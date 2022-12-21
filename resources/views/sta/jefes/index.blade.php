@extends('template.molde')

@section('title','Alumnos')

@section('ruta')
    <label class="label label-success">STA/Jefes de carrera</label>
@endsection

@section('contenido')
    <div class="row">
        <div class="col-sm-3" >
            <h4>Selecciona una generación</h4>        
            <select class="form-control " name="generacion" id="generacion">
                <option selected value="">Selecciona una opción</option>
                @foreach ($generaciones as $gen )
                    <option value="{{ $gen->Alu_AnioIngreso }}">{{ $gen->Alu_AnioIngreso }}</option>
                @endforeach              
            </select>             
        </div>
        <div class="col-sm-3" >
            <h4>Selecciona una carrera</h4>         
            <select class="form-control " name="carrera" id="carrera">
                <option selected value="">Selecciona una opción</option>
                @foreach ($carreras as $car )
                    <option value="{{ $car->car_Clave }}">{{ $car->car_Nombre }}</option>
                @endforeach              
            </select>               
        </div>
        <div class="col-sm-3" >

        </div>
    </div>

      
@endsection