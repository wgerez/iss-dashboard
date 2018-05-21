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

@section('content')
	<!-- COMIENZO CONTENIDO -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- COMIENZO DEL HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- COMIENZO TITULO & BREADCRUMB-->
					<h3 class="page-title">
					Docentes <small>nuevo docente</small>
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
							<a href="#">nuevo</a>
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
					{{ Form::open(array('url'=>'docentes/guardar', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FormDocentes', 'files' => true))}}
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-user"></i> Nuevo Docente
							</div>
							<div class="actions">
								<button type='submit' class="btn default green-stripe">
								<i class="fa fa-save"></i>
								<span class="hidden-480">
								Guardar </span>
								</button>
								<a href="listado" class="btn default yellow-stripe">
								<i class="fa fa-reorder"></i>
								<span class="hidden-480">
								Listado </span>
								</a>
								<a href="listado" class="btn default red-stripe">
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
										<li>
											<a href="#tab_legajos" data-toggle="tab">
											Legajos </a>
										</li>
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
														<input type="text" class="form-control" name="apellido" placeholder="" value="{{ Input::old('apellido') }}">

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
														<input type="text" class="form-control" name="nombre" placeholder="" value="{{ Input::old('nombre') }}">

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
														{{ Form::select('tipodocumento', $arrTipoDocumento, Input::old('tipodocumento'), array('class'=>'table-group-action-input form-control input-medium')); }}
													</div>
												</div>
												<div class="form-group <?php if ($errors->has('documento')) echo 'has-error' ?>">
													<label class="col-md-3 control-label">Documento: <span class="required">
													* </span>
													</label>
													<div class="col-md-3">
														<input type="text" class="form-control" name="documento" id="documento" placeholder="" value="{{ Input::old('documento') }}">

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
														<input type="text" class="form-control" name="cuil" id="cuil" placeholder="" value="{{ Input::old('cuil') }}">
													</div>
												</div>
											</div>	
											<div class="col-md-4">
												<div class="row" style="padding: 10px 0">
													<center>
													<div class="fileinput fileinput-new" data-provides="fileinput">
														<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 130px; height: 110px;">
															<img src="{{url('assets/admin/layout/img/sinperfil.png')}}" alt="sin perfil">
														</div>
														<div>
															<span class="btn btn-sm default btn-file">
																<span class="fileinput-new"><i class="fa fa-search"></i> Buscar Foto </span>
																<span class="fileinput-exists"><i class="fa fa-edit"></i> Cambiar </span>
																<input type="file" name="fotoperfil">
															</span>
															<a href="#" class="btn btn-sm red fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash-o"></i> Eliminar </a>
														</div>
													</div>	
													</center>				
												</div>
												<div class="row">
													<center>
														<label class="control-label" for="docenteactivo">Activo</label>
														<input type="checkbox" checked class="form-control" id="docenteactivo" name="docenteactivo">
														<label class="control-label" for="docenteempleado">Empleado</label>
														<input type="checkbox" class="form-control" name="docenteempleado" id="docenteempleado">
														<label class="control-label" for="disertante">Disertante</label>
														<input type="checkbox" class="form-control" name="disertante" id="disertante">				
													</center>
												</div>
											</div>
											</div> <!-- row -->
												<div class="form-group">
													<label class="col-md-2 control-label">Sexo: <span class="required">
													* </span>
													</label>
													<div class="col-md-6">
														<select name="sexo" id="sexo" class="table-group-action-input form-control input-medium">
															<option value="Masculino">Masculino</option>
															<option value="Femenino">Femenino</option>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-2 control-label">Estado Civil:	</label>
													<div class="col-md-6">
														{{ Form::select('estadocivil', $arrEstadoCivil, Input::old('estadocivil'), array('class'=>'table-group-action-input form-control input-medium')); }}
													</div>
												</div>
												<div id="divavisofechanac" class="form-group <?php if ($errors->has('fechanacimiento')) echo 'has-error' ?>">
													<label class="col-md-2 control-label">Fecha Nacimiento: <span class="required">
													* </span>
													</label>
													<div class="col-md-2">
														<div class="input-icon right">
															<i class="fa fa-exclamation tooltips iconoerror" style="display:none" data-original-title="Fecha incorrecta." data-container="body"></i>
															<input type="text" class="form-control" name="fechanacimiento" id="fechanacimiento" placeholder="" value="{{ Input::old('fechanacimiento') }}">

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
														<input type="text" class="form-control" readonly name="edad" id="edad" value="{{ Input::old('edad') }}">
													</div>
												</div>

												<div class="form-group">
													<label class="col-md-2 control-label">Lugar Nac.:</label>
													<div class="col-md-6">
														{{ Form::select('paisnacimiento', $arrPais, Input::old('paisnacimiento'), array('class'=>'table-group-action-input form-control input-medium')); }}
													</div>
												</div>

												<div class="form-group">
													<label class="col-md-2 control-label <?php if ($errors->has('fechaingreso')){ echo "text-danger";} ?> ">Fecha Ingreso:<span class="required">
													* </span></label>
													<div id="divavisofechaing" class="col-md-2">
														<div class="input-icon right">
															<i class="fa fa-exclamation tooltips iconoerrorfechaing" style="display:none" data-original-title="Fecha incorrecta." data-container="body"></i>
															<input type="text" class="form-control" name="fechaingreso" id="fechaingreso" placeholder="" value="{{ Input::old('fechaingreso') }}">

															<!-- mostrar cuando exista error -->
													    	@if ($errors->has('fechaingreso'))
														    	<span class="text-danger">{{ $errors->first('fechaingreso') }}</span>
													    	@endif
													    	<!--fin error-->
													    </div>	

													</div>
													<label class="col-md-2 control-label">Fecha Egreso:</label>
													<div class="col-md-2">
														<input type="text" class="form-control" name="fechaegreso" id="fechaegreso" placeholder="" value="{{ Input::old('fechaegreso') }}">
													</div>													
												</div>

												<div class="form-group">
													<label class="col-md-2 control-label">Título Habilitante:</label>
													<div class="col-md-3">
														{{ Form::select('tituloHabilitante', $titulosHabilitantes, Input::old('tituloHabilitante'), array('class'=>'table-group-action-input form-control input-medium', 'id' => 'titulohabilitante')); }}
													</div>
													<div class="col-md-2">
														<a href="#" id="btnAddTitle" class="btn default"><i class="fa fa-plus"></i></a>
													</div>
												</div>

												<div class="form-group">
													<label class="col-md-2 control-label">Organismo Habilitante:</label>
													<div class="col-md-3">
														{{ Form::select('organismoHabilitante', $organismosHabilitantes, Input::old('organismoHabilitante'), array('class'=>'table-group-action-input form-control input-medium', 'id' => 'organismohabilitante')); }}

													</div>
													<div class="col-md-2">
														<a href="#" id="btnAddOrganism" class="btn default"><i class="fa fa-plus"></i></a>
													</div>
												</div>
												<div class="form-group">											
													<label class="col-md-2 control-label">N° Legajo Habilitante:</label>
													<div class="col-md-3">
														<input type="text" class="form-control" name="nroLegajoHabilitante" id="nroLegajoHabilitante" value="{{ Input::old('nrolegajohabilitante') }}">
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
																	{{ Form::select('pais', $arrPais, Input::old('pais'), array('class'=>'table-group-action-input form-control input-medium', 'id'=>'pais')); }}
																</div>
															</div>

															<div class="form-group">
																<label class="col-md-2 control-label">Provincia:</label>
																<!--<div class="col-md-1">
																	<input type="text" class="form-control" name="codigoprovincia">
																</div>-->
																<div class="col-md-6">
																	{{ Form::select('provincia', $arrProvincia, Input::old('provincia'), array('class'=>'table-group-action-input form-control input-medium','id'=>'provincia')); }}
																</div>
															</div>

															<div class="form-group">
																<label class="col-md-2 control-label">Departamento:	</label>
																<!--<div class="col-md-1">
																	<input type="text" class="form-control" name="codigodepartamento">
																</div>-->
																<div class="col-md-6">
																	{{ Form::select('departamento', $arrDepartamento, Input::old('departamento'), array('class'=>'table-group-action-input form-control input-medium','id'=>'departamento')); }}
																</div>
															</div>


															<div class="form-group">
																<label class="col-md-2 control-label">Localidad:</label>
																<!--<div class="col-md-1">
																	<input type="text" class="form-control" name="codigolocalidad">
																</div>-->
																<div class="col-md-6">
																	{{ Form::select('localidad', $arrLocalidad, Input::old('localidad'), array('class'=>'table-group-action-input form-control input-medium' ,'id'=>'localidad')); }}
																</div>
															</div>


															<div class="form-group">
																<label class="col-md-2 control-label">Barrio:</label>
																<div class="col-md-6">
																	<input type="text" class="form-control" name="txt_barrio" Input::old('txt_barrio')>
																</div>
																<!--<div class="col-md-6">
																	{{ Form::select('barrio', $arrBarrio, Input::old('barrio'), array('class'=>'table-group-action-input form-control input-medium','id'=>'barrio')); }}
																</div>-->
															</div>															


															<div class="form-group">
																<label class="col-md-2 control-label">Calle:
																</label>
																<div class="col-md-6">
																	<input type="text" class="form-control" name="calle" placeholder="" value="{{ Input::old('calle') }}">
																</div>
															</div>

															<div class="form-group">
																<label class="col-md-2 control-label">Número:
																</label>
																<div class="col-md-1">
																	<input type="text" class="form-control" name="numerocalle" placeholder="" value="{{ Input::old('numerocalle') }}">
																</div>

																<label class="col-md-2 control-label">Mz.:
																</label>
																<div class="col-md-1">
																	<input type="text" class="form-control" name="manzana" placeholder="" value="{{ Input::old('manzana') }}">
																</div>																
															</div>		

															<div class="form-group">
																<label class="col-md-2 control-label">Departamento:
																</label>
																<div class="col-md-1">
																	<input type="text" class="form-control" name="domiciliodepartamento" placeholder="" value="{{ Input::old('domiciliodepartamento') }}">
																</div>

																<label class="col-md-2 control-label">Piso.:
																</label>
																<div class="col-md-1">
																	<input type="text" class="form-control" name="piso" placeholder="" value="{{ Input::old('piso') }}">
																</div>																
															</div>		

															<div class="form-group <?php if ($errors->has('codigoPostal')) echo 'has-error' ?>">
																<label class="col-md-2 control-label">Código Postal:
																</label>
																<div class="col-md-2">
																	<input type="text" class="form-control" name="codigopostal" placeholder="" value="{{ Input::old('codigopostal') }}">

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
																	{{ Form::select('cboContacto', $arrContacto, Input::old('cboContacto'), array('class'=>'table-group-action-input form-control', 'id'=>'cboContacto')); }}
																</div>
																<div class="errorContactoDescripcion">
																	<label class="col-md-2 control-label">Descripci&oacute;n:</label>
																	<div class="col-md-3">
																		<input type="text" class="form-control" name="contactodescripcion" id="contactodescripcion" placeholder="">
																		<span id="errorContactoDescripcion" class="help-block"></span>
																	</div>
																</div>	
																<div class="col-md-2">
																	<a href="#" id="btnAgregaContacto" class="btn default"><i class="fa fa-plus"></i> Agregar</a>
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
																			 <center>Tipo</center>
																		</th>
																		<th>
																			 <center>Descripción</center>
																		</th>
																		<th>
																			 <center>Acción</center>
																		</th>
																	</tr>
																	</thead>
																	<tbody>
																	</tbody>
																	</table>
																</div>
															</div>
														</div>
													</div>
											</div>	
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
	$('#tablecontactos > tbody').append('<tr><td><span id="icono_'+idaleatorio+'">'+ico+'</span></td><td><span id="tipo_'+idaleatorio+'">'+$("#cboContacto :selected").text()+'</span></td><td><span id="des_'+idaleatorio+'">'+$('#contactodescripcion').val()+'</span></td><td><center> <a rel="'+idaleatorio+'" title="Eliminar" href="#" class="btn default btn-sm red borrarContacto"><i class="fa fa-trash-o"></i></a></center></td></tr>');
	$('#FormDocentes').append('<input id="'+ idaleatorio +'" name="contactos[]" type="hidden" value="'+ $('#cboContacto').val() +'|'+ $('#contactodescripcion').val() +'">');
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


$('#pais, #provincia, #departamento, #localidad, #barrio').select2({
	placeholder: "Seleccione",
	allowClear: true
});

//activar docente
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
//activar docente


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
$('#disertante').change(function(){
    var checkeado = $(this).attr("checked");
    if(checkeado) {
    	$(this).prop("checked",false);
    	$(this).parent().removeClass("checked");
        $('#modalActivarDisertante').modal('show');
    }
});

$('#btnActivarDisertante').on('click', function(e){
	e.preventDefault();
	$("#disertante").prop("checked", true );
	$("#disertante").parent().addClass("checked");
	$('#modalActivarDisertante').modal('hide');
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
<script src="{{url('assets/admin/pages/scripts/helpers/calculo.edad.js')}}" type="text/javascript"></script>
<script src="{{url('assets/admin/layout/scripts/menusticky.js')}}" type="text/javascript"></script>
<script src="{{url('assets/admin/pages/scripts/components-form-tools.js')}}"></script>
<script src="{{url('assets/admin/pages/scripts/helpers/verificar.fecha.js')}}" type="text/javascript"></script>
<script src="{{url('assets/admin/pages/scripts/helpers/jquery.combodinamico.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
@stop
