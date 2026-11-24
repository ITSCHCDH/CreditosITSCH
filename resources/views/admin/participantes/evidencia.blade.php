@extends('template.molde')

@section('title','Evidencias del participante')

@section('ruta')
    <span class="d-inline-flex align-items-center flex-wrap gap-2">
        <i class="fa-solid fa-images" style="color:#2d6da3"></i>
        <a href="{{ route('participantes.index') }}" class="text-decoration-none">Participantes</a>
        <span class="text-muted">/</span>
        Evidencias
    </span>
@endsection

@push('styles')
<style>
    .evidencia-resumen,.evidencia-card{border:1px solid #e7edf4;border-radius:1rem;background:#fff;box-shadow:0 .75rem 1.5rem rgba(29,78,116,.10),0 .18rem .45rem rgba(16,43,74,.06)}
    .evidencia-resumen-head{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:1rem;padding:1rem 1.25rem;border-bottom:1px solid #edf1f5;background:#f8fafc;border-radius:1rem 1rem 0 0}
    .evidencia-resumen-head h1{margin:0;color:#102b4a;font-size:1.15rem;font-weight:700}
    .evidencia-resumen-head p{margin:.2rem 0 0;color:#6b7280;font-size:.86rem}
    .evidencia-resumen-body{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:0;padding:1rem 1.25rem}
    .evidencia-dato{min-width:0;padding:.25rem 1rem;border-right:1px solid #edf1f5}
    .evidencia-dato:first-child{padding-left:0}
    .evidencia-dato:last-child{padding-right:0;border-right:0}
    .evidencia-dato span{display:block;margin-bottom:.2rem;color:#6b7280;font-size:.75rem;text-transform:uppercase;letter-spacing:.03em}
    .evidencia-dato strong{display:block;overflow:hidden;text-overflow:ellipsis;color:#102b4a;font-size:.92rem;white-space:nowrap}
    .evidencia-icon{width:44px;height:44px;flex:0 0 44px;display:grid;place-items:center;border-radius:.8rem;color:#173c66;background:#edf3f8}
    .evidencia-validacion{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:.75rem;margin:1rem 0;padding:.9rem 1rem;border:1px solid #dce8f3;border-radius:.9rem;background:#f3f8fc}
    .evidencia-validacion h2{margin:0;color:#102b4a;font-size:.95rem;font-weight:700}
    .evidencia-validacion p{margin:.2rem 0 0;color:#64748b;font-size:.8rem}
    .evidencia-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:1rem}
    .evidencia-card{overflow:hidden;transition:transform .15s ease,box-shadow .15s ease}
    .evidencia-card:hover{transform:translateY(-2px);box-shadow:0 1rem 2rem rgba(29,78,116,.14),0 .2rem .5rem rgba(16,43,74,.07)}
    .evidencia-preview{position:relative;height:220px;overflow:hidden;background:#edf2f7}
    .evidencia-preview img{width:100%;height:100%;object-fit:cover;transition:transform .25s ease}
    .evidencia-preview:hover img{transform:scale(1.025)}
    .evidencia-preview-file{height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:.65rem;color:#b91c1c;background:linear-gradient(145deg,#fff4f4,#f1f5f9)}
    .evidencia-preview-file i{font-size:3.25rem}
    .evidencia-preview-file span{color:#64748b;font-size:.8rem;font-weight:600}
    .evidencia-tipo{position:absolute;top:.7rem;left:.7rem;padding:.2rem .55rem;border-radius:999px;background:rgba(16,43,74,.88);color:#fff;font-size:.72rem;font-weight:600;letter-spacing:.03em}
    .evidencia-card-body{padding:1rem}
    .evidencia-card-title{margin:0 0 .7rem;overflow:hidden;text-overflow:ellipsis;color:#102b4a;font-size:.92rem;font-weight:600;white-space:nowrap}
    .evidencia-meta{display:grid;gap:.45rem;margin:0;color:#64748b;font-size:.8rem}
    .evidencia-meta div{display:flex;align-items:center;gap:.5rem;min-width:0}
    .evidencia-meta i{width:16px;color:#2d6da3;text-align:center}
    .evidencia-meta span{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
    .evidencia-card-actions{display:flex;justify-content:flex-end;gap:.4rem;margin-top:.9rem;padding-top:.85rem;border-top:1px solid #edf1f5}
    .evidencia-empty{padding:3rem 1rem;border:1px dashed #cbd5e1;border-radius:1rem;background:#fff;text-align:center;color:#64748b}
    .evidencia-empty i{display:block;margin-bottom:.75rem;color:#9db0c5;font-size:2.25rem}
    @media(max-width:991.98px){.evidencia-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}
    @media(max-width:767.98px){
        .evidencia-resumen-body{grid-template-columns:1fr;gap:.7rem}
        .evidencia-dato{padding:0 0 .7rem;border-right:0;border-bottom:1px solid #edf1f5}
        .evidencia-dato:last-child{padding-bottom:0;border-bottom:0}
        .evidencia-grid{grid-template-columns:1fr}
        .evidencia-validacion{align-items:stretch}
        .evidencia-validacion .btn{width:100%}
    }
</style>
@endpush

@section('contenido')
@php
    $registroValidacion = $validado->first();
    $actividadValidada = $registroValidacion?->validado === 'true';
    $evidenciaPosteriorPendiente = $participante_data->momento_agregado === 'posteriormente'
        && $participante_data->evidencia_validada === 'no';
    $puedeEliminar = ! $actividadValidada || $evidenciaPosteriorPendiente;
    $puedeValidarParticipante = Auth::User()->hasAnyPermission(['VIP','VIP_EVIDENCIA','VIP_ACTIVIDAD','VERIFICAR_EVIDENCIA'])
        && $actividadValidada
        && $evidenciaPosteriorPendiente;
@endphp

<div id="mensaje-parte-superior"></div>

<article class="evidencia-resumen mb-3">
    <div class="evidencia-resumen-head">
        <div class="d-flex align-items-center gap-3">
            <span class="evidencia-icon"><i class="fa-solid fa-folder-open"></i></span>
            <div>
                <h1>Evidencias del participante</h1>
                <p>Consulta los archivos y su estado de validación.</p>
            </div>
        </div>
        <div class="d-flex flex-wrap align-items-center justify-content-end gap-2">
            <span class="badge rounded-pill {{ $actividadValidada && ! $evidenciaPosteriorPendiente ? 'bg-success' : 'bg-warning text-dark' }}">
                <i class="fa-solid {{ $actividadValidada && ! $evidenciaPosteriorPendiente ? 'fa-circle-check' : 'fa-clock' }} me-1"></i>
                {{ $actividadValidada && ! $evidenciaPosteriorPendiente ? 'Validado' : 'Pendiente de validación' }}
            </span>
            @if($registroValidacion && Auth::User()->hasAnyPermission(['VIP','VIP_EVIDENCIA','VERIFICAR_EVIDENCIA']))
                <a
                    href="{{ route('verifica_evidencia.ver_evidencia', $registroValidacion->id) }}"
                    class="btn btn-sm btn-primary"
                >
                    <i class="fa-solid fa-circle-check me-2"></i>Ir a verificar
                </a>
            @endif
        </div>
    </div>
    <div class="evidencia-resumen-body">
        <div class="evidencia-dato">
            <span>Actividad</span>
            <strong title="{{ $actividad?->nombre }}">{{ $actividad?->nombre ?? 'Actividad no disponible' }}</strong>
        </div>
        <div class="evidencia-dato">
            <span>Alumno</span>
            <strong title="{{ $alumno?->nombreCompleto }}">{{ $alumno?->nombreCompleto ?? 'Alumno no disponible' }}</strong>
        </div>
        <div class="evidencia-dato">
            <span>Número de control</span>
            <strong>{{ $participante->no_control }}</strong>
        </div>
    </div>
</article>

@if($puedeValidarParticipante)
    <div class="evidencia-validacion">
        <div>
            <h2><i class="fa-solid fa-user-check me-2"></i>Evidencia agregada posteriormente</h2>
            <p>El participante requiere una validación individual antes de completar el registro.</p>
        </div>
        <form action="{{ route('participantes.validar_evidencia') }}" method="post">
            @csrf
            <input type="hidden" name="participante_id" value="{{ $participante->id }}">
            <button type="submit" class="btn btn-success">
                <i class="fa-solid fa-check me-2"></i>Validar evidencia
            </button>
        </form>
    </div>
@endif

@if($evidencias->isNotEmpty())
    <div class="d-flex align-items-center justify-content-between gap-2 mb-3">
        <h2 class="h5 mb-0" style="color:#102b4a">
            <i class="fa-regular fa-images me-2"></i>Archivos
            <span class="badge rounded-pill bg-light text-dark">{{ $evidencias->count() }}</span>
        </h2>
    </div>

    <div class="evidencia-grid">
        @foreach ($evidencias as $evidencia)
            @php
                $extension = strtolower(pathinfo($evidencia->evidencia_nombre, PATHINFO_EXTENSION));
                $esImagen = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'], true);
                $urlEvidencia = asset('storage/evidencias/'.$evidencia->actividad_nombre.'/'.$evidencia->evidencia_nombre);
            @endphp
            <article class="evidencia-card" id="evidencia-{{ $evidencia->evidencia_id }}">
                <a href="{{ $urlEvidencia }}" class="evidencia-preview d-block" target="_blank" rel="noopener" title="Abrir {{ $evidencia->evidencia_nombre }}">
                    <span class="evidencia-tipo">{{ strtoupper($extension ?: 'ARCHIVO') }}</span>
                    @if($esImagen)
                        <img src="{{ $urlEvidencia }}" alt="Evidencia {{ $loop->iteration }}" loading="lazy">
                    @else
                        <span class="evidencia-preview-file">
                            <i class="fa-solid {{ $extension === 'pdf' ? 'fa-file-pdf' : 'fa-file' }}"></i>
                            <span>{{ strtoupper($extension ?: 'ARCHIVO') }}</span>
                        </span>
                    @endif
                </a>
                <div class="evidencia-card-body">
                    <h3 class="evidencia-card-title" title="{{ $evidencia->evidencia_nombre }}">{{ $evidencia->evidencia_nombre }}</h3>
                    <div class="evidencia-meta">
                        <div><i class="fa-solid fa-user-tie"></i><span title="{{ $evidencia->usuario_nombre }}">{{ $evidencia->usuario_nombre }}</span></div>
                        <div><i class="fa-regular fa-calendar"></i><span>{{ \Illuminate\Support\Carbon::parse($evidencia->fecha)->format('d/m/Y H:i') }}</span></div>
                    </div>
                    <div class="evidencia-card-actions">
                        <a href="{{ $urlEvidencia }}" class="btn btn-sm btn-outline-primary" target="_blank" rel="noopener" title="Abrir evidencia">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        </a>
                        @if($puedeEliminar)
                            <button
                                type="button"
                                class="btn btn-sm btn-outline-danger eliminar-evidencia"
                                data-mdb-toggle="modal"
                                data-mdb-target="#modalEliminarEvidencia"
                                data-actividad="{{ $evidencia->actividad_nombre }}"
                                data-archivo="{{ $evidencia->evidencia_id }}"
                                data-archivo-nombre="{{ $evidencia->evidencia_nombre }}"
                                title="Eliminar evidencia"
                            >
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        @endif
                    </div>
                </div>
            </article>
        @endforeach
    </div>
@else
    <div class="evidencia-empty">
        <i class="fa-regular fa-folder-open"></i>
        <strong>No hay evidencias registradas para este participante.</strong>
    </div>
@endif

<div class="modal fade" id="modalEliminarEvidencia" tabindex="-1" aria-labelledby="modalEliminarEvidenciaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title h5 mb-0" id="modalEliminarEvidenciaLabel">Eliminar evidencia</h2>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <p class="mb-2">¿Seguro que deseas eliminar este archivo?</p>
                <strong id="nombreEvidenciaEliminar"></strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-mdb-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmarEliminarEvidencia">
                    <i class="fa-solid fa-trash-can me-2"></i>Eliminar
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    let evidenciaSeleccionada = null;

    document.querySelectorAll('.eliminar-evidencia').forEach(function (boton) {
        boton.addEventListener('click', function () {
            evidenciaSeleccionada = {
                boton: boton,
                actividad: boton.dataset.actividad,
                archivo: boton.dataset.archivo,
                archivoNombre: boton.dataset.archivoNombre
            };
            document.getElementById('nombreEvidenciaEliminar').textContent = evidenciaSeleccionada.archivoNombre;
        });
    });

    document.getElementById('confirmarEliminarEvidencia')?.addEventListener('click', function () {
        if (!evidenciaSeleccionada) {
            return;
        }

        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: "{{ route('participantes.eliminar_evidencia') }}",
            data: {
                actividad: evidenciaSeleccionada.actividad,
                archivo: evidenciaSeleccionada.archivo,
                archivo_nombre: evidenciaSeleccionada.archivoNombre,
                no_control: "{{ $participante->no_control }}"
            },
            success: function (response) {
                mostrarMensaje(response.mensaje, 'mensaje-parte-superior', response.tipo);
                if (response.tipo === 'exito') {
                    document.getElementById('evidencia-' + evidenciaSeleccionada.archivo)?.remove();
                    evidenciaSeleccionada = null;
                    const modal = mdb.Modal.getInstance(document.getElementById('modalEliminarEvidencia'));
                    if (modal) {
                        modal.hide();
                    }
                }
            },
            error: function () {
                mostrarMensaje('No fue posible eliminar la evidencia.', 'mensaje-parte-superior', 'error');
            }
        });
    });
</script>
@endsection
