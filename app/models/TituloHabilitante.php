<?php

class TituloHabilitante extends \Eloquent {
	
	protected $table = 'tituloshabilitantes';

		/*Relaciones*/
	public function docentes()
	{
		return $this->hasmany('Docente','titulohabilitante_id');
	}
}