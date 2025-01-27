@extends('layouts.base')

@section('css')
<link rel="stylesheet" href="{{asset('css/app.css')}}">
@yield('app_css')
@endsection

@section('header')
<div class="header__content">
    <form action="/search" method="post" class="header__search">
        @csrf
        <input type="text" name="search" placeholder="なにをお探しですか？" class="search__input">
    </form>
    <div class="header__buttons">
        @if(auth()->check())
        <form action="/logout" method="post">
            @csrf
            <button class="header__auth header__button">ログアウト</button>
        </form>
        @else
        <a href="/login" class="header__auth header__button">ログイン</a>
        @endif
        <a href="" class="header__mypage header__button">マイページ</a>
        <a href="" class="header__listing header__button">出品</a>
    </div>
</div>
@endsection