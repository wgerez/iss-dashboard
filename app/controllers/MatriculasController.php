<?php
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MatriculasController extends BaseController {

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
    const MATRICULA_IMPAGA = 8;
    const NO_EXISTE_MATRICULA = 9;

    public function getGestion()
    {
        $organizaciones = Organizacion::lists('nombre', 'id');
        $organizaciones[0] = 'Seleccionar';
        ksort($organizaciones);

        return View::make('matriculas.gestion')
            ->with('organizaciones', $organizaciones)
            ->with('menu', ModulosHelper::MENU_GESTION_CONTABLE)
            ->with('submenu', ModulosHelper::SUBMENU_GESTION_MATRICULA)
            ->with('leer', Session::get('GESTIONMATRICULA_LEER'))
            ->with('editar', Session::get('GESTIONMATRICULA_EDITAR'))
            ->with('imprimir', Session::get('GESTIONMATRICULA_IMPRIMIR'))
            ->with('eliminar', Session::get('GESTIONMATRICULA_ELIMINAR'));
    }

    public function postGuardar()
    {
        $this->_setAttributesValidation();

        $validator = Validator::make($this->_data, $this->_rules, $this->_messages);

        if ($validator->fails()) {
            Session::flash('message', 'ERROR AL INTENTAR GUARDAR.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('matriculas/gestion')
                ->withErrors($validator);
        }

        $organizacion = Input::get('cboOrganizacion');
        $carrera = Input::get('cboCarrera');

        if ($organizacion == 0) {
            Session::flash('message', 'ERROR AL INTENTAR GUARDAR. DEBE SELECCIONAR UNA ORGANIZACIÓN.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('matriculas/gestion');
        }

        if ($carrera == 0) {
            Session::flash('message', 'ERROR AL INTENTAR GUARDAR. DEBE SELECCIONAR UNA CARRERA.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('matriculas/gestion');
        }

        $matricula_id = Input::get('txt_matricula_id');

        if (trim($matricula_id) == '') {
            if ($this->_existeMatriculaParaLaCarrera($organizacion, $carrera)) {
                Session::flash('message', 'LA CARRERA YA TIENE UNA MATRICULA ASIGNADA.');
                Session::flash('message_type', self::OPERACION_FALLIDA);
                return Redirect::to('matriculas/gestion');
            }

            $this->_crearMatricula($organizacion, $carrera);
        } else {
            $this->_modificarMatricula($matricula_id);
        }

        Session::flash('message_type', self::OPERACION_EXITOSA);
        return Redirect::to('matriculas/gestion');
    }

    public function postEditar()
    {
        $id = Input::get('id');
        $matricula = Matricula::find($id);
        return Response::json($matricula);
    }

    public function getEliminar($id)
    {
        $matricula = Matricula::find($id);

        if ($this->_noSePuedeBorrar($matricula)) {
            Session::flash('message', 'NO ES POSIBLE BORRAR LA MATRICULA.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('matriculas/gestion');
        }

        try
        {
            $matricula->delete();
        }
        catch(Exception $ex)
        {
            Session::flash('message', 'LA MATRÍCULA TIENE INFORMACIÓN RELACIONADA. NO SE PUEDE ELIMINAR.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('matriculas/gestion');
        }

        Session::flash('message', 'MATRICULA BORRADA DE LA BASE DE DATOS.');
        Session::flash('message_type', self::OPERACION_EXITOSA);
        return Redirect::to('matriculas/gestion');
    }

    /* REFACTORING LO QUE SE ENVIA POR JSON */
    public function postObtenercicloactivo()
    {
        $organizacion_id = Input::get('organizacion_id');
        $existe = CicloLectivo::verificaExisteCicloActivo($organizacion_id);

        if (!$existe)
            return Response::json(self::NO_EXISTE_CICLO_ACTIVO);

        $ciclo_lectivo_activo = CicloLectivo::getCicloActivo($organizacion_id);

        $periodos = $ciclo_lectivo_activo[0]->periodoslectivos;

        $ciclo_lectivo_activo[0]->fechafin = FechaHelper::getFechaImpresion($ciclo_lectivo_activo[0]->fechafin);

        return Response::json($ciclo_lectivo_activo[0]);
    }

    public function postObtenercarrerasinscripciones()
    {
        $alumno_id = Input::get('alumno_id');
        $carreras  = AlumnoCarrera::getCarrerasInscripciones($alumno_id);
        $ids = array();

        if (count($carreras) == 0) //{
            return self::NO_EXISTE_INSCRIPCION;
        /*} else {
            foreach ($carreras as $value) {
                array_push($ids, $value->id);
            }

            $id = array_unique($ids);
            
            for ($i=0; $i < count($ids); $i++) { 
                if (isset($id[$i])) {
                    $carrera = Carrera::whereRaw('id =' . $id[$i])->first();
                    $carrerass[] = ['carrera_id' => $carrera->id, 'carrera' => $carrera->carrera];
                }
            }
        }*/

        return Response::json($carreras);
    }

    public function postObtenerciclos()
    {
        //$ciclos = CicloLectivo::all();
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

        return Response::json($ciclos);
    }

    public function postObtenerdatosinscripcion()
    {
        $alumno_id = Input::get('alumno_id');
        $id = Input::get('inscripcion_id');
        $inscripciones = AlumnoCarrera::getDatosInscripcion($id);

        foreach ($inscripciones as $value) {
            $cicloinicio = CicloLectivo::whereRaw('id = '. $value->cicloinicio)->first()->descripcion;

            if ($value->ciclo_descripcion == $cicloinicio || $value->ciclo_descripcion > $cicloinicio) {
                $inscripcion[] = ['inscripcion_id' => $value->inscripcion_id, 'carrera_id' => $value->carrera_id, 'ciclolectivo_id' => $value->ciclolectivo_id, 'mespagocuotainicio' => $value->mespagocuotainicio, 'matriculaimporte' => $value->matriculaimporte, 'cuotaimporte' => $value->cuotaimporte, 'matriculaperiodopagodesde' => $value->matriculaperiodopagodesde, 'matriculaperiodopagohasta' => $value->matriculaperiodopagohasta, 'cuotaperiodopagodesde' => $value->cuotaperiodopagodesde, 'cuotaperiodopagohasta' => $value->cuotaperiodopagohasta, 'cuotasporperiodo' => $value->cuotasporperiodo, 'matricula_id' => $value->matricula_id, 'ciclo_descripcion' => $value->ciclo_descripcion, 'fecha_inicio_ciclo_lectivo' => $value->fecha_inicio_ciclo_lectivo, 'fecha_fin_ciclo_lectivo' => $value->fecha_fin_ciclo_lectivo, 'matricula_fecha_vencimiento' => $value->matricula_fecha_vencimiento, 'matriculaaplica' => $value->matriculaaplica, 'cuotaaplica' => $value->cuotaaplica];
            }
        }

        //foreach ($inscripcion as $value) {
        for ($i=0; $i < count($inscripcion); $i++) { 
            $detalle_pagos = DetalleMatriculaPago::getCuotasPagadas($inscripcion[$i]['inscripcion_id'], $inscripcion[$i]['matricula_id']);
            $inscripcion[$i]['detalle_cuotas'] = $detalle_pagos;

            $beca = Beca::whereRaw('inscripcion_id =' . $inscripcion[$i]['inscripcion_id'] . ' and becado=1')->get();
            $inscripcion[$i]['beca'] = (count($beca)) ? $beca[0] : self::NO_TIENE_BECA;
        }
/*highlight_string(var_export($inscripcion, true));
exit();*/
        return Response::json($inscripcion);
    }

    public function postGenerarinscripcion()
    {
        $id = Input::get('inscripcion_id');
        $ciclo = Input::get('ciclo');
        $alumno_id = Input::get('alumno_id');

        $inscripcion = AlumnoCarrera::getDatosInscripcion($id);
        
        foreach ($inscripcion as $value) {
            $carrera_id = $value->carrera_id;
        }

        $matricula = Matricula::whereRaw('carrera_id='. $carrera_id. ' AND ciclolectivo_id= '. $ciclo)->get();

        if (count($matricula) > 0) {
            $inscripcion = AlumnoCarrera::getDatosInscripcion($id);
        } else {
            $matricula = Matricula::whereRaw('carrera_id='. $carrera_id)->get();
            $inscripcions = $matricula->last();
    /*highlight_string(var_export($inscripcions, true));
    exit();*/
            $carreras  = AlumnoCarrera::find($id);
            $ciclos = CicloLectivo::whereRaw('id='. $ciclo)->first();

            $inscripciones = new Matricula;
            $inscripciones->organizacion_id             = $ciclos->organizacion_id;
            $inscripciones->carrera_id                  = $carreras->carrera_id;
            $inscripciones->ciclolectivo_id             = $ciclo;
            $inscripciones->matriculaaplica             = 1;
            $inscripciones->cuotaaplica                 = 1;
            $inscripciones->matriculaimporte            = $inscripcions->matriculaimporte;
            $inscripciones->cuotaimporte                = $inscripcions->cuotaimporte;
            $inscripciones->fechavencimientomatricula   = $ciclos->fechafin;
            $inscripciones->usuario_alta                = Auth::user()->usuario;
            $inscripciones->fecha_alta                  = date('Y-m-d');
            $inscripciones->save();
    /*
            $matriculas = Matricula::all();
            $matriculass = $matriculas->last();

            $detalles = new DetalleMatriculaPago;
            $detalles->inscripcion_id               = $id;
            $detalles->matricula_id                 = $matriculass->id;
            $detalles->alumno_id                    = $carreras->alumno_id;
            $detalles->mescuota                     = 0;
            $detalles->importe                      = $inscripcions->cuotaimporte;
            $detalles->porcentajerecargo            = 0;
            $detalles->porcentajedescuento          = 0;
            $detalles->fechavencimiento             = $ciclos->fechafin;
            $detalles->fecha_pago                   = date('Y-m-d');
            $detalles->estado                       = 1;
            $detalles->usuario_alta                 = Auth::user()->usuario;
            $detalles->fecha_alta                   = date('Y-m-d');
            $detalles->save();
    */
            $inscripcion = AlumnoCarrera::getDatosInscripcion($id);
        }

        return Response::json($inscripcion);
    }

    public function postObtenerdatosparapago()
    {
        $id = Input::get('inscripcion_id');
        $tipo_pago = Input::get('tipo_pago');
        $matricula_id = Input::get('matricula_id');

        if ($tipo_pago == 'matricula') {
            $inscripcion = AlumnoCarrera::getDatosPagoMatricula($id, $matricula_id);
        } elseif ($tipo_pago == 'cuota') {
            $inscripcion = AlumnoCarrera::getDatosPagoCuota($id, $matricula_id);
        }

        return Response::json($inscripcion[0]);
    }

    public function postObtenerdatospagorealizado()
    {
        $inscripcion_id = Input::get('inscripcion_id');
        $mes = Input::get('mes');
        $matricula_id = Input::get('matricula_id');

        $pagos = DetalleMatriculaPago::getDatosPagoRealizado($inscripcion_id, $mes, $matricula_id);

        if (!isset($pagos)) {
            $pagos = [];
        } else {
            $matricula = Matricula::whereRaw('id =' . $matricula_id)->first();
            $ciclolectivo = CicloLectivo::whereRaw('id = ' . $matricula->ciclolectivo_id)->first();
            
            foreach ($pagos as $value) {
                $value->ciclo_descripcion = $ciclolectivo->descripcion;
                $value->matriculaimporte = $matricula->matriculaimporte;
            }
        }
/*highlight_string(var_export($pagos, true));
exit();*/
        return Response::json($pagos);
    }

    public function postObtenerhistorico()
    {
        $organizacion_id = Input::get('organizacion_id');
        $carrera_id = Input::get('carrera_id');

        $matriculas = Matricula::with('ciclolectivo')
            ->whereRaw('organizacion_id=' . $organizacion_id . ' and carrera_id=' . $carrera_id)
            ->get();

        return Response::json($matriculas);
    }

    public function getListado()
    {
        $organizaciones = Organizacion::lists('nombre', 'id');
        $organizaciones[0] = 'Seleccionar';
        ksort($organizaciones);

        $habilita = false;
        
        return View::make('matriculas.listado')
            ->with('organizaciones', $organizaciones)
            ->with('habilita', $habilita)
            ->with('menu', ModulosHelper::MENU_GESTION_CONTABLE)
            ->with('submenu', ModulosHelper::SUBMENU_PAGO_MATRICULA)
            ->with('leer', Session::get('PAGOMATRICULA_LEER'))
            ->with('editar', Session::get('PAGOMATRICULA_EDITAR'))
            ->with('imprimir', Session::get('PAGOMATRICULA_IMPRIMIR'))
            ->with('eliminar', Session::get('PAGOMATRICULA_ELIMINAR'));
    }

    public function postObtenerlistado() 
    {
        $organizacion_id = Input::get('cboOrganizacion');
        $ciclo_id = Input::get('cboCiclo');
        $carrera_id = Input::get('cboCarrera');
        $ciclos = array();
        $carreras = array();
        $matricula = array();
        $habilita = false;
        $organizaciones = Organizacion::lists('nombre', 'id');
        $organizaciones[0] = 'Seleccionar';
        ksort($organizaciones);
        $matriculass = [];

        if (!$ciclo_id == '' && !$carrera_id == '') {
            $ciclos = CicloLectivo::where('organizacion_id', '=', $organizacion_id)->get();

            $carreras = AlumnoCarrera::getCarrerasPorCiclo($ciclo_id);

            $matriculas = Matricula::getDatosInscriptosMatriculas($carrera_id, $ciclo_id);

            foreach ($matriculas as $value) {
                $ciclomatricula = CicloLectivo::whereRaw('id = ' . $value->ciclolectivo_id)->first()->descripcion;
                $cicloinscripcion = CicloLectivo::whereRaw('id = ' . $value->ciclo_inscripcion)->first()->descripcion;

                if ($cicloinscripcion == $ciclomatricula || $ciclomatricula > $cicloinscripcion) {
                    $matricula[] = ['nombre' => $value->nombre, 'apellido' => $value->apellido, 'nrodocumento' => $value->nrodocumento, 'inscripcion_id' => $value->inscripcion_id, 'carrera_id' => $value->carrera_id, 'ciclolectivo_id' => $value->ciclolectivo_id, 'matriculaimporte' => $value->matriculaimporte, 'matricula_id' => $value->matricula_id, 'ciclo_descripcion' => $value->ciclo_descripcion, 'fechavencimientomatricula' => $value->fechavencimientomatricula, 'matriculaaplica' => $value->matriculaaplica, 'cuotaaplica' => $value->cuotaaplica, 'mespagocuotainicio' => $value->mespagocuotainicio, 'mespagocuotafin' => $value->mespagocuotafin];
                }
            }

            for ($i=0; $i < count($matricula); $i++) { 
                $detalle_pagos = DetalleMatriculaPago::getDatosPagos($matricula[$i]['inscripcion_id'], $matricula[$i]['matricula_id']);
                $matricula[$i]['detalle_cuotas'] = $detalle_pagos;

                $beca = Beca::whereRaw('inscripcion_id =' . $matricula[$i]['inscripcion_id'] . ' AND ciclolectivo_id =' . $matricula[$i]['ciclolectivo_id'] . ' and becado=1')->get();
                $matricula[$i]['beca'] = (count($beca)) ? $beca[0] : self::NO_TIENE_BECA;
            }
            /////////////////////////////////////
            foreach ($matricula as $matricul) {
                $ya_pago_matricula = false;
                $parcial = false;
                $tiene_beca = false;

                if ($matricul['beca'] == '7') {
                    $tiene_beca = false;
                } else {
                    $tiene_beca = true;
                }

                if ($matricul['matriculaaplica'] == '1') {
                    foreach ($matricul['detalle_cuotas'] as $value) {
                        if ($value->estado == 1) {
                            $ya_pago_matricula = true;
                            if ($value->totalparcial == 1) {
                                $parcial = true;
                            }
                        }
                    }

                    if ($ya_pago_matricula) {
                        if ($parcial) {
                            $td_matricula = 'class=warning';
                            $content = '<center><i class="fa fa-exclamation-triangle"></i></center>';
                        } else {
                            $td_matricula = 'class=success';
                            $content = '<center><i class="fa fa-check"></i></center>';
                        }
                    } else {
                        $fecha_vencimiento = $matricul['fechavencimientomatricula'];
                        
                        $fecha_actual = date("Y-m-d");

                        if ($fecha_vencimiento > $fecha_actual) {
                            $td_matricula = '';
                            $content = '<center><i class="fa fa-exclamation-triangle"></i></center>';
                        } else {
                            $td_matricula = 'class=danger';
                            $content = '<center><i class="fa fa-exclamation-triangle"></i></center>';
                        }

                        if ($tiene_beca == true) {
                            $td_matricula = 'class=info';
                            $content = '<center><i class="fa fa-asterisk"></i></center>';
                        }
                    }
                } else {
                    $td_matricula = '';
                    $content = '';
                }

                $matriculass[] = ['nombre' => $matricul['nombre'], 'apellido' => $matricul['apellido'], 'nrodocumento' => $matricul['nrodocumento'], 'td_matricula' => $td_matricula, 'content' => $content];
            }
            ////////////////////////

            //highlight_string(var_export($matricula,true));
            //exit;
            $habilita = true;
            $organizaciones = Organizacion::lists('nombre', 'id');
        }

        return View::make('matriculas.listado')
            ->with('organizaciones', $organizaciones)
            ->with('ciclo_id', $ciclo_id)
            ->with('ciclos', $ciclos)
            ->with('carrera', $carrera_id)
            ->with('carreras', $carreras)
            ->with('matricula', $matriculass)
            ->with('habilita', $habilita)
            ->with('menu', ModulosHelper::MENU_GESTION_CONTABLE)
            ->with('submenu', ModulosHelper::SUBMENU_PAGO_MATRICULA)
            ->with('leer', Session::get('PAGOMATRICULA_LEER'))
            ->with('editar', Session::get('PAGOMATRICULA_EDITAR'))
            ->with('imprimir', Session::get('PAGOMATRICULA_IMPRIMIR'))
            ->with('eliminar', Session::get('PAGOMATRICULA_ELIMINAR'));
    }
/*
    public function postObtenermatriculaporcarrerayciclo()
    {
        $organizacion_id = Input::get('organizacion');
        $ciclo_id = Input::get('ciclo');
        $carrera_id = Input::get('carrera');

        $matriculas = Matricula::whereRaw(
                'organizacion_id=' . $organizacion_id
                . ' and carrera_id=' . $carrera_id
                . ' and ciclolectivo_id=' . $ciclo_id)
            ->get();

        return Response::json($matriculas[0]);
    }
*/
    public function postObtenermatriculaporcarrerayciclo()
    {
        $organizacion_id = Input::get('organizacion');
        $ciclo_id = Input::get('ciclo');
        $carrera_id = Input::get('carrera');

        $matriculas = Matricula::getDatosInscriptosMatriculas($carrera_id, $ciclo_id);

        foreach ($matriculas as $value) {
            $ciclomatricula = CicloLectivo::whereRaw('id = ' . $value->ciclolectivo_id)->first()->descripcion;
            $cicloinscripcion = CicloLectivo::whereRaw('id = ' . $value->ciclo_inscripcion)->first()->descripcion;

            if ($cicloinscripcion == $ciclomatricula || $ciclomatricula > $cicloinscripcion) {
                $matricula[] = ['nombre' => $value->nombre, 'apellido' => $value->apellido, 'nrodocumento' => $value->nrodocumento, 'inscripcion_id' => $value->inscripcion_id, 'carrera_id' => $value->carrera_id, 'ciclolectivo_id' => $value->ciclolectivo_id, 'matriculaimporte' => $value->matriculaimporte, 'matricula_id' => $value->matricula_id, 'ciclo_descripcion' => $value->ciclo_descripcion, 'fechavencimientomatricula' => $value->fechavencimientomatricula, 'matriculaaplica' => $value->matriculaaplica, 'cuotaaplica' => $value->cuotaaplica, 'mespagocuotainicio' => $value->mespagocuotainicio, 'mespagocuotafin' => $value->mespagocuotafin];
            }
        }

        for ($i=0; $i < count($matricula); $i++) { 
            $detalle_pagos = DetalleMatriculaPago::getDatosPagos($matricula[$i]['inscripcion_id'], $matricula[$i]['matricula_id']);
            $matricula[$i]['detalle_cuotas'] = $detalle_pagos;

            $beca = Beca::whereRaw('inscripcion_id =' . $matricula[$i]['inscripcion_id'] . ' AND ciclolectivo_id =' . $matricula[$i]['ciclolectivo_id'] . ' and becado=1')->get();
            $matricula[$i]['beca'] = (count($beca)) ? $beca[0] : self::NO_TIENE_BECA;
        }

        /*foreach ($matricula as $value) {
            $detalle_pagos = DetalleMatriculaPago::getDatosPagos($value->inscripcion_id, $value->matricula_id);
            $value->detalle_cuotas = $detalle_pagos;

            $beca = Beca::whereRaw('inscripcion_id =' . $value->inscripcion_id . ' AND ciclolectivo_id =' . $value->ciclolectivo_id . ' and becado=1')->get();
            $value->beca = (count($beca)) ? $beca[0] : self::NO_TIENE_BECA;
        }*/

/*highlight_string(var_export($matriculas,true));
        exit;*/
        
        return Response::json($matricula);
    }

    public function getPagar()
    {
        return View::make('matriculas.gestionPagos')
            ->with('menu', ModulosHelper::MENU_GESTION_CONTABLE)
            ->with('submenu', ModulosHelper::SUBMENU_PAGO_MATRICULA)
            ->with('leer', Session::get('PAGOMATRICULA_LEER'))
            ->with('editar', Session::get('PAGOMATRICULA_EDITAR'))
            ->with('imprimir', Session::get('PAGOMATRICULA_IMPRIMIR'))
            ->with('eliminar', Session::get('PAGOMATRICULA_ELIMINAR'));
    }

    public function postRegistrarpago()
    {
        $persona_id        = Input::get('txt_persona_id');
        $inscripcion_id    = Input::get('txt_inscripcion_id');
        $matricula_id      = Input::get('txt_matricula_id');
        $alumno_id         = Input::get('txt_alumno_id');
        $numero_cuota      = Input::get('txt_numero_cuota'); // mes
        $importe           = Input::get('txt_total_a_pagar');
        $recargo           = Input::get('txt_recargo');
        $descuento         = Input::get('txt_descuento');

        $totalparcial      = Input::get('parcialfra');
        $txt_total_parcial = Input::get('txt_total_parcial');        
        $importe_parcial   = Input::get('txt_importe_parcial');
        $saldo             = Input::get('txt_saldo');
        $efectivo          = Input::get('txt_efectivo');
        $tarjeta           = Input::get('txt_tarjeta');
        $debito            = Input::get('txt_debito');
        $bancaria          = Input::get('txt_bancaria');

        $fecha_vencimiento = Input::get('txt_fecha_vencimiento');
        $fecha_pago        = date('Y-m-d');
        $estado            = 1;

        if ($efectivo == '' && $tarjeta == '' && $debito == '' && $bancaria == '') {
            Session::flash('message', 'ERROR AL INTENTAR GUARDAR EL PAGO. ESPECIFIQUE FORMA DE PAGO');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('matriculas/pagarcuotas/' . $persona_id)
                ->withInput();
        }

        if ($totalparcial == '') {
            $totalparcial = 0;
        }

        if ($efectivo == '') $efectivo = 0;
        
        if ($tarjeta == '') $tarjeta = 0;
        
        if ($debito == '') $debito = 0;
        
        if ($bancaria == '') $bancaria = 0;

        $totalcalculado = $efectivo + $tarjeta + $debito + $bancaria;

        if ($txt_total_parcial == 0) {
            if ($totalcalculado < $importe) {
                Session::flash('message', 'ERROR AL INTENTAR GUARDAR EL PAGO. LAS FORMA DE PAGO DEBE SER IGUAL AL TOTAL A ABONAR');
                Session::flash('message_type', self::OPERACION_FALLIDA);
                return Redirect::to('matriculas/pagarcuotas/' . $persona_id)
                    ->withInput();
            }
        }

        //$observaciones     = Input::get('txt_observaciones');

        /*echo $persona_id . '<br>';
        echo $inscripcion_id . '<br>';
        echo $matricula_id . '<br>';
        echo $alumno_id . '<br>';
        echo $numero_cuota . '<br>';
        echo $importe . '<br>';

        echo $totalparcial . '<br>';
        echo $importe_parcial . '<br>';
        echo $saldo . '<br>';
        echo $efectivo . '<br>';
        echo $tarjeta . '<br>';
        echo $debito . '<br>';
        echo $bancaria . '<br>';

        echo $recargo . '<br>';
        echo $descuento . '<br>';
        echo $fecha_vencimiento . '<br>';
        echo 'txt_total_parcial ' .$txt_total_parcial . '<br>';
        echo 'importe_parcial ' .$importe_parcial . '<br>';
        //echo $observaciones . '<br>';
        exit();*/
        $fecha_vencimiento = FechaHelper::getFechaParaGuardar($fecha_vencimiento);

        $pagos = DetalleMatriculaPago::whereRaw('inscripcion_id='.$inscripcion_id. ' AND matricula_id='. $matricula_id . ' AND mescuota='. $numero_cuota)->first();

        if (isset($pagos)) {
            
            if ($txt_total_parcial == 1) {
                if ($totalcalculado < $pagos->saldo) {
                Session::flash('message', 'ERROR AL INTENTAR GUARDAR EL PAGO. LAS FORMA DE PAGO DEBE SER IGUAL AL TOTAL A ABONAR');
                Session::flash('message_type', self::OPERACION_FALLIDA);
                return Redirect::to('matriculas/pagarcuotas/' . $persona_id)
                    ->withInput();
                }
            }

            $detalle_matricula = DetalleMatriculaPago::find($pagos->id);
            
            $detalle_matricula->inscripcion_id      = $inscripcion_id;
            $detalle_matricula->matricula_id        = $matricula_id;
            $detalle_matricula->alumno_id           = $alumno_id;
            $detalle_matricula->mescuota            = $numero_cuota; // mes
            $detalle_matricula->importe             = $importe;
            $detalle_matricula->totalparcial        = $totalparcial;
            $detalle_matricula->importeparcial      = $importe_parcial;
            $detalle_matricula->saldo               = $saldo;
            $detalle_matricula->efectivo            = $efectivo;
            $detalle_matricula->tarjetacredito      = $tarjeta;
            $detalle_matricula->tarjetadebito       = $debito;
            $detalle_matricula->cuentabancaria      = $bancaria;
            $detalle_matricula->porcentajerecargo   = $recargo;
            $detalle_matricula->porcentajedescuento = $descuento;
            $detalle_matricula->fechavencimiento    = $fecha_vencimiento;
            $detalle_matricula->fechapago           = $fecha_pago;
            $detalle_matricula->estado              = $estado;
            //$detalle_matricula->observaciones       = $observaciones;
            $detalle_matricula->usuario_modi        = Auth::user()->usuario;
            $detalle_matricula->fecha_modi          = date('Y-m-d');
            $detalle_matricula->save();
        } else {
            
            if ($txt_total_parcial == 1) {
                if ($importe_parcial == '') {
                    Session::flash('message', 'ERROR AL INTENTAR GUARDAR EL PAGO. DEBE INGRESAR EL IMPORTE PARCIAL A ABONAR');
                    Session::flash('message_type', self::OPERACION_FALLIDA);
                    return Redirect::to('matriculas/pagarcuotas/' . $persona_id)
                        ->withInput();
                }
            }

            $detalle_matricula = new DetalleMatriculaPago;

            $detalle_matricula->inscripcion_id      = $inscripcion_id;
            $detalle_matricula->matricula_id        = $matricula_id;
            $detalle_matricula->alumno_id           = $alumno_id;
            $detalle_matricula->mescuota            = $numero_cuota; // mes
            $detalle_matricula->importe             = $importe;
            $detalle_matricula->totalparcial        = $totalparcial;
            $detalle_matricula->importeparcial      = $importe_parcial;
            $detalle_matricula->saldo               = $saldo;
            $detalle_matricula->efectivo            = $efectivo;
            $detalle_matricula->tarjetacredito      = $tarjeta;
            $detalle_matricula->tarjetadebito       = $debito;
            $detalle_matricula->cuentabancaria      = $bancaria;
            $detalle_matricula->porcentajerecargo   = $recargo;
            $detalle_matricula->porcentajedescuento = $descuento;
            $detalle_matricula->fechavencimiento    = $fecha_vencimiento;
            $detalle_matricula->fechapago           = $fecha_pago;
            $detalle_matricula->estado              = $estado;
            //$detalle_matricula->observaciones       = $observaciones;
            $detalle_matricula->usuario_alta        = Auth::user()->usuario;
            $detalle_matricula->fecha_alta          = date('Y-m-d');
            $detalle_matricula->save();
        }

        Session::flash('message', 'PAGO REGISTRADO CON ÉXITO!');
        Session::flash('message_type', self::OPERACION_EXITOSA);
        return Redirect::to('matriculas/pagarcuotas/' . $persona_id);
    }

    public function postAnularpago()
    {
        $persona_id = Input::get('txt_persona_id_verInfo');
        $pago_id = Input::get('txt_pago_id_verInfo');
        
        $pago = DetalleMatriculaPago::find($pago_id);

        try
        {
            $pago->delete();
        }
        catch(Exception $ex)
        {
            Session::flash('message', 'NO SE PUEDE ANULAR.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('matriculas/pagarcuotas/' . $persona_id);
        }

        Session::flash('message', 'EL PAGO HA SIDO ANULADO');
        Session::flash('message_type', self::OPERACION_EXITOSA);
        return Redirect::to('matriculas/pagarcuotas/' . $persona_id);
    }

    public function getPagarcuotas($alumno_id)
    {
        $arrAlumno = Alumno::getAlumnoPorId($alumno_id);
        $alumno    = $arrAlumno[0];
        $carreras  = AlumnoCarrera::getCarrerasInscripciones($alumno->alumno_id);
        $ciclos    = CicloLectivo::all();

        $ultimopago = DetalleMatriculaPago::whereRaw('alumno_id ='.$alumno->alumno_id)->get();

        if (count($ultimopago) > 0) {
            $ultimopagos = $ultimopago->last();
            $inscripcionid = $ultimopagos->inscripcion_id;
        } else {
            $inscripcionid = $carreras[0]->inscripcion_id;
        }
        
        $inscripciones = AlumnoCarrera::getDatosInscripcion($inscripcionid);

        foreach ($inscripciones as $value) {
            $cicloinicio = CicloLectivo::whereRaw('id = '. $value->cicloinicio)->first()->descripcion;

            if ($value->ciclo_descripcion == $cicloinicio || $value->ciclo_descripcion > $cicloinicio) {
                $fecha_inicio_ciclo_lectivo = FechaHelper::getFechaImpresion($value->fecha_inicio_ciclo_lectivo);
                $fecha_fin_ciclo_lectivo = FechaHelper::getFechaImpresion($value->fecha_fin_ciclo_lectivo);
                $matricula_fecha_vencimiento = FechaHelper::getFechaImpresion($value->matricula_fecha_vencimiento);
                $ciclo_lectivo = $value->ciclolectivo_id;

                $inscripcion[] = ['inscripcion_id' => $value->inscripcion_id, 'carrera_id' => $value->carrera_id, 'ciclolectivo_id' => $value->ciclolectivo_id, 'mespagocuotainicio' => $value->mespagocuotainicio, 'matriculaimporte' => $value->matriculaimporte, 'cuotaimporte' => $value->cuotaimporte, 'matriculaperiodopagodesde' => $value->matriculaperiodopagodesde, 'matriculaperiodopagohasta' => $value->matriculaperiodopagohasta, 'cuotaperiodopagodesde' => $value->cuotaperiodopagodesde, 'cuotaperiodopagohasta' => $value->cuotaperiodopagohasta, 'cuotasporperiodo' => $value->cuotasporperiodo, 'matricula_id' => $value->matricula_id, 'ciclo_descripcion' => $value->ciclo_descripcion, 'fecha_inicio_ciclo_lectivo' => $fecha_inicio_ciclo_lectivo, 'fecha_fin_ciclo_lectivo' => $fecha_fin_ciclo_lectivo, 'matricula_fecha_vencimiento' => $matricula_fecha_vencimiento, 'matriculaaplica' => $value->matriculaaplica, 'cuotaaplica' => $value->cuotaaplica];
            }
        }

        for ($i=0; $i < count($inscripcion); $i++) { 
            $detalle_pagos = DetalleMatriculaPago::getCuotasPagadas($inscripcion[$i]['inscripcion_id'], $inscripcion[$i]['matricula_id']);
            $inscripcion[$i]['detalle_cuotas'] = $detalle_pagos;
            $inscripcion_ids = $inscripcion[$i]['inscripcion_id'];

            $beca = Beca::whereRaw('inscripcion_id =' . $inscripcion[$i]['inscripcion_id'] . ' and becado=1')->get();
            $inscripcion[$i]['beca'] = (count($beca)) ? $beca[0] : self::NO_TIENE_BECA;
        }
/*highlight_string(var_export($inscripcion, true));
exit();*/

        return View::make('matriculas.gestionPagosEdicion')
            ->with('alumno', $alumno)
            ->with('carreras', $carreras)
            ->with('ciclos', $ciclos)
            ->with('ciclo_lectivo', $ciclo_lectivo)
            ->with('inscripciones', $inscripcion)
            ->with('inscripcion_id', $inscripcion_ids)
            ->with('menu', ModulosHelper::MENU_GESTION_CONTABLE)
            ->with('submenu', ModulosHelper::SUBMENU_PAGO_MATRICULA)
            ->with('leer', Session::get('PAGOMATRICULA_LEER'))
            ->with('editar', Session::get('PAGOMATRICULA_EDITAR'))
            ->with('imprimir', Session::get('PAGOMATRICULA_IMPRIMIR'))
            ->with('eliminar', Session::get('PAGOMATRICULA_ELIMINAR'));
    }

    public function postObtenerpagospormatricula()
    {
        $matricula = Input::get('matricula');
        $pagos = DetalleMatriculaPago::where('matricula_id', '=', $matricula)
            ->orderBy('alumno_id')
            ->orderBy('mescuota')
            ->get();

        return Response::json($pagos);
    }

    /*
    | COMIENZO DE METODOS PARA INFORMES DE MATRICULAS
    */
    public function getInforme()
    {
        return View::make('informes/matriculas')
            ->with('menu', ModulosHelper::MENU_INFORMES)
            ->with('submenu', ModulosHelper::SUBMENU_INFORMES_MATRICULAS)
            ->with('leer', Session::get('INFORME_MATRICULAS_LEER'))
            ->with('editar', Session::get('INFORME_MATRICULAS_EDITAR'))
            ->with('imprimir', Session::get('INFORME_MATRICULAS_IMPRIMIR'))
            ->with('eliminar', Session::get('INFORME_MATRICULAS_ELIMINAR'));
    }

    /* INFORME DE PAGOS */
    public function getInformepagos()
    {
        $organizaciones = Organizacion::lists('nombre', 'id');

        array_unshift($organizaciones, 'Seleccionar');
        $habilita = false;

        return View::make('informes/matriculas_pagos')
            ->with('menu', ModulosHelper::MENU_INFORMES)
            ->with('submenu', ModulosHelper::SUBMENU_INFORMES_MATRICULAS)
            ->with('organizaciones', $organizaciones)
            ->with('habilita', $habilita)
            ->with('leer', Session::get('INFORME_MATRICULAS_LEER'))
            ->with('editar', Session::get('INFORME_MATRICULAS_EDITAR'))
            ->with('imprimir', Session::get('INFORME_MATRICULAS_IMPRIMIR'))
            ->with('eliminar', Session::get('INFORME_MATRICULAS_ELIMINAR'));
    }

    public function postInformelistado()
    {
        $carrera_id = Input::get('carrera');
        $orgid = Input::get('cboOrganizacion');
        $ciclo_id = Input::get('cboCiclo');
        $organizaciones = Organizacion::lists('nombre', 'id');
        $habilita = false;

        if (!$ciclo_id == '') {
            if (!$carrera_id == '') {
                $inscripciones = Matricula::getDatosInscriptosMatriculas($carrera_id, $ciclo_id);//AlumnoCarrera::getDatosInscripcionesPorCarreraCiclo($carrera_id, $ciclo_id);

                foreach ($inscripciones as $inscripcion) {
                    $fechamostrar = FechaHelper::getFechaImpresion($inscripcion->fechavencimientomatricula);
                    $inscripcion->fechavencimientomatricula = $fechamostrar;

                    $pagos = DetalleMatriculaPago::whereRaw(
                        'inscripcion_id = ' . $inscripcion->inscripcion_id . ' and mescuota = 0')->get();

                    $inscripcion->pago = (count($pagos)) ? $pagos[0] : self::MATRICULA_IMPAGA;
                }

                $carreras = AlumnoCarrera::getCarrerasPorCiclo($ciclo_id);
                //$carreras = Carrera::where('organizacion_id', '=', $orgid)->get();
                $ciclos = CicloLectivo::where('organizacion_id', '=', $orgid)->get();
                $habilita = true;
            } else {
                $carrera_id = 0;
                array_unshift($organizaciones, 'Seleccionar');
                $ciclos = array();
                $carreras = array();
                $inscripciones = array();
            }
        } else {
            $carrera_id = 0;
            $ciclo_id = 0;
            array_unshift($organizaciones, 'Seleccionar');
            $ciclos = array();
            $carreras = array();
            $inscripciones = array();
        }

       /* highlight_string(var_export($inscripciones,true));
        exit();*/
        return View::make('informes/matriculas_pagos')
            ->with('organizaciones', $organizaciones)
            ->with('ciclo_id', $ciclo_id)
            ->with('ciclos', $ciclos)
            ->with('carrID', $carrera_id)
            ->with('carreras', $carreras)
            ->with('matricula', $inscripciones)
            ->with('OrgID', $orgid)
            ->with('habilita', $habilita)
            ->with('menu', ModulosHelper::MENU_INFORMES)
            ->with('submenu', ModulosHelper::SUBMENU_INFORMES_MATRICULAS)
            ->with('leer', Session::get('INFORME_MATRICULAS_LEER'))
            ->with('editar', Session::get('INFORME_MATRICULAS_EDITAR'))
            ->with('imprimir', Session::get('INFORME_MATRICULAS_IMPRIMIR'))
            ->with('eliminar', Session::get('INFORME_MATRICULAS_ELIMINAR'));
    }

    public function getInformepagosparcial()
    {
        $organizaciones = Organizacion::lists('nombre', 'id');

        array_unshift($organizaciones, 'Seleccionar');

        $filtroalumno = 0;
        $habilita = false;

        return View::make('informes/matriculas_pagoparcial')
            ->with('menu', ModulosHelper::MENU_INFORMES)
            ->with('submenu', ModulosHelper::SUBMENU_INFORMES_MATRICULAS)
            ->with('organizaciones', $organizaciones)
            ->with('filtroalumno', $filtroalumno)
            ->with('habilita', $habilita)
            ->with('leer', Session::get('INFORME_MATRICULAS_LEER'))
            ->with('editar', Session::get('INFORME_MATRICULAS_EDITAR'))
            ->with('imprimir', Session::get('INFORME_MATRICULAS_IMPRIMIR'))
            ->with('eliminar', Session::get('INFORME_MATRICULAS_ELIMINAR'));
    }

    /*public function postInformepagosporcarrera()
    {
        $carrera_id = Input::get('carrera');

        $inscripciones = AlumnoCarrera::getDatosInscripcionesPorCarrera($carrera_id);

        foreach ($inscripciones as $inscripcion) {
            $pagos = DetalleMatriculaPago::whereRaw(
                'inscripcion_id = ' . $inscripcion->id . ' and mescuota = 0')->get();

            $inscripcion->pago = (count($pagos)) ? $pagos[0] : self::MATRICULA_IMPAGA;
        }

        return Response::json($inscripciones);
    }*/

    public function postInformepagospordni()
    {
        $dni = Input::get('filtro');
        $ciclo = Input::get('ciclo');
        //$dni = 'B25566223';

        $result = array();

        $persona = Persona::with('alumno')
            ->where('nrodocumento', '=', $dni)
            ->orderBy('apellido')
            ->get();

        if (count($persona) == 0)
            return Response::json($persona);

        $inscripciones = AlumnoCarrera::where(
            'alumno_id', '=', $persona[0]->alumno->id)->get();

        $persona[0]->inscripciones = $inscripciones;

        foreach ($inscripciones as $inscripcion) {
            $matricula = Matricula::whereRaw(
                'carrera_id = ' . $inscripcion->carrera_id .
                ' and ciclolectivo_id = ' . $ciclo)//$inscripcion->ciclolectivo_id)
            ->get();

            $carrera = Carrera::find($inscripcion->carrera_id);
            //$ciclo_lectivo = CicloLectivo::find($ciclo);//$inscripcion->ciclolectivo_id);

            $pagos = array();

            if (count($matricula) > 0) {
                $pagos = DetalleMatriculaPago::whereRaw(
                    'inscripcion_id = ' . $inscripcion->id . ' and mescuota = 0')->get();
            }

            $inscripcion->matricula = $matricula[0];
            $inscripcion->pago = (count($pagos)) ? $pagos[0] : self::MATRICULA_IMPAGA;
            $inscripcion->carrera = $carrera;
            //$inscripcion->ciclo = $ciclo_lectivo->descripcion;
        }

        return Response::json($persona);
    }

    public function postInformepagosporapellido()
    {
        $apellido = Input::get('filtro');
        //$apellido = 'a';

        $result = array();

        $personas = Alumno::getPorApellido($apellido);

        if (count($personas) == 0)
            return Response::json($personas);

        foreach ($personas as $persona) {
            $inscripciones = AlumnoCarrera::where(
                'alumno_id', '=', $persona->alumno_id)->get();

            $persona->inscripciones = $inscripciones;

            foreach ($inscripciones as $inscripcion) {
                $matricula = Matricula::whereRaw(
                    'carrera_id = ' . $inscripcion->carrera_id .
                    ' and ciclolectivo_id = ' . $inscripcion->ciclolectivo_id)
                ->get();

                $carrera = Carrera::find($inscripcion->carrera_id);
                $ciclo_lectivo = CicloLectivo::find($inscripcion->ciclolectivo_id);

                $pagos = array();

                if (count($matricula) > 0) {
                    $pagos = DetalleMatriculaPago::whereRaw(
                        'inscripcion_id = ' . $inscripcion->id . ' and mescuota = 0')->get();
                    $inscripcion->matricula = $matricula[0];

                    if (count($pagos)) {
                         $inscripcion->pago = $pagos[0];
                         $inscripcion->ha_pagado = 1;
                    } else {
                        $inscripcion->pago = $pagos;
                        $inscripcion->ha_pagado = self::MATRICULA_IMPAGA;
                    }
                } else {
                    $inscripcion->matricula = self::NO_EXISTE_MATRICULA;
                }
               
                $inscripcion->carrera = $carrera;
                $inscripcion->ciclo = $ciclo_lectivo->descripcion;
            }
        }

        return Response::json($personas);
    }

    public function getPdfpagosporcarrera()
    {
        $carrera_id = Input::get('carrera');
        $ciclo_id = Input::get('ciclo');

        $inscripciones = Matricula::getDatosInscriptosMatriculas($carrera_id, $ciclo_id);//AlumnoCarrera::getDatosInscripcionesPorCarreraCiclo($carrera_id, $ciclo_id);
        $carrera = Carrera::find($carrera_id);
        $ciclo_lectivo = CicloLectivo::find($ciclo_id);

        foreach ($inscripciones as $inscripcion) {
            $pagos = DetalleMatriculaPago::whereRaw(
                'inscripcion_id = ' . $inscripcion->inscripcion_id . ' and mescuota = 0')->get();

            if (count($pagos)) {
                 $inscripcion->pago = $pagos[0];
                 $inscripcion->ha_pagado = 1;
            } else {
                $inscripcion->pago = $pagos;
                $inscripcion->ha_pagado = self::MATRICULA_IMPAGA;
            }
        }

        $pdf = PDF::loadView(
            'informes.pdf.pagosporcarrera',
            [
              'inscripciones' => $inscripciones,
              'carrera' => $carrera,
              'ciclo_lectivo' => $ciclo_lectivo
            ]
        );
        return $pdf->setOrientation('landscape')->stream();
    }

    public function getPdfpagosporfiltro()
    {
        $filtro = Input::get('filtro');
        $valor = Input::get('valor');

        if ($filtro == 1) {
            // DNI
            $personas = Alumno::getAlumnoPorDni($valor);
        } elseif ($filtro == 2) {
            // APELLIDO
            $personas = Alumno::getPorApellido($valor);
        }

        if (count($personas) == 0)
            return Response::json($personas);

        foreach ($personas as $persona) {
            $inscripciones = AlumnoCarrera::where(
                'alumno_id', '=', $persona->alumno_id)->get();

            $persona->inscripciones = $inscripciones;

            foreach ($inscripciones as $inscripcion) {
                $matricula = Matricula::whereRaw(
                    'carrera_id = ' . $inscripcion->carrera_id .
                    ' and ciclolectivo_id = ' . $inscripcion->ciclolectivo_id)
                ->get();

                $carrera = Carrera::find($inscripcion->carrera_id);
                $inscripcion->carrera = $carrera;
                $ciclo_lectivo = CicloLectivo::find($inscripcion->ciclolectivo_id);
                $inscripcion->ciclo = $ciclo_lectivo->descripcion;

                if (count($matricula) > 0) {
                    $pagos = DetalleMatriculaPago::whereRaw(
                        'inscripcion_id = ' . $inscripcion->id . ' and mescuota = 0')->get();
                    $inscripcion->matricula = $matricula[0];
                    $inscripcion->tiene_matricula = 1;

                    if (count($pagos)) {
                         $inscripcion->pago = $pagos[0];
                         $inscripcion->ha_pagado = 1;
                    } else {
                        $inscripcion->pago = $pagos;
                        $inscripcion->ha_pagado = self::MATRICULA_IMPAGA;
                    }
                } else {
                    $inscripcion->tiene_matricula = self::NO_EXISTE_MATRICULA;
                }

            }
        }

        $pdf = PDF::loadView(
            'informes.pdf.pagosporfiltro',
            ['personas' => $personas]
        );
        return $pdf->setOrientation('landscape')->stream();
    }

    public function getInformeauditoriamatricula()/*PDF*/
    {
        $matriculasall = DetalleMatriculaPago::all();

        $i = 0;
        foreach ($matriculasall as $matricula) {
            $persona = $matricula->alumno->persona;
            $alumnocarrera = AlumnoCarrera::whereRaw('alumno_id = '. $matricula->alumno->id)->get();

            foreach ($alumnocarrera as $alumnocarr) {
                $carreras = Carrera::whereRaw('id = ' . $alumnocarr->carrera_id)->get();
                
                foreach ($carreras as $carrera) {
                    $abreviatura = $carrera->Abreviatura;
                }
            }
            
            $apeynom = $persona->apellido . ', ' . $persona->nombre;
            $dni = $persona->nrodocumento;

            $fecha_alta = FechaHelper::getFechaImpresion($matricula->fecha_alta);
            $fecha_modi = FechaHelper::getFechaImpresion($matricula->fecha_modi);

            $matriculas[$i] = ['apeynom'=>$apeynom, 'dni'=>$dni, 'mescuota'=>$matricula->mescuota, 'abreviatura'=>$abreviatura,
                            'usuario_alta'=>$matricula->usuario_alta, 'fecha_alta'=>$fecha_alta, 
                            'usuario_modi'=>$matricula->usuario_modi, 'fecha_modi'=>$fecha_modi];
            $i++;
        }

        $pdf = PDF::loadView('informes.pdf.matriculaauditoria', ['matriculas'=>$matriculas]);
        return $pdf->setOrientation('landscape')->stream();

    }  

    /**
     * Setea los valores a validar y las reglas a usar
     */
    private function _setAttributesValidation()
    {
        $this->_data = array('carrera' => Input::get('cboCarrera'));
        $this->_rules = array('carrera' => 'required');
        $this->_messages = array('required' => 'Campo Obligatorio',);
    }

    public function _existeMatriculaParaLaCarrera($organizacion, $carrera)
    {
        $ciclo_lectivo_activo = CicloLectivo::getCicloActivo($organizacion);
        $ciclo_id = $ciclo_lectivo_activo[0]->id;

        $existe_matricula = Matricula::verificaExisteMatricula($ciclo_id, $carrera);

        return $existe_matricula;
    }

    private function _crearMatricula($organizacion, $carrera)
    {
        $fecha_vencimiento_matricula = FechaHelper::getFechaParaGuardar(
            Input::get('txtmatriculafechavencimiento')
        );

        $ciclo_lectivo_id = Input::get('txt_ciclo_lectivo_id');
        $mes_pago_cuota_inicio = Input::get('cboMesPagoCuotaInicio');
        $mes_pago_cuota_fin = Input::get('cboMesPagoCuotaFin');

        if ($mes_pago_cuota_inicio == 0) $mes_pago_cuota_inicio = 1;

        $cuota_aplica = (Input::get('check_cuota_importe') == 'on') ? 1 : 0;

        if ($cuota_aplica) {
            $cantidad_cuotas = $this->_calcular_cantidad_cuotas(
                $ciclo_lectivo_id, $mes_pago_cuota_inicio
            );
        } else {
            $cantidad_cuotas = 0;
        }

        $matricula = new Matricula;
          $matricula->organizacion_id = $organizacion;
          $matricula->carrera_id      = $carrera;
          $matricula->cicloLectivo_id = $ciclo_lectivo_id;
          $matricula->matriculaaplica = (Input::get('check_matricula_importe') == 'on') ? 1 : 0;
          $matricula->cuotaaplica     = $cuota_aplica;
          $matricula->matriculaimporte = Input::get('txtmatriculaimporte');
          $matricula->fechavencimientomatricula = $fecha_vencimiento_matricula;
          $matricula->mespagocuotainicio = $mes_pago_cuota_inicio;
          $matricula->mespagocuotafin = $mes_pago_cuota_fin;
          $matricula->cuotaimporte = Input::get('txtcuotaimporte');
          $matricula->cuotaperiodopagohasta = Input::get('cuota_periodo_pago_hasta');
          $matricula->cuotasporperiodo = $cantidad_cuotas;
          $matricula->usuario_alta     = Auth::user()->usuario;
          $matricula->fecha_alta       = date('Y-m-d');
        $matricula->save();

        Session::flash('message', 'MATRICULA CREADA CON ÉXITO!');
    }

    private function _calcular_cantidad_cuotas($ciclo_id, $mes_pago_cuota_inicio)
    {
        $ciclo = CicloLectivo::find($ciclo_id);

        $fecha_fin_ciclo = FechaHelper::getFechaImpresion($ciclo->fechafin);
        $fecha_inicio_ciclo = FechaHelper::getFechaImpresion($ciclo->fechainicio);

        list($dia_inicio, $mes_inicio, $anio_inicio) = explode('/', $fecha_inicio_ciclo);
        list($dia_fin, $mes_fin, $anio_fin) = explode('/', $fecha_fin_ciclo);

        if ($anio_inicio == $anio_fin) {
            $cantidad_cuotas = $mes_fin - $mes_pago_cuota_inicio + 1;
        } else {
            $cantidad_cuotas = (12 - $mes_pago_cuota_inicio) + $mes_fin;
        }

        return ($cantidad_cuotas);
    }

    private function _modificarMatricula($id)
    {
        $fecha_vencimiento_matricula = FechaHelper::getFechaParaGuardar(
            Input::get('txtmatriculafechavencimiento')
        );

        $matricula = Matricula::find($id);
        $mes_pago_cuota_inicio = Input::get('cboMesPagoCuotaInicio');
        $mes_pago_cuota_fin = Input::get('cboMesPagoCuotaFin');

        if ($mes_pago_cuota_inicio == 0) $mes_pago_cuota_inicio = 1;

        $cuota_aplica = (Input::get('check_cuota_importe') == 'on') ? 1 : 0;

        if ($cuota_aplica) {
            $cantidad_cuotas = $this->_calcular_cantidad_cuotas(
                $matricula->ciclolectivo_id, $mes_pago_cuota_inicio
            );
        } else {
            $cantidad_cuotas = 0;
        }

          $matricula->matriculaaplica           = (Input::get('check_matricula_importe') == 'on') ? 1 : 0;
          $matricula->cuotaaplica               = $cuota_aplica;
          $matricula->matriculaimporte          = Input::get('txtmatriculaimporte');
          $matricula->fechavencimientomatricula = $fecha_vencimiento_matricula;
          $matricula->mespagocuotainicio        = $mes_pago_cuota_inicio;
          $matricula->mespagocuotafin           = $mes_pago_cuota_fin;
          $matricula->cuotaimporte              = Input::get('txtcuotaimporte');
          $matricula->cuotaperiodopagohasta     = Input::get('cuota_periodo_pago_hasta');
          $matricula->cuotasporperiodo          = $cantidad_cuotas;
          $matricula->usuario_modi              = Auth::user()->usuario;
          $matricula->fecha_modi                = date('Y-m-d');
        $matricula->save();

        Session::flash('message', 'LA MATRICULA HA SIDO MODIFICADA CON ÉXITO!');
    }

    public function getImprimirrecibo()/*PDF*/
    {
        $inscripcion_id = Input::get('inscripcion_id');
        $mes = Input::get('mes');
        $matricula_id = Input::get('matricula_id');
        $matriculas = array();

        $pagos = DetalleMatriculaPago::getDatosPagoRealizado($inscripcion_id, $mes, $matricula_id);

        
        foreach ($pagos as $value) {
            $matricula = Matricula::whereRaw('id =' . $value->matricula_id)->first();
            
            $ciclo = CicloLectivo::whereRaw('id='. $matricula->ciclolectivo_id)->first()->descripcion;
            
            $carrera = $matricula->carrera->carrera;

            $matriculaimporte = $matricula->matriculaimporte;

            $apeynomb = Alumno::find($value->alumno_id);

            $apeynom = $apeynomb->persona->apellido . ', ' . $apeynomb->persona->nombre;

            $dni = $apeynomb->persona->nrodocumento;

            $matriculas[] = ['id' => $value->pago_id, 'carrera' => $carrera, 'apeynom' => $apeynom, 'ciclo' => $ciclo, 'dni' => $dni, 'matriculaimporte' => $matriculaimporte, 'importe' => $value->importe, 'importeparcial' => $value->importeparcial, 'saldo' => $value->saldo, 'efectivo' => $value->efectivo, 'credito' => $value->tarjetacredito, 'debito' => $value->tarjetadebito, 'bancaria' => $value->cuentabancaria, 'descuento' => $value->porcentajedescuento, 'recargo' => $value->porcentajerecargo, 'totalparcial' => $value->totalparcial];
        }

        $pdf = PDF::loadView('informes.pdf.matricularecibo', ['matriculas'=>$matriculas]);
        return $pdf->setOrientation('landscape')->stream();
    }  

    public function getImprimir()/*PDF*/
    {
        $organizacion_id = Input::get('organizacion_id');
        $ciclo_id = Input::get('ciclo_id');
        $carrera_id = Input::get('carrera_id');

        $ciclos = CicloLectivo::where('organizacion_id', '=', $organizacion_id)->get();

        $carreras = AlumnoCarrera::getCarrerasPorCiclo($ciclo_id);

        $matriculas = Matricula::getDatosInscriptosMatriculas($carrera_id, $ciclo_id);

        foreach ($matriculas as $value) {
            $ciclomatricula = CicloLectivo::whereRaw('id = ' . $value->ciclolectivo_id)->first()->descripcion;
            $cicloinscripcion = CicloLectivo::whereRaw('id = ' . $value->ciclo_inscripcion)->first()->descripcion;
            $carrera = Carrera::whereRaw('id = ' . $carrera_id)->first()->carrera;

            if ($cicloinscripcion == $ciclomatricula || $ciclomatricula > $cicloinscripcion) {
                $matricula[] = ['nombre' => $value->nombre, 'apellido' => $value->apellido, 'nrodocumento' => $value->nrodocumento, 'inscripcion_id' => $value->inscripcion_id, 'carrera_id' => $value->carrera_id, 'ciclolectivo_id' => $value->ciclolectivo_id, 'matriculaimporte' => $value->matriculaimporte, 'matricula_id' => $value->matricula_id, 'ciclo_descripcion' => $value->ciclo_descripcion, 'fechavencimientomatricula' => $value->fechavencimientomatricula, 'matriculaaplica' => $value->matriculaaplica, 'cuotaaplica' => $value->cuotaaplica, 'mespagocuotainicio' => $value->mespagocuotainicio, 'mespagocuotafin' => $value->mespagocuotafin, 'ciclo' => $value->ciclo_inscripcion, 'carrera' => $carrera];
            }
        }

        for ($i=0; $i < count($matricula); $i++) { 
            $detalle_pagos = DetalleMatriculaPago::getDatosPagos($matricula[$i]['inscripcion_id'], $matricula[$i]['matricula_id']);
            $matricula[$i]['detalle_cuotas'] = $detalle_pagos;

            $beca = Beca::whereRaw('inscripcion_id =' . $matricula[$i]['inscripcion_id'] . ' AND ciclolectivo_id =' . $matricula[$i]['ciclolectivo_id'] . ' and becado=1')->get();
            $matricula[$i]['beca'] = (count($beca)) ? $beca[0] : self::NO_TIENE_BECA;
        }
        /*$organizacion_id = Input::get('organizacion_id');
        $ciclo_id = Input::get('ciclo_id');
        $carrera_id = Input::get('carrera_id');

        $inscripciones = Matricula::getDatosInscriptosMatriculas($carrera_id, $ciclo_id);

        $ya_pago_matricula = false;
        $tiene_beca = false;
        $beca_mes_inicio = 0;
        $beca_mes_fin = 0;
        $importe = 0;
        
        foreach ($inscripciones as $value) {
            if ($value->fechavencimientomatricula) $fechavencimientomatricula = FechaHelper::getFechaImpresion($value->fechavencimientomatricula);

            if ($value->matriculaaplica == 1) {
                $pagos = DetalleMatriculaPago::whereRaw('matricula_id ='. $value->matricula_id.' AND inscripcion_id = '. $value->inscripcion_id . ' AND mescuota = 0 AND estado = 1')->first();
                    
                if (isset($pagos)) {
                    $ya_pago_matricula = true;
                    if ($pagos->fechapago) $fechapago = FechaHelper::getFechaImpresion($pagos->fechapago);
                    $importe = $pagos->importe;
                } else {
                    $ya_pago_matricula = false;
                    $fechapago = '';
                }

                $beca = Beca::whereRaw('inscripcion_id =' . $value->inscripcion_id . ' AND ciclolectivo_id =' . $value->ciclolectivo_id . ' and becado=1')->first();
                //$value->beca = (count($beca)) ? $beca[0] : self::NO_TIENE_BECA;

                if (isset($beca)) {
                    $tiene_beca = true;
                } else {
                    $tiene_beca = false;
                }
            }

            $carrera = Carrera::whereRaw('id ='. $value->carrera_id)->first();
            $ciclo = $value->ciclo_descripcion;

            $matriculas[] = ['apellido' => $value->apellido, 'nombre' => $value->nombre, 'nrodocumento' => $value->nrodocumento, 'carrera' => $carrera->carrera, 'ciclo' => $ciclo, 'fechavencimientomatricula' => $fechavencimientomatricula, 'fechapago' => $fechapago, 'importe' => $importe, 'tiene_beca' => $tiene_beca, 'matriculaaplica' => $ya_pago_matricula];
        }*/

        /*highlight_string(var_export($matriculas,true));
        exit;*/

        $pdf = PDF::loadView('informes.pdf.pagosmatriculas', ['matriculas'=>$matricula]);
        return $pdf->setOrientation('landscape')->stream();
    }  

    public function postObtenermovimientos() 
    {
        $orgid = Input::get('cboOrganizacion');
        $fechadesdes = Input::get('fechadesde');
        $fechahastas = Input::get('fechahasta');
        $filtroalumno = Input::get('cboFiltros');
        $txtdni = Input::get('txtFiltro');
        $cbocarrera = Input::get('cboCarreras');
        $todomovimiento = array();
        $fecha_inicio = strtotime($fechadesdes);
        $fecha_fin    = strtotime($fechahastas);
        $carreras = array();
        $habilita = false;

        if (!$orgid == '') {
            $carreras = Carrera::whereRaw('organizacion_id=' . $orgid . ' and activa=1')->get();

            $cantidad_carreras = count($carreras);
            
            if ($cantidad_carreras == 0)
                return self::NO_TIENE_CARRERAS;

            for ($i = 0; $i < $cantidad_carreras; $i++) {
                $matricula = Matricula::where(
                    'carrera_id', '=', $carreras[$i]->id)->get();

                if (count($matricula) == 0)
                    unset($carreras[$i]);
            }
        }

        if ($cbocarrera == '') {
            $carrera = '';
        } else {
            $carrera = Carrera::find($cbocarrera);
        }

        if ($fechadesdes == '') $fechadesdes = date("Y-m-d");

        if ($fechahastas == '') $fechahastas = date("Y-m-d");

        if ($carrera) {
            if ($filtroalumno == 0) {
                $matriculas = Matricula::whereRaw('carrera_id= '. $cbocarrera)->get();

                foreach ($matriculas as $matricula) {
                    $detalle_pagos = DetalleMatriculaPago::whereRaw('matricula_id= '. $matricula->id .' AND totalparcial=1')->get();

                    foreach ($detalle_pagos as $value) {
                        $fechatransaccion = FechaHelper::getFechaImpresion($value->fechapago);
                        $porcions = explode("/", $fechatransaccion);
                        $fechatransaccions = $porcions[2].'-'.$porcions[1].'-'.$porcions[0];
                        $fecha_trans = strtotime($fechatransaccions);

                        if (!$value->alumno_id == NULL) {
                            $per_alum = Alumno::whereRaw('id ='. $value->alumno_id)->first();
                            $apellido = $per_alum->persona->apellido;
                            $nombre = $per_alum->persona->nombre;
                            $apeynom = $apellido .', '. $nombre;
                            $dni = $per_alum->persona->nrodocumento;
                        } else {
                            $apeynom = '-';
                            $dni = '-';
                        }

                        if ($fecha_trans >= $fecha_inicio && $fecha_trans <= $fecha_fin) {
                            $todomovimiento[] = ['id' => $value->id, 'apeynom' => $apeynom, 'dni' => $dni, 'fechapago' => $fechatransaccion, 'importe' => $value->importe, 'importeparcial' => $value->importeparcial, 'saldo' => $value->saldo];
                        }
                    }
                }
            }

            if (!$txtdni == '') {
                if ($filtroalumno == 1) {
                    $persona = Alumno::getAlumnoPorDni($txtdni);
                    /*$persona = Persona::with('alumno')
                        ->where('nrodocumento', '=', $txtdni)
                        ->orderBy('apellido')
                        ->get();*/

                    if (count($persona) > 0) {
                        $matriculas = Matricula::whereRaw('carrera_id= '. $cbocarrera)->get();

                        foreach ($matriculas as $matricula) {
                            $detalle_pagos = DetalleMatriculaPago::whereRaw('matricula_id= '. $matricula->id .' AND alumno_id= '. $persona[0]->alumno_id .' AND totalparcial=1')->get();

                            foreach ($detalle_pagos as $value) {
                                $fechatransaccion = FechaHelper::getFechaImpresion($value->fechapago);
                                $porcions = explode("/", $fechatransaccion);
                                $fechatransaccions = $porcions[2].'-'.$porcions[1].'-'.$porcions[0];
                                $fecha_trans = strtotime($fechatransaccions);

                                if (!$value->alumno_id == NULL) {
                                    $per_alum = Alumno::whereRaw('id ='. $value->alumno_id)->first();
                                    $apellido = $per_alum->persona->apellido;
                                    $nombre = $per_alum->persona->nombre;
                                    $apeynom = $apellido .', '. $nombre;
                                    $dni = $per_alum->persona->nrodocumento;
                                } else {
                                    $apeynom = '-';
                                    $dni = '-';
                                }

                                if ($fecha_trans >= $fecha_inicio && $fecha_trans <= $fecha_fin) {
                                    $todomovimiento[] = ['id' => $value->id, 'apeynom' => $apeynom, 'dni' => $dni, 'fechapago' => $fechatransaccion, 'importe' => $value->importe, 'importeparcial' => $value->importeparcial, 'saldo' => $value->saldo];
                                }
                            }
                        }
                    }
                }

                if ($filtroalumno == 2) {
                    $porcions = explode(", ", $txtdni);
                    $apellido = $porcions[0];
                    $nombre = $porcions[1];

                    $persona = Alumno::getPorApellidoNombre($apellido, $nombre);//Persona::with('alumno')
                        //->whereRaw('apellido= '.$apellido.' AND nombre= '.$nombre)
                        //->get();

                    if (count($persona) > 0) {
                        $matriculas = Matricula::whereRaw('carrera_id= '. $cbocarrera)->get();

                        foreach ($matriculas as $matricula) {
                            $detalle_pagos = DetalleMatriculaPago::whereRaw('matricula_id= '. $matricula->id .' AND alumno_id= '. $persona[0]->alumno_id .' AND totalparcial=1')->get();

                            foreach ($detalle_pagos as $value) {
                                $fechatransaccion = FechaHelper::getFechaImpresion($value->fechapago);
                                $porcions = explode("/", $fechatransaccion);
                                $fechatransaccions = $porcions[2].'-'.$porcions[1].'-'.$porcions[0];
                                $fecha_trans = strtotime($fechatransaccions);

                                if (!$value->alumno_id == NULL) {
                                    $per_alum = Alumno::whereRaw('id ='. $value->alumno_id)->first();
                                    $apellido = $per_alum->persona->apellido;
                                    $nombre = $per_alum->persona->nombre;
                                    $apeynom = $apellido .', '. $nombre;
                                    $dni = $per_alum->persona->nrodocumento;
                                } else {
                                    $apeynom = '-';
                                    $dni = '-';
                                }

                                if ($fecha_trans >= $fecha_inicio && $fecha_trans <= $fecha_fin) {
                                    $todomovimiento[] = ['id' => $value->id, 'apeynom' => $apeynom, 'dni' => $dni, 'fechapago' => $fechatransaccion, 'importe' => $value->importe, 'importeparcial' => $value->importeparcial, 'saldo' => $value->saldo];
                                }
                            }
                        }
                    }
                }
            }
        }

        /*highlight_string(var_export($todomovimiento,true));
        exit;*/
        if (!$cbocarrera == '') {
            $organizaciones = Organizacion::lists('nombre', 'id');
        } else {
            $organizaciones = Organizacion::lists('nombre', 'id');
            array_unshift($organizaciones, 'Seleccionar');
        }

        if (isset($todomovimiento)) {
            if (count($todomovimiento) > 0) {
                $habilita = true;
            }
        }


        return View::make('informes/matriculas_pagoparcial')
            ->with('menu', ModulosHelper::MENU_INFORMES)
            ->with('submenu', ModulosHelper::SUBMENU_INFORMES_MATRICULAS)
            ->with('organizaciones', $organizaciones)
            ->with('todomovimiento', $todomovimiento)
            ->with('OrgID', $orgid)
            ->with('filtroalumno', $filtroalumno)
            ->with('txtdni', $txtdni)
            ->with('fechadesdes', $fechadesdes)
            ->with('fechahastas', $fechahastas)
            ->with('carrera', $carrera)
            ->with('carreras', $carreras)
            ->with('habilita', $habilita)
            ->with('leer', Session::get('INFORME_MATRICULAS_LEER'))
            ->with('editar', Session::get('INFORME_MATRICULAS_EDITAR'))
            ->with('imprimir', Session::get('INFORME_MATRICULAS_IMPRIMIR'))
            ->with('eliminar', Session::get('INFORME_MATRICULAS_ELIMINAR'));
    }

    public function getImprimirinforme() 
    {
        //$orgid = Input::get('cboOrganizacion');
        $fechadesdes = Input::get('fechadesde');
        $fechahastas = Input::get('fechahasta');
        $filtroalumno = Input::get('filtro');
        $txtdni = Input::get('dni');
        $cbocarrera = Input::get('carrera');
        $todomovimiento = array();
        $fecha_inicio = strtotime($fechadesdes);
        $fecha_fin    = strtotime($fechahastas);
        $carreras = array();

        //if (!$orgid == '') {
            $carreras = Carrera::whereRaw('organizacion_id=1 and activa=1')->get();

            $cantidad_carreras = count($carreras);
            
            if ($cantidad_carreras == 0)
                return self::NO_TIENE_CARRERAS;

            for ($i = 0; $i < $cantidad_carreras; $i++) {
                $matricula = Matricula::where(
                    'carrera_id', '=', $carreras[$i]->id)->get();

                if (count($matricula) == 0)
                    unset($carreras[$i]);
            }
        //}

        if ($cbocarrera == '') {
            $carrera = '';
        } else {
            $carrera = Carrera::find($cbocarrera);
        }

        if ($fechadesdes == '') $fechadesdes = date("Y-m-d");

        if ($fechahastas == '') $fechahastas = date("Y-m-d");

        if ($carrera) {
            if ($filtroalumno == 0) {
                $matriculas = Matricula::whereRaw('carrera_id= '. $cbocarrera)->get();

                foreach ($matriculas as $matricula) {
                    $detalle_pagos = DetalleMatriculaPago::whereRaw('matricula_id= '. $matricula->id .' AND totalparcial=1')->get();

                    foreach ($detalle_pagos as $value) {
                        $fechatransaccion = FechaHelper::getFechaImpresion($value->fechapago);
                        $porcions = explode("/", $fechatransaccion);
                        $fechatransaccions = $porcions[2].'-'.$porcions[1].'-'.$porcions[0];
                        $fecha_trans = strtotime($fechatransaccions);

                        if (!$value->alumno_id == NULL) {
                            $per_alum = Alumno::whereRaw('id ='. $value->alumno_id)->first();
                            $apellido = $per_alum->persona->apellido;
                            $nombre = $per_alum->persona->nombre;
                            $apeynom = $apellido .', '. $nombre;
                            $dni = $per_alum->persona->nrodocumento;
                        } else {
                            $apeynom = '-';
                            $dni = '-';
                        }

                        if ($fecha_trans >= $fecha_inicio && $fecha_trans <= $fecha_fin) {
                            $todomovimiento[] = ['id' => $value->id, 'apeynom' => $apeynom, 'dni' => $dni, 'fechapago' => $fechatransaccion, 'importe' => $value->importe, 'importeparcial' => $value->importeparcial, 'saldo' => $value->saldo];
                        }
                    }
                }
            }

            if (!$txtdni == '') {
                if ($filtroalumno == 1) {
                    $persona = Alumno::getAlumnoPorDni($txtdni);
                    /*$persona = Persona::with('alumno')
                        ->where('nrodocumento', '=', $txtdni)
                        ->orderBy('apellido')
                        ->get();*/

                    if (count($persona) > 0) {
                        $detalle_pagos = DetalleMatriculaPago::whereRaw('alumno_id= '. $persona[0]->alumno_id .' AND totalparcial=1')->get();

                        foreach ($detalle_pagos as $value) {
                            $fechatransaccion = FechaHelper::getFechaImpresion($value->fechapago);
                            $porcions = explode("/", $fechatransaccion);
                            $fechatransaccions = $porcions[2].'-'.$porcions[1].'-'.$porcions[0];
                            $fecha_trans = strtotime($fechatransaccions);

                            if (!$value->alumno_id == NULL) {
                                $per_alum = Alumno::whereRaw('id ='. $value->alumno_id)->first();
                                $apellido = $per_alum->persona->apellido;
                                $nombre = $per_alum->persona->nombre;
                                $apeynom = $apellido .', '. $nombre;
                                $dni = $per_alum->persona->nrodocumento;
                            } else {
                                $apeynom = '-';
                                $dni = '-';
                            }

                            if ($fecha_trans >= $fecha_inicio && $fecha_trans <= $fecha_fin) {
                                $todomovimiento[] = ['id' => $value->id, 'apeynom' => $apeynom, 'dni' => $dni, 'fechapago' => $fechatransaccion, 'importe' => $value->importe, 'importeparcial' => $value->importeparcial, 'saldo' => $value->saldo];
                            }
                        }
                    }
                }

                if ($filtroalumno == 2) {
                    $porcions = explode(", ", $txtdni);
                    $apellido = $porcions[0];
                    $nombre = $porcions[1];

                    $persona = Alumno::getPorApellidoNombre($apellido, $nombre);
                    /*$persona = Persona::with('alumno')
                        ->where('nrodocumento', '=', $txtdni)
                        ->orderBy('apellido')
                        ->get();*/

                    if (count($persona) > 0) {
                        $detalle_pagos = DetalleMatriculaPago::whereRaw('alumno_id= '. $persona[0]->alumno_id .' AND totalparcial=1')->get();

                        foreach ($detalle_pagos as $value) {
                            $fechatransaccion = FechaHelper::getFechaImpresion($value->fechapago);
                            $porcions = explode("/", $fechatransaccion);
                            $fechatransaccions = $porcions[2].'-'.$porcions[1].'-'.$porcions[0];
                            $fecha_trans = strtotime($fechatransaccions);

                            if (!$value->alumno_id == NULL) {
                                $per_alum = Alumno::whereRaw('id ='. $value->alumno_id)->first();
                                $apellido = $per_alum->persona->apellido;
                                $nombre = $per_alum->persona->nombre;
                                $apeynom = $apellido .', '. $nombre;
                                $dni = $per_alum->persona->nrodocumento;
                            } else {
                                $apeynom = '-';
                                $dni = '-';
                            }

                            if ($fecha_trans >= $fecha_inicio && $fecha_trans <= $fecha_fin) {
                                $todomovimiento[] = ['id' => $value->id, 'apeynom' => $apeynom, 'dni' => $dni, 'fechapago' => $fechatransaccion, 'importe' => $value->importe, 'importeparcial' => $value->importeparcial, 'saldo' => $value->saldo];
                            }
                        }
                    }
                }
            }
        }

        /*highlight_string(var_export($todomovimiento,true));
        exit;*/
        /*if (!$cbocarrera == '') {
            $organizaciones = Organizacion::lists('nombre', 'id');
        } else {
            $organizaciones = Organizacion::lists('nombre', 'id');
            array_unshift($organizaciones, 'Seleccionar');
        }*/
        $fechadesdes = FechaHelper::getFechaImpresion($fechadesdes);
        $fechahastas = FechaHelper::getFechaImpresion($fechahastas);
        $fechahoy = FechaHelper::getFechaImpresion(date("Y-m-d"));

        $pdf = PDF::loadView('informes.pdf.pagosparcialmatriculas', [
            'todomovimiento' => $todomovimiento,
            'filtroalumno' => $filtroalumno,
            'txtdni' => $txtdni,
            'fechahoy' => $fechahoy,
            'fechadesdes' => $fechadesdes,
            'fechahastas' => $fechahastas,
            'carrera' => $carrera,
            'carreras' => $carreras
            ]);
        return $pdf->setOrientation('landscape')->stream();
    }

    public function getImprimirreciboadeuda()/*PDF*/
    {
        $carrera_id = Input::get('carrera');
        $ciclo_id = Input::get('ciclo');
        $alumno_id = Input::get('alumno');
        $mes = 0;
        $matricula_id = Input::get('matricula');
        $matriculas = array();

        $inscripcion_id = AlumnoCarrera::whereRaw('alumno_id= '.$alumno_id.' AND carrera_id= '.$carrera_id)->first();

        $pagos = DetalleMatriculaPago::getDatosPagoRealizado($inscripcion_id->id, $mes, $matricula_id);
        
        foreach ($pagos as $value) {
            $matricula = Matricula::whereRaw('id =' . $value->matricula_id)->first();
            
            $ciclo = CicloLectivo::whereRaw('id='. $matricula->ciclolectivo_id)->first()->descripcion;
            
            $carrera = $matricula->carrera->carrera;

            $matriculaimporte = $matricula->matriculaimporte;

            $apeynomb = Alumno::find($value->alumno_id);

            $apeynom = $apeynomb->persona->apellido . ', ' . $apeynomb->persona->nombre;

            $dni = $apeynomb->persona->nrodocumento;

            $matriculas[] = ['id' => $value->pago_id, 'carrera' => $carrera, 'apeynom' => $apeynom, 'ciclo' => $ciclo, 'dni' => $dni, 'matriculaimporte' => $matriculaimporte, 'importe' => $value->importe, 'importeparcial' => $value->importeparcial, 'saldo' => $value->saldo, 'efectivo' => $value->efectivo, 'credito' => $value->tarjetacredito, 'debito' => $value->tarjetadebito, 'bancaria' => $value->cuentabancaria, 'descuento' => $value->porcentajedescuento, 'recargo' => $value->porcentajerecargo, 'totalparcial' => $value->totalparcial];
        }

        $pdf = PDF::loadView('informes.pdf.matricularecibo', ['matriculas'=>$matriculas]);
        return $pdf->setOrientation('landscape')->stream();
    }  

    /**
     * Validacion para el borrado de la MATRICULA
     *
     * @param  Matricula  $matricula
     * @return Boolean
     */
    private function _noSePuedeBorrar(Matricula $matricula)
    {
        return FALSE;
    }
      

}

//PARA MANEJAR LOS ERRORES DE findOrFail
App::error(function(ModelNotFoundException $e)
{
    return Response::view('errors.404', array(), 404); 
});