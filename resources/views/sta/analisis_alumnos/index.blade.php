@extends('template.molde')

@section('title','Alumnos')

@section('ruta')
    <label class="label label-success"> <a href="#">STA</a> / Analisis alumnos</label> 
@endsection

@section('contenido')
    <form action="{{ route('analisis.generacion') }}" method="post">
        @csrf
        <div class="row">       
            <div class="col-sm-3" >
                <h5>Selecciona una generación</h5>       
                <select class="form-control " name="generacion" id="generacion" required>
                    <option selected value="">Selecciona una opción</option>
                    @foreach ($generaciones as $gen )
                        @if($generacion==$gen->Alu_AnioIngreso)
                            <option value="{{ $gen->Alu_AnioIngreso }}" selected>{{ $gen->Alu_AnioIngreso }}</option>
                        @else
                            <option value="{{ $gen->Alu_AnioIngreso }}">{{ $gen->Alu_AnioIngreso }}</option>
                        @endif                        
                    @endforeach              
                </select>             
            </div>
            <div class="col-sm-3" >
                <h5>Selecciona una carrera</h5>        
                <select class="form-control " name="carrera" id="carrera" required>
                    <option selected value="">Selecciona una opción</option>
                    @foreach ($carreras as $car )
                        @if($carrera==$car->car_Clave)
                            <option value="{{ $car->car_Clave }}" selected>{{ $car->car_Nombre }}</option>
                        @else
                            <option value="{{ $car->car_Clave }}">{{ $car->car_Nombre }}</option>
                        @endif                         
                    @endforeach              
                </select>               
            </div>           
            <div class="col-sm-3">
                <br>
                <button type="submit" class="btn btn-success" title="Buscar" ><i class="fas fa-search"></i></button>                
            </div> 
            <div class="col-sm-3">         
            </div>      
        </div>
    </form>
    <br>
    <table class="table" id="tabGrupos">
        <thead>
            <th>#</th>
            <th>Control</th>           
            <th>Nombre</th>
            <th>Último semestre</th>
            <th>Status</th>
            <th>Semaforos</th>
            <th>Acciones</th>
        </thead>
        <tbody>
            @if($grupo!="")
                @foreach ($grupo as $gru)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $gru->control }}</td>
                        <td>{{ $gru->aPaterno }} {{ $gru->aMaterno }} {{ $gru->nombre }}</td>
                        <td>{{ $gru->semestre }}</td>
                        <td>
                            @switch($gru->status)
                            @case('BD')
                                Baja definitiva
                                @break
                            @case('BT')
                                Baja temporal
                                @break
                            @case('VI')
                                Vigente
                                @break   
                            @case('EG')
                                Egresado
                                @break                        
                            @default
                                Sin status                       
                        @endswitch
                        </td>
                        <td>
                            <div class="row">
                                <div class="col-sm-2">
                                    <a href="{{ route('analisis.alumno',$gru->control) }}"><div class="{{ $gru->semaforos['semaforoAcad'] }}" data-mdb-toggle="tooltip" title="{{  $gru->semaforos['titleAcad'] }}"></div></a>
                                </div>
                                <div class="col-sm-2">
                                    <a href=""><div class="{{ $gru->semaforos['semaforoMedico'] }}" data-mdb-toggle="tooltip" title="Medico"></div></a>
                                </div>
                                <div class="col-sm-2">
                                    <a href=""><div class="{{ $gru->semaforos['semaforoPsico'] }}" data-mdb-toggle="tooltip" title="Psicologico"></div></a>
                                </div>
                                <div class="col-sm-2">
                                    <a href=""><div class="{{ $gru->semaforos['semaforoServicio'] }}" data-mdb-toggle="tooltip" title="{{ $gru->semaforos['titleSS'] }}"></div></a>
                                </div>
                            </div>                           
                        </td>
                        <td>
                            <a href="{{ route('analisis.alumno',$gru->control) }}" class="btn btn-primary" title="Ver más"><i class="fas fa-search-plus"></i></a>
                            @if($gru->ficha==1)
                                <a href="{{ route('analisis.ficha',[$gru->control,1]) }}" class="btn btn-secondary" title="Ver ficha"><i class="fas fa-file-invoice"></i></a>
                            @else
                                <button class="btn btn-light" title="Alumno sin ficha"><i class="fas fa-file-invoice"></i></button>
                            @endif                            
                        </td>
                    </tr>                
                @endforeach
            @endif
        </tbody>
    </table>      
@endsection

@section('js')
    <script>
       // Codigo para adornar las tablas con datatables
        $(document).ready(function() {
            $('#tabGrupos').DataTable({ 	           
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