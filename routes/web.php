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

Auth::routes(['verify' => true ]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/test', function() {
    return Auth::user();
});

Route::get('/{vue_capture?}', function () {
    return view('layouts.master');
   })->where('vue_capture', '(members|students|profile)')->middleware('auth');