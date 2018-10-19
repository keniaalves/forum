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
    return view('welcome');
});
Auth::routes();

/**
 * Rotas que passam um parâmetro pela url precisam ficar mais embaixo na
 *lista de rotas, pois rotas 'normais' podem ser confundidas com as que
 *passam parâmetro. Tipo isso... :/
 */

Route::get('/home', 'HomeController@index');
Route::get('/threads', 'ThreadsController@index');
Route::get('/threads/create', 'ThreadsController@create');
Route::post('/threads', 'ThreadsController@store')->name('threadStore');
Route::get('/threads/{channel}/{thread}', 'ThreadsController@show');
Route::delete('/threads/{channel}/{thread}', 'ThreadsController@destroy');
Route::get('/threads/{channel}', 'ThreadsController@index');
Route::post('replies/{reply}/favorites', 'FavoritesController@store');
Route::delete('/replies/{reply}', 'RepliesController@destroy');
Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store');

Route::get('/profiles/{user}', 'ProfilesController@show')->name('profile');
