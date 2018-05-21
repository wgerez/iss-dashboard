<?php

class CajaChica extends \Eloquent {
	

	protected $table = 'cajachica';

	/* Relaciones */
	public function organizacion()
	{
		return $this->belongsTo('Organizacion');
	}

	public function carreras()
	{
	    return $this->belongsTo('Carrera');
	}
	
	public function alumnos()
	{
		return $this->belongsTo('Alumno');
	}


	public function concepto()
	{
	    return $this->belongsTo('Concepto');
	}


	public function tipomovimiento()
	{
        return $this->belongsTo('TipoMovimiento');
   	}


    public function formapago()
	{
        return $this->belongsTo('FormaPago');
    }

}