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

Route::get('/', 'MoviesController@index');
Route::get('/movie/{id}', 'MoviesController@show')->name('movie')->middleware('auth');
Route::get('/search', 'MoviesController@search')->name('search');
Route::post('/comment-add', 'MoviesController@storeComment')->name('comment-add');
Route::post('/search-films', 'MoviesController@searchFilms')->name('search-films');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
