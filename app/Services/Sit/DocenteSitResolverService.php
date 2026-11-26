<?php

namespace App\Services\Sit;

use App\Models\Sit\Catedratico;
use App\Models\Sit\User as SitUser;
use App\User;
use Illuminate\Support\Facades\Cache;

class DocenteSitResolverService
{
    public function resolverCatedratico(User $usuarioCreditos, bool $forzarBusqueda = false): ?Catedratico
    {
        if (! $forzarBusqueda && $usuarioCreditos->sit_catedratico_id) {
            $vinculado = Catedratico::with('user')
                ->whereKey($usuarioCreditos->sit_catedratico_id)
                ->where('activo', true)
                ->first();
            if ($vinculado) {
                return $vinculado;
            }
        }

        $cacheKey = 'sit.docente.resuelto.'.(int) $usuarioCreditos->getKey();

        if (! $forzarBusqueda) {
            $enCache = Cache::get($cacheKey);
            if ($enCache instanceof Catedratico) {
                return $enCache->activo ? $enCache : null;
            }
        }

        $correo = mb_strtolower(trim((string) $usuarioCreditos->email));
        $coincidencia = null;

        if ($correo !== '') {
            $coincidencia = Catedratico::with('user')
                ->where('activo', true)
                ->whereHas('user', fn ($query) => $query->whereRaw('LOWER(email) = ?', [$correo]))
                ->first();
        }

        if (! $coincidencia) {
            $coincidencia = $this->buscarPorNombreNormalizado($usuarioCreditos->name);
        }

        if (! $coincidencia) {
            Cache::forget($cacheKey);
            return null;
        }

        $usuarioCreditos->forceFill([
            'sit_user_id' => $coincidencia->user_id,
            'sit_catedratico_id' => $coincidencia->id,
        ])->save();

        Cache::put($cacheKey, $coincidencia, now()->addMinutes(30));

        return $coincidencia;
    }

    private function buscarPorNombreNormalizado(?string $nombre): ?Catedratico
    {
        $objetivo = $this->normalizarNombre($nombre);
        if ($objetivo === '') {
            return null;
        }

        $mejor = null;
        $mejorPorcentaje = 0.0;

        Catedratico::with('user')
            ->where('activo', true)
            ->whereHas('user')
            ->chunkById(200, function ($catedraticos) use (&$mejor, &$mejorPorcentaje, $objetivo) {
                foreach ($catedraticos as $catedratico) {
                    $porcentaje = $this->porcentajeCoincidenciaNombre(
                        $objetivo,
                        $catedratico
                    );
                    if ($porcentaje > $mejorPorcentaje) {
                        $mejor = $catedratico;
                        $mejorPorcentaje = $porcentaje;
                    }
                }
            });

        return $mejorPorcentaje >= 82.0 ? $mejor : null;
    }

    public function normalizarNombre(?string $nombre): string
    {
        $nombre = mb_strtolower(trim((string) $nombre), 'UTF-8');
        $nombre = strtr($nombre, [
            'á'=>'a','é'=>'e','í'=>'i','ó'=>'o','ú'=>'u','ü'=>'u','ñ'=>'n',
        ]);
        $nombre = preg_replace(
            '/^(?:ing\.?|lic\.?|dr\.?|dra\.?|m\.c\.?|m\.i\.?|mtro\.?|mtra\.?|prof\.?|profr\.?|profa\.?|cp\.?|phd\.?)\s+/iu',
            '',
            $nombre
        );
        $nombre = preg_replace('/[^a-z0-9\s]/', ' ', $nombre);
        $nombre = preg_replace('/\s+/', ' ', $nombre);
        return trim((string) $nombre);
    }

    public function porcentajeCoincidenciaNombre(?string $objetivo, Catedratico $catedratico): float
    {
        $objetivo = $this->normalizarNombre($objetivo);
        $sitUser = $catedratico->user;
        if ($objetivo === '' || ! $sitUser) {
            return 0.0;
        }

        $nombre = $this->normalizarNombre($sitUser->nombre);
        $apellidoPaterno = $this->normalizarNombre($sitUser->apellido_paterno);
        $apellidoMaterno = $this->normalizarNombre($sitUser->apellido_materno);

        $candidatos = array_filter([
            trim(implode(' ', array_filter([$nombre, $apellidoPaterno, $apellidoMaterno]))),
            trim(implode(' ', array_filter([$apellidoPaterno, $apellidoMaterno, $nombre]))),
            $this->normalizarNombre($sitUser->nombreCompleto),
        ]);

        $mejor = 0.0;
        foreach ($candidatos as $candidato) {
            similar_text($objetivo, $candidato, $porcentaje);
            $mejor = max($mejor, (float) $porcentaje);

            $objetivoTokens = array_values(array_unique(explode(' ', $objetivo)));
            $candidatoTokens = array_values(array_unique(explode(' ', $candidato)));
            $interseccion = count(array_intersect($objetivoTokens, $candidatoTokens));
            $union = count(array_unique(array_merge($objetivoTokens, $candidatoTokens)));
            $porcentajeTokens = $union > 0 ? ($interseccion / $union) * 100 : 0.0;
            $mejor = max($mejor, $porcentajeTokens);
        }

        return $mejor;
    }
}
