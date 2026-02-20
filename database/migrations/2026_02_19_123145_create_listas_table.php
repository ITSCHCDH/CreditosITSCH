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
        Schema::create('listas', function (Blueprint $table) {
            $table->id();           
            // Relación con alumno (tabla alumnos)
            $table->string('no_control', 20);
            
            // Relación con materia (tabla materias)
            $table->string('materia_clave', 20);
            
            // Relación con profesor (tabla catedraticos)
            $table->integer('catedratico_clave');
            
            // Datos del grupo/periodo
            $table->string('grupo_clave', 30);
            $table->integer('anio');
            $table->string('periodo', 10); // Ej: 2024A, 2024B
            
            // Datos del tema/unidad
            $table->integer('num_tema'); // 1, 2, 3, 4, 5...           
            
            // LA CALIFICACIÓN DEL TEMA
            $table->decimal('calificacion', 4, 2);
          
            // Índices para búsquedas rápidas
            $table->index('no_control');
            $table->index('materia_clave');
            $table->index('catedratico_clave');
            $table->index('grupo_clave');
            
            // Foreign keys (asumiendo nombres de columnas en tus tablas)
            $table->foreign('no_control')
                  ->references('no_control') // Ajusta según tu columna real
                  ->on('alumnos')
                  ->onDelete('restrict');
                  
            $table->foreign('materia_clave')
                  ->references('materia_clave') // Ajusta según tu columna real
                  ->on('materias')
                  ->onDelete('restrict');
                  
            $table->foreign('catedratico_clave')
                  ->references('catedratico_clave') // Ajusta según tu columna real (cat_Clave?)
                  ->on('catedraticos')
                  ->onDelete('restrict');
            
            // Evitar duplicados (un alumno no puede tener dos calificaciones del mismo tema en el mismo grupo)
            $table->unique(['no_control', 'materia_clave', 'grupo_clave', 'num_tema', 'periodo'], 'calificacion_unica');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listas');
    }
};
