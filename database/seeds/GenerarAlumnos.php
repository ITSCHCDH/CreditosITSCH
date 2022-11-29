<?php

use Illuminate\Database\Seeder;

class GenerarAlumnos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $alumnos = factory(App\Models\Alumno::class,500)->create();
    }
}
