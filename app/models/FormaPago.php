<?php

class FormaPago extends Eloquent {
	
	protected $table = 'formapago';

	public function cajachica()
	{
		return $this->hasmany('CajaChica','formapago_id');
	}
}