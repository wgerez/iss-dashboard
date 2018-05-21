<?php
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AperturaCajaController extends \BaseController {

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
		echo "string";
		exit();
	}

    public function getCrear()
    {
        $iduser = Auth::user()->id;//User::lists('usuario', 'id');oliva225

        $usuarios = User::find($iduser)->persona;
        $aperturacajas = AperturaCaja::all();
        $habilitar = false;
        $bandera = false;

        if (count($aperturacajas) > 0) {
        	$aperturacajaid = $aperturacajas->last()->id + 1;
        } else {
        	$aperturacajaid = 1;
        }

        foreach ($aperturacajas as $aperturacajaa) {
            $fechamostrar = FechaHelper::getFechaImpresion($aperturacajaa->fechaapertura);
            list($dia, $mes, $anio) = explode('/', $fechamostrar);
            $fechamostrar = $anio . '-' . $mes . '-' . $dia;

            if ($fechamostrar == date('Y-m-d')) {
                $bandera = true;
                $aperturacaja = AperturaCaja::find($aperturacajaa->id);

                $aperturacaja->fechaapertura = $fechamostrar;
            }
        }
        
        /*highlight_string(var_export($aperturacaja, true));
        	exit();*/
        if ($bandera == true) {
            return View::make('aperturacaja.editar',[
                'aperturacaja'      => $aperturacaja,
                'iduser'            => $iduser,
                'usuarios'          => $usuarios,
                'habilitar'         => $habilitar,
                'bandera'           => $bandera
            ])->with('menu', ModulosHelper::MENU_GESTION_CONTABLE)
                ->with('submenu', ModulosHelper::SUBMENU_APERTURA_CAJA)
                ->with('leer', Session::get('APERTURACAJA_LEER'))
                ->with('editar', Session::get('APERTURACAJA_EDITAR'))
                ->with('imprimir', Session::get('APERTURACAJA_IMPRIMIR'))
                ->with('eliminar', Session::get('APERTURACAJA_ELIMINAR'));
        } else {
        	return View::make('aperturacaja/nuevo')
                ->with('usuarios', $usuarios)
                ->with('iduser', $iduser)
                ->with('aperturacajaid', $aperturacajaid)
                ->with('habilitar', $habilitar)
                ->with('bandera', $bandera)
                ->with('menu', ModulosHelper::MENU_GESTION_CONTABLE)
                ->with('submenu', ModulosHelper::SUBMENU_APERTURA_CAJA)
                ->with('leer', Session::get('APERTURACAJA_LEER'))
                ->with('editar', Session::get('APERTURACAJA_EDITAR'))
                ->with('imprimir', Session::get('APERTURACAJA_IMPRIMIR'))
                ->with('eliminar', Session::get('APERTURACAJA_ELIMINAR'));
        }
    }

    public function postObteneraperturacaja()
    {
        $fechadesde = Input::get('fechadesde');
        $fecha_inicio = strtotime($fechadesde);

        $aperturacajas = AperturaCaja::all();

        if (count($aperturacajas) == 0) {
            $apertura = 1;
        } else {
            $apertura = array();

            foreach ($aperturacajas as $aperturacaja) {
                $fechaapertura = FechaHelper::getFechaImpresion($aperturacaja->fechaapertura);
                $porcions = explode("/", $fechaapertura);
                $fechaaperturas = $porcions[2].'-'.$porcions[1].'-'.$porcions[0];
                $fecha_transaccion = strtotime($fechaaperturas);
                
                if ($fecha_transaccion == $fecha_inicio) {
                    $usuarios = User::find($aperturacaja->user_id)->persona;
                    $apeynom = $usuarios->apellido.', '.$usuarios->nombre;

                    $apertura[] = ['id' => $aperturacaja->id, 'user_id' => $aperturacaja->user_id, 'apeynom' => $apeynom, 'iniciocaja' => $aperturacaja->iniciocaja, 'fechaapertura' => $fechaapertura, 'cantidad500' => $aperturacaja->cantidad500, 'total500' => $aperturacaja->total500, 'cantidad200' => $aperturacaja->cantidad200, 'total200' => $aperturacaja->total200, 'cantidad100' => $aperturacaja->cantidad100, 'total100' => $aperturacaja->total100, 'cantidad50' => $aperturacaja->cantidad50, 'total50' => $aperturacaja->total50, 'cantidad20' => $aperturacaja->cantidad20, 'total20' => $aperturacaja->total20, 'cantidad10' => $aperturacaja->cantidad10, 'total10' => $aperturacaja->total10, 'cantidad5' => $aperturacaja->cantidad5, 'total5' => $aperturacaja->total5, 'cantidad2' => $aperturacaja->cantidad2, 'total2' => $aperturacaja->total2, 'monedas' => $aperturacaja->monedas, 'totalgeneral' => $aperturacaja->totalgeneral];
                }
            }
        }
            /*highlight_string(var_export($apertura, true));
        exit();*/

        return Response::json($apertura);
    }

    public function postGuardar()
    {   
        $validator = Validator::make(
            array(
                'iniciocajas'         => Input::get('iniciocajas'),
                'fechadesde'         => Input::get('fechadesde')
            ),
            array(
                'iniciocajas'         => 'required',
                'fechadesde'         => 'required'
            ),
            array(
                'required' => 'Campo Obligatorio',
                'required' => 'Campo Obligatorio'
            )
        );

        if ($validator->fails()) {
            Session::flash('message', 'ERROR AL INTENTAR GUARDAR LA TRANSACCION.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('aperturacaja/crear')
                ->withErrors($validator)
                ->withInput();
        } else {
            $usuario = Input::get('usuarioid');
            $iniciocaja = Input::get('iniciocajas');
            $fechadesde = Input::get('fechadesde');
            list($anio, $mes, $dia) = explode('-', $fechadesde);
            $fechadesde = $anio . '/' . $mes . '/' . $dia;
            
            $fecha_apertura = FechaHelper::getFechaParaGuardar($fechadesde);

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

            $aperturacaja = new AperturaCaja();

            $aperturacaja->user_id     		= $usuario;
            $aperturacaja->iniciocaja       = $iniciocaja;
            $aperturacaja->fechaapertura    = $fecha_apertura;
            $aperturacaja->cantidad500      = $cantidad500;
            $aperturacaja->total500 		= $total500s;
            $aperturacaja->cantidad200      = $cantidad200;
            $aperturacaja->total200 		= $total200s;
            $aperturacaja->cantidad100      = $cantidad100;
            $aperturacaja->total100 		= $total100s;
            $aperturacaja->cantidad50      	= $cantidad50;
            $aperturacaja->total50 			= $total50s;
            $aperturacaja->cantidad20      	= $cantidad20;
            $aperturacaja->total20 			= $total20s;
            $aperturacaja->cantidad10      	= $cantidad10;
            $aperturacaja->total10 			= $total10s;
            $aperturacaja->cantidad5      	= $cantidad5;
            $aperturacaja->total5 			= $total5s;
            $aperturacaja->cantidad2      	= $cantidad2;
            $aperturacaja->total2 			= $total2s;
            $aperturacaja->monedas      	= $monedas;
            $aperturacaja->totalgeneral 	= $iniciocaja;
            $aperturacaja->usuario_alta     = Auth::user()->usuario;  
            $aperturacaja->fecha_alta       = date('Y-m-d');
            
            $aperturacaja->save();

            $aperturacaja= AperturaCaja::all();
            $aperturacajas = $aperturacaja->last();

            Session::flash('message', 'LOS DATOS SE CARGARON CORRECTAMENTE!');
            Session::flash('message_type', self::OPERACION_EXITOSA);
            return Redirect::to('aperturacaja/pagado/'.$aperturacajas->id);
        }
    }

    public function getPagado($id)
    {  
        $aperturacaja = AperturaCaja::find($id);

        /*highlight_string(var_export($persona, true));
        exit();*/
        $iduser = Auth::user()->id;//User::lists('usuario', 'id');oliva225

        $usuarios = User::find($iduser)->persona;
        $habilitar = false;
        $bandera = false;

        $fechamostrar = FechaHelper::getFechaImpresion($aperturacaja->fechaapertura);
        list($dia, $mes, $anio) = explode('/', $fechamostrar);
        $fechamostrar = $anio . '-' . $mes . '-' . $dia;
        $aperturacaja->fechaapertura = $fechamostrar;

        return View::make('aperturacaja.editar',[
            'aperturacaja'  	=> $aperturacaja,
            'iduser'           	=> $iduser,
            'usuarios'          => $usuarios,
            'habilitar'         => $habilitar,
            'bandera'           => $bandera
        ])->with('menu', ModulosHelper::MENU_GESTION_CONTABLE)
            ->with('submenu', ModulosHelper::SUBMENU_CAJA_CHICA)
            ->with('leer', Session::get('CAJACHICA_LEER'))
            ->with('editar', Session::get('CAJACHICA_EDITAR'))
            ->with('imprimir', Session::get('CAJACHICA_IMPRIMIR'))
            ->with('eliminar', Session::get('CAJACHICA_ELIMINAR'));
    }

    public function getPdfimprimirapertura()
    {
        $id = Input::get('aperturacajaid');
        $aperturacaja = AperturaCaja::find($id);

        $iduser = $aperturacaja->user_id;//Auth::user()->id;

        $usuarios = User::find($iduser)->persona;
        $habilitar = false;

        $fechamostrar = FechaHelper::getFechaImpresion($aperturacaja->fechaapertura);
        //list($dia, $mes, $anio) = explode('/', $fechamostrar);
        //$fechamostrar = $anio . '-' . $mes . '-' . $dia;
        $aperturacaja->fechaapertura = $fechamostrar;

        $pdf = PDF::loadView(
            'aperturacaja.recibo',
            [
              'aperturacaja'  	=> $aperturacaja,
              'iduser'     		=> $iduser,
              'usuarios'     	=> $usuarios
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
