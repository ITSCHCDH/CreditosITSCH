@extends('template.molde')

@section('title','Alumnos')

@section('ruta')
    <label class="label label-success"> Alumnos</label>
@endsection

@section('contenido')
    <div style="text-align: right;"> 
        <div class="toltip">
            @if (Auth::User()->hasAnyPermission(['VIP','CREAR_ALUMNOS']))
                <a href="{{route('alumnos.create')}}" class="btn btn-info btn-lg" >
                    <span class="glyphicon glyphicon-plus"></span>
                    <span class="glyphicon glyphicon-user"></span>  
            </a>
            @endif
            <span class="toltiptext">Agregar nuevo alumno</span>     
        </div>                      
    </div>
    
    {!! Form::open(['route'=>'alumnos.index','method'=>'GET','class'=>'form-inline my-2 my-lg-0 mr-lg-2 navbar-form pull-right']) !!}
        <div class="input-group">
            {!! Form::text('valor',null,['class'=>'form-control','placeholder'=>'Buscar.....','aria-describedby'=>'search']) !!}
            <div class="input-group-btn">
                <button type="submit" class="btn btn-primary"> Buscar
                      <span class="badge  label label-primary glyphicon glyphicon-search">
                      </span>
                </button>
            </div>
            <br>
        </div>

    {!! Form::close() !!}

    <!--Fin del boton de busqueda  -->
    <section id="main">
        <aside id="horizontal-scroll">
            <table class="table" id="tabla-alumnos">
                <thead class="thead-dark">
                <th>ID</th>
                <th>Numero de Control</th>
                <th>Nombre</th>
                <th>Carrera</th>
                <th>Estatus</th>
                @if (Auth::User()->hasAnyPermission(['VIP','ELIMINAR_ALUMNOS','MODIFICAR_ALUMNOS']))
                    <th>Acción</th>
                @endif
                </thead>
                <tbody>
                @foreach($alumno as $alu)
                    <tr>
                        <td>{{$alu->id}}</td>
                        <td>{{$alu->no_control}}</td>
                        <td>{{$alu->nombre}}</td>
                        <td>{{$alu->carrera}}</td>
                        <td>
                            @if($alu->status == "Pendiente" || $alu->status == "pendiente")
                                <span class="label label-danger">Pendiente</span>
                            @else
                                <span class="label label-primary">Liberado</span>
                            @endif
                        </td>
                        <td>
                            @if (Auth::User()->hasAnyPermission(['VIP','MODIFICAR_ALUMNOS']))
                                <div class="toltip">
                                    <a href="{{ route('alumnos.edit',[$alu->id]) }}" class="btn btn-warning"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span></a>
                                    <span class="toltiptext">Modificar alumno</span>     
                                </div>      
                            @endif
                            @if (Auth::User()->hasAnyPermission(['VIP','ELIMINAR_ALUMNOS']))
                                <div class="toltip">
                                    <a href="{{ route('admin.alumnos.destroy',$alu->id) }}" onclick="return confirm('¿Estas seguro que deseas eliminarlo?')" class="btn btn-danger"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></a>
                                    <span class="toltiptext">Eliminar alumno</span>     
                                </div>    
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </aside>
    </section>
    {{ $alumno->appends(['valor' => $valor])->render() }}
@endsection