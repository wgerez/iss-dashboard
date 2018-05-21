<?php
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PlanestudioresourceController extends \BaseController {

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
		$this->_data = array(
            'organizacion'  => Input::get('organizacion'),
            'carrera'       => Input::get('carrera'),
            'ciclos'        => Input::get('ciclos'),
            'codigoplan'    => Input::get('codigoplan'),
            'tituloplan'    => Input::get('tituloplan'),
            'fechaInicio'   => Input::get('fechaInicio'),
            'fechaFin'   	=> Input::get('fechaFin')
        );

        $this->_rules = array(
            'organizacion'    => 'required',
            'carrera'  => 'required',
            'ciclos' => 'required',
            'codigoplan' => 'required',
            'tituloplan' => 'required',
            'fechaInicio' => 'required'
        );

        $validator = Validator::make($this->_data, $this->_rules);

        if ($validator->fails()) {
            return Response::json([
            	'status' => false], 404
            );
        } else {
        	$fechafin = Input::get('fechaFin');
        	$fechainicio = FechaHelper::getFechaParaGuardar(Input::get('fechaInicio'));
        	
        	if (!$fechafin = null) $fechafin = FechaHelper::getFechaParaGuardar($fechafin);

            $planestudio = new PlanEstudio();
            $planestudio->carrera_id     	= Input::get('carrera');
            $planestudio->codigoplan     	= Input::get('codigoplan');
            $planestudio->ciclolectivo_id  	= Input::get('ciclos');
            $planestudio->tituloplan  		= Input::get('tituloplan');
            $planestudio->nroresolucion     = Input::get('nroresolucion');
            $planestudio->fechainicio  		= $fechainicio;
            $planestudio->fechafin  		= $fechafin;
            $planestudio->usuario_alta      = Auth::user()->usuario;
            $planestudio->fecha_alta        = date('Y-m-d');
            
            if ($planestudio->save()) {
                return Response::json([
                    'status' => true], 200
                );                
            }
            else
            {
                return Response::json([
                'status' => false], 404
                );
            } 
        }
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $planes = PlanEstudio::whereRaw('carrera_id ='. $id)->get();

        if ($planes->count()!= 0) {
            $i = 0;
            foreach ($planes as $plan) {
                $ciclo = $plan->ciclolectivo->descripcion;
                $carrera = $plan->carrera->carrera;
                $fechafin = $plan->fechafin;

                if ($fechafin == null) {
                  $fechafin = "S/D";  
                } 
                else
                {
                  $fechafin =  FechaHelper::getFechaImpresion($fechafin); 
                }

                $planestudios[$i] = ['id'=>$plan['id'], 'ciclo'=>$ciclo, 'carrera'=>$carrera, 'codigoplan'=>$plan['codigoplan'], 
                                    'tituloplan'=>$plan['tituloplan'], 'fechainicio'=>FechaHelper::getFechaImpresion($plan['fechainicio']), 'fechafin'=>$fechafin];
                $i++;
            }

            return Response::json($planestudios);
        }
        else
        {
            return Response::json($planes);
        }
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
	public function update()
	{
        $id = Input::get('planid');


		$this->_data = array(
            'carrera'       => Input::get('carrera'),
            'ciclo'         => Input::get('ciclo'),
            'codigoplan'    => Input::get('codigoplan'),
            'tituloplan'    => Input::get('tituloplan'),
            'fechaInicio'   => Input::get('fechaInicio')
        );

        $this->_rules = array(
            'carrera'       => 'required',
            'ciclo'         => 'required',
            'codigoplan'    => 'required',
            'tituloplan'    => 'required',
            'fechaInicio'   => 'required'
        );

        $this->_messages = array(
            'required' => 'Campo Obligatorio',
        );

        $validator = Validator::make($this->_data, $this->_rules, $this->_messages);

        if ($validator->fails()) {
            Session::flash('message', 'ERROR AL INTENTAR MODIFICAR LOS DATOS DEL PLAN.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('planestudios/editar/' . $id)
                ->withErrors($validator)
                ->withInput();
        } else {
        	$fechainicio = FechaHelper::getFechaParaGuardar(Input::get('fechaInicio'));
            $fechafin = Input::get('fechaFin');

        	if (Input::get('fechaFin')) {
                $fechafin = FechaHelper::getFechaParaGuardar($fechafin);
            }
            else
            {
                $fechafin = null;
            }


            $planestudio = PlanEstudio::find($id);
            $planestudio->carrera_id     	= Input::get('carrera');
            $planestudio->codigoplan     	= Input::get('codigoplan');
            $planestudio->ciclolectivo_id  	= Input::get('ciclo');
            $planestudio->tituloplan  		= Input::get('tituloplan');
            $planestudio->nroresolucion     = Input::get('nroresolucion');
            $planestudio->fechainicio  		= $fechainicio;
            $planestudio->fechafin  		= $fechafin;
            $planestudio->usuario_modi      = Auth::user()->usuario;
            $planestudio->fecha_modi        = date('Y-m-d');


            if ($planestudio->save()) {
                Session::flash('message', 'LOS DATOS DEL PLAN DE ESTUDIOS SE GUARDO CORRECTAMENTE.');
                Session::flash('message_type', self::OPERACION_EXITOSA);
                return Redirect::to('planestudios/editar/' . $id);
            }
            else
            {
                Session::flash('message', 'AL PARECER HUBO UN PROBLEMA AL GUARDAR LOS DATOS.');
                Session::flash('message_type', self::OPERACION_FALLIDA);
                return Redirect::to('planestudios/editar/' . $id);
            } 
        }
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$planestudios = PlanEstudio::findOrFail($id);
        highlight_string(var_export($planestudios,true));
        exit();
		$planestudios->materias()->delete();
        $planestudios->delete();

        Session::flash('message', 'EL PLAN DE ESTUDIO HA SIDO BORRADO.');
        Session::flash('message_type', self::OPERACION_EXITOSA);
        return Redirect::to('planestudios/listado');
	}


}
