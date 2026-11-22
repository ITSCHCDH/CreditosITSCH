<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

beforeEach(function () {
    config()->set('database.default', 'creditos');
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

    Schema::connection('creditos')->create('alumnos', function (Blueprint $table) {
        $table->increments('id');
        $table->string('no_control', 20);
        $table->string('status', 35);
        $table->integer('ficha')->nullable();
        $table->string('foto', 100)->nullable();
        $table->text('observaciones')->nullable();
        $table->integer('sem_med')->nullable();
        $table->text('observaciones_med')->nullable();
        $table->integer('sem_psic')->nullable();
        $table->text('observaciones_psic')->nullable();
    });

    foreach (['familiares', 'padres', 'historiales_clinicos', 'datos_familiares', 'personales', 'social'] as $table) {
        Schema::connection('creditos')->create($table, function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->unsignedInteger('id_alu')->nullable();
        });
    }

    Schema::connection('creditos')->create('pacientes', function (Blueprint $table) {
        $table->id();
        $table->unsignedInteger('user_id');
        $table->string('tipo')->nullable();
    });

    $this->artisan('migrate', [
        '--database' => 'creditos',
        '--path' => 'database/migrations/2026_11_22_130000_create_alumno_creditos_perfil_and_no_control_bridge.php',
    ])->assertExitCode(0);
});

it('migra el perfil satélite y propaga el número de control de forma idempotente', function () {
    DB::connection('creditos')->table('alumnos')->insert([
        'id' => 41,
        'no_control' => 'G23030330',
        'status' => 'liberado',
        'ficha' => 1,
        'foto' => 'foto_G23030330.jpg',
        'observaciones' => 'Seguimiento de tutoría',
        'sem_med' => 4,
        'observaciones_med' => 'Sin observaciones',
        'sem_psic' => 5,
        'observaciones_psic' => 'Atención concluida',
    ]);

    foreach (['familiares', 'padres', 'historiales_clinicos', 'datos_familiares', 'personales', 'social'] as $table) {
        DB::connection('creditos')->table($table)->insert(['id' => 10, 'id_alu' => 41]);
    }
    DB::connection('creditos')->table('pacientes')->insert([
        'id' => 12,
        'user_id' => 41,
        'tipo' => 'Alumno',
    ]);

    $this->artisan('creditos:migrar-datos-alumnos')->assertExitCode(0);
    $this->artisan('creditos:migrar-datos-alumnos')->assertExitCode(0);

    expect(Schema::connection('creditos')->hasTable('alumno_creditos_perfil'))->toBeTrue();
    $this->assertDatabaseHas('alumno_creditos_perfil', [
        'no_control' => 'G23030330',
        'estatus_creditos' => 'liberado',
        'ficha_completada' => 1,
        'foto' => 'foto_G23030330.jpg',
        'observaciones_tutoria' => 'Seguimiento de tutoría',
        'sem_med' => 4,
        'observaciones_med' => 'Sin observaciones',
        'sem_psic' => 5,
        'observaciones_psic' => 'Atención concluida',
    ], 'creditos');
    $this->assertDatabaseCount('alumno_creditos_perfil', 1, 'creditos');

    foreach (['familiares', 'padres', 'historiales_clinicos', 'datos_familiares', 'personales', 'social', 'pacientes'] as $table) {
        expect(Schema::connection('creditos')->hasColumn($table, 'no_control'))->toBeTrue();
        $this->assertDatabaseHas($table, ['no_control' => 'G23030330'], 'creditos');
    }
});

it('completa sin error cuando ya fue eliminada la tabla legacy de alumnos', function () {
    Schema::connection('creditos')->dropIfExists('alumnos');

    $this->artisan('creditos:migrar-datos-alumnos')->assertExitCode(0);
});

it('responde 404 en las rutas de alumnos e importaciones retiradas', function () {
    foreach ([
        '/admin/alumnos/create',
        '/admin/alumnos/Bajas/view',
        '/admin/alumnos/editarStatus',
        '/admin/alumnos/41/edit',
        '/admin/alumnos/41/destroy',
        '/Import',
        '/Import/altas',
        '/fileUploadPost',
    ] as $uri) {
        expect($this->get($uri)->getStatusCode(), $uri)->toBe(404);
    }

    $this->post('/admin/alumnos/store')->assertNotFound();
    $this->post('/admin/alumnos/41/update')->assertNotFound();
    $this->post('/Import')->assertNotFound();
    $this->post('/Import/alta')->assertNotFound();
    $this->post('/getmsg')->assertNotFound();
});
