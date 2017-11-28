<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    //Nombre de la tabla
    protected $table="nom_actividad";
    //Datos visibles para los objetos json
    protected $fillable=['nombre','por_cred_actividad','id_actividad'];

    //Relacion con la tablas de actividad(uno) - evidencia(muchos)
    public function evidencias()
    {
        return $this->hasMany('App\Evidencia');
    }

    //Relacion con la tablas de credito(uno) - Actividades(muchos)
    public function credito()
    {
        //Agregamos el campo id_actividad ya que es el campo que enlaza con la tabla creditos, para hacer la busqueda
        return $this->belongsTo('App\Credito','id_actividad');
    }

    //Crea el bucador de actividades (Scope)
    public function scopeSearch($query,$nombre)
    {
        return $query->where('nombre','LIKE',"%$nombre%");
    }
}
