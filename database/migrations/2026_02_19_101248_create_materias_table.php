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
        Schema::create('materias', function (Blueprint $table) {
           $table->id();
            
            // Identificador único de la materia
            $table->string('materia_clave', 20)->unique();
            
            // Nombre de la materia
            $table->string('materia_nombre', 255);
            $table->string('materia_nombre_corto', 50)->nullable();
            
            // Clasificación académica
            $table->string('carrera_clave', 20); // Clave de la carrera a la que pertenece           
            $table->integer('semestre'); // Semestre en que se cursa
            $table->string('plan_clave', 20); // Clave del plan de estudios
            
            // Departamento que la imparte
            $table->string('departamento_clave', 20);
            $table->string('departamento_nombre', 255)->nullable();
            
            // Créditos y horas
            $table->integer('creditos')->default(0);           
            
            // Información de unidades/temas
            $table->integer('num_unidades')->default(5); // Número de unidades que tiene la materia
                        
            // Campos de control
            $table->boolean('activa')->default(true); // Si la materia está vigente
            $table->date('fecha_baja')->nullable(); // Si se dio de baja
            $table->string('estatus', 20)->default('VIGENTE'); // VIGENTE, BAJA, SUSPENDIDA
            
            $table->text('observaciones')->nullable();
            $table->timestamps();
            
            // Índices para búsquedas rápidas
            $table->index('materia_clave');
            $table->index('materia_nombre');
            $table->index('carrera_clave');
            $table->index('departamento_clave');
            $table->index('semestre');
            $table->index('plan_clave');            
            $table->index('estatus');
            
            // Índice compuesto para búsquedas comunes
            $table->index(['carrera_clave', 'semestre', 'activa']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materias');
    }
};
