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

Route::group(['middleware' => 'auth'], function () {
    Route::get('account', 'AccountController@show');
    Route::get('account/edit', 'AccountController@edit');
    Route::post('account/edit', 'AccountController@update');
    Route::get('account/delete', 'AccountController@delete');
    Route::post('account/delete', 'AccountController@destroy');

    Route::post('submissions', 'SubmissionsController@store');
    Route::delete('submissions', 'SubmissionsController@destroy');

    // Joind.in (@todo separate controller)
    Route::get('conferences/joindin/import/{eventId}', 'ConferencesController@joindinImport');
    Route::get('conferences/joindin/import', 'ConferencesController@joindinImportList');
    Route::get('conferences/joindin/all', 'ConferencesController@joindinImportAll');

    Route::get('conferences/{id}/favorite', 'ConferencesController@favorite');
    Route::get('conferences/{id}/unfavorite', 'ConferencesController@unfavorite');

    Route::get('talks/{talkId}/versions/{versionId}', 'TalkVersionsController@show');
    Route::get('talks/{talkId}/versions/{versionId}/delete', 'TalkVersionsController@destroy');
    Route::get('talks/{talkId}/versions/{versionId}/edit', 'TalkVersionsController@edit');
    Route::post('talks/{talkId}/versions/{versionId}/update', 'TalkVersionsController@update');
    Route::get('talks/{talkId}/versions/{versionId}/{revisionId}', 'TalkVersionsController@showRevision');

    // Necessary for GET-friendly delete because lazy
    Route::get('talks/{id}/delete', 'TalksController@destroy');
    Route::get('conferences/{id}/delete', 'ConferencesController@destroy');

    Route::get('talks/{id}/createVersion', 'TalkVersionsController@create');
    Route::post('talks/{id}/storeVersion', 'TalkVersionsController@store');

    // Necessary because IDK and please let's fix this @todo
    Route::post('talks/{id}', 'TalksController@update');
    Route::post('conferences/{id}', 'ConferencesController@update');

    Route::resource('talks', 'TalksController');
    Route::resource('conferences', 'ConferencesController');
});
