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
    return redirect()->route('login');
});

Auth::routes();

Route::get('home/{name}',function($name){
	return view('/home',['name'=>$name]);
})->name('loged');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/login','Auth\LoginController@attemptLogin')->name('login');
Route::get('/callback','Auth\LoginController@callback')->name('callback');

Route::get('/', function(){
	return view('welcome');
})->name('loggedOut');

Route::get('/logout', function(){
	Auth::logout();
	return redirect()->route('loggedOut');
})->name('logout');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
