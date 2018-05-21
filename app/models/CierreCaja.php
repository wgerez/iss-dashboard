<?php

class CierreCaja extends Eloquent {
	
	protected $table = 'cierrecajas';

	public function users()
	{
		return $this->belongsToMany('User');
	}
}