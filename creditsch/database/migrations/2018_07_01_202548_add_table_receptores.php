<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableReceptores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receptores', function(Blueprint $table){
            $table->increments('id');
            $table->integer('mensaje_id')->unsigned();
            $table->integer('user_id')->nullable()->unsigned();
            $table->string('alumno_no_control',20)->nullable();
            $table->enum('visto',['true','false'])->default('false');
            $table->dateTime('fecha_visto')->nullable();
            $table->foreign('mensaje_id')->references('id')->on('mensajes')->ondelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->ondelete('cascade');
            $table->foreign('alumno_no_control')->references('no_control')->on('alumnos');
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
        Schema::dropIfExists('receptores');
    }
}
