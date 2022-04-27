<?PHP 
	$bioquimica="SELECT adp.se_no_ficha, adp.dp_nombre, adp.dp_ap_paterno, adp.dp_ap_materno, adp.dp_carrera, ac.se_esc_proced_mun, ac.sa_exam_adm_res, ac.sa_grupo_gen from alumnos_datos_personales adp, alumnos_caracterizacion ac where adp.dp_carrera='INGENIERIA BIOQUIMICA' AND adp.se_no_ficha=ac.se_no_ficha ORDER BY ac.sa_grupo_gen,adp.dp_ap_paterno";

	$gestion="SELECT adp.se_no_ficha, adp.dp_nombre, adp.dp_ap_paterno, adp.dp_ap_materno, adp.dp_carrera, ac.se_esc_proced_mun, ac.sa_exam_adm_res, ac.sa_grupo_gen from alumnos_datos_personales adp, alumnos_caracterizacion ac where adp.dp_carrera='INGENIERIA EN GESTION EMPRESARIAL' AND adp.se_no_ficha=ac.se_no_ficha ORDER BY ac.sa_grupo_gen,adp.dp_ap_paterno";

	$industrial="SELECT adp.se_no_ficha, adp.dp_nombre, adp.dp_ap_paterno, adp.dp_ap_materno, adp.dp_carrera, ac.se_esc_proced_mun, ac.sa_exam_adm_res, ac.sa_grupo_gen from alumnos_datos_personales adp, alumnos_caracterizacion ac where adp.dp_carrera='INGENIERIA INDUSTRIAL' AND adp.se_no_ficha=ac.se_no_ficha ORDER BY ac.sa_grupo_gen,adp.dp_ap_paterno";

	$meca="SELECT adp.se_no_ficha, adp.dp_nombre, adp.dp_ap_paterno, adp.dp_ap_materno, adp.dp_carrera, ac.se_esc_proced_mun, ac.sa_exam_adm_res, ac.sa_grupo_gen from alumnos_datos_personales adp, alumnos_caracterizacion ac where adp.dp_carrera='INGENIERIA MECATRONICA' AND adp.se_no_ficha=ac.se_no_ficha ORDER BY ac.sa_grupo_gen,adp.dp_ap_paterno";

	$nano="SELECT adp.se_no_ficha, adp.dp_nombre, adp.dp_ap_paterno, adp.dp_ap_materno, adp.dp_carrera, ac.se_esc_proced_mun, ac.sa_exam_adm_res, ac.sa_grupo_gen from alumnos_datos_personales adp, alumnos_caracterizacion ac where adp.dp_carrera='INGENIERÍA EN NANOTECNOLOGÍA' AND adp.se_no_ficha=ac.se_no_ficha ORDER BY ac.sa_grupo_gen,adp.dp_ap_paterno";

	$sistemas="SELECT adp.se_no_ficha, adp.dp_nombre, adp.dp_ap_paterno, adp.dp_ap_materno, adp.dp_carrera, ac.se_esc_proced_mun, ac.sa_exam_adm_res, ac.sa_grupo_gen from alumnos_datos_personales adp, alumnos_caracterizacion ac where adp.dp_carrera='INGENIERIA EN SISTEMAS COMPUTACIONALES' AND adp.se_no_ficha=ac.se_no_ficha ORDER BY ac.sa_grupo_gen,adp.dp_ap_paterno";

	$tics="SELECT adp.se_no_ficha, adp.dp_nombre, adp.dp_ap_paterno, adp.dp_ap_materno, adp.dp_carrera, ac.se_esc_proced_mun, ac.sa_exam_adm_res, ac.sa_grupo_gen from alumnos_datos_personales adp, alumnos_caracterizacion ac where adp.dp_carrera='INGENIERIA EN TECNOLOGIAS DE LA INFORMACION Y COMUNICACIONES' AND adp.se_no_ficha=ac.se_no_ficha ORDER BY ac.sa_grupo_gen,adp.dp_ap_paterno";
?>