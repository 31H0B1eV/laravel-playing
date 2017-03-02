<?php

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::group(['prefix' => 'service'], function() {
    Route::get('/authorize_vk', 'HomeController@authorize_vk')->name('vk');
    Route::get('/forget_vk', 'HomeController@forget')->name('vk_forget');
    Route::get('/redirect', 'HomeController@redirect')->name('redirect');
});
