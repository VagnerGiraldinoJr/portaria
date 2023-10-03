<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Unidade;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function login(Request $request)
    {

      if (Auth::guard('web')->attempt(['email' => $request->email, 'unidade_id' => $request->unidade_id , 'password' => $request->password])) {
        // if successful, then redirect to their intended location
        return redirect()->intended(RouteServiceProvider::HOME);
      }
      return redirect()->back()->withErrors(['message' => 'Usuário ou senha inválido.']);
    }

    public function showLoginForm()
    {
        $unidade = new Unidade();
        $data = $unidade->orderBy('titulo')->get()->pluck('titulo','id');
        return view('auth.login',compact('data'));
    }


}
