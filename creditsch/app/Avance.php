<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
        return $this->belongsTo('App\Alumno');
    }
}
