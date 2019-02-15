<?php

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('me', 'MeController@index');
    Route::get('bios/{bioId}', 'BiosController@show');
    Route::get('user/{userId}/bios', 'UserBiosController@index');
    Route::get('talks/{talkId}', 'TalksController@show');
    Route::get('user/{userId}/talks', 'UserTalksController@index');
    Route::get('conferences/{id}', 'ConferencesController@show');
    Route::get('conferences', 'ConferencesController@index');
});
