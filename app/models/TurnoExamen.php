<?php

class TurnoExamen extends \Eloquent {

	protected $table = 'turnoexamenes';


	public function mesaexamenes()
    {
        return $this->hasmany('MesaExamen', 'turnoexamen_id');
    }

	
}