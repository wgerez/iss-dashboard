<?php 

class DocentesController extends BaseController {
    private $_data;
    private $_messages;
    private $_rules;

    const OPERACION_EXITOSA = 1;
    const OPERACION_FALLIDA = 2;
    const OPERACION_CANCELADA = 3;
    const OPERACION_INFO = 4;
    const IMG_PATH = 'docentes/img-perfil/';
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
            //txtIdDocenteHidden

            Session::flash('message', 'DOCENTE CREADO CON ÉXITO!');
            Session::flash('message_type', self::OPERACION_EXITOSA);
            return Redirect::to('docentes/editar/'.$docente->id);
        }
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
