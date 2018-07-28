<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Route::group(['middleware' => 'auth', 'prefix' => 'currency', 'as' => 'currency.'], function() {
    Route::get('/search', 'CurrencyController@search')->name('search');
});
