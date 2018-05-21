<?php

class AlumnoFamiliar extends \Eloquent {
	
	protected $table = 'alumnosfamiliares';



	/*Relaciones*/





	public function persona()
    {
    
        return $this->belongsTo('Persona', 'persona_id');
    }


	public function alumno()
    {
        return $this->belongsTo('Alumno');
    }


	public function ocupacion()
    {
        return $this->belongsTo('Ocupacion');
    }


    public function relacionfamiliar()
    {
        return $this->belongsTo('RelacionFamiliar');
    }


}