@extends('layouts.app')

@section('title', 'BLOG')
@section('leftsidebar')
@if(Auth::user())
<a class="newpost" href="{{ url('/posts/create') }}" class="header-menu">新規投稿</a>
@endif
{{--
 @if(isset($comments))
  <h2 class="com-t">コメント</h2>
  <ul>
  @forelse($comments as $comment)
  <li class="com">
    {{ $comment->body }}
    <a href="#" class="cdel" data-id="{{ $comment->id }}">[削除]</a>
    <form method="post" action="{{ action('CommentsController@destroy', [$comment, $comment->comments]) }}" id="cform_{{ $comment->id }}">
      {{ csrf_field() }}
      {{ method_field('delete') }}
    </form>
  </li>
  @empty
    <li class="com">コメントはありません</li>
  @endforelse
  @endif
  </ul>

   @if(isset($latestp))
  <form method="post" action="{{ action('CommentsController@store', $latestp) }}">
  {{ csrf_field() }}
  <p>
    <input type="text" name="body" placeholder="コメントを入力してください" value="{{ old('body') }}">
    @if ($errors->has('title'))
    <span class="error">{{ $errors->first('title') }}</span>
    @endif
  </p>

  <p>
    <input type="submit" value="コメント投稿">
  </p>
  </form>
  @endif--}}
  <!-- <img src="storage/img/public/productimage/Uy2qcdTIOGYirmRZ8GLsHFjVxtq5AtAHk93eNtB7.jpeg" alt="img"> -->
  <!-- <img src="{{ asset('images/sample01.jpg') }}" alt="img"> -->

@endsection

@if($deleteAccountFlg == 1)
<p id="delete_complete_message" class="delete_complete_message">アカウントが削除されました。</p>
@endif
@section('allarticlestitle')

<span class="box-title">全記事一覧</span>
@endsection


@section('allarticles')
  <table  class="alltable">
    <tr>
      <td class="title">タイトル
      </td>
      <td class="cont">内容
      </td>
      <td class="author">名前
      </td>
      <td class="tdgoodcounts">いいね数
      </td>
      <td class="tdgoodcounts">いいね数2
      </td>
    </tr>
    <tr>
  @if($allPosts!=null)
  @forelse($allPosts as $post)
    <td ><a class="conttitle" href="{{ action('PostsController@show', $post->id) }}">{{ $post->title }}</a></td>
      <td class="contcont"><a href="{{ action('PostsController@show', $post->id) }}">{{ $post->body }}</a></td>
      <td class="contname">{{ $post->name }}さん</td>
      <td class="indexgoodcounts">{{ $post->goodcounts }}</td>
    {{--<td class="indexgoodcounts">{{ $goodCounts }}</td>--}}
    <form method="post" action="{{ url('/posts', $post->id) }}" id="pform_{{ $post->id }}">
      <input type="hidden" name="userid" value="{{ $post->userid }}">
      {{ csrf_field() }}
      {{ method_field('delete') }}
    </form>
     </tr>
   @empty
    <td>投稿がありません</td>
   @endforelse
   @else
    <td>投稿がありません</td>
   @endif
 </table>
@endsection
