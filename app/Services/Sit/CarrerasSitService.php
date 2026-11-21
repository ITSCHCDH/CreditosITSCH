<?php

namespace App\Services\Sit;

use App\Models\Area;
use App\Models\Sit\Carrera;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Equivalencia entre creditos.areas y sit.cat_carreras.
 *
 * No existe una columna de mapeo entre ambos catálogos: se comparan los
 * nombres normalizados (minúsculas y sin acentos). Es el puente temporal
 * mientras el sistema termina de depender solo de SIT.
 */
class CarrerasSitService
{
    public static function normalizar($texto): string
    {
        return Str::lower(Str::ascii(trim((string) $texto)));
    }

    /** @return array<int,int> [area_id => carrera_id de SIT] */
    public static function mapaAreaCarrera(): array
    {
        static $mapa = null;

        if ($mapa !== null) {
            return $mapa;
        }

        $mapa = [];
        $carrerasSit = Carrera::all()->keyBy(fn ($carrera) => self::normalizar($carrera->nombre));

        foreach (Area::where('tipo', 'carrera')->get() as $area) {
            $clave = self::normalizar($area->nombre);
            if ($carrerasSit->has($clave)) {
                $mapa[$area->id] = $carrerasSit->get($clave)->id;
            }
        }

        return $mapa;
    }

    public static function deArea($areaId): ?int
    {
        return self::mapaAreaCarrera()[$areaId] ?? null;
    }

    public static function areaDeCarrera($carreraId): ?int
    {
        $area = array_search($carreraId, self::mapaAreaCarrera(), true);

        return $area === false ? null : (int) $area;
    }

    /**
     * Carreras del catálogo SIT; si se pasan áreas de créditos, se limita a sus
     * equivalentes. Con $soloActivas se excluyen las carreras dadas de baja.
     */
    public static function visibles($areasCredito = null, bool $soloActivas = false): Collection
    {
        $query = Carrera::query()->orderByDesc('activo')->orderBy('nombre');

        if ($soloActivas) {
            $query->where('activo', 1);
        }

        if ($areasCredito !== null) {
            $mapa = self::mapaAreaCarrera();
            $ids = collect($areasCredito)
                ->map(fn ($areaId) => $mapa[$areaId] ?? null)
                ->filter()
                ->values();

            $query->whereIn('id', $ids->isEmpty() ? [-1] : $ids->all());
        }

        return $query->get();
    }
}
