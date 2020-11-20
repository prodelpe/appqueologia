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

Route::get('/', function () {
    //return view('welcome');
    return redirect('app/excavacio/all');
});

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['namespace' => 'App', 'prefix' => 'app', 'middleware' => 'auth'], function () {

    Route::group(['prefix' => 'excavacio'], function () {

        Route::get('/all', 'ExcavacioController@index')->name('app.excavacio.all');
        //Route::get('/show/{id}', 'ExcavacioController@show')->name('app.excavacio.show');
        Route::get('/create', 'ExcavacioController@create')->name('app.excavacio.create');
        Route::post('/store', 'ExcavacioController@store')->name('app.excavacio.store');
        Route::get('/edit/{id}', 'ExcavacioController@edit')->name('app.excavacio.edit');
        Route::post('/update/{id}', 'ExcavacioController@update')->name('app.excavacio.update');
        Route::get('/delete/{id}', 'ExcavacioController@delete')->name('app.excavacio.delete');
        Route::get('/pdfexcavacio/{id}', 'PdfExcavacioController@index')->name('app.excavacio.pdf');

        Route::group(['prefix' => '{excavacio_id}/ue'], function () {

            Route::get('/all', 'UEController@index')->name('app.ue.all');
            Route::get('/show/{id}', 'UEController@show')->name('app.ue.show');
            Route::get('/create', 'UEController@create')->name('app.ue.create');
            Route::post('/store', 'UEController@store')->name('app.ue.store');
            Route::get('/edit/{id}', 'UEController@edit')->name('app.ue.edit');
            Route::post('/update/{id}', 'UEController@update')->name('app.ue.update');
            Route::get('/delete/{id}', 'UEController@delete')->name('app.ue.delete');
            Route::get('/pdfue/{id}', 'PdfUeController@index')->name('app.ue.pdf');
        });
    });
});
