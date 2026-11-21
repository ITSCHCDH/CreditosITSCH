<?php

namespace App\Models\Sit;

use App\Traits\SitReadOnlyModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Model
{
    use SitReadOnlyModel;

    protected $connection = 'sit';
    protected $table = 'users';
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'activo' => 'boolean',
        ];
    }

    protected function nombreCompleto(): Attribute
    {
        return Attribute::get(fn () => collect([
            $this->nombre,
            $this->apellido_paterno,
            $this->apellido_materno,
        ])->filter()->implode(' '));
    }

    public function alumno(): HasOne
    {
        return $this->hasOne(Alumno::class, 'user_id');
    }

    public function catedratico(): HasOne
    {
        return $this->hasOne(Catedratico::class, 'user_id');
    }
}
