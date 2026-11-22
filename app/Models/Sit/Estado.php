<?php

namespace App\Models\Sit;

use App\Traits\SitReadOnlyModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Estado extends Model
{
    use SitReadOnlyModel;

    protected $connection = 'sit';
    protected $table = 'cat_estados';
    protected $guarded = [];

    public function complementos(): HasMany
    {
        return $this->hasMany(AlumnoComplemento::class, 'estado_id');
    }
}
