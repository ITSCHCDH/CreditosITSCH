<?php

use App\Models\Sit\Catedratico;
use App\Models\Sit\Grupo;
use App\Models\Sit\Materia;
use App\Models\Sit\PeriodoEscolar;
use App\Models\Sit\User as SitUser;
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

    Schema::connection('sit')->create('users', function (Blueprint $table) {
        $table->id();
        $table->string('nombre')->nullable();
        $table->string('apellido_paterno')->nullable();
        $table->string('apellido_materno')->nullable();
        $table->string('email')->nullable();
    });
    Schema::connection('sit')->create('catedraticos', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->string('numero_empleado');
        $table->string('departamento_adscripcion')->nullable();
        $table->boolean('activo')->default(true);
    });
    Schema::connection('sit')->create('cat_periodos_escolares', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->date('fecha_inicio');
        $table->date('fecha_fin');
        $table->boolean('activo')->default(false);
    });
    Schema::connection('sit')->create('cat_materias', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->integer('num_temas')->default(3);
        $table->boolean('activo')->default(true);
    });
    Schema::connection('sit')->create('grupos', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('periodo_id');
        $table->unsignedBigInteger('materia_id');
        $table->unsignedBigInteger('catedratico_id');
        $table->string('clave_grupo');
        $table->integer('cupo_maximo')->default(30);
        $table->boolean('activo')->default(true);
    });
    Schema::connection('sit')->create('listas', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('grupo_id')->nullable();
        $table->unsignedBigInteger('alumno_id')->nullable();
        $table->unsignedBigInteger('catedratico_id')->nullable();
    });

    DB::connection('sit')->table('users')->insert([
        'id' => 10, 'nombre' => 'Ana', 'apellido_paterno' => 'Prueba', 'apellido_materno' => 'Docente', 'email' => 'ana@example.test',
    ]);
    DB::connection('sit')->table('catedraticos')->insert([
        'id' => 20, 'user_id' => 10, 'numero_empleado' => 'EMP-20', 'activo' => true,
    ]);
    DB::connection('sit')->table('cat_periodos_escolares')->insert([
        'id' => 30, 'nombre' => '2026-1', 'fecha_inicio' => '2026-01-01', 'fecha_fin' => '2026-06-30', 'activo' => true,
    ]);
    DB::connection('sit')->table('cat_materias')->insert([
        'id' => 40, 'nombre' => 'Programación', 'num_temas' => 4, 'activo' => true,
    ]);
    DB::connection('sit')->table('grupos')->insert([
        'id' => 50, 'periodo_id' => 30, 'materia_id' => 40, 'catedratico_id' => 20, 'clave_grupo' => 'A', 'activo' => true,
    ]);
});

function usuarioSta($permisos)
{
    $usuario = Mockery::mock(User::class)->makePartial();
    $usuario->id = 1;
    $usuario->name = 'Ana Prueba';
    $usuario->email = 'ana@example.test';
    $usuario->shouldReceive('hasAnyPermission')->andReturnUsing(fn (array $lista) => (bool) array_intersect($lista, $permisos));
    $usuario->shouldReceive('canAny')->andReturnUsing(fn (array $lista) => (bool) array_intersect($lista, $permisos));
    $usuario->shouldReceive('can')->andReturnUsing(fn (string $permiso) => in_array($permiso, $permisos, true));
    return $usuario;
}

function resolverDocenteParaPrueba()
{
    $docente = Catedratico::with('user')->find(20);
    $resolver = Mockery::mock(DocenteSitResolverService::class);
    $resolver->shouldReceive('resolverCatedratico')->andReturn($docente);
    app()->instance(DocenteSitResolverService::class, $resolver);
}

it('permite el acceso docente a mis grupos', function () {
    resolverDocenteParaPrueba();
    $usuario = usuarioSta(['STA_PROFESOR']);
    $this->actingAs($usuario);

    $response = $this->get(route('profesores.mis_grupos'));

    $response->assertOk()->assertSee('Mis Grupos')->assertSee('EMP-20')->assertSee('Programación');
});

it('devuelve 403 a profesor administrativo en consulta administrativa', function () {
    resolverDocenteParaPrueba();
    $usuario = usuarioSta(['STA_PROFESOR']);
    $this->actingAs($usuario);

    $this->get(route('profesores.index'))->assertForbidden();
    $this->post(route('profesores.find'))->assertForbidden();
});

it('devuelve 403 AJAX al intentar consultar un grupo ajeno', function () {
    resolverDocenteParaPrueba();
    $usuario = usuarioSta(['STA_PROFESOR']);
    $this->actingAs($usuario);

    $this->postJson(route('listaCali.find'), [
        'materia' => 40,
        'unidad' => 1,
        'grupo' => 999,
    ])->assertForbidden();
});

it('VIP_STA conserva acceso administrativo', function () {
    resolverDocenteParaPrueba();
    $usuario = usuarioSta(['VIP_STA']);
    $this->actingAs($usuario);

    $this->get(route('profesores.index'))->assertOk();
    $this->post(route('profesores.find'))->assertOk();
});
