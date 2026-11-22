@extends('template.molde')

@section('title','Ficha de identificación')

@section('links')
<style>
    .profile-page { --profile-blue:#173c66; --profile-gold:#c79a2b; }
    .profile-hero {
        display:flex; align-items:center; justify-content:space-between; gap:1rem;
        margin-bottom:1.25rem; padding:1.5rem; border-radius:1.25rem;
        color:#fff; background:linear-gradient(135deg,#173c66,#102b4a);
    }
    .profile-hero h1 { margin:.25rem 0 0; font-size:clamp(1.45rem,3vw,2.1rem); font-weight:700; }
    .profile-hero p { margin:.35rem 0 0; color:rgba(255,255,255,.78); }
    .profile-sections { display:grid; gap:1rem; }
    .profile-section {
        border:1px solid #e4eaf1; border-radius:1.1rem; background:#fff;
        box-shadow:0 .45rem 1.25rem rgba(29,78,116,.055); overflow:hidden;
    }
    .profile-section-head {
        display:flex; align-items:center; gap:.75rem; padding:1rem 1.25rem;
        border-bottom:1px solid #edf1f5; background:#f8fafc;
    }
    .profile-section-head i {
        width:38px; height:38px; display:grid; place-items:center;
        border-radius:.7rem; color:#173c66; background:#edf3f8;
    }
    .profile-section-head h2 { margin:0; color:#102b4a; font-size:1.05rem; font-weight:700; }
    .profile-section-body { padding:1.25rem; }
    .profile-section .form-control, .profile-section .form-select { min-height:46px; border-radius:.65rem; }
    .profile-summary { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:.75rem; }
    .profile-summary div { padding:.85rem; border-radius:.8rem; background:#f5f7fa; }
    .profile-summary span { display:block; color:#6b7280; font-size:.78rem; }
    .profile-summary strong { color:#102b4a; }
    .profile-actions {
        position:sticky; bottom:.75rem; z-index:5; display:flex; justify-content:flex-end;
        margin-top:1rem; padding:.75rem; border:1px solid #e4eaf1; border-radius:.9rem;
        background:rgba(255,255,255,.96); box-shadow:0 .55rem 1.5rem rgba(16,43,74,.12);
    }
    @media (max-width:767px) {
        .profile-hero { align-items:flex-start; flex-direction:column; }
        .profile-summary { grid-template-columns:1fr; }
    }
</style>
@endsection

@section('ruta')
<a class="text-decoration-none" href="{{ route('alumnos.home_avance') }}">Inicio</a> / Ficha de identificación
@endsection

@section('contenido')
@php
    $fechaNacimiento = $alu2->alc_FechaNac ? \Carbon\Carbon::parse($alu2->alc_FechaNac) : null;
    $sexo = in_array($alu1->alu_Sexo, ['M','Hombre','Masculino'], true) ? 'Hombre' : 'Mujer';
@endphp

<div class="profile-page">
    <div class="profile-hero">
        <div>
            <span class="small text-uppercase opacity-75">Ficha académica</span>
            <h1>{{ $alu1->alu_Nombre }} {{ $alu1->alu_ApePaterno }} {{ $alu1->alu_ApeMaterno }}</h1>
            <p>{{ $alu1->alu_NumControl }} · {{ $car->car_NombreCorto ?? 'Carrera no registrada' }}</p>
        </div>
        <span class="badge rounded-pill px-3 py-2 bg-light text-dark">Actualización del perfil</span>
    </div>

    @if (! empty($sitUrl))
        <div class="alert alert-info d-flex align-items-center justify-content-between" role="alert">
            <span><i class="fas fa-lock me-2"></i>Los datos institucionales se muestran como solo lectura.</span>
            <a class="btn btn-sm btn-outline-primary" href="{{ $sitUrl }}" target="_blank" rel="noopener noreferrer">¿Necesitas corregir estos datos? Actualízalos directamente en el sistema SIT</a>
        </div>
    @endif
    <form action="{{ route('alumnos.sta.ficha.guargar', $alu->no_control) }}" method="post" id="fr">
        @csrf
        <div class="profile-sections">
            <section class="profile-section">
                <div class="profile-section-head"><i class="fas fa-user"></i><h2>Datos personales</h2></div>
                <div class="profile-section-body">
                    <div class="profile-summary mb-3">
                        <div><span>Fecha de nacimiento</span><strong>{{ $fechaNacimiento?->format('d/m/Y') ?? 'No registrada' }}</strong></div>
                        <div><span>Edad</span><strong>{{ $fechaNacimiento ? $fechaNacimiento->age . ' años' : 'No registrada' }}</strong></div>
                        <div><span>Sexo</span><strong>{{ $sexo }}</strong></div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label" for="lug">Lugar de nacimiento</label>
                            <input id="lug" type="text" class="form-control" value="{{ $alu->lug_pro }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="est_civ">Estado civil</label>
                            <select id="est_civ" class="form-select" disabled>
                                @foreach(['Soltero','Casado','Separado','Divorciado','Viudo','Unión Libre'] as $estadoCivil)
                                    <option value="{{ $estadoCivil }}" @selected($alu->est_civ == $estadoCivil)>{{ $estadoCivil }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="grupo">Grupo</label>
                            <input id="grupo" maxlength="6" type="text" class="form-control" value="{{ $alu->grupo }}" readonly>
                        </div>
                    </div>
                </div>
            </section>

            <section class="profile-section">
                <div class="profile-section-head"><i class="fas fa-heart-pulse"></i><h2>Datos físicos y médicos</h2></div>
                <div class="profile-section-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label" for="estatura">Estatura (cm)</label>
                            <input id="estatura" type="number" min="0" class="form-control" value="{{ $clinicos->estatura }}" step="0.1" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" for="peso">Peso (kg)</label>
                            <input id="peso" type="number" min="0" class="form-control" value="{{ $clinicos->peso }}" step="1" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" for="sangre">Tipo de sangre</label>
                            <select id="sangre" class="form-select" disabled>
                                <option value="">Seleccione</option>
                                @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $tipoSangre)
                                    <option value="{{ $tipoSangre }}" @selected($clinicos->sangre == $tipoSangre)>{{ $tipoSangre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" for="tel">Teléfono</label>
                            <input type="text" id="tel" class="form-control" value="{{ $alu->tel }}" readonly>
                        </div>
                    </div>
                </div>
            </section>

            <section class="profile-section">
                <div class="profile-section-head"><i class="fas fa-house"></i><h2>Domicilio y situación</h2></div>
                <div class="profile-section-body">
                    <div class="row g-3">
                        <div class="col-md-4"><label class="form-label" for="estado">Estado</label><input type="text" id="estado" class="form-control" value="{{ $direccion->estado }}" readonly></div>
                        <div class="col-md-4"><label class="form-label" for="municipio">Municipio</label><input type="text" id="municipio" class="form-control" value="{{ $direccion->municipio }}" readonly></div>
                        <div class="col-md-4"><label class="form-label" for="cp">Código postal</label><input type="number" id="cp" class="form-control" value="{{ $direccion->cp }}" readonly></div>
                        <div class="col-md-8"><label class="form-label" for="direccion">Calle y número</label><input type="text" id="direccion" class="form-control" value="{{ $direccion->direccion }}" readonly></div>
                        <div class="col-md-4"><label class="form-label" for="colonia">Colonia</label><input type="text" id="colonia" class="form-control" value="{{ $direccion->colonia }}" readonly></div>
                    </div>
                    <hr>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label d-block">¿Trabajas actualmente?</label>
                            @foreach(['Si','No'] as $trabajo)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="trAlu" id="trAlu{{ $trabajo }}" value="{{ $trabajo }}" @checked(($person->trab ?? 'No') == $trabajo)>
                                    <label class="form-check-label" for="trAlu{{ $trabajo }}">{{ $trabajo }}</label>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-md-6"><label class="form-label" for="trabajo">Lugar de trabajo</label><input type="text" name="trabajo" id="trabajo" class="form-control" value="{{ $person->trab }}"></div>
                        <div class="col-md-6">
                            <label class="form-label d-block">Tipo de vivienda</label>
                            @foreach(['Rentada','Prestada','Propia','Otro'] as $tipoCasa)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="casa" value="{{ $tipoCasa }}" @checked(($person->casa ?? '') == $tipoCasa)>
                                    <label class="form-check-label">{{ $tipoCasa }}</label>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-md-6"><label class="form-label" for="casatipo">Especificación de vivienda</label><input type="text" name="casatipo" id="casatipo" class="form-control" value="{{ $person->casa }}"></div>
                    </div>
                </div>
            </section>

            <section class="profile-section">
                <div class="profile-section-head"><i class="fas fa-address-card"></i><h2>Contacto e identificación</h2></div>
                <div class="profile-section-body">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label" for="emailPer">Correo personal</label><input type="email" id="emailPer" class="form-control" value="{{ $alu->emailPer }}" readonly></div>
                        <div class="col-md-6"><label class="form-label" for="email">Correo institucional</label><input type="email" id="email" name="email" class="form-control" value="{{ $alu->email }}" readonly></div>
                        <div class="col-md-6"><label class="form-label" for="num_person">Número de dependientes</label><input type="number" name="num_person" id="num_person" class="form-control" value="{{ $person->num_person }}" required></div>
                        <div class="col-md-6"><label class="form-label" for="parentesco">Parentesco de contacto</label><input type="text" name="parentesco" id="parentesco" class="form-control" value="{{ $person->parentesco }}" required></div>
                    </div>
                </div>
            </section>

            <section class="profile-section">
                <div class="profile-section-head"><i class="fas fa-users"></i><h2>Información familiar</h2></div>
                <div class="profile-section-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <h3 class="h6 text-primary">Padre o tutor masculino</h3>
                            <div class="row g-2">
                                <div class="col-12"><label class="form-label" for="nomPa">Nombre</label><input required type="text" name="nomPa" id="nomPa" class="form-control" value="{{ $dPad->nombre }}"></div>
                                <div class="col-md-4"><label class="form-label" for="EdadPa">Edad</label><input required type="number" name="EdadPa" id="EdadPa" class="form-control" value="{{ $dPad->edad }}"></div>
                                <div class="col-md-8"><label class="form-label" for="TelPa">Teléfono</label><input required type="text" name="TelPa" id="TelPa" class="form-control" value="{{ $dPad->tel }}"></div>
                                <div class="col-12"><label class="form-label" for="ProfPa">Profesión</label><input required type="text" name="ProfPa" id="ProfPa" class="form-control" value="{{ $dPad->profesion }}"></div>
                                <div class="col-12">
                                    <label class="form-label d-block">¿Trabaja?</label>
                                    @foreach(['Si','No'] as $trabaja)
                                        <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="trPad" id="trPad{{ $trabaja }}" value="{{ $trabaja }}" @checked(($dPad->ocupacion ?? 'No') == $trabaja)><label class="form-check-label">{{ $trabaja }}</label></div>
                                    @endforeach
                                </div>
                                <div class="col-12"><label class="form-label" for="trabPatext">Ocupación</label><input type="text" name="trabPatext" id="trabPatext" class="form-control" value="{{ $dPad->ocupacion }}"></div>
                                <div class="col-12"><label class="form-label" for="estadoP">Estado</label><input name="estadoP" id="estadoP" class="form-control" value="{{ $direccionP->estado }}"></div>
                                <div class="col-12"><label class="form-label" for="municipioP">Municipio</label><input name="municipioP" id="municipioP" class="form-control" value="{{ $direccionP->municipio }}"></div>
                                <div class="col-12"><label class="form-label" for="cpP">Código postal</label><input name="cpP" id="cpP" type="number" class="form-control" value="{{ $direccionP->cp }}"></div>
                                <div class="col-12"><label class="form-label" for="direccionP">Dirección</label><input name="direccionP" id="direccionP" class="form-control" value="{{ $direccionP->direccion }}"></div>
                                <div class="col-12"><label class="form-label" for="coloniaP">Colonia</label><input name="coloniaP" id="coloniaP" class="form-control" value="{{ $direccionP->colonia }}"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h3 class="h6 text-primary">Madre o tutora femenina</h3>
                            <div class="row g-2">
                                <div class="col-12"><label class="form-label" for="nomMa">Nombre</label><input required type="text" name="nomMa" id="nomMa" class="form-control" value="{{ $dMad->nombre }}"></div>
                                <div class="col-md-4"><label class="form-label" for="EdadMa">Edad</label><input required type="number" name="EdadMa" id="EdadMa" class="form-control" value="{{ $dMad->edad }}"></div>
                                <div class="col-md-8"><label class="form-label" for="TelMa">Teléfono</label><input required type="text" name="TelMa" id="TelMa" class="form-control" value="{{ $dMad->tel }}"></div>
                                <div class="col-12"><label class="form-label" for="ProfMa">Profesión</label><input required type="text" id="ProfMa" name="ProfMa" class="form-control" value="{{ $dMad->profesion }}"></div>
                                <div class="col-12">
                                    <label class="form-label d-block">¿Trabaja?</label>
                                    @foreach(['Si','No'] as $trabaja)
                                        <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="trMad" id="trMad{{ $trabaja }}" value="{{ $trabaja }}" @checked(($dMad->ocupacion ?? 'No') == $trabaja)><label class="form-check-label">{{ $trabaja }}</label></div>
                                    @endforeach
                                </div>
                                <div class="col-12"><label class="form-label" for="trabMtext">Ocupación</label><input type="text" name="trabMtext" id="trabMtext" class="form-control" value="{{ $dMad->ocupacion }}"></div>
                                <div class="col-12"><label class="form-label" for="estadoM">Estado</label><input name="estadoM" id="estadoM" class="form-control" value="{{ $direccionM->estado }}"></div>
                                <div class="col-12"><label class="form-label" for="municipioM">Municipio</label><input name="municipioM" id="municipioM" class="form-control" value="{{ $direccionM->municipio }}"></div>
                                <div class="col-12"><label class="form-label" for="cpM">Código postal</label><input name="cpM" id="cpM" type="number" class="form-control" value="{{ $direccionM->cp }}"></div>
                                <div class="col-12"><label class="form-label" for="direccionM">Dirección</label><input name="direccionM" id="direccionM" class="form-control" value="{{ $direccionM->direccion }}"></div>
                                <div class="col-12"><label class="form-label" for="coloniaM">Colonia</label><input name="coloniaM" id="coloniaM" class="form-control" value="{{ $direccionM->colonia }}"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div class="profile-actions">
            <button type="submit" class="btn btn-primary rounded-pill px-4">
                <i class="fas fa-save me-2"></i>Guardar ficha
            </button>
        </div>
    </form>
</div>
@endsection
