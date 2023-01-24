<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personales', function (Blueprint $table) {
            $table->id();
            $table->integer('id_alu')->unsigned()->nullable();
            $table->string('trab', 50)->nullable();
            $table->string('casa', 50)->nullable();
            $table->integer('num_person')->nullable();
            $table->string('parentesco', 50)->nullable();
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
        Schema::dropIfExists('personales');
    }
}
