<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => ['auth.api']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/logoutest','HomeController@logout')->name('logout.test');
});
Route::get('/logintest','HomeController@login')->name('login.test');
