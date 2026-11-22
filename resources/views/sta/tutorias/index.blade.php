@extends('template.molde')

@section('title','Departamento de tutorías')

@section('ruta')
    <span class="d-inline-flex align-items-center gap-2">
        <i class="fa-solid fa-users-gear" style="color:#2d6da3"></i>
        Departamento de tutorías
    </span>
@endsection

@push('styles')
<style>
    .tut-card{border:1px solid #e7edf4;border-radius:1rem;background:#fff;box-shadow:0 .75rem 1.5rem rgba(29,78,116,.10),0 .18rem .45rem rgba(16,43,74,.06)}
    .tut-card-head{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:.65rem;padding:1rem 1.25rem;border-bottom:1px solid #edf1f5;background:#f8fafc}
    .tut-card-head h2{margin:0;color:#102b4a;font-size:1.02rem;font-weight:700}
    .tut-card-body{padding:1.25rem}
    .tut-kpi{display:flex;align-items:center;gap:.85rem;height:100%;padding:1rem 1.15rem}
    .tut-kpi-icon{width:44px;height:44px;flex:0 0 44px;display:grid;place-items:center;border-radius:.8rem;font-size:1.05rem}
    .tut-kpi-label{display:block;color:#6b7280;font-size:.78rem;text-transform:uppercase;letter-spacing:.03em}
    .tut-kpi-value{display:block;color:#102b4a;font-size:1.45rem;font-weight:700;line-height:1.1}
    .tut-kpi--asig .tut-kpi-icon{color:#173c66;background:#edf3f8}
    .tut-kpi--tutores .tut-kpi-icon{color:#1b7a43;background:#e7f5ec}
    .tut-kpi--grupos .tut-kpi-icon{color:#b45309;background:#fdf1e3}
    .tut-kpi--carreras .tut-kpi-icon{color:#6d28d9;background:#f1ecfd}
    .tut-tipo{display:inline-flex;align-items:center;gap:.3rem;padding:.2rem .55rem;border-radius:999px;font-size:.75rem;font-weight:600}
    .tut-tipo--ingreso{background:#e7f5ec;color:#1b7a43}
    .tut-tipo--permanencia{background:#edf3f8;color:#173c66}
    .tut-tipo--egreso{background:#fdf1e3;color:#b45309}
    .tut-tipo--jornada{background:#f1ecfd;color:#6d28d9}
    .tut-tipo--otro{background:#f1f5f9;color:#64748b}
    .tut-empty{padding:2.75rem 1rem;text-align:center;color:#64748b;font-size:.9rem}
    .tut-empty i{display:block;margin-bottom:.6rem;font-size:1.8rem;color:#c3d0de}
    .tut-table-card{overflow:hidden}
    .tut-table-card .dataTables_wrapper{position:relative;padding:0 1.25rem 1rem}
    .tut-table-card .dataTables_wrapper::after{content:"";display:block;clear:both}
    .tut-table-card .dt-buttons{float:left;margin:.85rem 0 .5rem;display:flex;flex-wrap:wrap;gap:.4rem}
    .tut-table-card .dt-buttons .dt-button{display:inline-flex;align-items:center;gap:.35rem;padding:.4rem .8rem;border:1px solid #cfdceb;border-radius:.55rem;background:#fff;color:#173c66;font-size:.8rem;font-weight:500;line-height:1.2;box-shadow:none;text-transform:none}
    .tut-table-card .dt-buttons .dt-button:hover,.tut-table-card .dt-buttons .dt-button:focus{background:#edf3f8;border-color:#b9cde1;color:#102b4a}
    .tut-table-card .dt-button-collection{border:1px solid #e2e9f1;border-radius:.7rem;box-shadow:0 .75rem 1.5rem rgba(16,43,74,.14);padding:.35rem}
    .tut-table-card .dt-button-collection .dt-button{border:0;border-radius:.45rem;width:100%;justify-content:flex-start}
    .tut-table-card .dataTables_filter{float:right;margin:.85rem 0 .5rem;text-align:right}
    .tut-table-card .dataTables_filter label{display:inline-flex;align-items:center;gap:.4rem;color:#6b7280;font-size:.85rem;font-weight:400;margin:0}
    .tut-table-card .dataTables_filter input{border:1px solid #d6e0ea;border-radius:.55rem;padding:.4rem .7rem;margin:0;background:#fff;box-shadow:none;font-size:.85rem}
    .tut-table-card .dataTables_filter input:focus{border-color:#2d6da3;box-shadow:0 0 0 .15rem rgba(45,109,163,.18);outline:0}
    .tut-table-card table.dataTable{clear:both;margin:.5rem 0 0!important;width:100%!important}
    .tut-table-card table.dataTable thead th{background:#f8fafc;color:#102b4a;font-size:.8rem;text-transform:uppercase;letter-spacing:.02em;border-bottom:1px solid #edf1f5;white-space:nowrap}
    .tut-table-card table.dataTable tbody td{vertical-align:middle}
    .tut-table-card .dataTables_info{float:left;color:#6b7280;font-size:.85rem;padding-top:1rem}
    .tut-table-card .dataTables_paginate{float:right;padding-top:.9rem}
    .tut-table-card .pagination{margin-bottom:0;gap:.2rem}
    .tut-table-card .page-link{border-radius:.55rem!important;color:#173c66;border-color:#e2e9f1;padding:.35rem .7rem;font-size:.82rem}
    .tut-table-card .page-item.active .page-link{background:#2d6da3;border-color:#2d6da3;color:#fff}
    .tut-table-card .page-link:hover{background:#edf3f8}
    .profe-alumno strong{display:block;color:#102b4a;font-size:.9rem}
    .profe-alumno small{color:#6b7280}
    @media(max-width:767.98px){
        .tut-card-head{align-items:flex-start;flex-direction:column}
        .tut-card-body{padding:1rem}
        .tut-table-card .dataTables_wrapper{padding:0 .85rem .85rem}
        .tut-table-card .dt-buttons{float:none;width:100%;margin:.75rem 0 .35rem}
        .tut-table-card .dt-buttons .buttons-colvis,.tut-table-card .dt-buttons .buttons-page-length{display:none}
        .tut-table-card .dataTables_filter{float:none;width:100%;text-align:left;margin:.25rem 0 .5rem}
        .tut-table-card .dataTables_filter label{display:flex;width:100%}
        .tut-table-card .dataTables_filter input{flex:1 1 auto;width:100%}
        .tut-table-card .dataTables_info{float:none;padding-top:.65rem;text-align:center}
        .tut-table-card .dataTables_paginate{float:none;padding-top:.4rem;text-align:center}
        .tut-table-card .pagination{justify-content:center;flex-wrap:wrap}
    }
</style>
@endpush

@section('contenido')
    @php
        $totalAsignaciones = $gruTutorias->count();
        $tutores = $gruTutorias->pluck('tut_Clave')->unique()->filter()->count();
        $gruposDistintos = $gruTutorias->pluck('gpo_Id')->unique()->filter()->count();
        $carrerasAtendidas = $gruTutorias->pluck('car_Clave')->unique()->filter()->count();
        $tipos = [
            'Ingreso' => 'tut-tipo--ingreso',
            'Permanencia' => 'tut-tipo--permanencia',
            'Egreso' => 'tut-tipo--egreso',
            'Jornada' => 'tut-tipo--jornada',
        ];
    @endphp

    <div class="row g-3 mb-3">
        <div class="col-6 col-xl-3">
            <div class="tut-card tut-kpi tut-kpi--asig">
                <span class="tut-kpi-icon"><i class="fa-solid fa-clipboard-check"></i></span>
                <div>
                    <span class="tut-kpi-label">Asignaciones</span>
                    <span class="tut-kpi-value">{{ $totalAsignaciones }}</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="tut-card tut-kpi tut-kpi--tutores">
                <span class="tut-kpi-icon"><i class="fa-solid fa-user-tie"></i></span>
                <div>
                    <span class="tut-kpi-label">Tutores</span>
                    <span class="tut-kpi-value">{{ $tutores }}</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="tut-card tut-kpi tut-kpi--grupos">
                <span class="tut-kpi-icon"><i class="fa-solid fa-users-rectangle"></i></span>
                <div>
                    <span class="tut-kpi-label">Grupos</span>
                    <span class="tut-kpi-value">{{ $gruposDistintos }}</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="tut-card tut-kpi tut-kpi--carreras">
                <span class="tut-kpi-icon"><i class="fa-solid fa-building-columns"></i></span>
                <div>
                    <span class="tut-kpi-label">Carreras</span>
                    <span class="tut-kpi-value">{{ $carrerasAtendidas }}</span>
                </div>
            </div>
        </div>
    </div>

    <article class="tut-card mb-3">
        <div class="tut-card-head">
            <h2><i class="fa-solid fa-user-plus me-2"></i>Asignar tutoría</h2>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('tutorias.getGruposAll') }}" class="btn btn-sm btn-outline-primary">
                    <i class="fa-solid fa-users me-2"></i>Grupos
                </a>
                <a href="{{ route('analisis.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fa-solid fa-user-graduate me-2"></i>Analizar alumnos
                </a>
            </div>
        </div>
        <div class="tut-card-body">
            <form action="{{ route('tutorias.saveGrupoTut') }}" method="post">
                @csrf
                <div class="row g-3">
                    <div class="col-12 col-md-4 col-xl-3">
                        @include('template.partes.buscador_combobox', [
                            'config' => [
                                'id' => 'tutorCatedratico',
                                'bare' => true,
                                'show_submit' => false,
                                'required' => true,
                                'field' => 'tut_Clave',
                                'label' => 'Catedrático / Profesor',
                                'placeholder' => 'Escribe nombre o apellidos',
                                'endpoint' => route('tutorias.catedraticos.busqueda'),
                                'query_param' => 'nombre',
                                'min_chars' => 2,
                                'limit' => 8,
                                'keys' => ['value' => 'cat_Clave', 'label' => 'nombre_completo', 'meta' => 'departamento'],
                            ],
                        ])
                    </div>
                    <div class="col-12 col-md-4 col-xl-2">
                        <label class="form-label" for="gtu_Semestre">Semestre</label>
                        <select name="gtu_Semestre" id="gtu_Semestre" class="form-select" required>
                            <option value="">Seleccione un semestre</option>
                            <option value="Feb-Jun">Febrero Junio</option>
                            <option value="Ago-Dic">Agosto Diciembre</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-4 col-xl-3">
                        <label class="form-label" for="selCarreras">Carrera a atender</label>
                        <select name="car_Clave" id="selCarreras" class="form-select" required>
                            <option value="">Seleccione una carrera</option>
                            @foreach ($carreras as $carrera)
                                <option value="{{ $carrera->car_Clave }}">{{ $carrera->car_Nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-xl-2">
                        <label class="form-label" for="selGrupos">Grupo</label>
                        <select name="gpo_Id" id="selGrupos" class="form-select" required>
                            <option value="">Seleccione un grupo</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-xl-2">
                        <label class="form-label" for="selTipo">Tipo de tutoría</label>
                        <select name="gtu_Tipo" id="selTipo" class="form-select" required>
                            <option value="">Seleccione un tipo</option>
                            <option value="Ingreso">Ingreso</option>
                            <option value="Permanencia">Permanencia</option>
                            <option value="Egreso">Egreso</option>
                            <option value="Jornada">Jornada</option>
                        </select>
                    </div>
                </div>
                <p class="form-text mt-2 mb-0" id="gruposHint">Elegí semestre y carrera para ver los grupos.</p>
                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-plus me-2"></i>Asignar grupo de tutoría
                    </button>
                </div>
            </form>
        </div>
    </article>

    <article class="tut-card tut-table-card">
        <div class="tut-card-head">
            <div class="d-flex align-items-center gap-2">
                <h2><i class="fa-solid fa-people-group me-2"></i>Grupos asignados</h2>
                <span class="badge rounded-pill bg-light text-dark">{{ $totalAsignaciones }}</span>
            </div>
            <span class="text-muted small">Cada asignación genera su constancia de asignación y liberación</span>
        </div>

        @if ($totalAsignaciones > 0)
            <div class="table-responsive">
                <table class="table align-middle mb-0" id="tabGruposTut">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Profesor</th>
                            <th>Grupo</th>
                            <th>Carrera</th>
                            <th>Semestre</th>
                            <th>Tipo</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($gruTutorias as $grupo)
                            @php
                                $tipoClase = $tipos[$grupo->gtu_Tipo] ?? 'tut-tipo--otro';
                            @endphp
                            <tr>
                                <td class="text-muted">{{ $loop->iteration }}</td>
                                <td class="profe-alumno">
                                    <strong>{{ $grupo->name ?? 'Tutor sin nombre' }}</strong>
                                    <small>{{ $grupo->gtu_Tipo ? 'Tutoría de '.strtolower($grupo->gtu_Tipo) : 'Sin tipo' }}</small>
                                </td>
                                <td><span class="font-monospace">{{ $grupo->gpo_Nombre ?? '—' }}</span></td>
                                <td>{{ $grupo->car_Nombre ?? 'Desconocida' }}</td>
                                <td class="text-muted">{{ $grupo->gtu_Semestre ?? '—' }} {{ $grupo->gtu_Año ?? '' }}</td>
                                <td>
                                    @if ($grupo->gtu_Tipo)
                                        <span class="tut-tipo {{ $tipoClase }}">{{ $grupo->gtu_Tipo }}</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('tutorias.asigTutPDF', $grupo->id) }}" class="btn btn-sm btn-outline-success" target="_blank" data-mdb-toggle="tooltip" title="Constancia de asignación">
                                            <i class="fa-solid fa-file-contract"></i>
                                        </a>
                                        <a href="{{ route('tutorias.libTutPDF', $grupo->id) }}" class="btn btn-sm btn-outline-secondary" target="_blank" data-mdb-toggle="tooltip" title="Constancia de liberación">
                                            <i class="fa-solid fa-file-signature"></i>
                                        </a>
                                        <button type="button"
                                            class="btn btn-sm btn-outline-danger btn-eliminar-asignacion"
                                            data-grupo="{{ json_encode($grupo, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) }}"
                                            data-action="{{ route('tutorias.destroy', $grupo->id) }}"
                                            data-bs-toggle="modal" data-bs-target="#modalEliminar"
                                            data-mdb-toggle="modal" data-mdb-target="#modalEliminar"
                                            title="Eliminar asignación">
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
            <div class="tut-empty">
                <i class="fa-regular fa-folder-open"></i>
                Todavía no hay asignaciones de tutoría.
            </div>
        @endif
    </article>

    {{-- Modal para eliminar asignaciones --}}
    <div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form id="formEliminar" method="get">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEliminarLabel">Eliminar asignación</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" data-mdb-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-3" id="mensaje"></p>
                        <input type="hidden" name="gpo_Id" id="idGrupo">
                        <input type="hidden" name="gpo_Nombre" id="gpo_Nombre">
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
@endsection

@section('js')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#gtu_Semestre').on('change', function () {
            $('#selGrupos').empty().append("<option value=''>Seleccione un grupo</option>");
            $('#selCarreras').val('');
            $('#gruposHint').text('Elegí semestre y carrera para ver los grupos.');
        });

        $('#selCarreras').on('change', function () {
            var car_Clave = $(this).val();
            var gpo_Semestre = $('#gtu_Semestre').val();

            if (!gpo_Semestre) {
                $('#selGrupos').empty().append("<option value=''>Seleccione un grupo</option>");
                $('#gruposHint').text('Primero elegí el semestre.');
                return;
            }

            $.ajax({
                url: "{{ route('tutorias.getGruposCar') }}",
                method: 'POST',
                data: {
                    car_Clave: car_Clave,
                    gpo_Semestre: gpo_Semestre
                },
                success: function (data) {
                    $('#selGrupos').empty().append("<option value=''>Seleccione un grupo</option>");

                    $.each(data, function (key, value) {
                        $('#selGrupos').append('<option value="' + value.id + '">' + value.gpo_Nombre + '</option>');
                    });

                    $('#gruposHint').text(data.length === 0
                        ? 'La carrera no tiene grupos en ese semestre.'
                        : data.length + (data.length === 1 ? ' grupo disponible' : ' grupos disponibles'));
                },
                error: function (data) {
                    console.log('Error al recuperar los grupos, error: ', data);
                    $('#gruposHint').text('No se pudieron cargar los grupos.');
                }
            });
        });

        function eliminarAsignacion(button) {
            const grupo = JSON.parse(button.dataset.grupo);
            $('#modalEliminarLabel').text('Eliminar asignación de tutoría');
            $('#mensaje').text('¿Seguro que querés eliminar la asignación con el grupo ' + grupo.gpo_Nombre + '?');
            $('#formEliminar').attr('action', button.dataset.action);
            $('#idGrupo').val(grupo.gpo_Id);
            $('#gpo_Nombre').val(grupo.gpo_Nombre);
        }

        $(document).on('click', '.btn-eliminar-asignacion', function () {
            eliminarAsignacion(this);
        });

        $(document).ready(function () {
            if (typeof mdb !== 'undefined' && mdb.Tooltip) {
                document.querySelectorAll('[data-mdb-toggle="tooltip"]').forEach(function (elemento) {
                    new mdb.Tooltip(elemento);
                });
            }

            if (!$('#tabGruposTut').length) {
                return;
            }

            $('#tabGruposTut').DataTable({
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
                    emptyTable: 'Sin asignaciones registradas',
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
