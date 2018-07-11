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

if (!isset($turnoexamen_id)) {
	$turnoexamen_id = 0;
}

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
					Examen Final <small> Examenes Finales</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('examenfinal/listado')}}">Examen Final</a>
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
					    @if (Session::get('message_type') == ExamenFinalController::OPERACION_EXITOSA)

					        <div class="note note-success">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == ExamenFinalController::OPERACION_FALLIDA)

					        <div class="note note-danger">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == ExamenFinalController::OPERACION_CANCELADA)

					        <div class="note note-warning">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == ExamenFinalController::OPERACION_INFO)

					        <div class="note note-info">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@endif
					@endif
					<!-- COMIENZO DE LA TABLA-->
					<form method="POST" action="{{url('examenfinal/obtenerlistado')}}" class="form-horizontal form-row-seperated" id="FrmPlaneslistados" name="">
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-files-o"></i> Examen Final
							</div>
							<div class="actions">
								<!--a href="#" {{$disabled}} id="guardar" class="btn default blue-stripe">
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Guardar </span>
								</a-->
								<a href="{{url('examenfinal/crear')}}" {{ $disabled }} class="btn default blue-stripe">
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Nuevo </span>
								</a>
								<a href="#" id="imprimir" {{$imprimir}} class="btn default yellow-stripe" <?php if ($habilita == false) echo "disabled"; ?>>
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

									<label class="col-md-2 col-sm-2 control-label">Ciclo Lectivo:</label>
									<div class="col-md-2 col-sm-2">
										<select class="table-group-action-input form-control" name="cboCiclos" id="cboCiclos">
											@if (isset($ciclos))
												@foreach ($ciclos as $ciclo)
													<option value="{{$ciclo->id}}" <?php if ($ciclo->id == $ciclo_id) echo "selected"; ?>>{{$ciclo->descripcion}}</option>
												@endforeach
											@endif
										</select>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 col-sm-2 control-label" for="filtro">Turno Exámen:</label>
									<div class="col-md-2 col-sm-3">
										<select name="cboTurnoExamen" id="cboTurnoExamen" class="table-group-action-input form-control">
											<option value="0">Seleccione</option>
											@if (isset($turnos))
												@foreach ($turnos as $turno)
													<option value="{{$turno->id}}" <?php if ($turno->id == $turnoexamen_id) echo "selected"; ?>>{{$turno->descripcion}}</option>
												@endforeach
											@endif
										</select>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 col-sm-2 control-label" for="cboMaterias">Unidad Curricular:</label>
									<div class="col-md-6 col-sm-6">
										<select name="cboMaterias" id="cboMaterias" class="table-group-action-input form-control">
											<option value="0">Seleccione</option>
											@if (isset($materias))
												@foreach ($materias as $materia)
													<option value="{{$materia['id']}}" <?php if ($materia['id'] == $materia_id) echo "selected"; ?>>{{$materia['nombremateria']}}</option>
												@endforeach
											@endif
										</select>
									</div>
								</div>

								<div class="form-group">
									<label  class="col-md-2 col-sm-2 control-label">Alumno:</label>
									<div class="col-md-2 col-sm-2">
										<select name="cboFiltroAlumno" id="cboFiltroAlumno" class="table-group-action-input form-control">
											<option value="1">Todos</option>
											<option value="2" <?php if (!$nrodocumento == '') echo 'selected'; ?>>DNI</option>
										</select>
									</div>
									<div class="col-md-4 col-sm-4">
										<input class="form-control" name="txtalumno" id="txtalumno" type="text" value="<?php if (!$nrodocumento == '') echo $nrodocumento; ?>" <?php if ($nrodocumento == '') echo 'disabled'; ?>>
										<input class="form-control" name="alumno_id" id="alumno_id" type="hidden" value="<?php if (isset($alumno_id)) echo $alumno_id; ?>">
									</div>
									<div class="col-md-2 col-sm-2">
										<!--a class="btn blue-madison" id='btnBuscar'>
											<i class="fa fa-search"></i> Buscar
										</a-->
										<div class="col-md-2 col-sm-2">
											<button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> Buscar</button>
										</div>
									</div>										
								</div>

								<!--div class="form-group" id="target">
									<label class="col-md-2 control-label" >Apellido y Nombre:</label>
									<div class="col-md-4 col-sm-10">
										<label id="nombreAlumno" class="control-label text-info" id="nombreAlumno"><?php if (isset($apeynom)) echo $apeynom; ?></label>
									</div>
									<label  class="col-md-2 col-sm-2 control-label">DNI:</label>
									<div class="col-md-2 col-sm-4 text-info" id='divDNI'><?php if (isset($nrodocumento)) echo $nrodocumento; ?></div>
								</div-->

							</div>
							<div class="portlet-body">
								<div class="box-body table-responsive no-padding">
									<table class="table table-striped table-bordered table-hover" id="table_examenfinal">
										<thead>
										<tr>
											<th>
												<center><i class="fa fa-calendar"></i> Fecha Aprobación</center>
											</th>
											<th>
												<center><i class="fa fa-users"></i> Tribunal/Docente</center>
											</th>
											<th>
												<center><i class="fa fa-user"></i> Alumno</center>
											</th>
											<th>
												<center><i class="glyphicon glyphicon-book"></i> Unidad Curricular</center>
											</th>
											<th>
												<center><i class="glyphicon glyphicon-sort-by-order-alt"></i> Calif. Final Número/Letra</center>
											</th>
											<th>
												<center><i class="glyphicon glyphicon-list-alt"></i> Folio</center>
											</th>
											<th>
												<center><i class="glyphicon glyphicon-list-alt"></i> Libro</center>
											</th>
											<th>
												<center><i class="glyphicon glyphicon-check"></i> Acta</center>
											</th>
											<th>
												<center><i class="glyphicon glyphicon-pencil"></i> Acciones</center>
											</th>
										</tr>
										</thead>
										<tbody>
											@if (isset($examenfinal))
												@foreach ($examenfinal as $examenfin)
													<?php $calif_final_num = $examenfin['calif_final_num']; ?>
													<tr>
														<td>
															<center>
																{{ $examenfin['fecha_aprobacion'] }}
															</center>
														</td>
														<td>
															<center>
																{{ $examenfin['docentes'] }}
															</center>
														</td>
														<td>
															<center>
																{{ $examenfin['alumno'] }}
															</center>
														</td>
														<td>
															<center>
																{{ $examenfin['nombremateria'] }}
															</center>
														</td>
														<td>
															<center>
																{{ $examenfin['calif_final_num'] }} ({{ $nota[$calif_final_num] }})
															</center>
														</td>
														<td>
															<center>
																{{ $examenfin['folio'] }}
															</center>
														</td>
														<td>
															<center>
																{{ $examenfin['libro'] }}
															</center>
														</td>
														<td>
															<center>
																{{ $examenfin['acta'] }}
															</center>
														</td>
														<td>
															<center>
																<a title="Modificar" href="{{url('examenfinal/editar/' . $examenfin['id'])}}" class="btn default btn-xs purple"><i class="fa fa-edit"></i></a>
																<a href="#" data-id="{{ $examenfin['id'] }}" class="btn default btn-xs red btnEliminarMaterias"><i title="Eliminar" class="fa fa-trash-o"></i></a>
															</center>
														</td>
													</tr>
												@endforeach
											@endif
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

	<!-- MODAL ELIMINACION DE MATERIAS-->
	<div class="modal fade" id="modalEliminaMateria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		{{ Form::open(array('url' => 'examenfinal/borrar')) }}
			<input id="idMateriaHidden" name='idMateriaHidden' type="hidden" value="">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Eliminar Examen Final</h4>
					</div>
					<div class="modal-body">
						¿Estás seguro de querer borrar este Examen Final?
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

							</div>
						</div>
					</div>
								</form>					<!-- FIN DE LA TABLA-->
				</div>
			</div>
			<!-- FIN DEL CONTENIDO -->
		</div>
	</div>
	<!-- FIN -->

@stop

@section('customjs')
	TableAdvanced.init();
	
	//$("#imprimir").attr('disabled', 'disabled');
	//$("#txtalumno").attr('disabled', 'disabled');
	$('#target').hide();

	$("#asistencias").change(function () {
	    if ($(this).is(':checked')) {
	        var activo = 'enabled';
			Inscripciones(activo);
	    } else {
	        var activo = 'disabled';
			Inscripciones(activo);
	    }
	});

	$('#btnBuscar').click(function() {
		var activo = 'disabled';
		var txtalumno = $('#txtalumno').val();

		if (!txtalumno == '') {
			$.ajax({
			  url: '{{url('alumnos/obteneralumnopordni')}}',
			  data: {'txt_alumno': txtalumno},
			  type: 'POST'
			}).done(function(alumno) {
				console.log(alumno);

				if (alumno == <?php echo AlumnosController::NO_EXISTE_ALUMNO ?>) {
					$('#divMensaje').html('<p class="form-control-static"><h4>' + 'El Alumno no existe!' + '</h4></p>');
		    		$('#MensajeCantidad').modal('show');
			    	return;
				}

				var name = alumno.apellido + ", " + alumno.nombre;
				var alumnoid = alumno.alumno_id;
				$('#alumno_id').val(alumno.alumno_id);
				name.toUpperCase();
				$('#nombreAlumno').text(name);
				$('#divDNI').html('<p class="form-control-static">' + alumno.nrodocumento + '</p>');
				//$('#icodni').removeClass('fa-warning').addClass("fa-check");
				//$('#divdni').removeClass('has-error').addClass("has-success");

			}).error(function(data) {
				console.log(data);
			});
		}
	});

	$('#cboFiltroAlumno').click(function() {
		if ($('#cboFiltroAlumno').val() == 2) {
	        $('#txtalumno').removeAttr("disabled");
	        $('#target').show();
	    }

	    if ($('#cboFiltroAlumno').val() == 1) {
	        $('#txtalumno').val("");
	        $('#alumno_id').val("");
	    	$("#txtalumno").attr('disabled', 'disabled');
	    	$('#target').hide();
	    }
	});

	$('#cboOrganizacion').select2({
		placeholder: "Seleccione",
		allowClear: true
	});

	$('#imprimir').on('click', function(e){
		if ($('#cboCarrera').val() == false || $('#cboMaterias').val() == false || $('#cboTurnoExamen').val() == false || $('#cboPlan').val() == false || $('#cboCiclos').val() == false) {
			$('#divMensaje').html('<p class="form-control-static"><h4>' + 'Debe seleccionar las opciones!' + '</h4></p>');
    		$('#MensajeCantidad').modal('show');
	    	return;
		} else {
			e.preventDefault();
			window.open("{{url('examenfinal/imprimir')}}?planID=" + $('#cboPlan').val() + '&carrera_id=' + $('#cboCarrera').val() + '&materia_id=' + $('#cboMaterias').val() + '&cboTurnoExamen=' + $('#cboTurnoExamen').val() + '&cboOrganizacion=' + $('#cboOrganizacion').val() + '&txtalumno=' + $('#txtalumno').val() + '&cboCiclos=' + $('#cboCiclos').val());
		}
	});

	$('.btnEliminarMaterias').live('click', function(){
		$('#idMateriaHidden').val($(this).data('id'));
		$('#modalEliminaMateria').modal('show');
	});

    $('#btnBuscar').click(function() {
    	var ciclo = $('#cboCiclos').val();
    	var carrera = $('#cboCarrera').val();

    });

    /*$('#cboMaterias').change(function() {
    	limpiar_tabla();

        if ($('#cboMaterias').val() == 0) return;

		var materia_id = $('#cboMaterias').val();
    	var carrera_id = $('#cboCarrera').val();
        var planID = $('#cboPlan').val();
        var cboTurnoExamen = $('#cboTurnoExamen').val();

		$.ajax({
		  url: "{{url('examenfinal/obtenerexamenes')}}",
		  data:{'materia_id': materia_id, 'carrera_id': carrera_id, 'planID': planID, 'cboTurnoExamen': cboTurnoExamen},
		  type: 'POST'
		}).done(function(materias) {
			console.log(materias);

			$("#table_regularidades").find("tr:gt(0)").remove();
			var calif_final_let = '';
			var tabladetalle = '';
			var bandera = true;

			$.each(materias, function(key, value) {
				if (value.calif_final_let == 0) {
					calif_final_let = "Aprobado";
				} 
				if (value.calif_final_let == 1) {
					calif_final_let = 'Desaprobado';
				}
				if (value.calif_final_let == 2) {
					calif_final_let = 'Ausente';
				}
				
				$('#table_regularidades > tbody').append('<tr><td><center>'+value.fecha_aprobacion+'</center></td><td><center>'+value.docentes+'</center></td><td><center>'+value.alumno+'</center></td><td><center>'+value.nombremateria+'</center></td><td><center>'+value.calif_final_num+'</center></td><td><center>'+calif_final_let+'</center></td><td><center>'+value.folio+'</center></td><td><center>'+value.libro+'</center></td><td><center>'+value.acta+'</center></td><td><center><a href="#" data-id="'+value.id+'" class="btn default btn-xs red btnEliminarMaterias"><i title="Eliminar" class="fa fa-trash-o"></i></a></center></td></tr>');
			});

		}).error(function(data) {
			console.log(data);
		});
    });*/

    $('#cboTurnoExamen').change(function() {
    	limpiar_tabla();

		$('#cboMaterias').children().remove().end();
        if ($('#cboTurnoExamen').val() == 0) return;

        var plan_id = $('#cboPlan').val();
    	var carrera_id = $('#cboCarrera').val();
    	var turnoexamen_id = $('#cboTurnoExamen').val();
    	var cboCiclos = $('#cboCiclos').val();

		$.ajax({
		  url: "{{url('examenfinal/obtenermaterias')}}",
		  data:{'plan_id': plan_id, 'carrera_id': carrera_id, 'turnoexamen_id': turnoexamen_id, 'cboCiclos': cboCiclos},
		  type: 'POST'
		}).done(function(materias) {
			console.log(materias);

			$("#table_asistencias").find("tr:gt(0)").remove();

			$('#cboMaterias').append(
		        $('<option></option>').val(0).html('Seleccionar')
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

    $('#cboPlan').change(function() {
    	limpiar_tabla();

    	$('#cboTurnoExamen').val(0);
		$('#cboMaterias').children().remove().end();
        if ($('#cboPlan').val() == 0) return;

        var plan_id = $('#cboPlan').val();
    	var carrera_id = $('#cboCarrera').val();

    	$('#cboCiclos').children().remove().end();
		if ($('#cboOrganizacion').val() == 0) return;

		$.ajax({
		  url: '{{url('ciclolectivo/obtenercicloslectivos')}}',
		  data:{'organizacion_id': $('#cboOrganizacion').val()},
		  type: 'POST'
		}).done(function(ciclos) {
			console.log(ciclos);

			if (ciclos == <?php echo CicloLectivoController::NO_EXISTE_CICLO ?>) {
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

    $('#cboCiclos').change(function() {
    	limpiar_tabla();

    	$('#cboTurnoExamen').val(0);
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
