<?php

use App\Models\Sit\Alumno;
use App\Models\Sit\ResidenciaAlumno;
use App\Models\Sit\ServicioSocialAlumno;
use App\Services\Sit\TrayectoriaAcademicaService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

beforeEach(function () {
    config()->set('database.connections.sit', [
        'driver' => 'sqlite',
        'database' => ':memory:',
        'prefix' => '',
        'foreign_key_constraints' => true,
    ]);
    DB::purge('sit');

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
    });
    Schema::connection('sit')->create('users', function (Blueprint $table) {
        $table->id();
        $table->string('nombre')->nullable();
        $table->string('apellido_paterno')->nullable();
        $table->string('apellido_materno')->nullable();
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
        ->and(Route::has('analisis.ficha'))->toBeTrue();
});
