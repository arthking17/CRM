<?php

namespace App\Http\Controllers;

use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'login';
    }

    public function index()
    {
        return view('auth.login');
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'login' => 'required|exists:App\Models\User,login',
            'pwd' => 'required',
        ]);

        //dd($request->ip());
        /*$user = User::where('login', $credentials['login'])->take(1)->get();
        $user = User::find($user[0]->id);
        if (Hash::check($credentials['pwd'], $user->pwd)) {
            $request->session()->regenerate();
            $user->timezone = config('app.timezone');
            $user->ip_address = $request->ip();
            $user->browser = $request->header('user-agent');
            $user->last_auth = today();
            $user->save();
            Session::put('user', $user);

            return redirect()->intended('profile');
        }*/
        //return $request->header('user-agent');
        //return explode("/", $request->header('user-agent'))[2];
        
        if (Auth::attempt(['login' => $credentials['login'], 'password' => $credentials['pwd'], 'status' => 1], $request->has('remember'))) {

            $user = User::find(Auth::id());
            $user->timezone = config('app.timezone');
            $user->ip_address = $request->ip();
            $user->browser = explode("/", $request->header('user-agent'))[2];
            $user->last_auth = new DateTime();
            $user->save();

            $request->session()->regenerate();
            
            return redirect()->intended();
        }
        //dd($request->header());
        //dd(config('app.timezone'));
        return back()
        ->withInput($request->except('pwd'))
        ->withErrors([
            'login' => 'The provided credentials do not match our records.',
        ]);
    }

    public function signOut()
    {
        Session::flush();
        Auth::logout();

        return Redirect('login');
    }
}
