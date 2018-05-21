/*TABLA Y TRIGGERS PARA TIPOS CARRERAS*/

CREATE TABLE IF NOT EXISTS `aud_tiposcarreras_log` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;  

  /*update*/
CREATE TRIGGER `tr_tiposcarreras_modi_log` AFTER UPDATE ON `tiposcarreras`
FOR EACH ROW insert into aud_tiposcarreras_log (id,descripcion,usuario,fecha,modi)
values (OLD.id,OLD.descripcion,NEW.usuario_modi,NOW(), 1);

  /*delete*/
CREATE TRIGGER `tr_tiposcarreras_baja_log` AFTER DELETE ON `tiposcarreras`
FOR EACH ROW insert into aud_tiposcarreras_log (id,descripcion,usuario,fecha,baja)
values (OLD.id,OLD.descripcion,OLD.usuario_modi,NOW(), 1);



/*TABLA Y TRIGGERS PARA REGIMENES*/

CREATE TABLE IF NOT EXISTS `aud_regimenes_log` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;  

  /*update*/
CREATE TRIGGER `tr_regimenes_modi_log` AFTER UPDATE ON `regimenes`
FOR EACH ROW insert into aud_regimenes_log (id,descripcion,usuario,fecha,modi)
values (OLD.id,OLD.descripcion,NEW.usuario_modi,NOW(), 1);

  /*delete*/
CREATE TRIGGER `tr_regimenes_baja_log` AFTER DELETE ON `regimenes`
FOR EACH ROW insert into aud_regimenes_log (id,descripcion,usuario,fecha,baja)
values (OLD.id,OLD.descripcion,OLD.usuario_modi,NOW(), 1);




/*TABLA Y TRIGGERS PARA CARRERA NIVEL*/

CREATE TABLE IF NOT EXISTS `aud_carrerasniveles_log` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

   /*update*/
  CREATE TRIGGER `tr_carrerasniveles_modi_log` AFTER UPDATE ON `carrerasniveles`
  FOR EACH ROW insert into aud_carrerasniveles_log (id,descripcion,usuario,fecha,modi)
  values (OLD.id,OLD.descripcion, NEW.usuario_modi,NOW(), 1); 

    /*delete*/
  CREATE TRIGGER `tr_carrerasniveles_baja_log` AFTER DELETE ON `carrerasniveles`
  FOR EACH ROW insert into aud_carrerasniveles_log (id,descripcion,usuario,fecha,baja)
  values (OLD.id,OLD.descripcion, OLD.usuario_modi,NOW(), 1);



/*TABLA Y TRIGGERS TIPOS DURACIONES*/

CREATE TABLE IF NOT EXISTS `aud_tiposduraciones_log` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;  

  /*update*/
CREATE TRIGGER `tr_tiposduraciones_modi_log` AFTER UPDATE ON `tiposduraciones`
FOR EACH ROW insert into aud_tiposducariones_log (id,descripcion,usuario,fecha,modi)
values (OLD.id,OLD.descripcion,NEW.usuario_modi,NOW(), 1);

  /*delete*/
CREATE TRIGGER `tr_tiposduraciones_baja_log` AFTER DELETE ON `tiposduraciones`
FOR EACH ROW insert into aud_tiposducariones_log (id,descripcion,usuario,fecha,baja)
values (OLD.id,OLD.descripcion,OLD.usuario_modi,NOW(), 1);





/*TABLA Y TRIGGERS MODALIDADES*/

CREATE TABLE IF NOT EXISTS `aud_modalidades_log` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;  

  /*update*/
CREATE TRIGGER `tr_modalidades_modi_log` AFTER UPDATE ON `modalidades`
FOR EACH ROW insert into aud_modalidades_log (id,descripcion,usuario,fecha,modi)
values (OLD.id,OLD.descripcion,NEW.usuario_modi,NOW(), 1);

  /*delete*/
CREATE TRIGGER `tr_modalidades_baja_log` AFTER DELETE ON `modalidades`
FOR EACH ROW insert into aud_modalidades_log (id,descripcion,usuario,fecha,baja)
values (OLD.id,OLD.descripcion,OLD.usuario_modi,NOW(), 1);




/*TABLA Y TRIGGERS AREAS OCUPACIONALES*/

CREATE TABLE IF NOT EXISTS `aud_areasocupacionales_log` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;  

  /*update*/
CREATE TRIGGER `tr_areasocupacionales_modi_log` AFTER UPDATE ON `areasocupacionales`
FOR EACH ROW insert into aud_areasocupacionales_log (id,descripcion,usuario,fecha,modi)
values (OLD.id,OLD.descripcion,NEW.usuario_modi,NOW(), 1);

  /*delete*/
CREATE TRIGGER `tr_areasocupacionales_baja_log` AFTER DELETE ON `areasocupacionales`
FOR EACH ROW insert into aud_areasocupacionales_log (id,descripcion,usuario,fecha,baja)
values (OLD.id,OLD.descripcion,OLD.usuario_modi,NOW(), 1);



/*TABLA Y TRIGGERS AREAS CARRERAS*/

CREATE TABLE IF NOT EXISTS `aud_carreras_log` (
  `id` int(11) NOT NULL,
  `organizacion_id` int(10) NOT NULL,
  `carrera` varchar(500) COLLATE utf8_spanish_ci DEFAULT NULL,
  `carreranivel_id` int(10) NULL,
  `tipocarrera_id` int(10) NULL,
  `regimen_id` int(10) NULL,
  `tipoduracion_id` int(10) NULL,
  `duracion` int(11) NULL,
  `modalidad_id` int(10) NULL,
  `cargahorariacatedra` int(11) NULL,
  `cargahorariareloj` int(11) NULL,
  `areaocupacional_id` int(10) NULL,
  `activa` tinyint(1) DEFAULT NULL,
  `exameningreso` tinyint(1) DEFAULT NULL,
  `observaciones` varchar(8000) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;  

  /*update*/
CREATE TRIGGER `tr_carreras_modi_log` AFTER UPDATE ON `carreras`
FOR EACH ROW insert into aud_carreras_log (id,organizacion_id,carrera,carreranivel_id,tipocarrera_id,regimen_id,tipoduracion_id,duracion,modalidad_id,cargahorariacatedra,cargahorariareloj,areaocupacional_id,activa,exameningreso,observaciones,usuario,fecha,modi)
values (OLD.id,OLD.organizacion_id,OLD.carrera,OLD.carreranivel_id,OLD.tipocarrera_id,OLD.regimen_id,OLD.tipoduracion_id,OLD.duracion,OLD.modalidad_id,OLD.cargahorariacatedra,OLD.cargahorariareloj,OLD.areaocupacional_id,OLD.activa,OLD.exameningreso,OLD.observaciones,NEW.usuario_modi,NOW(), 1);

  /*delete*/
CREATE TRIGGER `tr_carreras_baja_log` AFTER DELETE ON `carreras`
FOR EACH ROW insert into aud_carreras_log (id,organizacion_id,carrera,carreranivel_id,tipocarrera_id,regimen_id,tipoduracion_id,duracion,modalidad_id,cargahorariacatedra,cargahorariareloj,areaocupacional_id,activa,exameningreso,observaciones,usuario,fecha,baja)
values (OLD.id,OLD.organizacion_id,OLD.carrera,OLD.carreranivel_id,OLD.tipocarrera_id,OLD.regimen_id,OLD.tipoduracion_id,OLD.duracion,OLD.modalidad_id,OLD.cargahorariacatedra,OLD.cargahorariareloj,OLD.areaocupacional_id,OLD.activa,OLD.exameningreso,OLD.observaciones,OLD.usuario_modi,NOW(), 1);

