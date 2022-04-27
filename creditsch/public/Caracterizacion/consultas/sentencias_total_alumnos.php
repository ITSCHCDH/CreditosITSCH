<?PHP

$bio="SELECT COUNT(*) FROM alumnos_datos_personales T1 INNER JOIN semaforos_caracterizacion T2 ON T1.se_no_ficha=T2.no_ficha INNER JOIN alumnos_caracterizacion T3 ON T1.se_no_ficha=T3.se_no_ficha WHERE dp_carrera='INGENIERIA BIOQUIMICA'";
$ges="SELECT COUNT(*) FROM alumnos_datos_personales T1 INNER JOIN semaforos_caracterizacion T2 ON T1.se_no_ficha=T2.no_ficha INNER JOIN alumnos_caracterizacion T3 ON T1.se_no_ficha=T3.se_no_ficha WHERE dp_carrera='INGENIERIA EN GESTION EMPRESARIAL'";
$ind="SELECT COUNT(*) FROM alumnos_datos_personales T1 INNER JOIN semaforos_caracterizacion T2 ON T1.se_no_ficha=T2.no_ficha INNER JOIN alumnos_caracterizacion T3 ON T1.se_no_ficha=T3.se_no_ficha WHERE dp_carrera='INGENIERIA INDUSTRIAL'";
$mec="SELECT COUNT(*) FROM alumnos_datos_personales T1 INNER JOIN semaforos_caracterizacion T2 ON T1.se_no_ficha=T2.no_ficha INNER JOIN alumnos_caracterizacion T3 ON T1.se_no_ficha=T3.se_no_ficha WHERE dp_carrera='INGENIERIA MECATRONICA'";
$nan="SELECT COUNT(*) FROM alumnos_datos_personales T1 INNER JOIN semaforos_caracterizacion T2 ON T1.se_no_ficha=T2.no_ficha INNER JOIN alumnos_caracterizacion T3 ON T1.se_no_ficha=T3.se_no_ficha WHERE dp_carrera='INGENIERÍA EN NANOTECNOLOGÍA'";
$sis="SELECT COUNT(*) FROM alumnos_datos_personales T1 INNER JOIN semaforos_caracterizacion T2 ON T1.se_no_ficha=T2.no_ficha INNER JOIN alumnos_caracterizacion T3 ON T1.se_no_ficha=T3.se_no_ficha WHERE dp_carrera='INGENIERIA EN SISTEMAS COMPUTACIONALES'";
$tic="SELECT COUNT(*) FROM alumnos_datos_personales T1 INNER JOIN semaforos_caracterizacion T2 ON T1.se_no_ficha=T2.no_ficha INNER JOIN alumnos_caracterizacion T3 ON T1.se_no_ficha=T3.se_no_ficha WHERE dp_carrera='INGENIERIA EN TECNOLOGIAS DE LA INFORMACION Y COMUNICACIONES'";


?>