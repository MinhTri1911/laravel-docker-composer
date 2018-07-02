<?php

Route::group(['prefix' => 'user', 'as' => 'user.'], function(){
    // Home page of user
    Route::get('/', "UserController@index")->name('list'); 
    
    Route::get('/preview-pdf', "UserController@previewPDF")->name('preview-pdf'); 
    Route::get('/print-pdf', "UserController@printPDF")->name('print-pdf'); 
    Route::get('/stream-pdf', "UserController@displayBrownserPDF")->name('stream-pdf'); 
    Route::get('/stream-pdf-2', "UserController@displayBrownserPDF_2")->name('stream-pdf-2'); 
    Route::get('/stream-pdf-3', "UserController@displayBrownserPDF_3")->name('stream-pdf-3'); 
});