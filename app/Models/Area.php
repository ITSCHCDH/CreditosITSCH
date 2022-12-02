<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = "areas";

    protected $fillable = [
    	"nombre","tipo"
    ];

    public function scopeCarrerasUsuario($query, int $user_id) {
        $user = User::find($user_id);
        $tipo = Area::find($user->area)->tipo;
        if ($tipo == 'otro') {
            $query->where('tipo','=', 'carrera');
        } else {
            $query->where('id', '=', $user->area);
        }
    }

    public function scopeCarreras($query) {
        $query->where('tipo', '=', 'carrera');
    }
}
