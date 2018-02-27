<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableActividad extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actividad', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',250);
            $table->integer('por_cred_actividad');
            $table->integer('id_actividad')->unsigned();

            $table->foreign('id_actividad')->references('id')->on('creditos')->ondelete('cascade');

            $table->timestamps();
        });


        //Tabla para relacion pivote, muchos a muchos, nombre actividad_evidencia en singular compuesto pos las dos tablas que forman la relacion.
        //Podemos crear mas tablas en una misma relación, como esta:
        Schema::create('actividad_evidencia',function (Blueprint $table){
            $table->increments('id');
            $table->integer('actividad_id')->unsigned();
            $table->integer('user_id')->unsigned();

            //Llaves foraneas de la relacion
            $table->foreign('actividad_id')->references('id')->on('actividad')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('actividad');
    }
}
