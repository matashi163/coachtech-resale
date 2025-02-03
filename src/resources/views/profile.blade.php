@extends('layouts.app')

@section('app_css')
<link rel="stylesheet" href="{{asset('css/profile')}}">
@endsection

@section('content')
<div class="profile__content">
    <p class="profile__title">プロフィール設定</p>
    <form action="/" class="profile__form"></form>
</div>
@endsection