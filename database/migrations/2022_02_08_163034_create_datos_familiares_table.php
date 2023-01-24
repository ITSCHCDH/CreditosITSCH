<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatosFamiliaresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datos_familiares', function (Blueprint $table) {
            $table->id();
            $table->integer('id_alu')->unsigned()->nullable();
            $table->string('dificultades', 50)->nullable();
            $table->string('ligado', 50)->nullable();
            $table->string('ligado_por', 50)->nullable();
            $table->string('edu', 50)->nullable();
            $table->string('carrera', 50)->nullable();
            $table->string('otro_dato', 50)->nullable();
            $table->timestamps();

            $table->foreign('id_alu')->references('id')->on('alumnos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('datos_familiares');
    }
}
