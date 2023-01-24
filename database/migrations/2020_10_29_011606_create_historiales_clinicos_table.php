<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialesClinicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historiales_clinicos', function (Blueprint $table) {
            $table->id();
            $table->integer('id_alu')->unsigned()->nullable();
            $table->string('hipertension', 50)->nullable();
            $table->string('enfermedad', 5)->nullable();
            $table->string('diabetes', 50)->nullable();
            $table->string('epilepsia', 50)->nullable();
            $table->string('anorexia', 50)->nullable();
            $table->string('bulimia', 50)->nullable();
            $table->string('sexual', 100)->nullable();
            $table->string('depresion', 50)->nullable();
            $table->string('tristeza', 50)->nullable();
            $table->string('otra_enf', 50)->nullable();
            $table->string('cap_dif', 5)->nullable();
            $table->string('vista', 10)->nullable();
            $table->string('lenguaje', 10)->nullable();
            $table->string('oido', 10)->nullable();
            $table->string('motora', 10)->nullable();
            $table->string('otra_dis', 10)->nullable();
            $table->double('estatura')->nullable();
            $table->double('peso')->nullable();
            $table->char('sangre', 3)->nullable();
            $table->string('serv_med', 20)->nullable();
            $table->string('dia_psico', 50)->nullable();
            $table->string('cuanto_psico', 50)->nullable();
            $table->string('dia_med', 50)->nullable();
            $table->string('cuanto_med', 50)->nullable();
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
        Schema::dropIfExists('historiales_clinicos');
    }
}
