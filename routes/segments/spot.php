<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


Route::group(['middleware' => 'auth', 'prefix' => 'spot', 'as' => 'spot'], function() {
   Route::get('/{idShip}/create', 'SpotController@initCreate')->name('.init.create') ;
   Route::post('/search/amount', 'SpotController@searchAmount')->name('.search.amount') ;
   Route::post('/create', 'SpotController@create')->name('.create') ;
});
