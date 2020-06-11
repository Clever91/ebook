<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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

// ~~~~~~~~~~~~~~~~~~~ Admin ~~~~~~~~~~~~~~~~~~~

Auth::routes(['register' => false]);
Route::get('/', function() {
    return redirect('login');
});

Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {

    Route::get('/dashboard', 'HomeController@index')->name('dashboard');
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

    Route::resource('user', 'Admin\UserController');

    Route::get('/lang/{locale}', function ($locale) {
        if (!in_array($locale, config('translatable.locales'))) {
            abort(400);
        }
    
        session('locale', $locale);
        App::setLocale($locale);

        return back();
    })->name("admin/locale");
});


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