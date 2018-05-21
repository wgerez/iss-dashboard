<?php

class AlumnoCarrera extends \Eloquent {
	
	protected $table = 'alumno_carrera';

    public static function getDatosInscripcionesPorCarrera($carrera_id)
    {
        $result = DB::table('alumno_carrera', 'alumnos', 'personas', 'cicloslectivos',
                            'matriculas', 'carreras')
                ->select(DB::raw('personas.nrodocumento as dni, personas.apellido,
                    personas.nombre, personas.id as persona_id, alumnos.id as alumno_id,
                    cicloslectivos.descripcion as ciclo, alumno_carrera.id,
                    matriculas.matriculaimporte, matriculas.matriculaaplica,
                    matriculas.fechavencimientomatricula, carreras.carrera'))
                ->join('alumnos', 'alumno_carrera.alumno_id', '=', 'alumnos.id')
                ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
                ->join('cicloslectivos', 'alumno_carrera.ciclolectivo_id', '=', 'cicloslectivos.id')
                ->join('carreras', 'alumno_carrera.carrera_id', '=', 'carreras.id')
                ->join('matriculas', function($join)
                    {
                        $join->on('alumno_carrera.carrera_id', '=', 'matriculas.carrera_id')
                             ->on('alumno_carrera.ciclolectivo_id', '=',
                                     'matriculas.ciclolectivo_id');
                    })
                ->where('alumno_carrera.carrera_id', '=', $carrera_id)
                ->orderBy('personas.apellido')
                ->get();

        return $result;
    }

    public static function getDatosInscripcionesPorCarreraCiclo($carrera_id, $ciclo_id)
    {
        $result = DB::table('alumno_carrera', 'alumnos', 'personas', 'cicloslectivos',
                            'matriculas', 'carreras')
                ->select(DB::raw('personas.nrodocumento as dni, personas.apellido,
                    personas.nombre, personas.id as persona_id, alumnos.id as alumno_id,
                    cicloslectivos.descripcion as ciclo, alumno_carrera.id,
                    matriculas.matriculaimporte, matriculas.matriculaaplica,
                    matriculas.fechavencimientomatricula, carreras.carrera, alumnos.activo'))
                ->join('alumnos', 'alumno_carrera.alumno_id', '=', 'alumnos.id')
                ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
                ->join('cicloslectivos', 'alumno_carrera.ciclolectivo_id', '=', 'cicloslectivos.id')
                ->join('carreras', 'alumno_carrera.carrera_id', '=', 'carreras.id')
                ->join('matriculas', function($join)
                    {
                        $join->on('alumno_carrera.carrera_id', '=', 'matriculas.carrera_id')
                             ->on('alumno_carrera.ciclolectivo_id', '=',
                                     'matriculas.ciclolectivo_id');
                    })
                ->whereRaw('alumno_carrera.carrera_id ='.$carrera_id.' AND matriculas.ciclolectivo_id ='.$ciclo_id)
                ->orderBy('personas.apellido')
                ->get();

        return $result;
    }

    public static function getCarrerasInscripciones($alumno_id)
    {
        $result = DB::table('alumno_carrera', 'carreras')
                //->select(DB::raw('carreras.id, carreras.carrera'))
                ->select(DB::raw('carreras.id, carreras.carrera, alumno_carrera.id as inscripcion_id, alumno_carrera.carrera_id,
                    cicloslectivos.descripcion as ciclo, alumno_carrera.ciclolectivo_id'))
                ->join('cicloslectivos', 'alumno_carrera.ciclolectivo_id', '=', 'cicloslectivos.id')
                ->join('carreras', 'alumno_carrera.carrera_id', '=', 'carreras.id')
                ->where('alumno_carrera.alumno_id', '=', $alumno_id)
                ->get();

        return $result;
    }

    public static function getDatosInscripcionAlumno($alumno_id)
    {
        $result = DB::table('alumno_carrera', 'carreras', 'matriculas', 'cicloslectivos')
                ->select(DB::raw('carreras.id, carreras.carrera, alumno_carrera.id as inscripcion_id, alumno_carrera.carrera_id,
                    matriculas.ciclolectivo_id, matriculas.cuotaimporte, matriculas.mespagocuotainicio, matriculas.mespagocuotafin, matriculas.cuotaperiodopagodesde, matriculas.cuotaperiodopagohasta, matriculas.cuotasporperiodo, matriculas.id as matricula_id, cicloslectivos.descripcion as ciclo_descripcion, cicloslectivos.fechainicio as fecha_inicio_ciclo_lectivo, cicloslectivos.fechafin as fecha_fin_ciclo_lectivo, matriculas.cuotaaplica'))
                ->join('carreras', 'alumno_carrera.carrera_id', '=', 'carreras.id')
                ->join('matriculas', 'alumno_carrera.carrera_id', '=', 'matriculas.carrera_id')
                ->join('cicloslectivos', 'matriculas.ciclolectivo_id', '=', 'cicloslectivos.id')
                ->whereRaw('alumno_carrera.alumno_id ='. $alumno_id)
                ->get();

        return $result;
    }

    public static function getDatosInscripcion($inscripcion_id)
    {
        $result = DB::table('alumno_carrera', 'matriculas', 'cicloslectivos')
                ->select(DB::raw('alumno_carrera.id as inscripcion_id, alumno_carrera.carrera_id,
                    matriculas.ciclolectivo_id, matriculas.mespagocuotainicio,
                    matriculas.matriculaimporte, matriculas.cuotaimporte,
                    matriculas.matriculaperiodopagodesde, matriculas.matriculaperiodopagohasta,
                    matriculas.cuotaperiodopagodesde, matriculas.cuotaperiodopagohasta,
                    matriculas.cuotasporperiodo, matriculas.id as matricula_id,
                    cicloslectivos.descripcion as ciclo_descripcion,
                    cicloslectivos.fechainicio as fecha_inicio_ciclo_lectivo,
                    cicloslectivos.fechafin as fecha_fin_ciclo_lectivo,
                    matriculas.fechavencimientomatricula as matricula_fecha_vencimiento,
                    matriculas.matriculaaplica, matriculas.cuotaaplica, alumno_carrera.ciclolectivo_id as cicloinicio'))
                ->join('matriculas', 'alumno_carrera.carrera_id', '=', 'matriculas.carrera_id')
                ->join('cicloslectivos', 'matriculas.ciclolectivo_id', '=', 'cicloslectivos.id')
                ->where('alumno_carrera.id', '=', $inscripcion_id)
                ->get();

        return $result;
    }

    public static function getDatosPagoMatricula($inscripcion_id, $matricula_id)
    {
        $result = DB::table('alumno_carrera', 'matriculas', 'cicloslectivos')
                ->select(DB::raw('alumno_carrera.id as inscripcion_id, alumno_carrera.alumno_id,
                    matriculas.matriculaimporte, matriculas.id as matricula_id,
                    cicloslectivos.descripcion as ciclo_descripcion,
                    matriculas.fechavencimientomatricula as matricula_fecha_vencimiento'))
                ->join('matriculas', 'alumno_carrera.carrera_id', '=', 'matriculas.carrera_id')
                ->join('cicloslectivos', 'matriculas.ciclolectivo_id', '=', 'cicloslectivos.id')
                ->whereRaw('alumno_carrera.id ='. $inscripcion_id . ' AND matriculas.id=' . $matricula_id)
                ->get();

        return $result;
    }

    public static function getDatosPagoCuota($inscripcion_id, $matricula_id)
    {
        $result = DB::table('alumno_carrera', 'matriculas', 'cicloslectivos')
                ->select(DB::raw('alumno_carrera.id as inscripcion_id, alumno_carrera.alumno_id,
                    matriculas.cuotaimporte, matriculas.id as matricula_id,
                    cicloslectivos.descripcion as ciclo_descripcion,
                    cicloslectivos.fechafin as fecha_fin_ciclo_lectivo,
                    matriculas.cuotaperiodopagohasta as cuota_pago_hasta_dia'))
                ->join('matriculas', 'alumno_carrera.carrera_id', '=', 'matriculas.carrera_id')
                ->join('cicloslectivos', 'matriculas.ciclolectivo_id', '=', 'cicloslectivos.id')
                ->where('alumno_carrera.id ='. $inscripcion_id . ' AND matriculas.id=' . $matricula_id)
                ->get();

        return $result;
    }

    public static function getCarrerasPorCiclo($ciclo_id)
    {
        $result = DB::table('alumno_carrera', 'carreras', 'matriculas')
                ->select(DB::raw('alumno_carrera.carrera_id as carrera_id, carreras.carrera as carrera'))
                ->join('carreras', 'alumno_carrera.carrera_id', '=', 'carreras.id')
                ->join('matriculas', 'alumno_carrera.carrera_id', '=', 'matriculas.carrera_id')
                ->where('matriculas.ciclolectivo_id', '=', $ciclo_id)
                ->groupBy('alumno_carrera.carrera_id')
                ->get();

        return $result;
    }

    public static function getCarrerasPorCicloAlumno($alumno_id, $ciclo_id)
    {
        $result = DB::table('alumno_carrera', 'carreras')//, 'matriculas')
                ->select(DB::raw('alumno_carrera.id as inscripcion_id, alumno_carrera.carrera_id as carrera_id, carreras.carrera as carrera'))//, matriculas.id'))
                ->join('carreras', 'alumno_carrera.carrera_id', '=', 'carreras.id')
                //->join('matriculas', 'alumno_carrera.carrera_id', '=', 'matriculas.carrera_id')
                ->whereRaw('alumno_carrera.ciclolectivo_id='. $ciclo_id . ' AND alumno_carrera.alumno_id=' . $alumno_id)
                ->groupBy('alumno_carrera.carrera_id')
                ->get();

        return $result;
    }

    public static function getInscripciones($ciclo, $carrera)
    {
        $result = DB::table('alumno_carrera', 'alumnos', 'personas', 'localidades')
            ->select(DB::raw('personas.id as persona_id, personas.nombre, personas.apellido, personas.nrodocumento,
                personas.sexo, personas.barrio, personas.calle, personas.numero as calle_numero,
                personas.manzana, personas.departamento, localidades.descripcion as localidad, alumno_carrera.id as inscripcion_id, 
                alumno_carrera.alumno_id as alumno_id, alumno_carrera.ciclolectivo_id, alumno_carrera.carrera_id, alumnos.fechaingreso, alumnos.activo'))
            ->join('alumnos', 'alumno_carrera.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('localidades', 'personas.localidad_id', '=', 'localidades.id')
            ->whereRaw('alumno_carrera.ciclolectivo_id=' . $ciclo
                . ' and alumno_carrera.carrera_id=' . $carrera)
            ->orderBy('personas.apellido')
            ->get();

        return $result;
    }

    public static function getInscripcionesPorCiclo($ciclo)
    {
        $result = DB::table('alumno_carrera', 'alumnos', 'personas', 'localidades')
            ->select(DB::raw('personas.nombre, personas.apellido, personas.nrodocumento,
                personas.calle, personas.numero as calle_numero, personas.sexo,
                personas.manzana, personas.departamento, personas.id as persona_id, personas.barrio,
                localidades.descripcion as localidad'))
            ->join('alumnos', 'alumno_carrera.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('localidades', 'personas.localidad_id', '=', 'localidades.id')
            ->where('alumno_carrera.ciclolectivo_id', '=', $ciclo)
            ->orderBy('personas.apellido')
            ->get();

        return $result;
    }

    public static function getTodaslasInscripciones()
    {
        $result = DB::table('alumno_carrera', 'alumnos', 'personas', 'localidades')
            ->select(DB::raw('personas.nombre, personas.apellido, personas.nrodocumento,
                personas.calle, personas.numero as calle_numero, personas.sexo,
                personas.manzana, personas.departamento, personas.id as persona_id, personas.barrio,
                localidades.descripcion as localidad'))
            ->join('alumnos', 'alumno_carrera.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('localidades', 'personas.localidad_id', '=', 'localidades.id')
            ->orderBy('personas.apellido')
            ->get();

        return $result;
    }

    public static function getInscripcionesconcontacto($ciclo, $carrera)
    {
        $result = DB::table('alumno_carrera', 'alumnos', 'personas', 'localidades', 'contacto_persona')
            ->select(DB::raw('personas.id, alumno_carrera.alumno_id as alumno_id, 
                alumno_carrera.ciclolectivo_id, alumno_carrera.carrera_id,
                contacto_persona.contacto_id, contacto_persona.descripcion as contacto'))
            ->join('alumnos', 'alumno_carrera.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('contacto_persona', 'personas.id', '=', 'contacto_persona.persona_id')
            ->join('localidades', 'personas.localidad_id', '=', 'localidades.id')
            ->whereRaw('alumno_carrera.ciclolectivo_id=' . $ciclo
                . ' and alumno_carrera.carrera_id=' . $carrera)
            ->orderBy('personas.apellido')
            ->get();

        return $result;
    }

    public static function getInscripcionesactivosbaja($ciclo, $carrera, $filtro)
    {
        $result = DB::table('alumno_carrera', 'alumnos', 'personas', 'localidades')
            ->select(DB::raw('personas.id as persona_id, personas.nombre, personas.apellido, personas.nrodocumento,
                personas.sexo, personas.barrio, personas.calle, personas.numero as calle_numero,
                personas.manzana, personas.departamento, localidades.descripcion as localidad, 
                alumno_carrera.alumno_id as alumno_id, alumno_carrera.ciclolectivo_id, alumno_carrera.carrera_id, alumnos.fechaingreso, alumnos.activo'))
            ->join('alumnos', 'alumno_carrera.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('localidades', 'personas.localidad_id', '=', 'localidades.id')
            ->whereRaw('alumno_carrera.ciclolectivo_id=' . $ciclo
                . ' and alumno_carrera.carrera_id=' . $carrera . ' and alumnos.activo=' . $filtro)
            ->orderBy('personas.apellido')
            ->get();

        return $result;
    }


}