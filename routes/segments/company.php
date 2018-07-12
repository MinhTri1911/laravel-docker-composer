<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Route::group(['middleware' => 'auth'], function() {
    Route::resource('/company', 'CompanyController', [
        'only' => ['index', 'create', 'edit'],
        'middleware' => [
            'index' => 'prevent-history',
        ],
    ]);

    Route::group(['prefix' => 'company', 'as' => 'company.'], function () {
        Route::get('/search', 'CompanyController@searchCompany')->name('search');
        Route::get('/filter', 'CompanyController@filterCompany')->name('filter');
        Route::get('/show/{id}', 'CompanyController@show')->name('show');
        Route::get('/show-popup', 'CompanyController@detail')->name('detail');
    });

    Route::group(['prefix' => 'company-service', 'as' => 'company.service.'], function () {
        Route::get('/show-popup-all-service', 'CompanyServiceController@index')->name('index');
        Route::get('/show-popup-add-service', 'CompanyServiceController@create')->name('create');
        Route::post('/add-service', 'CompanyServiceController@store')->name('store');
        Route::get('/confirm-delete-service/{name}/{id}', 'CompanyServiceController@confirmDeleteServiceInAllShip')
            ->name('confirmDelete');
        Route::post('/delete-service', 'CompanyServiceController@delete')->name('delete');

    });
});
