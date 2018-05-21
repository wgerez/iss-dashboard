<?php

class TituloOtorgado extends \Eloquent {
	

	protected $table = 'titulosotorgados';


	public function carreras()
	{
		return $this->hasmany('Carrera', 'titulootorgado_id');
	}
}