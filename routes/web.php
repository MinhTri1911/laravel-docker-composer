<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return redirect()->route('user.list');
});

// Require if want to split file route to sub multiple file
//require(app_path() . '/routes/admin.php');

foreach ( File::allFiles(__DIR__.'/segments') as $partial )
{
    require $partial->getPathname();
}

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
