<?php

class AsignarDocenteController extends \BaseController {

    const OPERACION_EXITOSA = 1;
    const OPERACION_FALLIDA = 2;
    const OPERACION_CANCELADA = 3;
    const OPERACION_INFO = 4;
    const NO_EXISTE_DOCENTE = 5;
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

    public function getAsignadocente()
    {
        $organizaciones = Organizacion::lists('nombre', 'id');
        $organizaciones[0] = 'Seleccionar';
        ksort($organizaciones);
        $docentes = Docente::getListado();
        $habilita = false;
        $dni = '';

        return View::make('asignardocente.listadoasignar')
            ->with('organizaciones', $organizaciones)
            ->with('habilita', $habilita)
            ->with('dni', $dni)
            ->with('menu', ModulosHelper::MENU_GESTION_ACADEMICA)
            ->with('submenu', ModulosHelper::SUBMENU_ASIGNAR_DOCENTES)
            ->with('leer', Session::get('ASIGNAR_DOCENTE_LEER'))
            ->with('editar', Session::get('ASIGNAR_DOCENTE_EDITAR'))
            ->with('imprimir', Session::get('ASIGNAR_DOCENTE_IMPRIMIR'))
            ->with('eliminar', Session::get('ASIGNAR_DOCENTE_ELIMINAR'));
    }
    
    public function getCrear()
    {
        $organizaciones = Organizacion::lists('nombre', 'id');
        $organizaciones[0] = 'Seleccionar';
        ksort($organizaciones);
        $docentes = [];//Docente::getListado();
        $habilita = false;
        $idaseguir = '';
        $dni = '';

        return View::make('asignardocente.nuevo', array(
            'organizaciones' 	=> $organizaciones,
            'docentes' 			=> $docentes,
            'habilita' 			=> $habilita,
            'idaseguir' 		=> $idaseguir,
            'dni' 				=> $dni
        ))->with('menu', ModulosHelper::MENU_GESTION_ACADEMICA)
          ->with('submenu', ModulosHelper::SUBMENU_ASIGNAR_DOCENTES)
            ->with('leer', Session::get('ASIGNAR_DOCENTE_LEER'))
            ->with('editar', Session::get('ASIGNAR_DOCENTE_EDITAR'))
            ->with('imprimir', Session::get('ASIGNAR_DOCENTE_IMPRIMIR'))
            ->with('eliminar', Session::get('ASIGNAR_DOCENTE_ELIMINAR'));
    }

    public function postObtenerasignacion() 
    {
        $carrera_id = Input::get('carrera_id');
        $planID = Input::get('planID');
        $materia_id = Input::get('materia_id');

        if ($materia_id == 0) {
        	$asignaciones = AsignarDocente::whereRaw('carrera_id='. $carrera_id .' AND planestudio_id='. $planID)->get();
        } else {
        	$asignaciones = AsignarDocente::whereRaw('carrera_id='. $carrera_id .' AND materia_id='. $materia_id . ' AND planestudio_id='. $planID)->get();
        }

        $docentes = [];
        $dias = [];
        $horaentrada = [];
        $horasalida = [];

        if (count($asignaciones) > 0) {
        	foreach ($asignaciones as $asignacione) {
        		$titular_id = $asignacione->docentetitular_id;
        		$provisorio_id = $asignacione->docenteprovisorio_id;
        		$suplente_id = $asignacione->docentesuplente_id;
        		$materia_id = $asignacione->materia_id;

        		/*array_push($dias, $asignacione->dia);
        		array_push($horaentrada, $asignacione->horaentrada);
        		array_push($horasalida, $asignacione->horasalida);*/

	        	$docentetitular_id = Docente::find($titular_id);
	        	$docenteprovisorio_id = Docente::find($provisorio_id);
	        	$docentesuplente_id = Docente::find($suplente_id);
	        	$docentesmateria = Materia::find($materia_id)->nombremateria;

		        $docentetitular = Persona::where('id', '=', $docentetitular_id->persona_id)->first();
		        $docenteprovisorio = Persona::where('id', '=', $docenteprovisorio_id->persona_id)->first();
		        $docentesuplente = Persona::where('id', '=', $docentesuplente_id->persona_id)->first();

		        $apeynomtitular = $docentetitular->apellido .', '. $docentetitular->nombre;
		        $apeynomprovisorio = $docenteprovisorio->apellido .', '. $docenteprovisorio->nombre;
		        $apeynomsuplente = $docentesuplente->apellido .', '. $docentesuplente->nombre;

		        $detalledias = DetalleAsignarDocente::where('asignardocente_id', '=', $asignacione->id)->get();

		        foreach ($detalledias as $detalledia) {
	        		$entrada = explode(':', $detalledia->horaentrada);
	        		$salida = explode(':', $detalledia->horasalida);

	        		$horaentrada = $entrada[0] .':'. $entrada[1];
	        		$horasalida = $salida[0] .':'. $salida[1];

	        		$dias[] = ['diaid' => $detalledia->id, 'dia' => $detalledia->dia, 'horaentrada' => $horaentrada, 'horasalida' => $horasalida];
		        }

		        $docentes[] = ['id' => $asignacione->id, 'materia_id' => $materia_id, 'docentesmateria' => $docentesmateria, 'titular_id' => $titular_id, 'apeynomtitular' => $apeynomtitular, 'provisorio_id' => $provisorio_id, 'apeynomprovisorio' => $apeynomprovisorio, 'suplente_id' => $suplente_id, 'apeynomsuplente' => $apeynomsuplente, 'dias' => $dias];

		        unset($dias);
        	}

        	//foreach ($docentes as $docente) {
        	/*for ($i=0; $i < count($docentes); $i++) { 
        		$docentes[$i]['dias'] = $dias;

        		$entrada = explode(':', $horaentrada[0]);
        		$salida = explode(':', $horasalida[0]);

        		$horaent = $entrada[0];
        		$minutoent = $entrada[1];
        		$horasal = $salida[0];
        		$minutosal = $salida[1];

        		$docentes[$i]['horaentrada'] = $horaent .':'. $minutoent;
        		$docentes[$i]['horasalida'] = $horasal .':'. $minutosal;
        	}*/
        }
/*highlight_string(var_export($docentes,true));
        exit();*/
        return Response::json($docentes);
    }

    public function postObtenerdocentes() 
    {
        $carrera_id = Input::get('carrera_id');
        $planID = Input::get('planID');
        $materia_id = Input::get('materia_id');

        $asignaciones = AsignarDocente::whereRaw('carrera_id='. $carrera_id .' AND materia_id='. $materia_id . ' AND planestudio_id='. $planID)->get();
        $docentes = [];
        $dias = [];

        if (count($asignaciones) > 0) {
        	foreach ($asignaciones as $asignacione) {
        		$titular_id = $asignacione->docentetitular_id;
        		$provisorio_id = $asignacione->docenteprovisorio_id;
        		$suplente_id = $asignacione->docentesuplente_id;

        		/*array_push($dias, $asignacione->dia);*/

	        	$docentetitular_id = Docente::find($titular_id);
	        	$docenteprovisorio_id = Docente::find($provisorio_id);
	        	$docentesuplente_id = Docente::find($suplente_id);

		        $docentetitular = Persona::where('id', '=', $docentetitular_id->persona_id)->first();
		        $docenteprovisorio = Persona::where('id', '=', $docenteprovisorio_id->persona_id)->first();
		        $docentesuplente = Persona::where('id', '=', $docentesuplente_id->persona_id)->first();

		        $apeynomtitular = $docentetitular->apellido .', '. $docentetitular->nombre;
		        $apeynomprovisorio = $docenteprovisorio->apellido .', '. $docenteprovisorio->nombre;
		        $apeynomsuplente = $docentesuplente->apellido .', '. $docentesuplente->nombre;

		        $detalledias = DetalleAsignarDocente::where('asignardocente_id', '=', $asignacione->id)->get();
                $cuatrimestre = Materia::find($materia_id)->cuatrimestre;

		        foreach ($detalledias as $detalledia) {
	        		$entrada = explode(':', $detalledia->horaentrada);
	        		$salida = explode(':', $detalledia->horasalida);

	        		$horaentrada = $entrada[0];
	        		$minutoentrada = $entrada[1];
	        		$horasalida = $salida[0];
	        		$minutosalida = $salida[1];

	        		$dias[] = ['diaid' => $detalledia->id, 'dia' => $detalledia->dia, 'horaentrada' => $horaentrada, 'minutoentrada' => $minutoentrada, 'horasalida' => $horasalida, 'minutosalida' => $minutosalida];
		        }

		        $docentes[] = ['id' => $asignacione->id, 'titular_id' => $titular_id, 'apeynomtitular' => $apeynomtitular, 'provisorio_id' => $provisorio_id, 'apeynomprovisorio' => $apeynomprovisorio, 'suplente_id' => $suplente_id, 'apeynomsuplente' => $apeynomsuplente, 'cuatrimestre' => $cuatrimestre, 'dias' => $dias];
        	}
        }

        return Response::json($docentes);
    }

    public function postObtenerdia() 
    {
        $carrera_id = Input::get('carrera_id');
        $planID = Input::get('planID');
        $materia_id = Input::get('materia_id');
        $dia = Input::get('dia');

        $asignaciones = AsignarDocente::whereRaw('carrera_id='. $carrera_id .' AND materia_id='. $materia_id . ' AND planestudio_id='. $planID)->first();
        
        $dias = [];

        if ($dia == 'Todos') {
            $diass = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];

            /*for ($i=0; $i < count($diass); $i++) { 
                $detalledias = DetalleAsignarDocente::whereRaw('asignardocente_id='. $asignaciones->id . ' AND dia="'. $diass[$i] .'"')->get();

                if (count($detalledias) > 0) {
                    foreach ($detalledias as $detalledia) {
                        $entrada = explode(':', $detalledia->horaentrada);
                        $salida = explode(':', $detalledia->horasalida);

                        $horaentrada = $entrada[0];
                        $minutoentrada = $entrada[1];
                        $horasalida = $salida[0];
                        $minutosalida = $salida[1];

                        $dias[] = ['diaid' => $detalledia->id, 'dia' => $detalledia->dia, 'horaentrada' => $horaentrada, 'minutoentrada' => $minutoentrada, 'horasalida' => $horasalida, 'minutosalida' => $minutosalida];
                    }
                }
            }*/
        } else {
            $detalledias = DetalleAsignarDocente::whereRaw('asignardocente_id='. $asignaciones->id . ' AND dia="'. $dia .'"')->get();

            if (count($detalledias) > 0) {
                foreach ($detalledias as $detalledia) {
                    $entrada = explode(':', $detalledia->horaentrada);
                    $salida = explode(':', $detalledia->horasalida);

                    $horaentrada = $entrada[0];
                    $minutoentrada = $entrada[1];
                    $horasalida = $salida[0];
                    $minutosalida = $salida[1];

                    $dias[] = ['diaid' => $detalledia->id, 'dia' => $detalledia->dia, 'horaentrada' => $horaentrada, 'minutoentrada' => $minutoentrada, 'horasalida' => $horasalida, 'minutosalida' => $minutosalida];
                }
            }
        }

        return Response::json($dias);
    }

    public function postObtenerdocentedni()
    {
        $dni = Input::get('dni');
        $docentes = Docente::getDocentePorDni($dni);

        $docente = (count($docentes)) ? $docentes[0] : self::NO_EXISTE_DOCENTE;

        return Response::json($docente);
    }

    public function postObtenerdocenteporapellidoynombre()
    {
        $apeynom = Input::get('dni');//'Arevalo, Valeria Lujan';
        $porcion = explode(", ", $apeynom);

        $docentes = Docente::getDocenteApellidoNombre($porcion[0], $porcion[1]);

        $docente = (count($docentes)) ? $docentes[0] : self::NO_EXISTE_DOCENTE;

        return Response::json($docente);
    }

    public function getEditar($idaseguir)
    {  
        $asignacione = AsignarDocente::find($idaseguir);

        $carreras = Carrera::where('organizacion_id', '=', 1)->get();
        $planes = PlanEstudio::where('carrera_id', '=', $asignacione->carrera_id)->get();
        
        $planID = $asignacione->planestudio_id;

        $materias = Materia::where('carrera_id', '=', $asignacione->carrera_id)->where('planestudio_id', '=', $planID)->get();
		
		$docentes = [];
        $dias = [];
        $horaentrada = [];
        $horasalida = [];

		$titular_id = $asignacione->docentetitular_id;
		$provisorio_id = $asignacione->docenteprovisorio_id;
		$suplente_id = $asignacione->docentesuplente_id;

    	$docentetitular_id = Docente::find($titular_id);
    	$docenteprovisorio_id = Docente::find($provisorio_id);
    	$docentesuplente_id = Docente::find($suplente_id);

        $docentetitular = Persona::where('id', '=', $docentetitular_id->persona_id)->first();
        $docenteprovisorio = Persona::where('id', '=', $docenteprovisorio_id->persona_id)->first();
        $docentesuplente = Persona::where('id', '=', $docentesuplente_id->persona_id)->first();

        $apeynomtitular = $docentetitular->apellido .', '. $docentetitular->nombre;
        $apeynomprovisorio = $docenteprovisorio->apellido .', '. $docenteprovisorio->nombre;
        $apeynomsuplente = $docentesuplente->apellido .', '. $docentesuplente->nombre;

        $doctitular = $docentetitular->nrodocumento;
        $docprovisorio = $docenteprovisorio->nrodocumento;
        $docsuplente = $docentesuplente->nrodocumento;

        $detalledias = DetalleAsignarDocente::where('asignardocente_id', '=', $asignacione->id)->get();

        foreach ($detalledias as $detalledia) {
    		$entrada = explode(':', $detalledia->horaentrada);
    		$salida = explode(':', $detalledia->horasalida);

    		$horaentrada = $entrada[0];
    		$minutoentrada = $entrada[1];
    		$horasalida = $salida[0];
    		$minutosalida = $salida[1];

    		$dias[] = ['diaid' => $detalledia->id, 'dia' => $detalledia->dia, 'horaentrada' => $horaentrada, 'minutoentrada' => $minutoentrada, 'horasalida' => $horasalida, 'minutosalida' => $minutosalida];
        }

        $docentes[] = ['id' => $asignacione->id, 'titular_id' => $titular_id, 'apeynomtitular' => $apeynomtitular, 'doctitular' => $doctitular, 'provisorio_id' => $provisorio_id, 'apeynomprovisorio' => $apeynomprovisorio, 'docprovisorio' => $docprovisorio, 'suplente_id' => $suplente_id, 'apeynomsuplente' => $apeynomsuplente, 'docsuplente' => $docsuplente, 'dias' => $dias];
        	
        $habilita = false;
        $organizaciones = Organizacion::lists('nombre', 'id');
        
        return View::make('asignardocente.editar',[
            'organizaciones'  	=> $organizaciones,
            'carrera_id'        => $asignacione->carrera_id,
            'carreras'        	=> $carreras,
            'materia_id'        => $asignacione->materia_id,
            'materias'        	=> $materias,
            'planID'     	  	=> $planID,
            'planes'          	=> $planes,
            'docentes'          => $docentes,
            'idaseguir' 		=> $idaseguir,
            'habilita' 			=> $habilita
        ])->with('menu', ModulosHelper::MENU_GESTION_ACADEMICA)
            ->with('submenu', ModulosHelper::SUBMENU_ASIGNAR_DOCENTES)
            ->with('leer', Session::get('ASIGNAR_DOCENTE_LEER'))
            ->with('editar', Session::get('ASIGNAR_DOCENTE_EDITAR'))
            ->with('imprimir', Session::get('ASIGNAR_DOCENTE_IMPRIMIR'))
            ->with('eliminar', Session::get('ASIGNAR_DOCENTE_ELIMINAR'));
    }

    public function postGuardar()
    {   
    	$validator = Validator::make(
            array(
                'cboCarrera'      		=> Input::get('cboCarrera'),
                'cboPlan'         		=> Input::get('cboPlan'),
                'cboMaterias'     		=> Input::get('cboMaterias'),
                'txttitular_id'      	=> Input::get('txttitular_id'),
                'txtpropietario_id'     => Input::get('txtpropietario_id'),
                'txtsuplente_id'      	=> Input::get('txtsuplente_id')
            ),
            array(
                'cboCarrera'         => 'required',
                'cboPlan'            => 'required',
                'cboMaterias'        => 'required',
                'txttitular_id'      => 'required',
                'txtpropietario_id'  => 'required',
                'txtsuplente_id'     => 'required'
            ),
            array(
                'required' 		=> 'Campo Obligatorio',
                'required' 		=> 'Campo Obligatorio',
                'required' 		=> 'Campo Obligatorio',
                'required' 		=> 'Campo Obligatorio',
                'required' 		=> 'Campo Obligatorio',
                'required' 		=> 'Campo Obligatorio'
            )
        );

        $orgid = Input::get('cboOrganizacion');
        $carrera_id = Input::get('cboCarrera');
        $planID = Input::get('cboPlan');
        $materia_id = Input::get('cboMaterias');

        $docentet_id = Input::get('txttitular_id');
        $docentep_id = Input::get('txtpropietario_id');
        $docentes_id = Input::get('txtsuplente_id');
        $dia = Input::get('dia');
        $txtid = Input::get('txtid');

        if (Input::get('lunes') == null) {
            $lunes = '';
        } else {
            $lunes = Input::get('lunes');
        }

        if (Input::get('martes') == null) {
            $martes = '';
        } else {
            $martes = Input::get('martes');
        }

        if (Input::get('miercoles') == null) {
            $miercoles = '';
        } else {
            $miercoles = Input::get('miercoles');
        }

        if (Input::get('jueves') == null) {
            $jueves = '';
        } else {
            $jueves = Input::get('jueves');
        }

        if (Input::get('viernes') == null) {
            $viernes = '';
        } else {
            $viernes = Input::get('viernes');
        }

        if (Input::get('sabado') == null) {
            $sabado = '';
        } else {
            $sabado = Input::get('sabado');
        }

        if (Input::get('todos') == null) {
            $todos = '';
        } else {
            $todos = Input::get('todos');
        }
        
        $horaent = Input::get('horaentrada');
        $minutoentrada = Input::get('minutoentrada');
        $horasal = Input::get('horasalida');
        $minutosalida = Input::get('minutosalida');

        $horaentrada = '';
        $horasalida  = '';
        $bandera = true;

        if (!$horaent == '') {
            if (!$minutoentrada == '') {
                $horaentrada = $horaent .':'. $minutoentrada;
            } else {
                $bandera = false;
            }
        } else {
            $bandera = false;
        }
        
        if (!$horasal == '') {
            if (!$minutosalida == '') {
                $horasalida  = $horasal .':'. $minutosalida;
            } else {
                $bandera = false;
            }
        } else {
            $bandera = false;
        }

        if ($carrera_id == 0 || $materia_id == 0 || $planID == 0) {
            Session::flash('message', 'ERROR AL INTENTAR GUARDAR, DEBE SELECCIONAR TODAS LAS OPCIONES.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('asignardocente/crear')
                ->withErrors($validator)
                ->withInput();
        }
   
        if ($docentet_id == '') {
            Session::flash('message', 'ERROR AL INTENTAR GUARDAR, DEBE SELECCIONAR DOCENTE TITULAR.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('asignardocente/crear')
                ->withErrors($validator)
                ->withInput();
        }
   
        if ($docentep_id == '') {
            Session::flash('message', 'ERROR AL INTENTAR GUARDAR, DEBE SELECCIONAR DOCENTE PROVISORIO.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('asignardocente/crear')
                ->withErrors($validator)
                ->withInput();
        }
   
        if ($docentes_id == '') {
            Session::flash('message', 'ERROR AL INTENTAR GUARDAR, DEBE SELECCIONAR DOCENTE SUPLENTE.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('asignardocente/crear')
                ->withErrors($validator)
                ->withInput();
        }
   
    	if ($bandera == false) {
    		Session::flash('message', 'ERROR AL INTENTAR GUARDAR, DEBE SELECCIONAR HORAS DE CLASES.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('asignardocente/crear')
                ->withErrors($validator)
                ->withInput();
    	}
   
        if ($todos == '' && $lunes == '' && $martes == '' && $miercoles == '' && $jueves == '' && $viernes == '' && $sabado == '') {
            Session::flash('message', 'ERROR AL INTENTAR GUARDAR, DEBE SELECCIONAR DIAS DE CLASES.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('asignardocente/crear')
                ->withErrors($validator)
                ->withInput();
        }

        if ($validator->fails()) {
            Session::flash('message', 'ERROR AL INTENTAR GUARDAR LAS ASIGNACIÓN DE DOCENTE.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('asignardocente/crear')
                ->withErrors($validator)
                ->withInput();
        } else {
            if ($txtid == '') {
                $asignadocente = new AsignarDocente();

                $asignadocente->carrera_id              = $carrera_id;
                $asignadocente->planestudio_id          = $planID;
                $asignadocente->materia_id              = $materia_id;
                $asignadocente->docentetitular_id       = $docentet_id;
                $asignadocente->docenteprovisorio_id    = $docentep_id;
                $asignadocente->docentesuplente_id      = $docentes_id;
                $asignadocente->usuario_alta            = Auth::user()->usuario;  
                $asignadocente->fecha_alta              = date('Y-m-d');
                
                $asignadocente->save();

                $asigna = AsignarDocente::all();

                $asignadocente = $asigna->last();
                $idaseguir = $asignadocente->id;

                if ($todos == 'Todos') {
                    $dias = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];

                    for ($i=0; $i < count($dias); $i++) { 
                        $detalleasignadocente = new DetalleAsignarDocente();

                        $detalleasignadocente->asignardocente_id    = $idaseguir;
                        $detalleasignadocente->dia                  = $dias[$i];
                        $detalleasignadocente->horaentrada          = $horaentrada;
                        $detalleasignadocente->horasalida           = $horasalida;
                        $detalleasignadocente->usuario_alta         = Auth::user()->usuario;  
                        $detalleasignadocente->fecha_alta           = date('Y-m-d');
                        
                        $detalleasignadocente->save();
                    }
                } else {
                    if ($lunes == 'Lunes') {
                        $detalleasignadocente = new DetalleAsignarDocente();

                        $detalleasignadocente->asignardocente_id    = $idaseguir;
                        $detalleasignadocente->dia                  = $lunes;
                        $detalleasignadocente->horaentrada          = $horaentrada;
                        $detalleasignadocente->horasalida           = $horasalida;
                        $detalleasignadocente->usuario_alta         = Auth::user()->usuario;  
                        $detalleasignadocente->fecha_alta           = date('Y-m-d');
                        
                        $detalleasignadocente->save();
                    }

                    if ($martes == 'Martes') {
                        $detalleasignadocente = new DetalleAsignarDocente();

                        $detalleasignadocente->asignardocente_id    = $idaseguir;
                        $detalleasignadocente->dia                  = $martes;
                        $detalleasignadocente->horaentrada          = $horaentrada;
                        $detalleasignadocente->horasalida           = $horasalida;
                        $detalleasignadocente->usuario_alta         = Auth::user()->usuario;  
                        $detalleasignadocente->fecha_alta           = date('Y-m-d');
                        
                        $detalleasignadocente->save();
                    }

                    if ($miercoles == 'Miercoles') {
                        $detalleasignadocente = new DetalleAsignarDocente();

                        $detalleasignadocente->asignardocente_id    = $idaseguir;
                        $detalleasignadocente->dia                  = $miercoles;
                        $detalleasignadocente->horaentrada          = $horaentrada;
                        $detalleasignadocente->horasalida           = $horasalida;
                        $detalleasignadocente->usuario_alta         = Auth::user()->usuario;  
                        $detalleasignadocente->fecha_alta           = date('Y-m-d');
                        
                        $detalleasignadocente->save();
                    }

                    if ($jueves == 'Jueves') {
                        $detalleasignadocente = new DetalleAsignarDocente();

                        $detalleasignadocente->asignardocente_id    = $idaseguir;
                        $detalleasignadocente->dia                  = $jueves;
                        $detalleasignadocente->horaentrada          = $horaentrada;
                        $detalleasignadocente->horasalida           = $horasalida;
                        $detalleasignadocente->usuario_alta         = Auth::user()->usuario;  
                        $detalleasignadocente->fecha_alta           = date('Y-m-d');
                        
                        $detalleasignadocente->save();
                    }

                    if ($viernes == 'Viernes') {
                        $detalleasignadocente = new DetalleAsignarDocente();

                        $detalleasignadocente->asignardocente_id    = $idaseguir;
                        $detalleasignadocente->dia                  = $viernes;
                        $detalleasignadocente->horaentrada          = $horaentrada;
                        $detalleasignadocente->horasalida           = $horasalida;
                        $detalleasignadocente->usuario_alta         = Auth::user()->usuario;  
                        $detalleasignadocente->fecha_alta           = date('Y-m-d');
                        
                        $detalleasignadocente->save();
                    }

                    if ($sabado == 'Sabado') {
                        $detalleasignadocente = new DetalleAsignarDocente();

                        $detalleasignadocente->asignardocente_id    = $idaseguir;
                        $detalleasignadocente->dia                  = $sabado;
                        $detalleasignadocente->horaentrada          = $horaentrada;
                        $detalleasignadocente->horasalida           = $horasalida;
                        $detalleasignadocente->usuario_alta         = Auth::user()->usuario;  
                        $detalleasignadocente->fecha_alta           = date('Y-m-d');
                        
                        $detalleasignadocente->save();
                    }
                }
            } else {
                $asignadocente = AsignarDocente::find($txtid);

                $asignadocente->carrera_id              = $carrera_id;
                $asignadocente->planestudio_id          = $planID;
                $asignadocente->materia_id              = $materia_id;
                $asignadocente->docentetitular_id       = $docentet_id;
                $asignadocente->docenteprovisorio_id    = $docentep_id;
                $asignadocente->docentesuplente_id      = $docentes_id;
                $asignadocente->usuario_modi            = Auth::user()->usuario;  
                $asignadocente->fecha_modi              = date('Y-m-d');
                
                $asignadocente->save();

                if ($todos == 'Todos') {
                    $dias = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];
                    
                    for ($i=0; $i < count($dias); $i++) { 
                        $detalleasigna = DetalleAsignarDocente::whereRaw('asignardocente_id='. $txtid .' AND dia="'. $dias[$i] .'"')->first();

                        if (count($detalleasigna) > 0) {
                            $detalleasignadocente = DetalleAsignarDocente::find($detalleasigna->id);

                            $detalleasignadocente->asignardocente_id    = $txtid;
                            $detalleasignadocente->dia                  = $dias[$i];
                            $detalleasignadocente->horaentrada          = $horaentrada;
                            $detalleasignadocente->horasalida           = $horasalida;
                            $detalleasignadocente->usuario_modi         = Auth::user()->usuario;  
                            $detalleasignadocente->fecha_modi           = date('Y-m-d');
                            
                            $detalleasignadocente->save();
                        } else {
                            $detalleasignadocente = new DetalleAsignarDocente();

                            $detalleasignadocente->asignardocente_id    = $txtid;
                            $detalleasignadocente->dia                  = $dias[$i];
                            $detalleasignadocente->horaentrada          = $horaentrada;
                            $detalleasignadocente->horasalida           = $horasalida;
                            $detalleasignadocente->usuario_alta         = Auth::user()->usuario;  
                            $detalleasignadocente->fecha_alta           = date('Y-m-d');
                            
                            $detalleasignadocente->save();
                        }
                    }
                } else {
                    if ($lunes == 'Lunes') {
                        
                        $detalleasigna = DetalleAsignarDocente::whereRaw('asignardocente_id='. $txtid .' AND dia="'. $lunes .'"')->first();

                        if (count($detalleasigna) > 0) {
                            $detalleasignadocente = DetalleAsignarDocente::find($detalleasigna->id);

                            $detalleasignadocente->asignardocente_id    = $txtid;
                            $detalleasignadocente->dia                  = $lunes;
                            $detalleasignadocente->horaentrada          = $horaentrada;
                            $detalleasignadocente->horasalida           = $horasalida;
                            $detalleasignadocente->usuario_modi         = Auth::user()->usuario;  
                            $detalleasignadocente->fecha_modi           = date('Y-m-d');
                            
                            $detalleasignadocente->save();
                        } else {
                            $detalleasignadocente = new DetalleAsignarDocente();

                            $detalleasignadocente->asignardocente_id    = $txtid;
                            $detalleasignadocente->dia                  = $lunes;
                            $detalleasignadocente->horaentrada          = $horaentrada;
                            $detalleasignadocente->horasalida           = $horasalida;
                            $detalleasignadocente->usuario_alta         = Auth::user()->usuario;  
                            $detalleasignadocente->fecha_alta           = date('Y-m-d');
                            
                            $detalleasignadocente->save();
                        }
                    }

                    if ($martes == 'Martes') {
                        $detalleasigna = DetalleAsignarDocente::whereRaw('asignardocente_id='. $txtid .' AND dia="'. $martes .'"')->first();

                        if (count($detalleasigna) > 0) {
                            $detalleasignadocente = DetalleAsignarDocente::find($detalleasigna->id);

                            $detalleasignadocente->asignardocente_id    = $txtid;
                            $detalleasignadocente->dia                  = $martes;
                            $detalleasignadocente->horaentrada          = $horaentrada;
                            $detalleasignadocente->horasalida           = $horasalida;
                            $detalleasignadocente->usuario_modi         = Auth::user()->usuario;  
                            $detalleasignadocente->fecha_modi           = date('Y-m-d');
                            
                            $detalleasignadocente->save();
                        } else {
                            $detalleasignadocente = new DetalleAsignarDocente();

                            $detalleasignadocente->asignardocente_id    = $txtid;
                            $detalleasignadocente->dia                  = $martes;
                            $detalleasignadocente->horaentrada          = $horaentrada;
                            $detalleasignadocente->horasalida           = $horasalida;
                            $detalleasignadocente->usuario_alta         = Auth::user()->usuario;  
                            $detalleasignadocente->fecha_alta           = date('Y-m-d');
                            
                            $detalleasignadocente->save();
                        }
                    }

                    if ($miercoles == 'Miercoles') {
                        $detalleasigna = DetalleAsignarDocente::whereRaw('asignardocente_id='. $txtid .' AND dia="'. $miercoles .'"')->first();

                        if (count($detalleasigna) > 0) {
                            $detalleasignadocente = DetalleAsignarDocente::find($detalleasigna->id);

                            $detalleasignadocente->asignardocente_id    = $txtid;
                            $detalleasignadocente->dia                  = $miercoles;
                            $detalleasignadocente->horaentrada          = $horaentrada;
                            $detalleasignadocente->horasalida           = $horasalida;
                            $detalleasignadocente->usuario_modi         = Auth::user()->usuario;  
                            $detalleasignadocente->fecha_modi           = date('Y-m-d');
                            
                            $detalleasignadocente->save();
                        } else {
                            $detalleasignadocente = new DetalleAsignarDocente();

                            $detalleasignadocente->asignardocente_id    = $txtid;
                            $detalleasignadocente->dia                  = $miercoles;
                            $detalleasignadocente->horaentrada          = $horaentrada;
                            $detalleasignadocente->horasalida           = $horasalida;
                            $detalleasignadocente->usuario_alta         = Auth::user()->usuario;  
                            $detalleasignadocente->fecha_alta           = date('Y-m-d');
                            
                            $detalleasignadocente->save();
                        }
                    }

                    if ($jueves == 'Jueves') {
                        $detalleasigna = DetalleAsignarDocente::whereRaw('asignardocente_id='. $txtid .' AND dia="'. $jueves .'"')->first();

                        if (count($detalleasigna) > 0) {
                            $detalleasignadocente = DetalleAsignarDocente::find($detalleasigna->id);

                            $detalleasignadocente->asignardocente_id    = $txtid;
                            $detalleasignadocente->dia                  = $jueves;
                            $detalleasignadocente->horaentrada          = $horaentrada;
                            $detalleasignadocente->horasalida           = $horasalida;
                            $detalleasignadocente->usuario_modi         = Auth::user()->usuario;  
                            $detalleasignadocente->fecha_modi           = date('Y-m-d');
                            
                            $detalleasignadocente->save();
                        } else {
                            $detalleasignadocente = new DetalleAsignarDocente();

                            $detalleasignadocente->asignardocente_id    = $txtid;
                            $detalleasignadocente->dia                  = $jueves;
                            $detalleasignadocente->horaentrada          = $horaentrada;
                            $detalleasignadocente->horasalida           = $horasalida;
                            $detalleasignadocente->usuario_alta         = Auth::user()->usuario;  
                            $detalleasignadocente->fecha_alta           = date('Y-m-d');
                            
                            $detalleasignadocente->save();
                        }
                    }

                    if ($viernes == 'Viernes') {
                        $detalleasigna = DetalleAsignarDocente::whereRaw('asignardocente_id='. $txtid .' AND dia="'. $viernes .'"')->first();

                        if (count($detalleasigna) > 0) {
                            $detalleasignadocente = DetalleAsignarDocente::find($detalleasigna->id);

                            $detalleasignadocente->asignardocente_id    = $txtid;
                            $detalleasignadocente->dia                  = $viernes;
                            $detalleasignadocente->horaentrada          = $horaentrada;
                            $detalleasignadocente->horasalida           = $horasalida;
                            $detalleasignadocente->usuario_modi         = Auth::user()->usuario;  
                            $detalleasignadocente->fecha_modi           = date('Y-m-d');
                            
                            $detalleasignadocente->save();
                        } else {
                            $detalleasignadocente = new DetalleAsignarDocente();

                            $detalleasignadocente->asignardocente_id    = $txtid;
                            $detalleasignadocente->dia                  = $viernes;
                            $detalleasignadocente->horaentrada          = $horaentrada;
                            $detalleasignadocente->horasalida           = $horasalida;
                            $detalleasignadocente->usuario_alta         = Auth::user()->usuario;  
                            $detalleasignadocente->fecha_alta           = date('Y-m-d');
                            
                            $detalleasignadocente->save();
                        }
                    }

                    if ($sabado == 'Sabado') {
                        $detalleasigna = DetalleAsignarDocente::whereRaw('asignardocente_id='. $txtid .' AND dia="'. $sabado .'"')->first();

                        if (count($detalleasigna) > 0) {
                            $detalleasignadocente = DetalleAsignarDocente::find($detalleasigna->id);

                            $detalleasignadocente->asignardocente_id    = $txtid;
                            $detalleasignadocente->dia                  = $sabado;
                            $detalleasignadocente->horaentrada          = $horaentrada;
                            $detalleasignadocente->horasalida           = $horasalida;
                            $detalleasignadocente->usuario_modi         = Auth::user()->usuario;  
                            $detalleasignadocente->fecha_modi           = date('Y-m-d');
                            
                            $detalleasignadocente->save();
                        } else {
                            $detalleasignadocente = new DetalleAsignarDocente();

                            $detalleasignadocente->asignardocente_id    = $txtid;
                            $detalleasignadocente->dia                  = $sabado;
                            $detalleasignadocente->horaentrada          = $horaentrada;
                            $detalleasignadocente->horasalida           = $horasalida;
                            $detalleasignadocente->usuario_alta         = Auth::user()->usuario;  
                            $detalleasignadocente->fecha_alta           = date('Y-m-d');
                            
                            $detalleasignadocente->save();
                        }
                    }
                }

                $idaseguir = $txtid;
            }
            
            Session::flash('message', 'LOS DATOS SE CARGARON CORRECTAMENTE!');
            Session::flash('message_type', self::OPERACION_EXITOSA);
            return Redirect::to('asignardocente/guardado/'.$idaseguir);
            //return Redirect::to('asignardocente/crear');
        } 

    	/*highlight_string(var_export('ok',true));
        exit();*/
    }

    public function getGuardado($idaseguir)
    {  
        $asignacione = AsignarDocente::find($idaseguir);

        $carreras = Carrera::where('organizacion_id', '=', 1)->get();
        $planes = PlanEstudio::where('carrera_id', '=', $asignacione->carrera_id)->get();
        
        $planID = $asignacione->planestudio_id;

        $materias = Materia::where('carrera_id', '=', $asignacione->carrera_id)->where('planestudio_id', '=', $planID)->get();
        //$docente_id = Materia::find($asignardocente->materia_id)->docente_id;
        
        //$asigdocente = AsignarDocente::whereRaw('carrera_id='. $asignardocente->carrera_id .' AND planestudio_id='. $planID .' AND materia_id ='. $asignardocente->materia_id)->get();
		
		$docentes = [];
        $dias = [];
        $horaentrada = [];
        $horasalida = [];

        /*if (count($asignardocente) > 0) {
        	foreach ($asignardocente as $asignacione) {*/
        		$titular_id = $asignacione->docentetitular_id;
        		$provisorio_id = $asignacione->docenteprovisorio_id;
        		$suplente_id = $asignacione->docentesuplente_id;

        		/*array_push($dias, $asignacione->dia);
        		array_push($horaentrada, $asignacione->horaentrada);
        		array_push($horasalida, $asignacione->horasalida);*/

	        	$docentetitular_id = Docente::find($titular_id);
	        	$docenteprovisorio_id = Docente::find($provisorio_id);
	        	$docentesuplente_id = Docente::find($suplente_id);

		        $docentetitular = Persona::where('id', '=', $docentetitular_id->persona_id)->first();
		        $docenteprovisorio = Persona::where('id', '=', $docenteprovisorio_id->persona_id)->first();
		        $docentesuplente = Persona::where('id', '=', $docentesuplente_id->persona_id)->first();

		        $apeynomtitular = $docentetitular->apellido .', '. $docentetitular->nombre;
		        $apeynomprovisorio = $docenteprovisorio->apellido .', '. $docenteprovisorio->nombre;
		        $apeynomsuplente = $docentesuplente->apellido .', '. $docentesuplente->nombre;

		        $doctitular = $docentetitular->nrodocumento;
		        $docprovisorio = $docenteprovisorio->nrodocumento;
		        $docsuplente = $docentesuplente->nrodocumento;

		        $detalledias = DetalleAsignarDocente::where('asignardocente_id', '=', $asignacione->id)->get();

		        foreach ($detalledias as $detalledia) {
	        		$entrada = explode(':', $detalledia->horaentrada);
	        		$salida = explode(':', $detalledia->horasalida);

	        		$horaentrada = $entrada[0];
	        		$minutoentrada = $entrada[1];
	        		$horasalida = $salida[0];
	        		$minutosalida = $salida[1];

	        		$dias[] = ['diaid' => $detalledia->id, 'dia' => $detalledia->dia, 'horaentrada' => $horaentrada, 'minutoentrada' => $minutoentrada, 'horasalida' => $horasalida, 'minutosalida' => $minutosalida];
		        }

		        $docentes[] = ['id' => $asignacione->id, 'titular_id' => $titular_id, 'apeynomtitular' => $apeynomtitular, 'doctitular' => $doctitular, 'provisorio_id' => $provisorio_id, 'apeynomprovisorio' => $apeynomprovisorio, 'docprovisorio' => $docprovisorio, 'suplente_id' => $suplente_id, 'apeynomsuplente' => $apeynomsuplente, 'docsuplente' => $docsuplente, 'dias' => $dias];
        	//}

        	//foreach ($docentes as $docente) {
        	/*for ($i=0; $i < count($docentes); $i++) { 
        		$docentes[$i]['dias'] = $dias;

        		$entrada = explode(':', $horaentrada[0]);
        		$salida = explode(':', $horasalida[0]);

        		$horaent = $entrada[0];
        		$minutoent = $entrada[1];
        		$horasal = $salida[0];
        		$minutosal = $salida[1];

        		$docentes[$i]['horaentrada'] = $horaent;
        		$docentes[$i]['minutoentrada'] = $minutoent;
        		$docentes[$i]['horasalida'] = $horasal;
        		$docentes[$i]['minutosalida'] = $minutosal;
        	}*/
        //}

        $habilita = false;
        $organizaciones = Organizacion::lists('nombre', 'id');
        
        return View::make('asignardocente.editar',[
            'organizaciones'  	=> $organizaciones,
            'carrera_id'        => $asignacione->carrera_id,
            'carreras'        	=> $carreras,
            'materia_id'        => $asignacione->materia_id,
            'materias'        	=> $materias,
            'planID'     	  	=> $planID,
            'planes'          	=> $planes,
            'docentes'          => $docentes,
            'idaseguir' 		=> $idaseguir,
            'habilita' 			=> $habilita
        ])->with('menu', ModulosHelper::MENU_GESTION_ACADEMICA)
            ->with('submenu', ModulosHelper::SUBMENU_ASIGNAR_DOCENTES)
            ->with('leer', Session::get('ASIGNAR_DOCENTE_LEER'))
            ->with('editar', Session::get('ASIGNAR_DOCENTE_EDITAR'))
            ->with('imprimir', Session::get('ASIGNAR_DOCENTE_IMPRIMIR'))
            ->with('eliminar', Session::get('ASIGNAR_DOCENTE_ELIMINAR'));
    }

    public function getImprimir()
    {
        $carrera_id = Input::get('carrera_id');
        $planID = Input::get('planID');
        $materia_id = Input::get('materia_id');


        if ($materia_id == 0) {
        	$asignaciones = AsignarDocente::whereRaw('carrera_id='. $carrera_id .' AND planestudio_id='. $planID)->get();
        } else {
        	$asignaciones = AsignarDocente::whereRaw('carrera_id='. $carrera_id .' AND materia_id='. $materia_id . ' AND planestudio_id='. $planID)->get();
        }

        $docentes = [];
        $dias = [];
        $horaentrada = [];
        $horasalida = [];
        $carreras = Carrera::find($carrera_id)->carrera;
        $planes = PlanEstudio::find($planID)->codigoplan;

        if (count($asignaciones) > 0) {
        	foreach ($asignaciones as $asignacione) {
        		$titular_id = $asignacione->docentetitular_id;
        		$provisorio_id = $asignacione->docenteprovisorio_id;
        		$suplente_id = $asignacione->docentesuplente_id;
        		$materia_id = $asignacione->materia_id;

        		/*array_push($dias, $asignacione->dia);
        		array_push($horaentrada, $asignacione->horaentrada);
        		array_push($horasalida, $asignacione->horasalida);*/

	        	$docentetitular_id = Docente::find($titular_id);
	        	$docenteprovisorio_id = Docente::find($provisorio_id);
	        	$docentesuplente_id = Docente::find($suplente_id);
	        	$docentesmateria = Materia::find($materia_id)->nombremateria;

		        $docentetitular = Persona::where('id', '=', $docentetitular_id->persona_id)->first();
		        $docenteprovisorio = Persona::where('id', '=', $docenteprovisorio_id->persona_id)->first();
		        $docentesuplente = Persona::where('id', '=', $docentesuplente_id->persona_id)->first();

		        $apeynomtitular = $docentetitular->apellido .', '. $docentetitular->nombre;
		        $apeynomprovisorio = $docenteprovisorio->apellido .', '. $docenteprovisorio->nombre;
		        $apeynomsuplente = $docentesuplente->apellido .', '. $docentesuplente->nombre;

		        $detalledias = DetalleAsignarDocente::where('asignardocente_id', '=', $asignacione->id)->get();

		        foreach ($detalledias as $detalledia) {
	        		$entrada = explode(':', $detalledia->horaentrada);
	        		$salida = explode(':', $detalledia->horasalida);

	        		$horaentrada = $entrada[0] .':'. $entrada[1];
	        		$horasalida = $salida[0] .':'. $salida[1];

	        		$dias[] = ['dia' => $detalledia->dia, 'horaentrada' => $horaentrada, 'horasalida' => $horasalida];
		        }

		        $docentes[] = ['id' => $asignacione->id, 'materia_id' => $materia_id, 'docentesmateria' => $docentesmateria, 'titular_id' => $titular_id, 'apeynomtitular' => $apeynomtitular, 'provisorio_id' => $provisorio_id, 'apeynomprovisorio' => $apeynomprovisorio, 'suplente_id' => $suplente_id, 'apeynomsuplente' => $apeynomsuplente, 'dias' => $dias];

		        unset($dias);
        	}
        }

        /*highlight_string(var_export($docentes,true));
        exit;*/
        $pdf = PDF::loadView('informes.pdf.asignardocente', [
            'docentes' 			=>  $docentes,
            'carreras'          =>  $carreras,
            'planes'            =>  $planes]);
        return $pdf->setOrientation('landscape')->stream();
    }

    public function postBorrar()
    {
        $id = Input::get('idPlanHidden');

        $detalleasignadocente = DetalleAsignarDocente::findOrFail($id);

        $idaseguir = $detalleasignadocente->asignardocente_id;

        $detalleasignadocente->delete();
        
        /*$asignadocente = AsignarDocente::findOrFail($id);

        $asignadocente->delete();*/

        Session::flash('message', 'EL REGISTRO HA SIDO BORRADO.');
        Session::flash('message_type', self::OPERACION_EXITOSA);
        return Redirect::to('asignardocente/guardado/'.$idaseguir);
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
