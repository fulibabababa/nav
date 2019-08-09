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

Route::match(['get', 'post'], '/git/deploy', function () {
    $shell   = ["/bin/bash", base_path('resources/shell/deploy.sh'), base_path()];
    $process = new \Symfony\Component\Process\Process($shell);
    $process->start();
    $process->wait(function ($type, $buffer) {
        if (\Symfony\Component\Process\Process::ERR === $type) {
            $str = 'ERR > ' . $buffer;
        } else {
            $str = 'OUT > ' . $buffer;
        }
        \Illuminate\Support\Facades\Log::info('command:' . $str);
        echo $str;
    });
});
