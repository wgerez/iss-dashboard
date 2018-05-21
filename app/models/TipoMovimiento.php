<?php

class TipoMovimiento extends Eloquent {
	
	protected $table = 'tipomovimiento';

	public function cajachica()
	{
		return $this->hasmany('CajaChica','movimiento_id');
	}
}