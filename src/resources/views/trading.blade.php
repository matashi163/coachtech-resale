@extends('layouts.app')

@section('app_css')
<link rel="stylesheet" href="{{asset('css/trading.css')}}">
@endsection

@section('content')
<div class="trading__content">
    <div class="other-list">
        <p class="other-list__header">その他の取引</p>
        <div class="other-list__items">
            @foreach($products as $product)
            @if($product->id != $productData['product_id'])
            <a href="/trading/{{$product->id}}" class="other-list__item">{{$product->name}}</a>
            @endif
            @endforeach
        </div>
    </div>
    <div class="other-list--block"></div>
    <div class="trading">
        <div class="trading__info">
            <div class="trading__header">
                <div class="header__title">
                    <img src="{{Storage::url('user_icons/' . $productData['partner_icon'])}}" alt="相手" class="header__icon">
                    <p class="header__text">{{$productData['partner_name']}}さんとの取引画面</p>
                </div>
                @if($productData['position'] == 'buying_user' && $productData['completion'] == false)
                <a href="/trading/completion/{{$productData['product_id']}}" class="trading__button">取引を完了する</a>
                @endif
            </div>
            <div class="trading__product">
                <img src="{{Storage::url('product_images/' . $productData['product_image'])}}" alt="商品名" class="product__image">
                <div class="product__detail">
                    <p class="product__name">{{$productData['product_name']}}</p>
                    <p class="product__price">¥{{number_format($productData['product_price'])}}</p>
                </div>
            </div>
        </div>
        <div class="trading__chat">
            <div class="chat__content">
                @foreach($chats as $chat)
                @if($chat->user->id == $productData['oneself_id'])
                <div class="chat__group chat__oneself">
                    <div class="chat__user">
                        <img src="{{Storage::url('user_icons/' . $productData['oneself_icon'])}}" alt="自分" class="chat__icon">
                        <p class="chat__name">{{$productData['oneself_name']}}</p>
                    </div>
                    @if($chat->image)
                    <img src="{{Storage::url('chat_images/' . $chat->image)}}" alt="画像" class="chat__image">
                    @endif
                    <p class="chat__text">{{$chat->text}}</p>
                    <div class="chat__buttons">
                        <button data-id="{{$chat->id}}" data-text="{{$chat->text}}" class="chat__button chat__button--correct">編集</button>
                        <a href="/trading/chat/delete/{{$chat->id}}" class="chat__button">削除</a>
                    </div>
                </div>
                @elseif($chat->user->id == $productData['partner_id'])
                <div class="chat__group chat__partner">
                    <div class="chat__user">
                        <img src="{{Storage::url('user_icons/' . $productData['partner_icon'])}}" alt="相手" class="chat__icon">
                        <p class="chat__name">{{$productData['partner_name']}}</p>
                    </div>
                    @if($chat->image)
                    <img src="{{Storage::url('chat_images/' . $chat->image)}}" alt="画像" class="chat__image">
                    @endif
                    <p class="chat__text">{{$chat->text}}</p>
                </div>
                @endif
                @endforeach
            </div>
            <div class="chat__form">
                <p class="form__error">
                    @if ($errors->any())
                    {{$errors->first()}}
                    @endif
                </p>
                <form action="/trading/chat/{{$productData['product_id']}}" method="post" enctype="multipart/form-data" class="form__content">
                    @csrf
                    <input type="text" name="text" value="{{old('text')}}" placeholder="取引メッセージを記入してください" class="form__text">
                    <div class="form__image">
                        <input type="file" id="image" name="image" class="form__image--input">
                        <label for="image" class="form__image--label">画像を追加</label>
                    </div>
                    <button class="form__button">
                        <img src="{{Storage::url('icons/submit.jpg')}}" alt="送信" class="form__button--icon">
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div id="modal" class="modal {{$productData['completion'] ? 'modal__active' : ''}}">
        <p class="modal__text">取引が完了しました。</p>
        <div class="modal__rate">
            <p class="modal__rate--text">今回の取引相手はどうでしたか？</p>
            <div class="modal__stars">
                <svg class="modal__star" data-value="1" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                    <path d="M12 .587l3.668 7.568L24 9.75l-6 5.85L19.336 24 12 20.25 4.664 24 6 15.6 0 9.75l8.332-1.595z" />
                </svg>
                <svg class="modal__star" data-value="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                    <path d="M12 .587l3.668 7.568L24 9.75l-6 5.85L19.336 24 12 20.25 4.664 24 6 15.6 0 9.75l8.332-1.595z" />
                </svg>
                <svg class="modal__star" data-value="3" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                    <path d="M12 .587l3.668 7.568L24 9.75l-6 5.85L19.336 24 12 20.25 4.664 24 6 15.6 0 9.75l8.332-1.595z" />
                </svg>
                <svg class="modal__star" data-value="4" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                    <path d="M12 .587l3.668 7.568L24 9.75l-6 5.85L19.336 24 12 20.25 4.664 24 6 15.6 0 9.75l8.332-1.595z" />
                </svg>
                <svg class="modal__star" data-value="5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                    <path d="M12 .587l3.668 7.568L24 9.75l-6 5.85L19.336 24 12 20.25 4.664 24 6 15.6 0 9.75l8.332-1.595z" />
                </svg>
            </div>
        </div>
        <form action="/trading/rate/{{$productData['product_id']}}" method="post" class="modal__form">
            @csrf
            <input type="hidden" name="rate" id="rate" value="">
            <button class="modal__button">送信する</button>
        </form>
    </div>
    <form action="/trading/chat/correct" method="post" id="correct" class="chat__correct chat__correct--hidden">
        @csrf
        <a href="" class="chat__correct--cansel"></a>
        <div class="chat__correct--content">
            <input type="hidden" name="id" id="chatIdInput">
            <input type="text" name="text" id="chatTextInput" class="chat__correct--input">
            <button class="chat__correct--button">編集</button>
        </div>
    </form>
</div>

<script>
    window.addEventListener('load', function() {
        window.scrollTo(0, document.body.scrollHeight);
    });

    const stars = document.querySelectorAll('.modal__star');
    const rateInput = document.getElementById('rate');

    stars.forEach(star => {
        star.addEventListener('click', function() {
            const value = Number(this.getAttribute('data-value'));
            rateInput.value = value;

            stars.forEach(s => {
                const sValue = Number(s.getAttribute('data-value'));
                if (sValue <= value) {
                    s.classList.add('active');
                } else {
                    s.classList.remove('active');
                }
            });
        });
    });

    document.querySelectorAll('.chat__button--correct').forEach(function(button) {
        button.addEventListener('click', function() {
            const chatId = this.getAttribute('data-id');
            const chatText = this.getAttribute('data-text');

            document.getElementById('chatIdInput').value = chatId;
            document.getElementById('chatTextInput').value = chatText;
            document.getElementById('correct').classList.remove('chat__correct--hidden');
        });
    });
</script>
@endsection