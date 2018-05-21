<?php

class TipoDocumento extends \Eloquent {

	protected $table = 'tipodocumentos';

	public function users()
	{
		return $this->hasmany('User','tipodocumento_id');
	}
}