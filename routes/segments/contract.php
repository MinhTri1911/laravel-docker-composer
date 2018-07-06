<?php

Route::group(['middleware' => 'auth', 'prefix' => 'contract', 'as' => 'contract'], function() {
   Route::get('/create', 'ContractController@create')->name('.create') ;
   Route::get('/{id}/edit', 'ContractController@edit')->name('.edit');
   Route::get('/{id}/restore', 'ContractController@restore')->name('.restore') ;
});
