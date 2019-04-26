<?php

class Acceso extends \Eloquent {
	
	protected $table = 'accesos';

	/* Relaciones */
	public function persona()
    {
        return $this->belongsTo('Persona', 'persona_id');
    }

    public static function getAccesoPerfil($perfil)
    {
        $result = DB::Select('select p.apellido, p.nombre, p.id as persona_id, u.id, u.usuario from users u
			inner join perfil_user pu on u.id = pu.user_id
			inner join personas p on p.id = u.persona_id
			where pu.perfil_id = ?
			order by p.apellido, p.nombre',  [$perfil]);

        return $result;
    }

}