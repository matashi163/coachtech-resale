@extends('layouts.app')

@section('app_css')
<link rel="stylesheet" href="{{asset('css/profile.css')}}">
@endsection

@section('content')
<div class="profile__content">
    <h1 class="profile__title">プロフィール設定</h1>
    <form action="{{$route}}" method="post" enctype="multipart/form-data" class="profile__form">
        @csrf
        <div class="profile__user-icon">
            <img src="{{isset($profile['image']) ? Storage::url('user_icons/' . $profile['image']) : ''}}" alt=" " class="user-icon__image">
            <label for="userIcon" class="user-icon__button">画像を選択する</label>
            <input type="file" accept="image/*" name="image" id="userIcon" class="user-icon__input">
        </div>
        <p class="profile__error">
            @error('image')
            {{$errors->first('image')}}
            @enderror
        </p>
        <div class="profile__group">
            <p class="profile__label">ユーザー名</p>
            <input type="text" name="name" value="{{$profile['name'] ?? old('name')}}" class="profile__input">
            <p class="profile__error">
                @error('name')
                {{$errors->first('name')}}
                @enderror
            </p>
        </div>
        <div class="profile__group">
            <p class="profile__label">郵便番号</p>
            <input type="text" name="zip_code" value="{{$profile['zip_code'] ?? old('zip_code')}}" class="profile__input">
            <p class="profile__error">
                @error('zip_code')
                {{$errors->first('zip_code')}}
                @enderror
            </p>
        </div>
        <div class="profile__group">
            <p class="profile__label">住所</p>
            <input type="text" name="address" value="{{$profile['address'] ?? old('address')}}" class="profile__input">
            <p class="profile__error">
                @error('address')
                {{$errors->first('address')}}
                @enderror
            </p>
        </div>
        <div class="profile__group">
            <p class="profile__label">建物名</p>
            <input type="text" name="building" value="{{$profile['building'] ?? old('building')}}" class="profile__input">
            <p class="profile__error">
                @error('building')
                {{$errors->first('building')}}
                @enderror
            </p>
        </div>
        <button class="profile__button">更新する</button>
    </form>
</div>
@endsection