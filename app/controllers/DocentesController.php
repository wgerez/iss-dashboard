<?php 

class DocentesController extends BaseController {
    private $_data;
    private $_messages;
    private $_rules;

    const OPERACION_EXITOSA = 1;
    const OPERACION_FALLIDA = 2;
    const OPERACION_CANCELADA = 3;
    const OPERACION_INFO = 4;
    const NO_EXISTE_DOCENTE = 5;
    const IMG_PATH = 'alumnos/img-perfil/';
    const IMG_DOC_PATH = 'docentes/documentos/';
    const IMG_PERFIL_WIDTH = 400;
    const IMG_WIDTH = 800;    

    public function getIndex()
    {
        return Redirect::to('docentes/listado');
    }

    public function getListado()
    {
        $docentes = Docente::getListado();

        return View::make('docentes.listado')
            ->with('docentes', $docentes)
            ->with('menu', ModulosHelper::MENU_GESTION_ACADEMICA)
            ->with('submenu', ModulosHelper::SUBMENU_DOCENTES)
            ->with('leer', Session::get('DOCENTE_LEER'))
            ->with('editar', Session::get('DOCENTE_EDITAR'))
            ->with('imprimir', Session::get('DOCENTE_IMPRIMIR'))
            ->with('eliminar', Session::get('DOCENTE_ELIMINAR'));
    }
	
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
        $titulosHabilitantes = TituloHabilitante::lists('descripcion', 'id');
        $organismosHabilitantes = OrganismoHabilitante::lists('descripcion', 'id');

        array_unshift($titulosHabilitantes, 'Seleccionar');
        array_unshift($organismosHabilitantes, 'Seleccionar');

        return View::make('docentes.nuevo', array(
            'arrEstadoCivil' => $arrEstadoCivil,
            'arrTipoDocumento' => $arrTipoDocumento,
            'arrPais' => $arrPais,
            'arrProvincia' => $arrProvincia,
            'arrDepartamento' => $arrDepartamento,
            'arrLocalidad' => $arrLocalidad,
            'arrBarrio' => $arrBarrio,
            'arrContacto' => $arrContacto,
            'titulosHabilitantes' => $titulosHabilitantes,
            'organismosHabilitantes' => $organismosHabilitantes
        ))->with('menu', ModulosHelper::MENU_GESTION_ACADEMICA)
          ->with('submenu', ModulosHelper::SUBMENU_DOCENTES) ;
    }
    /**
     * refactoring en otros controller 
     * ver view::Make pase de datos 
     */

    public function getEditar($id)
    {

        $arrTipoDocumento = TipoDocumento::lists('descripcion', 'id');
        $arrEstadoCivil = EstadoCivil::lists('descripcion', 'id');
        $arrPais = Pais::lists('descripcion', 'id');
        $arrProvincia = Provincia::lists('descripcion', 'id');
        $arrDepartamento = Departamento::lists('descripcion', 'id');
        $arrLocalidad = Localidad::lists('descripcion', 'id');
        $arrBarrio = Barrio::lists('descripcion', 'id');
        $arrTipoContacto = Contacto::lists('descripcion', 'id');
        $tituloHabilitante = TituloHabilitante::lists('descripcion', 'id');
        $organismoHabilitante = OrganismoHabilitante::lists('descripcion', 'id');


        $docente = Docente::findOrFail($id);

        $activo               = $docente->activo;
        $empleado             = $docente->empleado;
        $disertante           = $docente->disertante;
        $nroLegajoHabilitante = $docente->nrolegajohabilitante;

        $arrContactos = new ArrayObject;

        foreach ($docente->persona->contactos as $contacto) {
            $arrContactos->offsetSet($contacto->descripcion, $contacto->pivot);
        }

         //return View::make('user.profile', array('user' => $user));

        return View::make('docentes.edit', array(           
            'docente' => $docente,
            'arrTipoDocumento' => $arrTipoDocumento,
            'arrEstadoCivil' => $arrEstadoCivil,
            'arrPais' => $arrPais,
            'arrProvincia' => $arrProvincia,
            'arrDepartamento' => $arrDepartamento,
            'arrLocalidad' => $arrLocalidad,
            'arrBarrio' => $arrBarrio,
            'arrContactos' => $arrContactos,
            'arrTipoContacto' => $arrTipoContacto,
            'tituloHabilitante' => $tituloHabilitante,
            'activo' => $activo,
            'empleado' => $empleado,
            'disertante' => $disertante,
            'organismoHabilitante' => $organismoHabilitante,
            'nrolegajohabilitante' => $nroLegajoHabilitante
        ))->with('menu', ModulosHelper::MENU_GESTION_ACADEMICA)
          ->with('submenu', ModulosHelper::SUBMENU_DOCENTES)
          ->with('leer', Session::get('DOCENTE_LEER'))
          ->with('editar', Session::get('DOCENTE_EDITAR'))
          ->with('imprimir', Session::get('DOCENTE_IMPRIMIR'))
          ->with('eliminar', Session::get('DOCENTE_ELIMINAR'));
    }

    public function postUpdate()
    {

        $this->_setAttributesValidation();

        $id = Input::get('txtAlumnoId');

        $validator = Validator::make($this->_data, $this->_rules, $this->_messages);

        $nrodoc = str_replace(".", "", trim(Input::get('documento')));
        $cuil = str_replace("-", "", trim(Input::get('cuil')));

        if ($validator->fails()) {
            Session::flash('message', 'ERROR AL INTENTAR MODIFICAR LOS DATOS DEL DOCENTE.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('docentes/editar/' . $id)
                ->withErrors($validator)
                ->withInput();
        } else {

            $contactos = Input::get('contactos');
            $arrContactos = ArrayHelper::obtenerContactosSeparados($contactos);

            /* REFACTORIZAR */
            $docente = Docente::find($id);
            $persona = Persona::find($docente->persona_id);

                if (empty($docente) || empty($persona)) {
                    Session::flash('message', 'EL DOCENTE NO EXISTE EN LA BASE DE DATOS.');
                    Session::flash('message_type', self::OPERACION_CANCELADA);
                    return Redirect::to('docentes/listado');
                }

                $fotoperfil = Input::file('fotoperfil');

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

                if ($fotoperfil) {
                    $filename = $docente->persona_id . '_' . $nrodoc . '.jpg';
                    $persona->foto = $filename;
                }

                $persona->usuario_modi       = Auth::user()->usuario;
                $persona->fecha_modi         = date('Y-m-d');
            $persona->save();

                $docente->activo                   = (Input::get('docenteactivo')) ? 1 : 0;
                $docente->empleado                 = (Input::get('docenteempleado')) ? 1 : 0;
                $docente->disertante               = (Input::get('docentedisertante')) ? 1 : 0;
                $docente->nrolegajo                = $nrodoc;                
                $docente->fechaingreso             = $fecha_ingreso;
                $docente->fechaegreso              = $fecha_egreso;
                $docente->tituloHabilitante_id     = (Input::get('titulohabilitante'));
                $docente->organismoHabilitante_id  = (Input::get('organismoHabilitante'));
                $docente->nrolegajohabilitante     = (Input::get('nroLegajoHabilitante'));
                $docente->usuario_modi             = Auth::user()->usuario;
                $docente->fecha_modi               = date('Y-m-d');

                /*var_dump($docente->fechanacimiento);
                var_dump($docente->organisamoHabilitante_id);
                exit();*/

                if ($fotoperfil) {
                    $filename = $persona->id . '_' . $persona->nrodocumento . '.jpg';
                    $docente->foto = $filename;
                }

            $docente->save();

            $persona->contactos()->detach();

            // se graban los contactos
            foreach ($arrContactos as $contacto) {
                $persona->contactos()->attach(
                    $contacto['tipo'],
                    array('descripcion'=>$contacto['valor'])
                );
            }

            // se guarda la imagen
            /*if ($fotoperfil) {
                $imagen = Image::make($fotoperfil->getRealPath());
                $ancho = $imagen->width();
                if ($ancho > self::IMG_PERFIL_WIDTH) $ancho = self::IMG_PERFIL_WIDTH;
                $imagen->resize($ancho, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $imagen->save(self::IMG_PATH . $filename);
            }*/

            if ($fotoperfil) {
                $image = $fotoperfil;
                $path = self::IMG_PATH . $filename;
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                
                $personas = Persona::find($persona->id);
                $personas->foto2 = $base64;
                $personas->save();
            }

            Session::flash('message', 'LA EDICIÓN SE HA REALIZADO CON ÉXITO.');
            Session::flash('message_type', self::OPERACION_EXITOSA);
            return Redirect::to('docentes/editar/'.$docente->id);
        }
    }

    public function postShow()
    {

        
        //$items = Item::with('relation_one', 'relation_two', 'relation_three', 'and_more')->get();
        $id = Input::get('id');
        //$details = Docente::find(1)->persona;
        //User::find(1)->roles
        //User::find(1)->toJson();
        $details = Docente::with('persona')->find($id);      

        $response = [
            'nombre' => $details->persona->nombre,
            'apellido' => $details->persona->apellido,
            'foto' => $details->foto,
            'activo' => $details->activo,
            'empleado' => $details->empleado,
            'disertante' => $details->disertante
        ];
        return Response::json($response);        
    }

    public function postGuardar()
    {
        $this->_setAttributesValidation();

        $validator = Validator::make($this->_data, $this->_rules, $this->_messages);

        $nrodoc = str_replace(".", "", trim(Input::get('documento')));
        $cuil = str_replace("-", "", trim(Input::get('cuil')));

        //VALIDACION PARA QUE NO SE REPITA PERSONAS CON EL MISMO DNI
        if (Docente::whereNrolegajo($nrodoc)->first()) {
            Session::flash('message', 'YA EXISTE UNA PERSONA REGISTRADO CON ESTE DNI.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('docentes/crear')
                ->withErrors($validator)
                ->withInput();
        }
        
        $tituloHabilitante = Input::get('tituloHabilitante');
        $organismoHabilitante = Input::get('organismoHabilitante');

        if ($tituloHabilitante == 0) {
            Session::flash('message', 'ERROR AL INTENTAR GUARDAR. DEBE SELECCIONAR UN TITULO.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('docentes/crear')
                ->withErrors($validator)
                ->withInput();
        }

        if ($organismoHabilitante == 0) {
            Session::flash('message', 'ERROR AL INTENTAR GUARDAR. DEBE SELECCIONAR UN ORGANISMO HABILITANTE.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('docentes/crear')
                ->withErrors($validator)
                ->withInput();
        }

        if ($validator->fails()) {
            Session::flash('message', 'ERROR AL INTENTAR CREAR UN DOCENTE.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('docentes/crear')
                ->withErrors($validator)
                ->withInput();
        } else {

            $fotoperfil = Input::file('fotoperfil');

            $contactos = Input::get('contactos');

            $arrContactos = ArrayHelper::obtenerContactosSeparados($contactos);

            $fecha_nacimiento = FechaHelper::getFechaParaGuardar(Input::get('fechanacimiento'));
            $fecha_ingreso    = FechaHelper::getFechaParaGuardar(Input::get('fechaingreso'));
            $fecha_egreso     = FechaHelper::getFechaParaGuardar(Input::get('fechaegreso'));

            // para crear un alumno, es necesario crear antes la persona
            $persona = new Persona;
            //var_dump($persona);
            //exit();
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

           
           $docente = new Docente;
                $docente->persona_id               = $persona->id;
                $docente->nrolegajo                = $nrodoc;
                $docente->activo                   = (Input::get('docenteactivo')) ? 1 : 0;
                $docente->empleado                 = (Input::get('docentempleado')) ? 1 : 0;
                $docente->disertante               = (Input::get('docentedisertante')) ? 1 : 0;                
                $docente->fechaingreso             = $fecha_ingreso;
                $docente->fechaegreso              = $fecha_egreso;                
                $docente->tituloHabilitante_id     = (Input::get('tituloHabilitante'));
                $docente->organismoHabilitante_id  = (Input::get('organismoHabilitante'));
                $docente->nrolegajohabilitante     = (Input::get('nroLegajoHabilitante'));

                if ($fotoperfil) {
                    $filename = $persona->id . '_' . $persona->nrodocumento . '.jpg';
                    $docente->foto = $filename;                    
                } 

                $docente->usuario_alta = Auth::user()->usuario;
                $docente->fecha_alta   = date('Y-m-d');
            $docente->save();

            if ($fotoperfil) {
                $personas = Persona::find($persona->id);
                //$filename = $persona->id . '_' . $persona->nrodocumento . '.jpg';
                $personas->foto = $filename;
                $personas->save();
            } 

            foreach ($arrContactos as $contacto) {
                $persona->contactos()->attach(
                    $contacto['tipo'],
                    array('descripcion'=>$contacto['valor'])
                );
            }

            // se guarda la imagen
            /*if ($fotoperfil) {
                $imagen = Image::make($fotoperfil->getRealPath());
                $ancho = $imagen->width();
                if ($ancho > self::IMG_PERFIL_WIDTH) $ancho = self::IMG_PERFIL_WIDTH;
                $imagen->resize($ancho, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $imagen->save(self::IMG_PATH . $filename);
            }*/

            if ($fotoperfil) {
                $image = $fotoperfil;
                $path = self::IMG_PATH . $filename;
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                
                $personas = Persona::find($persona->id);
                $personas->foto2 = $base64;
                $personas->save();
            }

            // se crea el legajo
            $legajo = new DocenteLegajo;
                $legajo->docente_id    = $docente->id;
                $legajo->usuario_alta = Auth::user()->usuario;
                $legajo->fecha_alta   = date('Y-m-d');
            $legajo->save();

            //txtIdDocenteHidden

            Session::flash('message', 'DOCENTE CREADO CON ÉXITO!');
            Session::flash('message_type', self::OPERACION_EXITOSA);
            return Redirect::to('docentes/editar/'.$docente->id);
        }
    }

    public function getLegajo($id_docente)
    {
        $docente = Docente::with('persona')->with('docentelegajo')->find($id_docente);
        $doc_legajo = DocenteLegajo::whereRaw('docente_id = '.$id_docente)->first();

        if (count($doc_legajo) > 0) {
            $docente_legajo = DocenteLegajo::with('docenteslegajosdocumentos')->find($docente->docentelegajo->id);
            
            if (!$docente->docentelegajo->fechavencimientoseguro == NULL) {
                $fechavencimientoseguro = FechaHelper::getFechaImpresion($docente->docentelegajo->fechavencimientoseguro);
                $porcion = explode("/", $fechavencimientoseguro);
                $fechadesde = $porcion[2].'-'.$porcion[1].'-'.$porcion[0];
                $docente->docentelegajo->fechavencimientoseguro = $fechadesde;
            }
        } else {
            $docente_legajo = [];
        }

        return View::make('legajos.docente')
            ->with('docente', $docente)
            ->with('docente_legajo', $docente_legajo)
            ->with('menu', ModulosHelper::MENU_GESTION_ACADEMICA)
          ->with('submenu', ModulosHelper::SUBMENU_DOCENTES)
          ->with('leer', Session::get('DOCENTE_LEER'))
          ->with('editar', Session::get('DOCENTE_EDITAR'))
          ->with('imprimir', Session::get('DOCENTE_IMPRIMIR'))
          ->with('eliminar', Session::get('DOCENTE_ELIMINAR'));
    }

    /*
     * SE GUARDA POR JSON AJAX
     */
    public function postGuardaritemlegajo()
    {
        $legajo_id = Input::get('legajoId');
        $campo = Input::get('campo');
        $docente_id = Input::get('docente_id');

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

        $legajo = DocenteLegajo::find($legajo_id);

        if (count($legajo) > 0) {
            $legajo = DocenteLegajo::find($legajo_id);
        } else {
            $legajos = new DocenteLegajo;
            $legajos->docente_id = $docente_id;
            $legajos->dni = 0;
            $legajos->foto = 0;
            $legajos->partidanacimiento = 0;
            $legajos->ficha_medica = 0;
            $legajos->cuil_cuit = 0;
            $legajos->titulosecundario = 0;
            $legajos->cargos_actividades = 0;
            $legajos->tituloprofesional = 0;
            $legajos->declaracion_jurada = 0;
            $legajos->seguro = 0;
            //$legajos->fechavencimientoseguro = $fecha_vencimiento;
            $legajos->otros = 0;
            $legajos->usuario_alta = Auth::user()->usuario;
            $legajos->fecha_alta = date('Y-m-d');
            $legajos->save();

            $legajo = DocenteLegajo::whereRaw('docente_id ='.$docente_id)->first();
        }

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
                $legajo->ficha_medica = (int) Input::get('valor');
                break;

            case 'CUIL_CUIT':
                $legajo->cuil_cuit = (int) Input::get('valor');
                break;

            case 'TITULO':
                $legajo->titulosecundario = (int) Input::get('valor');
                break;

            case 'CARGOS_ACTIVIDADES':
                $legajo->cargos_actividades = (int) Input::get('valor');
                break;

            case 'TITULO_PROFESIONAL':
                $legajo->tituloprofesional = (int) Input::get('valor');
                break;

            case 'DECLARACION_JURADA':
                $legajo->declaracion_jurada = (int) Input::get('valor');
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
        $docente_id = Input::get('txtAlumnoDocumentoId');
        $tipo_documento = Input::get('tipodocumento');
        $docente_legajo_id = Input::get('txtAlumnoLegajoId');
        $imagen = Input::file('archivoadjunto');

        if ($imagen) {
            $extension_valida = ImagenHelper::extensionValida($imagen->getClientOriginalName());

            if (!$extension_valida) {
                Session::flash('message', 'EL DOCUMENTO DEBE SER DEL TIPO PNG/JPG/GIF.');
                Session::flash('message_type', self::OPERACION_FALLIDA);
                return Redirect::to('docentes/legajo/' . $docente_id);
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
            return Redirect::to('docentes/legajo/' . $docente_id)
                ->withErrors($validator);
        }

        // PRIMERO CREAMOS SI NO EXISTE EL LEGAJO
        if ($docente_legajo_id == 0) {
            $legajos = new DocenteLegajo;
            $legajos->docente_id = $docente_id;
            $legajos->dni = 0;
            $legajos->foto = 0;
            $legajos->partidanacimiento = 0;
            $legajos->ficha_medica = 0;
            $legajos->cuil_cuit = 0;
            $legajos->titulosecundario = 0;
            $legajos->cargos_actividades = 0;
            $legajos->tituloprofesional = 0;
            $legajos->declaracion_jurada = 0;
            $legajos->seguro = 0;
            $legajos->otros = 0;
            $legajos->usuario_alta = Auth::user()->usuario;
            $legajos->fecha_alta = date('Y-m-d');
            $legajos->save();

            $legajo = DocenteLegajo::whereRaw('docente_id ='.$docente_id)->first();
            $docente_legajo_id = $legajo->id;
        }
        //

        $docente_legajo_documento = new DocenteLegajoDocumento;

        if ($imagen) {
            $filename = $docente_id . '_' . $docente_legajo_id . '_' . uniqid() .  '.jpg';
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

        $docente_legajo_documento->docentelegajo_id = $docente_legajo_id;
        $docente_legajo_documento->documento = $filename;
        $docente_legajo_documento->tipodocumento = $tipo_documento;
        $docente_legajo_documento->usuario_alta = Auth::user()->usuario;
        $docente_legajo_documento->fecha_alta = date('Y-m-d');
        $docente_legajo_documento->save();

        Session::flash('message', 'DOCUMENTO GUARDADO CORRECTAMENTE.');
        Session::flash('message_type', self::OPERACION_EXITOSA);
        return Redirect::to('docentes/legajo/' . $docente_id);
    }

    public function postEditardocumento()
    {
        $documento_id = Input::get('idDocumentoHiddenModi');
        $docente_id = Input::get('txtAlumnoDocumentoModiId');
        $documento_descripcion = Input::get('txtDocumentoDescripcion');

        if (trim($documento_descripcion) == '')
            return Redirect::to('docentes/legajo/' . $docente_id);

        $documento = DocenteLegajoDocumento::find($documento_id);
        $documento->tipodocumento = $documento_descripcion;
        $documento->save();
        
        return Redirect::to('docentes/legajo/' . $docente_id);
    }

    public function postBorrardocumento()
    {
        $documento_id = Input::get('idDocumentoHidden');
        $docente_id = Input::get('txtAlumnoDocumentoId');
        $imagen = '';
        $documento = DocenteLegajoDocumento::find($documento_id);
        if ($documento) {
            $documento->delete();
            // imagen fisica
            $imagen = "docentes/documentos/" . $documento->documento;
        }
        // borro imagen fisica
        if (file_exists($imagen)) unlink($imagen);

        Session::flash('message', 'EL DOCUMENTO HA SIDO BORRADO.');
        Session::flash('message_type', self::OPERACION_EXITOSA);
        return Redirect::to('docentes/legajo/' . $docente_id);
    }

    public function postBorrar()
    {
        $id = Input::get('txtIdDocenteHidden');

        $docente = Docente::find($id);        

        Session::flash('message', 'NO ES POSIBLE BORRAR AL DOCENTE.');
        Session::flash('message_type', self::OPERACION_FALLIDA);
        return Redirect::to('docentes/listado');

        /*
        if ($this->_noSePuedeBorrar($docente)) {
            Session::flash('message', 'NO ES POSIBLE BORRAR AL DOCENTE.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('docentes/listado');
        }

        //highlight_string(var_export($alumno,true));
        //exit;

        $docente->delete();
        $docente->persona->contactos()->detach();
        $docente->persona->delete();

        Session::flash('message', 'EL DOCENTE HA SIDO BORRADA DE LA BASE DE DATOS.');
        Session::flash('message_type', self::OPERACION_EXITOSA);
        return Redirect::to('docentes/listado');
        */
    }

    public function postCompruebadni()
    {
        $doc = Input::get('documento');

        $data = User::where('nrodocumento', '=', $doc)->get();

        if (count($data)==1)
        {
            return Response::json(array('documento' => true));
        }
        else
        {
            return Response::json(array('documento' => false));
        }
    }

    //PARA OBTENER DINAMICAMENTE LOS COMBOS DE DIRECCION
    public function postLocalidades()
    {
        $id = Input::get('id');
         
        $localidades = Localidad::Localidadespordpto($id);

        return Response::json($localidades);
    }    

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

    private function _noSePuedeBorrar(Docente $docente)
    {
        return FALSE;
    }

	public function postTitulo()
	{
		//agrega un titulo habilitante en el combo de docentes
		$desc = trim(Input::get("txtDescTitle"));
		$fecha = date('Y-m-d');
        $validator = Validator::make(['desc' => $desc],['desc' => 'exists:tituloshabilitantes,descripcion']);
		if ($validator->fails()) {
			DB::insert('insert into tituloshabilitantes (descripcion, usuario_alta, fecha_alta) values (?, ?, ?)', [$desc, Auth::user()->usuario, $fecha]);
			return TituloHabilitante::lists('descripcion', 'id');
		} else {
			return Response::json(['error' => 'Ya existe el título ingresado']);
		}

	}

	public function postOrganismo()
	{
		//agrega un organismo habilitante en el combo de docentes
		$desc = trim(Input::get("txtDescOrganism"));
		$fecha = date('Y-m-d');
        $validator = Validator::make(['desc' => $desc],['desc' => 'exists:organismoshabilitantes,descripcion']);
		if ($validator->fails()) {
			DB::insert('insert into organismoshabilitantes (descripcion, usuario_alta, fecha_alta) values (?, ?, ?)', [$desc, Auth::user()->usuario, $fecha]);
			return OrganismoHabilitante::lists('descripcion', 'id');
		} else {
			return Response::json(['error' => 'Ya existe el organismo ingresado']);
		}
	}

    /*
    / INFORME DE DOCENTES
    */

    public function getInforme()
    {
        return View::make('informes/docentes')
            ->with('menu', ModulosHelper::MENU_INFORMES)
            ->with('submenu', ModulosHelper::SUBMENU_INFORMES_DOCENTES)
            ->with('leer', Session::get('INFORME_DOCENTES_LEER'))
            ->with('editar', Session::get('INFORME_DOCENTES_EDITAR'))
            ->with('imprimir', Session::get('INFORME_DOCENTES_IMPRIMIR'))
            ->with('eliminar', Session::get('INFORME_DOCENTES_ELIMINAR'));
    }

    public function getInformelistado()
    {        
        $organizaciones = Organizacion::lists('nombre', 'id');

        array_unshift($organizaciones, 'Seleccionar');

        return View::make('informes/docentes_listado')
            ->with('menu', ModulosHelper::MENU_INFORMES)
            ->with('submenu', ModulosHelper::SUBMENU_INFORMES_DOCENTES)
            ->with('organizaciones', $organizaciones)
            ->with('leer', Session::get('INFORME_DOCENTES_LEER'))
            ->with('editar', Session::get('INFORME_DOCENTES_EDITAR'))
            ->with('imprimir', Session::get('INFORME_DOCENTES_IMPRIMIR'))
            ->with('eliminar', Session::get('INFORME_DOCENTES_ELIMINAR'));
    }

    /* REFACTORING */
    /* NO FILTRA POR ORGANIZACION */
    /* VER RELACION DOCENTE-ORGANIZACION */
    public function postInformelistado()
    {        
        $idOrg = Input::get('organizacion');

        $organizaciones = Organizacion::lists('nombre', 'id');

        array_unshift($organizaciones, 'Seleccionar');

        $docentes = Docente::all();

        return View::make('informes/docentes_listado')
            ->with('menu', ModulosHelper::MENU_INFORMES)
            ->with('submenu', ModulosHelper::SUBMENU_INFORMES_DOCENTES)
            ->with('organizaciones', $organizaciones)
            ->with('organizacionseleccionada', $idOrg)
            ->with('docentes', $docentes)
            ->with('leer', Session::get('INFORME_DOCENTES_LEER'))
            ->with('editar', Session::get('INFORME_DOCENTES_EDITAR'))
            ->with('imprimir', Session::get('INFORME_DOCENTES_IMPRIMIR'))
            ->with('eliminar', Session::get('INFORME_DOCENTES_ELIMINAR'));
    }

    public function getInformepdf()
    {
        
        $idOrg = Input::get('organizacion');

        $organizaciones = Organizacion::lists('nombre', 'id');

        array_unshift($organizaciones, 'Seleccionar');
        
        $docentes = Docente::all();

        $pdf = PDF::loadView('informes.pdf.docentes', ['docentes'=>$docentes]);
        return $pdf->setOrientation('landscape')->stream();

    }  


    public function getInformeauditoriadocente() /*Pdf*/
    {
        $docentesall = Docente::all();
        $personas = Persona::all();

        $i = 0;
        foreach ($docentesall as $docente) {
            $idpers = $docente->persona_id;

            foreach ($personas as $persona) {
                if ($persona->id == $idpers) {
                    $apeynom = $persona->apellido . ', ' . $persona->nombre;
                    $dni = $persona->nrodocumento;
                }
            }

            $fecha_alta = FechaHelper::getFechaImpresion($docente->fecha_alta);
            $fecha_modi = FechaHelper::getFechaImpresion($docente->fecha_modi);

            $docentes[$i] = ['apeynom'=>$apeynom, 'dni'=>$dni, 'usuario_alta'=>$docente->usuario_alta, 'fecha_alta'=>$fecha_alta,
                                'usuario_modi'=>$docente->usuario_modi, 'fecha_modi'=>$fecha_modi];
            $i++;
        }    
        /*$docentes = Docente::all();

        $docentes = Docente::getInformeAuditoria();

        /*highlight_string(var_export($docentes,true));
        exit();*/

        $pdf = PDF::loadView('informes.pdf.docenteauditoria', ['docentes'=>$docentes]);
        return $pdf->setOrientation('landscape')->stream();

    }        
}
