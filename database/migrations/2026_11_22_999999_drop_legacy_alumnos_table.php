<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $creditos = Schema::connection('creditos');

        if ($creditos->hasTable('alumno_creditos_perfil')) {
            $creditos->dropIfExists('alumnos');
        }
    }

    public function down(): void
    {
        // No recrear la tabla legacy. Restaurarla, si fuera indispensable, únicamente desde
        // backup_creditos_antes_migracion.sql previo al corte; sit.alumnos sigue siendo la fuente única de verdad.
    }
};
