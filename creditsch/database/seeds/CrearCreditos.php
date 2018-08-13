<?php

use Illuminate\Database\Seeder;
use App\Credito;

class CrearCreditos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $credito = new Credito();
        $credito->nombre = "Clubes";
        $credito->save();

		$credito = new Credito();
		$credito->nombre = "Tutorías";
		$credito->save();

		$credito = new Credito();
		$credito->nombre = "Concursos";
		$credito->save();

		$credito = new Credito();
		$credito->nombre = "Congresos y Jornadas";
		$credito->save();

		$credito = new Credito();
		$credito->nombre = "Comunitario";
		$credito->save();        
    }
}
