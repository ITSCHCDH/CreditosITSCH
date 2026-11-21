@extends('template.molde')

@section('title','Responsables asignados')

@section('links')
<style>
    .responsible-breadcrumb,.responsible-control,.responsible-card{border:1px solid #e7edf4;border-radius:1rem;background:#fff;box-shadow:0 .75rem 1.5rem rgba(29,78,116,.10),0 .18rem .45rem rgba(16,43,74,.06)}
    .responsible-breadcrumb{display:flex;align-items:center;gap:.65rem;min-height:64px;margin-bottom:.75rem;padding:.8rem 1rem;color:#64748b}
    .responsible-breadcrumb i{width:38px;height:38px;display:grid;place-items:center;border-radius:.7rem;color:#173c66;background:#edf3f8}
    .responsible-breadcrumb strong{color:#102b4a}
    .responsible-control{display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1rem;padding:.9rem 1rem}
    .responsible-control h1{margin:0;color:#102b4a;font-size:1.25rem;font-weight:700}
    .responsible-control p{margin:.2rem 0 0;color:#6b7280;font-size:.88rem}
    .responsible-card{overflow:hidden}
    .responsible-card-head{display:flex;align-items:center;gap:.75rem;padding:1rem 1.25rem;border-bottom:1px solid #edf1f5;background:#f8fafc}
    .responsible-card-head i{width:38px;height:38px;display:grid;place-items:center;border-radius:.7rem;color:#173c66;background:#edf3f8}
    .responsible-card-head h2{margin:0;color:#102b4a;font-size:1.05rem}
    .responsible-row{display:grid;grid-template-columns:minmax(220px,1fr) 180px 100px;align-items:center;gap:.75rem;padding:.85rem 1.25rem;border-bottom:1px solid #edf1f5}
    .responsible-row:last-child{border-bottom:0}
    .responsible-name{display:flex;align-items:center;gap:.65rem;font-weight:600;color:#334155}
    .responsible-avatar{width:38px;height:38px;display:grid;place-items:center;border-radius:.7rem;color:#173c66;background:#edf3f8}
    @media(max-width:767.98px){.responsible-control{align-items:flex-start;flex-direction:column}.responsible-row{grid-template-columns:1fr 1fr}.responsible-row>div:nth-child(3){grid-column:1/-1;text-align:right}}
</style>
@endsection

@section('contenido')
@if($actividad != null)
    <div class="responsible-breadcrumb"><i class="fa-solid fa-users-gear"></i><div><a class="text-decoration-none" href="{{ route('actividades.index') }}">Actividades</a><span class="mx-2">/</span><strong>{{ $actividad->nombre }}</strong><span class="mx-2">/</span>Responsables</div></div>
    <div class="responsible-control">
        <div><h1>Responsables asignados</h1><p>Gestiona usuarios responsables de esta actividad.</p></div>
        @if($actividad->vigente=='true')
            @if(Auth::User()->hasAnyPermission(['VIP','VIP_ACTIVIDAD']) || (Auth::User()->hasAllPermissions(['AGREGAR_RESPONSABLES','ELIMINAR_RESPONSABLES']) && $actividad->id_user==Auth::User()->id))
                <a href="{{ route('responsables.index',$actividad->id) }}" class="btn btn-primary rounded-pill"><i class="fa-solid fa-user-plus me-2"></i>Asignar responsables</a>
            @endif
        @endif
    </div>
    <article class="responsible-card">
        <div class="responsible-card-head"><i class="fa-solid fa-user-check"></i><h2>Lista de responsables</h2></div>
        @if($responsables != null && $responsables->count())
            <div class="d-none d-md-grid responsible-row border-bottom table-light"><strong>Nombre</strong><strong>Área</strong><strong class="text-end">Acción</strong></div>
            @foreach($responsables as $res)
                <div class="responsible-row">
                    <div class="responsible-name"><span class="responsible-avatar"><i class="fa-solid fa-user"></i></span><span>{{ $res->name }}</span></div>
                    <div>{{ $res->area }}</div>
                    <div class="text-end">
                        @if($actividad->vigente=='true' && Auth::User()->hasAnyPermission(['ELIMINAR_RESPONSABLES','VIP','VIP_ACTIVIDAD']))
                            @if(Auth::User()->hasAnyPermission(['VIP','VIP_ACTIVIDAD']) || $actividad->id_user==Auth::User()->id)
                                <button type="button" class="btn btn-outline-danger btn-sm rounded-3" data-mdb-toggle="modal" data-mdb-target="#modEliminarResponsable" onclick="eliminarResponsable({{ $res->actividad_evidencia_id }})" title="Quitar responsable"><i class="fa-solid fa-user-minus"></i></button>
                            @else
                                <span class="text-muted">Sin acción</span>
                            @endif
                        @else
                            <span class="badge rounded-pill bg-secondary">Actividad cerrada</span>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <div class="text-center text-muted py-5"><i class="fa-solid fa-users fa-2x mb-3"></i><div>No hay responsables asignados.</div></div>
        @endif
    </article>
@else
    <div class="responsible-breadcrumb"><i class="fa-solid fa-triangle-exclamation"></i><div><strong>Actividad no encontrada</strong></div></div>
@endif

<div class="modal fade" id="modEliminarResponsable" tabindex="-1" aria-labelledby="tituloEliminarResponsable" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title" id="tituloEliminarResponsable">Eliminar responsable</h5><button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Cerrar"></button></div>
            <div class="modal-body">¿Estás seguro de quitar este responsable de la actividad?</div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Cancelar</button><form id="formEliminarResponsable" method="POST" action="">@csrf @method('DELETE')<button type="submit" class="btn btn-danger">Eliminar</button></form></div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
function eliminarResponsable(activityEvidenceId){
    $('#formEliminarResponsable').attr('action',"{{ url('/admin/actividad_evidencias') }}/"+activityEvidenceId);
}
</script>
@endsection
