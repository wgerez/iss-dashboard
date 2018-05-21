


SET FOREIGN_KEY_CHECKS=0;

/*ALTER TABLE docentes ENABLE TRIGGERS ALL; */

ALTER TABLE  `docentes` CHANGE  `organisamohabilitante_id`  `organismohabilitante_id` INT( 10 ) UNSIGNED NOT NULL;

ALTER TABLE  `aud_docentes_log` CHANGE  `organisamohabilitante_id`  `organismohabilitante_id` INT( 10 ) UNSIGNED NOT NULL;

/*ALTER TABLE docentes DISABLE TRIGGERS ALL; */

SET FOREIGN_KEY_CHECKS=1;



DROP TRIGGER tr_docentes_baja_log;
 
CREATE TRIGGER `tr_docentes_baja_log` AFTER DELETE ON `docentes`
 FOR EACH ROW insert into aud_docentes_log (id,persona_id,nrolegajo,foto,activo,empleado,disertante,fechaingreso,fechaegreso,titulohabilitante_id,organismohabilitante_id,nrolegajohabilitante,usuario,fecha,baja)
values (OLD.id,OLD.persona_id,OLD.nrolegajo,OLD.foto,OLD.activo,OLD.empleado,OLD.disertante,OLD.fechaingreso,OLD.fechaegreso,OLD.titulohabilitante_id,OLD.organismohabilitante_id,OLD.nrolegajohabilitante, OLD.usuario_modi,NOW(), 1);
    

 DROP TRIGGER tr_docentes_modi_log;

CREATE TRIGGER `tr_docentes_modi_log` AFTER UPDATE ON `docentes`
 FOR EACH ROW insert into aud_docentes_log (id,persona_id,nrolegajo,foto,activo,empleado,disertante,fechaingreso,fechaegreso,titulohabilitante_id,organismohabilitante_id,nrolegajohabilitante,usuario,fecha,modi)
values (OLD.id,OLD.persona_id,OLD.nrolegajo,OLD.foto,OLD.activo,OLD.empleado,OLD.disertante,OLD.fechaingreso,OLD.fechaegreso,OLD.titulohabilitante_id,OLD.organismohabilitante_id,OLD.nrolegajohabilitante, NEW.usuario_modi,NOW(), 1);