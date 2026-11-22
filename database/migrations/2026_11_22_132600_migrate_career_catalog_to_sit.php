<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'sit_carrera_id')) {
                $table->unsignedBigInteger('sit_carrera_id')->nullable()->after('area');
                $table->index('sit_carrera_id');
            }
        });

        $carreras = DB::connection('sit')->table('cat_carreras')
            ->where('activo', 1)
            ->get(['id', 'clave', 'nombre', 'nombre_corto']);

        $mapa = $this->construirMapa(DB::table('areas')->where('tipo', 'carrera')->get(), $carreras);
        $fallback = $this->obtenerAreaOtro();

        DB::transaction(function () use ($mapa, $fallback, $carreras) {
            foreach (DB::table('users')->get(['id', 'area', 'sit_carrera_id']) as $user) {
                $carreraPorArea = $mapa[(int) $user->area] ?? null;
                $carreraId = $user->sit_carrera_id ?: $carreraPorArea;
                $datos = ['sit_carrera_id' => $carreraId];
                if ($carreraPorArea) {
                    $datos['area'] = $fallback;
                }
                DB::table('users')->where('id', $user->id)->update($datos);
            }

            foreach (DB::table('constancia')->get(['id', 'carrera']) as $row) {
                $carreraId = $mapa[(int) $row->carrera] ?? null;
                if (! $carreraId && $this->esCarreraSit((int) $row->carrera, $carreras)) {
                    $carreraId = (int) $row->carrera;
                }
                if ($carreraId) {
                    DB::table('constancia')->where('id', $row->id)->update(['carrera' => $carreraId]);
                }
            }

            foreach (DB::table('creditos_areas')->get(['id', 'credito_area']) as $row) {
                $carreraId = $this->normalizarReferencia((int) $row->credito_area, $mapa, $carreras);
                if ($carreraId) {
                    DB::table('creditos_areas')->where('id', $row->id)->update(['credito_area' => $carreraId]);
                }
            }

            foreach (['grupos' => 'id_Carrera', 'asignaciones_tutores' => 'car_Clave'] as $tabla => $columna) {
                foreach (DB::table($tabla)->get(['id', $columna]) as $row) {
                    $carreraId = $this->normalizarReferencia((int) $row->{$columna}, $mapa, $carreras);
                    if ($carreraId) {
                        DB::table($tabla)->where('id', $row->id)->update([$columna => $carreraId]);
                    }
                }
            }

            // Solo elimina áreas carrera cuando todas las referencias conocidas están resueltas.
            $sinHuerfanos = true;
            foreach (array_keys($mapa) as $areaId) {
                if (DB::table('users')->where('area', $areaId)->exists()
                    || DB::table('constancia')->where('carrera', $areaId)->exists()
                    || DB::table('creditos_areas')->where('credito_area', $areaId)->exists()
                    || DB::table('grupos')->where('id_Carrera', $areaId)->exists()
                    || DB::table('asignaciones_tutores')->where('car_Clave', $areaId)->exists()) {
                    $sinHuerfanos = false;
                }
            }

            if ($sinHuerfanos) {
                DB::table('areas')->where('tipo', 'carrera')->delete();
            }
        });
    }

    public function down(): void
    {
        // Los datos ya migrados conservan ids SIT; el rollback no recrea áreas carrera.
        if (Schema::hasColumn('users', 'sit_carrera_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropIndex(['sit_carrera_id']);
                $table->dropColumn('sit_carrera_id');
            });
        }
    }

    private function obtenerAreaOtro(): int
    {
        $area = DB::table('areas')->where('tipo', 'otro')->orderBy('id')->first();
        if ($area) {
            return (int) $area->id;
        }

        return (int) DB::table('areas')->insertGetId([
            'nombre' => 'Administrativo',
            'tipo' => 'otro',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function construirMapa($areas, $carreras): array
    {
        $mapa = [];
        foreach ($areas as $area) {
            $match = $this->coincidenciaNombre((string) $area->nombre, $carreras);
            if ($match) {
                $mapa[(int) $area->id] = (int) $match->id;
            }
        }
        return $mapa;
    }

    private function coincidenciaNombre(string $nombre, $carreras)
    {
        $normalizar = function ($texto) {
            $texto = \Illuminate\Support\Str::ascii(trim((string) $texto));
            return mb_strtolower($texto, 'UTF-8');
        };
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

    private function esCarreraSit(int $id, $carreras): bool
    {
        return $carreras->contains(fn ($carrera) => (int) $carrera->id === $id);
    }

    private function normalizarReferencia(int $referencia, array $mapa, $carreras): ?int
    {
        if (isset($mapa[$referencia])) {
            return $mapa[$referencia];
        }
        if ($this->esCarreraSit($referencia, $carreras)) {
            return $referencia;
        }
        return null;
    }
};
