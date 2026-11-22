<?php

namespace App\Services\Creditos;

use App\Models\AlumnoCreditosPerfil;
use App\Models\Avance;

class AvanceCreditosService
{
    public function sincronizar(string $noControl): AlumnoCreditosPerfil
    {
        $liberados = (int) Avance::query()
            ->where('no_control', $noControl)
            ->where('por_credito', '>=', 100)
            ->count();

        $perfil = AlumnoCreditosPerfil::obtenerOCrear($noControl);
        $estatusAnterior = (string) $perfil->estatus_creditos;

        if ($liberados >= 5) {
            $nuevoEstatus = 'Liberado';
        } elseif (strcasecmp($estatusAnterior, 'Liberado') === 0) {
            $nuevoEstatus = 'pendiente';
        } else {
            $nuevoEstatus = $perfil->estatus_creditos ?: 'pendiente';
        }

        if ($perfil->estatus_creditos !== $nuevoEstatus) {
            $perfil->estatus_creditos = $nuevoEstatus;
            $perfil->save();
        }

        return $perfil->fresh();
    }

    public function estaLiberado(string $noControl): bool
    {
        return $this->sincronizar($noControl)->estatus_creditos === 'Liberado';
    }

    public function liberados(string $noControl): int
    {
        return (int) Avance::query()
            ->where('no_control', $noControl)
            ->where('por_credito', '>=', 100)
            ->count();
    }
}
