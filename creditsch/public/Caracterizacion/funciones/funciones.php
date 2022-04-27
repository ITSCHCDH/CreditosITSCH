<?PHP
function familiares ($ficha){
	require '../conexion/conex_mysql.php';
	$no_ficha= $ficha;
	$mysqli = new mysqli ($hostname,$username,$password,$database);
	if ($mysqli->connect_errno){
		die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
	}

	$query = "SELECT * from alumnos_hab_casa WHERE no_ficha='$no_ficha'";
	$resultado = $mysqli->query($query);
	$rows = mysqli_num_rows($resultado);
	if (!empty($rows)){
		echo"
		<fieldset><legend><stroke>FAMILIARES</stroke></legend>";
		while($rows=mysqli_fetch_array($resultado)){
			echo"
			<table width='675' border='0'>
				<tr>
					<td><ba>Nombre:</ba></td>
					<td><ba>Edad:</td>
				</tr>
				<tr>
					<td width='500'>
						<input type='text' name='nombre' id='nombre' size='48' value= '";echo $rows['nombre']; echo "' disabled>
					</td>
					<td>
						<input type='text' name='edad' id='edad' size='3' value='";echo $rows['edad']; echo "' disabled>
					</td>	
				</tr>
			</table>
			<table width='675'>
				<tr>
					<td><ba>Parentesco:</ba></td>
					<td><ba>Escolaridad:</ba></td>
					<td><ba>Escuela:</td>
				</tr>				
				<tr>
					<td width='250'>
						<input type='text' name='parentesco' id='parentesco' size='20' value= '";echo $rows['parentesco']; echo "' disabled>
					</td>
					<td width='250'>
						<input type='text' name='escolaridad' id='escolaridad' size='20' value= '";echo $rows['escolaridad']; echo "' disabled>
					</td>
					<td>
						<input type='text' name='tipo_escuela' id='tipo_escuela' size='7' value= '";echo $rows['esc_pub_priv']; echo "' disabled>
					</td>
				</tr>					
			</table>
			<table width='675'>
				<tr width='500'>
					<td><ba>Ocupación:</ba></td>
				</tr>
				<tr>
					<td>
						<input type='text' name='ocupacion' id='ocupacion' size='48' value= '";echo $rows['ocupacion']; echo "' disabled>
					</td>
				</tr>
			</table> <br><br>";			
		}
		echo"
		</fieldset>";
	}
}
function familiares_2($ficha){
	require '../../conexion/conex_mysql.php';
	$no_ficha= $ficha;
	$mysqli = new mysqli ($hostname,$username,$password,$database);
	if ($mysqli->connect_errno){
		die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
	}
	$query = "SELECT * from alumnos_hab_casa WHERE no_ficha='$no_ficha'";
	$resultado = $mysqli->query($query);
	$rows = mysqli_num_rows($resultado);
	if (!empty($rows)){
		echo"
		<fieldset><legend><stroke>FAMILIARES</stroke></legend>";
		while($rows=mysqli_fetch_array($resultado)){
			echo"
			<table width='675' border='0'>
				<tr>
					<td><ba>Nombre:</ba></td>
					<td><ba>Edad:</td>
				</tr>
				<tr>
					<td width='500'>
						<input type='text' name='nombre' id='nombre' size='48' value= '";echo $rows['nombre']; echo "' disabled>
					</td>
					<td>
						<input type='text' name='edad' id='edad' size='3' value='";echo $rows['edad']; echo "' disabled>
					</td>	
				</tr>
			</table>
			<table width='675'>
				<tr>
					<td><ba>Parentesco:</ba></td>
					<td><ba>Escolaridad:</ba></td>
					<td><ba>Escuela:</td>
				</tr>				
				<tr>
					<td width='250'>
						<input type='text' name='parentesco' id='parentesco' size='20' value= '";echo $rows['parentesco']; echo "' disabled>
					</td>
					<td width='250'>
						<input type='text' name='escolaridad' id='escolaridad' size='20' value= '";echo $rows['escolaridad']; echo "' disabled>
					</td>
					<td>
						<input type='text' name='tipo_escuela' id='tipo_escuela' size='7' value= '";echo $rows['esc_pub_priv']; echo "' disabled>
					</td>
				</tr>					
			</table>
			<table width='675'>
				<tr width='500'>
					<td><ba>Ocupación:</ba></td>
				</tr>
				<tr>
					<td>
						<input type='text' name='ocupacion' id='ocupacion' size='48' value= '";echo $rows['ocupacion']; echo "' disabled>
					</td>
				</tr>
			</table> <br><br>";
			
		}
		echo"
		</fieldset>";
	}
}
function vivienda($caso){
	switch ($caso) {
		case '1':
			echo"
				<input type='radio' name='vivienda' value='1' id='vivienda' disabled checked><pp>Propia
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type='radio' name='vivienda' value='2' id='vivienda' disabled><pp>Rentada		
				&nbsp;<br>
				<input type='radio' name='vivienda' value='3' id='vivienda' disabled><pp>Prestada
				&nbsp;&nbsp;
				<input type='radio' name='vivienda' value='4' id='vivienda' disabled><pp>Pagando";
			break;
		case '2':
			echo"
				<input type='radio' name='vivienda' value='1' id='vivienda' disabled><pp>Propia
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type='radio' name='vivienda' value='2' id='vivienda' disabled checked><pp>Rentada		
				&nbsp;<br>
				<input type='radio' name='vivienda' value='3' id='vivienda' disabled><pp>Prestada
				&nbsp;&nbsp;
				<input type='radio' name='vivienda' value='4' id='vivienda' disabled><pp>Pagando";
			break;
		case '3':
			echo"
				<input type='radio' name='vivienda' value='1' id='vivienda' disabled><pp>Propia
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type='radio' name='vivienda' value='2' id='vivienda' disabled><pp>Rentada		
				&nbsp;<br>
				<input type='radio' name='vivienda' value='3' id='vivienda' disabled checked><pp>Prestada
				&nbsp;&nbsp;
				<input type='radio' name='vivienda' value='4' id='vivienda' disabled><pp>Pagando";
			break;
		case '4':
			echo"
				<input type='radio' name='vivienda' value='1' id='vivienda' disabled><pp>Propia
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type='radio' name='vivienda' value='2' id='vivienda' disabled><pp>Rentada		
				&nbsp;<br>
				<input type='radio' name='vivienda' value='3' id='vivienda' disabled><pp>Prestada
				&nbsp;&nbsp;
				<input type='radio' name='vivienda' value='4' id='vivienda' disabled checked><pp>Pagando";
			break;
	}
}
function zona_proc($caso){
	switch ($caso) {
		case '1':
			echo"
				<td width='130'>
					<input type='radio' name='zona_proc' value='1' id='zona_proc' disabled checked><pp>Indígena
				</td>
				<td width='110'>
					<input type='radio' name='zona_proc' value='2' id='zona_proc' disabled><pp>Rural
				</td>
				<td width='110'>
					<input type='radio' name='zona_proc' value='4' id='zona_proc' disabled><pp>Urbano	
				</td>
				<td width='200'>
					<input type='radio' name='zona_proc' value='3' id='zona_proc' disabled><pp>Urbano Marginado
				</td>";
			break;	
		case '2':
			echo"
				<td width='130'>
					<input type='radio' name='zona_proc' value='1' id='zona_proc' disabled ><pp>Indígena
				</td>
				<td width='110'>
					<input type='radio' name='zona_proc' value='2' id='zona_proc' disabled checked><pp>Rural
				</td>
				<td width='110'>
					<input type='radio' name='zona_proc' value='4' id='zona_proc' disabled><pp>Urbano	
				</td>
				<td width='200'>
					<input type='radio' name='zona_proc' value='3' id='zona_proc' disabled><pp>Urbano Marginado
				</td>";
			break;
		case '3':
			echo"
				<td width='130'>
					<input type='radio' name='zona_proc' value='1' id='zona_proc' disabled ><pp>Indígena
				</td>
				<td width='110'>
					<input type='radio' name='zona_proc' value='2' id='zona_proc' disabled ><pp>Rural
				</td>
				<td width='110'>
					<input type='radio' name='zona_proc' value='4' id='zona_proc' disabled checked><pp>Urbano	
				</td>
				<td width='200'>
					<input type='radio' name='zona_proc' value='3' id='zona_proc' disabled><pp>Urbano Marginado
				</td>";
			break;
		case '4':
			echo"
				<td width='130'>
					<input type='radio' name='zona_proc' value='1' id='zona_proc' disabled ><pp>Indígena
				</td>
				<td width='110'>
					<input type='radio' name='zona_proc' value='2' id='zona_proc' disabled ><pp>Rural
				</td>
				<td width='110'>
					<input type='radio' name='zona_proc' value='4' id='zona_proc' disabled><pp>Urbano	
				</td>
				<td width='200'>
					<input type='radio' name='zona_proc' value='3' id='zona_proc' disabled checked><pp>Urbano Marginado
				</td>";
			break;
	}
}
function estudio_se($ficha){
	require '../conexion/conex_mysql.php';
	$no_ficha= $ficha;
	$mysqli = new mysqli ($hostname,$username,$password,$database);
	if ($mysqli->connect_errno){
		die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
	}

	$query = "SELECT * from alumnos_folio WHERE no_ficha='$no_ficha'";
	$resultado = $mysqli->query($query);
	$rows = mysqli_fetch_array($resultado);
	$est_se1=$rows['f_est_soc_econ1'];
	$est_se2=$rows['f_est_soc_econ2'];
	$est_se3=$rows['f_est_soc_econ3'];

	if ($est_se1==1 AND $est_se2==1 AND $est_se3==1){
		$query = "SELECT * from alumnos_estudio_se WHERE no_ficha='$no_ficha'";
		$resultado = $mysqli->query($query);
		$rows = mysqli_fetch_array($resultado);
		$hijos_cant=($rows['est_hijos_cant']);
		$hijos_det=($rows['est_hijos_detalle']);
		$discapacidad=($rows['est_discap']);
		$discapacidad_det=($rows['est_discap_detalle']);
		$enf_cronica=($rows['est_enf_cron']);
		$enf_cronica_det=($rows['est_enf_cron_detalle']);
		$consulta_med=($rows['est_consulta_med']);
		if (!empty($consulta_med)){
			$imss= substr($consulta_med, 0,1);
			$isste= substr($consulta_med, 1,1);
			$salubridad = substr($consulta_med, 2,1);
			$particular = substr($consulta_med, 3,1);
		}
		else{
			$imss= 0;
			$isste= 0;
			$salubridad = 0;
			$particular = 0;
		}
	
		$zona_procedencia=($rows['est_zona_proc']);
		$zona_procedencia_det=($rows['est_zona_proc_detalle']);
		$apoyo_prospera=($rows['est_apoyo_prospera']);
		$vivienda=($rows['est_vivienda']);
		$material_vivienda=($rows['est_material_vivienda']);
		$material_techo=($rows['est_material_techo']);
		$cuartos=($rows['est_no_cuartos']);
		$baños=($rows['est_no_banios']);
		$agua_beber=($rows['est_agua_beber']);
		if (!empty($agua_beber)){
			$ab1= substr($agua_beber, 0,1);
			$ab2= substr($agua_beber, 1,1);
			$ab3= substr($agua_beber, 2,1);
			$ab4= substr($agua_beber, 3,1);
			$ab5= substr($agua_beber, 4,1);
			$ab6= substr($agua_beber, 5,1);
		}
		else{
			$ab1= 0;
			$ab2= 0;
			$ab3= 0;
			$ab4= 0;
			$ab5= 0;
			$ab6= 0;
		}
		$agua_vivienda=($rows['est_agua_vivienda']);
		if (!empty($agua_vivienda)){
			$av1= substr($agua_vivienda, 0,1);
			$av2= substr($agua_vivienda, 1,1);
			$av3= substr($agua_vivienda, 2,1);
			$av4= substr($agua_vivienda, 3,1);
			$av5= substr($agua_vivienda, 4,1);
			$av6= substr($agua_vivienda, 5,1);
		}
		else{
			$av1= 0;
			$av2= 0;
			$av3= 0;
			$av4= 0;
			$av5= 0;
			$av6= 0;
		}
		$pago_luz=($rows['est_gasto_luz']);
		$drenaje=($rows['est_drenaje']);
		if (!empty($drenaje)){
			$dre1= substr($drenaje, 0,1);
			$dre2= substr($drenaje, 1,1);
			$dre3= substr($drenaje, 2,1);
			$dre4= substr($drenaje, 3,1);
			$dre5= substr($drenaje, 4,1);
			
		}
		else{
			$dre1= 0;
			$dre2= 0;
			$dre3= 0;
			$dre4= 0;
			$dre5= 0;
		}
		$combustible=($rows['est_combust']);
		if (!empty($combustible)){
			$cb1= substr($combustible, 0,1);
			$cb2= substr($combustible, 1,1);
			$cb3= substr($combustible, 2,1);
		}
		else{
			$cb1= 0;
			$cb2= 0;
			$cb3= 0;
		}
		$combustible_det=($rows['est_combust_detalle']);
		$objetos1=($rows['est_objetos_casa1']);
		if (!empty($objetos1)){
			$internet= substr($objetos1, 0,1);
			$bicicleta= substr($objetos1, 1,1);
			$regadera= substr($objetos1, 2,1);
			$letrina= substr($objetos1, 3,1);
			$cisterna= substr($objetos1, 4,1);
			$refrigerador= substr($objetos1, 5,1);
			$parrilla= substr($objetos1, 6,1);
			$estufa= substr($objetos1, 7,1);
			$leña= substr($objetos1, 8,1);
			$tinaco= substr($objetos1, 9,1);
			$solar= substr($objetos1, 10,1);
			$boiler_combustible= substr($objetos1, 11,1);
		}
		else{
			$internet= 0;
			$bicicleta= 0;
			$regadera= 0;
			$letrina= 0;
			$cisterna= 0;
			$refrigerador= 0;
			$parrilla= 0;
			$estufa= 0;
			$leña= 0;
			$tinaco= 0;
			$solar= 0;
			$boiler_combustible= 0;
		}
		$objetos2=($rows['est_objetos_casa2']);
		if (!empty($objetos2)){
			$computadora= substr($objetos2, 0,1);
			$reproductor_mp3= substr($objetos2, 1,1);
			$boiler= substr($objetos2, 2,1);
			$tablet= substr($objetos2, 3,1);
			$laptop= substr($objetos2, 4,1);
			$microondas= substr($objetos2, 5,1);
			$grabadora= substr($objetos2, 6,1);
			$extractor= substr($objetos2, 7,1);
			$licuadora= substr($objetos2, 8,1);
			$plancha= substr($objetos2, 9,1);
			$lavadora= substr($objetos2, 10,1);
		}
		else{
			$computadora= 0;
			$reproductor_mp3= 0;
			$boiler= 0;
			$tablet= 0;
			$laptop= 0;
			$microondas= 0;
			$grabadora= 0;
			$extractor= 0;
			$licuadora= 0;
			$plancha= 0;
			$lavadora= 0;
		}
		$objetos3=($rows['est_objetos_casa3']);
		if (!empty($objetos3)){
			$secadora= substr($objetos3, 0,1);
			$radio= substr($objetos3, 1,1);
			$celular= substr($objetos3, 2,1);
			$dvd= substr($objetos3, 3,1);
			$television= substr($objetos3, 4,1);
			$telefono= substr($objetos3, 5,1);
			$videocasetera= substr($objetos3, 6,1);
			$moto= substr($objetos3, 7,1);
			$pantalla= substr($objetos3, 8,1);
			$servicio_paga= substr($objetos3, 9,1);
			$animales= substr($objetos3, 10,1);
		}
		else{
			$secadora= 0;
			$radio= 0;
			$celular= 0;
			$dvd= 0;
			$television= 0;
			$telefono= 0;
			$videocasetera= 0;
			$moto= 0;
			$pantalla= 0;
			$servicio_paga= 0;
			$animales= 0;
		}
		$auto=($rows['est_auto']);
		$auto_modelo=($rows['est_auto_modelo']);
		$auto_marca=($rows['est_auto_marca']);
		$mismo_domicilio=($rows['est_mismo_domicilio']);
		$prsn_cel=($rows['est_prsns_celular']);
		$cq_vive=($rows['est_cqvive']);
		if (!empty($cq_vive)){
			$cq_padre= substr($cq_vive, 0,1);
			$cq_madre= substr($cq_vive, 1,1);
			$cq_hermanos= substr($cq_vive, 2,1);
			$cq_pareja= substr($cq_vive, 3,1);
			$cq_familiar= substr($cq_vive, 4,1);
			$cq_solo= substr($cq_vive, 5,1);
			$cq_hijos= substr($cq_vive, 6,1);
			$cq_otro= substr($cq_vive, 7,1);
		}
		else{
			$cq_padre= 0;
			$cq_madre= 0;
			$cq_hermanos= 0;
			$cq_pareja= 0;
			$cq_familiar= 0;
			$cq_solo= 0;
			$cq_hijos= 0;
			$cq_otro= 0;
		}
		$cq_vive_otro=($rows['est_cqvive_otro']);
		$dependen_econ=($rows['est_depende_econo']);
		if (!empty($dependen_econ)){
			$de_padre= substr($dependen_econ, 0,1);
			$de_madre= substr($dependen_econ, 1,1);
			$de_hermanos= substr($dependen_econ, 2,1);
			$de_pareja= substr($dependen_econ, 3,1);
			$de_familiar= substr($dependen_econ, 4,1);
			$de_mismo= substr($dependen_econ, 5,1);
		}
		else{
			$de_padre= 0;
			$de_madre= 0;
			$de_hermanos= 0;
			$de_pareja= 0;
			$de_familiar= 0;
			$de_mismo= 0;
		}
		$np_viven_casa=($rows['est_no_prsns_vivienda']);
		$np_dependen_ingreso=($rows['est_np_depen_ingre']);
		$transporte=($rows['est_transporte']);
		if (!empty($transporte)){
			$autobus= substr($transporte, 0,1);
			$microbus= substr($transporte, 1,1);
			$combi= substr($transporte, 2,1);
			$taxi= substr($transporte, 3,1);
			$motocicleta= substr($transporte, 4,1);
			$bici= substr($transporte, 5,1);
			$auto_particular=substr($transporte, 6,1);
			$otro_transporte=substr($transporte, 7,1);
		}
		else{
			$autobus= 0;
			$microbus= 0;
			$combi= 0;
			$taxi= 0;
			$motocicleta= 0;
			$bici= 0;
			$auto_particular=0;
			$otro_transporte=0;
		}
		$otro_transporte_det=($rows['est_transporte_otro']);
		$horas=($rows['est_transporte_esc_hrs']);
		$minutos=($rows['est_transporte_esc_min']);
		$transporte_gasto=($rows['est_transporte_gasto']);
		$becas=($rows['est_becas']);
		$becas_det=($rows['est_becas_detalle']);
		$becas_utilidad=($rows['est_becas_utilidad']);
		if (!empty($becas_utilidad)){
			$colegiatura= substr($becas_utilidad, 0,1);
			$utiles= substr($becas_utilidad, 1,1);
			$transporte= substr($becas_utilidad, 2,1);
			$ayuda_gasto= substr($becas_utilidad, 3,1);
			$personales_gasto= substr($becas_utilidad, 4,1);
			$otra_utilidad= substr($becas_utilidad, 5,1);
		}
		else{
			$colegiatura= 0;
			$utiles= 0;
			$transporte= 0;
			$ayuda_gasto= 0;
			$personales_gasto= 0;
			$otra_utilidad= 0;
		}
		$becas_utilidad_otra=($rows['est_becas_utilidad_otra']);
		$hobby=($rows['est_hobby']);
		$lugares_frecuentes=($rows['est_lug_frecuentes']);
		$motivo_tec=($rows['est_motivo_inscripcion']);

		$query = "SELECT * from alumnos_datos_padres WHERE no_ficha='$no_ficha'";
		$resultado = $mysqli->query($query);
		$rows = mysqli_num_rows($resultado);
		$cont=1;
		while($rows=mysqli_fetch_array($resultado)){
			${"padre".$cont."_0"}=($rows['dp_padre_nombre']);
			${"padre".$cont."_1"}=($rows['dp_padre_vive']);
			${"padre".$cont."_2"}=($rows['dp_padre_fecnac']);
			${"padre".$cont."_3"}=($rows['dp_padre_ocup']);
			${"padre".$cont."_4"}=($rows['dp_padre_nivest']);
			${"padre".$cont."_5"}=($rows['dp_padre_domicilio']);
			${"padre".$cont."_6"}=($rows['dp_padre_colonia']);
			${"padre".$cont."_7"}=($rows['dp_padre_poblacion']);
			${"padre".$cont."_8"}=($rows['dp_padre_telparticular']);
			${"padre".$cont."_9"}=($rows['dp_padre_centro_trabajo']);
			${"padre".$cont."_10"}=($rows['dp_padre_teltrabajo']);
			${"padre".$cont."_11"}=($rows['dp_tutor']);
			${"padre".$cont."_12"}=($rows['dp_ausente']);
			$cont++;
		}
		$query = "SELECT * from alumnos_ingresos WHERE no_ficha='$no_ficha'";
		$resultado = $mysqli->query($query);
		$rows = mysqli_fetch_array($resultado);
		$ingreso_padre=($rows['est_ingreso_padre']);
		$ingreso_madre=($rows['est_ingreso_madre']);
		$ingreso_hermanos=($rows['est_ingreso_hermanos']);
		$ingreso_propio=($rows['est_ingreso_propio']);
		$ingreso_otros=($rows['est_ingreso_otros']);
		$ingreso_total=($rows['est_total_ingresos']);


	echo "
	<div class='contenedor-3'>
		<fieldset><legend><stroke>HIJOS</stroke></legend>
			<table width='675' border='0'>
				<tr>
					<td width='350'><ba>Hijos:</td>
					<td><ba>Edades:</td>
				</tr>
				<tr>
					<td>
						<input type='text' name='cant_hijos' id='cant_hijos' size='3' value= '$hijos_cant' disabled>
					</td>
					<td>
						<input type='text' name='edades_hijos' id='edades_hijos' size='15' value= '$hijos_det' disabled>
					</td>	
				</tr>									
			</table>
		</fieldset>								
		<fieldset><legend><stroke>MÉDICO</stroke></legend>
			<table>
				<tr>
					<td width='350'><ba>¿Discapacidad?</td>
					<td><ba>¿Enfermedades Crónicas?</td>
				</tr>
				<tr>
					<td>";
					if ($discapacidad==1){
						echo "
						<input type='radio' name='discapacidad' value='1' id='discapacidad' disabled checked><pp>SI
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type='radio' name='discapacidad' value='2' id='discapacidad' disabled><pp>NO";
					}
					else{
						echo "
						<input type='radio' name='discapacidad' value='1' id='discapacidad' disabled><pp>SI
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type='radio' name='discapacidad' value='2' id='discapacidad' disabled checked><pp>NO";
					}
					echo"	
					</td>
					<td>";
						if($enf_cronica==1){
							echo"
							<input type='radio' name='enf_cronicas' value='1' id='enf_cronicas' disabled checked><pp>SI
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type='radio' name='enf_cronicas' value='2' id='enf_cronicas' disabled><pp>NO";
						}
						else{
							echo"<input type='radio' name='enf_cronicas' value='1' id='enf_cronicas' disabled><pp>SI
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type='radio' name='enf_cronicas' value='2' id='enf_cronicas' disabled checked><pp>NO";
						}
						echo"
					</td>
				</tr>
				<tr>
					<td><ba>Detalle de Discapacidad:</td>
					<td><ba>Detalle de Enf. Crónicas:</td>
				</tr>
				<tr>
					<td>
						<textarea maxlength='150' rows='3' cols='33' name='detalle_discap' id='detalle_discap' placeholder='Descripción de discapacidad' disabled>$discapacidad_det</textarea>
					</td>
					<td>
						<textarea maxlength='150' rows='3' cols='33' name='detalle_discap' id='detalle_discap' placeholder='Descripción de enfermedades crónicas' disabled>$enf_cronica_det</textarea>
					</td>
				</tr>							
			</table>
			<table>
				<tr>
					<td><ba>¿Cuándo te enfermas acudes a?</td>										
				</tr>
			</table>
			<table>
				<tr>
					<td width='80'>
						<input type='checkbox' name='IMSS' value='1'";if ($imss==1){ echo " checked ";} echo" id='IMSS' disabled><pp>IMSS
					</td>
					<td width='100'>
						<input type='checkbox' name='ISSSTE' value='1'";if ($isste==1){ echo " checked ";} echo" id='ISSSTE' disabled><pp>ISSSTE
					</td>
					<td width='125'>
						<input type='checkbox' name='Salubridad' value='1'";if ($salubridad==1){ echo " checked ";} echo" id='Salubridad' disabled><pp>Salubridad
					</td>
					<td width='110'>
						<input type='checkbox' name='Particular' value='1'";if ($particular==1){ echo " checked ";} echo" id='Particular' disabled><pp>Particular
					</td>
				</tr>
			</table>
		</fieldset>	
		<fieldset><legend><stroke>PROCEDENCIA</stroke></legend>
			<table width='675' border='0'>
				<tr>
					<td><ba>Zona de Procedencia</td>
				</tr>
			</table>
			<table>
				<tr>";
					zona_proc($zona_procedencia);
				echo"</tr>
			</table>
			<table>
				<tr>
					<td><br><ba>Descripción de Etnia Indígena</td>
				</tr>
				<tr>
					<td>
						<textarea maxlength='50' rows='1' cols='50' name='detalle_indigena' id='detalle_indigena' disabled>$zona_procedencia_det</textarea>
					</td>
				</tr>
			</table>
		</fieldset>
		<fieldset><legend><stroke>BECA Y VIVIENDA</stroke></legend>
			<table>
				<tr>
					<td width='350'><ba>¿Familia con prospera?</td>
					<td><ba>¿La Casa donde vives es?</td>
				</tr>

				<tr>
					<td>";
						if($apoyo_prospera==1){
						echo"<input type='radio' name='prospera' value='1' id='prospera' disabled checked><pp>SI
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type='radio' name='prospera' value='2' id='prospera' disabled><pp>NO";
						}
						else{
							echo"<input type='radio' name='prospera' value='1' id='prospera' disabled ><pp>SI
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type='radio' name='prospera' value='2' id='prospera' disabled checked><pp>NO";
						}
					echo"</td>
					<td>";											
						vivienda($vivienda);	
					echo"</td>
					</td>
				</tr>
				
				<tr>
					<td><ba>Material de construcción de <br>la vivienda:</td>
					<td valign='top'><ba>Material del techo de vivienda:<br></td>
				</tr>

				<tr>
					<td>
						<textarea maxlength='50' rows='2' cols='33' name='material_vivienda' id='material_vivienda' disabled>$material_vivienda</textarea>
					</td>
					<td>
						<textarea maxlength='50' rows='2' cols='33	' name='material_techo' id='material_techo' disabled>$material_techo</textarea>
					</td>
				</tr>
				<tr>
					<td>
						<input type='text' name='cuartos' id='cuartos' size='3' value='$cuartos' disabled style='text-align:right;'><ba> Cuartos </ba><pp>(comedor, sala, etc)
					</td>
					<td>
						<input type='text' name='baños' id='baños' size='3' value='$baños' disabled style='text-align:right;'><ba> Baños
					</td>
				</tr>
			</table>
			<table width='675'>
				<tr>
					<td><ba>Agua para beber:</td>
					<td><ba>La vivienda tiene:</td>
				</tr>
				<tr>
					<td>
						<input type='checkbox' name='pozo' value='1'";if ($ab1==1){ echo " checked ";} echo" id='pozo' disabled><pp>Pozo <br>
						<input type='checkbox' name='garrafon' value='1'";if ($ab2==1){ echo " checked ";} echo" id='garrafon' disabled><pp>Garrafón <br>
						<input type='checkbox' name='agua_pipa' value='1'";if ($ab3==1){ echo " checked ";} echo" id='agua_pipa' disabled><pp>Agua de pipa <br>
						<input type='checkbox' name='agua_hervida' value='1'";if ($ab4==1){ echo " checked ";} echo" id='agua_hervida' disabled><pp>Agua hervida <br>
						<input type='checkbox' name='llave_fuera' value='1'";if ($ab5==1){ echo " checked ";} echo" id='llave_fuera' disabled><pp>Agua de la llave fuera de la vivienda <br>
						<input type='checkbox' name='llave_dentro' value='1'";if ($ab6==1){ echo " checked ";} echo" id='llave_dentro' disabled><pp>Agua de la llave dentro de la vivienda
					</td>
					<td>
						<input type='checkbox' name='agua_de_pipa' value='1'";if ($av1==1){ echo " checked ";} echo" id='agua_de_pipa' disabled><pp>Agua de pipa <br>
						<input type='checkbox' name='llave_publica' value='1'";if ($av2==1){ echo " checked ";} echo" id='llave_publica' disabled><pp>Agua de la llave pública <br>
						<input type='checkbox' name='agua_rio' value='1'";if ($av3==1){ echo " checked ";} echo" id='agua_rio' disabled><pp>Agua de pozo, rio, arroyo <br>
						<input type='checkbox' name='agua_otra_vivienda' value='1'";if ($av4==1){ echo " checked ";} echo" id='agua_otra_vivienda' disabled><pp>Agua entubada de otra vivienda <br>
						<input type='checkbox' name='agua_entubada_fuera' value='1'";if ($av5==1){ echo " checked ";} echo" id='agua_entubada_fuera' disabled><pp>Agua entubada fuera de la vivienda <br>
						<input type='checkbox' name='agua_entubada_dentro' value='1'";if ($av6==1){ echo " checked ";} echo" id='agua_entubada_dentro' disabled><pp>Agua entubada dentro de la vivienda
					</td>
				</tr>
				<tr>
					<td><ba><ba>Pago bimestral de luz:</td>
					
				</tr>
				<tr>
					<td>
						<input type='text' size='5' name='bimestre_luz' id='bimestre_luz' value='$pago_luz' disabled style='text-align:right;'><pp>.00 MXN
					</td>
					
				</tr>
				<tr>
					<td><ba>Drenaje o desagüe:</td>
					<td><ba>Combustible para cocinar:</td>
				</tr>
				<tr>
					<td>
						<input type='radio' name='red_publica' ";if ($dre1==1){ echo " checked ";} echo" id='red_publica' disabled><pp>Red pública <br>
						<input type='radio' name='fosa' ";if ($dre2==1){ echo " checked ";} echo" id='fosa' disabled><pp>Fosa séptica <br>		
						<input type='radio' name='sin_drenaje' ";if ($dre3==1){ echo " checked ";} echo" id='sin_drenaje' disabled><pp>No tiene drenaje <br>
						<input type='radio' name='tuberia_barranco' ";if ($dre4==1){ echo " checked ";} echo" id='tuberia_barranco' disabled><pp>Tubería que da barranco o grieta <br>
						<input type='radio' name='tuberia_rio' ";if ($dre5==1){ echo " checked ";} echo" id='tuberia_rio' disabled><pp>Tubería que da a rio, arroyo o lago <br>
						</td>
					<td>
						<input type='checkbox' name='leña' ";if ($cb1==1){ echo " checked ";} echo" id='leña' disabled><pp>Leña <br>
						<input type='checkbox' name='carbon' ";if ($cb2==1){ echo " checked ";} echo" id='carbon' disabled><pp>Carbón <br>
						<input type='checkbox' name='gas' ";if ($cb3==1){ echo " checked ";} echo" id='gas' disabled><pp>Gas de cilindro o estacionario <br>
						<textarea maxlength='40' rows='2' cols='30' name='otro_combustible' id='otro_combustible' placeholder='Descripción otro combustible' disabled>$combustible_det</textarea>								
					</td>
				</tr>
			</table>
		</fieldset>
		<fieldset>
			<legend><stroke>ELECTRODOMÉSTICOS Y MÁS</stroke></legend>
			<table width='675' border='0'>
				<tr>
					<td width='225'>
						<input type='checkbox' name='internet' value='1'";if ($internet==1){ echo " checked ";} echo"  id='internet' disabled><b>Internet
					</td>
					<td width='225'>
						<input type='checkbox' name='bicicleta' value='1'";if ($bicicleta==1){ echo " checked ";} echo" id='bicicleta' disabled><b>Bicicleta
					</td>
					<td>
						<input type='checkbox' name='regadera' value='1'";if ($regadera==1){ echo " checked ";} echo" id='regadera' disabled><b>Regadera
					</td>									
				</tr>
				<tr>
					<td width='225'>
						<input type='checkbox' name='letrina' value='1'";if ($letrina==1){ echo " checked ";} echo" id='letrina' disabled><b>Letrina
					</td>
					<td width='225'>
						<input type='checkbox' name='cisterna' value='1'";if ($cisterna==1){ echo " checked ";} echo" id='cisterna' disabled><b>Cisterna o aljibe
					</td>
					<td >
						<input type='checkbox' name='refrigerador'";if ($refrigerador==1){ echo " checked ";} echo" value='1' id='refrigerador' disabled><b>Refrigerador
					</td>									
				</tr>
				<tr>
					<td width='225'>
						<input type='checkbox' name='estufa' value='1'";if ($parrilla==1){ echo " checked ";} echo" id='estufa' disabled><b>Estufa o parrilla eléctrica
					</td>
					<td width='225'>
						<input type='checkbox' name='estufa_gas' value='1'";if ($estufa==1){ echo " checked ";} echo" id='estufa_gas' disabled><b>Estufa de gas
					</td>
					<td >
						<input type='checkbox' name='estufa_leña' value='1'";if ($leña==1){ echo " checked ";} echo" id='estufa_leña' disabled><b>Estufa de leña
					</td>									
				</tr>
				<tr>
					<td width='225'>
						<input type='checkbox' name='tinaco' value='1'";if ($tinaco==1){ echo " checked ";} echo" id='tinaco' disabled><b>Tinaco
					</td>
					<td width='225'>
						<input type='checkbox' name='calentador_solar' value='1'";if ($solar==1){ echo " checked ";} echo" id='calentador_solar' disabled><b>Calentador solar
					</td>
					<td >
						<input type='checkbox' name='boiler_combustible' value='1'";if ($boiler_combustible==1){ echo " checked ";} echo" id='boiler_combustible' disabled><b>Boiler de combustible
					</td>									
				</tr>
				<tr>
					<td width='225' valign='top'>
						<input type='checkbox' name='computadora' value='1'";if ($computadora==1){ echo " checked ";} echo" id='computadora' disabled><b>Computadora de escritorio
					</td>
					<td width='225'>
						<input type='checkbox' name='reproductor_mp3' value='1'";if ($reproductor_mp3==1){ echo " checked ";} echo" id='reproductor_mp3' disabled><b>iPod o reproductor de música
					</td>
					<td >
						<input type='checkbox' name='boiler' value='1'";if ($boiler==1){ echo " checked ";} echo" id='boiler' disabled><b>Calentador de agua (Boiler)
					</td>									
				</tr>
				<tr>
					<td width='225'>
						<input type='checkbox' name='tablet' value='1'";if ($tablet==1){ echo " checked ";} echo" id='tablet' disabled><b>iPad o tablet
					</td>
					<td width='225'>
						<input type='checkbox' name='laptop' value='1'";if ($laptop==1){ echo " checked ";} echo" id='laptop' disabled><b>Laptop
					</td>
					<td>
						<input type='checkbox' name='horno' value='1'";if ($microondas==1){ echo " checked ";} echo" id='horno' disabled><b>Horno de microondas
					</td>									
				</tr>
				<tr>
					<td width='225'>
						<input type='checkbox' name='grabadora' value='1'";if ($grabadora==1){ echo " checked ";} echo" id='grabadora' disabled><b>Grabadora
					</td>
					<td width='225'>
						<input type='checkbox' name='extractor' value='1'";if ($extractor==1){ echo " checked ";} echo" id='extractor' disabled><b>Extractor de jugos
					</td>
					<td >
						<input type='checkbox' name='licuadora' value='1'";if ($licuadora==1){ echo " checked ";} echo" id='licuadora' disabled><b>Licuadora
					</td>									
				</tr>
				<tr>
					<td width='225'>
						<input type='checkbox' name='plancha' value='1'";if ($plancha==1){ echo " checked ";} echo" id='plancha' disabled><b>Plancha
					</td>
					<td width='225'>
						<input type='checkbox' name='lavadora' value='1'";if ($lavadora==1){ echo " checked ";} echo" id='lavadora' disabled><b>Lavadora
					</td>
					<td >
						<input type='checkbox' name='secadora' value='1'";if ($secadora==1){ echo " checked ";} echo" id='secadora' disabled><b>Secadora
					</td>									
				</tr>
				<tr>
					<td width='225'>
						<input type='checkbox' name='radio' value='1'";if ($radio==1){ echo " checked ";} echo" id='radio' disabled><b>Radio
					</td>
					<td width='225'>
						<input type='checkbox' name='celular' value='1'";if ($celular==1){ echo " checked ";} echo" id='celular' disabled><b>Celular
					</td>
					<td >
						<input type='checkbox' name='dvd' value='1'";if ($dvd==1){ echo " checked ";} echo" id='dvd' disabled><b>Reproductor Dvd
					</td>									
				</tr>
				<tr>
					<td width='225'>
						<input type='checkbox' name='television' value='1'";if ($television==1){ echo " checked ";} echo" id='television' disabled><b>Televisión
					</td>
					<td width='225'>
						<input type='checkbox' name='telefono' value='1'";if ($telefono==1){ echo " checked ";} echo" id='telefono' disabled><b>Teléfono
					</td>
					<td >
						<input type='checkbox' name='videocasetera' value='1'";if ($videocasetera==1){ echo " checked ";} echo" id='videocasetera' disabled><b>Videocasetera
					</td>									
				</tr>
				<tr>
					<td width='225'>
						<input type='checkbox' name='moto' value='1'";if ($moto==1){ echo " checked ";} echo" id='moto' disabled><b>Motocicleta, motoneta y/o cuatrimoto
					</td>
					<td width='225'>
						<input type='checkbox' name='pantalla' value='1'";if ($pantalla==1){ echo " checked ";} echo" id='pantalla' disabled><b>Pantalla plana (Plasma, LCD, LED, etc.)
					</td>
					<td>
						<input type='checkbox' name='servicio_paga' value='1'";if ($servicio_paga==1){ echo " checked ";} echo" id='servicio_paga' disabled><b>Servicio de televisión de paga (Sky, Telecable, etc.)
					</td>									
				</tr>
				<tr>
					<td width='225'>
						<input type='checkbox' name='animales' value='1'";if ($animales==1){ echo " checked ";} echo" id='animales' disabled><b>Animales de granja (Caballos, puercos, gallinas, etc.) <br> <br> <br>
					</td>
					<td width='225'>
						<input type='checkbox' name='auto' value='1'";if ($auto==1){ echo " checked ";} echo" id='auto' disabled><b>Auto <br>
						<input type='text' name='marca' id='marca' placeholder='Marca de auto' value='$auto_marca' disabled>
						<input type='text' name='modelo' id='modelo' placeholder='Modelo de auto' value='$auto_modelo' disabled>		
					</td>
				</tr>
			</table>
		</fieldset>
		<fieldset><legend><stroke>FAMILIA</stroke></legend>
			<table width='675' border='0'>
				<tr>
					<td>
						<ba>¿El domicilio donde radicas mientras estudias es el mismo donde vive tu familia?</ba>
					</td>
					<td>
						<ba>¿Cuántas personas de tu hogar, incluyéndote, cuentan con teléfono celular? </ba>
					</td>
				</tr>
				<tr>
					<td>";
					if ($mismo_domicilio==1){
						echo"
						<input type='radio' name='mismo_domicilio' value='1' id='mismo_domicilio' disabled checked><pp>SI &nbsp;&nbsp;&nbsp;&nbsp;
						<input type='radio' name='mismo_domicilio' value='0' id='mismo_domicilio' disabled><pp>NO";
					}
					else{
						echo"
						<input type='radio' name='mismo_domicilio' value='1' id='mismo_domicilio' disabled><pp>SI &nbsp;&nbsp;&nbsp;&nbsp;
						<input type='radio' name='mismo_domicilio' value='0' id='mismo_domicilio' disabled checked><pp>NO";
					}
					echo"	
					</td>
					<td><input type='text' name='personas_con_cel' style='text-align:right;' id='personas_con_cel' size='2' disabled value='$prsn_cel'><pp>Personas</pp></td>
				</tr>
				<tr>
					<td><ba>¿Con quién vives actualmente?</td>
				</tr>
			</table>
			<table width='675'>
				<tr>
					<td width='225'>
						<input type='checkbox' name='padre' value='1'";if ($cq_padre==1){ echo " checked ";} echo" id='padre' disabled><pp>Padre
					</td>
					<td width='225'>
						<input type='checkbox' name='madre' value='1'";if ($cq_madre==1){ echo " checked ";} echo" id='madre' disabled><pp>Madre
					</td>
					<td >
						<input type='checkbox' name='hermanos' value='1'";if ($cq_hermanos==1){ echo " checked ";} echo" id='hermanos' disabled><pp>Hermanos
					</td>	
				</tr>
				<tr>
					<td width='225'>
						<input type='checkbox' name='pareja' value='1'";if ($cq_pareja==1){ echo " checked ";} echo" id='pareja' disabled><pp>Cónyuge o pareja
					</td>
					<td width='225'>
						<input type='checkbox' name='otro_familiar' value='1'";if ($cq_familiar==1){ echo " checked ";} echo" id='otro_familiar' disabled><pp>Otro Familiar
					</td>
					<td >
						<input type='checkbox' name='solo' value='1'";if ($cq_solo==1){ echo " checked ";} echo" id='solo' disabled><pp>Solo
					</td>	
				</tr>
			</table>
			<table width='675'>
				<tr>
					<td width='225'>
						<input type='checkbox' name='hijos' value='1'";if ($cq_hijos==1){ echo " checked ";} echo" id='hijos' disabled><pp>Hijos
					</td>
					<td>
						<input type='checkbox' name='otro' value='1'";if ($cq_otro==1){ echo " checked ";} echo" id='otro' disabled><pp>Otro &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type='text' size='25' name='otro' value='$cq_vive_otro' id='otro' disabled placeholder='Descripción de otro conocido'>
					</td>
				</tr>
			</table>
			<table>
				<tr>
					<td><ba>Dependes económicamende de:</td>
				</tr>
			</table>
			<table width='675'>
				<tr>
					<td width='225'>
						<input type='checkbox' name='padre_eco' value='1'";if ($de_padre==1){ echo " checked ";} echo" id='padre_eco' disabled><pp>Padre
					</td>
					<td width='225'>
						<input type='checkbox' name='madre_eco' value='1'";if ($de_madre==1){ echo " checked ";} echo" id='madre_eco' disabled><pp>Madre
					</td>
					<td>
						<input type='checkbox' name='hermanos_eco' value='1'";if ($de_hermanos==1){ echo " checked ";} echo" id='hermanos_eco' disabled><pp>Hermanos
					</td>
				</tr>
				<tr>
					<td width='225'>
						<input type='checkbox' name='pareja_eco' value='1'";if ($de_pareja==1){ echo " checked ";} echo" id='pareja_eco' disabled><pp>Cónyuge o pareja
					</td>
					<td width='225'>
						<input type='checkbox' name='otro_eco' value='1'";if ($de_familiar==1){ echo " checked ";} echo" id='otro_eco' disabled><pp>Otro familiar
					</td>
					<td>
						<input type='checkbox' name='yo_mismo' value='1'";if ($de_mismo==1){ echo " checked ";} echo" id='yo_mismo' disabled><pp>Yo mismo
					</td>
				</tr>
				<tr>
					<td width='225'><ba>Viven en tu casa:</td>
					<td><ba>Dependen del ingreso:</td>
				</tr>
				<tr>
					<td width='225'>
						<input type='text' size='2' name='viven_casa' value='$np_viven_casa' id='viven_casa' disabled style='text-align:right;' ><pp>Personas
					</td>
					<td>
						<input type='text' name='dependen_eco' size='2' value='$np_dependen_ingreso' id='dependen_eco' disabled style='text-align:right;' ><pp>Personas
					</td>										
				</tr>
			</table>
		</fieldset>
	</div>
	<div class='contenedor-4'>";
		if(isset($padre1_0)){
			echo"
		<fieldset><legend><stroke>DATOS PADRE</stroke></legend>
			<table width='675' border='0'>
				<tr>
					<td width='480'><ba>Nombre completo:</td>
					<td><ba>Vive:</td>
			 	</tr>
				<tr>
					<td>
						<input type='text' size='47' name='nombre_padre' value='$padre1_0' id='nombre_padre' disabled>
					</td>
					<td>";
					if ($padre1_1==1){
						echo"
						<input type='radio' name='vive_padre' id='vive_padre' disabled checked><pp>SI</pp> &nbsp;&nbsp;
						<input type='radio' name='vive_padre' id='vive_padre' disabled><pp>NO<br>
						<input type='checkbox' name='ausente_padre' id='ausente_padre' ";if ($padre1_12==1){ echo " checked ";} echo" disabled>Ausente
						<input type='checkbox' name='tutor_padre' id='tutor_padre' ";if ($padre1_11==1){ echo " checked ";} echo" disabled>Tutor</pp>";
					}
					else{
						echo"
						<input type='radio' name='vive_padre' id='vive_padre' disabled><pp>SI</pp> &nbsp;&nbsp;
						<input type='radio' name='vive_padre' id='vive_padre' disabled checked><pp>NO<br>
						<input type='checkbox' name='ausente_padre' id='ausente_padre' ";if ($padre1_12==1){ echo " checked ";} echo" disabled>Ausente
						<input type='checkbox' name='tutor_padre' id='tutor_padre' ";if ($padre1_11==1){ echo " checked ";} echo" disabled>Tutor</pp>";
					}
					echo"	
					</td>		
				</tr>
			</table>
			<table>
				<tr>
					<td width='480'><ba>Ocupación:</td>
					<td><ba>Fecha de Nac:</td>
				</tr>
				<tr>
					<td>
						<input type='text' size='47' name='ocupacion_padre' value='$padre1_3' id='ocupacion_padre' disabled>
					</td>
					<td>
						<input type='text' size='10' name='fecha_nac_padre' value='$padre1_2' id='fecha_nac_padre' disabled>
					</td>
				</tr>
			</table>
			<table>
				<tr>
					<td><ba>Escolaridad:</td>
				</tr>
				<tr>
					<td>
						<input type='text' size='50' name='escolaridad_padre' value='$padre1_4' id='escolaridad_padre' disabled>
					</td>
				</tr>
				<tr>
					<td><ba>Domicilio:</td>
				</tr>
				<tr>
					<td>
						<input type='text' size='60' name='domicilio_padre' value='$padre1_5' id='domicilio_padre' disabled>
					</td>
				</tr>
			</table>
			<table>
				<tr>
					<td width='400'><ba>Colonia:</td>
					<td><ba>Teléfono particular:</td>
				</tr>
				<tr>
					<td>
						<input type='text' size='30' name='colonia_padre' value='$padre1_6' id='colonia_padre' disabled>
					</td>
					<td>
						<input type='text' size='10' name='tel_particular_padre' value='$padre1_8' id='tel_particular_padre' disabled>
					</td>
				</tr>
				<tr>
					<td><ba>Población:</td>
					<td><ba>Teléfono de trabajo:</td>
				</tr>
				<tr>
					<td>
						<input type='text' size='30' name='poblacion_padre' value='$padre1_7' id='poblacion_padre' disabled>
					</td>
					<td>
						<input type='text' size='10' name='tel_trabajo_padre' value='$padre1_10' id='tel_trabajo_padre' disabled>
					</td>
				</tr>
			</table>
			<table>
				<tr>
					<td><ba>Centro de trabajo:</td>
				</tr>
				<tr>
					<td>
						<input type='text' size='50' name='trabajo_padre' value='$padre1_9' id='trabajo_padre' disabled>
					</td>
				</tr>
			</table>
		</fieldset>";
		}
		if(isset($padre2_0)){
			echo"
		
		<fieldset><legend><stroke>DATOS MADRE</stroke></legend>
			<table width='675' border='0'>
				<tr>
					<td width='480'><ba>Nombre completo:</td>
					<td><ba>Vive:</td>
			 	</tr>
				<tr>
					<td>
						<input type='text' size='47' name='nombre_madre' value='$padre2_0' id='nombre_madre' disabled>
					</td>
					<td>";
					if ($padre2_1==1){
						echo"
						<input type='radio' name='vive_madre' id='vive_madre' value='1' disabled checked><pp>SI</pp> &nbsp;&nbsp;
						<input type='radio' name='vive_madre' id='vive_madre' disabled><pp>NO<br>
						<input type='checkbox' name='ausente_madre' id='ausente_madre' ";if ($padre2_12==1){ echo " checked ";} echo" disabled>Ausente
						<input type='checkbox' name='tutor_madre' id='tutor_madre' ";if ($padre2_11==1){ echo " checked ";} echo" disabled>Tutor</pp>";
					}
					else{
						echo"
						<input type='radio' name='vive_madre' id='vive_madre' disabled><pp>SI</pp> &nbsp;&nbsp;
						<input type='radio' name='vive_madre' id='vive_madre' value='1' disabled checked><pp>NO<br>
						<input type='checkbox' name='ausente_madre' id='ausente_madre' ";if ($padre2_12==1){ echo " checked ";} echo" disabled>Ausente
						<input type='checkbox' name='tutor_madre' id='tutor_madre' ";if ($padre2_11==1){ echo " checked ";} echo" disabled>Tutor</pp>";
					}
					echo"	
					</td>	
				</tr>
			</table>
			<table>
				<tr>
					<td width='480'><ba>Ocupación:</td>
					<td><ba>Fecha de Nac:</td>
				</tr>
				<tr>
					<td>
						<input type='text' size='47' name='ocupacion_madre' value='$padre2_3' id='ocupacion_madre' disabled>
					</td>
					<td>
						<input type='text' size='10' name='fecha_nac_madre' value='$padre2_2' id='fecha_nac_madre' disabled>
					</td>
				</tr>
			</table>
			<table>
				<tr>
					<td><ba>Escolaridad:</td>
				</tr>
				<tr>
					<td>
						<input type='text' size='50' name='escolaridad_madre' value='$padre2_4' id='escolaridad_madre' disabled>
					</td>
				</tr>
				<tr>
					<td><ba>Domicilio:</td>
				</tr>
				<tr>
					<td>
						<input type='text' size='60' name='domicilio_madre' value='$padre2_5' id='domicilio_madre' disabled>
					</td>
				</tr>
			</table>
			<table>
				<tr>
					<td width='400'><ba>Colonia:</td>
					<td><ba>Teléfono particular:</td>
				</tr>
				<tr>
					<td>
						<input type='text' size='30' name='colonia_madre' value='$padre2_6' id='colonia_madre' disabled>
					</td>
					<td>
						<input type='text' size='10' name='tel_particular_madre' value='$padre2_8' id='tel_particular_madre' disabled>
					</td>
				</tr>
				<tr>
					<td><ba>Población:</td>
					<td><ba>Teléfono de trabajo:</td>
				</tr>
				<tr>
					<td>
						<input type='text' size='30' name='poblacion_madre' value='$padre2_7' id='poblacion_madre' disabled>
					</td>
					<td>
						<input type='text' size='10' name='tel_trabajo_madre' value='$padre2_10' id='tel_trabajo_madre' disabled>
					</td>
				</tr>
			</table>
			<table>
				<tr>
					<td><ba>Centro de trabajo:</td>
				</tr>
				<tr>
					<td>
						<input type='text' size='50' name='trabajo_madre' value='$padre2_9' id='trabajo_madre' disabled>
					</td>
				</tr>
			</table>
		</fieldset>";
		}
		echo"<fieldset><legend><stroke>INGRESOS Y TRANSPORTE</stroke></legend>
			<table width='675' border='0'>
				<tr>
					<td><ba>¿Cuáles son los ingresos mensuales familiares?</td>
				</tr>
			</table>
			<table width='675' border='0'>
				<tr>
					<td width='80'>
						<ba>Padre:</ba>
					</td>
					<td>
						<input type='text' size='4' value='$ingreso_padre' name='ingreso_padre' id='ingreso_padre' disabled maxlength='6'>
					</td>
					<td width='80'>
						<ba>Madre:</ba>
					</td>
					<td>
						<input type='text' size='4' value='$ingreso_madre' name='ingreso_madre' id='ingreso_madre' disabled maxlength='6'>
					</td>
					<td width='80'>
						<ba>Hermanos:</ba>
					</td>
					<td>
						<input type='text' size='4' value='$ingreso_hermanos' name='ingreso_hermanos' id='ingreso_hermanos' disabled maxlength='6'>
					</td>
				</tr>
				<tr>
					<td width='80'><ba>Propios:</ba></td>
					<td>
						<input type='text' size='4' value='$ingreso_propio' name='ingreso_propio' id='ingreso_propio' disabled maxlength='6'>
					</td>
					<td width='80'><ba>Otros:</ba></td>
					<td>
						<input type='text' size='4' value='$ingreso_otros' name='ingreso_otros' id='ingreso_otros' disabled maxlength='6'>
					</td>
					<td width='80'><ba>Total:</ba></td>
					<td>
						<input type='text' size='4' value='$ingreso_total' name='ingreso_total' id='ingreso_total' disabled maxlength='6'>
					
					</td>
				</tr>
			</table><br>
			<table width='675' border='0'>
				<tr>
					<td><ba>¿Cuáles son los principales medios de transporte que utilizas para trasladarte a la institución donde estudias?</ba>
					</td>
				</tr>
			</table>
			<table width='675' border='0'>
				<tr>
					<td width='200'><input type='checkbox' name='medio_transporte' id='medio_transporte' disabled ";if ($autobus==1){ echo " checked ";} echo"><pp>Autobús</pp></td>					
					<td width='200'><input type='checkbox' name='medio_transporte' id='medio_transporte' disabled ";if ($microbus==1){ echo " checked ";} echo"><pp>Microbús</pp></td>					
					<td><input type='checkbox' name='medio_transporte' id='medio_transporte' disabled ";if ($combi==1){ echo " checked ";} echo"><pp>Combi</pp></td>					
				</tr>
				<tr>
					<td width='200'><input type='checkbox' name='medio_transporte' id='medio_transporte' disabled ";if ($taxi==1){ echo " checked ";} echo"><pp>Taxi</pp></td>					
					<td><input type='checkbox' name='medio_transporte' id='medio_transporte' disabled ";if ($motocicleta==1){ echo " checked ";} echo"><pp>Motocicleta</pp></td>					
					<td><input type='checkbox' name='medio_transporte' id='medio_transporte' disabled ";if ($bici==1){ echo " checked ";} echo"><pp>Bicicleta</pp></td>	
				</tr>
			</table>
			<table width='675'>
				<tr>
					<td width='200'><input type='checkbox' name='medio_transporte' id='medio_transporte' disabled ";if ($auto_particular==1){ echo " checked ";} echo"><pp>Auto Particular</pp></td>					
					<td><input type='checkbox' name='medio_transporte' id='medio_transporte' disabled ";if ($otro_transporte==1){ echo " checked ";} echo"><pp>Otro</pp>"; if ($otro_transporte==1){
						echo"<pp>:</pp><input type='text' size='30' maxlength='30' name='otro_transporte' id='otro_transporte' disabled value='$otro_transporte_det'>";}
						echo"
					</td>	
				</tr>
			</table>
			<br>
			<table width='675'>
				<tr>
					<td width='365'><ba>¿Cuánto tiempo tardas en llegar desde tu vivienda a tu universidad?</ba></td>
					<td><ba>Normalmente, ¿cuánto gastas al día en transporte?</ba></td>
				</tr>
				<tr>
					<td>
						<input type='number' name='transporte_horas' id='transporte_horas' size='2' min='0' max='12' disabled value='$horas' style='text-align:right;'><pp>Horas</pp>
						<input type='number' name='transporte_minutos' id='transporte_minutos' size='2' min='0' max='59' disabled value='$minutos' style='text-align:right;'><pp>Minutos</pp></td>
					<td>
						<pp><input type='text' name='gasto_transporte' id='gasto_transporte' size='3' disabled value='$transporte_gasto' style='text-align:right;'>.00MXN</pp>
					</td>
				</tr>
			</table>
		</fieldset>
		<fieldset><legend><stroke>BECA Y HOBBIES</stroke></legend>
			<table width='675'>
				<tr>
					<td>
						<ba>¿Cuentas con algún tipo de beca?</ba>
					</td>
					<td><ba>Si tienes beca, ¿para qué te sirve?</ba><br></td>
				</tr>
				<tr>
					<td valign='top'>";
					if($becas==1){
						echo"
						<input type='radio' name='cuenta_con_beca' value='1' id='cuenta_con_beca' disabled checked><pp>SI</pp>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type='radio' name='cuenta_con_beca' value='2' id='cuenta_con_beca' disabled><pp>NO</pp><br>
						<pp>¿Cuáles?</pp>
						<br><textarea maxlength='200' rows='3' cols='33' name='beca_descripcion' id='beca_descripcion' disabled>$becas_det</textarea>";
					}
					else{
						echo"
						<input type='radio' name='cuenta_con_beca' value='1' id='cuenta_con_beca' disabled checked><pp>SI</pp>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type='radio' name='cuenta_con_beca' value='2' id='cuenta_con_beca' disabled checked><pp>NO</pp><br>";
					}
					echo"	
					</td>
					<td>
						<input type='checkbox' name='utilidad_beca' value='1' id='utilidad_beca' disabled ";if ($colegiatura==1){ echo " checked ";} echo"><pp>Pago de colegiatura</pp><br>
						<input type='checkbox' name='utilidad_beca' value='1' id='utilidad_beca' disabled ";if ($utiles==1){ echo " checked ";} echo"><pp>Pago de útiles escolares</pp><br>
						<input type='checkbox' name='utilidad_beca' value='1' id='utilidad_beca' disabled ";if ($transporte==1){ echo " checked ";} echo"><pp>Pago de transporte a institución</pp><br>
						<input type='checkbox' name='utilidad_beca' value='1' id='utilidad_beca' disabled ";if ($ayuda_gasto==1){ echo " checked ";} echo"><pp>Ayuda gasto familiar</pp><br>
						<input type='checkbox' name='utilidad_beca' value='1' id='utilidad_beca' disabled ";if ($personales_gasto==1){ echo " checked ";} echo"><pp>Gastos personales</pp><br>
						<input type='checkbox' name='utilidad_beca' value='1' id='utilidad_beca' disabled ";if ($otra_utilidad==1){ echo " checked ";} echo"><pp>Otros</pp>";
						if($otra_utilidad==1){
						echo"<pp>:</pp><br><textarea maxlength='100' rows='3' cols='33' name='beca_otra_utilidad' id='beca_otra_utilidad' disabled>$becas_utilidad_otra</textarea>";
						}
					echo"</td>
				</tr>
				<tr>
					<td><ba>¿Qué haces en tus ratos libres?</ba></td>
					<td><ba>¿Qué lugares frecuentas?</ba></td>
				</tr>
				<tr>
					<td>
						<textarea maxlength='200' rows='3' cols='33' name='hobby' id='hobby' disabled>$hobby</textarea>
					</td>
					<td>
						<textarea maxlength='200' rows='3' cols='33' name='lugares' id='lugares' disabled>$lugares_frecuentes</textarea>
					</td>
				</tr>
			</table>
			<table width='675'>	
				<tr>
					<td><ba>¿Qué te motivó a inscribirte en el tecnológico?</ba></td>
				</tr>
				<tr>
					<td><textarea maxlength='200' rows='3' cols='80' name='motivo_tec' id='motivo_tec' disabled>$motivo_tec</textarea></td>
				</tr>
			</table>
		</fieldset>";
		familiares($no_ficha);
	echo"</div>";
	}
}

	function estudio_se_2($ficha){

	require '../../conexion/conex_mysql.php';
	$no_ficha= $ficha;
	$mysqli = new mysqli ($hostname,$username,$password,$database);
	if ($mysqli->connect_errno){
		die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
	}

	$query = "SELECT * from alumnos_folio WHERE no_ficha='$no_ficha'";
	$resultado = $mysqli->query($query);
	$rows = mysqli_fetch_array($resultado);
	$est_se1=$rows['f_est_soc_econ1'];
	$est_se2=$rows['f_est_soc_econ2'];
	$est_se3=$rows['f_est_soc_econ3'];

	if ($est_se1==1 AND $est_se2==1 AND $est_se3==1){
		$query = "SELECT * from alumnos_estudio_se WHERE no_ficha='$no_ficha'";
		$resultado = $mysqli->query($query);
		$rows = mysqli_fetch_array($resultado);
		$hijos_cant=($rows['est_hijos_cant']);
		$hijos_det=($rows['est_hijos_detalle']);
		$discapacidad=($rows['est_discap']);
		$discapacidad_det=($rows['est_discap_detalle']);
		$enf_cronica=($rows['est_enf_cron']);
		$enf_cronica_det=($rows['est_enf_cron_detalle']);
		$consulta_med=($rows['est_consulta_med']);
		if (!empty($consulta_med)){
			$imss= substr($consulta_med, 0,1);
			$isste= substr($consulta_med, 1,1);
			$salubridad = substr($consulta_med, 2,1);
			$particular = substr($consulta_med, 3,1);
		}
		else{
			$imss= 0;
			$isste= 0;
			$salubridad = 0;
			$particular = 0;
		}
	
		$zona_procedencia=($rows['est_zona_proc']);
		$zona_procedencia_det=($rows['est_zona_proc_detalle']);
		$apoyo_prospera=($rows['est_apoyo_prospera']);
		$vivienda=($rows['est_vivienda']);
		$material_vivienda=($rows['est_material_vivienda']);
		$material_techo=($rows['est_material_techo']);
		$cuartos=($rows['est_no_cuartos']);
		$baños=($rows['est_no_banios']);
		$agua_beber=($rows['est_agua_beber']);
		if (!empty($agua_beber)){
			$ab1= substr($agua_beber, 0,1);
			$ab2= substr($agua_beber, 1,1);
			$ab3= substr($agua_beber, 2,1);
			$ab4= substr($agua_beber, 3,1);
			$ab5= substr($agua_beber, 4,1);
			$ab6= substr($agua_beber, 5,1);
		}
		else{
			$ab1= 0;
			$ab2= 0;
			$ab3= 0;
			$ab4= 0;
			$ab5= 0;
			$ab6= 0;
		}
		$agua_vivienda=($rows['est_agua_vivienda']);
		if (!empty($agua_vivienda)){
			$av1= substr($agua_vivienda, 0,1);
			$av2= substr($agua_vivienda, 1,1);
			$av3= substr($agua_vivienda, 2,1);
			$av4= substr($agua_vivienda, 3,1);
			$av5= substr($agua_vivienda, 4,1);
			$av6= substr($agua_vivienda, 5,1);
		}
		else{
			$av1= 0;
			$av2= 0;
			$av3= 0;
			$av4= 0;
			$av5= 0;
			$av6= 0;
		}
		$pago_luz=($rows['est_gasto_luz']);
		$drenaje=($rows['est_drenaje']);
		if (!empty($drenaje)){
			$dre1= substr($drenaje, 0,1);
			$dre2= substr($drenaje, 1,1);
			$dre3= substr($drenaje, 2,1);
			$dre4= substr($drenaje, 3,1);
			$dre5= substr($drenaje, 4,1);
			
		}
		else{
			$dre1= 0;
			$dre2= 0;
			$dre3= 0;
			$dre4= 0;
			$dre5= 0;
		}
		$combustible=($rows['est_combust']);
		if (!empty($combustible)){
			$cb1= substr($combustible, 0,1);
			$cb2= substr($combustible, 1,1);
			$cb3= substr($combustible, 2,1);
		}
		else{
			$cb1= 0;
			$cb2= 0;
			$cb3= 0;
		}
		$combustible_det=($rows['est_combust_detalle']);
		$objetos1=($rows['est_objetos_casa1']);
		if (!empty($objetos1)){
			$internet= substr($objetos1, 0,1);
			$bicicleta= substr($objetos1, 1,1);
			$regadera= substr($objetos1, 2,1);
			$letrina= substr($objetos1, 3,1);
			$cisterna= substr($objetos1, 4,1);
			$refrigerador= substr($objetos1, 5,1);
			$parrilla= substr($objetos1, 6,1);
			$estufa= substr($objetos1, 7,1);
			$leña= substr($objetos1, 8,1);
			$tinaco= substr($objetos1, 9,1);
			$solar= substr($objetos1, 10,1);
			$boiler_combustible= substr($objetos1, 11,1);
		}
		else{
			$internet= 0;
			$bicicleta= 0;
			$regadera= 0;
			$letrina= 0;
			$cisterna= 0;
			$refrigerador= 0;
			$parrilla= 0;
			$estufa= 0;
			$leña= 0;
			$tinaco= 0;
			$solar= 0;
			$boiler_combustible= 0;
		}
		$objetos2=($rows['est_objetos_casa2']);
		if (!empty($objetos2)){
			$computadora= substr($objetos2, 0,1);
			$reproductor_mp3= substr($objetos2, 1,1);
			$boiler= substr($objetos2, 2,1);
			$tablet= substr($objetos2, 3,1);
			$laptop= substr($objetos2, 4,1);
			$microondas= substr($objetos2, 5,1);
			$grabadora= substr($objetos2, 6,1);
			$extractor= substr($objetos2, 7,1);
			$licuadora= substr($objetos2, 8,1);
			$plancha= substr($objetos2, 9,1);
			$lavadora= substr($objetos2, 10,1);
		}
		else{
			$computadora= 0;
			$reproductor_mp3= 0;
			$boiler= 0;
			$tablet= 0;
			$laptop= 0;
			$microondas= 0;
			$grabadora= 0;
			$extractor= 0;
			$licuadora= 0;
			$plancha= 0;
			$lavadora= 0;
		}
		$objetos3=($rows['est_objetos_casa3']);
		if (!empty($objetos3)){
			$secadora= substr($objetos3, 0,1);
			$radio= substr($objetos3, 1,1);
			$celular= substr($objetos3, 2,1);
			$dvd= substr($objetos3, 3,1);
			$television= substr($objetos3, 4,1);
			$telefono= substr($objetos3, 5,1);
			$videocasetera= substr($objetos3, 6,1);
			$moto= substr($objetos3, 7,1);
			$pantalla= substr($objetos3, 8,1);
			$servicio_paga= substr($objetos3, 9,1);
			$animales= substr($objetos3, 10,1);
		}
		else{
			$secadora= 0;
			$radio= 0;
			$celular= 0;
			$dvd= 0;
			$television= 0;
			$telefono= 0;
			$videocasetera= 0;
			$moto= 0;
			$pantalla= 0;
			$servicio_paga= 0;
			$animales= 0;
		}
		$auto=($rows['est_auto']);
		$auto_modelo=($rows['est_auto_modelo']);
		$auto_marca=($rows['est_auto_marca']);
		$mismo_domicilio=($rows['est_mismo_domicilio']);
		$prsn_cel=($rows['est_prsns_celular']);
		$cq_vive=($rows['est_cqvive']);
		if (!empty($cq_vive)){
			$cq_padre= substr($cq_vive, 0,1);
			$cq_madre= substr($cq_vive, 1,1);
			$cq_hermanos= substr($cq_vive, 2,1);
			$cq_pareja= substr($cq_vive, 3,1);
			$cq_familiar= substr($cq_vive, 4,1);
			$cq_solo= substr($cq_vive, 5,1);
			$cq_hijos= substr($cq_vive, 6,1);
			$cq_otro= substr($cq_vive, 7,1);
		}
		else{
			$cq_padre= 0;
			$cq_madre= 0;
			$cq_hermanos= 0;
			$cq_pareja= 0;
			$cq_familiar= 0;
			$cq_solo= 0;
			$cq_hijos= 0;
			$cq_otro= 0;
		}
		$cq_vive_otro=($rows['est_cqvive_otro']);
		$dependen_econ=($rows['est_depende_econo']);
		if (!empty($dependen_econ)){
			$de_padre= substr($dependen_econ, 0,1);
			$de_madre= substr($dependen_econ, 1,1);
			$de_hermanos= substr($dependen_econ, 2,1);
			$de_pareja= substr($dependen_econ, 3,1);
			$de_familiar= substr($dependen_econ, 4,1);
			$de_mismo= substr($dependen_econ, 5,1);
		}
		else{
			$de_padre= 0;
			$de_madre= 0;
			$de_hermanos= 0;
			$de_pareja= 0;
			$de_familiar= 0;
			$de_mismo= 0;
		}
		$np_viven_casa=($rows['est_no_prsns_vivienda']);
		$np_dependen_ingreso=($rows['est_np_depen_ingre']);
		$transporte=($rows['est_transporte']);
		if (!empty($transporte)){
			$autobus= substr($transporte, 0,1);
			$microbus= substr($transporte, 1,1);
			$combi= substr($transporte, 2,1);
			$taxi= substr($transporte, 3,1);
			$motocicleta= substr($transporte, 4,1);
			$bici= substr($transporte, 5,1);
			$auto_particular=substr($transporte, 6,1);
			$otro_transporte=substr($transporte, 7,1);
		}
		else{
			$autobus= 0;
			$microbus= 0;
			$combi= 0;
			$taxi= 0;
			$motocicleta= 0;
			$bici= 0;
			$auto_particular=0;
			$otro_transporte=0;
		}
		$otro_transporte_det=($rows['est_transporte_otro']);
		$horas=($rows['est_transporte_esc_hrs']);
		$minutos=($rows['est_transporte_esc_min']);
		$transporte_gasto=($rows['est_transporte_gasto']);
		$becas=($rows['est_becas']);
		$becas_det=($rows['est_becas_detalle']);
		$becas_utilidad=($rows['est_becas_utilidad']);
		if (!empty($becas_utilidad)){
			$colegiatura= substr($becas_utilidad, 0,1);
			$utiles= substr($becas_utilidad, 1,1);
			$transporte= substr($becas_utilidad, 2,1);
			$ayuda_gasto= substr($becas_utilidad, 3,1);
			$personales_gasto= substr($becas_utilidad, 4,1);
			$otra_utilidad= substr($becas_utilidad, 5,1);
		}
		else{
			$colegiatura= 0;
			$utiles= 0;
			$transporte= 0;
			$ayuda_gasto= 0;
			$personales_gasto= 0;
			$otra_utilidad= 0;
		}
		$becas_utilidad_otra=($rows['est_becas_utilidad_otra']);
		$hobby=($rows['est_hobby']);
		$lugares_frecuentes=($rows['est_lug_frecuentes']);
		$motivo_tec=($rows['est_motivo_inscripcion']);

		$query = "SELECT * from alumnos_datos_padres WHERE no_ficha='$no_ficha'";
		$resultado = $mysqli->query($query);
		$rows = mysqli_num_rows($resultado);
		$cont=1;
		while($rows=mysqli_fetch_array($resultado)){
			${"padre".$cont."_0"}=($rows['dp_padre_nombre']);
			${"padre".$cont."_1"}=($rows['dp_padre_vive']);
			${"padre".$cont."_2"}=($rows['dp_padre_fecnac']);
			${"padre".$cont."_3"}=($rows['dp_padre_ocup']);
			${"padre".$cont."_4"}=($rows['dp_padre_nivest']);
			${"padre".$cont."_5"}=($rows['dp_padre_domicilio']);
			${"padre".$cont."_6"}=($rows['dp_padre_colonia']);
			${"padre".$cont."_7"}=($rows['dp_padre_poblacion']);
			${"padre".$cont."_8"}=($rows['dp_padre_telparticular']);
			${"padre".$cont."_9"}=($rows['dp_padre_centro_trabajo']);
			${"padre".$cont."_10"}=($rows['dp_padre_teltrabajo']);
			${"padre".$cont."_11"}=($rows['dp_tutor']);
			${"padre".$cont."_12"}=($rows['dp_ausente']);
			$cont++;
		}
		$query = "SELECT * from alumnos_ingresos WHERE no_ficha='$no_ficha'";
		$resultado = $mysqli->query($query);
		$rows = mysqli_fetch_array($resultado);
		$ingreso_padre=($rows['est_ingreso_padre']);
		$ingreso_madre=($rows['est_ingreso_madre']);
		$ingreso_hermanos=($rows['est_ingreso_hermanos']);
		$ingreso_propio=($rows['est_ingreso_propio']);
		$ingreso_otros=($rows['est_ingreso_otros']);
		$ingreso_total=($rows['est_total_ingresos']);


	echo "
	<div class='contenedor-3'>
		<fieldset><legend><stroke>HIJOS</stroke></legend>
			<table width='675' border='0'>
				<tr>
					<td width='350'><ba>Hijos:</td>
					<td><ba>Edades:</td>
				</tr>
				<tr>
					<td>
						<input type='text' name='cant_hijos' id='cant_hijos' size='3' value= '$hijos_cant' disabled>
					</td>
					<td>
						<input type='text' name='edades_hijos' id='edades_hijos' size='15' value= '$hijos_det' disabled>
					</td>	
				</tr>									
			</table>
		</fieldset>								
		<fieldset><legend><stroke>MÉDICO</stroke></legend>
			<table>
				<tr>
					<td width='350'><ba>¿Discapacidad?</td>
					<td><ba>¿Enfermedades Crónicas?</td>
				</tr>
				<tr>
					<td>";
					if ($discapacidad==1){
						echo "
						<input type='radio' name='discapacidad' value='1' id='discapacidad' disabled checked><pp>SI
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type='radio' name='discapacidad' value='2' id='discapacidad' disabled><pp>NO";
					}
					else{
						echo "
						<input type='radio' name='discapacidad' value='1' id='discapacidad' disabled><pp>SI
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type='radio' name='discapacidad' value='2' id='discapacidad' disabled checked><pp>NO";
					}
					echo"	
					</td>
					<td>";
						if($enf_cronica==1){
							echo"
							<input type='radio' name='enf_cronicas' value='1' id='enf_cronicas' disabled checked><pp>SI
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type='radio' name='enf_cronicas' value='2' id='enf_cronicas' disabled><pp>NO";
						}
						else{
							echo"<input type='radio' name='enf_cronicas' value='1' id='enf_cronicas' disabled><pp>SI
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type='radio' name='enf_cronicas' value='2' id='enf_cronicas' disabled checked><pp>NO";
						}
						echo"
					</td>
				</tr>
				<tr>
					<td><ba>Detalle de Discapacidad:</td>
					<td><ba>Detalle de Enf. Crónicas:</td>
				</tr>
				<tr>
					<td>
						<textarea maxlength='150' rows='3' cols='33' name='detalle_discap' id='detalle_discap' placeholder='Descripción de discapacidad' disabled>$discapacidad_det</textarea>
					</td>
					<td>
						<textarea maxlength='150' rows='3' cols='33' name='detalle_discap' id='detalle_discap' placeholder='Descripción de enfermedades crónicas' disabled>$enf_cronica_det</textarea>
					</td>
				</tr>							
			</table>
			<table>
				<tr>
					<td><ba>¿Cuándo te enfermas acudes a?</td>										
				</tr>
			</table>
			<table>
				<tr>
					<td width='80'>
						<input type='checkbox' name='IMSS' value='1'";if ($imss==1){ echo " checked ";} echo" id='IMSS' disabled><pp>IMSS
					</td>
					<td width='100'>
						<input type='checkbox' name='ISSSTE' value='1'";if ($isste==1){ echo " checked ";} echo" id='ISSSTE' disabled><pp>ISSSTE
					</td>
					<td width='125'>
						<input type='checkbox' name='Salubridad' value='1'";if ($salubridad==1){ echo " checked ";} echo" id='Salubridad' disabled><pp>Salubridad
					</td>
					<td width='110'>
						<input type='checkbox' name='Particular' value='1'";if ($particular==1){ echo " checked ";} echo" id='Particular' disabled><pp>Particular
					</td>
				</tr>
			</table>
		</fieldset>	
		<fieldset><legend><stroke>PROCEDENCIA</stroke></legend>
			<table width='675' border='0'>
				<tr>
					<td><ba>Zona de Procedencia</td>
				</tr>
			</table>
			<table>
				<tr>";
					zona_proc($zona_procedencia);
				echo"</tr>
			</table>
			<table>
				<tr>
					<td><br><ba>Descripción de Etnia Indígena</td>
				</tr>
				<tr>
					<td>
						<textarea maxlength='50' rows='1' cols='50' name='detalle_indigena' id='detalle_indigena' disabled>$zona_procedencia_det</textarea>
					</td>
				</tr>
			</table>
		</fieldset>
		<fieldset><legend><stroke>BECA Y VIVIENDA</stroke></legend>
			<table>
				<tr>
					<td width='350'><ba>¿Familia con prospera?</td>
					<td><ba>¿La Casa donde vives es?</td>
				</tr>

				<tr>
					<td>";
						if($apoyo_prospera==1){
						echo"<input type='radio' name='prospera' value='1' id='prospera' disabled checked><pp>SI
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type='radio' name='prospera' value='2' id='prospera' disabled><pp>NO";
						}
						else{
							echo"<input type='radio' name='prospera' value='1' id='prospera' disabled ><pp>SI
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type='radio' name='prospera' value='2' id='prospera' disabled checked><pp>NO";
						}
					echo"</td>
					<td>";											
						vivienda($vivienda);	
					echo"</td>
					</td>
				</tr>
				
				<tr>
					<td><ba>Material de construcción de <br>la vivienda:</td>
					<td valign='top'><ba>Material del techo de vivienda:<br></td>
				</tr>

				<tr>
					<td>
						<textarea maxlength='50' rows='2' cols='33' name='material_vivienda' id='material_vivienda' disabled>$material_vivienda</textarea>
					</td>
					<td>
						<textarea maxlength='50' rows='2' cols='33	' name='material_techo' id='material_techo' disabled>$material_techo</textarea>
					</td>
				</tr>
				<tr>
					<td>
						<input type='text' name='cuartos' id='cuartos' size='3' value='$cuartos' disabled style='text-align:right;'><ba> Cuartos </ba><pp>(comedor, sala, etc)
					</td>
					<td>
						<input type='text' name='baños' id='baños' size='3' value='$baños' disabled style='text-align:right;'><ba> Baños
					</td>
				</tr>
			</table>
			<table width='675'>
				<tr>
					<td><ba>Agua para beber:</td>
					<td><ba>La vivienda tiene:</td>
				</tr>
				<tr>
					<td>
						<input type='checkbox' name='pozo' value='1'";if ($ab1==1){ echo " checked ";} echo" id='pozo' disabled><pp>Pozo <br>
						<input type='checkbox' name='garrafon' value='1'";if ($ab2==1){ echo " checked ";} echo" id='garrafon' disabled><pp>Garrafón <br>
						<input type='checkbox' name='agua_pipa' value='1'";if ($ab3==1){ echo " checked ";} echo" id='agua_pipa' disabled><pp>Agua de pipa <br>
						<input type='checkbox' name='agua_hervida' value='1'";if ($ab4==1){ echo " checked ";} echo" id='agua_hervida' disabled><pp>Agua hervida <br>
						<input type='checkbox' name='llave_fuera' value='1'";if ($ab5==1){ echo " checked ";} echo" id='llave_fuera' disabled><pp>Agua de la llave fuera de la vivienda <br>
						<input type='checkbox' name='llave_dentro' value='1'";if ($ab6==1){ echo " checked ";} echo" id='llave_dentro' disabled><pp>Agua de la llave dentro de la vivienda
					</td>
					<td>
						<input type='checkbox' name='agua_de_pipa' value='1'";if ($av1==1){ echo " checked ";} echo" id='agua_de_pipa' disabled><pp>Agua de pipa <br>
						<input type='checkbox' name='llave_publica' value='1'";if ($av2==1){ echo " checked ";} echo" id='llave_publica' disabled><pp>Agua de la llave pública <br>
						<input type='checkbox' name='agua_rio' value='1'";if ($av3==1){ echo " checked ";} echo" id='agua_rio' disabled><pp>Agua de pozo, rio, arroyo <br>
						<input type='checkbox' name='agua_otra_vivienda' value='1'";if ($av4==1){ echo " checked ";} echo" id='agua_otra_vivienda' disabled><pp>Agua entubada de otra vivienda <br>
						<input type='checkbox' name='agua_entubada_fuera' value='1'";if ($av5==1){ echo " checked ";} echo" id='agua_entubada_fuera' disabled><pp>Agua entubada fuera de la vivienda <br>
						<input type='checkbox' name='agua_entubada_dentro' value='1'";if ($av6==1){ echo " checked ";} echo" id='agua_entubada_dentro' disabled><pp>Agua entubada dentro de la vivienda
					</td>
				</tr>
				<tr>
					<td><ba><ba>Pago bimestral de luz:</td>
					
				</tr>
				<tr>
					<td>
						<input type='text' size='5' name='bimestre_luz' id='bimestre_luz' value='$pago_luz' disabled style='text-align:right;'><pp>.00 MXN
					</td>
					
				</tr>
				<tr>
					<td><ba>Drenaje o desagüe:</td>
					<td><ba>Combustible para cocinar:</td>
				</tr>
				<tr>
					<td>
						<input type='radio' name='red_publica' ";if ($dre1==1){ echo " checked ";} echo" id='red_publica' disabled><pp>Red pública <br>
						<input type='radio' name='fosa' ";if ($dre2==1){ echo " checked ";} echo" id='fosa' disabled><pp>Fosa séptica <br>		
						<input type='radio' name='sin_drenaje' ";if ($dre3==1){ echo " checked ";} echo" id='sin_drenaje' disabled><pp>No tiene drenaje <br>
						<input type='radio' name='tuberia_barranco' ";if ($dre4==1){ echo " checked ";} echo" id='tuberia_barranco' disabled><pp>Tubería que da barranco o grieta <br>
						<input type='radio' name='tuberia_rio' ";if ($dre5==1){ echo " checked ";} echo" id='tuberia_rio' disabled><pp>Tubería que da a rio, arroyo o lago <br>
						</td>
					<td>
						<input type='checkbox' name='leña' ";if ($cb1==1){ echo " checked ";} echo" id='leña' disabled><pp>Leña <br>
						<input type='checkbox' name='carbon' ";if ($cb2==1){ echo " checked ";} echo" id='carbon' disabled><pp>Carbón <br>
						<input type='checkbox' name='gas' ";if ($cb3==1){ echo " checked ";} echo" id='gas' disabled><pp>Gas de cilindro o estacionario <br>
						<textarea maxlength='40' rows='2' cols='30' name='otro_combustible' id='otro_combustible' placeholder='Descripción otro combustible' disabled>$combustible_det</textarea>								
					</td>
				</tr>
			</table>
		</fieldset>
		<fieldset>
			<legend><stroke>ELECTRODOMÉSTICOS Y MÁS</stroke></legend>
			<table width='675' border='0'>
				<tr>
					<td width='225'>
						<input type='checkbox' name='internet' value='1'";if ($internet==1){ echo " checked ";} echo"  id='internet' disabled><b>Internet
					</td>
					<td width='225'>
						<input type='checkbox' name='bicicleta' value='1'";if ($bicicleta==1){ echo " checked ";} echo" id='bicicleta' disabled><b>Bicicleta
					</td>
					<td>
						<input type='checkbox' name='regadera' value='1'";if ($regadera==1){ echo " checked ";} echo" id='regadera' disabled><b>Regadera
					</td>									
				</tr>
				<tr>
					<td width='225'>
						<input type='checkbox' name='letrina' value='1'";if ($letrina==1){ echo " checked ";} echo" id='letrina' disabled><b>Letrina
					</td>
					<td width='225'>
						<input type='checkbox' name='cisterna' value='1'";if ($cisterna==1){ echo " checked ";} echo" id='cisterna' disabled><b>Cisterna o aljibe
					</td>
					<td >
						<input type='checkbox' name='refrigerador'";if ($refrigerador==1){ echo " checked ";} echo" value='1' id='refrigerador' disabled><b>Refrigerador
					</td>									
				</tr>
				<tr>
					<td width='225'>
						<input type='checkbox' name='estufa' value='1'";if ($parrilla==1){ echo " checked ";} echo" id='estufa' disabled><b>Estufa o parrilla eléctrica
					</td>
					<td width='225'>
						<input type='checkbox' name='estufa_gas' value='1'";if ($estufa==1){ echo " checked ";} echo" id='estufa_gas' disabled><b>Estufa de gas
					</td>
					<td >
						<input type='checkbox' name='estufa_leña' value='1'";if ($leña==1){ echo " checked ";} echo" id='estufa_leña' disabled><b>Estufa de leña
					</td>									
				</tr>
				<tr>
					<td width='225'>
						<input type='checkbox' name='tinaco' value='1'";if ($tinaco==1){ echo " checked ";} echo" id='tinaco' disabled><b>Tinaco
					</td>
					<td width='225'>
						<input type='checkbox' name='calentador_solar' value='1'";if ($solar==1){ echo " checked ";} echo" id='calentador_solar' disabled><b>Calentador solar
					</td>
					<td >
						<input type='checkbox' name='boiler_combustible' value='1'";if ($boiler_combustible==1){ echo " checked ";} echo" id='boiler_combustible' disabled><b>Boiler de combustible
					</td>									
				</tr>
				<tr>
					<td width='225' valign='top'>
						<input type='checkbox' name='computadora' value='1'";if ($computadora==1){ echo " checked ";} echo" id='computadora' disabled><b>Computadora de escritorio
					</td>
					<td width='225'>
						<input type='checkbox' name='reproductor_mp3' value='1'";if ($reproductor_mp3==1){ echo " checked ";} echo" id='reproductor_mp3' disabled><b>iPod o reproductor de música
					</td>
					<td >
						<input type='checkbox' name='boiler' value='1'";if ($boiler==1){ echo " checked ";} echo" id='boiler' disabled><b>Calentador de agua (Boiler)
					</td>									
				</tr>
				<tr>
					<td width='225'>
						<input type='checkbox' name='tablet' value='1'";if ($tablet==1){ echo " checked ";} echo" id='tablet' disabled><b>iPad o tablet
					</td>
					<td width='225'>
						<input type='checkbox' name='laptop' value='1'";if ($laptop==1){ echo " checked ";} echo" id='laptop' disabled><b>Laptop
					</td>
					<td>
						<input type='checkbox' name='horno' value='1'";if ($microondas==1){ echo " checked ";} echo" id='horno' disabled><b>Horno de microondas
					</td>									
				</tr>
				<tr>
					<td width='225'>
						<input type='checkbox' name='grabadora' value='1'";if ($grabadora==1){ echo " checked ";} echo" id='grabadora' disabled><b>Grabadora
					</td>
					<td width='225'>
						<input type='checkbox' name='extractor' value='1'";if ($extractor==1){ echo " checked ";} echo" id='extractor' disabled><b>Extractor de jugos
					</td>
					<td >
						<input type='checkbox' name='licuadora' value='1'";if ($licuadora==1){ echo " checked ";} echo" id='licuadora' disabled><b>Licuadora
					</td>									
				</tr>
				<tr>
					<td width='225'>
						<input type='checkbox' name='plancha' value='1'";if ($plancha==1){ echo " checked ";} echo" id='plancha' disabled><b>Plancha
					</td>
					<td width='225'>
						<input type='checkbox' name='lavadora' value='1'";if ($lavadora==1){ echo " checked ";} echo" id='lavadora' disabled><b>Lavadora
					</td>
					<td >
						<input type='checkbox' name='secadora' value='1'";if ($secadora==1){ echo " checked ";} echo" id='secadora' disabled><b>Secadora
					</td>									
				</tr>
				<tr>
					<td width='225'>
						<input type='checkbox' name='radio' value='1'";if ($radio==1){ echo " checked ";} echo" id='radio' disabled><b>Radio
					</td>
					<td width='225'>
						<input type='checkbox' name='celular' value='1'";if ($celular==1){ echo " checked ";} echo" id='celular' disabled><b>Celular
					</td>
					<td >
						<input type='checkbox' name='dvd' value='1'";if ($dvd==1){ echo " checked ";} echo" id='dvd' disabled><b>Reproductor Dvd
					</td>									
				</tr>
				<tr>
					<td width='225'>
						<input type='checkbox' name='television' value='1'";if ($television==1){ echo " checked ";} echo" id='television' disabled><b>Televisión
					</td>
					<td width='225'>
						<input type='checkbox' name='telefono' value='1'";if ($telefono==1){ echo " checked ";} echo" id='telefono' disabled><b>Teléfono
					</td>
					<td >
						<input type='checkbox' name='videocasetera' value='1'";if ($videocasetera==1){ echo " checked ";} echo" id='videocasetera' disabled><b>Videocasetera
					</td>									
				</tr>
				<tr>
					<td width='225'>
						<input type='checkbox' name='moto' value='1'";if ($moto==1){ echo " checked ";} echo" id='moto' disabled><b>Motocicleta, motoneta y/o cuatrimoto
					</td>
					<td width='225'>
						<input type='checkbox' name='pantalla' value='1'";if ($pantalla==1){ echo " checked ";} echo" id='pantalla' disabled><b>Pantalla plana (Plasma, LCD, LED, etc.)
					</td>
					<td>
						<input type='checkbox' name='servicio_paga' value='1'";if ($servicio_paga==1){ echo " checked ";} echo" id='servicio_paga' disabled><b>Servicio de televisión de paga (Sky, Telecable, etc.)
					</td>									
				</tr>
				<tr>
					<td width='225'>
						<input type='checkbox' name='animales' value='1'";if ($animales==1){ echo " checked ";} echo" id='animales' disabled><b>Animales de granja (Caballos, puercos, gallinas, etc.) <br> <br> <br>
					</td>
					<td width='225'>
						<input type='checkbox' name='auto' value='1'";if ($auto==1){ echo " checked ";} echo" id='auto' disabled><b>Auto <br>
						<input type='text' name='marca' id='marca' placeholder='Marca de auto' value='$auto_marca' disabled>
						<input type='text' name='modelo' id='modelo' placeholder='Modelo de auto' value='$auto_modelo' disabled>		
					</td>
				</tr>
			</table>
		</fieldset>
		<fieldset><legend><stroke>FAMILIA</stroke></legend>
			<table width='675' border='0'>
				<tr>
					<td>
						<ba>¿El domicilio donde radicas mientras estudias es el mismo donde vive tu familia?</ba>
					</td>
					<td>
						<ba>¿Cuántas personas de tu hogar, incluyéndote, cuentan con teléfono celular? </ba>
					</td>
				</tr>
				<tr>
					<td>";
					if ($mismo_domicilio==1){
						echo"
						<input type='radio' name='mismo_domicilio' value='1' id='mismo_domicilio' disabled checked><pp>SI &nbsp;&nbsp;&nbsp;&nbsp;
						<input type='radio' name='mismo_domicilio' value='0' id='mismo_domicilio' disabled><pp>NO";
					}
					else{
						echo"
						<input type='radio' name='mismo_domicilio' value='1' id='mismo_domicilio' disabled><pp>SI &nbsp;&nbsp;&nbsp;&nbsp;
						<input type='radio' name='mismo_domicilio' value='0' id='mismo_domicilio' disabled checked><pp>NO";
					}
					echo"	
					</td>
					<td><input type='text' name='personas_con_cel' style='text-align:right;' id='personas_con_cel' size='2' disabled value='$prsn_cel'><pp>Personas</pp></td>
				</tr>
				<tr>
					<td><ba>¿Con quién vives actualmente?</td>
				</tr>
			</table>
			<table width='675'>
				<tr>
					<td width='225'>
						<input type='checkbox' name='padre' value='1'";if ($cq_padre==1){ echo " checked ";} echo" id='padre' disabled><pp>Padre
					</td>
					<td width='225'>
						<input type='checkbox' name='madre' value='1'";if ($cq_madre==1){ echo " checked ";} echo" id='madre' disabled><pp>Madre
					</td>
					<td >
						<input type='checkbox' name='hermanos' value='1'";if ($cq_hermanos==1){ echo " checked ";} echo" id='hermanos' disabled><pp>Hermanos
					</td>	
				</tr>
				<tr>
					<td width='225'>
						<input type='checkbox' name='pareja' value='1'";if ($cq_pareja==1){ echo " checked ";} echo" id='pareja' disabled><pp>Cónyuge o pareja
					</td>
					<td width='225'>
						<input type='checkbox' name='otro_familiar' value='1'";if ($cq_familiar==1){ echo " checked ";} echo" id='otro_familiar' disabled><pp>Otro Familiar
					</td>
					<td >
						<input type='checkbox' name='solo' value='1'";if ($cq_solo==1){ echo " checked ";} echo" id='solo' disabled><pp>Solo
					</td>	
				</tr>
			</table>
			<table width='675'>
				<tr>
					<td width='225'>
						<input type='checkbox' name='hijos' value='1'";if ($cq_hijos==1){ echo " checked ";} echo" id='hijos' disabled><pp>Hijos
					</td>
					<td>
						<input type='checkbox' name='otro' value='1'";if ($cq_otro==1){ echo " checked ";} echo" id='otro' disabled><pp>Otro &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type='text' size='25' name='otro' value='$cq_vive_otro' id='otro' disabled placeholder='Descripción de otro conocido'>
					</td>
				</tr>
			</table>
			<table>
				<tr>
					<td><ba>Dependes económicamende de:</td>
				</tr>
			</table>
			<table width='675'>
				<tr>
					<td width='225'>
						<input type='checkbox' name='padre_eco' value='1'";if ($de_padre==1){ echo " checked ";} echo" id='padre_eco' disabled><pp>Padre
					</td>
					<td width='225'>
						<input type='checkbox' name='madre_eco' value='1'";if ($de_madre==1){ echo " checked ";} echo" id='madre_eco' disabled><pp>Madre
					</td>
					<td>
						<input type='checkbox' name='hermanos_eco' value='1'";if ($de_hermanos==1){ echo " checked ";} echo" id='hermanos_eco' disabled><pp>Hermanos
					</td>
				</tr>
				<tr>
					<td width='225'>
						<input type='checkbox' name='pareja_eco' value='1'";if ($de_pareja==1){ echo " checked ";} echo" id='pareja_eco' disabled><pp>Cónyuge o pareja
					</td>
					<td width='225'>
						<input type='checkbox' name='otro_eco' value='1'";if ($de_familiar==1){ echo " checked ";} echo" id='otro_eco' disabled><pp>Otro familiar
					</td>
					<td>
						<input type='checkbox' name='yo_mismo' value='1'";if ($de_mismo==1){ echo " checked ";} echo" id='yo_mismo' disabled><pp>Yo mismo
					</td>
				</tr>
				<tr>
					<td width='225'><ba>Viven en tu casa:</td>
					<td><ba>Dependen del ingreso:</td>
				</tr>
				<tr>
					<td width='225'>
						<input type='text' size='2' name='viven_casa' value='$np_viven_casa' id='viven_casa' disabled style='text-align:right;' ><pp>Personas
					</td>
					<td>
						<input type='text' name='dependen_eco' size='2' value='$np_dependen_ingreso' id='dependen_eco' disabled style='text-align:right;' ><pp>Personas
					</td>										
				</tr>
			</table>
		</fieldset>
	</div>
	<div class='contenedor-4'>";
		if(isset($padre1_0)){
			echo"
		<fieldset><legend><stroke>DATOS PADRE</stroke></legend>
			<table width='675' border='0'>
				<tr>
					<td width='480'><ba>Nombre completo:</td>
					<td><ba>Vive:</td>
			 	</tr>
				<tr>
					<td>
						<input type='text' size='47' name='nombre_padre' value='$padre1_0' id='nombre_padre' disabled>
					</td>
					<td>";
					if ($padre1_1==1){
						echo"
						<input type='radio' name='vive_padre' id='vive_padre' disabled checked><pp>SI</pp> &nbsp;&nbsp;
						<input type='radio' name='vive_padre' id='vive_padre' disabled><pp>NO<br>
						<input type='checkbox' name='ausente_padre' id='ausente_padre' ";if ($padre1_12==1){ echo " checked ";} echo" disabled>Ausente
						<input type='checkbox' name='tutor_padre' id='tutor_padre' ";if ($padre1_11==1){ echo " checked ";} echo" disabled>Tutor</pp>";
					}
					else{
						echo"
						<input type='radio' name='vive_padre' id='vive_padre' disabled><pp>SI</pp> &nbsp;&nbsp;
						<input type='radio' name='vive_padre' id='vive_padre' disabled checked><pp>NO<br>
						<input type='checkbox' name='ausente_padre' id='ausente_padre' ";if ($padre1_12==1){ echo " checked ";} echo" disabled>Ausente
						<input type='checkbox' name='tutor_padre' id='tutor_padre' ";if ($padre1_11==1){ echo " checked ";} echo" disabled>Tutor</pp>";
					}
					echo"	
					</td>		
				</tr>
			</table>
			<table>
				<tr>
					<td width='480'><ba>Ocupación:</td>
					<td><ba>Fecha de Nac:</td>
				</tr>
				<tr>
					<td>
						<input type='text' size='47' name='ocupacion_padre' value='$padre1_3' id='ocupacion_padre' disabled>
					</td>
					<td>
						<input type='text' size='10' name='fecha_nac_padre' value='$padre1_2' id='fecha_nac_padre' disabled>
					</td>
				</tr>
			</table>
			<table>
				<tr>
					<td><ba>Escolaridad:</td>
				</tr>
				<tr>
					<td>
						<input type='text' size='50' name='escolaridad_padre' value='$padre1_4' id='escolaridad_padre' disabled>
					</td>
				</tr>
				<tr>
					<td><ba>Domicilio:</td>
				</tr>
				<tr>
					<td>
						<input type='text' size='60' name='domicilio_padre' value='$padre1_5' id='domicilio_padre' disabled>
					</td>
				</tr>
			</table>
			<table>
				<tr>
					<td width='400'><ba>Colonia:</td>
					<td><ba>Teléfono particular:</td>
				</tr>
				<tr>
					<td>
						<input type='text' size='30' name='colonia_padre' value='$padre1_6' id='colonia_padre' disabled>
					</td>
					<td>
						<input type='text' size='10' name='tel_particular_padre' value='$padre1_8' id='tel_particular_padre' disabled>
					</td>
				</tr>
				<tr>
					<td><ba>Población:</td>
					<td><ba>Teléfono de trabajo:</td>
				</tr>
				<tr>
					<td>
						<input type='text' size='30' name='poblacion_padre' value='$padre1_7' id='poblacion_padre' disabled>
					</td>
					<td>
						<input type='text' size='10' name='tel_trabajo_padre' value='$padre1_10' id='tel_trabajo_padre' disabled>
					</td>
				</tr>
			</table>
			<table>
				<tr>
					<td><ba>Centro de trabajo:</td>
				</tr>
				<tr>
					<td>
						<input type='text' size='50' name='trabajo_padre' value='$padre1_9' id='trabajo_padre' disabled>
					</td>
				</tr>
			</table>
		</fieldset>";
		}
		if(isset($padre2_0)){
			echo"
		
		<fieldset><legend><stroke>DATOS MADRE</stroke></legend>
			<table width='675' border='0'>
				<tr>
					<td width='480'><ba>Nombre completo:</td>
					<td><ba>Vive:</td>
			 	</tr>
				<tr>
					<td>
						<input type='text' size='47' name='nombre_madre' value='$padre2_0' id='nombre_madre' disabled>
					</td>
					<td>";
					if ($padre2_1==1){
						echo"
						<input type='radio' name='vive_madre' id='vive_madre' value='1' disabled checked><pp>SI</pp> &nbsp;&nbsp;
						<input type='radio' name='vive_madre' id='vive_madre' disabled><pp>NO<br>
						<input type='checkbox' name='ausente_madre' id='ausente_madre' ";if ($padre2_12==1){ echo " checked ";} echo" disabled>Ausente
						<input type='checkbox' name='tutor_madre' id='tutor_madre' ";if ($padre2_11==1){ echo " checked ";} echo" disabled>Tutor</pp>";
					}
					else{
						echo"
						<input type='radio' name='vive_madre' id='vive_madre' disabled><pp>SI</pp> &nbsp;&nbsp;
						<input type='radio' name='vive_madre' id='vive_madre' value='1' disabled checked><pp>NO<br>
						<input type='checkbox' name='ausente_madre' id='ausente_madre' ";if ($padre2_12==1){ echo " checked ";} echo" disabled>Ausente
						<input type='checkbox' name='tutor_madre' id='tutor_madre' ";if ($padre2_11==1){ echo " checked ";} echo" disabled>Tutor</pp>";
					}
					echo"	
					</td>	
				</tr>
			</table>
			<table>
				<tr>
					<td width='480'><ba>Ocupación:</td>
					<td><ba>Fecha de Nac:</td>
				</tr>
				<tr>
					<td>
						<input type='text' size='47' name='ocupacion_madre' value='$padre2_3' id='ocupacion_madre' disabled>
					</td>
					<td>
						<input type='text' size='10' name='fecha_nac_madre' value='$padre2_2' id='fecha_nac_madre' disabled>
					</td>
				</tr>
			</table>
			<table>
				<tr>
					<td><ba>Escolaridad:</td>
				</tr>
				<tr>
					<td>
						<input type='text' size='50' name='escolaridad_madre' value='$padre2_4' id='escolaridad_madre' disabled>
					</td>
				</tr>
				<tr>
					<td><ba>Domicilio:</td>
				</tr>
				<tr>
					<td>
						<input type='text' size='60' name='domicilio_madre' value='$padre2_5' id='domicilio_madre' disabled>
					</td>
				</tr>
			</table>
			<table>
				<tr>
					<td width='400'><ba>Colonia:</td>
					<td><ba>Teléfono particular:</td>
				</tr>
				<tr>
					<td>
						<input type='text' size='30' name='colonia_madre' value='$padre2_6' id='colonia_madre' disabled>
					</td>
					<td>
						<input type='text' size='10' name='tel_particular_madre' value='$padre2_8' id='tel_particular_madre' disabled>
					</td>
				</tr>
				<tr>
					<td><ba>Población:</td>
					<td><ba>Teléfono de trabajo:</td>
				</tr>
				<tr>
					<td>
						<input type='text' size='30' name='poblacion_madre' value='$padre2_7' id='poblacion_madre' disabled>
					</td>
					<td>
						<input type='text' size='10' name='tel_trabajo_madre' value='$padre2_10' id='tel_trabajo_madre' disabled>
					</td>
				</tr>
			</table>
			<table>
				<tr>
					<td><ba>Centro de trabajo:</td>
				</tr>
				<tr>
					<td>
						<input type='text' size='50' name='trabajo_madre' value='$padre2_9' id='trabajo_madre' disabled>
					</td>
				</tr>
			</table>
		</fieldset>";
		}
		echo"<fieldset><legend><stroke>INGRESOS Y TRANSPORTE</stroke></legend>
			<table width='675' border='0'>
				<tr>
					<td><ba>¿Cuáles son los ingresos mensuales familiares?</td>
				</tr>
			</table>
			<table width='675' border='0'>
				<tr>
					<td width='80'>
						<ba>Padre:</ba>
					</td>
					<td>
						<input type='text' size='4' value='$ingreso_padre' name='ingreso_padre' id='ingreso_padre' disabled maxlength='6'>
					</td>
					<td width='80'>
						<ba>Madre:</ba>
					</td>
					<td>
						<input type='text' size='4' value='$ingreso_madre' name='ingreso_madre' id='ingreso_madre' disabled maxlength='6'>
					</td>
					<td width='80'>
						<ba>Hermanos:</ba>
					</td>
					<td>
						<input type='text' size='4' value='$ingreso_hermanos' name='ingreso_hermanos' id='ingreso_hermanos' disabled maxlength='6'>
					</td>
				</tr>
				<tr>
					<td width='80'><ba>Propios:</ba></td>
					<td>
						<input type='text' size='4' value='$ingreso_propio' name='ingreso_propio' id='ingreso_propio' disabled maxlength='6'>
					</td>
					<td width='80'><ba>Otros:</ba></td>
					<td>
						<input type='text' size='4' value='$ingreso_otros' name='ingreso_otros' id='ingreso_otros' disabled maxlength='6'>
					</td>
					<td width='80'><ba>Total:</ba></td>
					<td>
						<input type='text' size='4' value='$ingreso_total' name='ingreso_total' id='ingreso_total' disabled maxlength='6'>
					
					</td>
				</tr>
			</table><br>
			<table width='675' border='0'>
				<tr>
					<td><ba>¿Cuáles son los principales medios de transporte que utilizas para trasladarte a la institución donde estudias?</ba>
					</td>
				</tr>
			</table>
			<table width='675' border='0'>
				<tr>
					<td width='200'><input type='checkbox' name='medio_transporte' id='medio_transporte' disabled ";if ($autobus==1){ echo " checked ";} echo"><pp>Autobús</pp></td>					
					<td width='200'><input type='checkbox' name='medio_transporte' id='medio_transporte' disabled ";if ($microbus==1){ echo " checked ";} echo"><pp>Microbús</pp></td>					
					<td><input type='checkbox' name='medio_transporte' id='medio_transporte' disabled ";if ($combi==1){ echo " checked ";} echo"><pp>Combi</pp></td>					
				</tr>
				<tr>
					<td width='200'><input type='checkbox' name='medio_transporte' id='medio_transporte' disabled ";if ($taxi==1){ echo " checked ";} echo"><pp>Taxi</pp></td>					
					<td><input type='checkbox' name='medio_transporte' id='medio_transporte' disabled ";if ($motocicleta==1){ echo " checked ";} echo"><pp>Motocicleta</pp></td>					
					<td><input type='checkbox' name='medio_transporte' id='medio_transporte' disabled ";if ($bici==1){ echo " checked ";} echo"><pp>Bicicleta</pp></td>	
				</tr>
			</table>
			<table width='675'>
				<tr>
					<td width='200'><input type='checkbox' name='medio_transporte' id='medio_transporte' disabled ";if ($auto_particular==1){ echo " checked ";} echo"><pp>Auto Particular</pp></td>					
					<td><input type='checkbox' name='medio_transporte' id='medio_transporte' disabled ";if ($otro_transporte==1){ echo " checked ";} echo"><pp>Otro</pp>"; if ($otro_transporte==1){
						echo"<pp>:</pp><input type='text' size='30' maxlength='30' name='otro_transporte' id='otro_transporte' disabled value='$otro_transporte_det'>";}
						echo"
					</td>	
				</tr>
			</table>
			<br>
			<table width='675'>
				<tr>
					<td width='365'><ba>¿Cuánto tiempo tardas en llegar desde tu vivienda a tu universidad?</ba></td>
					<td><ba>Normalmente, ¿cuánto gastas al día en transporte?</ba></td>
				</tr>
				<tr>
					<td>
						<input type='number' name='transporte_horas' id='transporte_horas' size='2' min='0' max='12' disabled value='$horas' style='text-align:right;'><pp>Horas</pp>
						<input type='number' name='transporte_minutos' id='transporte_minutos' size='2' min='0' max='59' disabled value='$minutos' style='text-align:right;'><pp>Minutos</pp></td>
					<td>
						<pp><input type='text' name='gasto_transporte' id='gasto_transporte' size='3' disabled value='$transporte_gasto' style='text-align:right;'>.00MXN</pp>
					</td>
				</tr>
			</table>
		</fieldset>
		<fieldset><legend><stroke>BECA Y HOBBIES</stroke></legend>
			<table width='675'>
				<tr>
					<td>
						<ba>¿Cuentas con algún tipo de beca?</ba>
					</td>
					<td><ba>Si tienes beca, ¿para qué te sirve?</ba><br></td>
				</tr>
				<tr>
					<td valign='top'>";
					if($becas==1){
						echo"
						<input type='radio' name='cuenta_con_beca' value='1' id='cuenta_con_beca' disabled checked><pp>SI</pp>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type='radio' name='cuenta_con_beca' value='2' id='cuenta_con_beca' disabled><pp>NO</pp><br>
						<pp>¿Cuáles?</pp>
						<br><textarea maxlength='200' rows='3' cols='33' name='beca_descripcion' id='beca_descripcion' disabled>$becas_det</textarea>";
					}
					else{
						echo"
						<input type='radio' name='cuenta_con_beca' value='1' id='cuenta_con_beca' disabled checked><pp>SI</pp>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type='radio' name='cuenta_con_beca' value='2' id='cuenta_con_beca' disabled checked><pp>NO</pp><br>";
					}
					echo"	
					</td>
					<td>
						<input type='checkbox' name='utilidad_beca' value='1' id='utilidad_beca' disabled ";if ($colegiatura==1){ echo " checked ";} echo"><pp>Pago de colegiatura</pp><br>
						<input type='checkbox' name='utilidad_beca' value='1' id='utilidad_beca' disabled ";if ($utiles==1){ echo " checked ";} echo"><pp>Pago de útiles escolares</pp><br>
						<input type='checkbox' name='utilidad_beca' value='1' id='utilidad_beca' disabled ";if ($transporte==1){ echo " checked ";} echo"><pp>Pago de transporte a institución</pp><br>
						<input type='checkbox' name='utilidad_beca' value='1' id='utilidad_beca' disabled ";if ($ayuda_gasto==1){ echo " checked ";} echo"><pp>Ayuda gasto familiar</pp><br>
						<input type='checkbox' name='utilidad_beca' value='1' id='utilidad_beca' disabled ";if ($personales_gasto==1){ echo " checked ";} echo"><pp>Gastos personales</pp><br>
						<input type='checkbox' name='utilidad_beca' value='1' id='utilidad_beca' disabled ";if ($otra_utilidad==1){ echo " checked ";} echo"><pp>Otros</pp>";
						if($otra_utilidad==1){
						echo"<pp>:</pp><br><textarea maxlength='100' rows='3' cols='33' name='beca_otra_utilidad' id='beca_otra_utilidad' disabled>$becas_utilidad_otra</textarea>";
						}
					echo"</td>
				</tr>
				<tr>
					<td><ba>¿Qué haces en tus ratos libres?</ba></td>
					<td><ba>¿Qué lugares frecuentas?</ba></td>
				</tr>
				<tr>
					<td>
						<textarea maxlength='200' rows='3' cols='33' name='hobby' id='hobby' disabled>$hobby</textarea>
					</td>
					<td>
						<textarea maxlength='200' rows='3' cols='33' name='lugares' id='lugares' disabled>$lugares_frecuentes</textarea>
					</td>
				</tr>
			</table>
			<table width='675'>	
				<tr>
					<td><ba>¿Qué te motivó a inscribirte en el tecnológico?</ba></td>
				</tr>
				<tr>
					<td><textarea maxlength='200' rows='3' cols='80' name='motivo_tec' id='motivo_tec' disabled>$motivo_tec</textarea></td>
				</tr>
			</table>
		</fieldset>";
		familiares_2($no_ficha);
	echo"</div>";
	}

	}

	function datos_todos($ficha){
		$no_ficha=$ficha;
		require('../conexion/conex_mysql.php');
		$mysqli = new mysqli ($hostname,$username,$password,$database);
		if ($mysqli->connect_errno){
			die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
		}		
		$query = "SELECT * from alumnos_datos_personales WHERE se_no_ficha='$no_ficha'";
		$resultado = $mysqli->query($query);
		$rows = mysqli_fetch_array($resultado);

		$nombre=($rows['dp_nombre']);
		$apaterno=($rows['dp_ap_paterno']);
		$amaterno=($rows['dp_ap_materno']);
		$sexo=($rows['dp_sexo']);
		$carrera=($rows['dp_carrera']);
		$curp=($rows['se_curp']);
		$direccion=($rows['dp_direccion']);
//		$numero=($rows['dp_numero']);
		$colonia=($rows['dp_colonia']);
		$codpost=($rows['dp_cod_post']);
		$municipio=($rows['dp_municipio']);
		$estado=($rows['dp_estado']);
		$tel=($rows['dp_tel']);
		$email=($rows['dp_email']);
		$tiposangre=($rows['dp_tipo_sangre']);
		$edocivil=($rows['dp_edo_civil']);
		$control=($rows['se_no_control']);
		$hijos=($rows['dp_hijos']);
		if ($edocivil==0){
			$ecivil='Desconocido';
		}
		else if ($edocivil==1){
			$ecivil='Soltero';
		}
		else if ($edocivil==2){
			$ecivil='Casado';
		}
		else {
			$ecivil='Otro';
		}

		$query = "SELECT * from semaforos_caracterizacion WHERE no_ficha='$no_ficha'";
		$resultado = $mysqli->query($query);
		$rows = mysqli_fetch_array($resultado);
		
		$tutorias=($rows['smf_tut']);
		$cbasicas=($rows['smf_cb']);
		$trabaja=($rows['smf_trabaja']);
		$jcarrera=($rows['smf_jef_car']);
		$foraneo=($rows['smf_foraneo']);

		$query = "SELECT * from alumnos_caracterizacion WHERE se_no_ficha='$no_ficha'";
		$resultado = $mysqli->query($query);
		$rows = mysqli_fetch_array($resultado);

		$fecha=($rows['se_fecha_ficha']);
		$grupo= ($rows['sa_grupo_gen']);
		$clistas = ($rows['sa_corrimiento_listas']);
		$esc_procedencia= ($rows['se_esc_proced']);
		$mun_esc=($rows['se_esc_proced_mun']);
		$edo_esc=($rows['se_esc_proced_edo']);
		$promedio=($rows['se_bachillerato_prom']);
		$tipo_bach=($rows['se_bachillerato_tipo']);
		$exam_adm=($rows['sa_exam_adm_res']);
		$ps_depresion=($rows['tut_probpsico_depresion']);
		$ps_autoestima=($rows['tut_probpsico_autoestima']);
		$ps_machover=($rows['tut_probpsico_machover']);
		$ps_diagnostico=($rows['tut_probpsico_diagnostico']);
		$pm_peso=($rows['tut_probmed_peso']);
		$pm_enf=($rows['tut_probmed_enf']);
		$pm_ad=($rows['tut_probmed_ad']);
		$pm_alergias=($rows['tut_probmed_alergias']);
		$pm_alergias_med=($rows['tut_probmed_alergmed']);
		$pm_enf_hered=($rows['tut_probmed_enf_hered']);
		$pf_res=($rows['tut_probfam_res']);
		$habitos=($rows['tut_hab_estudio']);
		$vocacional=($rows['tut_orient_vocacional']);
		$opcion_esc=($rows['tut_opc_esc']);
		$ctrunca=($rows['tut_carrera_trunca']);
		$algrebra_res=($rows['doc_curso_algebra_res']);
		$regul_res=($rows['doc_curso_regul_res']);
		$ingresos=($rows['est_se_ingresos_todos']);
		$ingreso_ocaciones=($rows['se_ocasiones_ingreso']);
		$beca=($rows['tut_becas']);
		$tipo_beca=($rows['tut_becas_detalles']);
		$vivir_con=($rows['tut_vivir_con']);
		$horario=($rows['tut_trabajo_horario']);
		$lugar=($rows['tut_trabajo_lugar']);

		$mysqli->close();

		echo"
		<div class='contenedor-1'>
    		<fieldset><legend><stroke>PERSONALES</stroke></legend>
				<table width='675' border='0'>
					<tr>
						<td width='410'><ba>No Ficha:</td>
						<td><ba>No Control:</td>
					</tr>
					<tr>
						<td><input type='text' name='ficha' id='ficha' max='5' size='10' align='right' disabled value='$no_ficha'></td>
						<td><input type='text' name='control' id='control' size='10' disabled value='$control'></td>
					</tr>
					<tr>
						<td><ba>Nombre (s):</td>
						<td><ba>Sexo:</td>
					</tr>
					<tr>
						<td><input type='text' name='nombre' id='nombre' size='25' disabled value='$nombre'></td>
						<td><input type='text' name='sexo' id='sexo' disabled value='$sexo' size='2'></td>
					</tr>
					<tr>
						<td><ba>Apellido Paterno:</td>
						<td><ba>Apellido Materno:</td>
					</tr>
					<tr>
						<td><input type='text' name='ap_paterno' id='ap_paterno' size='20' disabled value='$apaterno'></td>
						<td><input type='text' name='ap_materno' id='ap_materno' size='20' disabled value='$amaterno'></td>
					</tr>
					<tr>
						<td><ba>CURP:</td>
					</tr>
					<tr>
						<td><input type='text' name='curp'  max='18' id='curp' size='20' disabled value='$curp'></td>
					</tr>
				</table>
				<table width='675' border='0'>
					<tr>
						<td><ba>Carrera</td>
					</tr>
					<tr>
					<td><input type='text' name='carreras' id='carreras' disabled value='$carrera' size='68'/></td>
					</tr>
				</table>
			
			</fieldset>
			<fieldset><legend><stroke>DOMICILIO</stroke></legend>
				<table width='675' border='0'>
					<tr>
						<td ><ba>Dirección:</td>
						<td><ba>Número:</td>
					</tr>
					<tr>
						<td><input type='text' name='direccion' id='direccion' size='35' disabled value='$direccion'></td>
						<td><input type='text' name='numero' id='numero' size='5' disabled ></td>
					</tr>
					<tr>
						<td><ba>Colonia:</td>
						<td><ba>Código Postal:</td>
					</tr>
					<tr>
						<td><input type='text' name='colonia' id='colonia' size='25' disabled value='$colonia'></td>
						<td><input type='text' name='codpost' id='codpost' size='8' disabled value='$codpost'></td>
					</tr>
					<tr>
						<td><ba>Municipio:</td>
						<td><ba>Estado:</td>
					</tr>
					<tr>
						<td><input type='text' name='municipio' id='municipio' size='30' disabled value='$municipio'></td>
						<td><input type='text' name='estado' id='estado' size='20' disabled value='$estado'></td>
					</tr>
				</table>
			</fieldset>
			<fieldset><legend><stroke>OTROS</stroke></legend>
				<table width='675' border='0'>
					<tr>	
						<td width='430'><ba>Telefono Celular:</td>
						<td><ba>Tipo de Sangre:</td>
					</tr>
					<tr>
						<td><input type='text' name='telefono_cel' id='telefono_cel' size='10' disabled value='$tel'></td>
						<td><input type='text' name='tiposangre' id='tiposangre' size='5' disabled value='$tiposangre'></td>
					</tr>
					<tr>
						<td><ba>Correo Electronico:</td>
						<td>&nbsp</td>
					</tr>
					<tr>
						<td><input type='text' name='email' id='email' size='40' disabled value='$email'></td>
						<td><ba>¿Tienes Hijos?<br></td>
					</tr>
					<tr>
						<td><ba>Estado Civil:<br>
						<input type='text' name='edocivil' id='edocivil' disabled value='$ecivil' size='12'></td>
						<td>";
						if($hijos==1){
							echo "<input type='radio' name='hijos' value='1' id='hijos' checked disabled><pp>SI <br>
							<input type='radio' name='hijos' value='0' id='hijos' disabled><pp>NO";
						}
						else{
							echo "<input type='radio' name='hijos' value='1' id='hijos' disabled><pp>SI <br>
							<input type='radio' name='hijos' value='0' id='hijos' checked disabled><pp>NO";
						}
						echo "</td>
					</tr>
				</table>
				<table width='675'>
					<tr>
						<td width='300'><ba>¿Has estado becado?</td>
						<td><ba>¿Cuál?</td>
					</tr>
					<tr>
						<td>";
						if ($beca==1){
							echo "
							<input type='radio' name='beca' value='1' id='beca' disabled checked><pp>SI</pp><br>
							<input type='radio' name='beca' value='0' id='beca' disabled><pp>NO</pp>
						</td>";
						}
						else{
							echo"
							<input type='radio' name='beca' value='1' id='beca' disabled><pp>SI</pp><br>
							<input type='radio' name='beca' value='0' id='beca' disabled checked><pp>NO</pp>
						</td>";
						}
						echo "<td><textarea title='Ejemplo: Pronabes, Prospera, etc.'name='tipobeca' id='tipobeca' rows='3' cols='35' maxlength='100' disabled  value='$tipo_beca'></textarea></td>
					</tr>
				</table>
				<table width='675'>
					<tr>
						<td><ba>¿En el transcurso de tus estudios vivirás con?</td>
					</tr>
				</table>
				<table width='675'>
					";
					if($vivir_con==1){
						echo"
						<tr>
							<td>
								<input type='radio' name='vivir_con' value='1' id='vivir_con' disabled checked><pp>Familia</pp>
							</td>
							<td>
								<input type='radio' name='vivir_con' value='2' id='vivir_con' disabled><pp>Familiares cercanos (Tios, primos, abuelos)</pp>
							</td>
						</tr>
						<tr>
							<td>
								<input type='radio' name='vivir_con' value='3' id='vivir_con' disabled><pp>Otros estudiantes</pp>
							</td>
							<td>
								<input type='radio' name='vivir_con' value='4' id='vivir_con' disabled><pp>Solo</pp>
							</td>
						</tr>";
					}
					else if($vivir_con==2){
						echo"
						<tr>
							<td>
								<input type='radio' name='vivir_con' value='1' id='vivir_con' disabled ><pp>Familia</pp>
							</td>
							<td>
								<input type='radio' name='vivir_con' value='2' id='vivir_con' disabled checked><pp>Familiares cercanos (Tios, primos, abuelos)</pp>
							</td>
						</tr>
						<tr>
							<td>
								<input type='radio' name='vivir_con' value='3' id='vivir_con' disabled><pp>Otros estudiantes</pp>
							</td>
							<td>
								<input type='radio' name='vivir_con' value='4' id='vivir_con' disabled><pp>Solo</pp>
							</td>
						</tr>";
					}
					else if($vivir_con==3){
						echo"
						<tr>
							<td>
								<input type='radio' name='vivir_con' value='1' id='vivir_con' disabled ><pp>Familia</pp>
							</td>
							<td>
								<input type='radio' name='vivir_con' value='2' id='vivir_con' disabled ><pp>Familiares cercanos (Tios, primos, abuelos)</pp>
							</td>
						</tr>
						<tr>
							<td>
								<input type='radio' name='vivir_con' value='3' id='vivir_con' disabled checked><pp>Otros estudiantes</pp>
							</td>
							<td>
								<input type='radio' name='vivir_con' value='4' id='vivir_con' disabled><pp>Solo</pp>
							</td>
						</tr>";
					}
					else if($vivir_con==4){
						echo"
						<tr>
							<td>
								<input type='radio' name='vivir_con' value='1' id='vivir_con' disabled ><pp>Familia</pp>
							</td>
							<td>
								<input type='radio' name='vivir_con' value='2' id='vivir_con' disabled ><pp>Familiares cercanos (Tios, primos, abuelos)</pp>
							</td>
						</tr>
						<tr>
							<td>
								<input type='radio' name='vivir_con' value='3' id='vivir_con' disabled ><pp>Otros estudiantes</pp>
							</td>
							<td>
								<input type='radio' name='vivir_con' value='4' id='vivir_con' disabled checked><pp>Solo</pp>
							</td>
						</tr>";
					}
					else{
						echo"
						<tr>
							<td>
								<input type='radio' name='vivir_con' value='1' id='vivir_con' disabled ><pp>Familia</pp>
							</td>
							<td>
								<input type='radio' name='vivir_con' value='2' id='vivir_con' disabled ><pp>Familiares cercanos (Tios, primos, abuelos)</pp>
							</td>
						</tr>
						<tr>
							<td>
								<input type='radio' name='vivir_con' value='3' id='vivir_con' disabled ><pp>Otros estudiantes</pp>
							</td>
							<td>
								<input type='radio' name='vivir_con' value='4' id='vivir_con' disabled ><pp>Solo</pp>
							</td>
						</tr>";
					}
				echo "</table>
			</fieldset>
			<fieldset><legend><stroke>TRABAJO</stroke></legend>
				<table width='675'>
					<tr>
						<td width='410'><ba>¿Trabajas?</td>
						<td><ba>Horario:</ba></td>

					</tr>
					<tr>
						<td>";
						if ($trabaja==1){
							echo "
							<input type='radio' name='trabaja' value='1' id='trabaja' disabled checked><pp>SI</pp><br>
							<input type='radio' name='trabaja' value='2' id='trabaja' disabled><pp>NO</pp>
						</td>";
						}
						else{
							echo "
							<input type='radio' name='trabaja' value='1' id='trabaja' disabled checked><pp>SI</pp><br>
							<input type='radio' name='trabaja' value='2' id='trabaja' disabled  checked><pp>NO</pp>
						</td>";
						}
						echo "<td><input type='text' title='Ejemplo: 8:00am a 3:00pm' name='horario' id='horario' size='15' maxlength='15' disabled value='$horario'></td>
					</tr>
				</table>
				<table width='675'>
					<tr>								
						<td><ba>¿Dónde?</ba></td>
					</tr>
					<tr>
						<td>
							<input type='text' name='lugar_trabajo' id='lugar_trabajo' size='50' maxlength='50' disabled value='$lugar'></td>
						</td>									
						
					</tr>
				</table>
			</fieldset>
				
			</fieldset>
			<fieldset><legend><stroke>SEMÁFOROS</stroke></legend>
				<table width='675' border='0'>
					<tr>
					<td width='225'><ba>Tutorías:</td>
						<td width='225'><ba>Ciencias Básicas:</td>
						<td width='225'><ba>Jefes de Carrera:</td>
					</tr>
					<tr>
						<td>";
							if ($tutorias==0){
								echo "<select disabled name='tutorias' id='tutorias'>
									<option>NINGUNO</option>
								</select>";
							}
							else if ($tutorias==1){
								echo "<select disabled name='tutorias' id='tutorias'>
									<option>BIEN</option>
								</select>";
							}
							else if ($tutorias==2){
								echo "<select disabled name='tutorias' id='tutorias'>
									<option>LEVE</option>
								</select>";
							}
							else if ($tutorias==3){
								echo "<select disabled name='tutorias' id='tutorias'>
									<option>MODERADO</option>
								</select>";
							}
							else {
								echo "<select disabled name='tutorias' id='tutorias'>
									<option>GRAVE</option>
								</select>";
							} echo"
						</td>
						<td>";
							if ($cbasicas==0){
								echo "<select disabled name='cbasicas' id='cbasicas'>
									<option>NINGUNO</option>
								</select>";
							}
							else if ($cbasicas==1){
								echo "<select disabled name='cbasicas' id='cbasicas'>
									<option>BIEN</option>
								</select>";
							}
							else if ($cbasicas==2){
								echo "<select disabled name='cbasicas' id='cbasicas'>
									<option>LEVE</option>
								</select>";
							}
							else if ($cbasicas==3){
								echo "<select disabled name='cbasicas' id='cbasicas'>
									<option>MODERADO</option>
								</select>";
							}
							else {
								echo "<select disabled name='cbasicas' id='cbasicas'>
									<option>GRAVE</option>
								</select>";
							} echo"
						</td>
						<td>";
							if ($jcarrera==0){
								echo "<select disabled name='jefes' id='jefes'>
									<option>NINGUNO</option>
								</select>";
							}
							else if ($jcarrera==1){
								echo "<select disabled name='jefes' id='jefes'>
									<option>BIEN</option>
								</select>";
							}
							else if ($jcarrera==2){
								echo "<select disabled name='jefes' id='jefes'>
									<option>LEVE</option>
								</select>";
							}
							else if ($jcarrera==3){
								echo "<select disabled name='jefes' id='jefes'>
									<option>MODERADO</option>
								</select>";
							}
							else {
								echo "<select disabled name='jefes' id='jefes'>
									<option>GRAVE</option>
								</select>";
							} echo"
						</td>
					</tr>
					
				</table>
			</fieldset>	
    	</div>
    	<div class='contenedor-2'>
			<fieldset><legend><stroke>GENERAL</stroke></legend>
				<table width='675' border='0'>
					<tr>
						<td width='430'><ba>Fecha de Solicitud:</td>
						<td><ba>Foráneo:</td>
					</tr>
					<tr>
						<td>
							<input type='text' name='fecha_ficha' id='fecha_ficha' size='15' value='$fecha' disabled>
						</td>
						<td>";
						if ($foraneo==1){
							echo" <input type='radio' name='foraneo' value='1' id='foraneo' checked disabled><pp>SI
							<br>
							<input type='radio' name='foraneo' value='0' id='foraneo' disabled><pp>NO";
						}
						else{
							echo" <input type='radio' name='foraneo' value='1' id='foraneo' disabled><pp>SI
							<br>
							<input type='radio' name='foraneo' value='0' id='foraneo' checked disabled><pp>NO";
						}
						echo "	
						</td>
					</tr>
					<tr>
						<td><ba>Grupo Generación:</td>
						<td><ba>Corrimiento de Listas:</td>
					</tr>
					<tr>
						<td>
							<input type='text' name='grupo_gen' id='grupo_gen' size='10' value='$grupo' disabled>
						</td>
						<td>
							<input type='text' name='lista_corrimiento' id='lista_corrimiento' size='8' value='$clistas' disabled>
						</td>
					</tr>
				</table>
			</fieldset>	
			<fieldset><legend><stroke>ESCUELA PROCEDENCIA</stroke></legend>
				<table width='675' border='0'>
					<tr>
						<td width='400'><ba>Nombre de Escuela</td>
						<td><ba>Promedio:</td>
					</tr>
					<tr>
						<td>
							<input type='text' name='esc_proc' id='esc_proc' size='40' value='$esc_procedencia' disabled>
						</td>
						<td>
							<input type='text' name='prom_bach' id='prom_bach' size='5' value='$promedio' disabled>
						</td>
					</tr>
					<tr>
						<td><ba>Municipio:</td>
						<td><ba>Estado:</td>
					</tr>
					<tr>
						<td>
							<input type='text' name='mun_esc_proc' id='mun_esc_proc' size='30' value='$mun_esc' disabled>
						</td>
						<td>
							<input type='text' name='edo_esc_proc' id='edo_esc_proc' size='20' value='$edo_esc' disabled>
						</td>
					</tr>
					<tr>
						<td><ba>Tipo de Bachillerato:</td>
					</tr>
					<tr>
						<td>
							<input type='text' name='tipo_bach' id='tipo_bach' size='40' value='$tipo_bach' disabled>
						</td>
					</tr>
				</table>
			</fieldset>
			<fieldset>
			<legend><stroke>RESULTADOS DE EXÁMENES</stroke></legend>
				<table width='675' border='0'>
					<tr>
						<td><ba>Admisión:</td>
						<td><ba>Algebra:</td>
						<td><ba>Regularización:</td>
					</tr>
					<tr>
						<td><input type='text' name='exam_admision' id='exam_admision' size='8' value='$exam_adm' disabled></td>
						<td><input type='text' name='curso_algebra' id='curso_algebra' size='8' value='$algrebra_res' disabled></td>
						<td><input type='text' name='curso_regul' id='curso_regul' size='8' value='$regul_res' disabled></td>
					</tr>
				</table>
			</fieldset>
			<fieldset>
				<legend><stroke>PROBLEMAS PSICOLÓGICOS</stroke></legend>
				<table width='660'>
					<tr>
						<td><ba>Depresión:</td>
						<td><ba>Autoestima:</td>
						<td><ba>Diagnóstico:</td>
					</tr>
					<tr>
						<td><input type='text' name='depresion' id='depresion' size='8' value='$ps_depresion' disabled></td>
						<td><input type='text' name='autoestima' id='autoestima' size='8' value='$ps_autoestima' disabled></td>
						<td><input type='text' name='diagnostico_probpsico' id='diagnostico_probpsico' size='10' value='$ps_diagnostico' disabled></td>								
					</tr>
				</table>
				<table width='675'>
					<tr>
						<td><ba>Machover:</td>
					</tr>
					<tr>
						<td><textarea maxlength='300' rows='3' cols='72' name='machover' id='machover' placeholder='Resultado de prueba machover' disabled>$ps_machover</textarea></td>
					</tr>
				</table>
			</fieldset>
			<fieldset>
				<legend><stroke>PROBLEMAS MÉDICOS</stroke></legend>
				<table width='675'>
					<tr>
						<td><ba>Enf. Hereditarias:</td>
						<td><ba>Adicciones:</td>
						<td><ba>Peso:</td>
					</tr>
					<tr>
						<td><input type='text' name='enf_hered' id='enf_hered' size='15' value='$pm_enf_hered' disabled></td>
						<td><input type='text' name='ayd' id='ayd' size='15' value='$pm_ad' disabled></td>
						<td><input type='text' name='peso' id='peso' size='20' maxlength='20' value='$pm_peso' disabled></td>
					</tr>
				</table>
				<table>
					<tr>
						<td><ba>Enfermedades:</td>
					</tr>
					<tr>
						<td><textarea maxlength='300' rows='3' cols='72' name='enfermedades' id='enfermedades' value='$pm_enf' disabled></textarea></td>
					</tr>
					<tr>
						<td><ba>Alergias:</td>
					</tr>
					<tr>
						<td><textarea maxlength='300' rows='3' cols='72' name='alergias' id='alergias' value='$pm_alergias' disabled></textarea></td>
					</tr>
					<tr>
						<td><ba>Alergia a medicamento:</td>
					</tr>
					<tr>
						<td><textarea maxlength='300' rows='3' cols='72' name='alergia_med' id='alergia_med' value='$pm_alergias_med' disabled></textarea></td>
					</tr>
				</table>
			</fieldset>
			<fieldset>
				<legend><stroke>PROBLEMAS FAMILIARES</stroke></legend>
				<table width='675'>
					<tr>
						<td><ba>Diagnóstico:</td>
					</tr>
					<tr>
						<td><input type='text' name='probfam' id='probfam' size='20' value='$pf_res' disabled></td>
					</tr>
				</table>
			</fieldset>
			<fieldset><legend><stroke>COMPLEMENTARIOS</stroke></legend>
				<table width='675'>
					<tr>
						<td width='225'><ba>Habitos de Estudio:</td>
						<td width='225'><ba>Orientación Vocacional:</td>
						<td><ba>¿Qué opción somos?</td>
					</tr>
					<tr>
						<td><input type='text' name='habitos' id='habitos' size='9' value='$habitos' disabled></td>
						<td><input type='text' name='vocacional' id='vocacional' size='10' value='$vocacional' disabled></td>
						<td><input type='text' name='opcesc' id='opcesc' size='10' value='$opcion_esc' disabled></td>
					</tr>
					<tr>
						<td><ba>Carrera Trunca:</td>
						<td><br><ba>Ingresos Familiares:</td>
						<td><br><ba>Inscrito Antes:</td>
					</tr>
					<tr>
						<td><textarea maxlength='50' name='trunca' rows='2' cols='20' wrap='hard' value='$ctrunca' disabled></textarea></td>
						<td><input type='text' name='ingresos' id='ingresos' size='5' value='$ingresos' disabled></td>
						<td><input type='text' name='ocasion_ingreso' id='ocasion_ingreso' size='5' value='$ingreso_ocaciones' disabled></td>
					</tr>
				</table>
				<br>
				<table width='675'>
					<tr align='right'>
						<td>
							<form action='test_vocacional.php' method='POST' name='resultados_tt'>
								<input type='submit' name='test' value='Ver Resultados Test Vocacional'>
								<input type='hidden' value='$no_ficha' name='ficha'>
							</form>
						</td>
					</tr>
				</table>
			</fieldset>
		</div>";
		estudio_se($no_ficha);
	}
	function datos_todos_2($ficha){

		$no_ficha=$ficha;
		require '../../conexion/conex_mysql.php';
		$mysqli = new mysqli ($hostname,$username,$password,$database);
		if ($mysqli->connect_errno){
			die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
		}		
		$query = "SELECT * from alumnos_datos_personales WHERE se_no_ficha='$no_ficha'";
		$resultado = $mysqli->query($query);
		$rows = mysqli_fetch_array($resultado);

		$nombre=($rows['dp_nombre']);
		$apaterno=($rows['dp_ap_paterno']);
		$amaterno=($rows['dp_ap_materno']);
		$sexo=($rows['dp_sexo']);
		$carrera=($rows['dp_carrera']);
		$curp=($rows['se_curp']);
		$direccion=($rows['dp_direccion']);
		$colonia=($rows['dp_colonia']);
		$codpost=($rows['dp_cod_post']);
		$municipio=($rows['dp_municipio']);
		$estado=($rows['dp_estado']);
		$tel=($rows['dp_tel']);
		$email=($rows['dp_email']);
		$tiposangre=($rows['dp_tipo_sangre']);
		$edocivil=($rows['dp_edo_civil']);
		$control=($rows['se_no_control']);
		$hijos=($rows['dp_hijos']);
		if ($edocivil==0){
			$ecivil='Desconocido';
		}
		else if ($edocivil==1){
			$ecivil='Soltero';
		}
		else if ($edocivil==2){
			$ecivil='Casado';
		}
		else {
			$ecivil='Otro';
		}

		$query = "SELECT * from semaforos_caracterizacion WHERE no_ficha='$no_ficha'";
		$resultado = $mysqli->query($query);
		$rows = mysqli_fetch_array($resultado);
		
		$tutorias=($rows['smf_tut']);
		$cbasicas=($rows['smf_cb']);
		$trabaja=($rows['smf_trabaja']);
		$jcarrera=($rows['smf_jef_car']);
		$foraneo=($rows['smf_foraneo']);

		$query = "SELECT * from alumnos_caracterizacion WHERE se_no_ficha='$no_ficha'";
		$resultado = $mysqli->query($query);
		$rows = mysqli_fetch_array($resultado);

		$fecha=($rows['se_fecha_ficha']);
		$grupo= ($rows['sa_grupo_gen']);
		$clistas = ($rows['sa_corrimiento_listas']);
		$esc_procedencia= ($rows['se_esc_proced']);
		$mun_esc=($rows['se_esc_proced_mun']);
		$edo_esc=($rows['se_esc_proced_edo']);
		$promedio=($rows['se_bachillerato_prom']);
		$tipo_bach=($rows['se_bachillerato_tipo']);
		$exam_adm=($rows['sa_exam_adm_res']);
		$ps_depresion=($rows['tut_probpsico_depresion']);
		$ps_autoestima=($rows['tut_probpsico_autoestima']);
		$ps_machover=($rows['tut_probpsico_machover']);
		$ps_diagnostico=($rows['tut_probpsico_diagnostico']);
		$pm_peso=($rows['tut_probmed_peso']);
		$pm_enf=($rows['tut_probmed_enf']);
		$pm_ad=($rows['tut_probmed_ad']);
		$pm_alergias=($rows['tut_probmed_alergias']);
		$pm_alergias_med=($rows['tut_probmed_alergmed']);
		$pm_enf_hered=($rows['tut_probmed_enf_hered']);
		$pf_res=($rows['tut_probfam_res']);
		$habitos=($rows['tut_hab_estudio']);
		$vocacional=($rows['tut_orient_vocacional']);
		$opcion_esc=($rows['tut_opc_esc']);
		$ctrunca=($rows['tut_carrera_trunca']);
		$algrebra_res=($rows['doc_curso_algebra_res']);
		$regul_res=($rows['doc_curso_regul_res']);
		$ingresos=($rows['est_se_ingresos_todos']);
		$ingreso_ocaciones=($rows['se_ocasiones_ingreso']);
		$beca=($rows['tut_becas']);
		$tipo_beca=($rows['tut_becas_detalles']);
		$vivir_con=($rows['tut_vivir_con']);
		$horario=($rows['tut_trabajo_horario']);
		$lugar=($rows['tut_trabajo_lugar']);

		$mysqli->close();

		echo"
		<div class='contenedor-1'>
    		<fieldset><legend><stroke>PERSONALES</stroke></legend>
				<table width='675' border='0'>
					<tr>
						<td width='410'><ba>No Ficha:</td>
						<td><ba>No Control:</td>
					</tr>
					<tr>
						<td><input type='text' name='ficha' id='ficha' max='5' size='10' align='right' disabled value='$no_ficha'></td>
						<td><input type='text' name='control' id='control' size='10' disabled value='$control'></td>
					</tr>
					<tr>
						<td><ba>Nombre (s):</td>
						<td><ba>Sexo:</td>
					</tr>
					<tr>
						<td><input type='text' name='nombre' id='nombre' size='25' disabled value='$nombre'></td>
						<td><input type='text' name='sexo' id='sexo' disabled value='$sexo' size='2'></td>
					</tr>
					<tr>
						<td><ba>Apellido Paterno:</td>
						<td><ba>Apellido Materno:</td>
					</tr>
					<tr>
						<td><input type='text' name='ap_paterno' id='ap_paterno' size='20' disabled value='$apaterno'></td>
						<td><input type='text' name='ap_materno' id='ap_materno' size='20' disabled value='$amaterno'></td>
					</tr>
					<tr>
						<td><ba>CURP:</td>
					</tr>
					<tr>
						<td><input type='text' name='curp'  max='18' id='curp' size='20' disabled value='$curp'></td>
					</tr>
				</table>
				<table width='675' border='0'>
					<tr>
						<td><ba>Carrera</td>
					</tr>
					<tr>
					<td><input type='text' name='carreras' id='carreras' disabled value='$carrera' size='68'/></td>
					</tr>
				</table>
			
			</fieldset>
			<fieldset><legend><stroke>DOMICILIO</stroke></legend>
				<table width='675' border='0'>
					<tr>
						<td ><ba>Dirección:</td>
					</tr>
					<tr>
						<td><input type='text' name='direccion' id='direccion' size='35' disabled value='$direccion'></td>
					</tr>
					<tr>
						<td><ba>Colonia:</td>
						<td><ba>Código Postal:</td>
					</tr>
					<tr>
						<td><input type='text' name='colonia' id='colonia' size='25' disabled value='$colonia'></td>
						<td><input type='text' name='codpost' id='codpost' size='8' disabled value='$codpost'></td>
					</tr>
					<tr>
						<td><ba>Municipio:</td>
						<td><ba>Estado:</td>
					</tr>
					<tr>
						<td><input type='text' name='municipio' id='municipio' size='30' disabled value='$municipio'></td>
						<td><input type='text' name='estado' id='estado' size='20' disabled value='$estado'></td>
					</tr>
				</table>
			</fieldset>
			<fieldset><legend><stroke>OTROS</stroke></legend>
				<table width='675' border='0'>
					<tr>	
						<td width='430'><ba>Telefono Celular:</td>
						<td><ba>Tipo de Sangre:</td>
					</tr>
					<tr>
						<td><input type='text' name='telefono_cel' id='telefono_cel' size='10' disabled value='$tel'></td>
						<td><input type='text' name='tiposangre' id='tiposangre' size='5' disabled value='$tiposangre'></td>
					</tr>
					<tr>
						<td><ba>Correo Electronico:</td>
						<td>&nbsp</td>
					</tr>
					<tr>
						<td><input type='text' name='email' id='email' size='40' disabled value='$email'></td>
						<td><ba>¿Tienes Hijos?<br></td>
					</tr>
					<tr>
						<td><ba>Estado Civil:<br>
						<input type='text' name='edocivil' id='edocivil' disabled value='$ecivil' size='12'></td>
						<td>";
						if($hijos==1){
							echo "<input type='radio' name='hijos' value='1' id='hijos' checked disabled><pp>SI <br>
							<input type='radio' name='hijos' value='0' id='hijos' disabled><pp>NO";
						}
						else{
							echo "<input type='radio' name='hijos' value='1' id='hijos' disabled><pp>SI <br>
							<input type='radio' name='hijos' value='0' id='hijos' checked disabled><pp>NO";
						}
						echo "</td>
					</tr>
				</table>
				<table width='675'>
					<tr>
						<td width='300'><ba>¿Has estado becado?</td>
						<td><ba>¿Cuál?</td>
					</tr>
					<tr>
						<td>";
						if ($beca==1){
							echo "
							<input type='radio' name='beca' value='1' id='beca' disabled checked><pp>SI</pp><br>
							<input type='radio' name='beca' value='0' id='beca' disabled><pp>NO</pp>
						</td>";
						}
						else{
							echo"
							<input type='radio' name='beca' value='1' id='beca' disabled><pp>SI</pp><br>
							<input type='radio' name='beca' value='0' id='beca' disabled checked><pp>NO</pp>
						</td>";
						}
						echo "<td><textarea title='Ejemplo: Pronabes, Prospera, etc.'name='tipobeca' id='tipobeca' rows='3' cols='35' maxlength='100' disabled  value='$tipo_beca'></textarea></td>
					</tr>
				</table>
				<table width='675'>
					<tr>
						<td><ba>¿En el transcurso de tus estudios vivirás con?</td>
					</tr>
				</table>
				<table width='675'>
					";
					if($vivir_con==1){
						echo"
						<tr>
							<td>
								<input type='radio' name='vivir_con' value='1' id='vivir_con' disabled checked><pp>Familia</pp>
							</td>
							<td>
								<input type='radio' name='vivir_con' value='2' id='vivir_con' disabled><pp>Familiares cercanos (Tios, primos, abuelos)</pp>
							</td>
						</tr>
						<tr>
							<td>
								<input type='radio' name='vivir_con' value='3' id='vivir_con' disabled><pp>Otros estudiantes</pp>
							</td>
							<td>
								<input type='radio' name='vivir_con' value='4' id='vivir_con' disabled><pp>Solo</pp>
							</td>
						</tr>";
					}
					else if($vivir_con==2){
						echo"
						<tr>
							<td>
								<input type='radio' name='vivir_con' value='1' id='vivir_con' disabled ><pp>Familia</pp>
							</td>
							<td>
								<input type='radio' name='vivir_con' value='2' id='vivir_con' disabled checked><pp>Familiares cercanos (Tios, primos, abuelos)</pp>
							</td>
						</tr>
						<tr>
							<td>
								<input type='radio' name='vivir_con' value='3' id='vivir_con' disabled><pp>Otros estudiantes</pp>
							</td>
							<td>
								<input type='radio' name='vivir_con' value='4' id='vivir_con' disabled><pp>Solo</pp>
							</td>
						</tr>";
					}
					else if($vivir_con==3){
						echo"
						<tr>
							<td>
								<input type='radio' name='vivir_con' value='1' id='vivir_con' disabled ><pp>Familia</pp>
							</td>
							<td>
								<input type='radio' name='vivir_con' value='2' id='vivir_con' disabled ><pp>Familiares cercanos (Tios, primos, abuelos)</pp>
							</td>
						</tr>
						<tr>
							<td>
								<input type='radio' name='vivir_con' value='3' id='vivir_con' disabled checked><pp>Otros estudiantes</pp>
							</td>
							<td>
								<input type='radio' name='vivir_con' value='4' id='vivir_con' disabled><pp>Solo</pp>
							</td>
						</tr>";
					}
					else if($vivir_con==4){
						echo"
						<tr>
							<td>
								<input type='radio' name='vivir_con' value='1' id='vivir_con' disabled ><pp>Familia</pp>
							</td>
							<td>
								<input type='radio' name='vivir_con' value='2' id='vivir_con' disabled ><pp>Familiares cercanos (Tios, primos, abuelos)</pp>
							</td>
						</tr>
						<tr>
							<td>
								<input type='radio' name='vivir_con' value='3' id='vivir_con' disabled ><pp>Otros estudiantes</pp>
							</td>
							<td>
								<input type='radio' name='vivir_con' value='4' id='vivir_con' disabled checked><pp>Solo</pp>
							</td>
						</tr>";
					}
					else{
						echo"
						<tr>
							<td>
								<input type='radio' name='vivir_con' value='1' id='vivir_con' disabled ><pp>Familia</pp>
							</td>
							<td>
								<input type='radio' name='vivir_con' value='2' id='vivir_con' disabled ><pp>Familiares cercanos (Tios, primos, abuelos)</pp>
							</td>
						</tr>
						<tr>
							<td>
								<input type='radio' name='vivir_con' value='3' id='vivir_con' disabled ><pp>Otros estudiantes</pp>
							</td>
							<td>
								<input type='radio' name='vivir_con' value='4' id='vivir_con' disabled ><pp>Solo</pp>
							</td>
						</tr>";
					}
				echo "</table>
			</fieldset>
			<fieldset><legend><stroke>TRABAJO</stroke></legend>
				<table width='675'>
					<tr>
						<td width='410'><ba>¿Trabajas?</td>
						<td><ba>Horario:</ba></td>

					</tr>
					<tr>
						<td>";
						if ($trabaja==1){
							echo "
							<input type='radio' name='trabaja' value='1' id='trabaja' disabled checked><pp>SI</pp><br>
							<input type='radio' name='trabaja' value='2' id='trabaja' disabled><pp>NO</pp>
						</td>";
						}
						else{
							echo "
							<input type='radio' name='trabaja' value='1' id='trabaja' disabled checked><pp>SI</pp><br>
							<input type='radio' name='trabaja' value='2' id='trabaja' disabled  checked><pp>NO</pp>
						</td>";
						}
						echo "<td><input type='text' title='Ejemplo: 8:00am a 3:00pm' name='horario' id='horario' size='15' maxlength='15' disabled value='$horario'></td>
					</tr>
				</table>
				<table width='675'>
					<tr>								
						<td><ba>¿Dónde?</ba></td>
					</tr>
					<tr>
						<td>
							<input type='text' name='lugar_trabajo' id='lugar_trabajo' size='50' maxlength='50' disabled value='$lugar'></td>
						</td>									
						
					</tr>
				</table>
			</fieldset>
				
			</fieldset>
			<fieldset><legend><stroke>SEMÁFOROS</stroke></legend>
				<table width='675' border='0'>
					<tr>
					<td width='225'><ba>Tutorías:</td>
						<td width='225'><ba>Ciencias Básicas:</td>
						<td width='225'><ba>Jefes de Carrera:</td>
					</tr>
					<tr>
						<td>";
							if ($tutorias==0){
								echo "<select disabled name='tutorias' id='tutorias'>
									<option>NINGUNO</option>
								</select>";
							}
							else if ($tutorias==1){
								echo "<select disabled name='tutorias' id='tutorias'>
									<option>BIEN</option>
								</select>";
							}
							else if ($tutorias==2){
								echo "<select disabled name='tutorias' id='tutorias'>
									<option>LEVE</option>
								</select>";
							}
							else if ($tutorias==3){
								echo "<select disabled name='tutorias' id='tutorias'>
									<option>MODERADO</option>
								</select>";
							}
							else {
								echo "<select disabled name='tutorias' id='tutorias'>
									<option>GRAVE</option>
								</select>";
							} echo"
						</td>
						<td>";
							if ($cbasicas==0){
								echo "<select disabled name='cbasicas' id='cbasicas'>
									<option>NINGUNO</option>
								</select>";
							}
							else if ($cbasicas==1){
								echo "<select disabled name='cbasicas' id='cbasicas'>
									<option>BIEN</option>
								</select>";
							}
							else if ($cbasicas==2){
								echo "<select disabled name='cbasicas' id='cbasicas'>
									<option>LEVE</option>
								</select>";
							}
							else if ($cbasicas==3){
								echo "<select disabled name='cbasicas' id='cbasicas'>
									<option>MODERADO</option>
								</select>";
							}
							else {
								echo "<select disabled name='cbasicas' id='cbasicas'>
									<option>GRAVE</option>
								</select>";
							} echo"
						</td>
						<td>";
							if ($jcarrera==0){
								echo "<select disabled name='jefes' id='jefes'>
									<option>NINGUNO</option>
								</select>";
							}
							else if ($jcarrera==1){
								echo "<select disabled name='jefes' id='jefes'>
									<option>BIEN</option>
								</select>";
							}
							else if ($jcarrera==2){
								echo "<select disabled name='jefes' id='jefes'>
									<option>LEVE</option>
								</select>";
							}
							else if ($jcarrera==3){
								echo "<select disabled name='jefes' id='jefes'>
									<option>MODERADO</option>
								</select>";
							}
							else {
								echo "<select disabled name='jefes' id='jefes'>
									<option>GRAVE</option>
								</select>";
							} echo"
						</td>
					</tr>
					
				</table>
			</fieldset>	
    	</div>
    	<div class='contenedor-2'>
			<fieldset><legend><stroke>GENERAL</stroke></legend>
				<table width='675' border='0'>
					<tr>
						<td width='430'><ba>Fecha de Solicitud:</td>
						<td><ba>Foráneo:</td>
					</tr>
					<tr>
						<td>
							<input type='text' name='fecha_ficha' id='fecha_ficha' value='$fecha' size='15' disabled>
						</td>
						<td>";
						if ($foraneo==1){
							echo" <input type='radio' name='foraneo' value='1' id='foraneo' checked disabled><pp>SI
							<br>
							<input type='radio' name='foraneo' value='0' id='foraneo' disabled><pp>NO";
						}
						else{
							echo" <input type='radio' name='foraneo' value='1' id='foraneo' disabled><pp>SI
							<br>
							<input type='radio' name='foraneo' value='0' id='foraneo' checked disabled><pp>NO";
						}
						echo "	
						</td>
					</tr>
					<tr>
						<td><ba>Grupo Generación:</td>
						<td><ba>Corrimiento de Listas:</td>
					</tr>
					<tr>
						<td>
							<input type='text' name='grupo_gen' id='grupo_gen' size='10' value='$grupo' disabled>
						</td>
						<td>
							<input type='text' name='lista_corrimiento' id='lista_corrimiento' size='8' value='$clistas' disabled>
						</td>
					</tr>
				</table>
			</fieldset>	
			<fieldset><legend><stroke>ESCUELA PROCEDENCIA</stroke></legend>
				<table width='675' border='0'>
					<tr>
						<td width='400'><ba>Nombre de Escuela</td>
						<td><ba>Promedio:</td>
					</tr>
					<tr>
						<td>
							<input type='text' name='esc_proc' id='esc_proc' size='40' value='$esc_procedencia' disabled>
						</td>
						<td>
							<input type='text' name='prom_bach' id='prom_bach' size='5' value='$promedio' disabled>
						</td>
					</tr>
					<tr>
						<td><ba>Municipio:</td>
						<td><ba>Estado:</td>
					</tr>
					<tr>
						<td>
							<input type='text' name='mun_esc_proc' id='mun_esc_proc' size='30' value='$mun_esc' disabled>
						</td>
						<td>
							<input type='text' name='edo_esc_proc' id='edo_esc_proc' size='20' value='$edo_esc' disabled>
						</td>
					</tr>
					<tr>
						<td><ba>Tipo de Bachillerato:</td>
					</tr>
					<tr>
						<td>
							<input type='text' name='tipo_bach' id='tipo_bach' size='40' value='$tipo_bach' disabled>
						</td>
					</tr>
				</table>
			</fieldset>
			<fieldset>
			<legend><stroke>RESULTADOS DE EXÁMENES</stroke></legend>
				<table width='675' border='0'>
					<tr>
						<td><ba>Admisión:</td>
						<td><ba>Algebra:</td>
						<td><ba>Regularización:</td>
					</tr>
					<tr>
						<td><input type='text' name='exam_admision' id='exam_admision' size='8' value='$exam_adm' disabled></td>
						<td><input type='text' name='curso_algebra' id='curso_algebra' size='8' value='$algrebra_res' disabled></td>
						<td><input type='text' name='curso_regul' id='curso_regul' size='8' value='$regul_res' disabled></td>
					</tr>
				</table>
			</fieldset>
			<fieldset>
				<legend><stroke>PROBLEMAS PSICOLÓGICOS</stroke></legend>
				<table width='660'>
					<tr>
						<td><ba>Depresión:</td>
						<td><ba>Autoestima:</td>
						<td><ba>Diagnóstico:</td>
					</tr>
					<tr>
						<td><input type='text' name='depresion' id='depresion' size='8' value='$ps_depresion' disabled></td>
						<td><input type='text' name='autoestima' id='autoestima' size='8' value='$ps_autoestima' disabled></td>
						<td><input type='text' name='diagnostico_probpsico' id='diagnostico_probpsico' size='10' value='$ps_diagnostico' disabled></td>								
					</tr>
				</table>
				<table width='675'>
					<tr>
						<td><ba>Machover:</td>
					</tr>
					<tr>
						<td><textarea maxlength='300' rows='3' cols='72' name='machover' id='machover' placeholder='Resultado de prueba machover' value='$ps_machover' disabled></textarea></td>
					</tr>
				</table>
			</fieldset>
			<fieldset>
				<legend><stroke>PROBLEMAS MÉDICOS</stroke></legend>
				<table width='675'>
					<tr>
						<td><ba>Enf. Hereditarias:</td>
						<td><ba>Adicciones:</td>
						<td><ba>Peso:</td>
					</tr>
					<tr>
						<td><input type='text' name='enf_hered' id='enf_hered' size='15' value='$pm_enf_hered' disabled></td>
						<td><input type='text' name='ayd' id='ayd' size='15' value='$pm_ad' disabled></td>
						<td><input type='text' name='peso' id='peso' size='20' maxlength='20' value='$pm_peso' disabled></td>
					</tr>
				</table>
				<table>
					<tr>
						<td><ba>Enfermedades:</td>
					</tr>
					<tr>
						<td><textarea maxlength='300' rows='3' cols='72' name='enfermedades' id='enfermedades' value='$pm_enf' disabled></textarea></td>
					</tr>
					<tr>
						<td><ba>Alergias:</td>
					</tr>
					<tr>
						<td><textarea maxlength='300' rows='3' cols='72' name='alergias' id='alergias' value='$pm_alergias' disabled></textarea></td>
					</tr>
					<tr>
						<td><ba>Alergia a medicamento:</td>
					</tr>
					<tr>
						<td><textarea maxlength='300' rows='3' cols='72' name='alergia_med' id='alergia_med' value='$pm_alergias_med' disabled></textarea></td>
					</tr>
				</table>
			</fieldset>
			<fieldset>
				<legend><stroke>PROBLEMAS FAMILIARES</stroke></legend>
				<table width='675'>
					<tr>
						<td><ba>Diagnóstico:</td>
					</tr>
					<tr>
						<td><input type='text' name='probfam' id='probfam' size='20' value='$pf_res' disabled></td>
					</tr>
				</table>
			</fieldset>
			<fieldset><legend><stroke>COMPLEMENTARIOS</stroke></legend>
				<table width='675'>
					<tr>
						<td width='225'><ba>Habitos de Estudio:</td>
						<td width='225'><ba>Orientación Vocacional:</td>
						<td><ba>¿Qué opción somos?</td>
					</tr>
					<tr>
						<td><input type='text' name='habitos' id='habitos' size='9' value='$habitos' disabled></td>
						<td><input type='text' name='vocacional' id='vocacional' size='10' value='$vocacional' disabled></td>
						<td><input type='text' name='opcesc' id='opcesc' size='10' value='$opcion_esc' disabled></td>
					</tr>
					<tr>
						<td><ba>Carrera Trunca:</td>
						<td><br><ba>Ingresos Familiares:</td>
						<td><br><ba>Inscrito Antes:</td>
					</tr>
					<tr>
						<td><textarea maxlength='50' name='trunca' rows='2' cols='20' wrap='hard' value='$ctrunca' disabled></textarea></td>
						<td><input type='text' name='ingresos' id='ingresos' size='5' value='$ingresos' disabled></td>
						<td><input type='text' name='ocasion_ingreso' id='ocasion_ingreso' size='5' value='$ingreso_ocaciones' disabled></td>
					</tr>
				</table>
				<table width='675'>
					<tr></tr>
					<tr></tr>
				</table>
			</fieldset>
		</div>";
		estudio_se_2($no_ficha);
		
	
	}

	function asignar_calif_exam_adm(){
		require_once '../conexion/conex_mysql.php';
		require_once '../consultas/sentencias_consultas_carreras.php';
		$arreglo[1]=$bioquimica;
		$arreglo[2]=$gestion;
		$arreglo[3]=$industrial;
		$arreglo[4]=$meca;
		$arreglo[5]=$nano;
		$arreglo[6]=$sistemas;
		$arreglo[7]=$tics;
		$char_carr[1]='b';
		$char_carr[2]='g';
		$char_carr[3]='i';
		$char_carr[4]='m';
		$char_carr[5]='n';
		$char_carr[6]='s';
		$char_carr[7]='t';
		session_start();
		for($i=1;$i<=7;$i++){
			echo"
			<div class='contenedor-$i'>
				<form id='form$i' name='form$i' method='post' action='guardar_calif.php'>";
					$mysqli = new mysqli ($hostname,$username,$password,$database);
					if ($mysqli->connect_errno){
						die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
					}
					$query = $arreglo[$i];
					$resultado = $mysqli->query($query);
					
					$reg = mysqli_num_rows($resultado);
					//$array=mysqli_fetch_row($resultado);
					$cont=1;
					if($reg!=0){
						$array[0]=$reg;
						echo "
						<table border='1' width='700'>
							<tr>
								<td><bb>Ficha</bb></td>
								<td><bb>Nombre</bb></td>
								<td><bb>Apellido Paterno</bb></td>
								<td><bb>Apellido Materno</bb></td>
								<td><bb>Grupo</bb></td>
								<td><bb>Calificación</bb></td>
							</tr>";
							while($rows=mysqli_fetch_array($resultado)){
								$cal=$rows['sa_exam_adm_res'];
								echo "
								<tr>
									<td><pp>".$rows['se_no_ficha']."</pp></td>
									<td><pp>".$rows['dp_nombre']."</pp></td>
									<td><pp>".$rows['dp_ap_paterno']."</pp></td>
									<td><pp>".$rows['dp_ap_materno']."</pp></td>
									<td><pp>".$rows['sa_grupo_gen']."</pp></td>				
									<td><pp><input type='text' name='calif".$cont."' id='textfield' value='$cal' size='3' /></pp></td>
								</tr>";
								$array[$cont]=$rows['se_no_ficha'];
								$cont++;
							}
						echo "</table>";
						$nombre='arreglo'.$i;
						$_SESSION[$nombre] = $array;
					}else{
						echo "No existen alumnos de esa carrera";
					}
				echo"
					<table width='700'>
						<tr align='right'><br>
						<input name='carrera' id='carrera' value='$char_carr[$i]' hidden></input>
							<td><input type='submit' name='button' id='button' value='Registrar' /></td>
					</tr>
					</table>
				</form>

	    	</div>";
    	}
	    	
	}
	function asignar_calif_algebra($carrera){
		session_start();
		require_once '../../conexion/conex_mysql.php';
		require_once '../../consultas/sentencias_consulta_con_distinc.php';
		
		$mysqli = new mysqli ($hostname,$username,$password,$database);
		if ($mysqli->connect_errno){
			die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
		}

		switch ($carrera) {
			case 'bioquimica':
				$query = $bioquimica;
				break;
			
			case 'gestion':
				$query = $gestion;
				break;

			case 'industrial':
				$query = $industrial;
				break;

			case 'meca':
				$query = $meca;
				break;

			case 'nano':
				$query = $nano;
				break;

			case 'sistemas':
				$query = $sistemas;
				break;

			case 'tics':
				$query = $tics;
				break;
		}		
		
		$resultado = $mysqli->query($query);
		$mysqli->close();
		$reg = mysqli_num_rows($resultado);
		
		$cont=1;
		if($reg!=0){
			while($rows=mysqli_fetch_array($resultado)){
				$array[$cont][0]=$rows['sa_grupo_gen'];
				$array[$cont][1]=$rows['dp_carrera'];
				$cont++;
			}
			
			echo "
		<div class='container'>
			<section class='tabs'>";
			for($x=1;$x<=$reg;$x++){
				if(!empty($array[$x][0])){
				echo"
	           	<input id='tab-$x' type='radio' name='radio-set' class='tab-selector-$x' checked='checked' style='visibility:hidden'/>
		       	<label for='tab-$x' class='tab-label-$x'><stroke-2>".$array[$x][0]."</stroke-2></label>";

				}
			}
		    echo "
			    <div class='clear-shadow'></div>
			    <div class='contenedor'>";
				for ($y=0;$y<=$reg;$y++){


					if(!empty($array[$y][0]))
					{
					echo"
					<div class='contenedor-$y'>";
				    	require_once '../../conexion/conex_mysql.php';
				    	$mysqli = new mysqli ($hostname,$username,$password,$database);
						if ($mysqli->connect_errno){
							die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
						}
						$grupo=$array[$y][0];
						$carrera=$array[$y][1];
						$query="SELECT * FROM alumnos_datos_personales T1 INNER JOIN semaforos_caracterizacion T2 ON T1.se_no_ficha=T2.no_ficha INNER JOIN alumnos_caracterizacion T3 ON T1.se_no_ficha=T3.se_no_ficha WHERE sa_grupo_gen='$grupo' AND dp_carrera='$carrera' ORDER BY dp_ap_paterno";
						
						$resultado = $mysqli->query($query);
						$arreglo=mysqli_num_rows($resultado);	
						
								//$array=mysqli_fetch_row($resultado);
						$cont=1;
						if($arreglo!=0){
						$arreg[0]=$arreglo;
						echo "
						<form id='form1' name='form1' method='post' action='guardar_calif_algebra.php'>
							<table border='1' width='700'>
								<tr align='center'>
									<td><bb>Ficha</bb></td>
									<td><bb>Nombre</bb></td>
									<td><bb>Apellido Paterno</bb></td>
									<td><bb>Apellido Materno</bb></td>
									<td><bb>Calificación</bb></td>
								</tr>";
					 		while($rows=mysqli_fetch_array($resultado)){
					 			$cal=$rows['doc_curso_algebra_res'];
								echo "
								<tr>
									<td><pp>".$rows['se_no_ficha']."</pp></td>
									<td><pp>".$rows['dp_nombre']."</pp></td>
									<td><pp>".$rows['dp_ap_paterno']."</pp></td>
									<td><pp>".$rows['dp_ap_materno']."</pp></td>
									<td><input type='text' name=tx".$cont." id='textfield' value='$cal' size='3'/></td>
								</tr>";
								$arreg[$cont]=$rows['se_no_ficha'];
								$cont++;
							
					 		}
					 		$nombre="contAlumnos".$y;
					 		$_SESSION[$nombre] = $arreg;
					 		echo "
					 		</table>
					 		<table width='700'>
  								<tr align='right'><br>
  								<input name='nombre' id='nombre' value='$nombre' hidden></input>
  									<td><input type='submit' name='button' id='button' value='Registrar' /></td>
    							</tr>
  							</table>
						</form>";
						}
						else {
						echo "
						<table width='700'>
							<tr>
								<td align='center'> <br>
									<img src='../../images/no_results3.png' alt='consulta'>
								</td>
							</tr>
						</table>";							
						}
				        echo "	
					</div>";
					}
				
				
				}
		       	echo "
		       	</div>
		    </section>
		</div>";
        }

	}

	function asignar_calif_regularizacion($carrera){
		session_start();
		require_once '../../conexion/conex_mysql.php';
		require_once '../../consultas/sentencias_consulta_con_distinc.php';
		$mysqli = new mysqli ($hostname,$username,$password,$database);
		if ($mysqli->connect_errno){
			die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
		}		
		switch ($carrera) {
			case 'bioquimica':
				$query = $bioquimica;
				break;
			
			case 'gestion':
				$query = $gestion;
				break;

			case 'industrial':
				$query = $industrial;
				break;

			case 'meca':
				$query = $meca;
				break;

			case 'nano':
				$query = $nano;
				break;

			case 'sistemas':
				$query = $sistemas;
				break;

			case 'tics':
				$query = $tics;
				break;
		}		

		$resultado = $mysqli->query($query);
		$mysqli->close();
		$reg = mysqli_num_rows($resultado);
		
		$cont=1;
		if($reg!=0){
			while($rows=mysqli_fetch_array($resultado)){
				$array[$cont][0]=$rows['sa_grupo_gen'];
				$array[$cont][1]=$rows['dp_carrera'];
				$cont++;
			}
			
			echo "
		<div class='container'>
			<section class='tabs'>";
			for($x=1;$x<=$reg;$x++){
				if(!empty($array[$x][0])){
				echo"
	           	<input id='tab-$x' type='radio' name='radio-set' class='tab-selector-$x' checked='checked' style='visibility:hidden'/>
		       	<label for='tab-$x' class='tab-label-$x'><stroke-2>".$array[$x][0]."</stroke-2></label>";

				}
			}
		    echo "
			    <div class='clear-shadow'></div>
			    <div class='contenedor'>";
				for ($y=0;$y<=$reg;$y++){


					if(!empty($array[$y][0]))
					{
					echo"
					<div class='contenedor-$y'>";
				    	require_once '../../conexion/conex_mysql.php';
				    	$mysqli = new mysqli ($hostname,$username,$password,$database);
						if ($mysqli->connect_errno){
							die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
						}
						$grupo=$array[$y][0];
						$carrera=$array[$y][1];
						$query="SELECT * FROM alumnos_datos_personales T1 INNER JOIN semaforos_caracterizacion T2 ON T1.se_no_ficha=T2.no_ficha INNER JOIN alumnos_caracterizacion T3 ON T1.se_no_ficha=T3.se_no_ficha WHERE sa_grupo_gen='$grupo' AND dp_carrera='$carrera' ORDER BY dp_ap_paterno";
						
						$resultado = $mysqli->query($query);
						$arreglo=mysqli_num_rows($resultado);	
						
								//$array=mysqli_fetch_row($resultado);
						$cont=1;
						if($arreglo!=0){
						$arreg[0]=$arreglo;
						echo "
						<form id='form1' name='form1' method='post' action='guardar_calif_regularizacion.php'>
							<table border='1' width='700'>
								<tr align='center'>
									<td><bb>Ficha</bb></td>
									<td><bb>Nombre</bb></td>
									<td><bb>Apellido Paterno</bb></td>
									<td><bb>Apellido Materno</bb></td>
									<td><bb>Calificación</bb></td>
								</tr>";
					 		while($rows=mysqli_fetch_array($resultado)){
					 			$cal=$rows['doc_curso_regul_res'];
								echo "
								<tr>
									<td><pp>".$rows['se_no_ficha']."</pp></td>
									<td><pp>".$rows['dp_nombre']."</pp></td>
									<td><pp>".$rows['dp_ap_paterno']."</pp></td>
									<td><pp>".$rows['dp_ap_materno']."</pp></td>
									<td><input type='text' name=tx".$cont." id='textfield' value='$cal' size='3'/></td>
								</tr>";
								$arreg[$cont]=$rows['se_no_ficha'];
								$cont++;
							
					 		}
					 		$nombre="contAlumnos".$y;
					 		$_SESSION[$nombre] = $arreg;
					 		echo "
					 		</table>
					 		<table width='700'>
  								<tr align='right'><br>
  								<input name='nombre' id='nombre' value='$nombre' hidden></input>
  									<td><input type='submit' name='button' id='button' value='Registrar' /></td>
    							</tr>
  							</table>
						</form>";
						}
						
				        echo "	
					</div>";
					}
				
				
				}
		       	echo "
		       	</div>
		    </section>
		</div>";
        }
	}
function consultar_calif($carrera){
	session_start();
	require_once '../../conexion/conex_mysql.php';
	require_once '../../consultas/sentencias_consulta_con_distinc.php';
	$mysqli = new mysqli ($hostname,$username,$password,$database);
	if ($mysqli->connect_errno){
		die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
	}		

	switch ($carrera) {
		case 'bioquimica':
			$query = $bioquimica;
			break;
		
		case 'gestion':
			$query = $gestion;
			break;

		case 'industrial':
			$query = $industrial;
			break;

		case 'meca':
			$query = $meca;
			break;

		case 'nano':
			$query = $nano;
			break;

		case 'sistemas':
			$query = $sistemas;
			break;

		case 'tics':
			$query = $tics;
			break;
	}		
	
	$resultado = $mysqli->query($query);
	$mysqli->close();
	$reg = mysqli_num_rows($resultado);
	
	$cont=1;
	if($reg!=0){
	while($rows=mysqli_fetch_array($resultado)){
		$array[$cont][0]=$rows['sa_grupo_gen'];
		$array[$cont][1]=$rows['dp_carrera'];
		$cont++;
	}
	echo "
	<div class='container'>
		<section class='tabs'>";
		for($x=1;$x<=$reg;$x++){
			if(!empty($array[$x][0])){
			echo"
	       	<input id='tab-$x' type='radio' name='radio-set' class='tab-selector-$x' checked='checked' style='visibility:hidden'/>
		   	<label for='tab-$x' class='tab-label-$x'><stroke-2>".$array[$x][0]."</stroke-2></label>";

			}
		}
		echo "
		    <div class='clear-shadow'></div>
		    <div class='contenedor'>";
			for ($y=0;$y<=$reg;$y++){
				
				
				if(!empty($array[$y][0])){
				echo"
				<div class='contenedor-$y'>";
					require_once '../../consultas/sentencias_consulta.php';
					$mysqli = new mysqli ($hostname,$username,$password,$database);
					if ($mysqli->connect_errno){
						die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
					}		
					$grupo=$array[$y][0];
					$carrera=$array[$y][1];
					$query="SELECT * FROM alumnos_datos_personales T1 INNER JOIN semaforos_caracterizacion T2 ON T1.se_no_ficha=T2.no_ficha INNER JOIN alumnos_caracterizacion T3 ON T1.se_no_ficha=T3.se_no_ficha WHERE sa_grupo_gen='$grupo' AND dp_carrera='$carrera' ORDER BY dp_ap_paterno";
						
					$resultado = $mysqli->query($query);
					$arreglo=mysqli_num_rows($resultado);	
						
								//$array=mysqli_fetch_row($resultado);
					$cont=1;
					if($arreglo!=0){
						$arreg[0]=$arreglo;
						echo
					"<table border='1'>
						<tr align='center'>
							<td><bb>Ficha</bb></td>
							<td><bb>Nombre</bb></td>
							<td><bb>Apellido Paterno</bb></td>
							<td><bb>Apellido Materno</bb></td>
							<td><bb>Calif. Cs. Básicas</bb></td>
							<td><bb>Calif. Regul. de Perfil</bb></td>
						</tr>";
						while($rows=mysqli_fetch_array($resultado)){
							$algebra=($rows['doc_curso_algebra_res']);
							$regul=($rows['doc_curso_regul_res']);
						echo "
						<tr>
							<td><pp>".$rows['se_no_ficha']."</pp></td>
							<td><pp>".$rows['dp_nombre']."</pp></td>
							<td><pp>".$rows['dp_ap_paterno']."</pp></td>
							<td><pp>".$rows['dp_ap_materno']."</pp></td>
							<td><input type='text' name=tx".$cont." id='textfield' value='$algebra' size='3' readonly /></td>
							<td><input type='text' name=tx".$cont." id='textfield' value='$regul' size='3' readonly /></td>
						</tr>";
							
							$cont++;
						}
						echo "
					</table>";
							
						}
					echo"
				</div>";
					}
			    
			}
			echo "</div>
			</section>
		</div>";
	}
}
	
	function consulta_carr(){	
	echo "
	<div class='container'>
		<section class='tabs'>
            <input id='tab-1' type='radio' name='radio-set' class='tab-selector-1' checked='checked' style='visibility:hidden'/>
	        <label for='tab-1' class='tab-label-1'><stroke-2>BIO</label>

	       	<input id='tab-2' type='radio' name='radio-set' class='tab-selector-2' style='visibility:hidden'/>
	        <label for='tab-2' class='tab-label-2'><stroke-2>GEST</label>
	
            <input id='tab-3' type='radio' name='radio-set' class='tab-selector-3' style='visibility:hidden'/>
	        <label for='tab-3' class='tab-label-3'><stroke-2>IND</label>

	        <input id='tab-4' type='radio' name='radio-set' class='tab-selector-4' style='visibility:hidden'/>
	        <label for='tab-4' class='tab-label-4'><stroke-2>MECA</label>

	        <input id='tab-5' type='radio' name='radio-set' class='tab-selector-5' style='visibility:hidden'/>
	        <label for='tab-5' class='tab-label-5'><stroke-2>NANO</label>

	        <input id='tab-6' type='radio' name='radio-set' class='tab-selector-6' style='visibility:hidden'/>
	        <label for='tab-6' class='tab-label-6'><stroke-2>SIST</label>

	        <input id='tab-7' type='radio' name='radio-set' class='tab-selector-7' style='visibility:hidden'/>
	        <label for='tab-7' class='tab-label-7'><stroke-2>TICS</label>
			                        
		    <div class='clear-shadow'></div>
		    <div class='contenedor'>";
		    	$arreglo[1]='Ingeniería Bioquímica';
		    	$arreglo[2]='Gestión Empresarial';
		    	$arreglo[3]='Ingeniería Industrial';
		    	$arreglo[4]='Ingeniería Mecatrónica';
		    	$arreglo[5]='Ingeniería en Nanotecnología';
		    	$arreglo[6]='Ingeniería en Sistemas Computacionales';
		    	$arreglo[7]='Ingeniería Tecnologías de la Información y Comunicaciones';
		    	for($i=1;$i<=7;$i++){
		    		echo"
		    		<div class='contenedor-$i'>
		        		<form name='carr".$i."' method='POST' action='carrera.php'>
		        			<table width='675'>
		        				<tr>
		        					<td width='550'>";
		        						echo "<ba>".$arreglo[$i]."</ba>
		        					</td>
		        					<td>
		        						<input type='hidden' value='$i' name='carrera'>
		        						<input type='submit' value='Consultar' name='consulta_carrera'>
		        					</td>
		        				</tr>
		        			</table>
		        		</form>
				    </div>";
				}
				echo"
			</div>
		</section>
	</div>";

	}
	function carrera($carrera){
		require_once '../consultas/sentencias_consulta_carreras.php';
		$arreglo[1]=$bioquimica;
		$arreglo[2]=$gestion;
		$arreglo[3]=$industrial;
		$arreglo[4]=$meca;
		$arreglo[5]=$nano;
		$arreglo[6]=$sistemas;
		$arreglo[7]=$tics;

		$nombre[1]="Bioq";
		$nombre[2]="Gest";
		$nombre[3]="Ind";
		$nombre[4]="Meca";
		$nombre[5]="Nano";
		$nombre[6]="Sist";
		$nombre[7]="Tics";

		require_once '../consultas/sentencias_total_alumnos.php';
		$alumnos[1]=$bio;
		$alumnos[2]=$ges;
		$alumnos[3]=$ind;
		$alumnos[4]=$mec;
		$alumnos[5]=$nan;
		$alumnos[6]=$sis;
		$alumnos[7]=$tic;


		echo"
		<div class='container'>
			<section class='tabs'>
            	<input id='tab-1' type='radio' name='radio-set' class='tab-selector-1' checked='checked' style='visibility:hidden'/>
            	<label for='tab-1' class='tab-label-1'><stroke-2>".$nombre[$carrera]."</label>
				<form action='carrera_filtrar.php' method='POST'>
					<table width='675'>
						<tr>
							<td width='600'></td>
							<td>
								<input type='hidden' name='carrera' value='$carrera'>
								<input type='submit' name='filtrar' value='Filtrar'>
							</td>
						</tr>
					</table>
				</form>
            	
		    	<div class='clear-shadow'></div>
		    	<div class='contenedor'>
		    		<div class='contenedor-1'>";
			        	require_once '../conexion/conex_mysql.php';
						$mysqli = new mysqli ($hostname,$username,$password,$database);
						if ($mysqli->connect_errno){
							die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
						}

						$query = $alumnos[$carrera];
						$resultado = $mysqli->query($query);
						$rows=mysqli_fetch_array($resultado);
						echo "
							<table width='675'>
								<tr align='right'>
									<td><stroke><b>Total de Alumnos:".$rows[0]."</b></stroke></td>
								</tr>
							</table>";
						

						$query = $arreglo[$carrera];
						$resultado = $mysqli->query($query);
						$array=mysqli_num_rows($resultado);														
					 	if (!empty($array)){


					 		while($rows=mysqli_fetch_array($resultado)){								
							$ficha=($rows['se_no_ficha']);
							$nombre=($rows['dp_nombre']);
							$apaterno=($rows['dp_ap_paterno']);
							$amaterno=($rows['dp_ap_materno']);
							$sexo=($rows['dp_sexo']);
							$edocivil=($rows['dp_edo_civil']);
							$hijos=($rows['dp_hijos']);
							$foraneo=($rows['smf_foraneo']);								
							$trabaja=($rows['smf_trabaja']);
							$tutorias=($rows['smf_tut']);
							$cb=($rows['smf_cb']);
							$jc=($rows['smf_jef_car']);
							$grupo=($rows['sa_grupo_gen']);								
							echo "
							<fieldset><legend><stroke><b>FICHA ".$ficha."</legend>
								<form name='Form".$ficha."' method='POST' action='consulta_individual_carrera.php'>
									<table width='670' border='0'>
										<tr>
											<td align='center' width='135'><bb>".$nombre."<br> ".$apaterno."<br>".$amaterno."
												
											<br></td>
											<td align='center'><bb>Sexo<br> ";
												if ($sexo=='h' || $sexo=='H'){
													echo "<img src='../images/masculino.png' alt='Sexo' height='65' width='65' title='Hombre'>";	
												}
												else {
													echo "<img src='../images/femenino.png' alt='Sexo' height='65' width='65' title='Mujer'>";	
												}
											echo "</td>
											<td align='center'><bb>Estado Civil<br>";
											if ($edocivil==0){
												echo "<img src='../images/clock.png' alt='Edo civil' height='65' width='65' title='Sin Asignar Aún'>";
											}
											else if ($edocivil==1){
												echo "<img src='../images/soltero.png' alt='Edo civil' height='65' width='65' title='Soltero'>";
											}
											else if ($edocivil==2){
												echo "<img src='../images/casado2.png' alt='Edo civil' height='65' width='65' title='Casado'>";
											}
											else {
												echo "<img src='../images/otro.png' alt='Edo civil' height='65' width='65' title='Otro'>";
											}
											echo "	
											</td>
											<td align='center'><bb>Hijos<br>";
												if ($hijos==1){
													echo "<img src='../images/baby.png' alt='Hijos' title='Con Hijos' height='65' width='65'>";	
												}
												else {
													echo "<img src='../images/cross.png' alt='Hijos' height='65' width='65' title='Sin Hijos'>";	
												}
												echo "
											</td>
											<td align='center'><bb>Trabaja<br>";
												if ($trabaja==0){
													echo "<img src='../images/cross.png' alt='Trabaja' title='No Trabaja' height='65' width='65'>";	
												}
												else if ($trabaja==1){
													echo "<img src='../images/ok2.png' alt='Trabaja' title='Si Trabaja' height='65' width='65'>";	
												}
												
												echo "
											</td>
										</tr>
										
										<tr>
											<td align='center'><stroke><b>Grupo<br><br>".$grupo."</td>
											<td align='center'><bb>Foráneo<br>";
											if ($foraneo==1){
												echo "<img src='../images/bus.png' alt='Foraneo' height='65' width='65' title='Foráneo'>";
											}
											else {
												echo "<img src='../images/home2.png' alt='Foraneo' height='65' width='65' title='Local'>";
											} 
											echo "	
											</td>
											<td align='center'><bb>Tutorías<br>";
											if ($tutorias==0){
												echo "<img src='../images/semaforos/blue.png' alt='Tutorías' height='65' width='65' title='Sin Asignar Aún'>";
											}
											else if ($tutorias==1){
												echo "<img src='../images/semaforos/green.png' alt='Tutorías' title='Bien' height='65' width='65'>";
											}
											else if ($tutorias==2){
												echo "<img src='../images/semaforos/yellow.png' alt='Tutorías' title='Leve' height='65' width='65'>";
											}
											else if ($tutorias==3){
												echo "<img src='../images/semaforos/naranja.png' alt='Tutorías' title='Moderado' height='65' width='65'>";
											}
											else {
												echo "<img src='../images/semaforos/red.png' alt='Tutorías' title='Grave' height='65' width='65'>";
											}
											echo "
											</td>
											<td align='center'><bb>C. Básicas<br>";
												if ($cb==0){
												echo "<img src='../images/semaforos/blue.png' alt='C.Basicas' height='65' width='65' title='Sin Asignar'>";
											}
											else if ($cb>85){
												echo "<img src='../images/semaforos/green.png' alt='C.Basicas' height='65' width='65' title='Bien'>";
											}
											else if ($cb>70){
												echo "<img src='../images/semaforos/yellow.png' alt='C.Basicas' height='65' width='65' title='Leve'>";
											}
											else if ($cb>50){
												echo "<img src='../images/semaforos/naranja.png' alt='C.Basicas' height='65' width='65' title='Moderado'>";
											}
											else {
												echo "<img src='../images/semaforos/red.png' alt='C.Basicas' height='65' width='65' title='Grave'>";
											}
											echo "
											</td>
											<td align='center'><bb>J. de Carrera<br>";
											if ($jc==0){
												echo "<img src='../images/semaforos/blue.png' alt='J.Carrera' title='Sin Asignar Aún' height='65' width='65'>";
											}
											else if ($jc==1){
												echo "<img src='../images/semaforos/green.png' alt='J.Carrera' title='Bien' height='65' width='65'>";
											}
											else if ($jc==2){
												echo "<img src='../images/semaforos/yellow.png' alt='J.Carrera' title='Leve' height='65' width='65'>";
											}
											else if ($jc==3){
												echo "<img src='../images/semaforos/naranja.png' alt='J.Carrera' height='65' width='65' title='Moderado'>";
											}
											else {
												echo "<img src='../images/semaforos/red.png' alt='J.Carrera' height='65' width='65' title='Grave'>";
											}
											echo "
											</td>
										</tr>
									</table>
									<table align='right'>
										<tr>
											<td> <br>
												<input type='text' name='ficha' id='ficha' max='5' size='10' align='right' value='$ficha' hidden>
												<input type='submit' value='Buscar' name='guardar' id='guardar'>
											</td>
										</tr>
									</table>
								</form>
							</fieldset>";								
							}
						
					 	
					 	}
						else {
							echo "
							<table width='700'>
								<tr>
									<td align='center'> <br>
										<img src='../images/no_results3.png' alt='consulta'>
									</td>
								</tr>
							</table>";

								
						}
			        	echo "	
				    </div>
				</div>
			</section>
		</div>";
	}
	function consulta_grupo(){
		session_start();
		require_once '../conexion/conex_mysql.php';

		$mysqli = new mysqli ($hostname,$username,$password,$database);
		if ($mysqli->connect_errno){
			die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
		}		

		$query = "SELECT DISTINCT ac.sa_grupo_gen, adp.dp_carrera FROM alumnos_datos_personales adp, alumnos_caracterizacion ac WHERE ac.se_no_ficha=adp.se_no_ficha AND ac.sa_grupo_gen!='' ORDER BY adp.dp_carrera";
		
		$resultado = $mysqli->query($query);
		$mysqli->close();
		$reg = mysqli_num_rows($resultado);

		$cont=1;
		if($reg!=0){
			while($rows=mysqli_fetch_array($resultado)){
				$array[$cont][0]=$rows['sa_grupo_gen'];
				$array[$cont][1]=$rows['dp_carrera'];
				if($rows['dp_carrera']=='INGENIERIA EN SISTEMAS COMPUTACIONALES'){
					$array[$cont][2]='S-'.$rows['sa_grupo_gen'];					
				}else if($rows['dp_carrera']=='INGENIERIA INDUSTRIAL'){
					$array[$cont][2]='I-'.$rows['sa_grupo_gen'];
				}
				else if($rows['dp_carrera']=='INGENIERIA MECATRONICA'){
					$array[$cont][2]='M-'.$rows['sa_grupo_gen'];
				}
				else if($rows['dp_carrera']=='INGENIERIA BIOQUIMICA'){
					$array[$cont][2]='B-'.$rows['sa_grupo_gen'];
				}
				else if($rows['dp_carrera']=='INGENIERIA EN GESTION EMPRESARIAL'){
					$array[$cont][2]='G-'.$rows['sa_grupo_gen'];
				}
				else if($rows['dp_carrera']=='INGENIERÍA EN NANOTECNOLOGÍA'){
					$array[$cont][2]=''.$rows['sa_grupo_gen'];
				}
				else if($rows['dp_carrera']=='INGENIERIA EN TECNOLOGIAS DE LA INFORMACION Y COMUNICACIONES'){
					$array[$cont][2]=''.$rows['sa_grupo_gen'];
				}
				$cont++;
			}
			
			echo "
		<div class='container'>
			<section class='tabs'>";
			for($x=1;$x<=$reg;$x++){
				if(!empty($array[$x][0])){
				echo"
	           	<input id='tab-$x' type='radio' name='radio-set' class='tab-selector-$x' checked='checked' style='visibility:hidden'/>
		       	<label for='tab-$x' class='tab-label-$x'><stroke-2>".$array[$x][2]."</stroke-2></label>";

				}
			}
		    echo "
			    <div class='clear-shadow'></div>
			    <div class='contenedor'>";
				for ($y=1;$y<=$reg;$y++){

					if(!empty($array[$y][0])){
						$grupo=$array[$y][0];
						$carrera=$array[$y][1];
						echo"
					<div class='contenedor-$y'>
						<form name='grupo".$y."' method='POST' action='grupos.php'>
							<table width='675'>
								<tr>
									<td><stroke><ba>".$grupo."</ba> - ".$carrera."</stroke></td>
									<td><input type='submit' value='Consultar' name='consultar'></td>
									<input type='hidden' name='grupo' value='$grupo'>
									<input type='hidden' name='carrera' value='$carrera'>
								</tr>
							</table>
						
					 		
						
				        
				        </form>	
					</div>";
					}
				
				}
		       	echo "
		       	</div>
		    </section>
		</div>";
        }

	}
	function grupos($grupo,$carrera){
		require_once '../conexion/conex_mysql.php';
			
			$mysqli = new mysqli ($hostname,$username,$password,$database);
			if ($mysqli->connect_errno){
				die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
			}
			$query="SELECT * FROM alumnos_datos_personales T1 INNER JOIN semaforos_caracterizacion T2 ON T1.se_no_ficha=T2.no_ficha INNER JOIN alumnos_caracterizacion T3 ON T1.se_no_ficha=T3.se_no_ficha WHERE sa_grupo_gen='$grupo' AND dp_carrera='$carrera'";
			
			echo"
			<div class='container'>
				<section class='tabs'>
				<input id='tab-1' type='radio' name='radio-set' class='tab-selector-1' checked='checked' style='visibility:hidden'/>
            	<label for='tab-1' class='tab-label-1'><stroke-2>".$grupo."</label>
					<div class='clear-shadow'></div>
			    	<div class='contenedor'>
			    		<div class='contenedor-1'>";
			    			$resultado = $mysqli->query($query);
							$array=mysqli_num_rows($resultado);
							echo "
							<table width='675'>
								<tr align='right'>
									<td><stroke><b>Total de Alumnos:".$array."</b></stroke></td>
								</tr>
							</table>";	
							if (!empty($array)){
								while($rows=mysqli_fetch_array($resultado)){							
									$ficha=($rows['se_no_ficha']);
									$nombre=($rows['dp_nombre']);
									$apaterno=($rows['dp_ap_paterno']);
									$amaterno=($rows['dp_ap_materno']);
									$sexo=($rows['dp_sexo']);
									$edocivil=($rows['dp_edo_civil']);
									$hijos=($rows['dp_hijos']);
									$foraneo=($rows['smf_foraneo']);								
									$trabaja=($rows['smf_trabaja']);
									$tutorias=($rows['smf_tut']);
									$cb=($rows['smf_cb']);
									$jc=($rows['smf_jef_car']);
									$grupo=($rows['sa_grupo_gen']);								
							echo "
							<fieldset><legend><stroke><b>FICHA ".$ficha."</legend>
								<form name='Form".$ficha."' method='POST' action='consulta_grupo_individual.php'>
									<table width='670' border='0'>
										<tr>
											<td align='center' width='135'><bb>".$nombre."<br> ".$apaterno."<br>".$amaterno."
												
											<br></td>
											<td align='center'><bb>Sexo<br> ";
												if ($sexo=='h' || $sexo=='H'){
													echo "<img src='../images/masculino.png' alt='Sexo' height='65' width='65' title='Hombre'>";	
												}
												else {
													echo "<img src='../images/femenino.png' alt='Sexo' height='65' width='65' title='Mujer'>";	
												}
											echo "</td>
											<td align='center'><bb>Estado Civil<br>";
											if ($edocivil==0){
												echo "<img src='../images/clock.png' alt='Edo civil' height='65' width='65' title='Sin Asignar Aún'>";
											}
											else if ($edocivil==1){
												echo "<img src='../images/soltero.png' alt='Edo civil' height='65' width='65' title='Soltero'>";
											}
											else if ($edocivil==2){
												echo "<img src='../images/casado2.png' alt='Edo civil' height='65' width='65' title='Casado'>";
											}
											else {
												echo "<img src='../images/otro.png' alt='Edo civil' height='65' width='65' title='Otro'>";
											}
											echo "	
											</td>
											<td align='center'><bb>Hijos<br>";
												if ($hijos==1){
													echo "<img src='../images/baby.png' alt='Hijos' title='Con Hijos' height='65' width='65'>";	
												}
												else {
													echo "<img src='../images/cross.png' alt='Hijos' height='65' width='65' title='Sin Hijos'>";	
												}
												echo "
											</td>
											<td align='center'><bb>Trabaja<br>";
												if ($trabaja==0){
													echo "<img src='../images/cross.png' alt='Trabaja' title='No Trabaja' height='65' width='65'>";	
												}
												else if ($trabaja==1){
													echo "<img src='../images/ok2.png' alt='Trabaja' title='Si Trabaja' height='65' width='65'>";	
												}
												
												echo "
											</td>
										</tr>
										
										<tr>
											<td align='center'><stroke><b>Grupo<br><br>".$grupo."</td>
											<td align='center'><bb>Foráneo<br>";
											if ($foraneo==1){
												echo "<img src='../images/bus.png' alt='Foraneo' height='65' width='65' title='Foráneo'>";
											}
											else {
												echo "<img src='../images/home2.png' alt='Foraneo' height='65' width='65' title='Local'>";
											} 
											echo "	
											</td>
											<td align='center'><bb>Tutorías<br>";
											if ($tutorias==0){
												echo "<img src='../images/semaforos/blue.png' alt='Tutorías' height='65' width='65' title='Sin Asignar Aún'>";
											}
											else if ($tutorias==1){
												echo "<img src='../images/semaforos/green.png' alt='Tutorías' title='Bien' height='65' width='65'>";
											}
											else if ($tutorias==2){
												echo "<img src='../images/semaforos/yellow.png' alt='Tutorías' title='Leve' height='65' width='65'>";
											}
											else if ($tutorias==3){
												echo "<img src='../images/semaforos/naranja.png' alt='Tutorías' title='Moderado' height='65' width='65'>";
											}
											else {
												echo "<img src='../images/semaforos/red.png' alt='Tutorías' title='Grave' height='65' width='65'>";
											}
											echo "
											</td>
											<td align='center'><bb>C. Básicas<br>";
												if ($cb==0){
												echo "<img src='../images/semaforos/blue.png' alt='C.Basicas' height='65' width='65' title='Sin Asignar'>";
											}
											else if ($cb>85){
												echo "<img src='../images/semaforos/green.png' alt='C.Basicas' height='65' width='65' title='Bien'>";
											}
											else if ($cb>70){
												echo "<img src='../images/semaforos/yellow.png' alt='C.Basicas' height='65' width='65' title='Leve'>";
											}
											else if ($cb>50){
												echo "<img src='../images/semaforos/naranja.png' alt='C.Basicas' height='65' width='65' title='Moderado'>";
											}
											else {
												echo "<img src='../images/semaforos/red.png' alt='C.Basicas' height='65' width='65' title='Grave'>";
											}
											echo "
											</td>
											<td align='center'><bb>J. de Carrera<br>";
											if ($jc==0){
												echo "<img src='../images/semaforos/blue.png' alt='J.Carrera' title='Sin Asignar Aún' height='65' width='65'>";
											}
											else if ($jc==1){
												echo "<img src='../images/semaforos/green.png' alt='J.Carrera' title='Bien' height='65' width='65'>";
											}
											else if ($jc==2){
												echo "<img src='../images/semaforos/yellow.png' alt='J.Carrera' title='Leve' height='65' width='65'>";
											}
											else if ($jc==3){
												echo "<img src='../images/semaforos/naranja.png' alt='J.Carrera' height='65' width='65' title='Moderado'>";
											}
											else {
												echo "<img src='../images/semaforos/red.png' alt='J.Carrera' height='65' width='65' title='Grave'>";
											}
											echo "
											</td>
										</tr>
									</table>
									<table align='right'>
										<tr>
											<td> <br>
												<input type='text' name='ficha' id='ficha' max='5' size='10' align='right' value='$ficha' hidden>
												<input type='submit' value='Buscar' name='guardar' id='guardar'>
											</td>
										</tr>
									</table>
								</form>
							</fieldset>";								
								}
							}
						echo"
						</div>
					</div>
				</section>
			</div>";
	}
	
	function asentar(){
	echo "
	<div class='container'>
		<section class='tabs'>
            <input id='tab-1' type='radio' name='radio-set' class='tab-selector-1' checked='checked' style='visibility:hidden'/>
	        <label for='tab-1' class='tab-label-1'><stroke-2>BIO</label>

	       	<input id='tab-2' type='radio' name='radio-set' class='tab-selector-2' style='visibility:hidden'/>
	        <label for='tab-2' class='tab-label-2'><stroke-2>GEST</label>
	
            <input id='tab-3' type='radio' name='radio-set' class='tab-selector-3' style='visibility:hidden'/>
	        <label for='tab-3' class='tab-label-3'><stroke-2>IND</label>

	        <input id='tab-4' type='radio' name='radio-set' class='tab-selector-4' style='visibility:hidden'/>
	        <label for='tab-4' class='tab-label-4'><stroke-2>MECA</label>

	        <input id='tab-5' type='radio' name='radio-set' class='tab-selector-5' style='visibility:hidden'/>
	        <label for='tab-5' class='tab-label-5'><stroke-2>NANO</label>

	        <input id='tab-6' type='radio' name='radio-set' class='tab-selector-6' style='visibility:hidden'/>
	        <label for='tab-6' class='tab-label-6'><stroke-2>SIST</label>

	        <input id='tab-7' type='radio' name='radio-set' class='tab-selector-7' style='visibility:hidden'/>
	        <label for='tab-7' class='tab-label-7'><stroke-2>TICS</label>
			                        
		    <div class='clear-shadow'></div>
		    <div class='contenedor'>";
		    	$arreglo[1]='Ingeniería Bioquímica';
		    	$arreglo[2]='Gestión Empresarial';
		    	$arreglo[3]='Ingeniería Industrial';
		    	$arreglo[4]='Ingeniería Mecatrónica';
		    	$arreglo[5]='Ingeniería en Nanotecnología';
		    	$arreglo[6]='Ingeniería en Sistemas Computacionales';
		    	$arreglo[7]='Ingeniería Tecnologías de la Información y Comunicaciones';
		    	for($i=1;$i<=7;$i++){
		    		echo"
		    		<div class='contenedor-$i'>
		        		<form name='carr".$i."' method='POST' action='asentar_carrera.php'>
		        			<table width='675'>
		        				<tr>
		        					<td width='550'>";
		        						echo "<ba>".$arreglo[$i]."</ba>
		        					</td>
		        					<td>
		        						<input type='hidden' value='$i' name='carrera'>
		        						<input type='submit' value='Consultar' name='consulta_carrera'>
		        					</td>
		        				</tr>
		        			</table>
		        		</form>
				    </div>";
				}
				echo"
			</div>
		</section>
		<section class='tabs'>
		<br>
		<br>
		<br>
		<br>
		<br>
			<div class='container'>
				<fieldset>
				<table width='100%' align='center'>
					<form name='' action='diagnostico_individual.php' method='POST'>
					<tr>
						<td width='75%'><ba>Asentar Individualmente:</ba>
						</td>
						
						<td>
							<input type='text' size='5' name='ficha'>
							<input type='submit' value='Buscar'>
						</td>
					</tr>
					</form>
				</table>
				</fieldset>
			</div>
		</section>
		
	</div>";

	
	}
	function carrera_diagnostico($carrera){

		require_once '../consultas/sentencias_consulta_carreras.php';
		$arreglo[1]=$bioquimica;
		$arreglo[2]=$gestion;
		$arreglo[3]=$industrial;
		$arreglo[4]=$meca;
		$arreglo[5]=$nano;
		$arreglo[6]=$sistemas;
		$arreglo[7]=$tics;

		$nombre[1]="Bioq";
		$nombre[2]="Gest";
		$nombre[3]="Ind";
		$nombre[4]="Meca";
		$nombre[5]="Nano";
		$nombre[6]="Sist";
		$nombre[7]="Tics";

		require_once '../consultas/sentencias_total_alumnos.php';
		$alumnos[1]=$bio;
		$alumnos[2]=$ges;
		$alumnos[3]=$ind;
		$alumnos[4]=$mec;
		$alumnos[5]=$nan;
		$alumnos[6]=$sis;
		$alumnos[7]=$tic;


		echo"
		<div class='container'>
			<section class='tabs'>
            	<input id='tab-1' type='radio' name='radio-set' class='tab-selector-1' checked='checked' style='visibility:hidden'/>
            	<label for='tab-1' class='tab-label-1'><stroke-2>".$nombre[$carrera]."</label>
	                                
		    	<div class='clear-shadow'></div>
		    	<div class='contenedor'>
		    		<div class='contenedor-1'>";
			        	require_once '../conexion/conex_mysql.php';
						$mysqli = new mysqli ($hostname,$username,$password,$database);
						if ($mysqli->connect_errno){
							die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
						}

						$query = $alumnos[$carrera];
						$resultado = $mysqli->query($query);
						$rows=mysqli_fetch_array($resultado);
						echo "
							<table width='675'>
								<tr align='right'>
									<td><stroke><b>Total de Alumnos:".$rows[0]."</b></stroke></td>
								</tr>
							</table>";
						

						$query = $arreglo[$carrera];
						$resultado = $mysqli->query($query);
						$array=mysqli_num_rows($resultado);														
					 	if (!empty($array)){


					 		while($rows=mysqli_fetch_array($resultado)){								
							$ficha=($rows['se_no_ficha']);
							$nombre=($rows['dp_nombre']);
							$apaterno=($rows['dp_ap_paterno']);
							$amaterno=($rows['dp_ap_materno']);
							$sexo=($rows['dp_sexo']);
							$edocivil=($rows['dp_edo_civil']);
							$hijos=($rows['dp_hijos']);
							$foraneo=($rows['smf_foraneo']);								
							$trabaja=($rows['smf_trabaja']);
							$tutorias=($rows['smf_tut']);
							$cb=($rows['smf_cb']);
							$jc=($rows['smf_jef_car']);
							$grupo=($rows['sa_grupo_gen']);								
							echo "
							<fieldset><legend><stroke><b>FICHA ".$ficha."</legend>
								<form name='Form".$ficha."' method='POST' action='diagnostico_individual.php'>
									<table width='670' border='0'>
										<tr>
											<td align='center' width='135'><bb>".$nombre."<br> ".$apaterno."<br>".$amaterno."
												
											<br></td>
											<td align='center'><bb>Sexo<br> ";
												if ($sexo=='h' || $sexo=='H'){
													echo "<img src='../images/masculino.png' alt='Sexo' height='65' width='65' title='Hombre'>";	
												}
												else {
													echo "<img src='../images/femenino.png' alt='Sexo' height='65' width='65' title='Mujer'>";	
												}
											echo "</td>
											<td align='center'><bb>Estado Civil<br>";
											if ($edocivil==0){
												echo "<img src='../images/clock.png' alt='Edo civil' height='65' width='65' title='Sin Asignar Aún'>";
											}
											else if ($edocivil==1){
												echo "<img src='../images/soltero.png' alt='Edo civil' height='65' width='65' title='Soltero'>";
											}
											else if ($edocivil==2){
												echo "<img src='../images/casado2.png' alt='Edo civil' height='65' width='65' title='Casado'>";
											}
											else {
												echo "<img src='../images/otro.png' alt='Edo civil' height='65' width='65' title='Otro'>";
											}
											echo "	
											</td>
											<td align='center'><bb>Hijos<br>";
												if ($hijos==1){
													echo "<img src='../images/baby.png' alt='Hijos' title='Con Hijos' height='65' width='65'>";	
												}
												else {
													echo "<img src='../images/cross.png' alt='Hijos' height='65' width='65' title='Sin Hijos'>";	
												}
												echo "
											</td>
											<td align='center'><bb>Trabaja<br>";
												if ($trabaja==0){
													echo "<img src='../images/cross.png' alt='Trabaja' title='No Trabaja' height='65' width='65'>";	
												}
												else if ($trabaja==1){
													echo "<img src='../images/ok2.png' alt='Trabaja' title='Si Trabaja' height='65' width='65'>";	
												}
												
												echo "
											</td>
										</tr>
										
										<tr>
											<td align='center'><stroke><b>Grupo<br><br>".$grupo."</td>
											<td align='center'><bb>Foráneo<br>";
											if ($foraneo==1){
												echo "<img src='../images/bus.png' alt='Foraneo' height='65' width='65' title='Foráneo'>";
											}
											else {
												echo "<img src='../images/home2.png' alt='Foraneo' height='65' width='65' title='Local'>";
											} 
											echo "	
											</td>
											<td align='center'><bb>Tutorías<br>";
											if ($tutorias==0){
												echo "<img src='../images/semaforos/blue.png' alt='Tutorías' height='65' width='65' title='Sin Asignar Aún'>";
											}
											else if ($tutorias==1){
												echo "<img src='../images/semaforos/green.png' alt='Tutorías' title='Bien' height='65' width='65'>";
											}
											else if ($tutorias==2){
												echo "<img src='../images/semaforos/yellow.png' alt='Tutorías' title='Leve' height='65' width='65'>";
											}
											else if ($tutorias==3){
												echo "<img src='../images/semaforos/naranja.png' alt='Tutorías' title='Moderado' height='65' width='65'>";
											}
											else {
												echo "<img src='../images/semaforos/red.png' alt='Tutorías' title='Grave' height='65' width='65'>";
											}
											echo "
											</td>
											<td align='center'><bb>C. Básicas<br>";
												if ($cb==0){
												echo "<img src='../images/semaforos/blue.png' alt='C.Basicas' height='65' width='65' title='Sin Asignar'>";
											}
											else if ($cb>85){
												echo "<img src='../images/semaforos/green.png' alt='C.Basicas' height='65' width='65' title='Bien'>";
											}
											else if ($cb>70){
												echo "<img src='../images/semaforos/yellow.png' alt='C.Basicas' height='65' width='65' title='Leve'>";
											}
											else if ($cb>50){
												echo "<img src='../images/semaforos/naranja.png' alt='C.Basicas' height='65' width='65' title='Moderado'>";
											}
											else {
												echo "<img src='../images/semaforos/red.png' alt='C.Basicas' height='65' width='65' title='Grave'>";
											}
											echo "
											</td>
											<td align='center'><bb>J. de Carrera<br>";
											if ($jc==0){
												echo "<img src='../images/semaforos/blue.png' alt='J.Carrera' title='Sin Asignar Aún' height='65' width='65'>";
											}
											else if ($jc==1){
												echo "<img src='../images/semaforos/green.png' alt='J.Carrera' title='Bien' height='65' width='65'>";
											}
											else if ($jc==2){
												echo "<img src='../images/semaforos/yellow.png' alt='J.Carrera' title='Leve' height='65' width='65'>";
											}
											else if ($jc==3){
												echo "<img src='../images/semaforos/naranja.png' alt='J.Carrera' height='65' width='65' title='Moderado'>";
											}
											else {
												echo "<img src='../images/semaforos/red.png' alt='J.Carrera' height='65' width='65' title='Grave'>";
											}
											echo "
											</td>
										</tr>
									</table>
									<table align='right'>
										<tr>
											<td> <br>
												<input type='text' name='ficha' id='ficha' max='5' size='10' align='right' value='$ficha' hidden>
												<input type='submit' value='Asentar' name='guardar' id='guardar'>
											</td>
										</tr>
									</table>
								</form>
							</fieldset>";								
							}
					 	}
						else {
							echo "
							<table width='700'>
								<tr>
									<td align='center'> <br>
										<img src='../images/no_results3.png' alt='consulta'>
									</td>
								</tr>
							</table>";
						}
			        	echo "	
				    </div>
				</div>
			</section>
		</div>";
	}
	function carrera2($carrera){
		//funcion de filtrado para jefes de carrera
		require_once '../../consultas/sentencias_consulta_filtro.php';
		$arreglo[1]=$bioquimica;	$arreglo[2]=$gestion;
		$arreglo[3]=$industrial;	$arreglo[4]=$meca;
		$arreglo[5]=$nano;			$arreglo[6]=$sistemas;
		$arreglo[7]=$tics;
		$nombre[1]="Bioq";		$nombre[2]="Gest";
		$nombre[3]="Ind";		$nombre[4]="Meca";
		$nombre[5]="Nano";		$nombre[6]="Sist";
		$nombre[7]="Tics";
		require_once '../../consultas/sentencias_total_alumnos.php';
		$alumnos[1]=$bio;		$alumnos[2]=$ges;
		$alumnos[3]=$ind;		$alumnos[4]=$mec;
		$alumnos[5]=$nan;		$alumnos[6]=$sis;
		$alumnos[7]=$tic;
		echo"
		<div class='container'>
			<section class='tabs'>
            	<input id='tab-1' type='radio' name='radio-set' class='tab-selector-1' checked='checked' style='visibility:hidden'/>
            	<label for='tab-1' class='tab-label-1'><stroke-2>".$nombre[$carrera]."</label>
		    	<div class='clear-shadow'></div>
		    	<form action='' name='' method='POST'>
			    	<table width='750'>
			    		<tr>
			    			<td width='200'></td>
			    			<td width='250'>
								<pp>Semáforo:</pp>
		            			<select name='semaforo'>
		            				<option value='1'>Tutorías</option>
			            			<option value='2'>C.Básicas</option>
			            			<option value='3'>J.Carrera</option>
		            			</select>
			    			</td>
			    			<td width='240'>
			    				<pp>Criterio:</pp>
		            			<select name='criterio' id='criterio'>
		            		 		<option value='1'>Bien</option>
			            		 	<option value='2'>Leve</option>
			            		 	<option value='3'>Moderado</option>
			            		 	<option value='4'>Grave</option>
			            		 </select> 
			    			</td>
			    			<td width='100'>
			    				<input type='submit' name='ordenar' value='Filtrar'>
			    			</td>
			    		</tr>
			    	</table>					 	
            	</form>";
		    	if (isset($_POST['ordenar']))
		    	{
		    		$semaforo=$_POST['semaforo'];
		    		$criterio=$_POST['criterio'];		    		
		    		echo"<div class='contenedor'>
		    		<div class='contenedor-1'>";
			        	require_once '../../conexion/conex_mysql.php';
						$mysqli = new mysqli ($hostname,$username,$password,$database);
						if ($mysqli->connect_errno){
							die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
						}
						$query = $alumnos[$carrera];
						$query2 = $arreglo[$carrera];
						if($semaforo==1){
							if($criterio==1){
								$query.='AND T2.smf_tut=1';
								$query2.='AND T2.smf_tut=1 ORDER BY dp_ap_paterno ASC';
								$smf='Tutorías';
								$crit='Bien';
							}
							elseif($criterio==2){
								$query.='AND T2.smf_tut=2';
								$query2.='AND T2.smf_tut=2 ORDER BY dp_ap_paterno ASC';
								$smf='Tutorías';
								$crit='Leve';
							}
							elseif($criterio==3){
								$query.='AND T2.smf_tut=3';
								$query2.='AND T2.smf_tut=3 ORDER BY dp_ap_paterno ASC';
								$smf='Tutorías';
								$crit='Moderado';
							}
							else{
								$query.='AND T2.smf_tut=4';
								$query2.='AND T2.smf_tut=4 ORDER BY dp_ap_paterno ASC';
								$smf='Tutorías';
								$crit='Grave';
							}
						}
						elseif($semaforo==2){
							if($criterio==1){
								$query.='AND T2.smf_cb>84';
								$query2.='AND T2.smf_cb>84 ORDER BY dp_ap_paterno ASC';	
								$smf='C.Básicas';
								$crit='Bien';
							}
							elseif($criterio==2){
								$query.='AND T2.smf_cb>69 AND T2.smf_cb<85';
								$query2.='AND T2.smf_cb>69 AND T2.smf_cb<85 ORDER BY dp_ap_paterno ASC';
								$smf='C.Básicas';
								$crit='Leve';	
							}
							elseif($criterio==3){
								$query.='AND T2.smf_cb>49 AND T2.smf_cb<70';
								$query2.='AND T2.smf_cb>49 AND T2.smf_cb<70 ORDER BY dp_ap_paterno ASC';
								$smf='C.Básicas';
								$crit='Moderado';	
							}
							else{
								$query.='AND T2.smf_cb<50 AND T2.smf_cb>0';
								$query2.='AND T2.smf_cb<50 AND T2.smf_cb>0 ORDER BY dp_ap_paterno ASC';	
								$smf='C.Básicas';
								$crit='Grave';
							}	
						}
						else{
							if($criterio==1){
								$query.='AND T2.smf_jef_car=1';
								$query2.='AND T2.smf_jef_car=1 ORDER BY dp_ap_paterno ASC';
								$smf='J.Carrera';
								$crit='Bien';
							}
							elseif($criterio==2){
								$query.='AND T2.smf_jef_car=2';
								$query2.='AND T2.smf_jef_car=2 ORDER BY dp_ap_paterno ASC';
								$smf='J.Carrera';
								$crit='Leve';
							}
							elseif($criterio==3){
								$query.='AND T2.smf_jef_car=3';
								$query2.='AND T2.smf_jef_car=3 ORDER BY dp_ap_paterno ASC';
								$smf='J.Carrera';
								$crit='Moderado';
							}
							else{
								$query.='AND T2.smf_jef_car=4';
								$query2.='AND T2.smf_jef_car=4 ORDER BY dp_ap_paterno ASC';
								$smf='J.Carrera';
								$crit='Grave';
							}
						}
						$resultado = $mysqli->query($query);
						$rows=mysqli_fetch_array($resultado);
						echo "
							<table width='675'>
								<tr align='right'>
									<td width='200'><stroke><b>".$smf."-".$crit."</b><stroke></td>
									<td width='200'><stroke><b>Total de Alumnos:".$rows[0]."</b></stroke></td>
								</tr>
							</table>";
						
						$resultado = $mysqli->query($query2);
						$array=mysqli_num_rows($resultado);														
					 	if (!empty($array)){


					 		while($rows=mysqli_fetch_array($resultado)){								
							$ficha=($rows['se_no_ficha']);
							$nombre=($rows['dp_nombre']);
							$apaterno=($rows['dp_ap_paterno']);
							$amaterno=($rows['dp_ap_materno']);
							$sexo=($rows['dp_sexo']);
							$edocivil=($rows['dp_edo_civil']);
							$hijos=($rows['dp_hijos']);
							$foraneo=($rows['smf_foraneo']);								
							$trabaja=($rows['smf_trabaja']);
							$tutorias=($rows['smf_tut']);
							$cb=($rows['smf_cb']);
							$jc=($rows['smf_jef_car']);
							$grupo=($rows['sa_grupo_gen']);								
							echo "
							<fieldset><legend><stroke><b>FICHA ".$ficha."</legend>
								<form name='Form".$ficha."' method='POST' action='consulta_individual.php'>
									<table width='670' border='0'>
										<tr>
											<td align='center' width='135'><bb>".$nombre."<br> ".$apaterno."<br>".$amaterno."
												
											<br></td>
											<td align='center'><bb>Sexo<br> ";
												if ($sexo=='h' || $sexo=='H'){
													echo "<img src='../../images/masculino.png' alt='Sexo' height='65' width='65' title='Hombre'>";	
												}
												else {
													echo "<img src='../../images/femenino.png' alt='Sexo' height='65' width='65' title='Mujer'>";	
												}
											echo "</td>
											<td align='center'><bb>Estado Civil<br>";
											if ($edocivil==0){
												echo "<img src='../../images/clock.png' alt='Edo civil' height='65' width='65' title='Sin Asignar Aún'>";
											}
											else if ($edocivil==1){
												echo "<img src='../../images/soltero.png' alt='Edo civil' height='65' width='65' title='Soltero'>";
											}
											else if ($edocivil==2){
												echo "<img src='../../images/casado2.png' alt='Edo civil' height='65' width='65' title='Casado'>";
											}
											else {
												echo "<img src='../../images/otro.png' alt='Edo civil' height='65' width='65' title='Otro'>";
											}
											echo "	
											</td>
											<td align='center'><bb>Hijos<br>";
												if ($hijos==1){
													echo "<img src='../../images/baby.png' alt='Hijos' title='Con Hijos' height='65' width='65'>";	
												}
												else {
													echo "<img src='../../images/cross.png' alt='Hijos' height='65' width='65' title='Sin Hijos'>";	
												}
												echo "
											</td>
											<td align='center'><bb>Trabaja<br>";
												if ($trabaja==0){
													echo "<img src='../../images/cross.png' alt='Trabaja' title='No Trabaja' height='65' width='65'>";	
												}
												else if ($trabaja==1){
													echo "<img src='../../images/ok2.png' alt='Trabaja' title='Si Trabaja' height='65' width='65'>";	
												}
												
												echo "
											</td>
										</tr>				
										<tr>
											<td align='center'><stroke><b>Grupo<br><br>".$grupo."</td>
											<td align='center'><bb>Foráneo<br>";
											if ($foraneo==1){
												echo "<img src='../../images/bus.png' alt='Foraneo' height='65' width='65' title='Foráneo'>";
											}
											else {
												echo "<img src='../../images/home2.png' alt='Foraneo' height='65' width='65' title='Local'>";
											} 
											echo "	
											</td>
											<td align='center'><bb>Tutorías<br>";
											if ($tutorias==0){
												echo "<img src='../../images/semaforos/blue.png' alt='Tutorías' height='65' width='65' title='Sin Asignar Aún'>";
											}
											else if ($tutorias==1){
												echo "<img src='../../images/semaforos/green.png' alt='Tutorías' title='Bien' height='65' width='65'>";
											}
											else if ($tutorias==2){
												echo "<img src='../../images/semaforos/yellow.png' alt='Tutorías' title='Leve' height='65' width='65'>";
											}
											else if ($tutorias==3){
												echo "<img src='../../images/semaforos/naranja.png' alt='Tutorías' title='Moderado' height='65' width='65'>";
											}
											else {
												echo "<img src='../../images/semaforos/red.png' alt='Tutorías' title='Grave' height='65' width='65'>";
											}
											echo "
											</td>
											<td align='center'><bb>C. Básicas<br>";
												if ($cb==0){
												echo "<img src='../../images/semaforos/blue.png' alt='C.Basicas' height='65' width='65' title='Sin Asignar'>";
											}
											else if ($cb>=85){
												echo "<img src='../../images/semaforos/green.png' alt='C.Basicas' height='65' width='65' title='Bien'>";
											}
											else if ($cb>=70){
												echo "<img src='../../images/semaforos/yellow.png' alt='C.Basicas' height='65' width='65' title='Leve'>";
											}
											else if ($cb>=50){
												echo "<img src='../../images/semaforos/naranja.png' alt='C.Basicas' height='65' width='65' title='Moderado'>";
											}
											else {
												echo "<img src='../../images/semaforos/red.png' alt='C.Basicas' height='65' width='65' title='Grave'>";
											}
											echo "
											</td>
											<td align='center'><bb>J. de Carrera<br>";
											if ($jc==0){
												echo "<img src='../../images/semaforos/blue.png' alt='J.Carrera' title='Sin Asignar Aún' height='65' width='65'>";
											}
											else if ($jc==1){
												echo "<img src='../../images/semaforos/green.png' alt='J.Carrera' title='Bien' height='65' width='65'>";
											}
											else if ($jc==2){
												echo "<img src='../../images/semaforos/yellow.png' alt='J.Carrera' title='Leve' height='65' width='65'>";
											}
											else if ($jc==3){
												echo "<img src='../../images/semaforos/naranja.png' alt='J.Carrera' height='65' width='65' title='Moderado'>";
											}
											else {
												echo "<img src='../../images/semaforos/red.png' alt='J.Carrera' height='65' width='65' title='Grave'>";
											}
											echo "
											</td>
										</tr>
									</table>
									<table align='right'>
										<tr>
											<td> <br>
												<input type='text' name='ficha' id='ficha' max='5' size='10' align='right' value='$ficha' hidden>
												<input type='submit' value='Buscar' name='guardar' id='guardar'>
											</td>
										</tr>
									</table>
								</form>
							</fieldset>";								
							}
					 	}
						else {
							echo "
							<table width='700'>
								<tr>
									<td align='center'> <br>
										<img src='../../images/no_results3.png' alt='consulta'>
									</td>
								</tr>
							</table>";	
						}
			        	echo "	
				    </div>
				</div>";
		    	}
		    	else{
		    	echo"	<div class='contenedor'>
		    		<div class='contenedor-1'>";
			        	require_once '../../conexion/conex_mysql.php';
						$mysqli = new mysqli ($hostname,$username,$password,$database);
						if ($mysqli->connect_errno){
							die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
						}
						$query = $alumnos[$carrera];
						$resultado = $mysqli->query($query);
						$rows=mysqli_fetch_array($resultado);
						echo "
							<table width='675'>
								<tr align='right'>
									<td><stroke><b>Total de Alumnos:".$rows[0]."</b></stroke></td>
								</tr>
							</table>";
						$query = $arreglo[$carrera];
						$resultado = $mysqli->query($query);
						$array=mysqli_num_rows($resultado);				
					 	if (!empty($array)){
					 		while($rows=mysqli_fetch_array($resultado)){								
							$ficha=($rows['se_no_ficha']);
							$nombre=($rows['dp_nombre']);
							$apaterno=($rows['dp_ap_paterno']);
							$amaterno=($rows['dp_ap_materno']);
							$sexo=($rows['dp_sexo']);
							$edocivil=($rows['dp_edo_civil']);
							$hijos=($rows['dp_hijos']);
							$foraneo=($rows['smf_foraneo']);								
							$trabaja=($rows['smf_trabaja']);
							$tutorias=($rows['smf_tut']);
							$cb=($rows['smf_cb']);
							$jc=($rows['smf_jef_car']);
							$grupo=($rows['sa_grupo_gen']);								
							echo "
							<fieldset><legend><stroke><b>FICHA ".$ficha."</legend>
								<form name='Form".$ficha."' method='POST' action='consulta_individual.php'>
									<table width='670' border='0'>
										<tr>
											<td align='center' width='135'><bb>".$nombre."<br> ".$apaterno."<br>".$amaterno."
												
											<br></td>
											<td align='center'><bb>Sexo<br> ";
												if ($sexo=='h' || $sexo=='H'){
													echo "<img src='../../images/masculino.png' alt='Sexo' height='65' width='65' title='Hombre'>";	
												}
												else {
													echo "<img src='../../images/femenino.png' alt='Sexo' height='65' width='65' title='Mujer'>";	
												}
											echo "</td>
											<td align='center'><bb>Estado Civil<br>";
											if ($edocivil==0){
												echo "<img src='../../images/clock.png' alt='Edo civil' height='65' width='65' title='Sin Asignar Aún'>";
											}
											else if ($edocivil==1){
												echo "<img src='../../images/soltero.png' alt='Edo civil' height='65' width='65' title='Soltero'>";
											}
											else if ($edocivil==2){
												echo "<img src='../../images/casado2.png' alt='Edo civil' height='65' width='65' title='Casado'>";
											}
											else {
												echo "<img src='../../images/otro.png' alt='Edo civil' height='65' width='65' title='Otro'>";
											}
											echo "	
											</td>
											<td align='center'><bb>Hijos<br>";
												if ($hijos==1){
													echo "<img src='../../images/baby.png' alt='Hijos' title='Con Hijos' height='65' width='65'>";	
												}
												else {
													echo "<img src='../../images/cross.png' alt='Hijos' height='65' width='65' title='Sin Hijos'>";	
												}
												echo "
											</td>
											<td align='center'><bb>Trabaja<br>";
												if ($trabaja==0){
													echo "<img src='../../images/cross.png' alt='Trabaja' title='No Trabaja' height='65' width='65'>";	
												}
												else if ($trabaja==1){
													echo "<img src='../../images/ok2.png' alt='Trabaja' title='Si Trabaja' height='65' width='65'>";	
												}
												echo "
											</td>
										</tr>										
										<tr>
											<td align='center'><stroke><b>Grupo<br><br>".$grupo."</td>
											<td align='center'><bb>Foráneo<br>";
											if ($foraneo==1){
												echo "<img src='../../images/bus.png' alt='Foraneo' height='65' width='65' title='Foráneo'>";
											}
											else {
												echo "<img src='../../images/home2.png' alt='Foraneo' height='65' width='65' title='Local'>";
											} 
											echo "	
											</td>
											<td align='center'><bb>Tutorías<br>";
											if ($tutorias==0){
												echo "<img src='../../images/semaforos/blue.png' alt='Tutorías' height='65' width='65' title='Sin Asignar Aún'>";
											}
											else if ($tutorias==1){
												echo "<img src='../../images/semaforos/green.png' alt='Tutorías' title='Bien' height='65' width='65'>";
											}
											else if ($tutorias==2){
												echo "<img src='../../images/semaforos/yellow.png' alt='Tutorías' title='Leve' height='65' width='65'>";
											}
											else if ($tutorias==3){
												echo "<img src='../../images/semaforos/naranja.png' alt='Tutorías' title='Moderado' height='65' width='65'>";
											}
											else {
												echo "<img src='../../images/semaforos/red.png' alt='Tutorías' title='Grave' height='65' width='65'>";
											}
											echo "
											</td>
											<td align='center'><bb>C. Básicas<br>";
												if ($cb==0){
												echo "<img src='../../images/semaforos/blue.png' alt='C.Basicas' height='65' width='65' title='Sin Asignar'>";
											}
											else if ($cb>85){
												echo "<img src='../../images/semaforos/green.png' alt='C.Basicas' height='65' width='65' title='Bien'>";
											}
											else if ($cb>70){
												echo "<img src='../../images/semaforos/yellow.png' alt='C.Basicas' height='65' width='65' title='Leve'>";
											}
											else if ($cb>50){
												echo "<img src='../../images/semaforos/naranja.png' alt='C.Basicas' height='65' width='65' title='Moderado'>";
											}
											else {
												echo "<img src='../../images/semaforos/red.png' alt='C.Basicas' height='65' width='65' title='Grave'>";
											}
											echo "
											</td>
											<td align='center'><bb>J. de Carrera<br>";
											if ($jc==0){
												echo "<img src='../../images/semaforos/blue.png' alt='J.Carrera' title='Sin Asignar Aún' height='65' width='65'>";
											}
											else if ($jc==1){
												echo "<img src='../../images/semaforos/green.png' alt='J.Carrera' title='Bien' height='65' width='65'>";
											}
											else if ($jc==2){
												echo "<img src='../../images/semaforos/yellow.png' alt='J.Carrera' title='Leve' height='65' width='65'>";
											}
											else if ($jc==3){
												echo "<img src='../../images/semaforos/naranja.png' alt='J.Carrera' height='65' width='65' title='Moderado'>";
											}
											else {
												echo "<img src='../../images/semaforos/red.png' alt='J.Carrera' height='65' width='65' title='Grave'>";
											}
											echo "
											</td>
										</tr>
									</table>
									<table align='right'>
										<tr>
											<td> <br>
												<input type='text' name='ficha' id='ficha' max='5' size='10' align='right' value='$ficha' hidden>
												<input type='submit' value='Buscar' name='guardar' id='guardar'>
											</td>
										</tr>
									</table>
								</form>
							</fieldset>";								
							}					
					 	}
						else {
							echo "
							<table width='700'>
								<tr>
									<td align='center'> <br>
										<img src='../../images/no_results3.png' alt='consulta'>
									</td>
								</tr>
							</table>";	
						}
			        	echo "	
				    </div>
				</div>";
		    	}
			echo"</section>
		</div>";
	}			
	function carrera_filtrar($carrera){
		require_once '../conexion/conex_mysql.php';
		$mysqli = new mysqli ($hostname,$username,$password,$database);
		if ($mysqli->connect_errno){
			die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
		}
		//funcion de filtrado para jefes de carrera
		require_once '../consultas/sentencias_consulta_filtro.php';
		$arreglo[1]=$bioquimica;		$arreglo[2]=$gestion;
		$arreglo[3]=$industrial;		$arreglo[4]=$meca;
		$arreglo[5]=$nano;				$arreglo[6]=$sistemas;
		$arreglo[7]=$tics;
		$nombre[1]="Bioq";		$nombre[2]="Gest";
		$nombre[3]="Ind";		$nombre[4]="Meca";
		$nombre[5]="Nano";		$nombre[6]="Sist";
		$nombre[7]="Tics";
		require_once '../consultas/sentencias_total_alumnos.php';
		$alumnos[1]=$bio;		$alumnos[2]=$ges;
		$alumnos[3]=$ind;		$alumnos[4]=$mec;
		$alumnos[5]=$nan;		$alumnos[6]=$sis;
		$alumnos[7]=$tic;
		echo"
		<div class='container'>
			<section class='tabs'>
            	<input id='tab-1' type='radio' name='radio-set' class='tab-selector-1' checked='checked' style='visibility:hidden'/>
            	<label for='tab-1' class='tab-label-1'><stroke-2>".$nombre[$carrera]."</label>
		    	<div class='clear-shadow'></div>
		    	<form action='' name='' method='POST'>
			    	<table width='750'>
			    		<tr>
			    			<td width='200'></td>
			    			<td width='250'>
								<pp>Semáforo:</pp>
		            			<select name='semaforo'>
		            				<option value='1'>Tutorías</option>
			            			<option value='2'>C.Básicas</option>
			            			<option value='3'>J.Carrera</option>
		            			</select>
			    			</td>
			    			<td width='240'>
			    				<pp>Criterio:</pp>
		            			<select name='criterio' id='criterio'>
		            		 		<option value='1'>Bien</option>
			            		 	<option value='2'>Leve</option>
			            		 	<option value='3'>Moderado</option>
			            		 	<option value='4'>Grave</option>
			            		 </select> 
			    			</td>
			    			<td width='100'>
			    				<input type='submit' name='ordenar' value='Filtrar'>
			    			</td>
			    		</tr>
			    	</table>					 	
            	</form>";
		    	if (isset($_POST['ordenar']))
		    	{
		    		$semaforo=$_POST['semaforo'];
		    		$criterio=$_POST['criterio'];		    		
		    		echo"<div class='contenedor'>
		    		<div class='contenedor-1'>";			        	
						$query = $alumnos[$carrera];
						$query2 = $arreglo[$carrera];
						if($semaforo==1){
							if($criterio==1){
								$query.='AND T2.smf_tut=1';
								$query2.='AND T2.smf_tut=1 ORDER BY sa_grupo_gen ASC, dp_ap_paterno ASC';
								$smf='Tutorías';
								$crit='Bien';
							}
							elseif($criterio==2){
								$query.='AND T2.smf_tut=2';
								$query2.='AND T2.smf_tut=2 ORDER BY sa_grupo_gen ASC, dp_ap_paterno ASC';
								$smf='Tutorías';
								$crit='Leve';
							}
							elseif($criterio==3){
								$query.='AND T2.smf_tut=3';
								$query2.='AND T2.smf_tut=3 ORDER BY sa_grupo_gen ASC, dp_ap_paterno ASC';
								$smf='Tutorías';
								$crit='Moderado';
							}
							else{
								$query.='AND T2.smf_tut=4';
								$query2.='AND T2.smf_tut=4 ORDER BY sa_grupo_gen ASC, dp_ap_paterno ASC';
								$smf='Tutorías';
								$crit='Grave';
							}
						}
						elseif($semaforo==2){
							if($criterio==1){
								$query.='AND T2.smf_cb>84';
								$query2.='AND T2.smf_cb>84 ORDER BY sa_grupo_gen ASC, dp_ap_paterno ASC';	
								$smf='C.Básicas';
								$crit='Bien';
							}
							elseif($criterio==2){
								$query.='AND T2.smf_cb>69 AND T2.smf_cb<85';
								$query2.='AND T2.smf_cb>69 AND T2.smf_cb<85 ORDER BY sa_grupo_gen ASC, dp_ap_paterno ASC';
								$smf='C.Básicas';
								$crit='Leve';	
							}
							elseif($criterio==3){
								$query.='AND T2.smf_cb>49 AND T2.smf_cb<70';
								$query2.='AND T2.smf_cb>49 AND T2.smf_cb<70 ORDER BY sa_grupo_gen ASC, dp_ap_paterno ASC';
								$smf='C.Básicas';
								$crit='Moderado';	
							}
							else{
								$query.='AND T2.smf_cb<50 AND T2.smf_cb>0';
								$query2.='AND T2.smf_cb<50 AND T2.smf_cb>0 ORDER BY sa_grupo_gen ASC, dp_ap_paterno ASC';	
								$smf='C.Básicas';
								$crit='Grave';
							}	
						}
						else{
							if($criterio==1){
								$query.='AND T2.smf_jef_car=1';
								$query2.='AND T2.smf_jef_car=1 ORDER BY sa_grupo_gen ASC, dp_ap_paterno ASC';
								$smf='J.Carrera';
								$crit='Bien';
							}
							elseif($criterio==2){
								$query.='AND T2.smf_jef_car=2';
								$query2.='AND T2.smf_jef_car=2 ORDER BY sa_grupo_gen ASC, dp_ap_paterno ASC';
								$smf='J.Carrera';
								$crit='Leve';
							}
							elseif($criterio==3){
								$query.='AND T2.smf_jef_car=3';
								$query2.='AND T2.smf_jef_car=3 ORDER BY sa_grupo_gen ASC, dp_ap_paterno ASC';
								$smf='J.Carrera';
								$crit='Moderado';
							}
							else{
								$query.='AND T2.smf_jef_car=4';
								$query2.='AND T2.smf_jef_car=4 ORDER BY sa_grupo_gen ASC, dp_ap_paterno ASC';
								$smf='J.Carrera';
								$crit='Grave';
							}
						}
						$resultado = $mysqli->query($query);
						$rows=mysqli_fetch_array($resultado);
						echo "
							<table width='675'>
								<tr align='right'>
									<td width='200'><stroke><b>".$smf."-".$crit."</b><stroke></td>
									<td width='200'><stroke><b>Total de Alumnos:".$rows[0]."</b></stroke></td>
								</tr>
							</table>";						
						$resultado = $mysqli->query($query2);
						$mysqli->close();
						$array=mysqli_num_rows($resultado);									
					 	if (!empty($array)){
					 		while($rows=mysqli_fetch_array($resultado)){								
							$ficha=($rows['se_no_ficha']);
							$nombre=($rows['dp_nombre']);
							$apaterno=($rows['dp_ap_paterno']);
							$amaterno=($rows['dp_ap_materno']);
							$sexo=($rows['dp_sexo']);
							$edocivil=($rows['dp_edo_civil']);
							$hijos=($rows['dp_hijos']);
							$foraneo=($rows['smf_foraneo']);								
							$trabaja=($rows['smf_trabaja']);
							$tutorias=($rows['smf_tut']);
							$cb=($rows['smf_cb']);
							$jc=($rows['smf_jef_car']);
							$grupo=($rows['sa_grupo_gen']);								
							echo "
							<fieldset><legend><stroke><b>FICHA ".$ficha."</legend>
								<form name='Form".$ficha."' method='POST' action='consulta_individual_carrera.php'>
									<table width='670' border='0'>
										<tr>
											<td align='center' width='135'><bb>".$nombre."<br> ".$apaterno."<br>".$amaterno."										
											<br></td>
											<td align='center'><bb>Sexo<br> ";
												if ($sexo=='h' || $sexo=='H'){
													echo "<img src='../images/masculino.png' alt='Sexo' height='65' width='65' title='Hombre'>";	
												}
												else {
													echo "<img src='../images/femenino.png' alt='Sexo' height='65' width='65' title='Mujer'>";	
												}
											echo "</td>
											<td align='center'><bb>Estado Civil<br>";
											if ($edocivil==0){
												echo "<img src='../images/clock.png' alt='Edo civil' height='65' width='65' title='Sin Asignar Aún'>";
											}
											else if ($edocivil==1){
												echo "<img src='../images/soltero.png' alt='Edo civil' height='65' width='65' title='Soltero'>";
											}
											else if ($edocivil==2){
												echo "<img src='../images/casado2.png' alt='Edo civil' height='65' width='65' title='Casado'>";
											}
											else {
												echo "<img src='../images/otro.png' alt='Edo civil' height='65' width='65' title='Otro'>";
											}
											echo "	
											</td>
											<td align='center'><bb>Hijos<br>";
												if ($hijos==1){
													echo "<img src='../images/baby.png' alt='Hijos' title='Con Hijos' height='65' width='65'>";	
												}
												else {
													echo "<img src='../images/cross.png' alt='Hijos' height='65' width='65' title='Sin Hijos'>";	
												}
												echo "
											</td>
											<td align='center'><bb>Trabaja<br>";
												if ($trabaja==0){
													echo "<img src='../images/cross.png' alt='Trabaja' title='No Trabaja' height='65' width='65'>";	
												}
												else if ($trabaja==1){
													echo "<img src='../images/ok2.png' alt='Trabaja' title='Si Trabaja' height='65' width='65'>";	
												}												
												echo "
											</td>
										</tr>										
										<tr>
											<td align='center'><stroke><b>Grupo<br><br>".$grupo."</td>
											<td align='center'><bb>Foráneo<br>";
											if ($foraneo==1){
												echo "<img src='../images/bus.png' alt='Foraneo' height='65' width='65' title='Foráneo'>";
											}
											else {
												echo "<img src='../images/home2.png' alt='Foraneo' height='65' width='65' title='Local'>";
											} 
											echo "	
											</td>
											<td align='center'><bb>Tutorías<br>";
											if ($tutorias==0){
												echo "<img src='../images/semaforos/blue.png' alt='Tutorías' height='65' width='65' title='Sin Asignar Aún'>";
											}
											else if ($tutorias==1){
												echo "<img src='../images/semaforos/green.png' alt='Tutorías' title='Bien' height='65' width='65'>";
											}
											else if ($tutorias==2){
												echo "<img src='../images/semaforos/yellow.png' alt='Tutorías' title='Leve' height='65' width='65'>";
											}
											else if ($tutorias==3){
												echo "<img src='../images/semaforos/naranja.png' alt='Tutorías' title='Moderado' height='65' width='65'>";
											}
											else {
												echo "<img src='../images/semaforos/red.png' alt='Tutorías' title='Grave' height='65' width='65'>";
											}
											echo "
											</td>
											<td align='center'><bb>C. Básicas<br>";
												if ($cb==0){
												echo "<img src='../images/semaforos/blue.png' alt='C.Basicas' height='65' width='65' title='Sin Asignar'>";
											}
											else if ($cb>=85){
												echo "<img src='../images/semaforos/green.png' alt='C.Basicas' height='65' width='65' title='Bien'>";
											}
											else if ($cb>=70){
												echo "<img src='../images/semaforos/yellow.png' alt='C.Basicas' height='65' width='65' title='Leve'>";
											}
											else if ($cb>=50){
												echo "<img src='../images/semaforos/naranja.png' alt='C.Basicas' height='65' width='65' title='Moderado'>";
											}
											else {
												echo "<img src='../images/semaforos/red.png' alt='C.Basicas' height='65' width='65' title='Grave'>";
											}
											echo "
											</td>
											<td align='center'><bb>J. de Carrera<br>";
											if ($jc==0){
												echo "<img src='../images/semaforos/blue.png' alt='J.Carrera' title='Sin Asignar Aún' height='65' width='65'>";
											}
											else if ($jc==1){
												echo "<img src='../images/semaforos/green.png' alt='J.Carrera' title='Bien' height='65' width='65'>";
											}
											else if ($jc==2){
												echo "<img src='../images/semaforos/yellow.png' alt='J.Carrera' title='Leve' height='65' width='65'>";
											}
											else if ($jc==3){
												echo "<img src='../images/semaforos/naranja.png' alt='J.Carrera' height='65' width='65' title='Moderado'>";
											}
											else {
												echo "<img src='../images/semaforos/red.png' alt='J.Carrera' height='65' width='65' title='Grave'>";
											}
											echo "
											</td>
										</tr>
									</table>
									<table align='right'>
										<tr>
											<td> <br>
												<input type='text' name='ficha' id='ficha' max='5' size='10' align='right' value='$ficha' hidden>
												<input type='submit' value='Buscar' name='guardar' id='guardar'>
											</td>
										</tr>
									</table>
								</form>
							</fieldset>";								
							}					
					 	}
						else {
							echo "
							<table width='700'>
								<tr>
									<td align='center'> <br>
										<img src='../images/no_results3.png' alt='consulta'>
									</td>
								</tr>
							</table>";								
						}
			        	echo "	
				    </div>
				</div>";
		    	}
		    	else{
		    	echo"	<div class='contenedor'>
		    		<div class='contenedor-1'>";
			        	$query = $alumnos[$carrera];
						$resultado = $mysqli->query($query);
						$rows=mysqli_fetch_array($resultado);
						echo "
							<table width='675'>
								<tr align='right'>
									<td><stroke><b>Total de Alumnos:".$rows[0]."</b></stroke></td>
								</tr>
							</table>";						
						$query = $arreglo[$carrera];
						$resultado = $mysqli->query($query);
						$mysqli->close();
						$array=mysqli_num_rows($resultado);												
					 	if (!empty($array)){
					 		while($rows=mysqli_fetch_array($resultado)){								
							$ficha=($rows['se_no_ficha']);
							$nombre=($rows['dp_nombre']);
							$apaterno=($rows['dp_ap_paterno']);
							$amaterno=($rows['dp_ap_materno']);
							$sexo=($rows['dp_sexo']);
							$edocivil=($rows['dp_edo_civil']);
							$hijos=($rows['dp_hijos']);
							$foraneo=($rows['smf_foraneo']);								
							$trabaja=($rows['smf_trabaja']);
							$tutorias=($rows['smf_tut']);
							$cb=($rows['smf_cb']);
							$jc=($rows['smf_jef_car']);
							$grupo=($rows['sa_grupo_gen']);								
							echo "
							<fieldset><legend><stroke><b>FICHA ".$ficha."</legend>
								<form name='Form".$ficha."' method='POST' action='consulta_individual_carrera.php'>
									<table width='670' border='0'>
										<tr>
											<td align='center' width='135'><bb>".$nombre."<br> ".$apaterno."<br>".$amaterno."										
											<br></td>
											<td align='center'><bb>Sexo<br> ";
												if ($sexo=='h' || $sexo=='H'){
													echo "<img src='../images/masculino.png' alt='Sexo' height='65' width='65' title='Hombre'>";	
												}
												else {
													echo "<img src='../images/femenino.png' alt='Sexo' height='65' width='65' title='Mujer'>";	
												}
											echo "</td>
											<td align='center'><bb>Estado Civil<br>";
											if ($edocivil==0){
												echo "<img src='../images/clock.png' alt='Edo civil' height='65' width='65' title='Sin Asignar Aún'>";
											}
											else if ($edocivil==1){
												echo "<img src='../images/soltero.png' alt='Edo civil' height='65' width='65' title='Soltero'>";
											}
											else if ($edocivil==2){
												echo "<img src='../images/casado2.png' alt='Edo civil' height='65' width='65' title='Casado'>";
											}
											else {
												echo "<img src='../images/otro.png' alt='Edo civil' height='65' width='65' title='Otro'>";
											}
											echo "	
											</td>
											<td align='center'><bb>Hijos<br>";
												if ($hijos==1){
													echo "<img src='../images/baby.png' alt='Hijos' title='Con Hijos' height='65' width='65'>";	
												}
												else {
													echo "<img src='../images/cross.png' alt='Hijos' height='65' width='65' title='Sin Hijos'>";	
												}
												echo "
											</td>
											<td align='center'><bb>Trabaja<br>";
												if ($trabaja==0){
													echo "<img src='../images/cross.png' alt='Trabaja' title='No Trabaja' height='65' width='65'>";	
												}
												else if ($trabaja==1){
													echo "<img src='../images/ok2.png' alt='Trabaja' title='Si Trabaja' height='65' width='65'>";	
												}
												
												echo "
											</td>
										</tr>										
										<tr>
											<td align='center'><stroke><b>Grupo<br><br>".$grupo."</td>
											<td align='center'><bb>Foráneo<br>";
											if ($foraneo==1){
												echo "<img src='../images/bus.png' alt='Foraneo' height='65' width='65' title='Foráneo'>";
											}
											else {
												echo "<img src='../images/home2.png' alt='Foraneo' height='65' width='65' title='Local'>";
											} 
											echo "	
											</td>
											<td align='center'><bb>Tutorías<br>";
											if ($tutorias==0){
												echo "<img src='../images/semaforos/blue.png' alt='Tutorías' height='65' width='65' title='Sin Asignar Aún'>";
											}
											else if ($tutorias==1){
												echo "<img src='../images/semaforos/green.png' alt='Tutorías' title='Bien' height='65' width='65'>";
											}
											else if ($tutorias==2){
												echo "<img src='../images/semaforos/yellow.png' alt='Tutorías' title='Leve' height='65' width='65'>";
											}
											else if ($tutorias==3){
												echo "<img src='../images/semaforos/naranja.png' alt='Tutorías' title='Moderado' height='65' width='65'>";
											}
											else {
												echo "<img src='../images/semaforos/red.png' alt='Tutorías' title='Grave' height='65' width='65'>";
											}
											echo "
											</td>
											<td align='center'><bb>C. Básicas<br>";
												if ($cb==0){
												echo "<img src='../images/semaforos/blue.png' alt='C.Basicas' height='65' width='65' title='Sin Asignar'>";
											}
											else if ($cb>85){
												echo "<img src='../images/semaforos/green.png' alt='C.Basicas' height='65' width='65' title='Bien'>";
											}
											else if ($cb>70){
												echo "<img src='../images/semaforos/yellow.png' alt='C.Basicas' height='65' width='65' title='Leve'>";
											}
											else if ($cb>50){
												echo "<img src='../images/semaforos/naranja.png' alt='C.Basicas' height='65' width='65' title='Moderado'>";
											}
											else {
												echo "<img src='../images/semaforos/red.png' alt='C.Basicas' height='65' width='65' title='Grave'>";
											}
											echo "
											</td>
											<td align='center'><bb>J. de Carrera<br>";
											if ($jc==0){
												echo "<img src='../images/semaforos/blue.png' alt='J.Carrera' title='Sin Asignar Aún' height='65' width='65'>";
											}
											else if ($jc==1){
												echo "<img src='../images/semaforos/green.png' alt='J.Carrera' title='Bien' height='65' width='65'>";
											}
											else if ($jc==2){
												echo "<img src='../images/semaforos/yellow.png' alt='J.Carrera' title='Leve' height='65' width='65'>";
											}
											else if ($jc==3){
												echo "<img src='../images/semaforos/naranja.png' alt='J.Carrera' height='65' width='65' title='Moderado'>";
											}
											else {
												echo "<img src='../images/semaforos/red.png' alt='J.Carrera' height='65' width='65' title='Grave'>";
											}
											echo "
											</td>
										</tr>
									</table>
									<table align='right'>
										<tr>
											<td> <br>
												<input type='text' name='ficha' id='ficha' max='5' size='10' align='right' value='$ficha' hidden>
												<input type='submit' value='Buscar' name='guardar' id='guardar'>
											</td>
										</tr>
									</table>
								</form>
							</fieldset>";								
							}										 	
					 	}
						else {
							echo "
							<table width='700'>
								<tr>
									<td align='center'> <br>
										<img src='../images/no_results3.png' alt='consulta'>
									</td>
								</tr>
							</table>";								
						}
			        	echo "	
				    </div>
				</div>";
		    	}
			echo"</section>
		</div>";	
	}	
	function docente_carrera(){
	echo "
	<div class='container'>
		<section class='tabs'>
            <input id='tab-1' type='radio' name='radio-set' class='tab-selector-1' checked='checked' style='visibility:hidden'/>
	        <label for='tab-1' class='tab-label-1'><stroke-2>BIO</label>

	       	<input id='tab-2' type='radio' name='radio-set' class='tab-selector-2' style='visibility:hidden'/>
	        <label for='tab-2' class='tab-label-2'><stroke-2>GEST</label>
	
            <input id='tab-3' type='radio' name='radio-set' class='tab-selector-3' style='visibility:hidden'/>
	        <label for='tab-3' class='tab-label-3'><stroke-2>IND</label>

	        <input id='tab-4' type='radio' name='radio-set' class='tab-selector-4' style='visibility:hidden'/>
	        <label for='tab-4' class='tab-label-4'><stroke-2>MECA</label>

	        <input id='tab-5' type='radio' name='radio-set' class='tab-selector-5' style='visibility:hidden'/>
	        <label for='tab-5' class='tab-label-5'><stroke-2>NANO</label>

	        <input id='tab-6' type='radio' name='radio-set' class='tab-selector-6' style='visibility:hidden'/>
	        <label for='tab-6' class='tab-label-6'><stroke-2>SIST</label>

	        <input id='tab-7' type='radio' name='radio-set' class='tab-selector-7' style='visibility:hidden'/>
	        <label for='tab-7' class='tab-label-7'><stroke-2>TICS</label>
			                        
		    <div class='clear-shadow'></div>
		    <div class='contenedor'>";
		    	$directorio[1]='bio/';    	$directorio[2]='gest/';
		    	$directorio[3]='ind/';    	$directorio[4]='meca/';
		    	$directorio[5]='nano/';    	$directorio[6]='sist/';
		    	$directorio[7]='tics/';		
		    	$arreglo[1]='Ingeniería Bioquímica';
		    	$arreglo[2]='Gestión Empresarial';
		    	$arreglo[3]='Ingeniería Industrial';
		    	$arreglo[4]='Ingeniería Mecatrónica';
		    	$arreglo[5]='Ingeniería en Nanotecnología';
		    	$arreglo[6]='Ingeniería en Sistemas Computacionales';
		    	$arreglo[7]='Ingeniería Tecnologías de la Información y Comunicaciones';
		    	for($i=1;$i<=7;$i++){
		    		echo"
		    		<div class='contenedor-$i'>
		        		<form name='carr".$i."' method='POST' action='$directorio[$i]'>
		        			<table width='675'>
		        				<tr>
		        					<td width='550'>";
		        						echo "<ba>".$arreglo[$i]."</ba>
		        					</td>
		        					<td>
		        						<input type='submit' value='Ir a' name='ir_a_carrera'>
		        					</td>
		        				</tr>
		        			</table>
		        		</form>
				    </div>";
				}
				echo"
			</div>
		</section>
	</div>";
	}
	function test_vocacional($ficha){
		echo"<style type='text/css'>
	   		input { text-align: center; }
    	</style>";		
		require_once '../conexion/conex_mysql.php';
		$mysqli = new mysqli ($hostname,$username,$password,$database);
		if ($mysqli->connect_errno){
			die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
		}
		$query = "SELECT * from alumnos_test_vocacional WHERE no_ficha='$ficha'";
		$resultado = $mysqli->query($query);
		$rows = mysqli_fetch_array($resultado);
		if (!empty($rows)){
			$carrera=$rows['carrera'];
			$ss=$rows['tv_apt_ss'];$ep=$rows['tv_apt_ep'];
			$v=$rows['tv_apt_v'];	$ap=$rows['tv_apt_ap'];
			$ms=$rows['tv_apt_ms'];$og=$rows['tv_apt_og'];
			$ct=$rows['tv_apt_ct'];$cl=$rows['tv_apt_cl'];
			$mc=$rows['tv_apt_mc'];$al=$rows['tv_apt_al'];
			$apt1=$rows['tv_apt_mayor'];
			$apt2=$rows['tv_apt_mayor_seg'];
			$apt3=$rows['tv_apt_menor_seg'];
			$apt4=$rows['tv_apt_menor'];
			$res=$rows['tv_test_res'];
			echo"
		<section class='tabs'>
			<fieldset><legend><stroke>Habilidades</stroke></legend>
				<table width='100%'>
					<tr>
						<td width='25%'></td>
						<td width='15%'><ba>Carrera:</ba></td>
						<td width='60%'><pp>$carrera</pp></td>
					</tr>
				</table>
				<br>
				<table width='675' align='center'>					
					<tr align='center'>
						<td><ba>SS</ba></td>
						<td><ba>EP</ba></td>
						<td><ba>V</ba></td>
						<td><ba>AP</ba></td>
						<td><ba>MS</ba></td>
					</tr>
					<tr align='center'>
						<td><input type='text' name='SS' readonly size='3' value='$ss'></td>
						<td><input type='text' name='EP' readonly size='3' value='$ep'></td>
						<td><input type='text' name='V' readonly size='3' value='$v'></td>
						<td><input type='text' name='AP' readonly size='3' value='$ap'></td>
						<td><input type='text' name='MS' readonly size='3' value='$ms'></td>			
					</tr>
					<tr align='center'>
						<td><ba>OG</ba></td>
						<td><ba>CT</ba></td>
						<td><ba>CL</ba></td>
						<td><ba>MC</ba></td>
						<td><ba>AL</ba></td>
					</tr>
					<tr align='center'>
						<td><input type='text' name='OG' readonly size='3' value='$og'></td>
						<td><input type='text' name='CT' readonly size='3' value='$ct'></td>
						<td><input type='text' name='CL' readonly size='3' value='$cl'></td>
						<td><input type='text' name='MC' readonly size='3' value='$mc'></td>
						<td><input type='text' name='AL' readonly size='3' value='$al'></td>			
					</tr>
				</table>
				<br>	
			</fieldset>

			<fieldset>
				<legend><stroke>Resultado</stroke></legend>
				<table width='100%'>
					<tr>
						<td width='20%' align='center'><ba>1er Aptitud</ba></td>
						<td width='20%' align='center'></td>
						<td width='20%' align='center'><ba>2da Aptitud</ba></td>
						<td width='20%' align='center'></td>
						<td width='20%' align='center'><ba>Resultado</ba></td>
					</tr>
					<tr>
						<td width='20%' align='center'><pp>$apt1</pp></td>
						<td width='20%' align='center'></td>
						<td width='20%' align='center'><pp>$apt2</pp></td>
						<td width='20%' align='center'></td>
						<td width='20%' align='center'><pp>$res</pp></td>
					</tr>
					<tr>
						<td width='20%' align='center'><ba>10ma Aptitud</ba></td>
						<td width='20%' align='center'></td>
						<td width='20%' align='center'><ba>9na Aptitud</ba></td>
						<td width='20%' align='center'></td>
						<td width='20%' align='center'></td>
					</tr>
					<tr>
						<td width='20%' align='center'><pp>$apt4</pp></td>
						<td width='20%' align='center'></td>
						<td width='20%' align='center'><pp>$apt3</pp></td>
						<td width='20%' align='center'></td>
						<td width='20%' align='center'></td>
					</tr>
				</table>
			</fieldset>
		</section>";	
		}
	}
	function carrera_docentes($carrera){

		require_once '../consultas/sentencias_consulta_carreras.php';
		$arreglo[1]=$bioquimica;		$arreglo[2]=$gestion;
		$arreglo[3]=$industrial;		$arreglo[4]=$meca;
		$arreglo[5]=$nano;				$arreglo[6]=$sistemas;
		$arreglo[7]=$tics;
		$nombre[1]="Bioq";		$nombre[2]="Gest";
		$nombre[3]="Ind";		$nombre[4]="Meca";
		$nombre[5]="Nano";		$nombre[6]="Sist";
		$nombre[7]="Tics";
		require_once '../consultas/sentencias_total_alumnos.php';
		$alumnos[1]=$bio;
		$alumnos[2]=$ges;
		$alumnos[3]=$ind;
		$alumnos[4]=$mec;
		$alumnos[5]=$nan;
		$alumnos[6]=$sis;
		$alumnos[7]=$tic;
		echo"
		<div class='container'>
			<section class='tabs'>
            	<input id='tab-1' type='radio' name='radio-set' class='tab-selector-1' checked='checked' style='visibility:hidden'/>
            	<label for='tab-1' class='tab-label-1'><stroke-2>".$nombre[$carrera]."</label>
				<form action='carrera_filtrar.php' method='POST'>
					<table width='675'>
						<tr>
							<td width='600'></td>
							<td>
								<input type='hidden' name='carrera' value='$carrera'>
								<input type='submit' name='filtrar' value='Filtrar'>
							</td>
						</tr>
					</table>
				</form>            	
		    	<div class='clear-shadow'></div>
		    	<div class='contenedor'>
		    		<div class='contenedor-1'>";
			        	require_once '../conexion/conex_mysql.php';
						$mysqli = new mysqli ($hostname,$username,$password,$database);
						if ($mysqli->connect_errno){
							die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
						}
						$query = $alumnos[$carrera];
						$resultado = $mysqli->query($query);
						$rows=mysqli_fetch_array($resultado);
						echo "
							<table width='675'>
								<tr align='right'>
									<td><stroke><b>Total de Alumnos:".$rows[0]."</b></stroke></td>
								</tr>
							</table>";					
						$query = $arreglo[$carrera];
						$resultado = $mysqli->query($query);
						$array=mysqli_num_rows($resultado);												
					 	if (!empty($array)){
					 		while($rows=mysqli_fetch_array($resultado)){								
							$ficha=($rows['se_no_ficha']);
							$nombre=($rows['dp_nombre']);
							$apaterno=($rows['dp_ap_paterno']);
							$amaterno=($rows['dp_ap_materno']);
							$sexo=($rows['dp_sexo']);
							$edocivil=($rows['dp_edo_civil']);
							$hijos=($rows['dp_hijos']);
							$foraneo=($rows['smf_foraneo']);								
							$trabaja=($rows['smf_trabaja']);
							$tutorias=($rows['smf_tut']);
							$cb=($rows['smf_cb']);
							$jc=($rows['smf_jef_car']);
							$grupo=($rows['sa_grupo_gen']);								
							echo "
							<fieldset><legend><stroke><b>FICHA ".$ficha."</legend>
								
									<table width='670' border='0'>
										<tr>
											<td align='center' width='135'><bb>".$nombre."<br> ".$apaterno."<br>".$amaterno."										
											<br></td>
											<td align='center'><bb>Sexo<br> ";
												if ($sexo=='h' || $sexo=='H'){
													echo "<img src='../images/masculino.png' alt='Sexo' height='65' width='65' title='Hombre'>";	
												}
												else {
													echo "<img src='../images/femenino.png' alt='Sexo' height='65' width='65' title='Mujer'>";	
												}
											echo "</td>
											<td align='center'><bb>Estado Civil<br>";
											if ($edocivil==0){
												echo "<img src='../images/clock.png' alt='Edo civil' height='65' width='65' title='Sin Asignar Aún'>";
											}
											else if ($edocivil==1){
												echo "<img src='../images/soltero.png' alt='Edo civil' height='65' width='65' title='Soltero'>";
											}
											else if ($edocivil==2){
												echo "<img src='../images/casado2.png' alt='Edo civil' height='65' width='65' title='Casado'>";
											}
											else {
												echo "<img src='../images/otro.png' alt='Edo civil' height='65' width='65' title='Otro'>";
											}
											echo "	
											</td>
											<td align='center'><bb>Hijos<br>";
												if ($hijos==1){
													echo "<img src='../images/baby.png' alt='Hijos' title='Con Hijos' height='65' width='65'>";	
												}
												else {
													echo "<img src='../images/cross.png' alt='Hijos' height='65' width='65' title='Sin Hijos'>";	
												}
												echo "
											</td>
											<td align='center'><bb>Trabaja<br>";
												if ($trabaja==0){
													echo "<img src='../images/cross.png' alt='Trabaja' title='No Trabaja' height='65' width='65'>";	
												}
												else if ($trabaja==1){
													echo "<img src='../images/ok2.png' alt='Trabaja' title='Si Trabaja' height='65' width='65'>";	
												}
												
												echo "
											</td>
										</tr>										
										<tr>
											<td align='center'><stroke><b>Grupo<br><br>".$grupo."</td>
											<td align='center'><bb>Foráneo<br>";
											if ($foraneo==1){
												echo "<img src='../images/bus.png' alt='Foraneo' height='65' width='65' title='Foráneo'>";
											}
											else {
												echo "<img src='../images/home2.png' alt='Foraneo' height='65' width='65' title='Local'>";
											} 
											echo "	
											</td>
											<td align='center'><bb>Tutorías<br>";
											if ($tutorias==0){
												echo "<img src='../images/semaforos/blue.png' alt='Tutorías' height='65' width='65' title='Sin Asignar Aún'>";
											}
											else if ($tutorias==1){
												echo "<img src='../images/semaforos/green.png' alt='Tutorías' title='Bien' height='65' width='65'>";
											}
											else if ($tutorias==2){
												echo "<img src='../images/semaforos/yellow.png' alt='Tutorías' title='Leve' height='65' width='65'>";
											}
											else if ($tutorias==3){
												echo "<img src='../images/semaforos/naranja.png' alt='Tutorías' title='Moderado' height='65' width='65'>";
											}
											else {
												echo "<img src='../images/semaforos/red.png' alt='Tutorías' title='Grave' height='65' width='65'>";
											}
											echo "
											</td>
											<td align='center'><bb>C. Básicas<br>";
												if ($cb==0){
												echo "<img src='../images/semaforos/blue.png' alt='C.Basicas' height='65' width='65' title='Sin Asignar'>";
											}
											else if ($cb>85){
												echo "<img src='../images/semaforos/green.png' alt='C.Basicas' height='65' width='65' title='Bien'>";
											}
											else if ($cb>70){
												echo "<img src='../images/semaforos/yellow.png' alt='C.Basicas' height='65' width='65' title='Leve'>";
											}
											else if ($cb>50){
												echo "<img src='../images/semaforos/naranja.png' alt='C.Basicas' height='65' width='65' title='Moderado'>";
											}
											else {
												echo "<img src='../images/semaforos/red.png' alt='C.Basicas' height='65' width='65' title='Grave'>";
											}
											echo "
											</td>
											<td align='center'><bb>J. de Carrera<br>";
											if ($jc==0){
												echo "<img src='../images/semaforos/blue.png' alt='J.Carrera' title='Sin Asignar Aún' height='65' width='65'>";
											}
											else if ($jc==1){
												echo "<img src='../images/semaforos/green.png' alt='J.Carrera' title='Bien' height='65' width='65'>";
											}
											else if ($jc==2){
												echo "<img src='../images/semaforos/yellow.png' alt='J.Carrera' title='Leve' height='65' width='65'>";
											}
											else if ($jc==3){
												echo "<img src='../images/semaforos/naranja.png' alt='J.Carrera' height='65' width='65' title='Moderado'>";
											}
											else {
												echo "<img src='../images/semaforos/red.png' alt='J.Carrera' height='65' width='65' title='Grave'>";
											}
											echo "
											</td>
										</tr>
									</table>						
							</fieldset>";								
							}
					 	}
						else {
							echo "
							<table width='700'>
								<tr>
									<td align='center'> <br>
										<img src='../images/no_results3.png' alt='consulta'>
									</td>
								</tr>
							</table>";
						}
			        	echo "	
				    </div>
				</div>
			</section>
		</div>";	
	}
	function carrera_filtrar2($carrera){
		//funcion de filtrado para jefes de carrera
		require_once '../consultas/sentencias_consulta_filtro.php';
		$arreglo[1]=$bioquimica;		$arreglo[2]=$gestion;
		$arreglo[3]=$industrial;		$arreglo[4]=$meca;
		$arreglo[5]=$nano;				$arreglo[6]=$sistemas;
		$arreglo[7]=$tics;
		$nombre[1]="Bioq";		$nombre[2]="Gest";
		$nombre[3]="Ind";		$nombre[4]="Meca";
		$nombre[5]="Nano";		$nombre[6]="Sist";
		$nombre[7]="Tics";
		require_once '../consultas/sentencias_total_alumnos.php';
		$alumnos[1]=$bio;		$alumnos[2]=$ges;
		$alumnos[3]=$ind;		$alumnos[4]=$mec;
		$alumnos[5]=$nan;		$alumnos[6]=$sis;
		$alumnos[7]=$tic;
		echo"
		<div class='container'>
			<section class='tabs'>
            	<input id='tab-1' type='radio' name='radio-set' class='tab-selector-1' checked='checked' style='visibility:hidden'/>
            	<label for='tab-1' class='tab-label-1'><stroke-2>".$nombre[$carrera]."</label>
		    	<div class='clear-shadow'></div>
		    	<form action='' name='' method='POST'>
			    	<table width='750'>
			    		<tr>
			    			<td width='200'></td>
			    			<td width='250'>
								<pp>Semáforo:</pp>
		            			<select name='semaforo'>
		            				<option value='1'>Tutorías</option>
			            			<option value='2'>C.Básicas</option>
			            			<option value='3'>J.Carrera</option>
		            			</select>
			    			</td>
			    			<td width='240'>
			    				<pp>Criterio:</pp>
		            			<select name='criterio' id='criterio'>
		            		 		<option value='1'>Bien</option>
			            		 	<option value='2'>Leve</option>
			            		 	<option value='3'>Moderado</option>
			            		 	<option value='4'>Grave</option>
			            		 </select> 
			    			</td>
			    			<td width='100'>
			    				<input type='submit' name='ordenar' value='Filtrar'>
			    			</td>
			    		</tr>
			    	</table>					 	
            	</form>";
		    	if (isset($_POST['ordenar']))
		    	{
		    		$semaforo=$_POST['semaforo'];
		    		$criterio=$_POST['criterio'];		    		
		    		echo"<div class='contenedor'>
		    		<div class='contenedor-1'>";
			        	require_once '../conexion/conex_mysql.php';
						$mysqli = new mysqli ($hostname,$username,$password,$database);
						if ($mysqli->connect_errno){
							die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
						}
						$query = $alumnos[$carrera];
						$query2 = $arreglo[$carrera];
						if($semaforo==1){
							if($criterio==1){
								$query.='AND T2.smf_tut=1';
								$query2.='AND T2.smf_tut=1 ORDER BY sa_grupo_gen ASC, dp_ap_paterno ASC';
								$smf='Tutorías';
								$crit='Bien';
							}
							elseif($criterio==2){
								$query.='AND T2.smf_tut=2';
								$query2.='AND T2.smf_tut=2 ORDER BY sa_grupo_gen ASC, dp_ap_paterno ASC';
								$smf='Tutorías';
								$crit='Leve';
							}
							elseif($criterio==3){
								$query.='AND T2.smf_tut=3';
								$query2.='AND T2.smf_tut=3 ORDER BY sa_grupo_gen ASC, dp_ap_paterno ASC';
								$smf='Tutorías';
								$crit='Moderado';
							}
							else{
								$query.='AND T2.smf_tut=4';
								$query2.='AND T2.smf_tut=4 ORDER BY sa_grupo_gen ASC, dp_ap_paterno ASC';
								$smf='Tutorías';
								$crit='Grave';
							}
						}
						elseif($semaforo==2){
							if($criterio==1){
								$query.='AND T2.smf_cb>84';
								$query2.='AND T2.smf_cb>84 ORDER BY sa_grupo_gen ASC, dp_ap_paterno ASC';	
								$smf='C.Básicas';
								$crit='Bien';
							}
							elseif($criterio==2){
								$query.='AND T2.smf_cb>69 AND T2.smf_cb<85';
								$query2.='AND T2.smf_cb>69 AND T2.smf_cb<85 ORDER BY sa_grupo_gen ASC, dp_ap_paterno ASC';
								$smf='C.Básicas';
								$crit='Leve';	
							}
							elseif($criterio==3){
								$query.='AND T2.smf_cb>49 AND T2.smf_cb<70';
								$query2.='AND T2.smf_cb>49 AND T2.smf_cb<70 ORDER BY sa_grupo_gen ASC, dp_ap_paterno ASC';
								$smf='C.Básicas';
								$crit='Moderado';	
							}
							else{
								$query.='AND T2.smf_cb<50 AND T2.smf_cb>0';
								$query2.='AND T2.smf_cb<50 AND T2.smf_cb>0 ORDER BY sa_grupo_gen ASC, dp_ap_paterno ASC';	
								$smf='C.Básicas';
								$crit='Grave';
							}	
						}
						else{
							if($criterio==1){
								$query.='AND T2.smf_jef_car=1';
								$query2.='AND T2.smf_jef_car=1 ORDER BY sa_grupo_gen ASC, dp_ap_paterno ASC';
								$smf='J.Carrera';
								$crit='Bien';
							}
							elseif($criterio==2){
								$query.='AND T2.smf_jef_car=2';
								$query2.='AND T2.smf_jef_car=2 ORDER BY sa_grupo_gen ASC, dp_ap_paterno ASC';
								$smf='J.Carrera';
								$crit='Leve';
							}
							elseif($criterio==3){
								$query.='AND T2.smf_jef_car=3';
								$query2.='AND T2.smf_jef_car=3 ORDER BY sa_grupo_gen ASC, dp_ap_paterno ASC';
								$smf='J.Carrera';
								$crit='Moderado';
							}
							else{
								$query.='AND T2.smf_jef_car=4';
								$query2.='AND T2.smf_jef_car=4 ORDER BY sa_grupo_gen ASC, dp_ap_paterno ASC';
								$smf='J.Carrera';
								$crit='Grave';
							}
						}
						$resultado = $mysqli->query($query);
						$rows=mysqli_fetch_array($resultado);
						echo "
							<table width='675'>
								<tr align='right'>
									<td width='200'><stroke><b>".$smf."-".$crit."</b><stroke></td>
									<td width='200'><stroke><b>Total de Alumnos:".$rows[0]."</b></stroke></td>
								</tr>
							</table>";						
						$resultado = $mysqli->query($query2);
						$array=mysqli_num_rows($resultado);												
					 	if (!empty($array)){
					 		while($rows=mysqli_fetch_array($resultado)){								
							$ficha=($rows['se_no_ficha']);
							$nombre=($rows['dp_nombre']);
							$apaterno=($rows['dp_ap_paterno']);
							$amaterno=($rows['dp_ap_materno']);
							$sexo=($rows['dp_sexo']);
							$edocivil=($rows['dp_edo_civil']);
							$hijos=($rows['dp_hijos']);
							$foraneo=($rows['smf_foraneo']);								
							$trabaja=($rows['smf_trabaja']);
							$tutorias=($rows['smf_tut']);
							$cb=($rows['smf_cb']);
							$jc=($rows['smf_jef_car']);
							$grupo=($rows['sa_grupo_gen']);								
							echo "
							<fieldset><legend><stroke><b>FICHA ".$ficha."</legend>					
									<table width='670' border='0'>
										<tr>
											<td align='center' width='135'><bb>".$nombre."<br> ".$apaterno."<br>".$amaterno."										
											<br></td>
											<td align='center'><bb>Sexo<br> ";
												if ($sexo=='h' || $sexo=='H'){
													echo "<img src='../images/masculino.png' alt='Sexo' height='65' width='65' title='Hombre'>";	
												}
												else {
													echo "<img src='../images/femenino.png' alt='Sexo' height='65' width='65' title='Mujer'>";	
												}
											echo "</td>
											<td align='center'><bb>Estado Civil<br>";
											if ($edocivil==0){
												echo "<img src='../images/clock.png' alt='Edo civil' height='65' width='65' title='Sin Asignar Aún'>";
											}
											else if ($edocivil==1){
												echo "<img src='../images/soltero.png' alt='Edo civil' height='65' width='65' title='Soltero'>";
											}
											else if ($edocivil==2){
												echo "<img src='../images/casado2.png' alt='Edo civil' height='65' width='65' title='Casado'>";
											}
											else {
												echo "<img src='../images/otro.png' alt='Edo civil' height='65' width='65' title='Otro'>";
											}
											echo "	
											</td>
											<td align='center'><bb>Hijos<br>";
												if ($hijos==1){
													echo "<img src='../images/baby.png' alt='Hijos' title='Con Hijos' height='65' width='65'>";	
												}
												else {
													echo "<img src='../images/cross.png' alt='Hijos' height='65' width='65' title='Sin Hijos'>";	
												}
												echo "
											</td>
											<td align='center'><bb>Trabaja<br>";
												if ($trabaja==0){
													echo "<img src='../images/cross.png' alt='Trabaja' title='No Trabaja' height='65' width='65'>";	
												}
												else if ($trabaja==1){
													echo "<img src='../images/ok2.png' alt='Trabaja' title='Si Trabaja' height='65' width='65'>";	
												}												
												echo "
											</td>
										</tr>										
										<tr>
											<td align='center'><stroke><b>Grupo<br><br>".$grupo."</td>
											<td align='center'><bb>Foráneo<br>";
											if ($foraneo==1){
												echo "<img src='../images/bus.png' alt='Foraneo' height='65' width='65' title='Foráneo'>";
											}
											else {
												echo "<img src='../images/home2.png' alt='Foraneo' height='65' width='65' title='Local'>";
											} 
											echo "	
											</td>
											<td align='center'><bb>Tutorías<br>";
											if ($tutorias==0){
												echo "<img src='../images/semaforos/blue.png' alt='Tutorías' height='65' width='65' title='Sin Asignar Aún'>";
											}
											else if ($tutorias==1){
												echo "<img src='../images/semaforos/green.png' alt='Tutorías' title='Bien' height='65' width='65'>";
											}
											else if ($tutorias==2){
												echo "<img src='../images/semaforos/yellow.png' alt='Tutorías' title='Leve' height='65' width='65'>";
											}
											else if ($tutorias==3){
												echo "<img src='../images/semaforos/naranja.png' alt='Tutorías' title='Moderado' height='65' width='65'>";
											}
											else {
												echo "<img src='../images/semaforos/red.png' alt='Tutorías' title='Grave' height='65' width='65'>";
											}
											echo "
											</td>
											<td align='center'><bb>C. Básicas<br>";
												if ($cb==0){
												echo "<img src='../images/semaforos/blue.png' alt='C.Basicas' height='65' width='65' title='Sin Asignar'>";
											}
											else if ($cb>=85){
												echo "<img src='../images/semaforos/green.png' alt='C.Basicas' height='65' width='65' title='Bien'>";
											}
											else if ($cb>=70){
												echo "<img src='../images/semaforos/yellow.png' alt='C.Basicas' height='65' width='65' title='Leve'>";
											}
											else if ($cb>=50){
												echo "<img src='../images/semaforos/naranja.png' alt='C.Basicas' height='65' width='65' title='Moderado'>";
											}
											else {
												echo "<img src='../images/semaforos/red.png' alt='C.Basicas' height='65' width='65' title='Grave'>";
											}
											echo "
											</td>
											<td align='center'><bb>J. de Carrera<br>";
											if ($jc==0){
												echo "<img src='../images/semaforos/blue.png' alt='J.Carrera' title='Sin Asignar Aún' height='65' width='65'>";
											}
											else if ($jc==1){
												echo "<img src='../images/semaforos/green.png' alt='J.Carrera' title='Bien' height='65' width='65'>";
											}
											else if ($jc==2){
												echo "<img src='../images/semaforos/yellow.png' alt='J.Carrera' title='Leve' height='65' width='65'>";
											}
											else if ($jc==3){
												echo "<img src='../images/semaforos/naranja.png' alt='J.Carrera' height='65' width='65' title='Moderado'>";
											}
											else {
												echo "<img src='../images/semaforos/red.png' alt='J.Carrera' height='65' width='65' title='Grave'>";
											}
											echo "
											</td>
										</tr>
									</table>															
							</fieldset>";								
							}										 	
					 	}
						else {
							echo "
							<table width='700'>
								<tr>
									<td align='center'> <br>
										<img src='../images/no_results3.png' alt='consulta'>
									</td>
								</tr>
							</table>";
						}
			        	echo "	
				    </div>
				</div>";
		    	}
		    	else{
		    	echo"	<div class='contenedor'>
		    		<div class='contenedor-1'>";
			        	require_once '../conexion/conex_mysql.php';
						$mysqli = new mysqli ($hostname,$username,$password,$database);
						if ($mysqli->connect_errno){
							die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
						}

						$query = $alumnos[$carrera];
						$resultado = $mysqli->query($query);
						$rows=mysqli_fetch_array($resultado);
						echo "
							<table width='675'>
								<tr align='right'>
									<td><stroke><b>Total de Alumnos:".$rows[0]."</b></stroke></td>
								</tr>
							</table>";						
						$query = $arreglo[$carrera];
						$resultado = $mysqli->query($query);
						$array=mysqli_num_rows($resultado);											
					 	if (!empty($array)){
					 		while($rows=mysqli_fetch_array($resultado)){								
							$ficha=($rows['se_no_ficha']);
							$nombre=($rows['dp_nombre']);
							$apaterno=($rows['dp_ap_paterno']);
							$amaterno=($rows['dp_ap_materno']);
							$sexo=($rows['dp_sexo']);
							$edocivil=($rows['dp_edo_civil']);
							$hijos=($rows['dp_hijos']);
							$foraneo=($rows['smf_foraneo']);								
							$trabaja=($rows['smf_trabaja']);
							$tutorias=($rows['smf_tut']);
							$cb=($rows['smf_cb']);
							$jc=($rows['smf_jef_car']);
							$grupo=($rows['sa_grupo_gen']);								
							echo "
							<fieldset><legend><stroke><b>FICHA ".$ficha."</legend>						
									<table width='670' border='0'>
										<tr>
											<td align='center' width='135'><bb>".$nombre."<br> ".$apaterno."<br>".$amaterno."										
											<br></td>
											<td align='center'><bb>Sexo<br> ";
												if ($sexo=='h' || $sexo=='H'){
													echo "<img src='../images/masculino.png' alt='Sexo' height='65' width='65' title='Hombre'>";	
												}
												else {
													echo "<img src='../images/femenino.png' alt='Sexo' height='65' width='65' title='Mujer'>";	
												}
											echo "</td>
											<td align='center'><bb>Estado Civil<br>";
											if ($edocivil==0){
												echo "<img src='../images/clock.png' alt='Edo civil' height='65' width='65' title='Sin Asignar Aún'>";
											}
											else if ($edocivil==1){
												echo "<img src='../images/soltero.png' alt='Edo civil' height='65' width='65' title='Soltero'>";
											}
											else if ($edocivil==2){
												echo "<img src='../images/casado2.png' alt='Edo civil' height='65' width='65' title='Casado'>";
											}
											else {
												echo "<img src='../images/otro.png' alt='Edo civil' height='65' width='65' title='Otro'>";
											}
											echo "	
											</td>
											<td align='center'><bb>Hijos<br>";
												if ($hijos==1){
													echo "<img src='../images/baby.png' alt='Hijos' title='Con Hijos' height='65' width='65'>";	
												}
												else {
													echo "<img src='../images/cross.png' alt='Hijos' height='65' width='65' title='Sin Hijos'>";	
												}
												echo "
											</td>
											<td align='center'><bb>Trabaja<br>";
												if ($trabaja==0){
													echo "<img src='../images/cross.png' alt='Trabaja' title='No Trabaja' height='65' width='65'>";	
												}
												else if ($trabaja==1){
													echo "<img src='../images/ok2.png' alt='Trabaja' title='Si Trabaja' height='65' width='65'>";	
												}												
												echo "
											</td>
										</tr>										
										<tr>
											<td align='center'><stroke><b>Grupo<br><br>".$grupo."</td>
											<td align='center'><bb>Foráneo<br>";
											if ($foraneo==1){
												echo "<img src='../images/bus.png' alt='Foraneo' height='65' width='65' title='Foráneo'>";
											}
											else {
												echo "<img src='../images/home2.png' alt='Foraneo' height='65' width='65' title='Local'>";
											} 
											echo "	
											</td>
											<td align='center'><bb>Tutorías<br>";
											if ($tutorias==0){
												echo "<img src='../images/semaforos/blue.png' alt='Tutorías' height='65' width='65' title='Sin Asignar Aún'>";
											}
											else if ($tutorias==1){
												echo "<img src='../images/semaforos/green.png' alt='Tutorías' title='Bien' height='65' width='65'>";
											}
											else if ($tutorias==2){
												echo "<img src='../images/semaforos/yellow.png' alt='Tutorías' title='Leve' height='65' width='65'>";
											}
											else if ($tutorias==3){
												echo "<img src='../images/semaforos/naranja.png' alt='Tutorías' title='Moderado' height='65' width='65'>";
											}
											else {
												echo "<img src='../images/semaforos/red.png' alt='Tutorías' title='Grave' height='65' width='65'>";
											}
											echo "
											</td>
											<td align='center'><bb>C. Básicas<br>";
												if ($cb==0){
												echo "<img src='../images/semaforos/blue.png' alt='C.Basicas' height='65' width='65' title='Sin Asignar'>";
											}
											else if ($cb>85){
												echo "<img src='../images/semaforos/green.png' alt='C.Basicas' height='65' width='65' title='Bien'>";
											}
											else if ($cb>70){
												echo "<img src='../images/semaforos/yellow.png' alt='C.Basicas' height='65' width='65' title='Leve'>";
											}
											else if ($cb>50){
												echo "<img src='../images/semaforos/naranja.png' alt='C.Basicas' height='65' width='65' title='Moderado'>";
											}
											else {
												echo "<img src='../images/semaforos/red.png' alt='C.Basicas' height='65' width='65' title='Grave'>";
											}
											echo "
											</td>
											<td align='center'><bb>J. de Carrera<br>";
											if ($jc==0){
												echo "<img src='../images/semaforos/blue.png' alt='J.Carrera' title='Sin Asignar Aún' height='65' width='65'>";
											}
											else if ($jc==1){
												echo "<img src='../images/semaforos/green.png' alt='J.Carrera' title='Bien' height='65' width='65'>";
											}
											else if ($jc==2){
												echo "<img src='../images/semaforos/yellow.png' alt='J.Carrera' title='Leve' height='65' width='65'>";
											}
											else if ($jc==3){
												echo "<img src='../images/semaforos/naranja.png' alt='J.Carrera' height='65' width='65' title='Moderado'>";
											}
											else {
												echo "<img src='../images/semaforos/red.png' alt='J.Carrera' height='65' width='65' title='Grave'>";
											}
											echo "
											</td>
										</tr>
									</table>									
							</fieldset>";								
							}						
					 	}
						else {
							echo "
							<table width='700'>
								<tr>
									<td align='center'> <br>
										<img src='../images/no_results3.png' alt='consulta'>
									</td>
								</tr>
							</table>";
						}
			        	echo "	
				    </div>
				</div>";
		    	}
			echo"</section>
		</div>";
	}
	function consulta_carr2(){
	echo "
	<div class='container'>
		<section class='tabs'>
            <input id='tab-1' type='radio' name='radio-set' class='tab-selector-1' checked='checked' style='visibility:hidden'/>
	        <label for='tab-1' class='tab-label-1'><stroke-2>BIO</label>

	       	<input id='tab-2' type='radio' name='radio-set' class='tab-selector-2' style='visibility:hidden'/>
	        <label for='tab-2' class='tab-label-2'><stroke-2>GEST</label>
	
            <input id='tab-3' type='radio' name='radio-set' class='tab-selector-3' style='visibility:hidden'/>
	        <label for='tab-3' class='tab-label-3'><stroke-2>IND</label>

	        <input id='tab-4' type='radio' name='radio-set' class='tab-selector-4' style='visibility:hidden'/>
	        <label for='tab-4' class='tab-label-4'><stroke-2>MECA</label>

	        <input id='tab-5' type='radio' name='radio-set' class='tab-selector-5' style='visibility:hidden'/>
	        <label for='tab-5' class='tab-label-5'><stroke-2>NANO</label>

	        <input id='tab-6' type='radio' name='radio-set' class='tab-selector-6' style='visibility:hidden'/>
	        <label for='tab-6' class='tab-label-6'><stroke-2>SIST</label>

	        <input id='tab-7' type='radio' name='radio-set' class='tab-selector-7' style='visibility:hidden'/>
	        <label for='tab-7' class='tab-label-7'><stroke-2>TICS</label>
			                        
		    <div class='clear-shadow'></div>
		    <div class='contenedor'>";
		    	$arreglo[1]='Ingeniería Bioquímica';
		    	$arreglo[2]='Gestión Empresarial';
		    	$arreglo[3]='Ingeniería Industrial';
		    	$arreglo[4]='Ingeniería Mecatrónica';
		    	$arreglo[5]='Ingeniería en Nanotecnología';
		    	$arreglo[6]='Ingeniería en Sistemas Computacionales';
		    	$arreglo[7]='Ingeniería Tecnologías de la Información y Comunicaciones';
		    	for($i=1;$i<=7;$i++){
		    		echo"
		    		<div class='contenedor-$i'>
		        		<form name='carr".$i."' method='POST' action='asignar_grupo2.php'>
		        			<table width='675'>
		        				<tr>
		        					<td width='550'>";
		        						echo "<ba>".$arreglo[$i]."</ba>
		        					</td>
		        					<td>
		        						<input type='hidden' value='$i' name='carrera'>
		        						<input type='submit' value='Asignar Grupos' name='consulta_carrera'>
		        					</td>
		        				</tr>
		        			</table>
		        		</form>
				    </div>";
				}
				echo"
			</div>
		</section>
	</div>";
	}
	function asignar_grupo($carrera){
		
		session_start();
		require_once '../consultas/sentencias_consultas_carreras_municipio.php';
		$arreglo[1]=$bioquimica;		$arreglo[2]=$gestion;
		$arreglo[3]=$industrial;		$arreglo[4]=$meca;
		$arreglo[5]=$nano;				$arreglo[6]=$sistemas;
		$arreglo[7]=$tics;
		$nombre[1]="Bioq";		$nombre[2]="Gest";
		$nombre[3]="Ind";		$nombre[4]="Meca";
		$nombre[5]="Nano";		$nombre[6]="Sist";
		$nombre[7]="Tics";
		require_once '../consultas/sentencias_total_alumnos.php';
		$alumnos[1]=$bio;		$alumnos[2]=$ges;
		$alumnos[3]=$ind;		$alumnos[4]=$mec;
		$alumnos[5]=$nan;		$alumnos[6]=$sis;
		$alumnos[7]=$tic;
		echo"
		<div class='container'>
			<section class='tabs'>
            	<input id='tab-1' type='radio' name='radio-set' class='tab-selector-1' checked='checked' style='visibility:hidden'/>
            	<label for='tab-1' class='tab-label-1'><stroke-2>".$nombre[$carrera]."</label>        	
		    	<div class='clear-shadow'></div>
		    	<div class='contenedor'>";
		    		require_once '../conexion/conex_mysql.php';
					$i=$carrera;
		    		echo"
					<div class='contenedor-1'>
						<form id='form1' name='form1' method='post' action='guardar_grupo.php'>";
							$mysqli = new mysqli ($hostname,$username,$password,$database);
							if ($mysqli->connect_errno){
								die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
							}
							$query = $arreglo[$carrera];
							$resultado = $mysqli->query($query);
								
							$reg = mysqli_num_rows($resultado);
							//$array=mysqli_fetch_row($resultado);
							$cont=1;
							if($reg!=0){
								$array[0]=$reg;
								echo "
								<table border='1' width='700'>
									<tr>
										<td><bb>Ficha</bb></td>
										<td><bb>Nombre</bb></td>
										<td><bb>Apellido Paterno</bb></td>
										<td><bb>Apellido Materno</bb></td>
										<td><bb>Municipio</bb></td>
										<td><bb>Grupo</bb></td>
										<td><bb>Carrera</bb></td>
									</tr>";
								while($rows=mysqli_fetch_array($resultado)){
									$grupo=$rows['sa_grupo_gen'];
									$ficha=$rows['se_no_ficha'];
									echo "
								
									<tr>
										<td><pp>".$rows['se_no_ficha']."</pp></td>
										<td><pp>".$rows['dp_nombre']."</pp></td>
										<td><pp>".$rows['dp_ap_paterno']."</pp></td>
										<td><pp>".$rows['dp_ap_materno']."</pp></td>
										<td><pp>".$rows['se_esc_proced_mun']."</pp></td>
										<td><pp><input type='text' name='gpo".$cont."' id='textfield' value='$grupo' size='3' /></pp></td>
										<td><input type='button' Value='Modificar' name='enviar$cont' onClick='modificar($cont,$ficha)'> </td>
										<input name='ficha' id='ficha' value='$ficha' hidden>
										<input name='ficha$cont' id='ficha$cont' value='$ficha' hidden>
									</tr>
										";
									$array[$cont]=$rows['se_no_ficha'];
									$cont++;
								}
									echo "</table>";
									$nombre='arreglo'.$i;
									$_SESSION[$nombre] = $array;
							}
							else{
								echo "No existen alumnos de esa carrera";
							}
							echo"
						
  							<table width='700'>
  								<tr align='right'><br>
  								<input name='carrera' id='carrera' value='$carrera' hidden></input>
  									<td><input type='submit' Value='Registrar' name='enviar'></td>
    							</tr>
  							</table>
						</form>
			    	</div>";
			echo"
			</div>
			</section>
		</div>";
	
	
	}
	function modificar_carrera($ficha){
		require_once '../conexion/conex_mysql.php';
		$mysqli = new mysqli ($hostname,$username,$password,$database);
		if ($mysqli->connect_errno){
			die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
		}
		$query = "SELECT * from alumnos_datos_personales T1 INNER JOIN alumnos_caracterizacion T2 ON T1.se_no_ficha=T2.se_no_ficha WHERE T1.se_no_ficha='$ficha'";
		$resultado = $mysqli->query($query);
		$rows = mysqli_fetch_array($resultado);		
		$nombre=($rows['dp_nombre']);
		$apaterno=($rows['dp_ap_paterno']);
		$amaterno=($rows['dp_ap_materno']);
		$carrera=($rows['dp_carrera']);
		$grupo=($rows['sa_grupo_gen']);

		echo"
		<div class='container'>
			<section class='tabs'>
				<div class='contenedor-1'>
    				<fieldset><legend><stroke>PERSONALES</stroke></legend>
						<form action='modificar.php' method='POST'>
							<table width='675' border='0'>
								<tr>
									<td><ba>No Ficha:</td>
									<td><ba>Grupo:</ba></td>								
								</tr>
								<tr>
									<td><input type='text' name='ficha' id='ficha' max='5' size='10' align='right' readonly value='$ficha'></td>
									<td><input type='text' name='grupo' id='grupo' max='5' size='10' align='right' value='$grupo'></td>						
								</tr>
								<tr>
									<td><ba>Nombre (s):</td>
									<td></td>
								</tr>
								<tr>
									<td><input type='text' name='nombre' id='nombre' size='25' readonly value='$nombre'></td>
									<td></td>
								</tr>
								<tr>
									<td><ba>Apellido Paterno:</td>
									<td><ba>Apellido Materno:</td>
								</tr>
								<tr>
									<td><input type='text' name='ap_paterno' id='ap_paterno' size='20' readonly value='$apaterno'></td>
									<td><input type='text' name='ap_materno' id='ap_materno' size='20' readonly value='$amaterno'></td>
								</tr>
							</table>
							<table width='675' border='0'>
								<tr>
									<td><ba>Carrera</td>
								</tr>";
									menu_carrera($carrera,$ficha);
								echo"								
							</table>
						</form>
					</fieldset>
				</div>
			</section>
		</div>";
	}
	function menu_carrera($carrera){
		if($carrera=='INGENIERIA BIOQUIMICA'){
			echo"
			<tr>
				<td>									
					<select name='carrera' id='carrera'>
						<option value='INGENIERIA BIOQUIMICA'>INGENIERIA BIOQUIMICA</option>
						<option value='INGENIERIA INDUSTRIAL'>INGENIERIA INDUSTRIAL</option>
						<option value='INGENIERIA MECATRONICA'>INGENIERIA MECATRONICA</option>
						<option value='INGENIERÍA EN NANOTECNOLOGÍA'>INGENIERÍA EN NANOTECNOLOGÍA</option>
						<option value='INGENIERIA EN GESTION EMPRESARIAL'>INGENIERIA EN GESTION EMPRESARIAL</option>
						<option value='INGENIERIA EN SISTEMAS COMPUTACIONALES'>INGENIERIA EN SISTEMAS COMPUTACIONALES</option>
						<option value='INGENIERIA EN TECNOLOGIAS DE LA INFORMACION Y COMUNICACIONES'>INGENIERIA EN TECNOLOGIAS DE LA INFORMACION Y COMUNICACIONES</option>	
					</select>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><input type='submit' value='Modificar'></td>
			</tr>
			";
		}
		else if($carrera=='INGENIERIA INDUSTRIAL'){
			echo"			
			<tr>
				<td>									
					<select name='carrera' id='carrera'>
						<option value='INGENIERIA INDUSTRIAL'>INGENIERIA INDUSTRIAL</option>
						<option value='INGENIERIA BIOQUIMICA'>INGENIERIA BIOQUIMICA</option>
						<option value='INGENIERIA MECATRONICA'>INGENIERIA MECATRONICA</option>
						<option value='INGENIERÍA EN NANOTECNOLOGÍA'>INGENIERÍA EN NANOTECNOLOGÍA</option>
						<option value='INGENIERIA EN GESTION EMPRESARIAL'>INGENIERIA EN GESTION EMPRESARIAL</option>
						<option value='INGENIERIA EN SISTEMAS COMPUTACIONALES'>INGENIERIA EN SISTEMAS COMPUTACIONALES</option>
						<option value='INGENIERIA EN TECNOLOGIAS DE LA INFORMACION Y COMUNICACIONES'>INGENIERIA EN TECNOLOGIAS DE LA INFORMACION Y COMUNICACIONES</option>	
					</select>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><input type='submit' value='Modificar'></td>
			</tr>";					
		}
		else if($carrera=='INGENIERIA MECATRONICA'){
			echo"			
			<tr>
				<td>									
					<select name='carrera' id='carrera'>
						<option value='INGENIERIA MECATRONICA'>INGENIERIA MECATRONICA</option>
						<option value='INGENIERIA BIOQUIMICA'>INGENIERIA BIOQUIMICA</option>
						<option value='INGENIERIA INDUSTRIAL'>INGENIERIA INDUSTRIAL</option>
						<option value='INGENIERÍA EN NANOTECNOLOGÍA'>INGENIERÍA EN NANOTECNOLOGÍA</option>
						<option value='INGENIERIA EN GESTION EMPRESARIAL'>INGENIERIA EN GESTION EMPRESARIAL</option>
						<option value='INGENIERIA EN SISTEMAS COMPUTACIONALES'>INGENIERIA EN SISTEMAS COMPUTACIONALES</option>
						<option value='INGENIERIA EN TECNOLOGIAS DE LA INFORMACION Y COMUNICACIONES'>INGENIERIA EN TECNOLOGIAS DE LA INFORMACION Y COMUNICACIONES</option>	
					</select>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><input type='submit' value='Modificar'></td>
			</tr>";
		}
		else if($carrera=='INGENIERÍA EN NANOTECNOLOGÍA'){
			echo"			
			<tr>
				<td>									
					<select name='carrera' id='carrera'>						
						<option value='INGENIERÍA EN NANOTECNOLOGÍA'>INGENIERÍA EN NANOTECNOLOGÍA</option>
						<option value='INGENIERIA BIOQUIMICA'>INGENIERIA BIOQUIMICA</option>
						<option value='INGENIERIA INDUSTRIAL'>INGENIERIA INDUSTRIAL</option>
						<option value='INGENIERIA MECATRONICA'>INGENIERIA MECATRONICA</option>			
						<option value='INGENIERIA EN GESTION EMPRESARIAL'>INGENIERIA EN GESTION EMPRESARIAL</option>
						<option value='INGENIERIA EN SISTEMAS COMPUTACIONALES'>INGENIERIA EN SISTEMAS COMPUTACIONALES</option>
						<option value='INGENIERIA EN TECNOLOGIAS DE LA INFORMACION Y COMUNICACIONES'>INGENIERIA EN TECNOLOGIAS DE LA INFORMACION Y COMUNICACIONES</option>	
					</select>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><input type='submit' value='Modificar'></td>
			</tr>";
		}
		else if($carrera=='INGENIERIA EN GESTION EMPRESARIAL'){		
			echo"			
			<tr>
				<td>									
					<select name='carrera' id='carrera'>						
						<option value='INGENIERIA EN GESTION EMPRESARIAL'>INGENIERIA EN GESTION EMPRESARIAL</option>
						<option value='INGENIERIA BIOQUIMICA'>INGENIERIA BIOQUIMICA</option>
						<option value='INGENIERIA INDUSTRIAL'>INGENIERIA INDUSTRIAL</option>
						<option value='INGENIERIA MECATRONICA'>INGENIERIA MECATRONICA</option>
						<option value='INGENIERÍA EN NANOTECNOLOGÍA'>INGENIERÍA EN NANOTECNOLOGÍA</option>
						<option value='INGENIERIA EN SISTEMAS COMPUTACIONALES'>INGENIERIA EN SISTEMAS COMPUTACIONALES</option>
						<option value='INGENIERIA EN TECNOLOGIAS DE LA INFORMACION Y COMUNICACIONES'>INGENIERIA EN TECNOLOGIAS DE LA INFORMACION Y COMUNICACIONES</option>	
					</select>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><input type='submit' value='Modificar'></td>
			</tr>";			
		}
		else if($carrera=='INGENIERIA EN SISTEMAS COMPUTACIONALES'){					
			echo"			
			<tr>
				<td>									
					<select name='carrera' id='carrera'>						
						<option value='INGENIERIA EN SISTEMAS COMPUTACIONALES'>INGENIERIA EN SISTEMAS COMPUTACIONALES</option>
						<option value='INGENIERIA BIOQUIMICA'>INGENIERIA BIOQUIMICA</option>
						<option value='INGENIERIA INDUSTRIAL'>INGENIERIA INDUSTRIAL</option>
						<option value='INGENIERIA MECATRONICA'>INGENIERIA MECATRONICA</option>
						<option value='INGENIERÍA EN NANOTECNOLOGÍA'>INGENIERÍA EN NANOTECNOLOGÍA</option>
						<option value='INGENIERIA EN GESTION EMPRESARIAL'>INGENIERIA EN GESTION EMPRESARIAL</option>						
						<option value='INGENIERIA EN TECNOLOGIAS DE LA INFORMACION Y COMUNICACIONES'>INGENIERIA EN TECNOLOGIAS DE LA INFORMACION Y COMUNICACIONES</option>	
					</select>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><input type='submit' value='Modificar'></td>
			</tr>";							
		}
		else if($carrera=='INGENIERIA EN TECNOLOGIAS DE LA INFORMACION Y COMUNICACIONES'){				
			echo"			
			<tr>
				<td>									
					<select name='carrera' id='carrera'>
						<option value='INGENIERIA EN TECNOLOGIAS DE LA INFORMACION Y COMUNICACIONES'>INGENIERIA EN TECNOLOGIAS DE LA INFORMACION Y COMUNICACIONES</option>
						<option value='INGENIERIA BIOQUIMICA'>INGENIERIA BIOQUIMICA</option>
						<option value='INGENIERIA INDUSTRIAL'>INGENIERIA INDUSTRIAL</option>
						<option value='INGENIERIA MECATRONICA'>INGENIERIA MECATRONICA</option>
						<option value='INGENIERÍA EN NANOTECNOLOGÍA'>INGENIERÍA EN NANOTECNOLOGÍA</option>
						<option value='INGENIERIA EN GESTION EMPRESARIAL'>INGENIERIA EN GESTION EMPRESARIAL</option>
						<option value='INGENIERIA EN SISTEMAS COMPUTACIONALES'>INGENIERIA EN SISTEMAS COMPUTACIONALES</option>												
					</select>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><input type='submit' value='Modificar'></td>
			</tr>";									
		}
		
	}
	function asignar_control(){
			require_once '../conexion/conex_ms_sql.php';
			$link = mssql_connect($server_mssql,$user_mssql,$pwd_mssql) or die ("no se ha podido conectar");
			// Seleccionar la base de datos 'my.database-name'
			$selected=mssql_select_db($bd_mssql, $link) or die ("no se puede abrir base de datos");		
			$query="SELECT alf_Folio,als_NumControl FROM AlumSelecc WHERE als_Inscrito=1";
			// EJECUTAMOS SENTENCIA	
			$result = mssql_query($query,$link);
			$row=mssql_num_rows($result);
			if(!empty($row))
			{
				require_once '../conexion/conex_mysql.php';
				$mysqli = new mysqli ($hostname,$username,$password,$database);
				if ($mysqli->connect_errno){
					die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
				}
				$cont=0;
				while ($rows=mssql_fetch_array($result)){
					$no_ficha=$rows['alf_Folio'];
					$control=$rows['als_NumControl'];					
					$query = "UPDATE alumnos_datos_personales SET se_no_control='$control' where se_no_ficha='$no_ficha'";
					$resultado = $mysqli->query($query);
					$r=$mysqli->affected_rows;
					if(!empty($r))
					{$cont++;}
				}
				echo"<script languaje='javascript'>mensaje($row,$cont);</script>";
				$mysqli->close();
			}
	}
	function busca_control($ficha){
		$no_ficha=$ficha;
		require('../conexion/conex_mysql.php');
		$mysqli = new mysqli ($hostname,$username,$password,$database);
		if ($mysqli->connect_errno){
			die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
		}		
		$query = "SELECT * from alumnos_datos_personales WHERE se_no_ficha='$no_ficha'";
		$resultado = $mysqli->query($query);
		$rows = mysqli_fetch_array($resultado);

		$nombre=($rows['dp_nombre']);
		$apaterno=($rows['dp_ap_paterno']);
		$amaterno=($rows['dp_ap_materno']);
		$sexo=($rows['dp_sexo']);
		$carrera=($rows['dp_carrera']);
		$curp=($rows['se_curp']);
		$control=($rows['se_no_control']);
		echo"
		<div class='contenedor-1'>
    		<fieldset><legend><stroke>PERSONALES</stroke></legend>
			<form action='' method='POST' name='F1'>
				<table width='675' border='0'>
					<tr>
						<td width='410'><ba>No Ficha:</td>
						<td><ba>No Control:</td>
					</tr>
					<tr>
						<td><input type='text' name='ficha' id='ficha' max='5' size='10' align='right' readonly value='$no_ficha'></td>
						<td><input type='text' name='control' id='control' size='10' value='$control' autofocus></td>
					</tr>
					<tr>
						<td><ba>Nombre (s):</td>
						<td><ba>Sexo:</td>
					</tr>
					<tr>
						<td><input type='text' name='nombre' id='nombre' size='25' readonly value='$nombre'></td>
						<td><input type='text' name='sexo' id='sexo' readonly value='$sexo' size='2'></td>
					</tr>
					<tr>
						<td><ba>Apellido Paterno:</td>
						<td><ba>Apellido Materno:</td>
					</tr>
					<tr>
						<td><input type='text' name='ap_paterno' id='ap_paterno' size='20' readonly value='$apaterno'></td>
						<td><input type='text' name='ap_materno' id='ap_materno' size='20' readonly value='$amaterno'></td>
					</tr>
					<tr>
						<td><ba>CURP:</td>
					</tr>
					<tr>
						<td><input type='text' name='curp'  max='18' id='curp' size='20' readonly value='$curp'></td>
					</tr>
				</table>
				<table width='675' border='0'>
					<tr>
						<td><ba>Carrera</td>
					</tr>
					<tr>
					<td><input type='text' name='carreras' id='carreras' readonly value='$carrera' size='68'/></td>
					</tr>
				</table>
				<table width='675'>
					<tr>
						<td width='80%'></td>
						<td><input type='submit' value='Guardar' name='guardar'></td>						
					</tr>
				</table>
			</form>
			</fieldset>
		</div>";
	}
?>