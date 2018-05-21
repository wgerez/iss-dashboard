<?php

class PlanEstudio extends \Eloquent {
	

	protected $table = 'planesestudios';




	public function carrera()
	{
		return $this->belongsTo('Carrera');
	}

	public function ciclolectivo()
	{
		return $this->belongsTo('CicloLectivo');
	}


	public function materias()
	{
		return $this->hasmany('Materia','planestudio_id');
	}
	

    /*public function inscripcionesfinales()
    {
        return $this->hasmany('InscripcionFinal', 'planestudio_id');
    }*/

    public function inscripcionesmaterias()
    {
        return $this->hasmany('InscripcionMateria', 'planestudio_id');
    }
}