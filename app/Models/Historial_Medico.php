<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historial_Medico extends Model
{
    use HasFactory;
    //Nombre de la tabla
    protected $table = 'historiales_medicos';
    protected $fillable = [
        'paciente_id',
        'cita_id',
        'antecedentes',
        'diagnosticos',
        'tratamientos',       
        'notas_adicionales',
        'semaforo'
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
    public function cita()
    {
        return $this->belongsTo(Cita::class);
    }
}
