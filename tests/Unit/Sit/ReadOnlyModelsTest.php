<?php

use App\Models\Sit\Alumno;
use App\Models\Sit\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Sit\ServicioSocialAlumno;
use App\Models\Sit\ResidenciaAlumno;

it('prohibe save en Alumno y User', function () {
    foreach ([new Alumno(), new User()] as $model) {
        expect(fn () => $model->save())->toThrow(
            RuntimeException::class,
            "Operación prohibida: el esquema 'sit' es de solo lectura."
        );
    }
});

it('prohibe update en Alumno y User', function () {
    foreach ([new Alumno(), new User()] as $model) {
        expect(fn () => $model->update(['id' => 1]))->toThrow(
            RuntimeException::class,
            "Operación prohibida: el esquema 'sit' es de solo lectura."
        );
    }
});

it('prohibe delete en Alumno y User', function () {
    foreach ([new Alumno(), new User()] as $model) {
        expect(fn () => $model->delete())->toThrow(
            RuntimeException::class,
            "Operación prohibida: el esquema 'sit' es de solo lectura."
        );
    }
});

it('expone correctamente las relaciones de Alumno', function () {
    $alumno = new Alumno();

    expect($alumno->user())->toBeInstanceOf(BelongsTo::class)
        ->and($alumno->carrera())->toBeInstanceOf(BelongsTo::class)
        ->and($alumno->planEstudio())->toBeInstanceOf(BelongsTo::class)
        ->and($alumno->periodoEscolar())->toBeInstanceOf(BelongsTo::class)
        ->and($alumno->municipio())->toBeInstanceOf(BelongsTo::class)
        ->and($alumno->escuelaProcedencia())->toBeInstanceOf(BelongsTo::class)
        ->and($alumno->alumnoComplemento())->toBeInstanceOf(HasOne::class)
        ->and($alumno->alumnoDatoMedico())->toBeInstanceOf(HasOne::class)
        ->and($alumno->semaforoAlumno())->toBeInstanceOf(HasOne::class)
        ->and($alumno->kardex())->toBeInstanceOf(HasMany::class)
        ->and($alumno->listas())->toBeInstanceOf(HasMany::class)
        ->and($alumno->bajas())->toBeInstanceOf(HasMany::class)
        ->and($alumno->perfilCreditos())->toBeInstanceOf(HasOne::class)
        ->and($alumno->avances())->toBeInstanceOf(HasMany::class)
        ->and($alumno->participantes())->toBeInstanceOf(HasMany::class)
        ->and($alumno->servicioSocial())->toBeInstanceOf(HasOne::class)
        ->and($alumno->residencia())->toBeInstanceOf(HasOne::class);
});

it('expone correctamente las relaciones de User', function () {
    $user = new User();

    expect($user->alumno())->toBeInstanceOf(HasOne::class)
        ->and($user->catedratico())->toBeInstanceOf(HasOne::class);
});
