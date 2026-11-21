@extends('template.molde')

@section('title','Mensajes vistos')

@section('ruta')
<a class="text-decoration-none" href="{{ route('mensajes.index') }}">Mensajes</a> / Mensajes vistos
@endsection

@section('contenido')
<div class="messages-toolbar">
    <div><h1>Mensajes vistos</h1><p>Historial de mensajes ya abiertos o marcados como vistos.</p></div>
    <div class="message-actions">
        <a href="{{ route('mensajes.crear') }}" class="btn btn-primary rounded-pill"><i class="fa-solid fa-plus me-2"></i>Crear</a>
        <a href="{{ route('mensajes.enviados') }}" class="btn btn-warning rounded-pill text-dark"><i class="fa-solid fa-paper-plane me-2"></i>Enviados</a>
    </div>
</div>
<div class="message-panel">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light"><tr><th>Remitente</th><th>Asunto</th><th>Fecha</th><th class="text-end">Acción</th></tr></thead>
            <tbody>
            @forelse($mensajes as $msj)
                <tr>
                    <td><div class="message-sender"><span class="message-avatar"><i class="fa-solid fa-user"></i></span><span>{{ $msj->usuario_nombre }}</span></div></td>
                    <td>{{ $msj->notificacion }}</td>
                    <td>{{ $msj->fecha }}</td>
                    <td class="text-end"><a href="{{ route('mensajes.ver',['mensaje_id'=>$msj->mensaje_id,'receptor_id'=>$msj->receptor_id]) }}" class="btn btn-outline-primary btn-sm rounded-3"><i class="fa-solid fa-eye"></i></a></td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-muted py-5"><i class="fa-solid fa-envelope-open fa-2x mb-3"></i><div>No hay mensajes vistos.</div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
