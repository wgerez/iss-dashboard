<?php

class TipoCarrera extends Eloquent {

	protected $table = 'tiposcarreras';


	/* Relaciones */
	public function carreras()
	{
		return $this->hasmany('Carrera','tipocarrera_id');
	}
}
