<?php

class NivelEducativo extends Eloquent {
	protected $guarded = array();

	public static $rules = array();

	protected $table = 'niveles_educativos';

	public function organizaciones()
	{
		return $this->hasmany('Organizacion');
	}

}
