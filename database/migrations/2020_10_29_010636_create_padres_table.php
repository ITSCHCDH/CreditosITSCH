<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePadresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('padres', function (Blueprint $table) {
            $table->id();
            $table->integer('id_alu')->unsigned()->nullable();
            $table->string('nombre', 60)->nullable();
            $table->integer('edad')->nullable();
            $table->string('tel', 13)->nullable();
            $table->string('parentesco', 30)->nullable();
            $table->string('ocupacion', 30)->nullable();
            $table->string('profesion', 50)->nullable();
            $table->timestamps();

            $table->foreign('id_alu')->references('id')->on('alumnos')->onDelete('cascade');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('padres');
    }
}
