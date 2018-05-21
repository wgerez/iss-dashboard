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
		<div class="page-content" ng-app="app">
			<!-- COMIENZO DEL HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- COMIENZO TITULO & BREADCRUMB-->
					<h3 class="page-title">
					Correlatividades <small>listado de Correlatividades</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="listado">Correlatividades</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="listado">Listado</a>
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
					    @if (Session::get('message_type') == CorrelatividadesController::OPERACION_EXITOSA)

					        <div class="note note-success">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == CorrelatividadesController::OPERACION_FALLIDA)

					        <div class="note note-danger">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == CorrelatividadesController::OPERACION_CANCELADA)

					        <div class="note note-warning">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == CorrelatividadesController::OPERACION_INFO)

					        <div class="note note-info">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@endif
					@endif
					<!-- COMIENZO DE LA TABLA-->
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-files-o"></i>Listado de Correlatividades
							</div>
							<div class="actions">
								<a {{ $disabled }} href="{{url('correlatividades/crear')}}" class="btn default blue-stripe">
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Nueva </span>
								</a>
								<a target="_blank" href="#" id="imprimir" {{$imprimir}} class="btn default yellow-stripe">
								<i class="fa fa-print"></i>
								<span class="hidden-480">
								Imprimir </span>
								</a>	

							</div>

						</div>
						<div class="portlet-body" >
							<div class="form-body">
								<!--<form method="POST" action="{{url('correlatividades/obtenermateriacorrelativas')}}" class="form-horizontal form-row-seperated" id="FrmCorrelatividad">-->
								<form class="form-horizontal form-row-seperated" id="FrmCorrelatividad">

									<div class="form-group">
										<label  class="col-md-2 col-sm-2 control-label">Organización:</label>
										<div class="col-md-6 col-sm-10">
											<select name="organizaciones" id="organizaciones" class="table-group-action-input form-control">
												<option value="0">Seleccione</option>
												<?php
												foreach ($organizaciones as $organizacion) {
												?>
													<option value="<?php echo $organizacion->id; ?>"><?php echo $organizacion->nombre; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-2 col-sm-2 control-label" for="carreras">Carrera:</label>
										<div class="col-md-6 col-sm-10">
												<select  class="table-group-action-input form-control" name="carreras" id="carreras">
													<option selected value="0">Seleccione</option>
												</select>
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-2 col-sm-2 control-label" for="plan">Plan:</label>
										<div class="col-md-4 col-sm-4">
											<select class="table-group-action-input form-control" name="plan" id="plan">
												<option selected value="0">Seleccione</option>
											</select>
										</div>

										<div class="col-md-2 col-sm-2">
											<button class="btn btn-primary" type="button" id ="buscar"><i class="fa fa-search"></i> Buscar</button>
										</div>
									</div>

								</form>
							</div>
							<br>

							<div class="portlet-body">
							 <div class="box-body table-responsive no-padding">
								<table class="table table-striped table-bordered table-hover" id="table_correlatividades">
									<thead>
									<tr>
										<th>
											<center><i class="fa fa-list-ol"></i> Año de Cursado</center>
										</th>
										<th>
											<center><i class="fa fa-calendar"></i> Periodo</center>
										</th>
										<th>
											<center><i class="fa fa-calendar"></i> Cuatrimestre</center>
										</th>
										<th>
											<center><i class="fa fa-tag"></i> Materia</center>
										</th>
										<th class="hidden-xs">
											<center><i class="fa fa-info-circle"></i> Haber Cursado</center>
										</th>
										<th>
											<center><i class="fa fa-info-circle"></i> Haber Aprobado</center>
										</th>
										<th>
											<center><i class="fa fa-info-circle"></i> Para rendir Finales</center>
										</th>
										<th>
											<center><i class="fa fa-rocket"></i> Acción</center>
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
					<!-- FIN DE LA TABLA-->
				</div>
			</div>
			<!-- FIN DEL CONTENIDO -->
		</div>
	</div>
	<!-- FIN -->

<!-- MODAL ELIMINACION DE CICLOS-->
	<div class="modal fade" id="modalEliminaCorrelatividad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		{{ Form::open(array('url' => 'correlatividades/borrar')) }}
			<input id="idCorrelatividadHidden" name='idCorrelatividadHidden' type="hidden" value="">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Eliminar Correlatividad</h4>
					</div>
					<div class="modal-body">
						¿Estás seguro de querer borrar esta Correlatividad?
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

	//TableAdvanced.init();

//AL PRESIONAR LOS BOTONES ELIMINAR PASO EL DATA ID DE LA CARRERA A ELIMINAR
	$('.btnEliminarCorrelatividad').live('click', function(){
		//PASO EL DATA ID AL CAMPO OCULTO		
		$('#idCorrelatividadHidden').val($(this).data('id'));
		//MUESTRO EL MODAL DE ADVERTENCIA
		$('#modalEliminaCorrelatividad').modal('show');
	});

$("#imprimir").attr('disabled', 'disabled');
	
$('#organizaciones').change(function() {
	
	
	var buscarO = $("#organizaciones option:selected").attr("value")
	//alert(buscarO);
	var arrayJS=<?php echo json_encode($arrCarreras);?>;
	//alert(arrayJS.carrera);	

	$('option', '#carreras').remove();
	$("#carreras").append('<option value="0" disabled selected>Seleccionar</option>');
	
	$('option', '#plan').remove();
	$("#plan").append('<option value="0" disabled selected>Seleccionar</option>');
			
	$.each(arrayJS, function(key, value){
		//$("#carreras").append('<option value="'+value.id+'">'+value.numero+' '+value.letra+'</option>');
		if(value.organizacion_id == buscarO) {
			$("#carreras").append('<option value="'+value.id+'">'+value.carrera+'</option>');
		}

	})


});

$('#carreras').change(function() {
	
	
	var buscarP = $("#carreras option:selected").attr("value")
	//alert(buscarP);
	var arrayJS=<?php echo json_encode($arrPlanes);?>;
	//alert(arrayJS.carrera);	
	
	$('option', '#materias').remove();
	$("#materias").append('<option value="0" disabled selected>Seleccionar</option>');

	$('option', '#plan').remove();
	$("#plan").append('<option value="0" disabled selected>Seleccionar</option>');
			
	$.each(arrayJS, function(key, value){
		//$("#plan").append('<option value="'+value.id+'">'+value.numero+' '+value.letra+'</option>');
		if(value.carrera_id == buscarP) {
			$("#plan").append('<option value="'+value.id+'">'+value.codigoplan+'</option>');
		}

	})


});





$('#buscar').on('click', function(e){
		

	url_destino = "{{url('correlatividades/obtenermateriacorrelativas')}}";

    /* OBTENGO LAS MATERIAS */
	$.ajax({
	  url: url_destino,
	  data: {'plan': $("#plan option:selected").attr("value")},
	  type: 'POST'
	}).done(function(listacorrelativas) {
		console.log(listacorrelativas);
		
		
		$('#table_correlatividades').find("tr:gt(0)").remove();

		$.each(listacorrelativas, function(index, value){
        /* Vamos agregando a nuestra tabla las filas necesarias */
        	$('#table_correlatividades > tbody').append('<tr>' +
        	'<td><center>' + value.codigo + '</center></td>' +
        	 '<td><center>' + value.periodo + '</center></td>' +
        	 '<td><center>' + value.cuatrimestre + '</center></td>' +
        	 '<td><center>' + value.nombremateria + '</center></td>' +
        	 '<td><center>' + value.cursadas + '</center></td>' +
        	 '<td><center>' + value.aprobadas + '</center></td>' +
        	  '<td><center>' + value.finales + '</center></td>' +
        	'<td><center><table><tr><td><center><a title="Modificar" href="{{url('correlatividades/editar')}}/'+value.id+'" class="btn default btn-xs purple"><i class="fa fa-edit"></i></a></td><td><a href="#modaleliminacorrelatividad" data-id="'+ value.id +'" class="btn default btn-xs red btnEliminarCorrelatividad"><i title="Eliminar" class="fa fa-trash-o"></i></center></center></td></tr></table></td>' +
			'</tr>');
    });

	if($('#table_correlatividades >tbody >tr').length > 0) {
		$('#imprimir').removeAttr("disabled",'false');
	} else {
		$("#imprimir").attr('disabled', 'disabled');
	}

	}).error(function(data) {
		console.log(data);
	});


});


$('#imprimir').on('click', function(e){
	e.preventDefault();
	window.open("{{url('correlatividades/imprimir')}}?plan=" + $('#plan').val());
});


$('div.note').not('.alert-important').delay(3000).fadeOut(350) 

@stop


@section('includejs')
	<script type="text/javascript" src="{{url('assets/global/plugins/select2/select2.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js')}}"></script>
	<!--<script src="{{url('assets/admin/pages/scripts/table-advanced.js')}}"></script>-->
	<!-- ANGULARJS -->
	<!--<script type="text/javascript" src="{{url('assets/global/scripts/angular.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/scripts/correlatividadesapp.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/scripts/controllers/correlatividadesController.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/scripts/services/planesxCarreras.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/scripts/directives/materiasDirective.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/scripts/services/carrerasporOrganizacion.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/scripts/directives/correlatividadesDirective.js')}}"></script>-->
@stop
