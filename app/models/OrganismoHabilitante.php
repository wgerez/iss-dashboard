<?php

class OrganismoHabilitante extends \Eloquent {
	
	protected $table = 'organismoshabilitantes';

	
	/*Relaciones*/
	public function docentes()
	{
		return $this->hasmany('Docente','organismohabilitante_id');
	}
}