<?php

class Provincia extends Eloquent {
	protected $guarded = array();

	public static $rules = array();


	protected $table = 'provincias';

	/* Relaciones */
	public function pais()
    {
        return $this->belongsTo('pais');
    }

	public function departamentos()
	{
		return $this->hasmany('Departamento','provincia_id');
	}

		public function organizaciones()
	{
		return $this->hasmany('Organizacion','provincia_id');
	}

	public function personas()
	{
		return $this->hasmany('Persona','provincia_id');
	}	
}
