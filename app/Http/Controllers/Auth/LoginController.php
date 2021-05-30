<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
// use App\Providers\RouteServiceProvider;
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
    protected $redirectTo = '/home';
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // GitHubの認証ページヘ遷移（ユーザーを転送するためのルート）
 
 public function redirectToProvider() 
 {
    return Socialite::driver("github")->redirect();
  }
 
 
  // GitHubの認証後に戻るルート
  public function handleProviderCallback() {
    try {
      $user = Socialite::driver('github')->user();
  } catch (Exception $e) {
      return redirect('/login');
  }

  $authUser = $this->findOrCreateUser($user, $provider);
  Auth::login($authUser, true);
  return redirect($this->redirectTo);
}

public function findOrCreateUser($providerUser, $provider)
{
  $account = IdentityProvider::whereProviderName($provider)
              ->whereProviderId($providerUser->getId())
              ->first();

  if ($account) {
      return $account->user;
  } else {
      $user = User::whereEmail($providerUser->getEmail())->first();

      if (!$user) {
          $user = User::create([
              'email' => $providerUser->getEmail(),
              'name'  => $providerUser->getName(),
          ]);
      }

      $user->IdentityProviders()->create([
          'provider_id'   => $providerUser->getId(),
          'provider_name' => $provider,
      ]);

      return $user;
  }
}
}
