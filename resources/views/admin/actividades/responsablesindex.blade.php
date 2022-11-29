@extends('template.molde')

@section('title','Responsables')
@section('links')
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/checkboxcss/checkbox.css') }}">
@endsection
@section('ruta')
    @if ($actividad!=null)
        <a href="{{route('actividades.index')}}">Actividades</a>
        /
        <a href="{{route('responsables',$actividad->id)}}">Responsables</a>
        /
        <label class="label label-success">Asignar Responsables</label>
    @endif
    
@endsection

@section('contenido')
    @if ($actividad!=null)
        <input type="hidden" name="actividad_id" value="{{ $actividad->id }}" id="actividad_id">
    @endif
    <div class="table-responsive"> 
        <table class="table" id="tabla-responsables">
            <thead>
                <th>Nombre</th>
                <th>Area</th>
                <th>Activo</th>
                <th>Asignar</th>
            </thead>
            <tbody>
                @if ($responsables!=null && $actividad!=null)
                    <input type="hidden" name="actividad_id" value="{{ $actividad->id }}" id="actividad_id">
                    @foreach($responsables as $res)
                        <tr>
                            <td>
                                {{$res->usuario_nombre}}
                            </td>
                            <td>
                                {{$res->area}}
                            </td>
                            <td>
                                @if ($res->active=="true")
                                    {{ "SI" }}
                                @else
                                    {{ "NO" }}
                                @endif
                            </td>
                            <td>
                                @if($actividad->vigente=="true")
                                    <label>
                                    @if($res->actividad_nombre==null)                                    
                                        @if ($res->active=="false")
                                            <label class="control control--checkbox">
                                                <input type="checkbox" name="user_id[]" value="{{ $res->usuario_id }}" class="responsable-agregado" id="c{{ $res->usuario_id }}" disabled>
                                                <div class="control__indicator"></div>
                                            </label>
                                        @else
                                            <label class="control control--checkbox">
                                                <input type="checkbox" name="user_id[]" value="{{ $res->usuario_id }}" class="responsable-agregado" id="c{{ $res->usuario_id }}">
                                                <div class="control__indicator"></div>
                                            </label>
                                        @endif
                                    @else
                                        @if($res->participantes!=null || $res->evidencias!=null || $res->validado=="true")
                                            <label class="control control--checkbox">
                                                <input type="checkbox" name="user_id[]" value="{{ $res->usuario_id }}" checked class="responsable-agregado" id="c{{ $res->usuario_id }}" disabled>
                                                <div class="control__indicator"></div>
                                            </label>
                                        @else
                                            <label class="control control--checkbox">
                                                <input type="checkbox" name="user_id[]" value="{{ $res->usuario_id }}" checked class="responsable-agregado" id="c{{ $res->usuario_id }}">
                                                <div class="control__indicator"></div>
                                            </label>
                                        @endif
                                    
                                    @endif
                                    </label>
                            @else
                                {{ "Ninguna" }}
                            @endif

                            </td>
                        </tr>
                    @endforeach

                @else
                    <tr>
                        <td colspan="3">No se encontraron resultados</td>
                    </tr>
                @endif            
            </tbody>
        </table>
    </div>
   
    @if ($responsables!=null && $actividad!=null)
        <input type="submit" value="Agregar" id="submit-reponsables" class="btn btn-primary">
    @endif
    
    
    @section('js')
        @if ($responsables!=null && $actividad!=null)
            <script type="text/javascript">
                $.ajaxSetup( {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                } );
                var responsables_array = [];
                function inicializarArreglo(){
                    var lista_ya_agregados = document.getElementsByClassName('responsable-agregado');
                    for (var i = 0; i < lista_ya_agregados.length; i++) {
                        if(lista_ya_agregados[i].checked){
                            responsables_array.push(lista_ya_agregados[i].value);
                        }  
                    }
                }
                function agregarResponsablesArreglo(){
                    $(document).on('click','.responsable-agregado',function(){
                        var checkbox = document.getElementById('c'+$(this).attr('value'));
                        if(checkbox.checked){
                            responsables_array.push(checkbox.value);
                        }else{
                            for (var i = 0; i < responsables_array.length; i++) {
                                if(responsables_array[i]==$(this).attr('value')){
                                    responsables_array.splice(i,1);
                                }
                            }
                        }
                    });
                }
                function asignarResponsables(){
                    $(document).on('click','#submit-reponsables', function(event){
                        event.preventDefault();
                        var actividad_id = $('#actividad_id').attr('value');
                        $.ajax({
                            type: "post",
                            dataType: "json",
                            url: "{{ route('actividad_evidencias.asignar_responsables') }}",
                            data:{
                                responsables_id:responsables_array,
                                actividad_id:actividad_id
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response){
                                console.log(response);
                                location.href = "{{ route('responsables',$actividad->id) }}"
                            }, error:function(){
                                console.log("Error al agregar responsables");
                            }
                        });
                    });
                }                
              

                //Codigo para adornar las tablas con datatables
                $(document).ready(function() {
                    inicializarArreglo();
                    $('#tabla-responsables').DataTable({

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
                    agregarResponsablesArreglo();
                    asignarResponsables();
                });
            </script>
        @endif
        
    @endsection
@endsection