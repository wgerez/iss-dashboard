<?php
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CierreCajaController extends \BaseController {

    private $_data;
    private $_rules;
    private $_messages;

    const OPERACION_EXITOSA = 1;
    const OPERACION_FALLIDA = 2;
    const OPERACION_CANCELADA = 3;
    const OPERACION_INFO = 4;

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

    public function getCrear()
    {
        $iduser = Auth::user()->id;//User::lists('usuario', 'id');oliva225

        $usuarios = User::find($iduser)->persona;
        $aperturacajas = AperturaCaja::all();
        $cierrecajas = CierreCaja::all();
        $bandera = false;
        $cierreecho = false;

        foreach ($aperturacajas as $aperturacaja) {
        	$fechamostrar = FechaHelper::getFechaImpresion($aperturacaja->fechaapertura);
	        list($dia, $mes, $anio) = explode('/', $fechamostrar);
	        $fechamostrar = $anio . '-' . $mes . '-' . $dia;

	        if ($fechamostrar == date('Y-m-d')) {
	        	$bandera = true;
	        }
        }
        
        $habilitar = false;

        if (count($cierrecajas) > 0) {
        	$cierrecaja = $cierrecajas->last()->id + 1;

            foreach ($cierrecajas as $cierrecajass) {
                $fechamostrar = FechaHelper::getFechaImpresion($cierrecajass->fechacierre);
                list($dia, $mes, $anio) = explode('/', $fechamostrar);
                $fechamostrar = $anio . '-' . $mes . '-' . $dia;

                if ($fechamostrar == date('Y-m-d')) {
                    $cierreecho = true;
                    $cierrecaja = CierreCaja::find($cierrecajass->id);

                    $cierrecaja->fechacierre = $fechamostrar;
                }
            }
        } else {
        	$cierrecaja = 1;
        }

        /*highlight_string(var_export($aperturacaja, true));
        	exit();*/

        if ($cierreecho == true) {
            $fecha_inicio = strtotime($fechamostrar);
            //-- APERTURA

            foreach ($aperturacajas as $aperturacaja) {
                $fechamostrarr = FechaHelper::getFechaImpresion($aperturacaja->fechaapertura);
                $porcions = explode("/", $fechamostrarr);
                $fechaaperturas = $porcions[2].'-'.$porcions[1].'-'.$porcions[0];
                $fecha_transaccion = strtotime($fechaaperturas);
                
                if ($fecha_transaccion == $fecha_inicio) {
                    //$usuarios = User::find($aperturacaja->user_id)->persona;
                    //$apeynom = $usuarios->apellido.', '.$usuarios->nombre;

                    $apertura = AperturaCaja::find($aperturacaja->id);
                    list($dia, $mes, $anio) = explode('/', $fechamostrarr);
                    $fechamostrar = $anio . '-' . $mes . '-' . $dia;
                    $apertura->fechaapertura = $fechamostrar;
                }
            }

            //-- CAJA CHICA
            $cajachicas = CajaChica::all();
            $ingreso = 0;
            $egreso = 0;
            $efectivocaja = 0;
            $tarjetacaja = 0;
            $debitocaja = 0;
            $bancariacaja = 0;
            $chequecaja = 0;

            foreach ($cajachicas as $value) {
                $fechatransaccion = FechaHelper::getFechaImpresion($value->fechatransaccion);
                $porcions = explode("/", $fechatransaccion);
                $fechaaperturas = $porcions[2].'-'.$porcions[1].'-'.$porcions[0];
                $fecha_transaccion = strtotime($fechaaperturas);
                
                if ($fecha_transaccion == $fecha_inicio) {
                    if ($value->ingresoegreso == 1) {
                        $ingreso = $ingreso + $value->monto;

                        $efectivocaja = $efectivocaja + $value->efectivo;
                        $tarjetacaja = $tarjetacaja + $value->tarjetacredito;
                        $debitocaja = $debitocaja + $value->tarjetadebito;
                        $bancariacaja = $bancariacaja + $value->cuentabancaria;
                        $chequecaja = $chequecaja + $value->cheque;
                    }

                    if ($value->ingresoegreso == 0) {
                        $egreso = $egreso + $value->monto;
                    }
                }
            }

            $ingresoegreso = $ingreso - $egreso;

            //-- CUOTAS
            $cuotas = DetalleCuotaPago::all();
            $cuotaspaga = 0;
            $efectivocuota = 0;
            $tarjetacuota = 0;
            $debitocuota = 0;
            $bancariacuota = 0;
            $chequecuota = 0;

            foreach ($cuotas as $value) {
                $fechapago = FechaHelper::getFechaImpresion($value->fechapago);
                $porcions = explode("/", $fechapago);
                $fechaaperturas = $porcions[2].'-'.$porcions[1].'-'.$porcions[0];
                $fecha_transaccion = strtotime($fechaaperturas);

                if ($fecha_transaccion == $fecha_inicio) {
                    $cuotaspaga = $cuotaspaga + $value->importe;
                    $formapago = Formapagocuota::whereRaw('detallecuotaspago_id = '. $value->id)->first();
                    $efectivocuota = $efectivocuota + $formapago->efectivo;
                    $tarjetacuota = $tarjetacuota + $formapago->tarjetacredito;
                    $debitocuota = $debitocuota + $formapago->tarjetadebito;
                    $bancariacuota = $bancariacuota + $formapago->cuentabancaria;
                    $chequecuota = $chequecuota + $formapago->cheque;
                }
            }

            //-- MATRICULAS
            $matriculas = DetalleMatriculaPago::all();
            $matriculaspaga = 0;
            $efectivomatricula = 0;
            $tarjetamatricula = 0;
            $debitomatricula = 0;
            $bancariamatricula = 0;
            $chequematricula = 0;

            foreach ($matriculas as $value) {
                $fechapago = FechaHelper::getFechaImpresion($value->fechapago);
                $porcions = explode("/", $fechapago);
                $fechaaperturas = $porcions[2].'-'.$porcions[1].'-'.$porcions[0];
                $fecha_transaccion = strtotime($fechaaperturas);

                if ($fecha_transaccion == $fecha_inicio) {
                    $matriculaspaga = $matriculaspaga + $value->importe;

                    $efectivomatricula = $efectivomatricula + $value->efectivo;
                    $tarjetamatricula = $tarjetamatricula + $value->tarjetacredito;
                    $debitomatricula = $debitomatricula + $value->tarjetadebito;
                    $bancariamatricula = $bancariamatricula + $value->cuentabancaria;
                    //$chequematricula = $chequematricula + $value->cheque;
                }
            }

            $totalsistema = $matriculaspaga + $cuotaspaga + $ingreso - $egreso;

            $totalefectivo = $efectivocaja + $efectivocuota + $efectivomatricula;
            $totaltarjeta = $tarjetacaja + $tarjetacuota +$tarjetamatricula;
            $totaldebito = $debitocaja + $debitocuota + $debitomatricula;
            $totalbancaria = $bancariacaja + $bancariacuota + $bancariamatricula;
            $totalcheque = $chequecaja + $chequecuota + $chequematricula;

            $totalgeneralf = $totalefectivo + $totaltarjeta + $totaldebito + $totalbancaria + $totalcheque;

            return View::make('cierrecaja.editar',[
                'cierrecaja'        => $cierrecaja,
                'iduser'            => $iduser,
                'usuarios'          => $usuarios,
                'habilitar'         => $habilitar,
                'bandera'           => $bandera,
                'cierreecho'        => $cierreecho,
                'apertura'          => $apertura,
                'ingresoegreso'     => $ingresoegreso,
                'egreso'            => $egreso,
                'totalsistema'      => $totalsistema,
                'totalefectivo'     => $totalefectivo,
                'totaltarjeta'      => $totaltarjeta,
                'totaldebito'       => $totaldebito,
                'totalbancaria'     => $totalbancaria,
                'totalcheque'       => $totalcheque,
                'totalgeneralf'     => $totalgeneralf
            ])->with('menu', ModulosHelper::MENU_GESTION_CONTABLE)
                ->with('submenu', ModulosHelper::SUBMENU_CIERRE_CAJA)
                ->with('leer', Session::get('CIERRECAJA_LEER'))
                ->with('editar', Session::get('CIERRECAJA_EDITAR'))
                ->with('imprimir', Session::get('CIERRECAJA_IMPRIMIR'))
                ->with('eliminar', Session::get('CIERRECAJA_ELIMINAR'));
        } else {
        	return View::make('cierrecaja/nuevo')
                ->with('usuarios', $usuarios)
                ->with('iduser', $iduser)
                ->with('cierrecaja', $cierrecaja)
                ->with('habilitar', $habilitar)
                ->with('bandera', $bandera)
                ->with('menu', ModulosHelper::MENU_GESTION_CONTABLE)
                ->with('submenu', ModulosHelper::SUBMENU_CIERRE_CAJA)
                ->with('leer', Session::get('CIERRECAJA_LEER'))
                ->with('editar', Session::get('CIERRECAJA_EDITAR'))
                ->with('imprimir', Session::get('CIERRECAJA_IMPRIMIR'))
                ->with('eliminar', Session::get('CIERRECAJA_ELIMINAR'));
        }
    }

    public function postGuardar()
    {   
        $validator = Validator::make(
            array(
                'fechadesde'         => Input::get('fechadesde')
            ),
            array(
                'fechadesde'         => 'required'
            ),
            array(
                'required' => 'Campo Obligatorio'
            )
        );

        if ($validator->fails()) {
            Session::flash('message', 'ERROR AL INTENTAR GUARDAR LA TRANSACCION.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('cierrecaja/crear')
                ->withErrors($validator)
                ->withInput();
        } else {
            $usuario = Input::get('usuarioid');
            $totalcierre = Input::get('totalcierre');
            $fechadesde = Input::get('fechadesde');
            list($anio, $mes, $dia) = explode('-', $fechadesde);
            $fechadesde = $anio . '/' . $mes . '/' . $dia;
            
            $fecha_cierre = FechaHelper::getFechaParaGuardar($fechadesde);

            $cantidad500 = Input::get('cantidad500');
            $cantidad200 = Input::get('cantidad200');
            $cantidad100 = Input::get('cantidad100');
            $cantidad50  = Input::get('cantidad50');
            $cantidad20  = Input::get('cantidad20');
            $cantidad10  = Input::get('cantidad10');
            $cantidad5   = Input::get('cantidad5');
            $cantidad2   = Input::get('cantidad2');
            $monedas     = Input::get('monedas');

            if ($cantidad500 == '') $cantidad500 = 0;
            
            if ($cantidad200 == '') $cantidad200 = 0;
            
            if ($cantidad100 == '') $cantidad100 = 0;
            
            if ($cantidad50 == '') $cantidad50 = 0;

            if ($cantidad20 == '') $cantidad20 = 0;

            if ($cantidad10 == '') $cantidad10 = 0;

            if ($cantidad5 == '') $cantidad5 = 0;

            if ($cantidad2 == '') $cantidad2 = 0;

            if ($monedas == '') $monedas = 0;

            $total500s = Input::get('total500s');
            $total200s = Input::get('total200s');
            $total100s = Input::get('total100s');
            $total50s = Input::get('total50s');
            $total20s = Input::get('total20s');
            $total10s = Input::get('total10s');
            $total5s = Input::get('total5s');
            $total2s = Input::get('total2s');

            if ($total500s == '') $total500s = 0;
            
            if ($total200s == '') $total200s = 0;
            
            if ($total100s == '') $total100s = 0;
            
            if ($total50s == '') $total50s = 0;

            if ($total20s == '') $total20s = 0;

            if ($total10s == '') $total10s = 0;

            if ($total5s == '') $total5s = 0;

            if ($total2s == '') $total2s = 0;

            $cierrecaja = new CierreCaja();

            $cierrecaja->user_id     	= $usuario;
            $cierrecaja->fechacierre  	= $fecha_cierre;
            $cierrecaja->cantidad500    = $cantidad500;
            $cierrecaja->total500 		= $total500s;
            $cierrecaja->cantidad200    = $cantidad200;
            $cierrecaja->total200 		= $total200s;
            $cierrecaja->cantidad100    = $cantidad100;
            $cierrecaja->total100 		= $total100s;
            $cierrecaja->cantidad50     = $cantidad50;
            $cierrecaja->total50 		= $total50s;
            $cierrecaja->cantidad20     = $cantidad20;
            $cierrecaja->total20 		= $total20s;
            $cierrecaja->cantidad10     = $cantidad10;
            $cierrecaja->total10 		= $total10s;
            $cierrecaja->cantidad5      = $cantidad5;
            $cierrecaja->total5 		= $total5s;
            $cierrecaja->cantidad2      = $cantidad2;
            $cierrecaja->total2 		= $total2s;
            $cierrecaja->monedas      	= $monedas;
            $cierrecaja->totalgeneral 	= $totalcierre;
            $cierrecaja->usuario_alta   = Auth::user()->usuario;  
            $cierrecaja->fecha_alta     = date('Y-m-d');
            
            $cierrecaja->save();

            $cierrecaja= CierreCaja::all();
            $cierrecajas = $cierrecaja->last();

            Session::flash('message', 'LOS DATOS SE CARGARON CORRECTAMENTE!');
            Session::flash('message_type', self::OPERACION_EXITOSA);
            return Redirect::to('cierrecaja/pagado/'.$cierrecajas->id);
        }
    }

    public function getPagado($id)
    {  
        $cierrecaja = CierreCaja::find($id);
        /*highlight_string(var_export($persona, true));
        exit();*/
        $iduser = Auth::user()->id;//User::lists('usuario', 'id');oliva225

        $usuarios = User::find($iduser)->persona;
        $habilitar = false;

        $fechamostrar = FechaHelper::getFechaImpresion($cierrecaja->fechacierre);
        list($dia, $mes, $anio) = explode('/', $fechamostrar);
        $fechamostrar = $anio . '-' . $mes . '-' . $dia;
        $cierrecaja->fechacierre = $fechamostrar;

        //--- APERTURA DE CAJA
        $aperturacajas = AperturaCaja::all();
        $fechadesde = date("Y-m-d");
        $fecha_inicio = strtotime($fechadesde);

        foreach ($aperturacajas as $aperturacaja) {
            $fechamostrarr = FechaHelper::getFechaImpresion($aperturacaja->fechaapertura);
            $porcions = explode("/", $fechamostrarr);
            $fechaaperturas = $porcions[2].'-'.$porcions[1].'-'.$porcions[0];
            $fecha_transaccion = strtotime($fechaaperturas);
            
            if ($fecha_transaccion == $fecha_inicio) {
                //$usuarios = User::find($aperturacaja->user_id)->persona;
                //$apeynom = $usuarios->apellido.', '.$usuarios->nombre;

                $apertura = AperturaCaja::find($aperturacaja->id);
                list($dia, $mes, $anio) = explode('/', $fechamostrarr);
                $fechamostrar = $anio . '-' . $mes . '-' . $dia;
                $apertura->fechaapertura = $fechamostrar;
            }
        }

        //-- CAJA CHICA
        $cajachicas = CajaChica::all();
        $ingreso = 0;
        $egreso = 0;
        $efectivocaja = 0;
        $tarjetacaja = 0;
        $debitocaja = 0;
        $bancariacaja = 0;
        $chequecaja = 0;

        foreach ($cajachicas as $value) {
            $fechatransaccion = FechaHelper::getFechaImpresion($value->fechatransaccion);
            $porcions = explode("/", $fechatransaccion);
            $fechaaperturas = $porcions[2].'-'.$porcions[1].'-'.$porcions[0];
            $fecha_transaccion = strtotime($fechaaperturas);
            
            if ($fecha_transaccion == $fecha_inicio) {
                if ($value->ingresoegreso == 1) {
                    $ingreso = $ingreso + $value->monto;

                    $efectivocaja = $efectivocaja + $value->efectivo;
                    $tarjetacaja = $tarjetacaja + $value->tarjetacredito;
                    $debitocaja = $debitocaja + $value->tarjetadebito;
                    $bancariacaja = $bancariacaja + $value->cuentabancaria;
                    $chequecaja = $chequecaja + $value->cheque;
                } else {
                    $egreso = $egreso + $value->monto;
                }
            }
        }

        $ingresoegreso = $ingreso - $egreso;

        //-- CUOTAS
        $cuotas = DetalleCuotaPago::all();
        $cuotaspaga = 0;
        $efectivocuota = 0;
        $tarjetacuota = 0;
        $debitocuota = 0;
        $bancariacuota = 0;
        $chequecuota = 0;

        foreach ($cuotas as $value) {
            $fechapago = FechaHelper::getFechaImpresion($value->fechapago);
            $porcions = explode("/", $fechapago);
            $fechaaperturas = $porcions[2].'-'.$porcions[1].'-'.$porcions[0];
            $fecha_transaccion = strtotime($fechaaperturas);

            if ($fecha_transaccion == $fecha_inicio) {
                $cuotaspaga = $cuotaspaga + $value->importe;
                $formapago = Formapagocuota::whereRaw('detallecuotaspago_id = '. $value->id)->first();
                $efectivocuota = $efectivocuota + $formapago->efectivo;
                $tarjetacuota = $tarjetacuota + $formapago->tarjetacredito;
                $debitocuota = $debitocuota + $formapago->tarjetadebito;
                $bancariacuota = $bancariacuota + $formapago->cuentabancaria;
                $chequecuota = $chequecuota + $formapago->cheque;
            }
        }

        //-- MATRICULAS
        $matriculas = DetalleMatriculaPago::all();
        $matriculaspaga = 0;
        $efectivomatricula = 0;
        $tarjetamatricula = 0;
        $debitomatricula = 0;
        $bancariamatricula = 0;
        $chequematricula = 0;

        foreach ($matriculas as $value) {
            $fechapago = FechaHelper::getFechaImpresion($value->fechapago);
            $porcions = explode("/", $fechapago);
            $fechaaperturas = $porcions[2].'-'.$porcions[1].'-'.$porcions[0];
            $fecha_transaccion = strtotime($fechaaperturas);

            if ($fecha_transaccion == $fecha_inicio) {
                $matriculaspaga = $matriculaspaga + $value->importe;

                $efectivomatricula = $efectivomatricula + $value->efectivo;
                $tarjetamatricula = $tarjetamatricula + $value->tarjetacredito;
                $debitomatricula = $debitomatricula + $value->tarjetadebito;
                $bancariamatricula = $bancariamatricula + $value->cuentabancaria;
                //$chequematricula = $chequematricula + $value->cheque;
            }
        }

        $totalsistema = $matriculaspaga + $cuotaspaga + $ingreso - $egreso;

        $totalefectivo = $efectivocaja + $efectivocuota + $efectivomatricula;
        $totaltarjeta = $tarjetacaja + $tarjetacuota +$tarjetamatricula;
        $totaldebito = $debitocaja + $debitocuota + $debitomatricula;
        $totalbancaria = $bancariacaja + $bancariacuota + $bancariamatricula;
        $totalcheque = $chequecaja + $chequecuota + $chequematricula;

        $totalgeneralf = $totalefectivo + $totaltarjeta + $totaldebito + $totalbancaria + $totalcheque;

        $cierreecho = false;

        return View::make('cierrecaja.editar',[
            'cierrecaja'  	=> $cierrecaja,
            'iduser'        => $iduser,
            'usuarios'      => $usuarios,
            'apertura'      => $apertura,
            'ingresoegreso' => $ingresoegreso,
            'totalsistema'  => $totalsistema,
            'habilitar'     => $habilitar,
            'totalefectivo' => $totalefectivo,
            'totaltarjeta'  => $totaltarjeta,
            'totaldebito'   => $totaldebito,
            'totalbancaria' => $totalbancaria,
            'totalcheque'   => $totalcheque,
            'totalgeneralf' => $totalgeneralf,
            'cierreecho'    => $cierreecho,
            'egreso'        => $egreso
        ])->with('menu', ModulosHelper::MENU_GESTION_CONTABLE)
            ->with('submenu', ModulosHelper::SUBMENU_CIERRE_CAJA)
            ->with('leer', Session::get('CIERRECAJA_LEER'))
            ->with('editar', Session::get('CIERRECAJA_EDITAR'))
            ->with('imprimir', Session::get('CIERRECAJA_IMPRIMIR'))
            ->with('eliminar', Session::get('CIERRECAJA_ELIMINAR'));
    }

    public function getPdfimprimircierre()
    {
        $id = Input::get('cierrecajaid');
        $cierrecaja = CierreCaja::find($id);

        $iduser = $cierrecaja->user_id;//Auth::user()->id;

        $usuarios = User::find($iduser)->persona;
        $habilitar = false;

        $fechamostrar = FechaHelper::getFechaImpresion($cierrecaja->fechacierre);
        $cierrecaja->fechacierre = $fechamostrar;
        list($dia, $mes, $anio) = explode('/', $fechamostrar);
        $fechamostrar = $anio . '-' . $mes . '-' . $dia;
        $fecha_inicio = strtotime($fechamostrar);

        //-- CAJA CHICA
        $cajachicas = CajaChica::all();
        $ingreso = 0;
        $egreso = 0;
        $efectivocaja = 0;
        $tarjetacaja = 0;
        $debitocaja = 0;
        $bancariacaja = 0;
        $chequecaja = 0;

        foreach ($cajachicas as $value) {
            $fechatransaccion = FechaHelper::getFechaImpresion($value->fechatransaccion);
            $porcions = explode("/", $fechatransaccion);
            $fechaaperturas = $porcions[2].'-'.$porcions[1].'-'.$porcions[0];
            $fecha_transaccion = strtotime($fechaaperturas);
            
            if ($fecha_transaccion == $fecha_inicio) {
                if ($value->ingresoegreso == 1) {
                    $ingreso = $ingreso + $value->monto;

                    $efectivocaja = $efectivocaja + $value->efectivo;
                    $tarjetacaja = $tarjetacaja + $value->tarjetacredito;
                    $debitocaja = $debitocaja + $value->tarjetadebito;
                    $bancariacaja = $bancariacaja + $value->cuentabancaria;
                    $chequecaja = $chequecaja + $value->cheque;
                } else {
                    $egreso = $egreso + $value->monto;
                }
            }
        }

        $ingresoegreso = $ingreso - $egreso;

        //-- CUOTAS
        $cuotas = DetalleCuotaPago::all();
        $cuotaspaga = 0;
        $efectivocuota = 0;
        $tarjetacuota = 0;
        $debitocuota = 0;
        $bancariacuota = 0;
        $chequecuota = 0;

        foreach ($cuotas as $value) {
            $fechapago = FechaHelper::getFechaImpresion($value->fechapago);
            $porcions = explode("/", $fechapago);
            $fechaaperturas = $porcions[2].'-'.$porcions[1].'-'.$porcions[0];
            $fecha_transaccion = strtotime($fechaaperturas);

            if ($fecha_transaccion == $fecha_inicio) {
                $cuotaspaga = $cuotaspaga + $value->importe;
                $formapago = Formapagocuota::whereRaw('detallecuotaspago_id = '. $value->id)->first();
                $efectivocuota = $efectivocuota + $formapago->efectivo;
                $tarjetacuota = $tarjetacuota + $formapago->tarjetacredito;
                $debitocuota = $debitocuota + $formapago->tarjetadebito;
                $bancariacuota = $bancariacuota + $formapago->cuentabancaria;
                $chequecuota = $chequecuota + $formapago->cheque;
            }
        }

        //-- MATRICULAS
        $matriculas = DetalleMatriculaPago::all();
        $matriculaspaga = 0;
        $efectivomatricula = 0;
        $tarjetamatricula = 0;
        $debitomatricula = 0;
        $bancariamatricula = 0;
        $chequematricula = 0;

        foreach ($matriculas as $value) {
            $fechapago = FechaHelper::getFechaImpresion($value->fechapago);
            $porcions = explode("/", $fechapago);
            $fechaaperturas = $porcions[2].'-'.$porcions[1].'-'.$porcions[0];
            $fecha_transaccion = strtotime($fechaaperturas);

            if ($fecha_transaccion == $fecha_inicio) {
                $matriculaspaga = $matriculaspaga + $value->importe;

                $efectivomatricula = $efectivomatricula + $value->efectivo;
                $tarjetamatricula = $tarjetamatricula + $value->tarjetacredito;
                $debitomatricula = $debitomatricula + $value->tarjetadebito;
                $bancariamatricula = $bancariamatricula + $value->cuentabancaria;
                //$chequematricula = $chequematricula + $value->cheque;
            }
        }

        $totalsistema = $matriculaspaga + $cuotaspaga + $ingreso - $egreso;

        $totalefectivo = $efectivocaja + $efectivocuota + $efectivomatricula;
        $totaltarjeta = $tarjetacaja + $tarjetacuota +$tarjetamatricula;
        $totaldebito = $debitocaja + $debitocuota + $debitomatricula;
        $totalbancaria = $bancariacaja + $bancariacuota + $bancariamatricula;
        $totalcheque = $chequecaja + $chequecuota + $chequematricula;

        $totalgeneralf = $totalefectivo + $totaltarjeta + $totaldebito + $totalbancaria + $totalcheque;


        $pdf = PDF::loadView(
            'cierrecaja.recibo',
            [
                'cierrecaja'        => $cierrecaja,
                'iduser'            => $iduser,
                'usuarios'          => $usuarios,
                'totalefectivo'     => $totalefectivo,
                'totaltarjeta'      => $totaltarjeta,
                'totaldebito'       => $totaldebito,
                'totalbancaria'     => $totalbancaria,
                'totalcheque'       => $totalcheque,
                'totalgeneralf'     => $totalgeneralf
            ]
        );
        return $pdf->setOrientation('landscape')->stream();
    }

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
