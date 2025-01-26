@extends('layouts.app')

@section('app_css')
<link rel="stylesheet" href="{{asset('css/list.css')}}">
@endsection

@section('content')
<div class="list__content">
    <div class="list__tabs">
        <a href="/" class="list__tab {{$pageCheck === null ? 'list__tab--active' : ''}}">おすすめ</a>
        <a href="/?page=my_list" class="list__tab {{$pageCheck === null ? '' : 'list__tab--active'}}">マイリスト</a>
    </div>
    <div class="list__cards">
        @if($products)
        @foreach($products as $product)
        <a href="/item/{{$product->id}}" class="list__card {{$product->buying_user_id !== null ? 'list__card--non-active' : ''}}">
            <div class="card__image">
                <img src="{{Storage::url('product_images/' . $product->image)}}" alt="商品画像" class="card__image--image">
                @if ($product->buying_user_id)
                <div class="card__image--sold">Sold</div>
                @endif
            </div>
            <p class="card__name">{{$product->name}}</p>
        </a>
        @endforeach
        @endif
    </div>
</div>
@endsection