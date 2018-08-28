@extends('layouts.master')

@section('customstyle')
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/select2/select2.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/jquery-multi-select/css/multi-select.css')}}"/>
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
					<form method="POST" action="{{url('inscripcionmaterias/obtenerinscriptos')}}" class="form-horizontal form-row-seperated" id="FrmPlanestudios" name="">
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-info"></i> Listado de Inscripción (a cursado)
							</div>
							<div class="actions">
								<a href="{{url('inscripcionmaterias/crear')}}" {{ $disabled }} class="btn default blue-stripe">
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Nuevo </span>
								</a>
								<a target="_blank" href="#" id="imprimir" class="btn default yellow-stripe"  {{ $imprimir }} <?php if ($habilita == false) echo 'disabled' ?>>
								<i class="glyphicon glyphicon-print"></i>
								<span class="hidden-480">
								Imprimir </span>
								</a>

								<!--button id="btnGuardarMaterias" {{ $disabled }} type='submit' class="btn default green-stripe">
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Guardar </span>
								</button-->
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
													<option value="{{$carrera->id}}" <?php if ($carrera->id == $carrera_id) echo "selected"; ?>>{{$carrera->carrera}}</option>
												@endforeach
											@endif
										</select>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 control-label" for="planes">Plan de estudios:</label>
									<div class="col-md-4 col-sm-10">
										<select name="planEstudio" id="planEstudio" class="table-group-action-input form-control">
											<option value="0">Seleccione</option>
											@if (isset($planes))
												@foreach ($planes as $plan)
													<option value="{{$plan->id}}" <?php if ($plan->id == $plan_id) echo "selected"; ?>>{{$plan->codigoplan}}</option>
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
													<option value="{{$ciclo->id}}"<?php if ($ciclo->id == $ciclo_id) echo "selected"; ?>>{{$ciclo->descripcion}}</option>
												@endforeach
											@endif
										</select>
									</div>
								</div>
							</div> <!-- FIN PORTLET-BODY -->
					</div>
					<br>
					<div class="portlet">
						<!--div class="portlet-title">
							<div class="caption">
								<i class="fa fa-user"></i> Datos de Inscripcion (Alumno)
							</div>
						</div-->											
						<div class="portlet-body form">

							<div class="form-group <?php if ($errors->has('documento')) echo 'has-error' ?> ">
								<label  class="col-md-2 col-sm-2 control-label">Alumno:</label>
								<div class="col-md-2 col-sm-4">
									<select name="cboFiltroAlumno" id="cboFiltroAlumno" class="table-group-action-input form-control">
										<option value="0">Todos</option>
										<option value="1" <?php if (!$dni == '') echo "selected"; ?>>DNI</option>
									</select>
								</div>

								<label class="col-md-2 control-label" for="documento">DNI:</label>
								<div id="divdni" class="col-md-3">
									<!--input type="text" class="form-control" id="documento" name="documento" -->
									<div class="input-icon right">
										<i id="icodni" class="fa"></i>
										<input type="text" id="documento" name="documento" class="form-control" value="{{ $dni }}" <?php if ($dni == '') echo "disabled"; ?>>
										<input type="hidden" name="alumnoid" id="alumnoid" value="">
									</div>
									@if ($errors->has('documento'))
									    <span class="help-block">{{ $errors->first('documento') }}</span>
								    @endif
								</div>

										<div class="col-md-2 col-sm-2">
											<button class="btn btn-primary" type="submit" id='BtnBuscar'><i class="fa fa-search"></i> Buscar</button>
										</div>

								<!--div class="col-md-2 col-sm-2">
									<a class="btn btn-primary" id="btnBuscarAlumno"><i class="fa fa-search"></i> Buscar</a>
								</div-->								
							</div>

							<div class="form-group">
								<label class="col-md-2 control-label" >Apellido y Nombre:</label>
								<div class="col-md-4 col-sm-10 text-info" id="nombreAlumno"><?php if ($apeynom != '') echo '<p class="form-control-static">'. $apeynom .'</p>'; ?></div>
								<label  class="col-md-2 col-sm-2 control-label">DNI:</label>
								<div class="col-md-2 col-sm-4 text-info" id='divDNI'><?php if ($dni != '') echo '<p class="form-control-static">'. $dni .'</p>'; ?></div>
							</div>

							<div class="form-group">
								<!--label class="control-label col-md-2 col-sm-2">Materias Disponibles:</label>
								<div class="col-md-8 col-sm-8">
									{{ Form::select('materiasdisponibles[]', array(), Input::old('materiasdisponibles'), array('class'=>'table-group-action-input form-control multi-select','id'=>'materiasdisponibles', 'multiple'=>'multiple', $disabled)); }}
								</div>
								<div class="col-md-2 col-sm-2">
									<label class="pull-left">Materias Asignadas</label>
								</div-->
							</div>
						</div>

								<!--TABLA DE PERMISOS-->
								<table class="table table-hover" id="table_asignadas">
									<thead>
									<tr>
										<th>
											<center><i class="fa fa-user"></i> Alumno</center>
										</th>
										<th>
											<center><i class="fa fa-calendar"></i> Plan/Estudio</center>
										</th>
										<!--th class="hidden-xs">
											<center><i class="fa fa-calendar"></i> Año Cursado</center>
										</th-->
										<th>
											<center><i class="fa fa-list"></i> Fecha</center>
										</th>
										<th>
											<center><i class="fa fa-list-ol"></i> Materias Asignadas</center>
										</th>
										<th>
											<center><i class="fa fa-rocket"></i> Acciones</center>
										</th>
									</tr>
									</thead>
										<tbody>
										<?php 
										$bandera = true;
										$tabla = ''; ?>

										@if (isset($alumnosinscriptos))
											@foreach ($alumnosinscriptos as $alumnosinscripto)
												<?php 
												if ($bandera == true) { 
													$tabla .= '<tr><td><center>'. $alumnosinscripto["apellido"] .', '. $alumnosinscripto["nombre"] .'</center></td><td><center>'. $planestudio .'</center></td>';
													$bandera = false;
													$i = 0;
												} 

												foreach ($alumnosinscripto["materias"] as $materias) {
												//for ($i=0; $i < count($alumnosinscripto["materias"]); $i++) { 
													if ($i > 0) {
														$tabla .= '<tr><td><center></center></td><td><center></center></td>';
													}

													$tabla .= '<td><center>'. $materias["fecha"] .'</center></td><td><center>'. $materias["nombre"] .'</center></td><td><center><a title="Datos personales" href="inscripto/'.$materias["alumno_id"].'-'.$materias["inscripcion"].'" class="btn btn-xs purple"><i class="fa fa-edit"></i></a><a href="#" data-id="'. $materias["inscripcion"] .'" class="btn default btn-xs red btnEliminarMaterias"><i title="Eliminar" class="fa fa-trash-o"></i></a></center></td></tr>';
													$i++;
												}

												$bandera = true;
												echo $tabla;
												$tabla = ''; 
												?>
											@endforeach
										@endif
										</tbody>
									</table>
									<!-- FIN TABLA DE PERMISOS -->



								</div>
						
					</div>
					</form>
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
					<p>Por favor, inscriba al alumno en la carrera correspondiente.</p>
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
			<input id="idAlumnoHidden" name='idAlumnoHidden' type="hidden" value="">
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
	TableAdvanced.init();
	ValidForm.init();

	var url_destino = "{{url('alumnos/obteneralumnopordni')}}";
	var url_alumno = "{{url('inscripcionmaterias/alumnoinscripto')}}";
	var url_materia = "{{url('inscripcionmaterias/materiasdecarrera')}}";

	$('#imprimir').on('click', function(e){
		e.preventDefault();
		window.open("{{url('inscripcionmaterias/pdfimprimirlistado')}}?organizacion=" + $('#organizacion').val() + '&planEstudio=' + $('#planEstudio').val() + '&carreras=' + $('#carreras').val() + '&cboCiclos=' + $('#cboCiclos').val() + '&alumnoid=' + $('#alumnoid').val() + '&documento=' + $('#documento').val());
	});

	$('#cboFiltroAlumno').on('change', function(){
		if ($('#cboFiltroAlumno').val() == 0) {
    		$("#documento").val('');
    		$("#documento").attr('disabled', 'disabled');
    		$('#alumnoid').val('');
    	}

    	if ($('#cboFiltroAlumno').val() == 1) {
    		$("#documento").removeAttr("disabled");
    	}
	});	

	$("#btnBuscarAlumno").on('click', function(){
		if (document.getElementById('documento').value.length < 8) {
			$('#modalAvisoDni').modal('show');		
			$('#nombreAlumno').text("");
			return false;
		}

	    if ($('#planEstudio').val() == '0') {
    		$('#divMensaje').html('<p class="form-control-static"><h4>' + 'Debe seleccionar los datos a buscar' + '</h4></p>');
    		$('#MensajeCantidad').modal('show');
	    	return;
	    }

		$.ajax({
			url: url_destino,
			data: {'txt_alumno': $("#documento").val()},
			type: 'POST',
			dataType: 'json',
			cache: false	
		}).done(function(alumno){
			if (alumno.apellido!=undefined)
			{
				var name = alumno.apellido + ", " + alumno.nombre;
				var alumnoid = alumno.alumno_id;
				$('#alumnoid').val(alumno.alumno_id);
				name.toUpperCase();
				$('#nombreAlumno').text(name);
				$('#divDNI').html('<p class="form-control-static">' + alumno.nrodocumento + '</p>');
				$('#icodni').removeClass('fa-warning').addClass("fa-check");
				$('#divdni').removeClass('has-error').addClass("has-success");

				//UNA VEZ QUE SE DETECTA AL ALUMNO, COMPROBAMOS SI ESTÁ INSCRIPTO EN LA CARRERA SELECCIONADA
				$.ajax({
					url: url_alumno,
					data: {'alumnoid': $('#alumnoid').val(), 'plan_id': $('#planEstudio').val()},
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
								$('#table_permisos > tbody:last-child').append('<tr><td><center>'+ value.fecha +'</center></td><!--td><center>'+ value.carrera +'</center></td--><td><center>'+ value.anio +'°</center></td><!--td><center>'+ value.plan +'</center></td--><td><center>'+ value.nombre +'</center></td><td><center><a href="#" data-id="'+ value.inscripcion +'" class="btn default btn-xs red btnEliminarMaterias"><i title="Eliminar" class="fa fa-trash-o"></i></a></center></td></tr>');
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
			} else {
				$('#icodni').removeClass('fa-check').addClass("fa-warning");
				$('#divdni').removeClass('has-success').addClass("has-error");
				$('#nombreAlumno').text('El DNI no pertenece a un alumno.');
    			$('#materiasdisponibles').children().remove().end();
    			$('#materiasdisponibles').multiSelect('refresh');				
			}
		});

	});

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
		var alumnoid = $('#alumnoid').val();
		$('#idAlumnoHidden').val(alumnoid);
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
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js')}}"></script>
	<script src="{{url('assets/admin/pages/scripts/table-advanced.js')}}"></script>
<!-- END PAGE LEVEL PLUGINS -->
@stop
