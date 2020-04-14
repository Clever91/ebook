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

// ~~~~~~~~~~~~~~~~~~~ Firebase Auth ~~~~~~~~~~~~~~~~~~~


Route::group(['prefix' => "firebase"], function() {

    Route::get('/auth', function() {
        return view('auth.firebase');
    });

    Route::get('/', 'Auth\FirebaseController@index');
    Route::get('/check', 'Auth\FirebaseController@check');
    Route::get('/create', 'Auth\FirebaseController@create');  
    Route::get('/success', 'Auth\FirebaseController@success');  

});


// ~~~~~~~~~~~~~~~~~~~ Admin ~~~~~~~~~~~~~~~~~~~

Route::get('/', function() {
    return redirect('login');
});

Auth::routes(['register' => false]);

Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('/dashboard', 'HomeController@index')->name('dashboard');
    
    Route::resource('user', 'Admin\UserController');
});
