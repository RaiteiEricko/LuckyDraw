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

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/save-number', 'HomeController@saveNumber')->name('save-number');
Route::get('/admin', 'HomeController@admin')->middleware('admin')->name('admin');
Route::post('/draw-winner', 'HomeController@drawWinner')->middleware('admin')->name('draw-winner');
