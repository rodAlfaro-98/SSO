<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use App\User;

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

	protected $url;
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
    public function __construct(UrlGenerator $url)
    {
        $this->middleware('guest')->except('logout');
		$this->url=$url;
    }
	
	function base64UrlEncode($inputStr)
	{
		return strtr(base64_encode($inputStr),'+/=','-_,');
	}
	
	protected function attemptLogin(Request $request)
	{
		if(Auth::user()){
			return view('home',[Auth::user()]);
		}else{
			$url=$this->base64UrlEncode($this->url->to('/callback'));
			header('Location: http://localhost:8000/redirect?url='.$url.'&action=login');
			die();
			return $broker->login($credentials[$this->username], $credentials['password']);
		}
	}
	
	function base64UrlDecode($inputStr)
	{
		return base64_decode(strtr($inputStr, '-_,', '+/='));
	}
	
	protected function callback(Request $request)
	{
		$user=$this->base64UrlDecode($_GET['auth']);
		$authUser=json_decode($user);
		$existingUser = User::where($authUser)->first();
		auth()->login($existingUser,true);
		$user= Auth::user();
		return redirect()->route('loged',['name'=>$user->name]);
	}
}
