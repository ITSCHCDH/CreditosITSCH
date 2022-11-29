<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMomentoAgregadoAndEvidenciaValidadaColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('participantes', function (Blueprint $table) {
            $table->enum('momento_agregado',['anteriormente','posteriormente'])->default('anteriormente')->after('no_control');
            $table->enum('evidencia_validada',['na','no','si'])->default('na')->after('no_control');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('participantes', function (Blueprint $table) {
            //
        });
    }
}
