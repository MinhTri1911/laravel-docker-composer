<?php

Route::group(['middleware' => 'auth', 'prefix' => 'ship/contract', 'as' => 'ship.contract'], function() {
   Route::get('/{id?}/detail', 'ShipContractController@detail')->name('.detail');
   Route::post('/restore-contract', 'ShipContractController@restoreContract')->name('.restore');
   Route::post('/disable-contract', 'ShipContractController@disableContract')->name('.disable');
   Route::post('/delete-contract', 'ShipContractController@deleteContract')->name('.delete');

   Route::post('/delete-spot', 'ShipContractController@deleteSpot')->name('.spot.delete');

   Route::get('/view-reason', 'ShipContractController@getReasonReject')->name('.item.reason');

   Route::post('/delete-ship', 'ShipContractController@deleteShip')->name('.delete-ship');
});
