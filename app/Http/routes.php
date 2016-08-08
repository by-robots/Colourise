<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// If the user is logged in send them to the dashboard.
// If the user is a guest send them to the login page.
Route::get('/', function () {
    if (Auth::guest()) {
        return redirect('/login');
    }

    return redirect('/dashboard');
});

Route::auth();

// ---------- The dashboard
Route::get('dashboard', [
    'middleware' => 'auth',
    'uses'       => 'DashboardController@show',
]);

// ---------- Colourisations
Route::get('colourisations/new', [
    'middleware' => 'auth',
    'uses'       => 'ColourisationController@create',
]);

Route::post('colourisations', [
    'middleware' => 'auth',
    'uses'       => 'ColourisationController@store',
    'before'     => 'csrf',
]);
