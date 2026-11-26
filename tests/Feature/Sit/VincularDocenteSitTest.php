<?php

use App\Models\Sit\Catedratico;
use App\Models\Sit\Grupo;
use App\Services\Sit\DocenteSitResolverService;
use App\User;
use Illuminate\Database\Schema\Blueprint;
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

    Schema::connection('creditos')->create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email');
        $table->string('password')->nullable();
        $table->string('active')->default('true');
        $table->string('tutor')->default('0');
        $table->unsignedBigInteger('area')->nullable();
        $table->unsignedBigInteger('sit_user_id')->nullable()->index();
        $table->unsignedBigInteger('sit_catedratico_id')->nullable()->index();
        $table->rememberToken();
        $table->timestamps();
    });

    Schema::connection('sit')->create('users', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->string('apellido_paterno')->nullable();
        $table->string('apellido_materno')->nullable();
        $table->string('email')->nullable();
        $table->boolean('activo')->default(true);
    });
    Schema::connection('sit')->create('catedraticos', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->string('numero_empleado');
        $table->boolean('activo')->default(true);
    });
    Schema::connection('sit')->create('cat_materias', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->integer('num_temas')->nullable();
        $table->boolean('activo')->default(true);
    });
    Schema::connection('sit')->create('cat_periodos_escolares', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->boolean('activo')->default(true);
        $table->date('fecha_inicio')->nullable();
        $table->date('fecha_fin')->nullable();
    });
    Schema::connection('sit')->create('grupos', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('periodo_id');
        $table->unsignedBigInteger('materia_id');
        $table->unsignedBigInteger('catedratico_id');
        $table->string('clave_grupo');
        $table->boolean('activo')->default(true);
    });
    Schema::connection('sit')->create('listas', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('grupo_id');
    });
});

it('vincula por correo sin distinguir mayúsculas y persiste ambos ids', function () {
    DB::connection('sit')->table('users')->insert([
        'id'=>10, 'nombre'=>'María', 'apellido_paterno'=>'Pérez', 'apellido_materno'=>'Luna',
        'email'=>'MARIA.PEREZ@ITCH.edu.mx', 'activo'=>1,
    ]);
    DB::connection('sit')->table('catedraticos')->insert([
        'id'=>20, 'user_id'=>10, 'numero_empleado'=>'EMP-20', 'activo'=>1,
    ]);

    $usuario = User::create(['name'=>'María Pérez Luna', 'email'=>'maria.perez@itch.edu.mx', 'password'=>'x']);
    $resuelto = app(DocenteSitResolverService::class)->resolverCatedratico($usuario);

    expect($resuelto?->id)->toBe(20)
        ->and($usuario->fresh()->sit_user_id)->toBe(10)
        ->and($usuario->fresh()->sit_catedratico_id)->toBe(20);
});

it('normaliza títulos y acepta coincidencia de nombre igual o superior a 82 porciento', function () {
    DB::connection('sit')->table('users')->insert([
        'id'=>11, 'nombre'=>'Carlos', 'apellido_paterno'=>'Ramírez', 'apellido_materno'=>'Soto',
        'email'=>'otro@itch.edu.mx', 'activo'=>1,
    ]);
    DB::connection('sit')->table('catedraticos')->insert([
        'id'=>21, 'user_id'=>11, 'numero_empleado'=>'EMP-21', 'activo'=>1,
    ]);

    $usuario = User::create(['name'=>'Ing. Carlos Ramirez Soto', 'email'=>'ninguno@itch.edu.mx', 'password'=>'x']);
    $resuelto = app(DocenteSitResolverService::class)->resolverCatedratico($usuario);

    expect($resuelto?->id)->toBe(21);
});

it('rechaza nombre distante y no persiste el vínculo', function () {
    DB::connection('sit')->table('users')->insert([
        'id'=>12, 'nombre'=>'Ana', 'apellido_paterno'=>'Martínez', 'email'=>'ana@itch.edu.mx', 'activo'=>1,
    ]);
    DB::connection('sit')->table('catedraticos')->insert([
        'id'=>22, 'user_id'=>12, 'numero_empleado'=>'EMP-22', 'activo'=>1,
    ]);

    $usuario = User::create(['name'=>'José completamente distinto', 'email'=>'no-match@itch.edu.mx', 'password'=>'x']);
    expect(app(DocenteSitResolverService::class)->resolverCatedratico($usuario))->toBeNull()
        ->and($usuario->fresh()->sit_catedratico_id)->toBeNull();
});

it('acepta nombres en orden invertido por apellidos', function () {
    DB::connection('sit')->table('users')->insert([
        'id'=>13, 'nombre'=>'Juan', 'apellido_paterno'=>'Pérez', 'apellido_materno'=>'López',
        'email'=>'juan-inverso@itch.edu.mx', 'activo'=>1,
    ]);
    DB::connection('sit')->table('catedraticos')->insert([
        'id'=>24, 'user_id'=>13, 'numero_empleado'=>'EMP-24', 'activo'=>1,
    ]);

    $usuario = User::create(['name'=>'Ing. Juan Pérez López', 'email'=>'sin-correo@itch.edu.mx', 'password'=>'x']);
    expect(app(DocenteSitResolverService::class)->resolverCatedratico($usuario)?->id)->toBe(24);
});

it('filtra grupos por catedrático activo y periodo activo o seleccionado', function () {
    DB::connection('sit')->table('users')->insert(['id'=>13,'nombre'=>'Laura','apellido_paterno'=>'Díaz','email'=>'laura@itch.edu.mx','activo'=>1]);
    DB::connection('sit')->table('catedraticos')->insert(['id'=>23,'user_id'=>13,'numero_empleado'=>'EMP-23','activo'=>1]);
    DB::connection('sit')->table('cat_materias')->insert(['id'=>30,'nombre'=>'Redes','num_temas'=>5,'activo'=>1]);
    DB::connection('sit')->table('cat_periodos_escolares')->insert(['id'=>40,'nombre'=>'2026-1','activo'=>1]);
    DB::connection('sit')->table('grupos')->insert([
        'id'=>50,'periodo_id'=>40,'materia_id'=>30,'catedratico_id'=>23,'clave_grupo'=>'A','activo'=>1,
    ]);
    DB::connection('sit')->table('listas')->insert(['id'=>60,'grupo_id'=>50]);

    $grupos = Grupo::with(['materia','periodoEscolar'])
        ->withCount('listas')
        ->where('activo', true)
        ->where('catedratico_id', 23)
        ->periodoActivoOSeleccionado(null)
        ->get();

    expect($grupos)->toHaveCount(1)
        ->and($grupos->first()->materia->nombre)->toBe('Redes')
        ->and($grupos->first()->periodoEscolar->nombre)->toBe('2026-1')
        ->and((int) $grupos->first()->listas_count)->toBe(1);
});
