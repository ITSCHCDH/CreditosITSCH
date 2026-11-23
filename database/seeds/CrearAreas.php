<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CrearAreas extends Seeder
{
    public function run(): void
    {
        $areas = [
            'Administrativo',
            'Ciencias Básicas',
            'Clubes',
            'Dirección Académica',
            'Extensión Educativa',
            'Tutorías',
            'Vinculación',
        ];

        DB::table('areas')
            ->where('nombre', 'Dirección Academica')
            ->where('tipo', 'otro')
            ->update([
                'nombre' => 'Dirección Académica',
                'updated_at' => now(),
            ]);

        foreach ($areas as $nombre) {
            $area = DB::table('areas')->where('nombre', $nombre)->first();

            if ($area) {
                DB::table('areas')->where('id', $area->id)->update([
                    'tipo' => 'otro',
                    'updated_at' => now(),
                ]);
            } else {
                DB::table('areas')->insert([
                    'nombre' => $nombre,
                    'tipo' => 'otro',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
