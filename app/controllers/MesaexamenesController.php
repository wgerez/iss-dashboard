<?php

class MesaexamenesController extends \BaseController {

   private $_data;
    private $_rules;
    private $_messages;

    const OPERACION_EXITOSA = 1;
    const OPERACION_FALLIDA = 2;
    const OPERACION_CANCELADA = 3;
    const OPERACION_INFO = 4;
    const NO_EXISTE_MESAEXAMEN = 5;

	public function getIndex()
    {
        return Redirect::to('mesaexamenes/listado');
    }

    public function getListado()
    {
        $organizaciones = Organizacion::lists('nombre', 'id');

        $turnos = TurnoExamen::all();

        if (count($turnos) > 0) {
            $turno_id = $turnos[0]->id;
        } else {
            $turno_id = '';
            $turnos = [];
        }
        
        array_unshift($organizaciones, 'Seleccione');

    	return View::make('mesaexamenes.listado')
    		->with('organizaciones', $organizaciones)
    		->with('turnos', $turnos)
    		->with('turno_id', $turno_id)
            ->with('menu', ModulosHelper::MENU_GESTION_ADMINISTRATIVA)
            ->with('submenu', ModulosHelper::SUBMENU_CALENDARIOS)
            ->with('submenu2', ModulosHelper::SUBMENU_2_MESAEXAMENES)
            ->with('leer', Session::get('CALENDARIO_LEER'))
            ->with('editar', Session::get('CALENDARIO_EDITAR'))
            ->with('imprimir', Session::get('CALENDARIO_IMPRIMIR'))
            ->with('eliminar', Session::get('CALENDARIO_ELIMINAR'));   
    }


    public function postObtenermesas() 
    {
    	$mesas = [];

    	$org_id   = Input::get('organizacion');
    	$carr_id  = Input::get('carrera');
        $filtro   = Input::get('cboFiltro');
        $opcion_id = Input::get('opcion');
        $ciclo_id = Input::get('ciclos');
        $turno_id = Input::get('turnos');
        $opcion = array();

       	if ($filtro == 1) {
       		$mesaexamenes = MesaExamen::where('ciclolectivo_id','=', $ciclo_id)->where('turnoexamen_id', '=', $turno_id)->where('organizacion_id','=', $org_id)->where('carrera_id','=', $carr_id)->get();

       		foreach ($mesaexamenes as $mesaexamen) {
       			$tribunal = '';
       			$docentes = TribunalDocente::where('mesaexamen_id', '=', $mesaexamen->id)->get();

       			foreach ($docentes as $docente) {
       				if ($tribunal == ''){
       					$tribunal = $tribunal .'' . $docente->docente->persona->apellido .' ' . $docente->docente->persona->nombre;
       				} else {
       					$tribunal = $tribunal .' - ' . $docente->docente->persona->apellido .' ' . $docente->docente->persona->nombre;
       				}

       			}
				
       			$mesaexamen->fechaprimerllamado = FechaHelper::getFechaImpresion($mesaexamen->fechaprimerllamado);

       			if ($mesaexamen->fechasegundollamado == '0000-00-00 00:00:00'){
       				$mesaexamen->fechasegundollamado = '';
       			} else {
       				$mesaexamen->fechasegundollamado = FechaHelper::getFechaImpresion($mesaexamen->fechasegundollamado);
       			}

				$mesas [] = ['id' => $mesaexamen->id, 'materia' => $mesaexamen->materia->nombremateria .' - '. $mesaexamen->materia->planestudio->codigoplan, 'fechaprimerllamado' => $mesaexamen->fechaprimerllamado, 'horaprimerllamado' => $mesaexamen->horaprimerllamado,'fechasegundollamado' => $mesaexamen->fechasegundollamado, 'horasegundollamado' => $mesaexamen->horasegundollamado, 'tribunal' => $tribunal];
			}

       	} else if ($filtro == 2) {

	        $mesaexamenes = MesaExamen::where('ciclolectivo_id','=', $ciclo_id)->where('turnoexamen_id', '=', $turno_id)->where('organizacion_id','=', $org_id)->where('carrera_id','=', $carr_id)->where('materia_id','=', $opcion_id)->get();

	        if($mesaexamenes){
       			foreach ($mesaexamenes as $mesaexamen) {
					$tribunal = '';
	       			$docentes = TribunalDocente::where('mesaexamen_id', '=', $mesaexamen->id)->get();

	       			foreach ($docentes as $docente) {
	       				if ($tribunal == ''){
	       					$tribunal = $tribunal .'' . $docente->docente->persona->apellido .' ' . $docente->docente->persona->nombre;
	       				} else {
	       					$tribunal = $tribunal .' - ' . $docente->docente->persona->apellido .' ' . $docente->docente->persona->nombre;
	       				}

	       			}
	       			$mesaexamen->fechaprimerllamado = FechaHelper::getFechaImpresion($mesaexamen->fechaprimerllamado);

	       			if ($mesaexamen->fechasegundollamado == '0000-00-00 00:00:00'){
	       				$mesaexamen->fechasegundollamado = '-';
	       			} else {
	       				$mesaexamen->fechasegundollamado = FechaHelper::getFechaImpresion($mesaexamen->fechasegundollamado);
	       			}

					$mesas [] = ['id' => $mesaexamen->id, 'materia' => $mesaexamen->materia->nombremateria, 'fechaprimerllamado' => $mesaexamen->fechaprimerllamado, 'horaprimerllamado' => $mesaexamen->horaprimerllamado,'fechasegundollamado' => $mesaexamen->fechasegundollamado, 'horasegundollamado' => $mesaexamen->horasegundollamado, 'tribunal' => $tribunal];

				}

			}

            $materias = Materia::where('carrera_id','=',$carr_id)->orderby('nombremateria')->get();
            
            foreach ($materias as $key => $value) {
                $plan = PlanEstudio::find($value->planestudio_id);
                $opcion[] = ['id' => $value->id, 'descripcion' => $value->nombremateria .' - ' . $plan->codigoplan];
            }
       	} else if ($filtro == 3) {

	        $mesaexamenes = MesaExamen::where('ciclolectivo_id','=', $ciclo_id)->where('turnoexamen_id', '=', $turno_id)->where('organizacion_id','=', $org_id)->where('carrera_id','=', $carr_id)->get();

	        if ($mesaexamenes) {
		        foreach ($mesaexamenes as $mesaexamen) {

		        	$titular = TribunalDocente::where('mesaexamen_id', '=', $mesaexamen->id)->first();

		        	if ($titular->docente_id == $opcion_id) {
		        		$tribunal = '';
		       			$docentes = TribunalDocente::where('mesaexamen_id', '=', $mesaexamen->id)->get();

		       			foreach ($docentes as $docente) {
		       				if ($tribunal == ''){
		       					$tribunal = $tribunal .'' . $docente->docente->persona->apellido .' ' . $docente->docente->persona->nombre;
		       				} else {
		       					$tribunal = $tribunal .' - ' . $docente->docente->persona->apellido .' ' . $docente->docente->persona->nombre;
		       				}

		       			}
		       			$mesaexamen->fechaprimerllamado = FechaHelper::getFechaImpresion($mesaexamen->fechaprimerllamado);

		       			if ($mesaexamen->fechasegundollamado == '0000-00-00 00:00:00'){
		       				$mesaexamen->fechasegundollamado = '-';
		       			} else {
		       				$mesaexamen->fechasegundollamado = FechaHelper::getFechaImpresion($mesaexamen->fechasegundollamado);
		       			}

		        		$mesas [] = ['id' => $mesaexamen->id, 'materia' => $mesaexamen->materia->nombremateria, 'fechaprimerllamado' => $mesaexamen->fechaprimerllamado, 'horaprimerllamado' => $mesaexamen->horaprimerllamado,'fechasegundollamado' => $mesaexamen->fechasegundollamado, 'horasegundollamado' => $mesaexamen->horasegundollamado, 'tribunal' => $tribunal];
		        	}
		        }
	    	}

            $docentes = Docente::all();
            
            foreach ($docentes as $key => $value) {
                //$docente = Docente::where('id', '=', $value->docentetitular_id)->first();
                $persona = Persona::where('id', '=', $value->persona_id)->first();
                //$plan = PlanEstudio::find($value->planestudio_id);
                $opcion[] = ['id' => $value->id, 'descripcion' => $persona->apellido.' ' . $persona->nombre];
            }
       	}
		
		

       	$organizaciones = Organizacion::lists('nombre', 'id');

       	$carreras = Carrera::where('organizacion_id', '=', $org_id)->get();

       	$ciclos = CicloLectivo::where('organizacion_id','=',$org_id)->orderby('descripcion', 'DESC')->get();

        $turnos = TurnoExamen::all();

       
        $opciones = array();
         
        foreach ($opcion as $opc) {
            $opciones[] = $opc['descripcion'];
        }
         
        array_multisort($opciones, SORT_ASC, $opcion);

    	return View::make('mesaexamenes/listado')
    		->with('organizaciones', $organizaciones)
    		->with('carreras', $carreras)
    		->with('filtro', $filtro)
    		->with('opcion', $opcion)
    		->with('ciclos', $ciclos)
    		->with('turnos', $turnos)
    		->with('org_id', $org_id)
    		->with('carr_id', $carr_id)
    		->with('opcion_id', $opcion_id)
    		->with('ciclo_id', $ciclo_id)
    		->with('turno_id', $turno_id )
    		->with('mesas', $mesas)
            ->with('menu', ModulosHelper::MENU_GESTION_ADMINISTRATIVA)
            ->with('submenu', ModulosHelper::SUBMENU_CALENDARIOS)
            ->with('submenu2', ModulosHelper::SUBMENU_2_MESAEXAMENES)
            ->with('leer', Session::get('CALENDARIO_LEER'))
            ->with('editar', Session::get('CALENDARIO_EDITAR'))
            ->with('imprimir', Session::get('CALENDARIO_IMPRIMIR'))
            ->with('eliminar', Session::get('CALENDARIO_ELIMINAR'));   
    }


    public function postObteneropciones() {
        
        $opcion = array();
        $carrid = Input::get('carrera_id');
        $filtro = Input::get('filtro');

        if ($filtro == 2) {

	        $materias = Materia::where('carrera_id','=',$carrid)->orderby('nombremateria')->get();
	        
	        foreach ($materias as $key => $value) {
	        	$plan = PlanEstudio::find($value->planestudio_id);
	        	$opcion[] = ['id' => $value->id, 'descripcion' => $value->nombremateria .' - ' . $plan->codigoplan];
	        }
    	} else if ($filtro == 3) {

    		/*	
    		$asignacion = AsignarDocente::where('carrera_id','=',$carrid)->get();
	        
	        foreach ($asignacion as $key => $value) {

	        	$docente = Docente::where('id', '=', $value->docentetitular_id)->first();
	        	$persona = Persona::where('id', '=', $docente->persona_id)->first();
	        	$plan = PlanEstudio::find($value->planestudio_id);
	        	$opcion[] = ['id' => $value->id, 'descripcion' => $persona->apellido.' ' . $persona->nombre .' - ' . $plan->codigoplan];
	        }*/

	        $docentes = Docente::all();
	        
	        foreach ($docentes as $key => $value) {

	        	//$docente = Docente::where('id', '=', $value->docentetitular_id)->first();
	        	$persona = Persona::where('id', '=', $value->persona_id)->first();
	        	//$plan = PlanEstudio::find($value->planestudio_id);
	        	$opcion[] = ['id' => $value->id, 'descripcion' => $persona->apellido.' ' . $persona->nombre];
	        }

    	}

    	$opciones = array();
		 
		foreach ($opcion as $opc) {
		    $opciones[] = $opc['descripcion'];
		}
		 
		array_multisort($opciones, SORT_ASC, $opcion);

        return Response::json($opcion);
    }

    public function postObtenerciclos() {
        
        $opcion = array();
        $orgid = Input::get('organizacion_id');
	    $ciclos = CicloLectivo::where('organizacion_id','=',$orgid)->orderby('descripcion', 'DESC')->get();


        return Response::json($ciclos);
    }


    public function postObtenerturnos() {
        
        $turnos = TurnoExamen::all();


        return Response::json($turnos);
    }




    public function postObtenerrepetidos() {
        
		$organizacion_id = Input::get('organizacion_id');
        $carrera_id = Input::get('carrera_id');
        $materia_id = Input::get('materia_id');
        $ciclo_id = Input::get('ciclo_id');
        $turno_id = Input::get('turno_id');

        $existe = MesaExamen::where('Organizacion_id','=', $organizacion_id)->where('carrera_id','=', $carrera_id)->where('materia_id','=', $materia_id)->where('ciclolectivo_id','=', $ciclo_id)->where('turnoexamen_id','=', $turno_id)->get();
       	
       	if (count($existe) > 0){
       		$resultado = 1;
       	} else {
       		$resultado = 0;
       	}

          return $resultado;

    }

	public function getCrear()
    {
        $organizaciones = Organizacion::lists('nombre', 'id');

        //$turnos = TurnoExamen::all();

        //$turno_id = $turnos[0]->id;

        //$ciclos = CicloLectivo::lists('descripcion','id');


        array_unshift($organizaciones, 'Seleccione');


        return View::make('mesaexamenes.nuevo')
            ->with('organizaciones', $organizaciones)
            //->with('turnos', $turnos)
    		//->with('turno_id', $turno_id )
            ->with('menu', ModulosHelper::MENU_GESTION_ADMINISTRATIVA)
            ->with('submenu', ModulosHelper::SUBMENU_CALENDARIOS)
            ->with('submenu2', ModulosHelper::SUBMENU_2_MESAEXAMENES)
            ->with('leer', Session::get('CALENDARIO_LEER'))
            ->with('editar', Session::get('CALENDARIO_EDITAR'))
            ->with('imprimir', Session::get('CALENDARIO_IMPRIMIR'))
            ->with('eliminar', Session::get('CALENDARIO_ELIMINAR'));
    }




	public function postGuardar()
	{   
	   	
		$organizacion_id = Input::get('organizacion');
        $carrera_id = Input::get('carreras');
        $materia_id = Input::get('materias');
        $ciclo_id = Input::get('ciclos');
        $turno_id = Input::get('turnos');
        $observacion = Input::get('observacion');
        $fechaprimerllamado = Input::get('fechaprimerllamado');
        $fechasegundollamado = Input::get('fechasegundollamado');
        $horaprimerllamado = Input::get('horaprimerllamado');
        $horasegundollamado = Input::get('horasegundollamado');

       	/*highlight_string(var_export($horasegundollamado, true));
        exit();*/
	   	
	   	$docentes      = Input::get('docentes');


	   	$mesa = new MesaExamen();
	   		$mesa->organizacion_id     =  $organizacion_id;
	   		$mesa->carrera_id          =  $carrera_id;
            $mesa->materia_id          =  $materia_id;  
            $mesa->ciclolectivo_id     =  $ciclo_id;
            $mesa->turnoexamen_id      =  $turno_id;
            $mesa->observaciones       =  $observacion;
            $mesa->fechaprimerllamado  =  $fechaprimerllamado;
            $mesa->horaprimerllamado   =  $horaprimerllamado;
            $mesa->fechasegundollamado =  $fechasegundollamado;
            $mesa->horasegundollamado  =  $horasegundollamado;
            $mesa->usuario_alta        =  Auth::user()->usuario;
            $mesa->fecha_alta          =  date('Y-m-d');
        $mesa->save();


        if ($docentes) {


            for ($i = 0; $i < count($docentes); $i++) {
                
                $tribunal = new TribunalDocente();
                    $tribunal->mesaexamen_id  = $mesa->id;
                    $tribunal->docente_id     =  $docentes[$i];
                    $tribunal->usuario_alta   = Auth::user()->usuario;
                    $tribunal->fecha_alta     = date('Y-m-d');
                $tribunal->save();
            }
        }
	   	

        Session::flash('message', 'LOS DATOS SE GUARDARON CORRECTAMENTE.');
        Session::flash('message_type', self::OPERACION_EXITOSA);
        //return Redirect::to('correlatividades/crear');
        return Redirect::to('mesaexamenes/editar/'.$mesa->id);
                //->withErrors($validator)
  
		/*$mensaje = 'esta parte falta';

	   	highlight_string(var_export($mensaje, true));
        exit();*/
	}


	public function getEditar($id)
    {

    	$tribunal = array();
        $mesaexamen   = MesaExamen::where('id', '=', $id)->first();
        $organizacion = Organizacion::where('id', '=', $mesaexamen->organizacion_id)->first();
        $materia 	  =	Materia::where('id', '=', $mesaexamen->materia_id)->first();
        $carrera      = Carrera::where('id', '=', $mesaexamen->carrera_id)->first();
        $ciclo        = CicloLectivo::where('id', '=', $mesaexamen->ciclolectivo_id)->first();
        $turno        = TurnoExamen::where('id', '=', $mesaexamen->turnoexamen_id)->first();
        //$plan = PlanEstudio::where('id', '=', $materia->planestudio_id)->first();




        $docentes = Docente::all();

       	/*highlight_string(var_export($mesaexamen, true));
        exit();*/

        foreach ($docentes as $key => $value) {
             
            $docente = TribunalDocente::where('mesaexamen_id', '=', $id)->where('docente_id', '=', $value->id)->first();

            if ($docente) {
               $tribunal[] = ['id' => $value->id, 'profesor' => $value->persona->apellido.' ' . $value->persona->nombre, 'seleccionado' => 1];

            } else {
               $tribunal[] = ['id' => $value->id, 'profesor' => $value->persona->apellido.' ' . $value->persona->nombre, 'seleccionado' => 0];

            }
        }

        if($mesaexamen->observacion == null) $mesaexamen->observacion = ''; 

        $mesaexamen->fechaprimerllamado = FechaHelper::getFechaInputDate($mesaexamen->fechaprimerllamado);

        if ($mesaexamen->fechasegundollamado == '0000-00-00 00:00:00'){ 
        	$mesaexamen->fechasegundollamado = null;
        } else {
        	$mesaexamen->fechasegundollamado = FechaHelper::getFechaInputDate($mesaexamen->fechasegundollamado);
        }	
        /*highlight_string(var_export($mesaexamen->fechaprimerllamado, true));
        exit();*/
        return View::make('mesaexamenes.editar')
            ->with('mesaexamen', $mesaexamen)
            ->with('organizacion', $organizacion)
            ->with('carrera', $carrera)
            ->with('materia', $materia)
            ->with('ciclo', $ciclo)
            ->with('tribunal', $tribunal)
            ->with('turno', $turno)
            ->with('menu', ModulosHelper::MENU_GESTION_ADMINISTRATIVA)
            ->with('submenu', ModulosHelper::SUBMENU_CALENDARIOS)
            ->with('submenu2', ModulosHelper::SUBMENU_2_MESAEXAMENES)
            ->with('leer', Session::get('CALENDARIO_LEER'))
            ->with('editar', Session::get('CALENDARIO_EDITAR'))
            ->with('imprimir', Session::get('CALENDARIO_IMPRIMIR'))
            ->with('eliminar', Session::get('CALENDARIO_ELIMINAR'));
    

        /*return View::make('mesaexamenes.editar')->with([
            'mesaexamen' => $mesaexamen,
            'organizacion' => $organizacion,
            'carrera' => $carrera,
            'materia' => $materia,
            'ciclo' => $ciclo,
            'tribunal' => $tribunal,
            'turno' => $turno,
            'menu', ModulosHelper::MENU_GESTION_ADMINISTRATIVA,
            'submenu', ModulosHelper::SUBMENU_CALENDARIOS,
            'submenu2', ModulosHelper::SUBMENU_2_MESAEXAMENES,
            'leer'              => Session::get('CALENDARIO_LEER'),
            'editar'            => Session::get('CALENDARIO_EDITAR'),
            'imprimir'          => Session::get('CALENDARIO_IMPRIMIR'),
            'eliminar'          => Session::get('CALENDARIO_ELIMINAR')
        ]);*/
    }



	public function postEditar()
    {

        $mesa_id = Input::get('txtmesaId');
        $observacion = Input::get('observacion');
        $fechaprimerllamado = Input::get('fechaprimerllamado');
        $fechasegundollamado = Input::get('fechasegundollamado');
        $horaprimerllamado = Input::get('horaprimerllamado');
        $horasegundollamado = Input::get('horasegundollamado');
	   	$docentes      = Input::get('docentes');




	   	$mesa = MesaExamen::find($mesa_id);
            $mesa->observaciones       =  $observacion;
            $mesa->fechaprimerllamado  =  $fechaprimerllamado;
            $mesa->horaprimerllamado   =  $horaprimerllamado;
            $mesa->fechasegundollamado =  $fechasegundollamado;
            $mesa->horasegundollamado  =  $horasegundollamado;
            $mesa->usuario_modi        =  Auth::user()->usuario;
            $mesa->fecha_modi          =  date('Y-m-d');
        $mesa->save();


        $docentestemp = TribunalDocente::where('mesaexamen_id', '=', $mesa_id)->delete();

        if ($docentes) {


            for ($i = 0; $i < count($docentes); $i++) {
                
                $tribunal = new TribunalDocente();
                    $tribunal->mesaexamen_id  = $mesa_id;
                    $tribunal->docente_id     =  $docentes[$i];
                    $tribunal->usuario_alta   = Auth::user()->usuario;
                    $tribunal->fecha_alta     = date('Y-m-d');
                $tribunal->save();
            }
        }


        Session::flash('message', 'LOS DATOS SE MODIFICARON CORRECTAMENTE.');
        Session::flash('message_type', self::OPERACION_EXITOSA);
        return Redirect::to('mesaexamenes/editar/'.$mesa_id);
    }


    public function postBorrar()
    {


        $id = Input::get('idMesaHidden');

        $mesa = IncripcionFinal::where('mesaexamen_id', '=', $id )->first();

        if ($mesa) {
            Session::flash('message', 'NO SE PUDO ELIMINAR LA MESA');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('mesaexamenes/listado');
        }
        
        /*if ($correlatividad->correlatividadesaprobadas) {
            Session::flash('message', 'NO SE PUDO ELIMINAR LA CORRELATIVIDAD');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('correlatividades/listado');
        }*/
        
 
       	TribunalDocente::where('mesaexamen_id', '=', $id)->delete();
        MesaExamen::where('id', '=', $id)->delete();

        Session::flash('message', 'LA MESA DE EXAMEN HA SIDO BORRADA CORRECTAMENTE.');
        Session::flash('message_type', self::OPERACION_EXITOSA);
        return Redirect::to('mesaexamenes/listado');
        

    }


 	public function getImprimir()
    {
    	$mesas = [];

    	$org_id   = Input::get('organizacion');
    	$carr_id  = Input::get('carrera');
        $filtro   = Input::get('cboFiltro');
        $opcion_id = Input::get('opcion');
        $ciclo_id = Input::get('ciclos');
        $turno_id = Input::get('turnos');



       	if ($filtro == 1) {
       		$mesaexamenes = MesaExamen::where('ciclolectivo_id','=', $ciclo_id)->where('turnoexamen_id', '=', $turno_id)->where('organizacion_id','=', $org_id)->where('carrera_id','=', $carr_id)->get();

       		foreach ($mesaexamenes as $mesaexamen) {

       			$tribunal = '';
       			$docentes = TribunalDocente::where('mesaexamen_id', '=', $mesaexamen->id)->get();

       			foreach ($docentes as $docente) {
       				if ($tribunal == ''){
       					$tribunal = $tribunal .'' . $docente->docente->persona->apellido .' ' . $docente->docente->persona->nombre;
       				} else {
       					$tribunal = $tribunal .' - ' . $docente->docente->persona->apellido .' ' . $docente->docente->persona->nombre;
       				}

       			}
				
       			$mesaexamen->fechaprimerllamado = FechaHelper::getFechaImpresion($mesaexamen->fechaprimerllamado);

       			if ($mesaexamen->fechasegundollamado == '0000-00-00 00:00:00'){
       				$mesaexamen->fechasegundollamado = '-';
       			} else {
       				$mesaexamen->fechasegundollamado = FechaHelper::getFechaImpresion($mesaexamen->fechasegundollamado);
       			}


				$mesas [] = ['id' => $mesaexamen->id, 'materia' => $mesaexamen->materia->nombremateria .' - '. $mesaexamen->materia->planestudio->codigoplan, 'fechaprimerllamado' => $mesaexamen->fechaprimerllamado, 'horaprimerllamado' => $mesaexamen->horaprimerllamado,'fechasegundollamado' => $mesaexamen->fechasegundollamado, 'horasegundollamado' => $mesaexamen->horasegundollamado, 'tribunal' => $tribunal];

			}

       	} else if ($filtro == 2) {


	        $mesaexamenes = MesaExamen::where('ciclolectivo_id','=', $ciclo_id)->where('turnoexamen_id', '=', $turno_id)->where('organizacion_id','=', $org_id)->where('carrera_id','=', $carr_id)->where('materia_id','=', $opcion_id)->get();
	        if($mesaexamenes){
       			foreach ($mesaexamenes as $mesaexamen) {
					
					$tribunal = '';
	       			$docentes = TribunalDocente::where('mesaexamen_id', '=', $mesaexamen->id)->get();

	       			foreach ($docentes as $docente) {
	       				if ($tribunal == ''){
	       					$tribunal = $tribunal .'' . $docente->docente->persona->apellido .' ' . $docente->docente->persona->nombre;
	       				} else {
	       					$tribunal = $tribunal .' - ' . $docente->docente->persona->apellido .' ' . $docente->docente->persona->nombre;
	       				}

	       			}
	       			$mesaexamen->fechaprimerllamado = FechaHelper::getFechaImpresion($mesaexamen->fechaprimerllamado);

	       			if ($mesaexamen->fechasegundollamado == '0000-00-00 00:00:00'){
	       				$mesaexamen->fechasegundollamado = '-';
	       			} else {
	       				$mesaexamen->fechasegundollamado = FechaHelper::getFechaImpresion($mesaexamen->fechasegundollamado);
	       			}

					$mesas [] = ['id' => $mesaexamen->id, 'materia' => $mesaexamen->materia->nombremateria, 'fechaprimerllamado' => $mesaexamen->fechaprimerllamado, 'horaprimerllamado' => $mesaexamen->horaprimerllamado,'fechasegundollamado' => $mesaexamen->fechasegundollamado, 'horasegundollamado' => $mesaexamen->horasegundollamado, 'tribunal' => $tribunal];

				}

			}
       	} else if ($filtro == 3) {


	        $mesaexamenes = MesaExamen::where('ciclolectivo_id','=', $ciclo_id)->where('turnoexamen_id', '=', $turno_id)->where('organizacion_id','=', $org_id)->where('carrera_id','=', $carr_id)->get();


	        if($mesaexamenes){
		        foreach ($mesaexamenes as $mesaexamen) {

		        	$titular = TribunalDocente::where('mesaexamen_id', '=', $mesaexamen->id)->first();

		        	if ($titular->docente_id == $opcion_id) {
		        		$tribunal = '';
		       			$docentes = TribunalDocente::where('mesaexamen_id', '=', $mesaexamen->id)->get();

		       			foreach ($docentes as $docente) {
		       				if ($tribunal == ''){
		       					$tribunal = $tribunal .'' . $docente->docente->persona->apellido .' ' . $docente->docente->persona->nombre;
		       				} else {
		       					$tribunal = $tribunal .' - ' . $docente->docente->persona->apellido .' ' . $docente->docente->persona->nombre;
		       				}

		       			}
		       			$mesaexamen->fechaprimerllamado = FechaHelper::getFechaImpresion($mesaexamen->fechaprimerllamado);

		       			if ($mesaexamen->fechasegundollamado == '0000-00-00 00:00:00'){
		       				$mesaexamen->fechasegundollamado = '-';
		       			} else {
		       				$mesaexamen->fechasegundollamado = FechaHelper::getFechaImpresion($mesaexamen->fechasegundollamado);
		       			}

		        		$mesas [] = ['id' => $mesaexamen->id, 'materia' => $mesaexamen->materia->nombremateria, 'fechaprimerllamado' => $mesaexamen->fechaprimerllamado, 'horaprimerllamado' => $mesaexamen->horaprimerllamado,'fechasegundollamado' => $mesaexamen->fechasegundollamado, 'horasegundollamado' => $mesaexamen->horasegundollamado, 'tribunal' => $tribunal];
		        	}
		        }
	    	}
       	}



       	$carrera = Carrera::where('id', '=', $carr_id)->first();

       	$ciclo = CicloLectivo::where('id','=',$ciclo_id)->first();

        $turno = TurnoExamen::where('id','=',$turno_id)->first();


        $pdf = PDF::loadView('informes.pdf.mesaexamenes', 
            ['mesas'=>$mesas,
             'carrera'=>$carrera,
             'ciclo'=>$ciclo,
             'turno'=>$turno
            ]);
        return $pdf->setOrientation('landscape')->stream();


    }

}
