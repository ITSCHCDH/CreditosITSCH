<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Credito extends Model
{
    //Nombre de la tabla
    protected $table="nom_creditos";
    //Datos visibles para los objetos json
    protected $fillable=['nombre'];

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
