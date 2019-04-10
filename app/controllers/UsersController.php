<?php
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UsersController extends BaseController
{
	const OPERACION_EXITOSA = 1;
    const OPERACION_FALLIDA = 2;
    const OPERACION_CANCELADA = 3;
    const OPERACION_INFO = 4;
    const IMG_PATH = 'alumnos/img-perfil/';
    const IMG_PERFIL_WIDTH = 400;
    const IMG_WIDTH = 800;

    public function getIndex()
    {
        return Redirect::to('usuarios/listado');
    }

	public $rules = [
		'create' => [			
			'apellido'     	=> 'required',
			'nombre'       	=> 'required',
			'nrodocumento' 	=> 'required',
			'usuario'      	=> 'required',
			'email'        	=> 'email',
			'password'     	=> 'required|min:6'
		],
		'update' => [
			'apellido'     	=> 'required',
			'nombre'       	=> 'required',
			'nrodocumento' 	=> 'required',
			'usuario'      	=> 'required',
			'email'        	=> 'email'
		]
	]; 

	public $messages = [
		'create' => [
			'apellido.required'		=>	'El apellido es obligatorio.',
			'nombre.required'		=>	'El nombre es obligatorio.',
			'nrodocumento.required'	=>	'El documento es obligatorio.',
			'usuario.required'		=>	'El usuario es obligatorio.',
			'email.required'		=>	'El correo es obligatorio.',
			'email.email'			=>	'No tiene formato de correo.',
			'password.required'		=>	'El password es obligatorio.',
			'password.min'			=>	'Mínimo 6 caracteres.',
		],
		'update' => [
			'apellido.required'		=>	'El apellido es obligatorio.',
			'nombre.required'		=>	'El nombre es obligatorio.',
			'nrodocumento.required'	=>	'El documento es obligatorio.',
			'usuario.required'		=>	'El usuario es obligatorio.',
			'email.required'		=>	'El correo es olbigatorio.',
			'email.email'			=>	'No tiene formato de correo.'
		]
	];

	public function getEditar($id)
	{
		$user = User::find($id);
		
		if (!$user) {
            Session::flash('message', 'EL USUARIO ASOCIADO NO EXISTE.');
            Session::flash('message_type', self::OPERACION_CANCELADA);
            return Redirect::to('usuarios/listado');
        }

		$persona = DB::table('personas')->where('nrodocumento', '=', '36.015.610')->first();	
		
		$user = User::with('Persona')->find($id);

		$organizaciones	= Organizacion::lists('nombre', 'id');
		$tipodocumento 	= TipoDocumento::lists('descripcion', 'id'); 
		
		//highlight_string(var_export($user,true));
		//exit();

		return View::make('seguridad.usuarios.edit',[
			'user' => $user, 
			'tipodocumento'	=> $tipodocumento,
			'organizaciones'=> $organizaciones
			])
			->with('menu', ModulosHelper::MENU_SEGURIDAD)
            ->with('submenu', ModulosHelper::SUBMENU_SEGURIDAD_USUARIOS)
            ->with('leer', Session::get('USUARIO_LEER'))
            ->with('editar', Session::get('USUARIO_EDITAR'))
            ->with('imprimir', Session::get('USUARIO_IMPRIMIR'))
            ->with('eliminar', Session::get('USUARIO_ELIMINAR'));

	}

	/*public function postUpdate()
	{
		if ($validator->fails()) {
            Session::flash('message', 'ERROR AL INTENTAR CREAR UN USUARIO.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('usuarios/crear')
                ->withErrors($validator)
                ->withInput();
        } else {

			$persona = new Persona();
			$persona->nombre           = trim(Input::get("txtapellido"));
			$persona->apellido         = trim(Input::get("txtapellido"));
			$persona->tipodocumento_id = Input::get("tipodocumento");
			$persona->nrodocumento     = trim(Input::get("txtdocumento"));

			//$persona->save();

			$user = new User();		
		
			$user->nrodocumento = $persona->nrodocumento;
			$user->email        = trim(Input::get("txtcorreo"));
			$user->usuario      = strtolower(trim(Input::get("txtusuario")));
			$user->password     = Hash::make(trim(Input::get("txtpass")));
			$user->activo       = (Input::get('usuarioactivo')) ? 1 : 0;

			$user->save();

			Session::flash('message', 'DOCENTE CREADO CON ÉXITO!');
            Session::flash('message_type', self::OPERACION_EXITOSA);
            return Redirect::to('usuarios/editar/'.$user->id);
		}
	}*/

	public function getListado()
	{		
		$organizaciones = Organizacion::lists('nombre', 'id');

		array_unshift($organizaciones, 'Seleccionar');

		$usuarios = array();

		return View::make('seguridad.usuarios.listado',['organizaciones' => $organizaciones, 'usuarios' => $usuarios])
            ->with('menu', ModulosHelper::MENU_SEGURIDAD)
            ->with('submenu', ModulosHelper::SUBMENU_SEGURIDAD_USUARIOS)
            ->with('leer', Session::get('USUARIO_LEER'))
            ->with('editar', Session::get('USUARIO_EDITAR'))
            ->with('imprimir', Session::get('USUARIO_IMPRIMIR'))
            ->with('eliminar', Session::get('USUARIO_ELIMINAR'));
	}

	public function postBorrar()
	{
		$idusuario 		= Input::get('idUsuarioHidden');
		$idOrganizacion = Input::get('idOrganizacionHidden');

		$usuario = User::findOrFail($idusuario);

		$consul = $usuario->perfiles;
		
		$cant = count($consul);

        if ($cant > 0) {
            Session::flash('message', 'NO SE PUEDE ELIMINAR EL USUARIO SELECCIONADO, TIENE PERFILES ASOCIADOS.');
            Session::flash('message_type', self::OPERACION_CANCELADA);
            return Redirect::to('usuarios/listado');
        } else {

			$usuario->organizaciones()->detach($idOrganizacion);


			foreach ($usuario->perfiles as $perfil) {
				$usuario->perfiles()->detach($perfil->pivot->perfil_id);	
			}

			$usuario->delete();

			$organizaciones = Organizacion::lists('nombre', 'id');
			array_unshift($organizaciones, 'Seleccionar');

			$usuarios = Organizacion::find($idOrganizacion)->users;
			
			return View::make('seguridad.usuarios.listado',['organizaciones' => $organizaciones, 'usuarios' => $usuarios])
	            ->with('menu', ModulosHelper::MENU_SEGURIDAD)
	            ->with('submenu', ModulosHelper::SUBMENU_SEGURIDAD_USUARIOS)
	            ->with('organizacionid', $idOrganizacion)
	            ->with('leer', Session::get('USUARIO_LEER'))
	            ->with('editar', Session::get('USUARIO_EDITAR'))
	            ->with('imprimir', Session::get('USUARIO_IMPRIMIR'))
	            ->with('eliminar', Session::get('USUARIO_ELIMINAR'));
	    }
	}

	public function postListado()
	{
		$idOrganizacion = Input::get('organizacion');

		if (!$idOrganizacion){
			Session::flash('message', 'NO SE HA SELECCIONADO UNA ORGANIZACION!');
        	Session::flash('message_type', self::OPERACION_CANCELADA);
			return Redirect::to('usuarios/listado');
		}

		$organizaciones = Organizacion::lists('nombre', 'id');

		array_unshift($organizaciones, 'Seleccionar');
		//TODAVÍA NO FUNCIONA EL FILTRO TRAE TODOS LOS USUARIOS
		$organizacion = Organizacion::find($idOrganizacion);

		if (!$organizacion) {
            Session::flash('message', 'LA ORGANIZACION NO POSEE USUARIOS ASOCIADOS.');
            Session::flash('message_type', self::OPERACION_CANCELADA);
            return Redirect::to('usuarios/listado');
        }

        $usuarios = $organizacion->users;

		return View::make('seguridad.usuarios.listado',['organizaciones' => $organizaciones, 'usuarios' => $usuarios])
            ->with('menu', ModulosHelper::MENU_SEGURIDAD)
            ->with('submenu', ModulosHelper::SUBMENU_SEGURIDAD_USUARIOS)
            ->with('organizacionid', $idOrganizacion)
            ->with('leer', Session::get('USUARIO_LEER'))
            ->with('editar', Session::get('USUARIO_EDITAR'))
            ->with('imprimir', Session::get('USUARIO_IMPRIMIR'))
            ->with('eliminar', Session::get('USUARIO_ELIMINAR'));
	}	

	public function getCrear()
	{
		
		return View::make('seguridad.usuarios.nuevo',[
			'tipodocumento' => TipoDocumento::lists('descripcion', 'id'),
			'organizaciones' => Organizacion::lists('nombre', 'id')
		])->with('menu', ModulosHelper::MENU_SEGURIDAD)
          ->with('submenu', ModulosHelper::SUBMENU_SEGURIDAD_USUARIOS);
			
	}

	public function getAsignaperfil($id)
	{
		$user = User::find($id);		

		$idorg = $user->organizaciones->first()->id;


		if (0 == $user->perfiles->count()) { //no tiene perfil asignado		
			$profiles = null;
			$fullName = $user->persona->nombre . ' ' . $user->persona->apellido;
		} else {
			foreach ($user->perfiles as $perfil)
			{
		    	$profiles[] = $perfil->pivot->perfil_id;
			}
			$fullName = $user->persona->nombre . ' ' . $user->persona->apellido;	//hghhg		
		}		
		
		/*ahora falta como usar el metodo detach para remover un perfil */

		return View::make('seguridad.usuarios.asignaperfil', [
			'organizaciones' => Organizacion::lists('nombre', 'id'),
			'perfiles'		 => Perfil::where('organizacion_id','=',$idorg)->lists('perfil', 'id'),
            'menu'           => ModulosHelper::MENU_SEGURIDAD,
            'submenu'        => ModulosHelper::SUBMENU_SEGURIDAD_USUARIOS,
            'profiles'       => $profiles,
            'nombre'         => $fullName,
            'usuario'        => $user->usuario,
            'id'             => $user->id
        ])
            ->with('leer', Session::get('USUARIO_LEER'))
            ->with('editar', Session::get('USUARIO_EDITAR'))
            ->with('imprimir', Session::get('USUARIO_IMPRIMIR'))
            ->with('eliminar', Session::get('USUARIO_ELIMINAR'));
	}

	public function postAsignarperfil()
	{
		
		$id = Input::get("userid");
		$perfiles = Input::get("perfiles");
		
		$user = User::find($id);

		foreach ($user->perfiles as $perfil)
		{
	    	$profiles[] = $perfil->pivot->perfil_id;
		}

		if (0 != $user->perfiles->count()) {
			$user->perfiles()->detach();	
		}
		if ($perfiles != null) {
			$user->perfiles()->attach($perfiles);
		}
		

		Session::flash('message', 'PERFIL ASIGNADO CON ÉXITO!');
        Session::flash('message_type', self::OPERACION_EXITOSA);
		return Redirect::to('usuarios/asignaperfil/' . $user->id)->withInput();	

	}

	public function postGuardar()
	{

		$vdoc = str_replace(".", "", trim(Input::get("txtdocumento")));

		$data = [			
			'apellido'     => trim(Input::get("txtapellido")),
			'nombre'       => trim(Input::get("txtnombre")),
			'nrodocumento' => $vdoc,
			'usuario'      => strtolower(trim(Input::get("txtusuario"))),
			'password'     => trim(Input::get("txtpass")),
			'email'        => trim(Input::get("txtcorreo"))
		];
		
		/** FUNCIONES PARA ENVIAR UNA PASS ALEATORIA POR MAIL AL USUARIO AL DAR DE ALTA
		 * $userMail = Input::get("txtcorreo");		
		 *
		 *$myarray[0]['email'];	
		 *
		*$ramdomPass = Util::LlaveTemporal(6); //pass aleatoria para enviar al user
		*
		*Mail::send('emails.nuevouser', array('pass' => $ramdomPass), function($message) use ($userMail)
		*{			
		*	$fullName = Input::get('txtnombre') . ' ' .  Input::get('txtapellido');
		*
		*	$message->to($userMail, $fullName)->subject('Su contraseña ISS');
		*});	
		*
		*	//Hash::make($pass);
		*	//if (preg_match('#[0-9]#',$str))
		*
		*/		


		$validator = Validator::make($data, $this->rules['create'] , $this->messages['create']);

		if ($validator->fails()) {
            Session::flash('message', 'ERROR AL INTENTAR CREAR UN USUARIO.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('usuarios/crear')
                ->withErrors($validator)
                ->withInput();
        } else {

            $fotoperfil = Input::file('fotoperfil');

            if ($fotoperfil) {

                $extension_valida = ImagenHelper::extensionValida($fotoperfil->getClientOriginalName());

                if (!$extension_valida) {
                    Session::flash('message', 'LA IMAGEN DEBE SER DEL TIPO PNG/JPG/GIF.');
                    Session::flash('message_type', self::OPERACION_FALLIDA);
                    return Redirect::to('usuarios/crear');
                }
            }

			$persona = new Persona();
			$persona->nombre           = trim(Input::get("txtnombre"));
			$persona->apellido         = trim(Input::get("txtapellido"));
			$persona->tipodocumento_id = Input::get("tipodocumento");
			$persona->nrodocumento     = trim(Input::get("txtdocumento"));
            $persona->usuario_alta     = Auth::user()->usuario;
            $persona->fecha_alta       = date('Y-m-d');

			$persona->save();

			$user = new User();		
		
			$user->nrodocumento = $persona->nrodocumento;
			$user->email        = trim(Input::get("txtcorreo"));
			$user->usuario      = strtolower(trim(Input::get("txtusuario")));
			$user->password     = Hash::make(trim(Input::get("txtpass")));
			$user->activo       = (Input::get('usuarioactivo')) ? 1 : 0;
			$user->persona_id 	= $persona->id;

            if ($fotoperfil) {
                $filename = $persona->id . '_' . $persona->nrodocumento . '.jpg';
                $user->foto = $filename;
            }

            $user->usuario_alta = Auth::user()->usuario;
            $user->fecha_alta   = date('Y-m-d');

			$user->save();

			$organizacion = Input::get("organizaciones");
			$user->organizaciones()->attach($organizacion);

            if ($fotoperfil) {
                $personas = Persona::find($persona->id);
                $personas->foto = $filename;
                $personas->save();
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

			Session::flash('message', 'USUARIO CREADO CON ÉXITO!');
            Session::flash('message_type', self::OPERACION_EXITOSA);
            return Redirect::to('usuarios/editar/'.$user->id);
			
		}

		
	}


	public function postUpdate()
	{

		$usrid 		= Input::get('userid');
		$idpersona 	= Input::get('idpersona');

		$user 		= User::findOrFail($usrid);

		$vdoc 		= str_replace(".", "", trim(Input::get("txtdocumento")));

		$data = [			
			'apellido'     => trim(Input::get("txtapellido")),
			'nombre'       => trim(Input::get("txtnombre")),
			'nrodocumento' => $vdoc,
			'usuario'      => strtolower(trim(Input::get("txtusuario"))),
			'email'        => trim(Input::get("txtcorreo"))
		];
		
		/** FUNCIONES PARA ENVIAR UNA PASS ALEATORIA POR MAIL AL USUARIO AL DAR DE ALTA
		 * $userMail = Input::get("txtcorreo");		
		 *
		 *$myarray[0]['email'];	
		 *
		*$ramdomPass = Util::LlaveTemporal(6); //pass aleatoria para enviar al user
		*
		*Mail::send('emails.nuevouser', array('pass' => $ramdomPass), function($message) use ($userMail)
		*{			
		*	$fullName = Input::get('txtnombre') . ' ' .  Input::get('txtapellido');
		*
		*	$message->to($userMail, $fullName)->subject('Su contraseña ISS');
		*});	
		*
		*	//Hash::make($pass);
		*	//if (preg_match('#[0-9]#',$str))
		*
		*	
		*/

		$validator = Validator::make($data, $this->rules['update'] , $this->messages['update']);

		if ($validator->fails()) {
            Session::flash('message', 'ERROR AL INTENTAR MODIFICAR EL USUARIO.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('usuarios/editar/'.$usrid)
                ->withErrors($validator)
                ->withInput();
        } else {

            $fotoperfil = Input::file('fotoperfil');

            if ($fotoperfil) {

                $extension_valida = ImagenHelper::extensionValida($fotoperfil->getClientOriginalName());

                if (!$extension_valida) {
                    Session::flash('message', 'LA IMAGEN DEBE SER DEL TIPO PNG/JPG/GIF.');
                    Session::flash('message_type', self::OPERACION_FALLIDA);
                    return Redirect::to('usuarios/editar/' . $usrid);
                }
            }

			$persona = Persona::findOrFail($idpersona);
			$persona->nombre           = trim(Input::get("txtnombre"));
			$persona->apellido         = trim(Input::get("txtapellido"));
			$persona->tipodocumento_id = Input::get("tipodocumento");
			$persona->nrodocumento     = trim(Input::get("txtdocumento"));
            $persona->usuario_modi	   = Auth::user()->usuario;
            $persona->fecha_modi       = date('Y-m-d');

			$persona->save();

		
			$user->nrodocumento = $persona->nrodocumento;
			$user->email        = trim(Input::get("txtcorreo"));
			$user->usuario      = strtolower(trim(Input::get("txtusuario")));
			if (!empty(Input::get("txtpass")))
			{
				$user->password     = Hash::make(trim(Input::get("txtpass")));
			}
			$user->activo       = (Input::get('usuarioactivo')) ? 1 : 0;
			$user->persona_id 	= $persona->id;
            $user->usuario_modi = Auth::user()->usuario;
            $user->fecha_modi   = date('Y-m-d');

            if ($fotoperfil) {
                $filename = $persona->id . '_' . $persona->nrodocumento . '.jpg';
                $user->foto = $filename;
            }

			$user->save();

			$organizacion = Input::get("organizaciones");
			$user->organizaciones()->detach();
			$user->organizaciones()->attach($organizacion);

            if ($fotoperfil) {
                $personas = Persona::find($persona->id);
                $personas->foto = $filename;
                $personas->save();
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

			Session::flash('message', 'USUARIO MODIFICADO CON ÉXITO!');
            Session::flash('message_type', self::OPERACION_EXITOSA);
            return Redirect::to('usuarios/editar/'.$user->id);
			
		}

		
	}


	public function ValidateData(Array $data)
	{

	}


	public function postCompruebausuario()
	{
		$usr = Input::get('usuario');

		$data = User::where('usuario', '=', $usr)->get();

		if (count($data)==1)
		{
			return Response::json(array('usuario' => true));
		}
		else
		{
			return Response::json(array('usuario' => false));
		}
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

	public function getImprimirusuarios()/*PDF*/
	{
		$idOrganizacion = Input::get('organizacion');

		if (!$idOrganizacion){
			Session::flash('message', 'NO SE HA SELECCIONADO UNA ORGANIZACION!');
        	Session::flash('message_type', self::OPERACION_CANCELADA);
			return Redirect::to('usuarios/listado');
		}

		$organizaciones = Organizacion::lists('nombre', 'id');

		array_unshift($organizaciones, 'Seleccionar');
		//TODAVÍA NO FUNCIONA EL FILTRO TRAE TODOS LOS USUARIOS
		$organizacion = Organizacion::find($idOrganizacion);

		if (!$organizacion) {
            Session::flash('message', 'LA ORGANIZACION NO POSEE USUARIOS ASOCIADOS.');
            Session::flash('message_type', self::OPERACION_CANCELADA);
            return Redirect::to('usuarios/listado');
        }

        $usuarios = $organizacion->users;

        $pdf = PDF::loadView('informes.pdf.usuarios', ['organizaciones'=>$organizaciones, 'usuarios'=>$usuarios]);
        return $pdf->setOrientation('landscape')->stream();
	}	

	
}

//PARA MANEJAR LOS ERRORES DE findOrFail
App::error(function(ModelNotFoundException $e)
{
    return Response::view('errors.404', array(), 404); 
});