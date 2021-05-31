<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Clients',
    'middleware' => 'auth'
], function () {
    Route::group([
        'namespace' => 'Product',
    ], function () {
        Route::apiResource('products', 'ProductController')->except('index', 'create', 'edit');
        Route::post('like/{id}', 'ProductController@like');
        Route::post('addReview', 'ProductController@addReview');
        Route::post('wishlist/{id}', 'ProductController@wishlist');
    });

    Route::post('order', 'Order\OrderController@store');
});

Route::post('payment/{provider}', 'Order\OrderController@payment');
Route::post('payment/{provider}/{status}/{order}', 'Order\OrderController@getStatusForPayment');

