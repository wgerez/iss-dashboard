<?php

class Departamento extends Eloquent {
	protected $guarded = array();

	public static $rules = array();

	protected $table = 'departamentos';

	/* Relaciones */
	public function provincia()
    {
        return $this->belongsTo('Provincia');
    }

    public function localidades()
	{
		return $this->hasmany('Localidad','Departamento_id');
	}


    public function organizaciones()
	{
		return $this->hasmany('Organizacion','departamento_id');
	}

	public function personas()
	{
		return $this->hasmany('Persona','departamento_id');
	}
}
