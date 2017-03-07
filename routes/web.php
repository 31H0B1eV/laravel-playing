<?php

Auth::routes();

Route::get('/', 'AppController@index');
Route::get('/dashboard/{id}', 'HomeController@index')->name('home');

Route::post('/dashboard/{id}/update', 'ProfileController@update');

Route::group(['namespace' => 'Social', 'prefix' => 'social'], function() {
    Route::get('/login/{provider}', 'SocialController@login')->name('social.login');
    Route::get('/redirect/{provider}', 'SocialController@redirect')->name('social.redirect');
    Route::get('/forget/{provider}', 'SocialController@forget')->name('social.forget');
});
