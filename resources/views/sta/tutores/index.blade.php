@extends('template.molde')

@section('title','Tutor')

@section('ruta')
    <span class="d-inline-flex align-items-center gap-2">
        <i class="fa-solid fa-user-tie" style="color:#2d6da3"></i>
        Tutor
    </span>
@endsection

@push('styles')
<style>
    .tutor-card{border:1px solid #e7edf4;border-radius:1rem;background:#fff;box-shadow:0 .75rem 1.5rem rgba(29,78,116,.10),0 .18rem .45rem rgba(16,43,74,.06)}
    .tutor-kpi{display:flex;align-items:center;gap:.85rem;height:100%;padding:1rem 1.15rem}
    .tutor-kpi-icon{width:44px;height:44px;flex:0 0 44px;display:grid;place-items:center;border-radius:.8rem;font-size:1.05rem}
    .tutor-kpi-label{display:block;color:#6b7280;font-size:.78rem;text-transform:uppercase;letter-spacing:.03em}
    .tutor-kpi-value{display:block;color:#102b4a;font-size:1.45rem;font-weight:700;line-height:1.1}
    .tutor-kpi--grupos .tutor-kpi-icon{color:#173c66;background:#edf3f8}
    .tutor-kpi--tutores .tutor-kpi-icon{color:#1b7a43;background:#e7f5ec}
    .tutor-kpi--carreras .tutor-kpi-icon{color:#b45309;background:#fdf1e3}
    .tutor-kpi--tipos .tutor-kpi-icon{color:#6d28d9;background:#f1ecfd}
    .tutor-table-head{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:.85rem;padding:1rem 1.25rem;border-bottom:1px solid #edf1f5;background:#f8fafc}
    .tutor-table-head h2{margin:0;color:#102b4a;font-size:1.05rem}
    .tutor-table-card{overflow:hidden}
    .tutor-table-card .dataTables_wrapper{position:relative;padding:0 1.25rem 1rem}
    .tutor-table-card .dataTables_wrapper::after{content:"";display:block;clear:both}
    .tutor-table-card .dt-buttons{float:left;margin:.85rem 0 .5rem;display:flex;flex-wrap:wrap;gap:.4rem}
    .tutor-table-card .dt-buttons .dt-button{display:inline-flex;align-items:center;gap:.35rem;padding:.4rem .8rem;border:1px solid #cfdceb;border-radius:.55rem;background:#fff;color:#173c66;font-size:.8rem;font-weight:500;line-height:1.2;box-shadow:none;text-transform:none}
    .tutor-table-card .dt-buttons .dt-button:hover,.tutor-table-card .dt-buttons .dt-button:focus{background:#edf3f8;border-color:#b9cde1;color:#102b4a;box-shadow:none}
    .tutor-table-card .dt-button-collection{border:1px solid #e2e9f1;border-radius:.7rem;box-shadow:0 .75rem 1.5rem rgba(16,43,74,.14);padding:.35rem}
    .tutor-table-card .dt-button-collection .dt-button{border:0;border-radius:.45rem;width:100%;justify-content:flex-start}
    .tutor-table-card .dataTables_filter{float:right;margin:.85rem 0 .5rem;text-align:right}
    .tutor-table-card .dataTables_filter label{display:inline-flex;align-items:center;gap:.4rem;color:#6b7280;font-size:.85rem;font-weight:400;margin:0}
    .tutor-table-card .dataTables_filter input{border:1px solid #d6e0ea;border-radius:.55rem;padding:.4rem .7rem;margin:0;background:#fff;box-shadow:none;font-size:.85rem}
    .tutor-table-card .dataTables_filter input:focus{border-color:#2d6da3;box-shadow:0 0 0 .15rem rgba(45,109,163,.18);outline:0}
    .tutor-table-card table.dataTable{clear:both;margin:.5rem 0 0!important;width:100%!important}
    .tutor-table-card table.dataTable thead th{background:#f8fafc;color:#102b4a;font-size:.8rem;text-transform:uppercase;letter-spacing:.02em;border-bottom:1px solid #edf1f5;white-space:nowrap}
    .tutor-table-card table.dataTable tbody td{vertical-align:middle}
    .tutor-table-card .dataTables_info{float:left;color:#6b7280;font-size:.85rem;padding-top:1rem}
    .tutor-table-card .dataTables_paginate{float:right;padding-top:.9rem}
    .tutor-table-card .pagination{margin-bottom:0;gap:.2rem}
    .tutor-table-card .page-link{border-radius:.55rem!important;color:#173c66;border-color:#e2e9f1;padding:.35rem .7rem;font-size:.82rem}
    .tutor-table-card .page-item.active .page-link{background:#2d6da3;border-color:#2d6da3;color:#fff}
    .tutor-table-card .page-link:hover{background:#edf3f8}
    .tutor-table-card .page-item.disabled .page-link{color:#b6c2cf;background:#f8fafc}
    .tutor-alumno strong{display:block;color:#102b4a;font-size:.9rem}
    .tutor-alumno small{color:#6b7280}
    .tutor-empty{padding:2.75rem 1rem;text-align:center;color:#64748b;font-size:.9rem}
    .tutor-empty i{display:block;margin-bottom:.6rem;font-size:1.8rem;color:#c3d0de}
    .tutor-tipo{display:inline-flex;align-items:center;gap:.3rem;padding:.2rem .55rem;border-radius:999px;font-size:.75rem;font-weight:600}
    .tutor-tipo--ingreso{background:#e7f5ec;color:#1b7a43}
    .tutor-tipo--permanencia{background:#edf3f8;color:#173c66}
    .tutor-tipo--egreso{background:#fdf1e3;color:#b45309}
    .tutor-tipo--jornada{background:#f1ecfd;color:#6d28d9}
    .tutor-tipo--otro{background:#f1f5f9;color:#64748b}
    @media(max-width:767.98px){
        .tutor-table-head{align-items:flex-start;flex-direction:column}
        .tutor-table-card .dataTables_wrapper{padding:0 .85rem .85rem}
        .tutor-table-card .dt-buttons{float:none;width:100%;margin:.75rem 0 .35rem}
        .tutor-table-card .dt-buttons .buttons-colvis,.tutor-table-card .dt-buttons .buttons-page-length{display:none}
        .tutor-table-card .dataTables_filter{float:none;width:100%;text-align:left;margin:.25rem 0 .5rem}
        .tutor-table-card .dataTables_filter label{display:flex;width:100%}
        .tutor-table-card .dataTables_filter input{flex:1 1 auto;width:100%}
        .tutor-table-card .dataTables_info{float:none;padding-top:.65rem;text-align:center}
        .tutor-table-card .dataTables_paginate{float:none;padding-top:.4rem;text-align:center}
        .tutor-table-card .pagination{justify-content:center;flex-wrap:wrap}
    }
</style>
@endpush

@section('contenido')
    @php
        $totalAsignaciones = $grupos->count();
        $tutores = $grupos->pluck('tut_Clave')->unique()->filter()->count();
        $gruposDistintos = $grupos->pluck('gpo_Id')->unique()->filter()->count();
        $carreras = $grupos->pluck('car_Clave')->unique()->filter()->count();
        $tipos = $grupos->pluck('gtu_Tipo')->unique()->filter()->count();
    @endphp

    <div class="row g-3 mb-3">
        <div class="col-6 col-xl-3">
            <div class="tutor-card tutor-kpi tutor-kpi--grupos">
                <span class="tutor-kpi-icon"><i class="fa-solid fa-users-rectangle"></i></span>
                <div>
                    <span class="tutor-kpi-label">Asignaciones</span>
                    <span class="tutor-kpi-value">{{ $totalAsignaciones }}</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="tutor-card tutor-kpi tutor-kpi--tutores">
                <span class="tutor-kpi-icon"><i class="fa-solid fa-user-tie"></i></span>
                <div>
                    <span class="tutor-kpi-label">Tutores</span>
                    <span class="tutor-kpi-value">{{ $tutores }}</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="tutor-card tutor-kpi tutor-kpi--carreras">
                <span class="tutor-kpi-icon"><i class="fa-solid fa-building-columns"></i></span>
                <div>
                    <span class="tutor-kpi-label">Carreras</span>
                    <span class="tutor-kpi-value">{{ $carreras }}</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="tutor-card tutor-kpi tutor-kpi--tipos">
                <span class="tutor-kpi-icon"><i class="fa-solid fa-tags"></i></span>
                <div>
                    <span class="tutor-kpi-label">Tipos de tutoría</span>
                    <span class="tutor-kpi-value">{{ $tipos }}</span>
                </div>
            </div>
        </div>
    </div>

    <article class="tutor-card tutor-table-card">
        <div class="tutor-table-head">
            <div class="d-flex align-items-center gap-2">
                <h2><i class="fa-solid fa-people-group me-2"></i>Grupos asignados</h2>
                <span class="badge rounded-pill bg-light text-dark">{{ $totalAsignaciones }}</span>
            </div>
            @if (Auth::User()->hasAnyPermission(['VIP_STA', 'STA_DEP_TUTORIA']))
                <a href="{{ route('tutorias.index') }}" class="btn btn-sm btn-primary">
                    <i class="fa-solid fa-plus me-2"></i>Asignar tutoría
                </a>
            @endif
        </div>

        @if ($totalAsignaciones > 0)
            <div class="table-responsive">
                <table class="table align-middle mb-0" id="gpoAsignados">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tutor</th>
                            <th>Grupo</th>
                            <th>Carrera</th>
                            <th>Tipo</th>
                            <th>Semestre</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($grupos as $grupo)
                            @php
                                $tipo = strtolower((string) $grupo->gtu_Tipo);
                                $tipoClase = match ($tipo) {
                                    'ingreso' => 'tutor-tipo--ingreso',
                                    'permanencia' => 'tutor-tipo--permanencia',
                                    'egreso' => 'tutor-tipo--egreso',
                                    'jornada' => 'tutor-tipo--jornada',
                                    default => 'tutor-tipo--otro',
                                };
                            @endphp
                            <tr>
                                <td class="text-muted">{{ $loop->iteration }}</td>
                                <td class="tutor-alumno">
                                    <strong>{{ $grupo->name ?? 'Tutor sin nombre' }}</strong>
                                    <small>Clave {{ $grupo->tut_Clave }}</small>
                                </td>
                                <td><span class="font-monospace">{{ $grupo->gpo_Nombre ?? '—' }}</span></td>
                                <td>{{ $grupo->car_Nombre ?? 'Desconocida' }}</td>
                                <td>
                                    @if ($grupo->gtu_Tipo)
                                        <span class="tutor-tipo {{ $tipoClase }}">{{ $grupo->gtu_Tipo }}</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td class="text-muted">{{ $grupo->gtu_Semestre ?? '—' }}</td>
                                <td class="text-end">
                                    <a href="{{ route('tutores.showGrupo', [$grupo->id, $grupo->gpo_Nombre]) }}" class="btn btn-sm btn-primary" data-mdb-toggle="tooltip" title="Ver detalle del grupo">
                                        <i class="fa-solid fa-magnifying-glass-chart"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="tutor-empty">
                <i class="fa-regular fa-folder-open"></i>
                Todavía no hay tutores asignados a grupos.
                @if (Auth::User()->hasAnyPermission(['VIP_STA', 'STA_DEP_TUTORIA']))
                    <div class="mt-2">
                        <a href="{{ route('tutorias.index') }}" class="btn btn-sm btn-outline-primary">
                            <i class="fa-solid fa-plus me-2"></i>Asignar la primera tutoría
                        </a>
                    </div>
                @endif
            </div>
        @endif
    </article>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            if (!$('#gpoAsignados').length) {
                return;
            }

            $('#gpoAsignados').DataTable({
                dom: 'Bfrtip',
                pageLength: 10,
                lengthMenu: [[10, 25, 50, -1], ['10 registros', '25 registros', '50 registros', 'Ver todos']],
                pagingType: 'full_numbers',
                order: [[1, 'asc']],
                columnDefs: [
                    { orderable: false, targets: [6] }
                ],
                rowCallback: function (fila, datos, indice) {
                    fila.cells[0].textContent = indice + 1;
                },
                deferRender: true,
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
                ]
            });

            if (typeof mdb !== 'undefined' && mdb.Tooltip) {
                document.querySelectorAll('[data-mdb-toggle="tooltip"]').forEach(function (elemento) {
                    new mdb.Tooltip(elemento);
                });
            }
        });
    </script>
@endsection
