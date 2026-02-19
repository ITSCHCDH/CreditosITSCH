<?php
// app/Models/CalificacionTema.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalificacionTema extends Model
{
    protected $table = 'listas';
    
    protected $fillable = [
        'no_control', 
        'materia_clave', 
        'catedratico_clave',
        'grupo_clave', 
        'anio', 
        'periodo',
        'num_tema',       
        'calificacion'       
    ];
    
    // Relaciones
    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'no_control', 'no_control');
    }
    
    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_clave', 'materia_clave');
    }
    
    public function catedratico()
    {
        return $this->belongsTo(Catedratico::class, 'catedratico_clave', 'catedratico_clave');
    }
    
    // Accessor para formatear calificación
    public function getCalificacionFormateadaAttribute()
    {
        return number_format($this->calificacion, 2);
    }
}