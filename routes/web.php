<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function() {
    return redirect('login');
});

Auth::routes(['register' => false]);

Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('/dashboard', 'HomeController@index')->name('dashboard');
    
    Route::resource('user', 'Admin\UserController');
});
