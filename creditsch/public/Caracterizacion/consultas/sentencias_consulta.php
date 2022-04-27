<?PHP 
	$bioquimica="SELECT adp.se_no_ficha, adp.dp_nombre, adp.dp_ap_paterno, adp.dp_ap_materno, adp.dp_carrera, ac.se_esc_proced_mun, ac.doc_curso_algebra_res, ac.doc_curso_regul_res from alumnos_datos_personales adp, alumnos_caracterizacion ac where adp.dp_carrera='INGENIERIA BIOQUIMICA' AND adp.se_no_ficha=ac.se_no_ficha ORDER BY dp_ap_paterno";

	$bioquimica2="SELECT se_no_ficha, dp_nombre, dp_ap_paterno, dp_ap_materno, dp_carrera from alumnos_datos_personales where dp_carrera='INGENIERIA BIOQUIMICA'  ORDER BY dp_ap_paterno";

	$gestion="SELECT adp.se_no_ficha, adp.dp_nombre, adp.dp_ap_paterno, adp.dp_ap_materno, adp.dp_carrera, ac.se_esc_proced_mun, ac.doc_curso_algebra_res, ac.doc_curso_regul_res from alumnos_datos_personales adp, alumnos_caracterizacion ac where adp.dp_carrera='INGENIERIA EN GESTION EMPRESARIAL' AND adp.se_no_ficha=ac.se_no_ficha ORDER BY dp_ap_paterno";

	$gestion2="SELECT se_no_ficha, dp_nombre, dp_ap_paterno, dp_ap_materno, dp_carrera from alumnos_datos_personales where dp_carrera='INGENIERIA EN GESTION EMPRESARIAL' ORDER BY dp_ap_paterno";

	$industrial="SELECT adp.se_no_ficha, adp.dp_nombre, adp.dp_ap_paterno, adp.dp_ap_materno, adp.dp_carrera, ac.se_esc_proced_mun, ac.doc_curso_algebra_res, ac.doc_curso_regul_res from alumnos_datos_personales adp, alumnos_caracterizacion ac where adp.dp_carrera='INGENIERIA INDUSTRIAL' AND adp.se_no_ficha=ac.se_no_ficha ORDER BY dp_ap_paterno";

	$industrial2="SELECT se_no_ficha, dp_nombre, dp_ap_paterno, dp_ap_materno, dp_carrera from alumnos_datos_personales where dp_carrera='INGENIERIA INDUSTRIAL' ORDER BY dp_ap_paterno";

	$meca="SELECT adp.se_no_ficha, adp.dp_nombre, adp.dp_ap_paterno, adp.dp_ap_materno, adp.dp_carrera, ac.se_esc_proced_mun, ac.doc_curso_algebra_res, ac.doc_curso_regul_res from alumnos_datos_personales adp, alumnos_caracterizacion ac where adp.dp_carrera='INGENIERIA MECATRONICA' AND adp.se_no_ficha=ac.se_no_ficha ORDER BY dp_ap_paterno";

	$meca2="SELECT se_no_ficha, dp_nombre, dp_ap_paterno, dp_ap_materno, dp_carrera from alumnos_datos_personales where dp_carrera='INGENIERIA MECATRONICA' ORDER BY dp_ap_paterno";

	$nano="SELECT adp.se_no_ficha, adp.dp_nombre, adp.dp_ap_paterno, adp.dp_ap_materno, adp.dp_carrera, ac.se_esc_proced_mun, ac.doc_curso_algebra_res, ac.doc_curso_regul_res from alumnos_datos_personales adp, alumnos_caracterizacion ac where adp.dp_carrera='INGENIERÍA EN NANOTECNOLOGÍA' AND adp.se_no_ficha=ac.se_no_ficha ORDER BY dp_ap_paterno";

	$nano2="SELECT se_no_ficha, dp_nombre, dp_ap_paterno, dp_ap_materno, dp_carrera from alumnos_datos_personales where dp_carrera='INGENIERÍA EN NANOTECNOLOGÍA' ORDER BY dp_ap_paterno";

	$sistemas="SELECT adp.se_no_ficha, adp.dp_nombre, adp.dp_ap_paterno, adp.dp_ap_materno, adp.dp_carrera, ac.se_esc_proced_mun, ac.doc_curso_algebra_res, ac.doc_curso_regul_res from alumnos_datos_personales adp, alumnos_caracterizacion ac where adp.dp_carrera='INGENIERIA EN SISTEMAS COMPUTACIONALES' AND adp.se_no_ficha=ac.se_no_ficha ORDER BY dp_ap_paterno";

	$sistemas2="SELECT se_no_ficha, dp_nombre, dp_ap_paterno, dp_ap_materno, dp_carrera from alumnos_datos_personales where dp_carrera='INGENIERIA EN SISTEMAS COMPUTACIONALES' ORDER BY dp_ap_paterno";

	$tics="SELECT adp.se_no_ficha, adp.dp_nombre, adp.dp_ap_paterno, adp.dp_ap_materno, adp.dp_carrera, ac.se_esc_proced_mun, ac.doc_curso_algebra_res, ac.doc_curso_regul_res from alumnos_datos_personales adp, alumnos_caracterizacion ac where adp.dp_carrera='INGENIERIA EN TECNOLOGIAS DE LA INFORMACION Y COMUNICACIONES' AND adp.se_no_ficha=ac.se_no_ficha ORDER BY dp_ap_paterno";

	$tics2="SELECT se_no_ficha, dp_nombre, dp_ap_paterno, dp_ap_materno, dp_carrera from alumnos_datos_personales where dp_carrera='INGENIERIA EN TECNOLOGIAS DE LA INFORMACION Y COMUNICACIONES' ORDER BY dp_ap_paterno";
?>