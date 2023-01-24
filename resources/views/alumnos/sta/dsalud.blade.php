@extends('template.molde')

@section('title','Actividades')

@section('ruta')
	<a href="" class="label label-info">STA</a>
	/
	<label class="label label-success">Datos Salud</label>
@endsection

@section('contenido')
    <form action="{{ route('alumnos.sta.updtDatSalud', $alu->no_control) }}" method="get">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card">
                    <div class="container cuerpo">
                        <div class="row fch">
                            <fieldset class="col-md-12">
                                {{--cabecera--}}
                                <br>
                                <div>
                                    <div class="panel-heading">
                                        <h3 class="head text-center">FICHA DE IDENTIFICACIÓN DEL
                                            ALUMNO TUTORADO</h3>
                                        <div class="head text-center">
                                            <h4>Datos de Salud </h4>
                                        </div>
                                        <div class="progress" style="height: 18px">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated"
                                                role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"
                                                style="width: 40%">40%</div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div id="cr">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h5 class="accordion-toggle collapsed" data-toggle="collapse" href="#enfermedad"
                                                class="panel-title">
                                                <a class="accordion-toggle collapsed txtNegro" data-toggle="collapse"
                                                    href="#enfermedad">¿Padeces alguna
                                                    enfermedad?</a>
                                                <a> <i class="fa fa-angle-down">
                                                    </i></a>
                                            </h5>
                                        </div>
                                        <div id="enfermedad" class="panel-collapse collapse" data-parent="#cr">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-sm-2">
                                                        <label class="radio-inline">
                                                            <input required @if($clinicos->enfermedad!='No') checked
                                                            @endif type="radio" name="alu_enf" id="alu_enf1" value="Si"
                                                            onclick="$('#fm_otra').attr('value','').attr('readonly',
                                                            false);$('#checkbox1').attr('disabled',
                                                            false).attr('checked',false);
                                                            $('#checkbox2').attr('disabled',false).attr('checked',false);
                                                            $('#checkbox3').attr('disabled',false).attr('checked',false);
                                                            $('#checkbox4').attr('disabled',false).attr('checked',false);
                                                            $('#checkbox5').attr('disabled',false).attr('checked',false);
                                                            $('#checkbox6').attr('disabled',false).attr('checked',false);
                                                            $('#checkbox7').attr('disabled',false).attr('checked',false);
                                                            $('#checkbox8').attr('disabled',false).attr('checked',false);"
                                                            >
                                                            SI
                                                        </label>
                                                        <label class="radio-inline">
                                                            <input required @if($clinicos->enfermedad=='No') checked
                                                            @endif type="radio" name="alu_enf" id="alu_enf2" value="No"
                                                            onclick="$('#fm_otra').attr('value','').attr('readonly',true);$('#checkbox1').attr('disabled',
                                                            true).attr('checked',false);
                                                            $('#checkbox2').attr('disabled',true).attr('checked',false);
                                                            $('#checkbox3').attr('disabled',true).attr('checked',false);
                                                            $('#checkbox4').attr('disabled',true).attr('checked',false);
                                                            $('#checkbox5').attr('disabled',true).attr('checked',false);
                                                            $('#checkbox6').attr('disabled',true).attr('checked',false);
                                                            $('#checkbox7').attr('disabled',true).attr('checked',false);
                                                            $('#checkbox8').attr('disabled',true).attr('checked',false);">
                                                            NO
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="row form-group bs-float-label">
                                                    <div class="col-sm-4">
                                                        <label class="checkbox-inline" for="checkbox1"> <input
                                                                @if($clinicos->enfermedad=='No') disabled @endif
                                                            @if($clinicos->diabetes=='Diabetes') checked @endif
                                                            type="checkbox" name="fm_diabetes" id="checkbox1"
                                                            value="Diabetes">
                                                            Diabetes </label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="checkbox-inline" for="checkbox2"> <input
                                                                @if($clinicos->enfermedad=='No') disabled @endif
                                                            @if($clinicos->hipertension=='Hipertensión') checked @endif
                                                            type="checkbox" name="fm_hipertencion" id="checkbox2"
                                                            value="Hipertensión"> Hipertensión
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="checkbox-inline" for="checkbox3"> <input
                                                                @if($clinicos->enfermedad=='No') disabled @endif
                                                            @if($clinicos->epilepsia=='Epilepsia') checked @endif
                                                            type="checkbox" name="fm_epilepsia" id="checkbox3"
                                                            value="Epilepsia"> Epilepsia </label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="checkbox-inline" for="checkbox4"> <input
                                                                @if($clinicos->enfermedad=='No') disabled @endif
                                                            @if($clinicos->anorexia=='Anorexia') checked @endif
                                                            type="checkbox" name="fm_anorexia" id="checkbox4"
                                                            value="Anorexia">
                                                            Anorexia </label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="checkbox-inline" for="checkbox5"> <input
                                                                @if($clinicos->enfermedad=='No') disabled @endif
                                                            @if($clinicos->bulimia=='Bulimia') checked @endif
                                                            type="checkbox" name="fm_bulimia" id="checkbox5"
                                                            value="Bulimia">
                                                            Bulimia </label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="checkbox-inline" for="checkbox6"> <input
                                                                @if($clinicos->enfermedad=='No') disabled @endif
                                                            @if($clinicos->sexual=='Enfermedad de Transmisión Sexual')
                                                            checked @endif
                                                            type="checkbox" name="fm_trans_sexual" id="checkbox6"
                                                            value="Enfermedad de Transmisión Sexual"> Enfermedad de
                                                            Transmisión Sexual </label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="checkbox-inline" for="checkbox7"> <input
                                                                @if($clinicos->enfermedad=='No') disabled @endif
                                                            @if($clinicos->depresion=='Depresión') checked @endif
                                                            type="checkbox" name="fm_depresion" id="checkbox7"
                                                            value="Depresión"> Depresión </label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="checkbox-inline" for="checkbox8"> <input
                                                                @if($clinicos->enfermedad=='No') disabled @endif
                                                            @if($clinicos->tristeza=='Tristeza Profunda') checked @endif
                                                            type="checkbox" name="fm_tristesa" id="checkbox8"
                                                            value="Tristeza Profunda">
                                                            Tristeza Profunda
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="checkbox-inline" for="checkbox9">
                                                            Alguna otra </label>
                                                        <input @if($clinicos->enfermedad=='No') readonly @endif
                                                        class="form-control float-input" type="text" name="fm_otra"
                                                        id="fm_otra" value="{{ $clinicos->otra_enf }}"
                                                        placeholder="Otra enfermedad">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h5 class="accordion-toggle collapsed" data-toggle="collapse"
                                                href="#discapacidad" class="panel-title">
                                                <a class="accordion-toggle collapsed txtNegro" data-toggle="collapse"
                                                    href="#discapacidad">¿Cuentas con alguna discapacidad física?</a>
                                                <a> <i class="fa fa-angle-down"></i></a>
                                            </h5>
                                        </div>
                                        <div id="discapacidad" class="panel-collapse collapse" data-parent="#cr">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-sm-9"><a>Indica cuales:</a>
                                                        <div class="row">
                                                            <div class="col-sm-2">
                                                                <label class="radio-inline">
                                                                    <input required @if($clinicos->cap_dif!='No') checked
                                                                    @endif type="radio" name="alu_disfi" id="alu_disfi1"
                                                                    value="Si"
                                                                    onclick="$('#fm_otra').attr('value','').attr('readonly',false);
                                                                    $('#inlineRadio1').attr('disabled',false).attr('checked',false);
                                                                    $('#inlineRadio2').attr('disabled',false).attr('checked',false);
                                                                    $('#inlineRadio3').attr('disabled',false).attr('checked',false);
                                                                    $('#discCheck4').attr('disabled',false).attr('checked',false);">
                                                                    SI
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input required @if($clinicos->cap_dif=='No') checked
                                                                    @endif type="radio" name="alu_disfi" id="alu_pdisfi"
                                                                    value="No"
                                                                    onclick="$('#fm_dis_otra').attr('value','').attr('readonly',true);
                                                                    $('#inlineRadio1').attr('disabled',true).attr('checked',false);
                                                                    $('#inlineRadio2').attr('disabled',true).attr('checked',false);
                                                                    $('#inlineRadio3').attr('disabled',true).attr('checked',false);
                                                                    $('#discCheck4').attr('disabled',true).attr('checked',false);">
                                                                    NO
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-2">
                                                                <label class="checkbox-inline" for="inlineRadio1">
                                                                    <input type="checkbox" name="fm_dis_vista"
                                                                        @if($clinicos->cap_dif=='No') disabled @endif
                                                                    @if($clinicos->vista=='Vista') checked @endif
                                                                    id="inlineRadio1" value="Vista"> Vista </label>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <label class="checkbox-inline" for="inlineRadio2">
                                                                    <input type="checkbox" name="fm_dis_oido"
                                                                        @if($clinicos->cap_dif=='No') disabled @endif
                                                                    @if($clinicos->oido=='Oído') checked @endif
                                                                    id="inlineRadio2" value="Oído"> Oído </label>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <label class="checkbox-inline" for="inlineRadio3">
                                                                    <input type="checkbox" name="fm_dis_lenguaje"
                                                                        @if($clinicos->cap_dif=='No') disabled @endif
                                                                    @if($clinicos->lenguaje=='Lenguaje') checked @endif
                                                                    id="inlineRadio3" value="Lenguaje"> Lenguaje
                                                                </label>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <label class="checkbox-inline" for="discCheck4"> <input
                                                                        @if($clinicos->cap_dif=='No') disabled @endif
                                                                    @if($clinicos->motora=='Motora') checked @endif
                                                                    type="checkbox" name="fm_dis_motora" id="discCheck4"
                                                                    value="Motora"> Motora </label>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="checkbox-inline" for="fm_dis_otra">
                                                                    Otra </label>
                                                                <input @if($clinicos->cap_dif=='No') readonly @endif
                                                                class="form-control float-input" type="text"
                                                                name="fm_dis_otra" id="fm_dis_otra" value="{{
                                                                $clinicos->otra_dis }}"
                                                                placeholder="Otra discapacidad">
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h5 class="accordion-toggle collapsed" data-toggle="collapse"
                                                    href="#clinico" class="panel-title">
                                                    <a class="accordion-toggle collapsed txtNegro" data-toggle="collapse"
                                                        href="#clinico">¿Cuentas con algún diagnóstico Psicológico
                                                        Clínico?</a>
                                                    <a> <i class="fa fa-angle-down"></i></a>
                                                </h5>
                                            </div>
                                            <div id="clinico" class="panel-collapse collapse" data-parent="#cr">
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label class="radio-inline">
                                                                <input required @if($clinicos->dia_psico!='No') checked
                                                                @endif type="radio" name="dx_psicologico" id="inlineRadio1"
                                                                value="Si"
                                                                onclick="$('#clin').attr('value','').attr('readonly',
                                                                false).attr('required',true);$('#clinT').attr('value','').attr('readonly',
                                                                false).attr('required',true);">
                                                                Sí</label>
                                                            <label class="radio-inline">
                                                                <input required @if($clinicos->dia_psico=='No') checked
                                                                @endif type="radio" name="dx_psicologico" id="inlineRadio2"
                                                                value="No"
                                                                onclick="$('#clin').attr('value','').attr('readonly',true).attr('required',false);
                                                                $('#clinT').attr('value','').attr('readonly',true).attr('required',false);"
                                                                > No
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-4"><a>¿Cuál?</a>
                                                            <input @if($clinicos->dia_psico=='No') readonly @endif
                                                            class="form-control float-input" type="text"
                                                            name="dx_psicologico_c" value="{{ $clinicos->dia_psico }}"
                                                            placeholder="¿Cuál?" id="clin">
                                                        </div>
                                                        <div class="col-sm-4"><a>Hace cuánto:</a>
                                                            <input @if($clinicos->dia_psico=='No') readonly @endif
                                                            class="form-control float-input" type="text"
                                                            name="dx_psicologico_tm" value="{{ $clinicos->cuanto_psico }}"
                                                            placeholder="Hace cuánto:" id="clinT">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h5 class="accordion-toggle collapsed" data-toggle="collapse" href="#Medico"
                                                    class="panel-title">
                                                    <a class="accordion-toggle collapsed txtNegro" data-toggle="collapse"
                                                        href="#Medico">¿Cuentas con algún diagnóstico Médico?</a>
                                                    <a> <i class="fa fa-angle-down"></i></a>
                                                </h5>
                                            </div>
                                            <div id="Medico" class="panel-collapse collapse" data-parent="#cr">
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label class="radio-inline">
                                                                <input required @if($clinicos->dia_med!='No') checked
                                                                @endif type="radio" name="medRadio" id="medinlineRad1"
                                                                value="Si"
                                                                onclick="$('#med').attr('value','').attr('readonly',
                                                                false).attr('required',true);$('#medT').attr('value','').attr('readonly',
                                                                false).attr('required',true);">
                                                                Sí</label>
                                                            <label class="radio-inline">
                                                                <input required @if($clinicos->dia_med=='No') checked
                                                                @endif type="radio" name="medRadio" id="medinlineRad2"
                                                                value="No"
                                                                onclick="$('#med').attr('value','').attr('readonly',true).attr('required',false);
                                                                $('#medT').attr('value','').attr('readonly',true).attr('required',false);"
                                                                > No</label>
                                                        </div>
                                                        <div class="col-sm-4"><a>¿Cuál?</a>
                                                            <input @if($clinicos->dia_med=='No') readonly @endif
                                                            class="form-control float-input" type="text" name="dx_medico"
                                                            value="{{ $clinicos->dia_med }}" placeholder="¿Cuál?" id="med">
                                                        </div>
                                                        <div class="col-sm-4"><a>Hace cuánto:</a>
                                                            <input @if($clinicos->dia_med=='No') readonly @endif
                                                            class="form-control float-input" type="text"
                                                            name="dx_medico_tm" value="{{ $clinicos->cuanto_med }}"
                                                            placeholder="Hace cuánto:" id="medT">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="panel-footer center">
                                            <a href="{{ url()->previous() }}" type="button"
                                                class="previous btn btn-default">Anterior</a>
                                            <input type="submit" value="Siguiente" class="btn btn-info">
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