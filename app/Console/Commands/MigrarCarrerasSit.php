<?php

namespace App\Console\Commands;

use App\Models\Sit\Carrera;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MigrarCarrerasSit extends Command
{
    protected $signature = 'creditos:migrar-carreras-sit
        {--manual= : Mapeos manuales "area_id=sit_id,area_id=sit_id"}
        {--dry-run : No escribe cambios}
        {--cleanup : Elimina áreas carrera después de comprobar referencias}';

    protected $description = 'Migra referencias de carreras locales a sit.cat_carreras de forma idempotente';

    public function handle(): int
    {
        $manual = $this->parseManual((string) $this->option('manual'));
        $dryRun = (bool) $this->option('dry-run');
        $cleanup = (bool) $this->option('cleanup');

        $carreras = Carrera::where('activo', 1)->get();
        $areas = DB::table('areas')->where('tipo', 'carrera')->get();
        $mapa = $manual;

        foreach ($areas as $area) {
            if (isset($mapa[(int) $area->id])) {
                continue;
            }
            $match = $this->matchPartial((string) $area->nombre, $carreras);
            if ($match) {
                $mapa[(int) $area->id] = (int) $match->id;
            }
        }

        $pendientes = $areas->filter(fn ($area) => ! isset($mapa[(int) $area->id]))
            ->map(fn ($area) => (object) ['area_id' => $area->id, 'nombre' => $area->nombre])
            ->values();

        foreach ($pendientes as $pendiente) {
            $this->warn("Sin coincidencia: area={$pendiente->area_id} {$pendiente->nombre}");
        }

        $fallback = DB::table('areas')->where('tipo', 'otro')->orderBy('id')->value('id');
        if (! $fallback) {
            $fallback = DB::table('areas')->insertGetId([
                'nombre' => 'Administrativo',
                'tipo' => 'otro',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $aplicar = function () use ($mapa, $carreras, $fallback, $cleanup, $pendientes) {
            foreach (DB::table('users')->get(['id', 'area', 'sit_carrera_id']) as $user) {
                $carreraPorArea = $mapa[(int) $user->area] ?? null;
                $carreraId = $user->sit_carrera_id ?: $carreraPorArea;
                $datos = ['sit_carrera_id' => $carreraId];
                if ($carreraPorArea) {
                    $datos['area'] = $fallback;
                }
                DB::table('users')->where('id', $user->id)->update($datos);
            }

            foreach (['constancia' => 'carrera', 'creditos_areas' => 'credito_area', 'grupos' => 'id_Carrera', 'asignaciones_tutores' => 'car_Clave'] as $tabla => $columna) {
                foreach (DB::table($tabla)->get(['id', $columna]) as $row) {
                    $valor = (int) $row->{$columna};
                    $nuevo = $mapa[$valor] ?? ($carreras->contains(fn ($c) => (int) $c->id === $valor) ? $valor : null);
                    if ($nuevo) {
                        DB::table($tabla)->where('id', $row->id)->update([$columna => $nuevo]);
                    }
                }
            }

            if ($cleanup || $pendientes->isEmpty()) {
                $hayAreasCarrera = DB::table('areas')->where('tipo', 'carrera')->exists();
                $idsSit = $carreras->pluck('id')->map(fn ($id) => (int) $id)->all();
                $idsLegacy = array_keys($mapa);
                $huerfanos = $hayAreasCarrera && (
                    DB::table('users')->whereIn('area', $idsLegacy)->exists()
                    || collect(DB::table('constancia')->pluck('carrera'))->filter(fn ($id) => $id && ! in_array((int) $id, $idsSit, true))->isNotEmpty()
                    || collect(DB::table('creditos_areas')->pluck('credito_area'))->filter(fn ($id) => $id && ! in_array((int) $id, $idsSit, true))->isNotEmpty()
                    || collect(DB::table('grupos')->pluck('id_Carrera'))->filter(fn ($id) => $id && ! in_array((int) $id, $idsSit, true))->isNotEmpty()
                    || collect(DB::table('asignaciones_tutores')->pluck('car_Clave'))->filter(fn ($id) => $id && ! in_array((int) $id, $idsSit, true))->isNotEmpty()
                );
                if (! $huerfanos) {
                    DB::table('areas')->where('tipo', 'carrera')->delete();
                    $this->info('Áreas carrera eliminadas.');
                } else {
                    $this->warn('No se eliminaron áreas carrera: existen referencias huérfanas.');
                }
            }
        };

        if ($dryRun) {
            $this->table(['area_id', 'nombre', 'sit_carrera_id'], $areas->map(function ($area) use ($mapa) {
                return [$area->id, $area->nombre, $mapa[(int) $area->id] ?? ''];
            })->all());
            $this->info('Dry-run: no se escribió ninguna tabla.');
            return self::SUCCESS;
        }

        DB::transaction($aplicar);
        $this->info('Mapeo de carreras aplicado en una transacción.');
        return self::SUCCESS;
    }

    private function parseManual(string $texto): array
    {
        $mapa = [];
        foreach (array_filter(array_map('trim', explode(',', $texto))) as $par) {
            if (! str_contains($par, '=')) {
                continue;
            }
            [$area, $carrera] = array_map('trim', explode('=', $par, 2));
            if (ctype_digit($area) && ctype_digit($carrera)) {
                $mapa[(int) $area] = (int) $carrera;
            }
        }
        return $mapa;
    }

    private function matchPartial(string $nombre, $carreras)
    {
        $normalizar = fn ($texto) => mb_strtolower(Str::ascii(trim((string) $texto)), 'UTF-8');
        $buscada = $normalizar($nombre);
        foreach ($carreras as $carrera) {
            if ($normalizar($carrera->nombre) === $buscada) {
                return $carrera;
            }
        }
        $coincidencias = $carreras->filter(function ($carrera) use ($buscada, $normalizar) {
            $nombre = $normalizar($carrera->nombre);
            return str_contains($nombre, $buscada) || str_contains($buscada, $nombre);
        })->values();
        return $coincidencias->count() === 1 ? $coincidencias->first() : null;
    }
}
