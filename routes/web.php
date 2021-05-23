<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

//　ルーティング
// 複数のプロバイダーで認証する場合

// Route::prefix('login/{provider}')->where(['provider' => '(twitter|facebook)'])->group(function(){
//     Route::get('/', [App\Http\Controllers\LoginController::class, 'redirectToProvider'])->name('sns_login.redirect');
//     Route::get('/callback', [App\Http\Controllers\LoginController::class, 'handleProviderCallback'])->name('sns_login.callback');
// });

Route::get('/login/{provider}', 'Auth\LoginController@redirectToProvider')->where('social', 'twitter|facebook');
Route::get('/login/{provider}/callback', 'Auth\LoginController@handleProviderCallback')->where('social', 'twitter|facebook');
// シンプルに実装する場合
// Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');

// Route::get('login/facebook', 'Auth\LoginController@redirectToProvider');
// Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallback');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
