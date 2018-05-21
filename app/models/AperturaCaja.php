<?php

class AperturaCaja extends Eloquent {
	
	protected $table = 'aperturacajas';

	public function users()
	{
		return $this->belongsToMany('User');
	}
}