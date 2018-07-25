<?php

Route::group(['middleware' => 'auth', 'prefix' => 'ship', 'as' => 'contract'], function() {
   Route::get('/{idShip}/contract/create', 'ContractController@initCreate')->name('.init.create') ;
   Route::post('/contract/create', 'ContractController@create')->name('.create') ;
   
   Route::get('/{idShip}/contract/{idContract}/edit', 'ContractController@edit')->name('.edit');
   Route::put('/{idShip}/contract/{idContract}/edit', 'ContractController@update')->name('.update');
   
   Route::get('/{idShip}/restore', 'ContractController@restore')->name('.restore') ;
});
