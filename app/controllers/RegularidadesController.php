<?php

class RegularidadesController extends \BaseController {

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

		$habilita = false;

        return View::make('regularidades.listado')
            ->with('organizaciones', $organizaciones)
            ->with('habilita', $habilita)
            ->with('menu', ModulosHelper::MENU_GESTION_ACADEMICA)
            ->with('submenu', ModulosHelper::SUBMENU_BOLETINES)
            ->with('submenu2', ModulosHelper::SUBMENU_2_EXAMENPARCIAL)
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
        $docentes = [];//Docente::getListado();
        $habilita = false;
        $idaseguir = '';
        $dni = '';

        return View::make('regularidades.nuevo', array(
            'organizaciones' 	=> $organizaciones,
            'docentes' 			=> $docentes,
            'habilita' 			=> $habilita,
            'idaseguir' 		=> $idaseguir,
            'dni' 				=> $dni
        ))->with('menu', ModulosHelper::MENU_GESTION_ACADEMICA)
            ->with('submenu', ModulosHelper::SUBMENU_BOLETINES)
            ->with('submenu2', ModulosHelper::SUBMENU_2_EXAMENPARCIAL)
            ->with('leer', Session::get('BOLETIN_LEER'))
            ->with('editar', Session::get('BOLETIN_EDITAR'))
            ->with('imprimir', Session::get('BOLETIN_IMPRIMIR'))
            ->with('eliminar', Session::get('BOLETIN_ELIMINAR'));
    }

    public function postObtenerregularidades() 
    {
        $carrera_id = Input::get('carrera_id');
        $planID = Input::get('planID');
        $materia_id = Input::get('materia_id');
        $alumnoid = Input::get('alumnoid');
        $ciclo_id = Input::get('cboCiclos');

        if ($alumnoid == '') {
            if ($ciclo_id == '') {
        	   $regularidades = Regularidades::whereRaw('planestudio_id ='.$planID.' AND carrera_id ='.$carrera_id.' AND materia_id ='.$materia_id)->get();
            } else {
                $regularidades = Regularidades::whereRaw('planestudio_id ='.$planID.' AND carrera_id ='.$carrera_id.' AND materia_id ='.$materia_id.' AND ciclolectivo_id ='.$ciclo_id)->get();
            }

			$alumnos = [];
			$materias = [];

        	if (count($regularidades) > 0) {
        		foreach ($regularidades as $regularidad) {
					array_push($alumnos, $regularidad->alumno_id);
				}

				$resultado = array_unique($alumnos);
				sort($resultado);

				foreach ($resultado as $resultad) {
                    ///////////////////////////////////////////////////////
                    $fechainicio = '';
                    $fechafin = '';

                    $porcentaje_asistencia = AsistenciaHelper::getAsistenciaporcentaje($carrera_id, $planID, $materia_id, $resultad, $ciclo_id);
                    ///////////////////////////////////////////////////////
					$alumnoss = Alumno::getAlumnoPorAlumnoId($resultad);

			        foreach ($alumnoss as $alumno) {
			        	$apeynom = $alumno->apellido.', '.$alumno->nombre;
			        	$regularidade = Regularidades::whereRaw('planestudio_id ='.$planID.' AND carrera_id ='.$carrera_id.' AND alumno_id ='.$alumno->alumno_id.' AND materia_id ='.$materia_id.' AND ciclolectivo_id ='.$ciclo_id)->get();

                        if (count($regularidade) > 0) {
                            foreach ($regularidade as $regularidad) {
                                $fecha = FechaHelper::getFechaImpresion($regularidad->fecha_regularidad);
                                $regularidad->fecha_regularidad = $fecha;
                            }
                        }

			        	$materias[] = ['alumno' => $apeynom, 'regularidad' => $regularidade, 'porcentaje_asistencia' => $porcentaje_asistencia];
			        }
				}
        	}
        } else {
	        ///////////////////////////////////////////////////////
            $fechainicio = '';
            $fechafin = '';

            $porcentaje_asistencia = AsistenciaHelper::getAsistenciaporcentaje($carrera_id, $planID, $materia_id, $alumnoid, $ciclo_id);
            ///////////////////////////////////////////////////////
            $countalumnoins = InscripcionMateria::whereRaw('planestudio_id ='.$planID.' AND carrera_id ='.$carrera_id.' AND alumno_id ='.$alumnoid.' AND materia_id ='.$materia_id)->get();

	        if (count($countalumnoins) > 0) {
	        	$materias = Regularidades::whereRaw('planestudio_id ='.$planID.' AND carrera_id ='.$carrera_id.' AND alumno_id ='.$alumnoid.' AND materia_id ='.$materia_id.' AND ciclolectivo_id ='.$ciclo_id)->get();

	        	if (count($materias) > 0) {
	        		foreach ($materias as $value) {
	        			$fecha = FechaHelper::getFechaImpresion($value->fecha_regularidad);
	        			$value->fecha_regularidad = $fecha;
                        $promocional = 0;
	        			$materiainfo = Materia::find($value->materia_id);

                        $promocions = RegularPromocion::whereRaw('carrera_id='.$carrera_id.' AND materia_id='.$value->materia_id.' AND planestudio_id='.$planID.' AND ciclolectivo_id='.$ciclo_id)->first();

                        if (count($promocions) > 0) {
                            if ($promocions->promocional == 1) {
                                $promocional = $promocions->promocional;
                            } else {
                                $promocional = 0;
                            }
                        }
                        
                        $value->promocional = $promocional;
                        $nombremateria = $materiainfo->nombremateria;
	        			$value->nombremateria = $nombremateria;
                        $value->porcentaje_asistencia = $porcentaje_asistencia;
	        		}
	        	} else {
	        		$materias = 1;
	        	}
	        } else {
	        	$materias = 0;
	        }
	    }
        /*highlight_string(var_export($materias,true));
        exit();*/
        return Response::json($materias);
    }

    public function postObtenermaterias() 
    {
        $carrid = Input::get('carrera_id');
        $planID = Input::get('plan_id');
        $ciclo_id = Input::get('ciclo_id');
        $materia_id = Input::get('materia_id');

        if ($materia_id == '') {
            $materias = Materia::where('carrera_id', '=', $carrid)->where('planestudio_id', '=', $planID)->get();
        } else {
            $materias = Materia::find($materia_id)->periodo;
        }
        
        return Response::json($materias);
    }

    public function postObtenerregularpromocion()
    {
        $carrera_id = Input::get('carrera_id');
        $planID = Input::get('plan_id');
        $ciclo_id = Input::get('ciclo_id');
        $materia_id = Input::get('materia_id');

        $promocional = 0;
        $promocions = RegularPromocion::whereRaw('carrera_id='.$carrera_id.' AND materia_id='.$materia_id.' AND planestudio_id='.$planID.' AND ciclolectivo_id='.$ciclo_id)->first();

        if (count($promocions) > 0) {
            if ($promocions->promocional == 1) {
                $promocional = $promocions->promocional;
            } else {
                $promocional = 0;
            }
        }

        return Response::json($promocional);
    }

    public function postObtenerpromocion() 
    {
        $carrera_id = Input::get('carrera_id');
        $planestudio_id = Input::get('planID');
        $materia_id = Input::get('materia_id');
        $alumno_id = Input::get('alumnoid');
        $regularizo = Input::get('regularizo');

        $materiainfo = Materia::find($materia_id);

        $regularidades = Regularidades::whereRaw('carrera_id='.$carrera_id.' AND materia_id='.$materia_id.' AND planestudio_id='.$planestudio_id.' AND alumno_id='.$alumno_id)->get();

        $can_parcial = count($regularidades);
        $aprobado = 0;
        $desaprobado = 0;
        $materias = 0;

        if ($regularizo == 3) {
            if ($can_parcial > 0) {
                foreach ($regularidades as $value) {
                    if ($materiainfo->periodo == 'Anual') {
                        if ($can_parcial == 2) {
                            if ($value->nota > 7) {
                                $aprobado = 1;
                            } else {
                                $desaprobado = 1;
                            }
                        }
                    }

                    if ($materiainfo->periodo == 'Cuatrimestral') {
                        if ($can_parcial == 1) {
                            if ($value->nota > 7) {
                                $aprobado = 1;
                            } else {
                                $desaprobado = 1;
                            }
                        }
                    }
                }

                if ($desaprobado == 1) {
                    $materias = 0;
                } else {
                    $materias = 1;
                }
            }
        }

        if ($regularizo == 1) {
            if ($can_parcial > 0) {
                foreach ($regularidades as $value) {
                    if ($materiainfo->periodo == 'Anual') {
                        if ($can_parcial == 2) {
                            if ($value->calificacion == 1) {
                                $aprobado = 1;
                            } else {
                                $desaprobado = 1;
                            }
                        }
                    }

                    if ($materiainfo->periodo == 'Cuatrimestral') {
                        if ($can_parcial == 1) {
                            if ($value->calificacion == 1) {
                                $aprobado = 1;
                            } else {
                                $desaprobado = 1;
                            }
                        }
                    }
                }

                if ($desaprobado == 1) {
                    $materias = 0;
                } else {
                    $materias = 1;
                }
            }
        }

        return Response::json($materias);
    }

    public function getEditar($idaseguir)
    {  
        $regularidad = Regularidades::find($idaseguir);

        $regularidades = Regularidades::whereRaw('carrera_id='.$regularidad->carrera_id.' AND materia_id='.$regularidad->materia_id.' AND planestudio_id='.$regularidad->planestudio_id.' AND alumno_id='.$regularidad->alumno_id)->get();

        foreach ($regularidades as $regularidade) {
        	$fecha = FechaHelper::getFechaImpresion($regularidade->fecha_regularidad);
        	$regularidade->fecha_regularidad = $fecha;
        }

        $carreras = Carrera::where('organizacion_id', '=', 1)->get();
        $planes = PlanEstudio::where('carrera_id', '=', $regularidad->carrera_id)->get();
        
        $planID = $regularidad->planestudio_id;
        $parcial = $regularidad->parcial;

        $materias = Materia::where('carrera_id', '=', $regularidad->carrera_id)->where('planestudio_id', '=', $planID)->get();
        $docente_id = AsignarDocente::whereRaw('carrera_id='.$regularidad->carrera_id.' AND materia_id='.$regularidad->materia_id. ' AND planestudio_id='.$regularidad->planestudio_id)->first()->docentetitular_id;

        $materiainfo = Materia::find($regularidad->materia_id);
        $nombremateria = $materiainfo->nombremateria;
        $promocional = $materiainfo->promocional;
        $asignaciones = AsignarDocente::whereRaw('carrera_id='.$regularidad->carrera_id.' AND materia_id='.$regularidad->materia_id.' AND planestudio_id='.$regularidad->planestudio_id)->get();

        foreach ($asignaciones as $asignacione) {
            $docente = Docente::find($asignacione->docentetitular_id);
            $docent = Persona::where('id', '=', $docente->persona_id)->first();
            $apeynomt = $docent->apellido.', '.$docent->nombre;

            $docente = Docente::find($asignacione->docenteprovisorio_id);
            $docent = Persona::where('id', '=', $docente->persona_id)->first();
            $apeynomp = $docent->apellido.', '.$docent->nombre;

            $docente = Docente::find($asignacione->docentesuplente_id);
            $docent = Persona::where('id', '=', $docente->persona_id)->first();
            $apeynoms = $docent->apellido.', '.$docent->nombre;

            $docentes[] = ['idt' => $asignacione->docentetitular_id, 'apeynomt' => $apeynomt, 'idp' => $asignacione->docenteprovisorio_id, 'apeynomp' => $apeynomp, 'ids' => $asignacione->docentesuplente_id, 'apeynoms' => $apeynoms];
        }

        $alumnoss = Alumno::getAlumnoPorAlumnoId($regularidad->alumno_id);
		$alumnos = [];

        foreach ($alumnoss as $alumno) {
        	$apeynom = $alumno->apellido.', '.$alumno->nombre;
        	$alumnos[] = ['alumno_id' => $alumno->alumno_id, 'apeynom' => $apeynom, 'nrodocumento' => $alumno->nrodocumento];
        }
        
        $ciclos = CicloLectivo::all();
        $ciclo_id = $regularidad->ciclolectivo_id;//PlanEstudio::find($planID)->ciclolectivo_id;
        
        
		$materia_id = $regularidad->materia_id;
		$carrera_id = $regularidad->carrera_id;
		$fechadesde = FechaHelper::getFechaImpresion($regularidad->fecha_regularidad);

    	$porcions = explode("/", $fechadesde);
    	$fechadesdes = $porcions[2].'-'.$porcions[1].'-'.$porcions[0];
    
		$habilita = false;
        $organizaciones = Organizacion::lists('nombre', 'id');

        return View::make('regularidades.editar',[
            'idaseguir'  		=> $idaseguir,
            'organizaciones'  	=> $organizaciones,
            'carrera_id'        => $regularidad->carrera_id,
            'carreras'        	=> $carreras,
            'materia_id'        => $regularidad->materia_id,
            'materias'        	=> $materias,
            'planID'     	  	=> $planID,
            'planes'          	=> $planes,
            'docente_id'        => $docente_id,
            'docentes'          => $docentes,
            'ciclo_id' 			=> $ciclo_id,
            'ciclos'            => $ciclos,
            'regularidad'       => $regularidad,
            'regularidades' 	=> $regularidades,
            'habilita' 			=> $habilita,
            'alumnos'       	=> $alumnos,
            'nombremateria'     => $nombremateria,
            'parcial'     		=> $parcial,
            'fechadesdes'       => $fechadesdes,
            'fechadesde'       	=> $fechadesde,
            'promocional'       => $promocional
        ])->with('menu', ModulosHelper::MENU_GESTION_ACADEMICA)
            ->with('submenu', ModulosHelper::SUBMENU_BOLETINES)
            ->with('submenu2', ModulosHelper::SUBMENU_2_EXAMENPARCIAL)
            ->with('leer', Session::get('BOLETIN_LEER'))
            ->with('editar', Session::get('BOLETIN_EDITAR'))
            ->with('imprimir', Session::get('BOLETIN_IMPRIMIR'))
            ->with('eliminar', Session::get('BOLETIN_ELIMINAR'));
    }

    public function postObtenerparcial() 
    {
        $carrera_id = Input::get('carrera_id');
        $planestudio_id = Input::get('planID');
        $materia_id = Input::get('materia_id');
        $alumnoid = Input::get('alumno_id');
        $cboParcial = Input::get('cboParcial');
        $parcial = 0;

    	$regularidades = Regularidades::whereRaw('carrera_id='.$carrera_id.' AND materia_id='.$materia_id. ' AND planestudio_id='.$planestudio_id.' AND alumno_id='.$alumnoid)->get();
		
		foreach ($regularidades as $regularidad) {
			if ($cboParcial == $regularidad->parcial) {
				$parcial = 1;
			}
		}
		
        return Response::json($parcial);
    }

    public function postObtenerregularidad() 
    {
        $carrera_id = Input::get('carrera_id');
        $planestudio_id = Input::get('planID');
        $materia_id = Input::get('materia_id');
        $alumnoid = Input::get('alumno_id');
        $cboParcial = Input::get('cboParcial');
        $calificacion = 0;

        $regularidades = Regularidades::whereRaw('carrera_id='.$carrera_id.' AND materia_id='.$materia_id. ' AND planestudio_id='.$planestudio_id.' AND alumno_id='.$alumnoid)->get();
        
        if (count($regularidades) > 0) {
            foreach ($regularidades as $value) {
                if ($cboParcial == 2) {
                    if ($value->parcial == 1) {
                        if ($value->calificacion == 3 || $value->calificacion == 2) {
                            $calificacion = 0;
                        } else {
                            $calificacion = 1;
                        }
                    }
                }

                if ($cboParcial == 3) {
                    if ($value->parcial == 2) {
                        if ($value->calificacion == 3 || $value->calificacion == 2) {
                            $calificacion = 0;
                        } else {
                            $calificacion = 1;
                        }
                    }
                }
            }
        }

        if (count($regularidades) > 1) {
            $calificacion = 1;
        }
        
        return Response::json($calificacion);
    }

    public function postObtenerfechaparcial() 
    {
        $carrera_id = Input::get('carrera_id');
        $planestudio_id = Input::get('planID');
        $materia_id = Input::get('materia_id');
        $alumnoid = Input::get('alumno_id');
        $cboParcial = Input::get('cboParcial');
        $fechadesde = Input::get('fechadesde');//2017-11-23
        $parcial = 0;

        $porcion = explode("-", $fechadesde);
        $fechadesdes = $porcion[2].'/'.$porcion[1].'/'.$porcion[0];

        $regularidades = Regularidades::whereRaw('carrera_id='.$carrera_id.' AND materia_id='.$materia_id. ' AND planestudio_id='.$planestudio_id.' AND alumno_id='.$alumnoid)->get();
        
        if (count($regularidades) > 0) {
            foreach ($regularidades as $value) {
                $fecha = FechaHelper::getFechaImpresion($value->fecha_regularidad);//23/11/2017
                
                if ($fechadesdes == $fecha) {
                    $parcial = 1;
                }
            }
        }

        return Response::json($parcial);
    }

    public function postGuardar()
    {   
    	$validator = Validator::make(
            array(
                'cboCarrera'      	=> Input::get('cboCarrera'),
                'cboPlan'         	=> Input::get('cboPlan'),
                'cboMaterias'     	=> Input::get('cboMaterias'),
                'cboDocente'      	=> Input::get('cboDocente'),
                'alumno_id'       	=> Input::get('alumno_id'),
                'fechadesde'       	=> Input::get('fechadesde'),
                'cboParcial'       	=> Input::get('cboParcial'),
                'cboCalificacion'   => Input::get('cboCalificacion'),
                'cboCiclos'         => Input::get('cboCiclos')
            ),
            array(
                'cboCarrera'      	=> 'required',
                'cboPlan'         	=> 'required',
                'cboMaterias'     	=> 'required',
                'cboDocente'      	=> 'required',
                'alumno_id'       	=> 'required',
                'fechadesde'       	=> 'required',
                'cboParcial'       	=> 'required',
                'cboCalificacion'	=> 'required',
                'cboCiclos'         => 'required'
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
                'required'      => 'Campo Obligatorio'
            )
        );

        $orgid = Input::get('cboOrganizacion');
        $carrera_id = Input::get('cboCarrera');
        $planID = Input::get('cboPlan');
        $ciclo_id = Input::get('cboCiclos');
        $materia_id = Input::get('cboMaterias');
        $docente_id = Input::get('cboDocente');
        $fechadesde = Input::get('fechadesde');
        $alumno_id = Input::get('alumno_id');
        $cboParcial = Input::get('cboParcial');
        $cboCalificacion = Input::get('cboCalificacion');
        $cboNota = Input::get('cboNota');
        $cboRegularizo = Input::get('cboRegularizo');
        $cboRecuperatorio = Input::get('cboRecuperatorio');
        $observaciones = Input::get('observaciones');

        if ($cboCalificacion == NULL) {
            $cboCalificacion = 0;
        }

        if ($cboNota == NULL) {
            $cboNota = 0;
        }

        if ($cboRecuperatorio == 0) {
        	$cboRecuperatorio = '';
            if ($cboParcial == 0) {
                Session::flash('message', 'ERROR AL INTENTAR GUARDAR LAS REGULARIDADES DEBE SELECCIONAR PARCIAL.');
                Session::flash('message_type', self::OPERACION_FALLIDA);
                return Redirect::to('regularidades/crear')
                    ->withErrors($validator)
                    ->withInput();
            }
        } else {
            $cboParcial = 0;
        }

    	if ($fechadesde == '') {
    		$fechadesde = date('d/m/Y');
    	} else {
    		$porcion = explode("-", $fechadesde);
        	$fechadesde = $porcion[2].'/'.$porcion[1].'/'.$porcion[0];
        	//$fechadesde = FechaHelper::getFechaParaGuardar($fechadesdes);
    	}

        if ($validator->fails()) {
            Session::flash('message', 'ERROR AL INTENTAR GUARDAR LAS REGULARIDADES.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('regularidades/crear')
                ->withErrors($validator)
                ->withInput();
        } else {
            /////////////////////////////CONSULTO ULTIMO PARCIAL
            $materiainfo = Materia::find($materia_id);

            $regularidades = Regularidades::whereRaw('carrera_id='.$carrera_id.' AND materia_id='.$materia_id.' AND planestudio_id='.$planID.' AND alumno_id='.$alumno_id)->get();

            $promocion = 0;
            $promocions = RegularPromocion::whereRaw('carrera_id='.$carrera_id.' AND materia_id='.$materia_id.' AND planestudio_id='.$planID.' AND ciclolectivo_id='.$ciclo_id)->first();

            if (count($promocions) > 0) {
                if ($promocions->promocional == 1) {
                    $promocion = $promocions->promocional;
                } else {
                    $promocion = 0;
                }
            }

            $can_parcial = count($regularidades);
            $aprobado = 0;
            $desaprobado = 0;
            $materias = 0;

            if ($promocion == 1) {
                if ($can_parcial > 0) {
                    foreach ($regularidades as $value) {
                        if ($materiainfo->periodo == 'Anual') {
                            if ($can_parcial == 2) {
                                if ($value->nota > 7) {
                                    $aprobado = 1;
                                } else {
                                    $desaprobado = 1;
                                }
                            }
                        }

                        if ($materiainfo->periodo == 'Cuatrimestral') {
                            if ($can_parcial == 1) {
                                if ($value->nota > 7) {
                                    $aprobado = 1;
                                } else {
                                    $desaprobado = 1;
                                }
                            }
                        }
                    }

                    if ($desaprobado == 1) {
                        $materias = 0;
                    } else {
                        $materias = 1;
                    }
                }
            }

            if ($promocion == 0) {
                if ($can_parcial > 0) {
                    foreach ($regularidades as $regularidad) {
                        if ($materiainfo->periodo == 'Anual') {
                            if ($can_parcial == 2) {
                                if ($regularidad->calificacion == 1) {
                                    $aprobado = 1;
                                } else {
                                    $desaprobado = 1;
                                }
                            }
                        }

                        if ($materiainfo->periodo == 'Cuatrimestral') {
                            if ($can_parcial == 1) {
                                if ($regularidad->calificacion == 1) {
                                    $aprobado = 1;
                                } else {
                                    $desaprobado = 1;
                                }
                            }
                        }
                    }

                    if ($desaprobado == 1) {
                        $materias = 0;
                    } else {
                        $materias = 1;
                    }
                }
            }

            if ($materias == 1) {
                $asistencias = AsistenciaHelper::getAsistenciaporcentaje($carrera_id, $planID, $materia_id, $alumno_id, $ciclo_id);

                if (count($asistencias) > 0) {
                    if ($asistencias < 80) {
                        if ($cboRegularizo == 1) {
                            Session::flash('message', 'ERROR AL INTENTAR GUARDAR, NO CUMPLE CON EL PORCENTAJE DE ASISTENCIAS EN LA MATERIA.');
                            Session::flash('message_type', self::OPERACION_FALLIDA);
                            return Redirect::to('regularidades/crear')
                                ->withErrors($validator)
                                ->withInput();
                        }

                        if ($cboRegularizo == 3) {
                            Session::flash('message', 'ERROR AL INTENTAR GUARDAR, NO CUMPLE CON EL PORCENTAJE DE ASISTENCIAS EN LA MATERIA.');
                            Session::flash('message_type', self::OPERACION_FALLIDA);
                            return Redirect::to('regularidades/crear')
                                ->withErrors($validator)
                                ->withInput();
                        }
                    }
                }
            }

            /////////////////////////////

            $fecha = FechaHelper::getFechaParaGuardar($fechadesde);
            $cuatrimestre = Materia::find($materia_id)->cuatrimestre;

        	$regularidades = Regularidades::whereRaw('carrera_id='.$carrera_id.' AND materia_id='.$materia_id. ' AND planestudio_id='.$planID.' AND alumno_id='.$alumno_id.' AND parcial='. $cboParcial)->first();

            if (count($regularidades) > 0) {
                $regularidad = Regularidades::find($regularidades->id);

                $regularidad->alumno_id         = $alumno_id;
                $regularidad->planestudio_id    = $planID;
                $regularidad->ciclolectivo_id   = $ciclo_id;
                $regularidad->materia_id        = $materia_id;
                $regularidad->carrera_id        = $carrera_id;
                $regularidad->cuatrimestre      = $cuatrimestre;
                $regularidad->fecha_regularidad = $fecha;
                $regularidad->parcial           = $cboParcial;
                $regularidad->calificacion      = $cboCalificacion;
                $regularidad->nota              = $cboNota;
                $regularidad->recuperatorio     = $cboRecuperatorio;
                $regularidad->regularizo        = $cboRegularizo;
                $regularidad->observaciones     = $observaciones;
                $regularidad->usuario_modi      = Auth::user()->usuario;  
                $regularidad->fecha_modi        = date('Y-m-d');
                
                $regularidad->save();

                $idaseguir = $regularidades->id;
            } else {
            	$regularidad = new Regularidades();

                $regularidad->alumno_id     	= $alumno_id;
                $regularidad->planestudio_id  	= $planID;
                $regularidad->ciclolectivo_id   = $ciclo_id;
                $regularidad->materia_id    	= $materia_id;
                $regularidad->carrera_id 		= $carrera_id;
                $regularidad->cuatrimestre		= $cuatrimestre;
                $regularidad->fecha_regularidad	= $fecha;
                $regularidad->parcial 			= $cboParcial;
                $regularidad->calificacion 		= $cboCalificacion;
                $regularidad->nota 				= $cboNota;
                $regularidad->recuperatorio 	= $cboRecuperatorio;
                $regularidad->regularizo 		= $cboRegularizo;
                $regularidad->observaciones     = $observaciones;
                $regularidad->usuario_alta   	= Auth::user()->usuario;  
                $regularidad->fecha_alta	   	= date('Y-m-d');
                
                $regularidad->save();

                $asigna = Regularidades::all();

                $regularidades = $asigna->last();
                $idaseguir = $regularidades->id;
            }


            Session::flash('message', 'LOS DATOS SE CARGARON CORRECTAMENTE!');
            Session::flash('message_type', self::OPERACION_EXITOSA);
            return Redirect::to('regularidades/guardado/'.$idaseguir);
        }
        /*highlight_string(var_export($asistencia,true));
        exit();*/
    }

    public function getGuardado($idaseguir)
    {  
        $regularidad = Regularidades::find($idaseguir);

        $regularidades = Regularidades::whereRaw('carrera_id='.$regularidad->carrera_id.' AND materia_id='.$regularidad->materia_id. ' AND planestudio_id='.$regularidad->planestudio_id.' AND alumno_id='.$regularidad->alumno_id)->get();

        $carreras = Carrera::where('organizacion_id', '=', 1)->get();
        $planes = PlanEstudio::where('carrera_id', '=', $regularidad->carrera_id)->get();
        
        $planID = $regularidad->planestudio_id;

        $materias = Materia::where('carrera_id', '=', $regularidad->carrera_id)->where('planestudio_id', '=', $planID)->get();
        $docente_id = AsignarDocente::whereRaw('carrera_id='.$regularidad->carrera_id.' AND materia_id='.$regularidad->materia_id. ' AND planestudio_id='.$regularidad->planestudio_id)->first()->docentetitular_id;

        $materia = Materia::find($regularidad->materia_id);
        $nombremateria = $materia->nombremateria;

        if ($materia->periodo == 'Anual') {
            $parcial = 3;
        } else {
            $parcial = 2;
        }

        $ciclos = CicloLectivo::all();
        $ciclo_id = $regularidad->ciclolectivo_id;//PlanEstudio::find($planID)->ciclolectivo_id;
        
        $promocional = 0;
        $promocions = RegularPromocion::whereRaw('carrera_id='.$regularidad->carrera_id.' AND materia_id='.$regularidad->materia_id.' AND planestudio_id='.$planID.' AND ciclolectivo_id='.$ciclo_id)->first();

        if (count($promocions) > 0) {
            if ($promocions->promocional == 1) {
                $promocional = $promocions->promocional;
            } else {
                $promocional = 0;
            }
        }

        $docente = Docente::find($docente_id);
        $docent = Persona::where('id', '=', $docente->persona_id)->first();
        $apeynom = $docent->apellido.', '.$docent->nombre;
        $docentes[] = ['id' => $docente->id, 'apeynom' => $apeynom];

        $alumnoss = Alumno::getAlumnoPorAlumnoId($regularidad->alumno_id);
		$alumnos = [];

        foreach ($alumnoss as $alumno) {
        	$apeynom = $alumno->apellido.', '.$alumno->nombre;
        	$alumnos[] = ['alumno_id' => $alumno->alumno_id, 'apeynom' => $apeynom, 'nrodocumento' => $alumno->nrodocumento];
        }
        
		$materia_id = $regularidad->materia_id;
		$carrera_id = $regularidad->carrera_id;
		$fechadesde = FechaHelper::getFechaImpresion($regularidad->fecha_regularidad);

    	$porcions = explode("/", $fechadesde);
    	$fechadesdes = $porcions[2].'-'.$porcions[1].'-'.$porcions[0];
    
		$habilita = false;
        $organizaciones = Organizacion::lists('nombre', 'id');

        foreach ($regularidades as $value) {
            $fechareg = FechaHelper::getFechaImpresion($value->fecha_regularidad);
            $value->fecha_regularidad = $fechareg;
            $value->promocional = $promocional;
        }

        return View::make('regularidades.nuevo',[
            'organizaciones'  	=> $organizaciones,
            'carrera_id'        => $regularidad->carrera_id,
            'carreras'        	=> $carreras,
            'materia_id'        => $regularidad->materia_id,
            'materias'        	=> $materias,
            'planID'     	  	=> $planID,
            'planes'          	=> $planes,
            'docente_id'        => $docente_id,
            'docentes'          => $docentes,
            'ciclo_id' 			=> $ciclo_id,
            'ciclos'            => $ciclos,
            'regularidades' 	=> $regularidades,
            'habilita' 			=> $habilita,
            'alumnos'       	=> $alumnos,
            'nombremateria'     => $nombremateria,
            'fechadesdes'       => $fechadesdes,
            'fechadesde'       	=> $fechadesde,
            'parcial'           => $parcial,
            'promocional'       => $promocional
        ])->with('menu', ModulosHelper::MENU_GESTION_ACADEMICA)
            ->with('submenu', ModulosHelper::SUBMENU_BOLETINES)
            ->with('submenu2', ModulosHelper::SUBMENU_2_EXAMENPARCIAL)
            ->with('leer', Session::get('BOLETIN_LEER'))
            ->with('editar', Session::get('BOLETIN_EDITAR'))
            ->with('imprimir', Session::get('BOLETIN_IMPRIMIR'))
            ->with('eliminar', Session::get('BOLETIN_ELIMINAR'));
    }

    public function getImprimir()
    {
        $carrera_id = Input::get('carrera_id');
        $planID = Input::get('planID');
        $materia_id = Input::get('materia_id');
        $docente_id = Input::get('docente_id');

        $regularidades = Regularidades::whereRaw('planestudio_id ='.$planID.' AND carrera_id ='.$carrera_id.' AND materia_id ='.$materia_id)->get();
        $alumnos = [];
        $materias = [];

            if (count($regularidades) > 0) {
                foreach ($regularidades as $regularidad) {
                    array_push($alumnos, $regularidad->alumno_id);
                }

                $resultado = array_unique($alumnos);
                sort($resultado);

                foreach ($resultado as $resultad) {
                    ///////////////////////////////////////////////////////
                    $fechainicio = '';
                    $fechafin = '';

                    $materiass = Materia::find($materia_id);
                    
                    if ($materiass->periodo == 'Anual') {
                        $ciclo_id = PlanEstudio::find($planID)->ciclolectivo_id;

                        $ciclos = CicloLectivo::find($ciclo_id);
                        $fechaini = FechaHelper::getFechaImpresion($ciclos->fechainicio);
                        $fechafi = FechaHelper::getFechaImpresion($ciclos->fechafin);

                        $fechainicio = $fechaini;
                        $fechafin = $fechafi;
                    } else {
                        $cuatri = $materiass->cuatrimestre;
                        $ciclo_id = PlanEstudio::find($planID)->ciclolectivo_id;

                        $ciclos = PeriodoLectivo::whereRaw('ciclolectivo_id ='. $ciclo_id)->get();

                        if (count($ciclos) > 0) {
                            foreach ($ciclos as $value) {
                                $fechainic = FechaHelper::getFechaImpresion($value->fechainicio);
                                $fechafic = FechaHelper::getFechaImpresion($value->fechafin);
                                $fechaini = FechaHelper::getFechaParaGuardar($fechainic);
                                $fechafi = FechaHelper::getFechaParaGuardar($fechafic);

                                if ($cuatri == 1) {
                                    if ($value->descripcion == '1 Cuatrimestre') {
                                        $fechainicio = $fechainic;
                                        $fechafin = $fechafic;
                                    }
                                }

                                if ($cuatri == 2) {
                                    if ($value->descripcion == '2 Cuatrimestre') {
                                        $fechainicio = $fechainic;
                                        $fechafin = $fechafic;
                                    }
                                }
                            }
                        } else {
                            $fechainicio = '';
                            $fechafin = '';
                        }
                    }
                    
                    if (!$fechainicio == '') {
                        $porcion = explode("/", $fechainicio);
                        $fecha_inicial = $porcion[2].'-'.$porcion[1].'-'.$porcion[0];
                        $porcion = explode("/", $fechafin);
                        $fecha_final = $porcion[2].'-'.$porcion[1].'-'.$porcion[0];
                    }
                    ////////////////////////////////
                    $luness = '';
                    $martess = '';
                    $miercoless = '';
                    $juevess = '';
                    $vierness = '';
                    $sabados = '';
                    $asignaciones = AsignarDocente::whereRaw('carrera_id='. $carrera_id .' AND materia_id='. $materia_id .' AND planestudio_id='. $planID)->first();

                    if (count($asignaciones) > 0) {
                        $detalledias = DetalleAsignarDocente::whereRaw('asignardocente_id='. $asignaciones->id)->get();

                        foreach ($detalledias as $value) {
                            if ($value->dia == 'Lunes') {
                                $luness = 'lunes';
                            }
                            if ($value->dia == 'Martes') {
                                $martess = 'martes';
                            }
                            if ($value->dia == 'Miercoles') {
                                $miercoless = 'miercoles';
                            }
                            if ($value->dia == 'Jueves') {
                                $juevess = 'jueves';
                            }
                            if ($value->dia == 'Viernes') {
                                $vierness = 'viernes';
                            }
                            if ($value->dia == 'Sabado') {
                                $sabados = 'sabado';
                            }
                        }

                        $diass[] = ['lunes' => $luness, 'martes' => $martess, 'miercoles' => $miercoless, 'jueves' => $juevess, 'viernes' => $vierness, 'sabado' => $sabados];
                    } else {
                        $diass = [];
                    }

                    $feriados = array();

                    $feriadoss = Feriados::whereRaw('fecha_feriado >= "'.$fecha_inicial.'" AND fecha_feriado <= "'.$fecha_final.'"')->get();
                    
                    foreach ($feriadoss as $value) {
                        $arrFechaHora = explode(' ', $value->fecha_feriado);
                        list($year,$mes,$dia) = explode("-",$arrFechaHora[0]);
                        $fechaf = $dia.'-'.(string)(int)$mes;
                        array_push($feriados, $fechaf);
                    }
                    
                    list($year,$mes,$dia) = explode("-",$fecha_inicial);
                    $ini = mktime(0, 0, 0, $mes , $dia, $year); 
                    list($yearf,$mesf,$diaf) = explode("-",$fecha_final);
                    $fin = mktime(0, 0, 0, $mesf , $diaf, $yearf);

                    $newArray = array();
                    $ArrayLab = array();
                    $r = 1;
                    $i = 0;
                    $dia2 = 0;

                    while ($ini != $fin) {
                        $ini = mktime(0, 0, 0, $mes , $dia+$r, $year); 
                        $newArray[$i] = $ini; //CANTIDAD DE DIAS HABILES TENIENDO EN CUENTA EL CICLO
                        $r++;
                        $i++;
                    }
                    $j = count($newArray);
                    $dia_Lab = 0;
                    $dia_NoLab = 0;
                    $dia = 0;

                    for ($i=0; $i < $j; $i++) {
                        $dia = $newArray[$i];
                        $fecha = getdate($dia);
                        $feriado = $fecha['mday']."-".$fecha['mon'];

                        if ($fecha["wday"] == 1) {
                            if ($diass[0]['lunes'] == 'lunes') {
                                if (in_array($feriado, $feriados)) {
                                    $dia_NoLab++; //CUENTO LOS FERIADOS
                                } else {
                                    array_push($ArrayLab, $dia);
                                    $dia_Lab++;
                                }
                            }
                        }
                        if ($fecha["wday"] == 2) {
                            if ($diass[0]['martes'] == 'martes') {
                                if (in_array($feriado, $feriados)) {
                                    $dia_NoLab++; //CUENTO LOS FERIADOS
                                } else {
                                    array_push($ArrayLab, $dia);
                                    $dia_Lab++;
                                }
                            }
                        }
                        if ($fecha["wday"] == 3) {
                            if ($diass[0]['miercoles'] == 'miercoles') {
                                if (in_array($feriado, $feriados)) {
                                    $dia_NoLab++; //CUENTO LOS FERIADOS
                                } else {
                                    array_push($ArrayLab, $dia);
                                    $dia_Lab++;
                                }
                            }
                        }
                        if ($fecha["wday"] == 4) {
                            if ($diass[0]['jueves'] == 'jueves') {
                                if (in_array($feriado, $feriados)) {
                                    $dia_NoLab++; //CUENTO LOS FERIADOS
                                } else {
                                    array_push($ArrayLab, $dia);
                                    $dia_Lab++;
                                }
                            }
                        }
                        if ($fecha["wday"] == 5) {
                            if ($diass[0]['viernes'] == 'viernes') {
                                if (in_array($feriado, $feriados)) {
                                    $dia_NoLab++; //CUENTO LOS FERIADOS
                                } else {
                                    array_push($ArrayLab, $dia);
                                    $dia_Lab++;
                                }
                            }
                        }
                        if ($fecha["wday"] == 6) {
                            if ($diass[0]['sabado'] == 'sabado') {
                                if (in_array($feriado, $feriados)) {
                                    $dia_NoLab++; //CUENTO LOS FERIADOS
                                } else {
                                    array_push($ArrayLab, $dia);
                                    $dia_Lab++;
                                }
                            }
                        }
                    }

                    $cant_dias = $dia_Lab - $dia_NoLab;

                    $asistencias = Asistencias::whereRaw('planestudio_id ='.$planID.' AND carrera_id ='.$carrera_id.' AND alumno_id ='.$resultad.' AND materia_id ='.$materia_id.' AND lunesfecha >= "'.$fecha_inicial.'" AND sabadofecha <= "'.$fecha_final.'"')->get();

                    $asistencia = 0;
                    $fechasasis = array();

                    foreach ($asistencias as $value) {
                        if ($diass[0]['lunes'] == 'lunes') {
                            $fecha = FechaHelper::getFechaImpresion($value->lunesfecha);
                            list($dia, $mes, $year) = explode("/", $fecha);
                            $fechalu = $dia.'-'.(string)(int)$mes;

                            if ($value->lunes == 1) {
                                array_push($fechasasis, $fechalu);
                                $asistencia++;
                            }
                        }

                        if ($diass[0]['martes'] == 'martes') {
                            $fecha = FechaHelper::getFechaImpresion($value->martesfecha);
                            list($dia, $mes, $year) = explode("/", $fecha);
                            $fechama = $dia.'-'.(string)(int)$mes;
                            
                            if ($value->martes == 1) {
                                array_push($fechasasis, $fechama);
                                $asistencia++;
                            }
                        }

                        if ($diass[0]['miercoles'] == 'miercoles') {
                            $fecha = FechaHelper::getFechaImpresion($value->miercolesfecha);
                            list($dia, $mes, $year) = explode("/", $fecha);
                            $fechami = $dia.'-'.(string)(int)$mes;
                            
                            if ($value->miercoles == 1) {
                                array_push($fechasasis, $fechami);
                                $asistencia++;
                            }
                        }

                        if ($diass[0]['jueves'] == 'jueves') {
                            $fecha = FechaHelper::getFechaImpresion($value->juevesfecha);
                            list($dia, $mes, $year) = explode("/", $fecha);
                            $fechaju = $dia.'-'.(string)(int)$mes;
                            
                            if ($value->jueves == 1) {
                                array_push($fechasasis, $fechaju);
                                $asistencia++;
                            }
                        }

                        if ($diass[0]['viernes'] == 'viernes') {
                            $fecha = FechaHelper::getFechaImpresion($value->viernesfecha);
                            list($dia, $mes, $year) = explode("/", $fecha);
                            $fechavi = $dia.'-'.(string)(int)$mes;
                            
                            if ($value->viernes == 1) {
                                array_push($fechasasis, $fechavi);
                                $asistencia++;
                            }
                        }

                        if ($diass[0]['sabado'] == 'sabado') {
                            $fecha = FechaHelper::getFechaImpresion($value->sabadofecha);
                            list($dia, $mes, $year) = explode("/", $fecha);
                            $fechasa = $dia.'-'.(string)(int)$mes;
                            
                            if ($value->sabado == 1) {
                                array_push($fechasasis, $fechasa);
                                $asistencia++;
                            }
                        }
                    }

                    $porcentaje_asistencias = $asistencia * 100 / $cant_dias;

                    $porcentaje_asistencia = round($porcentaje_asistencias, 2);
                /*highlight_string(var_export($porcentaje_asistencia,true));
                exit();*/
                //////////////////////////////////////////////////////////
                $alumnoss = Alumno::getAlumnoPorAlumnoId($resultad);

                foreach ($alumnoss as $alumno) {
                    $apeynom = $alumno->apellido.', '.$alumno->nombre;
                    $regularidade = Regularidades::whereRaw('planestudio_id ='.$planID.' AND carrera_id ='.$carrera_id.' AND alumno_id ='.$alumno->alumno_id.' AND materia_id ='.$materia_id)->get();

                    $materias[] = ['alumno' => $apeynom, 'regularidad' => $regularidade, 'porcentaje_asistencia' => $porcentaje_asistencia];
                }
            }
        }

        $carreras = Carrera::find($carrera_id)->carrera;
        $nombremateria = Materia::find($materia_id)->nombremateria;
        $aniocursado = Materia::find($materia_id)->aniocursado;
        $codigoplan = PlanEstudio::find($planID)->ciclolectivo_id;
        $ciclo = CicloLectivo::find($codigoplan)->descripcion;
        
        $docente = Docente::find($docente_id);
        $docent = Persona::where('id', '=', $docente->persona_id)->first();
        $docente = $docent->apellido.', '.$docent->nombre;
        
        /*highlight_string(var_export($materias,true));
        exit;*/
        $pdf = PDF::loadView('informes.pdf.regularidades', [
            'materias'          =>  $materias,
            'docente'           =>  $docente,
            'carreras'          =>  $carreras,
            'codigoplan'        =>  $ciclo,
            'nombremateria'     =>  $nombremateria,
            'aniocursado'     =>  $aniocursado]);
        return $pdf->setOrientation('landscape')->stream();
    }

    public function postBorrar()
    {
        $id = Input::get('idMateriaHidden');

        $regularidad = Regularidades::findOrFail($id);

        $planID = $regularidad->planestudio_id;
        $carrera_id = $regularidad->carrera_id;
        $alumno_id = $regularidad->alumno_id;
        $materia_id = $regularidad->materia_id;

        $regularidad->delete();

        $regularidade = Regularidades::whereRaw('planestudio_id ='.$planID.' AND carrera_id ='.$carrera_id.' AND alumno_id ='.$alumno_id.' AND materia_id ='.$materia_id)->get();

        if (count($regularidade) > 0) {
            foreach ($regularidade as $value) {
                $idaseguir = $value->id;
            }

            Session::flash('message', 'EL REGISTRO HA SIDO BORRADO.');
            Session::flash('message_type', self::OPERACION_EXITOSA);
            return Redirect::to('regularidades/guardado/'.$idaseguir);
        } else {
            Session::flash('message', 'EL REGISTRO HA SIDO BORRADO.');
            Session::flash('message_type', self::OPERACION_EXITOSA);
            return Redirect::to('regularidades/crear');
        }
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
