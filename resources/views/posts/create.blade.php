@extends('layouts.app')

@section('title', 'New Post')

@section('content')

    <h1>
      <a href="{{ url('/') }}" class="header-menu">戻る</a>
      新規投稿
    </h1>
    <form method="post" action="{{ url('/posts') }}" enctype="multipart/form-data" id="form">
  {{--  <form method="post" action="create_confirm" enctype="multipart/form-data">--}}
      {{ csrf_field() }}
      <p>
        <input type="text" name="title" placeholder="タイトルを入力してください" value="{{ old('title') }}">
        @if ($errors->has('title'))
        <span class="error">{{ $errors->first('title') }}</span>
        @endif
      </p>
      <p>
        <textarea name="body" placeholder="本文を入力してください">{{ old('body') }}</textarea>
        @if ($errors->has('body'))
        <span class="error">{{ $errors->first('body') }}</span>
        @endif
      </p>
      <p>画像添付：
      <input type="file" name="imagefile" value=""/>
        <input type="submit" value="投稿">
      </p>

    </form>
    {{--<form action="image_confirm" method="post" enctype="multipart/form-data" id="form">
          @csrf
          画像を添付する：
          <input type="file" name="imagefile" value=""/><br /><br />

          商品名：<br />
          <input type="text" name="product_name" size="50" value="{{ old('name') }}"/><br /><br />

          <input type="submit" name="confirm" id="button" value="確認" />
      </form>--}}
@endsection
