<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;

class InscripcionesController extends BaseController {

    const OPERACION_EXITOSA = 1;
    const OPERACION_FALLIDA = 2;
    const OPERACION_CANCELADA = 3;
    const OPERACION_INFO = 4;
    const NO_EXISTE_CICLO_ACTIVO = 5;
    const NO_HAY_INSCRITOS = 6;
    const NO_TIENE_INSCRIPCION = 7;


    public function getIndex() {
        return View::make('inscripcionfinal.gestion');
    }

    /* REFACTORING */
    /* ALUMNO-CARRERA */
    public function getInscribiralumno($alumno_id)
    {
        $alumno = Alumno::find($alumno_id);
        $organizaciones = Organizacion::lists('nombre', 'id');
        $alumno_carrera = AlumnoCarrera::where('alumno_id', '=', $alumno_id)->get();

        /* REFACTORING */
        $arrCiclosLectivos = new ArrayObject;

        foreach ($alumno->carreras as $carrera) {
            foreach ($alumno_carrera as $inscripcion) {
                if ((int)$carrera->id == (int)$inscripcion->carrera_id) {
                    $ciclo = CicloLectivo::find($inscripcion->ciclolectivo_id);
                    $carrera->descripcion_ciclo = $ciclo->descripcion;
                    $carrera->inscripcion_id = $inscripcion->id;
                    break;
                }
            }
        }

        array_unshift($organizaciones, 'Seleccionar');

        return View::make('alumnos.asignarcarreras')
            ->with('alumno', $alumno)
            ->with('organizaciones', $organizaciones)
            ->with('arrCiclosLectivos', $arrCiclosLectivos)
            ->with('menu', ModulosHelper::MENU_GESTION_ACADEMICA)
            ->with('submenu', ModulosHelper::SUBMENU_INSCRIPCIONES)
            ->with('leer', Session::get('ALUMNO_LEER'))
            ->with('editar', Session::get('ALUMNO_EDITAR'))
            ->with('imprimir', Session::get('ALUMNO_IMPRIMIR'))
            ->with('eliminar', Session::get('ALUMNO_ELIMINAR'));
    }

    /* REFACTORING */
    public function postGuardar()
    {
        //$organizacion_id = Input::get('cboOrganizacion');
        $alumno_id = Input::get('txt_alumno_id');
        $ciclo_id  = Input::get('txt_ciclo_lectivo_id');
        $carreras  = Input::get('carreras');

        $data  = array(
            'ciclo' => $ciclo_id,
            'carrera' => $carreras
        );

        $rules = array(
            'ciclo' => 'required',
            'carrera' => 'required'
        );

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            Session::flash('message', 'ERROR AL INTENTAR INSCRIBIR AL ALUMNO.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('inscripciones/inscribiralumno/' . $alumno_id);
        }

        foreach ($carreras as $carrera) {
            $inscripcion = new AlumnoCarrera;
              $inscripcion->alumno_id       = $alumno_id;
              $inscripcion->carrera_id      = $carrera;
              $inscripcion->ciclolectivo_id = $ciclo_id;
              $inscripcion->usuario_alta    = Auth::user()->usuario;
              $inscripcion->fecha_alta      = date('Y-m-d');
            $inscripcion->save();
        }

        Session::flash('message', 'INSCRIPCIÓN REALIZADA CON ÉXITO!');
        Session::flash('message_type', self::OPERACION_EXITOSA);
        return Redirect::to('inscripciones/inscribiralumno/' . $alumno_id);
    }

    /* REFACTORING LO QUE SE ENVIA POR JSON */
    public function postObtenercicloactivo()
    {
        $organizacion_id = Input::get('organizacion_id');
        $existe = CicloLectivo::verificaExisteCicloActivo($organizacion_id);

        if (!$existe)
            return Response::json(self::NO_EXISTE_CICLO_ACTIVO);

        $ciclo_lectivo_activo = CicloLectivo::getCicloActivo($organizacion_id);

        return Response::json($ciclo_lectivo_activo[0]);
    }

    public function getEliminar($id)
    {
        $inscripcion = AlumnoCarrera::find($id);
        $alumno_id = $inscripcion->alumno_id;

        try
        {
            $inscripcion->delete();
        }
        catch(Exception $ex)
        {
            Session::flash('message', 'LA INSCRIPCION TIENE INFORMACIÓN RELACIONADA. NO SE PUEDE ELIMINAR.');
            Session::flash('message_type', self::OPERACION_FALLIDA);
            return Redirect::to('inscripciones/inscribiralumno/' . $alumno_id);
        }

        Session::flash('message', 'INSCRIPCIÓN ELIMINADA.');
        Session::flash('message_type', self::OPERACION_EXITOSA);
        return Redirect::to('inscripciones/inscribiralumno/' . $alumno_id);
    }

    public function postObtenercarrerasporciclo()
    {
        $id = Input::get('ciclo_lectivo_id');
        $carreras = AlumnoCarrera::getCarrerasPorCiclo($id);

        if (count($carreras) == 0)
            $carreras = self::NO_TIENE_INSCRIPCION;

        return Response::json($carreras);
    }

    public function postObtenerinscripciones()
    {
        $ciclo = Input::get('ciclo');
        $carrera = Input::get('carrera');

        $inscripciones = AlumnoCarrera::getInscripciones($ciclo, $carrera);

        if (count($inscripciones) == 0)
            $inscripciones = self::NO_HAY_INSCRITOS;

        return Response::json($inscripciones);
    }

    public function postObtenerinscripcionesporciclo()
    {
        $ciclo = Input::get('ciclo');

        $inscripciones = AlumnoCarrera::getInscripcionesPorCiclo($ciclo);

        if (count($inscripciones) == 0) {
            $inscripciones = self::NO_HAY_INSCRITOS;
        } else {
            foreach ($inscripciones as $inscripcion) {
                $contactos = ContactoPersona::where(
                    'persona_id', '=', $inscripcion->persona_id)->get();
                $inscripcion->contactos = $contactos;
            }
        }

        return Response::json($inscripciones);
    }


}