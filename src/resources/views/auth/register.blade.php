@extends('layouts.base')

@section('css')
<link rel="stylesheet" href="{{asset('css/auth.css')}}">
@endsection

@section('content')
<div class="auth__content">
    <h1 class="auth__title">会員登録</h1>
    <form action="/register" method="post" class="auth__form">
        @csrf
        <div class="form__content">
            <div class="form__group">
                <p class="form__lavel">ユーザー名</p>
                <input type="text" name="name" value="{{old('name')}}" class="form__input">
                <p class="form__error">
                    @error('name')
                        {{$errors->first('name')}}
                    @enderror
                </p>
            </div>
            <div class="form__group">
                <p class="form__lavel">メールアドレス</p>
                <input type="text" name="email" value="{{old('email')}}" class="form__input">
                <p class="form__error">
                    @error('email')
                        {{$errors->first('email')}}
                    @enderror
                </p>
            </div>
            <div class="form__group">
                <p class="form__lavel">パスワード</p>
                <input type="password" name="password" class="form__input">
                <p class="form__error">
                    @error('password')
                        {{$errors->first('password')}}
                    @enderror
                </p>
            </div>
            <div class="form__group">
                <p class="form__lavel">確認用パスワード</p>
                <input type="password" name="password_confirmation" class="form__input">
                <p class="form__error">
                    @error('password_confirmation')
                        {{$errors->first('password_confirmation')}}
                    @enderror
                </p>
            </div>
        </div>
        <button class="form__button">登録する</button>
    </form>
    <a href="/login" class="auth__transition">ログインはこちら</a>
</div>
@endsection
