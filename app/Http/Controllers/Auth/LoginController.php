<?php

namespace App\Http\Controllers\Auth;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    // use AuthenticatesUsers {
    //     logout as traitLogout;
    // }
    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
      // 　$this->middleware('auth');
        $this->middleware('guest')->except('logout');

      
    }
    // public function logout(Request $request) {
    //   // Auth::logout();
    //   return redirect('/login');
    // }

   //  public function logout(Request $request)
   // {
   //
   //     $this->traitLogout($request);
   //
   //     return redirect('user');
   //
   // }

}
