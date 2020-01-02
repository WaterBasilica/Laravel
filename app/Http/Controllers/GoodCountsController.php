<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GoodCountsController extends Controller
{
  //session確認
  $exists   = $request->session()->exists('id');
  // IDを取得
  $user_id   = $request->session()->get('id');
  $currentpost = $request->session()->get('currentpost');
  $wherefrom = $request->session()->get('wherefrom');

  
}
