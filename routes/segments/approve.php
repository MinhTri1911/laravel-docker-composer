<?php

Route::group(['middleware' => 'auth', 'prefix' => 'approve', 'as' => 'approve'], function(){
   Route::get('/', "ApproveController@showHomeApprove")->name('.list');
   Route::post('/', "ApproveController@showHomeApprove")->name('.list.search');
   
   Route::get('/show-detail', "ApproveController@showDetailApprove")->name('.detail');
   
   Route::post('/accept-approve', "ApproveController@acceptApprove")->name('.approve');
   
   Route::post('/reject-approve', "ApproveController@rejectApprove")->name('.reject');
});
