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

Route::group([ 'prefix' => 'billing', 'as' => 'billing.'], function () {

    // Index create billing
    Route::get('/', 'BillingPaperController@index')->name('create.billing.paper');
    Route::get('/search', 'BillingPaperController@searchBillingPaper')->name('search.billing.paper');
    Route::post('/create', 'BillingPaperController@createBillingPaper')->name('create.billing.paper');
    Route::post('/delivery', 'BillingPaperController@deliveryBillingPaper')->name('delivery.billing.paper');
    Route::post('/export', 'BillingPaperController@exportBillingPaper')->name('export.billing.paper');

    // History billing
    Route::get('/history', 'HistoryBillingController@index')->name('history.billing');

    // Statistic billing
    Route::get('/statistic', 'StatisticBillingController@index')->name('statistic.billing');

    // Preview billing
    Route::get('/preview', 'BillingPaperController@previewBillingPaper')->name('preview.billing.paper');
});

Route::group(['middleware' => 'auth', 'prefix' => 'billing-method','as' => 'billing.method.'], function () {
    Route::get('/{id}', 'BillingMethodCompanyController@show')->name('show');
    Route::post('/update', 'BillingMethodCompanyController@update')->name('update');
});
