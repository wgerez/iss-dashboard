<?php

class EstadoCivil extends \Eloquent {
	

	protected $table = 'estadosciviles';

	/*Relaciones */
	public function personas()
	{
		return $this->hasmany('Persona','estadocivil_id');
	}
}