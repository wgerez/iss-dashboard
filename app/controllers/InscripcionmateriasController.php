<?php
use Carbon\Carbon;

class InscripcionmateriasController extends BaseController 
{

    private $_data;
    private $_rules;
    private $_messages;

    const OPERACION_EXITOSA = 1;
    const OPERACION_FALLIDA = 2;
    const OPERACION_CANCELADA = 3;
    const OPERACION_INFO = 4;


	public function getIndex()
	{
		$organizaciones = Organizacion::lists('nombre', 'id');

		$planes =	PlanEstudio::all();
		$carreras = Carrera::all();
		$alumnosinscriptos = array();
		$habilita = false;
		$dni = '';
		$apeynom = '';

		array_unshift($organizaciones, 'Seleccionar');

		return View::make('inscripcionmaterias.listado')->with([
			'arrOrganizaciones' => $organizaciones,
			'alumnosinscriptos' => $alumnosinscriptos,
			'dni' 				=> $dni,
			'habilita' 			=> $habilita,
			'apeynom'          	=> $apeynom,
			//'planes'            => $planes,
		    'menu'              => ModulosHelper::MENU_GESTION_ACADEMICA,
            'submenu'           => ModulosHelper::SUBMENU_INSCRIPCIONES_MATERIAS,
            'leer'              => Session::get('INSCRIPCION_MATERIAS_LEER'),
            'editar'            => Session::get('INSCRIPCION_MATERIAS_EDITAR'),
            'imprimir'          => Session::get('INSCRIPCION_MATERIAS_IMPRIMIR'),
            'eliminar'          => Session::get('INSCRIPCION_MATERIAS_ELIMINAR')
		]);
	}

	public function getCrear()
	{
		$organizaciones = Organizacion::lists('nombre', 'id');

		$planes =	PlanEstudio::all();
		$carreras = Carrera::all();
		$habilita = false;

		array_unshift($organizaciones, 'Seleccionar');

		return View::make('inscripcionmaterias.gestion')->with([
			'arrOrganizaciones' => $organizaciones,
			'habilita' 			=> $habilita,
			//'carreras'          => $carreras,
			//'planes'            => $planes,
		    'menu'              => ModulosHelper::MENU_GESTION_ACADEMICA,
            'submenu'           => ModulosHelper::SUBMENU_INSCRIPCIONES_MATERIAS,
            'leer'              => Session::get('INSCRIPCION_MATERIAS_LEER'),
            'editar'            => Session::get('INSCRIPCION_MATERIAS_EDITAR'),
            'imprimir'          => Session::get('INSCRIPCION_MATERIAS_IMPRIMIR'),
            'eliminar'          => Session::get('INSCRIPCION_MATERIAS_ELIMINAR')
		]);
	}

	public function getObtenerinscriptos()
	{
		$organizaciones = Organizacion::lists('nombre', 'id');

		$planes =	PlanEstudio::all();
		$carreras = Carrera::all();
		$alumnosinscriptos = array();
		$habilita = false;
		$dni = '';
		$apeynom = '';

		array_unshift($organizaciones, 'Seleccionar');
		
		return View::make('inscripcionmaterias.listado')->with([
			'arrOrganizaciones' => $organizaciones,
			'alumnosinscriptos' => $alumnosinscriptos,
			'dni' 				=> $dni,
			'habilita' 			=> $habilita,
			'apeynom'          	=> $apeynom,
			//'planes'            => $planes,
		    'menu'              => ModulosHelper::MENU_GESTION_ACADEMICA,
            'submenu'           => ModulosHelper::SUBMENU_INSCRIPCIONES_MATERIAS,
            'leer'              => Session::get('INSCRIPCION_MATERIAS_LEER'),
            'editar'            => Session::get('INSCRIPCION_MATERIAS_EDITAR'),
            'imprimir'          => Session::get('INSCRIPCION_MATERIAS_IMPRIMIR'),
            'eliminar'          => Session::get('INSCRIPCION_MATERIAS_ELIMINAR')
		]);
	}

	public function postObtenerinscriptos()
	{
		//PRIMERO OBTENGO LA CARRERA DONDE ESTA INSCRIPTO EL ALUMNO
		$dni = Input::get('documento');//33456209
		$alumnoid = Input::get('alumnoid');
		$carrera_id = Input::get('carreras');
		$plan_id = Input::get('planEstudio');
		$id = Input::get('organizacion');
		$ciclo_id = Input::get('cboCiclos');
		$apeynom = '';

		if ($id == 0 || $plan_id == 0 || $carrera_id == 0) {
			$carrera_id = '';
			$carreras = [];
			$plan_id = '';
			$planes = [];
			$planestudio = '';
			$alumnosinscriptos = [];
			$dni = '';
			$habilita = false;
		} else {
	        $carreras = Carrera::where('organizacion_id', '=', $id)->get();
	        $planes = PlanEstudio::where('carrera_id', '=', $carrera_id)->get();
			$planestudio = '';
			$habilita = false;
			$alumnosinscriptos = [];
			$countalumnoins = [];

			if (!$dni == '') {
				//$alumnocarrera = AlumnoCarrera::getCarrerasInscripciones($alumnoid);//231);
				$alumnoid = Alumno::getAlumnoPorDni($dni);
				//SEGUNDO OBTENGO LAS MATERIAS DE ESA CARRERA
				$materias = Materia::whereRaw('carrera_id ='. $carrera_id .' AND planestudio_id ='. $plan_id)->get();
				if (count($alumnoid) > 0) {
					$countalumnoins = InscripcionMateria::where('alumno_id', '=',$alumnoid[0]->alumno_id)->get();
					$apeynom = $alumnoid[0]->apellido.', '.$alumnoid[0]->nombre;
					$habilita = true;
				}
			} else {
				$materias = Materia::whereRaw('carrera_id ='. $carrera_id .' AND planestudio_id ='. $plan_id)->get();
				$countalumnoins = InscripcionMateria::whereRaw('planestudio_id ='.$plan_id.' AND carrera_id ='.$carrera_id.' AND ciclolectivo_id ='. $ciclo_id)->get();
			}

			//OBTENGO TODAS LAS MATERIAS Y LAS MATERIAS INSCRIPTAS LAS CHEQUEO
			$mat_insc = [];
			$alumnos = [];
			
			if (count($countalumnoins) > 0) {
				$habilita = true;
				foreach ($countalumnoins as $countalumnoin) {
					array_push($alumnos, $countalumnoin->alumno_id);
				}

				$resultado = array_unique($alumnos);
				sort($resultado);

				for ($i=0; $i < count($resultado); $i++) { 
					$alumnoss = Alumno::find($resultado[$i]);
					$apellido = $alumnoss->persona->apellido;
					$nombre = $alumnoss->persona->nombre;
					$nrodocumento = $alumnoss->persona->nrodocumento;

					$alumnosinscriptos[] = ['alumno_id' => $alumnoss->id, 'apellido' => $apellido, 'nombre' => $nombre, 'nrodocumento' => $nrodocumento];
				}

				for ($i=0; $i < count($alumnosinscriptos); $i++) {
					$alumno_id = $alumnosinscriptos[$i]['alumno_id'];

					foreach ($materias as $materia) {
						$mat = InscripcionMateria::whereRaw('planestudio_id ='.$plan_id.' AND materia_id ='.$materia->id.' AND alumno_id ='.$alumno_id.' AND ciclolectivo_id ='. $ciclo_id)->count();
						$datos = InscripcionMateria::whereRaw('planestudio_id ='.$plan_id.' AND materia_id ='.$materia->id.' AND alumno_id ='.$alumno_id.' AND ciclolectivo_id ='. $ciclo_id)->first();

						if ($mat > 0) {
							$fecha = FechaHelper::getFechaImpresion($datos->fecha_alta);
							$plan = $materia->planestudio->codigoplan;
							$inscripcion = $datos->id;

							array_push($mat_insc, [
												'alumno_id'		=> $datos->alumno_id,
												'nombre' 		=> $materia->nombremateria, 
												//'id' 			=> $materia->id, 
												'inscripcion' 	=> $inscripcion, 
												//'carrera'		=> $materia->carrera->carrera,
												'fecha'			=> $fecha,
												'plan' 			=> $plan,
												'anio' 			=> $materia->aniocursado
											]);
						}
					}

					$alumnosinscriptos[$i]['materias'] = $mat_insc;
					$mat_insc = [];
				}

				$planestudio = PlanEstudio::find($plan_id)->codigoplan;
			}
		}

		$organizaciones = Organizacion::lists('nombre', 'id');
		$ciclos = CicloLectivo::all();

		if (count($alumnosinscriptos) == 0) $habilita = false;

		if ($id == 0 || $plan_id == 0 || $carrera_id == 0) {
			array_unshift($organizaciones, 'Seleccionar');
		}
		//highlight_string(var_export($alumnosinscriptos,true));
        //exit;
		return View::make('inscripcionmaterias.listado')->with([
			'arrOrganizaciones' => $organizaciones,
			'carrera_id'        => $carrera_id,
			'carreras'          => $carreras,
			'plan_id'           => $plan_id,
			'planes'            => $planes,
			'ciclo_id'          => $ciclo_id,
			'ciclos'            => $ciclos,
			'planestudio' 		=> $planestudio,
			'alumnosinscriptos' => $alumnosinscriptos,
			'dni' 				=> $dni,
			'apeynom' 			=> $apeynom,
			'habilita' 			=> $habilita,
		    'menu'              => ModulosHelper::MENU_GESTION_ACADEMICA,
            'submenu'           => ModulosHelper::SUBMENU_INSCRIPCIONES_MATERIAS,
            'leer'              => Session::get('INSCRIPCION_MATERIAS_LEER'),
            'editar'            => Session::get('INSCRIPCION_MATERIAS_EDITAR'),
            'imprimir'          => Session::get('INSCRIPCION_MATERIAS_IMPRIMIR'),
            'eliminar'          => Session::get('INSCRIPCION_MATERIAS_ELIMINAR')
		]);
	}

	public function postObtenermatricula()
	{
		$alumno_id = Input::get('alumnoid');//33456209
		$plan_id = Input::get('plan_id');
		$carrera_id = Input::get('carrera_id');
		$ciclo_id = Input::get('cboCiclos');

		$alumnocarrera = AlumnoCarrera::getDatosInscripcionAlumno($alumno_id);//getCarrerasInscripciones($alumno_id);//231);

		//$ciclo_id = PlanEstudio::find($plan_id)->ciclolectivo_id;
		$inscripcion_id = '';

		foreach ($alumnocarrera as $value) {
			if ($value->ciclolectivo_id == $ciclo_id) {
				$inscripcion_id = $value->inscripcion_id;
			}
		}

		$beca = Beca::whereRaw('inscripcion_id =' . $inscripcion_id . ' and becado=1')->get();
        
		if (count($beca) > 0) {
			$matricula = 1;
        } else {
			$detallematricula = DetalleMatriculaPago::whereRaw('inscripcion_id ='.$inscripcion_id.' AND alumno_id ='.$alumno_id)->get();

			if (count($detallematricula) > 0) {
				$matricula = 1;
	        } else {
				$matricula = 0;
	        }
	    }

        return $matricula;
    }

	public function postAlumnoinscripto()
	{
		$alumno_id = Input::get('alumnoid');//33456209
		$plan_id = Input::get('plan_id');
		$carrera_id = Input::get('carrera_id');
		$ciclo_id = Input::get('cboCiclos');

		$alumnocarrera = AlumnoCarrera::getDatosInscripcionAlumno($alumno_id);//getCarrerasInscripciones($alumno_id);//231);
		
		$materias = Materia::whereRaw('carrera_id ='. $carrera_id .' AND planestudio_id ='. $plan_id)->get();
		
		$mat_insc = [];
		$countalumnoins = InscripcionMateria::whereRaw('alumno_id ='.$alumno_id.' AND carrera_id ='. $carrera_id .' AND planestudio_id ='. $plan_id.' AND ciclolectivo_id ='. $ciclo_id)->get();
		
		if (count($countalumnoins) > 0) {
			foreach ($materias as $materia) {
				$mat = InscripcionMateria::whereRaw('materia_id ='.$materia->id.' AND alumno_id ='.$alumno_id.' AND carrera_id ='. $carrera_id .' AND planestudio_id ='. $plan_id .' AND ciclolectivo_id ='. $ciclo_id)->get();
				
				if (count($mat) > 0) {
					$datos = InscripcionMateria::whereRaw('materia_id ='.$materia->id.' AND alumno_id ='.$alumno_id.' AND carrera_id ='. $carrera_id .' AND planestudio_id ='. $plan_id .' AND ciclolectivo_id ='. $ciclo_id)->first();
					$selected = true;
					$fecha = FechaHelper::getFechaImpresion($datos->fecha_alta);
					$plan = $materia->planestudio->codigoplan;
					$inscripcion = $datos->id;
				} else {
					$selected = false;
					$fecha = false;
					$plan = false;
					$inscripcion = '';
				}

				$ciclo = CicloLectivo::find($ciclo_id)->descripcion;

				array_push($mat_insc, [
										'nombre' 		=> $materia->nombremateria, 
										'id' 			=> $materia->id, 
										'inscripcion' 	=> $inscripcion, 
										'selected' 		=> $selected,
										'carrera'		=> $materia->carrera->carrera,
										'fecha'			=> $fecha,
										'plan' 			=> $plan,
										'ciclo'			=> $ciclo,
										'anio' 			=> $materia->aniocursado
									]);			
			}
		} else {
			foreach ($materias as $materia) {
				array_push($mat_insc, ['nombre' => $materia->nombremateria, 'id' => $materia->id, 'selected' => false]);			
			}			
		}	

		return json_encode($mat_insc);
	}
	
	public function postMateriasdecarrera()
	{
		$carreraid = Input::get('carreraid');
		$materias = Materia::where('carrera_id','=', $carreraid)->get();
		return $materias;
	}

	public function postObtenerciclolectivoactivo()
	{
		$plan_id = Input::get('plan_id');
		
		$plan = PlanEstudio::find($plan_id)->ciclolectivo_id;

		$ciclo = CicloLectivo::find($plan);

		$ciclo_act = $ciclo->activo;

		return $ciclo_act;
	}

	public function postObtenermaterias()
	{
		$carreraid 	= Input::get('carreraid');
		$plaid 		= Input::get('planid');

		$materias = Materia::where('carrera_id','=', $carreraid)
						->where('planestudio_id','=', $plaid)->get();

		return Response::json($materias);
	}

	public function postObtenercorrelatividad()
	{
		$materiains	= Input::get('materiasdisponibles');
		$alumno_id = Input::get('alumnoid');
		$carrera_id = Input::get('carrera_id');
		$planestudio_id = Input::get('planid');
		$materiasi = '';
		$materiano = '';
		$ciclo_id = Input::get('cboCiclos');

		$corr = Correlatividad::where('materia_id', '=', $materiains)->first();

		if (count($corr) > 0) {
			$materiasi = 1;

			$corrcur = Correlatividadcursada::whereRaw('correlatividad_id ='.$corr->id)->get();

			if (count($corrcur) > 0) {
				foreach ($corrcur as $value) {
					$inscripcionmateria = InscripcionMateria::whereRaw('planestudio_id= '.$planestudio_id.' AND alumno_id= '.$alumno_id.' AND carrera_id= '.$carrera_id.' AND materia_id= '.$value->materia_id .' AND ciclolectivo_id ='. $ciclo_id)->get();

					if (count($inscripcionmateria) > 0) {
				        $materiainfo = Materia::find($value->materia_id);

				        $regularidades = Regularidades::whereRaw('carrera_id='.$carrera_id.' AND materia_id='.$value->materia_id.' AND planestudio_id='.$planestudio_id.' AND alumno_id='.$alumno_id)->get();

				        $can_parcial = count($regularidades);

				        $promocions = RegularPromocion::whereRaw('carrera_id='.$carrera_id.' AND materia_id='.$value->materia_id.' AND planestudio_id='.$planestudio_id.' AND ciclolectivo_id='.$ciclo_id)->first();

				        if (count($promocions) > 0) {
				        	$promocion = $promocions->promocional;
				        } else {
				        	$promocion = 0;
				        }

				        $aprobado = 0;
				        $desaprobado = 0;
				        $materias = 0;

				        if ($promocion == 1) {
				            if ($can_parcial > 0) {
				                foreach ($regularidades as $regularidad) {
				                    if ($materiainfo->periodo == 'Anual') {
				                        if ($can_parcial == 2) {
				                            if ($regularidad->nota > 7) {
				                                $aprobado = 1;
				                            } else {
				                                $desaprobado = 1;
				                            }
				                        }
				                    }

				                    if ($materiainfo->periodo == 'Cuatrimestral') {
				                        if ($can_parcial == 1) {
				                            if ($regularidad->nota > 7) {
				                                $aprobado = 1;
				                            } else {
				                                $desaprobado = 1;
				                            }
				                        }
				                    }
				                }
				            } else {
				            	$desaprobado = 1;
				            }

			                if ($desaprobado == 1) {
			                    $materiano = 1;
			                } else {
			                    $materiasi = 1;
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
				            } else {
				            	$desaprobado = 1;
				            }

			                if ($desaprobado == 1) {
			                    $materiano = 1;
			                } else {
			                    $materiasi = 1;
			                }
				        }
					} else {
						$materiano = 1;
					}
				}
			}

			$corraprobada = Correlatividadaprobada::whereRaw('correlatividad_id ='.$corr->id)->get();

			if (count($corraprobada) > 0) {
				foreach ($corraprobada as $corraprobad) {
					$inscripcionmateria = InscripcionMateria::whereRaw('planestudio_id= '.$planestudio_id.' AND alumno_id= '.$alumno_id.' AND carrera_id= '.$carrera_id.' AND materia_id= '.$corraprobad->materia_id .' AND ciclolectivo_id ='. $ciclo_id)->get();

					if (count($inscripcionmateria) > 0) {
						$examenfinal = ExamenFinal::whereRaw('carrera_id ='.$carrera_id.' AND planestudio_id ='.$planestudio_id.' AND materia_id ='.$corraprobad->materia_id.' AND alumno_id ='.$alumno_id)->get();

						if (count($examenfinal) > 0) {
							foreach ($examenfinal as $value) {
								if ($value->calif_final_num > 5) {
									$materiasi = 1;
								} else {
									$materiano = 1;
								}
							}
						} else {
							$materiano = 1;
						}
					}
				}
			}

			$corrfinal = Correlatividadfinalaprobado::whereRaw('correlatividad_id ='.$corr->id)->get();

			if (count($corrfinal) > 0) {
				foreach ($corrfinal as $corrfina) {
					$inscripcionmateria = InscripcionMateria::whereRaw('planestudio_id= '.$planestudio_id.' AND alumno_id= '.$alumno_id.' AND carrera_id= '.$carrera_id.' AND materia_id= '.$corrfina->materia_id .' AND ciclolectivo_id ='. $ciclo_id)->get();

					if (count($inscripcionmateria) > 0) {
						$examenfinal = ExamenFinal::whereRaw('carrera_id ='.$carrera_id.' AND planestudio_id ='.$planestudio_id.' AND materia_id ='.$corrfina->materia_id.' AND alumno_id ='.$alumno_id)->get();

						if (count($examenfinal) > 0) {
							foreach ($examenfinal as $value) {
								if ($value->calif_final_num > 5) {
									$materiasi = 1;
								} else {
									$materiano = 1;
								}
							}
						} else {
							$materiano = 1;
						}
					}
				}
			}
		} else {
			$materiasi = 1;
		}

		if ($materiano == 1) {
			$materias = 0;
		} else {
			if ($materiasi == 1) {
				$materias = 1;
			} else {
				$materias = 0;
			}
		}

		/*highlight_string(var_export('si '.$materiasi,true));
		highlight_string(var_export('no '.$materiano,true));
        exit;*/
        
		return Response::json($materias);
	}

	public function postGuardar()
	{
		$alumnoid = Input::get('alumnoid');
		$alumno = Alumno::with('persona')->find($alumnoid);

		if (empty($alumnoid)) {
            Session::flash('message', 'POR FAVOR, RELLENE LOS CAMPOS ANTES DE GUARDAR.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('inscripcionmaterias');			
		}

		if (Input::get('materiasdisponibles')) {
			$materiasinscriptas = Input::get('materiasdisponibles');
		} else {
			$materiasinscriptas = [];	
		}
		
		$carrerains = Input::get('carreras');
		$planestudio_id = Input::get('planes');
		$ciclo_id = Input::get('cboCiclos');
		$rowsdelete = InscripcionMateria::where('alumno_id', '=', $alumnoid)->get();

		if (count($rowsdelete) == 0) {
			foreach ($materiasinscriptas as $materiains) {
				$newmateria = new InscripcionMateria;

				$newmateria->planestudio_id = $planestudio_id;
				$newmateria->alumno_id 		= $alumnoid;
				$newmateria->materia_id 	= $materiains;
				$newmateria->carrera_id 	= $carrerains;
				$newmateria->ciclolectivo_id = $ciclo_id;
	            $newmateria->usuario_alta   = Auth::user()->usuario;
	            $newmateria->fecha_alta     = date('Y-m-d');

	            $newmateria->save();
			}
		} else {
			$rowsdelete = InscripcionMateria::whereRaw('planestudio_id= '.$planestudio_id.' AND alumno_id= '.$alumnoid.' AND carrera_id= '.$carrerains .' AND ciclolectivo_id ='. $ciclo_id)->get();
			$rowsmat = count($materiasinscriptas);
			$rowscant = count($rowsdelete);
			$eliminamateria = array();
			
	        if ($rowsmat > $rowscant) {
				foreach ($materiasinscriptas as $materiains) {
					$rowspr = InscripcionMateria::whereRaw('planestudio_id= '.$planestudio_id.' AND alumno_id= '.$alumnoid.' AND carrera_id= '.$carrerains.' AND materia_id= '.$materiains.' AND ciclolectivo_id ='. $ciclo_id)->first();

					if (count($rowspr) == 0) {
						$newmateria = new InscripcionMateria;

						$newmateria->planestudio_id = $planestudio_id;
						$newmateria->alumno_id 		= $alumnoid;
						$newmateria->materia_id 	= $materiains;
						$newmateria->carrera_id 	= $carrerains;
						$newmateria->ciclolectivo_id = $ciclo_id;
			            $newmateria->usuario_alta   = Auth::user()->usuario;
			            $newmateria->fecha_alta     = date('Y-m-d');

			            $newmateria->save();

			            $insc = InscripcionMateria::all();
			            $ultimoins = $insc->last();
			            $inscripcion_id = $ultimoins->id;
					}
				}
			} else {
				foreach ($rowsdelete as $rowsdelet) {
					if (in_array($rowsdelet->materia_id, $materiasinscriptas)) {
					   	$prueba = $rowsdelet->materia_id;
				   		$inscripcion_id = $rowsdelet->id;
					} else {
						array_push($eliminamateria, $rowsdelet->materia_id);
					}
				}

				for ($i=0; $i < count($eliminamateria); $i++) { 
					$materiaeliminar = InscripcionMateria::whereRaw('planestudio_id= '.$planestudio_id.' AND alumno_id= '.$alumnoid.' AND carrera_id= '.$carrerains.' AND materia_id= '.$eliminamateria[$i].' AND ciclolectivo_id ='. $ciclo_id)->first();

					$materiaeliminar->delete();
				}
			}
		}

		if (count($materiasinscriptas) > 0) {
			$rowspr = InscripcionMateria::whereRaw('planestudio_id= '.$planestudio_id.' AND alumno_id= '.$alumnoid.' AND carrera_id= '.$carrerains.' AND ciclolectivo_id ='. $ciclo_id)->get();

			if (count($rowspr) > 0) {
				foreach ($rowspr as $value) {
					$inscripcion_id = $value->id;
				}

				Session::flash('message', 'EL ALUMNO <b>' . $alumno->persona->apellido.', '.$alumno->persona->nombre. '</b> SE INSCRIBIÓ CORRECTAMENTE.');
	            Session::flash('message_type', self::OPERACION_EXITOSA);
	            return Redirect::to('inscripcionmaterias/inscripto/'. $alumnoid.'-'.$inscripcion_id);
			} else {
				Session::flash('message', 'EL ALUMNO NO ESTÁ INSCRIPTO EN NINGUNA MATERIA.');
	            Session::flash('message_type', self::OPERACION_FALLIDA);
	            return Redirect::to('inscripcionmaterias/crear');
			}
            //return Redirect::to('inscripcionmaterias');			
		} else {
            Session::flash('message', 'EL ALUMNO NO ESTÁ INSCRIPTO EN NINGUNA MATERIA.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('inscripcionmaterias');
		}
	}

	public function postModificar()
	{
		$inscripcion_id = Input::get('inscripcion_id');
		$alumnoid = Input::get('alumnoid');
		$alumno = Alumno::with('persona')->find($alumnoid);

		if (empty($alumnoid)) {
            Session::flash('message', 'POR FAVOR, RELLENE LOS CAMPOS ANTES DE GUARDAR.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('inscripcionmaterias/inscripto/'. $alumnoid.'-'.$inscripcion_id);
		}

		if (Input::get('materiasdisponibles')) {
			$materiasinscriptas = Input::get('materiasdisponibles');	
		} else {
			$materiasinscriptas = [];	
		}
		
		$carrerains = Input::get('carreras');
		$planestudio_id = Input::get('planes');
		$ciclo_id = Input::get('cboCiclos');

		/*highlight_string(var_export($rowscant,true));
        exit;*/
		$rowsdelete = InscripcionMateria::whereRaw('planestudio_id= '.$planestudio_id.' AND alumno_id= '.$alumnoid.' AND carrera_id= '.$carrerains.' AND ciclolectivo_id ='. $ciclo_id)->get();

		$rowsmat = count($materiasinscriptas);
		$rowscant = count($rowsdelete);
		$eliminamateria = array();
		
        if ($rowsmat > $rowscant) {
			foreach ($materiasinscriptas as $materiains) {
				$rowspr = InscripcionMateria::whereRaw('planestudio_id= '.$planestudio_id.' AND alumno_id= '.$alumnoid.' AND carrera_id= '.$carrerains.' AND materia_id= '.$materiains.' AND ciclolectivo_id ='. $ciclo_id)->first();

				if (count($rowspr) > 0) $inscripcion_id = $rowspr->id;

				if (count($rowspr) == 0) {
					$newmateria = new InscripcionMateria;

					$newmateria->planestudio_id = $planestudio_id;
					$newmateria->alumno_id 		= $alumnoid;
					$newmateria->materia_id 	= $materiains;
					$newmateria->carrera_id 	= $carrerains;
					$newmateria->ciclolectivo_id = $ciclo_id;
		            $newmateria->usuario_alta   = Auth::user()->usuario;
		            $newmateria->fecha_alta     = date('Y-m-d');

		            $newmateria->save();

		            $insc = InscripcionMateria::all();
		            $ultimoins = $insc->last();
		            $inscripcion_id = $ultimoins->id;
				}
			}
		} else {
			foreach ($rowsdelete as $rowsdelet) {
				$inscripcion_id = $rowsdelet->id;
				
				if (in_array($rowsdelet->materia_id, $materiasinscriptas)) {
				   $prueba = $rowsdelet->materia_id;
				   $inscripcion_id = $rowsdelet->id;
				} else {
					array_push($eliminamateria, $rowsdelet->materia_id);
				}
			}

			for ($i=0; $i < count($eliminamateria); $i++) { 
				$materiaeliminar = InscripcionMateria::whereRaw('planestudio_id= '.$planestudio_id.' AND alumno_id= '.$alumnoid.' AND carrera_id= '.$carrerains.' AND materia_id= '.$eliminamateria[$i].' AND ciclolectivo_id ='. $ciclo_id)->first();

				$materiaeliminar->delete();
			}
		}

		if (count($materiasinscriptas) > 0) {
			$rowspr = InscripcionMateria::whereRaw('planestudio_id= '.$planestudio_id.' AND alumno_id= '.$alumnoid.' AND carrera_id= '.$carrerains.' AND ciclolectivo_id ='. $ciclo_id)->get();

			if (count($rowspr) > 0) {
				foreach ($rowspr as $value) {
					$inscripcion_id = $value->id;
				}

				Session::flash('message', 'EL ALUMNO <b>' . $alumno->persona->apellido.', '.$alumno->persona->nombre. '</b> SE INSCRIBIÓ CORRECTAMENTE.');
	            Session::flash('message_type', self::OPERACION_EXITOSA);
	            return Redirect::to('inscripcionmaterias/inscripto/'. $alumnoid.'-'.$inscripcion_id);
			} else {
				Session::flash('message', 'EL ALUMNO NO ESTÁ INSCRIPTO EN NINGUNA MATERIA.');
	            Session::flash('message_type', self::OPERACION_FALLIDA);
	            return Redirect::to('inscripcionmaterias/crear');
			}
            //return Redirect::to('inscripcionmaterias');			
		} else {
            Session::flash('message', 'EL ALUMNO NO ESTÁ INSCRIPTO EN NINGUNA MATERIA.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('inscripcionmaterias/crear'); //inscripto/'. $alumnoid.'-'.$inscripcion_id);
		}
	}

    public function getInscripto($id)
    {
        $porcion = explode("-", $id);
        $alumnoid = $porcion[0];
        $inscripcion_id = $porcion[1];

        $alumno = Alumno::with('persona')->find($alumnoid);

		$rows = InscripcionMateria::find($inscripcion_id);

		//$alumnocarrera = AlumnoCarrera::getDatosInscripcionAlumno($alumnoid);//getCarrerasInscripciones($alumnoid);//231);

		$carrera_id = $rows->carrera_id;//$alumnocarrera[0]->carrera_id;
		$planestudio_id = $rows->planestudio_id;
		$alumnoid = $rows->alumno_id;
		$ciclo_id = $rows->ciclolectivo_id;

		$materias = Materia::whereRaw('carrera_id ='. $carrera_id .' AND planestudio_id ='. $planestudio_id)->get();
		
		$mat_insc = [];
		$countalumnoins = InscripcionMateria::whereRaw('planestudio_id ='.$planestudio_id.' AND carrera_id ='.$carrera_id.' AND alumno_id ='.$alumnoid.' AND ciclolectivo_id ='. $ciclo_id)->count(); //where('id', '=',$inscripcion_id)->count();
		
		if ($countalumnoins > 0) {
			foreach ($materias as $materia) {
				$mat = InscripcionMateria::whereRaw('planestudio_id ='.$planestudio_id.' AND materia_id ='.$materia->id.' AND alumno_id ='.$alumnoid.' AND ciclolectivo_id ='. $ciclo_id)->count();
				$datos = InscripcionMateria::whereRaw('planestudio_id ='.$planestudio_id.' AND materia_id ='.$materia->id.' AND alumno_id ='.$alumnoid.' AND ciclolectivo_id ='. $ciclo_id)->first();
				//$mat = InscripcionMateria::where('materia_id', '=',$materia->id)->count();
				//$datos = InscripcionMateria::where('materia_id', '=',$materia->id)->first();
				if ($mat > 0) {
					$selected = true;
					$fecha = FechaHelper::getFechaImpresion($datos->fecha_alta);
					$plan = $materia->planestudio->codigoplan;
				} else {
					$selected = false;
					$fecha = false;
					$plan = false;
				}

				$ciclo = CicloLectivo::find($ciclo_id)->descripcion;

				array_push($mat_insc, [
										'nombre' 	=> $materia->nombremateria, 
										'id' 		=> $materia->id, 
										'selected' 	=> $selected,
										'carrera'	=> $materia->carrera->carrera,
										'fecha'		=> $fecha,
										'plan' 		=> $plan,
										'ciclo'		=> $ciclo,
										'anio' 		=> $materia->aniocursado
									]);			
			}
		} else {
			foreach ($materias as $materia) {
				array_push($mat_insc, ['nombre' => $materia->nombremateria, 'id' => $materia->id, 'selected' => false]);			
			}			
		}

        /*highlight_string(var_export($mat_insc,true));
        exit();*/
        $plan = PlanEstudio::find($planestudio_id)->ciclolectivo_id;

		$ciclo = CicloLectivo::find($plan);

		if ($ciclo->activo == 0) {
			$ciclo_act[] = ['text' => 'text-danger', 'activo' => 'No Activo'];
		} else {
			$ciclo_act[] = ['text' => 'text-info', 'activo' => 'Activo'];
		}

		$organizaciones = Organizacion::lists('nombre', 'id');

		//array_unshift($organizaciones, 'Seleccionar');

		$planes =	PlanEstudio::all();
		$ciclos =	CicloLectivo::all();
		$carreras = Carrera::all();
		$habilita = true;

        return View::make('inscripcionmaterias.gestioninscripcion')
            ->with('arrOrganizaciones', $organizaciones)
            ->with('alumnoid', $alumnoid)
            ->with('alumno', $alumno)
            ->with('carrera_id', $carrera_id)
            ->with('carreras', $carreras)
            ->with('planestudio_id', $planestudio_id)
            ->with('planes', $planes)
            ->with('ciclo_id', $ciclo_id)
            ->with('ciclos', $ciclos)
            ->with('ciclo_act', $ciclo_act[0])
            ->with('mat_insc', $mat_insc)
            ->with('habilita', $habilita)
            ->with('inscripcion_id', $inscripcion_id)
            ->with('menu', ModulosHelper::MENU_GESTION_ACADEMICA)
            ->with('submenu', ModulosHelper::SUBMENU_INSCRIPCIONES_MATERIAS)
            ->with('leer', Session::get('INSCRIPCION_MATERIAS_LEER'))
            ->with('editar', Session::get('INSCRIPCION_MATERIAS_EDITAR'))
            ->with('imprimir', Session::get('INSCRIPCION_MATERIAS_IMPRIMIR'))
            ->with('eliminar', Session::get('INSCRIPCION_MATERIAS_ELIMINAR'));
    }

    public function getPdfimprimirlistado()
    {
        $dni = Input::get('documento');//33456209
		$alumnoid = Input::get('alumnoid');
		$carrera_id = Input::get('carreras');
		$plan_id = Input::get('planEstudio');
		$id = Input::get('organizacion');
		$ciclo_id = Input::get('cboCiclos');

        $carreras = Carrera::find($carrera_id)->carrera;
        $planes = PlanEstudio::find($plan_id)->ciclolectivo_id;
        $ciclo = CicloLectivo::find($ciclo_id)->descripcion;
		$planestudio = '';
		$habilita = false;
		$alumnosinscriptos = [];

		if (!$dni == '') {
			//$alumnocarrera = AlumnoCarrera::getCarrerasInscripciones($alumnoid);//231);
			$alumnoid = Alumno::getAlumnoPorDni($dni);
			//SEGUNDO OBTENGO LAS MATERIAS DE ESA CARRERA
			$materias = Materia::whereRaw('carrera_id ='. $carrera_id .' AND planestudio_id ='. $plan_id)->get();
			$countalumnoins = InscripcionMateria::where('alumno_id', '=',$alumnoid[0]->alumno_id)->get();
			$habilita = true;
		} else {
			$materias = Materia::whereRaw('carrera_id ='. $carrera_id .' AND planestudio_id ='. $plan_id)->get();
			$countalumnoins = InscripcionMateria::whereRaw('planestudio_id ='.$plan_id.' AND carrera_id ='.$carrera_id.' AND ciclolectivo_id ='. $ciclo_id)->get();
		}

		//OBTENGO TODAS LAS MATERIAS Y LAS MATERIAS INSCRIPTAS LAS CHEQUEO
		$mat_insc = [];
		$alumnos = [];
        $fechahoy = FechaHelper::getFechaImpresion(date("Y-m-d"));
		
		if (count($countalumnoins) > 0) {
			foreach ($countalumnoins as $countalumnoin) {
				array_push($alumnos, $countalumnoin->alumno_id);
			}

			$resultado = array_unique($alumnos);
			sort($resultado);

			for ($i=0; $i < count($resultado); $i++) { 
				$alumnoss = Alumno::find($resultado[$i]);
				$apellido = $alumnoss->persona->apellido;
				$nombre = $alumnoss->persona->nombre;
				$nrodocumento = $alumnoss->persona->nrodocumento;

				$alumnosinscriptos[] = ['alumno_id' => $alumnoss->id, 'apellido' => $apellido, 'nombre' => $nombre, 'nrodocumento' => $nrodocumento];
			}

			for ($i=0; $i < count($alumnosinscriptos); $i++) {
				$alumno_id = $alumnosinscriptos[$i]['alumno_id'];

				foreach ($materias as $materia) {
					$mat = InscripcionMateria::whereRaw('planestudio_id ='.$plan_id.' AND materia_id ='.$materia->id.' AND alumno_id ='.$alumno_id.' AND ciclolectivo_id ='. $ciclo_id)->count();
					$datos = InscripcionMateria::whereRaw('planestudio_id ='.$plan_id.' AND materia_id ='.$materia->id.' AND alumno_id ='.$alumno_id.' AND ciclolectivo_id ='. $ciclo_id)->first();

					if ($mat > 0) {
						$fecha = FechaHelper::getFechaImpresion($datos->fecha_alta);
						$plan = $materia->planestudio->codigoplan;
						$inscripcion = $datos->id;

						array_push($mat_insc, [
											'alumno_id'		=> $datos->alumno_id,
											'nombre' 		=> $materia->nombremateria, 
											//'id' 			=> $materia->id, 
											'inscripcion' 	=> $inscripcion, 
											//'carrera'		=> $materia->carrera->carrera,
											'fecha'			=> $fecha,
											'plan' 			=> $plan,
											'anio' 			=> $materia->aniocursado
										]);
					}
				}

				$alumnosinscriptos[$i]['materias'] = $mat_insc;
				$mat_insc = [];
			}

			$planestudio = PlanEstudio::find($plan_id)->codigoplan;
		}

        $pdf = PDF::loadView(
            'informes.pdf.inscripcionmateria',
            [
              'alumnosinscriptos'  	=> $alumnosinscriptos,
              'carrera'				=> $carreras,
              'ciclo'				=> $ciclo,
              'planestudio'			=> $planestudio,
              'fechahoy'			=> $fechahoy
            ]
        );
        return $pdf->setOrientation('landscape')->stream();
    }

    public function postBorrar()
    {
        $id = Input::get('idMateriaHidden');
        $alumno_id = Input::get('idAlumnoHidden');

        $insc_materia = InscripcionMateria::find($id);

        $planID = $insc_materia->planestudio_id;
        $carrera_id = $insc_materia->carrera_id;
        $materia_id = $insc_materia->materia_id;
        $ciclo_id = $insc_materia->ciclolectivo_id;

        if ($alumno_id == '') $alumno_id = 0;

        $nombremateria = $insc_materia->nombremateria;

        $insc_materia->delete();

        if ($alumno_id == 0) {
        	$insc_materias = InscripcionMateria::whereRaw('planestudio_id ='.$planID.' AND carrera_id ='.$carrera_id.' AND materia_id ='.$materia_id.' AND ciclolectivo_id ='. $ciclo_id)->get();
        } else {
        	$insc_materias = InscripcionMateria::whereRaw('planestudio_id ='.$planID.' AND carrera_id ='.$carrera_id.' AND materia_id ='.$materia_id.' AND alumno_id ='.$alumno_id.' AND ciclolectivo_id ='. $ciclo_id)->get();
        }
        
        if (count($insc_materias) > 0) {
            Session::flash('message', 'LA MATERIA <b>' . $nombremateria . '</b> SE HA ELIMINADO.');
            Session::flash('message_type', self::OPERACION_EXITOSA);
            return Redirect::to('inscripcionmaterias/obtenerinscripto/'. $alumno_id.'-'.$planID.'-'.$carrera_id.'-'.$ciclo_id);
        } else {
            Session::flash('message', 'HUBO ALGUN PROBLEMA AL INTENTAR ELIMINAR LA MATERIA');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('inscripcionmaterias');
        }        
    }

	public function getObtenerinscripto($id)
	{
		$porcion = explode("-", $id);
        $alumno_id = $porcion[0];
		$plan_id = $porcion[1];
		$carrera_id = $porcion[2];
		$ciclo_id = $porcion[3];

        $dni = '';//33456209
		$id = 1;
/*
        if ($alumno_id == 0) {
        	$insc_materias = InscripcionMateria::whereRaw('planestudio_id ='.$plan_id.' AND carrera_id ='.$carrera_id.' AND materia_id ='.$materia_id)->get();
        } else {
        	$insc_materias = InscripcionMateria::whereRaw('planestudio_id ='.$plan_id.' AND carrera_id ='.$carrera_id.' AND materia_id ='.$materia_id.' AND alumno_id ='.$alumno_id)->get();
        }
        */
        $carreras = Carrera::where('organizacion_id', '=', $id)->get();
        $planes = PlanEstudio::where('carrera_id', '=', $carrera_id)->get();
		$planestudio = '';
		$habilita = false;
		$alumnosinscriptos = [];
		$countalumnoins = [];

		if (!$alumno_id == 0) {
			$alumnoid = Alumno::getAlumnoPorId($alumno_id);
			$dni = $alumnoid[0]->nrodocumento;
			//SEGUNDO OBTENGO LAS MATERIAS DE ESA CARRERA
			$materias = Materia::whereRaw('carrera_id ='. $carrera_id .' AND planestudio_id ='. $plan_id)->get();
			if (count($alumnoid) > 0) {
				$countalumnoins = InscripcionMateria::where('alumno_id', '=', $alumno_id)->get();
				$habilita = true;
			}
		} else {
			$materias = Materia::whereRaw('carrera_id ='. $carrera_id .' AND planestudio_id ='. $plan_id)->get();
			$countalumnoins = InscripcionMateria::whereRaw('planestudio_id ='.$plan_id.' AND carrera_id ='.$carrera_id.' AND ciclolectivo_id ='. $ciclo_id)->get();
		}

		//OBTENGO TODAS LAS MATERIAS Y LAS MATERIAS INSCRIPTAS LAS CHEQUEO
		$mat_insc = [];
		$alumnos = [];
		
		if (count($countalumnoins) > 0) {
			$habilita = true;
			foreach ($countalumnoins as $countalumnoin) {
				array_push($alumnos, $countalumnoin->alumno_id);
			}

			$resultado = array_unique($alumnos);
			sort($resultado);

			for ($i=0; $i < count($resultado); $i++) { 
				$alumnoss = Alumno::find($resultado[$i]);
				$apellido = $alumnoss->persona->apellido;
				$nombre = $alumnoss->persona->nombre;
				$nrodocumento = $alumnoss->persona->nrodocumento;

				$alumnosinscriptos[] = ['alumno_id' => $alumnoss->id, 'apellido' => $apellido, 'nombre' => $nombre, 'nrodocumento' => $nrodocumento];
			}

			for ($i=0; $i < count($alumnosinscriptos); $i++) {
				$alumno_id = $alumnosinscriptos[$i]['alumno_id'];

				foreach ($materias as $materia) {
					$mat = InscripcionMateria::whereRaw('planestudio_id ='.$plan_id.' AND materia_id ='.$materia->id.' AND alumno_id ='.$alumno_id.' AND ciclolectivo_id ='. $ciclo_id)->count();
					$datos = InscripcionMateria::whereRaw('planestudio_id ='.$plan_id.' AND materia_id ='.$materia->id.' AND alumno_id ='.$alumno_id.' AND ciclolectivo_id ='. $ciclo_id)->first();

					if ($mat > 0) {
						$fecha = FechaHelper::getFechaImpresion($datos->fecha_alta);
						$plan = $materia->planestudio->codigoplan;
						$inscripcion = $datos->id;
						$ciclo = CicloLectivo::find($ciclo_id)->descripcion;

						array_push($mat_insc, [
											'alumno_id'		=> $datos->alumno_id,
											'nombre' 		=> $materia->nombremateria, 
											//'id' 			=> $materia->id, 
											'inscripcion' 	=> $inscripcion, 
											//'carrera'		=> $materia->carrera->carrera,
											'fecha'			=> $fecha,
											'plan' 			=> $plan,
											'ciclo' 			=> $ciclo,
											'anio' 			=> $materia->aniocursado
										]);
					}
				}

				$alumnosinscriptos[$i]['materias'] = $mat_insc;
				$mat_insc = [];
			}

			$planestudio = PlanEstudio::find($plan_id)->codigoplan;
		}

		$organizaciones = Organizacion::lists('nombre', 'id');
		$ciclos = CicloLectivo::all();

		if ($id == 0 || $plan_id == 0 || $carrera_id == 0) {
			array_unshift($organizaciones, 'Seleccionar');
		}
		//highlight_string(var_export($alumnosinscriptos,true));
        //exit;
		return View::make('inscripcionmaterias.listado')->with([
			'arrOrganizaciones' => $organizaciones,
			'carrera_id'        => $carrera_id,
			'carreras'          => $carreras,
			'plan_id'           => $plan_id,
			'ciclo_id'			=> $ciclo_id,
			'ciclos'			=> $ciclos,
			'planes'            => $planes,
			'planestudio' 		=> $planestudio,
			'alumnosinscriptos' => $alumnosinscriptos,
			'dni' 				=> $dni,
			'habilita' 			=> $habilita,
		    'menu'              => ModulosHelper::MENU_GESTION_ACADEMICA,
            'submenu'           => ModulosHelper::SUBMENU_INSCRIPCIONES_MATERIAS,
            'leer'              => Session::get('INSCRIPCION_MATERIAS_LEER'),
            'editar'            => Session::get('INSCRIPCION_MATERIAS_EDITAR'),
            'imprimir'          => Session::get('INSCRIPCION_MATERIAS_IMPRIMIR'),
            'eliminar'          => Session::get('INSCRIPCION_MATERIAS_ELIMINAR')
		]);
	}


}
