<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $userid = Auth::user()->id;
        $id =  $request->session();
        $login = 'login';
        $test = DB::table('posts')->where('id', $userid)->first();
        // セッションへ一つのデータを保存する
        // ユーザー情報を保存する
        $request->session()->put('id', $userid);
        // currentpostを取得
        $currentpost  = $request->session()->get('currentpost');
        // dd('aaa');
        return Redirect('../' . $userid)->with('userid',$userid)->with($currentpost);
    }
}
