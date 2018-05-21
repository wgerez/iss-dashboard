<?php

class LugarNacimiento extends \Eloquent {
	

	protected $table = 'paises';

	/*Relaciones */
	public function personas()
	{
		return $this->hasmany('Persona','lugarnacimiento_id');
	}
}