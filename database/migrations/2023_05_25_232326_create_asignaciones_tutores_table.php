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
            $table->id();
            $table->bigInteger('gpo_Id')->unsigned()->nullable();
            $table->integer('tut_Clave')->nullable(false);
            $table->string('gtu_Tipo',35)->nullable();
            $table->string('gtu_Semestre',15)->nullable();
            $table->string('gtu_Año', 4)->nullable();
            $table->string('gtu_Observaciones', 255)->nullable();   
            $table->foreign('gpo_Id')->references('id')->on('grupos')->ondelete('cascade');                          
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
