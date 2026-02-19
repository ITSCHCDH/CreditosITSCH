<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
   protected $table = 'materias';
    
    protected $fillable = [
        'materia_clave',
        'materia_nombre',
        'materia_nombre_corto',
        'carrera_clave',        
        'semestre',
        'plan_clave',
        'departamento_clave',      
        'num_unidades',        
        'activa',
        'fecha_baja',
        'estatus',
        'observaciones'
    ];
    
    protected $casts = [
        'activa' => 'boolean',
        'fecha_baja' => 'date',
        'creditos' => 'integer',
        'num_unidades' => 'integer',
        'semestre' => 'integer'
    ];
    
    // Relaciones
    public function kardex()
    {
        return $this->hasMany(Kardex::class, 'materia_clave', 'materia_clave');
    }
    
    public function calificacionesTemas()
    {
        return $this->hasMany(Listas::class, 'materia_clave', 'materia_clave');
    }
    
    // Scope para materias activas
    public function scopeActivas($query)
    {
        return $query->where('activa', true);
    }
    
    // Scope por carrera
    public function scopePorCarrera($query, $carreraClave)
    {
        return $query->where('carrera_clave', $carreraClave);
    }
    
    // Scope por semestre
    public function scopePorSemestre($query, $semestre)
    {
        return $query->where('semestre', $semestre);
    }
    
    // Scope por tipo
    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo_materia', $tipo);
    }      
   
}
