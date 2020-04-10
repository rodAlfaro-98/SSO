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

Route::get('/home', 'HomeController@index')->name('home');

Route::get('login/facebook','Auth\LoginFacebookController@redirect');
Route::get('login/facebook/callback', 'Auth\LoginFacebookController@callback');
Route::get('login/google','Auth\LoginGoogleController@redirectToProvider');
Route::get('callback','Auth\LoginGoogleController@handleProviderCallback');

Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
