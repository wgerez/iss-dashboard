@extends('layouts.master')

@section('customstyle')
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/select2/select2.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/bootstrap-datepicker/css/datepicker.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/bootstrap-datetimepicker/css/datetimepicker.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/fancybox/source/jquery.fancybox.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}"/>
<style>
.fixed {
    position:fixed;
    top: 60px;
    right: 20px;
    z-index: 999
}
</style>
<!-- END PAGE LEVEL STYLES -->
@stop

<?php

$nombre = (trim(Input::old('nombre') == false)) ? $alumno->persona->nombre : Input::old('nombre');
$apellido = (trim(Input::old('apellido') == false)) ? $alumno->persona->apellido : Input::old('apellido');
$documento = (trim(Input::old('documento') == false)) ? $alumno->persona->nrodocumento : Input::old('documento');
$cuil = (trim(Input::old('cuil') == false)) ? $alumno->persona->cuil : Input::old('cuil');
$calle = (trim(Input::old('calle') == false)) ? $alumno->persona->calle : Input::old('calle');
$departamento = (trim(Input::old('domiciliodepartamento') == false)) ? $alumno->persona->departamento : Input::old('domiciliodepartamento');
$piso = (trim(Input::old('piso') == false)) ? $alumno->persona->piso : Input::old('piso');

//BOTONES Y CAMPOS DE PERMISOS
$disabled = (!$editar) ? 'disabled' : '';
$readonly = (!$editar) ? 'readonly' : '';
$imprimir = (!$imprimir) ? 'disabled' : '';


if (trim(Input::old('fechanacimiento') == false)) {
	$fechanacimiento = FechaHelper::getFechaImpresion($alumno->persona->fechanacimiento);
} else {
    $fechanacimiento = Input::old('fechanacimiento');
}

if (trim(Input::old('fechaingreso') == false)) {
	$fechaingreso = FechaHelper::getFechaImpresion($alumno->fechaingreso);
} else {
	$fechaingreso = Input::old('fechaingreso');
}

if (trim(Input::old('fechaegreso') == false)) {
	$fechaegreso = FechaHelper::getFechaImpresion($alumno->fechaegreso);
} else {
	$fechaegreso = Input::old('fechaegreso');
}

if (trim(Input::old('numerocalle') == false)) {
	$numero = ($alumno->persona->numero != 0) ? $alumno->persona->numero : '';
} else {
	$numero = Input::old('numerocalle');
}

if (trim(Input::old('manzana') == false)) {
	$manzana = ($alumno->persona->manzana != NULL) ? $alumno->persona->manzana : '';
} else {
	$manzana = Input::old('manzana');
}

if (trim(Input::old('codigopostal') == false)) {
	$codigoPostal = ($alumno->persona->codigo_postal != 0) ? $alumno->persona->codigo_postal : '';
} else {
	$codigoPostal = Input::old('codigopostal');
}

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
					Alumnos <small>editar alumno</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('alumnos/listado')}}">Alumnos</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">Editar</a>
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
					    @if (Session::get('message_type') == AlumnosController::OPERACION_EXITOSA)

							<div class="note note-success">
								<p> {{ Session::get('message') }} </p>
							</div>

						@elseif (Session::get('message_type') == AlumnosController::OPERACION_FALLIDA)

							<div class="note note-danger">
								<p> {{ Session::get('message') }} </p>
							</div>

						@endif	
					@endif
					<!-- COMIENZO DE LA TABLA-->
					{{ Form::open(array('url'=>'alumnos/update', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FormAlumnos', 'enctype'=>'multipart/form-data'))}}

					<input type='hidden' name='txtAlumnoId' value='{{$alumno->id}}'>

					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-users"></i> Editar Alumno
							</div>
							<div class="actions">
								<button {{$disabled}} type='submit' class="btn default green-stripe">
								<i class="fa fa-save"></i>
								<span class="hidden-480">
								Guardar </span>
								</button>
								<a href="{{url('alumnos/listado')}}" class="btn default yellow-stripe">
								<i class="fa fa-reorder"></i>
								<span class="hidden-480">
								Listado </span>
								</a>
								<a href="{{url('alumnos/listado')}}" class="btn default red-stripe">
								<i class="fa fa-times"></i>
								<span class="hidden-480">
								Cancelar </span>
								</a>
							</div>

						</div>
						<div class="portlet-body">
								<div class="tabbable-custom">

									<ul class="nav nav-tabs">
										<li class="active">
											<a href="{{url('alumnos/editar')}}/{{$alumno->id}}">
											Datos Personales </a>
										</li>
										<li>
											<a href="{{url('inscripciones/inscribiralumno')}}/{{$alumno->id}}" >
											Inscripciones </a>
										</li>
										<li>
											<a href="{{url('alumnos/legajo')}}/{{$alumno->id}}" >
											Legajo </a>
										</li>
										<!--li>
											<a href="{{url('alumnos/familia')}}/{{$alumno->id}}">
											Familia </a>
										</li-->
									</ul>
									<div class="tab-content no-space">
										<div class="tab-pane active" id="tab_datos_personales">
											<div class="form-body">
												<!-- la clase has-error muestra cuando exista errores en la carga -->
											<div class="row">
											<div class="col-md-8">
											    <div class="form-group <?php if ($errors->has('apellido')) echo 'has-error' ?>">

													<label class="col-md-3 control-label">Apellido: <span class="required">
													* </span>
													</label>
													<div class="col-md-9">
														<input {{$readonly}} type="text" class="form-control" name="apellido" placeholder="" value="{{ $apellido }}">

														<!-- mostrar cuando exista error -->
													    @if ($errors->has('apellido'))
														    <span class="help-block">{{ $errors->first('apellido') }}</span>
													    @endif
													    <!--fin error-->

													</div>
												</div>
												<div class="form-group <?php if ($errors->has('nombre')) echo 'has-error' ?>">
													<label class="col-md-3 control-label">Nombre/s: <span class="required">
													* </span>
													</label>
													<div class="col-md-9">
														<input {{$readonly}} type="text" class="form-control" name="nombre" placeholder="" value="{{ $nombre }}">

														<!-- mostrar cuando exista error -->
													    @if ($errors->has('nombre'))
														    <span class="help-block">{{ $errors->first('nombre') }}</span>
													    @endif
													    <!--fin error-->

													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Tipo de Doc.: <span class="required">
													* </span>
													</label>
													<div class="col-md-9">
														{{ Form::select('tipodocumento', $arrTipoDocumento, $alumno->persona->tipodocumento_id, array('class'=>'table-group-action-input form-control input-medium', $disabled)); }}
													</div>
												</div>
												<div class="form-group <?php if ($errors->has('documento')) echo 'has-error' ?>">
													<label class="col-md-3 control-label">Documento: <span class="required">
													* </span>
													</label>
													<div class="col-md-3">
														<input {{$readonly}} type="text" class="form-control" name="documento" id="documento" placeholder="" value="{{ $documento }}">

														<!-- mostrar cuando exista error -->
													    @if ($errors->has('documento'))
														    <span class="help-block">{{ $errors->first('documento') }}</span>
													    @endif
													    <!--fin error-->

													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">CUIL: 
													</label>
													<div class="col-md-3">
														<input {{$readonly}} type="text" class="form-control" name="cuil" id="cuil" placeholder="" value="{{$cuil}}">
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="row" style="padding: 10px 0">
													<center>
													<div class="fileinput fileinput-new" data-provides="fileinput">
														<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 130px; height: 110px;">
															@if ($alumno->Persona->foto)
															    <img id="img" src="{{$alumno->Persona->foto2}}" alt="sin perfil">
															@else
															    <img src="{{url('assets/admin/layout/img/sinperfil.png')}}" alt="sin perfil">
															@endif
														</div>
														<div>
															<span class="btn btn-sm default btn-file">
																<span class="fileinput-new"><i class="fa fa-search"></i> Buscar Foto </span>
																<span class="fileinput-exists"><i class="fa fa-edit"></i> Cambiar </span>
																<input {{$disabled}} type="file" name="fotoperfil">
															</span>
															<a href="#" class="btn btn-sm red fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash-o"></i> Eliminar </a>
														</div>
													</div>	
													</center>				
												</div>
												<div class="row">
													<center>
														<label>
															<div class="checker {{$disabled}}">
																<span class="<?php if ($alumno->activo) echo 'checked'; ?>">
																	<input id="alumnoactivo" name="alumnoactivo" type="checkbox" <?php if ($alumno->activo) echo 'CHECKED'; ?> >
																</span>
															</div> 
															Activo 
														</label>													
													</center>
												</div>
												<div class="form-group" style="border-bottom: 0">
													<center>
														<button {{$imprimir}} type="button" class="btn btn-sm grey-cascade"><i class="fa fa-print"></i> Credencial</button>
													</center>	
												</div>							
											</div>											
											</div> <!-- row -->												
												<div class="form-group">
													<label class="col-md-2 control-label">Sexo: <span class="required">
													* </span>
													</label>
													<div class="col-md-6">
														<select {{$disabled}} name="sexo" id="sexo" class="table-group-action-input form-control input-medium">
															<option value="Masculino" <?php if ($alumno->persona->sexo == 'Masculino') echo 'SELECTED' ?>>
																Masculino
															</option>
															<option value="Femenino" <?php if ($alumno->persona->sexo == 'Femenino') echo 'SELECTED' ?>>Femenino</option>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-2 control-label">Estado Civil:	</label>
													<div class="col-md-6">
														{{ Form::select('estadocivil', $arrEstadoCivil, $alumno->persona->estadocivil_id, array('class'=>'table-group-action-input form-control input-medium', $disabled)); }}
													</div>
												</div>
												<div id="divavisofechanac" class="form-group <?php if ($errors->has('fechanacimiento')) echo 'has-error' ?>">
													<label class="col-md-2 control-label">Fecha Nacimiento: <span class="required">
													* </span>
													</label>
													<div class="col-md-2">
														<div class="input-icon right">
															<i class="fa fa-exclamation tooltips iconoerror" style="display:none" data-original-title="Error en formato de fecha." data-container="body"></i>
															<input {{$readonly}} type="text" class="form-control" name="fechanacimiento" id="fechanacimiento" placeholder="" value="{{ $fechanacimiento }}">

															<!-- mostrar cuando exista error -->
													    	@if ($errors->has('fechanacimiento'))
														    	<span class="help-block">{{ $errors->first('fechanacimiento') }}</span>
													    	@endif
													    	<!--fin error-->
													    </div>	

													</div>
												</div>
												<div class="form-group">
													<label class="col-md-2 control-label">Edad:</label>
													<div class="col-md-1">
														<input type="text" class="form-control" readonly name="edad" id="edad" value="@if (Input::old('edad')) {{Input::old('edad')}} @else {{ Util::Calcularedad($fechanacimiento)}} @endif ">
													</div>
												</div>												

												<div class="form-group">
													<label  class="col-md-2 control-label <?php if ($errors->has('fechaingreso')) echo 'text-danger' ?>">Fecha Ingreso:<span class="required">
													* </span></label>
													<div id="divavisofechaing" class="col-md-2 <?php if ($errors->has('fechaingreso')) echo 'has-error' ?>">
														<div class="input-icon right">
															<i class="fa fa-exclamation tooltips iconoerrorfechaing" style="display:none" data-original-title="Error en formato de fecha." data-container="body"></i>
															<input {{$readonly}} type="text" class="form-control" name="fechaingreso" id="fechaingreso" placeholder="" value="{{ $fechaingreso }}">

															<!-- mostrar cuando exista error -->
													    	@if ($errors->has('fechaingreso'))
														    	<span class="help-block">{{ $errors->first('fechaingreso') }}</span>
													    	@endif
													    	<!--fin error-->
													    </div>	

													</div>
													<label class="col-md-2 control-label">Fecha Egreso:</label>
													<div class="col-md-2">
														<input {{$readonly}} type="text" class="form-control" name="fechaegreso" id="fechaegreso" placeholder="" value="{{ $fechaegreso }}">
													</div>													
												</div>
												<!--<div class="form-group">
													<label class="col-md-2 control-label">Edad:</label>
													<div class="col-md-2">
														<input type="text" class="form-control" name="edad" placeholder="" value="{{ Input::old('edad') }}">

													</div>
												</div>-->
												<div class="form-group">
													<label class="col-md-2 control-label">Lugar Nac.:</label>
													<div class="col-md-6">
														{{ Form::select('paisnacimiento', $arrPais, $alumno->persona->lugarnacimiento_id, array('class'=>'table-group-action-input form-control input-medium', $disabled)); }}
													</div>
												</div>																								
												<br>
													<div class="portlet">
														<div class="portlet-title">
															<div class="caption">
																<i class="fa fa-language"></i>Domicilio
															</div>
														</div>
														<div class="portlet-body">
															<div class="form-group">
																<label class="col-md-2 control-label">Pa&iacute;s:</label>
																<!--<div class="col-md-1">
																	<input type="text" class="form-control" name="codigopais" >
																</div>-->
																<div class="col-md-6">
																	{{ Form::select('pais', $arrPais, $alumno->persona->pais_id, array('class'=>'table-group-action-input form-control input-medium', 'id'=>'pais', $disabled)); }}
																</div>
															</div>

															<div class="form-group">
																<label class="col-md-2 control-label">Provincia:</label>
																<!--<div class="col-md-1">
																	<input type="text" class="form-control" name="codigoprovincia">
																</div>-->
																<div class="col-md-6">
																	{{ Form::select('provincia', $arrProvincia, $alumno->persona->provincia_id, array('class'=>'table-group-action-input form-control input-medium', 'id'=>'provincia', $disabled)); }}
																</div>
															</div>

															<div class="form-group">
																<label class="col-md-2 control-label">Departamento:	</label>
																<!--<div class="col-md-1">
																	<input type="text" class="form-control" name="codigodepartamento">
																</div>-->
																<div class="col-md-6">
																	{{ Form::select('departamento', $arrDepartamento, $alumno->persona->departamento_id, array('class'=>'table-group-action-input form-control input-medium', 'id'=>'departamento', $disabled)); }}
																</div>
															</div>


															<div class="form-group">
																<label class="col-md-2 control-label">Localidad:</label>
																<!--<div class="col-md-1">
																	<input type="text" class="form-control" name="codigolocalidad">
																</div>-->
																<div class="col-md-6">
																	{{ Form::select('localidad', $arrLocalidad, $alumno->persona->localidad_id, array('class'=>'table-group-action-input form-control input-medium', 'id'=>'localidad', $disabled)); }}
																</div>
															</div>


															<div class="form-group">
																<label class="col-md-2 control-label">Barrio:</label>
																<div class="col-md-6">
																	<input type="text" class="form-control" name="txt_barrio" Input::old('txt_barrio') value='{{$alumno->persona->barrio}}'>
																</div>
																<!--<div class="col-md-6">
																	{{ Form::select('barrio', $arrBarrio, $alumno->persona->barrio_id, array('class'=>'table-group-action-input form-control input-medium', 'id'=>'barrio', $disabled)); }}
																</div>-->
															</div>															


															<div class="form-group">
																<label class="col-md-2 control-label">Calle:
																</label>
																<div class="col-md-6">
																	<input {{$readonly}} type="text" class="form-control" name="calle" placeholder="" value="{{ $calle }}">
																</div>
															</div>

															<div class="form-group">
																<label class="col-md-2 control-label">Número:
																</label>
																<div class="col-md-1">
																	<input {{$readonly}} type="text" class="form-control" name="numerocalle" placeholder="" value="{{ $numero }}">
																</div>

																<label class="col-md-2 control-label">Mz.:
																</label>
																<div class="col-md-1">
																	<input {{$readonly}} type="text" class="form-control" name="manzana" placeholder="" value="{{ $manzana }}">
																</div>																
															</div>		

															<div class="form-group">
																<label class="col-md-2 control-label">Departamento:
																</label>
																<div class="col-md-1">
																	<input {{$readonly}} type="text" class="form-control" name="domiciliodepartamento" placeholder="" value="{{ $departamento }}">
																</div>

																<label class="col-md-2 control-label">Piso.:
																</label>
																<div class="col-md-1">
																	<input {{$readonly}} type="text" class="form-control" name="piso" placeholder="" value="{{ $piso }}">
																</div>																
															</div>		

															<div class="form-group <?php if ($errors->has('codigoPostal')) echo 'has-error' ?>">
																<label class="col-md-2 control-label">Código Postal:
																</label>
																<div class="col-md-2">
																	<input {{$readonly}} type="text" class="form-control" name="codigopostal" placeholder="" value="{{ $codigoPostal }}">

																	<!-- mostrar cuando exista error -->
																    @if ($errors->has('codigoPostal'))
																	    <span class="help-block">{{ $errors->first('codigoPostal') }}</span>
																    @endif
																    <!--fin error-->

																</div>
															</div>																														

														</div>
													</div>

													<br>
													<div class="portlet">
														<div class="portlet-title">
															<div class="caption">
																<i class="fa fa-envelope-square"></i>Contactos
															</div>
														</div>
														<div class="portlet-body">

															<div class="form-group">
																<label class="col-md-2 control-label">Tipo de Contacto:
																</label>

																<div class="col-md-3">
																	{{ Form::select('cboContacto', $arrTipoContacto, Input::old('cboContacto'), array('class'=>'table-group-action-input form-control', 'id'=>'cboContacto', $disabled)); }}
																</div>

																<div class="errorContactoDescripcion">
																	<label class="col-md-2 control-label">Descripci&oacute;n:
																	</label>
																	<div class="col-md-3">
																		<input {{$readonly}} type="text" class="form-control" name="contactodescripcion" id="contactodescripcion" placeholder="">
																		<span id="errorContactoDescripcion" class="help-block"></span>
																	</div>
																</div>
																<div class="col-md-2">
																	<a {{$disabled}} href="#" id="btnAgregaContacto" class="btn default"><i class="fa fa-plus"></i> Agregar</a>
																</div>
															</div>
															<div class="form-group">
																<label class="col-md-2 control-label">&nbsp;
																</label>
																<div class="col-md-10">
																	<table id="tablecontactos" class="table table-hover">
																	<thead>
																	<tr>
																		<th>
																			 &nbsp;
																		</th>
																		<th>
																			 Tipo
																		</th>
																		<th>
																			 Descripción
																		</th>
																		<th>
																			 <center>Acción</center>
																		</th>
																	</tr>
																	</thead>
                                                                    <tbody>
																		
																		@foreach ($arrContactos as $tipo=>$contacto)
																			<?php $aleatorio = mt_rand(6001, 15000); ?>
																			<tr>
																				<td>
																					<span id="icono_<?php echo $aleatorio; ?>">
																						 @if ($contacto->contacto_id==1 || $contacto->contacto_id==2)
																						 	{{'<i class="fa fa-phone-square"></i>'}}
																						 @elseif ($contacto->contacto_id==3)
																						 	{{'<i class="fa fa-envelope"></i>'}}
																						 @else
																							{{'<i class="fa fa-globe"></i>'}}	
																						 @endif
																					 </span> 	
																				</td>
																				<td>
																					<span id="tipo_<?php echo $aleatorio; ?>">
																					 	{{$tipo}}
																					 </span>
																				</td>
																				<td>
																					<span id="des_<?php echo $aleatorio; ?>">
																						{{$contacto->descripcion}}
																					</span>	
																				</td>
																				<td>
																					<input type="hidden" name="contactos[]" id="<?php echo $aleatorio; ?>" value="{{$contacto->contacto_id}}|{{$contacto->descripcion}}">
																					 <center><a {{$disabled}} title="Modificar" id="btnModi_<?php echo $aleatorio; ?>" rel="<?php echo $aleatorio; ?>" href="#" data-id="{{$contacto->contacto_id}}" data-body="{{$contacto->descripcion}}" class="btn default btn-sm purple modificarContacto"><i class="fa fa-edit"></i></a><a {{$disabled}} title="Eliminar" href="#" rel="<?php echo $aleatorio; ?>" class="btn default btn-sm red borrarContacto"><i class="fa fa-trash-o"></i></a></center>
																				</td>
																			</tr>
																		@endforeach
																	</tbody>
																	</table>
																</div>
															</div>
														</div>
													</div>
											</div>	
										</div>
										<div class="tab-pane" id="tab_familia">

										</div>
										<div class="tab-pane" id="tab_legajos">

										</div>
									</div>
								</div>
						</div>
					</div>
					{{ Form::close()}}
					<!-- FIN DE LA TABLA-->
				</div>
			</div>
			<!-- FIN DEL CONTENIDO -->
		</div>
	</div>
	<!-- FIN -->

	<!-- MODAL DESACTIVAR ACTIVO-->
	<div class="modal fade" id="modalDesactivarAlumno" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Desactivar Alumno</h4>
					</div>
					<div class="modal-body">
					<p>¿Estas seguro de cambiar el estado del Alumno?</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn red" id="btnDesactivarAlumno"><i class="fa fa-check"></i> Desactivar</button>
						<button type="button" class="btn default" id="btnCancelarAlumno"><i class="fa fa-times-circle-o"></i> Cancelar</button>
					</div>
				</div>
				<!-- /.modal-contenido -->
			</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
	<!-- FIN DEL MODAL FORM-->	


<!-- MODAL MODIFICACION DE CONTACTOS-->
	<div class="modal fade" id="modalModiContactos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Modificar Contactos</h4>
					</div>
					<div class="modal-body">
						<form class="form-horizontal">
							<input type="hidden" id="txtIdHiddenContacto" value="">
							<div class="form-group">
								<label class="col-md-3 control-label">Tipo de Contacto</label>
								<div class="col-md-6">
									{{ Form::select('cboTipoContacto', $arrTipoContacto, 'null', array('class'=>'table-group-action-input form-control input-medium', 'id'=>'cboTipoContacto')); }}
								</div>
							</div>

							<div class="form-group errorContactoDescripcionModal">
								<label class="col-md-3 control-label">Descripción</label>
								<div class="col-md-6">
									<input type="text" id="txtDescipContacto" name="txtDescipContacto" class="form-control">
									<span id="errorContactoDescripcionModal" class="help-block"></span>
								</div>
							</div>


						</form>

					</div>
					<div class="modal-footer">
						<button type="button" id="btnModalModificaContactos" class="btn purple"><i class="fa fa-edit"></i> Modificar</button>
						<button type="button" class="btn default" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> Cancelar</button>
					</div>
				</div>
				<!-- /.modal-contenido -->
			</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
	<!-- FIN DEL MODAL FORM-->			
@stop


@section('customjs')
ComponentsFormTools.init();
refreshImg($('#img'));

//Emular Tab al presionar Enter
$('input').keydown( function(e) {
        var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
        if(key == 13) {
            e.preventDefault();
            var inputs = $(this).closest('form').find(':input:visible');
            inputs.eq( inputs.index(this)+ 1 ).focus();
        }
 });

$('#btnAgregaContacto').on('click', function(e) {
	e.preventDefault();
	if ($('#contactodescripcion').val().length < 1) return false;

	//valido el formato email y sitio Web
	if ($("#cboContacto :selected").text()=='Correo'){
		if($("#contactodescripcion").val().indexOf('@', 0) == -1 || $("#contactodescripcion").val().indexOf('.', 0) == -1) {
			$('.errorContactoDescripcion').addClass('has-error');
			$('#errorContactoDescripcion').text('El correo es incorrecto.').show();
			return false;
		}
	}else if ($("#cboContacto :selected").text()=='Sitio Web'){
		if($("#contactodescripcion").val().indexOf('.', 0) == -1) {
			$('.errorContactoDescripcion').addClass('has-error');
			$('#errorContactoDescripcion').text('El sitio es incorrecto.').show();
			return false;
		}
	}
	$('.errorContactoDescripcion').removeClass('has-error');		
	$('#errorContactoDescripcion').hide();
	//

	var iconcontacto = $("#cboContacto :selected").text();
	if (iconcontacto=='Particular' || iconcontacto=='Laboral'){
		var ico = '<i class="fa fa-phone-square"></i>';
	}else if (iconcontacto=='Correo'){
		var ico = '<i class="fa fa-envelope"></i>';
	}else{
		var ico = '<i class="fa fa-globe"></i>';
	}
	var idaleatorio = $('#cboContacto').val() + aleatorio(100,2000);
	$('#tablecontactos > tbody').append('<tr><td><span id="icono_'+idaleatorio+'">'+ico+'</span></td><td><span id="tipo_'+idaleatorio+'">'+$("#cboContacto :selected").text()+'</span></td><td><span id="des_'+idaleatorio+'">'+$('#contactodescripcion').val()+'</span></td><td><center>    <a title="Modificar" id="btnModi_'+idaleatorio+'" rel="'+idaleatorio+'" href="#" data-id="'+$('#cboContacto').val()+'" data-body="'+$('#contactodescripcion').val()+'" class="btn default btn-sm purple modificarContacto"><i class="fa fa-edit"></i></a><a rel="'+idaleatorio+'" title="Eliminar" href="#" class="btn default btn-sm red borrarContacto"><i class="fa fa-trash-o"></i></a></center></td></tr>');
	$('#FormAlumnos').append('<input id="'+ idaleatorio +'" name="contactos[]" type="hidden" value="'+ $('#cboContacto').val() +'|'+ $('#contactodescripcion').val() +'">');
	$('#contactodescripcion').val('');
	$('#contactodescripcion').focus();
});

$(".borrarContacto" ).live('click', function(e){

	e.preventDefault();

	var idinputHidden = $(this).attr('rel');

	console.log(idinputHidden);
	$('#'+idinputHidden).remove();

    $(this).closest("tr").remove();
});

function aleatorio(a,b) {
    return '_'+Math.round(Math.random()*(b-a)+parseInt(a));
}

$('.modificarContacto').live('click', function(e){
	e.preventDefault();
	$('#txtIdHiddenContacto').val($(this).attr('rel'));
	$("#cboTipoContacto option[value="+ $(this).data('id') +"]").attr("selected",true);
	$('#txtDescipContacto').val($(this).data('body'));
	$('#modalModiContactos').modal('show');
});

$('#btnModalModificaContactos').live('click', function(){

	//valido el formato email y sitio Web Modal
	if ($("#cboTipoContacto").val()==3){
		if($("#txtDescipContacto").val().indexOf('@', 0) == -1 || $("#txtDescipContacto").val().indexOf('.', 0) == -1) {
			$('.errorContactoDescripcionModal').addClass('has-error');
			$('#errorContactoDescripcionModal').text('El correo es incorrecto.').show();
			return false;
		}
	}else if ($("#cboTipoContacto").val()==4){
		if($("#txtDescipContacto").val().indexOf('.', 0) == -1) {
			$('.errorContactoDescripcionModal').addClass('has-error');
			$('#errorContactoDescripcionModal').text('El sitio es incorrecto.').show();
			return false;
		}
	}
	$('.errorContactoDescripcionModal').removeClass('has-error');		
	$('#errorContactoDescripcionModal').hide();
	//


	var iconcontacto = $("#cboTipoContacto").val(); 
	if (iconcontacto=='1' || iconcontacto=='2'){
		var ico = '<i class="fa fa-phone-square"></i>';
	}else if (iconcontacto=='3'){
		var ico = '<i class="fa fa-envelope"></i>';
	}else{
		var ico = '<i class="fa fa-globe"></i>';
	}

	var idcont = $('#txtIdHiddenContacto').val();
	$('#'+idcont).val($("#cboTipoContacto").val()+ '|' +$("#txtDescipContacto").val() );
	$('#tipo_'+idcont).text($('#cboTipoContacto option:selected').text());
	$('#des_'+idcont).text($('#txtDescipContacto').val());
	$('#icono_'+idcont).html(ico);
	$('#btnModi_'+idcont).data('id', $("#cboTipoContacto").val());
	$('#btnModi_'+idcont).data('body', $("#txtDescipContacto").val());
	$('#modalModiContactos').modal('hide');
});


$('#pais, #provincia, #departamento, #localidad, #barrio, #cboContacto').select2({
	placeholder: "Seleccione",
	allowClear: true
});



<?php if ($editar) : ?>
	$('#alumnoactivo').change(function(){
	    var checkeado = $(this).attr("checked");
	    if(!checkeado) {
	    	$(this).prop("checked",true);
	    	$(this).parent().addClass("checked");
	        $('#modalDesactivarAlumno').modal('show');
	    }
	    else
	    {
	    	$(this).parent().addClass("checked");
	    }
	});

<?php endif ?>

$('#btnDesactivarAlumno').on('click', function(e){
	e.preventDefault();
	$("#alumnoactivo").prop("checked", false );
	$("#alumnoactivo").parent().removeClass("checked");
	$('#modalDesactivarAlumno').modal('hide');
});

$('#btnCancelarAlumno').on('click', function(e){
	e.preventDefault();
	$("#alumnoactivo").prop("checked", true );
	$("#alumnoactivo").parent().addClass("checked");	
	$('#modalDesactivarAlumno').modal('hide');
})


$('#fechanacimiento').on('keyup', function(){
	$('#edad').val(calcular_edad( $(this).val()));
})

	//Comprobacion de fecha de nacimiento
	$('#fechanacimiento').on('focusout', function(){
		var fecha = $('#fechanacimiento');
		var divaviso = $('#divavisofechanac');
		var iconoerror = $('.iconoerror');
		if (!validaFechaDDMMAAAA(fecha.val()) || validarFechaMayorActual(fecha.val()) ){
			divaviso.addClass('has-error');
			iconoerror.show();
			$('button[type="submit"]').attr('disabled','disabled');	
		}
		else
		{
			divaviso.removeClass('has-error');
			iconoerror.hide();
			$('button[type="submit"]').removeAttr('disabled');
		}
	});	

	//Comprobacion de fecha de nacimiento
	$('#fechaingreso').on('focusout', function(){
		var fecha = $('#fechaingreso');
		var divaviso = $('#divavisofechaing');
		var iconoerror = $('.iconoerrorfechaing');
		if (!validaFechaDDMMAAAA(fecha.val()) || validarFechaMayorActual(fecha.val())){
			divaviso.addClass('has-error');
			iconoerror.show();
			$('button[type="submit"]').attr('disabled','disabled');	
		}
		else
		{
			divaviso.removeClass('has-error');
			iconoerror.hide();
			$('button[type="submit"]').removeAttr('disabled');
		}
	});
	$('#departamento').combodinamico("{{url('alumnos/localidades/')}}", $('#localidad'));
@stop


@section('includejs') 
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{url('assets/global/plugins/select2/select2.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/global/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js')}}"></script>
<script type="text/javascript" src="{{url('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
<script type="text/javascript" src="{{url('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{url('assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js')}}" type="text/javascript"></script>
<script src="{{url('assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{url('assets/global/plugins/fancybox/source/jquery.fancybox.pack.js')}}"></script>
<script src="{{url('assets/global/plugins/plupload/js/plupload.full.min.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{url('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}"></script>

<script src="{{url('assets/admin/layout/scripts/menusticky.js')}}" type="text/javascript"></script>
<script src="{{url('assets/admin/pages/scripts/components-form-tools.js')}}"></script>
<script src="{{url('assets/admin/pages/scripts/helpers/calculo.edad.js')}}" type="text/javascript"></script>
<script src="{{url('assets/admin/pages/scripts/helpers/verificar.fecha.js')}}" type="text/javascript"></script>
<script src="{{url('assets/admin/pages/scripts/helpers/jquery.combodinamico.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
@stop
