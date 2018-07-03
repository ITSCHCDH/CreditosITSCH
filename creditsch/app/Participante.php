<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participante extends Model
{
    //Nombre de la tabla
    protected $table="participantes";
    //Datos visibles para los objetos json
    protected $fillable=['no_control','id_evidencia'];

    //Relacion de la tabla alumno(uno)-participante(muchos)
    public function alumno()
    {
        return $this->belongsTo('App\Alumno');
    }

    //Relacion de la tabla evidencia(uno)-participante(muchos)
    public function evidencias()
    {
        //return $this->belongsToMany('App\Evidencia');
    }

    //Crea el bucador de participantes (Scope)
    public function scopeSearch($query,$valor)
    {
        return $query->where('no_control','LIKE',"%$valor%");
    }
}
