@extends('template.molde')

@section('title','Alumnos')

@section('ruta')
    <label class="label label-success"> Alumnos</label>
@endsection

@section('contenido')
    <div class="row">
        <div class="col-sm-4">
            <div style="text-align: left !important;">
                {!! Form::open(['route'=>'alumnos.index','method'=>'GET','class'=>'form-inline navbar-form']) !!}
                    <div class="input-group toltip">
                        {!! Form::text('valor',null,['class'=>'form-control form-control-sm','placeholder'=>'Buscar.....','aria-describedby'=>'search']) !!}
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-primary">
                                <span class="badge  label label-primary glyphicon glyphicon-search">
                                </span>
                            </button>
                        </div>  
                        <span class="toltiptext">Buscar</span>                 
                    </div>
                {!! Form::close() !!}
                <!--Fin del boton de busqueda  -->   
            </div>                     
        </div>
        <div class="col-sm-4"></div>
        <div class="col-sm-4">
            <div style="text-align: right;"> 
                <div class="toltip">
                    @if (Auth::User()->hasAnyPermission(['VIP','CREAR_ALUMNOS']))
                        <a href="{{route('alumnos.create')}}" class="btn btn-info btn-sm" >
                            <span class="glyphicon glyphicon-plus"></span>
                            <span class="glyphicon glyphicon-user"></span>  
                        </a>
                    @endif
                    <span class="toltiptext">Agregar nuevo alumno</span>     
                </div>                      
            </div>
        </div>
    </div>
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
                                    <a href="{{ route('alumnos.edit',[$alu->id]) }}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span></a>
                                    <span class="toltiptext">Modificar alumno</span>     
                                </div>      
                            @endif
                            @if (Auth::User()->hasAnyPermission(['VIP','ELIMINAR_ALUMNOS']))
                                <div class="toltip">
                                    <a  class="btn btn-danger btn-sm" onclick="undo_alumno({{$alu->id}})" data-toggle="modal" data-target="#myModalMsg">
                                        <span class="glyphicon glyphicon-remove-circle" aria-hidden="true">                                            
                                        </span>
                                    </a>
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

    <!--Modal para mensajes del sistema-->    
    <div class="modal" id="myModalMsg">
        <div class="modal-dialog modal-sm">
        <div class="modal-content">
        
            <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title">Mensaje</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body" id="uno">
                ¿Estas seguro que deseas eliminar el alumno? 
                <input type="text" id="e_id" name="id"  readonly onFocus="this.blur()" style="border: none">

            </div>
            
            <!-- Modal footer -->
            <div class="modal-footer">
                <a  class="btn btn-danger" id="prueba">Aceptar</a>
                <button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button>
            </div>
            
        </div>
        </div>
    </div>

    <!--Script para pasasr el id del alumno a eliminar para que se use en el modal-->
    <script>
        function undo_alumno(n)
		{	            
			document.getElementById("e_id").value = n;	           					
            document.getElementById("prueba").href = "alumnos/"+n+"/destroy";
		}
    </script>
    

    <div style="text-align:center;">
        {{ $alumno->appends(['valor' => $valor])->render() }}
    </div>   
@endsection