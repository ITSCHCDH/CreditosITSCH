@extends('template.molde')

@section('title','Mensajes')

@section('links')
<style>
    .messages-toolbar { display:flex; align-items:flex-end; justify-content:space-between; gap:1rem; margin-bottom:1rem; }
    .messages-toolbar h1 { margin:0; color:#102b4a; font-size:clamp(1.5rem,3vw,2.1rem); font-weight:700; }
    .messages-toolbar p { margin:.35rem 0 0; color:#6b7280; }
    .message-actions { display:flex; gap:.55rem; flex-wrap:wrap; }
    .message-actions .btn { border-radius:.75rem; }
    .message-panel { border:1px solid #e7edf4; border-radius:1.1rem; background:#fff; overflow:hidden; box-shadow:0 .55rem 1.5rem rgba(29,78,116,.07); }
    .message-panel table { margin:0; }
    .message-panel tbody tr.unread { background:#f5f9fd; }
    .message-panel tbody tr.unread td { font-weight:600; color:#102b4a; }
    .message-sender { display:flex; align-items:center; gap:.65rem; }
    .message-avatar { width:38px; height:38px; display:grid; place-items:center; flex:0 0 auto; border-radius:.7rem; color:#173c66; background:#edf3f8; }
    .message-status { width:9px; height:9px; display:inline-block; border-radius:50%; background:#cbd5e1; }
    .message-status.unread { background:#2563a8; box-shadow:0 0 0 .18rem rgba(37,99,168,.12); }
    @media (max-width:767.98px) {
        .messages-toolbar { align-items:flex-start; flex-direction:column; }
        .message-actions { width:100%; }
        .message-actions .btn { flex:1; }
    }
</style>
@endsection

@section('ruta')
<a class="text-decoration-none" href="{{ route('home') }}">Inicio</a> / Mensajes
@endsection

@section('contenido')
<div class="messages-toolbar">
    <div>
        <h1>Bandeja de entrada</h1>
        <p>Mensajes recibidos, estados de lectura y notificaciones.</p>
    </div>
    <div class="message-actions">
        <a href="{{ route('mensajes.crear') }}" class="btn btn-primary" title="Crear mensaje">
            <i class="fa-solid fa-envelope me-2"></i>Crear
        </a>
        <a href="{{ route('mensajes.enviados') }}" class="btn btn-warning text-dark" title="Mensajes enviados">
            <i class="fa-solid fa-paper-plane me-2"></i>Enviados
        </a>
        <a href="{{ route('mensajes.vistos') }}" class="btn btn-success" title="Mensajes leídos">
            <i class="fa-solid fa-envelope-open me-2"></i>Leídos
        </a>
    </div>
</div>

<div class="message-panel">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Estado</th>
                    <th>Remitente</th>
                    <th>Asunto</th>
                    <th>Fecha</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mensajes as $msj)
                    <tr class="{{ $msj->visto != 'true' ? 'unread' : '' }}">
                        <td><span class="message-status {{ $msj->visto != 'true' ? 'unread' : '' }}" title="{{ $msj->visto == 'true' ? 'Leído' : 'No leído' }}"></span></td>
                        <td>
                            <div class="message-sender">
                                <span class="message-avatar"><i class="fa-solid fa-user"></i></span>
                                <span>{{ $msj->usuario_nombre }}</span>
                            </div>
                        </td>
                        <td>{{ $msj->notificacion }}</td>
                        <td>{{ $msj->fecha }}</td>
                        <td class="text-end">
                            <a href="{{ route('mensajes.ver',['mensaje_id'=>$msj->mensaje_id,'receptor_id'=>$msj->receptor_id]) }}" class="btn btn-outline-primary btn-sm rounded-3" title="Abrir mensaje">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            @if($msj->visto != 'true')
                                <a href="{{ route('mensajes.eliminar',['mensaje_id'=>$msj->mensaje_id,'receptor_id'=>$msj->receptor_id]) }}" class="btn btn-outline-danger btn-sm rounded-3 ms-1" title="Marcar como eliminado">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-5"><i class="fa-solid fa-inbox fa-2x mb-3"></i><div>No tienes mensajes pendientes.</div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('js')
@endsection
