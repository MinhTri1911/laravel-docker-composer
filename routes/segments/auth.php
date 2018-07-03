<?php

/**
 * Authentication Routes
 * Register the typical authentication routes for an application
 */

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
