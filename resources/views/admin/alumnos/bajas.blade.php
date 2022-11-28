@extends('template.molde')

@section('title','Alumnos|Altas')

@section('ruta')
    <a href="{{route('alumnos.index')}}"> Alumnos </a>
    /
    <label class="label label-success"> Bajas</label>
@endsection

@section('contenido')
    <form id="formBuscarAlumno" method="get" action="{{ route('alumnos.buscar') }}">
        <div class="row">             
            <div class="col-sm-2">
                <div class="form-outline mb-4">
                    <input type="text" id="control" class="form-control"  name="control" required/>
                    <label class="form-label" for="control" id="lControl">Numero de control</label>        
                </div>            
            </div>
            <div class="col-sm-1">
                <button type="submit" class="btn btn-success" >Buscar</button>
            </div>
            <div class="col-sm-9"></div>           
        </div>
    </form>
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Control</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Carrera</th>
                        <th scope="col">Status</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($alumno as $al)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $al->no_control }}</td>
                            <td>{{ $al->nombre }}</td>
                            <td>{{ $al->carrera }}</td>
                            <td>{{ $al->status }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" title="Editar usuario" data-mdb-toggle="modal" data-mdb-target="#modalEditUser" onclick="llenar('{{ $al->no_control }}','{{ $al->nombre }}')"><i class="fas fa-user-edit"></i></button>
                            </td>
                        </tr>
                    @endforeach                                                        
                </tbody>
              </table>
        </div>
        <div class="col-sm-2"></div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalEditUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('alumnos.editarStatus') }}" method="get">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar status del alumno</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                    </div>            
                    <div class="modal-body">
                        <h6>Nombre:</h6>
                        <h6 id="nombre"></h6>
                        <input type="hidden" name="cont" id="cont" readonly>
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="">Selecciona una opción</option>
                            <option value="pendiente"@if($alumno!=null) @if($alumno[0]->status=='pendiente') selected='selected' @endif @endif>Pendiente</option>
                            <option value="liberado" @if($alumno!=null) @if($alumno[0]->status=='liberado') selected='selected' @endif @endif>Liberado</option>
                            <option value="baja" @if($alumno!=null) @if($alumno[0]->status=='baja') selected='selected' @endif  @endif>Baja</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    

    <div style="margin-bottom: 100px;"></div>
@endsection

@section('js')
    <script>
        function llenar(c,n)
        {
            $('#nombre').text(n);
            $('#cont').val(c);
        }
    </script>
@endsection