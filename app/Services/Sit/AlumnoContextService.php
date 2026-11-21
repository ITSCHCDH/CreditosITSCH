<?php

namespace App\Services\Sit;

use App\Models\Sit\Alumno;
use Illuminate\Support\Facades\Auth;

class AlumnoContextService
{
    public function actual(): ?Alumno
    {
        $user = Auth::guard('alumno')->user();

        if (! $user) {
            return null;
        }

        return Alumno::with(['user', 'carrera', 'planEstudio'])
            ->where('user_id', $user->getAuthIdentifier())
            ->first();
    }

    public function porNoControl(string $noControl): ?Alumno
    {
        return Alumno::with(['user', 'carrera'])
            ->where('no_control', $noControl)
            ->first();
    }

    public function noControlActual(): ?string
    {
        $alumno = $this->actual();

        return $alumno?->no_control;
    }
}
