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

// Route::get('/login/{provider}', 'Auth\LoginController@redirectToProvider')->where('social', 'github|facebook');
// Route::get('/login/{provider}/callback', 'Auth\LoginController@handleProviderCallback')->where('social', 'github|facebook');

// シンプルに実装する場合
// Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// GitHubの認証ページに遷移するためのルーティング
Route::get('login/github', 'Auth\LoginController@redirectToProvider');

// GitHubの認証後に戻るためのルーティング
Route::get('/login/github/callback', 'Auth\LoginController@handleProviderCallback');
