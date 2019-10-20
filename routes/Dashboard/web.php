<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(

    // Use language in url
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ],
    function(){

        Route::prefix('dashboard')->name('dashboard.')->middleware(['auth'])->group(function() {

            Route::get('/', 'DashboardController@index')->name('index');

            // category routes
            Route::resource('categories', 'CategoryController')->except(['show']);

            // Product routes
            Route::resource('products', 'ProductController')->except(['show']);

            // Client routes
            Route::resource('clients', 'ClientController')->except(['show']);
            Route::resource('clients.orders', 'Client\OrderController')->except(['show']);

            //order routes
            Route::resource('orders', 'OrderController');
//            Route::get('orders/{order}/products', 'OrderController@products')->name('orders.products');

            // user routes
            Route::resource('users', 'UserController')->except(['show']);


        });
});








//
