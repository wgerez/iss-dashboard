<?php
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FeriadosController extends \BaseController {

    private $_data;
    private $_rules;
    private $_messages;

    const OPERACION_EXITOSA = 1;
    const OPERACION_FALLIDA = 2;
    const OPERACION_CANCELADA = 3;
    const OPERACION_INFO = 4;
    const NO_EXISTE_FERIADO = 5;

    public function getIndex()
    {
        return Redirect::to('feriados/listado');
    }

    public function getListado()
    {
        $ciclos = CicloLectivo::with('Organizacion')->get();
        $arrOrganizaciones = Organizacion::lists('nombre', 'id');
        array_unshift($arrOrganizaciones, 'Seleccionar');

        return View::make('feriados.listado')
            //->with('ciclos', $ciclos)
            ->with('arrOrganizaciones', $arrOrganizaciones)
            ->with('menu', ModulosHelper::MENU_GESTION_ADMINISTRATIVA)
            ->with('submenu', ModulosHelper::SUBMENU_CALENDARIOS)
            ->with('submenu2', ModulosHelper::SUBMENU_2_FERIADOS)
            ->with('leer', Session::get('CALENDARIO_LEER'))
            ->with('editar', Session::get('CALENDARIO_EDITAR'))
            ->with('imprimir', Session::get('CALENDARIO_IMPRIMIR'))
            ->with('eliminar', Session::get('CALENDARIO_ELIMINAR'));
    }

    public function getCrear()
    {
        $arrOrganizaciones = Organizacion::lists('nombre', 'id');


        array_unshift($arrOrganizaciones, 'Seleccionar');

        return View::make('feriados.nuevo')
            ->with('arrOrganizaciones', $arrOrganizaciones)
            ->with('menu', ModulosHelper::MENU_GESTION_ADMINISTRATIVA)
            ->with('submenu', ModulosHelper::SUBMENU_CALENDARIOS)
            ->with('submenu2', ModulosHelper::SUBMENU_2_FERIADOS)
            ->with('leer', Session::get('CALENDARIO_LEER'))
            ->with('editar', Session::get('CALENDARIO_EDITAR'))
            ->with('imprimir', Session::get('CALENDARIO_IMPRIMIR'))
            ->with('eliminar', Session::get('CALENDARIO_ELIMINAR'));
    }

    public function postObtenerferiados() 
    {
        $organizacion_id = Input::get('organizacion');
        $ciclo_id = Input::get('cboCiclos');
        $feriados = [];

		$ciclos = [];
        $arrOrganizaciones = Organizacion::lists('nombre', 'id');
        array_unshift($arrOrganizaciones, 'Seleccionar');

        if (!$ciclo_id == '') {
        	$feriado = Feriados::whereRaw('organizacion_id ='.$organizacion_id.' AND ciclolectivo_id ='.$ciclo_id)->get();

	        if (count($feriado) > 0) {
	        	foreach ($feriado as $value) {
	        		$fecha = FechaHelper::getFechaImpresion($value->fecha_feriado);
	        		$ciclo = CicloLectivo::find($ciclo_id)->descripcion;

	        		$feriados[] = ['id' => $value->id, 'ciclo' => $ciclo, 'fecha' => $fecha, 'descripcion' => $value->descripcion];
	        	}
	        }
	        $arrOrganizaciones = Organizacion::lists('nombre', 'id');
	        $ciclos = CicloLectivo::all();
        }
        
        return View::make('feriados/listado')
            ->with('arrOrganizaciones', $arrOrganizaciones)
            ->with('organizacion_id', $organizacion_id)
            ->with('ciclos', $ciclos)
            ->with('ciclo_id', $ciclo_id)
            ->with('feriados', $feriados)
            ->with('menu', ModulosHelper::MENU_GESTION_ADMINISTRATIVA)
            ->with('submenu', ModulosHelper::SUBMENU_CALENDARIOS)
            ->with('submenu2', ModulosHelper::SUBMENU_2_FERIADOS)
            ->with('leer', Session::get('CALENDARIO_LEER'))
            ->with('editar', Session::get('CALENDARIO_EDITAR'))
            ->with('imprimir', Session::get('CALENDARIO_IMPRIMIR'))
            ->with('eliminar', Session::get('CALENDARIO_ELIMINAR'));
    }

    public function getEditar($idaseguir)
    {  
        $feriados = Feriados::find($idaseguir);
        $fecha_feriado = FechaHelper::getFechaImpresion($feriados->fecha_feriado);
        $porcion = explode("/", $fecha_feriado);
        $fecha = $porcion[2].'-'.$porcion[1].'-'.$porcion[0];

        $ciclo_id = $feriados->ciclolectivo_id;
        $descripcion = $feriados->descripcion;
        $organizacionid = $feriados->organizacion_id;

        $habilita = false;
        $arrOrganizaciones = Organizacion::lists('nombre', 'id');
        $ciclos = CicloLectivo::all();
        
        return View::make('feriados.editar',[
            'arrOrganizaciones'  	=> $arrOrganizaciones,
            'organizacionid'  		=> $organizacionid,
            'ciclos'        		=> $ciclos,
            'ciclo_id'        		=> $ciclo_id,
            'fecha'        			=> $fecha,
            'descripcion'        	=> $descripcion,
            'idferiados'        	=> $idaseguir,
            'habilita' 				=> $habilita
        ])->with('menu', ModulosHelper::MENU_GESTION_ADMINISTRATIVA)
            ->with('submenu', ModulosHelper::SUBMENU_CALENDARIOS)
            ->with('submenu2', ModulosHelper::SUBMENU_2_FERIADOS)
            ->with('leer', Session::get('CALENDARIO_LEER'))
            ->with('editar', Session::get('CALENDARIO_EDITAR'))
            ->with('imprimir', Session::get('CALENDARIO_IMPRIMIR'))
            ->with('eliminar', Session::get('CALENDARIO_ELIMINAR'));
    }

    public function postGuardar()
    {   
    	$validator = Validator::make(
            array(
                'organizacion'      => Input::get('organizacion'),
                'cboCiclos'         => Input::get('cboCiclos'),
                'fechaferiado'     	=> Input::get('fechaferiado'),
                'descripcion'      	=> Input::get('descripcion')
            ),
            array(
                'organizacion'      => 'required',
                'cboCiclos'         => 'required',
                'fechaferiado'     	=> 'required',
                'descripcion'      	=> 'required'
            ),
            array(
                'required' 		=> 'Campo Obligatorio',
                'required' 		=> 'Campo Obligatorio',
                'required' 		=> 'Campo Obligatorio',
                'required' 		=> 'Campo Obligatorio'
            )
        );

        $organizacion_id = Input::get('organizacion');
        $cboCiclos = Input::get('cboCiclos');
        $descripcion = Input::get('descripcion');
        $fechaferiado = Input::get('fechaferiado');
        $txtFeriadoId = Input::get('txtFeriadoId');

    	if ($validator->fails()) {
            Session::flash('message', 'ERROR AL INTENTAR GUARDAR EL FERIADO.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('feriados/crear')
                ->withErrors($validator)
                ->withInput();
        } else {
    		if ($txtFeriadoId == '') {
    			$feriado = Feriados::whereRaw('organizacion_id ='.$organizacion_id.' AND ciclolectivo_id ='.$cboCiclos.' AND fecha_feriado ="'.$fechaferiado.'"')->get();

	        	if (count($feriado) > 0) {
	        		Session::flash('message', 'ERROR AL INTENTAR GUARDAR, YA EXISTE EL FERIADO QUE INTENTA GUARDAR.');
		            Session::flash('message_type', self::OPERACION_FALLIDA);
		            return Redirect::to('feriados/crear')
		                ->withErrors($validator)
		                ->withInput();
	        	} else {
	    			$feriados = new Feriados();

	                $feriados->organizacion_id  = $organizacion_id;
	                $feriados->ciclolectivo_id  = $cboCiclos;
	                $feriados->descripcion      = $descripcion;
	                $feriados->fecha_feriado    = $fechaferiado;
	                $feriados->usuario_alta    	= Auth::user()->usuario;  
	                $feriados->fecha_alta      	= date('Y-m-d');
	                
	                $feriados->save();

                    $feriado = Feriados::all();
                    $feriadolast = $feriado->last();

	                $txtFeriadoId = $feriadolast->id;
	            }
    		} else {
    			$feriados = Feriados::find($txtFeriadoId);

                $feriados->organizacion_id  = $organizacion_id;
                $feriados->ciclolectivo_id  = $cboCiclos;
                $feriados->descripcion      = $descripcion;
                $feriados->fecha_feriado    = $fechaferiado;
                $feriados->usuario_modi    	= Auth::user()->usuario;  
                $feriados->fecha_modi      	= date('Y-m-d');
                
                $feriados->save();
    		}

            Session::flash('message', 'LOS DATOS SE CARGARON CORRECTAMENTE!');
            Session::flash('message_type', self::OPERACION_EXITOSA);
            return Redirect::to('feriados/editar/'.$txtFeriadoId);
        }
    }

    public function postBorrar()
    {
        $id = Input::get('idCicloHidden');

        $feriados = Feriados::find($id);
        $feriados->delete();

        Session::flash('message', 'EL FERIADO FUE BORRADO.');
        Session::flash('message_type', self::OPERACION_EXITOSA);
        return Redirect::to('feriados/listado');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
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
