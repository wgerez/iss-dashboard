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
					Examanes <small>Nueva Mesa de Examanes</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
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
							<a href="{{url('mesaexamenes/listado')}}">Mesa Examenes</a>
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
					    @if (Session::get('message_type') == MesaexamenesController::OPERACION_EXITOSA)

					        <div class="note note-success">
								<p>{{ Session::get('message') }}</p>
							</div>

						@elseif (Session::get('message_type') == MesaexamenesController::OPERACION_FALLIDA)

					        <div class="note note-danger">
								<p>{{ Session::get('message') }}</p>
							</div>

						@elseif (Session::get('message_type') == MesaexamenesController::OPERACION_CANCELADA)

					        <div class="note note-warning">
								<p>{{ Session::get('message') }}</p>
							</div>

						@elseif (Session::get('message_type') == MesaexamenesController::OPERACION_INFO)

					        <div class="note note-info">
								<p>{{ Session::get('message') }}</p>
							</div>

						@endif
					@endif
					<!-- COMIENZO DE LA TABLA-->
					{{ Form::open(array('url'=>'mesaexamenes/guardar', 'class'=>'form-horizontal form-row-seperated', 'id'=>'Frmguardar', 'name'=>'Frmguardar'))}}
					
					<div class="portlet">
						<div class="portlet-title">
							<!--<div class="caption">
								<i class="fa fa-info"></i> Inscripción (a cursado)
							</div>-->
							<div class="actions">
								<a href="{{url('mesaexamenes')}}" class="btn default yellow-stripe">
								<i class="fa fa-list"></i>
								<span class="hidden-480">
								Listado </span>
								</a>

								<button id="guardar" {{ $disabled }} type='submit' class="btn default green-stripe">
								<i class="fa fa-save"></i>
								<span class="hidden-480">
								Guardar </span>
								</button>
								
							</div>
						</div>
						<div class="portlet-body form">
							<div class="form-body">
								<div class="form-group">
									<label  class="col-md-2 col-sm-2 control-label">Organización:</label>
									<div class="col-md-6 col-sm-10">
										{{ Form::select('organizacion', $organizaciones, Input::old('organizacion'), array('class'=>'table-group-action-input form-control','id'=>'organizacion')); }}
									</div>
								</div>


								<div class="form-group">
									<label class="col-md-2 control-label" for="carrera">Carrera:</label>
									<div class="col-md-6 col-sm-10">
										<select name="carreras" id="carreras" class="table-group-action-input form-control">
											<option value="0">Seleccione</option>
											@if (isset($carreras))
												@foreach ($carreras as $carrera)
													<option value="{{$carrera->id}}">{{$carrera->carrera}}</option>
												@endforeach
											@endif
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label" for="carrera">Materia:</label>
									<div class="col-md-6 col-sm-10">
										<select name="materias" id="materias" class="table-group-action-input form-control">
											<option value="0">Seleccione</option>
											@if (isset($materias))
												@foreach ($materias as $materia)
													<option value="{{$materia->id}}">{{$materia->nombremateria}}</option>
												@endforeach
											@endif
										</select>
									</div>
								</div>
								<div class="form-group">
									<label  class="col-md-2 col-sm-2 control-label">Ciclo Lectivo:</label>
									<div class="col-md-6 col-sm-4">
										<select name="ciclos" id="ciclos" class="table-group-action-input form-control">
										<option value="0">Seleccione</option>
										@if (isset($ciclos))
											@foreach ($ciclos as $ciclo)
												<option value="{{$ciclo->id}}" <?php if ($ciclo->id == $ciclo_id) echo "selected"; ?>>{{$ciclo->descripcion}}</option>
											@endforeach
										@endif
										</select>
									</div>			
								</div>
								<div class="form-group">
									<label  class="col-md-2 col-sm-2 control-label">Turnos de Examenes:</label>
									<div class="col-md-2 col-sm-2">
										<select name="turnos" id="turnos" class="table-group-action-input form-control">
										<option value="0">Seleccione</option>	
										@if (isset($turnos))
											@foreach ($turnos as $turno)
												<option value="{{$turno->id}}">{{$turno->descripcion}}</option>
											@endforeach
										@endif
									</select>
									</div>	
									<div class="form-group">
										<label class="col-md-2 control-label" for="observacion">Observación:</label>
										<div class="col-md-2">
											<textarea rows="5" name="observacion" id="observacion" class="form-control"></textarea>
										</div>
									</div>				
								</div>

								<div class="form-group">
									<label class="col-md-2 control-label" for="fechaprimerllamado"><font color="red">Fecha Primer Llamado:</font></label>
									<div class="col-md-2">
										<input type="date" class="form-control" id="fechaprimerllamado" name="fechaprimerllamado" value="" >
										<!--<div class="help-block">(hs Cátedra)</div>-->
									</div>
									<label class="col-md-2 control-label" for="horaprimerllamado"><font color="red">Hora: </font></label>
									<div class="col-md-2">
										<input type="time" class="form-control" id="horaprimerllamado" name="horaprimerllamado" value="" >
										<!--<div class="help-block">(hs Cátedra)</div>-->
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label" for="fechasegundollamado"><font color="red">Fecha Segundo Llamado:</font></label>
									<div class="col-md-2">
										<input type="date" class="form-control" id="fechasegundollamado" name="fechasegundollamado" value="" >
										<!--<div class="help-block">(hs Cátedra)</div>-->
									</div>
									<label class="col-md-2 control-label" for="horasegundollamado"><font color="red">Hora: </font></label>
									<div class="col-md-2">
										<input type="time" class="form-control" id="horasegundollamado" name="horasegundollamado" value="" >
										<!--<div class="help-block">(hs Cátedra)</div>-->
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
																
						<div class="portlet-body form">

							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2">Lista de Docentes:</label>
								<div class="col-md-8 col-sm-8">
									{{ Form::select('docentes[]', array(), Input::old('docentes'), array('class'=>'table-group-action-input form-control multi-select','id'=>'docentes', 'multiple'=>'multiple', $disabled)); }}
								</div>
								<div class="col-md-2 col-sm-2">
									<label class="pull-left">Tribunal Docente</label>
								</div>
							</div>
						</div>


								<!--TABLA DE PERMISOS-->
								<!--<table class="table table-hover" id="table_permisos">
									<thead>
									<tr>
										<th>
											<center><i class="fa fa-list"></i> Fecha</center>
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
											<center><i class="fa fa-list-ol"></i> Materias Asignadas</center>
										</th>
										
									</tr>
									</thead>
										<tbody>

										</tbody>
									</table>-->
									<!-- FIN TABLA DE PERMISOS -->



					</div>
						
				
					{{ Form::close()}}
				</div>
			</div>
			<!-- FIN DEL CONTENIDO -->
		</div>
	</div>
	<!-- FIN -->

	<!-- MODAL-->
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
	<!-- FIN MODAL-->

@stop


@section('customjs')
	ValidForm.init();

	$('#docentes').multiSelect();
	
	
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
					combociclos.append('<option selected value="'+ciclos[i]['id']+'">'+ciclos[i]['descripcion']+'</option>')
				} else {
					combociclos.append('<option value="'+ciclos[i]['id']+'">'+ciclos[i]['descripcion']+'</option>')
				}
			}
			combociclos.select2()
			
		});

		//

		$('#carreras').find('option').remove().end()
		$('#carreras').append('<option value="0" disabled selected>Seleccione</option>');
		$('#carreras').select2("destroy")
		$('#carreras').select2();
		
		$('#materias').find('option').remove().end()
		$('#materias').append('<option value="0" disabled selected>Seleccione</option>');
		$('#materias').select2("destroy")
		$('#materias').select2();


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
		var filtro = 2;
    	
		$('#opcion').removeAttr('disabled');
    	var carrera_id = $('#carreras').val();
	
		$.ajax({
		  url: "{{url('mesaexamenes/obteneropciones')}}",
		  data:{'carrera_id': carrera_id, 'filtro': filtro},
		  type: 'POST'
		}).done(function(opcion) {
			console.log(opcion);
		
		$('#materias').find('option').remove().end()
		$('#materias').append('<option value="0" disabled selected>Seleccione</option>');
		$('#materias').select2("destroy")
		$('#materias').select2();


		$.each(opcion, function(key, value) {
			$('#materias').append(
		        $('<option></option>').val(value.id).html(value.descripcion)
		    );
		});
		
		}).error(function(data) {
			console.log(data);
		});

		// para docentes
		filtro = 3;	
		$.ajax({
		  url: "{{url('mesaexamenes/obteneropciones')}}",
		  data:{'carrera_id': carrera_id, 'filtro': filtro},
		  type: 'POST'
		}).done(function(opcion) {
			console.log(opcion);

			var arrayJS= opcion;
			
			$('#docentes').children().remove().end();
		    //$('#docentes').multiSelect('refresh');

					
					
			$.each(arrayJS, function(key, value){

				$("#docentes").append('<option value="'+value.id+'">'+value.descripcion+'</option>');
				
			})
		
			//$('#docentes').multiSelect();
			$('#docentes').multiSelect('refresh');

		}).error(function(data) {
			console.log(data);
		});
		
	});

	$('#organizacion, #carreras, #materias, #ciclos, #turnos').select2({
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

	/*$('.btnEliminarMaterias').live('click', function(){
		$('#idMateriaHidden').val($(this).data('id'));
		$('#modalEliminaMateria').modal('show');
	});*/

	
	$('#materias').change(function() {

		//$('#docentes').multiSelect('deselect_all');
		var turnoss = $('#turnos');
		$.ajax({
		type: "POST",
		url: "{{url('mesaexamenes/obtenerturnos')}}",
		//data: { organizacion_id: $('#organizacion').val() }	
		}).done(function(turnos) {
			console.log(turnos)
			turnoss.find('option').remove().end()
			turnoss.append('<option value="0" disabled selected>Seleccione</option>');
			turnoss.select2("destroy")
			turnoss.select2()
			

			for (i = 0; i < turnos.length; i++) {

				turnoss.append('<option value="'+turnos[i]['id']+'">'+turnos[i]['descripcion']+'</option>')
			
			}
			turnoss.select2()
			
		});

	
	});


	$('#turnos').change(function() {

		$('#docentes').multiSelect('deselect_all');
	
	});


	$('#docentes').change(function() {
	
		
		var organizacion_id = $('#organizacion').val();
		var carrera_id = $('#carreras').val();
		var materia_id = $('#materias').val();
		var ciclo_id = $('#ciclos').val();
		var turno_id = $('#turnos').val();
		
		var ultimo = $('#docentes').closest('select').find('option').filter(':selected:last').val();
		
		$('#fechaprimerllamado').removeAttr('disabled');
		$('#fechasegundollamado').removeAttr('disabled');
		$('#horaprimerllamado').removeAttr('disabled');
		$('#horasegundollamado').removeAttr('disabled');
		$('#observacion').removeAttr('disabled');

		$.ajax({
		  url: "{{url('mesaexamenes/obtenerrepetidos')}}",
		  data:{'organizacion_id': organizacion_id, 'carrera_id': carrera_id, 'materia_id': materia_id, 'ciclo_id': ciclo_id, 'turno_id': turno_id},
		  type: 'POST'
		}).done(function(resultado) {
			console.log(resultado);
			
			//alert(resultado);
			if (resultado == 1){
				//nuevo
				$('#fechaprimerllamado').attr('disabled', 'disabled');
				$('#fechasegundollamado').attr('disabled', 'disabled');
				$('#horaprimerllamado').attr('disabled', 'disabled');
				$('#horasegundollamado').attr('disabled', 'disabled');
				$('#observacion').attr('disabled', 'disabled');
				//
				$('#divMensaje').html('<p class="form-control-static"><h4>' + 'Ya existe una mesa registrada con estos datos!' + '</h4></p>');
				$('#Mensajes').modal('show');
				$('#docentes').multiSelect('deselect', ultimo);
				return false;
			}

		}).error(function(data) {
			console.log(data);
		});


		//var ultimo = $('#docentes').closest('select').find('option').filter(':selected:last').val();

        temp = $('#docentes').val();


		if (temp.length == 4) {
			$('#docentes').multiSelect('deselect', ultimo);
		}
    	

    	$('#docentes').multiSelect('refresh');
	
	});



	$('#guardar').on('click', function(e){
		
		var organizacion_id = $('#organizacion').val();
		
		if (organizacion_id == '0'){
			$('#divMensaje').html('<p class="form-control-static"><h4>' + 'Todos los combos deben tener una opción seleccionada!' + '</h4></p>');
			$('#Mensajes').modal('show');
			return false;
		}

		var carrera_id = $('#carreras').val();

		if (carrera_id == '0' || carrera_id == null){
			$('#divMensaje').html('<p class="form-control-static"><h4>' + 'Todos los combos deben tener una opción seleccionada!' + '</h4></p>');
			$('#Mensajes').modal('show');
			return false;
		}

		var materia_id = $('#materias').val();

		if (materia_id == '0' || materia_id == null){
			$('#divMensaje').html('<p class="form-control-static"><h4>' + 'Todos los combos deben tener una opción seleccionada!' + '</h4></p>');
			$('#Mensajes').modal('show');
			return false;
		}


		var ciclo_id = $('#ciclos').val();

		if (ciclo_id == '0' || ciclo_id == null){
			$('#divMensaje').html('<p class="form-control-static"><h4>' + 'Todos los combos deben tener una opción seleccionada!' + '</h4></p>');
			$('#Mensajes').modal('show');
			return false;
		}

		var turno_id = $('#turnos').val();

		if (turno_id == '0' || turno_id == null){
			$('#divMensaje').html('<p class="form-control-static"><h4>' + 'Todos los combos deben tener una opción seleccionada!' + '</h4></p>');
			$('#Mensajes').modal('show');
			return false;
		}


		var primerfecha = $('#fechaprimerllamado').val();
		var segundafecha = $('#fechasegundollamado').val();

		if (primerfecha == '' || primerfecha == null){
			$('#divMensaje').html('<p class="form-control-static"><h4>' + 'Debe seleccionar las fechas para esta mesa!' + '</h4></p>');
			$('#Mensajes').modal('show');
			return false;
		} else {
			if (segundafecha != '' && segundafecha != null){
				if (segundafecha <= primerfecha){
					$('#divMensaje').html('<p class="form-control-static"><h4>' + 'La fecha del segundo llamado no puede ser menor a la del pimer llamado!' + '</h4></p>');
					$('#Mensajes').modal('show');
					return false;
				} 
			}
		}

		var primerhora  = $('#horaprimerllamado').val();
		var segundahora = $('#horasegundollamado').val();

		if (primerhora == '' || primerhora == null){
			$('#divMensaje').html('<p class="form-control-static"><h4>' + 'Debe asignar los horarios para esta mesa!' + '</h4></p>');
			$('#Mensajes').modal('show');
			return false;
		}
	
		if (segundafecha != '' &&  segundafecha != null){
			if (segundahora == '' ||  segundahora == null){
				$('#divMensaje').html('<p class="form-control-static"><h4>' + 'Debe asignar los horarios para esta mesa!' + '</h4></p>');
				$('#Mensajes').modal('show');
				return false;
			}
		}



		temp = $('#docentes').val();

        if ($('#docentes').val() == null) {
	
			$('#divMensaje').html('<p class="form-control-static"><h4>' + 'Faltan docentes en el tribunal!' + '</h4></p>');
			$('#Mensajes').modal('show');
			return false;
    	} else if (temp.length != 3){
				
			$('#divMensaje').html('<p class="form-control-static"><h4>' + 'Faltan docentes en el tribunal!' + '</h4></p>');
			$('#Mensajes').modal('show');
			return false;
    	}



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
