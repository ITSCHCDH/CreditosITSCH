<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\Cita;

class Paciente extends Model
{
    use HasFactory;
     //Nombre de la tabla
    protected $table="pacientes";

    //Campos asignables en masa
    protected $fillable=[
        'user_id',
        'tipo',
        'edad',
        'alergias',
        'enfermedades_cronicas',
        'medicamentos_actuales',
        'contacto_emergencia',
        'telefono_emergencia',
    ];  
    //Definición de relaciones
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function citas()
    {
        return $this->hasMany(Cita::class, 'paciente_id');
    }

}
