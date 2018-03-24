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
})->name('login');
/* Agregamos la ruta al html para listar los resposables de una actividad
+*/
Route::get('/admin/actividades/{id}/responsables','ResponsablesController@show', function(){
    /* Ruta del html responsables (responsableshow) **/
    return view('admin.actividades.responsableshow');
})->name('responsables'); /* Le asignamos un nombre a la ruta para facilitar su uso **/

/* Ruta para listar y asignar resposables a una actividad */
Route::get('/admin/actividades/{id}/responsables/asignar','ResponsablesController@index', function(){
    /* Ruta del html responsables (responsableshow) **/
    return view('admin.actividades.responsablesindex');
})->name('responsables.index'); /* Le asignamos un nombre a la ruta para facilitar su uso **/


Route::get('/home', 'HomeController@index')->name('home');



/****Rutas para el controlador de alumnos, con el group::resource, nos crean todas las rutas, para el controlador especificado*****/

Route::group(['prefix'=>'admin'],function(){

    Route::resource('alumnos','AlumnosController');

    //La siguiente nos crea las rutas para el controlador de alumnos
    Route::get('alumnos/{id}/destroy',[
        'uses'=>'AlumnosController@destroy',
        'as'=> 'admin.alumnos.destroy'
    ]);

    /****Rutas para el controlador de creditos*****/
    Route::resource('creditos','CreditosController');

    //La siguiente nos crea las rutas para el controlador de creditos(Bajas)
    Route::get('creditos/{id}/destroy',[
        'uses'=>'CreditosController@destroy',
        'as'=> 'admin.creditos.destroy'
    ]);

    /****Rutas para el controlador de actividades*****/
    Route::resource('actividades','ActividadesController');

    //La siguiente nos crea las rutas para el controlador de actividades(Bajas)
    Route::get('actividades/{id}/destroy',[
        'uses'=>'ActividadesController@destroy',
        'as'=> 'admin.actividades.destroy'
    ]);

    /****Rutas para el controlador de participantes*****/
    Route::resource('participantes','ParticipantesController');

    //La siguiente nos crea las rutas para el controlador de participantes(Bajas)
    Route::get('participantes/{id}/destroy',[
        'uses'=>'ParticipantesController@destroy',
        'as'=> 'admin.participantes.destroy'
    ]);

    /****Rutas para el controlador de evidencias*****/
    Route::resource('evidencias','EvidenciasController');

    //La siguiente nos crea las rutas para el controlador de evidencias(Bajas)
    Route::get('evidencias/{id}/destroy',[
        'uses'=>'EvidenciasController@destroy',
        'as'=> 'admin.evidencias.destroy'
    ]);
    /****Rutas para el controlador de actividad_evidencia *****/
    Route::resource('actividad_evidencias','Actividad_EvidenciasController');
    Route::get('actividad_evidencias/{id}/destroy',[
        'uses'=>'Actividad_EvidenciasController@destroy',
        'as'=> 'actividad_evidencias.destroy'
    ]);
});
/******************************/

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

