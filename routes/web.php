<?php

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::group(['prefix' => 'service'], function() {
    Route::get('/authorize_vk', 'HomeController@authorize_vk')->name('vk');
    Route::get('/redirect', 'HomeController@redirect')->name('redirect');
});
