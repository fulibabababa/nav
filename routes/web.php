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

Route::get('/', 'LinkController@index')->name('home');
Route::get('employ', 'LinkController@employ')->name('employ');
Route::post('employ/register', 'LinkController@register')->name('employ.register');
Route::get('what', function () {
    return view('oops');
})->name('oops');
//Route::get('hack', 'LinkController@hack');
//Route::get('insert', 'LinkController@insert');
//Route::get('check', 'LinkController@check')->name('check');
