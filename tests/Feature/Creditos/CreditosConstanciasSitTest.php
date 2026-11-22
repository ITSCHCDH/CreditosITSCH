<?php

use App\Http\Controllers\AlumnosRutasController;
use App\Http\Controllers\ConstanciasController;
use App\Http\Controllers\VerificaEvidenciaController;
use App\Models\AlumnoCreditosPerfil;
use App\Models\Avance;
use App\Services\Creditos\AvanceCreditosService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

    Schema::connection('creditos')->create('avance', function (Blueprint $table) {
        $table->id();
        $table->string('no_control', 20);
        $table->unsignedInteger('id_credito');
        $table->integer('por_credito');
        $table->timestamps();
    });
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
    Schema::connection('creditos')->create('creditos', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
    });

    Schema::connection('sit')->create('users', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->string('apellido_paterno')->nullable();
        $table->string('apellido_materno')->nullable();
    });
    Schema::connection('sit')->create('cat_carreras', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
    });
    Schema::connection('sit')->create('alumnos', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->string('no_control', 20)->unique();
        $table->unsignedBigInteger('carrera_id');
        $table->integer('anio_ingreso')->nullable();
        $table->string('estatus')->default('Regular');
    });

    DB::connection('sit')->table('users')->insert([
        'id' => 1, 'nombre' => 'Ana', 'apellido_paterno' => 'Lopez', 'apellido_materno' => 'Soto',
    ]);
    DB::connection('sit')->table('cat_carreras')->insert(['id' => 10, 'nombre' => 'Ingeniería en Sistemas Computacionales']);
    DB::connection('sit')->table('alumnos')->insert([
        'id' => 100, 'user_id' => 1, 'no_control' => 'S23001',
        'carrera_id' => 10, 'anio_ingreso' => 2023, 'estatus' => 'Regular',
    ]);
});

it('sincroniza liberado sin escribir en sit', function () {
    foreach (range(1, 5) as $id) {
        Avance::create(['no_control' => 'S23001', 'id_credito' => $id, 'por_credito' => 100]);
    }

    $perfil = app(AvanceCreditosService::class)->sincronizar('S23001');

    expect($perfil->estatus_creditos)->toBe('Liberado')
        ->and(AlumnoCreditosPerfil::where('no_control', 'S23001')->value('estatus_creditos'))->toBe('Liberado')
        ->and(DB::connection('sit')->table('alumnos')->where('no_control', 'S23001')->count())->toBe(1);

    DB::table('avance')->where('no_control', 'S23001')->update(['por_credito' => 90]);
    $perfil = app(AvanceCreditosService::class)->sincronizar('S23001');
    expect($perfil->estatus_creditos)->toBe('pendiente');
});

it('busca por nombre o no_control en alumnosBusqueda', function () {
    $admin = Mockery::mock();
    $admin->shouldReceive('hasAnyPermission')->andReturn(true);
    Auth::shouldReceive('User')->andReturn($admin);

    $response = app(VerificaEvidenciaController::class)->alumnosBusqueda(
        new Illuminate\Http\Request(['peticion' => 2, 'nombre' => 'Ana'])
    );

    expect($response->getStatusCode())->toBe(200)
        ->and($response->getData(true)[0]['no_control'])->toBe('S23001');
});

it('consulta avance y bloquea constancia cuando el alumno no existe en sit', function () {
    foreach (range(1, 5) as $id) {
        Avance::create(['no_control' => 'S23001', 'id_credito' => $id, 'por_credito' => 100]);
    }

    expect(app(AvanceCreditosService::class)->estaLiberado('S23001'))->toBeTrue();

    $response = app(ConstanciasController::class)->imprimir(
        new Illuminate\Http\Request(['no_control' => 'NO-EXISTE'])
    );

    expect($response->getStatusCode())->toBe(302);
});
