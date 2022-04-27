
use encuestasv1_1;
create table if not exists usuarios(
    id int(255) NOT NULL AUTO_INCREMENT,
    username varchar(250) NOT NULL,
    email varchar(250) NOT NULL,
    password varchar(250) NOT NULL,
    clasificacion varchar(250) NULL,
    fecha_creacion  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
    );
    
create table  if not exists encuestas(
    id int(255)  not null AUTO_INCREMENT ,
    nombre text CHARSET utf8 COLLATE utf8_unicode_ci NOT NULL ,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    habilitada boolean,
    modalidad varchar(255) CHARSET utf8 COLLATE utf8_unicode_ci NOT NULL ,
    PRIMARY KEY (id)
);
create table if not exists instrucciones(
    id int(255)  not null AUTO_INCREMENT,
    contenido text CHARSET utf8 COLLATE utf8_unicode_ci null,
    fecha_creacion  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY(id)
    );
create table if not exists secciones(
    id int(255)  not null AUTO_INCREMENT,		
    id_encuesta int(255)  not null,
    id_instrucciones int(255)   null ,
    nombre text CHARSET utf8 COLLATE utf8_unicode_ci null,
    fecha_creacion  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    habilitada boolean,
    PRIMARY KEY(id),
    FOREIGN  KEY (id_encuesta) REFERENCES encuestas(id),
    FOREIGN  KEY (id_instrucciones) REFERENCES instrucciones(id)

    );
create table if not exists subsecciones(
    id int(255)  not null AUTO_INCREMENT,
    id_seccion int(255)  not null,
    id_instrucciones int(255)   null ,
    nombre text CHARSET utf8 COLLATE utf8_unicode_ci null,
    habilitada boolean,
    fecha_creacion  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY(id),
    FOREIGN  KEY (id_seccion) REFERENCES secciones(id),
    FOREIGN  KEY (id_instrucciones) REFERENCES instrucciones(id)
    );

create table if not exists preguntas(
    id int(255)  not null AUTO_INCREMENT,
    id_subseccion int(255)  not null,
    id_instrucciones int(255),
    habilitada boolean,
    nombre text CHARSET utf8 COLLATE utf8_unicode_ci null,
    fecha_creacion  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    respuesta VARCHAR(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
    PRIMARY KEY(id),
    FOREIGN  KEY (id_subseccion) REFERENCES subsecciones(id),
    FOREIGN  KEY (id_instrucciones) REFERENCES instrucciones(id)
    );
ALTER TABLE `preguntas` ADD `require_respuesta` BOOLEAN NULL AFTER `respuesta`;
ALTER TABLE `preguntas` ADD `otro` BOOLEAN NULL AFTER `require_respuesta`;

ALTER TABLE `preguntas` CHANGE `respuesta` `respuesta` VARCHAR(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL;
ALTER TABLE `preguntas` CHANGE `id_subseccion` `id_subseccion` INT(255) NULL;
create table if not exists opciones(
    id int(255)  not null AUTO_INCREMENT,	
    id_pregunta int(255)  not null,
    habilitada boolean,
    nombre text CHARSET utf8 COLLATE utf8_unicode_ci null,
    fecha_creacion  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY(id),
    FOREIGN  KEY (id_pregunta) REFERENCES preguntas(id)
    );

create table if not exists atributos_respuesta_abierta(
    id int(255)  not null AUTO_INCREMENT,	
    id_pregunta int(255)  not null,
    habilitada boolean,
    placeholder text CHARSET utf8 COLLATE utf8_unicode_ci null,
    min_caracteres int(30)  null,	
    max_caracteres int(30)  null,		
    fecha_creacion  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY(id),
    FOREIGN  KEY (id_pregunta) REFERENCES preguntas(id)
    );
create table if not exists atributos_respuesta_cerrada(
    id int(255)  not null AUTO_INCREMENT,	
    id_pregunta int(255)  not null,
    habilitada boolean,
    min_caracteres int(30)  null,	
    max_caracteres int(30)  null,		
    fecha_creacion  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY(id),
    FOREIGN  KEY (id_pregunta) REFERENCES preguntas(id)
    );

create table if not exists otro(
    id int(255)  not null AUTO_INCREMENT,
    id_pregunta int(255)  null,
    PRIMARY key (id),
    placeholder varchar(255) CHARSET utf8 COLLATE utf8_unicode_ci null,
    fecha_creacion  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN key (id_pregunta) REFERENCES preguntas(id)
);


INSERT INTO `usuarios` (`id`, `username`, `email`, `password`, `clasificacion`, `fecha_creacion`) VALUES (NULL,"", 
        MD5('00000')
        , MD5('00000'), NULL, CURRENT_TIMESTAMP);
ALTER TABLE preguntas ADD COLUMN id_pregunta int(255)  null;
ALTER TABLE preguntas ADD FOREIGN KEY (id_pregunta) REFERENCES preguntas(id);

create table if not exists reglas(
    id int(255)  not null AUTO_INCREMENT,   
    id_opcion int(255)   null,
    id_pregunta_afectada int(255)   null,
    id_subseccion_afectada int(255)   null,
    id_seccion_afectada int(255)   null,
    FOREIGN  KEY (id_opcion) REFERENCES opciones(id),
    FOREIGN  KEY (id_pregunta_afectada) REFERENCES preguntas(id),
    FOREIGN  KEY (id_subseccion_afectada) REFERENCES subsecciones(id),
    FOREIGN  KEY (id_seccion_afectada) REFERENCES secciones(id),
    PRIMARY KEY(id),
    fecha_creacion  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    
    );
ALTER TABLE opciones ADD COLUMN id_regla int(255)  null;

ALTER TABLE opciones ADD FOREIGN KEY (id_regla) REFERENCES reglas(id);
create table if not exists resultados(
    id int(255)  not null AUTO_INCREMENT,
    PRIMARY key (id),
    folio varchar(255) CHARSET utf8 COLLATE utf8_unicode_ci null,
    fecha_creacion  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
ALTER TABLE `resultados` ADD `id_encuesta` INT(255)  NULL AFTER `folio`;

/*Actualizacion 1.1
Problematica con las llaves foraneas ... al eliminar en cascada
*/ 
/*ALTER TABLE reglas DROP INDEX id_seccion_afectada;
ALTER TABLE reglas DROP INDEX id_pregunta_afectada;
ALTER TABLE reglas DROP INDEX id_subseccion_afectada;*/

ALTER TABLE `usuarios` ADD `a_pat` VARCHAR(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL AFTER `username`, ADD `a_mat` VARCHAR(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER `a_pat`, ADD `depoAr` VARCHAR(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL AFTER `a_mat`;
ALTER TABLE `encuestas` ADD `id_usuario` INT(255) NULL AFTER `modalidad`;
UPDATE `usuarios` SET `email` = 'admin' WHERE `usuarios`.`id` = 1;
ALTER TABLE `usuarios` ADD `restaurar_contrasena` VARCHAR(255) NOT NULL AFTER `fecha_creacion`;
/*ALTER TABLE `usuarios` CHANGE `restaurar_contraseña` `restaurar_contrasena` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL;*/
UPDATE `usuarios` SET `email` = md5('Admin'), `password` =md5('admin'),`clasificacion`='A' WHERE `usuarios`.`id` = 1
