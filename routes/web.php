<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/products', 'ProductsController@index')->name('products');

Route::get('/cart', 'CartController@index')->name('cart');

Route::post('/cart', 'CartController@add');

Route::get('/cart/checkout', 'CartController@checkout')->name('checkout');

Route::post('/order/place', 'OrderController@place');

Route::get('/order/place', 'OrderController@place');

Route::delete('/cart', 'CartController@delete');

Route::get('/order', 'OrderController@index');
