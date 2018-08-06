<?php

/**
 * Router for function tax
 *
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *
 * @author Rikkei.Quangpm
 * @date 2018/08/03
*/

Route::group(['middleware' => 'auth', 'prefix' => 'tax', 'as' => 'tax.'], function () {

    // Index tax
    Route::get('/', 'TaxController@index')->name('index');
});

