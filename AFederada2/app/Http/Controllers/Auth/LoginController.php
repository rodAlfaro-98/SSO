<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Socialite;
use Auth;
use App\User;
//use Laravel\Socialite\Facades\Socialite;

function credentials(Request $request)
{
    $request['active'] = 1;
    return $request->only($this->username(), 'password', 'active');
}


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
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }




    public function handleProviderCallback()
    {
        $user = Socialite::driver("google")->stateless()->user();
        return redirect()->to('/home');
    }

    public function login(Request $request){
        $user=User::where($request->only('email'))->first();
        $password=$request->only('password');
        if(password_verify($password['password'], $user->password)){
            auth()->login($user,true);
            return redirect()->route('return.host',$user);
        }
        return view('loginsso');
    }

}
