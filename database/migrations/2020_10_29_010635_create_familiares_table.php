<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamiliaresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('familiares', function (Blueprint $table) {
            $table->id();
            $table->integer('id_alu')->unsigned()->nullable();
            $table->string('nombre', 60)->nullable();
            $table->integer('edad')->nullable();
            $table->string('parentesco', 30)->nullable();
            $table->string('escolaridad', 30)->nullable();
            $table->enum('relacion', ['Buena', 'Regular', 'Mala'])->nullable();
            $table->timestamps();

            $table->foreign('id_alu', 'familiares_id_alu_foreign')->references('id')->on('alumnos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('familiares');
    }
}
