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

//Auth::routes();

Route::get('/test-reset', function() {
    //$this->validateEmail($request);

    // We will send the password reset link to this user. Once we have attempted
    // to send the link, we will examine the response then see the message we
    // need to show to the user. Finally, we'll send out a proper response.
    $response = \Illuminate\Support\Facades\Password::broker()->sendResetLink(['email' => 'info@computer4life.nl']);
    dd($response);

    return $response == Password::RESET_LINK_SENT
        ? $this->sendResetLinkResponse($response)
        : $this->sendResetLinkFailedResponse($request, $response);
});

// password reset routes
Route::group(['namespace' => 'Auth', 'prefix' => 'password'], function() {
    Route::post('/email', 'ForgotPasswordController@sendResetLinkEmail');
    Route::post('/reset', 'ResetPasswordController@reset');
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
