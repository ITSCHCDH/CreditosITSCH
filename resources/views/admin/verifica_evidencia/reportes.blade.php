@extends('template.molde')

@section('title','Reportes')

@section('ruta')
    <span class="d-inline-flex align-items-center gap-2"><i class="fa-solid fa-chart-pie" style="color:#2d6da3"></i> Reportes de avance</span>
@endsection

@section('links')
<style>
    .report-card{border:1px solid #e7edf4;border-radius:1rem;background:#fff;box-shadow:0 .75rem 1.5rem rgba(29,78,116,.10),0 .18rem .45rem rgba(16,43,74,.06);padding:1.25rem;margin-bottom:1rem;text-align:left}
    .report-card-head{display:flex;align-items:flex-start;gap:.85rem;margin-bottom:1rem}
    .report-card-head h2{margin:0;color:#102b4a;font-size:1.1rem;font-weight:700}
    .report-card-head p{margin:.2rem 0 0;color:#6b7280;font-size:.85rem}
    .report-icon{width:44px;height:44px;flex:0 0 auto;display:grid;place-items:center;border-radius:.8rem;color:#173c66;background:#edf3f8;font-size:1.05rem}
    .report-filters .form-label{font-size:.82rem;font-weight:600;color:#334155;margin-bottom:.3rem}
    .report-filters .form-select,.report-filters .form-control{min-height:46px;border-radius:.7rem}
    .report-filters .cbx-combo{flex-wrap:nowrap;min-height:46px;padding:.2rem .3rem .2rem .65rem}
    .report-filters .cbx-input{font-size:.9rem}
    .report-filters .cbx-chip,.report-filters .cbx-chip-text{flex-wrap:nowrap}
    .report-filters .cbx-chip-avatar{display:none}
    .report-filters .cbx-hint{display:none}
    .report-actions-buttons{display:flex;gap:.5rem}
    .report-kpis{display:grid;grid-template-columns:repeat(auto-fit,minmax(9.5rem,1fr));gap:.75rem}
    .report-kpi{display:flex;flex-direction:column;gap:.15rem;padding:.9rem 1rem;border:1px solid #e7edf4;border-radius:.85rem;background:#f8fafc}
    .report-kpi-value{font-size:1.45rem;font-weight:700;color:#102b4a;line-height:1.1}
    .report-kpi-label{font-size:.78rem;color:#64748b;text-transform:uppercase;letter-spacing:.03em}
    .report-kpi.is-ok{background:#f1f8f4;border-color:#d6ecdd}
    .report-kpi.is-warn{background:#fdf8ed;border-color:#f2e2bf}
    .report-kpi.is-off{background:#f8f2f2;border-color:#eed9d9}
    .report-student{border:1px solid #e7edf4;border-radius:1rem;background:#fff;box-shadow:0 .5rem 1.1rem rgba(29,78,116,.07);padding:1.1rem 1.25rem;margin-bottom:.9rem;text-align:left}
    .report-student-head{display:flex;align-items:center;gap:.85rem;flex-wrap:wrap}
    .report-avatar{width:46px;height:46px;flex:0 0 auto;display:grid;place-items:center;border-radius:.8rem;color:#173c66;background:#e8eff6;font-size:1.15rem}
    .report-student-id{min-width:0;flex:1 1 12rem}
    .report-student-id h3{margin:0;font-size:1rem;font-weight:700;color:#102b4a;overflow:hidden;text-overflow:ellipsis}
    .report-student-meta{display:flex;flex-wrap:wrap;align-items:center;gap:.45rem;margin-top:.25rem;font-size:.82rem;color:#64748b}
    .report-badge{display:inline-flex;align-items:center;gap:.35rem;padding:.3rem .7rem;border-radius:999px;font-size:.78rem;font-weight:700}
    .report-badge.is-ok{background:#e6f4ea;color:#1b7a3d}
    .report-badge.is-pending{background:#fdf3e0;color:#9a6408}
    .report-badge.is-off{background:#fdeceb;color:#b3261e}
    .report-badge.is-neutral{background:#eef3f8;color:#173c66}
    .report-progress-row{display:flex;align-items:center;gap:1rem;margin-top:1rem;flex-wrap:wrap}
    .report-progress{flex:1 1 12rem;min-width:8rem}
    .report-progress .progress{height:.7rem;border-radius:999px;background:#e9eef4}
    .report-progress .progress-bar{border-radius:999px;background:linear-gradient(90deg,#173c66,#2d6da3)}
    .report-progress-value{display:flex;align-items:baseline;gap:.5rem;white-space:nowrap}
    .report-progress-value strong{font-size:1.05rem;color:#102b4a}
    .report-progress-value span{font-size:.78rem;color:#64748b}
    .report-actions{display:flex;flex-wrap:wrap;gap:.5rem;margin-top:1rem;padding-top:.9rem;border-top:1px solid #edf1f5}
    .report-actions form{margin:0}
    .report-empty{display:flex;flex-direction:column;align-items:center;text-align:center;gap:.5rem;padding:2.5rem 1.5rem}
    .report-empty i{font-size:2rem;color:#94a3b8}
    .report-empty h2{margin:0;font-size:1.05rem;color:#102b4a}
    .report-empty p{margin:0;color:#64748b;font-size:.88rem;max-width:32rem}
    .report-detail-item{display:flex;flex-direction:column;gap:.35rem;padding:.75rem 0;border-bottom:1px solid #edf1f5}
    .report-detail-item:last-child{border-bottom:0}
    .report-detail-head{display:flex;align-items:center;justify-content:space-between;gap:1rem;font-size:.9rem;font-weight:600;color:#102b4a}
    .report-pagination{padding:.9rem 1.25rem}
    .report-pager{display:flex;align-items:center;gap:.5rem;flex-wrap:wrap}
    .report-pager-btn{display:inline-flex;align-items:center;gap:.4rem;padding:.4rem .9rem;border:1px solid #d7dee8;border-radius:999px;background:#fff;color:#173c66;font-size:.85rem;font-weight:600;text-decoration:none;transition:background-color .15s ease,border-color .15s ease}
    .report-pager-btn:hover,.report-pager-btn:focus-visible{background:#eef3f8;border-color:#b9c8d8;color:#102b4a}
    .report-pager-btn.is-disabled{color:#94a3b8;background:#f8fafc;border-color:#e7edf4;pointer-events:none}
    .report-pager-info{font-size:.82rem;color:#64748b}
    @media(max-width:575.98px){.report-actions .btn{flex:1 1 auto}}
</style>
@endsection

@section('contenido')
@php
    $paginado = $suma_creditos instanceof \Illuminate\Pagination\LengthAwarePaginator ? $suma_creditos : null;
    $sinDatos = $paginado === null || $paginado->total() === 0;
    $filtrado = (bool) ($filtrosAplicados ?? false);
    $puntosTotales = max(1, (int) $creditos * 100);
    $detallePorAlumno = $reportes_data ? collect($reportes_data)->groupBy('no_control') : collect();
    $r = $resumen ?? ['total' => 0, 'liberados' => 0, 'enProceso' => 0, 'sinAvance' => 0, 'bajas' => 0, 'promedio' => 0];

    $estados = [
        'liberado' => ['texto' => 'Liberado', 'clase' => 'is-ok', 'icono' => 'fa-circle-check'],
        'pendiente' => ['texto' => 'Pendiente', 'clase' => 'is-pending', 'icono' => 'fa-clock'],
        'baja' => ['texto' => 'Baja', 'clase' => 'is-off', 'icono' => 'fa-circle-xmark'],
    ];
@endphp

<article class="report-card">
    <div class="report-card-head">
        <span class="report-icon"><i class="fa-solid fa-filter" aria-hidden="true"></i></span>
        <div>
            <h2>Filtros</h2>
            <p>Son opcionales y se acotan entre sí: la carrera depende de la generación, y el alumno se busca dentro de lo ya elegido.</p>
        </div>
    </div>
    <form action="{{ route('verifica_evidencia.reportes') }}" method="get" class="report-filters">
        <div class="row g-3 align-items-end">
            <div class="col-sm-6 col-xl-2">
                <label class="form-label" for="generacion">Generación</label>
                <select name="generacion" id="generacion" class="form-select">
                    <option value="1" @if((int) $generacion === 1 || (int) $generacion === 0) selected @endif>Todos</option>
                    @foreach($anios as $anioDisponible)
                        <option value="{{ $anioDisponible }}" @if((int) $generacion === (int) $anioDisponible) selected @endif>{{ $anioDisponible }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-6 col-xl-2">
                <label class="form-label" for="carrera">Carrera</label>
                <select class="form-select" name="carrera" id="carrera">
                    <option value="">Todas las carreras</option>
                    @foreach($carreras as $carrera)
                        <option value="{{ $carrera->id }}" title="{{ $carrera->nombre }}" @selected($carrera_seleccionada == $carrera->id)>{{ $carrera->nombre_corto ?: $carrera->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-6 col-xl-2">
                <label class="form-label" for="status">Status</label>
                <select class="form-select" name="status" id="status">
                    <option value="todos" @if($status=='todos') selected @endif>Cualquier status</option>
                    <option value="liberado" @if($status=='liberado') selected @endif>Liberados</option>
                    <option value="pendiente" @if($status=='pendiente') selected @endif>Pendientes</option>
                    <option value="baja" @if($status=='baja') selected @endif>Baja</option>
                </select>
            </div>
            <div class="col-sm-6 col-xl-4">
                @include('template.partes.buscador_combobox', [
                    'config' => [
                        'id' => 'alumnoFiltro',
                        'bare' => true,
                        'required' => false,
                        'show_submit' => false,
                        'label' => 'Alumno',
                        'placeholder' => 'Nombre o No. control',
                        'field' => 'busqueda',
                        'endpoint' => route('verifica_evidencia.alumnos_busqueda'),
                        'query_param' => 'nombre',
                        'params' => ['peticion' => '0', 'carrera' => (string) ($carrera_seleccionada ?? ''), 'anio' => (int) $generacion > 1 ? (string) (int) $generacion : ''],
                        'keys' => ['value' => 'no_control', 'label' => 'nombre', 'meta' => ''],
                        'initial' => $alumnoFiltro ?? null,
                    ],
                ])
            </div>
            <div class="col-12 col-xl-2">
                <div class="report-actions-buttons">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 flex-grow-1"><i class="fa-solid fa-filter me-2" aria-hidden="true"></i>Filtrar</button>
                    <a href="{{ route('verifica_evidencia.reportes') }}" class="btn btn-outline-secondary rounded-pill" title="Quitar filtros" aria-label="Quitar filtros"><i class="fa-solid fa-eraser" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
    </form>
</article>

<script>
    (function () {
        const carrera = document.getElementById('carrera');
        const generacion = document.getElementById('generacion');
        const combo = document.getElementById('alumnoFiltro_combo');
        if (!carrera || !generacion || !combo || typeof combo.cbxSetParams !== 'function') { return; }

        const sync = function () {
            const anio = generacion.value && generacion.value !== '1' ? generacion.value : '';
            combo.cbxSetParams({ carrera: carrera.value || '', anio: anio });
        };

        carrera.addEventListener('change', sync);
        generacion.addEventListener('change', sync);
        sync();
    })();
</script>

@if($sinDatos)
    <article class="report-card">
        <div class="report-empty">
            <i class="fa-solid {{ $filtrado ? 'fa-circle-question' : 'fa-chart-simple' }}" aria-hidden="true"></i>
            @if($filtrado)
                <h2>Sin resultados</h2>
                <p>Ningún alumno coincide con la combinación elegida. Recuerda que la carrera se acota por la generación y la búsqueda de alumno por ambos filtros; ajusta la selección e inténtalo de nuevo.</p>
            @else
                <h2>Elige al menos un filtro</h2>
                <p>Puedes filtrar por generación, por carrera o buscar directamente un alumno; no es necesario llenar todos. El avance se calcula por crédito: {{ $creditos }} créditos registrados, {{ $puntosTotales }} puntos posibles por alumno.</p>
            @endif
        </div>
    </article>
@else
    <article class="report-card">
        <div class="report-card-head">
            <span class="report-icon"><i class="fa-solid fa-chart-simple" aria-hidden="true"></i></span>
            <div>
                <h2>Resumen</h2>
                <p>{{ $r['total'] }} {{ $r['total'] === 1 ? 'alumno' : 'alumnos' }} · avance promedio {{ $r['promedio'] }}% · fuente: sit.alumnos</p>
            </div>
        </div>
        <div class="report-kpis">
            <div class="report-kpi"><span class="report-kpi-value">{{ $r['total'] }}</span><span class="report-kpi-label">Alumnos</span></div>
            <div class="report-kpi is-ok"><span class="report-kpi-value">{{ $r['liberados'] }}</span><span class="report-kpi-label">Liberados</span></div>
            <div class="report-kpi is-warn"><span class="report-kpi-value">{{ $r['enProceso'] }}</span><span class="report-kpi-label">En proceso</span></div>
            <div class="report-kpi"><span class="report-kpi-value">{{ $r['sinAvance'] }}</span><span class="report-kpi-label">Sin avance</span></div>
            <div class="report-kpi is-off"><span class="report-kpi-value">{{ $r['bajas'] }}</span><span class="report-kpi-label">Baja</span></div>
            <div class="report-kpi"><span class="report-kpi-value">{{ $r['promedio'] }}%</span><span class="report-kpi-label">Promedio</span></div>
        </div>
    </article>

    <div class="report-list">
        @foreach($paginado as $alumno)
            @php
                $puntos = (int) $alumno->credito_suma;
                $porcentaje = min(100, (int) round($puntos * 100 / $puntosTotales));
                $estado = $estados[strtolower((string) $alumno->status)] ?? ['texto' => ucfirst((string) $alumno->status), 'clase' => 'is-neutral', 'icono' => 'fa-circle-info'];
                $detalle = $detallePorAlumno->get($alumno->no_control, collect());
                $modalId = 'myModalDetalle'.$alumno->alumno_id;
            @endphp
            <article class="report-student">
                <div class="report-student-head">
                    <span class="report-avatar"><i class="fa-solid fa-user-graduate" aria-hidden="true"></i></span>
                    <div class="report-student-id">
                        <h3>{{ $alumno->nombre }}</h3>
                        <div class="report-student-meta">
                            <span class="report-badge is-neutral">{{ $alumno->no_control }}</span>
                            @if(!empty($alumno->carrera))<span>{{ $alumno->carrera }}</span>@endif
                        </div>
                    </div>
                    <span class="report-badge {{ $estado['clase'] }}"><i class="fa-solid {{ $estado['icono'] }}" aria-hidden="true"></i>{{ $estado['texto'] }}</span>
                </div>

                <div class="report-progress-row">
                    <div class="report-progress">
                        <div class="progress" role="progressbar" aria-label="Avance de {{ $alumno->nombre }}" aria-valuenow="{{ $porcentaje }}" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width:{{ $porcentaje }}%"></div>
                        </div>
                    </div>
                    <div class="report-progress-value"><strong>{{ $porcentaje }}%</strong><span>{{ $puntos }} / {{ $puntosTotales }} pts</span></div>
                </div>

                <div class="report-actions">
                    <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3" data-mdb-toggle="modal" data-mdb-target="#{{ $modalId }}"><i class="fa-solid fa-eye me-2" aria-hidden="true"></i>Ver detalle</button>

                    @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VER_AVANCE_ALUMNO']))
                        <form action="{{ route('verifica_evidencia.avance_alumno') }}" method="get">
                            <input type="hidden" name="ruta_carrera" value="{{ request()->query('carrera', 'desconocida') }}">
                            <input type="hidden" name="ruta_generacion" value="{{ request()->query('generacion', 'desconocida') }}">
                            <input type="hidden" name="no_control" value="{{ $alumno->no_control }}">
                            <button type="submit" class="btn btn-primary btn-sm rounded-pill px-3"><i class="fa-solid fa-chart-line me-2" aria-hidden="true"></i>Avance</button>
                        </form>
                    @endif

                    @if($puntos >= $puntosTotales && Auth::User()->hasAnyPermission(['VIP','IMPRIMIR_CONSTANCIAS']))
                        <form action="{{ route('constancias.imprimir') }}" method="post">
                            @csrf
                            <input type="hidden" name="no_control" value="{{ $alumno->no_control }}">
                            <button type="submit" class="btn btn-warning btn-sm rounded-pill px-3"><i class="fa-solid fa-print me-2" aria-hidden="true"></i>Constancia</button>
                        </form>
                    @endif
                </div>
            </article>

            <div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div>
                                <h5 class="modal-title" id="{{ $modalId }}Label">Detalle del alumno</h5>
                                <div class="text-muted small">{{ $alumno->nombre }} · {{ $alumno->no_control }}</div>
                            </div>
                            <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            @if($detalle->isEmpty())
                                <p class="text-muted mb-0">Este alumno no tiene créditos registrados en el reporte.</p>
                            @else
                                @foreach($detalle as $registro)
                                    @php $porCredito = min(100, max(0, (int) $registro->por_credito)); @endphp
                                    <div class="report-detail-item">
                                        <div class="report-detail-head"><span>{{ $registro->nombre_credito }}</span><span>{{ $porCredito }}%</span></div>
                                        <div class="progress" role="progressbar" aria-label="{{ $registro->nombre_credito }}" aria-valuenow="{{ $porCredito }}" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar" style="width:{{ $porCredito }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary rounded-pill" data-mdb-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($paginado->hasPages())
        <div class="report-card report-pagination">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                <span class="text-muted small">Mostrando {{ $paginado->firstItem() }}–{{ $paginado->lastItem() }} de {{ $paginado->total() }} alumnos</span>
                <div class="report-pager">
                    @if($paginado->onFirstPage())
                        <span class="report-pager-btn is-disabled"><i class="fa-solid fa-chevron-left" aria-hidden="true"></i> Anterior</span>
                    @else
                        <a class="report-pager-btn" href="{{ $paginado->previousPageUrl() }}"><i class="fa-solid fa-chevron-left" aria-hidden="true"></i> Anterior</a>
                    @endif
                    <span class="report-pager-info">Página {{ $paginado->currentPage() }} de {{ $paginado->lastPage() }}</span>
                    @if($paginado->hasMorePages())
                        <a class="report-pager-btn" href="{{ $paginado->nextPageUrl() }}">Siguiente <i class="fa-solid fa-chevron-right" aria-hidden="true"></i></a>
                    @else
                        <span class="report-pager-btn is-disabled">Siguiente <i class="fa-solid fa-chevron-right" aria-hidden="true"></i></span>
                    @endif
                </div>
            </div>
        </div>
    @endif
@endif
@endsection
