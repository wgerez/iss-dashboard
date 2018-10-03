<?php
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PlanestudiosController extends \BaseController {

	private $_data;
    private $_rules;
    private $_messages;

    const OPERACION_EXITOSA = 1;
    const OPERACION_FALLIDA = 2;
    const OPERACION_CANCELADA = 3;
    const OPERACION_INFO = 4;

    const NO_TIENE_CARRERAS = 0;
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
    {
        return Redirect::to('planestudios/listado');
    }

    public function getListado()
    {

        $organizaciones = Organizacion::lists('nombre', 'id');

        array_unshift($organizaciones, 'Seleccionar');

        //array_unshift($organizaciones, 'Seleccionar');

    	return View::make('planestudios/listado')
            ->with('organizaciones', $organizaciones)
            ->with('menu', ModulosHelper::MENU_GESTION_ADMINISTRATIVA)
            ->with('submenu', ModulosHelper::SUBMENU_PLAN_ESTUDIOS)
            ->with('leer', Session::get('PLANESTUDIO_LEER'))
            ->with('editar', Session::get('PLANESTUDIO_EDITAR'))
            ->with('imprimir', Session::get('PLANESTUDIO_IMPRIMIR'))
            ->with('eliminar', Session::get('PLANESTUDIO_ELIMINAR'));          		
    }

    public function postObtenerlistado() 
    {
        $carrera = Input::get('carrera');
        $orgid = Input::get('organizacion');
        $planID = Input::get('plan');

        if (!$orgid == '') {
            $organizaciones = Organizacion::lists('nombre', 'id');

            $carreras = Carrera::where('organizacion_id', '=', $orgid)->get();

            $planestudios = PlanEstudio::whereRaw('carrera_id= '. $carrera)->get();

            foreach ($planestudios as $planestudio) {
                $fechamostrar = FechaHelper::getFechaImpresion($planestudio->fechainicio);
                $planestudio->fechainicio = $fechamostrar;
                $fechamostrar = FechaHelper::getFechaImpresion($planestudio->fechafin);
                $planestudio->fechafin = $fechamostrar;
                $materias = Materia::whereRaw('planestudio_id = '. $planestudio->id)->get();

                if (count($materias) > 0) {
                    $planestudio->materia = 'true';
                } else {
                    $planestudio->materia = 'false';
                }
            }
        } else {
            $carreras = [];
            $planestudios = [];
            $organizaciones = Organizacion::lists('nombre', 'id');
            array_unshift($organizaciones, 'Seleccionar');
        }

        /*$carrid = Input::get('carrera');
        $orgid = Input::get('organizacion');
        $planID = Input::get('plan');

        $materias = Materia::whereRaw('carrera_id= '. $carrid .' AND planestudio_id= '. $planID)->get();

        foreach ($materias as $value) {
            $planestudio = PlanEstudio::whereRaw('id= '.$value->planestudio_id)->first();
            
            $value->codigoplan = $planestudio->codigoplan;
            $value->ciclolectivo = $planestudio->ciclolectivo->descripcion;
            $value->idplan = $planestudio->id;
        }*/

        return View::make('planestudios/listado')
            ->with('organizaciones', $organizaciones)
            ->with('planestudios', $planestudios)
            ->with('carrID', $carrera)
            ->with('OrgID', $orgid)
            ->with('carreras', $carreras)
            ->with('menu', ModulosHelper::MENU_GESTION_ADMINISTRATIVA)
            ->with('submenu', ModulosHelper::SUBMENU_PLAN_ESTUDIOS)
            ->with('leer', Session::get('PLANESTUDIO_LEER'))
            ->with('editar', Session::get('PLANESTUDIO_EDITAR'))
            ->with('imprimir', Session::get('PLANESTUDIO_IMPRIMIR'))
            ->with('eliminar', Session::get('PLANESTUDIO_ELIMINAR'));
    }

    public function getListadoplanes()
    {
        $carrera = Input::get('carrera');
        $orgid = Input::get('organizacion');
        $planID = Input::get('plan');

        $organizaciones = Organizacion::lists('nombre', 'id');

        //array_unshift($organizaciones, 'Seleccionar');
        $carreras = Carrera::where('organizacion_id', '=', 1)->get();

        $planestudios = PlanEstudio::whereRaw('carrera_id= '. $carrera)->get();

        foreach ($planestudios as $planestudio) {
            $fechamostrar = FechaHelper::getFechaImpresion($planestudio->fechainicio);
            $planestudio->fechainicio = $fechamostrar;
            $fechamostrar = FechaHelper::getFechaImpresion($planestudio->fechafin);
            $planestudio->fechafin = $fechamostrar;
        }

        return View::make('planestudios/listadoplanes')
            ->with('organizaciones', $organizaciones)
            ->with('planestudios', $planestudios)
            ->with('carrID', $carrera)
            ->with('carreras', $carreras)
            ->with('OrgID', $orgid)
            ->with('menu', ModulosHelper::MENU_GESTION_ADMINISTRATIVA)
            ->with('submenu', ModulosHelper::SUBMENU_PLAN_ESTUDIOS)
            ->with('leer', Session::get('PLANESTUDIO_LEER'))
            ->with('editar', Session::get('PLANESTUDIO_EDITAR'))
            ->with('imprimir', Session::get('PLANESTUDIO_IMPRIMIR'))
            ->with('eliminar', Session::get('PLANESTUDIO_ELIMINAR'));
    }    

    public function getEditar($id) {

        $planestudios   = PlanEstudio::find($id);
        $ciclos         = CicloLectivo::lists('descripcion', 'id');
        $carreras       = CarrerasController::ObtenerCarrerasParaSelect(1);

        $fechainicio = FechaHelper::getFechaImpresion($planestudios->fechainicio);

        if ($planestudios->fechafin == '0000-00-00 00:00:00') {
            $fechafin = '';
        } else {
            $fechafin = FechaHelper::getFechaImpresion($planestudios->fechafin);
        }

        //return $planestudios;
        //exit();

        return View::make('planestudios/editar', [
                    'planestudios'      => $planestudios,
                    'ciclos'            => $ciclos,
                    'fechainicio'       => $fechainicio,
                    'fechafin'          => $fechafin,
                    'carreras'          => $carreras
                ])
                ->with('menu', ModulosHelper::MENU_GESTION_ADMINISTRATIVA)
                ->with('submenu', ModulosHelper::SUBMENU_PLAN_ESTUDIOS)
                ->with('leer', Session::get('PLANESTUDIO_LEER'))
                ->with('editar', Session::get('PLANESTUDIO_EDITAR'))
                ->with('imprimir', Session::get('PLANESTUDIO_IMPRIMIR'))
                ->with('eliminar', Session::get('PLANESTUDIO_ELIMINAR'));    
    }

	public function postObtenercarreras()
    {
        $id = Input::get('organizacion_id');
        $carreras = Carrera::where('organizacion_id', '=', $id)->get();
        
        if (count($carreras) == 0)
            return self::NO_TIENE_CARRERAS;

        return Response::json($carreras);
    }


    public function postObtenerplanes()
    {
        $carrera = Input::get('carrera');

        $planes = PlanEstudio::whereRaw('carrera_id=' . $carrera)->get();

        if (count($planes) == 0)
            return self::NO_TIENE_CARRERAS;

		return Response::json($planes);
        $materias = Materia::whereRaw('carrera_id=' . $carrera)->get();

        $i = 0;
        foreach ($materias as $materia) {
          $planes = PlanEstudio::whereRaw('id=' . $materia['planestudio_id'])->get();
          foreach ($planes as $plan) {
            $ciclo = $plan->ciclolectivo->descripcion;
          }
          $nombremateria = $materia->nombremateria;
          $aniocursado = $materia->aniocursado;
          $periodo = $materia->periodo;

          $planestudios[$i] = ['codigo'=>$materia['planestudio_id'], 'ciclo'=>$ciclo, 'aniocursado'=>$aniocursado, 'nombremateria'=>$nombremateria, 'periodo'=>$periodo];
          $i++;
        }

        return Response::json($planestudios);
    }

    public function getCrear()
    {
        $organizaciones = Organizacion::lists('nombre', 'id');
        $carreras       = Carrera::lists('carrera', 'id');

        $ciclos         = CicloLectivo::lists('descripcion', 'id');


        array_unshift($organizaciones, 'Seleccionar');
        array_unshift($carreras, 'Seleccionar');
        //array_unshift($ciclos, 'Seleccionar');

      return View::make('planestudios/nuevo',[
          'carreras'          => $carreras,
          'organizaciones' => $organizaciones,
          'ciclos'            => $ciclos
        ])
        ->with('menu', ModulosHelper::MENU_GESTION_ADMINISTRATIVA)
        ->with('submenu', ModulosHelper::SUBMENU_PLAN_ESTUDIOS)
        ->with('leer', Session::get('PLANESTUDIO_LEER'))
        ->with('editar', Session::get('PLANESTUDIO_EDITAR'))
        ->with('imprimir', Session::get('PLANESTUDIO_IMPRIMIR'))
        ->with('eliminar', Session::get('PLANESTUDIO_ELIMINAR'));             
    }

    public function postObtenerplanestudios()
    {
        $ciclo = Input::get('ciclo');
        $carrera = Input::get('carrera');

        $carreras = Carrera::find($carrera);
        $ncarrera = $carreras->carrera;
        $porcion = explode(" ", $ncarrera);
        $resultado = '';
        $resultado2 = '';

        for ($i=0; $i < count($porcion); $i++) { 
            $primer = substr($porcion[$i], 0, 1);
            $resultado .= $primer;
        }

        $ciclos = CicloLectivo::find($ciclo);
        $nciclo = $ciclos->descripcion;

        $resultado2 .= $resultado .'/'. $nciclo;

        $planes[] = ['codigoplan' => $resultado2, 'tituloplan' => $ncarrera];

        /*highlight_string(var_export($resultado2,true));
        exit();*/

        return Response::json($planes);
    }

    public function postGuardar()
    {
        $this->_data = array(
            'organizacion'  => Input::get('organizacion'),
            'carrera'       => Input::get('carrera'),
            'ciclos'        => Input::get('ciclos'),
            'codigoplan'    => Input::get('codigoplan1'),
            'tituloplan'    => Input::get('tituloplan'),
            'fechaInicio'   => Input::get('fechaInicio'),
            'fechaFin'      => Input::get('fechaFin')
        );

        $this->_rules = array(
            'organizacion'      => 'required',
            'carrera'           => 'required',
            'ciclos'            => 'required',
            'codigoplan'        => 'required',
            'tituloplan'        => 'required',
            'fechaInicio'       => 'required'
        );

        $this->_messages = array(
            'required' => 'Campo Obligatorio',
        );

        $validator = Validator::make($this->_data, $this->_rules, $this->_messages);

        if ($validator->fails()) {
            Session::flash('message', 'ERROR AL INTENTAR GUARDAR EL PLAN DE ESTUDIO.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('planestudios/crear')
                ->withErrors($validator)
                ->withInput();
        } else {
            $carrera = Input::get('carrera');
            $ciclos = Input::get('ciclos');
            $planestudios = PlanEstudio::whereRaw('carrera_id= '.$carrera. ' AND ciclolectivo_id= '.$ciclos)->first();

            if (count($planestudios) > 0) {
                Session::flash('message', 'ERROR, EL PLAN DE ESTUDIO YA EXISTE!');
                Session::flash('message_type', self::OPERACION_FALLIDA);
                return Redirect::to('planestudios/crear')
                    ->withErrors($validator)
                    ->withInput();
            }

            $fechafin = Input::get('fechaFin');
            $fechainicio = FechaHelper::getFechaParaGuardar(Input::get('fechaInicio'));
            
            if ($fechafin) $fechafin = FechaHelper::getFechaParaGuardar($fechafin);

            $planestudio = new PlanEstudio();
            $planestudio->carrera_id        = Input::get('carrera');
            $planestudio->codigoplan        = Input::get('codigoplan1');
            $planestudio->ciclolectivo_id   = Input::get('ciclos');
            $planestudio->tituloplan        = Input::get('tituloplan');
            $planestudio->nroresolucion     = Input::get('nroresolucion');
            $planestudio->fechainicio       = $fechainicio;
            $planestudio->fechafin          = $fechafin;
            $planestudio->usuario_alta      = Auth::user()->usuario;
            $planestudio->fecha_alta        = date('Y-m-d');
            
            $planestudio->save();


            $plan = PlanEstudio::all();
            $ultimoplan = $plan->last();
            $idplan = $ultimoplan->id;

            Session::flash('message', 'PLAN DE ESTUDIO CREADO CON ÉXITO!');
            Session::flash('message_type', self::OPERACION_EXITOSA);
            return Redirect::to('planestudios/editar/'.$idplan);
        }
    }

    public function getImprimirplan()/*PDF*/
    {
        $planestudio_id = Input::get('plan');
        
        $planestudio = PlanEstudio::find($planestudio_id);
        $materias = Materia::whereRaw('planestudio_id = '. $planestudio_id)->get();
        $anocursa = 1;
        $cantidad = 0;

        foreach ($materias as $materia) {
            if ($materia->aniocursado > $anocursa) {
                $cantidad = $materia->aniocursado;
            }

            if ($materia->aniocursado == $anocursa) {
                if ($materia->aniocursado > $cantidad) {
                    $cantidad = $materia->aniocursado;
                }
            }
        }

        $cantidad = $cantidad + 1;
/*highlight_string(var_export($materias,true));
        exit;*/
        $pdf = PDF::loadView('informes.pdf.materiasplandeestudio', [
            'planestudio'   =>  $planestudio,
            'materias'      =>  $materias,
            'cantidad'      =>  $cantidad]);
        return $pdf->setOrientation('landscape')->stream();
    }  

    public function postBorrar()
    {
        $id = Input::get('idPlanHidden');

        $planestudios = PlanEstudio::findOrFail($id);

        if ($planestudios->materias) {
            Session::flash('message', 'ERROR, AL INTENTAR BORRAR EL PLAN DE ESTUDIO!');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('planestudios/listado');
        } else {
            $planestudios->materias()->delete();
            $planestudios->delete();

            Session::flash('message', 'EL PLAN DE ESTUDIO HA SIDO BORRADO.');
            Session::flash('message_type', self::OPERACION_EXITOSA);
            return Redirect::to('planestudios/listado');
        }
    }

    public function postBuscarjson()
    {
        $idCarrera = (int)Input::get('carreraid');

        $result = PlanEstudio::where('carrera_id','=', $idCarrera)
                    //->select('id', 'carrera')
                    ->get();

        //highlight_string(var_export($result,true));
        //exit;

        return Response::json($result);
    }

    public static function ObtenerPlanesParaSelect($id) 
    {
        $planes = PlanEstudio::where('carrera_id', '=', $id)->lists('codigoplan', 'id');
        
        return $planes;        
    }

    public function postObtenerciclo()
    {
        $plan = Input::get('plan');

        $planes = PlanEstudio::find($plan)->ciclolectivo_id;

        return Response::json($planes);
    }

}
