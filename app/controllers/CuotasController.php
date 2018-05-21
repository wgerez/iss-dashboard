<?php
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CuotasController extends \BaseController {

    private $_data;
    private $_rules;
    private $_messages;

    const OPERACION_EXITOSA = 1;
    const OPERACION_FALLIDA = 2;
    const OPERACION_CANCELADA = 3;
    const OPERACION_INFO = 4;
    const NO_EXISTE_CICLO_ACTIVO = 5;
    const NO_EXISTE_INSCRIPCION = 6;
    const NO_TIENE_BECA = 7;

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	public function getListado()
	{
        $organizaciones = Organizacion::lists('nombre', 'id');
        $organizaciones[0] = 'Seleccionar';
        ksort($organizaciones);

        return View::make('cuotas.listado')
            ->with('organizaciones', $organizaciones)
            ->with('menu', ModulosHelper::MENU_GESTION_CONTABLE)
            ->with('submenu', ModulosHelper::SUBMENU_PAGO_CUOTAS)
            ->with('leer', Session::get('PAGOCUOTAS_LEER'))
            ->with('editar', Session::get('PAGOCUOTAS_EDITAR'))
            ->with('imprimir', Session::get('PAGOCUOTAS_IMPRIMIR'))
            ->with('eliminar', Session::get('PAGOCUOTAS_ELIMINAR'));
		//return PDF::load($html, 'A4', 'portrait')->show();
	}

    public function postObtenercuotaporcarrerayciclo()
    {
        $organizacion_id = Input::get('organizacion');
        $ciclo_id = Input::get('ciclo');
        $carrera_id = Input::get('carrera');
        $cuotas = array();
        $cuotasinscriptos = array();

        $inscripciones = Matricula::getDatosInscriptosMatriculas($carrera_id, $ciclo_id);

        foreach ($inscripciones as $value) {
            $detalle_matricula = DetalleMatriculaPago::whereRaw('inscripcion_id = '. $value->inscripcion_id .' AND matricula_id = '. $value->matricula_id)->first();

            if ($detalle_matricula) {
                if ($value->ciclolectivo_id == $value->ciclo_inscripcion) {
                    $cuotasinscriptos[] = ['nombre' => $value->nombre, 'apellido' => $value->apellido, 'nrodocumento' => $value->nrodocumento, 'inscripcion_id' => $value->inscripcion_id, 'carrera_id' => $value->carrera_id, 'alumno_id' => $value->alumno_id, 'ciclo_inscripcion' => $value->ciclo_inscripcion, 'ciclolectivo_id' => $value->ciclolectivo_id, 'matriculaimporte' => $value->matriculaimporte, 'matricula_id' => $value->matricula_id, 'ciclo_descripcion' => $value->ciclo_descripcion, 'fechavencimientomatricula' => $value->fechavencimientomatricula, 'matriculaaplica' => $value->matriculaaplica, 'cuotaaplica' => $value->cuotaaplica, 'mespagocuotainicio' => $value->mespagocuotainicio, 'mespagocuotafin' => $value->mespagocuotafin, 'cuotaimporte' => $value->cuotaimporte];
                }
            }
        }

        foreach ($inscripciones as $value) {
            $detalle_matricula = DetalleMatriculaPago::whereRaw('inscripcion_id = '. $value->inscripcion_id .' AND matricula_id = '. $value->matricula_id)->first();

            if ($detalle_matricula) {
                if ($value->ciclolectivo_id > $value->ciclo_inscripcion) {
                    $cuotasinscriptos[] = ['nombre' => $value->nombre, 'apellido' => $value->apellido, 'nrodocumento' => $value->nrodocumento, 'inscripcion_id' => $value->inscripcion_id, 'carrera_id' => $value->carrera_id, 'alumno_id' => $value->alumno_id, 'ciclo_inscripcion' => $value->ciclo_inscripcion, 'ciclolectivo_id' => $value->ciclolectivo_id, 'matriculaimporte' => $value->matriculaimporte, 'matricula_id' => $value->matricula_id, 'ciclo_descripcion' => $value->ciclo_descripcion, 'fechavencimientomatricula' => $value->fechavencimientomatricula, 'matriculaaplica' => $value->matriculaaplica, 'cuotaaplica' => $value->cuotaaplica, 'mespagocuotainicio' => $value->mespagocuotainicio, 'mespagocuotafin' => $value->mespagocuotafin, 'cuotaimporte' => $value->cuotaimporte];
                }
            }
        }

        if (isset($cuotasinscriptos)) {
            asort($cuotasinscriptos);
            
            foreach ($cuotasinscriptos as $value) {
                $detalle_pagos = DetalleCuotaPago::getDatosPagos($value['inscripcion_id'], $value['matricula_id'], $ciclo_id);

                if ($value['mespagocuotafin'] == NULL || $value['mespagocuotafin'] == '') {
                    $value['mespagocuotafin'] = 12;
                }

                $beca = Beca::whereRaw('inscripcion_id =' . $value['inscripcion_id'] . ' AND ciclolectivo_id =' . $value['ciclolectivo_id'] . ' and becado=1')->get();
                $becas = (count($beca)) ? $beca[0] : self::NO_TIENE_BECA;

                $cuotas[] = ['nombre' => $value['nombre'], 'apellido' => $value['apellido'], 'nrodocumento' => $value['nrodocumento'], 'inscripcion_id' => $value['inscripcion_id'], 'carrera_id' => $value['carrera_id'], 'alumno_id' => $value['alumno_id'], 'ciclo_inscripcion' => $value['ciclo_inscripcion'], 'ciclolectivo_id' => $value['ciclolectivo_id'], 'matriculaimporte' => $value['matriculaimporte'], 'matricula_id' => $value['matricula_id'], 'ciclo_descripcion' => $value['ciclo_descripcion'], 'fechavencimientomatricula' => $value['fechavencimientomatricula'], 'matriculaaplica' => $value['matriculaaplica'], 'cuotaaplica' => $value['cuotaaplica'], 'mespagocuotainicio' => $value['mespagocuotainicio'], 'mespagocuotafin' => $value['mespagocuotafin'], 'cuotaimporte' => $value['cuotaimporte'], 'detalle_cuotas' => $detalle_pagos, 'beca' => $becas];
            }
        }

        /*highlight_string(var_export($cuotas,true));
        exit;
highlight_string(var_export($cuotas,true));
        exit;*/
        return Response::json($cuotas);
    }

    public function postObtenercuotaporalumno()
    {
        $alumno_id = Input::get('alumno_id');
        $ciclo_id = Input::get('ciclo');
        $carrera_id = Input::get('carrera');

        $cuotas = Matricula::getDatosCuotasMatriculas($carrera_id, $ciclo_id, $alumno_id);

        if (count($cuotas) > 0) {
            $detalle_matricula = DetalleMatriculaPago::whereRaw('inscripcion_id = '. $cuotas[0]->inscripcion_id .' AND matricula_id = '. $cuotas[0]->matricula_id)->first();

            if (count($detalle_matricula) > 0) {
                foreach ($cuotas as $value) {
                    $detalle_pagos = DetalleCuotaPago::getDatosPagos($value->inscripcion_id, $value->matricula_id, $ciclo_id);

                    if ($detalle_pagos) {
                        $value->detalle_cuotas = $detalle_pagos;
                    } else {
                        $value->detalle_cuotas = '';
                    }

                    $beca = Beca::whereRaw('inscripcion_id =' . $value->inscripcion_id . ' AND ciclolectivo_id =' . $value->ciclolectivo_id . ' and becado=1')->get();
                    $value->beca = (count($beca)) ? $beca[0] : self::NO_TIENE_BECA;
                }
            } else {
                $cuotas = [];
            }
        }
/*highlight_string(var_export($cuotas,true));
        exit;*/
        return Response::json($cuotas);
    }

    public function postObtenerdeudasalumnos()
    {
        $organizacion_id = Input::get('organizacion');
        $ciclo_id = Input::get('ciclo');
        $carrera_id = Input::get('carrera');
        $fechadesde = Input::get('fechadesde');
        $fechahasta = Input::get('fechahasta');
        $cuotas = array();
        $cuotasinscriptos = array();

        $inscripciones = Matricula::getDatosInscriptosMatriculas($carrera_id, $ciclo_id);//getDatosInscriptoMatriculaCarrera($carrera_id, $fechadesde, $fechahasta);

        foreach ($inscripciones as $value) {
            $detalle_matricula = DetalleMatriculaPago::whereRaw('inscripcion_id = '. $value->inscripcion_id .' AND matricula_id = '. $value->matricula_id)->first();

            if ($detalle_matricula) {
                $cuotasinscriptos[] = ['nombre' => $value->nombre, 'apellido' => $value->apellido, 'nrodocumento' => $value->nrodocumento, 'inscripcion_id' => $value->inscripcion_id, 'carrera_id' => $value->carrera_id, 'alumno_id' => $value->alumno_id, 'ciclo_inscripcion' => $value->ciclo_inscripcion, 'ciclolectivo_id' => $value->ciclolectivo_id, 'matriculaimporte' => $value->matriculaimporte, 'matricula_id' => $value->matricula_id, 'ciclo_descripcion' => $value->ciclo_descripcion, 'fechavencimientomatricula' => $value->fechavencimientomatricula, 'matriculaaplica' => $value->matriculaaplica, 'cuotaaplica' => $value->cuotaaplica, 'mespagocuotainicio' => $value->mespagocuotainicio, 'mespagocuotafin' => $value->mespagocuotafin, 'cuotaimporte' => $value->cuotaimporte, 'saldo' => $detalle_matricula->saldo, 'abonada' => 1];
            } else {
                $cuotasinscriptos[] = ['nombre' => $value->nombre, 'apellido' => $value->apellido, 'nrodocumento' => $value->nrodocumento, 'inscripcion_id' => $value->inscripcion_id, 'carrera_id' => $value->carrera_id, 'alumno_id' => $value->alumno_id, 'ciclo_inscripcion' => $value->ciclo_inscripcion, 'ciclolectivo_id' => $value->ciclolectivo_id, 'matriculaimporte' => $value->matriculaimporte, 'matricula_id' => $value->matricula_id, 'ciclo_descripcion' => $value->ciclo_descripcion, 'fechavencimientomatricula' => $value->fechavencimientomatricula, 'matriculaaplica' => $value->matriculaaplica, 'cuotaaplica' => $value->cuotaaplica, 'mespagocuotainicio' => $value->mespagocuotainicio, 'mespagocuotafin' => $value->mespagocuotafin, 'cuotaimporte' => $value->cuotaimporte, 'saldo' => 0, 'abonada' => 0];
            }
        }

        if (isset($cuotasinscriptos)) {
            asort($cuotasinscriptos);
            
            foreach ($cuotasinscriptos as $value) {
                $detalle_pagos = DetalleCuotaPago::getDatosPagos($value['inscripcion_id'], $value['matricula_id'], $value['ciclolectivo_id']);

                if ($value['mespagocuotafin'] == NULL || $value['mespagocuotafin'] == '') {
                    $value['mespagocuotafin'] = 12;
                }

                if ($value['saldo'] == 0) {
                    $saldo = 0;
                } else {
                    $saldo = $value['saldo'];
                }

                $beca = Beca::whereRaw('inscripcion_id =' . $value['inscripcion_id'] . ' AND ciclolectivo_id =' . $value['ciclolectivo_id'] . ' and becado=1')->get();
                $becas = (count($beca)) ? $beca[0] : self::NO_TIENE_BECA;
                
                if (!count($beca) > 0) {
                    $cuotas[] = ['nombre' => $value['nombre'], 'apellido' => $value['apellido'], 'nrodocumento' => $value['nrodocumento'], 'inscripcion_id' => $value['inscripcion_id'], 'carrera_id' => $value['carrera_id'], 'alumno_id' => $value['alumno_id'], 'ciclo_inscripcion' => $value['ciclo_inscripcion'], 'ciclolectivo_id' => $value['ciclolectivo_id'], 'matriculaimporte' => $value['matriculaimporte'], 'matricula_id' => $value['matricula_id'], 'ciclo_descripcion' => $value['ciclo_descripcion'], 'fechavencimientomatricula' => $value['fechavencimientomatricula'], 'matriculaaplica' => $value['matriculaaplica'], 'cuotaaplica' => $value['cuotaaplica'], 'mespagocuotainicio' => $value['mespagocuotainicio'], 'mespagocuotafin' => $value['mespagocuotafin'], 'cuotaimporte' => $value['cuotaimporte'], 'saldo' => $saldo, 'detalle_cuotas' => $detalle_pagos, 'beca' => $becas, 'abonada' => $value['abonada']];
                }
            }
        }

        /*highlight_string(var_export($cuotas,true));
        exit;*/
        return Response::json($cuotas);
    }

    public function postObtenerdeudaporalumno()
    {
        $alumno_id = Input::get('alumno_id');
        $ciclo_id = Input::get('ciclo');
        $carrera_id = Input::get('carrera');
        $fechadesde = Input::get('fechadesde');
        $fechahasta = Input::get('fechahasta');

        $inscripciones = Matricula::getDatosCuotasMatriculas($carrera_id, $ciclo_id, $alumno_id);

        foreach ($inscripciones as $value) {
            $detalle_matricula = DetalleMatriculaPago::whereRaw('inscripcion_id = '. $value->inscripcion_id .' AND matricula_id = '. $value->matricula_id)->first();
            $saldo = 0;

            $detalle_pagos = DetalleCuotaPago::getDatosPagos($value->inscripcion_id, $value->matricula_id, $value->ciclolectivo_id);

            if (count($detalle_pagos) > 0) {
                $detalle_cuotas = $detalle_pagos;
            } else {
                $detalle_cuotas = '';
            }

            $beca = Beca::whereRaw('inscripcion_id =' . $value->inscripcion_id . ' AND ciclolectivo_id =' . $value->ciclolectivo_id . ' and becado=1')->get();
            $becas = (count($beca)) ? $beca[0] : self::NO_TIENE_BECA;

            if (count($detalle_matricula) > 0) {
                if ($detalle_matricula->saldo == 0) {
                    $saldo = 0;
                } else {
                    $saldo = $detalle_matricula->saldo;
                }

                $cuotas[] = ['nombre' => $value->nombre, 'apellido' => $value->apellido, 'nrodocumento' => $value->nrodocumento, 'inscripcion_id' => $value->inscripcion_id, 'carrera_id' => $value->carrera_id, 'alumno_id' => $value->alumno_id, 'ciclo_inscripcion' => $value->ciclo_inscripcion, 'ciclolectivo_id' => $value->ciclolectivo_id, 'matriculaimporte' => $value->matriculaimporte, 'matricula_id' => $value->matricula_id, 'ciclo_descripcion' => $value->ciclo_descripcion, 'fechavencimientomatricula' => $value->fechavencimientomatricula, 'matriculaaplica' => $value->matriculaaplica, 'cuotaaplica' => $value->cuotaaplica, 'mespagocuotainicio' => $value->mespagocuotainicio, 'mespagocuotafin' => $value->mespagocuotafin, 'cuotaimporte' => $value->cuotaimporte, 'saldo' => $saldo, 'detalle_cuotas' => $detalle_cuotas, 'beca' => $becas, 'abonada' => 1];
            } else {
                $cuotas[] = ['nombre' => $value->nombre, 'apellido' => $value->apellido, 'nrodocumento' => $value->nrodocumento, 'inscripcion_id' => $value->inscripcion_id, 'carrera_id' => $value->carrera_id, 'alumno_id' => $value->alumno_id, 'ciclo_inscripcion' => $value->ciclo_inscripcion, 'ciclolectivo_id' => $value->ciclolectivo_id, 'matriculaimporte' => $value->matriculaimporte, 'matricula_id' => $value->matricula_id, 'ciclo_descripcion' => $value->ciclo_descripcion, 'fechavencimientomatricula' => $value->fechavencimientomatricula, 'matriculaaplica' => $value->matriculaaplica, 'cuotaaplica' => $value->cuotaaplica, 'mespagocuotainicio' => $value->mespagocuotainicio, 'mespagocuotafin' => $value->mespagocuotafin, 'cuotaimporte' => $value->cuotaimporte, 'saldo' => $saldo, 'detalle_cuotas' => $detalle_cuotas, 'beca' => $becas, 'abonada' => 0];
            }
        }

/*highlight_string(var_export($cuotas,true));
        exit;*/
        return Response::json($cuotas);
    }

    public function getPagar()
    {
        $organizaciones = Organizacion::lists('nombre', 'id');
        //$organizaciones[0] = 'Seleccionar';
        //ksort($organizaciones);

        return View::make('cuotas.gestionPagos')
            ->with('organizaciones', $organizaciones)
            ->with('menu', ModulosHelper::MENU_GESTION_CONTABLE)
            ->with('submenu', ModulosHelper::SUBMENU_PAGO_CUOTAS)
            ->with('leer', Session::get('PAGOCUOTAS_LEER'))
            ->with('editar', Session::get('PAGOCUOTAS_EDITAR'))
            ->with('imprimir', Session::get('PAGOCUOTAS_IMPRIMIR'))
            ->with('eliminar', Session::get('PAGOCUOTAS_ELIMINAR'));
    }

    public function postObteneralumnobecado()
    {
        $dni = Input::get('txt_alumno');
        $alumnos = Beca::getAlumnosBecadosPorDNI($dni);

        if (count($alumnos) == 0) {
            $alumno = 0;
        } else {
            $alumno = 1;
        }

        return Response::json($alumno);
    }

    public function postObtenercarrerasinscripciones()
    {
        $alumno_id = Input::get('alumno_id');
        $carreras  = AlumnoCarrera::getDatosInscripcionAlumno($alumno_id);
        
        if (count($carreras) == 0) //{
            return self::NO_EXISTE_INSCRIPCION;

        return Response::json($carreras);
    }

    public function postObtenercicloinscripciones()
    {
        $alumno_id = Input::get('alumno_id');
        $ciclo  = AlumnoCarrera::getCarrerasInscripciones($alumno_id);
        $carreras  = AlumnoCarrera::getDatosInscripcionAlumno($alumno_id);

        if (count($ciclo) == 0) {
            return self::NO_EXISTE_INSCRIPCION;
        } else {
            foreach ($ciclo as $value) {
                $cicloinscripcion = $value->ciclo;
            }

            foreach ($carreras as $value) {
                $cicloinicio = CicloLectivo::whereRaw('id = '. $value->ciclolectivo_id)->first()->descripcion;

                if ($cicloinscripcion == $cicloinicio || $cicloinicio > $cicloinscripcion) {
                    $ciclos[] = ['ciclolectivo_id' => $value->ciclolectivo_id, 'ciclo' => $cicloinicio];
                }
            }
        }

        /*highlight_string(var_export($ciclos,true));
        exit;*/
        return Response::json($ciclos);
    }

    public function postObtenercuotas()
    {
        $ciclo_id = Input::get('ciclo');
        $carrera_id = Input::get('carrera');
        $alumno_id = Input::get('alumno_id');
        $mespagocuotafin = 12;

        $cuotafin = Matricula::whereRaw('carrera_id = '. $carrera_id .' AND ciclolectivo_id = '. $ciclo_id)->first();

        if ($cuotafin) {
	        if ($cuotafin->mespagocuotafin == NULL || $cuotafin->mespagocuotafin == '') {
	        	$cuotafin->mespagocuotafin = 12;
                $mespagocuotafin = $cuotafin->mespagocuotafin;
	        }

	        $meses = ['vacio', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

	        $detalles = DetalleCuotaPago::whereRaw('matricula_id= '. $cuotafin->id. ' AND alumno_id = '. $alumno_id)->get();
            
            if (count($detalles)) {
                $detalle = $detalles->last();
    		    $mespagocuotainicio = $detalle->mescuota;
			} else {
		    	$mespagocuotainicio = $cuotafin->mespagocuotainicio - 1;
		    }

            if ($mespagocuotainicio < 13) {
    	        for ($i=0; $i < count($meses); $i++) { 
    	        	if ($i > $mespagocuotainicio || $cuotafin->mespagocuotafin == $i) {
                        $cuotasmeses[] = ['id' => $i, 'mes' => $meses[$i], 'matricula_id' => $cuotafin->id];
    	        	}
    	        }
            }

    	    $cuotafin->cuotasmeses = $cuotasmeses;

            $cantidad_cuota = $mespagocuotafin - $mespagocuotainicio;
            if ($cantidad_cuota == 0) $cuotafin = 'mensaje';
            
	    }

/*highlight_string(var_export($cuotafin,true));
        exit;*/
        return Response::json($cuotafin);
    }

    public function postObtenercarrerasporciclo()
    {
        $ciclo_id = Input::get('ciclo');
        $alumno_id = Input::get('alumno_id');

        //$carreras = AlumnoCarrera::getCarrerasPorCicloAlumno(290, 11);
        $carreras = AlumnoCarrera::whereRaw('alumno_id = '. $alumno_id)->get();

        if (count($carreras) == 0) {
            $carrerass = 'El alumno no posee carrera inscriptas!';
        } else {
            foreach ($carreras as $value) {
                $carrera = Carrera::whereRaw('id = '. $value->carrera_id)->first()->carrera;
                $ciclocarrera = $value->ciclolectivo_id;

                $carrerass[] = ['inscripcion_id' => $value->id, 'carrera_id' => $value->carrera_id, 'carrera' => $carrera];
            }

            foreach ($carrerass as $value) {
                $matricula = Matricula::whereRaw('carrera_id = '. $value['carrera_id']. ' AND ciclolectivo_id = '.$ciclo_id)->first();

                $detalle_cuotas = DetalleMatriculaPago::whereRaw('matricula_id= '. $matricula->id . ' AND alumno_id = '. $alumno_id)->get();
            }

            if (count($detalle_cuotas) == 0) {
                $carrerass = 'El alumno no tiene abonada la matricula de este ciclo!';
            }
        }

        /*highlight_string(var_export($carrerass,true));
        exit;*/
        return Response::json($carrerass);
    }

    public function postObtenerinscripcionescarreras()
    {
        $carrera_id = Input::get('carrera');
        $alumno_id = Input::get('alumno_id');

        $carreras = AlumnoCarrera::whereRaw('alumno_id ='. $alumno_id . ' AND carrera_id = '. $carrera_id)->first()->id;

        if (count($carreras) == 0)
            $carreras = self::NO_EXISTE_INSCRIPCION;

        return Response::json($carreras);
    }

    public function postGuardar()
    {
        $pago_id = Input::get('txt_pago_id');

        if ($pago_id == 0) {
            $this->_data = array(
                'alumno'    => Input::get('txt_alumno_id'),
                'carrera'  => Input::get('cboCarrera'),
                'matricula'  => Input::get('txt_matricula_id')
            );

            $this->_rules = array(
                'alumno'    => 'required',
                'carrera'  => 'required',
                'matricula'  => 'required'
            );

            $this->_messages = array(
                'required' => 'Campo Obligatorio',
            );

            $validator = Validator::make($this->_data, $this->_rules, $this->_messages);

            $mesescargados = Input::get('mesescargados');
            $cantmeses = count($mesescargados);
            $detalle = DetalleCuotaPago::all();

            if (count($detalle) > 0) {
                $ultimodetalle = $detalle->last();
                $id_detalle = $ultimodetalle->id + 1;
            } else {
                $id_detalle = 1;
            }
            
            if ($validator->fails()) {
                Session::flash('message', 'ERROR AL INTENTAR GUARDAR LA CUOTA A PAGAR.');
                Session::flash('message_type', self::OPERACION_FALLIDA);
                return Redirect::to('cuotas/pagar')
                    ->withErrors($validator)
                    ->withInput();
            } else {
                if ($cantmeses == 0) {
                    Session::flash('message', 'ERROR AL INTENTAR GUARDAR LA CUOTA A PAGAR.');
                    Session::flash('message_type', self::OPERACION_FALLIDA);
                    return Redirect::to('cuotas/pagar')
                        ->withErrors($validator)
                        ->withInput();
                }

                $persona_id        = Input::get('txt_persona_id');
                $efectivo          = Input::get('txt_efectivo');
                $tarjeta           = Input::get('txt_tarjeta');
                $debito            = Input::get('txt_debito');
                $bancaria          = Input::get('txt_bancaria');
                $cheque            = Input::get('txt_cheque');
                $total_apagar      = Input::get('txt_total_apagar');
                $txt_alumno_id     = Input::get('txt_alumno_id');
                $inscripcion_id    = Input::get('txt_inscripcion_id');

                $detalle_cuotas = DetalleMatriculaPago::whereRaw('inscripcion_id= '. $inscripcion_id. ' AND alumno_id = '. $txt_alumno_id)->get();

                if (count($detalle_cuotas) == 0) {
                    Session::flash('message', 'ERROR AL INTENTAR GUARDAR. EL ALUMNO NO TIENE PAGADO LA MATRICULA');
                    Session::flash('message_type', self::OPERACION_FALLIDA);
                    return Redirect::to('cuotas/pagar')
                        ->withInput();
                }

                if ($efectivo == '' && $tarjeta == '' && $debito == '' && $bancaria == '' && $cheque == '') {
                    Session::flash('message', 'ERROR AL INTENTAR GUARDAR EL PAGO. ESPECIFIQUE FORMA DE PAGO');
                    Session::flash('message_type', self::OPERACION_FALLIDA);
                    return Redirect::to('cuotas/pagar')
                        ->withInput();
                }

                if ($efectivo == '') $efectivo = 0;
            
                if ($tarjeta == '') $tarjeta = 0;
                
                if ($debito == '') $debito = 0;
                
                if ($bancaria == '') $bancaria = 0;

                if ($cheque == '') $cheque = 0;

                $totalcalculado = $efectivo + $tarjeta + $debito + $bancaria + $cheque;

                if ($totalcalculado < $total_apagar) {
                    Session::flash('message', 'ERROR AL INTENTAR GUARDAR EL PAGO. LAS FORMA DE PAGO DEBE SER IGUAL AL TOTAL A ABONAR');
                    Session::flash('message_type', self::OPERACION_FALLIDA);
                    return Redirect::to('cuotas/pagar')
                        ->withInput();
                }

                if ($totalcalculado > $total_apagar) {
                    Session::flash('message', 'ERROR AL INTENTAR GUARDAR EL PAGO. LAS FORMA DE PAGO DEBE SER IGUAL AL TOTAL A ABONAR');
                    Session::flash('message_type', self::OPERACION_FALLIDA);
                    return Redirect::to('cuotas/pagar')
                        ->withInput();
                }

                //$fecha_nacimiento = FechaHelper::getFechaParaGuardar(Input::get('fechanacimiento'));
                $descuentos = Input::get('txtdescuentos');
                $recargos = Input::get('txtrecargos');
                $importes = Input::get('txt_importes');
                $totals = Input::get('txt_totals');
                $adividir = 0;
                $efectivog = 0;
                $tarjetag = 0;
                $debitog = 0;
                $bancariag = 0;
                $chequeg = 0;

                if (!$efectivo == 0) {
                    $adividir = $adividir + 1;
                    $efectivo = 1;
                }

                if (!$tarjeta == 0) {
                    $adividir = $adividir + 1;
                    $tarjeta = 1;
                }

                if (!$debito == 0) {
                    $adividir = $adividir + 1;
                    $debito = 1;
                }

                if (!$bancaria == 0) {
                    $adividir = $adividir + 1;
                    $bancaria = 1;
                }

                if (!$cheque == 0) {
                    $adividir = $adividir + 1;
                    $cheque = 1;
                }

                for ($i=0; $i < $cantmeses; $i++) { 
                    if ($efectivo == 1) {
                        $totefectivo = $totals[$i] / $adividir;
                        $efectivog = $efectivog + $totefectivo;
                    }

                    if ($tarjeta == 1) {
                        $tottarjeta = $totals[$i] / $adividir;
                        $tarjetag = $tarjetag + $tottarjeta;
                    }

                    if ($debito == 1) {
                        $totdebito = $totals[$i] / $adividir;
                        $debitog = $debitog + $totdebito;
                    }

                    if ($bancaria == 1) {
                        $totbancaria = $totals[$i] / $adividir;
                        $bancariag = $bancariag + $totbancaria;
                    }

                    if ($cheque == 1) {
                        $totcheque = $totals[$i] / $adividir;
                        $chequeg = $chequeg + $totcheque;
                    }
                }

                $matricula_id = Input::get('txt_matricula_id');
                $matricula = Matricula::find($matricula_id);
                $cuotadia = $matricula->cuotaperiodopagohasta;
                $fechaciclo = CicloLectivo::find($matricula->ciclolectivo_id)->descripcion;

                for ($i=0; $i < $cantmeses; $i++) {
                    $cuotas = new DetalleCuotaPago;
                    $cuotas->inscripcion_id         = $inscripcion_id;
                    $cuotas->matricula_id           = $matricula_id;
                    $cuotas->alumno_id              = $txt_alumno_id;
                    $cuotas->mescuota               = $mesescargados[$i];
                    $cuotas->importe                = $totals[$i];
                    $cuotas->porcentajerecargo      = $recargos[$i];
                    $cuotas->porcentajedescuento    = $descuentos[$i];

                    if ($mesescargados[$i] < 10) {
                        $mescuota = '0'. $mesescargados[$i];
                    } else {
                        $mescuota = $mesescargados[$i];
                    }

                    $fechavenci = $cuotadia .'/'. $mescuota .'/'. $fechaciclo;
                    $fechavencimiento = FechaHelper::getFechaParaGuardar($fechavenci);

                    $cuotas->fechavencimiento       = $fechavencimiento;
                    $cuotas->fechapago              = date('Y-m-d');
                    $cuotas->estado                 = 1;

                    if (!$efectivog == 0) {
                        $tot = $totals[$i] / $adividir;
                        $cuotas->efectivo = $tot;
                    }

                    if (!$tarjetag == 0) {
                        $tot = $totals[$i] / $adividir;
                        $cuotas->tarjetacredito = $tot;
                    }

                    if (!$debitog == 0) {
                        $tot = $totals[$i] / $adividir;
                        $cuotas->tarjetadebito = $tot;
                    }

                    if (!$bancariag == 0) {
                        $tot = $totals[$i] / $adividir;
                        $cuotas->cuentabancaria = $tot;
                    }

                    if (!$chequeg == 0) {
                        $tot = $totals[$i] / $adividir;
                        $cuotas->cheque = $tot;
                    }
                    
                    $cuotas->observaciones          = trim(Input::get('observaciones'));
                    $cuotas->transaccion            = $id_detalle;
                    $cuotas->usuario_alta           = Auth::user()->usuario;
                    $cuotas->fecha_alta             = date('Y-m-d');
                    $cuotas->save();
                }

                $efectivo          = Input::get('txt_efectivo');
                $tarjeta           = Input::get('txt_tarjeta');
                $debito            = Input::get('txt_debito');
                $bancaria          = Input::get('txt_bancaria');
                $cheque            = Input::get('txt_cheque');

                if ($efectivo == '') $efectivo = 0;
                if ($tarjeta == '') $tarjeta = 0;
                if ($debito == '') $debito = 0;
                if ($bancaria == '') $bancaria = 0;
                if ($cheque == '') $cheque = 0;

                $detallepago = new Formapagocuota;

                $detallepago->detallecuotaspago_id   = $id_detalle;
                $detallepago->efectivo               = $efectivo;
                $detallepago->tarjetacredito         = $tarjeta;
                $detallepago->tarjetadebito          = $debito;
                $detallepago->cuentabancaria         = $bancaria;
                $detallepago->cheque                 = $cheque;
                $detallepago->usuario_alta           = Auth::user()->usuario;
                $detallepago->fecha_alta             = date('Y-m-d');
                $detallepago->save();

                Session::flash('message', 'CUOTAS PAGADAS CON ÉXITO!');
                Session::flash('message_type', self::OPERACION_EXITOSA);
                return Redirect::to('cuotas/pagarcuotas/' . $persona_id);
            }
        } else {
            $this->_data = array(
                'alumno'    => Input::get('txt_alumno_id'),
                'carrera'  => Input::get('cboCarrera'),
                'matricula'  => Input::get('txt_matricula_id')
            );

            $this->_rules = array(
                'alumno'    => 'required',
                'carrera'  => 'required',
                'matricula'  => 'required'
            );

            $this->_messages = array(
                'required' => 'Campo Obligatorio',
            );

            $validator = Validator::make($this->_data, $this->_rules, $this->_messages);

            $mesescargados = Input::get('mesescargados');
            $cantmeses = count($mesescargados);
            /*$detalle = DetalleCuotaPago::all();

            $ultimodetalle = $detalle->last();
            $id_detalle = $ultimodetalle->id + 1;*/

            if ($validator->fails()) {
                Session::flash('message', 'ERROR AL INTENTAR GUARDAR LOS CAMBIOS!.');
                Session::flash('message_type', self::OPERACION_FALLIDA);
                return Redirect::to('cuotas/editarpago/' . $pago_id)
                    ->withErrors($validator)
                    ->withInput();
            } else {
                if ($cantmeses == 0) {
                    Session::flash('message', 'ERROR AL INTENTAR GUARDAR LA CUOTA A PAGAR.');
                    Session::flash('message_type', self::OPERACION_FALLIDA);
                    return Redirect::to('cuotas/editarpago/' . $pago_id)
                        ->withErrors($validator)
                        ->withInput();
                }

                $persona_id        = Input::get('txt_persona_id');
                $efectivo          = Input::get('txt_efectivo');
                $tarjeta           = Input::get('txt_tarjeta');
                $debito            = Input::get('txt_debito');
                $bancaria          = Input::get('txt_bancaria');
                $cheque            = Input::get('txt_cheque');
                $total_apagar      = Input::get('txt_total_apagar');
                $txt_alumno_id     = Input::get('txt_alumno_id');
                $inscripcion_id    = Input::get('txt_inscripcion_id');

                $detalle_cuotas = DetalleMatriculaPago::whereRaw('inscripcion_id= '. $inscripcion_id. ' AND alumno_id = '. $txt_alumno_id)->get();

                if (count($detalle_cuotas) == 0) {
                    Session::flash('message', 'ERROR AL INTENTAR GUARDAR. EL ALUMNO NO TIENE PAGADO LA MATRICULA');
                    Session::flash('message_type', self::OPERACION_FALLIDA);
                    return Redirect::to('cuotas/editarpago/' . $pago_id)
                        ->withInput();
                }

                if ($efectivo == '' && $tarjeta == '' && $debito == '' && $bancaria == '' && $cheque == '') {
                    Session::flash('message', 'ERROR AL INTENTAR GUARDAR EL PAGO. ESPECIFIQUE FORMA DE PAGO');
                    Session::flash('message_type', self::OPERACION_FALLIDA);
                    return Redirect::to('cuotas/editarpago/' . $pago_id)
                        ->withInput();
                }

                if ($efectivo == '') $efectivo = 0;
            
                if ($tarjeta == '') $tarjeta = 0;
                
                if ($debito == '') $debito = 0;
                
                if ($bancaria == '') $bancaria = 0;

                if ($cheque == '') $cheque = 0;

                $totalcalculado = $efectivo + $tarjeta + $debito + $bancaria + $cheque;

                if ($totalcalculado < $total_apagar) {
                    Session::flash('message', 'ERROR AL INTENTAR GUARDAR EL PAGO. LAS FORMA DE PAGO DEBE SER IGUAL AL TOTAL A ABONAR');
                    Session::flash('message_type', self::OPERACION_FALLIDA);
                    return Redirect::to('cuotas/editarpago/' . $pago_id)
                        ->withInput();
                }

                if ($totalcalculado > $total_apagar) {
                    Session::flash('message', 'ERROR AL INTENTAR GUARDAR EL PAGO. LAS FORMA DE PAGO DEBE SER IGUAL AL TOTAL A ABONAR');
                    Session::flash('message_type', self::OPERACION_FALLIDA);
                    return Redirect::to('cuotas/editarpago/' . $pago_id)
                        ->withInput();
                }

                //$fecha_nacimiento = FechaHelper::getFechaParaGuardar(Input::get('fechanacimiento'));
                $descuentos = Input::get('txtdescuentos');
                $recargos = Input::get('txtrecargos');
                $importes = Input::get('txt_importes');
                $totals = Input::get('txt_totals');

                //for ($i=0; $i < $cantmeses; $i++) {
                    $cuotas = DetalleCuotaPago::find($pago_id);

                    /*$cuotas->inscripcion_id         = Input::get('txt_inscripcion_id');
                    $cuotas->matricula_id           = Input::get('txt_matricula_id');
                    $cuotas->alumno_id              = $txt_alumno_id;*/
                    /*$cuotas->mescuota               = $mesescargados[0];*/
                    $cuotas->importe                = $totals[0];
                    $cuotas->porcentajerecargo      = $recargos[0];
                    $cuotas->porcentajedescuento    = $descuentos[0];
                    /*$cuotas->fechavencimiento       = date('Y-m-d');
                    $cuotas->fechapago              = date('Y-m-d');
                    $cuotas->estado                 = 1;*/

                    $cuotas->efectivo               = $efectivo;
                    $cuotas->tarjetacredito         = $tarjeta;
                    $cuotas->tarjetadebito          = $debito;
                    $cuotas->cuentabancaria         = $bancaria;
                    $cuotas->cheque                 = $cheque;
                    
                    $cuotas->observaciones          = trim(Input::get('observaciones'));
                    //$cuotas->transaccion            = $id_detalle;
                    $cuotas->usuario_modi           = Auth::user()->usuario;
                    $cuotas->fecha_modi             = date('Y-m-d');
                    $cuotas->save();
                //}
                if ($cuotas->transaccion) {
                    $transaccion = $cuotas->transaccion;
                    $detallepago = Formapagocuota::whereRaw('detallecuotaspago_id =' . $transaccion)->first();

                    //$detallepago->detallecuotaspago_id   = $id_detalle;
                    $detallepago->efectivo               = $efectivo;
                    $detallepago->tarjetacredito         = $tarjeta;
                    $detallepago->tarjetadebito          = $debito;
                    $detallepago->cuentabancaria         = $bancaria;
                    $detallepago->cheque                 = $cheque;
                    $detallepago->usuario_modi           = Auth::user()->usuario;
                    $detallepago->fecha_modi             = date('Y-m-d');
                    $detallepago->save();
                }

                Session::flash('message', 'CUOTAS MODIFICADA CON ÉXITO!');
                Session::flash('message_type', self::OPERACION_EXITOSA);
                return Redirect::to('cuotas/vistacuotas/' . $pago_id);
            }
        }
    }

    public function getPagarcuotas($alumno_id)
    {
        $arrAlumno = Alumno::getAlumnoPorId($alumno_id);
        $alumno    = $arrAlumno[0];
        $carreras  = AlumnoCarrera::getCarrerasInscripciones($alumno->alumno_id);
        $ciclos    = CicloLectivo::all();
        $detalle = DetalleCuotaPago::all();
        $ultimodetalle = $detalle->last();
        $id_detalle = $ultimodetalle->transaccion;

        $detalle_cuotas = DetalleCuotaPago::whereRaw('alumno_id = '. $alumno->alumno_id . ' AND transaccion = ' . $id_detalle)->get();
        
        $fechahoy = date("Y-m-d");
        $fechaactual = strtotime($fechahoy);
        $cuota_detalle = array();

        $efectivo = 0;
        $tarjetacredito = 0;
        $tarjetadebito = 0;
        $cuentabancaria = 0;
        $cheque = 0;

        foreach ($detalle_cuotas as $value) {
            $fechatransaccion = FechaHelper::getFechaImpresion($value->fechapago);
            $porcions = explode("/", $fechatransaccion);
            $fechatransaccions = $porcions[2].'-'.$porcions[1].'-'.$porcions[0];
            $fecha_trans = strtotime($fechatransaccions);

            $meses = ['vacio', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

            //if ($fecha_trans == $fechaactual) {
            
                $detallepago = Formapagocuota::whereRaw('detallecuotaspago_id = ' . $id_detalle)->first();

                $efectivo = $detallepago->efectivo;
                $tarjetacredito = $detallepago->tarjetacredito;
                $tarjetadebito = $detallepago->tarjetadebito;
                $cuentabancaria = $detallepago->cuentabancaria;
                $cheque = $detallepago->cheque;

                /*$efectivo = $efectivo + $value->efectivo;
                $tarjetacredito = $tarjetacredito + $value->tarjetacredito;
                $tarjetadebito = $tarjetadebito + $value->tarjetadebito;
                $cuentabancaria = $cuentabancaria + $value->cuentabancaria;
                $cheque = $cheque + $value->cheque;*/
                $matricula = $value->matricula_id;

                $ciclolectiv = Matricula::whereRaw('id = '. $value->matricula_id)->first()->ciclolectivo_id;

                $cuota_detalle[] = ['mescuota' => $value->mescuota, 'mes' => $meses[$value->mescuota], 'descuentos' => $value->porcentajedescuento, 'recargos' => $value->porcentajerecargo, 'importe' => $value->importe, 'efectivo' => $efectivo, 'tarjetacredito' => $tarjetacredito, 'tarjetadebito' => $tarjetadebito, 'cuentabancaria' => $cuentabancaria, 'cheque' => $cheque, 'observaciones' => $value->observaciones, 'fechatransaccion' => $fechatransaccion];
            //}
        }

        $editargestion = 1;
        $pago_id = 0;

        /*highlight_string(var_export($alumno,true));
        echo '<br>';

        highlight_string(var_export($cuota_detalle,true));
        exit;*/

        return View::make('cuotas.gestionPagosEdicion')
            ->with('alumno', $alumno)
            ->with('carreras', $carreras)
            ->with('ciclos', $ciclos)
            ->with('ciclolectivo', $ciclolectiv)
            ->with('matricula', $matricula)
            ->with('cuota_detalle', $cuota_detalle)
            ->with('editargestion', $editargestion)
            ->with('pago_id', $pago_id)
            ->with('menu', ModulosHelper::MENU_GESTION_CONTABLE)
            ->with('submenu', ModulosHelper::SUBMENU_PAGO_CUOTAS)
            ->with('leer', Session::get('PAGOCUOTAS_LEER'))
            ->with('editar', Session::get('PAGOCUOTAS_EDITAR'))
            ->with('imprimir', Session::get('PAGOCUOTAS_IMPRIMIR'))
            ->with('eliminar', Session::get('PAGOCUOTAS_ELIMINAR'));
    }

    public function getVistacuotas($pago_id)
    {
        $detalle_cuotas = DetalleCuotaPago::whereRaw('id = '. $pago_id)->get();
        
        $ciclos    = CicloLectivo::all();
        
        $cuota_detalle = array();

        $efectivo = 0;
        $tarjetacredito = 0;
        $tarjetadebito = 0;
        $cuentabancaria = 0;
        $cheque = 0;

        foreach ($detalle_cuotas as $value) {
            $fechatransaccion = FechaHelper::getFechaImpresion($value->fechapago);
            $porcions = explode("/", $fechatransaccion);
            $fechatransaccions = $porcions[2].'-'.$porcions[1].'-'.$porcions[0];
            $fecha_trans = strtotime($fechatransaccions);

            $meses = ['vacio', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

            $efectivo = $efectivo + $value->efectivo;
            $tarjetacredito = $tarjetacredito + $value->tarjetacredito;
            $tarjetadebito = $tarjetadebito + $value->tarjetadebito;
            $cuentabancaria = $cuentabancaria + $value->cuentabancaria;
            $cheque = $cheque + $value->cheque;
            $matricula = $value->matricula_id;

            $matriculas = Matricula::whereRaw('id = '. $value->matricula_id)->first();

            $ciclolectiv = $matriculas->ciclolectivo_id;

            $cuota_detalle[] = ['mescuota' => $value->mescuota, 'mes' => $meses[$value->mescuota], 'descuentos' => $value->porcentajedescuento, 'recargos' => $value->porcentajerecargo, 'importe' => $value->importe, 'efectivo' => $efectivo, 'tarjetacredito' => $tarjetacredito, 'tarjetadebito' => $tarjetadebito, 'cuentabancaria' => $cuentabancaria, 'cheque' => $cheque, 'observaciones' => $value->observaciones, 'fechatransaccion' => $fechatransaccion];

            //
            $arrAlumno = Alumno::find($value->alumno_id);
            $alumnos    = Alumno::getAlumnoPorId($arrAlumno->persona_id);
            $alumno    = $alumnos[0];
            $carreras  = AlumnoCarrera::getCarrerasInscripciones($value->alumno_id);
        }

        $editargestion = 1;

        /*highlight_string(var_export($alumno,true));
        echo '<br>';

        highlight_string(var_export($cuota_detalle,true));
        exit;*/

        return View::make('cuotas.gestionPagosEdicion')
            ->with('alumno', $alumno)
            ->with('carreras', $carreras)
            ->with('ciclos', $ciclos)
            ->with('ciclolectivo', $ciclolectiv)
            ->with('matricula', $matricula)
            ->with('cuota_detalle', $cuota_detalle)
            ->with('editargestion', $editargestion)
            ->with('pago_id', $pago_id)
            ->with('menu', ModulosHelper::MENU_GESTION_CONTABLE)
            ->with('submenu', ModulosHelper::SUBMENU_PAGO_CUOTAS)
            ->with('leer', Session::get('PAGOCUOTAS_LEER'))
            ->with('editar', Session::get('PAGOCUOTAS_EDITAR'))
            ->with('imprimir', Session::get('PAGOCUOTAS_IMPRIMIR'))
            ->with('eliminar', Session::get('PAGOCUOTAS_ELIMINAR'));
    }

    public function getEditar($parametro)
    {
        $porcion = explode("-", $parametro);
        
        $ciclo_id = $porcion[0];
        $carrera_id = $porcion[1];
        $alumno_id = $porcion[2];
        $mes_cuota = $porcion[3];

        $cuotas = Matricula::getDatosCuotasMatriculas($carrera_id, $ciclo_id, $alumno_id);

        $carreras  = AlumnoCarrera::getCarrerasInscripciones($alumno_id);
        $ciclos    = CicloLectivo::all();
        $cuota_detalle = array();

        foreach ($cuotas as $cuota) {
            $arrAlumno = Alumno::getAlumnoPorId($cuota->persona_id);
            $alumno    = $arrAlumno[0];
            $ciclolectiv = Matricula::whereRaw('id = '. $cuota->matricula_id)->first()->ciclolectivo_id;
            $matricula = $cuota->matricula_id;
            $importe = $cuota->cuotaimporte;
        }

        $fechahoy = date("Y-m-d");
        $fechatransaccion = FechaHelper::getFechaImpresion($fechahoy);

        $meses = ['vacio', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

        //if ($fecha_trans == $fechaactual) {
        $efectivo = '';
        $tarjetacredito = '';
        $tarjetadebito = '';
        $cuentabancaria = '';
        $cheque = '';
        $porcentajedescuento = '';
        $porcentajerecargo = '';
        $observaciones = '';

        $cuota_detalle[] = ['mescuota' => $mes_cuota, 'mes' => $meses[$mes_cuota], 'descuentos' => $porcentajedescuento, 'recargos' => $porcentajerecargo, 'importe' => $importe, 'efectivo' => $efectivo, 'tarjetacredito' => $tarjetacredito, 'tarjetadebito' => $tarjetadebito, 'cuentabancaria' => $cuentabancaria, 'cheque' => $cheque, 'observaciones' => $observaciones, 'fechatransaccion' => $fechatransaccion];


        $cuotafin = Matricula::whereRaw('carrera_id = '. $carrera_id .' AND ciclolectivo_id = '. $ciclo_id)->first();

        if ($cuotafin) {
            if ($cuotafin->mespagocuotafin == NULL || $cuotafin->mespagocuotafin == '') {
                $cuotafin->mespagocuotafin = 12;
            }

            $detalles = DetalleCuotaPago::whereRaw('matricula_id= '. $cuotafin->id. ' AND alumno_id = '. $alumno_id)->get();
            
            if (count($detalles)) {
                $detalle = $detalles->last();
                $mespagocuotainicio = $detalle->mescuota;
            } else {
                $mespagocuotainicio = $cuotafin->mespagocuotainicio - 1;
            }
            
            if ($mespagocuotainicio < 13) {
                for ($i=0; $i < count($meses); $i++) { 
                    if ($i > $mespagocuotainicio || $cuotafin->mespagocuotafin == $i) {
                        $cuotasmeses[] = ['id' => $i, 'mes' => $meses[$i], 'matricula_id' => $cuotafin->id];
                    }
                }
            }
            
            //$cuotafin->cuotasmeses = $cuotasmeses;
        }

        $editargestion = 2;
        $pago_id = 0;

        return View::make('cuotas.gestionPagosEdicion')
            ->with('alumno', $alumno)
            ->with('carreras', $carreras)
            ->with('ciclos', $ciclos)
            ->with('ciclolectivo', $ciclolectiv)
            ->with('matricula', $matricula)
            ->with('cuota_detalle', $cuota_detalle)
            ->with('cuotasmeses', $cuotasmeses)
            ->with('editargestion', $editargestion)
            ->with('pago_id', $pago_id)
            ->with('menu', ModulosHelper::MENU_GESTION_CONTABLE)
            ->with('submenu', ModulosHelper::SUBMENU_PAGO_CUOTAS)
            ->with('leer', Session::get('PAGOCUOTAS_LEER'))
            ->with('editar', Session::get('PAGOCUOTAS_EDITAR'))
            ->with('imprimir', Session::get('PAGOCUOTAS_IMPRIMIR'))
            ->with('eliminar', Session::get('PAGOCUOTAS_ELIMINAR'));
    }

    public function getEditarpago($id)
    {
        /*$porcion = explode("-", $parametro);
        
        $ciclo_id = $porcion[0];
        $carrera_id = $porcion[1];*/
        $ciclos    = CicloLectivo::all();
        $detalle_cuotas = DetalleCuotaPago::whereRaw('id = '. $id)->get();
        $pago_id = $id;
        $fechahoy = date("Y-m-d");
        $fechaactual = strtotime($fechahoy);
        $cuota_detalle = array();

        $efectivo = 0;
        $tarjetacredito = 0;
        $tarjetadebito = 0;
        $cuentabancaria = 0;
        $cheque = 0;

        foreach ($detalle_cuotas as $value) {
            $alumno_id = $value->alumno_id;
            $persona_id = Alumno::with('persona')->find($alumno_id);
            $arrAlumno = Alumno::getAlumnoPorId($persona_id->persona_id);
            $alumno    = $arrAlumno[0];
            $carreras  = AlumnoCarrera::getCarrerasInscripciones($alumno->alumno_id);

            $fechatransaccion = FechaHelper::getFechaImpresion($value->fechapago);
            $porcions = explode("/", $fechatransaccion);
            $fechatransaccions = $porcions[2].'-'.$porcions[1].'-'.$porcions[0];
            $fecha_trans = strtotime($fechatransaccions);

            $meses = ['vacio', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

            //if ($fecha_trans == $fechaactual) {
                $efectivo = $efectivo + $value->efectivo;
                $tarjetacredito = $tarjetacredito + $value->tarjetacredito;
                $tarjetadebito = $tarjetadebito + $value->tarjetadebito;
                $cuentabancaria = $cuentabancaria + $value->cuentabancaria;
                $cheque = $cheque + $value->cheque;
                $matricula = $value->matricula_id;

                $ciclolectiv = Matricula::whereRaw('id = '. $matricula)->first()->ciclolectivo_id;

                $cuota_detalle[] = ['mescuota' => $value->mescuota, 'mes' => $meses[$value->mescuota], 'descuentos' => $value->porcentajedescuento, 'recargos' => $value->porcentajerecargo, 'importe' => $value->importe, 'efectivo' => $efectivo, 'tarjetacredito' => $tarjetacredito, 'tarjetadebito' => $tarjetadebito, 'cuentabancaria' => $cuentabancaria, 'cheque' => $cheque, 'observaciones' => $value->observaciones, 'fechatransaccion' => $fechatransaccion];
            //}
                $cuotasmeses[] = ['id' => $value->mescuota, 'mes' => $meses[$value->mescuota]];
        }

        $editargestion = 3;

        return View::make('cuotas.gestionPagosEdicion')
            ->with('alumno', $alumno)
            ->with('carreras', $carreras)
            ->with('ciclos', $ciclos)
            ->with('ciclolectivo', $ciclolectiv)
            ->with('matricula', $matricula)
            ->with('cuota_detalle', $cuota_detalle)
            ->with('cuotasmeses', $cuotasmeses)
            ->with('editargestion', $editargestion)
            ->with('pago_id', $pago_id)
            ->with('menu', ModulosHelper::MENU_GESTION_CONTABLE)
            ->with('submenu', ModulosHelper::SUBMENU_PAGO_CUOTAS)
            ->with('leer', Session::get('PAGOCUOTAS_LEER'))
            ->with('editar', Session::get('PAGOCUOTAS_EDITAR'))
            ->with('imprimir', Session::get('PAGOCUOTAS_IMPRIMIR'))
            ->with('eliminar', Session::get('PAGOCUOTAS_ELIMINAR'));
    }

    public function getImprimirrecibo()/*PDF*/
    {
        $inscripcion_id = Input::get('inscripcion_id');
        $matricula_id = Input::get('matricula_id');
        $pago_id = Input::get('txt_pago_id');
        $matriculas = array();
        $fechahoy = date("Y-m-d");
        $fechaactual = strtotime($fechahoy);

        $efectivo = 0;
        $tarjetacredito = 0;
        $tarjetadebito = 0;
        $cuentabancaria = 0;
        $cheque = 0;
        $cuotasmeses = array();

        if ($pago_id == 0) {
            $detalle = DetalleCuotaPago::all();
            $ultimodetalle = $detalle->last();
            $id_detalle = $ultimodetalle->transaccion;
            $pagos = DetalleCuotaPago::getDatosPagoRealizado($inscripcion_id, $matricula_id);
        } else {
            $pagos = DetalleCuotaPago::whereRaw('id = ' . $pago_id)->get();
        }
        
        foreach ($pagos as $value) {
            $matricula = Matricula::whereRaw('id =' . $value->matricula_id)->first();

            $cuotames = $matricula->cuotaimporte;
            
            $ciclo = CicloLectivo::whereRaw('id='. $matricula->ciclolectivo_id)->first()->descripcion;
            
            $carrera = $matricula->carrera->carrera;

            $apeynomb = Alumno::find($value->alumno_id);

            $apeynom = $apeynomb->persona->apellido . ', ' . $apeynomb->persona->nombre;

            $dni = $apeynomb->persona->nrodocumento;
            $total = 0;
            $porcentajerecargo = 0;
            $porcentajedescuento = 0;

            $meses = ['vacio', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

            $detalles = DetalleCuotaPago::whereRaw('matricula_id= '. $matricula->id. ' AND alumno_id = '. $value->alumno_id)->get();

            if ($pago_id == 0) {
                foreach ($detalles as $detalle) {
                    $fechatransaccion = FechaHelper::getFechaImpresion($detalle->fechapago);
                    $porcions = explode("/", $fechatransaccion);
                    $fechatransaccions = $porcions[2].'-'.$porcions[1].'-'.$porcions[0];
                    $fecha_trans = strtotime($fechatransaccions);

                    if ($detalle->transaccion == $id_detalle) {
                        /*$efectivo = $efectivo + $detalle->efectivo;
                        $tarjetacredito = $tarjetacredito + $detalle->tarjetacredito;
                        $tarjetadebito = $tarjetadebito + $detalle->tarjetadebito;
                        $cuentabancaria = $cuentabancaria + $detalle->cuentabancaria;
                        $cheque = $cheque + $detalle->cheque;*/
                        $detallepago = Formapagocuota::whereRaw('detallecuotaspago_id = ' . $id_detalle)->first();

                        $efectivo = $detallepago->efectivo;
                        $tarjetacredito = $detallepago->tarjetacredito;
                        $tarjetadebito = $detallepago->tarjetadebito;
                        $cuentabancaria = $detallepago->cuentabancaria;
                        $cheque = $detallepago->cheque;

                        $matricula = $detalle->matricula_id;
                        $porcentajerecargo = $porcentajerecargo + $detalle->porcentajerecargo;
                        $porcentajedescuento = $porcentajedescuento + $detalle->porcentajedescuento;
                        $total = $total + $detalle->importe;

                        $cuotasmeses[] = ['mescuota' => $detalle->mescuota, 'mes' => $meses[$detalle->mescuota], 'observaciones' => $detalle->observaciones];
                    }
                }
            } else {
                $fechatransaccion = FechaHelper::getFechaImpresion($value->fechapago);
                $porcions = explode("/", $fechatransaccion);
                $fechatransaccions = $porcions[2].'-'.$porcions[1].'-'.$porcions[0];
                $fecha_trans = strtotime($fechatransaccions);
                //$pago_ids = $value->id;

                $efectivo = $efectivo + $value->efectivo;
                $tarjetacredito = $tarjetacredito + $value->tarjetacredito;
                $tarjetadebito = $tarjetadebito + $value->tarjetadebito;
                $cuentabancaria = $cuentabancaria + $value->cuentabancaria;
                $cheque = $cheque + $value->cheque;
                $matricula = $value->matricula_id;
                $porcentajerecargo = $porcentajerecargo + $value->porcentajerecargo;
                $porcentajedescuento = $porcentajedescuento + $value->porcentajedescuento;
                $total = $total + $value->importe;

                $cuotasmeses[] = ['mescuota' => $value->mescuota, 'mes' => $meses[$value->mescuota], 'observaciones' => $value->observaciones];
            }

            //$cuotafin->cuotasmeses = $cuotasmeses;

            $matriculas[] = ['id' => $value->id, 'carrera' => $carrera, 'apeynom' => $apeynom, 'ciclo' => $ciclo, 'dni' => $dni, 'importe' => $value->importe, 'efectivo' => $efectivo, 'credito' => $tarjetacredito, 'debito' => $tarjetadebito, 'bancaria' => $cuentabancaria, 'cheque' => $cheque, 'descuento' => $porcentajedescuento, 'recargo' => $porcentajerecargo, 'total' => $total, 'cuotasmeses' => $cuotasmeses, 'cuotames' => $cuotames];
        }

/*highlight_string(var_export($matriculas[0],true));
        exit;*/
        $pdf = PDF::loadView('informes.pdf.cuotarecibo', ['matriculas'=>$matriculas[0]]);
        return $pdf->setOrientation('landscape')->stream();
    }  

    public function getImprimir()/*PDF*/
    {
        $organizacion_id = Input::get('organizacion_id');
        $ciclo_id = Input::get('ciclo_id');
        $carrera_id = Input::get('carrera_id');
        $txtalumno = Input::get('alumno_id');
        $cuotasinscriptos = array();

        if ($txtalumno == '') {
            $inscripciones = Matricula::getDatosInscriptosMatriculas($carrera_id, $ciclo_id);
            
            foreach ($inscripciones as $value) {
                $detalle_matricula = DetalleMatriculaPago::whereRaw('inscripcion_id = '. $value->inscripcion_id .' AND matricula_id = '. $value->matricula_id)->first();

                if ($detalle_matricula) {
                    if ($value->ciclo_inscripcion == $value->ciclolectivo_id) {
                        $cuotasinscriptos[] = ['nombre' => $value->nombre, 'apellido' => $value->apellido, 'nrodocumento' => $value->nrodocumento, 'inscripcion_id' => $value->inscripcion_id, 'carrera_id' => $value->carrera_id, 'alumno_id' => $value->alumno_id, 'ciclo_inscripcion' => $value->ciclo_inscripcion, 'ciclolectivo_id' => $value->ciclolectivo_id, 'matriculaimporte' => $value->matriculaimporte, 'matricula_id' => $value->matricula_id, 'ciclo_descripcion' => $value->ciclo_descripcion, 'fechavencimientomatricula' => $value->fechavencimientomatricula, 'matriculaaplica' => $value->matriculaaplica, 'cuotaaplica' => $value->cuotaaplica, 'mespagocuotainicio' => $value->mespagocuotainicio, 'mespagocuotafin' => $value->mespagocuotafin, 'cuotaimporte' => $value->cuotaimporte];
                    }
                }
            }

            foreach ($inscripciones as $value) {
                $detalle_matricula = DetalleMatriculaPago::whereRaw('inscripcion_id = '. $value->inscripcion_id .' AND matricula_id = '. $value->matricula_id)->first();

                if ($detalle_matricula) {
                    if ($value->ciclolectivo_id > $value->ciclo_inscripcion) {
                        $cuotasinscriptos[] = ['nombre' => $value->nombre, 'apellido' => $value->apellido, 'nrodocumento' => $value->nrodocumento, 'inscripcion_id' => $value->inscripcion_id, 'carrera_id' => $value->carrera_id, 'alumno_id' => $value->alumno_id, 'ciclo_inscripcion' => $value->ciclo_inscripcion, 'ciclolectivo_id' => $value->ciclolectivo_id, 'matriculaimporte' => $value->matriculaimporte, 'matricula_id' => $value->matricula_id, 'ciclo_descripcion' => $value->ciclo_descripcion, 'fechavencimientomatricula' => $value->fechavencimientomatricula, 'matriculaaplica' => $value->matriculaaplica, 'cuotaaplica' => $value->cuotaaplica, 'mespagocuotainicio' => $value->mespagocuotainicio, 'mespagocuotafin' => $value->mespagocuotafin, 'cuotaimporte' => $value->cuotaimporte];
                    }
                }
            }

            if (isset($cuotasinscriptos)) {
                asort($cuotasinscriptos);
                
                foreach ($cuotasinscriptos as $value) {
                    $detalle_pagos = DetalleCuotaPago::getDatosPagos($value['inscripcion_id'], $value['matricula_id'], $ciclo_id);

                    if ($value['mespagocuotafin'] == NULL || $value['mespagocuotafin'] == '') {
                        $value['mespagocuotafin'] = 13;
                    }

                    if (!$detalle_pagos) {
                        $detalle_pagos = 'ADEUDA';
                    }

                    $beca = Beca::whereRaw('inscripcion_id =' . $value['inscripcion_id'] . ' AND ciclolectivo_id =' . $value['ciclolectivo_id'] . ' and becado=1')->get();

                    $beca = (count($beca)) ? 'BECADO' : 'NO_TIENE_BECA';

                    $carrera = Carrera::whereRaw('id ='. $value['carrera_id'])->first();
                    $ciclo = $value['ciclo_descripcion'];

                    $matriculas[] = ['apellido' => $value['apellido'], 'nombre' => $value['nombre'], 'nrodocumento' => $value['nrodocumento'], 'carrera' => $carrera->carrera, 'ciclo' => $ciclo, 'mespagocuotainicio' => $value['mespagocuotainicio'], 'mespagocuotafin' => $value['mespagocuotafin'], 'cuotaimporte' => $value['cuotaimporte'], 'beca' => $beca, 'detalle_cuotas' => $detalle_pagos];
                }
            }
        } else {
            $inscripciones = Matricula::getDatosCuotasMatriculas($carrera_id, $ciclo_id, $txtalumno);

            foreach ($inscripciones as $value) {
                $detalle_pagos = DetalleCuotaPago::getDatosPagos($value->inscripcion_id, $value->matricula_id, $ciclo_id);
                
                if ($value->mespagocuotafin == NULL || $value->mespagocuotafin == '') {
                    $value->mespagocuotafin = 13;
                }

                if (!$detalle_pagos) {
                    $detalle_pagos = 'ADEUDA';
                }

                $beca = Beca::whereRaw('inscripcion_id =' . $value->inscripcion_id . ' AND ciclolectivo_id =' . $value->ciclolectivo_id . ' and becado=1')->get();

                $beca = (count($beca)) ? 'BECADO' : 'NO_TIENE_BECA';

                $carrera = Carrera::whereRaw('id ='. $value->carrera_id)->first();
                $ciclo = $value->ciclo_descripcion;

                $matriculas[] = ['apellido' => $value->apellido, 'nombre' => $value->nombre, 'nrodocumento' => $value->nrodocumento, 'carrera' => $carrera->carrera, 'ciclo' => $ciclo, 'mespagocuotainicio' => $value->mespagocuotainicio, 'mespagocuotafin' => $value->mespagocuotafin, 'cuotaimporte' => $value->cuotaimporte, 'beca' => $beca, 'detalle_cuotas' => $detalle_pagos];
                /*if ($detalle_pagos) {
                    $value->detalle_cuotas = $detalle_pagos;
                } else {
                    $value->detalle_cuotas = '';
                }

                $beca = Beca::whereRaw('inscripcion_id =' . $value->inscripcion_id . ' AND ciclolectivo_id =' . $value->ciclolectivo_id . ' and becado=1')->get();
                $value->beca = (count($beca)) ? $beca[0] : self::NO_TIENE_BECA;*/
            }
        }

        /*highlight_string(var_export($matriculas,true));
        exit;*/

        $pdf = PDF::loadView('informes.pdf.pagoscuotas', ['matriculas'=>$matriculas]);
        return $pdf->setOrientation('landscape')->stream();
    }  

    public function getImprimirdeuda()/*PDF*/
    {
        $organizacion_id = Input::get('organizacion_id');
        $ciclo_id = Input::get('ciclo_id');
        $carrera_id = Input::get('carrera_id');
        $txtalumno = Input::get('alumno_id');
        $fechadesde = Input::get('fechadesde');
        $fechahasta = Input::get('fechahasta');
        $cuotasinscriptos = array();
        $matriculas = [];
        $apeynom = '';
        $saldo = 0;

        if (!$fechadesde == '') {
            if ($txtalumno == '') {
                $inscripciones = Matricula::getDatosInscriptosMatriculas($carrera_id, $ciclo_id);
                
                foreach ($inscripciones as $value) {
                    $detalle_matricula = DetalleMatriculaPago::whereRaw('inscripcion_id = '. $value->inscripcion_id .' AND matricula_id = '. $value->matricula_id)->first();

                    if ($detalle_matricula) {
                        $cuotasinscriptos[] = ['nombre' => $value->nombre, 'apellido' => $value->apellido, 'nrodocumento' => $value->nrodocumento, 'inscripcion_id' => $value->inscripcion_id, 'carrera_id' => $value->carrera_id, 'alumno_id' => $value->alumno_id, 'ciclo_inscripcion' => $value->ciclo_inscripcion, 'ciclolectivo_id' => $value->ciclolectivo_id, 'matriculaimporte' => $value->matriculaimporte, 'matricula_id' => $value->matricula_id, 'ciclo_descripcion' => $value->ciclo_descripcion, 'fechavencimientomatricula' => $value->fechavencimientomatricula, 'matriculaaplica' => $value->matriculaaplica, 'cuotaaplica' => $value->cuotaaplica, 'mespagocuotainicio' => $value->mespagocuotainicio, 'mespagocuotafin' => $value->mespagocuotafin, 'cuotaimporte' => $value->cuotaimporte, 'saldo' => $detalle_matricula->saldo, 'abonada' => 1];
                    } else {
                        $cuotasinscriptos[] = ['nombre' => $value->nombre, 'apellido' => $value->apellido, 'nrodocumento' => $value->nrodocumento, 'inscripcion_id' => $value->inscripcion_id, 'carrera_id' => $value->carrera_id, 'alumno_id' => $value->alumno_id, 'ciclo_inscripcion' => $value->ciclo_inscripcion, 'ciclolectivo_id' => $value->ciclolectivo_id, 'matriculaimporte' => $value->matriculaimporte, 'matricula_id' => $value->matricula_id, 'ciclo_descripcion' => $value->ciclo_descripcion, 'fechavencimientomatricula' => $value->fechavencimientomatricula, 'matriculaaplica' => $value->matriculaaplica, 'cuotaaplica' => $value->cuotaaplica, 'mespagocuotainicio' => $value->mespagocuotainicio, 'mespagocuotafin' => $value->mespagocuotafin, 'cuotaimporte' => $value->cuotaimporte, 'saldo' => 0, 'abonada' => 0];
                    }
                }

                if (isset($cuotasinscriptos)) {
                    asort($cuotasinscriptos);
                    
                    foreach ($cuotasinscriptos as $value) {
                        $detalle_pagos = DetalleCuotaPago::getDatosPagos($value['inscripcion_id'], $value['matricula_id'], $ciclo_id);

                        if ($value['mespagocuotafin'] == NULL || $value['mespagocuotafin'] == '') {
                            $value['mespagocuotafin'] = 13;
                        }

                        if ($value['saldo'] == 0) {
                            $saldo = 0;
                        } else {
                            $saldo = $value['saldo'];
                        }

                        if (!$detalle_pagos) {
                            $detalle_pagos = 'ADEUDA';
                        }

                        $beca = Beca::whereRaw('inscripcion_id =' . $value['inscripcion_id'] . ' AND ciclolectivo_id =' . $value['ciclolectivo_id'] . ' and becado=1')->get();

                        $beca = (count($beca)) ? 'BECADO' : 'NO_TIENE_BECA';

                        $carrera = Carrera::whereRaw('id ='. $value['carrera_id'])->first();
                        $ciclo = $value['ciclo_descripcion'];
                        $apeynom = '';

                        $matriculas[] = ['apellido' => $value['apellido'], 'nombre' => $value['nombre'], 'nrodocumento' => $value['nrodocumento'], 'carrera' => $carrera->carrera, 'ciclo' => $ciclo, 'mespagocuotainicio' => $value['mespagocuotainicio'], 'mespagocuotafin' => $value['mespagocuotafin'], 'cuotaimporte' => $value['cuotaimporte'], 'matriculaimporte' => $value['matriculaimporte'], 'saldo' => $saldo, 'abonada' => $value['abonada'], 'beca' => $beca, 'detalle_cuotas' => $detalle_pagos];
                    }
                }
            } else {
                $inscripciones = Matricula::getDatosCuotasMatriculas($carrera_id, $ciclo_id, $txtalumno);

                if (count($inscripciones) > 0) {
                    foreach ($inscripciones as $value) {
                        $detalle_pagos = DetalleCuotaPago::getDatosPagos($value->inscripcion_id, $value->matricula_id, $ciclo_id);
                        //////
                        $detalle_matricula = DetalleMatriculaPago::whereRaw('inscripcion_id = '. $value->inscripcion_id .' AND matricula_id = '. $value->matricula_id)->first();

                        if (count($detalle_matricula) > 0) {
                            if ($detalle_matricula->saldo == 0) {
                                $saldo = 0;
                            } else {
                                $saldo = $detalle_matricula->saldo;
                            }
                        }
            
                        if ($value->mespagocuotafin == NULL || $value->mespagocuotafin == '') {
                            $value->mespagocuotafin = 13;
                        }

                        if (!$detalle_pagos) {
                            $detalle_pagos = 'ADEUDA';
                        }

                        $beca = Beca::whereRaw('inscripcion_id =' . $value->inscripcion_id . ' AND ciclolectivo_id =' . $value->ciclolectivo_id . ' and becado=1')->get();

                        $beca = (count($beca)) ? 'BECADO' : 'NO_TIENE_BECA';

                        $carrera = Carrera::whereRaw('id ='. $value->carrera_id)->first();
                        $ciclo = $value->ciclo_descripcion;
                        $apeynom = $value->apellido.', '.$value->nombre;

                        $matriculas[] = ['apellido' => $value->apellido, 'nombre' => $value->nombre, 'nrodocumento' => $value->nrodocumento, 'carrera' => $carrera->carrera, 'ciclo' => $ciclo, 'mespagocuotainicio' => $value->mespagocuotainicio, 'mespagocuotafin' => $value->mespagocuotafin, 'cuotaimporte' => $value->cuotaimporte, 'saldo' => $saldo, 'beca' => $beca, 'detalle_cuotas' => $detalle_pagos];
                    }
                }
            }
        }
        /*highlight_string(var_export($matriculas,true));
        exit;*/

        $pdf = PDF::loadView('informes.pdf.deudasalumnos', ['matriculas'=>$matriculas, 'fechadesde'=>$fechadesde, 'fechahasta'=>$fechahasta, 'apeynom'=>$apeynom]);
        return $pdf->setOrientation('landscape')->stream();
    }  

    public function getHistorial()
    {
        $ciclo_id = Input::get('ciclo_id');
        $dni = Input::get('dni');
        $ciclos    = CicloLectivo::all();

        $alumnos = Alumno::getAlumnoPorDni($dni);
        $alumno = (count($alumnos)) ? $alumnos[0] : '';

        $carreras  = AlumnoCarrera::whereRaw('alumno_id = '. $alumno->alumno_id)->get();
        //getCarrerasPorCicloAlumno($alumno->alumno_id, $ciclo_id);
        $carrera = (count($carreras)) ? $carreras[0] : '';
        $alu_carrera = Carrera::find($carrera->carrera_id)->carrera;

        /*highlight_string(var_export($alu_carrera,true));
        exit();//*/
        $matricula = Matricula::whereRaw('carrera_id =' . $carrera->carrera_id . ' AND ciclolectivo_id =' . $ciclo_id)->first();
        $detalle_cuotas = DetalleCuotaPago::whereRaw('matricula_id = '. $matricula->id . ' AND alumno_id =' . $alumno->alumno_id)->get();
        
        $cuota_detalle = array();

        if ($matricula) {
            $importecuota = $matricula->cuotaimporte;
            $mespagocuotainicio = $matricula->mespagocuotainicio;
            if ($matricula->mespagocuotafin == NULL) {
                $mespagocuotafin = 13;
            } else {
                $mespagocuotafin = $matricula->mespagocuotafin++;
            }
        }
        
        $efectivo = 0;
        $tarjetacredito = 0;
        $tarjetadebito = 0;
        $cuentabancaria = 0;
        $cheque = 0;
        $cicloslec    = CicloLectivo::find($ciclo_id);

        if ($detalle_cuotas) {
            foreach ($detalle_cuotas as $value) {
                $fechatransaccion = FechaHelper::getFechaImpresion($value->fechapago);
                $totalpagado = 0;

                $meses = ['vacio', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

                $efectivo = $efectivo + $value->efectivo;
                $tarjetacredito = $tarjetacredito + $value->tarjetacredito;
                $tarjetadebito = $tarjetadebito + $value->tarjetadebito;
                $cuentabancaria = $cuentabancaria + $value->cuentabancaria;
                $cheque = $cheque + $value->cheque;
                $totalpagado = $value->importe;

                $cuota_detalle[] = ['cicloslec' => $cicloslec->descripcion, 'mescuota' => $value->mescuota, 'mes' => $meses[$value->mescuota], 'descuentos' => $value->porcentajedescuento, 'recargos' => $value->porcentajerecargo, 'importe' => $importecuota, 'efectivo' => $efectivo, 'tarjetacredito' => $tarjetacredito, 'tarjetadebito' => $tarjetadebito, 'cuentabancaria' => $cuentabancaria, 'cheque' => $cheque, 'observaciones' => $value->observaciones, 'fechatransaccion' => $fechatransaccion, 'totalpagado' => $totalpagado, 'mespagocuotafin' => $mespagocuotafin];
            
                //$cuotasmeses[] = ['id' => $value->mescuota, 'mes' => $meses[$value->mescuota]];
            }
        }


        return View::make('cuotas.historial')
            ->with('alumno', $alumno)
            ->with('carreras', $alu_carrera)
            ->with('ciclos', $ciclos)
            ->with('ciclolectivo', $ciclo_id)
            ->with('cuota_detalle', $cuota_detalle)
            ->with('cicloslec', $cicloslec)
            ->with('mespagocuotainicio', $mespagocuotainicio)
            ->with('mespagocuotafin', $mespagocuotafin)
            ->with('dni', $dni)
            ->with('menu', ModulosHelper::MENU_GESTION_CONTABLE)
            ->with('submenu', ModulosHelper::SUBMENU_PAGO_CUOTAS)
            ->with('leer', Session::get('PAGOCUOTAS_LEER'))
            ->with('editar', Session::get('PAGOCUOTAS_EDITAR'))
            ->with('imprimir', Session::get('PAGOCUOTAS_IMPRIMIR'))
            ->with('eliminar', Session::get('PAGOCUOTAS_ELIMINAR'));
    }  

    public function getImprimirhistorial()
    {
        $ciclo_id = Input::get('ciclo_id');
        $dni = Input::get('dni');
        $ciclos    = CicloLectivo::all();

        $alumnos = Alumno::getAlumnoPorDni($dni);
        $alumno = (count($alumnos)) ? $alumnos[0] : '';

        $carreras  = AlumnoCarrera::whereRaw('alumno_id = '. $alumno->alumno_id)->get();
        //AlumnoCarrera::getCarrerasPorCicloAlumno($alumno->alumno_id, $ciclo_id);
        $carrera = (count($carreras)) ? $carreras[0] : '';
        $alu_carrera = Carrera::find($carrera->carrera_id)->carrera;

        /*highlight_string(var_export($carreras,true));
        exit();//*/
        $matricula = Matricula::whereRaw('carrera_id =' . $carrera->carrera_id . ' AND ciclolectivo_id =' . $ciclo_id)->first();
        $detalle_cuotas = DetalleCuotaPago::whereRaw('matricula_id = '. $matricula->id . ' AND alumno_id =' . $alumno->alumno_id)->get();
        
        $cuota_detalle = array();

        if ($matricula) {
            $importecuota = $matricula->cuotaimporte;
            $mespagocuotainicio = $matricula->mespagocuotainicio;
            if ($matricula->mespagocuotafin == NULL) {
                $mespagocuotafin = 13;
            } else {
                $mespagocuotafin = $matricula->mespagocuotafin++;
            }
        }
        
        $efectivo = 0;
        $tarjetacredito = 0;
        $tarjetadebito = 0;
        $cuentabancaria = 0;
        $cheque = 0;
        $cicloslec    = CicloLectivo::find($ciclo_id);
        $ciclolectiv = $cicloslec->descripcion;

        if ($detalle_cuotas) {
            foreach ($detalle_cuotas as $value) {
                $fechatransaccion = FechaHelper::getFechaImpresion($value->fechapago);
                $totalpagado = 0;

                $meses = ['vacio', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

                $efectivo = $efectivo + $value->efectivo;
                $tarjetacredito = $tarjetacredito + $value->tarjetacredito;
                $tarjetadebito = $tarjetadebito + $value->tarjetadebito;
                $cuentabancaria = $cuentabancaria + $value->cuentabancaria;
                $cheque = $cheque + $value->cheque;
                $totalpagado = $value->importe;

                $cuota_detalle[] = ['cicloslec' => $cicloslec->descripcion, 'mescuota' => $value->mescuota, 'mes' => $meses[$value->mescuota], 'descuentos' => $value->porcentajedescuento, 'recargos' => $value->porcentajerecargo, 'importe' => $importecuota, 'efectivo' => $efectivo, 'tarjetacredito' => $tarjetacredito, 'tarjetadebito' => $tarjetadebito, 'cuentabancaria' => $cuentabancaria, 'cheque' => $cheque, 'observaciones' => $value->observaciones, 'fechatransaccion' => $fechatransaccion, 'totalpagado' => $totalpagado, 'mespagocuotafin' => $mespagocuotafin];
            }
        }

        $pdf = PDF::loadView(
            'informes.pdf.cuotashistorial',
            [
                'alumno' => $alumno,
                'carreras' => $alu_carrera,
                'ciclos' => $ciclos,
                'ciclolectivo' => $ciclo_id,
                'cuota_detalle' => $cuota_detalle,
                'cicloslec' => $ciclolectiv,
                'mespagocuotainicio' => $mespagocuotainicio,
                'mespagocuotafin' => $mespagocuotafin,
            ]
        );
        return $pdf->setOrientation('landscape')->stream();
    }  

    public function postObtenercuentaporalumno() 
    {
        $ciclo_id = Input::get('ciclo');
        $carrera_id = Input::get('carrera');
        $alumno_id = Input::get('alumno_id');
        
        $matricula = [];
        $meses = ['vacio', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        $tipomovimiento = '';
        $mespagocuotainicio = 0;
        $mespagocuotafin = 0;
        $cuotaperiodopagohasta = 0;
        
        if (!$ciclo_id == '' && !$carrera_id == '' && !$alumno_id == '') {
            $cicloslec = CicloLectivo::find($ciclo_id)->descripcion;

            $matriculas = Matricula::getDatosCuotasMatriculas($carrera_id, $ciclo_id, $alumno_id);//getDatosInscriptosMatriculas($carrera_id, $ciclo_id);

            foreach ($matriculas as $value) {
                $detalle_pagos = DetalleMatriculaPago::whereRaw('inscripcion_id= '.$value->inscripcion_id.' AND matricula_id= '.$value->matricula_id.' AND alumno_id= '.$alumno_id)->first();

                $mespagocuotainicio = $value->mespagocuotainicio;
                $cuotaperiodopagohasta = $value->cuotaperiodopagohasta;

                if ($value->mespagocuotafin == NULL) {
                    $mespagocuotafin = 12;
                } else {
                    $mespagocuotafin = $value->mespagocuotafin;
                }

                if (count($detalle_pagos) > 0) {
                    $fechavencimiento = FechaHelper::getFechaImpresion($detalle_pagos->fechavencimiento);
                    $fechapago = FechaHelper::getFechaImpresion($detalle_pagos->fechapago);

                    $matricula[] = [
                        'matricula_id' => $value->matricula_id, 
                        'fechavencimientomatricula' => $fechavencimiento, 
                        'tipomovimiento' => 'Matricula', 
                        'efectivo' => $detalle_pagos->efectivo, 
                        'tarjetacredito' => $detalle_pagos->tarjetacredito, 
                        'tarjetadebito' => $detalle_pagos->tarjetadebito, 
                        'otros' => $detalle_pagos->cuentabancaria, 
                        'fechapago' => $fechapago, 
                        'nrocomprobante' => $detalle_pagos->id, 
                        'mespagocuotainicio' => $mespagocuotainicio, 
                        'mespagocuotafin' => $mespagocuotafin, 
                        'mescuota' => '',
                        'cuotaperiodopagohasta' => $cuotaperiodopagohasta,
                        'cicloslec' => $cicloslec, 
                        'activo' => ''];

                    $det_cuotas = DetalleCuotaPago::whereRaw('inscripcion_id= '.$value->inscripcion_id.' AND matricula_id= '.$value->matricula_id.' AND alumno_id= '.$alumno_id)->get();
                    
                    if (count($det_cuotas) > 0) {
                        foreach ($det_cuotas as $det_cuota) {
                            $cuentabancaria = 0;
                            $cheque = 0;
                            $otros = 0;
                            $fechavencimiento = FechaHelper::getFechaImpresion($det_cuota->fechavencimiento);
                            $fechapago = FechaHelper::getFechaImpresion($det_cuota->fechapago);

                            $formapago = Formapagocuota::whereRaw('detallecuotaspago_id= '.$det_cuota->id)->first();

                            if (count($formapago) > 0) {
                                $otros = $formapago->cuentabancaria + $formapago->cheque;
                                $efectivo = $formapago->efectivo;
                                $tarjetacredito = $formapago->tarjetacredito;
                                $tarjetadebito = $formapago->tarjetadebito;
                            } else {
                                if ($det_cuota->efectivo == NULL) {
                                    $efectivo = 0;
                                } else {
                                    $efectivo = $det_cuota->efectivo;
                                }

                                if ($det_cuota->cuentabancaria == NULL) {
                                    $cuentabancaria = 0;
                                } else {
                                    $cuentabancaria = $det_cuota->cuentabancaria;
                                }

                                if ($det_cuota->cheque == NULL) {
                                    $cheque = 0;
                                } else {
                                    $cheque = $det_cuota->cheque;
                                }

                                if ($det_cuota->tarjetacredito == NULL) {
                                    $tarjetacredito = 0;
                                } else {
                                    $tarjetacredito = $det_cuota->tarjetacredito;
                                }

                                if ($det_cuota->tarjetadebito == NULL) {
                                    $tarjetadebito = 0;
                                } else {
                                    $tarjetadebito = $det_cuota->tarjetadebito;
                                }

                                $otros = $cuentabancaria + $cheque;
                            }
                            
                            $tipomovimiento = 'Cta. '.$meses[$det_cuota->mescuota];

                            $matricula[] = [
                                'matricula_id' => $det_cuota->id, 
                                'fechavencimientomatricula' => $fechavencimiento, 
                                'tipomovimiento' => $tipomovimiento, 
                                'efectivo' => $efectivo, 
                                'tarjetacredito' => $tarjetacredito, 
                                'tarjetadebito' => $tarjetadebito, 
                                'otros' => $otros, 
                                'fechapago' => $fechapago, 
                                'nrocomprobante' => $det_cuota->id, 
                                'mespagocuotainicio' => $mespagocuotainicio, 
                                'mespagocuotafin' => $mespagocuotafin, 
                                'mescuota' => $det_cuota->mescuota,
                                'cuotaperiodopagohasta' => $cuotaperiodopagohasta,
                                'cicloslec' => $cicloslec, 
                                'activo' => ''];
                        }
                    } else {
                        $mespagocuotaf = $mespagocuotafin + 1;

                        for ($i=$mespagocuotainicio; $i < $mespagocuotaf; $i++) { 
                            $tipomovimiento = 'Cta. '.$meses[$i];

                            if ($i < 10) {
                                $mescuota = '0'. $i;
                            } else {
                                $mescuota = $i;
                            }

                            $fechavencimiento = $cuotaperiodopagohasta .'/'. $mescuota .'/'. $cicloslec;

                            $matricula[] = [
                                'matricula_id' => $value->matricula_id, 
                                'fechavencimientomatricula' => $fechavencimiento, 
                                'tipomovimiento' => $tipomovimiento, 
                                'efectivo' => '', 
                                'tarjetacredito' => '', 
                                'tarjetadebito' => '', 
                                'otros' => '', 
                                'fechapago' => '', 
                                'nrocomprobante' => '', 
                                'mespagocuotainicio' => $mespagocuotainicio, 
                                'mespagocuotafin' => $mespagocuotafin, 
                                'mescuota' => $i,
                                'cuotaperiodopagohasta' => $cuotaperiodopagohasta,
                                'cicloslec' => $cicloslec, 
                                'activo' => 'disabled'];
                        }
                    }
                } else {
                    $fechavencimiento = FechaHelper::getFechaImpresion($value->fechavencimientomatricula);
                    $mescuota = $mespagocuotainicio - 1;

                    $matricula[] = ['matricula_id' => $value->matricula_id, 'fechavencimientomatricula' => $fechavencimiento, 'tipomovimiento' => 'Matricula', 'efectivo' => 0, 'tarjetacredito' => 0, 'tarjetadebito' => 0, 'otros' => 0, 'fechapago' => '-', 'nrocomprobante' => '-', 'mespagocuotainicio' => $mespagocuotainicio, 'mespagocuotafin' => $mespagocuotafin, 'mescuota' => $mescuota, 'cuotaperiodopagohasta' => $cuotaperiodopagohasta, 'cicloslec' => $cicloslec, 'activo' => 'disabled'];
                }
            }
        }

        /*highlight_string(var_export($matricula,true));
        exit();*/
        return Response::json($matricula);
    }

    public function getImprimirestadoalumno()
    {
        $ciclo_id = Input::get('ciclo_id');
        $carrera_id = Input::get('carrera_id');
        $alumno_id = Input::get('alumno_id');
        
        $alumnos = Alumno::getAlumnoPorAlumnoId($alumno_id);
        $alumno = (count($alumnos)) ? $alumnos[0] : '';

        $alu_carrera = Carrera::find($carrera_id)->carrera;

        $matricula = [];
        $meses = ['vacio', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        $tipomovimiento = '';
        $mespagocuotainicio = 0;
        $mespagocuotafin = 0;
        
        if (!$ciclo_id == '' && !$carrera_id == '' && !$alumno_id == '') {
            $cicloslec = CicloLectivo::find($ciclo_id)->descripcion;

            $matriculas = Matricula::getDatosCuotasMatriculas($carrera_id, $ciclo_id, $alumno_id);//getDatosInscriptosMatriculas($carrera_id, $ciclo_id);

            foreach ($matriculas as $value) {
                $detalle_pagos = DetalleMatriculaPago::whereRaw('inscripcion_id= '.$value->inscripcion_id.' AND matricula_id= '.$value->matricula_id.' AND alumno_id= '.$alumno_id)->first();

                $mespagocuotainicio = $value->mespagocuotainicio;
                $cuotaperiodopagohasta = $value->cuotaperiodopagohasta;

                if ($value->mespagocuotafin == NULL) {
                    $mespagocuotafin = 12;
                } else {
                    $mespagocuotafin = $value->mespagocuotafin;
                }

                if (count($detalle_pagos) > 0) {
                    $fechavencimiento = FechaHelper::getFechaImpresion($detalle_pagos->fechavencimiento);
                    $fechapago = FechaHelper::getFechaImpresion($detalle_pagos->fechapago);

                    $matricula[] = [
                        'matricula_id' => $value->matricula_id, 
                        'fechavencimientomatricula' => $fechavencimiento, 
                        'tipomovimiento' => 'Matricula', 
                        'efectivo' => $detalle_pagos->efectivo, 
                        'tarjetacredito' => $detalle_pagos->tarjetacredito, 
                        'tarjetadebito' => $detalle_pagos->tarjetadebito, 
                        'otros' => $detalle_pagos->cuentabancaria, 
                        'fechapago' => $fechapago, 
                        'nrocomprobante' => $detalle_pagos->id, 
                        'mespagocuotainicio' => $mespagocuotainicio, 
                        'mespagocuotafin' => $mespagocuotafin, 
                        'mescuota' => '',
                        'cuotaperiodopagohasta' => $cuotaperiodopagohasta,
                        'cicloslec' => $cicloslec];

                    $det_cuotas = DetalleCuotaPago::whereRaw('inscripcion_id= '.$value->inscripcion_id.' AND matricula_id= '.$value->matricula_id.' AND alumno_id= '.$alumno_id)->get();
                    
                    if (count($det_cuotas) > 0) {
                        foreach ($det_cuotas as $det_cuota) {
                            $cuentabancaria = 0;
                            $cheque = 0;
                            $otros = 0;
                            $fechavencimiento = FechaHelper::getFechaImpresion($det_cuota->fechavencimiento);
                            $fechapago = FechaHelper::getFechaImpresion($det_cuota->fechapago);

                            $formapago = Formapagocuota::whereRaw('detallecuotaspago_id= '.$det_cuota->id)->first();

                            if (count($formapago) > 0) {
                                $otros = $formapago->cuentabancaria + $formapago->cheque;
                                $efectivo = $formapago->efectivo;
                                $tarjetacredito = $formapago->tarjetacredito;
                                $tarjetadebito = $formapago->tarjetadebito;
                            } else {
                                if ($det_cuota->efectivo == NULL) {
                                    $efectivo = 0;
                                } else {
                                    $efectivo = $det_cuota->efectivo;
                                }

                                if ($det_cuota->cuentabancaria == NULL) {
                                    $cuentabancaria = 0;
                                } else {
                                    $cuentabancaria = $det_cuota->cuentabancaria;
                                }

                                if ($det_cuota->cheque == NULL) {
                                    $cheque = 0;
                                } else {
                                    $cheque = $det_cuota->cheque;
                                }

                                if ($det_cuota->tarjetacredito == NULL) {
                                    $tarjetacredito = 0;
                                } else {
                                    $tarjetacredito = $det_cuota->tarjetacredito;
                                }

                                if ($det_cuota->tarjetadebito == NULL) {
                                    $tarjetadebito = 0;
                                } else {
                                    $tarjetadebito = $det_cuota->tarjetadebito;
                                }

                                $otros = $cuentabancaria + $cheque;
                            }
                            
                            $tipomovimiento = 'Cta. '.$meses[$det_cuota->mescuota];

                            $matricula[] = [
                                'matricula_id' => $det_cuota->id, 
                                'fechavencimientomatricula' => $fechavencimiento, 
                                'tipomovimiento' => $tipomovimiento, 
                                'efectivo' => $efectivo, 
                                'tarjetacredito' => $tarjetacredito, 
                                'tarjetadebito' => $tarjetadebito, 
                                'otros' => $otros, 
                                'fechapago' => $fechapago, 
                                'nrocomprobante' => $det_cuota->id, 
                                'mespagocuotainicio' => $mespagocuotainicio, 
                                'mespagocuotafin' => $mespagocuotafin, 
                                'mescuota' => $det_cuota->mescuota,
                                'cuotaperiodopagohasta' => $cuotaperiodopagohasta,
                                'cicloslec' => $cicloslec];
                        }
                    } else {
                        $mespagocuotaf = $mespagocuotafin + 1;

                        for ($i=$mespagocuotainicio; $i < $mespagocuotaf; $i++) { 
                            $tipomovimiento = 'Cta. '.$meses[$i];

                            if ($i < 10) {
                                $mescuota = '0'. $i;
                            } else {
                                $mescuota = $i;
                            }

                            $fechavencimiento = $cuotaperiodopagohasta .'/'. $mescuota .'/'. $cicloslec;

                            $matricula[] = [
                                'matricula_id' => $value->matricula_id, 
                                'fechavencimientomatricula' => $fechavencimiento, 
                                'tipomovimiento' => $tipomovimiento, 
                                'efectivo' => '', 
                                'tarjetacredito' => '', 
                                'tarjetadebito' => '', 
                                'otros' => '', 
                                'fechapago' => '', 
                                'nrocomprobante' => '', 
                                'mespagocuotainicio' => $mespagocuotainicio, 
                                'mespagocuotafin' => $mespagocuotafin, 
                                'mescuota' => $i,
                                'cuotaperiodopagohasta' => $cuotaperiodopagohasta,
                                'cicloslec' => $cicloslec, 
                                'activo' => 'disabled'];
                        }
                    }
                } else {
                    $fechavencimiento = FechaHelper::getFechaImpresion($value->fechavencimientomatricula);
                    $mescuota = $mespagocuotainicio - 1;

                    $matricula[] = ['matricula_id' => $value->matricula_id, 'fechavencimientomatricula' => $fechavencimiento, 'tipomovimiento' => 'Matricula', 'efectivo' => '', 'tarjetacredito' => '', 'tarjetadebito' => '', 'otros' => '', 'fechapago' => '', 'nrocomprobante' => '', 'mespagocuotainicio' => $mespagocuotainicio, 'mespagocuotafin' => $mespagocuotafin, 'mescuota' => $mescuota, 'cuotaperiodopagohasta' => $cuotaperiodopagohasta, 'cicloslec' => $cicloslec];
                }
            }
        }

        $pdf = PDF::loadView(
            'informes.pdf.deudaporalumno',
            [
                'alumno' => $alumno,
                'carreras' => $alu_carrera,
                'matriculas' => $matricula,
                'meses' => $meses
            ]
        );
        return $pdf->setOrientation('landscape')->stream();
    }  

    /*public function postObteneralumnos() 
    {
        $organizacion_id = Input::get('organizacion_id');
        $ciclo_id = Input::get('cboCiclo');
        $carrera_id = Input::get('cboCarrera');
        $alumno_id = '';
        $alumnos = '';

        $dni = Input::get('txtalumno');
        if (!$dni == '') $alumnos = Alumno::getAlumnoPorDni($dni);

        if (!$alumnos == '') {
            if (count($alumnos) > 0) {
                foreach ($alumnos as $alumno) {
                    $alumno_id = $alumno->alumno_id;
                }
            }
        }

        if ($alumno_id == '') {
            $inscripciones = Matricula::getDatosInscriptosMatriculas($carrera_id, $ciclo_id);
        } else {
            $inscripciones = Matricula::getDatosCuotasMatriculas($carrera_id, $ciclo_id, $alumno_id);
        }

        foreach ($inscripciones as $value) {
            if ($value->ciclolectivo_id == $value->ciclo_inscripcion) {
                $cuotasinscriptos[] = ['nombre' => $value->nombre, 'apellido' => $value->apellido, 'nrodocumento' => $value->nrodocumento, 'inscripcion_id' => $value->inscripcion_id, 'carrera_id' => $value->carrera_id, 'alumno_id' => $value->alumno_id, 'ciclo_inscripcion' => $value->ciclo_inscripcion, 'ciclolectivo_id' => $value->ciclolectivo_id, 'matriculaimporte' => $value->matriculaimporte, 'matricula_id' => $value->matricula_id, 'ciclo_descripcion' => $value->ciclo_descripcion, 'fechavencimientomatricula' => $value->fechavencimientomatricula, 'matriculaaplica' => $value->matriculaaplica, 'cuotaaplica' => $value->cuotaaplica, 'mespagocuotainicio' => $value->mespagocuotainicio, 'mespagocuotafin' => $value->mespagocuotafin, 'cuotaimporte' => $value->cuotaimporte];
            }
        }

        foreach ($inscripciones as $value) {
            if ($value->ciclolectivo_id > $value->ciclo_inscripcion) {
                $cuotasinscriptos[] = ['nombre' => $value->nombre, 'apellido' => $value->apellido, 'nrodocumento' => $value->nrodocumento, 'inscripcion_id' => $value->inscripcion_id, 'carrera_id' => $value->carrera_id, 'alumno_id' => $value->alumno_id, 'ciclo_inscripcion' => $value->ciclo_inscripcion, 'ciclolectivo_id' => $value->ciclolectivo_id, 'matriculaimporte' => $value->matriculaimporte, 'matricula_id' => $value->matricula_id, 'ciclo_descripcion' => $value->ciclo_descripcion, 'fechavencimientomatricula' => $value->fechavencimientomatricula, 'matriculaaplica' => $value->matriculaaplica, 'cuotaaplica' => $value->cuotaaplica, 'mespagocuotainicio' => $value->mespagocuotainicio, 'mespagocuotafin' => $value->mespagocuotafin, 'cuotaimporte' => $value->cuotaimporte];
            }
        }

        asort($cuotasinscriptos);
        
        foreach ($cuotasinscriptos as $value) {
            $detalle_pagos = DetalleCuotaPago::getDatosPagos($value['inscripcion_id'], $value['matricula_id'], $ciclo_id);

            if ($value['mespagocuotafin'] == NULL || $value['mespagocuotafin'] == '') {
                $value['mespagocuotafin'] = 13;
            }

            if (!$detalle_pagos) {
                $detalle_pagos = '';
            }

            $beca = Beca::whereRaw('inscripcion_id =' . $value['inscripcion_id'] . ' AND ciclolectivo_id =' . $value['ciclolectivo_id'] . ' and becado=1')->get();

            $beca = (count($beca)) ? $beca[0] : '';

            $carrera = Carrera::whereRaw('id ='. $value['carrera_id'])->first();
            $ciclo = $value['ciclo_descripcion'];

            $matriculas[] = ['apellido' => $value['apellido'], 'nombre' => $value['nombre'], 'nrodocumento' => $value['nrodocumento'], 'carrera' => $carrera->carrera, 'ciclo' => $ciclo, 'ciclolectivo_id' => $value['ciclolectivo_id'], 'carrera_id' => $value['carrera_id'], 'alumno_id' => $value['alumno_id'], 'mespagocuotainicio' => $value['mespagocuotainicio'], 'mespagocuotafin' => $value['mespagocuotafin'], 'cuotaimporte' => $value['cuotaimporte'], 'beca' => $beca, 'detalle_cuotas' => $detalle_pagos];
        }

        $organizaciones = Organizacion::lists('nombre', 'id');

        return View::make('cuotas/listado')
            ->with('organizaciones', $organizaciones)
            ->with('matriculas', $matriculas)
            ->with('menu', ModulosHelper::MENU_GESTION_CONTABLE)
            ->with('submenu', ModulosHelper::SUBMENU_PAGO_CUOTAS)
            ->with('leer', Session::get('PAGOCUOTAS_LEER'))
            ->with('editar', Session::get('PAGOCUOTAS_EDITAR'))
            ->with('imprimir', Session::get('PAGOCUOTAS_IMPRIMIR'))
            ->with('eliminar', Session::get('PAGOCUOTAS_ELIMINAR'));                
    }*/

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
