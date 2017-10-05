<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    //Nombre de la tabla
    protected $table="nom_actividad";
    //Datos visibles para los objetos json
    protected $fillable=['nom_actividad','por_cred_actividad','id_actividad'];

    //Relacion con la tablas de actividad(uno) - evidencia(muchos)
    public function evidencias()
    {
        return $this->hasMany('App\Evidencia');
    }

    //Relacion con la tablas de credito(uno) - Actividades(muchos)
    public function credito()
    {
        return $this->belongsTo('App\Credito');
    }

}
