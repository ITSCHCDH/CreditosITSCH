<?php

namespace App\Services\Sit;

use App\Models\Sit\Carrera;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Catálogo institucional de carreras proveniente de SIT.
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
        return [];
    }

    public static function deArea($areaId): ?int
    {
        return null;
    }

    public static function areaDeCarrera($carreraId): ?int
    {
        return (int) $carreraId ?: null;
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
            $ids = collect($areasCredito)
                ->map(fn ($carreraId) => (int) $carreraId)
                ->filter()
                ->values();

            $query->whereIn('id', $ids->isEmpty() ? [-1] : $ids->all());
        }

        return $query->get();
    }

    /**
     * Carreras con la clave de área de créditos, que es la que guardan las
     * tablas propias (grupos.id_Carrera, asignaciones_tutores.car_Clave).
     */
    public static function opcionesPorArea(bool $soloActivas = true): Collection
    {
        $query = Carrera::query()->orderBy('nombre');
        if ($soloActivas) {
            $query->where('activo', 1);
        }

        return $query->get()
            ->map(fn ($carrera) => (object) [
                'car_Clave' => (int) $carrera->id,
                'car_Nombre' => $carrera->nombre,
            ])
            ->values();
    }

    public static function nombreDeArea($areaId, string $porDefecto = 'Desconocido'): string
    {
        $directa = Carrera::find((int) $areaId);
        if ($directa) {
            return $directa->nombre;
        }

        $carreraId = self::deArea((int) $areaId);
        if ($carreraId === null) {
            return $porDefecto;
        }

        return Carrera::find($carreraId)?->nombre ?? $porDefecto;
    }
}
