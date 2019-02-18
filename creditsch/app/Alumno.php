<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Alumno extends Authenticatable
{
    use Notifiable;
    //Nombre de la tabla
    protected $table="alumnos";
    //Datos visibles para los objetos json
    protected $fillable=['no_control','password','nombre','carrera','status'];


    //Relacion con la tablas de alumno(uno) a participante(muchos)
    public function participantes()
    {
        return $this->hasMany('App\Participante');
    }

    //Relacion con la tablas de alumno(uno) a Avances(muchos)
    public function avances()
    {
        return $this->hasMany('App\Avance');
    }

    //Crea el buscador de actividades (Scope)
    public function scopeSearch($query,$valor)
    {
        return $query->where('nombre','LIKE',"%$valor%")->orwhere('no_control','LIKE',"%$valor%")->orwhere('carrera','LIKE',"%$valor%");
    }
}


