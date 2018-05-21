<?php
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BecasController extends BaseController {

    const OPERACION_EXITOSA = 1;
    const OPERACION_FALLIDA = 2;
    const OPERACION_CANCELADA = 3;
    const OPERACION_INFO = 4;

    public function getGestionar()
    {
        return View::make('matriculas.gestionBecas')
            ->with('menu', ModulosHelper::MENU_GESTION_CONTABLE)
            ->with('submenu', ModulosHelper::SUBMENU_BECAS)
            ->with('leer', Session::get('BECA_LEER'))
            ->with('editar', Session::get('BECA_EDITAR'))
            ->with('imprimir', Session::get('BECA_IMPRIMIR'))
            ->with('eliminar', Session::get('BECA_ELIMINAR'));
    }

    public function postObtenerhistorial()
    {
        $alumno_id = Input::get('alumno_id');
        //$matricula = Matricula::find($id);
        $historial_becas = Beca::getHistorial($alumno_id);
        return Response::json($historial_becas);
    }

    public function postGuardar()
    {
        $ciclo_id = Input::get('cboCiclo');
        $inscripcion_id = Input::get('cboCarrera');
        $mes_inicio_beca = Input::get('cboMesInicioBeca');
        $mes_fin_beca = Input::get('cboMesFinBeca');
        $pagado_id = Input::get('txt_pagado_id');

        if ($inscripcion_id == 0 || trim($inscripcion_id) == '' || $mes_inicio_beca == 0 || $ciclo_id == 0) {
            if ($pagado_id == '') {
                Session::flash('message', 'ERROR. DEBE SELECCIONAR CICLO, LA CARRERA Y EL MES DE INICIO DE LA BECA.');
                Session::flash('message_type', self::OPERACION_FALLIDA);
                return Redirect::to('becas/gestionar');
            } else {
                Session::flash('message', 'ERROR. DEBE SELECCIONAR CICLO, LA CARRERA Y EL MES DE INICIO DE LA BECA.');
                Session::flash('message_type', self::OPERACION_FALLIDA);
                return Redirect::to('becas/pagado/'.$inscripcion_id);
            }
        }

        /*
         * VALIDACION 
         * NO DEJA ASIGNAR UNA BECA, EN CASO DE QUE YA LO TENGA
         */
        $beca = Beca::whereRaw('inscripcion_id =' . $inscripcion_id . ' AND ciclolectivo_id= '.$ciclo_id.' AND becado=1')->get();
        if (count($beca) > 0) {
            if ($pagado_id == '') {
                Session::flash('message', 'YA EXISTE UNA BECA ACTUAL.');
                Session::flash('message_type', self::OPERACION_FALLIDA);
                return Redirect::to('becas/gestionar');
            } else {
                Session::flash('message', 'YA EXISTE UNA BECA ACTUAL.');
                Session::flash('message_type', self::OPERACION_FALLIDA);
                return Redirect::to('becas/pagado/'.$inscripcion_id);
            }
            
        }

        $inscripcion = AlumnoCarrera::find($inscripcion_id);
        $ciclo = CicloLectivo::find($ciclo_id);//$inscripcion->ciclolectivo_id);

        $fecha_fin_ciclo = FechaHelper::getFechaImpresion($ciclo->fechafin);
        list($dia, $mes, $anio) = explode('/', $fecha_fin_ciclo);

        $fecha_inicio_beca = $anio . '/' . $mes_inicio_beca . '/01';

        if ($mes_fin_beca == 0) {
            // finalizacion automatica al finalizar ciclo
            $fecha_fin_beca = $ciclo->fechafin;
        } else {
            $fecha_fin_beca = $anio . '/' . $mes_fin_beca . '/01';
        }

        $beca = new Beca;
          $beca->inscripcion_id  = $inscripcion_id;
          $beca->alumno_id       = $inscripcion->alumno_id;
          $beca->carrera_id      = $inscripcion->carrera_id;
          $beca->ciclolectivo_id = $ciclo_id;//$inscripcion->ciclolectivo_id;
          $beca->becado          = 1;
          $beca->becafechainicio = $fecha_inicio_beca;
          $beca->becafechafin    = $fecha_fin_beca;
          $beca->usuario_alta    = Auth::user()->usuario;
          $beca->fecha_alta      = date('Y-n-d');
        $beca->save();

        Session::flash('message', 'BECA GUARDADA CORRECTAMENTE.');
        Session::flash('message_type', self::OPERACION_EXITOSA);
        return Redirect::to('becas/pagado/'.$inscripcion_id);
    }

    public function getPagado($inscripcion_id)
    {
        $arrAlumno = AlumnoCarrera::find($inscripcion_id);
        $alumno = Alumno::getAlumnoPorAlumnoId($arrAlumno->alumno_id);
        $beca = Beca::whereRaw('inscripcion_id =' . $inscripcion_id . ' AND becado=1')->get();
        $becas = $beca->last();

        $ciclo  = AlumnoCarrera::getCarrerasInscripciones($arrAlumno->alumno_id);
        $carrera  = AlumnoCarrera::getDatosInscripcionAlumno($arrAlumno->alumno_id);
        $ciclos = array();

        if (count($ciclo) == 0) {
            return self::NO_EXISTE_INSCRIPCION;
        } else {
            foreach ($ciclo as $value) {
                $cicloinscripcion = $value->ciclo;
            }

            foreach ($carrera as $value) {
                $cicloinicio = CicloLectivo::whereRaw('id = '. $value->ciclolectivo_id)->first()->descripcion;

                if ($cicloinscripcion == $cicloinicio || $cicloinicio > $cicloinscripcion) {
                    $ciclos[] = ['ciclolectivo_id' => $value->ciclolectivo_id, 'ciclo' => $cicloinicio];
                }
            }
        }

        $carreras  = AlumnoCarrera::getCarrerasInscripciones($arrAlumno->alumno_id);
        
        //---RESCATO MESES INICIO, FIN
        $meses = ['Seleccionar', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        $fecha_inicio_beca = FechaHelper::getFechaImpresion($becas->becafechainicio);
        list($dia, $mes, $anio) = explode('/', $fecha_inicio_beca);
        $mesinicio = $mes;
        $mesinicio = (string)(int)$mesinicio;

        $fecha_fin_beca = FechaHelper::getFechaImpresion($becas->becafechafin);
        list($dia, $mes, $anio) = explode('/', $fecha_fin_beca);
        $mesfin = $mes;
        $mesfin = (string)(int)$mesfin;
        //
        //-- HISTORIAL BECAS
        $historial_becas = Beca::getHistorial($arrAlumno->alumno_id);

        foreach ($historial_becas as $historial_beca) {
            $fecha_inicio_beca = FechaHelper::getFechaImpresion($historial_beca->becafechainicio);
            $historial_beca->becafechainicio = $fecha_inicio_beca;
            $fecha_fin_beca = FechaHelper::getFechaImpresion($historial_beca->becafechafin);
            $historial_beca->becafechafin = $fecha_fin_beca;
        }
        
        /*highlight_string(var_export($historial_becas,true));
        exit();*/

        return View::make('matriculas.gestionBecasPagos')
            ->with('alumno', $alumno[0])
            ->with('carreras', $carreras)
            ->with('ciclos', $ciclos)
            ->with('arrAlumno', $arrAlumno)
            ->with('becas', $becas)
            ->with('meses', $meses)
            ->with('mesinicio', $mesinicio)
            ->with('mesfin', $mesfin)
            ->with('historial_becas', $historial_becas)
            ->with('menu', ModulosHelper::MENU_GESTION_CONTABLE)
            ->with('submenu', ModulosHelper::SUBMENU_BECAS)
            ->with('leer', Session::get('BECA_LEER'))
            ->with('editar', Session::get('BECA_EDITAR'))
            ->with('imprimir', Session::get('BECA_IMPRIMIR'))
            ->with('eliminar', Session::get('BECA_ELIMINAR'));
    }

    public function getFinalizar($beca_id)
    {
        $beca = Beca::find($beca_id);
          $beca->becado       = 0;
          $beca->becafechafin = date('Y-n-d');
        $beca->save();

        Session::flash('message', 'LA BECA PARA EL ALUMNO HA FINALIZADO');
        Session::flash('message_type', self::OPERACION_EXITOSA);
        return Redirect::to('becas/gestionar');
    }

    public function getEliminar($beca_id)
    {
        $beca = Beca::find($beca_id);

        try
        {
            $beca->delete();
        }
        catch(Exception $ex)
        {
            Session::flash('message', 'NO SE PUEDE BORRAR LA BECA.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('becas/gestionar');
        }

        Session::flash('message', 'LA BECA HA SIDO BORRADA DEL SISTEMA');
        Session::flash('message_type', self::OPERACION_EXITOSA);
        return Redirect::to('becas/gestionar');
    }

    public function postObtenerbecasporcarrerayciclo()
    {
        $ciclo_id = Input::get('ciclo');
        $carrera_id = Input::get('carrera');

        $becas = Beca::whereRaw(
            'carrera_id=' . $carrera_id
            . ' and ciclolectivo_id=' . $ciclo_id
            . ' and becado = 1'
            )->get();

        return Response::json($becas);
    }

}
