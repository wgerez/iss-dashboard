<?php

class TribunalDocente extends \Eloquent {
	
	protected $table = 'tribunaldocentes';


	public function docente()
	{
		return $this->belongsTo('Docente');
	}


	public function mesaexamen()
	{
		return $this->belongsTo('MesaExamen');
	}
}