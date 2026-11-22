<?php

namespace App\Models\Sit;

use App\Traits\SitReadOnlyModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Discapacidad extends Model
{
    use SitReadOnlyModel;

    protected $connection = 'sit';
    protected $table = 'discapacidades';
    protected $guarded = [];

    public function alumnos(): BelongsToMany
    {
        return $this->belongsToMany(Alumno::class, 'alumno_discapacidades', 'discapacidad_id', 'alumno_id')
            ->withPivot(['observaciones'])
            ->withTimestamps();
    }
}
