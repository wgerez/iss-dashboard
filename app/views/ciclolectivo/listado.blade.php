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
					Ciclos Lectivos <small>gestión de ciclos</small>
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
							<a href="{{url('organizacions/listado')}}">Organizaciones</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('ciclolectivo/listado')}}">Ciclos Lectivos</a>
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
					    @if (Session::get('message_type') == CiclolectivoController::OPERACION_EXITOSA)

					        <div class="note note-success">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == CiclolectivoController::OPERACION_FALLIDA)

					        <div class="note note-danger">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == CiclolectivoController::OPERACION_CANCELADA)

					        <div class="note note-warning">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == CiclolectivoController::OPERACION_INFO)

					        <div class="note note-info">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@endif
					@endif
					<!-- COMIENZO DE LA TABLA-->
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-calendar"></i>Listado de Ciclos
							</div>
							<div class="actions">
								<a {{ $disabled }} href="{{url('ciclolectivo/crear')}}" class="btn default blue-stripe">
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Nuevo </span>
								</a>
								<a href="{{url('ciclolectivo/listado')}}" class="btn default yellow-stripe">
								<i class="fa fa-refresh"></i>
								<span class="hidden-480">
								Actualizar </span>
								</a>

							</div>

						</div>
						<div class="portlet-body">
							<table class="table table-striped table-bordered table-hover" id="table_ciclos">
								<thead>
								<tr>
									<th>
										<center><i class="fa fa-bank"></i> Organización</center>
									</th>
									<th>
										<center><i class="fa fa-calendar"></i> Ciclo Lectivo</center>
									</th>
									<th>
										<center><i class="fa fa-tag"></i> Activo</center>
									</th>
									<th class="hidden-xs">
										<center><i class="fa fa-calendar"></i> Fecha Inicio</center>
									</th>
									<th>
										<center><i class="fa fa-calendar"></i> Fecha Fin</center>
									</th>
									<th>
										<center><i class="fa fa-rocket"></i> Acción</center>
									</th>
								</tr>
								</thead>
								<tbody>

									@foreach ($ciclos as $ciclo)
										<?php
							    			$fechainicio = FechaHelper::getFechaImpresion($ciclo->fechainicio);
							    			$fechafin = FechaHelper::getFechaImpresion($ciclo->fechafin);
							    		?>
										<tr>
											<td class="verinfo" data-id="{{$ciclo->id}}" data-nivel="{{$ciclo->activo}}" style="cursor:pointer">
												{{$ciclo->organizacion->nombre}}
											</td>
											<td class="verinfo" data-id="{{$ciclo->id}}" data-nivel="{{$ciclo->activo}}" style="cursor:pointer">
												{{$ciclo->descripcion}}
											</td>
											<td class="verinfo" data-id="{{$ciclo->id}}" data-nivel="{{$ciclo->activo}}" style="cursor:pointer">
												@if ($ciclo->activo) Si @else No @endif
											</td>
											<td class="verinfo" data-id="{{$ciclo->id}}" data-nivel="{{$ciclo->activo}}" style="cursor:pointer">
												 {{ $fechainicio }}
											</td>
											<td class="verinfo" data-id="{{$ciclo->id}}" data-nivel="{{$ciclo->activo}}" style="cursor:pointer">
												 {{ $fechafin }}
											</td>
											<td>
												<center>
												<a title="Modificar" href="editar/{{$ciclo->id}}" class="btn default btn-xs purple">
												<i class="fa fa-edit"></i></a>
												<a title="Eliminar" href="#modaleliminaciclo" {{ $disabled }} data-id="{{$ciclo->id}}" class="btn default btn-xs red btnEliminarCiclo">
												<i class="fa fa-trash-o"></i></a>
												</center>
											</td>
										</tr>
									@endforeach

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
	<div class="modal fade" id="modalEliminaCiclo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		{{ Form::open(array('url' => 'ciclolectivo/borrar')) }}
			<input id="idCicloHidden" name='txtIdCicloHidden' type="hidden" value="">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Eliminar Ciclo</h4>
					</div>
					<div class="modal-body">
						¿Estás seguro de querer borrar este ciclo?
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



	<!-- MODAL VER MAS INFO-->
	<div id="modalVerMasInformacion" class="modal fade" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title" id='mTitulo'></h4>
				</div>
				<div class="modal-body">
					<div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible1="1">

							<div class="col-md-12 col-sm-12">
								<div class="col-md-4 col-sm-4">
						 			<p class="text-info"><strong>Activo</strong></h5>
						 		</div>
						 		<div class="col-md-8 col-sm-8">
						 			<p id="mActivo"></p>
						 		</div>					 		
							</div>

							<div class="col-md-12 col-sm-12">
								<div class="col-md-4 col-sm-4">
						 			<p class="text-info"><strong>Fecha Inicio</strong></h5>
						 		</div>
						 		<div class="col-md-8 col-sm-8">
						 			<p id="mFechaInicio"></p>
						 		</div>					 		
							</div>
							<div class="col-md-12 col-sm-12">
								<div class="col-md-4 col-sm-4">
						 			<p class="text-info"><strong>Fecha Cierre</strong></h5>
						 		</div>
						 		<div class="col-md-8 col-sm-8">
						 			<p id="mFechaCierre"></p>
						 		</div>					 		
							</div>

							<div class="col-md-12 col-sm-12">
								<table id="tableperiodoslectivos" class="table table-hover">
									<thead>
									<tr>
										<th colspan=3>
											 Per&iacute;odos Lectivos
										</th>
									</tr>
									<tr>
										<th>
											 Per&iacute;odo
										</th>
										<th>
											 Fecha Inicio
										</th>
										<th>
											 Fecha Fin
										</th>
									</tr>
									</thead>
									<tbody>
									</tbody>
							    </table>
							</div>
						
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn default" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> Cerrar</button>				</div>
			</div>
		</div>
	</div>
@stop


@section('customjs')
	TableAdvanced.init();

	$('.verinfo').live('click', function() {
	    // BORRAR FILAS DE LA TABLA PERIODOS LECTIVOS
	    var n = 0;
		$('#tableperiodoslectivos tr').each(function() {
		   if (n > 1) $(this).remove();
		   n++;
		});

		var nivel = $(this).data('nivel');
		$.ajax({
		  url: "{{url('ciclolectivo/show')}}",
		  data:{'id': $(this).data('id')},
		  type: 'POST'
		}).done(function(CicloLectivo) {
			console.log(CicloLectivo);
		  	$('#mTitulo').html('<strong>'+CicloLectivo.organizacion.nombre + ' - ' + CicloLectivo.descripcion + '</strong>');
		  	if (CicloLectivo.activo == 1) {
			    $('#mActivo').text("Si");
			} else {
				$('#mActivo').text("No");
		    }
		    var fecha_inicio = getFechaImpresion(CicloLectivo.fechainicio);
		    var fecha_fin = getFechaImpresion(CicloLectivo.fechafin);
		  	$('#mFechaInicio').text(fecha_inicio);
		  	$('#mFechaCierre').text(fecha_fin);

			$.each(CicloLectivo.periodos_lectivos, function(key, value) {
			    fecha_inicio = getFechaImpresion(value.fechainicio);
			    fecha_fin = getFechaImpresion(value.fechafin);
				$('#tableperiodoslectivos > tbody').append('<tr><td>' + value.descripcion + '</td><td>' + fecha_inicio + '</td><td>' + fecha_fin + '</td></tr>');
			});

		  	$('#modalVerMasInformacion').modal('show');
		}).error(function(data){
			console.log(data);
		});
	});

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
