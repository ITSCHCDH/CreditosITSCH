@extends('template.molde')

@section('title','Actividades')

@section('ruta')
	<a href="" class="label label-info">STA</a>
	/
	<label class="label label-success">Datos sociales</label>
@endsection

@section('contenido')
    <form action="{{ route('alumnos.sta.dsociales.guargar', $alu->no_control) }}" method="get">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card">
                    <div class="container cuerpo">
                        <div class="row fch">
                            <fieldset class="col-md-12">
                                {{--cabecera--}}
                                <div>
                                    <div class="panel-heading">
                                        <h3 class="head text-center">ÁREAS PERSONAL Y SOCIAL</h3>
                                        <div class="head text-center">
                                            <h4>Datos sobre tu vida social</h4>
                                        </div>
                                        <div class="progress" style="height: 18px">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated"
                                                role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"
                                                style="width: 80%">80%</div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div id="cr">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h5 class="accordion-toggle collapsed" data-toggle="collapse" href="#soc"
                                                class="panel-title">
                                                <a class="accordion-toggle collapsed txtNegro" data-toggle="collapse"
                                                    href="#soc">¿Cómo
                                                    es la relación con tus compañeros?</a>
                                                <a> <i class="fa fa-angle-down"></i></a>
                                            </h5>
                                        </div>
                                        <div id="soc" class="panel-collapse collapse" data-parent="#cr">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <select required id="rel_comp" name="rel_comp"
                                                            class="form-control float-input">
                                                            <option value=''>Seleccione una opcion
                                                            </option>
                                                            <option @if($soc->
                                                                rel_comp=='Buena') selected
                                                                @endif value='Buena'>Buena</option>
                                                            <option @if($soc->
                                                                rel_comp=='Regular') selected
                                                                @endif value='Regular'>Regular</option>
                                                            <option @if($soc->
                                                                rel_comp=='Mala') selected
                                                                @endif value='Mala'>Mala</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group bs-float-label">
                                                            <label for="rel_comp_t">¿Por qué?</label>
                                                            <textarea required id="rel_comp_t" name="rel_comp_t"
                                                                placeholder=""
                                                                class="form-control float-input">{{ $soc->comp_por }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h5 class="accordion-toggle collapsed" data-toggle="collapse" href="#soc1"
                                                class="panel-title">
                                                <a class="accordion-toggle collapsed txtNegro" data-toggle="collapse"
                                                    href="#soc1">¿Cómo
                                                    es la relación con tus amigos?</a>
                                                <a> <i class="fa fa-angle-down"></i></a>
                                            </h5>
                                        </div>
                                        <div id="soc1" class="panel-collapse collapse" data-parent="#cr">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <select required id="rel_ami" name="rel_ami"
                                                            class="form-control float-input">
                                                            <option value=''>Seleccione una opcion
                                                            </option>
                                                            <option @if($soc->
                                                                rel_amig=='Buena') selected
                                                                @endif value='Buena'>Buena</option>
                                                            <option @if($soc->
                                                                rel_amig=='Regular') selected
                                                                @endif value='Regular'>Regular</option>
                                                            <option @if($soc->
                                                                rel_amig=='Mala') selected
                                                                @endif value='Mala'>Mala</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group bs-float-label">
                                                            <label for="rel_ami_t">¿Por qué?</label>
                                                            <textarea required id="rel_ami_t" name="rel_ami_t"
                                                                placeholder=""
                                                                class="form-control float-input">{{ $soc->amig_por }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h5 class="accordion-toggle collapsed" data-toggle="collapse" href="#soc2"
                                                class="panel-title">
                                                <a class="accordion-toggle collapsed txtNegro" data-toggle="collapse"
                                                    href="#soc2">¿Tienes pareja?</a>
                                                <a> <i class="fa fa-angle-down"></i></a>
                                            </h5>
                                        </div>
                                        <div id="soc2" class="panel-collapse collapse" data-parent="#cr">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-sm-2">
                                                        <label class="radio-inline">
                                                            <input required @if($soc->pareja!='No') checked
                                                            @endif type="radio" name="alu_par" id="alu_par1" value="Si"
                                                            onclick="$('#rel_alu_par').attr('value','').attr('readonly',
                                                            false).attr('required',true);">
                                                            SI
                                                        </label>
                                                        <label class="radio-inline">
                                                            <input required @if($soc->pareja=='No') checked
                                                            @endif type="radio" name="alu_par" id="alu_par2" value="No"
                                                            onclick="$('#rel_alu_par').attr('value','').attr('readonly',true).attr('required',false);">
                                                            NO
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-5">
                                                        <label for="rel_alu_par">¿Cómo
                                                            es su relación?</label>
                                                        <select name="rel_alu_par" id="rel_alu_par" @if($soc->pareja=='No')
                                                            readonly
                                                            @endif class="form-control float-input">
                                                            <option value=''>Seleccione una opcion
                                                            </option>
                                                            <option @if($soc->
                                                                pareja=='Buena') selected
                                                                @endif value='Buena'>Buena</option>
                                                            <option @if($soc->
                                                                pareja=='Regular') selected
                                                                @endif value='Regular'>Regular</option>
                                                            <option @if($soc->
                                                                pareja=='Mala') selected
                                                                @endif value='Mala'>Mala</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h5 class="accordion-toggle collapsed" data-toggle="collapse" href="#soc3"
                                                class="panel-title">
                                                <a class="accordion-toggle collapsed txtNegro" data-toggle="collapse"
                                                    href="#soc3">¿Cómo
                                                    es la relación con tus
                                                    profesores?</a>
                                                <a> <i class="fa fa-angle-down"></i></a>
                                            </h5>
                                        </div>
                                        <div id="soc3" class="panel-collapse collapse" data-parent="#cr">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <select required id="rel_pro" name="rel_pro"
                                                            class="form-control float-input">
                                                            <option value=''>Seleccione una opcion
                                                            </option>
                                                            <option @if($soc->
                                                                rel_prof=='Buena') selected
                                                                @endif value='Buena'>Buena</option>
                                                            <option @if($soc->
                                                                rel_prof=='Regular') selected
                                                                @endif value='Regular'>Regular</option>
                                                            <option @if($soc->
                                                                rel_prof=='Mala') selected
                                                                @endif value='Mala'>Mala</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group bs-float-label">
                                                            <label for="rel_pro_t">¿Por qué?</label>
                                                            <textarea required id="rel_pro_t" name="rel_pro_t"
                                                                placeholder=""
                                                                class="form-control float-input">{{ $soc->prof_por }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h5 class="accordion-toggle collapsed" data-toggle="collapse" href="#soc4"
                                                class="panel-title">
                                                <a class="accordion-toggle collapsed txtNegro" data-toggle="collapse"
                                                    href="#soc4">¿Cómo es tu relación con las autoridades académicas?</a>
                                                <a> <i class="fa fa-angle-down"></i></a>
                                            </h5>
                                        </div>
                                        <div id="soc4" class="panel-collapse collapse" data-parent="#cr">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <select required name="rel_aut_aca" class="form-control float-input"
                                                            id="rel_aut_aca">
                                                            <option value=''>Seleccione una opcion
                                                            </option>
                                                            <option @if($soc->
                                                                rel_auto_ac=='Buena') selected
                                                                @endif value='Buena'>Buena</option>
                                                            <option @if($soc->
                                                                rel_auto_ac=='Regular') selected
                                                                @endif value='Regular'>Regular</option>
                                                            <option @if($soc->
                                                                rel_auto_ac=='Mala') selected
                                                                @endif value='Mala'>Mala</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group bs-float-label">
                                                            <label for="rel_aut_aca_t">¿Por qué?</label>
                                                            <textarea required id="rel_aut_aca_t" name="rel_aut_aca_t"
                                                                placeholder=""
                                                                class="form-control float-input">{{ $soc->auto_ac_por }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h5 class="accordion-toggle collapsed" data-toggle="collapse" href="#soc5"
                                                class="panel-title">
                                                <a class="accordion-toggle collapsed txtNegro" data-toggle="collapse"
                                                    href="#soc5">¿Qué haces en tu tiempo libre?</a>
                                                <a> <i class="fa fa-angle-down"></i></a>
                                            </h5>
                                        </div>
                                        <div id="soc5" class="panel-collapse collapse" data-parent="#cr">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group bs-float-label">
                                                            <textarea id="alu_tlibre" name="alu_tlibre" placeholder=""
                                                                class="form-control float-input"
                                                                required>{{ $soc->tiempo_lib }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h5 class="accordion-toggle collapsed" data-toggle="collapse" href="#soc6"
                                                class="panel-title">
                                                <a class="accordion-toggle collapsed txtNegro" data-toggle="collapse"
                                                    href="#soc6">¿Cuál
                                                    es tu actividad recreativa?</a>
                                                <a> <i class="fa fa-angle-down"></i></a>
                                            </h5>
                                        </div>
                                        <div id="soc6" class="panel-collapse collapse" data-parent="#cr">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group bs-float-label">
                                                            <textarea id="alu_act_rec" name="alu_act_rec" placeholder=""
                                                                class="form-control float-input"
                                                                required>{{ $soc->recreativa }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h5 class="accordion-toggle collapsed" data-toggle="collapse" href="#soc7"
                                                class="panel-title">
                                                <a class="accordion-toggle collapsed txtNegro" data-toggle="collapse"
                                                    href="#soc7">¿Cuáles son tus planes inmediatos?</a>
                                                <a> <i class="fa fa-angle-down"></i></a>
                                            </h5>
                                        </div>
                                        <div id="soc7" class="panel-collapse collapse" data-parent="#cr">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group bs-float-label">
                                                            <textarea id="alu_pl_inme" name="alu_pl_inme" placeholder=""
                                                                class="form-control float-input"
                                                                required>{{ $soc->planes_in }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h5 class="accordion-toggle collapsed" data-toggle="collapse" href="#soc8"
                                                class="panel-title">
                                                <a class="accordion-toggle collapsed txtNegro" data-toggle="collapse"
                                                    href="#soc8">¿Cuáles son tus metas en la vida?</a>
                                                <a> <i class="fa fa-angle-down"></i></a>
                                            </h5>
                                        </div>
                                        <div id="soc8" class="panel-collapse collapse" data-parent="#cr">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group bs-float-label">
                                                            <textarea id="alu_metas" name="alu_metas" placeholder=""
                                                                class="form-control float-input"
                                                                required>{{ $soc->metas_vida }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h5 class="accordion-toggle collapsed" data-toggle="collapse" href="#soc9"
                                                class="panel-title">
                                                <a class="accordion-toggle collapsed txtNegro" data-toggle="collapse" href="#soc9">Yo
                                                    soy...(Responde lo primero que se te venga a la mente)</a>
                                                <a> <i class="fa fa-angle-down"></i></a>
                                            </h5>
                                        </div>
                                        <div id="soc9" class="panel-collapse collapse" data-parent="#cr">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group bs-float-label">
                                                            <textarea id="alu_soy" name="alu_soy" placeholder=""
                                                                class="form-control float-input"
                                                                required>{{ $soc->yo_soy }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h5 class="accordion-toggle collapsed" data-toggle="collapse" href="#soc10"
                                                class="panel-title">
                                                <a class="accordion-toggle collapsed txtNegro" data-toggle="collapse"
                                                    href="#soc10">¿Mi carácter es...?</a>
                                                <a> <i class="fa fa-angle-down"></i></a>
                                            </h5>
                                        </div>
                                        <div id="soc10" class="panel-collapse collapse" data-parent="#cr">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group bs-float-label">
                                                            <textarea id="alu_caracter" name="alu_caracter" placeholder=""
                                                                class="form-control float-input"
                                                                required>{{ $soc->caracter }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h5 class="accordion-toggle collapsed" data-toggle="collapse" href="#soc11"
                                                class="panel-title">
                                                <a class="accordion-toggle collapsed txtNegro" data-toggle="collapse" href="#soc11">A mí me gusta que...</a>
                                                <a> <i class="fa fa-angle-down"></i></a>
                                            </h5>
                                        </div>
                                        <div id="soc11" class="panel-collapse collapse" data-parent="#cr">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group bs-float-label">
                                                            <textarea id="alu_gusto" name="alu_gusto" placeholder=""
                                                                class="form-control float-input"
                                                                required>{{ $soc->me_gusta }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h5 class="accordion-toggle collapsed" data-toggle="collapse" href="#soc12"
                                                class="panel-title">
                                                <a class="accordion-toggle collapsed txtNegro" data-toggle="collapse"
                                                    href="#soc12">Yo aspiro en la vida...</a>
                                                <a> <i class="fa fa-angle-down"></i></a>
                                            </h5>
                                        </div>
                                        <div id="soc12" class="panel-collapse collapse" data-parent="#cr">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group bs-float-label">
                                                            <textarea id="alu_aspira" name="alu_aspira" placeholder=""
                                                                class="form-control float-input"
                                                                required>{{ $soc->aspiraciones }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h5 class="accordion-toggle collapsed" data-toggle="collapse" href="#soc13"
                                                class="panel-title">
                                                <a class="accordion-toggle collapsed txtNegro" data-toggle="collapse"
                                                    href="#soc13">Yo tengo miedo que...</a>
                                                <a> <i class="fa fa-angle-down"></i></a>
                                            </h5>
                                        </div>
                                        <div id="soc13" class="panel-collapse collapse" data-parent="#cr">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group bs-float-label">
                                                            <textarea id="alu_miedo" name="alu_miedo" placeholder=""
                                                                class="form-control float-input"
                                                                required>{{ $soc->miedo }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="panel-footer center">
                                        <a href="{{ url('/alumnos/updtDatSalud',$alu->no_control) }}" type="button" class="previous btn btn-default">Anterior</a>
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