<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Paciente;
use App\User;

class Cita extends Model
{
    use HasFactory;

    //Nombre de la tabla
    protected $table="citas";

    //Campos asignables en masa
    protected $fillable=[
        'paciente_id',        
        'fecha_cita',
        'hora_cita',
        'motivo_consulta',
        'estado_cita'
    ];   
    
     /**
     * Relación con el médico (usuario)
     */
    public function medico()
    {
        return $this->belongsTo(User::class, 'medico_id');
    }
    
    //Definición de relaciones
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }
}
