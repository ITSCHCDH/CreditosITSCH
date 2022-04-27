<?php
	$bioquimica="SELECT * FROM alumnos_datos_personales T1 INNER JOIN semaforos_caracterizacion T2 ON T1.se_no_ficha=T2.no_ficha INNER JOIN alumnos_caracterizacion T3 ON T1.se_no_ficha=T3.se_no_ficha WHERE dp_carrera='INGENIERIA BIOQUIMICA' ";

	$gestion="SELECT * FROM alumnos_datos_personales T1 INNER JOIN semaforos_caracterizacion T2 ON T1.se_no_ficha=T2.no_ficha INNER JOIN alumnos_caracterizacion T3 ON T1.se_no_ficha=T3.se_no_ficha WHERE dp_carrera='INGENIERIA EN GESTION EMPRESARIAL' ";

	$industrial="SELECT * FROM alumnos_datos_personales T1 INNER JOIN semaforos_caracterizacion T2 ON T1.se_no_ficha=T2.no_ficha INNER JOIN alumnos_caracterizacion T3 ON T1.se_no_ficha=T3.se_no_ficha WHERE dp_carrera='INGENIERIA INDUSTRIAL' ";

	$meca="SELECT * FROM alumnos_datos_personales T1 INNER JOIN semaforos_caracterizacion T2 ON T1.se_no_ficha=T2.no_ficha INNER JOIN alumnos_caracterizacion T3 ON T1.se_no_ficha=T3.se_no_ficha WHERE dp_carrera='INGENIERIA MECATRONICA' ";

	$nano="SELECT * FROM alumnos_datos_personales T1 INNER JOIN semaforos_caracterizacion T2 ON T1.se_no_ficha=T2.no_ficha INNER JOIN alumnos_caracterizacion T3 ON T1.se_no_ficha=T3.se_no_ficha WHERE dp_carrera='INGENIERÍA EN NANOTECNOLOGÍA' ";

	$sistemas="SELECT * FROM alumnos_datos_personales T1 INNER JOIN semaforos_caracterizacion T2 ON T1.se_no_ficha=T2.no_ficha INNER JOIN alumnos_caracterizacion T3 ON T1.se_no_ficha=T3.se_no_ficha WHERE dp_carrera='INGENIERIA EN SISTEMAS COMPUTACIONALES' ";

	$tics="SELECT * FROM alumnos_datos_personales T1 INNER JOIN semaforos_caracterizacion T2 ON T1.se_no_ficha=T2.no_ficha INNER JOIN alumnos_caracterizacion T3 ON T1.se_no_ficha=T3.se_no_ficha WHERE dp_carrera='INGENIERIA EN TECNOLOGIAS DE LA INFORMACION Y COMUNICACIONES' ";
?>