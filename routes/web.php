<?php

use App\Helpers\Common\Fargo;
use App\Models\Admin\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
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
    return redirect()->route('front.home');
});

Route::get('/denied', function() {
    return view('error._denied');
})->name('denied');

// ~~~~~~~~~~~~~~~~~~~ Payment Callback ~~~~~~~~~~~~~~~~~~~

Route::group(['prefix' => 'pay'], function () {
    // click
    Route::match(['get', 'post'], '/click/prepare', 'Bot\ClickController@prepare')->name('click.prepare');
    Route::match(['get', 'post'], '/click/complete', 'Bot\ClickController@complete')->name('click.complete');
    // payme
    Route::match(['get', 'post'],'/payme/complete', 'Bot\PaymeController@complete')->name('payme.complete');
});

// ~~~~~~~~~~~~~~~~~~~ Front ~~~~~~~~~~~~~~~~~~~
Localization::localizedRoutesGroup(function() {
    // front route
    Route::group(['prefix' => 'front'], function () {
        // globale route
        Route::get('/', 'Front\HomeController@index')->name('front.home');
        Route::get('/category/{cat}/products', 'Front\CategoryController@products')->name('front.category.products');
    });
});

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

    // Route::get('/test', function() {
    //     $content = Fargo::savePrices();
    //     return $content;
    // })->name('test');

    // Route::get('/ptest', function() {
    //     $content = Fargo::getPrices();
    //     return $content;
    // })->name('ptest');

    // Route::get('/price', function() {
    //     // return Fargo::getPrice(0.4, "CITY");
    //     return Fargo::getPrice(6);
    // })->name('ptest');

    // admin route
    Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
        // globale route
        Route::get('/', 'Admin\DashboardController@index')->name('home');
        Route::get('/dashboard', 'Admin\DashboardController@index')->name('dashboard');
        Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

        // resource route
        Route::resource('user', 'Admin\UserController')->except('show');
        Route::resource('category', 'Admin\CategoryController')->except('show');
        Route::resource('group', 'Admin\GroupController')->except('show');
        Route::resource('author', 'Admin\AuthorController')->except('show');
        Route::resource('product', 'Admin\ProductController')->except('show');
        Route::resource('goods', 'Admin\GoodsController')->except('show');
        Route::resource('color', 'Admin\ColorController')->except('show');
        Route::resource('coverType', 'Admin\CoverTypeController')->except('show');

        // book route
        Route::get('/book/list', 'Admin\BookController@list')->name('admin.book.list');
        Route::get('/book/{product}/index', 'Admin\BookController@index')->name('admin.book.index');
        Route::get('/book/{product}/add', 'Admin\BookController@add')->name('admin.book.add');
        Route::patch('/book/{product}/store', 'Admin\BookController@store')->name('admin.book.store');
        Route::get('/book/{book}/edit', 'Admin\BookController@edit')->name('admin.book.edit');
        Route::patch('/book/{product}/update', 'Admin\BookController@update')->name('admin.book.update');
        Route::delete('/book/{book}/destroy', 'Admin\BookController@destroy')->name('admin.book.destroy');
        Route::get('/book/{book}/image', 'Admin\BookController@image')->name('admin.book.image');
        Route::patch('/book/{book}/image', 'Admin\BookController@image')->name('admin.book.image.patch');

        // custom image route
        Route::get('/product/{product}/eform', 'Admin\ProductController@eform')->name('product.eform');
        Route::patch('/product/{product}/eform', 'Admin\ProductController@eform')->name('product.eform.patch');
        Route::get('/product/{product}/image', 'Admin\ProductController@image')->name('product.image');
        Route::patch('/product/{product}/image', 'Admin\ProductController@image')->name('product.image.patch');

        // custom image route
        Route::get('/author/{author}/image', 'Admin\AuthorController@image')->name('author.image');
        Route::patch('/author/{author}/image', 'Admin\AuthorController@image')->name('author.image.patch');

        // custom image route
        Route::get('/group/{group}/image', 'Admin\GroupController@image')->name('group.image');
        Route::patch('/group/{group}/image', 'Admin\GroupController@image')->name('group.image.patch');

        // custom image route
        Route::get('/category/{category}/image', 'Admin\CategoryController@image')->name('category.image');
        Route::patch('/category/{category}/image', 'Admin\CategoryController@image')->name('category.image.patch');

        // order list
        Route::get('/order/index', 'Admin\OrderController@index')->name('admin.order.index');

        // group relation
        Route::get('/relation/{relation}/{type}/index', 'Admin\GroupRelationController@index')->name('admin.relation.index');
        Route::post('/relation/{relation}/{type}/store', 'Admin\GroupRelationController@store')->name('admin.relation.store');

        Route::get('/telegram/{product}/index', 'Admin\TelegramController@index')->name('admin.telegram.index');
        Route::post('/telegram/{product}/send', 'Admin\TelegramController@send')->name('admin.telegram.send');

        // setting
        Route::get('/settings', 'Admin\SettingController@index')->name('admin.settings');
        Route::post('/settings', 'Admin\SettingController@store')->name('admin.settings.store');

        // telegram group
        Route::get('/chat/groups', 'Admin\ChatGroupController@index')->name('admin.chat.groups');
        Route::delete('/chat/groups/{id}/destroy', 'Admin\ChatGroupController@destroy')->name('admin.chat.groups.destroy');
        Route::get('/chat/order/index', 'Admin\ChatOrderController@index')->name('admin.chat.order.index');
        Route::get('/chat/order/{order_id}/send', 'Admin\ChatOrderController@sendToTelegram')->name('admin.chat.order.send');
        Route::get('/chat/order/{order_id}/detail', 'Admin\ChatOrderController@detail')->name('admin.chat.order.detail');

        // price type
        Route::get('/priceType/index', 'Admin\PriceTypeController@index')->name('admin.priceType.index');
        Route::get('/priceType/create', 'Admin\PriceTypeController@create')->name('admin.priceType.create');
        Route::post('/priceType/store', 'Admin\PriceTypeController@store')->name('admin.priceType.store');
        Route::get('/priceType/{id}/edit', 'Admin\PriceTypeController@edit')->name('admin.priceType.edit');
        Route::patch('/priceType/{id}/update', 'Admin\PriceTypeController@update')->name('admin.priceType.update');
        Route::delete('/priceType/{id}/destroy', 'Admin\PriceTypeController@destroy')->name('admin.priceType.destroy');

        // price
        Route::get('/price/{id}/index', 'Admin\PriceController@index')->name('admin.price.index');
        Route::post('/price/{id}/set/price', 'Admin\PriceController@setPrice')->name('admin.price.setPrice');
    });
});


// ~~~~~~~~~~~~~~~~~~~ Firebase Auth ~~~~~~~~~~~~~~~~~~~

// Route::group(['prefix' => "firebase"], function() {

//     Route::get('/auth', function() {
//         return view('auth.firebase');
//     });

//     Route::get('/', 'Auth\FirebaseController@index');
//     Route::get('/check', 'Auth\FirebaseController@check');
//     Route::get('/create', 'Auth\FirebaseController@create');
//     Route::get('/success', 'Auth\FirebaseController@success');

// });
