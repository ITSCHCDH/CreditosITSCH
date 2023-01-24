<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDireccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direcciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_alu')->nullable();
            $table->unsignedBigInteger('id_fam')->nullable();
            $table->string('direccion', 70)->nullable();
            $table->string('colonia', 50)->nullable();
            $table->integer('cp')->nullable();
            $table->string('municipio', 50)->nullable();
            $table->string('estado', 25)->nullable();
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
        Schema::dropIfExists('direcciones');
    }
}
