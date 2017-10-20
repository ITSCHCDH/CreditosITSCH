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
    //return view('welcome');
    return view('auth.login');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



/****Rutas para el controlador de alumnos, con el group::resource, nos crean todas las rutas, para el controlador especificado*****/

Route::group(['prefix'=>'admin'],function(){

    Route::resource('alumnos','AlumnosController');

     //La siguiente nos crea la ruta para las
    Route::get('alumnos/{id}/destroy',[
        'uses'=>'AlumnosController@destroy',
        'as'=> 'admin.alumnos.destroy'
    ]);
});
/******************************/