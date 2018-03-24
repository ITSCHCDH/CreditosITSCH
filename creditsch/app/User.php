<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table ="users";
    protected $fillable = [
        'name', 'email', 'password','area',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    //Relacion mucho a muchos una actividad puede terner mucho responsables y un resposables puede tener muchas acctividades
    public function actividades(){
        return $this->belongsToMany('App\Actividad')->withTimestamps();
    }
    
}
