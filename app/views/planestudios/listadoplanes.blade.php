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

$orgId 		= (isset($OrgID)) ? $OrgID : 0;
?>
@section('content')
	<!-- COMIENZO CONTENIDO -->
	<div class="page-content-wrapper">
		<div class="page-content" ng-app="app">
			<!-- COMIENZO DEL HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- COMIENZO TITULO & BREADCRUMB-->
					<h3 class="page-title">
					Plan de Estudios <small>listado de planes</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('planestudios/listado')}}">Plan de estudios</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('planestudios/listado')}}">Listado</a>
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
					    @if (Session::get('message_type') == PlanestudiosController::OPERACION_EXITOSA)

					        <div class="note note-success">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == PlanestudiosController::OPERACION_FALLIDA)

					        <div class="note note-danger">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == PlanestudiosController::OPERACION_CANCELADA)

					        <div class="note note-warning">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == PlanestudiosController::OPERACION_INFO)

					        <div class="note note-info">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@endif
					@endif
					<!-- COMIENZO DE LA TABLA-->
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-files-o"></i>Listado de Planes
							</div>
							<div class="actions">
								<a href="{{url('planestudios/crear')}}" {{ $disabled }} class="btn default blue-stripe">
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Nuevo </span>
								</a>
								<a href="{{url('planestudios/listado')}}" class="btn default yellow-stripe">
								<i class="fa fa-reorder"></i>
								<span class="hidden-480">
								Listado de materias </span>
								</a>

							</div>

						</div>
						<div class="portlet-body">
							<div class="form-body">
								<form class="form-horizontal form-row-seperated" id="FrmPlanestudios" name="">
									<div class="form-group">
										<label  class="col-md-2 col-sm-2 control-label">Organización:</label>
										<div class="col-md-6 col-sm-10">
											{{ Form::select('organizacion', $organizaciones, Input::old('organizacion'), array('class'=>'table-group-action-input form-control','id'=>'organizacion','ng-model'=>'orgItem', 'ng-change'=>'org_selec(this)')); }}
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-2 col-sm-2 control-label" for="tipocarrera">Carrera:</label>
										<div class="col-md-6 col-sm-10">
											@if (isset($carreras))
												<select class="table-group-action-input form-control" name="carrera" id="carrera">
													<option value="0" disabled selected>Seleccionar</option><?php
													foreach ($carreras as $carrera) { ?>
														<option value="{{$carrera->id}}" <?php if($carrera->id == $carrID) { echo "selected=selected";}?>>
															{{$carrera->carrera}}
														</option>
													<?php } ?>
												</select>
											@else
												<select class="table-group-action-input form-control" name="carrera" id="carrera">
													<!--option selected value="0">Seleccione</option-->
												</select>
											@endif
										</div>
									</div>

									<div class="portlet-body">
									 	<div class="box-body table-responsive no-padding">
											<table class="table table-striped table-bordered table-hover" id="table_planes">
												<thead>
												<tr>
													<th>
														<center><i class="fa fa-list-ol"></i> Codigo</center>
													</th>
													<th>
														<center><i class="fa fa-files-o"></i> Ciclo Lectivo</center>
													</th>
													<th class="hidden-xs">
														<center><i class="fa fa-calendar"></i> Titulo Plan</center>
													</th>
													<th>
														<center><i class="fa fa-clock-o"></i> Fecha Inicio</center>
													</th>									
													<th>
														<center><i class="fa fa-clock-o"></i> Fecha Fin</center>
													</th>
													<th>
														<center><i class="fa fa-rocket"></i> Acciones</center>
													</th>			

												</tr>
												</thead>
												<tbody>
													@if (isset($planestudios))
														@foreach ($planestudios as $planestudio)
															<tr>
																<td>
																	<center>{{ $planestudio->codigoplan }}</center>
																</td>
																<td>
																	<center>{{ $planestudio->ciclolectivo->descripcion }}</center>
																</td>
																<td>
																	<center>{{ $planestudio->tituloplan }}</center>
																</td>
																<td>
																	<center>{{ $planestudio->fechainicio }} </center>
																</td>
																<td>
																	<center><?php 
																	if ($planestudio->fechafin) {
																		echo $planestudio->fechafin;
																	} else {
																		echo "-";
																	} ?></center>
																</td>												
																<td>
																	<center>
																		<a title="Modificar" href="{{url('planestudios/editar/' . $planestudio->id)}}" class="btn default btn-xs purple">
																			<i class="fa fa-edit"></i>
																		</a>
																		<a href="#" data-id="{{$planestudio->id}}"  class="btn default btn-xs red btnEliminarMaterias">
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
								</form>
							</div>
							<br>

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
	TableAdvanced.init();

	$('#organizacion, #carrera').select2({
		placeholder: "Seleccione",
		allowClear: true
	});

	$('#organizacion').on('change', function(){
		var organizacion_id = $('#organizacion').val();
		
		$.ajax({
		  url: "{{url('organizacions/obtenercarreras')}}",
		  data:{'organizacion_id': organizacion_id},
		  type: 'POST'
		}).done(function(carreras) {
			console.log(carreras);
			if (carreras == <?php echo OrganizacionsController::NO_TIENE_CARRERAS ?>) {
				$('#divMensaje').html('<p class="form-control-static"><h4>' + 'La Organización no tiene Carreras Asignadas' + '</h4></p>');
	    	    $('#MensajeCantidad').modal('show');
				return;
		    }

			$('#carrera').append(
		        $('<option></option>').val(0).html('Seleccionar')
		    );

			$.each(carreras, function(key, value) {
				$('#carrera').append(
			        $('<option></option>').val(value.id).html(value.carrera)
			    );
			});
		}).error(function(data){
			console.log(data);
		});
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
	

@stop
