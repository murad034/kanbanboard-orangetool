<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/', 'KanbanBoardController@index')->name('index');
Route::post('store', 'KanbanBoardController@store')->name('store');
Route::post('status_update', 'KanbanBoardController@status_update')->name('status_update');
