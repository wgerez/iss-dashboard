<?php

class DocenteLegajo extends \Eloquent {
	
	protected $table = 'docenteslegajos';

/*Relaciones*/
	public function docente()
    {
        return $this->belongsTo('Docente');
    }


    public function docenteslegajosdocumentos()
    {
        return $this->hasmany('DocenteLegajoDocumento', 'docentelegajo_id');
    }

    public function borrar()
    {

        foreach($this->docenteslegajosdocumentos as $aldocumento)
        {
            $aldocumento->delete();
        }

        return parent::delete();
    }    
}


