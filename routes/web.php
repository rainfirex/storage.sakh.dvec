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

Route::get('/testdb', function () {
    if (DB::connection()->getDatabaseName()) {
        return 'Есть соединение!';
    }
    else {
        return 'Нет соединения';
    }
});

Route::view('{path}', 'view')->where('path', '([A-z\d-\/_.]+)?');
