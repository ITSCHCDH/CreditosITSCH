<?php

use App\Http\Controllers\AlumnosStaController;
use App\Http\Controllers\JefesController;
use App\Http\Controllers\SistemaMedicoController;
use App\Models\AlumnoCreditosPerfil;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

beforeEach(function () {
    config()->set('database.connections.creditos', [
        'driver' => 'sqlite', 'database' => ':memory:', 'prefix' => '', 'foreign_key_constraints' => true,
    ]);
    config()->set('database.connections.sit', [
        'driver' => 'sqlite', 'database' => ':memory:', 'prefix' => '', 'foreign_key_constraints' => true,
    ]);
    DB::purge('creditos');
    DB::purge('sit');
    DB::setDefaultConnection('creditos');

    Schema::connection('creditos')->create('alumno_creditos_perfil', function (Blueprint $table) {
        $table->id();
        $table->string('no_control', 20)->unique();
        $table->string('estatus_creditos', 35)->default('pendiente');
        $table->boolean('ficha_completada')->default(false);
        $table->string('foto', 100)->nullable();
        $table->text('observaciones_tutoria')->nullable();
        $table->integer('sem_med')->nullable();
        $table->text('observaciones_med')->nullable();
        $table->integer('sem_psic')->nullable();
        $table->text('observaciones_psic')->nullable();
        $table->timestamps();
    });
    Schema::connection('creditos')->create('citas', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('paciente_id');
        $table->string('estado_cita')->nullable();
    });
    Schema::connection('creditos')->create('pacientes', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->string('no_control', 20)->nullable();
        $table->string('tipo')->nullable();
    });

    Schema::connection('sit')->create('users', function (Blueprint $table) {
        $table->id();
        $table->string('nombre')->nullable();
        $table->string('apellido_paterno')->nullable();
        $table->string('apellido_materno')->nullable();
        $table->string('name')->nullable();
    });
    Schema::connection('sit')->create('cat_carreras', function (Blueprint $table) {
        $table->id();
        $table->string('nombre')->nullable();
        $table->string('nombre_corto')->nullable();
    });
    Schema::connection('sit')->create('alumnos', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->string('no_control', 20)->unique();
        $table->unsignedBigInteger('carrera_id');
        $table->string('estatus')->default('Regular');
        $table->integer('semestre_actual')->nullable();
    });

    DB::connection('sit')->table('users')->insert(['id' => 1, 'nombre' => 'Ana', 'apellido_paterno' => 'Lopez', 'apellido_materno' => 'Soto']);
    DB::connection('sit')->table('cat_carreras')->insert(['id' => 10, 'nombre' => 'Sistemas', 'nombre_corto' => 'ISC']);
    DB::connection('sit')->table('alumnos')->insert([
        'id' => 100, 'user_id' => 1, 'no_control' => 'S23001', 'carrera_id' => 10,
    ]);
});

it('autoriza la ficha y guarda observaciones de tutoría por no_control', function () {
    $response = app(AlumnosStaController::class)->autorizar('S23001');
    expect((bool) AlumnoCreditosPerfil::where('no_control', 'S23001')->value('ficha_completada'))->toBeTrue();

    $jefes = app(JefesController::class);
    $json = $jefes->storeAlumnoObs(Request::create('/', 'POST', [
        'no_Control' => 'S23001',
        'observaciones' => 'Seguimiento individual',
    ]))->getData(true);
    expect($json['status'])->toBe(200)
        ->and(AlumnoCreditosPerfil::where('no_control', 'S23001')->value('observaciones_tutoria'))
        ->toBe('Seguimiento individual');

    expect($response->isRedirect())->toBeTrue();
});

it('guarda semáforo médico y anexar observaciones sin sumarlas', function () {
    DB::connection('creditos')->table('pacientes')->insert([
        'id' => 1, 'user_id' => 1, 'no_control' => 'S23001', 'tipo' => 'Alumno',
    ]);
    DB::connection('creditos')->table('citas')->insert([
        'id' => 1, 'paciente_id' => 1, 'estado_cita' => 'Pendiente',
    ]);
    AlumnoCreditosPerfil::create([
        'no_control' => 'S23001',
        'sem_med' => 2,
        'observaciones_med' => 'Observación previa',
    ]);

    app(SistemaMedicoController::class)->guardarSemaforo(1, Request::create('/', 'POST', [
        'semaforo' => 3,
        'observaciones_med' => 'Nueva observación',
    ]));

    $perfil = AlumnoCreditosPerfil::where('no_control', 'S23001')->first();
    expect($perfil->sem_med)->toBe(3)
        ->and($perfil->observaciones_med)->toBe("Observación previa\nNueva observación");
});
