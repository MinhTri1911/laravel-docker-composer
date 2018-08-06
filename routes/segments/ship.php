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
        Route::get('/create-ship-contract', 'ShipContractController@create')->name('contract.create');
        Route::post('/create-ship-contract', 'ShipContractController@store')->name('contract.store');

        Route::get('/{id}/edit', 'ShipController@showEdit')->name('edit');
        Route::post('/{id}/edit', 'ShipController@edit')->name('update');
        Route::get('/create', 'ShipController@showCreate')->name('create');
        Route::post('/create', 'ShipController@create')->name('create');

        Route::post('/check-create-exist', 'ShipController@checkExistCreateShipData')->name('check.exists.data');
        Route::post('/check-edit-exist', 'ShipController@checkExistEditShipData');
    });
});
