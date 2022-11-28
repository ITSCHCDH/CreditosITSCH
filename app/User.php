<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table ="users";
    protected $fillable = [
        'name', 'email', 'password','area','active',
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
    //Relacion uno a muchos un usuario puede crear muchas actividades pero una actividad solo puede tener un creador
    public function actividadesCreadas(){
        return $this->hasMany('App\Actividad','id','id_user');
    }
    //Crea el bucador de actividades (Scope)
    public function scopeSearch($query,$valor)
    {
        return $query->where('name','LIKE',"%$valor%");
    }
}
