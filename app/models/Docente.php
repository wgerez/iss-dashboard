<?php

class Docente extends Eloquent {
    
	protected $table = 'docentes';	

    public static function getListado()
    {
        return Docente::get(array('id', 'activo', 'nrolegajo', 'fechaingreso', 'fechaegreso', 'persona_id'));
    }

    

	public function persona()
    {
        return $this->belongsTo('Persona');
    }

    public function tituloHabilitante()
    {
        return $this->belongsTo('TituloHabilitante');
    }

    public function organismoHabilitante()
    {
        return $this->belongsTo('OrganismoHabilitante');
    }
    
    /*public function inscripcionesfinales()
    {
        return $this->hasmany('InscripcionFinal', 'docente_id');
    }*/

    public function materias()
    {
        return $this->hasmany('materias', 'docente_id');
    }


    public function tribunaldocentes()
    {
        return $this->hasmany('TribunalDocente', 'docente_id');
    }

    public function docentelegajo()
    {
        return $this->hasOne('DocenteLegajo');
    }

    public static function getDocentePorDni($dni)
    {
        $result = DB::table('personas', 'docentes', 'localidades', 'provincias')
                ->select(DB::raw('personas.id as persona_id, personas.apellido, personas.nombre,
                    personas.numero, personas.calle, personas.nrodocumento, docentes.id as docente_id,
                    localidades.descripcion as localidad, provincias.descripcion as provincia'))
                ->join('docentes', 'personas.id', '=', 'docentes.persona_id')
                ->join('localidades', 'personas.localidad_id', '=', 'localidades.id')
                ->join('provincias', 'personas.provincia_id', '=', 'provincias.id')
                ->whereRaw('personas.nrodocumento ='.$dni.' AND docentes.activo=1')
                ->orderBy('personas.apellido')
                ->get();

        return $result;
    }

    public static function getDocenteApellidoNombre($apellido, $nombre)
    {
        $result = DB::table('personas', 'docentes')
                ->select(DB::raw('personas.id as persona_id, personas.apellido, personas.nombre,
                    personas.nrodocumento, docentes.id as docente_id'))
                ->join('docentes', 'personas.id', '=', 'docentes.persona_id')
                ->whereRaw('personas.apellido="' . $apellido . '" and personas.nombre="' . $nombre . '" AND docentes.activo=1')
                ->orderBy('personas.apellido')
                ->get();

        return $result;
    }

}