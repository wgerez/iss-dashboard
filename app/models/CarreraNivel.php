<?php

class CarreraNivel extends \Eloquent {
	

	protected $table = 'carrerasniveles';


	/*Relaciones*/
	public function carreras()
	{
		return $this->hasmany('Carrera', 'carreranivel_id');
	}
}