<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social', function (Blueprint $table) {
            $table->id();
            $table->integer('id_alu')->unsigned()->nullable();
            $table->string('rel_comp', 50)->nullable();
            $table->string('comp_por', 50)->nullable();
            $table->string('rel_amig', 50)->nullable();
            $table->string('amig_por', 50)->nullable();
            $table->string('pareja', 50)->nullable();
            $table->string('rel_prof', 50)->nullable();
            $table->string('prof_por', 50)->nullable();
            $table->string('rel_auto_ac', 50)->nullable();
            $table->string('auto_ac_por', 50)->nullable();
            $table->string('tiempo_lib', 50)->nullable();
            $table->string('recreativa', 50)->nullable();
            $table->string('planes_in', 50)->nullable();
            $table->string('metas_vida', 50)->nullable();
            $table->string('yo_soy', 50)->nullable();
            $table->string('caracter', 50)->nullable();
            $table->string('me_gusta', 50)->nullable();
            $table->string('aspiraciones', 50)->nullable();
            $table->string('miedo', 50)->nullable();
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
        Schema::dropIfExists('social');
    }
}
