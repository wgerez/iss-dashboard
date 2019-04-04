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
//BOTONES Y CAMPOS DE PERMISOS
$disabled = (!$editar) ? 'disabled' : '';
$readonly = (!$editar) ? 'readonly' : '';
$imprimir = (!$imprimir) ? 'disabled' : '';

$nombre = (trim(Input::old('nombre') == false)) ? $docente->persona->nombre : Input::old('nombre');
$apellido = (trim(Input::old('apellido') == false)) ? $docente->persona->apellido : Input::old('apellido');
$documento = (trim(Input::old('documento') == false)) ? $docente->persona->nrodocumento : Input::old('documento');
$cuil = (trim(Input::old('cuil') == false)) ? $docente->persona->cuil : Input::old('cuil');
$calle = (trim(Input::old('calle') == false)) ? $docente->persona->calle : Input::old('calle');
$departamento = (trim(Input::old('domiciliodepartamento') == false)) ? $docente->persona->departamento : Input::old('domiciliodepartamento');
$piso = (trim(Input::old('piso') == false)) ? $docente->persona->piso : Input::old('piso');
$sexo = (trim(Input::old('sexo') == false)) ? $docente->persona->sexo : Input::old('sexo');


if (trim(Input::old('fechanacimiento') == false)) {
	$fechanacimiento = FechaHelper::getFechaImpresion($docente->persona->fechanacimiento);
} else {
    $fechanacimiento = Input::old('fechanacimiento');
}

if (trim(Input::old('fechaingreso') == false)) {
	$fechaingreso = FechaHelper::getFechaImpresion($docente->fechaingreso);
} else {
	$fechaingreso = Input::old('fechaingreso');
}

if (trim(Input::old('fechaegreso') == false)) {
	$fechaegreso = FechaHelper::getFechaImpresion($docente->fechaegreso);
} else {
	$fechaegreso = Input::old('fechaegreso');
}

if (trim(Input::old('numerocalle') == false)) {
	$numero = ($docente->persona->numero != 0) ? $docente->persona->numero : '';
} else {
	$numero = Input::old('numerocalle');
}

if (trim(Input::old('manzana') == false)) {
	$manzana = ($docente->persona->manzana != NULL) ? $docente->persona->manzana : '';
} else {
	$manzana = Input::old('manzana');
}

if (trim(Input::old('codigopostal') == false)) {
	$codigoPostal = ($docente->persona->codigo_postal != 0) ? $docente->persona->codigo_postal : '';
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
					Docentes <small>editar docente</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('docentes/listado')}}">Docentes</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">editar</a>
						</li>
					</ul>
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
					{{ Form::open(array('url'=>'docentes/update' , 'class'=>'form-horizontal form-row-seperated', 'id'=>'FormAlumnos', 'enctype'=>'multipart/form-data'))}}

					<input type='hidden' name='txtAlumnoId' value='{{$docente->id}}'>

					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-user"></i> Editar Docente
							</div>
							<div class="actions">
								<button {{ $disabled }} type='submit' class="btn default green-stripe">
								<i class="fa fa-save"></i>
								<span class="hidden-480">
								Guardar </span>
								</button>
								<a href="{{url('docentes/listado')}}" class="btn default yellow-stripe">
								<i class="fa fa-reorder"></i>
								<span class="hidden-480">
								Listado </span>
								</a>
								<a href="{{url('docentes/listado')}}" class="btn default red-stripe">
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
											<a href="#tab_datos_personales" data-toggle="tab">
											Datos Personales </a>
										</li>
										<!--li>
											<a href="#tab_familia" data-toggle="tab">
											Familia </a>
										</li-->
										<li>
											<a href="{{url('docentes/legajo')}}/{{$docente->id}}" >
											Legajo </a>
										</li>
										<!--li>
											<a href="#tab_legajos" data-toggle="tab">
											Legajos </a>
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
														{{ Form::select('tipodocumento', $arrTipoDocumento, $docente->persona->tipodocumento_id, array('class'=>'table-group-action-input form-control input-medium', $disabled)); }}
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
															@if ($docente->Persona->foto)
															    <img src="{{url('docentes/img-perfil')}}/{{$docente->Persona->foto}}" alt="sin perfil">
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
														<label class="control-label" for="docenteactivo">Activo
															<div class="checker {{$disabled}}">
																<span class="<?php if ($docente->activo) echo 'checked'; ?>">
																<input type="checkbox" class="form-control" id="docenteactivo" name="docenteactivo" checked="<?php if ($docente->activo) echo 'CHECKED'; ?>">
																</span>
															</div>
														</label>
														<!--<label class="control-label" for="docenteactivo">Activo</label>
														<input type="checkbox" class="form-control" id="docenteactivo" name="docenteactivo"> !-->
														<label class="control-label" for="docenteempleado">Empleado
															<div class="checker {{$disabled}}">
																<span class="<?php if ($docente->empleado) echo 'checked'; ?>">
																<input type="checkbox" class="form-control" id="docenteempleado" name="docenteempleado" checked="<?php if ($docente->empleado) echo 'CHECKED'; ?>">
																</span>
															</div>
														</label>
														<label class="control-label" for="docentedisertante">Disertante
															<div class="checker {{$disabled}}">
																<span class="<?php if ($docente->disertante) echo 'checked'; ?>">
																<input type="checkbox" class="form-control" id="docentedisertante" name="docentedisertante" checked="<?php if ($docente->disertante) echo 'CHECKED'; ?>">
																</span>
															</div>
														</label>
														 <!-- <label class="control-label" for="alumnobecado">Alumno Becado</label>
														<input type="checkbox" class="form-control" name="alumnobecado" id="alumnobecado" <?php //if ($docente->becado) echo 'CHECKED'; ?> >! -->							
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
															<option @if ($sexo=='Masculino') {{'SELECTED'}} @endif value="Masculino">Masculino</option>
															<option @if ($sexo=='Femenino') {{'SELECTED'}} @endif value="Femenino">Femenino</option>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-2 control-label">Estado Civil:	</label>
													<div class="col-md-6">
														{{ Form::select('estadocivil', $arrEstadoCivil, $docente->persona->estadocivil_id, array('class'=>'table-group-action-input form-control input-medium', $disabled)); }}
													</div>
												</div>
												<div id="divavisofechanac" class="form-group <?php if ($errors->has('fechanacimiento')) echo 'has-error' ?>">
													<label class="col-md-2 control-label">Fecha Nacimiento: <span class="required">
													* </span>
													</label>
													
													<div class="col-md-2">
														<div class="input-icon right">
															<i class="fa fa-exclamation tooltips iconoerror" style="display:none" data-original-title="Fecha incorrecta." data-container="body"></i>
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
													<label class="col-md-2 control-label">Lugar Nac.:</label>
													<div class="col-md-6">
														{{ Form::select('paisnacimiento', $arrPais, $docente->persona->lugarnacimiento_id, array('class'=>'table-group-action-input form-control input-medium', $disabled)); }}
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
															<i class="fa fa-exclamation tooltips iconoerrorfechaing" style="display:none" data-original-title="Fecha incorrecta." data-container="body"></i>
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

												<div class="form-group">
													<label class="col-md-2 control-label">Titulo Habilitante:</label>
													<div class="col-md-3">
														{{ Form::select('titulohabilitante', $tituloHabilitante, $docente->titulohabilitante_id, array('class'=>'table-group-action-input form-control input-medium','id' => 'titulohabilitante', $disabled)); }}
													</div>
													<div class="col-md-2">
														<a href="#" id="btnAddTitle" class="btn default"><i class="fa fa-plus"></i></a>
													</div>
												</div >
												<div class="form-group">
													<label class="col-md-2 control-label">Organismo Habilitante:</label>
													<div class="col-md-3">
														{{ Form::select('organismoHabilitante', $organismoHabilitante, $docente->organismohabilitante_id, array('class'=>'table-group-action-input form-control input-medium', 'id' => 'organismohabilitante', $disabled)); }}
													</div>
													<div class="col-md-2">
														<a href="#" id="btnAddOrganism" class="btn default"><i class="fa fa-plus"></i></a>
													</div>
												</div>
												<div class="form-group">											
													<label class="col-md-2 control-label">N° Legajo Habilitante:</label>
													<div class="col-md-3">
														<input {{$readonly}} type="text" class="form-control" name="nroLegajoHabilitante" id="nroLegajoHabilitante" value="{{ $nrolegajohabilitante }}">
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
																	{{ Form::select('pais', $arrPais, $docente->persona->pais_id, array('class'=>'table-group-action-input form-control input-medium', 'id'=>'pais', $disabled)); }}
																</div>
															</div>

															<div class="form-group">
																<label class="col-md-2 control-label">Provincia:</label>
																<!--<div class="col-md-1">
																	<input type="text" class="form-control" name="codigoprovincia">
																</div>-->
																<div class="col-md-6">
																	{{ Form::select('provincia', $arrProvincia, $docente->persona->provincia_id, array('class'=>'table-group-action-input form-control input-medium', 'id'=>'provincia', $disabled)); }}
																</div>
															</div>

															<div class="form-group">
																<label class="col-md-2 control-label">Departamento:	</label>
																<!--<div class="col-md-1">
																	<input type="text" class="form-control" name="codigodepartamento">
																</div>-->
																<div class="col-md-6">
																	{{ Form::select('departamento', $arrDepartamento, $docente->persona->departamento_id, array('class'=>'table-group-action-input form-control input-medium', 'id'=>'departamento', $disabled)); }}
																</div>
															</div>


															<div class="form-group">
																<label class="col-md-2 control-label">Localidad:</label>
																<!--<div class="col-md-1">
																	<input type="text" class="form-control" name="codigolocalidad">
																</div>-->
																<div class="col-md-6">
																	{{ Form::select('localidad', $arrLocalidad, $docente->persona->localidad_id, array('class'=>'table-group-action-input form-control input-medium', 'id'=>'localidad', $disabled)); }}
																</div>
															</div>


															<div class="form-group">
																<label class="col-md-2 control-label">Barrio:</label>
																<div class="col-md-6">
																	<input type="text" class="form-control" name="txt_barrio" Input::old('txt_barrio') value='{{$docente->persona->barrio}}'>
																</div>
																<!--<div class="col-md-6">
																	{{ Form::select('barrio', $arrBarrio, $docente->persona->barrio_id, array('class'=>'table-group-action-input form-control input-medium', 'id'=>'barrio', $disabled)); }}
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
	<div class="modal fade" id="modalDesactivarDocente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Desactivar Docente</h4>
					</div>
					<div class="modal-body">
					<p>¿Estas seguro de cambiar el estado del Docente?</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn red" id="btnDesactivarDocente"><i class="fa fa-check"></i> Desactivar</button>
						<button type="button" class="btn default" id="btnCancelarDocente"><i class="fa fa-times-circle-o"></i> Cancelar</button>
					</div>
				</div>
				<!-- /.modal-contenido -->
			</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
	<!-- FIN DEL MODAL FORM-->	


	<!-- MODAL ACTIVAR EMPLEADO-->
	<div class="modal fade" id="modalActivarEmpleado" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Activar como empleado</h4>
					</div>
					<div class="modal-body">
					<p>¿Estas seguro de queres activar como empleado este docente?</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn blue" id="btnActivarEmpleado"><i class="fa fa-check"></i> Activar</button>
						<button type="button" class="btn default" id="btnCancelarEmpleado"><i class="fa fa-times-circle-o"></i> Cancelar</button>
					</div>
				</div>
				<!-- /.modal-contenido -->
			</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
	<!-- FIN DEL MODAL FORM-->


	<!-- MODAL ACTIVAR DISERTANTE-->
	<div class="modal fade" id="modalActivarDisertante" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Activar como disertante</h4>
					</div>
					<div class="modal-body">
					<p>¿Estas seguro de querer activar como disertante este docente?</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn blue" id="btnActivarDisertante"><i class="fa fa-check"></i> Activar</button>
						<button type="button" class="btn default" id="btnCancelarDisertante"><i class="fa fa-times-circle-o"></i> Cancelar</button>
					</div>
				</div>
				<!-- /.modal-contenido -->
			</div>
		<!-- /.modal-dialog -->
	</div>


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
	<div class="modal fade" id="modalAddTitle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Agregar Título Habilitante</h4>
					</div>
					<div class="modal-body">
						<form class="form-horizontal" id="frmTitle">
							<input type="hidden" id="txtIdHiddenContacto" value="">
							<div class="form-group errorTitleModal">
								<label class="col-md-3 control-label">Descripción</label>
								<div class="col-md-6">
									<input type="text" id="txtDescTitle" name="txtDescTitle" class="form-control">
									<span id="errorTitleModal" class="help-block"></span>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" id="btnModalAddTitle" class="btn purple"><i class="fa fa-edit"></i>Guardar</button>
						<button type="button" class="btn default" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> Cancelar</button>
					</div>
				</div>
				<!-- /.modal-contenido -->
			</div>
		<!-- /.modal-dialog -->
	</div>
	<div class="modal fade" id="modalAddOrganism" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Agregar Organismo Habilitante</h4>
					</div>
					<div class="modal-body">
						<form class="form-horizontal" id="frmTitle">
							<input type="hidden" id="txtIdHiddenContacto" value="">
							<div class="form-group errorOrganismModal">
								<label class="col-md-3 control-label">Descripción</label>
								<div class="col-md-6">
									<input type="text" id="txtDescOrganism" name="txtDescOrganism" class="form-control">
									<span id="errorOrganismModal" class="help-block"></span>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" id="btnModalAddOrganism" class="btn purple"><i class="fa fa-edit"></i>Guardar</button>
						<button type="button" class="btn default" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> Cancelar</button>
					</div>
				</div>
				<!-- /.modal-contenido -->
			</div>
		<!-- /.modal-dialog -->
	</div>
@stop

@section('customjs')
ComponentsFormTools.init();

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

$('#docenteactivo').change(function(){
    var checkeado = $(this).attr("checked");
    if(!checkeado) {
    	$(this).prop("checked",true);
    	$(this).parent().addClass("checked");
        $('#modalDesactivarDocente').modal('show');
    }
});

$('#btnDesactivarDocente').on('click', function(e){
	e.preventDefault();
	$("#docenteactivo").prop("checked", false );
	$("#docenteactivo").parent().removeClass("checked");
	$('#modalDesactivarDocente').modal('hide');
});

$('#btnCancelarDocente').on('click', function(e){
	e.preventDefault();
	$('#modalDesactivarDocente').modal('hide');
})

//activar empleado
$('#docenteempleado').change(function(){
    var checkeado = $(this).attr("checked");
    if(checkeado) {
    	$(this).prop("checked",false);
    	$(this).parent().removeClass("checked");
        $('#modalActivarEmpleado').modal('show');
    }
});

$('#btnActivarEmpleado').on('click', function(e){
	e.preventDefault();
	$("#docenteempleado").prop("checked", true );
	$("#docenteempleado").parent().addClass("checked");
	$('#modalActivarEmpleado').modal('hide');
});

$('#btnCancelarEmpleado').on('click', function(e){
	e.preventDefault();
	$('#modalActivarEmpleado').modal('hide');
})
//activar empleado

//activar disertante
$('#docentedisertante').change(function(){
    var checkeado = $(this).attr("checked");
    if(checkeado) {
    	$(this).prop("checked",false);
    	$(this).parent().removeClass("checked");
        $('#modalActivarDisertante').modal('show');
    }
});

$('#btnActivarDisertante').on('click', function(e){
	e.preventDefault();
	$("#docentedisertante").prop("checked", true );
	$("#docentedisertante").parent().addClass("checked");
	$('#modalActivarDisertante').modal('hide');
});
$('#btnAddTitle').on('click', function(e){
	e.preventDefault();
	$('#modalAddTitle').modal('show');
});

$('#btnModalAddTitle').on('click', function(e){
	e.preventDefault();
	if ($('#txtDescTitle').val() == "") {
		$('.errorTitleModal').addClass('has-error');
		$('#errorTitleModal').text('Ingrese una descripción').show();
		return false;
	}

	$.ajax({
	  url: '{{url('docentes/titulo')}}',
	  data: {'txtDescTitle': $('#txtDescTitle').val() },
	  dataType: 'json',
	  type: 'POST'
	}).done(function(response) {
		if (response.hasOwnProperty('error')) {
			$('.errorTitleModal').addClass('has-error');
			$('#errorTitleModal').text(response.error).show();
			return false;
		}

		$('#titulohabilitante').empty();
		$.each(response, function(index, value) {
			$('#titulohabilitante').append('<option value=' + index + '>' + value + '</option>');
		});

		$("select option").filter(function() {
			return $(this).text() == $('#txtDescTitle').val();
		}).prop('selected', true);	

		$('#txtDescTitle').val("");
		$('.errorTitleModal').removeClass('has-error');
		$('#modalAddTitle').modal('hide');
		$('#errorTitleModal').text(response.error).hide();
	});
});
//////////////////////////////////////////////////
$('#btnAddOrganism').on('click', function(e){
	e.preventDefault();
	$('#modalAddOrganism').modal('show');
});

$('#btnModalAddOrganism').on('click', function(e){
	e.preventDefault();
	if ($('#txtDescOrganism').val() == "") {
		$('.errorOrganismModal').addClass('has-error');
		$('#errorOrganismModal').text('Ingrese una descripción').show();
		return false;
	}

	$.ajax({
	  url: '{{url('docentes/organismo')}}',
	  data: {'txtDescOrganism': $('#txtDescOrganism').val() },
	  dataType: 'json',
	  type: 'POST'
	}).done(function(response) {
		if (response.hasOwnProperty('error')) {
			$('.errorOrganismModal').addClass('has-error');
			$('#errorOrganismModal').text(response.error).show();
			return false;
		}

		$('#organismohabilitante').empty();
		$.each(response, function(index, value) {
			$('#organismohabilitante').append('<option value=' + index + '>' + value + '</option>');
		});

		$("#organismohabilitante option").filter(function() {
			return $(this).text() == $('#txtDescOrganism').val();
		}).prop('selected', true);	

		$('#txtDescOrganism').val("");
		$('.errorOrganismModal').removeClass('has-error');
		$('#modalAddOrganism').modal('hide');
		$('#errorOrganismModal').text(response.error).hide();
	});
});

$('#btnCancelarDisertante').on('click', function(e){
	e.preventDefault();
	$('#modalActivarDisertante').modal('hide');
})
//activar disertante

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

	//Comprobacion de fecha de ingreso
	$('#fechaingreso').on('focusout', function(){
		var fecha = $('#fechaingreso');
		var divaviso = $('#divavisofechaing');
		var iconoerror = $('.iconoerrorfechaing');
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

	$('#departamento').combodinamico("{{url('docentes/localidades/')}}", $('#localidad'));
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
