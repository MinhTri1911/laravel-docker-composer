<?php

Route::group(['middleware' => 'auth', 'prefix' => 'ship/contract', 'as' => 'ship.contract'], function() {
   Route::get('/{id?}/detail', 'ShipContractController@detail')->name('.detail') ;
});
