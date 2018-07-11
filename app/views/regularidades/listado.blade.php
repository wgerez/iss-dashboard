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
					Boletines <small> Examen Parcial</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('regularidades/listado')}}">Examen Parcial</a>
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
					    @if (Session::get('message_type') == RegularidadesController::OPERACION_EXITOSA)

					        <div class="note note-success">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == RegularidadesController::OPERACION_FALLIDA)

					        <div class="note note-danger">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == RegularidadesController::OPERACION_CANCELADA)

					        <div class="note note-warning">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == RegularidadesController::OPERACION_INFO)

					        <div class="note note-info">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@endif
					@endif
					<!-- COMIENZO DE LA TABLA-->
								{{ Form::open(array('url'=>'regularidades/listado', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmListadoregularidades', 'name'=>'FrmListadoalumnos'))}}
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-files-o"></i> Examen Parcial
							</div>
							<div class="actions">
								<!--a href="#" {{$disabled}} id="guardar" class="btn default blue-stripe">
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Guardar </span>
								</a-->
								<a href="{{url('regularidades/crear')}}" {{ $disabled }} class="btn default blue-stripe">
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Nuevo </span>
								</a>
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

									<div class="<?php if ($errors->has('cboCiclos')) echo 'has-error' ?>" >
										<label class="col-md-2 col-sm-2 control-label">Ciclo Lectivo:</label>
										<div class="col-md-2 col-sm-2">
											<select class="table-group-action-input form-control" name="cboCiclos" id="cboCiclos">
												<option value="0">Seleccione</option>
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
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 col-sm-2 control-label" for="cboMaterias">Materias:</label>
									<div class="col-md-6 col-sm-6">
										<select name="cboMaterias" id="cboMaterias" class="table-group-action-input form-control">
											<option value="0">Seleccione</option>
											@if (isset($materias))
												@foreach ($materias as $materia)
													<option value="{{$materia->id}}" <?php if ($materia->id == $materia_id) echo "selected"; ?>>{{$materia->nombremateria}}</option>
												@endforeach
											@endif
										</select>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 col-sm-2 control-label" for="cboDocente">Docente:</label>
									<div class="col-md-6 col-sm-6">
										<select name="cboDocente" id="cboDocente" class="table-group-action-input form-control" readonly>
											<option value="0">Seleccione</option>
											@if (isset($docentes))
												@foreach ($docentes as $docente)
													<option value="{{$docente['id']}}" <?php if ($docente['id'] == $docente_id) echo "selected"; ?>>{{$docente['apeynom']}}</option>
												@endforeach
											@endif
										</select>
									</div>
								</div>

							</div>
							<div class="portlet-body">
								<div class="box-body table-responsive no-padding">
									<table class="table table-striped table-bordered table-hover" id="table_regularidades">
										<thead>
										<tr>
											<th>
												<center><i class="fa fa-users"></i> Alumno</center>
											</th>
											<th>
												<center><i class="fa fa-files-o"></i> Parcial</center>
											</th>
											<th>
												<center><i class="glyphicon glyphicon-sort-by-order-alt"></i> Calificación</center>
											</th>
											<th>
												<center><i class="glyphicon glyphicon-sort-by-order-alt"></i> Nota</center>
											</th>
											<th>
												<center><i class="fa fa-files-o"></i> Recuperatorio</center>
											</th>
											<th>
												<center><i class="glyphicon glyphicon-stats"></i> Asistencia %</center>
											</th>
											<th>
												<center><i class="glyphicon glyphicon-check"></i> Regularizó</center>
											</th>
											<th>
												<center><i class="fa fa-calendar"></i> Fecha Parcial</center>
											</th>
											<th>
												<center><i class="glyphicon glyphicon-pencil"></i> Acciones</center>
											</th>
										</tr>
										</thead>
										<tbody>
											@if (isset($regularidades))
												@foreach ($regularidades as $regularidad)
													<tr>
														<td>
															<center>
																{{ $fechadesde }}
															</center>
														</td>
														<td>
															<center>
																{{ $nombremateria }}
															</center>
														</td>
														<td>
															<center>
																{{ $regularidad->parcial }}
															</center>
														</td>
														<td>
															<center>
																{{ $regularidad->calificacion }}
															</center>
														</td>
														<td>
															<center>
																{{ $regularidad->nota }}
															</center>
														</td>
														<td>
															<center>
																{{ $regularidad->recuperatorio }}
															</center>
														</td>
														<td>
															<center>
																{{ $regularidad->regularizo }}
															</center>
														</td>
														<td>
															<center>
																<a href="#" data-id="{{ $regularidad->id }}" class="btn default btn-xs red btnEliminarMaterias"><i title="Eliminar" class="fa fa-trash-o"></i></a>
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

@stop

@section('customjs')
	//TableAdvanced.init();
	
	//$("#imprimir").attr('disabled', 'disabled');
	$("#txtalumno").attr('disabled', 'disabled');
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
		e.preventDefault();
		window.open("{{url('regularidades/imprimir')}}?planID=" + $('#cboPlan').val() + '&carrera_id=' + $('#cboCarrera').val() + '&materia_id=' + $('#cboMaterias').val() + '&docente_id=' + $('#cboDocente').val() + '&ciclo_id=' + $('#cboCiclos').val());
	});

    $('#btnBuscar').click(function() {
    	var ciclo = $('#cboCiclo').val();
    	var carrera = $('#cboCarrera').val();

    });

    $('#cboMaterias').change(function() {
    	limpiar_tabla();

        if ($('#cboMaterias').val() == 0) return;
		$('#cboDocente').children().remove().end();

        var materia_id = $('#cboMaterias').val();
    	var carrera_id = $('#cboCarrera').val();
        var planID = $('#cboPlan').val();
		var cboCiclos = $('#cboCiclos').val();

		$.ajax({
		  url: "{{url('asignardocente/obtenerdocentes')}}",
		  data:{'materia_id': materia_id, 'carrera_id': carrera_id, 'planID': planID},
		  type: 'POST'
		}).done(function(docentes) {
			console.log(docentes);

			//$("#table_regularidades").find("tr:gt(0)").remove();

			$.each(docentes, function(key, value) {
				$('#cboDocente').append(
			        $('<option></option>').val(value.titular_id).html(value.apeynomtitular), $('<option></option>').val(value.provisorio_id).html(value.apeynomprovisorio), $('<option></option>').val(value.suplente_id).html(value.apeynomsuplente)
			    );
			});

			$.ajax({
			  url: "{{url('regularidades/obtenerregularidades')}}",
			  data:{'materia_id': materia_id, 'carrera_id': carrera_id, 'planID': planID, 'cboCiclos': cboCiclos},
			  type: 'POST'
			}).done(function(materias) {
				console.log(materias);

				$("#table_regularidades").find("tr:gt(0)").remove();
				var tablacargada = '';

				$.each(materias, function(key, value) {
					var tabla = '';
					var tabladetalle = '';
					var bandera = true;
					var recuperatorio = '';
					var regularizo = '';
					var calificacion = '';
					var parcial = '';
					var porcentaje_asistencia = value.porcentaje_asistencia;

					tabla = '<tr><td><center>'+value.alumno+'</center></td>';

					$.each(value.regularidad, function(key, regularida) {
						if (regularida.recuperatorio > 0) {
							recuperatorio = 'A';
						} else {
							recuperatorio = '-';
						}

						if (regularida.regularizo == 0) {
							regularizo = '-';
						}

						if (regularida.regularizo == 1) {
							regularizo = 'SI';
						}

						if (regularida.regularizo == 2) {
							regularizo = 'NO';
						}

						if (regularida.regularizo == 3) {
							regularizo = 'Promocionó';
						}

						if (regularida.calificacion == 0) {
							calificacion = '-';
						}

						if (regularida.calificacion == 1) {
							calificacion = 'Aprobó';
						}

						if (regularida.calificacion == 2) {
							calificacion = 'Desaprobó';
						}

						if (regularida.calificacion == 3) {
							calificacion = 'Ausente';
						}

						if (regularida.nota == 0) {
							nota = '-';
						}

						if (regularida.nota == 1) {
							nota = '1';
						}

						if (regularida.nota == 2) {
							nota = '2';
						}

						if (regularida.nota == 3) {
							nota = '3';
						}

						if (regularida.nota == 4) {
							nota = '4';
						}

						if (regularida.nota == 5) {
							nota = '5';
						}

						if (regularida.nota == 6) {
							nota = '6';
						}

						if (regularida.nota == 7) {
							nota = '7';
						}

						if (regularida.nota == 8) {
							nota = '8';
						}

						if (regularida.nota == 9) {
							nota = '9';
						}

						if (regularida.nota == 10) {
							nota = '10';
						}

						if (regularida.parcial == 0) {
							parcial = '-';
						} else {
							parcial = regularida.parcial + '°';
						}

						if (bandera == true) {
							tabladetalle = '<td><center>'+parcial+'</center></td><td><center>'+calificacion+'</center></td><td><center>'+nota+'</center></td><td><center>'+recuperatorio+'</center></td><td><center>'+porcentaje_asistencia+' %</center></td><td><center>'+regularizo+'</center></td><td><center>'+regularida.fecha_regularidad+'</center></td><td><center><a title="Modificar" href="{{url('regularidades/editar')}}/'+regularida.id+'" class="btn default btn-xs purple"><i class="fa fa-edit"></i></a></center></td></tr>';
							bandera = false;
						} else {
							tabladetalle = '<tr><td><center></center></td><td><center>'+parcial+'</center></td><td><center>'+calificacion+'</center></td><td><center>'+nota+'</center></td><td><center>'+recuperatorio+'</center></td><td><center>'+porcentaje_asistencia+' %</center></td><td><center>'+regularizo+'</center></td><td><center>'+regularida.fecha_regularidad+'</center></td><td><center><a title="Modificar" href="{{url('regularidades/editar')}}/'+regularida.id+'" class="btn default btn-xs purple"><i class="fa fa-edit"></i></a></center></td></tr>';
						}

						tabla += tabladetalle;
					});

					tablacargada += tabla;
					$("#imprimir").removeAttr("disabled");
				});

				$('#table_regularidades > tbody').append(tablacargada);

				if (tablacargada == '') {
					$("#imprimir").attr('disabled', 'disabled');
				} else {
					$("#imprimir").removeAttr("disabled");
				}

			}).error(function(data) {
				console.log(data);
			});
				
		}).error(function(data) {
			console.log(data);
		});
    });

    $('#cboCiclos').change(function() {
    	limpiar_tabla();

        if ($('#cboCiclos').val() == 0) return;
		$('#cboMaterias').children().remove().end();

        var carrera_id = $('#cboCarrera').val();
        var plan_id = $('#cboPlan').val();
    	var ciclo_id = $('#cboCiclos').val();

		$.ajax({
		  url: "{{url('regularidades/obtenermaterias')}}",
		  data:{'carrera_id': carrera_id, 'plan_id': plan_id, 'ciclo_id': ciclo_id},
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

        if ($('#cboPlan').val() == 0) return;
		$('#cboMaterias').children().remove().end();

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
