<?php

class Correlatividadaprobada extends \Eloquent {
	protected $fillable = [];

	protected $table = 'correlatividadesaprobadas';


	public function correlatividad()
	{
		return $this->belongsTo('Correlatividad');
	}


	public function materia()
	{
		return $this->belongsTo('Materia');
	}
}