<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Storage;
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
            $table->string('nom_imagen');
            $table->integer('id_asig_actividades')->unsigned();
            $table->string('alumno_no_control',20)->nullable();
            $table->string('nom_original', 128)->nullable();
            $table->foreign('alumno_no_control')->references('no_control')->on('alumnos');
            $table->foreign('id_asig_actividades')->references('id')->on('actividad_evidencia')->ondelete('cascade');
            $table->timestamps();
        });
        Storage::makeDirectory('public/evidencias');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evidencia');
        Storage::deleteDirectory('public/evidencias');
    }
}
