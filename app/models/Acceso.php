<?php

class Acceso extends \Eloquent {
	
	protected $table = 'accesos';

	/* Relaciones */
	public function persona()
    {
        return $this->belongsTo('Persona', 'persona_id');
    }

}