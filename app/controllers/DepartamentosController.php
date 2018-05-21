<?php

class DepartamentosController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$arrDepartamento = Departamento::all();

        return View::make('departamentos.index')
            ->with('arrDepartamento', $arrDepartamento);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make('departamentos.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $rules = array(
            'txtDepartamento' => 'required',
            'txtProvinciaId' => 'required',
        );

        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('departamentos/create')
                ->withErrors($validator);
        } else {
            // store
            $departamento = new Departamento;
            $departamento->descripcion = Input::get('txtDepartamento');
            $departamento->provincia_id = Input::get('txtProvinciaId');
            $departamento->usuario_alta = Auth::user()->usuario;
            $departamento->fecha_alta = date('Y-m-d');
            $departamento->save();

            // redirect
            Session::flash('message', 'departamento creado!');
            return Redirect::to('departamentos');
        }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$departamento = Departamento::find($id);
		/*if (empty($organizacion)) {
			echo 'vacio';
			exit;
		}*/
        return View::make('departamentos.show')
            ->with('departamento', $departamento);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$departamento = Departamento::find($id);
        return View::make('departamentos.edit')
            ->with('departamento', $departamento);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        $rules = array(
            'txtDepartamento' => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('departamentos/' . $id . '/edit')
                ->withErrors($validator);
        } else {
            // store
            $departamento = Departamento::find($id);
            $departamento->descripcion = Input::get('txtDepartamento');
            $departamento->usuario_modi = Auth::user()->usuario;
            $departamento->fecha_modi = date('Y-m-d');
            $departamento->save();

            // redirect
            Session::flash('message', 'Actualizado!');
            return Redirect::to('departamentos');
        }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        // delete
        $departamento = Departamento::find($id);
        $departamento->delete();

        // redirect
        Session::flash('message', 'Eliminado!');
        return Redirect::to('departamentos');
	}

}
