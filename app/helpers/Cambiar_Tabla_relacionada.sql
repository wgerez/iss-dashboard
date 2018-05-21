SET FOREIGN_KEY_CHECKS=0;



ALTER TABLE  `carreras` CHANGE  `nivel_Educativo_id`  `carreranivel_id` INT( 10 ) UNSIGNED NOT NULL;

ALTER TABLE  `aud_carreras_log` CHANGE  `nivel_Educativo_id`  `carreranivel_id` INT( 10 ) UNSIGNED NOT NULL;

/*ALTER TABLE docentes DISABLE TRIGGERS ALL; */

SET FOREIGN_KEY_CHECKS=1;



DROP TRIGGER IF EXISTS tr_docentes_baja_log;
 


DROP TRIGGER IF EXISTS tr_docentes_modi_log;

