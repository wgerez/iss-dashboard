<?php

class MesaExamen extends \Eloquent {
	protected $table = 'mesaexamenes';


	public function tribunaldocentes()
    {
        return $this->hasmany('TribunalDocente', 'mesaexamen_id');
    }


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


	public function ciclolectivo()
	{
		return $this->belongsTo('CicloLectivo');
	}


	public function turnoexamen()
	{
		return $this->belongsTo('TurnoExamen');
	}


	public function inscripcionesfinales()
    {
        return $this->hasmany('InscripcionFinal', 'mesaexamen_id');
    }

}