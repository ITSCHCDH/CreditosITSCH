@extends('template.molde')

@section('title','Ver mensaje')

@section('contenido')
<div class="message-breadcrumb-card">
    <i class="fa-solid fa-message"></i>
    <div>
        <a class="text-decoration-none" href="{{ route('mensajes.index') }}">Mensajes</a>
        @if($ruta)
            <span class="mx-2">/</span><a class="text-decoration-none" href="{{ route('mensajes.enviados') }}">Enviados</a>
        @endif
        <span class="mx-2">/</span><strong>Ver mensaje</strong>
    </div>
</div>
<div class="message-control-card">
    <div><h1>Contenido del mensaje</h1><p>Lectura y acciones relacionadas.</p></div>
    @if($ruta)
        <a href="{{ route('mensajes.enviados') }}" class="btn btn-outline-secondary rounded-pill"><i class="fa-solid fa-arrow-left me-2"></i>Enviados</a>
    @else
        <a href="{{ route('mensajes.index') }}" class="btn btn-outline-secondary rounded-pill"><i class="fa-solid fa-arrow-left me-2"></i>Bandeja</a>
    @endif
</div>
<div class="row justify-content-center">
    <div class="col-lg-9">
        <article class="message-panel">
            <div class="p-3 border-bottom d-flex align-items-center justify-content-between gap-2">
                <div class="d-flex align-items-center gap-3">
                    <span class="message-avatar"><i class="fa-solid fa-envelope-open-text"></i></span>
                    <div>
                        <h1 class="h5 mb-1">{{ $mensaje->notificacion }}</h1>
                        <div class="text-muted small">De: {{ $mensaje->name }}</div>
                    </div>
                </div>
                @if($ruta)
                    <a href="{{ route('mensajes.enviados') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                        <i class="fa-solid fa-arrow-left me-1"></i>Enviados
                    </a>
                @else
                    <a href="{{ route('mensajes.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                        <i class="fa-solid fa-arrow-left me-1"></i>Bandeja
                    </a>
                @endif
            </div>
            <div class="p-4">
                <div class="border rounded-3 p-3 bg-light" style="white-space:pre-line">{{ $mensaje->mensaje }}</div>
                @if(Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VIP_EVIDENCIA','VER_PARTICIPANTES']) && $actividad_id != null)
                    <button type="button" class="btn btn-success rounded-pill mt-3" onclick="redireccionar({{ $actividad_id }});">
                        <i class="fa-solid fa-users me-2"></i>Ver participantes
                    </button>
                @endif
            </div>
        </article>
    </div>
</div>
@endsection

@section('js')
<script>
function redireccionar(actividadId) {
    Cookies.set('participantes_actividad', actividadId, {expires:1});
    window.location.href = "{{ route('participantes.index') }}";
}
</script>
@endsection
