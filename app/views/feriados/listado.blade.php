@extends('layouts.master')

@section('customstyle')
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/select2/select2.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css')}}"/>
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
					Feriados <small>Gestión de Feriados</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<!--li class="btn-group">
							<button type="button" class="btn blue dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
							<span>Acciones</span><i class="fa fa-angle-down"></i>
							</button>
							<ul class="dropdown-menu pull-right" role="menu">
								<li>
									<a href="#">Exportar a PDF</a>
								</li>
								<li>
									<a href="#">Exportar a CVS</a>
								</li>
								<li>
									<a href="#">Exportar a Excel</a>
								</li>
								<li class="divider">
								</li>
								<li>
									<a href="#">Salir</a>
								</li>
							</ul>
						</li -->
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('feriados/listado')}}">Feriados</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">Listado</a>
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
					    @if (Session::get('message_type') == FeriadosController::OPERACION_EXITOSA)

					        <div class="note note-success">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == FeriadosController::OPERACION_FALLIDA)

					        <div class="note note-danger">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == FeriadosController::OPERACION_CANCELADA)

					        <div class="note note-warning">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == FeriadosController::OPERACION_INFO)

					        <div class="note note-info">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@endif
					@endif
					<!-- COMIENZO DE LA TABLA-->
					{{ Form::open(array('url'=>'feriados/obtenerferiados', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmListadoFeriados', 'name'=>'FrmListadoFeriados'))}}
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-calendar"></i>Listado de Feriados
							</div>
							<div class="actions">
								<a {{ $disabled }} href="{{url('feriados/crear')}}" class="btn default blue-stripe">
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Nuevo </span>
								</a>
								<a href="{{url('feriados/listado')}}" class="btn default yellow-stripe">
								<i class="fa fa-refresh"></i>
								<span class="hidden-480">
								Actualizar </span>
								</a>

							</div>

						</div>
						<div class="portlet-body form">
							<div class="form-body">
								<div class="form-group">
									<label  class="col-md-2 col-sm-2 control-label">Organización:</label>
									<div class="col-md-6 col-sm-10">
										{{ Form::select('organizacion', $arrOrganizaciones, Input::old('organizacion'), array('class'=>'table-group-action-input form-control','id'=>'organizacion')); }}
									</div>
								</div>

								<div class="form-group <?php if ($errors->has('cboCiclos')) echo 'has-error' ?>">
									<label class="col-md-2 col-sm-2 control-label">Ciclo Lectivo:</label>
									<div class="col-md-2 col-sm-2">
										<select class="table-group-action-input form-control" name="cboCiclos" id="cboCiclos">
											@if (isset($ciclos))
												@foreach ($ciclos as $ciclo)
													<option value="{{$ciclo->id}}" <?php if ($ciclo->id == $ciclo_id) echo "selected"; ?>>{{$ciclo->descripcion}}</option>
												@endforeach
											@endif
										</select>
									    @if ($errors->has('cboCiclos'))
										    <span class="help-block">{{ $errors->first('cboCiclos') }}</span>
									    @endif
									</div>

									<div class="col-md-2 col-sm-2">
										<button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> Buscar</button>
									</div>
								</div>
								<br>
								<br>
									
								<div class="portlet-body">
									<div class="box-body table-responsive no-padding">
										<table class="table table-striped table-bordered table-hover" id="table_feriados">
											<thead>
											<tr>
												<th>
													<center><i class="fa fa-bank"></i> Ciclo Lectivo</center>
												</th>
												<th class="hidden-xs">
													<center><i class="fa fa-calendar"></i> Fecha Feriado</center>
												</th>
												<th>
													<center><i class="fa fa-tag"></i> Descripción</center>
												</th>
												<th>
													<center><i class="fa fa-rocket"></i> Acción</center>
												</th>
											</tr>
											</thead>
											<tbody>
											@if (isset($feriados))
												@foreach ($feriados as $feriado)
													<tr>
														<td>
															<center>
																{{$feriado['ciclo']}}
															</center>
														</td>
														<td>
															<center>
																{{$feriado['fecha']}}
															</center>
														</td>
														<td>
															<center>
																{{$feriado['descripcion']}}
															</center>
														</td>
														<td>
															<center>
															<a title="Modificar" href="editar/{{$feriado['id']}}" class="btn default btn-xs purple">
															<i class="fa fa-edit"></i></a>
															<a title="Eliminar" href="#modaleliminaciclo" {{ $disabled }} data-id="{{$feriado['id']}}" class="btn default btn-xs red btnEliminarCiclo">
															<i class="fa fa-trash-o"></i></a>
															</center>
														</td>
													</tr>
												@endforeach
											@endif
											</tbody>
										</table>
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
		</div>
	</div>
	<!-- FIN -->

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
	<div class="modal fade" id="modalEliminaCiclo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		{{ Form::open(array('url' => 'feriados/borrar')) }}
			<input id="idCicloHidden" name='idCicloHidden' type="hidden" value="">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Eliminar Feriado</h4>
					</div>
					<div class="modal-body">
						¿Está seguro de querer borrar este feriado?
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
	<!-- FIN DEL MODAL FORM-->

@stop


@section('customjs')
	TableAdvanced.init();

	$('#organizacion').select2({
		placeholder: "Seleccione",
		allowClear: true
	});

	/*$('#cboCiclos').change(function() {
		limpiar_tabla();
		//var carrid = $('#carrera').val();

		if ($('#organizacion').val() == 0) return;
		if ($('#cboCiclos').val() == 0) return;

		$.ajax({
		  url: '{{url('feriados/obtenerferiados')}}',
		  data:{'organizacion_id': $('#organizacion').val(), 'ciclo_id': $('#cboCiclos').val()},
		  type: 'POST'
		}).done(function(feriados) {
			console.log(feriados);

			if (feriados == 5) {
				//alert('La Organización no tiene Feriados Asignados');
				$('#divMensaje').html('<p class="form-control-static"><h4>' + 'La Organización no tiene Feriados Asignados' + '</h4></p>');
	    	    $('#MensajeCantidad').modal('show');
				return;
		    }

			$.each(feriados, function(key, value) {
				$('#table_feriados > tbody').append('<tr><td><center>'+value.ciclo+'</center></td><td><center>'+value.fecha+'</center></td><td><center>'+value.descripcion+'</center></td><td><center><a title="Modificar" href="{{url('feriados/editar')}}/'+value.id+'" class="btn default btn-xs purple"><i class="fa fa-edit"></i></a><a title="Eliminar" href="#modaleliminaciclo" data-id="'+ value.id +'" class="btn default btn-xs red btnEliminarCiclo"><i class="fa fa-trash-o"></i></a></center></td></tr>');
			});

		}).error(function(data) {
			console.log(data);
		});
	});*/

	$('#organizacion').change(function() {
		limpiar_tabla();
		//var carrid = $('#carrera').val();
		$('#ciclos').children().remove().end();

		if ($('#organizacion').val() == 0) return;

		$.ajax({
		  url: '{{url('ciclolectivo/obtenercicloslectivos')}}',
		  data:{'organizacion_id': $('#organizacion').val()},
		  type: 'POST'
		}).done(function(ciclos) {
			console.log(ciclos);
			if (ciclos == <?php echo CicloLectivoController::NO_EXISTE_CICLO ?>) {
				//alert('La Organización no tiene Ciclos Lectivos Asignados');
				$('#divMensaje').html('<p class="form-control-static"><h4>' + 'La Organización no tiene Ciclos Lectivos Asignados' + '</h4></p>');
	    	    $('#MensajeCantidad').modal('show');
				return;
		    }

			$('#cboCiclos').append(
		        $('<option></option>').val(0).html('Seleccionar')
		    );

			$.each(ciclos, function(key, value) {
				$('#cboCiclos').append(
			        $('<option></option>').val(value.id).html(value.descripcion)
			    );
			});
		}).error(function(data) {
			console.log(data);
		});
	});

    function limpiar_tabla() {
	    var n = 0;
		$('#table_feriados tr').each(function() {
		   if (n > 1) $(this).remove();
		   n++;
		});
    }

	//AL PRESIONAR LOS BOTONES ELIMINAR PASO EL DATA ID DE LA ORGANIZACION A ELIMINAR
	$('.btnEliminarCiclo').live('click', function(){
		//PASO EL DATA ID AL CAMPO OCULTO
		$('#idCicloHidden').val($(this).data('id'));
		//MUESTRO EL MODAL DE ADVERTENCIA
		$('#modalEliminaCiclo').modal('show');
	});

@stop


@section('includejs')
	<script type="text/javascript" src="{{url('assets/global/plugins/select2/select2.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js')}}"></script>

	<script src="{{url('assets/admin/pages/scripts/table-advanced.js')}}"></script>
	<script src="{{url('assets/admin/pages/scripts/getFechaImpresion.js')}}"></script>
@stop
