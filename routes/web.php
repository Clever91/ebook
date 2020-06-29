<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Lunaweb\Localization\Facades\Localization;

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

Auth::routes(['register' => false]);
Route::get('/', function() {
    return redirect('login');
});

Route::get('/denied', function() {
    return view('error._denied');
})->name('denied');

// ~~~~~~~~~~~~~~~~~~~ Admin ~~~~~~~~~~~~~~~~~~~
Localization::localizedRoutesGroup(function() {

    // error route
    Route::get('/error/404', function() {
        if (Auth::check())
            return view('error._404');
        
        return view('auth._404');
    })->name('error404');

    Route::get('/error/500', function() {
        if (Auth::check())
            return view('error._500');
        
        return view('auth._500');
    })->name('error500');

    // admin route
    Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
        // globale route
        Route::get('/', 'Admin\DashboardController@index')->name('home');
        Route::get('/dashboard', 'Admin\DashboardController@index')->name('dashboard')->middleware('auth');
        Route::get('/lang/{lang}', 'Admin\LanguageController@index')->name("admin.lang");
        Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

        // resource route
        // Route::group(['middleware' => ['sadmin', 'admin']], function() {
        // });
        Route::resource('user', 'Admin\UserController')->except('show');
        Route::resource('category', 'Admin\CategoryController')->except('show');
        Route::resource('group', 'Admin\GroupController')->except('show');
        Route::resource('author', 'Admin\AuthorController')->except('show');
        Route::resource('product', 'Admin\ProductController')->except('show');

        // custom route of product
        Route::get('/product/{product}/eform', 'Admin\ProductController@eform')->name('product.eform');
        Route::patch('/product/{product}/eform', 'Admin\ProductController@eform')->name('product.eform.patch');
        Route::get('/product/{product}/image', 'Admin\ProductController@image')->name('product.image');
        Route::patch('/product/{product}/image', 'Admin\ProductController@image')->name('product.image.patch');
    });
    
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