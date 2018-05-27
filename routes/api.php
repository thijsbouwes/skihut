<?php
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

// password reset routes
Route::group(['namespace' => 'Auth', 'prefix' => 'password'], function() {
    Route::post('/email', 'ForgotPasswordController@sendResetLinkEmailApi');
    Route::post('/reset', 'ResetPasswordController@resetApi');
});

Route::group(['namespace' => 'Api'], function() {
    // Status
    Route::get('/', 'StatusController');
});

Route::group(['namespace' => 'Api', 'middleware' => 'auth:api'], function() {
    // User
    Route::get('/user/{user_id?}', 'UserResource@show');
});

// admin routes
Route::group(['namespace' => 'Api', 'middleware' => ['auth:api', 'auth.admin']], function() {
    // Dashboard
    Route::get('/dashboard', 'DashboardController@index');

    // users
    Route::group(['prefix' => 'users'], function() {
        Route::get('/', 'UserResource@index');
        Route::post('/', 'UserResource@register');

        Route::get('/debt', 'UserResource@indexDebt');
    });

    // Product
    Route::group(['prefix' => 'products'], function() {
        Route::get('/', 'ProductResource@index');
        Route::get('/{product}', 'ProductResource@show');
        Route::delete('/{product}', 'ProductResource@destroy');
        Route::patch('/{product}', 'ProductResource@update');
        Route::post('/', 'ProductResource@store');

        Route::get('/stock', 'ProductResource@indexWithStock');
    });

    // Stock
    Route::group(['prefix' => 'stocks'], function() {
        Route::get('/', 'StockResource@index');
        Route::post('/', 'StockResource@store');
        Route::get('/{stock}', 'StockResource@show');
        Route::delete('/{stock}', 'StockResource@destroy');
        Route::patch('/{stock}', 'StockResource@update');
    });

    // Event
    Route::group(['prefix' => 'events'], function() {
        Route::get('/', 'EventResource@index');
        Route::get('/{event}', 'EventResource@show');
        Route::delete('/{event}', 'EventResource@destroy');
        Route::patch('/{event}', 'EventResource@update');
        Route::post('/', 'EventResource@store');
    });
});
