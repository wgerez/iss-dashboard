<?php

class AsignarDocente extends \Eloquent {
		

		protected $table = 'asignardocente';

	
	public function carrera()
	{
		return $this->belongsTo('Carrera');
	}


	public function planestudio()
	{
		return $this->belongsTo('PlanEstudio');
	}


	public function materia()
	{
		return $this->belongsTo('Materia');
	}


	public function docente()
	{
		return $this->belongsTo('Docente');
	}

}