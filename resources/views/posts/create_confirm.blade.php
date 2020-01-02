@extends('layouts.app')

@section('title', 'BLOG')

@section('leftsidebar')

  <form action="image_complete" method="post">
          @csrf
          <table border="1">
              <tr>{{var_dump('ss')}}
                  <td>画像</td>
                  <td><img src="{{ $data['read_temp_path'] }}" width="200" height="130"></td>
              </tr>
              <tr>
                  <td>商品名</td>
                  <td>{{ $data['product_name'] }}</td>
              </tr>
          </table>
          <input type="submit" name="action" value="送信" />
      </form>

@endsection
