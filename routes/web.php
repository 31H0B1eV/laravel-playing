<?php

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::group(['namespace' => 'Social', 'prefix' => 'service'], function() {
    Route::get('/avk', 'VkController@oauth2')->name('vk_authorize');
    Route::get('/fvk', 'VkController@forget')->name('vk_forget');
    Route::get('/rvk', 'VkController@redirect')->name('vk_redirect');
});
