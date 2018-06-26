<?php

class ExamenFinalController extends \BaseController {

    private $_data;
    private $_rules;
    private $_messages;

    const OPERACION_EXITOSA = 1;
    const OPERACION_FALLIDA = 2;
    const OPERACION_CANCELADA = 3;
    const OPERACION_INFO = 4;
    const NO_EXISTE_ALUMNO = 5;
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	public function getListado()
	{
        $organizaciones = Organizacion::lists('nombre', 'id');
        $organizaciones[0] = 'Seleccionar';
        ksort($organizaciones);

        $turnos = TurnoExamen::all();

		$habilita = false;
        $alumno_id = '';
        $nrodocumento = '';

        return View::make('examenfinal.listado')
            ->with('organizaciones', $organizaciones)
            ->with('turnos', $turnos)
            ->with('alumno_id', $alumno_id)
            ->with('nrodocumento', $nrodocumento)
            ->with('habilita', $habilita)
            ->with('menu', ModulosHelper::MENU_GESTION_ACADEMICA)
            ->with('submenu', ModulosHelper::SUBMENU_BOLETINES)
            ->with('submenu2', ModulosHelper::SUBMENU_2_EXAMENFINAL)
            ->with('leer', Session::get('BOLETIN_LEER'))
            ->with('editar', Session::get('BOLETIN_EDITAR'))
            ->with('imprimir', Session::get('BOLETIN_IMPRIMIR'))
            ->with('eliminar', Session::get('BOLETIN_ELIMINAR'));
	}

    public function postObtenerlistado() 
    {
        $carrera_id = Input::get('cboCarrera');
        $orgid =  Input::get('cboOrganizacion');
        $planID = Input::get('cboPlan');
        $materia_id = Input::get('cboMaterias');
        $turnoexamen_id = Input::get('cboTurnoExamen');
        $dni = Input::get('txtalumno');

        $alumno_id = '';
        $nrodocumento = '';
        $docentes = '';
        $alumnos = [];
        $habilita = true;
        $nota = ['cero', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve', 'diez'];

        if ($orgid == 0 || $carrera_id == 0 || $planID == 0 || $materia_id == 0 || $turnoexamen_id == 0) {
        	Session::flash('message', 'ERROR DEBE SELECCIONAR LOS DATOS A BUSCAR.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('examenfinal/listado')
                //->withErrors($validator)
                ->withInput();
        }
        ///////////////
        $ciclolectivo_id = PlanEstudio::find($planID)->ciclolectivo_id;

        $mesaexamen = MesaExamen::whereRaw('carrera_id ='.$carrera_id.' AND ciclolectivo_id ='.$ciclolectivo_id.' AND materia_id ='.$materia_id.' AND turnoexamen_id ='.$turnoexamen_id)->get();

        if (count($mesaexamen) > 0) {
        	foreach ($mesaexamen as $value) {
	        	$docentesasig = TribunalDocente::whereRaw('mesaexamen_id ='. $value->id)->get();

	        	if (count($docentesasig) > 0) {
		        	foreach ($docentesasig as $docente) {
		        		$personatitular = Docente::find($docente->docente_id)->persona_id;

				    	$docentetitular_id = Persona::find($personatitular);

				    	$docentetitular = $docentetitular_id->apellido .', '. $docentetitular_id->nombre;

				    	$docentes .= $docentetitular . ' - ';
		        	}
		        }
	        }
        }

        $mesaexamens = MesaExamen::whereRaw('carrera_id ='.$carrera_id.' AND ciclolectivo_id ='.$ciclolectivo_id.' AND turnoexamen_id ='.$turnoexamen_id)->get();

        if (count($mesaexamens) > 0) {
        	foreach ($mesaexamens as $value) {
	        	$materiass = Materia::find($value->materia_id);

	        	$cbomaterias[] = ['id' => $materiass->id, 'nombremateria' => $materiass->nombremateria];
	        }
        } else {
        	$cbomaterias = [];
        }

        if (!$dni == '') {
        	$alumnos = Alumno::getAlumnoPorDni($dni);
        }

        if (count($alumnos) > 0) {
        	$alumno_id = $alumnos[0]->alumno_id;
        	$nrodocumento = $alumnos[0]->nrodocumento;

        	$examenfinal = ExamenFinal::whereRaw('carrera_id ='.$carrera_id.' AND planestudio_id ='.$planID.' AND turnoexamen_id ='.$turnoexamen_id.' AND materia_id ='.$materia_id.' AND alumno_id ='.$alumno_id)->get();
        } else {
        	$examenfinal = ExamenFinal::whereRaw('carrera_id ='.$carrera_id.' AND planestudio_id ='.$planID.' AND turnoexamen_id ='.$turnoexamen_id.' AND materia_id ='.$materia_id)->get();
        }

        if (count($examenfinal) > 0) {
        	foreach ($examenfinal as $value) {
    			$alumnopersona = Alumno::find($value->alumno_id)->persona_id;
    			$personaalumno = Persona::find($alumnopersona);
    			$persona = $personaalumno->apellido .', '. $personaalumno->nombre;

	        	$fecha_aprobacion = FechaHelper::getFechaImpresion($value->fecha_aprobacion);
	        	$nombremateria = Materia::find($materia_id)->nombremateria;
	        	
	        	$materias[] = ['id' => $value->id, 'fecha_aprobacion' => $fecha_aprobacion, 'docentes' => $docentes, 'alumno' => $persona, 'nombremateria' => $nombremateria, 'calif_final_num' => $value->calif_final_num, 'calif_final_let' => $value->calif_final_let, 'folio' => $value->folio, 'libro' => $value->libro, 'acta' => $value->acta];
	        }
        } else {
        	$habilita = false;
        	$materias = [];
        }
        /*
highlight_string(var_export($examenfinal,true));
        exit;
*/
        $carreras = Carrera::where('organizacion_id', '=', $orgid)->get();

        $planestudios = PlanEstudio::whereRaw('carrera_id= '. $carrera_id)->get();

        $turnos = TurnoExamen::all();

        $organizaciones = Organizacion::lists('nombre', 'id');

        return View::make('examenfinal/listado')
            ->with('organizaciones', $organizaciones)
            ->with('planes', $planestudios)
            ->with('planID', $planID)
            ->with('carrera_id', $carrera_id)
            ->with('OrgID', $orgid)
            ->with('carreras', $carreras)
            ->with('examenfinal', $materias)
            ->with('turnoexamen_id', $turnoexamen_id)
            ->with('turnos', $turnos)
            ->with('materia_id', $materia_id)
            ->with('materias', $cbomaterias)
            ->with('alumno_id', $alumno_id)
            ->with('nrodocumento', $nrodocumento)
            ->with('habilita', $habilita)
            ->with('nota', $nota)
            ->with('menu', ModulosHelper::MENU_GESTION_ACADEMICA)
            ->with('submenu', ModulosHelper::SUBMENU_BOLETINES)
            ->with('submenu2', ModulosHelper::SUBMENU_2_EXAMENFINAL)
            ->with('leer', Session::get('BOLETIN_LEER'))
            ->with('editar', Session::get('BOLETIN_EDITAR'))
            ->with('imprimir', Session::get('BOLETIN_IMPRIMIR'))
            ->with('eliminar', Session::get('BOLETIN_ELIMINAR'));
    }

    public function getCrear()
    {
        $organizaciones = Organizacion::lists('nombre', 'id');
        $organizaciones[0] = 'Seleccionar';
        ksort($organizaciones);
        $examenfinal = [];
        $habilita = false;
        $idaseguir = '';
        $dni = '';
        $libro = '';
        $folio = '';
        $acta = '';
        $calif_final_num = '';
        $calif_final_let = '';
        $justifico = 0;

        $turnos = TurnoExamen::all();

        return View::make('examenfinal.nuevo', array(
            'organizaciones' 	=> $organizaciones,
            'examenfinal' 		=> $examenfinal,
            'habilita' 			=> $habilita,
            'idaseguir' 		=> $idaseguir,
            'dni' 				=> $dni,
            'turnos' 			=> $turnos,
            'libro' 			=> $libro,
            'folio' 			=> $folio,
            'acta' 				=> $acta,
            'calif_final_num' 	=> $calif_final_num,
            'calif_final_let' 	=> $calif_final_let,
            'justifico'         => $justifico
        ))->with('menu', ModulosHelper::MENU_GESTION_ACADEMICA)
            ->with('submenu', ModulosHelper::SUBMENU_BOLETINES)
            ->with('submenu2', ModulosHelper::SUBMENU_2_EXAMENFINAL)
            ->with('leer', Session::get('BOLETIN_LEER'))
            ->with('editar', Session::get('BOLETIN_EDITAR'))
            ->with('imprimir', Session::get('BOLETIN_IMPRIMIR'))
            ->with('eliminar', Session::get('BOLETIN_ELIMINAR'));
    }

    public function postObtenermaterias() 
    {
        $carrid = Input::get('carrera_id');
        $planID = Input::get('plan_id');
        $turnoexamen_id = Input::get('turnoexamen_id');

        $ciclolectivo_id = PlanEstudio::find($planID)->ciclolectivo_id;

        $examenfinal = MesaExamen::whereRaw('carrera_id ='.$carrid.' AND ciclolectivo_id ='.$ciclolectivo_id.' AND turnoexamen_id ='.$turnoexamen_id)->get();

        if (count($examenfinal) > 0) {
        	foreach ($examenfinal as $value) {
	        	$materiass = Materia::find($value->materia_id);

	        	$materias[] = ['id' => $materiass->id, 'nombremateria' => $materiass->nombremateria];
	        }
        } else {
        	$materias = [];
        }
        
        return Response::json($materias);
    }

    public function postObtenerinscripcionexamen() 
    {
        $carrera_id = Input::get('carrera_id');
        $planID = Input::get('planID');
        $materia_id = Input::get('materia_id');
        $turnoexamen_id = Input::get('cboTurnoExamen');
        $alumno_id = Input::get('alumno_id');
        $inscripto = 0;

        $ciclolectivo_id = PlanEstudio::find($planID)->ciclolectivo_id;

        $inscripcion = InscripcionFinal::whereRaw('alumno_id = '.$alumno_id)->get();

        if (count($inscripcion) > 0) {
        	foreach ($inscripcion as $value) {
        		if ($value->anulado == 0) {
	        		$mesaexamen = MesaExamen::whereRaw('id ='.$value->mesaexamen_id.' AND carrera_id ='.$carrera_id.' AND ciclolectivo_id ='.$ciclolectivo_id.' AND materia_id ='.$materia_id.' AND turnoexamen_id ='.$turnoexamen_id)->get();//find($value->mesaexamen_id);

	        		if (count($mesaexamen) > 0) {
	        			$inscripto = $value->id;
	        		}
        		}
        	}
        }
        
        if ($inscripto > 0) {
        	$examenfinal = ExamenFinal::whereRaw('carrera_id ='.$carrera_id.' AND planestudio_id ='.$planID.' AND turnoexamen_id ='.$turnoexamen_id.' AND materia_id ='.$materia_id.' AND alumno_id ='.$alumno_id.' AND inscripcionfinal_id ='.$inscripto)->get();

        	if (count($examenfinal) > 0) {
        		foreach ($examenfinal as $value) {
        			$fecha_aprobacion = FechaHelper::getFechaImpresion($value->fecha_aprobacion);
        			$fecha_aprobacion = FechaHelper::getFechaParaGuardar($fecha_aprobacion);
        			$value->fecha_aprobacion = $fecha_aprobacion;
        		}

        		$inscripto = $examenfinal;
        	}
        }
        

        return Response::json($inscripto);
    }

    public function postObtenerexamenes() 
    {
        $carrera_id = Input::get('carrera_id');
        $planID = Input::get('planID');
        $materia_id = Input::get('materia_id');
        $turnoexamen_id = Input::get('cboTurnoExamen');
        //$alumnoid = Input::get('alumnoid');

        /*$asignaciones = AsignarDocente::whereRaw('carrera_id='. $carrera_id .' AND materia_id='. $materia_id . ' AND planestudio_id='. $planID)->first();

    	$personatitular = Docente::find($asignaciones->docentetitular_id)->persona_id;
    	$personaprovisorio = Docente::find($asignaciones->docenteprovisorio_id)->persona_id;
    	$personasuplente = Docente::find($asignaciones->docentesuplente_id)->persona_id;

    	$docentetitular_id = Persona::find($personatitular);
    	$docenteprovisorio_id = Persona::find($personaprovisorio);
    	$docentesuplente_id = Persona::find($personasuplente);

    	$docentetitular = $docentetitular_id->apellido .', '. $docentetitular_id->nombre;
    	$docenteprovisorio = $docenteprovisorio_id->apellido .', '. $docenteprovisorio_id->nombre;
    	$docentesuplente = $docentesuplente_id->apellido .', '. $docentesuplente_id->nombre;*/
    	///////////////
    	$docentes = '';
        $ciclolectivo_id = PlanEstudio::find($planID)->ciclolectivo_id;

        $mesaexamen = MesaExamen::whereRaw('carrera_id ='.$carrera_id.' AND ciclolectivo_id ='.$ciclolectivo_id.' AND materia_id ='.$materia_id.' AND turnoexamen_id ='.$turnoexamen_id)->get();

        if (count($mesaexamen) > 0) {
        	foreach ($mesaexamen as $value) {
	        	$docentesasig = TribunalDocente::whereRaw('mesaexamen_id ='. $value->id)->get();

	        	if (count($docentesasig) > 0) {
		        	foreach ($docentesasig as $docente) {
		        		$personatitular = Docente::find($docente->docente_id)->persona_id;

				    	$docentetitular_id = Persona::find($personatitular);

				    	$docentetitular = $docentetitular_id->apellido .', '. $docentetitular_id->nombre;

				    	$docentes .= $docentetitular . ' - ';
		        	}
		        }
	        }
        }
        
        $examenfinal = ExamenFinal::whereRaw('carrera_id ='.$carrera_id.' AND planestudio_id ='.$planID.' AND turnoexamen_id ='.$turnoexamen_id.' AND materia_id ='.$materia_id)->get();

        if (count($examenfinal) > 0) {
        	foreach ($examenfinal as $value) {
    			$alumnopersona = Alumno::find($value->alumno_id)->persona_id;
    			$personaalumno = Persona::find($alumnopersona);
    			$persona = $personaalumno->apellido .', '. $personaalumno->nombre;

	        	$fecha_aprobacion = FechaHelper::getFechaImpresion($value->fecha_aprobacion);
	        	$nombremateria = Materia::find($materia_id)->nombremateria;
	        	
	        	$materias[] = ['id' => $value->id, 'fecha_aprobacion' => $fecha_aprobacion, 'docentes' => $docentes, 'alumno' => $persona, 'nombremateria' => $nombremateria, 'calif_final_num' => $value->calif_final_num, 'calif_final_let' => $value->calif_final_let, 'folio' => $value->folio, 'libro' => $value->libro, 'acta' => $value->acta];
	        }
        } else {
        	$materias = [];
        }
        
        return Response::json($materias);
    }

    public function getEditar($id) 
    {
		$examenfinal = ExamenFinal::find($id);

		$alumno_id = $examenfinal->alumno_id;

        $examenfina = ExamenFinal::whereRaw('carrera_id='.$examenfinal->carrera_id.' AND materia_id='.$examenfinal->materia_id. ' AND planestudio_id='.$examenfinal->planestudio_id.' AND turnoexamen_id ='.$examenfinal->turnoexamen_id)->get();

        $inscripto = $examenfinal->inscripcionfinal_id;
        $nota = ['cero', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve', 'diez'];

        $carreras = Carrera::where('organizacion_id', '=', 1)->get();

        $planes = PlanEstudio::where('carrera_id', '=', $examenfinal->carrera_id)->get();
        
        $planID = $examenfinal->planestudio_id;
        $justifico = $examenfinal->justifico;

        //$materias = Materia::where('carrera_id', '=', $examenfinal->carrera_id)->where('planestudio_id', '=', $planID)->get();
        
        $ciclo_id = PlanEstudio::find($planID)->ciclolectivo_id;
        
        $materiaexamenfinal = MesaExamen::whereRaw('carrera_id ='.$examenfinal->carrera_id.' AND ciclolectivo_id ='.$ciclo_id.' AND materia_id ='.$examenfinal->materia_id.' AND turnoexamen_id ='.$examenfinal->turnoexamen_id)->get();
        $docentes = '';

        if (count($materiaexamenfinal) > 0) {
        	foreach ($materiaexamenfinal as $value) {
	        	$docentesasig = TribunalDocente::whereRaw('mesaexamen_id ='. $value->id)->get();

	        	if (count($docentesasig) > 0) {
		        	foreach ($docentesasig as $docente) {
		        		$personatitular = Docente::find($docente->docente_id)->persona_id;

				    	$docentetitular_id = Persona::find($personatitular);

				    	$docentetitular = $docentetitular_id->apellido .', '. $docentetitular_id->nombre;

				    	$docentes .= $docentetitular . ' - ';
		        	}
		        }

	        	$materiass = Materia::find($value->materia_id);

	        	$materias[] = ['id' => $materiass->id, 'nombremateria' => $materiass->nombremateria];
	        }
        }

        $nombremateria = Materia::find($examenfinal->materia_id)->nombremateria;
        
        $alumnoss = Alumno::getAlumnoPorAlumnoId($alumno_id);
		$alumnos = [];

        foreach ($alumnoss as $alumno) {
        	$apeynom = $alumno->apellido.', '.$alumno->nombre;
        	$nrodocumento = $alumno->nrodocumento;
        	$alumnos[] = ['alumno_id' => $alumno->alumno_id, 'apeynom' => $apeynom, 'nrodocumento' => $nrodocumento];
        }
        
		$materia_id = $examenfinal->materia_id;
		$carrera_id = $examenfinal->carrera_id;
		$fechadesde = FechaHelper::getFechaImpresion($examenfinal->fecha_aprobacion);

    	$porcions = explode("/", $fechadesde);
    	$fechadesdes = $porcions[2].'-'.$porcions[1].'-'.$porcions[0];
    
		$habilita = false;
        $organizaciones = Organizacion::lists('nombre', 'id');

        foreach ($examenfina as $value) {
	    	$alumnopersona = Alumno::find($value->alumno_id)->persona_id;

	    	$personaalumno = Persona::find($alumnopersona);

	    	$persona = $personaalumno->apellido .', '. $personaalumno->nombre;
			
            $fechareg = FechaHelper::getFechaImpresion($value->fecha_aprobacion);
            $value->fecha_aprobacion = $fechareg;
            $nombrematerias = Materia::find($value->materia_id)->nombremateria;
            $value->nombrematerias = $nombrematerias;
            $value->docentes = $docentes;
            $value->alumno = $persona;
        }

        $turnos = TurnoExamen::all();

        return View::make('examenfinal.nuevo',[
            'organizaciones'  	=> $organizaciones,
            'carrera_id'        => $carrera_id,
            'carreras'        	=> $carreras,
            'materia_id'        => $materia_id,
            'materias'        	=> $materias,
            'planID'     	  	=> $planID,
            'planes'          	=> $planes,
            'ciclo_id' 			=> $ciclo_id,
            'examenfina' 		=> $examenfina,
            'examenfinal' 		=> $examenfinal,
            'habilita' 			=> $habilita,
            'alumnos'       	=> $alumnos,
            'alumno_id'       	=> $alumno_id,
            'apeynom'       	=> $apeynom,
            'nrodocumento'      => $nrodocumento,
            'nombremateria'     => $nombremateria,
            'fechadesdes'       => $fechadesdes,
            'fechadesde'       	=> $fechadesde,
            'turnos'       		=> $turnos,
            'idaseguir'    		=> $id,
            'folio'       		=> $examenfinal->folio,
            'libro'       		=> $examenfinal->libro,
            'acta'       		=> $examenfinal->acta,
            'calif_final_num'   => $examenfinal->calif_final_num,
            'calif_final_let'   => $examenfinal->calif_final_let,
            'turnoexamen_id'    => $examenfinal->turnoexamen_id,
            'inscripto'			=> $inscripto,
            'nota'				=> $nota,
            'justifico'         => $justifico
        ])->with('menu', ModulosHelper::MENU_GESTION_ACADEMICA)
            ->with('submenu', ModulosHelper::SUBMENU_BOLETINES)
            ->with('submenu2', ModulosHelper::SUBMENU_2_EXAMENFINAL)
            ->with('leer', Session::get('BOLETIN_LEER'))
            ->with('editar', Session::get('BOLETIN_EDITAR'))
            ->with('imprimir', Session::get('BOLETIN_IMPRIMIR'))
            ->with('eliminar', Session::get('BOLETIN_ELIMINAR'));    
    }

    public function postGuardar()
    {   
    	$validator = Validator::make(
            array(
                'cboOrganizacion'   => Input::get('cboOrganizacion'),
                'cboCarrera'      	=> Input::get('cboCarrera'),
                'cboPlan'         	=> Input::get('cboPlan'),
                'cboMaterias'     	=> Input::get('cboMaterias'),
                'cboTurnoExamen'    => Input::get('cboTurnoExamen'),
                'alumno_id'       	=> Input::get('alumno_id'),
                'fechadesde'       	=> Input::get('fechadesde'),
                'libro'       		=> Input::get('libro'),
                'folio'   			=> Input::get('folio'),
                'acta'       		=> Input::get('acta'),
                'cbofinalnumero'    => Input::get('cbofinalnumero'),
                'inscripto'         => Input::get('inscripto')
            ),
            array(
                'cboCarrera'      	=> 'required',
                'cboPlan'         	=> 'required',
                'cboMaterias'     	=> 'required',
                'cboTurnoExamen'    => 'required',
                'alumno_id'       	=> 'required',
                'fechadesde'       	=> 'required',
                'libro'       		=> 'required',
                'folio'				=> 'required',
                'acta'       		=> 'required',
                'cbofinalnumero'    => 'required',
                'inscripto'         => 'required'
            ),
            array(
                'required' 		=> 'Campo Obligatorio',
                'required' 		=> 'Campo Obligatorio',
                'required' 		=> 'Campo Obligatorio',
                'required' 		=> 'Campo Obligatorio',
                'required' 		=> 'Campo Obligatorio',
                'required' 		=> 'Campo Obligatorio',
                'required' 		=> 'Campo Obligatorio',
                'required' 		=> 'Campo Obligatorio',
                'required' 		=> 'Campo Obligatorio',
                'required' 		=> 'Campo Obligatorio',
                'required'      => 'Campo Obligatorio'
            )
        );

        $organizacion_id = Input::get('cboOrganizacion');
        $carrera_id = Input::get('cboCarrera');
        $planID = Input::get('cboPlan');
        $materia_id = Input::get('cboMaterias');
        $turnoexamen_id = Input::get('cboTurnoExamen');
        $fechadesde = Input::get('fechadesde');
        $alumno_id = Input::get('alumno_id');
        $libro = Input::get('libro');
        $folio = Input::get('folio');
        $acta = Input::get('acta');
        $cbofinalnumero = Input::get('cbofinalnumero');
        //$cbofinalletra = Input::get('cbofinalletra');
        $observaciones = Input::get('observaciones');
        $inscripcionfinal_id = Input::get('inscripto');
        $asistencia = Input::get('asistencia');
        $justifico = Input::get('justifico');
        $nota = ['cero', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve', 'diez'];

        if ($justifico == NULL) {
            $justifico = 0;
        }

    	if ($fechadesde == '') {
    		$fechadesde = date('d/m/Y');
    	} else {
    		$porcion = explode("-", $fechadesde);
        	$fechadesde = $porcion[2].'/'.$porcion[1].'/'.$porcion[0];
        	//$fechadesde = FechaHelper::getFechaParaGuardar($fechadesdes);
    	}

        if ($validator->fails()) {
            Session::flash('message', 'ERROR AL INTENTAR GUARDAR EL EXAMEN FINAL.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('examenfinal/crear')
                ->withErrors($validator)
                ->withInput();
        } else {
            $fecha = FechaHelper::getFechaParaGuardar($fechadesde);
            //$cuatrimestre = Materia::find($materia_id)->cuatrimestre;

        	//$regularidades = Regularidades::whereRaw('carrera_id='.$carrera_id.' AND materia_id='.$materia_id. ' AND planestudio_id='.$planID.' AND alumno_id='.$alumno_id.' AND parcial='. $cboParcial)->first();
        	$examenfinal = ExamenFinal::whereRaw('carrera_id ='.$carrera_id.' AND planestudio_id ='.$planID.' AND turnoexamen_id ='.$turnoexamen_id.' AND materia_id ='.$materia_id.' AND alumno_id ='.$alumno_id.' AND inscripcionfinal_id ='.$inscripcionfinal_id)->first();

            if (count($examenfinal) > 0) {
                $examenfina = ExamenFinal::find($examenfinal->id);

                $examenfina->organizacion_id    = $organizacion_id;
                $examenfina->alumno_id         	= $alumno_id;
                $examenfina->planestudio_id    	= $planID;
                $examenfina->turnoexamen_id    	= $turnoexamen_id;
                $examenfina->materia_id        	= $materia_id;
                $examenfina->carrera_id        	= $carrera_id;
                $examenfina->libro      		= $libro;
                $examenfina->folio           	= $folio;
                $examenfina->acta      			= $acta;
                $examenfina->calif_final_num    = $cbofinalnumero;
                $examenfina->calif_final_let    = $nota[$cbofinalnumero];
                $examenfina->fecha_aprobacion 	= $fecha;
                $examenfina->observaciones      = $observaciones;
                $examenfina->inscripcionfinal_id = $inscripcionfinal_id;
                $examenfina->asistencia         = $asistencia;
                $examenfina->justifico          = $justifico;
                $examenfina->usuario_modi      	= Auth::user()->usuario;  
                $examenfina->fecha_modi        	= date('Y-m-d');
                
                $examenfina->save();

                $idaseguir = $examenfinal->id;
            } else {
            	$examenfina = new ExamenFinal();

                $examenfina->organizacion_id    = $organizacion_id;
                $examenfina->alumno_id     		= $alumno_id;
                $examenfina->planestudio_id  	= $planID;
                $examenfina->turnoexamen_id    	= $turnoexamen_id;
                $examenfina->materia_id    		= $materia_id;
                $examenfina->carrera_id 		= $carrera_id;
                $examenfina->libro				= $libro;
                $examenfina->folio 				= $folio;
                $examenfina->acta 				= $acta;
                $examenfina->calif_final_num 	= $cbofinalnumero;
                $examenfina->calif_final_let 	= $nota[$cbofinalnumero];
                $examenfina->fecha_aprobacion	= $fecha;
                $examenfina->observaciones 		= $observaciones;
                $examenfina->inscripcionfinal_id = $inscripcionfinal_id;
                $examenfina->asistencia         = $asistencia;
                $examenfina->justifico          = $justifico;
                $examenfina->usuario_alta   	= Auth::user()->usuario;  
                $examenfina->fecha_alta	   		= date('Y-m-d');
                
                $examenfina->save();

                $asigna = ExamenFinal::all();

                $examenfinal = $asigna->last();
                $idaseguir = $examenfinal->id;
            }


            Session::flash('message', 'LOS DATOS SE CARGARON CORRECTAMENTE!');
            Session::flash('message_type', self::OPERACION_EXITOSA);
            return Redirect::to('examenfinal/guardado/'.$idaseguir);
        }
        /*highlight_string(var_export($asistencia,true));
        exit();*/
    }

    public function getGuardado($idaseguir)
    {  
        $examenfinal = ExamenFinal::find($idaseguir);

        $folio = '';
        $libro = '';
        $acta = '';
        $calif_final_num = '';
        $calif_final_let = '';
        $nota = ['cero', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve', 'diez'];

        $examenfina = ExamenFinal::whereRaw('carrera_id='.$examenfinal->carrera_id.' AND materia_id='.$examenfinal->materia_id. ' AND planestudio_id='.$examenfinal->planestudio_id.' AND turnoexamen_id ='.$examenfinal->turnoexamen_id)->get();

        $inscripto = $examenfinal->inscripcionfinal_id;

        $carreras = Carrera::where('organizacion_id', '=', 1)->get();

        $planes = PlanEstudio::where('carrera_id', '=', $examenfinal->carrera_id)->get();
        
        $planID = $examenfinal->planestudio_id;
        $justifico = $examenfinal->justifico;

        //$materias = Materia::where('carrera_id', '=', $examenfinal->carrera_id)->where('planestudio_id', '=', $planID)->get();
        
        $ciclo_id = PlanEstudio::find($planID)->ciclolectivo_id;
        
        $materiaexamenfinal = MesaExamen::whereRaw('carrera_id ='.$examenfinal->carrera_id.' AND ciclolectivo_id ='.$ciclo_id.' AND materia_id ='.$examenfinal->materia_id.' AND turnoexamen_id ='.$examenfinal->turnoexamen_id)->get();
        $docentes = '';

        if (count($materiaexamenfinal) > 0) {
        	foreach ($materiaexamenfinal as $value) {
        		$docentesasig = TribunalDocente::whereRaw('mesaexamen_id ='. $value->id)->get();

	        	if (count($docentesasig) > 0) {
		        	foreach ($docentesasig as $docente) {
		        		$personatitular = Docente::find($docente->docente_id)->persona_id;

				    	$docentetitular_id = Persona::find($personatitular);

				    	$docentetitular = $docentetitular_id->apellido .', '. $docentetitular_id->nombre;

				    	$docentes .= $docentetitular . ' - ';
		        	}
		        }

	        	$materiass = Materia::find($value->materia_id);

	        	$materias[] = ['id' => $materiass->id, 'nombremateria' => $materiass->nombremateria];
	        }
        }

        $nombremateria = Materia::find($examenfinal->materia_id)->nombremateria;
        
        $alumnoss = Alumno::getAlumnoPorAlumnoId($examenfinal->alumno_id);
		$alumnos = [];

        foreach ($alumnoss as $alumno) {
        	$apeynom = $alumno->apellido.', '.$alumno->nombre;
        	$alumnos[] = ['alumno_id' => $alumno->alumno_id, 'apeynom' => $apeynom, 'nrodocumento' => $alumno->nrodocumento];
        }
        
		$materia_id = $examenfinal->materia_id;
		$carrera_id = $examenfinal->carrera_id;
		$fechadesde = FechaHelper::getFechaImpresion($examenfinal->fecha_aprobacion);

    	$porcions = explode("/", $fechadesde);
    	$fechadesdes = $porcions[2].'-'.$porcions[1].'-'.$porcions[0];
    
		$habilita = false;
        $organizaciones = Organizacion::lists('nombre', 'id');

        foreach ($examenfina as $value) {
	        $alumnopersona = Alumno::find($value->alumno_id)->persona_id;

	    	$personaalumno = Persona::find($alumnopersona);

	    	$persona = $personaalumno->apellido .', '. $personaalumno->nombre;
			
            $fechareg = FechaHelper::getFechaImpresion($value->fecha_aprobacion);
            $value->fecha_aprobacion = $fechareg;
            $nombrematerias = Materia::find($value->materia_id)->nombremateria;
            $value->nombrematerias = $nombrematerias;
            $value->docentes = $docentes;
            $value->alumno = $persona;
        }

        $turnos = TurnoExamen::all();

        return View::make('examenfinal.nuevo',[
            'organizaciones'  	=> $organizaciones,
            'carrera_id'        => $carrera_id,
            'carreras'        	=> $carreras,
            'materia_id'        => $materia_id,
            'materias'        	=> $materias,
            'planID'     	  	=> $planID,
            'planes'          	=> $planes,
            'ciclo_id' 			=> $ciclo_id,
            'examenfina' 		=> $examenfina,
            'examenfinal' 		=> $examenfinal,
            'habilita' 			=> $habilita,
            'alumnos'       	=> $alumnos,
            'nombremateria'     => $nombremateria,
            'fechadesdes'       => $fechadesdes,
            'fechadesde'       	=> $fechadesde,
            'turnos'       		=> $turnos,
            'idaseguir'    		=> $idaseguir,
            'folio'    			=> $folio,
            'libro'    			=> $libro,
            'acta'    			=> $acta,
            'calif_final_num'   => $calif_final_num,
            'calif_final_let'   => $calif_final_let,
            'turnoexamen_id'    => $examenfinal->turnoexamen_id,
            'inscripto'			=> $inscripto,
            'nota'				=> $nota,
            'justifico'         => $justifico
        ])->with('menu', ModulosHelper::MENU_GESTION_ACADEMICA)
            ->with('submenu', ModulosHelper::SUBMENU_BOLETINES)
            ->with('submenu2', ModulosHelper::SUBMENU_2_EXAMENFINAL)
            ->with('leer', Session::get('BOLETIN_LEER'))
            ->with('editar', Session::get('BOLETIN_EDITAR'))
            ->with('imprimir', Session::get('BOLETIN_IMPRIMIR'))
            ->with('eliminar', Session::get('BOLETIN_ELIMINAR'));
    }

    public function postBorrar()
    {
        $id = Input::get('idMateriaHidden');

        $examenfinal = ExamenFinal::findOrFail($id);

        $planID = $examenfinal->planestudio_id;
        $carrera_id = $examenfinal->carrera_id;
        $alumno_id = $examenfinal->alumno_id;
        $materia_id = $examenfinal->materia_id;
        $turnoexamen_id = $examenfinal->turnoexamen_id;

        $examenfinal->delete();

        $examenfinals = ExamenFinal::whereRaw('planestudio_id ='.$planID.' AND carrera_id ='.$carrera_id.' AND alumno_id ='.$alumno_id.' AND materia_id ='.$materia_id.' AND turnoexamen_id ='.$turnoexamen_id)->get();

        if (count($examenfinals) > 0) {
            foreach ($examenfinals as $value) {
                $idaseguir = $value->id;
            }

            Session::flash('message', 'EL REGISTRO HA SIDO BORRADO.');
            Session::flash('message_type', self::OPERACION_EXITOSA);
            return Redirect::to('examenfinal/guardado/'.$idaseguir);
        } else {
            Session::flash('message', 'EL REGISTRO HA SIDO BORRADO.');
            Session::flash('message_type', self::OPERACION_EXITOSA);
            return Redirect::to('examenfinal/crear');
        }
    }

    public function getImprimir()
    {
        $carrera_id = Input::get('carrera_id');
        $orgid =  Input::get('cboOrganizacion');
        $planID = Input::get('planID');
        $materia_id = Input::get('materia_id');
        $turnoexamen_id = Input::get('cboTurnoExamen');
        $dni = Input::get('txtalumno');

        $alumno_id = '';
        $nrodocumento = '';
        $alumnos = [];
        $apeynom = '';
        $domicilio = '';
        $condicion = '';
        $docentes = '';
        $nota = ['cero', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve', 'diez'];

        $planestudios = PlanEstudio::find($planID);

        $ciclolectivo_id = $planestudios->ciclolectivo_id;
        $cohorte = $planestudios->codigoplan;

        $mesaexamen = MesaExamen::whereRaw('carrera_id ='.$carrera_id.' AND ciclolectivo_id ='.$ciclolectivo_id.' AND materia_id ='.$materia_id.' AND turnoexamen_id ='.$turnoexamen_id)->get();

        if (count($mesaexamen) > 0) {
        	foreach ($mesaexamen as $value) {
        		$docentesasig = TribunalDocente::whereRaw('mesaexamen_id ='. $value->id)->get();

	        	if (count($docentesasig) > 0) {
		        	foreach ($docentesasig as $docente) {
		        		$personatitular = Docente::find($docente->docente_id)->persona_id;

				    	$docentetitular_id = Persona::find($personatitular);

				    	$docentetitular = $docentetitular_id->apellido .', '. $docentetitular_id->nombre;

				    	$docentes .= $docentetitular . ' - ';
		        	}
		        }

	        	$materiass = Materia::find($value->materia_id);

	        	$cbomaterias[] = ['id' => $materiass->id, 'nombremateria' => $materiass->nombremateria];
	        }
        } else {
        	$cbomaterias = [];
        }

        $carreras = Carrera::find($carrera_id);//where('organizacion_id', '=', $orgid)->get();

        $ciclolectivo_id = $planestudios->ciclolectivo_id;
        $cohorte = $planestudios->codigoplan;
        $nroresolucion = $planestudios->nroresolucion;

        if (!$dni == '') {
        	$alumnos = Alumno::getAlumnoPorDni($dni);
        }

        if (count($alumnos) > 0) {
        	$alumno_id = $alumnos[0]->alumno_id;
        	$nrodocumento = $alumnos[0]->nrodocumento;
        	$apeynom = $alumnos[0]->apellido.', '. $alumnos[0]->nombre;
        	$domicilio = $alumnos[0]->calle.' - '. $alumnos[0]->numero;

        	$examenfinal = ExamenFinal::whereRaw('carrera_id ='.$carrera_id.' AND planestudio_id ='.$planID.' AND turnoexamen_id ='.$turnoexamen_id.' AND materia_id ='.$materia_id.' AND alumno_id ='.$alumno_id)->get();
        } else {
        	$examenfinal = ExamenFinal::whereRaw('carrera_id ='.$carrera_id.' AND planestudio_id ='.$planID.' AND turnoexamen_id ='.$turnoexamen_id.' AND materia_id ='.$materia_id)->get();
        }

        if (count($examenfinal) > 0) {
        	foreach ($examenfinal as $value) {
        		$regularidades = Regularidades::whereRaw('planestudio_id ='.$planID.' AND carrera_id ='.$carrera_id.' AND materia_id ='.$materia_id.' AND alumno_id ='.$value->alumno_id)->get();

        		foreach ($regularidades as $regularidad) {
        			if ($regularidad->regularizo == 1) {
        				$condicion = 'Regular';
        			}
        		}

    			$alumnopersona = Alumno::find($value->alumno_id)->persona_id;
    			$personaalumno = Persona::find($alumnopersona);
    			$persona = $personaalumno->apellido .', '. $personaalumno->nombre;

	        	$fecha_aprobacion = FechaHelper::getFechaImpresion($value->fecha_aprobacion);
	        	$nombremateria = Materia::find($materia_id)->nombremateria;
	        	
	        	$materias[] = ['id' => $value->id, 'fecha_aprobacion' => $fecha_aprobacion, 'docentes' => $docentes, 'alumno' => $persona, 'nombremateria' => $nombremateria, 'calif_final_num' => $value->calif_final_num, 'calif_final_let' => $value->calif_final_let, 'folio' => $value->folio, 'libro' => $value->libro, 'acta' => $value->acta, 'observaciones' => $value->observaciones, 'nroresolucion' => $nroresolucion, 'condicion' => $condicion];
	        }
        } else {
        	$materias = [];
        }
        
        $turnos = TurnoExamen::all();

        $organizaciones = Organizacion::lists('nombre', 'id');
        $habilita = true;

        /*highlight_string(var_export($materias,true));
        exit;*/
        $pdf = PDF::loadView('informes.pdf.examenesfinales', [
            'materias'          =>  $materias,
            'cohorte'           =>  $cohorte,
            'carreras'          =>  $carreras->carrera,
            'nombremateria'     =>  $nombremateria,
            'nrodocumento'     	=>  $nrodocumento,
            'apeynom'     		=>  $apeynom,
            'domicilio'     	=>  $domicilio,
            'nota'     			=>  $nota]);
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
