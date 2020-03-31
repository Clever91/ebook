<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['prefix' => 'v1'], function() {
    
    Route::group(['prefix' => 'device'], function() {
        Route::post('register', 'API\DeviceController@register');
        Route::post('check', 'API\DeviceController@check');
        Route::delete('delete', 'API\DeviceController@delete');
        Route::post('languages', 'API\DeviceController@languages');
    });
    
    Route::group(['prefix' => 'home'], function() {
        Route::post('store', 'API\HomeController@store');
    });

    Route::group(['prefix' => 'category'], function() {
        Route::post('category_list', 'API\CategoryController@categories');
    });

    Route::group(['prefix' => 'product'], function() {
        Route::post('product_list', 'API\ProductController@products');
        Route::post('product_info', 'API\ProductController@product');
    });

    Route::group(['prefix' => 'author'], function() {
        Route::post('author_list', 'API\AuthorController@authors');
        Route::post('author_info', 'API\AuthorController@author');
    });

    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });
    
});
