<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actividad_Evidencia extends Model
{
    //Nombre de la tabla
    protected $table = "actividad_evidencia";
    //Datos visibles para los objetos json
    protected $fillable=[
        'actividad_id','user_id','validador_id','validado'
    ];
    //Relacion muchos as uno
    //Una actividad evidencia puede tener muchos participantes
    public function participantes(){
    	return $this->hasMany('App\Participante','id','id_evidencia');
    }
    //Relacion muchos as uno
    //Una actividad evidencia puede tener muchas evidencias
    public function evidencias(){
    	return $this->hasMany('App\Evidencia','id_asig_actividades');
    }
}
