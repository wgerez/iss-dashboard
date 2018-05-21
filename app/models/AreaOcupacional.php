<?php

class AreaOcupacional extends \Eloquent {
	
	protected $table = 'areasocupacionales';


	/* Relaciones */
	public function carreras()
	{
		return $this->hasmany('Carrera','areaocupacional_id');
	}
}