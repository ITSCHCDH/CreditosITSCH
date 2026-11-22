# Inventario de codigo y base de datos

> Fecha del inventario: 2026-11-22
> Alcance: rutas web/API, modelos Eloquent, codigo bajo `app/` y rutas, y comparacion de SQL.

## Resumen ejecutivo
- Rutas: 210
- Modelos Eloquent: 29 (incluye el perfil propio `AlumnoCreditosPerfil`; excluye el modelo legacy `Alumno`)
- Tablas en `creditos.sql`: 38
- Tablas en `sit.sql`: 83
- Tablas solo en `creditos.sql`: 28
- Corte final: `creditos.alumnos` queda fuera de la aplicación y se elimina por la migración `2026_11_22_999999_drop_legacy_alumnos_table.php`, protegida por la existencia de `alumno_creditos_perfil`

## Corte final de identidad de alumnos (2026-11-22)

- Fuente institucional única: `App\Models\Sit\Alumno`, conexión `sit`, clave operativa `no_control`.
- Perfil y datos propios del módulo: `creditos.alumno_creditos_perfil` y modelos locales enlazados mediante `no_control`.
- Relación cruzada disponible en SIT: `App\Models\Sit\Alumno::perfilCreditos()`.
- Relaciones locales útiles: `Avance::alumno()`, `Participante::alumno()` y perfiles familiares/médicos sociales usan `no_control` hacia `Sit\Alumno`.
- Eliminados: `app/Models/Alumno.php`, el factory legacy `database/factories/AlumnosFactory.php` y el seeder legacy `database/seeds/GenerarAlumnos.php`.
- Consulta prohibida: no crear, leer ni escribir `creditos.alumnos`; la migración final solo actúa sobre `creditos` y exige el guard `alumno_creditos_perfil`.

## 1. Rutas web
### `/`
- Metodo: `GET|HEAD`
- Nombre: `alumnos.login`
- Controlador/metodo: `Closure`
- Middleware: `web`
- Modelos detectados: -
- Tablas detectadas: -

### `Import`
- Metodo: `POST`
- Nombre: `excel.import`
- Controlador/metodo: `App\Http\Controllers\ExcelController@importClaves`
- Middleware: `web`
- Modelos detectados: -
- Tablas detectadas: -

### `Import`
- Metodo: `GET|HEAD`
- Nombre: `ImportExcel.index`
- Controlador/metodo: `App\Http\Controllers\ExcelController@index`
- Middleware: `web`
- Modelos detectados: -
- Tablas detectadas: -

### `Import/alta`
- Metodo: `POST`
- Nombre: `excel.aluImport`
- Controlador/metodo: `App\Http\Controllers\altaAlumnosController@altaAlumnos`
- Middleware: `web`
- Modelos detectados: -
- Tablas detectadas: -

### `Import/altas`
- Metodo: `GET|HEAD`
- Nombre: `ImportExcel.altaAlumnos`
- Controlador/metodo: `App\Http\Controllers\altaAlumnosController@index`
- Middleware: `web`
- Modelos detectados: -
- Tablas detectadas: -

### `_ignition/execute-solution`
- Metodo: `POST`
- Nombre: `ignition.executeSolution`
- Controlador/metodo: `Spatie\LaravelIgnition\Http\Controllers\ExecuteSolutionController`
- Middleware: `Spatie\LaravelIgnition\Http\Middleware\RunnableSolutionsEnabled`
- Modelos detectados: -
- Tablas detectadas: -

### `_ignition/health-check`
- Metodo: `GET|HEAD`
- Nombre: `ignition.healthCheck`
- Controlador/metodo: `Spatie\LaravelIgnition\Http\Controllers\HealthCheckController`
- Middleware: `Spatie\LaravelIgnition\Http\Middleware\RunnableSolutionsEnabled`
- Modelos detectados: -
- Tablas detectadas: -

### `_ignition/update-config`
- Metodo: `POST`
- Nombre: `ignition.updateConfig`
- Controlador/metodo: `Spatie\LaravelIgnition\Http\Controllers\UpdateConfigController`
- Middleware: `Spatie\LaravelIgnition\Http\Middleware\RunnableSolutionsEnabled`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/actividad_evidencias`
- Metodo: `GET|HEAD`
- Nombre: `actividad_evidencias.index`
- Controlador/metodo: `App\Http\Controllers\Actividad_EvidenciasController@index`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/actividad_evidencias`
- Metodo: `POST`
- Nombre: `actividad_evidencias.store`
- Controlador/metodo: `App\Http\Controllers\Actividad_EvidenciasController@store`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/actividad_evidencias/asignar_responsables`
- Metodo: `POST`
- Nombre: `actividad_evidencias.asignar_responsables`
- Controlador/metodo: `App\Http\Controllers\Actividad_EvidenciasController@asignarResponsables`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/actividad_evidencias/create`
- Metodo: `GET|HEAD`
- Nombre: `actividad_evidencias.create`
- Controlador/metodo: `App\Http\Controllers\Actividad_EvidenciasController@create`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/actividad_evidencias/{actividad_evidencia}`
- Metodo: `GET|HEAD`
- Nombre: `actividad_evidencias.show`
- Controlador/metodo: `App\Http\Controllers\Actividad_EvidenciasController@show`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/actividad_evidencias/{actividad_evidencia}`
- Metodo: `PUT|PATCH`
- Nombre: `actividad_evidencias.update`
- Controlador/metodo: `App\Http\Controllers\Actividad_EvidenciasController@update`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/actividad_evidencias/{actividad_evidencia}`
- Metodo: `DELETE`
- Nombre: `actividad_evidencias.destroy`
- Controlador/metodo: `App\Http\Controllers\Actividad_EvidenciasController@destroy`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/actividad_evidencias/{actividad_evidencia}/edit`
- Metodo: `GET|HEAD`
- Nombre: `actividad_evidencias.edit`
- Controlador/metodo: `App\Http\Controllers\Actividad_EvidenciasController@edit`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/actividad_evidencias/{id}/destroy`
- Metodo: `GET|HEAD`
- Nombre: `actividad_evidencias.destroy`
- Controlador/metodo: `App\Http\Controllers\Actividad_EvidenciasController@destroy`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/actividades/cargar_actividades`
- Metodo: `GET|HEAD`
- Nombre: `actividades.cargar.ajax`
- Controlador/metodo: `App\Http\Controllers\ActividadesController@cargarActividadesAjax`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP_SOLO_LECTURA|VIP|VER_ACTIVIDAD|VIP_ACTIVIDAD`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/actividades/create`
- Metodo: `GET|HEAD`
- Nombre: `actividades.create`
- Controlador/metodo: `App\Http\Controllers\ActividadesController@create`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|VIP_ACTIVIDAD|CREAR_ACTIVIDAD`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/actividades/index`
- Metodo: `GET|HEAD`
- Nombre: `actividades.index`
- Controlador/metodo: `App\Http\Controllers\ActividadesController@index`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP_SOLO_LECTURA|VIP|VER_ACTIVIDAD|VIP_ACTIVIDAD`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/actividades/store`
- Metodo: `POST`
- Nombre: `actividades.store`
- Controlador/metodo: `App\Http\Controllers\ActividadesController@store`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|VIP_ACTIVIDAD|CREAR_ACTIVIDAD`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/actividades/update/{id}`
- Metodo: `POST`
- Nombre: `actividades.update`
- Controlador/metodo: `App\Http\Controllers\ActividadesController@update`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|VIP_ACTIVIDAD|MODIFICAR_ACTIVIDAD`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/actividades/{id}/destroy`
- Metodo: `GET|HEAD`
- Nombre: `actividades.destroy`
- Controlador/metodo: `App\Http\Controllers\ActividadesController@destroy`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/actividades/{id}/edit`
- Metodo: `GET|HEAD`
- Nombre: `actividades.edit`
- Controlador/metodo: `App\Http\Controllers\ActividadesController@edit`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|VIP_ACTIVIDAD|MODIFICAR_ACTIVIDAD`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/actividades/{id}/responsables`
- Metodo: `GET|HEAD`
- Nombre: `responsables`
- Controlador/metodo: `App\Http\Controllers\ResponsablesController@show`
- Middleware: `web, Spatie\Permission\Middleware\PermissionMiddleware:VIP|VIP_ACTIVIDAD|VIP_SOLO_LECTURA|VER_RESPONSABLES`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/actividades/{id}/responsables/asignar`
- Metodo: `GET|HEAD`
- Nombre: `responsables.index`
- Controlador/metodo: `App\Http\Controllers\ResponsablesController@index`
- Middleware: `web, Spatie\Permission\Middleware\PermissionMiddleware:VIP|VIP_ACTIVIDAD|AGREGAR_RESPONSABLES|ELIMINAR_RESPONSABLES`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/alumnos/Bajas/view`
- Metodo: `GET|HEAD`
- Nombre: `alumnos.bajas.view`
- Controlador/metodo: `App\Http\Controllers\AlumnosController@bajas`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/alumnos/buscar`
- Metodo: `GET|HEAD`
- Nombre: `alumnos.buscar`
- Controlador/metodo: `App\Http\Controllers\AlumnosController@buscar`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/alumnos/cargar_alumnos_ajax`
- Metodo: `GET|HEAD`
- Nombre: `admin.alumnos.cargar.ajax`
- Controlador/metodo: `App\Http\Controllers\AlumnosController@cargarAlumnosAjax`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|VIP_SOLO_LECTURA|VER_ALUMNOS`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/alumnos/create`
- Metodo: `GET|HEAD`
- Nombre: `alumnos.create`
- Controlador/metodo: `App\Http\Controllers\AlumnosController@create`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|CREAR_ALUMNOS`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/alumnos/editarStatus`
- Metodo: `GET|HEAD`
- Nombre: `alumnos.editarStatus`
- Controlador/metodo: `App\Http\Controllers\AlumnosController@editStatus`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/alumnos/index`
- Metodo: `GET|HEAD`
- Nombre: `alumnos.index`
- Controlador/metodo: `App\Http\Controllers\AlumnosController@index`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|VIP_SOLO_LECTURA|VER_ALUMNOS`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/alumnos/store`
- Metodo: `POST`
- Nombre: `alumnos.store`
- Controlador/metodo: `App\Http\Controllers\AlumnosController@store`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|CREAR_ALUMNOS`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/alumnos/{id}/destroy`
- Metodo: `GET|HEAD`
- Nombre: `alumnos.destroy`
- Controlador/metodo: `App\Http\Controllers\AlumnosController@destroy`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|ELIMINAR_ALUMNOS`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/alumnos/{id}/edit`
- Metodo: `GET|HEAD`
- Nombre: `alumnos.edit`
- Controlador/metodo: `App\Http\Controllers\AlumnosController@edit`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|MODIFICAR_ALUMNOS`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/alumnos/{id}/update`
- Metodo: `POST`
- Nombre: `alumnos.update`
- Controlador/metodo: `App\Http\Controllers\AlumnosController@update`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|MODIFICAR_ALUMNOS`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/areas/crear`
- Metodo: `GET|HEAD`
- Nombre: `areas.crear`
- Controlador/metodo: `App\Http\Controllers\AreasController@crear`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|CREAR_AREAS|SOLO_LECTURA`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/areas/guardar`
- Metodo: `POST`
- Nombre: `areas.guardar`
- Controlador/metodo: `App\Http\Controllers\AreasController@guardar`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|CREAR_AREAS|SOLO_LECTURA`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/areas/lista`
- Metodo: `GET|HEAD`
- Nombre: `areas.inicio`
- Controlador/metodo: `App\Http\Controllers\AreasController@inicio`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|VER_AREAS|SOLO_LECTURA`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/areas/{area}/actualizar`
- Metodo: `POST`
- Nombre: `areas.actualizar`
- Controlador/metodo: `App\Http\Controllers\AreasController@actualizar`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|MODIFICAR_AREAS|SOLO_LECTURA`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/areas/{area}/editar`
- Metodo: `GET|HEAD`
- Nombre: `areas.editar`
- Controlador/metodo: `App\Http\Controllers\AreasController@editar`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|MODIFICAR_AREAS|SOLO_LECTURA`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/areas/{area}/eliminar`
- Metodo: `GET|HEAD`
- Nombre: `areas.eliminar`
- Controlador/metodo: `App\Http\Controllers\AreasController@eliminar`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|ELIMINAR_AREAS|SOLO_LECTURA`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/areas/{area}/usuarios`
- Metodo: `GET|HEAD`
- Nombre: `areas.usuarios`
- Controlador/metodo: `App\Http\Controllers\AreasController@usuarios`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|VER_AREAS|SOLO_LECTURA`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/constancias`
- Metodo: `GET|HEAD`
- Nombre: `constancias.index`
- Controlador/metodo: `App\Http\Controllers\ConstanciasController@index`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/constancias/constancias_faltantes`
- Metodo: `GET|HEAD`
- Nombre: `constancias.constancias_faltantes`
- Controlador/metodo: `App\Http\Controllers\ConstanciasController@constanciasFaltantes`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/constancias/editar`
- Metodo: `GET|HEAD`
- Nombre: `constancias.editar`
- Controlador/metodo: `App\Http\Controllers\ConstanciasController@editarConstancia`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|VIP_CONSTANCIAS|MODIFICAR_CONSTANCIAS_CARRERA`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/constancias/guardar_datos_globales`
- Metodo: `POST`
- Nombre: `constancias.guardar_datos_globales`
- Controlador/metodo: `App\Http\Controllers\ConstanciasController@guardarDatosGlobales`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|VIP_CONSTANCIAS`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/constancias/imprimir`
- Metodo: `POST`
- Nombre: `constancias.imprimir`
- Controlador/metodo: `App\Http\Controllers\ConstanciasController@imprimir`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/constancias/visualizar`
- Metodo: `GET|HEAD`
- Nombre: `constancias.visualizar`
- Controlador/metodo: `App\Http\Controllers\ConstanciasController@visualizar`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|VIP_CONSTANCIAS|MODIFICAR_CONSTANCIAS_CARRERA`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/constancias/{carrera}/guardar`
- Metodo: `POST`
- Nombre: `constancias.guardar_datos_especificos`
- Controlador/metodo: `App\Http\Controllers\ConstanciasController@guardarDatosEspecificos`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|VIP_CONSTANCIAS|MODIFICAR_CONSTANCIAS_CARRERA`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/constancias/{carrera}/obtener_datos_especificos`
- Metodo: `GET|HEAD`
- Nombre: `constancias.obtener_datos_especificos`
- Controlador/metodo: `App\Http\Controllers\ConstanciasController@obtenerDatosEspecificos`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/creditos/create`
- Metodo: `GET|HEAD`
- Nombre: `creditos.create`
- Controlador/metodo: `App\Http\Controllers\CreditosController@create`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|CREAR_CREDITOS`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/creditos/index`
- Metodo: `GET|HEAD`
- Nombre: `creditos.index`
- Controlador/metodo: `App\Http\Controllers\CreditosController@index`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP_SOLO_LECTURA|VIP|VER_CREDITOS`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/creditos/store`
- Metodo: `POST`
- Nombre: `creditos.store`
- Controlador/metodo: `App\Http\Controllers\CreditosController@store`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|CREAR_CREDITOS`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/creditos/{id}/destroy`
- Metodo: `GET|HEAD`
- Nombre: `creditos.destroy`
- Controlador/metodo: `App\Http\Controllers\CreditosController@destroy`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|ELIMINAR_CREDITOS`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/creditos/{id}/edit`
- Metodo: `GET|HEAD`
- Nombre: `creditos.edit`
- Controlador/metodo: `App\Http\Controllers\CreditosController@edit`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|MODIFICAR_CREDITOS`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/creditos/{id}/update`
- Metodo: `POST`
- Nombre: `creditos.update`
- Controlador/metodo: `App\Http\Controllers\CreditosController@update`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|MODIFICAR_CREDITOS`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/evidencias`
- Metodo: `GET|HEAD`
- Nombre: `evidencias.index`
- Controlador/metodo: `App\Http\Controllers\EvidenciasController@index`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP_SOLO_LECTURA|VIP|VER_EVIDENCIA`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/evidencias`
- Metodo: `POST`
- Nombre: `evidencias.store`
- Controlador/metodo: `App\Http\Controllers\EvidenciasController@store`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|CREAR_EVIDENCIA`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/evidencias/create`
- Metodo: `GET|HEAD`
- Nombre: `evidencias.create`
- Controlador/metodo: `App\Http\Controllers\EvidenciasController@create`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|CREAR_EVIDENCIA`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/evidencias/eliminar`
- Metodo: `GET|HEAD`
- Nombre: `evidencias.eliminar`
- Controlador/metodo: `App\Http\Controllers\EvidenciasController@peticionEliminar`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/evidencias/galeria`
- Metodo: `GET|HEAD`
- Nombre: `evidencias.galeria`
- Controlador/metodo: `App\Http\Controllers\EvidenciasController@peticionGaleria`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/evidencias/peticion`
- Metodo: `GET|HEAD`
- Nombre: `evidencias.peticion`
- Controlador/metodo: `App\Http\Controllers\EvidenciasController@peticionAjax`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/evidencias/{evidencia}`
- Metodo: `GET|HEAD`
- Nombre: `evidencias.show`
- Controlador/metodo: `App\Http\Controllers\EvidenciasController@show`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP_SOLO_LECTURA|VIP|VER_EVIDENCIA`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/evidencias/{evidencia}`
- Metodo: `PUT|PATCH`
- Nombre: `evidencias.update`
- Controlador/metodo: `App\Http\Controllers\EvidenciasController@update`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/evidencias/{evidencia}`
- Metodo: `DELETE`
- Nombre: `evidencias.destroy`
- Controlador/metodo: `App\Http\Controllers\EvidenciasController@destroy`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/evidencias/{evidencia}/edit`
- Metodo: `GET|HEAD`
- Nombre: `evidencias.edit`
- Controlador/metodo: `App\Http\Controllers\EvidenciasController@edit`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/evidencias/{id}/destroy`
- Metodo: `GET|HEAD`
- Nombre: `admin.evidencias.destroy`
- Controlador/metodo: `App\Http\Controllers\EvidenciasController@destroy`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/mensajes`
- Metodo: `GET|HEAD`
- Nombre: `mensajes.index`
- Controlador/metodo: `App\Http\Controllers\MensajesController@index`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/mensajes/crear`
- Metodo: `GET|HEAD`
- Nombre: `mensajes.crear`
- Controlador/metodo: `App\Http\Controllers\MensajesController@crear`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/mensajes/destinatarios`
- Metodo: `GET|HEAD`
- Nombre: `mensajes.destinatarios`
- Controlador/metodo: `App\Http\Controllers\MensajesController@destinatarios`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/mensajes/eliminar`
- Metodo: `GET|HEAD`
- Nombre: `mensajes.eliminar`
- Controlador/metodo: `App\Http\Controllers\MensajesController@eliminarMensaje`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/mensajes/enviados`
- Metodo: `GET|HEAD`
- Nombre: `mensajes.enviados`
- Controlador/metodo: `App\Http\Controllers\MensajesController@enviados`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/mensajes/enviar`
- Metodo: `POST`
- Nombre: `mensajes.enviar`
- Controlador/metodo: `App\Http\Controllers\MensajesController@enviar`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/mensajes/mensajes_vistos`
- Metodo: `GET|HEAD`
- Nombre: `mensajes.vistos`
- Controlador/metodo: `App\Http\Controllers\MensajesController@mensajesVistos`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/mensajes/nuevos_mensajes`
- Metodo: `GET|HEAD`
- Nombre: `mensajes.nuevos_mensajes`
- Controlador/metodo: `App\Http\Controllers\MensajesController@nuevosMensajes`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/mensajes/ver`
- Metodo: `GET|HEAD`
- Nombre: `mensajes.ver`
- Controlador/metodo: `App\Http\Controllers\MensajesController@ver`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/participantes`
- Metodo: `GET|HEAD`
- Nombre: `participantes.index`
- Controlador/metodo: `App\Http\Controllers\ParticipantesController@index`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP_SOLO_LECTURA|VIP|VER_PARTICIPANTES`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/participantes`
- Metodo: `POST`
- Nombre: `participantes.store`
- Controlador/metodo: `App\Http\Controllers\ParticipantesController@store`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|AGREGAR_PARTICIPANTES|ELIMINAR_PARTICIPANTES`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/participantes/actividad/responsables`
- Metodo: `GET|HEAD`
- Nombre: `participantes.actividad_responsables`
- Controlador/metodo: `App\Http\Controllers\ParticipantesController@peticionAjaxResponsables`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/participantes/busqueda`
- Metodo: `GET|HEAD`
- Nombre: `participantes.busqueda`
- Controlador/metodo: `App\Http\Controllers\ParticipantesController@participantesBusqueda`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/participantes/create`
- Metodo: `GET|HEAD`
- Nombre: `participantes.create`
- Controlador/metodo: `App\Http\Controllers\ParticipantesController@create`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|AGREGAR_PARTICIPANTES|ELIMINAR_PARTICIPANTES`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/participantes/eliminar_evidencia`
- Metodo: `GET|HEAD`
- Nombre: `participantes.eliminar_evidencia`
- Controlador/metodo: `App\Http\Controllers\ParticipantesController@eliminarEvidencia`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/participantes/guardar`
- Metodo: `POST`
- Nombre: `participantes.guardar`
- Controlador/metodo: `App\Http\Controllers\ParticipantesController@ajaxGuardar`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|AGREGAR_PARTICIPANTES|ELIMINAR_PARTICIPANTES`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/participantes/peticion`
- Metodo: `GET|HEAD`
- Nombre: `participantes.peticion`
- Controlador/metodo: `App\Http\Controllers\ParticipantesController@peticionAjax`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP_SOLO_LECTURA|VIP|VER_PARTICIPANTES`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/participantes/validar_evidencia`
- Metodo: `POST`
- Nombre: `participantes.validar_evidencia`
- Controlador/metodo: `App\Http\Controllers\ParticipantesController@validarEvidencia`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/participantes/ver_evidencia`
- Metodo: `GET|HEAD`
- Nombre: `participantes.ver_evidencia`
- Controlador/metodo: `App\Http\Controllers\ParticipantesController@verEvidencia`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/participantes/{id}/destroy`
- Metodo: `GET|HEAD`
- Nombre: `admin.participantes.destroy`
- Controlador/metodo: `App\Http\Controllers\ParticipantesController@destroy`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|AGREGAR_PARTICIPANTES|ELIMINAR_PARTICIPANTES`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/participantes/{participante}`
- Metodo: `GET|HEAD`
- Nombre: `participantes.show`
- Controlador/metodo: `App\Http\Controllers\ParticipantesController@show`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|AGREGAR_PARTICIPANTES|ELIMINAR_PARTICIPANTES`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/participantes/{participante}`
- Metodo: `PUT|PATCH`
- Nombre: `participantes.update`
- Controlador/metodo: `App\Http\Controllers\ParticipantesController@update`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|AGREGAR_PARTICIPANTES|ELIMINAR_PARTICIPANTES`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/participantes/{participante}`
- Metodo: `DELETE`
- Nombre: `participantes.destroy`
- Controlador/metodo: `App\Http\Controllers\ParticipantesController@destroy`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|AGREGAR_PARTICIPANTES|ELIMINAR_PARTICIPANTES`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/participantes/{participante}/edit`
- Metodo: `GET|HEAD`
- Nombre: `participantes.edit`
- Controlador/metodo: `App\Http\Controllers\ParticipantesController@edit`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|AGREGAR_PARTICIPANTES|ELIMINAR_PARTICIPANTES`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/perfil`
- Metodo: `GET|HEAD`
- Nombre: `perfil.index`
- Controlador/metodo: `App\Http\Controllers\PerfilController@index`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/perfil/password_reset`
- Metodo: `GET|HEAD`
- Nombre: `perfil.password_reset_view`
- Controlador/metodo: `App\Http\Controllers\PerfilController@passwordResetViewMiPerfil`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/perfil/password_update`
- Metodo: `POST`
- Nombre: `perfil.password_update`
- Controlador/metodo: `App\Http\Controllers\PerfilController@passwordUpdate`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/roles/{id}/ver_permisos`
- Metodo: `GET|HEAD`
- Nombre: `roles.role_ver_permisos`
- Controlador/metodo: `App\Http\Controllers\RolesPermisosController@roleVerPermisos`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/roles_permisos/index`
- Metodo: `GET|HEAD`
- Nombre: `roles.index`
- Controlador/metodo: `App\Http\Controllers\RolesPermisosController@index`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|VER_ROLES|VIP_SOLO_LECTURA`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/roles_permisos/role_asignar_permiso`
- Metodo: `POST`
- Nombre: `roles.roles_asignar_permisos`
- Controlador/metodo: `App\Http\Controllers\RolesPermisosController@rolesAsignarPermiso`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|ASIGNAR_REMOVER_PERMISOS_A_ROLES`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/roles_permisos/roles_crear`
- Metodo: `GET|HEAD`
- Nombre: `roles.roles_crear`
- Controlador/metodo: `App\Http\Controllers\RolesPermisosController@crearRole`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|CREAR_ROLES`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/roles_permisos/roles_guardar`
- Metodo: `POST`
- Nombre: `roles.roles_guardar`
- Controlador/metodo: `App\Http\Controllers\RolesPermisosController@guardarRole`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|CREAR_ROLES`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/roles_permisos/{id}/actualizar`
- Metodo: `POST`
- Nombre: `roles.role_actualizar`
- Controlador/metodo: `App\Http\Controllers\RolesPermisosController@actualizarRole`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|MODIFICAR_ROLES`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/roles_permisos/{id}/asignar_permiso_vista`
- Metodo: `GET|HEAD`
- Nombre: `roles.roles_asignar_permisos_vista`
- Controlador/metodo: `App\Http\Controllers\RolesPermisosController@rolesAsignarPermisosVista`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|ASIGNAR_REMOVER_PERMISOS_A_ROLES`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/roles_permisos/{id}/editar`
- Metodo: `GET|HEAD`
- Nombre: `roles.role_editar`
- Controlador/metodo: `App\Http\Controllers\RolesPermisosController@editarRole`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|MODIFICAR_ROLES`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/roles_permisos/{id}/eliminar`
- Metodo: `GET|HEAD`
- Nombre: `roles.role_eliminar`
- Controlador/metodo: `App\Http\Controllers\RolesPermisosController@eliminarRole`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|ELIMINAR_ROLES`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/roles_permisos/{id}/usuarios`
- Metodo: `GET|HEAD`
- Nombre: `roles.usuarios`
- Controlador/metodo: `App\Http\Controllers\RolesPermisosController@usuarios`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|VIP_SOLO_LECTURA|VER_ROLES_USUARIOS`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/roles_permisos/{id}/usuarios/revocar_role`
- Metodo: `GET|HEAD`
- Nombre: `roles.usuarios_revocar`
- Controlador/metodo: `App\Http\Controllers\RolesPermisosController@usuariosRevocarRol`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|ELIMINAR_ROLES_USUARIOS|ASIGNAR_REMOVER_ROLES_USUARIOS`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/analisis`
- Metodo: `GET|HEAD`
- Nombre: `analisis.index`
- Controlador/metodo: `App\Http\Controllers\JefesController@index`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP_STA|STA_DEP_TUTORIA|STA_COR_CARRERA`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/analisis/alumno/{nc}`
- Metodo: `GET|HEAD`
- Nombre: `analisis.alumno`
- Controlador/metodo: `App\Http\Controllers\JefesController@diagnostico`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP_STA|STA_DEP_TUTORIA|STA_TUTOR|STA_COR_CARRERA`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/analisis/ficha/{nc},/{usr}`
- Metodo: `GET|HEAD`
- Nombre: `analisis.ficha`
- Controlador/metodo: `App\Http\Controllers\JefesController@ficha`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP_STA|STA_DEP_TUTORIA|STA_TUTOR|STA_COR_CARRERA`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/analisis/generación`
- Metodo: `POST`
- Nombre: `analisis.generacion`
- Controlador/metodo: `App\Http\Controllers\JefesController@generacion`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP_STA|STA_DEP_TUTORIA|STA_TUTOR|STA_COR_CARRERA`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/comentarios/guardar`
- Metodo: `POST`
- Nombre: `comentarios.save`
- Controlador/metodo: `App\Http\Controllers\STAController@saveComent`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP_STA|STA_DEP_TUTORIA|STA_PROFESOR`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/lista/calificaciones/find`
- Metodo: `POST`
- Nombre: `listaCali.find`
- Controlador/metodo: `App\Http\Controllers\STAController@findListaCali`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP_STA|STA_DEP_TUTORIA|STA_PROFESOR`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/materias/find`
- Metodo: `POST`
- Nombre: `materias.find`
- Controlador/metodo: `App\Http\Controllers\STAController@findMaterias`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP_STA|STA_DEP_TUTORIA|STA_PROFESOR`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/medico`
- Metodo: `GET|HEAD`
- Nombre: `medico.index`
- Controlador/metodo: `App\Http\Controllers\SistemaMedicoController@index`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/medico/actualizar/semaforo/{id}`
- Metodo: `GET|HEAD`
- Nombre: `medico.actualizar.semaforo`
- Controlador/metodo: `App\Http\Controllers\SistemaMedicoController@actualizarSemaforo`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/medico/atender/cita/{id}`
- Metodo: `GET|HEAD`
- Nombre: `medico.atender.cita`
- Controlador/metodo: `App\Http\Controllers\SistemaMedicoController@atenderCita`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/medico/editar/cita/{id}`
- Metodo: `GET|HEAD`
- Nombre: `medico.editar.cita`
- Controlador/metodo: `App\Http\Controllers\SistemaMedicoController@edit`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/medico/generar/receta/{id}`
- Metodo: `GET|HEAD`
- Nombre: `medico.generar.receta`
- Controlador/metodo: `App\Http\Controllers\SistemaMedicoController@generarReceta`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/medico/guardar/historial/{id}`
- Metodo: `POST`
- Nombre: `medico.guardar.historial`
- Controlador/metodo: `App\Http\Controllers\SistemaMedicoController@guardarHistorial`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/medico/guardar/receta/{id}`
- Metodo: `POST`
- Nombre: `medico.guardar.receta`
- Controlador/metodo: `App\Http\Controllers\SistemaMedicoController@guardarReceta`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/medico/guardar/semaforo/{id}`
- Metodo: `POST`
- Nombre: `medico.guardar.semaforo`
- Controlador/metodo: `App\Http\Controllers\SistemaMedicoController@guardarSemaforo`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/medico/update/cita/{id}`
- Metodo: `POST`
- Nombre: `medico.update.cita`
- Controlador/metodo: `App\Http\Controllers\SistemaMedicoController@update`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/paciente/create/cita`
- Metodo: `GET|HEAD`
- Nombre: `paciente.create.cita`
- Controlador/metodo: `App\Http\Controllers\PacienteController@create`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/paciente/destroy/cita/{id}`
- Metodo: `POST`
- Nombre: `paciente.destroy.cita`
- Controlador/metodo: `App\Http\Controllers\PacienteController@destroy`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/paciente/editar/cita/{id}`
- Metodo: `GET|HEAD`
- Nombre: `paciente.editar.cita`
- Controlador/metodo: `App\Http\Controllers\PacienteController@edit`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/paciente/editar/perfil`
- Metodo: `GET|HEAD`
- Nombre: `paciente.editar.perfil`
- Controlador/metodo: `App\Http\Controllers\PacienteController@editPerfil`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/paciente/mis_citas`
- Metodo: `GET|HEAD`
- Nombre: `paciente.index.citas`
- Controlador/metodo: `App\Http\Controllers\PacienteController@index`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/paciente/store/cita`
- Metodo: `POST`
- Nombre: `paciente.store.cita`
- Controlador/metodo: `App\Http\Controllers\PacienteController@store`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/paciente/store/perfil`
- Metodo: `POST`
- Nombre: `paciente.store.perfil`
- Controlador/metodo: `App\Http\Controllers\PacienteController@storePerfil`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/paciente/update/cita/{id}`
- Metodo: `POST`
- Nombre: `paciente.update.cita`
- Controlador/metodo: `App\Http\Controllers\PacienteController@update`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/pdf/{nc}`
- Metodo: `GET|HEAD`
- Nombre: `analisis.sta.pdf`
- Controlador/metodo: `App\Http\Controllers\AlumnosStaController@pdf`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/profesores`
- Metodo: `GET|HEAD`
- Nombre: `profesores.index`
- Controlador/metodo: `App\Http\Controllers\STAController@indexProfesores`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP_STA|STA_DEP_TUTORIA|STA_PROFESOR`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/profesores/find`
- Metodo: `POST`
- Nombre: `profesores.find`
- Controlador/metodo: `App\Http\Controllers\STAController@findProfesores`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP_STA|STA_DEP_TUTORIA|STA_PROFESOR`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/tutores`
- Metodo: `GET|HEAD`
- Nombre: `tutores.index`
- Controlador/metodo: `App\Http\Controllers\STAController@indexTutores`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP_STA|STA_DEP_TUTORIA|STA_TUTOR`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/tutores/analisis_grupo/{id_gpo}`
- Metodo: `GET|HEAD`
- Nombre: `tutores.analisisGrupo`
- Controlador/metodo: `App\Http\Controllers\STAController@analisisGrupo`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/tutores/delete/alumno`
- Metodo: `POST`
- Nombre: `tutores.deleteAlumno`
- Controlador/metodo: `App\Http\Controllers\STAController@deleteAlumno`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP_STA|STA_DEP_TUTORIA|STA_TUTOR`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/tutores/show/grupo/{id}/{nom}`
- Metodo: `GET|HEAD`
- Nombre: `tutores.showGrupo`
- Controlador/metodo: `App\Http\Controllers\STAController@showGrupo`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP_STA|STA_DEP_TUTORIA|STA_TUTOR`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/tutores/store/alumno/observaciones`
- Metodo: `POST`
- Nombre: `tutores.storeAlumnoObs`
- Controlador/metodo: `App\Http\Controllers\JefesController@storeAlumnoObs`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP_STA|STA_DEP_TUTORIA|STA_TUTOR|STA_COR_CARRERA`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/tutores/store/grupo`
- Metodo: `POST`
- Nombre: `tutores.storeGrupo`
- Controlador/metodo: `App\Http\Controllers\STAController@storeGrupo`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP_STA|STA_DEP_TUTORIA|STA_TUTOR`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/tutorias`
- Metodo: `GET|HEAD`
- Nombre: `tutorias.index`
- Controlador/metodo: `App\Http\Controllers\STAController@indexTutorias`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP_STA|STA_DEP_TUTORIA`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/tutorias/asigTutPDF/{id}`
- Metodo: `GET|HEAD`
- Nombre: `tutorias.asigTutPDF`
- Controlador/metodo: `App\Http\Controllers\GruposController@asigTutPDF`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/tutorias/get/grupos`
- Metodo: `POST`
- Nombre: `tutorias.getGruposCar`
- Controlador/metodo: `App\Http\Controllers\GruposController@getGruposCar`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/tutorias/grupos`
- Metodo: `GET|HEAD`
- Nombre: `tutorias.getGruposAll`
- Controlador/metodo: `App\Http\Controllers\GruposController@getGruposAll`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/tutorias/grupos/{id}/delete`
- Metodo: `GET|HEAD`
- Nombre: `tutorias.deleteGrupo`
- Controlador/metodo: `App\Http\Controllers\GruposController@deleteGrupo`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/tutorias/grupos/{id}/update`
- Metodo: `POST`
- Nombre: `tutorias.updateGrupo`
- Controlador/metodo: `App\Http\Controllers\GruposController@updateGrupo`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/tutorias/libTutPDF/{id}`
- Metodo: `GET|HEAD`
- Nombre: `tutorias.libTutPDF`
- Controlador/metodo: `App\Http\Controllers\GruposController@libTutPDF`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/tutorias/save/grupo`
- Metodo: `POST`
- Nombre: `tutorias.saveGrupo`
- Controlador/metodo: `App\Http\Controllers\GruposController@saveGrupo`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/tutorias/saveGrupoTutorias`
- Metodo: `POST`
- Nombre: `tutorias.saveGrupoTut`
- Controlador/metodo: `App\Http\Controllers\GruposController@saveGrupoTut`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/tutorias/tutoriasDestroy/{id}`
- Metodo: `GET|HEAD`
- Nombre: `tutorias.destroy`
- Controlador/metodo: `App\Http\Controllers\GruposController@tutoriasDestroy`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/tutorias/tutoriasEdit/{id}`
- Metodo: `GET|HEAD`
- Nombre: `tutorias.tutoriasEdit`
- Controlador/metodo: `App\Http\Controllers\GruposController@tutoriasEdit`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/sta/units/find`
- Metodo: `POST`
- Nombre: `units.find`
- Controlador/metodo: `App\Http\Controllers\STAController@findUnits`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/usuarios/create`
- Metodo: `GET|HEAD`
- Nombre: `usuarios.create`
- Controlador/metodo: `App\Http\Controllers\UsersController@create`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|CREAR_USUARIOS`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/usuarios/destroy/{id}`
- Metodo: `GET|HEAD`
- Nombre: `usuarios.destroy`
- Controlador/metodo: `App\Http\Controllers\UsersController@destroy`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|ELIMINAR_USUARIOS`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/usuarios/edit/{id}`
- Metodo: `GET|HEAD`
- Nombre: `usuarios.edit`
- Controlador/metodo: `App\Http\Controllers\UsersController@edit`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|MODIFICAR_USUARIOS`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/usuarios/guardar_roles`
- Metodo: `POST`
- Nombre: `usuarios.guardar_roles`
- Controlador/metodo: `App\Http\Controllers\UsersController@guardarRoles`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|ASIGNAR_REMOVER_ROLES_USUARIOS`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/usuarios/index`
- Metodo: `GET|HEAD`
- Nombre: `usuarios.index`
- Controlador/metodo: `App\Http\Controllers\UsersController@index`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|VER_USUARIOS|VIP_SOLO_LECTURA`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/usuarios/store`
- Metodo: `POST`
- Nombre: `usuarios.store`
- Controlador/metodo: `App\Http\Controllers\UsersController@store`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|CREAR_USUARIOS`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/usuarios/update/{id}`
- Metodo: `POST`
- Nombre: `usuarios.update`
- Controlador/metodo: `App\Http\Controllers\UsersController@update`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|MODIFICAR_USUARIOS`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/usuarios/{id}/asignar_roles`
- Metodo: `GET|HEAD`
- Nombre: `usuarios.asignar_roles`
- Controlador/metodo: `App\Http\Controllers\UsersController@asignarRoles`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|ASIGNAR_REMOVER_ROLES_USUARIOS`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/verifica_evidencia`
- Metodo: `GET|HEAD`
- Nombre: `verifica_evidencia.index`
- Controlador/metodo: `App\Http\Controllers\VerificaEvidenciaController@index`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|VIP_SOLO_LECTURA|VIP_EVIDENCIA|VERIFICAR_EVIDENCIA`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/verifica_evidencia`
- Metodo: `POST`
- Nombre: `verifica_evidencia.store`
- Controlador/metodo: `App\Http\Controllers\VerificaEvidenciaController@store`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|VIP_EVIDENCIA|VERIFICAR_EVIDENCIA`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/verifica_evidencia/alumno/busqueda`
- Metodo: `GET|HEAD`
- Nombre: `verifica_evidencia.alumnos_busqueda`
- Controlador/metodo: `App\Http\Controllers\VerificaEvidenciaController@alumnosBusqueda`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|VIP_SOLO_LECTURA|VER_AVANCE_ALUMNO|VIP_AVANCE_ALUMNO`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/verifica_evidencia/avance_alumno`
- Metodo: `GET|HEAD`
- Nombre: `verifica_evidencia.avance_alumno`
- Controlador/metodo: `App\Http\Controllers\VerificaEvidenciaController@avanceAlumno`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|VIP_SOLO_LECTURA|VER_AVANCE_ALUMNO|VIP_AVANCE_ALUMNO`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/verifica_evidencia/create`
- Metodo: `GET|HEAD`
- Nombre: `verifica_evidencia.create`
- Controlador/metodo: `App\Http\Controllers\VerificaEvidenciaController@create`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|VIP_EVIDENCIA|VERIFICAR_EVIDENCIA`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/verifica_evidencia/reportes`
- Metodo: `GET|HEAD`
- Nombre: `verifica_evidencia.reportes`
- Controlador/metodo: `App\Http\Controllers\VerificaEvidenciaController@reportes`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|VIP_SOLO_LECTURA|VIP_REPORTES|VER_REPORTES_CARRERA`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/verifica_evidencia/visualizar/{archivo}`
- Metodo: `GET|HEAD`
- Nombre: `verificar_evidencia.visualizar`
- Controlador/metodo: `App\Http\Controllers\VerificaEvidenciaController@visualizar`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/verifica_evidencia/{id}/ver_evidencia`
- Metodo: `GET|HEAD`
- Nombre: `verifica_evidencia.ver_evidencia`
- Controlador/metodo: `App\Http\Controllers\VerificaEvidenciaController@verEvidencia`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|VIP_EVIDENCIA|VERIFICAR_EVIDENCIA|VIP_SOLO_LECTURA`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/verifica_evidencia/{verifica_evidencium}`
- Metodo: `GET|HEAD`
- Nombre: `verifica_evidencia.show`
- Controlador/metodo: `App\Http\Controllers\VerificaEvidenciaController@show`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP|VIP_SOLO_LECTURA|VIP_EVIDENCIA|VERIFICAR_EVIDENCIA`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/verifica_evidencia/{verifica_evidencium}`
- Metodo: `PUT|PATCH`
- Nombre: `verifica_evidencia.update`
- Controlador/metodo: `App\Http\Controllers\VerificaEvidenciaController@update`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/verifica_evidencia/{verifica_evidencium}`
- Metodo: `DELETE`
- Nombre: `verifica_evidencia.destroy`
- Controlador/metodo: `App\Http\Controllers\VerificaEvidenciaController@destroy`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `admin/verifica_evidencia/{verifica_evidencium}/edit`
- Metodo: `GET|HEAD`
- Nombre: `verifica_evidencia.edit`
- Controlador/metodo: `App\Http\Controllers\VerificaEvidenciaController@edit`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `alumnos/actividades`
- Metodo: `GET|HEAD`
- Nombre: `alumnos.actividades`
- Controlador/metodo: `App\Http\Controllers\AlumnosRutasController@actividades`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate:alumno`
- Modelos detectados: -
- Tablas detectadas: -

### `alumnos/actividades/eliminar_evidencia`
- Metodo: `GET|HEAD`
- Nombre: `alumnos.eliminar_evidencia`
- Controlador/metodo: `App\Http\Controllers\AlumnosRutasController@peticionEliminar`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate:alumno`
- Modelos detectados: -
- Tablas detectadas: -

### `alumnos/actividades/evidencia`
- Metodo: `GET|HEAD`
- Nombre: `alumnos.evidencia`
- Controlador/metodo: `App\Http\Controllers\AlumnosRutasController@evidencia`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate:alumno`
- Modelos detectados: -
- Tablas detectadas: -

### `alumnos/actividades/guardar_evidencia`
- Metodo: `POST`
- Nombre: `alumnos.guardar_evidencia`
- Controlador/metodo: `App\Http\Controllers\AlumnosRutasController@guardarEvidencia`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate:alumno`
- Modelos detectados: -
- Tablas detectadas: -

### `alumnos/actividades/peticion_evidencia`
- Metodo: `GET|HEAD`
- Nombre: `alumnos.peticion_evidencia`
- Controlador/metodo: `App\Http\Controllers\AlumnosRutasController@peticionEvidencia`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate:alumno`
- Modelos detectados: -
- Tablas detectadas: -

### `alumnos/actividades/subir_evidencia`
- Metodo: `GET|HEAD`
- Nombre: `alumnos.subir_evidencia`
- Controlador/metodo: `App\Http\Controllers\AlumnosRutasController@subirEvidencia`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate:alumno`
- Modelos detectados: -
- Tablas detectadas: -

### `alumnos/autorizar/guardar/{nc}`
- Metodo: `GET|HEAD`
- Nombre: `alumnos.sta.autorizar.guargar`
- Controlador/metodo: `App\Http\Controllers\AlumnosStaController@autorizar`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate:alumno`
- Modelos detectados: -
- Tablas detectadas: -

### `alumnos/avance`
- Metodo: `GET|HEAD`
- Nombre: `alumnos.avance`
- Controlador/metodo: `App\Http\Controllers\AlumnosRutasController@avance`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate:alumno`
- Modelos detectados: -
- Tablas detectadas: -

### `alumnos/constancias/imprimir`
- Metodo: `GET|HEAD`
- Nombre: `alumnos.constancias_imprimir`
- Controlador/metodo: `App\Http\Controllers\AlumnosRutasController@imprimir`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate:alumno`
- Modelos detectados: -
- Tablas detectadas: -

### `alumnos/dfamiliares/guardar/{nc}`
- Metodo: `GET|HEAD`
- Nombre: `alumnos.sta.dfamiliares.guargar`
- Controlador/metodo: `App\Http\Controllers\AlumnosStaController@updtDatFam`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate:alumno`
- Modelos detectados: -
- Tablas detectadas: -

### `alumnos/dsociales/guardar/{nc}`
- Metodo: `GET|HEAD`
- Nombre: `alumnos.sta.dsociales.guargar`
- Controlador/metodo: `App\Http\Controllers\AlumnosStaController@updtDatSoc`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate:alumno`
- Modelos detectados: -
- Tablas detectadas: -

### `alumnos/editDatSalud/{nc}`
- Metodo: `GET|HEAD`
- Nombre: `alumnos.sta.editDatSalud`
- Controlador/metodo: `App\Http\Controllers\AlumnosStaController@editDatSalud`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate:alumno`
- Modelos detectados: -
- Tablas detectadas: -

### `alumnos/ficha`
- Metodo: `GET|HEAD`
- Nombre: `alumnos.sta.ficha`
- Controlador/metodo: `App\Http\Controllers\AlumnosStaController@ficha`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate:alumno`
- Modelos detectados: -
- Tablas detectadas: -

### `alumnos/ficha/guardar/{nc}`
- Metodo: `GET|HEAD`
- Nombre: `alumnos.sta.ficha.guargar`
- Controlador/metodo: `App\Http\Controllers\AlumnosStaController@guardarDatFam`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate:alumno`
- Modelos detectados: -
- Tablas detectadas: -

### `alumnos/home`
- Metodo: `GET|HEAD`
- Nombre: `alumnos.home_avance`
- Controlador/metodo: `App\Http\Controllers\AlumnosRutasController@avance`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate:alumno`
- Modelos detectados: -
- Tablas detectadas: -

### `alumnos/login`
- Metodo: `POST`
- Nombre: `alumnos.login`
- Controlador/metodo: `App\Http\Controllers\Auth\LoginController@alumnoLogin`
- Middleware: `web, App\Http\Middleware\RedirectIfAuthenticated`
- Modelos detectados: -
- Tablas detectadas: -

### `alumnos/pdf/{nc}`
- Metodo: `GET|HEAD`
- Nombre: `alumnos.sta.pdf`
- Controlador/metodo: `App\Http\Controllers\AlumnosStaController@pdf`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate:alumno`
- Modelos detectados: -
- Tablas detectadas: -

### `alumnos/sta/paciente/alumno/mis_citas`
- Metodo: `GET|HEAD`
- Nombre: `paciente.alumno.index.citas`
- Controlador/metodo: `App\Http\Controllers\PacienteController@index`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate:alumno`
- Modelos detectados: -
- Tablas detectadas: -

### `alumnos/updtDatSalud/{nc}`
- Metodo: `GET|HEAD`
- Nombre: `alumnos.sta.updtDatSalud`
- Controlador/metodo: `App\Http\Controllers\AlumnosStaController@updtDatSalud`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate:alumno`
- Modelos detectados: -
- Tablas detectadas: -

### `alumnos/{id}/edit/perfil`
- Metodo: `POST`
- Nombre: `alumnos.edit.perfil`
- Controlador/metodo: `App\Http\Controllers\AlumnosController@editPerfil`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate:alumno`
- Modelos detectados: -
- Tablas detectadas: -

### `alumnos/{id}/perfil`
- Metodo: `GET|HEAD`
- Nombre: `alumnos.perfil`
- Controlador/metodo: `App\Http\Controllers\AlumnosController@perfil`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate:alumno`
- Modelos detectados: -
- Tablas detectadas: -

### `api/user`
- Metodo: `GET|HEAD`
- Nombre: `-`
- Controlador/metodo: `Closure`
- Middleware: `api, Illuminate\Auth\Middleware\Authenticate:api`
- Modelos detectados: -
- Tablas detectadas: -

### `fileUploadPost`
- Metodo: `GET|HEAD`
- Nombre: `session_variable`
- Controlador/metodo: `App\Http\Controllers\ExcelController@fileUploadPost`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `getmsg`
- Metodo: `POST`
- Nombre: `getmsg`
- Controlador/metodo: `App\Http\Controllers\ExcelController@camMsg`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate`
- Modelos detectados: -
- Tablas detectadas: -

### `home`
- Metodo: `GET|HEAD`
- Nombre: `home`
- Controlador/metodo: `App\Http\Controllers\HomeController@index`
- Middleware: `web`
- Modelos detectados: -
- Tablas detectadas: -

### `login`
- Metodo: `GET|HEAD`
- Nombre: `login`
- Controlador/metodo: `App\Http\Controllers\Auth\LoginController@showLoginForm`
- Middleware: `web, App\Http\Middleware\RedirectIfAuthenticated`
- Modelos detectados: -
- Tablas detectadas: -

### `login`
- Metodo: `POST`
- Nombre: `-`
- Controlador/metodo: `App\Http\Controllers\Auth\LoginController@login`
- Middleware: `web, App\Http\Middleware\RedirectIfAuthenticated`
- Modelos detectados: -
- Tablas detectadas: -

### `logout`
- Metodo: `POST`
- Nombre: `logout`
- Controlador/metodo: `App\Http\Controllers\Auth\LoginController@logout`
- Middleware: `web`
- Modelos detectados: -
- Tablas detectadas: -

### `password/email`
- Metodo: `POST`
- Nombre: `password.email`
- Controlador/metodo: `App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail`
- Middleware: `web, App\Http\Middleware\RedirectIfAuthenticated`
- Modelos detectados: -
- Tablas detectadas: -

### `password/reset`
- Metodo: `GET|HEAD`
- Nombre: `password.request`
- Controlador/metodo: `App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm`
- Middleware: `web, App\Http\Middleware\RedirectIfAuthenticated`
- Modelos detectados: -
- Tablas detectadas: -

### `password/reset`
- Metodo: `POST`
- Nombre: `password.update`
- Controlador/metodo: `App\Http\Controllers\Auth\ResetPasswordController@reset`
- Middleware: `web, App\Http\Middleware\RedirectIfAuthenticated`
- Modelos detectados: -
- Tablas detectadas: -

### `password/reset/{token}`
- Metodo: `GET|HEAD`
- Nombre: `password.reset`
- Controlador/metodo: `App\Http\Controllers\Auth\ResetPasswordController@showResetForm`
- Middleware: `web, App\Http\Middleware\RedirectIfAuthenticated`
- Modelos detectados: -
- Tablas detectadas: -

### `perfil/password_mail`
- Metodo: `GET|HEAD`
- Nombre: `perfil.password_mail`
- Controlador/metodo: `App\Http\Controllers\PerfilController@passwordMail`
- Middleware: `web`
- Modelos detectados: -
- Tablas detectadas: -

### `perfil/password_reset`
- Metodo: `POST`
- Nombre: `perfil.password_reset`
- Controlador/metodo: `App\Http\Controllers\PerfilController@passwordReset`
- Middleware: `web`
- Modelos detectados: -
- Tablas detectadas: -

### `perfil/password_reset/view/{token}`
- Metodo: `GET|HEAD`
- Nombre: `perfil.password_reset.view`
- Controlador/metodo: `App\Http\Controllers\PerfilController@passwordResetView`
- Middleware: `web`
- Modelos detectados: -
- Tablas detectadas: -

### `perfil/password_reset_link`
- Metodo: `POST`
- Nombre: `perfil.password_reset_link`
- Controlador/metodo: `App\Http\Controllers\PerfilController@passwordResetLink`
- Middleware: `web`
- Modelos detectados: -
- Tablas detectadas: -

### `register`
- Metodo: `GET|HEAD`
- Nombre: `register`
- Controlador/metodo: `App\Http\Controllers\Auth\RegisterController@showRegistrationForm`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP`
- Modelos detectados: -
- Tablas detectadas: -

### `register`
- Metodo: `POST`
- Nombre: `-`
- Controlador/metodo: `App\Http\Controllers\Auth\RegisterController@register`
- Middleware: `web, Illuminate\Auth\Middleware\Authenticate, Spatie\Permission\Middleware\PermissionMiddleware:VIP`
- Modelos detectados: -
- Tablas detectadas: -

### `sanctum/csrf-cookie`
- Metodo: `GET|HEAD`
- Nombre: `sanctum.csrf-cookie`
- Controlador/metodo: `Laravel\Sanctum\Http\Controllers\CsrfCookieController@show`
- Middleware: `web`
- Modelos detectados: -
- Tablas detectadas: -

## 2. Inventario de modelos Eloquent
### `Actividad`
- Archivo: `app/Models/Actividad.php`
- Tabla: `actividad`
- Conexion: `default`
- Fillable/guarded: `[         'nombre','por_cred_actividad','id_actividad','id_user','alumnos','vigente','fecCierre'     ]`
- Casts: `(no definido)`
- Relaciones: evidencias: hasMany, credito: belongsTo, users: belongsTo, creador: belongsTo

### `Actividad_Evidencia`
- Archivo: `app/Models/Actividad_Evidencia.php`
- Tabla: `actividad_evidencia`
- Conexion: `default`
- Fillable/guarded: `[         'actividad_id','user_id','validador_id','validado'     ]`
- Casts: `(no definido)`
- Relaciones: participantes: hasMany, evidencias: hasMany

### `Alumno` — legado eliminado
- Archivo retirado: `app/Models/Alumno.php`
- Reemplazo obligatorio: `App\Models\Sit\Alumno` con conexión `sit`
- Clave operativa: `no_control`
- Perfil propio: `App\Models\AlumnoCreditosPerfil`
- Estado: `creditos.alumnos` eliminado por la migración del corte final

### `Area`
- Archivo: `app/Models/Area.php`
- Tabla: `areas`
- Conexion: `default`
- Fillable/guarded: `[     	"nombre","tipo"     ]`
- Casts: `(no definido)`
- Relaciones: (ninguna detectada)

### `AsignacionTutores`
- Archivo: `app/Models/AsignacionTutores.php`
- Tabla: `asignaciones_tutores`
- Conexion: `default`
- Fillable/guarded: `['gpo_Id','tut_Clave','gtu_Tipo','gtu_Semestre','gtu_Año','car_Clave']`
- Casts: `(no definido)`
- Relaciones: (ninguna detectada)

### `Avance`
- Archivo: `app/Models/Avance.php`
- Tabla: `avance`
- Conexion: `default`
- Fillable/guarded: `['no_control','id_credito','por_credito']`
- Casts: `(no definido)`
- Relaciones: credito: belongsTo, alumno: belongsTo

### `Cita`
- Archivo: `app/Models/Cita.php`
- Tabla: `citas`
- Conexion: `default`
- Fillable/guarded: `[         'paciente_id',                 'fecha_cita',         'hora_cita',         'motivo_consulta',         'estado_cita'     ]`
- Casts: `(no definido)`
- Relaciones: medico: belongsTo, paciente: belongsTo

### `Constancia`
- Archivo: `app/Models/Constancia.php`
- Tabla: `constancia`
- Conexion: `default`
- Fillable/guarded: `[     	'profesion_jefe_division','jefe_division','division_enuciado','division_enunciado','carrera','plan_de_estudios'     ]`
- Casts: `(no definido)`
- Relaciones: (ninguna detectada)

### `ConstanciaComplemento`
- Archivo: `app/Models/ConstanciaComplemento.php`
- Tabla: `constancia_complemento`
- Conexion: `default`
- Fillable/guarded: `[     	'institucion_info','numero_oficio','profesion_jefe_depto','jefe_depto','jefe_depto_enunciado','imagen_encabezado','imagen_pie','profesion_certificador','certificador','certificador_enunciado'     ]`
- Casts: `(no definido)`
- Relaciones: (ninguna detectada)

### `Credito`
- Archivo: `app/Models/Credito.php`
- Tabla: `creditos`
- Conexion: `default`
- Fillable/guarded: `['nombre','credito_jefe','vigente']`
- Casts: `(no definido)`
- Relaciones: actividades: hasMany, avances: hasMany

### `CreditoArea`
- Archivo: `app/Models/CreditoArea.php`
- Tabla: `creditos_areas`
- Conexion: `default`
- Fillable/guarded: `[     	"credito_id","credito_area"     ]`
- Casts: `(no definido)`
- Relaciones: (ninguna detectada)

### `Datos_familiares`
- Archivo: `app/Models/Datos_familiares.php`
- Tabla: `datos_familiares`
- Conexion: `default`
- Fillable/guarded: `(no definido)`
- Casts: `(no definido)`
- Relaciones: (ninguna detectada)

### `Direccion`
- Archivo: `app/Models/Direccion.php`
- Tabla: `direcciones`
- Conexion: `default`
- Fillable/guarded: `['id_alu','direccion','colonia','cp','municipio','estado']`
- Casts: `(no definido)`
- Relaciones: (ninguna detectada)

### `Evidencia`
- Archivo: `app/Models/Evidencia.php`
- Tabla: `evidencia`
- Conexion: `default`
- Fillable/guarded: `['status','nom_imagen','valida','id_asig_actividades', 'nom_original']`
- Casts: `(no definido)`
- Relaciones: participantes: hasMany, actividad: belongsTo, actividad_evidencia: belongsTo

### `Familiar`
- Archivo: `app/Models/Familiar.php`
- Tabla: `familiares`
- Conexion: `default`
- Fillable/guarded: `(no definido)`
- Casts: `(no definido)`
- Relaciones: (ninguna detectada)

### `Folio`
- Archivo: `app/Models/Folio.php`
- Tabla: `constancia_folios`
- Conexion: `default`
- Fillable/guarded: `["no_control", "no_folio"]`
- Casts: `(no definido)`
- Relaciones: (ninguna detectada)

### `GpoTutorias`
- Archivo: `app/Models/GpoTutorias.php`
- Tabla: `gpo_tutorias`
- Conexion: `default`
- Fillable/guarded: `[         'gpo_Nombre','no_Control',     ]`
- Casts: `(no definido)`
- Relaciones: (ninguna detectada)

### `Grupo`
- Archivo: `app/Models/Grupo.php`
- Tabla: `grupos`
- Conexion: `default`
- Fillable/guarded: `['gpo_Nombre','id_Carrera','gpo_Status','gpo_Semestre']`
- Casts: `(no definido)`
- Relaciones: (ninguna detectada)

### `Historial_Medico`
- Archivo: `app/Models/Historial_Medico.php`
- Tabla: `historiales_medicos`
- Conexion: `default`
- Fillable/guarded: `[         'paciente_id',         'cita_id',         'antecedentes',         'diagnosticos',         'tratamientos',                'notas_adicionales',         'semaforo'     ]`
- Casts: `(no definido)`
- Relaciones: paciente: belongsTo, cita: belongsTo

### `Historial_clinico`
- Archivo: `app/Models/Historial_clinico.php`
- Tabla: `historiales_clinicos`
- Conexion: `default`
- Fillable/guarded: `['id_alu','enfermedad','cap_dif','estatura','peso','sangre','serv_med']`
- Casts: `(no definido)`
- Relaciones: (ninguna detectada)

### `Mensaje`
- Archivo: `app/Models/Mensaje.php`
- Tabla: `mensajes`
- Conexion: `default`
- Fillable/guarded: `[     	"creador_id","mensaje","notificacion"     ]`
- Casts: `(no definido)`
- Relaciones: (ninguna detectada)

### `Motivoreprobacion`
- Archivo: `app/Models/Motivoreprobacion.php`
- Tabla: `motivosreprobacion`
- Conexion: `default`
- Fillable/guarded: `['no_control','materia','grup_cla','lse_clave','num_tema','motivos','comentario']`
- Casts: `(no definido)`
- Relaciones: (ninguna detectada)

### `Paciente`
- Archivo: `app/Models/Paciente.php`
- Tabla: `pacientes`
- Conexion: `default`
- Fillable/guarded: `[         'user_id',         'tipo',         'edad',         'alergias',         'enfermedades_cronicas',         'medicamentos_actuales',         'contacto_emergencia',         'telefono_emergencia',     ]`
- Casts: `(no definido)`
- Relaciones: user: belongsTo, citas: hasMany

### `Padres`
- Archivo: `app/Models/Padres.php`
- Tabla: `padres`
- Conexion: `default`
- Fillable/guarded: `(no definido)`
- Casts: `(no definido)`
- Relaciones: (ninguna detectada)

### `Participante`
- Archivo: `app/Models/Participante.php`
- Tabla: `participantes`
- Conexion: `default`
- Fillable/guarded: `['no_control','id_evidencia']`
- Casts: `(no definido)`
- Relaciones: alumno: belongsTo, evidencias: belongsTo, actividad_evidencia: belongsTo

### `Personales`
- Archivo: `app/Models/Personales.php`
- Tabla: `personales`
- Conexion: `default`
- Fillable/guarded: `(no definido)`
- Casts: `(no definido)`
- Relaciones: (ninguna detectada)

### `Receptor`
- Archivo: `app/Models/Receptor.php`
- Tabla: `receptores`
- Conexion: `default`
- Fillable/guarded: `[     	"mensaje_id","visto","fecha_visto","user_id"     ]`
- Casts: `(no definido)`
- Relaciones: (ninguna detectada)

### `Social`
- Archivo: `app/Models/Social.php`
- Tabla: `social`
- Conexion: `default`
- Fillable/guarded: `(no definido)`
- Casts: `(no definido)`
- Relaciones: (ninguna detectada)

## 3. Consultas que tocan `alumnos`
### `app/Exceptions/Handler.php`
- L74: `if(!Auth::Guard('web')->check() && !Auth::Guard('alumno')->check()){`
### `app/Http/Controllers/ActividadesController.php`
- L45: `'a.alumnos','c.nombre as credito_nombre','u.name as administrador','a.id_user',`
- L46: `DB::raw('count(par.id) as no_alumnos'), DB::raw('DATE_FORMAT(a.created_at, "%d-%m-%Y") as fecha_creacion'), DB::raw('DATE_FORMAT(a.fecCierre,"%d-%m-%Y") as fecCierre')`
- L104: `'onclick="redireccionar(' . $actividad->id . ');" title="Agregar participantes (Alumnos) a la actividad">' .`
- L286: `// Tercero: evaluar si la actividad era de alumnos responsables y estos ya tienen evidencia, no deberia dejar modificar.`
- L290: `|| $act_anterior->alumnos != $act_nueva->alumnos)`
### `app/Http/Controllers/altaAlumnosController.php`
- L6: `use App\Models\Alumno;`
- L7: `use App\Imports\AlumnosAgregar;`
- L11: `class altaAlumnosController extends Controller`
- L15: `return view('admin.ImportExcel.altAlumnos');`
- L18: `public function altaAlumnos(Request $request)`
- L29: `$array = Excel::toArray(new AlumnosAgregar, $request->file('excel'));`
- L38: `$alumno_ya_existe = Alumno::where('no_control','=',$row[0])->get()->count() > 0? true: false;`
- L40: `Alumno::updateOrCreate(`
- L56: `//Solo pasamos al siguiente registro si el alumno ya existe`
- L60: `Alert::success('Correcto','Se importaron '.$aluInsert.' alumnos de forma exitosa y se encontraron '.$aluRep.' alumnos repetidos');`
- L61: `return redirect()->route('ImportExcel.altaAlumnos');`
- L75: `Alert::error('Error', 'Ocurrió un error al cargar los alumnos: ' . $e->getMessage());`
### `app/Http/Controllers/AlumnosController.php`
- L8: `use App\Models\Alumno;`
- L19: `class AlumnosController extends Controller`
- L22: `$this->middleware('permission:VIP|VIP_SOLO_LECTURA|VER_ALUMNOS')->only(['index','show', 'cargarAlumnosAjax']);`
- L23: `$this->middleware('permission:VIP|CREAR_ALUMNOS')->only(['store','create']);`
- L24: `$this->middleware('permission:VIP|MODIFICAR_ALUMNOS')->only(['edit','update']);`
- L25: `$this->middleware('permission:VIP|ELIMINAR_ALUMNOS')->only(['destroy']);`
- L34: `return view('admin.alumnos.index');`
- L37: `public function cargarAlumnosAjax(Request $request) {`
- L42: `$alumnos = DB::table('alumnos as alu')`
- L46: `DataTableHelper::applyAllExcept($alumnos, $dtAttr, [DataTableHelper::PAGINATOR]);`
- L48: `foreach ($alumnos as $alumno) {`
- L49: `$alumno->status = ucwords($alumno->status);`
- L50: `$alumno->acciones = "";`
- L52: `if (Auth::User()->hasAnyPermission(['VIP','MODIFICAR_ALUMNOS'])) {`
- L53: `$alumno->acciones = $alumno->acciones . '<a href="'.route('alumnos.edit',[$alumno->alumno_id]) .'"`
- L54: `class="btn btn-warning btn-sm" title="Modificar alumno"><i class="fas fa-user-edit" style="font-size:14px"></i></a>';`
- L57: `if (Auth::User()->hasAnyPermission(['VIP','ELIMINAR_ALUMNOS'])) {`
- L58: `$alumno->acciones = $alumno->acciones . '<a  class="btn btn-danger btn-sm ml-1" onclick="undo_alumno(' .`
- L59: `$alumno->alumno_id .','."'". $alumno->nombre . "'". ')" data-toggle="modal" data-target="#myModalMsg" title="Eliminar alumno">`
- L63: `if (empty($alumno->acciones))`
- L64: `$alumno->acciones = 'NA';`
- L67: `$paginatorResponse = DataTableHelper::paginatorResponse($alumnos, $dtAttr);`
- L77: `return view('admin.alumnos.create')`
- L85: `$alumno = new Alumno($request->all());`
- L87: `$alumno->password=bcrypt($request->password);`
- L89: `$no_control_existe = Alumno::where('no_control','=',$request->no_control)->select('no_control')->get();`
- L94: `$alumno->email=$request->email;`
- L95: `$alumno->save();`
- L97: `Alert::success('Correcto', 'El alumno  '.$alumno->name.' se ha registrado de forma exitosa');`
- L98: `return redirect()->route('alumnos.index');`
- L105: `$alumno=Alumno::find($id);//Busca el registro`
- L106: `if($alumno==null){`
- L107: `Alert::error('Error','El alumno no existe');`
- L113: `return view('admin.alumnos.edit')`
- L114: `->with('alumno',$alumno)`
- L124: `$alumno= Alumno::find($id);`
- L125: `if($alumno==null){`
- L126: `Alert::error('Error','El alumno no existe');`
- L129: `//$avance = DB::table('avance')->where('no_control','=',$alumno->no_control)->get()->count()>0?true: false;`
- L130: `//$participante = DB::table('participantes')->where('no_control','=',$alumno->no_control)->get()->count()>0?true: false;`
- L131: `$alumno->nombre=$request->nombre;`
- L132: `$alumno->carrera=$request->carrera;`
- L133: `if($alumno->password!=$request->password)`
- L137: `$alumno->password= bcrypt($request->password);`
- L141: `Alert::error('Error','Error de credenciales, las contraseñas deben ser iguales para el alumno: '.$alumno->nombre);`
- L142: `return redirect()->route('alumnos.index');`
- L146: `$alumno->email=$request->email;`
- L147: `$alumno->save();`
- L149: `Alert::warning('Alerta','El alumno '. $alumno->nombre .' a sido editado de forma exitosa');`
- L151: `return redirect()->route('alumnos.index');`
- L158: `$alumno=Alumno::find($id);//Busca el registro`
- L159: `if($alumno==null){`
- L160: `Alert::error('Error','El alumno no existe');`
- L161: `return redirect()->route('alumnos.index');;`
- L163: `$participante = DB::table('participantes')->where('no_control','=',$alumno->no_control)->get()->count()>0?true:false;`
- L164: `$evidencia = DB::table('evidencia')->where('alumno_no_control','=',$alumno->no_control)->get()->count()>0?true:false;`
- L165: `$avance = DB::table('avance')->where('no_control','=',$alumno->no_control)->get()->count()>0?true:false;`
- L167: `Alert::error('Error','El alumno '.$alumno->nombre.' no puede ser eliminado por que esta registrado en algunas actividades');`
- L168: `return redirect()->route('alumnos.index');`
- L170: `$alumno->delete();//Elimina el registro`
- L171: `Alert::success('Correcto','El alumno '. $alumno->nombre .' a sido borrado de forma exitosa');//Envia mensaje`
- L172: `return redirect()->route('alumnos.index');//llama a la pagina de consultas`
- L179: `$alumno_data = DB::table('alumnos as alu')`
- L184: `return view('alumnos.perfil')`
- L192: `if(!Storage::has('public/alumnos/img')){`
- L193: `Storage::makeDirectory('public/alumnos/img');`
- L195: `$alumno = Alumno::find($id);`
- L223: `$path=storage_path().'/app/public/alumnos/img';`
- L224: `$path_to_verify = 'public/alumnos/img';`
- L229: `$name='foto_'.$alumno->no_control.'.'.strtolower($file->getClientOriginalExtension());`
- L232: `$alumno->foto=$name;//Obtiene el nombre de la imagen para guardarlo en la bd`
- L233: `$alumno->save();//Guarda el perfil del usuario`
- L235: `if($request->txtPassword!=$alumno->password)`
- L239: `$alumno->password=bcrypt($request->txtPassword);`
- L240: `$alumno->save();//Guarda el perfil del usuario`
- L257: `return redirect()->route('alumnos.perfil',$id);`
- L262: `$alumno=[];`
- L263: `return view('admin.alumnos.bajas')`
- L264: `->with('alumno',$alumno);`
- L271: `$alumno = DB::table('alumnos as alu')`
- L276: `if($alumno->isEmpty())`
- L278: `Alert::error('Error','Alumno no encontrado');`
- L279: `return view('admin.alumnos.bajas')`
- L280: `->with('alumno',$alumno);`
- L284: `return view('admin.alumnos.bajas')`
- L285: `->with('alumno',$alumno);`
- L291: `$alumno=Alumno::where('no_control',$request->cont)->get();`
- L292: `$alumno[0]->status=$request->status;`
- L293: `$alumno[0]->save();`
- L295: `Alert::success('Correcto','El status del alumno se modifico con exito');`
- L296: `return view('admin.alumnos.bajas')`
- L297: `->with('alumno',$alumno);`
### `app/Http/Controllers/AlumnosLoginController.php`
- L11: `class AlumnosLoginController extends Controller`
- L31: `protected $redirectTo = 'alumnos/home';`
- L79: `$this->guard('alumno')->logout();`
- L93: `return Auth::guard('alumno');`
### `app/Http/Controllers/AlumnosRutasController.php`
- L14: `use App\Models\ALumno;`
- L24: `class AlumnosRutasController extends Controller`
- L34: `//Consulta para obterner el avance del alumno`
- L35: `$alumno_data = DB::table('alumnos as alu')`
- L65: `//Validamos que el alumnos tenga algun avance`
- L67: `//SI no tiene avance solo retornamos los datos del alumno los datos del alumno`
- L69: `$alumno_data = DB::table('alumnos')->join('areas', function($join){`
- L70: `$join->on('areas.id','=','alumnos.carrera');`
- L71: `})->where('alumnos.no_control','=',Auth::User()->no_control)->select('alumnos.id as alumno_id','alumnos.nombre as nombre_alumno','areas.nombre as carrera','alumnos.no_control','alumnos.foto')->get();`
- L74: `return view('alumnos.avance')`
- L82: `$existe_alumno = Alumno::where('no_control','=',Auth::User()->no_control)->get()->count()>0? true: false;`
- L106: `$jefe_division = DB::table('alumnos as alu')->join('constancia as c', function($join){`
- L114: `$alumno = DB::table('alumnos')->join('areas','areas.id','=','alumnos.carrera')->where('alumnos.no_control','=',Auth::User()->no_control)->select('alumnos.nombre','alumnos.no_control','areas.nombre as carrera')->get();`
- L143: `'alumno' => $alumno[0],`
- L154: `$no_control = Auth::Guard('alumno')->user()->no_control;`
- L188: `if ($creditos_liberados >= 5 && Auth::guard('alumno')->user()->status === 'pendiente') {`
- L189: `$alumno = Alumno::find(Auth::guard('alumno')->user()->id);`
- L190: `$alumno->status = 'Liberado';`
- L191: `$alumno->save();`
- L192: `} else if (Auth::guard('alumno')->user()->status === 'Liberado') {`
- L193: `$alumno = Alumno::find(Auth::guard('alumno')->user()->id);`
- L194: `$alumno->status = 'pendiente';`
- L195: `$alumno->save();`
- L202: `$alumno_data = Alumno::where('no_control',Auth::User()->no_control)->select('id as alumno_id')->get();`
- L211: `->select('a.nombre as actividad_nombre','a.id as actividad_id','a.por_cred_actividad as actividad_porcentaje','a.alumnos','ae.validado','ae.user_id','c.nombre as credito_nombre','p.momento_agregado','p.evidencia_validada')`
- L214: `return view('alumnos.actividades')`
- L220: `$alumno_data = Alumno::where('no_control',Auth::User()->no_control)->select('id as alumno_id')->get();`
- L234: `if($actividad->alumnos == "true" && ($participante->momento_agregado == "anteriormente" || $participante->evidencia_validada == "si")){`
- L236: `return redirect()->route('alumnos.actividades');`
- L245: `return view('alumnos.subir_evidencia')`
- L261: `return redirect()->route('alumnos.actividades');`
- L294: `return redirect()->route('alumnos.actividades');`
- L326: `return redirect()->route('alumnos.actividades');`
- L330: `$alumno_data = Alumno::where('no_control',Auth::User()->no_control)->select('id as alumno_id')->get();`
- L333: `return redirect()->route('alumnos.home_avance');`
- L336: `return redirect()->route('alumnos.home_avance');`
- L361: `return redirect()->route('alumnos.actividades');`
- L363: `return view('alumnos.evidencia')`
### `app/Http/Controllers/AlumnosStaController.php`
- L8: `use App\Models\Alumno;`
- L18: `class AlumnosStaController extends Controller`
- L23: `$alu = Alumno::where('no_control',$no_cont)->first();`
- L24: `$alu1 = DB::connection('SIT')->table('alumnos')->where('alu_NumControl', $no_cont)->first();`
- L76: `$alumno_data = Alumno::where('no_control',Auth::User()->no_control)->select('id as alumno_id')->get();`
- L77: `return view('alumnos.sta.ficha',compact('alu2', 'alu1', 'dPad', 'dMad', 'direccion', 'direccionP', 'direccionM', 'alu', 'car', 'clinicos', 'person','alumno_data'));`
- L83: `$alu = Alumno::where('no_control',$nc)->first();`
- L160: `return redirect()->route('alumnos.sta.editDatSalud', $alu->no_control);`
- L165: `$alu = Alumno::where('no_control',$nc)->first();`
- L166: `$alu1 = DB::connection('SIT')->table('alumnos')->where('alu_NumControl', $nc)->first();`
- L168: `$alumno_data = Alumno::where('no_control',Auth::User()->no_control)->select('id as alumno_id')->get();`
- L169: `return view('alumnos.sta.dsalud', compact('alu1', 'alu', 'clinicos','alumno_data'));`
- L176: `$alu = Alumno::where('no_control',$nc)->first();`
- L259: `$alumno_data = Alumno::where('no_control',Auth::User()->no_control)->select('id as alumno_id')->get();`
- L260: `$alu1 = DB::connection('SIT')->table('alumnos')->where('alu_NumControl', $nc)->first();`
- L268: `return view('alumnos.sta.dfamiliares', compact('alu1', 'alu', 'fam', 'familiares','alumno_data'));`
- L282: `//Buscamos al alumno`
- L283: `$alu = Alumno::where('no_control',$nc)->first();`
- L318: `$alu1 = DB::connection('SIT')->table('alumnos')->where('alu_NumControl', $nc)->first();`
- L325: `$alumno_data = Alumno::where('no_control',Auth::User()->no_control)->select('id as alumno_id')->get();`
- L326: `return view('alumnos.sta.dsocial', compact('alu1', 'alu', 'soc','alumno_data'));`
- L340: `$alu = Alumno::where('no_control',$nc)->first();`
- L366: `$alu1 = DB::connection('SIT')->table('alumnos')->where('alu_NumControl', $nc)->first();`
- L367: `$alumno_data = Alumno::where('no_control',Auth::User()->no_control)->select('id as alumno_id')->get();`
- L368: `return view('alumnos.sta.autorizar', compact('alu1', 'alu','alumno_data'));`
- L380: `$alu = Alumno::where('no_control',$nc)->first();`
- L383: `return redirect()->route('alumnos.sta.pdf', $nc);`
- L390: `$alu = Alumno::where('no_control',$nc)->first();`
- L391: `$alu1 = DB::connection('SIT')->table('alumnos')->where('alu_NumControl', $nc)->first();`
- L409: `$pdf = PDF::setOptions(['defaultFont' => 'sans-serif'])->loadView('alumnos.sta.pdf', compact('familiares', 'alu1', 'alu2', 'car', 'dPad', 'dMad', 'direccion', 'direccionP', 'direccionM', 'soc', 'alu',  'clinicos', 'person', 'fam'));`
### `app/Http/Controllers/AreasController.php`
- L8: `use App\Models\ALumno;`
- L75: `$tiene_alumnos = Alumno::where('carrera','=',$id)->get()->count() > 0?true: false;`
- L76: `if($tiene_alumnos || $tiene_usuarios){`
### `app/Http/Controllers/Auth/LoginController.php`
- L100: `// Intentar autenticar con el guard 'alumno'`
- L101: `if (\Auth::guard('alumno')->attempt(['email' => $request->email, 'password' => $request->password])) {`
- L102: `return redirect()->intended('alumnos/home');`
### `app/Http/Controllers/ConstanciasController.php`
- L13: `use App\Models\Alumno;`
- L122: `$existe_alumno = Alumno::where('no_control','=',$request->no_control)->get()->count()>0? true: false;`
- L147: `$jefe_division = DB::table('alumnos as alu')->join('constancia as c', function($join) use($request){`
- L155: `$alumno = DB::table('alumnos')->join('areas','areas.id','=','alumnos.carrera')->where('alumnos.no_control','=',$request->no_control)->select('alumnos.nombre','alumnos.no_control','areas.nombre as carrera')->get();`
- L158: `Alert::error('Error','El alumno aun no liberado todos sus credito complementarios');`
- L184: `'alumno' => $alumno[0],`
### `app/Http/Controllers/CreditosController.php`
- L27: `//Aqui mandamos llamar la vista de la pagina de inicio de alumnos`
### `app/Http/Controllers/EvidenciasController.php`
- L209: `->leftjoin('alumnos as alu','alu.no_control','=','e.alumno_no_control')`
- L224: `->leftjoin('alumnos as alu','alu.no_control','=','e.alumno_no_control')`
### `app/Http/Controllers/ExcelController.php`
- L7: `use App\Models\Alumno;`
- L8: `use App\Imports\AlumnosImport;`
- L32: `$array = Excel::toArray(new AlumnosImport, $request->file('excel'));`
- L49: `$actualizados = DB::table('alumnos')`
### `app/Http/Controllers/GruposController.php`
- L165: `//Quitamos los alumnos asignados a este grupo de la tabla gpo_tutorias`
### `app/Http/Controllers/HomeController.php`
- L18: `if(Auth::guard('alumno')->check()){`
- L19: `return redirect()->route('alumnos.home_avance');`
### `app/Http/Controllers/JefesController.php`
- L12: `use App\Models\Alumno;`
- L48: `$generaciones = DB::connection('SIT')->table('alumnos')`
- L49: `->select("alumnos.Alu_AnioIngreso")`
- L50: `->where('alumnos.Alu_AnioIngreso', '!=', 0)`
- L51: `->whereNotNull('alumnos.Alu_AnioIngreso')`
- L56: `return view('sta/analisis_alumnos/index')`
- L66: `// Obtener el grupo de alumnos basado en carrera y año de ingreso`
- L67: `$grupo = DB::connection('SIT')->table('alumnos')`
- L76: `->where('alumnos.car_Clave', '=', $request->carrera)`
- L77: `->where('alumnos.Alu_AnioIngreso', '=', $request->generacion)`
- L78: `->orderBy('alumnos.alu_ApePaterno', 'asc')`
- L81: `// Si no hay alumnos, enviar advertencia y retornar`
- L83: `Alert::warning('No hay alumnos registrados en esta generación')->showConfirmButton('Ok', '#3085d6');`
- L87: `// Obtener las fichas de los alumnos en una sola consulta usando la tabla Alumno`
- L88: `$fichas = Alumno::whereIn('no_control', $grupo->pluck('control'))`
- L114: `$generaciones = DB::connection('SIT')->table('alumnos')`
- L123: `return view('sta.analisis_alumnos.index', compact('grupo', 'carreras', 'generaciones'))`
- L132: `$buscarAlumno = DB::connection('SIT')->table('alumnos')`
- L133: `->join('carreras','carreras.car_Clave', '=','alumnos.car_Clave')`
- L134: `->select("alumnos.alu_NumControl",'alumnos.alu_StatusAct',"alumnos.alu_Nombre","alumnos.alu_ApePaterno","alumnos.alu_ApeMaterno","alumnos.alu_SemestreAct","carreras.car_Nombre","alumnos.alu_Sexo")`
- L138: `//Consultamos las observaciones de cada alumno y las agregamos a $buscarAlumno`
- L139: `$obs=DB::table('alumnos')->where('no_control',$nc)->select('observaciones')->first();`
- L151: `//Obtenemos el semaforo academico correspondiente para este alumno`
- L154: `$GetGrupos = DB::connection('SIT')->table('alumnos')`
- L155: `->join('listassemestre','listassemestre.alu_NumControl','=','alumnos.alu_NumControl')`
- L158: `->where("alumnos.alu_NumControl","=",$nc)`
- L232: `return view('sta.analisis_alumnos.diagnostico')`
- L233: `-> with ('alumnos',$buscarAlumno)`
- L247: `'alumnos.alu_StatusAct',`
- L254: `->join('alumnos', 'alumnos.alu_NumControl', '=', 'cardex.alu_NumControl')`
- L256: `->groupBy('alumnos.alu_StatusAct')`
- L271: `$semaforos['titleAcad'] = 'Ya no es posible realizar acciones de seguimiento con este alumno';`
- L275: `$semaforos['titleAcad'] = 'El alumno tiene problemas académicos graves, urgente dar seguimiento';`
- L279: `$semaforos['titleAcad'] = 'El alumno tiene problemas académicos moderados, se recomienda dar seguimiento';`
- L283: `$semaforos['titleAcad'] = 'El alumno tiene problemas académicos leves, se recomienda observación';`
- L287: `$semaforos['titleAcad'] = 'El alumno no tiene problemas académicos';`
- L299: `$semaforos['titleAcad'] = 'Este alumno aún no tiene indicadores académicos registrados';`
- L343: `//Verificamos si el alumno ya tiene registrado el servicio social en cardex`
- L350: `//cambiamos el semaforo si el alumno ya tiene registrado el servicio social`
- L358: `$status= DB::connection('SIT')->table('alumnos')`
- L359: `->select('alumnos.alu_NumControl','alumnos.alu_SemestreAct','alumnos.alu_StatusAct','planesestudios.pes_CredTot','alumnos.alu_CreditosAcum','alumnos.alu_Inscrito')`
- L360: `->join('planesestudios','planesestudios.pes_Clave','=','alumnos.pes_Clave')`
- L361: `->where('alumnos.alu_NumControl','=',$nc)->first();`
- L367: `$semaforos['titleSS'] = 'Este alumno no tiene registros de servicio social';`
- L374: `$semaforos['titleSS'] = 'El status del alumno es baja, consultar con servicios escolares';`
- L384: `$semaforos['titleSS'] = 'Este alumno aún no reune los requicitos para tramitar servicio social';`
- L389: `$semaforos['titleSS'] = 'Verificar que el alumno este realizando servicio social';`
- L399: `$semaforos['titleSS'] = 'Este alumno no tiene registros de servicio social';`
- L410: `$alu = Alumno::where('no_control',$nc)->first();`
- L411: `$alu1 = DB::connection('SIT')->table('alumnos')->where('alu_NumControl', $nc)->first();`
- L432: `return view('sta.analisis_alumnos.ficha', compact('familiares', 'alu1', 'alu2', 'car','padres', 'direccion', 'direccionP', 'direccionM', 'soc', 'alu',  'clinicos', 'person', 'fam'));`
- L439: `Alert::error('Error', 'Este alumno no ha llenado su ficha académica');`
- L444: `Alert::error('Error', 'Este alumno no ha llenado su ficha académica');`
- L455: `//Funcion para guardar las observaciones del alumno`
- L460: `$alumno = Alumno::where('no_control', $noControl)->firstOrFail();`
- L461: `$alumno->observaciones = $request->observaciones;`
- L462: `$alumno->save();`
- L472: `'mensaje' => 'No se encontró el registro del alumno: '.$noControl.', es probable que no esté registrado en la base de datos de creditos, infórmalo al administrador de sistemas',`
### `app/Http/Controllers/ParticipantesController.php`
- L10: `use App\Models\Alumno;`
- L112: `})->join('actividad as act','act.id','=','ae.actividad_id')->select('act.id as actividad_id','act.alumnos as evidencia_individual','act.vigente','ae.id as ae_id','p.no_control as no_control','act.nombre as actividad_nombre')->get()[0];`
- L134: `// La function liberar cambia es estado del alumno (parámetro: no_control) segun su avance`
- L170: `->where('p.id','=',$participante->id)->select('ae.actividad_id','ae.validado','act.alumnos as alumnos_responsables')->get()[0];`
- L172: `if(!$es_creador_actividad && $actividad_evidencia->alumnos_responsables == "false" && $actividad_evidencia->validado == "true"){`
- L174: `}else if(!$es_creador_actividad && $actividad_evidencia->alumnos_responsables == "true" && $actividad_evidencia->validado == "true" && ($participante->evidencia_validada == "si" || $participante->evidencia_validada == "na")){`
- L211: `->join('alumnos as a','a.no_control','=','p.no_control')`
- L294: `$existe_no_control = DB::table('alumnos')->select('no_control')->where('no_control','=',$request->get('no_control'))->get();`
- L320: `if($evidencias[0]->validado == 'true' && $actividad->alumnos == 'true' && (Auth::User()->hasAnyPermission(['VIP','VIP_ACTIVIDAD']) || $es_creador_actividad)){`
- L399: `$alumno = Alumno::where('no_control','=',$no_control)->get()[0];`
- L400: `$alumno->status = "Liberado";`
- L401: `$alumno->save();`
- L403: `$alumno = Alumno::where('no_control','=',$no_control)->get()[0];`
- L404: `$alumno->status = "Pendiente";`
- L405: `$alumno->save();`
- L411: `$lista_alumnos = Alumno::select('nombre','no_control')->where('nombre','like',"%$request->nombre%")->orderBy('nombre')->get();`
- L413: `$lista_alumnos = Alumno::select('nombre')->where('no_control','=',$request->no_control)->get();`
- L415: `return response()->json($lista_alumnos);`
- L449: `return redirect()->route('alumnos.actividades');`
- L451: `$alumno = Alumno::where('no_control','=',$participante->no_control)->get()[0];`
- L457: `->with('alumno',$alumno)`
- L506: `->select('ae.id as ae_id','p.no_control','act.nombre','c.vigente as credito_vigente','act.vigente as actividad_vigente','act.alumnos as alumnos_responsables','act.id_user as administrador_id','act.id as actividad_id','act.por_cred_actividad','ae.validado as actividad_validada','c.id as credito_id')-`
- L517: `if($actividad_data->alumnos_responsables == "false"){`
- L518: `Alert::error('Error','Esta actividad no es para alumnos responsables');`
### `app/Http/Controllers/PerfilController.php`
- L12: `use App\Models\Alumno;`
- L37: `$emaila=Alumno::where('email', $request->email)->first();`
- L135: `$user= Alumno::where('email',$email)->first();`
### `app/Http/Controllers/SistemaMedicoController.php`
- L11: `use App\Models\Alumno;`
- L86: `//Verificamos si es alumno y consultamos su nombre de la tabla pacientes de lo contrario consultamos el nombre de la tabla usuarios y lo agregamos a $paciente`
- L87: `if($paciente->tipo=='Alumno'){`
- L88: `$usuarioPaciente=Alumno::where('id',$paciente->user_id)->first();`
- L94: `$dat_medicos=Alumno::where('id',$paciente->id)->first(['sem_med', 'observaciones_med']);`
- L100: `//Verificamos si el paciente es alumno para guardar su semaforo, en caso contrario solo enviamos un mensaje de error`
- L103: `if($paciente->tipo=='Alumno'){`
- L104: `//Guardamos el semaforo en la tabla de alumnos`
- L105: `$alumno= Alumno::where('id',$paciente->id)->first();`
- L106: `$alumno->sem_med = $request->input('semaforo');`
- L107: `$alumno->observaciones_med = $alumno->observaciones_med + $request->input('observaciones_med');`
- L108: `$alumno->save();`
- L114: `Alert::error('Error','Solo los pacientes de tipo Alumno pueden tener semáforo médico.');`
- L196: `//Si es alumno buscamos su historial clinico de lo contrario lo omitimos`
- L197: `if($paciente->tipo=='Alumno'){`
### `app/Http/Controllers/STAController.php`
- L175: `->join('alumnos','listassemestre.alu_NumControl','=','alumnos.alu_NumControl')`
- L177: `->join('planesestudios','alumnos.pes_Clave','=','planesestudios.pes_Clave')`
- L182: `->select('listassemestre.gse_Clave','listassemestre.lse_Clave','alumnos.alu_NumControl','alumnos.alu_Nombre','alumnos.alu_ApePaterno','alumnos.alu_ApeMaterno','listassemestrecom.lsc_Calificacion')`
- L183: `->orderBy('alumnos.alu_Nombre','asc')`
- L195: `['no_control' => $request->alumno, 'grup_cla' => $request->gse_clave, 'num_tema'=>$request->unidad],`
- L310: `//Seleccionamos todos los alumnos de los ultimos 7 años para llenar el select de alumnos`
- L311: `$alumnos = DB::connection('SIT')->table('alumnos')`
- L316: `// Obtén todos los alumnos del grupo en una sola consulta`
- L317: `$alumnosGrupo = GpoTutorias::where('gpo_Nombre', $gpo_Nombre)->get();`
- L319: `// Obtén los números de control de los alumnos del grupo`
- L320: `$noControles = $alumnosGrupo->pluck('no_Control')->toArray();`
- L322: `// Consulta todos los datos de los alumnos correspondientes a los números de control en una sola consulta`
- L323: `$alumnosDatos = DB::connection('SIT')->table('alumnos')`
- L328: `// Consulta las fichas de los alumnos en una sola consulta`
- L329: `$fichas = DB::table('alumnos')`
- L334: `// Itera sobre los alumnos del grupo y agrega los datos correspondientes`
- L335: `foreach ($alumnosGrupo as $alumno) {`
- L336: `// Verifica si el alumno existe en la base de datos SIT`
- L337: `if (isset($alumnosDatos[$alumno->no_Control])) {`
- L338: `$alumnoTem = $alumnosDatos[$alumno->no_Control];`
- L339: `$alumno->alu_Nombre = strtoupper($alumnoTem->alu_Nombre) . ' ' . strtoupper($alumnoTem->alu_ApePaterno) . ' ' . strtoupper($alumnoTem->alu_ApeMaterno);`
- L340: `$alumno->status = $alumnoTem->alu_StatusAct;`
- L342: `$alumno->alu_Nombre = 'EL ALUMNO NO EXISTE, VERIFICA SU NUMERO DE CONTROL!';`
- L346: `if (isset($fichas[$alumno->no_Control])) {`
- L347: `$alumno->ficha = $fichas[$alumno->no_Control]->ficha;`
- L349: `$alumno->ficha = 0;`
- L353: `foreach ($alumnosGrupo as $row) {`
- L357: `return view('sta.tutores.showGrupo',compact('grupo','alumnos','alumnosGrupo'));`
- L400: `//Función para guardar los alumnos de un grupo`
- L406: `$alumno = DB::connection('SIT')->table('alumnos')`
- L409: `if($alumno==null)`
- L410: `return response()->json(['message' => 'El alumno con numero de control: '. $request->no_Control .', no existe en la base de datos de control escolar'], 500);`
- L427: `//Función para eliminar un alumno de un grupo`
- L448: `// Obtener los alumnos del grupo`
- L449: `$alumnosGrupo = GpoTutorias::where('gpo_Nombre', $grupo[0]->gpo_Nombre)->get();`
- L451: `// Obtener todos los alumnos y sus datos en una sola consulta`
- L452: `$noControles = $alumnosGrupo->pluck('no_Control'); // Recolectar los no_Control de los alumnos`
- L453: `$alumnosTem = DB::connection('SIT')->table('alumnos')`
- L458: `// Verificar y asignar datos del alumno en el grupo`
- L459: `foreach($alumnosGrupo as $alumno) {`
- L460: `if (isset($alumnosTem[$alumno->no_Control])) {`
- L461: `$alumnoTem = $alumnosTem[$alumno->no_Control];`
- L462: `$alumno->alu_Nombre = strtoupper($alumnoTem->alu_Nombre) . ' ' . strtoupper($alumnoTem->alu_ApePaterno) . ' ' . strtoupper($alumnoTem->alu_ApeMaterno);`
- L463: `$alumno->status = $alumnoTem->alu_StatusAct;`
- L465: `$alumno->alu_Nombre = 'EL ALUMNO NO EXISTE, VERIFICA SU NUMERO DE CONTROL!';`
- L469: `// Obtener todas las materias y calificaciones de los alumnos en una sola consulta`
- L479: `// Asignar materias a cada alumno`
- L480: `foreach($alumnosGrupo as $alumno) {`
- L481: `$alumno->materias = $materias->get($alumno->no_Control, collect()); // Si no hay materias, asigna una colección vacía`
- L484: `return view('sta.tutores.analisis', compact('grupo', 'alumnosGrupo'));`
### `app/Http/Controllers/UsersController.php`
- L161: `return redirect()->route('alumnos.index');`
### `app/Http/Controllers/VerificaEvidenciaController.php`
- L9: `use App\Models\Alumno;`
- L27: `$this->middleware('permission:VIP|VIP_SOLO_LECTURA|VER_AVANCE_ALUMNO|VIP_AVANCE_ALUMNO')->only('alumnosBusqueda');`
- L88: `public function eliminarAlumnosSinEvidencia($todos_los_alumnos, $alumnos_con_evidencia){`
- L89: `foreach($todos_los_alumnos as $alumno){`
- L91: `foreach($alumnos_con_evidencia as $alumno_con_evidencia){`
- L92: `if($alumno->no_control == $alumno_con_evidencia->no_control){`
- L98: `Participante::destroy($alumno->id);`
- L129: `// Validamos si la actividad es de alumnos responsables (Cada alumno es responsable de su`
- L131: `if($actividad->alumnos == 'true'){`
- L139: `$this->eliminarAlumnosSinEvidencia($participantes_lista, $participantes_con_evidencia);`
- L177: `$alumno = Alumno::where('no_control','=',$no_control)->get()[0];`
- L178: `$alumno->status = "Liberado";`
- L179: `$alumno->save();`
- L202: `$alumno = DB::table('alumnos')->where('no_control','=',$request->get('no_control'))->get();`
- L203: `if($alumno->count() == 0){`
- L208: `if(!Auth::User()->hasAnyPermission(['VIP','VIP_AVANCE_ALUMNO']) && $alumno[0]->carrera!=Auth::User()->area){`
- L209: `Alert::error('Error','No puedes consultar avances de alumnos de otras carreras');`
- L213: `//Consulta para obterner el avance del alumno`
- L214: `$alumno_data = DB::table('alumnos as alu')->join('participantes as p', function($join) use ($request){`
- L233: `//Validamos que el alumnos tenga algun avance`
- L235: `//SI no tiene avance solo retornamos los datos del alumno los datos del alumno`
- L237: `$alumno_data= DB::table('alumnos as alu')->join('areas as a','a.id','=','alu.carrera')->select('alu.nombre as nombre_alumno','a.nombre as carrera','alu.no_control','alu.foto')->where('alu.no_control','=',$request->get('no_control'))->get();`
- L249: `$alumno = Alumno::where('no_control', '=', $no_control)->get();`
- L251: `if (!$alumno) return false;`
- L252: `$alumno = $alumno[0];`
- L286: `if ($creditos_liberados >= 5 && $alumno->status === 'pendiente') {`
- L287: `$alumno->status = 'Liberado';`
- L288: `$alumno->save();`
- L289: `} else if ($alumno->status === 'Liberado') {`
- L290: `$alumno->status = 'pendiente';`
- L291: `$alumno->save();`
- L310: `$reportes_data = DB::select('select alumnos.nombre,alumnos.status, alumnos.no_control, areas.nombre as carrera, if(avance.por_credito is null or avance.por_credito > 100, if( avance.por_credito > 100, 100, 0), avance.por_credito) as por_credito, creditos.nombre as nombre_credito from alumnos join cr`
- L313: `$suma_creditos = DB::select('select if(sum(case when por_credito > 100 then 100 else por_credito end) is null,0,sum(case when por_credito > 100 then 100 else por_credito end)) as credito_suma,alumnos.id as alumno_id ,alumnos.nombre,alumnos.status, alumnos.no_control, areas.nombre as carrera, if(avan`
- L317: `$reportes_data = DB::select('select alumnos.nombre,alumnos.status, alumnos.no_control, areas.nombre as carrera, if(avance.por_credito is null or avance.por_credito > 100, if( avance.por_credito > 100, 100, 0), avance.por_credito) as por_credito, creditos.nombre as nombre_credito from alumnos join cr`
- L320: `$suma_creditos = DB::select('select if(sum(case when por_credito > 100 then 100 else por_credito end) is null,0,sum(case when por_credito > 100 then 100 else por_credito end)) as credito_suma,alumnos.id as alumno_id ,alumnos.nombre,alumnos.status, alumnos.no_control, areas.nombre as carrera, if(avan`
- L340: `$reportes_data = DB::select('select alumnos.nombre,alumnos.status, alumnos.no_control, areas.nombre as carrera, if(avance.por_credito is null or avance.por_credito > 100, if( avance.por_credito > 100, 100, 0), avance.por_credito) as por_credito, creditos.nombre as nombre_credito from alumnos join cr`
- L342: `$suma_creditos = DB::select('select if(sum(case when por_credito > 100 then 100 else por_credito end) is null,0,sum(case when por_credito > 100 then 100 else por_credito end)) as credito_suma,alumnos.id as alumno_id ,alumnos.nombre, alumnos.status, alumnos.no_control, areas.nombre as carrera, if(ava`
- L346: `$reportes_data = DB::select('select alumnos.nombre,alumnos.status, alumnos.no_control, areas.nombre as carrera, if(avance.por_credito is null or avance.por_credito > 100, if( avance.por_credito > 100, 100, 0), avance.por_credito) as por_credito, creditos.nombre as nombre_credito from alumnos join cr`
- L348: `$suma_creditos = DB::select('select if(sum(case when por_credito > 100 then 100 else por_credito end) is null,0,sum(case when por_credito > 100 then 100 else por_credito end)) as credito_suma,alumnos.id as alumno_id ,alumnos.nombre, alumnos.status, alumnos.no_control, areas.nombre as carrera, if(ava`
- L376: `public function alumnosBusqueda(Request $request){`
- L379: `$lista_alumnos = Alumno::select('nombre','no_control')->where('nombre','like',"%$request->nombre%")->orderBy('nombre');`
- L381: `$lista_alumnos = Alumno::select('nombre')->where('no_control','=',$request->no_control);`
- L385: `$lista_alumnos = Alumno::select('nombre','no_control')->where([`
- L390: `$lista_alumnos = Alumno::select('nombre')->where([`
- L396: `$lista_alumnos = $lista_alumnos->limit(100)->get();`
- L397: `return response()->json($lista_alumnos);`
### `app/Imports/AlumnosAgregar.php`
- L5: `use App\Alumno;`
- L8: `class AlumnosAgregar implements ToModel`
- L19: `return new alumno([`
### `app/Imports/AlumnosImport.php`
- L5: `use App\Alumno;`
- L11: `class AlumnosImport implements ToModel`
- L22: `return new alumno([`
### `app/Models/Actividad.php`
- L13: `'nombre','por_cred_actividad','id_actividad','id_user','alumnos','vigente','fecCierre'`
### `app/Models/Alumno.php`
- L10: `class Alumno extends Authenticatable`
- L17: `protected $table="alumnos";`
- L22: `//Relacion con la tablas de alumno(uno) a participante(muchos)`
- L28: `//Relacion con la tablas de alumno(uno) a Avances(muchos)`
### `app/Models/Avance.php`
- L20: `//Relacion con la tablas de alumno(uno) a Avances(muchos)`
- L21: `public function alumno()`
- L23: `return $this->belongsTo('App\Alumno');`
### `app/Models/Participante.php`
- L14: `//Relacion de la tabla alumno(uno)-participante(muchos)`
- L15: `public function alumno()`
- L17: `return $this->belongsTo('App\Alumno');`
### `routes/web.php`
- L17: `use App\Http\Controllers\AlumnosController;`
- L18: `use App\Http\Controllers\AlumnosRutasController;`
- L25: `use App\Http\Controllers\AlumnosStaController;`
- L45: `/*Ruta para dar de alta alumnos en masa*/`
- L46: `Route::post('Import/alta', 'altaAlumnosController@altaAlumnos')->name('excel.aluImport');`
- L47: `Route::get('Import/altas','altaAlumnosController@index')->name('ImportExcel.altaAlumnos');`
- L52: `}else if(Auth::guard('alumno')->check()){`
- L53: `return redirect("alumnos/home");`
- L56: `})->name('alumnos.login');`
- L58: `Route::post('/alumnos/login', [App\Http\Controllers\Auth\LoginController::class, 'alumnoLogin'])->name('alumnos.login');`
- L86: `/****Rutas para el controlador de alumnos, con el group::resource, nos crean todas las rutas, para el controlador especificado*****/`
- L89: `/****Rutas para el controlador de alumnos*****/`
- L90: `//Route::resource('alumnos','AlumnosController');`
- L91: `Route::get('alumnos/cargar_alumnos_ajax', [AlumnosController::class, 'cargarAlumnosAjax'])->name('admin.alumnos.cargar.ajax');`
- L92: `Route::get('/alumnos/index',[AlumnosController::class,'index'])->name('alumnos.index');`
- L93: `Route::get('/alumnos/{id}/edit',[AlumnosController::class,'edit'])->name('alumnos.edit');`
- L94: `Route::post('/alumnos/{id}/update',[AlumnosController::class,'update'])->name('alumnos.update');`
- L95: `Route::post('/alumnos/store',[AlumnosController::class,'store'])->name('alumnos.store');`
- L96: `Route::get('/alumnos/create',[AlumnosController::class,'create'])->name('alumnos.create');`
- L97: `Route::get('/alumnos/{id}/destroy',[AlumnosController::class,'destroy'])->name('alumnos.destroy');`
- L98: `Route::get('/alumnos/Bajas/view',[AlumnosController::class,'bajas'])->name('alumnos.bajas.view');`
- L99: `Route::get('/alumnos/buscar',[AlumnosController::class,'buscar'])->name('alumnos.buscar');`
- L100: `Route::get('/alumnos/editarStatus',[AlumnosController::class,'editStatus'])->name('alumnos.editarStatus');`
- L177: `Route::get('verifica_evidencia/alumno/busqueda','VerificaEvidenciaController@alumnosBusqueda')->name('verifica_evidencia.alumnos_busqueda');`
- L230: `Route::get('/sta/analisis/alumno/{nc}',[JefesController::class,'diagnostico'])->name('analisis.alumno');`
- L232: `Route::get('/sta/pdf/{nc}', [AlumnosStaController::class,'pdf'])->name('analisis.sta.pdf');`
- L259: `Route::post('/sta/tutores/delete/alumno',[STAController::class,'deleteAlumno'])->name('tutores.deleteAlumno');`
- L260: `Route::post('/sta/tutores/store/alumno/observaciones',[JefesController::class,'storeAlumnoObs'])->name('tutores.storeAlumnoObs');`
- L287: `Route::group(['prefix' => 'alumnos', 'middleware' => 'auth:alumno'],function(){`
- L288: `Route::get('home','AlumnosRutasController@avance')->name('alumnos.home_avance');`
- L289: `Route::get('avance','AlumnosRutasController@avance')->name('alumnos.avance');`
- L290: `Route::get('actividades','AlumnosRutasController@actividades')->name('alumnos.actividades');`
- L291: `Route::get('actividades/subir_evidencia','AlumnosRutasController@subirEvidencia')->name('alumnos.subir_evidencia');`
- L292: `Route::post('actividades/guardar_evidencia','AlumnosRutasController@guardarEvidencia')->name('alumnos.guardar_evidencia');`
- L293: `Route::get('actividades/evidencia', [AlumnosRutasController::class, 'evidencia'])->name('alumnos.evidencia');`
- L294: `Route::get('actividades/peticion_evidencia', [AlumnosRutasController::class, 'peticionEvidencia'])->name('alumnos.peticion_evidencia');`
- L295: `Route::get('actividades/eliminar_evidencia', [AlumnosRutasController::class, 'peticionEliminar'])->name('alumnos.eliminar_evidencia');`
- L296: `Route::get('constancias/imprimir','AlumnosRutasController@imprimir')->name('alumnos.constancias_imprimir');`
- L297: `Route::get('/{id}/perfil',[AlumnosController::class,'perfil'])->name('alumnos.perfil');`
- L298: `Route::post('/{id}/edit/perfil',[AlumnosController::class,'editPerfil'])->name('alumnos.edit.perfil');`
- L300: `//Rutas STA alumnos`
- L301: `Route::get('/ficha',[AlumnosStaController::class,'ficha'])->name('alumnos.sta.ficha');`
- L302: `Route::get('/ficha/guardar/{nc}',[AlumnosStaController::class,'guardarDatFam'])->name('alumnos.sta.ficha.guargar');`
- L303: `Route::get('/editDatSalud/{nc}',[AlumnosStaController::class,'editDatSalud'])->name('alumnos.sta.editDatSalud');`
- L304: `Route::get('/updtDatSalud/{nc}',[AlumnosStaController::class,'updtDatSalud'])->name('alumnos.sta.updtDatSalud');`
- L305: `Route::get('/dfamiliares/guardar/{nc}',[AlumnosStaController::class,'updtDatFam'])->name('alumnos.sta.dfamiliares.guargar');`
- L306: `Route::get('/dsociales/guardar/{nc}',[AlumnosStaController::class,'updtDatSoc'])->name('alumnos.sta.dsociales.guargar');`
- L307: `Route::get('/autorizar/guardar/{nc}',[AlumnosStaController::class,'autorizar'])->name('alumnos.sta.autorizar.guargar');`
- L308: `Route::get('/pdf/{nc}', [AlumnosStaController::class,'pdf'])->name('alumnos.sta.pdf');`
- L310: `//Rutas del sistema medico para alumnos`
- L311: `Route::get('/sta/paciente/alumno/mis_citas',[PacienteController::class,'index'])->name('paciente.alumno.index.citas');`
- L314: `//Rutas compartidas entre alumnos y usuarios`
- L315: `Route::group(['prefix'=>'compartido', 'middleware' => ['auth', 'alumno']],function(){`

## 4. Consultas con `alumnos.creditos` o `$alumno->creditos`
- Sin coincidencias exactas.

## 5. Campos de alumno que no existen en `sit.alumnos`
- Campos presentes en `creditos.alumnos` y ausentes en `sit.alumnos`: `a_mat`, `a_pat`, `beca`, `carrera`, `creditos`, `email`, `emailPer`, `est_civ`, `fec_nac`, `ficha`, `foto`, `generacion`, `grupo`, `lug_pro`, `nom_ficha`, `nombre`, `nombre_i`, `observaciones_med`, `observaciones_psic`, `password`, `remember_token`, `sem_med`, `sem_psic`, `sexo`, `tel`, `tel_emer`
### `a_mat`
- `app/Models/Alumno.php:19`: `protected $fillable=['no_control','password','nombre','carrera','status','foto','observaciones','email','ficha','nombre_i','a_pat','a_mat','creditos','fec_nac','lug_pro','curp','sexo','est_civ','tel','tel_emer','beca','grupo','nom_ficha','generacion'];`
### `a_pat`
- `app/Models/Alumno.php:19`: `protected $fillable=['no_control','password','nombre','carrera','status','foto','observaciones','email','ficha','nombre_i','a_pat','a_mat','creditos','fec_nac','lug_pro','curp','sexo','est_civ','tel','tel_emer','beca','grupo','nom_ficha','generacion'];`
### `beca`
- `app/Models/Alumno.php:19`: `protected $fillable=['no_control','password','nombre','carrera','status','foto','observaciones','email','ficha','nombre_i','a_pat','a_mat','creditos','fec_nac','lug_pro','curp','sexo','est_civ','tel','tel_emer','beca','grupo','nom_ficha','generacion'];`
### `carrera`
- `app/Http/Controllers/altaAlumnosController.php:46`: `'carrera' => $row[5],`
- `app/Http/Controllers/AlumnosController.php:39`: `$selectColumns = ['alu.nombre','alu.no_control','alu.email','alu.status','alu.id as alumno_id','a.nombre as carrera'];`
- `app/Http/Controllers/AlumnosController.php:43`: `->join('areas as a','a.id','=','alu.carrera')`
- `app/Http/Controllers/AlumnosController.php:76`: `$carreras = Area::where('tipo','=','carrera')->orderBy('nombre','ASC')->get();`
- `app/Http/Controllers/AlumnosController.php:132`: `$alumno->carrera=$request->carrera;`
- `app/Http/Controllers/AlumnosController.php:177`: `$selectColumns = ['alu.nombre','alu.no_control','alu.foto','alu.id as alumno_id','alu.password','a.nombre as carrera'];`
- `app/Http/Controllers/AlumnosController.php:180`: `->join('areas as a','a.id','=','alu.carrera')`
- `app/Http/Controllers/AlumnosController.php:269`: `$selectColumns = ['alu.nombre','alu.no_control','alu.status','alu.id as alumno_id','a.nombre as carrera'];`
- `app/Http/Controllers/AlumnosController.php:272`: `->join('areas as a','a.id','=','alu.carrera')`
- `app/Http/Controllers/AlumnosRutasController.php:53`: `->join('areas','areas.id','=','alu.carrera')`
- `app/Http/Controllers/AlumnosRutasController.php:58`: `->select('alu.no_control','alu.foto as foto','alu.id as alumno_id','alu.nombre as nombre_alumno','areas.nombre as carrera','c.nombre as nombre_credito','a.nombre as nombre_actividad','a.por_cred_actividad','av.por_credito')`
- `app/Http/Controllers/AlumnosRutasController.php:70`: `$join->on('areas.id','=','alumnos.carrera');`
- `app/Http/Controllers/AlumnosRutasController.php:71`: `})->where('alumnos.no_control','=',Auth::User()->no_control)->select('alumnos.id as alumno_id','alumnos.nombre as nombre_alumno','areas.nombre as carrera','alumnos.no_control','alumnos.foto')->get();`
- `app/Http/Controllers/AlumnosRutasController.php:107`: `$join->on('alu.carrera','=','c.carrera');`
- `app/Http/Controllers/AlumnosRutasController.php:114`: `$alumno = DB::table('alumnos')->join('areas','areas.id','=','alumnos.carrera')->where('alumnos.no_control','=',Auth::User()->no_control)->select('alumnos.nombre','alumnos.no_control','areas.nombre as carrera')->get();`
- `app/Http/Controllers/AlumnosStaController.php:313`: `$fam->carrera = $request->fiden_influ;`
- `app/Http/Controllers/AreasController.php:75`: `$tiene_alumnos = Alumno::where('carrera','=',$id)->get()->count() > 0?true: false;`
- `app/Http/Controllers/Auth/RegisterController.php:85`: `['carrera' => 'Ing. en Sistemas Computacionales','valor' => 'Sistemas'],`
- `app/Http/Controllers/Auth/RegisterController.php:86`: `['carrera' => 'Ing. en Nanotecnología', 'valor' => 'Nanotecnología'],`
- `app/Http/Controllers/Auth/RegisterController.php:87`: `['carrera' => 'Ing. en Mecatrónica','valor' => 'Mecatrónica'],`
- `app/Http/Controllers/Auth/RegisterController.php:88`: `['carrera' => 'Ing. en Bioquímica','valor' => 'Bioquímica'],`
- `app/Http/Controllers/Auth/RegisterController.php:89`: `['carrera' => 'Ing. en Tecnologías de la Información y Comunicaciones','valor' =>"TIC's"],`
- `app/Http/Controllers/Auth/RegisterController.php:90`: `['carrera' => 'Gestión Empresarial','valor' => 'Gestión Empresarial'],`
- `app/Http/Controllers/Auth/RegisterController.php:91`: `['carrera' => 'Ing. Industrial', 'valor' => 'Industrial']`
- `app/Http/Controllers/ConstanciasController.php:35`: `$carreras = Area::where('tipo','=','carrera')->get();`
- `app/Http/Controllers/ConstanciasController.php:52`: `['tipo','=','carrera'],`
- `app/Http/Controllers/ConstanciasController.php:69`: `if(!$request->has('carrera')){`
- `app/Http/Controllers/ConstanciasController.php:73`: `$datos_especificos_por_carrera = DB::table('constancia as c')->join('users as u','u.id','=','c.jefe_division')->where('c.carrera','=',$request->get('carrera'))->select('u.name','c.profesion_jefe_division','c.division_enunciado','c.plan_de_estudios')->get();`
- `app/Http/Controllers/ConstanciasController.php:148`: `$join->on('alu.carrera','=','c.carrera');`
- `app/Http/Controllers/ConstanciasController.php:155`: `$alumno = DB::table('alumnos')->join('areas','areas.id','=','alumnos.carrera')->where('alumnos.no_control','=',$request->no_control)->select('alumnos.nombre','alumnos.no_control','areas.nombre as carrera')->get();`
- `app/Http/Controllers/ConstanciasController.php:281`: `public function obtenerDatosEspecificos($carrera){`
- `app/Http/Controllers/ConstanciasController.php:282`: `$constancia_data = Constancia::where('carrera','=',$carrera)->get();`
- `app/Http/Controllers/ConstanciasController.php:286`: `public function guardarDatosEspecificos($carrera,Request $request){`
- `app/Http/Controllers/ConstanciasController.php:287`: `$area = Area::find($carrera);`
- `app/Http/Controllers/ConstanciasController.php:289`: `return response()->json(array('data' => [],'mensaje' => 'La carrera no existe','mensaje_tipo' => 'error'));`
- `app/Http/Controllers/ConstanciasController.php:291`: `if($area->tipo!="carrera"){`
- `app/Http/Controllers/ConstanciasController.php:292`: `return response()->json(array('data' => [],'mensaje' => 'No es una carrera','mensaje_tipo' => 'error'));`
- `app/Http/Controllers/ConstanciasController.php:294`: `$constancia_existe = Constancia::where('carrera','=',$carrera)->select('id')->get();`
- `app/Http/Controllers/ConstanciasController.php:309`: `$carreras_lista= Area::where('tipo','=','carrera')->get();`
- `app/Http/Controllers/ConstanciasController.php:310`: `foreach ($carreras_lista as $carrera) {`
- `app/Http/Controllers/ConstanciasController.php:313`: `if($constancia->carrera==$carrera->id){`
- `app/Http/Controllers/ConstanciasController.php:319`: `array_push($constancias_faltantes, $carrera->nombre);`
- `app/Http/Controllers/GruposController.php:37`: `//Agregamos el nombre de la carrera a cada grupo`
- `app/Http/Controllers/GruposController.php:187`: `//Obtenemos el nombre de la carrera y se lo asignamos a la variable`
- `app/Http/Controllers/GruposController.php:207`: `//Obtenemos el nombre de la carrera y se lo asignamos a la variable`
- `app/Http/Controllers/JefesController.php:37`: `//Verificamos si el usuario tiene permiso VIP_STA para darle acceso a todas las carreras si no, lo limitamos solo a su carrera`
- `app/Http/Controllers/JefesController.php:47`: `$carrera="";`
- `app/Http/Controllers/JefesController.php:61`: `->with('carrera',$carrera);`
- `app/Http/Controllers/JefesController.php:66`: `// Obtener el grupo de alumnos basado en carrera y año de ingreso`
- `app/Http/Controllers/JefesController.php:76`: `->where('alumnos.car_Clave', '=', $request->carrera)`
- `app/Http/Controllers/JefesController.php:125`: `->with('carrera', $request->carrera);`
- `app/Http/Controllers/ParticipantesController.php:212`: `->join('areas','areas.id','=','a.carrera')`
- `app/Http/Controllers/ParticipantesController.php:218`: `->select('a.nombre','areas.nombre as carrera','p.id','p.id_evidencia','a.no_control','e.alumno_no_control as tiene_evidencia','p.momento_agregado','p.evidencia_validada')->groupBy('p.no_control')->get();`
- `app/Http/Controllers/STAController.php:41`: `$carrera=$request->carrera;`
- `app/Http/Controllers/STAController.php:43`: `$dpto=$this->obtDpto($carrera);`
- `app/Http/Controllers/STAController.php:151`: `function obtDpto($carrera)`
- `app/Http/Controllers/STAController.php:159`: `->where('c.car_Clave',$carrera)`
- `app/Http/Controllers/STAController.php:227`: `// Obtener todas las claves de carrera para hacer una sola consulta a SQL Server`
- `app/Http/Controllers/STAController.php:237`: `// Agregar el nombre de la carrera a cada grupo`
- `app/Http/Controllers/STAController.php:292`: `// Asignar nombre de la carrera`
- `app/Http/Controllers/STAController.php:365`: `// Extraer las claves de tutor, grupo y carrera`
- `app/Http/Controllers/STAController.php:378`: `// Iterar sobre el grupo y agregar los datos del tutor, grupo y carrera`
- `app/Http/Controllers/STAController.php:390`: `// Asignar el nombre de la carrera`
- `app/Http/Controllers/VerificaEvidenciaController.php:208`: `if(!Auth::User()->hasAnyPermission(['VIP','VIP_AVANCE_ALUMNO']) && $alumno[0]->carrera!=Auth::User()->area){`
- `app/Http/Controllers/VerificaEvidenciaController.php:227`: `})->join('areas','alu.carrera','=','areas.id')`
- `app/Http/Controllers/VerificaEvidenciaController.php:231`: `->select('alu.no_control','alu.nombre as nombre_alumno','areas.nombre as carrera','c.nombre as nombre_credito','a.nombre as nombre_actividad','a.por_cred_actividad','av.por_credito')->orderBy('nombre_credito')->groupBy('nombre_actividad')->get();`
- `app/Http/Controllers/VerificaEvidenciaController.php:237`: `$alumno_data= DB::table('alumnos as alu')->join('areas as a','a.id','=','alu.carrera')->select('alu.nombre as nombre_alumno','a.nombre as carrera','alu.no_control','alu.foto')->where('alu.no_control','=',$request->get('no_control'))->get();`
- `app/Http/Controllers/VerificaEvidenciaController.php:302`: `$carrera = null;`
- `app/Http/Controllers/VerificaEvidenciaController.php:306`: `$carrera = $request->get('carrera');`
- `app/Http/Controllers/VerificaEvidenciaController.php:310`: `$reportes_data = DB::select('select alumnos.nombre,alumnos.status, alumnos.no_control, areas.nombre as carrera, if(avance.por_credito is null or avance.por_credito > 100, if( avance.por_credito > 100, 100, 0), avance.por_credito) as por_credito, creditos.nombre as nombre_credito from alumnos join cr`
- `app/Http/Controllers/VerificaEvidenciaController.php:313`: `$suma_creditos = DB::select('select if(sum(case when por_credito > 100 then 100 else por_credito end) is null,0,sum(case when por_credito > 100 then 100 else por_credito end)) as credito_suma,alumnos.id as alumno_id ,alumnos.nombre,alumnos.status, alumnos.no_control, areas.nombre as carrera, if(avan`
- `app/Http/Controllers/VerificaEvidenciaController.php:317`: `$reportes_data = DB::select('select alumnos.nombre,alumnos.status, alumnos.no_control, areas.nombre as carrera, if(avance.por_credito is null or avance.por_credito > 100, if( avance.por_credito > 100, 100, 0), avance.por_credito) as por_credito, creditos.nombre as nombre_credito from alumnos join cr`
- `app/Http/Controllers/VerificaEvidenciaController.php:320`: `$suma_creditos = DB::select('select if(sum(case when por_credito > 100 then 100 else por_credito end) is null,0,sum(case when por_credito > 100 then 100 else por_credito end)) as credito_suma,alumnos.id as alumno_id ,alumnos.nombre,alumnos.status, alumnos.no_control, areas.nombre as carrera, if(avan`
- `app/Http/Controllers/VerificaEvidenciaController.php:332`: `$carrera = null;`
- `app/Http/Controllers/VerificaEvidenciaController.php:336`: `$carrera = $request->get('carrera');`
- `app/Http/Controllers/VerificaEvidenciaController.php:340`: `$reportes_data = DB::select('select alumnos.nombre,alumnos.status, alumnos.no_control, areas.nombre as carrera, if(avance.por_credito is null or avance.por_credito > 100, if( avance.por_credito > 100, 100, 0), avance.por_credito) as por_credito, creditos.nombre as nombre_credito from alumnos join cr`
- `app/Http/Controllers/VerificaEvidenciaController.php:342`: `$suma_creditos = DB::select('select if(sum(case when por_credito > 100 then 100 else por_credito end) is null,0,sum(case when por_credito > 100 then 100 else por_credito end)) as credito_suma,alumnos.id as alumno_id ,alumnos.nombre, alumnos.status, alumnos.no_control, areas.nombre as carrera, if(ava`
- `app/Http/Controllers/VerificaEvidenciaController.php:346`: `$reportes_data = DB::select('select alumnos.nombre,alumnos.status, alumnos.no_control, areas.nombre as carrera, if(avance.por_credito is null or avance.por_credito > 100, if( avance.por_credito > 100, 100, 0), avance.por_credito) as por_credito, creditos.nombre as nombre_credito from alumnos join cr`
- `app/Http/Controllers/VerificaEvidenciaController.php:348`: `$suma_creditos = DB::select('select if(sum(case when por_credito > 100 then 100 else por_credito end) is null,0,sum(case when por_credito > 100 then 100 else por_credito end)) as credito_suma,alumnos.id as alumno_id ,alumnos.nombre, alumnos.status, alumnos.no_control, areas.nombre as carrera, if(ava`
- `app/Http/Controllers/VerificaEvidenciaController.php:364`: `->with('carrera_seleccionada',$carrera)`
- `app/Http/Controllers/VerificaEvidenciaController.php:387`: `['carrera','=',Auth::User()->area]`
- `app/Http/Controllers/VerificaEvidenciaController.php:392`: `['carrera','=',Auth::User()->area]`
- `app/Imports/AlumnosAgregar.php:23`: `'carrera'=>$rows[6]`
- `app/Models/Alumno.php:19`: `protected $fillable=['no_control','password','nombre','carrera','status','foto','observaciones','email','ficha','nombre_i','a_pat','a_mat','creditos','fec_nac','lug_pro','curp','sexo','est_civ','tel','tel_emer','beca','grupo','nom_ficha','generacion'];`
- `app/Models/Area.php:20`: `$query->where('tipo','=', 'carrera');`
- `app/Models/Area.php:27`: `$query->where('tipo', '=', 'carrera');`
- `app/Models/Constancia.php:11`: `'profesion_jefe_division','jefe_division','division_enuciado','division_enunciado','carrera','plan_de_estudios'`
- `routes/web.php:184`: `Route::get('constancias/{carrera}/obtener_datos_especificos','ConstanciasController@obtenerDatosEspecificos')->name('constancias.obtener_datos_especificos');`
- `routes/web.php:185`: `Route::post('constancias/{carrera}/guardar','ConstanciasController@guardarDatosEspecificos')->name('constancias.guardar_datos_especificos');`
- `routes/web.php:227`: `//Rutas de jefes de carrera`
### `creditos`
- `app/Http/Controllers/ActividadesController.php:57`: `->leftjoin('creditos as c','c.id','=','a.id_actividad')`
- `app/Http/Controllers/ActividadesController.php:168`: `$creditos = Credito::where('vigente','=','true')->orderBy('nombre','asc')->get();`
- `app/Http/Controllers/ActividadesController.php:171`: `$creditos = Credito::leftjoin('creditos_areas as ca','ca.credito_id','=','creditos.id')`
- `app/Http/Controllers/ActividadesController.php:174`: `['creditos.vigente','=','true']`
- `app/Http/Controllers/ActividadesController.php:176`: `->select('creditos.id', 'creditos.nombre')`
- `app/Http/Controllers/ActividadesController.php:177`: `->groupBy('creditos.id')`
- `app/Http/Controllers/ActividadesController.php:178`: `->orderBy('creditos.nombre','asc')`
- `app/Http/Controllers/ActividadesController.php:182`: `return view('admin.actividades.create')->with('creditos',$creditos);`
- `app/Http/Controllers/ActividadesController.php:198`: `$areas_del_credito = DB::table('creditos as c')->join('creditos_areas as ca', function($join) use($request){`
- `app/Http/Controllers/ActividadesController.php:249`: `$creditos=Credito::orderBy('nombre','asc')->get();`
- `app/Http/Controllers/ActividadesController.php:250`: `return view('admin.actividades.edit')->with('actividad',$act)->with('creditos',$creditos);`
- `app/Http/Controllers/ActividadesController.php:252`: `$creditos=Credito::orderBy('nombre','asc')->get();`
- `app/Http/Controllers/ActividadesController.php:253`: `return view('admin.actividades.edit')->with('actividad',$act)->with('creditos',$creditos);`
- `app/Http/Controllers/Actividad_EvidenciasController.php:23`: `$credito_vigente = DB::table('creditos as c')->join('actividad as a', function($join) use($actividad_evidencia){`
- `app/Http/Controllers/Actividad_EvidenciasController.php:59`: `$credito_vigente = DB::table('creditos as c')->join('actividad as a', function($join) use($actividad_evidencia){`
- `app/Http/Controllers/AlumnosRutasController.php:31`: `//Traemos todos los creditos existentes`
- `app/Http/Controllers/AlumnosRutasController.php:32`: `$creditos = Credito::select('nombre')->orderBy('nombre')->get();`
- `app/Http/Controllers/AlumnosRutasController.php:48`: `->join('creditos as c','c.id','=','a.id_actividad')`
- `app/Http/Controllers/AlumnosRutasController.php:76`: `->with('creditos',$creditos)`
- `app/Http/Controllers/AlumnosRutasController.php:115`: `$alumno_data = DB::select('select c.nombre as credito_nombre, u.name as credito_jefe from creditos as c join avance on avance.id_credito=c.id and avance.no_control = "'.Auth::User()->no_control.'" and avance.por_credito >= 100 join users as u on u.id = c.credito_jefe order by c.id limit 5');`
- `app/Http/Controllers/AlumnosRutasController.php:159`: `->join('creditos as c', 'c.id', '=', 'act.id_actividad')`
- `app/Http/Controllers/AlumnosRutasController.php:210`: `->join('creditos as c','a.id_actividad','=','c.id')`
- `app/Http/Controllers/ConstanciasController.php:156`: `$alumno_data = DB::select('select c.nombre as credito_nombre, u.name as credito_jefe from creditos as c join avance on avance.id_credito=c.id and avance.no_control = "'.$request->no_control.'" and avance.por_credito >= 100 join users as u on u.id = c.credito_jefe order by c.id limit 5');`
- `app/Http/Controllers/CreditosController.php:28`: `$credito = Credito::leftjoin('users as u','u.id','=','creditos.credito_jefe')->select('creditos.nombre','creditos.vigente','creditos.id','u.name as jefe_nombre')->get();`
- `app/Http/Controllers/CreditosController.php:32`: `return view('admin.creditos.index')`
- `app/Http/Controllers/CreditosController.php:40`: `//Ponemos el codigo de la vista que se llamara para las altas de los creditos`
- `app/Http/Controllers/CreditosController.php:43`: `return view('admin.creditos.create')`
- `app/Http/Controllers/CreditosController.php:64`: `return redirect()->route('creditos.index');`
- `app/Http/Controllers/CreditosController.php:78`: `return redirect()->route('creditos.index');`
- `app/Http/Controllers/CreditosController.php:81`: `return view('admin.creditos.edit')`
- `app/Http/Controllers/CreditosController.php:105`: `return redirect()->route('creditos.index');`
- `app/Http/Controllers/CreditosController.php:115`: `return redirect()->route('creditos.index');`
- `app/Http/Controllers/CreditosController.php:117`: `$tiene_actividades = DB::table('actividad as a')->join('creditos as c',function($join) use($id){`
- `app/Http/Controllers/CreditosController.php:122`: `$tiene_avance = DB::table('avance as a')->join('creditos as c', function($join) use($id){`
- `app/Http/Controllers/CreditosController.php:128`: `return redirect()->route('creditos.index');`
- `app/Http/Controllers/CreditosController.php:132`: `return redirect()->route('creditos.index');`
- `app/Http/Controllers/JefesController.php:378`: `//Calculamos el avance en creditos acumulados`
- `app/Http/Controllers/JefesController.php:472`: `'mensaje' => 'No se encontró el registro del alumno: '.$noControl.', es probable que no esté registrado en la base de datos de creditos, infórmalo al administrador de sistemas',`
- `app/Http/Controllers/ParticipantesController.php:105`: `})->join('actividad as a','a.id','=','ae.actividad_id')->join('creditos as c','c.id','=','a.id_actividad')->where('c.vigente','=','true')->get()->count()>0?true: false;`
- `app/Http/Controllers/ParticipantesController.php:118`: `$participante_data = DB::table('participantes as p')->join('actividad_evidencia as ae','p.id_evidencia','=','ae.id')->join('evidencia as e','e.id_asig_actividades','=','ae.id')->join('actividad as a','a.id','=','ae.actividad_id')->join('creditos as c','c.id','=','a.id_actividad')->where([`
- `app/Http/Controllers/ParticipantesController.php:285`: `$credito_vigente = DB::table('actividad as a')->join('creditos as c','c.id','=','a.id_actividad')->where([`
- `app/Http/Controllers/ParticipantesController.php:394`: `$creditos = 0;`
- `app/Http/Controllers/ParticipantesController.php:396`: `if($avance[$i]->por_credito >= 100) ++$creditos;`
- `app/Http/Controllers/ParticipantesController.php:398`: `if($creditos >= 5){`
- `app/Http/Controllers/ParticipantesController.php:501`: `->join('creditos as c','c.id','=','act.id_actividad')`
- `app/Http/Controllers/VerificaEvidenciaController.php:48`: `->join('creditos as c','a.id_actividad','=','c.id')`
- `app/Http/Controllers/VerificaEvidenciaController.php:65`: `->join('creditos as c','a.id_actividad','=','c.id')`
- `app/Http/Controllers/VerificaEvidenciaController.php:117`: `})->join('creditos as c','c.id','=','a.id_actividad')->where('c.vigente','=','true')->get()->count()>0?true: false;`
- `app/Http/Controllers/VerificaEvidenciaController.php:172`: `$creditos = 0;`
- `app/Http/Controllers/VerificaEvidenciaController.php:174`: `if($avance[$i]->por_credito >= 100) ++$creditos;`
- `app/Http/Controllers/VerificaEvidenciaController.php:176`: `if($creditos >= 5){`
- `app/Http/Controllers/VerificaEvidenciaController.php:198`: `//Traemos todos los creditos existentes`
- `app/Http/Controllers/VerificaEvidenciaController.php:199`: `$creditos = Credito::select('nombre')->orderBy('nombre')->get();`
- `app/Http/Controllers/VerificaEvidenciaController.php:223`: `->join('creditos as c','c.id','=','a.id_actividad')`
- `app/Http/Controllers/VerificaEvidenciaController.php:242`: `->with('creditos',$creditos)`
- `app/Http/Controllers/VerificaEvidenciaController.php:257`: `->join('creditos as c', 'c.id', '=', 'act.id_actividad')`
- `app/Http/Controllers/VerificaEvidenciaController.php:298`: `$creditos = count($creditos_count);`
- `app/Http/Controllers/VerificaEvidenciaController.php:307`: `//Consulta para traer los creditos y su avance indibidual de cada uno`
- `app/Http/Controllers/VerificaEvidenciaController.php:310`: `$reportes_data = DB::select('select alumnos.nombre,alumnos.status, alumnos.no_control, areas.nombre as carrera, if(avance.por_credito is null or avance.por_credito > 100, if( avance.por_credito > 100, 100, 0), avance.por_credito) as por_credito, creditos.nombre as nombre_credito from alumnos join cr`
- `app/Http/Controllers/VerificaEvidenciaController.php:312`: `//Cosulta para traer la suma total de todos creditos`
- `app/Http/Controllers/VerificaEvidenciaController.php:313`: `$suma_creditos = DB::select('select if(sum(case when por_credito > 100 then 100 else por_credito end) is null,0,sum(case when por_credito > 100 then 100 else por_credito end)) as credito_suma,alumnos.id as alumno_id ,alumnos.nombre,alumnos.status, alumnos.no_control, areas.nombre as carrera, if(avan`
- `app/Http/Controllers/VerificaEvidenciaController.php:317`: `$reportes_data = DB::select('select alumnos.nombre,alumnos.status, alumnos.no_control, areas.nombre as carrera, if(avance.por_credito is null or avance.por_credito > 100, if( avance.por_credito > 100, 100, 0), avance.por_credito) as por_credito, creditos.nombre as nombre_credito from alumnos join cr`
- `app/Http/Controllers/VerificaEvidenciaController.php:319`: `//Cosulta para traer la suma total de todos creditos`
- `app/Http/Controllers/VerificaEvidenciaController.php:320`: `$suma_creditos = DB::select('select if(sum(case when por_credito > 100 then 100 else por_credito end) is null,0,sum(case when por_credito > 100 then 100 else por_credito end)) as credito_suma,alumnos.id as alumno_id ,alumnos.nombre,alumnos.status, alumnos.no_control, areas.nombre as carrera, if(avan`
- `app/Http/Controllers/VerificaEvidenciaController.php:337`: `//Consulta para traer los creditos y su avance indibidual de cada uno`
- `app/Http/Controllers/VerificaEvidenciaController.php:340`: `$reportes_data = DB::select('select alumnos.nombre,alumnos.status, alumnos.no_control, areas.nombre as carrera, if(avance.por_credito is null or avance.por_credito > 100, if( avance.por_credito > 100, 100, 0), avance.por_credito) as por_credito, creditos.nombre as nombre_credito from alumnos join cr`
- `app/Http/Controllers/VerificaEvidenciaController.php:341`: `//Cosulta para traer la suma total de todos creditos`
- `app/Http/Controllers/VerificaEvidenciaController.php:342`: `$suma_creditos = DB::select('select if(sum(case when por_credito > 100 then 100 else por_credito end) is null,0,sum(case when por_credito > 100 then 100 else por_credito end)) as credito_suma,alumnos.id as alumno_id ,alumnos.nombre, alumnos.status, alumnos.no_control, areas.nombre as carrera, if(ava`
- `app/Http/Controllers/VerificaEvidenciaController.php:346`: `$reportes_data = DB::select('select alumnos.nombre,alumnos.status, alumnos.no_control, areas.nombre as carrera, if(avance.por_credito is null or avance.por_credito > 100, if( avance.por_credito > 100, 100, 0), avance.por_credito) as por_credito, creditos.nombre as nombre_credito from alumnos join cr`
- `app/Http/Controllers/VerificaEvidenciaController.php:347`: `//Cosulta para traer la suma total de todos creditos`
- `app/Http/Controllers/VerificaEvidenciaController.php:348`: `$suma_creditos = DB::select('select if(sum(case when por_credito > 100 then 100 else por_credito end) is null,0,sum(case when por_credito > 100 then 100 else por_credito end)) as credito_suma,alumnos.id as alumno_id ,alumnos.nombre, alumnos.status, alumnos.no_control, areas.nombre as carrera, if(ava`
- `app/Http/Controllers/VerificaEvidenciaController.php:361`: `->with('creditos',$creditos)`
- `app/Models/Actividad.php:25`: `//Agregamos el campo id_actividad ya que es el campo que enlaza con la tabla creditos, para hacer la busqueda`
- `app/Models/Alumno.php:19`: `protected $fillable=['no_control','password','nombre','carrera','status','foto','observaciones','email','ficha','nombre_i','a_pat','a_mat','creditos','fec_nac','lug_pro','curp','sexo','est_civ','tel','tel_emer','beca','grupo','nom_ficha','generacion'];`
- `app/Models/Credito.php:10`: `protected $table="creditos";`
- `routes/web.php:102`: `/****Rutas para el controlador de creditos*****/`
- `routes/web.php:103`: `//Route::resource('creditos','CreditosController');`
- `routes/web.php:105`: `Route::get('/creditos/index',[CreditosController::class,'index'])->name('creditos.index');`
- `routes/web.php:106`: `Route::get('/creditos/create',[CreditosController::class,'create'])->name('creditos.create');`
- `routes/web.php:107`: `Route::post('/creditos/store',[CreditosController::class,'store'])->name('creditos.store');`
- `routes/web.php:108`: `Route::get('/creditos/{id}/edit',[CreditosController::class,'edit'])->name('creditos.edit');`
- `routes/web.php:109`: `Route::post('/creditos/{id}/update',[CreditosController::class,'update'])->name('creditos.update');`
- `routes/web.php:110`: `Route::get('/creditos/{id}/destroy',[CreditosController::class,'destroy'])->name('creditos.destroy');`
### `email`
- `app/Http/Controllers/altaAlumnosController.php:45`: `'email' => $row[3],`
- `app/Http/Controllers/AlumnosController.php:39`: `$selectColumns = ['alu.nombre','alu.no_control','alu.email','alu.status','alu.id as alumno_id','a.nombre as carrera'];`
- `app/Http/Controllers/AlumnosController.php:94`: `$alumno->email=$request->email;`
- `app/Http/Controllers/AlumnosController.php:146`: `$alumno->email=$request->email;`
- `app/Http/Controllers/AlumnosLoginController.php:52`: `$credentials = $request->only('email', 'password');`
- `app/Http/Controllers/AlumnosLoginController.php:68`: `return 'email';`
- `app/Http/Controllers/Auth/LoginController.php:52`: `$user = User::where('email','=',$request->email)->get();`
- `app/Http/Controllers/Auth/LoginController.php:101`: `if (\Auth::guard('alumno')->attempt(['email' => $request->email, 'password' => $request->password])) {`
- `app/Http/Controllers/Auth/LoginController.php:107`: `return redirect()->back()->withInput($request->only('email'));`
- `app/Http/Controllers/Auth/RegisterController.php:53`: `'email' => 'required|string|email|max:255|unique:users',`
- `app/Http/Controllers/Auth/RegisterController.php:71`: `'email' => $data['email'],`
- `app/Http/Controllers/ConstanciasController.php:37`: `$users = User::select('name','id')->where('email','<>','admin@itsch.com')->orderBy('name','ASC')->get();`
- `app/Http/Controllers/ConstanciasController.php:57`: `['email','<>','admin@itsch.com'],`
- `app/Http/Controllers/PerfilController.php:21`: `$data_user = User::join('areas as a','a.id','=','users.area')->where('users.id','=',Auth::User()->id)->select('a.nombre as area_nombre','users.name as usuario_nombre','users.email as usuario_correo')->get();`
- `app/Http/Controllers/PerfilController.php:30`: `return view('auth.passwords.email');`
- `app/Http/Controllers/PerfilController.php:35`: `$email=User::where('email', $request->email)->first();`
- `app/Http/Controllers/PerfilController.php:36`: `if(is_null($email))		{`
- `app/Http/Controllers/PerfilController.php:37`: `$emaila=Alumno::where('email', $request->email)->first();`
- `app/Http/Controllers/PerfilController.php:41`: `return view('auth.passwords.email');`
- `app/Http/Controllers/PerfilController.php:48`: `'email' => $request->email,`
- `app/Http/Controllers/PerfilController.php:53`: `//Envío de email al usuario`
- `app/Http/Controllers/PerfilController.php:54`: `Mail::to( $request->email)->send(new mail_res_pass($token));`
- `app/Http/Controllers/PerfilController.php:56`: `Alert::success('Correcto','Te hemos enviado un email a '.$request->email.' con un enlace para realizar el cambio de contraseña. Recuerda que pueden pasar algunos minutos para que el correo llegue a tu bandeja de entrada');`
- `app/Http/Controllers/PerfilController.php:65`: `'email' => $request->email,`
- `app/Http/Controllers/PerfilController.php:70`: `//Envío de email al usuario`
- `app/Http/Controllers/PerfilController.php:71`: `Mail::to( $request->email)->send(new mail_res_pass($token));`
- `app/Http/Controllers/PerfilController.php:73`: `Alert::success('Correcto','Te hemos enviado un email a '.$request->email.' con un enlace para realizar el cambio de contraseña. Recuerda que pueden pasar algunos minutos para que el correo llegue a tu bandeja de entrada');`
- `app/Http/Controllers/PerfilController.php:81`: `$mail=DB::table('password_resets')->where('token',$token)->select('email')->first();`
- `app/Http/Controllers/PerfilController.php:85`: `return view('auth.passwords.email');`
- `app/Http/Controllers/PerfilController.php:118`: `$mail=DB::table('password_resets')->where('token',$request->token)->select('email')->first();`
- `app/Http/Controllers/PerfilController.php:119`: `$user=$this->getUser($mail->email);`
- `app/Http/Controllers/PerfilController.php:130`: `private function getUser($email)`
- `app/Http/Controllers/PerfilController.php:132`: `$user= User::where('email',$email)->first();`
- `app/Http/Controllers/PerfilController.php:135`: `$user= Alumno::where('email',$email)->first();`
- `app/Http/Controllers/ResponsablesController.php:43`: `})->leftjoin('actividad as a','a.id','=','ae.actividad_id')->leftjoin('evidencia as e','e.id_asig_actividades','=','ae.id')->leftjoin('participantes as p','p.id_evidencia','=','ae.id')->leftjoin('areas','areas.id','=','users.area')->where('users.email','<>','admin@itsch.com')->groupBy('usuario_id')-`
- `app/Http/Controllers/SistemaMedicoController.php:35`: `'paciente.user:id,name,email',`
- `app/Http/Controllers/SistemaMedicoController.php:46`: `'paciente.user:id,name,email',`
- `app/Http/Controllers/UsersController.php:28`: `->select('a.nombre as area','u.name','u.active','u.id','u.email','u.tutor')`
- `app/Http/Controllers/UsersController.php:39`: `->select('a.nombre as area','u.name','u.active','u.id','u.email')`
- `app/Http/Controllers/UsersController.php:94`: `$correo_duplicado = User::where('email','=',$user->email)->get()->count() > 0;`
- `app/Http/Controllers/UsersController.php:96`: `Alert::error('Error','El correo '.$user->email.' ya se encuentra en uso');`
- `app/Http/Controllers/UsersController.php:144`: `$user->email = $request->email;`
- `app/Http/Controllers/UsersController.php:148`: `$correo_duplicado = User::where('email','=',$request->email)->get()->count() > 1;`
- `app/Http/Controllers/UsersController.php:150`: `Alert::error('Error','El correo '.$request->email.' ya se encuentra en uso por otro usuario');`
- `app/Http/Requests/UserRequest.php:28`: `'email' =>  'email|required',`
- `app/Models/Alumno.php:19`: `protected $fillable=['no_control','password','nombre','carrera','status','foto','observaciones','email','ficha','nombre_i','a_pat','a_mat','creditos','fec_nac','lug_pro','curp','sexo','est_civ','tel','tel_emer','beca','grupo','nom_ficha','generacion'];`
- `app/User.php:22`: `'name', 'email', 'password','area','active','tutor'`
### `emailPer`
- `app/Http/Controllers/AlumnosStaController.php:91`: `$alu->emailPer = $request->emailPer;`
### `est_civ`
- `app/Http/Controllers/AlumnosStaController.php:93`: `$alu->est_civ = $request->est_civ;`
- `app/Models/Alumno.php:19`: `protected $fillable=['no_control','password','nombre','carrera','status','foto','observaciones','email','ficha','nombre_i','a_pat','a_mat','creditos','fec_nac','lug_pro','curp','sexo','est_civ','tel','tel_emer','beca','grupo','nom_ficha','generacion'];`
### `fec_nac`
- `app/Models/Alumno.php:19`: `protected $fillable=['no_control','password','nombre','carrera','status','foto','observaciones','email','ficha','nombre_i','a_pat','a_mat','creditos','fec_nac','lug_pro','curp','sexo','est_civ','tel','tel_emer','beca','grupo','nom_ficha','generacion'];`
### `ficha`
- `app/Http/Controllers/AlumnosStaController.php:20`: `public function ficha()`
- `app/Http/Controllers/AlumnosStaController.php:77`: `return view('alumnos.sta.ficha',compact('alu2', 'alu1', 'dPad', 'dMad', 'direccion', 'direccionP', 'direccionM', 'alu', 'car', 'clinicos', 'person','alumno_data'));`
- `app/Http/Controllers/AlumnosStaController.php:381`: `$alu->ficha = 1;`
- `app/Http/Controllers/JefesController.php:32`: `$this->middleware('permission:VIP_STA|STA_DEP_TUTORIA|STA_TUTOR|STA_COR_CARRERA')->only(['generacion','diagnostico','calSemaforos','ficha','storeAlumnoObs']);`
- `app/Http/Controllers/JefesController.php:89`: `->select('no_control', 'ficha')`
- `app/Http/Controllers/JefesController.php:95`: `// Asignar ficha si existe, de lo contrario, asignar 0`
- `app/Http/Controllers/JefesController.php:96`: `$alu->ficha = $fichas->get($alu->control)->ficha ?? 0;`
- `app/Http/Controllers/JefesController.php:407`: `public function ficha($nc, $usr)`
- `app/Http/Controllers/JefesController.php:432`: `return view('sta.analisis_alumnos.ficha', compact('familiares', 'alu1', 'alu2', 'car','padres', 'direccion', 'direccionP', 'direccionM', 'soc', 'alu',  'clinicos', 'person', 'fam'));`
- `app/Http/Controllers/JefesController.php:439`: `Alert::error('Error', 'Este alumno no ha llenado su ficha académica');`
- `app/Http/Controllers/JefesController.php:444`: `Alert::error('Error', 'Este alumno no ha llenado su ficha académica');`
- `app/Http/Controllers/STAController.php:345`: `// Asigna la ficha correspondiente, o 0 si no existe`
- `app/Http/Controllers/STAController.php:347`: `$alumno->ficha = $fichas[$alumno->no_Control]->ficha;`
- `app/Http/Controllers/STAController.php:349`: `$alumno->ficha = 0;`
- `app/Models/Alumno.php:19`: `protected $fillable=['no_control','password','nombre','carrera','status','foto','observaciones','email','ficha','nombre_i','a_pat','a_mat','creditos','fec_nac','lug_pro','curp','sexo','est_civ','tel','tel_emer','beca','grupo','nom_ficha','generacion'];`
- `routes/web.php:231`: `Route::get('/sta/analisis/ficha/{nc},/{usr}',[JefesController::class,'ficha'])->name('analisis.ficha');`
- `routes/web.php:301`: `Route::get('/ficha',[AlumnosStaController::class,'ficha'])->name('alumnos.sta.ficha');`
- `routes/web.php:302`: `Route::get('/ficha/guardar/{nc}',[AlumnosStaController::class,'guardarDatFam'])->name('alumnos.sta.ficha.guargar');`
### `foto`
- `app/Http/Controllers/AlumnosController.php:177`: `$selectColumns = ['alu.nombre','alu.no_control','alu.foto','alu.id as alumno_id','alu.password','a.nombre as carrera'];`
- `app/Http/Controllers/AlumnosController.php:196`: `if($request->has('foto'))`
- `app/Http/Controllers/AlumnosController.php:200`: `$file = $request->foto;`
- `app/Http/Controllers/AlumnosController.php:232`: `$alumno->foto=$name;//Obtiene el nombre de la imagen para guardarlo en la bd`
- `app/Http/Controllers/AlumnosRutasController.php:58`: `->select('alu.no_control','alu.foto as foto','alu.id as alumno_id','alu.nombre as nombre_alumno','areas.nombre as carrera','c.nombre as nombre_credito','a.nombre as nombre_actividad','a.por_cred_actividad','av.por_credito')`
- `app/Http/Controllers/AlumnosRutasController.php:71`: `})->where('alumnos.no_control','=',Auth::User()->no_control)->select('alumnos.id as alumno_id','alumnos.nombre as nombre_alumno','areas.nombre as carrera','alumnos.no_control','alumnos.foto')->get();`
- `app/Http/Controllers/VerificaEvidenciaController.php:237`: `$alumno_data= DB::table('alumnos as alu')->join('areas as a','a.id','=','alu.carrera')->select('alu.nombre as nombre_alumno','a.nombre as carrera','alu.no_control','alu.foto')->where('alu.no_control','=',$request->get('no_control'))->get();`
- `app/Models/Alumno.php:19`: `protected $fillable=['no_control','password','nombre','carrera','status','foto','observaciones','email','ficha','nombre_i','a_pat','a_mat','creditos','fec_nac','lug_pro','curp','sexo','est_civ','tel','tel_emer','beca','grupo','nom_ficha','generacion'];`
### `generacion`
- `app/Http/Controllers/JefesController.php:32`: `$this->middleware('permission:VIP_STA|STA_DEP_TUTORIA|STA_TUTOR|STA_COR_CARRERA')->only(['generacion','diagnostico','calSemaforos','ficha','storeAlumnoObs']);`
- `app/Http/Controllers/JefesController.php:46`: `$generacion="";`
- `app/Http/Controllers/JefesController.php:60`: `->with('generacion',$generacion)`
- `app/Http/Controllers/JefesController.php:64`: `public function generacion(Request $request)`
- `app/Http/Controllers/JefesController.php:77`: `->where('alumnos.Alu_AnioIngreso', '=', $request->generacion)`
- `app/Http/Controllers/JefesController.php:124`: `->with('generacion', $request->generacion)`
- `app/Http/Controllers/VerificaEvidenciaController.php:303`: `if($request->has('generacion')){`
- `app/Http/Controllers/VerificaEvidenciaController.php:304`: `//Substraemos los dos ultimos digitos del año de generacion`
- `app/Http/Controllers/VerificaEvidenciaController.php:305`: `$generacion = substr($request->generacion,2,4);`
- `app/Http/Controllers/VerificaEvidenciaController.php:310`: `$reportes_data = DB::select('select alumnos.nombre,alumnos.status, alumnos.no_control, areas.nombre as carrera, if(avance.por_credito is null or avance.por_credito > 100, if( avance.por_credito > 100, 100, 0), avance.por_credito) as por_credito, creditos.nombre as nombre_credito from alumnos join cr`
- `app/Http/Controllers/VerificaEvidenciaController.php:313`: `$suma_creditos = DB::select('select if(sum(case when por_credito > 100 then 100 else por_credito end) is null,0,sum(case when por_credito > 100 then 100 else por_credito end)) as credito_suma,alumnos.id as alumno_id ,alumnos.nombre,alumnos.status, alumnos.no_control, areas.nombre as carrera, if(avan`
- `app/Http/Controllers/VerificaEvidenciaController.php:317`: `$reportes_data = DB::select('select alumnos.nombre,alumnos.status, alumnos.no_control, areas.nombre as carrera, if(avance.por_credito is null or avance.por_credito > 100, if( avance.por_credito > 100, 100, 0), avance.por_credito) as por_credito, creditos.nombre as nombre_credito from alumnos join cr`
- `app/Http/Controllers/VerificaEvidenciaController.php:320`: `$suma_creditos = DB::select('select if(sum(case when por_credito > 100 then 100 else por_credito end) is null,0,sum(case when por_credito > 100 then 100 else por_credito end)) as credito_suma,alumnos.id as alumno_id ,alumnos.nombre,alumnos.status, alumnos.no_control, areas.nombre as carrera, if(avan`
- `app/Http/Controllers/VerificaEvidenciaController.php:333`: `if($request->has('generacion')){`
- `app/Http/Controllers/VerificaEvidenciaController.php:334`: `//Substraemos los dos ultimos digitos del año de generacion`
- `app/Http/Controllers/VerificaEvidenciaController.php:335`: `$generacion = substr($request->generacion,2,4);`
- `app/Http/Controllers/VerificaEvidenciaController.php:340`: `$reportes_data = DB::select('select alumnos.nombre,alumnos.status, alumnos.no_control, areas.nombre as carrera, if(avance.por_credito is null or avance.por_credito > 100, if( avance.por_credito > 100, 100, 0), avance.por_credito) as por_credito, creditos.nombre as nombre_credito from alumnos join cr`
- `app/Http/Controllers/VerificaEvidenciaController.php:342`: `$suma_creditos = DB::select('select if(sum(case when por_credito > 100 then 100 else por_credito end) is null,0,sum(case when por_credito > 100 then 100 else por_credito end)) as credito_suma,alumnos.id as alumno_id ,alumnos.nombre, alumnos.status, alumnos.no_control, areas.nombre as carrera, if(ava`
- `app/Http/Controllers/VerificaEvidenciaController.php:346`: `$reportes_data = DB::select('select alumnos.nombre,alumnos.status, alumnos.no_control, areas.nombre as carrera, if(avance.por_credito is null or avance.por_credito > 100, if( avance.por_credito > 100, 100, 0), avance.por_credito) as por_credito, creditos.nombre as nombre_credito from alumnos join cr`
- `app/Http/Controllers/VerificaEvidenciaController.php:348`: `$suma_creditos = DB::select('select if(sum(case when por_credito > 100 then 100 else por_credito end) is null,0,sum(case when por_credito > 100 then 100 else por_credito end)) as credito_suma,alumnos.id as alumno_id ,alumnos.nombre, alumnos.status, alumnos.no_control, areas.nombre as carrera, if(ava`
- `app/Http/Controllers/VerificaEvidenciaController.php:367`: `->with('generacion',$request->generacion);`
- `app/Models/Alumno.php:19`: `protected $fillable=['no_control','password','nombre','carrera','status','foto','observaciones','email','ficha','nombre_i','a_pat','a_mat','creditos','fec_nac','lug_pro','curp','sexo','est_civ','tel','tel_emer','beca','grupo','nom_ficha','generacion'];`
- `routes/web.php:229`: `Route::post('/sta/analisis/generación',[JefesController::class,'generacion'])->name('analisis.generacion');`
### `grupo`
- `app/Http/Controllers/AlumnosStaController.php:95`: `$alu->grupo = $request->grupo;`
- `app/Http/Controllers/GruposController.php:37`: `//Agregamos el nombre de la carrera a cada grupo`
- `app/Http/Controllers/GruposController.php:38`: `foreach ($grupos as $grupo) {`
- `app/Http/Controllers/GruposController.php:39`: `$grupo->gpo_Carrera = DB::connection('SIT')->table('carreras')`
- `app/Http/Controllers/GruposController.php:40`: `->where('car_Clave',$grupo->id_Carrera)`
- `app/Http/Controllers/GruposController.php:52`: `//Verificamos si el grupo existe y solo si no, lo damos de alta`
- `app/Http/Controllers/GruposController.php:60`: `Alert::error('Error','Este grupo ya se encuentra dado de alta');`
- `app/Http/Controllers/GruposController.php:63`: `//Creamos el grupo`
- `app/Http/Controllers/GruposController.php:64`: `$grupo = new Grupo();`
- `app/Http/Controllers/GruposController.php:65`: `$grupo->gpo_Nombre = $request->gpo_Nombre;`
- `app/Http/Controllers/GruposController.php:66`: `$grupo->id_Carrera = $request->id_Carrera;`
- `app/Http/Controllers/GruposController.php:67`: `$grupo->gpo_Status = 0;`
- `app/Http/Controllers/GruposController.php:68`: `$grupo->gpo_Semestre= $request->gpo_Semestre;`
- `app/Http/Controllers/GruposController.php:69`: `$grupo->save();`
- `app/Http/Controllers/GruposController.php:70`: `Alert::success('Correcto',"El grupo se ha guardado correctamente");`
- `app/Http/Controllers/GruposController.php:76`: `Alert::error('Error','Ocurrio un error al guardar el grupo');`
- `app/Http/Controllers/GruposController.php:81`: `//Función para eliminar un grupo`
- `app/Http/Controllers/GruposController.php:86`: `//Obtenemos el grupo a eliminar`
- `app/Http/Controllers/GruposController.php:87`: `$grupo = Grupo::find($id);`
- `app/Http/Controllers/GruposController.php:88`: `//Eliminamos el grupo`
- `app/Http/Controllers/GruposController.php:89`: `$grupo->delete();`
- `app/Http/Controllers/GruposController.php:90`: `Alert::success('Correcto',"El grupo se ha eliminado correctamente");`
- `app/Http/Controllers/GruposController.php:96`: `Alert::error('Error','Ocurrio un error al eliminar el grupo, ya que tiene un tutor asignado');`
- `app/Http/Controllers/GruposController.php:102`: `//Función para modificar un grupo`
- `app/Http/Controllers/GruposController.php:106`: `//Obtenemos el grupo a modificar`
- `app/Http/Controllers/GruposController.php:107`: `$grupo = Grupo::find($id);`
- `app/Http/Controllers/GruposController.php:108`: `//Actualizamos el grupo`
- `app/Http/Controllers/GruposController.php:109`: `$grupo->gpo_Nombre = $request->gpo_Nombre;`
- `app/Http/Controllers/GruposController.php:110`: `$grupo->id_Carrera = $request->id_Carrera;`
- `app/Http/Controllers/GruposController.php:111`: `$grupo->gpo_Status = $request->gpo_Status;`
- `app/Http/Controllers/GruposController.php:112`: `$grupo->gpo_Semestre= $request->gpo_Semestre;`
- `app/Http/Controllers/GruposController.php:113`: `$grupo->save();`
- `app/Http/Controllers/GruposController.php:114`: `Alert::success('Correcto',"El grupo se ha actualizado correctamente");`
- `app/Http/Controllers/GruposController.php:120`: `Alert::error('Error','Ocurrio un error al modificar el grupo');`
- `app/Http/Controllers/GruposController.php:131`: `//Guarda el grupo si no existe en la tabla de grupos`
- `app/Http/Controllers/GruposController.php:132`: `$grupo=AsignacionTutores::updateOrCreate(`
- `app/Http/Controllers/GruposController.php:137`: `if ($grupo->wasRecentlyCreated) {`
- `app/Http/Controllers/GruposController.php:138`: `// Cambiamos el status del grupo a 1`
- `app/Http/Controllers/GruposController.php:139`: `$grupo = Grupo::find($request->gpo_Id);`
- `app/Http/Controllers/GruposController.php:140`: `$grupo->gpo_Status = 1;`
- `app/Http/Controllers/GruposController.php:141`: `$grupo->save();`
- `app/Http/Controllers/GruposController.php:142`: `Alert::success('Correcto',"El grupo se ha asignado correctamente");`
- `app/Http/Controllers/GruposController.php:147`: `Alert::error('Error',"Ocurrio un error al asignar el grupo");`
- `app/Http/Controllers/GruposController.php:153`: `//Función para eliminar un grupo`
- `app/Http/Controllers/GruposController.php:157`: `//Obtenemos el grupo a eliminar`
- `app/Http/Controllers/GruposController.php:159`: `//Eliminamos el grupo`
- `app/Http/Controllers/GruposController.php:161`: `// Cambiamos el status del grupo a 0`
- `app/Http/Controllers/GruposController.php:162`: `$grupo = Grupo::find($request->gpo_Id);`
- `app/Http/Controllers/GruposController.php:163`: `$grupo->gpo_Status = 0;`
- `app/Http/Controllers/GruposController.php:164`: `$grupo->save();`
- `app/Http/Controllers/GruposController.php:165`: `//Quitamos los alumnos asignados a este grupo de la tabla gpo_tutorias`
- `app/Http/Controllers/GruposController.php:167`: `Alert::success('Correcto',"El grupo se ha eliminado correctamente");`
- `app/Http/Controllers/GruposController.php:171`: `Alert::error('Error',"Ocurrio un error al eliminar el grupo");`
- `app/Http/Controllers/JefesController.php:45`: `$grupo="";`
- `app/Http/Controllers/JefesController.php:57`: `->with('grupo',$grupo)`
- `app/Http/Controllers/JefesController.php:66`: `// Obtener el grupo de alumnos basado en carrera y año de ingreso`
- `app/Http/Controllers/JefesController.php:67`: `$grupo = DB::connection('SIT')->table('alumnos')`
- `app/Http/Controllers/JefesController.php:82`: `if ($grupo->isEmpty()) {`
- `app/Http/Controllers/JefesController.php:88`: `$fichas = Alumno::whereIn('no_control', $grupo->pluck('control'))`
- `app/Http/Controllers/JefesController.php:93`: `// Iterar sobre el grupo y asignar las fichas y semáforos correspondientes`
- `app/Http/Controllers/JefesController.php:94`: `foreach ($grupo as $alu) {`
- `app/Http/Controllers/JefesController.php:123`: `return view('sta.analisis_alumnos.index', compact('grupo', 'carreras', 'generaciones'))`
- `app/Http/Controllers/STAController.php:181`: `->where('listassemestre.gse_Clave',$request->grupo)`
- `app/Http/Controllers/STAController.php:237`: `// Agregar el nombre de la carrera a cada grupo`
- `app/Http/Controllers/STAController.php:242`: `// Agregar el nombre del profesor a cada grupo`
- `app/Http/Controllers/STAController.php:287`: `// Asignar nombre del grupo`
- `app/Http/Controllers/STAController.php:306`: `//Llamamos a la función para completar el grupo`
- `app/Http/Controllers/STAController.php:307`: `$grupo = $this->completarGrupo($id);`
- `app/Http/Controllers/STAController.php:316`: `// Obtén todos los alumnos del grupo en una sola consulta`
- `app/Http/Controllers/STAController.php:319`: `// Obtén los números de control de los alumnos del grupo`
- `app/Http/Controllers/STAController.php:334`: `// Itera sobre los alumnos del grupo y agrega los datos correspondientes`
- `app/Http/Controllers/STAController.php:357`: `return view('sta.tutores.showGrupo',compact('grupo','alumnos','alumnosGrupo'));`
- `app/Http/Controllers/STAController.php:362`: `// Obtén la información del grupo`
- `app/Http/Controllers/STAController.php:363`: `$grupo = AsignacionTutores::where('id', $id)->get();`
- `app/Http/Controllers/STAController.php:365`: `// Extraer las claves de tutor, grupo y carrera`
- `app/Http/Controllers/STAController.php:366`: `$tutClaves = $grupo->pluck('tut_Clave')->toArray();`
- `app/Http/Controllers/STAController.php:367`: `$gpoIds = $grupo->pluck('gpo_Id')->toArray();`
- `app/Http/Controllers/STAController.php:368`: `$carClaves = $grupo->pluck('car_Clave')->toArray();`
- `app/Http/Controllers/STAController.php:378`: `// Iterar sobre el grupo y agregar los datos del tutor, grupo y carrera`
- `app/Http/Controllers/STAController.php:379`: `foreach ($grupo as $gru) {`
- `app/Http/Controllers/STAController.php:385`: `// Asignar el nombre del grupo`
- `app/Http/Controllers/STAController.php:396`: `return $grupo;`
- `app/Http/Controllers/STAController.php:400`: `//Función para guardar los alumnos de un grupo`
- `app/Http/Controllers/STAController.php:412`: `//Guardamos el numero de control y grupo en la tabla gpoTutorias`
- `app/Http/Controllers/STAController.php:427`: `//Función para eliminar un alumno de un grupo`
- `app/Http/Controllers/STAController.php:445`: `// Obtener el grupo completo con una sola consulta`
- `app/Http/Controllers/STAController.php:446`: `$grupo = $this->completarGrupo($id);`
- `app/Http/Controllers/STAController.php:448`: `// Obtener los alumnos del grupo`
- `app/Http/Controllers/STAController.php:449`: `$alumnosGrupo = GpoTutorias::where('gpo_Nombre', $grupo[0]->gpo_Nombre)->get();`
- `app/Http/Controllers/STAController.php:458`: `// Verificar y asignar datos del alumno en el grupo`
- `app/Http/Controllers/STAController.php:484`: `return view('sta.tutores.analisis', compact('grupo', 'alumnosGrupo'));`
- `app/Models/Alumno.php:19`: `protected $fillable=['no_control','password','nombre','carrera','status','foto','observaciones','email','ficha','nombre_i','a_pat','a_mat','creditos','fec_nac','lug_pro','curp','sexo','est_civ','tel','tel_emer','beca','grupo','nom_ficha','generacion'];`
- `routes/web.php:245`: `Route::post('/sta/tutorias/save/grupo',[GruposController::class,'saveGrupo'])->name('tutorias.saveGrupo');`
- `routes/web.php:257`: `Route::get('/sta/tutores/show/grupo/{id}/{nom}',[STAController::class,'showGrupo'])->name('tutores.showGrupo');`
- `routes/web.php:258`: `Route::post('/sta/tutores/store/grupo',[STAController::class,'storeGrupo'])->name('tutores.storeGrupo');`
### `lug_pro`
- `app/Http/Controllers/AlumnosStaController.php:94`: `$alu->lug_pro = $request->lug;`
- `app/Models/Alumno.php:19`: `protected $fillable=['no_control','password','nombre','carrera','status','foto','observaciones','email','ficha','nombre_i','a_pat','a_mat','creditos','fec_nac','lug_pro','curp','sexo','est_civ','tel','tel_emer','beca','grupo','nom_ficha','generacion'];`
### `nom_ficha`
- `app/Models/Alumno.php:19`: `protected $fillable=['no_control','password','nombre','carrera','status','foto','observaciones','email','ficha','nombre_i','a_pat','a_mat','creditos','fec_nac','lug_pro','curp','sexo','est_civ','tel','tel_emer','beca','grupo','nom_ficha','generacion'];`
### `nombre`
- `app/Http/Controllers/ActividadesController.php:44`: `'a.nombre as actividad_nombre','a.id','a.por_cred_actividad','a.vigente',`
- `app/Http/Controllers/ActividadesController.php:45`: `'a.alumnos','c.nombre as credito_nombre','u.name as administrador','a.id_user',`
- `app/Http/Controllers/ActividadesController.php:168`: `$creditos = Credito::where('vigente','=','true')->orderBy('nombre','asc')->get();`
- `app/Http/Controllers/ActividadesController.php:176`: `->select('creditos.id', 'creditos.nombre')`
- `app/Http/Controllers/ActividadesController.php:178`: `->orderBy('creditos.nombre','asc')`
- `app/Http/Controllers/ActividadesController.php:196`: `$actividad_con_mismo_nombre = Actividad::where('nombre','=',$act->nombre)->get();`
- `app/Http/Controllers/ActividadesController.php:214`: `Alert::error('Error', 'El nombre '.$act->nombre.' ya ha sido tomado, ingrese uno diferente');`
- `app/Http/Controllers/ActividadesController.php:226`: `Alert::success('Correcto', 'La actividad '.$act->nombre.' se registro correctamente');`
- `app/Http/Controllers/ActividadesController.php:249`: `$creditos=Credito::orderBy('nombre','asc')->get();`
- `app/Http/Controllers/ActividadesController.php:252`: `$creditos=Credito::orderBy('nombre','asc')->get();`
- `app/Http/Controllers/ActividadesController.php:272`: `$actividad_con_mismo_nombre = Actividad::where('nombre','=',$act_nueva->nombre)->get();`
- `app/Http/Controllers/ActividadesController.php:275`: `Alert::error('Error','El nombre ".$act_nueva->nombre." ya ha sido tomado, ingrese uno diferente');`
- `app/Http/Controllers/ActividadesController.php:308`: `//En caso de la actividad ya cuente con evidencias y a esta se le cambie el nombre`
- `app/Http/Controllers/ActividadesController.php:310`: `if($act_anterior->nombre!=$act_nueva->nombre && Storage::has('public/evidencias')){`
- `app/Http/Controllers/ActividadesController.php:311`: `// Validamos si existe el directorio con el nombre anterios si no significa que no tenia evidencia agregada aun`
- `app/Http/Controllers/ActividadesController.php:312`: `if(Storage::has('public/evidencias/'.$act_anterior->nombre)){`
- `app/Http/Controllers/ActividadesController.php:314`: `$archivos = Storage::allFiles('public/evidencias/'.$act_anterior->nombre);`
- `app/Http/Controllers/ActividadesController.php:315`: `if(!Storage::has('public/evidencias/'.$act_nueva->nombre)){`
- `app/Http/Controllers/ActividadesController.php:317`: `Storage::makeDirectory('public/evidencias/'.$act_nueva->nombre);`
- `app/Http/Controllers/ActividadesController.php:322`: `//Existen 3 diagonales antes de llegar al nombre del archivo`
- `app/Http/Controllers/ActividadesController.php:329`: `Storage::move('public/evidencias/'.$act_anterior->nombre.'/'.$tokenizer,'public/evidencias/'.$act_nueva->nombre.'/'.$tokenizer);`
- `app/Http/Controllers/ActividadesController.php:332`: `Storage::deleteDirectory('public/evidencias/'.$act_anterior->nombre);`
- `app/Http/Controllers/ActividadesController.php:336`: `Alert::warning('Alerta', 'La actividad '.$act_nueva->nombre.' ha sido editada con exito');`
- `app/Http/Controllers/ActividadesController.php:364`: `Alert::success('Correcto','La actividad '.$act->nombre.' ha sido borrada con exito');`
- `app/Http/Controllers/ActividadesController.php:375`: `Alert::success('Correcto','La actividad '.$act->nombre.' ha sido borrada con exito');`
- `app/Http/Controllers/Actividad_EvidenciasController.php:177`: `$mensaje->mensaje = "Has sido asignado a la actividad ".$actividad->nombre.". #".$actividad->id;`
- `app/Http/Controllers/altaAlumnosController.php:43`: `'nombre' => $row[1],`
- `app/Http/Controllers/AlumnosController.php:39`: `$selectColumns = ['alu.nombre','alu.no_control','alu.email','alu.status','alu.id as alumno_id','a.nombre as carrera'];`
- `app/Http/Controllers/AlumnosController.php:59`: `$alumno->alumno_id .','."'". $alumno->nombre . "'". ')" data-toggle="modal" data-target="#myModalMsg" title="Eliminar alumno">`
- `app/Http/Controllers/AlumnosController.php:76`: `$carreras = Area::where('tipo','=','carrera')->orderBy('nombre','ASC')->get();`
- `app/Http/Controllers/AlumnosController.php:131`: `$alumno->nombre=$request->nombre;`
- `app/Http/Controllers/AlumnosController.php:141`: `Alert::error('Error','Error de credenciales, las contraseñas deben ser iguales para el alumno: '.$alumno->nombre);`
- `app/Http/Controllers/AlumnosController.php:149`: `Alert::warning('Alerta','El alumno '. $alumno->nombre .' a sido editado de forma exitosa');`
- `app/Http/Controllers/AlumnosController.php:167`: `Alert::error('Error','El alumno '.$alumno->nombre.' no puede ser eliminado por que esta registrado en algunas actividades');`
- `app/Http/Controllers/AlumnosController.php:171`: `Alert::success('Correcto','El alumno '. $alumno->nombre .' a sido borrado de forma exitosa');//Envia mensaje`
- `app/Http/Controllers/AlumnosController.php:177`: `$selectColumns = ['alu.nombre','alu.no_control','alu.foto','alu.id as alumno_id','alu.password','a.nombre as carrera'];`
- `app/Http/Controllers/AlumnosController.php:228`: `//Para evitar nombres repetidos en las imagenes, creamos un nombre antes de guardar`
- `app/Http/Controllers/AlumnosController.php:232`: `$alumno->foto=$name;//Obtiene el nombre de la imagen para guardarlo en la bd`
- `app/Http/Controllers/AlumnosController.php:269`: `$selectColumns = ['alu.nombre','alu.no_control','alu.status','alu.id as alumno_id','a.nombre as carrera'];`
- `app/Http/Controllers/AlumnosRutasController.php:32`: `$creditos = Credito::select('nombre')->orderBy('nombre')->get();`
- `app/Http/Controllers/AlumnosRutasController.php:58`: `->select('alu.no_control','alu.foto as foto','alu.id as alumno_id','alu.nombre as nombre_alumno','areas.nombre as carrera','c.nombre as nombre_credito','a.nombre as nombre_actividad','a.por_cred_actividad','av.por_credito')`
- `app/Http/Controllers/AlumnosRutasController.php:71`: `})->where('alumnos.no_control','=',Auth::User()->no_control)->select('alumnos.id as alumno_id','alumnos.nombre as nombre_alumno','areas.nombre as carrera','alumnos.no_control','alumnos.foto')->get();`
- `app/Http/Controllers/AlumnosRutasController.php:114`: `$alumno = DB::table('alumnos')->join('areas','areas.id','=','alumnos.carrera')->where('alumnos.no_control','=',Auth::User()->no_control)->select('alumnos.nombre','alumnos.no_control','areas.nombre as carrera')->get();`
- `app/Http/Controllers/AlumnosRutasController.php:115`: `$alumno_data = DB::select('select c.nombre as credito_nombre, u.name as credito_jefe from creditos as c join avance on avance.id_credito=c.id and avance.no_control = "'.Auth::User()->no_control.'" and avance.por_credito >= 100 join users as u on u.id = c.credito_jefe order by c.id limit 5');`
- `app/Http/Controllers/AlumnosRutasController.php:165`: `->select('act.nombre as act_nombre', 'act.por_cred_actividad as porcentaje',`
- `app/Http/Controllers/AlumnosRutasController.php:211`: `->select('a.nombre as actividad_nombre','a.id as actividad_id','a.por_cred_actividad as actividad_porcentaje','a.alumnos','ae.validado','ae.user_id','c.nombre as credito_nombre','p.momento_agregado','p.evidencia_validada')`
- `app/Http/Controllers/AlumnosRutasController.php:302`: `$path=storage_path().'/app/public/evidencias/'.$actividad->nombre.'/';`
- `app/Http/Controllers/AlumnosRutasController.php:303`: `$path_to_verify = 'public/evidencias/'.$actividad->nombre;`
- `app/Http/Controllers/AlumnosRutasController.php:308`: `//En el metodo file ponemos el nombre del campo file que pusimos en la vista, que sera el que tenga los datos de la imagen`
- `app/Http/Controllers/AlumnosRutasController.php:310`: `//Para evitar nombres repetidos en las imagenes, creamos un nombre antes de guardar`
- `app/Http/Controllers/AlumnosRutasController.php:317`: `$evidencia->nom_imagen=$name;//Obtiene el nombre de la imagen para guardarlo en la bd`
- `app/Http/Controllers/AlumnosRutasController.php:343`: `})->join('actividad as a','a.id','=','ae.actividad_id')->join('users as u','u.id','=','ae.user_id')->select('a.nombre as actividad_nombre','a.id as actividad_id','e.nom_imagen as evidencia_nombre','ae.user_id','e.created_at as fecha','e.id as evidencia_id','u.name as usuario_nombre')->get();`
- `app/Http/Controllers/AlumnosRutasController.php:386`: `'a.nombre as actividad_nombre','e.id as evidencia_id', 'p.evidencia_validada as participante_evidencia_validada',`
- `app/Http/Controllers/AlumnosRutasController.php:401`: `->select('a.nombre as actividad_nombre', 'e.nom_imagen as archivo_nombre', 'ae.validado',`
- `app/Http/Controllers/AlumnosStaController.php:98`: `$dPad->nombre = $request->nomPa;`
- `app/Http/Controllers/AlumnosStaController.php:109`: `$dMad->nombre = $request->nomMa;`
- `app/Http/Controllers/AlumnosStaController.php:290`: `if (isset($request->nombre[0])  ) {`
- `app/Http/Controllers/AlumnosStaController.php:294`: `$familiar->nombre = $request->nombre[$i];`
- `app/Http/Controllers/AreasController.php:31`: `$nombre_ya_existe = Area::where('nombre','=',$request->nombre)->get()->count() > 0? true: false;`
- `app/Http/Controllers/AreasController.php:33`: `Alert::error('Error','Una area ya existe con este nombre');`
- `app/Http/Controllers/AreasController.php:38`: `Alert::success('Correcto','La area '.$area->nombre.' se ha guardado correctamente');`
- `app/Http/Controllers/AreasController.php:54`: `['nombre','=',$request->nombre],`
- `app/Http/Controllers/AreasController.php:58`: `Alert::error('Error','El nombre del area ya ha sido tomado');`
- `app/Http/Controllers/AreasController.php:64`: `Alert::success('Correcto','El area '.$area->nombre.' ha sido guardada correctamente');`
- `app/Http/Controllers/ConstanciasController.php:155`: `$alumno = DB::table('alumnos')->join('areas','areas.id','=','alumnos.carrera')->where('alumnos.no_control','=',$request->no_control)->select('alumnos.nombre','alumnos.no_control','areas.nombre as carrera')->get();`
- `app/Http/Controllers/ConstanciasController.php:156`: `$alumno_data = DB::select('select c.nombre as credito_nombre, u.name as credito_jefe from creditos as c join avance on avance.id_credito=c.id and avance.no_control = "'.$request->no_control.'" and avance.por_credito >= 100 join users as u on u.id = c.credito_jefe order by c.id limit 5');`
- `app/Http/Controllers/ConstanciasController.php:319`: `array_push($constancias_faltantes, $carrera->nombre);`
- `app/Http/Controllers/CreditosController.php:6`: `use App\Models\Credito; //Es el nombre del modelo con el que va a trabajar el controlador`
- `app/Http/Controllers/CreditosController.php:28`: `$credito = Credito::leftjoin('users as u','u.id','=','creditos.credito_jefe')->select('creditos.nombre','creditos.vigente','creditos.id','u.name as jefe_nombre')->get();`
- `app/Http/Controllers/CreditosController.php:41`: `$areas = Area::orderby('nombre','ASC')->get();`
- `app/Http/Controllers/CreditosController.php:63`: `Alert::success('Correcto','El credito  '.$credito->nombre.' se ha registrado de forma exitosa');`
- `app/Http/Controllers/CreditosController.php:74`: `})->select('a.nombre','a.id','ca.credito_id')->orderBy('nombre','ASC')->get();`
- `app/Http/Controllers/CreditosController.php:93`: `$credito->nombre=$request->nombre;`
- `app/Http/Controllers/CreditosController.php:104`: `Alert::warning('Alerta','El credito '. $credito->nombre .' a sido editado de forma exitosa');//Envia mensaje`
- `app/Http/Controllers/CreditosController.php:131`: `Alert::success('Correcto','El credito '. $credito->nombre .' a sido borrado de forma exitosa');`
- `app/Http/Controllers/EvidenciasController.php:34`: `$actividades = Actividad::select('nombre','id')->orderBy('nombre')->get();`
- `app/Http/Controllers/EvidenciasController.php:43`: `->select('a.nombre','a.id')`
- `app/Http/Controllers/EvidenciasController.php:44`: `->orderBy('nombre')`
- `app/Http/Controllers/EvidenciasController.php:73`: `$actividad = Actividad::select('id','nombre')->where('id','=',$request->id_actividad)->get();`
- `app/Http/Controllers/EvidenciasController.php:127`: `$path = storage_path() . '/app/public/evidencias/' . $actividad->nombre . '/';`
- `app/Http/Controllers/EvidenciasController.php:128`: `$storage_path = 'public/evidencias/' . $actividad->nombre;`
- `app/Http/Controllers/EvidenciasController.php:137`: `//En el metodo file ponemos el nombre del campo file que pusimos en la vista, que sera el que tenga los datos de la imagen`
- `app/Http/Controllers/EvidenciasController.php:139`: `//Para evitar nombres repetidos en las imagenes, creamos un nombre antes de guardar`
- `app/Http/Controllers/EvidenciasController.php:147`: `$evidencia->nom_imagen = $name; //Obtiene el nombre de la imagen para guardarlo en la bd`
- `app/Http/Controllers/EvidenciasController.php:211`: `'a.nombre as actividad_nombre','e.id as evidencia_id','alu.nombre as alumno_nombre'`
- `app/Http/Controllers/EvidenciasController.php:225`: `->select('users.name as responsable_nombre','a.nombre as actividad_nombre','e.nom_imagen',`
- `app/Http/Controllers/EvidenciasController.php:226`: `DB::raw('DATE_FORMAT(e.created_at, "%d-%m-%Y") as fecha_creacion'),'e.id as evidencia_id','alu.nombre as alumno_nombre',`
- `app/Http/Controllers/EvidenciasController.php:241`: `->select('a.nombre as actividad_nombre', 'e.nom_imagen as archivo_nombre', 'ae.validado', 'ae.user_id as responsable', 'a.id_user as owner_id', 'e.id as archivo')`
- `app/Http/Controllers/GruposController.php:37`: `//Agregamos el nombre de la carrera a cada grupo`
- `app/Http/Controllers/GruposController.php:187`: `//Obtenemos el nombre de la carrera y se lo asignamos a la variable`
- `app/Http/Controllers/GruposController.php:207`: `//Obtenemos el nombre de la carrera y se lo asignamos a la variable`
- `app/Http/Controllers/JefesController.php:72`: `"alu_Nombre AS nombre",`
- `app/Http/Controllers/ParticipantesController.php:6`: `use App\Models\Participante; //Es el nombre del modelo con el que va a trabajar el controlador`
- `app/Http/Controllers/ParticipantesController.php:39`: `$actividades = Actividad::select('id','nombre')->orderBy('nombre','ASC')->get();`
- `app/Http/Controllers/ParticipantesController.php:51`: `->select('a.id','a.nombre')`
- `app/Http/Controllers/ParticipantesController.php:52`: `->orderBy('nombre','ASC')`
- `app/Http/Controllers/ParticipantesController.php:65`: `->select('a.id','a.nombre')`
- `app/Http/Controllers/ParticipantesController.php:66`: `->orderBy('nombre','ASC')`
- `app/Http/Controllers/ParticipantesController.php:112`: `})->join('actividad as act','act.id','=','ae.actividad_id')->select('act.id as actividad_id','act.alumnos as evidencia_individual','act.vigente','ae.id as ae_id','p.no_control as no_control','act.nombre as actividad_nombre')->get()[0];`
- `app/Http/Controllers/ParticipantesController.php:218`: `->select('a.nombre','areas.nombre as carrera','p.id','p.id_evidencia','a.no_control','e.alumno_no_control as tiene_evidencia','p.momento_agregado','p.evidencia_validada')->groupBy('p.no_control')->get();`
- `app/Http/Controllers/ParticipantesController.php:318`: `return response()->json(array('mensaje' => 'La actividad '.$actividad->nombre.' ya no se encuentra vigente','mensaje_tipo' => 'Error','icono'=> 'error' ));`
- `app/Http/Controllers/ParticipantesController.php:411`: `$lista_alumnos = Alumno::select('nombre','no_control')->where('nombre','like',"%$request->nombre%")->orderBy('nombre')->get();`
- `app/Http/Controllers/ParticipantesController.php:413`: `$lista_alumnos = Alumno::select('nombre')->where('no_control','=',$request->no_control)->get();`
- `app/Http/Controllers/ParticipantesController.php:432`: `})->join('actividad as a','a.id','=','ae.actividad_id')->join('users as u','u.id','=','ae.user_id')->select('a.nombre as actividad_nombre','a.id as actividad_id','e.nom_imagen as evidencia_nombre','ae.user_id','e.created_at as fecha','e.id as evidencia_id','u.name as usuario_nombre')->get();`
- `app/Http/Controllers/ParticipantesController.php:506`: `->select('ae.id as ae_id','p.no_control','act.nombre','c.vigente as credito_vigente','act.vigente as actividad_vigente','act.alumnos as alumnos_responsables','act.id_user as administrador_id','act.id as actividad_id','act.por_cred_actividad','ae.validado as actividad_validada','c.id as credito_id')-`
- `app/Http/Controllers/PerfilController.php:21`: `$data_user = User::join('areas as a','a.id','=','users.area')->where('users.id','=',Auth::User()->id)->select('a.nombre as area_nombre','users.name as usuario_nombre','users.email as usuario_correo')->get();`
- `app/Http/Controllers/ResponsablesController.php:18`: `$responsables = User::join('actividad_evidencia as act_evi','act_evi.user_id','=','users.id')->join('areas','areas.id','=','users.area')->where('act_evi.actividad_id','=',$id)->select('act_evi.id as actividad_evidencia_id','act_evi.actividad_id','act_evi.user_id','users.name','areas.nombre as area',`
- `app/Http/Controllers/ResponsablesController.php:35`: `})->leftjoin('actividad as a','a.id','=','ae.actividad_id')->leftjoin('evidencia as e','e.id_asig_actividades','=','ae.id')->leftjoin('participantes as p','p.id_evidencia','=','ae.id')->leftjoin('areas','areas.id','=','users.area')->where('users.id','<>',1)->groupBy('usuario_id')->select('users.name`
- `app/Http/Controllers/ResponsablesController.php:43`: `})->leftjoin('actividad as a','a.id','=','ae.actividad_id')->leftjoin('evidencia as e','e.id_asig_actividades','=','ae.id')->leftjoin('participantes as p','p.id_evidencia','=','ae.id')->leftjoin('areas','areas.id','=','users.area')->where('users.email','<>','admin@itsch.com')->groupBy('usuario_id')-`
- `app/Http/Controllers/SistemaMedicoController.php:86`: `//Verificamos si es alumno y consultamos su nombre de la tabla pacientes de lo contrario consultamos el nombre de la tabla usuarios y lo agregamos a $paciente`
- `app/Http/Controllers/SistemaMedicoController.php:89`: `$paciente->nombre = $usuarioPaciente->nombre;`
- `app/Http/Controllers/SistemaMedicoController.php:92`: `$paciente->nombre = $usuarioPaciente->name;`
- `app/Http/Controllers/STAController.php:76`: `// Obtener el nombre del usuario autenticado y procesarlo`
- `app/Http/Controllers/STAController.php:87`: `// Procesar el nombre completo del catedrático`
- `app/Http/Controllers/STAController.php:90`: `// Verificar la similitud entre el nombre del usuario y el nombre del catedrático`
- `app/Http/Controllers/STAController.php:205`: `$profesores = User::select('id', DB::raw('UPPER(name) as nombre'))`
- `app/Http/Controllers/STAController.php:237`: `// Agregar el nombre de la carrera a cada grupo`
- `app/Http/Controllers/STAController.php:242`: `// Agregar el nombre del profesor a cada grupo`
- `app/Http/Controllers/STAController.php:245`: `$gru->name = $profesores[$gru->tut_Clave]->nombre;`
- `app/Http/Controllers/STAController.php:282`: `// Asignar nombre del tutor`
- `app/Http/Controllers/STAController.php:287`: `// Asignar nombre del grupo`
- `app/Http/Controllers/STAController.php:292`: `// Asignar nombre de la carrera`
- `app/Http/Controllers/STAController.php:380`: `// Asignar el nombre del tutor`
- `app/Http/Controllers/STAController.php:385`: `// Asignar el nombre del grupo`
- `app/Http/Controllers/STAController.php:390`: `// Asignar el nombre de la carrera`
- `app/Http/Controllers/UsersController.php:28`: `->select('a.nombre as area','u.name','u.active','u.id','u.email','u.tutor')`
- `app/Http/Controllers/UsersController.php:39`: `->select('a.nombre as area','u.name','u.active','u.id','u.email')`
- `app/Http/Controllers/UsersController.php:49`: `$areas = Area::orderBy('nombre','ASC')->get();`
- `app/Http/Controllers/UsersController.php:86`: `$areas = Area::where('id','=',Auth::User()->area)->orderBy('nombre','ASC')->get();`
- `app/Http/Controllers/UsersController.php:116`: `$areas = Area::orderBy('nombre','ASC')->get();`
- `app/Http/Controllers/UsersController.php:129`: `$areas = Area::where('id','=',Auth::User()->area)->orderBy('nombre','ASC')->get();`
- `app/Http/Controllers/UsersController.php:160`: `Alert::error('Error','Error de credenciales, las contraseñas deben ser iguales para el usuario: '.$user->nombre);`
- `app/Http/Controllers/Utilities/DataTableAttr.php:10`: `private $data; // Contiene el nombre dado a la columna`
- `app/Http/Controllers/VerificaEvidenciaController.php:52`: `$query->where('a.nombre','LIKE',"%$request->busqueda%")`
- `app/Http/Controllers/VerificaEvidenciaController.php:53`: `->orwhere('c.nombre','LIKE',"%$request->busqueda%")`
- `app/Http/Controllers/VerificaEvidenciaController.php:58`: `->select('e.nom_imagen','e.id','ae.validado','u.name','a.nombre','a.por_cred_actividad','c.nombre as nombre_credito','c.id as id_credito','ae.id as actividad_evidencia_id','validador.name as validador_nombre','validador.id as validador_id','c.vigente')`
- `app/Http/Controllers/VerificaEvidenciaController.php:69`: `$query->where('a.nombre','LIKE',"%$request->busqueda%")`
- `app/Http/Controllers/VerificaEvidenciaController.php:70`: `->orwhere('c.nombre','LIKE',"%$request->busqueda%")`
- `app/Http/Controllers/VerificaEvidenciaController.php:78`: `->select('e.nom_imagen','e.id','ae.validado','u.name','a.nombre','a.por_cred_actividad','c.nombre as nombre_credito','c.id as id_credito','ae.id as actividad_evidencia_id','validador.name as validador_nombre','validador.id as validador_id','c.vigente')`
- `app/Http/Controllers/VerificaEvidenciaController.php:199`: `$creditos = Credito::select('nombre')->orderBy('nombre')->get();`
- `app/Http/Controllers/VerificaEvidenciaController.php:231`: `->select('alu.no_control','alu.nombre as nombre_alumno','areas.nombre as carrera','c.nombre as nombre_credito','a.nombre as nombre_actividad','a.por_cred_actividad','av.por_credito')->orderBy('nombre_credito')->groupBy('nombre_actividad')->get();`
- `app/Http/Controllers/VerificaEvidenciaController.php:237`: `$alumno_data= DB::table('alumnos as alu')->join('areas as a','a.id','=','alu.carrera')->select('alu.nombre as nombre_alumno','a.nombre as carrera','alu.no_control','alu.foto')->where('alu.no_control','=',$request->get('no_control'))->get();`
- `app/Http/Controllers/VerificaEvidenciaController.php:263`: `->select('act.nombre as act_nombre', 'act.por_cred_actividad as porcentaje',`
- `app/Http/Controllers/VerificaEvidenciaController.php:310`: `$reportes_data = DB::select('select alumnos.nombre,alumnos.status, alumnos.no_control, areas.nombre as carrera, if(avance.por_credito is null or avance.por_credito > 100, if( avance.por_credito > 100, 100, 0), avance.por_credito) as por_credito, creditos.nombre as nombre_credito from alumnos join cr`
- `app/Http/Controllers/VerificaEvidenciaController.php:313`: `$suma_creditos = DB::select('select if(sum(case when por_credito > 100 then 100 else por_credito end) is null,0,sum(case when por_credito > 100 then 100 else por_credito end)) as credito_suma,alumnos.id as alumno_id ,alumnos.nombre,alumnos.status, alumnos.no_control, areas.nombre as carrera, if(avan`
- `app/Http/Controllers/VerificaEvidenciaController.php:317`: `$reportes_data = DB::select('select alumnos.nombre,alumnos.status, alumnos.no_control, areas.nombre as carrera, if(avance.por_credito is null or avance.por_credito > 100, if( avance.por_credito > 100, 100, 0), avance.por_credito) as por_credito, creditos.nombre as nombre_credito from alumnos join cr`
- `app/Http/Controllers/VerificaEvidenciaController.php:320`: `$suma_creditos = DB::select('select if(sum(case when por_credito > 100 then 100 else por_credito end) is null,0,sum(case when por_credito > 100 then 100 else por_credito end)) as credito_suma,alumnos.id as alumno_id ,alumnos.nombre,alumnos.status, alumnos.no_control, areas.nombre as carrera, if(avan`
- `app/Http/Controllers/VerificaEvidenciaController.php:340`: `$reportes_data = DB::select('select alumnos.nombre,alumnos.status, alumnos.no_control, areas.nombre as carrera, if(avance.por_credito is null or avance.por_credito > 100, if( avance.por_credito > 100, 100, 0), avance.por_credito) as por_credito, creditos.nombre as nombre_credito from alumnos join cr`
- `app/Http/Controllers/VerificaEvidenciaController.php:342`: `$suma_creditos = DB::select('select if(sum(case when por_credito > 100 then 100 else por_credito end) is null,0,sum(case when por_credito > 100 then 100 else por_credito end)) as credito_suma,alumnos.id as alumno_id ,alumnos.nombre, alumnos.status, alumnos.no_control, areas.nombre as carrera, if(ava`
- `app/Http/Controllers/VerificaEvidenciaController.php:346`: `$reportes_data = DB::select('select alumnos.nombre,alumnos.status, alumnos.no_control, areas.nombre as carrera, if(avance.por_credito is null or avance.por_credito > 100, if( avance.por_credito > 100, 100, 0), avance.por_credito) as por_credito, creditos.nombre as nombre_credito from alumnos join cr`
- ... 17 referencias adicionales
### `nombre_i`
- `app/Models/Alumno.php:19`: `protected $fillable=['no_control','password','nombre','carrera','status','foto','observaciones','email','ficha','nombre_i','a_pat','a_mat','creditos','fec_nac','lug_pro','curp','sexo','est_civ','tel','tel_emer','beca','grupo','nom_ficha','generacion'];`
### `observaciones_med`
- `app/Http/Controllers/SistemaMedicoController.php:94`: `$dat_medicos=Alumno::where('id',$paciente->id)->first(['sem_med', 'observaciones_med']);`
- `app/Http/Controllers/SistemaMedicoController.php:107`: `$alumno->observaciones_med = $alumno->observaciones_med + $request->input('observaciones_med');`
### `observaciones_psic`
- Sin referencias detectadas.
### `password`
- `app/Exceptions/Handler.php:30`: `'password',`
- `app/Http/Controllers/altaAlumnosController.php:44`: `'password' => bcrypt($row[2]),`
- `app/Http/Controllers/AlumnosController.php:87`: `$alumno->password=bcrypt($request->password);`
- `app/Http/Controllers/AlumnosController.php:133`: `if($alumno->password!=$request->password)`
- `app/Http/Controllers/AlumnosController.php:135`: `if($request->password==$request->passwordV)`
- `app/Http/Controllers/AlumnosController.php:137`: `$alumno->password= bcrypt($request->password);`
- `app/Http/Controllers/AlumnosController.php:177`: `$selectColumns = ['alu.nombre','alu.no_control','alu.foto','alu.id as alumno_id','alu.password','a.nombre as carrera'];`
- `app/Http/Controllers/AlumnosController.php:235`: `if($request->txtPassword!=$alumno->password)`
- `app/Http/Controllers/AlumnosController.php:239`: `$alumno->password=bcrypt($request->txtPassword);`
- `app/Http/Controllers/AlumnosLoginController.php:52`: `$credentials = $request->only('email', 'password');`
- `app/Http/Controllers/Auth/ForgotPasswordController.php:15`: `| This controller is responsible for handling password reset emails and`
- `app/Http/Controllers/Auth/LoginController.php:101`: `if (\Auth::guard('alumno')->attempt(['email' => $request->email, 'password' => $request->password])) {`
- `app/Http/Controllers/Auth/RegisterController.php:54`: `'password' => 'required|string|min:8|confirmed',`
- `app/Http/Controllers/Auth/RegisterController.php:72`: `'password' => bcrypt($data['password']),`
- `app/Http/Controllers/Auth/ResetPasswordController.php:15`: `| This controller is responsible for handling password reset requests`
- `app/Http/Controllers/Auth/ResetPasswordController.php:24`: `* Where to redirect users after resetting their password.`
- `app/Http/Controllers/ExcelController.php:51`: `->update(['password' => bcrypt($row[2])]);`
- `app/Http/Controllers/PerfilController.php:120`: `$user->password=bcrypt($request->newPass);`
- `app/Http/Controllers/PerfilController.php:129`: `//Función que obtiene el usuario que desea cambiar su password`
- `app/Http/Controllers/PerfilController.php:141`: `if(!Hash::check($request->old_password, Auth::User()->password)){`
- `app/Http/Controllers/PerfilController.php:146`: `$user->password = bcrypt($request->new_password);`
- `app/Http/Controllers/UsersController.php:99`: `$user->password = bcrypt($request->password);`
- `app/Http/Controllers/UsersController.php:153`: `if($user->password!=$request->password) {`
- `app/Http/Controllers/UsersController.php:154`: `if($request->password==$request->password_confirmation)`
- `app/Http/Controllers/UsersController.php:156`: `$user->password=bcrypt($request->password);`
- `app/Http/Middleware/TrimStrings.php:15`: `'password',`
- `app/Http/Requests/UserRequest.php:31`: `'password' => 'required|min:4|max:60',`
- `app/Http/Requests/UserRequest.php:32`: `'password_confirmation' => 'required_with:password|same:password|min:4|max:60|required'`
- `app/Imports/AlumnosAgregar.php:22`: `'password' => bcrypt($row[4]),`
- `app/Imports/AlumnosImport.php:24`: `'password' => bcrypt($row[3]),`
- `app/Mail/mail_res_pass.php:33`: `subject: 'Restablecimiento de password CREDITSCH',`
- `app/Models/Alumno.php:19`: `protected $fillable=['no_control','password','nombre','carrera','status','foto','observaciones','email','ficha','nombre_i','a_pat','a_mat','creditos','fec_nac','lug_pro','curp','sexo','est_civ','tel','tel_emer','beca','grupo','nom_ficha','generacion'];`
- `app/User.php:22`: `'name', 'email', 'password','area','active','tutor'`
- `app/User.php:31`: `'password', 'remember_token',`
### `remember_token`
- `app/User.php:31`: `'password', 'remember_token',`
### `sem_med`
- `app/Http/Controllers/SistemaMedicoController.php:94`: `$dat_medicos=Alumno::where('id',$paciente->id)->first(['sem_med', 'observaciones_med']);`
- `app/Http/Controllers/SistemaMedicoController.php:106`: `$alumno->sem_med = $request->input('semaforo');`
### `sem_psic`
- Sin referencias detectadas.
### `sexo`
- `app/Models/Alumno.php:19`: `protected $fillable=['no_control','password','nombre','carrera','status','foto','observaciones','email','ficha','nombre_i','a_pat','a_mat','creditos','fec_nac','lug_pro','curp','sexo','est_civ','tel','tel_emer','beca','grupo','nom_ficha','generacion'];`
### `tel`
- `app/Http/Controllers/AlumnosStaController.php:92`: `$alu->tel = $request->tel;`
- `app/Http/Controllers/AlumnosStaController.php:100`: `$dPad->tel = $request->TelPa;`
- `app/Http/Controllers/AlumnosStaController.php:111`: `$dMad->tel = $request->TelMa;`
- `app/Models/Alumno.php:19`: `protected $fillable=['no_control','password','nombre','carrera','status','foto','observaciones','email','ficha','nombre_i','a_pat','a_mat','creditos','fec_nac','lug_pro','curp','sexo','est_civ','tel','tel_emer','beca','grupo','nom_ficha','generacion'];`
### `tel_emer`
- `app/Models/Alumno.php:19`: `protected $fillable=['no_control','password','nombre','carrera','status','foto','observaciones','email','ficha','nombre_i','a_pat','a_mat','creditos','fec_nac','lug_pro','curp','sexo','est_civ','tel','tel_emer','beca','grupo','nom_ficha','generacion'];`

## 6. Tablas de `creditos.sql` sin equivalente en `sit.sql`
### `actividad`
- Volumen estimado: Sin AUTO_INCREMENT; volumen no estimable
- FK: `id_actividad->creditos, id_user->users`
- FK directa a alumnos: `No`
- Recomendacion preliminar: Mantener temporalmente; validar equivalencia funcional

### `actividad_evidencia`
- Volumen estimado: Sin AUTO_INCREMENT; volumen no estimable
- FK: `actividad_id->actividad, user_id->users, validador_id->users`
- FK directa a alumnos: `No`
- Recomendacion preliminar: Mantener temporalmente; validar equivalencia funcional

### `areas`
- Volumen estimado: Sin AUTO_INCREMENT; volumen no estimable
- FK: `-`
- FK directa a alumnos: `No`
- Recomendacion preliminar: Mantener temporalmente; validar equivalencia funcional

### `asignaciones_tutores`
- Volumen estimado: Sin AUTO_INCREMENT; volumen no estimable
- FK: `gpo_Id->grupos`
- FK directa a alumnos: `No`
- Recomendacion preliminar: Mantener temporalmente; validar equivalencia funcional

### `avance`
- Volumen estimado: Sin AUTO_INCREMENT; volumen no estimable
- FK: `id_credito->creditos, no_control->alumnos`
- FK directa a alumnos: `Si`
- Recomendacion preliminar: Migrar; existe relacion funcional con alumnos

### `citas`
- Volumen estimado: Sin AUTO_INCREMENT; volumen no estimable
- FK: `medico_id->users, paciente_id->pacientes`
- FK directa a alumnos: `No`
- Recomendacion preliminar: Mantener temporalmente; validar equivalencia funcional

### `constancia`
- Volumen estimado: Sin AUTO_INCREMENT; volumen no estimable
- FK: `carrera->areas, jefe_division->users`
- FK directa a alumnos: `No`
- Recomendacion preliminar: Mantener temporalmente; validar equivalencia funcional

### `constancia_complemento`
- Volumen estimado: Sin AUTO_INCREMENT; volumen no estimable
- FK: `certificador->users, jefe_depto->users`
- FK directa a alumnos: `No`
- Recomendacion preliminar: Mantener temporalmente; validar equivalencia funcional

### `constancia_folios`
- Volumen estimado: Sin AUTO_INCREMENT; volumen no estimable
- FK: `no_control->alumnos`
- FK directa a alumnos: `Si`
- Recomendacion preliminar: Migrar; existe relacion funcional con alumnos

### `creditos`
- Volumen estimado: Sin AUTO_INCREMENT; volumen no estimable
- FK: `credito_jefe->users`
- FK directa a alumnos: `No`
- Recomendacion preliminar: Mantener temporalmente; validar equivalencia funcional

### `creditos_areas`
- Volumen estimado: Sin AUTO_INCREMENT; volumen no estimable
- FK: `-`
- FK directa a alumnos: `No`
- Recomendacion preliminar: Mantener temporalmente; validar equivalencia funcional

### `datos_familiares`
- Volumen estimado: Sin AUTO_INCREMENT; volumen no estimable
- FK: `id_alu->alumnos`
- FK directa a alumnos: `Si`
- Recomendacion preliminar: Migrar; existe relacion funcional con alumnos

### `direcciones`
- Volumen estimado: Sin AUTO_INCREMENT; volumen no estimable
- FK: `-`
- FK directa a alumnos: `No`
- Recomendacion preliminar: Mantener temporalmente; validar equivalencia funcional

### `evidencia`
- Volumen estimado: Sin AUTO_INCREMENT; volumen no estimable
- FK: `alumno_no_control->alumnos, id_asig_actividades->actividad_evidencia`
- FK directa a alumnos: `Si`
- Recomendacion preliminar: Migrar; existe relacion funcional con alumnos

### `familiares`
- Volumen estimado: Sin AUTO_INCREMENT; volumen no estimable
- FK: `id_alu->alumnos`
- FK directa a alumnos: `Si`
- Recomendacion preliminar: Migrar; existe relacion funcional con alumnos

### `gpo_tutorias`
- Volumen estimado: Sin AUTO_INCREMENT; volumen no estimable
- FK: `-`
- FK directa a alumnos: `No`
- Recomendacion preliminar: Migrar; existe relacion funcional con alumnos

### `historiales_clinicos`
- Volumen estimado: Sin AUTO_INCREMENT; volumen no estimable
- FK: `id_alu->alumnos`
- FK directa a alumnos: `Si`
- Recomendacion preliminar: Migrar; existe relacion funcional con alumnos

### `historiales_medicos`
- Volumen estimado: Sin AUTO_INCREMENT; volumen no estimable
- FK: `cita_id->citas, paciente_id->pacientes`
- FK directa a alumnos: `No`
- Recomendacion preliminar: Migrar; existe relacion funcional con alumnos

### `horario_medicos`
- Volumen estimado: Sin AUTO_INCREMENT; volumen no estimable
- FK: `-`
- FK directa a alumnos: `No`
- Recomendacion preliminar: Mantener temporalmente; validar equivalencia funcional

### `mensajes`
- Volumen estimado: Sin AUTO_INCREMENT; volumen no estimable
- FK: `creador_id->users`
- FK directa a alumnos: `No`
- Recomendacion preliminar: Mantener temporalmente; validar equivalencia funcional

### `motivosreprobacion`
- Volumen estimado: Sin AUTO_INCREMENT; volumen no estimable
- FK: `-`
- FK directa a alumnos: `No`
- Recomendacion preliminar: Mantener temporalmente; validar equivalencia funcional

### `pacientes`
- Volumen estimado: Sin AUTO_INCREMENT; volumen no estimable
- FK: `-`
- FK directa a alumnos: `No`
- Recomendacion preliminar: Mantener temporalmente; validar equivalencia funcional

### `padres`
- Volumen estimado: Sin AUTO_INCREMENT; volumen no estimable
- FK: `id_alu->alumnos`
- FK directa a alumnos: `Si`
- Recomendacion preliminar: Migrar; existe relacion funcional con alumnos

### `participantes`
- Volumen estimado: Sin AUTO_INCREMENT; volumen no estimable
- FK: `id_evidencia->actividad_evidencia, no_control->alumnos`
- FK directa a alumnos: `Si`
- Recomendacion preliminar: Migrar; existe relacion funcional con alumnos

### `password_resets`
- Volumen estimado: Sin AUTO_INCREMENT; volumen no estimable
- FK: `-`
- FK directa a alumnos: `No`
- Recomendacion preliminar: Deprecer o recrear segun framework

### `personales`
- Volumen estimado: Sin AUTO_INCREMENT; volumen no estimable
- FK: `id_alu->alumnos`
- FK directa a alumnos: `Si`
- Recomendacion preliminar: Migrar; existe relacion funcional con alumnos

### `receptores`
- Volumen estimado: Sin AUTO_INCREMENT; volumen no estimable
- FK: `mensaje_id->mensajes, user_id->users`
- FK directa a alumnos: `No`
- Recomendacion preliminar: Mantener temporalmente; validar equivalencia funcional

### `social`
- Volumen estimado: Sin AUTO_INCREMENT; volumen no estimable
- FK: `id_alu->alumnos`
- FK directa a alumnos: `Si`
- Recomendacion preliminar: Migrar; existe relacion funcional con alumnos

