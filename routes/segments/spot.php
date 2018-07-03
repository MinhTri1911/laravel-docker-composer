<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Route::group(['middleware' => 'auth'], function() {
    Route::resource('/spot', 'SpotController', ['only' => ['create', 'edit']]);
});
