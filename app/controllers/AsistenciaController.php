<?php

class AsistenciaController extends \BaseController {

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
		return Redirect::to('asistencias/listado');
	}

	public function getListado()
	{
        //$organizaciones = Organizacion::lists('nombre', 'id');
        //$organizaciones[0] = 'Seleccionar';
        //ksort($organizaciones);
        $organizaciones = Organizacion::all();
        $org_id = 0;

        //$carreras = Carrera::where('organizacion_id', '=', 1)->get();

        //Genero la semana a mostrar, lunes a sabado
        $meses = ['vacio', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        $dias = ['vacio', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];
        $date = strtotime(date("Y-m-d"));
		$first = strtotime('last Sunday 1 days');
		$last = strtotime('next Saturday 0 days');
		//echo date('Y-m-d', $first);
		//echo '<br>';
		//echo date('Y-m-d', $last);
        $porcion = explode("-", date('d-m-Y', $first));
		$lunes = $porcion[0];
		$lunesmes = (string)(int)$porcion[1];

		$fecha = date('d-m-Y', $first);
		$nuevafecha = strtotime('+1 day', strtotime($fecha)) ;
		$porcion = explode("-", date('d-m-Y', $nuevafecha));
		$martes = $porcion[0];
		$martesmes = (string)(int)$porcion[1];

		$nuevafecha = strtotime('+2 day', strtotime($fecha)) ;
		$porcion = explode("-", date('d-m-Y', $nuevafecha));
		$miercoles = $porcion[0];
		$miercolesmes = (string)(int)$porcion[1];

		$nuevafecha = strtotime('+3 day', strtotime($fecha)) ;
		$porcion = explode("-", date('d-m-Y', $nuevafecha));
		$jueves = $porcion[0];
		$juevesmes = (string)(int)$porcion[1];

		$nuevafecha = strtotime('+4 day', strtotime($fecha)) ;
		$porcion = explode("-", date('d-m-Y', $nuevafecha));
		$viernes = $porcion[0];
		$viernesmes = (string)(int)$porcion[1];

		$nuevafecha = strtotime('+5 day', strtotime($fecha)) ;
		$porcion = explode("-", date('d-m-Y', $nuevafecha));
		$sabado = $porcion[0];
		$sabadomes = (string)(int)$porcion[1];

		$dni = '';
        $fecha = '';
		$habilita = false;

        return View::make('asistencias.listado')
            ->with('organizaciones', $organizaciones)
            ->with('org_id', $org_id)
            ->with('lunes', $lunes)
            ->with('lunesmes', $lunesmes)
            ->with('martes', $martes)
            ->with('martesmes', $martesmes)
            ->with('miercoles', $miercoles)
            ->with('miercolesmes', $miercolesmes)
            ->with('jueves', $jueves)
            ->with('juevesmes', $juevesmes)
            ->with('viernes', $viernes)
            ->with('viernesmes', $viernesmes)
            ->with('sabado', $sabado)
            ->with('sabadomes', $sabadomes)
            ->with('meses', $meses)
            ->with('dias', $dias)
            ->with('habilita', $habilita)
            ->with('dni', $dni)
            ->with('fecha', $fecha)
            ->with('menu', ModulosHelper::MENU_GESTION_ACADEMICA)
            ->with('submenu', ModulosHelper::SUBMENU_ASISTENCIA)
            ->with('leer', Session::get('ASISTENCIA_LEER'))
            ->with('editar', Session::get('ASISTENCIA_EDITAR'))
            ->with('imprimir', Session::get('ASISTENCIA_IMPRIMIR'))
            ->with('eliminar', Session::get('ASISTENCIA_ELIMINAR'));
	}

    public function getCrear()
    {
        $organizaciones = Organizacion::all();
        $org_id = 0;

        //$carreras = Carrera::where('organizacion_id', '=', 1)->get();

        //Genero la semana a mostrar, lunes a sabado
        $meses = ['vacio', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        $dias = ['vacio', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];
        $date = strtotime(date("Y-m-d"));
        $first = strtotime('last Sunday 1 days');
        $last = strtotime('next Saturday 0 days');
        //echo date('Y-m-d', $first);
        //echo '<br>';
        //echo date('Y-m-d', $last);
        $porcion = explode("-", date('d-m-Y', $first));
        $lunes = $porcion[0];
        $lunesmes = (string)(int)$porcion[1];

        $fecha = date('d-m-Y', $first);
        $nuevafecha = strtotime('+1 day', strtotime($fecha)) ;
        $porcion = explode("-", date('d-m-Y', $nuevafecha));
        $martes = $porcion[0];
        $martesmes = (string)(int)$porcion[1];

        $nuevafecha = strtotime('+2 day', strtotime($fecha)) ;
        $porcion = explode("-", date('d-m-Y', $nuevafecha));
        $miercoles = $porcion[0];
        $miercolesmes = (string)(int)$porcion[1];

        $nuevafecha = strtotime('+3 day', strtotime($fecha)) ;
        $porcion = explode("-", date('d-m-Y', $nuevafecha));
        $jueves = $porcion[0];
        $juevesmes = (string)(int)$porcion[1];

        $nuevafecha = strtotime('+4 day', strtotime($fecha)) ;
        $porcion = explode("-", date('d-m-Y', $nuevafecha));
        $viernes = $porcion[0];
        $viernesmes = (string)(int)$porcion[1];

        $nuevafecha = strtotime('+5 day', strtotime($fecha)) ;
        $porcion = explode("-", date('d-m-Y', $nuevafecha));
        $sabado = $porcion[0];
        $sabadomes = (string)(int)$porcion[1];

        $dni = '';
        $fecha = '';
        $habilita = false;

        return View::make('asistencias.nuevo')
            ->with('organizaciones', $organizaciones)
            ->with('org_id', $org_id)
            ->with('lunes', $lunes)
            ->with('lunesmes', $lunesmes)
            ->with('martes', $martes)
            ->with('martesmes', $martesmes)
            ->with('miercoles', $miercoles)
            ->with('miercolesmes', $miercolesmes)
            ->with('jueves', $jueves)
            ->with('juevesmes', $juevesmes)
            ->with('viernes', $viernes)
            ->with('viernesmes', $viernesmes)
            ->with('sabado', $sabado)
            ->with('sabadomes', $sabadomes)
            ->with('meses', $meses)
            ->with('dias', $dias)
            ->with('habilita', $habilita)
            ->with('dni', $dni)
            ->with('fecha', $fecha)
            ->with('menu', ModulosHelper::MENU_GESTION_ACADEMICA)
            ->with('submenu', ModulosHelper::SUBMENU_ASISTENCIA)
            ->with('leer', Session::get('ASISTENCIA_LEER'))
            ->with('editar', Session::get('ASISTENCIA_EDITAR'))
            ->with('imprimir', Session::get('ASISTENCIA_IMPRIMIR'))
            ->with('eliminar', Session::get('ASISTENCIA_ELIMINAR'));
    }

    public function postObtenerplanes()
    {
        $carrera_id = Input::get('carrera_id');
        $planes = PlanEstudio::where('carrera_id', '=', $carrera_id)->get();

        return Response::json($planes);
    }

    public function postObtenermaterias() 
    {
        $carrid = Input::get('carrera_id');
        $planID = Input::get('plan_id');
        $materia_id = Input::get('materia_id');
        $cboCiclos = Input::get('cboCiclos');

        if ($materia_id == '') {
            $materias = Materia::where('carrera_id', '=', $carrid)->where('planestudio_id', '=', $planID)->get();
        } else {
            $materias = Materia::find($materia_id)->periodo;
        }
        
        return Response::json($materias);
    }

    public function postObtenerfechas() 
    {
        $carrid = Input::get('carrera_id');
        $planID = Input::get('planID');
        $materia_id = Input::get('materia_id');
        $materias= [];
        $fechainicio = '';
        $fechafin = '';

        $materiass = Materia::find($materia_id);
        
        if ($materiass->periodo == 'Anual') {
            $ciclo_id = PlanEstudio::find($planID)->ciclolectivo_id;

            $ciclos = CicloLectivo::find($ciclo_id);
            $fechaini = FechaHelper::getFechaImpresion($ciclos->fechainicio);
            $fechafi = FechaHelper::getFechaImpresion($ciclos->fechafin);
            //$fecha = date('d/m/Y');

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
                    /*$fechap = strtotime(date('Y-m-d'));
                    $fechainicio = strtotime($fechaini);
                    $fechafin = strtotime($fechafi);*/

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
                    /*if ($fechap > $fechainicio) {
                        if ($fechap < $fechafin) {
                            $fechainicio = $value->fechainic;
                            $fechafin = $value->fechafic;
                        }
                    }*/
                }
            } else {
                $fechainicio = '';
                $fechafin = '';
            }
        }
        
        if (!$fechainicio == '') {
            $porcion = explode("/", $fechainicio);
            $fechainicio = $porcion[2].'-'.$porcion[1].'-'.$porcion[0];
            $porcion = explode("/", $fechafin);
            $fechafin = $porcion[2].'-'.$porcion[1].'-'.$porcion[0];
        }

        $materias[] = ['fechainicio' => $fechainicio, 'fechafin' => $fechafin];

        return Response::json($materias);
    }

    public function postObtenerasistencias() 
    {
        $carrera_id = Input::get('cboCarrera');
        $planID = Input::get('cboPlan');
        $materia_id = Input::get('cboMaterias');
        $ciclo_id = Input::get('cboCiclos');
        $fechacons = Input::get('fechadesde');
        $fechadesde = Input::get('fechadesde');
        $dni = Input::get('txtalumno');//30294929

        $meses = ['vacio', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        $dias = ['vacio', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];

        if ($fechadesde == '') {
        	$fechadesdes = date('Y-m-d');
        	$porcion = explode("-", $fechadesdes);
			//$fecha = $dias[date('N', strtotime($fechadesdes))].' '. $porcion[2] .' de '.$meses[$porcion[1]];
        	$fechadesde = date('d/m/Y');
        } else {
        	$porcion = explode("-", $fechadesde);
			//$fecha = $dias[date('N', strtotime($fechadesde))].' '. $porcion[2] .' de '.$meses[$porcion[1]];
        	$fechadesde = $porcion[2].'/'.$porcion[1].'/'.$porcion[0];
        	$fechadesdes = $porcion[0].'-'.$porcion[1].'-'.$porcion[2];

            $calendario = $porcion[0].'-'.(string)(int)$porcion[1].'-'.$porcion[2];
        }
        //////////////////////////////
        if ($fechacons == '') {
            //Genero la semana a mostrar, lunes a sabado
            $date = strtotime(date("Y-m-d"));
            $first = strtotime('last Sunday 1 days');
            $last = strtotime('next Saturday 0 days');
            //echo date('Y-m-d', $first);
            //echo '<br>';
            //echo date('Y-m-d', $last);
            $porcion = explode("-", date('d-m-Y', $first));
            $fechalunes = date('d/m/Y', $first);
            $fechalunescons = $porcion[2].'-'.$porcion[1].'-'.$porcion[0];
            $lunes = $porcion[0];
            $lunesmes = (string)(int)$porcion[1];

            $fecha = date('d-m-Y', $first);
            $nuevafecha = strtotime('+1 day', strtotime($fecha));
            $fechamartes = date('d/m/Y', $nuevafecha);
            $porcion = explode("-", date('d-m-Y', $nuevafecha));
            $martes = $porcion[0];
            $martesmes = (string)(int)$porcion[1];

            $nuevafecha = strtotime('+2 day', strtotime($fecha));
            $fechamiercoles = date('d/m/Y', $nuevafecha);
            $porcion = explode("-", date('d-m-Y', $nuevafecha));
            $miercoles = $porcion[0];
            $miercolesmes = (string)(int)$porcion[1];

            $nuevafecha = strtotime('+3 day', strtotime($fecha));
            $fechajueves = date('d/m/Y', $nuevafecha);
            $porcion = explode("-", date('d-m-Y', $nuevafecha));
            $jueves = $porcion[0];
            $juevesmes = (string)(int)$porcion[1];

            $nuevafecha = strtotime('+4 day', strtotime($fecha));
            $fechaviernes = date('d/m/Y', $nuevafecha);
            $porcion = explode("-", date('d-m-Y', $nuevafecha));
            $viernes = $porcion[0];
            $viernesmes = (string)(int)$porcion[1];

            $nuevafecha = strtotime('+5 day', strtotime($fecha));
            $fechasabado = date('d/m/Y', $nuevafecha);
            $porcion = explode("-", date('d-m-Y', $nuevafecha));
            $sabado = $porcion[0];
            $sabadomes = (string)(int)$porcion[1];
            //////////////////////////////////////
        } else {
            $diaInicio="Monday";
            $diaFin="Saturday";
            //$fecha = '2017-11-15';

            $strFecha = strtotime($calendario);

            $fechaInicio = date('Y-m-d',strtotime('last '.$diaInicio, $strFecha));
            $fechaFin = date('Y-m-d',strtotime('next '.$diaFin, $strFecha));

            if(date("l",$strFecha)==$diaInicio){
                $fechaInicio= date("Y-m-d",$strFecha);
            }

            if(date("l",$strFecha)==$diaFin){
                $fechaFin= date("Y-m-d",$strFecha);
            }
           
            $first = strtotime('last Sunday 1 days');
            $last = strtotime('next Saturday 0 days');
            $porcion = explode("-", date($fechaInicio, $first));
            $fechai = strtotime($fechaInicio);
            $fechalunes = date('d/m/Y', $fechai);
            $fechalunescons = $porcion[0].'-'.$porcion[1].'-'.$porcion[2];
            $lunes = $porcion[2];
            $lunesmes = (string)(int)$porcion[1];

            $nuevafecha = strtotime($fechaInicio."+ 1 days");
            $fechamartes = date('d/m/Y', $nuevafecha);
            $porcion = explode("-", date('d-m-Y', $nuevafecha));
            $martes = $porcion[0];
            $martesmes = (string)(int)$porcion[1];

            $nuevafecha = strtotime($fechaInicio."+ 2 days");
            $fechamiercoles = date('d/m/Y', $nuevafecha);
            $porcion = explode("-", date('d-m-Y', $nuevafecha));
            $miercoles = $porcion[0];
            $miercolesmes = (string)(int)$porcion[1];

            $nuevafecha = strtotime($fechaInicio."+ 3 days");
            $fechajueves = date('d/m/Y', $nuevafecha);
            $porcion = explode("-", date('d-m-Y', $nuevafecha));
            $jueves = $porcion[0];
            $juevesmes = (string)(int)$porcion[1];

            $nuevafecha = strtotime($fechaInicio."+ 4 days");
            $fechaviernes = date('d/m/Y', $nuevafecha);
            $porcion = explode("-", date('d-m-Y', $nuevafecha));
            $viernes = $porcion[0];
            $viernesmes = (string)(int)$porcion[1];

            $nuevafecha = strtotime($fechaInicio."+ 5 days");
            $fechasabado = date('d/m/Y', $nuevafecha);
            $porcion = explode("-", date('d-m-Y', $nuevafecha));
            $sabado = $porcion[0];
            $sabadomes = (string)(int)$porcion[1];
        }
        /////////////////////
        //$carreras = Carrera::where('organizacion_id', '=', $orgid)->get();
        $planes = PlanEstudio::where('carrera_id', '=', $carrera_id)->get();
        $materias = Materia::where('carrera_id', '=', $carrera_id)->where('planestudio_id', '=', $planID)->get();
        /*$docente = Docente::find($docente_id);
        $docent = Persona::where('id', '=', $docente->persona_id)->first();
        $apeynom = $docent->apellido.', '.$docent->nombre;
        $docentes[] = ['id' => $docente->id, 'apeynom' => $apeynom];*/
        //$ciclo_id = PlanEstudio::find($planID)->ciclolectivo_id;
        $asistencias = Asistencias::whereRaw('planestudio_id ='.$planID.' AND materia_id ='.$materia_id.' AND carrera_id ='.$carrera_id.' AND ciclolectivo_id ='. $ciclo_id)->get();

        if ($dni == '') {
        	$datos = InscripcionMateria::whereRaw('planestudio_id ='.$planID.' AND materia_id ='.$materia_id.' AND carrera_id ='.$carrera_id.' AND ciclolectivo_id ='. $ciclo_id)->get();
        } else {
        	$alumno = Alumno::getAlumnoPorDni($dni);
        	$datos = InscripcionMateria::whereRaw('planestudio_id ='.$planID.' AND alumno_id ='.$alumno[0]->alumno_id.' AND materia_id ='.$materia_id.' AND carrera_id ='.$carrera_id.' AND ciclolectivo_id ='. $ciclo_id)->get();
        }
        
		$alumnos = [];
		$alumnosinscriptos = [];
        $lunesa = 3;
        $martesa = 3;
        $miercolesa = 3;
        $juevesa = 3;
        $viernesa = 3;
        $sabadoa = 3;
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

        $lunest = $lunes.'/'.$meses[$lunesmes];
        $martest = $martes.'/'.$meses[$martesmes];
        $miercolest = $miercoles.'/'.$meses[$miercolesmes];
        $juevest = $jueves.'/'.$meses[$juevesmes];
        $viernest = $viernes.'/'.$meses[$viernesmes];
        $sabadot = $sabado.'/'.$meses[$sabadomes];

        if (count($datos) > 0) {
        	foreach ($datos as $dato) {
				array_push($alumnos, $dato->alumno_id);
			}

			$resultado = array_unique($alumnos);
			sort($resultado);

			for ($i=0; $i < count($resultado); $i++) { 
				$alumnoss = Alumno::find($resultado[$i]);
				$alumnoid = $alumnoss->id;
				$apellido = $alumnoss->persona->apellido;
				$nombre = $alumnoss->persona->nombre;
				$nrodocumento = $alumnoss->persona->nrodocumento;

                $asistencias = Asistencias::whereRaw('alumno_id ='.$resultado[$i].' AND planestudio_id ='.$planID.' AND materia_id ='.$materia_id.' AND carrera_id ='.$carrera_id.' AND ciclolectivo_id ='. $ciclo_id.' AND lunesfecha ="'.$fechalunescons.'"')->get();

                if (count($asistencias) > 0) {
                    foreach ($asistencias as $asistencia) {
                        $lunesfecha = FechaHelper::getFechaImpresion($asistencia->lunesfecha);
                        $martesfecha = FechaHelper::getFechaImpresion($asistencia->martesfecha);
                        $miercolesfecha = FechaHelper::getFechaImpresion($asistencia->miercolesfecha);
                        $juevesfecha = FechaHelper::getFechaImpresion($asistencia->juevesfecha);
                        $viernesfecha = FechaHelper::getFechaImpresion($asistencia->viernesfecha);
                        $sabadofecha = FechaHelper::getFechaImpresion($asistencia->sabadofecha);

                        $porcion = explode("/", $lunesfecha);
                        $lunesfechaf = $porcion[2].'-'.(string)(int)$porcion[1].'-'.$porcion[0];
                        $feriadolun = Feriados::whereRaw('ciclolectivo_id ='.$ciclo_id.' AND fecha_feriado ="'.$lunesfechaf.'"')->first();

                        $porcion = explode("/", $martesfecha);
                        $martesfechaf = $porcion[2].'-'.(string)(int)$porcion[1].'-'.$porcion[0];
                        $feriadomar = Feriados::whereRaw('ciclolectivo_id ='.$ciclo_id.' AND fecha_feriado ="'.$martesfechaf.'"')->first();

                        $porcion = explode("/", $miercolesfecha);
                        $miercolesfechaf = $porcion[2].'-'.(string)(int)$porcion[1].'-'.$porcion[0];
                        $feriadomie = Feriados::whereRaw('ciclolectivo_id ='.$ciclo_id.' AND fecha_feriado ="'.$miercolesfechaf.'"')->first();

                        $porcion = explode("/", $juevesfecha);
                        $juevesfechaf = $porcion[2].'-'.(string)(int)$porcion[1].'-'.$porcion[0];
                        $feriadojue = Feriados::whereRaw('ciclolectivo_id ='.$ciclo_id.' AND fecha_feriado ="'.$juevesfechaf.'"')->first();

                        $porcion = explode("/", $viernesfecha);
                        $viernesfechaf = $porcion[2].'-'.(string)(int)$porcion[1].'-'.$porcion[0];
                        $feriadovie = Feriados::whereRaw('ciclolectivo_id ='.$ciclo_id.' AND fecha_feriado ="'.$viernesfechaf.'"')->first();

                        $porcion = explode("/", $sabadofecha);
                        $sabadofechaf = $porcion[2].'-'.(string)(int)$porcion[1].'-'.$porcion[0];
                        $feriadosab = Feriados::whereRaw('ciclolectivo_id ='.$ciclo_id.' AND fecha_feriado ="'.$sabadofechaf.'"')->first();

                        $asislunes = $asistencia->lunes;
                        $asismartes = $asistencia->martes;
                        $asismiercoles = $asistencia->miercoles;
                        $asisjueves = $asistencia->jueves;
                        $asisviernes = $asistencia->viernes;
                        $asissabado = $asistencia->sabado;
                        
                        if ($diass[0]['lunes'] == 'lunes') {
                            $lunesa = 2;
                            if ($fechalunes == $lunesfecha) {
                                if ($asislunes == 1) {
                                    $lunesa = 1;
                                } else {
                                    $lunesa = 0;
                                }
                            }
                            if (count($feriadolun) > 0) $lunesa = 4;
                        }

                        if ($diass[0]['martes'] == 'martes') {
                            $martesa = 2;
                            if ($fechamartes == $martesfecha) {
                                if ($asismartes == 1) {
                                    $martesa = 1;
                                } else {
                                    $martesa = 0;
                                }
                            }
                            if (count($feriadomar) > 0) $martesa = 4;
                        }

                        if ($diass[0]['miercoles'] == 'miercoles') {
                            $miercolesa = 2;
                            if ($fechamiercoles == $miercolesfecha) {
                                if ($asismiercoles == 1) {
                                    $miercolesa = 1;
                                } else {
                                    $miercolesa = 0;
                                }
                            }
                            if (count($feriadomie) > 0) $miercolesa = 4;
                        }

                        if ($diass[0]['jueves'] == 'jueves') {
                            $juevesa = 2;
                            if ($fechajueves == $juevesfecha) {
                                if ($asisjueves == 1) {
                                    $juevesa = 1;
                                } else {
                                    $juevesa = 0;
                                }
                            }
                            if (count($feriadojue) > 0) $juevesa = 4;
                        }

                        if ($diass[0]['viernes'] == 'viernes') {
                            $viernesa = 2;
                            if ($fechaviernes == $viernesfecha) {
                                if ($asisviernes == 1) {
                                    $viernesa = 1;
                                } else {
                                    $viernesa = 0;
                                }
                            }
                            if (count($feriadovie) > 0) $viernesa = 4;
                        }

                        if ($diass[0]['sabado'] == 'sabado') {
                            $sabadoa = 2;
                            if ($fechasabado == $sabadofecha) {
                                if ($asissabado == 1) {
                                    $sabadoa = 1;
                                } else {
                                    $sabadoa = 0;
                                }
                            }
                            if (count($feriadosab) > 0) $sabadoa = 4;
                        }

                        $alumnosinscriptos[] = ['alumno_id' => $alumnoid, 'apellido' => $apellido, 'nombre' => $nombre, 'nrodocumento' => $nrodocumento, 'lunes' => $lunesa, 'martes' => $martesa, 'miercoles' => $miercolesa, 'jueves' => $juevesa, 'viernes' => $viernesa, 'sabado' => $sabadoa, 'lunest' => $lunest, 'martest' => $martest, 'miercolest' => $miercolest, 'juevest' => $juevest, 'viernest' => $viernest, 'sabadot' => $sabadot];
                    }
                } else {
                    $porcion = explode("/", $fechalunes);
                    $lunesfechaf = $porcion[2].'-'.(string)(int)$porcion[1].'-'.$porcion[0];
                    $feriadolun = Feriados::whereRaw('ciclolectivo_id ='.$ciclo_id.' AND fecha_feriado ="'.$lunesfechaf.'"')->first();

                    $porcion = explode("/", $fechamartes);
                    $martesfechaf = $porcion[2].'-'.(string)(int)$porcion[1].'-'.$porcion[0];
                    $feriadomar = Feriados::whereRaw('ciclolectivo_id ='.$ciclo_id.' AND fecha_feriado ="'.$martesfechaf.'"')->first();

                    $porcion = explode("/", $fechamiercoles);
                    $miercolesfechaf = $porcion[2].'-'.(string)(int)$porcion[1].'-'.$porcion[0];
                    $feriadomie = Feriados::whereRaw('ciclolectivo_id ='.$ciclo_id.' AND fecha_feriado ="'.$miercolesfechaf.'"')->first();

                    $porcion = explode("/", $fechajueves);
                    $juevesfechaf = $porcion[2].'-'.(string)(int)$porcion[1].'-'.$porcion[0];
                    $feriadojue = Feriados::whereRaw('ciclolectivo_id ='.$ciclo_id.' AND fecha_feriado ="'.$juevesfechaf.'"')->first();

                    $porcion = explode("/", $fechaviernes);
                    $viernesfechaf = $porcion[2].'-'.(string)(int)$porcion[1].'-'.$porcion[0];
                    $feriadovie = Feriados::whereRaw('ciclolectivo_id ='.$ciclo_id.' AND fecha_feriado ="'.$viernesfechaf.'"')->first();

                    $porcion = explode("/", $fechasabado);
                    $sabadofechaf = $porcion[2].'-'.(string)(int)$porcion[1].'-'.$porcion[0];
                    $feriadosab = Feriados::whereRaw('ciclolectivo_id ='.$ciclo_id.' AND fecha_feriado ="'.$sabadofechaf.'"')->first();

                    if ($diass[0]['lunes'] == 'lunes') {
                        $lunesa = 0;
                        if (count($feriadolun) > 0) $lunesa = 4;
                    }

                    if ($diass[0]['martes'] == 'martes') {
                        $martesa = 0;
                        if (count($feriadomar) > 0) $martesa = 4;
                    }

                    if ($diass[0]['miercoles'] == 'miercoles') {
                        $miercolesa = 0;
                        if (count($feriadomie) > 0) $miercolesa = 4;
                    }

                    if ($diass[0]['jueves'] == 'jueves') {
                        $juevesa = 0;
                        if (count($feriadojue) > 0) $juevesa = 4;
                    }

                    if ($diass[0]['viernes'] == 'viernes') {
                        $viernesa = 0;
                        if (count($feriadovie) > 0) $viernesa = 4;
                    }

                    if ($diass[0]['sabado'] == 'sabado') {
                        $sabadoa = 0;
                        if (count($feriadosab) > 0) $sabadoa = 4;
                    }

                    $alumnosinscriptos[] = ['alumno_id' => $alumnoid, 'apellido' => $apellido, 'nombre' => $nombre, 'nrodocumento' => $nrodocumento, 'lunes' => $lunesa, 'martes' => $martesa, 'miercoles' => $miercolesa, 'jueves' => $juevesa, 'viernes' => $viernesa, 'sabado' => $sabadoa, 'lunest' => $lunest, 'martest' => $martest, 'miercolest' => $miercolest, 'juevest' => $juevest, 'viernest' => $viernest, 'sabadot' => $sabadot];
                }
			}
		}

        /*highlight_string(var_export($alumnosinscriptos,true));
        exit();*/

        $habilita = true;
        $organizaciones = Organizacion::lists('nombre', 'id');

        return Response::json($alumnosinscriptos);
        /*return View::make('asistencias/listado')
            ->with('organizaciones', $organizaciones)
            ->with('materia_id', $materia_id)
            ->with('materias', $materias)
            ->with('carrera_id', $carrera_id)
            ->with('carreras', $carreras)
            ->with('docente_id', $docente_id)
            ->with('docentes', $docentes)
            ->with('OrgID', $orgid)
            ->with('planID', $planID)
            ->with('planes', $planes)
            ->with('alumnosinscriptos', $alumnosinscriptos)
            ->with('lunes', $lunes)
            ->with('lunesmes', $lunesmes)
            ->with('martes', $martes)
            ->with('martesmes', $martesmes)
            ->with('miercoles', $miercoles)
            ->with('miercolesmes', $miercolesmes)
            ->with('jueves', $jueves)
            ->with('juevesmes', $juevesmes)
            ->with('viernes', $viernes)
            ->with('viernesmes', $viernesmes)
            ->with('sabado', $sabado)
            ->with('sabadomes', $sabadomes)
            ->with('meses', $meses)
            ->with('dias', $dias)
            ->with('diass', $diass)
            ->with('fechadesdes', $fechadesdes)
            ->with('habilita', $habilita)
            ->with('dni', $dni)
            ->with('menu', ModulosHelper::MENU_GESTION_ACADEMICA)
            ->with('submenu', ModulosHelper::SUBMENU_ASISTENCIA)
            ->with('leer', Session::get('ASISTENCIA_LEER'))
            ->with('editar', Session::get('ASISTENCIA_EDITAR'))
            ->with('imprimir', Session::get('ASISTENCIA_IMPRIMIR'))
            ->with('eliminar', Session::get('ASISTENCIA_ELIMINAR'));*/
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

    public function postGuardar()
    {   
    	$validator = Validator::make(
            array(
                'cboCarrera'      => Input::get('cboCarrera'),
                'cboPlan'         => Input::get('cboPlan'),
                'cboCiclos'       => Input::get('cboCiclos'),
                'cboMaterias'     => Input::get('cboMaterias'),
                'cboDocente'      => Input::get('txtDocente')
            ),
            array(
                'cboCarrera'      => 'required',
                'cboPlan'         => 'required',
                'cboCiclos'         => 'required',
                'cboMaterias'     => 'required',
                'cboDocente'      => 'required'
            ),
            array(
                'required' 		=> 'Campo Obligatorio',
                'required' 		=> 'Campo Obligatorio',
                'required'      => 'Campo Obligatorio',
                'required' 		=> 'Campo Obligatorio',
                'required' 		=> 'Campo Obligatorio'
            )
        );

        $orgid = Input::get('cboOrganizacion');
        $carrera_id = Input::get('cboCarrera');
        $planID = Input::get('cboPlan');
        $ciclo_id = Input::get('cboCiclos');
        $materia_id = Input::get('cboMaterias');
        $docente_id = Input::get('txtDocente');
        $fechadesde = Input::get('fechadesde');
        $alumno_id = Input::get('alumno_id');
    	$lunesasis = Input::get('lunes');
        $martesasis = Input::get('martes');
        $miercolesasis = Input::get('miercoles');
        $juevesasis = Input::get('jueves');
        $viernesasis = Input::get('viernes');
        $sabadoasis = Input::get('sabado');
        
        if ($fechadesde == '') {
            $fechadesdes = date('Y-m-d');
            $porcion = explode("-", $fechadesdes);
            $fechadesde = date('d/m/Y');
        } else {
            $porcion = explode("-", $fechadesde);
            $calendario = $porcion[0].'-'.$porcion[1].'-'.$porcion[2];
            $fechadesde = $porcion[2].'/'.$porcion[1].'/'.$porcion[0];
        }
        
        $fechacons = Input::get('fechadesde');

        if ($fechacons == '') {
            //Genero la semana a mostrar, lunes a sabado
            $date = strtotime(date("Y-m-d"));
            $first = strtotime('last Sunday 1 days');
            $last = strtotime('next Saturday 0 days');
            //echo date('Y-m-d', $first);
            //echo '<br>';
            //echo date('Y-m-d', $last);
            $porcion = explode("-", date('d-m-Y', $first));
            $fechalunes = date('d/m/Y', $first);
            $fechalunescons = $porcion[2].'-'.$porcion[1].'-'.$porcion[0];
            $calendario = $porcion[2].'-'.$porcion[1].'-'.$porcion[0];
            //$lunes = $porcion[0];
            //$lunesmes = (string)(int)$porcion[1];

            $fecha = date('d-m-Y', $first);
            $nuevafecha = strtotime('+1 day', strtotime($fecha));
            $fechamartes = date('d/m/Y', $nuevafecha);
            $porcion = explode("-", date('d-m-Y', $nuevafecha));
            //$martes = $porcion[0];
            //$martesmes = (string)(int)$porcion[1];

            $nuevafecha = strtotime('+2 day', strtotime($fecha));
            $fechamiercoles = date('d/m/Y', $nuevafecha);
            $porcion = explode("-", date('d-m-Y', $nuevafecha));
            //$miercoles = $porcion[0];
            //$miercolesmes = (string)(int)$porcion[1];

            $nuevafecha = strtotime('+3 day', strtotime($fecha));
            $fechajueves = date('d/m/Y', $nuevafecha);
            $porcion = explode("-", date('d-m-Y', $nuevafecha));
            //$jueves = $porcion[0];
            //$juevesmes = (string)(int)$porcion[1];

            $nuevafecha = strtotime('+4 day', strtotime($fecha));
            $fechaviernes = date('d/m/Y', $nuevafecha);
            $porcion = explode("-", date('d-m-Y', $nuevafecha));
            //$viernes = $porcion[0];
            //$viernesmes = (string)(int)$porcion[1];

            $nuevafecha = strtotime('+5 day', strtotime($fecha));
            $fechasabado = date('d/m/Y', $nuevafecha);
            $porcion = explode("-", date('d-m-Y', $nuevafecha));
            //$sabado = $porcion[0];
            //$sabadomes = (string)(int)$porcion[1];
        } else {
            $diaInicio="Monday";
            $diaFin="Saturday";
            //$fecha = '2017-11-15';

            $strFecha = strtotime($calendario);

            $fechaInicio = date('Y-m-d',strtotime('last '.$diaInicio, $strFecha));
            $fechaFin = date('Y-m-d',strtotime('next '.$diaFin, $strFecha));

            if(date("l",$strFecha)==$diaInicio){
                $fechaInicio= date("Y-m-d",$strFecha);
            }

            if(date("l",$strFecha)==$diaFin){
                $fechaFin= date("Y-m-d",$strFecha);
            }
           
            $first = strtotime('last Sunday 1 days');
            $last = strtotime('next Saturday 0 days');
            $porcion = explode("-", date($fechaInicio, $first));
            $fechalunescons = $porcion[0].'-'.$porcion[1].'-'.$porcion[2];
            $fechai = strtotime($fechaInicio);
            $fechalunes = date('d/m/Y', $fechai);
            //$lunes = $porcion[2];
            //$lunesmes = (string)(int)$porcion[1];

            $nuevafecha = strtotime($fechaInicio."+ 1 days");
            $fechamartes = date('d/m/Y', $nuevafecha);
            $porcion = explode("-", date('d-m-Y', $nuevafecha));
            //$martes = $porcion[0];
            //$martesmes = (string)(int)$porcion[1];

            $nuevafecha = strtotime($fechaInicio."+ 2 days");
            $fechamiercoles = date('d/m/Y', $nuevafecha);
            $porcion = explode("-", date('d-m-Y', $nuevafecha));
            //$miercoles = $porcion[0];
            //$miercolesmes = (string)(int)$porcion[1];

            $nuevafecha = strtotime($fechaInicio."+ 3 days");
            $fechajueves = date('d/m/Y', $nuevafecha);
            $porcion = explode("-", date('d-m-Y', $nuevafecha));
            //$jueves = $porcion[0];
            //$juevesmes = (string)(int)$porcion[1];

            $nuevafecha = strtotime($fechaInicio."+ 4 days");
            $fechaviernes = date('d/m/Y', $nuevafecha);
            $porcion = explode("-", date('d-m-Y', $nuevafecha));
            //$viernes = $porcion[0];
            //$viernesmes = (string)(int)$porcion[1];

            $nuevafecha = strtotime($fechaInicio."+ 5 days");
            $fechasabado = date('d/m/Y', $nuevafecha);
            $porcion = explode("-", date('d-m-Y', $nuevafecha));
            //$sabado = $porcion[0];
            //$sabadomes = (string)(int)$porcion[1];
        }
        ////////////////////////////////////////

        if ($materia_id == 0) {
            Session::flash('message', 'ERROR AL INTENTAR GUARDAR LAS ASISTENCIAS, DEBE SELECCIONAR LOS FILTROS.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('asistencias/listado')
                ->withErrors($validator)
                ->withInput();
        }

        $materiass = Materia::find($materia_id);
        $msj = 'NO';
        $fechainicio = '';
        $fechafin = '';
        
        if ($materiass->periodo == 'Anual') {
            //$ciclo_id = PlanEstudio::find($planID)->ciclolectivo_id;

            $ciclos = CicloLectivo::find($ciclo_id);
            $fechainic = FechaHelper::getFechaImpresion($ciclos->fechainicio);
            $fechafic = FechaHelper::getFechaImpresion($ciclos->fechafin);
            $fechaini = FechaHelper::getFechaParaGuardar($fechainic);
            $nuevafecha = strtotime('-1 day', strtotime($fechaini));
            $fechaini = date('Y-m-j', $nuevafecha);
            $fechafi = FechaHelper::getFechaParaGuardar($fechafic);
            $nuevafecha = strtotime('+1 day', strtotime($fechafi));
            $fechafi = date('Y-m-j', $nuevafecha);
            $fechap = strtotime(date('Y-m-d'));
            $fechainicio = strtotime($fechaini);
            $fechafin = strtotime($fechafi);
            $fechall = FechaHelper::getFechaParaGuardar($fechalunes);
            $fechass = FechaHelper::getFechaParaGuardar($fechasabado);
            $fechaln = strtotime($fechall);
            $fechasb = strtotime($fechass);

            if ($fechacons == '') {
                if ($fechaln > $fechainicio) {
                    if ($fechap < $fechafin) {
                        $msj = 'SI';
                    }
                }
            } else {
                if ($fechaln > $fechainicio) {
                    //if ($fechasb < $fechafin) {
                        $msj = 'SI';
                    //}
                }
            }
        } else {
            $cuatri = $materiass->cuatrimestre;
            //$ciclo_id = PlanEstudio::find($planID)->ciclolectivo_id;

            $ciclos = PeriodoLectivo::whereRaw('ciclolectivo_id ='. $ciclo_id)->get();

            if (count($ciclos) > 0) {
                foreach ($ciclos as $value) {
                    $fechainic = FechaHelper::getFechaImpresion($value->fechainicio);
                    $fechafic = FechaHelper::getFechaImpresion($value->fechafin);
                    $fechaini = FechaHelper::getFechaParaGuardar($fechainic);
                    $nuevafecha = strtotime('-1 day', strtotime($fechaini));
                    $fechaini = date('Y-m-j', $nuevafecha);
                    $fechafi = FechaHelper::getFechaParaGuardar($fechafic);
                    $nuevafecha = strtotime('+1 day', strtotime($fechafi));
                    $fechafi = date('Y-m-j', $nuevafecha);
                    $fechap = strtotime(date('Y-m-d'));
                    $fechainicio = strtotime($fechaini);
                    $fechafin = strtotime($fechafi);
                    $fechall = FechaHelper::getFechaParaGuardar($fechalunes);
                    $fechass = FechaHelper::getFechaParaGuardar($fechasabado);
                    $fechaln = strtotime($fechall);
                    $fechasb = strtotime($fechass);
                    
                    if ($fechacons == '') {
                        if ($cuatri == 1) {
                            if ($value->descripcion == '1 Cuatrimestre') {
                                if ($fechaln > $fechainicio) {
                                    if ($fechap < $fechafin) {
                                        $msj = 'SI';
                                    }
                                }
                            }
                        }

                        if ($cuatri == 2) {
                            if ($value->descripcion == '2 Cuatrimestre') {
                                if ($fechaln > $fechainicio) {
                                    if ($fechap < $fechafin) {
                                        $msj = 'SI';
                                    }
                                }
                            }
                        }
                    } else {
                        if ($cuatri == 1) {
                            if ($value->descripcion == '1 Cuatrimestre') {
                                if ($fechaln > $fechainicio) {
                                    //if ($fechasb < $fechafin) {
                                        $msj = 'SI';
                                    //}
                                }
                            }
                        }

                        if ($cuatri == 2) {
                            if ($value->descripcion == '2 Cuatrimestre') {
                                if ($fechaln > $fechainicio) {
                                    //if ($fechasb < $fechafin) {
                                        $msj = 'SI';
                                    //}
                                }
                            }
                        }
                    }
                }
            } else {
                $msj = 'NO';
            }
        }

        if ($msj == 'NO') {
            Session::flash('message', 'ERROR AL INTENTAR GUARDAR LAS ASISTENCIAS, NO SE ENCUENTRA ENTRE LA FECHA INICIO Y FIN.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('asistencias/listado')
                ->withErrors($validator)
                ->withInput();
        }
        /////////////////////////////////////////

        $luness = '';
        $martess = '';
        $miercoless = '';
        $juevess = '';
        $vierness = '';
        $sabados = '';

        $asignaciones = AsignarDocente::whereRaw('carrera_id='. $carrera_id .' AND materia_id='. $materia_id . ' AND planestudio_id='. $planID)->first();

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

    	/*if ($fechadesde == '') {
    		$fechadesde = date('d/m/Y');
    	} else {
    		$porcion = explode("-", $fechadesde);
        	$fechadesde = $porcion[2].'/'.$porcion[1].'/'.$porcion[0];
        	//$fechadesde = FechaHelper::getFechaParaGuardar($fechadesdes);
    	}*/

        if ($validator->fails()) {
            Session::flash('message', 'ERROR AL INTENTAR GUARDAR LAS ASISTENCIAS.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('asistencias/listado')
                ->withErrors($validator)
                ->withInput();
        } else {
            if ($alumno_id == '') {
                $datos = InscripcionMateria::whereRaw('planestudio_id ='.$planID.' AND materia_id ='.$materia_id.' AND carrera_id ='.$carrera_id.' AND ciclolectivo_id ='. $ciclo_id)->get();
            } else {
                $datos = InscripcionMateria::whereRaw('planestudio_id ='.$planID.' AND materia_id ='.$materia_id.' AND carrera_id ='.$carrera_id.' AND alumno_id ='.$alumno_id.' AND ciclolectivo_id ='. $ciclo_id)->get();
            }
        	
        	$idaseguir = '';
        	$idasistencias = [];

        	foreach ($datos as $value) {
        		$inscripciones[] = ['alumno_id' => $value->alumno_id];
        	}

            //$ciclo_id = PlanEstudio::find($planID)->ciclolectivo_id;

        	for ($j=0; $j < count($inscripciones); $j++) { 
        		$alumnoid = $inscripciones[$j]['alumno_id'];

        		$asistenciass = Asistencias::whereRaw('alumno_id ='.$alumnoid.' AND planestudio_id ='.$planID.' AND materia_id ='.$materia_id.' AND carrera_id ='.$carrera_id.' AND ciclolectivo_id ='. $ciclo_id.' AND lunesfecha ="'.$fechalunescons.'"')->first();
        		$presentelu = 0;
                $presentema = 0;
                $presentemi = 0;
                $presenteju = 0;
                $presentevi = 0;
                $presentesa = 0;

                $porcion = explode("/", $fechalunes);
                $lunesfechaf = $porcion[2].'-'.(string)(int)$porcion[1].'-'.$porcion[0];
                $feriadolun = Feriados::whereRaw('ciclolectivo_id ='.$ciclo_id.' AND fecha_feriado ="'.$lunesfechaf.'"')->first();

                $porcion = explode("/", $fechamartes);
                $martesfechaf = $porcion[2].'-'.(string)(int)$porcion[1].'-'.$porcion[0];
                $feriadomar = Feriados::whereRaw('ciclolectivo_id ='.$ciclo_id.' AND fecha_feriado ="'.$martesfechaf.'"')->first();

                $porcion = explode("/", $fechamiercoles);
                $miercolesfechaf = $porcion[2].'-'.(string)(int)$porcion[1].'-'.$porcion[0];
                $feriadomie = Feriados::whereRaw('ciclolectivo_id ='.$ciclo_id.' AND fecha_feriado ="'.$miercolesfechaf.'"')->first();

                $porcion = explode("/", $fechajueves);
                $juevesfechaf = $porcion[2].'-'.(string)(int)$porcion[1].'-'.$porcion[0];
                $feriadojue = Feriados::whereRaw('ciclolectivo_id ='.$ciclo_id.' AND fecha_feriado ="'.$juevesfechaf.'"')->first();

                $porcion = explode("/", $fechaviernes);
                $viernesfechaf = $porcion[2].'-'.(string)(int)$porcion[1].'-'.$porcion[0];
                $feriadovie = Feriados::whereRaw('ciclolectivo_id ='.$ciclo_id.' AND fecha_feriado ="'.$viernesfechaf.'"')->first();

                $porcion = explode("/", $fechasabado);
                $sabadofechaf = $porcion[2].'-'.(string)(int)$porcion[1].'-'.$porcion[0];
                $feriadosab = Feriados::whereRaw('ciclolectivo_id ='.$ciclo_id.' AND fecha_feriado ="'.$sabadofechaf.'"')->first();

        		if (count($asistenciass) > 0) {
                    $asistencias = Asistencias::find($asistenciass->id);
                    $idaseguir = $asistenciass->id .'-'. $calendario;

                    if ($diass[0]['lunes'] == 'lunes') {
                        if (count($lunesasis) > 0) {
                            for ($i=0; $i < count($lunesasis); $i++) { 
                                if ($alumnoid == $lunesasis[$i]) {
                                    $presentelu = 1;
                                }
                            }

                            if ($presentelu == 1) $asistencias->lunes = 1;
                            if ($presentelu == 0) $asistencias->lunes = 0;
                        }
                        if (count($feriadolun) > 0) $presentelu = 2;
                        if ($presentelu == 2) $asistencias->lunes = 2;

                    }

                    if ($diass[0]['martes'] == 'martes') {
                        if (count($martesasis) > 0) {
                            for ($i=0; $i < count($martesasis); $i++) { 
                                if ($alumnoid == $martesasis[$i]) {
                                    $presentema = 1;
                                }
                            }

                            if ($presentema == 0) $asistencias->martes = 0;
                            if ($presentema == 1) $asistencias->martes = 1;
                        }
                        if (count($feriadomar) > 0) $presentema = 2;
                        if ($presentema == 2) $asistencias->martes = 2;
                    }

                    if ($diass[0]['miercoles'] == 'miercoles') {
                        if (count($miercolesasis) > 0) {
                            for ($i=0; $i < count($miercolesasis); $i++) { 
                                if ($alumnoid == $miercolesasis[$i]) {
                                    $presentemi = 1;
                                }
                            }

                            if ($presentemi == 0) $asistencias->miercoles = 0;
                            if ($presentemi == 1) $asistencias->miercoles = 1;
                        }
                        if (count($feriadomie) > 0) $presentemi = 2;
                        if ($presentemi == 2) $asistencias->miercoles = 2;
                    }

                    if ($diass[0]['jueves'] == 'jueves') {
                        if (count($juevesasis) > 0) {
                            for ($i=0; $i < count($juevesasis); $i++) { 
                                if ($alumnoid == $juevesasis[$i]) {
                                    $presenteju = 1;
                                }
                            }


                            if ($presenteju == 0) $asistencias->jueves = 0;
                            if ($presenteju == 1) $asistencias->jueves = 1;
                        }
                        if (count($feriadojue) > 0) $presenteju = 2;
                        if ($presenteju == 2) $asistencias->jueves = 2;
                    }

                    if ($diass[0]['viernes'] == 'viernes') {
                        if (count($viernesasis) > 0) {
                            for ($i=0; $i < count($viernesasis); $i++) { 
                                if ($alumnoid == $viernesasis[$i]) {
                                    $presentevi = 1;
                                }
                            }

                            if ($presentevi == 0) $asistencias->viernes = 0;
                            if ($presentevi == 1) $asistencias->viernes = 1;
                        }
                        if (count($feriadovie) > 0) $presentevi = 2;
                        if ($presentevi == 2) $asistencias->viernes = 2;
                    }

                    if ($diass[0]['sabado'] == 'sabado') {
                        if (count($sabadoasis) > 0) {
                            for ($i=0; $i < count($sabadoasis); $i++) { 
                                if ($alumnoid == $sabadoasis[$i]) {
                                    $presentesa = 1;
                                }
                            }

                            if ($presentesa == 0) $asistencias->sabado = 0;
                            if ($presentesa == 1) $asistencias->sabado = 1;
                        }
                        if (count($feriadosab) > 0) $presentesa = 2;
                        if ($presentesa == 2) $asistencias->sabado = 2;
                    }

                    $asistencias->ciclolectivo_id = $ciclo_id;
                    $asistencias->usuario_modi  = Auth::user()->usuario;  
                    $asistencias->fecha_modi    = date('Y-m-d');
                        
                    $asistencias->save();
        		} else {
                    $fechaluness = FechaHelper::getFechaParaGuardar($fechalunes);
                    $fechamartess = FechaHelper::getFechaParaGuardar($fechamartes);
                    $fechamiercoless = FechaHelper::getFechaParaGuardar($fechamiercoles);
                    $fechajuevess = FechaHelper::getFechaParaGuardar($fechajueves);
                    $fechavierness = FechaHelper::getFechaParaGuardar($fechaviernes);
                    $fechasabados = FechaHelper::getFechaParaGuardar($fechasabado);

                    $asistencias = new Asistencias();

                    $asistencias->alumno_id         = $alumnoid;
                    $asistencias->planestudio_id    = $planID;
                    $asistencias->materia_id        = $materia_id;
                    $asistencias->carrera_id        = $carrera_id;
                    $asistencias->docente_id        = $docente_id;
                    $asistencias->lunesfecha        = $fechaluness;
                    $asistencias->lunes             = 0;
                    $asistencias->martesfecha       = $fechamartess;
                    $asistencias->martes            = 0;
                    $asistencias->miercolesfecha    = $fechamiercoless;
                    $asistencias->miercoles         = 0;
                    $asistencias->juevesfecha       = $fechajuevess;
                    $asistencias->jueves            = 0;
                    $asistencias->viernesfecha      = $fechavierness;
                    $asistencias->viernes           = 0;
                    $asistencias->sabadofecha       = $fechasabados;
                    $asistencias->sabado            = 0;
                    $asistencias->ciclolectivo_id   = $ciclo_id;
                    $asistencias->usuario_alta      = Auth::user()->usuario;  
                    $asistencias->fecha_alta        = date('Y-m-d');
                    
                    $asistencias->save();

                    $asistenciaid = Asistencias::all();
                    $ultimoidasis = $asistenciaid->last();

                    $asistencias = Asistencias::find($ultimoidasis->id);

                    if ($diass[0]['lunes'] == 'lunes') {
                        if (count($lunesasis) > 0) {
                            for ($i=0; $i < count($lunesasis); $i++) { 
                                if ($asistencias->alumno_id == $lunesasis[$i]) {
                                    $asistencias->lunes = 1;
                                }
                            }
                        }
                        if (count($feriadolun) > 0) $asistencias->lunes = 2;
                    }

                    if ($diass[0]['martes'] == 'martes') {
                        if (count($martesasis) > 0) {
                            for ($i=0; $i < count($martesasis); $i++) { 
                                if ($asistencias->alumno_id == $martesasis[$i]) {
                                    $asistencias->martes = 1;
                                }
                            }
                        }
                        if (count($feriadomar) > 0) $asistencias->martes = 2;
                    }

                    if ($diass[0]['miercoles'] == 'miercoles') {
                        if (count($miercolesasis) > 0) {
                            for ($i=0; $i < count($miercolesasis); $i++) { 
                                if ($asistencias->alumno_id == $miercolesasis[$i]) {
                                    $asistencias->miercoles = 1;
                                }
                            }
                        }
                        if (count($feriadomie) > 0) $asistencias->miercoles = 2;
                    }

                    if ($diass[0]['jueves'] == 'jueves') {
                        if (count($juevesasis) > 0) {
                            for ($i=0; $i < count($juevesasis); $i++) { 
                                if ($asistencias->alumno_id == $juevesasis[$i]) {
                                    $asistencias->jueves = 1;
                                }
                            }
                        }
                        if (count($feriadojue) > 0) $asistencias->jueves = 2;
                    }

                    if ($diass[0]['viernes'] == 'viernes') {
                        if (count($viernesasis) > 0) {
                            for ($i=0; $i < count($viernesasis); $i++) { 
                                if ($asistencias->alumno_id == $viernesasis[$i]) {
                                    $asistencias->viernes = 1;
                                }
                            }
                        }
                        if (count($feriadovie) > 0) $asistencias->viernes = 2;
                    }

                    if ($diass[0]['sabado'] == 'sabado') {
                        if (count($sabadoasis) > 0) {
                            for ($i=0; $i < count($sabadoasis); $i++) { 
                                if ($asistencias->alumno_id == $sabadoasis[$i]) {
                                    $asistencias->sabado = 1;
                                }
                            }
                        }
                        if (count($feriadosab) > 0) $asistencias->sabado = 2;
                    }
                        
                    $asistencias->save();

                    $asistenciaid = Asistencias::all();
                    $ultimoidasis = $asistenciaid->last();
                    $idaseguir = $ultimoidasis->id .'-'. $calendario;
                }
        	}

            Session::flash('message', 'LOS DATOS SE CARGARON CORRECTAMENTE!');
            Session::flash('message_type', self::OPERACION_EXITOSA);
            return Redirect::to('asistencias/guardado/'.$idaseguir);
        }
        /*highlight_string(var_export($asistencia,true));
        exit();*/
    }

    public function getGuardado($idaseguir)
    {  
        $porcion = explode("-", $idaseguir);
        $id = $porcion[0];
        $fecha = $porcion[1] .'-'. $porcion[2] .'-'. $porcion[3];

        $asistenciass = Asistencias::find($id);

        /////////////////////////////////////
        $diaInicio="Monday";
        $diaFin="Saturday";
        //$fecha = '2017-11-15';

        $strFecha = strtotime($fecha);

        $fechaInicio = date('Y-m-d',strtotime('last '.$diaInicio, $strFecha));
        $fechaFin = date('Y-m-d',strtotime('next '.$diaFin, $strFecha));

        if(date("l",$strFecha)==$diaInicio){
            $fechaInicio= date("Y-m-d",$strFecha);
        }

        if(date("l",$strFecha)==$diaFin){
            $fechaFin= date("Y-m-d",$strFecha);
        }
       
        $first = strtotime('last Sunday 1 days');
        $last = strtotime('next Saturday 0 days');
        $porcion = explode("-", date($fechaInicio, $first));
        $fechai = strtotime($fechaInicio);
        $fechalunes = date('d/m/Y', $fechai);
        $fechalunescons = $porcion[0].'-'.$porcion[1].'-'.$porcion[2];
        $lunes = $porcion[2];
        $lunesmes = (string)(int)$porcion[1];

        $nuevafecha = strtotime($fechaInicio."+ 1 days");
        $fechamartes = date('d/m/Y', $nuevafecha);
        $porcion = explode("-", date('d-m-Y', $nuevafecha));
        $martes = $porcion[0];
        $martesmes = (string)(int)$porcion[1];

        $nuevafecha = strtotime($fechaInicio."+ 2 days");
        $fechamiercoles = date('d/m/Y', $nuevafecha);
        $porcion = explode("-", date('d-m-Y', $nuevafecha));
        $miercoles = $porcion[0];
        $miercolesmes = (string)(int)$porcion[1];

        $nuevafecha = strtotime($fechaInicio."+ 3 days");
        $fechajueves = date('d/m/Y', $nuevafecha);
        $porcion = explode("-", date('d-m-Y', $nuevafecha));
        $jueves = $porcion[0];
        $juevesmes = (string)(int)$porcion[1];

        $nuevafecha = strtotime($fechaInicio."+ 4 days");
        $fechaviernes = date('d/m/Y', $nuevafecha);
        $porcion = explode("-", date('d-m-Y', $nuevafecha));
        $viernes = $porcion[0];
        $viernesmes = (string)(int)$porcion[1];

        $nuevafecha = strtotime($fechaInicio."+ 5 days");
        $fechasabado = date('d/m/Y', $nuevafecha);
        $porcion = explode("-", date('d-m-Y', $nuevafecha));
        $sabado = $porcion[0];
        $sabadomes = (string)(int)$porcion[1];

        if ($fecha == $fechalunescons) {
            $fechadesde = '';
        } else {
            $fechadesde = $fecha;
        }

        $lunesa = 3;
        $martesa = 3;
        $miercolesa = 3;
        $juevesa = 3;
        $viernesa = 3;
        $sabadoa = 3;
        $luness = '';
        $martess = '';
        $miercoless = '';
        $juevess = '';
        $vierness = '';
        $sabados = '';
        $carrera_id = $asistenciass->carrera_id;
        $materia_id = $asistenciass->materia_id;
        $planID = $asistenciass->planestudio_id;
        $ciclo_id = $asistenciass->ciclolectivo_id;

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
        //////////////////////////////////////////
        
        $carreras = Carrera::where('organizacion_id', '=', 1)->get();
        $planes = PlanEstudio::where('carrera_id', '=', $asistenciass->carrera_id)->get();
        
        $materias = Materia::where('carrera_id', '=', $asistenciass->carrera_id)->where('planestudio_id', '=', $planID)->get();
        $docente_id = AsignarDocente::whereRaw('carrera_id='.$asistenciass->carrera_id.' AND materia_id='.$asistenciass->materia_id. ' AND planestudio_id='.$asistenciass->planestudio_id)->first()->docentetitular_id;//Materia::find($asistenciass->materia_id)->docente_id;
        
        $docente = Docente::find($docente_id);
        $docent = Persona::where('id', '=', $docente->persona_id)->first();
        $apeynom = $docent->apellido.', '.$docent->nombre;
        $docentes[] = ['id' => $docente->id, 'apeynom' => $apeynom];
        
        //$ciclo_id = PlanEstudio::find($planID)->ciclolectivo_id;
        $asistencias = Asistencias::whereRaw('planestudio_id ='.$planID.' AND materia_id ='.$asistenciass->materia_id.' AND carrera_id ='.$asistenciass->carrera_id.' AND ciclolectivo_id ='.$ciclo_id)->get();

        $meses = ['vacio', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        $dias = ['vacio', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];

        $datos = InscripcionMateria::whereRaw('planestudio_id ='. $planID .' AND materia_id ='. $asistenciass->materia_id .' AND carrera_id ='. $asistenciass->carrera_id.' AND ciclolectivo_id ='.$ciclo_id)->get();
		$alumnos = [];
		$alumnosinscriptos = [];
		$materia_id = $asistenciass->materia_id;
		$carrera_id = $asistenciass->carrera_id;
		
        //$organizaciones = Organizacion::lists('nombre', 'id');
        $organizaciones = Organizacion::all();

        if (count($datos) > 0) {
        	foreach ($datos as $dato) {
				array_push($alumnos, $dato->alumno_id);
			}

			$resultado = array_unique($alumnos);
			sort($resultado);

			for ($i=0; $i < count($resultado); $i++) { 
				$alumnoss = Alumno::find($resultado[$i]);
				$alumnoid = $alumnoss->id;
				$apellido = $alumnoss->persona->apellido;
				$nombre = $alumnoss->persona->nombre;
				$nrodocumento = $alumnoss->persona->nrodocumento;

				$asistencias = Asistencias::whereRaw('alumno_id ='.$resultado[$i].' AND planestudio_id ='.$planID.' AND materia_id ='.$materia_id.' AND carrera_id ='.$carrera_id.' AND ciclolectivo_id ='.$ciclo_id.' AND lunesfecha ="'.$fechalunescons.'"')->get();

                if (count($asistencias) > 0) {
                    foreach ($asistencias as $asistencia) {
                        $lunesfecha = FechaHelper::getFechaImpresion($asistencia->lunesfecha);
                        $martesfecha = FechaHelper::getFechaImpresion($asistencia->martesfecha);
                        $miercolesfecha = FechaHelper::getFechaImpresion($asistencia->miercolesfecha);
                        $juevesfecha = FechaHelper::getFechaImpresion($asistencia->juevesfecha);
                        $viernesfecha = FechaHelper::getFechaImpresion($asistencia->viernesfecha);
                        $sabadofecha = FechaHelper::getFechaImpresion($asistencia->sabadofecha);

                        $porcion = explode("/", $lunesfecha);
                        $lunesfechaf = $porcion[2].'-'.(string)(int)$porcion[1].'-'.$porcion[0];
                        $feriadolun = Feriados::whereRaw('ciclolectivo_id ='.$ciclo_id.' AND fecha_feriado ="'.$lunesfechaf.'"')->first();

                        $porcion = explode("/", $martesfecha);
                        $martesfechaf = $porcion[2].'-'.(string)(int)$porcion[1].'-'.$porcion[0];
                        $feriadomar = Feriados::whereRaw('ciclolectivo_id ='.$ciclo_id.' AND fecha_feriado ="'.$martesfechaf.'"')->first();

                        $porcion = explode("/", $miercolesfecha);
                        $miercolesfechaf = $porcion[2].'-'.(string)(int)$porcion[1].'-'.$porcion[0];
                        $feriadomie = Feriados::whereRaw('ciclolectivo_id ='.$ciclo_id.' AND fecha_feriado ="'.$miercolesfechaf.'"')->first();

                        $porcion = explode("/", $juevesfecha);
                        $juevesfechaf = $porcion[2].'-'.(string)(int)$porcion[1].'-'.$porcion[0];
                        $feriadojue = Feriados::whereRaw('ciclolectivo_id ='.$ciclo_id.' AND fecha_feriado ="'.$juevesfechaf.'"')->first();

                        $porcion = explode("/", $viernesfecha);
                        $viernesfechaf = $porcion[2].'-'.(string)(int)$porcion[1].'-'.$porcion[0];
                        $feriadovie = Feriados::whereRaw('ciclolectivo_id ='.$ciclo_id.' AND fecha_feriado ="'.$viernesfechaf.'"')->first();

                        $porcion = explode("/", $sabadofecha);
                        $sabadofechaf = $porcion[2].'-'.(string)(int)$porcion[1].'-'.$porcion[0];
                        $feriadosab = Feriados::whereRaw('ciclolectivo_id ='.$ciclo_id.' AND fecha_feriado ="'.$sabadofechaf.'"')->first();

                        $asislunes = $asistencia->lunes;
                        $asismartes = $asistencia->martes;
                        $asismiercoles = $asistencia->miercoles;
                        $asisjueves = $asistencia->jueves;
                        $asisviernes = $asistencia->viernes;
                        $asissabado = $asistencia->sabado;
                        
                        if ($diass[0]['lunes'] == 'lunes') {
                            $lunesa = 2;
                            if ($fechalunes == $lunesfecha) {
                                if ($asislunes == 1) {
                                    $lunesa = 1;
                                } else {
                                    $lunesa = 0;
                                }
                            }
                            if (count($feriadolun) > 0) $lunesa = 4;
                        }

                        if ($diass[0]['martes'] == 'martes') {
                            $martesa = 2;
                            if ($fechamartes == $martesfecha) {
                                if ($asismartes == 1) {
                                    $martesa = 1;
                                } else {
                                    $martesa = 0;
                                }
                            }
                            if (count($feriadomar) > 0) $martesa = 4;
                        }

                        if ($diass[0]['miercoles'] == 'miercoles') {
                            $miercolesa = 2;
                            if ($fechamiercoles == $miercolesfecha) {
                                if ($asismiercoles == 1) {
                                    $miercolesa = 1;
                                } else {
                                    $miercolesa = 0;
                                }
                            }
                            if (count($feriadomie) > 0) $miercolesa = 4;
                        }

                        if ($diass[0]['jueves'] == 'jueves') {
                            $juevesa = 2;
                            if ($fechajueves == $juevesfecha) {
                                if ($asisjueves == 1) {
                                    $juevesa = 1;
                                } else {
                                    $juevesa = 0;
                                }
                            }
                            if (count($feriadojue) > 0) $juevesa = 4;
                        }

                        if ($diass[0]['viernes'] == 'viernes') {
                            $viernesa = 2;
                            if ($fechaviernes == $viernesfecha) {
                                if ($asisviernes == 1) {
                                    $viernesa = 1;
                                } else {
                                    $viernesa = 0;
                                }
                            }
                            if (count($feriadovie) > 0) $viernesa = 4;
                        }

                        if ($diass[0]['sabado'] == 'sabado') {
                            $sabadoa = 2;
                            if ($fechasabado == $sabadofecha) {
                                if ($asissabado == 1) {
                                    $sabadoa = 1;
                                } else {
                                    $sabadoa = 0;
                                }
                            }
                            if (count($feriadosab) > 0) $sabadoa = 4;
                        }

                        $alumnosinscriptos[] = ['alumno_id' => $alumnoid, 'apellido' => $apellido, 'nombre' => $nombre, 'nrodocumento' => $nrodocumento, 'lunes' => $lunesa, 'martes' => $martesa, 'miercoles' => $miercolesa, 'jueves' => $juevesa, 'viernes' => $viernesa, 'sabado' => $sabadoa];
                    }
                }
			}
		}

        $fechainicio = '';
        $fechafin = '';
        $materiass = Materia::find($materia_id);
        
        if ($materiass->periodo == 'Anual') {
            //$ciclo_id = PlanEstudio::find($planID)->ciclolectivo_id;

            $ciclos = CicloLectivo::find($ciclo_id);
            $fechainicio = FechaHelper::getFechaImpresion($ciclos->fechainicio);
            $fechafin = FechaHelper::getFechaImpresion($ciclos->fechafin);
        } else {
            $cuatri = $materiass->cuatrimestre;
            //$ciclo_id = PlanEstudio::find($planID)->ciclolectivo_id;

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
                    /*if ($fechap > $fechainicio) {
                        if ($fechap < $fechafin) {
                            $fechainicio = $value->fechainic;
                            $fechafin = $value->fechafic;
                        }
                    }*/
                }
            } else {
                $fechainicio = '';
                $fechafin = '';
            }
        }
        
        if (!$fechainicio == '') {
            $porcion = explode("/", $fechainicio);
            $fechainicio = $porcion[2].'-'.$porcion[1].'-'.$porcion[0];
            $porcion = explode("/", $fechafin);
            $fechafin = $porcion[2].'-'.$porcion[1].'-'.$porcion[0];
        }

        $dni = '';
        $org_id = 1;

		$habilita = true;
        $ciclos = CicloLectivo::all();

        return View::make('asistencias.listado',[
            'organizaciones'  	=> $organizaciones,
            'org_id'            => $org_id,
            'carrera_id'        => $asistenciass->carrera_id,
            'carreras'        	=> $carreras,
            'materia_id'        => $asistenciass->materia_id,
            'materias'        	=> $materias,
            'planID'     	  	=> $planID,
            'planes'          	=> $planes,
            'ciclo_id'          => $ciclo_id,
            'ciclos'            => $ciclos,
            'docente_id'        => $docente_id,
            'docentes'          => $docentes,
            'dias'          	=> $dias,
            'diass'             => $diass,
            'meses'          	=> $meses,
            'alumnosinscriptos' => $alumnosinscriptos,
            'habilita' 			=> $habilita,
            'dni' 				=> $dni,
            'fechadesdes'       => $fecha,
            'fecha'             => $fecha,
            'lunes'             => $lunes,
            'lunesmes'          => $lunesmes,
            'martes'            => $martes,
            'martesmes'         => $martesmes,
            'miercoles'         => $miercoles,
            'miercolesmes'      => $miercolesmes,
            'jueves'            => $jueves,
            'juevesmes'         => $juevesmes,
            'viernes'           => $viernes,
            'viernesmes'        => $viernesmes,
            'sabado'            => $sabado,
            'sabadomes'         => $sabadomes,
            'fechainicio'       => $fechainicio,
            'fechafin'          => $fechafin
        ])->with('menu', ModulosHelper::MENU_GESTION_ACADEMICA)
            ->with('submenu', ModulosHelper::SUBMENU_ASISTENCIA)
            ->with('leer', Session::get('ASISTENCIA_LEER'))
            ->with('editar', Session::get('ASISTENCIA_EDITAR'))
            ->with('imprimir', Session::get('ASISTENCIA_IMPRIMIR'))
            ->with('eliminar', Session::get('ASISTENCIA_ELIMINAR'));
    }

    public function getImprimir()
    {
        $carrera_id = Input::get('carrera_id');
        $planID = Input::get('planID');
        $ciclo_id = Input::get('cboCiclos');
        $materia_id = Input::get('materia_id');
        $docente_id = Input::get('docente_id');
        $fechadesde = Input::get('fechadesde');
        $fechaimp = Input::get('fechadesde');
        $dni = Input::get('txtalumno');//30294929

        /////////////////////////////////////
        if ($fechadesde == '') {
            //Genero la semana a mostrar, lunes a sabado
            $date = strtotime(date("Y-m-d"));
            $first = strtotime('last Sunday 1 days');
            $last = strtotime('next Saturday 0 days');
            //echo date('Y-m-d', $first);
            //echo '<br>';
            //echo date('Y-m-d', $last);
            $porcion = explode("-", date('d-m-Y', $first));
            $fechalunes = date('d/m/Y', $first);
            $fechalunescons = $porcion[2].'-'.$porcion[1].'-'.$porcion[0];
            $lunes = $porcion[0];
            $lunesmes = (string)(int)$porcion[1];

            $fecha = date('d-m-Y', $first);
            $nuevafecha = strtotime('+1 day', strtotime($fecha));
            $fechamartes = date('d/m/Y', $nuevafecha);
            $porcion = explode("-", date('d-m-Y', $nuevafecha));
            $martes = $porcion[0];
            $martesmes = (string)(int)$porcion[1];

            $nuevafecha = strtotime('+2 day', strtotime($fecha));
            $fechamiercoles = date('d/m/Y', $nuevafecha);
            $porcion = explode("-", date('d-m-Y', $nuevafecha));
            $miercoles = $porcion[0];
            $miercolesmes = (string)(int)$porcion[1];

            $nuevafecha = strtotime('+3 day', strtotime($fecha));
            $fechajueves = date('d/m/Y', $nuevafecha);
            $porcion = explode("-", date('d-m-Y', $nuevafecha));
            $jueves = $porcion[0];
            $juevesmes = (string)(int)$porcion[1];

            $nuevafecha = strtotime('+4 day', strtotime($fecha));
            $fechaviernes = date('d/m/Y', $nuevafecha);
            $porcion = explode("-", date('d-m-Y', $nuevafecha));
            $viernes = $porcion[0];
            $viernesmes = (string)(int)$porcion[1];

            $nuevafecha = strtotime('+5 day', strtotime($fecha));
            $fechasabado = date('d/m/Y', $nuevafecha);
            $porcion = explode("-", date('d-m-Y', $nuevafecha));
            $sabado = $porcion[0];
            $sabadomes = (string)(int)$porcion[1];
        } else {
            $diaInicio="Monday";
            $diaFin="Saturday";
            //$fecha = '2017-11-15';

            $strFecha = strtotime($fechadesde);

            $fechaInicio = date('Y-m-d',strtotime('last '.$diaInicio, $strFecha));
            $fechaFin = date('Y-m-d',strtotime('next '.$diaFin, $strFecha));

            if(date("l",$strFecha)==$diaInicio){
                $fechaInicio= date("Y-m-d",$strFecha);
            }

            if(date("l",$strFecha)==$diaFin){
                $fechaFin= date("Y-m-d",$strFecha);
            }
           
            $first = strtotime('last Sunday 1 days');
            $last = strtotime('next Saturday 0 days');
            $porcion = explode("-", date($fechaInicio, $first));
            $fechai = strtotime($fechaInicio);
            $fechalunes = date('d/m/Y', $fechai);
            $fechalunescons = $porcion[0].'-'.$porcion[1].'-'.$porcion[2];
            $lunes = $porcion[2];
            $lunesmes = (string)(int)$porcion[1];

            $nuevafecha = strtotime($fechaInicio."+ 1 days");
            $fechamartes = date('d/m/Y', $nuevafecha);
            $porcion = explode("-", date('d-m-Y', $nuevafecha));
            $martes = $porcion[0];
            $martesmes = (string)(int)$porcion[1];

            $nuevafecha = strtotime($fechaInicio."+ 2 days");
            $fechamiercoles = date('d/m/Y', $nuevafecha);
            $porcion = explode("-", date('d-m-Y', $nuevafecha));
            $miercoles = $porcion[0];
            $miercolesmes = (string)(int)$porcion[1];

            $nuevafecha = strtotime($fechaInicio."+ 3 days");
            $fechajueves = date('d/m/Y', $nuevafecha);
            $porcion = explode("-", date('d-m-Y', $nuevafecha));
            $jueves = $porcion[0];
            $juevesmes = (string)(int)$porcion[1];

            $nuevafecha = strtotime($fechaInicio."+ 4 days");
            $fechaviernes = date('d/m/Y', $nuevafecha);
            $porcion = explode("-", date('d-m-Y', $nuevafecha));
            $viernes = $porcion[0];
            $viernesmes = (string)(int)$porcion[1];

            $nuevafecha = strtotime($fechaInicio."+ 5 days");
            $fechasabado = date('d/m/Y', $nuevafecha);
            $porcion = explode("-", date('d-m-Y', $nuevafecha));
            $sabado = $porcion[0];
            $sabadomes = (string)(int)$porcion[1];
        }

        $lunesa = 3;
        $martesa = 3;
        $miercolesa = 3;
        $juevesa = 3;
        $viernesa = 3;
        $sabadoa = 3;
        $luness = '';
        $martess = '';
        $miercoless = '';
        $juevess = '';
        $vierness = '';
        $sabados = '';
        /*$carrera_id = $asistenciass->carrera_id;
        $materia_id = $asistenciass->materia_id;
        $planID = $asistenciass->planestudio_id;*/

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
        //////////////////////////////////////////

        $meses = ['vacio', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        $dias = ['vacio', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];

        if ($fechadesde == '') {
            $fechadesdes = date('Y-m-d');
            $porcion = explode("-", $fechadesdes);
            $mees = (string)(int)$porcion[1];
            $fecha = $dias[date('N', strtotime($fechadesdes))].' '. $porcion[2] .' de '.$meses[$mees] .' de '.$porcion[0];
            $fechadesde = date('d/m/Y');
        } else {
            $porcion = explode("-", $fechadesde);
            $mees = (string)(int)$porcion[1];
            $fecha = $dias[date('N', strtotime($fechadesde))].' '. $porcion[2] .' de '.$meses[$mees] .' de '.$porcion[0];
            $fechadesde = $porcion[2].'/'.$porcion[1].'/'.$porcion[0];
            //$fechadesde = $fechadesdes;
        }

        $carreras = Carrera::find($carrera_id)->carrera;
        $planes = PlanEstudio::find($planID)->codigoplan;
        $materia = Materia::find($materia_id)->nombremateria;
        $docente = Docente::find($docente_id);
        $docent = Persona::where('id', '=', $docente->persona_id)->first();
        $docentes = $docent->apellido.', '.$docent->nombre;
        /*$docentes[] = ['id' => $docente->id, 'apeynom' => $apeynom];
        $asistencias = Asistencias::whereRaw('planestudio_id ='.$planID.' AND materia_id ='.$materia_id.' AND carrera_id ='.$carrera_id)->get();*/
        //$ciclo_id = PlanEstudio::find($planID)->ciclolectivo_id;

        if ($dni == '') {
            $datos = InscripcionMateria::whereRaw('planestudio_id ='. $planID .' AND materia_id ='. $materia_id .' AND carrera_id ='. $carrera_id.' AND ciclolectivo_id ='.$ciclo_id)->get();
        } else {
            $alumno = Alumno::getAlumnoPorDni($dni);
            $datos = InscripcionMateria::whereRaw('planestudio_id ='. $planID .' AND alumno_id ='. $alumno[0]->alumno_id .' AND materia_id ='. $materia_id .' AND carrera_id ='. $carrera_id.' AND ciclolectivo_id ='.$ciclo_id)->get();
        }
        
        $alumnos = [];
        $alumnosinscriptos = [];

        if (count($datos) > 0) {
            foreach ($datos as $dato) {
                array_push($alumnos, $dato->alumno_id);
            }

            $resultado = array_unique($alumnos);
            sort($resultado);

            for ($i=0; $i < count($resultado); $i++) { 
                $alumnoss = Alumno::find($resultado[$i]);
                $alumnoid = $alumnoss->id;
                $apellido = $alumnoss->persona->apellido;
                $nombre = $alumnoss->persona->nombre;
                $nrodocumento = $alumnoss->persona->nrodocumento;

                $asistencias = Asistencias::whereRaw('alumno_id ='.$resultado[$i].' AND planestudio_id ='.$planID.' AND materia_id ='.$materia_id.' AND carrera_id ='.$carrera_id.' AND ciclolectivo_id ='.$ciclo_id.' AND lunesfecha ="'.$fechalunescons.'"')->get();

                if (count($asistencias) > 0) {
                    foreach ($asistencias as $asistencia) {
                        $lunesfecha = FechaHelper::getFechaImpresion($asistencia->lunesfecha);
                        $martesfecha = FechaHelper::getFechaImpresion($asistencia->martesfecha);
                        $miercolesfecha = FechaHelper::getFechaImpresion($asistencia->miercolesfecha);
                        $juevesfecha = FechaHelper::getFechaImpresion($asistencia->juevesfecha);
                        $viernesfecha = FechaHelper::getFechaImpresion($asistencia->viernesfecha);
                        $sabadofecha = FechaHelper::getFechaImpresion($asistencia->sabadofecha);

                        $porcion = explode("/", $lunesfecha);
                        $lunesfechaf = $porcion[2].'-'.(string)(int)$porcion[1].'-'.$porcion[0];
                        $feriadolun = Feriados::whereRaw('ciclolectivo_id ='.$ciclo_id.' AND fecha_feriado ="'.$lunesfechaf.'"')->first();

                        $porcion = explode("/", $martesfecha);
                        $martesfechaf = $porcion[2].'-'.(string)(int)$porcion[1].'-'.$porcion[0];
                        $feriadomar = Feriados::whereRaw('ciclolectivo_id ='.$ciclo_id.' AND fecha_feriado ="'.$martesfechaf.'"')->first();

                        $porcion = explode("/", $miercolesfecha);
                        $miercolesfechaf = $porcion[2].'-'.(string)(int)$porcion[1].'-'.$porcion[0];
                        $feriadomie = Feriados::whereRaw('ciclolectivo_id ='.$ciclo_id.' AND fecha_feriado ="'.$miercolesfechaf.'"')->first();

                        $porcion = explode("/", $juevesfecha);
                        $juevesfechaf = $porcion[2].'-'.(string)(int)$porcion[1].'-'.$porcion[0];
                        $feriadojue = Feriados::whereRaw('ciclolectivo_id ='.$ciclo_id.' AND fecha_feriado ="'.$juevesfechaf.'"')->first();

                        $porcion = explode("/", $viernesfecha);
                        $viernesfechaf = $porcion[2].'-'.(string)(int)$porcion[1].'-'.$porcion[0];
                        $feriadovie = Feriados::whereRaw('ciclolectivo_id ='.$ciclo_id.' AND fecha_feriado ="'.$viernesfechaf.'"')->first();

                        $porcion = explode("/", $sabadofecha);
                        $sabadofechaf = $porcion[2].'-'.(string)(int)$porcion[1].'-'.$porcion[0];
                        $feriadosab = Feriados::whereRaw('ciclolectivo_id ='.$ciclo_id.' AND fecha_feriado ="'.$sabadofechaf.'"')->first();

                        $asislunes = $asistencia->lunes;
                        $asismartes = $asistencia->martes;
                        $asismiercoles = $asistencia->miercoles;
                        $asisjueves = $asistencia->jueves;
                        $asisviernes = $asistencia->viernes;
                        $asissabado = $asistencia->sabado;
                        
                        if ($diass[0]['lunes'] == 'lunes') {
                            $lunesa = 2;
                            if ($fechalunes == $lunesfecha) {
                                if ($asislunes == 1) {
                                    $lunesa = 1;
                                } else {
                                    if ($lunesfecha == date('d/m/Y')) {
                                        $lunesa = 0;
                                    } else {
                                        if ($lunesfecha > date('d/m/Y')) {
                                            $lunesa = 0;
                                        }
                                    }
                                }
                                if (count($feriadolun) > 0) $lunesa = 5;
                            }
                        }

                        if ($diass[0]['martes'] == 'martes') {
                            $martesa = 2;
                            if ($fechamartes == $martesfecha) {
                                if ($asismartes == 1) {
                                    $martesa = 1;
                                } else {
                                    if ($martesfecha == date('d/m/Y')) {
                                        $martesa = 0;
                                    } else {
                                        if ($martesfecha > date('d/m/Y')) {
                                            $martesa = 0;
                                        }
                                    }
                                }
                                if (count($feriadomar) > 0) $martesa = 5;
                            }
                        }

                        if ($diass[0]['miercoles'] == 'miercoles') {
                            $miercolesa = 2;
                            if ($fechamiercoles == $miercolesfecha) {
                                if ($asismiercoles == 1) {
                                    $miercolesa = 1;
                                } else {
                                    if ($miercolesfecha == date('d/m/Y')) {
                                        $miercolesa = 0;
                                    } else {
                                        if ($miercolesfecha > date('d/m/Y')) {
                                            $miercolesa = 0;
                                        }
                                    }
                                }
                                if (count($feriadomie) > 0) $miercolesa = 5;
                            }
                        }

                        if ($diass[0]['jueves'] == 'jueves') {
                            $juevesa = 2;
                            if ($fechajueves == $juevesfecha) {
                                if ($asisjueves == 1) {
                                    $juevesa = 1;
                                } else {
                                    if ($juevesfecha == date('d/m/Y')) {
                                        $juevesa = 0;
                                    } else {
                                        if ($juevesfecha > date('d/m/Y')) {
                                            $juevesa = 0;
                                        }
                                    }
                                }
                                if (count($feriadojue) > 0) $juevesa = 5;
                            }
                        }

                        if ($diass[0]['viernes'] == 'viernes') {
                            $viernesa = 2;
                            if ($fechaviernes == $viernesfecha) {
                                if ($asisviernes == 1) {
                                    $viernesa = 1;
                                } else {
                                    if ($viernesfecha == date('d/m/Y')) {
                                        $viernesa = 0;
                                    } else {
                                        if ($viernesfecha > date('d/m/Y')) {
                                            $viernesa = 0;
                                        }
                                    }
                                }
                                if (count($feriadovie) > 0) $viernesa = 5;
                            }
                        }

                        if ($diass[0]['sabado'] == 'sabado') {
                            $sabadoa = 2;
                            if ($fechasabado == $sabadofecha) {
                                if ($asissabado == 1) {
                                    $sabadoa = 1;
                                } else {
                                    if ($sabadofecha == date('d/m/Y')) {
                                        $sabadoa = 0;
                                    } else {
                                        if ($sabadofecha > date('d/m/Y')) {
                                            $sabadoa = 0;
                                        }
                                    }
                                }
                                if (count($feriadosab) > 0) $sabadoa = 5;
                            }
                        }

                        $alumnosinscriptos[] = ['alumno_id' => $alumnoid, 'apellido' => $apellido, 'nombre' => $nombre, 'nrodocumento' => $nrodocumento, 'lunes' => $lunesa, 'martes' => $martesa, 'miercoles' => $miercolesa, 'jueves' => $juevesa, 'viernes' => $viernesa, 'sabado' => $sabadoa];
                    }
                } else {
                    if ($diass[0]['lunes'] == 'lunes') {
                        $lunesa = 4;
                    }

                    if ($diass[0]['martes'] == 'martes') {
                        $martesa = 4;
                    }

                    if ($diass[0]['miercoles'] == 'miercoles') {
                        $miercolesa = 4;
                    }

                    if ($diass[0]['jueves'] == 'jueves') {
                        $juevesa = 4;
                    }

                    if ($diass[0]['viernes'] == 'viernes') {
                        $viernesa = 4;
                    }

                    if ($diass[0]['sabado'] == 'sabado') {
                        $sabadoa = 4;
                    }

                    $alumnosinscriptos[] = ['alumno_id' => $alumnoid, 'apellido' => $apellido, 'nombre' => $nombre, 'nrodocumento' => $nrodocumento, 'lunes' => $lunesa, 'martes' => $martesa, 'miercoles' => $miercolesa, 'jueves' => $juevesa, 'viernes' => $viernesa, 'sabado' => $sabadoa];
                }
            }
        }

        if ($fechaimp == date('Y-m-d')) {
            $fechaimp = '';
        }

        $ciclo = CicloLectivo::find($ciclo_id)->descripcion;

        /*highlight_string(var_export($alumnosinscriptos,true));
        exit;*/
        $pdf = PDF::loadView('informes.pdf.asistencias', [
            'alumnosinscriptos' =>  $alumnosinscriptos,
            'carreras'          =>  $carreras,
            'planes'            =>  $planes,
            'ciclo'             =>  $ciclo,
            'materia'           =>  $materia,
            'docentes'          =>  $docentes,
            'fecha'             =>  $fecha,
            'fechaimp'          =>  $fechaimp,
            'diass'             =>  $diass,
            'meses'             =>  $meses,
            'lunes'             =>  $lunes,
            'lunesmes'          =>  $lunesmes,
            'martes'            =>  $martes,
            'martesmes'         =>  $martesmes,
            'miercoles'         =>  $miercoles,
            'miercolesmes'      =>  $miercolesmes,
            'jueves'            =>  $jueves,
            'juevesmes'         =>  $juevesmes,
            'viernes'           =>  $viernes,
            'viernesmes'        =>  $viernesmes,
            'sabado'            =>  $sabado,
            'sabadomes'         =>  $sabadomes,
            'lunesfecha'        =>  $fechalunes,
            'martesfecha'       =>  $fechamartes,
            'miercolesfecha'    =>  $fechamiercoles,
            'juevesfecha'       =>  $fechajueves,
            'viernesfecha'      =>  $fechaviernes,
            'sabadofecha'       =>  $fechasabado]);
        return $pdf->setOrientation('landscape')->stream();
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
