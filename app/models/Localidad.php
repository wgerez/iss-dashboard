<?php

class Localidad extends Eloquent {

	protected $guarded = array();

	public static $rules = array();

	protected $table = 'localidades';

	public static function Localidadespordpto($id)
	{
		return Localidad::where('departamento_id','=',$id)->get();
	}

	/* Relaciones */

	public function departamento()
    {
        return $this->belongsTo('Departamento');
    }

	public function barrios()
	{
		return $this->hasmany('Barrio','localidad_id');
	}


    public function organizaciones()
	{
		return $this->hasmany('Organizacion','localidad_id');
	}

		public function personas()
	{
		return $this->hasmany('Persona','localidad_id');
	}
}
