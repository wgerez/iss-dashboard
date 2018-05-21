<?php

class Regularidades extends \Eloquent {
		

		protected $table = 'regularidades';

	
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
	
    public function ciclolectivo()
    {
        return $this->belongsTo('CicloLectivo');
    }

}