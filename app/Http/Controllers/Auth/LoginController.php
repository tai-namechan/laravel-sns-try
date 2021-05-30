<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Auth;
use Socialite;
use App\User;
use App\IdentityProvider;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
 * GitHubの認証ページヘ遷移（ユーザーを転送するためのルート）
 *
 * @return \Symfony\Component\HttpFoundation\RedirectResponse
 */
 public function redirectToProvider() {
    return Socialite::driver("github")->redirect();
  }
 
 /**
  * GitHubの認証後に戻るルート
  *
  * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
  */
  public function handleProviderCallback() {
    $socialUser = Socialite::driver('github')->stateless()->user();
      $user = User::where([ 'email' => $socialUser->getEmail() ])->first();

     if ($user) {
          Auth::login($user);
          return redirect('/home');
      } else {
          $user = User::create([
              'name' => $socialUser->getNickname(),
              'email' => $socialUser->getEmail(),
              'password' => Hash::make($socialUser->getNickname()),  
          ]);
          Auth::login($user);
          return redirect('/home');
      }
    }
  //   try {
  //     $user = Socialite::with("github")->user();
  //   } catch (Exception $e) {
  //     return redirect('/welcome'); 
  //     エラーならウェルカムページに転送
  //   }
 
  //   nameかnickNameをuserNameにする
  //   if ($user->getName()) {
  //     $userName = $user->getName();
  //   } else {
  //     $userName = $user->getNickName();
  //   }
 
  //   mailアドレスおよび名前を保存
  //   $authUser = User::firstOrCreate([
  //     'email' => $user->getEmail(),
  //     'name' => $userName
  //   ]);
  //   auth()->login($authUser); 
  //   ログイン
  //   return redirect()->to('/home'); 
  //   homeページに転送
  }
}
