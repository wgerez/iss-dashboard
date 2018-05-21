
/*TABLA Y TRIGGERS PARA ORGANIZACIONES*/
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

    /*update*/
CREATE TRIGGER `tr_organizaciones_modi_log` AFTER UPDATE ON `organizaciones`
FOR EACH ROW insert into aud_organizaciones_log (id,nombre,razon_social,cuit,nivel_educativo_id,habilitar_sedes,pais_id,provincia_id,departamento_id,localidad_id,barrio_id,calle,numero,manzana,piso,departamento,codigo_postal,usuario,fecha,modi)
values (OLD.id,OLD.nombre,OLD.razon_social,OLD.cuit,OLD.nivel_educativo_id,OLD.habilitar_sedes,OLD.pais_id,OLD.provincia_id,OLD.departamento_id,OLD.localidad_id,OLD.barrio_id,OLD.calle,OLD.numero,OLD.manzana,OLD.piso,OLD.departamento,OLD.codigo_postal, NEW.usuario_modi,NOW(), 1);  

    /*delete*/
CREATE TRIGGER `tr_organizaciones_baja_log` AFTER DELETE ON `organizaciones`
FOR EACH ROW insert into aud_organizaciones_log (id,nombre,razon_social,cuit,nivel_educativo_id,habilitar_sedes,pais_id,provincia_id,departamento_id,localidad_id,barrio_id,calle,numero,manzana,piso,departamento,codigo_postal,usuario,fecha,baja)
values (OLD.id,OLD.nombre,OLD.razon_social,OLD.cuit,OLD.nivel_educativo_id,OLD.habilitar_sedes,OLD.pais_id,OLD.provincia_id,OLD.departamento_id,OLD.localidad_id,OLD.barrio_id,OLD.calle,OLD.numero,OLD.manzana,OLD.piso,OLD.departamento,OLD.codigo_postal, OLD.usuario_modi,NOW(), 1);



/*TABLA Y TRIGGERS PARA NIVELES EDUCATIVOS*/

CREATE TABLE IF NOT EXISTS `aud_niveles_educativos_log` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

   /*update*/
  CREATE TRIGGER `tr_niveles_educativos_modi_log` AFTER UPDATE ON `niveles_educativos`
  FOR EACH ROW insert into aud_niveles_educativos_log (id,descripcion,usuario,fecha,modi)
  values (OLD.id,OLD.descripcion, NEW.usuario_modi,NOW(), 1); 

    /*delete*/
  CREATE TRIGGER `tr_niveles_educativos_baja_log` AFTER DELETE ON `niveles_educativos`
  FOR EACH ROW insert into aud_niveles_educativos_log (id,descripcion,usuario,fecha,baja)
  values (OLD.id,OLD.descripcion, OLD.usuario_modi,NOW(), 1);



  /*TABLA Y TRIGGERS PARA CONTACTOS*/

CREATE TABLE IF NOT EXISTS `aud_contactos_log` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;  

  /*update*/
CREATE TRIGGER `tr_contactos_modi_log` AFTER UPDATE ON `contactos`
FOR EACH ROW insert into aud_contactos_log (id,descripcion,usuario,fecha,modi)
values (OLD.id,OLD.descripcion, NEW.usuario_modi,NOW(), 1);

  /*delete*/
CREATE TRIGGER `tr_contactos_baja_log` AFTER DELETE ON `contactos`
FOR EACH ROW insert into aud_contactos_log (id,descripcion,usuario,fecha,baja)
values (OLD.id,OLD.descripcion, OLD.usuario_modi,NOW(), 1);

 

 /*TABLA Y TRIGGERS PARA CONTACTOS_ORGANIZACION*/

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


  /*delete*/
CREATE TRIGGER `tr_contacto_organizacion_baja_log` AFTER DELETE ON `contacto_organizacion`
FOR EACH ROW insert into aud_contacto_organizacion_log (id,organizacion_id,contacto_id,descripcion,usuario,fecha,baja)
values (OLD.id,OLD.organizacion_id,OLD.contacto_id,OLD.descripcion, OLD.usuario_modi,NOW(), 1);



/*TABLA Y TRIGGERS PARA PAISES*/

CREATE TABLE IF NOT EXISTS `aud_paises_log` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

  /*update*/
CREATE TRIGGER `tr_paises_modi_log` AFTER UPDATE ON `paises`
FOR EACH ROW insert into aud_paises_log (id,descripcion,usuario,fecha,modi)
values (OLD.id,OLD.descripcion, NEW.usuario_modi,NOW(), 1);

  /*delete*/
CREATE TRIGGER `tr_paises_baja_log` AFTER DELETE ON `paises`
FOR EACH ROW insert into aud_paises_log (id,descripcion,usuario,fecha,baja)
values (OLD.id,OLD.descripcion, OLD.usuario_modi,NOW(), 1);



/*TABLA Y TRIGGERS PARA PROVINCIAS*/

CREATE TABLE IF NOT EXISTS `aud_provincias_log` (
  `id` int(11) NOT NULL,
  `pais_id` int(11) DEFAULT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

  /*update*/
CREATE TRIGGER `tr_provincias_modi_log` AFTER UPDATE ON `provincias`
FOR EACH ROW insert into aud_provincias_log (id,pais_id,descripcion,usuario,fecha,modi)
values (OLD.id,OLD.pais_id,OLD.descripcion, NEW.usuario_modi,NOW(), 1);

  /*delete*/
CREATE TRIGGER `tr_provincias_baja_log` AFTER DELETE ON `provincias`
FOR EACH ROW insert into aud_provincias_log (id,pais_id,descripcion,usuario,fecha,baja)
values (OLD.id,OLD.pais_id,OLD.descripcion, OLD.usuario_modi,NOW(), 1);



/*TABLA Y TRIGGERS PARA DEPARTAMENTOS*/

CREATE TABLE IF NOT EXISTS `aud_departamentos_log` (
  `id` int(11) NOT NULL,
  `provincia_id` int(11) DEFAULT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

  /*update*/
CREATE TRIGGER `tr_departamentos_modi_log` AFTER UPDATE ON `departamentos`
FOR EACH ROW insert into aud_departamentos_log (id,provincia_id,descripcion,usuario,fecha,modi)
values (OLD.id,OLD.provincia_id,OLD.descripcion, NEW.usuario_modi,NOW(), 1);

  /*delete*/
CREATE TRIGGER `tr_departamentos_baja_log` AFTER DELETE ON `departamentos`
FOR EACH ROW insert into aud_departamentos_log (id,provincia_id,descripcion,usuario,fecha,baja)
values (OLD.id,OLD.provincia_id,OLD.descripcion, OLD.usuario_modi,NOW(), 1);



/*TABLA Y TRIGGERS PARA LOCALIDADES*/

CREATE TABLE IF NOT EXISTS `aud_localidades_log` (
  `id` int(11) NOT NULL,
  `departamento_id` int(11) DEFAULT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

  /*update*/
CREATE TRIGGER `tr_localidades_modi_log` AFTER UPDATE ON `localidades`
FOR EACH ROW insert into aud_localidades_log (id,departamento_id,descripcion,usuario,fecha,modi)
values (OLD.id,OLD.departamento_id,OLD.descripcion, NEW.usuario_modi,NOW(), 1);

  /*delete*/
CREATE TRIGGER `tr_localidades_baja_log` AFTER DELETE ON `localidades`
FOR EACH ROW insert into aud_localidades_log (id,departamento_id,descripcion,usuario,fecha,baja)
values (OLD.id,OLD.departamento_id,OLD.descripcion, OLD.usuario_modi,NOW(), 1);



/*TABLA Y TRIGGERS PARA BARRIOS*/

CREATE TABLE IF NOT EXISTS `aud_barrios_log` (
  `id` int(11) NOT NULL,
  `localidad_id` int(11) DEFAULT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `modi` tinyint(1) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

  /*update*/
CREATE TRIGGER `tr_barrios_modi_log` AFTER UPDATE ON `barrios`
FOR EACH ROW insert into aud_barrios_log (id,localidad_id,descripcion,usuario,fecha,modi)
values (OLD.id,OLD.localidad_id,OLD.descripcion, NEW.usuario_modi,NOW(), 1);

  /*delete*/
CREATE TRIGGER `tr_barrios_baja_log` AFTER DELETE ON `barrios`
FOR EACH ROW insert into aud_barrios_log (id,localidad_id,descripcion,usuario,fecha,baja)
values (OLD.id,OLD.localidad_id,OLD.descripcion, OLD.usuario_modi,NOW(), 1);