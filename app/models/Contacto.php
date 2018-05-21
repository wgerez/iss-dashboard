<?php

class Contacto extends Eloquent {
	protected $guarded = array();

	public static $rules = array();

	protected $table = 'contactos';


    /* Relaciones */
	public function organizaciones()
    {
        return $this->belongsToMany('Organizacion')->withPivot('descripcion');
        //return $this->belongsToMany('Organizacion', 'contacto_organizacion');
    }

    public function personas()
    {
        return $this->belongsToMany('Persona')->withPivot('descripcion');
    }

    /*Relaciones*/
}
