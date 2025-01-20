@extends('layouts.app')

@section('app_css')
<link rel="stylesheet" href="{{asset('css/index.css')}}">
@endsection

@section('content')
<div class="product-list__content">
    <div class="product-list__tabs">
        <a href="/" class="product-list__tab">おすすめ</a>
        <a href="/?page=mylist" class="product-list__tab">マイリスト</a>
    </div>
</div>
@endsection