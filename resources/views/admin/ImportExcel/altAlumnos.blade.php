@extends('template.molde')

@section('title','Importar claves')

@section('ruta')
	<label class="label label-success">Importar alumnos</label>
@endsection

@section('contenido')
	<div class="col-sm-12 bg-light text-center">		
  		<h5>Este modulo permite la importacion masiva de alumnos, para ello necesitaremos un archivo de excel que contenga los siguientes datos: </h5> 		
		<b>Columnas del archivo:</b> 
		<br>
		<p>Numero de control, Nombre del alumno, Password, Nombre de carrera y Id_Carrera</p>
		<p><b>Ejemplo:</b></p>
		<p>Control |  Nombre  |   Password    |  Correo   |   Carrera    |   Clave Carr   |</p>
		<p>C17030393 |	ALEJANDRO ROMAN GONZALEZ |	P-n57uH |	ING. INDUSTRIAL |	2  |</p> 
		<h6>Para obtener los ID de las carreras en el archivo de excel, usar la siguiente formula:</h6>
		<p><b>Office en español:</b> "=SI(E2="ING. INDUSTRIAL",2,SI(E2="ING. SIST COMP",3,SI(E2="ING. MECATRONICA",5,SI(E2="ING. BIOQUIMICA",6,SI(E2="ING. EN GES EMP",7,SI(E2="ING. EN TICS",9,SI(E2="ING. NANOTEC",10,"")))))))"</p>
		<p><b>Office en ingles:</b> "=IF(E2="ING. INDUSTRIAL",2,IF(E2="ING. SIST COMP",3,IF(E2="ING. MECATRONICA",5,IF(E2="ING. BIOQUIMICA",6,IF(E2="ING. EN GES EMP",7,IF(E2="ING. EN TICS",9,IF(E2="ING. NANOTEC",10,"")))))))"</p>				
		<p><b>Nota: LAs claves obtenerlas en otro archivo, ya que el que se va a subir, solo debe contener texto, no formulas!</b></p>
	</div>	
	<div class="row">			
		<div class="col-sm-2 ">				
		</div>
		<div class="col-sm-8 text-center">
			<div class="col-sm-12">
				<h3>Dar de alta alumnos nuevos</h3>
			</div>
			<hr>
			<form method="POST" action="{{ route('excel.aluImport')}}" enctype="multipart/form-data" >
		        @csrf 
	       	    <div class="form-group">
	       	     	<input type="file" name="excel" id="archivos" class="inputfile inputfile-4 subida" data-multiple-caption="{count} archivos seleccionados"/>
	       	     	
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