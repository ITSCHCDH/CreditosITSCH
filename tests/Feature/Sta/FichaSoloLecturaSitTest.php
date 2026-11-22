<?php

use App\Models\Sit\Alumno;
use App\Models\Sit\AlumnoComplemento;
use App\Models\Sit\Estado;
use App\Models\Sit\Discapacidad;
use App\Services\Sta\FichaAlumnoService;
use App\Models\AlumnoCreditosPerfil;
use App\Models\Familiar;
use App\Models\Social;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
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
    });
    Schema::connection('sit')->create('cat_estados', function (Blueprint $table) {
        $table->id();
        $table->string('clave')->nullable();
        $table->string('nombre')->nullable();
    });
    Schema::connection('sit')->create('cat_municipios', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('estado_id')->nullable();
        $table->string('nombre')->nullable();
    });
    Schema::connection('sit')->create('alumnos', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->string('no_control')->unique();
        $table->unsignedBigInteger('carrera_id');
        $table->string('estatus')->nullable();
        $table->integer('semestre_actual')->nullable();
    });
    Schema::connection('sit')->create('alumno_complementos', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('alumno_id');
        $table->string('direccion')->nullable();
        $table->string('colonia')->nullable();
        $table->string('cp')->nullable();
        $table->unsignedBigInteger('estado_id')->nullable();
        $table->unsignedBigInteger('municipio_id')->nullable();
    });
    Schema::connection('sit')->create('alumno_datos_medicos', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('alumno_id');
        $table->string('tipo_sangre')->nullable();
        $table->boolean('discapacidad')->default(false);
    });
    Schema::connection('sit')->create('discapacidades', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->text('descripcion')->nullable();
    });
    Schema::connection('sit')->create('alumno_discapacidades', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('alumno_id');
        $table->unsignedBigInteger('discapacidad_id');
        $table->text('observaciones')->nullable();
        $table->timestamps();
    });

    Schema::connection('creditos')->create('alumno_creditos_perfil', function (Blueprint $table) {
        $table->id();
        $table->string('no_control')->unique();
        $table->boolean('ficha_completada')->default(false);
        $table->timestamps();
    });
    foreach (['historiales_clinicos', 'padres', 'direcciones', 'familiares', 'personales', 'datos_familiares', 'social'] as $tabla) {
        Schema::connection('creditos')->create($tabla, function (Blueprint $table) use ($tabla) {
            $table->id();
            $table->unsignedBigInteger('id_alu')->nullable();
            $table->string('no_control')->nullable();
            if ($tabla === 'padres') {
                $table->string('parentesco')->nullable();
            }
            if ($tabla === 'direcciones') {
                $table->unsignedBigInteger('id_fam')->nullable();
            }
            if ($tabla === 'familiares') {
                $table->string('nombre')->nullable();
                $table->integer('edad')->nullable();
            }
            if ($tabla === 'social') {
                $table->string('metas_vida')->nullable();
            }
            $table->timestamps();
        });
    }

    DB::connection('sit')->table('users')->insert(['id' => 1, 'nombre' => 'Ana', 'apellido_paterno' => 'Lopez']);
    DB::connection('sit')->table('cat_carreras')->insert(['id' => 10, 'nombre' => 'Sistemas', 'nombre_corto' => 'ISC']);
    DB::connection('sit')->table('cat_estados')->insert(['id' => 16, 'nombre' => 'Michoacán']);
    DB::connection('sit')->table('cat_municipios')->insert(['id' => 1, 'estado_id' => 16, 'nombre' => 'Ciudad Hidalgo']);
    DB::connection('sit')->table('alumnos')->insert(['id' => 100, 'user_id' => 1, 'no_control' => 'S23001', 'carrera_id' => 10]);
    DB::connection('sit')->table('alumno_complementos')->insert([
        'id' => 1, 'alumno_id' => 100, 'direccion' => 'Centro', 'colonia' => 'Una',
        'cp' => '61100', 'estado_id' => 16, 'municipio_id' => 1,
    ]);
    DB::connection('sit')->table('alumno_datos_medicos')->insert([
        'id' => 1, 'alumno_id' => 100, 'tipo_sangre' => 'O+', 'discapacidad' => false,
    ]);
    DB::connection('sit')->table('discapacidades')->insert(['id' => 1, 'nombre' => 'Visual']);
    DB::connection('sit')->table('alumno_discapacidades')->insert([
        'alumno_id' => 100, 'discapacidad_id' => 1, 'observaciones' => null,
        'created_at' => now(), 'updated_at' => now(),
    ]);
});

it('expone la ficha combinando SIT, créditos e histórico local', function () {
    config()->set('services.sit.url', 'https://sit.example.test');
    config()->set('services.sit.perfil_url', 'https://sit.example.test/alumno/perfil');

    $ficha = app(FichaAlumnoService::class)->obtener('S23001');

    expect($ficha)->toBeArray()
        ->and($ficha['sit']['alumno'])->toBeInstanceOf(Alumno::class)
        ->and($ficha['sit']['sit_perfil_url'])->toBe('https://sit.example.test/alumno/perfil')
        ->and($ficha['complemento'])->toBeInstanceOf(AlumnoComplemento::class)
        ->and($ficha['historico_legacy'])->toBeArray()
        ->and($ficha['creditos']['ficha_completada'])->toBeFalse()
        ->and($ficha['url'])->toBe('https://sit.example.test/alumno/perfil');

    expect($ficha['sit']['discapacidades']->first())->toBeInstanceOf(Discapacidad::class)
        ->and($ficha['sit']['estado'])->toBeInstanceOf(Estado::class);
});

it('protege al alumno SIT contra escrituras y conserva rutas POST para el histórico STA', function () {
    expect(fn () => Alumno::first()->save())->toThrow(RuntimeException::class);

    expect(Route::getRoutes()->getByName('alumnos.sta.ficha.guargar')->methods())
        ->toContain('POST');
    expect(Route::getRoutes()->getByName('alumnos.sta.dfamiliares.guargar')->methods())
        ->toContain('POST');
    expect(Route::getRoutes()->getByName('alumnos.sta.dsociales.guargar')->methods())
        ->toContain('POST');
    expect(Route::getRoutes()->getByName('alumnos.sta.autorizar.guargar')->methods())
        ->toContain('POST');
    expect(Route::getRoutes()->getByName('alumnos.sta.updtDatSalud'))->toBeNull();
});

it('guarda datos propios de créditos y autoriza la ficha sin escribir en SIT', function () {
    DB::connection('creditos')->table('familiares')->insert([
        'no_control' => 'S23001',
        'nombre' => 'Hermano',
        'edad' => 20,
    ]);
    DB::connection('creditos')->table('social')->insert([
        'no_control' => 'S23001',
        'metas_vida' => 'Terminar la carrera',
    ]);

    expect(Familiar::where('no_control', 'S23001')->exists())->toBeTrue()
        ->and(Social::where('no_control', 'S23001')->exists())->toBeTrue();

    $perfil = AlumnoCreditosPerfil::obtenerOCrear('S23001');
    $perfil->ficha_completada = true;
    $perfil->save();

    expect($perfil->fresh()->ficha_completada)->toBeTrue();
    expect(Alumno::where('no_control', 'S23001')->exists())->toBeTrue();
});
