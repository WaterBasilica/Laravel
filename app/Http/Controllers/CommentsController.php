<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Comment;
use App\User;
use Auth;
use Illuminate\Support\Facades\DB;

class CommentsController extends Controller
{
    //
    public function store(Request $request, Post $post) {
      // dd($post->id);
      $this->validate($request, [
        'body' => 'required'
      ]);
  
      $comment = new Comment(['body' => $request->body]);
      $comment->user_id = Auth::user()->id;
      $username =  DB::table('users')->where('id',$comment->user_id)->value('name');
      // dd($username);
      $comment->username = $username;
      // dd($comment->user_id);
      $post->comments()->save($comment);
      return redirect()->action('PostsController@show', $post);
    }

    public function destroy(Post $post, Comment $comment) {
      // dd('destroy');
      // dd($post);
      $comment->delete();
      // dd($comment);
      // dd($post);
      return redirect()->action('PostsController@show', $post);
      return redirect()->back();
    }
}
