<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableParticipantes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participantes', function(Blueprint $table) {
            $table->increments('id');
            $table->string('no_control',20);
            $table->integer('id_evidencia')->unsigned();
            $table->foreign('no_control')->references('no_control')->on('alumnos');
            $table->foreign('id_evidencia')->references('id')->on('actividad_evidencia')->ondelete('cascade');
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
        Schema::dropIfExists('participantes');
    }
}
