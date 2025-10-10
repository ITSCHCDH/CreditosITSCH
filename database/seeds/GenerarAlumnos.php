<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alumno;

class GenerarAlumnos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Para Laravel 8+ - nuevo sistema de factories
        $alumnos = Alumno::factory()->count(500)->create();
    }
}