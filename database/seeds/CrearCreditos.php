<?php

use App\Models\Credito;
use Illuminate\Database\Seeder;

class CrearCreditos extends Seeder
{
    public function run(): void
    {
        $creditos = [
            'Clubes',
            'Tutorías',
            'Concursos',
            'Congresos y Jornadas',
            'Comunitario',
        ];

        foreach ($creditos as $nombre) {
            Credito::firstOrCreate(['nombre' => $nombre]);
        }
    }
}
