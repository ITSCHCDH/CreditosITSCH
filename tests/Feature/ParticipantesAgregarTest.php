<?php

use App\Models\Participante;
use App\User;
use Illuminate\Database\Schema\Blueprint;
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

    Schema::connection('creditos')->create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
    });
    Schema::connection('creditos')->create('permissions', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('guard_name');
    });
    Schema::connection('creditos')->create('model_has_permissions', function (Blueprint $table) {
        $table->unsignedBigInteger('permission_id');
        $table->string('model_type');
        $table->unsignedBigInteger('model_id');
    });
    Schema::connection('creditos')->create('roles', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('guard_name');
    });
    Schema::connection('creditos')->create('role_has_permissions', function (Blueprint $table) {
        $table->unsignedBigInteger('permission_id');
        $table->unsignedBigInteger('role_id');
    });
    Schema::connection('creditos')->create('model_has_roles', function (Blueprint $table) {
        $table->unsignedBigInteger('role_id');
        $table->string('model_type');
        $table->unsignedBigInteger('model_id');
    });
    Schema::connection('creditos')->create('creditos', function (Blueprint $table) {
        $table->id();
        $table->string('vigente')->default('true');
    });
    Schema::connection('creditos')->create('actividad', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->integer('por_cred_actividad')->default(20);
        $table->unsignedBigInteger('id_actividad');
        $table->unsignedBigInteger('id_user');
        $table->string('alumnos')->default('false');
        $table->string('vigente')->default('true');
    });
    Schema::connection('creditos')->create('actividad_evidencia', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('actividad_id');
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('validador_id')->nullable();
        $table->string('validado')->default('false');
    });
    Schema::connection('creditos')->create('participantes', function (Blueprint $table) {
        $table->id();
        $table->string('no_control');
        $table->unsignedBigInteger('id_evidencia');
        $table->string('momento_agregado')->nullable();
        $table->string('evidencia_validada')->nullable();
        $table->timestamps();
    });
    Schema::connection('creditos')->create('avance', function (Blueprint $table) {
        $table->id();
        $table->string('no_control');
        $table->unsignedBigInteger('id_credito');
        $table->integer('por_credito')->default(0);
        $table->timestamps();
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
    });
    Schema::connection('sit')->create('alumnos', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->string('no_control')->unique();
        $table->unsignedBigInteger('carrera_id')->nullable();
    });

    DB::connection('creditos')->table('users')->insert(['id' => 7, 'name' => 'Responsable']);
    DB::connection('creditos')->table('permissions')->insert([
        'id' => 1,
        'name' => 'VIP',
        'guard_name' => 'web',
    ]);
    DB::connection('creditos')->table('roles')->insert([
        'id' => 1,
        'name' => 'VIP',
        'guard_name' => 'web',
    ]);
    DB::connection('creditos')->table('role_has_permissions')->insert([
        'permission_id' => 1,
        'role_id' => 1,
    ]);
    DB::connection('creditos')->table('model_has_roles')->insert([
        'role_id' => 1,
        'model_type' => User::class,
        'model_id' => 7,
    ]);
    DB::connection('creditos')->table('model_has_permissions')->insert([
        'permission_id' => 1,
        'model_type' => User::class,
        'model_id' => 7,
    ]);
    DB::connection('creditos')->table('creditos')->insert(['id' => 3, 'vigente' => 'true']);
    DB::connection('creditos')->table('actividad')->insert([
        'id' => 4,
        'nombre' => 'Actividad prueba',
        'por_cred_actividad' => 20,
        'id_actividad' => 3,
        'id_user' => 7,
        'alumnos' => 'false',
        'vigente' => 'true',
    ]);
    DB::connection('creditos')->table('actividad_evidencia')->insert([
        'id' => 8,
        'actividad_id' => 4,
        'user_id' => 7,
        'validador_id' => 7,
        'validado' => 'false',
    ]);

    DB::connection('sit')->table('users')->insert([
        'id' => 11,
        'nombre' => 'Ana',
        'apellido_paterno' => 'López',
        'apellido_materno' => 'Pérez',
    ]);
    DB::connection('sit')->table('cat_carreras')->insert(['id' => 5, 'nombre' => 'Sistemas']);
    DB::connection('sit')->table('alumnos')->insert([
        'id' => 20,
        'user_id' => 11,
        'no_control' => 'S23001',
        'carrera_id' => 5,
    ]);
});

it('agrega un alumno SIT a una actividad y rechaza duplicados', function () {
    $responsable = User::findOrFail(7);
    $this->actingAs($responsable);
    $this->withoutMiddleware();

    $this->postJson('/admin/participantes/guardar', [
        'no_control' => ' S23001 ',
        'id_responsable' => 7,
        'id_actividad' => 4,
    ])->assertOk()
        ->assertJsonPath('mensaje_tipo', 'Correcto');

    expect(Participante::where('no_control', 'S23001')->where('id_evidencia', 8)->exists())->toBeTrue();

    $this->postJson('/admin/participantes/guardar', [
        'no_control' => 'S23001',
        'id_responsable' => 7,
        'id_actividad' => 4,
    ])->assertOk()
        ->assertJsonPath('mensaje_tipo', 'Error');
});
