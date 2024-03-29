<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evidencia extends Model
{
    //Nombre de la tabla
    protected $table="evidencia";
    //Datos visibles para los objetos json
    protected $fillable=['status','nom_imagen','valida','id_asig_actividades', 'nom_original'];

    //Relacion con la tablas de evidencia(uno) a participante(muchos)
    public function participantes()
    {
        //return $this->hasMany('App\Participante');
    }

    //Relacion con la tablas de actividad(uno) a evidencia(muchos)
    public function actividad()
    {
        return $this->belongsTo('App\Actividad');
    }

    public function actividad_evidencia(){
        return $this->belongsTo('App\Actividad_Evidencia','id_asig_actividades');
    }
}
