<?php

class DetalleAsignarDocente extends \Eloquent {
		

		protected $table = 'detalleasignardocente';

	
	public function asignardocente()
	{
		return $this->belongsTo('asignardocente');
	}


}