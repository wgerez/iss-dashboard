<?php
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AlumnosController extends BaseController {

    private $_data;
    private $_rules;
    private $_messages;

    const OPERACION_EXITOSA = 1;
    const OPERACION_FALLIDA = 2;
    const OPERACION_CANCELADA = 3;
    const OPERACION_INFO = 4;
    const NO_EXISTE_ALUMNO = 5;
    const IMG_PATH = 'alumnos/img-perfil/';
    const IMG_DOC_PATH = 'alumnos/documentos/';
    const IMG_PERFIL_WIDTH = 400;
    const IMG_WIDTH = 800;


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    public function getIndex()
    {
        return Redirect::to('alumnos/listado');
    }

	public function getListado()
	{

        $alumnos = Alumno::with('persona')->get();

		//$html = View::make('alumnos.listado',array('alumnos' => $alumnos));

         return View::make('alumnos.listado')
            ->with('alumnos', $alumnos)
            ->with('menu', ModulosHelper::MENU_GESTION_ACADEMICA)
            ->with('submenu', ModulosHelper::SUBMENU_ALUMNOS)
            ->with('leer', Session::get('ALUMNO_LEER'))
            ->with('editar', Session::get('ALUMNO_EDITAR'))
            ->with('imprimir', Session::get('ALUMNO_IMPRIMIR'))
            ->with('eliminar', Session::get('ALUMNO_ELIMINAR'));
		//return PDF::load($html, 'A4', 'portrait')->show();
	}

    /**
     * Obtiene todos los datos necesarios
     * en forma de arrays, que se necesitaran para
     * dar de alta a la persona.
     *
     * @return Response
     */
    public function getCrear()
    {
        $arrTipoDocumento = TipoDocumento::lists('descripcion', 'id');
        $arrEstadoCivil = EstadoCivil::lists('descripcion', 'id');
        $arrPais = Pais::lists('descripcion', 'id');
        $arrProvincia = Provincia::lists('descripcion', 'id');
        $arrDepartamento = Departamento::lists('descripcion', 'id');
        $arrLocalidad = Localidad::lists('descripcion', 'id');
        $arrBarrio = Barrio::lists('descripcion', 'id');
        $arrContacto = Contacto::lists('descripcion', 'id');

        return View::make('alumnos.nuevo')
            ->with('arrEstadoCivil', $arrEstadoCivil)
            ->with('arrTipoDocumento', $arrTipoDocumento)
            ->with('arrPais', $arrPais)
            ->with('arrProvincia', $arrProvincia)
            ->with('arrDepartamento', $arrDepartamento)
            ->with('arrLocalidad', $arrLocalidad)
            ->with('arrBarrio', $arrBarrio)
            ->with('arrContacto', $arrContacto)
            ->with('menu', ModulosHelper::MENU_GESTION_ACADEMICA)
            ->with('submenu', ModulosHelper::SUBMENU_ALUMNOS);
    }

    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function postShow()
    {
        $id = Input::get('id');
        $alumno = Alumno::with('persona')->find($id);

        return Response::json($alumno);
    }

    public function postGuardar()
    {

        $this->_setAttributesValidation();

        $validator = Validator::make($this->_data, $this->_rules, $this->_messages);


        $nrodoc = str_replace(".", "", trim(Input::get('documento')));
        $cuil = str_replace("-", "", trim(Input::get('cuil')));
        /* REFACTORING */
        //VALIDACION PARA QUE NO SE REPITA PERSONAS CON EL MISMO DNI
        if (Alumno::whereNrolegajo($nrodoc)->first()) {
            Session::flash('message', 'YA EXISTE UN ALUMNO REGISTRADO CON ESTE DNI.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('alumnos/crear')
                ->withErrors($validator)
                ->withInput();
        }

        if ($validator->fails()) {
            Session::flash('message', 'ERROR AL INTENTAR CREAR UN ALUMNO.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('alumnos/crear')
                ->withErrors($validator)
                ->withInput();
        } else {

            $fotoperfil = Input::file('fotoperfil');

            if ($fotoperfil) {

                $extension_valida = ImagenHelper::extensionValida($fotoperfil->getClientOriginalName());

                if (!$extension_valida) {
                    Session::flash('message', 'LA IMAGEN DEBE SER DEL TIPO PNG/JPG/GIF.');
                    Session::flash('message_type', self::OPERACION_FALLIDA);
                    return Redirect::to('alumnos/crear');
                }
            }

            $contactos = Input::get('contactos');
            $arrContactos = ArrayHelper::obtenerContactosSeparados($contactos);

            $fecha_nacimiento = FechaHelper::getFechaParaGuardar(Input::get('fechanacimiento'));
            $fecha_ingreso    = FechaHelper::getFechaParaGuardar(Input::get('fechaingreso'));
            $fecha_egreso     = FechaHelper::getFechaParaGuardar(Input::get('fechaegreso'));

            // para crear un alumno, es necesario crear antes la persona
            $persona = new Persona;
                $persona->nombre             = Input::get('nombre');
                $persona->apellido           = Input::get('apellido');
                $persona->tipodocumento_id   = Input::get('tipodocumento');
                $persona->nrodocumento       = $nrodoc;
                $persona->sexo               = Input::get('sexo');
                $persona->estadocivil_id     = Input::get('estadocivil');
                $persona->fechanacimiento    = $fecha_nacimiento;
                $persona->lugarnacimiento_id = Input::get('paisnacimiento');
                $persona->pais_id            = Input::get('pais');
                $persona->provincia_id       = Input::get('provincia');
                $persona->departamento_id    = Input::get('departamento');
                $persona->localidad_id       = Input::get('localidad');
                //$persona->barrio_id          = Input::get('barrio');
                $persona->barrio_id          = 39;
                $persona->barrio             = Input::get('txt_barrio');
                $persona->calle              = Input::get('calle');
                $persona->numero             = Input::get('numerocalle');
                $persona->manzana            = Input::get('manzana');
                $persona->piso               = Input::get('piso');
                $persona->departamento       = Input::get('domiciliodepartamento');
                $persona->codigo_postal      = Input::get('codigopostal');
                $persona->cuil               = $cuil;
                $persona->usuario_alta       = Auth::user()->usuario;
                $persona->fecha_alta         = date('Y-m-d');
            $persona->save();

           // creacion del alumno
           $alumno = new Alumno;
                $alumno->persona_id   = $persona->id;
                $alumno->nrolegajo    = $nrodoc;
                $alumno->activo       = (Input::get('alumnoactivo')) ? 1 : 0;
                $alumno->fechaingreso = $fecha_ingreso;
                $alumno->fechaegreso  = $fecha_egreso;
                $alumno->usuario_alta = Auth::user()->usuario;
                $alumno->fecha_alta   = date('Y-m-d');

                if ($fotoperfil) {
                    $filename = $persona->id . '_' . $persona->nrodocumento . '.jpg';
                    $alumno->foto = $filename;
                }

                $alumno->usuario_alta = Auth::user()->usuario;
                $alumno->fecha_alta   = date('Y-m-d');
            $alumno->save();

            foreach ($arrContactos as $contacto) {
                $persona->contactos()->attach(
                    $contacto['tipo'],
                    array('descripcion'=>$contacto['valor'])
                );
            }

            // se guarda la imagen
            if ($fotoperfil) {
                $imagen = Image::make($fotoperfil->getRealPath());
                $ancho = $imagen->width();
                if ($ancho > self::IMG_PERFIL_WIDTH) $ancho = self::IMG_PERFIL_WIDTH;
                $imagen->resize($ancho, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $imagen->save(self::IMG_PATH . $filename);
            }

            // se crea el legajo
            $legajo = new AlumnoLegajo;
                $legajo->alumno_id    = $alumno->id;
                $legajo->usuario_alta = Auth::user()->usuario;
                $legajo->fecha_alta   = date('Y-m-d');
            $legajo->save();

            Session::flash('message', 'ALUMNO CREADO CON ÉXITO!');
            Session::flash('message_type', self::OPERACION_EXITOSA);
            return Redirect::to('alumnos/editar/'.$alumno->id);
        }
    }

    public function postObteneralumnopordni()
    {
        $dni = Input::get('txt_alumno');
        $alumnos = Alumno::getAlumnoPorDni($dni);

        $alumno = (count($alumnos)) ? $alumnos[0] : self::NO_EXISTE_ALUMNO;

        return Response::json($alumno);
    }

    public function postObteneralumnoporapellidoynombre()
    {
        $apeynom = Input::get('txt_alumno');//'Arevalo, Valeria Lujan';
        $porcion = explode(", ", $apeynom);

        $alumnos = Alumno::getPorApellidoNombre($porcion[0], $porcion[1]);

        $alumno = (count($alumnos)) ? $alumnos[0] : self::NO_EXISTE_ALUMNO;

        return Response::json($alumno);
    }

    /*public function postObtenerhistoricomatricula()
    {
        $carrera_id = Input::get('carrera_id');
        $alumno_id  = Input::get('alumno_id');
        $isncripcion_id = Input::get('isncripcion_id');

        return Response::json($alumno_id);
    }*/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function getEditar($id)
    {

        $alumno = Alumno::findOrFail($id);

        $arrContactos = new ArrayObject;

        foreach ($alumno->persona->contactos as $contacto) {
            $arrContactos->offsetSet($contacto->descripcion, $contacto->pivot);
        }

        $arrTipoDocumento = TipoDocumento::lists('descripcion', 'id');
        $arrEstadoCivil = EstadoCivil::lists('descripcion', 'id');
        $arrPais = Pais::lists('descripcion', 'id');
        $arrProvincia = Provincia::lists('descripcion', 'id');
        $arrDepartamento = Departamento::lists('descripcion', 'id');
        $arrLocalidad = Localidad::lists('descripcion', 'id');
        $arrBarrio = Barrio::lists('descripcion', 'id');
        $arrTipoContacto = Contacto::lists('descripcion', 'id');

        return View::make('alumnos.edit')
            ->with('alumno', $alumno)
            ->with('arrTipoDocumento', $arrTipoDocumento)
            ->with('arrEstadoCivil', $arrEstadoCivil)
            ->with('arrPais', $arrPais)
            ->with('arrProvincia', $arrProvincia)
            ->with('arrDepartamento', $arrDepartamento)
            ->with('arrLocalidad', $arrLocalidad)
            ->with('arrBarrio', $arrBarrio)
            ->with('arrContactos', $arrContactos)
            ->with('arrTipoContacto', $arrTipoContacto)
            ->with('menu', ModulosHelper::MENU_GESTION_ACADEMICA)
            ->with('submenu', ModulosHelper::SUBMENU_ALUMNOS)
            ->with('leer', Session::get('ALUMNO_LEER'))
            ->with('editar', Session::get('ALUMNO_EDITAR'))
            ->with('imprimir', Session::get('ALUMNO_IMPRIMIR'))
            ->with('eliminar', Session::get('ALUMNO_ELIMINAR'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function postUpdate()
    {
        $this->_setAttributesValidation();

        $id = Input::get('txtAlumnoId');

        $validator = Validator::make($this->_data, $this->_rules, $this->_messages);

        $nrodoc = str_replace(".", "", trim(Input::get('documento')));
        $cuil = str_replace("-", "", trim(Input::get('cuil')));

        if ($validator->fails()) {
            Session::flash('message', 'ERROR AL INTENTAR MODIFICAR LOS DATOS DEL ALUMNO.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('alumnos/editar/' . $id)
                ->withErrors($validator)
                ->withInput();
        } else {

            $contactos = Input::get('contactos');
            $arrContactos = ArrayHelper::obtenerContactosSeparados($contactos);

            /* REFACTORIZAR */
            $alumno = Alumno::find($id);
            $persona = Persona::find($alumno->persona_id);

                if (empty($alumno) || empty($persona)) {
                    Session::flash('message', 'EL ALUMNO NO EXISTE EN LA BASE DE DATOS.');
                    Session::flash('message_type', self::OPERACION_CANCELADA);
                    return Redirect::to('alumnos/listado');
                }

                $fotoperfil = Input::file('fotoperfil');

                if ($fotoperfil) {

                    $extension_valida = ImagenHelper::extensionValida($fotoperfil->getClientOriginalName());

                    if (!$extension_valida) {
                        Session::flash('message', 'LA IMAGEN DEBE SER DEL TIPO PNG/JPG/GIF.');
                        Session::flash('message_type', self::OPERACION_FALLIDA);
                        return Redirect::to('alumnos/editar/' . $id);
                    }
                }

                $contactos = Input::get('contactos');
                $arrContactos = ArrayHelper::obtenerContactosSeparados($contactos);

                $fecha_nacimiento = FechaHelper::getFechaParaGuardar(Input::get('fechanacimiento'));
                $fecha_ingreso    = FechaHelper::getFechaParaGuardar(Input::get('fechaingreso'));
                $fecha_egreso     = FechaHelper::getFechaParaGuardar(Input::get('fechaegreso'));

                $persona->nombre             = Input::get('nombre');
                $persona->apellido           = Input::get('apellido');
                $persona->tipodocumento_id   = Input::get('tipodocumento');
                $persona->nrodocumento       = $nrodoc;
                $persona->sexo               = Input::get('sexo');
                $persona->estadocivil_id     = Input::get('estadocivil');
                $persona->fechanacimiento    = $fecha_nacimiento;
                $persona->lugarnacimiento_id = Input::get('paisnacimiento');
                $persona->pais_id            = Input::get('pais');
                $persona->provincia_id       = Input::get('provincia');
                $persona->departamento_id    = Input::get('departamento');
                $persona->localidad_id       = Input::get('localidad');
                //$persona->barrio_id          = Input::get('barrio');
                $persona->barrio_id          = 39;
                $persona->barrio             = Input::get('txt_barrio');
                $persona->calle              = Input::get('calle');
                $persona->numero             = Input::get('numerocalle');
                $persona->manzana            = Input::get('manzana');
                $persona->piso               = Input::get('piso');
                $persona->departamento       = Input::get('domiciliodepartamento');
                $persona->codigo_postal      = Input::get('codigopostal');
                $persona->cuil               = $cuil;
                $persona->usuario_modi       = Auth::user()->usuario;
                $persona->fecha_modi         = date('Y-m-d');
            $persona->save();

                $alumno->activo       = (Input::get('alumnoactivo')) ? 1 : 0;
                $alumno->nrolegajo    = $nrodoc;
                $alumno->fechaingreso = $fecha_ingreso;
                $alumno->fechaegreso  = $fecha_egreso;
                $alumno->usuario_modi = Auth::user()->usuario;
                $alumno->fecha_modi   = date('Y-m-d');

                if ($fotoperfil) {
                    $filename = $persona->id . '_' . $persona->nrodocumento . '.jpg';
                    $alumno->foto = $filename;
                }

            $alumno->save();

            $persona->contactos()->detach();

            // se graban los contactos
            foreach ($arrContactos as $contacto) {
                $persona->contactos()->attach(
                    $contacto['tipo'],
                    array('descripcion'=>$contacto['valor'])
                );
            }

            // se guarda la imagen
            if ($fotoperfil) {
                $imagen = Image::make($fotoperfil->getRealPath());
                $ancho = $imagen->width();
                if ($ancho > self::IMG_PERFIL_WIDTH) $ancho = self::IMG_PERFIL_WIDTH;
                $imagen->resize($ancho, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $imagen->save(self::IMG_PATH . $filename);
            }

            Session::flash('message', 'LA EDICIÓN SE HA REALIZADO CON ÉXITO.');
            Session::flash('message_type', self::OPERACION_EXITOSA);
            return Redirect::to('alumnos/editar/'.$alumno->id);
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
        $id = Input::get('txtIdAlumnoHidden');

        $alumno = Alumno::find($id);

        //if ($this->_noSePuedeBorrar($alumno)) {
            Session::flash('message', ' POR EL MOMENTO NO ES POSIBLE BORRAR AL ALUMNO.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('alumnos/listado');
        //}

        //highlight_string(var_export($alumno,true));
        //exit;
        //
        /*$alumno->alumnolegajo->borrar();
        $alumno->carreras()->detach();
        //$alumno->detallesmatriculaspagos()->delete();
        $alumno->delete();
        $alumno->persona->contactos()->detach();
        $alumno->persona->delete();*/

        Session::flash('message', 'EL ALUMNO HA SIDO BORRADO DE LA BASE DE DATOS.');
        Session::flash('message_type', self::OPERACION_EXITOSA);
        return Redirect::to('alumnos/listado');
    }

    public function getLegajo($id_alumno)
    {
        //$legajo = AlumnoLegajo::where('alumno_id', '=', $id_alumno)->get();
        $alumno = Alumno::with('persona')->with('alumnolegajo')->find($id_alumno);
        $alumno_legajo = AlumnoLegajo::with('alumnoslegajosdocumentos')->find($alumno->alumnolegajo->id);
        
        if (!$alumno->alumnolegajo->fechavencimientoseguro == NULL) {
            $fechavencimientoseguro = FechaHelper::getFechaImpresion($alumno->alumnolegajo->fechavencimientoseguro);
            $porcion = explode("/", $fechavencimientoseguro);
            $fechadesde = $porcion[2].'-'.$porcion[1].'-'.$porcion[0];
            $alumno->alumnolegajo->fechavencimientoseguro = $fechadesde;
        }

        return View::make('legajos.edit')
            ->with('alumno', $alumno)
            ->with('alumno_legajo', $alumno_legajo)
            ->with('menu', ModulosHelper::MENU_GESTION_ACADEMICA)
            ->with('submenu', ModulosHelper::SUBMENU_ALUMNOS)
            ->with('leer', Session::get('ALUMNO_LEER'))
            ->with('editar', Session::get('ALUMNO_EDITAR'))
            ->with('imprimir', Session::get('ALUMNO_IMPRIMIR'))
            ->with('eliminar', Session::get('ALUMNO_ELIMINAR'));
    }

    /*
     * SE GUARDA POR JSON AJAX
     */
    public function postGuardaritemlegajo()
    {
        $legajo_id = Input::get('legajoId');
        $campo = Input::get('campo');

        if ($campo == 'FECHA_SEGURO') {
            $fecha_vencimiento = Input::get('valor');
            if ($fecha_vencimiento == '') {
                $fecha_vencimiento = NULL;
            } else {
                $porcion = explode("-", $fecha_vencimiento);
                $fechadesde = $porcion[0].'/'.$porcion[1].'/'.$porcion[2];
                $fecha_vencimiento = FechaHelper::getFechaParaGuardar($fechadesde);
            }
        }

        $legajo = AlumnoLegajo::find($legajo_id);
        switch ($campo) {
            case 'DNI':
                $legajo->dni = (int) Input::get('valor');
                break;
            case 'FOTO':
                $legajo->foto = (int) Input::get('valor');
                break;                

            case 'PARTIDA_NACIMIENTO':
                $legajo->partidanacimiento = (int) Input::get('valor');
                break;

            case 'BUENA_SALUD':
                $legajo->certificadobuenasalud = (int) Input::get('valor');
                break;

            case 'VACUNACION':
                $legajo->certificadovacinacion = (int) Input::get('valor');
                break;

            case 'FICHA_PREINSCRIPCION':
                $legajo->fichapreinscripcion = (int) Input::get('valor');
                break;

            case 'TITULO':
                $legajo->titulosecundario = (int) Input::get('valor');
                break;

            case 'TITULO_TRAMITE':
                $legajo->constitulotramite = (int) Input::get('valor');
                break;

            case 'CONSTANCIA_TRABAJO':
                $legajo->constanciatrabajo = (int) Input::get('valor');
                break;

            case 'SEGURO':
                $legajo->seguro = (int) Input::get('valor');
                break;

            case 'FECHA_SEGURO':
                $legajo->fechavencimientoseguro = $fecha_vencimiento;
                break;

            case 'OTROS':
                $legajo->otros = (int) Input::get('valor');
                break;
        }

        $legajo->save();

        /*Session::flash('message', 'LEGAJO GUARDADO CORRECTAMENTE.');
        Session::flash('message_type', self::OPERACION_EXITOSA);
        return Redirect::to('alumnos/legajo/' . $alumno_id);*/

        $result = [
            'mensaje' => 'LEGAJO ACTUALIZADO',
            'tipo_mensaje' => self::OPERACION_EXITOSA
        ];

        return Response::json($result);
    }

    /* 
     * REFACTORING
     * mensajes de error en caso de no enviar la imagen
     */

    public function postGuardardocumento()
    {
        $alumno_id = Input::get('txtAlumnoDocumentoId');
        $tipo_documento = Input::get('tipodocumento');
        $alumno_legajo_id = Input::get('txtAlumnoLegajoId');
        $imagen = Input::file('archivoadjunto');

        if ($imagen) {
            $extension_valida = ImagenHelper::extensionValida($imagen->getClientOriginalName());

            if (!$extension_valida) {
                Session::flash('message', 'EL DOCUMENTO DEBE SER DEL TIPO PNG/JPG/GIF.');
                Session::flash('message_type', self::OPERACION_FALLIDA);
                return Redirect::to('alumnos/legajo/' . $alumno_id);
            }
        }

        $data = array(
            'tipo_documento' => $tipo_documento,
            'imagen' => $imagen
        );
        $rules = array(
            'tipo_documento' => 'required',
            'imagen' => 'required'
        );
        $messages = array(
            'required' => 'Campo Obligatorio',
            'imagen.required' => "Debe seleccionar un Documento."
        );

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            Session::flash('message', 'ERROR AL INTENTAR GUARDAR UN DOCUMENTO.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('alumnos/legajo/' . $alumno_id)
                ->withErrors($validator);
        }

        $alumno_legajo_documento = new AlumnoLegajoDocumento;

        if ($imagen) {
            $filename = $alumno_id . '_' . $alumno_legajo_id . '_' . uniqid() .  '.jpg';
        }

        // se guarda la imagen
        if ($imagen) {
            $imagen = Image::make($imagen->getRealPath());
            $ancho = $imagen->width();
            if ($ancho > self::IMG_WIDTH) $ancho = self::IMG_WIDTH;
            $imagen->resize($ancho, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $imagen->save(self::IMG_DOC_PATH . $filename);
        }

        $alumno_legajo_documento->alumnolegajo_id = $alumno_legajo_id;
        $alumno_legajo_documento->documento = $filename;
        $alumno_legajo_documento->tipodocumento = $tipo_documento;
        $alumno_legajo_documento->usuario_alta = Auth::user()->usuario;
        $alumno_legajo_documento->fecha_alta = date('Y-m-d');
        $alumno_legajo_documento->save();

        Session::flash('message', 'DOCUMENTO GUARDADO CORRECTAMENTE.');
        Session::flash('message_type', self::OPERACION_EXITOSA);
        return Redirect::to('alumnos/legajo/' . $alumno_id);
    }

    public function postEditardocumento()
    {
        $documento_id = Input::get('idDocumentoHiddenModi');
        $alumno_id = Input::get('txtAlumnoDocumentoModiId');
        $documento_descripcion = Input::get('txtDocumentoDescripcion');

        if (trim($documento_descripcion) == '')
            return Redirect::to('alumnos/legajo/' . $alumno_id);

        $documento = AlumnoLegajoDocumento::find($documento_id);
        $documento->tipodocumento = $documento_descripcion;
        $documento->save();
        
        return Redirect::to('alumnos/legajo/' . $alumno_id);
    }

    public function postBorrardocumento()
    {
        $documento_id = Input::get('idDocumentoHidden');
        $alumno_id = Input::get('txtAlumnoDocumentoId');
        $imagen = '';
        $documento = AlumnoLegajoDocumento::find($documento_id);
        if ($documento) {
            $documento->delete();
            // imagen fisica
            $imagen = "alumnos/documentos/" . $documento->documento;
        }
        // borro imagen fisica
        if (file_exists($imagen)) unlink($imagen);

        Session::flash('message', 'EL DOCUMENTO HA SIDO BORRADO.');
        Session::flash('message_type', self::OPERACION_EXITOSA);
        return Redirect::to('alumnos/legajo/' . $alumno_id);
    }


    //PARA OBTENER DINAMICAMENTE LOS COMBOS DE DIRECCION
    public function postLocalidades()
    {
        $id = Input::get('id');
         
        $localidades = Localidad::Localidadespordpto($id);

        return Response::json($localidades);
    }

    


    /**
     * Validacion para el borrado de una Alumno
     *
     * @param  Alumno  $alumno
     * @return Boolean
     */
    private function _noSePuedeBorrar(Alumno $alumno)
    {
        return FALSE;
    }

    /**
     * Setea los valores a validar y las reglas a usar
     */
    private function _setAttributesValidation()
    {
        $this->_data = array(
            'nombre'    => Input::get('nombre'),
            'apellido'  => Input::get('apellido'),
            'documento' => Input::get('documento'),
            'fechanacimiento' => Input::get('fechanacimiento'),
            'fechaingreso' => Input::get('fechaingreso')
        );

        $this->_rules = array(
            'nombre'    => 'required',
            'apellido'  => 'required',
            'documento' => 'required',
            'fechanacimiento' => 'required',
            'fechaingreso' => 'required'
        );

        $this->_messages = array(
            'required' => 'Campo Obligatorio',
        );
    }

    /*
    | COMIENZO DE METODOS PARA INFORMES DE ALUMNOS
    */
    public function getInforme()
    {
        return View::make('informes/alumnos')
            ->with('menu', ModulosHelper::MENU_INFORMES)
            ->with('submenu', ModulosHelper::SUBMENU_INFORMES_ALUMNOS)
            ->with('leer', Session::get('INFORME_ALUMNOS_LEER'))
            ->with('editar', Session::get('INFORME_ALUMNOS_EDITAR'))
            ->with('imprimir', Session::get('INFORME_ALUMNOS_IMPRIMIR'))
            ->with('eliminar', Session::get('INFORME_ALUMNOS_ELIMINAR'));
    }

    public function getInformealumnosporcarrera()
    {        
        $organizaciones = Organizacion::lists('nombre', 'id');

        array_unshift($organizaciones, 'Seleccionar');

        return View::make('informes/alumnos_por_carrera')
            ->with('menu', ModulosHelper::MENU_INFORMES)
            ->with('submenu', ModulosHelper::SUBMENU_INFORMES_ALUMNOS)
            ->with('organizaciones', $organizaciones)
            ->with('leer', Session::get('INFORME_ALUMNOS_LEER'))
            ->with('editar', Session::get('INFORME_ALUMNOS_EDITAR'))
            ->with('imprimir', Session::get('INFORME_ALUMNOS_IMPRIMIR'))
            ->with('eliminar', Session::get('INFORME_ALUMNOS_ELIMINAR'));
    }

    public function getInformealumnosdeudasporcarrera()
    {        
        $organizaciones = Organizacion::lists('nombre', 'id');

        array_unshift($organizaciones, 'Seleccionar');

        return View::make('informes/alumnos_adeudados')
            ->with('menu', ModulosHelper::MENU_INFORMES)
            ->with('submenu', ModulosHelper::SUBMENU_INFORMES_ALUMNOS)
            ->with('organizaciones', $organizaciones)
            ->with('leer', Session::get('INFORME_ALUMNOS_LEER'))
            ->with('editar', Session::get('INFORME_ALUMNOS_EDITAR'))
            ->with('imprimir', Session::get('INFORME_ALUMNOS_IMPRIMIR'))
            ->with('eliminar', Session::get('INFORME_ALUMNOS_ELIMINAR'));
    }

    public function getInformecuentaalumnos()
    {        
        $organizaciones = Organizacion::lists('nombre', 'id');

        array_unshift($organizaciones, 'Seleccionar');

        return View::make('informes/alumnos_cuentas')
            ->with('menu', ModulosHelper::MENU_INFORMES)
            ->with('submenu', ModulosHelper::SUBMENU_INFORMES_ALUMNOS)
            ->with('organizaciones', $organizaciones)
            ->with('leer', Session::get('INFORME_ALUMNOS_LEER'))
            ->with('editar', Session::get('INFORME_ALUMNOS_EDITAR'))
            ->with('imprimir', Session::get('INFORME_ALUMNOS_IMPRIMIR'))
            ->with('eliminar', Session::get('INFORME_ALUMNOS_ELIMINAR'));
    }

    public function getInformeanaliticoalumnos()
    {        
        $organizaciones = Organizacion::lists('nombre', 'id');

        array_unshift($organizaciones, 'Seleccionar');

        return View::make('informes/alumnos_analitico')
            ->with('menu', ModulosHelper::MENU_INFORMES)
            ->with('submenu', ModulosHelper::SUBMENU_INFORMES_ALUMNOS)
            ->with('organizaciones', $organizaciones)
            ->with('leer', Session::get('INFORME_ALUMNOS_LEER'))
            ->with('editar', Session::get('INFORME_ALUMNOS_EDITAR'))
            ->with('imprimir', Session::get('INFORME_ALUMNOS_IMPRIMIR'))
            ->with('eliminar', Session::get('INFORME_ALUMNOS_ELIMINAR'));
    }

    public function postObtenercarreras()
    {
        $idOrg = Input::get('id');
         
        $carreras = Carrera::Carreraspororganizacion($idOrg);

        return Response::json($carreras);
    }

    public function postObteneranaliticoporalumno()
    {
        $organizacion_id = Input::get('organizacion');
        $carrera_id = Input::get('carrera');
        $alumno_id = Input::get('alumno_id');
        $materias = [];
         
        $examenfinal = ExamenFinal::whereRaw('carrera_id ='.$carrera_id.' AND organizacion_id ='.$organizacion_id.' AND alumno_id ='.$alumno_id)->get();

        if (count($examenfinal) > 0) {
            foreach ($examenfinal as $examenfina) {
                array_push($materias, $examenfina->materia_id);
            }

            $resultado = array_unique($materias);
            sort($resultado);

            foreach ($resultado as $value) {
                $materia = Materia::find($value);

                $parciales = Regularidades::whereRaw('carrera_id ='.$carrera_id.' AND planestudio_id ='.$materia->planestudio_id.' AND materia_id ='.$value.' AND alumno_id ='.$alumno_id)->get();

                foreach ($parciales as $parcial) {
                    if ($parcial->regularizo == 1) {
                        $regularizo = 'SI';
                        $promociono = '-';
                        $fecha_regularizo = FechaHelper::getFechaImpresion($parcial->fecha_regularidad);
                        //$porcion = explode("/", $fecha_regularidad);
                        //$fecha_regularizo = $porcion[2].'-'.$porcion[1].'-'.$porcion[0];
                    } 

                    if ($parcial->regularizo == 0 || $parcial->regularizo == 2) {
                        $regularizo = 'NO';
                        $promociono = '-';
                        $fecha_regularizo = '-';
                    }

                    if ($parcial->regularizo == 3) {
                        $regularizo = '-';
                        $promociono = 'SI';
                        $fecha_regularizo = FechaHelper::getFechaImpresion($parcial->fecha_regularidad);
                    }
                }

                $examenfinales = ExamenFinal::whereRaw('carrera_id ='.$carrera_id.' AND organizacion_id ='.$organizacion_id.' AND alumno_id ='.$alumno_id.' AND materia_id ='.$value.' AND planestudio_id ='.$materia->planestudio_id.' AND calif_final_num > 5')->get();

                if (count($examenfinales) > 0) {
                    foreach ($examenfinales as $examen) {
                        $aprobo = 'SI';
                        $fecha_aprobacion = FechaHelper::getFechaImpresion($examen->fecha_aprobacion);

                        $analitico[] = ['materia_id' => $examen->materia_id, 'materia' => $materia->nombremateria, 'regimen' => $materia->periodo, 'regularizado' => $regularizo, 'fecha_regularizacion' => $fecha_regularizo, 'promociono' => $promociono, 'aprobo' => $aprobo, 'fecha_aprobacion' => $fecha_aprobacion, 'calif_final_num' => $examen->calif_final_num, 'calif_final_let' => $examen->calif_final_let, 'libro' => $examen->libro, 'folio' => $examen->folio, 'acta' => $examen->acta, 'observaciones' => $examen->observaciones, 'aniocursado' => $materia->aniocursado];
                    }
                } else {
                    $examenfinales = ExamenFinal::whereRaw('carrera_id ='.$carrera_id.' AND organizacion_id ='.$organizacion_id.' AND alumno_id ='.$alumno_id.' AND materia_id ='.$value.' AND planestudio_id ='.$materia->planestudio_id.' AND calif_final_num < 6')->get();

                    if (count($examenfinales) > 0) {
                        foreach ($examenfinales as $examen) {
                            $calif_final_num = $examen->calif_final_num;
                            $calif_final_let = $examen->calif_final_let;
                            $libro = $examen->libro;
                            $folio = $examen->folio;
                            $acta = $examen->acta;
                            $observaciones = $examen->observaciones;
                        }

                        $aprobo = 'NO';
                        $fecha_aprobacion = '-';

                        $analitico[] = ['materia_id' => $value, 'materia' => $materia->nombremateria, 'regimen' => $materia->periodo, 'regularizado' => $regularizo, 'fecha_regularizacion' => $fecha_regularizo, 'promociono' => $promociono, 'aprobo' => $aprobo, 'fecha_aprobacion' => $fecha_aprobacion, 'calif_final_num' => $calif_final_num, 'calif_final_let' => $calif_final_let, 'libro' => $libro, 'folio' => $folio, 'acta' => $acta, 'observaciones' => $observaciones, 'aniocursado' => $materia->aniocursado];
                    }
                }
            }
        } else {
            $analitico = [];
        }

        /*highlight_string(var_export($analitico, true));
        exit();*/
        return Response::json($analitico);
    }

    public function getImprimiranaliticoalumno()
    {
        $organizacion_id = Input::get('organizacion_id');
        $carrera_id = Input::get('carrera_id');
        $alumno_id = Input::get('alumno_id');

        $materias = [];
        
        $examenfinal = ExamenFinal::whereRaw('carrera_id ='.$carrera_id.' AND organizacion_id ='.$organizacion_id.' AND alumno_id ='.$alumno_id)->get();

        if (count($examenfinal) > 0) {
            foreach ($examenfinal as $examenfina) {
                array_push($materias, $examenfina->materia_id);
            }

            $resultado = array_unique($materias);
            sort($resultado);

            foreach ($resultado as $value) {
                $materia = Materia::find($value);

                $parciales = Regularidades::whereRaw('carrera_id ='.$carrera_id.' AND planestudio_id ='.$materia->planestudio_id.' AND materia_id ='.$value.' AND alumno_id ='.$alumno_id)->get();

                foreach ($parciales as $parcial) {
                    if ($parcial->regularizo == 1) {
                        $regularizo = 'SI';
                        $promociono = '-';
                        $fecha_regularizo = FechaHelper::getFechaImpresion($parcial->fecha_regularidad);
                        //$porcion = explode("/", $fecha_regularidad);
                        //$fecha_regularizo = $porcion[2].'-'.$porcion[1].'-'.$porcion[0];
                    } 

                    if ($parcial->regularizo == 0 || $parcial->regularizo == 2) {
                        $regularizo = 'NO';
                        $promociono = '-';
                        $fecha_regularizo = '-';
                    }

                    if ($parcial->regularizo == 3) {
                        $regularizo = '-';
                        $promociono = 'SI';
                        $fecha_regularizo = FechaHelper::getFechaImpresion($parcial->fecha_regularidad);
                    }
                }

                $examenfinales = ExamenFinal::whereRaw('carrera_id ='.$carrera_id.' AND organizacion_id ='.$organizacion_id.' AND alumno_id ='.$alumno_id.' AND materia_id ='.$value.' AND planestudio_id ='.$materia->planestudio_id.' AND calif_final_num > 5')->get();

                if (count($examenfinales) > 0) {
                    foreach ($examenfinales as $examen) {
                        $aprobo = 'SI';
                        $fecha_aprobacion = FechaHelper::getFechaImpresion($examen->fecha_aprobacion);

                        $analitico[] = ['materia_id' => $examen->materia_id, 'materia' => $materia->nombremateria, 'regimen' => $materia->periodo, 'regularizado' => $regularizo, 'fecha_regularizacion' => $fecha_regularizo, 'promociono' => $promociono, 'aprobo' => $aprobo, 'fecha_aprobacion' => $fecha_aprobacion, 'calif_final_num' => $examen->calif_final_num, 'calif_final_let' => $examen->calif_final_let, 'libro' => $examen->libro, 'folio' => $examen->folio, 'acta' => $examen->acta, 'observaciones' => $examen->observaciones, 'aniocursado' => $materia->aniocursado];
                    }
                } else {
                    $examenfinales = ExamenFinal::whereRaw('carrera_id ='.$carrera_id.' AND organizacion_id ='.$organizacion_id.' AND alumno_id ='.$alumno_id.' AND materia_id ='.$value.' AND planestudio_id ='.$materia->planestudio_id.' AND calif_final_num < 6')->get();

                    if (count($examenfinales) > 0) {
                        foreach ($examenfinales as $examen) {
                            $calif_final_num = $examen->calif_final_num;
                            $calif_final_let = $examen->calif_final_let;
                            $libro = $examen->libro;
                            $folio = $examen->folio;
                            $acta = $examen->acta;
                            $observaciones = $examen->observaciones;
                        }

                        $aprobo = 'NO';
                        $fecha_aprobacion = '-';

                        $analitico[] = ['materia_id' => $value, 'materia' => $materia->nombremateria, 'regimen' => $materia->periodo, 'regularizado' => $regularizo, 'fecha_regularizacion' => $fecha_regularizo, 'promociono' => $promociono, 'aprobo' => $aprobo, 'fecha_aprobacion' => $fecha_aprobacion, 'calif_final_num' => $calif_final_num, 'calif_final_let' => $calif_final_let, 'libro' => $libro, 'folio' => $folio, 'acta' => $acta, 'observaciones' => $observaciones, 'aniocursado' => $materia->aniocursado];
                    }
                }
            }
        }

        $alumnos = Alumno::getAlumnoPorAlumnoId($alumno_id);
        $alumno = (count($alumnos)) ? $alumnos[0] : '';

        $apeynom = $alumno->apellido.', '.$alumno->nombre;
        $fecha_nac = FechaHelper::getFechaImpresion($alumno->fechanacimiento);
        $lugarnacimiento = $alumno->provincia.', '.$fecha_nac;

        $titulosecundario = AlumnoLegajo::whereRaw('alumno_id ='.$alumno_id)->first()->titulosecundario;

        $cohorte = PlanEstudio::find($materia->planestudio_id)->codigoplan;

        $contactotel = ContactoPersona::whereRaw('contacto_id=1 AND persona_id ='.$alumno->persona_id)->first();
        $telefono = '';

        if (count($contactotel) > 0) {
            $telefono = $contactotel->descripcion;
        } else {
            $contactotel = ContactoPersona::whereRaw('contacto_id=2 AND persona_id ='.$alumno->persona_id)->first();

            if (count($contactotel) > 0) {
                $telefono = $contactotel->descripcion;
            }
        }

        if ($titulosecundario == 1) {
            $titulopresentado = 'SI';
        } else {
            $titulopresentado = 'NO';
        }

        $carrera = Carrera::find($carrera_id)->carrera;

        $datoalumno[] = ['carrera' => $carrera, 'apeynom' => $apeynom, 'nrodocumento' => $alumno->nrodocumento, 'calle' => $alumno->calle, 'cohorte' => $cohorte, 'lugarnacimiento' => $lugarnacimiento, 'titulopresentado' => $titulopresentado, 'telefono' => $telefono];

        /*highlight_string(var_export($datoalumno, true));
        exit();*/

        $pdf = PDF::loadView(
            'informes.pdf.analiticoalumno',
            [
              'datoalumno' => $datoalumno,
              'analitico' => $analitico
            ]
        );
        return $pdf->setOrientation('landscape')->stream();
    }

	public function postInformealumnosporcarrera()
	{
		$filtro         = Input::get('filtro');
        $idOrganizacion = Input::get('organizacion');
        $idCarrera      = Input::get('carrera');
        $sexo = (Input::get('filtrosexo')==1) ? 'Masculino' : 'Femenino';

        if ($idOrganizacion==0 or $idCarrera==0)
        {
            Session::flash('message', 'DEBES SELECCIONAR UNA ORGANIZACION Y UNA CARERRA.');
            Session::flash('message_type', self::OPERACION_FALLIDA);                
            return Redirect::to('alumnos/informealumnosporcarrera');
        }
        //Filtro = 1 -> Opcion Todos
        if ($filtro == 1 or $filtro == 4 or $filtro == 2 or $filtro == 5)
        {
            $carreras = Organizacion::find($idOrganizacion)->carreras;

            foreach ($carreras as $carrera) {
                if ($carrera->id == $idCarrera)
                {
                    $alumnos = $carrera->alumnos;
                    break;
                }
            }
        }

        $txtapellido = (empty(Input::get('filtroapellido'))) ? null : trim(Input::get('filtroapellido'));
        $txtnombre = (empty(Input::get('filtronombre'))) ? null : trim(Input::get('filtronombre'));
        $txtlocalidad = (empty(Input::get('filtrolocalidad'))) ? null : trim(Input::get('filtrolocalidad'));

        $organizaciones = Organizacion::lists('nombre', 'id');

        array_unshift($organizaciones, 'Seleccionar');

        return View::make('informes/alumnos_por_carrera')
            ->with('menu', ModulosHelper::MENU_INFORMES)
            ->with('submenu', ModulosHelper::SUBMENU_INFORMES_ALUMNOS)
            ->with('organizaciones', $organizaciones)
            ->with('alumnos', $alumnos)
            ->with('organizacionseleccionada', $idOrganizacion)
            ->with('carreraseleccionada', $idCarrera)
            ->with('filtroseleccionado', $filtro)
            ->with('filtrosexo', $sexo)
            ->with('filtroapellido', $txtapellido)
            ->with('filtronombre', $txtnombre)
            ->with('filtrolocalidad', $txtlocalidad)
            ->with('leer', Session::get('INFORME_ALUMNOS_LEER'))
            ->with('editar', Session::get('INFORME_ALUMNOS_EDITAR'))
            ->with('imprimir', Session::get('INFORME_ALUMNOS_IMPRIMIR'))
            ->with('eliminar', Session::get('INFORME_ALUMNOS_ELIMINAR'));
	}

    public function getInformealumnosbecadosactivos()
    {
        $organizaciones = Organizacion::lists('nombre', 'id');

        array_unshift($organizaciones, 'Seleccionar');

        return View::make('informes/becados')
            ->with('menu', ModulosHelper::MENU_INFORMES)
            ->with('submenu', ModulosHelper::SUBMENU_INFORMES_ALUMNOS)
            ->with('organizaciones', $organizaciones)
            ->with('leer', Session::get('INFORME_ALUMNOS_LEER'))
            ->with('editar', Session::get('INFORME_ALUMNOS_EDITAR'))
            ->with('imprimir', Session::get('INFORME_ALUMNOS_IMPRIMIR'))
            ->with('eliminar', Session::get('INFORME_ALUMNOS_ELIMINAR'));
    }

    public function postObtenercarrera()
    {
        $idOrg = Input::get('id');
         
        $carreras = Carrera::Carreraspororganizacion($idOrg);

        return Response::json($carreras);
    }

    public function postObtenercantida()
    {
        $carrera_id = Input::get('carrera_id');
        
        $totbecados = Beca::getAlumnosBecadosPorCarrera($carrera_id);

        $totactivos = AlumnoCarrera::whereRaw('carrera_id = '. $carrera_id .' and activo = 1')->get();

        $becados[] = array('becados'=>count($totbecados), 'activos'=>count($totactivos));
/*highlight_string(var_export($carreras, true));
exit();*/
        
        return Response::json($becados);
    }

    public function postPorcengrafico()
    {
        $carrera_id = Input::get('carrera_id');
        $carreras = Carrera::findOrFail($carrera_id);
        //$totalumnos = Alumno::all()->count();
        $totbecados = Beca::getAlumnosBecadosPorCarrera($carrera_id);
        $totactivos = AlumnoCarrera::whereRaw('carrera_id = '. $carrera_id .' and activo = 1')->get();
        $totalumnos = count($totactivos);
        $becados = array('becados', 'activos');

        $arrc = array();
        $porcent = array();
        $arrporc = array();

        for ($i=0; $i < count($becados); $i++) { 
            $cadena = $becados[$i];

            $arrc[] = $cadena;
            //RESCATO EN PORCENTAJE PARA LUEGO USAR EN EL BUCLE DE GRAFICO DE TORTA
            if ($becados[$i]=='becados') {
                $totbeca =  (count($totbecados)*100)/$totalumnos;
                $arrporc[] =  abs($totbeca);
                $totacti = $totbeca - 100;
                $arrporc[] =  abs($totacti);
            }
        }

        //FOREACH PARA ARMADO PARA EL JSON DE GRAFICO DE TORTA
        $colores = ['#F7464A', '#46BFBD', '#FDB45C', '#949FB1', '#4D5360', '#69ADFB', '#A17BED', '#67B352', '#31B5AE', '#FAC020', '#22BED6', '#3CDEC0', '#32A12F', '#1A6891'];
        $highlight = ['#FF5A5E', '#5AD3D1', '#FFC870', '#A8B3C5', '#616774', '#89BEFA', '#B296EB', '#8BC47C', '#5DC9C4', '#FAD05C', '#4FD4E8', '#74F7DF', '#74C971', '#468BB0'];

        /*$i = 0;
        foreach ($arrporc as $arrp) {*/
            $porcent[] = ['becados'=>round($arrporc[0], 1), 'activos'=>round($arrporc[1], 1)];
            //$porcent[$i] = ['value'=>(int)number_format($arrp,2,",","."), 'color'=>$colores[$i], 'highlight'=>$highlight[$i], 'label'=>$arrc[$i]];
            /*$i++;
        }*/
        
        return $porcent;
    }

    public function postBarragrafico()
    {
        $carrera_id = Input::get('carrera_id');
        $totbecados = Beca::getAlumnosBecadosPorCarrera($carrera_id);

        $totactivos = AlumnoCarrera::whereRaw('carrera_id = '. $carrera_id .' and activo = 1')->get();

        $barra[] = ['becados'=>count($totbecados), 'activos'=>count($totactivos)];

        return Response::json($barra);
    }

    public function getInformealumnosmatriculadosxciclo()
    {
        $organizaciones = Organizacion::lists('nombre', 'id');

        array_unshift($organizaciones, 'Seleccionar');

        return View::make('informes/cantidad_alumnos_matriculados')
            ->with('menu', ModulosHelper::MENU_INFORMES)
            ->with('submenu', ModulosHelper::SUBMENU_INFORMES_ALUMNOS)
            ->with('organizaciones', $organizaciones)
            ->with('leer', Session::get('INFORME_ALUMNOS_LEER'))
            ->with('editar', Session::get('INFORME_ALUMNOS_EDITAR'))
            ->with('imprimir', Session::get('INFORME_ALUMNOS_IMPRIMIR'))
            ->with('eliminar', Session::get('INFORME_ALUMNOS_ELIMINAR'));
    }

    public function postObtenermatriculaporciclo()
    {
        $organizacion_id = Input::get('organizacion');
        $ciclo_id = Input::get('ciclo');
        $todos = AlumnoCarrera::whereRaw('activo = 1')->get();
        $porcentaje = array();
        $cantidad = array();

        if ($ciclo_id == 0) {
            $matricula = Matricula::whereRaw('organizacion_id=' . $organizacion_id)->get();
        } else {
            $matricula = Matricula::whereRaw('organizacion_id=' . $organizacion_id . ' and ciclolectivo_id=' . $ciclo_id)->get();

            $totalumnos = AlumnoCarrera::whereRaw('ciclolectivo_id = '. $ciclo_id . ' and activo = 1')->get();
            $cantidad[] = count($totalumnos);
        }

        foreach ($matricula as $matri) {
            $años[] = $matri->ciclolectivo->descripcion;
            if ($ciclo_id == 0) {
                $idciclo = $matri->ciclolectivo->id;
                $totalumnos = AlumnoCarrera::whereRaw('ciclolectivo_id = '. $idciclo . ' and activo = 1')->get();
                $cantidad[] = count($totalumnos);
            }
        }
        
            $años = array_unique($años);
            $años = array_values($años);
            $cantidad = array_unique($cantidad);
            $cantidad = array_values($cantidad);
        
        $i = 0;
        foreach ($años as $año) {
            if ($cantidad[$i] == 0){
                $porcentaje[] = 0;
            } else {
                $porcentaje[] = ($cantidad[$i]*100)/count($todos);
            }
            
            $matriculas[$i] = ['descripcion'=>$año, 'cantidad'=>$cantidad[$i], 'porcentaje'=>round($porcentaje[$i], 1)];
            $i++;
        }

        return $matriculas;
    }

    public function postObtenerciclolectivo()
    {
        $ciclo_id = Input::get('ciclo');

        if ($ciclo_id == 0) {
            $organizacion_id = Input::get('organizacion');
            $matricula = Matricula::whereRaw('organizacion_id=' . $organizacion_id)->get();
        } else {
            $matricula = Matricula::whereRaw('ciclolectivo_id=' . $ciclo_id)->get();
        }

        foreach ($matricula as $matri) {
            $ciclos[] = $matri->ciclolectivo->descripcion;
        }

        $ciclos = array_unique($ciclos);
        $ciclos = array_values($ciclos);

        return Response::json($ciclos);
    }

    public function postObtenerporcen()
    {
        $organizacion_id = Input::get('organizacion');
        $ciclo_id = Input::get('ciclo');
        $todos = AlumnoCarrera::whereRaw('activo = 1')->get();
        $porcentaje = array();
        $cantidad = array();

        if ($ciclo_id == 0) {
            $matricula = Matricula::whereRaw('organizacion_id=' . $organizacion_id)->get();
        } else {
            $matricula = Matricula::whereRaw('organizacion_id=' . $organizacion_id . ' and ciclolectivo_id=' . $ciclo_id)->get();

            $totalumnos = AlumnoCarrera::whereRaw('ciclolectivo_id = '. $ciclo_id . ' and activo = 1')->get();
            $cantidad[] = count($totalumnos);
        }

        foreach ($matricula as $matri) {
            $años[] = $matri->ciclolectivo->descripcion;
            if ($ciclo_id == 0) {
                $idciclo = $matri->ciclolectivo->id;
                $totalumnos = AlumnoCarrera::whereRaw('ciclolectivo_id = '. $idciclo . ' and activo = 1')->get();
                $cantidad[] = count($totalumnos);
            }
        }
        
            $años = array_unique($años);
            $años = array_values($años);
            $cantidad = array_unique($cantidad);
            $cantidad = array_values($cantidad);
        //FOREACH PARA ARMADO PARA EL JSON DE GRAFICO DE TORTA
        $colores = ['#F7464A', '#46BFBD', '#FDB45C', '#949FB1', '#4D5360', '#69ADFB', '#A17BED', '#67B352', '#31B5AE', '#FAC020', '#22BED6', '#3CDEC0', '#32A12F', '#1A6891'];
        $highlight = ['#FF5A5E', '#5AD3D1', '#FFC870', '#A8B3C5', '#616774', '#89BEFA', '#B296EB', '#8BC47C', '#5DC9C4', '#FAD05C', '#4FD4E8', '#74F7DF', '#74C971', '#468BB0'];

        $i = 0;
        foreach ($años as $año) {
            if ($cantidad[$i] == 0){
                $porcentaje[] = 0;
            } else {
                $porcentaje[] = ($cantidad[$i]*100)/count($todos);
            }
            
            $porcent[$i] = ['label'=>$año, 'value'=>round($porcentaje[$i], 1)];
            //$porcent[$i] = ['value'=>(int)number_format($porcentaje[$i],2,",","."), 'color'=>$colores[$i], 'highlight'=>$highlight[$i], 'label'=>$año];
            $i++;
        }

        return $porcent;
    }

    public function postBarralinea()
    {
        $organizacion_id = Input::get('organizacion');
        $ciclo_id = Input::get('ciclo');
        $cantidad = array();
        $barra = array();

        if ($ciclo_id == 0) {
            $matricula = Matricula::whereRaw('organizacion_id=' . $organizacion_id)->get();
        } /*else {
            $matricula = Matricula::whereRaw('organizacion_id=' . $organizacion_id . ' and ciclolectivo_id=' . $ciclo_id)->get();

            $totalumnos = AlumnoCarrera::whereRaw('ciclolectivo_id = '. $ciclo_id . ' and activo = 1')->get();
            $cantidad[] = count($totalumnos);
        }*/

        foreach ($matricula as $matri) {
            if ($ciclo_id == 0) {
                $años[] = $matri->ciclolectivo->descripcion;
                $idciclo = $matri->ciclolectivo->id;
                $totalumnos = AlumnoCarrera::whereRaw('ciclolectivo_id = '. $idciclo . ' and activo = 1')->get();
                $cantidad[] = count($totalumnos);
            }
        }
        
        $años = array_unique($años);
        $años = array_values($años);
        $cantidad = array_unique($cantidad);
        $cantidad = array_values($cantidad);

        $i = 0;
        foreach ($años as $año) {
            $barra[$i] = ['anos'=>$año, 'total'=>$cantidad[$i]];
            $i++;
        }

        return $barra;
    }

    public function getInformematriculadospdf()
    {
        $ciclo = Input::get('ciclo_lectivo');
        $organizacion = Input::get('organizacion');

        //if ($ciclo == 0) {
            $inscripciones = AlumnoCarrera::getTodaslasInscripciones();
            $ciclo_lectivo = CicloLectivo::whereRaw('organizacion_id = ' . $organizacion)->get();
        /*} else {
            $inscripciones = AlumnoCarrera::getInscripcionesPorCiclo($ciclo);
            $ciclo_lectivo = CicloLectivo::find($ciclo);
        }*/

        foreach ($inscripciones as $inscripcion) {
            $contactos = ContactoPersona::where(
                'persona_id', '=', $inscripcion->persona_id)->get();
            $inscripcion->contactos = $contactos;
        }

        $pdf = PDF::loadView(
            'informes.pdf.alumnosmatriculados',
            [
              'alumnos' => $inscripciones,
              'ciclo_lectivo' => $ciclo_lectivo
            ]
        );
        return $pdf->setOrientation('landscape')->stream();
    }

	public function getInformepdf()
	{
        $filtro         = Input::get('filtro');
        $idOrganizacion = Input::get('organizacion');
        $idCarrera      = Input::get('carrera');
        $nombrecarrera  = Input::get('nombrecarrera');
        $sexo = (Input::get('filtrosexo')==1) ? 'Masculino' : 'Femenino';

        if ($idOrganizacion==0 or $idCarrera==0)
        {
            Session::flash('message', 'DEBES SELECCIONAR UNA ORGANIZACION Y UNA CARERRA.');
            Session::flash('message_type', self::OPERACION_FALLIDA);                
            return Redirect::to('alumnos/informealumnosporcarrera');
        }
        //Filtro = 1 -> Opcion Todos
        if ($filtro == 1 or $filtro == 4 or $filtro == 2 or $filtro == 5)
        {
            $carreras = Organizacion::find($idOrganizacion)->carreras;

            foreach ($carreras as $carrera) {
                if ($carrera->id == $idCarrera) {
                    $alumnos = $carrera->alumnos;
                    break;
                }
            }
        }


        $txtapellido = (empty(Input::get('filtroapellido'))) ? null : trim(Input::get('filtroapellido'));
        $txtnombre = (empty(Input::get('filtronombre'))) ? null : trim(Input::get('filtronombre'));
        $txtlocalidad = (empty(Input::get('filtrolocalidad'))) ? null : trim(Input::get('filtrolocalidad'));

        $pdf = PDF::loadView(
            'informes.pdf.alumnosporcarrera',
            [
                'alumnos'=>$alumnos,
                'filtroseleccionado'=>$filtro,
                'filtrosexo'=>$sexo,
                'filtroapellido'=>$txtapellido,
                'filtronombre'=>$txtnombre,
                'filtrolocalidad'=>$txtlocalidad,
                'nombrecarrera'=>$nombrecarrera
            ]
        );
        return $pdf->setOrientation('landscape')->stream();

	}

    /* INFORME ALUMNOS MATRICULADOS POR ANIO */
    public function getInformealumnosmatriculadosporanio()
    {
        
        $organizaciones = Organizacion::lists('nombre', 'id');

        array_unshift($organizaciones, 'Seleccionar');
        $habilita = false;

        return View::make('informes/alumnos_matriculados_por_anio')
            ->with('organizaciones', $organizaciones)
            ->with('habilita', $habilita)
            ->with('menu', ModulosHelper::MENU_INFORMES)
            ->with('submenu', ModulosHelper::SUBMENU_INFORMES_MATRICULAS)
            ->with('leer', Session::get('INFORME_MATRICULAS_LEER'))
            ->with('editar', Session::get('INFORME_MATRICULAS_EDITAR'))
            ->with('imprimir', Session::get('INFORME_MATRICULAS_IMPRIMIR'))
            ->with('eliminar', Session::get('INFORME_MATRICULAS_ELIMINAR'));
    }

    public function postObtenerinscripcionesporciclo()
    {
        $ciclo_id = Input::get('cboCiclo');
        $orgid = Input::get('cboOrganizacion');
        $inscriptos = array();
        $ciclos = CicloLectivo::where('organizacion_id', '=', $orgid)->get();
        $habilita = false;

        if (!$ciclo_id == '') {
            $inscripciones = AlumnoCarrera::getInscripcionesPorCiclo($ciclo_id);

            if (count($inscripciones) > 0) {
                foreach ($inscripciones as $inscripcion) {
                    $contactos = ContactoPersona::where('persona_id', '=', $inscripcion->persona_id)->get();
                    $inscripcion->contactos = $contactos;
                }

                //////////////////////////////
                foreach ($inscripciones as $inscripcion) {
                    $persona = $inscripcion->apellido . ', ' . $inscripcion->nombre;

                    if ($inscripcion->barrio == null) {
                        $barrio = 'B° no cargado';
                    } else {
                        $barrio = $inscripcion->barrio;
                    }

                    if ($inscripcion->calle) {
                        $calle = $inscripcion->calle;
                    } else {
                        $calle = 'Calle no cargado';
                    }

                    if ($inscripcion->calle_numero==0) {
                        $numero = ' s/n';
                    } else {
                        $numero = ' N: ' . $inscripcion->calle_numero;
                    }

                    if ($inscripcion->manzana==0) {
                        $manzana = '';
                    } else {
                        $manzana = ' - Mz: ' . $inscripcion->manzana;
                    }

                    if ($inscripcion->departamento==0) {
                        $departamento = '';
                    } else {
                        $departamento = ' - dpto: ' . $inscripcion->departamento;
                    }
                    
                    $domicilio = $barrio . ' - ' . $calle . ' ' . $numero . ' ' . $manzana . ' ' . $departamento;

                    //if ($domicilio == 0) $domicilio = ' ';

                    $telefono = '';
                    $email = '';

                    foreach ($inscripcion->contactos as $contacto) {
                        if ($contacto->contacto_id == 1) {
                            $telefono = $contacto->descripcion;
                        } else if($contacto->contacto_id == 3) {
                            $email = $contacto->descripcion;
                        }
                    }

                    $ciclos = CicloLectivo::where('organizacion_id', '=', $orgid)->get();
                    $habilita = true;

                    $inscriptos[] = ['persona' => $persona, 'nrodocumento' => $inscripcion->nrodocumento, 'sexo' => $inscripcion->sexo, 'domicilio' => $domicilio, 'localidad' => $inscripcion->localidad, 'telefono' => $telefono, 'email' => $email];
                }
            }
        }
/*highlight_string(var_export($inscriptos, true));
exit();*/
        /////////////////////////////
        $organizaciones = Organizacion::lists('nombre', 'id');

        //array_unshift($organizaciones, 'Seleccionar');

        return View::make('informes/alumnos_matriculados_por_anio')
            ->with('organizaciones', $organizaciones)
            ->with('inscriptos', $inscriptos)
            ->with('ciclo_id', $ciclo_id)
            ->with('ciclos', $ciclos)
            ->with('OrgID', $orgid)
            ->with('habilita', $habilita)
            ->with('menu', ModulosHelper::MENU_INFORMES)
            ->with('submenu', ModulosHelper::SUBMENU_INFORMES_MATRICULAS)
            ->with('leer', Session::get('INFORME_MATRICULAS_LEER'))
            ->with('editar', Session::get('INFORME_MATRICULAS_EDITAR'))
            ->with('imprimir', Session::get('INFORME_MATRICULAS_IMPRIMIR'))
            ->with('eliminar', Session::get('INFORME_MATRICULAS_ELIMINAR'));
    }

    public function getPdfalumnosmatriculadosporanio()
    {
        $ciclo = Input::get('ciclo_lectivo');

        $inscripciones = AlumnoCarrera::getInscripcionesPorCiclo($ciclo);
        $ciclo_lectivo = CicloLectivo::find($ciclo);

        foreach ($inscripciones as $inscripcion) {
            $contactos = ContactoPersona::where(
                'persona_id', '=', $inscripcion->persona_id)->get();
            $inscripcion->contactos = $contactos;
        }

        $pdf = PDF::loadView(
            'informes.pdf.alumnosmatriculadosporanio',
            [
              'alumnos' => $inscripciones,
              'ciclo_lectivo' => $ciclo_lectivo->descripcion
            ]
        );
        return $pdf->setOrientation('landscape')->stream();

    }

    /* INFORME LEGAJOS DE ALUMNOS POR CARRERA */

    public function getInformelegajosalumnosporcarrera()
    {
        
        $organizaciones = Organizacion::lists('nombre', 'id');

        array_unshift($organizaciones, 'Seleccionar');

        return View::make('informes/legajos_alumnos_por_carrera')
            ->with('menu', ModulosHelper::MENU_INFORMES)
            ->with('submenu', ModulosHelper::SUBMENU_INFORMES_ALUMNOS)
            ->with('organizaciones', $organizaciones)
            ->with('leer', Session::get('INFORME_ALUMNOS_LEER'))
            ->with('editar', Session::get('INFORME_ALUMNOS_EDITAR'))
            ->with('imprimir', Session::get('INFORME_ALUMNOS_IMPRIMIR'))
            ->with('eliminar', Session::get('INFORME_ALUMNOS_ELIMINAR'));
    }

    public function postInformelegajosporcarrera()
    {
        $carrera_id = Input::get('carrera');
        $ciclo_id = Input::get('cboCiclo');
        $cbolegajo = Input::get('cboLegajo');
        $bandera = 'false';
        $bandera1 = 'true';
        $legajo = [];

        $legajos = AlumnoLegajo::getLegajosPorCarreraCiclo($carrera_id, $ciclo_id);

        if ($cbolegajo == 1) {
            foreach ($legajos as $value) {
                if ($value->dni == 1 && $value->partidanacimiento == 1 && $value->certificadobuenasalud == 1 && $value->certificadovacinacion == 1 && $value->fichapreinscripcion == 1 && $value->titulosecundario == 1 && $value->constitulotramite == 1 && $value->constanciatrabajo == 1 && $value->seguro == 1 && $value->otros == 1 && $value->foto == 1) {
                    $legajo[] = ['dni' => $value->dni, 'partidanacimiento' => $value->partidanacimiento, 'certificadobuenasalud' => $value->certificadobuenasalud, 'certificadovacinacion' => $value->certificadovacinacion, 'fichapreinscripcion' => $value->fichapreinscripcion, 'titulosecundario' => $value->titulosecundario, 'constitulotramite' => $value->constitulotramite, 'constanciatrabajo' => $value->constanciatrabajo, 'seguro' => $value->seguro, 'otros' => $value->otros, 'foto' => $value->foto, 'fechavencimientoseguro' => $value->fechavencimientoseguro, 'apellido' => $value->apellido, 'nombre' => $value->nombre];
                }
            }
        } else {
            foreach ($legajos as $value) {
                if ($value->dni == 1 && $value->partidanacimiento == 1 && $value->certificadobuenasalud == 1 && $value->certificadovacinacion == 1 && $value->fichapreinscripcion == 1 && $value->titulosecundario == 1 && $value->constitulotramite == 1 && $value->constanciatrabajo == 1 && $value->seguro == 1 && $value->otros == 1 && $value->foto == 1) {
                    $bandera = 'false';
                } else {
                    $legajo[] = ['dni' => $value->dni, 'partidanacimiento' => $value->partidanacimiento, 'certificadobuenasalud' => $value->certificadobuenasalud, 'certificadovacinacion' => $value->certificadovacinacion, 'fichapreinscripcion' => $value->fichapreinscripcion, 'titulosecundario' => $value->titulosecundario, 'constitulotramite' => $value->constitulotramite, 'constanciatrabajo' => $value->constanciatrabajo, 'seguro' => $value->seguro, 'otros' => $value->otros, 'foto' => $value->foto, 'fechavencimientoseguro' => $value->fechavencimientoseguro, 'apellido' => $value->apellido, 'nombre' => $value->nombre];
                }
            }
        }
        
/*highlight_string(var_export($legajo, true));
        exit();*/
        return Response::json($legajo);
    }

    public function postInformelegajospordni()
    {
        $dni = Input::get('filtro');
        //$dni = '25.228.692';

        $legajos = AlumnoLegajo::getLegajosPorDNI($dni);

        return Response::json($legajos);
    }

    public function postInformelegajosporapellido()
    {
        $apellido = Input::get('filtro');

        $legajos = AlumnoLegajo::getLegajosPorApellido($apellido);

        return Response::json($legajos);
    }

    public function getPdflegajosalumnosporcarrera()
    {
        $carrera_id = Input::get('carrera');
        $ciclo_id = Input::get('cboCiclo');
        $cbolegajo = Input::get('cboLegajo');

        if ($carrera_id == '' || $ciclo_id == '') {
            $legajos = '';
            $carrera = '';
            $ciclo = '';
        } else {
            $legajo = AlumnoLegajo::getLegajosPorCarreraCiclo($carrera_id, $ciclo_id);

            if ($cbolegajo == 1) {
                foreach ($legajo as $value) {
                    if ($value->dni == 1 && $value->partidanacimiento == 1 && $value->certificadobuenasalud == 1 && $value->certificadovacinacion == 1 && $value->fichapreinscripcion == 1 && $value->titulosecundario == 1 && $value->constitulotramite == 1 && $value->constanciatrabajo == 1 && $value->seguro == 1 && $value->otros == 1 && $value->foto == 1) {
                        $legajos[] = ['dni' => $value->dni, 'partidanacimiento' => $value->partidanacimiento, 'certificadobuenasalud' => $value->certificadobuenasalud, 'certificadovacinacion' => $value->certificadovacinacion, 'fichapreinscripcion' => $value->fichapreinscripcion, 'titulosecundario' => $value->titulosecundario, 'constitulotramite' => $value->constitulotramite, 'constanciatrabajo' => $value->constanciatrabajo, 'seguro' => $value->seguro, 'otros' => $value->otros, 'foto' => $value->foto, 'fechavencimientoseguro' => $value->fechavencimientoseguro, 'apellido' => $value->apellido, 'nombre' => $value->nombre];
                    }
                }
            } else {
                foreach ($legajo as $value) {
                    if ($value->dni == 1 && $value->partidanacimiento == 1 && $value->certificadobuenasalud == 1 && $value->certificadovacinacion == 1 && $value->fichapreinscripcion == 1 && $value->titulosecundario == 1 && $value->constitulotramite == 1 && $value->constanciatrabajo == 1 && $value->seguro == 1 && $value->otros == 1 && $value->foto == 1) {
                        $bandera = 'false';
                    } else {
                        $legajos[] = ['dni' => $value->dni, 'partidanacimiento' => $value->partidanacimiento, 'certificadobuenasalud' => $value->certificadobuenasalud, 'certificadovacinacion' => $value->certificadovacinacion, 'fichapreinscripcion' => $value->fichapreinscripcion, 'titulosecundario' => $value->titulosecundario, 'constitulotramite' => $value->constitulotramite, 'constanciatrabajo' => $value->constanciatrabajo, 'seguro' => $value->seguro, 'otros' => $value->otros, 'foto' => $value->foto, 'fechavencimientoseguro' => $value->fechavencimientoseguro, 'apellido' => $value->apellido, 'nombre' => $value->nombre];
                    }
                }
            }

            $carrera = Carrera::find($carrera_id);

            $carrera = (empty($carrera)) ? '' : $carrera->carrera;

            $ciclo = CicloLectivo::find($ciclo_id);

            $ciclo = (empty($ciclo)) ? '' : $ciclo->descripcion;
        }

        $pdf = PDF::loadView(
            'informes.pdf.legajosalumnosporcarrera',
            [
              'legajos' => $legajos,
              'carrera' => $carrera,
              'ciclo' => $ciclo
            ]
        );
        return $pdf->setOrientation('landscape')->stream();

    }

    public function getPdflegajosalumnosporfiltro()
    {
        $filtro = Input::get('filtro');
        $valor = Input::get('valor');

        if ($filtro == 1) {
            // DNI
            $legajos = AlumnoLegajo::getLegajosPorDNI($valor);
        } elseif ($filtro == 2) {
            // APELLIDO
            $legajos = AlumnoLegajo::getLegajosPorApellido($valor);
        }        

        $pdf = PDF::loadView(
            'informes.pdf.legajosalumnosporfiltro',
            ['legajos' => $legajos]
        );
        return $pdf->setOrientation('landscape')->stream();

    }

    /* INFORME ALUMNOS BECADOS */

    public function getInformealumnosbecados()
    {
        
        $organizaciones = Organizacion::lists('nombre', 'id');

        array_unshift($organizaciones, 'Seleccionar');

        return View::make('informes/alumnos_becados')
            ->with('menu', ModulosHelper::MENU_INFORMES)
            ->with('submenu', ModulosHelper::SUBMENU_INFORMES_ALUMNOS)
            ->with('organizaciones', $organizaciones)
            ->with('leer', Session::get('INFORME_ALUMNOS_LEER'))
            ->with('editar', Session::get('INFORME_ALUMNOS_EDITAR'))
            ->with('imprimir', Session::get('INFORME_ALUMNOS_IMPRIMIR'))
            ->with('eliminar', Session::get('INFORME_ALUMNOS_ELIMINAR'));
    }

    public function getInformealumnosbecadosactivosbaja()
    {
        $organizaciones = Organizacion::lists('nombre', 'id');

        array_unshift($organizaciones, 'Seleccionar');

        $habilita = false;
        $filtros = '';
        $becado = array();

        return View::make('informes/alumnos_becados_activos')
            ->with('menu', ModulosHelper::MENU_INFORMES)
            ->with('submenu', ModulosHelper::SUBMENU_INFORMES_ALUMNOS)
            ->with('organizaciones', $organizaciones)
            ->with('filtros', $filtros)
            ->with('habilita', $habilita)
            ->with('becados', $becado)
            ->with('leer', Session::get('INFORME_ALUMNOS_LEER'))
            ->with('editar', Session::get('INFORME_ALUMNOS_EDITAR'))
            ->with('imprimir', Session::get('INFORME_ALUMNOS_IMPRIMIR'))
            ->with('eliminar', Session::get('INFORME_ALUMNOS_ELIMINAR'));
    }

    public function postInformebecadosactivosporcarreras()
    {
        $organizacion_id = Input::get('cboOrganizacion');
        $carrera_id = Input::get('cboCarreras');
        $ciclo_id = Input::get('cboCiclo');
        $filtros = Input::get('cboFiltros');
        $ciclos = array();
        $carreras = array();
        $habilita = false;
        $becados = array();
        $becado = array();

        if (!$ciclo_id == '' && !$carrera_id == '') {
            if ($filtros == 0) {
                $inscripciones = Matricula::getDatosInscriptosMatriculaActivo($carrera_id, $ciclo_id);//AlumnoCarrera::getInscripciones($ciclo_id, $carrera_id);

                foreach ($inscripciones as $value) {
                    $detalle_matricula = DetalleMatriculaPago::whereRaw('inscripcion_id = '. $value->inscripcion_id .' AND matricula_id = '. $value->matricula_id)->first();

                    $ciclo_inscripcion = CicloLectivo::find($value->ciclo_inscripcion)->descripcion;
                    $ciclo_matricula = CicloLectivo::find($value->ciclolectivo_id)->descripcion;

                    if ($detalle_matricula) {
                        if ($ciclo_matricula == $ciclo_inscripcion) {
                            $becados[] = ['persona_id' => $value->persona_id, 'nombre' => $value->nombre, 'apellido' => $value->apellido, 'nrodocumento' => $value->nrodocumento, 'sexo' => $value->sexo, 'barrio' => $value->barrio, 'calle' => $value->calle, 'calle_numero' => $value->calle_numero, 'manzana' => $value->manzana, 'departamento' => $value->departamento, 'localidad' => $value->localidad, 'alumno_id' => $value->alumno_id, 'ciclo_inscripcion' => $value->ciclo_inscripcion, 'ciclolectivo_id' => $value->ciclolectivo_id, 'carrera_id' => $value->carrera_id, 'inscripcion_id' => $value->inscripcion_id, 'fechaingreso' => $value->fechaingreso, 'activo' => $value->activo];
                        }
                    }
                }

                foreach ($inscripciones as $value) {
                    $detalle_matricula = DetalleMatriculaPago::whereRaw('inscripcion_id = '. $value->inscripcion_id .' AND matricula_id = '. $value->matricula_id)->first();

                    $ciclo_inscripcion = CicloLectivo::find($value->ciclo_inscripcion)->descripcion;
                    $ciclo_matricula = CicloLectivo::find($value->ciclolectivo_id)->descripcion;

                    if ($detalle_matricula) {
                        if ($ciclo_matricula > $ciclo_inscripcion) {
                            $becados[] = ['persona_id' => $value->persona_id, 'nombre' => $value->nombre, 'apellido' => $value->apellido, 'nrodocumento' => $value->nrodocumento, 'sexo' => $value->sexo, 'barrio' => $value->barrio, 'calle' => $value->calle, 'calle_numero' => $value->calle_numero, 'manzana' => $value->manzana, 'departamento' => $value->departamento, 'localidad' => $value->localidad, 'alumno_id' => $value->alumno_id, 'ciclolectivo_id' => $value->ciclolectivo_id, 'carrera_id' => $value->carrera_id, 'inscripcion_id' => $value->inscripcion_id, 'fechaingreso' => $value->fechaingreso, 'activo' => $value->activo];
                        }
                    }
                }

                foreach ($inscripciones as $value) {
                    $beca = Beca::whereRaw('inscripcion_id =' . $value->inscripcion_id . ' AND ciclolectivo_id =' . $ciclo_id . ' and becado=1')->get();

                    if (count($beca) > 0) {
                        $becados[] = ['persona_id' => $value->persona_id, 'nombre' => $value->nombre, 'apellido' => $value->apellido, 'nrodocumento' => $value->nrodocumento, 'sexo' => $value->sexo, 'barrio' => $value->barrio, 'calle' => $value->calle, 'calle_numero' => $value->calle_numero, 'manzana' => $value->manzana, 'departamento' => $value->departamento, 'localidad' => $value->localidad, 'alumno_id' => $value->alumno_id, 'ciclolectivo_id' => $value->ciclolectivo_id, 'carrera_id' => $value->carrera_id, 'inscripcion_id' => $value->inscripcion_id, 'fechaingreso' => $value->fechaingreso, 'activo' => $value->activo];
                    }
                }
            }
            
            if ($filtros == 1) {
                $inscripciones = Beca::getAlumnosBecadosPorCarreraCiclo($carrera_id, $ciclo_id);

                foreach ($inscripciones as $value) {
                    $inscripcion_id = AlumnoCarrera::whereRaw('carrera_id= '.$value->carrera_id.' AND alumno_id= '.$value->alumno_id)->first()->id;

                    $becados[] = ['persona_id' => $value->persona_id, 'nombre' => $value->nombre, 'apellido' => $value->apellido, 'nrodocumento' => $value->dni, 'sexo' => $value->sexo, 'barrio' => $value->barrio, 'calle' => $value->calle, 'calle_numero' => $value->calle_numero, 'manzana' => $value->manzana, 'departamento' => $value->departamento, 'localidad' => $value->localidad, 'alumno_id' => $value->alumno_id, 'ciclolectivo_id' => $value->ciclolectivo_id, 'carrera_id' => $value->carrera_id, 'inscripcion_id' => $inscripcion_id, 'fechaingreso' => $value->fechaingreso, 'activo' => $value->activo];
                }
            }
            
            if ($filtros == 2) {
                $filtro = 1;
                $inscripciones = Matricula::getDatosInscriptosMatriculas($carrera_id, $ciclo_id);//AlumnoCarrera::getInscripcionesactivosbaja($ciclo_id, $carrera_id, $filtro);
                $localidad = '';

                foreach ($inscripciones as $value) {
                    $detalle_matricula = DetalleMatriculaPago::whereRaw('inscripcion_id = '. $value->inscripcion_id .' AND matricula_id = '. $value->matricula_id)->first();

                    $ciclo_inscripcion = CicloLectivo::find($value->ciclo_inscripcion)->descripcion;
                    $ciclo_matricula = CicloLectivo::find($value->ciclolectivo_id)->descripcion;
                    $inscripcion_id = AlumnoCarrera::whereRaw('carrera_id= '.$value->carrera_id.' AND alumno_id= '.$value->alumno_id)->first()->id;

                    if ($detalle_matricula) {
                        if ($ciclo_matricula == $ciclo_inscripcion) {
                            $becados[] = ['persona_id' => $value->persona_id, 'nombre' => $value->nombre, 'apellido' => $value->apellido, 'nrodocumento' => $value->nrodocumento, 'sexo' => $value->sexo, 'barrio' => $value->barrio, 'calle' => $value->calle, 'calle_numero' => $value->calle_numero, 'manzana' => $value->manzana, 'departamento' => $value->departamento, 'localidad' => $localidad, 'alumno_id' => $value->alumno_id, 'ciclolectivo_id' => $value->ciclolectivo_id, 'carrera_id' => $value->carrera_id, 'inscripcion_id' => $inscripcion_id, 'fechaingreso' => $value->fechaingreso, 'activo' => $value->activo];
                        }
                    }
                }

                foreach ($inscripciones as $value) {
                    $detalle_matricula = DetalleMatriculaPago::whereRaw('inscripcion_id = '. $value->inscripcion_id .' AND matricula_id = '. $value->matricula_id)->first();

                    $ciclo_inscripcion = CicloLectivo::find($value->ciclo_inscripcion)->descripcion;
                    $ciclo_matricula = CicloLectivo::find($value->ciclolectivo_id)->descripcion;
                    $inscripcion_id = AlumnoCarrera::whereRaw('carrera_id= '.$value->carrera_id.' AND alumno_id= '.$value->alumno_id)->first()->id;

                    if ($detalle_matricula) {
                        if ($ciclo_matricula > $ciclo_inscripcion) {
                            $becados[] = ['persona_id' => $value->persona_id, 'nombre' => $value->nombre, 'apellido' => $value->apellido, 'nrodocumento' => $value->nrodocumento, 'sexo' => $value->sexo, 'barrio' => $value->barrio, 'calle' => $value->calle, 'calle_numero' => $value->calle_numero, 'manzana' => $value->manzana, 'departamento' => $value->departamento, 'localidad' => $localidad, 'alumno_id' => $value->alumno_id, 'ciclolectivo_id' => $value->ciclolectivo_id, 'carrera_id' => $value->carrera_id, 'inscripcion_id' => $inscripcion_id, 'fechaingreso' => $value->fechaingreso, 'activo' => $value->activo];
                        }
                    }
                }

                foreach ($inscripciones as $value) {
                    $beca = Beca::whereRaw('inscripcion_id =' . $value->inscripcion_id . ' AND ciclolectivo_id =' . $ciclo_id . ' and becado=1')->get();

                    if (count($beca) > 0) {
                        $becados[] = ['persona_id' => $value->persona_id, 'nombre' => $value->nombre, 'apellido' => $value->apellido, 'nrodocumento' => $value->nrodocumento, 'sexo' => $value->sexo, 'barrio' => $value->barrio, 'calle' => $value->calle, 'calle_numero' => $value->calle_numero, 'manzana' => $value->manzana, 'departamento' => $value->departamento, 'localidad' => $localidad, 'alumno_id' => $value->alumno_id, 'ciclolectivo_id' => $value->ciclolectivo_id, 'carrera_id' => $value->carrera_id, 'inscripcion_id' => $inscripcion_id, 'fechaingreso' => $value->fechaingreso, 'activo' => $value->activo];
                    }
                }
            }
            
            if ($filtros == 3) {
                $filtro = 0;
                //$becados = AlumnoCarrera::getInscripcionesactivosbaja($ciclo_id, $carrera_id, $filtro);
                $inscripciones = Matricula::getDatosInscriptosMatriculaActivo($carrera_id, $ciclo_id);//AlumnoCarrera::getInscripciones($ciclo_id, $carrera_id);

                foreach ($inscripciones as $value) {
                    $detalle_matricula = DetalleMatriculaPago::whereRaw('inscripcion_id = '. $value->inscripcion_id .' AND matricula_id = '. $value->matricula_id)->first();

                    $ciclo_inscripcion = CicloLectivo::find($value->ciclo_inscripcion)->descripcion;
                    $ciclo_matricula = CicloLectivo::find($value->ciclolectivo_id)->descripcion;

                    if ($detalle_matricula) {
                        if ($ciclo_matricula == $ciclo_inscripcion) {
                            if ($value->activo == 0) {
                                $becados[] = ['persona_id' => $value->persona_id, 'nombre' => $value->nombre, 'apellido' => $value->apellido, 'nrodocumento' => $value->nrodocumento, 'sexo' => $value->sexo, 'barrio' => $value->barrio, 'calle' => $value->calle, 'calle_numero' => $value->calle_numero, 'manzana' => $value->manzana, 'departamento' => $value->departamento, 'localidad' => $value->localidad, 'alumno_id' => $value->alumno_id, 'ciclo_inscripcion' => $value->ciclo_inscripcion, 'ciclolectivo_id' => $value->ciclolectivo_id, 'carrera_id' => $value->carrera_id, 'inscripcion_id' => $value->inscripcion_id, 'fechaingreso' => $value->fechaingreso, 'activo' => $value->activo];
                            }
                        }
                    }
                }

                foreach ($inscripciones as $value) {
                    $detalle_matricula = DetalleMatriculaPago::whereRaw('inscripcion_id = '. $value->inscripcion_id .' AND matricula_id = '. $value->matricula_id)->first();

                    $ciclo_inscripcion = CicloLectivo::find($value->ciclo_inscripcion)->descripcion;
                    $ciclo_matricula = CicloLectivo::find($value->ciclolectivo_id)->descripcion;

                    if ($detalle_matricula) {
                        if ($ciclo_matricula > $ciclo_inscripcion) {
                            if ($value->activo == 0) {
                                $becados[] = ['persona_id' => $value->persona_id, 'nombre' => $value->nombre, 'apellido' => $value->apellido, 'nrodocumento' => $value->nrodocumento, 'sexo' => $value->sexo, 'barrio' => $value->barrio, 'calle' => $value->calle, 'calle_numero' => $value->calle_numero, 'manzana' => $value->manzana, 'departamento' => $value->departamento, 'localidad' => $value->localidad, 'alumno_id' => $value->alumno_id, 'ciclo_inscripcion' => $value->ciclo_inscripcion, 'ciclolectivo_id' => $value->ciclolectivo_id, 'carrera_id' => $value->carrera_id, 'inscripcion_id' => $value->inscripcion_id, 'fechaingreso' => $value->fechaingreso, 'activo' => $value->activo];
                            }
                        }
                    }
                }
            }

            $carreras = AlumnoCarrera::getCarrerasPorCiclo($ciclo_id);
            $ciclos = CicloLectivo::where('organizacion_id', '=', $organizacion_id)->get();
            $habilita = true;
     
            foreach ($becados as $value) {
                $telefono = '';
                $email = '';
                $fechaingreso = FechaHelper::getFechaImpresion($value['fechaingreso']);
                //$value['fechaingreso'] = $fechaingreso;
                $contactos = ContactoPersona::where('persona_id', '=', $value['persona_id'])->get();

                foreach ($contactos as $contacto) {
                    if ($contacto->contacto_id == 1) {
                        $telefono = $contacto->descripcion;
                    } else if($contacto->contacto_id == 3) {
                        $email = $contacto->descripcion;
                    }
                }

                /*$value['telefono'] = $telefono;
                $value['email'] = $email;*/

                $becado[] = ['persona_id' => $value['persona_id'], 'nombre' => $value['nombre'], 'apellido' => $value['apellido'], 'nrodocumento' => $value['nrodocumento'], 'sexo' => $value['sexo'], 'barrio' => $value['barrio'], 'calle' => $value['calle'], 'calle_numero' => $value['calle_numero'], 'manzana' => $value['manzana'], 'departamento' => $value['departamento'], 'localidad' => $value['localidad'], 'alumno_id' => $value['alumno_id'], 'ciclolectivo_id' => $value['ciclolectivo_id'], 'carrera_id' => $value['carrera_id'], 'inscripcion_id' => $value['inscripcion_id'], 'fechaingreso' => $fechaingreso, 'activo' => $value['activo'], 'telefono' => $telefono, 'email' => $email];
            }
        }
  /*
highlight_string(var_export($becado, true));
exit();*/
        $organizaciones = Organizacion::lists('nombre', 'id');

        if ($ciclo_id == '') {
            array_unshift($organizaciones, 'Seleccionar');
        }

        if ($carrera_id == 0) {
            array_unshift($organizaciones, 'Seleccionar');
        }

        return View::make('informes/alumnos_becados_activos')
            ->with('menu', ModulosHelper::MENU_INFORMES)
            ->with('submenu', ModulosHelper::SUBMENU_INFORMES_ALUMNOS)
            ->with('organizaciones', $organizaciones)
            ->with('ciclos', $ciclos)
            ->with('carreras', $carreras)
            ->with('carrera', $carrera_id)
            ->with('ciclo_id', $ciclo_id)
            ->with('becados', $becado)
            ->with('filtros', $filtros)
            ->with('habilita', $habilita)
            ->with('leer', Session::get('INFORME_ALUMNOS_LEER'))
            ->with('editar', Session::get('INFORME_ALUMNOS_EDITAR'))
            ->with('imprimir', Session::get('INFORME_ALUMNOS_IMPRIMIR'))
            ->with('eliminar', Session::get('INFORME_ALUMNOS_ELIMINAR'));
    }

    public function getPdfbecadosactivosbajas()
    {
        $carrera_id = Input::get('carrera');
        $ciclo_id = Input::get('ciclo');
        $filtros = Input::get('filtro');
        $becados = array();
        $becado = array();

        if (!$ciclo_id == '' && !$carrera_id == '') {
            if ($filtros == 0) {
                $inscripciones = Matricula::getDatosInscriptosMatriculaActivo($carrera_id, $ciclo_id);//AlumnoCarrera::getInscripciones($ciclo_id, $carrera_id);

                foreach ($inscripciones as $value) {
                    $detalle_matricula = DetalleMatriculaPago::whereRaw('inscripcion_id = '. $value->inscripcion_id .' AND matricula_id = '. $value->matricula_id)->first();

                    $ciclo_inscripcion = CicloLectivo::find($value->ciclo_inscripcion)->descripcion;
                    $ciclo_matricula = CicloLectivo::find($value->ciclolectivo_id)->descripcion;

                    if ($detalle_matricula) {
                        if ($ciclo_matricula == $ciclo_inscripcion) {
                            $becados[] = ['persona_id' => $value->persona_id, 'nombre' => $value->nombre, 'apellido' => $value->apellido, 'nrodocumento' => $value->nrodocumento, 'sexo' => $value->sexo, 'barrio' => $value->barrio, 'calle' => $value->calle, 'calle_numero' => $value->calle_numero, 'manzana' => $value->manzana, 'departamento' => $value->departamento, 'localidad' => $value->localidad, 'alumno_id' => $value->alumno_id, 'ciclo_inscripcion' => $value->ciclo_inscripcion, 'ciclolectivo_id' => $value->ciclolectivo_id, 'carrera_id' => $value->carrera_id, 'inscripcion_id' => $value->inscripcion_id, 'fechaingreso' => $value->fechaingreso, 'activo' => $value->activo];
                        }
                    }
                }

                foreach ($inscripciones as $value) {
                    $detalle_matricula = DetalleMatriculaPago::whereRaw('inscripcion_id = '. $value->inscripcion_id .' AND matricula_id = '. $value->matricula_id)->first();

                    $ciclo_inscripcion = CicloLectivo::find($value->ciclo_inscripcion)->descripcion;
                    $ciclo_matricula = CicloLectivo::find($value->ciclolectivo_id)->descripcion;

                    if ($detalle_matricula) {
                        if ($ciclo_matricula > $ciclo_inscripcion) {
                            $becados[] = ['persona_id' => $value->persona_id, 'nombre' => $value->nombre, 'apellido' => $value->apellido, 'nrodocumento' => $value->nrodocumento, 'sexo' => $value->sexo, 'barrio' => $value->barrio, 'calle' => $value->calle, 'calle_numero' => $value->calle_numero, 'manzana' => $value->manzana, 'departamento' => $value->departamento, 'localidad' => $value->localidad, 'alumno_id' => $value->alumno_id, 'ciclolectivo_id' => $value->ciclolectivo_id, 'carrera_id' => $value->carrera_id, 'inscripcion_id' => $value->inscripcion_id, 'fechaingreso' => $value->fechaingreso, 'activo' => $value->activo];
                        }
                    }
                }

                foreach ($inscripciones as $value) {
                    $beca = Beca::whereRaw('inscripcion_id =' . $value->inscripcion_id . ' AND ciclolectivo_id =' . $ciclo_id . ' and becado=1')->get();

                    if (count($beca) > 0) {
                        $becados[] = ['persona_id' => $value->persona_id, 'nombre' => $value->nombre, 'apellido' => $value->apellido, 'nrodocumento' => $value->nrodocumento, 'sexo' => $value->sexo, 'barrio' => $value->barrio, 'calle' => $value->calle, 'calle_numero' => $value->calle_numero, 'manzana' => $value->manzana, 'departamento' => $value->departamento, 'localidad' => $value->localidad, 'alumno_id' => $value->alumno_id, 'ciclolectivo_id' => $value->ciclolectivo_id, 'carrera_id' => $value->carrera_id, 'inscripcion_id' => $value->inscripcion_id, 'fechaingreso' => $value->fechaingreso, 'activo' => $value->activo];
                    }
                }
            }
            
            if ($filtros == 1) {
                $inscripciones = Beca::getAlumnosBecadosPorCarreraCiclo($carrera_id, $ciclo_id);

                foreach ($inscripciones as $value) {
                    $inscripcion_id = AlumnoCarrera::whereRaw('carrera_id= '.$value->carrera_id.' AND alumno_id= '.$value->alumno_id)->first()->id;

                    $becados[] = ['persona_id' => $value->persona_id, 'nombre' => $value->nombre, 'apellido' => $value->apellido, 'nrodocumento' => $value->dni, 'sexo' => $value->sexo, 'barrio' => $value->barrio, 'calle' => $value->calle, 'calle_numero' => $value->calle_numero, 'manzana' => $value->manzana, 'departamento' => $value->departamento, 'localidad' => $value->localidad, 'alumno_id' => $value->alumno_id, 'ciclolectivo_id' => $value->ciclolectivo_id, 'carrera_id' => $value->carrera_id, 'inscripcion_id' => $inscripcion_id, 'fechaingreso' => $value->fechaingreso, 'activo' => $value->activo];
                }
            }
            
            if ($filtros == 2) {
                $filtro = 1;
                $inscripciones = Matricula::getDatosInscriptosMatriculas($carrera_id, $ciclo_id);//AlumnoCarrera::getInscripcionesactivosbaja($ciclo_id, $carrera_id, $filtro);
                $localidad = '';

                foreach ($inscripciones as $value) {
                    $detalle_matricula = DetalleMatriculaPago::whereRaw('inscripcion_id = '. $value->inscripcion_id .' AND matricula_id = '. $value->matricula_id)->first();

                    $ciclo_inscripcion = CicloLectivo::find($value->ciclo_inscripcion)->descripcion;
                    $ciclo_matricula = CicloLectivo::find($value->ciclolectivo_id)->descripcion;
                    $inscripcion_id = AlumnoCarrera::whereRaw('carrera_id= '.$value->carrera_id.' AND alumno_id= '.$value->alumno_id)->first()->id;

                    if ($detalle_matricula) {
                        if ($ciclo_matricula == $ciclo_inscripcion) {
                            $becados[] = ['persona_id' => $value->persona_id, 'nombre' => $value->nombre, 'apellido' => $value->apellido, 'nrodocumento' => $value->nrodocumento, 'sexo' => $value->sexo, 'barrio' => $value->barrio, 'calle' => $value->calle, 'calle_numero' => $value->calle_numero, 'manzana' => $value->manzana, 'departamento' => $value->departamento, 'localidad' => $localidad, 'alumno_id' => $value->alumno_id, 'ciclolectivo_id' => $value->ciclolectivo_id, 'carrera_id' => $value->carrera_id, 'inscripcion_id' => $inscripcion_id, 'fechaingreso' => $value->fechaingreso, 'activo' => $value->activo];
                        }
                    }
                }

                foreach ($inscripciones as $value) {
                    $detalle_matricula = DetalleMatriculaPago::whereRaw('inscripcion_id = '. $value->inscripcion_id .' AND matricula_id = '. $value->matricula_id)->first();

                    $ciclo_inscripcion = CicloLectivo::find($value->ciclo_inscripcion)->descripcion;
                    $ciclo_matricula = CicloLectivo::find($value->ciclolectivo_id)->descripcion;
                    $inscripcion_id = AlumnoCarrera::whereRaw('carrera_id= '.$value->carrera_id.' AND alumno_id= '.$value->alumno_id)->first()->id;

                    if ($detalle_matricula) {
                        if ($ciclo_matricula > $ciclo_inscripcion) {
                            $becados[] = ['persona_id' => $value->persona_id, 'nombre' => $value->nombre, 'apellido' => $value->apellido, 'nrodocumento' => $value->nrodocumento, 'sexo' => $value->sexo, 'barrio' => $value->barrio, 'calle' => $value->calle, 'calle_numero' => $value->calle_numero, 'manzana' => $value->manzana, 'departamento' => $value->departamento, 'localidad' => $localidad, 'alumno_id' => $value->alumno_id, 'ciclolectivo_id' => $value->ciclolectivo_id, 'carrera_id' => $value->carrera_id, 'inscripcion_id' => $inscripcion_id, 'fechaingreso' => $value->fechaingreso, 'activo' => $value->activo];
                        }
                    }
                }
                
                foreach ($inscripciones as $value) {
                    $beca = Beca::whereRaw('inscripcion_id =' . $value->inscripcion_id . ' AND ciclolectivo_id =' . $ciclo_id . ' and becado=1')->get();

                    if (count($beca) > 0) {
                        $becados[] = ['persona_id' => $value->persona_id, 'nombre' => $value->nombre, 'apellido' => $value->apellido, 'nrodocumento' => $value->nrodocumento, 'sexo' => $value->sexo, 'barrio' => $value->barrio, 'calle' => $value->calle, 'calle_numero' => $value->calle_numero, 'manzana' => $value->manzana, 'departamento' => $value->departamento, 'localidad' => $localidad, 'alumno_id' => $value->alumno_id, 'ciclolectivo_id' => $value->ciclolectivo_id, 'carrera_id' => $value->carrera_id, 'inscripcion_id' => $inscripcion_id, 'fechaingreso' => $value->fechaingreso, 'activo' => $value->activo];
                    }
                }
            }
            
            if ($filtros == 3) {
                $filtro = 0;
                //$becados = AlumnoCarrera::getInscripcionesactivosbaja($ciclo_id, $carrera_id, $filtro);
                $inscripciones = Matricula::getDatosInscriptosMatriculaActivo($carrera_id, $ciclo_id);//AlumnoCarrera::getInscripciones($ciclo_id, $carrera_id);

                foreach ($inscripciones as $value) {
                    $detalle_matricula = DetalleMatriculaPago::whereRaw('inscripcion_id = '. $value->inscripcion_id .' AND matricula_id = '. $value->matricula_id)->first();

                    $ciclo_inscripcion = CicloLectivo::find($value->ciclo_inscripcion)->descripcion;
                    $ciclo_matricula = CicloLectivo::find($value->ciclolectivo_id)->descripcion;

                    if ($detalle_matricula) {
                        if ($ciclo_matricula == $ciclo_inscripcion) {
                            if ($value->activo == 0) {
                                $becados[] = ['persona_id' => $value->persona_id, 'nombre' => $value->nombre, 'apellido' => $value->apellido, 'nrodocumento' => $value->nrodocumento, 'sexo' => $value->sexo, 'barrio' => $value->barrio, 'calle' => $value->calle, 'calle_numero' => $value->calle_numero, 'manzana' => $value->manzana, 'departamento' => $value->departamento, 'localidad' => $value->localidad, 'alumno_id' => $value->alumno_id, 'ciclo_inscripcion' => $value->ciclo_inscripcion, 'ciclolectivo_id' => $value->ciclolectivo_id, 'carrera_id' => $value->carrera_id, 'inscripcion_id' => $value->inscripcion_id, 'fechaingreso' => $value->fechaingreso, 'activo' => $value->activo];
                            }
                        }
                    }
                }

                foreach ($inscripciones as $value) {
                    $detalle_matricula = DetalleMatriculaPago::whereRaw('inscripcion_id = '. $value->inscripcion_id .' AND matricula_id = '. $value->matricula_id)->first();

                    $ciclo_inscripcion = CicloLectivo::find($value->ciclo_inscripcion)->descripcion;
                    $ciclo_matricula = CicloLectivo::find($value->ciclolectivo_id)->descripcion;

                    if ($detalle_matricula) {
                        if ($ciclo_matricula > $ciclo_inscripcion) {
                            if ($value->activo == 0) {
                                $becados[] = ['persona_id' => $value->persona_id, 'nombre' => $value->nombre, 'apellido' => $value->apellido, 'nrodocumento' => $value->nrodocumento, 'sexo' => $value->sexo, 'barrio' => $value->barrio, 'calle' => $value->calle, 'calle_numero' => $value->calle_numero, 'manzana' => $value->manzana, 'departamento' => $value->departamento, 'localidad' => $value->localidad, 'alumno_id' => $value->alumno_id, 'ciclo_inscripcion' => $value->ciclo_inscripcion, 'ciclolectivo_id' => $value->ciclolectivo_id, 'carrera_id' => $value->carrera_id, 'inscripcion_id' => $value->inscripcion_id, 'fechaingreso' => $value->fechaingreso, 'activo' => $value->activo];
                            }
                        }
                    }
                }
            }

            $carrera = Carrera::find($carrera_id)->carrera;
            $ciclos = CicloLectivo::find($ciclo_id)->descripcion;
            $fechahoy = FechaHelper::getFechaImpresion(date("Y-m-d"));
     
            foreach ($becados as $value) {
                $telefono = '';
                $email = '';
                $fechaingreso = FechaHelper::getFechaImpresion($value['fechaingreso']);
                //$value['fechaingreso'] = $fechaingreso;
                $contactos = ContactoPersona::where('persona_id', '=', $value['persona_id'])->get();

                foreach ($contactos as $contacto) {
                    if ($contacto->contacto_id == 1) {
                        $telefono = $contacto->descripcion;
                    } else if($contacto->contacto_id == 3) {
                        $email = $contacto->descripcion;
                    }
                }

                /*$value['telefono'] = $telefono;
                $value['email'] = $email;*/
                $beca = Beca::whereRaw('alumno_id = '.$value['alumno_id'].' AND carrera_id = '.$value['carrera_id'].' AND ciclolectivo_id = '.$value['ciclolectivo_id'])->get();

                if (count($beca) > 0) {
                    $beca = 1;
                } else {
                    $beca = 0;
                }

                //$becado->becado = $beca;

                $becado[] = ['persona_id' => $value['persona_id'], 'nombre' => $value['nombre'], 'apellido' => $value['apellido'], 'nrodocumento' => $value['nrodocumento'], 'sexo' => $value['sexo'], 'barrio' => $value['barrio'], 'calle' => $value['calle'], 'calle_numero' => $value['calle_numero'], 'manzana' => $value['manzana'], 'departamento' => $value['departamento'], 'localidad' => $value['localidad'], 'alumno_id' => $value['alumno_id'], 'ciclolectivo_id' => $value['ciclolectivo_id'], 'carrera_id' => $value['carrera_id'], 'inscripcion_id' => $value['inscripcion_id'], 'fechaingreso' => $fechaingreso, 'activo' => $value['activo'], 'telefono' => $telefono, 'email' => $email, 'becado' => $beca];
            }
        }
        
        $pdf = PDF::loadView(
            'informes.pdf.becadosactivosbajas',
            [
              'becados' => $becado,
              'carrera' => $carrera,
              'ciclos'   => $ciclos,
              'fechahoy' => $fechahoy
            ]
        );
        return $pdf->setOrientation('landscape')->stream();

    }

    public function postInformebecadosporcarrera()
    {
        $carrera_id = Input::get('carrera');
        $ciclo_id = Input::get('ciclo');
        //$carrera_id = 11;

        $becados = Beca::getAlumnosBecadosPorCarreraCiclo($carrera_id, $ciclo_id);//getAlumnosBecadosPorCarrera($carrera_id);

        foreach ($becados as $becado) {
            $contactos = ContactoPersona::where(
                'persona_id', '=', $becado->persona_id)->get();
            $becado->contactos = $contactos;
        }

        return Response::json($becados);
    }

    public function postInformebecadospordni()
    {
        $dni = Input::get('filtro');
        //$dni = '25.228.692';

        $becados = Beca::getAlumnosBecadosPorDNI($dni);

        foreach ($becados as $becado) {
            $contactos = ContactoPersona::where(
                'persona_id', '=', $becado->persona_id)->get();
            $becado->contactos = $contactos;
        }

        return Response::json($becados);
    }

    public function postInformebecadosporapellido()
    {
        $apellido = Input::get('filtro');
        //$apellido = 'a';

        $becados = Beca::getAlumnosBecadosPorApellido($apellido);

        foreach ($becados as $becado) {
            $contactos = ContactoPersona::where(
                'persona_id', '=', $becado->persona_id)->get();
            $becado->contactos = $contactos;
        }

        return Response::json($becados);
    }

    public function getPdfactivosbecadosporcarrera()
    {
        $carrera_id = Input::get('carrera');

        $activos = AlumnoCarrera::getDatosInscripcionesPorCarrera($carrera_id);

        $carrera = Carrera::find($carrera_id);
        $carrera = (empty($carrera)) ? '' : $carrera->carrera;

        foreach ($activos as $activo) {
            $becados = Beca::where(
                'alumno_id', '=', $activo->alumno_id)->get();
            $activo->becados = $becados;
        }

        foreach ($activos as $activo) {
            $contactos = ContactoPersona::where(
                'persona_id', '=', $activo->persona_id)->get();
            $activo->contactos = $contactos;
        }
        
        $pdf = PDF::loadView(
            'informes.pdf.activosbecadosporcarrera',
            [
              'activos' => $activos,
              'carrera' => $carrera
            ]
        );
        return $pdf->setOrientation('landscape')->stream();

    }

    public function getPdfbecadosporcarrera()
    {
        $carrera_id = Input::get('carrera');
        $ciclo_id = Input::get('ciclo');

        $becados = Beca::getAlumnosBecadosPorCarreraCiclo($carrera_id, $ciclo_id);//getAlumnosBecadosPorCarrera($carrera_id);

        $carrera = Carrera::find($carrera_id);
        $carrera = (empty($carrera)) ? '' : $carrera->carrera;

        foreach ($becados as $becado) {
            $contactos = ContactoPersona::where(
                'persona_id', '=', $becado->persona_id)->get();
            $becado->contactos = $contactos;
        }

        $ciclo = CicloLectivo::find($ciclo_id)->descripcion;

        $pdf = PDF::loadView(
            'informes.pdf.becadosporcarrera',
            [
              'becados' => $becados,
              'carrera' => $carrera,
              'ciclo'   => $ciclo
            ]
        );
        return $pdf->setOrientation('landscape')->stream();

    }

    public function getPdfbecadosporfiltro()
    {
        $filtro = Input::get('filtro');
        $valor = Input::get('valor');

        if ($filtro == 1) {
            // DNI
            $becados = Beca::getAlumnosBecadosPorDNI($valor);
        } elseif ($filtro == 2) {
            // APELLIDO
            $becados = Beca::getAlumnosBecadosPorApellido($valor);
        }

        foreach ($becados as $becado) {
            $contactos = ContactoPersona::where(
                'persona_id', '=', $becado->persona_id)->get();
            $becado->contactos = $contactos;
        }

        $pdf = PDF::loadView(
            'informes.pdf.becadosporfiltro',
            ['becados' => $becados]
        );
        return $pdf->setOrientation('landscape')->stream();

    }

    public function getInformealumnosporciclolectivo()
    {        
        $organizaciones = Organizacion::lists('nombre', 'id');

        array_unshift($organizaciones, 'Seleccionar');

        return View::make('informes/alumnos_por_ciclo')
            ->with('menu', ModulosHelper::MENU_INFORMES)
            ->with('submenu', ModulosHelper::SUBMENU_INFORMES_ALUMNOS)
            ->with('organizaciones', $organizaciones)
            ->with('leer', Session::get('INFORME_ALUMNOS_LEER'))
            ->with('editar', Session::get('INFORME_ALUMNOS_EDITAR'))
            ->with('imprimir', Session::get('INFORME_ALUMNOS_IMPRIMIR'))
            ->with('eliminar', Session::get('INFORME_ALUMNOS_ELIMINAR'));
    }

    public function postObtenerinscripcioncontacto()
    {
        $ciclo = Input::get('ciclo');
        $carrera = Input::get('carrera');

        $contactos = AlumnoCarrera::getInscripcionesconcontacto($ciclo, $carrera);

        if (count($contactos) == 0)
            $contactos = self::NO_HAY_INSCRITOS;

        return Response::json($contactos);
    }

    public function getInformecontactospdf()
    {
        $ciclo         = Input::get('filtro');
        $carrera      = Input::get('carrera');
        $nombrecarrera  = Input::get('nombrecarrera');
        
        $inscripciones = AlumnoCarrera::getInscripciones($ciclo, $carrera);
        //$contactos = AlumnoCarrera::getInscripcionesconcontacto($ciclo, $carrera);

        foreach ($inscripciones as $inscripcion) {
            $contactos = ContactoPersona::where(
                'persona_id', '=', $inscripcion->persona_id)->get();
            $inscripcion->contactos = $contactos;
        }
//highlight_string(var_export($inscripciones, true));
//exit();
        $pdf = PDF::loadView(
            'informes.pdf.alumnosporciclolectivo',
            [
                'alumnos' => $inscripciones,
                'nombrecarrera' => $nombrecarrera
            ]
        );
        return $pdf->setOrientation('landscape')->stream();

    }

    public function getInformeauditoriaalumnos()
    {
        $alumnosall = Alumno::all();

        $i = 0;
        foreach ($alumnosall as $alumno) {
            $persona = $alumno->persona;

            $apeynom = $persona->apellido . ', ' . $persona->nombre;
            $dni = $persona->nrodocumento;

            $fecha_alta = FechaHelper::getFechaImpresion($alumno->fecha_alta);
            $fecha_modi = FechaHelper::getFechaImpresion($alumno->fecha_modi);

            $alumnos[$i] = ['apeynom'=>$apeynom, 'dni'=>$dni, 'usuario_alta'=>$alumno->usuario_alta, 'fecha_alta'=>$fecha_alta,
                                'usuario_modi'=>$alumno->usuario_modi, 'fecha_modi'=>$fecha_modi];
            $i++;
        }
        //highlight_string(var_export($alumnos, true));
        //exit();

        $pdf = PDF::loadView(
            'informes.pdf.auditoriaalumnos',
            [
                'alumnos' => $alumnos
            ]
        );
        return $pdf->setOrientation('landscape')->stream();

    }

    /*
    | FIN DE METODOS PARA INFORMES DE ALUMNOS
    */    
}

//PARA MANEJAR LOS ERRORES DE findOrFail
App::error(function(ModelNotFoundException $e)
{
    return Response::view('errors.404Alumnos', array(), 404);
});
