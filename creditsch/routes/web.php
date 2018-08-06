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

Route::group(['prefix'=>'admin', 'middleware' => 'auth'],function(){

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

    /****Rutas para el controlador de usuarios *****/
    Route::get('usuarios/{id}/asignar_roles','UsersController@asignarRoles')->name('usuarios.asignar_roles');
    Route::post('usuarios/guardar_roles','UsersController@guardarRoles')->name('usuarios.guardar_roles');
    Route::resource('usuarios','UsersController');

    //La siguiente nos crea las rutas para el controlador de actividades(Bajas)
    Route::get('usuarios/{id}/destroy',[
        'uses'=>'UsersController@destroy',
        'as'=> 'admin.usuarios.destroy'
    ]);

    //Ruta y metodo para la peticion al servidor mediante Ajax, el cual tendra como funcion consultar los participantes asignado a una evidencia
    Route::get('participantes/busqueda','ParticipantesController@participantesBusqueda')->name('participantes.busqueda');
    Route::get('participantes/peticion','ParticipantesController@peticionAjax')->name('participantes.peticion');
    Route::post('participantes/guardar','ParticipantesController@ajaxGuardar')->name('participantes.guardar');
    Route::get('participantes/actividad/responsables','ParticipantesController@peticionAjaxResponsables')->name('participantes.actividad_responsables');
    /****Rutas para el controlador de participantes*****/
    Route::resource('participantes','ParticipantesController');

    //La siguiente nos crea las rutas para el controlador de participantes(Bajas)
    Route::get('participantes/{id}/destroy',[
        'uses'=>'ParticipantesController@destroy',
        'as'=> 'admin.participantes.destroy'
    ]);

    //Ruta y metodo para las peticiones al servidor mediante Ajax
    Route::get('evidencias/galeria','EvidenciasController@peticionGaleria')->name('evidencias.galeria');
    Route::get('evidencias/peticion','EvidenciasController@peticionAjax')->name('evidencias.peticion');
    Route::get('evidencias/eliminar','EvidenciasController@peticionEliminar')->name('evidencias.eliminar');
    /****Rutas para el controlador de evidencias*****/
    Route::resource('evidencias','EvidenciasController');

    //La siguiente nos crea las rutas para el controlador de evidencias(Bajas)
    Route::get('evidencias/{id}/destroy',[
        'uses'=>'EvidenciasController@destroy',
        'as'=> 'admin.evidencias.destroy'
    ]);
    /****Rutas para el controlador de actividad_evidencia *****/
    Route::post('actividad_evidencias/asignar_responsables','Actividad_EvidenciasController@asignarResponsables')->name('actividad_evidencias.asignar_responsables');
    Route::resource('actividad_evidencias','Actividad_EvidenciasController');
    Route::get('actividad_evidencias/{id}/destroy',[
        'uses'=>'Actividad_EvidenciasController@destroy',
        'as'=> 'actividad_evidencias.destroy'
    ]);

    Route::get('verifica_evidencia/{id}/ver_evidencia','VerificaEvidenciaController@verEvidencia')->name('verifica_evidencia.ver_evidencia');
    Route::get('verifica_evidencia/reportes','VerificaEvidenciaController@reportes')->name('verifica_evidencia.reportes');
    Route::get('verifica_evidencia/descargar/{archivo}','VerificaEvidenciaController@descargar')->name('verifica_evidencia.descarga');
    Route::get('verifica_evidencia/visualizar/{archivo}','VerificaEvidenciaController@visualizar')->name('verificar_evidencia.visualizar');
    Route::get('verifica_evidencia/avance_alumno','VerificaEvidenciaController@avanceAlumno')->name('verifica_evidencia.avance_alumno');
    Route::resource('verifica_evidencia','VerificaEvidenciaController');

    Route::get('constancias/visualizar','ConstanciasController@visualizar')->name('constancias.visualizar');
    Route::get('constancias','ConstanciasController@index')->name('constancias.index');
    Route::get('constancias/editar','ConstanciasController@editarConstancia')->name('constancias.editar');
    Route::post('constancias/guardar_datos_globales','ConstanciasController@guardarDatosGlobales')->name('constancias.guardar_datos_globales');
    Route::get('constancias/{carrera}/obtener_datos_especificos','ConstanciasController@obtenerDatosEspecificos')->name('constancias.obtener_datos_especificos');
    Route::post('constancias/{carrera}/guardar','ConstanciasController@guardarDatosEspecificos')->name('constancias.guardar_datos_especificos');
    Route::get('constancias/constancias_faltantes','ConstanciasController@constanciasFaltantes')->name('constancias.constancias_faltantes');
    //Roles y permisos

    Route::get('roles_permisos/index','RolesPermisosController@index')->name('roles.index');
    Route::get('roles_permisos/roles_crear','RolesPermisosController@crearRole')->name('roles.roles_crear');
    Route::post('roles_permisos/roles_guardar','RolesPermisosController@guardarRole')->name('roles.roles_guardar');
    Route::get('roles_permisos/permisos_crear','RolesPermisosController@crearPermiso')->name('roles.permisos_crear');
    Route::post('roles_permisos/permisos_guardar','RolesPermisosController@guardarPermiso')->name('roles.permisos_guardar');
    Route::get('roles_permisos/{id}/asignar_permiso_vista','RolesPermisosController@rolesAsignarPermisosVista')->name('roles.roles_asignar_permisos_vista');
    Route::get('roles/{id}/ver_permisos','RolesPermisosController@roleVerPermisos')->name('roles.role_ver_permisos');
    Route::post('roles_permisos/role_asignar_permiso','RolesPermisosController@rolesAsignarPermiso')->name('roles.roles_asignar_permisos');
    Route::get('roles_permisos/{id}/editar','RolesPermisosController@editarRole')->name('roles.role_editar');
    Route::put('roles_permisos/{id}/actualizar','RolesPermisosController@actualizarRole')->name('roles.role_actualizar');
    Route::get('roles_permisos/{id}/eliminar','RolesPermisosController@eliminarRole')->name('roles.role_eliminar');
    Route::get('roles_permisos/{id}/usuarios','RolesPermisosController@usuarios')->name('roles.usuarios');
    Route::get('roles_permisos/{id}/usuarios/revocar_role','RolesPermisosController@usuarioRevocarRol')->name('roles.usuarios_revocar');

});
/******************************/
Route::group(['prefix' => 'alumnos', 'middleware' => 'auth:alumno'],function(){
    Route::get('home','AlumnosRutasController@home');
    Route::get('avance','AlumnosRutasController@avance')->name('alumnos.avance');
    Route::get('actividades','AlumnosRutasController@actividades')->name('alumnos.actividades');
    Route::get('actividades/subir_evidencia','AlumnosRutasController@subirEvidencia')->name('alumnos.subir_evidencia');
    Route::post('actividades/guardar_evidencia','AlumnosRutasController@guardarEvidencia')->name('alumnos.guardar_evidencia');
    Route::get('actividades/evidencia','AlumnosRutasController@evidencia')->name('alumnos.evidencia');
    Route::get('actividades/eliminar_evidencia','AlumnosRutasController@eliminarEvidencia')->name('alumnos.eliminar_evidencia');
});
//Route::get('alumnos/login','AlumnosLoginController@showLoginForm')->name('alumnos.login');
Route::post('alumnos/login','AlumnosLoginController@login')->name('alumnos.login');
Route::post('alumnos/logout','AlumnosLoginController@logout')->name('alumnos.logout');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

