<?php

class AlumnoLegajo extends \Eloquent {
	
	protected $table = 'alumnoslegajos';

    public static function getLegajosPorCarrera($carrera_id)
    {
        $result = DB::table('alumno_carrera', 'alumnoslegajos', 'alumnos', 'personas')
                ->select(DB::raw('alumnoslegajos.dni, alumnoslegajos.partidanacimiento,
                    alumnoslegajos.certificadobuenasalud, alumnoslegajos.certificadovacinacion,
                    alumnoslegajos.fichapreinscripcion, alumnoslegajos.titulosecundario, alumnoslegajos.constitulotramite,
                    alumnoslegajos.constanciatrabajo, alumnoslegajos.otros, alumnoslegajos.foto,
                    personas.apellido, personas.nombre'))
                ->join('alumnoslegajos', 'alumno_carrera.alumno_id', '=', 'alumnoslegajos.alumno_id')
                ->join('alumnos', 'alumnoslegajos.alumno_id', '=', 'alumnos.id')
                ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
                ->where('alumno_carrera.carrera_id', '=', $carrera_id)
                ->orderBy('personas.apellido')
                ->get();

        return $result;
    }

    public static function getLegajosPorCarreraCiclo($carrera_id, $ciclo_id)
    {
        $result = DB::table('alumno_carrera', 'alumnoslegajos', 'alumnos', 'personas')//, 'matriculas')
                ->select(DB::raw('alumnoslegajos.dni, alumnoslegajos.partidanacimiento, alumnoslegajos.certificadobuenasalud, alumnoslegajos.certificadovacinacion, alumnoslegajos.fichapreinscripcion, alumnoslegajos.titulosecundario, alumnoslegajos.constitulotramite, alumnoslegajos.constanciatrabajo, alumnoslegajos.seguro, alumnoslegajos.otros, alumnoslegajos.foto, alumnoslegajos.fechavencimientoseguro, personas.apellido, personas.nombre'))
                //->join('matriculas', 'alumno_carrera.carrera_id', '=', 'matriculas.carrera_id')
                //->join('cicloslectivos', 'matriculas.ciclolectivo_id', '=', 'cicloslectivos.id')
                ->join('alumnoslegajos', 'alumno_carrera.alumno_id', '=', 'alumnoslegajos.alumno_id')
                ->join('alumnos', 'alumnoslegajos.alumno_id', '=', 'alumnos.id')
                ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
                ->whereRaw('alumno_carrera.ciclolectivo_id=' . $ciclo_id . ' and alumno_carrera.carrera_id=' . $carrera_id . ' and alumnos.activo=1')
                ->orderBy('personas.apellido')
                ->get();

        return $result;
    }

    public static function getLegajosPorDNI($dni)
    {
        $result = DB::table('personas', 'alumnoslegajos', 'alumnos')
                ->select(DB::raw('alumnoslegajos.dni, alumnoslegajos.partidanacimiento,
                    alumnoslegajos.certificadobuenasalud, alumnoslegajos.certificadovacinacion,
                    alumnoslegajos.fichapreinscripcion, alumnoslegajos.titulosecundario, alumnoslegajos.constitulotramite,
                    alumnoslegajos.constanciatrabajo, alumnoslegajos.seguro, alumnoslegajos.fechavencimientoseguro, alumnoslegajos.otros, alumnoslegajos.foto,
                    personas.apellido, personas.nombre'))
                ->join('alumnos', 'personas.id', '=', 'alumnos.persona_id')
                ->join('alumnoslegajos', 'alumnos.id', '=', 'alumnoslegajos.alumno_id')
                ->whereRaw('personas.nrodocumento='. $dni . ' AND alumnos.activo=1')
                ->orderBy('personas.apellido')
                ->get();

        return $result;
    }

    public static function getLegajosPorApellido($apellido)
    {
        $result = DB::table('personas', 'alumnoslegajos', 'alumnos')
                ->select(DB::raw('alumnoslegajos.dni, alumnoslegajos.partidanacimiento,
                    alumnoslegajos.certificadobuenasalud, alumnoslegajos.certificadovacinacion,
                    alumnoslegajos.fichapreinscripcion, alumnoslegajos.titulosecundario, alumnoslegajos.constitulotramite,
                    alumnoslegajos.constanciatrabajo, alumnoslegajos.seguro, alumnoslegajos.fechavencimientoseguro, alumnoslegajos.otros, alumnoslegajos.foto,
                    personas.apellido, personas.nombre'))
                ->join('alumnos', 'personas.id', '=', 'alumnos.persona_id')
                ->join('alumnoslegajos', 'alumnos.id', '=', 'alumnoslegajos.alumno_id')
                ->whereRaw('personas.apellido=' . $apellido . ' AND alumnos.activo=1')
                ->orderBy('personas.apellido')
                ->get();

        return $result;
    }


/*Relaciones*/
	public function alumno()
    {
        return $this->belongsTo('Alumno');
    }


    public function alumnoslegajosdocumentos()
    {
        return $this->hasmany('AlumnoLegajoDocumento', 'alumnolegajo_id');
    }

    public function borrar()
    {

        foreach($this->alumnoslegajosdocumentos as $aldocumento)
        {
            $aldocumento->delete();
        }

        return parent::delete();
    }    
}


