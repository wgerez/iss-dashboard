<?php
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CiclolectivoController extends BaseController {

    private $_data;
    private $_rules;
    private $_messages;

    const OPERACION_EXITOSA = 1;
    const OPERACION_FALLIDA = 2;
    const OPERACION_CANCELADA = 3;
    const OPERACION_INFO = 4;
    const NO_EXISTE_CICLO = 5;

    public function getIndex()
    {
        return Redirect::to('ciclolectivo/listado');
    }

    public function getListado()
    {
        $ciclos = CicloLectivo::with('Organizacion')->get();

        return View::make('ciclolectivo.listado')
            ->with('ciclos', $ciclos)
            ->with('menu', ModulosHelper::MENU_GESTION_ADMINISTRATIVA)
            ->with('submenu', ModulosHelper::SUBMENU_CALENDARIOS)
            ->with('submenu2', ModulosHelper::SUBMENU_2_CICLOS)
            ->with('leer', Session::get('CALENDARIO_LEER'))
            ->with('editar', Session::get('CALENDARIO_EDITAR'))
            ->with('imprimir', Session::get('CALENDARIO_IMPRIMIR'))
            ->with('eliminar', Session::get('CALENDARIO_ELIMINAR'));
    }

    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function postShow()
    {
        $id = Input::get('id');
        $ciclo = CicloLectivo::with('Organizacion')
            ->with('periodosLectivos')
            ->find($id);

        return Response::json($ciclo);
    }

    /**
     * Verifica si es que existe algun ciclo lectivo activo.
     * ajax
     *
     * @return boolean
     */
    public function postVerificaexistecicloactivo()
    {
        $organizacion_id = Input::get('organizacion_id');
        $ciclo_activo = CicloLectivo::verificaExisteCicloActivo($organizacion_id);

        $existe = ($ciclo_activo) ? TRUE : FALSE;

        return Response::json($existe);
    }

    public function postObtenercicloslectivos()
    {
        $id = Input::get('organizacion_id');
        $ciclos = CicloLectivo::where('organizacion_id', '=', $id)->get();

        if (count($ciclos) == 0) {
            $ciclos = self::NO_EXISTE_CICLO;
        }

        return Response::json($ciclos);

    }
    
    public function getCrear()
    {
        $arrOrganizaciones = Organizacion::lists('nombre', 'id');


        array_unshift($arrOrganizaciones, 'Seleccionar');

        return View::make('ciclolectivo.nuevo')
            ->with('arrOrganizaciones', $arrOrganizaciones)
            ->with('menu', ModulosHelper::MENU_GESTION_ADMINISTRATIVA)
            ->with('submenu', ModulosHelper::SUBMENU_CALENDARIOS)
            ->with('submenu2', ModulosHelper::SUBMENU_2_CICLOS);
    }

    //En el caso de usar angular esta sería la forma correcta de devolver los datos
    /*public function getOrganizaciones()
    {
        $arrOrganizaciones = Organizacion::get(array('id', 'nombre'));
        return Response::json(array(
            "organizaciones"    =>  $arrOrganizaciones
        ));
    }*/

    public function postGuardar()
    {
        $this->_setAttributesValidation();

        $validator = Validator::make($this->_data, $this->_rules, $this->_messages);

        /*$arrPeriodos = new ArrayObject;

        if (Input::get('periodos')) {
            $periodos    = Input::get('periodos');
            $arrPeriodos = ArrayHelper::obtenerPeriodosSeparados($periodos);
        }*/

        //highlight_string(var_export(Input::get('periodos'),true));
        //exit;

        if ($validator->fails()) {
            Session::flash('message', 'ERROR AL INTENTAR CREAR UN CICLO.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            //Session::flash('periodos', $arrPeriodos);
            return Redirect::to('ciclolectivo/crear')
                ->withErrors($validator)
                ->withInput();
        } else {
            //$organizacion       = Input::get('organizacion');
            //$ciclolectivo       = Input::get('cicloLectivo');
            $activo = (Input::get('cicloactivo')) ? 1 : 0;

            /*
             * Si este ciclo sera activo, entonces tengo que verificar
             * que no existya otro activo.
             * En caso de que exista otro ciclo como activo, entonces debo setear
             * su valor a cero (0), es decir dejarlo como no activo.
             */
            if ($activo) {
                $existe = CicloLectivo::verificaExisteCicloActivo(Input::get('organizacion'));
                if ($existe) {
                    $ciclos_activos = CicloLectivo::getCicloActivo(Input::get('organizacion'));
                    foreach ($ciclos_activos as $ciclo_activo) {
                        $ciclo_activo->activo = 0;
                        $ciclo_activo->save();
                    }
                }
            }

            $ciclofechainicio = FechaHelper::getFechaParaGuardar(Input::get('cicloFechaInicio'));
            $ciclofechafin    = FechaHelper::getFechaParaGuardar(Input::get('cicloFechaFin'));

            $ciclo = new CicloLectivo;
                $ciclo->organizacion_id = Input::get('organizacion');
                $ciclo->descripcion     = Input::get('cicloLectivo');
                $ciclo->fechainicio     = $ciclofechainicio;
                $ciclo->fechafin        = $ciclofechafin;
                $ciclo->activo          = $activo;
                $ciclo->usuario_alta    = Auth::user()->usuario;
                $ciclo->fecha_alta      = date('Y-m-d');              
            $ciclo->save();

            /*foreach ($arrPeriodos as $periodo) {
                $periodoLectivo = new PeriodoLectivo(array(
                    'ciclolectivo_id' => $ciclo->id, 
                    'descripcion'     => $periodo['periodo'], 
                    'fechainicio'     => FechaHelper::getFechaParaGuardar($periodo['fechaini']), 
                    'fechafin'        => FechaHelper::getFechaParaGuardar($periodo['fechafin']),
                    'usuario_alta'    => 'FIJO-CiclolectivoController. Store-alta',
                    'fecha_alta'      => date('Y-m-d')
                ));
                $periodoLectivo->save();
            }*/

            Session::flash('message', 'CICLO CREADO CON ÉXITO!');
            Session::flash('message_type', self::OPERACION_EXITOSA);
            return Redirect::to('ciclolectivo/editar/' . $ciclo->id);            
        }
    }

    public function getEditar($id)
    {
        $ciclo = CicloLectivo::findOrFail($id);

        $arrOrganizaciones = Organizacion::lists('nombre', 'id');

        $periodos = $ciclo->periodoslectivos;

        return View::make('ciclolectivo.edit')
            ->with('arrOrganizaciones', $arrOrganizaciones)
            ->with('ciclo', $ciclo)
            ->with('periodos', $periodos)
            ->with('menu', ModulosHelper::MENU_GESTION_ADMINISTRATIVA)
            ->with('submenu', ModulosHelper::SUBMENU_CALENDARIOS)
            ->with('submenu2', ModulosHelper::SUBMENU_2_CICLOS)
            ->with('leer', Session::get('CALENDARIO_LEER'))
            ->with('editar', Session::get('CALENDARIO_EDITAR'))
            ->with('imprimir', Session::get('CALENDARIO_IMPRIMIR'))
            ->with('eliminar', Session::get('CALENDARIO_ELIMINAR'));
    }

    public function postUpdate()
    {
        /* REFACTORIZAR */

        $this->_setAttributesValidation();

        $id = Input::get('txtCicloId');

        $validator = Validator::make($this->_data, $this->_rules, $this->_messages);

        /*$arrPeriodos = new ArrayObject;

        if (Input::get('periodos')) {
            $periodos    = Input::get('periodos');
            $arrPeriodos = ArrayHelper::obtenerPeriodosSeparados($periodos);
        }*/

        //highlight_string(var_export(Input::get('periodos'),true));
        //exit;

        if ($validator->fails()) {
            Session::flash('message', 'ERROR AL INTENTAR EDITAR UN CICLO.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            //Session::flash('periodos', $arrPeriodos);
            return Redirect::to('ciclolectivo/editar/' . $id)
                ->withErrors($validator)
                ->withInput();
        } else {

            $ciclo = CicloLectivo::find($id);

            //$organizacion       = Input::get('organizacion');
            //$ciclolectivo       = Input::get('cicloLectivo');

            $activo = (Input::get('cicloactivo')) ? 1 : 0;

            /*
             * Si este ciclo sera activo, entonces tengo que verificar
             * que no existya otro activo.
             * En caso de que exista otro ciclo como activo, entonces debo setear
             * su valor a cero (0), es decir dejarlo como no activo.
             */
            if ($activo) {
                $existe = CicloLectivo::verificaExisteCicloActivo(Input::get('organizacion'));
                if ($existe) {
                    $ciclos_activos = CicloLectivo::getCicloActivo(Input::get('organizacion'));
                    foreach ($ciclos_activos as $ciclo_activo) {
                        if ($ciclo->id == $ciclo_activo->id) continue;
                        $ciclo_activo->activo = 0;
                        $ciclo_activo->save();
                    }
                }
            }

            $ciclofechainicio   = FechaHelper::getFechaParaGuardar(Input::get('cicloFechaInicio'));
            $ciclofechafin      = FechaHelper::getFechaParaGuardar(Input::get('cicloFechaFin'));

                $ciclo->organizacion_id = Input::get('organizacion');
                $ciclo->descripcion     = Input::get('cicloLectivo');
                $ciclo->fechainicio     = $ciclofechainicio;
                $ciclo->fechafin        = $ciclofechafin;
                $ciclo->activo          = $activo;
                $ciclo->usuario_modi    = Auth::user()->usuario;
                $ciclo->fecha_modi      = date('Y-m-d');
                //$ciclo->usuario_alta    = 'FIJO-CiclolectivoController. Store-alta';
                //$ciclo->fecha_alta      = date('Y-m-d');
            $ciclo->save();

            /*$ciclo->periodoslectivos()->delete();

            foreach ($arrPeriodos as $periodo) {

                if (strrpos($periodo['fechaini'], '/')) {
                    $fecha_inicio = FechaHelper::getFechaParaGuardar($periodo['fechaini']);
                } else {
                    $fecha_inicio = $periodo['fechaini'];
                }
                if (strrpos($periodo['fechafin'], '/')) {
                    $fecha_fin = FechaHelper::getFechaParaGuardar($periodo['fechafin']);
                } else {
                    $fecha_fin = $periodo['fechafin'];
                }

                $periodoLectivo = new PeriodoLectivo(array(
                    'ciclolectivo_id' => $ciclo->id,
                    'descripcion'     => $periodo['periodo'],
                    'fechainicio'     => $fecha_inicio,
                    'fechafin'        => $fecha_fin,
                    'usuario_alta'    => 'FIJO-CiclolectivoController. Store-alta',
                    'fecha_alta'      => date('Y-m-d')
                ));
                $periodoLectivo->save();
            }*/

            Session::flash('message', 'EL CICLO HA SIDO MODIFICADO CON ÉXITO!');
            Session::flash('message_type', self::OPERACION_EXITOSA);
            return Redirect::to('ciclolectivo/editar/' . $id);            
        }
    }

    public function postGuardarperiodo()
    {
        $id = Input::get('ciclo_lectivo_id');
        $descripcion = Input::get('descripcion');
        $fecha_inicio = Input::get('fecha_inicio');
        $fecha_fin = Input::get('fecha_fin');

        $fecha_inicio = FechaHelper::getFechaParaGuardar($fecha_inicio);
        $fecha_fin = FechaHelper::getFechaParaGuardar($fecha_fin);

        $periodo = new PeriodoLectivo;
          $periodo->ciclolectivo_id = $id;
          $periodo->descripcion     = $descripcion;
          $periodo->fechainicio     = $fecha_inicio;
          $periodo->fechafin        = $fecha_fin;
          $periodo->usuario_alta    = Auth::user()->usuario;
          $periodo->fecha_alta      = date('Y-m-d');
        $periodo->save();

        return Response::json($periodo);
    }

    public function postEditarperiodo()
    {
        $id = Input::get('periodo_lectivo_id');
        $descripcion = Input::get('descripcion');
        $fecha_inicio = Input::get('fecha_inicio');
        $fecha_fin = Input::get('fecha_fin');

        $fecha_inicio = FechaHelper::getFechaParaGuardar($fecha_inicio);
        $fecha_fin = FechaHelper::getFechaParaGuardar($fecha_fin);

        $periodo = PeriodoLectivo::find($id);
          $periodo->descripcion = $descripcion;
          $periodo->fechainicio = $fecha_inicio;
          $periodo->fechafin    = $fecha_fin;
        $periodo->save();

        //return Response::json($periodo);
    }

    public function postBorrarperiodo()
    {
        $id = Input::get('periodo_lectivo_id');
        $periodo = PeriodoLectivo::find($id);

        if ($this->_noSePuedeBorrarPeriodo($periodo)) {
            $respuesta = [
                'mensaje' => 'NO ES POSIBLE BORRAR EL PERIODO LECTIVO.',
                'tipo_mensaje' => self::OPERACION_FALLIDA
            ];
        } else {

            try
            {
                $periodo->delete();
                $respuesta = [
                    'mensaje' => 'PERIODO LECTIVO BORRADO.',
                    'tipo_mensaje' => self::OPERACION_EXITOSA
                ];
            }
            catch(Exception $ex)
            {
                $respuesta = [
                    'mensaje' => 'NO SE PUEDE BORRAR EL PERIODO LECTIVO.',
                    'tipo_mensaje' => self::OPERACION_FALLIDA
                ];
            }
        }

        return Response::json($respuesta);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function postBorrar()
    {
        $id = Input::get('txtIdCicloHidden');

        $ciclo = CicloLectivo::find($id);

        Session::flash('message', 'NO ES POSIBLE BORRAR EL CICLO LECTIVO.');
        Session::flash('message_type', self::OPERACION_FALLIDA);
        return Redirect::to('ciclolectivo/listado');
        /*
        if ($this->_noSePuedeBorrar($ciclo)) {
            Session::flash('message', 'NO ES POSIBLE BORRAR EL CICLO LECTIVO.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('ciclolectivo/listado');
        }

        //highlight_string(var_export($ciclo,true));
        //exit;

        $ciclo->periodoslectivos()->delete();
        $ciclo->delete();

        Session::flash('message', 'EL CICLO LECTIVO HA SIDO BORRADO DE LA BASE DE DATOS.');
        Session::flash('message_type', self::OPERACION_EXITOSA);
        return Redirect::to('ciclolectivo/listado');
        */
    }

    /**
     * Validacion para el borrado del Periodo Lectivo
     *
     * @param  PeriodoLectivo  $periodo
     * @return Boolean
     */
    private function _noSePuedeBorrarPeriodo(PeriodoLectivo $periodo)
    {
        return FALSE;
    }

    /**
     * Validacion para el borrado del Ciclo Lectivo
     *
     * @param  CicloLectivo  $ciclo
     * @return Boolean
     */
    private function _noSePuedeBorrar(CicloLectivo $ciclo)
    {
        return FALSE;
    }

    private function _setAttributesValidation()
    {
        $this->_data = array(
            'ciclolectivo'     => Input::get('cicloLectivo'),
            'ciclofechainicio' => Input::get('cicloFechaInicio'),
            'ciclofechafin'    => Input::get('cicloFechaFin')
        );

        $this->_rules = array(
            'ciclolectivo'     => 'required',
            'ciclofechainicio' => 'required|fechamenos:'.Input::get('cicloFechaFin'),
            'ciclofechafin'    => 'required'
        );

        $this->_messages = array(
            'required' => 'Campo Obligatorio',
            'fechamenos' => 'La fecha de inicio debe ser menor'
        );
    }
}

//PARA MANEJAR LOS ERRORES DE findOrFail
App::error(function(ModelNotFoundException $e)
{
    return Response::view('errors.404Ciclos', array(), 404); 
});