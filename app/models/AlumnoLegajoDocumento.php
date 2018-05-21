<?php

class AlumnoLegajoDocumento extends \Eloquent {
	
	
	protected $table = 'alumnoslegajosdocumentos';



	/*Relaciones*/
	public function alumnolegajo()
    {
        return $this->belongsTo('AlumnoLegajo');
    }

}