@extends('layouts.master')

@section('customstyle')
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/select2/select2.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/jquery-multi-select/css/multi-select.css')}}"/>
<style>
.fixed {
    position:fixed;
    top: 60px;
    right: 20px;
    z-index: 999
}
</style>
<!-- END PAGE LEVEL STYLES -->
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
					Inscripciones <small>inscripción cursado de materias</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('inscripcionmaterias')}}">Inscripciones a Materias</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">Nuevo</a>
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
					    @if (Session::get('message_type') == InscripcionmateriasController::OPERACION_EXITOSA)

							<div class="note note-success">
								<p> {{ Session::get('message') }} </p>
							</div>
						@elseif (Session::get('message_type') == InscripcionmateriasController::OPERACION_FALLIDA)

							<div class="note note-danger">
								<p> {{ Session::get('message') }} </p>
							</div>

						@endif	
					@endif
					<!-- COMIENZO DE LA TABLA-->
					{{ Form::open(array('url'=>'inscripcionmaterias/guardar', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmInscripcionMaterias', 'name'=>'FrmInscripcion'))}}
					
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-info"></i> Inscripción (a cursado)
							</div>
							<div class="actions">
								<a href="{{url('inscripcionmaterias')}}" class="btn default yellow-stripe">
								<i class="fa fa-list"></i>
								<span class="hidden-480">
								Listado </span>
								</a>

								<button id="btnGuardarMaterias" {{ $disabled }} type='submit' class="btn default green-stripe">
								<i class="fa fa-save"></i>
								<span class="hidden-480">
								Guardar </span>
								</button>
								<a target="_blank" href="#" id="imprimir" class="btn default yellow-stripe"  {{ $imprimir }} <?php if ($habilita == false) echo 'disabled' ?>>
								<i class="glyphicon glyphicon-print"></i>
								<span class="hidden-480">
								Imprimir </span>
								</a>
							</div>
						</div>
						<div class="portlet-body form">
							<div class="form-body">
								<div class="form-group">
									<label  class="col-md-2 col-sm-2 control-label">Organización:</label>
									<div class="col-md-6 col-sm-10">
										{{ Form::select('organizacion', $arrOrganizaciones, Input::old('organizacion'), array('class'=>'table-group-action-input form-control','id'=>'organizacion')); }}
									</div>
								</div>


								<div class="form-group">
									<label class="col-md-2 control-label" for="carrera">Carrera:</label>
									<div class="col-md-6 col-sm-10">
										<select name="carreras" id="carreras" class="table-group-action-input form-control">
											<option value="0">Seleccione</option>
											@if (isset($planes))
												@foreach ($carreras as $carrera)
													<option value="{{$carrera->id}}">{{$carrera->carrera}}</option>
												@endforeach
											@endif
										</select>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 control-label" for="planes">Plan de estudios:</label>
									<div class="col-md-4 col-sm-10">
										<select name="planes" id="planEstudio" class="table-group-action-input form-control">
											<option value="0">Seleccione</option>
											@if (isset($planes))
												@foreach ($planes as $plan)
													<option value="{{$plan->id}}">{{$plan->codigoplan}}</option>
												@endforeach
											@endif
										</select>
									</div>
									<!--label class="col-md-2 control-label" for="estadoCiclo">Ciclo lectivo:</label>
									<div class="col-md-4 col-sm-10">
										<label class="control-label text-info" id="estadoCiclo"></label>
									</div-->
								</div>

								<div class="form-group">
									<label class="col-md-2 control-label" for="cboCiclos">Ciclo Lectivo:</label>
									<div class="col-md-4 col-sm-10">
										<select name="cboCiclos" id="cboCiclos" class="table-group-action-input form-control">
											<option value="0">Seleccione</option>
											@if (isset($ciclos))
												@foreach ($ciclos as $ciclo)
													<option value="{{$ciclo->id}}">{{$ciclo->descripcion}}</option>
												@endforeach
											@endif
										</select>
									</div>
								</div>
							</div> <!-- FIN PORTLET-BODY -->
							<!--div class="form-group">
								<label class="col-md-2 control-label" for="tituloplan">Docente:</label>
								<div class="col-md-6 col-sm-10">
									<input type="text" class="form-control" id="docente" name="docente">
								</div>
							</div -->
					</div>
					<br>
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-user"></i> Datos de Inscripcion (Alumno)
							</div>
						</div>											
						<div class="portlet-body form">

							<div class="form-group <?php if ($errors->has('documento')) echo 'has-error' ?> ">
								<label class="col-md-2 control-label" for="documento">DNI:</label>
								<div id="divdni" class="col-md-3">
									<!--input type="text" class="form-control" id="documento" name="documento" -->
									<div class="input-icon right">
										<i id="icodni" class="fa"></i>
										<input type="text" id="documento" name="documento" class="form-control">
										<input type="hidden" name="alumnoid" id="alumnoid" value="">
									</div>
									@if ($errors->has('documento'))
									    <span class="help-block">{{ $errors->first('documento') }}</span>
								    @endif
								</div>
								<div class="col-md-2 col-sm-2">
									<a class="btn btn-primary" id="btnBuscarAlumno"><i class="fa fa-search"></i> Buscar</a>
								</div>								
							</div>

							<div class="form-group">
								<label class="col-md-2 control-label" >Apellido y Nombre:</label>
								<div class="col-md-2 col-sm-6">
									<label id="nombreAlumno" class="control-label text-info" id="nombreAlumno"></label>
								</div>
								<label  class="col-md-2 col-sm-2 control-label">DNI:</label>
								<div class="col-md-2 col-sm-4 text-info" id='divDNI'></div>
								<!--label class="col-md-2 control-label" for="estado">Estado:</label>
								<div class="col-md-2 col-sm-4">
									<label class="control-label text-info" id="estado"></label>
								</div-->
							</div>

							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2">Materias Disponibles:</label>
								<div class="col-md-8 col-sm-8">
									{{ Form::select('materiasdisponibles[]', array(), Input::old('materiasdisponibles'), array('class'=>'table-group-action-input form-control multi-select','id'=>'materiasdisponibles', 'multiple'=>'multiple', $disabled)); }}
								</div>
								<div class="col-md-2 col-sm-2">
									<label class="pull-left">Materias Asignadas</label>
								</div>
							</div>
						</div>


								<!--TABLA DE PERMISOS-->
								<table class="table table-hover" id="table_permisos">
									<thead>
									<tr>
										<th>
											<center><i class="fa fa-calendar"></i> Fecha</center>
										</th>
										<th>
											<center><i class="fa fa-indent"></i> Carrera</center>
										</th>
										<th class="hidden-xs">
											<center><i class="fa fa-calendar"></i> Año Cursado</center>
										</th>
										<th>
											<center><i class="fa fa-edit"></i> Plan/Estudio</center>
										</th>
										<th>
											<center><i class="fa fa-edit"></i> Ciclo Lectivo</center>
										</th>
										<th>
											<center><i class="fa fa-list-ol"></i> Materias Asignadas</center>
										</th>
										<!--th>
											<center><i class="fa fa-print"></i> Acciones</center>
										</th-->
									</tr>
									</thead>
										<tbody>

										</tbody>
									</table>
									<!-- FIN TABLA DE PERMISOS -->



								</div>
						
					</div>
					{{ Form::close()}}
				</div>
			</div>
			<!-- FIN DEL CONTENIDO -->
		</div>
	</div>
	<!-- FIN -->


	<!-- MODAL AVISO DE ALUMNO NO INSCRIPTO-->
	<div class="modal fade" id="modalAviso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">AVISO</h4>
					</div>
					<div class="modal-body">
					<p>El Plan de Estudio no tiene asignado la carrera.</p>
					</div>
					<div class="modal-footer">
						<button type="button" data-dismiss="modal" class="btn default"><i class="fa fa-times-circle-o"></i> Cancelar</button>
					</div>
				</div>
			</div>
	</div>
	<!-- FIN DEL MODAL FORM-->


	<!-- MODAL AVISO DE INGRESO DE DNI-->
	<div class="modal fade" id="modalAvisoDni" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">AVISO</h4>
					</div>
					<div class="modal-body">
					<p>Por favor, ingrese un DNI válido, sin puntos.</p>
					</div>
					<div class="modal-footer">
						<button type="button" data-dismiss="modal" class="btn default"><i class="fa fa-times-circle-o"></i> Cancelar</button>
					</div>
				</div>
			</div>
	</div>
	<!-- FIN DEL MODAL FORM-->	

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
		{{ Form::open(array('url' => 'inscripcionmaterias/borrar')) }}
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
	ValidForm.init();

	//$("#imprimir").attr('disabled', 'disabled');

	$('#materiasdisponibles').change(function() {
		//$('#finales').multiSelect('deselect_all');
		var materiasdisponibles = $('#materiasdisponibles').val();
		
		if (materiasdisponibles) {
			$.each(materiasdisponibles, function(key, value){
				$.ajax({
					url: "{{url('inscripcionmaterias/obtenercorrelatividad')}}",
					data: {'alumnoid': $('#alumnoid').val(), 'planid': $('#planEstudio').val(), 'cboCiclos': $('#cboCiclos').val(), 'carrera_id': $('#carreras').val(), 'materiasdisponibles': value},
					type: 'POST'					
				}).done(function(materias){
					console.log(materias);

						if (materias == 0) {
							$('#materiasdisponibles').multiSelect('deselect', value);
							$('#divMensaje').html('<p class="form-control-static"><h4>' + 'No cumple con los requisitos para inscribirse!' + '</h4></p>');
			    			$('#MensajeCantidad').modal('show');
						}

				}).error(function(data) {
					console.log(data);
				});
			})	
		}
	});

	var url_destino = "{{url('alumnos/obteneralumnopordni')}}";
	var url_alumno = "{{url('inscripcionmaterias/alumnoinscripto')}}";
	var url_materia = "{{url('inscripcionmaterias/materiasdecarrera')}}";

	$('#imprimir').on('click', function(e){
		e.preventDefault();
		window.open("{{url('inscripcionmaterias/pdfimprimirlistado')}}?organizacion=" + $('#organizacion').val() + '&planEstudio=' + $('#planEstudio').val() + '&cboCiclos=' + $('#cboCiclos').val() + '&carreras=' + $('#carreras').val() + '&alumnoid=' + $('#alumnoid').val() + '&documento=' + $('#documento').val());
	});

	$("#btnBuscarAlumno").on('click', function(){
	    if ($('#planEstudio').val() == '0') {
    		$('#divMensaje').html('<p class="form-control-static"><h4>' + 'Debe seleccionar los datos a buscar' + '</h4></p>');
    		$('#MensajeCantidad').modal('show');
	    	return;
	    }

	    if ($('#carreras').val() == '0') {
    		$('#divMensaje').html('<p class="form-control-static"><h4>' + 'Debe seleccionar los datos a buscar' + '</h4></p>');
    		$('#MensajeCantidad').modal('show');
	    	return;
	    }

	    if ($("#documento").val() == '') {
			$('#modalAvisoDni').modal('show');		
			$('#nombreAlumno').text("");
			return false;
		}
		
		if ($('#cboCiclos').val() == '0') {
    		$('#divMensaje').html('<p class="form-control-static"><h4>' + 'Debe seleccionar los datos a buscar' + '</h4></p>');
    		$('#MensajeCantidad').modal('show');
	    	return;
	    }

		Ejecutarbusqueda();
	});

	function Ejecutarbusqueda() {
		$('#estado').removeClass( "text-info" ).addClass( "text-danger" ).text('');
		$("#imprimir").attr('disabled', 'disabled');

		$.ajax({
			url: url_destino,
			data: {'txt_alumno': $("#documento").val()},
			type: 'POST',
			dataType: 'json',
			cache: false	
		}).done(function(alumno){

			if (alumno.apellido!=undefined)	{
				var name = alumno.apellido + ", " + alumno.nombre;
				var alumnoid = alumno.alumno_id;
				$('#alumnoid').val(alumno.alumno_id);
				name.toUpperCase();
				$('#nombreAlumno').text(name);
				$('#divDNI').html('<p class="form-control-static">' + alumno.nrodocumento + '</p>');
				$('#icodni').removeClass('fa-warning').addClass("fa-check");
				$('#divdni').removeClass('has-error').addClass("has-success");

				//UNA VEZ QUE SE DETECTA AL ALUMNO, COMPROBAMOS SI TIENE ABONADO LA MATRICULA
				$.ajax({
					url: "{{url('inscripcionmaterias/obtenermatricula')}}",
					data: {'alumnoid': $('#alumnoid').val(), 'plan_id': $('#planEstudio').val(), 'carrera_id': $('#carreras').val(), 'cboCiclos': $('#cboCiclos').val()},
					type: 'POST',
					dataType: 'json',
					cache: false					
				}).done(function(matricula){
					console.log(matricula);

					if (matricula == 0) {
						$('#materiasdisponibles').children().remove().end();
						$('#materiasdisponibles').multiSelect('refresh');
						$('#divMensaje').html('<p class="form-control-static"><h4>' + 'EL ALUMNO NO TIENE ABONADO LA MATRICULA' + '</h4></p>');
			    		$('#MensajeCantidad').modal('show');
				    	return;
					}

					//UNA VEZ QUE SE DETECTA AL ALUMNO, COMPROBAMOS SI ESTÁ INSCRIPTO EN LA CARRERA SELECCIONADA
					$.ajax({
						url: url_alumno,
						data: {'alumnoid': $('#alumnoid').val(), 'plan_id': $('#planEstudio').val(), 'carrera_id': $('#carreras').val(), 'cboCiclos': $('#cboCiclos').val()},
						type: 'POST',
						dataType: 'json',
						cache: false					
					}).done(function(materias){
						console.log(materias);
						$('#table_permisos tbody tr').each(function() {
						      $(this).remove();
						});					
						if (materias.length > 0) {
		        			$('#materiasdisponibles').children().remove().end();
		        			//$('#materiasdisponibles').multiSelect('refresh');
							$.each(materias, function(key, value) {
								if (value.selected) {
									$('#materiasdisponibles').append(
									    $('<option selected></option>').val(value.id).html(value.nombre)
								    );

									$('#table_permisos > tbody:last-child').append('<tr><td><center>'+ value.fecha +'</center></td><td><center>'+ value.carrera +'</center></td><td><center>'+ value.anio +'°</center></td><td><center>'+ value.plan +'</center></td><td><center>'+ value.ciclo +'</center></td><td><center>'+ value.nombre +'</center></td><!--td><center><a href="#" data-id="'+ value.id +'" class="btn default btn-xs red btnEliminarMaterias"><i title="Eliminar" class="fa fa-trash-o"></i></a></center></td--></tr>');

									$('#imprimir').removeAttr("disabled",'false');
								} else {
									$('#materiasdisponibles').append(
									    $('<option></option>').val(value.id).html(value.nombre)
								    );
							    }
							});
							$('#materiasdisponibles').multiSelect('refresh');
						} else {
							$('#materiasdisponibles').children().remove().end();
							$('#materiasdisponibles').multiSelect('refresh');
							$('#modalAviso').modal('show');
						}

					}).error(function(err){
						console.log(err);
					});
				}).error(function(err){
					console.log(err);
				});
			} else {
				$('#icodni').removeClass('fa-check').addClass("fa-warning");
				$('#divdni').removeClass('has-success').addClass("has-error");
				$('#nombreAlumno').text('El DNI no pertenece a un alumno.');
    			$('#materiasdisponibles').children().remove().end();
    			$('#materiasdisponibles').multiSelect('refresh');
    			$("#imprimir").attr('disabled', 'disabled');
    			$('#table_permisos tbody tr').each(function() {
				      $(this).remove();
				});
			}
		});
	}

	$('#cboCiclos').on('change', function() {
		$('#estadoCiclo').removeClass( "text-info" ).addClass( "text-danger" ).text('');
		if ($('#cboCiclos').val() == 0) return;
		
		$('#materiasdisponibles').children().remove().end();
		$('#materiasdisponibles').multiSelect('refresh');
		$('#table_permisos tbody tr').each(function() {
		    $(this).remove();
		});
		$('#nombreAlumno').text('');
		$('#divDNI').html('<p class="form-control-static"></p>');
	});

	$('#planEstudio').on('change', function() {
		$('#estadoCiclo').removeClass( "text-info" ).addClass( "text-danger" ).text('');
		$('#cboCiclos').children().remove().end();
		if ($('#organizacion').val() == 0) return;

		$.ajax({
		  url: '{{url('ciclolectivo/obtenercicloslectivos')}}',
		  data:{'organizacion_id': $('#organizacion').val()},
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

		$('#materiasdisponibles').children().remove().end();
		$('#materiasdisponibles').multiSelect('refresh');
		$('#table_permisos tbody tr').each(function() {
		    $(this).remove();
		});
		$('#nombreAlumno').text('');
		$('#divDNI').html('<p class="form-control-static"></p>');
	});

	$('#materiasdisponibles').multiSelect();

	//optengo las materias que corresponden a la carrera
	$('#carreras').on('change', function(){
        $('#materiasdisponibles').children().remove().end();
        $('#materiasdisponibles').multiSelect('refresh');	
		//////////////////////////////
		if ($('#carreras').val() == 0) return;
		$('#planEstudio').children().remove().end();

        var carrera_id = $('#carreras').val();

		$.ajax({
		  url: "{{url('asistencias/obtenerplanes')}}",
		  data:{'carrera_id': carrera_id},
		  type: 'POST'
		}).done(function(planes) {
			console.log(planes);

			$('#planEstudio').append(
		        $('<option></option>').val(0).html('Seleccionar')
		    );

			$.each(planes, function(key, value) {
				$('#planEstudio').append(
			        $('<option></option>').val(value.id).html(value.codigoplan)
			    );
			});

		}).error(function(data) {
			console.log(data);
		});

		$('#materiasdisponibles').children().remove().end();
		$('#materiasdisponibles').multiSelect('refresh');
		$('#table_permisos tbody tr').each(function() {
		    $(this).remove();
		});
		$('#nombreAlumno').text('');
		$('#divDNI').html('<p class="form-control-static"></p>');
		////////////////////////////////////

		/*var carreraid = $(this).val();
		$.ajax({
			url: url_materia,
			data: {'carreraid': carreraid},
			type: 'POST',
			dataType: 'json',
			cache: false	
		}).done(function(materias){
			//console.log(materias);
			$.each(materias, function(key, value) {
				$('#materiasdisponibles').append(
				    $('<option></option>').val(value.id).html(value.nombremateria)
			    );
			});

			$('#materiasdisponibles').multiSelect('refresh');

		}).error(function(err){
			console.log("Error: "+err);
		});*/
	});

    $('#organizacion').change(function() {
		$('#carreras').children().remove().end();

		if ($('#organizacion').val() == 0) return;
		
		$.ajax({
		  url: "{{url('organizacions/obtenercarreras')}}",
		  data:{'organizacion_id': $('#organizacion').val()},
		  type: 'POST'
		}).done(function(carreras) {
			console.log(carreras);
			if (carreras == <?php echo OrganizacionsController::NO_TIENE_CARRERAS ?>) {
				$('#modalMensajes').modal('show');
				return;
		    }

			$('#carreras').append(
		        $('<option></option>').val(0).html('Seleccionar')
		    );

			$.each(carreras, function(key, value) {
				$('#carreras').append(
			        $('<option></option>').val(value.id).html(value.carrera)
			    );
			});
		}).error(function(data){
			console.log(data);
		});
    });

	$('#organizacion, #carreras').select2({
		placeholder: "Seleccione",
		allowClear: true
	});

	$('#plan').select2({
		placeholder: "Seleccione",
		allowClear: true
	});	


	//Emular Tab al presionar Enter
	$('input').keydown( function(e) {
	        var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
	        if(key == 13) {
	            e.preventDefault();
	            var inputs = $(this).closest('form').find(':input:visible');
	            inputs.eq( inputs.index(this)+ 1 ).focus();
	        }
	 });

	$('.btnEliminarMaterias').live('click', function(){
		$('#idMateriaHidden').val($(this).data('id'));
		$('#modalEliminaMateria').modal('show');
	});

	

@stop

@section('includejs') 
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{url('assets/global/plugins/select2/select2.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js')}}"></script>
<script src="{{url('assets/admin/layout/scripts/menusticky.js')}}" type="text/javascript"></script>
<script src="{{url('assets/global/plugins/jquery-validation/js/jquery.validate.min.js')}}" type="text/javascript"></script>
<script src="{{url('assets/admin/pages/scripts/validation-form-inscripcion-materias.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
@stop
