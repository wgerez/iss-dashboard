<?php
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CajaChicaController extends BaseController {

    private $_data;
    private $_rules;
    private $_messages;

    const OPERACION_EXITOSA = 1;
    const OPERACION_FALLIDA = 2;
    const OPERACION_CANCELADA = 3;
    const OPERACION_INFO = 4;
    const NO_EXISTE_ALUMNO = 5;

    public function getListado()
    {
        $organizaciones = Organizacion::lists('nombre', 'id');

        //array_unshift($organizaciones, 'Seleccionar');

    	return View::make('cajachica/listado')
            ->with('organizaciones', $organizaciones)
            ->with('menu', ModulosHelper::MENU_GESTION_CONTABLE)
            ->with('submenu', ModulosHelper::SUBMENU_CAJA_CHICA)
            ->with('leer', Session::get('CAJACHICA_LEER'))
            ->with('editar', Session::get('CAJACHICA_EDITAR'))
            ->with('imprimir', Session::get('CAJACHICA_IMPRIMIR'))
            ->with('eliminar', Session::get('CAJACHICA_ELIMINAR'));
    }

    public function postObtenermovimientos() 
    {
        $movimiento = Input::get('movimiento');
        $orgid = Input::get('organizacion');
        $fechadesdes = Input::get('fechadesde');
        $fechahastas = Input::get('fechahasta');
        $filtroalumno = Input::get('cboFiltroAlumno');
        $txtalumno = Input::get('txtalumno');
        $divAlumno = Input::get('divAlumnos');
        $txt_alumno_id = Input::get('txt_alumno_id');
        $todomovimiento = array();
        $alumno = 'enabled';

        if ($fechahastas == '') $fechahastas = date("Y-m-d");

        if ($fechadesdes == "" || $fechahastas == "") {
            $alumno_id = Input::get('txt_alumno_id');

            if ($movimiento == 1) {
                if (isset($alumno_id) && $filtroalumno == 1) {
                    if (!$alumno_id) {
                        $movimientos = [];
                    } else {
                        $movimientos = CajaChica::whereRaw('ingresoegreso='. 1 .' AND alumno_id='. $alumno_id)->get();
                    }
                } else {
                    $movimientos = CajaChica::whereRaw('ingresoegreso='. 1)->get();
                }

                //$movimientos = (count($movimientos)) ? $movimientos[0] : self::NO_EXISTE_ALUMNO;

                foreach ($movimientos as $value) {
                    $fechatransaccion = FechaHelper::getFechaImpresion($value->fechatransaccion);
                    $movi = 0;

                    if (!$value->alumno_id == NULL) {
                        $per_alum = Alumno::whereRaw('id ='. $value->alumno_id)->first();
                        $apellido = $per_alum->persona->apellido;
                        $nombre = $per_alum->persona->nombre;
                        $apeynom = $apellido .', '. $nombre;
                    } else {
                        $apeynom = '-';
                    }

                    if ($value->ingresoegreso == 1) {
                        $ingreso = $value->monto;
                        $egreso = 0;
                    }

                    $tipomovimiento = TipoMovimiento::whereRaw('id='. $value->movimiento_id)->first()->descripcion;
                    $porcion = explode(" ", $tipomovimiento);
                    $tipomovimiento = $porcion[1];

                    $alumno = 'enabled';

                    if ($value->alumno_id == NULL) $alumno = 'disabled';

                    $todomovimiento[] = ['id' => $value->id, 'alumno_id' => $alumno, 'apeynom' => $apeynom, 'fecha' => $fechatransaccion, 'concepto' => $value->concepto->descripcion, 'tipomovimiento' => $tipomovimiento, 'comprobante' => $value->numeromovimiento, 'ingreso' => $ingreso, 'egreso' => $egreso, 'movimiento' => $movi];
                }
            }

            if ($movimiento == 0) {
                if (isset($alumno_id) && $filtroalumno == 1) {
                    if (!$alumno_id) {
                        $movimientos = [];
                    } else {
                        $movimientos = CajaChica::whereRaw('ingresoegreso='. 0 .' AND alumno_id='. $alumno_id)->get();
                    }
                } else {
                    $movimientos = CajaChica::whereRaw('ingresoegreso='. 0)->get();
                }
                
                foreach ($movimientos as $value) {
                    $fechatransaccion = FechaHelper::getFechaImpresion($value->fechatransaccion);
                    $movi = 0;

                    if (!$value->alumno_id == NULL) {
                        $per_alum = Alumno::whereRaw('id ='. $value->alumno_id)->first();
                        $apellido = $per_alum->persona->apellido;
                        $nombre = $per_alum->persona->nombre;
                        $apeynom = $apellido .', '. $nombre;
                    } else {
                        $apeynom = '-';
                    }

                    if ($value->ingresoegreso == 0) {
                        $ingreso = 0;
                        $egreso = $value->monto;
                    }

                    $tipomovimiento = TipoMovimiento::whereRaw('id='. $value->movimiento_id)->first()->descripcion;
                    $porcion = explode(" ", $tipomovimiento);
                    $tipomovimiento = $porcion[1];

                    $alumno = 'enabled';

                    if ($value->alumno_id == NULL) $alumno = 'disabled';

                    $todomovimiento[] = ['id' => $value->id, 'alumno_id' => $alumno, 'apeynom' => $apeynom, 'fecha' => $fechatransaccion, 'concepto' => $value->concepto->descripcion, 'tipomovimiento' => $tipomovimiento, 'comprobante' => $value->numeromovimiento, 'ingreso' => $ingreso, 'egreso' => $egreso, 'movimiento' => $movi];
                }
            }

            if ($movimiento == 2) {
                $movimientos = CajaChica::all();
                
                foreach ($movimientos as $value) {
                    $fechatransaccion = FechaHelper::getFechaImpresion($value->fechatransaccion);
                    $movi = 1;

                    if (!$value->alumno_id == NULL) {
                        $per_alum = Alumno::whereRaw('id ='. $value->alumno_id)->first();
                        $apellido = $per_alum->persona->apellido;
                        $nombre = $per_alum->persona->nombre;
                        $apeynom = $apellido .', '. $nombre;
                    } else {
                        $apeynom = '-';
                    }

                    if ($value->ingresoegreso == 0) {
                        $ingreso = 0;
                        $egreso = $value->monto;
                    } else {
                        $ingreso = $value->monto;
                        $egreso = 0;
                    }

                    $tipomovimiento = TipoMovimiento::whereRaw('id='. $value->movimiento_id)->first()->descripcion;
                    $porcion = explode(" ", $tipomovimiento);
                    $tipomovimiento = $porcion[1];

                    $alumno = 'enabled';

                    if ($value->alumno_id == NULL) $alumno = 'disabled';

                    $todomovimiento[] = ['id' => $value->id, 'alumno_id' => $alumno, 'apeynom' => $apeynom, 'fecha' => $fechatransaccion, 'concepto' => $value->concepto->descripcion, 'tipomovimiento' => $tipomovimiento, 'comprobante' => $value->numeromovimiento, 'ingreso' => $ingreso, 'egreso' => $egreso, 'movimiento' => $movi];
                }
            }
            //$todomovimiento[] = ['id' => '', 'fecha' => '', 'concepto' => '','comprobante' => '', 'ingreso' => '', 'egreso' => ''];
        } else {
            //$porcion = explode("-", $fechadesdes);
            //$fechadesde = $porcion[0].'/'.$porcion[1].'/'.$porcion[2];
            //$porcions = explode("-", $fechahastas);
            //$fechahasta = $porcions[0].'/'.$porcions[1].'/'.$porcions[2];
            $fecha_inicio = strtotime($fechadesdes);
            $fecha_fin    = strtotime($fechahastas);
            
            if ($movimiento == 1) {
                $alumno_id = Input::get('txt_alumno_id');
                if (isset($alumno_id) && $filtroalumno == 1) {
                    $movimientos = CajaChica::whereRaw('ingresoegreso='. 1 .' AND alumno_id='. $alumno_id)->get();
                } else {
                    $movimientos = CajaChica::whereRaw('ingresoegreso='. 1)->get();
                }
                
                foreach ($movimientos as $value) {
                    $fechatransaccion = FechaHelper::getFechaImpresion($value->fechatransaccion);
                    $movi = 0;
                    $porcions = explode("/", $fechatransaccion);
                    $fechatransaccions = $porcions[2].'-'.$porcions[1].'-'.$porcions[0];
                    $fecha_trans = strtotime($fechatransaccions);

                    if (!$value->alumno_id == NULL) {
                        $per_alum = Alumno::whereRaw('id ='. $value->alumno_id)->first();
                        $apellido = $per_alum->persona->apellido;
                        $nombre = $per_alum->persona->nombre;
                        $apeynom = $apellido .', '. $nombre;
                    } else {
                        $apeynom = '-';
                    }

                    if ($value->ingresoegreso == 1) {
                        $ingreso = $value->monto;
                        $egreso = 0;
                    }

                    $tipomovimiento = TipoMovimiento::whereRaw('id='. $value->movimiento_id)->first()->descripcion;
                    $porcion = explode(" ", $tipomovimiento);
                    $tipomovimiento = $porcion[1];

                    $alumno = 'enabled';

                    if ($value->alumno_id == NULL) $alumno = 'disabled';

                    if ($fecha_trans >= $fecha_inicio && $fecha_trans <= $fecha_fin) {
                        $todomovimiento[] = ['id' => $value->id, 'alumno_id' => $alumno, 'apeynom' => $apeynom, 'fecha' => $fechatransaccion, 'concepto' => $value->concepto->descripcion, 'tipomovimiento' => $tipomovimiento, 'comprobante' => $value->numeromovimiento, 'ingreso' => $ingreso, 'egreso' => $egreso, 'movimiento' => $movi];
                    }
                }
            }

            if ($movimiento == 0) {
                $movimientos = CajaChica::whereRaw('ingresoegreso='. 0)->get();
                
                foreach ($movimientos as $value) {
                    $fechatransaccion = FechaHelper::getFechaImpresion($value->fechatransaccion);
                    $movi = 0;
                    $porcions = explode("/", $fechatransaccion);
                    $fechatransaccions = $porcions[2].'-'.$porcions[1].'-'.$porcions[0];
                    $fecha_trans = strtotime($fechatransaccions);

                    if (!$value->alumno_id == NULL) {
                        $per_alum = Alumno::whereRaw('id ='. $value->alumno_id)->first();
                        $apellido = $per_alum->persona->apellido;
                        $nombre = $per_alum->persona->nombre;
                        $apeynom = $apellido .', '. $nombre;
                    } else {
                        $apeynom = '-';
                    }

                    if ($value->ingresoegreso == 0) {
                        $ingreso = 0;
                        $egreso = $value->monto;
                    }

                    $tipomovimiento = TipoMovimiento::whereRaw('id='. $value->movimiento_id)->first()->descripcion;
                    $porcion = explode(" ", $tipomovimiento);
                    $tipomovimiento = $porcion[1];

                    $alumno = 'enabled';

                    if ($value->alumno_id == NULL) $alumno = 'disabled';

                    if ($fecha_trans >= $fecha_inicio && $fecha_trans <= $fecha_fin) {
                        $todomovimiento[] = ['id' => $value->id, 'alumno_id' => $alumno, 'apeynom' => $apeynom, 'fecha' => $fechatransaccion, 'concepto' => $value->concepto->descripcion, 'tipomovimiento' => $tipomovimiento, 'comprobante' => $value->numeromovimiento, 'ingreso' => $ingreso, 'egreso' => $egreso, 'movimiento' => $movi];
                    }
                }
            }

            if ($movimiento == 2) {
                $movimientos = CajaChica::all();
                
                foreach ($movimientos as $value) {
                    $fechatransaccion = FechaHelper::getFechaImpresion($value->fechatransaccion);
                    $movi = 1;
                    $porcions = explode("/", $fechatransaccion);
                    $fechatransaccions = $porcions[2].'-'.$porcions[1].'-'.$porcions[0];
                    $fecha_trans = strtotime($fechatransaccions);

                    if (!$value->alumno_id == NULL) {
                        $per_alum = Alumno::whereRaw('id ='. $value->alumno_id)->first();
                        $apellido = $per_alum->persona->apellido;
                        $nombre = $per_alum->persona->nombre;
                        $apeynom = $apellido .', '. $nombre;
                    } else {
                        $apeynom = '-';
                    }

                    if ($value->ingresoegreso == 0) {
                        $ingreso = 0;
                        $egreso = $value->monto;
                    } else {
                        $ingreso = $value->monto;
                        $egreso = 0;
                    }

                    $tipomovimiento = TipoMovimiento::whereRaw('id='. $value->movimiento_id)->first()->descripcion;
                    $porcion = explode(" ", $tipomovimiento);
                    $tipomovimiento = $porcion[1];

                    $alumno = 'enabled';

                    if ($value->alumno_id == NULL) $alumno = 'disabled';

                    if ($fecha_trans >= $fecha_inicio && $fecha_trans <= $fecha_fin) {
                        $todomovimiento[] = ['id' => $value->id, 'alumno_id' => $alumno, 'apeynom' => $apeynom, 'fecha' => $fechatransaccion, 'concepto' => $value->concepto->descripcion, 'tipomovimiento' => $tipomovimiento, 'comprobante' => $value->numeromovimiento, 'ingreso' => $ingreso, 'egreso' => $egreso, 'movimiento' => $movi];
                    }
                }
            }
        }

        
        //return Response::json($todomovimiento);
        //$materias = Materia::whereRaw('carrera_id ='. $carrid)->get();


        $organizaciones = Organizacion::lists('nombre', 'id');

        return View::make('cajachica/listado')
            ->with('organizaciones', $organizaciones)
            ->with('todomovimiento', $todomovimiento)
            ->with('OrgID', $orgid)
            ->with('filtroalumno', $filtroalumno)
            ->with('txtalumno', $txtalumno)
            ->with('fechadesdes', $fechadesdes)
            ->with('fechahastas', $fechahastas)
            ->with('divAlumno', $divAlumno)
            ->with('movimiento', $movimiento)
            ->with('txt_alumno_id', $txt_alumno_id)
            ->with('menu', ModulosHelper::MENU_GESTION_CONTABLE)
            ->with('submenu', ModulosHelper::SUBMENU_CAJA_CHICA)
            ->with('leer', Session::get('CAJACHICA_LEER'))
            ->with('editar', Session::get('CAJACHICA_EDITAR'))
            ->with('imprimir', Session::get('CAJACHICA_IMPRIMIR'))
            ->with('eliminar', Session::get('CAJACHICA_ELIMINAR'));
    }

    public function getCrear()
    {
        $organizaciones = Organizacion::lists('nombre', 'id');
        $conceptos      = Concepto::whereRaw('ingresoegreso ='. 1)->get();
        $tipomovimiento = TipoMovimiento::lists('descripcion', 'id');
        $formapago      = FormaPago::lists('descripcion', 'id');
        $organizacionid = Organizacion::whereRaw('id='. 1)->first();
        $movimiento     = CajaChica::whereRaw('movimiento_id='. 1)->get();
        $movimientos    = $movimiento->last();
        $movimientos    = $movimientos->numeromovimiento + 1;

        //array_unshift($organizaciones, 'Seleccionar');

          return View::make('cajachica/nuevo',[
              'arrOrganizaciones'   => $organizaciones,
              'organizacionid'      => $organizacionid,
              'conceptos'           => $conceptos,
              'tipomovimiento'      => $tipomovimiento,
              'movimientos'         => $movimientos,
              'formapago'           => $formapago
            ])
            ->with('menu', ModulosHelper::MENU_GESTION_CONTABLE)
            ->with('submenu', ModulosHelper::SUBMENU_CAJA_CHICA)
            ->with('leer', Session::get('CAJACHICA_LEER'))
            ->with('editar', Session::get('CAJACHICA_EDITAR'))
            ->with('imprimir', Session::get('CAJACHICA_IMPRIMIR'))
            ->with('eliminar', Session::get('CAJACHICA_ELIMINAR'));
    }

    public function postGuardar()
    {   
        $validator = Validator::make(
            array(
                'monto'         => Input::get('monto')
            ),
            array(
                'monto'         => 'required'
            ),
            array(
                'required' => 'Campo Obligatorio' 
            )
        );

        if ($validator->fails()) {
            Session::flash('message', 'ERROR AL INTENTAR GUARDAR LA TRANSACCION.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('cajachica/crear')
                ->withErrors($validator)
                ->withInput();
        } else {
            $numeromovimiento = Input::get('txtmovimiento');
            $organizacion_id = Input::get('txt_organizacion_id');
            $concepto = Input::get('cboFiltroConcepto');

            if ($organizacion_id == '') $organizacion_id = NULL;

            $carrera_id = Input::get('txt_carrera_id');
            if ($carrera_id == '') $carrera_id = NULL;

            $alumno_id = Input::get('txt_alumno_id');
            if ($alumno_id == '') $alumno_id = NULL;
            
            if ($concepto == 1 || $concepto == 2 || $concepto == 5 || $concepto == 7) {
                if ($alumno_id == NULL) {
                    Session::flash('message', 'ERROR, DEBE SELECCIONAR UN ALUMNO PARA EL TIPO DE TRANSACCION.');
                    Session::flash('message_type', self::OPERACION_FALLIDA);
                    return Redirect::to('cajachica/crear')
                        ->withErrors($validator)
                        ->withInput();
                }
            }

            $monto             = Input::get('monto');
            $cheque            = Input::get('cheque');
            $efectivo          = Input::get('efectivo');
            $tarjeta           = Input::get('tarjeta');
            $debito            = Input::get('debito');
            $bancaria          = Input::get('bancaria');

            if ($efectivo == '') $efectivo = 0;
            
            if ($tarjeta == '') $tarjeta = 0;
            
            if ($debito == '') $debito = 0;
            
            if ($bancaria == '') $bancaria = 0;

            if ($cheque == '') $cheque = 0;

            $totalpago = $efectivo + $tarjeta + $debito + $bancaria + $cheque;

            if ($totalpago < 1) {
                Session::flash('message', 'ERROR, DEBE AGREGAR LAS FORMA DE PAGO.');
                    Session::flash('message_type', self::OPERACION_FALLIDA);
                    return Redirect::to('cajachica/crear')
                        ->withErrors($validator)
                        ->withInput();
            }

            if ($totalpago < $monto) {
                Session::flash('message', 'ERROR, LA FORMA DE PAGO NO DEBE SUPERAR EL MONTO A PAGAR.');
                    Session::flash('message_type', self::OPERACION_FALLIDA);
                    return Redirect::to('cajachica/crear')
                        ->withErrors($validator)
                        ->withInput();
            }

            $cajachica = new CajaChica();

            $cajachica->organizacion_id     = $organizacion_id;
            $cajachica->carrera_id          = $carrera_id;
            $cajachica->alumno_id           = $alumno_id;
            $cajachica->concepto_id         = $concepto;
            $cajachica->observacionconcepto = trim(Input::get('observaciones'));
            $cajachica->monto               = Input::get('monto');
            $cajachica->movimiento_id       = Input::get('tipomovimiento');
            $cajachica->numeromovimiento    = $numeromovimiento;
            $cajachica->formapago_id        = 1;
            $cajachica->observacionpago     = trim(Input::get('observaciones2'));
            $cajachica->fechatransaccion    = date('Y-m-d');
            $cajachica->usuario_alta        = Auth::user()->usuario;  
            $cajachica->fecha_alta          = date('Y-m-d');
            $cajachica->ingresoegreso       = Input::get('parcialfra');
            $cajachica->efectivo            = $efectivo;
            $cajachica->tarjetacredito      = $tarjeta;
            $cajachica->tarjetadebito       = $debito;
            $cajachica->cuentabancaria      = $bancaria;
            $cajachica->cheque              = $cheque;
            $cajachica->usuario_alta        = Auth::user()->usuario;  
            $cajachica->fecha_alta          = date('Y-m-d');
            
            $cajachica->save();

            $cajachica= CajaChica::all();
            $cajachicas = $cajachica->last();

            Session::flash('message', 'LOS DATOS SE CARGARON CORRECTAMENTE!');
            Session::flash('message_type', self::OPERACION_EXITOSA);
            return Redirect::to('cajachica/generarecibo/'.$cajachicas->id);
        }
    }

    public function getEditar($id)
    {  
        $cajachica = CajaChica::find($id);

        if (!$cajachica->alumno_id == NULL) {
            $alumno = Alumno::find($cajachica->alumno_id);
            $persona = Persona::find($alumno->persona_id);
        } else {
            $persona = '';
        }

        /*highlight_string(var_export($tipomovimiento->descripcion, true));
        exit();*/
        $organizaciones = Organizacion::all();
        $carreras       = Carrera::all();
        $tipomovimiento = TipoMovimiento::whereRaw('id ='. $cajachica->movimiento_id)->first();
        $formapagos = FormaPago::all();
        $conceptos = Concepto::whereRaw('ingresoegreso ='. $cajachica->ingresoegreso)->get();

        return View::make('cajachica.editar',[
            'arrOrganizaciones'  => $organizaciones,
            'carreras'           => $carreras,
            'cajachica'          => $cajachica,
            'persona'            => $persona,
            'tipomovimiento'     => $tipomovimiento,
            'formapagos'         => $formapagos,
            'conceptos'          => $conceptos
        ])->with('menu', ModulosHelper::MENU_GESTION_CONTABLE)
            ->with('submenu', ModulosHelper::SUBMENU_CAJA_CHICA)
            ->with('leer', Session::get('CAJACHICA_LEER'))
            ->with('editar', Session::get('CAJACHICA_EDITAR'))
            ->with('imprimir', Session::get('CAJACHICA_IMPRIMIR'))
            ->with('eliminar', Session::get('CAJACHICA_ELIMINAR'));
    }

    public function postUpdate()
    {   
        $id = Input::get('cajaid');

        $validator = Validator::make(
            array(
                'monto'         => Input::get('monto')
            ),
            array(
                'monto'         => 'required'
            ),
            array(
                'required' => 'Campo Obligatorio' 
            )
        );

        if ($validator->fails()) {
            Session::flash('message', 'ERROR AL INTENTAR MODIFICAR.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('cajachica/editar/'. $id)
                ->withErrors($validator)
                ->withInput();
        } else {
            $numeromovimiento = Input::get('txtmovimiento');
            $organizacion_id = Input::get('txt_organizacion_id');
            $concepto = Input::get('cboFiltroConcepto');
            
            if ($organizacion_id == '') $organizacion_id = NULL;

            $carrera_id = Input::get('txt_carrera_id');
            if ($carrera_id == '') $carrera_id = NULL;

            $alumno_id = Input::get('txt_alumno_id');
            if ($alumno_id == '') $alumno_id = NULL;
            
            if ($concepto == 1 || $concepto == 2 || $concepto == 6 || $concepto == 8) {
                if ($alumno_id == NULL) {
                    Session::flash('message', 'ERROR, DEBE SELECCIONAR UN ALUMNO PARA EL TIPO DE TRANSACCION.');
                    Session::flash('message_type', self::OPERACION_FALLIDA);
                    return Redirect::to('cajachica/editar/'. $id)
                        ->withErrors($validator)
                        ->withInput();
                }
            }

            $monto             = Input::get('monto');
            $cheque            = Input::get('cheque');
            $efectivo          = Input::get('efectivo');
            $tarjeta           = Input::get('tarjeta');
            $debito            = Input::get('debito');
            $bancaria          = Input::get('bancaria');

            if ($efectivo == '') $efectivo = 0;
            
            if ($tarjeta == '') $tarjeta = 0;
            
            if ($debito == '') $debito = 0;
            
            if ($bancaria == '') $bancaria = 0;

            if ($cheque == '') $cheque = 0;

            $totalpago = $efectivo + $tarjeta + $debito + $bancaria +$cheque;

            if ($totalpago < 1) {
                Session::flash('message', 'ERROR, DEBE AGREGAR LAS FORMA DE PAGO.');
                    Session::flash('message_type', self::OPERACION_FALLIDA);
                    return Redirect::to('cajachica/editar/'. $id)
                        ->withErrors($validator)
                        ->withInput();
            }

            if ($totalpago < $monto) {
                Session::flash('message', 'ERROR, LA FORMA DE PAGO NO DEBE SUPERAR EL MONTO A PAGAR.');
                    Session::flash('message_type', self::OPERACION_FALLIDA);
                    return Redirect::to('cajachica/editar/'. $id)
                        ->withErrors($validator)
                        ->withInput();
            }

            $cajachica = CajaChica::find($id);

            $cajachica->organizacion_id     = $organizacion_id;
            $cajachica->carrera_id          = $carrera_id;
            $cajachica->alumno_id           = $alumno_id;
            $cajachica->concepto_id         = $concepto;
            $cajachica->observacionconcepto = trim(Input::get('observaciones'));
            $cajachica->monto               = $monto;
            $cajachica->movimiento_id       = Input::get('tipomovimiento');
            $cajachica->numeromovimiento    = $numeromovimiento;
            $cajachica->formapago_id        = 1;
            $cajachica->observacionpago     = trim(Input::get('observaciones2'));
            $cajachica->fechatransaccion    = date('Y-m-d');
            $cajachica->usuario_modi        = Auth::user()->usuario;  
            $cajachica->fecha_modi          = date('Y-m-d');
            $cajachica->ingresoegreso       = Input::get('parcialfra');
            $cajachica->efectivo            = $efectivo;
            $cajachica->tarjetacredito      = $tarjeta;
            $cajachica->tarjetadebito       = $debito;
            $cajachica->cuentabancaria      = $bancaria;
            $cajachica->cheque              = $cheque;
            $cajachica->usuario_modi        = Auth::user()->usuario;  
            $cajachica->fecha_modi          = date('Y-m-d');
            
            $cajachica->save();

            Session::flash('message', 'LOS DATOS SE ACTUALIZARON CORRECTAMENTE!');
            Session::flash('message_type', self::OPERACION_EXITOSA);
            return Redirect::to('cajachica/editar/'.$id);
        }
    }

    public function getGenerarecibo($id)
    {  
        $cajachica = CajaChica::find($id);

        if (!$cajachica->alumno_id == NULL) {
            $alumno = Alumno::find($cajachica->alumno_id);
            $persona = Persona::find($alumno->persona_id);
        } else {
            $persona = '';
        }

        /*highlight_string(var_export($persona, true));
        exit();*/
        $organizaciones = Organizacion::all();
        $carreras       = Carrera::all();
        $tipomovimiento = TipoMovimiento::all();
        $formapagos = FormaPago::all();
        $conceptos = Concepto::whereRaw('ingresoegreso ='. $cajachica->ingresoegreso)->get();

        return View::make('cajachica.generarecibo',[
            'arrOrganizaciones'  => $organizaciones,
            'carreras'           => $carreras,
            'cajachica'          => $cajachica,
            'persona'            => $persona,
            'tipomovimiento'     => $tipomovimiento,
            'formapagos'         => $formapagos,
            'conceptos'          => $conceptos
        ])->with('menu', ModulosHelper::MENU_GESTION_CONTABLE)
            ->with('submenu', ModulosHelper::SUBMENU_CAJA_CHICA)
            ->with('leer', Session::get('CAJACHICA_LEER'))
            ->with('editar', Session::get('CAJACHICA_EDITAR'))
            ->with('imprimir', Session::get('CAJACHICA_IMPRIMIR'))
            ->with('eliminar', Session::get('CAJACHICA_ELIMINAR'));
    }

    public function postBuscarcarreras()
    {
        $alumno_id = Input::get('alumno_id');
        $alumnocarrera = AlumnoCarrera::whereRaw('alumno_id ='. $alumno_id)->get();
        $alucarrera = array();

        foreach ($alumnocarrera as $value) {
            $carrera = Carrera::whereRaw('id ='. $value->carrera_id)->first();

            $alucarrera[] = ['id' => $carrera->id, 'carrera' => $carrera->carrera];
        }

        return Response::json($alucarrera);
    }

    public function postObtenerconcepto()
    {
        $concepto = Input::get('concepto');
        $conceptos = Concepto::whereRaw('ingresoegreso ='. $concepto)->get();

        return Response::json($conceptos);
    }

    public function postBuscarmonto()
    {
        $alumno_id = Input::get('alumno_id');
        $cajachica = CajaChica::whereRaw('alumno_id ='. $alumno_id)->get();
        $cajachicas = $cajachica->last();
        $monto = $cajachicas->monto;

        return Response::json($monto);
    }

    public function postObtenercomprobante()
    {
        $movimiento = Input::get('movimiento');
        $movimiento1    = CajaChica::whereRaw('movimiento_id='. $movimiento)->get();
        $movimientos    = $movimiento1->last();

        if (isset($movimientos->numeromovimiento)) {
            $movimientos = $movimientos->numeromovimiento + 1;
        } else {
            $movimientos = 1;
        }
       
        return Response::json($movimientos);
        /*$numeromovimiento = Input::get('txtmovimiento');
        $mensaje = 'BIEN';

        $cajachicas = CajaChica::whereRaw('numeromovimiento ='. $numeromovimiento)->first();

        if (isset($cajachicas)) {
            $mensaje = 'ERROR';
        }

        return Response::json($mensaje);*/
    }

    public function getPdfrecibo()
    {
        $ids = Input::get('cajaid');

        if ($ids == '') {
            $cajachica = CajaChica::all();
            $cajachicas = $cajachica->last();
        } else {
            $cajachicas = CajaChica::whereRaw('id='.$ids)->first();
        }

        if (!$cajachicas->alumno_id == NULL) {
            $alumno = Alumno::find($cajachicas->alumno_id);
            $persona = Persona::find($alumno->persona_id);
        } else {
            $alumno = '';
            $persona = '';
        }
        
        if (!$cajachicas->carrera_id == NULL) {
            $carrera = Carrera::find($cajachicas->carrera_id);
        } else {
            $carrera = '';
        }

        $cajachicas->fechatransaccion =  FechaHelper::getFechaImpresion($cajachicas->fechatransaccion);
        $porcion = explode(".", $cajachicas->monto);
        if ($porcion[1] == 00) {
            $monto = $porcion[0];
        } else {
            $monto = $cajachicas->monto;
        }

        $montonumero =  AifLibNumber::toWord($monto);
        
        $pdf = PDF::loadView(
            'cajachica.recibo',
            [
              'cajachicas'  => $cajachicas,
              'persona'     => $persona,
              'carrera'     => $carrera,
              'montonumero' => $montonumero,
              'monto'       => $monto
            ]
        );
        return $pdf->setOrientation('landscape')->stream();
    }

    public function getPdfimprimirrecibo($id)
    {
        $cajachicas= CajaChica::find($id);
        //$cajachicas = $cajachica->last();
        $alumno = Alumno::find($cajachicas->alumno_id);
        $persona = Persona::find($alumno->persona_id);
        $carrera = Carrera::find($cajachicas->carrera_id);

        $cajachicas->fechatransaccion =  FechaHelper::getFechaImpresion($cajachicas->fechatransaccion);
        $porcion = explode(".", $cajachicas->monto);
        if ($porcion[1] == 00) {
            $monto = $porcion[0];
        } else {
            $monto = $cajachicas->monto;
        }

        $montonumero =  AifLibNumber::toWord($monto);
        
        $pdf = PDF::loadView(
            'cajachica.recibo',
            [
              'cajachicas'  => $cajachicas,
              'persona'     => $persona,
              'carrera'     => $carrera,
              'montonumero' => $montonumero,
              'monto'       => $monto
            ]
        );
        return $pdf->setOrientation('landscape')->stream();
    }

    public function getPdfimprimirlistado()
    {
        $movimiento = Input::get('movimiento');
        $orgid = Input::get('organizacion');
        $fechadesde = Input::get('fechadesde');
        $fechahasta = Input::get('fechahasta');
        $filtroalumno = Input::get('cboFiltroAlumno');
        $todomovimiento = array();
        $alumno = 'enabled';
        $datos = 0;

        if ($fechahasta == '') $fechahasta = date("Y-m-d");

        if ($fechadesde == "" || $fechahasta == "") {
            $alumno_id = Input::get('txt_alumno_id');

            if ($movimiento == 1) {
                if (isset($alumno_id) && $filtroalumno == 1) {
                    if (!$alumno_id) {
                        $movimientos = [];
                    } else {
                        $movimientos = CajaChica::whereRaw('ingresoegreso='. 1 .' AND alumno_id='. $alumno_id)->get();
                    }
                } else {
                    $movimientos = CajaChica::whereRaw('ingresoegreso='. 1)->get();
                }

                //$movimientos = (count($movimientos)) ? $movimientos[0] : self::NO_EXISTE_ALUMNO;

                foreach ($movimientos as $value) {
                    $fechatransaccion = FechaHelper::getFechaImpresion($value->fechatransaccion);
                    $movi = 0;

                    if ($value->ingresoegreso == 1) {
                        $ingreso = $value->monto;
                        $egreso = 0;
                    }
                    
                    $nombre = '';
                    $dni = '';

                    if (!$value->alumno_id == NULL) {
                        $alumnos = Alumno::whereRaw('id='. $value->alumno_id)->first();
                        $personas = Persona::whereRaw('id='. $alumnos->persona_id)->first();
                        $nombre = $personas->apellido.', '.$personas->nombre;
                        $dni = $personas->nrodocumento;
                        $datos = 1;
                    }
                    
                    $tipomovimiento = TipoMovimiento::whereRaw('id='. $value->movimiento_id)->first()->descripcion;
                    $porcion = explode(" ", $tipomovimiento);
                    $tipomovimiento = $porcion[1];

                    $alumno = 'enabled';

                    if ($value->alumno_id == NULL) $alumno = 'disabled';

                    $todomovimiento[] = ['id' => $value->id, 'nombre' => $nombre, 'dni' => $dni, 'alumno_id' => $alumno, 'fecha' => $fechatransaccion, 'concepto' => $value->concepto->descripcion, 'tipomovimiento' => $tipomovimiento, 'comprobante' => $value->numeromovimiento, 'ingreso' => $ingreso, 'egreso' => $egreso, 'movimiento' => $movi, 'datos' => $datos];
                }
            }

            if ($movimiento == 0) {
                if (isset($alumno_id) && $filtroalumno == 1) {
                    if (!$alumno_id) {
                        $movimientos = [];
                    } else {
                        $movimientos = CajaChica::whereRaw('ingresoegreso='. 0 .' AND alumno_id='. $alumno_id)->get();
                    }
                } else {
                    $movimientos = CajaChica::whereRaw('ingresoegreso='. 0)->get();
                }
                
                foreach ($movimientos as $value) {
                    $fechatransaccion = FechaHelper::getFechaImpresion($value->fechatransaccion);
                    $movi = 0;

                    if ($value->ingresoegreso == 0) {
                        $ingreso = 0;
                        $egreso = $value->monto;
                    }

                    $nombre = '';
                    $dni = '';

                    if (!$value->alumno_id == NULL) {
                        $alumnos = Alumno::whereRaw('id='. $value->alumno_id)->first();
                        $personas = Persona::whereRaw('id='. $alumnos->persona_id)->first();
                        $nombre = $personas->apellido.', '.$personas->nombre;
                        $dni = $personas->nrodocumento;
                        $datos = 1;
                    }
                    
                    $tipomovimiento = TipoMovimiento::whereRaw('id='. $value->movimiento_id)->first()->descripcion;
                    $porcion = explode(" ", $tipomovimiento);
                    $tipomovimiento = $porcion[1];
                    
                    $alumno = 'enabled';

                    if ($value->alumno_id == NULL) $alumno = 'disabled';

                    $todomovimiento[] = ['id' => $value->id, 'nombre' => $nombre, 'dni' => $dni, 'alumno_id' => $alumno, 'fecha' => $fechatransaccion, 'concepto' => $value->concepto->descripcion, 'tipomovimiento' => $tipomovimiento, 'comprobante' => $value->numeromovimiento, 'ingreso' => $ingreso, 'egreso' => $egreso, 'movimiento' => $movi, 'datos' => $datos];
                }
            }

            if ($movimiento == 2) {
                $movimientos = CajaChica::all();
                
                foreach ($movimientos as $value) {
                    $fechatransaccion = FechaHelper::getFechaImpresion($value->fechatransaccion);
                    $movi = 1;

                    if ($value->ingresoegreso == 0) {
                        $ingreso = 0;
                        $egreso = $value->monto;
                    } else {
                        $ingreso = $value->monto;
                        $egreso = 0;
                    }

                    $nombre = '';
                    $dni = '';

                    if (!$value->alumno_id == NULL) {
                        $alumnos = Alumno::whereRaw('id='. $value->alumno_id)->first();
                        $personas = Persona::whereRaw('id='. $alumnos->persona_id)->first();
                        $nombre = $personas->apellido.', '.$personas->nombre;
                        $dni = $personas->nrodocumento;
                        $datos = 1;
                    }
                    
                    $tipomovimiento = TipoMovimiento::whereRaw('id='. $value->movimiento_id)->first()->descripcion;
                    $porcion = explode(" ", $tipomovimiento);
                    $tipomovimiento = $porcion[1];
                    
                    $alumno = 'enabled';

                    if ($value->alumno_id == NULL) $alumno = 'disabled';

                    $todomovimiento[] = ['id' => $value->id, 'nombre' => $nombre, 'dni' => $dni, 'alumno_id' => $alumno, 'fecha' => $fechatransaccion, 'concepto' => $value->concepto->descripcion, 'tipomovimiento' => $tipomovimiento, 'comprobante' => $value->numeromovimiento, 'ingreso' => $ingreso, 'egreso' => $egreso, 'movimiento' => $movi, 'datos' => $datos];
                }
            }
            //$todomovimiento[] = ['id' => '', 'fecha' => '', 'concepto' => '','comprobante' => '', 'ingreso' => '', 'egreso' => ''];
        } else {
            /*$porcion = explode("-", $fechadesde);
            $fechadesde = $porcion[2].'/'.$porcion[1].'/'.$porcion[0];
            $porcions = explode("-", $fechahasta);
            $fechahasta = $porcions[2].'/'.$porcions[1].'/'.$porcions[0];*/
            $fecha_inicio = strtotime($fechadesde);
            $fecha_fin    = strtotime($fechahasta);

            if ($movimiento == 1) {
                $alumno_id = Input::get('txt_alumno_id');
                if (isset($alumno_id) && $filtroalumno == 1) {
                    $movimientos = CajaChica::whereRaw('ingresoegreso='. 1 .' AND alumno_id='. $alumno_id)->get();
                } else {
                    $movimientos = CajaChica::whereRaw('ingresoegreso='. 1)->get();
                }
                
                foreach ($movimientos as $value) {
                    $fechatransaccion = FechaHelper::getFechaImpresion($value->fechatransaccion);
                    $movi = 0;
                    $porcions = explode("/", $fechatransaccion);
                    $fechatransaccions = $porcions[2].'-'.$porcions[1].'-'.$porcions[0];
                    $fecha_trans = strtotime($fechatransaccions);

                    if ($value->ingresoegreso == 1) {
                        $ingreso = $value->monto;
                        $egreso = 0;
                    }

                    $nombre = '';
                    $dni = '';

                    if (!$value->alumno_id == NULL) {
                        $alumnos = Alumno::whereRaw('id='. $value->alumno_id)->first();
                        $personas = Persona::whereRaw('id='. $alumnos->persona_id)->first();
                        $nombre = $personas->apellido.', '.$personas->nombre;
                        $dni = $personas->nrodocumento;
                        $datos = 1;
                    }
                    
                    $tipomovimiento = TipoMovimiento::whereRaw('id='. $value->movimiento_id)->first()->descripcion;
                    $porcion = explode(" ", $tipomovimiento);
                    $tipomovimiento = $porcion[1];
                    
                    $alumno = 'enabled';

                    if ($value->alumno_id == NULL) $alumno = 'disabled';

                    if ($fecha_trans >= $fecha_inicio && $fecha_trans <= $fecha_fin) {
                        $todomovimiento[] = ['id' => $value->id, 'nombre' => $nombre, 'dni' => $dni, 'alumno_id' => $alumno, 'fecha' => $fechatransaccion, 'concepto' => $value->concepto->descripcion, 'tipomovimiento' => $tipomovimiento, 'comprobante' => $value->numeromovimiento, 'ingreso' => $ingreso, 'egreso' => $egreso, 'movimiento' => $movi, 'datos' => $datos];
                    }
                }
            }

            if ($movimiento == 0) {
                $movimientos = CajaChica::whereRaw('ingresoegreso='. 0)->get();
                
                foreach ($movimientos as $value) {
                    $fechatransaccion = FechaHelper::getFechaImpresion($value->fechatransaccion);
                    $movi = 0;
                    $porcions = explode("/", $fechatransaccion);
                    $fechatransaccions = $porcions[2].'-'.$porcions[1].'-'.$porcions[0];
                    $fecha_trans = strtotime($fechatransaccions);

                    if ($value->ingresoegreso == 0) {
                        $ingreso = 0;
                        $egreso = $value->monto;
                    }

                    $nombre = '';
                    $dni = '';

                    if (!$value->alumno_id == NULL) {
                        $alumnos = Alumno::whereRaw('id='. $value->alumno_id)->first();
                        $personas = Persona::whereRaw('id='. $alumnos->persona_id)->first();
                        $nombre = $personas->apellido.', '.$personas->nombre;
                        $dni = $personas->nrodocumento;
                        $datos = 1;
                    }
                    
                    $tipomovimiento = TipoMovimiento::whereRaw('id='. $value->movimiento_id)->first()->descripcion;
                    $porcion = explode(" ", $tipomovimiento);
                    $tipomovimiento = $porcion[1];
                    
                    $alumno = 'enabled';

                    if ($value->alumno_id == NULL) $alumno = 'disabled';

                    if ($fecha_trans >= $fecha_inicio && $fecha_trans <= $fecha_fin) {
                        $todomovimiento[] = ['id' => $value->id, 'nombre' => $nombre, 'dni' => $dni, 'alumno_id' => $alumno, 'fecha' => $fechatransaccion, 'concepto' => $value->concepto->descripcion, 'tipomovimiento' => $tipomovimiento, 'comprobante' => $value->numeromovimiento, 'ingreso' => $ingreso, 'egreso' => $egreso, 'movimiento' => $movi, 'datos' => $datos];
                    }
                }
            }

            if ($movimiento == 2) {
                $movimientos = CajaChica::all();
                
                foreach ($movimientos as $value) {
                    $fechatransaccion = FechaHelper::getFechaImpresion($value->fechatransaccion);
                    $movi = 1;
                    $porcions = explode("/", $fechatransaccion);
                    $fechatransaccions = $porcions[2].'-'.$porcions[1].'-'.$porcions[0];
                    $fecha_trans = strtotime($fechatransaccions);

                    if ($value->ingresoegreso == 0) {
                        $ingreso = 0;
                        $egreso = $value->monto;
                    } else {
                        $ingreso = $value->monto;
                        $egreso = 0;
                    }

                    $nombre = '';
                    $dni = '';

                    if (!$value->alumno_id == NULL) {
                        $alumnos = Alumno::whereRaw('id='. $value->alumno_id)->first();
                        $personas = Persona::whereRaw('id='. $alumnos->persona_id)->first();
                        $nombre = $personas->apellido.', '.$personas->nombre;
                        $dni = $personas->nrodocumento;
                        $datos = 1;
                    }
                    
                    $tipomovimiento = TipoMovimiento::whereRaw('id='. $value->movimiento_id)->first()->descripcion;
                    $porcion = explode(" ", $tipomovimiento);
                    $tipomovimiento = $porcion[1];
                    
                    $alumno = 'enabled';

                    if ($value->alumno_id == NULL) $alumno = 'disabled';

                    if ($fecha_trans >= $fecha_inicio && $fecha_trans <= $fecha_fin) {
                        $todomovimiento[] = ['id' => $value->id, 'nombre' => $nombre, 'dni' => $dni, 'alumno_id' => $alumno, 'fecha' => $fechatransaccion, 'concepto' => $value->concepto->descripcion, 'tipomovimiento' => $tipomovimiento, 'comprobante' => $value->numeromovimiento, 'ingreso' => $ingreso, 'egreso' => $egreso, 'movimiento' => $movi, 'datos' => $datos];
                    }
                }
            }
        }

        $pdf = PDF::loadView(
            'cajachica.imprimir',
            [
              'todomovimiento'  => $todomovimiento
            ]
        );
        return $pdf->setOrientation('landscape')->stream();
    }

}
