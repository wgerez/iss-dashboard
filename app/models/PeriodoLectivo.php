<?php

class PeriodoLectivo extends \Eloquent {
	

	protected $table = 'periodoslectivos';

	protected $fillable = array('ciclolectivo_id', 'descripcion', 'fechainicio', 'fechafin', 'usuario_alta', 'fecha_alta');

	
	/*Relaciones*/
	public function ciclolectivo()
    {
        return $this->belongsTo('CicloLectivo');
    }

    public function matriculas()
    {
        return $this->hasmany('Matricula', 'periodolectivo_id');
    }    
}