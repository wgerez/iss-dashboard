<?php

class OrganizacionsController extends BaseController {

    private $_data;
    private $_rules;
    private $_messages;

    const OPERACION_EXITOSA = 1;
    const OPERACION_FALLIDA = 2;
    const OPERACION_CANCELADA = 3;
    const OPERACION_INFO = 4;
    const NO_TIENE_CARRERAS = 5;
    const NO_TIENE_CARRERAS_CON_MATRICULA_ASOCIADA = 6;
    const NO_EXISTE_CICLO_ACTIVO = 7;

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    public function getIndex()
    {
        return Redirect::to('organizacions/listado');
    }

	public function getListado()
	{
        //$organizaciones = Organizacion::with('nivelEducativo')->get();
        $organizaciones = Organizacion::get(
            array('id', 'nombre', 'nivel_educativo_id')
        );

        //highlight_string(var_export($organizaciones,true));
        //exit;

        return View::make('organizacions.listado')
            ->with('organizaciones', $organizaciones)
            ->with('menu', ModulosHelper::MENU_GESTION_ADMINISTRATIVA)
            ->with('submenu', ModulosHelper::SUBMENU_ORGANIZACIONES)
            ->with('leer', Session::get('ORGANIZACION_LEER'))
            ->with('editar', Session::get('ORGANIZACION_EDITAR'))
            ->with('imprimir', Session::get('ORGANIZACION_IMPRIMIR'))
            ->with('eliminar', Session::get('ORGANIZACION_ELIMINAR'));
	}

    /**
     * Obtiene todos los datos necesarios
     * en forma de arrays, que se necesitaran para
     * dar de alta a la organizacion.
     *
     * @return Response
     */
	public function getCrear()
	{
        $arrNivelEducativo = NivelEducativo::lists('descripcion', 'id');
        $arrPais = Pais::lists('descripcion', 'id');
        $arrProvincia = Provincia::lists('descripcion', 'id');
        $arrDepartamento = Departamento::lists('descripcion', 'id');
        $arrLocalidad = Localidad::lists('descripcion', 'id');
        $arrBarrio = Barrio::lists('descripcion', 'id');
        $arrContacto = Contacto::lists('descripcion', 'id');

        //$arrPais1 = Pais::get(array('id','descripcion'))->toArray();

		return View::make('organizacions.nuevo')
            ->with('arrNivelEducativo', $arrNivelEducativo)
            ->with('arrPais', $arrPais)
            ->with('arrProvincia', $arrProvincia)
            ->with('arrDepartamento', $arrDepartamento)
            ->with('arrLocalidad', $arrLocalidad)
            ->with('arrBarrio', $arrBarrio)
            ->with('arrContacto', $arrContacto)
            ->with('menu', ModulosHelper::MENU_GESTION_ADMINISTRATIVA)
            ->with('submenu', ModulosHelper::SUBMENU_ORGANIZACIONES);
	}

    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function postShow()
    {
        $id = Input::get('id');
        $organizacion = Organizacion::with('localidad')
            ->find($id);

        return Response::json($organizacion);
    }

    public function postObtenercarreras()
    {
        $id = Input::get('organizacion_id');
        $carreras = Carrera::where('organizacion_id', '=', $id)->get();
        
        if (count($carreras) == 0)
            return self::NO_TIENE_CARRERAS;

        return Response::json($carreras);
    }

    public function postObtenercarrerasconmatricula()
    {
        $id = Input::get('organizacion_id');
        $carreras = Carrera::whereRaw('organizacion_id=' . $id . ' and activa=1')
            ->get();

        $cantidad_carreras = count($carreras);
        
        if ($cantidad_carreras == 0)
            return self::NO_TIENE_CARRERAS;

        for ($i = 0; $i < $cantidad_carreras; $i++) {
            $matricula = Matricula::where(
                'carrera_id', '=', $carreras[$i]->id)->get();

            if (count($matricula) == 0)
                unset($carreras[$i]);
        }

        $cantidad_carreras_con_matricula = count($carreras);

        if ($cantidad_carreras_con_matricula == 0)
            return self::NO_TIENE_CARRERAS_CON_MATRICULA_ASOCIADA;

        return Response::json($carreras);
    }

    public function postObtenercarrerasconmatriculaporciclo()
    {
        $id = Input::get('organizacion_id');
        $ciclo = Input::get('ciclo');
        $carreras = Carrera::whereRaw('organizacion_id=' . $id . ' and activa=1')
            ->get();

        $cantidad_carreras = count($carreras);
        
        if ($cantidad_carreras == 0)
            return self::NO_TIENE_CARRERAS;

        for ($i = 0; $i < $cantidad_carreras; $i++) {
            $matricula = Matricula::whereRaw(
                'carrera_id = ' . $carreras[$i]->id .
                ' and ciclolectivo_id = ' . $ciclo
                )->get();

            if (count($matricula) == 0)
                unset($carreras[$i]);
        }

        $cantidad_carreras_con_matricula = count($carreras);

        if ($cantidad_carreras_con_matricula == 0)
            return self::NO_TIENE_CARRERAS_CON_MATRICULA_ASOCIADA;

        return Response::json($carreras);
    }

	public function postGuardar()
	{
		$this->_setAttributesValidation();

        $validator = Validator::make($this->_data, $this->_rules, $this->_messages);

        if ($validator->fails()) {
            Session::flash('message', 'ERROR AL INTENTAR CREAR UNA ORGANIZACIÓN.');
	        Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('organizacions/crear')
                ->withErrors($validator)
                ->withInput();
        } else {

            $contactos = Input::get('contactos');
            $arrContactos = ArrayHelper::obtenerContactosSeparados($contactos);

            $organizacion = new Organizacion;
                $organizacion->nombre          = Input::get('nombre');
                $organizacion->razon_social    = Input::get('razon');
                $organizacion->cuit            = Input::get('cuit');
                $organizacion->nivel_educativo_id = Input::get('nivel');
                $organizacion->habilitar_sedes = (Input::get('habilitarsedes') == 'on') ? 1 : 0;
                $organizacion->pais_id         = Input::get('pais');
                $organizacion->provincia_id    = Input::get('provincia');
                $organizacion->departamento_id = Input::get('departamento');
                $organizacion->localidad_id    = Input::get('localidad');
                //$organizacion->barrio_id          = Input::get('barrio');
                $organizacion->barrio_id       = 39;
                $organizacion->barrio          = Input::get('txt_barrio');
                $organizacion->calle           = Input::get('calle');
                $organizacion->numero          = Input::get('numerocalle');
                $organizacion->manzana         = Input::get('manzana');
                $organizacion->piso            = Input::get('piso');
                $organizacion->departamento    = Input::get('domiciliodepartamento');
                $organizacion->codigo_postal   = Input::get('codigopostal');
                $organizacion->usuario_alta    = Auth::user()->usuario;
                $organizacion->fecha_alta      = date('Y-m-d');
            $organizacion->save();

            // se graban los contactos
            foreach ($arrContactos as $contacto) {
                $organizacion->contactos()->attach(
                    $contacto['tipo'],
                    array('descripcion'=>$contacto['valor'])
                );
            }

            Session::flash('message', 'ORGANIZACIÓN CREADA CON ÉXITO!');
	        Session::flash('message_type', self::OPERACION_EXITOSA);
            return Redirect::to('organizacions/listado');
        }
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getEditar($id)
	{

        $arrNivelEducativo = NivelEducativo::lists('descripcion', 'id');
        $arrPais = Pais::lists('descripcion', 'id');
        $arrProvincia = Provincia::lists('descripcion', 'id');
        $arrDepartamento = Departamento::lists('descripcion', 'id');
        $arrLocalidad = Localidad::lists('descripcion', 'id');
        $arrBarrio = Barrio::lists('descripcion', 'id');
        $arrTipoContacto = Contacto::lists('descripcion', 'id');

        $organizacion = Organizacion::find($id);

        $arrContactos = new ArrayObject;

        /* Obtengo los contactos */

        //$arrTmp = $organizacion->contactos()->get()->toArray();
        //highlight_string($organizacion->contactos);
        //exit;
        //$organizacion->contactos->pivot->get();

        foreach ($organizacion->contactos as $contacto) {
            $arrContactos->offsetSet($contacto->descripcion, $contacto->pivot);
        }

        return View::make('organizacions.edit')
            ->with('organizacion', $organizacion)
            ->with('arrNivelEducativo', $arrNivelEducativo)
            ->with('arrPais', $arrPais)
            ->with('arrProvincia', $arrProvincia)
            ->with('arrDepartamento', $arrDepartamento)
            ->with('arrLocalidad', $arrLocalidad)
            ->with('arrBarrio', $arrBarrio)
            ->with('arrContactos', $arrContactos)
            ->with('arrTipoContacto', $arrTipoContacto)
            ->with('menu', ModulosHelper::MENU_GESTION_ADMINISTRATIVA)
            ->with('submenu', ModulosHelper::SUBMENU_ORGANIZACIONES)
            ->with('leer', Session::get('ORGANIZACION_LEER'))
            ->with('editar', Session::get('ORGANIZACION_EDITAR'))
            ->with('imprimir', Session::get('ORGANIZACION_IMPRIMIR'))
            ->with('eliminar', Session::get('ORGANIZACION_ELIMINAR'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function postUpdate()
	{

		$this->_setAttributesValidationEdit();

        $id = Input::get('txtOrganizacionId');

        $validator = Validator::make($this->_data, $this->_rules, $this->_messages);

        if ($validator->fails()) {
            Session::flash('message', 'ERROR AL INTENTAR MODIFICAR LOS DATOS DE LA ORGANIZACIÓN.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('organizacions/editar/' . $id)
                ->withErrors($validator)
                ->withInput();
        } else {

            $contactos = Input::get('contactos');
            $arrContactos = ArrayHelper::obtenerContactosSeparados($contactos);

            $organizacion = Organizacion::find($id);

            if (empty($organizacion)) {
                Session::flash('message', 'LA ORGANIZACIÓN NO EXISTE EN LA BASE DE DATOS.');
                Session::flash('message_type', self::OPERACION_CANCELADA);
                return Redirect::to('organizacions/listado');
            }

                $organizacion->nombre          = Input::get('nombre');
                $organizacion->razon_social    = Input::get('razon');
                $organizacion->cuit            = Input::get('cuit');
                $organizacion->nivel_educativo_id = Input::get('nivel');
                $organizacion->habilitar_sedes = (Input::get('habilitarsedes') == 'on') ? 1 : 0;
                $organizacion->pais_id         = Input::get('pais');
                $organizacion->provincia_id    = Input::get('provincia');
                $organizacion->departamento_id = Input::get('departamento');
                $organizacion->localidad_id    = Input::get('localidad');
                //$organizacion->barrio_id          = Input::get('barrio');
                $organizacion->barrio_id       = 39;
                $organizacion->barrio          = Input::get('txt_barrio');
                $organizacion->calle           = Input::get('calle');
                $organizacion->numero          = Input::get('numerocalle');
                $organizacion->manzana         = Input::get('manzana');
                $organizacion->piso            = Input::get('piso');
                $organizacion->departamento    = Input::get('domiciliodepartamento');
                $organizacion->codigo_postal   = Input::get('codigopostal');
                $organizacion->usuario_modi    = Auth::user()->usuario;
                $organizacion->fecha_modi      = date('Y-m-d');
            $organizacion->save();

            /*
             * Con detach() se borran todos los contactos relacionados.
             * Con attach() se relacionan los nuevos
             * No es lo optimo, ya que para agregar o modificar contactos,
             * primero deben eliminarse los anteriores. Es decir que siempre
             * se esta haciendo altas de contactos.
             *
             * Arreglo temporal.
             */
            $organizacion->contactos()->detach();

            foreach ($arrContactos as $contacto) {
                $organizacion->contactos()->attach(
                    $contacto['tipo'],
                    array('descripcion'=>$contacto['valor'])
                );
            }

            Session::flash('message', 'LA EDICIÓN SE HA REALIZADO CON ÉXITO.');
            Session::flash('message_type', self::OPERACION_EXITOSA);
            return Redirect::to('organizacions/listado');
        }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function postBorrar()
	{
		$id = Input::get('txtIdOrganizacionHidden');

        $organizacion = Organizacion::find($id);

        Session::flash('message', 'NO ES POSIBLE BORRAR LA ORGANIZACIÓN.');
        Session::flash('message_type', self::OPERACION_FALLIDA);
        return Redirect::to('organizacions/listado');
        /*
        if ($this->_noSePuedeBorrar($organizacion)) {
	        Session::flash('message', 'NO ES POSIBLE BORRAR LA ORGANIZACIÓN.');
	        Session::flash('message_type', self::OPERACION_FALLIDA);
	        return Redirect::to('organizacions/listado');
        }

        //highlight_string(var_export($organizacion,true));
        //exit;

        // detach elimina relacion organizacion-contacto
        $organizacion->contactos()->detach();
        $organizacion->delete();

        Session::flash('message', 'LA ORGANIZACIÓN HA SIDO BORRADA DE LA BASE DE DATOS.');
        Session::flash('message_type', self::OPERACION_EXITOSA);
        return Redirect::to('organizacions/listado');
        */
	}

    /* REFACTORING LO QUE SE ENVIA POR JSON */
    public function postObtenercicloactivo()
    {
        $organizacion_id = Input::get('organizacion_id');
        $existe = CicloLectivo::verificaExisteCicloActivo($organizacion_id);

        if (!$existe)
            return Response::json(self::NO_EXISTE_CICLO_ACTIVO);

        $ciclo_lectivo_activo = CicloLectivo::getCicloActivo($organizacion_id);

        return Response::json($ciclo_lectivo_activo[0]);
    }

	/**
	 * Validacion para el borrado de una Organizacion
	 *
	 * @param  Organizacion  $organizacion
	 * @return Boolean
	 */
	private function _noSePuedeBorrar(Organizacion $organizacion)
	{
		// El sistema verifica que la Organización no tiene Alumnos,
		// ni Docentes ni Empleados asociados
		return FALSE;
	}

	/**
	 * Setea los valores a validar y las reglas a usar
	 */
	private function _setAttributesValidation()
	{
		$this->_data = array(
	        'nombre'       => Input::get('nombre'),
	        'razonSocial'  => Input::get('razon'),
            'cuit'  => Input::get('cuit'),
	        'codigoPostal' => Input::get('codigopostal')
		);

		$this->_rules = array(
	        'nombre'       => 'required|nombrerepetido',
	        'razonSocial'  => 'required',
            'cuit'         => 'required|cuitrepetido',
	        'codigoPostal' => 'required'
		);

		$this->_messages = array(
    		'required' => 'Campo Obligatorio',
            'cuitrepetido'=>'Ya exite una organizacion con este cuit',
            'nombrerepetido' => 'Esta organización ya se encuentra registrada.'
		);
	}
	private function _setAttributesValidationEdit()
	{
		$this->_data = array(
	        'nombre'       => Input::get('nombre'),
	        'razonSocial'  => Input::get('razon'),
            'cuit'  => Input::get('cuit'),
	        'codigoPostal' => Input::get('codigopostal')
		);

		$this->_rules = array(
	        'nombre'       => 'required',
	        'razonSocial'  => 'required',
            'cuit'         => 'required',
	        'codigoPostal' => 'required'
		);

		$this->_messages = array(
    		'required' => 'Campo Obligatorio',
		);
		
	}

}
