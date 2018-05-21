<?php

class Alumno extends \Eloquent {
	
	protected $table = 'alumnos';

    public static function getPorApellido($apellido)
    {
        $result = DB::table('personas', 'alumnos')
                ->select(DB::raw('personas.id as persona_id, personas.apellido, personas.nombre,
                    personas.nrodocumento, alumnos.id as alumno_id'))
                ->join('alumnos', 'personas.id', '=', 'alumnos.persona_id')
                ->where('personas.apellido', 'like', '%' . $apellido . '%')
                ->orderBy('personas.apellido')
                ->get();

        return $result;
    }

    public static function getPorApellidoNombre($apellido, $nombre)
    {
        $result = DB::table('personas', 'alumnos')
                ->select(DB::raw('personas.id as persona_id, personas.apellido, personas.nombre,
                    personas.nrodocumento, alumnos.id as alumno_id'))
                ->join('alumnos', 'personas.id', '=', 'alumnos.persona_id')
                ->whereRaw('personas.apellido="' . $apellido . '" and personas.nombre="' . $nombre . '"')
                ->orderBy('personas.apellido')
                ->get();

        return $result;
    }

    public static function getAlumnoPorDni($dni)
    {
        $result = DB::table('personas', 'alumnos', 'localidades', 'provincias')
                ->select(DB::raw('personas.id as persona_id, personas.apellido, personas.nombre,
                    personas.numero, personas.calle, personas.nrodocumento, alumnos.id as alumno_id,
                    localidades.descripcion as localidad, provincias.descripcion as provincia'))
                ->join('alumnos', 'personas.id', '=', 'alumnos.persona_id')
                ->join('localidades', 'personas.localidad_id', '=', 'localidades.id')
                ->join('provincias', 'personas.provincia_id', '=', 'provincias.id')
                ->whereRaw('personas.nrodocumento ='.$dni.' AND alumnos.activo=1')
                ->orderBy('personas.apellido')
                ->get();

        return $result;
    }

    public static function getAlumnoPorId($id)
    {
        $result = DB::table('personas', 'alumnos', 'localidades', 'provincias')
                ->select(DB::raw('personas.id as persona_id, personas.apellido, personas.nombre,
                    personas.numero, personas.calle, personas.nrodocumento, alumnos.id as alumno_id,
                    localidades.descripcion as localidad, provincias.descripcion as provincia'))
                ->join('alumnos', 'personas.id', '=', 'alumnos.persona_id')
                ->join('localidades', 'personas.localidad_id', '=', 'localidades.id')
                ->join('provincias', 'personas.provincia_id', '=', 'provincias.id')
                ->where('personas.id', '=', $id)
                ->orderBy('personas.apellido')
                ->get();

        return $result;
    }

    public static function getAlumnoPorAlumnoId($id)
    {
        $result = DB::table('personas', 'alumnos', 'localidades', 'provincias')
                ->select(DB::raw('personas.id as persona_id, personas.apellido, personas.nombre,
                    personas.numero, personas.calle, personas.nrodocumento, alumnos.id as alumno_id,
                    localidades.descripcion as localidad, provincias.descripcion as provincia'))
                ->join('alumnos', 'personas.id', '=', 'alumnos.persona_id')
                ->join('localidades', 'personas.localidad_id', '=', 'localidades.id')
                ->join('provincias', 'personas.provincia_id', '=', 'provincias.id')
                ->where('alumnos.id', '=', $id)
                ->orderBy('personas.apellido')
                ->get();

        return $result;
    }

	/* Relaciones */
	public function persona()
    {
    	/*
    	 * Se agrega el 2do parametro.
    	 * Con esto puedo consultar datos de la Persona
    	 * desde Alumno.
    	 */
        return $this->belongsTo('Persona', 'persona_id');
    }

    public function alumnosfamiliares()
    {
        return $this->hasmany('AlumnoFamiliar', 'alumno_id');
    }

    public function detallesmatriculaspagos()
    {
        return $this->hasmany('DetalleMatriculaPago', 'alumno_id');
    }

    public function detallescuotaspagos()
    {
        return $this->hasmany('DetalleCuotaPago', 'alumno_id');
    }


    public function alumnolegajo()
    {
        return $this->hasOne('AlumnoLegajo');
    }

    public function carreras()
    {
        return $this->belongsToMany('Carrera');
    }


    public function inscripcionesfinales()
    {
        return $this->hasmany('InscripcionFinal', 'alumno_id');
    }


    public function inscripcionesmaterias()
    {
        return $this->hasmany('InscripcionMateria', 'alumno_id');
    }
}