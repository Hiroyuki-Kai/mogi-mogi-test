@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="products-page">
  <div class="products-page__head">
    <h1 class="page-title">商品一覧</h1>

    <a class="add__btn" href="{{ route('products.create') }}">
      ＋ 商品を追加
    </a>
  </div>

  <div class="products-layout">
    <aside class="products-side">
      <form class="side-search" action="{{ route('products.search') }}" method="GET">
        <input
          class="form-input side-search__input"
          type="text"
          name="keyword"
          value="{{ $keyword ?? '' }}"
          placeholder="商品名で検索"
        >

        <button class="side-search__btn" type="submit">
          検索
        </button>

        <p class="side-search__label">価格順で表示</p>

        <select class="form-select side-search__select" name="sort">
          <option value="">価格で並び替え</option>
          <option value="high" @if(($sort ?? '')==='high') selected @endif>高い順に表示</option>
          <option value="low"  @if(($sort ?? '')==='low') selected @endif>低い順に表示</option>
        </select>

        @if(!empty($sort))
          <div class="side-search__reset">
            <span class="chip">
              {{ $sort === 'high' ? '高い順に表示' : '低い順に表示'}}
              <a class="chip__close"
                href="{{ route('products.index', ['keyword' => $keyword]) }}">
                ×
              </a>
            </span>
          </div>
        @endif
      </form>
    </aside>

    <section class="products-main">
      <div class="product-grid">
        @foreach ($products as $product)
          <a class="product-card" href="{{ route('products.show', $product->id) }}">
            <div class="product-card__img-wrap">
              <img
                  class="product-card__img"
                  src="{{ asset('storage/' . $product->image) }}"
                  alt="{{ $product->name }}"
              >
            </div>

            <div class="product-card__foot">
              <p class="product-card__name">{{ $product->name }}</p>
              <p class="product-card__price">¥{{ number_format($product->price) }}</p>
            </div>
          </a>
        @endforeach
      </div>

    <div class="pager">
      @if ($products->onFirstPage())
        <span class="pager__btn pager__btn--disabled">‹</span>
      @else
        <a class="pager__btn" href="{{ $products->previousPageUrl() }}">‹</a>
      @endif

      @for ($page = 1; $page <= $products->lastPage(); $page++)
        @if ($page == $products->currentPage())
          <span class="pager__page--active">{{ $page }}</span>
        @else
          <a class="pager__btn" href="{{ $products->url($page) }}">{{ $page }}</a>
        @endif
      @endfor

      @if ($products->hasMorePages())
        <a class="pager__btn" href="{{ $products->nextPageUrl() }}">›</a>
      @else
        <span class="pager__btn">›</span>
      @endif
    </div>
    </section>
  </div>
</div>
@endsection
