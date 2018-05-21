<?php

class Modulo extends \Eloquent {
	
	protected $table = 'modulos';



	/*Relaciones*/


	public function perfiles()
    {
//        return $this->belongsToMany('Perfil')->withPivot('perfil');
    	return $this->belongsToMany('Perfil')->withPivot('perfil_id', 'leer', 'editar', 'eliminar', 'imprimir');

        //return $this->belongsToMany('Organizacion', 'contacto_organizacion');
    }
}