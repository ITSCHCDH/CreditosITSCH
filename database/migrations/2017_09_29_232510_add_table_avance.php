<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableAvance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avance', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_control',20);
            $table->integer('id_credito')->unsigned();
            $table->integer('por_credito');
            $table->foreign('no_control')->references('no_control')->on('alumnos');
            $table->foreign('id_credito')->references('id')->on('creditos');

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
        Schema::dropIfExists('avance');
    }
}
