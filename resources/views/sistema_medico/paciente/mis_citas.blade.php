@extends('template.molde')

@section('title','Sistema Medico - Mis Citas')

@section('ruta')
    <label class="label label-success"> <a href="#">Sistema Medico</a> / Mis Citas</label> 
@endsection

@section('contenido')
    {{--Tabla que muetra mis citas creadas con su estatus y un boton pra agregar una nueva cita--}}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mb-8">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-4">
                                <h3>Mis Citas Médicas</h3>
                            </div>
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <a href="{{ route('paciente.create.cita') }}" class="btn btn-secondary float-right" title="Agregar Cita"><i class="fas fa-calendar-plus"></i></a>
                                <a href="{{ route('paciente.editar.perfil') }}" class="btn btn-info float-right mr-2" title="Editar perfil"><i class="fas fa-user-edit"></i></a>
                            </div>
                        </div>                       
                    </div>
                    <div class="card-body">                        
                        <table class="table" id="misCitasTable">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Motivo</th>
                                    <th>Estatus</th>
                                    <th>Notas Adicionales</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($citas as $cita)
                                    <tr>
                                        <td>{{ $cita->fecha_cita }}</td>
                                        <td>{{ $cita->hora_cita }}</td>
                                        <td>{{ $cita->motivo_consulta }}</td>
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
                                        <td>{{ $cita->notas_adicionales }}</td>
                                        <td>
                                            <a href="{{ route('paciente.editar.cita', $cita->id) }}" class="btn btn-warning btn-sm" title="Editar Cita"><i class="fas fa-edit"></i></a>
                                            <form id="form-eliminar-{{ $cita->id }}" action="{{ route('paciente.destroy.cita', $cita->id) }}" method="POST" style="display: inline;">
                                                @csrf                                                
                                                <a  class="btn btn-danger btn-sm" title="Eliminar Cita" onclick="fnEliminarCita({{ $cita->id }})"><i class="fas fa-trash"></i></a>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
       // Codigo para adornar las tablas con datatables
        $(document).ready(function() {
            $('#misCitasTable').DataTable({ 	           
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

        // Funcion para eliminar una cita con confirmacion
        function fnEliminarCita(citaId) {   
            console.log("Eliminar cita con ID: " + citaId);
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarla',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirigir a la ruta de eliminación 'medico.destroy.cita'
                    document.getElementById('form-eliminar-' + citaId).submit();
                }
            });
        }
    </script>
@endsection