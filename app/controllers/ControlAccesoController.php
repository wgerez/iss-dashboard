<?php
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ControlAccesoController extends \BaseController {

    private $_data;
    private $_rules;
    private $_messages;

    const OPERACION_EXITOSA = 1;
    const OPERACION_FALLIDA = 2;
    const OPERACION_CANCELADA = 3;

    public function getListado()
    {
        $organizaciones = Organizacion::lists('nombre', 'id');

        array_unshift($organizaciones, 'Seleccionar');

        $resultados = array();

    	return View::make('controlacceso/listado')
            ->with('organizaciones', $organizaciones)
            ->with('resultados', $resultados)
            ->with('menu', ModulosHelper::MENU_ACCESOS)
            ->with('submenu', ModulosHelper::SUBMENU_CONTROL_ACCESOS)
            ->with('leer', Session::get('CONTROL_ACCESOS_LEER'))
            ->with('editar', Session::get('CONTROL_ACCESOS_EDITAR'))
            ->with('imprimir', Session::get('CONTROL_ACCESOS_IMPRIMIR'))
            ->with('eliminar', Session::get('CONTROL_ACCESOS_ELIMINAR'));
    }

    public function postObteneracceso() 
    {
    	$organizacion = Input::get('organizacion_id');

    	$perfiles = Perfil::whereRaw('organizacion_id='. $organizacion)->get();

    	$resultado = array('N° Documento', 'Usuario', 'Apellido', 'Nombre');

    	if (count($perfiles) > 0) {
    		foreach ($perfiles as $perfil) {
    			array_push($resultado, $perfil->perfil);
    		}
    	}

    	/*highlight_string(var_export($resultado, true));
    	exit();*/

        return Response::json($resultado);
    }

    public function getObtenermovimientos()
    {
        $organizaciones = Organizacion::lists('nombre', 'id');

        array_unshift($organizaciones, 'Seleccionar');

        $resultados = array();

    	return View::make('controlacceso/listado')
            ->with('organizaciones', $organizaciones)
            ->with('resultados', $resultados)
            ->with('menu', ModulosHelper::MENU_ACCESOS)
            ->with('submenu', ModulosHelper::SUBMENU_CONTROL_ACCESOS)
            ->with('leer', Session::get('CONTROL_ACCESOS_LEER'))
            ->with('editar', Session::get('CONTROL_ACCESOS_EDITAR'))
            ->with('imprimir', Session::get('CONTROL_ACCESOS_IMPRIMIR'))
            ->with('eliminar', Session::get('CONTROL_ACCESOS_ELIMINAR'));
    }

    public function postObtenermovimientos() 
    {
        $orgid = Input::get('organizacion');
        $fechadesdes = Input::get('fechadesde');
        $fechahastas = Input::get('fechahasta');
        $filtro = Input::get('filtrar');
        $txtalumno = Input::get('txtalumno');
        $bandera = true;

        $arraydias = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];
        $resultados = array();
        $i = 0;

        if ($fechadesdes == '') {
        	$fechadesdes = date('Y-m-d');
        }

        if ($fechahastas == '') {
        	$fechahastas = date('Y-m-d');
        }

        $fecha_inicio = strtotime($fechadesdes);
        $fecha_fin    = strtotime($fechahastas);

    	if (!$filtro == '') {
	        if ($filtro == 'N° Documento') {
	        	if ($txtalumno == '') {
		            Session::flash('message', 'ERROR, DEBE INGRESAR UN CRITERIO DE BUSQUEDA!');
		            Session::flash('message_type', self::OPERACION_CANCELADA);
		        }

	        	$personas = Persona::whereRaw("nrodocumento= '". $txtalumno ."'")->get();
	        } elseif ($filtro == 'Usuario') {
	        	if ($txtalumno == '') {
		            Session::flash('message', 'ERROR, DEBE INGRESAR UN CRITERIO DE BUSQUEDA!');
		            Session::flash('message_type', self::OPERACION_CANCELADA);
		        }

	        	$usuario = User::whereRaw("usuario ='". $txtalumno ."'")->get();

	        	if (count($usuario) > 0) {
	        		foreach ($usuario as $value) {
	        			$personas = Persona::whereRaw('id='. $value->persona_id)->get();
	        		}
	        	} else {
	        		$personas = array();
	        	}
	        } elseif ($filtro == 'Apellido') {
	        	if ($txtalumno == '') {
		            Session::flash('message', 'ERROR, DEBE INGRESAR UN CRITERIO DE BUSQUEDA!');
		            Session::flash('message_type', self::OPERACION_CANCELADA);
		        }

	        	$personas = Persona::SearchApellido($txtalumno)->orderBy('apellido')->paginate(1000);
	        } elseif ($filtro == 'Nombre') {
	        	if ($txtalumno == '') {
		            Session::flash('message', 'ERROR, DEBE INGRESAR UN CRITERIO DE BUSQUEDA!');
		            Session::flash('message_type', self::OPERACION_CANCELADA);
		        }

	        	$personas = Persona::SearchNombre($txtalumno)->orderBy('nombre')->paginate(1000);
	        	//$personas = Persona::whereRaw("nombre= '". $txtalumno ."'")->get();
	        } else {
	        	$perfil = Perfil::whereRaw("perfil ='". $filtro ."'")->first();

	        	$users = Acceso::getAccesoPerfil($perfil->id);
	        	
	    		foreach ($users as $user) {
	    			$i = 0;
	    			$usuario = User::find($user->id);

	    			$persona = $user->usuario;
	    			/////
	    			$apellido_nombre = $user->apellido .', '. $user->nombre;
					$usuario = User::whereRaw('persona_id ='. $user->persona_id)->get();

					if (count($usuario) > 0) {
	    				$usuario = User::whereRaw('persona_id ='. $user->persona_id)->first()->usuario;

	    				$accesos = Acceso::whereRaw('persona_id =' . $user->persona_id)->orderByRaw('entrada ASC')->get();
	    				$persona_id = $user->persona_id;
	    				
	    				foreach ($accesos as $acceso) {
		                    $fechatransaccion = FechaHelper::getFechaImpresion($acceso->entrada);
		                    
		                    $porcions = explode("/", $fechatransaccion);
		                    $fechatransaccions = $porcions[2].'-'.$porcions[1].'-'.$porcions[0];
		                    $fecha_trans = strtotime($fechatransaccions);

	    					if ($fecha_trans >= $fecha_inicio && $fecha_trans <= $fecha_fin) {
			                    $porcion = explode(" ", $acceso->entrada);
			                    $fecha = $porcion[0];
		    					$horaentrada = $porcion[1];
		    					$fecha1 = $acceso->entrada;
				                $porciones = explode(":", $horaentrada);
		                    	$horae = $porciones[0];
		                    	$minutoe = $porciones[1];

		    					if ($acceso->salida == '') {
		    						$horasalida = '';
		    						$fecha2 = date('Y-m-d H:i:s');
		    						$fecha_salida = '';
		    						$horass = '';
		    						$minutoss = '';
		    					} else {
				                    $porcione = explode(" ", $acceso->salida);
				    				$horasalida = $porcione[1];
		    						$fecha2 = $acceso->salida;
		    						$fecha_salidas = FechaHelper::getFechaImpresion($acceso->salida);
				                    $porcionx = explode("/", $fecha_salidas);
				                    $fecha_salida = $porcionx[2].'-'.$porcionx[1].'-'.$porcionx[0];
				                	$porciones = explode(":", $horasalida);
		    						$horass = $porciones[0];
		    						$minutoss = $porciones[1];
				    			}

			                    $dian = date("w", strtotime($fecha));
			                    $dia = $arraydias[$dian];
			                    $porcionz = explode("-", $fecha);
			                    $dianu = $dia.' '.$porcionz[2];

			                    //////////////CALCULA HORAS////////////////
			                    $hora = FechaHelper::getCalculoHorarios($fecha1, $fecha2);
			                    //////////////////////////////////////////
			    				
			                    if ($i == 0) {
			                    	$resultados[] = ['i' => $i, 'id' => $acceso->id, 'usuario' => $usuario, 'persona_id' => $persona_id, 'apellido_nombre' => $apellido_nombre, 'dia' => $dianu, 'entrada' => $horaentrada, 'salida' => $horasalida, 'horascumplidas' => $hora, 'fecha_entrada' => $fechatransaccions, 'fecha_salida' => $fecha_salida, 'hora' => $horae, 'minuto' => $minutoe, 'horas' => $horass, 'minutos' => $minutoss];
			                    	$i++;
			                    } else {
			                    	$resultados[] = ['i' => $i, 'id' => $acceso->id, 'usuario' => $usuario, 'persona_id' => $persona_id, 'apellido_nombre' => $apellido_nombre, 'dia' => $dianu, 'entrada' => $horaentrada, 'salida' => $horasalida, 'horascumplidas' => $hora, 'fecha_entrada' => $fechatransaccions, 'fecha_salida' => $fecha_salida, 'hora' => $horae, 'minuto' => $minutoe, 'horas' => $horass, 'minutos' => $minutoss];
			                    }
			                }
	    				}
	    			}
	    			////
	    		}

	    		$bandera = false;
	        }

		    if ($bandera == true) {
				if (count($personas) > 0) {
					foreach ($personas as $persona) {
						$i = 0;
						$apellido_nombre = $persona->apellido .', '. $persona->nombre;

		    				$usuarios = User::whereRaw('persona_id ='. $persona->id)->first();

		    				if (count($usuarios) > 0) {
		    					$usuario = $usuarios->usuario;
		    				} else {
		    					$usuario = '';
		    				}

		    				$accesos = Acceso::whereRaw('persona_id =' . $persona->id)->orderByRaw('entrada ASC')->get();
	    					$persona_id = $persona->id;
		    				
		    				foreach ($accesos as $acceso) {
			                    $fechatransaccion = FechaHelper::getFechaImpresion($acceso->entrada);
			                    
			                    $porcions = explode("/", $fechatransaccion);
			                    $fechatransaccions = $porcions[2].'-'.$porcions[1].'-'.$porcions[0];
			                    $fecha_trans = strtotime($fechatransaccions);

		    					if ($fecha_trans >= $fecha_inicio && $fecha_trans <= $fecha_fin) {
				                    $porcion = explode(" ", $acceso->entrada);
				                    $fecha = $porcion[0];
			    					$horaentrada = $porcion[1];
			    					$fecha1 = $acceso->entrada;
					                $porciones = explode(":", $horaentrada);
			                    	$horae = $porciones[0];
			                    	$minutoe = $porciones[1];

			    					if ($acceso->salida == '') {
			    						$horasalida = '';
			    						$fecha2 = date('Y-m-d H:i:s');
			    						$fecha_salida = '';
			    						$horass = '';
			    						$minutoss = '';
			    					} else {
					                    $porcione = explode(" ", $acceso->salida);
					    				$horasalida = $porcione[1];
			    						$fecha2 = $acceso->salida;
			    						$fecha_salidas = FechaHelper::getFechaImpresion($acceso->salida);
					                    $porcionx = explode("/", $fecha_salidas);
					                    $fecha_salida = $porcionx[2].'-'.$porcionx[1].'-'.$porcionx[0];
					                	$porciones = explode(":", $horasalida);
			    						$horass = $porciones[0];
			    						$minutoss = $porciones[1];
					    			}

				                    $dian = date("w", strtotime($fecha));
				                    $dia = $arraydias[$dian];
				                    $porcionz = explode("-", $fecha);
				                    $dianu = $dia.' '.$porcionz[2];


				                    //////////////CALCULA HORAS////////////////
				                    $hora = FechaHelper::getCalculoHorarios($fecha1, $fecha2);
				                    //////////////////////////////////////////
				    				
				                    if ($i == 0) {
				                    	$resultados[] = ['i' => $i, 'id' => $acceso->id, 'usuario' => $usuario, 'persona_id' => $persona_id, 'apellido_nombre' => $apellido_nombre, 'dia' => $dianu, 'entrada' => $horaentrada, 'salida' => $horasalida, 'horascumplidas' => $hora, 'fecha_entrada' => $fechatransaccions, 'fecha_salida' => $fecha_salida, 'hora' => $horae, 'minuto' => $minutoe, 'horas' => $horass, 'minutos' => $minutoss];
				                    	$i++;
				                    } else {
				                    	$resultados[] = ['i' => $i, 'id' => $acceso->id, 'usuario' => $usuario, 'persona_id' => $persona_id, 'apellido_nombre' => $apellido_nombre, 'dia' => $dianu, 'entrada' => $horaentrada, 'salida' => $horasalida, 'horascumplidas' => $hora, 'fecha_entrada' => $fechatransaccions, 'fecha_salida' => $fecha_salida, 'hora' => $horae, 'minuto' => $minutoe, 'horas' => $horass, 'minutos' => $minutoss];
				                    }
				                }
		    				}
		    			//}
					}
				}
			}
		} else {
			$organizaciones = Organizacion::lists('nombre', 'id');

	        array_unshift($organizaciones, 'Seleccionar');

	        $resultados = array();

	    	return View::make('controlacceso/listado')
	            ->with('organizaciones', $organizaciones)
	            ->with('resultados', $resultados)
	            ->with('menu', ModulosHelper::MENU_ACCESOS)
	            ->with('submenu', ModulosHelper::SUBMENU_CONTROL_ACCESOS)
	            ->with('leer', Session::get('CONTROL_ACCESOS_LEER'))
	            ->with('editar', Session::get('CONTROL_ACCESOS_EDITAR'))
	            ->with('imprimir', Session::get('CONTROL_ACCESOS_IMPRIMIR'))
	            ->with('eliminar', Session::get('CONTROL_ACCESOS_ELIMINAR'));
		}

    	$perfiless = Perfil::whereRaw('organizacion_id='. $orgid)->get();
    	$perfilesu = array('N° Documento', 'Usuario', 'Apellido', 'Nombre');

    	if (count($perfiless) > 0) {
    		foreach ($perfiless as $perfil) {
    			array_push($perfilesu, $perfil->perfil);
    		}
    	}

		/*highlight_string(var_export($resultados, true));
		exit();*/
        $organizaciones = Organizacion::lists('nombre', 'id');

        return View::make('controlacceso/listado')
            ->with('organizaciones', $organizaciones)
            ->with('resultados', $resultados)
            ->with('OrgID', $orgid)
            ->with('txtalumno', $txtalumno)
            ->with('fechadesdes', $fechadesdes)
            ->with('fechahastas', $fechahastas)
            ->with('perfilesu', $perfilesu)
            ->with('filtro', $filtro)
            ->with('menu', ModulosHelper::MENU_ACCESOS)
            ->with('submenu', ModulosHelper::SUBMENU_CONTROL_ACCESOS)
            ->with('leer', Session::get('CONTROL_ACCESOS_LEER'))
            ->with('editar', Session::get('CONTROL_ACCESOS_EDITAR'))
            ->with('imprimir', Session::get('CONTROL_ACCESOS_IMPRIMIR'))
            ->with('eliminar', Session::get('CONTROL_ACCESOS_ELIMINAR'));
    }

    public function postRegistrarentradasalida()
    {
        $personal       = Input::get('txt_personal');
        $usuario    	= Input::get('txt_usuario');
        $usuario_id     = Input::get('txt_usuario_id');
        $entrada        = Input::get('txt_entrada');
        $hora      		= Input::get('txt_hora'); // mes
        $minuto         = Input::get('txt_minuto');
        $salida         = Input::get('txt_salida');
        $horas         	= Input::get('txt_horas');
        $minutos        = Input::get('txt_minutos');

        $horaentrada = $entrada.' '.$hora.':'.$minuto;
        
        if ($entrada == '' || $hora == '' || $minuto == '') {
            Session::flash('message', 'ERROR AL INTENTAR GUARDAR EL ACCESO, DEBE INGRESAR LA FECHA/HORA DE ENTRADA!');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('controlacceso/listado')//acceso/' . $persona_id)
                ->withInput();
        }

        if ($salida == '') {
        	$horasalida = date('Y-m-d');
        } else {
        	$horasalida = $salida;
        }

        $fecha_inicio = strtotime($entrada);
        $fecha_fin    = strtotime($horasalida);

	    if ($fecha_inicio > $fecha_fin) {
	    	Session::flash('message', 'ERROR AL INTENTAR GUARDAR EL ACCESO, LA FECHA DE SALIDA NO PUEDE SER MAYOR QUE LA DE ENTRADA!');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('controlacceso/listado')//acceso/' . $persona_id)
                ->withInput();
	    }

	    if (!$salida == '') {
	    	if ($horas == '' || $minutos == '') {
	    		Session::flash('message', 'ERROR AL INTENTAR GUARDAR EL ACCESO, LA FECHA DE SALIDA DEBE ESTAR COMPLETA!');
	            Session::flash('message_type', self::OPERACION_FALLIDA);
	            return Redirect::to('controlacceso/listado')//acceso/' . $persona_id)
	                ->withInput();
	    	}
	    }

        if ($salida == '') {
        	$horasalida = '';//date('Y-m-d H:i');
        } else {
        	if ($horas == '' || $minutos == '') {
        		Session::flash('message', 'ERROR AL INTENTAR GUARDAR EL ACCESO, LA FECHA/HORA DE SALIDA DEBE ESTAR COMPLETA!');
	            Session::flash('message_type', self::OPERACION_FALLIDA);
	            return Redirect::to('controlacceso/listado')//acceso/' . $persona_id)
	                ->withInput();
        	} else {
        		$horasalida = $salida.' '.$horas.':'.$minutos;
        	}
        }

        $fecha_inicio = strtotime($horaentrada);

        if (!$horasalida == '') {
        	$fecha_fin    = strtotime($horasalida);

		    if ($fecha_inicio > $fecha_fin) {
		    	Session::flash('message', 'ERROR AL INTENTAR GUARDAR EL ACCESO, LA FECHA/HORA DE SALIDA NO PUEDE SER MAYOR QUE LA DE ENTRADA!');
	            Session::flash('message_type', self::OPERACION_FALLIDA);
	            return Redirect::to('controlacceso/listado')//acceso/' . $persona_id)
	                ->withInput();
		    }
        }
        
        $acceso = Acceso::find($usuario_id);
        
        //$acceso->persona_id   = $personal;
        $acceso->entrada        = $horaentrada;

        if (!$horasalida == '') $acceso->salida = $horasalida;
        //$acceso->tipo           = 7;
        //$acceso->visto          = 1;
        $acceso->usuario_modi   = Auth::user()->usuario;
        $acceso->fecha_modi     = date('Y-m-d H:i:s');
        $acceso->save();

        Session::flash('message', 'LOS DATOS SE GUARDARON EXITOSAMENTE!');
        Session::flash('message_type', self::OPERACION_EXITOSA);
        return Redirect::to('controlacceso/listado');
    }

    public function getCrear()
    {
        $organizaciones = Organizacion::lists('nombre', 'id');
        $organizacionid = Organizacion::whereRaw('id='. 1)->first();
        $personas = Persona::all();
        $resultados = array();

        foreach ($personas as $persona) {
	        $apellido_nombre = $persona->apellido.', '.$persona->nombre;
        	$user = User::whereRaw('persona_id ='. $persona->id)->first();
	        $perfilesu = '';
	        $usuario = '';

        	if (count($user) > 0) {
	        	$usuario = $user->usuario;

	        	$perfiles = PerfilUser::whereRaw('user_id ='. $user->id)->get();

	        	foreach ($perfiles as $value) {
	        		$perfil = Perfil::find($value->perfil_id)->perfil;

	        		$perfilesu .= ' - '. $perfil;
	        	}

        		$resultados[] = ['id' => $persona->id, 'apellido_nombre' => $apellido_nombre, 'usuario' => $usuario, 'perfil' => $perfilesu];
	        } else {
	        	$resultados[] = ['id' => $persona->id, 'apellido_nombre' => $apellido_nombre, 'usuario' => $usuario, 'perfil' => $perfilesu];
	        }
        }

        array_unshift($organizaciones, 'Seleccionar');

          return View::make('controlacceso/nuevo',[
              'arrOrganizaciones'   => $organizaciones,
              'organizacionid'      => $organizacionid,
              'resultados'	        => $resultados
            ])
            ->with('menu', ModulosHelper::MENU_ACCESOS)
            ->with('submenu', ModulosHelper::SUBMENU_CONTROL_ACCESOS)
            ->with('leer', Session::get('CONTROL_ACCESOS_LEER'))
            ->with('editar', Session::get('CONTROL_ACCESOS_EDITAR'))
            ->with('imprimir', Session::get('CONTROL_ACCESOS_IMPRIMIR'))
            ->with('eliminar', Session::get('CONTROL_ACCESOS_ELIMINAR'));
    }

    public function postBuscarcodigo()
    {
    	$codigo = Input::get('codigo');
    	$personal = array();

    	$personas = Persona::find($codigo);

    	if (count($personas) > 0) {
    		$apellido_nombre = $personas->apellido.', '.$personas->nombre;
    		$usuarios = User::whereRaw('persona_id= '.$personas->id)->first();

    		if (count($usuarios) > 0) {
    			$usuario = $usuarios->usuario;
    		} else {
    			$usuario = '';
    		}

    		$personal[] = ['personal' => $apellido_nombre, 'usuario' => $usuario];
    	}

    	return Response::json($personal);
    }

    public function postBuscarhorario()
    {
    	$codigo = Input::get('codigo');
    	$resultados = array();

    	$accesos = Acceso::whereRaw('persona_id =' . $codigo)->get();

    	if (count($accesos) > 0) {
    		foreach ($accesos as $acceso) {
    			if ($acceso->salida == '') {
    				$acceso_id = $acceso->id;
    				$porcion = explode(" ", $acceso->entrada);
                    $fechas = $porcion[0];
                    $horas = $porcion[1];

    				$porcionx = explode(":", $horas);
                    $hora = $porcionx[0];
                    $minuto = $porcionx[1];

    				$fechatransaccion = FechaHelper::getFechaImpresion($fechas);
                    $porcions = explode("/", $fechatransaccion);
                    $fecha = $porcions[2].'-'.$porcions[1].'-'.$porcions[0];

    				$resultados[] = ['acceso_id' => $acceso_id, 'fecha' => $fecha, 'hora' => $hora, 'minuto' => $minuto];
    			}
    		}
    	}

/*highlight_string(var_export($resultados,true));
        exit;*/
    	return Response::json($resultados);
    }

    public function postGuardar()
    {   
        $personal       = Input::get('txt_personal');
        $usuario    	= Input::get('txt_usuario');
        $usuario_id     = Input::get('txt_codigo');
        $entrada        = Input::get('txt_entrada');
        $hora      		= Input::get('cbo_hora'); // mes
        $minuto         = Input::get('cbo_minuto');
        $salida         = Input::get('txt_salida');
        $horas         	= Input::get('cbo_horas');
        $minutos        = Input::get('cbo_minutos');
        $organizacion   = Input::get('organizacion');
        $acceso_id   	= Input::get('txt_acceso_id');

        $horaentrada = $entrada.' '.$hora.':'.$minuto;
        
        if ($usuario_id == '' || $personal == '' || $organizacion == 0) {
            Session::flash('message', 'ERROR AL INTENTAR GUARDAR EL ACCESO, DEBE INGRESAR LOS DATOS!');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('controlacceso/crear')
                ->withInput();
        }

        if ($entrada == '' || $hora == '' || $minuto == '') {
            Session::flash('message', 'ERROR AL INTENTAR GUARDAR EL ACCESO, DEBE INGRESAR LA FECHA/HORA DE ENTRADA!');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('controlacceso/crear')
                ->withInput();
        }

        if ($salida == '') {
        	$horasalida = date('Y-m-d');
        } else {
        	$horasalida = $salida;
        }

        $fecha_inicio = strtotime($entrada);
        $fecha_fin    = strtotime($horasalida);

	    if ($fecha_inicio > $fecha_fin) {
	    	Session::flash('message', 'ERROR AL INTENTAR GUARDAR EL ACCESO, LA FECHA DE SALIDA NO PUEDE SER MAYOR QUE LA DE ENTRADA!');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('controlacceso/crear')
                ->withInput();
	    }

	    if (!$salida == '') {
	    	if ($horas == '' || $minutos == '') {
	    		Session::flash('message', 'ERROR AL INTENTAR GUARDAR EL ACCESO, LA FECHA DE SALIDA DEBE ESTAR COMPLETA!');
	            Session::flash('message_type', self::OPERACION_FALLIDA);
	            return Redirect::to('controlacceso/crear')
	                ->withInput();
	    	}
	    }

        if ($salida == '') {
        	$horasalida = NULL;
        } else {
        	if ($horas == '' || $minutos == '') {
        		Session::flash('message', 'ERROR AL INTENTAR GUARDAR EL ACCESO, LA FECHA/HORA DE SALIDA DEBE ESTAR COMPLETA!');
	            Session::flash('message_type', self::OPERACION_FALLIDA);
	            return Redirect::to('controlacceso/crear')
	                ->withInput();
        	} else {
        		$horasalida = $salida.' '.$horas.':'.$minutos.':00';
        	}
        }

        if (!$horasalida == NULL) {
	        $fecha_inicio = strtotime($horaentrada);
	        $fecha_fin    = strtotime($horasalida);

		    if ($fecha_inicio > $fecha_fin) {
		    	Session::flash('message', 'ERROR AL INTENTAR GUARDAR EL ACCESO, LA FECHA/HORA DE SALIDA NO PUEDE SER MAYOR QUE LA DE ENTRADA!');
	            Session::flash('message_type', self::OPERACION_FALLIDA);
	            return Redirect::to('controlacceso/crear')
	                ->withInput();
		    }
		}

		if ($acceso_id == '') {
	        $acceso = new Acceso();
	        
	        $acceso->persona_id     = $usuario_id;
	        $acceso->entrada        = $horaentrada;
	        $acceso->salida         = $horasalida;
	        $acceso->tipo           = 8;
	        $acceso->visto          = 1;
	        $acceso->usuario_alta   = Auth::user()->usuario;
	        $acceso->fecha_alta     = date('Y-m-d H:i:s');
	        $acceso->save();
	    } else {
	    	$acceso = Acceso::find($acceso_id);
        
	        if (!$horasalida == '') $acceso->salida = $horasalida;
	        //$acceso->tipo           = 7;
	        //$acceso->visto          = 1;
	        $acceso->usuario_modi   = Auth::user()->usuario;
	        $acceso->fecha_modi     = date('Y-m-d H:i:s');
	        $acceso->save();
	    }

        Session::flash('message', 'LOS DATOS SE GUARDARON EXITOSAMENTE!');
        Session::flash('message_type', self::OPERACION_EXITOSA);
        return Redirect::to('controlacceso/crear');
    }

    public function getImprimiracceso()/*PDF*/
    {
        //$orgid = Input::get('organizacion');
        $fechadesdes = Input::get('fechadesde');
        $fechahastas = Input::get('fechahasta');
        $filtro = Input::get('filtrar');
        $txtalumno = Input::get('txtalumno');
        $bandera = true;

        $arraydias = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];
        $resultados = array();
        $i = 0;

        if ($fechadesdes == '') {
        	$fechadesdes = date('Y-m-d');
        }

        if ($fechahastas == '') {
        	$fechahastas = date('Y-m-d');
        }

        $fecha_inicio = strtotime($fechadesdes);
        $fecha_fin    = strtotime($fechahastas);

    	if (!$filtro == '') {
	        if ($filtro == 'N° Documento') {
	        	$personas = Persona::whereRaw("nrodocumento= '". $txtalumno ."'")->get();
	        } elseif ($filtro == 'Usuario') {
	        	$usuario = User::whereRaw("usuario ='". $txtalumno ."'")->get();

	        	if (count($usuario) > 0) {
	        		foreach ($usuario as $value) {
	        			$personas = Persona::whereRaw('id='. $value->persona_id)->get();
	        		}
	        	} else {
	        		$personas = array();
	        	}
	        } elseif ($filtro == 'Apellido') {
	        	$personas = Persona::SearchApellido($txtalumno)->orderBy('apellido')->paginate(1000);
	        } elseif ($filtro == 'Nombre') {
	        	$personas = Persona::SearchNombre($txtalumno)->orderBy('nombre')->paginate(1000);
	        } else {
	        	$perfil = Perfil::whereRaw("perfil ='". $filtro ."'")->first();
	        	
	        	$users = Acceso::getAccesoPerfil($perfil->id);

	    		foreach ($users as $user) {
	    			$i = 0;
	    			$usuario = User::find($user->id);

	    			$persona = $user->usuario;
	    			/////
	    			$apellido_nombre = $user->apellido .', '. $user->nombre;
					$usuario = User::whereRaw('persona_id ='. $user->persona_id)->get();

					if (count($usuario) > 0) {
	    				$usuario = User::whereRaw('persona_id ='. $user->persona_id)->first()->usuario;
	    				$acc = 0;
	    				$accesos = Acceso::whereRaw('persona_id =' . $user->persona_id)->get();
	    				$persona_id = $user->persona_id;
				        $horax = array();
	    				
	    				foreach ($accesos as $acceso) {
		                    $fechatransaccion = FechaHelper::getFechaImpresion($acceso->entrada);
		                    
		                    $porcions = explode("/", $fechatransaccion);
		                    $fechatransaccions = $porcions[2].'-'.$porcions[1].'-'.$porcions[0];
		                    $fecha_trans = strtotime($fechatransaccions);

	    					if ($fecha_trans >= $fecha_inicio && $fecha_trans <= $fecha_fin) {
	    						$acc = 1;
			                    $porcion = explode(" ", $acceso->entrada);
			                    $fecha = $porcion[0];
		    					$horaentrada = $porcion[1];
		    					$fecha1 = $acceso->entrada;
				                $porciones = explode(":", $horaentrada);
		                    	$horae = $porciones[0];
		                    	$minutoe = $porciones[1];

		    					if ($acceso->salida == '') {
		    						$horasalida = '';
		    						$fecha2 = date('Y-m-d H:i:s');
		    						$fecha_salida = '';
		    						$horass = '';
		    						$minutoss = '';
		    					} else {
				                    $porcione = explode(" ", $acceso->salida);
				    				$horasalida = $porcione[1];
		    						$fecha2 = $acceso->salida;
		    						$fecha_salidas = FechaHelper::getFechaImpresion($acceso->salida);
				                    $porcionx = explode("/", $fecha_salidas);
				                    $fecha_salida = $porcionx[2].'-'.$porcionx[1].'-'.$porcionx[0];
				                	$porciones = explode(":", $horasalida);
		    						$horass = $porciones[0];
		    						$minutoss = $porciones[1];
				    			}

			                    $dian = date("w", strtotime($fecha));
			                    $dia = $arraydias[$dian];
			                    $porcionz = explode("-", $fecha);
			                    $dianu = $dia.' '.$porcionz[2];

			                    //////////////CALCULA HORAS////////////////
			                    $hora = FechaHelper::getCalculoHorarios($fecha1, $fecha2);
			                    //////////////////////////////////////////
				                if ($hora == '0:00:00') {
					            	$e = 0;
				                } else {
				                	array_push($horax, $hora);
				                }
			    				
			                    if ($i == 0) {
			                    	$resultados[] = ['i' => $i, 'id' => $acceso->id, 'usuario' => $usuario, 'persona_id' => $persona_id, 'apellido_nombre' => $apellido_nombre, 'dia' => $dianu, 'entrada' => $horaentrada, 'salida' => $horasalida, 'horascumplidas' => $hora, 'fecha_entrada' => $fechatransaccions, 'fecha_salida' => $fecha_salida, 'hora' => $horae, 'minuto' => $minutoe, 'horas' => $horass, 'minutos' => $minutoss, 'totalhoras' => ''];
			                    	$i++;
			                    } else {
			                    	$resultados[] = ['i' => $i, 'id' => $acceso->id, 'usuario' => $usuario, 'persona_id' => $persona_id, 'apellido_nombre' => $apellido_nombre, 'dia' => $dianu, 'entrada' => $horaentrada, 'salida' => $horasalida, 'horascumplidas' => $hora, 'fecha_entrada' => $fechatransaccions, 'fecha_salida' => $fecha_salida, 'hora' => $horae, 'minuto' => $minutoe, 'horas' => $horass, 'minutos' => $minutoss, 'totalhoras' => ''];
			                    }
			                }
	    				}

	    				$total = 0;

		    			if ($acc == 1) {
	    					$sumaHoras = 0;
	    					$sumaminutos = 0;
							
							for ($i=0; $i < count($horax); $i++) { 
							    $value_horario   = $horax[$i];
							    $parts           = explode(':', $value_horario);
							    
							    $sumaHoras = $sumaHoras + $parts[0];
							    $sumaminutos = $sumaminutos + $parts[1];

							    if ($sumaminutos > 59) {
							    	$sumaHoras++;
							    	$sumaminutosn = $sumaminutos - 60;

							    	if ($sumaminutosn < 10) {
							    		$sumaminutos = '0'.$sumaminutosn;
							    	} else {
							    		$sumaminutos = $sumaminutosn;
							    	}
							    }
							}
							
						    $totalhoras = $sumaHoras.':'.$sumaminutos;

		    				$resultados[] = ['i' => '', 'id' => '', 'usuario' => $usuario, 'persona_id' => '', 'apellido_nombre' => '', 'dia' => '', 'entrada' => '', 'salida' => '', 'horascumplidas' => '', 'fecha_entrada' => '', 'fecha_salida' => '', 'hora' => '', 'minuto' => '', 'horas' => '', 'minutos' => '', 'totalhoras' => $totalhoras];

		    				$acc = 0;
		    			}
	    			}
	    			////
	    		}

	    		$bandera = false;
	        }

		    if ($bandera == true) {
				if (count($personas) > 0) {
					foreach ($personas as $persona) {
						$i = 0;
						$apellido_nombre = $persona->apellido .', '. $persona->nombre;

	    				$usuarios = User::whereRaw('persona_id ='. $persona->id)->first();

	    				if (count($usuarios) > 0) {
	    					$usuario = $usuarios->usuario;
	    				} else {
	    					$usuario = '';
	    				}

	    				$acc = 0;
	    				$accesos = Acceso::whereRaw('persona_id =' . $persona->id)->get();
    					$persona_id = $persona->id;
			            $horax = array();
	    				
	    				foreach ($accesos as $acceso) {
		                    $fechatransaccion = FechaHelper::getFechaImpresion($acceso->entrada);
		                    
		                    $porcions = explode("/", $fechatransaccion);
		                    $fechatransaccions = $porcions[2].'-'.$porcions[1].'-'.$porcions[0];
		                    $fecha_trans = strtotime($fechatransaccions);

	    					if ($fecha_trans >= $fecha_inicio && $fecha_trans <= $fecha_fin) {
	    						$acc = 1;
			                    $porcion = explode(" ", $acceso->entrada);
			                    $fecha = $porcion[0];
		    					$horaentrada = $porcion[1];
		    					$fecha1 = $acceso->entrada;
				                $porciones = explode(":", $horaentrada);
		                    	$horae = $porciones[0];
		                    	$minutoe = $porciones[1];

		    					if ($acceso->salida == '') {
		    						$horasalida = '';
		    						$fecha2 = date('Y-m-d H:i:s');
		    						$fecha_salida = '';
		    						$horass = '';
		    						$minutoss = '';
		    					} else {
				                    $porcione = explode(" ", $acceso->salida);
				    				$horasalida = $porcione[1];
		    						$fecha2 = $acceso->salida;
		    						$fecha_salidas = FechaHelper::getFechaImpresion($acceso->salida);
				                    $porcionx = explode("/", $fecha_salidas);
				                    $fecha_salida = $porcionx[2].'-'.$porcionx[1].'-'.$porcionx[0];
				                	$porciones = explode(":", $horasalida);
		    						$horass = $porciones[0];
		    						$minutoss = $porciones[1];
				    			}

			                    $dian = date("w", strtotime($fecha));
			                    $dia = $arraydias[$dian];
			                    $porcionz = explode("-", $fecha);
			                    $dianu = $dia.' '.$porcionz[2];

			                    //////////////CALCULA HORAS////////////////
			                    $hora = FechaHelper::getCalculoHorarios($fecha1, $fecha2);
			                    //////////////////////////////////////////
			                    if ($hora == '0:00:00') {
					            	$e = 0;
				                } else {
				                	array_push($horax, $hora);
				                }
			    				
			                    if ($i == 0) {
			                    	$resultados[] = ['i' => $i, 'id' => $acceso->id, 'usuario' => $usuario, 'persona_id' => $persona_id, 'apellido_nombre' => $apellido_nombre, 'dia' => $dianu, 'entrada' => $horaentrada, 'salida' => $horasalida, 'horascumplidas' => $hora, 'fecha_entrada' => $fechatransaccions, 'fecha_salida' => $fecha_salida, 'hora' => $horae, 'minuto' => $minutoe, 'horas' => $horass, 'minutos' => $minutoss, 'totalhoras' => ''];
			                    	$i++;
			                    } else {
			                    	$resultados[] = ['i' => $i, 'id' => $acceso->id, 'usuario' => $usuario, 'persona_id' => $persona_id, 'apellido_nombre' => $apellido_nombre, 'dia' => $dianu, 'entrada' => $horaentrada, 'salida' => $horasalida, 'horascumplidas' => $hora, 'fecha_entrada' => $fechatransaccions, 'fecha_salida' => $fecha_salida, 'hora' => $horae, 'minuto' => $minutoe, 'horas' => $horass, 'minutos' => $minutoss, 'totalhoras' => ''];
			                    }
			                }
	    				}

	    				$total = 0;

		    			if ($acc == 1) {
	    					$sumaHoras=0;
	    					$sumaminutos = 0;

							for ($i=0; $i < count($horax); $i++) { 
							    $value_horario   = $horax[$i];
							    $parts           = explode(':', $value_horario);
							    
							    $sumaHoras = $sumaHoras + $parts[0];
							    $sumaminutos = $sumaminutos + $parts[1];

							    if ($sumaminutos > 59) {
							    	$sumaHoras++;
							    	$sumaminutosn = $sumaminutos - 60;

							    	if ($sumaminutosn < 10) {
							    		$sumaminutos = '0'.$sumaminutosn;
							    	} else {
							    		$sumaminutos = $sumaminutosn;
							    	}
							    }
							}
							
						    $totalhoras = $sumaHoras.':'.$sumaminutos;

		    				$resultados[] = ['i' => '', 'id' => '', 'usuario' => $usuario, 'persona_id' => '', 'apellido_nombre' => '', 'dia' => '', 'entrada' => '', 'salida' => '', 'horascumplidas' => '', 'fecha_entrada' => '', 'fecha_salida' => '', 'hora' => '', 'minuto' => '', 'horas' => '', 'minutos' => '', 'totalhoras' => $totalhoras];

		    				$acc = 0;
		    			}
					}
				}
			}
		} else {
			$organizaciones = Organizacion::lists('nombre', 'id');

	        array_unshift($organizaciones, 'Seleccionar');

	        $resultados = array();
	    }

	    $fechadesde = FechaHelper::getFechaImpresion($fechadesdes);
	    $fechahasta = FechaHelper::getFechaImpresion($fechahastas);
        /*highlight_string(var_export($resultados,true));
        exit;*/

        $pdf = PDF::loadView('informes.pdf.accesopersonal', ['resultados'=>$resultados, 'fechadesde'=>$fechadesde, 'fechahasta'=>$fechahasta, 'filtro' => $filtro, 'txtalumno' => $txtalumno]);
        return $pdf->setOrientation('landscape')->stream();
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
