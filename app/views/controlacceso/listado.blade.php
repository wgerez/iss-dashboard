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
//BOTONES Y CAMPOS DE PERMISOS
$disabled 	= (!$editar) ? 'disabled' : '';
$readonly 	= (!$editar) ? 'readonly' : '';
$imprimir 	= (!$imprimir) ? 'disabled' : '';
$orgId 		= (isset($OrgID)) ? $OrgID : 0;

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
					Acceso <small>Control de Acceso</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('controlacceso/listado')}}">Control de Acceso</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('controlacceso/listado')}}">Listado</a>
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
					    @if (Session::get('message_type') == ControlAccesoController::OPERACION_EXITOSA)

					        <div class="note note-success">
								<p>{{ Session::get('message') }}</p>
							</div>

						@elseif (Session::get('message_type') == ControlAccesoController::OPERACION_FALLIDA)

					        <div class="note note-danger">
								<p>{{ Session::get('message') }}</p>
							</div>

						@elseif (Session::get('message_type') == ControlAccesoController::OPERACION_CANCELADA)

					        <div class="note note-warning">
								<p>{{ Session::get('message') }}</p>
							</div>

						@elseif (Session::get('message_type') == ControlAccesoController::OPERACION_INFO)

					        <div class="note note-info">
								<p>{{ Session::get('message') }}</p>
							</div>

						@endif
					@endif
					<!-- COMIENZO DE LA TABLA-->
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-files-o"></i>Listado de Control de Acceso
							</div>
							<div class="actions">
								<a href="{{url('controlacceso/crear')}}" {{ $disabled }} class="btn default blue-stripe">
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Nuevo </span>
								</a>
								<a href="{{url('controlacceso/listado')}}" class="btn default yellow-stripe">
								<i class="fa fa-refresh"></i>
								<span class="hidden-480">
								Actualizar </span>
								</a>
								<a target="_blank" href="#" id="imprimir" {{$imprimir}} class="btn default yellow-stripe" <?php if (count($resultados) == 0) echo 'disabled' ?>>
								<i class="glyphicon glyphicon-print"></i>
								<span class="hidden-480">
								Imprimir </span>
								</a>

							</div>

						</div>
						<div class="portlet-body">
							<div class="form-body">
								<form method="POST" action="{{url('controlacceso/obtenermovimientos')}}" class="form-horizontal form-row-seperated" id="FrmPlanestudios" name="">
									<div class="form-group">
										<label  class="col-md-2 col-sm-2 control-label">Organización:</label>
										<div class="col-md-6 col-sm-10">
											{{ Form::select('organizacion', $organizaciones, Input::old('organizacion'), array('class'=>'table-group-action-input form-control','id'=>'organizacion')) }}
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-2 col-sm-2 control-label" for="filtrar">Filtrar por:</label>
										<div class="col-md-3 col-sm-10">
											<select class="table-group-action-input form-control" name="filtrar" id="filtrar">
												<option value="0" disabled="disabled" selected="selected">Seleccionar</option>
												@if (isset($perfilesu))
													@foreach ($perfilesu as $perfiles)
														<option value="<?php echo $perfiles; ?>" <?php if ($filtro == $perfiles) echo "selected=selected"; ?>><?php echo $perfiles; ?></option>
													@endforeach
												@endif
											</select>
											@if ($errors->has('filtrar'))
											    <span class="help-block">{{ $errors->first('filtrar') }}</span>
										    @endif
										</div>

										<div class="col-md-4 col-sm-4">
											<input class="form-control" name="txtalumno" id="txtalumno" type="text" placeholder="(Todos)" value="<?php if (isset($txtalumno)) echo $txtalumno; ?>" <?php if (!isset($txtalumno)) echo "disabled"; ?>>
										</div>
				
									</div>

									<div class="form-group">
										<label class="col-md-2 control-label <?php if ($errors->has('fechadesde')) echo 'text-danger' ?>">Fecha Desde:</label>
										<div id="divavisofechaing" class="col-md-3 <?php if ($errors->has('fechadesde')) echo 'has-error' ?>">
											<div class="input-icon right">
												<i class="fa fa-exclamation tooltips iconoerrorfechaing" style="display:none" data-original-title="Fecha Incorrecta." data-container="body"></i>
												<input type="date" class="form-control" name="fechadesde" id="fechadesde" placeholder="" value="<?php if (isset($fechadesdes)) {echo $fechadesdes;} else {echo date('Y-m-d');} ?>">

												<!-- mostrar cuando exista error -->
										    	@if ($errors->has('fechadesde'))
											    	<span class="help-block">{{ $errors->first('fechadesde') }}</span>
										    	@endif
										    	<!--fin error-->
											</div>
										</div>
										<label class="col-md-2 control-label">Fecha Hasta:</label>
										<div class="col-md-3">
											<input type="date" class="form-control" name="fechahasta" id="fechahasta" placeholder="" value="<?php if (isset($fechahastas)) {echo $fechahastas;} else {echo date('Y-m-d');} ?>">
										</div>
										
										<div class="col-md-2 col-sm-2">
											<button class="btn btn-primary" type="submit" id='BtnBuscar'><i class="fa fa-search"></i> Buscar</button>
										</div>
									</div>
								</form>
							</div>
							<br>

							<table class="table table-striped table-bordered table-hover" id="table_movimien">
								<thead>
								<tr>
									<th class="hidden-xs" style="display: none;">
										<center><i class="fa fa-user"></i> Usuario</center>
									</th>
									<th class="hidden-xs">
										<center><i class="glyphicon glyphicon-list-alt"></i> Código</center>
									</th>
									<th>
										<center><i class="fa fa-users"></i> Apellido y Nombre</center>
									</th>
									<th>
										<center><i class="glyphicon glyphicon-calendar"></i> Dias</center>
									</th>
									<th>
										<center><i class="glyphicon glyphicon-thumbs-up"></i> Entrada</center>
									</th>
									<th>
										<center><i class="glyphicon glyphicon-thumbs-down"></i> Salida</center>
									</th>
									<th>
										<center><i class="glyphicon glyphicon-time"></i> Hs. Cumplidas</center>
									</th>	
									<th>
										<center><i class="glyphicon glyphicon-pencil"></i> Acciones</center>
									</th>			

								</tr>
								</thead>
								<tbody>
									@if (isset($resultados))
										@foreach ($resultados as $resultado)
											@if ($resultado['i'] == 0)
												<tr>
													<td style="display: none;">
														<center>
															{{ $resultado['usuario'] }}
														</center>
													</td>
													<td>
														<center>
															{{ $resultado['persona_id'] }}
														</center>
													</td>
													<td>
														<center>
															{{ $resultado['apellido_nombre'] }}
														</center>
													</td>
													<td>
														<center>
															{{ $resultado['dia'] }}
														</center>
													</td>
													<td>
														<center>
															{{ $resultado['entrada'] }}
														</center>
													</td>
													<td>
														<center>
															{{ $resultado['salida'] }}
														</center>
													</td>
													<td>
														<center>
															{{ $resultado['horascumplidas'] }}
														</center>
													</td>													
													<td>
														<center>
															<a title="Modificar" href="#modaleditarregistro" data-id="{{$resultado['id']}}" data-usuario="{{$resultado['usuario']}}" data-apellido_nombre="{{$resultado['apellido_nombre']}}" data-fecha_entrada="{{$resultado['fecha_entrada']}}" data-fecha_salida="{{$resultado['fecha_salida']}}" data-hora="{{$resultado['hora']}}" data-minuto="{{$resultado['minuto']}}" data-horas="{{$resultado['horas']}}" data-minutos="{{$resultado['minutos']}}" class="btn default btn-xs purple btnEditarRegistro">
																<i class="fa fa-edit"></i>
															</a>
														</center>
													</td>
												</tr>
											@else
												<tr>
													<td style="display: none;">
														<center>
															{{ $resultado['usuario'] }}
														</center>
													</td>
													<td>
														<center>
															
														</center>
													</td>
													<td>
														<center>
															
														</center>
													</td>
													<td>
														<center>
															{{ $resultado['dia'] }}
														</center>
													</td>
													<td>
														<center>
															{{ $resultado['entrada'] }}
														</center>
													</td>
													<td>
														<center>
															{{ $resultado['salida'] }}
														</center>
													</td>
													<td>
														<center>
															{{ $resultado['horascumplidas'] }}
														</center>
													</td>													
													<td>
														<center>
															<a title="Modificar" href="#modaleditarregistro" data-id="{{$resultado['id']}}" data-usuario="{{$resultado['usuario']}}" data-apellido_nombre="{{$resultado['apellido_nombre']}}" data-fecha_entrada="{{$resultado['fecha_entrada']}}" data-fecha_salida="{{$resultado['fecha_salida']}}" data-hora="{{$resultado['hora']}}" data-minuto="{{$resultado['minuto']}}" data-horas="{{$resultado['horas']}}" data-minutos="{{$resultado['minutos']}}" class="btn default btn-xs purple btnEditarRegistro">
																<i class="fa fa-edit"></i>
															</a>
														</center>
													</td>
												</tr>
											@endif
										@endforeach
											
									@endif
								</tbody>
							</table>
							
							<!-- MODAL-->
							<div id="modalRegistraEntradaSalida" class="modal fade" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title"><strong>Registrar Entrada/Salida</strong></h4>
										</div>
										{{ Form::open(array('url'=>'controlacceso/registrarentradasalida', 'class' => 'form-horizontal form-row-seperated', 'id'=>'FrmControlAcceso', 'name'=>'FrmControlAcceso')) }}
										  <input id="txt_usuario_id" name='txt_usuario_id' type="hidden" value="">
										  <div class="modal-body form-body">
											<div class="scroller" style="height:250px;" data-always-visible="1" data-rail-visible="1">
													<div class="col-md-12 col-sm-12">
														<div class="form-group">
															<div class="col-md-2 col-sm-2">
													 			<label class="text-info control-label"><strong>Personal:</strong></label>
													 		</div>
													 		<div class="input-icon col-md-6 col-sm-6">
													 			<input type="text" name="txt_personal" id="txt_personal" class="form-control" value="" readonly="readonly">
													 		</div>
												 		</div>
														<div class="form-group">
															<div class="col-md-2 col-sm-2">
													 			<label class="text-info control-label"><strong>Usuario:</strong></label>
													 		</div>
													 		<div class="input-icon col-md-4 col-sm-4">
													 			<input type="text" name="txt_usuario" id="txt_usuario" class="form-control" value="" readonly="readonly">
													 		</div>
												 		</div>
														<div class="form-group">
															<div class="col-md-2 col-sm-2">
													 			<label class="text-info control-label" for="mImporte"><strong>Entrada:</strong></label>
													 		</div>
													 		<div class="input-icon col-md-5 col-sm-4">
																<input type="date" name="txt_entrada" id="txt_entrada" class="form-control" value=''>
															</div>
															<!--div class="col-md-2 col-sm-2">
																<label class="text-info control-label">
																	<strong>Hora Entrada:</strong>
																</label>
															</div-->
															<div class="col-md-2 col-sm-2">
																<select class="table-group-action-input form-control" name="txt_hora" id="txt_hora">
																	<option value=""></option>
																	<?php
																	for ($i=00; $i < 24; $i++) { 
																		if ($i < 10) {
																		 	$i = '0'.$i;
																		 } ?>
																		<option value="{{ $i }}">{{ $i }}</option>
																	<?php } ?>
																</select>
												                <!--input type="number" name="txt_hora" id="txt_hora" class="form-control" value=""-->
												            </div>
												            <div class="col-md-2 col-sm-2">
												            	<select class="table-group-action-input form-control" name="txt_minuto" id="txt_minuto">
																	<option value=""></option>
																	<?php
																	for ($i=00; $i < 60; $i++) { 
																		if ($i < 10) {
																		 	$i = '0'.$i;
																		 } ?>
																		<option value="{{ $i }}">{{ $i }}</option>
																	<?php } ?>
																</select>
												                <!--input type="number" name="txt_minuto" id="txt_minuto" class="form-control" value=""-->
															</div>
													 	</div>
														<div class="form-group">
															<div class="col-md-2 col-sm-2">
													 			<label class="text-info control-label" for="mImporte"><strong>Salida:</strong></label>
													 		</div>
													 		<div class="input-icon col-md-5 col-sm-4">
																<input type="date" name="txt_salida" id="txt_salida" class="form-control" value=''>
															</div>
															<div class="col-md-2 col-sm-2">
																<select class="table-group-action-input form-control" name="txt_horas" id="txt_horas">
																	<option value=""></option>
																	<option value=""></option>
																	<?php
																	for ($i=00; $i < 24; $i++) { 
																		if ($i < 10) {
																		 	$i = '0'.$i;
																		 } ?>
																		<option value="{{ $i }}">{{ $i }}</option>
																	<?php } ?>
																</select>
												                <!--input type="number" name="txt_horas" id="txt_horas" class="form-control" value=""-->
												            </div>
												            <div class="col-md-2 col-sm-2">
																<select class="table-group-action-input form-control" name="txt_minutos" id="txt_minutos">
																	<option value=""></option>
																	<option value=""></option>
																	<?php
																	for ($i=00; $i < 60; $i++) { 
																		if ($i < 10) {
																		 	$i = '0'.$i;
																		 } ?>
																		<option value="{{ $i }}">{{ $i }}</option>
																	<?php } ?>
																</select>
												                <!--input type="number" name="txt_minutos" id="txt_minutos" class="form-control" value=""-->
															</div>
													 	</div>
													</div>
												
											</div>
										</div>
										<div class="modal-footer">
											<!--a target="_blank" href="#" id="imprimir1" class="btn default">
												<i class="fa fa-print"></i>
												<span class="hidden-480">Imprimir</span>
											</a-->
											<button type="button" id="btnGuardarAcceso" class="btn blue"><i class="fa fa-save"></i> Guardar</button>
											<button type="button" class="btn default" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> Cerrar</button>
										</div>
										{{ Form::close() }}

									</div>
								</div>
							</div>	

							<!-- FIN MODAL-->

						</div>
					</div>
					<!-- FIN DE LA TABLA-->
				</div>
			</div>
			<!-- FIN DEL CONTENIDO -->
		</div>
	</div>
	<!-- FIN -->

@stop


@section('customjs')
	$(document).ready(function() {
	    $('#table_movimien').DataTable();
	});

	$('#btnGuardarAcceso').live('click', function() {

		if ($('#txt_entrada').val() == '' || $('#txt_hora').val() == '' || $('#txt_minuto').val() == '') {
			alert('Debe por lo menos cargar datos de entrada');
			return;
		}
		
		if ($('#txt_entrada').val() > $('#txt_salida').val()) {
			alert('La fecha de salida no debe superar la fecha de entrada!');
			return;
		}
		
		if ($('#txt_salida').val() != '') {
			if ($('#txt_horas').val() == '' || $('#txt_minutos').val() == '') {
				alert('Debe ingresar Hora de salida!');
				return;
			}
		}

		$('#FrmControlAcceso').submit();
	});

	$('#BtnBuscardni').hide();

	$('#organizacion').select2({
		placeholder: "Seleccione",
		allowClear: true
	});

	$('#filtrar').on('change', function(){
		if ($('#filtrar').val() == 0) {
			$("#txtalumno").attr("placeholder", "(Todos)").val("").focus().blur();
    		$("#txtalumno").attr('disabled', 'disabled');
    		$("#BtnBuscar").attr('disabled', 'disabled');
    		//$('#txt_alumno_id').val('');
			//$('#BtnBuscardni').hide();
    	} else if ($('#filtrar').val() == 'N° Documento') {
    		$("#txtalumno").removeAttr("disabled");
    		$("#txtalumno").attr("placeholder", "N° Documento").val("").focus().blur();
    		$("#BtnBuscar").removeAttr("disabled");
			//$('#BtnBuscardni').show();
    	} else if ($('#filtrar').val() == 'Usuario') {
    		$("#txtalumno").removeAttr("disabled");
    		$("#txtalumno").attr("placeholder", "Usuario").val("").focus().blur();
    		$("#BtnBuscar").removeAttr("disabled");
			//$('#BtnBuscardni').show();
    	} else if ($('#filtrar').val() == 'Apellido') {
    		$("#txtalumno").removeAttr("disabled");
    		$("#txtalumno").attr("placeholder", "Apellido").val("").focus().blur();
    		$("#BtnBuscar").removeAttr("disabled");
    	} else if ($('#filtrar').val() == 'Nombre') {
    		$("#txtalumno").removeAttr("disabled");
    		$("#txtalumno").attr("placeholder", "Nombre").val("").focus().blur();
    		$("#BtnBuscar").removeAttr("disabled");
    	} else {
    		$("#txtalumno").attr("placeholder", "(Todos)").val("").focus().blur();
    		$("#BtnBuscar").removeAttr("disabled");
    		$("#txtalumno").attr('disabled', 'disabled');
    	}
	});	

    $('#organizacion').change(function() {
		$('#filtrar').children().remove().end();

		if ($('#organizacion').val() == 0) return;
		
		$.ajax({
		  url: "{{url('controlacceso/obteneracceso')}}",
		  data:{'organizacion_id': $('#organizacion').val()},
		  type: 'POST'
		}).done(function(perfiles) {
			console.log(perfiles);
			
			$('#filtrar').append(
		        $('<option></option>').val(0).html('Seleccionar')
		    );

			$.each(perfiles, function(key, value) {
				$('#filtrar').append(
			        $('<option></option>').val(value).html(value)
			    );
			});
		}).error(function(data){
			console.log(data);
		});
    });

	//AL PRESIONAR LOS BOTONES EDITAR PASO EL DATA ID DEL USUARIO A EDITAR
	$('.btnEditarRegistro').live('click', function(){
		//PASO EL DATA ID AL CAMPO OCULTO
		$('#txt_usuario_id').val($(this).data('id'));
		$('#txt_usuario').val($(this).data('usuario'));
		$('#txt_personal').val($(this).data('apellido_nombre'));
		$('#txt_entrada').val($(this).data('fecha_entrada'));
		$('#txt_salida').val($(this).data('fecha_salida'));
		$('#txt_hora').val($(this).data('hora'));
		$('#txt_minuto').val($(this).data('minuto'));
		$('#txt_horas').val($(this).data('horas'));
		$('#txt_minutos').val($(this).data('minutos'));
		//MUESTRO EL MODAL DE ADVERTENCIA
		$('#modalRegistraEntradaSalida').modal('show');
	});

	$('#imprimir').on('click', function(e){
		e.preventDefault();
		window.open("{{url('controlacceso/imprimiracceso')}}?fechadesde=" + $('#fechadesde').val() + '&fechahasta=' + $('#fechahasta').val() + '&filtrar=' + $('#filtrar').val() + '&txtalumno=' + $('#txtalumno').val());
	});

@stop


@section('includejs')
	<script type="text/javascript" src="{{url('assets/global/plugins/select2/select2.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js')}}"></script>
	<script src="{{url('assets/admin/layout/scripts/menusticky.js')}}" type="text/javascript"></script>
	<script src="{{url('assets/admin/pages/scripts/table-advanced.js')}}"></script>
@stop
