<?php

class Formapagocuota extends \Eloquent {
	
	protected $table = 'formapagocuotas';


	public function detallepagocuota()
	{
		return $this->hasmany('Detallecuotapago','formapagocuota_id');
	}
}