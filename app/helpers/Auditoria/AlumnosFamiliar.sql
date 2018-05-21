/*TABLA Y TRIGGERS PARA RELACIONES FAMILIARES*/
CREATE TABLE IF NOT EXISTS `aud_relacionesfamiliares_log` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;  

  /*update*/
CREATE TRIGGER `tr_relacionesfamiliares_modi_log` AFTER UPDATE ON `relacionesfamiliares`
FOR EACH ROW insert into aud_relacionesfamiliares_log (id,descripcion,usuario,fecha,modi)
values (OLD.id,OLD.descripcion, NEW.usuario_modi,NOW(), 1);

  /*delete*/
CREATE TRIGGER `tr_relacionesfamiliares_baja_log` AFTER DELETE ON `relacionesfamiliares`
FOR EACH ROW insert into aud_relacionesfamiliares_log (id,descripcion,usuario,fecha,baja)
values (OLD.id,OLD.descripcion, OLD.usuario_modi,NOW(), 1);





/*TABLA Y TRIGGERS PARA OCUPACIONES*/
CREATE TABLE IF NOT EXISTS `aud_ocupaciones_log` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;  

  /*update*/
CREATE TRIGGER `tr_ocupaciones_modi_log` AFTER UPDATE ON `ocupaciones`
FOR EACH ROW insert into aud_ocupaciones_log (id,descripcion,usuario,fecha,modi)
values (OLD.id,OLD.descripcion, NEW.usuario_modi,NOW(), 1);

  /*delete*/
CREATE TRIGGER `tr_ocupaciones_baja_log` AFTER DELETE ON `ocupaciones`
FOR EACH ROW insert into aud_ocupaciones_log (id,descripcion,usuario,fecha,baja)
values (OLD.id,OLD.descripcion, OLD.usuario_modi,NOW(), 1);




/*TABLA Y TRIGGERS PARA ALUMNOS FAMILIARES*/
CREATE TABLE IF NOT EXISTS `aud_alumnosfamiliares_log` (
  `id` int(10) NOT NULL,
  `persona_id` int(10) NULL,
  `alumno_id` int(10) NULL,
  `relacionfamiliar_id` int(10) NULL,
  `responsable` tinyint(1) DEFAULT NULL,
  `ocupacion_id` int(10) NULL,
  `lugartrabajoestudio` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `enfermedaddiscapacidad` tinyint(1) DEFAULT NULL,
  `enfermedaddiscapacidaddetalle` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;  

  /*update*/
CREATE TRIGGER `tr_alumnosfamiliares_modi_log` AFTER UPDATE ON `alumnosfamiliares`
FOR EACH ROW insert into aud_alumnosfamiliares_log (id,persona_id,alumno_id,relacionfamiliar_id,responsable,ocupacion_id,lugartrabajoestudio,enfermedaddiscapacidad,enfermedaddiscapacidaddetalle,usuario,fecha,modi)
values (OLD.id,Old.persona_id,Old.alumno_id,Old.relacionfamiliar_id,Old.responsable,Old.ocupacion_id,Old.lugartrabajoestudio,Old.enfermedaddiscapacidad,Old.enfermedaddiscapacidaddetalle,NEW.usuario_modi,NOW(), 1);

  /*delete*/
CREATE TRIGGER `tr_alumnosfamiliares_baja_log` AFTER DELETE ON `alumnosfamiliares`
FOR EACH ROW insert into aud_alumnosfamiliares_log (id,persona_id,alumno_id,relacionfamiliar_id,responsable,ocupacion_id,lugartrabajoestudio,enfermedaddiscapacidad,enfermedaddiscapacidaddetalle,usuario,fecha,baja)
values (OLD.id,Old.persona_id,Old.alumno_id,Old.relacionfamiliar_id,Old.responsable,Old.ocupacion_id,Old.lugartrabajoestudio,Old.enfermedaddiscapacidad,Old.enfermedaddiscapacidaddetalle, OLD.usuario_modi,NOW(), 1);





