@extends('layouts.app')

@section('app_css')
<link rel="stylesheet" href="{{asset('css/mypage.css')}}">
@endsection

@section('content')
<div class="mypage__content">
    <div class="mypage__user">
        <div class="user__information">
            <img src="{{Storage::url('user_icons/' . $user['image'])}}" alt=" " class="user__icon">
            <p class="user__name">{{$user['name']}}</p>
        </div>
        <a href="/mypage/profile" class="user__button">プロフィールを編集</a>
    </div>
    <div class="mypage__product">
        <div class="product__tabs">
            <a href="?page=listed" class="product__tab {{$pageCheck === 'listed' ? 'product__tab--active' : ''}}">出品した商品</a>
            <a href="?page=purchased" class="product__tab {{$pageCheck === 'purchased' ? 'product__tab--active' : ''}}">購入した商品</a>
        </div>
        <div class="product__cards">
            @if($products)
            @foreach($products as $product)
            <div class="product__card">
                <img src="{{Storage::url('product_images/' . $product->image)}}" alt="商品画像" class="card__image">
                <p class="card__name">{{$product->name}}</p>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>
@endsection