@extends('template.molde')

@section('title','Destinatarios')

@section('ruta')
<a class="text-decoration-none" href="{{ route('mensajes.index') }}">Mensajes</a> / Destinatarios
@endsection

@section('contenido')
<div class="messages-toolbar">
    <div><h1>Destinatarios</h1><p>Estado de lectura por persona.</p></div>
    <a href="{{ route('mensajes.enviados') }}" class="btn btn-outline-secondary rounded-pill"><i class="fa-solid fa-arrow-left me-2"></i>Enviados</a>
</div>
<div class="message-panel">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light"><tr><th>Usuario</th><th>Estado</th><th>Fecha visto</th></tr></thead>
            <tbody>
            @forelse($receptores as $receptor)
                <tr>
                    <td><div class="message-sender"><span class="message-avatar"><i class="fa-solid fa-user"></i></span><strong>{{ $receptor->usuario_nombre }}</strong></div></td>
                    <td>{!! $receptor->visto == 'true' ? '<span class="badge rounded-pill bg-success">Leído</span>' : '<span class="badge rounded-pill bg-secondary">Pendiente</span>' !!}</td>
                    <td>{{ $receptor->visto == 'true' ? $receptor->fecha_visto : '—' }}</td>
                </tr>
            @empty
                <tr><td colspan="3" class="text-center text-muted py-5">Este mensaje no tiene destinatarios registrados.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
