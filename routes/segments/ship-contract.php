<?php

Route::group(['prefix' => 'ship/contract', 'as' => 'ship.contract'], function(){
   Route::get('/{id?}/detail', 'ShipContractController@detail')->name('.detail') ;
});
