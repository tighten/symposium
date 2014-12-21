<?php

Route::get('/', function () {
    return View::make('home');
});

Route::get('what-is-this', function () {
    return View::make('what-is-this');
});

Route::get('log-in', 'AuthController@getLogin');
Route::post('log-in', 'AuthController@postLogin');
Route::get('log-out', 'AuthController@logout');

Route::get('sign-up', 'AccountController@create');
Route::post('sign-up', 'AccountController@store');

Route::group(['before' => 'auth'], function () {
    Route::get('account', 'AccountController@show');
    Route::get('account/edit', 'AccountController@edit');
    Route::post('account/edit', 'AccountController@update');
    Route::get('account/delete', 'AccountController@delete');
    Route::post('account/delete', 'AccountController@destroy');

    // Necessary for GET-friendly delete because lazy
    Route::get('talks/{id}/delete', 'TalksController@destroy');

    // Necessary because IDK and please let's fix this @todo
    Route::post('talks/{id}', 'TalksController@update');

    Route::resource('talks', 'TalksController');

    // Necessary for GET-friendly delete because lazy
    Route::get('conferences/{id}/delete', 'ConferencesController@destroy');
    Route::resource('conferences', 'ConferencesController');
});
