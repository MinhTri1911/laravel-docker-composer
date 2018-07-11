<?php

Route::group(['middleware' => 'auth', 'prefix' => 'search/service', 'as' => 'search.service'], function() {
    
    Route::post('/init', "SearchServiceController@index")->name('service.init');
    Route::post('/search', "SearchServiceController@search")->name('service.search');
    
});
