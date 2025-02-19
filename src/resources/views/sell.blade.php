@extends('layouts.app')

@section('app_css')
<link rel="stylesheet" href="{{asset('css/sell.css')}}">
@endsection

@section('content')
<div class="sell__content">
    <h1 class="sell__title">商品の出品</h1>
    <form action="/sell" method="post" enctype="multipart/form-data" class="sell__form">
        @csrf
        <div class="sell__group">
            <div class="sell__item">
                <p class="sell__label">商品画像</p>
                <input type="file" name="image" id="image" class="image__input">
                <div class="image__group">
                    <img src="" alt=" " class="image__image">
                    <label for="image" class="image__label">画像を選択する</label>
                </div>
                <p class="sell__error">
                    @error('image')
                    {{$errors->first('image')}}
                    @enderror
                </p>
            </div>
        </div>
        <div class="sell__group">
            <p class="sell__group--title">商品の詳細</p>
            <div class="sell__item">
                <p class="sell__label">カテゴリー</p>
                <div class="category__input">
                    @foreach($categories as $category)
                    <div class="category__item">
                        <input type="checkbox" name="category[]" value="{{$category->id}}" id="category_{{$category->id}}" class="category__checkbox" {{in_array($category->id, old('category', [])) ? 'checked' : ''}}>
                        <label for="category_{{$category->id}}" class="category__label">{{$category->category}}</label>
                    </div>
                    @endforeach
                </div>
                <p class="sell__error">
                    @error('category')
                    {{$errors->first('category')}}
                    @enderror
                </p>
            </div>
            <div class="sell__item">
                <p class="sell__label">商品の状態</p>
                <select name="condision" class="condision__input">
                    <option disabled selected hidden>選択してください</option>
                    @foreach($condisions as $condision)
                    <option value="{{$condision->id}}" {{old('condision') == $condision->id ? 'selected' : ''}}>{{$condision->condision}}</option>
                    @endforeach
                </select>
                <p class="sell__error">
                    @error('condision')
                    {{$errors->first('condision')}}
                    @enderror
                </p>
            </div>
        </div>
        <div class="sell__group">
            <p class="sell__group--title">商品名と説明</p>
            <div class="sell__item">
                <p class="sell__label">商品名</p>
                <input type="text" name="name" value="{{old('name')}}" class="name__input">
                <p class="sell__error">
                    @error('name')
                    {{$errors->first('name')}}
                    @enderror
                </p>
            </div>
            <div class="sell__item">
                <p class="sell__label">ブランド名</p>
                <input type="text" name="brand" value="{{old('brand')}}" class="brand__input">
                <p class="sell__error">
                    @error('brand')
                    {{$errors->first('brand')}}
                    @enderror
                </p>
            </div>
            <div class="sell__item">
                <p class="sell__label">商品の説明</p>
                <textarea name="description" class="description__input">{{old('description')}}</textarea>
                <p class="sell__error">
                    @error('description')
                    {{$errors->first('description')}}
                    @enderror
                </p>
            </div>
            <div class="sell__item">
                <p class="sell__label">販売価格</p>
                <div class="price__input--wrapper">
                    <input type="text" name="price" value="{{old('price')}}" class="price__input">
                </div>
                <p class="sell__error">
                    @error('price')
                    {{$errors->first('price')}}
                    @enderror
                </p>
            </div>
        </div>
        <button class="sell__button">出品する</button>
    </form>
</div>
@endsection