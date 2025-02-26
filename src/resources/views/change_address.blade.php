@extends('layouts.app')

@section('app_css')
<link rel="stylesheet" href="{{asset('css/change_address.css')}}">
@endsection

@section('content')
<div class="address__content">
    <h1 class="address__title">住所の変更</h1>
    <form action="/purchase/change_address" method="post" class="address__form">
        @csrf
        <input type="hidden" name="item_id" value="{{$item_id}}">
        <div class="form__content">
            <div class="form__group">
                <p class="form__lavel">郵便番号</p>
                <input type="text" name="zip_code" value="{{$zipCode}}" class="form__input">
                <p class="form__error">
                    @error('zip_code')
                    {{$errors->first('zip_code')}}
                    @enderror
                </p>
            </div>
            <div class="form__group">
                <p class="form__lavel">住所</p>
                <input type="text" name="address" value="{{$address}}" class="form__input">
                <p class="form__error">
                    @error('address')
                    {{$errors->first('address')}}
                    @enderror
                </p>
            </div>
            <div class="form__group">
                <p class="form__lavel">建物名</p>
                <input type="text" name="building" value="{{$building}}" class="form__input">
            </div>
        </div>
        <button class="form__button">更新する</button>
    </form>
</div>
@endsection