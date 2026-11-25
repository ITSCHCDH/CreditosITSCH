<?php

use App\Models\Sit\Alumno;
use App\Models\Sit\ResidenciaAlumno;
use App\Models\Sit\ServicioSocialAlumno;
use App\Services\Sit\TrayectoriaAcademicaService;
use App\Http\Controllers\GruposController;
use App\Models\Grupo;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

beforeEach(function () {
    config()->set('database.connections.creditos', [
        'driver' => 'sqlite',
        'database' => ':memory:',
        'prefix' => '',
        'foreign_key_constraints' => true,
    ]);
    config()->set('database.connections.sit', [
        'driver' => 'sqlite',
        'database' => ':memory:',
        'prefix' => '',
        'foreign_key_constraints' => true,
    ]);
    DB::purge('creditos');
    DB::purge('sit');
    DB::setDefaultConnection('creditos');

    Schema::connection('creditos')->create('grupos', function (Blueprint $table) {
        $table->id();
        $table->string('gpo_Nombre');
        $table->unsignedBigInteger('id_Carrera')->nullable();
        $table->string('gpo_Semestre')->nullable();
        $table->integer('gpo_Status')->default(0);
    });
    Schema::connection('creditos')->create('asignaciones_tutores', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('gpo_Id');
        $table->unsignedBigInteger('tut_Clave');
        $table->unsignedBigInteger('car_Clave');
        $table->string('gtu_Tipo')->nullable();
        $table->string('gtu_Semestre')->nullable();
        $table->integer('gtu_Año')->nullable();
        $table->timestamps();
    });

    Schema::connection('sit')->create('alumnos', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id')->nullable();
        $table->string('no_control', 20)->unique();
        $table->unsignedBigInteger('carrera_id')->nullable();
        $table->unsignedBigInteger('plan_estudio_id')->nullable();
        $table->year('anio_ingreso')->nullable();
        $table->string('estatus')->default('Regular');
        $table->integer('semestre_actual')->nullable();
    });
    Schema::connection('sit')->create('cat_plan_estudios', function (Blueprint $table) {
        $table->id();
        $table->integer('creditos_totales')->default(260);
    });
    Schema::connection('sit')->create('kardex', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('alumno_id');
        $table->unsignedBigInteger('materia_id')->nullable();
        $table->unsignedBigInteger('periodo_id')->nullable();
        $table->integer('semestre')->default(1);
        $table->integer('opcion_acreditacion_numerico')->nullable();
        $table->boolean('acreditada')->default(false);
        $table->integer('creditos_materia')->default(0);
    });
    Schema::connection('sit')->create('servicio_social_alumnos', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('alumno_id');
        $table->string('estatus')->default('no_iniciado');
        $table->string('constancia_estatus')->nullable();
    });
    Schema::connection('sit')->create('residencia_alumnos', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('alumno_id');
        $table->string('estatus')->default('solicitado');
    });
    Schema::connection('sit')->create('listas', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('alumno_id');
        $table->unsignedBigInteger('grupo_id');
        $table->unsignedBigInteger('catedratico_id')->nullable();
    });
    Schema::connection('sit')->create('grupos', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('materia_id')->nullable();
    });
    Schema::connection('sit')->create('cat_materias', function (Blueprint $table) {
        $table->id();
        $table->string('nombre')->nullable();
        $table->integer('num_temas')->nullable();
    });
    Schema::connection('sit')->create('catedraticos', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id')->nullable();
        $table->string('numero_empleado')->nullable();
        $table->string('departamento_adscripcion')->nullable();
        $table->boolean('activo')->default(true);
    });
    Schema::connection('sit')->create('users', function (Blueprint $table) {
        $table->id();
        $table->string('nombre')->nullable();
        $table->string('apellido_paterno')->nullable();
        $table->string('apellido_materno')->nullable();
    });
    Schema::connection('sit')->create('cat_carreras', function (Blueprint $table) {
        $table->id();
        $table->string('nombre')->nullable();
        $table->string('nombre_corto')->nullable();
        $table->boolean('activo')->default(true);
    });
    Schema::connection('sit')->create('lista_unidades', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('lista_id');
        $table->integer('numero_unidad')->nullable();
        $table->integer('oportunidad')->nullable();
        $table->decimal('calificacion', 5, 2)->nullable();
        $table->integer('corte')->nullable();
    });

    DB::connection('sit')->table('cat_plan_estudios')->insert(['id' => 10, 'creditos_totales' => 260]);
    DB::connection('sit')->table('users')->insert([
        'id' => 1,
        'nombre' => 'Ana',
        'apellido_paterno' => 'López',
        'apellido_materno' => 'Soto',
    ]);
    DB::connection('sit')->table('alumnos')->insert([
        'id' => 100,
        'no_control' => 'S26001',
        'plan_estudio_id' => 10,
        'anio_ingreso' => 2026,
        'estatus' => 'Regular',
        'semestre_actual' => 8,
    ]);
    DB::connection('sit')->table('kardex')->insert([
        'id' => 1,
        'alumno_id' => 100,
        'opcion_acreditacion_numerico' => 1,
        'acreditada' => true,
        'creditos_materia' => 52,
    ]);
    DB::connection('sit')->table('catedraticos')->insert([
        'id' => 3,
        'user_id' => 1,
        'numero_empleado' => 'CAT-001',
        'departamento_adscripcion' => 'Sistemas',
        'activo' => true,
    ]);
    DB::connection('sit')->table('cat_carreras')->insert([
        'id' => 10,
        'nombre' => 'Ingeniería en Sistemas Computacionales',
        'nombre_corto' => 'ISC',
        'activo' => true,
    ]);
    DB::connection('creditos')->table('grupos')->insert([
        'id' => 1,
        'gpo_Nombre' => '7A',
        'id_Carrera' => 10,
        'gpo_Semestre' => 'Ago-Dic',
        'gpo_Status' => 1,
    ]);
    DB::connection('creditos')->table('asignaciones_tutores')->insert([
        'id' => 1,
        'gpo_Id' => 1,
        'tut_Clave' => 3,
        'car_Clave' => 10,
        'gtu_Tipo' => 'Permanencia',
        'gtu_Semestre' => 'Ago-Dic',
        'gtu_Año' => 2026,
    ]);
});

it('calcula la trayectoria desde el servicio SIT sin modelos legacy', function () {
    $alumno = Alumno::where('no_control', 'S26001')->firstOrFail();
    $servicio = app(TrayectoriaAcademicaService::class);

    expect($servicio->creditos($alumno))
        ->toMatchArray(['acumulados' => 52, 'totales' => 260, 'porcentaje' => 20])
        ->and($servicio->generaciones()->values()->all())->toBe([2026])
        ->and($servicio->materiasUnidades($alumno))->toBeEmpty()
        ->and($servicio->residencia($alumno)['estatus'])->toBe('sin_registro');

    DB::connection('sit')->table('servicio_social_alumnos')->insert([
        'alumno_id' => 100,
        'estatus' => 'liberado',
        'constancia_estatus' => 'aprobada',
    ]);
    DB::connection('sit')->table('residencia_alumnos')->insert([
        'alumno_id' => 100,
        'estatus' => 'liberado',
    ]);

    $alumno = $alumno->fresh(['servicioSocial', 'residencia']);
    expect($servicio->servicioSocial($alumno)['liberado'])->toBeTrue()
        ->and($servicio->residencia($alumno)['liberada'])->toBeTrue()
        ->and($servicio->semaforos($alumno))->toHaveKeys([
            'semaforoAcad',
            'semaforoPsico',
            'semaforoMedico',
            'semaforoServicio',
        ]);

    expect(new ServicioSocialAlumno())->toBeInstanceOf(ServicioSocialAlumno::class)
        ->and(new ResidenciaAlumno())->toBeInstanceOf(ResidenciaAlumno::class);
});

it('mantiene disponibles las rutas STA principales', function () {
    expect(Route::has('analisis.index'))->toBeTrue()
        ->and(Route::has('profesores.index'))->toBeTrue()
        ->and(Route::has('tutorias.index'))->toBeTrue()
        ->and(Route::has('alumnos.sta.ficha'))->toBeTrue()
        ->and(Route::has('analisis.alumno'))->toBeTrue()
        ->and(Route::has('analisis.ficha'))->toBeTrue()
        ->and(Route::has('analisis.ficha.familiares.guardar'))->toBeTrue()
        ->and(Route::has('analisis.ficha.social.guardar'))->toBeTrue()
        ->and(Route::has('tutorias.catedraticos.busqueda'))->toBeTrue()
        ->and(Route::has('tutorias.updateGrupo'))->toBeTrue()
        ->and(Route::has('tutorias.deleteGrupo'))->toBeTrue()
        ->and(Route::has('tutorias.destroy'))->toBeTrue()
        ->and(Route::has('tutorias.asigTutPDF'))->toBeTrue()
        ->and(Route::has('tutorias.libTutPDF'))->toBeTrue()
        ->and(Route::has('tutorias.deleteAllGrupos'))->toBeTrue();
});

it('busca todos los catedraticos activos de SIT para tutorias', function () {
    $admin = Mockery::mock();
    $admin->shouldReceive('hasAnyPermission')->andReturn(true);
    Illuminate\Support\Facades\Auth::shouldReceive('User')->andReturn($admin);

    $response = app(App\Http\Controllers\STAController::class)->buscarCatedraticosTutorias(
        new Illuminate\Http\Request(['nombre' => 'Ana'])
    );

    expect($response->getStatusCode())->toBe(200)
        ->and($response->getData(true)[0]['cat_Clave'])->toBe(3)
        ->and($response->getData(true)[0]['nombre_completo'])->toContain('Ana');
});

it('genera la constancia PDF de asignacion con datos SIT', function () {
    $response = app(GruposController::class)->asigTutPDF(1);

    expect($response->getStatusCode())->toBe(200)
        ->and($response->headers->get('content-type'))->toContain('application/pdf');
});

it('elimina un grupo por la ruta de accion sin dejarlo registrado', function () {
    expect(Grupo::count())->toBe(1);

    $response = app(GruposController::class)->deleteGrupo(1);

    expect($response->getStatusCode())->toBe(302)
        ->and(Grupo::count())->toBe(0);
});

it('elimina todos los grupos y sus asignaciones mediante la accion masiva', function () {
    DB::connection('creditos')->table('grupos')->insert([
        'id' => 2,
        'gpo_Nombre' => '8A',
        'id_Carrera' => 10,
        'gpo_Semestre' => 'Ago-Dic',
        'gpo_Status' => 0,
    ]);
    DB::connection('creditos')->table('asignaciones_tutores')->insert([
        'id' => 2,
        'gpo_Id' => 2,
        'tut_Clave' => 3,
        'car_Clave' => 10,
        'gtu_Tipo' => 'Ingreso',
        'gtu_Semestre' => 'Ago-Dic',
        'gtu_Año' => 2026,
    ]);

    $response = app(GruposController::class)->deleteAllGrupos();

    expect($response->getStatusCode())->toBe(302)
        ->and(Grupo::count())->toBe(0)
        ->and(DB::table('asignaciones_tutores')->count())->toBe(0);
});
