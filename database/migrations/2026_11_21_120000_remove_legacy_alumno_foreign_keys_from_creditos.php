<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $foreignKeys = [
        'avance' => 'avance_no_control_foreign',
        'constancia_folios' => 'constancia_folios_no_control_foreign',
        'evidencia' => 'evidencia_alumno_no_control_foreign',
        'participantes' => 'participantes_no_control_foreign',
        'datos_familiares' => 'datos_familiares_id_alu_foreign',
        'familiares' => 'familiares_id_alu_foreign',
        'padres' => 'padres_id_alu_foreign',
        'personales' => 'personales_id_alu_foreign',
        'historiales_clinicos' => 'historiales_clinicos_id_alu_foreign',
        'social' => 'social_id_alu_foreign',
    ];

    public function up(): void
    {
        $database = DB::getDatabaseName();

        foreach ($this->foreignKeys as $table => $constraint) {
            if (! Schema::hasTable($table)) {
                continue;
            }

            $exists = DB::table('information_schema.TABLE_CONSTRAINTS')
                ->where('CONSTRAINT_SCHEMA', $database)
                ->where('TABLE_NAME', $table)
                ->where('CONSTRAINT_NAME', $constraint)
                ->exists();

            if ($exists) {
                DB::statement("ALTER TABLE `{$table}` DROP FOREIGN KEY `{$constraint}`");
            }
        }
    }

    public function down(): void
    {
        // Re-vincular a creditos.alumnos volvería a acoplar el sistema al esquema eliminado.
    }
};
