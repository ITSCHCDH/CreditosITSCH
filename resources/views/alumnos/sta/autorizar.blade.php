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
                                <div id="editor-container">
                                    <div id="editor" contenteditable="true" onscroll="checkScroll()" id="aviso" style="height: 500px;  border: 1px solid #ccc; overflow: auto;">
                                        <div style="margin: 40px;">
                                            <b>AVISO DE PRIVACIDAD DE ACCESO A LA INFORMACIÓN</b>
                                        <p>
                                            I. Responsable de la protección de sus datos personales.
                                            El Instituto Tecnológico Superior de Ciudad Hidalgo con Unidad de Transparencia, ubicada en Av. Ing. Carlos Rojas Gutiérrez #2120 Fracc. Valle de la Herradura, C.P. 61100, en un horario de 9:00 a 17:00 horas será el responsable de recabar, tratar y proteger su información confidencial. Lo anterior conforme a lo establecido por la Ley de Protección de Datos Personales en Posesión de Sujetos Obligados del Estado de Michoacán de Ocampo.
                                        </p>
                                        <b>II. ¿Para qué fines recabamos y utilizamos sus datos personales?</b>
                                        <p>                                        
                                            <b>Las finalidades del tratamiento de sus datos personales son:</b><br>
                                            <ul >
                                                <li>Ficha de examen de admisión;</li>
                                                <li>Titulación;</li>
                                                <li>Elaboración de Constancias con y sin calificaciones;</li>
                                                <li>Certificado parcial;</li>
                                                <li>Duplicado de credencia;</li>
                                                <li>Inscripción al Seguro Social;</li>
                                                <li>Baja definitiva; </li>
                                                <li>Examen global de conocimiento; </li>
                                                <li>Tramite Tardío; </li>
                                                <li>Préstamo de documentos; </li>
                                                <li>Verano materia teórica;</li>
                                                <li>Kardex;</li>
                                                <li>Examen EGEL;</li>
                                                <li> Tutorias academicas.</li>
                                            </ul>                                  
                                        </p>
                                        <b> III. ¿Qué datos personales obtenemos?</b>
                                        <p>
                                            Para cumplir las finalidades anteriores requerimos dependiendo del procedimiento o actividad a realizar de los siguientes datos personales:
                                            De identificación: Nombre, Origen Étnico y Racial, Lengua Materna, Domicilio, Teléfono, Correo Electrónico, Firma, Contraseñas, RFC, CURP, Fecha de Nacimiento, Edad, Nacionalidad, Estado Civil.
                                            De Educación: Escuelas, Calificaciones, Títulos, Cédulas, Certificados, Diplomas.
                                            De Salud: Estado de Salud, Historial y Estudios Clínicos, Enfermedades, Tratamientos Médicos, Medicamentos, Alergias, Embarazos, Condición Psicológica y/o Psiquiátricas. Usted tiene la facultad de determinar si los entrega o no.
                                        </p>
                                        <b> IV. Fundamento Legal.</b>
                                        <p>
                                            En lo que se refiere al tratamiento de sus datos personales, el responsable lo efectuara en términos del numeral 23, 24 y demás de la Ley de Protección de Datos Personales en Posesión de Sujetos Obligados del Estado de Michoacán de Ocampo.
                                        </p>
                                        <b>V. Mecanismos de seguridad.</b>
                                        <p>                                  
                                            En el Instituto Tecnológico Superior de Ciudad Hidalgo se emplean procedimientos físicos para prevenir el acceso no autorizado, mantener la exactitud de los datos, y garantizar el uso correcto de su información personal.
                                        </p>
                                        <b>
                                            VI. ¿Cómo Acceder, ¿Rectificar, Cancelar u Oponerse al uso y tratamiento de sus datos personales (Derechos ARCO) o revocar su consentimiento para el tratamiento sus datos?
                                            Usted tiene derecho de acceso, rectificación, cancelación u oposición al tratamiento de sus datos personales o revocar el consentimiento. Para el ejercicio de estos derechos el titular de los datos personales o su representante deberán presentar solicitud de ejercicio de derechos ARCO, misma que podrá ser presentada en formato libre siempre que reúna los siguientes requisitos:
                                        </b>             
                                        <p>
                                            Acreditar que es el titular de los datos personales ante la autoridad a la que se dirige la solicitud.
                                            Nombre, datos generales e identificación oficial del solicitante, o en su defecto poder otorgado por el titular de los datos personales.
                                            Precisión de los datos respecto de los que busca ejercer alguno de los derechos ARCO (Acceso, Rectificación, Cancelación y Oposición).
                                            Domicilio para recibir notificaciones y/o correo electrónico.
                                            Modalidad en la que prefiere se les otorgue el acceso a sus datos (verbalmente, mediante consulta directa, a través de documentos como copias simples, certificadas u otros).
                                            Algún elemento que facilite la localización de la información.
                                            Firma del solicitante.
                                            Le informamos que puede presentar su solicitud de protección de datos personales vía electrónica a través de la Plataforma Nacional de Transparencia
                                            http://www.plataformadetransparencia.org.mx
                                            o bien puede acudir directamente a las oficinas de la Unidad de Transparencia del Instituto Tecnológico Superior de Ciudad Hidalgo, ubicada en Av. Ing. Carlos Rojas Gutiérrez #2120 Fracc. Valle de la Herradura, C.P. 61100, en Horario de atención de 9:00 am a 5:00 pm.
                                        </p>
                                        <b> VII. Transferencia de datos personales.</b>   
                                        <p>
                                            Le informamos que sólo excepcionalmente sus datos personales serán transferidos en el siguiente caso: Sus datos podrán ser transferidos al Instituto Mexicano del Seguro Social a efectos registro y alta con la finalidad de obtener los servicios de salud pública correspondientes.                                    
                                        </p>                    
                                        <b>VIII. Modificaciones al aviso de privacidad</b>
                                        <p>
                                            El Instituto Tecnológico Superior de Ciudad Hidalgo, le notificarán de cualquier cambio al aviso de privacidad mediante comunicados que se publicarán a través de nuestro portal de transparencia:
                                        </p> 
                                        </div>                                             
                                    </div>
                                </div>
                                <hr>
                                <div id="cr">
                                    <div class="panel-footer center">
                                        <a href="{{  url()->previous() }}" type="button" class="previous btn btn-default">Anterior</a>                                        
                                        <button type="submit" class="btn btn-primary" id="btnFirmar" disabled>Aceptar y firmar</button>
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

@section('js')
<script>
    function checkScroll() {
        var editor = document.getElementById("editor");
        var button = document.getElementById("btnFirmar");
    
        var scrollTop = editor.scrollTop;
        var clientHeight = editor.clientHeight;
        var scrollHeight = editor.scrollHeight;
    
        // Añade un pequeño margen para considerar diferencias en cálculos de scroll
        var scrollThreshold = 5;
    
        if (scrollTop + clientHeight + scrollThreshold >= scrollHeight) {
            button.removeAttribute("disabled");
        } else {
            button.setAttribute("disabled", "true");
        }
    }
  </script>
@endsection