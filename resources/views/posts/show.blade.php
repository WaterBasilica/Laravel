@extends('layouts.app')

@section('title' ,'Show Post')

@section('leftsidebar')

@if($postflg==0)
<a class="newpost" href="{{ url('/posts/create') }}" class="header-menu">新規投稿</a>
<h1 class="postlist">
  投稿一覧
</h1>
@endif
<ul class="noneul">
  @forelse($posts as $post)
  <li><a class="post_name" href="{{ action('PostsController@show', [$post->id => $post->id]) }}">{{ $post->title }}</a>
  @if($postflg==0)
    <a href="{{ action('PostsController@edit', $post->id) }}" class="edit">[編集]</a>
    <a href="#" class="pdel" data-id="{{ $post->id }}">[削除]</a>
  @endif
    <form method="post" action="{{ url('/posts', $post->id) }}" id="pform_{{ $post->id }}">
      {{ csrf_field() }}
      {{ method_field('delete') }}
    </form>
  </li>
  @empty
  <li>投稿がありません</li>
  @endforelse
</ul>
@endsection

@section('content')
      <a href="{{ url('posts', $maxid) }}" class="header-menu">最後のページ</a>
      <a href="{{ url('posts', $nextPost->id) }}" class="header-menu nextTitle">{{ $nextTitle }}</a>
      <a href="{{ url('posts', $prevPost->id) }}" class="header-menu nextTitle">{{ $prevTitle }}</a>
      <a href="{{ url('posts', $minid) }}" class="header-menu">最初のページ</a>
      <a href="{{ url('/','fromclick') }}" class="header-menu">Back</a>
    <h1>
      {{ $article->title }}
    </h1>
    <p class="date">{{ $date }}</p>
    <p>{!! nl2br(e($article->body)) !!}</p>
    <img class="postimg" src="{{nl2br(url($article->imageurl))}}" alt="画像なし">
    <h2 class="com-t">コメント</h2>
  <ul>
    @forelse($comments as $post)
    @if(count($post->comments)!=0)
    @forelse($post->comments as $comment)
    <li class="com">
      {{ $comment->body }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      {{ $comment->username }}さん
      @if(Auth::user())
      @if($comment->user_id==Auth::user()->id)
      <a href="#" class="cdel" data-id="{{ $comment->id }}">[削除]</a>
      <form method="post" action="{{ action('CommentsController@destroy', [$post,$comment]) }}" id="cform_{{ $comment->id }}">
        {{ csrf_field() }}
        {{ method_field('delete') }}
      </form>
      @endif
      @endif
    </li>
    @empty
    @endforelse
    @endif
    @empty
    <li class="com">コメントはありません</li>
    @endforelse

  </ul>
  <form method="post" action="{{ action('CommentsController@store', $article) }}">
    {{ csrf_field() }}
    <p>
      <input type="text" name="body" placeholder="コメントを入力してください" value="{{ old('body') }}">
      @if ($errors->has('title'))
      <span class="error">{{ $errors->first('title') }}</span>
      @endif
    </p>
  @if(Auth::user())
    <p>
      <input type="submit" value="コメント投稿">
    </p>
  @else
    <p>
      コメントを投稿するにはログインしてください。
    </p>
  @endif
  </form>

  この記事のいいね数&nbsp;<span class="goodcounts">{{ $article->goodcounts }}</span>
  @if(Auth::user())
  <a href="#" class="goodbtn" >いいね</a>
  <form method="post" action="{{ action('PostsController@storeGoodCounts', $post) }}" id="goodbtn">
    {{ csrf_field() }}

  </form>
  この記事のいいね数&nbsp;<span class="goodcounts">{{ $goodCounts }}</span>
  @if($goodExistsFlg==0)
　<a href="#" class="goodbtn2" ><button>いいね</button></a>
  @else
  <a href="#" class="goodbtn2" ><button>いいね済み</button></a>
  @endif
  <form method="post" action="{{ url('/posts/' . $article->id . '/like') }}" id="goodbtn2">
    {{ csrf_field() }}

  </form>
  @else
  いいねするにはログインしてください。
  @endif
@endsection

@section('prfRightBox')
<div id="prfBox">
<div id="prfTitle">プロフィール</div>
<div id="prfLink" class="clearFix">
<div id="prfImg"><a href="#"><img src="" alt="" width="85" height="92" style="padding-top:0px" /></a></div>
<div id="prfRightBox">
<div id="nickName">名前：<a href="#">{{ $user_name }}</a></div>
@if($profile_sentence!=null)
<p class="profile_sentence">{{ $profile_sentence }}</p>
@endif
<div id="prfLinkList">
<p class="prfLinkItem"><a href="#">プロフィール</a></p>
</div><!-- id="prfLinkList" -->
</div><!-- id="prfRightBox" -->
</div>
</div><!-- id="prfBox" -->
@endsection


{{--
@section('allarticlestitle')
<span class="box-title">全記事一覧</span>
@endsection


@section('allarticles')
  <table  class="alltable">
    <tr>
  @forelse($allPosts as $post)
    <td><a href="{{ action('PostsController@show', [$post->id => $post->id]) }}">{{ $post->title }}</a></td>
      <td><a href="{{ action('PostsController@show', $post) }}">{{ $post->body }}</a></td>
    <form method="post" action="{{ url('/posts', $post->id) }}" id="pform_{{ $post->id }}">
      {{ csrf_field() }}
      {{ method_field('delete') }}
    </form>
     </tr>
   @empty
    投稿がありません
   @endforelse

 </table>
@endsection
--}}
