<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{ 
    //Nombre de la tabla
    protected $table="actividad";
    //Datos visibles para los objetos json
    protected $fillable=[
        'nombre','por_cred_actividad','id_actividad','id_user','alumnos','vigente'
    ];

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
        return $query->where('actividad.nombre','LIKE',"%$nombre%");
    }
    //Relacion mucho a muchos una actividad puede terner mucho responsables y un resposables puede tener muchas actividades
    public function users(){
        return $this->belongsToMany('App\User','actividad_evidencia')->withTimestamps();
    }
    //Relacion muchos a uno un usuario puede tener muchas actividades creadas pero un actividad solo puede tener un creador
    public function creador(){
        return $this->belongsTo('App\User','id_user');
    }
}
