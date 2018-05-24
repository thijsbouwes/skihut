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

Route::get('/mailable', function () {
    $user = \App\Models\User::find(1);

    $events = $user->events()->where('payed_date', '=', null)->get();

    return new App\Mail\UserEventInvoice($user, $events);
});

Route::get('/{vue?}', 'PageController@index')
    ->name('index')
    ->where('vue', '[\/\w\.-]*');

Route::get('/confirm/{token}/{email}', 'PageController@index')
    ->name('password.reset');