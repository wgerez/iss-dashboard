<?php

class Asistencias extends \Eloquent {
		

		protected $table = 'asistencias';

	
	public function carrera()
	{
		return $this->belongsTo('Carrera');
	}


	public function planestudio()
	{
		return $this->belongsTo('PlanEstudio');
	}


		public function alumno()
	{
		return $this->belongsTo('Alumno');
	}

	
	public function materia()
	{
		return $this->belongsTo('Materia');
	}

	public function docente()
	{
		return $this->belongsTo('Docente');
	}
	
    public function ciclolectivo()
    {
        return $this->belongsTo('CicloLectivo');
    }
}