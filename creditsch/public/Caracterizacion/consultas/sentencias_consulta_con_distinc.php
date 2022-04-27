<?PHP 
	
	$bioquimica="SELECT DISTINCT adp.dp_carrera, ac.sa_grupo_gen FROM alumnos_datos_personales adp, alumnos_caracterizacion ac WHERE ac.se_no_ficha=adp.se_no_ficha AND adp.dp_carrera='INGENIERIA BIOQUIMICA' ORDER BY adp.dp_carrera";
	
	$gestion="SELECT DISTINCT adp.dp_carrera, ac.sa_grupo_gen FROM alumnos_datos_personales adp, alumnos_caracterizacion ac WHERE ac.se_no_ficha=adp.se_no_ficha AND adp.dp_carrera='INGENIERIA EN GESTION EMPRESARIAL' ORDER BY adp.dp_carrera";
	
	$industrial="SELECT DISTINCT adp.dp_carrera, ac.sa_grupo_gen FROM alumnos_datos_personales adp, alumnos_caracterizacion ac WHERE ac.se_no_ficha=adp.se_no_ficha AND adp.dp_carrera='INGENIERIA INDUSTRIAL' ORDER BY adp.dp_carrera";

	$meca="SELECT DISTINCT adp.dp_carrera, ac.sa_grupo_gen FROM alumnos_datos_personales adp, alumnos_caracterizacion ac WHERE ac.se_no_ficha=adp.se_no_ficha AND adp.dp_carrera='INGENIERIA MECATRONICA' ORDER BY adp.dp_carrera";

	$nano="SELECT DISTINCT adp.dp_carrera, ac.sa_grupo_gen FROM alumnos_datos_personales adp, alumnos_caracterizacion ac WHERE ac.se_no_ficha=adp.se_no_ficha AND adp.dp_carrera='INGENIERÍA EN NANOTECNOLOGÍA' ORDER BY adp.dp_carrera";

	$sistemas="SELECT DISTINCT adp.dp_carrera, ac.sa_grupo_gen FROM alumnos_datos_personales adp, alumnos_caracterizacion ac WHERE ac.se_no_ficha=adp.se_no_ficha AND adp.dp_carrera='INGENIERIA EN SISTEMAS COMPUTACIONALES' ORDER BY adp.dp_carrera";

	$tics="SELECT DISTINCT adp.dp_carrera, ac.sa_grupo_gen FROM alumnos_datos_personales adp, alumnos_caracterizacion ac WHERE ac.se_no_ficha=adp.se_no_ficha AND adp.dp_carrera='INGENIERIA EN TECNOLOGIAS DE LA INFORMACION Y COMUNICACIONES' ORDER BY adp.dp_carrera";


?>