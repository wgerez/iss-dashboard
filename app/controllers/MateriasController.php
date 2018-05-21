<?php
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MateriasController extends BaseController {

    private $_data;
    private $_rules;
    private $_messages;

    const OPERACION_EXITOSA = 1;
    const OPERACION_FALLIDA = 2;
    const OPERACION_CANCELADA = 3;
    const OPERACION_INFO = 4;

    public function getListado()
    {
        $organizaciones = Organizacion::lists('nombre', 'id');

        array_unshift($organizaciones, 'Seleccionar');

    	return View::make('materias/listado')
    		->with('organizaciones', $organizaciones)
            ->with('menu', ModulosHelper::MENU_GESTION_ADMINISTRATIVA)
            ->with('submenu', ModulosHelper::SUBMENU_MATERIAS)
            ->with('leer', Session::get('MATERIA_LEER'))
            ->with('editar', Session::get('MATERIA_EDITAR'))
            ->with('imprimir', Session::get('MATERIA_IMPRIMIR'))
            ->with('eliminar', Session::get('MATERIA_ELIMINAR'));          		
    }

    public function postObtenermaterias() 
    {
        $carrid = Input::get('carrera');
        $orgid = Input::get('organizacion');
        $planID = Input::get('plan');
        $ciclo_id = Input::get('cboCiclos');

        $materias = Materia::where('carrera_id', '=', $carrid)->where('planestudio_id', '=', $planID)->get();

        foreach ($materias as $value) {
            $promocionregular = RegularPromocion::whereRaw('materia_id ='.$value->id.' AND carrera_id ='.$carrid.' AND planestudio_id ='.$planID.' AND ciclolectivo_id ='.$ciclo_id)->first();

            $promocion = 0;

            if (count($promocionregular) > 0) {
                $promocion = $promocionregular->promocional;
                $value->promocional = $promocion;
            } else {
                $value->promocional = $promocion;
            }
        }

        $organizaciones = Organizacion::lists('nombre', 'id');

        return View::make('materias/listado')
            ->with('organizaciones', $organizaciones)
            ->with('materias', $materias)
            ->with('carrID', $carrid)
            ->with('OrgID', $orgid)
            ->with('planID', $planID)
            ->with('menu', ModulosHelper::MENU_GESTION_ADMINISTRATIVA)
            ->with('submenu', ModulosHelper::SUBMENU_MATERIAS)
            ->with('leer', Session::get('MATERIA_LEER'))
            ->with('editar', Session::get('MATERIA_EDITAR'))
            ->with('imprimir', Session::get('MATERIA_IMPRIMIR'))
            ->with('eliminar', Session::get('MATERIA_ELIMINAR'));                
    }


    public function getCrear()
    {
        $organizaciones = Organizacion::lists('nombre', 'id');
        $carreras       = Carrera::all();
        $planes         = PlanEstudio::all();

        array_unshift($organizaciones, 'Seleccionar');
        //array_unshift($carreras, 'Seleccionar');

      return View::make('materias/nuevo',[
          'carreras'            => $carreras,
          'arrOrganizaciones'   => $organizaciones,
          'planes'              => $planes
        ])
        ->with('menu', ModulosHelper::MENU_GESTION_ADMINISTRATIVA)
        ->with('submenu', ModulosHelper::SUBMENU_MATERIAS)
        ->with('leer', Session::get('MATERIA_LEER'))
        ->with('editar', Session::get('MATERIA_EDITAR'))
        ->with('imprimir', Session::get('MATERIA_IMPRIMIR'))
        ->with('eliminar', Session::get('MATERIA_ELIMINAR'));             
    }

    public function getEditar($id)
    {
        $materia = Materia::find($id);

        $organizaciones = Organizacion::lists('nombre', 'id');
        $carreras       = Carrera::lists('carrera', 'id');
        $planes         = PlanEstudio::lists('codigoplan', 'id');
        $ciclos         = CicloLectivo::all();
        $ciclo_id       = PlanEstudio::find($materia->planestudio_id)->ciclolectivo_id;
        $promo_regu    = RegularPromocion::whereRaw('materia_id ='.$id.' AND carrera_id ='.$materia->carrera_id.' AND planestudio_id ='.$materia->planestudio_id.' AND ciclolectivo_id ='.$ciclo_id)->first();

        $promocional = 0;

        if (count($promo_regu) > 0) {
            $promocional = $promo_regu->promocional;
        }

        return View::make('materias.edit',[
            'arrOrganizaciones'  => $organizaciones,
            'carreras'           => $carreras,
            'planes'             => $planes,   
            'materia'            => $materia,
            'ciclos'             => $ciclos,
            'ciclo_id'           => $ciclo_id,
            'promocional'        => $promocional
        ])->with('menu', ModulosHelper::MENU_GESTION_ADMINISTRATIVA)
          ->with('submenu', ModulosHelper::SUBMENU_MATERIAS)
          ->with('leer', Session::get('MATERIA_LEER'))
          ->with('editar', Session::get('MATERIA_EDITAR'))
          ->with('imprimir', Session::get('MATERIA_IMPRIMIR'))
          ->with('eliminar', Session::get('MATERIA_ELIMINAR'));
    }

    public function getInformeauditoriamateria()/*PDF*/
    {
        $materias = Materia::all();

        $pdf = PDF::loadView('informes.pdf.materiaauditoria', ['materias'=>$materias]);
        return $pdf->setOrientation('landscape')->stream();

    }

    public function postBorrar()
    {
        $id = Input::get('idMateriaHidden');
        $materia = Materia::find($id);

        if ($materia->correlatividades) {
            Session::flash('message', 'NO SE PUDO ELIMINAR LA MATERIA, ESTA RELACIONADA A UNA CORRELATIVIDAD');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('materias/listado');
        }

        if ($materia->correlatividadescursadas) {
            Session::flash('message', 'NO SE PUDO ELIMINAR LA MATERIA, ESTA RELACIONADA A UNA CORRELATIVIDAD');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('materias/listado');
        }
        
        if ($materia->correlatividadesaprobadas) {
            Session::flash('message', 'NO SE PUDO ELIMINAR LA MATERIA, ESTA RELACIONADA A UNA CORRELATIVIDAD');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('materias/listado');
        }
        
        if ($materia->delete()) {
            Session::flash('message', 'LA MATERIA <b>' . $materia->nombremateria . '</b> SE HA ELIMINADO.');
            Session::flash('message_type', self::OPERACION_EXITOSA);
            return Redirect::to('materias/listado');
        } else {
            Session::flash('message', 'HUBO ALGUN PROBLEMA AL INTENTAR ELIMINAR LA MATERIA');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('materias/listado');
        }        
    }

}

