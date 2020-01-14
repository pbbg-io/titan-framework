<?php

namespace PbbgIo\Titan\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use PbbgIo\Titan\SocialProvider;

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
    protected $redirectTo = '/characters';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('titan::auth.login');
    }

    public function loggedOut(Request $request)
    {
        session()->forget('character_logged_in');
    }

    public function redirectToProvider($provider, Request $request) {

        // Get these from settings

        return Socialite::driver($provider)->redirect();


    }

    public function handleProviderCallback($provider, Request $request) {

        try {
            $user = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            dd($e);
        }
        $authUser = $this->findOrCreateUser($user, $provider);
        auth()->login($authUser, true);
        return redirect()->to('dashboard');
    }


    private function findOrCreateUser($user, $provider)
    {
        if ($authUser = SocialProvider::where('providerId', $user->id)->where('provider',$provider)->first()) {
            return $authUser->user;
        }
        $newUser = new User([
            'name' => isset($user->name) ? $user->name : $user->nickname,
            'email' => $user->email,
        ]);

        $newUser->save();

        $socialProvider = new SocialProvider([
            'user_id' => $newUser->id,
            'provider' => $provider,
            'providerId' => $user->getId(),
            'avatar' => $user->avatar
        ]);
        $socialProvider->save();

        return $newUser;
    }
}
