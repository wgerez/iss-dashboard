<?php
use Carbon\Carbon;

class InscripcionFinalesController extends BaseController 
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

        $turnos = TurnoExamen::all();

        if (count($turnos) > 0) {
            $turno_id = $turnos[0]->id;
        } else {
            $turno_id = '';
            $turnos = [];
        }
        
        array_unshift($organizaciones, 'Seleccione');

        return View::make('inscripcionfinal.listado')
            ->with('organizaciones', $organizaciones)
            ->with('turnos', $turnos)
            ->with('turno_id', $turno_id)
            ->with('llamado', 1)
            ->with('dni', '')
            ->with('menu', ModulosHelper::MENU_GESTION_ACADEMICA)
            ->with('submenu', ModulosHelper::SUBMENU_INSCRIPCIONES)
            ->with('leer', Session::get('INSCRIPCION_LEER'))
            ->with('editar', Session::get('INSCRIPCION_EDITAR'))
            ->with('imprimir', Session::get('INSCRIPCION_IMPRIMIR'))
            ->with('eliminar', Session::get('INSCRIPCION_ELIMINAR'));
    }
    
    public function postObtenerinscriptos ()
    {
        //echo "hola";
        /*highlight_string(var_export($asignard,true));
        exit();*/
        $inscriptos = [];

        $org_id     = Input::get('organizacion');
        $carr_id    = Input::get('carrera');
        $ciclo_id   = Input::get('ciclos');
        $turno_id   = Input::get('turnos');
        $materia_id = Input::get('materias');
        $llamado    = Input::get('llamado');
        $filtro     = Input::get('cboFiltro');
        $dni        = Input::get('nrodocumento');

        $mesa = MesaExamen::where('carrera_id', '=', $carr_id)->where('ciclolectivo_id', '=', $ciclo_id)->where('turnoexamen_id', '=', $turno_id)->where('materia_id', '=', $materia_id)->first();

        if ($mesa) {
            $mesa->fechaprimerllamado = FechaHelper::getFechaImpresion($mesa->fechaprimerllamado);
            $mesa->fechasegundollamado = FechaHelper::getFechaImpresion($mesa->fechasegundollamado);

            $asignard = AsignarDocente::where('materia_id', '=', $mesa->materia_id)->first();

            if ($asignard) {
                $tempdocente = Docente::where('id', '=', $asignard->docentetitular_id)->first();

                if ($tempdocente) {
                    $docente =  $tempdocente->persona->apellido .' ' . $tempdocente->persona->nombre;
                } else {
                    $docente = '';
                }
            } else {
                $docente = '';
            }
            
            if ($filtro == 1) { //filtro todos
                if ($llamado == 1) {
                    $inscripcionfinal = InscripcionFinal::where('mesaexamen_id', '=', $mesa->id)->where('primerllamado', '=', 1)->get();    

                    if ($inscripcionfinal) {
                        foreach ($inscripcionfinal as $temp) {
                            $inscriptos [] = ['id' => $temp->id,'fecha' => $mesa->fechaprimerllamado, 'alumno' => $temp->alumno->persona->apellido .' ' . $temp->alumno->persona->nombre, 'plan' => $mesa->materia->planestudio->codigoplan, 'materia' => $mesa->materia->nombremateria, 'docentetitular' => $docente, 'anulado' => $temp->anulado];
                        }
                    }
                } else {
                    $inscripcionfinal = InscripcionFinal::where('mesaexamen_id', '=', $mesa->id)->where('segundollamado', '=', 1)->get();

                    if ($inscripcionfinal) {
                        foreach ($inscripcionfinal as $temp) {
                            $inscriptos [] = ['id' => $temp->id,'fecha' => $mesa->fechasegundollamado, 'alumno' => $temp->alumno->persona->apellido .' ' . $temp->alumno->persona->nombre, 'plan' => $mesa->materia->planestudio->codigoplan, 'materia' => $mesa->materia->nombremateria, 'docentetitular' => $docente, 'anulado' => $temp->anulado];
                        }
                    }
                }
            } else { //filtro dni
                if ($llamado == 1) {
                    $inscripcionfinal = InscripcionFinal::where('mesaexamen_id', '=', $mesa->id)->where('primerllamado', '=', 1)->get();    

                    if ($inscripcionfinal) {
                        foreach ($inscripcionfinal as $temp) {

                            if ($temp->alumno->persona->nrodocumento == $dni) {
                                $inscriptos [] = ['id' => $temp->id,'fecha' => $mesa->fechaprimerllamado, 'alumno' => $temp->alumno->persona->apellido .' ' . $temp->alumno->persona->nombre, 'plan' => $mesa->materia->planestudio->codigoplan, 'materia' => $mesa->materia->nombremateria, 'docentetitular' => $docente, 'anulado' => $temp->anulado];
                            }
                        }
                    }
                } else {
                    $inscripcionfinal = InscripcionFinal::where('mesaexamen_id', '=', $mesa->id)->where('segundollamado', '=', 1)->get();

                    if ($inscripcionfinal) {
                        foreach ($inscripcionfinal as $temp) {
                            if ($temp->alumno->persona->nrodocumento == $dni) {
                                $inscriptos [] = ['id' => $temp->id,'fecha' => $mesa->fechasegundollamado, 'alumno' => $temp->alumno->persona->apellido .' ' . $temp->alumno->persona->nombre, 'plan' => $mesa->materia->planestudio->codigoplan, 'materia' => $mesa->materia->nombremateria, 'docentetitular' => $docente, 'anulado' => $temp->anulado];
                            }
                        }
                    }
                }       
            }
        }
        
        $organizaciones = Organizacion::lists('nombre', 'id');

        $carreras = Carrera::where('organizacion_id', '=', $org_id)->get();

        $materias = Materia::where('carrera_id', '=', $carr_id)->orderBy('nombremateria')->get();

        foreach ($materias as $temp) {
            $temp->nombremateria = $temp->nombremateria .' - ' . $temp->planestudio->codigoplan; 
        }

        $ciclos = CicloLectivo::where('organizacion_id','=',$org_id)->orderby('descripcion', 'DESC')->get();

        $turnos = TurnoExamen::all();
       
        return View::make('inscripcionfinal/listado')
            ->with('organizaciones', $organizaciones)
            ->with('carreras', $carreras)
            ->with('materias', $materias)
            //->with('opcion', $opcion)
            ->with('ciclos', $ciclos)
            ->with('turnos', $turnos)
            ->with('org_id', $org_id)
            ->with('carr_id', $carr_id)
            ->with('materia_id', $materia_id)
            ->with('ciclo_id', $ciclo_id)
            ->with('turno_id', $turno_id )
            ->with('llamado', $llamado )
            ->with('filtro', $filtro )
            ->with('dni', $dni )
            ->with('inscriptos', $inscriptos)
            ->with('menu', ModulosHelper::MENU_GESTION_ACADEMICA)
            ->with('submenu', ModulosHelper::SUBMENU_INSCRIPCIONES)
            ->with('leer', Session::get('INSCRIPCION_LEER'))
            ->with('editar', Session::get('INSCRIPCION_EDITAR'))
            ->with('imprimir', Session::get('INSCRIPCION_IMPRIMIR'))
            ->with('eliminar', Session::get('INSCRIPCION_ELIMINAR'));

        //echo Response::json($inscriptos);
    }

    public function postObtenerciclolectivo()
    {
        if (Input::get('plan_id') == 0) {
            $ciclo_act = 0;
        } else {
            $plan = PlanEstudio::find(Input::get('plan_id'))->first();
            $ciclo = CicloLectivo::find($plan->ciclolectivo_id);
            $ciclo_act = $ciclo->activo;
        }

        return $ciclo_act;
    }

    public function postObtenermaterias()
    {
        $alumno = Alumno::where('nrolegajo', '=', Input::get('nrodni'))->get();
        
        foreach ($alumno as $data) {
            $id = $data->id;    
        }

        $alumno = Alumno::find($id);

        foreach ($alumno->carreras as $data) {
            $carrera = $data->pivot->carrera_id;
        }

        $mats = [];
        $materias = Materia::where('carrera_id', '=', $carrera)->get(); 
        
        foreach ($materias as $materia) {
            $mats[$materia->id] = [
                'id'      => (int)$materia->id,
                'nombre'  => $materia->nombremateria,
                'plan'    => $materia->planestudio->codigoplan, 
                'carrera' => $materia->planestudio->carrera->Abreviatura
            ];
        }

        return $mats;
    }

    public function getCrear()
    {
        $organizaciones = Organizacion::lists('nombre', 'id');

        array_unshift($organizaciones, 'Seleccione');

        return View::make('inscripcionfinal.nuevo')->with([
            'arrOrganizaciones' => $organizaciones,
            'carreras'          => Carrera::lists('carrera', 'id'),
            'planes'            => PlanEstudio::lists('codigoplan', 'id'),
            'menu'              => ModulosHelper::MENU_GESTION_ACADEMICA,
            'submenu'           => ModulosHelper::SUBMENU_INSCRIPCIONES,
            'leer'              => Session::get('INSCRIPCION_LEER'),
            'editar'            => Session::get('INSCRIPCION_EDITAR'),
            'imprimir'          => Session::get('INSCRIPCION_IMPRIMIR'),
            'eliminar'          => Session::get('INSCRIPCION_ELIMINAR'),
            'finales'           => InscripcionFinal::all()->toArray()
        ]);
    }

    /*public function getNuevo()
    {
        return View::make('inscripcion.nuevo');
    }*/

    public function postGuardar()
    {
        $data = Input::all();

        foreach ($data['materiasdisponibles'] as $k => $materia) {
            $inscripto = new InscripcionFinal();
            $inscripto->alumno_id      = $data['alumno_id'];
            $inscripto->mesaexamen_id     = $materia;

            if ($data['valorllamada'] == 1) {
                $inscripto->primerllamado = 1;
            } else {
                $inscripto->segundollamado = 1;
            }

            $inscripto->fecha_alta     = date('Y-m-d H:i:s');
            $inscripto->usuario_alta   = Auth::user()->usuario;

            $inscripto->save();
        }

        $organizaciones = Organizacion::lists('nombre', 'id');

        array_unshift($organizaciones, 'Seleccione');

        Session::flash('message', 'LOS DATOS SE GUARDARON CORRECTAMENTE.');
        Session::flash('message_type', self::OPERACION_EXITOSA);

        return  Redirect::to('inscripcionfinal/crear')->with([
            'arrOrganizaciones' => $organizaciones,
            'carreras'          => Carrera::lists('carrera', 'id'),
            'planes'            => PlanEstudio::lists('codigoplan', 'id'),
            'menu'              => ModulosHelper::MENU_GESTION_ACADEMICA,
            'submenu'           => ModulosHelper::SUBMENU_INSCRIPCIONES,
            'leer'              => Session::get('INSCRIPCION_LEER'),
            'editar'            => Session::get('INSCRIPCION_EDITAR'),
            'imprimir'          => Session::get('INSCRIPCION_IMPRIMIR'),
            'eliminar'          => Session::get('INSCRIPCION_ELIMINAR'),
            'finales'           => InscripcionFinal::all()->toArray()
        ]);

    }

    public function getEditar($id)
    {
        $insc = InscripcionFinal::Find($id);
        return View::make('inscripcionfinal.edit')->with($insc);
    }

    public function postEditar($id)
    {
        $data = Input::all();
        $inscripto = InscripcionFinal::find($id);

        $inscripto->docente_id     = $data['docente_id'];
        $inscripto->planestudio_id = $data['planestudio_id'];
        $inscripto->alumno_id      = $data['alumno_id'];
        $inscripto->materia_id     = $data['materia_id'];
        $inscripto->fecha          = $data['fecha'];
        $inscripto->fecha_modi     = date('Y-m-d');
        $inscripto->usuario_modi   = Auth::user()->usuario;

        if ($inscripto->save()) {
            return Redirect('editar/'.$inscripto->id);
        }
    }
    
    public function postObtenerplanes() 
    {
        $planes = PlanEstudio::where('carrera_id', '=', Input::get('id'))->get();
        
        return  Response::json($planes);       
    } 

    public function postObtenerturnos() 
    {
        $turnos = TurnoExamen::all();
        
        return Response::json($turnos);       
    } 

    public function postObtenerllamados() 
    {
        $turno = TurnoExamen::where('id', '=', Input::get('id'))->first();
        
        $resultado = $turno->llamadounico;
       
        return $resultado;       
    } 

    public function postObtenermesas() 
    {
        $mesas = [];
        $carr_id = Input::get('id');
        $plan_id = Input::get('plan_id');
        $turno_id = Input::get('turno_id');
        $alumno_id = Input::get('alumno_id');
        $llamado = Input::get('llamado');
        $estado = 1;
        $matriculas = 0;
        $cuota = 0;
        $derecho = 0;
        //$ciclo = PlanEstudio::find($plan_id)->ciclolectivo_id;
        $ciclo = CicloLectivo::whereRaw('organizacion_id = 1 AND activo=1')->first()->id;

        $beca = Beca::whereRaw('carrera_id ='.$carr_id.' AND alumno_id ='.$alumno_id.' AND ciclolectivo_id ='.$ciclo.' AND becado=1')->get();
        
        if (count($beca) > 0) {
            $estado = 0;
        } else {
            // validar que tenga pagada la matricula del siglo lectivo actual
            $matricula = Matricula::where('carrera_id', '=', $carr_id)->where('ciclolectivo_id', '=', $ciclo)->first();

            if ($matricula) {
                $pagomatricula = DetalleMatriculaPago::where('alumno_id', '=', $alumno_id)->where('matricula_id', '=', $matricula->id)->where('mescuota', '=', 0)->where('totalparcial', '=', 0)->first();

                if ($pagomatricula) {
                    $estado = 0;
                } else {
                    $estado = 1;
                    $matriculas = 1;
                }

                $pagocuota = DetalleCuotaPago::where('alumno_id', '=', $alumno_id)->where('matricula_id', '=', $matricula->id)->where('mescuota', '=',  (int)  date('m'))->first();

                if ($pagocuota) {
                    $estado = 0;
                } else {
                    $estado = 2;
                    $cuota = 1;
                }
            }
        }

        // derecho de examen
        $derechos = CajaChica::where('alumno_id', '=', $alumno_id)->where('carrera_id', '=', $carr_id)->where('concepto_id', '=', 1)->get();

        foreach ($derechos as $der) {
            if ((int) date('m', strtotime(str_replace('-','/', $der->fechatransaccion))) == (int) date('m')) {
                $estado = 0;
            } else {
                $estado = 3;
                $derecho = 1;
            }
        }
        //

        if ($estado !== 0) {
            /*if ($estado == 1) {
                $mesas [] = 2;//['id' => 2]; // falta matriculas
            } else if ($estado == 2) {
                $mesas [] = 3;//['id' => 3]; // falta falta cuota del mes
            } else if ($estado == 3) {
                $mesas [] = 4;//['id' => 4]; // falta falta derecho de examen
            }*/

            if ($matriculas == 1) {
                $mesas[] = 2;//['id' => 2]; // falta matriculas
            } else if ($cuota == 1) {
                $mesas[] = 3;//['id' => 3]; // falta falta cuota del mes
            } else if ($derecho == 1) {
                $mesas[] = 4;//['id' => 4]; // falta falta derecho de examen
            }
        } else {
            $temp = MesaExamen::where('carrera_id', '=', $carr_id)->where('ciclolectivo_id', '=', $ciclo)->where('turnoexamen_id', '=', $turno_id)->get();

            if ($temp) {
                foreach ($temp as $tp) {
                    $materia = Materia::where('id', '=', $tp->materia_id)->where('planestudio_id','=', $plan_id)->first();

                    if ($materia) {
                        $regular = Regularidades::where('carrera_id', '=', $carr_id)->where('planestudio_id', '=', $plan_id)->where('materia_id', '=', $tp->materia_id)->where('alumno_id','=', $alumno_id)->where('regularizo', '=', 1)->first();
                        
                        if ($regular) {
                            //verificar que no exista el re
                            $existe = InscripcionFinal::where('alumno_id', '=', $alumno_id)->where('mesaexamen_id', '=', $tp->id)->first();
                            
                            if (!$existe) {
                                $examenfinal = ExamenFinal::whereRaw('alumno_id ='.$alumno_id.' AND carrera_id ='.$carr_id.' AND planestudio_id ='.$plan_id.' AND materia_id ='.$tp->materia_id)->get();
                                
                                if (count($examenfinal) > 0) {
                                    foreach ($examenfinal as $value) {
                                        if ($value->calif_final_num < 5 || $value->asistencia == 1) {
                                            $mesas[] = ['id' => $tp->id, 'materia' => $materia->nombremateria];
                                        }
                                    }
                                } else {
                                    $mesas[] = ['id' => $tp->id, 'materia' => $materia->nombremateria];
                                }
                            }
                        }
                    }
                }
            } else {
                unset($mesas);
                $mesas[] = 1;//['id' => 1]; // 1 = no se encontraron mesas con estos parametros
            }
        }
        
        if ($estado == 0) {
            return  Response::json($mesas);       
        } else {
            return  $mesas;
        }
    }

    public function postObtenerinscripciones() 
    {
        $materias = [];
        $carr_id    = Input::get('id');
        $plan_id    = Input::get('plan_id');
        $ciclo      = CicloLectivo::where('descripcion', '=', Input::get('ciclo_id'))->first();
        $turno_id   = Input::get('turno_id');
        $alumno_id  = Input::get('alumno_id');
        $llamado    = Input::get('llamado');

        $mesas = MesaExamen::where('carrera_id', '=', $carr_id)->where('ciclolectivo_id', '=', $ciclo->id)->where('turnoexamen_id', '=', $turno_id)->get();

        if ($mesas) {
            foreach ($mesas as $mesa) {
                $final = InscripcionFinal::where('mesaexamen_id', '=', $mesa->id)->where('alumno_id', '=', $alumno_id)->where('anulado', '=', 0)->first();

                if ($final) {
                    if ($final->primerllamado == 1) {
                        $fecha = FechaHelper::getFechaImpresion($mesa->fechaprimerllamado);
                    } else {
                        $fecha = FechaHelper::getFechaImpresion($mesa->fechasegundollamado);
                    }

                    $materias[] = ['fecha' => $fecha, 'plan' => $mesa->materia->planestudio->codigoplan, 'materia' => $mesa->materia->nombremateria];
                }
            }
        }
        
        return Response::json($materias); 
    }

    public function postBorrar()
    {
        $id = Input::get('idInscripcionHidden');

        $examen = ExamenFinal::where('inscripcionfinal_id', '=', $id )->first();

        if ($examen) {
            Session::flash('message', 'NO SE PUDO ELIMINAR LA INSCRIPCION');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('inscripcionfinal');
        }
        
        /*if ($correlatividad->correlatividadesaprobadas) {
            Session::flash('message', 'NO SE PUDO ELIMINAR LA CORRELATIVIDAD');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('correlatividades/listado');
        }*/
        
        InscripcionFinal::where('id', '=', $id)->delete();
        //MesaExamen::where('id', '=', $id)->delete();

        Session::flash('message', 'LA INCRIPCION AL EXAMEN HA SIDO BORRADA CORRECTAMENTE.');
        Session::flash('message_type', self::OPERACION_EXITOSA);
        return Redirect::to('inscripcionfinal');
    }

    public function postAnular()
    {
        $id = Input::get('idAnularHidden');
        $cbofil = Input::get('cbofil');
        $txtfil = Input::get('txtfil');

        $examen = ExamenFinal::where('inscripcionfinal_id', '=', $id )->first();

        if ($examen) {
            Session::flash('message', 'NO SE PUDO ANULAR LA INSCRIPCION');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('inscripcionfinal');
        }
        
        /*if ($correlatividad->correlatividadesaprobadas) {
            Session::flash('message', 'NO SE PUDO ELIMINAR LA CORRELATIVIDAD');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('correlatividades/listado');
        }
        highlight_string(var_export($materias,true));
        exit();*/
        
        $inscripcion = InscripcionFinal::find($id);
            $inscripcion->anulado           =  1;
            $inscripcion->usuario_anula     =  Auth::user()->usuario;
            $inscripcion->fecha_anulacion   =  date('Y-m-d');
        $inscripcion->save();

        //MesaExamen::where('id', '=', $id)->delete();
        if ($txtfil == '') {
            $txtfil = 0;
        }

        $idaseguir = $id.'-'.$cbofil.'-'.$txtfil;

        Session::flash('message', 'LA INCRIPCION AL EXAMEN HA SIDO ANULADA CORRECTAMENTE.');
        Session::flash('message_type', self::OPERACION_EXITOSA);
        return Redirect::to('inscripcionfinal/anulado/'.$idaseguir);
    }

    public function getAnulado($idaseguir)
    {  
        $porcion = explode("-", $idaseguir);

        $id = $porcion[0];
        $filtro = $porcion[1];
        $dni = $porcion[2];

        if ($dni == 0) {
            $dni = '';
        }

        $inscripcion = InscripcionFinal::find($id);

        $mesaexamen = MesaExamen::find($inscripcion->mesaexamen_id);

        $planID = Materia::find($mesaexamen->materia_id)->planestudio_id;

        $organizaciones = Organizacion::lists('nombre', 'id');
        $carreras = Carrera::where('organizacion_id', '=', 1)->get();
        $materias = Materia::where('carrera_id', '=', $mesaexamen->carrera_id)->where('planestudio_id', '=', $planID)->get();
        $ciclos = CicloLectivo::all();
        $turnoexamen = TurnoExamen::find($mesaexamen->turnoexamen_id);

        if ($inscripcion->primerllamado == 1) {
            $llamado = 1;
        } else {
            $llamado = 0;
        }
        //////////////////////
        $mesa = MesaExamen::where('carrera_id', '=', $mesaexamen->carrera_id)->where('ciclolectivo_id', '=', $mesaexamen->ciclolectivo_id)->where('turnoexamen_id', '=', $mesaexamen->turnoexamen_id)->where('materia_id', '=', $mesaexamen->materia_id)->first();

        if ($mesa) {
            $mesa->fechaprimerllamado = FechaHelper::getFechaImpresion($mesa->fechaprimerllamado);
            $mesa->fechasegundollamado = FechaHelper::getFechaImpresion($mesa->fechasegundollamado);

            $asignard = AsignarDocente::where('materia_id', '=', $mesa->materia_id)->first();

            if ($asignard) {
                $tempdocente = Docente::where('id', '=', $asignard->docentetitular_id)->first();

                if ($tempdocente) {
                    $docente =  $tempdocente->persona->apellido .' ' . $tempdocente->persona->nombre;
                } else {
                    $docente = '';
                }
            } else {
                $docente = '';
            }
            
            if ($filtro == 1) { //filtro todos
                if ($llamado == 1) {
                    $inscripcionfinal = InscripcionFinal::where('mesaexamen_id', '=', $mesa->id)->where('primerllamado', '=', 1)->get();    

                    if ($inscripcionfinal) {
                        foreach ($inscripcionfinal as $temp) {
                            $inscriptos [] = ['id' => $temp->id,'fecha' => $mesa->fechaprimerllamado, 'alumno' => $temp->alumno->persona->apellido .' ' . $temp->alumno->persona->nombre, 'plan' => $mesa->materia->planestudio->codigoplan, 'materia' => $mesa->materia->nombremateria, 'docentetitular' => $docente, 'anulado' => $temp->anulado];
                        }
                    }
                } else {
                    $inscripcionfinal = InscripcionFinal::where('mesaexamen_id', '=', $mesa->id)->where('segundollamado', '=', 1)->get();

                    if ($inscripcionfinal) {
                        foreach ($inscripcionfinal as $temp) {
                            $inscriptos [] = ['id' => $temp->id,'fecha' => $mesa->fechasegundollamado, 'alumno' => $temp->alumno->persona->apellido .' ' . $temp->alumno->persona->nombre, 'plan' => $mesa->materia->planestudio->codigoplan, 'materia' => $mesa->materia->nombremateria, 'docentetitular' => $docente, 'anulado' => $temp->anulado];
                        }
                    }
                }
            } else { //filtro dni
                if ($llamado == 1) {
                    $inscripcionfinal = InscripcionFinal::where('mesaexamen_id', '=', $mesa->id)->where('primerllamado', '=', 1)->get();    

                    if ($inscripcionfinal) {
                        foreach ($inscripcionfinal as $temp) {

                            if ($temp->alumno->persona->nrodocumento == $dni) {
                                $inscriptos [] = ['id' => $temp->id,'fecha' => $mesa->fechaprimerllamado, 'alumno' => $temp->alumno->persona->apellido .' ' . $temp->alumno->persona->nombre, 'plan' => $mesa->materia->planestudio->codigoplan, 'materia' => $mesa->materia->nombremateria, 'docentetitular' => $docente, 'anulado' => $temp->anulado];
                            }
                        }
                    }
                } else {
                    $inscripcionfinal = InscripcionFinal::where('mesaexamen_id', '=', $mesa->id)->where('segundollamado', '=', 1)->get();

                    if ($inscripcionfinal) {
                        foreach ($inscripcionfinal as $temp) {
                            if ($temp->alumno->persona->nrodocumento == $dni) {
                                $inscriptos [] = ['id' => $temp->id,'fecha' => $mesa->fechasegundollamado, 'alumno' => $temp->alumno->persona->apellido .' ' . $temp->alumno->persona->nombre, 'plan' => $mesa->materia->planestudio->codigoplan, 'materia' => $mesa->materia->nombremateria, 'docentetitular' => $docente, 'anulado' => $temp->anulado];
                            }
                        }
                    }
                }       
            }
        }
        ////////////////////////
        $turnos = TurnoExamen::all();

        return View::make('inscripcionfinal.listado',[
            'organizaciones'    => $organizaciones,
            'organizacion_id'   => $mesaexamen->organizacion_id,
            'carreras'          => $carreras,
            'carr_id'           => $mesaexamen->carrera_id,
            'materias'          => $materias,
            'materia_id'        => $mesaexamen->materia_id,
            'ciclos'            => $ciclos,
            'ciclo_id'          => $mesaexamen->ciclolectivo_id,
            'turnos'            => $turnos,
            'turno_id'          => $mesaexamen->turnoexamen_id,
            'llamado'           => $llamado,
            'filtro'            => $filtro,
            'dni'               => $dni,
            'inscriptos'        => $inscriptos
        ])->with('menu', ModulosHelper::MENU_GESTION_ACADEMICA)
            ->with('submenu', ModulosHelper::SUBMENU_INSCRIPCIONES)
            ->with('leer', Session::get('INSCRIPCION_LEER'))
            ->with('editar', Session::get('INSCRIPCION_EDITAR'))
            ->with('imprimir', Session::get('INSCRIPCION_IMPRIMIR'))
            ->with('eliminar', Session::get('INSCRIPCION_ELIMINAR'));
    }

    public function getImprimiracuse($id)
    {
        $inscripcion = InscripcionFinal::where('id', '=', $id)->first();

        $mesa = MesaExamen::where('id','=',$inscripcion->mesaexamen_id)->first();

        if ($inscripcion->primerllamado == 1) {
            $fecha = FechaHelper::getFechaImpresion($mesa->fechaprimerllamado);
            $llamado = 'Primer Llamado';
        } else {
            $fecha = FechaHelper::getFechaImpresion($mesa->fechasegundollamado);
            $llamado = 'Segundo Llamado';
        }

        $docentes = TribunalDocente::where('mesaexamen_id', '=', $mesa->id)->get();

        foreach ($docentes as $value) {
            $tribunal = $value->docente->persona->apellido .' '. $value->docente->persona->nombre;
        }

        $materia = $mesa->materia->nombremateria;

        $plan = $mesa->materia->planestudio->codigoplan;

        //$plan = $mesa->materia->planestudio->codigoplan;

        //echo $mesa->turnoexamen->descripcion;
        
        $pdf = PDF::loadView('informes.pdf.acuseinscripcionanulacion', 
            ['inscripcion' => $inscripcion,
             'mesa'=>$mesa,
             'inscripcion'=>$inscripcion,
             'fecha'=>$fecha,
             'tribunal' => $tribunal,
             'materia' => $materia,
             'llamado' => $llamado,
             'plan' => $plan
            ]);
        return $pdf->setOrientation('landscape')->stream();
    }


    public function getImprimirlistado()
    {
        $inscriptos = [];

        $org_id     = Input::get('organizacion');
        $carr_id    = Input::get('carrera');
        $ciclo_id   = Input::get('ciclos');
        $turno_id   = Input::get('turnos');
        $materia_id = Input::get('materias');
        $llamado    = Input::get('llamado');
        $filtro     = Input::get('cboFiltro');
        $dni        = Input::get('nrodocumento');

        $mesa = MesaExamen::where('carrera_id', '=', $carr_id)->where('ciclolectivo_id', '=', $ciclo_id)->where('turnoexamen_id', '=', $turno_id)->where('materia_id', '=', $materia_id)->first();

        echo $materia_id;

        if ($mesa) {
            $mesa->fechaprimerllamado = FechaHelper::getFechaImpresion($mesa->fechaprimerllamado);
            $mesa->fechasegundollamado = FechaHelper::getFechaImpresion($mesa->fechasegundollamado);

            $asignard = AsignarDocente::where('materia_id', '=', $mesa->materia_id)->first();

            if ($asignard) {
                $tempdocente = Docente::where('id', '=', $asignard->docentetitular_id)->first();

                if ($tempdocente) {
                    $docente =  $tempdocente->persona->apellido .' ' . $tempdocente->persona->nombre;
                } else {
                    $docente = '';
                }
            } else {
                $docente = '';
            }
            
            if ($filtro == 1) { //filtro todos
                if ($llamado == 1) {
                    $inscripcionfinal = InscripcionFinal::where('mesaexamen_id', '=', $mesa->id)->where('primerllamado', '=', 1)->get();    

                    if ($inscripcionfinal) {
                        foreach ($inscripcionfinal as $temp) {
                            $inscriptos [] = ['id' => $temp->id,'fecha' => $mesa->fechaprimerllamado, 'alumno' => $temp->alumno->persona->apellido .' ' . $temp->alumno->persona->nombre, 'plan' => $mesa->materia->planestudio->codigoplan, 'materia' => $mesa->materia->nombremateria, 'docentetitular' => $docente, 'anulado' => $temp->anulado];
                        }
                    }
                } else {
                    $inscripcionfinal = InscripcionFinal::where('mesaexamen_id', '=', $mesa->id)->where('segundollamado', '=', 1)->get();

                    if ($inscripcionfinal) {
                        foreach ($inscripcionfinal as $temp) {
                            $inscriptos [] = ['id' => $temp->id,'fecha' => $mesa->fechasegundollamado, 'alumno' => $temp->alumno->persona->apellido .' ' . $temp->alumno->persona->nombre, 'plan' => $mesa->materia->planestudio->codigoplan, 'materia' => $mesa->materia->nombremateria, 'docentetitular' => $docente, 'anulado' => $temp->anulado];
                        }
                    }
                }
            } else { //filtro dni
                if ($llamado == 1) {
                    $inscripcionfinal = InscripcionFinal::where('mesaexamen_id', '=', $mesa->id)->where('primerllamado', '=', 1)->get();    

                    if ($inscripcionfinal) {
                        foreach ($inscripcionfinal as $temp) {
                            if ($temp->alumno->persona->nrodocumento == $dni ) {
                                $inscriptos [] = ['id' => $temp->id,'fecha' => $mesa->fechaprimerllamado, 'alumno' => $temp->alumno->persona->apellido .' ' . $temp->alumno->persona->nombre, 'plan' => $mesa->materia->planestudio->codigoplan, 'materia' => $mesa->materia->nombremateria, 'docentetitular' => $docente, 'anulado' => $temp->anulado];
                            }
                        }
                    }
                } else {
                    $inscripcionfinal = InscripcionFinal::where('mesaexamen_id', '=', $mesa->id)->where('segundollamado', '=', 1)->get();

                    if ($inscripcionfinal){
                        foreach ($inscripcionfinal as $temp) {
                            if ($temp->alumno->persona->nrodocumento == $dni ){
                                $inscriptos [] = ['id' => $temp->id,'fecha' => $mesa->fechasegundollamado, 'alumno' => $temp->alumno->persona->apellido .' ' . $temp->alumno->persona->nombre, 'plan' => $mesa->materia->planestudio->codigoplan, 'materia' => $mesa->materia->nombremateria, 'docentetitular' => $docente, 'anulado' => $temp->anulado];
                            }
                        }
                    }
                }       
            }
        }
        
        if ($llamado == 1) {
            $llamado = 'Primer Llamado';
        } else {
            $llamado = 'Segundo Llamado';
        }

        $carrera = Carrera::where('id', '=', $carr_id)->first();
        //echo Response::json($inscriptos);

        $pdf = PDF::loadView('informes.pdf.listadomateriasfinales', 
            ['inscriptos'=>$inscriptos,
             'carrera'=>$carrera,
             'llamado'=>$llamado
            ]);
        return $pdf->setOrientation('landscape')->stream();
    }


    public function getImprimirlistadototal()
    {
        $materias = [];

        $carr_id    = Input::get('carr_id');
        $plan_id    = Input::get('plan_id');
        $ciclo      = CicloLectivo::where('descripcion', '=', Input::get('ciclo_id'))->first();
        $turno_id   = Input::get('turno_id');
        $alumno_id  = Input::get('alumno_id');
        $llamado    = Input::get('llamado');

        $mesas = MesaExamen::where('carrera_id', '=', $carr_id)->where('ciclolectivo_id', '=', $ciclo->id)->where('turnoexamen_id', '=', $turno_id)->get();

        if ($mesas) {
            foreach ($mesas as $mesa) {
                $final = InscripcionFinal::where('mesaexamen_id', '=', $mesa->id)->where('alumno_id', '=', $alumno_id)->where('anulado', '=', 0)->first();

                if ($final) {
                    if ($final->primerllamado == 1) {
                        $fecha = FechaHelper::getFechaImpresion($mesa->fechaprimerllamado);
                    } else {
                        $fecha = FechaHelper::getFechaImpresion($mesa->fechasegundollamado);
                    }

                    $materias[] = ['fecha' => $fecha, 'plan' => $mesa->materia->planestudio->codigoplan, 'materia' => $mesa->materia->nombremateria];
                }
            }
        }

        $carrera = Carrera::where('id', '=', $carr_id)->first();

        $alumno = Alumno::where('id', '=', $alumno_id)->first();

        $turno = TurnoExamen::where('id', '=', $turno_id)->first();

        $pdf = PDF::loadView('informes.pdf.listadomateriasfinalestotal', 
            ['materias' =>  $materias,
             'carrera'  =>  $carrera,
             'alumno'   =>  $alumno,
             'turno'    =>  $turno
            ]);
        return $pdf->setOrientation('landscape')->stream();
    }
}
