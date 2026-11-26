<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Sit\Carrera;
use App\Models\Sit\Catedratico;
use App\Models\Sit\User as SitUser;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    protected $connection = 'creditos';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    
    protected $table ="users";
    protected $fillable = [
        'name', 'email', 'password','area','sit_carrera_id','sit_user_id','sit_catedratico_id','active','tutor'
    ];

    protected function casts(): array
    {
        return [
            'sit_user_id' => 'integer',
            'sit_catedratico_id' => 'integer',
        ];
    }

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

    public function sitCarrera(): BelongsTo
    {
        return $this->belongsTo(Carrera::class, 'sit_carrera_id', 'id');
    }

    public function sitUser(): BelongsTo
    {
        return $this->belongsTo(SitUser::class, 'sit_user_id');
    }

    public function sitCatedratico(): BelongsTo
    {
        return $this->belongsTo(Catedratico::class, 'sit_catedratico_id');
    }
}
