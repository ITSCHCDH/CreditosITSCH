@extends('template.molde')

@section('title','Importar claves')

@section('ruta')
	<label class="label label-success">Importar claves</label>
@endsection

@section('contenido')
	<div class="col-sm-12 bg-light text-center">		
  			<h5>Este modulo permite la importacion masiva de alumnos para modificar las contraseñas de aquellos que ya han sido registrados previamente, para ello necesitaremos un archivo de excel que contenga los siguientes datos:</h5>		
			<p><b>Para modificar:</b></p>
			<h6>Columnas del excel:<h6>
		    <p>No., Numero de control y Password</p>
	</div>
	<div class="row ">
		<div class="col-sm-2 ">			
		</div>
		<div class="col-sm-8 text-center">
			<div class="col-sm-12">
				<h3>Modificar alumnos existentes</h3>
			</div>	   
			<hr> 
		    <form method="POST" action="{{ route('excel.import')}}" enctype="multipart/form-data">
		        @csrf
		        <div class="form-group">				    
			        <input type="file" name="excel" id="archivos" class="inputfile inputfile-4 subida" data-multiple-caption="{count} archivos seleccionados"/>			       
					<br>
					<br>
			        <input type="submit" value="Modificar" class="btn btn-success" onclick="move()">		      	              
	            </div>
		    </form>
		</div>
		<div class="col-sm-2">
			
		</div>
	</div>
	<br>
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
							var id = setInterval(frame, 6000);
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