<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMotivosreprobacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('motivosreprobacion', function (Blueprint $table) {
            $table->id();
            $table->string('no_control',15)->nullable(false);
            $table->string('materia',45)->nullable(false);
            $table->char('grup_cla',10)->nullable(false);
            $table->integer('lse_clave')->nullable(false);
            $table->integer('num_tema')->nullable(false);
            $table->enum('motivos',['1','2','3','4'])->nullable(false);
            $table->string('comentario',500)->nullable();
           
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
        Schema::dropIfExists('motivosreprobacion');
    }
}
