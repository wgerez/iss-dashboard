<?php

class TipoDuracion extends \Eloquent {
		
	protected $table = 'tiposduraciones';


	/* Relaciones */
	public function carreras()
	{
		return $this->hasmany('Carrera','tipoduracion_id');
	}
}