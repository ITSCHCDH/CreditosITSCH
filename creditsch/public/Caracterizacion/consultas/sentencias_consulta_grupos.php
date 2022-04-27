<?php
	$bioquimica1="SELECT * FROM alumnos_datos_personales T1 INNER JOIN semaforos_caracterizacion T2 ON T1.se_no_ficha=T2.no_ficha INNER JOIN alumnos_caracterizacion T3 ON T1.se_no_ficha=T3.se_no_ficha WHERE sa_grupo_gen='061J'";

	$bioquimica2="SELECT * FROM alumnos_datos_personales T1 INNER JOIN semaforos_caracterizacion T2 ON T1.se_no_ficha=T2.no_ficha INNER JOIN alumnos_caracterizacion T3 ON T1.se_no_ficha=T3.se_no_ficha WHERE sa_grupo_gen='061K'";

	$gestion1="SELECT * FROM alumnos_datos_personales T1 INNER JOIN semaforos_caracterizacion T2 ON T1.se_no_ficha=T2.no_ficha INNER JOIN alumnos_caracterizacion T3 ON T1.se_no_ficha=T3.se_no_ficha WHERE sa_grupo_gen='381L'";

	$gestion2="SELECT * FROM alumnos_datos_personales T1 INNER JOIN semaforos_caracterizacion T2 ON T1.se_no_ficha=T2.no_ficha INNER JOIN alumnos_caracterizacion T3 ON T1.se_no_ficha=T3.se_no_ficha WHERE sa_grupo_gen='381M'";

	$industrial1="SELECT * FROM alumnos_datos_personales T1 INNER JOIN semaforos_caracterizacion T2 ON T1.se_no_ficha=T2.no_ficha INNER JOIN alumnos_caracterizacion T3 ON T1.se_no_ficha=T3.se_no_ficha WHERE sa_grupo_gen='161A'";

	$industrial2="SELECT * FROM alumnos_datos_personales T1 INNER JOIN semaforos_caracterizacion T2 ON T1.se_no_ficha=T2.no_ficha INNER JOIN alumnos_caracterizacion T3 ON T1.se_no_ficha=T3.se_no_ficha WHERE sa_grupo_gen='161B'";

	$industrial3="SELECT * FROM alumnos_datos_personales T1 INNER JOIN semaforos_caracterizacion T2 ON T1.se_no_ficha=T2.no_ficha INNER JOIN alumnos_caracterizacion T3 ON T1.se_no_ficha=T3.se_no_ficha WHERE sa_grupo_gen='161E'";

	$meca1="SELECT * FROM alumnos_datos_personales T1 INNER JOIN semaforos_caracterizacion T2 ON T1.se_no_ficha=T2.no_ficha INNER JOIN alumnos_caracterizacion T3 ON T1.se_no_ficha=T3.se_no_ficha WHERE sa_grupo_gen='351G'";

	$meca2="SELECT * FROM alumnos_datos_personales T1 INNER JOIN semaforos_caracterizacion T2 ON T1.se_no_ficha=T2.no_ficha INNER JOIN alumnos_caracterizacion T3 ON T1.se_no_ficha=T3.se_no_ficha WHERE sa_grupo_gen='351H'";

	$nano="SELECT * FROM alumnos_datos_personales T1 INNER JOIN semaforos_caracterizacion T2 ON T1.se_no_ficha=T2.no_ficha INNER JOIN alumnos_caracterizacion T3 ON T1.se_no_ficha=T3.se_no_ficha WHERE sa_grupo_gen='NANO1'";

	$sistemas1="SELECT * FROM alumnos_datos_personales T1 INNER JOIN semaforos_caracterizacion T2 ON T1.se_no_ficha=T2.no_ficha INNER JOIN alumnos_caracterizacion T3 ON T1.se_no_ficha=T3.se_no_ficha WHERE sa_grupo_gen='061C'";

	$sistemas2="SELECT * FROM alumnos_datos_personales T1 INNER JOIN semaforos_caracterizacion T2 ON T1.se_no_ficha=T2.no_ficha INNER JOIN alumnos_caracterizacion T3 ON T1.se_no_ficha=T3.se_no_ficha WHERE sa_grupo_gen='061D'";

	$tics="SELECT * FROM alumnos_datos_personales T1 INNER JOIN semaforos_caracterizacion T2 ON T1.se_no_ficha=T2.no_ficha INNER JOIN alumnos_caracterizacion T3 ON T1.se_no_ficha=T3.se_no_ficha WHERE sa_grupo_gen='TICS1'";
?>