<?php

class DashboardController extends BaseController
{
    const OPERACION_EXITOSA = 1;
    const OPERACION_FALLIDA = 2;
    const OPERACION_CANCELADA = 3;
    const OPERACION_INFO = 4;
    	
    public function getIndex()
    {
    	$carreras = Organizacion::find(Session::get('ORGANIZACION_ID'))->carreras;
    	$alumnos = Alumno::whereRaw('activo ='. 1)->get();
        $i = 0;
        foreach ($alumnos as $alum) {
            if ($alum['fechaegreso']) $i--;
            
            $i++;
        }
            
        $totalumnos = $i;
        $docentes = Docente::whereRaw('activo ='. 1)->get();
        $i = 0;
        foreach ($docentes as $docen) {
            if ($docen['fechaegreso']) $i--;
            
            $i++;
        }
            
        $totaldocentes = $i;
    	$totalcarreras = Carrera::where('activa', '=', 1)->count();
    	$totalusuarios = User::all()->count();

    	$totalhombres = DB::table('personas')
            ->join('alumnos', 'personas.id', '=', 'alumnos.persona_id')
            ->where('personas.sexo', '=', 'Masculino')
            ->where('alumnos.activo', '=', 1)
            ->where('alumnos.fechaegreso', '=', null)
            ->count();

    	$totalmujeres = DB::table('personas')
            ->join('alumnos', 'personas.id', '=', 'alumnos.persona_id')
            ->where('personas.sexo', '=', 'Femenino')
            ->where('alumnos.activo', '=', 1)
            ->where('alumnos.fechaegreso', '=', null)
            ->count();            



    	$arrc = array();
    	$arra = array();
    	$arrporc = array();
    	$porcent = array();
    	//BUCLE PARA RESCATAR LA CANTIDAD DE ALUMNOS POR CARRERA COUNT()
    	foreach ($carreras as $carrera) {
    		$arr = explode(" ", $carrera->carrera);
    		$cadena = '';
    		$arrc[] = $carrera->Abreviatura;
    		$arra[] = $carrera->alumnos->count();
    		//RESCATO EN PORCENTAJE PARA LUEGO USAR EN EL BUCLE DE GRAFICO DE TORTA
			$arrporc[] =  ($carrera->alumnos->count()*100)/$totalumnos;
    	}

        
    	//FOREACH PARA ARMADO PARA EL JSON DE GRAFICO DE TORTA
    	$colores = ['#F7464A', '#46BFBD', '#FDB45C', '#949FB1', '#4D5360', '#69ADFB', '#A17BED', '#67B352', '#31B5AE', '#FAC020', '#22BED6', '#3CDEC0', '#32A12F', '#1A6891'];
    	$highlight = ['#FF5A5E', '#5AD3D1', '#FFC870', '#A8B3C5', '#616774', '#89BEFA', '#B296EB', '#8BC47C', '#5DC9C4', '#FAD05C', '#4FD4E8', '#74F7DF', '#74C971', '#468BB0'];

    	$i = 0;
    	foreach ($arrporc as $arrp) {
            if ($arrp > 0) {
        		$porcent[$i] = ['value'=>(int)number_format($arrp,2,",","."), 'color'=>$colores[$i], 'highlight'=>$highlight[$i], 'label'=>$arrc[$i]];
        		$i++;
            }
    	}
highlight_string(var_export($porcent, true));
        exit();
        //TOTAL DE ALUMNOS BECADOS
        $tot_becados = Beca::all()->count();
    	
        return View::make('dashboard', [
        	'carreras'=>$arrc,
        	'alumnosporcarrera'=>$arra,
        	'porcentaje'=>$porcent,
        	'totalalumnos'=>$totalumnos,
        	'totaldocentes'=>$totaldocentes,
        	'totalcarreras'=>$totalcarreras,
        	'totalusuarios'=>$totalusuarios,
        	'totalhombres'=> $totalhombres,
        	'totalmujeres'=> $totalmujeres,
            'totalbecados'=> $tot_becados,
        	'menu'=>ModulosHelper::MENU_DASHBOARD, 
        	'submenu'=>ModulosHelper::MENU_DASHBOARD 
        	]);
    }	
}