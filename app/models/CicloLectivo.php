<?php

class CicloLectivo extends \Eloquent {
	

	protected $table = 'cicloslectivos';

	/*Relaciones*/

    /*
     * Retorna la cantidad de ciclos lectivos activos.
     * Solo deberia existir -como maximo- 1 ciclo activo.
     */
    public static function verificaExisteCicloActivo($organizacion_id)
    {
        return CicloLectivo::whereRaw('organizacion_id=' . $organizacion_id . ' and activo=1')->count();
    }

    public static function getCicloActivo($organizacion_id)
    {
        return CicloLectivo::whereRaw('organizacion_id=' . $organizacion_id . ' and activo=1')->get();
    }

	public function organizacion()
	{
		return $this->belongsTo('Organizacion');
	}


	public function periodoslectivos()
	{
		return $this->hasmany('PeriodoLectivo', 'ciclolectivo_id');
	}

    public function matriculas()
    {
        return $this->hasmany('Matricula', 'ciclolectivo_id');
    }


    public function planesestudios()
    {
        return $this->hasmany('PlanEstudio', 'ciclolectivo_id');
    }


    public function mesaexamenes()
    {
        return $this->hasmany('MesaExamen', 'ciclolectivo_id');
    }
}