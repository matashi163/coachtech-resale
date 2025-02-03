@extends('layouts.app')

@section('app_css')
<link rel="stylesheet" href="{{asset('css/purchase.css')}}">
@endsection

@section('content')
<div class="purchase__content">
    <div class="purchase__information">
        <div class="purchase__group purchase__product">
            <img src="{{Storage::url('product_images/' . $product->image)}}" alt="商品画像" class="product__image">
            <div class="product__information">
                <p class="product__name">{{$product->name}}</p>
                <div class="product__price">
                    <p class="product__price--yen">¥</p>
                    <p class="product__price--price">{{number_format($product->price)}}</p>
                </div>
            </div>
        </div>
        <div class="purchase__group purchase__payment-method">
            <p class="group__title">支払い方法</p>
            <select name="payment_method" id="payment_method" onchange="changePaymentMethod()" class="payment-method__select">
                <option value="" disabled selected hidden>選択してください</option>
                <option value="コンビニ払い">コンビニ払い</option>
                <option value="カード払い">カード払い</option>
            </select>
        </div>
        <div class="purchase__group purchase__adress">
            <div class="adress__content">
                <p class="group__title">配送先</p>
                <div class="adress__display">
                    <p class="adress__zip-code">〒{{$zipCode ?? 'XXX-YYYY'}}</p>
                    <p class="adress__text">{{$adress ?? 'ここには住所と建物が入ります'}}</p>
                </div>
            </div>
            <a href="/purchase/adress/{{$product->id}}" class="adress__change">変更する</a>
        </div>
    </div>
    <div class="purchase__payment">
        <div class="payment__information">
            <div class="payment__price">
                <p class="payment__lavel">商品代金</p>
                <div class="payment__price--content">
                    <p class="payment__price--yen">¥</p>
                    <p class="payment__price--price">{{number_format($product->price)}}</p>
                </div>
            </div>
            <div class="payment__method">
                <p class="payment__lavel">支払い方法</p>
                <p id="paymentMethodDisplay" class="payment__method--content"></p>
            </div>
        </div>
        <a href="/purchase/?product_id={{$product->id}}&user_id={{auth()->id()}}" class="purchase__button">購入する</a>
    </div>
</div>

<script>
    function changePaymentMethod() {
        let paymentMethod = document.getElementById("payment_method").value;
        document.getElementById("paymentMethodDisplay").innerText = paymentMethod;
    }
</script>
@endsection