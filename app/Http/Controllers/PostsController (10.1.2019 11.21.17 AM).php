<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use App\Post;
use App\User;
use Auth;
use App\Comment;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ImageUploadRequest;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Controller,Session;
// use Intervention\Image\ImageManagerStatic as Image;


class PostsController extends Controller
{

    // public function __construct(Router $router) {
    //     // ルートパラメータを取得する
    //     $routeParamName = 'prefecture_slug';
    //     $defaultValue = null;
    //     // $routeParam = $router->getCurrentRoute()->getParameter($post, $defaultValue);
    //     // 全てのルートパラメータを取得したい場合は以下のようにする
    //     $allRouteParams = $router->getCurrentRoute()->parameters();
    //
    // }

    public function index(Request $request) {
      //session確認
      $exists   = $request->session()->exists('id');
      // IDを取得
      $userid   = $request->session()->get('id');
      $currentpost = $request->session()->get('currentpost');
      $wherefrom = $request->session()->get('wherefrom');
      $post = Post::find($currentpost);
      // dd('aaa');
      // dd($post);
      // $post = Post::findOrFail($currentpost);
      if(isset($post)) {
        $this->show($request, $post);
        return Redirect('../posts/' . $currentpost);
      }
        // dd($post);

      if($exists) {
        // dd($exists);
      } else {
        // return view('../auth/login');
      }
      $comments = "";
      $mylatestp = "";
      // if($id==null) {
      //   return view('auth.login');
      // }
      // $posts = \App\Post::all();
      // $posts = Post::all();
      // $posts = Post::orderBy('created_at', 'desc')->get();
      $posts = Post::latest()->get()->where('userid',$userid);
      // dd($userid);
      // dd($posts);
      // dd($posts->toArray());
      $url = Storage::url('app.js');
       // $contents = Storage::get('sample01.jpg');
      $files = Storage::files($url);



      //******検索機能**************
      #キーワード受け取り
      $keyword = $request->input('keyword');

      $serchResult = "";
      #クエリ生成
      $query = Post::query();
      #もしキーワードがあったら
      if(!empty($keyword)) {

         // $query->where('body','like','%'.$keyword.'%')->orWhere('title','like','%'.$keyword.'%');
         $serchResult =  DB::table('posts')->where('body','like','%'.$keyword.'%')->where('deleted_at',null)->orWhere('title','like','%'.$keyword.'%')->where('deleted_at',null)->get();
         $counter=0;
         foreach ($serchResult as $srv) {
           if($counter==0){
             $maxid = $srv.id;
           }
         }
         //日付
         $maxid = Post::all('id')->max('id');
         $post = $serchResult;
         $latestp = DB::table('posts')->where('id','=',$maxid)->get();

         // dd(isset($idd));
         // dd(isset($postcount));
         if(isset($serchResult)) {
             $d = $this->getDate($post);
         } else {
           $d = null;
         }

         foreach ($serchResult as $laa) {
           // dd($laa->id);
           $postid = $laa->id;
         }
         $comSQL = DB::table('comments')->toSql();
         $userSQL = DB::table('users')->toSql();
         $postSQL = DB::table('posts')->where('body','like','%'.$keyword.'%')->where('deleted_at',null)->orWhere('title','like','%'.$keyword.'%')->where('deleted_at',null)->toSql();
         // dd($userid);
         $joinCommentResult = DB::table('posts')->JoinSub($comSQL, 'COM', 'posts.userid', 'COM.id')->get();
         $maxPostId = DB::table('posts')->JoinSub($userSQL, 'USER', 'posts.userid', 'USER.id')->where('USER.id',$userid)->where('posts.deleted_at',null)->max('posts.id');
         $joinLatestResult = DB::table('posts')->where('id',$maxPostId)->get();
         if(isset($postid)) {
           $mylatestp = DB::table('posts')->where('body','like','%'.$keyword.'%')->where('deleted_at',null)->where('id','=',$maxid)->orWhere('title','like','%'.$keyword.'%')->where('deleted_at',null)->where('id','=',$maxid)->get();
           $comments = Comment::all('id')->where('post_id',$postid);
         }

         // $allPosts = Post::latest()->get()->where('deleted_at',null);
         // $allPosts = DB::table('posts')->JoinSub($userSQL, 'USER', 'posts.userid', 'USER.id')->orderBy('posts.id','desc')->get()->where('deleted_at',null);
         $allPosts = User::JoinSub($postSQL, 'POST', 'users.id', 'POST.userid')->orderBy('POST.id','desc')->get()->where('deleted_at',null);
         // dd($allPosts);
         // return view('posts.index',['posts' => $posts]);
         return view('posts.index')->with('posts',$posts)
         ->with('date',$d)
         ->with('mylatestp',$mylatestp)
         ->with('comments',$comments)
         ->with('joinCommentResult',$joinCommentResult)
         ->with('joinLatestResult',$joinLatestResult)
         ->with('userid',$userid)
         ->with('serchResult',$serchResult)
         ->with('allPosts', $allPosts);













      }
      // dd($serchResult);
      //*************************

      $postscount = Post::latest()->get()->where('userid',$userid)->count();
      //日付
      $maxid = Post::all('id')->max('id');
      $idd = DB::table('posts')->where('userid','=',$userid)->get();
      $post = Post::find($maxid)->where('userid',$userid);
      $latestp = DB::table('posts')->where('id','=',$maxid)->get();
      // dd(isset($idd));
      // dd(isset($postcount));
      if(isset($postcount)) {
          $d = $this->getDate($post);
      } else {
        $d = null;
      }

      foreach ($posts as $laa) {
        // dd($laa->id);
        $postid = $laa->id;
      }
      $comSQL = DB::table('comments')->toSql();
      $userSQL = DB::table('users')->toSql();
      $postSQL = DB::table('posts')->toSql();
      // dd($userid);
      $joinCommentResult = DB::table('posts')->JoinSub($comSQL, 'COM', 'posts.userid', 'COM.id')->get();
      $maxPostId = DB::table('posts')->JoinSub($userSQL, 'USER', 'posts.userid', 'USER.id')->where('USER.id',$userid)->where('posts.deleted_at',null)->max('posts.id');
      $joinLatestResult = DB::table('posts')->where('id',$maxPostId)->get();
      if(isset($postid)) {
        $mylatestp = DB::table('posts')->where('userid','=',$userid)->where('id','=',$maxid)->get();
        $comments = Comment::all('id')->where('post_id',$postid);
      }

      // $allPosts = Post::latest()->get()->where('deleted_at',null);
      // $allPosts = DB::table('posts')->JoinSub($userSQL, 'USER', 'posts.userid', 'USER.id')->orderBy('posts.id','desc')->get()->where('deleted_at',null);
      $allPosts = User::JoinSub($postSQL, 'POST', 'users.id', 'POST.userid')->orderBy('POST.id','desc')->get()->where('deleted_at',null);
      // dd($allPosts);
      // return view('posts.index',['posts' => $posts]);
      return view('posts.index')->with('posts',$posts)
      ->with('date',$d)
      ->with('mylatestp',$mylatestp)
      ->with('comments',$comments)
      ->with('joinCommentResult',$joinCommentResult)
      ->with('joinLatestResult',$joinLatestResult)
      ->with('userid',$userid)
      ->with('serchResult',$serchResult)
      ->with('allPosts', $allPosts);
    }

    // public function login_check(Request $request) {
    //   // ユーザー情報がセット(nullでもOK)されているかチェック
    //   $exists   = $request->session()->exists('id');
    //   if($exists) {
    //     // dd($exists);
    //   } else {
    //     return view('../auth/login');
    //   }
    // }

    // public function show($id) {
    // public function show2(Request $request) {
    //
    //   dd(requestUri($request));
    //   dd(substr(pathinfo($request, PATHINFO_DIRNAME),5,1));
    // }
    public function fromclick(Request $request) {
      //session確認
      $exists   = $request->session()->exists('id');
      // IDを取得
      $userid   = $request->session()->get('id');
      $currentpost = $request->session()->get('currentpost');
      $wherefrom = $request->session()->get('wherefrom');
      $comments = "";
      $mylatestp = "";
      // if($id==null) {
      //   return view('auth.login');
      // }
      // $posts = \App\Post::all();
      // $posts = Post::all();
      // $posts = Post::orderBy('created_at', 'desc')->get();
      $posts = Post::latest()->get()->where('userid',$userid);
      // dd($userid);

      // dd($posts);
      // dd($posts->toArray());
      $url = Storage::url('app.js');
       // $contents = Storage::get('sample01.jpg');
      $files = Storage::files($url);
      //******検索機能**************
      #キーワード受け取り
      $keyword = $request->input('keyword');

      $serchResult = "";
      #クエリ生成
      $query = Post::query();
      #もしキーワードがあったら
      if(!empty($keyword)) {
         // $query->where('body','like','%'.$keyword.'%')->orWhere('title','like','%'.$keyword.'%');
         $serchResult =  DB::table('posts')->where('body','like','%'.$keyword.'%')->where('deleted_at',null)->orWhere('title','like','%'.$keyword.'%')->where('deleted_at',null)->get();
         $counter=0;
         foreach ($serchResult as $srv) {
           if($counter==0){
             $maxid = $srv.id;
           }
         }
         //日付
         $maxid = Post::all('id')->max('id');
         $post = $serchResult;
         $latestp = DB::table('posts')->where('id','=',$maxid)->get();

         // dd(isset($idd));
         // dd(isset($postcount));
         if(isset($serchResult)) {
             $d = $this->getDate($post);
         } else {
           $d = null;
         }

         foreach ($serchResult as $laa) {
           // dd($laa->id);
           $postid = $laa->id;
         }
         $comSQL = DB::table('comments')->toSql();
         $userSQL = DB::table('users')->toSql();
         $postSQL = DB::table('posts')->where('body','like','%'.$keyword.'%')->where('deleted_at',null)->orWhere('title','like','%'.$keyword.'%')->where('deleted_at',null)->toSql();
         // dd($userid);
         $joinCommentResult = DB::table('posts')->JoinSub($comSQL, 'COM', 'posts.userid', 'COM.id')->get();
         $maxPostId = DB::table('posts')->JoinSub($userSQL, 'USER', 'posts.userid', 'USER.id')->where('USER.id',$userid)->where('posts.deleted_at',null)->max('posts.id');
         $joinLatestResult = DB::table('posts')->where('id',$maxPostId)->get();
         if(isset($postid)) {
           $mylatestp = DB::table('posts')->where('body','like','%'.$keyword.'%')->where('deleted_at',null)->where('id','=',$maxid)->orWhere('title','like','%'.$keyword.'%')->where('deleted_at',null)->where('id','=',$maxid)->get();
           $comments = Comment::all('id')->where('post_id',$postid);
         }

         // $allPosts = Post::latest()->get()->where('deleted_at',null);
         // $allPosts = DB::table('posts')->JoinSub($userSQL, 'USER', 'posts.userid', 'USER.id')->orderBy('posts.id','desc')->get()->where('deleted_at',null);
         $allPosts = User::JoinSub($postSQL, 'POST', 'users.id', 'POST.userid')->orderBy('POST.id','desc')->get()->where('deleted_at',null);
         // dd($allPosts);
         // return view('posts.index',['posts' => $posts]);
         return view('posts.index')->with('posts',$posts)
         ->with('date',$d)
         ->with('mylatestp',$mylatestp)
         ->with('comments',$comments)
         ->with('joinCommentResult',$joinCommentResult)
         ->with('joinLatestResult',$joinLatestResult)
         ->with('userid',$userid)
         ->with('serchResult',$serchResult)
         ->with('allPosts', $allPosts);













      }
      // dd($serchResult);
      //*************************

      // dd($files);
      $postscount = Post::latest()->get()->where('userid',$userid)->count();
      //日付
      $maxid = Post::all('id')->max('id');
      $idd = DB::table('posts')->where('userid','=',$userid)->get();
      $post = Post::find($maxid)->where('userid',$userid);
      $latestp = DB::table('posts')->where('id','=',$maxid)->get();
      // dd(isset($idd));
      // dd(isset($postcount));
      if(isset($postcount)) {
          $d = $this->getDate($post);
      } else {
        $d = null;
      }

      foreach ($posts as $laa) {
        // dd($laa->id);
        $postid = $laa->id;
      }
      $comSQL = DB::table('comments')->toSql();
      $userSQL = DB::table('users')->toSql();
      $postSQL = DB::table('posts')->toSql();
      // dd($userid);
      $joinCommentResult = DB::table('posts')->JoinSub($comSQL, 'COM', 'posts.userid', 'COM.id')->get();
      $maxPostId = DB::table('posts')->JoinSub($userSQL, 'USER', 'posts.userid', 'USER.id')->where('USER.id',$userid)->where('posts.deleted_at',null)->max('posts.id');
      $joinLatestResult = DB::table('posts')->where('id',$maxPostId)->get();
      if(isset($postid)) {
        $mylatestp = DB::table('posts')->where('userid','=',$userid)->where('id','=',$maxid)->get();
        $comments = Comment::all('id')->where('post_id',$postid);
      }

      // $allPosts = Post::latest()->get()->where('deleted_at',null);
      // $allPosts = DB::table('posts')->JoinSub($userSQL, 'USER', 'posts.userid', 'USER.id')->orderBy('posts.id','desc')->get()->where('deleted_at',null);
      $allPosts = User::JoinSub($postSQL, 'POST', 'users.id', 'POST.userid')->orderBy('POST.id','desc')->get()->where('deleted_at',null);
      // dd($allPosts);
      // return view('posts.index',['posts' => $posts]);
      return view('posts.index')->with('posts',$posts)
      ->with('date',$d)
      ->with('mylatestp',$mylatestp)
      ->with('comments',$comments)
      ->with('joinCommentResult',$joinCommentResult)
      ->with('joinLatestResult',$joinLatestResult)
      ->with('userid',$userid)
      ->with('serchResult',$serchResult)
      ->with('allPosts', $allPosts);
    }

    public function show(Request $request,Post $post) {
      $auths = Auth::user();
      // dd($auths);
      // IDを取得
      $userid   = $request->session()->get('id');
      //session確認
      $exists   = $request->session()->exists('id');
      $currentpost = $request->session()->get('currentpost');

      $postflg = 0;
      if($userid!=$post->userid){
        $postflg = 1;
      }

      // dd($userid);
      // $post = Post::find($id);
      // $post = Post::findOrFail($id);
      $posts = Post::latest()->get();
      $maxid = Post::all('id')->max('id');
      $minid = Post::all('id')->min('id');
      $comSQL = DB::table('comments')->toSql();
      $userSQL = DB::table('users')->toSql();
      $joinCommentResult = DB::table('posts')->JoinSub($comSQL, 'COM', 'posts.userid', 'COM.id')->get();
      $maxPostId = DB::table('posts')->JoinSub($userSQL, 'USER', 'posts.userid', 'USER.id')->where('USER.id',$userid)->where('posts.deleted_at',null)->max('posts.id');
      $minPostId = DB::table('posts')->JoinSub($userSQL, 'USER', 'posts.userid', 'USER.id')->where('USER.id',$userid)->where('posts.deleted_at',null)->min('posts.id');
      $mylatestp =  DB::table('posts')->where('id',$maxPostId);
      $myOldestp =  DB::table('posts')->where('id',$minPostId);
      $max_flg = 0;
      $allPosts = DB::table('posts')->JoinSub($userSQL, 'USER', 'posts.userid', 'USER.id')->get()->where('deleted_at',null);
      // $allPosts = Post::latest()->get()->where('deleted_at',null);

      if($postflg==1) {
        $maxPostId = $othersMaxPostId = DB::table('posts')->JoinSub($userSQL, 'USER', 'posts.userid', 'USER.id')->where('USER.id',$post->userid)->where('posts.deleted_at',null)->max('posts.id');
        $minPostId = $othersMinPostId = DB::table('posts')->JoinSub($userSQL, 'USER', 'posts.userid', 'USER.id')->where('USER.id',$post->userid)->where('posts.deleted_at',null)->min('posts.id');
        $othersLatestp =  DB::table('posts')->where('id',$othersMaxPostId);
        $othersOldestp =  DB::table('posts')->where('id',$othersMinPostId);
        //他人の次のタイトル
        $nextPost = $this->getNextTitle($post, $othersLatestp, $othersMaxPostId);
        //他人の前のタイトル
        $prevPost = $this->getPrevTitle($post, $othersOldestp, $othersMinPostId);
        //他人のposts
        $myPosts = DB::table('posts')->where('posts.deleted_at',null)->where('userid',$post->userid)->orderBy('id', 'desc')->get();
      } else {
        //自分の次のタイトル
        $nextPost = $this->getNextTitle($post, $mylatestp, $maxPostId);
        //自分の前のタイトル
        $prevPost = $this->getPrevTitle($post, $myOldestp, $minPostId);
        //自分のposts
        $myPosts = DB::table('posts')->where('posts.deleted_at',null)->where('userid',$userid)->orderBy('id', 'desc')->get();
      }

      //日付
      $d = $this->getDate($post);
      if ($nextPost!=null) {
        $nextTitle = $nextPost->title;
      } else {
        $nextTitle = "";
        $nextPost = $post;
      }
      if ($prevPost!=null) {
        $prevTitle = $prevPost->title;
      } else {
        $prevTitle = "";
        $prevPost = $post;
      }
      $currentpost = $request->session()->put('currentpost', $post->id);
      return view('posts.show')->with('article',$post)
      ->with('maxid',$maxPostId)
      ->with('minid',$minPostId)
      ->with('date',$d)
      ->with('nextTitle',$nextTitle)
      ->with('prevTitle',$prevTitle)
      ->with('posts',$myPosts)
      ->with('nextPost',$nextPost)
      ->with('prevPost',$prevPost)
      ->with('allPosts', $allPosts)
      ->with('postflg', $postflg)
      ->with('exists',$exists)
      ->with('currentpost',$currentpost);
    }

    //日付
    protected function getDate(Post $post) {
      $date = date_create($post->created_at);
      $date = date_format($date, 'Y-m-d');
      $year = substr($date, 0,4);
      $month = substr($date, 5,2);
      $day = substr($date, 8,2);
      if(substr($date, 5,1)==0) {
        $month = substr($date, 6,1);
      }
      if(substr($date, 8,1)==0) {
        $day = substr($date, 9,1);
      }
      $d = $year . "年" . $month . "月" . $day . "日";
      return $d;
    }

    //次のページ
    public function getNextTitle(Post $post, $posts,int $maxid) {
      $nextTitle = "";
      $nextId = $post->id + 1;
      $count = 0;
      $max_flg = 0;
      $nextPost = "";
      $test = DB::table('posts')->where('id', $nextId)->where('userid',$post->userid)->where('deleted_at',null)->first();
      // dd($post->id);
      if ($post->id == $maxid) {
        // dd('aaa');
        if($test==null) {
          $max_flg = 1;
          return;
        }
      } else {
        while(isset($test)==false){
          $nextId = $nextId + 1;
          $test = DB::table('posts')->where('id', $nextId)->where('userid',$post->userid)->where('deleted_at',null)->first();
        }
        // dd($test);
        return $test;

      }

          // while(($test==null && $post->id < $maxid)  || ($test->deleted_at!=null && $post->id < $maxid)){
          // if ($test!=null) {
          //   if ($test->id >= $maxid) {
          //     $max_flg = 1;
          //     break;
          //   }
          // }
          // if ($count > 10) {
          //   break;
          // }
          // dump($max_flg);
          // dump($nextId);
          // dump($maxid);
          // dump($post->id);
          //     dump($test);
      //     $nextId++;
      //     $count++;
      //     $test = DB::table('posts')->where('id', $nextId)->first();
      //   }
      // }
      // if ($test==null) {
      //   $test = DB::table('posts')->where('id', $post->id)->first();
      // }
      // // dump($test->deleted_at);
      // // dump($nextId);
      // // dump($max_flg);
      //   foreach ($posts as $v) {
      //   if ($v->id == $nextId) {
      //       $nextTitle = $v->title;
      //       $nextPost = $v;
      //       // dump($v->title);
      //   }
      // }
      //
      // return $nextPost;
    }

    //前のタイトル
    public function getPrevTitle(Post $post, $posts,int $minid) {
      $prevTitle = "";
      $prevId = $post->id - 1;
      $count = 0;
      $min_flg = 0;
      $prevPost = "";
      $test = DB::table('posts')->where('id', $prevId)->where('userid',$post->userid)->where('deleted_at',null)->first();
      //一番古いタイトル確認
      if ($post->id == $minid) {
          $min_flg = 1;
          return;
      } else {
        while(isset($test)==false){
          $prevId = $prevId - 1;
          $test = DB::table('posts')->where('id', $prevId)->where('userid',$post->userid)->where('deleted_at',null)->first();
        }
        // dd($test);
        return $test;

      }

         //前のタイトル探す
      //     while($test==null  || $test->deleted_at!=null){
      //       if ($count > 10) {
      //         break;
      //       }
      //       $prevId--;
      //       $count++;
      //       $test = DB::table('posts')->where('id', $prevId)->first();
      //     }
      // if ($test==null) {
      //   $test = DB::table('posts')->where('id', $post->id)->first();
      // }
      // // dump($test->deleted_at);
      // // dump($nextId);
      // // dump($max_flg);
      //   foreach ($posts as $v) {
      //   if ($v->id == $prevId) {
      //       $prevTitle = $v->title;
      //       $prevPost = $v;
      //       // dump($v->title);
      //   }
      // }
      // if ($min_flg==0) {
      //   $prevTitle = $prevTitle . "<";
      // }
      // return $prevPost;
    }

    public function create() {
      return view('posts.create');
    }

    public function store(Request $request) {
      //session確認
      $exists   = $request->session()->exists('id');
      // IDを取得
      $userid   = $request->session()->get('id');
      $post_data = $request->except('imagefile');
      $imagefile = $request->file('imagefile');
      if($imagefile!=null) {
          $temp_path = $imagefile->store('public/temp');
          $read_temp_path = str_replace('public/', 'storage/img/public/', $temp_path);
          // $product_name = $post_data['product_name'];
          $data = array(
            'temp_path' => $temp_path,
            'read_temp_path' => $read_temp_path, //追加
            // 'product_name' => $product_name,
          );
          $request->session()->put('data', $data);
      }


      $post = new Post();
      $post->userid = $userid;
      $post->title = $request->title;
      $post->body = $request->body;
      if($imagefile==null){
        $post->imageurl = "";
      } else {
        $post->imageurl = $read_temp_path;
      }
      $post->save();
      return redirect('/');
    }

    public function postImageConfirm(Request $request){
      // dd($request);
      $post_data = $request->except('imagefile');
      $imagefile = $request->file('imagefile');

      $temp_path = $imagefile->store('public/temp');
      $read_temp_path = str_replace('public/', 'storage/img/public/', $temp_path);//
      $product_name = $post_data['product_name'];
      // dd($read_temp_path);
      $data = array(
          'temp_path' => $temp_path,
          'read_temp_path' => $read_temp_path, //追加
          'product_name' => $product_name,
      );
      $request->session()->put('data', $data);
      return view('posts.image_confirm', compact('data') );
    }

    public function edit(Post $post) {
      return view('posts.edit')->with('post',$post);
    }

    public function update(PostRequest $request, Post $post) {
      $post->title = $request->title;
      $post->body = $request->body;
      $post->save();
      return redirect('/');
    }

    public function destroy(Post $post) {
        // dd('postdelete');
      $post->delete();
      return redirect('/');
    }
}
