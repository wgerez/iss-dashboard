<?php

class TiposContratosController extends BaseController {

    const OPERACION_EXITOSA = 1;
    const OPERACION_FALLIDA = 2;

    public function getEditar()
    {
    	// 1 = contratos id menores de edad
        // 2 = contratos id mayores de edad
        $contratos = TipoContrato::all();

		return View::make('contratos.editar')
            ->with('contratos', $contratos)
            ->with('menu', ModulosHelper::MENU_GESTION_CONTABLE)
            ->with('submenu', ModulosHelper::SUBMENU_CONTRATOS)
            ->with('submenu2', ModulosHelper::SUBMENU_2_EDICION_CONTRATOS)
            ->with('leer', Session::get('CONTRATOS_LEER'))
            ->with('editar', Session::get('CONTRATOS_EDITAR'))
            ->with('imprimir', Session::get('CONTRATOS_IMPRIMIR'))
            ->with('eliminar', Session::get('CONTRATOS_ELIMINAR'));
    }

    public function postUpdate()
    {
    	$titulo_mayor_edad = Input::get('txtTituloMayorEdad');
    	$clausulas_mayor_edad = Input::get('txtContratoMayorEdad');
        $titulo_menor_edad = Input::get('txtTituloMenorEdad');
        $clausulas_menor_edad = Input::get('txtContratoMenorEdad');

    	$contratos = TipoContrato::all();

   		$contratos[0]->titulo = $titulo_mayor_edad;
   		$contratos[0]->clausulas = trim($clausulas_mayor_edad);
    	$contratos[0]->save();

        $contratos[1]->titulo = $titulo_menor_edad;
        $contratos[1]->clausulas = trim($clausulas_menor_edad);
        $contratos[1]->save();

        Session::flash('message', 'LA EDICIÓN DE CONTRATOS SE HA REALIZADO CON ÉXITO.');
        Session::flash('message_type', self::OPERACION_EXITOSA);
        return Redirect::to('tiposcontratos/editar');
    }

    public function getPdfcontrato($id)
    {
        $contrato = TipoContrato::find($id);

        $pdf = PDF::loadView(
            'contratos.pdf.contrato',
            ['contrato' => $contrato]
        );
        return $pdf->setPaper('Legal')->stream();

    }
}
