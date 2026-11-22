@extends('template.molde')

@section('title','Análisis de alumnos')

@section('ruta')
    <span class="d-inline-flex align-items-center gap-2">
        <i class="fa-solid fa-user-graduate" style="color:#2d6da3"></i>
        Análisis de alumnos
    </span>
@endsection

@push('styles')
<style>
    .sta-card{border:1px solid #e7edf4;border-radius:1rem;background:#fff;box-shadow:0 .75rem 1.5rem rgba(29,78,116,.10),0 .18rem .45rem rgba(16,43,74,.06)}
    .sta-filter{padding:1.25rem}
    .sta-filter-head{display:flex;align-items:center;gap:.85rem}
    .sta-filter-icon{width:44px;height:44px;display:grid;place-items:center;border-radius:.8rem;color:#173c66;background:#edf3f8;font-size:1.05rem}
    .sta-filter-head h1{margin:0;color:#102b4a;font-size:1.2rem;font-weight:700}
    .sta-filter-head p{margin:.15rem 0 0;color:#6b7280;font-size:.88rem}
    .sta-filter .row>*{min-width:0}
    .sta-filter .form-select{min-width:0;max-width:100%}
    .sta-kpi{display:flex;align-items:center;gap:.85rem;height:100%;padding:1rem 1.15rem}
    .sta-kpi-icon{width:44px;height:44px;flex:0 0 44px;display:grid;place-items:center;border-radius:.8rem;font-size:1.05rem}
    .sta-kpi-label{display:block;color:#6b7280;font-size:.78rem;text-transform:uppercase;letter-spacing:.03em}
    .sta-kpi-value{display:block;color:#102b4a;font-size:1.45rem;font-weight:700;line-height:1.1}
    .sta-kpi--total .sta-kpi-icon{color:#173c66;background:#edf3f8}
    .sta-kpi--vigentes .sta-kpi-icon{color:#1b7a43;background:#e7f5ec}
    .sta-kpi--bajas .sta-kpi-icon{color:#b3261e;background:#fdeceb}
    .sta-kpi--riesgo .sta-kpi-icon{color:#b45309;background:#fdf1e3}
    .sta-table-card{overflow:hidden}
    .sta-table-head{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:.85rem;padding:1rem 1.25rem;border-bottom:1px solid #edf1f5;background:#f8fafc}
    .sta-table-head h2{margin:0;color:#102b4a;font-size:1.05rem}
    .sta-semaforos{display:flex;align-items:center;justify-content:center;gap:.4rem}
    .sta-semaforos>*{display:inline-block;margin:0!important}
    .sta-legend{display:flex;flex-wrap:wrap;align-items:center;gap:.9rem;padding:.65rem 1.25rem;border-top:1px solid #edf1f5;color:#6b7280;font-size:.76rem}
    .sta-legend span{display:inline-flex;align-items:center;gap:.35rem}
    .sta-legend .CirculoNegro,.sta-legend .CirculoRojo,.sta-legend .CirculoNaranja,.sta-legend .CirculoAmarillo,.sta-legend .CirculoVerde,.sta-legend .CirculoAzul{display:inline-block;width:12px;height:12px;margin:0}
    .sta-table-card .dataTables_wrapper{position:relative;padding:0 1.25rem 1rem}
    .sta-table-card .dataTables_wrapper::after{content:"";display:block;clear:both}
    .sta-table-card .dt-buttons{float:left;margin:.85rem 0 .5rem;display:flex;flex-wrap:wrap;gap:.4rem}
    .sta-table-card .dt-buttons .dt-button{display:inline-flex;align-items:center;gap:.35rem;padding:.4rem .8rem;border:1px solid #cfdceb;border-radius:.55rem;background:#fff;color:#173c66;font-size:.8rem;font-weight:500;line-height:1.2;box-shadow:none;text-transform:none}
    .sta-table-card .dt-buttons .dt-button:hover,.sta-table-card .dt-buttons .dt-button:focus{background:#edf3f8;border-color:#b9cde1;color:#102b4a;box-shadow:none}
    .sta-table-card .dt-buttons .dt-button.active{background:#e3eef8;border-color:#a9c4dc;color:#173c66}
    .sta-table-card .dt-button-collection{border:1px solid #e2e9f1;border-radius:.7rem;box-shadow:0 .75rem 1.5rem rgba(16,43,74,.14);padding:.35rem}
    .sta-table-card .dt-button-collection .dt-button{border:0;border-radius:.45rem;width:100%;justify-content:flex-start;text-transform:none}
    .sta-table-card .dataTables_filter{float:right;margin:.85rem 0 .5rem;text-align:right}
    .sta-table-card .dataTables_filter label{display:inline-flex;align-items:center;gap:.4rem;color:#6b7280;font-size:.85rem;font-weight:400;margin:0}
    .sta-table-card .dataTables_filter input{border:1px solid #d6e0ea;border-radius:.55rem;padding:.4rem .7rem;margin:0;background:#fff;box-shadow:none;font-size:.85rem}
    .sta-table-card .dataTables_filter input:focus{border-color:#2d6da3;box-shadow:0 0 0 .15rem rgba(45,109,163,.18);outline:0}
    .sta-table-card table.dataTable{clear:both;margin:.5rem 0 0!important;width:100%!important}
    .sta-table-card .dataTables_scrollBody{overflow-x:auto}
    .sta-table-card .dataTables_scrollHead{overflow:hidden}
    .sta-table-card .dataTables_info{float:left;color:#6b7280;font-size:.85rem;padding-top:1rem}
    .sta-table-card .dataTables_paginate{float:right;padding-top:.9rem}
    .sta-table-card .pagination{margin-bottom:0;gap:.2rem}
    .sta-table-card .page-link{border-radius:.55rem!important;color:#173c66;border-color:#e2e9f1;padding:.35rem .7rem;font-size:.82rem}
    .sta-table-card .page-item.active .page-link{background:#2d6da3;border-color:#2d6da3;color:#fff}
    .sta-table-card .page-link:hover{background:#edf3f8}
    .sta-table-card .page-item.disabled .page-link{color:#b6c2cf;background:#f8fafc}
    .sta-empty-state{padding:3rem 1.25rem;text-align:center;color:#64748b}
    .sta-empty-state i{display:block;margin-bottom:.6rem;font-size:2rem;color:#c3d0de}
    .sta-table-card table.dataTable thead th{background:#f8fafc;color:#102b4a;font-size:.82rem;text-transform:uppercase;letter-spacing:.02em;border-bottom:1px solid #edf1f5}
    .sta-table-card table.dataTable tbody td{vertical-align:middle}
    @media(max-width:767.98px){
        .sta-table-head{align-items:flex-start;flex-direction:column}
        .sta-table-card .dataTables_wrapper{padding:0 .85rem .85rem}
        .sta-table-card .dt-buttons{float:none;width:100%;margin:.75rem 0 .35rem}
        .sta-table-card .dt-buttons .buttons-colvis,.sta-table-card .dt-buttons .buttons-page-length{display:none}
        .sta-table-card .dataTables_filter{float:none;width:100%;text-align:left;margin:.25rem 0 .5rem}
        .sta-table-card .dataTables_filter label{display:flex;width:100%}
        .sta-table-card .dataTables_filter input{flex:1 1 auto;width:100%}
        .sta-table-card .dataTables_info{float:none;padding-top:.65rem;text-align:center}
        .sta-table-card .dataTables_paginate{float:none;padding-top:.4rem;text-align:center}
        .sta-table-card .pagination{justify-content:center;flex-wrap:wrap}
    }
</style>
@endpush

@section('contenido')
    <article class="sta-card sta-filter mb-3">
        <div class="sta-filter-head mb-3">
            <span class="sta-filter-icon"><i class="fa-solid fa-filter"></i></span>
            <div>
                <h1>Consultar alumnos</h1>
                <p>Elegí una generación y una carrera para revisar el avance y los semáforos del grupo.</p>
            </div>
        </div>

        <form action="{{ route('analisis.generacion') }}" method="post">
            @csrf
            <div class="row g-3 align-items-end">
                <div class="col-12 col-md-5">
                    <label class="form-label" for="generacion">Generación</label>
                    <select class="form-select" name="generacion" id="generacion" required>
                        <option value="">Selecciona una generación</option>
                        @foreach ($generaciones as $gen)
                            <option value="{{ $gen->Alu_AnioIngreso }}" @selected((string) $generacion === (string) $gen->Alu_AnioIngreso)>{{ $gen->Alu_AnioIngreso }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-5">
                    <label class="form-label" for="carrera">Carrera</label>
                    <select class="form-select" name="carrera" id="carrera" required>
                        <option value="">Selecciona una carrera</option>
                        @foreach ($carreras as $car)
                            <option value="{{ $car->car_Clave }}" @selected((string) $carrera === (string) $car->car_Clave)>{{ $car->car_Nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-2">
                    <button type="submit" class="btn btn-primary w-100" title="Consultar">
                        <i class="fa-solid fa-magnifying-glass me-2"></i>Consultar
                    </button>
                </div>
            </div>
        </form>
    </article>

    @php
        $hayGrupo = is_object($grupo) && $grupo !== '' && count($grupo) > 0;
        $totalAlumnos = $hayGrupo ? $grupo->count() : 0;
        $vigentes = $hayGrupo ? $grupo->where('status', 'VI')->count() : 0;
        $bajas = $hayGrupo ? $grupo->whereIn('status', ['BD', 'BT'])->count() : 0;
        $enRiesgo = $hayGrupo
            ? $grupo->filter(fn ($alumno) => in_array($alumno->semaforos['semaforoAcad'] ?? '', ['CirculoRojo', 'CirculoNaranja'], true))->count()
            : 0;
        $estatusMap = [
            'VI' => ['Vigente', 'bg-success'],
            'BD' => ['Baja definitiva', 'bg-danger'],
            'BT' => ['Baja temporal', 'bg-warning text-dark'],
            'EG' => ['Egresado', 'bg-info text-dark'],
        ];
    @endphp

    @if ($hayGrupo)
        <div class="row g-3 mb-3">
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="sta-card sta-kpi sta-kpi--total">
                    <span class="sta-kpi-icon"><i class="fa-solid fa-users"></i></span>
                    <div>
                        <span class="sta-kpi-label">Alumnos</span>
                        <span class="sta-kpi-value">{{ $totalAlumnos }}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="sta-card sta-kpi sta-kpi--vigentes">
                    <span class="sta-kpi-icon"><i class="fa-solid fa-user-check"></i></span>
                    <div>
                        <span class="sta-kpi-label">Vigentes</span>
                        <span class="sta-kpi-value">{{ $vigentes }}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="sta-card sta-kpi sta-kpi--bajas">
                    <span class="sta-kpi-icon"><i class="fa-solid fa-user-slash"></i></span>
                    <div>
                        <span class="sta-kpi-label">Bajas</span>
                        <span class="sta-kpi-value">{{ $bajas }}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="sta-card sta-kpi sta-kpi--riesgo">
                    <span class="sta-kpi-icon"><i class="fa-solid fa-triangle-exclamation"></i></span>
                    <div>
                        <span class="sta-kpi-label">Riesgo académico</span>
                        <span class="sta-kpi-value">{{ $enRiesgo }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <article class="sta-card sta-table-card">
        <div class="sta-table-head">
            <div class="d-flex align-items-center gap-2">
                <h2>Alumnos del grupo</h2>
                @if ($hayGrupo)
                    <span class="badge rounded-pill bg-light text-dark">{{ $totalAlumnos }}</span>
                @endif
            </div>
            <span class="text-muted small">
                <i class="fa-solid fa-arrow-down-a-z me-1"></i>Ordenado por apellido paterno, materno y nombre
            </span>
        </div>

        @if ($hayGrupo)
            <div class="sta-table-scroll">
                <table class="table align-middle mb-0" id="staTabla">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Control</th>
                            <th>Nombre</th>
                            <th class="text-center">Semestre</th>
                            <th>Estatus</th>
                            <th class="text-center">Semáforos</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($grupo as $gru)
                            @php
                                [$estatusTexto, $estatusClase] = $estatusMap[$gru->status] ?? ['Sin estatus', 'bg-secondary'];
                                $ordenNombre = \Illuminate\Support\Str::upper(\Illuminate\Support\Str::ascii($gru->aPaterno.' '.$gru->aMaterno.' '.$gru->nombre));
                            @endphp
                            <tr>
                                <td class="text-muted">{{ $loop->iteration }}</td>
                                <td><span class="font-monospace">{{ $gru->control }}</span></td>
                                <td data-order="{{ $ordenNombre }}">
                                    <strong class="d-block">{{ $gru->aPaterno }} {{ $gru->aMaterno }}</strong>
                                    <small class="text-muted">{{ $gru->nombre }}</small>
                                </td>
                                <td class="text-center">{{ $gru->semestre }}</td>
                                <td><span class="badge rounded-pill {{ $estatusClase }}">{{ $estatusTexto }}</span></td>
                                <td>
                                    <div class="sta-semaforos">
                                        <a href="{{ route('analisis.alumno', $gru->control) }}"
                                           class="{{ $gru->semaforos['semaforoAcad'] }}"
                                           data-mdb-toggle="tooltip"
                                           title="Académico: {{ $gru->semaforos['titleAcad'] }}"
                                           aria-label="Ver diagnóstico académico"></a>
                                        <span class="{{ $gru->semaforos['semaforoMedico'] }}" data-mdb-toggle="tooltip" title="Médico"></span>
                                        <span class="{{ $gru->semaforos['semaforoPsico'] }}" data-mdb-toggle="tooltip" title="Psicológico"></span>
                                        <span class="{{ $gru->semaforos['semaforoServicio'] }}" data-mdb-toggle="tooltip" title="Servicio social: {{ $gru->semaforos['titleSS'] }}"></span>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('analisis.alumno', $gru->control) }}" class="btn btn-sm btn-primary" data-mdb-toggle="tooltip" title="Ver diagnóstico">
                                        <i class="fa-solid fa-magnifying-glass-chart"></i>
                                    </a>
                                    <a href="{{ route('analisis.ficha', [$gru->control, 1]) }}"
                                       class="btn btn-sm {{ $gru->ficha == 1 ? 'btn-outline-success' : 'btn-outline-secondary' }}"
                                       data-mdb-toggle="tooltip"
                                       title="{{ $gru->ficha == 1 ? 'Ver ficha completada' : 'Ver avance de llenado de ficha' }}">
                                        <i class="fa-solid {{ $gru->ficha == 1 ? 'fa-file-circle-check' : 'fa-file-pen' }}"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="sta-legend">
                <span><span class="CirculoVerde"></span>Sin riesgo</span>
                <span><span class="CirculoAmarillo"></span>Leve</span>
                <span><span class="CirculoNaranja"></span>Moderado</span>
                <span><span class="CirculoRojo"></span>Grave</span>
                <span><span class="CirculoNegro"></span>Sin datos</span>
                <span><span class="CirculoAzul"></span>No aplica</span>
            </div>
        @else
            <div class="sta-empty-state">
                <i class="fa-regular fa-rectangle-list"></i>
                Elegí una generación y una carrera para ver a los alumnos.
            </div>
        @endif
    </article>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            if (!$('#staTabla').length) {
                return;
            }

            $('#staTabla').DataTable({
                dom: 'Bfrtip',
                pageLength: 10,
                lengthMenu: [[10, 25, 50, -1], ['10 registros', '25 registros', '50 registros', 'Ver todos']],
                pagingType: 'full_numbers',
                // Sin orden inicial: se respeta el orden del servidor
                // (apellido paterno, apellido materno y nombre)
                order: [],
                columnDefs: [
                    { orderable: false, targets: [5, 6] }
                ],
                rowCallback: function (fila, datos, indice) {
                    // La columna "#" se renumera según el orden y el filtro actuales
                    fila.cells[0].textContent = indice + 1;
                },
                responsive: false,
                scrollX: true,
                scrollCollapse: true,
                deferRender: true,
                // Sin stateSave: evita que un orden anterior (por control)
                // se restaure por encima del orden de apellidos
                stateSave: false,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                },
                buttons: [
                    {
                        extend: 'collection',
                        text: '<i class="fa-solid fa-download me-2"></i>Exportar',
                        className: 'btn btn-sm btn-outline-primary',
                        buttons: [
                            { extend: 'copyHtml5', text: '<i class="fa-regular fa-copy me-2"></i>Copiar', className: 'btn-sm' },
                            { extend: 'csvHtml5', text: '<i class="fa-solid fa-file-csv me-2"></i>CSV', className: 'btn-sm' },
                            { extend: 'excelHtml5', text: '<i class="fa-solid fa-file-excel me-2"></i>Excel', className: 'btn-sm' },
                            { extend: 'pdfHtml5', text: '<i class="fa-solid fa-file-pdf me-2"></i>PDF', className: 'btn-sm' },
                            { extend: 'print', text: '<i class="fa-solid fa-print me-2"></i>Imprimir', className: 'btn-sm' }
                        ]
                    },
                    {
                        extend: 'colvis',
                        text: '<i class="fa-solid fa-table-columns me-2"></i>Columnas',
                        className: 'btn btn-sm btn-outline-secondary'
                    },
                    {
                        extend: 'pageLength',
                        text: '<i class="fa-solid fa-list me-2"></i>Registros',
                        className: 'btn btn-sm btn-outline-secondary'
                    }
                ],
                drawCallback: function () {
                    if (typeof mdb !== 'undefined' && mdb.Tooltip) {
                        this.api().rows({ page: 'current' }).nodes().each(function (fila) {
                            fila.querySelectorAll('[data-mdb-toggle="tooltip"]').forEach(function (elemento) {
                                if (!elemento.dataset.mdbTooltipInicializado) {
                                    new mdb.Tooltip(elemento);
                                    elemento.dataset.mdbTooltipInicializado = '1';
                                }
                            });
                        });
                    }
                }
            });

            // Tooltips de MDB en la primera carga
            if (typeof mdb !== 'undefined' && mdb.Tooltip) {
                document.querySelectorAll('[data-mdb-toggle="tooltip"]').forEach(function (elemento) {
                    new mdb.Tooltip(elemento);
                    elemento.dataset.mdbTooltipInicializado = '1';
                });
            }
        });
    </script>
@endsection
