<?php

Route::group(['middleware' => 'auth', 'prefix' => 'approve', 'as' => 'approve'], function(){
   Route::get('/', "ApproveController@list");
});
