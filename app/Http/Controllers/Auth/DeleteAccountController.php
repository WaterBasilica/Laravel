<?php

namespace App\Http\Controllers\Auth;
use Auth;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class DeleteAccountController extends Controller
{
    function deleteAccount(Request $request) {
      // dd(Auth::user());
      $user = User::find(Auth::user()->id);
      // dd($user);
      $user->delete();
      $request->session()->put('deleteAccountFlg', 1);
      return redirect()->to('/');
    }

}
