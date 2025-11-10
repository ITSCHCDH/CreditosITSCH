@extends('template.molde')

@section('title','Sistema Medico - Index')

@section('ruta')
    <label class="label label-success"> <a href="#">Sistema Medico</a> / Index</label> 
@endsection

@section('contenido')
    {{--Mostramos las citas programadas--}}
    <div class="container mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Agenda Médica</h4>
            <hr>
             <!-- Filtros -->
            <div class="btn-group" role="group">
                <a href="{{ request()->fullUrlWithQuery(['filtro' => 'pendientes']) }}" 
                   class="btn btn-{{ $filtro == 'pendientes' ? 'primary' : 'outline-primary' }} btn-sm">
                    📅 Pendientes/Confirmadas
                </a>
                <a href="{{ request()->fullUrlWithQuery(['filtro' => 'atendidas']) }}" 
                   class="btn btn-{{ $filtro == 'atendidas' ? 'success' : 'outline-success' }} btn-sm">
                    ✅ Atendidas
                </a>
                <a href="{{ request()->fullUrlWithQuery(['filtro' => 'canceladas']) }}" 
                   class="btn btn-{{ $filtro == 'canceladas' ? 'danger' : 'outline-danger' }} btn-sm">
                    ❌ Canceladas
                </a>
                <a href="{{ request()->fullUrlWithQuery(['filtro' => 'todas']) }}" 
                   class="btn btn-{{ $filtro == 'todas' ? 'secondary' : 'outline-secondary' }} btn-sm">
                    📊 Todas
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="citasTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Paciente</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Motivo</th>
                            <th>Comentarios</th>
                            <th>Status</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($citas as $cita)
                            <tr>
                                <td>{{ $cita->id }}</td>
                                <td>{{ $cita->paciente->user->name }}</td>
                                <td>{{ $cita->fecha_cita }}</td>
                                <td>{{ $cita->hora_cita }}</td>
                                <td>{{ $cita->motivo_consulta }}</td>
                                <td>{{ $cita->notas_adicionales }}</td>
                                <td>
                                    @if($cita->estado_cita == 'Pendiente')
                                        <span class="badge bg-warning text-dark">{{ $cita->estado_cita }}</span>
                                    @elseif($cita->estado_cita == 'Confirmada')
                                        <span class="badge bg-success">{{ $cita->estado_cita }}</span>
                                    @elseif($cita->estado_cita == 'Cancelada')
                                        <span class="badge bg-danger">{{ $cita->estado_cita }}</span>
                                    @elseif($cita->estado_cita == 'Atendida')
                                        <span class="badge bg-primary">{{ $cita->estado_cita }}</span>                                    
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('medico.editar.cita', $cita->id) }}" class="btn btn-warning btn-sm" title="Gestionar cita">📋</a>
                                    <a href="{{ route('medico.atender.cita', $cita->id) }}" class="btn btn-success btn-sm" title="Atender cita">✅</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
       // Codigo para adornar las tablas con datatables
        $(document).ready(function() {
            $('#citasTable').DataTable({ 	           
                dom: 'Bfrtip',
                responsive: {
                    breakpoints: [
                        {name: 'bigdesktop', width: Infinity},
                        {name: 'meddesktop', width: 1366},
                        {name: 'smalldesktop', width: 1280},
                        {name: 'medium', width: 1188},
                        {name: 'tabletl', width: 1024},
                        {name: 'btwtabllandp', width: 848},
                        {name: 'tabletp', width: 768},
                        {name: 'mobilel', width: 600},
                        {name: 'mobilep', width: 320}
                    ]
                },	            		    

                // Configuración de paginación mejorada
                "paging": true,
                "pageLength": 5,
                "lengthMenu": [
                    [5, 10, 25, 50, -1],
                    ['5 reg', '10 reg', '25 reg', '50 reg', 'Ver todo']
                ],
                "pagingType": "full_numbers",
                
                buttons: [
                    {
                        extend: 'collection', 
                        text: 'Exportar',
                        className: 'btn-primary btn-sm',
                        buttons: [ 
                            { 
                                extend: 'copyHtml5', 
                                text: '<i class="fas fa-copy"></i> Copiar',
                                className: 'btn-sm'
                            },
                            { 
                                extend: 'csvHtml5',
                                text: '<i class="fas fa-file-csv"></i> CSV',
                                className: 'btn-sm'
                            }, 
                            { 
                                extend: 'excelHtml5',
                                text: '<i class="fas fa-file-excel"></i> Excel',
                                className: 'btn-sm'
                            }, 
                            { 
                                extend: 'pdfHtml5',
                                text: '<i class="fas fa-file-pdf"></i> PDF',
                                className: 'btn-sm'
                            },
                            { 
                                extend: 'print', 
                                text: '<i class="fas fa-print"></i> Imprimir',
                                className: 'btn-sm'
                            }, 
                        ]
                    },                 
                    { 
                        extend: 'colvis', 
                        text: '<i class="fas fa-columns"></i> Columnas visibles',
                        className: 'btn-info btn-sm'
                    },                       
                    { 
                        extend: 'pageLength',
                        text: '<i class="fas fa-list"></i> Ver registros',
                        className: 'btn-warning btn-sm'
                    },               
                ],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
                },
                
                // Opciones adicionales para mejor rendimiento
                "deferRender": true,
                "processing": true,
                "stateSave": true
            });
        });   
    </script>
@endsection