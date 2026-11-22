<?php

namespace App\Models\Sit;

use App\Traits\SitReadOnlyModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\AlumnoCreditosPerfil;
use App\Models\Avance;
use App\Models\Participante;

class Alumno extends Model
{
    use SitReadOnlyModel;

    protected $connection = 'sit';
    protected $table = 'alumnos';
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'fecha_nacimiento' => 'date',
            'anio_ingreso' => 'integer',
            'promedio_bachillerato' => 'decimal:2',
            'calificacion_examen_diagnostico' => 'decimal:2',
            'fecha_certificado_profesional' => 'date',
            'fecha_titulacion' => 'date',
            'inscrito' => 'boolean',
            'bloqueado_adeudos' => 'boolean',
            'status' => 'integer',
        ];
    }

    protected function nombreCompleto(): Attribute
    {
        return Attribute::get(fn () => $this->user?->nombreCompleto);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function carrera(): BelongsTo
    {
        return $this->belongsTo(Carrera::class, 'carrera_id');
    }

    public function planEstudio(): BelongsTo
    {
        return $this->belongsTo(PlanEstudio::class, 'plan_estudio_id');
    }

    public function periodoEscolar(): BelongsTo
    {
        return $this->belongsTo(PeriodoEscolar::class, 'periodo_ingreso_id');
    }

    public function municipio(): BelongsTo
    {
        return $this->belongsTo(Municipio::class, 'lugar_procedencia_id');
    }

    public function escuelaProcedencia(): BelongsTo
    {
        return $this->belongsTo(EscuelaProcedencia::class, 'escuela_procedencia_id');
    }

    public function alumnoComplemento(): HasOne
    {
        return $this->hasOne(AlumnoComplemento::class, 'alumno_id');
    }

    public function alumnoDatoMedico(): HasOne
    {
        return $this->hasOne(AlumnoDatoMedico::class, 'alumno_id');
    }

    public function discapacidades(): BelongsToMany
    {
        return $this->belongsToMany(Discapacidad::class, 'alumno_discapacidades', 'alumno_id', 'discapacidad_id')
            ->withPivot(['observaciones'])
            ->withTimestamps();
    }

    public function semaforoAlumno(): HasOne
    {
        return $this->hasOne(SemaforoAlumno::class, 'alumno_id');
    }

    public function kardex(): HasMany
    {
        return $this->hasMany(Kardex::class, 'alumno_id');
    }

    public function listas(): HasMany
    {
        return $this->hasMany(Lista::class, 'alumno_id');
    }

    public function bajas(): HasMany
    {
        return $this->hasMany(BajaAlumno::class, 'alumno_id');
    }

    public function perfilCreditos(): HasOne
    {
        return $this->hasOne(AlumnoCreditosPerfil::class, 'no_control', 'no_control');
    }

    public function avances(): HasMany
    {
        return $this->hasMany(Avance::class, 'no_control', 'no_control');
    }

    public function participantes(): HasMany
    {
        return $this->hasMany(Participante::class, 'no_control', 'no_control');
    }

    public function servicioSocial(): HasOne
    {
        return $this->hasOne(ServicioSocialAlumno::class, 'alumno_id');
    }

    public function residencia(): HasOne
    {
        return $this->hasOne(ResidenciaAlumno::class, 'alumno_id');
    }
}
