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
					Informes <small>informe de alumnos por ciclo lectivo (pdf)</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('informes/alumnos')}}">Informes</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('alumnos/listado')}}">Alumnos</a>
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
					    @if (Session::get('message_type') == AlumnosController::OPERACION_EXITOSA)

					        <div class="note note-success">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == AlumnosController::OPERACION_FALLIDA)

					        <div class="note note-danger">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == AlumnosController::OPERACION_CANCELADA)

					        <div class="note note-warning">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == AlumnosController::OPERACION_INFO)

					        <div class="note note-info">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@endif
					@endif
					<!-- COMIENZO DE LA TABLA-->
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-files-o"></i>Informe de Alumnos por Ciclo Lectivo
							</div>
							<!--div class="actions">
								<a href="{{url('matriculas/pagar')}}" {{$disabled}} class="btn default blue-stripe">
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Pagar </span>
								</a>
								<a href="{{url('matriculas/imprimir')}}" {{$imprimir}} class="btn default yellow-stripe">
								<i class="fa fa-print"></i>
								<span class="hidden-480">
								Imprimir </span>
								</a>								
							</div-->
						</div>
						<div class="portlet-body form">
							<div class="form-body">
								{{ Form::open(array('url'=>'alumnos/informealumnosporciclolectivo', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmListadoalumnos', 'name'=>'FrmListadoalumnos'))}}
								<div class="form-group">
									<label  class="col-md-2 col-sm-2 control-label">Organización:</label>
									<div class="col-md-6 col-sm-6">
										{{ Form::select('cboOrganizacion', $organizaciones, Input::old('organizacion'), array('class'=>'table-group-action-input form-control','id'=>'cboOrganizacion')); }}
									</div>
									<!--div class="col-md-4 col-sm-4 col-xs-12">
										<center>
											<p><span class="text-success"><i class="fa fa-check"></i></span> Pagado - <span class="text-danger"><i class="fa fa-exclamation-triangle"></i></span> Adeuda - <span class="text-info"><i class="fa fa-asterisk"></i></span> Becado</p>
										</center>
									</div-->
								</div>

								<div class="form-group">
									<label class="col-md-2 col-sm-2 control-label" for="filtro">Ciclo Lectivo:</label>
									<div class="col-md-2 col-sm-3">
										<select name="cboCiclo" id="cboCiclo" class="table-group-action-input form-control">
										</select>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 col-sm-2 control-label" for="cbocarrera">Carrera:</label>
									<div class="col-md-6 col-sm-6">
										<select name="cboCarrera" id="cboCarrera" class="table-group-action-input form-control">
										</select>
									</div>
									<div class="col-md-2 col-sm-2">
										<a class="btn btn-primary" id='btnBuscar'><i class="fa fa-search"></i> Buscar</a>
									</div>
										<div id="divbtnImprimir" class="col-md-2 col-sm-2">
											<a target="_blank" href="#" id="imprimir" class="btn btn-success"><i class="fa fa-print"></i> Imprimir</a>
										</div>
								</div>

								{{ Form::close() }}
							</div>
							<table class="table table-striped table-bordered table-hover" id="table_matriculas">
									<thead>
										<tr>
											<th>
												 <center><i class="fa fa-tags"></i> Apellido y Nombre</center>
											</th>
											<th>
												 <center><i class="fa fa-list-ol"></i> DNI</center>
											</th>
											<th>
												 <center><i class="fa fa-female"></i></i> Sexo</center>
											</th>
											<th>
												 <center><i class="fa fa-language"></i> Dirección</center>
											</th>
											<th>
												 <center><i class="fa fa-language"></i> Localidad</center>
											</th>
											<th>
												 <center><i class="fa fa-phone"></i> Teléfono</center>
											</th>
											<th>
												 <center><i class="fa fa-envelope"></i> E-mail</center>
											</th>								
										</tr>
									</thead>
									<tbody>
								<!--<tr class="success">
									<td>
										Apellido y Nombre
									</td>
									<td>
										00.000.000
									</td>
									<td>
										<center><i class="fa fa-check"></i></center>
									</td>
									<td>
										<center><i class="fa fa-check"></i></center>
									</td>
									<td>
										&nbsp;
									</td>
									<td>
										&nbsp;
									</td>
									<td>
										&nbsp;
									</td>
								</tr-->
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

@stop


@section('customjs')
	TableAdvanced.init();
	$('#cboOrganizacion').select2({
		placeholder: "Seleccione",
		allowClear: true
	});

	$('#divbtnImprimir').hide();

    $('#btnBuscar').click(function() {

		var class_matricula = '';
		var td_cuota = '';

    	var organizacion = $('#cboOrganizacion').val();
    	var ciclo = $('#cboCiclo').val();
    	var carrera = $('#cboCarrera').val();

    	if (organizacion == 0 || carrera == 0 || ciclo == 0) {
    	    alert('Debe seleccionar todos los datos a buscar');
    	    return;
    	}

    	$('#divbtnImprimir').show();

    	limpiar_tabla();

    	$.ajax({
		  url: '{{url('inscripciones/obtenerinscripciones')}}',
		  data:{'organizacion': organizacion, 'ciclo': ciclo, 'carrera': carrera},
		  type: 'POST'
		}).done(function(inscripciones) {
			console.log(inscripciones);

				$.ajax({
				  url: '{{url('alumnos/obtenerinscripcioncontacto')}}',
				  data:{'organizacion': organizacion, 'ciclo': ciclo, 'carrera': carrera},
				  type: 'POST'
				}).done(function(contactos) {
					console.log(contactos);

						$.each(inscripciones, function(key, inscripcion) {
							var telefono = 'No cargado';
							var correo = 'No cargado';

							$.each(contactos, function(key, contacto) {
							    if (inscripcion.alumno_id == contacto.alumno_id) {
									if (contacto.contacto_id == 1) {
										telefono = contacto.contacto;
									}
								    if (contacto.contacto_id == 2) {
										telefono = contacto.contacto;
									}
								    if (contacto.contacto_id == 3) {
										correo = contacto.contacto;
									}
								}
							});

							if (inscripcion.barrio==null) {
								barrio = 'B° no cargado - ';
							} else {
								barrio = inscripcion.barrio + ' - ';
							}

							if (inscripcion.calle=="") {
								calle = 'Calle no cargado ';
							} else {
								calle = inscripcion.calle;
							}

							if (inscripcion.calle_numero==0) {
								numero = ' s/n';
							} else {
								numero = ' N: ' + inscripcion.calle_numero;
							}

							if (inscripcion.manzana==0) {
								manzana = '';
							} else {
								manzana = ' - Mz: ' + inscripcion.manzana;
							}

							if (inscripcion.departamento==0) {
								departamento = '';
							} else {
								departamento = ' - dpto: ' + inscripcion.departamento;
							}

							$('#table_matriculas > tbody').append(
							    '<tr>' +
							    '<td>' + inscripcion.apellido + ', ' + inscripcion.nombre + '</td>' +
							    '<td>' + inscripcion.nrodocumento + '</td>' +
							    '<td>' + inscripcion.sexo + '</td>' +
							    '<td>' + barrio + calle + numero + manzana + departamento + '</td>' +
							    '<td>' + inscripcion.localidad + '</td>' +
							    '<td>' + telefono + '</td>' +
							    '<td>' + correo + '</td>' +
							    '</tr>'
							);
						});

				}).error(function(data) {
					console.log(data);
				});

		}).error(function(data) {
			console.log(data);
		});

    });

    $('#cboCarrera').change(function() {

    	limpiar_tabla();

        if ($('#cboCarrera').val() == 0) return;

    });

    $('#cboCiclo').change(function() {

        $('#cboCarrera').children().remove().end();

		limpiar_tabla();

        if ($('#cboCiclo').val() == 0) return;

		$.ajax({
		  url: '{{url('inscripciones/obtenercarrerasporciclo')}}',
		  data:{'ciclo_lectivo_id': $('#cboCiclo').val()},
		  type: 'POST'
		}).done(function(carreras) {
			console.log(carreras);

			if (carreras == <?php echo InscripcionesController::NO_TIENE_INSCRIPCION  ?>) {
				alert('Este Ciclo Lectivo no tiene Carreras con Alumnos inscritos');
				return;
			}

			$('#cboCarrera').append(
		        $('<option></option>').val(0).html('Seleccionar')
		    );

			$.each(carreras, function(key, value) {
				$('#cboCarrera').append(
			        $('<option></option>').val(value.carrera_id).html(value.carrera)
			    );
			});
		}).error(function(data) {
			console.log(data);
		});

    });

    $('#cboOrganizacion').change(function() {
    	// 1 - limpiar todo

    	limpiar_tabla();
		$('#cboCiclo').children().remove().end();
		$('#cboCarrera').children().remove().end();

		if ($('#cboOrganizacion').val() == 0) return;

		$.ajax({
		  url: '{{url('ciclolectivo/obtenercicloslectivos')}}',
		  data:{'organizacion_id': $('#cboOrganizacion').val()},
		  type: 'POST'
		}).done(function(ciclos) {
			console.log(ciclos);
			if (ciclos == <?php echo CicloLectivoController::NO_EXISTE_CICLO ?>) {
				alert('La Organización no tiene Ciclos Lectivos Asignados');
				return;
		    }

			$('#cboCiclo').append(
		        $('<option></option>').val(0).html('Seleccionar')
		    );

			$.each(ciclos, function(key, value) {
				$('#cboCiclo').append(
			        $('<option></option>').val(value.id).html(value.descripcion)
			    );
			});
		}).error(function(data) {
			console.log(data);
		});

    });

    function limpiar_tabla() {
	    var n = 0;
		$('#table_matriculas tr').each(function() {
		   if (n > 0) $(this).remove();
		   n++;
		});
    }

    $('#imprimir').on('click', function(e){
		e.preventDefault();
		window.open("{{url('alumnos/informecontactospdf')}}?carrera=" + $('#cboCarrera').val() + "&filtro=" + $("#cboCiclo").val() + "&nombrecarrera=" + $('#cboCarrera option:selected').text());
	});

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
@stop
