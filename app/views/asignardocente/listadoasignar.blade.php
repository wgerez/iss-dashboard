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
					Asignación de Docentes <small> Registrar docente a materia</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('asignardocente/asignadocente')}}">Listado</a>
							<i class="fa fa-angle-right"></i>
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
					    @if (Session::get('message_type') == AsignarDocenteController::OPERACION_EXITOSA)

					        <div class="note note-success">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == AsignarDocenteController::OPERACION_FALLIDA)

					        <div class="note note-danger">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == AsignarDocenteController::OPERACION_CANCELADA)

					        <div class="note note-warning">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == AsignarDocenteController::OPERACION_INFO)

					        <div class="note note-info">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@endif
					@endif
					<!-- COMIENZO DE LA TABLA-->
								{{ Form::open(array('url'=>'docentes/guardar', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmListadoasistencias', 'name'=>'FrmListadoalumnos'))}}
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-files-o"></i> Asignar docentes
							</div>
							<div class="actions">
								<!--a href="#" {{$disabled}} id="guardar" class="btn default blue-stripe">
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Guardar </span>
								</a-->
								<a href="{{url('asignardocente/crear')}}" {{ $disabled }} class="btn default blue-stripe">
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Nuevo </span>
								</a>
								<!--button type='submit' class="btn default green-stripe" {{ $disabled }} <?php if ($habilita == true) echo "disabled"; ?>>
								<i class="fa fa-save"></i>
								<span class="hidden-480">
								Guardar </span>
								</button-->
								<a target="_blank" href="#" id="imprimir" {{$imprimir}} class="btn default yellow-stripe" <?php if ($habilita == false) echo "disabled"; ?>>
								<i class="fa fa-print"></i>
								<span class="hidden-480">
								Imprimir </span>
								</a>								
							</div>
						</div>
						<div class="portlet-body form">
							<div class="form-body">
								<div class="form-group">
									<label  class="col-md-2 col-sm-2 control-label">Organización:</label>
									<div class="col-md-6 col-sm-6">
										{{ Form::select('cboOrganizacion', $organizaciones, Input::old('organizacion'), array('class'=>'table-group-action-input form-control','id'=>'cboOrganizacion')); }}
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 col-sm-2 control-label" for="cbocarrera">Carrera:</label>
									<div class="col-md-6 col-sm-6">
										<select name="cboCarrera" id="cboCarrera" class="table-group-action-input form-control">
											<option value="0">Seleccione</option>
											@if (isset($carreras))
												@foreach ($carreras as $carrera)
													<option value="{{$carrera->id}}" <?php if ($carrera->id == $carrera_id) echo "selected"; ?>>{{$carrera->carrera}}</option>
												@endforeach
											@endif
										</select>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 col-sm-2 control-label" for="filtro">Plan Estudio:</label>
									<div class="col-md-2 col-sm-3">
										<select name="cboPlan" id="cboPlan" class="table-group-action-input form-control">
											<option value="0">Seleccione</option>
											@if (isset($planes))
												@foreach ($planes as $plan)
													<option value="{{$plan->id}}" <?php if ($plan->id == $planID) echo "selected"; ?>>{{$plan->codigoplan}}</option>
												@endforeach
											@endif
										</select>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 col-sm-2 control-label" for="cboMaterias">Materias:</label>
									<div class="col-md-6 col-sm-6">
										<select name="cboMaterias" id="cboMaterias" class="table-group-action-input form-control">
											<option value="0">Todos</option>
											@if (isset($materias))
												@foreach ($materias as $materia)
													<option value="{{$materia->id}}" <?php if ($materia->id == $materia_id) echo "selected"; ?>>{{$materia->nombremateria}}</option>
												@endforeach
											@endif
										</select>
									</div>

									<div class="col-md-2 col-sm-2">
										<a class="btn blue-madison" id='btnBuscar' <?php if (isset($alumnosinscriptos)) echo "disabled"; ?>>
											<i class="fa fa-search"></i> Buscar
										</a>
									</div>
								</div>

							<div class="portlet-body">
								<div class="box-body table-responsive no-padding">
									<table class="table table-striped table-bordered table-hover" id="table_asistencias">
										<thead>
										<tr>
											<th>
												<center><i class="fa fa-files-o"></i> Materia</center>
											</th>
											<th>
												<center><i class="fa fa-user"></i> Docente Titular</center>
											</th>
											<th>
												<center><i class="fa fa-user"></i> Docente Provisorio</center>
											</th>
											<th>
												<center><i class="fa fa-user"></i> Docente Suplente</center>
											</th>
											<th>
												<center><i class="fa fa-calendar"></i> Dias</center>
											</th>
											<th>
												<center><i class="fa fa-calendar"></i> Hora Entrada</center>
											</th>
											<th>
												<center><i class="fa fa-calendar"></i> Hora Salida</center>
											</th>
											<th>
												<center>Acciones</center>
											</th>
										</tr>
										</thead>
										<tbody>

										</tbody>
									</table>
								</div>

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

							</div>
						</div>
					</div>
								{{ Form::close() }}
					<!-- FIN DE LA TABLA-->
				</div>
			</div>
			<!-- FIN DEL CONTENIDO -->

						<!-- MODAL ELIMINACION DE CICLOS-->
						<div class="modal fade" id="modalEliminaCorrelatividad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							{{ Form::open(array('url' => 'asignardocente/borrar')) }}
								<input id="idPlanHidden" name='idPlanHidden' type="hidden" value="">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Eliminar Plan de Estudios</h4>
										</div>
										<div class="modal-body">
											¿Estás seguro de querer borrar este registro?
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
							
		</div>
	</div>
	<!-- FIN -->

@stop

@section('customjs')
	//TableAdvanced.init();
	
	$("#imprimir").attr('disabled', 'disabled');
	//$("#txtalumno").attr('disabled', 'disabled');

	$('#btnBuscartt').click(function() {
    	var carrera_id = $('#cboCarrera').val();
        var planID = $('#cboPlan').val();
        var materia_id = $('#cboMaterias').val();
		
		$.ajax({
		  url: "{{url('docentes/obtenerasignacion')}}",
		  data:{'materia_id': materia_id, 'carrera_id': carrera_id, 'planID': planID},
		  type: 'POST'
		}).done(function(materias) {
			console.log(materias);

			$("#table_asistencias").find("tr:gt(0)").remove();

			$.each(materias, function(key, value) {
				$('#table_asistencias > tbody').append('<tr><td><center>'+value.apellido+', '+value.nombre+'</center></td><td><center>'+value.nrodocumento+'</center></td><td><center><input type="checkbox" name="asistencia[]" value="'+value.alumno_id+'" '+value.asistencia+' '+activo+'></center></td></tr>');
				$('#fechas').val(value.fecha);
			});

		}).error(function(data) {
			console.log(data);
		});
	});

	$('#cboOrganizacion').select2({
		placeholder: "Seleccione",
		allowClear: true
	});

	$('#imprimir').on('click', function(e){
		e.preventDefault();
		window.open("{{url('asignardocente/imprimir')}}?planID=" + $('#cboPlan').val() + '&carrera_id=' + $('#cboCarrera').val() + '&materia_id=' + $('#cboMaterias').val());
	});

    $('#btnBuscar').click(function() {
    	limpiar_tabla();

		$("#table_asistencias").find("tr:gt(0)").remove();

        var materia_id = $('#cboMaterias').val();
    	var carrera_id = $('#cboCarrera').val();
    	var planID = $('#cboPlan').val();
		$("#imprimir").attr('disabled', 'disabled');

		$.ajax({
		  url: "{{url('asignardocente/obtenerasignacion')}}",
		  data:{'materia_id': materia_id, 'carrera_id': carrera_id, 'planID': planID},
		  type: 'POST'
		}).done(function(docentes) {
			console.log(docentes);

			$("#table_asistencias").find("tr:gt(0)").remove();
			
			var tablacargada = '';
			var tabla = '';
			var tabladetalle = '';
			var id = 0;
			var bandera = true;
			
			$.each(docentes, function(key, value) {
				bandera = true;

				tabla = '<tr><td><center>'+value.docentesmateria+'</center></td><td><center>'+value.apeynomtitular+'</center></td><td><center>'+value.apeynomprovisorio+'</center></td><td><center>'+value.apeynomsuplente+'</center></td>';

				id = value.id;

				$.each(value.dias, function(key, dia) {
					if (bandera == true) {
						tabladetalle = '<td><center>'+dia.dia+'</center></td><td><center>'+dia.horaentrada+'</center></td><td><center>'+dia.horasalida+'</center></td><td><center><a title="Modificar" href="{{url('asignardocente/editar')}}/'+id+'" class="btn default btn-xs purple"><i class="fa fa-edit"></i></a><!--a href="#" data-id="'+id+'"  class="btn default btn-xs red btnEliminarMaterias" data-toggle="modal" data-target="#deletePlan"><i title="Eliminar" class="fa fa-trash-o"></i></a--></center></td></tr>';
						bandera = false;
					} else {
						tabladetalle = '<tr><td><center></center></td><td><center></center></td><td><center></center></td><td><center></center></td><td><center>'+dia.dia+'</center></td><td><center>'+dia.horaentrada+'</center></td><td><center>'+dia.horasalida+'</center></td><td><center></center></td></tr>';
					}

					tabla += tabladetalle;
				});

				tablacargada += tabla;
			});

			$('#table_asistencias > tbody').append(tablacargada);

			if (tablacargada == '') {
				$("#imprimir").attr('disabled', 'disabled');
			} else {
				$("#imprimir").removeAttr("disabled");
			}

		}).error(function(data) {
			console.log(data);
		});
    });

    $('#cboPlan').change(function() {
    	limpiar_tabla();

        if ($('#cboPlan').val() == 0) return;
		$('#cboMaterias').children().remove().end();

        var plan_id = $('#cboPlan').val();
    	var carrera_id = $('#cboCarrera').val();

		$.ajax({
		  url: "{{url('asistencias/obtenermaterias')}}",
		  data:{'plan_id': plan_id, 'carrera_id': carrera_id},
		  type: 'POST'
		}).done(function(materias) {
			console.log(materias);

			$("#table_asistencias").find("tr:gt(0)").remove();

			$('#cboMaterias').append(
		        $('<option></option>').val(0).html('Todos')
		    );

			$.each(materias, function(key, value) {
				$('#cboMaterias').append(
			        $('<option></option>').val(value.id).html(value.nombremateria)
			    );
			});
			
		}).error(function(data) {
			console.log(data);
		});
    });

    $('#cboCarrera').change(function() {
    	limpiar_tabla();

        if ($('#cboCarrera').val() == 0) return;
		$('#cboPlan').children().remove().end();

        var carrera_id = $('#cboCarrera').val();

		$.ajax({
		  url: "{{url('asistencias/obtenerplanes')}}",
		  data:{'carrera_id': carrera_id},
		  type: 'POST'
		}).done(function(planes) {
			console.log(planes);

			$("#table_asistencias").find("tr:gt(0)").remove();

			$('#cboPlan').append(
		        $('<option></option>').val(0).html('Seleccionar')
		    );

			$.each(planes, function(key, value) {
				$('#cboPlan').append(
			        $('<option></option>').val(value.id).html(value.codigoplan)
			    );
			});

		}).error(function(data) {
			console.log(data);
		});
    });

    $('#cboOrganizacion').change(function() {
    	// 1 - limpiar todo

    	limpiar_tabla();
		$('#cboCarrera').children().remove().end();

		if ($('#cboOrganizacion').val() == 0) return;
		
		$.ajax({
		  url: "{{url('organizacions/obtenercarreras')}}",
		  data:{'organizacion_id': $('#cboOrganizacion').val()},
		  type: 'POST'
		}).done(function(carreras) {
			console.log(carreras);
			if (carreras == <?php echo OrganizacionsController::NO_TIENE_CARRERAS ?>) {
				$('#modalMensajes').modal('show');
				return;
		    }

			$("#table_asistencias").find("tr:gt(0)").remove();

			$('#cboCarrera').append(
		        $('<option></option>').val(0).html('Seleccionar')
		    );

			$.each(carreras, function(key, value) {
				$('#cboCarrera').append(
			        $('<option></option>').val(value.id).html(value.carrera)
			    );
			});
		}).error(function(data){
			console.log(data);
		});
    });

    function limpiar_tabla() {
	    var n = 0;
		$('#table_asistencias tr').each(function() {
		   if (n > 1) $(this).remove();
		   n++;
		});
    }

    //AL PRESIONAR LOS BOTONES ELIMINAR PASO EL DATA ID DE LA CARRERA A ELIMINAR
	$('.btnEliminarMaterias').live('click', function(){
		//PASO EL DATA ID AL CAMPO OCULTO		
		$('#idPlanHidden').val($(this).data('id'));
		//MUESTRO EL MODAL DE ADVERTENCIA
		$('#modalEliminaCorrelatividad').modal('show');
	});

	$(document).ready(function(){
 
		$('.ir-arriba').click(function(){
			$('body, html').animate({
				scrollTop: '0px'
			}, 300);
		});
	 
		$(window).scroll(function(){
			if( $(this).scrollTop() > 0 ){
				$('.ir-arriba').slideDown(300);
			} else {
				$('.ir-arriba').slideUp(300);
			}
		});
	 
	});

	$('div.alert').not('.alert-important').delay(3000).fadeOut(350) 

@stop


@section('includejs')
	<script type="text/javascript" src="{{url('assets/global/plugins/select2/select2.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js')}}"></script>
	<script src="{{url('assets/admin/pages/scripts/getFechaImpresion.js')}}"></script>
	<script src="{{url('assets/admin/pages/scripts/primerFechaMayor.js')}}"></script>
	<script src="{{url('assets/admin/pages/scripts/table-advanced.js')}}"></script>
<script src="{{url('assets/admin/layout/scripts/menusticky.js')}}" type="text/javascript"></script>
@stop
