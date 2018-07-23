<?php

Route::group(['middleware' => 'auth', 'prefix' => 'nation', 'as' => 'nation.'], function() {
    Route::get('/search', 'NationController@searchAjax')->name('search');
});
