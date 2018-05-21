<?php

class Correlatividadfinalaprobado extends \Eloquent {
	protected $fillable = [];

	protected $table = 'correlatividadfinalaprobados';


	public function correlatividad()
	{
		return $this->belongsTo('Correlatividad');
	}


	public function materia()
	{
		return $this->belongsTo('Materia');
	}
}