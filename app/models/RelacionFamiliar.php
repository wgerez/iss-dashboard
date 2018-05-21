<?php

class RelacionFamiliar extends \Eloquent {
	

	protected $table = 'relacioneafamiliares';



		public function alumnosfamiliares()
	{
		return $this->hasmany('AlumnoFamiliar', 'relacionfamiliar_id');
	}
}

