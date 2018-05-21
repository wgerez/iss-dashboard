<?php

class ExamenFinal extends \Eloquent {
	protected $table = 'examenfinal';


    public function organizacion()
	{
		return $this->belongsTo('Organizacion');
	}

	public function carrera()
	{
		return $this->belongsTo('Carrera');
	}

	public function materia()
	{
		return $this->belongsTo('Materia');
	}


	public function planestudio()
	{
		return $this->belongsTo('PlanEstudio');
	}


	public function turnoexamen()
	{
		return $this->belongsTo('TurnoExamen');
	}

	public function alumno()
	{
		return $this->belongsTo('Alumno');
	}

}