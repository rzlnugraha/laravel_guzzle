<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Session;


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

    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $req = $client->post('localhost:8000/api/auth/login', [
            'form_params' => [
                'email' => $email,
                'password' => $password
            ]
        ]);
        $response = $req->getBody()->getContents();
        $dataLogin = json_decode($response, true);
        $code = $dataLogin['code'];
        if ($code == 200) {
            $access_token = 'bearer' . $dataLogin['content']['access_token'];
            session(['authenticate' => $dataLogin['content']]); //data token di simpan di session
            Session::flash('success','Berhasil');
            return redirect()->route('home');
        } else {
            return redirect()->route('login');
        }
    }
}
