<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEvidencia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evidencia', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status',35);
            $table->string('nom_imagen');
            $table->string('valida',20);
            $table->integer('id_asig_actividades')->unsigned();
            $table->string('alumno_no_control',20)->nullable();
            $table->string('slug')->nullable();
            $table->foreign('alumno_no_control')->references('no_control')->on('alumnos');
            $table->foreign('id_asig_actividades')->references('id')->on('actividad_evidencia')->ondelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evidencia');
    }
}
