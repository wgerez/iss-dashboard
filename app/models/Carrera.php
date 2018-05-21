<?php

class Carrera extends \Eloquent {
	

	protected $table = 'carreras';

	public static function Carreraspororganizacion($id)
	{
		$arr = array();
		$carreras =  Carrera::where('organizacion_id','=',$id)->get();
		$arr[]= ['id'=>0, 'descripcion'=>'Seleccione'];
		foreach ($carreras as $carrera) {
			$arr[]= ['id'=>$carrera['id'], 'descripcion'=>$carrera['carrera']];
		}
		return $arr;
	}

	/* Relaciones */
	public function organizacion()
	{
		return $this->belongsTo('Organizacion');
	}

	public function titulootorgado()
	{
	    return $this->belongsTo('TituloOtorgado');
	}
	
	public function carreranivel()
	{
		return $this->belongsTo('CarreraNivel');
	}


	public function tipocarrera()
	{
	    return $this->belongsTo('TipoCarrera');
	}


	public function regimen()
	{
        return $this->belongsTo('Regimen');
   	}


    public function tipoduracion()
	{
        return $this->belongsTo('TipoDuracion');
    }


    public function modalidad()
	{
        return $this->belongsTo('Modalidad');
    }

    public function matriculas()
    {
        return $this->hasmany('Matricula', 'carrera_id');
    }

    public function areaocupacional()
	{
        return $this->belongsTo('AreaOcupacional');
    }

    public function alumnos()
    {
        return $this->belongsToMany('Alumno');
    }

    public function planesestudios()
    {
        return $this->hasmany('PlanEstudio', 'carrera_id');
    }


    public function materias()
	{
		return $this->hasmany('Materia','carrera_id');
	}

	public function mesaexamenes()
    {
        return $this->hasmany('MesaExamen', 'carrera_id');
    }

    /*public function inscripcionesfinal()
    {
        return $this->hasmany('InscripcionFinal', 'carrera_id');
    }
	*/
}