<?php
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PerfilesController extends BaseController {


	private $_data;
    private $_rules;
    private $_messages;

    const OPERACION_EXITOSA = 1;
    const OPERACION_FALLIDA = 2;
    const OPERACION_CANCELADA = 3;
    const OPERACION_INFO = 4;
    const NO_TIENE_SUBMODULOS = 5;


	public function getListado()
	{
        $organizaciones = Organizacion::lists('nombre', 'id');

        array_unshift($organizaciones, 'Seleccionar');

        return View::make('seguridad.perfiles.listado')
            ->with('organizaciones', $organizaciones)
            ->with('menu', ModulosHelper::MENU_SEGURIDAD)
            ->with('submenu', ModulosHelper::SUBMENU_SEGURIDAD_PERFILES)
            ->with('leer', Session::get('PERFIL_LEER'))
            ->with('editar', Session::get('PERFIL_EDITAR'))
            ->with('imprimir', Session::get('PERFIL_IMPRIMIR'))
            ->with('eliminar', Session::get('PERFIL_ELIMINAR'));
	}

    public function postBuscar()
    {
        $idorg = Input::get('organizacion');

        if (!$idorg) {
            Session::flash('message', 'NO SE HA SELECCIONADO UNA ORGANIZACION.');
            Session::flash('message_type', self::OPERACION_CANCELADA);
            return Redirect::to('perfiles/listado');
        }

        $organizacion = Organizacion::find($idorg);

        if (!$organizacion) {
            Session::flash('message', 'LA ORGANIZACION NO POSEE USUARIOS ASOCIADOS.');
            Session::flash('message_type', self::OPERACION_CANCELADA);
            return Redirect::to('perfiles/listado');
        }

        $perfiles = $organizacion->perfiles;

        $organizaciones = Organizacion::lists('nombre', 'id');

        if (empty($perfiles)) array_unshift($organizaciones, 'Seleccionar');

        return View::make('seguridad.perfiles.listado')
            ->with('organizaciones', $organizaciones)
            ->with('idorganizacion', $idorg)
            ->with('perfiles', $perfiles)
            ->with('menu', ModulosHelper::MENU_SEGURIDAD)
            ->with('submenu', ModulosHelper::SUBMENU_SEGURIDAD_PERFILES)
            ->with('leer', Session::get('PERFIL_LEER'))
            ->with('editar', Session::get('PERFIL_EDITAR'))
            ->with('imprimir', Session::get('PERFIL_IMPRIMIR'))
            ->with('eliminar', Session::get('PERFIL_ELIMINAR'));
	}

	public function getCrear()
    {
        /*$perfil = new Perfil();
        var_dump($perfil);
exit();*/
        $organizaciones = Organizacion::lists('nombre', 'id');
        array_unshift($organizaciones, 'Seleccionar');

        return View::make('seguridad.perfiles.nuevo')
            ->with('organizaciones', $organizaciones)
            ->with('menu', ModulosHelper::MENU_SEGURIDAD)
            ->with('submenu', ModulosHelper::SUBMENU_SEGURIDAD_PERFILES)
            ->with('leer', Session::get('PERFIL_LEER'))
            ->with('editar', Session::get('PERFIL_EDITAR'))
            ->with('imprimir', Session::get('PERFIL_IMPRIMIR'))
            ->with('eliminar', Session::get('PERFIL_ELIMINAR'));
	}

    public function postGuardar()
    {
        $validator = Validator::make(
            array(
                'perfil' => Input::get('txtperfil')
            ),
            array(
                'perfil' => 'required'
            )
        );

        $organizacion = Input::get('organizacion');

        if ($organizacion == 0) {
            Session::flash('message', 'ERROR AL INTENTAR GUARDAR. DEBE SELECCIONAR UNA ORGANIZACIÓN.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('perfiles/crear');
        }

        if ($validator->fails()) {
            Session::flash('message', 'ERROR AL INTENTAR CREAR EL PERFIL.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('perfiles/crear')
                ->withErrors($validator)
                ->withInput();
        } else {

            $perfile = new Perfil();
            $perfile->organizacion_id     = Input::get('organizacion');
            $perfile->perfil              = trim(Input::get('txtperfil'));
            $perfile->descripcion         = Input::get('txtdescripcion');
            $perfile->usuario_alta        = Auth::user()->usuario;
            $perfile->fecha_alta          = date('Y-m-d');
            $perfile->save();

            Session::flash('message', 'PERFIL CREADO CON ÉXITO!');
            Session::flash('message_type', self::OPERACION_EXITOSA);
            return Redirect::to('perfiles/listado');
        }
    }

    public function postGuardarpermisos()
    {
        $id = Input::get('txt_perfil_id');
        $permisos = Input::get('permiso');

        $validator = Validator::make(
            array(
                'modulo_id' => Input::get('submodulo')
            ),
            array(
                'modulo_id' => 'required'
            )
        );

        $modulos = Input::get('submodulo');

        if ($modulos == 0) {
            Session::flash('message', 'ERROR AL INTENTAR GUARDAR. DEBE SELECCIONAR UN SUBMODULO.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('perfiles/asignapermisos/'.$id);
        }

        if ($validator->fails()) {
            Session::flash('message', 'ERROR AL INTENTAR ASIGNAR PERMISOS.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('perfiles/asignapermisos/'.$id)
                ->withErrors($validator)
                ->withInput();
        } else {
            
            $permiso = array('leer'=>0, 'editar'=>0, 'eliminar'=>0, 'imprimir'=>0);

            for ($i = 0; $i < count($permisos); $i++) {
                    if ($permisos[$i]==1) $permiso['leer'] = 1;
                    if ($permisos[$i]==2) {
                        $permiso['leer'] = 1;
                        $permiso['editar'] = 1;
                    }
                    if ($permisos[$i]==3) {
                        $permiso['leer'] = 1;
                        $permiso['eliminar'] = 1;
                    }
                    if ($permisos[$i]==4) {
                        $permiso['leer'] = 1;
                        $permiso['imprimir'] = 1;
                    }
            }

            $perfil = Perfil::findOrFail($id);

            $consul = Perfil::getExisteperfilusuario($id,$modulos);
            //$consul = $perfil->modulos->count();

            $cant = count($consul);
            $usuario = Auth::user()->usuario;
            $date = date('Y-m-d');

            if ($cant == 0) {
                /* REFACTORIZAR----- NUEVO PERMISO */
                $perfil->modulos()->attach(
                    array('modulo_id'=>$modulos),
                    array('perfil_id'=>$id, 'leer'=>$permiso['leer'], 'editar'=>$permiso['editar'],
                          'eliminar'=>$permiso['eliminar'], 'imprimir'=>$permiso['imprimir'], 
                          'usuario_alta'=>$usuario, 'fecha_alta'=>$date)
                );
                
            } else {

                $perfil->modulos()->detach(
                    array('modulo_id'=>$modulos),
                    array('perfil_id'=>$id, 'leer'=>$permiso['leer'], 'editar'=>$permiso['editar'],
                          'eliminar'=>$permiso['eliminar'], 'imprimir'=>$permiso['imprimir'], 
                          'usuario_modi'=>$usuario, 'fecha_modi'=>$date)
                );
                /* REFACTORIZAR----- MODIFICA PERMISO */
                if ($permiso['leer']==1 or $permiso['editar']==1 or $permiso['eliminar']==1 or $permiso['imprimir']==1)
                {
                    $perfil->modulos()->attach(
                        array('modulo_id'=>$modulos),
                        array('perfil_id'=>$id, 'leer'=>$permiso['leer'], 'editar'=>$permiso['editar'],
                              'eliminar'=>$permiso['eliminar'], 'imprimir'=>$permiso['imprimir'], 
                              'usuario_modi'=>$usuario, 'fecha_modi'=>$date)
                    );
                }
            }

            Session::flash('message', 'PERMISO CREADO CON ÉXITO!');
            Session::flash('message_type', self::OPERACION_EXITOSA);
            return Redirect::to('perfiles/asignapermisos/'.$id);
        }
    }

    public function getAsignapermisos($perfil_id)
    {
        $perfil = Perfil::find($perfil_id);
        $modulos = Modulo::where('padreid', '=', 0)->get();


        foreach ($modulos as $modulo) {
            $submoduloi = [];
            foreach ($perfil->modulos as $perfilmodulo) {
                if ($modulo['id'] == $perfilmodulo['padreid'])
                {
                    $submoduloi[] = ['nombre'=>$perfilmodulo['descripcion'], 'id'=>$perfilmodulo['id'], 'leer'=>$perfilmodulo['pivot']['leer'], 'editar'=>$perfilmodulo['pivot']['editar'], 'imprimir'=>$perfilmodulo['pivot']['imprimir'], 'eliminar'=>$perfilmodulo['pivot']['eliminar']];
                }
            }

            $submoduloi = $this->ordenar_por_campo($submoduloi, 'id');
            
            $modulosi[] = ['modulo'=>$modulo['descripcion'], 'id'=>$modulo['id'], 'submodulos'=>$submoduloi];
        }

       
      
        return View::make('seguridad.perfiles.asignapermisos')
            ->with('perfil', $perfil)
            ->with('modulos', $modulos)
            ->with('arbolpermisos', $modulosi)
            ->with('menu', ModulosHelper::MENU_SEGURIDAD)
            ->with('submenu', ModulosHelper::SUBMENU_SEGURIDAD_PERFILES)
            ->with('leer', Session::get('PERFIL_LEER'))
            ->with('editar', Session::get('PERFIL_EDITAR'))
            ->with('imprimir', Session::get('PERFIL_IMPRIMIR'))
            ->with('eliminar', Session::get('PERFIL_ELIMINAR'));
    }

    public function postObtenersubmodulos()
    {
        $id = Input::get('modulo_id');
    	$submodulos = Modulo::where('padreid', '=', $id)->get();


        if (!$submodulos)
            return self::NO_TIENE_SUBMODULOS;

        return Response::json($submodulos);
    }

    public function postObtenerpermisos()
    {
        $id = Input::get('submodulo_id');
        
        $idperfil = Input::get('perfil_id');

        if (!$id) {
            Session::flash('message', 'NO SE HA SELECCIONADO UN SUBMODULO.');
            Session::flash('message_type', self::OPERACION_CANCELADA);
            return Redirect::to('perfiles/asignapermisos/'.$idperfil);
        }

        $permisos = Perfil::getPermisosperfiles($id,$idperfil);
        
        if (count($permisos) == 0) {
            $permisos = [
                array('descripcion' => trim(Input::get('submod')),
                'leer' => 0,
                'editar' => 0,
                'eliminar' => 0,
                'imprimir' => 0)
            ];
        }
        //highlight_string(var_export($permisos, true));
        //exit();

        return Response::json($permisos);
    }

    public function postEliminaperfil()
    {
        $id = Input::get('idPerfilHidden');
        $perfiles = Perfil::findOrFail($id);

        $consul = $perfiles->users;

        $cant = count($consul);

        if ($cant > 0) {
            Session::flash('message', 'NO SE PUEDE ELIMINAR EL PERFIL SELECCIONADO, TIENE PERMISOS O USUARIOS ASOCIADOS.');
            Session::flash('message_type', self::OPERACION_CANCELADA);
            return Redirect::to('perfiles/listado');
        } else {

            $perfiles->users()->detach();
            $perfiles->modulos()->detach();
            $perfiles->delete();

            //$organizaciones = Organizacion::lists('nombre', 'id');

            Session::flash('message', 'EL PERFIL HA SIDO BORRADO DE LA BASE DE DATOS.');
            Session::flash('message_type', self::OPERACION_EXITOSA);
            return Redirect::to('perfiles/listado');
        }
    }

    public function getEditar($id)
    {  
        $perfiles = Perfil::find($id);
        $organizaciones = Organizacion::lists('nombre', 'id');
        
        //highlight_string(var_export($perfiles, true));
        //exit();
        return View::make('seguridad.perfiles.nuevo')
            ->with('organizaciones', $organizaciones)
            ->with('perfiles', $perfiles)
            ->with('menu', ModulosHelper::MENU_GESTION_ADMINISTRATIVA)
            ->with('submenu', ModulosHelper::SUBMENU_CARRERAS)
            ->with('leer', Session::get('PERFIL_LEER'))
            ->with('editar', Session::get('PERFIL_EDITAR'))
            ->with('imprimir', Session::get('PERFIL_IMPRIMIR'))
            ->with('eliminar', Session::get('PERFIL_ELIMINAR'));
    }

    public function postUpdateperfil()
    {
        $id = Input::get('perfilid');

        $validator = Validator::make(
            array(
                'perfil' => Input::get('txtperfil')
            ),
            array(
                'perfil' => 'required'
            )
        );
        

        if ($validator->fails()) {
            Session::flash('message', 'ERROR AL INTENTAR MODIFICAR EL PERFIL.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('perfiles/listado')
                ->withErrors($validator)
                ->withInput();
        } else {          
           
            $perfiles = Perfil::find($id);            

            $perfiles->organizacion_id     = Input::get('organizacion');
            $perfiles->perfil              = trim(Input::get('txtperfil'));
            $perfiles->descripcion         = Input::get('txtdescripcion');
            $perfiles->usuario_modi        = Auth::user()->usuario;
            $perfiles->fecha_modi          = date('Y-m-d');

            $perfiles->save();
        }

        Session::flash('message', 'LA EDICIÓN SE HA REALIZADO CON ÉXITO.');
        Session::flash('message_type', self::OPERACION_EXITOSA);
        return Redirect::to('perfiles/listado');
    }

    public function ordenar_por_campo($registros, $campo, $reversa=false)
    {
        $hash = array();
        
        foreach($registros as $registro)
        {
            $hash[$registro[$campo]] = $registro;
        }
        
        ($reversa)? krsort($hash) : ksort($hash);
        
        $registros = array();
        
        foreach($hash as $registro)
        {
            $registros []= $registro;
        }
        
        return $registros;
    }    

}

//PARA MANEJAR LOS ERRORES DE findOrFail
App::error(function(ModelNotFoundException $e)
{
    return Response::view('errors.404', array(), 404); 
});
