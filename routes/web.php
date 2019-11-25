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
    return redirect()->route('products.index');
});

Route::namespace('web')->group(function () {

    Route::get('register', 'UserController@getRegister');
    Route::post('register', 'UserController@register');
    Route::get('login', 'UserController@getLogin')->name('login');
    Route::post('login', 'UserController@login');

    Route::resource('products', 'ProductController');


    Route::group(['middleware' => 'auth'], function () {

        Route::get('logout', 'UserController@logout');

        Route::post('add-item-to-order', 'OrderController@addItemToOrder')->name('addItemToOrder');
        Route::post('close-order', 'OrderController@closeOrder')->name('closeOrder');

        Route::get('cart', 'OrderController@getOrderItems')->name('getCart');
    });
});

