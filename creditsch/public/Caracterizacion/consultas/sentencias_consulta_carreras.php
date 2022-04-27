<?php
	$bioquimica="SELECT * FROM alumnos_datos_personales T1 INNER JOIN semaforos_caracterizacion T2 ON T1.se_no_ficha=T2.no_ficha INNER JOIN alumnos_caracterizacion T3 ON T1.se_no_ficha=T3.se_no_ficha WHERE dp_carrera='INGENIERIA BIOQUIMICA' ORDER BY sa_grupo_gen DESC, dp_ap_paterno ASC";

	$gestion="SELECT * FROM alumnos_datos_personales T1 INNER JOIN semaforos_caracterizacion T2 ON T1.se_no_ficha=T2.no_ficha INNER JOIN alumnos_caracterizacion T3 ON T1.se_no_ficha=T3.se_no_ficha WHERE dp_carrera='INGENIERIA EN GESTION EMPRESARIAL' ORDER BY sa_grupo_gen DESC, dp_ap_paterno ASC";

	$industrial="SELECT * FROM alumnos_datos_personales T1 INNER JOIN semaforos_caracterizacion T2 ON T1.se_no_ficha=T2.no_ficha INNER JOIN alumnos_caracterizacion T3 ON T1.se_no_ficha=T3.se_no_ficha WHERE dp_carrera='INGENIERIA INDUSTRIAL' ORDER BY sa_grupo_gen DESC, dp_ap_paterno ASC";

	$meca="SELECT * FROM alumnos_datos_personales T1 INNER JOIN semaforos_caracterizacion T2 ON T1.se_no_ficha=T2.no_ficha INNER JOIN alumnos_caracterizacion T3 ON T1.se_no_ficha=T3.se_no_ficha WHERE dp_carrera='INGENIERIA MECATRONICA' ORDER BY sa_grupo_gen DESC, dp_ap_paterno ASC";

	$nano="SELECT * FROM alumnos_datos_personales T1 INNER JOIN semaforos_caracterizacion T2 ON T1.se_no_ficha=T2.no_ficha INNER JOIN alumnos_caracterizacion T3 ON T1.se_no_ficha=T3.se_no_ficha WHERE dp_carrera='INGENIERÍA EN NANOTECNOLOGÍA' ORDER BY sa_grupo_gen DESC, dp_ap_paterno ASC";

	$sistemas="SELECT * FROM alumnos_datos_personales T1 INNER JOIN semaforos_caracterizacion T2 ON T1.se_no_ficha=T2.no_ficha INNER JOIN alumnos_caracterizacion T3 ON T1.se_no_ficha=T3.se_no_ficha WHERE dp_carrera='INGENIERIA EN SISTEMAS COMPUTACIONALES' ORDER BY sa_grupo_gen DESC, dp_ap_paterno ASC";

	$tics="SELECT * FROM alumnos_datos_personales T1 INNER JOIN semaforos_caracterizacion T2 ON T1.se_no_ficha=T2.no_ficha INNER JOIN alumnos_caracterizacion T3 ON T1.se_no_ficha=T3.se_no_ficha WHERE dp_carrera='INGENIERIA EN TECNOLOGIAS DE LA INFORMACION Y COMUNICACIONES' ORDER BY sa_grupo_gen DESC, dp_ap_paterno ASC";
?>