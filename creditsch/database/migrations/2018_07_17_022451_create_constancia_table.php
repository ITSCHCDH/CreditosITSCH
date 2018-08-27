<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Storage;

class CreateConstanciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('constancia',function(Blueprint $table){
            $table->increments('id');
            $table->string('profesion_jefe_division',20);
            $table->integer('jefe_division')->unsigned();
            $table->string('division_enunciado');//enuciado que aparece despues del jefe de division (DIV.DE ING.SIST.COMP)
            $table->integer('carrera')->nullable()->unsigned();
            $table->foreign('jefe_division')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('carrera')->references('id')->on('areas')->onDelete('cascade');
            $table->timestamps();

        });

        Schema::create('constancia_complemento', function(Blueprint $table){
            $table->increments('id');
            $table->string('profesion_jefe_depto',20);//Abreviatura de la profesion Ejem: LIC, ISC
            $table->integer('jefe_depto')->unsigned();//Jefe de departamento
            $table->string('jefe_depto_enunciado');//Ejem: Jefe de depto. de servicios escolares

            $table->string('profesion_certificador',20);
            $table->integer('certificador')->unsigned();//Nombre de quien certifica el documento A.K.A VoBo
            $table->string('certificador_enunciado');//Puesto/posicion de quien certifica
            $table->string('imagen_encabezado');
            $table->string('imagen_pie');
            $table->string('plan_de_estudios'); // El plan de estudios ISIC-2010-224
            $table->integer('numero_oficio');
            $table->foreign('jefe_depto')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('certificador')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
        Storage::makeDirectory('public/constancia_imagenes');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('constancia');
        Schema::dropIfExists('constancia_complemento');
        Storage::deleteDirectory('public/constancia_imagenes');
    }
}
