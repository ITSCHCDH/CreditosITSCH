@extends('template.molde')

@section('title','Actividades')

@section('ruta')
	<a href="" class="label label-info">STA</a>
	/
	<label class="label label-success">Autorisar uso de datos</label>
@endsection

@section('contenido')
    <form action="{{ route('alumnos.sta.autorizar.guargar', $alu->no_control) }}" method="get">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card">
                    <div class="container cuerpo">
                        <div class="row">
                            <fieldset class="col-md-12">
                                {{--cabecera--}}
                                <div>
                                    <div class="panel-heading">
                                        <h3 class="head text-center">AUTORIZACIÓN</h3>
                                        <div class="progress" style="height: 18px;">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated"
                                                role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"
                                                style="width: 100%">100%</div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <textarea style="color:#000000" class="form-control" id="exampleFormControlTextarea1"
                                    rows="3"
                                    readonly>AUTORIZÓ AL DEPARTAMENTO DE TUTORÍAS Y SERVICIOS PSICOPEDAGÓGICOS HACER USO DE ESTA INFORMACIÓN, EN CASO DE SER REQUERIDA, CON EL COMPROMISO DE QUE ESTA INFORMACIÓN ESTARÁ BAJO LA CONFIDENCIALIDAD DE LA MISMA ÁREA.
                                </textarea>
                                <hr>
                                <div id="cr">
                                    <div class="panel-footer center">
                                        <a href="{{  url()->previous() }}" type="button" class="previous btn btn-default">Anterior</a>
                                        <input type="submit" value="Aceptar y firmar" class="btn btn-primary">
                                    </div>
                                </div>
                                <br> <br>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
    </form>
@endsection