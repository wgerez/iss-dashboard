<?php

Route::get('/', ['before' => 'guest', function()
{
    return View::make('login');
}]);


Route::post('login', ['uses' => 'AuthController@doLogin', 'before' => 'guest']);
//Desconecta al usuario
Route::get('logout', ['uses' => 'AuthController@doLogout', 'before' => 'auth']);

Route::group(['prefix' => 'api'], function() 
{
	Route::resource('materias', 'MateriasResourceController');	
});

Route::controller('materias', 'MateriasController');


Route::group(['before' => 'auth'], function()
{
	Route::controller('dashboard', 'DashboardController');

	Route::group(['before' => 'filtroorganizacion'], function()
	{
		Route::controller('organizacions', 'OrganizacionsController');
	});

	Route::group(['before' => 'filtroalumnos'], function()
	{
		Route::controller('alumnos', 'AlumnosController');
	});
	
	Route::group(['before' => 'filtrodocentes'], function()
	{
		Route::controller('docentes', 'DocentesController');
	});

	Route::group(['before' => 'filtroasignardocentes'], function()
	{
		Route::controller('asignardocente', 'AsignarDocenteController');
	});

	Route::group(['before' => 'filtroasistencias'], function()
	{
		Route::controller('asistencias', 'AsistenciaController');
	});

	Route::group(['before' => 'filtroboletines'], function()
	{	
		Route::controller('examenfinal', 'ExamenFinalController');
	});

	Route::group(['before' => 'filtrocalendarios'], function()
	{	
		Route::controller('ciclolectivo', 'CiclolectivoController');
	});

	Route::group(['before' => 'filtrocalendario'], function()
	{	
		Route::controller('feriados', 'FeriadosController');
	});

	Route::group(['before' => 'filtrocalendarios'], function()
	{	
		Route::controller('ciclolectivo', 'CiclolectivoController');
	});

	Route::group(['before' => 'filtrocalendarios'], function()
	{	
		Route::controller('mesaexamenes', 'MesaexamenesController');
	});


	Route::group(['before' => 'filtrocarreras'], function()
	{
		Route::controller('carreras', 'CarrerasController');
	});

	Route::group(['before' => 'filtromatriculas'], function()
	{
		Route::controller('matriculas', 'MatriculasController');
	});	
	
	Route::group(['before' => 'filtrocuotas'], function()
	{
		Route::controller('cuotas', 'CuotasController');
	});	
	
	Route::group(['before' => 'filtroperfiles'], function()
	{
		Route::controller('perfiles', 'PerfilesController');
	});	


	Route::group(['before' => 'filtroinscripciones'], function()
	{
		Route::controller('inscripciones', 'InscripcionesController');
	});


	Route::group(['before' => 'filtroinscripciones'], function()
	{
		Route::controller('inscripcionfinal', 'InscripcionfinalesController');
	});

	Route::group(['before' => 'filtroinscripcionesmaterias'], function()
	{
		Route::controller('inscripcionmaterias', 'InscripcionmateriasController');
	});	

	Route::group(['before' => 'filtrousuarios'], function()
	{
		Route::controller('usuarios', 'UsersController');
	});
	
	Route::group(['before' => 'filtrobecas'], function()
	{		
		Route::controller('becas', 'BecasController');
	});

	Route::group(['before' => 'filtroinformesalumnos'], function()
	{		
		Route::get('informes/alumnos', 'AlumnosController@getInforme');
	});

	Route::group(['before' => 'filtroinformesdocentes'], function()
	{		
		Route::get('informes/docentes', 'DocentesController@getInforme');
	});

	Route::group(['before' => 'filtroinformesmatriculas'], function()
	{		
		Route::get('informes/matriculas', 'MatriculasController@getInforme');
	});

	Route::group(['before' => 'filtroregularidades'], function()
	{
		Route::controller('regularidades', 'RegularidadesController');
	});

	Route::group(['before' => 'filtroplanestudios', 'prefix' => 'api'], function()
	{
		Route::resource('planestudios', 'PlanestudioresourceController');
	});	

	Route::group(['before' => 'filtroplanestudios'], function()
	{
		Route::controller('planestudios', 'PlanestudiosController');
	});

	Route::group(['before' => 'filtroaperturacaja'], function()
	{
		Route::controller('aperturacaja', 'AperturaCajaController');
	});

	Route::group(['before' => 'filtrocierrecaja'], function()
	{
		Route::controller('cierrecaja', 'CierreCajaController');
	});

	
	Route::group(['prefix' => 'api'], function()
	{		
		Route::resource('caja', 'CajaChicaResourceController');
	});

	Route::group(['before' => 'filtrocajachica'], function()
	{
		Route::controller('cajachica', 'CajaChicaController');
	});
	

	/*Route::group(['before' => 'filtromaterias'], function()
	{
		Route::resource('materias', 'MateriasResourceController');
	});	
	 */


	Route::controller('tiposcontratos', 'TiposContratosController');

	Route::controller('contratos', 'ContratosController');

	Route::controller('correlatividades', 'CorrelatividadesController');

	/*Route::group(['before' => 'filtrocorrelatividades'], function()
	{
		Route::controller('correlatividades', 'CorrelatividadesController');
	});*/
});


//PARA MANEJAR LOS ERRORES (404 - 500 ETC..)
App::missing(function($exception)
{
    return Response::view(
    	'errors.404',
    	array(
    		'menu'=>ModulosHelper::MENU_GESTION_ADMINISTRATIVA,
    		'submenu'=>ModulosHelper::SUBMENU_ORGANIZACIONES),
        404);
});


