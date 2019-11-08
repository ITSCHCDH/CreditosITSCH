@extends('template.molde')

@section('title','Actividades')

@section('links')
    <link rel="stylesheet" href="{{ asset('css/checkbox.css')}}">
    <script type="text/javascript" src="{{ asset('plugins/jsCookie/js.cookie.js') }}"></script>
@endsection

@section('ruta')
    <label class="label label-success"> Actividades</label>
@endsection

@section('contenido')

    @if (Auth::User()->hasAnyPermission(['VIP','CREAR_ACTIVIDAD','VIP_ACTIVIDAD']))
        <div class="toltip pull-left">
            <a href="{{route('actividades.create')}}" class="btn btn-primary white-icon">
                <img src="{{ asset('images/organize.png') }}" alt="" }}">
            </a>
            <span class="toltiptext">Nueva actividad</span>
        </div>
    @endif
    
    <!-- Boton de busqueda en la pagina -->
    {!! Form::open(['route'=>'actividades.index','method'=>'GET','class'=>'form-inline my-2 my-lg-0 mr-lg-2 navbar-form pull-right','id' => 'actividades-submit']) !!}
        @if ($vigente == "true")
            <input type="checkbox" id="checkbox5" class="css-checkbox" checked="checked" name="vigentes"/>
        @else
            <input type="checkbox" id="checkbox5" class="css-checkbox" name="vigentes"/>
        @endif
        <label for="checkbox5" name="checkbox2_lbl" class="css-label lite-blue-check">Mostrar solo actividades vigentes</label>
        <div class="input-group">
            {!! Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Buscar.....','aria-describedby'=>'search']) !!}
            <div class="input-group-btn">
                <button type="submit" class="btn btn-primary"> Buscar
                      <span class="badge  label label-primary glyphicon glyphicon-search">
                      </span>
                </button>
            </div>
        </div>
    {!! Form::close() !!}
    <!--Nota: Se tiene que agregar el (scope) que es una funcion que se agrega en el modelo y es la encargada de hacer la consulta  -->
    <!--Fin del boton de busqueda  -->

    <section id="main">
        <aside id="horizontal-scroll">
            <table class="table table-striped">
                <thead>
                    <th>ID</th>
                    <th>Actividad</th>
                    <th>Porcentaje crédito</th>
                    <th>Crédito</th>
                    <th>Alumnos</th>
                    <th>No Alumnos</th>
                    <th>Administrador</th>
                    <th>Vigente</th>
                    @if (Auth::User()->hasAnyPermission(['VIP','VIP_ACTIVIDAD','MODIFICAR_ACTIVIDAD','CREAR_ACTIVIDAD','ELIMINAR_ACTIVIDAD','AGREGAR_RESPONSABLES','VIP_SOLO_LECTURA']))
                        <th>Acción</th>
                    @endif
                </thead>
                <tbody>
                @foreach($actividad as $act)
                    <tr>
                        <td>{{$act->id}}</td>
                        <td>{{$act->actividad_nombre}}</td>
                        <td>{{$act->por_cred_actividad}}</td>
                        <td>{{$act->credito_nombre}}</td>
                        <td>
                            @if ($act->alumnos == "true")
                                {{ "SI" }}
                            @else
                                {{ "NO" }}
                            @endif
                        </td>
                        <td>{{ $act->no_alumnos }}</td>
                        <td>
                            {{ $act->usuario_nombre }}
                        </td>
                        <td>
                            @if($act->vigente == "true")
                                {{ "SI" }}
                            @else
                                {{ "NO" }}
                            @endif
                        </td>
                        @if (Auth::User()->hasAnyPermission(['VIP','VIP_ACTIVIDAD','MODIFICAR_ACTIVIDAD','CREAR_ACTIVIDAD','ELIMINAR_ACTIVIDAD','AGREGAR_RESPONSABLES','VIP_SOLO_LECTURA']))
                            <td>
                                @if ($act->vigente == 'true' && Auth::User()->hasAnyPermission(['VIP','CREAR_ACTIVIDAD','VIP_ACTIVIDAD']))
                                    <div class="toltip">
                                        <a href="#" class="btn btn-info" onclick="redireccionar({{ $act->id }});">
                                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                        </a>
                                        <span class="toltiptext">Agregar participantes (Alumnos) a la actividad</span>
                                    </div>
                                @endif
                                @if (Auth::User()->hasAnyPermission(['VIP','VIP_EVIDENCIA','VERIFICAR_EVIDENCIA','VIP_ACTIVIDAD']))
                                    <div class="toltip">
                                        <a href="{{ route('verifica_evidencia.index',['validadas=on','busqueda='.$act->actividad_nombre,"actividades_link=true"]) }}" class="btn btn-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></a>
                                        <span class="toltiptext">Verificar evidencias de esta actividad</span>
                                    </div>
                                @endif
                                @if (Auth::User()->hasAnyPermission(['VIP','MODIFICAR_ACTIVIDAD','VIP_ACTIVIDAD']))
                                    <div class="toltip">
                                        @if (Auth::User()->hasAnyPermission(['VIP','VIP_ACTIVIDAD']))
                                            <a href="{{ route('actividades.edit',[$act->id]) }}" class="btn btn-warning"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span></a>
                                        @elseif($act->id_user==Auth::User()->id)
                                            <a href="{{ route('actividades.edit',[$act->id]) }}" class="btn btn-warning"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span></a>
                                        @endif
                                        <span class="toltiptext">Editar actividad</span>
                                    </div>
                                @endif
                                @if (Auth::User()->hasAnyPermission(['VIP','ELIMINAR_ACTIVIDAD','VIP_ACTIVIDAD']))
                                    <div class="toltip">
                                        @if (Auth::User()->hasAnyPermission(['VIP','VIP_ACTIVIDAD']))
                                        <a href="{{ route('admin.actividades.destroy',$act->id) }}" onclick="return confirm('¿Estas seguro que deseas eliminarlo?')" class="btn btn-danger"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></a>
                                        @elseif($act->id_user==Auth::User()->id)
                                        <a href="{{ route('admin.actividades.destroy',$act->id) }}" onclick="return confirm('¿Estas seguro que deseas eliminarlo?')" class="btn btn-danger"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></a>
                                        @endif
                                        <span class="toltiptext">Eliminar actividad</span>
                                    </div>
                                @endif
                                @if (Auth::User()->hasAnyPermission(['VIP','VER_RESPONSABLES','VIP_ACTIVIDAD','VIP_SOLO_LECTURA']))
                                    <div class="toltip">
                                        @if (Auth::User()->hasAnyPermission(['VIP','VIP_ACTIVIDAD','VIP_SOLO_LECTURA']))
                                            <a href="{{ route('responsables',$act->id) }}" class="btn btn-primary">
                                                <span class="glyphicon glyphicon-user" aria-hidden="true"></span></a>
                                        @elseif($act->id_user==Auth::User()->id)
                                            <a href="{{ route('responsables',$act->id) }}" class="btn btn-primary">
                                                <span class="glyphicon glyphicon-user" aria-hidden="true"></span></a>
                                        @endif
                                        <span class="toltiptext">Asignar responsables</span>
                                    </div>
                                @endif  
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </aside>
    </section>  

    {!! $actividad->appends(['nombre'=> $nombre])->render() !!}
    <div style="margin-bottom: 50px;"></div>
    @section('js')
        <script>
            function redireccionar(actividad_id){
                Cookies.set('participantes_actividad',actividad_id,{ expires: 1});
                window.location.href = "{{ route('participantes.index',['actividades_link=true']) }}";
            }
            $('#checkbox5').click(function(event){
                var value = $(this).is(':checked');
                $('#actividades-submit').submit();
            });
        </script>
    @endsection
@endsection