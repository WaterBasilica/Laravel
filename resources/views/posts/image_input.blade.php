@extends('layouts.app')

@section('title', 'BLOG')

@section('leftsidebar')

  <form action="image_confirm" method="post" enctype="multipart/form-data" id="form">
        @csrf
        ファイル：
        <input type="file" name="imagefile" value=""/><br /><br />

        商品名：<br />
        <input type="text" name="product_name" size="50" value="{{ old('name') }}"/><br /><br />

        <input type="submit" name="confirm" id="button" value="確認" />
    </form>

    <script src="/js/main.js"></script>
@endsection
