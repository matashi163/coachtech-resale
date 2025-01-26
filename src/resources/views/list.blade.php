@extends('layouts.app')

@section('app_css')
<link rel="stylesheet" href="{{asset('css/list.css')}}">
@endsection

@section('content')
<div class="list__content">
    <div class="list__tabs">
        <a href="/" class="list__tab">おすすめ</a>
        <a href="/?page=my_list" class="list__tab">マイリスト</a>
    </div>
    <div class="list__cards">
        @if($products)
        @foreach($products as $product)
        <a href="/item/{{$product->id}}" class="list__card">
            <img src="{{Storage::url('product_images/' . $product->image)}}" alt="商品画像" class="card__image">
            <p class="card__name">{{$product->name}}</p>
        </a>
        @endforeach
        @endif
    </div>
</div>
@endsection