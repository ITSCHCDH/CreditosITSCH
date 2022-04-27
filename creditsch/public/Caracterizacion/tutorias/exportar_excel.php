<?php
//
//*@Control de presentacion de los weblogs. "exportar_pdf.php"
//*@version: 1.0  @modificado:25 de abril del 2016
//*@autores: Vanessa Jacqueline Villegas Granciano
//		     Daniel Moreno Tellez
//*
//*/

	//generamos nuestro archivo con extension .xls
	header ("Content-type: application/vnd.ms-excel");
	header ("Content-Disposition: attachment; filename=Reporte_caracterizacion.xls");
			
?>
<?php
//el siguiente fracmento de codigo es HTML y solo nos sirve para crear nuestra tabla que mostrara el reporte
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Caracterizacion</title>
</head>
<body>
<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="48" bgcolor="#ffffff"><CENTER><strong>REPORTE CARACTERIZACION</strong></CENTER></td>
  </tr>
  <tr bgcolor="#ffffff">
    <td><strong>SE_NO_FICHA</strong></td>
    <td><strong>SE_NO_CONTROL</strong></td>
    <td><strong>SE_FECHA_FICHA</strong></td>
	<td><strong>DP_NOMBRE</strong></td>
	<td><strong>DP_AP_PATERNO</strong></td>
	<td><strong>DP_AP_MATERNO</strong></td>
	<td><strong>DP_SEXO</strong></td>
	<td><strong>DP_CARRERA</strong></td>
	<td><strong>DP_DIRECCION</strong></td>
	<td><strong>DP_COLONIA</strong></td>
	<td><strong>DP_COD_POST</strong></td>
	<td><strong>DP_ESTADO</strong></td>
	<td><strong>DP_MUNICIPIO</strong></td>
	<td><strong>SE_CURP</strong></td>
	<td><strong>DP_TIPO_SANGRE</strong></td>
	<td><strong>DP_TEL</strong></td>
	<td><strong>DP_EMAIL</strong></td>
	<td><strong>DP_EDO_CIVIL</strong></td>
	<td><strong>DP_HIJOS</strong></td>
    <td><strong>SE_PROCEDENCIA_FORANEO</strong></td>
    <td><strong>SE_ESC_PROCED</strong></td>
    <td><strong>SE_ESC_PROCED_MUN</strong></td>
    <td><strong>SE_ESC_PROCED_EDO</strong></td>
    <td><strong>SE_BACHILLERATO_PROM</strong></td>
    <td><strong>SE_BACHILLERATO_TIPO</strong></td>
    <td><strong>SE_CORRIMIENTO_LISTAS</strong></td>
    <td><strong>SA_GRUPO_GEN</strong></td>
    <td><strong>SA_EXAM_ADM_RES</strong></td>
    <td><strong>TUT_PROBPSICO_DEPRESION</strong></td>
    <td><strong>TUT_PROBPSICO_AUTOESTIMA</strong></td>
    <td><strong>TUT_PROBPSICO_MACHOVER</strong></td>
    <td><strong>TUT_PROBPSICO_DIAGNOSTICO</strong></td>
    <td><strong>TUT_PROBMED_PESO</strong></td>
    <td><strong>TUT_PROBMED_ENF</strong></td>
    <td><strong>TUT_PROBMED_AD</strong></td>
    <td><strong>TUT_PROBMED_ALERGIAS</strong></td>
    <td><strong>TUT_PROBMED_ALERGMED</strong></td>
    <td><strong>TUT_PROBMED_ENF_HERED</strong></td>
    <td><strong>TUT_PROBFAM_RES</strong></td>
    <td><strong>TUT_HAB_ESTUDIO</strong></td>
    <td><strong>TUT_ORIENT_VOCACIONAL</strong></td>
    <td><strong>TUT_OPC_ESC</strong></td>
    <td><strong>TUT_CARRERA_TRUNCA</strong></td>
    <td><strong>DOC_CURSO_ALEBRA_RES</strong></td>
    <td><strong>DOC_CURSO_REGUL_RES</strong></td>
    <td><strong>EST_SE_INGRESOS_TODOS</strong></td>
    <td><strong>SE_OCASIONES_INGRESO</strong></td>
  </tr>
  
<?PHP
//conectamos con la base de datos 		
	require_once '../conexion/conex_mysql.php';
	$mysqli = new mysqli ($hostname,$username,$password,$database);
	if ($mysqli->connect_errno){
		die ("Fallo la conexion a MySQL: (" .$mysqli -> mysqli_connect_errno(). ") " . $mysqli->mysqli_connect_error());
	}
	//hacemos nuestra consulta	
	$query = "SELECT * FROM alumnos_caracterizacion JOIN alumnos_datos_personales 
	WHERE (alumnos_caracterizacion.se_no_control = alumnos_datos_personales.se_no_control) ORDER BY alumnos_caracterizacion.se_no_control ASC";
	$resultado = $mysqli->query($query);
	
//recorrecmos el array que almacena los registros de la BD 
while($rows = mysqli_fetch_array($resultado)){		
//asignamos los registros a las variables utilizadas
	$noFicha=$rows["se_no_ficha"];
	$noControl=$rows["se_no_control"];
	$fechaFicha=$rows["se_fecha_ficha"];
	$dpNombre=$rows["dp_nombre"];
	$dpApPaterno=$rows["dp_ap_paterno"];
	$dpApMaterno=$rows["dp_ap_materno"];
	$dpSexo=$rows["dp_sexo"];
	$dpCarrera=$rows["dp_carrera"];
	$dpDireccion=$rows["dp_direccion"];
	$dpColonia=$rows["dp_colonia"];
	$dpCodPost=$rows["dp_cod_post"];
	$dpEstado=$rows["dp_estado"];
	$dpMunicipio=$rows["dp_municipio"];
	$dpCurp=$rows["se_curp"];
	$dpTipoSangre=$rows["dp_tipo_sangre"];
	$dpTel=$rows["dp_tel"];
	$dpEmail=$rows["dp_email"];
	$dpEdoCivil=$rows["dp_edo_civil"];
	$dpHijos=$rows["dp_hijos"];
	$procedenciaForaneo=$rows["se_procedencia_foraneo"];
	$escProced=$rows["se_esc_proced"];
	$escProcedMun=$rows["se_esc_proced_mun"];
	$escProcedEdo=$rows["se_esc_proced_edo"];
	$bachilleraroProm=$rows["se_bachillerato_prom"];
	$bachilleraroTipo=$rows["se_bachillerato_tipo"];
	$corrimientoListas=$rows["sa_corrimiento_listas"];
	$grupoGen=$rows["sa_grupo_gen"];
	$examAdmRes=$rows["sa_exam_adm_res"];
	$probpsicoDepresion=$rows["tut_probpsico_depresion"];
	$probpsicoautoestima=$rows["tut_probpsico_autoestima"];
	$probpsicoMachover=$rows["tut_probpsico_machover"];
	$probpsicoDiagnostico=$rows["tut_probpsico_diagnostico"];
	$probmedPeso=$rows["tut_probmed_peso"];
	$probmedEnf=$rows["tut_probmed_enf"];
	$probmedAd=$rows["tut_probmed_ad"];
	$probmedAlegias=$rows["tut_probmed_alergias"];
	$probmedAlergmed=$rows["tut_probmed_alergmed"];
	$probmedEnfHered=$rows["tut_probmed_enf_hered"];
	$probfamRes=$rows["tut_probfam_res"];
	$habEstudio=$rows["tut_hab_estudio"];
	$orientVocacional=$rows["tut_orient_vocacional"];
	$opcEsc=$rows["tut_opc_esc"];
	$carreraTrunca=$rows["tut_carrera_trunca"];
	$cursoAlegebraRes=$rows["doc_curso_algebra_res"];
	$cursoRegulRes=$rows["doc_curso_regul_res"];
	$estIngresosTodos=$rows["est_se_ingresos_todos"];
	$ocasionesIngreso=$rows["se_ocasiones_ingreso"];					
//metemos los registros en nuestra tabla 
?>  
<tr>
	<td><?php echo $noFicha; ?></td>
	<td><?php echo $noControl; ?></td>
	<td><?php echo $fechaFicha; ?></td>
	<td><?php echo $dpNombre; ?></td>
	<td><?php echo $dpApPaterno; ?></td>
	<td><?php echo $dpApMaterno; ?></td>
	<td><?php echo $dpSexo; ?></td>
	<td><?php echo $dpCarrera; ?></td>
	<td><?php echo $dpDireccion; ?></td>
	<td><?php echo $dpColonia; ?></td>
	<td><?php echo $dpCodPost; ?></td>
	<td><?php echo $dpEstado; ?></td>
	<td><?php echo $dpMunicipio; ?></td>
	<td><?php echo $dpCurp; ?></td>
	<td><?php echo $dpTipoSangre; ?></td>
	<td><?php echo $dpTel; ?></td>
	<td><?php echo $dpEmail; ?></td>
	<td><?php echo $dpEdoCivil; ?></td>
	<td><?php echo $dpHijos; ?></td>
	<td><?php echo $procedenciaForaneo; ?></td>
	<td><?php echo $escProced; ?></td>
	<td><?php echo $escProcedMun; ?></td>                     
	<td><?php echo $escProcedEdo; ?></td>
	<td><?php echo $bachilleraroProm; ?></td>
	<td><?php echo $bachilleraroTipo; ?></td>
	<td><?php echo $corrimientoListas; ?></td>
	<td><?php echo $grupoGen; ?></td>
	<td><?php echo $examAdmRes; ?></td> 
	<td><?php echo $probpsicoDepresion; ?></td>
	<td><?php echo $probpsicoautoestima; ?></td>
	<td><?php echo $probpsicoMachover; ?></td>
	<td><?php echo $probpsicoDiagnostico; ?></td>
	<td><?php echo $probmedPeso; ?></td>
	<td><?php echo $probmedEnf; ?></td> 
	<td><?php echo $probmedAd; ?></td>
	<td><?php echo $probmedAlegias; ?></td>
	<td><?php echo $probmedAlergmed; ?></td>
	<td><?php echo $probmedEnfHered; ?></td>
	<td><?php echo $probfamRes; ?></td>
	<td><?php echo $habEstudio; ?></td> 
	<td><?php echo $orientVocacional; ?></td>
	<td><?php echo $opcEsc; ?></td>
	<td><?php echo $carreraTrunca; ?></td>
	<td><?php echo $cursoAlegebraRes; ?></td>
	<td><?php echo $cursoRegulRes; ?></td>
	<td><?php echo $estIngresosTodos; ?></td> 
	<td><?php echo $ocasionesIngreso; ?></td> 
</tr> 
  <?php
}
  ?>
</table>
</body>
</html>
