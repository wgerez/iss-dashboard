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
					Inscripciones <small>inscripción a final</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('materias/listado')}}">Materias</a>
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
					    @if (Session::get('message_type') == InscripcionFinalesController::OPERACION_EXITOSA)

							<div class="note note-success">
								<p> {{ Session::get('message') }} </p>
							</div>
						@elseif (Session::get('message_type') == InscripcionFinalesController::OPERACION_FALLIDA)

							<div class="note note-danger">
								<p> {{ Session::get('message') }} </p>
							</div>

						@endif	
					@endif
					<!-- COMIENZO DE LA TABLA-->
					{{ Form::open(array('url'=>'inscripcionfinal/guardar', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmInscripcion', 'name'=>'FrmInscripcion'))}}
					
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-info"></i> Inscripción (a finales)
							</div>
							<div class="actions">
								<a href="{{url('inscripcionfinal')}}" {{ $disabled }} class="btn default yellow-stripe">
								<i class="fa fa-list"></i>
								<span class="hidden-480">
								Listado </span>
								</a>

								<button id="guardar" {{ $disabled }} type='submit' class="btn default green-stripe">
								<i class="fa fa-save"></i>
								<span class="hidden-480">
								Guardar </span>
								</button>
								<a target="_blank" href="#" id="imprimir" {{$imprimir}} class="btn default yellow-stripe">
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
										<div class="col-md-6 col-sm-10">
											{{ Form::select('organizacion', $arrOrganizaciones, Input::old('organizacion'), array('class'=>'table-group-action-input form-control','id'=>'organizacion')); }}
										</div>
									</div>


									<div class="form-group">
										<label class="col-md-2 control-label" for="carrera">Carrera:</label>
										<div class="col-md-6 col-sm-10">
											<select name="carreras" id="carreras" class="table-group-action-input form-control">
												<option value="0">Seleccione</option>
												
											</select>
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-2 control-label" for="carrera">Plan de estudios:</label>
										<div class="col-md-2 col-sm-10">
											<select name="planes" id="planes" class="table-group-action-input form-control">
												<option value="0">Seleccione</option>
											</select>
										</div>
										<label class="col-md-2 control-label" for="carrera">Ciclo lectivo:</label>
										<div class="col-md-4 col-sm-10">
											<label class="control-label text-info" id="estadoCiclo"></label>
										</div>										
									</div>	
									<div class="form-group">
									<label  class="col-md-2 col-sm-2 control-label">Turnos de Examenes:</label>
									<div class="col-md-2 col-sm-4">
										<select name="turnos" id="turnos" class="table-group-action-input form-control">
										<option value="0">Seleccione</option>
									</select>
									</div>
									<!--
									<label  class="col-md-2 col-sm-2 control-label">Ciclo Lectivo:</label>
									<div class="col-md-2 col-sm-4">
										<select name="ciclos" id="ciclos" class="table-group-action-input form-control">
										<option disabled value="0">Seleccione</option>
										@if (isset($ciclos))
											@foreach ($ciclos as $ciclo)
												<option value="{{$ciclo->id}}" <?php if ($ciclo->id == $ciclo_id) echo "selected"; ?>>{{$ciclo->descripcion}}</option>
											@endforeach
										@endif
									</select>
									</div>-->

									<div class="form-group">
										<div class="col-md-6 col-sm-10">
							                <label class="col-md-4 col-sm-4 control-label">1° Llamado
							                    <input type="radio" name="llamado" id="llamado" value="1" checked="true">
							                </label>
							                <label class="col-md-4 col-sm-4 control-label">2° Llamando	
							                    <input type="radio" name="llamado" id="llamado" value="2">
							                </label>
							                @if ($errors->has('llamado'))
												<span class="help-block">{{ $errors->first('llamado') }}</span>
											@endif
										</div>
	        						</div>
									<input type="hidden" name="llamadounico" id="llamadounico" value="">
									<input type="hidden" name="valorllamada" id="valorllamada" value="1">	
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
								<i class="fa fa-user"></i> Datos de Inscripcion (Finales)
							</div>
						</div>											
						<div class="portlet-body form">

							<div class="form-group <?php if ($errors->has('documento')) echo 'has-error' ?> ">
								<label class="col-md-2 control-label" for="documento">DNI:</label>
								<div class="col-md-3">
									<input type="text" class="form-control" id="documento" name="documento">
									@if ($errors->has('documento'))
									    <span class="help-block">{{ $errors->first('documento') }}</span>
								    @endif
								</div>
								<div class="col-md-2 col-sm-2">
									<a class="btn btn-primary" id="search"><i class="fa fa-search"></i> Buscar</a>
								</div>								
							</div>

							<div class="form-group">
								<label class="col-md-2 control-label" >Apellido y Nombre:</label>
								<div class="col-md-3 col-sm-10">
									<label id="nombreAlumno" class="control-label text-info" id="nombreAlumno"></label>
								</div>
								<label class="col-md-2 control-label" >Estado:</label>
								<div class="col-md-3 col-sm-10">
									<label class="control-label text-info">Regular</label>
								</div>								
							</div>

							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2">Materias Disponibles:</label>
								<div class="col-md-8 col-sm-8">
									{{ Form::select('materiasdisponibles[]', array(), Input::old('materiasdisponibles'), array('class'=>'table-group-action-input form-control multi-select','id'=>'materiasdisponibles', 'multiple'=>'multiple')); }}
								</div>
								<div class="col-md-2 col-sm-2">
									<label class="pull-left">Materias Asignadas</label>
								</div>
							</div>
						</div>


								<!--TABLA DE PERMISOS-->
								<table class="table table-hover" id="table_materias">
									<thead>
									<tr>
										<th>
											<center><i class="glyphicon glyphicon-calendar"></i> Fecha Final</center>
										</th>
										<th class="hidden-xs">
											<center><i class="glyphicon glyphicon-calendar"></i> Plan/Estudio</center>
										</th>
										<th>
											<center><i class="fa fa-edit"></i> Materia A Inscribir</center>
										</th>
									</tr>
									</thead>
										<tbody>
											<!-- aca debe ir el bucle para la lista de las materias Diego Maximiliano -->
											<tr>
												<td>
													<center>
													</center>
												</td>
											</tr>
										</tbody>
									</table>
									<!-- FIN TABLA DE PERMISOS -->
								</div>
					<input type="hidden" name="alumno_id" id="alumno_id" value="">	
					</div>
					{{ Form::close()}}
				</div>
			</div>
			<!-- FIN DEL CONTENIDO -->
		</div>
	</div>
	<!-- FIN -->

	<div class="modal fade" id="Mensajes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
@stop


@section('customjs')
	
	$("#imprimir").attr('disabled', 'disabled');
	
	$('#organizacion, #carreras, #planes, #turnos').select2({
		placeholder: "Seleccione",
		allowClear: true
	});
	
	$('#materiasdisponibles').multiSelect();

	//Emular Tab al presionar Enter
	$('input').keydown( function(e) {
        var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
        if(key == 13) {
            e.preventDefault();
            var inputs = $(this).closest('form').find(':input:visible');
            inputs.eq( inputs.index(this)+ 1 ).focus();
        }
	});

	$('#FrmInscripcion').on('submit', function(){
		if (document.getElementById('materiasdisponibles').options.selectedIndex == -1) {
			alert('Seleccione una materia');
			return false;
		}
	});

	$('#organizacion').change(function() {
		if ($('#organizacion').val() == 0) {
			location.reload();
		}
		// para combo ciclo lectivo
		var combociclos = $('#ciclos');
		$.ajax({
		type: "POST",
		url: "{{url('mesaexamenes/obtenerciclos')}}",
		data: { organizacion_id: $('#organizacion').val() }	
		}).done(function(ciclos) {
			console.log(ciclos)
			combociclos.find('option').remove().end()
			combociclos.append('<option value="0" disabled selected>Seleccione</option>');
			combociclos.select2("destroy")
			combociclos.select2()
			
			for (i = 0; i < ciclos.length; i++) {
				if (ciclos[i]['activo'] == 1) {
					$('#estadoCiclo').text(ciclos[i]['descripcion']);	
				} 
			}
			combociclos.select2()
		});

		//

		$('#carreras').find('option').remove().end()
		$('#carreras').append('<option value="0" disabled selected>Seleccione</option>');
		$('#carreras').select2("destroy")
		$('#carreras').select2();
		
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

			$.each(carreras, function(key, value) {
				$('#carreras').append(
			        $('<option></option>').val(value.id).html(value.carrera)
			    );
			});
		}).error(function(data){
			console.log(data);
		});
    });

    $('#carreras').on('change', function(){
    	$('#materiasdisponibles').children().remove().end();
		$('#materiasdisponibles').multiSelect('refresh');
       // para combo plan de estudio
		$.ajax({
		type: "POST",
		url: "{{url('inscripcionfinal/obtenerplanes')}}",
		data: { id: $('#carreras').val() }	
		}).done(function(planes) {
			console.log(planes)
			$('#planes').find('option').remove().end()
			$('#planes').append('<option value="0" disabled selected>Seleccione</option>');
			$('#planes').select2("destroy")
			$('#planes').select2();

			$.each(planes, function(key, value) {
				$('#planes').append(
			        $('<option></option>').val(value.id).html(value.codigoplan)
			    );
			});
			
		}).error(function(data){
			console.log(data);
		});
	});

	$('#planes').on('change', function(){
		$('#materiasdisponibles').children().remove().end();
		$('#materiasdisponibles').multiSelect('refresh');
       // para combo plan de estudio
		$.ajax({
		type: "POST",
		url: "{{url('inscripcionfinal/obtenerturnos')}}",
		//data: { carr_id: $('#carreras').val() , 'plan_id': $('#planes').val() , 'ciclo_id': $('#estadoCiclo').text()}	
		}).done(function(turnos) {
			console.log(turnos)
			$('#turnos').find('option').remove().end()
			$('#turnos').append('<option value="0" disabled selected>Seleccione</option>');
			$('#turnos').select2("destroy")
			$('#turnos').select2();

			$.each(turnos, function(key, value) {
				$('#turnos').append(
			        $('<option></option>').val(value.id).html(value.descripcion)
			    );
			});
			
		}).error(function(data){
			console.log(data);
		});
	});
	
	$('#turnos').on('change', function(){
		$('#materiasdisponibles').children().remove().end();
		$('#materiasdisponibles').multiSelect('refresh');
       // para combo plan de estudio
		$.ajax({
		type: "POST",
		url: "{{url('inscripcionfinal/obtenerllamados')}}",
		data: { id: $('#turnos').val()}	
		}).done(function(resultado) {
			console.log(resultado)

			$('#llamadounico').val(resultado);

		}).error(function(data){
			console.log(data);
		});
	});

	$(document).ready(function(){
		$('input[name=llamado]').click(function () {
        	$('#valorllamada').val($(this).val());
    	});
	});

	var url_destino = "{{url('alumnos/obteneralumnopordni')}}";

	$('#search').on('click', function(){
		$("#imprimir").attr('disabled', 'disabled');

		if ($("#turnos").val() == 0 || $("#turnos").val() == null) {
			$('#divMensaje').html('<p class="form-control-static"><h4>' + 'Seleccione un turno de examen antes de realizar esta busqueda!' + '</h4></p>');
			$('#Mensajes').modal('show');	
			$('#nombreAlumno').text("");
			return false;
		}

		if ($("#planes").val() == 0 || $("#planes").val() == null) {
			$('#divMensaje').html('<p class="form-control-static"><h4>' + 'Seleccione un plan de estudio antes de realizar esta busqueda!' + '</h4></p>');
			$('#Mensajes').modal('show');	
			$('#nombreAlumno').text("");
			return false;
		}

		if ($("#carreras").val() == 0 || $("#carreras").val() == null) {
			$('#divMensaje').html('<p class="form-control-static"><h4>' + 'Seleccione una carrera antes de realizar esta busqueda!' + '</h4></p>');
			$('#Mensajes').modal('show');	
			$('#nombreAlumno').text("");
			return false;
		}

		if (document.getElementById('documento').value.length < 8 || document.getElementById('documento').value == "") {
			//alert('Ingrese un DNI válido');
			$('#divMensaje').html('<p class="form-control-static"><h4>' + 'Ingrese un DNI válido!' + '</h4></p>');
			$('#Mensajes').modal('show');			
			$('#nombreAlumno').text("");
			return false;
		}
		
		$('#table_materias tbody tr').each(function() {
		    $(this).remove();
		});

		$.ajax({
			url: url_destino,
			data: {'txt_alumno': $("#documento").val()},
			type: 'POST',
			dataType: 'json',
			cache: false	
		}).done(function(alumno){
			if (alumno.apellido == undefined && alumno.nombre == undefined) {
				$('#nombreAlumno').text('no se encontro el alumno');
				$('#materiasdisponibles').children().remove().end();
				$('#materiasdisponibles').multiSelect('refresh');
				return false;
			}
			var name = alumno.apellido + ", " + alumno.nombre;
			name.toUpperCase();
			$('#nombreAlumno').text(name);
			$('#alumno_id').val(alumno.alumno_id);

			$.ajax({
	      	  type: "POST",
			  url: "{{url('inscripcionfinal/obtenermesas')}}",
			  data: { id: $('#carreras').val(), plan_id: $('#planes').val() , ciclo_id: $('#estadoCiclo').text() , turno_id: $('#turnos').val(), alumno_id: alumno.alumno_id, llamado: $('#llamado').val()}	
			}).done(function(mesas) {
				console.log(mesas);
				
				if (mesas == 1) {
					$('#divMensaje').html('<p class="form-control-static"><h4>' + 'No se encontraron mesas de examenes con estos parametros!' + '</h4></p>');
					$('#Mensajes').modal('show');
				} else if (mesas == 2) {
					$('#divMensaje').html('<p class="form-control-static"><h4>' + 'El alumno adeuda matricula!' + '</h4></p>');
					$('#Mensajes').modal('show');
				} else if (mesas == 3) {
					$('#divMensaje').html('<p class="form-control-static"><h4>' + 'El alumno adeuda cuota!' + '</h4></p>');
					$('#Mensajes').modal('show');
				} else if (mesas == 4) {
					$('#divMensaje').html('<p class="form-control-static"><h4>' + 'El alumno adeuda derecho de examen!' + '</h4></p>');
					$('#Mensajes').modal('show');
				} else if (mesas == '') {
					$('#divMensaje').html('<p class="form-control-static"><h4>' + 'No se encontraron materias en las que el alumno este como regular con estos parametros!' + '</h4></p>');
					$('#Mensajes').modal('show');
				} else {
					var arrayJS= mesas;
				
					$('#materiasdisponibles').children().remove().end();

					$.each(arrayJS, function(key, value){
						$("#materiasdisponibles").append('<option value="'+value.id+'">'+value.materia+'</option>');
					});

					$('#materiasdisponibles').multiSelect('refresh');
				}

			}).error(function(data) {
				console.log(data);
			});

			$.ajax({
	      	  type: "POST",
			  url: "{{url('inscripcionfinal/obtenerinscripciones')}}",
			  data: { id: $('#carreras').val(), plan_id: $('#planes').val() , ciclo_id: $('#estadoCiclo').text() , turno_id: $('#turnos').val(), alumno_id: alumno.alumno_id, llamado: $('#llamado').val()}	
			}).done(function(materias) {
				console.log(materias);

				//alert(materias);
				$('#table_materias tbody tr').each(function() {
					      $(this).remove();
					});					
					if (materias.length > 0) {
						$.each(materias, function(key, value) {
							$('#table_materias > tbody:last-child').append('<tr><td><center>'+ value.fecha +'</center></td><td><center>'+ value.plan +'</center></td><td><center>'+ value.materia +'</center></td></tr>');
						});

						$('#imprimir').removeAttr("disabled",'false');
					} 
			
			}).error(function(data) {
				console.log(data);
			});
		});
	});

	$('#guardar').on('click', function(){
	    if ($('#llamadounico').val() == 1 &&  $('#valorllamada').val() == 2) {
			$('#divMensaje').html('<p class="form-control-static"><h4>' + 'El turno que selecciono solo tiene un llamado!' + '</h4></p>');
			$('#Mensajes').modal('show');
			return false;
    	} 

        if ($('#materiasdisponibles').val() == null) {
			$('#divMensaje').html('<p class="form-control-static"><h4>' + 'Debe seleccionar al menos una materia!' + '</h4></p>');
			$('#Mensajes').modal('show');
			return false;
    	}
	});
	
	$('#imprimir').on('click', function(e){
		//alert($('#estadoCiclo').text());
		e.preventDefault();
		window.open("{{url('inscripcionfinal/imprimirlistadototal')}}?organizacion=" + $('#organizacion').val() + '& carr_id=' + $('#carreras').val() + '& plan_id=' + $('#planes').val()  + '&ciclo_id=' + $('#estadoCiclo').text() + '& turno_id=' + $('#turnos').val() + '& llamado=' + $('#llamado').val() + '& alumno_id=' + $('#alumno_id').val());
	});

@stop

@section('includejs') 
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{url('assets/global/plugins/select2/select2.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js')}}"></script>
<script src="{{url('assets/admin/layout/scripts/menusticky.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
@stop
