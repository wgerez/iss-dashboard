<?php

class DetalleCuotaPago extends \Eloquent {
	
	protected $table = 'detallescuotaspagos';


	/*Relaciones*/

	public function matricula()
    {
        return $this->belongsTo('Matricula');
    }

    
	public function alumno()
	{
		return $this->belongsTo('Alumno');
	}

    public static function getDatosPagos($inscripcion_id, $matricula_id, $ciclo_id)
    {
        $result = DB::table('alumno_carrera', 'detallescuotaspagos', 'matriculas')
                ->select(DB::raw('detallescuotaspagos.matricula_id, detallescuotaspagos.alumno_id, detallescuotaspagos.fechavencimiento, detallescuotaspagos.fechapago, detallescuotaspagos.importe, detallescuotaspagos.id as pago_id, detallescuotaspagos.estado, detallescuotaspagos.mescuota, alumno_carrera.carrera_id, matriculas.ciclolectivo_id'))
                ->join('detallescuotaspagos', 'alumno_carrera.id', '=', 'detallescuotaspagos.inscripcion_id')
                ->join('matriculas', 'detallescuotaspagos.matricula_id', '=', 'matriculas.id')
                ->whereRaw('detallescuotaspagos.inscripcion_id = ' . $inscripcion_id . ' AND detallescuotaspagos.matricula_id = ' . $matricula_id . ' AND matriculas.ciclolectivo_id = ' . $ciclo_id)
                ->get();

        return $result;
    }

    public static function getDatosPagoRealizado($inscripcion_id, $matricula_id)
    {
        $result = DB::table('alumno_carrera','detallescuotaspagos', 'cicloslectivos')
                ->select(DB::raw('detallescuotaspagos.matricula_id, detallescuotaspagos.alumno_id, detallescuotaspagos.fechavencimiento, detallescuotaspagos.fechapago, detallescuotaspagos.porcentajerecargo,
                    detallescuotaspagos.porcentajedescuento, detallescuotaspagos.importe, cicloslectivos.descripcion as ciclo_descripcion, detallescuotaspagos.id, detallescuotaspagos.efectivo, detallescuotaspagos.tarjetacredito, detallescuotaspagos.tarjetadebito, detallescuotaspagos.cuentabancaria, detallescuotaspagos.cheque, detallescuotaspagos.observaciones'))
                ->join('cicloslectivos', 'alumno_carrera.ciclolectivo_id', '=', 'cicloslectivos.id')
                ->join('detallescuotaspagos', 'alumno_carrera.id', '=', 'detallescuotaspagos.inscripcion_id')
                ->whereRaw('detallescuotaspagos.inscripcion_id = ' . $inscripcion_id .
                    ' and detallescuotaspagos.matricula_id = ' . $matricula_id)
                ->get();

        return $result;
    }


    public function formapagocuota()
    {
        return $this->belongsTo('Formapagocuota');
    }
   
}