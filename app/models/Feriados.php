<?php

class Feriados extends \Eloquent {
	

	protected $table = 'feriados';

	public function organizacion()
	{
		return $this->belongsTo('Organizacion');
	}

	public function ciclolectivo()
	{
		return $this->belongsTo('CicloLectivo');
	}


}