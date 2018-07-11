<?php

Route::group(['middleware' => 'auth', 'prefix' => 'search/ship', 'as' => 'search.ship'], function() {
    
    Route::post('/init', "SearchShipController@index")->name('ship.init');
    Route::post('/search', "SearchShipController@search")->name('ship.search');
    
});
