<?php

class DetalleMatriculaPago extends \Eloquent {
	
	protected $table = 'detallesmatriculaspagos';


	/*Relaciones*/

	public function matricula()
    {
        return $this->belongsTo('Matricula');
    }

    
	public function alumno()
	{
		return $this->belongsTo('Alumno');
	}

    public static function getCuotasPagadas($inscripcion_id, $matricula_id)
    {
        return DetalleMatriculaPago::whereRaw('inscripcion_id ='. $inscripcion_id . ' AND matricula_id =' . $matricula_id)->get();
    }

    public static function getDatosPagoRealizado($inscripcion_id, $mes_cuota, $matricula_id)
    {
        $result = DB::table('alumno_carrera','detallesmatriculaspagos', 'cicloslectivos')
                ->select(DB::raw('detallesmatriculaspagos.matricula_id, detallesmatriculaspagos.alumno_id, detallesmatriculaspagos.fechavencimiento, detallesmatriculaspagos.fechapago,
                    detallesmatriculaspagos.observaciones, detallesmatriculaspagos.porcentajerecargo,
                    detallesmatriculaspagos.porcentajedescuento, detallesmatriculaspagos.importe,
                    cicloslectivos.descripcion as ciclo_descripcion, detallesmatriculaspagos.fechavencimiento,
                    detallesmatriculaspagos.id as pago_id, detallesmatriculaspagos.importeparcial, detallesmatriculaspagos.totalparcial, detallesmatriculaspagos.saldo, detallesmatriculaspagos.efectivo, detallesmatriculaspagos.tarjetacredito, detallesmatriculaspagos.tarjetadebito, detallesmatriculaspagos.cuentabancaria'))
                ->join('cicloslectivos', 'alumno_carrera.ciclolectivo_id', '=', 'cicloslectivos.id')
                ->join('detallesmatriculaspagos', 'alumno_carrera.id', '=', 'detallesmatriculaspagos.inscripcion_id')
                ->whereRaw('detallesmatriculaspagos.inscripcion_id = ' . $inscripcion_id .
                    ' and detallesmatriculaspagos.mescuota = ' . $mes_cuota .
                    ' and detallesmatriculaspagos.matricula_id = ' . $matricula_id)
                ->get();

        return $result;
    }

    public static function getDatosPagos($inscripcion_id, $matricula_id)
    {
        //return DetalleMatriculaPago::whereRaw('inscripcion_id ='. $inscripcion_id . ' AND matricula_id =' . $matricula_id . ' and detallesmatriculaspagos.mescuota = 0')->get();
        $result = DB::table('alumno_carrera', 'detallesmatriculaspagos')
                ->select(DB::raw('detallesmatriculaspagos.matricula_id, detallesmatriculaspagos.alumno_id, detallesmatriculaspagos.fechavencimiento, detallesmatriculaspagos.fechapago, detallesmatriculaspagos.importe, detallesmatriculaspagos.fechavencimiento, detallesmatriculaspagos.id as pago_id, detallesmatriculaspagos.estado, detallesmatriculaspagos.totalparcial, detallesmatriculaspagos.importeparcial'))
                ->join('detallesmatriculaspagos', 'alumno_carrera.id', '=', 'detallesmatriculaspagos.inscripcion_id')
                ->whereRaw('detallesmatriculaspagos.inscripcion_id = ' . $inscripcion_id . ' AND detallesmatriculaspagos.matricula_id = ' . $matricula_id .' AND detallesmatriculaspagos.mescuota = 0')
                ->get();

        return $result;
    }

    public static function getInscripcionesMatricula($matricula_id)
    {
        $result = DB::table('alumno_carrera', 'alumnos', 'personas', 'localidades', 'detallesmatriculaspagos')
            ->select(DB::raw('personas.id as persona_id, personas.nombre, personas.apellido, personas.nrodocumento,
                personas.sexo, personas.barrio, personas.calle, personas.numero as calle_numero,
                personas.manzana, personas.departamento, localidades.descripcion as localidad, 
                alumno_carrera.alumno_id as alumno_id, alumno_carrera.ciclolectivo_id, alumno_carrera.carrera_id'))
            ->join('detallesmatriculaspagos', 'alumno_carrera.id', '=', 'detallesmatriculaspagos.inscripcion_id')
            ->join('alumnos', 'alumno_carrera.alumno_id', '=', 'alumnos.id')
            ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->join('localidades', 'personas.localidad_id', '=', 'localidades.id')
            ->whereRaw('detallesmatriculaspagos.matricula_id=' . $matricula_id)
            ->orderBy('personas.apellido')
            ->get();

        return $result;
    }

}