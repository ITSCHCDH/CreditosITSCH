<?php

namespace App\Models\Sit;

use App\Traits\SitReadOnlyModel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use SitReadOnlyModel;

    protected $connection = 'sit';
    protected $table = 'users';
    protected $guarded = [];
    protected $hidden = ['password', 'remember_token'];

    public function setRememberToken($value)
    {
        // No-op: sit.users es de solo lectura.
    }

    public function isAlumnoActivo(): bool
    {
        return (int) $this->activo === 1 && $this->alumno()->exists();
    }

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

    protected function noControl(): Attribute
    {
        return Attribute::get(fn () => $this->alumno?->no_control);
    }

    protected function foto(): Attribute
    {
        return Attribute::get(fn () => null);
    }

    protected function status(): Attribute
    {
        return Attribute::get(fn () => $this->alumno?->estatus);
    }

    protected function carrera(): Attribute
    {
        return Attribute::get(fn () => $this->alumno?->carrera_id);
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
