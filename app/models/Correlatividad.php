<?php

class Correlatividad extends \Eloquent {
	protected $fillable = [];


	protected $table = 'correlatividades';



	public function correlatividadescursadas()
    {
        return $this->hasmany('Correlatividadcursada', 'correlatividad_id');
    }


    public function correlatividadesaprobadas()
    {
        return $this->hasmany('Correlatividadaprobada', 'correlatividad_id');
    }


    public function correlatividadfinalaprobados()
    {
        return $this->hasmany('Correlatividadafinalprobado', 'correlatividad_id');
    }



	public function materia()
	{
		return $this->belongsTo('Materia');
	}
}