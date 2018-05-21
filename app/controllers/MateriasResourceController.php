<?php

class MateriasResourceController extends \BaseController {
    const OPERACION_EXITOSA = 1;
    const OPERACION_FALLIDA = 2;
    const OPERACION_CANCELADA = 3;
    const OPERACION_INFO = 4;
	/**
	 * Lista completa de todas las materias 
	 * Se puede filtrar por Carrera y no me acuerdo que más
	 * @return Response
	 * @author Diego Maximiliano  
	 */

	public function index()
	{
		$httpCode = 200;
		$param = Input::only('carrera', 'plan');

		try {	
			$materias = Materia::whereRaw('carrera_id ='. $param['carrera']. ' and planestudio_id = ' .$param['plan'])->get();
		} catch(Exception $e) {
			$httpCode = 404;  
			$materias = ['status' => '400'];
		} finally {
			return Response::json($materias, $httpCode);
		}
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('materias.nuevo');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$data = Input::all();
		$messages = [
			'required'         => 'Este campo es obligatorio',
			'required|integer' => 'Debe ingresar un numero'
		];
		$validator = Validator::make($data, [
			'carrera'     		=> 'required|integer',
			'materia'  			=> 'required',
			'plan' 				=> 'required|integer',
			'hsSemanales'    	=> 'required',
			'hsCatedras'      	=> 'required',
			'hsReloj'      		=> 'required',
			'aniocursado'    	=> 'required|integer',
			'cuatrimestre'    	=> 'required|integer'
		], $messages);


		if ($validator->fails()) {
            Session::flash('message', 'ERROR AL INTENTAR CREAR UNA MATERIA.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('materias/crear')
                ->withErrors($validator)
                ->withInput();
		}

		$ciclolectivo_id = Input::get('cboCiclos');

		$existe = Materia::where('planestudio_id', '=',$data['plan'])->where('nombremateria', '=',$data['materia'])->first();


		if ($existe) {
            Session::flash('message', 'LA MATERIA QUE QUIERE CREAR YA EXISTE EN ESTE PLAN DE ESTUDIO.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('materias/crear')
                ->withErrors($validator)
                ->withInput();
		}

		$materia = new Materia();
		$materia->carrera_id      = $data['carrera'];
		$materia->nombremateria   = $data['materia'];
		$materia->planestudio_id  = $data['plan'];
		$materia->periodo         = $data['periodo'];
		$materia->hssemanales     = $data['hsSemanales'];
		$materia->hsreloj         = $data['hsReloj'];
		$materia->hscatedra       = $data['hsCatedras'];
		$materia->aniocursado     = $data['aniocursado'];
		//$materia->promocional     = (Input::get('promocional')) ? 1 : 0;
		if ($data['periodo'] == 'Cuatrimestral') {$materia->cuatrimestre  = $data['cuatrimestre'];}
		$materia->usuario_alta    = Auth::user()->usuario;
		$materia->fecha_alta      = date('Y-m-d');

	   	if ($materia->save()) {
	        $materia = Materia::all();
	        $ultimamateria = $materia->last();
	        $materia_id = $ultimamateria->id;

	   		$promocionregular = new RegularPromocion();
			$promocionregular->carrera_id      = $data['carrera'];
			$promocionregular->materia_id	   = $materia_id;
			$promocionregular->planestudio_id  = $data['plan'];
			$promocionregular->ciclolectivo_id = $ciclolectivo_id;
			$promocionregular->promocional     = (Input::get('promocional')) ? 1 : 0;
			$promocionregular->usuario_alta		= Auth::user()->usuario;
			$promocionregular->fecha_alta  		= date('Y-m-d');
			$promocionregular->save();

            Session::flash('message', 'MATERIA GUARDADA CORRECTAMENTE.');
            Session::flash('message_type', self::OPERACION_EXITOSA);
            return Redirect::to('materias/crear');
		} else {
            Session::flash('message', 'NO SE PUDO GUARDAR LA MATERIA.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('materias/crear');
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
		return Response::json(Materia::find($id));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$materia = Materia::find($id);	
		return View::make('materias.editar')->with($materia);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$data = Input::all();
		
		$messages = [
			'required'         => 'Este campo es obligatorio',
			'required|integer' => 'Debe ingresar un numero'
		];

		$validator = Validator::make($data, [
			'carrera'     	=> 'required|integer',
			'materia'  		=> 'required',
			'plan' 			=> 'required|integer',
			'hsSemanales'   => 'required',
			'hsCatedras'    => 'required',
			'hsReloj'      	=> 'required',
			'aniocursado'   => 'required|integer',
			'cuatrimestre'  => 'required|integer'
		], $messages);

		$messages = [
			'required'         => 'Este campo es obligatorio',
			'required|integer' => 'Debe ingresar un numero'
		];

		if ($validator->fails()) {
			Session::flash('message', 'ERROR AL INTENTAR EDITAR LA MATERIA.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('materias/editar/'.$id)
                ->withErrors($validator)
                ->withInput();
		}

		$ciclolectivo_id = Input::get('cboCiclos');
		
		$existe = Materia::where('planestudio_id', '=',$data['plan'])->where('nombremateria', '=',$data['materia'])->where('id', '<>', $id)->first();


		if ($existe) {
            Session::flash('message', 'LA MATERIA QUE QUIERE CREAR YA EXISTE EN ESTE PLAN DE ESTUDIO.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('materias/editar/'.$id)
                ->withErrors($validator)
                ->withInput();
		}



		$materia = Materia::find($id);	
		$materia->carrera_id      = $data['carrera'];
		$materia->nombremateria   = $data['materia'];
		$materia->planestudio_id  = $data['plan'];
		$materia->periodo         = $data['periodo'];
		$materia->hssemanales     = $data['hsSemanales'];
		$materia->hsreloj         = $data['hsReloj'];
		$materia->hscatedra       = $data['hsCatedras'];
		$materia->aniocursado     = $data['aniocursado'];
		//$materia->promocional     = (Input::get('promocional')) ? 1 : 0;
		if ($data['periodo'] == 'Cuatrimestral') {$materia->cuatrimestre  = $data['cuatrimestre'];}
		$materia->usuario_modi   = Auth::user()->usuario;
		$materia->fecha_modi      = date('Y-m-d');

		if ($materia->save()) {
			$promo_regular = RegularPromocion::whereRaw('materia_id ='.$id.' AND carrera_id ='.$data['carrera'].' AND planestudio_id ='.$data['plan'].' AND ciclolectivo_id ='.$ciclolectivo_id)->first();

			if (count($promo_regular) > 0) {
				$promo_regular->promocional 	= (Input::get('promocional')) ? 1 : 0;
				$promo_regular->usuario_modi   = Auth::user()->usuario;
				$promo_regular->fecha_modi     = date('Y-m-d');
				$promo_regular->save();
			} else {
				$promocionregular = new RegularPromocion();
				$promocionregular->carrera_id      = $data['carrera'];
				$promocionregular->materia_id	   = $id;
				$promocionregular->planestudio_id  = $data['plan'];
				$promocionregular->ciclolectivo_id = $ciclolectivo_id;
				$promocionregular->promocional     = (Input::get('promocional')) ? 1 : 0;
				$promocionregular->usuario_alta		= Auth::user()->usuario;
				$promocionregular->fecha_alta  		= date('Y-m-d');
				$promocionregular->save();
			}
			
            Session::flash('message', 'MATERIA ACTUALIZADA CORRECTAMENTE.');
            Session::flash('message_type', self::OPERACION_EXITOSA);
            return Redirect::to('materias/editar/'.$id);
		} else {
            Session::flash('message', 'ERROR AL INTENTAR ACTUALIZAR LA MATERIA.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('materias/editar/'.$id);
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
		$materia = Materia::find($id);
		if ($materia->delete()) {
			return Response::json(['status' => 200, 'message' => 'deleted'], 200);
		} else {
			return Response::json(['status' => 500, 'message' => 'error'], 500);
		}
	}


}
