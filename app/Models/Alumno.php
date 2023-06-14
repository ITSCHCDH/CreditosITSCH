<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
   
    //Nombre de la tabla
    protected $table="alumnos";
    //Datos visibles para los objetos json   
    protected $fillable=['no_control','password','nombre','carrera','status','foto','observaciones','email','ficha','nombre_i','a_pat','a_mat','creditos','fec_nac','lug_pro','curp','sexo','est_civ','tel','tel_emer','beca','grupo','nom_ficha','generacion'];


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
}


