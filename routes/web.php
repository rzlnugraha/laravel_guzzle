<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => ['auth.api']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/logoutest','HomeController@logout')->name('logout.test');
});
Route::get('/logintest','HomeController@login')->name('login.test');
