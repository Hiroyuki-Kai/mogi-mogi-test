<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        $keyword = $request->query('keyword');
        if (!empty($keyword)) {
            $query->where('name', 'like', '%' . $keyword . '%');
        }

        $sort = $request->query('sort');
        if ($sort === 'high') {
            $query->orderBy('price', 'desc');
        } elseif ($sort === 'low') {
            $query->orderBy('price', 'asc');
        } else {
            $query->orderBy('id', 'desc');
        }

        $products = $query->paginate(6)->withQueryString();

        return view('products.index', [
            'products' => $products,
            'keyword' => $keyword,
            'sort' => $sort,
        ]);
    }

    public function search(Request $request)
    {
        return $this->index($request);
    }

    public function create()
    {
        $seasons = Season::orderBy('id')->get();
        return view('products.create', compact('seasons'));
    }

    public function store(ProductStoreRequest $request)
    {
        $data = $request->validated();

        $file = $request->file('image');
        $originalName = $file->getClientOriginalName();

        $path = $file->storeAs('images', $originalName, 'public');
        $data['image'] = $path;

        $seasonIds = $data['seasons'];
        unset($data['seasons']);

        $product = Product::create($data);
        $product->seasons()->sync($seasonIds);

        return redirect()->route('products.index');
    }

    public function show($productId)
    {
        $product = Product::with('seasons')->findOrFail($productId);
        $seasons = Season::all();
        $selectedSeasonIds = $product->seasons->pluck('id')->all();

        return view('products.show', compact('product', 'seasons', 'selectedSeasonIds'));
    }

    public function update(ProductUpdateRequest $request, $productId)
    {
        $data = $request->validated();
        $product = Product::findOrFail($productId);

        $seasonIds = $data['seasons'] ?? [];
        unset($data['seasons']);
        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $data['image'] = $path;
        } else {
            unset($data['image']);
        }

        $product->update($data);
        $product->seasons()->sync($seasonIds);

        return redirect()->route('products.index');
    }

    public function destroy($productId)
    {
        $product = Product::findOrFail($productId);

        if (!empty($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->seasons()->detach();
        $product->delete();

        return redirect()->route('products.index');
    }
}
