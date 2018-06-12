<?php

class AsistenciaHelper {

    /**
     * Recibe la datos de alumno o carrera
     * Devuelve la fecha en porcentaje de asistencia
     *
     * @param  String  $fecha
     * @return String
     */
    public static function getAsistenciaporcentaje($carrera_id, $planestudio_id, $materia_id, $alumno_id, $ciclo_id)
    {
        $materiass = Materia::find($materia_id);
        
        if ($materiass->periodo == 'Anual') {
            if ($ciclo_id == '') {
                $ciclo_id = PlanEstudio::find($planestudio_id)->ciclolectivo_id;
            }

            $ciclos = CicloLectivo::find($ciclo_id);
            $fechaini = FechaHelper::getFechaImpresion($ciclos->fechainicio);
            $fechafi = FechaHelper::getFechaImpresion($ciclos->fechafin);

            $fechainicio = $fechaini;
            $fechafin = $fechafi;
        } else {
            $cuatri = $materiass->cuatrimestre;

            if ($ciclo_id == '') {
                $ciclo_id = PlanEstudio::find($planestudio_id)->ciclolectivo_id;
            }
            
            $ciclos = PeriodoLectivo::whereRaw('ciclolectivo_id ='. $ciclo_id)->get();

            if (count($ciclos) > 0) {
                foreach ($ciclos as $value) {
                    $fechainic = FechaHelper::getFechaImpresion($value->fechainicio);
                    $fechafic = FechaHelper::getFechaImpresion($value->fechafin);
                    $fechaini = FechaHelper::getFechaParaGuardar($fechainic);
                    $fechafi = FechaHelper::getFechaParaGuardar($fechafic);

                    if ($cuatri == 1) {
                        if ($value->descripcion == '1 Cuatrimestre') {
                            $fechainicio = $fechainic;
                            $fechafin = $fechafic;
                        }
                    }

                    if ($cuatri == 2) {
                        if ($value->descripcion == '2 Cuatrimestre') {
                            $fechainicio = $fechainic;
                            $fechafin = $fechafic;
                        }
                    }
                }
            } else {
                $fechainicio = '';
                $fechafin = '';
            }
        }
        
        if (!$fechainicio == '') {
            $porcion = explode("/", $fechainicio);
            $fecha_inicial = $porcion[2].'-'.$porcion[1].'-'.$porcion[0];
            $porcion = explode("/", $fechafin);
            $fecha_final = $porcion[2].'-'.$porcion[1].'-'.$porcion[0];
        //}
            ////////////////////////////////
            $luness = '';
            $martess = '';
            $miercoless = '';
            $juevess = '';
            $vierness = '';
            $sabados = '';
            $asignaciones = AsignarDocente::whereRaw('carrera_id='. $carrera_id .' AND materia_id='. $materia_id .' AND planestudio_id='. $planestudio_id)->first();

            if (count($asignaciones) > 0) {
                $detalledias = DetalleAsignarDocente::whereRaw('asignardocente_id='. $asignaciones->id)->get();

                foreach ($detalledias as $value) {
                    if ($value->dia == 'Lunes') {
                        $luness = 'lunes';
                    }
                    if ($value->dia == 'Martes') {
                        $martess = 'martes';
                    }
                    if ($value->dia == 'Miercoles') {
                        $miercoless = 'miercoles';
                    }
                    if ($value->dia == 'Jueves') {
                        $juevess = 'jueves';
                    }
                    if ($value->dia == 'Viernes') {
                        $vierness = 'viernes';
                    }
                    if ($value->dia == 'Sabado') {
                        $sabados = 'sabado';
                    }
                }

                $diass[] = ['lunes' => $luness, 'martes' => $martess, 'miercoles' => $miercoless, 'jueves' => $juevess, 'viernes' => $vierness, 'sabado' => $sabados];
            } else {
                $diass = [];
            }

            $feriados = array();

            $feriadoss = Feriados::whereRaw('fecha_feriado >= "'.$fecha_inicial.'" AND fecha_feriado <= "'.$fecha_final.'"')->get();
            
            foreach ($feriadoss as $value) {
                $arrFechaHora = explode(' ', $value->fecha_feriado);
                list($year,$mes,$dia) = explode("-",$arrFechaHora[0]);
                $fechaf = $dia.'-'.(string)(int)$mes;
                array_push($feriados, $fechaf);
            }
            
            list($year,$mes,$dia) = explode("-",$fecha_inicial);
            $ini = mktime(0, 0, 0, $mes , $dia, $year); 
            list($yearf,$mesf,$diaf) = explode("-",$fecha_final);
            $fin = mktime(0, 0, 0, $mesf , $diaf, $yearf);

            $newArray = array();
            $ArrayLab = array();
            $r = 1;
            $i = 0;
            $dia2 = 0;

            while ($ini != $fin) {
                $ini = mktime(0, 0, 0, $mes , $dia+$r, $year); 
                $newArray[$i] = $ini; //CANTIDAD DE DIAS HABILES TENIENDO EN CUENTA EL CICLO
                $r++;
                $i++;
            }
            $j = count($newArray);
            $dia_Lab = 0;
            $dia_NoLab = 0;
            $dia = 0;

            for ($i=0; $i < $j; $i++) {
                $dia = $newArray[$i];
                $fecha = getdate($dia);
                $feriado = $fecha['mday']."-".$fecha['mon'];

                if ($fecha["wday"] == 1) {
                    if ($diass[0]['lunes'] == 'lunes') {
                        if (in_array($feriado, $feriados)) {
                            $dia_NoLab++; //CUENTO LOS FERIADOS
                        } else {
                            array_push($ArrayLab, $dia);
                            $dia_Lab++;
                        }
                    }
                }
                if ($fecha["wday"] == 2) {
                    if ($diass[0]['martes'] == 'martes') {
                        if (in_array($feriado, $feriados)) {
                            $dia_NoLab++; //CUENTO LOS FERIADOS
                        } else {
                            array_push($ArrayLab, $dia);
                            $dia_Lab++;
                        }
                    }
                }
                if ($fecha["wday"] == 3) {
                    if ($diass[0]['miercoles'] == 'miercoles') {
                        if (in_array($feriado, $feriados)) {
                            $dia_NoLab++; //CUENTO LOS FERIADOS
                        } else {
                            array_push($ArrayLab, $dia);
                            $dia_Lab++;
                        }
                    }
                }
                if ($fecha["wday"] == 4) {
                    if ($diass[0]['jueves'] == 'jueves') {
                        if (in_array($feriado, $feriados)) {
                            $dia_NoLab++; //CUENTO LOS FERIADOS
                        } else {
                            array_push($ArrayLab, $dia);
                            $dia_Lab++;
                        }
                    }
                }
                if ($fecha["wday"] == 5) {
                    if ($diass[0]['viernes'] == 'viernes') {
                        if (in_array($feriado, $feriados)) {
                            $dia_NoLab++; //CUENTO LOS FERIADOS
                        } else {
                            array_push($ArrayLab, $dia);
                            $dia_Lab++;
                        }
                    }
                }
                if ($fecha["wday"] == 6) {
                    if ($diass[0]['sabado'] == 'sabado') {
                        if (in_array($feriado, $feriados)) {
                            $dia_NoLab++; //CUENTO LOS FERIADOS
                        } else {
                            array_push($ArrayLab, $dia);
                            $dia_Lab++;
                        }
                    }
                }
            }

            $cant_dias = $dia_Lab - $dia_NoLab;

            $asistencias = Asistencias::whereRaw('planestudio_id ='.$planestudio_id.' AND carrera_id ='.$carrera_id.' AND alumno_id ='.$alumno_id.' AND materia_id ='.$materia_id.' AND lunesfecha >= "'.$fecha_inicial.'" AND sabadofecha <= "'.$fecha_final.'"')->get();
            $asistencia = 0;
            $fechasasis = array();

            foreach ($asistencias as $value) {
                if ($diass[0]['lunes'] == 'lunes') {
                    $fecha = FechaHelper::getFechaImpresion($value->lunesfecha);
                    list($dia, $mes, $year) = explode("/", $fecha);
                    $fechalu = $dia.'-'.(string)(int)$mes;

                    if ($value->lunes == 1) {
                        array_push($fechasasis, $fechalu);
                        $asistencia++;
                    }
                }

                if ($diass[0]['martes'] == 'martes') {
                    $fecha = FechaHelper::getFechaImpresion($value->martesfecha);
                    list($dia, $mes, $year) = explode("/", $fecha);
                    $fechama = $dia.'-'.(string)(int)$mes;
                    
                    if ($value->martes == 1) {
                        array_push($fechasasis, $fechama);
                        $asistencia++;
                    }
                }

                if ($diass[0]['miercoles'] == 'miercoles') {
                    $fecha = FechaHelper::getFechaImpresion($value->miercolesfecha);
                    list($dia, $mes, $year) = explode("/", $fecha);
                    $fechami = $dia.'-'.(string)(int)$mes;
                    
                    if ($value->miercoles == 1) {
                        array_push($fechasasis, $fechami);
                        $asistencia++;
                    }
                }

                if ($diass[0]['jueves'] == 'jueves') {
                    $fecha = FechaHelper::getFechaImpresion($value->juevesfecha);
                    list($dia, $mes, $year) = explode("/", $fecha);
                    $fechaju = $dia.'-'.(string)(int)$mes;
                    
                    if ($value->jueves == 1) {
                        array_push($fechasasis, $fechaju);
                        $asistencia++;
                    }
                }

                if ($diass[0]['viernes'] == 'viernes') {
                    $fecha = FechaHelper::getFechaImpresion($value->viernesfecha);
                    list($dia, $mes, $year) = explode("/", $fecha);
                    $fechavi = $dia.'-'.(string)(int)$mes;
                    
                    if ($value->viernes == 1) {
                        array_push($fechasasis, $fechavi);
                        $asistencia++;
                    }
                }

                if ($diass[0]['sabado'] == 'sabado') {
                    $fecha = FechaHelper::getFechaImpresion($value->sabadofecha);
                    list($dia, $mes, $year) = explode("/", $fecha);
                    $fechasa = $dia.'-'.(string)(int)$mes;
                    
                    if ($value->sabado == 1) {
                        array_push($fechasasis, $fechasa);
                        $asistencia++;
                    }
                }
            }

            $porcentaje_asistencias = $asistencia * 100 / $cant_dias;
            $porcentaje_asistencia = round($porcentaje_asistencias, 2);
        } else {
            $porcentaje_asistencia = 1;
        }

        return $porcentaje_asistencia;
    }

}