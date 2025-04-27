@extends('layouts.app')

@section('app_css')
<link rel="stylesheet" href="{{asset('css/mypage.css')}}">
@endsection

@section('content')
<div class="mypage__content">
    <div class="mypage__user">
        <div class="user__information">
            <img src="{{Storage::url('user_icons/' . $user['image'])}}" alt=" " class="user__icon">
            <div class="user__information--group">
                <p class="user__name">{{$user['name']}}</p>
                <div class="user__rate">
                    <input type="hidden" id="rate" data-value="{{$user['rate']}}">
                    <svg class="user__rate--star" data-value="1" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                        <path d="M12 .587l3.668 7.568L24 9.75l-6 5.85L19.336 24 12 20.25 4.664 24 6 15.6 0 9.75l8.332-1.595z" />
                    </svg>
                    <svg class="user__rate--star" data-value="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                        <path d="M12 .587l3.668 7.568L24 9.75l-6 5.85L19.336 24 12 20.25 4.664 24 6 15.6 0 9.75l8.332-1.595z" />
                    </svg>
                    <svg class="user__rate--star" data-value="3" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                        <path d="M12 .587l3.668 7.568L24 9.75l-6 5.85L19.336 24 12 20.25 4.664 24 6 15.6 0 9.75l8.332-1.595z" />
                    </svg>
                    <svg class="user__rate--star" data-value="4" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                        <path d="M12 .587l3.668 7.568L24 9.75l-6 5.85L19.336 24 12 20.25 4.664 24 6 15.6 0 9.75l8.332-1.595z" />
                    </svg>
                    <svg class="user__rate--star" data-value="5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                        <path d="M12 .587l3.668 7.568L24 9.75l-6 5.85L19.336 24 12 20.25 4.664 24 6 15.6 0 9.75l8.332-1.595z" />
                    </svg>
                </div>
            </div>
        </div>
        <a href="/mypage/profile" class="user__button">プロフィールを編集</a>
    </div>
    <div class="mypage__product">
        <div class="product__tabs">
            <a href="?page=sell" class="product__tab {{$pageCheck === 'sell' ? 'product__tab--active' : ''}}">出品した商品</a>
            <a href="?page=buy" class="product__tab {{$pageCheck === 'buy' ? 'product__tab--active' : ''}}">購入した商品</a>
            <a href="?page=trading" class="product__tab {{$pageCheck === 'trading' ? 'product__tab--active' : ''}}">
                <p>取引中の商品</p>
                @if($messageCount != 0)
                <p class="product__message-count">{{$messageCount}}</p>
                @endif
            </a>
        </div>
        <div class="product__cards">
            @if($products && $pageCheck !== 'trading')
            @foreach($products as $product)
            <div class="product__card">
                <img src="{{Storage::url('product_images/' . $product->image)}}" alt="商品画像" class="card__image">
                <p class="card__name">{{$product->name}}</p>
            </div>
            @endforeach
            @elseif($products && $pageCheck === 'trading')
            @foreach($products as $product)
            <a href="/trading/{{$product->id}}" class="product__card">
                <img src="{{Storage::url('product_images/' . $product->image)}}" alt="商品画像" class="card__image">
                <p class="card__name">{{$product->name}}</p>
                @if($messageCountDatas[$product->id] != 0)
                <p class="card__message-count">{{$messageCountDatas[$product->id]}}</p>
                @endif
            </a>
            @endforeach
            @endif
        </div>
    </div>
</div>

<script>
    const stars = document.querySelectorAll('.user__rate--star');
    const value = document.getElementById('rate').dataset.value;

    stars.forEach(s => {
        const sValue = Number(s.getAttribute('data-value'));
        if (sValue <= value) {
            s.classList.add('active');
        } else {
            s.classList.remove('active');
        }
    });
</script>
@endsection