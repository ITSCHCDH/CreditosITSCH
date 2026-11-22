<?php

namespace App\Services\Sta;

use App\Models\AlumnoCreditosPerfil;
use App\Models\Datos_familiares;
use App\Models\Direccion;
use App\Models\Familiar;
use App\Models\Historial_clinico;
use App\Models\Padres;
use App\Models\Personales;
use App\Models\Social;
use App\Models\Sit\Alumno;

class FichaAlumnoService
{
    public function obtener(string $noControl): ?array
    {
        $alumno = Alumno::with([
            'user',
            'carrera',
            'alumnoComplemento.estado',
            'alumnoComplemento.municipio',
            'alumnoDatoMedico',
            'discapacidades',
        ])->where('no_control', $noControl)->first();

        if (! $alumno) {
            return null;
        }

        $complemento = $alumno->alumnoComplemento;
        $medico = $alumno->alumnoDatoMedico;
        $perfil = AlumnoCreditosPerfil::where('no_control', $noControl)->first();
        $social = Social::where('no_control', $noControl)->first();
        $familiares = Familiar::where('no_control', $noControl)->get();
        $url = (string) config('services.sit.perfil_url');

        $padres = Padres::where('no_control', $noControl)->get();
        if ($padres->isEmpty()) {
            $padres = Padres::where('id_alu', $alumno->id)->get();
        }

        return [
            'sit' => [
                'alumno' => $alumno,
                'user' => $alumno->user,
                'carrera' => $alumno->carrera,
                'complementos' => $complemento,
                'estado' => $complemento?->estado,
                'municipio' => $complemento?->municipio,
                'datos_medicos' => $medico,
                'discapacidades' => $alumno->discapacidades,
                'sit_perfil_url' => $url,
            ],
            'alumno' => $alumno,
            'complemento' => $complemento,
            'dato_medico' => $medico,
            'discapacidades' => $alumno->discapacidades,
            'creditos' => [
                'social' => $social,
                'familiares' => $familiares,
                'ficha_completada' => (bool) ($perfil?->ficha_completada),
                'perfil' => $perfil,
            ],
            'historico_legacy' => [
                'datos_familiares' => Datos_familiares::where('no_control', $noControl)->first()
                    ?? Datos_familiares::where('id_alu', $alumno->id)->first(),
                'padres' => $padres,
                'padre' => $padres->firstWhere('parentesco', 'Padre'),
                'madre' => $padres->firstWhere('parentesco', 'Madre'),
                'direccion' => Direccion::where('id_alu', $alumno->id)->first(),
                'personales' => Personales::where('no_control', $noControl)->first()
                    ?? Personales::where('id_alu', $alumno->id)->first(),
                'clinicos' => Historial_clinico::where('no_control', $noControl)->first()
                    ?? Historial_clinico::where('id_alu', $alumno->id)->first(),
                'social' => $social,
                'familiares' => $familiares,
            ],
            'sit_perfil_url' => $url,
            'url' => $url,
            'url_sit' => $url,
        ];
    }

    public function get(string $noControl): ?array
    {
        return $this->obtener($noControl);
    }

    public function ficha(string $noControl): ?array
    {
        return $this->obtener($noControl);
    }
}
