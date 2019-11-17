<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Session;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = session('authenticate');
        $access_token = 'bearer '.$data['access_token'];
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $req = $client->get('https://app-panjul.herokuapp.com/api/auth/me', [
        'headers' => [
            'Authorization' => $access_token
            ]
        ]);
        $response = $req->getBody()->getContents();
        $dataUser = json_decode($response);
        $code = $dataUser->code;
        $message = $dataUser->message;
        if ($code == 200) {
            $user = $dataUser->content;
            return view('home', compact('user'));
        } elseif ($code == 401) {
            Session::flash('error','Hohoho login heula');
            return redirect()->route('logout.test');
        }
    }
                
    public function login()
    {
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $req = $client->post('https://app-panjul.herokuapp.com/api/auth/login', [
            'form_params' => [
                "email" => "ijal@mail.com",
                "password" => "password"
            ]
        ]);
        $response = $req->getBody()->getContents();
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        Session::flash('success','Berhasil logout');
        return redirect(route('login'));
    }
}
