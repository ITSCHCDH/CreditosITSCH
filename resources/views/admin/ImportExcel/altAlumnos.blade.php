@extends('template.molde')

@section('title','Importar claves')


@section('links')
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/fileupload/css/demo.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/fileupload/css/component.css')}}">
    <script>(function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);</script>
@endsection

@section('ruta')
	<label class="label label-success">Importar alumnos</label>
@endsection

@section('contenido')
	<div class="col-sm-12 bg-success text-white text-center">		
  		<h5>Este modulo permite la importacion masiva de alumnos, para darlos de alta, para ello necesitaremos un archivo de excel que contenga los siguientes datos: <p></p> <b>Para dar de alta:</b> <p></p> Columnas del archivo:<br> <b>No., Numero de control, Nombre del alumno, Password, Nombre de carrera y Id_Carrera</b><p><b>Ejemplo:</b></p>9 |	C17030393 |	ALEJANDRO ROMAN GONZALEZ |	P-n58N_ |	ING. INDUSTRIAL |	2
			<p>Para los ID de las carreras usar la siguiente formula:</p>
			<b><p>"=SI(E2="ING. INDUSTRIAL",2,SI(E2="ING. SIST COMP",3,SI(E2="ING. MECATRONICA",5,SI(E2="ING. BIOQUIMICA",6,SI(E2="ING. EN GES EMP",7,SI(E2="ING. EN TICS",9,SI(E2="ING. NANOTEC",10,"")))))))"</p></b>
		</h5>		
	</div>
	<div class="row">			
		<div class="col-sm-2 ">				
		</div>
		<div class="col-sm-8 text-center">
			<div class="col-sm-12">
				<h3>Dar de alta alumnos nuevos</h3>
			</div>
			<form method="POST" action="{{ route('excel.aluImport')}}" enctype="multipart/form-data" >
		        {{ csrf_field() }} 
	       	    <div class="form-group">
	       	     	<input type="file" name="excel" id="archivos" class="inputfile inputfile-4 subida" data-multiple-caption="{count} archivos seleccionados"/>
	       	     	<label for="archivos" class="subida">
			            <figure class="subida">
			                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17" class="subida">
			                    <path class="subida" d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
			                </svg>
			            </figure> 
			            <span class="subida">Seleccionar archivos&hellip;</span>
	        		</label>
	        		<br><br>	       	    		       		    
			        <input type="submit" value="Registrar" class="btn btn-primary" onclick="move()">
			     </div>		            
		    </form>
		</div>
		<div class="col-sm-2">
			
		</div>
	</div>
	<p></p>
    <div class="col-sm-12" id="myProgress">
		<div id="myBar"></div>
		<div id="percent">0 %</div >		
	</div> 
	<div class="col-sm-12">
		<br>
	</div> 	
	@section('js')	
	      <script>
	      	var ban=0;
				function move() 
				{
				    var elem = document.getElementById("myBar"); 
				    var percent = $('#percent');
				    var file=$('#archivos');
				    var width = 1;	
					if( document.getElementById("archivos").files.length == 0 )
					{
						alert("Debes seleccionar un archivo");
					}
					else
					{
						if(ban==0)
						{
							ban=1;
							var id = setInterval(frame, 680);
						    function frame() 
						    {
							    if (width >= 100) 
							    {
							      clearInterval(id);
							      ban=0;
							    } 
							    else 
							    {
							      width++; 
							      elem.style.width = width + '%'; 
							      percent.text(width+' %');
							    }
						 	}
						}
					}
				}						
		  </script>  
		

		<style>
			#myProgress {
			  width: 100%;			
			  background-color: #ddd;
			  position:relative;			 
			  padding: 1px; 
			  border-radius: 3px;
			}

			#myBar {
			  width: 1%;
			  height: 30px;
			  background-color: #4CAF50;
			}

			#percent { 
				position:absolute; 
				display:inline-block; 
				top:3px; 
				left:48%; 
				color: #000000;
			}
		</style>
		 
	@endsection
@endsection