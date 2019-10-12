@extends('template.molde')

@section('title','Actividades')

@section('ruta')
    <label class="label label-success"> Actividades</label>
@endsection

@section('contenido')

    @if (Auth::User()->hasAnyPermission(['VIP','CREAR_ACTIVIDAD','VIP_ACTIVIDAD']))
        <a href="{{route('actividades.create')}}" class="btn btn-primary">Registrar nueva actividad</a>
    @endif
    

    <!--BUSCADOR DE ARTICULOS  -->
    <!-- Boton de busqueda en la pagina -->
    {!! Form::open(['route'=>'actividades.index','method'=>'GET','class'=>'form-inline my-2 my-lg-0 mr-lg-2 navbar-form pull-right']) !!}

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
                    @if (Auth::User()->hasAnyPermission(['VIP','VIP_ACTIVIDAD','MODIFICAR_ACTIVIDAD','ELIMINAR_ACTIVIDAD','AGREGAR_RESPONSABLES','VIP_SOLO_LECTURA']))
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
                            @if ($act->alumnos=="true")
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
                            @if($act->vigente=="true")
                                {{ "SI" }}
                            @else
                                {{ "NO" }}
                            @endif
                        </td>
                        @if (Auth::User()->hasAnyPermission(['VIP','VIP_ACTIVIDAD','MODIFICAR_ACTIVIDAD','ELIMINAR_ACTIVIDAD','AGREGAR_RESPONSABLES','VIP_SOLO_LECTURA']))
                            <td>
                                @if (Auth::User()->hasAnyPermission(['VIP','MODIFICAR_ACTIVIDAD','VIP_ACTIVIDAD']))
                                    @if (Auth::User()->hasAnyPermission(['VIP','VIP_ACTIVIDAD']))
                                        <a href="{{ route('actividades.edit',[$act->id]) }}" class="btn btn-warning"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span></a>
                                    @elseif($act->id_user==Auth::User()->id)
                                        <a href="{{ route('actividades.edit',[$act->id]) }}" class="btn btn-warning"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span></a>
                                    @endif
                                @endif
                                @if (Auth::User()->hasAnyPermission(['VIP','ELIMINAR_ACTIVIDAD','VIP_ACTIVIDAD']))
                                    @if (Auth::User()->hasAnyPermission(['VIP','VIP_ACTIVIDAD']))
                                        <a href="{{ route('admin.actividades.destroy',$act->id) }}" onclick="return confirm('¿Estas seguro que deseas eliminarlo?')" class="btn btn-danger"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></a>
                                    @elseif($act->id_user==Auth::User()->id)
                                        <a href="{{ route('admin.actividades.destroy',$act->id) }}" onclick="return confirm('¿Estas seguro que deseas eliminarlo?')" class="btn btn-danger"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></a>
                                    @endif
                                @endif
                                @if (Auth::User()->hasAnyPermission(['VIP','VER_RESPONSABLES','VIP_ACTIVIDAD','VIP_SOLO_LECTURA']))
                                    @if (Auth::User()->hasAnyPermission(['VIP','VIP_ACTIVIDAD','VIP_SOLO_LECTURA']))
                                        <a href="{{ route('responsables',$act->id) }}" class="btn btn-primary">
                                            <span class="glyphicon glyphicon-user" aria-hidden="true"></span
                                        ></a>
                                    @elseif($act->id_user==Auth::User()->id)
                                        <a href="{{ route('responsables',$act->id) }}" class="btn btn-primary">
                                            <span class="glyphicon glyphicon-user" aria-hidden="true"></span
                                        ></a>
                                    @endif
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

@endsection