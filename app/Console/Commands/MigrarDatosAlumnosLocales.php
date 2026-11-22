<?php

namespace App\Console\Commands;

use App\Models\AlumnoCreditosPerfil;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MigrarDatosAlumnosLocales extends Command
{
    protected $signature = 'creditos:migrar-datos-alumnos';

    protected $description = 'Migra los datos locales de alumnos al perfil satélite y propaga no_control';

    public function handle(): int
    {
        if (!Schema::connection('creditos')->hasTable('alumnos')) {
            $this->info('La tabla legacy creditos.alumnos ya fue eliminada; no hay datos que migrar.');

            return self::SUCCESS;
        }

        $conteos = [
            'perfiles' => 0,
            'familiares' => 0,
            'padres' => 0,
            'historiales_clinicos' => 0,
            'datos_familiares' => 0,
            'personales' => 0,
            'social' => 0,
            'pacientes' => 0,
        ];

        DB::connection('creditos')->transaction(function () use (&$conteos) {
            $alumnos = DB::connection('creditos')->table('alumnos')
                ->select([
                    'id',
                    'no_control',
                    'status',
                    'ficha',
                    'foto',
                    'observaciones',
                    'sem_med',
                    'observaciones_med',
                    'sem_psic',
                    'observaciones_psic',
                ])
                ->orderBy('id')
                ->get();

            foreach ($alumnos as $alumno) {
                AlumnoCreditosPerfil::on('creditos')->updateOrCreate(
                    ['no_control' => $alumno->no_control],
                    [
                        'estatus_creditos' => $alumno->status ?: 'pendiente',
                        'ficha_completada' => (bool) $alumno->ficha,
                        'foto' => $alumno->foto,
                        'observaciones_tutoria' => $alumno->observaciones,
                        'sem_med' => $alumno->sem_med,
                        'observaciones_med' => $alumno->observaciones_med,
                        'sem_psic' => $alumno->sem_psic,
                        'observaciones_psic' => $alumno->observaciones_psic,
                    ]
                );
                $conteos['perfiles']++;

                foreach (['familiares', 'padres', 'historiales_clinicos', 'datos_familiares', 'personales', 'social'] as $tabla) {
                    $conteos[$tabla] += DB::connection('creditos')->table($tabla)
                        ->where('id_alu', $alumno->id)
                        ->update(['no_control' => $alumno->no_control]);
                }

                $conteos['pacientes'] += DB::connection('creditos')->table('pacientes')
                    ->where('tipo', 'Alumno')
                    ->where('user_id', $alumno->id)
                    ->update(['no_control' => $alumno->no_control]);
            }
        });

        foreach ($conteos as $tabla => $conteo) {
            $this->line(sprintf('%-24s %d', $tabla, $conteo));
        }

        $this->info('Migración local de alumnos completada.');

        return self::SUCCESS;
    }
}
