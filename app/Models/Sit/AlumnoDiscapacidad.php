<?php

namespace App\Models\Sit;

use App\Traits\SitReadOnlyModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlumnoDiscapacidad extends Model
{
    use SitReadOnlyModel;

    protected $connection = 'sit';
    protected $table = 'alumno_discapacidades';
    protected $guarded = [];

    public function alumno(): BelongsTo
    {
        return $this->belongsTo(Alumno::class, 'alumno_id');
    }

    public function discapacidad(): BelongsTo
    {
        return $this->belongsTo(Discapacidad::class, 'discapacidad_id');
    }
}
