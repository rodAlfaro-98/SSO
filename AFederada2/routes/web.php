<?php
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
	$user = Auth::user();
	if($user){
		return redirect()->to('home');
	}
    return view('welcome');
});
*/
Auth::routes();
//Route::get('/home', 'HomeController@index')->name('home');

Route::get('login/facebook','Auth\LoginFacebookController@redirect');
Route::get('login/facebook/callback', 'Auth\LoginFacebookController@callback');
Route::get('login/google','Auth\LoginGoogleController@redirectToProvider');
Route::get('login/google/','Auth\LoginGoogleController@redirectToProvider')->name('login.google');

Route::get('callback/','Auth\LoginGoogleController@handleProviderCallback')->name('callback');

Route::get('redirect/{user}',function($user){
	$host= base64_decode(strtr(session('host'), '-_,', '+/='));
	if(strcmp('http://localhost:8000/',$host)==0){
		return redirect()->route('home');
	}else{
		header("Location: $host?auth=".$user,true);
		die();
	}
})->name('return.host');

Route::get('callback/google/{$url}','Auth\LoginGoogleController@handleProviderCallback')->name('callback.google');

Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('redirect',function(){
	if(isset($_GET['url'])){
		session(['host'=>$_GET['url']]);
	}
	else{
		session(['host'=>base64_encode(strtr('http://localhost:8000/','-_,','+/='))]);
	}
	$user=Auth::user();
	if($user){
		$host= base64_decode(strtr(session('host'), '-_,', '+/='));
		header("Location: $host?auth=".$user,true);
		die();
	}else{
		$action=$_GET['action'];
		if(strcmp('login',$action)==0){
			return view('auth.loginsso');
		}else{
			return view('auth.register');
		}
	}
})->name('redirect');

Route::get('/logout', function(){
	Auth::logout();
	return redirect()->route('loggedOut');
})->name('logout');

/*Route::get('/', function(){
	return view('welcome');
})->name('loggedOut');

Route::get('login', ['as'=>'login','uses'=>'Auth\LoginController@login']);*/



 
