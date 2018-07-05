<?php

class DocenteLegajoDocumento extends \Eloquent {
	
	
	protected $table = 'docenteslegajosdocumentos';



	/*Relaciones*/
	public function docentelegajo()
    {
        return $this->belongsTo('DocenteLegajo');
    }

}