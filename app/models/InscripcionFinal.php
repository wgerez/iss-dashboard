<?php

class InscripcionFinal extends \Eloquent {
	
	protected $table = 'inscripcionesfinales';

	

	/*public function carrera()
	{
		return $this->belongsTo('Carrera');
	}*/


	/*public function planestudio()
	{
		return $this->belongsTo('PlanEstudio');
	}


	public function docente()
	{
		return $this->belongsTo('Docente');
	}*/

	public function alumno()
	{
		return $this->belongsTo('Alumno');
	}

	
	/*public function materia()
	{
		return $this->belongsTo('Materia');
	}*/

	public function mesaexamen()
	{
		return $this->belongsTo('MesaExamen');
	}
}