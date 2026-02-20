<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Catedratico extends Model
{
    protected $table = 'catedraticos';
    
    protected $fillable = [
        'catedratico_clave',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'titulo',        
        'departamento_clave',        
        'email',      
        'celular',       
        'fecha_ingreso',
        'fecha_baja',       
        'estatus',        
        'observaciones'
    ];
    
    protected $casts = [
        'fecha_ingreso' => 'date',
        'fecha_baja' => 'date'        
    ];
    
    // Relaciones
    public function calificacionesTemas()
    {
        return $this->hasMany(Listas::class, 'profesor_clave', 'profesor_clave');
    }
    
    // Scope para profesores activos
    public function scopeActivos($query)
    {
        return $query->where('estatus', 'ACTIVO');
    }

    // Scope por departamento
    public function scopePorDepartamento($query, $departamentoClave)
    {
        return $query->where('departamento_clave', $departamentoClave);
    }  
    
    public function getNombreTituloAttribute()
    {
        $nombre = $this->nombre_completo;
        if ($this->titulo) {
            $nombre = "{$this->titulo}. {$nombre}";
        }
        return $nombre;
    }
    
    public function getNombreFormalAttribute()
    {
        $partes = [];
        if ($this->apellido_paterno) $partes[] = $this->apellido_paterno;
        if ($this->apellido_materno) $partes[] = $this->apellido_materno;
        $partes[] = $this->nombre;
        
        $nombre = implode(' ', $partes);
        
        if ($this->titulo) {
            $nombre = "{$this->titulo}. {$nombre}";
        }
        
        return $nombre;
    }    

}
