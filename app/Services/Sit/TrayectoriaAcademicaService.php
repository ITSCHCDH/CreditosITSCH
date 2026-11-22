<?php

namespace App\Services\Sit;

use App\Models\Sit\Alumno;
use App\Models\Sit\Kardex;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TrayectoriaAcademicaService
{
    public function creditos(Alumno $alumno): array
    {
        $acumulados = (int) Kardex::where('alumno_id', $alumno->id)
            ->where('acreditada', 1)
            ->sum('creditos_materia');
        $totales = (int) ($alumno->planEstudio?->creditos_totales ?? 0);

        return [
            'acumulados' => $acumulados,
            'totales' => $totales,
            'porcentaje' => $totales > 0 ? round(($acumulados * 100) / $totales, 2) : 0,
        ];
    }

    public function servicioSocial(Alumno $alumno): array
    {
        $registro = $alumno->servicioSocial;
        return [
            'estatus' => $registro?->estatus ?? 'no_iniciado',
            'constancia_estatus' => $registro?->constancia_estatus,
            'liberado' => $registro?->estatus === 'liberado',
            'registro' => $registro,
        ];
    }

    public function residencia(Alumno $alumno): array
    {
        $registro = $alumno->residencia;
        return [
            'estatus' => $registro?->estatus ?? 'sin_registro',
            'liberada' => $registro?->estatus === 'liberado',
            'registro' => $registro,
        ];
    }

    public function generaciones(?int $carreraId = null): Collection
    {
        return Alumno::query()
            ->when($carreraId, fn ($query) => $query->where('carrera_id', $carreraId))
            ->whereNotNull('anio_ingreso')
            ->distinct()
            ->orderByDesc('anio_ingreso')
            ->pluck('anio_ingreso');
    }

    public function materiasUnidades(Alumno $alumno): Collection
    {
        return DB::connection('sit')->table('listas')
            ->leftJoin('grupos', 'grupos.id', '=', 'listas.grupo_id')
            ->leftJoin('cat_materias', 'cat_materias.id', '=', 'grupos.materia_id')
            ->leftJoin('catedraticos', 'catedraticos.id', '=', 'listas.catedratico_id')
            ->leftJoin('users as docente', 'docente.id', '=', 'catedraticos.user_id')
            ->leftJoin('lista_unidades', 'lista_unidades.lista_id', '=', 'listas.id')
            ->where('listas.alumno_id', $alumno->id)
            ->select(
                'listas.id as lista_id',
                'grupos.materia_id',
                'cat_materias.nombre as materia',
                'cat_materias.num_temas as num_unidades',
                'lista_unidades.numero_unidad',
                'lista_unidades.oportunidad',
                'lista_unidades.calificacion',
                'lista_unidades.corte',
                DB::raw("CONCAT_WS(' ', docente.nombre, docente.apellido_paterno, docente.apellido_materno) as docente")
            )
            ->orderBy('listas.id')
            ->orderBy('lista_unidades.numero_unidad')
            ->orderByDesc('lista_unidades.oportunidad')
            ->orderByDesc('lista_unidades.id')
            ->get();
    }

    public function semaforos(Alumno $alumno): array
    {
        $estatus = $alumno->estatus;
        $status = match ($estatus) {
            'Baja temporal' => 'BT',
            'Baja definitiva' => 'BD',
            'Egresado', 'Titulado' => 'EG',
            default => 'R',
        };

        $indices = Kardex::where('alumno_id', $alumno->id)
            ->selectRaw('SUM(CASE WHEN opcion_acreditacion_numerico = 2 THEN 1 ELSE 0 END) AS nivelacionesOrdinario')
            ->selectRaw('SUM(CASE WHEN opcion_acreditacion_numerico = 3 THEN 1 ELSE 0 END) AS repeticiones')
            ->selectRaw('SUM(CASE WHEN opcion_acreditacion_numerico = 4 THEN 1 ELSE 0 END) AS nivelacionesRepe')
            ->selectRaw('SUM(CASE WHEN opcion_acreditacion_numerico = 5 THEN 1 ELSE 0 END) AS especiales')
            ->selectRaw('SUM(CASE WHEN opcion_acreditacion_numerico = 6 THEN 1 ELSE 0 END) AS nivelacionesEspecial')
            ->first();

        $repeticiones = (int) ($indices->repeticiones ?? 0);
        $especiales = (int) ($indices->especiales ?? 0);
        $nivelaciones = (int) (($indices->nivelacionesOrdinario ?? 0) + ($indices->nivelacionesRepe ?? 0) + ($indices->nivelacionesEspecial ?? 0));

        if ($status === 'BD') {
            $semaforoAcad = 'CirculoNegro';
            $tituloAcad = 'Ya no es posible realizar acciones de seguimiento con este alumno';
        } elseif ($especiales > 0 || $nivelaciones >= 10 || $repeticiones > 2 || $status === 'BT') {
            $semaforoAcad = 'CirculoRojo';
            $tituloAcad = 'El alumno tiene problemas académicos graves, urgente dar seguimiento';
        } elseif ($repeticiones <= 2 && $nivelaciones >= 3 && $nivelaciones < 10) {
            $semaforoAcad = 'CirculoNaranja';
            $tituloAcad = 'El alumno tiene problemas académicos moderados, se recomienda dar seguimiento';
        } elseif ($nivelaciones > 1 && $nivelaciones < 3) {
            $semaforoAcad = 'CirculoAmarillo';
            $tituloAcad = 'El alumno tiene problemas académicos leves, se recomienda observación';
        } else {
            $semaforoAcad = 'CirculoVerde';
            $tituloAcad = 'El alumno no tiene problemas académicos';
        }

        $servicio = $this->servicioSocial($alumno);
        $creditos = $this->creditos($alumno);
        $semestre = (int) $alumno->semestre_actual;

        if ($servicio['liberado']) {
            $semaforoServicio = 'CirculoVerde';
            $tituloServicio = 'El servicio social ya fue registrado';
        } elseif ($status === 'BT' || $status === 'BD') {
            $semaforoServicio = 'CirculoNegro';
            $tituloServicio = 'El status del alumno es baja, consultar con servicios escolares';
        } elseif ($semestre <= 7) {
            $semaforoServicio = 'CirculoAzul';
            $tituloServicio = 'Este alumno aún no reúne los requisitos para tramitar servicio social';
        } elseif ($semestre === 8 && $creditos['porcentaje'] >= 80) {
            $semaforoServicio = 'CirculoNaranja';
            $tituloServicio = 'Verificar que el alumno esté realizando servicio social';
        } elseif ($semestre >= 9) {
            $semaforoServicio = 'CirculoRojo';
            $tituloServicio = 'Servicio social retrasado, urgente dar seguimiento';
        } else {
            $semaforoServicio = 'CirculoNegro';
            $tituloServicio = 'Este alumno no tiene registros de servicio social';
        }

        return [
            'semaforoAcad' => $semaforoAcad,
            'titleAcad' => $tituloAcad,
            'semaforoPsico' => 'CirculoNegro',
            'semaforoMedico' => 'CirculoNegro',
            'semaforoServicio' => $semaforoServicio,
            'titleSS' => $tituloServicio,
        ];
    }
}
