<?php
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CorrelatividadesController extends \BaseController {

	private $_data;
    private $_rules;
    private $_messages;

    const OPERACION_EXITOSA = 1;
    const OPERACION_FALLIDA = 2;
    const OPERACION_CANCELADA = 3;
    const OPERACION_INFO = 4;

    const NO_TIENE_CARRERAS = 0;
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
    {
        return Redirect::to('correlatividades/listado');
    }

    public function getListado()
    {

        $organizaciones = Organizacion::all();
        $carreras = Carrera::all();
        $planes = PlanEstudio::all();

        //array_unshift($organizaciones, 'Seleccionar');

    	return View::make('correlatividades/listado')
            ->with('organizaciones', $organizaciones)
            ->with('arrCarreras', $carreras)
            ->with('arrPlanes', $planes)
            ->with('menu', ModulosHelper::MENU_GESTION_ADMINISTRATIVA)
            ->with('submenu', ModulosHelper::SUBMENU_CORRELATIVIDADES)
            ->with('leer', Session::get('CORRELATIVIDAD_LEER'))
            ->with('editar', Session::get('CORRELATIVIDAD_EDITAR'))
            ->with('imprimir', Session::get('CORRELATIVIDAD_IMPRIMIR'))
            ->with('eliminar', Session::get('CORRELATIVIDAD_ELIMINAR'));     		
    }

    
    public function postObtenermateriacorrelativas()
    {
        $plan = Input::get('plan');

        $materias = Materia::where('planestudio_id', '=', $plan)->get();
        $listacorrelativas = array();
        if ($materias) {
            
            foreach ($materias as $key => $value) {
                $correlatividades = Correlatividad::where('materia_id', '=', $value->id)->first();
                if ($correlatividades) {

                    $corrcursada = Correlatividadcursada::where('correlatividad_id', '=', $correlatividades->id)->get();
                    if($corrcursada) {
                        $cursadas = '';
                        foreach ($corrcursada as $key => $value1) {
                                
                            if ($cursadas == ''){
                                $cursadas = $value1->materia->nombremateria;
                            } else {
                                $cursadas = $cursadas . ' - ' . $value1->materia->nombremateria;                            
                            }
                        }
                    } else{
                        $cursadas = '-';
                    }

                    $corraprobada = Correlatividadaprobada::where('correlatividad_id', '=', $correlatividades->id)->get();
                    if($corraprobada) {
                        $aprobadas = '';
                        foreach ($corraprobada as $key => $value2) {
                            if ($aprobadas == ''){
                                $aprobadas = $value2->materia->nombremateria;
                            } else {
                                $aprobadas = $aprobadas . ' - ' . $value2->materia->nombremateria;                            
                            }

                        }
                    } else{
                        $aprobadas = '-';
                    }

                    $corrfinal = Correlatividadfinalaprobado::where('correlatividad_id', '=', $correlatividades->id)->get();
                    if($corrfinal) {
                        $finales = '';
                        foreach ($corrfinal as $key => $value3) {
                                
                            if ($finales == ''){
                                $finales = $value3->materia->nombremateria;
                            } else {
                                $finales = $finales . ' - ' . $value3->materia->nombremateria;                            
                            }
                        }
                    } else{
                        $finales = '-';
                    }

                    $cuatrimestre = '';

                    if($value->periodo == 'Cuatrimestral') {
                        $cuatrimestre = $value->cuatrimestre;
                    } else {
                         $cuatrimestre = '-';
                    }

                    $listacorrelativas[] = ['codigo' => $value->aniocursado, 'id' => $correlatividades->id, 'periodo' => $value->periodo, 'nombremateria' => $value->nombremateria, 'cursadas' => $cursadas, 'aprobadas' => $aprobadas, 'finales' => $finales, 'cuatrimestre' => $cuatrimestre];
                    
                    //
                }
            
            }
        }

        sort($listacorrelativas);

        return Response::json($listacorrelativas);
    }

    

    public function getCrear()
    {
        $organizaciones = Organizacion::all();
        $carreras = Carrera::all();
        $materias = Materia::all();
        $planes = PlanEstudio::all();

         //$user->toArray();

        /*highlight_string(var_export($carreras->toArray(), true));
        exit();*/

        return View::make('correlatividades.nuevo')->with([
            'arrOrganizaciones' => $organizaciones,
            'arrCarreras' => $carreras->toArray(),
            'arrMaterias' => $materias->toArray(),
            'arrPlanes' => $planes->toArray(),
            //'carreras'          => Carrera::lists('carrera', 'id'),
            //'planes'            => PlanEstudio::lists('codigoplan', 'id'),
            'menu'              => ModulosHelper::MENU_GESTION_ACADEMICA,
            'submenu'           => ModulosHelper::SUBMENU_CORRELATIVIDADES,
            'leer'              => Session::get('CORRELATIVIDAD_LEER'),
            'editar'            => Session::get('CORRELATIVIDAD_EDITAR'),
            'imprimir'          => Session::get('CORRELATIVIDAD_IMPRIMIR'),
            'eliminar'          => Session::get('CORRELATIVIDAD_ELIMINAR')
        ]);
    }


public function postGuardar()
    {

        $organizacion  = Input::get('organizacion');
        $carrera       = Input::get('carreras');
        $plan          = Input::get('planes');
        $materia       = Input::get('materias');
        $cursadas      = Input::get('cursadas');
        $aprobadas     = Input::get('aprobadas');
        $finales        = Input::get('finales');



         if ($organizacion == 0 OR $carrera == 0 OR $plan == 0 OR $materia == 0) {

            Session::flash('message', 'DEBE SELECCIONAR UNA OPCION DE CADA COMBO.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('correlatividades/crear');
        } 

        $corr = Correlatividad::where('materia_id', '=', $materia)->first();

        if ($corr){
            Session::flash('message', 'ESTA MATERIA YA FUE DADA DE ALTA.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('correlatividades/crear');
        }

        $correlatividad = new Correlatividad();
            $correlatividad->materia_id          =  $materia;  
            $correlatividad->usuario_alta        = Auth::user()->usuario;
            $correlatividad->fecha_alta          = date('Y-m-d');
        $correlatividad->save();

        if ($cursadas) {


            for ($i = 0; $i < count($cursadas); $i++) {
                
                $correlatividadcursada = new Correlatividadcursada();
                    $correlatividadcursada->correlatividad_id  = $correlatividad->id;
                    $correlatividadcursada->materia_id         =  $cursadas[$i];
                    $correlatividadcursada->usuario_alta       = Auth::user()->usuario;
                    $correlatividadcursada->fecha_alta         = date('Y-m-d');
                $correlatividadcursada->save();
            }
        }

        if ($aprobadas) {


            for ($i = 0; $i < count($aprobadas); $i++) {
                
                $correlatividadaprobada = new Correlatividadaprobada();
                    $correlatividadaprobada->correlatividad_id  = $correlatividad->id;
                    $correlatividadaprobada->materia_id         =  $aprobadas[$i];
                    $correlatividadaprobada->usuario_alta       = Auth::user()->usuario;
                    $correlatividadaprobada->fecha_alta         = date('Y-m-d');
                $correlatividadaprobada->save();
            }
        }

        if ($finales) {


            for ($i = 0; $i < count($finales); $i++) {
                
                $correlatividadfinalaprobado = new Correlatividadfinalaprobado();
                    $correlatividadfinalaprobado->correlatividad_id  = $correlatividad->id;
                    $correlatividadfinalaprobado->materia_id         =  $finales[$i];
                    $correlatividadfinalaprobado->usuario_alta       = Auth::user()->usuario;
                    $correlatividadfinalaprobado->fecha_alta         = date('Y-m-d');
                $correlatividadfinalaprobado->save();
            }
        }
        /*highlight_string(var_export($cursadas, true));
        exit();*/

        Session::flash('message', 'LOS DATOS SE GUARDARON CORRECTAMENTE.');
        Session::flash('message_type', self::OPERACION_EXITOSA);
        //return Redirect::to('correlatividades/crear');
        return Redirect::to('correlatividades/crear')
                //->withErrors($validator)
                ->withInput();
    }


public function getEditar($id)
    {

        //echo $id;

        $correlatividad = Correlatividad::where('id', '=', $id)->first();
        $materia = Materia::where('id', '=', $correlatividad->materia_id)->first();
        $carrera = Carrera::where('id', '=', $materia->carrera_id)->first();
        $plan = PlanEstudio::where('id', '=', $materia->planestudio_id)->first();
        $organizacion = Organizacion::where('id', '=', $carrera->organizacion_id)->first();



        $correlatividadcursadas = Materia::where('planestudio_id', '=', $plan->id)->get();

        foreach ($correlatividadcursadas as $key => $value) {
             
            $correlatividadtemp = Correlatividadcursada::where('materia_id', '=', $value->id)->where('correlatividad_id', '=', $id)->first();

            if ($correlatividadtemp) {
                $value->hsreloj = 1;
            } else {
                $value->hsreloj = 0;
            }
        }


        $correlatividadaprobadas = Materia::where('planestudio_id', '=', $plan->id)->get();

        foreach ($correlatividadaprobadas as $key => $value) {
             
            $correlatividadtemp = Correlatividadaprobada::where('materia_id', '=', $value->id)->where('correlatividad_id', '=', $id)->first();

            if ($correlatividadtemp) {
                $value->hsreloj = 1;
            } else {
                $value->hsreloj = 0;
            }
        }

        $correlatividadfinales = Materia::where('planestudio_id', '=', $plan->id)->get();

        foreach ($correlatividadfinales as $key => $value) {
             
            $correlatividadtemp = Correlatividadfinalaprobado::where('materia_id', '=', $value->id)->where('correlatividad_id', '=', $id)->first();

            if ($correlatividadtemp) {
                $value->hsreloj = 1;
            } else {
                $value->hsreloj = 0;
            }
        }


        return View::make('correlatividades.editar')->with([
            'correlatividad' => $correlatividad,
            'organizacion' => $organizacion,
            'carrera' => $carrera,
            'materia' => $materia,
            'plan' => $plan,
            'correlatividadfinales' => $correlatividadfinales,
            'correlatividadcursadas' => $correlatividadcursadas,
            'correlatividadaprobadas' => $correlatividadaprobadas,
            'menu'              => ModulosHelper::MENU_GESTION_ACADEMICA,
            'submenu'           => ModulosHelper::SUBMENU_CORRELATIVIDADES,
            'leer'              => Session::get('CORRELATIVIDAD_LEER'),
            'editar'            => Session::get('CORRELATIVIDAD_EDITAR'),
            'imprimir'          => Session::get('CORRELATIVIDAD_IMPRIMIR'),
            'eliminar'          => Session::get('CORRELATIVIDAD_ELIMINAR')
        ]);
    }



public function postEditar()
    {

        $correlatividad= Input::get('txtcorrId');
        $cursadas      = Input::get('cursadas');
        $aprobadas     = Input::get('aprobadas');
        $finales        = Input::get('finales');


        /*highlight_string(var_export($correlatividad, true));
        exit();*/

        $cursadastemp = Correlatividadcursada::where('correlatividad_id', '=', $correlatividad)->delete();
  
        

        if ($cursadas) {


            for ($i = 0; $i < count($cursadas); $i++) {
                
                $correlatividadcursada = new Correlatividadcursada();
                    $correlatividadcursada->correlatividad_id  = $correlatividad;
                    $correlatividadcursada->materia_id         =  $cursadas[$i];
                    $correlatividadcursada->usuario_alta       = Auth::user()->usuario;
                    $correlatividadcursada->fecha_alta         = date('Y-m-d');
                $correlatividadcursada->save();
            }
        }

        $aprobadastemp = Correlatividadaprobada::where('correlatividad_id', '=', $correlatividad)->delete();
    
       

        if ($aprobadas) {


            for ($i = 0; $i < count($aprobadas); $i++) {
                
                $correlatividadaprobada = new Correlatividadaprobada();
                    $correlatividadaprobada->correlatividad_id  = $correlatividad;
                    $correlatividadaprobada->materia_id         =  $aprobadas[$i];
                    $correlatividadaprobada->usuario_alta       = Auth::user()->usuario;
                    $correlatividadaprobada->fecha_alta         = date('Y-m-d');
                $correlatividadaprobada->save();
            }
        }



        $finalestemp = Correlatividadfinalaprobado::where('correlatividad_id', '=', $correlatividad)->delete();
    
       

        if ($finales) {


            for ($i = 0; $i < count($finales); $i++) {
                
                $correlatividadfinal = new Correlatividadfinalaprobado();
                    $correlatividadfinal->correlatividad_id  = $correlatividad;
                    $correlatividadfinal->materia_id         =  $finales[$i];
                    $correlatividadfinal->usuario_alta       = Auth::user()->usuario;
                    $correlatividadfinal->fecha_alta         = date('Y-m-d');
                $correlatividadfinal->save();
            }
        }
        /*highlight_string(var_export($cursadas, true));
        exit();*/

        Session::flash('message', 'LOS DATOS SE MODIFICARON CORRECTAMENTE.');
        Session::flash('message_type', self::OPERACION_EXITOSA);
        return Redirect::to('correlatividades/editar/'.$correlatividad);
    }




    public function postBorrar()
    {


        $id = Input::get('idCorrelatividadHidden');

        $correlatividad = Correlatividad::find($id);

        if ($correlatividad->correlatividadescursadas) {
            Session::flash('message', 'NO SE PUDO ELIMINAR LA CORRELATIVIDAD');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('correlatividades/listado');
        }
        
        if ($correlatividad->correlatividadesaprobadas) {
            Session::flash('message', 'NO SE PUDO ELIMINAR LA CORRELATIVIDAD');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('correlatividades/listado');
        }
        
        if ($correlatividad->correlatividadfinalaprobados) {
            Session::flash('message', 'NO SE PUDO ELIMINAR LA CORRELATIVIDAD');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('correlatividades/listado');
        }
        

        /*highlight_string(var_export($materia->correlatividades,true));
        exit();*/
        $aprobadastemp = Correlatividadaprobada::where('correlatividad_id', '=', $id)->delete();
        $cursadastemp = Correlatividadcursada::where('correlatividad_id', '=', $id)->delete();
        $finalestemp = Correlatividadfinalaprobado::where('correlatividad_id', '=', $correlatividad)->delete();
        $correlatividad->delete();

        Session::flash('message', 'LA CORRELATIVIDAD HA SIDO BORRADA CORRECTAMENTE.');
        Session::flash('message_type', self::OPERACION_EXITOSA);
        return Redirect::to('correlatividades/listado');
        

    }


    public function getImprimir()/*PDF*/
    {
        $plan = Input::get('plan');

        $descplan = PlanEstudio::where('id', '=', $plan)->first();

        $carrera = Carrera::where('id', '=', $descplan->carrera_id)->first();


        $materias = Materia::where('planestudio_id', '=', $plan)->get();

        $listacorrelativas = array();
        if ($materias) {
            
            foreach ($materias as $key => $value) {
                $correlatividades = Correlatividad::where('materia_id', '=', $value->id)->first();
                if ($correlatividades) {

                    $corrcursada = Correlatividadcursada::where('correlatividad_id', '=', $correlatividades->id)->get();
                    if($corrcursada) {
                        $cursadas = '';
                        foreach ($corrcursada as $key => $value1) {
                                
                            if ($cursadas == ''){
                                $cursadas = $value1->materia->nombremateria;
                            } else {
                                $cursadas = $cursadas . ' - ' . $value1->materia->nombremateria;                            
                            }
                        }
                    } else{
                        $cursadas = '-';
                    }

                    $corraprobada = Correlatividadaprobada::where('correlatividad_id', '=', $correlatividades->id)->get();
                    if($corraprobada) {
                        $aprobadas = '';
                        foreach ($corraprobada as $key => $value2) {
                            if ($aprobadas == ''){
                                $aprobadas = $value2->materia->nombremateria;
                            } else {
                                $aprobadas = $aprobadas . ' - ' . $value2->materia->nombremateria;                            
                            }

                        }
                    } else{
                        $aprobadas = '-';
                    }

                    $corrfinal = Correlatividadfinalaprobado::where('correlatividad_id', '=', $correlatividades->id)->get();
                    if($corrfinal) {
                        $finales = '';
                        foreach ($corrfinal as $key => $value3) {
                                
                            if ($finales == ''){
                                $finales = $value3->materia->nombremateria;
                            } else {
                                $finales = $finales . ' - ' . $value3->materia->nombremateria;                            
                            }
                        }
                    } else{
                        $finales = '-';
                    }

                    $cuatrimestre = '';

                    if($value->periodo == 'Cuatrimestral') {
                        $cuatrimestre = $value->cuatrimestre;
                    } else {
                         $cuatrimestre = '-';
                    }

                    $listacorrelativas[] = ['aniocursado' => $value->aniocursado, 'periodo' => $value->periodo, 'nombremateria' => $value->nombremateria, 'cursadas' => $cursadas, 'aprobadas' => $aprobadas,'finales' => $finales, 'cuatrimestre' => $cuatrimestre ];
                    
                    //
                }
            
            }
        }

        sort($listacorrelativas);

        //highlight_string(var_export($listacorrelativas,true));
        //exit;
        $pdf = PDF::loadView('informes.pdf.correlatividades', 
            ['listacorrelativas'=>$listacorrelativas,
             'plan'=>$descplan,
             'carrera'=>$carrera
            ]);
        return $pdf->setOrientation('landscape')->stream();
    }  


}
