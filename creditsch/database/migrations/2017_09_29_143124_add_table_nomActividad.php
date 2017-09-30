<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableNomActividad extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nom_actividad', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('nom_actividad');
            $table->integer('por_cred_actividad');
            $table->integer('id_actividad')->unsigned();

            $table->foreign('id_actividad')->references('id')->on('nom_creditos')->ondelete('cascade');

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
        Schema::dropIfExists('nom_actividad');
    }
}
