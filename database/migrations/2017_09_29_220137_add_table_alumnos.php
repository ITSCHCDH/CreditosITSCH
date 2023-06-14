<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableAlumnos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumnos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('no_control',20)->unique();
            $table->string('password',255);
            $table->integer('carrera')->unsigned();
            $table->string('status',35);
            $table->string('foto',30);
            $table->string('email',35);           
            $table->integer('ficha')->nullable();
            $table->string('nombre_i', 30)->nullable();
            $table->string('a_pat', 30)->nullable();
            $table->string('a_mat', 30)->nullable();          
            $table->integer('creditos')->nullable();//Revisar si se puede usar                    
            $table->date('fec_nac')->nullable();
            $table->string('lug_pro', 70)->nullable();
            $table->char('curp', 18)->nullable()->unique('alumnos_curp_unique');
            $table->enum('sexo', ['f', 'm'])->nullable();
            $table->string('est_civ', 30)->nullable();
            $table->string('tel', 13)->nullable();
            $table->string('tel_emer', 13)->nullable();
            $table->string('beca', 100)->nullable();
            $table->string('grupo', 10)->nullable();           
            $table->string('nom_ficha', 100)->nullable();
            $table->integer('generacion')->nullable();
            $table->string('observaciones', 500)->nullable();
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
        Schema::dropIfExists('alumnos');
    }
}
