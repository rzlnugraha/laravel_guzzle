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
        // $this->middleware('auth');

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
        $req = $client->get('localhost:8000/api/auth/me', [
            'headers' => [
                'Authorization' => $access_token
            ]
        ]);
        $response = $req->getBody()->getContents();
        $dataUser = json_decode($response);
        $code = $dataUser->code;
        if ($code == 200) {
            Session::flash('success','Berhasil masuk');
            $user = $dataUser->content;
            return view('home', compact('user'));
        } elseif ($code == 401) {
            Session::flash('success','Tokenmu habis');
            return redirect()->route('logout');
        }
    }

    public function login()
    {
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $req = $client->post('localhost:8000/api/auth/login', [
            'form_params' => [
                "email" => "ijal@mail.com",
                "password" => "password"
            ]
        ]);
        $response = $req->getBody()->getContents();
        dd($response);
    }
}
