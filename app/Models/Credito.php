<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Credito extends Model
{
    //Nombre de la tabla
    protected $table="creditos";
    //Datos visibles para los objetos json
    protected $fillable=['nombre','credito_jefe','vigente'];

    //Relacion con la tablas de credito(uno) - Actividades(muchos)
    public function actividades()
    {
        return $this->hasMany('App\Actividad');
    }

    //Relacion con la tablas de credito(uno) - Avances(muchos)
    public function avances()
    {
        return $this->hasMany('App\Avance');
    }


}
