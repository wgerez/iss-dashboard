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

	$idOrganizacionOld = (isset($idOrg)) ? $idOrg : null;
	$idTipoCarreraOld  = (isset($idTCarrera)) ? $idTCarrera : null;  
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
					Carreras <small>gestión de carreras</small>
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
							<a href="{{url('carreras/listado')}}">Carreras</a>
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
					    @if (Session::get('message_type') == CarrerasController::OPERACION_EXITOSA)

					        <div class="note note-success">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == CarrerasController::OPERACION_FALLIDA)

					        <div class="note note-danger">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == CarrerasController::OPERACION_CANCELADA)

					        <div class="note note-warning">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == CarrerasController::OPERACION_INFO)

					        <div class="note note-info">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@endif
					@endif
					<!-- COMIENZO DE LA TABLA-->
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-files-o"></i>Listado de Carreras
							</div>
							<div class="actions">
								<a {{$disabled}} href="{{url('carreras/crear')}}" class="btn default blue-stripe">
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Nuevo </span>
								</a>
								<a href="{{url('carreras/listado')}}" class="btn default yellow-stripe">
								<i class="fa fa-refresh"></i>
								<span class="hidden-480">
								Actualizar </span>
								</a>

							</div>

						</div>
						<div class="portlet-body form">
							<div class="form-body">
								{{ Form::open(array('url'=>'carreras/buscar', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmCarrera', 'name'=>'FrmCarrera'))}}
								<div class="form-group">
									<label  class="col-md-2 col-sm-2 control-label">Organización:</label>
									<div class="col-md-6 col-sm-10">
										{{ Form::select('organizacion', $arrOrganizaciones, $idOrganizacionOld, array('class'=>'table-group-action-input form-control','id'=>'organizacion')); }}
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 col-sm-2 control-label" for="tipocarrera">Tipo de Carrera:</label>
									<div class="col-md-4 col-sm-4">
										{{ Form::select('tipocarrera', $tiposCarreras, $idTipoCarreraOld, array('class'=>'table-group-action-input form-control','id'=>'tipocarrera')); }}
										<!--<select name="filtro" id="filtro" class="table-group-action-input form-control">
											<option value="2">Cursos</option>
										</select>!-->
									</div>
									<!--
									<div class="col-md-4 col-sm-4">
										<select name="filtro2" id="filtro2" class="table-group-action-input form-control">
											<option value="1">Opcion 1</option>
											<option value="2">Opcion 2</option>
										</select>
									</div>
									!-->
									<div class="col-md-2 col-sm-2">
										<button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> Buscar</button>
									</div>				
								</div>
								{{ Form::close() }}
							</div>
							<table class="table table-striped table-bordered table-hover" id="table_carreras">
								<thead>
								<tr>
									<th>
										<center><i class="fa fa-list-ol"></i> Cod. Carrera</center>
									</th>
									<th>
										<center><i class="fa fa-files-o"></i> Carrera</center>
									</th>
									<th class="hidden-xs">
										<center><i class="fa fa-calendar"></i> Duración</center>
									</th>
									<th>
										<center><i class="fa fa-info-circle"></i> Modalidad</center>
									</th>									
									<th>
										<center><i class="fa fa-info-circle"></i> Nivel</center>
									</th>
									<th>
										<center><i class="fa fa-check"></i> Activo</center>
									</th>									
									<th>
										<center><i class="fa fa-rocket"></i> Acción</center>
									</th>
								</tr>
								</thead>
								<tbody>
									@if (isset($carreras))
										@foreach ($carreras as $carrera)
											<tr class="@if ($carrera->activa==0) {{ 'danger' }} @endif">
												<td class="verinfo" data-id="{{$carrera->id}}" style="cursor:pointer">
													{{$carrera->id}}
												</td>
												<td class="verinfo" data-id="{{$carrera->id}}" style="cursor:pointer">
													{{$carrera->carrera}}
												</td>											
												<td class="verinfo" data-id="{{$carrera->id}}" style="cursor:pointer">
													{{ $carrera->duracion }} {{ $carrera->tipoduracion['descripcion'] }} 						 
												</td>
												<td class="verinfo" data-id="{{$carrera->id}}" style="cursor:pointer">
													{{ $carrera->modalidad['descripcion'] }} 						 
												</td>											
												<td class="verinfo" data-id="{{$carrera->id}}" style="cursor:pointer">
													{{ $carrera->carreranivel['descripcion'] }}
												</td>
												<td class="verinfo" data-id="{{$carrera->id}}" style="cursor:pointer">
													@if ($carrera->activa==1) {{ 'Activo' }} @else {{ 'Desactivo' }} @endif
												</td>												
												<td>
													<center>
													<a title="Modificar" href="editar/{{ $carrera->id }}" class="btn default btn-xs purple">
													<i class="fa fa-edit"></i></a>
													<a href="#modaleliminacarrera" {{$disabled}} data-id="{{$carrera->id}}" class="btn default btn-xs red btnEliminarCarrera">
													<i title="Eliminar" class="fa fa-trash-o"></i></a>
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

	<!-- MODAL ELIMINACION DE CICLOS-->
	<div class="modal fade" id="modalEliminaCarrera" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		{{ Form::open(array('url' => 'carreras/borrar')) }}
			<input id="idCarreraHidden" name='idCarreraHidden' type="hidden" value="">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Eliminar Carrera</h4>
					</div>
					<div class="modal-body">
						¿Estás seguro de querer borrar esta carrera?
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

    <!-- comentario boludo para mostrar a Walter -->
	<!-- MODAL ELIMINACION DE ORGANIZACIONES-->
	<div class="modal fade" id="modalVerMasInformacion" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title" id="mTituloCarrera"></h4>
					</div>
					<div class="modal-body">
						 <h5 class="text-info"><strong>Régimen</strong></h5>
						 <p id="mRegimen"> - </p>
						 <h5 class="text-info"><strong>Tipo de Carrera</strong></h5>
						 <p id="mTipoCarrera"> - </p>					 
						 <h5 class="text-info"><strong>Duración</strong></h5>
						 <p id="mDuracion"> - </p>
						 <h5 class="text-info"><strong>Carga Horaria</strong></h5>
						 <p id="mCargaHoraria"></p>
						 <h5 class="text-info"><strong>Examen Ingreso</strong></h5>
						 <p id="mExamenIngreso"></p>						 
					</div>
					<div class="modal-footer">
						<button type="button" class="btn default" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> Cerrar</button>
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
	TableAdvanced.init();

	//AL PRESIONAR LOS BOTONES ELIMINAR PASO EL DATA ID DE LA CARRERA A ELIMINAR
	$('.btnEliminarCarrera').live('click', function(){
		//PASO EL DATA ID AL CAMPO OCULTO		
		$('#idCarreraHidden').val($(this).data('id'));
		//MUESTRO EL MODAL DE ADVERTENCIA
		$('#modalEliminaCarrera').modal('show');
	});

	$('#organizacion').select2({
		placeholder: "Seleccione",
		allowClear: true
	});

	$('.verinfo').live('click', function(){
		$.ajax({
		  url: "{{url('carreras/show')}}",
		  data:{'id': $(this).data('id')},
		  type: 'POST'
		}).done(function(carrera) {
			console.log(carrera);


		  	$('#mTituloCarrera').html('<strong>'+carrera.carrera+'</strong>');
		  	$('#mRegimen').text(carrera.regimen.descripcion);
		  	$('#mTipoCarrera').text(carrera.tipo_carrera.descripcion);
		  	$('#mDuracion').text(carrera.duracion+' '+carrera.tipo_duracion.descripcion);
		  	$('#mCargaHoraria').text(carrera.cargahorariacatedra+' '+'hs. Cátedras');
		  	if (carrera.exameningreso==1){ var exi = 'SI' }else{ var exi = 'NO' }
		  	$('#mExamenIngreso').text(exi);
		  	$('#modalVerMasInformacion').modal('show');
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
