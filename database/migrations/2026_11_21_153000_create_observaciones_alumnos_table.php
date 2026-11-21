<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * SIT es solo de consulta: las observaciones que edita STA se guardan en
 * creditos, asociadas por número de control.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('observaciones_alumnos')) {
            return;
        }

        Schema::create('observaciones_alumnos', function (Blueprint $table) {
            $table->id();
            $table->string('no_control', 20)->unique();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('observaciones_alumnos');
    }
};
