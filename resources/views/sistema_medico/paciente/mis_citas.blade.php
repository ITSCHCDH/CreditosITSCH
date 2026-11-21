@extends('template.molde')

@section('title','Mis citas médicas')

@section('links')
<style>
    .citas-header {
        display:flex; align-items:flex-end; justify-content:space-between; gap:1rem;
        margin-bottom:1.25rem;
    }
    .citas-header h1 { margin:.25rem 0 0; color:#102b4a; font-size:clamp(1.5rem,3vw,2.25rem); font-weight:700; }
    .citas-header p { margin:.35rem 0 0; color:#6b7280; }
    .citas-actions { display:flex; gap:.75rem; flex-wrap:wrap; }
    .citas-actions .btn { border-radius:.75rem; }
    .cita-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:1rem; }
    .cita-card {
        position:relative; overflow:hidden; border:1px solid #e7edf4; border-radius:1.1rem;
        background:#fff; box-shadow:0 .55rem 1.5rem rgba(29,78,116,.07);
    }
    .cita-card::before { content:""; position:absolute; inset:0 auto 0 0; width:5px; background:#173c66; }
    .cita-card-body { padding:1.25rem 1.25rem 1rem 1.5rem; }
    .cita-date { display:flex; align-items:center; gap:.75rem; margin-bottom:1rem; }
    .cita-date-icon {
        width:48px; height:48px; display:grid; place-items:center; border-radius:.85rem;
        color:#173c66; background:#edf3f8;
    }
    .cita-date strong { display:block; color:#102b4a; }
    .cita-date span { color:#6b7280; font-size:.9rem; }
    .cita-motive { min-height:44px; color:#374151; line-height:1.5; }
    .cita-meta { display:flex; justify-content:space-between; gap:.75rem; align-items:center; margin-top:1rem; }
    .cita-actions { display:flex; gap:.5rem; }
    .cita-actions .btn { width:38px; height:38px; display:inline-grid; place-items:center; border-radius:.65rem; padding:0; }
    .citas-empty {
        grid-column:1/-1; padding:3.5rem 1.25rem; border:1px dashed #cbd5e1; border-radius:1.1rem;
        text-align:center; color:#64748b; background:#fff;
    }
    .status-pendiente { background:#fff3cd!important; color:#7a5700!important; }
    .status-confirmada, .status-atendida { background:#d7efe1!important; color:#17643a!important; }
    .status-cancelada { background:#fde2e2!important; color:#991b1b!important; }
    @media (max-width:767px) {
        .citas-header { align-items:flex-start; flex-direction:column; }
        .cita-grid { grid-template-columns:1fr; }
        .citas-actions { width:100%; }
        .citas-actions .btn { flex:1; }
    }
</style>
@endsection

@section('ruta')
<a class="text-decoration-none" href="{{ route('alumnos.home_avance') }}">Inicio</a> / Sistema médico
@endsection

@section('contenido')
@php
    $esAlumno = Auth::guard('alumno')->check();
    $rutaCrear = $esAlumno ? 'paciente.alumno.create.cita' : 'paciente.create.cita';
    $rutaPerfil = $esAlumno ? 'paciente.alumno.editar.perfil' : 'paciente.editar.perfil';
@endphp
<div class="citas-header">
    <div>
        <h1>Mis citas médicas</h1>
        <p>Consulta tus próximas citas y su estado actual.</p>
    </div>
    <div class="citas-actions">
        <a href="{{ route($rutaPerfil) }}" class="btn btn-outline-primary">
            <i class="fas fa-user me-2"></i>Mi perfil
        </a>
        <a href="{{ route($rutaCrear) }}" class="btn btn-primary">
            <i class="fas fa-calendar-plus me-2"></i>Nueva cita
        </a>
    </div>
</div>

<div class="cita-grid">
    @forelse($citas as $cita)
        @php
            $estado = strtolower((string) $cita->estado_cita);
            $estadoClase = 'status-' . preg_replace('/[^a-z]+/', '-', $estado);
        @endphp
        <article class="cita-card">
            <div class="cita-card-body">
                <div class="cita-date">
                    <div class="cita-date-icon"><i class="fas fa-calendar-days"></i></div>
                    <div>
                        <strong>{{ \Carbon\Carbon::parse($cita->fecha_cita)->translatedFormat('d \\d\\e F \\d\\e Y') }}</strong>
                        <span>{{ \Carbon\Carbon::parse($cita->hora_cita)->format('h:i A') }}</span>
                    </div>
                </div>
                <div class="cita-motive">
                    {{ $cita->motivo_consulta ?: 'Sin motivo registrado.' }}
                </div>
                @if(!empty($cita->notas_adicionales))
                    <small class="text-muted d-block mt-2"><i class="fas fa-comment-medical me-1"></i>{{ $cita->notas_adicionales }}</small>
                @endif
                <div class="cita-meta">
                    <span class="badge rounded-pill px-3 py-2 {{ $estadoClase }}">{{ $cita->estado_cita ?: 'Pendiente' }}</span>
                    <div class="cita-actions">
                        <a href="{{ route($esAlumno ? 'paciente.alumno.editar.cita' : 'paciente.editar.cita', $cita->id) }}" class="btn btn-outline-warning" title="Editar cita" aria-label="Editar cita">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form id="form-eliminar-{{ $cita->id }}" action="{{ route($esAlumno ? 'paciente.alumno.destroy.cita' : 'paciente.destroy.cita', $cita->id) }}" method="POST">
                            @csrf
                            <button type="button" class="btn btn-outline-danger" onclick="fnEliminarCita({{ $cita->id }})" title="Eliminar cita" aria-label="Eliminar cita">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </article>
    @empty
        <div class="citas-empty">
            <i class="fas fa-calendar-xmark fa-3x mb-3"></i>
            <h2 class="h5">{{ isset($paciente) && $paciente ? 'Aún no tienes citas médicas' : 'Completa tu perfil médico' }}</h2>
            <p class="mb-3">{{ isset($paciente) && $paciente ? 'Programa una cita para comenzar tu seguimiento médico.' : 'Necesitas registrar tu perfil antes de programar una cita.' }}</p>
            <a href="{{ route($rutaPerfil) }}" class="btn btn-primary rounded-pill">
                {{ isset($paciente) && $paciente ? 'Crear primera cita' : 'Completar perfil' }}
            </a>
        </div>
    @endforelse
</div>
@endsection

@section('js')
<script>
function fnEliminarCita(citaId) {
    Swal.fire({
        title: '¿Eliminar cita?',
        text: 'Esta acción no se puede deshacer.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#173c66'
    }).then(function(result) {
        if (result.isConfirmed) {
            document.getElementById('form-eliminar-' + citaId).submit();
        }
    });
}
</script>
@endsection
