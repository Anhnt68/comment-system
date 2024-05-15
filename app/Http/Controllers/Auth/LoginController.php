<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;



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
        $this->middleware('guest:admin')->except('logout');
    }

    public function showAdminLoginForm()
    {
        return view('auth.login', ['route' => route('admin.login-view'), 'title'=>'Admin']);
    }

    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('admin')->attempt($request->only(['email', 'password']), $request->get('remember'))) {
            $user = Auth::guard('admin')->user();

            // Tạo JWT token từ người dùng
            $token = JWTAuth::fromUser($user);

            // Lưu token vào cookie
            $cookie = \Cookie::make('access_token', $token, 60);

            // Chuyển hướng người dùng đến trang mong muốn
            return redirect()->intended('/admin/dashboard')->withCookie($cookie);
        }

        // Trong trường hợp đăng nhập không thành công
        return back()->withInput($request->only('email', 'remember'))->withErrors([
            'email' => 'Email hoặc mật khẩu không đúng.'
        ]);
    }

}
