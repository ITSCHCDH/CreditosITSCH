@extends('template.molde')

@section('title','Ficha del alumno')

@section('ruta')
    <span class="d-inline-flex align-items-center gap-2">
        <i class="fa-solid fa-user-check" style="color:#2d6da3"></i>
        <a href="{{ route('analisis.index') }}" class="text-decoration-none">STA</a>
        <span class="text-muted">/</span>
        Ficha del alumno
    </span>
@endsection

@push('styles')
<style>
    .sta-ficha-shell{display:grid;gap:1rem}
    .sta-ficha-hero{display:flex;align-items:center;justify-content:space-between;gap:1rem;padding:1.25rem 1.35rem;border:1px solid #e4eaf1;border-radius:1.15rem;background:linear-gradient(135deg,#173c66,#102b4a);color:#fff;box-shadow:0 .75rem 1.5rem rgba(16,43,74,.14)}
    .sta-ficha-profile{display:flex;align-items:center;gap:.9rem;min-width:0}
    .sta-ficha-photo{width:68px;height:68px;flex:0 0 68px;display:grid;place-items:center;overflow:hidden;border-radius:1rem;border:2px solid rgba(255,255,255,.35);background:rgba(255,255,255,.12)}
    .sta-ficha-photo img{width:100%;height:100%;object-fit:cover}
    .sta-ficha-photo i{font-size:1.55rem;color:rgba(255,255,255,.75)}
    .sta-ficha-hero h1{margin:.1rem 0 0;font-size:clamp(1.2rem,3vw,1.55rem);font-weight:700}
    .sta-ficha-hero p{margin:.25rem 0 0;color:rgba(255,255,255,.78)}
    .sta-ficha-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1rem}
    .sta-ficha-card{border:1px solid #e4eaf1;border-radius:1.15rem;background:#fff;box-shadow:0 .55rem 1.35rem rgba(29,78,116,.08);overflow:hidden}
    .sta-ficha-card.full{grid-column:1/-1}
    .sta-ficha-card-head{display:flex;align-items:center;justify-content:space-between;gap:.75rem;padding:1rem 1.25rem;border-bottom:1px solid #edf1f5;background:#f8fafc}
    .sta-ficha-card-title{display:flex;align-items:center;gap:.7rem}
    .sta-ficha-card-icon{width:40px;height:40px;display:grid;place-items:center;flex:0 0 40px;border-radius:.75rem;color:#173c66;background:#edf3f8}
    .sta-ficha-card h2{margin:0;color:#102b4a;font-size:1rem;font-weight:700}
    .sta-ficha-card-body{padding:1.1rem 1.25rem}
    .sta-ficha-list{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:.65rem}
    .sta-ficha-item{padding:.75rem;border:1px solid #edf1f5;border-radius:.75rem;background:#fbfcfe}
    .sta-ficha-item span{display:block;color:#6b7280;font-size:.76rem;text-transform:uppercase;letter-spacing:.025em}
    .sta-ficha-item strong{display:block;margin-top:.18rem;color:#102b4a;font-size:.9rem;overflow-wrap:anywhere}
    .sta-ficha-sit{border-color:#bdd3e8;background:#f3f8fc}
    .sta-ficha-creditos{border-color:#e7dcc1;background:#fdfbf5}
    .sta-ficha-table{margin:0}
    .sta-ficha-table th{font-size:.78rem;color:#64748b;background:#f8fafc;white-space:nowrap}
    .sta-ficha-table td{font-size:.88rem;vertical-align:middle}
    .sta-ficha-actions{display:flex;justify-content:flex-end;gap:.5rem}
    @media(max-width:767.98px){
        .sta-ficha-hero{align-items:flex-start;flex-direction:column}
        .sta-ficha-grid{grid-template-columns:1fr}
        .sta-ficha-card.full{grid-column:auto}
        .sta-ficha-list{grid-template-columns:1fr}
        .sta-ficha-actions{width:100%}
        .sta-ficha-actions .btn{flex:1}
    }
</style>
@endpush

@section('contenido')
@php
    $fechaNacimiento = $alu2->alc_FechaNac ? \Carbon\Carbon::parse($alu2->alc_FechaNac) : null;
    $edad = $fechaNacimiento ? $fechaNacimiento->age : 'No registrada';
    $sexo = ($alu1->alu_Sexo ?? null) === 'M' ? 'Hombre' : (($alu1->alu_Sexo ?? null) === 'F' ? 'Mujer' : 'No registrado');
    $padre = $padres[0] ?? (object) ['nombre'=>'No registrado','edad'=>'','tel'=>'','ocupacion'=>'No registrada','profesion'=>''];
    $madre = $padres[1] ?? (object) ['nombre'=>'No registrada','edad'=>'','tel'=>'','ocupacion'=>'No registrada','profesion'=>''];
    $valor = function ($obj, $key, $fallback = 'No registrado') {
        return $obj && isset($obj->{$key}) && $obj->{$key} !== '' && $obj->{$key} !== null
            ? $obj->{$key}
            : $fallback;
    };
    $enfermedades = $clinicos->enfermedad ?? 'No registrada';
    $discapacidadesTexto = $clinicos->cap_dif ?? 'No registrada';
@endphp

<div class="sta-ficha-shell">
    <section class="sta-ficha-hero">
        <div class="sta-ficha-profile">
            <span class="sta-ficha-photo">
                @if(!empty($alu->foto))
                    <img src="{{ asset('storage/alumnos/img/'.$alu->foto) }}" alt="Fotografía de {{ $alu1->alu_Nombre }}">
                @else
                    <i class="fa-solid fa-user-graduate" aria-hidden="true"></i>
                @endif
            </span>
            <div>
                <span class="small text-uppercase opacity-75">Ficha de identificación</span>
                <h1>{{ $alu1->alu_Nombre }} {{ $alu1->alu_ApePaterno }} {{ $alu1->alu_ApeMaterno }}</h1>
                <p>{{ $alu1->alu_NumControl }} · {{ $car->car_NombreCorto ?: 'Carrera no registrada' }}</p>
            </div>
        </div>
        <div class="sta-ficha-actions">
            @if(!empty($sitUrl))
                <a href="{{ $sitUrl }}" target="_blank" rel="noopener noreferrer" class="btn btn-light rounded-pill">
                    <i class="fa-solid fa-arrow-up-right-from-square me-2"></i>Actualizar en SIT
                </a>
            @endif
            <a href="{{ route('analisis.sta.pdf',$alu1->alu_NumControl) }}" target="_blank" class="btn btn-warning rounded-pill">
                <i class="fa-solid fa-print me-2"></i>Imprimir
            </a>
        </div>
    </section>

    <div class="sta-ficha-grid">
        <article class="sta-ficha-card">
            <div class="sta-ficha-card-head">
                <div class="sta-ficha-card-title">
                    <span class="sta-ficha-card-icon"><i class="fa-solid fa-user"></i></span>
                    <h2>Datos personales</h2>
                </div>
                <span class="badge rounded-pill bg-primary">SIT · Solo lectura</span>
            </div>
            <div class="sta-ficha-card-body">
                <div class="sta-ficha-list">
                    <div class="sta-ficha-item"><span>Fecha de nacimiento</span><strong>{{ $fechaNacimiento?->format('d/m/Y') ?: 'No registrada' }}</strong></div>
                    <div class="sta-ficha-item"><span>Edad</span><strong>{{ $edad }}@if(is_numeric($edad)) años @endif</strong></div>
                    <div class="sta-ficha-item"><span>Sexo</span><strong>{{ $sexo }}</strong></div>
                    <div class="sta-ficha-item"><span>Lugar de nacimiento</span><strong>{{ $alu->lug_pro ?? 'No registrado' }}</strong></div>
                    <div class="sta-ficha-item"><span>Correo institucional</span><strong>{{ $alu->email ?? 'No registrado' }}</strong></div>
                    <div class="sta-ficha-item"><span>Correo personal</span><strong>{{ $alu->emailPer ?? 'No registrado' }}</strong></div>
                    <div class="sta-ficha-item"><span>Teléfono</span><strong>{{ $alu->tel ?? 'No registrado' }}</strong></div>
                    <div class="sta-ficha-item"><span>Estado civil</span><strong>{{ $alu->est_civ ?? 'No registrada' }}</strong></div>
                </div>
            </div>
        </article>

        <article class="sta-ficha-card">
            <div class="sta-ficha-card-head">
                <div class="sta-ficha-card-title">
                    <span class="sta-ficha-card-icon"><i class="fa-solid fa-house"></i></span>
                    <h2>Domicilio</h2>
                </div>
                <span class="badge rounded-pill bg-primary">SIT · Solo lectura</span>
            </div>
            <div class="sta-ficha-card-body">
                <div class="sta-ficha-list">
                    <div class="sta-ficha-item"><span>Estado</span><strong>{{ $valor($direccion,'estado') }}</strong></div>
                    <div class="sta-ficha-item"><span>Municipio</span><strong>{{ $valor($direccion,'municipio') }}</strong></div>
                    <div class="sta-ficha-item"><span>Código postal</span><strong>{{ $valor($direccion,'cp') }}</strong></div>
                    <div class="sta-ficha-item"><span>Colonia</span><strong>{{ $valor($direccion,'colonia') }}</strong></div>
                    <div class="sta-ficha-item" style="grid-column:1/-1"><span>Calle y número</span><strong>{{ $valor($direccion,'direccion') }}</strong></div>
                </div>
            </div>
        </article>

        <article class="sta-ficha-card">
            <div class="sta-ficha-card-head">
                <div class="sta-ficha-card-title">
                    <span class="sta-ficha-card-icon"><i class="fa-solid fa-person"></i></span>
                    <h2>Padre</h2>
                </div>
            </div>
            <div class="sta-ficha-card-body">
                <div class="sta-ficha-list">
                    <div class="sta-ficha-item"><span>Nombre</span><strong>{{ $valor($padre,'nombre') }}</strong></div>
                    <div class="sta-ficha-item"><span>Edad</span><strong>{{ $valor($padre,'edad','No registrada') }}</strong></div>
                    <div class="sta-ficha-item"><span>Teléfono</span><strong>{{ $valor($padre,'tel','No registrado') }}</strong></div>
                    <div class="sta-ficha-item"><span>Ocupación</span><strong>{{ $valor($padre,'ocupacion','No registrada') }}</strong></div>
                    <div class="sta-ficha-item full" style="grid-column:1/-1"><span>Profesión</span><strong>{{ $valor($padre,'profesion','No registrada') }}</strong></div>
                </div>
            </div>
        </article>

        <article class="sta-ficha-card">
            <div class="sta-ficha-card-head">
                <div class="sta-ficha-card-title">
                    <span class="sta-ficha-card-icon"><i class="fa-solid fa-person-dress"></i></span>
                    <h2>Madre</h2>
                </div>
            </div>
            <div class="sta-ficha-card-body">
                <div class="sta-ficha-list">
                    <div class="sta-ficha-item"><span>Nombre</span><strong>{{ $valor($madre,'nombre') }}</strong></div>
                    <div class="sta-ficha-item"><span>Edad</span><strong>{{ $valor($madre,'edad','No registrada') }}</strong></div>
                    <div class="sta-ficha-item"><span>Teléfono</span><strong>{{ $valor($madre,'tel','No registrado') }}</strong></div>
                    <div class="sta-ficha-item"><span>Ocupación</span><strong>{{ $valor($madre,'ocupacion','No registrada') }}</strong></div>
                    <div class="sta-ficha-item" style="grid-column:1/-1"><span>Profesión</span><strong>{{ $valor($madre,'profesion','No registrada') }}</strong></div>
                </div>
            </div>
        </article>

        <article class="sta-ficha-card full">
            <div class="sta-ficha-card-head">
                <div class="sta-ficha-card-title">
                    <span class="sta-ficha-card-icon"><i class="fa-solid fa-heart-pulse"></i></span>
                    <h2>Datos médicos</h2>
                </div>
                <span class="badge rounded-pill bg-primary">SIT · Solo lectura</span>
            </div>
            <div class="sta-ficha-card-body">
                <div class="sta-ficha-list">
                    <div class="sta-ficha-item"><span>Tipo de sangre</span><strong>{{ $valor($clinicos,'sangre') }}</strong></div>
                    <div class="sta-ficha-item"><span>Estatura</span><strong>{{ $valor($clinicos,'estatura','No registrada') }}</strong></div>
                    <div class="sta-ficha-item"><span>Peso</span><strong>{{ $valor($clinicos,'peso','No registrado') }}</strong></div>
                    <div class="sta-ficha-item"><span>Enfermedades</span><strong>{{ $enfermedades }}</strong></div>
                    <div class="sta-ficha-item"><span>Discapacidades</span><strong>{{ $discapacidadesTexto }}</strong></div>
                    <div class="sta-ficha-item"><span>Diagnóstico clínico</span><strong>{{ $valor($clinicos,'dia_med','No registrado') }}</strong></div>
                    <div class="sta-ficha-item"><span>Diagnóstico psicológico</span><strong>{{ $valor($clinicos,'dia_psico','No registrado') }}</strong></div>
                </div>
            </div>
        </article>

        <article class="sta-ficha-card full">
            <div class="sta-ficha-card-head">
                <div class="sta-ficha-card-title">
                    <span class="sta-ficha-card-icon"><i class="fa-solid fa-users"></i></span>
                    <h2>Integrantes familiares</h2>
                </div>
                <span class="badge rounded-pill bg-warning text-dark">Créditos · Histórico editable</span>
            </div>
            <div class="sta-ficha-card-body">
                <div class="table-responsive">
                    <table class="table align-middle sta-ficha-table">
                        <thead><tr><th>Nombre</th><th>Edad</th><th>Escolaridad</th><th>Parentesco</th><th>Relación</th></tr></thead>
                        <tbody>
                            @forelse($familiares as $familiar)
                                <tr>
                                    <td>{{ $familiar->nombre ?? 'No registrado' }}</td>
                                    <td>{{ $familiar->edad ?? '—' }}</td>
                                    <td>{{ $familiar->escolaridad ?? '—' }}</td>
                                    <td>{{ $familiar->parentesco ?? '—' }}</td>
                                    <td>{{ $familiar->relacion ?? '—' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted py-4">No hay integrantes familiares registrados.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </article>

        <article class="sta-ficha-card">
            <div class="sta-ficha-card-head">
                <div class="sta-ficha-card-title">
                    <span class="sta-ficha-card-icon"><i class="fa-solid fa-house-chimney-user"></i></span>
                    <h2>Situación familiar</h2>
                </div>
            </div>
            <div class="sta-ficha-card-body">
                <div class="sta-ficha-list">
                    <div class="sta-ficha-item" style="grid-column:1/-1"><span>Dificultades familiares</span><strong>{{ $valor($fam,'dificultades') }}</strong></div>
                    <div class="sta-ficha-item"><span>Vínculo afectivo</span><strong>{{ $valor($fam,'ligado') }} {{ $valor($fam,'ligado_por','') }}</strong></div>
                    <div class="sta-ficha-item"><span>Responsable educativo</span><strong>{{ $valor($fam,'edu') }}</strong></div>
                    <div class="sta-ficha-item" style="grid-column:1/-1"><span>Influencia en la carrera</span><strong>{{ $valor($fam,'carrera') }}</strong></div>
                </div>
                <form action="{{ route('analisis.ficha.familiares.guardar', $alu1->alu_NumControl) }}" method="post" class="mt-3">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="dificultades">Dificultades familiares</label>
                            <input type="text" class="form-control" id="dificultades" name="dificultades" value="{{ $valor($fam,'dificultades','') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" for="ligado">Vínculo</label>
                            <input type="text" class="form-control" id="ligado" name="ligado" value="{{ $valor($fam,'ligado','') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" for="ligado_por">Con quién</label>
                            <input type="text" class="form-control" id="ligado_por" name="ligado_por" value="{{ $valor($fam,'ligado_por','') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="edu">Responsable educativo</label>
                            <input type="text" class="form-control" id="edu" name="edu" value="{{ $valor($fam,'edu','') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="carrera">Influencia en la carrera</label>
                            <input type="text" class="form-control" id="carrera" name="carrera" value="{{ $valor($fam,'carrera','') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="otro_dato">Otro dato familiar</label>
                            <input type="text" class="form-control" id="otro_dato" name="otro_dato" value="{{ $valor($fam,'otro_dato','') }}">
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-warning rounded-pill">
                            <i class="fa-solid fa-floppy-disk me-2"></i>Guardar datos familiares
                        </button>
                    </div>
                </form>
            </div>
        </article>

        <article class="sta-ficha-card">
            <div class="sta-ficha-card-head">
                <div class="sta-ficha-card-title">
                    <span class="sta-ficha-card-icon"><i class="fa-solid fa-heart"></i></span>
                    <h2>Aspectos sociales y personales</h2>
                </div>
            </div>
            <div class="sta-ficha-card-body">
                <div class="sta-ficha-list">
                    <div class="sta-ficha-item"><span>Relación con compañeros</span><strong>{{ $valor($soc,'rel_comp') }}</strong></div>
                    <div class="sta-ficha-item"><span>Relación con amigos</span><strong>{{ $valor($soc,'rel_amig') }}</strong></div>
                    <div class="sta-ficha-item"><span>Pareja</span><strong>{{ $valor($soc,'pareja') }}</strong></div>
                    <div class="sta-ficha-item"><span>Relación con profesores</span><strong>{{ $valor($soc,'rel_prof') }}</strong></div>
                    <div class="sta-ficha-item"><span>Tiempo libre</span><strong>{{ $valor($soc,'tiempo_lib') }}</strong></div>
                    <div class="sta-ficha-item"><span>Actividad recreativa</span><strong>{{ $valor($soc,'recreativa') }}</strong></div>
                    <div class="sta-ficha-item" style="grid-column:1/-1"><span>Metas y planes</span><strong>{{ $valor($soc,'metas_vida') }} {{ $valor($soc,'planes_in','') }}</strong></div>
                    <div class="sta-ficha-item"><span>Caracter</span><strong>{{ $valor($soc,'caracter') }}</strong></div>
                    <div class="sta-ficha-item"><span>Aspiraciones</span><strong>{{ $valor($soc,'aspiraciones') }}</strong></div>
                </div>
                <form action="{{ route('analisis.ficha.social.guardar', $alu1->alu_NumControl) }}" method="post" class="mt-3">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label" for="rel_comp">Relación con compañeros</label><input type="text" class="form-control" id="rel_comp" name="rel_comp" value="{{ $valor($soc,'rel_comp','') }}"></div>
                        <div class="col-md-6"><label class="form-label" for="comp_por">Descripción</label><input type="text" class="form-control" id="comp_por" name="comp_por" value="{{ $valor($soc,'comp_por','') }}"></div>
                        <div class="col-md-6"><label class="form-label" for="rel_amig">Relación con amigos</label><input type="text" class="form-control" id="rel_amig" name="rel_amig" value="{{ $valor($soc,'rel_amig','') }}"></div>
                        <div class="col-md-6"><label class="form-label" for="amig_por">Descripción</label><input type="text" class="form-control" id="amig_por" name="amig_por" value="{{ $valor($soc,'amig_por','') }}"></div>
                        <div class="col-md-4"><label class="form-label" for="pareja">Pareja</label><input type="text" class="form-control" id="pareja" name="pareja" value="{{ $valor($soc,'pareja','') }}"></div>
                        <div class="col-md-4"><label class="form-label" for="rel_prof">Relación con profesores</label><input type="text" class="form-control" id="rel_prof" name="rel_prof" value="{{ $valor($soc,'rel_prof','') }}"></div>
                        <div class="col-md-4"><label class="form-label" for="rel_auto_ac">Autoridades académicas</label><input type="text" class="form-control" id="rel_auto_ac" name="rel_auto_ac" value="{{ $valor($soc,'rel_auto_ac','') }}"></div>
                        <div class="col-md-6"><label class="form-label" for="tiempo_lib">Tiempo libre</label><input type="text" class="form-control" id="tiempo_lib" name="tiempo_lib" value="{{ $valor($soc,'tiempo_lib','') }}"></div>
                        <div class="col-md-6"><label class="form-label" for="recreativa">Actividad recreativa</label><input type="text" class="form-control" id="recreativa" name="recreativa" value="{{ $valor($soc,'recreativa','') }}"></div>
                        <div class="col-md-6"><label class="form-label" for="planes_in">Planes inmediatos</label><textarea class="form-control" id="planes_in" name="planes_in" rows="2">{{ $valor($soc,'planes_in','') }}</textarea></div>
                        <div class="col-md-6"><label class="form-label" for="metas_vida">Metas de vida</label><textarea class="form-control" id="metas_vida" name="metas_vida" rows="2">{{ $valor($soc,'metas_vida','') }}</textarea></div>
                        <div class="col-md-6"><label class="form-label" for="caracter">Caracter</label><input type="text" class="form-control" id="caracter" name="caracter" value="{{ $valor($soc,'caracter','') }}"></div>
                        <div class="col-md-6"><label class="form-label" for="aspiraciones">Aspiraciones</label><input type="text" class="form-control" id="aspiraciones" name="aspiraciones" value="{{ $valor($soc,'aspiraciones','') }}"></div>
                        <div class="col-md-6"><label class="form-label" for="yo_soy">Yo soy</label><input type="text" class="form-control" id="yo_soy" name="yo_soy" value="{{ $valor($soc,'yo_soy','') }}"></div>
                        <div class="col-md-6"><label class="form-label" for="me_gusta">Me gusta</label><input type="text" class="form-control" id="me_gusta" name="me_gusta" value="{{ $valor($soc,'me_gusta','') }}"></div>
                        <div class="col-md-6"><label class="form-label" for="miedo">Miedo</label><input type="text" class="form-control" id="miedo" name="miedo" value="{{ $valor($soc,'miedo','') }}"></div>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-warning rounded-pill">
                            <i class="fa-solid fa-floppy-disk me-2"></i>Guardar datos sociales
                        </button>
                    </div>
                </form>
            </div>
        </article>
    </div>
</div>
@endsection
