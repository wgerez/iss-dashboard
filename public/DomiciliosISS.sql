
SET FOREIGN_KEY_CHECKS=0;

delete from provincias;
delete from departamentos;
delete from departamentos;
delete from barrios;

SET FOREIGN_KEY_CHECKS=1;

ALTER TABLE provincias AUTO_INCREMENT = 1;
ALTER TABLE departamentos AUTO_INCREMENT = 1;
ALTER TABLE localidades AUTO_INCREMENT = 1;
ALTER TABLE barrios AUTO_INCREMENT = 1;


Insert into paises (Descripcion) values ('Argentina');


Insert into provincias (pais_id,Descripcion) values (1,'Formosa');


Insert into departamentos (provincia_id,Descripcion) values (1,'BERMEJO');
Insert into departamentos (provincia_id,Descripcion) values (1,'FORMOSA');
Insert into departamentos (provincia_id,Descripcion) values (1,'LAISHI');
Insert into departamentos (provincia_id,Descripcion) values (1,'MATACOS');
Insert into departamentos (provincia_id,Descripcion) values (1,'PATIÑO');
Insert into departamentos (provincia_id,Descripcion) values (1,'PILAGAS');
Insert into departamentos (provincia_id,Descripcion) values (1,'PILCOMAYO');
Insert into departamentos (provincia_id,Descripcion) values (1,'PIRANE');
Insert into departamentos (provincia_id,Descripcion) values (1,'RAMON LISTA');



Insert into localidades (departamento_id,Descripcion) values (1,'BAJO HONDO');
Insert into localidades (departamento_id,Descripcion) values (1,'EL AIBAL');
Insert into localidades (departamento_id,Descripcion) values (1,'EL AIBALITO');
Insert into localidades (departamento_id,Descripcion) values (1,'EL CAÑON');
Insert into localidades (departamento_id,Descripcion) values (1,'EL CRUCE');
Insert into localidades (departamento_id,Descripcion) values (1,'EL CHURCAL');
Insert into localidades (departamento_id,Descripcion) values (1,'EL CHURCALITO');
Insert into localidades (departamento_id,Descripcion) values (1,'EL QUEMADO NUEVO');
Insert into localidades (departamento_id,Descripcion) values (1,'EL REMANSO');
Insert into localidades (departamento_id,Descripcion) values (1,'EL CAVADO');
Insert into localidades (departamento_id,Descripcion) values (1,'EL SOLITARIO');
Insert into localidades (departamento_id,Descripcion) values (1,'PALMITAS');
Insert into localidades (departamento_id,Descripcion) values (1,'FORTIN LA SOLEDAD');
Insert into localidades (departamento_id,Descripcion) values (1,'FORTIN NUEVO PILCOMAYO');
Insert into localidades (departamento_id,Descripcion) values (1,'INGENIERO FAURE');
Insert into localidades (departamento_id,Descripcion) values (1,'PUERTO IRIGOYEN');
Insert into localidades (departamento_id,Descripcion) values (1,'LA LIBERTAD');
Insert into localidades (departamento_id,Descripcion) values (1,'LA PALIZADA');
Insert into localidades (departamento_id,Descripcion) values (1,'LA RINCONADA');
Insert into localidades (departamento_id,Descripcion) values (1,'LA SOLEDAD');
Insert into localidades (departamento_id,Descripcion) values (1,'TRES PACES');
Insert into localidades (departamento_id,Descripcion) values (1,'LAG. YACARE (CACIQ SUMAYEN)');
Insert into localidades (departamento_id,Descripcion) values (1,'LAGUNA YEMA');
Insert into localidades (departamento_id,Descripcion) values (1,'LAGUNITA');
Insert into localidades (departamento_id,Descripcion) values (1,'LAMADRID');
Insert into localidades (departamento_id,Descripcion) values (1,'LOS CIENEGUITOS');
Insert into localidades (departamento_id,Descripcion) values (1,'LOS CHIRIGUANOS');
Insert into localidades (departamento_id,Descripcion) values (1,'MATIAS GULACSY (TAS TAS)');
Insert into localidades (departamento_id,Descripcion) values (1,'MEDIA LUNA');
Insert into localidades (departamento_id,Descripcion) values (1,'PALMA SOLA');
Insert into localidades (departamento_id,Descripcion) values (1,'PESCADO NEGRO');
Insert into localidades (departamento_id,Descripcion) values (1,'POZO DE MAZA (LUIS DE GASPERI)');
Insert into localidades (departamento_id,Descripcion) values (1,'POZO DEL MORTERO (FRANCISCO BOCH)');
Insert into localidades (departamento_id,Descripcion) values (1,'RIO MUERTO');
Insert into localidades (departamento_id,Descripcion) values (1,'SANTA ROSA');
Insert into localidades (departamento_id,Descripcion) values (1,'EL SIMBOLAR');
Insert into localidades (departamento_id,Descripcion) values (1,'SOMBRERO NEGRO (GUMERCINDO ZAYAGO)');
Insert into localidades (departamento_id,Descripcion) values (1,'VACA PERDIDA');
Insert into localidades (departamento_id,Descripcion) values (1,'GUADALCAZAR');
Insert into localidades (departamento_id,Descripcion) values (1,'RINCONADA');
Insert into localidades (departamento_id,Descripcion) values (1,'REPRESA');
Insert into localidades (departamento_id,Descripcion) values (1,'TRES YUCHANES');
Insert into localidades (departamento_id,Descripcion) values (1,'EL QUIMIL');
Insert into localidades (departamento_id,Descripcion) values (1,'POSITOS');
Insert into localidades (departamento_id,Descripcion) values (1,'POZO RAMON');
Insert into localidades (departamento_id,Descripcion) values (1,'EL PICHANAL');
Insert into localidades (departamento_id,Descripcion) values (1,'MADRUGADA');
Insert into localidades (departamento_id,Descripcion) values (1,'EL CHAÑARAL');
Insert into localidades (departamento_id,Descripcion) values (1,'SANTA ROSA');
Insert into localidades (departamento_id,Descripcion) values (1,'LAS BANDERITAS');
Insert into localidades (departamento_id,Descripcion) values (1,'EL PARAISO');
Insert into localidades (departamento_id,Descripcion) values (1,'EL SILENCIO');


Insert into localidades (departamento_id,Descripcion) values (2,'FORMOSA CAPITAL');
Insert into localidades (departamento_id,Descripcion) values (2,'COL. ITUZAINGO');
Insert into localidades (departamento_id,Descripcion) values (2,'COL. DALMACIA');
Insert into localidades (departamento_id,Descripcion) values (2,'EL DESVIO DE LOS PILAGAS');
Insert into localidades (departamento_id,Descripcion) values (2,'COL. LAS LOMITAS');
Insert into localidades (departamento_id,Descripcion) values (2,'ISLA ALVAREZ');
Insert into localidades (departamento_id,Descripcion) values (2,'ESTANCIA LA ALEGRIA');
Insert into localidades (departamento_id,Descripcion) values (2,'ESTANCIA STA. OLGA');
Insert into localidades (departamento_id,Descripcion) values (2,'GRAN GUARDIA');
Insert into localidades (departamento_id,Descripcion) values (2,'GUAYCOLE');
Insert into localidades (departamento_id,Descripcion) values (2,'ISLA 25 DE MAYO');
Insert into localidades (departamento_id,Descripcion) values (2,'ESTANCIA LA FLORIDA');
Insert into localidades (departamento_id,Descripcion) values (2,'LOMA CLAVEL');
Insert into localidades (departamento_id,Descripcion) values (2,'MIGUEL AZCUENAGA');
Insert into localidades (departamento_id,Descripcion) values (2,'MARIANO BOEDO');
Insert into localidades (departamento_id,Descripcion) values (2,'MOJON DE FIERRO');
Insert into localidades (departamento_id,Descripcion) values (2,'MONTEAGUDO');
Insert into localidades (departamento_id,Descripcion) values (2,'COL. PASTORIL');
Insert into localidades (departamento_id,Descripcion) values (2,'BOCA PILAGAS');
Insert into localidades (departamento_id,Descripcion) values (2,'PTE. HIRIGOYEN');
Insert into localidades (departamento_id,Descripcion) values (2,'SAN ALBERTO');
Insert into localidades (departamento_id,Descripcion) values (2,'SAN HILARIO');
Insert into localidades (departamento_id,Descripcion) values (2,'PTE. URIBURU');
Insert into localidades (departamento_id,Descripcion) values (2,'CAÑADA 12');
Insert into localidades (departamento_id,Descripcion) values (2,'EL OMBU');
Insert into localidades (departamento_id,Descripcion) values (2,'PILAGA I');
Insert into localidades (departamento_id,Descripcion) values (2,'PJE. PUENTE SAN HILARIO');
Insert into localidades (departamento_id,Descripcion) values (2,'POZO DEL TIGRE');



Insert into barrios (localidad_id,Descripcion) values (1,'Don Bosco');
Insert into barrios (localidad_id,Descripcion) values (1,'Independencia');
Insert into barrios (localidad_id,Descripcion) values (1,'San Miguel');
Insert into barrios (localidad_id,Descripcion) values (1,'San Francisco');
Insert into barrios (localidad_id,Descripcion) values (1,'Villa Lourdes');
Insert into barrios (localidad_id,Descripcion) values (1,'El resguardo');
Insert into barrios (localidad_id,Descripcion) values (1,'San Agustín');
Insert into barrios (localidad_id,Descripcion) values (1,'Bernardino Rivadavia');
Insert into barrios (localidad_id,Descripcion) values (1,'Villa Hermosa');
Insert into barrios (localidad_id,Descripcion) values (1,'Barrio Obrero');
Insert into barrios (localidad_id,Descripcion) values (1,'La Pilar');
Insert into barrios (localidad_id,Descripcion) values (1,'Mariano Moreno');
Insert into barrios (localidad_id,Descripcion) values (1,'Luis Jorge Fontana');
Insert into barrios (localidad_id,Descripcion) values (1,'San Juan Bautista');
Insert into barrios (localidad_id,Descripcion) values (1,'Nuestra señora de Luján');
Insert into barrios (localidad_id,Descripcion) values (1,'La Paz');
Insert into barrios (localidad_id,Descripcion) values (1,'Juan Manuel de Rosas');
Insert into barrios (localidad_id,Descripcion) values (1,'San Pedro');
Insert into barrios (localidad_id,Descripcion) values (1,'Virgen de Itatí');
Insert into barrios (localidad_id,Descripcion) values (1,'El PUCÚ');
Insert into barrios (localidad_id,Descripcion) values (1,'Emilio Tomás');
Insert into barrios (localidad_id,Descripcion) values (1,'El Palmar');
Insert into barrios (localidad_id,Descripcion) values (1,'Coluccio');
Insert into barrios (localidad_id,Descripcion) values (1,'Sagrado Corazón de María');
Insert into barrios (localidad_id,Descripcion) values (1,'Ricardo Balbín');
Insert into barrios (localidad_id,Descripcion) values (1,'Municipal');
Insert into barrios (localidad_id,Descripcion) values (1,'Santa Rosa');
Insert into barrios (localidad_id,Descripcion) values (1,'12 de octubre');
Insert into barrios (localidad_id,Descripcion) values (1,'Venezuela');
Insert into barrios (localidad_id,Descripcion) values (1,'Irigoyen');
Insert into barrios (localidad_id,Descripcion) values (1,'Parque Urbano');
Insert into barrios (localidad_id,Descripcion) values (1,'7 de Noviembre');
Insert into barrios (localidad_id,Descripcion) values (1,'San Juan I');
Insert into barrios (localidad_id,Descripcion) values (1,'Antenor Gauna');
Insert into barrios (localidad_id,Descripcion) values (1,'8 de octubre');
Insert into barrios (localidad_id,Descripcion) values (1,'Juan Domindo Perón');
Insert into barrios (localidad_id,Descripcion) values (1,'Eva Perón');
Insert into barrios (localidad_id,Descripcion) values (1,'El Porvenir');
