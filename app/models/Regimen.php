<?php

class Regimen extends \Eloquent {
		
	protected $table = 'regimenes';


	/* Relaciones */
	public function carreras()
	{
		return $this->hasmany('Carrera','regimen_id');
	}
}