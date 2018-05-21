<?php

class Pais extends Eloquent {
	protected $guarded = array();

	public static $rules = array();


	protected $table = 'paises';

	/* Relaciones */

	public function provincias()
	{
		return $this->hasmany('provincia','pais_id');
	}

	public function organizaciones()
	{
		return $this->hasmany('Organizacion','pais_id');
	}	

	public function personas()
	{
		return $this->hasmany('Persona','pais_id');
	}
}
