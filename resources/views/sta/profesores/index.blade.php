@extends('template.molde')

@section('title','Alumnos')

@section('ruta')
    <label class="label label-success"> <a href="#">STA</a> / Profesores</label> 
@endsection

@section('contenido')
    <div class="row">
        <div class="col-sm-3">
            <label for="carrera">Carrera</label>
            <div class="input-group mb-3">               
                <select name="carrera" id="carrera" class="form-control">
                    <option value="">Selecciona una carrera</option>
                    @foreach ($carreras as $car)            
                        <option value="{{ $car->car_Clave }}">{{ $car->car_Nombre }}</option>
                    @endforeach
                </select>
                <a href="#" type="button" class="btn btn-info" id="filtrar"><i class="fas fa-filter"></i></a>
            </div>
        </div>
        <div class="col-sm-3">
            <label for="profesores" hidden id="labProfesores">Profesores</label>
            <div class="input-group mb-3">               
                <select name="profesores" id="profesores" class="form-control" hidden>
                    <option value="">Selecciona un profesor</option>
                    
                </select>
                <a href="#" type="button" class="btn btn-info" id="buscar" hidden><i class="fas fa-filter"></i></a>
            </div>
        </div>
        </div>
        <div class="col-sm-3"></div>
        <div class="col-sm-3"></div>
    </div>

    @section('js')
        <script type="text/javascript">
            $.ajaxSetup( {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
			} );
            $("#filtrar").click(function(e){
                          
                e.preventDefault();
                carrera = $('#carrera').val();
                $.ajax({
                    type: "post",
                    dataType: "json",
                    url:"{{ url('admin/sta/profesores/find') }}",
                    data:{
                        carrera:carrera
                    },
                    success: function(response){
                        console.log(profesores);
                        location.href = "{{ route('profesores.index') }}";
                    },
                    error: function(e){
                        console.log('Error al buscar los profesores de esta carrera',e);
                    }
                });
            })
        </script>
    @endsection
    
@endsection