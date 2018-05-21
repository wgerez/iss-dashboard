@extends('layouts.master')

@section('customstyle')
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/select2/select2.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css')}}"/>
<style>
.fixed {
	position:fixed;
	top: 60px;
	right: 20px;
	z-index: 999
}
</style>
@stop
<?php
$id = '';
$titular_id = '';
$doctitular = '';
$apeynomtitular = '';
$provisorio_id = '';
$apeynomprovisorio = '';
$docprovisorio = '';
$suplente_id = '';
$apeynomsuplente = '';
$docsuplente = '';
$horaentrada = '';
$minutoentrada = '';
$horasalida = '';
$minutosalida = '';
$horaentradama = '';
$minutoentradama = '';
$horasalidama = '';
$minutosalidama = '';
$horaentradami = '';
$minutoentradami = '';
$horasalidami = '';
$minutosalidami = '';
$horaentradaj = '';
$minutoentradaj = '';
$horasalidaj = '';
$minutosalidaj = '';
$horaentradav = '';
$minutoentradav = '';
$horasalidav = '';
$minutosalidav = '';
$horaentradas = '';
$minutoentradas = '';
$horasalidas = '';
$minutosalidas = '';
$lunes = '';
$martes = '';
$miercoles = '';
$jueves = '';
$viernes = '';
$sabado = '';

if (count($docentes) > 0) {
	foreach ($docentes as $docente) {
		$id = $docente['id'];
		$titular_id = $docente['titular_id'];
		$doctitular = $docente['doctitular'];
		$apeynomtitular = $docente['apeynomtitular'];
	    $provisorio_id = $docente['provisorio_id'];
	    $apeynomprovisorio = $docente['apeynomprovisorio'];
	    $docprovisorio = $docente['docprovisorio'];
	    $suplente_id = $docente['suplente_id'];
	    $apeynomsuplente = $docente['apeynomsuplente'];
	    $docsuplente = $docente['docsuplente'];

		foreach ($docente['dias'] as $value) {
		    $horaentrada = $value['horaentrada'];
			$minutoentrada = $value['minutoentrada'];
			$horasalida = $value['horasalida'];
			$minutosalida = $value['minutosalida'];

			if ($value['dia'] == 'Lunes') {
				$lunes = 'checked';
				$horaentradal = $horaentrada;
				$minutoentradal = $minutoentrada;
				$horasalidal = $horasalida;
				$minutosalidal = $minutosalida;
			}

	    	if ($value['dia'] == 'Martes') {
	    		$martes = 'checked';
				$horaentradama = $horaentrada;
				$minutoentradama = $minutoentrada;
				$horasalidama = $horasalida;
				$minutosalidama = $minutosalida;
	    	}

	    	if ($value['dia'] == 'Miercoles') {
	    		$miercoles = 'checked';
				$horaentradami = $horaentrada;
				$minutoentradami = $minutoentrada;
				$horasalidami = $horasalida;
				$minutosalidami = $minutosalida;
	    	}

	    	if ($value['dia'] == 'Jueves') {
	    		$jueves = 'checked';
				$horaentradaj = $horaentrada;
				$minutoentradaj = $minutoentrada;
				$horasalidaj = $horasalida;
				$minutosalidaj = $minutosalida;
	    	}

	    	if ($value['dia'] == 'Viernes') {
	    		$viernes = 'checked';
				$horaentradav = $horaentrada;
				$minutoentradav = $minutoentrada;
				$horasalidav = $horasalida;
				$minutosalidav = $minutosalida;
	    	}

	    	if ($value['dia'] == 'Sabado') {
	    		$sabado = 'checked';
				$horaentradas = $horaentrada;
				$minutoentradas = $minutoentrada;
				$horasalidas = $horasalida;
				$minutosalidas = $minutosalida;
	    	}
		}
	}
	/*highlight_string(var_export($docentes[0]['dias'],true));
        exit();*/
    
}

//BOTONES Y CAMPOS DE PERMISOS
$disabled = (!$editar) ? 'disabled' : '';
$readonly = (!$editar) ? 'readonly' : '';
$imprimir = (!$imprimir) ? 'disabled' : '';
?>
@section('content')
	<!-- COMIENZO CONTENIDO -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- COMIENZO DEL HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- COMIENZO TITULO & BREADCRUMB-->
					<h3 class="page-title">
					Asignación de Docentes <small> Registrar docente a materia</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('asignardocente/asignadocente')}}">Listado</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">docente</a>
						</li>						
					</ul>
					<!-- FIN DE TITULO & BREADCRUMB-->
				</div>
			</div>
			<!-- FIN DE HEADER-->
			<!-- COMIENZO DEL CONTENIDO-->
			<div class="row">
				<div class="col-md-12">
					<!-- PARA MOSTRAR ALERTAS - ERRORES - INFORMACIÓN ETC. USAREMOS ESTE DIV. DEPENDIENDO DEL TIPO (note-danger=rojo - note-info=celeste - note-warning=rojo - note-success=verde) USAR DISPLAY:NONE  -->
					@if (Session::has('message'))
					    @if (Session::get('message_type') == AsignarDocenteController::OPERACION_EXITOSA)

					        <div class="note note-success">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == AsignarDocenteController::OPERACION_FALLIDA)

					        <div class="note note-danger">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == AsignarDocenteController::OPERACION_CANCELADA)

					        <div class="note note-warning">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == AsignarDocenteController::OPERACION_INFO)

					        <div class="note note-info">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@endif
					@endif
					<!-- COMIENZO DE LA TABLA-->
								{{ Form::open(array('url'=>'asignardocente/guardar', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmListadoasistencias', 'name'=>'FrmListadoalumnos'))}}
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-files-o"></i> Asignar docentes
							</div>
							<div class="actions">
								<a href="{{url('asignardocente/crear')}}" {{$disabled}} class="btn default blue-stripe" <?php if ($habilita == true) echo "disabled"; ?>>
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Nuevo </span>
								</a>
								<!--button type='submit' class="btn default green-stripe" {{ $disabled }} <?php if ($habilita == true) echo "disabled"; ?>>
								<i class="fa fa-save"></i>
								<span class="hidden-480">
								Guardar </span>
								</button-->
								<a href="{{url('asignardocente/asignadocente')}}" {{ $disabled }} class="btn default red-stripe">
								<i class="fa fa-reorder"></i>
								<span class="hidden-480">
								Listado </span>
								</a>
								<!--a target="_blank" href="#" id="imprimir" {{$imprimir}} class="btn default yellow-stripe">
								<i class="fa fa-print"></i>
								<span class="hidden-480">
								Imprimir </span>
								</a-->								
							</div>
						</div>
						<div class="portlet-body form">
							<div class="form-body">
								<div class="form-group">
									<label  class="col-md-2 col-sm-2 control-label">Organización:</label>
									<div class="col-md-6 col-sm-6">
										{{ Form::select('cboOrganizacion', $organizaciones, Input::old('organizacion'), array('class'=>'table-group-action-input form-control','id'=>'cboOrganizacion')); }}
									</div>
								</div>

								<div class="form-group <?php if ($errors->has('cboCarrera')) echo 'has-error' ?>">
									<label class="col-md-2 col-sm-2 control-label" for="cbocarrera">Carrera:</label>
									<div class="col-md-6 col-sm-6">
										<select name="cboCarrera" id="cboCarrera" class="table-group-action-input form-control">
											<option value="0">Seleccione</option>
											@if (isset($carreras))
												@foreach ($carreras as $carrera)
													<option value="{{$carrera->id}}" <?php if ($carrera->id == $carrera_id) echo "selected"; ?>>{{$carrera->carrera}}</option>
												@endforeach
											@endif
										</select>
										@if ($errors->has('cboCarrera'))
										    <span class="help-block">{{ $errors->first('cboCarrera') }}</span>
									    @endif
									</div>
								</div>

								<div class="form-group <?php if ($errors->has('cboPlan')) echo 'has-error' ?>">
									<label class="col-md-2 col-sm-2 control-label" for="filtro">Plan Estudio:</label>
									<div class="col-md-2 col-sm-3">
										<select name="cboPlan" id="cboPlan" class="table-group-action-input form-control">
											<option value="0">Seleccione</option>
											@if (isset($planes))
												@foreach ($planes as $plan)
													<option value="{{$plan->id}}" <?php if ($plan->id == $planID) echo "selected"; ?>>{{$plan->codigoplan}}</option>
												@endforeach
											@endif
										</select>
										@if ($errors->has('cboPlan'))
										    <span class="help-block">{{ $errors->first('cboPlan') }}</span>
									    @endif
									</div>
								</div>

								<div class="form-group <?php if ($errors->has('cboMaterias')) echo 'has-error' ?>">
									<label class="col-md-2 col-sm-2 control-label" for="cboMaterias">Materias:</label>
									<div class="col-md-6 col-sm-6">
										<select name="cboMaterias" id="cboMaterias" class="table-group-action-input form-control">
											<option value="0">Seleccione</option>
											@if (isset($materias))
												@foreach ($materias as $materia)
													<option value="{{$materia->id}}" <?php if ($materia->id == $materia_id) echo "selected"; ?>>{{$materia->nombremateria}}</option>
												@endforeach
											@endif
										</select>
										@if ($errors->has('cboMaterias'))
										    <span class="help-block">{{ $errors->first('cboMaterias') }}</span>
									    @endif
									</div>
									<input class="form-control" name="txtid" id="txtid" type="hidden" value="<?php if ($idaseguir) echo $idaseguir; ?>">
									<!--div class="col-md-2 col-sm-2">
										<a class="btn blue-madison" id='btnBuscar'>
											<i class="fa fa-search"></i> Buscar
										</a>
									</div-->
								</div>
								<br>

								<div class="portlet form-horizontal">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-users"></i> Docentes
										</div>
									</div>

									<div class="portlet-body form">
										<div class="form-body">
											<div class="form-group <?php if ($errors->has('txttitular_id')) echo 'has-error' ?>">
												<label  class="col-md-2 col-sm-2 control-label">Docente Titular:</label>
												<div class="col-md-2 col-sm-4">
													<select name="cboFiltroTitular" id="cboFiltroTitular" class="table-group-action-input form-control">
														<option value="1">Documento</option>
														<option value="2">Apellido y Nombre</option>
													</select>
												</div>
												<div class="col-md-4 col-sm-4">
													<input class="form-control" name="txttitular" id="txttitular" type="text" value="{{ Input::old('txttitular') }}">
													<input class="form-control" name="txttitular_id" id="txttitular_id" type="hidden" value="{{ Input::old('txttitular_id') }}">
												</div>
											    @if ($errors->has('txttitular_id'))
												    <span class="help-block">{{ $errors->first('txttitular_id') }}</span>
											    @endif
												<div class="col-md-2 col-sm-2">
													<a class="btn blue-madison" id='btnBuscart' <?php if (isset($alumnosinscriptos)) echo "disabled"; ?>>
														<i class="fa fa-search"></i> 
													</a>
												</div>
											</div>

												<div class="form-group">
													<label  class="col-md-2 col-sm-2 control-label text-info">Docente:</label>
													<div class="col-md-2 col-sm-4" id='divTitular'><?php if ($apeynomtitular) echo $apeynomtitular; ?></div>
													<label  class="col-md-2 col-sm-2 control-label text-info">DNI:</label>
													<div class="col-md-2 col-sm-4" id='divDNIt'><?php if ($doctitular) echo $doctitular; ?></div>								
												</div>

											<div class="form-group <?php if ($errors->has('txtpropietario_id')) echo 'has-error' ?>">
												<label  class="col-md-2 col-sm-2 control-label">Docente Provisorio:</label>
												<div class="col-md-2 col-sm-4">
													<select name="cboFiltroPropietario" id="cboFiltroPropietario" class="table-group-action-input form-control">
														<option value="1">Documento</option>
														<option value="2">Apellido y Nombre</option>
													</select>
												</div>
												<div class="col-md-4 col-sm-4">
													<input class="form-control" name="txtpropietario" id="txtpropietario" type="text" value="{{ Input::old('txtpropietario') }}">
													<input class="form-control" name="txtpropietario_id" id="txtpropietario_id" type="hidden" value="{{ Input::old('txtpropietario_id') }}">
												</div>
											    @if ($errors->has('txtpropietario_id'))
												    <span class="help-block">{{ $errors->first('txtpropietario_id') }}</span>
											    @endif
												<div class="col-md-2 col-sm-2">
													<a class="btn blue-madison" id='btnBuscarp' <?php if (isset($alumnosinscriptos)) echo "disabled"; ?>>
														<i class="fa fa-search"></i> 
													</a>
												</div>
											</div>

												<div class="form-group">
													<label  class="col-md-2 col-sm-2 control-label text-info">Docente:</label>
													<div class="col-md-2 col-sm-4" id='divProvisorio'><?php if ($apeynomprovisorio) echo $apeynomprovisorio; ?></div>
													<label  class="col-md-2 col-sm-2 control-label text-info">DNI:</label>
													<div class="col-md-2 col-sm-4" id='divDNIp'><?php if ($docprovisorio) echo $docprovisorio; ?></div>								
												</div>

											<div class="form-group <?php if ($errors->has('txtsuplente_id')) echo 'has-error' ?>">
												<label  class="col-md-2 col-sm-2 control-label">Docente Suplente:</label>
												<div class="col-md-2 col-sm-4">
													<select name="cboFiltroSuplente" id="cboFiltroSuplente" class="table-group-action-input form-control">
														<option value="1">Documento</option>
														<option value="2">Apellido y Nombre</option>
													</select>
												</div>
												<div class="col-md-4 col-sm-4">
													<input class="form-control" name="txtsuplente" id="txtsuplente" type="text" value="{{ Input::old('txtsuplente') }}">
													<input class="form-control" name="txtsuplente_id" id="txtsuplente_id" type="hidden" value="{{ Input::old('txtsuplente_id') }}">
												</div>
											    @if ($errors->has('txtsuplente_id'))
												    <span class="help-block">{{ $errors->first('txtsuplente_id') }}</span>
											    @endif
												<div class="col-md-2 col-sm-2">
													<a class="btn blue-madison" id='btnBuscars' <?php if (isset($alumnosinscriptos)) echo "disabled"; ?>>
														<i class="fa fa-search"></i> 
													</a>
												</div>
											</div>

												<div class="form-group">
													<label  class="col-md-2 col-sm-2 control-label text-info">Docente:</label>
													<div class="col-md-2 col-sm-4" id='divSuplente'><?php if ($apeynomsuplente) echo $apeynomsuplente; ?></div>
													<label  class="col-md-2 col-sm-2 control-label text-info">DNI:</label>
													<div class="col-md-2 col-sm-4" id='divDNIs'><?php if ($docsuplente) echo $docsuplente; ?></div>								
												</div>

										</div>
									</div>
								</div>
								<br>
								<div class="portlet form-horizontal">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-calendar"></i>Horarios de Clases
										</div>
									</div>
									<div class="portlet-body form">
										<div class="form-body">
											<div class="form-group col-md-12 col-sm-12">
												<div class="col-md-2 col-sm-2">
													<center>
														<label class="control-label" for="asistencias">Días de Clases:</label>
													</center>
												</div>
												<div class="form-group">
													<div class="col-md-1 col-sm-2">
														<center>
															<label class="control-label" for="lunes">Lunes
															<input type="checkbox" class="form-control" id="lunes" name="lunes" value="Lunes"></label>
														</center>
													</div>
												
													<div class="col-md-1 col-sm-2">
														<center>
															<label class="control-label" for="martes">Martes
															<input type="checkbox" class="form-control" id="martes" name="martes" value="Martes"></label>
														</center>
													</div>
												
													<div class="col-md-1 col-sm-2">
														<center>
															<label class="control-label" for="miercoles">Miércoles
															<input type="checkbox" class="form-control" id="miercoles" name="miercoles" value="Miercoles"></label>
														</center>
													</div>
												
													<div class="col-md-1 col-sm-2">
														<center>
															<label class="control-label" for="jueves">Jueves
															<input type="checkbox" class="form-control" id="jueves" name="jueves" value="Jueves"></label>
														</center>
													</div>
												
													<div class="col-md-1 col-sm-2">
														<center>
															<label class="control-label" for="viernes">Viernes
															<input type="checkbox" class="form-control" id="viernes" name="viernes" value="Viernes"></label>
														</center>
													</div>
												
													<div class="col-md-1 col-sm-2">
														<center>
															<label class="control-label" for="sabado">Sábados
															<input type="checkbox" class="form-control" id="sabado" name="sabado" value="Sabado"></label>
														</center>
													</div>

													<div class="col-md-1 col-sm-2">
														<center>
															<label class="control-label" for="todos">Todos
															<input type="checkbox" class="form-control" id="todos" name="todos" value="Todos"></label>
														</center>
													</div>
												</div>

												<div class="form-group">
													<label  class="col-md-2 col-sm-2 control-label">Hora Entrada:</label>
													<div class="col-md-1 col-sm-1">
														<input type="number" class="form-control" min="0" max="24" id="horaentrada" name="horaentrada" value="{{ Input::old('horaentrada') }}">
													</div>
													<div class="col-md-1 col-sm-1">
														<input type="number" class="form-control" min="0" max="59" id="minutoentrada" name="minutoentrada" value="{{ Input::old('minutoentrada') }}">
													</div>

													<label  class="col-md-2 col-sm-2 control-label">Hora Salida:</label>
													<div class="col-md-1 col-sm-1">
														<input type="number" class="form-control" min="0" max="24" id="horasalida" name="horasalida" value="{{ Input::old('horasalida') }}">
													</div>
													<div class="col-md-1 col-sm-1">
														<input type="number" class="form-control" min="0" max="59" id="minutosalida" name="minutosalida" value="{{ Input::old('minutosalida') }}">
													</div>

													<div class="col-md-3 col-sm-2">
														<!--a class="btn blue-madison" id='btnAgregar'>
															<i class="glyphicon glyphicon-download-alt"></i> Agregar
														</a-->
														<button type='submit' class="btn blue-madison" {{ $disabled }}>
															<i class="glyphicon glyphicon-download-alt"></i>
															<span class="hidden-480"> Agregar </span>
														</button>
													</div>
												</div>
												<br>
												<br>

											</div>
											<br>
											<br>
										</div>
									</div>
								</div>
								<br>
								<br>

								<div class="portlet-body">
									<div class="box-body table-responsive no-padding">
										<table class="table table-striped table-bordered table-hover" id="table_asistencias">
											<thead>
											<tr>
												<th>
													<center><i class="fa fa-user"></i> Docente Titular</center>
												</th>
												<th>
													<center><i class="fa fa-user"></i> Docente Provisorio</center>
												</th>
												<th>
													<center><i class="fa fa-user"></i> Docente Suplente</center>
												</th>
												<th>
													<center><i class="fa fa-calendar"></i> Dias</center>
												</th>
												<th>
													<center><i class="fa fa-calendar"></i> Hora Entrada</center>
												</th>
												<th>
													<center><i class="fa fa-calendar"></i> Hora Salida</center>
												</th>
												<th>
													<center>Acciones</center>
												</th>
											</tr>
											</thead>
											<tbody>
											<?php
											$bandera = true;
											$id = 0;
											$tablacargada = '';
											$tabla = '';
											$tabladetalle = '';
											?>
											@if (isset($docentes))
												@foreach ($docentes as $docente)
													<?php
													$tabla = '<tr><td><center>'. $docente['apeynomtitular'] .'</center></td><td><center>'. $docente['apeynomprovisorio'] .'</center></td><td><center>'. $docente['apeynomsuplente'] .'</center></td>';

													$id = $docente['id'];

													foreach ($docente['dias'] as $dia) {
														$diaa = $dia['dia'];

														if ($diaa == 'Miercoles') {
															$diaa = 'Miércoles';
														}

														if ($diaa == 'Sabado') {
															$diaa = 'Sábado';
														}

														if ($bandera == true) {
															$tabladetalle = '<td><center>'. $diaa .'</center></td><td><center>'. $dia['horaentrada'] .':'. $dia['minutoentrada'] .'</center></td><td><center>'. $dia['horasalida'] .':'. $dia['minutosalida'] .'</center></td><td><center><a href="#" data-id="'. $dia['diaid'] .'"  class="btn default btn-xs red btnEliminarMaterias" data-toggle="modal" data-target="#deletePlan"><i title="Eliminar" class="fa fa-trash-o"></i></a></center></td></tr>';
															$bandera = false;
														} else {
															$tabladetalle = '<tr><td><center></center></td><td><center></center></td><td><center></center></td><td><center>'. $diaa .'</center></td><td><center>'. $dia['horaentrada'] .':'. $dia['minutoentrada'] .'</center></td><td><center>'. $dia['horasalida'] .':'. $dia['minutosalida'] .'</center></td><td><center><a href="#" data-id="'. $dia['diaid'] .'"  class="btn default btn-xs red btnEliminarMaterias" data-toggle="modal" data-target="#deletePlan"><i title="Eliminar" class="fa fa-trash-o"></i></a></center></td></tr>';
														}

														$tabla .= $tabladetalle;
													}

													$tablacargada .= $tabla;
													?>
												@endforeach
											@endif

											<?php echo $tablacargada; ?>
											</tbody>
										</table>
									</div>
								</div>
								<br>
								<br>

								</div>
							</div>

							</div>
						</div>
					</div>
								{{ Form::close() }}
					<!-- FIN DE LA TABLA-->
				</div>
			</div>
			<!-- FIN DEL CONTENIDO -->

			<!-- MODAL-->
			<div class="modal fade" id="MensajeCantidad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title">Atención!</h4>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<center><div class="col-md-12 col-sm-12 control-label text-info" id='divMensaje'></div></center><br><br>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn default" data-dismiss="modal">Cerrar</button>
						</div>
					</div>
				</div>
			</div>
			<!-- FIN MODAL-->

						<!-- MODAL ELIMINACION DE CICLOS-->
						<div class="modal fade" id="modalEliminaCorrelatividad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							{{ Form::open(array('url' => 'asignardocente/borrar')) }}
								<input id="idPlanHidden" name='idPlanHidden' type="hidden" value="">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Eliminar Asignación Docente</h4>
										</div>
										<div class="modal-body">
											¿Estás seguro de querer borrar este registro?
										</div>
										<div class="modal-footer">
											<button type="submit" class="btn red"><i class="fa fa-trash-o"></i> Eliminar</button>
											<button type="button" class="btn default" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> Cancelar</button>
										</div>
									</div>
									<!-- /.modal-contenido -->
								</div>
							{{Form::close()}}
							<!-- /.modal-dialog -->
						</div>
						<!-- /.modal -->
							
		</div>
	</div>
	<!-- FIN -->

@stop

@section('customjs')
	//TableAdvanced.init();
	
	//$("#imprimir").attr('disabled', 'disabled');
	//$("#horaentradal").attr('disabled', 'disabled');

	function Consultardia(dia) {
        $("#horaentrada").val('');
        $("#minutoentrada").val('');
        $("#horasalida").val('');
        $("#minutosalida").val('');
		var materia_id = $('#cboMaterias').val();
    	var carrera_id = $('#cboCarrera').val();
        var planID = $('#cboPlan').val();

		$.ajax({
		  url: "{{url('asignardocente/obtenerdia')}}",
		  data:{'materia_id': materia_id, 'carrera_id': carrera_id, 'planID': planID, 'dia': dia},
		  type: 'POST'
		}).done(function(dias) {
			console.log(dias);

			$.each(dias, function(key, value) {
				$("#horaentrada").val(value.horaentrada);
		        $("#minutoentrada").val(value.minutoentrada);
		        $("#horasalida").val(value.horasalida);
		        $("#minutosalida").val(value.minutosalida);
			});

		}).error(function(data) {
			console.log(data);
		});
	}

	$("#lunes").change(function () {
	    if ($(this).is(':checked')) {
	        /*var dia = 'Lunes';
	        Consultardia(dia);*/
	        $("#horaentrada").removeAttr("disabled");
	        $("#minutoentrada").removeAttr("disabled");
	        $("#horasalida").removeAttr("disabled");
	        $("#minutosalida").removeAttr("disabled");
	        //$('#martes').prop( "checked", false );
	    } else {
	        /*$("#horaentrada").val('');
	        $("#minutoentrada").val('');
	        $("#horasalida").val('');
	        $("#minutosalida").val('');
	        $("#horaentrada").attr('disabled', 'disabled');
	        $("#minutoentrada").attr('disabled', 'disabled');
	        $("#horasalida").attr('disabled', 'disabled');
	        $("#minutosalida").attr('disabled', 'disabled');*/
	    }
	});

	$("#martes").change(function () {
	    if ($(this).is(':checked')) {
	        /*var dia = 'Martes';
	        Consultardia(dia);*/
	        $("#horaentrada").removeAttr("disabled");
	        $("#minutoentrada").removeAttr("disabled");
	        $("#horasalida").removeAttr("disabled");
	        $("#minutosalida").removeAttr("disabled");
	        //$('#lunes').prop( "checked", false );
	    } else {
	        /*$("#horaentrada").val('');
	        $("#minutoentrada").val('');
	        $("#horasalida").val('');
	        $("#minutosalida").val('');
	        $("#horaentrada").attr('disabled', 'disabled');
	        $("#minutoentrada").attr('disabled', 'disabled');
	        $("#horasalida").attr('disabled', 'disabled');
	        $("#minutosalida").attr('disabled', 'disabled');*/
	    }
	});

	$("#miercoles").change(function () {
	    if ($(this).is(':checked')) {
	        /*var dia = 'Miercoles';
	        Consultardia(dia);*/
	        $("#horaentrada").removeAttr("disabled");
	        $("#minutoentrada").removeAttr("disabled");
	        $("#horasalida").removeAttr("disabled");
	        $("#minutosalida").removeAttr("disabled");
	    } else {
	        /*$("#horaentrada").val('');
	        $("#minutoentrada").val('');
	        $("#horasalida").val('');
	        $("#minutosalida").val('');
	        $("#horaentrada").attr('disabled', 'disabled');
	        $("#minutoentrada").attr('disabled', 'disabled');
	        $("#horasalida").attr('disabled', 'disabled');
	        $("#minutosalida").attr('disabled', 'disabled');*/
	    }
	});

	$("#jueves").change(function () {
	    if ($(this).is(':checked')) {
	        /*var dia = 'Jueves';
	        Consultardia(dia);*/
	        $("#horaentrada").removeAttr("disabled");
	        $("#minutoentrada").removeAttr("disabled");
	        $("#horasalida").removeAttr("disabled");
	        $("#minutosalida").removeAttr("disabled");
	    } else {
	        /*$("#horaentrada").val('');
	        $("#minutoentrada").val('');
	        $("#horasalida").val('');
	        $("#minutosalida").val('');
	        $("#horaentrada").attr('disabled', 'disabled');
	        $("#minutoentrada").attr('disabled', 'disabled');
	        $("#horasalida").attr('disabled', 'disabled');
	        $("#minutosalida").attr('disabled', 'disabled');*/
	    }
	});

	$("#viernes").change(function () {
	    if ($(this).is(':checked')) {
	        /*var dia = 'Viernes';
	        Consultardia(dia);*/
	        $("#horaentrada").removeAttr("disabled");
	        $("#minutoentrada").removeAttr("disabled");
	        $("#horasalida").removeAttr("disabled");
	        $("#minutosalida").removeAttr("disabled");
	    } else {
	        /*$("#horaentrada").val('');
	        $("#minutoentrada").val('');
	        $("#horasalida").val('');
	        $("#minutosalida").val('');
	        $("#horaentrada").attr('disabled', 'disabled');
	        $("#minutoentrada").attr('disabled', 'disabled');
	        $("#horasalida").attr('disabled', 'disabled');
	        $("#minutosalida").attr('disabled', 'disabled');*/
	    }
	});

	$("#sabado").change(function () {
	    if ($(this).is(':checked')) {
	        /*var dia = 'Sabado';
	        Consultardia(dia);
	        $("#horaentrada").removeAttr("disabled");
	        $("#minutoentrada").removeAttr("disabled");
	        $("#horasalida").removeAttr("disabled");
	        $("#minutosalida").removeAttr("disabled");*/
	    } else {
	        /*$("#horaentrada").val('');
	        $("#minutoentrada").val('');
	        $("#horasalida").val('');
	        $("#minutosalida").val('');
	        $("#horaentrada").attr('disabled', 'disabled');
	        $("#minutoentrada").attr('disabled', 'disabled');
	        $("#horasalida").attr('disabled', 'disabled');
	        $("#minutosalida").attr('disabled', 'disabled');*/
	    }
	});

	$("#todos").change(function () {
	    if ($(this).is(':checked')) {
	        /*var dia = 'Todos';
	        Consultardia(dia);*/
	        $("#horaentrada").removeAttr("disabled");
	        $("#minutoentrada").removeAttr("disabled");
	        $("#horasalida").removeAttr("disabled");
	        $("#minutosalida").removeAttr("disabled");
	    } else {
	        /*$("#horaentrada").val('');
	        $("#minutoentrada").val('');
	        $("#horasalida").val('');
	        $("#minutosalida").val('');
	        $("#horaentrada").attr('disabled', 'disabled');
	        $("#minutoentrada").attr('disabled', 'disabled');
	        $("#horasalida").attr('disabled', 'disabled');
	        $("#minutosalida").attr('disabled', 'disabled');*/
	    }
	});

	$("#horaentrada").change(function () {
	    var horaentrada = $("#horaentrada").val();

	    if (horaentrada > 24) {
	        $('#divMensaje').html('<p class="form-control-static"><h4>' + 'La hora ingresada no corresponde!' + '</h4></p>');
    		$('#MensajeCantidad').modal('show');
    		$("#horaentrada").val('');
    		$("#horaentrada").focus;
			return;
	    }
	});

	$("#minutoentrada").change(function () {
	    var minutoentrada = $("#minutoentrada").val();

	    if (minutoentrada > 59) {
	        $('#divMensaje').html('<p class="form-control-static"><h4>' + 'El minuto ingresado no corresponde!' + '</h4></p>');
    		$('#MensajeCantidad').modal('show');
    		$("#minutoentrada").val('');
    		$("#minutoentrada").focus();
			return;
	    }
	});

	$("#horasalida").change(function () {
	    var horasalida = $("#horasalida").val();

	    if (horasalida > 24) {
	        $('#divMensaje').html('<p class="form-control-static"><h4>' + 'La hora ingresada no corresponde!' + '</h4></p>');
    		$('#MensajeCantidad').modal('show');
    		$("#horasalida").val('');
    		$("#horasalida").focus();
			return;
	    }
	});

	$("#minutosalida").change(function () {
	    var minutosalida = $("#minutosalida").val();

	    if (minutosalida > 59) {
	        $('#divMensaje').html('<p class="form-control-static"><h4>' + 'El minuto ingresado no corresponde!' + '</h4></p>');
    		$('#MensajeCantidad').modal('show');
    		$("#minutosalida").val('');
    		$("#minutosalida").focus();
			return;
	    }
	});

	function borrar_datos_docentet() {
		 $('#divTitular').html('');
		 $('#divDNIt').html('');
		 $('#txttitular_id').val('');
	}

	function borrar_datos_docentep() {
		 $('#divProvisorio').html('');
		 $('#divDNIp').html('');
		 $('#txtpropietario_id').val('');
	}

	function borrar_datos_docentes() {
		 $('#divSuplente').html('');
		 $('#divDNIs').html('');
		 $('#txtsuplente_id').val('');
	}

    $('#btnBuscart').on('click', function() {
    	//var carrera_id = $('#cboCarrera').val();
        //var planID = $('#cboPlan').val();
        //var materia_id = $('#cboMaterias').val();
        var titular = $('#txttitular').val();
        borrar_datos_docentet();
		
	    if ($('#cboFiltroTitular').val() == 1) {
	        if ($.trim($('#txttitular').val()) == '') {
	    		$('#divMensaje').html('<p class="form-control-static"><h4>' + 'Debe ingresar el DNI del Docente' + '</h4></p>');
	    		$('#MensajeCantidad').modal('show');
	    	    return;
	    	}
	    	url_destino = "{{url('asignardocente/obtenerdocentedni')}}";
	    } else {
	        url_destino = "{{url('asignardocente/obtenerdocenteporapellidoynombre')}}";
	    }

		$.ajax({
		  url: url_destino,
		  data:{'dni': titular},
		  type: 'POST'
		}).done(function(docente) {
			console.log(docente);

				if (docente == <?php echo AsignarDocenteController::NO_EXISTE_DOCENTE ?>) {
		    		$('#divMensaje').html('<p class="form-control-static"><h4>' + 'No se ha encontrado ningún registro' + '</h4></p>');
		    		$('#MensajeCantidad').modal('show');
					return;
			    }

			    var apellido_nombre = docente.apellido + ', ' + docente.nombre;
			    var dni = docente.nrodocumento;
			    $('#txttitular_id').val(docente.docente_id);

				$('#divTitular').html('<p class="form-control-static">' + apellido_nombre + '</p>');
			    $('#divDNIt').html('<p class="form-control-static">' + dni + '</p>');

		}).error(function(data) {
			console.log(data);
		});
	});

    $('#btnBuscarp').on('click', function() {
        var titular = $('#txtpropietario').val();
        borrar_datos_docentep();
		
	    if ($('#cboFiltroPropietario').val() == 1) {
	        if ($.trim($('#txtpropietario').val()) == '') {
	    		$('#divMensaje').html('<p class="form-control-static"><h4>' + 'Debe ingresar el DNI del Docente' + '</h4></p>');
	    		$('#MensajeCantidad').modal('show');
	    	    return;
	    	}
	    	url_destino = "{{url('asignardocente/obtenerdocentedni')}}";
	    } else {
	        url_destino = "{{url('asignardocente/obtenerdocenteporapellidoynombre')}}";
	    }

		$.ajax({
		  url: url_destino,
		  data:{'dni': titular},
		  type: 'POST'
		}).done(function(docente) {
			console.log(docente);

				if (docente == <?php echo AsignarDocenteController::NO_EXISTE_DOCENTE ?>) {
		    		$('#divMensaje').html('<p class="form-control-static"><h4>' + 'No se ha encontrado ningún registro' + '</h4></p>');
		    		$('#MensajeCantidad').modal('show');
					return;
			    }

			    var apellido_nombre = docente.apellido + ', ' + docente.nombre;
			    var dni = docente.nrodocumento;
			    $('#txtpropietario_id').val(docente.docente_id);

				$('#divProvisorio').html('<p class="form-control-static">' + apellido_nombre + '</p>');
			    $('#divDNIp').html('<p class="form-control-static">' + dni + '</p>');

		}).error(function(data) {
			console.log(data);
		});
	});

    $('#btnBuscars').on('click', function() {
        var titular = $('#txtsuplente').val();
        borrar_datos_docentes();
		
	    if ($('#cboFiltroSuplente').val() == 1) {
	        if ($.trim($('#txtsuplente').val()) == '') {
	    		$('#divMensaje').html('<p class="form-control-static"><h4>' + 'Debe ingresar el DNI del Docente' + '</h4></p>');
	    		$('#MensajeCantidad').modal('show');
	    	    return;
	    	}
	    	url_destino = "{{url('asignardocente/obtenerdocentedni')}}";
	    } else {
	        url_destino = "{{url('asignardocente/obtenerdocenteporapellidoynombre')}}";
	    }

		$.ajax({
		  url: url_destino,
		  data:{'dni': titular},
		  type: 'POST'
		}).done(function(docente) {
			console.log(docente);

				if (docente == <?php echo AsignarDocenteController::NO_EXISTE_DOCENTE ?>) {
		    		$('#divMensaje').html('<p class="form-control-static"><h4>' + 'No se ha encontrado ningún registro' + '</h4></p>');
		    		$('#MensajeCantidad').modal('show');
					return;
			    }

			    var apellido_nombre = docente.apellido + ', ' + docente.nombre;
			    var dni = docente.nrodocumento;
			    $('#txtsuplente_id').val(docente.docente_id);

				$('#divSuplente').html('<p class="form-control-static">' + apellido_nombre + '</p>');
			    $('#divDNIs').html('<p class="form-control-static">' + dni + '</p>');

		}).error(function(data) {
			console.log(data);
		});
	});

	$('#cboOrganizacion').select2({
		placeholder: "Seleccione",
		allowClear: true
	});

	$('#imprimir').on('click', function(e){
		e.preventDefault();
		window.open("{{url('asistencias/imprimir')}}?planID=" + $('#cboPlan').val() + '&carrera_id=' + $('#cboCarrera').val() + '&txtalumno=' + $('#txtalumno').val() + '&fechadesde=' + $('#fechadesde').val() + '&materia_id=' + $('#cboMaterias').val() + '&docente_id=' + $('#cboDocente').val());
	});

    $('#cboMaterias').change(function() {
    	limpiar_tabla();
        borrar_datos_docentet();
        borrar_datos_docentep();
        borrar_datos_docentes();
		/*$('#lunes').prop('checked', false);
		$('#martes').attr('checked', false);
		$('#miercoles').attr('checked', false);
		$('#jueves').attr('checked', false);
		$('#viernes').attr('checked', false);
		$('#sabado').attr('checked', false);*/

        if ($('#cboMaterias').val() == 0) return;

		$('#txttitular').val('');
		$('#txttitular_id').val('');
		$('#txtpropietario').val('');
		$('#txtpropietario_id').val('');
		$('#txtsuplente').val('');
		$('#txtsuplente_id').val('');
		$('#txtid').val('');

        var materia_id = $('#cboMaterias').val();
    	var carrera_id = $('#cboCarrera').val();
        var planID = $('#cboPlan').val();

		$.ajax({
		  url: "{{url('asignardocente/obtenerdocentes')}}",
		  data:{'materia_id': materia_id, 'carrera_id': carrera_id, 'planID': planID},
		  type: 'POST'
		}).done(function(docentes) {
			console.log(docentes);

			$.each(docentes, function(key, value) {
				$('#txtid').val(value.id);
				$('#txttitular').val(value.apeynomtitular);
				$('#txttitular_id').val(value.titular_id);

				$('#txtpropietario').val(value.apeynomprovisorio);
				$('#txtpropietario_id').val(value.provisorio_id);

				$('#txtsuplente').val(value.apeynomsuplente);
				$('#txtsuplente_id').val(value.suplente_id);

				$.each(value.dias, function(key, dia) {
					/*if (dia.dia == 'Lunes') {
						$('#lunes').prop( "checked", true );
					}

					if (dia.dia == 'Martes') {
						$('#martes').prop( "checked", true );
					}

					if (dia.dia == 'Miercoles') {
						$('#miercoles').prop( "checked", true );
					}

					if (dia.dia == 'Jueves') {
						$('#jueves').prop( "checked", true );
					}

					if (dia.dia == 'Viernes') {
						$('#viernes').prop( "checked", true );
					}

					if (dia.dia == 'Sabado') {
						$('#sabado').prop( "checked", true );
					}*/
				});
			});

			$.ajax({
			  url: "{{url('asignardocente/obtenerasignacion')}}",
			  data:{'materia_id': materia_id, 'carrera_id': carrera_id, 'planID': planID},
			  type: 'POST'
			}).done(function(docentes) {
				console.log(docentes);

				$("#table_asistencias").find("tr:gt(0)").remove();
				
				var tablacargada = '';
				var tabla = '';
				var tabladetalle = '';
				var id = 0;
				var bandera = true;
				
				$.each(docentes, function(key, value) {
					bandera = true;

					tabla = '<tr><td><center>'+value.apeynomtitular+'</center></td><td><center>'+value.apeynomprovisorio+'</center></td><td><center>'+value.apeynomsuplente+'</center></td>';

					id = value.id;

					$.each(value.dias, function(key, dia) {
						var diaa = dia.dia;

						if (diaa == 'Miercoles') {
							diaa = 'Miércoles';
						}

						if (diaa == 'Sabado') {
							diaa = 'Sábado';
						}

						if (bandera == true) {
							tabladetalle = '<td><center>'+diaa+'</center></td><td><center>'+dia.horaentrada+'</center></td><td><center>'+dia.horasalida+'</center></td><td><center><a href="#" data-id="'+dia.diaid+'"  class="btn default btn-xs red btnEliminarMaterias" data-toggle="modal" data-target="#deletePlan"><i title="Eliminar" class="fa fa-trash-o"></i></a></center></td></tr>';
							bandera = false;
						} else {
							tabladetalle = '<tr><td><center></center></td><td><center></center></td><td><center></center></td><td><center>'+diaa+'</center></td><td><center>'+dia.horaentrada+'</center></td><td><center>'+dia.horasalida+'</center></td><td><center><a href="#" data-id="'+dia.diaid+'"  class="btn default btn-xs red btnEliminarMaterias" data-toggle="modal" data-target="#deletePlan"><i title="Eliminar" class="fa fa-trash-o"></i></a></center></td></tr>';
						}

						tabla += tabladetalle;
					});

					tablacargada += tabla;
				});

				$('#table_asistencias > tbody').append(tablacargada);

			}).error(function(data) {
				console.log(data);
			});
			
		}).error(function(data) {
			console.log(data);
		});
    });

    $('#cboPlan').change(function() {
    	limpiar_tabla();

        if ($('#cboPlan').val() == 0) return;
		$('#cboMaterias').children().remove().end();

        var plan_id = $('#cboPlan').val();
    	var carrera_id = $('#cboCarrera').val();

		$.ajax({
		  url: "{{url('asistencias/obtenermaterias')}}",
		  data:{'plan_id': plan_id, 'carrera_id': carrera_id},
		  type: 'POST'
		}).done(function(materias) {
			console.log(materias);

			$("#table_asistencias").find("tr:gt(0)").remove();

			$('#cboMaterias').append(
		        $('<option></option>').val(0).html('Seleccionar')
		    );

			$.each(materias, function(key, value) {
				$('#cboMaterias').append(
			        $('<option></option>').val(value.id).html(value.nombremateria)
			    );
			});
			
		}).error(function(data) {
			console.log(data);
		});
    });

    $('#cboCarrera').change(function() {
    	limpiar_tabla();

        if ($('#cboCarrera').val() == 0) return;
		$('#cboPlan').children().remove().end();

        var carrera_id = $('#cboCarrera').val();

		$.ajax({
		  url: "{{url('asistencias/obtenerplanes')}}",
		  data:{'carrera_id': carrera_id},
		  type: 'POST'
		}).done(function(planes) {
			console.log(planes);

			$("#table_asistencias").find("tr:gt(0)").remove();

			$('#cboPlan').append(
		        $('<option></option>').val(0).html('Seleccionar')
		    );

			$.each(planes, function(key, value) {
				$('#cboPlan').append(
			        $('<option></option>').val(value.id).html(value.codigoplan)
			    );
			});

		}).error(function(data) {
			console.log(data);
		});
    });

    $('#cboOrganizacion').change(function() {
    	// 1 - limpiar todo

    	limpiar_tabla();
		$('#cboCarrera').children().remove().end();

		if ($('#cboOrganizacion').val() == 0) return;
		
		$.ajax({
		  url: "{{url('organizacions/obtenercarreras')}}",
		  data:{'organizacion_id': $('#cboOrganizacion').val()},
		  type: 'POST'
		}).done(function(carreras) {
			console.log(carreras);
			if (carreras == <?php echo OrganizacionsController::NO_TIENE_CARRERAS ?>) {
				$('#modalMensajes').modal('show');
				return;
		    }

			$("#table_asistencias").find("tr:gt(0)").remove();

			$('#cboCarrera').append(
		        $('<option></option>').val(0).html('Seleccionar')
		    );

			$.each(carreras, function(key, value) {
				$('#cboCarrera').append(
			        $('<option></option>').val(value.id).html(value.carrera)
			    );
			});
		}).error(function(data){
			console.log(data);
		});
    });

    function limpiar_tabla() {
		$('#horaentradal').val('');
		$('#minutoentradal').val('');
		$('#horasalidal').val('');
		$('#minutosalidal').val('');

        $("#horaentradal").attr('disabled', 'disabled');
        $("#minutoentradal").attr('disabled', 'disabled');
        $("#horasalidal").attr('disabled', 'disabled');
        $("#minutosalidal").attr('disabled', 'disabled');

		$('#horaentradama').val('');
		$('#minutoentradama').val('');
		$('#horasalidama').val('');
		$('#minutosalidama').val('');

        $("#horaentradama").attr('disabled', 'disabled');
        $("#minutoentradama").attr('disabled', 'disabled');
        $("#horasalidama").attr('disabled', 'disabled');
        $("#minutosalidama").attr('disabled', 'disabled');
	    
		$('#horaentradami').val('');
		$('#minutoentradami').val('');
		$('#horasalidami').val('');
		$('#minutosalidami').val('');

        $("#horaentradami").attr('disabled', 'disabled');
        $("#minutoentradami").attr('disabled', 'disabled');
        $("#horasalidami").attr('disabled', 'disabled');
        $("#minutosalidami").attr('disabled', 'disabled');
	    
		$('#horaentradaj').val('');
		$('#minutoentradaj').val('');
		$('#horasalidaj').val('');
		$('#minutosalidaj').val('');

        $("#horaentradaj").attr('disabled', 'disabled');
        $("#minutoentradaj").attr('disabled', 'disabled');
        $("#horasalidaj").attr('disabled', 'disabled');
        $("#minutosalidaj").attr('disabled', 'disabled');
	    
		$('#horaentradav').val('');
		$('#minutoentradav').val('');
		$('#horasalidav').val('');
		$('#minutosalidav').val('');

        $("#horaentradav").attr('disabled', 'disabled');
        $("#minutoentradav").attr('disabled', 'disabled');
        $("#horasalidav").attr('disabled', 'disabled');
        $("#minutosalidav").attr('disabled', 'disabled');
	    
		$('#horaentradas').val('');
		$('#minutoentradas').val('');
		$('#horasalidas').val('');
		$('#minutosalidas').val('');

        $("#horaentradas").attr('disabled', 'disabled');
        $("#minutoentradas").attr('disabled', 'disabled');
        $("#horasalidas").attr('disabled', 'disabled');
        $("#minutosalidas").attr('disabled', 'disabled');
	    
	    var n = 0;
		$('#table_asistencias tr').each(function() {
		   if (n > 1) $(this).remove();
		   n++;
		});
    }

    //AL PRESIONAR LOS BOTONES ELIMINAR PASO EL DATA ID DE LA CARRERA A ELIMINAR
	$('.btnEliminarMaterias').live('click', function(){
		//PASO EL DATA ID AL CAMPO OCULTO		
		$('#idPlanHidden').val($(this).data('id'));
		//MUESTRO EL MODAL DE ADVERTENCIA
		$('#modalEliminaCorrelatividad').modal('show');
	});


	$(document).ready(function(){
 
		$('.ir-arriba').click(function(){
			$('body, html').animate({
				scrollTop: '0px'
			}, 300);
		});
	 
		$(window).scroll(function(){
			if( $(this).scrollTop() > 0 ){
				$('.ir-arriba').slideDown(300);
			} else {
				$('.ir-arriba').slideUp(300);
			}
		});
	 
	});

	$('div.alert').not('.alert-important').delay(3000).fadeOut(350) 

@stop


@section('includejs')
	<script type="text/javascript" src="{{url('assets/global/plugins/select2/select2.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js')}}"></script>
	<script src="{{url('assets/admin/pages/scripts/getFechaImpresion.js')}}"></script>
	<script src="{{url('assets/admin/pages/scripts/primerFechaMayor.js')}}"></script>
	<script src="{{url('assets/admin/pages/scripts/table-advanced.js')}}"></script>
<script src="{{url('assets/admin/layout/scripts/menusticky.js')}}" type="text/javascript"></script>
@stop
