@extends('template.molde')

@section('title','Crear Actividad')

@section('ruta')
    <a href="{{route('actividades.index')}}"> Actividades </a>
    /
    <label class="label label-success"> Altas</label>
@endsection

@section('contenido')

    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <form action="{{ route('actividades.store') }}" method="POST">
                @csrf

                <div class="form-outline mb-4">
                    <input type="text" id="nombre" class="form-control form-control-lg"  name="nombre" required/>
                    <label class="form-label" for="nombre" id="actividad">Nombre de la actividad</label>
                </div>

                <div class="form-outline mb-4">
                    <input type="number" min="0" max="100" id="por_cred_actividad" class="form-control form-control-lg"  name="por_cred_actividad" required/>
                    <label class="form-label" for="por_cred_actividad" id="lPorcentage">Porcentaje de liberación Ej. 20</label>
                </div>

                <div class="mb-4">
                    <Label class="form-label" >Credito al que pertenece la actividad</Label>
                    <select id="select-category" name="id_actividad" class="form-control form-control-lg" required>
                        <option value="">Selecciona un tipo de credito</option>
                        @foreach($creditos as $cred)
                            <option value="{{ $cred->id }}">{{ $cred->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                @if (Auth::User()->hasAnyPermission(['VIP','CREAR_ACTIVIDAD_ALUMNOS','VIP_ACTIVIDAD']))

                    <div class="mb-4">
                        <Label class="form-label" >Alumnos Responsables</Label>
                        <select id="alumnos" name="alumnos" class="form-control form-control-lg" required>
                            <option value="">¿Actividad dedicada para alumnos responsables?, Si no estas seguro selecciona NO</option>
                            <option value="false">NO</option>
                            <option value="true">SI</option>
                        </select>
                    </div>
                @endif

                <div class="form-outline mb-4">
                    <input type="date" class="form-control form-control-lg" name="fecCierre" id="fecCierre" required>
                    <label class="form-label">Fecha de cierre</label>
                </div>

                <hr>

                <input type="submit" value="Registrar actividad" class="btn btn-primary">
            </form>

        </div>
        <div class="col-sm-3"></div>
    </div>



</form>

@endsection
