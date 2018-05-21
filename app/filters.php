<?php


App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Autentificación de Usuarios
|--------------------------------------------------------------------------
*/

Route::filter('auth', function()
{
    if (Auth::guest()) return Redirect::guest('/')->with('msg', 'Debes identificarte primero.');
});


Route::filter('auth.basic', function()
{
	return Auth::basic('usuario');
});


/*
|--------------------------------------------------------------------------
| Filtro para rutas y permisos de acceso
|--------------------------------------------------------------------------
*/

Route::filter('filtroorganizacion', function()
{
	$v = 0;
    foreach (Session::get('permisos')[0] as $permiso) {
    	if ($permiso['submoduloid'] == ModulosHelper::ORGANIZACIONES_ID)
    	{
    		$v = 1;
			break;
    	}
    }

    if ($v == 0)
    {
	    Session::flash('message', 'NO TIENES ACCESO A ESTE MODULO, CONSULTA CON EL ADMINISTRADOR DEL SISTEMA.');
    	Session::flash('message_type', DashboardController::OPERACION_FALLIDA);
    	return Redirect::to('dashboard');    	
    }
});


Route::filter('filtroalumnos', function()
{
	$v = 0;
    foreach (Session::get('permisos')[0] as $permiso) {
    	if ($permiso['submoduloid'] == ModulosHelper::ALUMNOS_ID)
    	{
    		$v = 1;
			break;
    	}
    }

    if ($v == 0)
    {
	    Session::flash('message', 'NO TIENES ACCESO A ESTE MODULO, CONSULTA CON EL ADMINISTRADOR DEL SISTEMA.');
    	Session::flash('message_type', DashboardController::OPERACION_FALLIDA);
    	return Redirect::to('dashboard');    	
    }
});


Route::filter('filtrodocentes', function()
{
	$v = 0;
    foreach (Session::get('permisos')[0] as $permiso) {
    	if ($permiso['submoduloid'] == ModulosHelper::DOCENTES_ID)
    	{
    		$v = 1;
			break;
    	}
    }

    if ($v == 0)
    {
	    Session::flash('message', 'NO TIENES ACCESO A ESTE MODULO, CONSULTA CON EL ADMINISTRADOR DEL SISTEMA.');
    	Session::flash('message_type', DashboardController::OPERACION_FALLIDA);
    	return Redirect::to('dashboard');    	
    }
});


Route::filter('filtrocalendarios', function()
{
	$v = 0;
    foreach (Session::get('permisos')[0] as $permiso) {
    	if ($permiso['submoduloid'] == ModulosHelper::CALENDARIOS_ID)
    	{
    		$v = 1;
			break;
    	}
    }

    if ($v == 0)
    {
	    Session::flash('message', 'NO TIENES ACCESO A ESTE MODULO, CONSULTA CON EL ADMINISTRADOR DEL SISTEMA.');
    	Session::flash('message_type', DashboardController::OPERACION_FALLIDA);
    	return Redirect::to('dashboard');    	
    }
});

Route::filter('filtrocarreras', function()
{
	$v = 0;
    foreach (Session::get('permisos')[0] as $permiso) {
    	if ($permiso['submoduloid'] == ModulosHelper::CARRERAS_ID)
    	{
    		$v = 1;
			break;
    	}
    }

    if ($v == 0)
    {
	    Session::flash('message', 'NO TIENES ACCESO A ESTE MODULO, CONSULTA CON EL ADMINISTRADOR DEL SISTEMA.');
    	Session::flash('message_type', DashboardController::OPERACION_FALLIDA);
    	return Redirect::to('dashboard');    	
    }
});

Route::filter('filtromatriculas', function()
{
	$v = 0;
    foreach (Session::get('permisos')[0] as $permiso) {
    	if ($permiso['submoduloid'] == ModulosHelper::GESTIONMATRICULAS_ID or $permiso['submoduloid'] == ModulosHelper::PAGOMATRICULAS_ID or $permiso['submoduloid'] == ModulosHelper::BECAS_ID)
    	{
    		$v = 1;
			break;
    	}
    }

    if ($v == 0)
    {
	    Session::flash('message', 'NO TIENES ACCESO A ESTE MODULO, CONSULTA CON EL ADMINISTRADOR DEL SISTEMA.');
    	Session::flash('message_type', DashboardController::OPERACION_FALLIDA);
    	return Redirect::to('dashboard');    	
    }
});

Route::filter('filtroperfiles', function()
{
	$v = 0;
    foreach (Session::get('permisos')[0] as $permiso) {
    	if ($permiso['submoduloid'] == ModulosHelper::PERFILES_ID)
    	{
    		$v = 1;
			break;
    	}
    }

    if ($v == 0)
    {
	    Session::flash('message', 'NO TIENES ACCESO A ESTE MODULO, CONSULTA CON EL ADMINISTRADOR DEL SISTEMA.');
    	Session::flash('message_type', DashboardController::OPERACION_FALLIDA);
    	return Redirect::to('dashboard');    	
    }
});

Route::filter('filtroinscripciones', function()
{
	$v = 0;
    foreach (Session::get('permisos')[0] as $permiso) {
    	if ($permiso['submoduloid'] == ModulosHelper::INSCRIPCIONES_ID)
    	{
    		$v = 1;
			break;
    	}
    }

    if ($v == 0)
    {
	    Session::flash('message', 'NO TIENES ACCESO A ESTE MODULO, CONSULTA CON EL ADMINISTRADOR DEL SISTEMA.');
    	Session::flash('message_type', DashboardController::OPERACION_FALLIDA);
    	return Redirect::to('dashboard');
    }
});

Route::filter('filtrousuarios', function()
{
	$v = 0;
    foreach (Session::get('permisos')[0] as $permiso) {
    	if ($permiso['submoduloid'] == ModulosHelper::USUARIOS_ID)
    	{
    		$v = 1;
			break;
    	}
    }

    if ($v == 0)
    {
	    Session::flash('message', 'NO TIENES ACCESO A ESTE MODULO, CONSULTA CON EL ADMINISTRADOR DEL SISTEMA.');
    	Session::flash('message_type', DashboardController::OPERACION_FALLIDA);
    	return Redirect::to('dashboard');    	
    }
});

Route::filter('filtrobecas', function()
{
	$v = 0;
    foreach (Session::get('permisos')[0] as $permiso) {
    	if ($permiso['submoduloid'] == ModulosHelper::BECAS_ID)
    	{
    		$v = 1;
			break;
    	}
    }

    if ($v == 0)
    {
	    Session::flash('message', 'NO TIENES ACCESO A ESTE MODULO, CONSULTA CON EL ADMINISTRADOR DEL SISTEMA.');
    	Session::flash('message_type', DashboardController::OPERACION_FALLIDA);
    	return Redirect::to('dashboard');    	
    }
});

Route::filter('filtroinformesalumnos', function()
{
	$v = 0;
    foreach (Session::get('permisos')[0] as $permiso) {
    	if ($permiso['submoduloid'] == ModulosHelper::INFORMES_ALUMNOS_ID)
    	{
    		$v = 1;
			break;
    	}
    }

    if ($v == 0)
    {
	    Session::flash('message', 'NO TIENES ACCESO A ESTE MODULO, CONSULTA CON EL ADMINISTRADOR DEL SISTEMA.');
    	Session::flash('message_type', DashboardController::OPERACION_FALLIDA);
    	return Redirect::to('dashboard');    	
    }
});

Route::filter('filtroinformesdocentes', function()
{
	$v = 0;
    foreach (Session::get('permisos')[0] as $permiso) {
    	if ($permiso['submoduloid'] == ModulosHelper::INFORMES_DOCENTES_ID)
    	{
    		$v = 1;
			break;
    	}
    }

    if ($v == 0)
    {
	    Session::flash('message', 'NO TIENES ACCESO A ESTE MODULO, CONSULTA CON EL ADMINISTRADOR DEL SISTEMA.');
    	Session::flash('message_type', DashboardController::OPERACION_FALLIDA);
    	return Redirect::to('dashboard');    	
    }
});

Route::filter('filtroinformesmatriculas', function()
{
    $tiene_permiso = false;
    foreach (Session::get('permisos')[0] as $permiso) {
        if ($permiso['submoduloid'] == ModulosHelper::INFORMES_MATRICULAS_ID) {
            $tiene_permiso = true;
            break;
        }
    }

    if (!$tiene_permiso) {
        Session::flash('message', 'NO TIENES ACCESO A ESTE MODULO, CONSULTA CON EL ADMINISTRADOR DEL SISTEMA.');
        Session::flash('message_type', DashboardController::OPERACION_FALLIDA);
        return Redirect::to('dashboard');       
    }
});


Route::filter('filtroplanestudios', function()
{
    $v = 0;
    foreach (Session::get('permisos')[0] as $permiso) {
        if ($permiso['submoduloid'] == ModulosHelper::PLANESTUDIOS_ID)
        {
            $v = 1;
            break;
        }
    }

    if ($v == 0)
    {
        Session::flash('message', 'NO TIENES ACCESO A ESTE MODULO, CONSULTA CON EL ADMINISTRADOR DEL SISTEMA.');
        Session::flash('message_type', DashboardController::OPERACION_FALLIDA);
        return Redirect::to('dashboard');       
    }
});

Route::filter('filtromaterias', function()
{
    $v = 0;
    foreach (Session::get('permisos')[0] as $permiso) {
        if ($permiso['submoduloid'] == ModulosHelper::MATERIAS_ID)
        {
            $v = 1;
            break;
        }
    }

    if ($v == 0)
    {
        Session::flash('message', 'NO TIENES ACCESO A ESTE MODULO, CONSULTA CON EL ADMINISTRADOR DEL SISTEMA.');
        Session::flash('message_type', DashboardController::OPERACION_FALLIDA);
        return Redirect::to('dashboard');       
    }
});

//$permiso['submoduloid'] == ModulosHelper::CALENDARIOS_ID or $permiso['submoduloid'] == ModulosHelper::CARRERAS_ID or $permiso['submoduloid'] == ModulosHelper::MATERIAS_ID or $permiso['submoduloid'] == ModulosHelper::PLANESTUDIOS_ID or $permiso['submoduloid'] == ModulosHelper::ADMINISTRACION_ID


/*
|--------------------------------------------------------------------------
| Filtro para invitados
|--------------------------------------------------------------------------
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('alumnos/listado');
});

/*
|--------------------------------------------------------------------------
| Filtro para proteción CSRF
|--------------------------------------------------------------------------
*/

Route::filter('csrf', function()
{
	if (Session::token() !== Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});
