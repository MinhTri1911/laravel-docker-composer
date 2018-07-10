<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Route::group(['middleware' => 'auth'], function() {
    Route::resource('/ship', 'ShipController', [
        'only' => ['index', 'create'],
        'middleware' => [
            'index' => 'prevent-history',
        ],
    ]);

    Route::group(['prefix' => 'ship', 'as' => 'ship.'], function () {
        Route::get('/filter', 'ShipController@filterShip')->name('filter');
        Route::get('/create-ship-contract', 'ShipController@createShipContract')->name('createShipContract');

        Route::get('/{id}/edit', 'ShipController@edit')->name('edit');

    });
});
