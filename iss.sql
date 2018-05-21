-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 14-06-2016 a las 15:30:13
-- Versión del servidor: 5.5.41-0ubuntu0.14.04.1
-- Versión de PHP: 5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `iss`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE IF NOT EXISTS `alumnos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `persona_id` int(10) unsigned NOT NULL,
  `nrolegajo` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '0',
  `fechaingreso` timestamp NULL DEFAULT NULL,
  `fechaegreso` timestamp NULL DEFAULT NULL,
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `alumnos_persona_id_foreign` (`persona_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=74 ;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`id`, `persona_id`, `nrolegajo`, `foto`, `activo`, `fechaingreso`, `fechaegreso`, `usuario_alta`, `fecha_alta`, `usuario_modi`, `fecha_modi`, `created_at`, `updated_at`) VALUES
(41, 75, '38576702', NULL, 1, '2015-02-01 00:00:00', NULL, 'admin', '2015-03-25 00:00:00', 'admin', '2015-03-30 00:00:00', '2015-03-25 12:07:31', '2015-03-30 13:19:08'),
(42, 84, '39607256', NULL, 1, '2015-03-16 00:00:00', NULL, 'admin', '2015-03-27 00:00:00', 'dgomez', '2015-03-31 00:00:00', '2015-03-27 17:12:27', '2015-03-31 15:01:17'),
(43, 86, '37468203', NULL, 1, '2015-03-16 00:00:00', NULL, 'alovera', '2015-03-31 00:00:00', NULL, NULL, '2015-03-31 14:51:06', '2015-03-31 14:51:06'),
(44, 87, '31865565', NULL, 1, '2014-08-19 00:00:00', NULL, 'dgomez', '2015-03-31 00:00:00', 'admin', '2015-04-16 00:00:00', '2015-03-31 15:17:58', '2015-04-16 15:21:24'),
(45, 88, '32234090', NULL, 1, '2015-03-16 00:00:00', NULL, 'dgomez', '2015-03-31 00:00:00', 'admin', '2015-05-15 00:00:00', '2015-03-31 15:31:51', '2015-05-15 14:19:46'),
(46, 89, '40084936', NULL, 1, '2015-03-16 00:00:00', NULL, 'dgomez', '2015-03-31 00:00:00', 'admin', '2015-06-04 00:00:00', '2015-03-31 15:40:00', '2015-06-04 14:50:48'),
(47, 90, '40214643', NULL, 1, '2015-03-16 00:00:00', NULL, 'dgomez', '2015-03-31 00:00:00', NULL, NULL, '2015-03-31 16:00:04', '2015-03-31 16:00:04'),
(48, 91, '36203915', NULL, 1, '2015-03-16 00:00:00', NULL, 'dgomez', '2015-03-31 00:00:00', NULL, NULL, '2015-03-31 16:17:26', '2015-03-31 16:17:26'),
(49, 92, '38541087', NULL, 1, '2015-03-16 00:00:00', NULL, 'dgomez', '2015-03-31 00:00:00', NULL, NULL, '2015-03-31 16:37:03', '2015-03-31 16:37:03'),
(50, 93, '32048532', NULL, 1, '2015-03-16 00:00:00', NULL, 'mcandia', '2015-03-31 00:00:00', 'admin', '2015-05-14 00:00:00', '2015-03-31 22:39:30', '2015-05-14 16:30:03'),
(51, 94, '31406651', NULL, 1, '2015-03-16 00:00:00', NULL, 'mcandia', '2015-03-31 00:00:00', NULL, NULL, '2015-03-31 22:42:47', '2015-03-31 22:42:47'),
(52, 95, '31071391', NULL, 1, '2015-03-16 00:00:00', NULL, 'mcandia', '2015-03-31 00:00:00', 'mcandia', '2015-03-31 00:00:00', '2015-03-31 23:05:57', '2015-03-31 23:09:28'),
(53, 96, '28781722', NULL, 1, '2015-03-16 00:00:00', NULL, 'mcandia', '2015-03-31 00:00:00', 'cdorrego', '2015-03-31 00:00:00', '2015-03-31 23:19:02', '2015-03-31 23:45:16'),
(54, 97, '37911008', NULL, 1, '2015-03-16 00:00:00', NULL, 'mcandia', '2015-03-31 00:00:00', 'mcandia', '2015-03-31 00:00:00', '2015-03-31 23:26:29', '2015-03-31 23:32:23'),
(55, 98, '31091337', NULL, 1, '2015-03-16 00:00:00', NULL, 'mcandia', '2015-03-31 00:00:00', 'admin', '2015-05-14 00:00:00', '2015-03-31 23:39:53', '2015-05-14 14:31:42'),
(56, 99, '38378916', NULL, 1, '2015-03-16 00:00:00', NULL, 'mcandia', '2015-03-31 00:00:00', 'admin', '2015-05-21 00:00:00', '2015-03-31 23:51:27', '2015-05-21 17:12:43'),
(57, 100, '38378917', NULL, 1, '2015-03-16 00:00:00', NULL, 'mcandia', '2015-03-31 00:00:00', 'cdorrego', '2015-04-01 00:00:00', '2015-03-31 23:59:21', '2015-04-01 13:11:29'),
(58, 101, '30445260', NULL, 1, '2015-03-16 00:00:00', NULL, 'mcandia', '2015-04-01 00:00:00', NULL, NULL, '2015-04-01 00:15:44', '2015-04-01 00:15:44'),
(59, 102, '22486262', NULL, 1, '2015-03-16 00:00:00', NULL, 'mcandia', '2015-04-01 00:00:00', 'admin', '2015-05-21 00:00:00', '2015-04-01 00:15:57', '2015-05-21 14:55:33'),
(60, 103, '37585626', NULL, 1, '2015-03-16 00:00:00', NULL, 'mcandia', '2015-04-01 00:00:00', 'mcandia', '2015-04-01 00:00:00', '2015-04-01 00:33:22', '2015-04-01 00:39:30'),
(61, 104, '35003057', NULL, 0, '2015-03-16 00:00:00', NULL, 'mcandia', '2015-04-01 00:00:00', 'admin', '2015-07-27 00:00:00', '2015-04-01 00:45:59', '2015-07-27 18:16:06'),
(62, 105, '36956567', NULL, 1, '2015-03-16 00:00:00', NULL, 'mcandia', '2015-04-01 00:00:00', 'admin', '2015-07-10 00:00:00', '2015-04-01 00:56:01', '2015-07-10 14:21:35'),
(63, 106, '31671507', NULL, 1, '2015-03-16 00:00:00', NULL, 'mcandia', '2015-04-01 00:00:00', 'admin', '2015-06-02 00:00:00', '2015-04-01 01:03:30', '2015-06-02 18:08:39'),
(64, 107, '36955802', NULL, 1, '2015-03-16 00:00:00', NULL, 'mcandia', '2015-04-01 00:00:00', 'mcandia', '2015-04-01 00:00:00', '2015-04-01 01:10:34', '2015-04-01 01:11:52'),
(65, 108, '24287653', NULL, 1, '2015-03-16 00:00:00', NULL, 'mcandia', '2015-04-01 00:00:00', 'mcandia', '2015-04-01 00:00:00', '2015-04-01 01:18:38', '2015-04-01 01:20:05'),
(66, 109, '34047079', NULL, 1, '2015-03-16 00:00:00', NULL, 'dgomez', '2015-04-01 00:00:00', NULL, NULL, '2015-04-01 15:30:20', '2015-04-01 15:30:20'),
(67, 110, '40213111', NULL, 1, '2015-03-16 00:00:00', NULL, 'dgomez', '2015-04-01 00:00:00', NULL, NULL, '2015-04-01 15:44:48', '2015-04-01 15:44:48'),
(68, 111, '399022687', NULL, 1, '2015-03-16 00:00:00', NULL, 'dgomez', '2015-04-01 00:00:00', 'admin', '2015-05-15 00:00:00', '2015-04-01 15:55:14', '2015-05-15 13:14:48'),
(69, 112, '38378372', NULL, 1, '2015-03-16 00:00:00', NULL, 'dgomez', '2015-04-01 00:00:00', NULL, NULL, '2015-04-01 16:01:58', '2015-04-01 16:01:58'),
(70, 113, '39719162', NULL, 1, '2015-03-16 00:00:00', NULL, 'dgomez', '2015-04-01 00:00:00', 'admin', '2015-06-04 00:00:00', '2015-04-01 16:17:56', '2015-06-04 14:42:25'),
(71, 114, '2532323', '114_2532323.jpg', 1, '2012-03-12 00:00:00', NULL, 'admin', '2015-04-07 00:00:00', 'admin', '2015-06-16 00:00:00', '2015-04-07 12:43:41', '2015-06-16 15:39:41'),
(72, 115, '32159789', NULL, 1, '2014-06-12 00:00:00', NULL, 'admin', '2015-06-16 00:00:00', 'admin', '2015-07-15 00:00:00', '2015-06-16 13:40:59', '2015-07-15 13:24:14'),
(73, 116, '33008560', NULL, 1, '2015-07-28 00:00:00', NULL, 'admin', '2015-07-28 00:00:00', NULL, NULL, '2015-07-28 11:16:04', '2015-07-28 11:16:04');

--
-- Disparadores `alumnos`
--
DROP TRIGGER IF EXISTS `tr_alumnos_baja_log`;
DELIMITER //
CREATE TRIGGER `tr_alumnos_baja_log` AFTER DELETE ON `alumnos`
 FOR EACH ROW insert into aud_alumnos_log (id,persona_id,nrolegajo,foto,activo,fechaingreso,fechaegreso,usuario,fecha,baja)
values (OLD.id,OLD.persona_id,OLD.nrolegajo,OLD.foto,OLD.activo,OLD.fechaingreso,OLD.fechaegreso, OLD.usuario_modi,NOW(), 1)
//
DELIMITER ;
DROP TRIGGER IF EXISTS `tr_alumnos_modi_log`;
DELIMITER //
CREATE TRIGGER `tr_alumnos_modi_log` AFTER UPDATE ON `alumnos`
 FOR EACH ROW insert into aud_alumnos_log (id,persona_id,nrolegajo,foto,activo,fechaingreso,fechaegreso,usuario,fecha,modi)
values (OLD.id,OLD.persona_id,OLD.nrolegajo,OLD.foto,OLD.activo,OLD.fechaingreso,OLD.fechaegreso,NEW.usuario_modi,NOW(), 1)
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnosfamiliares`
--

CREATE TABLE IF NOT EXISTS `alumnosfamiliares` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `persona_id` int(10) unsigned NOT NULL,
  `alumno_id` int(10) unsigned NOT NULL,
  `relacionfamiliar_id` int(10) unsigned NOT NULL,
  `responsable` tinyint(1) NOT NULL DEFAULT '0',
  `ocupacion_id` int(10) unsigned DEFAULT NULL,
  `lugartrabajoestudio` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `enfermedaddiscapacidad` tinyint(1) NOT NULL DEFAULT '0',
  `enfermedaddiscapacidaddetalle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `alumnosfamiliares_persona_id_foreign` (`persona_id`),
  KEY `alumnosfamiliares_alumno_id_foreign` (`alumno_id`),
  KEY `alumnosfamiliares_relacionfamiliar_id_foreign` (`relacionfamiliar_id`),
  KEY `alumnosfamiliares_ocupacion_id_foreign` (`ocupacion_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Disparadores `alumnosfamiliares`
--
DROP TRIGGER IF EXISTS `tr_alumnosfamiliares_baja_log`;
DELIMITER //
CREATE TRIGGER `tr_alumnosfamiliares_baja_log` AFTER DELETE ON `alumnosfamiliares`
 FOR EACH ROW insert into aud_alumnosfamiliares_log (id,persona_id,alumno_id,relacionfamiliar_id,responsable,ocupacion_id,lugartrabajoestudio,enfermedaddiscapacidad,enfermedaddiscapacidaddetalle,usuario,fecha,baja)
values (OLD.id,Old.persona_id,Old.alumno_id,Old.relacionfamiliar_id,Old.responsable,Old.ocupacion_id,Old.lugartrabajoestudio,Old.enfermedaddiscapacidad,Old.enfermedaddiscapacidaddetalle, OLD.usuario_modi,NOW(), 1)
//
DELIMITER ;
DROP TRIGGER IF EXISTS `tr_alumnosfamiliares_modi_log`;
DELIMITER //
CREATE TRIGGER `tr_alumnosfamiliares_modi_log` AFTER UPDATE ON `alumnosfamiliares`
 FOR EACH ROW insert into aud_alumnosfamiliares_log (id,persona_id,alumno_id,relacionfamiliar_id,responsable,ocupacion_id,lugartrabajoestudio,enfermedaddiscapacidad,enfermedaddiscapacidaddetalle,usuario,fecha,modi)
values (OLD.id,Old.persona_id,Old.alumno_id,Old.relacionfamiliar_id,Old.responsable,Old.ocupacion_id,Old.lugartrabajoestudio,Old.enfermedaddiscapacidad,Old.enfermedaddiscapacidaddetalle,NEW.usuario_modi,NOW(), 1)
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnoslegajos`
--

CREATE TABLE IF NOT EXISTS `alumnoslegajos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `alumno_id` int(10) unsigned NOT NULL,
  `dni` tinyint(1) NOT NULL DEFAULT '0',
  `foto` tinyint(4) NOT NULL DEFAULT '0',
  `partidanacimiento` tinyint(1) NOT NULL DEFAULT '0',
  `certificadobuenasalud` tinyint(1) NOT NULL DEFAULT '0',
  `certificadovacinacion` tinyint(1) NOT NULL DEFAULT '0',
  `fichapreinscripcion` tinyint(1) NOT NULL DEFAULT '0',
  `titulosecundario` tinyint(1) NOT NULL DEFAULT '0',
  `constitulotramite` tinyint(1) NOT NULL DEFAULT '0',
  `constanciatrabajo` tinyint(1) NOT NULL DEFAULT '0',
  `otros` tinyint(1) NOT NULL DEFAULT '0',
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `alumnoslegajos_alumno_id_foreign` (`alumno_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=74 ;

--
-- Volcado de datos para la tabla `alumnoslegajos`
--

INSERT INTO `alumnoslegajos` (`id`, `alumno_id`, `dni`, `foto`, `partidanacimiento`, `certificadobuenasalud`, `certificadovacinacion`, `fichapreinscripcion`, `titulosecundario`, `constitulotramite`, `constanciatrabajo`, `otros`, `usuario_alta`, `fecha_alta`, `usuario_modi`, `fecha_modi`, `created_at`, `updated_at`) VALUES
(41, 41, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'admin', '2015-03-25 00:00:00', NULL, NULL, '2015-03-25 12:07:31', '2015-03-25 12:07:31'),
(42, 42, 1, 0, 1, 1, 1, 1, 1, 0, 0, 0, 'admin', '2015-03-27 00:00:00', NULL, NULL, '2015-03-27 17:12:27', '2015-03-31 15:05:35'),
(43, 43, 1, 1, 1, 0, 1, 1, 1, 0, 0, 0, 'alovera', '2015-03-31 00:00:00', NULL, NULL, '2015-03-31 14:51:06', '2015-03-31 15:20:11'),
(44, 44, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 'dgomez', '2015-03-31 00:00:00', NULL, NULL, '2015-03-31 15:17:58', '2015-03-31 15:25:15'),
(45, 45, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 'dgomez', '2015-03-31 00:00:00', NULL, NULL, '2015-03-31 15:31:51', '2015-03-31 15:33:01'),
(46, 46, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'dgomez', '2015-03-31 00:00:00', NULL, NULL, '2015-03-31 15:40:00', '2015-03-31 15:40:00'),
(47, 47, 1, 0, 1, 1, 1, 1, 1, 0, 0, 0, 'dgomez', '2015-03-31 00:00:00', NULL, NULL, '2015-03-31 16:00:04', '2015-03-31 16:09:08'),
(48, 48, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 'dgomez', '2015-03-31 00:00:00', NULL, NULL, '2015-03-31 16:17:26', '2015-03-31 16:25:34'),
(49, 49, 1, 1, 1, 1, 1, 0, 1, 0, 0, 0, 'dgomez', '2015-03-31 00:00:00', NULL, NULL, '2015-03-31 16:37:03', '2015-03-31 16:38:11'),
(50, 50, 1, 1, 1, 1, 1, 1, 1, 0, 1, 0, 'mcandia', '2015-03-31 00:00:00', NULL, NULL, '2015-03-31 22:39:30', '2015-03-31 22:44:55'),
(51, 51, 1, 1, 1, 1, 0, 1, 1, 0, 1, 0, 'mcandia', '2015-03-31 00:00:00', NULL, NULL, '2015-03-31 22:42:47', '2015-03-31 22:44:40'),
(52, 52, 1, 1, 1, 1, 0, 1, 1, 0, 0, 0, 'mcandia', '2015-03-31 00:00:00', NULL, NULL, '2015-03-31 23:05:57', '2015-03-31 23:11:01'),
(53, 53, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 'mcandia', '2015-03-31 00:00:00', NULL, NULL, '2015-03-31 23:19:02', '2015-03-31 23:20:03'),
(54, 54, 1, 1, 1, 0, 1, 1, 0, 0, 0, 0, 'mcandia', '2015-03-31 00:00:00', NULL, NULL, '2015-03-31 23:26:29', '2015-03-31 23:28:39'),
(55, 55, 1, 1, 1, 0, 0, 1, 1, 0, 0, 0, 'mcandia', '2015-03-31 00:00:00', NULL, NULL, '2015-03-31 23:39:53', '2015-03-31 23:43:20'),
(56, 56, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 'mcandia', '2015-03-31 00:00:00', NULL, NULL, '2015-03-31 23:51:27', '2015-05-21 17:09:56'),
(57, 57, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 'mcandia', '2015-03-31 00:00:00', NULL, NULL, '2015-03-31 23:59:21', '2015-04-01 00:03:45'),
(58, 58, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 'mcandia', '2015-04-01 00:00:00', NULL, NULL, '2015-04-01 00:15:44', '2015-07-27 18:16:52'),
(59, 59, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 'mcandia', '2015-04-01 00:00:00', NULL, NULL, '2015-04-01 00:15:57', '2015-07-08 11:45:53'),
(60, 60, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 'mcandia', '2015-04-01 00:00:00', NULL, NULL, '2015-04-01 00:33:22', '2015-04-01 00:40:54'),
(61, 61, 1, 1, 0, 1, 1, 1, 1, 0, 0, 0, 'mcandia', '2015-04-01 00:00:00', NULL, NULL, '2015-04-01 00:45:59', '2015-04-01 00:48:23'),
(62, 62, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 'mcandia', '2015-04-01 00:00:00', NULL, NULL, '2015-04-01 00:56:01', '2015-04-01 00:58:00'),
(63, 63, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 'mcandia', '2015-04-01 00:00:00', NULL, NULL, '2015-04-01 01:03:30', '2015-07-08 17:34:55'),
(64, 64, 1, 1, 1, 1, 0, 1, 1, 0, 0, 0, 'mcandia', '2015-04-01 00:00:00', NULL, NULL, '2015-04-01 01:10:34', '2015-04-01 01:12:48'),
(65, 65, 1, 1, 0, 1, 1, 1, 1, 0, 0, 0, 'mcandia', '2015-04-01 00:00:00', NULL, NULL, '2015-04-01 01:18:38', '2015-05-27 14:04:50'),
(66, 66, 1, 1, 1, 1, 1, 1, 1, 0, 1, 0, 'dgomez', '2015-04-01 00:00:00', NULL, NULL, '2015-04-01 15:30:20', '2015-04-30 14:37:43'),
(67, 67, 1, 1, 1, 1, 1, 0, 1, 0, 0, 0, 'dgomez', '2015-04-01 00:00:00', NULL, NULL, '2015-04-01 15:44:48', '2015-04-01 15:46:14'),
(68, 68, 0, 1, 1, 1, 1, 1, 1, 0, 0, 0, 'dgomez', '2015-04-01 00:00:00', NULL, NULL, '2015-04-01 15:55:14', '2015-04-01 15:56:42'),
(69, 69, 1, 1, 1, 1, 1, 0, 1, 0, 0, 0, 'dgomez', '2015-04-01 00:00:00', NULL, NULL, '2015-04-01 16:01:58', '2015-04-01 16:03:47'),
(70, 70, 1, 0, 1, 1, 1, 0, 0, 0, 0, 0, 'dgomez', '2015-04-01 00:00:00', NULL, NULL, '2015-04-01 16:17:56', '2015-04-01 16:18:48'),
(71, 71, 1, 1, 1, 1, 1, 1, 0, 0, 1, 1, 'admin', '2015-04-07 00:00:00', NULL, NULL, '2015-04-07 12:43:41', '2015-07-08 12:30:47'),
(72, 72, 0, 0, 0, 0, 0, 0, 1, 1, 1, 0, 'admin', '2015-06-16 00:00:00', NULL, NULL, '2015-06-16 13:40:59', '2015-07-17 15:06:35'),
(73, 73, 1, 1, 1, 0, 1, 0, 1, 0, 0, 0, 'admin', '2015-07-28 00:00:00', NULL, NULL, '2015-07-28 11:16:04', '2015-07-29 13:42:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnoslegajosdocumentos`
--

CREATE TABLE IF NOT EXISTS `alumnoslegajosdocumentos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `alumnolegajo_id` int(10) unsigned NOT NULL,
  `tipodocumento` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `documento` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `alumnoslegajosdocumentos_alumnolegajo_id_foreign` (`alumnolegajo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=19 ;

--
-- Volcado de datos para la tabla `alumnoslegajosdocumentos`
--

INSERT INTO `alumnoslegajosdocumentos` (`id`, `alumnolegajo_id`, `tipodocumento`, `documento`, `usuario_alta`, `fecha_alta`, `usuario_modi`, `fecha_modi`, `created_at`, `updated_at`) VALUES
(15, 71, 'Fotocopia de título', '71_71_554938b3635c5.jpg', 'admin', '2015-05-05 00:00:00', NULL, NULL, '2015-05-05 21:40:04', '2015-05-27 14:12:19'),
(16, 68, 'Fotocopia DNI', '68_68_5559faaa571e4.jpg', 'admin', '2015-05-18 00:00:00', NULL, NULL, '2015-05-18 14:43:54', '2015-05-18 14:43:54'),
(17, 48, 'Fotocopia certificado de vacunación', '48_48_555dd2b18dba5.jpg', 'admin', '2015-05-21 00:00:00', NULL, NULL, '2015-05-21 12:42:25', '2015-05-21 12:42:25'),
(18, 71, 'Fotocopia DNI', '71_71_5565cf75c6efa.jpg', 'admin', '2015-05-27 00:00:00', NULL, NULL, '2015-05-27 14:06:45', '2015-05-27 14:06:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno_carrera`
--

CREATE TABLE IF NOT EXISTS `alumno_carrera` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `alumno_id` int(10) unsigned NOT NULL,
  `carrera_id` int(10) unsigned DEFAULT NULL,
  `ciclolectivo_id` int(10) unsigned DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `alumno_carrera_alumno_id_foreign` (`alumno_id`),
  KEY `alumno_carrera_carrera_id_foreign` (`carrera_id`),
  KEY `alumno_carrera_ciclolectivo_id_foreign` (`ciclolectivo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=81 ;

--
-- Volcado de datos para la tabla `alumno_carrera`
--

INSERT INTO `alumno_carrera` (`id`, `alumno_id`, `carrera_id`, `ciclolectivo_id`, `activo`, `usuario_alta`, `fecha_alta`, `usuario_modi`, `fecha_modi`, `created_at`, `updated_at`) VALUES
(53, 59, 28, 7, 1, 'admin', '2015-04-01 00:00:00', NULL, NULL, '2015-04-01 21:56:07', '2015-04-01 21:56:07'),
(54, 65, 28, 7, 1, 'admin', '2015-04-01 00:00:00', NULL, NULL, '2015-04-01 21:57:59', '2015-04-01 21:57:59'),
(55, 53, 32, 7, 1, 'admin', '2015-04-06 00:00:00', NULL, NULL, '2015-04-06 17:55:49', '2015-04-06 17:55:49'),
(56, 58, 30, 7, 1, 'admin', '2015-04-06 00:00:00', NULL, NULL, '2015-04-06 17:57:00', '2015-04-06 17:57:00'),
(57, 52, 31, 7, 1, 'admin', '2015-04-06 00:00:00', NULL, NULL, '2015-04-06 17:57:10', '2015-04-06 17:57:10'),
(58, 55, 29, 7, 1, 'admin', '2015-04-06 00:00:00', NULL, NULL, '2015-04-06 17:57:49', '2015-04-06 17:57:49'),
(59, 50, 28, 7, 1, 'admin', '2015-04-07 00:00:00', NULL, NULL, '2015-04-07 11:55:25', '2015-04-07 11:55:25'),
(60, 45, 28, 7, 1, 'admin', '2015-04-14 00:00:00', NULL, NULL, '2015-04-14 15:16:43', '2015-04-14 15:16:43'),
(61, 68, 28, 7, 1, 'admin', '2015-04-14 00:00:00', NULL, NULL, '2015-04-14 15:16:58', '2015-04-14 15:16:58'),
(63, 44, 28, 8, 1, 'admin', '2015-04-16 00:00:00', NULL, NULL, '2015-04-16 15:20:25', '2015-04-16 15:20:25'),
(64, 61, 28, 8, 1, 'admin', '2015-04-22 00:00:00', NULL, NULL, '2015-04-22 13:10:54', '2015-04-22 13:10:54'),
(65, 63, 28, 8, 1, 'admin', '2015-04-23 00:00:00', NULL, NULL, '2015-04-23 14:49:13', '2015-04-23 14:49:13'),
(66, 51, 28, 8, 1, 'admin', '2015-04-23 00:00:00', NULL, NULL, '2015-04-23 14:49:21', '2015-04-23 14:49:21'),
(67, 66, 28, 8, 1, 'admin', '2015-04-23 00:00:00', NULL, NULL, '2015-04-23 14:49:37', '2015-04-23 14:49:37'),
(68, 48, 28, 8, 1, 'admin', '2015-04-23 00:00:00', NULL, NULL, '2015-04-23 14:49:44', '2015-04-23 14:49:44'),
(69, 64, 29, 8, 1, 'admin', '2015-04-23 00:00:00', NULL, NULL, '2015-04-23 14:50:06', '2015-04-23 14:50:06'),
(71, 43, 29, 8, 1, 'admin', '2015-04-23 00:00:00', NULL, NULL, '2015-04-23 14:50:25', '2015-04-23 14:50:25'),
(72, 54, 30, 8, 1, 'admin', '2015-04-23 00:00:00', NULL, NULL, '2015-04-23 14:50:37', '2015-04-23 14:50:37'),
(73, 41, 30, 8, 1, 'admin', '2015-04-23 00:00:00', NULL, NULL, '2015-04-23 14:50:46', '2015-04-23 14:50:46'),
(74, 67, 30, 8, 1, 'admin', '2015-04-23 00:00:00', NULL, NULL, '2015-04-23 14:50:55', '2015-04-23 14:50:55'),
(75, 71, 32, 7, 1, 'admin', '2015-04-28 00:00:00', NULL, NULL, '2015-04-28 15:36:08', '2015-04-28 15:36:08'),
(76, 56, 34, 7, 1, 'admin', '2015-05-21 00:00:00', NULL, NULL, '2015-05-21 17:10:42', '2015-05-21 17:10:42'),
(77, 62, 28, 7, 1, 'admin', '2015-06-04 00:00:00', NULL, NULL, '2015-06-04 14:43:48', '2015-06-04 14:43:48'),
(78, 72, 28, 7, 1, 'admin', '2015-06-18 00:00:00', NULL, NULL, '2015-06-18 17:51:54', '2015-06-18 17:51:54'),
(80, 73, 32, 7, 1, 'admin', '2015-07-28 00:00:00', NULL, NULL, '2015-07-28 13:46:31', '2015-07-28 13:46:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areasocupacionales`
--

CREATE TABLE IF NOT EXISTS `areasocupacionales` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `areasocupacionales`
--

INSERT INTO `areasocupacionales` (`id`, `descripcion`, `usuario_alta`, `fecha_alta`, `usuario_modi`, `fecha_modi`, `created_at`, `updated_at`) VALUES
(1, 'Sistema de Salúd Pública', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Sistema de Salud Privada', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Disparadores `areasocupacionales`
--
DROP TRIGGER IF EXISTS `tr_areasocupacionales_baja_log`;
DELIMITER //
CREATE TRIGGER `tr_areasocupacionales_baja_log` AFTER DELETE ON `areasocupacionales`
 FOR EACH ROW insert into aud_areasocupacionales_log (id,descripcion,usuario,fecha,baja)
values (OLD.id,OLD.descripcion,OLD.usuario_modi,NOW(), 1)
//
DELIMITER ;
DROP TRIGGER IF EXISTS `tr_areasocupacionales_modi_log`;
DELIMITER //
CREATE TRIGGER `tr_areasocupacionales_modi_log` AFTER UPDATE ON `areasocupacionales`
 FOR EACH ROW insert into aud_areasocupacionales_log (id,descripcion,usuario,fecha,modi)
values (OLD.id,OLD.descripcion,NEW.usuario_modi,NOW(), 1)
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aud_alumnosfamiliares_log`
--

CREATE TABLE IF NOT EXISTS `aud_alumnosfamiliares_log` (
  `id` int(10) NOT NULL,
  `persona_id` int(10) DEFAULT NULL,
  `alumno_id` int(10) DEFAULT NULL,
  `relacionfamiliar_id` int(10) DEFAULT NULL,
  `responsable` tinyint(1) DEFAULT NULL,
  `ocupacion_id` int(10) DEFAULT NULL,
  `lugartrabajoestudio` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `enfermedaddiscapacidad` tinyint(1) DEFAULT NULL,
  `enfermedaddiscapacidaddetalle` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aud_alumnos_log`
--

CREATE TABLE IF NOT EXISTS `aud_alumnos_log` (
  `id` int(11) NOT NULL,
  `persona_id` int(11) DEFAULT NULL,
  `nrolegajo` int(11) DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `becado` tinyint(1) DEFAULT NULL,
  `fechaingreso` timestamp NULL DEFAULT NULL,
  `fechaegreso` timestamp NULL DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `aud_alumnos_log`
--

INSERT INTO `aud_alumnos_log` (`id`, `persona_id`, `nrolegajo`, `foto`, `activo`, `becado`, `fechaingreso`, `fechaegreso`, `usuario`, `fecha`, `modi`, `baja`) VALUES
(1, 2, 25812475, NULL, 1, 0, '2014-04-01 03:00:00', NULL, NULL, '2015-01-22 19:12:43', 1, NULL),
(1, 2, 25812475, NULL, 1, 0, '2014-04-01 03:00:00', NULL, NULL, '2015-01-26 11:38:53', 1, NULL),
(1, 2, 25812475, '2_25.812.475.jpg', 1, 0, '2014-04-01 03:00:00', NULL, NULL, '2015-01-26 11:41:07', 1, NULL),
(1, 2, 25812475, '2_25.812.475.jpg', 1, 0, '2014-04-01 03:00:00', NULL, NULL, '2015-01-26 11:46:18', 1, NULL),
(1, 2, 25812475, '2_25.812.475.jpg', 1, 0, '2014-04-01 03:00:00', NULL, NULL, '2015-01-26 11:47:28', 1, NULL),
(1, 2, 25812475, '2_25.812.475.jpg', 1, 0, '2014-04-01 03:00:00', NULL, NULL, '2015-01-26 11:47:45', 1, NULL),
(5, 6, 2566625, NULL, 1, 0, '2015-02-01 00:00:00', NULL, NULL, '2015-02-05 18:44:40', 1, NULL),
(4, 5, 25228692, NULL, 1, 0, '1976-05-01 00:00:00', NULL, NULL, '2015-02-05 18:45:31', 1, NULL),
(5, 6, 2566625, '6_25.666.25_.jpg', 1, 0, '2015-02-01 00:00:00', NULL, NULL, '2015-02-05 18:47:29', 1, NULL),
(4, 5, 25228692, '5_25.228.692.jpg', 1, 0, '1976-05-01 00:00:00', NULL, NULL, '2015-02-05 18:47:47', 1, NULL),
(5, 6, 2566625, '6_25.666.25_.jpg', 1, 0, '2015-02-01 00:00:00', NULL, NULL, '2015-02-05 18:47:49', 1, NULL),
(4, 5, 25228692, '5_25.228.692.jpg', 1, 0, '1976-05-01 00:00:00', NULL, NULL, '2015-02-05 18:50:08', 1, NULL),
(6, 7, 3809522, '7_38.095.22_.jpg', 1, 0, '2020-03-01 00:00:00', NULL, NULL, '2015-02-06 12:16:02', 1, NULL),
(6, 7, 3809522, '7_38.095.22_.jpg', 1, 0, '2020-03-01 00:00:00', NULL, NULL, '2015-02-06 12:16:10', 1, NULL),
(6, 7, 3809522, '7_38.095.22_.jpg', 1, 0, '2020-03-01 00:00:00', NULL, NULL, '2015-02-06 12:20:20', 1, NULL),
(6, 7, 3809522, '7_38.095.22_.jpg', 1, 0, '2020-03-01 00:00:00', NULL, NULL, '2015-02-06 12:20:46', 1, NULL),
(6, 7, 3809522, '7_38.095.22_.jpg', 1, 0, '2020-03-01 00:00:00', NULL, NULL, '2015-02-06 12:21:28', 1, NULL),
(6, 7, 3809522, '7_38.095.22_.jpg', 1, 0, '2020-03-01 00:00:00', NULL, NULL, '2015-02-06 12:23:22', 1, NULL),
(6, 7, 3809522, '7_38.095.22_.jpg', 1, 0, '2020-03-01 00:00:00', NULL, NULL, '2015-02-06 12:23:53', 1, NULL),
(6, 7, 3809522, '7_38.095.22_.jpg', 1, 0, '2020-03-01 00:00:00', NULL, NULL, '2015-02-06 12:24:08', 1, NULL),
(6, 7, 3809522, '7_38.095.22_.jpg', 1, 0, '2020-03-01 00:00:00', NULL, NULL, '2015-02-06 12:24:34', 1, NULL),
(6, 7, 3809522, '7_38.095.22_.jpg', 1, 0, '2020-03-01 00:00:00', NULL, NULL, '2015-02-06 12:25:02', 1, NULL),
(7, 8, 11252555, NULL, 1, 0, '2015-02-01 00:00:00', NULL, NULL, '2015-02-06 12:47:53', 1, NULL),
(10, 11, 14141414, NULL, 1, 0, '0000-00-00 00:00:00', NULL, NULL, '2015-02-06 12:50:38', 1, NULL),
(9, 10, 14141441, NULL, 1, 0, '0000-00-00 00:00:00', NULL, NULL, '2015-02-06 12:51:32', 1, NULL),
(9, 10, 14141441, NULL, 1, 0, '0000-00-00 00:00:00', NULL, NULL, '2015-02-06 12:51:44', 1, NULL),
(9, 10, 14141441, NULL, 1, 0, '0000-00-00 00:00:00', NULL, NULL, '2015-02-06 12:52:58', 1, NULL),
(9, 10, 14141441, NULL, 1, 0, '2015-10-10 00:00:00', NULL, NULL, '2015-02-06 12:53:32', 1, NULL),
(9, 10, 14141441, NULL, 1, 0, '2015-10-10 00:00:00', NULL, NULL, '2015-02-06 12:54:08', 1, NULL),
(9, 10, 14141441, NULL, 1, 0, '2015-10-10 00:00:00', NULL, NULL, '2015-02-06 12:54:16', 1, NULL),
(9, 10, 14141441, NULL, 1, 0, '2015-10-10 00:00:00', NULL, NULL, '2015-02-06 12:55:05', 1, NULL),
(12, 13, 21111111, NULL, 1, 0, '2015-11-14 00:00:00', NULL, NULL, '2015-02-06 13:13:32', 1, NULL),
(12, 13, 21111111, NULL, 1, 0, '2015-11-14 00:00:00', NULL, NULL, '2015-02-06 13:15:20', 1, NULL),
(12, 13, 21111111, NULL, 1, 0, '2015-11-14 00:00:00', NULL, NULL, '2015-02-06 13:18:30', 1, NULL),
(13, 14, 32323232, NULL, 1, 0, '2015-01-01 00:00:00', NULL, NULL, '2015-02-06 13:19:24', 1, NULL),
(13, 14, 32323232, NULL, 1, 0, '2015-01-01 00:00:00', NULL, NULL, '2015-02-06 13:26:36', 1, NULL),
(8, 9, 14114588, NULL, 1, 0, '0000-00-00 00:00:00', NULL, NULL, '2015-02-07 12:20:21', 1, NULL),
(7, 8, 11252555, '8_11.252.555.jpg', 1, 0, '2015-02-01 00:00:00', NULL, NULL, '2015-02-09 10:24:25', 1, NULL),
(8, 9, 14114588, NULL, 1, 0, '2014-02-01 00:00:00', NULL, NULL, '2015-02-09 10:32:57', 1, NULL),
(10, 11, 14141414, NULL, 1, 0, '0000-00-00 00:00:00', NULL, NULL, '2015-02-09 10:33:51', 1, NULL),
(10, 11, 14141414, NULL, 1, 0, '2015-01-15 00:00:00', NULL, NULL, '2015-02-09 10:34:19', 1, NULL),
(11, 12, 35252525, NULL, 1, 0, '2015-02-01 00:00:00', NULL, NULL, '2015-02-09 10:34:37', 1, NULL),
(11, 12, 35252525, NULL, 1, 0, '2015-02-01 00:00:00', NULL, NULL, '2015-02-09 10:35:37', 1, NULL),
(11, 12, 35252525, NULL, 1, 0, '2015-02-01 00:00:00', NULL, NULL, '2015-02-09 10:36:04', 1, NULL),
(9, 10, 14141441, NULL, 1, 0, '0000-00-00 00:00:00', NULL, NULL, '2015-02-09 10:36:41', 1, NULL),
(13, 14, 32323232, NULL, 1, 0, '2015-01-01 00:00:00', NULL, NULL, '2015-02-09 10:37:00', 1, NULL),
(13, 14, 32323232, NULL, 1, 0, '2015-01-01 00:00:00', NULL, NULL, '2015-02-09 10:37:14', 1, NULL),
(3, 4, 26888987, NULL, 1, 0, '2020-03-03 00:00:00', NULL, NULL, '2015-02-09 10:37:34', 1, NULL),
(14, 15, 25696871, NULL, 1, 0, '2015-01-01 00:00:00', NULL, NULL, '2015-02-09 10:38:07', 1, NULL),
(5, 6, 2566625, '6_25.666.25_.jpg', 1, 0, '2015-02-01 00:00:00', NULL, NULL, '2015-02-09 10:40:07', 1, NULL),
(5, 6, 2566625, '6_25.666.25_.jpg', 1, 0, '2015-02-01 00:00:00', NULL, NULL, '2015-02-09 10:40:22', 1, NULL),
(12, 13, 21111111, NULL, 1, 0, '2015-11-14 00:00:00', NULL, NULL, '2015-02-09 10:42:11', 1, NULL),
(4, 5, 25228692, '5_25.228.692.jpg', 1, 0, '1976-05-01 00:00:00', NULL, NULL, '2015-02-09 10:42:39', 1, NULL),
(7, 8, 11252555, '8_11.252.555.jpg', 1, 0, '2015-02-01 00:00:00', NULL, NULL, '2015-02-09 10:43:06', 1, NULL),
(8, 9, 14114588, NULL, 1, 0, '2014-02-01 00:00:00', NULL, NULL, '2015-02-09 10:43:22', 1, NULL),
(11, 12, 35252525, NULL, 1, 0, '2015-02-01 00:00:00', NULL, NULL, '2015-02-09 10:43:33', 1, NULL),
(10, 11, 14141414, NULL, 1, 0, '2015-01-15 00:00:00', NULL, NULL, '2015-02-09 10:43:42', 1, NULL),
(1, 2, 25812475, '2_25.812.475.jpg', 1, 0, '2014-04-01 03:00:00', NULL, NULL, '2015-02-09 10:56:33', 1, NULL),
(1, 2, 25812475, '2_25.812.475.jpg', 1, 0, '2014-04-01 00:00:00', NULL, NULL, '2015-02-09 10:56:48', 1, NULL),
(1, 2, 25812475, '2_25.812.475.jpg', 1, 0, '2014-04-01 00:00:00', NULL, NULL, '2015-02-09 11:23:35', 1, NULL),
(1, 2, 25812475, '2_25.812.475.jpg', 1, 0, '2014-04-01 00:00:00', NULL, NULL, '2015-02-09 11:23:37', 1, NULL),
(7, 8, 11252555, '8_11.252.555.jpg', 1, 0, '2015-02-01 00:00:00', NULL, NULL, '2015-02-09 11:45:58', 1, NULL),
(7, 8, 11252555, '8_11.252.555.jpg', 1, 0, '2015-02-01 00:00:00', NULL, NULL, '2015-02-09 11:47:41', 1, NULL),
(16, 19, 25132326, NULL, 1, 0, '2015-02-15 00:00:00', NULL, NULL, '2015-02-09 11:51:39', 1, NULL),
(10, 11, 14141414, '11_14.141.414.jpg', 1, 0, '2015-01-15 00:00:00', NULL, NULL, '2015-02-09 11:59:45', 1, NULL),
(4, 5, 25228692, '5_25.228.692.jpg', 1, 0, '1976-05-01 00:00:00', NULL, NULL, '2015-02-09 12:17:58', 1, NULL),
(1, 2, 25812475, '2_25.812.475.jpg', 1, 0, '2014-04-01 00:00:00', NULL, NULL, '2015-02-09 12:18:43', 1, NULL),
(1, 2, 25812475, '2_25.812.475.jpg', 1, 0, '2014-04-01 00:00:00', NULL, NULL, '2015-02-09 12:18:46', 1, NULL),
(6, 7, 3809522, '7_38.095.22_.jpg', 1, 0, '2020-03-01 00:00:00', NULL, NULL, '2015-02-09 12:19:09', 1, NULL),
(5, 6, 2566625, '6_25.666.250.jpg', 1, 0, '2015-02-01 00:00:00', NULL, NULL, '2015-02-09 12:36:08', 1, NULL),
(1, 2, 25812475, '2_25.812.475.jpg', 1, 0, '2014-04-01 00:00:00', NULL, NULL, '2015-02-09 12:36:39', 1, NULL),
(1, 2, 25812475, '2_25.812.475.jpg', 1, 0, '2014-04-01 00:00:00', NULL, NULL, '2015-02-09 12:36:43', 1, NULL),
(7, 8, 11252555, '8_11.252.555.jpg', 1, 0, '2015-02-01 00:00:00', NULL, NULL, '2015-02-09 16:23:03', 1, NULL),
(7, 8, 11252555, '8_11.252.555.jpg', 1, 0, '2015-02-01 00:00:00', NULL, NULL, '2015-02-09 16:23:11', 1, NULL),
(9, 10, 14141441, NULL, 1, 0, '2015-01-15 00:00:00', NULL, NULL, '2015-02-09 16:23:43', 1, NULL),
(4, 5, 25228692, '5_25.228.692.jpg', 1, 0, '1976-05-01 00:00:00', NULL, NULL, '2015-02-09 16:24:00', 1, NULL),
(18, 21, 25362365, NULL, 1, 0, '2014-12-15 00:00:00', NULL, NULL, '2015-02-09 16:28:48', 1, NULL),
(10, 11, 14141414, '11_14.141.414.jpg', 1, 0, '2015-01-15 00:00:00', NULL, NULL, '2015-02-09 17:24:12', 1, NULL),
(10, 11, 14141414, '11_14.141.414.jpg', 1, 0, '2015-01-15 00:00:00', NULL, NULL, '2015-02-09 17:24:42', 1, NULL),
(10, 11, 14141414, '11_14.141.414.jpg', 1, 0, '2015-01-15 00:00:00', NULL, NULL, '2015-02-09 17:28:06', 1, NULL),
(7, 8, 11252555, '8_11.252.555.jpg', 1, 1, '2015-02-01 00:00:00', NULL, NULL, '2015-02-10 10:50:25', 1, NULL),
(7, 8, 11252555, '8_11.252.555.jpg', 1, 1, '2015-02-01 00:00:00', NULL, NULL, '2015-02-10 16:40:05', 1, NULL),
(7, 8, 11252555, '8_11.252.555.jpg', 1, 1, '2015-02-01 00:00:00', NULL, NULL, '2015-02-10 16:42:58', 1, NULL),
(7, 8, 11252555, '8_11.252.555.jpg', 1, 1, '2000-02-01 00:00:00', NULL, NULL, '2015-02-10 18:04:55', 1, NULL),
(19, 31, 123, NULL, 1, 0, '2015-01-12 00:00:00', NULL, NULL, '2015-02-11 10:37:46', 1, NULL),
(19, 31, 123, '31_123ASD.jpg', 1, 0, '2015-01-12 00:00:00', NULL, NULL, '2015-02-11 10:38:13', 1, NULL),
(19, 31, 123, '31_123ASD.jpg', 1, 0, '2015-01-12 00:00:00', NULL, NULL, '2015-02-11 10:38:29', 1, NULL),
(19, 31, 123, '31_123ASD.jpg', 1, 0, '2015-01-12 00:00:00', NULL, NULL, '2015-02-11 10:55:59', 1, NULL),
(7, 8, 11252555, '8_11.252.555.jpg', 1, 1, '2000-02-01 00:00:00', NULL, NULL, '2015-02-11 10:56:39', 1, NULL),
(20, 32, 32656987, NULL, 1, 0, '2014-12-12 00:00:00', NULL, NULL, '2015-02-11 11:10:54', 1, NULL),
(20, 32, 32656987, '32_32656987.jpg', 1, 0, '2014-12-12 00:00:00', NULL, NULL, '2015-02-11 11:11:36', 1, NULL),
(20, 32, 0, '32_32656987.jpg', 1, 0, '2014-12-12 00:00:00', NULL, NULL, '2015-02-11 11:12:03', 1, NULL),
(20, 32, 0, '32_32656987.jpg', 1, 0, '2014-12-12 00:00:00', NULL, NULL, '2015-02-11 11:12:32', 1, NULL),
(15, 16, 25228693, NULL, 1, 0, '2015-01-01 00:00:00', NULL, NULL, '2015-02-11 11:14:00', 1, NULL),
(15, 16, 25228693, NULL, 1, 0, '2015-01-01 00:00:00', NULL, NULL, '2015-02-11 11:14:08', 1, NULL),
(20, 32, 12356, '32_32656987.jpg', 1, 0, '2014-12-12 00:00:00', NULL, NULL, '2015-02-11 11:14:16', NULL, 1),
(17, 20, 25323365, NULL, 1, 0, '2015-05-25 00:00:00', NULL, NULL, '2015-02-11 11:14:37', NULL, 1),
(19, 31, 1231236, '31_123ASD.jpg', 1, 0, '2015-01-12 00:00:00', NULL, NULL, '2015-02-11 11:15:31', 1, NULL),
(5, 6, 2566625, '6_25.666.250.jpg', 1, 0, '2015-02-01 00:00:00', NULL, NULL, '2015-02-11 11:16:23', 1, NULL),
(5, 6, 0, '6_25.666.250.jpg', 1, 0, '2015-02-01 00:00:00', NULL, NULL, '2015-02-11 11:20:33', 1, NULL),
(19, 31, 0, '31_123ASD.jpg', 1, 0, '2015-01-12 00:00:00', NULL, NULL, '2015-02-11 11:20:41', 1, NULL),
(8, 9, 14114588, '9_14.114.588.jpg', 1, 0, '2014-02-01 00:00:00', NULL, NULL, '2015-02-11 12:04:11', 1, NULL),
(8, 9, 14114588, '9_14.114.588.jpg', 1, 0, '2014-02-01 00:00:00', NULL, NULL, '2015-02-11 12:04:16', 1, NULL),
(10, 11, 14141414, '11_14.141.414.jpg', 1, 0, '2015-01-15 00:00:00', NULL, NULL, '2015-02-11 12:04:26', 1, NULL),
(10, 11, 1236326, '11_14.141.414.jpg', 1, 0, '2015-01-15 00:00:00', NULL, NULL, '2015-02-11 12:04:44', 1, NULL),
(16, 19, 25132326, NULL, 1, 0, '2015-02-15 00:00:00', NULL, NULL, '2015-02-11 13:32:59', 1, NULL),
(16, 19, 25132326, NULL, 1, 0, '2015-02-15 00:00:00', NULL, NULL, '2015-02-11 13:48:09', 1, NULL),
(8, 9, 1411458, '9_14.114.588.jpg', 1, 0, '2014-02-01 00:00:00', NULL, NULL, '2015-02-11 13:51:16', 1, NULL),
(3, 4, 26888987, NULL, 1, 0, '2020-03-03 00:00:00', NULL, NULL, '2015-02-11 14:42:21', 1, NULL),
(8, 9, 1411458, '9_14.114.588.jpg', 0, 0, '2014-02-01 00:00:00', NULL, NULL, '2015-02-12 12:09:22', 1, NULL),
(22, 39, 32569781, NULL, 1, 0, '2014-01-25 00:00:00', NULL, NULL, '2015-02-12 13:44:39', 1, NULL),
(8, 9, 1411458, '9_14.114.588.jpg', 1, 0, '2014-02-01 00:00:00', NULL, NULL, '2015-02-12 13:51:31', 1, NULL),
(8, 9, 1411458, '9_14.114.588.jpg', 1, 0, '2014-02-01 00:00:00', NULL, NULL, '2015-02-12 13:51:40', 1, NULL),
(23, 42, 13112312, NULL, 1, 0, '2012-11-13 00:00:00', NULL, NULL, '2015-02-12 13:52:19', NULL, 1),
(3, 4, 26888987, '4_26888987.jpg', 1, 0, '2020-03-03 00:00:00', NULL, NULL, '2015-02-12 14:29:11', NULL, 1),
(22, 39, 32569781, '39_32569781.jpg', 1, 0, '2014-01-25 00:00:00', NULL, NULL, '2015-02-12 14:30:35', NULL, 1),
(8, 9, 1411458, '9_14.114.588.jpg', 1, 0, '2014-02-01 00:00:00', NULL, NULL, '2015-02-12 14:37:32', 1, NULL),
(19, 31, 0, '31_123ASD.jpg', 1, 0, '2015-01-12 00:00:00', NULL, NULL, '2015-02-12 18:27:23', 1, NULL),
(8, 9, 1411458, '9_14.114.588.jpg', 1, 0, '2014-02-01 00:00:00', NULL, NULL, '2015-02-19 11:10:35', 1, NULL),
(8, 9, 1411458, '9_14.114.588.jpg', 1, 0, '2014-02-01 00:00:00', NULL, NULL, '2015-02-19 11:11:33', 1, NULL),
(8, 9, 1411458, '9_14.114.588.jpg', 1, 0, '2015-02-01 00:00:00', NULL, NULL, '2015-02-19 11:12:08', 1, NULL),
(8, 9, 1411458, '9_14.114.588.jpg', 0, 0, '2015-02-01 00:00:00', NULL, NULL, '2015-02-19 11:55:13', 1, NULL),
(8, 9, 1411458, '9_14.114.588.jpg', 1, 0, '2015-02-01 00:00:00', NULL, NULL, '2015-02-24 12:06:21', 1, NULL),
(11, 12, 35252525, '12_35.252.525.jpg', 1, 0, '2015-02-01 00:00:00', NULL, NULL, '2015-02-24 12:08:50', 1, NULL),
(8, 9, 1411458, '9_14.114.588.jpg', 1, NULL, '2015-02-01 00:00:00', NULL, NULL, '2015-02-24 15:27:29', 1, NULL),
(11, 12, 35252525, '12_35.252.525.jpg', 1, NULL, '2015-02-01 00:00:00', NULL, NULL, '2015-02-25 13:13:18', 1, NULL),
(16, 19, 25132326, NULL, 1, NULL, '2015-02-15 00:00:00', NULL, NULL, '2015-02-25 13:16:22', 1, NULL),
(8, 9, 1411458, '9_14.114.588.jpg', 1, NULL, '2015-02-01 00:00:00', NULL, NULL, '2015-02-26 11:37:44', NULL, 1),
(9, 10, 14141441, '10_14.141.441.jpg', 1, NULL, '2015-01-15 00:00:00', NULL, NULL, '2015-02-26 11:39:53', NULL, 1),
(12, 13, 21111111, NULL, 1, NULL, '2015-11-14 00:00:00', NULL, NULL, '2015-02-26 11:40:07', NULL, 1),
(21, 34, 25132323, NULL, 1, NULL, '2014-12-12 00:00:00', NULL, NULL, '2015-02-26 11:44:19', NULL, 1),
(16, 19, 25132326, NULL, 1, NULL, '2015-02-15 00:00:00', NULL, NULL, '2015-02-26 11:46:05', NULL, 1),
(4, 5, 25228692, '5_25.228.692.jpg', 1, NULL, '1976-05-01 00:00:00', NULL, NULL, '2015-02-26 11:48:19', NULL, 1),
(15, 16, 25228693, '16_25228693.jpg', 1, NULL, '2015-01-01 00:00:00', NULL, NULL, '2015-02-26 11:49:16', NULL, 1),
(18, 21, 25362365, '21_25.362.365.jpg', 1, NULL, '2014-12-15 00:00:00', NULL, NULL, '2015-02-26 11:49:52', NULL, 1),
(14, 15, 25696871, NULL, 1, NULL, '2015-01-01 00:00:00', NULL, NULL, '2015-02-26 11:50:14', NULL, 1),
(1, 2, 25812475, '2_25.812.475.jpg', 1, NULL, '2014-04-01 00:00:00', NULL, NULL, '2015-02-26 11:50:18', NULL, 1),
(2, 3, 26211892, NULL, 1, NULL, '2016-03-01 00:00:00', NULL, NULL, '2015-02-26 11:50:25', NULL, 1),
(24, 47, 27299155, NULL, 1, NULL, '2014-03-01 00:00:00', NULL, NULL, '2015-02-26 11:55:07', NULL, 1),
(13, 14, 32323232, '14_32.323.232.jpg', 1, NULL, '2015-01-01 00:00:00', NULL, NULL, '2015-02-26 11:55:11', NULL, 1),
(7, 8, 3523632, '8_11.252.555.jpg', 1, NULL, '2000-02-01 00:00:00', NULL, NULL, '2015-02-26 11:55:15', NULL, 1),
(11, 12, 35252525, '12_35.252.525.jpg', 1, NULL, '2015-02-01 00:00:00', NULL, NULL, '2015-02-26 11:55:18', NULL, 1),
(6, 7, 3809522, '7_38.095.222.jpg', 1, NULL, '2020-03-01 00:00:00', NULL, NULL, '2015-02-26 11:55:22', NULL, 1),
(10, 11, 0, '11_14.141.414.jpg', 1, NULL, '2015-01-15 00:00:00', NULL, NULL, '2015-02-26 11:55:25', NULL, 1),
(19, 31, 0, '31_123ASD.jpg', 0, NULL, '2015-01-12 00:00:00', NULL, NULL, '2015-02-26 11:55:29', NULL, 1),
(5, 6, 0, '6_25.666.250.jpg', 1, NULL, '2015-02-01 00:00:00', NULL, NULL, '2015-02-26 11:55:33', NULL, 1),
(25, 52, 31691951, NULL, 1, NULL, '2014-12-12 00:00:00', NULL, NULL, '2015-02-26 12:40:55', 1, NULL),
(27, 54, 31691957, NULL, 1, NULL, '2014-12-12 00:00:00', NULL, NULL, '2015-02-26 12:41:05', 1, NULL),
(26, 53, 35687961, NULL, 1, NULL, '2014-02-12 00:00:00', NULL, NULL, '2015-02-26 12:41:17', 1, NULL),
(27, 54, 31691957, '54_31691957.jpg', 1, NULL, '2014-12-12 00:00:00', NULL, NULL, '2015-02-26 14:03:29', 1, NULL),
(26, 53, 35687961, '53_35687961.jpg', 1, NULL, '2014-02-12 00:00:00', NULL, NULL, '2015-02-26 14:37:01', 1, NULL),
(26, 53, 35687961, '53_35687961.jpg', 1, NULL, '2014-02-12 00:00:00', NULL, NULL, '2015-02-26 14:59:54', 1, NULL),
(29, 56, 252369789, NULL, 1, NULL, '2013-06-25 00:00:00', NULL, NULL, '2015-02-27 10:48:09', 1, NULL),
(29, 56, 252369789, NULL, 1, NULL, '2013-06-25 00:00:00', NULL, NULL, '2015-02-27 10:52:22', 1, NULL),
(29, 56, 252369789, NULL, 1, NULL, '2013-06-25 00:00:00', NULL, NULL, '2015-02-27 10:52:46', 1, NULL),
(30, 58, 32569789, NULL, 1, NULL, '2014-12-12 00:00:00', NULL, NULL, '2015-03-02 10:15:43', 1, NULL),
(31, 59, 23258963, NULL, 1, NULL, '2014-03-03 00:00:00', NULL, NULL, '2015-03-02 10:16:55', 1, NULL),
(30, 58, 32569789, NULL, 1, NULL, '2014-12-12 00:00:00', NULL, NULL, '2015-03-02 17:52:11', 1, NULL),
(25, 52, 31691951, '52_31691951.jpg', 1, NULL, '2014-12-12 00:00:00', NULL, NULL, '2015-03-02 18:29:33', 1, NULL),
(25, 52, 31691955, '52_31691951.jpg', 1, NULL, '2014-12-12 00:00:00', NULL, NULL, '2015-03-02 18:30:30', 1, NULL),
(25, 52, 31691955, '52_31691951.jpg', 1, NULL, '2014-12-12 00:00:00', NULL, NULL, '2015-03-02 18:31:25', 1, NULL),
(25, 52, 31691955, '52_31691951.jpg', 1, NULL, '2014-12-12 00:00:00', NULL, NULL, '2015-03-02 18:32:13', 1, NULL),
(25, 52, 3169195, '52_31691951.jpg', 1, NULL, '2014-12-12 00:00:00', NULL, NULL, '2015-03-02 18:35:30', 1, NULL),
(26, 53, 35687961, '53_35687961.jpg', 1, NULL, '2014-02-12 00:00:00', NULL, NULL, '2015-03-04 11:22:28', 1, NULL),
(26, 53, 35687961, '53_35687961.jpg', 1, NULL, '2014-02-12 00:00:00', NULL, NULL, '2015-03-04 11:22:40', 1, NULL),
(28, 55, 36256897, NULL, 1, NULL, '2014-02-12 00:00:00', NULL, NULL, '2015-03-04 13:44:47', 1, NULL),
(28, 55, 36256897, NULL, 1, NULL, '2014-02-12 00:00:00', NULL, NULL, '2015-03-04 13:45:01', 1, NULL),
(26, 53, 35687961, '53_35687961.jpg', 1, NULL, '2014-02-12 00:00:00', NULL, NULL, '2015-03-04 13:45:41', 1, NULL),
(29, 56, 252369789, '56_252369789.jpg', 1, NULL, '2013-06-25 00:00:00', NULL, NULL, '2015-03-04 13:46:27', 1, NULL),
(26, 53, 35687961, '53_35687961.jpg', 0, NULL, '2014-02-12 00:00:00', NULL, NULL, '2015-03-05 11:56:48', 1, NULL),
(26, 53, 35687961, '53_35687961.jpg', 0, NULL, '2014-02-12 00:00:00', NULL, NULL, '2015-03-05 11:57:00', 1, NULL),
(29, 56, 252369789, '56_252369789.jpg', 0, NULL, '2013-06-25 00:00:00', NULL, NULL, '2015-03-05 11:57:24', 1, NULL),
(29, 56, 252369789, '56_252369789.jpg', 1, NULL, '2013-06-25 00:00:00', NULL, NULL, '2015-03-05 12:21:59', 1, NULL),
(29, 56, 252369789, '56_252369789.jpg', 0, NULL, '2013-06-25 00:00:00', NULL, NULL, '2015-03-09 12:26:23', 1, NULL),
(29, 56, 252369789, '56_252369789.jpg', 1, NULL, '2013-06-25 00:00:00', NULL, NULL, '2015-03-09 12:26:30', 1, NULL),
(29, 56, 252369789, '56_252369789.jpg', 0, NULL, '2013-06-25 00:00:00', NULL, NULL, '2015-03-09 12:37:49', 1, NULL),
(33, 62, 2147483647, NULL, 1, NULL, '2014-03-12 00:00:00', NULL, 'bsegovia', '2015-03-10 13:52:07', 1, NULL),
(33, 62, 12345678, NULL, 1, NULL, '2014-03-12 00:00:00', NULL, 'esandoval', '2015-03-10 14:55:53', 1, NULL),
(29, 56, 252369789, '56_252369789.jpg', 1, NULL, '2013-06-25 00:00:00', NULL, 'bsegovia', '2015-03-11 12:43:17', 1, NULL),
(35, 66, 323222, NULL, 1, NULL, '2012-02-13 00:00:00', NULL, 'admin', '2015-03-12 14:20:47', 1, NULL),
(30, 58, 32569789, NULL, 1, NULL, '2014-12-12 00:00:00', NULL, 'admin', '2015-03-12 14:58:13', 1, NULL),
(30, 58, 32569789, NULL, 1, NULL, '2014-12-12 00:00:00', NULL, 'admin', '2015-03-12 14:59:05', 1, NULL),
(30, 58, 32569789, NULL, 1, NULL, '2014-12-12 00:00:00', NULL, 'admin', '2015-03-12 14:59:45', 1, NULL),
(29, 56, 252369789, '56_252369789.jpg', 0, NULL, '2013-06-25 00:00:00', NULL, 'admin', '2015-03-13 12:31:37', 1, NULL),
(25, 52, 31691955, '52_31691951.jpg', 1, NULL, '2014-12-12 00:00:00', NULL, NULL, '2015-03-13 12:32:24', NULL, 1),
(26, 53, 35687961, '53_35687961.jpg', 1, NULL, '2014-02-12 00:00:00', NULL, NULL, '2015-03-13 12:32:26', NULL, 1),
(35, 66, 1234565, NULL, 1, NULL, '2012-02-13 00:00:00', NULL, 'admin', '2015-03-13 12:32:29', NULL, 1),
(32, 60, 32658987, NULL, 1, NULL, '2015-02-12 00:00:00', NULL, NULL, '2015-03-13 12:32:44', NULL, 1),
(31, 59, 23258963, NULL, 1, NULL, '2014-03-03 00:00:00', NULL, NULL, '2015-03-13 12:32:46', NULL, 1),
(33, 62, 12345678, NULL, 1, NULL, '2014-03-12 00:00:00', NULL, 'esandoval', '2015-03-13 12:32:47', NULL, 1),
(34, 63, 25236987, NULL, 1, NULL, '2014-12-12 00:00:00', NULL, NULL, '2015-03-13 12:32:49', NULL, 1),
(30, 58, 32569789, NULL, 1, NULL, '2014-12-12 00:00:00', NULL, 'admin', '2015-03-13 12:32:50', NULL, 1),
(29, 56, 252369789, '56_252369789.jpg', 1, NULL, '2013-06-25 00:00:00', NULL, 'admin', '2015-03-13 12:32:52', NULL, 1),
(28, 55, 36256897, NULL, 1, NULL, '2014-02-12 00:00:00', NULL, NULL, '2015-03-13 12:32:54', NULL, 1),
(27, 54, 31691957, '54_31691957.jpg', 1, NULL, '2014-12-12 00:00:00', NULL, NULL, '2015-03-13 12:32:56', NULL, 1),
(37, 68, 25236981, NULL, 1, NULL, '2014-05-12 00:00:00', NULL, 'admin', '2015-03-16 11:37:00', 1, NULL),
(37, 68, 25236981, NULL, 1, NULL, '2014-05-12 00:00:00', NULL, 'bsegovia', '2015-03-18 11:42:39', 1, NULL),
(36, 67, 25236987, NULL, 1, NULL, '2014-03-15 00:00:00', NULL, 'bsegovia', '2015-03-18 11:42:48', 1, NULL),
(37, 68, 25236981, NULL, 1, NULL, '2014-05-12 00:00:00', NULL, 'bsegovia', '2015-03-18 13:35:22', 1, NULL),
(36, 67, 25236987, NULL, 1, NULL, '2014-03-15 00:00:00', NULL, 'bsegovia', '2015-03-18 13:35:50', 1, NULL),
(36, 67, 25236987, NULL, 1, NULL, '2014-03-15 00:00:00', NULL, 'bsegovia', '2015-03-18 13:36:05', 1, NULL),
(37, 68, 25236981, NULL, 1, NULL, '2014-05-12 00:00:00', NULL, 'admin', '2015-03-20 14:48:29', 1, NULL),
(36, 67, 25236987, NULL, 1, NULL, '2014-03-15 00:00:00', NULL, 'admin', '2015-03-20 14:48:39', 1, NULL),
(36, 67, 25236987, '67_25236987.jpg', 1, NULL, '2014-03-15 00:00:00', NULL, 'admin', '2015-03-25 11:32:54', 1, NULL),
(37, 68, 25236981, '68_25236981.jpg', 1, NULL, '2014-05-12 00:00:00', NULL, 'admin', '2015-03-25 11:33:09', 1, NULL),
(37, 68, 25236981, '68_25236981.jpg', 1, NULL, '2014-05-12 00:00:00', NULL, 'admin', '2015-03-25 11:35:11', NULL, 1),
(38, 70, 21321, '70_21321.jpg', 1, NULL, '2013-03-21 00:00:00', NULL, NULL, '2015-03-25 11:35:13', NULL, 1),
(39, 71, 131222132, '71_131222132.jpg', 1, NULL, '2012-11-13 00:00:00', NULL, NULL, '2015-03-25 11:35:15', NULL, 1),
(40, 72, 1321321, '72_1321321.jpg', 1, NULL, '2000-06-04 00:00:00', NULL, NULL, '2015-03-25 11:35:16', NULL, 1),
(36, 67, 25236987, '67_25236987.jpg', 1, NULL, '2014-03-15 00:00:00', NULL, 'admin', '2015-03-25 11:35:18', NULL, 1),
(42, 84, 22222222, NULL, 1, NULL, '2012-02-22 00:00:00', '2013-03-23 00:00:00', 'admin', '2015-03-27 17:21:15', 1, NULL),
(42, 84, 22222222, NULL, 1, NULL, '2012-02-22 00:00:00', '2013-03-23 00:00:00', 'admin', '2015-03-27 17:22:22', 1, NULL),
(42, 84, 22222222, NULL, 1, NULL, '2012-02-22 00:00:00', '2013-03-23 00:00:00', 'admin', '2015-03-30 12:22:47', 1, NULL),
(42, 84, 1234567, NULL, 1, NULL, '2012-02-22 00:00:00', '2013-03-23 00:00:00', 'alovera', '2015-03-30 13:17:51', 1, NULL),
(42, 84, 1234567, NULL, 1, NULL, '2012-02-22 00:00:00', NULL, 'alovera', '2015-03-30 13:17:58', 1, NULL),
(42, 84, 1234567, NULL, 1, NULL, '2012-02-22 00:00:00', NULL, 'alovera', '2015-03-30 13:18:08', 1, NULL),
(41, 75, 38576702, NULL, 1, NULL, '2015-02-01 00:00:00', NULL, 'admin', '2015-03-30 13:19:08', 1, NULL),
(42, 84, 1234567, NULL, 1, NULL, '2012-02-22 00:00:00', NULL, 'admin', '2015-03-30 14:48:56', 1, NULL),
(42, 84, 1234567, NULL, 1, NULL, '2012-02-22 00:00:00', NULL, 'admin', '2015-03-30 14:49:18', 1, NULL),
(42, 84, 1234567, NULL, 1, NULL, '2012-02-22 00:00:00', NULL, 'admin', '2015-03-30 14:49:28', 1, NULL),
(42, 84, 1234567, NULL, 1, NULL, '2012-02-22 00:00:00', NULL, 'admin', '2015-03-30 14:49:38', 1, NULL),
(42, 84, 1234567, NULL, 1, NULL, '2012-02-22 00:00:00', NULL, 'admin', '2015-03-30 14:49:58', 1, NULL),
(42, 84, 1234567, NULL, 1, NULL, '2012-02-22 00:00:00', NULL, 'admin', '2015-03-30 14:50:11', 1, NULL),
(42, 84, 1234567, NULL, 1, NULL, '2012-02-22 00:00:00', NULL, 'admin', '2015-03-30 14:50:17', 1, NULL),
(42, 84, 1234567, NULL, 1, NULL, '2012-02-22 00:00:00', NULL, 'admin', '2015-03-30 14:50:46', 1, NULL),
(42, 84, 1234567, NULL, 1, NULL, '2012-02-22 00:00:00', NULL, 'admin', '2015-03-30 14:50:51', 1, NULL),
(42, 84, 1234567, NULL, 1, NULL, '2012-02-22 00:00:00', NULL, 'admin', '2015-03-31 12:37:01', 1, NULL),
(42, 84, 1234567, NULL, 1, NULL, '2012-02-22 00:00:00', NULL, 'dgomez', '2015-03-31 15:01:17', 1, NULL),
(44, 87, 31865565, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'dgomez', '2015-03-31 15:22:46', 1, NULL),
(45, 88, 32234090, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'dgomez', '2015-03-31 15:33:19', 1, NULL),
(50, 93, 32048532, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'mcandia', '2015-03-31 22:42:00', 1, NULL),
(52, 95, 31071391, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'mcandia', '2015-03-31 23:09:28', 1, NULL),
(54, 97, 37911008, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'mcandia', '2015-03-31 23:27:17', 1, NULL),
(54, 97, 37911008, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'mcandia', '2015-03-31 23:32:23', 1, NULL),
(55, 98, 31091337, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'mcandia', '2015-03-31 23:42:08', 1, NULL),
(53, 96, 28781722, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'cdorrego', '2015-03-31 23:45:16', 1, NULL),
(56, 99, 38378916, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'mcandia', '2015-03-31 23:52:56', 1, NULL),
(57, 100, 38378917, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'mcandia', '2015-04-01 00:00:40', 1, NULL),
(57, 100, 38378917, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'mcandia', '2015-04-01 00:02:30', 1, NULL),
(56, 99, 38378916, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'mcandia', '2015-04-01 00:06:28', 1, NULL),
(59, 102, 22486262, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'mcandia', '2015-04-01 00:17:36', 1, NULL),
(60, 103, 37585626, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'mcandia', '2015-04-01 00:39:30', 1, NULL),
(61, 104, 35003057, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'mcandia', '2015-04-01 00:47:15', 1, NULL),
(62, 105, 36956567, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'mcandia', '2015-04-01 00:57:17', 1, NULL),
(63, 106, 31671507, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'mcandia', '2015-04-01 01:04:40', 1, NULL),
(64, 107, 36955802, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'mcandia', '2015-04-01 01:11:52', 1, NULL),
(65, 108, 24287653, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'mcandia', '2015-04-01 01:20:05', 1, NULL),
(50, 93, 32048532, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'cdorrego', '2015-04-01 12:59:11', 1, NULL),
(57, 100, 38378917, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'cdorrego', '2015-04-01 13:01:16', 1, NULL),
(57, 100, 38378917, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'cdorrego', '2015-04-01 13:11:29', 1, NULL),
(71, 114, 2532323, NULL, 1, NULL, '2012-03-12 00:00:00', NULL, 'admin', '2015-04-07 12:57:36', 1, NULL),
(50, 93, 32048532, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'admin', '2015-04-14 15:42:14', 1, NULL),
(44, 87, 31865565, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'admin', '2015-04-16 15:21:24', 1, NULL),
(71, 114, 2532323, NULL, 1, NULL, '2012-03-12 00:00:00', NULL, 'admin', '2015-04-21 15:14:18', 1, NULL),
(71, 114, 2532323, NULL, 1, NULL, '2012-03-12 00:00:00', NULL, 'admin', '2015-04-21 15:14:28', 1, NULL),
(71, 114, 2532323, NULL, 1, NULL, '2012-03-12 00:00:00', NULL, 'admin', '2015-04-21 15:15:43', 1, NULL),
(71, 114, 2532323, NULL, 1, NULL, '2012-03-12 00:00:00', NULL, 'admin', '2015-04-21 15:16:41', 1, NULL),
(71, 114, 2532323, NULL, 1, NULL, '2012-03-12 00:00:00', NULL, 'admin', '2015-05-14 12:30:23', 1, NULL),
(71, 114, 2532323, NULL, 0, NULL, '2012-03-12 00:00:00', NULL, 'admin', '2015-05-14 12:43:58', 1, NULL),
(61, 104, 35003057, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'admin', '2015-05-14 12:44:23', 1, NULL),
(45, 88, 32234090, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'admin', '2015-05-14 13:46:12', 1, NULL),
(55, 98, 31091337, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'admin', '2015-05-14 13:53:55', 1, NULL),
(55, 98, 31091337, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'admin', '2015-05-14 13:56:38', 1, NULL),
(55, 98, 31091337, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'admin', '2015-05-14 13:56:46', 1, NULL),
(55, 98, 31091337, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'admin', '2015-05-14 13:56:54', 1, NULL),
(55, 98, 31091337, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'admin', '2015-05-14 13:58:16', 1, NULL),
(55, 98, 31091337, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'admin', '2015-05-14 14:09:01', 1, NULL),
(55, 98, 31091337, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'admin', '2015-05-14 14:31:42', 1, NULL),
(50, 93, 32048532, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'admin', '2015-05-14 16:30:03', 1, NULL),
(68, 111, 399022687, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'admin', '2015-05-15 13:14:48', 1, NULL),
(45, 88, 32234090, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'admin', '2015-05-15 14:19:46', 1, NULL),
(71, 114, 2532323, NULL, 1, NULL, '2012-03-12 00:00:00', NULL, 'admin', '2015-05-19 14:58:03', 1, NULL),
(71, 114, 2532323, NULL, 1, NULL, '2012-03-12 00:00:00', NULL, 'admin', '2015-05-20 17:46:12', 1, NULL),
(59, 102, 22486262, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'admin', '2015-05-21 14:53:55', 1, NULL),
(59, 102, 22486262, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'admin', '2015-05-21 14:55:33', 1, NULL),
(56, 99, 38378916, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'admin', '2015-05-21 17:12:43', 1, NULL),
(71, 114, 2532323, NULL, 1, NULL, '2012-03-12 00:00:00', NULL, 'admin', '2015-05-26 11:23:59', 1, NULL),
(71, 114, 2532323, NULL, 1, NULL, '2012-03-12 00:00:00', NULL, 'admin', '2015-05-26 16:49:33', 1, NULL),
(71, 114, 2532323, '114_2532323.jpg', 1, NULL, '2012-03-12 00:00:00', NULL, 'admin', '2015-05-26 17:08:18', 1, NULL),
(63, 106, 31671507, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'admin', '2015-06-02 18:08:39', 1, NULL),
(71, 114, 2532323, '114_2532323.jpg', 1, NULL, '2012-03-12 00:00:00', NULL, 'admin', '2015-06-04 14:21:06', 1, NULL),
(70, 113, 39719162, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'admin', '2015-06-04 14:42:25', 1, NULL),
(46, 89, 40084936, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'admin', '2015-06-04 14:50:48', 1, NULL),
(71, 114, 2532323, '114_2532323.jpg', 1, NULL, '2012-03-12 00:00:00', NULL, 'admin', '2015-06-16 13:39:25', 1, NULL),
(71, 114, 2532323, '114_2532323.jpg', 1, NULL, '2012-03-12 00:00:00', NULL, 'admin', '2015-06-16 15:39:41', 1, NULL),
(62, 105, 36956567, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'admin', '2015-07-10 14:21:35', 1, NULL),
(61, 104, 35003057, NULL, 0, NULL, '2015-03-16 00:00:00', NULL, 'admin', '2015-07-10 14:43:12', 1, NULL),
(72, 115, 32159789, NULL, 1, NULL, '2014-06-12 00:00:00', NULL, 'admin', '2015-07-15 13:24:14', 1, NULL),
(61, 104, 35003057, NULL, 1, NULL, '2015-03-16 00:00:00', NULL, 'admin', '2015-07-27 18:16:06', 1, NULL),
(41, 75, 38576702, NULL, 1, NULL, '2015-02-01 00:00:00', NULL, 'admin', '2015-11-04 14:23:25', 1, NULL),
(41, 75, 38576702, NULL, 1, NULL, '2015-02-01 00:00:00', '2015-11-03 00:00:00', 'admin', '2015-11-04 14:23:33', 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aud_areasocupacionales_log`
--

CREATE TABLE IF NOT EXISTS `aud_areasocupacionales_log` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aud_barrios_log`
--

CREATE TABLE IF NOT EXISTS `aud_barrios_log` (
  `id` int(11) NOT NULL,
  `localidad_id` int(11) DEFAULT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `aud_barrios_log`
--

INSERT INTO `aud_barrios_log` (`id`, `localidad_id`, `descripcion`, `usuario`, `fecha`, `modi`, `baja`) VALUES
(40, 1, 'Otro', NULL, '2015-03-20 13:37:21', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aud_carreras_log`
--

CREATE TABLE IF NOT EXISTS `aud_carreras_log` (
  `id` int(11) NOT NULL,
  `organizacion_id` int(10) NOT NULL,
  `carrera` varchar(500) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nivel_educativo_id` int(10) DEFAULT NULL,
  `tipocarrera_id` int(10) DEFAULT NULL,
  `regimen_id` int(10) DEFAULT NULL,
  `tipoduracion_id` int(10) DEFAULT NULL,
  `duracion` int(11) DEFAULT NULL,
  `modalidad_id` int(10) DEFAULT NULL,
  `cargahorariacatedra` int(11) DEFAULT NULL,
  `cargahorariareloj` int(11) DEFAULT NULL,
  `areaocupacional_id` int(10) DEFAULT NULL,
  `activa` tinyint(1) DEFAULT NULL,
  `exameningreso` tinyint(1) DEFAULT NULL,
  `observaciones` varchar(8000) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aud_cicloslectivos_log`
--

CREATE TABLE IF NOT EXISTS `aud_cicloslectivos_log` (
  `id` int(11) NOT NULL,
  `organizacion_id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechainicio` timestamp NULL DEFAULT NULL,
  `fechafin` timestamp NULL DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `aud_cicloslectivos_log`
--

INSERT INTO `aud_cicloslectivos_log` (`id`, `organizacion_id`, `descripcion`, `fechainicio`, `fechafin`, `activo`, `usuario`, `fecha`, `modi`, `baja`) VALUES
(1, 1, '2015', '2015-03-19 03:00:00', '2015-12-19 03:00:00', 1, NULL, '2015-01-29 19:03:24', 1, NULL),
(1, 1, '2015', '2015-03-19 03:00:00', '2015-12-19 03:00:00', 1, NULL, '2015-01-29 19:37:17', 1, NULL),
(3, 1, 'A', '2015-03-19 00:00:00', '2015-12-19 00:00:00', 0, NULL, '2015-02-09 14:32:30', 1, NULL),
(3, 1, 'Año 2015', '2015-03-19 00:00:00', '2015-12-19 00:00:00', 0, NULL, '2015-02-09 14:32:45', 1, NULL),
(1, 1, '2015', '2015-03-19 03:00:00', '2015-12-19 03:00:00', 1, NULL, '2015-02-09 14:32:53', 1, NULL),
(3, 1, ' 2015', '2015-03-19 00:00:00', '2015-12-19 00:00:00', 0, NULL, '2015-02-09 14:32:53', 1, NULL),
(2, 2, '2015', '2015-03-01 00:00:00', '2015-12-31 00:00:00', 1, NULL, '2015-02-09 16:14:39', 1, NULL),
(4, 3, 'Año 2015', '2015-03-01 00:00:00', '2015-12-21 00:00:00', 0, NULL, '2015-02-09 16:15:12', 1, NULL),
(4, 3, ' 2015', '2015-03-01 00:00:00', '2015-12-21 00:00:00', 0, NULL, '2015-02-09 16:16:13', 1, NULL),
(5, 7, '2015', '2015-03-01 00:00:00', '2015-12-12 00:00:00', 1, NULL, '2015-02-10 17:43:36', 1, NULL),
(3, 1, ' 2015', '2015-03-19 00:00:00', '2015-12-19 00:00:00', 1, NULL, '2015-02-11 13:41:27', 1, NULL),
(1, 1, '2015', '2015-03-19 03:00:00', '2015-12-19 03:00:00', 0, NULL, '2015-02-11 13:41:27', 1, NULL),
(3, 1, ' 2015', '2015-03-19 00:00:00', '2015-12-19 00:00:00', 0, NULL, '2015-02-11 17:47:27', 1, NULL),
(3, 1, ' 2015', '2015-03-19 00:00:00', '2015-12-19 00:00:00', 0, NULL, '2015-02-11 17:47:33', NULL, 1),
(6, 7, '2015', '2015-03-16 00:00:00', '2015-12-21 00:00:00', 0, NULL, '2015-02-12 12:22:23', 1, NULL),
(1, 1, '2015', '2015-03-19 00:00:00', '2015-12-19 00:00:00', 1, NULL, '2015-02-12 17:18:40', 1, NULL),
(1, 1, '2015', '2015-03-19 00:00:00', '2015-12-19 00:00:00', 0, NULL, '2015-02-12 18:21:30', 1, NULL),
(5, 7, '2015', '2015-03-01 00:00:00', '2015-12-12 00:00:00', 1, NULL, '2015-02-24 13:27:42', 1, NULL),
(1, 1, '2015', '2015-03-19 00:00:00', '2015-12-19 00:00:00', 1, NULL, '2015-02-24 13:29:10', 1, NULL),
(6, 6, '2015', '2015-03-16 00:00:00', '2015-12-21 00:00:00', 1, NULL, '2015-02-25 13:06:45', 1, NULL),
(6, 6, '2015', '2015-03-16 00:00:00', '2015-12-21 00:00:00', 1, NULL, '2015-03-02 11:29:04', 1, NULL),
(1, 1, '2015', '2015-03-19 00:00:00', '2015-12-19 00:00:00', 1, NULL, '2015-03-13 12:19:18', NULL, 1),
(2, 2, '2015', '2015-03-01 00:00:00', '2015-12-31 00:00:00', 1, NULL, '2015-03-13 12:19:18', NULL, 1),
(4, 3, ' 2015', '2015-03-01 00:00:00', '2015-12-21 00:00:00', 1, NULL, '2015-03-13 12:19:18', NULL, 1),
(5, 7, '2015', '2015-03-01 00:00:00', '2015-12-12 00:00:00', 1, NULL, '2015-03-13 12:19:18', NULL, 1),
(6, 6, '2014', '2014-03-16 00:00:00', '2014-12-21 00:00:00', 1, NULL, '2015-03-13 12:19:18', NULL, 1),
(7, 1, 'Año 2015', '2015-02-01 00:00:00', '2015-12-12 00:00:00', 1, 'bsegovia', '2015-03-17 15:04:40', 1, NULL),
(7, 1, '2015', '2015-03-16 00:00:00', '2015-12-12 00:00:00', 1, 'admin', '2015-03-20 15:04:57', 1, NULL),
(7, 1, '2015', '2015-03-16 00:00:00', '2015-12-12 00:00:00', 1, 'admin', '2015-03-25 12:25:13', 1, NULL),
(8, 1, 'Año 2014', '2014-08-19 00:00:00', '2015-07-03 00:00:00', 0, 'admin', '2015-04-16 15:16:40', 1, NULL),
(7, 1, '2015', '2015-03-16 00:00:00', '2015-12-31 00:00:00', 1, 'admin', '2015-04-16 15:16:48', 1, NULL),
(8, 1, 'Año 2014', '2014-08-19 00:00:00', '2015-07-03 00:00:00', 0, 'admin', '2015-04-16 15:16:48', 1, NULL),
(8, 1, 'Año 2014', '2014-08-19 00:00:00', '2015-07-03 00:00:00', 1, 'admin', '2015-04-16 15:18:26', 1, NULL),
(8, 1, ' 2014', '2014-08-19 00:00:00', '2015-07-03 00:00:00', 1, 'admin', '2015-04-16 15:23:09', 1, NULL),
(7, 1, '2015', '2015-03-16 00:00:00', '2015-12-31 00:00:00', 0, 'admin', '2015-04-16 15:23:09', 1, NULL),
(8, 1, ' 2014', '2014-08-19 00:00:00', '2015-07-03 00:00:00', 0, 'admin', '2015-04-16 15:23:22', 1, NULL),
(8, 1, ' 2014', '2014-08-19 00:00:00', '2015-07-03 00:00:00', 0, 'admin', '2015-04-16 15:24:46', 1, NULL),
(7, 1, '2015', '2015-03-16 00:00:00', '2015-12-31 00:00:00', 1, 'admin', '2015-04-16 15:26:37', 1, NULL),
(8, 1, ' 2014', '2014-08-19 00:00:00', '2015-07-03 00:00:00', 0, 'admin', '2015-04-16 15:26:37', 1, NULL),
(8, 1, ' 2014', '2014-08-19 00:00:00', '2015-07-03 00:00:00', 1, 'admin', '2015-04-16 15:29:59', 1, NULL),
(7, 1, '2015', '2015-03-16 00:00:00', '2015-12-31 00:00:00', 0, 'admin', '2015-04-16 15:29:59', 1, NULL),
(7, 1, '2015', '2015-03-16 00:00:00', '2015-12-31 00:00:00', 1, 'admin', '2015-04-16 15:32:18', 1, NULL),
(8, 1, ' 2014', '2014-08-19 00:00:00', '2015-07-03 00:00:00', 0, 'admin', '2015-04-16 15:32:18', 1, NULL),
(8, 1, ' 2014', '2014-08-19 00:00:00', '2015-07-03 00:00:00', 1, 'admin', '2015-04-17 12:34:19', 1, NULL),
(7, 1, '2015', '2015-03-16 00:00:00', '2015-12-31 00:00:00', 0, 'admin', '2015-04-17 12:34:19', 1, NULL),
(7, 1, '2015', '2015-03-16 00:00:00', '2015-12-31 00:00:00', 1, 'admin', '2015-04-17 12:37:37', 1, NULL),
(8, 1, ' 2014', '2014-08-19 00:00:00', '2015-07-03 00:00:00', 0, 'admin', '2015-04-17 12:37:37', 1, NULL),
(8, 1, ' 2014', '2014-08-19 00:00:00', '2015-07-03 00:00:00', 1, 'admin', '2015-04-17 14:20:04', 1, NULL),
(7, 1, '2015', '2015-03-16 00:00:00', '2015-12-31 00:00:00', 0, 'admin', '2015-04-17 14:20:04', 1, NULL),
(7, 1, '2015', '2015-03-16 00:00:00', '2015-12-31 00:00:00', 1, 'admin', '2015-04-17 15:05:48', 1, NULL),
(8, 1, ' 2014', '2014-08-19 00:00:00', '2015-07-03 00:00:00', 0, 'admin', '2015-04-17 15:05:48', 1, NULL),
(8, 1, ' 2014', '2014-08-19 00:00:00', '2015-07-03 00:00:00', 1, 'admin', '2015-04-21 12:41:28', 1, NULL),
(9, 1, '2016', '2016-03-03 00:00:00', '2016-12-12 00:00:00', 1, NULL, '2015-04-22 12:52:25', 1, NULL),
(7, 1, '2015', '2015-03-16 00:00:00', '2015-12-31 00:00:00', 0, 'admin', '2015-04-22 12:52:25', 1, NULL),
(7, 1, '2015', '2015-03-16 00:00:00', '2015-12-31 00:00:00', 1, 'admin', '2015-04-22 13:10:37', 1, NULL),
(8, 1, ' 2014', '2014-08-19 00:00:00', '2015-07-03 00:00:00', 0, 'admin', '2015-04-22 13:10:37', 1, NULL),
(8, 1, ' 2014', '2014-08-19 00:00:00', '2015-07-03 00:00:00', 1, 'admin', '2015-04-22 13:11:44', 1, NULL),
(7, 1, '2015', '2015-03-16 00:00:00', '2015-12-31 00:00:00', 0, 'admin', '2015-04-22 13:11:44', 1, NULL),
(7, 1, '2015', '2015-03-16 00:00:00', '2015-12-31 00:00:00', 1, 'admin', '2015-04-22 13:14:52', 1, NULL),
(8, 1, ' 2014', '2014-08-19 00:00:00', '2015-07-03 00:00:00', 0, 'admin', '2015-04-22 13:14:52', 1, NULL),
(8, 1, ' 2014', '2014-08-19 00:00:00', '2015-07-03 00:00:00', 1, 'admin', '2015-04-24 13:09:03', 1, NULL),
(7, 1, '2015', '2015-03-16 00:00:00', '2015-12-31 00:00:00', 0, 'admin', '2015-04-24 13:09:03', 1, NULL),
(7, 1, '2015', '2015-03-16 00:00:00', '2015-12-31 00:00:00', 1, 'admin', '2015-04-27 11:34:11', 1, NULL),
(8, 1, ' 2014', '2014-08-19 00:00:00', '2015-07-03 00:00:00', 0, 'admin', '2015-04-27 11:34:11', 1, NULL),
(8, 1, ' 2014', '2014-08-19 00:00:00', '2015-07-03 00:00:00', 1, 'admin', '2015-04-27 13:33:30', 1, NULL),
(7, 1, '2015', '2015-03-16 00:00:00', '2015-12-31 00:00:00', 0, 'admin', '2015-04-27 13:33:30', 1, NULL),
(7, 1, '2015', '2015-03-16 00:00:00', '2015-12-31 00:00:00', 1, 'admin', '2015-05-12 12:51:49', 1, NULL),
(8, 1, ' 2014', '2014-08-19 00:00:00', '2015-07-03 00:00:00', 0, 'admin', '2015-05-12 12:51:49', 1, NULL),
(8, 1, ' 2014', '2014-08-19 00:00:00', '2015-07-03 00:00:00', 1, 'admin', '2015-05-12 13:19:00', 1, NULL),
(7, 1, '2015', '2015-03-16 00:00:00', '2015-12-31 00:00:00', 0, 'admin', '2015-05-12 13:19:00', 1, NULL),
(7, 1, '2015', '2015-03-16 00:00:00', '2015-12-31 00:00:00', 1, 'admin', '2015-05-12 14:40:15', 1, NULL),
(8, 1, ' 2014', '2014-08-19 00:00:00', '2015-07-03 00:00:00', 0, 'admin', '2015-05-12 14:40:15', 1, NULL),
(8, 1, ' 2014', '2014-08-19 00:00:00', '2015-07-03 00:00:00', 1, 'admin', '2015-05-12 14:43:13', 1, NULL),
(7, 1, '2015', '2015-03-16 00:00:00', '2015-12-31 00:00:00', 0, 'admin', '2015-05-12 14:43:13', 1, NULL),
(7, 1, '2015', '2015-03-16 00:00:00', '2015-12-31 00:00:00', 1, 'admin', '2015-05-14 13:35:47', 1, NULL),
(8, 1, ' 2014', '2014-08-19 00:00:00', '2015-07-03 00:00:00', 0, 'admin', '2015-05-14 13:35:47', 1, NULL),
(8, 1, ' 2014', '2014-08-19 00:00:00', '2015-07-03 00:00:00', 1, 'admin', '2015-05-14 13:44:38', 1, NULL),
(7, 1, '2015', '2015-03-16 00:00:00', '2015-12-31 00:00:00', 0, 'admin', '2015-05-14 13:44:38', 1, NULL),
(7, 1, '2015', '2015-03-16 00:00:00', '2015-12-31 00:00:00', 1, 'admin', '2015-05-20 13:31:03', 1, NULL),
(8, 1, ' 2014', '2014-08-19 00:00:00', '2015-07-03 00:00:00', 0, 'admin', '2015-05-20 13:31:03', 1, NULL),
(8, 1, ' 2014', '2014-08-19 00:00:00', '2015-07-03 00:00:00', 1, 'admin', '2015-05-20 13:33:27', 1, NULL),
(7, 1, '2015', '2015-03-16 00:00:00', '2015-12-31 00:00:00', 0, 'admin', '2015-05-20 13:33:27', 1, NULL),
(7, 1, '2015', '2015-03-16 00:00:00', '2015-12-31 00:00:00', 1, 'admin', '2015-05-20 13:34:21', 1, NULL),
(9, 1, '2016', '2016-03-03 00:00:00', '2016-12-12 00:00:00', 0, 'admin', '2015-05-20 13:34:21', 1, NULL),
(9, 1, '2016', '2016-03-03 00:00:00', '2016-12-12 00:00:00', 1, 'admin', '2015-05-21 14:49:13', 1, NULL),
(7, 1, '2015', '2015-03-16 00:00:00', '2015-12-31 00:00:00', 0, 'admin', '2015-05-21 14:49:13', 1, NULL),
(7, 1, '2015', '2015-03-16 00:00:00', '2015-12-31 00:00:00', 1, 'admin', '2015-06-25 13:11:23', 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aud_contactos_log`
--

CREATE TABLE IF NOT EXISTS `aud_contactos_log` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aud_contacto_organizacion_log`
--

CREATE TABLE IF NOT EXISTS `aud_contacto_organizacion_log` (
  `id` int(11) NOT NULL,
  `organizacion_id` int(11) NOT NULL,
  `contacto_id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `aud_contacto_organizacion_log`
--

INSERT INTO `aud_contacto_organizacion_log` (`id`, `organizacion_id`, `contacto_id`, `descripcion`, `usuario`, `fecha`, `modi`, `baja`) VALUES
(1, 2, 1, '037-4358640', NULL, '2015-02-06 12:13:09', NULL, 1),
(2, 2, 1, '037-4358640', NULL, '2015-02-09 12:41:55', NULL, 1),
(3, 2, 3, 'ckbenitez@hotmail.com', NULL, '2015-02-09 12:41:55', NULL, 1),
(8, 7, 1, '3704-56232323', NULL, '2015-02-11 11:18:59', NULL, 1),
(6, 5, 1, '3704-656238', NULL, '2015-02-11 11:19:32', NULL, 1),
(10, 2, 3, 'ckbenitez@hotmail.com', NULL, '2015-03-13 12:21:15', NULL, 1),
(9, 2, 1, '037-4358640', NULL, '2015-03-13 12:24:52', NULL, 1),
(7, 6, 1, '3704-656532', NULL, '2015-03-13 12:24:54', NULL, 1),
(5, 4, 1, '32326565465', NULL, '2015-03-13 12:24:56', NULL, 1),
(4, 3, 1, '3704-698656', NULL, '2015-03-13 12:24:58', NULL, 1),
(11, 1, 1, '(3704)-421840 / 431868', NULL, '2015-03-13 14:40:33', NULL, 1),
(12, 1, 3, 'contacto@issformosa.edu.ar', NULL, '2015-03-13 14:40:33', NULL, 1),
(13, 1, 1, '(3704)-421840 / 431868', NULL, '2015-03-13 17:23:53', NULL, 1),
(14, 1, 3, 'contacto@issformosa.edu.ar', NULL, '2015-03-13 17:23:53', NULL, 1),
(15, 1, 4, 'http://issformosa.edu.ar/', NULL, '2015-03-13 17:23:53', NULL, 1),
(16, 1, 1, '(3704)-421840 / 431868', NULL, '2015-03-25 11:52:21', NULL, 1),
(17, 1, 3, 'contacto@issformosa.edu.ar', NULL, '2015-03-25 11:52:21', NULL, 1),
(18, 1, 4, 'http://issformosa.edu.ar/', NULL, '2015-03-25 11:52:21', NULL, 1),
(19, 1, 1, '(3704)-421840 / 431868', NULL, '2015-05-14 13:58:54', NULL, 1),
(20, 1, 3, 'contacto@issformosa.edu.ar', NULL, '2015-05-14 13:58:54', NULL, 1),
(21, 1, 4, 'http://issformosa.edu.ar/', NULL, '2015-05-14 13:58:54', NULL, 1),
(22, 1, 1, '(3704)-421840 / 431868', NULL, '2015-05-14 14:01:15', NULL, 1),
(23, 1, 3, 'contacto@issformosa.edu.ar', NULL, '2015-05-14 14:01:15', NULL, 1),
(24, 1, 4, 'http://issformosa.edu.ar/', NULL, '2015-05-14 14:01:15', NULL, 1),
(28, 11, 1, '3704-895623', NULL, '2015-05-19 17:49:27', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aud_contacto_persona_log`
--

CREATE TABLE IF NOT EXISTS `aud_contacto_persona_log` (
  `id` int(11) NOT NULL,
  `persona_id` int(11) NOT NULL,
  `contacto_id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `aud_contacto_persona_log`
--

INSERT INTO `aud_contacto_persona_log` (`id`, `persona_id`, `contacto_id`, `descripcion`, `usuario`, `fecha`, `modi`, `baja`) VALUES
(1, 2, 1, '3704-505063', NULL, '2015-01-26 11:38:53', NULL, 1),
(2, 2, 3, 'waltergerez@issformosa.edu.ar', NULL, '2015-01-26 11:38:53', NULL, 1),
(4, 2, 1, '3704-505063', NULL, '2015-01-26 11:41:07', NULL, 1),
(5, 2, 3, 'waltergerez@issformosa.edu.ar', NULL, '2015-01-26 11:41:07', NULL, 1),
(6, 2, 1, '3704-505063', NULL, '2015-01-26 11:46:18', NULL, 1),
(7, 2, 3, 'waltergerez@issformosa.edu.ar', NULL, '2015-01-26 11:46:18', NULL, 1),
(8, 2, 1, '3704-505063', NULL, '2015-01-26 11:47:29', NULL, 1),
(9, 2, 3, 'waltergerez@issformosa.edu.ar', NULL, '2015-01-26 11:47:29', NULL, 1),
(10, 2, 1, '3704-505063', NULL, '2015-01-26 11:47:45', NULL, 1),
(11, 2, 3, 'waltergerez@issformosa.edu.ar', NULL, '2015-01-26 11:47:45', NULL, 1),
(14, 5, 1, '15151515', NULL, '2015-02-05 18:45:31', NULL, 1),
(15, 5, 3, 'caceres@yahoo.com.ar', NULL, '2015-02-05 18:45:31', NULL, 1),
(16, 6, 2, '1511511-01', NULL, '2015-02-05 18:47:29', NULL, 1),
(17, 5, 1, '15151515', NULL, '2015-02-05 18:47:47', NULL, 1),
(18, 5, 3, 'caceres@yahoo.com.ar', NULL, '2015-02-05 18:47:47', NULL, 1),
(19, 5, 1, '15151515', NULL, '2015-02-05 18:50:08', NULL, 1),
(20, 5, 3, 'caceres@yahoo.com.ar', NULL, '2015-02-05 18:50:08', NULL, 1),
(24, 7, 1, '3704-292922', NULL, '2015-02-06 12:21:28', NULL, 1),
(25, 7, 1, '3704-292922', NULL, '2015-02-06 12:23:22', NULL, 1),
(26, 7, 3, 'sol_@hotmail.com', NULL, '2015-02-06 12:23:22', NULL, 1),
(27, 7, 1, 'otro ', NULL, '2015-02-06 12:23:22', NULL, 1),
(28, 7, 1, 'otro ', NULL, '2015-02-06 12:23:53', NULL, 1),
(29, 7, 3, 'sol_@hotmail.com', NULL, '2015-02-06 12:23:53', NULL, 1),
(30, 7, 1, 'otro ', NULL, '2015-02-06 12:24:08', NULL, 1),
(31, 7, 3, 'sol_@hotmail.com', NULL, '2015-02-06 12:24:08', NULL, 1),
(32, 7, 2, 'laboral 12', NULL, '2015-02-06 12:24:08', NULL, 1),
(33, 7, 1, 'otro ', NULL, '2015-02-06 12:24:34', NULL, 1),
(34, 7, 2, 'laboral 12', NULL, '2015-02-06 12:24:34', NULL, 1),
(35, 7, 3, 'sol_@hotmail.com', NULL, '2015-02-06 12:24:34', NULL, 1),
(36, 7, 2, 'laboral 13', NULL, '2015-02-06 12:24:34', NULL, 1),
(37, 7, 1, 'otro ', NULL, '2015-02-06 12:25:02', NULL, 1),
(38, 7, 2, 'laboral 13', NULL, '2015-02-06 12:25:02', NULL, 1),
(39, 7, 3, 'sol_@hotmail.com', NULL, '2015-02-06 12:25:02', NULL, 1),
(40, 7, 3, 'sol_otro_correo@hotmail.com', NULL, '2015-02-06 12:25:02', NULL, 1),
(49, 12, 3, 'sosa@formosa.com', NULL, '2015-02-09 10:36:04', NULL, 1),
(50, 12, 3, 'marcelo@formosa.com', NULL, '2015-02-09 10:36:04', NULL, 1),
(44, 14, 1, '2522225', NULL, '2015-02-09 10:37:00', NULL, 1),
(45, 14, 1, '2522225', NULL, '2015-02-09 10:37:00', NULL, 1),
(54, 14, 1, '2522225', NULL, '2015-02-09 10:37:14', NULL, 1),
(21, 6, 1, '3704-25258', NULL, '2015-02-09 10:40:07', NULL, 1),
(56, 6, 1, '3704-25258', NULL, '2015-02-09 10:40:22', NULL, 1),
(22, 5, 1, '15151515', NULL, '2015-02-09 10:42:39', NULL, 1),
(23, 5, 3, 'caceres@yahoo.com.ar', NULL, '2015-02-09 10:42:39', NULL, 1),
(46, 9, 1, '3704-369896', NULL, '2015-02-09 10:43:22', NULL, 1),
(47, 9, 1, '37048956522', NULL, '2015-02-09 10:43:22', NULL, 1),
(51, 12, 3, 'marcelo@formosa.com', NULL, '2015-02-09 10:43:33', NULL, 1),
(52, 12, 1, '3704-568936', NULL, '2015-02-09 10:43:33', NULL, 1),
(53, 12, 1, '3704-369633', NULL, '2015-02-09 10:43:33', NULL, 1),
(48, 11, 3, 'sosa@formosa.com', NULL, '2015-02-09 10:43:42', NULL, 1),
(12, 2, 1, '3704-505063', NULL, '2015-02-09 10:56:33', NULL, 1),
(13, 2, 3, 'waltergerez@issformosa.edu.ar', NULL, '2015-02-09 10:56:33', NULL, 1),
(64, 2, 1, '3704-505063', NULL, '2015-02-09 10:56:48', NULL, 1),
(65, 2, 3, 'waltergerez@issformosa.edu.ar', NULL, '2015-02-09 10:56:48', NULL, 1),
(66, 2, 1, '3704-505063', NULL, '2015-02-09 11:23:35', NULL, 1),
(67, 2, 3, 'waltergerez@issformosa.edu.ar', NULL, '2015-02-09 11:23:35', NULL, 1),
(68, 2, 1, '3704-505063', NULL, '2015-02-09 11:23:37', NULL, 1),
(69, 2, 3, 'waltergerez@issformosa.edu.ar', NULL, '2015-02-09 11:23:37', NULL, 1),
(63, 11, 3, 'sosa@formosa.com', NULL, '2015-02-09 11:59:45', NULL, 1),
(58, 5, 1, '15151515', NULL, '2015-02-09 12:17:58', NULL, 1),
(59, 5, 3, 'caceres@yahoo.com.ar', NULL, '2015-02-09 12:17:58', NULL, 1),
(70, 2, 1, '3704-505063', NULL, '2015-02-09 12:18:43', NULL, 1),
(71, 2, 3, 'waltergerez@issformosa.edu.ar', NULL, '2015-02-09 12:18:43', NULL, 1),
(78, 2, 1, '3704-505063', NULL, '2015-02-09 12:18:46', NULL, 1),
(79, 2, 3, 'waltergerez@issformosa.edu.ar', NULL, '2015-02-09 12:18:46', NULL, 1),
(41, 7, 1, 'otro ', NULL, '2015-02-09 12:19:09', NULL, 1),
(42, 7, 2, 'laboral 13', NULL, '2015-02-09 12:19:09', NULL, 1),
(43, 7, 3, 'sol_otro_correo@hotmail.com', NULL, '2015-02-09 12:19:09', NULL, 1),
(57, 6, 1, '3704-25258', NULL, '2015-02-09 12:36:08', NULL, 1),
(80, 2, 1, '3704-505063', NULL, '2015-02-09 12:36:39', NULL, 1),
(81, 2, 3, 'waltergerez@issformosa.edu.ar', NULL, '2015-02-09 12:36:39', NULL, 1),
(86, 2, 1, '3704-505063', NULL, '2015-02-09 12:36:43', NULL, 1),
(87, 2, 3, 'waltergerez@issformosa.edu.ar', NULL, '2015-02-09 12:36:43', NULL, 1),
(3, 1, 1, '3704-556036', NULL, '2015-02-09 13:03:04', NULL, 1),
(90, 1, 1, '3704-556036', NULL, '2015-02-09 13:03:07', NULL, 1),
(76, 5, 1, '15151515', NULL, '2015-02-09 16:24:00', NULL, 1),
(77, 5, 3, 'caceres@yahoo.com.ar', NULL, '2015-02-09 16:24:00', NULL, 1),
(94, 21, 1, '3704-6565323', NULL, '2015-02-09 16:28:48', NULL, 1),
(95, 21, 3, 'montenegro@formosa.com', NULL, '2015-02-09 16:28:48', NULL, 1),
(75, 11, 3, 'sosa@formosa.com', NULL, '2015-02-09 17:24:12', NULL, 1),
(98, 11, 3, 'sosa@formosa.com', NULL, '2015-02-09 17:24:42', NULL, 1),
(99, 11, 3, 'sosa@formosa.com', NULL, '2015-02-09 17:28:06', NULL, 1),
(101, 31, 1, '3704-658989', NULL, '2015-02-11 10:37:46', NULL, 1),
(102, 31, 1, '3704-658989', NULL, '2015-02-11 10:38:13', NULL, 1),
(103, 31, 1, '3704-658989', NULL, '2015-02-11 10:38:29', NULL, 1),
(104, 31, 1, '3704-658989', NULL, '2015-02-11 10:55:59', NULL, 1),
(105, 31, 1, '3704-658989', NULL, '2015-02-11 11:15:31', NULL, 1),
(85, 6, 1, '3704-25258', NULL, '2015-02-11 11:16:23', NULL, 1),
(107, 6, 1, '3704-25258', NULL, '2015-02-11 11:20:33', NULL, 1),
(106, 31, 1, '3704-658989', NULL, '2015-02-11 11:20:41', NULL, 1),
(60, 9, 1, '37048956522', NULL, '2015-02-11 12:04:11', NULL, 1),
(110, 9, 1, '37048956522', NULL, '2015-02-11 12:04:16', NULL, 1),
(100, 11, 3, 'sosa@formosa.com', NULL, '2015-02-11 12:04:26', NULL, 1),
(112, 11, 3, 'sosa@formosa.com', NULL, '2015-02-11 12:04:44', NULL, 1),
(72, 19, 1, '3704-989656', NULL, '2015-02-11 13:32:59', NULL, 1),
(73, 19, 3, 'roman@formosa.com', NULL, '2015-02-11 13:32:59', NULL, 1),
(74, 19, 3, 'roman@gmail.com', NULL, '2015-02-11 13:32:59', NULL, 1),
(114, 19, 1, '3704-989656', NULL, '2015-02-11 13:48:09', NULL, 1),
(115, 19, 3, 'roman@gmail.com', NULL, '2015-02-11 13:48:09', NULL, 1),
(111, 9, 1, '37048956522', NULL, '2015-02-11 13:51:16', NULL, 1),
(91, 1, 1, '3704-556036', NULL, '2015-02-11 14:41:27', NULL, 1),
(118, 9, 1, '37048956522', NULL, '2015-02-12 12:09:22', NULL, 1),
(119, 1, 1, '3704-556036', NULL, '2015-02-12 13:42:28', NULL, 1),
(123, 41, 1, '3704-693691', NULL, '2015-02-12 13:49:38', NULL, 1),
(120, 9, 1, '37048956522', NULL, '2015-02-12 13:51:31', NULL, 1),
(125, 9, 1, '37048956522', NULL, '2015-02-12 13:51:40', NULL, 1),
(127, 43, 1, '4425639', NULL, '2015-02-12 14:04:34', NULL, 1),
(126, 9, 1, '37048956522', NULL, '2015-02-12 14:37:32', NULL, 1),
(128, 43, 1, '4425639', NULL, '2015-02-12 14:43:11', NULL, 1),
(130, 43, 1, '4425639', NULL, '2015-02-12 17:07:18', NULL, 1),
(109, 31, 1, '3704-658989', NULL, '2015-02-12 18:27:23', NULL, 1),
(129, 9, 1, '37048956522', NULL, '2015-02-19 11:10:35', NULL, 1),
(133, 9, 1, '37048956522', NULL, '2015-02-19 11:11:33', NULL, 1),
(134, 9, 1, '37048956522', NULL, '2015-02-19 11:12:08', NULL, 1),
(136, 40, 1, '3704-693698/3704895623', NULL, '2015-02-19 11:41:54', NULL, 1),
(131, 43, 1, '4425639', NULL, '2015-02-19 11:41:59', NULL, 1),
(121, 1, 1, '3704-556036', NULL, '2015-02-19 11:43:28', NULL, 1),
(122, 1, 3, 'mongelos@formosa.com', NULL, '2015-02-19 11:43:28', NULL, 1),
(135, 9, 1, '37048956522', NULL, '2015-02-19 11:55:13', NULL, 1),
(137, 40, 1, '3704-693698/3704895623', NULL, '2015-02-19 14:23:36', NULL, 1),
(141, 9, 1, '37048956522', NULL, '2015-02-24 12:06:21', NULL, 1),
(61, 12, 1, '3704-369633', NULL, '2015-02-24 12:08:50', NULL, 1),
(62, 12, 3, 'marcelo@formosa.com', NULL, '2015-02-24 12:08:50', NULL, 1),
(143, 9, 1, '37048956522', NULL, '2015-02-24 15:27:29', NULL, 1),
(144, 12, 1, '3704-369633', NULL, '2015-02-25 13:13:18', NULL, 1),
(145, 12, 3, 'marcelo@formosa.com', NULL, '2015-02-25 13:13:18', NULL, 1),
(116, 19, 1, '3704-989612', NULL, '2015-02-25 13:16:22', NULL, 1),
(117, 19, 3, 'roman@gmail.com', NULL, '2015-02-25 13:16:22', NULL, 1),
(96, 21, 1, '3704-6565323', NULL, '2015-02-26 11:49:52', NULL, 1),
(97, 21, 3, 'montenegro@formosa.com', NULL, '2015-02-26 11:49:52', NULL, 1),
(88, 2, 1, '3704-505063', NULL, '2015-02-26 11:50:18', NULL, 1),
(89, 2, 3, 'waltergerez@issformosa.edu.ar', NULL, '2015-02-26 11:50:18', NULL, 1),
(55, 14, 1, '2522225', NULL, '2015-02-26 11:55:11', NULL, 1),
(147, 12, 1, '3704-369633', NULL, '2015-02-26 11:55:18', NULL, 1),
(148, 12, 3, 'marcelo@formosa.com', NULL, '2015-02-26 11:55:18', NULL, 1),
(82, 7, 1, 'otro ', NULL, '2015-02-26 11:55:22', NULL, 1),
(83, 7, 2, 'laboral 13', NULL, '2015-02-26 11:55:22', NULL, 1),
(84, 7, 3, 'sol_otro_correo@hotmail.com', NULL, '2015-02-26 11:55:22', NULL, 1),
(113, 11, 3, 'sosa@formosa.com', NULL, '2015-02-26 11:55:25', NULL, 1),
(132, 31, 1, '3704-658989', NULL, '2015-02-26 11:55:29', NULL, 1),
(108, 6, 1, '3704-25258', NULL, '2015-02-26 11:55:33', NULL, 1),
(152, 56, 1, '3704-8965323', NULL, '2015-02-27 10:52:22', NULL, 1),
(153, 56, 1, '3704-8965323', NULL, '2015-02-27 10:52:46', NULL, 1),
(155, 58, 1, '3704-6936923', NULL, '2015-03-02 17:52:11', NULL, 1),
(151, 53, 1, '3704-693698', NULL, '2015-03-04 11:22:28', NULL, 1),
(157, 53, 1, '3704-693698', NULL, '2015-03-04 11:22:40', NULL, 1),
(158, 53, 1, '3704-693698', NULL, '2015-03-04 13:45:41', NULL, 1),
(154, 56, 1, '3704-8965323', NULL, '2015-03-04 13:46:27', NULL, 1),
(160, 53, 1, '3704-693698', NULL, '2015-03-05 11:56:48', NULL, 1),
(164, 53, 1, '3704-693698', NULL, '2015-03-05 11:57:00', NULL, 1),
(161, 56, 1, '3704-8965323', NULL, '2015-03-05 11:57:24', NULL, 1),
(166, 56, 1, '3704-8965323', NULL, '2015-03-05 12:21:59', NULL, 1),
(167, 56, 1, '3704-8965323', NULL, '2015-03-09 12:26:23', NULL, 1),
(168, 56, 1, '3704-8965323', NULL, '2015-03-09 12:26:30', NULL, 1),
(169, 56, 1, '3704-8965323', NULL, '2015-03-09 12:37:49', NULL, 1),
(170, 56, 1, '3704-8965323', NULL, '2015-03-11 12:43:17', NULL, 1),
(142, 40, 1, '3704-693698/3704895623', NULL, '2015-03-12 13:40:43', NULL, 1),
(172, 40, 1, '3704-693698/3704895623', NULL, '2015-03-12 14:03:03', NULL, 1),
(173, 40, 1, '3704-693698/3704895623', NULL, '2015-03-12 14:03:13', NULL, 1),
(138, 43, 1, '4425639', NULL, '2015-03-12 14:12:04', NULL, 1),
(156, 58, 1, '3704-6936923', NULL, '2015-03-12 14:58:13', NULL, 1),
(175, 58, 1, '3704-6936923', NULL, '2015-03-12 14:59:05', NULL, 1),
(176, 58, 3, 'sadad@.com', NULL, '2015-03-12 14:59:05', NULL, 1),
(177, 58, 1, '3704-6936923', NULL, '2015-03-12 14:59:45', NULL, 1),
(178, 58, 3, 'segben12@gmail.com', NULL, '2015-03-12 14:59:45', NULL, 1),
(174, 40, 1, '3704-693698/3704895623', NULL, '2015-03-13 11:20:44', NULL, 1),
(171, 56, 1, '3704-8965323', NULL, '2015-03-13 12:31:37', NULL, 1),
(180, 40, 1, '3704-693698/3704895623', NULL, '2015-03-13 12:33:08', NULL, 1),
(139, 1, 1, '3704-556036', NULL, '2015-03-13 12:33:25', NULL, 1),
(140, 1, 3, 'mongelos@formosa.com', NULL, '2015-03-13 12:33:25', NULL, 1),
(184, 67, 1, '3704-658956', NULL, '2015-03-18 13:36:05', NULL, 1),
(185, 67, 3, 'gustavo@formosa.com', NULL, '2015-03-18 13:36:05', NULL, 1),
(182, 68, 1, '3704-693698', NULL, '2015-03-20 14:48:29', NULL, 1),
(183, 68, 3, 'sebastian@gmail.com', NULL, '2015-03-20 14:48:29', NULL, 1),
(186, 67, 1, '3704-658956', NULL, '2015-03-20 14:48:39', NULL, 1),
(187, 67, 3, 'gustavo@formosa.com', NULL, '2015-03-20 14:48:39', NULL, 1),
(190, 67, 1, '3704-658956', NULL, '2015-03-25 11:32:54', NULL, 1),
(191, 67, 3, 'gustavo@formosa.com', NULL, '2015-03-25 11:32:54', NULL, 1),
(188, 68, 1, '3704-693698', NULL, '2015-03-25 11:33:09', NULL, 1),
(189, 68, 3, 'sebastian@gmail.com', NULL, '2015-03-25 11:33:09', NULL, 1),
(192, 75, 1, '370-4356001', NULL, '2015-03-30 13:19:08', NULL, 1),
(193, 75, 3, 'valea95@hotmail.com', NULL, '2015-03-30 13:19:08', NULL, 1),
(200, 87, 1, '3704710480', NULL, '2015-03-31 15:22:46', NULL, 1),
(201, 87, 3, 'eferichlajunta87@hotmail.com', NULL, '2015-03-31 15:22:46', NULL, 1),
(204, 88, 1, '3704828674', NULL, '2015-03-31 15:33:19', NULL, 1),
(205, 88, 3, 'nali_e@hotmail.com', NULL, '2015-03-31 15:33:19', NULL, 1),
(220, 95, 1, '3704573410', NULL, '2015-03-31 23:09:28', NULL, 1),
(225, 97, 1, '3704688097', NULL, '2015-03-31 23:27:17', NULL, 1),
(226, 97, 1, '3704688097', NULL, '2015-03-31 23:32:23', NULL, 1),
(227, 97, 3, 'KARUA_123@HOTMAIL.COM', NULL, '2015-03-31 23:32:23', NULL, 1),
(224, 96, 1, '3704363649', NULL, '2015-03-31 23:45:16', NULL, 1),
(235, 104, 1, '3704402959', NULL, '2015-04-01 00:47:15', NULL, 1),
(216, 93, 1, '3704-855861', NULL, '2015-04-01 12:59:11', NULL, 1),
(217, 93, 3, 'emanuelcardozo09@gimail.com', NULL, '2015-04-01 12:59:11', NULL, 1),
(242, 93, 1, '3704-855861', NULL, '2015-04-14 15:42:14', NULL, 1),
(243, 93, 3, 'emanuelcardozo09@gimail.com', NULL, '2015-04-14 15:42:14', NULL, 1),
(202, 87, 1, '3704710480', NULL, '2015-04-16 15:21:24', NULL, 1),
(203, 87, 3, 'eferichlajunta87@hotmail.com', NULL, '2015-04-16 15:21:24', NULL, 1),
(236, 104, 1, '3704402959', NULL, '2015-05-14 12:44:23', NULL, 1),
(237, 104, 3, 'rocioleal15@hotmal.com', NULL, '2015-05-14 12:44:23', NULL, 1),
(206, 88, 1, '3704828674', NULL, '2015-05-14 13:46:12', NULL, 1),
(207, 88, 3, 'nali_e@hotmail.com', NULL, '2015-05-14 13:46:12', NULL, 1),
(230, 98, 3, 'cristian-faray@hotmail.com', NULL, '2015-05-14 13:53:55', NULL, 1),
(262, 98, 3, 'cristian-faray@hotmail.com', NULL, '2015-05-14 13:56:38', NULL, 1),
(263, 98, 3, 'cristian-faray@hotmail.com', NULL, '2015-05-14 13:56:46', NULL, 1),
(264, 98, 3, 'cristian-faray@hotmail.com', NULL, '2015-05-14 13:56:54', NULL, 1),
(265, 98, 3, 'cristian-faray@hotmail.com', NULL, '2015-05-14 13:58:16', NULL, 1),
(266, 98, 3, 'cristian-faray@hotmail.com', NULL, '2015-05-14 14:09:01', NULL, 1),
(267, 98, 3, 'cristian-faray@hotmail.com', NULL, '2015-05-14 14:31:42', NULL, 1),
(254, 93, 1, '3704-855861', NULL, '2015-05-14 16:30:03', NULL, 1),
(255, 93, 3, 'emanuelcardozo09@gimail.com', NULL, '2015-05-14 16:30:03', NULL, 1),
(248, 111, 1, '3715406448', NULL, '2015-05-15 13:14:48', NULL, 1),
(249, 111, 3, 'carlazayas97@gmail.com', NULL, '2015-05-15 13:14:48', NULL, 1),
(260, 88, 1, '3704828674', NULL, '2015-05-15 14:19:46', NULL, 1),
(261, 88, 3, 'nali_e@hotmail.com', NULL, '2015-05-15 14:19:46', NULL, 1),
(232, 99, 3, 'gallardo.mabelen@gmail.com', NULL, '2015-05-21 17:12:43', NULL, 1),
(239, 106, 3, 'marialauralezcano@hotmail.com', NULL, '2015-06-02 18:08:39', NULL, 1),
(276, 114, 1, '3704-693698', NULL, '2015-06-04 14:21:06', NULL, 1),
(252, 113, 1, '3704595103', NULL, '2015-06-04 14:42:25', NULL, 1),
(253, 113, 2, 'gabii_41@hotmail.es', NULL, '2015-06-04 14:42:25', NULL, 1),
(208, 89, 1, '3704390233', NULL, '2015-06-04 14:50:48', NULL, 1),
(209, 89, 3, 'sabri.godo@hotmail.com', NULL, '2015-06-04 14:50:48', NULL, 1),
(279, 114, 1, '3704-693698', NULL, '2015-06-16 13:39:25', NULL, 1),
(284, 114, 1, '3704-693698', NULL, '2015-06-16 15:39:41', NULL, 1),
(238, 105, 3, 'marianellal37@gmail.com', NULL, '2015-07-10 14:21:35', NULL, 1),
(258, 104, 1, '3704402959', NULL, '2015-07-10 14:43:12', NULL, 1),
(259, 104, 3, 'rocioleal15@hotmal.com', NULL, '2015-07-10 14:43:12', NULL, 1),
(285, 115, 1, '3704-693698', NULL, '2015-07-15 13:24:14', NULL, 1),
(288, 104, 1, '3704402959', NULL, '2015-07-27 18:16:06', NULL, 1),
(289, 104, 3, 'rocioleal15@hotmal.com', NULL, '2015-07-27 18:16:06', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aud_departamentos_log`
--

CREATE TABLE IF NOT EXISTS `aud_departamentos_log` (
  `id` int(11) NOT NULL,
  `provincia_id` int(11) DEFAULT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aud_docentes_log`
--

CREATE TABLE IF NOT EXISTS `aud_docentes_log` (
  `id` int(11) NOT NULL,
  `persona_id` int(11) NOT NULL,
  `nrolegajo` int(11) NOT NULL,
  `foto` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `empleado` tinyint(1) DEFAULT NULL,
  `disertante` tinyint(1) DEFAULT NULL,
  `fechaingreso` timestamp NULL DEFAULT NULL,
  `fechaegreso` timestamp NULL DEFAULT NULL,
  `titulohabilitante_id` int(11) NOT NULL,
  `organisamohabilitante_id` int(11) NOT NULL,
  `nrolegajohabilitante` int(11) NOT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aud_estadosciviles_log`
--

CREATE TABLE IF NOT EXISTS `aud_estadosciviles_log` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aud_localidades_log`
--

CREATE TABLE IF NOT EXISTS `aud_localidades_log` (
  `id` int(11) NOT NULL,
  `departamento_id` int(11) DEFAULT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `aud_localidades_log`
--

INSERT INTO `aud_localidades_log` (`id`, `departamento_id`, `descripcion`, `usuario`, `fecha`, `modi`, `baja`) VALUES
(266, 5, 'Villa Kilómetro 213', NULL, '2015-03-11 14:47:56', 1, NULL),
(265, 5, 'Palo Santo', NULL, '2015-03-11 14:48:11', 1, NULL),
(266, 8, 'Villa Kilómetro 213', NULL, '2015-03-11 14:48:23', 1, NULL),
(264, 5, 'Villa General Manuel Belgrano', NULL, '2015-03-11 14:48:37', 1, NULL),
(263, 5, 'Villa General Gûemes', NULL, '2015-03-11 14:48:49', 1, NULL),
(262, 5, 'Subteniente Perín', NULL, '2015-03-11 14:48:58', 1, NULL),
(261, 5, 'San Martín II', NULL, '2015-03-11 14:49:09', 1, NULL),
(260, 5, 'San Martín I', NULL, '2015-03-11 14:49:16', 1, NULL),
(259, 5, 'Pozo del Tigre', NULL, '2015-03-11 14:49:26', 1, NULL),
(258, 5, 'Las Lomitas', NULL, '2015-03-11 14:49:34', 1, NULL),
(257, 5, 'Ibarreta', NULL, '2015-03-11 14:49:43', 1, NULL),
(256, 5, 'Estanislao del Campo', NULL, '2015-03-11 14:49:53', 1, NULL),
(255, 5, 'Comandante Fontana', NULL, '2015-03-11 14:50:02', 1, NULL),
(254, 5, 'Bartolomé de las Casas', NULL, '2015-03-11 14:50:11', 1, NULL),
(253, 7, 'Siete Palmas', NULL, '2015-03-11 14:50:17', 1, NULL),
(252, 7, 'Riacho Negro', NULL, '2015-03-11 14:50:23', 1, NULL),
(251, 7, 'Riacho He-He', NULL, '2015-03-11 14:50:29', 1, NULL),
(250, 7, 'Puerto Pilcomayo', NULL, '2015-03-11 14:50:35', 1, NULL),
(249, 7, 'Palma Sola', NULL, '2015-03-11 14:50:40', 1, NULL),
(248, 7, 'Laguna Naick-Neck', NULL, '2015-03-11 14:50:51', 1, NULL),
(247, 2, 'Villa del Carmen', NULL, '2015-03-11 14:51:08', 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aud_modalidades_log`
--

CREATE TABLE IF NOT EXISTS `aud_modalidades_log` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aud_niveles_educativos_log`
--

CREATE TABLE IF NOT EXISTS `aud_niveles_educativos_log` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aud_ocupaciones_log`
--

CREATE TABLE IF NOT EXISTS `aud_ocupaciones_log` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aud_organismoshabilitantes_log`
--

CREATE TABLE IF NOT EXISTS `aud_organismoshabilitantes_log` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aud_organizaciones_log`
--

CREATE TABLE IF NOT EXISTS `aud_organizaciones_log` (
  `id` int(11) NOT NULL,
  `nombre` varchar(300) COLLATE utf8_spanish_ci DEFAULT NULL,
  `razon_social` varchar(300) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cuit` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nivel_Educativo_id` int(11) DEFAULT NULL,
  `habilitar_sedes` tinyint(1) NOT NULL DEFAULT '0',
  `pais_id` int(11) DEFAULT NULL,
  `provincia_id` int(11) DEFAULT NULL,
  `departamento_id` int(11) DEFAULT NULL,
  `localidad_id` int(11) DEFAULT NULL,
  `barrio_id` int(11) DEFAULT NULL,
  `calle` varchar(500) COLLATE utf8_spanish_ci DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `manzana` int(11) DEFAULT NULL,
  `piso` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `departamento` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `codigo_postal` int(11) DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `aud_organizaciones_log`
--

INSERT INTO `aud_organizaciones_log` (`id`, `nombre`, `razon_social`, `cuit`, `nivel_Educativo_id`, `habilitar_sedes`, `pais_id`, `provincia_id`, `departamento_id`, `localidad_id`, `barrio_id`, `calle`, `numero`, `manzana`, `piso`, `departamento`, `codigo_postal`, `usuario`, `fecha`, `modi`, `baja`) VALUES
(2, 'Mi Organización 2015', 'Mi Razón Social 2015', '30-70902020-01', 2, 0, 1, 1, 1, 1, 1, 'Av. 25 de mayo 2025', 2025, 0, '', '', 3600, NULL, '2015-02-06 12:13:09', 1, NULL),
(1, 'Instituto Superior de Sanidad ', 'ISS - "Prof. Ramón Carrillo"', '30-55636215-4', 1, 0, 1, 1, 2, 53, 2, '', 0, 0, '', '', 3600, NULL, '2015-02-09 10:55:22', 1, NULL),
(1, 'Instituto Superior de Sanidad ', 'ISS - "Prof. Ramón Carrillo"', '30-55636215-4', 1, 0, 1, 1, 2, 53, 2, 'Independencia', 365, 0, '', '', 3600, NULL, '2015-02-09 10:59:44', 1, NULL),
(2, 'Mi Organización 2015', 'Mi Razón Social 2015', '30-70902020-01', 2, 0, 1, 1, 1, 1, 1, 'Av. 25 de mayo 2025', 2025, 0, '', '', 3600, NULL, '2015-02-09 12:41:55', 1, NULL),
(5, 'COLEGIO SUPERIOR DE SANIDAD RAMÓN CARRILLO', 'CSS ', '30-65956232-7', 1, 0, 1, 1, 1, 1, 1, '', 0, 0, '', '', 3265, NULL, '2015-02-11 11:19:32', NULL, 1),
(8, 'COLEGIO SUPERIOR DE SANIDAD RAMÓN CARRILLO', 'CSS ', '32-3698969-9', 1, 0, 1, 1, 1, 1, 1, '', 0, 0, '', '', 21323, NULL, '2015-02-11 12:39:26', 1, NULL),
(9, 'COLEGIO SUPERIOR DE SANIDAD RAMÓN CARRILLO', 'CSS ', '32-3698969-9', 1, 0, 1, 1, 1, 1, 1, '', 0, 0, '', '', 3600, NULL, '2015-02-11 14:08:21', NULL, 1),
(8, 'COLEGIO SUPERIOR DE SANIDAD RAMÓN CARRILLO', 'CSS ', '32-3698969-9', 1, 0, 1, 1, 1, 1, 1, '', 0, 0, '', '', 3600, NULL, '2015-03-13 12:23:34', NULL, 1),
(7, 'CENTRO DE FORMACIÓN TÉCNICA FORMOSA', 'CFT FORMOSA', '31-5656556-9', 1, 0, 1, 1, 1, 1, 1, 'Independencia', 323, 0, '', '', 65323, NULL, '2015-03-13 12:23:49', NULL, 1),
(2, 'MI ORGANIZACIÓN 2015', 'Mi Razón Social 2015', '30-70902020-01', 2, 0, 1, 1, 1, 1, 1, 'Av. 25 de mayo 2025', 2025, 0, '', '', 3600, NULL, '2015-03-13 12:25:04', NULL, 1),
(3, 'UNIVERSIDAD PRIVADA DE MEDICINA', 'UPM ', '30-65956232-7', 2, 0, 1, 1, 1, 1, 1, '', 0, 0, '', '', 3600, NULL, '2015-03-13 12:25:06', NULL, 1),
(4, 'NUEVA ORGANIZACIÓN', 'NUEVA ORG ', '30-6969369-1', 1, 0, 1, 1, 1, 1, 1, '', 0, 0, '', '', 6523, NULL, '2015-03-13 12:25:09', NULL, 1),
(6, 'CENTRO EDUCATIVO DE SANIDAD FORMOSA', 'CSS ', '35-56565656-89', 1, 0, 1, 1, 1, 1, 1, '', 0, 0, '', '', 36000, NULL, '2015-03-13 12:25:10', NULL, 1),
(1, 'INSTITUTO SUPERIOR DE SANIDAD PROF. RAMÓN CARRILLO', 'ISS - "Prof. Ramón Carrillo"', '30-55636215-4', 1, 0, 1, 1, 2, 53, 2, 'Independencia', 365, 0, '', '', 3600, 'admin', '2015-03-13 14:37:01', 1, NULL),
(1, 'INSTITUTO SUPERIOR DE SANIDAD PROF. RAMÓN CARRILLO', 'ISS - "Prof. Ramón Carrillo"', '12345', 1, 0, 1, 1, 2, 53, 2, 'Independencia', 365, 0, '', '', 3600, 'admin', '2015-03-13 14:39:25', 1, NULL),
(1, 'Instituto Superior de Sanidad "Prof. Dr. Ramón Carrillo"', 'ISS - "Prof. Ramón Carrillo"', '12345', 1, 0, 1, 1, 2, 53, 2, 'Córdoba ', 447, 0, '', '', 3600, 'admin', '2015-03-13 14:40:33', 1, NULL),
(1, 'Instituto Superior de Sanidad "Prof. Dr. Ramón Carrillo"', 'ISS - "Prof. Ramón Carrillo"', '12345', 1, 0, 1, 1, 2, 53, 2, 'Córdoba ', 447, 0, '', '', 3600, 'admin', '2015-03-13 17:23:53', 1, NULL),
(10, 'UNIVERSIDAD PRIVADA DE MEDICINA', 'UPM ', '30-6969369-1', 2, 0, 1, 1, 2, 53, 2, '', 0, 0, '', '', 3600, NULL, '2015-03-25 11:36:48', NULL, 1),
(1, 'INSTITUTO SUPERIOR DE SANIDAD "Prof. Dr. Ramón Carrillo"', 'ISS - "Prof. Ramón Carrillo"', '12345', 1, 0, 1, 1, 2, 53, 2, 'Córdoba ', 447, 0, '', '', 3600, 'admin', '2015-03-25 11:52:21', 1, NULL),
(1, 'INSTITUTO SUPERIOR DE SANIDAD "Prof. Dr. Ramón Carrillo"', 'Fundación Hospital de Alta Complejidad "Pte. Juan D. Perón"', '30-71233107-7', 1, 0, 1, 1, 2, 53, 2, 'Córdoba ', 447, 0, '', '', 3600, 'admin', '2015-05-14 13:58:54', 1, NULL),
(1, 'INSTITUTO SUPERIOR DE SANIDAD "Prof. Dr. Ramón Carrillo"', 'Fundación Hospital de Alta Complejidad "Pte. Juan D. Perón"', '30-71233107-7', 1, 0, 1, 1, 2, 53, 2, '', 0, 0, '', '', 3600, 'admin', '2015-05-14 14:01:15', 1, NULL),
(11, 'INSTITUTO SUPERIOR DE SANIDAD FORMOSA', 'ISS FORMOSA S.A. ', '30-55636215-4', 1, 0, 1, 1, 7, 148, 39, 'Libertad', 690, 0, '', '', 3658, 'admin', '2015-05-19 17:49:27', 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aud_paises_log`
--

CREATE TABLE IF NOT EXISTS `aud_paises_log` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aud_periodoslectivos_log`
--

CREATE TABLE IF NOT EXISTS `aud_periodoslectivos_log` (
  `id` int(11) NOT NULL,
  `ciclolectivo_id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechainicio` timestamp NULL DEFAULT NULL,
  `fechafin` timestamp NULL DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `aud_periodoslectivos_log`
--

INSERT INTO `aud_periodoslectivos_log` (`id`, `ciclolectivo_id`, `descripcion`, `fechainicio`, `fechafin`, `usuario`, `fecha`, `modi`, `baja`) VALUES
(1, 1, '1° Cuatrimestre', '2015-03-19 03:00:00', '2015-06-10 03:00:00', NULL, '2015-01-29 19:04:14', NULL, 1),
(2, 1, '1° Cuatrimestre', '2015-03-19 03:00:00', '2015-06-10 03:00:00', NULL, '2015-01-29 19:25:24', NULL, 1),
(3, 1, '1° Cuatrimestre', '2015-02-19 03:00:00', '2015-06-10 03:00:00', NULL, '2015-01-29 19:38:42', NULL, 1),
(4, 1, '2° Cuatrimestre', '2015-07-18 03:00:00', '2015-12-19 03:00:00', NULL, '2015-02-06 13:12:09', 1, NULL),
(7, 3, '1 cuatrimestre', '2015-03-19 00:00:00', '2015-07-19 00:00:00', NULL, '2015-02-11 17:47:33', NULL, 1),
(4, 1, '1° Cuatrimestre', '2015-03-15 00:00:00', '2015-06-19 00:00:00', NULL, '2015-02-11 17:47:48', NULL, 1),
(10, 1, '1 Cuatrimestre', '2015-03-19 00:00:00', '2015-06-12 00:00:00', NULL, '2015-02-12 14:31:12', NULL, 1),
(11, 1, '2 Cuatrimestre', '2015-07-12 00:00:00', '2015-12-15 00:00:00', NULL, '2015-02-12 14:31:12', NULL, 1),
(12, 1, '1 Cuatrimestre', '2015-03-19 00:00:00', '2015-07-15 00:00:00', NULL, '2015-02-19 11:46:50', NULL, 1),
(13, 1, '2 Cuatrimestre', '2015-08-15 00:00:00', '2015-12-19 00:00:00', NULL, '2015-02-19 11:46:50', NULL, 1),
(14, 5, 'dcfgvdeeeeexzf', '1977-12-12 00:00:00', '2013-12-12 00:00:00', NULL, '2015-02-24 13:27:40', 1, NULL),
(17, 6, '1 Cuatrimestr', '2015-03-16 00:00:00', '2015-06-20 00:00:00', NULL, '2015-03-02 11:30:15', 1, NULL),
(9, 4, '2 Cuatrimestre', '2015-08-15 00:00:00', '2015-12-21 00:00:00', NULL, '2015-03-13 12:17:11', NULL, 1),
(8, 4, '1 cuatrimestre', '2015-03-01 00:00:00', '2015-06-15 00:00:00', NULL, '2015-03-13 12:17:14', NULL, 1),
(5, 2, '1 Cuatrimestr', '2015-03-01 00:00:00', '2015-07-15 00:00:00', NULL, '2015-03-13 12:18:24', NULL, 1),
(6, 2, '2 Cuetrimestre', '2015-08-15 00:00:00', '2015-12-31 00:00:00', NULL, '2015-03-13 12:18:24', NULL, 1),
(14, 5, '1 CUATRIMESTRE', '1977-12-12 00:00:00', '2013-12-12 00:00:00', NULL, '2015-03-13 12:18:24', NULL, 1),
(15, 1, '1 Cuatrimestre', '2015-03-19 00:00:00', '2015-06-25 00:00:00', NULL, '2015-03-13 12:18:24', NULL, 1),
(16, 1, '2 Cuatrimestre', '2015-08-08 00:00:00', '2015-12-19 00:00:00', NULL, '2015-03-13 12:18:24', NULL, 1),
(17, 6, '1 Cuatrimestr', '2014-03-16 00:00:00', '2014-06-20 00:00:00', NULL, '2015-03-13 12:18:24', NULL, 1),
(18, 7, '1 Cuatrimestre', '2015-02-01 00:00:00', '2015-07-25 00:00:00', NULL, '2015-03-25 12:26:28', 1, NULL),
(19, 7, '2Cuatrimestre', '2015-08-25 00:00:00', '2015-12-12 00:00:00', NULL, '2015-03-25 12:36:17', 1, NULL),
(19, 7, '2Cuatrimestre', '2015-08-18 00:00:00', '2015-12-04 00:00:00', NULL, '2015-03-25 16:43:16', 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aud_personas_log`
--

CREATE TABLE IF NOT EXISTS `aud_personas_log` (
  `id` int(11) NOT NULL,
  `apellido` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `tipodocumento_id` int(11) DEFAULT NULL,
  `nrodocumento` varchar(300) COLLATE utf8_spanish_ci DEFAULT NULL,
  `sexo` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estadocivil_id` int(11) DEFAULT NULL,
  `fechanacimiento` timestamp NULL DEFAULT NULL,
  `lugarnacimiento_id` int(11) DEFAULT NULL,
  `pais_id` int(11) DEFAULT NULL,
  `provincia_id` int(11) DEFAULT NULL,
  `departamento_id` int(11) DEFAULT NULL,
  `localidad_id` int(11) DEFAULT NULL,
  `barrio_id` int(11) DEFAULT NULL,
  `calle` varchar(500) COLLATE utf8_spanish_ci DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `manzana` int(11) DEFAULT NULL,
  `piso` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `departamento` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `codigo_postal` int(11) DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `aud_personas_log`
--

INSERT INTO `aud_personas_log` (`id`, `apellido`, `nombre`, `tipodocumento_id`, `nrodocumento`, `sexo`, `estadocivil_id`, `fechanacimiento`, `lugarnacimiento_id`, `pais_id`, `provincia_id`, `departamento_id`, `localidad_id`, `barrio_id`, `calle`, `numero`, `manzana`, `piso`, `departamento`, `codigo_postal`, `usuario`, `fecha`, `modi`, `baja`) VALUES
(1, 'Mongelos', 'María Cristina', 1, '30.526.623', 'Femenino', 2, '1972-10-01 03:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-01-12 17:48:15', 1, NULL),
(1, 'Mongelos', 'María Cristina', 1, '30.526.623', 'Masculino', 2, '1972-10-01 03:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-01-12 17:48:22', 1, NULL),
(1, 'Mongelos', 'María Cristina', 1, '30.526.623', 'Masculino', 2, '1972-10-01 03:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-01-12 17:49:25', 1, NULL),
(1, 'Mongelos', 'María Cristina', 1, '30.526.623', 'Masculino', 2, '1972-10-01 03:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-01-12 18:24:23', 1, NULL),
(1, 'Mongelos', 'María Cristina', 1, '30.526.623', 'Masculino', 2, '1972-10-01 03:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-01-12 18:24:31', 1, NULL),
(1, 'Mongelos', 'María Cristina', 1, '30.526.623', 'Masculino', 2, '1972-10-01 03:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-01-13 10:51:49', 1, NULL),
(1, 'Mongelos', 'María Cristina', 1, '30.526.623', 'Masculino', 2, '1972-10-01 03:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-01-13 11:06:00', 1, NULL),
(1, 'Mongelos', 'María Cristina', 1, '30.526.623', 'Masculino', 2, '1972-10-01 03:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-01-13 11:12:43', 1, NULL),
(1, 'Mongelos', 'María Cristina', 1, '30.526.623', 'Masculino', 2, '1972-10-01 03:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-01-16 13:27:39', 1, NULL),
(2, 'Gerez', 'Cesar Walter', 1, '25.812.475', 'Masculino', 2, '1977-06-11 03:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-01-22 19:12:43', 1, NULL),
(1, 'Mongelos', 'María Cristina', 1, '30.526.623', 'Masculino', 2, '1973-10-01 03:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-01-22 19:33:40', 1, NULL),
(2, 'Gerez', 'Cesar Walter', 1, '25.812.475', 'Masculino', 2, '1977-06-11 03:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-01-26 11:38:53', 1, NULL),
(2, 'Gerez', 'Cesar Walter', 1, '25.812.475', 'Masculino', 2, '1977-06-11 03:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-01-26 11:41:07', 1, NULL),
(2, 'Gerez', 'Cesar Walter', 1, '25.812.475', 'Masculino', 2, '1977-06-11 03:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-01-26 11:46:18', 1, NULL),
(2, 'Gerez', 'Cesar Walter', 1, '25.812.475', 'Masculino', 2, '1977-06-11 03:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-01-26 11:47:28', 1, NULL),
(2, 'Gerez', 'Cesar Walter', 1, '25.812.475', 'Masculino', 2, '1977-06-11 03:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-01-26 11:47:45', 1, NULL),
(6, 'gimenez ', 'carmelo', 1, '25.666.25_', 'Masculino', 4, '0000-00-00 00:00:00', 1, 1, 1, 1, 1, 1, 'calle 13', 13, 0, '', '', 3066, NULL, '2015-02-05 18:44:40', 1, NULL),
(5, 'caceres', 'marcela', 1, '25.228.692', 'Femenino', 1, '1976-06-24 00:00:00', 1, 1, 1, 1, 1, 1, 'las americas ', 2015, 0, '', '', 3600, NULL, '2015-02-05 18:45:31', 1, NULL),
(6, 'gimenez ', 'carmelo', 1, '25.666.25_', 'Masculino', 4, '0000-00-00 00:00:00', 1, 1, 1, 1, 1, 1, 'calle 13', 13, 0, '', '', 3066, NULL, '2015-02-05 18:47:29', 1, NULL),
(5, 'caceres', 'marcela', 1, '25.228.692', 'Masculino', 1, '1976-06-24 00:00:00', 1, 1, 1, 1, 1, 1, 'las americas ', 2015, 0, '', '', 3600, NULL, '2015-02-05 18:47:47', 1, NULL),
(6, 'gimenez ', 'carmelo', 1, '25.666.25_', 'Masculino', 4, '0000-00-00 00:00:00', 1, 1, 1, 1, 1, 1, 'calle 13', 13, 0, '', '', 3066, NULL, '2015-02-05 18:47:49', 1, NULL),
(5, 'caceres', 'marcela', 1, '25.228.692', 'Masculino', 1, '1976-06-24 00:00:00', 1, 1, 1, 1, 1, 1, 'las americas ', 2015, 0, '', '', 3600, NULL, '2015-02-05 18:50:08', 1, NULL),
(7, 'Sanchez', 'Maria Sol', 1, '38.095.22_', 'Femenino', 1, '1995-04-19 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-06 12:16:02', 1, NULL),
(7, 'Sanchez', 'Maria Sol', 1, '38.095.222', 'Masculino', 1, '1995-04-19 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-06 12:16:10', 1, NULL),
(7, 'Sanchez', 'Maria Sol', 1, '38.095.222', 'Femenino', 1, '1995-04-19 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-06 12:20:20', 1, NULL),
(7, 'Sanchez', 'Maria Sol', 1, '38.095.222', 'Masculino', 1, '1995-04-19 00:00:00', 1, 1, 1, 3, 2, 8, '', 0, 0, '', '', 0, NULL, '2015-02-06 12:20:46', 1, NULL),
(7, 'Sanchez', 'Maria Sol', 1, '38.095.222', 'Masculino', 1, '1995-04-19 00:00:00', 1, 1, 1, 3, 2, 8, 'Av. 25 de mayo 2020', 2020, 0, '', '', 3600, NULL, '2015-02-06 12:21:28', 1, NULL),
(7, 'Sanchez', 'Maria Sol', 1, '38.095.222', 'Masculino', 1, '1995-04-19 00:00:00', 1, 1, 1, 3, 2, 8, 'Av. 25 de mayo 2020', 2020, 0, '', '', 3600, NULL, '2015-02-06 12:23:22', 1, NULL),
(7, 'Sanchez', 'Maria Sol', 1, '38.095.222', 'Masculino', 1, '1995-04-19 00:00:00', 1, 1, 1, 3, 2, 8, 'Av. 25 de mayo 2020', 2020, 0, '', '', 3600, NULL, '2015-02-06 12:23:53', 1, NULL),
(7, 'Sanchez', 'Maria Sol', 1, '38.095.222', 'Masculino', 1, '1995-04-19 00:00:00', 1, 1, 1, 3, 2, 8, 'Av. 25 de mayo 2020', 2020, 0, '', '', 3600, NULL, '2015-02-06 12:24:08', 1, NULL),
(7, 'Sanchez', 'Maria Sol', 1, '38.095.222', 'Masculino', 1, '1995-04-19 00:00:00', 1, 1, 1, 3, 2, 8, 'Av. 25 de mayo 2020', 2020, 0, '', '', 3600, NULL, '2015-02-06 12:24:34', 1, NULL),
(7, 'Sanchez', 'Maria Sol', 1, '38.095.222', 'Masculino', 1, '1995-04-19 00:00:00', 1, 1, 1, 3, 2, 8, 'Av. 25 de mayo 2020', 2020, 0, '', '', 3600, NULL, '2015-02-06 12:25:02', 1, NULL),
(8, 'Dalmaso', 'Berta', 7, '11.252.555', 'Femenino', 3, '2022-05-15 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-06 12:47:53', 1, NULL),
(11, 'sosa', 'marcelo', 1, '14.141.414', 'Masculino', 1, '0000-00-00 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-06 12:50:38', 1, NULL),
(10, 'guanes', 'fernanda', 1, '14.141.441', 'Masculino', 1, '0000-00-00 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-06 12:51:32', 1, NULL),
(10, 'guanes', 'fernanda', 1, '14.141.441', 'Masculino', 1, '0000-00-00 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-06 12:51:44', 1, NULL),
(10, 'guanes', 'fernanda', 1, '14.141.441', 'Masculino', 1, '2014-04-14 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-06 12:52:58', 1, NULL),
(10, 'guanes', 'fernanda', 1, '14.141.441', 'Masculino', 1, '2000-04-14 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-06 12:53:32', 1, NULL),
(10, 'guanes', 'fernanda', 1, '14.141.441', 'Masculino', 1, '0000-00-00 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-06 12:54:08', 1, NULL),
(10, 'guanes', 'fernanda', 1, '14.141.441', 'Masculino', 1, '2010-11-14 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-06 12:54:16', 1, NULL),
(13, 'hitcher', 'marisol', 1, '21.111.111', 'Femenino', 1, '0000-00-00 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-06 13:13:32', 1, NULL),
(13, 'hitcher', 'marisol', 1, '21.111.111', 'Masculino', 1, '0000-00-00 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-06 13:15:20', 1, NULL),
(13, 'hitcher', 'marisol', 1, '21.111.111', 'Masculino', 1, '0000-00-00 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-06 13:18:30', 1, NULL),
(14, 'fernandez', 'paola', 1, '32.323.232', 'Femenino', 3, '1995-01-01 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-06 13:19:24', 1, NULL),
(13, 'hitcher', 'marisol', 1, '21.111.111', 'Masculino', 1, '1994-01-01 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-06 13:20:29', 1, NULL),
(14, 'fernandez', 'paola', 1, '32.323.232', 'Femenino', 3, '1995-01-01 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-06 13:26:36', 1, NULL),
(9, 'gerula', 'gustavo', 1, '14.114.588', 'Masculino', 1, '0000-00-00 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-07 12:20:21', 1, NULL),
(8, 'Dalmaso', 'Berta', 7, '11.252.555', 'Masculino', 3, '2022-05-15 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-09 10:24:25', 1, NULL),
(9, 'gerula', 'gustavo', 1, '14.114.588', 'Masculino', 1, '1975-06-10 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-09 10:32:57', 1, NULL),
(11, 'sosa', 'marcelo', 1, '14.141.414', 'Masculino', 1, '0000-00-00 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-09 10:33:51', 1, NULL),
(11, 'Sosa', 'Marcelo', 1, '14.141.414', 'Masculino', 1, '2000-02-15 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-09 10:34:19', 1, NULL),
(12, 'ortiz', 'diego', 1, '35.252.525', 'Masculino', 2, '1991-01-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-09 10:34:37', 1, NULL),
(12, 'Ortiz', 'Diego', 1, '35.252.525', 'Masculino', 2, '1991-01-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-09 10:35:37', 1, NULL),
(12, 'Ortiz', 'Diego', 1, '35.252.525', 'Masculino', 2, '1991-01-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-09 10:36:04', 1, NULL),
(10, 'guanes', 'fernanda', 1, '14.141.441', 'Masculino', 1, '0000-00-00 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-09 10:36:41', 1, NULL),
(14, 'fernandez', 'paola', 1, '32.323.232', 'Masculino', 3, '1995-01-01 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-09 10:37:00', 1, NULL),
(14, 'Fernandez', 'Paola', 1, '32.323.232', 'Masculino', 3, '1995-01-01 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-09 10:37:14', 1, NULL),
(4, 'perez', 'juan', 1, '26.888.987', 'Masculino', 1, '1977-12-19 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-09 10:37:34', 1, NULL),
(15, 'mendez', 'marcelino', 1, '25.696.871', 'Femenino', 4, '0000-00-00 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-09 10:38:07', 1, NULL),
(6, 'gimenez ', 'carmelo', 1, '25.666.25_', 'Masculino', 4, '0000-00-00 00:00:00', 1, 1, 1, 1, 1, 1, 'calle 13', 13, 0, '', '', 3066, NULL, '2015-02-09 10:40:07', 1, NULL),
(6, 'Gimenez ', 'Carmelo', 1, '25.666.250', 'Masculino', 4, '1980-02-12 00:00:00', 1, 1, 1, 1, 1, 1, 'calle 13', 13, 0, '', '', 3066, NULL, '2015-02-09 10:40:22', 1, NULL),
(13, 'hitcher', 'marisol', 1, '21.111.111', 'Femenino', 1, '1994-01-01 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-09 10:42:11', 1, NULL),
(5, 'caceres', 'marcela', 1, '25.228.692', 'Masculino', 1, '1976-06-24 00:00:00', 1, 1, 1, 1, 1, 1, 'las americas ', 2015, 0, '', '', 3600, NULL, '2015-02-09 10:42:39', 1, NULL),
(8, 'Dalmaso', 'Berta', 7, '11.252.555', 'Masculino', 3, '1995-05-15 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-09 10:43:06', 1, NULL),
(9, 'Gerula', 'Gustavo', 1, '14.114.588', 'Masculino', 1, '1975-06-10 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-09 10:43:22', 1, NULL),
(12, 'Ortiz', 'Diego', 1, '35.252.525', 'Masculino', 2, '1991-01-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-09 10:43:33', 1, NULL),
(11, 'Sosa', 'Marcelo', 1, '14.141.414', 'Masculino', 1, '2000-02-15 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-09 10:43:42', 1, NULL),
(17, 'Zaragoza', 'Estela Maria', 1, '25.236.698', 'Masculino', 2, '1981-06-25 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 3600, NULL, '2015-02-09 10:49:59', 1, NULL),
(17, 'Zaragoza', 'Estela Maria', 1, '25.236.698', 'Masculino', 2, '1981-06-25 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 3600, NULL, '2015-02-09 10:54:30', 1, NULL),
(2, 'Gerez', 'Cesar Walter', 1, '25.812.475', 'Masculino', 2, '1977-06-11 03:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-09 10:56:33', 1, NULL),
(2, 'Gerez', 'Cesar Walter', 1, '25.812.475', 'Masculino', 2, '1977-06-11 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-09 10:56:48', 1, NULL),
(17, 'Zaragoza', 'Estela Maria', 1, '25.236.698', 'Masculino', 2, '1981-06-25 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 3600, NULL, '2015-02-09 10:56:59', 1, NULL),
(18, 'Medina', 'Cristina ', 1, '25.123.369', 'Masculino', 1, '1980-02-15 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-09 10:57:52', 1, NULL),
(2, 'Gerez', 'Cesar Walter', 1, '25.812.475', 'Masculino', 2, '1977-06-11 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-09 11:23:35', 1, NULL),
(2, 'Gerez', 'Cesar Walter', 1, '25.812.475', 'Masculino', 2, '1977-06-11 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-09 11:23:37', 1, NULL),
(8, 'Dalmaso', 'Berta', 7, '11.252.555', 'Masculino', 3, '1995-05-15 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-09 11:45:58', 1, NULL),
(8, 'Dalmaso', 'Berta', 7, '11.252.555', 'Femenino', 3, '1995-05-15 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-09 11:47:41', 1, NULL),
(19, 'Román', 'Griselda', 1, '25.132.326', 'Femenino', 1, '1989-02-25 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-09 11:51:39', 1, NULL),
(11, 'Sosa', 'Marcelo', 1, '14.141.414', 'Masculino', 1, '2000-02-15 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-09 11:59:45', 1, NULL),
(5, 'Caceres', 'Marcela', 1, '25.228.692', 'Masculino', 1, '1976-06-24 00:00:00', 1, 1, 1, 1, 1, 1, 'las americas ', 2015, 0, '', '', 3600, NULL, '2015-02-09 12:17:58', 1, NULL),
(2, 'Gerez', 'Cesar Walter', 1, '25.812.475', 'Masculino', 2, '1977-06-11 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-09 12:18:43', 1, NULL),
(2, 'Gerez', 'Cesar Walter', 1, '25.812.475', 'Masculino', 2, '1977-06-11 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-09 12:18:46', 1, NULL),
(7, 'Sanchez', 'Maria Sol', 1, '38.095.222', 'Masculino', 1, '1995-04-19 00:00:00', 1, 1, 1, 3, 2, 8, 'Av. 25 de mayo 2020', 2022, 0, '', '', 3600, NULL, '2015-02-09 12:19:09', 1, NULL),
(6, 'Gimenez ', 'Carmelo', 1, '25.666.250', 'Masculino', 4, '1980-02-12 00:00:00', 1, 1, 1, 1, 1, 1, 'calle 13', 13, 0, '', '', 3066, NULL, '2015-02-09 12:36:08', 1, NULL),
(2, 'Gerez', 'Cesar Walter', 1, '25.812.475', 'Masculino', 2, '1977-06-11 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-09 12:36:39', 1, NULL),
(2, 'Gerez', 'Cesar Walter', 1, '25.812.475', 'Masculino', 2, '1977-06-11 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-09 12:36:43', 1, NULL),
(1, 'Mongelos', 'María Cristina', 1, '30.526.623', 'Masculino', 2, '1973-10-01 03:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-09 13:03:04', 1, NULL),
(1, 'Mongelos', 'María Cristina', 1, '30.526.623', 'Masculino', 2, '1973-10-01 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-09 13:03:07', 1, NULL),
(8, 'Dalmaso', 'Berta', 7, '11.252.555', 'Femenino', 3, '1995-05-15 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-09 16:23:03', 1, NULL),
(8, 'Dalmaso', 'Berta', 7, '1.263.656', 'Femenino', 3, '1995-05-15 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-09 16:23:11', 1, NULL),
(10, 'Guanes', 'Fernanda', 1, '14.141.441', 'Masculino', 1, '1980-02-25 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-09 16:23:43', 1, NULL),
(5, 'Caceres', 'Marcela', 1, '25.228.692', 'Masculino', 1, '1976-06-24 00:00:00', 1, 1, 1, 1, 1, 1, 'las americas ', 2015, 0, '', '', 3600, NULL, '2015-02-09 16:24:00', 1, NULL),
(21, 'Montenegro', 'Pedro Daniel', 1, '25.362.365', 'Masculino', 1, '1981-09-25 00:00:00', 1, 1, 1, 1, 1, 1, 'CORDOBA', 595, 0, '', '', 3600, NULL, '2015-02-09 16:28:48', 1, NULL),
(11, 'Sosa', 'Marcelo', 1, '14.141.414', 'Femenino', 1, '2000-02-15 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-09 17:24:12', 1, NULL),
(11, 'Sosa', 'Marcelo', 1, '4.141.414', 'Femenino', 1, '2000-02-15 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-09 17:24:42', 1, NULL),
(11, 'Sosa', 'Marcelo', 7, 'A44623232', 'Femenino', 1, '2000-02-15 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-09 17:28:06', 1, NULL),
(22, 'Acosta', 'David Sergio', 1, '35.326.369', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2015-02-09 18:07:17', 1, NULL),
(8, 'Dalmaso', 'Berta', 7, '1.263.656', 'Femenino', 3, '1995-05-15 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-10 10:50:25', 1, NULL),
(22, 'Acosta', 'David', 1, '35.326.369', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2015-02-10 11:37:00', 1, NULL),
(8, 'Dalmaso', 'Berta', 1, '35236326', 'Femenino', 3, '1995-05-15 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-10 16:40:05', 1, NULL),
(8, 'Dalmaso', 'Berta', 1, '3523632', 'Femenino', 3, '1995-05-15 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-10 16:42:58', 1, NULL),
(8, 'Dalmaso', 'Berta', 1, '3523632', 'Femenino', 3, '1995-05-15 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-10 18:04:55', 1, NULL),
(21, 'Montenegro', 'Pedro Daniel', 1, '25.362.365', 'Masculino', 1, '1981-09-25 00:00:00', 1, 1, 1, 1, 1, 1, 'CORDOBA', 595, 0, '', '', 3600, NULL, '2015-02-10 18:22:13', 1, NULL),
(31, 'Figeroa', 'Carlos', 3, '123ASD', 'Masculino', 1, '1980-02-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-11 10:37:46', 1, NULL),
(31, 'Figeroa', 'Carlos', 3, '123ASD', 'Masculino', 1, '1980-02-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-11 10:38:13', 1, NULL),
(31, 'Figeroa', 'Carlos', 3, '123123456', 'Masculino', 1, '1980-02-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-11 10:38:29', 1, NULL),
(31, 'Figeroa', 'Carlos', 3, '1231236', 'Masculino', 1, '1980-02-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-11 10:55:59', 1, NULL),
(8, 'Dalmaso', 'Berta', 1, '3523632', 'Femenino', 3, '1990-05-15 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-11 10:56:39', 1, NULL),
(18, 'Medina', 'Cristina ', 1, '25.123.369', 'Masculino', 1, '1980-02-15 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-11 10:58:48', NULL, 1),
(32, 'Acosta', 'Sebastian', 1, '32656987', 'Masculino', 1, '1981-12-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-11 11:10:54', 1, NULL),
(32, 'Acosta', 'Sebastian', 1, '32656987', 'Masculino', 1, '1981-12-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-11 11:11:36', 1, NULL),
(32, 'Acosta', 'Sebastian', 1, 'A32656987', 'Masculino', 1, '1981-12-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-11 11:12:03', 1, NULL),
(32, 'Acosta', 'Sebastian', 3, 'AB12356', 'Masculino', 1, '1981-12-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-11 11:12:32', 1, NULL),
(16, 'PERFECTO', 'JOSE', 1, '25.228.693', 'Masculino', 4, '1975-01-01 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-11 11:14:00', 1, NULL),
(16, 'Perfecto', 'José', 1, '25228693', 'Masculino', 4, '1975-01-01 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-11 11:14:08', 1, NULL),
(32, 'Acosta', 'Sebastian', 3, '12356', 'Masculino', 1, '1981-12-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-11 11:14:16', NULL, 1),
(20, 'Sandoval', 'Nelsón Oscar', 1, '25.323.365', 'Masculino', 1, '0000-00-00 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-11 11:14:37', NULL, 1),
(31, 'Figeroa', 'Carlos', 3, '1231236', 'Masculino', 1, '1980-02-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-11 11:15:31', 1, NULL),
(6, 'Giménez ', 'Carmelo', 1, '25.666.250', 'Masculino', 4, '1980-02-12 00:00:00', 1, 1, 1, 1, 1, 1, 'calle 13', 13, 0, '', '', 3066, NULL, '2015-02-11 11:16:23', 1, NULL),
(6, 'Giménez ', 'Carmelo', 3, 'B25566223', 'Masculino', 4, '1980-02-12 00:00:00', 1, 1, 1, 1, 1, 1, 'calle 13', 13, 0, '', '', 3066, NULL, '2015-02-11 11:20:33', 1, NULL),
(31, 'Figeroa', 'Carlos', 3, 'A44623232', 'Masculino', 1, '1980-02-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-11 11:20:41', 1, NULL),
(9, 'Gerula', 'Gustavo', 1, '14.114.588', 'Masculino', 1, '1975-06-10 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-11 12:04:11', 1, NULL),
(9, 'Gerula', 'Gustavo', 1, '14114588', 'Masculino', 1, '1975-06-10 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-11 12:04:16', 1, NULL),
(11, 'Sosa', 'Marcelo', 7, '1.236.326', 'Femenino', 1, '2000-02-15 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-11 12:04:26', 1, NULL),
(11, 'Sosa', 'Marcelo', 7, '1236326', 'Femenino', 1, '2000-02-15 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-11 12:04:44', 1, NULL),
(17, 'Zaragoza', 'Estela Maria', 1, '25.236.698', 'Masculino', 2, '1981-06-25 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 3600, NULL, '2015-02-11 13:31:17', 1, NULL),
(19, 'Román', 'Griselda', 1, '25.132.326', 'Femenino', 1, '1989-02-25 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-11 13:32:59', 1, NULL),
(19, 'Román', 'Griselda', 1, '25132326', 'Femenino', 1, '1989-02-25 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-11 13:48:09', 1, NULL),
(17, 'Zaragoza', 'Estela Maria', 1, '25236698', 'Masculino', 2, '1981-06-25 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 3600, NULL, '2015-02-11 13:50:50', 1, NULL),
(9, 'Gerula', 'Gustavo', 1, '1411458/8', 'Masculino', 1, '1975-06-10 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-11 13:51:16', 1, NULL),
(1, 'Mongelos', 'María Cristina', 1, '30.526.623', 'Masculino', 2, '1973-10-01 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-11 14:41:27', 1, NULL),
(17, 'Zaragoza', 'Estela Maria', 1, '25236698', 'Masculino', 2, '1981-06-25 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 3600, NULL, '2015-02-11 14:41:42', 1, NULL),
(33, 'Echeverria', 'Sebastian', 1, '25236698', 'Masculino', 1, '1981-02-21 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-11 14:41:54', 1, NULL),
(4, 'Perez', 'Juan', 1, '26.888.987', 'Masculino', 1, '1977-12-19 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-11 14:42:21', 1, NULL),
(9, 'Gerula', 'Gustavo', 1, '1411458/8', 'Masculino', 1, '1975-06-10 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-12 12:09:22', 1, NULL),
(35, 'Estigarribia', 'Enrique Ramón', 1, '2536598', 'Masculino', 2, '1980-12-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-12 12:52:29', 1, NULL),
(35, 'Estigarribia', 'Enrique Ramón', 1, '2536598', 'Masculino', 2, '1980-12-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-12 12:53:24', 1, NULL),
(35, 'Estigarribia', 'Enrique Ramón', 1, '2536598', 'Masculino', 2, '1980-12-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-12 12:53:35', 1, NULL),
(35, 'Estigarribia', 'Enrique Ramón', 1, '2536598', 'Masculino', 2, '1980-12-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-12 13:39:10', 1, NULL),
(35, 'Estigarribia', 'Enrique Ramón', 1, '2536598', 'Masculino', 2, '1980-12-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-12 13:39:20', 1, NULL),
(35, 'Estigarribia', 'Enrique Ramón', 1, '2536598', 'Masculino', 2, '1980-12-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-12 13:39:35', 1, NULL),
(1, 'Mongelos', 'María Cristina', 1, '30.526.623', 'Masculino', 2, '1973-10-01 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-12 13:42:28', 1, NULL),
(39, 'Fermin', 'Manuel', 1, '32569781', 'Masculino', 1, '1980-02-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-12 13:44:39', 1, NULL),
(40, 'Dalmaso', 'Mirta', 4, '123365', 'Femenino', 2, '1990-05-23 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-12 13:47:39', 1, NULL),
(41, 'Sanabria', 'Samuel Andrés', 1, '32654789', 'Masculino', 4, '1980-03-06 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-12 13:49:38', 1, NULL),
(40, 'Dalmaso', 'Mirta', 4, '123365', 'Masculino', 2, '1990-05-23 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-12 13:49:56', 1, NULL),
(40, 'Dalmaso', 'Mirta', 4, '123365', 'Femenino', 2, '1990-05-23 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-12 13:50:03', 1, NULL),
(9, 'Gerula', 'Gustavo', 1, '1411458/8', 'Masculino', 1, '1975-06-10 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-12 13:51:31', 1, NULL),
(9, 'Gerula', 'Gustavo', 1, '1411458/8', 'Femenino', 1, '1975-06-10 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-12 13:51:40', 1, NULL),
(42, 'Rivas', 'Raquel', 1, '13112312', 'Femenino', 1, '2012-02-13 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-12 13:52:20', NULL, 1),
(43, 'Maldonado', 'Ernesto Javier', 3, 'AB121351', 'Masculino', 1, '1980-12-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-12 14:04:34', 1, NULL),
(4, 'Perez', 'Juan', 1, '26888987', 'Masculino', 1, '1977-12-19 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-12 14:29:11', NULL, 1),
(39, 'Fermin', 'Manuel', 1, '32569781', 'Masculino', 1, '1980-02-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-12 14:30:35', NULL, 1),
(9, 'Gerula', 'Gustavo', 1, '1411458/8', 'Masculino', 1, '1975-06-10 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-12 14:37:32', 1, NULL),
(43, 'Maldonado', 'Ernesto Javier', 3, 'AB121351', 'Masculino', 1, '1980-12-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-12 14:43:11', 1, NULL),
(43, 'Maldonado', 'Ernesto Javier', 3, 'AB121351', 'Masculino', 1, '1980-12-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-12 17:07:18', 1, NULL),
(44, 'Acosta', 'Sergio', 1, '32659456', 'Masculino', 1, '1984-01-25 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-12 18:01:36', 1, NULL),
(45, 'Gonzalez', 'Gerardo', 1, '31654789', 'Masculino', 1, '1983-01-23 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-12 18:01:50', 1, NULL),
(31, 'Figeroa', 'Carlos', 3, 'A44623232', 'Masculino', 1, '1980-02-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-12 18:27:23', 1, NULL),
(9, 'Gerula', 'Gustavo', 1, '1411458/8', 'Masculino', 1, '1975-06-10 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-19 11:10:35', 1, NULL),
(9, 'Gerula', 'Gustavo', 1, '1411458/8', 'Masculino', 1, '1975-06-10 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-19 11:11:33', 1, NULL),
(9, 'Gerula', 'Gustavo', 1, '1411458/8', 'Masculino', 1, '1975-06-10 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-19 11:12:08', 1, NULL),
(40, 'Dalmaso', 'Mirta', 4, '123365', 'Femenino', 2, '1990-05-23 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-19 11:13:52', 1, NULL),
(40, 'Dalmaso', 'Mirta', 4, 'AB121351', 'Femenino', 2, '1990-05-23 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-19 11:14:02', 1, NULL),
(40, 'Dalmaso', 'Mirta', 3, 'AB121351', 'Femenino', 2, '1990-05-23 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-19 11:15:16', 1, NULL),
(40, 'Dalmaso', 'Mirta', 3, 'AB121351', 'Femenino', 2, '1990-05-23 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-19 11:15:46', 1, NULL),
(40, 'Dalmaso', 'Mirta', 3, 'AB121351', 'Femenino', 2, '1989-05-23 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-19 11:16:03', 1, NULL),
(40, 'Dalmaso', 'Mirta', 3, 'AB121351', 'Femenino', 2, '1989-05-23 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-19 11:41:54', 1, NULL),
(43, 'Maldonado', 'Ernesto Javier', 3, 'AB121351', 'Masculino', 1, '1980-12-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-19 11:41:59', 1, NULL),
(35, 'Estigarribia', 'Enrique Ramón', 1, '2536598', 'Masculino', 2, '1980-12-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-19 11:42:27', 1, NULL),
(1, 'Mongelos', 'María Cristina', 1, '30.526.623', 'Masculino', 2, '1973-10-01 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-19 11:43:28', 1, NULL),
(9, 'Gerula', 'Gustavo', 1, '1411458/8', 'Masculino', 1, '1975-06-10 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-19 11:55:13', 1, NULL),
(17, 'Zaragoza', 'Estela Maria', 1, '25236698', 'Masculino', 2, '1981-06-25 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 3600, NULL, '2015-02-19 14:21:50', 1, NULL),
(40, 'Dalmaso', 'Mirta', 3, 'AB121351', 'Femenino', 2, '1989-05-23 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-19 14:23:36', 1, NULL),
(25, 'Administrador', 'Administrador', 1, '123456789', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2015-02-20 13:16:01', 1, NULL),
(51, 'Centurion', 'Carlos', 1, '25369789', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2015-02-23 13:46:03', 1, NULL),
(9, 'Gerula', 'Gustavo', 1, '1411458/8', 'Masculino', 1, '1975-06-10 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-24 12:06:21', 1, NULL),
(12, 'Ortiz', 'Diego', 1, '35.252.525', 'Masculino', 2, '1991-01-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-24 12:08:50', 1, NULL),
(9, 'Gerula', 'Gustavo', 1, '1411458/8', 'Masculino', 1, '1975-06-10 00:00:00', 1, 1, 1, 2, 53, 1, '', 0, 0, '', '', 3621, NULL, '2015-02-24 15:27:29', 1, NULL),
(12, 'Ortiz', 'Diego', 1, '35252525', 'Masculino', 2, '1991-01-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-25 13:13:18', 1, NULL),
(19, 'Román', 'Griselda', 1, '25132326', 'Femenino', 1, '1989-02-25 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-25 13:16:22', 1, NULL),
(13, 'Hitcher', 'Marisol', 1, '21.111.111', 'Femenino', 1, '1994-01-01 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-26 11:40:07', NULL, 1),
(16, 'Perfecto', 'José', 1, '25228693', 'Masculino', 4, '1975-01-01 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-26 11:49:16', NULL, 1),
(21, 'Montenegro', 'Pedro Daniel', 1, '25362365', 'Masculino', 1, '1981-09-25 00:00:00', 1, 1, 1, 1, 1, 1, 'CORDOBA', 595, 0, '', '', 3600, NULL, '2015-02-26 11:49:52', NULL, 1),
(15, 'Mendez', 'Marcelino', 1, '25.696.871', 'Femenino', 4, '1981-03-02 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-26 11:50:14', NULL, 1),
(2, 'Gerez', 'Cesar Walter', 1, '25.812.475', 'Masculino', 2, '1977-06-11 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-26 11:50:18', NULL, 1),
(3, 'Gonzalez', 'Martin', 1, '26.211.892', 'Masculino', 1, '1978-10-18 00:00:00', 1, 1, 1, 5, 58, 3, 'dgdf', 123, 3, '5', '9', 3600, NULL, '2015-02-26 11:50:25', NULL, 1),
(46, 'Palacios', 'Miguel Angel', 1, '21258963', 'Masculino', 2, '1978-04-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-26 11:50:54', 1, NULL),
(46, 'Palacios', 'Miguel Angel', 1, '21258963', 'Masculino', 2, '1978-04-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-26 11:51:01', 1, NULL),
(46, 'Palacios', 'Miguel Angel', 1, '21258963', 'Masculino', 2, '1978-04-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-26 11:54:48', 1, NULL),
(47, 'Valdez ', 'Nestor Augusto', 1, '27299155', 'Masculino', 1, '1979-02-17 00:00:00', 1, 1, 1, 1, 53, 1, '', 0, 0, '', '', 0, NULL, '2015-02-26 11:55:07', NULL, 1),
(14, 'Fernandez', 'Paola', 1, '32.323.232', 'Masculino', 3, '1995-01-01 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-26 11:55:11', NULL, 1),
(8, 'Dalmaso', 'Berta', 1, '3523632', 'Femenino', 3, '1990-05-15 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-26 11:55:15', NULL, 1),
(12, 'Ortiz', 'Diego', 1, '35252525', 'Masculino', 2, '1991-01-12 00:00:00', 1, 1, 1, 1, 1, 1, 'Av. 25 de mayo ', 256, 0, '', '', 0, NULL, '2015-02-26 11:55:18', NULL, 1),
(7, 'Sanchez', 'Maria Sol', 1, '38.095.222', 'Masculino', 1, '1995-04-19 00:00:00', 1, 1, 1, 3, 2, 8, 'Av. 25 de mayo 2020', 2022, 0, '', '', 3600, NULL, '2015-02-26 11:55:22', NULL, 1),
(11, 'Sosa', 'Marcelo', 7, 'A12363/26', 'Femenino', 1, '2000-02-15 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-26 11:55:25', NULL, 1),
(31, 'Figeroa', 'Carlos', 3, 'A44623232', 'Masculino', 1, '1980-02-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-26 11:55:29', NULL, 1),
(6, 'Giménez ', 'Carmelo', 3, 'B25566223', 'Masculino', 4, '1980-02-12 00:00:00', 1, 1, 1, 1, 1, 1, 'calle 13', 13, 0, '', '', 3066, NULL, '2015-02-26 11:55:33', NULL, 1),
(46, 'Palacios', 'Miguel Angel', 1, '21258963', 'Masculino', 2, '1978-04-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-26 12:32:33', 1, NULL),
(44, 'Acosta', 'Sergio', 1, '32659456', 'Masculino', 1, '1984-01-25 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-26 12:33:29', 1, NULL),
(52, 'Figeroa', 'Gustavo', 1, '31691951', 'Masculino', 1, '1983-07-25 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-26 12:40:55', 1, NULL),
(54, 'Figeroa', 'Marcelo', 1, '31691957', 'Masculino', 1, '1980-05-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-26 12:41:05', 1, NULL),
(53, 'Román', 'Estela Maria', 1, '35687961', 'Masculino', 1, '1980-12-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-26 12:41:17', 1, NULL),
(54, 'Figeroa', 'Marcelo', 1, '31691957', 'Masculino', 1, '1980-05-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-26 14:03:29', 1, NULL),
(53, 'Román', 'Estela Maria', 1, '35687961', 'Masculino', 1, '1980-12-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-26 14:37:01', 1, NULL),
(50, 'Rodruigez', 'Santiago', 1, '32569781', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2015-02-26 14:56:17', 1, NULL),
(53, 'Román', 'Estela Maria', 1, '35687961', 'Femenino', 1, '1980-12-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-26 14:59:54', 1, NULL),
(56, 'Ruiz Diaz', 'Neslon', 1, '252369789', 'Masculino', 1, '1987-06-05 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-27 10:48:09', 1, NULL),
(56, 'Ruiz Diaz', 'Neslon', 1, '252369789', 'Masculino', 1, '1987-06-05 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-02-27 10:52:22', 1, NULL),
(56, 'Ruiz Diaz', 'Neslon', 1, '252369789', 'Masculino', 1, '1987-06-05 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 3600, NULL, '2015-02-27 10:52:46', 1, NULL),
(58, 'Navarrete', 'Daniell', 1, '32569789', 'Masculino', 1, '1980-02-25 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-03-02 10:15:43', 1, NULL),
(59, 'Rivarola', 'Federico Santiago', 1, '23258963', 'Masculino', 1, '1983-10-09 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-03-02 10:16:55', 1, NULL),
(58, 'Navarrete', 'Daniell', 1, '32569789', 'Masculino', 1, '1980-02-25 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-03-02 17:52:11', 1, NULL),
(52, 'Figeroa', 'Gustavo', 1, '31691951', 'Masculino', 1, '1983-07-25 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-03-02 18:29:33', 1, NULL),
(52, 'Figeroa', 'Gustavo', 1, '31691955', 'Masculino', 1, '1983-07-25 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-03-02 18:30:30', 1, NULL),
(52, 'Figeroa', 'Gustavo', 1, '31691955', 'Masculino', 1, '1983-07-25 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-03-02 18:31:25', 1, NULL),
(52, 'Figeroa', 'Gustavo', 1, '31691955', 'Masculino', 1, '1983-07-25 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-03-02 18:32:13', 1, NULL),
(52, 'Figeroa', 'Gustavo', 1, '3169195', 'Masculino', 1, '1983-07-25 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-03-02 18:35:29', 1, NULL),
(53, 'Román', 'Estela Maria', 1, '35687961', 'Femenino', 1, '1980-12-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-03-04 11:22:28', 1, NULL),
(53, 'Román', 'Estela Maria', 1, '35687961', 'Femenino', 1, '1980-12-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-03-04 11:22:40', 1, NULL),
(55, 'Acosta', 'Damian ', 1, '36256897', 'Masculino', 2, '1983-02-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-03-04 13:44:47', 1, NULL),
(55, 'Acosta', 'Damian ', 1, '36256897', 'Masculino', 2, '1983-02-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-03-04 13:45:01', 1, NULL),
(53, 'Román', 'Estela Maria', 1, '35687961', 'Femenino', 1, '1980-12-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-03-04 13:45:41', 1, NULL),
(56, 'Ruiz Diaz', 'Neslon', 1, '252369789', 'Masculino', 1, '1987-06-05 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 3600, NULL, '2015-03-04 13:46:27', 1, NULL),
(53, 'Román', 'Estela Maria', 1, '35687961', 'Femenino', 1, '1980-12-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-03-05 11:56:48', 1, NULL),
(53, 'Román', 'Estela Maria', 1, '35687961', 'Femenino', 1, '1980-12-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, NULL, '2015-03-05 11:57:00', 1, NULL),
(56, 'Ruiz Diaz', 'Neslon', 1, '252369789', 'Masculino', 1, '1987-06-05 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 3600, NULL, '2015-03-05 11:57:24', 1, NULL),
(56, 'Ruiz Diaz', 'Neslon', 1, '252369789', 'Masculino', 1, '1987-06-05 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 3600, NULL, '2015-03-05 12:21:59', 1, NULL),
(56, 'Ruiz Diaz', 'Neslon', 1, '252369789', 'Masculino', 1, '1987-06-05 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 3600, NULL, '2015-03-09 12:26:23', 1, NULL),
(56, 'Ruiz Diaz', 'Neslon', 1, '252369789', 'Masculino', 1, '1987-06-05 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 3600, NULL, '2015-03-09 12:26:30', 1, NULL),
(56, 'Ruiz Diaz', 'Neslon', 1, '252369789', 'Masculino', 1, '1987-06-05 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 3600, NULL, '2015-03-09 12:37:49', 1, NULL),
(62, 'Sanchez', 'David', 1, '2523269887', 'Masculino', 1, '1981-03-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, 'bsegovia', '2015-03-10 13:52:07', 1, NULL),
(17, 'Zaragoza', 'Estela Maria', 1, '25236698', 'Masculino', 2, '1981-06-25 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 3600, 'bsegovia', '2015-03-10 14:23:56', 1, NULL),
(17, 'Zaragoza', 'Estela Maria', 1, '25236698', 'Masculino', 2, '1981-06-25 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 3600, 'bsegovia', '2015-03-10 14:24:10', 1, NULL),
(62, 'Sanchez', 'David', 1, '12345678', 'Masculino', 1, '1981-03-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, 'esandoval', '2015-03-10 14:55:53', 1, NULL),
(56, 'Ruiz Diaz', 'Neslon', 1, '252369789', 'Masculino', 1, '1987-06-05 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 3600, 'bsegovia', '2015-03-11 12:43:17', 1, NULL),
(57, 'Miño', 'Jose', 1, '25236987', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'bsegovia', '2015-03-11 17:42:37', 1, NULL),
(25, 'Administrador', 'Admin', 1, '123456789', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'bsegovia', '2015-03-12 10:47:35', 1, NULL),
(40, 'Dalmaso', 'Mirta', 1, '2326565', 'Femenino', 2, '1989-05-23 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, 'bsegovia', '2015-03-12 13:40:43', 1, NULL),
(40, 'Dalmaso', 'Mirta', 1, '2326565', 'Femenino', 2, '1989-05-23 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, 'admin', '2015-03-12 14:03:03', 1, NULL),
(40, 'Dalmaso', 'Mirta', 1, '2326565', 'Femenino', 2, '1989-05-23 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, 'admin', '2015-03-12 14:03:13', 1, NULL),
(43, 'Maldonado', 'Ernesto Javier', 3, 'AB121351', 'Masculino', 1, '1980-12-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, 'admin', '2015-03-12 14:12:04', 1, NULL),
(66, 'Apellido', 'Nombre', 1, '323222', 'Masculino', 1, '2012-03-21 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, 'admin', '2015-03-12 14:20:47', 1, NULL),
(58, 'Navarrete', 'Daniel', 1, '32569789', 'Masculino', 1, '1980-02-25 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, 'admin', '2015-03-12 14:58:13', 1, NULL),
(58, 'Navarrete', 'Daniel', 1, '32569789', 'Masculino', 1, '1980-02-25 00:00:00', 1, 1, 1, 1, 1, 1, 'Independencia', 150, 0, '', '', 0, 'admin', '2015-03-12 14:59:05', 1, NULL),
(58, 'Navarrete', 'Daniel', 1, '32569789', 'Masculino', 1, '1980-02-25 00:00:00', 1, 1, 1, 1, 1, 1, 'Independencia', 150, 0, '', '', 0, 'admin', '2015-03-12 14:59:45', 1, NULL),
(40, 'Dalmaso', 'Mirta', 1, '2326565', 'Femenino', 2, '1989-05-23 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, 'bsegovia', '2015-03-13 11:20:44', 1, NULL),
(56, 'Ruiz Diaz', 'Neslon', 1, '252369789', 'Masculino', 1, '1987-06-05 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 3600, 'admin', '2015-03-13 12:31:37', 1, NULL),
(40, 'Dalmaso', 'Mirta', 1, '2326565', 'Femenino', 2, '1989-05-23 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, 'admin', '2015-03-13 12:33:08', 1, NULL),
(1, 'Mongelos', 'María Cristina', 1, '30526623', 'Femenino', 2, '1973-10-01 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, 'admin', '2015-03-13 12:33:25', 1, NULL),
(25, 'Administrador', 'Administrador Sistema', 1, '123456789', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', '2015-03-13 14:42:20', 1, NULL),
(25, 'Administrador', 'Administrador', 1, '123456789', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', '2015-03-13 17:12:56', 1, NULL),
(25, 'Administrador', 'Administrador', 1, '123456789', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', '2015-03-13 17:14:18', 1, NULL),
(25, 'Administrador', 'Administrador', 1, '123456789', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', '2015-03-13 17:23:52', 1, NULL),
(25, 'Administrador', 'Administrador', 1, '123456789', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', '2015-03-13 17:38:46', 1, NULL),
(68, 'Maldonado', 'Gustavo', 1, '25236981', 'Masculino', 1, '1980-03-12 00:00:00', 1, 1, 1, 5, 100, 1, '123', 0, 0, '', '', 0, 'admin', '2015-03-16 11:37:00', 1, NULL),
(25, 'Administrador', 'Administrador', 1, '123456789', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'bsegovia', '2015-03-17 15:06:56', 1, NULL),
(68, 'Maldonado', 'Sebastian', 1, '25236981', 'Masculino', 1, '1980-03-12 00:00:00', 1, 1, 1, 5, 100, 1, '123', 0, 0, '', '', 0, 'bsegovia', '2015-03-18 11:42:39', 1, NULL),
(67, 'Figeroa', 'Gustavo', 1, '25236987', 'Masculino', 1, '1982-03-25 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, 'bsegovia', '2015-03-18 11:42:48', 1, NULL),
(25, 'Administrador', 'Administrador', 1, '123456789', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'bsegovia', '2015-03-18 12:08:07', 1, NULL),
(25, 'Administrador', 'Administrador', 1, '123456789', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', '2015-03-18 12:52:02', 1, NULL),
(68, 'Maldonado', 'Sebastian', 1, '25236981', 'Masculino', 1, '1980-03-12 00:00:00', 1, 1, 1, 5, 53, 1, '123', 0, 0, '', '', 0, 'bsegovia', '2015-03-18 13:35:22', 1, NULL),
(67, 'Figeroa', 'Gustavo', 1, '25236987', 'Masculino', 1, '1982-03-25 00:00:00', 1, 1, 1, 2, 53, 1, '', 0, 0, '', '', 0, 'bsegovia', '2015-03-18 13:35:50', 1, NULL),
(67, 'Figeroa', 'Gustavo', 1, '25236987', 'Masculino', 1, '1982-03-25 00:00:00', 1, 1, 1, 2, 53, 1, '', 0, 0, '', '', 0, 'bsegovia', '2015-03-18 13:36:05', 1, NULL),
(68, 'Maldonado', 'Sebastian', 1, '25236981', 'Masculino', 1, '1980-03-12 00:00:00', 1, 1, 1, 5, 53, 1, 'Irigoyen', 260, 0, '', '', 3600, 'admin', '2015-03-20 14:48:29', 1, NULL),
(67, 'Figeroa', 'Gustavo', 1, '25236987', 'Masculino', 1, '1982-03-25 00:00:00', 1, 1, 1, 2, 53, 2, 'Córdoba ', 540, 0, '', '', 3600, 'admin', '2015-03-20 14:48:39', 1, NULL),
(73, 'Zaragoza', 'Natalia ', 1, '1231321', 'Femenino', 2, '2011-12-23 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, 'admin', '2015-03-20 15:13:28', 1, NULL),
(74, 'Sandoval', 'María Cristina', 1, '3213211', 'Femenino', 1, '2013-02-21 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, 'admin', '2015-03-20 15:14:20', 1, NULL),
(67, 'Figeroa', 'Gustavo', 1, '25236987', 'Masculino', 1, '1982-03-25 00:00:00', 1, 1, 1, 2, 53, 2, 'Córdoba ', 540, 0, '', '', 3600, 'admin', '2015-03-25 11:32:54', 1, NULL),
(68, 'Maldonado', 'Sebastian', 1, '25236981', 'Masculino', 1, '1980-03-12 00:00:00', 1, 1, 1, 5, 53, 1, 'Irigoyen', 260, 0, '', '', 3600, 'admin', '2015-03-25 11:33:09', 1, NULL),
(82, 'Candia', 'Mirta', 1, '12345', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', '2015-03-27 13:21:12', 1, NULL),
(82, 'Candia', 'Mirtha', 1, '17560453', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', '2015-03-27 13:21:29', 1, NULL),
(83, 'Arrua', 'Fernanda', 1, '1245', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', '2015-03-27 13:22:27', 1, NULL),
(84, 'iuuyyyyyyyyyyyyyyyyyyyyyy', 'ujiuyi', 1, '22222222', 'Masculino', 1, '2014-11-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, 'admin', '2015-03-27 17:21:15', 1, NULL),
(84, 'Segovia', 'Mario Luis', 1, '22222222', 'Masculino', 1, '2014-11-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, 'admin', '2015-03-27 17:22:22', 1, NULL),
(84, 'Segovia', 'Mario Luis', 1, '22222222', 'Masculino', 1, '1994-11-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, 'admin', '2015-03-30 12:22:47', 1, NULL),
(84, 'Segovia', 'Mario Luis', 1, '1234567', 'Masculino', 1, '1994-11-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, 'alovera', '2015-03-30 13:17:51', 1, NULL),
(84, 'Segovia', 'Mario Luis', 1, '1234567', 'Masculino', 1, '1994-11-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, 'alovera', '2015-03-30 13:17:57', 1, NULL),
(84, 'Segovia', 'Mario Luis', 1, '1234567', 'Masculino', 1, '1994-11-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, 'alovera', '2015-03-30 13:18:08', 1, NULL),
(75, 'Arevalo', 'Valeria Lujan', 1, '38576702', 'Femenino', 1, '1995-09-29 00:00:00', 1, 1, 1, 2, 53, 39, 'Av. Nestor Kirchner s/n', 0, 0, '', '', 3600, 'admin', '2015-03-30 13:19:08', 1, NULL),
(85, 'Gerez', 'Walter', 1, '26555531', 'Masculino', 2, '1979-02-11 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, 'admin', '2015-03-30 13:28:57', 1, NULL),
(84, 'Segovia', 'Mario Luis', 1, '1234567', 'Masculino', 1, '1994-11-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, 'admin', '2015-03-30 14:48:56', 1, NULL),
(84, 'Segovia', 'Mario Luis', 1, '1234567', 'Masculino', 1, '1994-11-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, 'admin', '2015-03-30 14:49:18', 1, NULL),
(84, 'Segovia', 'Mario Luis', 1, '1234567', 'Masculino', 1, '1994-11-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, 'admin', '2015-03-30 14:49:28', 1, NULL),
(84, 'Segovia', 'Mario Luis', 1, '1234567', 'Masculino', 1, '1994-11-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, 'admin', '2015-03-30 14:49:38', 1, NULL),
(84, 'Segovia', 'Mario Luis', 1, '1234567', 'Masculino', 1, '1994-11-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, 'admin', '2015-03-30 14:49:58', 1, NULL),
(84, 'Segovia', 'Mario Luis', 1, '1234567', 'Masculino', 1, '1994-11-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, 'admin', '2015-03-30 14:50:11', 1, NULL),
(84, 'Segovia', 'Mario Luis', 1, '1234567', 'Masculino', 1, '1994-11-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, 'admin', '2015-03-30 14:50:17', 1, NULL),
(84, 'Segovia', 'Mario Luis', 1, '1234567', 'Masculino', 1, '1994-11-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, 'admin', '2015-03-30 14:50:46', 1, NULL),
(84, 'Segovia', 'Mario Luis', 1, '1234567', 'Masculino', 1, '1994-11-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, 'admin', '2015-03-30 14:50:51', 1, NULL),
(83, 'Arrua', 'Fernanda', 1, '38191394', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', '2015-03-30 17:27:45', 1, NULL),
(83, 'Arrua', 'Fernanda', 1, '38191394', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', '2015-03-30 17:28:23', 1, NULL),
(84, 'Segovia', 'Mario Luis', 1, '1234567', 'Masculino', 1, '1994-11-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, 'admin', '2015-03-31 12:37:01', 1, NULL),
(84, 'Segovia', 'Mario Luis', 1, '1234567', 'Masculino', 1, '1994-11-12 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, 'dgomez', '2015-03-31 15:01:17', 1, NULL),
(87, 'Chirife', 'Rocio Elizabeth', 1, '31865565', 'Femenino', 1, '1985-05-06 00:00:00', 1, 1, 1, 2, 53, 39, 'paraguay', 4435, 0, '', '', 3600, 'dgomez', '2015-03-31 15:22:46', 1, NULL),
(88, 'Espinoza', 'Raquel Analia', 1, '32234090', 'Femenino', 1, '1986-06-04 00:00:00', 1, 1, 1, 2, 53, 3, 'uruguay', 556, 0, '', '', 3600, 'dgomez', '2015-03-31 15:33:19', 1, NULL),
(93, 'cardozo', 'julio emmanuel', 1, '32048532', 'Masculino', 1, '1986-03-11 00:00:00', 1, 1, 1, 2, 53, 31, '', 2, 100, '', '', 3600, 'mcandia', '2015-03-31 22:42:00', 1, NULL),
(95, 'CASTRO ', 'MARIA CECILIA', 1, '31071391', 'Femenino', 1, '1985-04-10 00:00:00', 1, 1, 1, 2, 53, 39, '', 2, 8, '', 'B', 3600, 'mcandia', '2015-03-31 23:09:28', 1, NULL),
(97, 'DUARTE', 'EMILIO EDUARDO', 1, '37911008', 'Masculino', 1, '1993-12-31 00:00:00', 1, 1, 1, 2, 53, 39, 'FILHO', 264, 0, '', '', 3600, 'mcandia', '2015-03-31 23:27:17', 1, NULL),
(97, 'DUARTE', 'EMILIO EDUARDO', 1, '37911008', 'Masculino', 1, '1993-12-31 00:00:00', 1, 1, 1, 2, 53, 39, 'FILHO', 264, 0, '', '', 3600, 'mcandia', '2015-03-31 23:32:23', 1, NULL),
(98, 'FARAY', 'CRISTIAN ALBERTO', 1, '31091337', 'Masculino', 1, '1985-11-03 00:00:00', 1, 1, 1, 5, 257, 39, 'DEAN FUNES Y NAPOLEON URIBURO', 0, 0, '', '', 36000, 'mcandia', '2015-03-31 23:42:08', 1, NULL),
(96, 'CAHPARRO', 'ALEJANDRA AGLAE', 1, '28781722', 'Femenino', 1, '1981-09-11 00:00:00', 1, 1, 1, 2, 53, 39, 'FUERZA AEREA Y NESTOR KIRCHNNER', 112, 0, '', 'G', 3600, 'cdorrego', '2015-03-31 23:45:16', 1, NULL),
(99, 'GALLARDO', 'MARIA BELEN', 1, '38378916', 'Femenino', 1, '1994-08-03 00:00:00', 1, 1, 1, 2, 53, 29, '', 13, 330, '', 'G 9', 3600, 'mcandia', '2015-03-31 23:52:56', 1, NULL);
INSERT INTO `aud_personas_log` (`id`, `apellido`, `nombre`, `tipodocumento_id`, `nrodocumento`, `sexo`, `estadocivil_id`, `fechanacimiento`, `lugarnacimiento_id`, `pais_id`, `provincia_id`, `departamento_id`, `localidad_id`, `barrio_id`, `calle`, `numero`, `manzana`, `piso`, `departamento`, `codigo_postal`, `usuario`, `fecha`, `modi`, `baja`) VALUES
(100, 'GALLARDO ', 'MARIA BELEN', 1, '38378917', 'Femenino', 1, '1994-08-03 00:00:00', 1, 1, 1, 2, 53, 29, '', 13, 330, '', 'G 9', 3600, 'mcandia', '2015-04-01 00:00:40', 1, NULL),
(100, 'GALLARDO ', 'MARIA BELEN', 1, '38378917', 'Femenino', 1, '1994-08-03 00:00:00', 1, 1, 1, 2, 53, 29, '', 13, 330, '', 'G 9', 3600, 'mcandia', '2015-04-01 00:02:30', 1, NULL),
(99, 'GALLARDO', 'MARIA BELEN', 1, '38378916', 'Femenino', 1, '1994-08-03 00:00:00', 1, 1, 1, 2, 53, 29, '', 13, 330, '', 'G 9', 3600, 'mcandia', '2015-04-01 00:06:28', 1, NULL),
(102, 'GONZALES', 'JOSE ENRIQUE', 1, '22486262', 'Masculino', 1, '1971-12-14 00:00:00', 1, 1, 1, 2, 53, 3, 'ARENALES ', 534, 0, '', '', 3600, 'mcandia', '2015-04-01 00:17:36', 1, NULL),
(103, 'GONZÁLES', 'MAURICIO NICOLAS', 1, '37585626', 'Masculino', 1, '1993-06-26 00:00:00', 1, 1, 1, 2, 53, 39, 'LIBERTAD', 1654, 0, '', '', 3600, 'mcandia', '2015-04-01 00:39:30', 1, NULL),
(104, 'LEAL', 'ROCIO ELIZABETH', 1, '35003057', 'Femenino', 1, '1989-10-15 00:00:00', 1, 1, 1, 2, 53, 1, 'CORDOBA', 1463, 0, '', '', 3600, 'mcandia', '2015-04-01 00:47:15', 1, NULL),
(105, 'LEZCANO', 'CARMEN MARIANELLA', 1, '36956567', 'Femenino', 1, '1992-07-16 00:00:00', 1, 1, 1, 2, 53, 39, '', 0, 8, '', 'S B', 36000, 'mcandia', '2015-04-01 00:57:17', 1, NULL),
(106, 'LEZCANO', 'MARIA LAURA', 1, '31671507', 'Femenino', 1, '1985-05-15 00:00:00', 1, 1, 1, 2, 53, 39, '', 5, 7, '', 'SB', 36000, 'mcandia', '2015-04-01 01:04:40', 1, NULL),
(107, 'MALDONADO', 'MELISA MARIANA', 1, '36955802', 'Femenino', 1, '1990-05-19 00:00:00', 1, 1, 1, 2, 53, 38, 'BERUTTI', 840, 0, '', '', 3600, 'mcandia', '2015-04-01 01:11:52', 1, NULL),
(108, 'MEDINA', 'ISMAEL REINALDO', 1, '24287653', 'Masculino', 1, '1974-12-30 00:00:00', 1, 1, 1, 2, 53, 39, 'ANTONIO BERUTTI', 1196, 0, '', '', 3600, 'mcandia', '2015-04-01 01:20:05', 1, NULL),
(93, 'cardozo', 'julio emmanuel', 1, '32048532', 'Masculino', 1, '1986-03-11 00:00:00', 1, 1, 1, 2, 53, 31, '', 2, 100, '', '', 3600, 'cdorrego', '2015-04-01 12:59:11', 1, NULL),
(100, 'GALLARDO ', 'MARIA  DE LOS ANGELES', 1, '38378917', 'Femenino', 1, '1994-08-03 00:00:00', 1, 1, 1, 2, 53, 29, '', 13, 330, '', 'G 9', 3600, 'cdorrego', '2015-04-01 13:01:16', 1, NULL),
(100, 'Gallardo', 'María de los Angeles', 1, '38378917', 'Femenino', 1, '1994-08-03 00:00:00', 1, 1, 1, 2, 53, 29, '', 13, 330, '', 'G 9', 3600, 'cdorrego', '2015-04-01 13:11:29', 1, NULL),
(76, 'Acosta', 'David', 1, '12345678', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'bsegovia', '2015-04-01 14:03:16', 1, NULL),
(77, 'Dorrego', 'Claudia', 1, '25889620', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'bsegovia', '2015-04-01 14:04:02', 1, NULL),
(78, 'Teresita', 'Brizuela', 1, '23269996', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'bsegovia', '2015-04-01 14:04:49', 1, NULL),
(80, 'Dasso', 'Hugo', 1, '1245678', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'bsegovia', '2015-04-01 14:05:24', 1, NULL),
(83, 'Arrua', 'Fernanda', 1, '38191394', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'bsegovia', '2015-04-01 14:05:55', 1, NULL),
(82, 'Candia', 'Mirtha', 1, '17560453', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'bsegovia', '2015-04-01 14:12:25', 1, NULL),
(25, 'Administrador', 'Administrador', 1, '123456789', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', '2015-04-01 21:05:17', 1, NULL),
(114, 'Zaragoza', 'Lidia', 1, '2532323', 'Femenino', 1, '0000-00-00 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, 'admin', '2015-04-07 12:57:36', 1, NULL),
(69, 'Segovia', 'Benjamin', 1, '31691957', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', '2015-04-13 17:33:37', 1, NULL),
(93, 'Cardozo', 'Julio Emmanuel', 1, '32048532', 'Masculino', 1, '1986-03-11 00:00:00', 1, 1, 1, 2, 53, 31, '', 2, 100, '', '', 3600, 'admin', '2015-04-14 15:42:14', 1, NULL),
(87, 'Chirife', 'Rocio Elizabeth', 1, '31865565', 'Femenino', 1, '1985-05-06 00:00:00', 1, 1, 1, 2, 53, 39, 'paraguay', 4435, 0, '', '', 3600, 'admin', '2015-04-16 15:21:24', 1, NULL),
(114, 'Zaragoza', 'Lidia', 1, '2532323', 'Femenino', 1, '0000-00-00 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, 'admin', '2015-04-21 15:14:18', 1, NULL),
(114, 'Zaragoza', 'Lidia', 1, '2532323', 'Femenino', 1, '0000-00-00 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, 'admin', '2015-04-21 15:14:28', 1, NULL),
(114, 'Zaragoza', 'Lidia', 1, '2532323', 'Femenino', 1, '0000-00-00 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, 'admin', '2015-04-21 15:15:43', 1, NULL),
(114, 'Zaragoza', 'Lidia', 1, '2532323', 'Femenino', 1, '0000-00-00 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 20, '', '', 0, 'admin', '2015-04-21 15:16:41', 1, NULL),
(85, 'Gerez', 'Walter', 1, '26555531', 'Masculino', 2, '1979-02-11 00:00:00', 1, 1, 1, 2, 53, 39, '', 0, 0, '', '', 0, 'admin', '2015-04-21 15:19:37', 1, NULL),
(114, 'Zaragoza', 'Lidia', 1, '2532323', 'Femenino', 1, '0000-00-00 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, 'admin', '2015-05-14 12:30:23', 1, NULL),
(114, 'Zaragoza', 'Lidia', 1, '2532323', 'Femenino', 1, '0000-00-00 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, 'admin', '2015-05-14 12:43:58', 1, NULL),
(104, 'LEAL', 'ROCIO ELIZABETH', 1, '35003057', 'Femenino', 1, '1989-10-15 00:00:00', 1, 1, 1, 2, 53, 1, 'CORDOBA', 1463, 0, '', '', 3600, 'admin', '2015-05-14 12:44:23', 1, NULL),
(85, 'Gerez', 'Walter', 1, '26555531', 'Masculino', 2, '1979-02-11 00:00:00', 1, 1, 1, 2, 53, 39, '', 0, 0, '', '', 0, 'admin', '2015-05-14 12:45:36', 1, NULL),
(85, 'Gerez', 'Walter', 1, '26555531', 'Masculino', 2, '1979-02-11 00:00:00', 1, 1, 1, 2, 53, 39, '', 0, 0, '', '', 0, 'admin', '2015-05-14 12:45:51', 1, NULL),
(88, 'Espinoza', 'Raquel Analia', 1, '32234090', 'Femenino', 1, '1986-06-04 00:00:00', 1, 1, 1, 2, 53, 3, 'uruguay', 556, 0, '', '', 3600, 'admin', '2015-05-14 13:46:12', 1, NULL),
(98, 'FARAY', 'CRISTIAN ALBERTO', 1, '31091337', 'Masculino', 1, '1985-11-03 00:00:00', 1, 1, 1, 5, 257, 39, 'DEAN FUNES Y NAPOLEON URIBURO', 0, 0, '', '', 36000, 'admin', '2015-05-14 13:53:55', 1, NULL),
(98, 'FARAY', 'CRISTIAN ALBERTO', 4, '31091337', 'Masculino', 1, '1985-11-03 00:00:00', 1, 1, 1, 5, 257, 39, 'DEAN FUNES Y NAPOLEON URIBURO', 0, 0, '', '', 36000, 'admin', '2015-05-14 13:56:38', 1, NULL),
(98, 'FARAY', 'CRISTIAN ALBERTO', 1, '31091337', 'Masculino', 1, '1985-11-03 00:00:00', 1, 1, 1, 5, 257, 39, 'DEAN FUNES Y NAPOLEON URIBURO', 0, 0, '', '', 36000, 'admin', '2015-05-14 13:56:46', 1, NULL),
(98, 'FARAY', 'CRISTIAN ALBERTO', 1, '31091337', 'Masculino', 1, '1985-11-03 00:00:00', 1, 1, 1, 5, 257, 39, '', 0, 0, '', '', 36000, 'admin', '2015-05-14 13:56:54', 1, NULL),
(98, 'FARAY', 'CRISTIAN ALBERTO', 1, '31091337', 'Masculino', 1, '1985-11-03 00:00:00', 1, 1, 1, 5, 257, 39, '', 0, 0, '', '', 36000, 'admin', '2015-05-14 13:58:16', 1, NULL),
(98, 'FARAY', 'CRISTIAN ALBERTO', 1, '31091337', 'Masculino', 1, '1985-11-03 00:00:00', 1, 1, 1, 5, 257, 39, '', 0, 0, '', '', 0, 'admin', '2015-05-14 14:09:01', 1, NULL),
(98, 'FARAY', 'CRISTIAN ALBERTO', 1, '31091337', 'Masculino', 1, '1985-11-03 00:00:00', 1, 1, 1, 5, 257, 35, 'Acosta', 25, 0, '', '', 0, 'admin', '2015-05-14 14:31:42', 1, NULL),
(85, 'Gerez', 'Walter', 1, '26555531', 'Masculino', 2, '1979-02-11 00:00:00', 1, 1, 1, 2, 53, 39, '', 0, 0, '', '', 0, 'admin', '2015-05-14 14:45:24', 1, NULL),
(93, 'Cardozo', 'Julio Emmanuel', 1, '32048532', 'Masculino', 1, '1986-03-11 00:00:00', 1, 1, 1, 2, 53, 31, '', 2, 100, '', '', 3600, 'admin', '2015-05-14 16:30:03', 1, NULL),
(111, 'Zayas', 'Carla Nair', 1, '399022687', 'Femenino', 1, '1997-03-12 00:00:00', 1, 1, 1, 5, 258, 38, '', 1, 32, '', '', 3600, 'admin', '2015-05-15 13:14:48', 1, NULL),
(88, 'Espinoza', 'Raquel Analia', 1, '32234090', 'Femenino', 1, '1997-06-04 00:00:00', 1, 1, 1, 2, 53, 3, 'uruguay', 556, 0, '', '', 3600, 'admin', '2015-05-15 14:19:46', 1, NULL),
(114, 'Zaragoza', 'Lidia', 1, '2532323', 'Femenino', 1, '0000-00-00 00:00:00', 1, 1, 1, 1, 1, 1, '', 0, 0, '', '', 0, 'admin', '2015-05-19 14:58:03', 1, NULL),
(114, 'Zaragoza', 'Lidia', 1, '2532323', 'Femenino', 1, '0000-00-00 00:00:00', 1, 1, 1, 1, 1, 39, '', 0, 0, '', '', 0, 'admin', '2015-05-20 17:46:12', 1, NULL),
(83, 'Arrua', 'Fernanda', 1, '38191394', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', '2015-05-21 14:26:26', 1, NULL),
(102, 'GONZALES', 'JOSE ENRIQUE', 1, '22486262', 'Masculino', 1, '1971-12-14 00:00:00', 1, 1, 1, 2, 53, 3, 'ARENALES ', 534, 0, '', '', 3600, 'admin', '2015-05-21 14:53:55', 1, NULL),
(102, 'GONZALES', 'JOSE ENRIQUE', 1, '22486262', 'Masculino', 1, '1971-12-14 00:00:00', 1, 1, 1, 2, 53, 39, 'ARENALES ', 534, 0, '', '', 3600, 'admin', '2015-05-21 14:55:33', 1, NULL),
(99, 'GALLARDO', 'MARIA BELEN', 1, '38378916', 'Femenino', 1, '1994-08-03 00:00:00', 1, 1, 1, 2, 53, 29, '', 13, 330, '', 'G 9', 3600, 'admin', '2015-05-21 17:12:43', 1, NULL),
(83, 'Arrua', 'Fernanda', 1, '38191394', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', '2015-05-22 13:52:43', 1, NULL),
(114, 'Zaragoza', 'Lidia', 1, '2532323', 'Femenino', 1, '0000-00-00 00:00:00', 1, 1, 1, 1, 1, 39, 'SARMIENTO ', 520, 0, '', '', 0, 'admin', '2015-05-26 11:23:59', 1, NULL),
(114, 'Zaragoza', 'Lidia', 1, '2532323', 'Femenino', 1, '1998-07-25 00:00:00', 1, 1, 1, 1, 1, 39, 'SARMIENTO ', 520, 0, '', '', 0, 'admin', '2015-05-26 16:49:33', 1, NULL),
(114, 'Zaragoza', 'Lidia', 1, '2532323', 'Femenino', 1, '1998-07-25 00:00:00', 1, 1, 1, 1, 1, 39, 'SARMIENTO ', 520, 0, '', '', 0, 'admin', '2015-05-26 17:08:18', 1, NULL),
(69, 'Segovia', 'Benjamin', 1, '31691957', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', '2015-06-01 12:14:54', 1, NULL),
(69, 'Segovia', 'Benjamin', 1, '31691957', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', '2015-06-01 12:15:10', 1, NULL),
(106, 'LEZCANO', 'MARIA LAURA', 1, '31671507', 'Femenino', 1, '1985-05-15 00:00:00', 1, 1, 1, 2, 53, 39, '', 5, 7, '', 'SB', 36000, 'admin', '2015-06-02 18:08:39', 1, NULL),
(114, 'Zaragoza', 'Lidia', 1, '2532323', 'Femenino', 1, '1998-07-25 00:00:00', 1, 1, 1, 1, 1, 39, 'SARMIENTO ', 520, 0, '', '', 0, 'admin', '2015-06-04 14:21:06', 1, NULL),
(113, 'Ortiz', 'Orlando Gabriel', 1, '39719162', 'Masculino', 1, '1996-06-16 00:00:00', 1, 1, 1, 2, 53, 39, 'paraguay', 4145, 0, '', '', 3600, 'admin', '2015-06-04 14:42:25', 1, NULL),
(89, 'Godo', 'sabrina', 1, '40084936', 'Femenino', 1, '1997-01-27 00:00:00', 1, 1, 1, 2, 53, 39, 'san martin', 127, 0, '', '', 3600, 'admin', '2015-06-04 14:50:48', 1, NULL),
(114, 'Zaragoza', 'Lidia', 1, '2532323', 'Femenino', 1, '1998-07-25 00:00:00', 1, 1, 1, 1, 1, 39, 'SARMIENTO ', 520, 0, '', '', 0, 'admin', '2015-06-16 13:39:25', 1, NULL),
(114, 'Zaragoza', 'Lidia', 1, '2532323', 'Femenino', 1, '1998-07-25 00:00:00', 1, 1, 1, 1, 1, 39, 'SARMIENTO ', 520, 0, '', '', 0, 'admin', '2015-06-16 15:39:41', 1, NULL),
(85, 'Gerez', 'Walter', 1, '26555531', 'Masculino', 2, '1979-02-11 00:00:00', 1, 1, 1, 2, 53, 39, '', 0, 0, '', '', 0, 'admin', '2015-06-22 14:34:12', 1, NULL),
(85, 'Gerez', 'Walter', 1, '26555531', 'Masculino', 2, '1979-02-11 00:00:00', 1, 1, 1, 2, 53, 39, '', 0, 0, '', '', 0, 'admin', '2015-06-22 14:34:18', 1, NULL),
(85, 'Gerez', 'Walter', 1, '26555531', 'Masculino', 2, '1979-02-11 00:00:00', 1, 1, 1, 2, 53, 39, '', 0, 0, '', '', 0, 'admin', '2015-06-22 14:34:33', 1, NULL),
(105, 'LEZCANO', 'CARMEN MARIANELLA', 1, '36956567', 'Femenino', 1, '1992-07-16 00:00:00', 1, 1, 1, 2, 53, 39, '', 0, 8, '', 'S B', 36000, 'admin', '2015-07-10 14:21:35', 1, NULL),
(104, 'LEAL', 'ROCIO ELIZABETH', 1, '35003057', 'Femenino', 1, '1989-10-15 00:00:00', 1, 1, 1, 2, 53, 1, 'CORDOBA', 1463, 0, '', '', 3600, 'admin', '2015-07-10 14:43:12', 1, NULL),
(115, 'Mendieta', 'Oscar', 1, '32159789', 'Masculino', 1, '1984-05-12 00:00:00', 1, 1, 1, 2, 54, 39, 'San Martín', 120, 0, '', '', 3600, 'admin', '2015-07-15 13:24:14', 1, NULL),
(104, 'LEAL', 'ROCIO ELIZABETH', 1, '35003057', 'Femenino', 1, '1989-10-15 00:00:00', 1, 1, 1, 2, 53, 39, 'CORDOBA', 1463, 0, '', '', 3600, 'admin', '2015-07-27 18:16:06', 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aud_provincias_log`
--

CREATE TABLE IF NOT EXISTS `aud_provincias_log` (
  `id` int(11) NOT NULL,
  `pais_id` int(11) DEFAULT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aud_regimenes_log`
--

CREATE TABLE IF NOT EXISTS `aud_regimenes_log` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `aud_regimenes_log`
--

INSERT INTO `aud_regimenes_log` (`id`, `descripcion`, `usuario`, `fecha`, `modi`, `baja`) VALUES
(4, 'Anual', NULL, '2015-02-05 17:18:34', NULL, 1),
(5, 'Cuatrimestral', NULL, '2015-02-05 17:18:37', NULL, 1),
(6, 'Semestral', NULL, '2015-02-05 17:18:40', NULL, 1),
(3, 'A distancia', NULL, '2015-02-05 17:22:54', NULL, 1),
(2, 'Semipresencial', NULL, '2015-02-05 17:22:56', NULL, 1),
(1, 'Presencial', NULL, '2015-02-05 17:22:58', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aud_relacionesfamiliares_log`
--

CREATE TABLE IF NOT EXISTS `aud_relacionesfamiliares_log` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aud_tipodocumentos_log`
--

CREATE TABLE IF NOT EXISTS `aud_tipodocumentos_log` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `aud_tipodocumentos_log`
--

INSERT INTO `aud_tipodocumentos_log` (`id`, `descripcion`, `usuario`, `fecha`, `modi`, `baja`) VALUES
(2, 'DNID', NULL, '2015-02-10 18:09:04', NULL, 1),
(3, 'DNIT', NULL, '2015-02-10 18:09:45', 1, NULL),
(4, 'DNIC', NULL, '2015-02-10 18:09:53', 1, NULL),
(5, 'DNI – EA', NULL, '2015-02-10 18:10:02', NULL, 1),
(6, 'DNI – EB', NULL, '2015-02-10 18:10:02', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aud_tiposcarreras_log`
--

CREATE TABLE IF NOT EXISTS `aud_tiposcarreras_log` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `aud_tiposcarreras_log`
--

INSERT INTO `aud_tiposcarreras_log` (`id`, `descripcion`, `usuario`, `fecha`, `modi`, `baja`) VALUES
(1, 'Grado', NULL, '2015-02-10 13:10:46', 1, NULL),
(2, 'Posgrado', NULL, '2015-02-10 13:10:57', 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aud_tiposduraciones_log`
--

CREATE TABLE IF NOT EXISTS `aud_tiposduraciones_log` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aud_tituloshabilitantes_log`
--

CREATE TABLE IF NOT EXISTS `aud_tituloshabilitantes_log` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `barrios`
--

CREATE TABLE IF NOT EXISTS `barrios` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `localidad_id` int(10) unsigned NOT NULL,
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `barrios_localidad_id_foreign` (`localidad_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=40 ;

--
-- Volcado de datos para la tabla `barrios`
--

INSERT INTO `barrios` (`id`, `descripcion`, `localidad_id`, `usuario_alta`, `fecha_alta`, `usuario_modi`, `fecha_modi`, `created_at`, `updated_at`) VALUES
(1, 'Don Bosco', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Independencia', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'San Miguel', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'San Francisco', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'Villa Lourdes', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'El resguardo', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'San Agustín', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 'Bernardino Rivadavia', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 'Villa Hermosa', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 'Barrio Obrero', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 'La Pilar', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 'Mariano Moreno', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 'Luis Jorge Fontana', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 'San Juan Bautista', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 'Nuestra señora de Luján', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 'La Paz', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 'Juan Manuel de Rosas', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, 'San Pedro', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 'Virgen de Itatí', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 'El PUCÚ', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, 'Emilio Tomás', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 'El Palmar', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, 'Coluccio', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(24, 'Sagrado Corazón de María', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(25, 'Ricardo Balbín', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26, 'Municipal', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(27, 'Santa Rosa', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(28, '12 de octubre', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(29, 'Venezuela', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(30, 'Irigoyen', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(31, 'Parque Urbano', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(32, '7 de Noviembre', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(33, 'San Juan I', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(34, 'Antenor Gauna', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(35, '8 de octubre', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(36, 'Juan Domindo Perón', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(37, 'Eva Perón', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(38, 'El Porvenir', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(39, 'Otro', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Disparadores `barrios`
--
DROP TRIGGER IF EXISTS `tr_barrios_baja_log`;
DELIMITER //
CREATE TRIGGER `tr_barrios_baja_log` AFTER DELETE ON `barrios`
 FOR EACH ROW insert into aud_barrios_log (id,localidad_id,descripcion,usuario,fecha,baja)
values (OLD.id,OLD.localidad_id,OLD.descripcion, OLD.usuario_modi,NOW(), 1)
//
DELIMITER ;
DROP TRIGGER IF EXISTS `tr_barrios_modi_log`;
DELIMITER //
CREATE TRIGGER `tr_barrios_modi_log` AFTER UPDATE ON `barrios`
 FOR EACH ROW insert into aud_barrios_log (id,localidad_id,descripcion,usuario,fecha,modi)
values (OLD.id,OLD.localidad_id,OLD.descripcion, NEW.usuario_modi,NOW(), 1)
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `becas`
--

CREATE TABLE IF NOT EXISTS `becas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `inscripcion_id` int(10) unsigned NOT NULL,
  `alumno_id` int(10) unsigned NOT NULL,
  `carrera_id` int(10) unsigned DEFAULT NULL,
  `ciclolectivo_id` int(10) unsigned DEFAULT NULL,
  `becado` tinyint(1) NOT NULL DEFAULT '0',
  `becafechainicio` timestamp NULL DEFAULT NULL,
  `becafechafin` timestamp NULL DEFAULT NULL,
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `becas_inscripcion_id_foreign` (`inscripcion_id`),
  KEY `becas_alumno_id_foreign` (`alumno_id`),
  KEY `becas_carrera_id_foreign` (`carrera_id`),
  KEY `becas_ciclolectivo_id_foreign` (`ciclolectivo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Volcado de datos para la tabla `becas`
--

INSERT INTO `becas` (`id`, `inscripcion_id`, `alumno_id`, `carrera_id`, `ciclolectivo_id`, `becado`, `becafechainicio`, `becafechafin`, `usuario_alta`, `fecha_alta`, `usuario_modi`, `fecha_modi`, `created_at`, `updated_at`) VALUES
(6, 54, 65, 28, 7, 1, '2015-03-01 00:00:00', '2015-12-01 00:00:00', 'admin', '2015-04-01 00:00:00', NULL, NULL, '2015-04-01 21:58:29', '2015-04-01 21:58:29'),
(7, 55, 53, 32, 7, 1, '2015-03-01 00:00:00', '2015-12-01 00:00:00', 'admin', '2015-04-15 00:00:00', NULL, NULL, '2015-04-15 12:36:41', '2015-04-15 12:36:41'),
(8, 53, 59, 28, 7, 1, '2015-03-01 00:00:00', '2015-12-01 00:00:00', 'admin', '2015-04-15 00:00:00', NULL, NULL, '2015-04-15 12:54:49', '2015-04-15 12:54:49'),
(9, 60, 45, 28, 7, 1, '2015-02-01 00:00:00', '2015-12-01 00:00:00', 'admin', '2015-05-19 00:00:00', NULL, NULL, '2015-05-19 12:19:08', '2015-05-19 12:19:08'),
(10, 80, 73, 32, 7, 1, '2015-08-01 00:00:00', '2015-12-01 00:00:00', 'admin', '2015-07-29 00:00:00', NULL, NULL, '2015-07-29 12:20:18', '2015-07-29 12:20:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carreras`
--

CREATE TABLE IF NOT EXISTS `carreras` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `organizacion_id` int(10) unsigned NOT NULL,
  `carrera` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `nroresolucion` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Abreviatura` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `carreranivel_id` int(10) unsigned DEFAULT NULL,
  `tipocarrera_id` int(10) unsigned DEFAULT NULL,
  `regimen_id` int(10) unsigned DEFAULT NULL,
  `tipoduracion_id` int(10) unsigned DEFAULT NULL,
  `duracion` int(11) DEFAULT NULL,
  `modalidad_id` int(10) unsigned DEFAULT NULL,
  `cargahorariacatedra` int(11) DEFAULT NULL,
  `cargahorariareloj` int(11) DEFAULT NULL,
  `areaocupacional_id` int(10) unsigned DEFAULT NULL,
  `activa` tinyint(1) NOT NULL DEFAULT '0',
  `exameningreso` tinyint(1) NOT NULL DEFAULT '0',
  `observaciones` varchar(8000) COLLATE utf8_unicode_ci NOT NULL,
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `titulootorgado_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `carreras_organizacion_id_foreign` (`organizacion_id`),
  KEY `carreras_carreranivel_id_foreign` (`carreranivel_id`),
  KEY `carreras_tipocarrera_id_foreign` (`tipocarrera_id`),
  KEY `carreras_regimen_id_foreign` (`regimen_id`),
  KEY `carreras_tipoduracion_id_foreign` (`tipoduracion_id`),
  KEY `carreras_modalidad_id_foreign` (`modalidad_id`),
  KEY `carreras_areaocupacional_id_foreign` (`areaocupacional_id`),
  KEY `carreras_titulootorgado_id_foreign` (`titulootorgado_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=35 ;

--
-- Volcado de datos para la tabla `carreras`
--

INSERT INTO `carreras` (`id`, `organizacion_id`, `carrera`, `nroresolucion`, `Abreviatura`, `carreranivel_id`, `tipocarrera_id`, `regimen_id`, `tipoduracion_id`, `duracion`, `modalidad_id`, `cargahorariacatedra`, `cargahorariareloj`, `areaocupacional_id`, `activa`, `exameningreso`, `observaciones`, `usuario_alta`, `fecha_alta`, `usuario_modi`, `fecha_modi`, `created_at`, `updated_at`, `titulootorgado_id`) VALUES
(28, 1, 'TECNICATURA SUPERIOR EN INSTRUMENTACIÓN QUIRURGICA', ' 5656/14', 'TEC.SUP.EN I.Q', 1, 2, 9, 3, 3, 2, 4016, 2667, 1, 1, 1, '', 'cdorrego', '2015-03-31 00:00:00', 'admin', '2015-04-01 00:00:00', '2015-03-31 23:17:04', '2015-04-01 12:41:42', 2),
(29, 1, 'TECNICATURA SUPERIOR EN HEMOTERAPIA', '  5876/14', 'TEC. SUP. HEMO.', 1, 2, 9, 3, 3, 2, 3154, 2102, 1, 1, 1, '', 'cdorrego', '2015-03-31 00:00:00', 'admin', '2015-05-14 00:00:00', '2015-03-31 23:21:28', '2015-05-14 12:32:38', 1),
(30, 1, 'TECNICATURA SUPERIOR EN SALUD MATERNO INFANTIL', ' 6693/14', 'TEC. SUP. en SMI', 1, 2, 9, 3, 3, 2, 2436, 1622, 1, 1, 1, '', 'cdorrego', '2015-03-31 00:00:00', 'admin', '2015-05-14 00:00:00', '2015-03-31 23:25:17', '2015-05-14 12:32:57', 1),
(31, 1, 'TECNICATURA SUPERIOR EN EMERGENCIAS Y DESASTRES', '   0140/15', 'TEC. SUP. en EyD', 1, 2, 9, 3, 3, 2, 2880, 1920, 1, 1, 1, '', 'cdorrego', '2015-03-31 00:00:00', 'admin', '2015-05-14 00:00:00', '2015-03-31 23:32:07', '2015-05-14 12:33:15', 1),
(32, 1, 'TECNICATURA EN MEDICINA NUCLEAR', '', 'TEC EN M.N', 1, 2, 9, 3, 3, 2, 0, 0, 1, 1, 1, '', 'cdorrego', '2015-04-01 00:00:00', NULL, NULL, '2015-04-01 12:57:42', '2015-04-01 12:57:42', 1),
(33, 1, 'TECNICATURA CARRERA 2016', '    2121', 'PC2016', 1, 2, 9, 3, 3, 2, 0, 0, 1, 1, 0, '', 'admin', '2015-04-21 00:00:00', 'admin', '2015-05-21 00:00:00', '2015-04-21 12:40:24', '2015-05-21 12:40:43', 1),
(34, 1, 'TECNICATURA SUPERIOR EN ENFERMERIA', '1232', 'TSE', 1, 2, 9, 3, 3, 2, 0, 0, 1, 1, 0, '', 'admin', '2015-04-22 00:00:00', NULL, NULL, '2015-04-22 13:14:13', '2015-04-22 13:14:13', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrerasniveles`
--

CREATE TABLE IF NOT EXISTS `carrerasniveles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `carrerasniveles`
--

INSERT INTO `carrerasniveles` (`id`, `descripcion`, `usuario_alta`, `fecha_alta`, `usuario_modi`, `fecha_modi`, `created_at`, `updated_at`) VALUES
(1, 'Terciario', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Universitario', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cicloslectivos`
--

CREATE TABLE IF NOT EXISTS `cicloslectivos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `organizacion_id` int(10) unsigned DEFAULT NULL,
  `descripcion` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `fechainicio` timestamp NULL DEFAULT NULL,
  `fechafin` timestamp NULL DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '0',
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `cicloslectivos_organizacion_id_foreign` (`organizacion_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `cicloslectivos`
--

INSERT INTO `cicloslectivos` (`id`, `organizacion_id`, `descripcion`, `fechainicio`, `fechafin`, `activo`, `usuario_alta`, `fecha_alta`, `usuario_modi`, `fecha_modi`, `created_at`, `updated_at`) VALUES
(7, 1, '2015', '2015-03-16 00:00:00', '2015-12-31 00:00:00', 1, 'admin', '2015-03-13 00:00:00', 'admin', '2015-06-25 00:00:00', '2015-03-13 17:51:40', '2015-06-25 13:11:23'),
(8, 1, ' 2014', '2014-08-19 00:00:00', '2015-07-03 00:00:00', 0, 'admin', '2015-04-16 00:00:00', 'admin', '2015-05-20 00:00:00', '2015-04-16 15:15:11', '2015-05-20 13:33:27'),
(9, 1, '2016', '2016-03-03 00:00:00', '2016-12-12 00:00:00', 0, 'admin', '2015-04-21 00:00:00', 'admin', '2015-05-20 00:00:00', '2015-04-21 12:41:28', '2015-05-21 14:49:13');

--
-- Disparadores `cicloslectivos`
--
DROP TRIGGER IF EXISTS `tr_cicloslectivos_baja_log`;
DELIMITER //
CREATE TRIGGER `tr_cicloslectivos_baja_log` AFTER DELETE ON `cicloslectivos`
 FOR EACH ROW insert into aud_cicloslectivos_log (id,organizacion_id,descripcion,fechainicio,fechafin,activo,usuario,fecha,baja)
values (OLD.id,OLD.organizacion_id,OLD.descripcion,OLD.fechainicio,OLD.fechafin,OLD.activo,OLD.usuario_modi,NOW(), 1)
//
DELIMITER ;
DROP TRIGGER IF EXISTS `tr_cicloslectivos_modi_log`;
DELIMITER //
CREATE TRIGGER `tr_cicloslectivos_modi_log` AFTER UPDATE ON `cicloslectivos`
 FOR EACH ROW insert into aud_cicloslectivos_log (id,organizacion_id,descripcion,fechainicio,fechafin,activo,usuario,fecha,modi)
values (OLD.id,OLD.organizacion_id,OLD.descripcion,OLD.fechainicio,OLD.fechafin,OLD.activo,NEW.usuario_modi,NOW(), 1)
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ContactoPersonas`
--

CREATE TABLE IF NOT EXISTS `ContactoPersonas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `persona_id` int(10) unsigned NOT NULL,
  `contacto_id` int(10) unsigned NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `contactopersonas_persona_id_foreign` (`persona_id`),
  KEY `contactopersonas_contacto_id_foreign` (`contacto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contactos`
--

CREATE TABLE IF NOT EXISTS `contactos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `contactos`
--

INSERT INTO `contactos` (`id`, `descripcion`, `usuario_alta`, `fecha_alta`, `usuario_modi`, `fecha_modi`, `created_at`, `updated_at`) VALUES
(1, 'Particular', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Laboral', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Correo', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'Sitio Web', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Disparadores `contactos`
--
DROP TRIGGER IF EXISTS `tr_contactos_baja_log`;
DELIMITER //
CREATE TRIGGER `tr_contactos_baja_log` AFTER DELETE ON `contactos`
 FOR EACH ROW insert into aud_contactos_log (id,descripcion,usuario,fecha,baja)
values (OLD.id,OLD.descripcion, OLD.usuario_modi,NOW(), 1)
//
DELIMITER ;
DROP TRIGGER IF EXISTS `tr_contactos_modi_log`;
DELIMITER //
CREATE TRIGGER `tr_contactos_modi_log` AFTER UPDATE ON `contactos`
 FOR EACH ROW insert into aud_contactos_log (id,descripcion,usuario,fecha,modi)
values (OLD.id,OLD.descripcion, NEW.usuario_modi,NOW(), 1)
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacto_organizacion`
--

CREATE TABLE IF NOT EXISTS `contacto_organizacion` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `organizacion_id` int(10) unsigned NOT NULL,
  `contacto_id` int(10) unsigned NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `contacto_organizacion_organizacion_id_foreign` (`organizacion_id`),
  KEY `contacto_organizacion_contacto_id_foreign` (`contacto_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=30 ;

--
-- Volcado de datos para la tabla `contacto_organizacion`
--

INSERT INTO `contacto_organizacion` (`id`, `organizacion_id`, `contacto_id`, `descripcion`, `usuario_alta`, `fecha_alta`, `usuario_modi`, `fecha_modi`, `created_at`, `updated_at`) VALUES
(25, 1, 1, '(3704)-421840 / 431868', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26, 1, 3, 'contacto@issformosa.edu.ar', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(27, 1, 4, 'http://issformosa.edu.ar/', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(29, 11, 1, '3704-895623', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Disparadores `contacto_organizacion`
--
DROP TRIGGER IF EXISTS `tr_contacto_organizacion_baja_log`;
DELIMITER //
CREATE TRIGGER `tr_contacto_organizacion_baja_log` AFTER DELETE ON `contacto_organizacion`
 FOR EACH ROW insert into aud_contacto_organizacion_log (id,organizacion_id,contacto_id,descripcion,usuario,fecha,baja)
values (OLD.id,OLD.organizacion_id,OLD.contacto_id,OLD.descripcion, OLD.usuario_modi,NOW(), 1)
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacto_organizaciones`
--

CREATE TABLE IF NOT EXISTS `contacto_organizaciones` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `organizacion_id` int(10) unsigned NOT NULL,
  `contacto_id` int(10) unsigned NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `contacto_organizaciones_organizacion_id_foreign` (`organizacion_id`),
  KEY `contacto_organizaciones_contacto_id_foreign` (`contacto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacto_persona`
--

CREATE TABLE IF NOT EXISTS `contacto_persona` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `persona_id` int(10) unsigned NOT NULL,
  `contacto_id` int(10) unsigned NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `contacto_persona_persona_id_foreign` (`persona_id`),
  KEY `contacto_persona_contacto_id_foreign` (`contacto_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=293 ;

--
-- Volcado de datos para la tabla `contacto_persona`
--

INSERT INTO `contacto_persona` (`id`, `persona_id`, `contacto_id`, `descripcion`, `usuario_alta`, `fecha_alta`, `usuario_modi`, `fecha_modi`, `created_at`, `updated_at`) VALUES
(92, 5, 1, '15151515', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(93, 5, 3, 'caceres@yahoo.com.ar', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(124, 41, 1, '3704-693691', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(146, 9, 1, '37048956522', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(149, 19, 1, '3704-989612', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(150, 19, 3, 'roman@gmail.com', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(159, 55, 1, '3704-895636', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(162, 60, 1, '3704-32659', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(163, 60, 3, 'rivarola@gmail.com', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(165, 53, 1, '3704-693698', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(179, 58, 1, '3704-6936923', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(181, 56, 1, '3704-8965323', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(194, 75, 1, '370-4356001', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(195, 75, 3, 'valea95@hotmail.com', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(196, 86, 1, '3704538053', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(197, 86, 3, 'hectorace78@hotmail.com', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(198, 84, 1, '3704674954', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(199, 84, 3, 'karlasu@gmail.com', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(210, 90, 1, '3704078375', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(211, 90, 3, 'belenprini45@gmail.com', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(212, 91, 1, '3704382741', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(213, 91, 3, 'sheila_mz_17@hotmail.com', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(214, 92, 1, '3704912052', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(215, 92, 3, 'sofigallego2@gmail.com', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(218, 94, 1, '3704576647', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(219, 94, 3, 'jorgearanda21@hotmail.com', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(221, 95, 1, '3704573410', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(222, 95, 3, 'checha_kstro@hotmail.com', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(223, 95, 3, 'checha_kstro@hotmail.com', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(228, 97, 1, '3704688097', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(229, 97, 3, 'KARUA_123@HOTMAIL.COM', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(231, 96, 1, '3704363649', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(233, 101, 1, '3704301558', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(234, 101, 3, 'gambattimariasoledad@gemail.com', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(240, 107, 3, 'melisamaldonado92@gmail.com', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(241, 108, 3, 'ismaelgrande@hotmail.com', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(244, 109, 1, '3704235370', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(245, 109, 3, 'britalita_09@hotmail.com', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(246, 110, 1, '3704236561', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(247, 110, 3, 'matyvillalva97@gmail.com', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(250, 112, 1, '3704063925', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(251, 112, 3, 'francov@gmail.com', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(256, 87, 1, '3704710480', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(257, 87, 3, 'eferichlajunta87@hotmail.com', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(268, 98, 3, 'cristian-faray@hotmail.com', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(269, 93, 1, '3704-855861', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(270, 93, 3, 'emanuelcardozo09@gimail.com', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(271, 111, 1, '3715406448', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(272, 111, 3, 'carlazayas97@gmail.com', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(273, 88, 1, '3704828674', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(274, 88, 3, 'nali_e@hotmail.com', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(275, 99, 3, 'gallardo.mabelen@gmail.com', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(277, 106, 3, 'marialauralezcano@hotmail.com', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(278, 106, 1, '3704-693698', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(280, 113, 1, '3704595103', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(281, 113, 3, 'gabii_41@hotmail.es', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(282, 89, 1, '3704390233', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(283, 89, 3, 'sabri.godo@hotmail.com', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(286, 114, 1, '3704-693698', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(287, 105, 3, 'marianellal37@gmail.com', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(290, 115, 1, '3704-693698', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(291, 104, 1, '3704402959', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(292, 104, 3, 'rocioleal15@hotmal.com', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Disparadores `contacto_persona`
--
DROP TRIGGER IF EXISTS `tr_contacto_persona_baja_log`;
DELIMITER //
CREATE TRIGGER `tr_contacto_persona_baja_log` AFTER DELETE ON `contacto_persona`
 FOR EACH ROW insert into aud_contacto_persona_log (id,persona_id,contacto_id,descripcion,usuario,fecha,baja)
values (OLD.id,OLD.persona_id,OLD.contacto_id,OLD.descripcion, OLD.usuario_modi,NOW(), 1)
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contratos`
--

CREATE TABLE IF NOT EXISTS `contratos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `organizacion_id` int(10) unsigned NOT NULL,
  `tipocontrato_id` int(10) unsigned NOT NULL,
  `alumno_id` int(10) unsigned NOT NULL,
  `ciclolectivo_id` int(10) unsigned DEFAULT NULL,
  `fechadesde` datetime DEFAULT NULL,
  `fechahasta` datetime DEFAULT NULL,
  `carrera_id` int(10) unsigned DEFAULT NULL,
  `cantidadcuotas` int(11) DEFAULT NULL,
  `cuotaimporte` decimal(6,2) DEFAULT NULL,
  `matriculaimporte` decimal(6,2) DEFAULT NULL,
  `totalimporte` decimal(6,2) DEFAULT NULL,
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `contratos_organizacion_id_foreign` (`organizacion_id`),
  KEY `contratos_tipocontrato_id_foreign` (`tipocontrato_id`),
  KEY `contratos_alumno_id_foreign` (`alumno_id`),
  KEY `contratos_ciclolectivo_id_foreign` (`ciclolectivo_id`),
  KEY `contratos_carrera_id_foreign` (`carrera_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=80 ;

--
-- Volcado de datos para la tabla `contratos`
--

INSERT INTO `contratos` (`id`, `organizacion_id`, `tipocontrato_id`, `alumno_id`, `ciclolectivo_id`, `fechadesde`, `fechahasta`, `carrera_id`, `cantidadcuotas`, `cuotaimporte`, `matriculaimporte`, `totalimporte`, `usuario_alta`, `fecha_alta`, `usuario_modi`, `fecha_modi`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 50, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-14 00:00:00', NULL, NULL, '2015-05-14 13:10:14', '2015-05-14 13:10:14'),
(2, 1, 1, 50, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-14 00:00:00', NULL, NULL, '2015-05-14 13:16:23', '2015-05-14 13:16:23'),
(3, 1, 1, 65, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-14 00:00:00', NULL, NULL, '2015-05-14 13:16:34', '2015-05-14 13:16:34'),
(4, 1, 1, 50, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-14 00:00:00', NULL, NULL, '2015-05-14 13:30:45', '2015-05-14 13:30:45'),
(5, 1, 1, 50, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-14 00:00:00', NULL, NULL, '2015-05-14 13:32:36', '2015-05-14 13:32:36'),
(6, 1, 1, 51, 8, '2014-08-19 00:00:00', '2015-07-03 00:00:00', 28, 11, 850.00, 850.00, 9.35, 'admin', '2015-05-14 00:00:00', NULL, NULL, '2015-05-14 13:36:05', '2015-05-14 13:36:05'),
(7, 1, 1, 50, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-14 00:00:00', NULL, NULL, '2015-05-14 13:45:15', '2015-05-14 13:45:15'),
(8, 1, 2, 45, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-14 00:00:00', NULL, NULL, '2015-05-14 13:46:29', '2015-05-14 13:46:29'),
(9, 1, 1, 55, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 29, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-14 00:00:00', NULL, NULL, '2015-05-14 13:49:30', '2015-05-14 13:49:30'),
(10, 1, 1, 55, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 29, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-14 00:00:00', NULL, NULL, '2015-05-14 13:54:01', '2015-05-14 13:54:01'),
(11, 1, 1, 55, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 29, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-14 00:00:00', NULL, NULL, '2015-05-14 13:54:03', '2015-05-14 13:54:03'),
(12, 1, 1, 55, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 29, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-14 00:00:00', NULL, NULL, '2015-05-14 13:57:05', '2015-05-14 13:57:05'),
(13, 1, 1, 55, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 29, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-14 00:00:00', NULL, NULL, '2015-05-14 13:57:18', '2015-05-14 13:57:18'),
(14, 1, 1, 55, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 29, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-14 00:00:00', NULL, NULL, '2015-05-14 13:58:37', '2015-05-14 13:58:37'),
(15, 1, 1, 50, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-14 00:00:00', NULL, NULL, '2015-05-14 14:01:17', '2015-05-14 14:01:17'),
(16, 1, 1, 68, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-14 00:00:00', NULL, NULL, '2015-05-14 14:04:46', '2015-05-14 14:04:46'),
(17, 1, 1, 68, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-14 00:00:00', NULL, NULL, '2015-05-14 14:08:25', '2015-05-14 14:08:25'),
(18, 1, 1, 68, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-14 00:00:00', NULL, NULL, '2015-05-14 14:09:44', '2015-05-14 14:09:44'),
(19, 1, 1, 55, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 29, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-14 00:00:00', NULL, NULL, '2015-05-14 14:10:08', '2015-05-14 14:10:08'),
(20, 1, 1, 55, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 29, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-14 00:00:00', NULL, NULL, '2015-05-14 14:31:54', '2015-05-14 14:31:54'),
(21, 1, 1, 55, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 29, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-14 00:00:00', NULL, NULL, '2015-05-14 14:57:36', '2015-05-14 14:57:36'),
(22, 1, 1, 55, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 29, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-14 00:00:00', NULL, NULL, '2015-05-14 14:57:49', '2015-05-14 14:57:49'),
(23, 1, 1, 55, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 29, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-14 00:00:00', NULL, NULL, '2015-05-14 15:01:37', '2015-05-14 15:01:37'),
(24, 1, 1, 50, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-14 00:00:00', NULL, NULL, '2015-05-14 22:14:35', '2015-05-14 22:14:35'),
(25, 1, 1, 50, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-15 00:00:00', NULL, NULL, '2015-05-15 12:13:15', '2015-05-15 12:13:15'),
(26, 1, 1, 68, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-15 00:00:00', NULL, NULL, '2015-05-15 13:14:53', '2015-05-15 13:14:53'),
(27, 1, 1, 50, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-15 00:00:00', NULL, NULL, '2015-05-15 14:17:24', '2015-05-15 14:17:24'),
(28, 1, 2, 45, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-15 00:00:00', NULL, NULL, '2015-05-15 14:19:57', '2015-05-15 14:19:57'),
(29, 1, 1, 50, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-18 00:00:00', NULL, NULL, '2015-05-18 11:07:07', '2015-05-18 11:07:07'),
(30, 1, 2, 45, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-18 00:00:00', NULL, NULL, '2015-05-18 11:07:10', '2015-05-18 11:07:10'),
(31, 1, 1, 68, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-18 00:00:00', NULL, NULL, '2015-05-18 11:07:20', '2015-05-18 11:07:20'),
(32, 1, 1, 50, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-18 00:00:00', NULL, NULL, '2015-05-18 11:07:26', '2015-05-18 11:07:26'),
(33, 1, 2, 45, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-18 00:00:00', NULL, NULL, '2015-05-18 11:07:30', '2015-05-18 11:07:30'),
(34, 1, 1, 50, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-18 00:00:00', NULL, NULL, '2015-05-18 11:34:55', '2015-05-18 11:34:55'),
(35, 1, 2, 45, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-18 00:00:00', NULL, NULL, '2015-05-18 11:34:59', '2015-05-18 11:34:59'),
(36, 1, 1, 68, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-18 00:00:00', NULL, NULL, '2015-05-18 11:35:18', '2015-05-18 11:35:18'),
(37, 1, 2, 45, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-18 00:00:00', NULL, NULL, '2015-05-18 11:35:33', '2015-05-18 11:35:33'),
(38, 1, 1, 50, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-18 00:00:00', NULL, NULL, '2015-05-18 11:35:36', '2015-05-18 11:35:36'),
(39, 1, 1, 68, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-18 00:00:00', NULL, NULL, '2015-05-18 11:36:05', '2015-05-18 11:36:05'),
(40, 1, 1, 68, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-18 00:00:00', NULL, NULL, '2015-05-18 11:38:50', '2015-05-18 11:38:50'),
(41, 1, 1, 68, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-18 00:00:00', NULL, NULL, '2015-05-18 12:14:00', '2015-05-18 12:14:00'),
(42, 1, 1, 50, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-18 00:00:00', NULL, NULL, '2015-05-18 12:14:07', '2015-05-18 12:14:07'),
(43, 1, 1, 50, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-18 00:00:00', NULL, NULL, '2015-05-18 12:14:20', '2015-05-18 12:14:20'),
(44, 1, 1, 55, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 29, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-18 00:00:00', NULL, NULL, '2015-05-18 12:14:25', '2015-05-18 12:14:25'),
(45, 1, 1, 50, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'farrua', '2015-05-18 00:00:00', NULL, NULL, '2015-05-18 14:47:56', '2015-05-18 14:47:56'),
(46, 1, 1, 50, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-19 00:00:00', NULL, NULL, '2015-05-19 11:36:06', '2015-05-19 11:36:06'),
(47, 1, 2, 45, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-19 00:00:00', NULL, NULL, '2015-05-19 11:36:12', '2015-05-19 11:36:12'),
(48, 1, 1, 68, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-19 00:00:00', NULL, NULL, '2015-05-19 11:36:23', '2015-05-19 11:36:23'),
(49, 1, 1, 55, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 29, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-19 00:00:00', NULL, NULL, '2015-05-19 11:36:42', '2015-05-19 11:36:42'),
(50, 1, 1, 50, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-20 00:00:00', NULL, NULL, '2015-05-20 12:40:09', '2015-05-20 12:40:09'),
(51, 1, 1, 71, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 32, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-21 00:00:00', NULL, NULL, '2015-05-21 17:31:57', '2015-05-21 17:31:57'),
(52, 1, 1, 71, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 32, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-21 00:00:00', NULL, NULL, '2015-05-21 17:45:06', '2015-05-21 17:45:06'),
(53, 1, 1, 68, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-21 00:00:00', NULL, NULL, '2015-05-21 17:46:51', '2015-05-21 17:46:51'),
(54, 1, 1, 50, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-26 00:00:00', NULL, NULL, '2015-05-26 11:21:15', '2015-05-26 11:21:15'),
(55, 1, 2, 45, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-26 00:00:00', NULL, NULL, '2015-05-26 11:21:32', '2015-05-26 11:21:32'),
(56, 1, 1, 59, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-26 00:00:00', NULL, NULL, '2015-05-26 11:21:37', '2015-05-26 11:21:37'),
(57, 1, 1, 68, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-26 00:00:00', NULL, NULL, '2015-05-26 11:21:50', '2015-05-26 11:21:50'),
(58, 1, 1, 55, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 29, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-26 00:00:00', NULL, NULL, '2015-05-26 11:22:28', '2015-05-26 11:22:28'),
(59, 1, 1, 71, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 32, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-26 00:00:00', NULL, NULL, '2015-05-26 11:22:52', '2015-05-26 11:22:52'),
(60, 1, 1, 56, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 34, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-26 00:00:00', NULL, NULL, '2015-05-26 11:23:05', '2015-05-26 11:23:05'),
(61, 1, 2, 71, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 32, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-26 00:00:00', NULL, NULL, '2015-05-26 11:24:26', '2015-05-26 11:24:26'),
(62, 1, 1, 50, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-26 00:00:00', NULL, NULL, '2015-05-26 11:24:50', '2015-05-26 11:24:50'),
(63, 1, 1, 68, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-26 00:00:00', NULL, NULL, '2015-05-26 14:48:56', '2015-05-26 14:48:56'),
(64, 1, 1, 68, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-28 00:00:00', NULL, NULL, '2015-05-28 11:42:16', '2015-05-28 11:42:16'),
(65, 1, 1, 50, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-05-29 00:00:00', NULL, NULL, '2015-05-29 14:10:51', '2015-05-29 14:10:51'),
(66, 1, 1, 50, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-07-02 00:00:00', NULL, NULL, '2015-07-02 13:07:22', '2015-07-02 13:07:22'),
(67, 1, 1, 68, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-07-15 00:00:00', NULL, NULL, '2015-07-15 13:23:18', '2015-07-15 13:23:18'),
(68, 1, 1, 72, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-07-15 00:00:00', NULL, NULL, '2015-07-15 13:23:24', '2015-07-15 13:23:24'),
(69, 1, 1, 45, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-07-15 00:00:00', NULL, NULL, '2015-07-15 13:23:33', '2015-07-15 13:23:33'),
(70, 1, 1, 50, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-07-27 00:00:00', NULL, NULL, '2015-07-27 18:35:23', '2015-07-27 18:35:23'),
(71, 1, 1, 68, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-07-27 00:00:00', NULL, NULL, '2015-07-27 18:35:34', '2015-07-27 18:35:34'),
(72, 1, 1, 50, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2015-07-27 00:00:00', NULL, NULL, '2015-07-27 18:36:10', '2015-07-27 18:36:10'),
(73, 1, 1, 50, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2016-01-13 00:00:00', NULL, NULL, '2016-01-13 14:54:11', '2016-01-13 14:54:11'),
(74, 1, 1, 50, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2016-01-14 00:00:00', NULL, NULL, '2016-01-14 14:43:46', '2016-01-14 14:43:46'),
(75, 1, 1, 68, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2016-01-14 00:00:00', NULL, NULL, '2016-01-14 14:44:11', '2016-01-14 14:44:11'),
(76, 1, 1, 68, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2016-01-14 00:00:00', NULL, NULL, '2016-01-14 14:44:15', '2016-01-14 14:44:15'),
(77, 1, 1, 68, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2016-01-14 00:00:00', NULL, NULL, '2016-01-14 14:44:17', '2016-01-14 14:44:17'),
(78, 1, 1, 68, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2016-01-14 00:00:00', NULL, NULL, '2016-01-14 14:44:20', '2016-01-14 14:44:20'),
(79, 1, 1, 68, 7, '2015-03-16 00:00:00', '2015-12-31 00:00:00', 28, 11, 1200.00, 1200.00, 13.20, 'admin', '2016-01-14 00:00:00', NULL, NULL, '2016-01-14 14:44:22', '2016-01-14 14:44:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE IF NOT EXISTS `departamentos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `provincia_id` int(10) unsigned NOT NULL,
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `departamentos_provincia_id_foreign` (`provincia_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`id`, `descripcion`, `provincia_id`, `usuario_alta`, `fecha_alta`, `usuario_modi`, `fecha_modi`, `created_at`, `updated_at`) VALUES
(1, 'BERMEJO', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'FORMOSA', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'LAISHI', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'MATACOS', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'PATIÑO', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'PILAGAS', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'PILCOMAYO', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 'PIRANE', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 'RAMON LISTA', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Disparadores `departamentos`
--
DROP TRIGGER IF EXISTS `tr_departamentos_baja_log`;
DELIMITER //
CREATE TRIGGER `tr_departamentos_baja_log` AFTER DELETE ON `departamentos`
 FOR EACH ROW insert into aud_departamentos_log (id,provincia_id,descripcion,usuario,fecha,baja)
values (OLD.id,OLD.provincia_id,OLD.descripcion, OLD.usuario_modi,NOW(), 1)
//
DELIMITER ;
DROP TRIGGER IF EXISTS `tr_departamentos_modi_log`;
DELIMITER //
CREATE TRIGGER `tr_departamentos_modi_log` AFTER UPDATE ON `departamentos`
 FOR EACH ROW insert into aud_departamentos_log (id,provincia_id,descripcion,usuario,fecha,modi)
values (OLD.id,OLD.provincia_id,OLD.descripcion, NEW.usuario_modi,NOW(), 1)
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallesmatriculaspagos`
--

CREATE TABLE IF NOT EXISTS `detallesmatriculaspagos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `inscripcion_id` int(10) unsigned NOT NULL,
  `matricula_id` int(10) unsigned NOT NULL,
  `alumno_id` int(10) unsigned NOT NULL,
  `mescuota` int(11) DEFAULT NULL,
  `importe` decimal(6,2) DEFAULT NULL,
  `porcentajerecargo` int(11) DEFAULT NULL,
  `porcentajedescuento` int(11) DEFAULT NULL,
  `fechavencimiento` timestamp NULL DEFAULT NULL,
  `fechapago` timestamp NULL DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '0',
  `observaciones` varchar(5000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `detallesmatriculaspagos_inscripcion_id_foreign` (`inscripcion_id`),
  KEY `detallesmatriculaspagos_matricula_id_foreign` (`matricula_id`),
  KEY `detallesmatriculaspagos_alumno_id_foreign` (`alumno_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=27 ;

--
-- Volcado de datos para la tabla `detallesmatriculaspagos`
--

INSERT INTO `detallesmatriculaspagos` (`id`, `inscripcion_id`, `matricula_id`, `alumno_id`, `mescuota`, `importe`, `porcentajerecargo`, `porcentajedescuento`, `fechavencimiento`, `fechapago`, `estado`, `observaciones`, `usuario_alta`, `fecha_alta`, `usuario_modi`, `fecha_modi`, `created_at`, `updated_at`) VALUES
(13, 53, 27, 59, 0, 1200.00, 0, 0, '2015-03-20 00:00:00', '2015-04-01 00:00:00', 1, '', 'admin', '2015-04-01 00:00:00', NULL, NULL, '2015-04-01 21:56:32', '2015-04-01 21:56:32'),
(14, 53, 27, 59, 2, 1200.00, 0, 0, '2015-02-20 00:00:00', '2015-04-01 00:00:00', 1, '', 'admin', '2015-04-01 00:00:00', NULL, NULL, '2015-04-01 21:56:41', '2015-04-01 21:56:41'),
(15, 53, 27, 59, 3, 1200.00, 0, 0, '2015-03-20 00:00:00', '2015-04-01 00:00:00', 1, '', 'admin', '2015-04-01 00:00:00', NULL, NULL, '2015-04-01 21:56:47', '2015-04-01 21:56:47'),
(16, 54, 27, 65, 0, 1200.00, 0, 0, '2015-03-20 00:00:00', '2015-04-01 00:00:00', 1, '', 'admin', '2015-04-01 00:00:00', NULL, NULL, '2015-04-01 21:59:06', '2015-04-01 21:59:06'),
(17, 59, 27, 50, 0, 1200.00, 0, 0, '2015-03-20 00:00:00', '2015-04-17 00:00:00', 1, '', 'admin', '2015-04-17 00:00:00', NULL, NULL, '2015-04-17 14:15:07', '2015-04-17 14:15:07'),
(18, 59, 27, 50, 2, 1200.00, 0, 0, '2015-02-20 00:00:00', '2015-04-17 00:00:00', 1, '', 'admin', '2015-04-17 00:00:00', NULL, NULL, '2015-04-17 14:15:16', '2015-04-17 14:15:16'),
(19, 59, 27, 50, 3, 1200.00, 0, 0, '2015-03-20 00:00:00', '2015-04-17 00:00:00', 1, '', 'admin', '2015-04-17 00:00:00', NULL, NULL, '2015-04-17 14:15:20', '2015-04-17 14:15:20'),
(21, 60, 27, 45, 2, 1200.00, 0, 0, '2015-02-20 00:00:00', '2015-04-17 00:00:00', 1, '', 'admin', '2015-04-17 00:00:00', NULL, NULL, '2015-04-17 14:48:59', '2015-04-17 14:48:59'),
(22, 60, 27, 45, 3, 1200.00, 0, 0, '2015-03-20 00:00:00', '2015-04-17 00:00:00', 1, '', 'admin', '2015-04-17 00:00:00', NULL, NULL, '2015-04-17 14:49:05', '2015-04-17 14:49:05'),
(23, 75, 31, 71, 0, 1200.00, 0, 0, '2015-02-28 00:00:00', '2015-05-14 00:00:00', 1, '', 'admin', '2015-05-14 00:00:00', NULL, NULL, '2015-05-14 12:06:28', '2015-05-14 12:06:28'),
(24, 65, 27, 63, 0, 1200.00, 0, 0, '2015-02-28 00:00:00', '2015-07-10 00:00:00', 1, '', 'admin', '2015-07-10 00:00:00', NULL, NULL, '2015-07-10 14:06:50', '2015-07-10 14:06:50'),
(25, 60, 27, 45, 0, 1200.00, 0, 0, '2015-02-28 00:00:00', '2015-07-27 00:00:00', 1, '', 'admin', '2015-07-27 00:00:00', NULL, NULL, '2015-07-27 18:40:54', '2015-07-27 18:40:54'),
(26, 80, 31, 73, 0, 1200.00, 0, 0, '2015-02-28 00:00:00', '2015-07-29 00:00:00', 1, '', 'admin', '2015-07-29 00:00:00', NULL, NULL, '2015-07-29 12:08:39', '2015-07-29 12:08:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docentes`
--

CREATE TABLE IF NOT EXISTS `docentes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `persona_id` int(10) unsigned NOT NULL,
  `nrolegajo` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '0',
  `empleado` tinyint(1) NOT NULL DEFAULT '0',
  `disertante` tinyint(1) NOT NULL DEFAULT '0',
  `fechaingreso` timestamp NULL DEFAULT NULL,
  `fechaegreso` timestamp NULL DEFAULT NULL,
  `titulohabilitante_id` int(10) unsigned NOT NULL,
  `organismohabilitante_id` int(10) unsigned NOT NULL,
  `nrolegajohabilitante` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `docentes_persona_id_foreign` (`persona_id`),
  KEY `docentes_titulohabilitante_id_foreign` (`titulohabilitante_id`),
  KEY `docentes_organismohabilitante_id_foreign` (`organismohabilitante_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

--
-- Volcado de datos para la tabla `docentes`
--

INSERT INTO `docentes` (`id`, `persona_id`, `nrolegajo`, `foto`, `activo`, `empleado`, `disertante`, `fechaingreso`, `fechaegreso`, `titulohabilitante_id`, `organismohabilitante_id`, `nrolegajohabilitante`, `usuario_alta`, `fecha_alta`, `usuario_modi`, `fecha_modi`, `created_at`, `updated_at`) VALUES
(16, 85, '26555531', NULL, 1, 1, 1, '2014-02-12 00:00:00', NULL, 3, 1, '', 'admin', '2015-03-27 00:00:00', 'admin', '2015-06-22 00:00:00', '2015-03-27 17:27:46', '2015-06-22 14:34:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadosciviles`
--

CREATE TABLE IF NOT EXISTS `estadosciviles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `estadosciviles`
--

INSERT INTO `estadosciviles` (`id`, `descripcion`, `usuario_alta`, `fecha_alta`, `usuario_modi`, `fecha_modi`, `created_at`, `updated_at`) VALUES
(1, 'Soltero', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Casado', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Divorciado', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'Viudo', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Disparadores `estadosciviles`
--
DROP TRIGGER IF EXISTS `tr_estadosciviles_baja_log`;
DELIMITER //
CREATE TRIGGER `tr_estadosciviles_baja_log` AFTER DELETE ON `estadosciviles`
 FOR EACH ROW insert into aud_estadosciviles_log (id,descripcion,usuario,fecha,baja)
values (OLD.id,OLD.descripcion, OLD.usuario_modi,NOW(), 1)
//
DELIMITER ;
DROP TRIGGER IF EXISTS `tr_estadosciviles_modi_log`;
DELIMITER //
CREATE TRIGGER `tr_estadosciviles_modi_log` AFTER UPDATE ON `estadosciviles`
 FOR EACH ROW insert into aud_estadosciviles_log (id,descripcion,usuario,fecha,modi)
values (OLD.id,OLD.descripcion, NEW.usuario_modi,NOW(), 1)
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcionesfinales`
--

CREATE TABLE IF NOT EXISTS `inscripcionesfinales` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `docente_id` int(10) unsigned DEFAULT NULL,
  `planestudio_id` int(10) unsigned DEFAULT NULL,
  `alumno_id` int(10) unsigned NOT NULL,
  `materia_id` int(10) unsigned NOT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `inscripcionesfinales_docente_id_foreign` (`docente_id`),
  KEY `inscripcionesfinales_planestudio_id_foreign` (`planestudio_id`),
  KEY `inscripcionesfinales_alumno_id_foreign` (`alumno_id`),
  KEY `inscripcionesfinales_materia_id_foreign` (`materia_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcionesmaterias`
--

CREATE TABLE IF NOT EXISTS `inscripcionesmaterias` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `planestudio_id` int(10) unsigned DEFAULT NULL,
  `alumno_id` int(10) unsigned NOT NULL,
  `materia_id` int(10) unsigned NOT NULL,
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `inscripcionesmaterias_planestudio_id_foreign` (`planestudio_id`),
  KEY `inscripcionesmaterias_alumno_id_foreign` (`alumno_id`),
  KEY `inscripcionesmaterias_materia_id_foreign` (`materia_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=30 ;

--
-- Volcado de datos para la tabla `inscripcionesmaterias`
--

INSERT INTO `inscripcionesmaterias` (`id`, `planestudio_id`, `alumno_id`, `materia_id`, `usuario_alta`, `fecha_alta`, `usuario_modi`, `fecha_modi`, `created_at`, `updated_at`) VALUES
(5, 14, 41, 24, 'admin', '2015-12-04 00:00:00', NULL, NULL, '2015-12-04 11:35:34', '2015-12-04 11:35:34'),
(6, 14, 41, 25, 'admin', '2015-12-04 00:00:00', NULL, NULL, '2015-12-04 11:35:34', '2015-12-04 11:35:34'),
(7, 15, 53, 26, 'admin', '2015-12-04 00:00:00', NULL, NULL, '2015-12-04 11:36:53', '2015-12-04 11:36:53'),
(8, 15, 53, 27, 'admin', '2015-12-04 00:00:00', NULL, NULL, '2015-12-04 11:36:53', '2015-12-04 11:36:53'),
(21, 13, 44, 21, 'admin', '2015-12-04 00:00:00', NULL, NULL, '2015-12-04 13:54:58', '2015-12-04 13:54:58'),
(22, 13, 59, 21, 'admin', '2015-12-04 00:00:00', NULL, NULL, '2015-12-04 13:55:58', '2015-12-04 13:55:58'),
(23, 13, 59, 23, 'admin', '2015-12-04 00:00:00', NULL, NULL, '2015-12-04 13:55:58', '2015-12-04 13:55:58'),
(25, 13, 61, 23, 'admin', '2015-12-04 00:00:00', NULL, NULL, '2015-12-04 13:57:50', '2015-12-04 13:57:50'),
(26, 13, 66, 21, 'admin', '2015-12-04 00:00:00', NULL, NULL, '2015-12-04 14:00:18', '2015-12-04 14:00:18'),
(28, 13, 73, 26, 'admin', '2015-12-04 00:00:00', NULL, NULL, '2015-12-04 14:18:40', '2015-12-04 14:18:40'),
(29, 13, 73, 27, 'admin', '2015-12-04 00:00:00', NULL, NULL, '2015-12-04 14:18:40', '2015-12-04 14:18:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `localidades`
--

CREATE TABLE IF NOT EXISTS `localidades` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `departamento_id` int(10) unsigned NOT NULL,
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `localidades_departamento_id_foreign` (`departamento_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=267 ;

--
-- Volcado de datos para la tabla `localidades`
--

INSERT INTO `localidades` (`id`, `descripcion`, `departamento_id`, `usuario_alta`, `fecha_alta`, `usuario_modi`, `fecha_modi`, `created_at`, `updated_at`) VALUES
(1, 'BAJO HONDO', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'EL AIBAL', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'EL AIBALITO', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'EL CAÑON', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'EL CRUCE', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'EL CHURCAL', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'EL CHURCALITO', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 'EL QUEMADO NUEVO', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 'EL REMANSO', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 'EL CAVADO', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 'EL SOLITARIO', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 'PALMITAS', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 'FORTIN LA SOLEDAD', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 'FORTIN NUEVO PILCOMAYO', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 'INGENIERO FAURE', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 'PUERTO IRIGOYEN', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 'LA LIBERTAD', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, 'LA PALIZADA', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 'LA RINCONADA', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 'LA SOLEDAD', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, 'TRES PACES', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 'LAG. YACARE (CACIQ SUMAYEN)', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, 'LAGUNA YEMA', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(24, 'LAGUNITA', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(25, 'LAMADRID', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26, 'LOS CIENEGUITOS', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(27, 'LOS CHIRIGUANOS', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(28, 'MATIAS GULACSY (TAS TAS)', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(29, 'MEDIA LUNA', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(30, 'PALMA SOLA', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(31, 'PESCADO NEGRO', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(32, 'POZO DE MAZA (LUIS DE GASPERI)', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(33, 'POZO DEL MORTERO (FRANCISCO BOCH)', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(34, 'RIO MUERTO', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(35, 'SANTA ROSA', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(36, 'EL SIMBOLAR', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(37, 'SOMBRERO NEGRO (GUMERCINDO ZAYAGO)', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(38, 'VACA PERDIDA', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(39, 'GUADALCAZAR', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(40, 'RINCONADA', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(41, 'REPRESA', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(42, 'TRES YUCHANES', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(43, 'EL QUIMIL', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(44, 'POSITOS', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(45, 'POZO RAMON', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(46, 'EL PICHANAL', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(47, 'MADRUGADA', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(48, 'EL CHAÑARAL', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(49, 'SANTA ROSA', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(50, 'LAS BANDERITAS', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(51, 'EL PARAISO', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(52, 'EL SILENCIO', 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(53, 'FORMOSA CAPITAL', 2, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(54, 'COL. ITUZAINGO', 2, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(55, 'COL. DALMACIA', 2, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(56, 'EL DESVIO DE LOS PILAGAS', 2, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(57, 'COL. LAS LOMITAS', 2, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(58, 'ISLA ALVAREZ', 2, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(59, 'ESTANCIA LA ALEGRIA', 2, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(60, 'ESTANCIA STA. OLGA', 2, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(61, 'GRAN GUARDIA', 2, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(62, 'GUAYCOLE', 2, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(63, 'ISLA 25 DE MAYO', 2, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(64, 'ESTANCIA LA FLORIDA', 2, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(65, 'LOMA CLAVEL', 2, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(66, 'MIGUEL AZCUENAGA', 2, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(67, 'MARIANO BOEDO', 2, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(68, 'MOJON DE FIERRO', 2, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(69, 'MONTEAGUDO', 2, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(70, 'COL. PASTORIL', 2, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(71, 'BOCA PILAGAS', 2, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(72, 'PTE. HIRIGOYEN', 2, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(73, 'SAN ALBERTO', 2, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(74, 'SAN HILARIO', 2, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(75, 'PTE. URIBURU', 2, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(76, 'CAÑADA 12', 2, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(77, 'EL OMBU', 2, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(78, 'PILAGA I', 2, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(79, 'PJE. PUENTE SAN HILARIO', 2, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(80, 'POZO DEL TIGRE', 2, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(81, 'BANCO PAYAGUÁ', 3, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(82, 'GENERAL LUCIO V. MANSILLA', 3, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(83, 'HERRADURA', 3, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(84, 'SAN FRANCISCO DE LAISHI', 3, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(85, 'TATANÉ', 3, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(86, 'VILLA ESCOLAR', 3, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(87, 'CAMPO BANDERA', 4, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(88, 'EL MISTOLAR', 4, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(89, 'EL ROSILLO', 4, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(90, 'EL TOTORAL', 4, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(91, 'INGENIERO JUAREZ', 4, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(92, 'MISION POZO YACARE', 4, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(93, 'TTE. FRAGA', 4, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(94, 'POTRERITO', 4, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(95, 'CAMPO GRANDE', 4, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(96, 'AG. FELIPE S IVAÑEZ', 5, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(97, 'ALTO ALEGRE', 5, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(98, 'BLANCA GOMEZ (COL. LEGUA A)', 5, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(99, 'CABO 1° BENITEZ', 5, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(100, 'CAMPO ALEGRE', 5, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(101, 'CAMPO AZCURRA (ANDRES FOLRES)', 5, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(102, 'CAMPO DEL CIELO', 5, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(103, 'CAMPO LAS YEGUAS', 5, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(104, 'CACIQUE COQUERO', 5, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(105, 'COL. 14 DE MAYO (COL. GUILLERMINA)', 5, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(106, 'COL. 20 DE JUNIO', 5, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(107, 'COL. 8 DE SEPTIEMBRE', 5, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(108, 'COL. B. DE LAS CASAS', 5, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(109, 'COL. CACUY', 5, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(110, 'COL. CEFERINO NAMUNCURA', 5, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(111, 'COL. CORONEL BOGADO', 5, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(112, 'COL. EL 14', 5, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(113, 'COL. EL ENSANCHE', 5, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(114, 'COL. EL LUCERO', 5, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(115, 'COL. ISMAEL SANCHEZ', 5, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(116, 'COL. JUANITA (LOS INMIGRANTES)', 5, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(117, 'COL. LA PREFERIDA', 5, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(118, 'COL. NAPENAY', 5, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(119, 'COL. SAN ANTONIO', 5, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(120, '25 DE MAYO', 6, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(121, 'APAYEREY (SOL. ERIVERTO DAVALOS)', 6, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(122, 'BELLA VISTA', 6, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(123, 'BUENA VISTA', 6, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(124, 'SAN CARLOS', 6, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(125, 'COL. ABORIGEM M. TACAAGLE', 6, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(126, 'JULIO CUE', 6, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(127, 'COL. NUEVA (ABORIGEN)', 6, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(128, 'EL CEIBO', 6, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(129, 'EL ESPINILLO', 6, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(130, 'EL POMBERO', 6, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(131, 'ISLA AZUL', 6, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(132, 'LAGUNA GALLO (FLORENTINO AMEGHINO)', 6, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(133, 'LOMA ZAPATU', 6, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(134, 'LORO CUE (SUBTTE. MAZAFERRO)', 6, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(135, 'MISION TACAAGLE', 6, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(136, 'PORTON NEGRO (GRAL. JULIO DE VEDIA)', 6, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(137, 'PUESTO RAMONA', 6, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(138, 'RINCON GRANDE', 6, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(139, 'SALVACION', 6, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(140, 'SAN CARLOS MAPZAT', 6, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(141, 'SANTA ROSA', 6, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(142, 'TRES LAGUNAS', 6, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(143, 'VILLA HERMOSA', 6, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(144, 'VILLA REAL', 6, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(145, 'MONTE LINDO CHICO', 7, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(146, 'ISLA BUEY MUERTO', 7, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(147, 'CEIBO 13', 7, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(148, 'CLORINDA', 7, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(149, 'COL. BOUVIER', 7, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(150, 'COL. SARMIENTO', 7, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(151, 'COL.SUD AMERICA', 7, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(152, 'COSTA ALEGRE', 7, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(153, 'EL PARAISO', 7, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(154, 'EL RECODO', 7, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(155, 'GARCETE CUE (SOL. JOSE CORONEL)', 7, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(156, 'ISLA APANDO (BERNARDO AGULAR)', 7, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(157, 'ISLA PUEN', 7, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(158, 'ISLA YOBAY GUAZU', 7, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(159, 'JOSE MARIA PAZ', 7, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(160, 'LA FRONTERA', 7, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(161, 'COL LA PRIMAVERA ABORIGEN', 7, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(162, 'LAGUNA BLANCA', 7, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(163, 'LOMA TUYUYU', 7, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(164, 'LOMA HERMOSA', 7, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(165, 'LOS SANTAFECINOS', 7, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(166, 'LUCERO CUE (VILLA LUCERO)', 7, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(167, 'MARCA M (JOSE CANCIO)', 7, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(168, 'MARTIN FIERRO', 7, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(169, 'PRIMERA JUNTA', 7, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(170, 'EL SALADILLO', 8, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(171, 'EL BELLACO', 8, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(172, 'RINCON ALEGRE', 8, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(173, 'CABO NOROÑA', 8, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(174, 'CAMPO GARCIA', 8, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(175, 'CAMPO HARDY', 8, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(176, 'CAMPO RIGONATO', 8, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(177, 'CAMPO SAN RAFAEL', 8, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(178, 'CAMPO VILLAFAÑE', 8, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(179, 'CASCO CUE (JOSE HERNANDEZ)', 8, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(180, 'CENTRO FORESTAL', 8, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(181, 'COL. 5 DE OCTUBRE', 8, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(182, 'COL. LA BLANCA', 8, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(183, 'COL. LA UNION', 8, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(184, 'COL. RODAS', 8, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(185, 'COL. SAN JUAN', 8, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(186, 'COL. WEITZEL', 8, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(187, 'COL. KM 15', 8, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(188, 'COPO BLANCO', 8, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(189, 'COSTA R. ALAZAN', 8, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(190, 'CRUCE A LA PICADITA', 8, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(191, 'EL ALBA', 8, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(192, 'EL BAÑADERO', 8, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(193, 'EL COATI', 8, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(194, 'EL COLORADO', 8, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(195, 'PIRANE', 8, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(196, 'CAMPO DE HACHA', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(197, 'EL ALAMBRADO', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(198, 'EL BREAL', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(199, 'EL FAVORITO', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(200, 'EL PALMAR', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(201, 'EL PALMARCITO', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(202, 'EL POTRILLO', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(203, 'EL QUEBRACHO', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(204, 'EL SURUBI', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(205, 'EL TABIQUE', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(206, 'TRONQUITO I', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(207, 'EL TUCUMANO', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(208, 'EL CHORRO (GRAL MOSCONI)', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(209, 'LA BREA', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(210, 'LA MOCHA', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(211, 'LA PAMPA', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(212, 'LOTE 1', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(213, 'LOTE 8', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(214, 'MARIA CRISTINA', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(215, 'PALMAR LARGO', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(216, 'PALO SANTO', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(217, 'POZO CERCADO', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(218, 'SAN ANDRES', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(219, 'SAN MARTIN', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(220, 'SAN MIGUEL', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(221, 'SANTA ROSA', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(222, 'SANTA TERESA', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(223, 'SELVA MARIA', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(224, 'TRES PALMAS', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(225, 'TUCUMANCITO', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(226, 'LAS CAÑITAS', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(227, 'TRONQUITO II', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(228, 'POZO CABALLO', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(229, 'POZO CHARATA', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(230, 'MEDIA LUNITA', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(231, 'EL SILENCIO', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(232, 'EL DIVISADERO', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(233, 'BATERIA', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(234, 'EL CRUCE', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(235, 'LA ESPERANZA', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(236, 'TRES POZOS', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(237, 'KM 17', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(238, 'KM 30', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(239, 'KM 2', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(240, 'LAS PALMITAS', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(241, 'EL ESTANQUE', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(242, 'EL TRASBORDO', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(243, 'PALMAR CHICO', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(244, 'POZO LAS CHIVAS', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(245, 'EL ROSARIO', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(246, 'CAÑADA RICA', 9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(247, 'VILLA DEL CARMEN', 2, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(248, 'LAGUNA NAICK-NECK', 7, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(249, 'PALMA SOLA', 7, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(250, 'PILCOMAYO', 7, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(251, 'RIACHO HE-HE', 7, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(252, 'RIACHO NEGRO', 7, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(253, 'SIETE PALMAS', 7, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(254, 'CARTOLOMÉ DE LAS CASAS', 5, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(255, 'COMANDANTE FONTANA', 5, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(256, 'ESTANISLAO DEL CAMPO', 5, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(257, 'IBARRETA', 5, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(258, 'LAS LOMITAS', 5, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(259, 'POZO DEL TIGRE', 5, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(260, 'SAN MARTIN I', 5, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(261, 'SAN MARTIN II', 5, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(262, 'SUBTENIENTE PERIN', 5, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(263, 'VULLA GENERAL GÛEMES', 5, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(264, 'VILLA GENERAL BELGRANO', 5, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(265, 'PALO SANTO', 8, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(266, 'VILLA KILÓMETRO 2013', 8, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Disparadores `localidades`
--
DROP TRIGGER IF EXISTS `tr_localidades_baja_log`;
DELIMITER //
CREATE TRIGGER `tr_localidades_baja_log` AFTER DELETE ON `localidades`
 FOR EACH ROW insert into aud_localidades_log (id,departamento_id,descripcion,usuario,fecha,baja)
values (OLD.id,OLD.departamento_id,OLD.descripcion, OLD.usuario_modi,NOW(), 1)
//
DELIMITER ;
DROP TRIGGER IF EXISTS `tr_localidades_modi_log`;
DELIMITER //
CREATE TRIGGER `tr_localidades_modi_log` AFTER UPDATE ON `localidades`
 FOR EACH ROW insert into aud_localidades_log (id,departamento_id,descripcion,usuario,fecha,modi)
values (OLD.id,OLD.departamento_id,OLD.descripcion, NEW.usuario_modi,NOW(), 1)
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE IF NOT EXISTS `materias` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `carrera_id` int(10) unsigned DEFAULT NULL,
  `planestudio_id` int(10) unsigned DEFAULT NULL,
  `nombremateria` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `periodo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `hssemanales` int(11) DEFAULT NULL,
  `hsreloj` int(11) DEFAULT NULL,
  `hscatedra` int(11) DEFAULT NULL,
  `aniocursado` int(11) DEFAULT NULL,
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `materias_carrera_id_foreign` (`carrera_id`),
  KEY `materias_planestudio_id_foreign` (`planestudio_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=28 ;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`id`, `carrera_id`, `planestudio_id`, `nombremateria`, `periodo`, `hssemanales`, `hsreloj`, `hscatedra`, `aniocursado`, `usuario_alta`, `fecha_alta`, `usuario_modi`, `fecha_modi`, `created_at`, `updated_at`) VALUES
(21, 28, 13, ' Bioinformática', 'Anual', 12, 11, 10, 1, 'admin', '2015-12-04 00:00:00', NULL, NULL, '2015-12-04 11:23:56', '2015-12-04 11:23:56'),
(22, 28, 13, ' Bioinformática 2', 'Cuatrimestral', 12, 10, 10, 2, 'admin', '2015-12-04 00:00:00', NULL, NULL, '2015-12-04 11:24:19', '2015-12-04 11:24:19'),
(23, 28, 13, 'Metodología de la Investigación', 'Cuatrimestral', 10, 9, 3, 1, 'admin', '2015-12-04 00:00:00', NULL, NULL, '2015-12-04 11:24:39', '2015-12-04 11:24:39'),
(24, 30, 14, 'Salud Pública ', 'Cuatrimestral', 12, 11, 10, 1, 'admin', '2015-12-04 00:00:00', NULL, NULL, '2015-12-04 11:28:08', '2015-12-04 11:28:08'),
(25, 30, 13, ' Obstetricia ', 'Cuatrimestral', 10, 11, 9, 2, 'admin', '2015-12-04 00:00:00', NULL, NULL, '2015-12-04 11:28:43', '2015-12-04 11:28:43'),
(26, 32, 13, 'Progrmación1', 'Cuatrimestral', 10, 11, 11, 1, 'admin', '2015-12-04 00:00:00', NULL, NULL, '2015-12-04 11:31:12', '2015-12-04 11:31:12'),
(27, 32, 13, 'Ética y Deontología ', 'Anual', 5, 6, 7, 1, 'admin', '2015-12-04 00:00:00', NULL, NULL, '2015-12-04 11:31:39', '2015-12-04 11:31:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matriculas`
--

CREATE TABLE IF NOT EXISTS `matriculas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `organizacion_id` int(10) unsigned NOT NULL,
  `carrera_id` int(10) unsigned NOT NULL,
  `ciclolectivo_id` int(10) unsigned NOT NULL,
  `matriculaaplica` tinyint(1) NOT NULL DEFAULT '0',
  `cuotaaplica` tinyint(1) NOT NULL DEFAULT '0',
  `matriculaimporte` decimal(7,2) DEFAULT NULL,
  `cuotaimporte` decimal(6,2) DEFAULT NULL,
  `matriculaperiodopagodesde` int(11) DEFAULT NULL,
  `matriculaperiodopagohasta` int(11) DEFAULT NULL,
  `cuotaperiodopagodesde` int(11) DEFAULT NULL,
  `cuotaperiodopagohasta` int(11) DEFAULT NULL,
  `cuotasporcarrera` int(11) DEFAULT NULL,
  `cuotasporciclo` int(11) DEFAULT NULL,
  `cuotasporperiodo` int(11) DEFAULT NULL,
  `mespagocuotainicio` int(11) DEFAULT NULL,
  `fechavencimientomatricula` timestamp NULL DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `matriculas_organizacion_id_foreign` (`organizacion_id`),
  KEY `matriculas_carrera_id_foreign` (`carrera_id`),
  KEY `matriculas_ciclolectivo_id_foreign` (`ciclolectivo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=39 ;

--
-- Volcado de datos para la tabla `matriculas`
--

INSERT INTO `matriculas` (`id`, `organizacion_id`, `carrera_id`, `ciclolectivo_id`, `matriculaaplica`, `cuotaaplica`, `matriculaimporte`, `cuotaimporte`, `matriculaperiodopagodesde`, `matriculaperiodopagohasta`, `cuotaperiodopagodesde`, `cuotaperiodopagohasta`, `cuotasporcarrera`, `cuotasporciclo`, `cuotasporperiodo`, `mespagocuotainicio`, `fechavencimientomatricula`, `activo`, `usuario_alta`, `fecha_alta`, `usuario_modi`, `fecha_modi`, `created_at`, `updated_at`) VALUES
(27, 1, 28, 7, 1, 1, 1200.00, 1200.00, NULL, NULL, NULL, 20, NULL, NULL, 11, 2, '2015-02-28 00:00:00', 1, 'tbrizuela', '2015-04-01 00:00:00', 'admin', '2015-04-17 00:00:00', '2015-04-01 17:43:17', '2015-04-17 14:21:33'),
(28, 1, 29, 7, 1, 1, 1200.00, 1200.00, NULL, NULL, NULL, 20, NULL, NULL, 11, 2, '2015-02-28 00:00:00', 1, 'admin', '2015-04-06 00:00:00', NULL, NULL, '2015-04-06 17:53:54', '2015-04-06 17:53:54'),
(29, 1, 30, 7, 1, 1, 1200.00, 1200.00, NULL, NULL, NULL, 20, NULL, NULL, 11, 2, '2021-02-28 00:00:00', 1, 'admin', '2015-04-06 00:00:00', NULL, NULL, '2015-04-06 17:54:17', '2015-04-06 17:54:17'),
(31, 1, 32, 7, 1, 1, 1200.00, 1200.00, NULL, NULL, NULL, 20, NULL, NULL, 11, 2, '2015-02-28 00:00:00', 1, 'admin', '2015-04-06 00:00:00', NULL, NULL, '2015-04-06 17:55:11', '2015-04-06 17:55:11'),
(32, 1, 28, 8, 1, 1, 850.00, 850.00, NULL, NULL, NULL, 20, NULL, NULL, 11, 8, '2015-08-15 00:00:00', 1, 'admin', '2015-04-16 00:00:00', 'admin', '2015-04-27 00:00:00', '2015-04-16 15:17:56', '2015-04-27 12:02:56'),
(33, 1, 33, 9, 1, 1, 1500.00, 1500.00, NULL, NULL, NULL, 20, NULL, NULL, 11, 2, '2016-02-27 00:00:00', 1, 'admin', '2015-04-21 00:00:00', 'admin', '2015-05-20 00:00:00', '2015-04-21 12:42:17', '2015-05-20 13:34:58'),
(34, 1, 29, 8, 1, 1, 850.00, 850.00, NULL, NULL, NULL, 20, NULL, NULL, 11, 8, '2014-08-15 00:00:00', 1, 'admin', '2015-04-22 00:00:00', 'admin', '2015-04-22 00:00:00', '2015-04-22 13:15:32', '2015-04-22 13:16:46'),
(35, 1, 30, 8, 1, 1, 850.00, 850.00, NULL, NULL, NULL, 20, NULL, NULL, 11, 8, '2014-08-15 00:00:00', 1, 'admin', '2015-04-22 00:00:00', 'admin', '2015-04-22 00:00:00', '2015-04-22 13:16:30', '2015-04-22 13:17:02'),
(36, 1, 31, 7, 1, 1, 1200.00, 1200.00, NULL, NULL, NULL, 20, NULL, NULL, 11, 2, '2015-02-28 00:00:00', 1, 'admin', '2015-05-20 00:00:00', 'admin', '2015-05-20 00:00:00', '2015-05-20 13:29:22', '2015-05-20 13:33:41'),
(37, 1, 34, 7, 1, 1, 1200.00, 1200.00, NULL, NULL, NULL, 20, NULL, NULL, 11, 2, '2015-02-28 00:00:00', 1, 'admin', '2015-05-20 00:00:00', 'admin', '2015-07-02 00:00:00', '2015-05-20 13:30:41', '2015-07-02 14:07:13'),
(38, 1, 31, 8, 1, 1, 850.00, 850.00, NULL, NULL, NULL, 20, NULL, NULL, 11, 8, '2014-08-31 00:00:00', 1, 'admin', '2015-05-20 00:00:00', NULL, NULL, '2015-05-20 13:31:28', '2015-05-20 13:31:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_11_13_142702_create_Paises_table', 1),
('2014_11_13_142703_create_provincias_table', 1),
('2014_11_13_145723_create_departamentos_table', 1),
('2014_11_13_171153_create_localidades_table', 1),
('2014_11_13_171806_create_barrios_table', 1),
('2014_11_13_172136_create_niveles_educativos_table', 1),
('2014_11_13_174019_create_contactos_table', 1),
('2014_11_13_174301_create_organizaciones_table', 1),
('2014_11_14_112049_create_contacto_organizaciones_table', 1),
('2014_11_17_124805_create_users_table', 1),
('2014_11_17_181649_create_tipodocumentos_table', 1),
('2014_11_17_182120_create_estadosciviles_table', 1),
('2014_11_17_184024_create_personas_table', 1),
('2014_11_18_112645_create_ContactoPersonas_table', 1),
('2014_11_18_120526_create_alumnos_table', 1),
('2014_11_19_115222_create_organismoshabilitantes_table', 1),
('2014_11_19_120037_create_tituloshabilitantes_Table', 1),
('2014_11_14_112049_create_contacto_organizacion_table', 2),
('2014_11_18_112645_create_contacto_persona_table', 2),
('2014_12_03_134030_add_campos_to_users_table', 2),
('2014_12_03_134244_create_organizacion_user_table', 2),
('2014_12_05_113054_create_cicloslectivos_table', 2),
('2014_12_05_113327_create_periodoslectivos_table', 2),
('2014_12_29_115855_create_tiposcarreras_table', 2),
('2014_12_29_120328_create_regimenes_table', 2),
('2014_12_29_123157_create_tiposduraciones_table', 2),
('2014_12_29_123256_create_modalidades_table', 2),
('2014_12_29_123349_create_areasocupacionales_table', 2),
('2015_01_05_171226_create_relacionesfamiliares_table', 2),
('2015_01_05_171517_create_ocupaciones_table', 2),
('2015_01_05_171747_create_alumnosfamiliares_table', 2),
('2015_01_06_121932_create_alumnoslegajos_table', 2),
('2015_01_06_134229_create_alumnoslegajosdocumentos_table', 2),
('2015_01_06_140048_add_alumnosfamiliares_table', 2),
('2014_12_29_121311_create_carrerasniveles_table', 3),
('2015_01_07_171210_create_matricula_table', 3),
('2014_11_19_120253_create_docentes_table', 4),
('2014_12_29_123557_create_carreras_table', 5),
('2015_01_15_133214_create_titulosotorgados_table', 6),
('2015_01_15_133422_add_titulootorgado_id_to_carreras_table', 6),
('2015_01_26_123007_create_perfiles_table', 8),
('2015_01_26_131227_create_modulos_table', 8),
('2015_01_26_132034_create_modulo_perfil_table', 8),
('2015_01_30_115253_add_padreid_to_modulos_table', 10),
('2015_01_08_143509_create_alumno_carrera_table', 11),
('2015_02_05_113550_add_remember_to_users_table', 12),
('2015_01_28_161838_create_perfil_user_table', 13),
('2015_02_06_141351_add_persona_id_to_users_Table', 14),
('2015_01_08_131531_create_matriculas_table', 15),
('2015_01_08_143510_create_detallesmatriculaspagos_table', 16),
('2015_02_12_135535_add_nrolegajohabilitante_to_docentes_table', 16),
('2015_02_25_115902_create_becas_table', 17),
('2015_05_05_125225_create_tiposcontratos_table', 18),
('2015_05_05_125832_create_contratos_table', 19),
('2015_09_15_122525_create_planesestudios_table', 20),
('2015_09_16_125857_create_materias_table', 20),
('2015_09_22_132015_create_inscripcionesfinales_table', 21),
('2015_10_15_163231_create_inscripcionesmaterias_table', 22);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modalidades`
--

CREATE TABLE IF NOT EXISTS `modalidades` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `modalidades`
--

INSERT INTO `modalidades` (`id`, `descripcion`, `usuario_alta`, `fecha_alta`, `usuario_modi`, `fecha_modi`, `created_at`, `updated_at`) VALUES
(1, 'A distancia', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Presencial', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Semipresencial', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Disparadores `modalidades`
--
DROP TRIGGER IF EXISTS `tr_modalidades_baja_log`;
DELIMITER //
CREATE TRIGGER `tr_modalidades_baja_log` AFTER DELETE ON `modalidades`
 FOR EACH ROW insert into aud_modalidades_log (id,descripcion,usuario,fecha,baja)
values (OLD.id,OLD.descripcion,OLD.usuario_modi,NOW(), 1)
//
DELIMITER ;
DROP TRIGGER IF EXISTS `tr_modalidades_modi_log`;
DELIMITER //
CREATE TRIGGER `tr_modalidades_modi_log` AFTER UPDATE ON `modalidades`
 FOR EACH ROW insert into aud_modalidades_log (id,descripcion,usuario,fecha,modi)
values (OLD.id,OLD.descripcion,NEW.usuario_modi,NOW(), 1)
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos`
--

CREATE TABLE IF NOT EXISTS `modulos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `padreid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=32 ;

--
-- Volcado de datos para la tabla `modulos`
--

INSERT INTO `modulos` (`id`, `descripcion`, `usuario_alta`, `fecha_alta`, `usuario_modi`, `fecha_modi`, `created_at`, `updated_at`, `padreid`) VALUES
(1, 'Gestión Académica', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(2, 'Gestión Administrativa', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(3, 'Gestión Contable', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(4, 'Configuraciones', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(5, 'Seguridad', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(6, 'Alumnos', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1),
(7, 'Docentes', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1),
(8, 'Boletines', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1),
(9, 'Inscripciones', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1),
(10, 'Organizaciones', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2),
(11, 'Calendarios', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2),
(12, 'Carreras', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2),
(13, 'Materias', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2),
(14, 'Plan de Estudios', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2),
(15, 'Administración', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2),
(16, 'Gestión de Matrículas', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 3),
(17, 'Pago de Matrículas', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 3),
(18, 'General', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 4),
(19, 'Institutos', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 4),
(20, 'Usuarios', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 5),
(21, 'Perfiles', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 5),
(22, 'Becas', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 3),
(24, 'Informes', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(25, 'Alumnos', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 24),
(26, 'Docentes', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 24),
(27, 'Matrículas', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 24),
(28, 'Contratos', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 3),
(29, 'Edición de Contratos', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 28),
(30, 'Impresión', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 28),
(31, 'Inscripcion Materias', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulo_perfil`
--

CREATE TABLE IF NOT EXISTS `modulo_perfil` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `modulo_id` int(10) unsigned NOT NULL,
  `perfil_id` int(10) unsigned NOT NULL,
  `leer` tinyint(1) NOT NULL DEFAULT '0',
  `editar` tinyint(1) NOT NULL DEFAULT '0',
  `eliminar` tinyint(1) NOT NULL DEFAULT '0',
  `imprimir` tinyint(1) NOT NULL DEFAULT '0',
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `modulo_perfil_modulo_id_foreign` (`modulo_id`),
  KEY `modulo_perfil_perfil_id_foreign` (`perfil_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=297 ;

--
-- Volcado de datos para la tabla `modulo_perfil`
--

INSERT INTO `modulo_perfil` (`id`, `modulo_id`, `perfil_id`, `leer`, `editar`, `eliminar`, `imprimir`, `usuario_alta`, `fecha_alta`, `usuario_modi`, `fecha_modi`, `created_at`, `updated_at`) VALUES
(61, 6, 2, 1, 1, 1, 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(62, 7, 2, 1, 1, 1, 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(63, 8, 2, 1, 1, 1, 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(64, 9, 2, 1, 1, 1, 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(67, 21, 2, 1, 1, 1, 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(68, 10, 2, 1, 1, 1, 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(70, 12, 2, 1, 1, 1, 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(71, 13, 2, 1, 1, 1, 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(72, 14, 2, 1, 1, 1, 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(73, 15, 2, 1, 1, 1, 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(76, 18, 2, 1, 1, 1, 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(77, 19, 2, 1, 1, 1, 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(146, 20, 2, 1, 1, 1, 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(154, 11, 2, 1, 1, 1, 1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(178, 6, 27, 1, 1, 1, 1, 'admin', '2015-03-25 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(179, 7, 27, 1, 1, 1, 1, 'admin', '2015-03-25 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(180, 8, 27, 1, 1, 1, 1, 'admin', '2015-03-25 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(181, 9, 27, 1, 1, 1, 1, 'admin', '2015-03-25 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(182, 10, 27, 1, 1, 1, 1, 'admin', '2015-03-25 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(183, 11, 27, 1, 1, 1, 1, 'admin', '2015-03-25 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(184, 12, 27, 1, 1, 1, 1, 'admin', '2015-03-25 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(185, 13, 27, 1, 1, 1, 1, 'admin', '2015-03-25 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(186, 14, 27, 1, 1, 1, 1, 'admin', '2015-03-25 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(187, 15, 27, 1, 1, 1, 1, 'admin', '2015-03-25 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(188, 16, 27, 1, 1, 1, 1, 'admin', '2015-03-25 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(189, 17, 27, 1, 1, 1, 1, 'admin', '2015-03-25 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(190, 22, 27, 1, 1, 1, 1, 'admin', '2015-03-25 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(191, 18, 27, 1, 1, 1, 1, 'admin', '2015-03-25 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(192, 19, 27, 1, 1, 1, 1, 'admin', '2015-03-25 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(193, 20, 27, 1, 1, 1, 1, 'admin', '2015-03-25 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(195, 25, 27, 1, 1, 1, 1, 'admin', '2015-03-25 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(196, 21, 27, 1, 1, 1, 1, 'admin', '2015-03-25 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(197, 16, 25, 1, 1, 1, 1, 'admin', '2015-03-25 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(198, 17, 25, 1, 1, 1, 1, 'admin', '2015-03-25 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(199, 22, 25, 1, 1, 1, 1, 'admin', '2015-03-25 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(201, 7, 25, 1, 0, 0, 0, 'admin', '2015-03-25 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(202, 25, 25, 1, 1, 1, 1, 'admin', '2015-03-25 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(204, 6, 23, 1, 1, 1, 1, 'admin', '2015-03-25 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(205, 7, 23, 1, 1, 1, 1, 'admin', '2015-03-25 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(206, 12, 23, 1, 1, 1, 1, 'admin', '2015-03-25 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(207, 13, 23, 1, 1, 1, 1, 'admin', '2015-03-25 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(208, 14, 23, 1, 1, 1, 1, 'admin', '2015-03-25 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(209, 11, 23, 1, 1, 1, 1, 'admin', '2015-03-25 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(210, 25, 23, 1, 1, 1, 1, 'admin', '2015-03-25 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(211, 17, 23, 1, 0, 0, 0, 'admin', '2015-03-25 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(219, 6, 24, 1, 1, 1, 1, 'admin', '2015-03-25 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(220, 7, 24, 1, 1, 1, 1, 'admin', '2015-03-25 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(221, 17, 24, 1, 0, 0, 0, 'admin', '2015-03-25 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(223, 8, 24, 1, 1, 1, 1, 'admin', '2015-03-25 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(224, 11, 24, 1, 1, 1, 1, 'admin', '2015-03-25 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(225, 12, 24, 1, 1, 1, 1, 'admin', '2015-03-25 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(226, 25, 24, 1, 1, 1, 1, 'admin', '2015-03-25 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(227, 13, 24, 1, 1, 1, 1, 'admin', '2015-03-25 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(228, 14, 24, 1, 1, 1, 1, 'admin', '2015-03-25 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(231, 6, 26, 1, 1, 1, 1, NULL, NULL, 'admin', '2015-03-27 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(232, 26, 2, 1, 1, 1, 1, 'admin', '2015-03-30 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(233, 7, 26, 1, 1, 1, 1, NULL, NULL, 'admin', '2015-03-30 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(235, 26, 23, 1, 1, 1, 1, 'admin', '2015-03-30 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(237, 26, 27, 1, 1, 1, 1, 'admin', '2015-03-30 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(238, 26, 24, 1, 1, 1, 1, 'admin', '2015-03-30 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(241, 6, 25, 1, 1, 1, 1, NULL, NULL, 'admin', '2015-03-30 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(247, 9, 23, 1, 1, 1, 1, 'admin', '2015-03-31 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(248, 9, 24, 1, 1, 1, 1, 'admin', '2015-03-31 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(250, 9, 25, 1, 1, 1, 1, 'admin', '2015-03-31 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(251, 16, 2, 1, 1, 1, 1, NULL, NULL, 'admin', '2015-04-01 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(252, 17, 2, 1, 1, 1, 1, NULL, NULL, 'admin', '2015-04-01 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(253, 22, 2, 1, 1, 1, 1, NULL, NULL, 'admin', '2015-04-01 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(256, 12, 25, 1, 0, 0, 0, NULL, NULL, 'admin', '2015-04-01 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(258, 11, 25, 1, 1, 1, 1, 'admin', '2015-04-01 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(259, 10, 25, 1, 1, 1, 1, 'admin', '2015-04-01 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(269, 9, 26, 1, 0, 0, 0, NULL, NULL, 'admin', '2015-04-06 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(270, 10, 26, 1, 0, 0, 0, NULL, NULL, 'admin', '2015-04-06 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(271, 12, 26, 1, 0, 0, 0, NULL, NULL, 'admin', '2015-04-06 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(272, 11, 26, 1, 0, 0, 0, NULL, NULL, 'admin', '2015-04-06 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(274, 17, 26, 1, 0, 0, 0, NULL, NULL, 'admin', '2015-04-06 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(277, 22, 26, 1, 0, 0, 0, 'admin', '2015-04-06 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(279, 25, 26, 1, 1, 1, 1, NULL, NULL, 'bsegovia', '2015-04-15 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(281, 25, 2, 1, 1, 1, 1, NULL, NULL, 'bsegovia', '2015-04-15 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(282, 27, 2, 1, 1, 1, 1, 'bsegovia', '2015-04-15 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(283, 10, 24, 1, 0, 0, 0, 'admin', '2015-04-16 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(284, 10, 23, 1, 0, 0, 0, 'admin', '2015-04-16 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(285, 27, 23, 1, 1, 1, 1, 'admin', '2015-04-20 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(286, 27, 24, 1, 1, 1, 1, 'admin', '2015-04-20 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(287, 27, 27, 1, 1, 1, 1, 'admin', '2015-04-20 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(288, 26, 26, 1, 0, 0, 0, NULL, NULL, 'bsegovia', '2015-04-27 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(291, 28, 2, 1, 1, 1, 1, NULL, NULL, 'admin', '2015-05-12 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(292, 28, 27, 1, 1, 1, 1, 'admin', '2015-05-13 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(293, 28, 26, 1, 0, 0, 0, 'admin', '2015-05-18 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(294, 8, 26, 1, 1, 0, 0, 'admin', '2015-07-27 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(296, 31, 2, 1, 1, 1, 1, NULL, NULL, 'admin', '2015-12-01 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `niveles_educativos`
--

CREATE TABLE IF NOT EXISTS `niveles_educativos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `niveles_educativos`
--

INSERT INTO `niveles_educativos` (`id`, `descripcion`, `usuario_alta`, `fecha_alta`, `usuario_modi`, `fecha_modi`, `created_at`, `updated_at`) VALUES
(1, 'Terciario', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Universitario', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Disparadores `niveles_educativos`
--
DROP TRIGGER IF EXISTS `tr_niveles_educativos_baja_log`;
DELIMITER //
CREATE TRIGGER `tr_niveles_educativos_baja_log` AFTER DELETE ON `niveles_educativos`
 FOR EACH ROW insert into aud_niveles_educativos_log (id,descripcion,usuario,fecha,baja)
  values (OLD.id,OLD.descripcion, OLD.usuario_modi,NOW(), 1)
//
DELIMITER ;
DROP TRIGGER IF EXISTS `tr_niveles_educativos_modi_log`;
DELIMITER //
CREATE TRIGGER `tr_niveles_educativos_modi_log` AFTER UPDATE ON `niveles_educativos`
 FOR EACH ROW insert into aud_niveles_educativos_log (id,descripcion,usuario,fecha,modi)
  values (OLD.id,OLD.descripcion, NEW.usuario_modi,NOW(), 1)
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ocupaciones`
--

CREATE TABLE IF NOT EXISTS `ocupaciones` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Disparadores `ocupaciones`
--
DROP TRIGGER IF EXISTS `tr_ocupaciones_baja_log`;
DELIMITER //
CREATE TRIGGER `tr_ocupaciones_baja_log` AFTER DELETE ON `ocupaciones`
 FOR EACH ROW insert into aud_ocupaciones_log (id,descripcion,usuario,fecha,baja)
values (OLD.id,OLD.descripcion, OLD.usuario_modi,NOW(), 1)
//
DELIMITER ;
DROP TRIGGER IF EXISTS `tr_ocupaciones_modi_log`;
DELIMITER //
CREATE TRIGGER `tr_ocupaciones_modi_log` AFTER UPDATE ON `ocupaciones`
 FOR EACH ROW insert into aud_ocupaciones_log (id,descripcion,usuario,fecha,modi)
values (OLD.id,OLD.descripcion, NEW.usuario_modi,NOW(), 1)
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `organismoshabilitantes`
--

CREATE TABLE IF NOT EXISTS `organismoshabilitantes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `organismoshabilitantes`
--

INSERT INTO `organismoshabilitantes` (`id`, `descripcion`, `usuario_alta`, `fecha_alta`, `usuario_modi`, `fecha_modi`, `created_at`, `updated_at`) VALUES
(1, 'Ministerio de Educación', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Universidad Nacional de Formosa', 'admin', '2015-03-18 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Disparadores `organismoshabilitantes`
--
DROP TRIGGER IF EXISTS `tr_organismoshabilitantes_baja_log`;
DELIMITER //
CREATE TRIGGER `tr_organismoshabilitantes_baja_log` AFTER DELETE ON `organismoshabilitantes`
 FOR EACH ROW insert into aud_organismoshabilitantes_log (id,descripcion,usuario,fecha,baja)
values (OLD.id,OLD.descripcion, OLD.usuario_modi,NOW(), 1)
//
DELIMITER ;
DROP TRIGGER IF EXISTS `tr_organismoshabilitantes_modi_log`;
DELIMITER //
CREATE TRIGGER `tr_organismoshabilitantes_modi_log` AFTER UPDATE ON `organismoshabilitantes`
 FOR EACH ROW insert into aud_organismoshabilitantes_log (id,descripcion,usuario,fecha,modi)
values (OLD.id,OLD.descripcion, NEW.usuario_modi,NOW(), 1)
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `organizaciones`
--

CREATE TABLE IF NOT EXISTS `organizaciones` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `razon_social` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cuit` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nivel_Educativo_id` int(10) unsigned DEFAULT NULL,
  `habilitar_sedes` tinyint(1) NOT NULL DEFAULT '0',
  `pais_id` int(10) unsigned NOT NULL,
  `provincia_id` int(10) unsigned DEFAULT NULL,
  `departamento_id` int(10) unsigned DEFAULT NULL,
  `localidad_id` int(10) unsigned DEFAULT NULL,
  `barrio_id` int(10) unsigned DEFAULT NULL,
  `barrio` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `calle` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `manzana` int(11) DEFAULT NULL,
  `piso` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `departamento` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `codigo_postal` int(11) DEFAULT NULL,
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `organizaciones_nivel_educativo_id_foreign` (`nivel_Educativo_id`),
  KEY `organizaciones_pais_id_foreign` (`pais_id`),
  KEY `organizaciones_provincia_id_foreign` (`provincia_id`),
  KEY `organizaciones_departamento_id_foreign` (`departamento_id`),
  KEY `organizaciones_localidad_id_foreign` (`localidad_id`),
  KEY `organizaciones_barrio_id_foreign` (`barrio_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- Volcado de datos para la tabla `organizaciones`
--

INSERT INTO `organizaciones` (`id`, `nombre`, `razon_social`, `cuit`, `nivel_Educativo_id`, `habilitar_sedes`, `pais_id`, `provincia_id`, `departamento_id`, `localidad_id`, `barrio_id`, `barrio`, `calle`, `numero`, `manzana`, `piso`, `departamento`, `codigo_postal`, `usuario_alta`, `fecha_alta`, `usuario_modi`, `fecha_modi`, `created_at`, `updated_at`) VALUES
(1, 'INSTITUTO SUPERIOR DE SANIDAD "Prof. Dr. Ramón Carrillo"', 'Fundación Hospital de Alta Complejidad "Pte. Juan D. Perón"', '30-71233107-7', 1, 0, 1, 1, 2, 53, 2, NULL, 'Córdoba ', 447, 0, '', '', 3600, 'FIJO-OrganizacionsController. Store-Edit', '2015-01-13 03:00:00', 'admin', '2015-05-14 00:00:00', '2015-01-13 17:49:41', '2015-05-14 14:01:15'),
(11, 'INSTITUTO SUPERIOR DE SANIDAD FORMOSA', 'ISS FORMOSA ', '30-55636215-4', 1, 0, 1, 1, 7, 148, 39, 'San Martin', 'Libertad', 690, 0, '', '', 3658, 'admin', '2015-05-19 00:00:00', 'admin', '2015-05-19 00:00:00', '2015-05-19 17:48:41', '2015-05-19 17:49:27');

--
-- Disparadores `organizaciones`
--
DROP TRIGGER IF EXISTS `tr_organizaciones_baja_log`;
DELIMITER //
CREATE TRIGGER `tr_organizaciones_baja_log` AFTER DELETE ON `organizaciones`
 FOR EACH ROW insert into aud_organizaciones_log (id,nombre,razon_social,cuit,nivel_educativo_id,habilitar_sedes,pais_id,provincia_id,departamento_id,localidad_id,barrio_id,calle,numero,manzana,piso,departamento,codigo_postal,usuario,fecha,baja)
values (OLD.id,OLD.nombre,OLD.razon_social,OLD.cuit,OLD.nivel_educativo_id,OLD.habilitar_sedes,OLD.pais_id,OLD.provincia_id,OLD.departamento_id,OLD.localidad_id,OLD.barrio_id,OLD.calle,OLD.numero,OLD.manzana,OLD.piso,OLD.departamento,OLD.codigo_postal, OLD.usuario_modi,NOW(), 1)
//
DELIMITER ;
DROP TRIGGER IF EXISTS `tr_organizaciones_modi_log`;
DELIMITER //
CREATE TRIGGER `tr_organizaciones_modi_log` AFTER UPDATE ON `organizaciones`
 FOR EACH ROW insert into aud_organizaciones_log (id,nombre,razon_social,cuit,nivel_educativo_id,habilitar_sedes,pais_id,provincia_id,departamento_id,localidad_id,barrio_id,calle,numero,manzana,piso,departamento,codigo_postal,usuario,fecha,modi)
values (OLD.id,OLD.nombre,OLD.razon_social,OLD.cuit,OLD.nivel_educativo_id,OLD.habilitar_sedes,OLD.pais_id,OLD.provincia_id,OLD.departamento_id,OLD.localidad_id,OLD.barrio_id,OLD.calle,OLD.numero,OLD.manzana,OLD.piso,OLD.departamento,OLD.codigo_postal, NEW.usuario_modi,NOW(), 1)
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `organizacion_user`
--

CREATE TABLE IF NOT EXISTS `organizacion_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `organizacion_id` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `organizacion_user_organizacion_id_foreign` (`organizacion_id`),
  KEY `organizacion_user_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=77 ;

--
-- Volcado de datos para la tabla `organizacion_user`
--

INSERT INTO `organizacion_user` (`id`, `organizacion_id`, `user_id`, `created_at`, `updated_at`) VALUES
(16, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(24, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(25, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(27, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(54, 1, 24, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(56, 1, 26, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(64, 1, 21, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(65, 1, 22, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(66, 1, 23, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(67, 1, 25, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(69, 1, 27, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(70, 1, 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(73, 1, 28, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(75, 1, 20, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(76, 1, 29, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paises`
--

CREATE TABLE IF NOT EXISTS `paises` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `paises`
--

INSERT INTO `paises` (`id`, `descripcion`, `usuario_alta`, `fecha_alta`, `usuario_modi`, `fecha_modi`, `created_at`, `updated_at`) VALUES
(1, 'Argentina', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Disparadores `paises`
--
DROP TRIGGER IF EXISTS `tr_paises_baja_log`;
DELIMITER //
CREATE TRIGGER `tr_paises_baja_log` AFTER DELETE ON `paises`
 FOR EACH ROW insert into aud_paises_log (id,descripcion,usuario,fecha,baja)
values (OLD.id,OLD.descripcion, OLD.usuario_modi,NOW(), 1)
//
DELIMITER ;
DROP TRIGGER IF EXISTS `tr_paises_modi_log`;
DELIMITER //
CREATE TRIGGER `tr_paises_modi_log` AFTER UPDATE ON `paises`
 FOR EACH ROW insert into aud_paises_log (id,descripcion,usuario,fecha,modi)
values (OLD.id,OLD.descripcion, NEW.usuario_modi,NOW(), 1)
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfiles`
--

CREATE TABLE IF NOT EXISTS `perfiles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `organizacion_id` int(10) unsigned NOT NULL,
  `codigo` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `perfil` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `perfiles_organizacion_id_foreign` (`organizacion_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=28 ;

--
-- Volcado de datos para la tabla `perfiles`
--

INSERT INTO `perfiles` (`id`, `organizacion_id`, `codigo`, `perfil`, `descripcion`, `usuario_alta`, `fecha_alta`, `usuario_modi`, `fecha_modi`, `created_at`, `updated_at`) VALUES
(2, 1, '', 'Administrador Sistema de Gestión', 'Administración Sistema de Gestión Académica', NULL, '2015-02-10 00:00:00', 'admin', '2015-03-25 00:00:00', '2015-02-10 12:01:39', '2015-03-25 14:14:25'),
(23, 1, '', 'Secretaría Docente', 'Secretaría Docente', 'admin', '2015-03-25 00:00:00', NULL, NULL, '2015-03-25 13:41:39', '2015-03-25 13:41:39'),
(24, 1, '', 'Secretaría Alumnado', 'Alumnado', 'admin', '2015-03-25 00:00:00', 'admin', '2015-03-25 00:00:00', '2015-03-25 13:42:01', '2015-03-25 14:14:42'),
(25, 1, '', 'Secretaría Contable', 'Administrativo Contable', 'admin', '2015-03-25 00:00:00', NULL, NULL, '2015-03-25 13:42:45', '2015-03-25 13:42:45'),
(26, 1, '', 'Preceptor', 'Bedeles', 'admin', '2015-03-25 00:00:00', 'admin', '2015-03-25 00:00:00', '2015-03-25 13:43:08', '2015-03-25 14:15:36'),
(27, 1, '', 'Administrador General', 'Administrador Estableciemiento', 'admin', '2015-03-25 00:00:00', 'admin', '2015-03-25 00:00:00', '2015-03-25 13:44:50', '2015-03-25 14:15:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil_user`
--

CREATE TABLE IF NOT EXISTS `perfil_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `perfil_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `perfil_user_perfil_id_foreign` (`perfil_id`),
  KEY `perfil_user_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=148 ;

--
-- Volcado de datos para la tabla `perfil_user`
--

INSERT INTO `perfil_user` (`id`, `perfil_id`, `user_id`, `usuario_alta`, `fecha_alta`, `usuario_modi`, `fecha_modi`, `created_at`, `updated_at`) VALUES
(119, 2, 5, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(123, 27, 21, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(124, 26, 24, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(125, 26, 26, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(126, 26, 27, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(127, 26, 28, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(128, 25, 23, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(129, 24, 25, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(135, 23, 22, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(141, 2, 20, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(142, 2, 29, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(143, 23, 29, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(144, 24, 29, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(145, 25, 29, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(146, 26, 29, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(147, 27, 29, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodoslectivos`
--

CREATE TABLE IF NOT EXISTS `periodoslectivos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ciclolectivo_id` int(10) unsigned DEFAULT NULL,
  `descripcion` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `fechainicio` timestamp NULL DEFAULT NULL,
  `fechafin` timestamp NULL DEFAULT NULL,
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `periodoslectivos_ciclolectivo_id_foreign` (`ciclolectivo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=22 ;

--
-- Volcado de datos para la tabla `periodoslectivos`
--

INSERT INTO `periodoslectivos` (`id`, `ciclolectivo_id`, `descripcion`, `fechainicio`, `fechafin`, `usuario_alta`, `fecha_alta`, `usuario_modi`, `fecha_modi`, `created_at`, `updated_at`) VALUES
(18, 7, '1 Cuatrimestre', '2015-03-16 00:00:00', '2015-07-03 00:00:00', 'admin', '2015-03-13 00:00:00', NULL, NULL, '2015-03-13 17:51:57', '2015-03-25 12:26:28'),
(19, 7, '2 Cuatrimestre', '2015-08-18 00:00:00', '2015-12-04 00:00:00', 'admin', '2015-03-20 00:00:00', NULL, NULL, '2015-03-20 15:04:57', '2015-03-25 16:43:16'),
(20, 8, '1 Cuatrimestre', '2014-08-19 00:00:00', '2014-12-05 00:00:00', 'admin', '2015-04-16 00:00:00', NULL, NULL, '2015-04-16 15:15:40', '2015-04-16 15:15:40'),
(21, 8, '2 Cuatrimestre', '2015-03-16 00:00:00', '2015-07-03 00:00:00', 'admin', '2015-04-16 00:00:00', NULL, NULL, '2015-04-16 15:16:38', '2015-04-16 15:16:38');

--
-- Disparadores `periodoslectivos`
--
DROP TRIGGER IF EXISTS `tr_periodoslectivos_baja_log`;
DELIMITER //
CREATE TRIGGER `tr_periodoslectivos_baja_log` AFTER DELETE ON `periodoslectivos`
 FOR EACH ROW insert into aud_periodoslectivos_log (id,ciclolectivo_id,descripcion,fechainicio,fechafin,usuario,fecha,baja)
values (OLD.id,OLD.ciclolectivo_id,OLD.descripcion,OLD.fechainicio,OLD.fechafin,OLD.usuario_modi,NOW(), 1)
//
DELIMITER ;
DROP TRIGGER IF EXISTS `tr_periodoslectivos_modi_log`;
DELIMITER //
CREATE TRIGGER `tr_periodoslectivos_modi_log` AFTER UPDATE ON `periodoslectivos`
 FOR EACH ROW insert into aud_periodoslectivos_log (id,ciclolectivo_id,descripcion,fechainicio,fechafin,usuario,fecha,modi)
values (OLD.id,OLD.ciclolectivo_id,OLD.descripcion,OLD.fechainicio,OLD.fechafin,NEW.usuario_modi,NOW(), 1)
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE IF NOT EXISTS `personas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `apellido` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nombre` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tipodocumento_id` int(10) unsigned DEFAULT NULL,
  `nrodocumento` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sexo` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estadocivil_id` int(10) unsigned DEFAULT NULL,
  `fechanacimiento` datetime DEFAULT NULL,
  `lugarnacimiento_id` int(10) unsigned DEFAULT NULL,
  `pais_id` int(10) unsigned DEFAULT NULL,
  `provincia_id` int(10) unsigned DEFAULT NULL,
  `departamento_id` int(10) unsigned DEFAULT NULL,
  `localidad_id` int(10) unsigned DEFAULT NULL,
  `barrio_id` int(10) unsigned DEFAULT NULL,
  `barrio` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `calle` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `manzana` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `piso` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `departamento` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `codigo_postal` int(11) DEFAULT NULL,
  `cuil` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `personas_tipodocumento_id_foreign` (`tipodocumento_id`),
  KEY `personas_estadocivil_id_foreign` (`estadocivil_id`),
  KEY `personas_lugarnacimiento_id_foreign` (`lugarnacimiento_id`),
  KEY `personas_pais_id_foreign` (`pais_id`),
  KEY `personas_provincia_id_foreign` (`provincia_id`),
  KEY `personas_departamento_id_foreign` (`departamento_id`),
  KEY `personas_localidad_id_foreign` (`localidad_id`),
  KEY `personas_barrio_id_foreign` (`barrio_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=118 ;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id`, `apellido`, `nombre`, `tipodocumento_id`, `nrodocumento`, `sexo`, `estadocivil_id`, `fechanacimiento`, `lugarnacimiento_id`, `pais_id`, `provincia_id`, `departamento_id`, `localidad_id`, `barrio_id`, `barrio`, `calle`, `numero`, `manzana`, `piso`, `departamento`, `codigo_postal`, `cuil`, `usuario_alta`, `fecha_alta`, `usuario_modi`, `fecha_modi`, `created_at`, `updated_at`) VALUES
(1, 'Mongelos', 'María Cristina', 1, '30526623', 'Femenino', 2, '1973-10-01 00:00:00', 1, 1, 1, 1, 1, 1, NULL, '', 0, '0', '', '', 0, NULL, 'FIJO-DocentesController. Store-alta', '2015-01-12 03:00:00', 'admin', '2015-03-13 00:00:00', '2015-01-12 20:42:53', '2015-03-13 12:33:25'),
(5, 'Caceres', 'Marcela', 1, '25.228.692', 'Masculino', 1, '1976-06-24 00:00:00', 1, 1, 1, 1, 1, 1, NULL, 'las americas ', 2015, '0', '', '', 3600, NULL, 'FIJO-AlumnosController. Store-alta', '2015-02-05 00:00:00', NULL, NULL, '2015-02-05 17:49:04', '2015-02-09 16:24:00'),
(9, 'Gerula', 'Gustavo', 1, '1411458/8', 'Masculino', 1, '1975-06-10 00:00:00', 1, 1, 1, 2, 53, 1, NULL, '', 0, '0', '', '', 3621, NULL, 'FIJO-AlumnosController. Store-alta', '2015-02-06 00:00:00', NULL, NULL, '2015-02-06 12:48:39', '2015-02-24 15:27:29'),
(10, 'Guanes', 'Fernanda', 1, '14.141.441', 'Masculino', 1, '1980-02-25 00:00:00', 1, 1, 1, 1, 1, 1, NULL, '', 0, '0', '', '', 0, NULL, 'FIJO-AlumnosController. Store-alta', '2015-02-06 00:00:00', NULL, NULL, '2015-02-06 12:49:08', '2015-02-09 16:23:43'),
(17, 'Zaragoza', 'Estela Maria', 1, '25236698', 'Masculino', 2, '1981-06-25 00:00:00', 1, 1, 1, 1, 1, 1, NULL, '', 0, '0', '', '', 3600, NULL, 'FIJO-DocentesController. Store-alta', '2015-02-09 00:00:00', 'bsegovia', '2015-03-10 00:00:00', '2015-02-09 10:49:48', '2015-03-10 14:24:10'),
(19, 'Román', 'Griselda', 4, '25132326', 'Femenino', 1, '1989-02-25 00:00:00', 1, 1, 1, 1, 1, 1, NULL, '', 0, '0', '', '', 0, NULL, 'FIJO-AlumnosController. Store-alta', '2015-02-09 00:00:00', NULL, NULL, '2015-02-09 11:49:13', '2015-02-25 13:16:22'),
(22, 'Acosta', 'David', 1, '35326369', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2015-02-09 17:51:58', '2015-02-10 11:37:00'),
(23, 'Segovia', 'Benjamín', 1, '31691957', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2015-02-10 11:23:35', '2015-02-10 11:23:35'),
(24, 'Riquelme', 'Diego Rubén', 1, '35658239', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2015-02-10 11:25:25', '2015-02-10 11:25:25'),
(25, 'Administrador', 'Administrador', 1, '123456789', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', '2015-04-01 00:00:00', '2015-02-10 11:26:31', '2015-04-01 21:05:17'),
(26, 'Paré', 'Olga', 1, '35687963', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2015-02-10 11:44:16', '2015-02-10 11:44:16'),
(27, 'Silva', 'Diego', 1, '32546896', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2015-02-10 11:53:00', '2015-02-10 11:53:00'),
(28, 'Geréz', 'Walter', 1, '29325236', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2015-02-10 11:54:11', '2015-02-10 11:54:11'),
(29, 'Aguirre', 'Jonathan', 1, '31691957', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2015-02-10 13:05:28', '2015-02-10 13:05:28'),
(30, 'Segovia', 'Benjamín', 1, '31691957', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2015-02-10 13:25:49', '2015-02-10 13:25:49'),
(33, 'Echeverria', 'Sebastian', 1, '25236698', 'Masculino', 1, '1981-02-21 00:00:00', 1, 1, 1, 1, 1, 1, NULL, '', 0, '0', '', '', 0, NULL, 'FIJO-DocentesController. Store-alta', '2015-02-11 00:00:00', NULL, NULL, '2015-02-11 13:32:05', '2015-02-11 14:41:54'),
(34, 'Genes', 'Carolina', 1, '25132323', 'Masculino', 1, '1983-01-12 00:00:00', 1, 1, 1, 1, 1, 1, NULL, '', 0, '0', '', '', 0, NULL, 'FIJO-AlumnosController. Store-alta', '2015-02-11 00:00:00', NULL, NULL, '2015-02-11 13:33:49', '2015-02-11 13:33:49'),
(35, 'Estigarribia', 'Enrique Ramón', 1, '25236698', 'Masculino', 2, '1980-12-12 00:00:00', 1, 1, 1, 1, 1, 1, NULL, '', 0, '0', '', '', 0, NULL, 'FIJO-DocentesController. Store-alta', '2015-02-11 00:00:00', NULL, NULL, '2015-02-11 14:18:43', '2015-02-19 11:42:27'),
(36, 'Aguirre', 'Jorge', 1, '31691957', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2015-02-12 13:17:13', '2015-02-12 13:17:13'),
(37, 'Sandoval', 'Ezequiel', 1, '35269589', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2015-02-12 13:37:36', '2015-02-12 13:37:36'),
(38, 'Ramirez', 'Rodolfo', 1, '32569789', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2015-02-12 13:38:44', '2015-02-12 13:38:44'),
(40, 'Dalmaso', 'Mirta', 1, '2326565', 'Femenino', 2, '1989-05-23 00:00:00', 1, 1, 1, 1, 1, 1, NULL, '', 0, '0', '', '', 0, NULL, 'FIJO-DocentesController. Store-alta', '2015-02-12 00:00:00', 'admin', '2015-03-13 00:00:00', '2015-02-12 13:47:35', '2015-03-13 12:33:08'),
(41, 'Sanabria', 'Samuel Andrés', 1, '32654789', 'Masculino', 4, '1980-03-06 00:00:00', 1, 1, 1, 1, 1, 1, NULL, '', 0, '0', '', '', 0, NULL, 'FIJO-DocentesController. Store-alta', '2015-02-12 00:00:00', NULL, NULL, '2015-02-12 13:49:31', '2015-02-12 13:49:38'),
(43, 'Maldonado', 'Ernesto Javier', 3, 'AB121351', 'Masculino', 1, '1980-12-12 00:00:00', 1, 1, 1, 1, 1, 1, NULL, '', 0, '0', '', '', 0, NULL, 'FIJO-DocentesController. Store-alta', '2015-02-12 00:00:00', 'admin', '2015-03-12 00:00:00', '2015-02-12 14:04:29', '2015-03-12 14:12:04'),
(44, 'Acosta', 'Sergio', 1, '31691957', 'Masculino', 1, '1984-01-25 00:00:00', 1, 1, 1, 1, 1, 1, NULL, '', 0, '0', '', '', 0, NULL, 'FIJO-DocentesController. Store-alta', '2015-02-12 00:00:00', NULL, NULL, '2015-02-12 17:59:32', '2015-02-26 12:33:29'),
(45, 'Gonzalez', 'Gerardo', 1, '31654789', 'Masculino', 1, '1983-01-23 00:00:00', 1, 1, 1, 1, 1, 1, NULL, '', 0, '0', '', '', 0, NULL, 'FIJO-DocentesController. Store-alta', '2015-02-12 00:00:00', NULL, NULL, '2015-02-12 18:01:17', '2015-02-12 18:01:50'),
(46, 'Palacios', 'Miguel Angel', 1, '31691957', 'Masculino', 2, '1978-04-12 00:00:00', 1, 1, 1, 1, 1, 1, NULL, '', 0, '0', '', '', 0, NULL, 'FIJO-DocentesController. Store-alta', '2015-02-12 00:00:00', NULL, NULL, '2015-02-12 18:04:19', '2015-02-26 12:32:33'),
(48, 'Salvatierra', 'Daniel Osvaldo', 1, '35258896', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2015-02-20 13:06:30', '2015-02-20 13:06:30'),
(49, 'Orquera', 'Sebastian', 1, '25236987', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2015-02-20 13:10:15', '2015-02-20 13:10:15'),
(50, 'Rodriguez', 'Santiago', 1, '32569781', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2015-02-23 11:01:53', '2015-02-26 14:56:17'),
(51, 'Centurión', 'Carlos', 1, '25369789', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2015-02-23 12:10:14', '2015-02-23 13:46:03'),
(52, 'Figeroa', 'Gustavo', 1, '31691955', 'Masculino', 1, '1983-07-25 00:00:00', 1, 1, 1, 1, 1, 1, NULL, '', 0, '0', '', '', 0, NULL, 'FIJO-AlumnosController. Store-alta', '2015-02-26 00:00:00', NULL, NULL, '2015-02-26 12:28:38', '2015-03-02 18:35:29'),
(53, 'Román', 'Estela Maria', 1, '35687961', 'Femenino', 1, '1980-12-12 00:00:00', 1, 1, 1, 1, 1, 1, NULL, '', 0, '0', '', '', 0, NULL, 'FIJO-AlumnosController. Store-alta', '2015-02-26 00:00:00', NULL, NULL, '2015-02-26 12:30:31', '2015-03-05 11:57:00'),
(54, 'Sand', 'Marcelo', 1, '31691957', 'Masculino', 1, '1980-05-12 00:00:00', 1, 1, 1, 1, 1, 1, NULL, '', 0, '0', '', '', 0, NULL, 'FIJO-AlumnosController. Store-alta', '2015-02-26 00:00:00', NULL, NULL, '2015-02-26 12:35:04', '2015-02-26 14:03:29'),
(55, 'Acosta', 'Damian ', 1, '36256897', 'Masculino', 2, '1983-02-12 00:00:00', 1, 1, 1, 1, 1, 1, NULL, '', 0, '0', '', '', 0, NULL, 'FIJO-AlumnosController. Store-alta', '2015-02-27 00:00:00', NULL, NULL, '2015-02-27 10:47:06', '2015-03-04 13:45:01'),
(56, 'Ruiz Diaz', 'Neslon', 1, '252369789', 'Masculino', 1, '1987-06-05 00:00:00', 1, 1, 1, 1, 1, 1, NULL, '', 0, '0', '', '', 3600, NULL, 'FIJO-AlumnosController. Store-alta', '2015-02-27 00:00:00', 'admin', '2015-03-13 00:00:00', '2015-02-27 10:47:57', '2015-03-13 12:31:37'),
(57, 'Miño', 'Jose', 1, '25236987', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'bsegovia', '2015-03-11 00:00:00', '2015-02-27 14:11:37', '2015-03-11 17:42:37'),
(58, 'Navarrete', 'Daniel', 1, '32569789', 'Masculino', 1, '1980-02-25 00:00:00', 1, 1, 1, 2, 53, 2, NULL, 'Independencia', 150, '0', '', '', 0, NULL, 'FIJO-AlumnosController. Store-alta', '2015-03-02 00:00:00', 'admin', '2015-03-12 00:00:00', '2015-03-02 10:15:26', '2015-03-12 14:59:45'),
(59, 'Rivarola', 'Federico Santiago', 1, '23258963', 'Masculino', 1, '1983-10-09 00:00:00', 1, 1, 1, 1, 1, 1, NULL, '', 0, '0', '', '', 0, NULL, 'FIJO-AlumnosController. Store-alta', '2015-03-02 00:00:00', NULL, NULL, '2015-03-02 10:16:31', '2015-03-02 10:16:55'),
(60, 'Rivarola', 'Ernesto Javier', 1, '32658987', 'Masculino', 1, '1981-02-25 00:00:00', 1, 1, 1, 1, 1, 1, NULL, '', 0, '0', '', '', 3600, NULL, 'bsegovia', '2015-03-05 00:00:00', NULL, NULL, '2015-03-05 11:13:21', '2015-03-05 11:13:21'),
(61, 'Segovia', 'Benjamín', 1, '31691957', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2015-03-09 12:42:46', '2015-03-09 12:42:46'),
(62, 'Sanchez', 'David', 1, '12345678', 'Masculino', 1, '1981-03-12 00:00:00', 1, 1, 1, 1, 1, 1, NULL, '', 0, '0', '', '', 1234, NULL, 'bsegovia', '2015-03-09 00:00:00', 'esandoval', '2015-03-10 00:00:00', '2015-03-09 14:01:31', '2015-03-10 14:55:53'),
(63, 'Benitez', 'Natalia ', 1, '25236987', 'Femenino', 1, '1987-06-25 00:00:00', 1, 1, 1, 1, 1, 1, NULL, '', 0, '0', '', '', 0, NULL, 'bsegovia', '2015-03-09 00:00:00', NULL, NULL, '2015-03-09 14:56:02', '2015-03-09 14:56:02'),
(64, 'Figeroa', 'Mirta', 1, '253656552', 'Femenino', 1, '1980-02-25 00:00:00', 1, 1, 1, 1, 1, 1, NULL, '', 0, '0', '', '', 0, NULL, 'bsegovia', '2015-03-12 00:00:00', NULL, NULL, '2015-03-12 13:50:57', '2015-03-12 13:50:57'),
(65, 'Figeroa', 'Mirta', 1, '253656552', 'Femenino', 1, '1980-02-25 00:00:00', 1, 1, 1, 1, 1, 1, NULL, '', 0, '0', '', '', 0, NULL, 'bsegovia', '2015-03-12 00:00:00', NULL, NULL, '2015-03-12 13:52:08', '2015-03-12 13:52:08'),
(66, 'Apellido', 'Nombre', 1, '1234565', 'Masculino', 1, '2012-03-21 00:00:00', 1, 1, 1, 1, 1, 1, NULL, '', 0, '0', '', '', 0, NULL, 'admin', '2015-03-12 00:00:00', 'admin', '2015-03-12 00:00:00', '2015-03-12 14:14:33', '2015-03-12 14:20:47'),
(67, 'Figeroa', 'Gustavo', 1, '25236987', 'Masculino', 1, '1982-03-25 00:00:00', 1, 1, 1, 2, 53, 2, NULL, 'Córdoba ', 540, '0', '', '', 3600, NULL, 'admin', '2015-03-13 00:00:00', 'admin', '2015-03-25 00:00:00', '2015-03-13 17:51:13', '2015-03-25 11:32:54'),
(68, 'Maldonado', 'Sebastian', 1, '25236981', 'Masculino', 1, '1980-03-12 00:00:00', 1, 1, 1, 5, 53, 1, NULL, 'Irigoyen', 260, '0', '', '', 3600, NULL, 'admin', '2015-03-16 00:00:00', 'admin', '2015-03-25 00:00:00', '2015-03-16 11:36:40', '2015-03-25 11:33:09'),
(69, 'Segovia', 'Benjamin', 1, '31691957', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', '2015-03-17 00:00:00', 'admin', '2015-06-01 00:00:00', '2015-03-17 14:43:37', '2015-06-01 12:15:10'),
(70, 'Román', 'Estela Maria', 1, '21321', 'Masculino', 1, '2012-03-12 00:00:00', 1, 1, 1, 1, 1, 1, NULL, '', 0, '0', '', '', 0, NULL, 'admin', '2015-03-20 00:00:00', NULL, NULL, '2015-03-20 14:48:05', '2015-03-20 14:48:05'),
(71, 'Dalmaso', 'Mirta', 1, '131222132', 'Femenino', 1, '2012-12-23 00:00:00', 1, 1, 1, 1, 1, 1, NULL, '', 0, '0', '', '', 0, NULL, 'admin', '2015-03-20 00:00:00', NULL, NULL, '2015-03-20 15:01:31', '2015-03-20 15:01:31'),
(72, 'Gerula', 'Enrique', 1, '1321321', 'Masculino', 1, '2012-03-12 00:00:00', 1, 1, 1, 1, 1, 1, NULL, '', 0, '0', '', '', 0, NULL, 'admin', '2015-03-20 00:00:00', NULL, NULL, '2015-03-20 15:02:02', '2015-03-20 15:02:02'),
(73, 'Zaragoza', 'Natalia ', 1, '1231321', 'Femenino', 2, '2011-12-23 00:00:00', 1, 1, 1, 1, 1, 1, NULL, '', 0, '0', '', '', 0, NULL, 'admin', '2015-03-20 00:00:00', 'admin', '2015-03-20 00:00:00', '2015-03-20 15:13:17', '2015-03-20 15:13:28'),
(74, 'Sandoval', 'María Cristina', 1, '3213211', 'Femenino', 1, '2013-02-21 00:00:00', 1, 1, 1, 1, 1, 1, NULL, '', 0, '0', '', '', 0, NULL, 'admin', '2015-03-20 00:00:00', 'admin', '2015-03-20 00:00:00', '2015-03-20 15:14:05', '2015-03-20 15:14:20'),
(75, 'Arevalo', 'Valeria Lujan', 1, '38576702', 'Femenino', 1, '1995-09-29 00:00:00', 1, 1, 1, 2, 53, 39, NULL, 'Av. Nestor Kirchner s/n', 0, '0', '', '', 3600, NULL, 'admin', '2015-03-25 00:00:00', 'admin', '2015-03-30 00:00:00', '2015-03-25 12:07:31', '2015-03-30 13:19:08'),
(76, 'Acosta', 'David', 1, '12345678', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', '2015-03-25 00:00:00', 'bsegovia', '2015-04-01 00:00:00', '2015-03-25 13:05:33', '2015-04-01 14:03:16'),
(77, 'Dorrego', 'Claudia', 1, '25889620', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', '2015-03-25 00:00:00', 'bsegovia', '2015-04-01 00:00:00', '2015-03-25 13:20:38', '2015-04-01 14:04:02'),
(78, 'Teresita', 'Brizuela', 1, '23269996', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', '2015-03-25 00:00:00', 'bsegovia', '2015-04-01 00:00:00', '2015-03-25 13:22:12', '2015-04-01 14:04:49'),
(79, 'Gómez', 'Daniel', 1, '27576558', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', '2015-03-25 00:00:00', NULL, NULL, '2015-03-25 13:24:32', '2015-03-25 13:24:32'),
(80, 'Dasso', 'Hugo', 1, '1245678', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', '2015-03-25 00:00:00', 'bsegovia', '2015-04-01 00:00:00', '2015-03-25 13:25:09', '2015-04-01 14:05:24'),
(81, 'Lovera', 'Ariel', 1, '1234567', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', '2015-03-25 00:00:00', NULL, NULL, '2015-03-25 13:31:06', '2015-03-25 13:31:06'),
(82, 'Candia', 'Mirtha', 1, '17560453', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', '2015-03-25 00:00:00', 'bsegovia', '2015-04-01 00:00:00', '2015-03-25 13:31:41', '2015-04-01 14:12:25'),
(83, 'Arrua', 'Fernanda', 1, '38191394', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', '2015-03-25 00:00:00', 'admin', '2015-05-22 00:00:00', '2015-03-25 13:34:05', '2015-05-22 13:52:43'),
(84, 'Brandan', 'Carla Susana', 1, '39607256', 'Femenino', 1, '1996-05-16 00:00:00', 1, 1, 1, 2, 53, 39, NULL, 'Illia 1', 6, '38', '', '', 3600, '23396072564', 'admin', '2015-03-27 00:00:00', 'dgomez', '2015-03-31 00:00:00', '2015-03-27 17:12:27', '2015-03-31 15:01:17'),
(85, 'Gerez', 'Walter', 1, '26555531', 'Masculino', 2, '1979-02-11 00:00:00', 1, 1, 1, 2, 53, 39, 'Illia 1', '', 0, 'L', '', '', 0, '', 'admin', '2015-03-27 00:00:00', 'admin', '2015-06-22 00:00:00', '2015-03-27 17:27:46', '2015-06-22 14:34:33'),
(86, 'Acevedo', 'Hector Manuel', 1, '37468203', 'Masculino', 1, '1993-05-12 00:00:00', 1, 1, 1, 2, 53, 31, NULL, '', 34, '112', '', '', 3600, '20374682033', 'alovera', '2015-03-31 00:00:00', NULL, NULL, '2015-03-31 14:51:06', '2015-03-31 14:51:06'),
(87, 'Chirife', 'Rocio Elizabeth', 1, '31865565', 'Femenino', 1, '1985-05-06 00:00:00', 1, 1, 1, 2, 53, 39, NULL, 'paraguay', 4435, '0', '', '', 3600, '27318655658', 'dgomez', '2015-03-31 00:00:00', 'admin', '2015-04-16 00:00:00', '2015-03-31 15:17:58', '2015-04-16 15:21:24'),
(88, 'Espinoza', 'Raquel Analia', 1, '32234090', 'Femenino', 1, '1997-06-04 00:00:00', 1, 1, 1, 2, 53, 39, 'Guadalupe', 'uruguay', 556, '0', '', '', 3600, '27322340902', 'dgomez', '2015-03-31 00:00:00', 'admin', '2015-05-15 00:00:00', '2015-03-31 15:31:51', '2015-05-15 14:19:46'),
(89, 'Godo', 'Sabrina', 1, '40084936', 'Femenino', 1, '1997-01-27 00:00:00', 1, 1, 1, 2, 53, 39, '', 'san martin', 127, '0', '', '', 3600, '2740089361', 'dgomez', '2015-03-31 00:00:00', 'admin', '2015-06-04 00:00:00', '2015-03-31 15:40:00', '2015-06-04 14:50:48'),
(90, 'Prini', 'Belen Roxana', 1, '40214643', 'Femenino', 1, '1997-07-01 00:00:00', 1, 1, 1, 2, 53, 39, NULL, '', 29, '72', '', '', 3600, '27402146430', 'dgomez', '2015-03-31 00:00:00', NULL, NULL, '2015-03-31 16:00:04', '2015-03-31 16:00:04'),
(91, 'Mendoza', 'Sheila Alejandra', 1, '36203915', 'Femenino', 1, '1991-10-16 00:00:00', 1, 1, 1, 2, 53, 39, NULL, 'Eva peron', 1043, '0', '', '', 3600, '27362039156', 'dgomez', '2015-03-31 00:00:00', NULL, NULL, '2015-03-31 16:17:26', '2015-03-31 16:17:26'),
(92, 'Gallego', 'Sofia Ayelen', 1, '38541087', 'Femenino', 1, '1994-11-08 00:00:00', 1, 1, 1, 2, 53, 39, NULL, 'trinidad gonzalez y corrientes', 0, '0', '', '', 3600, '20385410872', 'dgomez', '2015-03-31 00:00:00', NULL, NULL, '2015-03-31 16:37:03', '2015-03-31 16:37:03'),
(93, 'Cardozo', 'Julio Emmanuel', 1, '32048532', 'Masculino', 1, '1986-03-11 00:00:00', 1, 1, 1, 2, 53, 39, 'Sarmiento', '', 2, '100', '', '', 3600, '20320485321', 'mcandia', '2015-03-31 00:00:00', 'admin', '2015-05-14 00:00:00', '2015-03-31 22:39:30', '2015-05-14 16:30:03'),
(94, 'ARANDA ', 'JORGE AGUSTIN', 1, '31406651', 'Masculino', 1, '1985-06-21 00:00:00', 1, 1, 1, 2, 53, 39, NULL, 'BARRIO 17 DE OCTUBRE', 0, '62', '', '16', 3600, '20314066511', 'mcandia', '2015-03-31 00:00:00', NULL, NULL, '2015-03-31 22:42:47', '2015-03-31 22:42:47'),
(95, 'CASTRO ', 'MARIA CECILIA', 1, '31071391', 'Femenino', 1, '1985-04-10 00:00:00', 1, 1, 1, 2, 53, 39, NULL, '', 2, '8', '', 'B', 3600, '27316713918', 'mcandia', '2015-03-31 00:00:00', 'mcandia', '2015-03-31 00:00:00', '2015-03-31 23:05:57', '2015-03-31 23:09:28'),
(96, 'CHAPARRO', 'ALEJANDRA AGLAE', 1, '28781722', 'Femenino', 1, '1981-09-11 00:00:00', 1, 1, 1, 2, 53, 39, NULL, 'FUERZA AEREA Y NESTOR KIRCHNNER', 112, '0', '', 'G', 3600, '272287817229', 'mcandia', '2015-03-31 00:00:00', 'cdorrego', '2015-03-31 00:00:00', '2015-03-31 23:19:02', '2015-03-31 23:45:16'),
(97, 'DUARTE', 'EMILIO EDUARDO', 1, '37911008', 'Masculino', 1, '1993-12-31 00:00:00', 1, 1, 1, 2, 53, 39, NULL, 'FILHO', 264, '0', '', '', 3600, '20379110089', 'mcandia', '2015-03-31 00:00:00', 'mcandia', '2015-03-31 00:00:00', '2015-03-31 23:26:29', '2015-03-31 23:32:23'),
(98, 'FARAY', 'CRISTIAN ALBERTO', 1, '31091337', 'Masculino', 1, '1985-11-03 00:00:00', 1, 1, 1, 5, 257, 39, '8 de Octubre Bis', 'Acosta', 25, '', '', '', 0, '20316913376', 'mcandia', '2015-03-31 00:00:00', 'admin', '2015-05-14 00:00:00', '2015-03-31 23:39:53', '2015-05-14 14:31:42'),
(99, 'GALLARDO', 'MARIA BELEN', 1, '38378916', 'Femenino', 1, '1994-08-03 00:00:00', 1, 1, 1, 2, 53, 39, 'San Martin', 'Av. 25 de mayo 2025', 13, '330', '', 'G', 3600, '2738378916', 'mcandia', '2015-03-31 00:00:00', 'admin', '2015-05-21 00:00:00', '2015-03-31 23:51:27', '2015-05-21 17:12:43'),
(100, 'Gallardo', 'María de los Angeles', 1, '38378917', 'Femenino', 1, '1994-08-03 00:00:00', 1, 1, 1, 2, 53, 29, NULL, '', 13, '330', '', 'G 9', 3600, '27383789171', 'mcandia', '2015-03-31 00:00:00', 'cdorrego', '2015-04-01 00:00:00', '2015-03-31 23:59:21', '2015-04-01 13:11:29'),
(101, 'GAMBATTI', 'ROMINA SOLEDAD', 1, '30445260', 'Femenino', 2, '1983-11-18 00:00:00', 1, 1, 1, 2, 53, 13, NULL, 'MAIPU', 1895, '0', '', '', 3600, '27304452604', 'mcandia', '2015-04-01 00:00:00', NULL, NULL, '2015-04-01 00:15:44', '2015-04-01 00:15:44'),
(102, 'GONZALES', 'JOSE ENRIQUE', 1, '22486262', 'Masculino', 1, '1971-12-14 00:00:00', 1, 1, 1, 2, 53, 39, 'Don Bosco', 'ARENALES ', 534, '', '', '', 3600, '20224862629', 'mcandia', '2015-04-01 00:00:00', 'admin', '2015-05-21 00:00:00', '2015-04-01 00:15:57', '2015-05-21 14:55:33'),
(103, 'GONZÁLES', 'MAURICIO NICOLAS', 1, '37585626', 'Masculino', 1, '1993-06-26 00:00:00', 1, 1, 1, 2, 53, 39, NULL, 'LIBERTAD', 1654, '0', '', '', 3600, '20375856264', 'mcandia', '2015-04-01 00:00:00', 'mcandia', '2015-04-01 00:00:00', '2015-04-01 00:33:22', '2015-04-01 00:39:30'),
(104, 'LEAL', 'ROCIO ELIZABETH', 1, '35003057', 'Femenino', 1, '1989-10-15 00:00:00', 1, 1, 1, 2, 53, 39, '', 'CORDOBA', 1463, '0', '', '', 3600, '2735003059', 'mcandia', '2015-04-01 00:00:00', 'admin', '2015-07-27 00:00:00', '2015-04-01 00:45:59', '2015-07-27 18:16:06'),
(105, 'LEZCANO', 'CARMEN MARIANELLA', 1, '36956567', 'Femenino', 1, '1992-07-16 00:00:00', 1, 1, 1, 2, 53, 39, '', '', 0, '8', '', '', 36000, '27369565678', 'mcandia', '2015-04-01 00:00:00', 'admin', '2015-07-10 00:00:00', '2015-04-01 00:56:01', '2015-07-10 14:21:35'),
(106, 'LEZCANO', 'MARIA LAURA', 1, '31671507', 'Femenino', 1, '1985-05-15 00:00:00', 1, 1, 1, 2, 53, 39, '', '', 5, '7', '', 'SB', 36000, '27316715074', 'mcandia', '2015-04-01 00:00:00', 'admin', '2015-06-02 00:00:00', '2015-04-01 01:03:30', '2015-06-02 18:08:39'),
(107, 'MALDONADO', 'MELISA MARIANA', 1, '36955802', 'Femenino', 1, '1990-05-19 00:00:00', 1, 1, 1, 2, 53, 38, NULL, 'BERUTTI', 840, '0', '', '', 3600, '27369558027', 'mcandia', '2015-04-01 00:00:00', 'mcandia', '2015-04-01 00:00:00', '2015-04-01 01:10:34', '2015-04-01 01:11:52'),
(108, 'MEDINA', 'ISMAEL REINALDO', 1, '24287653', 'Masculino', 1, '1974-12-30 00:00:00', 1, 1, 1, 2, 53, 39, NULL, 'ANTONIO BERUTTI', 1196, '0', '', '', 3600, '23242876539', 'mcandia', '2015-04-01 00:00:00', 'mcandia', '2015-04-01 00:00:00', '2015-04-01 01:18:38', '2015-04-01 01:20:05'),
(109, 'Ruiz', 'Alejandra Isabel', 1, '34047079', 'Femenino', 1, '1988-09-09 00:00:00', 1, 1, 1, 2, 53, 37, NULL, '', 13, '74', '', '', 3600, '27340470791', 'dgomez', '2015-04-01 00:00:00', NULL, NULL, '2015-04-01 15:30:20', '2015-04-01 15:30:20'),
(110, 'Villalba', 'Angel Matias', 1, '40213111', 'Masculino', 1, '1997-07-22 00:00:00', 1, 1, 1, 2, 53, 15, NULL, '', 0, '0', '', '', 3600, '20402131110', 'dgomez', '2015-04-01 00:00:00', NULL, NULL, '2015-04-01 15:44:48', '2015-04-01 15:44:48'),
(111, 'Zayas', 'Carla Nair', 1, '399022687', 'Femenino', 1, '1997-03-12 00:00:00', 1, 1, 1, 5, 258, 39, 'Venezuela', '', 1, '32', '', '', 3600, '27399022687', 'dgomez', '2015-04-01 00:00:00', 'admin', '2015-05-15 00:00:00', '2015-04-01 15:55:14', '2015-05-15 13:14:48'),
(112, 'Villagra', 'Nicolas Franco', 1, '38378372', 'Masculino', 1, '1994-09-24 00:00:00', 1, 1, 1, 2, 53, 9, NULL, 'guiraldes', 1444, '0', '', '', 3600, '20383783721', 'dgomez', '2015-04-01 00:00:00', NULL, NULL, '2015-04-01 16:01:58', '2015-04-01 16:01:58'),
(113, 'Ortiz', 'Orlando Gabriel', 1, '39719162', 'Masculino', 1, '1996-06-16 00:00:00', 1, 1, 1, 2, 53, 39, '', 'paraguay', 4145, '0', '', '', 3600, '20397191622', 'dgomez', '2015-04-01 00:00:00', 'admin', '2015-06-04 00:00:00', '2015-04-01 16:17:56', '2015-06-04 14:42:25'),
(114, 'Zaragoza', 'Lidia', 1, '2532323', 'Femenino', 1, '1998-07-25 00:00:00', 1, 1, 1, 1, 1, 39, 'San Martin', 'SARMIENTO ', 520, 'H', '', '', 0, '212123323', 'admin', '2015-04-07 00:00:00', 'admin', '2015-06-16 00:00:00', '2015-04-07 12:43:41', '2015-06-16 15:39:41'),
(115, 'Mendieta', 'Oscar', 1, '32159789', 'Masculino', 1, '1984-05-12 00:00:00', 1, 1, 1, 2, 54, 39, '', 'San Martín', 120, '', '', '', 3600, '', 'admin', '2015-06-16 00:00:00', 'admin', '2015-07-15 00:00:00', '2015-06-16 13:40:59', '2015-07-15 13:24:14'),
(116, 'Gomez', 'Esteban Sebastian', 1, '33008560', 'Masculino', 1, '1987-05-10 00:00:00', 1, 1, 1, 2, 53, 39, 'Fontana', 'Maipú', 1778, '', '', '', 3600, '', 'admin', '2015-07-28 00:00:00', NULL, NULL, '2015-07-28 11:16:04', '2015-07-28 11:16:04'),
(117, 'Avila', 'Manuel David', 1, '33456282', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', '2015-09-15 00:00:00', NULL, NULL, '2015-09-15 17:41:32', '2015-09-15 17:41:32');

--
-- Disparadores `personas`
--
DROP TRIGGER IF EXISTS `tr_personas_baja_log`;
DELIMITER //
CREATE TRIGGER `tr_personas_baja_log` AFTER DELETE ON `personas`
 FOR EACH ROW insert into aud_personas_log (id,apellido,nombre,tipodocumento_id,nrodocumento,sexo,estadocivil_id,fechanacimiento,lugarnacimiento_id,pais_id,provincia_id,departamento_id,localidad_id,barrio_id,calle,numero,manzana,piso,departamento,codigo_postal,usuario,fecha,baja)
values (OLD.id,OLD.apellido,OLD.nombre,OLD.tipodocumento_id,OLD.nrodocumento,OLD.sexo,OLD.estadocivil_id,OLD.fechanacimiento,OLD.lugarnacimiento_id,OLD.pais_id,OLD.provincia_id,OLD.departamento_id,OLD.localidad_id,OLD.barrio_id,OLD.calle,OLD.numero,OLD.manzana,OLD.piso,OLD.departamento,OLD.codigo_postal, OLD.usuario_modi,NOW(), 1)
//
DELIMITER ;
DROP TRIGGER IF EXISTS `tr_personas_modi_log`;
DELIMITER //
CREATE TRIGGER `tr_personas_modi_log` AFTER UPDATE ON `personas`
 FOR EACH ROW insert into aud_personas_log (id,apellido,nombre,tipodocumento_id,nrodocumento,sexo,estadocivil_id,fechanacimiento,lugarnacimiento_id,pais_id,provincia_id,departamento_id,localidad_id,barrio_id,calle,numero,manzana,piso,departamento,codigo_postal,usuario,fecha,modi)
values (OLD.id,OLD.apellido,OLD.nombre,OLD.tipodocumento_id,OLD.nrodocumento,OLD.sexo,OLD.estadocivil_id,OLD.fechanacimiento,OLD.lugarnacimiento_id,OLD.pais_id,OLD.provincia_id,OLD.departamento_id,OLD.localidad_id,OLD.barrio_id,OLD.calle,OLD.numero,OLD.manzana,OLD.piso,OLD.departamento,OLD.codigo_postal, NEW.usuario_modi,NOW(), 1)
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planesestudios`
--

CREATE TABLE IF NOT EXISTS `planesestudios` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `carrera_id` int(10) unsigned DEFAULT NULL,
  `codigoplan` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `ciclolectivo_id` int(10) unsigned NOT NULL,
  `tituloplan` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `fechainicio` timestamp NULL DEFAULT NULL,
  `fechafin` timestamp NULL DEFAULT NULL,
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `planesestudios_carrera_id_foreign` (`carrera_id`),
  KEY `planesestudios_ciclolectivo_id_foreign` (`ciclolectivo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Volcado de datos para la tabla `planesestudios`
--

INSERT INTO `planesestudios` (`id`, `carrera_id`, `codigoplan`, `ciclolectivo_id`, `tituloplan`, `fechainicio`, `fechafin`, `usuario_alta`, `fecha_alta`, `usuario_modi`, `fecha_modi`, `created_at`, `updated_at`) VALUES
(13, 28, 'TSEIQ/2015', 7, 'TECNICATURA SUPERIOR EN INSTRUMENTACIÓN QUIRURGICA', '2015-02-01 00:00:00', NULL, 'admin', '2015-12-04 00:00:00', NULL, NULL, '2015-12-04 11:19:53', '2015-12-04 11:19:53'),
(14, 30, 'TSESMI/2015', 7, 'TECNICATURA SUPERIOR EN SALUD MATERNO INFANTIL', '2015-02-01 00:00:00', NULL, 'admin', '2015-12-04 00:00:00', NULL, NULL, '2015-12-04 11:23:06', '2015-12-04 11:23:06'),
(15, 32, 'TEMN/2015', 7, 'TECNICATURA EN MEDICINA NUCLEAR', '2015-02-01 00:00:00', NULL, 'admin', '2015-12-04 00:00:00', NULL, NULL, '2015-12-04 11:23:23', '2015-12-04 11:23:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provincias`
--

CREATE TABLE IF NOT EXISTS `provincias` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pais_id` int(10) unsigned NOT NULL,
  `descripcion` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `provincias_pais_id_foreign` (`pais_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `provincias`
--

INSERT INTO `provincias` (`id`, `pais_id`, `descripcion`, `usuario_alta`, `fecha_alta`, `usuario_modi`, `fecha_modi`, `created_at`, `updated_at`) VALUES
(1, 1, 'Formosa', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Disparadores `provincias`
--
DROP TRIGGER IF EXISTS `tr_provincias_baja_log`;
DELIMITER //
CREATE TRIGGER `tr_provincias_baja_log` AFTER DELETE ON `provincias`
 FOR EACH ROW insert into aud_provincias_log (id,pais_id,descripcion,usuario,fecha,baja)
values (OLD.id,OLD.pais_id,OLD.descripcion, OLD.usuario_modi,NOW(), 1)
//
DELIMITER ;
DROP TRIGGER IF EXISTS `tr_provincias_modi_log`;
DELIMITER //
CREATE TRIGGER `tr_provincias_modi_log` AFTER UPDATE ON `provincias`
 FOR EACH ROW insert into aud_provincias_log (id,pais_id,descripcion,usuario,fecha,modi)
values (OLD.id,OLD.pais_id,OLD.descripcion, NEW.usuario_modi,NOW(), 1)
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `regimenes`
--

CREATE TABLE IF NOT EXISTS `regimenes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `regimenes`
--

INSERT INTO `regimenes` (`id`, `descripcion`, `usuario_alta`, `fecha_alta`, `usuario_modi`, `fecha_modi`, `created_at`, `updated_at`) VALUES
(7, 'Anual', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 'Cuatrimestral', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 'Mixto', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Disparadores `regimenes`
--
DROP TRIGGER IF EXISTS `tr_regimenes_baja_log`;
DELIMITER //
CREATE TRIGGER `tr_regimenes_baja_log` AFTER DELETE ON `regimenes`
 FOR EACH ROW insert into aud_regimenes_log (id,descripcion,usuario,fecha,baja)
values (OLD.id,OLD.descripcion,OLD.usuario_modi,NOW(), 1)
//
DELIMITER ;
DROP TRIGGER IF EXISTS `tr_regimenes_modi_log`;
DELIMITER //
CREATE TRIGGER `tr_regimenes_modi_log` AFTER UPDATE ON `regimenes`
 FOR EACH ROW insert into aud_regimenes_log (id,descripcion,usuario,fecha,modi)
values (OLD.id,OLD.descripcion,NEW.usuario_modi,NOW(), 1)
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relacionesfamiliares`
--

CREATE TABLE IF NOT EXISTS `relacionesfamiliares` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Disparadores `relacionesfamiliares`
--
DROP TRIGGER IF EXISTS `tr_relacionesfamiliares_baja_log`;
DELIMITER //
CREATE TRIGGER `tr_relacionesfamiliares_baja_log` AFTER DELETE ON `relacionesfamiliares`
 FOR EACH ROW insert into aud_relacionesfamiliares_log (id,descripcion,usuario,fecha,baja)
values (OLD.id,OLD.descripcion, OLD.usuario_modi,NOW(), 1)
//
DELIMITER ;
DROP TRIGGER IF EXISTS `tr_relacionesfamiliares_modi_log`;
DELIMITER //
CREATE TRIGGER `tr_relacionesfamiliares_modi_log` AFTER UPDATE ON `relacionesfamiliares`
 FOR EACH ROW insert into aud_relacionesfamiliares_log (id,descripcion,usuario,fecha,modi)
values (OLD.id,OLD.descripcion, NEW.usuario_modi,NOW(), 1)
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipodocumentos`
--

CREATE TABLE IF NOT EXISTS `tipodocumentos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Volcado de datos para la tabla `tipodocumentos`
--

INSERT INTO `tipodocumentos` (`id`, `descripcion`, `usuario_alta`, `fecha_alta`, `usuario_modi`, `fecha_modi`, `created_at`, `updated_at`) VALUES
(1, 'DNI', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'PAS', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'CI', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'LE', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 'LC', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Disparadores `tipodocumentos`
--
DROP TRIGGER IF EXISTS `tr_tipodocumentos_baja_log`;
DELIMITER //
CREATE TRIGGER `tr_tipodocumentos_baja_log` AFTER DELETE ON `tipodocumentos`
 FOR EACH ROW insert into aud_tipodocumentos_log (id,descripcion,usuario,fecha,baja)
values (OLD.id,OLD.descripcion, OLD.usuario_modi,NOW(), 1)
//
DELIMITER ;
DROP TRIGGER IF EXISTS `tr_tipodocumentos_modi_log`;
DELIMITER //
CREATE TRIGGER `tr_tipodocumentos_modi_log` AFTER UPDATE ON `tipodocumentos`
 FOR EACH ROW insert into aud_tipodocumentos_log (id,descripcion,usuario,fecha,modi)
values (OLD.id,OLD.descripcion, NEW.usuario_modi,NOW(), 1)
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiposcarreras`
--

CREATE TABLE IF NOT EXISTS `tiposcarreras` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `tiposcarreras`
--

INSERT INTO `tiposcarreras` (`id`, `descripcion`, `usuario_alta`, `fecha_alta`, `usuario_modi`, `fecha_modi`, `created_at`, `updated_at`) VALUES
(1, 'Curso', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Pregrado', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Grado', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'Postgrado', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Disparadores `tiposcarreras`
--
DROP TRIGGER IF EXISTS `tr_tiposcarreras_baja_log`;
DELIMITER //
CREATE TRIGGER `tr_tiposcarreras_baja_log` AFTER DELETE ON `tiposcarreras`
 FOR EACH ROW insert into aud_tiposcarreras_log (id,descripcion,usuario,fecha,baja)
values (OLD.id,OLD.descripcion,OLD.usuario_modi,NOW(), 1)
//
DELIMITER ;
DROP TRIGGER IF EXISTS `tr_tiposcarreras_modi_log`;
DELIMITER //
CREATE TRIGGER `tr_tiposcarreras_modi_log` AFTER UPDATE ON `tiposcarreras`
 FOR EACH ROW insert into aud_tiposcarreras_log (id,descripcion,usuario,fecha,modi)
values (OLD.id,OLD.descripcion,NEW.usuario_modi,NOW(), 1)
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiposcontratos`
--

CREATE TABLE IF NOT EXISTS `tiposcontratos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `titulo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `clausulas` text COLLATE utf8_unicode_ci NOT NULL,
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `tiposcontratos`
--

INSERT INTO `tiposcontratos` (`id`, `descripcion`, `titulo`, `clausulas`, `usuario_alta`, `fecha_alta`, `usuario_modi`, `fecha_modi`, `created_at`, `updated_at`) VALUES
(1, 'Contrato Mayores de Edad', 'CONTRATO DE SERVICIO EDUCATIVO', '<div style="text-align: justify;"><div style="line-height: 18.5714282989502px;"><span style="line-height: 2;">En Formosa Capital, a los {{CANTIDAD_DIAS}} días del mes de {{MES_TEXTO}} del año de {{ANIO}}; entre <span style="font-weight: bold;">EL INSTITUTO SUPERIOR DE SANIDAD “PROFESOR DOCTOR RAMON CARRILLO”,</span> representado en este acto por el <span style="font-weight: bold;">Señor Representante Legal Dr. OSCAR L. GOMEZ,</span> en adelante <span style="font-weight: bold;">EL INSTITUTO,</span> con domicilio en {{DOMICILIO_INSTITUCION}}, de la provincia de Formosa Capital del mismo nombre; y {{PRONOMBRE_PERSONA}} <span style="font-weight: bold;">{{ALUMNO}}; D.N.I. Nº: {{DNI_ALUMNO}}</span>; en calidad de Alumno en adelante <span style="font-weight: bold;">EL EDUCANDO,</span> con domicilio {{DOMICILIO_EDUCANDO}}; acuerdan en suscribir el presente <span style="font-style: italic; font-weight: bold;">Contrato de Servicio Educativo</span> que se regirá por las cláusulas que a continuación se detallan, a las cuales las partes se someten, obligándose <span style="font-weight: bold;">EL INSTITUTO</span> a notificar con treinta (30) días de anticipación la rescisión del presente Contrato Educativo, cualquiera fuera la causa. Debiendo suscribirse un nuevo Contrato para que el alumno continúe en el establecimiento más allá del Período Lectivo para el que hoy se contrata.</span></div><div style="line-height: 18.5714282989502px;"><span style="line-height: 2;"><br></span></div><div style="line-height: 18.5714282989502px;"><span style="line-height: 2;"><span style="font-weight: bold;">PRIMERO: EL INSTITUTO</span> se compromete a brindar enseñanza al alumno durante el presente Ciclo Lectivo {{CICLO_LECTIVO}}, en un todo de acuerdo a los planes de estudio oficiales que aplica el establecimiento o los que en el futuro dispusiere y fueran autorizados oficialmente a aplicar, y las demás actividades extracurriculares que <span style="font-weight: bold;">EL INSTITUTO</span> resuelva implementar.-</span></div><div style="line-height: 18.5714282989502px;"><span style="line-height: 2;"><br></span></div><div style="line-height: 18.5714282989502px;"><span style="line-height: 2;"><span style="font-weight: bold;">SEGUNDO: EL EDUCANDO</span> se adhiere al presente contrato en forma completa y se comprometen a cumplir todas las obligaciones establecidas en las reglamentaciones oficiales, en el Código de Convivencia, Reglamento Académico Interno y demás normas y disposiciones emanadas de la Representación Legal y de la Rectoría y Junta Evaluadora de la Institución que hacen a la buena convivencia y las sanas costumbres, así como al asistir cada vez que sea citado por <span style="font-weight: bold;">EL INSTITUTO.</span>- </span></div><div style="line-height: 18.5714282989502px;"><span style="line-height: 2;">Que de existir motivos graves de incumplimiento, por parte de <span style="font-weight: bold;">EL EDUCANDO</span> a los compromisos asumidos en el presente Convenio, serán motivos suficientes para que pueda ser separado del mismo, reservándose <span style="font-weight: bold;">EL INSTITUTO</span> el derecho de admisión y/o de no suscribir un nuevo convenio para el próximo Ciclo Lectivo. En este supuesto <span style="font-weight: bold;">EL EDUCANDO,</span> será notificado fehacientemente emitiéndose la documentación pertinente.-</span></div><div style="line-height: 18.5714282989502px;"><span style="line-height: 2;"><br></span></div><div style="line-height: 18.5714282989502px;"><span style="line-height: 2; font-weight: bold;">TERCERO:</span><span style="line-height: 2;"> En contraprestación del Servicio Educativo que recibirá </span><span style="line-height: 2; font-weight: bold;">EL EDUCANDO,</span><span style="line-height: 2;"> se comprometen a abonar a </span><span style="line-height: 2; font-weight: bold;">EL INSTITUTO,</span> <span style="line-height: 2;">un arancel la suma de</span> <span style="line-height: 2;"><span style="font-weight: bold;">{{ARANCEL_TOTAL_TEXTO}}</span> (<span style="font-weight: bold;">{{ARANCEL_TOTAL_NUMERO}}</span>)</span> <span style="line-height: 2;">dividido en {{CANTIDAD_CUOTAS_TEXTO}} ({{CANTIDAD_CUOTAS_NUMERO}}) cuotas mensuales, iguales y consecutivas, pagaderas por adelantado del uno al veinte de cada mes, depositado en la cuenta Bancaria del Banco Provincia de Formosa perteneciente a la Fundación del Hospital de Alta Complejidad Cuenta Corriente N°: 3019/5 CBU: 310000301000000301951; acompañando el comprobante de pago para su registro correspondiente a la administración del Instituto; con vencimiento la primera de ellas en el mes de {{MES_VENCIMIENTO_PRIMER_CUOTA}} del año {{ANIO_VENCIMIENTO_PRIMER_CUOTA}}, y según las modalidades y características que determina </span><span style="line-height: 2; font-weight: bold;">EL INSTITUTO.</span><span style="line-height: 2;"> Reservándose este, la facultad de incrementar unilateralmente el monto de las cuotas, con la sola condición de comunicarlo fehacientemente. Correspondiendo abonar asimismo como condición previa para el ingreso del alumno al periodo por el cual se suscribe el presente contrato a la Institución Educativa la suma de </span><span style="line-height: 2; font-weight: bold;">{{MATRICULA_IMPORTE_TEXTO}} ({{MATRICULA_IMPORTE_NUMERO}})</span><span style="line-height: 2;"> en concepto de </span><span style="line-height: 2; font-weight: bold;">MATRICULA DE </span><span style="font-weight: bold; line-height: 26px;">INSCRIPCION,</span><span style="line-height: 2;"> la cual no será reintegrada en ningún supuesto, ni aun por imposibilidad comprobada y/o desistimiento liso y llano de </span><span style="line-height: 2; font-weight: bold;">EL EDUCANDO,</span><span style="line-height: 2;"> de iniciar sus clases en el establecimiento; previéndose un nuevo abono de dicho concepto (Matricula de Inscripción) durante el presente año lectivo, solo en los supuestos de que se conceda la reincorporación del alumno, al perder este su condición de regular, como consecuencia de la aplicación del Reglamento Académico Interno.</span></div><div style="line-height: 18.5714282989502px;"><span style="line-height: 2;"><br></span></div><div style="line-height: 18.5714282989502px;"><span style="line-height: 2;"><span style="font-weight: bold;">CUARTO:</span> Se prevé que para los supuestos de atraso en el pago del arancel, la mora se producirá de pleno derecho, sin necesidad de interpelación judicial o extrajudicial alguna, quedando facultado <span style="font-weight: bold;">EL INSTITUTO,</span> a no computar asistencia en las materias del año en curso, como así también perderá el derecho a rendir exámenes parciales, recuperatorios y exámenes finales a <span style="font-weight: bold;">EL EDUCANDO.</span> Será requisito indispensable de matriculación no adeudar suma alguna de dinero a <span style="font-weight: bold;">EL INSTITUTO,</span> por ningún concepto, conviniendo libremente las partes que a los efectos del cobro de importes adeudados, devinientes del presente contrato, se otorgue a los mismos carácter de Titulo Ejecutivo a todos los efectos procesales en sede judicial.-</span></div><div style="line-height: 18.5714282989502px;"><span style="line-height: 2;"><br></span></div><div style="line-height: 18.5714282989502px;"><span style="line-height: 2;"><span style="font-weight: bold;">QUINTO: EL EDUCANDO</span> se compromete, a abonar en concepto de resarcimiento las sumas dinerarias que, a criterio del establecimiento, resulten pertinentes por todo daño que pudiere inferir de manera voluntaria, y/o por su culpa o negligencia; tanto a los bienes propios del establecimiento, como a la integridad psíquica o física de los miembros de la comunidad educativa, en su persona o pertenencias.-</span></div><div style="line-height: 18.5714282989502px;"><span style="line-height: 2;"><br></span></div><div style="line-height: 18.5714282989502px;"><span style="line-height: 2;"><span style="font-weight: bold;">SEXTO: EL INSTITUTO</span> habilitara los medios para garantizar el dictado de clases durante el ciclo lectivo, consecuentemente mantendrá el libre acceso a sus instalaciones para alumnos y personal docente. Liberando de responsabilidad <span style="font-weight: bold;">EL EDUCANDO</span> a <span style="font-weight: bold;">EL INSTITUTO</span> de las suspensiones o interrupciones de las actividades que se produjeren como consecuencia de medidas de fuerza o acción directa del personal, y caso fortuito o fuerza mayor.</span></div><div style="line-height: 18.5714282989502px;"><span style="line-height: 2;">A todos los efectos legales que pudiera producir el presente contrato, las partes fijan sus domicilios en los enunciados precedentemente, en donde serán válidas todas las notificaciones y diligencias que se practiquen. No pudiendo constituir las partes nuevos domicilios fuera de la Provincia de FORMOSA. Remitiéndose para cualquier controversia que pudiera surgir del presente a los Tribunales Ordinarios de la Provincia de FORMOSA, renunciando las partes en forma expresa al Fuero Federal u otro de excepción que les pudiera corresponder. Suscribiendo las partes de conformidad previa lectura del presente, en dos ejemplares a mismo efecto y tenor.-</span></div></div>', 'driquelme', '2015-05-05 03:00:00', NULL, NULL, '0000-00-00 00:00:00', '2015-05-18 14:15:32'),
(2, 'Contrato Menores de Edad', 'CONTRATO DE SERVICIO EDUCATIVO', '<div style="text-align: justify; line-height: 2;"><span style="line-height: 2;">En Formosa Capital, a los {{CANTIDAD_DIAS}} días del mes de {{MES_TEXTO}} del año de {{ANIO}}; entre <span style="font-weight: bold;">EL INSTITUTO SUPERIOR DE SANIDAD “PROFESOR  DOCTOR RAMON CARRILLO”,</span> representado en este acto por el <span style="font-weight: bold;">Señor Representante Legal Dr. OSCAR L. GOMEZ,</span> en adelante <span style="font-weight: bold;">EL INSTITUTO,</span> con domicilio en {{DOMICILIO_INSTITUCION}},</span> de la provincia de Formosa Capital del mismo nombre<span style="line-height: 2;">; y {{PRONOMBRE_PERSONA}} </span><span style="line-height: 2; font-weight: bold;">{{TUTOR}}; D.N.I. Nº: {{DNI_TUTOR}};</span><span style="line-height: 2;"> en  carácter de  </span><span style="line-height: 2; font-weight: bold;">TUTOR</span><span style="line-height: 2;"> del alumno menor </span><span style="line-height: 2; font-weight: bold;">{{ALUMNO}}; D.N.I. N° {{DNI_ALUMNO}};</span><span style="line-height: 2;"> en adelante </span><span style="line-height: 2; font-weight: bold;">EL EDUCANDO,</span><span style="line-height: 2;"> con domicilio en {{DOMICILIO_EDUCANDO}}; acuerdan en suscribir  el presente </span><span style="line-height: 2; font-style: italic; font-weight: bold;">Contrato de Servicio Educativo</span><span style="line-height: 2;"> que se regirá por las cláusulas que a continuación se detallan, a las cuales las partes se someten, obligándose </span><span style="line-height: 2; font-weight: bold;">EL INSTITUTO</span><span style="line-height: 2;">  a notificar con treinta (30) días de anticipación  la rescisión  del presente Contrato Educativo, cualquiera fuera la causa. Debiendo suscribirse un nuevo Contrato para que el alumno continúe en el establecimiento más allá del Período Lectivo para el que hoy se contrata.</span></div><div style="text-align: justify;"><span style="line-height: 1.42857143;"><br></span></div><div style="text-align: justify; line-height: 2;"><span style="font-weight: bold;">PRIMERO: EL INSTITUTO</span> se compromete a brindar enseñanza al alumno durante el presente Ciclo Lectivo {{CICLO_LECTIVO}}, en un todo de acuerdo a los planes de estudio oficiales que aplica el establecimiento o los que en el futuro dispusiere y fueran autorizados oficialmente a aplicar, y las demás actividades extracurriculares que <span style="font-weight: bold;">EL INSTITUTO</span> resuelva implementar.-</div><div><br></div><div style="text-align: justify; line-height: 2;"><span style="font-weight: bold;">SEGUNDO: EL EDUCANDO</span>  se adhiere  al presente contrato en forma completa y se comprometen a cumplir  todas las obligaciones establecidas  en las reglamentaciones oficiales, en el Código de Convivencia, Reglamento Académico Interno y demás normas y disposiciones emanadas de la Representación Legal y de la Rectoría y Junta Evaluadora de la Institución que hacen a la  buena convivencia y las sanas costumbres,  así como al asistir cada vez que sea citado por <span style="font-weight: bold;">EL INSTITUTO.-</span> </div><div style="text-align: justify; line-height: 2;">Que de existir  motivos graves de incumplimiento, por parte de <span style="font-weight: bold;">EL EDUCANDO</span> a los compromisos asumidos en el presente  Convenio, serán  motivos suficientes para que pueda  ser separado del mismo, reservándose <span style="font-weight: bold;">EL INSTITUTO</span> el derecho de admisión y/o de no suscribir un nuevo convenio para el próximo Ciclo Lectivo. En este supuesto <span style="font-weight: bold;">EL EDUCANDO,</span>  será  notificado fehacientemente emitiéndose la documentación pertinente.-</div><div><br></div><div style="text-align: justify; line-height: 2;"><span style="font-weight: bold;">TERCERO:</span> En contraprestación del Servicio Educativo que recibirá <span style="font-weight: bold;">EL EDUCANDO</span> se compromete a abonar a <span style="font-weight: bold;">EL INSTITUTO,</span> el Tutor en concepto de arancel la suma de <span style="font-weight: bold;">{{ARANCEL_TOTAL_TEXTO}}</span> <span style="font-weight: bold;">({{ARANCEL_TOTAL_NUMERO}})</span> dividido en {{CANTIDAD_CUOTAS_TEXTO}} ({{CANTIDAD_CUOTAS_NUMERO}})  cuotas mensuales, iguales  y  consecutivas, pagaderas por adelantado del uno al veinte de cada mes, depositando en la cuenta Bancaria del Banco Provincia de Formosa perteneciente a la Fundación del Hospital de Alta Complejidad Cuenta Corriente N°: 3019/5 CBU: 310000301000000301951; acompañando el comprobante de pago para su registro correspondiente a la administración del Instituto; con vencimiento la primera de ellas en el mes de {{MES_VENCIMIENTO_PRIMER_CUOTA}} del año {{ANIO_VENCIMIENTO_PRIMER_CUOTA}}, y según las modalidades y características que determina <span style="font-weight: bold;">EL INSTITUTO.</span> Reservándose este, la facultad  de incrementar unilateralmente el monto de las cuotas, con la sola condición de comunicarlo fehacientemente. Correspondiendo abonar asimismo como condición previa para el ingreso del alumno al periodo por el cual se suscribe el presente contrato a la Institución Educativa la suma de <span style="font-weight: bold;">{{MATRICULA_IMPORTE_TEXTO}} ({{MATRICULA_IMPORTE_NUMERO}})</span> en concepto de <span style="font-weight: bold;">MATRICULA DE INSCRIPCION,</span> la cual no será reintegrada en ningún supuesto, ni aun por imposibilidad comprobada y/o desistimiento liso y llano de <span style="font-weight: bold;">EL EDUCANDO,</span> de iniciar sus clases en el establecimiento; previéndose un nuevo abono de dicho concepto (Matricula de Inscripción) durante el presente año lectivo, solo en los supuestos de que se conceda la reincorporación del alumno, al perder este su condición de regular, como consecuencia de la aplicación del Reglamento Académico Interno.</div><div><br></div><div style="text-align: justify; line-height: 2;"><span style="font-weight: bold;">CUARTO:</span> Se prevé que para los supuestos de atraso en el pago del arancel, la mora se producirá de pleno derecho, sin necesidad de interpelación  judicial o extrajudicial alguna, quedando facultado <span style="font-weight: bold;">EL INSTITUTO,</span> a no computar asistencia en las materias del año en curso, como así también perderá el derecho a rendir exámenes parciales, recuperatorios y exámenes finales a <span style="font-weight: bold;">EL EDUCANDO.</span> Será requisito indispensable de matriculación no  adeudar suma alguna de dinero a <span style="font-weight: bold;">EL INSTITUTO,</span> por ningún concepto, conviniendo libremente las partes que a los efectos del cobro de importes adeudados, devinientes del presente contrato, se otorgue a los mismos carácter de Titulo Ejecutivo a todos los efectos procesales en sede judicial.-</div><div><br></div><div style="text-align: justify; line-height: 2;"><span style="font-weight: bold;">QUINTO: EL TUTOR</span> se compromete, a abonar en concepto de resarcimiento las sumas dinerarias que, a criterio del establecimiento, resulten pertinentes por todo daño que pudiere inferir de manera voluntaria, y/o por su culpa o negligencia; tanto a los bienes propios del establecimiento, como a la integridad psíquica o física de los  miembros de la comunidad educativa, en su persona o pertenencias.-</div><div><br></div><div style="text-align: justify; line-height: 2;"><span style="font-weight: bold;">SEXTO: EL INSTITUTO</span> habilitara los medios para garantizar el dictado de clases durante el ciclo lectivo, consecuentemente mantendrá el libre acceso a sus instalaciones para alumnos y personal docente. Liberando de responsabilidad <span style="font-weight: bold;">EL EDUCANDO</span> a          <span style="font-weight: bold;">EL INSTITUTO</span> de las suspensiones o interrupciones de las actividades que se produjeren como consecuencia de medidas de fuerza o acción directa del personal, y caso fortuito o fuerza mayor.</div><div style="text-align: justify; line-height: 2;">A todos los efectos legales que pudiera producir el presente contrato, las partes fijan sus domicilios en los enunciados precedentemente, en donde serán válidas todas las notificaciones y diligencias que se practiquen. No pudiendo constituir las partes nuevos domicilios fuera de la Provincia  de FORMOSA. Remitiéndose  para cualquier controversia que pudiera surgir del presente a los Tribunales Ordinarios de la Provincia  de FORMOSA, renunciando las partes en forma expresa al Fuero Federal u otro de excepción que les pudiera corresponder. Suscribiendo las partes de conformidad previa lectura del presente, en dos ejemplares a mismo efecto y tenor.-														</div>', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '2015-05-12 13:33:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiposduraciones`
--

CREATE TABLE IF NOT EXISTS `tiposduraciones` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `tiposduraciones`
--

INSERT INTO `tiposduraciones` (`id`, `descripcion`, `usuario_alta`, `fecha_alta`, `usuario_modi`, `fecha_modi`, `created_at`, `updated_at`) VALUES
(1, 'Dias', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Meses', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Años', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Disparadores `tiposduraciones`
--
DROP TRIGGER IF EXISTS `tr_tiposduraciones_baja_log`;
DELIMITER //
CREATE TRIGGER `tr_tiposduraciones_baja_log` AFTER DELETE ON `tiposduraciones`
 FOR EACH ROW insert into aud_tiposducariones_log (id,descripcion,usuario,fecha,baja)
values (OLD.id,OLD.descripcion,OLD.usuario_modi,NOW(), 1)
//
DELIMITER ;
DROP TRIGGER IF EXISTS `tr_tiposduraciones_modi_log`;
DELIMITER //
CREATE TRIGGER `tr_tiposduraciones_modi_log` AFTER UPDATE ON `tiposduraciones`
 FOR EACH ROW insert into aud_tiposducariones_log (id,descripcion,usuario,fecha,modi)
values (OLD.id,OLD.descripcion,NEW.usuario_modi,NOW(), 1)
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tituloshabilitantes`
--

CREATE TABLE IF NOT EXISTS `tituloshabilitantes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `tituloshabilitantes`
--

INSERT INTO `tituloshabilitantes` (`id`, `descripcion`, `usuario_alta`, `fecha_alta`, `usuario_modi`, `fecha_modi`, `created_at`, `updated_at`) VALUES
(1, 'Profesor de Ingles', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Lic. en Enfermería Universitaria', 'admin', '2015-03-18 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Analista en Sistema', 'admin', '2015-03-18 00:00:00', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Disparadores `tituloshabilitantes`
--
DROP TRIGGER IF EXISTS `tr_tituloshabilitantes_baja_log`;
DELIMITER //
CREATE TRIGGER `tr_tituloshabilitantes_baja_log` AFTER DELETE ON `tituloshabilitantes`
 FOR EACH ROW insert into aud_tituloshabilitantes_log (id,descripcion,usuario,fecha,baja)
values (OLD.id,OLD.descripcion, OLD.usuario_modi,NOW(), 1)
//
DELIMITER ;
DROP TRIGGER IF EXISTS `tr_tituloshabilitantes_modi_log`;
DELIMITER //
CREATE TRIGGER `tr_tituloshabilitantes_modi_log` AFTER UPDATE ON `tituloshabilitantes`
 FOR EACH ROW insert into aud_tituloshabilitantes_log (id,descripcion,usuario,fecha,modi)
values (OLD.id,OLD.descripcion, NEW.usuario_modi,NOW(), 1)
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `titulosotorgados`
--

CREATE TABLE IF NOT EXISTS `titulosotorgados` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `titulosotorgados`
--

INSERT INTO `titulosotorgados` (`id`, `descripcion`, `usuario_alta`, `fecha_alta`, `usuario_modi`, `fecha_modi`, `created_at`, `updated_at`) VALUES
(1, 'Técnico Superior en Hemoterapia', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Técnico Superior en Instrumentación Quirúrgica', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Técnico Superior en Salud Materno Infantil', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'Técnico Superior en Emergencias y Desastres', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usuario` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usuario_alta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT NULL,
  `usuario_modi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_modi` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tipodocumento_id` int(10) unsigned DEFAULT NULL,
  `nrodocumento` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `persona_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `users_tipodocumento_id_foreign` (`tipodocumento_id`),
  KEY `users_persona_id_foreign` (`persona_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=30 ;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `usuario`, `password`, `usuario_alta`, `fecha_alta`, `usuario_modi`, `fecha_modi`, `created_at`, `updated_at`, `tipodocumento_id`, `nrodocumento`, `email`, `activo`, `remember_token`, `persona_id`) VALUES
(5, 'admin', '$2y$10$AThBKB9hNFO6yzi1P2EmoOgxTPlhNlwyOKDjFoYQ1t7/szgOFEWci', NULL, NULL, 'admin', '2015-04-01 00:00:00', '2015-02-10 11:26:32', '2015-12-04 15:00:46', NULL, '123456789', 'admin@admin.com', 1, 'EnWXPfPukSxLR2u9G5i4DdoEaqATrtTX7ODXay5Z9Y2jlDkentlqFPAZn7b7', 25),
(20, 'bsegovia', '$2y$10$jib3DNrjA8uikFpu79HdRevEvZeRGtLotlQvB4vJ4UaiWvJxrnGey', 'admin', '2015-03-17 00:00:00', 'admin', '2015-06-01 00:00:00', '2015-03-17 14:43:37', '2015-06-01 12:15:10', NULL, '31691957', '', 1, 'iTmtJoQtVcdFiuxVjPlluP8DisuOX4C3uBg3tJ54HOUVNKdZ70ar23HgVHTE', 69),
(21, 'dacosta', '$2y$10$0tnB1JiVoVfZ3l10B6TKQe5.ir2foWzkxIf817b5UPFPynRz9mFKW', 'admin', '2015-03-25 00:00:00', 'bsegovia', '2015-04-01 00:00:00', '2015-03-25 13:05:33', '2015-04-01 16:56:33', NULL, '12345678', 'david-acosta@issformosa.edu.ar', 1, 'JxZ0boZMh2pqAngxCMkBFynFWTD1Dwmpko7jjBIViGEJHStDJpa8xofneOPf', 76),
(22, 'cdorrego', '$2y$10$jIh18UzfOJpy4.0jTLB.VuczFuVdpQU5zrx9nFB3ETfjaW5zravUC', 'admin', '2015-03-25 00:00:00', 'bsegovia', '2015-04-01 00:00:00', '2015-03-25 13:20:38', '2015-04-16 14:57:05', NULL, '25889620', 'claudia-dorrego@issformosa.edu.ar', 1, 'dlNOwxKhL17WjQ7mKhxXqY0dYksxKV4SMij6koeq8qx9xOvGKtAAXbXaYoMh', 77),
(23, 'tbrizuela', '$2y$10$fcaKSyPyBXnYD9IMM6Y29eaLgJlQLlAnEZ1npqEWB0UgLUhr0pMB2', 'admin', '2015-03-25 00:00:00', 'bsegovia', '2015-04-01 00:00:00', '2015-03-25 13:22:12', '2015-04-01 22:27:45', NULL, '23269996', 'tery-brizuela@issformosa.edu.ar', 1, 'XZaGUv7gd7GLDorlyRupkOC8JjsOL50T2hqqZOpXOVNcNNJjnPt9aK3LbOwa', 78),
(24, 'dgomez', '$2y$10$HI2S7/RGVyeMz0iDoxM6deTqozCWhE91.IcG4JPik7Ohh/Ag4.7/i', 'admin', '2015-03-25 00:00:00', NULL, NULL, '2015-03-25 13:24:32', '2015-03-25 13:24:32', NULL, '27576558', '', 1, NULL, 79),
(25, 'hdasso', '$2y$10$uId2/pz0YHUz0eeA9wUT0.wr.MSf8r8C814y24C3r/QFU5XmsmAiK', 'admin', '2015-03-25 00:00:00', 'bsegovia', '2015-04-01 00:00:00', '2015-03-25 13:25:09', '2015-04-16 14:56:24', NULL, '1245678', 'hugo-dasso@issformosa.edu.ar', 1, '9Yop6zmIcqT2ZQiRGre5wiUzcsmgVywDwbxXSnWa7ZMsB8zcCOxUMuxGjunU', 80),
(26, 'alovera', '$2y$10$9nGb84gRIR1vc4ry4NbfcOXU/3txi90DJobGM38svA5gUY2C6mICK', 'admin', '2015-03-25 00:00:00', NULL, NULL, '2015-03-25 13:31:06', '2015-03-31 17:05:43', NULL, '1234567', '', 1, 'pIo7N5X1qgKwXyAUMJjP9nDZ9q166MruEmEMWK9v5WtgCVueNNzgptwjqPru', 81),
(27, 'mcandia', '$2y$10$5E3rqQluWsyqg2aY6FsOA.D4y1qw460tw2PKG1kTWkf.aJCT0TF4e', 'admin', '2015-03-25 00:00:00', 'bsegovia', '2015-04-01 00:00:00', '2015-03-25 13:31:41', '2015-04-01 14:12:25', NULL, '17560453', '', 1, '2AgVCqFz9TLohDMBsmnztCFapKKEMTLwLYfnyCZLBTQu8Npv2HvR7iHo9zJP', 82),
(28, 'farrua', '$2y$10$OA3Q5VNdTdyfcx74Lg.KTuqtbWgvgbqmrA9hAsrSrmVqWQFY90lEi', 'admin', '2015-03-25 00:00:00', 'admin', '2015-05-22 00:00:00', '2015-03-25 13:34:06', '2015-05-22 13:52:43', NULL, '38191394', 'fernanda-arrua@issformosa.edu.ar', 1, 'eZdqPOTg52wefQdwL9kUgZxkAFNRzLsPmuvuqWPZARaAdPyMeHCvXXHnWLox', 83),
(29, 'mavila', '$2y$10$7pZUox4v3xuvUasFZOdnZ.bInIrIYs3uN6nOlev/xrN07r43Qrr2G', 'admin', '2015-09-15 00:00:00', NULL, NULL, '2015-09-15 17:41:32', '2015-09-15 17:41:32', NULL, '33456282', 'manudva22@gmail.com', 1, NULL, 117);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD CONSTRAINT `alumnos_persona_id_foreign` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`);

--
-- Filtros para la tabla `alumnosfamiliares`
--
ALTER TABLE `alumnosfamiliares`
  ADD CONSTRAINT `alumnosfamiliares_alumno_id_foreign` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`),
  ADD CONSTRAINT `alumnosfamiliares_ocupacion_id_foreign` FOREIGN KEY (`ocupacion_id`) REFERENCES `ocupaciones` (`id`),
  ADD CONSTRAINT `alumnosfamiliares_persona_id_foreign` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`),
  ADD CONSTRAINT `alumnosfamiliares_relacionfamiliar_id_foreign` FOREIGN KEY (`relacionfamiliar_id`) REFERENCES `relacionesfamiliares` (`id`);

--
-- Filtros para la tabla `alumnoslegajos`
--
ALTER TABLE `alumnoslegajos`
  ADD CONSTRAINT `alumnoslegajos_alumno_id_foreign` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`);

--
-- Filtros para la tabla `alumnoslegajosdocumentos`
--
ALTER TABLE `alumnoslegajosdocumentos`
  ADD CONSTRAINT `alumnoslegajosdocumentos_alumnolegajo_id_foreign` FOREIGN KEY (`alumnolegajo_id`) REFERENCES `alumnoslegajos` (`id`);

--
-- Filtros para la tabla `alumno_carrera`
--
ALTER TABLE `alumno_carrera`
  ADD CONSTRAINT `alumno_carrera_alumno_id_foreign` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`),
  ADD CONSTRAINT `alumno_carrera_carrera_id_foreign` FOREIGN KEY (`carrera_id`) REFERENCES `carreras` (`id`),
  ADD CONSTRAINT `alumno_carrera_ciclolectivo_id_foreign` FOREIGN KEY (`ciclolectivo_id`) REFERENCES `cicloslectivos` (`id`);

--
-- Filtros para la tabla `barrios`
--
ALTER TABLE `barrios`
  ADD CONSTRAINT `barrios_localidad_id_foreign` FOREIGN KEY (`localidad_id`) REFERENCES `localidades` (`id`);

--
-- Filtros para la tabla `becas`
--
ALTER TABLE `becas`
  ADD CONSTRAINT `becas_alumno_id_foreign` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`),
  ADD CONSTRAINT `becas_carrera_id_foreign` FOREIGN KEY (`carrera_id`) REFERENCES `carreras` (`id`),
  ADD CONSTRAINT `becas_ciclolectivo_id_foreign` FOREIGN KEY (`ciclolectivo_id`) REFERENCES `cicloslectivos` (`id`),
  ADD CONSTRAINT `becas_inscripcion_id_foreign` FOREIGN KEY (`inscripcion_id`) REFERENCES `alumno_carrera` (`id`);

--
-- Filtros para la tabla `carreras`
--
ALTER TABLE `carreras`
  ADD CONSTRAINT `carreras_areaocupacional_id_foreign` FOREIGN KEY (`areaocupacional_id`) REFERENCES `areasocupacionales` (`id`),
  ADD CONSTRAINT `carreras_carreranivel_id_foreign` FOREIGN KEY (`carreranivel_id`) REFERENCES `carrerasniveles` (`id`),
  ADD CONSTRAINT `carreras_modalidad_id_foreign` FOREIGN KEY (`modalidad_id`) REFERENCES `modalidades` (`id`),
  ADD CONSTRAINT `carreras_organizacion_id_foreign` FOREIGN KEY (`organizacion_id`) REFERENCES `organizaciones` (`id`),
  ADD CONSTRAINT `carreras_regimen_id_foreign` FOREIGN KEY (`regimen_id`) REFERENCES `regimenes` (`id`),
  ADD CONSTRAINT `carreras_tipocarrera_id_foreign` FOREIGN KEY (`tipocarrera_id`) REFERENCES `tiposcarreras` (`id`),
  ADD CONSTRAINT `carreras_tipoduracion_id_foreign` FOREIGN KEY (`tipoduracion_id`) REFERENCES `tiposduraciones` (`id`),
  ADD CONSTRAINT `carreras_titulootorgado_id_foreign` FOREIGN KEY (`titulootorgado_id`) REFERENCES `titulosotorgados` (`id`);

--
-- Filtros para la tabla `cicloslectivos`
--
ALTER TABLE `cicloslectivos`
  ADD CONSTRAINT `cicloslectivos_organizacion_id_foreign` FOREIGN KEY (`organizacion_id`) REFERENCES `organizaciones` (`id`);

--
-- Filtros para la tabla `ContactoPersonas`
--
ALTER TABLE `ContactoPersonas`
  ADD CONSTRAINT `contactopersonas_contacto_id_foreign` FOREIGN KEY (`contacto_id`) REFERENCES `contactos` (`id`),
  ADD CONSTRAINT `contactopersonas_persona_id_foreign` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`);

--
-- Filtros para la tabla `contacto_organizacion`
--
ALTER TABLE `contacto_organizacion`
  ADD CONSTRAINT `contacto_organizacion_contacto_id_foreign` FOREIGN KEY (`contacto_id`) REFERENCES `contactos` (`id`),
  ADD CONSTRAINT `contacto_organizacion_organizacion_id_foreign` FOREIGN KEY (`organizacion_id`) REFERENCES `organizaciones` (`id`);

--
-- Filtros para la tabla `contacto_organizaciones`
--
ALTER TABLE `contacto_organizaciones`
  ADD CONSTRAINT `contacto_organizaciones_contacto_id_foreign` FOREIGN KEY (`contacto_id`) REFERENCES `contactos` (`id`),
  ADD CONSTRAINT `contacto_organizaciones_organizacion_id_foreign` FOREIGN KEY (`organizacion_id`) REFERENCES `organizaciones` (`id`);

--
-- Filtros para la tabla `contacto_persona`
--
ALTER TABLE `contacto_persona`
  ADD CONSTRAINT `contacto_persona_contacto_id_foreign` FOREIGN KEY (`contacto_id`) REFERENCES `contactos` (`id`),
  ADD CONSTRAINT `contacto_persona_persona_id_foreign` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`);

--
-- Filtros para la tabla `contratos`
--
ALTER TABLE `contratos`
  ADD CONSTRAINT `contratos_alumno_id_foreign` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`),
  ADD CONSTRAINT `contratos_carrera_id_foreign` FOREIGN KEY (`carrera_id`) REFERENCES `carreras` (`id`),
  ADD CONSTRAINT `contratos_ciclolectivo_id_foreign` FOREIGN KEY (`ciclolectivo_id`) REFERENCES `cicloslectivos` (`id`),
  ADD CONSTRAINT `contratos_organizacion_id_foreign` FOREIGN KEY (`organizacion_id`) REFERENCES `organizaciones` (`id`),
  ADD CONSTRAINT `contratos_tipocontrato_id_foreign` FOREIGN KEY (`tipocontrato_id`) REFERENCES `tiposcontratos` (`id`);

--
-- Filtros para la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD CONSTRAINT `departamentos_provincia_id_foreign` FOREIGN KEY (`provincia_id`) REFERENCES `provincias` (`id`);

--
-- Filtros para la tabla `detallesmatriculaspagos`
--
ALTER TABLE `detallesmatriculaspagos`
  ADD CONSTRAINT `detallesmatriculaspagos_alumno_id_foreign` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`),
  ADD CONSTRAINT `detallesmatriculaspagos_inscripcion_id_foreign` FOREIGN KEY (`inscripcion_id`) REFERENCES `alumno_carrera` (`id`),
  ADD CONSTRAINT `detallesmatriculaspagos_matricula_id_foreign` FOREIGN KEY (`matricula_id`) REFERENCES `matriculas` (`id`);

--
-- Filtros para la tabla `docentes`
--
ALTER TABLE `docentes`
  ADD CONSTRAINT `docentes_organismohabilitante_id_foreign` FOREIGN KEY (`organismohabilitante_id`) REFERENCES `organismoshabilitantes` (`id`),
  ADD CONSTRAINT `docentes_persona_id_foreign` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`),
  ADD CONSTRAINT `docentes_titulohabilitante_id_foreign` FOREIGN KEY (`titulohabilitante_id`) REFERENCES `tituloshabilitantes` (`id`);

--
-- Filtros para la tabla `inscripcionesfinales`
--
ALTER TABLE `inscripcionesfinales`
  ADD CONSTRAINT `inscripcionesfinales_alumno_id_foreign` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`),
  ADD CONSTRAINT `inscripcionesfinales_docente_id_foreign` FOREIGN KEY (`docente_id`) REFERENCES `docentes` (`id`),
  ADD CONSTRAINT `inscripcionesfinales_materia_id_foreign` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`),
  ADD CONSTRAINT `inscripcionesfinales_planestudio_id_foreign` FOREIGN KEY (`planestudio_id`) REFERENCES `planesestudios` (`id`);

--
-- Filtros para la tabla `inscripcionesmaterias`
--
ALTER TABLE `inscripcionesmaterias`
  ADD CONSTRAINT `inscripcionesmaterias_alumno_id_foreign` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`),
  ADD CONSTRAINT `inscripcionesmaterias_materia_id_foreign` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`),
  ADD CONSTRAINT `inscripcionesmaterias_planestudio_id_foreign` FOREIGN KEY (`planestudio_id`) REFERENCES `planesestudios` (`id`);

--
-- Filtros para la tabla `localidades`
--
ALTER TABLE `localidades`
  ADD CONSTRAINT `localidades_departamento_id_foreign` FOREIGN KEY (`departamento_id`) REFERENCES `departamentos` (`id`);

--
-- Filtros para la tabla `materias`
--
ALTER TABLE `materias`
  ADD CONSTRAINT `materias_carrera_id_foreign` FOREIGN KEY (`carrera_id`) REFERENCES `carreras` (`id`),
  ADD CONSTRAINT `materias_planestudio_id_foreign` FOREIGN KEY (`planestudio_id`) REFERENCES `planesestudios` (`id`);

--
-- Filtros para la tabla `matriculas`
--
ALTER TABLE `matriculas`
  ADD CONSTRAINT `matriculas_carrera_id_foreign` FOREIGN KEY (`carrera_id`) REFERENCES `carreras` (`id`),
  ADD CONSTRAINT `matriculas_ciclolectivo_id_foreign` FOREIGN KEY (`ciclolectivo_id`) REFERENCES `cicloslectivos` (`id`),
  ADD CONSTRAINT `matriculas_organizacion_id_foreign` FOREIGN KEY (`organizacion_id`) REFERENCES `organizaciones` (`id`);

--
-- Filtros para la tabla `modulo_perfil`
--
ALTER TABLE `modulo_perfil`
  ADD CONSTRAINT `modulo_perfil_modulo_id_foreign` FOREIGN KEY (`modulo_id`) REFERENCES `modulos` (`id`),
  ADD CONSTRAINT `modulo_perfil_perfil_id_foreign` FOREIGN KEY (`perfil_id`) REFERENCES `perfiles` (`id`);

--
-- Filtros para la tabla `organizaciones`
--
ALTER TABLE `organizaciones`
  ADD CONSTRAINT `organizaciones_barrio_id_foreign` FOREIGN KEY (`barrio_id`) REFERENCES `barrios` (`id`),
  ADD CONSTRAINT `organizaciones_departamento_id_foreign` FOREIGN KEY (`departamento_id`) REFERENCES `departamentos` (`id`),
  ADD CONSTRAINT `organizaciones_localidad_id_foreign` FOREIGN KEY (`localidad_id`) REFERENCES `localidades` (`id`),
  ADD CONSTRAINT `organizaciones_nivel_educativo_id_foreign` FOREIGN KEY (`nivel_Educativo_id`) REFERENCES `niveles_educativos` (`id`),
  ADD CONSTRAINT `organizaciones_pais_id_foreign` FOREIGN KEY (`pais_id`) REFERENCES `paises` (`id`),
  ADD CONSTRAINT `organizaciones_provincia_id_foreign` FOREIGN KEY (`provincia_id`) REFERENCES `provincias` (`id`);

--
-- Filtros para la tabla `organizacion_user`
--
ALTER TABLE `organizacion_user`
  ADD CONSTRAINT `organizacion_user_organizacion_id_foreign` FOREIGN KEY (`organizacion_id`) REFERENCES `organizaciones` (`id`),
  ADD CONSTRAINT `organizacion_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `perfiles`
--
ALTER TABLE `perfiles`
  ADD CONSTRAINT `perfiles_organizacion_id_foreign` FOREIGN KEY (`organizacion_id`) REFERENCES `organizaciones` (`id`);

--
-- Filtros para la tabla `perfil_user`
--
ALTER TABLE `perfil_user`
  ADD CONSTRAINT `perfil_user_perfil_id_foreign` FOREIGN KEY (`perfil_id`) REFERENCES `perfiles` (`id`),
  ADD CONSTRAINT `perfil_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `periodoslectivos`
--
ALTER TABLE `periodoslectivos`
  ADD CONSTRAINT `periodoslectivos_ciclolectivo_id_foreign` FOREIGN KEY (`ciclolectivo_id`) REFERENCES `cicloslectivos` (`id`);

--
-- Filtros para la tabla `personas`
--
ALTER TABLE `personas`
  ADD CONSTRAINT `personas_barrio_id_foreign` FOREIGN KEY (`barrio_id`) REFERENCES `barrios` (`id`),
  ADD CONSTRAINT `personas_departamento_id_foreign` FOREIGN KEY (`departamento_id`) REFERENCES `departamentos` (`id`),
  ADD CONSTRAINT `personas_estadocivil_id_foreign` FOREIGN KEY (`estadocivil_id`) REFERENCES `estadosciviles` (`id`),
  ADD CONSTRAINT `personas_localidad_id_foreign` FOREIGN KEY (`localidad_id`) REFERENCES `localidades` (`id`),
  ADD CONSTRAINT `personas_lugarnacimiento_id_foreign` FOREIGN KEY (`lugarnacimiento_id`) REFERENCES `paises` (`id`),
  ADD CONSTRAINT `personas_pais_id_foreign` FOREIGN KEY (`pais_id`) REFERENCES `paises` (`id`),
  ADD CONSTRAINT `personas_provincia_id_foreign` FOREIGN KEY (`provincia_id`) REFERENCES `provincias` (`id`),
  ADD CONSTRAINT `personas_tipodocumento_id_foreign` FOREIGN KEY (`tipodocumento_id`) REFERENCES `tipodocumentos` (`id`);

--
-- Filtros para la tabla `planesestudios`
--
ALTER TABLE `planesestudios`
  ADD CONSTRAINT `planesestudios_carrera_id_foreign` FOREIGN KEY (`carrera_id`) REFERENCES `carreras` (`id`),
  ADD CONSTRAINT `planesestudios_ciclolectivo_id_foreign` FOREIGN KEY (`ciclolectivo_id`) REFERENCES `cicloslectivos` (`id`);

--
-- Filtros para la tabla `provincias`
--
ALTER TABLE `provincias`
  ADD CONSTRAINT `provincias_pais_id_foreign` FOREIGN KEY (`pais_id`) REFERENCES `paises` (`id`);

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_persona_id_foreign` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`),
  ADD CONSTRAINT `users_tipodocumento_id_foreign` FOREIGN KEY (`tipodocumento_id`) REFERENCES `tipodocumentos` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
