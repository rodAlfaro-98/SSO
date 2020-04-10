<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Socialite;

class LoginFacebookController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();
    }
/////////////////////////////////////

////////////////////////////////////

    public function callback()
    {
        $user = Socialite::driver('facebook')->user();
        dd($user);
    }
}
