<?php

namespace App\Console\Commands;

use App\Services\Sit\DocenteSitResolverService;
use App\User;
use Illuminate\Console\Command;

class VincularDocentesSit extends Command
{
    protected $signature = 'creditos:vincular-docentes-sit {--force : Forzar la búsqueda aunque exista vínculo persistido}';

    protected $description = 'Vincula usuarios activos locales con catedráticos activos de SIT';

    public function handle(DocenteSitResolverService $resolver): int
    {
        $usuarios = User::query()
            ->where(function ($query) {
                $query->where('active', 'true')
                    ->orWhere('active', 1)
                    ->orWhereNull('active');
            })
            ->get()
            ->sortByDesc(function (User $usuario) {
                $puntaje = (string) $usuario->tutor === '1' ? 4 : 0;
                foreach ($usuario->roles as $rol) {
                    $nombre = mb_strtolower((string) $rol->name);
                    if (str_contains($nombre, 'prof') || str_contains($nombre, 'tutor') || str_contains($nombre, 'sta')) {
                        $puntaje += 3;
                    }
                }
                foreach ($usuario->permissions as $permiso) {
                    $nombre = mb_strtolower((string) $permiso->name);
                    if (str_contains($nombre, 'prof') || str_contains($nombre, 'tutor') || str_contains($nombre, 'sta')) {
                        $puntaje += 2;
                    }
                }
                return $puntaje;
            });

        $vinculados = 0;
        $manuales = 0;
        $filas = [];

        foreach ($usuarios as $usuario) {
            $catedratico = $resolver->resolverCatedratico($usuario, (bool) $this->option('force'));
            if ($catedratico) {
                $vinculados++;
                $correoCoincide = mb_strtolower(trim((string) $usuario->email)) === mb_strtolower(trim((string) $catedratico->user?->email));
                $porcentaje = $correoCoincide
                    ? '100%'
                    : round($resolver->porcentajeCoincidenciaNombre($usuario->name, $catedratico), 2).' %';
                $nombreSit = trim(implode(' ', array_filter([
                    $catedratico->user?->nombre,
                    $catedratico->user?->apellido_paterno,
                    $catedratico->user?->apellido_materno,
                ]))) ?: 'Sin nombre';
                $filas[] = [
                    $usuario->id,
                    $usuario->name,
                    $nombreSit,
                    $correoCoincide ? 'Email exacto' : 'Similitud '.$porcentaje,
                    $catedratico->id,
                ];
            } else {
                $manuales++;
                $filas[] = [$usuario->id, $usuario->name, 'No encontrado', 'REVISIÓN MANUAL', ''];
            }
        }

        $this->table([
            'ID Créditos',
            'Nombre Créditos',
            'Nombre SIT',
            'Método',
            'sit_catedratico_id',
        ], $filas);
        $this->line("Vinculados: {$vinculados}");
        $this->warn("Revisión manual: {$manuales}");

        return self::SUCCESS;
    }
}
