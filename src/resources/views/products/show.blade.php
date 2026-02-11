@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')
<div class="show-head">
  <a class="link" href="{{ route('products.index') }}">商品一覧</a>
  <span class="show-head__separator">></span>
  <span class="show-head__current">{{ $product->name }}</span>
</div>

<div class="show-card">
  <form id="product-form" class="show-form"
        action="{{ route('products.update', $product->id) }}"
        method="POST" enctype="multipart/form-data" novalidate>
    @csrf
    @method('PUT')

    <div class="show-form__top">

      <div class="show-card__left">
        <img class="show-card__img" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">

        <div class="product-edit__image-upload">
          <input type="file" name="image" id="image" class="product-edit__file-input" accept="image/*">
          <label class="product-edit__file-button" for="image">ファイルを選択</label>

          <span class="product-edit__filename">
            @if($product->image)
              {{ basename($product->image) }}
            @else
              選択されていません
            @endif
          </span>
        </div>
        @error('image')
            <p class="error">{{ $message }}</p>
        @enderror
      </div>

      <div class="show-card__right">

        <div class="show-form__group">
          <label class="form-label" for="name">商品名</label>
          <input class="form-input" id="name" name="name" type="text"
                 value="{{ old('name', $product->name) }}">
        </div>
        @error('name')
            <p class="error">{{ $message }}</p>
        @enderror

        <div class="show-form__group">
          <label class="form-label" for="price">値段</label>
          <input class="form-input" id="price" name="price" type="text"
                 value="{{ old('price', $product->price) }}">
        </div>
        @error('price')
            <p class="error">{{ $message }}</p>
        @enderror

        <div class="show-form__group">
          <p class="form-label">季節</p>
          <div class="check-grid">
            @foreach ($seasons as $season)
              <label class="check">
                <input class="check__input" type="checkbox" name="seasons[]"
                       value="{{ $season->id }}"
                       @if(in_array($season->id, old('seasons', $selectedSeasonIds))) checked @endif>
                <span class="check__text">{{ $season->name }}</span>
              </label>
            @endforeach
          </div>
            @error('seasons')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

      </div>
    </div>

    <div class="show-form__bottom">
      <div class="show-form__group">
        <label class="form-label" for="description">商品説明</label>
        <textarea class="form-textarea show-form__textarea"
                  id="description" name="description" rows="4">{{ old('description', $product->description) }}</textarea>
      </div>
        @error('description')
            <p class="error">{{ $message }}</p>
        @enderror

      <div class="show-form__actions">
        <a class="show__btn-back" href="{{ route('products.index') }}">戻る</a>
        <button class="show__btn-submit" type="submit">変更を保存</button>
      </div>
    </div>
  </form>

  <form class="show-form__delete"
        action="{{ route('products.destroy', $product->id) }}"
        method="POST">
    @csrf
    @method('DELETE')
    <button class="btn btn-danger" type="submit" aria-label="削除">🗑</button>
  </form>

</div>
@endsection
