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
					Organizaciones <small>gestión de organizaciones</small>
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
						</li-->
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
							<a href="{{url('organizacions/listado')}}">Listado</a>
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
					    @if (Session::get('message_type') == OrganizacionsController::OPERACION_EXITOSA)

					        <div class="note note-success">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == OrganizacionsController::OPERACION_FALLIDA)

					        <div class="note note-danger">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == OrganizacionsController::OPERACION_CANCELADA)

					        <div class="note note-warning">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == OrganizacionsController::OPERACION_INFO)

					        <div class="note note-info">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@endif
					@endif
					<!-- COMIENZO DE LA TABLA-->
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-university"></i>Listado de Organizaciones
							</div>
							<div class="actions">
								<a href="{{url('organizacions/crear')}}" {{ $disabled }} class="btn default blue-stripe">
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Nueva </span>
								</a>
								<a href="{{url('organizacions/listado')}}" class="btn default yellow-stripe">
								<i class="fa fa-refresh"></i>
								<span class="hidden-480">
								Actualizar </span>
								</a>

							</div>

						</div>
						<div class="portlet-body">
							<table class="table table-striped table-bordered table-hover" id="table_organizaciones">
								<thead>
								<tr>
									<th>
										<center><i class="fa fa-list-ol"></i> Cod. Org.</center>
									</th>
									<th class="hidden-xs">
										<center><i class="fa fa-tag"></i> Nombre</center>
									</th>
									<th>
										<center><i class="fa fa-info-circle"></i> Nivel de Educación</center>
									</th>
									<th>
										<center><i class="fa fa-rocket"></i> Acción</center>
									</th>
								</tr>
								</thead>
								<tbody>

									@foreach ($organizaciones as $organizacion)
										<tr>
											<td class="highlight verinfo" data-id="{{$organizacion->id}}" data-nivel="{{$organizacion->nivelEducativo->descripcion}}" style="cursor:pointer">
												{{$organizacion->id}}
											</td>
											<td class="hidden-xs verinfo" data-id="{{$organizacion->id}}" data-nivel="{{$organizacion->nivelEducativo->descripcion}}" style="cursor:pointer">
												 {{$organizacion->nombre}}
											</td>
											<td class="verinfo" data-id="{{$organizacion->id}}" data-nivel="{{$organizacion->nivelEducativo->descripcion}}" style="cursor:pointer">
												 {{$organizacion->nivelEducativo->descripcion}}
											</td>
											<td>
												<center>
												<a title="Modificar" href="editar/{{$organizacion->id}}" class="btn default btn-xs purple">
												<i class="fa fa-edit"></i></a>
												<a title="Eliminar" href="#modaleliminaorganizacion" @if (!$eliminar) {{'DISABLED'}} @endif data-id="{{$organizacion->id}}" class="btn default btn-xs red btnEliminarOrganizacion">
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


	<!-- MODAL ELIMINACION DE ORGANIZACIONES-->
	<div class="modal fade" id="modalEliminaOrganizacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		{{ Form::open(array('url' => 'organizacions/borrar')) }}
			<input id="idOrganizacionHidden" name='txtIdOrganizacionHidden' type="hidden" value="">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Eliminar Organización</h4>
					</div>
					<div class="modal-body">
						 ¿Estás seguro de querer borrar esta organización?
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



	<!-- MODAL ELIMINACION DE ORGANIZACIONES-->
	<div class="modal fade" id="modalVerMasInformacion" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title" id="mNombreOrg"></h4>
					</div>
					<div class="modal-body">
						 <h5 class="text-info"><strong>Razón Social</strong></h5>
						 <p id="mRazonOrg"> - </p>
						 <h5 class="text-info"><strong>Nivel Académico</strong></h5>
						 <p id="mNivelOrg"> - </p>					 
						 <h5 class="text-info"><strong>Cuit</strong></h5>
						 <p id="mCuitOrg"> - </p>
						 <h5 class="text-info"><strong>Domicilio</strong></h5>
						 <p id="mDomicilioOrg"></p>
						 <h5 class="text-info"><strong>Fecha Alta</strong></h5>
						 <p id="mFechaAltaOrg"></p>						 
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
		
	$('.verinfo').live('click', function(){
		var nivel = $(this).data('nivel');
		$.ajax({
		  url: "{{url('organizacions/show')}}",
		  data:{'id': $(this).data('id')},
		  type: 'POST'
		}).done(function(organizacion) {
			console.log(organizacion);
			var fecha_alta = getFechaImpresion(organizacion.fecha_alta);

		  	$('#mNombreOrg').html('<strong>'+organizacion.nombre+'</strong>');
		  	$('#mRazonOrg').text(organizacion.razon_social);
		  	$('#mCuitOrg').text(organizacion.cuit);
		  	if (organizacion.calle){ var calle = organizacion.calle }else{ calle='Calle'}
		  	if (organizacion.numero!=0 && organizacion.numero !=null) {
		  	    var numero = organizacion.numero;
		  	} else {
		  	    numero='s/n';
		    }
		  	$('#mDomicilioOrg').text(calle +', '+ numero +', '+ organizacion.localidad.descripcion);
		  	$('#mFechaAltaOrg').text(fecha_alta);
		  	$('#mNivelOrg').text(nivel);
		  	$('#modalVerMasInformacion').modal('show');
		}).error(function(data){
			console.log(data);
		});
	});
	//AL PRESIONAR LOS BOTONES ELIMINAR PASO EL DATA ID DE LA ORGANIZACION A ELIMINAR
	$('.btnEliminarOrganizacion').live('click', function(){
		//PASO EL DATA ID AL CAMPO OCULTO
		$('#idOrganizacionHidden').val($(this).data('id'));
		//MUESTRO EL MODAL DE ADVERTENCIA
		$('#modalEliminaOrganizacion').modal('show');
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
