@extends('template.molde')

@section('title','Créditos')

@section('ruta')
    <span class="d-inline-flex align-items-center gap-2">
        <i class="fa-solid fa-award" style="color:#2d6da3"></i>
        Créditos
    </span>
@endsection

@push('styles')
<style>
    .cred-card{border:1px solid #e7edf4;border-radius:1rem;background:#fff;box-shadow:0 .75rem 1.5rem rgba(29,78,116,.10),0 .18rem .45rem rgba(16,43,74,.06)}
    .cred-card-head{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:.65rem;padding:1rem 1.25rem;border-bottom:1px solid #edf1f5;background:#f8fafc}
    .cred-card-head h2{margin:0;color:#102b4a;font-size:1.02rem;font-weight:700}
    .cred-kpi{display:flex;align-items:center;gap:.85rem;height:100%;padding:1rem 1.15rem}
    .cred-kpi-icon{width:44px;height:44px;flex:0 0 44px;display:grid;place-items:center;border-radius:.8rem;font-size:1.05rem}
    .cred-kpi-label{display:block;color:#6b7280;font-size:.78rem;text-transform:uppercase;letter-spacing:.03em}
    .cred-kpi-value{display:block;color:#102b4a;font-size:1.45rem;font-weight:700;line-height:1.1}
    .cred-kpi--total .cred-kpi-icon{color:#173c66;background:#edf3f8}
    .cred-kpi--vigentes .cred-kpi-icon{color:#1b7a43;background:#e7f5ec}
    .cred-kpi--no .cred-kpi-icon{color:#b45309;background:#fdf1e3}
    .cred-kpi--sin .cred-kpi-icon{color:#b3261e;background:#fdeceb}
    .cred-alert{display:flex;align-items:flex-start;gap:.75rem;padding:1rem 1.1rem;border:1px solid #f4d9a8;border-radius:.85rem;background:#fdf6e8;color:#8a5a00;font-size:.88rem}
    .cred-alert i{color:#b45309;font-size:1.05rem;margin-top:.1rem}
    .cred-table-card{overflow:hidden}
    .cred-table-card .dataTables_wrapper{position:relative;padding:0 1.25rem 1rem}
    .cred-table-card .dataTables_wrapper::after{content:"";display:block;clear:both}
    .cred-table-card .dt-buttons{float:left;margin:.85rem 0 .5rem;display:flex;flex-wrap:wrap;gap:.4rem}
    .cred-table-card .dt-buttons .dt-button{display:inline-flex;align-items:center;gap:.35rem;padding:.4rem .8rem;border:1px solid #cfdceb;border-radius:.55rem;background:#fff;color:#173c66;font-size:.8rem;font-weight:500;line-height:1.2;box-shadow:none;text-transform:none}
    .cred-table-card .dt-buttons .dt-button:hover,.cred-table-card .dt-buttons .dt-button:focus{background:#edf3f8;border-color:#b9cde1;color:#102b4a}
    .cred-table-card .dt-button-collection{border:1px solid #e2e9f1;border-radius:.7rem;box-shadow:0 .75rem 1.5rem rgba(16,43,74,.14);padding:.35rem}
    .cred-table-card .dt-button-collection .dt-button{border:0;border-radius:.45rem;width:100%;justify-content:flex-start}
    .cred-table-card .dataTables_filter{float:right;margin:.85rem 0 .5rem;text-align:right}
    .cred-table-card .dataTables_filter label{display:inline-flex;align-items:center;gap:.4rem;color:#6b7280;font-size:.85rem;font-weight:400;margin:0}
    .cred-table-card .dataTables_filter input{border:1px solid #d6e0ea;border-radius:.55rem;padding:.4rem .7rem;margin:0;background:#fff;box-shadow:none;font-size:.85rem}
    .cred-table-card .dataTables_filter input:focus{border-color:#2d6da3;box-shadow:0 0 0 .15rem rgba(45,109,163,.18);outline:0}
    .cred-table-card table.dataTable{clear:both;margin:.5rem 0 0!important;width:100%!important}
    .cred-table-card table.dataTable thead th{background:#f8fafc;color:#102b4a;font-size:.8rem;text-transform:uppercase;letter-spacing:.02em;border-bottom:1px solid #edf1f5;white-space:nowrap}
    .cred-table-card table.dataTable tbody td{vertical-align:middle}
    .cred-table-card .dataTables_info{float:left;color:#6b7280;font-size:.85rem;padding-top:1rem}
    .cred-table-card .dataTables_paginate{float:right;padding-top:.9rem}
    .cred-table-card .pagination{margin-bottom:0;gap:.2rem}
    .cred-table-card .page-link{border-radius:.55rem!important;color:#173c66;border-color:#e2e9f1;padding:.35rem .7rem;font-size:.82rem}
    .cred-table-card .page-item.active .page-link{background:#2d6da3;border-color:#2d6da3;color:#fff}
    .cred-table-card .page-link:hover{background:#edf3f8}
    .cred-nombre strong{display:block;color:#102b4a;font-size:.92rem}
    .cred-nombre small{color:#6b7280}
    .cred-empty{padding:2.75rem 1rem;text-align:center;color:#64748b;font-size:.9rem}
    .cred-empty i{display:block;margin-bottom:.6rem;font-size:1.8rem;color:#c3d0de}
    @media(max-width:767.98px){
        .cred-card-head{align-items:flex-start;flex-direction:column}
        .cred-table-card .dataTables_wrapper{padding:0 .85rem .85rem}
        .cred-table-card .dt-buttons{float:none;width:100%;margin:.75rem 0 .35rem}
        .cred-table-card .dt-buttons .buttons-colvis,.cred-table-card .dt-buttons .buttons-page-length{display:none}
        .cred-table-card .dataTables_filter{float:none;width:100%;text-align:left;margin:.25rem 0 .5rem}
        .cred-table-card .dataTables_filter label{display:flex;width:100%}
        .cred-table-card .dataTables_filter input{flex:1 1 auto;width:100%}
        .cred-table-card .dataTables_info{float:none;padding-top:.65rem;text-align:center}
        .cred-table-card .dataTables_paginate{float:none;padding-top:.4rem;text-align:center}
        .cred-table-card .pagination{justify-content:center;flex-wrap:wrap}
    }
</style>
@endpush

@section('contenido')
    @php
        $totalCreditos = $credito->count();
        $vigentes = $credito->where('vigente', 'true')->count();
        $noVigentes = $totalCreditos - $vigentes;
        $sinJefe = $credito->filter(fn ($c) => empty($c->jefe_nombre))->count();
    @endphp

    @if ($faltan_jefes)
        <div class="cred-alert mb-3">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <div>
                <strong>Hay créditos sin jefe asignado.</strong>
                Mientras no se asignen, no será posible imprimir constancias de esos créditos.
            </div>
        </div>
    @endif

    <div class="row g-3 mb-3">
        <div class="col-6 col-xl-3">
            <div class="cred-card cred-kpi cred-kpi--total">
                <span class="cred-kpi-icon"><i class="fa-solid fa-award"></i></span>
                <div>
                    <span class="cred-kpi-label">Créditos</span>
                    <span class="cred-kpi-value">{{ $totalCreditos }}</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="cred-card cred-kpi cred-kpi--vigentes">
                <span class="cred-kpi-icon"><i class="fa-solid fa-circle-check"></i></span>
                <div>
                    <span class="cred-kpi-label">Vigentes</span>
                    <span class="cred-kpi-value">{{ $vigentes }}</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="cred-card cred-kpi cred-kpi--no">
                <span class="cred-kpi-icon"><i class="fa-solid fa-circle-pause"></i></span>
                <div>
                    <span class="cred-kpi-label">No vigentes</span>
                    <span class="cred-kpi-value">{{ $noVigentes }}</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="cred-card cred-kpi cred-kpi--sin">
                <span class="cred-kpi-icon"><i class="fa-solid fa-user-slash"></i></span>
                <div>
                    <span class="cred-kpi-label">Sin jefe</span>
                    <span class="cred-kpi-value">{{ $sinJefe }}</span>
                </div>
            </div>
        </div>
    </div>

    <article class="cred-card cred-table-card">
        <div class="cred-card-head">
            <div class="d-flex align-items-center gap-2">
                <h2><i class="fa-solid fa-list-check me-2"></i>Listado de créditos</h2>
                <span class="badge rounded-pill bg-light text-dark">{{ $totalCreditos }}</span>
            </div>
            @if (Auth::User()->can('VIP') || Auth::User()->can('CREAR_CREDITOS'))
                <a href="{{ route('creditos.create') }}" class="btn btn-sm btn-primary">
                    <i class="fa-solid fa-plus me-2"></i>Agregar crédito
                </a>
            @endif
        </div>

        @if ($totalCreditos > 0)
            <div class="table-responsive">
                <table class="table align-middle mb-0" id="tabCreditos">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Crédito</th>
                            <th>Jefe</th>
                            <th>Vigente</th>
                            @if (Auth::User()->can('VIP') || Auth::User()->can('MODIFICAR_CREDITOS') || Auth::User()->can('ELIMINAR_CREDITOS'))
                                <th class="text-end">Acciones</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($credito as $cred)
                            <tr>
                                <td class="text-muted">{{ $loop->iteration }}</td>
                                <td class="cred-nombre">
                                    <strong>{{ $cred->nombre }}</strong>
                                    <small>Clave {{ $cred->id }}</small>
                                </td>
                                <td>
                                    @if ($cred->jefe_nombre)
                                        <span class="d-inline-flex align-items-center gap-2">
                                            <i class="fa-solid fa-user-tie text-muted"></i>{{ $cred->jefe_nombre }}
                                        </span>
                                    @else
                                        <span class="badge rounded-pill bg-warning text-dark">Sin jefe</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($cred->vigente == 'true')
                                        <span class="badge rounded-pill bg-success">Sí</span>
                                    @else
                                        <span class="badge rounded-pill bg-secondary">No</span>
                                    @endif
                                </td>
                                @if (Auth::User()->can('VIP') || Auth::User()->can('MODIFICAR_CREDITOS') || Auth::User()->can('ELIMINAR_CREDITOS'))
                                    <td class="text-end">
                                        <div class="d-inline-flex gap-1">
                                            @if (Auth::User()->can('MODIFICAR_CREDITOS') || Auth::User()->can('VIP'))
                                                <a href="{{ route('creditos.edit', [$cred->id]) }}" class="btn btn-sm btn-outline-primary" title="Modificar crédito">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                            @endif
                                            @if (Auth::User()->can('ELIMINAR_CREDITOS') || Auth::User()->can('VIP'))
                                                <button type="button" class="btn btn-sm btn-outline-danger" data-mdb-toggle="modal" data-mdb-target="#myModalMsg" data-credito-id="{{ $cred->id }}" data-credito-nombre="{{ $cred->nombre }}" onclick="undoCredito(this)" title="Eliminar crédito">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="cred-empty">
                <i class="fa-regular fa-folder-open"></i>
                Todavía no hay créditos registrados.
                @if (Auth::User()->can('VIP') || Auth::User()->can('CREAR_CREDITOS'))
                    <div class="mt-2">
                        <a href="{{ route('creditos.create') }}" class="btn btn-sm btn-outline-primary">
                            <i class="fa-solid fa-plus me-2"></i>Agregar el primero
                        </a>
                    </div>
                @endif
            </div>
        @endif
    </article>

    {{-- Modal para eliminar --}}
    <div class="modal fade" id="myModalMsg" tabindex="-1" aria-labelledby="myModalMsgLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalMsgLabel">Eliminar crédito</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-2">¿Seguro que querés eliminar este crédito?</p>
                    <p class="mb-0"><strong id="e_name"></strong></p>
                    <input type="hidden" id="e_id" name="id" readonly>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-mdb-dismiss="modal">Cancelar</button>
                    <a class="btn btn-danger" id="eliminar">
                        <i class="fa-solid fa-trash-can me-2"></i>Eliminar
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function undoCredito(boton) {
            var id = boton.dataset.creditoId;
            var nombre = boton.dataset.creditoNombre;

            document.getElementById('e_id').value = id;
            document.getElementById('e_name').textContent = nombre;
            document.getElementById('eliminar').href = "{{ url('/admin/creditos') }}/" + id + "/destroy";
        }

        $(document).ready(function () {
            if (typeof mdb !== 'undefined' && mdb.Tooltip) {
                document.querySelectorAll('[data-mdb-toggle="tooltip"]').forEach(function (elemento) {
                    new mdb.Tooltip(elemento);
                });
            }

            if (!$('#tabCreditos').length) {
                return;
            }

            $('#tabCreditos').DataTable({
                dom: 'Bfrtip',
                pageLength: 10,
                lengthMenu: [[10, 25, 50, -1], ['10 registros', '25 registros', '50 registros', 'Ver todos']],
                pagingType: 'full_numbers',
                order: [[1, 'asc']],
                columnDefs: [
                    { orderable: false, targets: -1 }
                ],
                rowCallback: function (fila, datos, indice) {
                    fila.cells[0].textContent = indice + 1;
                },
                deferRender: true,
                language: {
                    emptyTable: 'Sin créditos registrados',
                    info: 'Mostrando _START_ a _END_ de _TOTAL_ registros',
                    infoEmpty: 'Mostrando 0 a 0 de 0 registros',
                    infoFiltered: '(filtrado de _MAX_ registros totales)',
                    lengthMenu: 'Mostrar _MENU_ registros',
                    loadingRecords: 'Cargando…',
                    processing: 'Procesando…',
                    search: 'Buscar:',
                    zeroRecords: 'Sin coincidencias',
                    paginate: {
                        first: 'Primero',
                        last: 'Último',
                        next: 'Siguiente',
                        previous: 'Anterior'
                    }
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
        });
    </script>
@endsection
