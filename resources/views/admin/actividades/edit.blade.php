@extends('template.molde')

@section('title','Editar actividad')

@section('links')
<style>
    .activity-breadcrumb { display:flex;align-items:center;gap:.65rem;min-height:64px;margin-bottom:.75rem;padding:.8rem 1rem;border:1px solid #e7edf4;border-radius:1rem;background:#fff;color:#64748b;box-shadow:0 .75rem 1.5rem rgba(29,78,116,.10),0 .18rem .45rem rgba(16,43,74,.06); }
    .activity-breadcrumb i { width:38px;height:38px;display:grid;place-items:center;border-radius:.7rem;color:#173c66;background:#edf3f8; }
    .activity-breadcrumb strong { color:#102b4a; }
    .activity-control { display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1rem;padding:.8rem 1rem;border:1px solid #e7edf4;border-radius:1rem;background:#fff;box-shadow:0 .75rem 1.5rem rgba(29,78,116,.10),0 .18rem .45rem rgba(16,43,74,.06); }
    .activity-control h1 { margin:0;color:#102b4a;font-size:1.25rem;font-weight:700; }
    .activity-control p { margin:.2rem 0 0;color:#6b7280;font-size:.88rem; }
    .activity-form-card { max-width:760px;margin:auto;border:1px solid #e7edf4;border-radius:1.1rem;background:#fff;box-shadow:0 1rem 2.25rem rgba(29,78,116,.12),0 .25rem .65rem rgba(16,43,74,.07);overflow:hidden; }
    .activity-form-head { display:flex;align-items:center;gap:.75rem;padding:1rem 1.25rem;border-bottom:1px solid #edf1f5;background:#f8fafc; }
    .activity-form-head i { width:38px;height:38px;display:grid;place-items:center;border-radius:.7rem;color:#173c66;background:#edf3f8; }
    .activity-form-head h2 { margin:0;color:#102b4a;font-size:1.05rem; }
    .activity-form-body { padding:1.25rem; }
    .activity-form .form-control,.activity-form .form-select { min-height:48px;border-radius:.75rem; }
</style>
@endsection

@section('contenido')
<div class="activity-breadcrumb"><i class="fa-solid fa-layer-group"></i><div><a class="text-decoration-none" href="{{ route('actividades.index') }}">Actividades</a><span class="mx-2">/</span><strong>Editar actividad</strong></div></div>
<div class="activity-control"><div><h1>Editar actividad</h1><p>Modifica los datos y conserva las evidencias validadas.</p></div><a href="{{ route('actividades.index') }}" class="btn btn-outline-secondary rounded-pill"><i class="fa-solid fa-arrow-left me-2"></i>Volver</a></div>
<article class="activity-form-card">
    <div class="activity-form-head"><i class="fa-solid fa-pencil"></i><h2>Datos de la actividad</h2></div>
    <div class="activity-form-body">
        <form action="{{ route('actividades.update', $actividad->id) }}" method="post" class="activity-form">
            @csrf
            <div class="row g-3">
                <div class="col-md-8"><label class="form-label" for="nombre">Nombre</label><input value="{{ $actividad->nombre }}" type="text" id="nombre" class="form-control" name="nombre" required></div>
                <div class="col-md-4"><label class="form-label" for="por_cred_actividad">Porcentaje</label><input value="{{ $actividad->por_cred_actividad }}" type="number" min="0" max="100" id="por_cred_actividad" class="form-control" name="por_cred_actividad" required></div>
                <div class="col-md-7"><label class="form-label" for="select-category">Crédito</label><select id="select-category" name="id_actividad" class="form-select" required>@foreach($creditos as $cred)<option value="{{ $cred->id }}" @selected($cred->id==$actividad->id_actividad)>{{ $cred->nombre }}</option>@endforeach</select></div>
                <div class="col-md-5"><label class="form-label" for="fecCierre">Fecha de cierre</label><input value="{{ $actividad->fecCierre }}" type="date" class="form-control" name="fecCierre" id="fecCierre" required></div>
                @if(Auth::User()->hasAnyPermission(['VIP','CREAR_ACTIVIDAD_ALUMNOS','VIP_ACTIVIDAD']))
                    <div class="col-md-6"><label class="form-label" for="alumnos">Alumnos responsables</label><select id="alumnos" name="alumnos" class="form-select" required><option value="false" @selected($actividad->alumnos!='true')>NO</option><option value="true" @selected($actividad->alumnos=='true')>SI</option></select></div>
                @endif
                <div class="col-md-6"><label class="form-label" for="vigente">Vigencia</label><select id="vigente" name="vigente" class="form-select" required><option value="false" @selected($actividad->vigente!='true')>NO</option><option value="true" @selected($actividad->vigente=='true')>SI</option></select></div>
                <div class="col-12 d-flex justify-content-end gap-2 pt-2"><a href="{{ route('actividades.index') }}" class="btn btn-outline-secondary rounded-pill">Cancelar</a><button type="submit" class="btn btn-primary rounded-pill px-4"><i class="fa-solid fa-floppy-disk me-2"></i>Guardar cambios</button></div>
            </div>
        </form>
    </div>
</article>
@endsection
