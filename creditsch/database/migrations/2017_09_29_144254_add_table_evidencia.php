<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableEvidencia extends Migration
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
            $table->integer('status');
            $table->string('nom_imagen');
            $table->string('responsable',20);
            $table->string('valida',20);
            $table->integer('id_nom_actividad')->unsigned();
            $table->string('slug')->nullable();

            $table->foreign('id_nom_actividad')->references('id')->on('nom_actividad')->ondelete('cascade');

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
