<?php

class Materia extends \Eloquent {
	

	protected $table = 'materias';
	protected $hidden = ['created_at','updated_ad', 'usuario_alta', 'usuario_modi', 'updated_at','fecha_alta', 'fecha_modi'];



	public function carrera()
	{
		return $this->belongsTo('Carrera');
	}


	public function planestudio()
	{
		return $this->belongsTo('PlanEstudio');
	}


    /*public function inscripcionesfinales()
    {
        return $this->hasmany('InscripcionFinal', 'materia_id');
    }*/


    public function inscripcionesmaterias()
    {
        return $this->hasmany('InscripcionMateria', 'materia_id');
    }


    public function correlatividades()
    {
        return $this->hasmany('Correlatividad', 'materia_id');
    }

    public function correlatividadcursadas()
    {
        return $this->hasmany('Correlatividadcursada', 'materia_id');
    }

    public function correlatividadaprobadas()
    {
        return $this->hasmany('Correlatividadaprobada', 'materia_id');
    }

    public function correlatividadfinalaprobados()
    {
        return $this->hasmany('Correlatividadafinalprobado', 'materia_id');
    }



    public function mesaexamenes()
    {
        return $this->hasmany('MesaExamen', 'materia_id');
    }

    public function regularpromocion()
    {
        return $this->hasmany('RegularPromocion', 'materia_id');
    }

}
