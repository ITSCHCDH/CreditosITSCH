@extends('template.molde')

@section('title','Mensajes enviados')

@section('ruta')
@endsection

@section('contenido')
<div class="message-breadcrumb-card">
    <i class="fa-solid fa-message"></i>
    <div><a class="text-decoration-none" href="{{ route('mensajes.index') }}">Mensajes</a><span class="mx-2">/</span><strong>Enviados</strong></div>
</div>
<div class="message-control-card">
    <div><h1>Mensajes enviados</h1><p>Consulta y revisa los destinatarios de tus mensajes.</p></div>
    <a href="{{ route('mensajes.crear') }}" class="btn btn-primary rounded-pill">
        <i class="fa-solid fa-plus me-2"></i>Nuevo mensaje
    </a>
</div>
<div class="message-panel">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light"><tr><th>Asunto</th><th>Fecha</th><th class="text-end">Acciones</th></tr></thead>
            <tbody>
            @forelse($mensajes as $msj)
                <tr>
                    <td><div class="d-flex align-items-center gap-2"><span class="message-avatar"><i class="fa-solid fa-paper-plane"></i></span><strong>{{ $msj->notificacion }}</strong></div></td>
                    <td>{{ $msj->created_at }}</td>
                    <td class="text-end">
                        <a href="{{ route('mensajes.destinatarios',['mensaje_id'=>$msj->id]) }}" class="btn btn-outline-primary btn-sm rounded-3"><i class="fa-solid fa-users me-1"></i>Destinatarios</a>
                        <a href="{{ route('mensajes.ver',['mensaje_id'=>$msj->id,'ruta'=>'true']) }}" class="btn btn-outline-warning btn-sm rounded-3 ms-1"><i class="fa-solid fa-eye me-1"></i>Ver</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3" class="text-center text-muted py-5"><i class="fa-solid fa-paper-plane fa-2x mb-3"></i><div>No hay mensajes enviados.</div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if(method_exists($mensajes,'links'))
        <div class="p-3">{{ $mensajes->links() }}</div>
    @endif
</div>
@endsection
