<?php

class Correlatividadcursada extends \Eloquent {
	protected $fillable = [];


	protected $table = 'correlatividadescursadas';



	public function correlatividad()
	{
		return $this->belongsTo('Correlatividad');
	}

	public function materia()
	{
		return $this->belongsTo('Materia');
	}
}