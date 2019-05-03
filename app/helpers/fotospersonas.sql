
SET SQL_SAFE_UPDATES = 0; /* para permitir actualizacion entre 2 tablas*/




UPDATE 
personas
 
INNER JOIN 
alumnos
 
ON 
personas.id = alumnos.persona_id
 
SET 
personas.foto = alumnos.foto

WHERE 
personas.id = alumnos.persona_id;








UPDATE 
personas 

INNER JOIN 
docentes
 
ON 
personas.id = docentes.persona_id 

SET 
personas.foto = docentes.foto
WHERE 
personas.id = docentes.persona_id;

