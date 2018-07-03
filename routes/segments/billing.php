<?php

/**
 * Router for function billing
 * 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *
 * @author quangpm
 * @date 2018/06/19
*/

Route::group(['middleware' => 'auth', 'prefix' => 'billing', 'as' => 'billing.'], function () {
    Route::get('/', 'BillingPaperController@index')->name('create.billing.paper');
    Route::get('/history', 'HistoryBillingController@index')->name('history.billing');
    Route::get('/statistic', 'StatisticBillingController@index')->name('statistic.billing');
    Route::get('/preview', 'BillingPaperController@previewBillingPaper')->name('preview.billing.paper');
});
