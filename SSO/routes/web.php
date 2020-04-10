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

Route::get('/', function () {
    $user = Auth::user();
	if($user){
		return redirect()->to('home');
	}
    return view('welcome');
});

Auth::routes();

Route::get('home/{name}',function($name){
	return view('/home',['name'=>$name]);
})->name('loged');
Route::get('register',['as'=>'register','uses'=>'Auth\RegisterController@register']);
Route::get('/home', ['as'=>'home','uses'=>'HomeController@index']);
Route::get('/login',['as'=>'login','uses'=>'Auth\LoginController@attemptLogin']);
Route::get('/callback',['as'=>'callback','uses'=>'Auth\LoginController@callback']);

Route::get('/logout', function(){
	Auth::logout();
	return redirect()->route('loggedOut');
})->name('logout');

Route::get('/', function(){
	return view('welcome');
})->name('loggedOut');

