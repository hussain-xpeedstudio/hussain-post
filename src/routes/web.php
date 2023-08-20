<?php
Route::group(['namespace'=>'Hussain\Post\Http\Controllers'],function(){
    Route::get('/post', 'PostController@index');
    Route::post('/post', 'PostController@store')->name('post.store');
    Route::post('/edit-post/{id}', 'PostController@store')->name('post.edit');
    Route::post('/delete-post/{id}', 'PostController@store')->name('post.delete');
});

