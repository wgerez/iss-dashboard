<?php

class Matricula extends \Eloquent {
	

	protected $table = 'matriculas';

	public static function verificaExisteMatricula($ciclo, $carrera)
	{
		$result = Matricula::whereRaw(
			'ciclolectivo_id=' . $ciclo . ' and carrera_id=' . $carrera . ' and activo=1')
		    ->count();
		
		return $result;
	}


	public function detallesmatriculaspagos()
	{
		return $this->hasmany('DetalleMatriculaPago','matricula_id');
	}


	public function detallescuotaspagos()
	{
		return $this->hasmany('DetalleCuotaPago','matricula_id');
	}


	public function organizacion()
	{
		return $this->belongsTo('Organizacion');
	}

	public function carrera()
	{
		return $this->belongsTo('Carrera');
	}

	public function ciclolectivo()
	{
		return $this->belongsTo('CicloLectivo');
	}

    public static function getDatosInscriptosMatriculas($carrera_id, $ciclo_id)
    {
        $result = DB::table('alumno_carrera', 'matriculas', 'cicloslectivos', 'alumnos', 'personas')
                ->select(DB::raw('personas.id as persona_id, personas.nombre, personas.apellido, personas.nrodocumento, personas.sexo, personas.barrio, personas.calle, personas.numero as calle_numero, personas.manzana, personas.departamento, alumno_carrera.id as inscripcion_id, alumno_carrera.carrera_id, alumno_carrera.alumno_id, alumno_carrera.ciclolectivo_id as ciclo_inscripcion, matriculas.ciclolectivo_id, matriculas.matriculaimporte, matriculas.id as matricula_id, cicloslectivos.descripcion as ciclo_descripcion, matriculas.fechavencimientomatricula, matriculas.matriculaaplica, matriculas.cuotaaplica, matriculas.mespagocuotainicio, matriculas.mespagocuotafin, matriculas.cuotaimporte, alumnos.fechaingreso, alumnos.activo'))
                ->join('alumnos', 'alumno_carrera.alumno_id', '=', 'alumnos.id')
                ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
                ->join('matriculas', 'alumno_carrera.carrera_id', '=', 'matriculas.carrera_id')
                ->join('cicloslectivos', 'matriculas.ciclolectivo_id', '=', 'cicloslectivos.id')
                ->whereRaw('matriculas.carrera_id ='. $carrera_id . ' and matriculas.ciclolectivo_id = ' . $ciclo_id . ' AND alumnos.activo=1')
                ->get();

        return $result;
    }

    public static function getDatosInscriptosMatriculaActivo($carrera_id, $ciclo_id)
    {
        $result = DB::table('alumno_carrera', 'matriculas', 'cicloslectivos', 'alumnos', 'personas', 'localidades')
                ->select(DB::raw('personas.id as persona_id, personas.nombre, personas.apellido, personas.nrodocumento, personas.sexo, personas.barrio, personas.calle, personas.numero as calle_numero, personas.manzana, personas.departamento, localidades.descripcion as localidad, alumno_carrera.id as inscripcion_id, alumno_carrera.carrera_id, alumno_carrera.alumno_id, alumno_carrera.ciclolectivo_id as ciclo_inscripcion, matriculas.ciclolectivo_id, matriculas.matriculaimporte, matriculas.id as matricula_id, cicloslectivos.descripcion as ciclo_descripcion, matriculas.fechavencimientomatricula, matriculas.matriculaaplica, matriculas.cuotaaplica, matriculas.mespagocuotainicio, matriculas.mespagocuotafin, matriculas.cuotaimporte, alumnos.fechaingreso, alumnos.activo'))
                ->join('alumnos', 'alumno_carrera.alumno_id', '=', 'alumnos.id')
                ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            	->join('localidades', 'personas.localidad_id', '=', 'localidades.id')
                ->join('matriculas', 'alumno_carrera.carrera_id', '=', 'matriculas.carrera_id')
                ->join('cicloslectivos', 'matriculas.ciclolectivo_id', '=', 'cicloslectivos.id')
                ->whereRaw('matriculas.carrera_id ='. $carrera_id . ' and matriculas.ciclolectivo_id = ' . $ciclo_id)
                ->get();

        return $result;
    }

    public static function getDatosCuotasMatriculas($carrera_id, $ciclo_id, $alumno_id)
    {
        $result = DB::table('alumno_carrera', 'matriculas', 'cicloslectivos', 'alumnos', 'personas')
                ->select(DB::raw('personas.id as persona_id, personas.nombre, personas.apellido, personas.nrodocumento, alumno_carrera.id as inscripcion_id, alumno_carrera.carrera_id, alumno_carrera.alumno_id, alumno_carrera.ciclolectivo_id as ciclo_inscripcion, matriculas.ciclolectivo_id, matriculas.matriculaimporte, matriculas.id as matricula_id, cicloslectivos.descripcion as ciclo_descripcion, matriculas.fechavencimientomatricula, matriculas.matriculaaplica, matriculas.cuotaaplica, matriculas.mespagocuotainicio, matriculas.mespagocuotafin, matriculas.cuotaimporte, matriculas.cuotaperiodopagohasta'))
                ->join('alumnos', 'alumno_carrera.alumno_id', '=', 'alumnos.id')
                ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
                ->join('matriculas', 'alumno_carrera.carrera_id', '=', 'matriculas.carrera_id')
                ->join('cicloslectivos', 'matriculas.ciclolectivo_id', '=', 'cicloslectivos.id')
                ->whereRaw('matriculas.carrera_id ='. $carrera_id . ' and matriculas.ciclolectivo_id = ' . $ciclo_id . ' AND alumno_carrera.alumno_id=' . $alumno_id .' AND alumnos.activo=1')
                ->get();

        return $result;
    }

    public static function getDatosInscriptoMatriculaCarrera($carrera_id, $fechadesde, $fechahasta)
    {
        $result = DB::table('alumno_carrera', 'matriculas', 'cicloslectivos', 'alumnos', 'personas')
                ->select(DB::raw('personas.id as persona_id, personas.nombre, personas.apellido, personas.nrodocumento, personas.sexo, personas.barrio, personas.calle, personas.numero as calle_numero, personas.manzana, personas.departamento, alumno_carrera.id as inscripcion_id, alumno_carrera.carrera_id, alumno_carrera.alumno_id, alumno_carrera.ciclolectivo_id as ciclo_inscripcion, matriculas.ciclolectivo_id, matriculas.matriculaimporte, matriculas.id as matricula_id, cicloslectivos.descripcion as ciclo_descripcion, matriculas.fechavencimientomatricula, matriculas.matriculaaplica, matriculas.cuotaaplica, matriculas.mespagocuotainicio, matriculas.mespagocuotafin, matriculas.cuotaimporte, alumnos.fechaingreso, alumnos.activo'))
                ->join('alumnos', 'alumno_carrera.alumno_id', '=', 'alumnos.id')
                ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
                ->join('matriculas', 'alumno_carrera.carrera_id', '=', 'matriculas.carrera_id')
                ->join('cicloslectivos', 'matriculas.ciclolectivo_id', '=', 'cicloslectivos.id')
                ->whereRaw('matriculas.carrera_id ='. $carrera_id . ' AND alumnos.activo=1 and matriculas.fechavencimientomatricula >= "' . $fechadesde . '" AND matriculas.fechavencimientomatricula <= "' . $fechahasta . '"')
                ->get();

        return $result;
    }

    public static function getDatosInscriptoMatricula($carrera_id, $alumno_id, $fechadesde, $fechahasta)
    {
        $result = DB::table('alumno_carrera', 'matriculas', 'cicloslectivos', 'alumnos', 'personas')
                ->select(DB::raw('personas.id as persona_id, personas.nombre, personas.apellido, personas.nrodocumento, alumno_carrera.id as inscripcion_id, alumno_carrera.carrera_id, alumno_carrera.alumno_id, alumno_carrera.ciclolectivo_id as ciclo_inscripcion, matriculas.ciclolectivo_id, matriculas.matriculaimporte, matriculas.id as matricula_id, cicloslectivos.descripcion as ciclo_descripcion, matriculas.fechavencimientomatricula, matriculas.matriculaaplica, matriculas.cuotaaplica, matriculas.mespagocuotainicio, matriculas.mespagocuotafin, matriculas.cuotaimporte'))
                ->join('alumnos', 'alumno_carrera.alumno_id', '=', 'alumnos.id')
                ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
                ->join('matriculas', 'alumno_carrera.carrera_id', '=', 'matriculas.carrera_id')
                ->join('cicloslectivos', 'matriculas.ciclolectivo_id', '=', 'cicloslectivos.id')
                ->whereRaw('matriculas.carrera_id ='. $carrera_id . ' AND alumno_carrera.alumno_id=' . $alumno_id .' AND alumnos.activo=1 and matriculas.fechavencimientomatricula >= "' . $fechadesde . '" AND matriculas.fechavencimientomatricula <= "' . $fechahasta . '"')
                ->get();

        return $result;
    }


}