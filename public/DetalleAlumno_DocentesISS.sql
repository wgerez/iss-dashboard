
SET FOREIGN_KEY_CHECKS=0;

delete from contactos;
delete from estadosciviles;
delete from niveles_educativos;
delete from organismoshabilitantes;
delete from tipodocumentos;
delete from tituloshabilitantes;

SET FOREIGN_KEY_CHECKS=1;

ALTER TABLE provincias AUTO_INCREMENT = 1;
ALTER TABLE departamentos AUTO_INCREMENT = 1;
ALTER TABLE localidades AUTO_INCREMENT = 1;
ALTER TABLE barrios AUTO_INCREMENT = 1;



Insert into contactos (Descripcion) values ('Particular');
Insert into contactos (Descripcion) values ('Laboral');
Insert into contactos (Descripcion) values ('Correo');
Insert into contactos (Descripcion) values ('Sitio Web');



Insert into estadosciviles (Descripcion) values ('Soltero');
Insert into estadosciviles (Descripcion) values ('Casado');
Insert into estadosciviles (Descripcion) values ('Divorciado');
Insert into estadosciviles (Descripcion) values ('Viudo');



Insert into niveles_educativos (Descripcion) values ('Terciario');
Insert into niveles_educativos (Descripcion) values ('Universitario');



Insert into organismoshabilitantes (Descripcion) values ('Ministerio de Educación');


Insert into tipodocumentos (Descripcion) values ('DNI');
Insert into tipodocumentos (Descripcion) values ('DNID');
Insert into tipodocumentos (Descripcion) values ('DNIT');
Insert into tipodocumentos (Descripcion) values ('DNIC');
Insert into tipodocumentos (Descripcion) values ('DNI – EA');
Insert into tipodocumentos (Descripcion) values ('DNI – EB');
Insert into tipodocumentos (Descripcion) values ('LE');
Insert into tipodocumentos (Descripcion) values ('LC');


Insert into tituloshabilitantes (Descripcion) values ('Profesor de Ingles');


