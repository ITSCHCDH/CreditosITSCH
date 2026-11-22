<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = "areas";

    protected $fillable = [
    	"nombre","tipo"
    ];

    protected static function booted(): void
    {
        static::addGlobalScope('administrativas', function ($query) {
            $query->where('tipo', 'otro');
        });
    }
}
