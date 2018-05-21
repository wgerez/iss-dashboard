<?php

class RegularPromocion extends \Eloquent {
	

	protected $table = 'regularpromocion';


	public function carrera()
	{
		return $this->belongsTo('Carrera');
	}

	public function planestudio()
	{
		return $this->belongsTo('PlanEstudio');
	}

    public function ciclolectivo()
    {
        return $this->belongsTo('CicloLectivo');
    }

    public function materias()
    {
        return $this->belongsTo('Materia');
    }
    
}
