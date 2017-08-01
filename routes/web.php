<?php

Route::get('/', 'HomePageController@index')->name('homepage');

Route::get('/video/{id}/{hash}', 'IframeController@show')->name('show_video');

Auth::routes();

Route::group(['middleware' => 'auth', 'namespace' => 'Panel', 'prefix' => 'user'], function () {
    Route::get('/home', 'HomeController@index')->name('dashboard');

    Route::get('/profile', 'ProfileController@edit')->name('edit_profile');
    Route::put('/profile', 'ProfileController@update')->name('update_profile');

    Route::resource('video-settings', 'VideoSettingsController');

    Route::get('/videos', 'VideoController@list_videos')->name('list_videos');
    Route::get('/upload-video', 'VideoController@create')->name('upload_video');
    Route::post('/upload-video', 'VideoController@store')->name('store_video');
    Route::get('/video-details/{id}', 'VideoController@show')->name('video_details');
    Route::put('/update-video/{id}', 'VideoController@update')->name('update_video');
    Route::delete('/delete-video/{video_id}', 'VideoController@destroy')->name('delete_video');
});

Route::group(['middleware' => 'admin', 'namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::get('/admin_commands', 'AdminController@dashboard');
    Route::get('/delete_storage', 'AdminCommands@delete_storage')->name('delete_storage');

});
