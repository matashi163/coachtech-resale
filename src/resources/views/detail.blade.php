@extends('layouts.app')

@section('app_css')
<link rel="stylesheet" href="{{asset('css/detail.css')}}">
@endsection

@section('content')
<div class="detail__content">
    <div class="detail__group">
        <img src="{{Storage::url('product_images/' . $product->image)}}" alt="商品画像" class="detail__image">
    </div>
    <div class="detail__group">
        <div class="detail__information">
            <p class="detail__name">{{$product->name}}</p>
            <p class="detail__brand">
                {{$product->brand ?? ''}}
            </p>
            <div class="detail__price">
                <p class="detail__price--yen">¥</p>
                <p class="detail__price--price">{{number_format($product->price)}}</p>
                <p class="detail__price--tax">(税込)</p>
            </div>
            <div class="detail__counts">
                <div class="detail__count">
                    @if ($bookmarked)
                    <a href="/bookmark/delete/{{$product->id}}" class="detail__count--link">
                        <img src="{{Storage::url('icons/bookmark.png')}}" alt="お気に入り" class="detail__count--icon bookmarked">
                    </a>
                    @else
                    <a href="/bookmark/create/{{$product->id}}" class="detail__count--link">
                        <img src="{{Storage::url('icons/bookmark.png')}}" alt="お気に入り" class="detail__count--icon">
                    </a>
                    @endif
                    <p class="detail__count--bookmark">{{$bookmarkCount}}</p>
                </div>
                <div class="detail__count">
                    <a href="#comment" class="detail__count--link">
                        <img src="{{Storage::url('icons/comment.png')}}" alt="コメント" class="detail__count--icon">
                    </a>
                    <p class="detail__count--comment">{{$commentCount}}</p>
                </div>
            </div>
            <a href="/purchase/{{$product->id}}" class="detail__purchase">購入手続きへ</a>
            <div class="detail__description">
                <p class="detail__description--title">商品説明</p>
                <p class="detail__description--content">{{$product->description}}</p>
            </div>
            <div class="detail__status">
                <p class="detail__status--title">商品の情報</p>
                <div class="detail__category">
                    <p class="detail__status--lavel">カテゴリー</p>
                    <div class="detail__category--content">
                        @if ($product->category)
                        @foreach ($product->category as $category)
                        <p class="detail__category--item">{{$category}}</p>
                        @endforeach
                        @endif
                        <p class="detail__category--item">腕時計</p>
                        <p class="detail__category--item">メンズ</p>
                    </div>
                </div>
                <div class="detail__condision">
                    <p class="detail__status--lavel">商品の状態</p>
                    <p class="detail__condision--content">{{$product->condision->condision}}</p>
                </div>
            </div>
            <div id="comment" class="detail__comments">
                <p class="detail__comments--title">コメント({{$commentCount}})</p>
                @foreach($comments as $comment)
                <div class="comments__comment">
                    <div class="comment__user">
                        <img src="" alt="image" class="comment__user--image">
                        <p class="comment__user--name">名前</p>
                    </div>
                    <div class="comment__content">
                        {!!nl2br(e($comment->comment))!!}
                    </div>
                </div>
                @endforeach
                <form action="/comment" method="post" class="detail__comment-box">
                    @csrf
                    <p class="detail__comment-box--title">商品へのコメント</p>
                    <textarea name="comment" value="{{old('comment')}}" class="detail__comment-box--input"></textarea>
                    <p class="detail__comment-box--error">
                        @error('comment')
                        {{$errors->first('comment')}}
                        @enderror
                    </p>
                    <button name="product_id" value="{{$product->id}}" class="detail__comment-box--button">コメントを送信する</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection