<?php

class Organizacion extends Eloquent {
	protected $guarded = array();

	public static $rules = array();

	protected $table = 'organizaciones';

	/*Relaciones */
    public function pais()
    {
        return $this->belongsTo('Pais');
    }

	public function provincia()
    {
        return $this->belongsTo('Provincia');
    }	

	public function departamento()
    {
        return $this->belongsTo('Departamento');
    }

    public function localidad()
    {
        return $this->belongsTo('Localidad');
    }

    public function barrio()
    {
        return $this->belongsTo('Barrio');
    }

    public function nivelEducativo()
    {
        return $this->belongsTo('NivelEducativo');
    }

    public function contactos()
    {
        return $this->belongsToMany('Contacto')->withPivot('descripcion');
        //return $this->belongsToMany('Contacto', 'contacto_organizacion');
    }

    public function users()
    {
        return $this->belongsToMany('User');
    }

    public function ciclolectivos()
    {
        return $this->hasmany('CicloLectivo', 'organizacion_id');
    }

    public function matriculas()
    {
        return $this->hasmany('Matricula', 'organizacion_id');
    }


    public function perfiles()
    {
        return $this->hasmany('Perfil', 'organizacion_id');
    }

    public function carreras()
    {
        return $this->hasmany('Carrera', 'organizacion_id');
    }


    public function planesestudios()
    {
        return $this->hasmany('PlanEstudio', 'organizacion_id');
    }

    public function mesaexamenes()
    {
        return $this->hasmany('MesaExamen', 'organizacion_id');
    }


    /*Relaciones*/

}
