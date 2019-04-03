@extends('layouts.master')

@section('customstyle')
<!-- BEGIN PAGE LEVEL STYLES -->
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
<!-- END PAGE LEVEL STYLES -->
@stop
<?php
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
					Acceso <small>Control de Acceso</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('controlacceso/listado')}}">Listado</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">Nueva</a>
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
								<p> {{ Session::get('message') }} </p>
							</div>
						@elseif (Session::get('message_type') == ControlAccesoController::OPERACION_FALLIDA)

							<div class="note note-danger">
								<p> {{ Session::get('message') }} </p>
							</div>

						@endif	
					@endif
					<!-- COMIENZO DE LA TABLA-->
					{{ Form::open(array('url'=>'controlacceso/guardar', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmCajaChica', 'name'=>'FrmCajaChica'))}}
					
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-files-o"></i> Control de Acceso
							</div>
							<div class="actions">
								<button type='submit' class="btn default green-stripe" {{ $disabled }}>
								<i class="fa fa-save"></i>
								<span class="hidden-480">
								Guardar </span>
								</button>
								<a href="listado" class="btn default yellow-stripe">
								<i class="fa fa-reorder"></i>
								<span class="hidden-480">
								Listado </span>
								</a>
								<!--a target="_blank" href="#" id="imprimir" class="btn default yellow-stripe" disabled>
								<i class="glyphicon glyphicon-list-alt"></i>
								<span class="hidden-480">
								Recibo </span>
								</a-->
							</div>

						</div>
						<div class="portlet-body form">
								<div class="form-body">

									<div class="form-group <?php if ($errors->has('arrOrganizaciones')) echo 'has-error' ?>">
										<label  class="col-md-2 col-sm-2 control-label">Organización:</label>
										<div class="col-md-6 col-sm-10">
											{{ Form::select('organizacion', $arrOrganizaciones, Input::old('organizacion'), array('class'=>'table-group-action-input form-control','id'=>'organizacion')) }}
										</div>
				  						<input id="txt_organizacion_id" name='txt_organizacion_id' type="hidden" value="{{ $organizacionid->id }}">
									</div>

									<div class="form-group <?php if ($errors->has('txt_codigo')) echo 'has-error' ?>">
										<label class="col-md-2 col-sm-2 control-label" for="txt_codigo">Buscar por Codigo:</label>
										<div class="col-md-4 col-sm-4 <?php if ($errors->has('txt_codigo')) echo 'has-error' ?>">
											<input class="form-control" name="txt_codigo" id="txt_codigo" type="text" placeholder="Codigo" value="{{ Input::old('txt_codigo') }}">
											@if ($errors->has('txt_codigo'))
											    <span class="help-block">{{ $errors->first('txt_codigo') }}</span>
										    @endif
										</div>
										<div class="col-md-1 col-sm-1">
											<a class="btn blue-madison" id='BtnBuscar'>
												<i class="fa fa-search"></i>
											</a>
										</div>

										<div class="col-md-2 col-sm-2">
											<a class="btn blue-madison" id='BtnBuscarLista'>
												<i class="fa fa-search"></i> Buscar en Lista
											</a>
										</div>
									</div>

									<div class="form-group @if ($errors->has('txt_personal')) {{'has-error'}} @endif">
										<label class="col-md-2 control-label" for="txt_personal">Personal:</label>
										<div class="col-md-4 <?php if ($errors->has('txt_personal')) echo 'has-error' ?>">
											<input type="text" class="form-control" id="txt_personal" name="txt_personal" value="{{ Input::old('txt_personal') }}" placeholder="Personal">
											@if ($errors->has('txt_personal'))
											    <span class="help-block">{{ $errors->first('txt_personal') }}</span>
										    @endif
										</div>
									</div>

									<div class="form-group @if ($errors->has('txt_usuario')) {{'has-error'}} @endif">
										<label class="col-md-2 control-label" for="txt_usuario">Usuario:</label>
										<div class="col-md-4 <?php if ($errors->has('txt_usuario')) echo 'has-error' ?>">
											<input type="text" class="form-control" id="txt_usuario" name="txt_usuario" value="{{ Input::old('txt_usuario') }}" placeholder="Usuario">
											@if ($errors->has('txt_usuario'))
											    <span class="help-block">{{ $errors->first('txt_usuario') }}</span>
										    @endif
										</div>
									</div>

									<div class="form-group @if ($errors->has('txt_entrada')) {{'has-error'}} @endif">
										<label class="col-md-2 control-label" for="txt_entrada">Entrada:</label>
										<div class="col-md-2 <?php if ($errors->has('txt_entrada')) echo 'has-error' ?>">
											<input type="date" class="form-control" id="txt_entrada" name="txt_entrada" value="{{ Input::old('txt_entrada') }}">
											@if ($errors->has('txt_entrada'))
											    <span class="help-block">{{ $errors->first('txt_entrada') }}</span>
										    @endif
										</div>
									
										<label class="col-md-2 control-label" for="cbo_hora">Hora:</label>
										<div class="col-md-1">
											<select class="table-group-action-input form-control" name="cbo_hora" id="cbo_hora">
												<option value="00">00</option>
												<?php
												for ($i=1; $i < 25; $i++) { 
													if ($i < 10) {
													 	$i = '0'.$i;
													 } ?>
													<option value="{{ $i }}">{{ $i }}</option>
												<?php } ?>
											</select>
											@if ($errors->has('cbo_hora'))
											    <span class="help-block">{{ $errors->first('cbo_hora') }}</span>
										    @endif
										</div>
										<div class="col-md-1">
											<select class="table-group-action-input form-control" name="cbo_minuto" id="cbo_minuto">
												<option value="00">00</option>
												<?php
												for ($i=01; $i < 60; $i++) { 
													if ($i < 10) {
													 	$i = '0'.$i;
													 } ?>
													<option value="{{ $i }}">{{ $i }}</option>
												<?php } ?>
											</select>
											@if ($errors->has('cbo_minuto'))
											    <span class="help-block">{{ $errors->first('cbo_minuto') }}</span>
										    @endif
										</div>
									</div>

									<div class="form-group @if ($errors->has('txt_salida')) {{'has-error'}} @endif">
										<label class="col-md-2 control-label" for="txt_salida">Salida:</label>
										<div class="col-md-2 <?php if ($errors->has('txt_salida')) echo 'has-error' ?>">
											<input type="date" class="form-control" id="txt_salida" name="txt_salida" value="{{ Input::old('txt_salida') }}">
											@if ($errors->has('txt_salida'))
											    <span class="help-block">{{ $errors->first('txt_salida') }}</span>
										    @endif
										</div>
									
										<label class="col-md-2 control-label" for="cbo_horas">Hora:</label>
										<div class="col-md-1">
											<select class="table-group-action-input form-control" name="cbo_horas" id="cbo_horas">
												<option value="00">00</option>
												<?php
												for ($i=1; $i < 25; $i++) { 
													if ($i < 10) {
													 	$i = '0'.$i;
													 } ?>
													<option value="{{ $i }}">{{ $i }}</option>
												<?php } ?>
											</select>
											@if ($errors->has('cbo_horas'))
											    <span class="help-block">{{ $errors->first('cbo_horas') }}</span>
										    @endif
										</div>
										<div class="col-md-1">
											<select class="table-group-action-input form-control" name="cbo_minutos" id="cbo_minutos">
												<option value="00">00</option>
												<?php
												for ($i=01; $i < 60; $i++) { 
													if ($i < 10) {
													 	$i = '0'.$i;
													 } ?>
													<option value="{{ $i }}">{{ $i }}</option>
												<?php } ?>
											</select>
											@if ($errors->has('cbo_minutos'))
											    <span class="help-block">{{ $errors->first('cbo_minutos') }}</span>
										    @endif
										</div>
									</div>
								</div>
									<br><br>

							<!-- MODAL-->
							<div id="modalBuscarPersona" class="modal fade" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title"><strong>Lista de Personas</strong></h4>
										</div>
										  <div class="modal-body form-body">
											<div class="scroller" style="height:500px; width:700px;" data-always-visible="1" data-rail-visible="1">
												<div class="portlet-body">
													<table class="table table-striped table-bordered table-hover" id="table_organizaciones">
													<thead>
													<tr>
														<th>
															 <center><i class="fa fa-list-ol"></i> Código</center>
														</th>
														<th>
															 <center><i class="fa fa-user"></i> Apellido y Nombre</center>
														</th>
														<th>
															 <center><i class="fa fa-users"></i> Usuario</center>
														</th>
														<th>
															 <center><i class="fa fa-calendar"></i> Perfil</center>
														</th>
													</tr>
													</thead>
													<tbody>
													@foreach ($resultados as $resultado)
														<tr>
															<td class="verinfo" data-id="{{$resultado['id']}}" data-personal="{{$resultado['apellido_nombre']}}" data-usuario="{{$resultado['usuario']}}" style="cursor:pointer"><center>
																{{$resultado['id']}}</center>
															</td>
															<td class="verinfo" data-id="{{$resultado['id']}}" data-personal="{{$resultado['apellido_nombre']}}" data-usuario="{{$resultado['usuario']}}" style="cursor:pointer">
																{{$resultado['apellido_nombre']}}
															</td>
															<td class="verinfo" data-id="{{$resultado['id']}}" data-personal="{{$resultado['apellido_nombre']}}" data-usuario="{{$resultado['usuario']}}" style="cursor:pointer"><center>
																{{$resultado['usuario']}}</center>
															</td>
															<td class="verinfo" data-id="{{$resultado['id']}}" data-personal="{{$resultado['apellido_nombre']}}" data-usuario="{{$resultado['usuario']}}" style="cursor:pointer">
																{{$resultado['perfil']}}
															</td>
														</tr>
													@endforeach
													</tbody>
													</table>
												</div>
												
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn default" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> Cerrar</button>
										</div>

									</div>
								</div>
							</div>
							<!-- FIN MODAL-->

										<!-- MODAL-->
										<div class="modal fade" id="MensajeCantidad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
															<h4 class="modal-title">Atención!</h4>
														</div>
														<div class="modal-body">
															DEBE INGRESAR EL CODIGO A BUSCAR!!
														</div>
														<div class="modal-footer">
															<button type="button" class="btn default" data-dismiss="modal">Cerrar</button>
														</div>
													</div>
												</div>
										</div>
										<!-- FIN MODAL-->

									</div>

								</div>																	
						</div> <!-- FIN PORTLET-BODY -->
					</div>
					{{ Form::close() }}
				</div>
			</div>
			<!-- FIN DEL CONTENIDO -->
		</div>
	</div>
	<!-- FIN -->
@stop


@section('customjs')
	$(document).ready(function() {
	    $('#table_organizaciones').DataTable();
	});

	$('#imprimir').on('click', function(e){
		e.preventDefault();
		window.open("{{url('cajachica/pdfrecibo')}}");
	});

	//Emular Tab al presionar Enter
	$('input').keydown( function(e) {
	        var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
	        if(key == 13) {
	            e.preventDefault();
	            var inputs = $(this).closest('form').find(':input:visible');
	            inputs.eq( inputs.index(this)+ 1 ).focus();
	        }
	 });
	 
	$('#organizacion').select2({
		placeholder: "Seleccione",
		allowClear: true
	});

	$('#organizacion').on('change', function(){
		var orgid = $('#organizacion').val();
		$('#txt_organizacion_id').val($('#organizacion').val());
	});

    $('#BtnBuscar').change(function() {
    	var codigo = $('#txt_codigo').val();

    	if (codigo == '') {
	    	$('#MensajeCantidad').modal('show');
	    } else {
	    	Buscar_codigo(codigo);
	    }
    });

    $('#txt_codigo').change(function() {
    	var codigo = $('#txt_codigo').val();

    	if (codigo == '') {
	    	$('#MensajeCantidad').modal('show');
	    } else {
	    	Buscar_codigo(codigo);
	    }
    });

    function Buscar_codigo(codigo) {
	    //alert(codigo);
	    $.ajax({
			type: "POST",
			url: "{{url('controlacceso/buscarcodigo')}}",
			data: { codigo: codigo },
			type: "POST"
			}).done(function(personal) {
				console.log(personal);

				$.each(personal, function(key, value) {
					$('#txt_personal').val(value.personal);
					$('#txt_usuario').val(value.usuario);
				});

			}).error(function(data) {
				console.log(data);
			});
	}

	$('#BtnBuscarLista').live('click', function(){
		$('#modalBuscarPersona').modal('show');
	});

	$('.verinfo').live('click', function(){
		var id = $(this).data('id');
		var personal = $(this).data('personal');
		var usuario = $(this).data('usuario');

		$('#txt_codigo').val(id);
		$('#txt_personal').val(personal);
		$('#txt_usuario').val(usuario);

		$('#modalBuscarPersona').modal('hide');
	});

	
@stop

@section('includejs') 
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{url('assets/global/plugins/select2/select2.min.js')}}"></script>
<script src="{{url('assets/admin/layout/scripts/menusticky.js')}}" type="text/javascript"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js')}}"></script>
	<script src="{{url('assets/admin/pages/scripts/table-advanced.js')}}"></script>
<!-- END PAGE LEVEL PLUGINS -->
@stop
