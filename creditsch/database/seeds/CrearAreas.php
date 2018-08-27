<?php

use Illuminate\Database\Seeder;
use App\Area;

class CrearAreas extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	//Carreras
        $area = new Area();
        $area->nombre = "Ingeniería en Sistemas Computacionales";
        $area->tipo = "carrera";
        $area->save();

        $area = new Area();
        $area->nombre = "Ingeniería en Tecnologías de la Información y Comunicaciones";
        $area->tipo = "carrera";
        $area->save();

        $area = new Area();
        $area->nombre = "Ingeniería en Nanotecnología";
        $area->tipo = "carrera";
        $area->save();

        $area = new Area();
        $area->nombre = "Ingeniería Industrial";
        $area->tipo = "carrera";
        $area->save();

        $area = new Area();
        $area->nombre = "Ingeniería en Gestión Empresarial";
        $area->tipo = "carrera";
        $area->save();

        $area = new Area();
        $area->nombre = "Ingeniería Mecatrónica";
        $area->tipo = "carrera";
        $area->save();

        $area = new Area();
        $area->nombre = "Ingeniería Bioquímica";
        $area->tipo = "carrera";
        $area->save();

        //Otras areas diferentes a las de carrera

        $area = new Area();
        $area->nombre = "Ciencias Básicas";
        $area->tipo = "otro";
        $area->save();

        $area = new Area();
        $area->nombre = "Tutorías";
        $area->tipo = "otro";
        $area->save();

        $area = new Area();
        $area->nombre = "Extensión Educativa";
        $area->tipo = "otro";
        $area->save();

        $area = new Area();
        $area->nombre = "Dirección Academica";
        $area->tipo = "otro";
        $area->save();

        $area = new Area();
        $area->nombre = "Vinculación";
        $area->tipo = "otro";
        $area->save();

        $area = new Area();
        $area->nombre = "Clubes";
        $area->tipo = "otro";
        $area->save();

    }
}
