<?php

class Ocupacion extends \Eloquent {
	

	protected $table = 'ocupaciones';



	public function alumnosfamiliares()
	{
		return $this->hasmany('AlumnoFamiliar', 'ocupacion_id');
	}
}