@extends('layouts.master')

@section('customstyle')
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/select2/select2.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css')}}"/>
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
					Materias <small>listado de materias</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('materias/listado')}}">Materias</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('materias/listado')}}">Listado</a>
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
					    @if (Session::get('message_type') == MateriasController::OPERACION_EXITOSA)

					        <div class="note note-success">
								<p>{{ Session::get('message') }}</p>
							</div>

						@elseif (Session::get('message_type') == MateriasController::OPERACION_FALLIDA)

					        <div class="note note-danger">
								<p>{{ Session::get('message') }}</p>
							</div>

						@elseif (Session::get('message_type') == MateriasController::OPERACION_CANCELADA)

					        <div class="note note-warning">
								<p>{{ Session::get('message') }}</p>
							</div>

						@elseif (Session::get('message_type') == MateriasController::OPERACION_INFO)

					        <div class="note note-info">
								<p>{{ Session::get('message') }}</p>
							</div>

						@endif
					@endif
					<!-- COMIENZO DE LA TABLA-->
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-files-o"></i>Listado de Materias
							</div>
							<div class="actions">
								<a href="{{url('materias/crear')}}" {{ $disabled }} class="btn default blue-stripe">
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Nueva </span>
								</a>
								<a href="{{url('materias/listado')}}" class="btn default yellow-stripe">
								<i class="fa fa-refresh"></i>
								<span class="hidden-480">
								Actualizar </span>
								</a>

							</div>

						</div>
						<div class="portlet-body">
							<div class="form-body">
								<form method="POST" action="{{url('materias/obtenermaterias')}}" class="form-horizontal form-row-seperated" id="FrmPlanestudios" name="">
									<div class="form-group">
										<label  class="col-md-2 col-sm-2 control-label">Organización:</label>
										<div class="col-md-6 col-sm-10">
											{{ Form::select('organizacion', $organizaciones, Input::old('organizacion'), array('class'=>'table-group-action-input form-control','id'=>'organizacion')) }}
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-2 col-sm-2 control-label" for="tipocarrera">Carreras:</label>
										<div class="col-md-6 col-sm-10">
											@if (isset($materias))
												{{ Form::select('carrera', CarrerasController::ObtenerCarrerasParaSelect($orgId), $carrID, array('class'=>'table-group-action-input form-control','id'=>'carrera')) }}
											@else
												<select class="table-group-action-input form-control" name="carrera" id="carrera">
													<option value="0">Seleccione</option>
												</select>
											@endif
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 col-sm-2 control-label" for="plan">Plan Estudio:</label>
										<div class="col-md-4 col-sm-4">
											@if (isset($planes))
												{{ Form::select('plan', PlanestudiosController::ObtenerPlanesParaSelect($carrID), $planID, array('class'=>'table-group-action-input form-control','id'=>'codigoplan')) }}
											@else
												<select class="table-group-action-input form-control" name="plan" id="plan">
													<option value="0">Seleccione</option>
												</select>
											@endif
										</div>

										<label class="col-md-2 col-sm-2 control-label">Ciclo Lectivo:</label>
										<div class="col-md-2 col-sm-2">
											<select class="table-group-action-input form-control" name="cboCiclos" id="cboCiclos">
												<option value="0">Seleccione</option>
											</select>
										    @if ($errors->has('cboCiclos'))
											    <span class="help-block">{{ $errors->first('cboCiclos') }}</span>
										    @endif
										</div>

										<div class="col-md-2 col-sm-2">
											<button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> Buscar</button>
										</div>				
									</div>
								</form>
							</div>
							<br>

							<table class="table table-striped table-bordered table-hover" id="table_materias">
								<thead>
								<tr>
									<th>
										<center><i class="fa fa-list-ol"></i> Cod. Materia</center>
									</th>
									<th>
										<center><i class="fa fa-files-o"></i> Materia</center>
									</th>
									<th>
										<center><i class="fa fa-files-o"></i> Regimen</center>
									</th>
									<th class="hidden-xs">
										<center><i class="fa fa-calendar"></i> Periodo</center>
									</th>
									<th>
										<center><i class="fa fa-clock-o"></i> Hs. Semanales</center>
									</th>									
									<th>
										<center><i class="fa fa-clock-o"></i> Hs. Cátedras</center>
									</th>
									<th>
										<center><i class="fa fa-clock-o"></i> Hs. Reloj</center>
									</th>
									<th>
										<center><i class="fa fa-calendar"></i> Año de Cursado</center>
									</th>	
									<th>
										<center><i class="fa fa-rocket"></i> Acciones</center>
									</th>			

								</tr>
								</thead>
								<tbody>
									@if (isset($materias))
										@foreach ($materias as $materia)
											<tr>
												<td><center>
													{{ $materia->id }} </center>
												</td>
												<td><center>
													{{ $materia->nombremateria }} </center>
												</td>
												<td><center>
													@if($materia->promocional == 1)
														Promocional
													@else
														Regular
													@endif
													</center>
												</td>
												<td><center>
													{{ $materia->periodo }}</center>
												</td>
												<td><center>
													{{ $materia->hssemanales }}</center>
												</td>
												<td><center>
													{{ $materia->hscatedra }}</center>
												</td>
												<td><center>
													{{ $materia->hsreloj }}</center>
												</td>
												<td><center>
													{{ $materia->aniocursado }}</center>
												</td>													
												<td>
													<center>
														<a title="Modificar" href="{{url('materias/editar/' . $materia->id)}}" class="btn default btn-xs purple">
															<i class="fa fa-edit"></i>
														</a>
														<a href="#" data-id="{{$materia->id}}"  class="btn default btn-xs red btnEliminarMaterias">
															<i title="Eliminar" class="fa fa-trash-o"></i>
														</a>
													</center>
												</td>
											</tr>
										@endforeach
									@endif
								</tbody>
							</table>

						</div>
					</div>
					<!-- FIN DE LA TABLA-->
				</div>
			</div>
			<!-- FIN DEL CONTENIDO -->
		</div>
	</div>
	<!-- FIN -->

	<!-- MODAL ELIMINACION DE MATERIAS-->
	<div class="modal fade" id="modalEliminaMateria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		{{ Form::open(array('url' => 'materias/borrar')) }}
			<input id="idMateriaHidden" name='idMateriaHidden' type="hidden" value="">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Eliminar Materia</h4>
					</div>
					<div class="modal-body">
						¿Estás seguro de querer borrar esta materia?
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn red"><i class="fa fa-trash-o"></i> Eliminar</button>
						<button type="button" class="btn default" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> Cancelar</button>
					</div>
				</div>
			</div>
		{{Form::close()}}
	</div>
	<!-- FIN DEL MODAL FORM-->



@stop


@section('customjs')
	<!--TableAdvanced.init();-->

	$(document).ready(function() {
	    $('#table_materias').DataTable();
	} );

	$('#organizacion, #carrera, #plan').select2({
		placeholder: "Seleccione",
		allowClear: true
	});

	$('#organizacion').on('change', function(){
		var orgid = $('#organizacion').val();
		var combocarga = $('#carrera');
		var comboplan = $('#plan');
		$.ajax({
			type: "POST",
			url: "{{url('carreras/buscarjson/')}}",
			data: { organizacionid: orgid }	
			}).done(function(data) {
				console.log(data)
				combocarga.find('option').remove().end()
				combocarga.append('<option value="0" disabled selected>Seleccionar</option>');
				combocarga.select2("destroy")
				
				comboplan.find('option').remove().end()
				comboplan.append('<option value="0" disabled selected>Seleccionar</option>');
				comboplan.select2("destroy")


				for (i = 0; i < data.length; i++) {
					combocarga.append('<option value="'+data[i]['id']+'">'+data[i]['carrera']+'</option>')
				}
				combocarga.select2()
				comboplan.select2()
			});
	});
	

	$('#carrera').change(function() {
		var carrid = $('#carrera').val();
		var combocarga = $('#plan');
		$.ajax({
			type: "POST",
			url: "{{url('planestudios/buscarjson/')}}",
			data: { carreraid: carrid }	
		}).done(function(data) {
			console.log(data)
			combocarga.find('option').remove().end()
			combocarga.append('<option value="0" disabled selected>Seleccionar</option>');
			combocarga.select2("destroy")
			for (i = 0; i < data.length; i++) {
				combocarga.append('<option value="'+data[i]['id']+'">'+data[i]['codigoplan']+'</option>')
			}
			combocarga.select2()

		});
	});

	$('#plan').change(function() {
		$('#cboCiclos').children().remove().end();
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

			$.ajax({
			  url: '{{url('planestudios/obtenerciclo')}}',
			  data:{'plan': $('#plan').val()},
			  type: 'POST'
			}).done(function(plan) {
				console.log(plan);

				$('#cboCiclos').val(plan);

			}).error(function(data) {
				console.log(data);
			});

		}).error(function(data) {
			console.log(data);
		});
	});

	$('.btnEliminarMaterias').live('click', function(){
		$('#idMateriaHidden').val($(this).data('id'));
		$('#modalEliminaMateria').modal('show');
	});

@stop


@section('includejs')
	<script type="text/javascript" src="{{url('assets/global/plugins/select2/select2.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js')}}"></script>
	<!--<script src="{{url('assets/admin/pages/scripts/table-advanced.js')}}"></script>-->
@stop
