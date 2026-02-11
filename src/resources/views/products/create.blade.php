@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endsection

@section('content')
<div class="create">
	<div class="create__inner">
		<h1 class="create__title">商品登録</h1>
		<form class="create__form" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" novalidate>
		@csrf
			<div class="field">
				<label class="label">商品名 <span class="required">必須</span></label>
				<input class="input" type="text" name="name" value="{{ old('name') }}" placeholder="商品名を入力">
				@error('name') <p class="error">{{ $message }}</p> @enderror
			</div>

			<div class="field">
				<label class="label">価格 <span class="required">必須</span></label>
				<input class="input" type="number" name="price" placeholder="価格を入力" value="{{ old('price') }}">
				@error('price') <p class="error">{{ $message }}</p> @enderror
			</div>

			<div class="field">
				<label class="label">商品画像 <span class="required">必須</span></label>
				<input type="file" name="image">
				@error('image') <p class="error">{{ $message }}</p> @enderror
			</div>

			<div class="field">
				<label class="label">季節 
					<span class="required">必須</span>
					<span class="multiple">複数選択可</span>
				</label>

				<div class="season">
				@foreach ($seasons as $season)
					<label class="season__item">
					<input class="season__checkbox" type="checkbox" name="seasons[]" value="{{ $season->id }}"
						{{ in_array($season->id, old('seasons', [])) ? 'checked' : '' }}>
					<span class="season__custom"></span>
					<span>{{ $season->name }}</span>
					</label>
				@endforeach
				</div>
				@error('seasons') <p class="error">{{ $message }}</p> @enderror
			</div>

			<div class="field">
				<label class="label">商品説明 <span class="required">必須</span></label>
				<textarea class="textarea" name="description" placeholder="商品の説明を入力">{{ old('description') }}</textarea>
				@error('description') <p class="error">{{ $message }}</p> @enderror
			</div>

			<div class="actions">
				<a class="btn--back" href="{{ route('products.index') }}">戻る</a>
				<button class="btn--submit">登録</button>
			</div>

		</form>
	</div>
</div>
@endsection
