<?php

class Concepto extends Eloquent {
	
	protected $table = 'concepto';

	public function cajachica()
	{
		return $this->hasmany('CajaChica','concepto_id');
	}
}