<?php

class Beca extends \Eloquent {
	
	protected $table = 'becas';

    public static function getHistorial($alumno_id)
    {
        $result = DB::table('becas', 'carreras', 'cicloslectivos')
                ->select(DB::raw('becas.id as beca_id, becas.becafechainicio,
                	becas.becafechafin, cicloslectivos.descripcion as ciclo_descripcion,
                    cicloslectivos.fechafin as fecha_fin_ciclo_lectivo, carreras.carrera'))
                ->join('carreras', 'becas.carrera_id', '=', 'carreras.id')
                ->join('cicloslectivos', 'becas.ciclolectivo_id', '=', 'cicloslectivos.id')
                ->where('becas.alumno_id', '=', $alumno_id)
                ->get();
    	return $result;
    }

    public static function getAlumnosBecadosPorCarrera($carrera_id)
    {
        $result = DB::table('becas', 'carreras','personas', 'alumnos', 'barrios', 'localidades')
                ->select(DB::raw('becas.becafechainicio, becas.becafechafin,
                    carreras.carrera, personas.apellido, personas.nombre,
                    personas.nrodocumento as dni, personas.calle, personas.id as persona_id,
                    personas.numero as calle_numero, barrios.descripcion as barrio,
                    localidades.descripcion as localidad'))
                ->join('alumnos', 'alumnos.id', '=', 'becas.alumno_id')
                ->join('personas', 'personas.id', '=', 'alumnos.persona_id')
                ->join('carreras', 'carreras.id', '=', 'becas.carrera_id')
                ->join('barrios', 'barrios.id', '=', 'personas.barrio_id')
                ->join('localidades', 'localidades.id', '=', 'personas.localidad_id')
                ->whereRaw('becas.carrera_id = ' . $carrera_id . ' and becas.becado = 1')
                ->orderBy('personas.apellido')
                ->get();

        return $result;
    }

    public static function getAlumnosBecadosPorCarreraCiclo($carrera_id, $ciclo_id)
    {
        $result = DB::table('becas', 'carreras','personas', 'alumnos', 'barrios', 'localidades')
                ->select(DB::raw('becas.becafechainicio, becas.becafechafin, becas.ciclolectivo_id,
                    carreras.id as carrera_id, carreras.carrera, personas.apellido, personas.nombre,
                    personas.nrodocumento as dni, personas.sexo, personas.calle, personas.id as persona_id,
                    personas.numero as calle_numero, barrios.descripcion as barrio, personas.manzana, personas.departamento,
                    localidades.descripcion as localidad, alumnos.id as alumno_id, alumnos.fechaingreso, alumnos.activo'))
                ->join('alumnos', 'alumnos.id', '=', 'becas.alumno_id')
                ->join('personas', 'personas.id', '=', 'alumnos.persona_id')
                ->join('carreras', 'carreras.id', '=', 'becas.carrera_id')
                ->join('barrios', 'barrios.id', '=', 'personas.barrio_id')
                ->join('localidades', 'localidades.id', '=', 'personas.localidad_id')
                ->whereRaw('becas.carrera_id = ' . $carrera_id . ' AND becas.ciclolectivo_id ='. $ciclo_id .' and becas.becado = 1')
                ->orderBy('personas.apellido')
                ->get();

        return $result;
    }

    public static function getAlumnosBecadosPorDNI($dni)
    {
        $result = DB::table('personas', 'carreras','becas', 'alumnos', 'barrios', 'localidades')
                ->select(DB::raw('becas.becafechainicio, becas.becafechafin,
                    carreras.carrera, personas.apellido, personas.nombre,
                    personas.nrodocumento as dni, personas.calle, personas.id as persona_id,
                    personas.numero as calle_numero, barrios.descripcion as barrio,
                    localidades.descripcion as localidad'))
                ->join('alumnos', 'alumnos.persona_id', '=', 'personas.id')
                ->join('becas', function($join)
                    {
                        $join->on('alumnos.id', '=', 'becas.alumno_id')
                             ->where('becas.becado', '=', 1);
                    })
                ->join('carreras', 'carreras.id', '=', 'becas.carrera_id')
                ->join('barrios', 'barrios.id', '=', 'personas.barrio_id')
                ->join('localidades', 'localidades.id', '=', 'personas.localidad_id')
                ->where('personas.nrodocumento', '=', $dni)
                ->orderBy('personas.apellido')
                ->get();

        return $result;
    }

    public static function getAlumnosBecadosPorApellido($apellido)
    {
        $result = DB::table('personas', 'carreras','becas', 'alumnos', 'barrios', 'localidades')
                ->select(DB::raw('becas.becafechainicio, becas.becafechafin,
                    carreras.carrera, personas.apellido, personas.nombre,
                    personas.nrodocumento as dni, personas.calle, personas.id as persona_id,
                    personas.numero as calle_numero, barrios.descripcion as barrio,
                    localidades.descripcion as localidad'))
                ->join('alumnos', 'alumnos.persona_id', '=', 'personas.id')
                ->join('becas', function($join)
                    {
                        $join->on('alumnos.id', '=', 'becas.alumno_id')
                             ->where('becas.becado', '=', 1);
                    })
                ->join('carreras', 'carreras.id', '=', 'becas.carrera_id')
                ->join('barrios', 'barrios.id', '=', 'personas.barrio_id')
                ->join('localidades', 'localidades.id', '=', 'personas.localidad_id')
                ->where('personas.apellido', 'like', '%' . $apellido . '%')
                ->orderBy('personas.apellido')
                ->get();

        return $result;
    }

}