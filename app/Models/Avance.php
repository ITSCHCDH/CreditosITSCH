<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sit\Alumno as SitAlumno;

class Avance extends Model
{
    //Nombre de la tabla
    protected $table="avance";
    //Datos visibles para los objetos json
    protected $fillable=['no_control','id_credito','por_credito'];

    //Relacion con la tablas de credito(uno) - Avances(muchos)
    public function credito()
    {
        return $this->belongsTo('App\Credito');
    }

    //Relacion con la tablas de alumno(uno) a Avances(muchos)
    public function alumno()
    {
        return $this->belongsTo(SitAlumno::class, 'no_control', 'no_control');
    }

    public function perfilCreditos()
    {
        return $this->belongsTo(
            \App\Models\AlumnoCreditosPerfil::class,
            'no_control',
            'no_control'
        );
    }
}
