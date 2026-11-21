@extends('template.molde')

@section('title','Diagnóstico del alumno')

@section('ruta')
    <span class="d-inline-flex align-items-center flex-wrap gap-2">
        <i class="fa-solid fa-user-graduate" style="color:#2d6da3"></i>
        <a href="{{ route('analisis.index') }}" class="text-decoration-none d-none d-md-inline">Análisis de alumnos</a>
        <a href="{{ route('analisis.index') }}" class="text-decoration-none d-md-none">Análisis</a>
        <span class="text-muted">/</span>
        Diagnóstico
    </span>
@endsection

@push('styles')
<style>
    .diag-card{border:1px solid #e7edf4;border-radius:1rem;background:#fff;box-shadow:0 .75rem 1.5rem rgba(29,78,116,.10),0 .18rem .45rem rgba(16,43,74,.06)}
    .diag-card-head{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:.65rem;padding:1rem 1.25rem;border-bottom:1px solid #edf1f5;background:#f8fafc}
    .diag-card-head h2{margin:0;color:#102b4a;font-size:1.02rem;font-weight:700}
    .diag-card-body{padding:1.25rem}
    .diag-avatar{width:72px;height:72px;flex:0 0 72px;display:grid;place-items:center;border-radius:1rem;background:#edf3f8;color:#173c66;font-size:1.5rem;font-weight:700}
    .diag-name{margin:0;color:#102b4a;font-size:1.15rem;font-weight:700;line-height:1.25}
    .diag-sub{color:#6b7280;font-size:.85rem}
    .diag-meta{display:grid;gap:.6rem;margin-top:1rem;padding-top:1rem;border-top:1px solid #edf1f5}
    .diag-meta-row{display:flex;justify-content:space-between;gap:1rem;font-size:.88rem}
    .diag-meta-row span:first-child{color:#6b7280}
    .diag-meta-row strong{color:#102b4a;font-weight:600;text-align:right}
    .diag-grupo{display:inline-flex;align-items:center;gap:.3rem;margin:.2rem .25rem .2rem 0;padding:.2rem .55rem;border-radius:999px;background:#edf3f8;color:#173c66;font-size:.75rem}
    .diag-semaforos{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:.85rem}
    .diag-semaforo{display:flex;flex-direction:column;align-items:center;gap:.5rem;padding:1rem .6rem;border:1px solid #edf1f5;border-radius:.85rem;background:#fbfcfe;text-align:center}
    .diag-semaforo-label{color:#6b7280;font-size:.78rem;text-transform:uppercase;letter-spacing:.03em}
    .diag-legends{display:flex;flex-wrap:wrap;gap:.9rem;margin-top:1rem;color:#6b7280;font-size:.75rem}
    .diag-legends span{display:inline-flex;align-items:center;gap:.35rem}
    .diag-legends .CirculoNegro,.diag-legends .CirculoRojo,.diag-legends .CirculoNaranja,.diag-legends .CirculoAmarillo,.diag-legends .CirculoVerde,.diag-legends .CirculoAzul{display:inline-block;width:12px;height:12px;margin:0}
    .diag-table thead th{background:#f8fafc;color:#102b4a;font-size:.78rem;text-transform:uppercase;letter-spacing:.02em;border-bottom:1px solid #edf1f5;white-space:nowrap}
    .diag-table tbody td{vertical-align:middle}
    .diag-materia{min-width:220px}
    .diag-materia strong{display:block;color:#102b4a;font-size:.9rem}
    .diag-materia small{color:#6b7280}
    .diag-nota{display:inline-flex;align-items:center;justify-content:center;min-width:44px;padding:.25rem .5rem;border-radius:.5rem;font-weight:700;font-size:.82rem}
    .diag-nota--rojo{background:#fdeceb;color:#b3261e}
    .diag-nota--naranja{background:#fdf1e3;color:#b45309}
    .diag-nota--amarillo{background:#fdf8dd;color:#8a6d05}
    .diag-nota--verde{background:#e7f5ec;color:#1b7a43}
    .diag-nota--vacia{background:#f1f5f9;color:#94a3b8;font-weight:600}
    .diag-semestre td{padding:0!important;border-bottom:0!important}
    .diag-semestre div{margin:1rem 0 .35rem;padding:.5rem .85rem;border-radius:.6rem;background:#edf3f8;color:#173c66;font-weight:700;font-size:.86rem;text-transform:uppercase;letter-spacing:.03em}
    .diag-empty{padding:2.5rem 1rem;text-align:center;color:#64748b;font-size:.9rem}
    .diag-empty i{display:block;margin-bottom:.5rem;font-size:1.6rem;color:#c3d0de}
    .diag-obs{min-height:120px;resize:vertical}
    @media(max-width:767.98px){
        .diag-semaforos{grid-template-columns:repeat(2,minmax(0,1fr))}
        .diag-meta-row{flex-direction:column;gap:.15rem}
        .diag-meta-row strong{text-align:left}
    }
</style>
@endpush

@section('contenido')
    @php
        $iniciales = strtoupper(mb_substr((string) $alumnos->alu_Nombre, 0, 1).mb_substr((string) $alumnos->alu_ApePaterno, 0, 1));
        $nombreCompleto = trim($alumnos->alu_Nombre.' '.$alumnos->alu_ApePaterno.' '.$alumnos->alu_ApeMaterno);
        $estatusMap = [
            'VI' => ['Vigente', 'bg-success'],
            'BD' => ['Baja definitiva', 'bg-danger'],
            'BT' => ['Baja temporal', 'bg-warning text-dark'],
            'EG' => ['Egresado', 'bg-info text-dark'],
        ];
        [$estatusTexto, $estatusClase] = $estatusMap[$alumnos->alu_StatusAct] ?? ['Sin estatus', 'bg-secondary'];
        $motivos = [
            1 => 'Responsabilidad del alumno',
            2 => 'Inasistencia',
            3 => 'Complejidad de la materia',
            4 => 'Otro',
        ];
        $acreditaciones = [
            1 => ['Ordinario', 'bg-success'],
            2 => ['Regularización', 'bg-success'],
            3 => ['Extraordinario', 'bg-warning text-dark'],
            4 => ['Repetición', 'bg-warning text-dark'],
            5 => ['Repetición regularización', 'bg-warning text-dark'],
            6 => ['Examen especial A', 'bg-danger'],
            7 => ['Examen especial B', 'bg-danger'],
            91 => ['Convalidación', 'bg-info text-dark'],
            92 => ['Revalidación', 'bg-info text-dark'],
            93 => ['Equivalencia', 'bg-info text-dark'],
        ];
        $puedeEditarObs = Auth::User()->hasAnyPermission(['VIP_STA', 'STA_TUTOR', 'STA_DEP_TUTORIA']);
    @endphp

    <input type="hidden" name="no_Control" id="no_Control" value="{{ $alumnos->alu_NumControl }}">

    <div class="row g-3">
        {{-- Identidad del alumno --}}
        <div class="col-12 col-xl-4">
            <article class="diag-card h-100">
                <div class="diag-card-body">
                    <div class="d-flex align-items-center gap-3">
                        <span class="diag-avatar">{{ $iniciales !== '' ? $iniciales : '?' }}</span>
                        <div class="min-w-0">
                            <h1 class="diag-name">{{ $nombreCompleto }}</h1>
                            <div class="diag-sub"><i class="fa-solid fa-id-card me-1"></i>{{ $alumnos->alu_NumControl }}</div>
                        </div>
                    </div>

                    <div class="mt-3 d-flex flex-wrap gap-2">
                        <span class="badge rounded-pill {{ $estatusClase }}">{{ $estatusTexto }}</span>
                        <span class="badge rounded-pill bg-light text-dark">Semestre {{ $alumnos->alu_SemestreAct ?? '—' }}</span>
                        <span class="badge rounded-pill bg-light text-dark">{{ $alumnos->alu_Sexo }}</span>
                    </div>

                    <div class="diag-meta">
                        <div class="diag-meta-row">
                            <span>Carrera</span>
                            <strong>{{ $alumnos->car_Nombre ?? 'Sin carrera' }}</strong>
                        </div>
                        @if (is_object($grupos) ? $grupos->isNotEmpty() : count($grupos) > 0)
                            <div class="diag-meta-row">
                                <span>{{ trim($variablegrupo, ' :') ?: 'Grupos' }}</span>
                                <strong>
                                    @foreach ($grupos as $al)
                                        <span class="diag-grupo"><i class="fa-solid fa-users"></i>{{ $al->gse_Observaciones }}</span>
                                    @endforeach
                                </strong>
                            </div>
                        @endif
                    </div>
                </div>
            </article>
        </div>

        {{-- Semáforos --}}
        <div class="col-12 col-xl-8">
            <article class="diag-card h-100">
                <div class="diag-card-head">
                    <h2><i class="fa-solid fa-traffic-light me-2"></i>Semáforos del alumno</h2>
                    <span class="text-muted small">Pasá el cursor sobre cada indicador</span>
                </div>
                <div class="diag-card-body">
                    <div class="diag-semaforos">
                        <div class="diag-semaforo">
                            <div class="{{ $alumnos->semaforos['semaforoAcad'] }}" data-mdb-toggle="tooltip" title="{{ $alumnos->semaforos['titleAcad'] }}"></div>
                            <span class="diag-semaforo-label">Académico</span>
                        </div>
                        <div class="diag-semaforo">
                            <div class="{{ $alumnos->semaforos['semaforoMedico'] }}" data-mdb-toggle="tooltip" title="Semáforo médico"></div>
                            <span class="diag-semaforo-label">Médico</span>
                        </div>
                        <div class="diag-semaforo">
                            <div class="{{ $alumnos->semaforos['semaforoPsico'] }}" data-mdb-toggle="tooltip" title="Semáforo psicológico"></div>
                            <span class="diag-semaforo-label">Psicológico</span>
                        </div>
                        <div class="diag-semaforo">
                            <div class="{{ $alumnos->semaforos['semaforoServicio'] }}" data-mdb-toggle="tooltip" title="{{ $alumnos->semaforos['titleSS'] }}"></div>
                            <span class="diag-semaforo-label">Servicio social</span>
                        </div>
                    </div>

                    <div class="diag-legends">
                        <span><span class="CirculoVerde"></span>Sin riesgo</span>
                        <span><span class="CirculoAmarillo"></span>Leve</span>
                        <span><span class="CirculoNaranja"></span>Moderado</span>
                        <span><span class="CirculoRojo"></span>Grave</span>
                        <span><span class="CirculoNegro"></span>Sin datos</span>
                        <span><span class="CirculoAzul"></span>No aplica</span>
                    </div>
                </div>
            </article>
        </div>

        {{-- Calificaciones parciales --}}
        <div class="col-12">
            <article class="diag-card">
                <div class="diag-card-head">
                    <h2><i class="fa-solid fa-pen-to-square me-2"></i>{{ $calificacionesvariable }}</h2>
                    <span class="text-muted small">{{ count($unidades) }} unidades · {{ count($materias) }} materias</span>
                </div>

                @if (count($materias) > 0)
                    <div class="table-responsive">
                        <table class="table align-middle mb-0 diag-table">
                            <thead>
                                <tr>
                                    <th class="diag-materia">{{ $unidadesvariable }}</th>
                                    @foreach ($unidades as $uni)
                                        <th class="text-center">Unidad {{ $uni->lsc_NumUnidad }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($materias as $calif)
                                    <tr>
                                        <td class="diag-materia">
                                            <strong>{{ $calif[0]->ret_NomCompleto }}</strong>
                                            <small><i class="fa-solid fa-user-tie me-1"></i>{{ trim($calif[0]->profesor) ?: 'Sin profesor' }}</small>
                                        </td>
                                        @foreach ($unidades as $uni)
                                            @php
                                                $registro = collect($calif)->firstWhere('lsc_NumUnidad', $uni->lsc_NumUnidad);
                                                $calificacion = $registro?->lsc_Calificacion;
                                                $corte = $registro?->lsc_Corte;
                                            @endphp
                                            @if ($registro === null || ! $corte)
                                                <td class="text-center">
                                                    <span class="diag-nota diag-nota--vacia" data-mdb-toggle="tooltip" title="El profesor no ha capturado la calificación">—</span>
                                                </td>
                                            @elseif ($calificacion < 70)
                                                @php
                                                    $motivo = $motivos[$registro->motivo] ?? 'Sin motivo específico';
                                                    $detalle = $registro->comentario !== ''
                                                        ? "Motivo: {$motivo}. Comentario: {$registro->comentario}"
                                                        : 'El profesor no agregó comentarios';
                                                @endphp
                                                <td class="text-center">
                                                    <span class="diag-nota diag-nota--rojo" data-mdb-toggle="tooltip" title="{{ $detalle }}">{{ $calificacion }}</span>
                                                </td>
                                            @elseif ($calificacion < 80)
                                                <td class="text-center"><span class="diag-nota diag-nota--naranja">{{ $calificacion }}</span></td>
                                            @elseif ($calificacion < 86)
                                                <td class="text-center"><span class="diag-nota diag-nota--amarillo">{{ $calificacion }}</span></td>
                                            @else
                                                <td class="text-center"><span class="diag-nota diag-nota--verde">{{ $calificacion }}</span></td>
                                            @endif
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="diag-empty">
                        <i class="fa-regular fa-folder-open"></i>
                        Sin calificaciones parciales registradas.
                    </div>
                @endif
            </article>
        </div>

        {{-- Observaciones --}}
        <div class="col-12">
            <article class="diag-card">
                <div class="diag-card-head">
                    <h2><i class="fa-solid fa-comment-dots me-2"></i>Observaciones</h2>
                    @if (! $puedeEditarObs)
                        <span class="badge rounded-pill bg-light text-dark"><i class="fa-solid fa-lock me-1"></i>Solo lectura</span>
                    @endif
                </div>
                <div class="diag-card-body">
                    <label class="form-label" for="observaciones">Notas de seguimiento</label>
                    <textarea name="observaciones" id="observaciones" rows="4" class="form-control diag-obs" @readonly(! $puedeEditarObs) placeholder="Escribí una observación para el seguimiento del alumno">{{ $alumnos->observaciones }}</textarea>
                    @if ($puedeEditarObs)
                        <div class="d-flex justify-content-end mt-3">
                            <button type="button" class="btn btn-primary" onclick="guardarObservaciones()">
                                <i class="fa-solid fa-floppy-disk me-2"></i>Guardar observaciones
                            </button>
                        </div>
                    @endif
                </div>
            </article>
        </div>

        {{-- Cardex --}}
        <div class="col-12">
            <article class="diag-card">
                <div class="diag-card-head">
                    <h2><i class="fa-solid fa-table-list me-2"></i>Cardex</h2>
                    <span class="text-muted small">{{ count($cardex) }} materias</span>
                </div>

                @if (count($cardex) > 0)
                    <div class="table-responsive">
                        <table class="table align-middle mb-0 diag-table">
                            <thead>
                                <tr>
                                    <th style="width:52px">#</th>
                                    <th>Materia</th>
                                    <th>Periodo</th>
                                    <th class="text-center">Calificación</th>
                                    <th>Acreditación</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $semestreTem = null; $contador = 0; @endphp
                                @foreach ($cardex as $res)
                                    @if ($semestreTem !== $res->cdx_SemXPrime)
                                        <tr class="diag-semestre">
                                            <td colspan="5">
                                                <div><i class="fa-solid fa-layer-group me-2"></i>Semestre {{ $res->cdx_SemXPrime }}</div>
                                            </td>
                                        </tr>
                                        @php $semestreTem = $res->cdx_SemXPrime; $contador = 0; @endphp
                                    @endif
                                    @php $contador++; @endphp
                                    @php
                                        $claseNota = $res->cdx_Calif < 70
                                            ? 'diag-nota--rojo'
                                            : ($res->cdx_Calif < 80 ? 'diag-nota--naranja' : ($res->cdx_Calif < 86 ? 'diag-nota--amarillo' : 'diag-nota--verde'));
                                        [$acredTexto, $acredClase] = $acreditaciones[$res->cdx_UltOpcAcred] ?? ['Sin registrar', 'bg-secondary'];
                                    @endphp
                                    <tr>
                                        <td class="text-muted">{{ $contador }}</td>
                                        <td class="diag-materia"><strong>{{ $res->ret_NomCompleto }}</strong></td>
                                        <td class="text-muted">{{ $res->cdx_AnioXPrime ?? '—' }}</td>
                                        <td class="text-center">
                                            @if ($res->cdx_Calif === null)
                                                <span class="diag-nota diag-nota--vacia">—</span>
                                            @else
                                                <span class="diag-nota {{ $claseNota }}" data-mdb-toggle="tooltip" title="{{ $res->cdx_Calif < 70 ? 'No acreditada' : 'Acreditada' }}">{{ $res->cdx_Calif }}</span>
                                            @endif
                                        </td>
                                        <td><span class="badge rounded-pill {{ $acredClase }}">{{ $acredTexto }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="diag-empty">
                        <i class="fa-regular fa-folder-open"></i>
                        Sin materias registradas en el cardex.
                    </div>
                @endif
            </article>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            if (typeof mdb !== 'undefined' && mdb.Tooltip) {
                document.querySelectorAll('[data-mdb-toggle="tooltip"]').forEach(function (elemento) {
                    new mdb.Tooltip(elemento);
                });
            }
        });

        function guardarObservaciones() {
            var observaciones = $('#observaciones').val();
            var no_Control = $('#no_Control').val();

            swal({
                title: 'Guardando...',
                text: 'Por favor espere',
                icon: 'info',
                buttons: false,
                closeOnClickOutside: false,
                closeOnEsc: false
            });

            $.ajax({
                url: "{{ route('tutores.storeAlumnoObs') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    observaciones: observaciones,
                    no_Control: no_Control
                },
                success: function (response) {
                    swal.close();
                    if (response.status === 200) {
                        swal('Éxito', response.mensaje, 'success');
                    } else {
                        swal('Error', response.mensaje, 'error');
                    }
                },
                error: function (xhr) {
                    swal.close();
                    var mensajeError = 'Error en la conexión con el servidor';
                    if (xhr.status === 404) {
                        mensajeError = 'Recurso no encontrado';
                    } else if (xhr.status === 500) {
                        mensajeError = 'Error interno del servidor';
                    }
                    if (xhr.responseJSON && xhr.responseJSON.mensaje) {
                        mensajeError = xhr.responseJSON.mensaje;
                    }
                    swal('Error', mensajeError, 'error');
                    console.error('Error detallado:', xhr.responseJSON);
                }
            });
        }
    </script>
@endsection
