<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kardex', function (Blueprint $table) {
            $table->id();
            // Relación con alumno (tabla alumnos)
            $table->string('no_control', 20);
            
            // Relación con materia (tabla materias)
            $table->string('materia_clave', 20);
            
            // Datos académicos
            $table->integer('semestre');           
            $table->integer('anio');

            // Datos del catedratico que impartió la materia           
            $table->integer('catedratico_clave')->nullable();
            
            // CALIFICACIÓN FINAL de la materia
            $table->decimal('calificacion_final', 4, 2);
            
            // OPCIÓN DE ACREDITACIÓN
            $table->enum('opcion_acreditacion', [
                'ORDINARIA',      // Cursada en periodo normal
                'ORDINARIA COMPLEMENTO', // Periodo de recuperación de ordinario
                'REPETICIÓN',       // Cursada por segunda vez
                'REPETICIÓN COMPLEMENTO',         // Periodo de recuperación de repetición
                'EXTRAORDINARIO',  // Cursada en examen extraordinario
                'EXTRAORDINARIO COMPLEMENTO',  // Periodo de recuperación de extraordinario
                'CURSADO',        // Cursada pero sin acreditar?
            ])->default('ORDINARIA');
            
            // Situación de la materia
            $table->enum('situacion', [
                'ACREDITADA',
                'NO ACREDITADA',
                'CURSANDO',
                'BAJA',
                'EQUIVALENCIA'
            ])->default('CURSANDO');                   
            
            $table->timestamps();
            
            // Índices para búsquedas
            $table->index('no_control');
            $table->index('materia_clave');            
            $table->index('semestre');
            $table->index('situacion');
            
            // Foreign keys
            $table->foreign('no_control')
                  ->references('no_control') // Ajusta según tu columna real
                  ->on('alumnos')
                  ->onDelete('restrict');
                  
            $table->foreign('materia_clave')
                  ->references('materia_clave') // Ajusta según tu columna real
                  ->on('materias')
                  ->onDelete('restrict');

            $table->foreign('catedratico_clave')
                  ->references('catedratico_clave') // Ajusta según tu columna real
                  ->on('catedraticos')
                  ->onDelete('restrict');
            
            // Evitar duplicados (un alumno no puede tener dos registros de la misma materia en el mismo periodo)
            $table->unique(['no_control', 'materia_clave', 'semestre', 'anio'], 'kardex_unico');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kardex');
    }
};
