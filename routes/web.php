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

Route::get('/test', function() {
    $user = \App\Models\User::find(25);
//
//    event(new \Illuminate\Auth\Events\Registered($user));


    $events = $user->events()->wherePivot('payed', '=', false)->get();
    \Illuminate\Support\Facades\Mail::to($user)->send(new \App\Mail\UserEventInvoice($user, $events));

    echo "oke";
});

Route::get('/{vue?}', 'PageController@index')
    ->name('index')
    ->where('vue', '[\/\w\.-]*');

Route::get('/confirm/{token}/{email}', 'PageController@index')
    ->name('password.reset');