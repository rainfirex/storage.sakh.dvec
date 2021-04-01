<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('/entity')->group(function () {

    Route::prefix('/users')->group(function () {

        Route::put('{id}', 'ControllerEntityUser@update');

        Route::get('count-page', 'ControllerEntityUser@count');

        Route::get('page-{page}', 'ControllerEntityUser@index');

        Route::post('', 'ControllerEntityUser@store');

        Route::get('{id}', 'ControllerEntityUser@show');

        Route::get('find/{text}/page-{page}', 'ControllerEntityUser@find');

        Route::delete('{id}', 'ControllerEntityUser@delete');

    });

    Route::prefix('/computers')->group(function () {

        Route::delete('{id}', 'ControllerEntityComputer@delete');

    });

    Route::prefix('/passwords')->group(function () {

        Route::delete('{id}', 'ControllerEntityPassword@delete');

    });

});

Route::prefix('/auth')->group(function () {

    Route::post('/login', 'ControllerAuth@login');

    Route::post('/logout', 'ControllerAuth@logout');

    Route::get('/find/{username}', 'ControllerAuth@find');
});
