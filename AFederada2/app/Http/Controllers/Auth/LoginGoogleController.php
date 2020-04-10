<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use DB; 
use App\User;
use Socialite;

class LoginGoogleController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
        //return Scorialite::driver('google')->stateless()->user();
    }

    function base64UrlEncode($inputStr)
	{
		return strtr(base64_encode($inputStr),'+/=','-_,');
    }
    
    function base64UrlDecode($inputStr)
	{
		return base64_decode(strtr($inputStr, '-_,', '+/='));
	}

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        try{
            $user = Socialite::driver('google')->stateless()->user();
        } catch(\Exception $e){
            return redirect()->to('/');
        }

        $existingUser = User::where('email',$user->email)->first();
        if($user->nickname){
            $nickname=$user->nickname;
        }else{
            $nickname=$user->name;
        }

        if($existingUser){
            //return (array) $existingUser;
            DB::table('users')
                ->where('email',$user->email)
                ->update(['remember_token'=>$user->token]);
            auth()->login($existingUser, true);
        } else{
            //return 'Non existing';
            DB::table('users')
                ->insert(['first_name'=>$user->name,'last_name'=>"",'username'=>$nickname,'email'=>$user->email,'remember_token'=>$user->token,'account_number'=>$user->id]);
                $existingUser = User::where('email',$user->email)->first();
            auth()->login($existingUser, true);
        }
        $user=Auth::user();
        //return (array) $user;
        $toReturn = json_encode($user);

        return redirect()->route('return.host',[$this->base64UrlEncode($user->email)]);
        //return redirect()->to('/home');

        //return redirect()->route('home',['user'=>$user]);
    }

    public function returnHost($url, $user){
        header("Location: $url?auth=".$user,true);
	    exit();
    }
}