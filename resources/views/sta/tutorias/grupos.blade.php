@extends('template.molde')

@section('title','Grupos de tutoría')

@section('ruta')
    <span class="d-inline-flex align-items-center flex-wrap gap-2">
        <i class="fa-solid fa-users-rectangle" style="color:#2d6da3"></i>
        <a href="{{ route('tutorias.index') }}" class="text-decoration-none">Tutorías</a>
        <span class="text-muted">/</span>
        Grupos
    </span>
@endsection

@push('styles')
<style>
    .gpo-card{border:1px solid #e7edf4;border-radius:1rem;background:#fff;box-shadow:0 .75rem 1.5rem rgba(29,78,116,.10),0 .18rem .45rem rgba(16,43,74,.06)}
    .gpo-card-head{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:.65rem;padding:1rem 1.25rem;border-bottom:1px solid #edf1f5;background:#f8fafc}
    .gpo-card-head h2{margin:0;color:#102b4a;font-size:1.02rem;font-weight:700}
    .gpo-card-body{padding:1.25rem}
    .gpo-kpi{display:flex;align-items:center;gap:.85rem;height:100%;padding:1rem 1.15rem}
    .gpo-kpi-icon{width:44px;height:44px;flex:0 0 44px;display:grid;place-items:center;border-radius:.8rem;font-size:1.05rem}
    .gpo-kpi-label{display:block;color:#6b7280;font-size:.78rem;text-transform:uppercase;letter-spacing:.03em}
    .gpo-kpi-value{display:block;color:#102b4a;font-size:1.45rem;font-weight:700;line-height:1.1}
    .gpo-kpi--total .gpo-kpi-icon{color:#173c66;background:#edf3f8}
    .gpo-kpi--asignados .gpo-kpi-icon{color:#1b7a43;background:#e7f5ec}
    .gpo-kpi--sin .gpo-kpi-icon{color:#b45309;background:#fdf1e3}
    .gpo-kpi--carreras .gpo-kpi-icon{color:#6d28d9;background:#f1ecfd}
    .gpo-table-card{overflow:hidden}
    .gpo-table-card .dataTables_wrapper{position:relative;padding:0 1.25rem 1rem}
    .gpo-table-card .dataTables_wrapper::after{content:"";display:block;clear:both}
    .gpo-table-card .dt-buttons{float:left;margin:.85rem 0 .5rem;display:flex;flex-wrap:wrap;gap:.4rem}
    .gpo-table-card .dt-buttons .dt-button{display:inline-flex;align-items:center;gap:.35rem;padding:.4rem .8rem;border:1px solid #cfdceb;border-radius:.55rem;background:#fff;color:#173c66;font-size:.8rem;font-weight:500;line-height:1.2;box-shadow:none;text-transform:none}
    .gpo-table-card .dt-buttons .dt-button:hover,.gpo-table-card .dt-buttons .dt-button:focus{background:#edf3f8;border-color:#b9cde1;color:#102b4a}
    .gpo-table-card .dt-button-collection{border:1px solid #e2e9f1;border-radius:.7rem;box-shadow:0 .75rem 1.5rem rgba(16,43,74,.14);padding:.35rem}
    .gpo-table-card .dt-button-collection .dt-button{border:0;border-radius:.45rem;width:100%;justify-content:flex-start}
    .gpo-table-card .dataTables_filter{float:right;margin:.85rem 0 .5rem;text-align:right}
    .gpo-table-card .dataTables_filter label{display:inline-flex;align-items:center;gap:.4rem;color:#6b7280;font-size:.85rem;font-weight:400;margin:0}
    .gpo-table-card .dataTables_filter input{border:1px solid #d6e0ea;border-radius:.55rem;padding:.4rem .7rem;margin:0;background:#fff;box-shadow:none;font-size:.85rem}
    .gpo-table-card .dataTables_filter input:focus{border-color:#2d6da3;box-shadow:0 0 0 .15rem rgba(45,109,163,.18);outline:0}
    .gpo-table-card table.dataTable{clear:both;margin:.5rem 0 0!important;width:100%!important}
    .gpo-table-card table.dataTable thead th{background:#f8fafc;color:#102b4a;font-size:.8rem;text-transform:uppercase;letter-spacing:.02em;border-bottom:1px solid #edf1f5;white-space:nowrap}
    .gpo-table-card table.dataTable tbody td{vertical-align:middle}
    .gpo-table-card .dataTables_info{float:left;color:#6b7280;font-size:.85rem;padding-top:1rem}
    .gpo-table-card .dataTables_paginate{float:right;padding-top:.9rem}
    .gpo-table-card .pagination{margin-bottom:0;gap:.2rem}
    .gpo-table-card .page-link{border-radius:.55rem!important;color:#173c66;border-color:#e2e9f1;padding:.35rem .7rem;font-size:.82rem}
    .gpo-table-card .page-item.active .page-link{background:#2d6da3;border-color:#2d6da3;color:#fff}
    .gpo-table-card .page-link:hover{background:#edf3f8}
    .gpo-empty{padding:2.75rem 1rem;text-align:center;color:#64748b;font-size:.9rem}
    .gpo-empty i{display:block;margin-bottom:.6rem;font-size:1.8rem;color:#c3d0de}
    .gpo-nombre strong{display:block;color:#102b4a;font-size:.92rem}
    .gpo-nombre small{color:#6b7280}
    @media(max-width:767.98px){
        .gpo-card-head{align-items:flex-start;flex-direction:column}
        .gpo-card-body{padding:1rem}
        .gpo-table-card .dataTables_wrapper{padding:0 .85rem .85rem}
        .gpo-table-card .dt-buttons{float:none;width:100%;margin:.75rem 0 .35rem}
        .gpo-table-card .dt-buttons .buttons-colvis,.gpo-table-card .dt-buttons .buttons-page-length{display:none}
        .gpo-table-card .dataTables_filter{float:none;width:100%;text-align:left;margin:.25rem 0 .5rem}
        .gpo-table-card .dataTables_filter label{display:flex;width:100%}
        .gpo-table-card .dataTables_filter input{flex:1 1 auto;width:100%}
        .gpo-table-card .dataTables_info{float:none;padding-top:.65rem;text-align:center}
        .gpo-table-card .dataTables_paginate{float:none;padding-top:.4rem;text-align:center}
        .gpo-table-card .pagination{justify-content:center;flex-wrap:wrap}
    }
</style>
@endpush

@section('contenido')
    @php
        $totalGrupos = $grupos->count();
        $asignados = $grupos->where('gpo_Status', '!=', 0)->count();
        $sinAsignar = $totalGrupos - $asignados;
        $carrerasDistintas = $grupos->pluck('id_Carrera')->unique()->filter()->count();
    @endphp

    <div class="row g-3 mb-3">
        <div class="col-6 col-xl-3">
            <div class="gpo-card gpo-kpi gpo-kpi--total">
                <span class="gpo-kpi-icon"><i class="fa-solid fa-users-rectangle"></i></span>
                <div>
                    <span class="gpo-kpi-label">Grupos</span>
                    <span class="gpo-kpi-value">{{ $totalGrupos }}</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="gpo-card gpo-kpi gpo-kpi--asignados">
                <span class="gpo-kpi-icon"><i class="fa-solid fa-circle-check"></i></span>
                <div>
                    <span class="gpo-kpi-label">Asignados</span>
                    <span class="gpo-kpi-value">{{ $asignados }}</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="gpo-card gpo-kpi gpo-kpi--sin">
                <span class="gpo-kpi-icon"><i class="fa-solid fa-hourglass-half"></i></span>
                <div>
                    <span class="gpo-kpi-label">Sin asignar</span>
                    <span class="gpo-kpi-value">{{ $sinAsignar }}</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="gpo-card gpo-kpi gpo-kpi--carreras">
                <span class="gpo-kpi-icon"><i class="fa-solid fa-building-columns"></i></span>
                <div>
                    <span class="gpo-kpi-label">Carreras</span>
                    <span class="gpo-kpi-value">{{ $carrerasDistintas }}</span>
                </div>
            </div>
        </div>
    </div>

    <article class="gpo-card mb-3">
        <div class="gpo-card-head">
            <h2><i class="fa-solid fa-plus me-2"></i>Nuevo grupo</h2>
            <span class="text-muted small">Los grupos se usan para asignar tutorías</span>
        </div>
        <div class="gpo-card-body">
            <form action="{{ route('tutorias.saveGrupo') }}" method="POST">
                @csrf
                <div class="row g-3 align-items-end">
                    <div class="col-12 col-md-6 col-xl-3">
                        <label class="form-label" for="gpo_SemestreInp">Semestre</label>
                        <select name="gpo_Semestre" id="gpo_SemestreInp" class="form-select" required>
                            <option value="">Selecciona un semestre</option>
                            <option value="Feb-Jun">Febrero Junio</option>
                            <option value="Ago-Dic">Agosto Diciembre</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-xl-3">
                        <label class="form-label" for="gpo_Nombre">Nombre del grupo</label>
                        <input type="text" class="form-control" placeholder="Ej. 7A" name="gpo_Nombre" id="gpo_Nombre" maxlength="10" required>
                    </div>
                    <div class="col-12 col-md-6 col-xl-4">
                        <label class="form-label" for="selCarreras">Carrera</label>
                        <select class="form-select" id="selCarreras" name="id_Carrera" required>
                            <option value="">Seleccione una carrera</option>
                            @foreach ($carreras as $carrera)
                                <option value="{{ $carrera->car_Clave }}">{{ $carrera->car_Nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-xl-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fa-solid fa-floppy-disk me-2"></i>Guardar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </article>

    <article class="gpo-card gpo-table-card">
        <div class="gpo-card-head">
            <div class="d-flex align-items-center gap-2">
                <h2><i class="fa-solid fa-table-list me-2"></i>Grupos registrados</h2>
                <span class="badge rounded-pill bg-light text-dark">{{ $totalGrupos }}</span>
            </div>
            <div class="d-flex flex-wrap justify-content-end gap-2">
                @if($totalGrupos > 0)
                    <button type="button" class="btn btn-sm btn-outline-danger"
                        data-bs-toggle="modal" data-bs-target="#modalEliminarTodos"
                        data-mdb-toggle="modal" data-mdb-target="#modalEliminarTodos">
                        <i class="fa-solid fa-trash-can me-2"></i>Eliminar todos
                    </button>
                @endif
                <a href="{{ route('tutorias.index') }}" class="btn btn-sm btn-outline-primary">
                    <i class="fa-solid fa-arrow-left me-2"></i>Volver a tutorías
                </a>
            </div>
        </div>

        @if ($totalGrupos > 0)
            <div class="table-responsive">
                <table class="table align-middle mb-0" id="tabGrupos">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Grupo</th>
                            <th>Carrera</th>
                            <th>Semestre</th>
                            <th>Estatus</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($grupos as $grupo)
                            <tr>
                                <td class="text-muted">{{ $loop->iteration }}</td>
                                <td class="gpo-nombre">
                                    <strong>{{ $grupo->gpo_Nombre }}</strong>
                                    <small>Clave {{ $grupo->id }}</small>
                                </td>
                                <td>{{ $grupo->gpo_Carrera }}</td>
                                <td class="text-muted">{{ $grupo->gpo_Semestre ?? '—' }}</td>
                                <td>
                                    @if ($grupo->gpo_Status == 0)
                                        <span class="badge rounded-pill bg-warning text-dark">Sin asignar</span>
                                    @else
                                        <span class="badge rounded-pill bg-success">Asignado</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-1">
                                        <button type="button" class="btn btn-sm btn-outline-primary btn-edit-group"
                                            data-grupo="{{ json_encode($grupo, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) }}"
                                            data-action="{{ route('tutorias.updateGrupo', $grupo->id) }}"
                                            data-bs-toggle="modal" data-bs-target="#myModalUpdate"
                                            data-mdb-toggle="modal" data-mdb-target="#myModalUpdate" title="Editar grupo">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete-group"
                                            data-grupo="{{ json_encode($grupo, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) }}"
                                            data-action="{{ route('tutorias.deleteGrupo', $grupo->id) }}"
                                            data-bs-toggle="modal" data-bs-target="#myModalDelete"
                                            data-mdb-toggle="modal" data-mdb-target="#myModalDelete" title="Eliminar grupo">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="gpo-empty">
                <i class="fa-regular fa-folder-open"></i>
                Todavía no hay grupos registrados. Creá el primero con el formulario de arriba.
            </div>
        @endif
    </article>

    {{-- Modal editar --}}
    <div class="modal fade" id="myModalUpdate" tabindex="-1" aria-labelledby="myModalUpdateLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form id="formUpdateGrupo" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalUpdateLabel">Editar grupo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" data-mdb-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label" for="gpo_NombreMod">Nombre del grupo</label>
                            <input type="text" class="form-control" name="gpo_Nombre" id="gpo_NombreMod" maxlength="10" required>
                            <input type="hidden" id="status" name="gpo_Status" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="selCarrerasMod">Carrera</label>
                            <select class="form-select" id="selCarrerasMod" name="id_Carrera" required>
                                <option value="">Seleccione una carrera</option>
                                @foreach ($carreras as $carrera)
                                    <option value="{{ $carrera->car_Clave }}">{{ $carrera->car_Nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="form-label" for="selSemestreMod">Semestre</label>
                            <select class="form-select" id="selSemestreMod" name="gpo_Semestre" required>
                                <option value="">Seleccione un semestre</option>
                                <option value="Feb-Jun">Febrero Junio</option>
                                <option value="Ago-Dic">Agosto Diciembre</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" data-mdb-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-floppy-disk me-2"></i>Guardar cambios
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal eliminar --}}
    <div class="modal fade" id="myModalDelete" tabindex="-1" aria-labelledby="myModalDeleteLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="" method="get" id="formDeleteGrupo">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalDeleteLabel">Eliminar grupo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" data-mdb-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-0" id="mensaje"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" data-mdb-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fa-solid fa-trash-can me-2"></i>Eliminar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modalEliminarTodos" tabindex="-1" aria-labelledby="modalEliminarTodosLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('tutorias.deleteAllGrupos') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="modalEliminarTodosLabel">
                            <i class="fa-solid fa-triangle-exclamation me-2"></i>Eliminar todos los grupos
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" data-mdb-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-2">¿Estás seguro de eliminar <strong>todos los {{ $totalGrupos }} grupos</strong>?</p>
                        <p class="text-danger mb-0"><strong>Esta acción también eliminará las asignaciones y vinculaciones asociadas.</strong></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" data-mdb-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fa-solid fa-trash-can me-2"></i>Eliminar todos
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('#gpo_Nombre').on('keyup', function () {
            $(this).val($(this).val().toUpperCase());
        });

        function modificarGrupo(button) {
            const grupo = JSON.parse(button.dataset.grupo);
            $('#gpo_NombreMod').val(grupo.gpo_Nombre);
            $('#selCarrerasMod').val(grupo.id_Carrera);
            $('#status').val(grupo.gpo_Status);
            $('#selSemestreMod').val(grupo.gpo_Semestre);
            $('#formUpdateGrupo').attr('action', button.dataset.action);
            $('#gpo_NombreMod').trigger('change');
            $('#selCarrerasMod').trigger('change');
            $('#selSemestreMod').trigger('change');
        }

        function eliminarGrupo(button) {
            const grupo = JSON.parse(button.dataset.grupo);
            $('#mensaje').html('¿Seguro que querés eliminar el grupo <strong>' + grupo.gpo_Nombre + '</strong>?');
            $('#formDeleteGrupo').attr('action', button.dataset.action);
        }

        $(document).on('click', '.btn-edit-group', function () {
            modificarGrupo(this);
        });

        $('#myModalUpdate').on('shown.bs.modal shown.mdb.modal', function () {
            const activeButton = $(document.activeElement).closest('.btn-edit-group')[0];
            if (activeButton) {
                modificarGrupo(activeButton);
            }
        });

        $(document).on('click', '.btn-delete-group', function () {
            eliminarGrupo(this);
        });

        $(document).ready(function () {
            if (!$('#tabGrupos').length) {
                return;
            }

            $('#tabGrupos').DataTable({
                dom: 'Bfrtip',
                pageLength: 10,
                lengthMenu: [[10, 25, 50, -1], ['10 registros', '25 registros', '50 registros', 'Ver todos']],
                pagingType: 'full_numbers',
                order: [[1, 'asc']],
                columnDefs: [
                    { orderable: false, targets: [5] }
                ],
                rowCallback: function (fila, datos, indice) {
                    fila.cells[0].textContent = indice + 1;
                },
                deferRender: true,
                language: {
                    emptyTable: 'Sin grupos registrados',
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
