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



Route::post('save_file','FileController@save')->name('save.file');
Route::post('delete_file','FileController@delete')->name('delete.file');
Route::get('history','FileController@history')->name('load.history');
Route::get('/','FileController@index')->name('load.index');
