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
            $table->integer('id_user')->unsigned();
            $table->integer('id_actividad')->unsigned();
            $table->enum('alumnos',['true','false']);
            $table->foreign('id_user')->references('id')->on('users')->ondelete('cascade');
            $table->foreign('id_actividad')->references('id')->on('creditos')->ondelete('cascade');
            $table->timestamps(); 
        });


        //Tabla para relacion pivote, muchos a muchos, nombre actividad_evidencia en singular compuesto pos las dos tablas que forman la relacion.
        //Podemos crear mas tablas en una misma relación, como esta:
        Schema::create('actividad_evidencia',function (Blueprint $table){
            $table->increments('id');
            $table->integer('actividad_id')->unsigned();
            $table->integer('user_id')->unsigned();
            //Nuevos campos para falicitar el manejo de quien valida y validacion de las evidencias
            $table->integer('validador_id')->nullable()->unsigned();
            $table->enum('validado',['true','false'])->default('false');
            //Llaves foraneas de la relacion
            $table->foreign('actividad_id')->references('id')->on('actividad')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('validador_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('actividad_evidencia');
        Schema::dropIfExists('actividad');
    }
}
