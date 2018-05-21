/*TABLA Y TRIGGERS PARA DOCENTES*/
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
  `organismohabilitante_id` int(11) NOT NULL,
  `nrolegajohabilitante` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

 

    /*update*/
CREATE TRIGGER `tr_docentes_modi_log` AFTER UPDATE ON `docentes`
FOR EACH ROW insert into aud_docentes_log (id,persona_id,nrolegajo,foto,activo,empleado,disertante,fechaingreso,fechaegreso,titulohabilitante_id,organismohabilitante_id,nrolegajohabilitante,usuario,fecha,modi)
values (OLD.id,OLD.persona_id,OLD.nrolegajo,OLD.foto,OLD.activo,OLD.empleado,OLD.disertante,OLD.fechaingreso,OLD.fechaegreso,OLD.titulohabilitante_id,OLD.organismohabilitante_id,OLD.nrolegajohabilitante, NEW.usuario_modi,NOW(), 1);  

    /*delete*/
CREATE TRIGGER `tr_docentes_baja_log` AFTER DELETE ON `docentes`
 FOR EACH ROW insert into aud_docentes_log (id,persona_id,nrolegajo,foto,activo,empleado,disertante,fechaingreso,fechaegreso,titulohabilitante_id,organismohabilitante_id,nrolegajohabilitante,usuario,fecha,baja)
values (OLD.id,OLD.persona_id,OLD.nrolegajo,OLD.foto,OLD.activo,OLD.empleado,OLD.disertante,OLD.fechaingreso,OLD.fechaegreso,OLD.titulohabilitante_id,OLD.organismohabilitante_id,OLD.nrolegajohabilitante, OLD.usuario_modi,NOW(), 1);  





 /*TABLA Y TRIGGERS PARA TIPO ORGANISMOS HABILITANTES*/

CREATE TABLE IF NOT EXISTS `aud_organismoshabilitantes_log` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;  

  /*update*/
CREATE TRIGGER `tr_organismoshabilitantes_modi_log` AFTER UPDATE ON `organismoshabilitantes`
FOR EACH ROW insert into aud_organismoshabilitantes_log (id,descripcion,usuario,fecha,modi)
values (OLD.id,OLD.descripcion, NEW.usuario_modi,NOW(), 1);

  /*delete*/
CREATE TRIGGER `tr_organismoshabilitantes_baja_log` AFTER DELETE ON `organismoshabilitantes`
FOR EACH ROW insert into aud_organismoshabilitantes_log (id,descripcion,usuario,fecha,baja)
values (OLD.id,OLD.descripcion, OLD.usuario_modi,NOW(), 1);



 /*TABLA Y TRIGGERS PARA TIPO ORGANISMOS HABILITANTES*/

CREATE TABLE IF NOT EXISTS `aud_tituloshabilitantes_log` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;  

  /*update*/
CREATE TRIGGER `tr_tituloshabilitantes_modi_log` AFTER UPDATE ON `tituloshabilitantes`
FOR EACH ROW insert into aud_tituloshabilitantes_log (id,descripcion,usuario,fecha,modi)
values (OLD.id,OLD.descripcion, NEW.usuario_modi,NOW(), 1);

  /*delete*/
CREATE TRIGGER `tr_tituloshabilitantes_baja_log` AFTER DELETE ON `tituloshabilitantes`
FOR EACH ROW insert into aud_tituloshabilitantes_log (id,descripcion,usuario,fecha,baja)
values (OLD.id,OLD.descripcion, OLD.usuario_modi,NOW(), 1);
