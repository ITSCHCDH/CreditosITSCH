@extends('template.molde')

@section('title','Tutorias')

@section('ruta')
    <label class="label label-success"> <a href="#">STA</a> / <a href="{{ route('tutores.index') }}"> Tutor </a> /Grupo: {{ $grupo[0]->gpo_Nombre }} </label> 
@endsection

@section('contenido')
    <div class="row">
        <div class="col-sm-3"><h5>TUTOR: {{ $grupo[0]->nomTutor }}</h5></div>
        <div class="col-sm-4"><h5>CARRERA: {{ $grupo[0]->car_Nombre }}</h5></div>
        <div class="col-sm-3"></div>
        <div class="col-sm-2"></div>
    </div>
    <hr>
    <div class="alert alert-danger" role="alert">
        Este grupo no se a guardado en el sistema, por lo tanto no se puede realizar ninguna accion.
    </div>
    <div class="row">
        <div class="col-sm-7"></div>
        <div class="col-sm-4">
            {{-- Agregamos un select con todos los alumnos --}}
            <div class="input-group mb-3">
                <div class="input-group-prepend" style="max-width: 200px">  
                    <input type="text" id="searchInput" class="form-control" placeholder="Buscar">
                </div>              
                <select name="alumno" id="alumno" class="form-control mr-2">
                    <option value="">Selecciona un alumno</option>
                    @foreach($alumnos as $alu)
                        <option value="{{ $alu->alu_NumControl }}">{{ $alu->alu_NumControl }} - {{ $alu->alu_Nombre }} {{ $alu->alu_ApePaterno }} {{ $alu->alu_ApeMaterno }}</option>
                    @endforeach
                </select>          
            </div>
        </div>
        <div class="col-sm-1">
            <a onclick="agregar()" class="btn btn-primary"><i class="fas fa-plus"></i></a>
        </div>
    </div>
    <table class="table" id="tabGrupoTut">
        <thead>
            <th>Número</th>
            <th>No. Control</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </thead>
        <tbody>
           
        </tbody>
    </table>
@endsection

@section('js')
<script>
    //Agregamos a los alumnos del select a la tabla de grupo de tutorias
    function agregar()
    {
        //Verificamos que se seleccione algo en el select si no marcamos un error
        if($('#alumno').val() == '')
        {
            swal('Error','Selecciona un alumno','error');
            return false;
        }
        else
        {
            //Verificamos que el alumno no se haya registrado en la tabla
            var numControl = $('#alumno').val();
            var existe = false;
            $('#tabGrupoTut tbody tr').each(function(){
                var num = $(this).find('td').eq(1).text();
                if(num == numControl)
                {
                    existe = true;
                }
            });
            if(existe)
            {
                swal('Error','El alumno ya se encuentra registrado en el grupo de tutorias','error');
                return false;
            }
            else
            {
                //Si no existe el alumno lo agregamos a la tabla            
                var alumno = $('#alumno').val();
                var nombre = $('#alumno option:selected').text();
                var num = $('#tabGrupoTut tr').length;
                var fila = '<tr id="fila'+num+'"><td>'+num+'</td><td>'+alumno+'</td><td>'+nombre+'</td><td><a href="" class="btn btn-danger" onclick="eliminar('+num+')"><i class="fas fa-trash-alt"></i></a></td></tr>';
                $('#tabGrupoTut tbody').append(fila);
                //Guardamos el registro en la base de datos
                $.ajax({
                    url: "{{ route('tutores.storeGrupo') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        gpo: {{ $grupo[0]->gpo_Id }},
                        alu: alumnoCom
                    },
                    success: function(response){
                        if(response == 'ok')
                        {
                            swal('Exito','Alumno agregado al grupo de tutorias','success');
                        }
                        else
                        {
                            swal('Error','No se pudo agregar al alumno al grupo de tutorias','error');
                        }
                    }
                });
                return false;
            }           
        }
        
    }
    //Eliminamos un alumno de la tabla de grupo de tutorias sin actualizar la pagina
    function eliminar(num, event)
    {
        event.preventDefault();
        $('#fila'+num).remove();
        var num = 1;
        $('#tabGrupoTut tbody tr').each(function(){
            $(this).find('td').eq(0).text(num);
            num++;
        });
        return false;
    }
    
    //Codigo para buscar en el select de alumno
    $(document).ready(function() {
        $('#searchInput').on('keyup', function() {
            var searchText = $(this).val().toLowerCase();        
            if (searchText === '') {
                $('#alumno option').prop('selected', false);
            } else {
                $('#alumno option').filter(function() {
                    var optionText = $(this).text().toLowerCase();
                    var regex = new RegExp(searchText, 'i');
                    return regex.test(optionText);
                }).prop('selected', true);
            }
        });
    });
    //Codigo para adornar las tablas con datatables
    $(document).ready(function() {
        $('#tabGrupoTut').DataTable({
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
                        'excelHtml5',
                        'pdfHtml5',
                        { extend: 'print', text: 'Imprimir' },
                    ]},
                { extend: 'colvis', text: 'Columnas visibles' },
                { extend:'pageLength',text:'Ver registros'},
            ],
            language: {
                url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },            
        });
    });
</script>
@endsection