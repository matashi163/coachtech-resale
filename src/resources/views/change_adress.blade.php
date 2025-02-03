@extends('layouts.app')

@section('app_css')
<link rel="stylesheet" href="{{asset('css/change_adress.css')}}">
@endsection

@section('content')
<div class="adress__content">
    <p class="adress__title">住所の変更</p>
    <form action="/purchase/change_adress" method="post" class="adress__form">
        @csrf
        <input type="hidden" name="item_id" value="{{$item_id}}">
        <div class="form__content">
            <div class="form__group">
                <p class="form__lavel">郵便番号</p>
                <input type="text" name="zip_code" class="form__input">
                <p class="form__error">
                    @error('zip_code')
                    {{$errors->first('zip_code')}}
                    @enderror
                </p>
            </div>
            <div class="form__group">
                <p class="form__lavel">住所</p>
                <input type="text" name="adress" class="form__input">
                <p class="form__error">
                    @error('adress')
                    {{$errors->first('adress')}}
                    @enderror
                </p>
            </div>
            <div class="form__group">
                <p class="form__lavel">建物名</p>
                <input type="text" name="building" class="form__input">
            </div>
        </div>
        <button class="form__button">更新する</button>
    </form>
</div>
@endsection