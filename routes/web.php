<?php

/**
 * Public
 */
Route::get('/', function () {
    return view('home');
});

Route::get('what-is-this', function () {
    return view('what-is-this');
});

Route::get('speakers', [
    'as' => 'speakers-public.index',
    'uses' => 'PublicProfileController@index'
]);
Route::post('speakers', [
    'as' => 'speakers-public.search',
    'uses' => 'PublicProfileController@search'
]);
Route::get('u/{profileSlug}', [
    'as' => 'speakers-public.show',
    'uses' => 'PublicProfileController@show'
]);
Route::get('u/{profileSlug}/talks/{talkId}', [
    'as' => 'speakers-public.talks.show',
    'uses' => 'PublicProfileController@showTalk'
]);
Route::get('u/{profileSlug}/bios/{bioId}', [
    'as' => 'speakers-public.bios.show',
    'uses' => 'PublicProfileController@showBio'
]);
Route::get('u/{profileSlug}/email', [
    'as' => 'speakers-public.email',
    'uses' => 'PublicProfileController@getEmail'
]);
Route::post('u/{profileSlug}/email', [
    'as' => 'speakers-public.email',
    'uses' => 'PublicProfileController@postEmail'
]);

/**
 * App
 */
Route::get('log-out', ['as' => 'log-out', 'uses' => 'Auth\LoginController@logout']);

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('account', ['as' => 'account.show', 'uses' => 'AccountController@show']);
    Route::get('account/edit', ['as' => 'account.edit', 'uses' => 'AccountController@edit']);
    Route::put('account/edit', 'AccountController@update');
    Route::get('account/delete', ['as' => 'account.delete', 'uses' => 'AccountController@delete']);
    Route::post('account/delete', 'AccountController@destroy');
    Route::get('account/export', ['as' => 'account.export', 'uses' => 'AccountController@export']);

    Route::post('submissions', 'SubmissionsController@store');
    Route::delete('submissions', 'SubmissionsController@destroy');

    // Joind.in (@todo separate controller)
    Route::get('conferences/joindin/import/{eventId}', 'ConferencesController@joindinImport');
    Route::get('conferences/joindin/import', 'ConferencesController@joindinImportList');
    Route::get('conferences/joindin/all', 'ConferencesController@joindinImportAll');

    Route::get('conferences/{id}/favorite', 'ConferencesController@favorite');
    Route::get('conferences/{id}/unfavorite', 'ConferencesController@unfavorite');

    Route::get('calendar', ['as' => 'calendar.index', 'uses' => 'CalendarController@index']);

    // Necessary for GET-friendly delete because lazy
    Route::get('talks/{id}/delete', ['as' => 'talks.delete', 'uses' => 'TalksController@destroy']);
    Route::get('conferences/{id}/delete', ['as' => 'conferences.delete', 'uses' => 'ConferencesController@destroy']);
    Route::get('bios/{id}/delete', ['as' => 'bios.delete', 'uses' => 'BiosController@destroy']);

    Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);
    Route::get('archive', ['as' =>'talks.archived.index', 'uses' => 'TalksController@archiveIndex']);
    Route::get('talks/{id}/archive', ['as' => 'talks.archive', 'uses' => 'TalksController@archive']);
    Route::get('talks/{id}/restore', ['as' => 'talks.restore', 'uses' => 'TalksController@restore']);
    Route::resource('talks', 'TalksController');
    Route::resource('conferences', 'ConferencesController', [
        'except' => ['index', 'show']
    ]);
    Route::resource('bios', 'BiosController');
});

Route::get('conferences', ['as' => 'conferences.index', 'uses' => 'ConferencesController@index']);
Route::get('conferences/{id}', ['as' => 'conferences.show', 'uses' => 'ConferencesController@show']);

/**
 * OAuth
 */
Route::group(['middleware' => 'auth'], function () {
    Route::get('oauth/authorize', [
        'middleware' => ['check-authorization-params', 'auth'],
        'as' => 'get-oauth-authorize',
        'uses' => 'OAuthController@getAuthorize'
    ]);

    Route::post('oauth/authorize', [
        'middleware' => ['check-authorization-params', 'auth'],
        'as' => 'post-oauth-authorize',
        'uses' => 'OAuthController@postAuthorize'
    ]);
});

Route::post('oauth/access-token', [
    'as' => 'oauth-access-token',
    'uses' => 'OAuthController@postAccessToken'
]);
