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
            </div>
        </div>
        <div class="sell__group">
            <p class="sell__group--title">商品の詳細</p>
            <div class="sell__item">
                <p class="sell__label">カテゴリー</p>
                <div class="category__input">
                    @foreach($categories as $category)
                    <div class="category__item">
                        <input type="checkbox" name="category[]" value="{{$category->id}}" id="category_{{$category->id}}" class="category__checkbox">
                        <label for="category_{{$category->id}}" class="category__label">{{$category->category}}</label>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="sell__item">
                <p class="sell__label">商品の状態</p>
                <select name="condision" class="condision__input">
                    <option disabled selected hidden>選択してください</option>
                    @foreach($condisions as $condision)
                    <option value="{{$condision->id}}">{{$condision->condision}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="sell__group">
            <p class="sell__group--title">商品名と説明</p>
            <div class="sell__item">
                <p class="sell__label">商品名</p>
                <input type="text" name="name" class="name__input">
            </div>
            <div class="sell__item">
                <p class="sell__label">ブランド名</p>
                <input type="text" name="brand" class="brand__input">
            </div>
            <div class="sell__item">
                <p class="sell__label">商品の説明</p>
                <textarea name="description" class="description__input"></textarea>
            </div>
            <div class="sell__item">
                <p class="sell__label">販売価格</p>
                <div class="price__input--wrapper">
                    <input type="text" name="price" class="price__input">
                </div>
            </div>
        </div>
        <button class="sell__button">出品する</button>
    </form>
</div>
@endsection