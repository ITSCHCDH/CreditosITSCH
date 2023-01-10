@extends('template.molde')

@section('title','Alumnos')

@section('ruta')
    <label class="label label-success"> <a href="#">STA</a> / Jefes de carrera</label> 
@endsection

@section('contenido')
    <form action="{{ route('jefes.generacion') }}" method="post">
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
                <a id="btnAnalisis" class="btn btn-secondary" title="Analisis grupal" onclick="asignaRuta()"><i class="fas fa-chart-pie"></i></a>
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
                        <td>{{ $gru->status }}</td>
                        <td><a href="{{ route('jefes.diagnostico',$gru->control) }}" class="btn btn-primary"><i class="fas fa-search-plus"></i></a></td>
                    </tr>                
                @endforeach
            @endif
        </tbody>
    </table>      
@endsection

@section('js')
    <script>
        function asignaRuta()
        {
            gen=$('#generacion option:selected').val();
            car=$('#carrera option:selected').val();

            if(gen=='' || car=='')
            {
                swal({
                        title: "Warning",
                        text: "Debes seleccionar una generación y una carrera",
                        icon: "warning",
                        button: "Cerrar",
                    });
            }
            else
            {
                r="{{url('/sta/jefes')}}/analisis/"+gen+"/"+car;               
                $('#btnAnalisis').attr('action', r);
            }
            
           
        }

        //Codigo para adornar las tablas con datatables
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

	            lengthMenu: [
			        [ 5, 10, 25, 50, -1 ],
			        [ '5 reg', '10 reg', '25 reg', '50 reg', 'Ver todo' ]
			    ],
	            buttons: [
	            	{extend: 'collection', text: 'Exportar',
	            		buttons: [ 
	            			{ extend: 'copyHtml5', text: 'Copiar' },
	            			'csvHtml5', 
	            			'excelHtml5', 
	            			'pdfHtml5',
	            			{ extend: 'print', text: 'Imprimir' }, 
	            		]},                 
	                { extend: 'colvis', text: 'Columnas visibles' },                       
	                { extend:'pageLength',text:'Ver registros'},               
	            ],
	            "language": {
                   "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
               }  
	        });
	    });	    
    </script>
@endsection