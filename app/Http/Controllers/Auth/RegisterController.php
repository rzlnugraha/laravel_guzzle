<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Session;    


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function register(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $req = $client->post('https://app-panjul.herokuapp.com/api/auth/register', [
            'form_params' => [
                'name' => $name,
                'email' => $email,
                'password' => $password
            ],
        ]);
        $response = $req->getBody()->getContents();
        $dataLogin = json_decode($response, true);
        $code = $dataLogin['code'];
        $message = $dataLogin['message'];
        if ($code == 200) {
            Session::flash('success', $message);
            return redirect()->route('home');
        } else {
            $error = "";
            foreach ($dataLogin['contents'] as $key) {
                // dd($key);
                $error .=$key[0].'<br/>';
            }
            Session::flash('error', $error);
            return redirect()->route('register');
        }

    }
}
