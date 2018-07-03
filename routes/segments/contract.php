<?php

Route::group(['middleware' => 'auth', 'prefix' => 'contract', 'as' => 'contract'], function() {
   Route::get('/create', 'ContractController@create') ;
   Route::get('/{id}/edit', 'ContractController@edit') ;
   Route::get('/{id}/restore', 'ContractController@restore') ;
});
