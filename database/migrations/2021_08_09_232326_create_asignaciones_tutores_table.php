<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsignacionesTutoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asignaciones_tutores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('gtu_grupo',60)->nullable(false);
            $table->string('tut_clave', 60)->nullable(false);
            $table->bigInteger('gtu_tipo')->nullable();
            $table->integer('gtu_semestre')->nullable();
            $table->string('gtu_año', 4)->nullable();
            $table->string('gtu_observaciones', 255)->nullable();            
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
        Schema::dropIfExists('asignaciones_tutores');
    }
}
