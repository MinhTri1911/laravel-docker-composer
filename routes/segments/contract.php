<?php

Route::group(['middleware' => 'auth', 'prefix' => 'ship', 'as' => 'contract'], function() {
   Route::get('/{idShip}/contract/create', 'ContractController@initCreate')->name('.init.create') ;
   Route::post('/contract/create', 'ContractController@create')->name('.create') ;
   
   Route::get('/{idShip}/edit', 'ContractController@edit')->name('.edit');
   Route::get('/{idShip}/restore', 'ContractController@restore')->name('.restore') ;
});
