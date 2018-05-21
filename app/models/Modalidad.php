<?php

class Modalidad extends \Eloquent {
	

	protected $table = 'modalidades';


	/* Relaciones */
	public function carreras()
	{
		return $this->hasmany('Carrera','modalidad_id');
	}
}