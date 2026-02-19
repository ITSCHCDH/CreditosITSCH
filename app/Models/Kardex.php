<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kardex extends Model
{
     protected $table = 'kardex';
    
    protected $fillable = [
        'no_control',
        'materia_clave',
        'semestre',        
        'anio',
        'calificacion_final',
        'opcion_acreditacion',
        'situacion'       
    ];
    
    protected $casts = [
        'calificacion_final' => 'decimal:2'        
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
     
    
    public function getAcreditadaAttribute()
    {
        return $this->situacion === 'ACREDITADA';
    }
    
    // Scopes útiles
    public function scopeAcreditadas($query)
    {
        return $query->where('situacion', 'ACREDITADA');
    }
    
    public function scopePorPeriodo($query, $periodo)
    {
        return $query->where('periodo', $periodo);
    }
    
    public function scopePorSemestre($query, $semestre)
    {
        return $query->where('semestre', $semestre);
    }
}
