<?php

class Persona extends \Eloquent {
	

	protected $table = 'personas';

	/*Relaciones */
	public function estadoCivil()
    {
        return $this->belongsTo('EstadoCivil');
    }

	public function tipoDocumento()
    {
        return $this->belongsTo('TipoDocumento');
    }

	public function lugarNacimiento()
    {
        return $this->belongsTo('LugarNacimiento');
    }

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
    }

	public function alumno()
    {
        return $this->hasOne('Alumno');
    }

    public function docente()
    {
        return $this->hasOne('Docente');
    }

    public function alumnofamiliar()
    {
        return $this->hasOne('AlumnoFamiliar');
    }
    
    public function user()
    {
        return $this->hasOne('User');
    }    
    /*Relaciones*/  

    public function ScopeSearchApellido($query, $descripcion)
    {
        return $query->where('apellido', 'like', "%$descripcion%");
    }

    public function ScopeSearchNombre($query, $descripcion)
    {
        return $query->where('nombre', 'like', "%$descripcion%");
    }

}