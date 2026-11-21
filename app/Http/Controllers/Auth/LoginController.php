<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use App\Models\Sit\User as SitUser;
use Alert;
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
    protected $redirectTo = '/home';

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
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        $email = (string) $request->input('email');
        $password = (string) $request->input('password');

        $administrativo = User::where('email', $email)->first();
        if ($administrativo && $administrativo->active === 'true') {
            if (Auth::guard('web')->attempt([
                'email' => $email,
                'password' => $password,
                'active' => 'true',
            ])) {
                $request->session()->regenerate();
                $this->clearLoginAttempts($request);

                return redirect()->intended('/home');
            }
        }

        $sitUser = SitUser::where('email', $email)->where('activo', 1)->first();
        if ($sitUser && $sitUser->isAlumnoActivo()) {
            if (Auth::guard('alumno')->attempt([
                'email' => $email,
                'password' => $password,
                'activo' => 1,
            ], false)) {
                $request->session()->regenerate();
                $this->clearLoginAttempts($request);

                return redirect()->intended('alumnos/home');
            }
        }

        $this->incrementLoginAttempts($request);
        Alert::error('Error', 'El usuario o la contraseña son incorrectos.');

        return redirect()->back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Credenciales inválidas.']);
    }

    public function alumnoLogin(Request $request)
    {
        return $this->login($request);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        Auth::guard('alumno')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }


}
