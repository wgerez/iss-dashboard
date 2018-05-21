<?php
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CarrerasController extends BaseController {

    private $_data;
    private $_rules;
    private $_messages;

    const OPERACION_EXITOSA = 1;
    const OPERACION_FALLIDA = 2;
    const OPERACION_CANCELADA = 3;
    const OPERACION_INFO = 4;

    public function getIndex()
    {
        return Redirect::to('carreras/listado');
    }
    
    public function getListado()
    {
        $organizaciones = Organizacion::lists('nombre', 'id');

        array_unshift($organizaciones, 'Seleccionar');

        return View::make('carreras.listado',[            
            'carreras'          => Carrera::get(array('id', 'carrera', 'tipoduracion_id', 'duracion', 'carreranivel_id', 'modalidad_id', 'tipocarrera_id', 'activa')),
            'tiposCarreras'     => TipoCarrera::lists('descripcion', 'id'),
            'arrOrganizaciones' => $organizaciones
        ])->with('menu', ModulosHelper::MENU_GESTION_ADMINISTRATIVA)
          ->with('submenu', ModulosHelper::SUBMENU_CARRERAS)
          ->with('leer', Session::get('CARRERA_LEER'))
          ->with('editar', Session::get('CARRERA_EDITAR'))
          ->with('imprimir', Session::get('CARRERA_IMPRIMIR'))
          ->with('eliminar', Session::get('CARRERA_ELIMINAR'));
    }

    /**
     * Formulario de nueva carrera
     */
    public function getCrear()
    {
        $organizaciones = Organizacion::lists('nombre', 'id');

        array_unshift($organizaciones, 'Seleccionar');

    	return View::make('carreras.nuevo',[
            'arrOrganizaciones'  => $organizaciones,
            'arrNivelEducativo'  => CarreraNivel::lists('descripcion', 'id'),
            'tiposCarreras'      => TipoCarrera::lists('descripcion', 'id'),
            'regimenes'          => Regimen::lists('descripcion', 'id'),
            'areasOcupacionales' => AreaOcupacional::lists('descripcion', 'id'),
            'modalidades'        => Modalidad::lists('descripcion', 'id'),
            'tiposDuraciones'    => TipoDuracion::lists('descripcion', 'id'),            
            'titulosOtorgados'   => TituloOtorgado::lists('descripcion', 'id')
        ])->with('menu', ModulosHelper::MENU_GESTION_ADMINISTRATIVA)
          ->with('submenu', ModulosHelper::SUBMENU_CARRERAS);
    }

    public function postGuardar()
    {   

        $validator = Validator::make(
            array(
                'carrera' => Input::get('carrera'),
                'abreviatura' => Input::get('abreviatura')
            ),
            array(
                'carrera' => 'required',
                'abreviatura' => 'required'              
            ),
            array(
                'required' => 'Campo Obligatorio' 
            )
        );
        

        if ($validator->fails()) {
            Session::flash('message', 'ERROR AL INTENTAR CREAR UNA CARRERA.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('carreras/listado')
                ->withErrors($validator)
                ->withInput();
        } else {

        $carrera = new Carrera();

            $carrera->organizacion_id     = Input::get('organizacion');
            $carrera->carrera             = trim(Input::get('carrera'));
            $carrera->nroresolucion       = Input::get('nroresolucion');
            $carrera->abreviatura         = trim(Input::get('abreviatura'));
            $carrera->carreranivel_id     = Input::get('nivel');
            $carrera->tipocarrera_id      = Input::get('tipocarrera');
            $carrera->regimen_id          = Input::get('regimen');
            $carrera->titulootorgado_id   = Input::get('titulootorga');
            $carrera->tipoduracion_id     = Input::get('tipoduracion');
            $carrera->duracion            = Input::get('duracion');
            $carrera->modalidad_id        = Input::get('modalidad');
            $carrera->cargahorariacatedra = str_replace(array(',', '.'), "", Input::get('cargaHorariaCatedra'));
            $carrera->cargahorariareloj   = str_replace(array(',', '.'), "", Input::get('cargaHorariaReloj'));
            $carrera->areaocupacional_id  = Input::get('areaocupacional');
            $carrera->activa              = (Input::get('carreraactiva')) ? 1 : 0;
            $carrera->exameningreso       = (Input::get('exameningreso')) ? 1 : 0;
            $carrera->observaciones       = Input::get('observacion');
            $carrera->cargahorariareloj   = Input::get('cargaHorariaReloj');
            $carrera->usuario_alta        = Auth::user()->usuario;  
            $carrera->fecha_alta         = date('Y-m-d');
            
            $carrera->save();
            Session::flash('message', 'CARRERA CREADA CON ÉXITO!');
            Session::flash('message_type', self::OPERACION_EXITOSA);
            return Redirect::to('carreras/listado');
        }
    }

    /**
     * formulario para editar la Carrera
     * @param Carreraid
     */

    public function getEditar($id)
    {  

        return View::make('carreras.edit',[
            'arrOrganizaciones'  => Organizacion::lists('nombre', 'id'),
            'arrNivelEducativo'  => CarreraNivel::lists('descripcion', 'id'),
            'tiposCarreras'      => TipoCarrera::lists('descripcion', 'id'),
            'regimenes'          => Regimen::lists('descripcion', 'id'),
            'areasOcupacionales' => AreaOcupacional::lists('descripcion', 'id'),
            'titulosOtorgados'   => TituloOtorgado::lists('descripcion', 'id'),
            'modalidades'        => Modalidad::lists('descripcion', 'id'),
            'tiposDuraciones'    => TipoDuracion::lists('descripcion', 'id'),
            'carrera'            => Carrera::find($id)
        ])->with('menu', ModulosHelper::MENU_GESTION_ADMINISTRATIVA)
          ->with('submenu', ModulosHelper::SUBMENU_CARRERAS)
          ->with('leer', Session::get('CARRERA_LEER'))
          ->with('editar', Session::get('CARRERA_EDITAR'))
          ->with('imprimir', Session::get('CARRERA_IMPRIMIR'))
          ->with('eliminar', Session::get('CARRERA_ELIMINAR'));
    }

    public function postUpdate()
    {
        $id = Input::get('carreraid');

        $validator = Validator::make(
            array(
                'carrera' => Input::get('carrera'),
                'abreviatura' => Input::get('abreviatura')
            ),
            array(
                'carrera' => 'required',
                'abreviatura' => 'required'              
            ),
            array(
                'required' => 'Campo Obligatorio' 
            )
        );
        

        if ($validator->fails()) {
            Session::flash('message', 'ERROR AL INTENTAR CREAR UNA CARRERA.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('carreras/listado')
                ->withErrors($validator)
                ->withInput();
        } else {          
           
            $carrera = Carrera::find($id);            

            $carrera->organizacion_id     = Input::get('organizacion');
            $carrera->carrera             = trim(Input::get('carrera'));
            $carrera->nroresolucion       = Input::get('nroresolucion');
            $carrera->abreviatura         = trim(Input::get('abreviatura'));
            $carrera->carreranivel_id     = Input::get('nivel');
            $carrera->tipocarrera_id      = Input::get('tipocarrera');
            $carrera->regimen_id          = Input::get('regimen');
            $carrera->tipoduracion_id     = Input::get('tipoduracion');
            $carrera->titulootorgado_id   = Input::get('titulootorga');
            $carrera->duracion            = Input::get('duracion');
            $carrera->modalidad_id        = Input::get('modalidad');
            $carrera->cargahorariacatedra = str_replace(array(',', '.'), "", Input::get('cargaHorariaCatedra'));
            $carrera->cargahorariareloj   = str_replace(array(',', '.'), "", Input::get('cargaHorariaReloj'));
            $carrera->areaocupacional_id  = Input::get('areaocupacional');
            $carrera->activa              = (Input::get('carreraactiva')) ? 1 : 0;
            $carrera->exameningreso       = (Input::get('exameningreso')) ? 1 : 0;
            $carrera->observaciones       = Input::get('observacion');
            $carrera->usuario_modi        = Auth::user()->usuario;
            $carrera->fecha_modi         = date('Y-m-d');

            $carrera->save();
        }

        Session::flash('message', 'LA EDICIÓN SE HA REALIZADO CON ÉXITO.');
        Session::flash('message_type', self::OPERACION_EXITOSA);
        return Redirect::to('carreras/listado');
    }

    public function postBorrar()
    {
        $id = Input::get('idCarreraHidden');
        $carrera = Carrera::find($id);

        Session::flash('message', 'POR EL MOMENTO NO SE PUEDE BORRAR ESTA CARRERA.');
        Session::flash('message_type', self::OPERACION_FALLIDA);
        return Redirect::to('carreras/listado');
        /*
        $carrera->delete();

        Session::flash('message', 'LA CARRERA HA SIDO BORRADO DE LA BASE DE DATOS.');
        Session::flash('message_type', self::OPERACION_EXITOSA);
        return Redirect::to('carreras/listado');
        */

    }

    public function postBuscar()
    {
        $idTipoCarrera = (int)Input::get('tipocarrera');
        $idOrganizacion = (int)Input::get('organizacion');


        $result = Carrera::where('organizacion_id','=', $idOrganizacion)
                    ->where('tipocarrera_id', '=', $idTipoCarrera)
                    ->get();

        //highlight_string(var_export($result,true));
        //exit;

        return View::make('carreras.listado',[            
            'carreras'          => $result,
            'tiposCarreras'     => TipoCarrera::lists('descripcion', 'id'),
            'arrOrganizaciones' => Organizacion::lists('nombre', 'id'),
            'idOrg'             => $idOrganizacion,
            'idTCarrera'        => $idTipoCarrera
        ])
        ->with('menu', ModulosHelper::MENU_GESTION_ADMINISTRATIVA)
        ->with('submenu', ModulosHelper::SUBMENU_CARRERAS)
        ->with('leer', Session::get('CARRERA_LEER'))
        ->with('editar', Session::get('CARRERA_EDITAR'))
        ->with('imprimir', Session::get('CARRERA_IMPRIMIR'))
        ->with('eliminar', Session::get('CARRERA_ELIMINAR'));
    }

    public function postBuscarjson()
    {
        $idOrganizacion = (int)Input::get('organizacionid');


        $result = Carrera::where('organizacion_id','=', $idOrganizacion)
                    //->where('tipocarrera_id', '=', 2)
                    //->select('id', 'carrera')
                    ->get();

        //highlight_string(var_export($result,true));
        //exit;

        return Response::json($result);
    }
    
    public function postShow()
    {
        $id = Input::get('id');
        $carrera = Carrera::with('CarreraNivel')
            ->with('TipoCarrera')
            ->with('TipoDuracion')
            ->with('Regimen')
            ->find($id);            

        return Response::json($carrera);
    }

    public static function ObtenerCarrerasParaSelect($id) {

        $carreras = Carrera::where('organizacion_id', '=', $id)->lists('carrera', 'id');
        

        return $carreras;        
    }    
}

//PARA MANEJAR LOS ERRORES DE findOrFail
App::error(function(ModelNotFoundException $e)
{
    return Response::view('errors.404', array(), 404);
});
