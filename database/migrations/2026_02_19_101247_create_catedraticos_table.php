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
        Schema::create('catedraticos', function (Blueprint $table) {
            $table->id();
            
            // Identificador único del profesor
            $table->integer('catedratico_clave')->unique();
            
            // Datos personales
            $table->string('nombre', 100);
            $table->string('apellido_paterno', 100);
            $table->string('apellido_materno', 100)->nullable();
            
            // Datos profesionales
            $table->string('titulo', 50)->nullable(); // Dr., Mtro., Ing., Lic., etc.
            $table->string('cedula_profesional', 50)->nullable();           
            
            // Adscripción
            $table->string('departamento_clave', 20);           
            
            // Contacto
            $table->string('email', 255)->nullable();
            $table->string('email_institucional', 255)->nullable();            
            $table->string('celular', 20)->nullable();
                      
            $table->date('fecha_ingreso')->nullable();
            $table->date('fecha_baja')->nullable();
                                  
            $table->string('estatus', 20)->default('ACTIVO'); // ACTIVO, BAJA, LICENCIA, JUBILADO            
            
            $table->text('observaciones')->nullable();
            $table->timestamps();
            
            // Índices para búsquedas rápidas
            $table->index('catedratico_clave');
            $table->index('nombre');
            $table->index('apellido_paterno');
            $table->index('apellido_materno');
            $table->index('departamento_clave');
            $table->index('estatus'); 
            
            // Índice compuesto para búsqueda por nombre completo
            $table->index(['apellido_paterno', 'apellido_materno', 'nombre']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catedraticos');
    }
};
