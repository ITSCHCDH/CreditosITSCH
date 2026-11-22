<?php

use App\Models\Sit\Carrera;
use App\Services\Sit\CarrerasSitService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

it('lista carreras institucionales activas y migradas', function () {
    $activas = Carrera::where('activo', 1)->count();

    expect($activas)->toBeGreaterThan(0);
    expect(CarrerasSitService::visibles(null, true)->count())->toBe($activas);
});

it('ejecuta el comando de migracion de carreras de forma idempotente', function () {
    $this->artisan('creditos:migrar-carreras-sit')->assertExitCode(0);
    $this->artisan('creditos:migrar-carreras-sit')->assertExitCode(0);

    expect(DB::table('areas')->where('tipo', 'carrera')->count())->toBe(0);
});

it('tiene la columna users sit_carrera_id y ya no conserva areas carrera', function () {
    expect(Schema::hasColumn('users', 'sit_carrera_id'))->toBeTrue();
    expect(DB::table('areas')->where('tipo', 'carrera')->count())->toBe(0);
    expect(DB::table('areas')->where('tipo', 'otro')->count())->toBeGreaterThan(0);
});

it('los catalogos locales de carrera usan ids institucionales', function () {
    $idsSit = Carrera::where('activo', 1)->pluck('id')->map(fn ($id) => (int) $id)->all();

    foreach (['constancia' => 'carrera', 'creditos_areas' => 'credito_area', 'grupos' => 'id_Carrera', 'asignaciones_tutores' => 'car_Clave'] as $tabla => $columna) {
        foreach (DB::table($tabla)->pluck($columna)->filter()->unique() as $referencia) {
            expect(in_array((int) $referencia, $idsSit, true))->toBeTrue();
        }
    }

    expect(true)->toBeTrue();
});
