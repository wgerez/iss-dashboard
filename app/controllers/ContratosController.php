<?php

class ContratosController extends BaseController {

	const NO_HAY_INSCRITOS = 1;
    const NO_HAY_MATRICULA_ASIGNADA = 2;
    const ALUMNO_NO_INSCRITO = 3;
    const ALUMNO_NO_EXISTE = 4;
    const ALUMNO_MAYOR_EDAD = 5;
    const ALUMNO_MENOR_EDAD = 6;

    public function getImprimir()
    {
        $organizaciones = Organizacion::lists('nombre', 'id');

        array_unshift($organizaciones, 'Seleccionar');

        return View::make('contratos.imprimir')
            ->with('organizaciones', $organizaciones)
            ->with('menu', ModulosHelper::MENU_GESTION_CONTABLE)
            ->with('submenu', ModulosHelper::SUBMENU_CONTRATOS)
            ->with('submenu2', ModulosHelper::SUBMENU_2_IMPRESION_CONTRATOS)
            ->with('leer', Session::get('CONTRATOS_LEER'))
            ->with('editar', Session::get('CONTRATOS_EDITAR'))
            ->with('imprimir', Session::get('CONTRATOS_IMPRIMIR'))
            ->with('eliminar', Session::get('CONTRATOS_ELIMINAR'));
    }

    public function postDatosparagenerarcontratosporcicloycarrera()
    {
        $ciclo_id = Input::get('ciclo');
        $carrera_id = Input::get('carrera');

        $matricula = Matricula::whereRaw(
            'carrera_id = ' . $carrera_id .
            ' and ciclolectivo_id = ' . $ciclo_id)->first();

        $inscripciones = DetalleMatriculaPago::getInscripcionesMatricula($matricula->id);

        if (count($inscripciones) == 0)
            return self::NO_HAY_INSCRITOS;

        $matricula = Matricula::whereRaw(
            'carrera_id = ' . $carrera_id .
            ' and ciclolectivo_id = ' . $ciclo_id)->get();

        if (count($matricula) == 0)
            return self::NO_HAY_MATRICULA_ASIGNADA;

        $ciclo_lectivo = CicloLectivo::find($ciclo_id);
        $carrera = Carrera::find($carrera_id);

        $inscripciones[] = $carrera;
        $inscripciones[] = $ciclo_lectivo;
        $inscripciones[] = $matricula;

        return Response::json($inscripciones);
    }

    public function postDatosparagenerarcontratospordniyciclo()
    {
        $ciclo_id = Input::get('ciclo');
        $dni = Input::get('dni');

        $persona = Persona::with('alumno')
            ->where('nrodocumento', '=', $dni)
            ->get();

        if (count($persona) == 0)
            return self::ALUMNO_NO_EXISTE;

        $inscripciones = AlumnoCarrera::whereRaw(
            'alumno_id = ' . $persona[0]->alumno->id)
            ->get();

        if (count($inscripciones) == 0)
            return self::ALUMNO_NO_INSCRITO;

        $arrInscripciones = array();

        foreach ($inscripciones as $inscripcion) {

            $matricula = Matricula::whereRaw(
                'carrera_id = ' . $inscripcion->carrera_id .
                ' and ciclolectivo_id = ' . $ciclo_id)->get();

            if (count($matricula) == 0) continue;

            $carrera = Carrera::find($inscripcion->carrera_id);

            $inscripcion->carrera = $carrera;
            $inscripcion->matricula = $matricula;

            $arrInscripciones[] = $inscripcion;
        }

        if (count($arrInscripciones) == 0)
            return self::ALUMNO_NO_INSCRITO;

        $ciclo_lectivo = CicloLectivo::find($ciclo_id);

        $persona[0]->inscripciones = $arrInscripciones;
        $persona[0]->ciclo_lectivo = $ciclo_lectivo;

        return Response::json($persona[0]);
    }

    public function getPdfgenerarcontrato()
    {
        $organizacion_id = Input::get('organizacion');
        $ciclo_id = Input::get('ciclo');
        $carrera_id = Input::get('carrera');
        $alumno_id = Input::get('alumno');

        $arrErroresContrato = array();

        $organizacion = Organizacion::find($organizacion_id);

        $alumno = Alumno::with('persona')
            ->where('id', '=', $alumno_id)
            ->get();

        $inscripcion = AlumnoCarrera::whereRaw(
            'alumno_id = ' . $alumno_id .
            ' and ciclolectivo_id = ' . $ciclo_id .
            ' and carrera_id = ' . $carrera_id)
            ->get();

        $matricula = Matricula::whereRaw(
            'carrera_id = ' . $carrera_id .
            ' and ciclolectivo_id = ' . $ciclo_id)
            ->get();

        $ciclo_lectivo = CicloLectivo::find($ciclo_id);

        $barrio = Barrio::find($alumno[0]->persona->barrio_id);

                //highlight_string(var_export($alumno,true));
        //exit;

        /* VERIFICO SI ES MAYOR DE EDAD O NO */
        /* DEPENDIENDO DE ESTO, SE CARGA EL CONTRATO CORRESPONDIENTE */
        $fecha_nacimiento = FechaHelper::getFechaImpresion(
            $alumno[0]->persona->fechanacimiento
        );

        if ($this->_es_mayor_de_edad($fecha_nacimiento)) {
            $tipo_contrato_id = 1;
            $contrato = TipoContrato::find(1);
        } else {
            $tipo_contrato_id = 2;
            $contrato = TipoContrato::find(2);

            /* {{TUTOR y DNI_TUTOR}} */
            $tutor = '___________________________________';
            $dni_tutor = '____________________';

            $contrato->clausulas = str_replace('{{TUTOR}}', $tutor, $contrato->clausulas);
            $contrato->clausulas = str_replace('{{DNI_TUTOR}}', $dni_tutor, $contrato->clausulas);
        }

        /* VALIDO QUE TENGA IMPORTES CARGADOS */
        if ($matricula[0]->matriculaaplica == 0) {
            $arrErroresContrato[] = 'IMPORTE DE MATRICULA';
        }

        /*
         * {{CANTIDAD_DIAS}}
         * {{MES_TEXTO}}
         * {{ANIO}}
         */
        $arrNumerosTexto = FechaHelper::getNumerosTexto();
        $arrMesesTexto = FechaHelper::getMesesTexto();

        $dia_actual = date('j');
        $mes_actual = date('n');
        $anio_actual = date('Y');

        $dia_actual_texto = $arrNumerosTexto[$dia_actual - 1];
        $mes_actual_texto = $arrMesesTexto[$mes_actual - 1];

        $contrato->clausulas = str_replace('{{CANTIDAD_DIAS}}', $dia_actual_texto, $contrato->clausulas);
        $contrato->clausulas = str_replace('{{MES_TEXTO}}', $mes_actual_texto, $contrato->clausulas);
        $contrato->clausulas = str_replace('{{ANIO}}', $anio_actual, $contrato->clausulas);

        /* {{DOMICILIO_INSTITUCION}} */
        if (trim($organizacion->calle) != '') {
            $domicilio_institucion = 'calle ' . ucwords($organizacion->calle);

            if (trim($organizacion->numero) != '')
                 $domicilio_institucion .= ' N° ' . $organizacion->numero;
        } else {
            $arrErroresContrato[] = 'DOMICILIO DE LA INSTITUCION';
            $domicilio_institucion = '';
        }

        $contrato->clausulas = str_replace(
            '{{DOMICILIO_INSTITUCION}}', $domicilio_institucion, $contrato->clausulas);

        /* {{PRONOMBRE_PERSONA}} */
        $pronombre_persona = ' el/la Sr/a';

        $contrato->clausulas = str_replace(
            '{{PRONOMBRE_PERSONA}}', $pronombre_persona, $contrato->clausulas);

        /* {{ALUMNO}} */
        $alumno_nombre_apellido = strtoupper($alumno[0]->persona->apellido) . ', '
                                . strtoupper($alumno[0]->persona->nombre);

        $contrato->clausulas = str_replace('{{ALUMNO}}', $alumno_nombre_apellido, $contrato->clausulas);

        /* {{DNI_ALUMNO}} */
        if (trim($alumno[0]->persona->nrodocumento) != '') {
            $dni_alumno = $alumno[0]->persona->nrodocumento;
        } else {
            $arrErroresContrato[] = 'DNI DEL ALUMNO';
            $dni_alumno = '';
        }

        $contrato->clausulas = str_replace('{{DNI_ALUMNO}}', $dni_alumno, $contrato->clausulas);

        /* {{DOMICILIO_EDUCANDO}} */
        $domicilio_alumno = '';

        if (trim($alumno[0]->persona->calle) != '') {
            $domicilio_alumno = 'calle ' . ucwords($alumno[0]->persona->calle);

            if (trim($alumno[0]->persona->numero) != '')
                 $domicilio_alumno .= ' N° ' . $alumno[0]->persona->numero;
        }

        if (trim($domicilio_alumno) != '') {
            $domicilio_alumno .= ', B° ' . ucwords($alumno[0]->persona->barrio);
        } else {
            $domicilio_alumno = 'B° ' . ucwords($alumno[0]->persona->barrio);
        }

        if (trim($alumno[0]->persona->barrio) == '') {
            $arrErroresContrato[] = 'BARRIO DEL ALUMNO';            
        }

        if (trim($domicilio_alumno) == '') {
            $arrErroresContrato[] = 'DOMICILIO DEL ALUMNO';
        }

        $contrato->clausulas = str_replace(
            '{{DOMICILIO_EDUCANDO}}', $domicilio_alumno, $contrato->clausulas);



        /* VALIDO QUE SE HA LLEGADO HASTA AQUI SIN ERRORES */
        if (count($arrErroresContrato)) {

            return View::make('contratos.generacionerror')
                ->with('errores', $arrErroresContrato)
                ->with('menu', ModulosHelper::MENU_GESTION_CONTABLE)
                ->with('submenu', ModulosHelper::SUBMENU_CONTRATOS)
                ->with('submenu2', ModulosHelper::SUBMENU_2_IMPRESION_CONTRATOS);

            exit;
        }


        /* {{CICLO_LECTIVO}} */
        $ciclo = ucwords($ciclo_lectivo->descripcion);
        // -------------- ver si se agrega la palabra año -------------
        $contrato->clausulas = str_replace('{{CICLO_LECTIVO}}', $ciclo, $contrato->clausulas);

        /* {{ARANCEL_TOTAL_TEXTO}} */
        //  -------------- no tiene en cuenta decimales ----------------
        $total_anual = (int) ($matricula[0]->cuotaimporte * $matricula[0]->cuotasporperiodo);
        $arancel_total_texto = 'PESOS ' . strtoupper(AifLibNumber::toWord($total_anual)) . ' C/00/100';

        $contrato->clausulas = str_replace(
            '{{ARANCEL_TOTAL_TEXTO}}', $arancel_total_texto, $contrato->clausulas);

        /* {{ARANCEL_TOTAL_NUMERO}} */
        $total_anual = (float) ($matricula[0]->cuotaimporte * $matricula[0]->cuotasporperiodo);
        $total_anual = number_format($total_anual, 2, ',', '.');
        $arancel_total_numero = '$' . $total_anual;

        $contrato->clausulas = str_replace(
            '{{ARANCEL_TOTAL_NUMERO}}', $arancel_total_numero, $contrato->clausulas);

        /* {{CANTIDAD_CUOTAS_TEXTO}} */
        $cuotas_texto = AifLibNumber::toWord($matricula[0]->cuotasporperiodo);

        $contrato->clausulas = str_replace(
            '{{CANTIDAD_CUOTAS_TEXTO}}', $cuotas_texto, $contrato->clausulas);

        /* {{CANTIDAD_CUOTAS_NUMERO}} */
        $contrato->clausulas = str_replace(
            '{{CANTIDAD_CUOTAS_NUMERO}}', $matricula[0]->cuotasporperiodo, $contrato->clausulas);

        /* {{MES_VENCIMIENTO_PRIMER_CUOTA}} */
        $mes_inicio_pago_texto = ucfirst($arrMesesTexto[$matricula[0]->mespagocuotainicio - 1]);

        $contrato->clausulas = str_replace(
            '{{MES_VENCIMIENTO_PRIMER_CUOTA}}', $mes_inicio_pago_texto, $contrato->clausulas);

        /* {{ANIO_VENCIMIENTO_PRIMER_CUOTA}} */
        $contrato->clausulas = str_replace(
            '{{ANIO_VENCIMIENTO_PRIMER_CUOTA}}', $anio_actual, $contrato->clausulas);

        /* {{MATRICULA_IMPORTE_TEXTO}} */
        //  -------------- no tiene en cuenta decimales ----------------
        $importe = (int) $matricula[0]->matriculaimporte;
        $importe_matricula_texto = 'PESOS ' . strtoupper(AifLibNumber::toWord($importe)) . ' C/00/100';

        $contrato->clausulas = str_replace(
            '{{MATRICULA_IMPORTE_TEXTO}}', $importe_matricula_texto, $contrato->clausulas);

        /* {{MATRICULA_IMPORTE_NUMERO}} */
        $importe = number_format($matricula[0]->matriculaimporte, 2, ',', '.');
        $importe_matricula_numero = '$' . $importe;

        $contrato->clausulas = str_replace(
            '{{MATRICULA_IMPORTE_NUMERO}}', $importe_matricula_numero, $contrato->clausulas);


        /* SE GUARDA EL CONTRATO GENERADO */
        $contrato_generado = new Contratos;

            $contrato_generado->organizacion_id = $organizacion_id;
            $contrato_generado->tipocontrato_id = $tipo_contrato_id;
            $contrato_generado->alumno_id = $alumno_id;
            $contrato_generado->ciclolectivo_id = $ciclo_id;
            $contrato_generado->fechadesde = $ciclo_lectivo->fechainicio;
            $contrato_generado->fechahasta = $ciclo_lectivo->fechafin;
            $contrato_generado->carrera_id = $carrera_id;
            $contrato_generado->cantidadcuotas = $matricula[0]->cuotasporperiodo;
            $contrato_generado->cuotaimporte = $matricula[0]->cuotaimporte;
            $contrato_generado->matriculaimporte = $matricula[0]->matriculaimporte;
            $contrato_generado->totalimporte = $total_anual;
            $contrato_generado->usuario_alta = Auth::user()->usuario;
            $contrato_generado->fecha_alta = date('Y-n-j');

        $contrato_generado->save();


        $pdf = PDF::loadView(
            'contratos.pdf.contrato',
            ['contrato' => $contrato]
        );
        return $pdf->setPaper('Legal')->stream();

    }

    private function _es_mayor_de_edad($fecha_nacimiento)
    {
        list($dia, $mes, $anio) = explode("/", $fecha_nacimiento);

        $edad = (date("md") < $mes . $dia) ? date("Y") - $anio - 1 : date("Y") - $anio;

        return ($edad >= 18);
    }
    
}