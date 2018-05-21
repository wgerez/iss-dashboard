<?php

class Barrio extends Eloquent {
	
	protected $guarded = array();

	public static $rules = array();


	protected $table = 'barrios';

	public function localidad()
    {
        return $this->belongsTo('Localidad');
    }


    public function organizaciones()
	{
		return $this->hasmany('Organizacion','barrio_id');
	}

	public function personas()
	{
		return $this->hasmany('Persona','barrio_id');
	}
}