<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $foreignKeys = [
        'participantes' => 'participantes_no_control_foreign',
        'avance' => 'avance_no_control_foreign',
        'evidencia' => 'evidencia_alumno_no_control_foreign',
        'constancia_folios' => 'constancia_folios_no_control_foreign',
        'familiares' => 'familiares_id_alu_foreign',
        'padres' => 'padres_id_alu_foreign',
        'historiales_clinicos' => 'historiales_clinicos_id_alu_foreign',
        'datos_familiares' => 'datos_familiares_id_alu_foreign',
        'personales' => 'personales_id_alu_foreign',
        'social' => 'social_id_alu_foreign',
    ];

    private array $bridgedTables = [
        'familiares',
        'padres',
        'historiales_clinicos',
        'datos_familiares',
        'personales',
        'social',
        'pacientes',
    ];

    public function up(): void
    {
        $connection = Schema::connection('creditos');

        if (! $connection->hasTable('alumno_creditos_perfil')) {
            $connection->create('alumno_creditos_perfil', function (Blueprint $table) {
                $table->id();
                $table->string('no_control', 20)->unique();
                $table->string('estatus_creditos', 35)->default('pendiente');
                $table->boolean('ficha_completada')->default(false);
                $table->string('foto', 100)->nullable();
                $table->text('observaciones_tutoria')->nullable();
                $table->integer('sem_med')->nullable();
                $table->text('observaciones_med')->nullable();
                $table->integer('sem_psic')->nullable();
                $table->text('observaciones_psic')->nullable();
                $table->timestamps();
            });
        }

        $database = DB::connection('creditos')->getDatabaseName();
        $driver = DB::connection('creditos')->getDriverName();

        foreach ($this->foreignKeys as $table => $constraint) {
            if (! $connection->hasTable($table) || $driver !== 'mysql') {
                continue;
            }

            $exists = DB::connection('creditos')
                ->table('information_schema.TABLE_CONSTRAINTS')
                ->where('CONSTRAINT_SCHEMA', $database)
                ->where('TABLE_NAME', $table)
                ->where('CONSTRAINT_NAME', $constraint)
                ->where('CONSTRAINT_TYPE', 'FOREIGN KEY')
                ->exists();

            if ($exists) {
                DB::connection('creditos')->statement(
                    "ALTER TABLE `{$table}` DROP FOREIGN KEY `{$constraint}`"
                );
            }
        }

        foreach ($this->bridgedTables as $table) {
            if (! $connection->hasTable($table) || $connection->hasColumn($table, 'no_control')) {
                continue;
            }

            $connection->table($table, function (Blueprint $blueprint) {
                $blueprint->string('no_control', 20)->nullable()->index();
            });
        }
    }

    public function down(): void
    {
        $connection = Schema::connection('creditos');

        foreach ($this->bridgedTables as $table) {
            if ($connection->hasTable($table) && $connection->hasColumn($table, 'no_control')) {
                $connection->table($table, function (Blueprint $blueprint) {
                    $blueprint->dropColumn('no_control');
                });
            }
        }

        $connection->dropIfExists('alumno_creditos_perfil');
    }
};
