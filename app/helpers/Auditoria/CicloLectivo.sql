/*TABLA Y TRIGGERS PARA TIPO ORGANISMOS CICLOS LECTIVOS*/

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

  /*update*/
CREATE TRIGGER `tr_cicloslectivos_modi_log` AFTER UPDATE ON `cicloslectivos`
FOR EACH ROW insert into aud_cicloslectivos_log (id,organizacion_id,descripcion,fechainicio,fechafin,activo,usuario,fecha,modi)
values (OLD.id,OLD.organizacion_id,OLD.descripcion,OLD.fechainicio,OLD.fechafin,OLD.activo,NEW.usuario_modi,NOW(), 1);

  /*delete*/
CREATE TRIGGER `tr_cicloslectivos_baja_log` AFTER DELETE ON `cicloslectivos`
FOR EACH ROW insert into aud_cicloslectivos_log (id,organizacion_id,descripcion,fechainicio,fechafin,activo,usuario,fecha,baja)
values (OLD.id,OLD.organizacion_id,OLD.descripcion,OLD.fechainicio,OLD.fechafin,OLD.activo,OLD.usuario_modi,NOW(), 1);



/*TABLA Y TRIGGERS PARA TIPO ORGANISMOS PERIODOS LECTIVOS*/

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

  /*update*/
CREATE TRIGGER `tr_periodoslectivos_modi_log` AFTER UPDATE ON `periodoslectivos`
FOR EACH ROW insert into aud_periodoslectivos_log (id,ciclolectivo_id,descripcion,fechainicio,fechafin,usuario,fecha,modi)
values (OLD.id,OLD.ciclolectivo_id,OLD.descripcion,OLD.fechainicio,OLD.fechafin,NEW.usuario_modi,NOW(), 1);

  /*delete*/
CREATE TRIGGER `tr_periodoslectivos_baja_log` AFTER DELETE ON `periodoslectivos`
FOR EACH ROW insert into aud_periodoslectivos_log (id,ciclolectivo_id,descripcion,fechainicio,fechafin,usuario,fecha,baja)
values (OLD.id,OLD.ciclolectivo_id,OLD.descripcion,OLD.fechainicio,OLD.fechafin,OLD.usuario_modi,NOW(), 1);



