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
use Illuminate\Support\Facades\Route;

Route::get('/','FullCalendarController@index')->name('index');

//para cargar los eventos desde la BD
Route::get('/load-events', 'EventController@routeLoadEvents')->name('routeLoadEvents');

//prueba filtrado ///////////////////////////////////////////////////////////////////////////////////////////////////////
Route::get('/load-events-filtered', 'EventController@routeLoadEventsFiltered')->name('routeLoadEventsFiltered');

//para hacer update en eventos
Route::put('/event-update', 'EventController@update')->name('routeEventUpdate');

// para inserts
Route::post('/event-store', 'EventController@store')->name('routeEventStore');

//deletes
Route::delete('/event-delete', 'EventController@delete')->name('routeEventDelete');


// actividades

Route::delete('/fast-event-delete', 'FastEventController@delete')->name('routeFastEventDelete');

Route::put('/fast-event-update', 'FastEventController@update')->name('routeFastEventUpdate');

Route::post('/fast-event-store', 'FastEventController@store')->name('routeFastEventStore');


// usuarios

Route::post('/usuario-store', 'UsuariosController@store')->name('routeUsuarioStore');
