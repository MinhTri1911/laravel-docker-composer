<?php

Route::group(['prefix' => 'approve', 'as' => 'approve'], function(){
   Route::get('/', "ApproveController@list");
});
