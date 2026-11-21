/*
 Navicat Premium Data Transfer

 Source Server         : MySql(Local)
 Source Server Type    : MySQL
 Source Server Version : 50724
 Source Host           : localhost:3306
 Source Schema         : sit

 Target Server Type    : MySQL
 Target Server Version : 50724
 File Encoding         : 65001

 Date: 20/11/2026 17:42:17
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for actos_titulacion
-- ----------------------------
DROP TABLE IF EXISTS `actos_titulacion`;
CREATE TABLE `actos_titulacion`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `solicitud_titulacion_id` bigint(20) UNSIGNED NOT NULL,
  `jurado_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `tipo_acto` enum('examen_profesional','defensa_tesis','examen_cenaval','presentacion_informe','protocolo_ceremonia') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_acto` date NULL DEFAULT NULL,
  `hora_acto` time(0) NULL DEFAULT NULL,
  `lugar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `modalidad` enum('presencial','virtual','hibrida') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'presencial',
  `url_virtual` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'Enlace para actos virtuales',
  `estatus` enum('programado','en_curso','realizado','suspendido','cancelado') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'programado',
  `observaciones` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `participantes` json NULL COMMENT 'JSON con participantes adicionales',
  `resultado_acto` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `calificacion_final` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `dictamen` enum('aprobado','no_aprobado','pendiente') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `fecha_dictamen` date NULL DEFAULT NULL,
  `acta_numero` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `fecha_acta` date NULL DEFAULT NULL,
  `observaciones_acta` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `creado_por` bigint(20) UNSIGNED NOT NULL,
  `actualizado_por` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `actos_titulacion_jurado_id_foreign`(`jurado_id`) USING BTREE,
  INDEX `actos_titulacion_creado_por_foreign`(`creado_por`) USING BTREE,
  INDEX `actos_titulacion_actualizado_por_foreign`(`actualizado_por`) USING BTREE,
  INDEX `actos_titulacion_solicitud_titulacion_id_index`(`solicitud_titulacion_id`) USING BTREE,
  INDEX `actos_titulacion_tipo_acto_index`(`tipo_acto`) USING BTREE,
  INDEX `actos_titulacion_estatus_index`(`estatus`) USING BTREE,
  INDEX `actos_titulacion_fecha_acto_index`(`fecha_acto`) USING BTREE,
  INDEX `actos_titulacion_dictamen_index`(`dictamen`) USING BTREE,
  CONSTRAINT `actos_titulacion_actualizado_por_foreign` FOREIGN KEY (`actualizado_por`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `actos_titulacion_creado_por_foreign` FOREIGN KEY (`creado_por`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `actos_titulacion_jurado_id_foreign` FOREIGN KEY (`jurado_id`) REFERENCES `jurados_titulacion` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `actos_titulacion_solicitud_titulacion_id_foreign` FOREIGN KEY (`solicitud_titulacion_id`) REFERENCES `solicitudes_titulacion` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for adeudo_alumnos
-- ----------------------------
DROP TABLE IF EXISTS `adeudo_alumnos`;
CREATE TABLE `adeudo_alumnos`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `alumno_id` bigint(20) UNSIGNED NOT NULL,
  `tipo_adeudo` enum('Financiero','Biblioteca','Material','Laboratorio','Otro') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `concepto` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `monto` decimal(10, 2) NULL DEFAULT NULL,
  `fecha_registro` date NOT NULL,
  `fecha_limite` date NULL DEFAULT NULL,
  `periodo_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `saldado` tinyint(1) NOT NULL DEFAULT 0,
  `fecha_pago` date NULL DEFAULT NULL,
  `folio_pago` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `observaciones` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `concepto_cache_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `recibo_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `origen` enum('automatico','manual','sistema') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'manual',
  `bloquea_inscripcion` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `adeudo_alumnos_concepto_cache_id_foreign`(`concepto_cache_id`) USING BTREE,
  INDEX `adeudo_alumnos_recibo_id_foreign`(`recibo_id`) USING BTREE,
  INDEX `adeudo_alumnos_alumno_id_index`(`alumno_id`) USING BTREE,
  INDEX `adeudo_alumnos_tipo_adeudo_index`(`tipo_adeudo`) USING BTREE,
  INDEX `adeudo_alumnos_saldado_index`(`saldado`) USING BTREE,
  INDEX `adeudo_alumnos_periodo_id_index`(`periodo_id`) USING BTREE,
  INDEX `adeudo_alumnos_fecha_registro_index`(`fecha_registro`) USING BTREE,
  INDEX `adeudo_alumnos_origen_index`(`origen`) USING BTREE,
  INDEX `adeudo_alumnos_bloquea_inscripcion_index`(`bloquea_inscripcion`) USING BTREE,
  CONSTRAINT `adeudo_alumnos_alumno_id_foreign` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `adeudo_alumnos_concepto_cache_id_foreign` FOREIGN KEY (`concepto_cache_id`) REFERENCES `cat_conceptos_cache` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `adeudo_alumnos_periodo_id_foreign` FOREIGN KEY (`periodo_id`) REFERENCES `cat_periodos_escolares` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `adeudo_alumnos_recibo_id_foreign` FOREIGN KEY (`recibo_id`) REFERENCES `recibos` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for administracion_parametros
-- ----------------------------
DROP TABLE IF EXISTS `administracion_parametros`;
CREATE TABLE `administracion_parametros`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `clave` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor_entero` int(10) UNSIGNED NULL DEFAULT NULL,
  `valor_texto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `valor_booleano` tinyint(1) NULL DEFAULT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `administracion_parametros_clave_unique`(`clave`) USING BTREE,
  INDEX `administracion_parametros_clave_index`(`clave`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for alumno_complementos
-- ----------------------------
DROP TABLE IF EXISTS `alumno_complementos`;
CREATE TABLE `alumno_complementos`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `alumno_id` bigint(20) UNSIGNED NOT NULL,
  `email_personal` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `direccion` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `colonia` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `cp` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `ciudad` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `estado_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `municipio_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `nombre_padre` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `telefono_padre` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `ocupacion_padre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nombre_madre` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `telefono_madre` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `ocupacion_madre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nombre_tutor` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `telefono_tutor` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `parentesco_tutor` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `vive_con` enum('Ambos padres','Solo padre','Solo madre','Tutor','Solo','Otro') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `vivienda` enum('Propia','Rentada','Prestada','Familiar') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `personas_dependientes` int(11) NULL DEFAULT NULL,
  `ingreso_familiar_mensual` decimal(10, 2) NULL DEFAULT NULL,
  `trabaja_actualmente` tinyint(1) NOT NULL DEFAULT 0,
  `ingreso_propio_mensual` decimal(10, 2) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `alumno_complementos_alumno_id_unique`(`alumno_id`) USING BTREE,
  INDEX `alumno_complementos_estado_id_foreign`(`estado_id`) USING BTREE,
  INDEX `alumno_complementos_municipio_id_foreign`(`municipio_id`) USING BTREE,
  CONSTRAINT `alumno_complementos_alumno_id_foreign` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `alumno_complementos_estado_id_foreign` FOREIGN KEY (`estado_id`) REFERENCES `cat_estados` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `alumno_complementos_municipio_id_foreign` FOREIGN KEY (`municipio_id`) REFERENCES `cat_municipios` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 11301 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for alumno_convalidaciones_perfil
-- ----------------------------
DROP TABLE IF EXISTS `alumno_convalidaciones_perfil`;
CREATE TABLE `alumno_convalidaciones_perfil`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `alumno_id` bigint(20) UNSIGNED NOT NULL,
  `periodo_id` bigint(20) UNSIGNED NOT NULL,
  `plan_estudio_base_id` bigint(20) UNSIGNED NOT NULL,
  `materia_base_id` bigint(20) UNSIGNED NOT NULL,
  `plan_estudio_origen_id` bigint(20) UNSIGNED NOT NULL,
  `materia_origen_id` bigint(20) UNSIGNED NOT NULL,
  `motivo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `autorizada_por_user_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uq_convalidacion_perfil_por_periodo`(`alumno_id`, `periodo_id`, `materia_base_id`) USING BTREE,
  INDEX `alumno_convalidaciones_perfil_periodo_id_foreign`(`periodo_id`) USING BTREE,
  INDEX `alumno_convalidaciones_perfil_plan_estudio_base_id_foreign`(`plan_estudio_base_id`) USING BTREE,
  INDEX `alumno_convalidaciones_perfil_materia_base_id_foreign`(`materia_base_id`) USING BTREE,
  INDEX `alumno_convalidaciones_perfil_plan_estudio_origen_id_foreign`(`plan_estudio_origen_id`) USING BTREE,
  INDEX `alumno_convalidaciones_perfil_autorizada_por_user_id_foreign`(`autorizada_por_user_id`) USING BTREE,
  INDEX `alumno_convalidaciones_perfil_alumno_id_periodo_id_index`(`alumno_id`, `periodo_id`) USING BTREE,
  INDEX `alumno_convalidaciones_perfil_materia_origen_id_index`(`materia_origen_id`) USING BTREE,
  CONSTRAINT `alumno_convalidaciones_perfil_alumno_id_foreign` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `alumno_convalidaciones_perfil_autorizada_por_user_id_foreign` FOREIGN KEY (`autorizada_por_user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `alumno_convalidaciones_perfil_materia_base_id_foreign` FOREIGN KEY (`materia_base_id`) REFERENCES `cat_materias` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `alumno_convalidaciones_perfil_materia_origen_id_foreign` FOREIGN KEY (`materia_origen_id`) REFERENCES `cat_materias` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `alumno_convalidaciones_perfil_periodo_id_foreign` FOREIGN KEY (`periodo_id`) REFERENCES `cat_periodos_escolares` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `alumno_convalidaciones_perfil_plan_estudio_base_id_foreign` FOREIGN KEY (`plan_estudio_base_id`) REFERENCES `cat_plan_estudios` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `alumno_convalidaciones_perfil_plan_estudio_origen_id_foreign` FOREIGN KEY (`plan_estudio_origen_id`) REFERENCES `cat_plan_estudios` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for alumno_datos_medicos
-- ----------------------------
DROP TABLE IF EXISTS `alumno_datos_medicos`;
CREATE TABLE `alumno_datos_medicos`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `alumno_id` bigint(20) UNSIGNED NOT NULL,
  `tipo_sangre` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nss` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `seguro_medico` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `alergias` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `enfermedades_cronicas` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `medicamentos_controlados` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `discapacidad` tinyint(1) NOT NULL DEFAULT 0,
  `atencion_especial` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `contacto_emergencia_nombre` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `contacto_emergencia_telefono` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `contacto_emergencia_parentesco` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `alumno_datos_medicos_alumno_id_unique`(`alumno_id`) USING BTREE,
  CONSTRAINT `alumno_datos_medicos_alumno_id_foreign` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 11301 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for alumno_discapacidades
-- ----------------------------
DROP TABLE IF EXISTS `alumno_discapacidades`;
CREATE TABLE `alumno_discapacidades`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `alumno_id` bigint(20) UNSIGNED NOT NULL,
  `discapacidad_id` bigint(20) UNSIGNED NOT NULL,
  `observaciones` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `alumno_discapacidad_unique`(`alumno_id`, `discapacidad_id`) USING BTREE,
  INDEX `alumno_discapacidades_discapacidad_id_foreign`(`discapacidad_id`) USING BTREE,
  CONSTRAINT `alumno_discapacidades_alumno_id_foreign` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `alumno_discapacidades_discapacidad_id_foreign` FOREIGN KEY (`discapacidad_id`) REFERENCES `discapacidades` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 112 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for alumno_documentos
-- ----------------------------
DROP TABLE IF EXISTS `alumno_documentos`;
CREATE TABLE `alumno_documentos`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `alumno_id` bigint(20) UNSIGNED NOT NULL,
  `tipo_documento` enum('Certificado_bachillerato','Acta_nacimiento','CURP','Certificado_medico','Fotografia','NSS_documento','Solicitud_inscripcion','Consentimiento_datos','Otro') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `entrega_fisica` tinyint(1) NULL DEFAULT NULL,
  `numero_documento` int(11) NULL DEFAULT NULL,
  `nombre_archivo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `ruta_archivo` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tamaño` int(11) NULL DEFAULT NULL,
  `mime_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `fecha_subida` date NOT NULL,
  `vigente` tinyint(1) NOT NULL DEFAULT 1,
  `observaciones` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `alumno_documentos_alumno_id_index`(`alumno_id`) USING BTREE,
  INDEX `alumno_documentos_tipo_documento_index`(`tipo_documento`) USING BTREE,
  CONSTRAINT `alumno_documentos_alumno_id_foreign` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 83605 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for alumno_especialidad
-- ----------------------------
DROP TABLE IF EXISTS `alumno_especialidad`;
CREATE TABLE `alumno_especialidad`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `alumno_id` bigint(20) UNSIGNED NOT NULL,
  `especialidad_id` bigint(20) UNSIGNED NOT NULL,
  `fecha_eleccion` date NULL DEFAULT NULL,
  `estatus` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `cambios_especialidad` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `alumno_especialidad_alumno_id_unique`(`alumno_id`) USING BTREE,
  INDEX `alumno_especialidad_especialidad_id_index`(`especialidad_id`) USING BTREE,
  INDEX `alumno_especialidad_estatus_index`(`estatus`) USING BTREE,
  CONSTRAINT `alumno_especialidad_alumno_id_foreign` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `alumno_especialidad_especialidad_id_foreign` FOREIGN KEY (`especialidad_id`) REFERENCES `cat_especialidades` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 9670 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for alumnos
-- ----------------------------
DROP TABLE IF EXISTS `alumnos`;
CREATE TABLE `alumnos`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `no_control` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `curp` varchar(18) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `fecha_nacimiento` date NOT NULL,
  `estado_nacimiento_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `genero` enum('M','F','OTRO') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_institucional` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nacionalidad` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Mexicana',
  `carrera_id` bigint(20) UNSIGNED NOT NULL,
  `plan_estudio_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `periodo_ingreso_id` bigint(20) UNSIGNED NOT NULL,
  `anio_ingreso` year NOT NULL,
  `estatus` enum('Regular','Irregular','Baja temporal','Baja definitiva','Egresado','Titulado') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `semestre_actual` int(11) NULL DEFAULT NULL,
  `inscrito` tinyint(1) NOT NULL DEFAULT 0,
  `pertenencia_etnica` enum('Indígena','Afrodescendiente','Otra','Ninguna') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `lugar_procedencia_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `escuela_procedencia_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `promedio_bachillerato` decimal(5, 2) NULL DEFAULT NULL,
  `especialidad_bachillerato` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `anio_egreso_bachillerato` year NULL DEFAULT NULL,
  `calificacion_examen_diagnostico` decimal(5, 2) NULL DEFAULT NULL,
  `beca_ingreso` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `beca_actual` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `folio_certificado_profesional` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `fecha_certificado_profesional` date NULL DEFAULT NULL,
  `cedula_profesional` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `fecha_titulacion` date NULL DEFAULT NULL,
  `modalidad_titulacion` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `bloqueado_adeudos` tinyint(1) NOT NULL DEFAULT 0,
  `observaciones` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `alumnos_user_id_unique`(`user_id`) USING BTREE,
  UNIQUE INDEX `alumnos_no_control_unique`(`no_control`) USING BTREE,
  UNIQUE INDEX `alumnos_email_institucional_unique`(`email_institucional`) USING BTREE,
  INDEX `alumnos_estado_nacimiento_id_foreign`(`estado_nacimiento_id`) USING BTREE,
  INDEX `alumnos_periodo_ingreso_id_foreign`(`periodo_ingreso_id`) USING BTREE,
  INDEX `alumnos_lugar_procedencia_id_foreign`(`lugar_procedencia_id`) USING BTREE,
  INDEX `alumnos_escuela_procedencia_id_foreign`(`escuela_procedencia_id`) USING BTREE,
  INDEX `alumnos_carrera_id_index`(`carrera_id`) USING BTREE,
  INDEX `alumnos_plan_estudio_id_index`(`plan_estudio_id`) USING BTREE,
  INDEX `alumnos_estatus_index`(`estatus`) USING BTREE,
  INDEX `alumnos_semestre_actual_index`(`semestre_actual`) USING BTREE,
  INDEX `alumnos_inscrito_index`(`inscrito`) USING BTREE,
  INDEX `alumnos_anio_ingreso_id_idx`(`anio_ingreso`, `id`) USING BTREE,
  CONSTRAINT `alumnos_carrera_id_foreign` FOREIGN KEY (`carrera_id`) REFERENCES `cat_carreras` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `alumnos_escuela_procedencia_id_foreign` FOREIGN KEY (`escuela_procedencia_id`) REFERENCES `cat_escuelas_procedencia` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `alumnos_estado_nacimiento_id_foreign` FOREIGN KEY (`estado_nacimiento_id`) REFERENCES `cat_estados` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `alumnos_lugar_procedencia_id_foreign` FOREIGN KEY (`lugar_procedencia_id`) REFERENCES `cat_municipios` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `alumnos_periodo_ingreso_id_foreign` FOREIGN KEY (`periodo_ingreso_id`) REFERENCES `cat_periodos_escolares` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `alumnos_plan_estudio_id_foreign` FOREIGN KEY (`plan_estudio_id`) REFERENCES `cat_plan_estudios` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `alumnos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 11301 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for aulas
-- ----------------------------
DROP TABLE IF EXISTS `aulas`;
CREATE TABLE `aulas`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `clave_aula` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `edificio` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `capacidad` int(11) NULL DEFAULT NULL,
  `tipo` enum('Aula','Laboratorio','Taller','Auditorio','Sala de cómputo','Otro') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `equipamiento` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `disponible` tinyint(1) NOT NULL DEFAULT 1,
  `es_sala_titulacion` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `aulas_clave_aula_unique`(`clave_aula`) USING BTREE,
  INDEX `aulas_edificio_index`(`edificio`) USING BTREE,
  INDEX `aulas_tipo_index`(`tipo`) USING BTREE,
  INDEX `aulas_disponible_index`(`disponible`) USING BTREE,
  INDEX `aulas_es_sala_titulacion_index`(`es_sala_titulacion`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 154 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for aviso_user
-- ----------------------------
DROP TABLE IF EXISTS `aviso_user`;
CREATE TABLE `aviso_user`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `aviso_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `leido` tinyint(1) NOT NULL DEFAULT 0,
  `leido_en` timestamp(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `aviso_user_aviso_id_user_id_unique`(`aviso_id`, `user_id`) USING BTREE,
  INDEX `aviso_user_user_id_leido_index`(`user_id`, `leido`) USING BTREE,
  CONSTRAINT `aviso_user_aviso_id_foreign` FOREIGN KEY (`aviso_id`) REFERENCES `avisos` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `aviso_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for avisos
-- ----------------------------
DROP TABLE IF EXISTS `avisos`;
CREATE TABLE `avisos`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `titulo` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mensaje` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `destinatario` enum('personal','alumnos','general','usuario') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'general',
  `usuario_objetivo_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `publicado_en` timestamp(0) NULL DEFAULT NULL,
  `expira_en` timestamp(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `avisos_destinatario_activo_index`(`destinatario`, `activo`) USING BTREE,
  INDEX `avisos_usuario_objetivo_id_index`(`usuario_objetivo_id`) USING BTREE,
  INDEX `avisos_publicado_en_index`(`publicado_en`) USING BTREE,
  INDEX `avisos_created_by_foreign`(`created_by`) USING BTREE,
  CONSTRAINT `avisos_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `avisos_usuario_objetivo_id_foreign` FOREIGN KEY (`usuario_objetivo_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for baja_alumnos
-- ----------------------------
DROP TABLE IF EXISTS `baja_alumnos`;
CREATE TABLE `baja_alumnos`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `alumno_id` bigint(20) UNSIGNED NOT NULL,
  `tipo_baja` enum('Temporal','Definitiva','Egreso','Baja por bajo rendimiento','Baja por adeudo','Baja voluntaria','Otro') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `motivo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `fecha_baja` date NOT NULL,
  `periodo_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `autorizo_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `observaciones` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `estatus` enum('solicitada','autorizada','rechazada') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'solicitada',
  `fecha_autorizacion` timestamp(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `baja_alumnos_autorizo_id_foreign`(`autorizo_id`) USING BTREE,
  INDEX `baja_alumnos_estatus_index`(`estatus`) USING BTREE,
  INDEX `baja_alumnos_alumno_id_estatus_index`(`alumno_id`, `estatus`) USING BTREE,
  INDEX `baja_alumnos_alumno_id_index`(`alumno_id`) USING BTREE,
  INDEX `baja_alumnos_tipo_baja_index`(`tipo_baja`) USING BTREE,
  INDEX `baja_alumnos_fecha_baja_index`(`fecha_baja`) USING BTREE,
  INDEX `baja_alumnos_periodo_id_index`(`periodo_id`) USING BTREE,
  CONSTRAINT `baja_alumnos_alumno_id_foreign` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `baja_alumnos_autorizo_id_foreign` FOREIGN KEY (`autorizo_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `baja_alumnos_periodo_id_foreign` FOREIGN KEY (`periodo_id`) REFERENCES `cat_periodos_escolares` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 9639 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for cache
-- ----------------------------
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache`  (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`) USING BTREE,
  INDEX `cache_expiration_index`(`expiration`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for cache_locks
-- ----------------------------
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks`  (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`) USING BTREE,
  INDEX `cache_locks_expiration_index`(`expiration`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for candidato_documentos
-- ----------------------------
DROP TABLE IF EXISTS `candidato_documentos`;
CREATE TABLE `candidato_documentos`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `candidato_id` bigint(20) UNSIGNED NOT NULL,
  `tipo_documento` enum('Fotografia','CURP','Certificado_parcial','Certificado_total','Constancia_estudios','Acta_nacimiento','Comprobante_pago','Folio_pago','Identificacion_oficial','Comprobante_domicilio','Otro') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_archivo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ruta_archivo` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tamaño` int(11) NULL DEFAULT NULL,
  `mime_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `folio_pago` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `fecha_subida` date NOT NULL,
  `validado` tinyint(1) NOT NULL DEFAULT 0,
  `fecha_validacion` date NULL DEFAULT NULL,
  `validado_por` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `vigente` tinyint(1) NOT NULL DEFAULT 1,
  `observaciones` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `candidato_doc_vigente_unique`(`candidato_id`, `tipo_documento`, `vigente`) USING BTREE,
  INDEX `candidato_documentos_validado_por_foreign`(`validado_por`) USING BTREE,
  INDEX `candidato_documentos_candidato_id_index`(`candidato_id`) USING BTREE,
  INDEX `candidato_documentos_tipo_documento_index`(`tipo_documento`) USING BTREE,
  INDEX `candidato_documentos_validado_index`(`validado`) USING BTREE,
  INDEX `candidato_documentos_vigente_index`(`vigente`) USING BTREE,
  CONSTRAINT `candidato_documentos_candidato_id_foreign` FOREIGN KEY (`candidato_id`) REFERENCES `candidatos` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `candidato_documentos_validado_por_foreign` FOREIGN KEY (`validado_por`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for candidatos
-- ----------------------------
DROP TABLE IF EXISTS `candidatos`;
CREATE TABLE `candidatos`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `curp` varchar(18) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `apellido_paterno` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `apellido_materno` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `fecha_nacimiento` date NULL DEFAULT NULL,
  `genero` enum('M','F','OTRO') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `celular` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `carrera_solicitada_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `carrera_solicitada_opcion_2_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `periodo_solicitado_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `escuela_procedencia_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `bachillerato` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `municipio_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `estado_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `calle` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `numero` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `colonia` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `codigo_postal` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `promedio_bachillerato` decimal(5, 2) NULL DEFAULT NULL,
  `anio_egreso` int(10) UNSIGNED NULL DEFAULT NULL,
  `calificacion_examen_diagnostico` decimal(5, 2) NULL DEFAULT NULL,
  `token_verificacion` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `token_expiracion` datetime(0) NULL DEFAULT NULL,
  `email_verificado` tinyint(1) NOT NULL DEFAULT 0,
  `estatus` enum('Registrado','Documentación pendiente','Documentación completa','En revisión','Aceptado','Inscrito','pendiente_verificacion','pendiente_solicitud','solicitud_enviada','pendiente','en_revision','validado','rechazado') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Registrado',
  `observaciones` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `documentos_validados` tinyint(1) NOT NULL DEFAULT 0,
  `fecha_validacion` datetime(0) NULL DEFAULT NULL,
  `validado_por` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `fecha_registro` datetime(0) NULL DEFAULT NULL,
  `folio_ficha` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `candidatos_curp_unique`(`curp`) USING BTREE,
  UNIQUE INDEX `candidatos_email_unique`(`email`) USING BTREE,
  INDEX `candidatos_user_id_foreign`(`user_id`) USING BTREE,
  INDEX `candidatos_escuela_procedencia_id_foreign`(`escuela_procedencia_id`) USING BTREE,
  INDEX `candidatos_validado_por_foreign`(`validado_por`) USING BTREE,
  INDEX `candidatos_apellido_paterno_apellido_materno_nombre_index`(`apellido_paterno`, `apellido_materno`, `nombre`) USING BTREE,
  INDEX `candidatos_carrera_solicitada_id_index`(`carrera_solicitada_id`) USING BTREE,
  INDEX `candidatos_carrera_solicitada_opcion_2_id_index`(`carrera_solicitada_opcion_2_id`) USING BTREE,
  INDEX `candidatos_periodo_solicitado_id_index`(`periodo_solicitado_id`) USING BTREE,
  INDEX `candidatos_municipio_id_index`(`municipio_id`) USING BTREE,
  INDEX `candidatos_estado_id_index`(`estado_id`) USING BTREE,
  INDEX `candidatos_estatus_index`(`estatus`) USING BTREE,
  INDEX `candidatos_fecha_registro_index`(`fecha_registro`) USING BTREE,
  INDEX `candidatos_email_verificado_index`(`email_verificado`) USING BTREE,
  INDEX `candidatos_documentos_validados_index`(`documentos_validados`) USING BTREE,
  CONSTRAINT `candidatos_carrera_solicitada_id_foreign` FOREIGN KEY (`carrera_solicitada_id`) REFERENCES `cat_carreras` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `candidatos_carrera_solicitada_opcion_2_id_foreign` FOREIGN KEY (`carrera_solicitada_opcion_2_id`) REFERENCES `cat_carreras` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `candidatos_escuela_procedencia_id_foreign` FOREIGN KEY (`escuela_procedencia_id`) REFERENCES `cat_escuelas_procedencia` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `candidatos_estado_id_foreign` FOREIGN KEY (`estado_id`) REFERENCES `cat_estados` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `candidatos_municipio_id_foreign` FOREIGN KEY (`municipio_id`) REFERENCES `cat_municipios` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `candidatos_periodo_solicitado_id_foreign` FOREIGN KEY (`periodo_solicitado_id`) REFERENCES `cat_periodos_escolares` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `candidatos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `candidatos_validado_por_foreign` FOREIGN KEY (`validado_por`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for cat_areas_conocimiento
-- ----------------------------
DROP TABLE IF EXISTS `cat_areas_conocimiento`;
CREATE TABLE `cat_areas_conocimiento`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `clave` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `cat_areas_conocimiento_clave_unique`(`clave`) USING BTREE,
  UNIQUE INDEX `cat_areas_conocimiento_nombre_unique`(`nombre`) USING BTREE,
  INDEX `cat_areas_conocimiento_nombre_index`(`nombre`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for cat_carreras
-- ----------------------------
DROP TABLE IF EXISTS `cat_carreras`;
CREATE TABLE `cat_carreras`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `clave` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_corto` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nivel` enum('Licenciatura','Maestría','Doctorado') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `modalidad` enum('Escolarizado','Mixto','En línea') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `letra_control` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `coordinador_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NULL DEFAULT NULL,
  `creditos_totales` int(11) NOT NULL,
  `duracion_semestres` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `cat_carreras_clave_unique`(`clave`) USING BTREE,
  INDEX `cat_carreras_coordinador_id_index`(`coordinador_id`) USING BTREE,
  INDEX `cat_carreras_activo_index`(`activo`) USING BTREE,
  CONSTRAINT `cat_carreras_coordinador_id_foreign` FOREIGN KEY (`coordinador_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for cat_conceptos_cache
-- ----------------------------
DROP TABLE IF EXISTS `cat_conceptos_cache`;
CREATE TABLE `cat_conceptos_cache`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `concepto_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `clave` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `monto` decimal(10, 2) NOT NULL,
  `tipo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `ultima_sincronizacion` timestamp(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `cat_conceptos_cache_concepto_id_unique`(`concepto_id`) USING BTREE,
  INDEX `cat_conceptos_cache_clave_index`(`clave`) USING BTREE,
  INDEX `cat_conceptos_cache_activo_index`(`activo`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for cat_departamentos_academicos
-- ----------------------------
DROP TABLE IF EXISTS `cat_departamentos_academicos`;
CREATE TABLE `cat_departamentos_academicos`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `clave` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `carrera_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `es_transversal` tinyint(1) NOT NULL DEFAULT 0,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `cat_departamentos_academicos_clave_unique`(`clave`) USING BTREE,
  UNIQUE INDEX `cat_departamentos_academicos_nombre_unique`(`nombre`) USING BTREE,
  INDEX `cat_departamentos_academicos_carrera_id_index`(`carrera_id`) USING BTREE,
  INDEX `cat_departamentos_academicos_es_transversal_index`(`es_transversal`) USING BTREE,
  INDEX `cat_departamentos_academicos_activo_index`(`activo`) USING BTREE,
  CONSTRAINT `cat_departamentos_academicos_carrera_id_foreign` FOREIGN KEY (`carrera_id`) REFERENCES `cat_carreras` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 45 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for cat_escuelas_procedencia
-- ----------------------------
DROP TABLE IF EXISTS `cat_escuelas_procedencia`;
CREATE TABLE `cat_escuelas_procedencia`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `clave` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `municipio_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `sistema` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tipo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `direccion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `telefono` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `cat_escuelas_procedencia_clave_unique`(`clave`) USING BTREE,
  INDEX `cat_escuelas_procedencia_municipio_id_sistema_index`(`municipio_id`, `sistema`) USING BTREE,
  INDEX `cat_escuelas_procedencia_nombre_index`(`nombre`) USING BTREE,
  INDEX `cat_escuelas_procedencia_sistema_index`(`sistema`) USING BTREE,
  CONSTRAINT `cat_escuelas_procedencia_municipio_id_foreign` FOREIGN KEY (`municipio_id`) REFERENCES `cat_municipios` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 12378 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for cat_especialidades
-- ----------------------------
DROP TABLE IF EXISTS `cat_especialidades`;
CREATE TABLE `cat_especialidades`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `carrera_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `plan_estudio_id` bigint(20) UNSIGNED NOT NULL,
  `clave` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_corto` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `fecha_inicio` date NULL DEFAULT NULL,
  `fecha_fin` date NULL DEFAULT NULL,
  `creditos_requeridos` int(11) NULL DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `cat_especialidades_carrera_id_foreign`(`carrera_id`) USING BTREE,
  INDEX `cat_especialidades_plan_estudio_id_index`(`plan_estudio_id`) USING BTREE,
  INDEX `cat_especialidades_activo_index`(`activo`) USING BTREE,
  INDEX `cat_especialidades_fecha_inicio_index`(`fecha_inicio`) USING BTREE,
  INDEX `cat_especialidades_fecha_fin_index`(`fecha_fin`) USING BTREE,
  CONSTRAINT `cat_especialidades_carrera_id_foreign` FOREIGN KEY (`carrera_id`) REFERENCES `cat_carreras` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `cat_especialidades_plan_estudio_id_foreign` FOREIGN KEY (`plan_estudio_id`) REFERENCES `cat_plan_estudios` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 55 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for cat_estados
-- ----------------------------
DROP TABLE IF EXISTS `cat_estados`;
CREATE TABLE `cat_estados`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `clave` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abreviatura` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `cat_estados_clave_unique`(`clave`) USING BTREE,
  UNIQUE INDEX `cat_estados_nombre_unique`(`nombre`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 33 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for cat_materias
-- ----------------------------
DROP TABLE IF EXISTS `cat_materias`;
CREATE TABLE `cat_materias`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `clave` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_corto` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `ambito` enum('tronco_comun','perfil','especialidad') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'perfil',
  `materia_ligada_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `materia_ligada2_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `materia_ligada3_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `area_conocimiento_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `departamento_responsable_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `creditos` int(11) NOT NULL,
  `horas_teoria` int(11) NULL DEFAULT NULL,
  `horas_practica` int(11) NULL DEFAULT NULL,
  `tipo` enum('Obligatoria','Optativa','Complementaria') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_evaluacion` enum('numerica','desempeno') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'numerica',
  `concepto` enum('servicio_social','actividades_complementarias') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `num_temas` int(10) UNSIGNED NULL DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `profesor_asignado_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `cat_materias_clave_unique`(`clave`) USING BTREE,
  INDEX `cat_materias_materia_ligada2_id_foreign`(`materia_ligada2_id`) USING BTREE,
  INDEX `cat_materias_materia_ligada3_id_foreign`(`materia_ligada3_id`) USING BTREE,
  INDEX `cat_materias_profesor_asignado_id_foreign`(`profesor_asignado_id`) USING BTREE,
  INDEX `cat_materias_ambito_index`(`ambito`) USING BTREE,
  INDEX `cat_materias_materia_ligada_id_index`(`materia_ligada_id`) USING BTREE,
  INDEX `cat_materias_area_conocimiento_id_index`(`area_conocimiento_id`) USING BTREE,
  INDEX `cat_materias_departamento_responsable_id_index`(`departamento_responsable_id`) USING BTREE,
  INDEX `cat_materias_tipo_index`(`tipo`) USING BTREE,
  INDEX `cat_materias_tipo_evaluacion_index`(`tipo_evaluacion`) USING BTREE,
  INDEX `cat_materias_concepto_index`(`concepto`) USING BTREE,
  CONSTRAINT `cat_materias_area_conocimiento_id_foreign` FOREIGN KEY (`area_conocimiento_id`) REFERENCES `cat_areas_conocimiento` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `cat_materias_departamento_responsable_id_foreign` FOREIGN KEY (`departamento_responsable_id`) REFERENCES `cat_departamentos_academicos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `cat_materias_materia_ligada2_id_foreign` FOREIGN KEY (`materia_ligada2_id`) REFERENCES `cat_materias` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `cat_materias_materia_ligada3_id_foreign` FOREIGN KEY (`materia_ligada3_id`) REFERENCES `cat_materias` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `cat_materias_materia_ligada_id_foreign` FOREIGN KEY (`materia_ligada_id`) REFERENCES `cat_materias` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `cat_materias_profesor_asignado_id_foreign` FOREIGN KEY (`profesor_asignado_id`) REFERENCES `catedraticos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 973 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for cat_municipios
-- ----------------------------
DROP TABLE IF EXISTS `cat_municipios`;
CREATE TABLE `cat_municipios`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `clave` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `cat_municipios_clave_estado_id_unique`(`clave`, `estado_id`) USING BTREE,
  INDEX `cat_municipios_estado_id_nombre_index`(`estado_id`, `nombre`) USING BTREE,
  CONSTRAINT `cat_municipios_estado_id_foreign` FOREIGN KEY (`estado_id`) REFERENCES `cat_estados` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2479 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for cat_niveles_desempeno
-- ----------------------------
DROP TABLE IF EXISTS `cat_niveles_desempeno`;
CREATE TABLE `cat_niveles_desempeno`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `clave` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `orden` tinyint(3) UNSIGNED NOT NULL,
  `acredita` tinyint(1) NOT NULL DEFAULT 1,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `cat_niveles_desempeno_clave_unique`(`clave`) USING BTREE,
  INDEX `cat_niveles_desempeno_orden_index`(`orden`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for cat_periodos_escolares
-- ----------------------------
DROP TABLE IF EXISTS `cat_periodos_escolares`;
CREATE TABLE `cat_periodos_escolares`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `fecha_limite_pagos` date NULL DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `cat_periodos_escolares_fecha_inicio_index`(`fecha_inicio`) USING BTREE,
  INDEX `cat_periodos_escolares_fecha_fin_index`(`fecha_fin`) USING BTREE,
  INDEX `cat_periodos_escolares_activo_index`(`activo`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 82 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for cat_plan_estudios
-- ----------------------------
DROP TABLE IF EXISTS `cat_plan_estudios`;
CREATE TABLE `cat_plan_estudios`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `carrera_id` bigint(20) UNSIGNED NOT NULL,
  `clave` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NULL DEFAULT NULL,
  `creditos_totales` int(11) NOT NULL,
  `duracion_semestres` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `modelo_educativo` tinyint(4) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `activo_unico` tinyint(4) GENERATED ALWAYS AS ((case when `activo` then 1 else NULL end)) STORED NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `cat_plan_estudios_clave_unique`(`clave`) USING BTREE,
  UNIQUE INDEX `uq_plan_vigente_por_carrera`(`carrera_id`, `activo_unico`) USING BTREE,
  INDEX `cat_plan_estudios_carrera_id_index`(`carrera_id`) USING BTREE,
  INDEX `cat_plan_estudios_activo_index`(`activo`) USING BTREE,
  CONSTRAINT `cat_plan_estudios_carrera_id_foreign` FOREIGN KEY (`carrera_id`) REFERENCES `cat_carreras` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for catedraticos
-- ----------------------------
DROP TABLE IF EXISTS `catedraticos`;
CREATE TABLE `catedraticos`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `numero_empleado` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cedula_profesional` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tipo_contrato` enum('Tiempo completo','Medio tiempo','Asignatura','Honorarios') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `fecha_ingreso` date NULL DEFAULT NULL,
  `especialidad` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `grado_estudios` enum('Licenciatura','Maestría','Doctorado') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `departamento_adscripcion` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `carrera_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `catedraticos_user_id_unique`(`user_id`) USING BTREE,
  UNIQUE INDEX `catedraticos_numero_empleado_unique`(`numero_empleado`) USING BTREE,
  INDEX `catedraticos_carrera_id_foreign`(`carrera_id`) USING BTREE,
  INDEX `catedraticos_tipo_contrato_index`(`tipo_contrato`) USING BTREE,
  INDEX `catedraticos_departamento_adscripcion_index`(`departamento_adscripcion`) USING BTREE,
  INDEX `catedraticos_activo_index`(`activo`) USING BTREE,
  CONSTRAINT `catedraticos_carrera_id_foreign` FOREIGN KEY (`carrera_id`) REFERENCES `cat_carreras` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `catedraticos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 237 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for certificados_generados
-- ----------------------------
DROP TABLE IF EXISTS `certificados_generados`;
CREATE TABLE `certificados_generados`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `folio` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alumno_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `tipo_certificado` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'TOTAL',
  `tamano_papel` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'letter',
  `promedio` decimal(5, 2) NOT NULL DEFAULT 0.00,
  `creditos_totales` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `creditos_acreditados` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `porcentaje_avance` decimal(5, 2) NOT NULL DEFAULT 0.00,
  `total_materias` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `materias_acreditadas` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `ruta_pdf` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `archivo_nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_emision` date NOT NULL,
  `lugar_expedicion` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `director_nombre` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `director_cargo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `servicios_escolares_nombre` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `servicios_escolares_cargo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `observaciones` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `metadata` json NULL,
  `regenerado_por_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `regenerado_en` datetime(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `certificados_generados_folio_unique`(`folio`) USING BTREE,
  INDEX `certificados_generados_user_id_foreign`(`user_id`) USING BTREE,
  INDEX `certificados_generados_regenerado_por_id_foreign`(`regenerado_por_id`) USING BTREE,
  INDEX `certificados_generados_folio_index`(`folio`) USING BTREE,
  INDEX `certificados_generados_alumno_id_index`(`alumno_id`) USING BTREE,
  INDEX `certificados_generados_fecha_emision_index`(`fecha_emision`) USING BTREE,
  INDEX `certificados_generados_tipo_certificado_index`(`tipo_certificado`) USING BTREE,
  CONSTRAINT `certificados_generados_alumno_id_foreign` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `certificados_generados_regenerado_por_id_foreign` FOREIGN KEY (`regenerado_por_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `certificados_generados_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for cierres_periodo
-- ----------------------------
DROP TABLE IF EXISTS `cierres_periodo`;
CREATE TABLE `cierres_periodo`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `periodo_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `user_name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `fecha_cierre` timestamp(0) NOT NULL,
  `resumen` json NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `cierres_periodo_periodo_id_index`(`periodo_id`) USING BTREE,
  INDEX `cierres_periodo_user_id_index`(`user_id`) USING BTREE,
  INDEX `cierres_periodo_fecha_cierre_index`(`fecha_cierre`) USING BTREE,
  CONSTRAINT `cierres_periodo_periodo_id_foreign` FOREIGN KEY (`periodo_id`) REFERENCES `cat_periodos_escolares` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `cierres_periodo_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for corte_calificacions
-- ----------------------------
DROP TABLE IF EXISTS `corte_calificacions`;
CREATE TABLE `corte_calificacions`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `periodo_id` bigint(20) UNSIGNED NOT NULL,
  `numero_corte` int(11) NOT NULL,
  `nombre_corte` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `fecha_apertura` date NOT NULL,
  `fecha_cierre` date NOT NULL,
  `abierto` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `corte_periodo_unique`(`periodo_id`, `numero_corte`) USING BTREE,
  INDEX `corte_calificacions_fecha_apertura_index`(`fecha_apertura`) USING BTREE,
  INDEX `corte_calificacions_fecha_cierre_index`(`fecha_cierre`) USING BTREE,
  INDEX `corte_calificacions_abierto_index`(`abierto`) USING BTREE,
  CONSTRAINT `corte_calificacions_periodo_id_foreign` FOREIGN KEY (`periodo_id`) REFERENCES `cat_periodos_escolares` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for discapacidades
-- ----------------------------
DROP TABLE IF EXISTS `discapacidades`;
CREATE TABLE `discapacidades`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `discapacidades_nombre_unique`(`nombre`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for documentos_titulacion
-- ----------------------------
DROP TABLE IF EXISTS `documentos_titulacion`;
CREATE TABLE `documentos_titulacion`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `solicitud_titulacion_id` bigint(20) UNSIGNED NOT NULL,
  `solicitud_id` bigint(20) UNSIGNED NOT NULL,
  `alumno_id` bigint(20) UNSIGNED NOT NULL,
  `nombre_documento` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_documento` enum('solicitud','acta_nacimiento','certificado_estudios','kardex','comprobante_pago','comprobante','carta_liberacion_ss','carta_liberacion_residencia','tesis','informe','constancia_idiomas','constancia_servicio_social','constancia_residencia','curriculum','dictamen_jurado','acta_profesional','cedula_federal','foto_titulacion','otro') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `archivo_path` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Ruta del archivo almacenado',
  `archivo_nombre_original` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `archivo_mime_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `archivo_tamano` int(11) NOT NULL COMMENT 'Tamaño en bytes',
  `ruta_archivo` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nombre_original` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `mime_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tamano` int(11) NULL DEFAULT NULL,
  `fecha_subida` timestamp(0) NULL DEFAULT NULL,
  `validado` tinyint(1) NOT NULL DEFAULT 0,
  `observaciones` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `estatus` enum('pendiente','validado','rechazado') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendiente',
  `observaciones_validacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `fecha_validacion` timestamp(0) NULL DEFAULT NULL,
  `validado_por` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `version` int(11) NOT NULL DEFAULT 1,
  `es_requisito_obligatorio` tinyint(1) NOT NULL DEFAULT 1,
  `creado_por` bigint(20) UNSIGNED NOT NULL,
  `actualizado_por` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `documentos_titulacion_validado_por_foreign`(`validado_por`) USING BTREE,
  INDEX `documentos_titulacion_creado_por_foreign`(`creado_por`) USING BTREE,
  INDEX `documentos_titulacion_actualizado_por_foreign`(`actualizado_por`) USING BTREE,
  INDEX `documentos_titulacion_solicitud_titulacion_id_index`(`solicitud_titulacion_id`) USING BTREE,
  INDEX `documentos_titulacion_solicitud_id_index`(`solicitud_id`) USING BTREE,
  INDEX `documentos_titulacion_alumno_id_index`(`alumno_id`) USING BTREE,
  INDEX `documentos_titulacion_tipo_documento_index`(`tipo_documento`) USING BTREE,
  INDEX `documentos_titulacion_estatus_index`(`estatus`) USING BTREE,
  INDEX `documentos_titulacion_fecha_validacion_index`(`fecha_validacion`) USING BTREE,
  INDEX `documentos_titulacion_fecha_subida_index`(`fecha_subida`) USING BTREE,
  INDEX `doc_tit_sol_tipo_estatus_idx`(`solicitud_titulacion_id`, `tipo_documento`, `estatus`) USING BTREE,
  CONSTRAINT `documentos_titulacion_actualizado_por_foreign` FOREIGN KEY (`actualizado_por`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `documentos_titulacion_alumno_id_foreign` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `documentos_titulacion_creado_por_foreign` FOREIGN KEY (`creado_por`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `documentos_titulacion_solicitud_id_foreign` FOREIGN KEY (`solicitud_id`) REFERENCES `solicitudes_titulacion` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `documentos_titulacion_solicitud_titulacion_id_foreign` FOREIGN KEY (`solicitud_titulacion_id`) REFERENCES `solicitudes_titulacion` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `documentos_titulacion_validado_por_foreign` FOREIGN KEY (`validado_por`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for especialidad_materias
-- ----------------------------
DROP TABLE IF EXISTS `especialidad_materias`;
CREATE TABLE `especialidad_materias`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `especialidad_id` bigint(20) UNSIGNED NOT NULL,
  `materia_id` bigint(20) UNSIGNED NOT NULL,
  `obligatoria` tinyint(1) NOT NULL DEFAULT 1,
  `semestre_recomendado` int(11) NULL DEFAULT NULL,
  `fila` int(11) NULL DEFAULT NULL,
  `columna` int(11) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `especialidad_materias_unique`(`especialidad_id`, `materia_id`) USING BTREE,
  INDEX `especialidad_materias_materia_id_foreign`(`materia_id`) USING BTREE,
  CONSTRAINT `especialidad_materias_especialidad_id_foreign` FOREIGN KEY (`especialidad_id`) REFERENCES `cat_especialidades` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `especialidad_materias_materia_id_foreign` FOREIGN KEY (`materia_id`) REFERENCES `cat_materias` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1572 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for grupos
-- ----------------------------
DROP TABLE IF EXISTS `grupos`;
CREATE TABLE `grupos`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `periodo_id` bigint(20) UNSIGNED NOT NULL,
  `materia_id` bigint(20) UNSIGNED NOT NULL,
  `catedratico_id` bigint(20) UNSIGNED NOT NULL,
  `clave_grupo` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cupo_maximo` int(11) NOT NULL,
  `cupo_actual` int(11) NOT NULL DEFAULT 0,
  `horario_entrada` time(0) NULL DEFAULT NULL,
  `horario_salida` time(0) NULL DEFAULT NULL,
  `dias` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `horario_detalle` json NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `plan_estudio_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `departamento_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `grupos_periodo_id_index`(`periodo_id`) USING BTREE,
  INDEX `grupos_materia_id_index`(`materia_id`) USING BTREE,
  INDEX `grupos_catedratico_id_index`(`catedratico_id`) USING BTREE,
  INDEX `idx_grupos_clave_periodo_materia`(`clave_grupo`, `periodo_id`, `materia_id`) USING BTREE,
  INDEX `grupos_plan_estudio_id_foreign`(`plan_estudio_id`) USING BTREE,
  INDEX `grupos_departamento_id_foreign`(`departamento_id`) USING BTREE,
  CONSTRAINT `grupos_catedratico_id_foreign` FOREIGN KEY (`catedratico_id`) REFERENCES `catedraticos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `grupos_departamento_id_foreign` FOREIGN KEY (`departamento_id`) REFERENCES `cat_departamentos_academicos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `grupos_materia_id_foreign` FOREIGN KEY (`materia_id`) REFERENCES `cat_materias` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `grupos_periodo_id_foreign` FOREIGN KEY (`periodo_id`) REFERENCES `cat_periodos_escolares` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `grupos_plan_estudio_id_foreign` FOREIGN KEY (`plan_estudio_id`) REFERENCES `cat_plan_estudios` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3079 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for job_batches
-- ----------------------------
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `cancelled_at` int(11) NULL DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for jobs
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED NULL DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `jobs_queue_index`(`queue`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for jurados_titulacion
-- ----------------------------
DROP TABLE IF EXISTS `jurados_titulacion`;
CREATE TABLE `jurados_titulacion`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `solicitud_titulacion_id` bigint(20) UNSIGNED NOT NULL,
  `presidente_id` bigint(20) UNSIGNED NOT NULL,
  `secretario_id` bigint(20) UNSIGNED NOT NULL,
  `vocal_id` bigint(20) UNSIGNED NOT NULL,
  `suplente_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `estatus` enum('propuesto','designado','confirmado','reemplazado') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'propuesto',
  `fecha_nombramiento` date NULL DEFAULT NULL,
  `fecha_confirmacion` date NULL DEFAULT NULL,
  `observaciones` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `designaciones_especificas` json NULL COMMENT 'Roles específicos adicionales',
  `creado_por` bigint(20) UNSIGNED NOT NULL,
  `actualizado_por` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `jurados_titulacion_presidente_id_foreign`(`presidente_id`) USING BTREE,
  INDEX `jurados_titulacion_secretario_id_foreign`(`secretario_id`) USING BTREE,
  INDEX `jurados_titulacion_vocal_id_foreign`(`vocal_id`) USING BTREE,
  INDEX `jurados_titulacion_suplente_id_foreign`(`suplente_id`) USING BTREE,
  INDEX `jurados_titulacion_creado_por_foreign`(`creado_por`) USING BTREE,
  INDEX `jurados_titulacion_actualizado_por_foreign`(`actualizado_por`) USING BTREE,
  INDEX `jurados_titulacion_solicitud_titulacion_id_index`(`solicitud_titulacion_id`) USING BTREE,
  INDEX `jurados_titulacion_estatus_index`(`estatus`) USING BTREE,
  INDEX `jurados_titulacion_fecha_nombramiento_index`(`fecha_nombramiento`) USING BTREE,
  CONSTRAINT `jurados_titulacion_actualizado_por_foreign` FOREIGN KEY (`actualizado_por`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `jurados_titulacion_creado_por_foreign` FOREIGN KEY (`creado_por`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `jurados_titulacion_presidente_id_foreign` FOREIGN KEY (`presidente_id`) REFERENCES `catedraticos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `jurados_titulacion_secretario_id_foreign` FOREIGN KEY (`secretario_id`) REFERENCES `catedraticos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `jurados_titulacion_solicitud_titulacion_id_foreign` FOREIGN KEY (`solicitud_titulacion_id`) REFERENCES `solicitudes_titulacion` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `jurados_titulacion_suplente_id_foreign` FOREIGN KEY (`suplente_id`) REFERENCES `catedraticos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `jurados_titulacion_vocal_id_foreign` FOREIGN KEY (`vocal_id`) REFERENCES `catedraticos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for kardex
-- ----------------------------
DROP TABLE IF EXISTS `kardex`;
CREATE TABLE `kardex`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `alumno_id` bigint(20) UNSIGNED NOT NULL,
  `materia_id` bigint(20) UNSIGNED NOT NULL,
  `materia_origen_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `plan_estudio_id` bigint(20) UNSIGNED NOT NULL,
  `plan_estudio_origen_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `especialidad_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `periodo_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `semestre` int(11) NOT NULL,
  `grupo_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `catedratico_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `convalidacion_aplicada` tinyint(1) NOT NULL DEFAULT 0,
  `convalidacion_motivo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `convalidacion_autorizada_por_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `opcion_acreditacion` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `opcion_acreditacion_numerico` int(11) NULL DEFAULT NULL,
  `calificacion_final` decimal(5, 2) NULL DEFAULT NULL,
  `nivel_desempeno_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `fecha_liberacion` date NULL DEFAULT NULL,
  `acreditada` tinyint(1) NOT NULL DEFAULT 0,
  `creditos_materia` int(11) NOT NULL,
  `ultima_opcion` int(11) NULL DEFAULT NULL,
  `fecha_especial` date NULL DEFAULT NULL,
  `idsice` int(11) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `kardex_unico_numerico`(`alumno_id`, `materia_id`, `periodo_id`, `opcion_acreditacion_numerico`) USING BTREE,
  INDEX `kardex_plan_estudio_id_foreign`(`plan_estudio_id`) USING BTREE,
  INDEX `kardex_plan_estudio_origen_id_foreign`(`plan_estudio_origen_id`) USING BTREE,
  INDEX `kardex_especialidad_id_foreign`(`especialidad_id`) USING BTREE,
  INDEX `kardex_grupo_id_foreign`(`grupo_id`) USING BTREE,
  INDEX `kardex_catedratico_id_foreign`(`catedratico_id`) USING BTREE,
  INDEX `kardex_convalidacion_autorizada_por_id_foreign`(`convalidacion_autorizada_por_id`) USING BTREE,
  INDEX `kardex_alumno_id_index`(`alumno_id`) USING BTREE,
  INDEX `kardex_materia_id_index`(`materia_id`) USING BTREE,
  INDEX `kardex_materia_origen_id_index`(`materia_origen_id`) USING BTREE,
  INDEX `kardex_periodo_id_index`(`periodo_id`) USING BTREE,
  INDEX `kardex_acreditada_index`(`acreditada`) USING BTREE,
  INDEX `kardex_convalidacion_aplicada_index`(`convalidacion_aplicada`) USING BTREE,
  INDEX `kardex_idsice_index`(`idsice`) USING BTREE,
  INDEX `kardex_nivel_desempeno_id_foreign`(`nivel_desempeno_id`) USING BTREE,
  CONSTRAINT `kardex_alumno_id_foreign` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `kardex_catedratico_id_foreign` FOREIGN KEY (`catedratico_id`) REFERENCES `catedraticos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `kardex_convalidacion_autorizada_por_id_foreign` FOREIGN KEY (`convalidacion_autorizada_por_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `kardex_especialidad_id_foreign` FOREIGN KEY (`especialidad_id`) REFERENCES `cat_especialidades` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `kardex_grupo_id_foreign` FOREIGN KEY (`grupo_id`) REFERENCES `grupos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `kardex_materia_id_foreign` FOREIGN KEY (`materia_id`) REFERENCES `cat_materias` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `kardex_materia_origen_id_foreign` FOREIGN KEY (`materia_origen_id`) REFERENCES `cat_materias` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `kardex_nivel_desempeno_id_foreign` FOREIGN KEY (`nivel_desempeno_id`) REFERENCES `cat_niveles_desempeno` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `kardex_periodo_id_foreign` FOREIGN KEY (`periodo_id`) REFERENCES `cat_periodos_escolares` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `kardex_plan_estudio_id_foreign` FOREIGN KEY (`plan_estudio_id`) REFERENCES `cat_plan_estudios` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `kardex_plan_estudio_origen_id_foreign` FOREIGN KEY (`plan_estudio_origen_id`) REFERENCES `cat_plan_estudios` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1466372 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for kardex_sice_pendiente
-- ----------------------------
DROP TABLE IF EXISTS `kardex_sice_pendiente`;
CREATE TABLE `kardex_sice_pendiente`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `origen` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cdx_clave` int(11) NULL DEFAULT NULL,
  `kardex_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `alu_numcontrol` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `alumno_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `ret_clave` int(11) NULL DEFAULT NULL,
  `materia_clave` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `plan_clave` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `periodo` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `anio` smallint(6) NULL DEFAULT NULL,
  `calificacion` decimal(5, 2) NULL DEFAULT NULL,
  `opcion` int(11) NULL DEFAULT NULL,
  `fecha` date NULL DEFAULT NULL,
  `estado` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendiente',
  `nota` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `kardex_sice_pendiente_origen_cdx_unique`(`origen`, `cdx_clave`) USING BTREE,
  UNIQUE INDEX `kardex_sice_pendiente_origen_kardex_unique`(`origen`, `kardex_id`) USING BTREE,
  INDEX `kardex_sice_pendiente_cdx_clave_index`(`cdx_clave`) USING BTREE,
  INDEX `kardex_sice_pendiente_kardex_id_index`(`kardex_id`) USING BTREE,
  INDEX `kardex_sice_pendiente_alumno_id_index`(`alumno_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 49155 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lista_unidades
-- ----------------------------
DROP TABLE IF EXISTS `lista_unidades`;
CREATE TABLE `lista_unidades`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `lista_id` bigint(20) UNSIGNED NOT NULL,
  `numero_unidad` smallint(5) UNSIGNED NOT NULL,
  `oportunidad` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `calificacion` decimal(5, 2) NULL DEFAULT NULL,
  `faltas` int(11) NULL DEFAULT NULL,
  `corte` int(11) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `lista_unidad_oportunidad_unica`(`lista_id`, `numero_unidad`, `oportunidad`) USING BTREE,
  INDEX `lista_unidades_numero_unidad_index`(`numero_unidad`) USING BTREE,
  INDEX `lista_unidades_lista_id_nueva_index`(`lista_id`) USING BTREE,
  CONSTRAINT `lista_unidades_lista_id_foreign` FOREIGN KEY (`lista_id`) REFERENCES `listas` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3321 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for listas
-- ----------------------------
DROP TABLE IF EXISTS `listas`;
CREATE TABLE `listas`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `alumno_id` bigint(20) UNSIGNED NOT NULL,
  `grupo_id` bigint(20) UNSIGNED NOT NULL,
  `catedratico_id` bigint(20) UNSIGNED NOT NULL,
  `opcion_acreditacion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `opcion_acreditacion_numerico` int(11) NULL DEFAULT NULL,
  `calificacion_final` decimal(5, 2) NULL DEFAULT NULL,
  `faltas_totales` int(11) NULL DEFAULT NULL,
  `fecha_registro` date NULL DEFAULT NULL,
  `tipo_carga` enum('normal','especial') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'normal',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `lista_unica`(`alumno_id`, `grupo_id`) USING BTREE,
  INDEX `listas_grupo_id_index`(`grupo_id`) USING BTREE,
  INDEX `listas_catedratico_id_index`(`catedratico_id`) USING BTREE,
  CONSTRAINT `listas_alumno_id_foreign` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `listas_catedratico_id_foreign` FOREIGN KEY (`catedratico_id`) REFERENCES `catedraticos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `listas_grupo_id_foreign` FOREIGN KEY (`grupo_id`) REFERENCES `grupos` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 20585 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 87 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for model_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions`  (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`, `model_id`, `model_type`) USING BTREE,
  INDEX `model_has_permissions_model_id_model_type_index`(`model_id`, `model_type`) USING BTREE,
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for model_has_roles
-- ----------------------------
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles`  (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`, `model_id`, `model_type`) USING BTREE,
  INDEX `model_has_roles_model_id_model_type_index`(`model_id`, `model_type`) USING BTREE,
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for modelo_educativo
-- ----------------------------
DROP TABLE IF EXISTS `modelo_educativo`;
CREATE TABLE `modelo_educativo`  (
  `id` tinyint(4) NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for opcion_acreditacion
-- ----------------------------
DROP TABLE IF EXISTS `opcion_acreditacion`;
CREATE TABLE `opcion_acreditacion`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `modelo_educativo_id` tinyint(4) NOT NULL,
  `opcion` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for opciones_titulacion
-- ----------------------------
DROP TABLE IF EXISTS `opciones_titulacion`;
CREATE TABLE `opciones_titulacion`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `plan_estudio_id` bigint(20) UNSIGNED NOT NULL,
  `requiere_proyecto` tinyint(1) NOT NULL DEFAULT 0,
  `requiere_documento` tinyint(1) NOT NULL DEFAULT 1,
  `requisitos_extra` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `orden` int(11) NOT NULL DEFAULT 0,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `opciones_titulacion_plan_estudio_id_index`(`plan_estudio_id`) USING BTREE,
  INDEX `opciones_titulacion_activo_index`(`activo`) USING BTREE,
  CONSTRAINT `opciones_titulacion_plan_estudio_id_foreign` FOREIGN KEY (`plan_estudio_id`) REFERENCES `cat_plan_estudios` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for pago_inscripcions
-- ----------------------------
DROP TABLE IF EXISTS `pago_inscripcions`;
CREATE TABLE `pago_inscripcions`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `alumno_id` bigint(20) UNSIGNED NOT NULL,
  `periodo_id` bigint(20) UNSIGNED NOT NULL,
  `monto` decimal(10, 2) NOT NULL,
  `fecha_pago` date NOT NULL,
  `folio_pago` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `metodo_pago` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `validado` tinyint(1) NOT NULL DEFAULT 0,
  `validado_por` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `fecha_validacion` date NULL DEFAULT NULL,
  `observaciones` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `pago_periodo_unique`(`alumno_id`, `periodo_id`) USING BTREE,
  INDEX `pago_inscripcions_validado_por_foreign`(`validado_por`) USING BTREE,
  INDEX `pago_inscripcions_periodo_id_index`(`periodo_id`) USING BTREE,
  INDEX `pago_inscripcions_validado_index`(`validado`) USING BTREE,
  INDEX `pago_inscripcions_fecha_pago_index`(`fecha_pago`) USING BTREE,
  CONSTRAINT `pago_inscripcions_alumno_id_foreign` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `pago_inscripcions_periodo_id_foreign` FOREIGN KEY (`periodo_id`) REFERENCES `cat_periodos_escolares` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `pago_inscripcions_validado_por_foreign` FOREIGN KEY (`validado_por`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for paquete_grupo
-- ----------------------------
DROP TABLE IF EXISTS `paquete_grupo`;
CREATE TABLE `paquete_grupo`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `paquete_id` bigint(20) UNSIGNED NOT NULL,
  `grupo_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `paquete_grupo_unique`(`paquete_id`, `grupo_id`) USING BTREE,
  INDEX `paquete_grupo_grupo_id_foreign`(`grupo_id`) USING BTREE,
  CONSTRAINT `paquete_grupo_grupo_id_foreign` FOREIGN KEY (`grupo_id`) REFERENCES `grupos` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `paquete_grupo_paquete_id_foreign` FOREIGN KEY (`paquete_id`) REFERENCES `paquetes` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for paquetes
-- ----------------------------
DROP TABLE IF EXISTS `paquetes`;
CREATE TABLE `paquetes`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `carrera_id` bigint(20) UNSIGNED NOT NULL,
  `periodo_id` bigint(20) UNSIGNED NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `paquetes_carrera_id_foreign`(`carrera_id`) USING BTREE,
  INDEX `paquetes_periodo_id_foreign`(`periodo_id`) USING BTREE,
  CONSTRAINT `paquetes_carrera_id_foreign` FOREIGN KEY (`carrera_id`) REFERENCES `cat_carreras` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `paquetes_periodo_id_foreign` FOREIGN KEY (`periodo_id`) REFERENCES `cat_periodos_escolares` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for password_reset_tokens
-- ----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `permissions_name_guard_name_unique`(`name`, `guard_name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 147 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `last_used_at` timestamp(0) NULL DEFAULT NULL,
  `expires_at` timestamp(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `personal_access_tokens_token_unique`(`token`) USING BTREE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type`, `tokenable_id`) USING BTREE,
  INDEX `personal_access_tokens_expires_at_index`(`expires_at`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 53 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for plan_credito_limites
-- ----------------------------
DROP TABLE IF EXISTS `plan_credito_limites`;
CREATE TABLE `plan_credito_limites`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `plan_estudio_id` bigint(20) UNSIGNED NOT NULL,
  `creditos_minimos` int(10) UNSIGNED NOT NULL DEFAULT 22,
  `creditos_maximos` int(10) UNSIGNED NOT NULL DEFAULT 36,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `plan_credito_limites_plan_estudio_id_unique`(`plan_estudio_id`) USING BTREE,
  INDEX `plan_credito_limites_activo_index`(`activo`) USING BTREE,
  CONSTRAINT `plan_credito_limites_plan_estudio_id_foreign` FOREIGN KEY (`plan_estudio_id`) REFERENCES `cat_plan_estudios` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for plan_materia_sice
-- ----------------------------
DROP TABLE IF EXISTS `plan_materia_sice`;
CREATE TABLE `plan_materia_sice`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `plan_materia_id` bigint(20) UNSIGNED NOT NULL,
  `especialidad_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `siceid` int(11) NULL DEFAULT NULL,
  `sicecve` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `siceespcve` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `carcve` int(11) NOT NULL,
  `placve` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `matcve` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `plan_materia_sice_siceid_unique`(`siceid`) USING BTREE,
  UNIQUE INDEX `plan_materia_sice_plan_especialidad_unique`(`plan_materia_id`, `especialidad_id`) USING BTREE,
  INDEX `plan_materia_sice_especialidad_id_foreign`(`especialidad_id`) USING BTREE,
  CONSTRAINT `plan_materia_sice_especialidad_id_foreign` FOREIGN KEY (`especialidad_id`) REFERENCES `cat_especialidades` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `plan_materia_sice_plan_materia_id_foreign` FOREIGN KEY (`plan_materia_id`) REFERENCES `plan_materias` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1181 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for plan_materias
-- ----------------------------
DROP TABLE IF EXISTS `plan_materias`;
CREATE TABLE `plan_materias`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `plan_estudio_id` bigint(20) UNSIGNED NOT NULL,
  `materia_id` bigint(20) UNSIGNED NOT NULL,
  `especialidad_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `clasificacion` enum('tronco_comun','perfil') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'perfil',
  `semestre_recomendado` int(11) NULL DEFAULT NULL,
  `obligatoria` tinyint(1) NOT NULL DEFAULT 1,
  `fila` int(11) NULL DEFAULT NULL,
  `columna` int(11) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `plan_materias_unique`(`plan_estudio_id`, `materia_id`, `especialidad_id`) USING BTREE,
  INDEX `plan_materias_materia_id_foreign`(`materia_id`) USING BTREE,
  INDEX `plan_materias_clasificacion_index`(`clasificacion`) USING BTREE,
  INDEX `plan_materias_semestre_recomendado_index`(`semestre_recomendado`) USING BTREE,
  INDEX `plan_materias_especialidad_id_index`(`especialidad_id`) USING BTREE,
  CONSTRAINT `plan_materias_especialidad_id_foreign` FOREIGN KEY (`especialidad_id`) REFERENCES `cat_especialidades` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `plan_materias_materia_id_foreign` FOREIGN KEY (`materia_id`) REFERENCES `cat_materias` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `plan_materias_plan_estudio_id_foreign` FOREIGN KEY (`plan_estudio_id`) REFERENCES `cat_plan_estudios` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1189 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for recibo_movs
-- ----------------------------
DROP TABLE IF EXISTS `recibo_movs`;
CREATE TABLE `recibo_movs`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `recibo_id` bigint(20) UNSIGNED NOT NULL,
  `concepto_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `clave` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `concepto` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1,
  `importe` decimal(12, 2) NOT NULL,
  `obs` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `tag` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `recibo_movs_recibo_id_index`(`recibo_id`) USING BTREE,
  INDEX `recibo_movs_concepto_id_index`(`concepto_id`) USING BTREE,
  CONSTRAINT `recibo_movs_recibo_id_foreign` FOREIGN KEY (`recibo_id`) REFERENCES `recibos` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for recibos
-- ----------------------------
DROP TABLE IF EXISTS `recibos`;
CREATE TABLE `recibos`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `control` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` date NOT NULL,
  `hora` time(0) NOT NULL,
  `total` decimal(12, 2) NOT NULL,
  `observaciones` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `usuario` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `origen` enum('W','V','API') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'W',
  `status` enum('G','A','P','C') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'G',
  `link` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `referencia` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `fecha_pago` date NULL DEFAULT NULL,
  `folio_pago` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `alumno_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `recibos_alumno_id_index`(`alumno_id`) USING BTREE,
  INDEX `recibos_status_index`(`status`) USING BTREE,
  INDEX `recibos_fecha_index`(`fecha`) USING BTREE,
  INDEX `recibos_referencia_index`(`referencia`) USING BTREE,
  CONSTRAINT `recibos_alumno_id_foreign` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for reportes_ejecuciones
-- ----------------------------
DROP TABLE IF EXISTS `reportes_ejecuciones`;
CREATE TABLE `reportes_ejecuciones`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `reporte_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `configuracion` json NOT NULL,
  `registros_encontrados` int(11) NOT NULL DEFAULT 0,
  `tiempo_ejecucion_ms` int(11) NULL DEFAULT NULL,
  `estado` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'exitoso',
  `error` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `ip_origen` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `reportes_ejecuciones_reporte_id_created_at_index`(`reporte_id`, `created_at`) USING BTREE,
  INDEX `reportes_ejecuciones_user_id_estado_index`(`user_id`, `estado`) USING BTREE,
  CONSTRAINT `reportes_ejecuciones_reporte_id_foreign` FOREIGN KEY (`reporte_id`) REFERENCES `reportes_personalizados` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `reportes_ejecuciones_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for reportes_personalizados
-- ----------------------------
DROP TABLE IF EXISTS `reportes_personalizados`;
CREATE TABLE `reportes_personalizados`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `tabla_principal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tablas_seleccionadas` json NULL,
  `campos` json NOT NULL,
  `filtros` json NULL,
  `ordenamiento` json NULL,
  `agrupacion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `agregaciones` json NULL,
  `paginar` tinyint(1) NOT NULL DEFAULT 1,
  `per_page` int(11) NOT NULL DEFAULT 15,
  `configuracion_grafico` json NULL,
  `user_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `etiqueta` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `es_favorito` tinyint(1) NOT NULL DEFAULT 0,
  `compartido` tinyint(1) NOT NULL DEFAULT 0,
  `token_compartido` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `ultima_ejecucion` timestamp(0) NULL DEFAULT NULL,
  `veces_ejecutado` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `reportes_personalizados_token_compartido_unique`(`token_compartido`) USING BTREE,
  INDEX `reportes_personalizados_user_id_es_favorito_index`(`user_id`, `es_favorito`) USING BTREE,
  INDEX `reportes_personalizados_user_id_etiqueta_index`(`user_id`, `etiqueta`) USING BTREE,
  INDEX `reportes_personalizados_token_compartido_index`(`token_compartido`) USING BTREE,
  CONSTRAINT `reportes_personalizados_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for residencia_alumnos
-- ----------------------------
DROP TABLE IF EXISTS `residencia_alumnos`;
CREATE TABLE `residencia_alumnos`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `alumno_id` bigint(20) UNSIGNED NOT NULL,
  `periodo_id` bigint(20) UNSIGNED NULL DEFAULT NULL COMMENT 'Periodo escolar en el que se solicita la residencia',
  `proyecto_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `fecha_solicitud` date NULL DEFAULT NULL,
  `fecha_asignacion` date NULL DEFAULT NULL,
  `fecha_inicio` date NULL DEFAULT NULL,
  `fecha_termino` date NULL DEFAULT NULL,
  `estatus` enum('solicitado','asignado','en_curso','liberado','no_aprobado') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'solicitado',
  `asesor_interno_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `asesor_externo_nombre` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `asesor_externo_puesto` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `asesor_externo_email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `asesor_externo_telefono` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `anteproyecto_data` json NULL,
  `cronograma_oficial_data` json NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `residencia_alumnos_alumno_id_unique`(`alumno_id`) USING BTREE,
  INDEX `residencia_alumnos_asesor_interno_id_foreign`(`asesor_interno_id`) USING BTREE,
  INDEX `residencia_alumnos_alumno_id_index`(`alumno_id`) USING BTREE,
  INDEX `residencia_alumnos_proyecto_id_index`(`proyecto_id`) USING BTREE,
  INDEX `residencia_alumnos_estatus_index`(`estatus`) USING BTREE,
  INDEX `residencia_alumnos_periodo_id_index`(`periodo_id`) USING BTREE,
  CONSTRAINT `residencia_alumnos_alumno_id_foreign` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `residencia_alumnos_asesor_interno_id_foreign` FOREIGN KEY (`asesor_interno_id`) REFERENCES `catedraticos` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `residencia_alumnos_periodo_id_foreign` FOREIGN KEY (`periodo_id`) REFERENCES `cat_periodos_escolares` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `residencia_alumnos_proyecto_id_foreign` FOREIGN KEY (`proyecto_id`) REFERENCES `residencia_proyectos` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for residencia_archivos
-- ----------------------------
DROP TABLE IF EXISTS `residencia_archivos`;
CREATE TABLE `residencia_archivos`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `residencia_alumno_id` bigint(20) UNSIGNED NOT NULL,
  `tipo_archivo` enum('carta_presentacion','carta_aceptacion','carta_terminacion','proyecto_final','evaluacion_parcial1','evaluacion_parcial2','evaluacion_final') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ruta_archivo` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_original` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tamaño` bigint(20) UNSIGNED NOT NULL,
  `mime_type` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_subida` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0),
  `validado` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `residencia_archivos_alumno_tipo_idx`(`residencia_alumno_id`, `tipo_archivo`) USING BTREE,
  CONSTRAINT `residencia_archivos_residencia_alumno_id_foreign` FOREIGN KEY (`residencia_alumno_id`) REFERENCES `residencia_alumnos` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for residencia_bitacora
-- ----------------------------
DROP TABLE IF EXISTS `residencia_bitacora`;
CREATE TABLE `residencia_bitacora`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `residencia_alumno_id` bigint(20) UNSIGNED NOT NULL,
  `numero_asesoria` int(10) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `duracion` decimal(3, 1) NOT NULL,
  `tema` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `observaciones_asesor` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `compromisos_estudiante` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `residencia_bitacora_asesoria_unique`(`residencia_alumno_id`, `numero_asesoria`) USING BTREE,
  INDEX `residencia_bitacora_fecha_index`(`fecha`) USING BTREE,
  CONSTRAINT `residencia_bitacora_residencia_alumno_id_foreign` FOREIGN KEY (`residencia_alumno_id`) REFERENCES `residencia_alumnos` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for residencia_checkpoints
-- ----------------------------
DROP TABLE IF EXISTS `residencia_checkpoints`;
CREATE TABLE `residencia_checkpoints`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `residencia_alumno_id` bigint(20) UNSIGNED NOT NULL,
  `paso` enum('kardex_validado','ss_validado','ac_validado','anteproyecto_completado','bitacora_completada','liberado') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `completado` tinyint(1) NOT NULL DEFAULT 0,
  `fecha_completado` timestamp(0) NULL DEFAULT NULL,
  `completado_por` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `residencia_checkpoint_unique`(`residencia_alumno_id`, `paso`) USING BTREE,
  INDEX `residencia_checkpoints_completado_por_foreign`(`completado_por`) USING BTREE,
  CONSTRAINT `residencia_checkpoints_completado_por_foreign` FOREIGN KEY (`completado_por`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `residencia_checkpoints_residencia_alumno_id_foreign` FOREIGN KEY (`residencia_alumno_id`) REFERENCES `residencia_alumnos` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for residencia_evaluaciones
-- ----------------------------
DROP TABLE IF EXISTS `residencia_evaluaciones`;
CREATE TABLE `residencia_evaluaciones`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `residencia_alumno_id` bigint(20) UNSIGNED NOT NULL,
  `tipo` enum('parcial1','parcial2','final') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `calificacion` decimal(5, 2) NULL DEFAULT NULL,
  `observaciones` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `evaluador_id` bigint(20) UNSIGNED NOT NULL,
  `fecha_evaluacion` date NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `residencia_evaluaciones_tipo_unique`(`residencia_alumno_id`, `tipo`) USING BTREE,
  INDEX `residencia_evaluaciones_evaluador_id_foreign`(`evaluador_id`) USING BTREE,
  CONSTRAINT `residencia_evaluaciones_evaluador_id_foreign` FOREIGN KEY (`evaluador_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `residencia_evaluaciones_residencia_alumno_id_foreign` FOREIGN KEY (`residencia_alumno_id`) REFERENCES `residencia_alumnos` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for residencia_proyecto_carreras
-- ----------------------------
DROP TABLE IF EXISTS `residencia_proyecto_carreras`;
CREATE TABLE `residencia_proyecto_carreras`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `proyecto_id` bigint(20) UNSIGNED NOT NULL,
  `carrera_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `residencia_proyecto_carrera_unique`(`proyecto_id`, `carrera_id`) USING BTREE,
  INDEX `residencia_proyecto_carreras_carrera_id_index`(`carrera_id`) USING BTREE,
  CONSTRAINT `residencia_proyecto_carreras_carrera_id_foreign` FOREIGN KEY (`carrera_id`) REFERENCES `cat_carreras` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `residencia_proyecto_carreras_proyecto_id_foreign` FOREIGN KEY (`proyecto_id`) REFERENCES `residencia_proyectos` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for residencia_proyectos
-- ----------------------------
DROP TABLE IF EXISTS `residencia_proyectos`;
CREATE TABLE `residencia_proyectos`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `objetivo_proyecto` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `delimitacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `objetivo_general` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `objetivos_especificos` json NOT NULL,
  `justificacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cronograma_preliminar` json NOT NULL,
  `descripcion_actividades` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lugar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `empresa_nombre` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `empresa_direccion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `empresa_contacto_nombre` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `empresa_contacto_puesto` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `empresa_contacto_telefono` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `empresa_contacto_email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `duracion_meses` int(10) UNSIGNED NOT NULL DEFAULT 4,
  `requisitos` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `status` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `residencia_proyectos_activo_index`(`activo`) USING BTREE,
  INDEX `residencia_proyectos_nombre_index`(`nombre`) USING BTREE,
  INDEX `residencia_proyectos_empresa_nombre_index`(`empresa_nombre`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for role_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions`  (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`, `role_id`) USING BTREE,
  INDEX `role_has_permissions_role_id_foreign`(`role_id`) USING BTREE,
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `roles_name_guard_name_unique`(`name`, `guard_name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for semaforo_alumnos
-- ----------------------------
DROP TABLE IF EXISTS `semaforo_alumnos`;
CREATE TABLE `semaforo_alumnos`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `alumno_id` bigint(20) UNSIGNED NOT NULL,
  `semaforo_medico` enum('Verde','Amarillo','Naranja','Rojo') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Verde',
  `semaforo_psicologico` enum('Verde','Amarillo','Naranja','Rojo') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Verde',
  `semaforo_academico` enum('Verde','Amarillo','Naranja','Rojo') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Verde',
  `detalle_medico` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `detalle_psicologico` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `detalle_academico` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `fecha_actualizacion` date NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `semaforo_alumnos_alumno_id_unique`(`alumno_id`) USING BTREE,
  INDEX `semaforo_alumnos_semaforo_medico_index`(`semaforo_medico`) USING BTREE,
  INDEX `semaforo_alumnos_semaforo_psicologico_index`(`semaforo_psicologico`) USING BTREE,
  INDEX `semaforo_alumnos_semaforo_academico_index`(`semaforo_academico`) USING BTREE,
  CONSTRAINT `semaforo_alumnos_alumno_id_foreign` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for servicio_social_alumnos
-- ----------------------------
DROP TABLE IF EXISTS `servicio_social_alumnos`;
CREATE TABLE `servicio_social_alumnos`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `alumno_id` bigint(20) UNSIGNED NOT NULL,
  `dependencia_nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `dependencia_tipo` enum('publica','privada','social') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `proyecto_nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `fecha_inicio` date NULL DEFAULT NULL,
  `fecha_termino` date NULL DEFAULT NULL,
  `constancia_path` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `constancia_estatus` enum('pendiente','en_revision','aprobada','rechazada') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendiente',
  `estatus` enum('no_iniciado','en_curso','liberado') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no_iniciado',
  `observaciones` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `servicio_social_alumnos_alumno_id_unique`(`alumno_id`) USING BTREE,
  INDEX `servicio_social_alumnos_estatus_index`(`estatus`) USING BTREE,
  INDEX `servicio_social_alumnos_dependencia_tipo_index`(`dependencia_tipo`) USING BTREE,
  CONSTRAINT `servicio_social_alumnos_alumno_id_foreign` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sessions_user_id_index`(`user_id`) USING BTREE,
  INDEX `sessions_last_activity_index`(`last_activity`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for solicitudes_titulacion
-- ----------------------------
DROP TABLE IF EXISTS `solicitudes_titulacion`;
CREATE TABLE `solicitudes_titulacion`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `alumno_id` bigint(20) UNSIGNED NOT NULL,
  `opcion_titulacion` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Opción de titulación seleccionada (flexible según catálogo vigente)',
  `estatus` enum('borrador','en_revision','revision_asesor','aprobada_asesor','revision_revisor1','revision_revisor2','aprobada_revisores','aprobada','acto_programado','rechazada','observaciones','completada','cancelada') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'borrador',
  `fecha_solicitud` date NULL DEFAULT NULL,
  `fecha_aprobacion` date NULL DEFAULT NULL,
  `fecha_aprobacion_asesor` datetime(0) NULL DEFAULT NULL,
  `fecha_aprobacion_revisor1` datetime(0) NULL DEFAULT NULL,
  `fecha_aprobacion_revisor2` datetime(0) NULL DEFAULT NULL,
  `observaciones` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `observaciones_asesor` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `datos_extra` json NULL COMMENT 'JSON con metadatos adicionales; por ejemplo, datos de tesis/tesina',
  `asesor` bigint(20) UNSIGNED NULL DEFAULT NULL COMMENT 'ID del asesor asignado (catedrático)',
  `revisor1` bigint(20) UNSIGNED NULL DEFAULT NULL COMMENT 'ID del revisor 1 asignado (catedrático)',
  `revisor2` bigint(20) UNSIGNED NULL DEFAULT NULL COMMENT 'ID del revisor 2 asignado (catedrático)',
  `creado_por` bigint(20) UNSIGNED NOT NULL,
  `actualizado_por` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `solicitudes_titulacion_creado_por_foreign`(`creado_por`) USING BTREE,
  INDEX `solicitudes_titulacion_actualizado_por_foreign`(`actualizado_por`) USING BTREE,
  INDEX `solicitudes_titulacion_alumno_id_index`(`alumno_id`) USING BTREE,
  INDEX `solicitudes_titulacion_estatus_index`(`estatus`) USING BTREE,
  INDEX `solicitudes_titulacion_opcion_titulacion_index`(`opcion_titulacion`) USING BTREE,
  INDEX `solicitudes_titulacion_fecha_solicitud_index`(`fecha_solicitud`) USING BTREE,
  INDEX `solicitudes_titulacion_asesor_index`(`asesor`) USING BTREE,
  INDEX `solicitudes_titulacion_revisor1_index`(`revisor1`) USING BTREE,
  INDEX `solicitudes_titulacion_revisor2_index`(`revisor2`) USING BTREE,
  CONSTRAINT `solicitudes_titulacion_actualizado_por_foreign` FOREIGN KEY (`actualizado_por`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `solicitudes_titulacion_alumno_id_foreign` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `solicitudes_titulacion_creado_por_foreign` FOREIGN KEY (`creado_por`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for titulacion_acto_protocolario
-- ----------------------------
DROP TABLE IF EXISTS `titulacion_acto_protocolario`;
CREATE TABLE `titulacion_acto_protocolario`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `solicitud_id` bigint(20) UNSIGNED NOT NULL,
  `sala_id` bigint(20) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `hora_inicio` time(0) NOT NULL,
  `hora_fin` time(0) NOT NULL,
  `duracion_minutos` smallint(5) UNSIGNED NOT NULL COMMENT 'Duracion total en minutos (60-240)',
  `observaciones` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `titulacion_acto_protocolario_solicitud_unique`(`solicitud_id`) USING BTREE,
  INDEX `titulacion_acto_protocolario_sala_id_foreign`(`sala_id`) USING BTREE,
  INDEX `titulacion_acto_protocolario_fecha_sala_id_index`(`fecha`, `sala_id`) USING BTREE,
  INDEX `titulacion_acto_protocolario_fecha_hora_inicio_hora_fin_index`(`fecha`, `hora_inicio`, `hora_fin`) USING BTREE,
  CONSTRAINT `titulacion_acto_protocolario_sala_id_foreign` FOREIGN KEY (`sala_id`) REFERENCES `aulas` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `titulacion_acto_protocolario_solicitud_id_foreign` FOREIGN KEY (`solicitud_id`) REFERENCES `solicitudes_titulacion` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for titulacion_sinodales
-- ----------------------------
DROP TABLE IF EXISTS `titulacion_sinodales`;
CREATE TABLE `titulacion_sinodales`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `acto_id` bigint(20) UNSIGNED NOT NULL,
  `catedratico_id` bigint(20) UNSIGNED NOT NULL,
  `rol` enum('presidente','secretario','vocal','suplente') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notificado` tinyint(1) NOT NULL DEFAULT 0,
  `confirmado` tinyint(1) NOT NULL DEFAULT 0,
  `fecha_notificacion` datetime(0) NULL DEFAULT NULL,
  `fecha_confirmacion` datetime(0) NULL DEFAULT NULL,
  `observaciones` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `titulacion_sinodales_acto_rol_unique`(`acto_id`, `rol`) USING BTREE,
  UNIQUE INDEX `titulacion_sinodales_acto_catedratico_unique`(`acto_id`, `catedratico_id`) USING BTREE,
  INDEX `titulacion_sinodales_catedratico_id_rol_index`(`catedratico_id`, `rol`) USING BTREE,
  CONSTRAINT `titulacion_sinodales_acto_id_foreign` FOREIGN KEY (`acto_id`) REFERENCES `titulacion_acto_protocolario` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `titulacion_sinodales_catedratico_id_foreign` FOREIGN KEY (`catedratico_id`) REFERENCES `catedraticos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user_activities
-- ----------------------------
DROP TABLE IF EXISTS `user_activities`;
CREATE TABLE `user_activities`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_ip_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `session_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `last_activity` timestamp(0) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_activities_user_ip_hash_index`(`user_ip_hash`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 108 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido_paterno` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `apellido_materno` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `celular` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `telefono_casa` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email_verified_at` timestamp(0) NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email`) USING BTREE,
  INDEX `users_nombre_orden_idx`(`apellido_paterno`, `apellido_materno`, `nombre`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11537 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for visitas_historicas
-- ----------------------------
DROP TABLE IF EXISTS `visitas_historicas`;
CREATE TABLE `visitas_historicas`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 30 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
