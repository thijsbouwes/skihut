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
    Route::get('/user', 'UserResource@show');

    // users
    Route::group(['prefix' => 'users'], function() {
        Route::get('/', 'UserResource@index');
        Route::post('/', 'UserResource@register');
    });

    // Product
    Route::group(['prefix' => 'products'], function() {
        Route::get('/', 'ProductResource@index');
        Route::get('/{product}', 'ProductResource@show');
        Route::delete('/{product}', 'ProductResource@destroy');
        Route::patch('/{product}', 'ProductResource@update');
        Route::post('/', 'ProductResource@store');

        // Product Stock
        Route::get('/{product}/stocks', 'StockResource@index');
        Route::post('/{product}/stocks', 'StockResource@store');
        Route::get('/stocks/{stock}', 'StockResource@show');
        Route::delete('/stocks/{stock}', 'StockResource@destroy');
        Route::patch('/stocks/{stock}', 'StockResource@update');
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
