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
					Registrar Examen Final <small> Examen Final</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('examenfinal/crear')}}">Examen Final</a>
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
					{{ Form::open(array('url'=>'examenfinal/guardar', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmExamenFinal', 'name'=>'FrmExamenFinal'))}}
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-files-o"></i> Examen Final
							</div>
							<div class="actions">
								<a href="{{url('examenfinal/crear')}}" {{$disabled}} class="btn default blue-stripe" <?php if ($habilita == true) echo "disabled"; ?>>
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Nuevo </span>
								</a>
								<!--a href="#" {{$disabled}} id="guardar" class="btn default blue-stripe">
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Guardar </span>
								</a-->
								<a href="{{url('examenfinal/listado')}}" {{ $disabled }} class="btn default red-stripe">
								<i class="fa fa-list"></i>
								<span class="hidden-480">
								Listado </span>
								</a>
								<!--button type='submit' class="btn default green-stripe" {{ $disabled }}>
								<i class="fa fa-save"></i>
								<span class="hidden-480">
								Guardar </span>
								</button>
								<a target="_blank" href="#" id="imprimir" {{$imprimir}} class="btn default yellow-stripe">
								<i class="fa fa-print"></i>
								<span class="hidden-480">
								Imprimir </span>
								</a-->								
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

									<label class="col-md-2 col-sm-2 control-label" for="filtro">Turno Examen:</label>
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
											<option value="1">DNI</option>
											<option value="2">Apellido, Nombres</option>
										</select>
									</div>
									<div class="col-md-4 col-sm-4">
										<input class="form-control" name="txtalumno" id="txtalumno" type="text" value="<?php if (isset($nrodocumento)) echo $nrodocumento; ?>">
										<input class="form-control" name="alumno_id" id="alumno_id" type="hidden" value="<?php if (isset($alumno_id)) echo $alumno_id; ?>">
										<input class="form-control" name="inscripto" id="inscripto" type="hidden" value="<?php if (isset($inscripto)) echo $inscripto; ?>">
									</div>
									<div class="col-md-2 col-sm-2">
										<a class="btn blue-madison" id='btnBuscar'>
											<i class="fa fa-search"></i> Buscar
										</a>
									</div>										
								</div>

								<div class="form-group" id="target">
									<label class="col-md-2 control-label" >Apellido y Nombre:</label>
									<div class="col-md-4 col-sm-10">
										<label id="nombreAlumno" class="control-label text-info" id="nombreAlumno"><?php if (isset($apeynom)) echo $apeynom; ?></label>
									</div>
									<label  class="col-md-2 col-sm-2 control-label">DNI:</label>
									<div class="col-md-2 col-sm-4 text-info" id='divDNI'><?php if (isset($nrodocumento)) echo $nrodocumento; ?></div>
								</div>

								<div class="form-group">
									<label class="col-md-2 control-label <?php if ($errors->has('libro')) echo 'text-danger' ?>">Libro:</label>
									<div id="divavisofechaing" class="col-md-2 <?php if ($errors->has('libro')) echo 'has-error' ?>">
										<div class="input-icon right">
											<input type="text" class="form-control" name="libro" id="libro" placeholder="" value="{{ Input::old('libro') }}<?php if (!$libro == '') echo $libro; ?>">
											<!-- mostrar cuando exista error -->
									    	@if ($errors->has('libro'))
										    	<span class="help-block">{{ $errors->first('libro') }}</span>
									    	@endif
									    	<!--fin error-->
										</div>
									</div>
									<label class="col-md-1 control-label <?php if ($errors->has('folio')) echo 'text-danger' ?>">Folio:</label>
									<div class="col-md-2">
										<input type="text" class="form-control" id="folio" name="folio" value="{{ Input::old('folio') }}<?php if (!$folio=='') echo $folio; ?>" >
										@if ($errors->has('folio'))
										    <span class="help-block">{{ $errors->first('folio') }}</span>
									    @endif
									</div>
									
									<label class="col-md-1 control-label <?php if ($errors->has('acta')) echo 'text-danger' ?>">Acta:</label>
									<div class="col-md-2 col-sm-2">
										<input type="text" class="form-control" id="acta" name="acta" value="{{ Input::old('acta') }}<?php if (!$acta=='') echo $acta; ?>" >
										@if ($errors->has('acta'))
										    <span class="help-block">{{ $errors->first('acta') }}</span>
									    @endif
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 control-label <?php if ($errors->has('asistencia')) echo 'text-danger' ?>">Asistencia:</label>
									<div class="col-md-1 <?php if ($errors->has('asistencia')) echo 'has-error' ?>">
										<select name="asistencia" id="asistencia" class="table-group-action-input form-control">
												<option value="0">Presente</option>
												<option value="1">Ausente</option>
										</select>
										<!-- mostrar cuando exista error -->
								    	@if ($errors->has('asistencia'))
									    	<span class="help-block">{{ $errors->first('asistencia') }}</span>
								    	@endif
								    	<!--fin error-->
									</div>

									<div class="col-md-1 col-sm-1">
						                <label class="col-md-1 col-sm-1 control-label">Justificó
						                </label>
						            </div>
									<div class="col-md-1">
						                <label class="col-md-1 control-label">Si
						                    <input type="radio" name="justifico" id="justificosi" value="0" <?php if ($justifico == 0) echo "checked"; ?>>
						                </label>
						            </div>
						            <div class="col-md-1">
						                <label class="col-md-1 control-label">No
						                    <input type="radio" name="justifico" id="justificono" value="1" <?php if ($justifico == 1) echo "checked"; ?>>
						                </label>
									</div>

									<div class="@if ($errors->has('observaciones')) {{'has-error'}} @endif">
										<label class="col-md-1 control-label">Observaciones: </label>
										<div class="col-md-4 col-sm-6">
											<textarea rows="5" name="observaciones" class="col-md-2 form-control" placeholder="Observaciones" 
											value="{{ Input::old('observaciones') }}"><?php if (count($examenfinal) > 0) echo $examenfinal->observaciones; ?></textarea>
											@if ($errors->has('observaciones'))
												<span class="help-block">{{ $errors->first('observaciones') }}</span>
											@endif
										</div>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 control-label <?php if ($errors->has('cbofinalnumero')) echo 'text-danger' ?>">Calif. Final Número/Letra:</label>
									<div class="col-md-1 <?php if ($errors->has('cbofinalnumero')) echo 'has-error' ?>">
										<select name="cbofinalnumero" id="cbofinalnumero" class="table-group-action-input form-control">
											<?php if (!$calif_final_num == '') { ?>
												<option value="1" <?php if ($examenfinal->calif_final_num == 1) echo "selected"; ?>>1 (uno)</option>
												<option value="2" <?php if ($examenfinal->calif_final_num == 2) echo "selected"; ?>>2 (dos)</option>
												<option value="3" <?php if ($examenfinal->calif_final_num == 3) echo "selected"; ?>>3 (tres)</option>
												<option value="4" <?php if ($examenfinal->calif_final_num == 4) echo "selected"; ?>>4 (cuatro)</option>
												<option value="5" <?php if ($examenfinal->calif_final_num == 5) echo "selected"; ?>>5 (cinco)</option>
												<option value="6" <?php if ($examenfinal->calif_final_num == 6) echo "selected"; ?>>6 (seis)</option>
												<option value="7" <?php if ($examenfinal->calif_final_num == 7) echo "selected"; ?>>7 (siete)</option>
												<option value="8" <?php if ($examenfinal->calif_final_num == 8) echo "selected"; ?>>8 (ocho)</option>
												<option value="9" <?php if ($examenfinal->calif_final_num == 9) echo "selected"; ?>>9 (nueve)</option>
												<option value="10" <?php if ($examenfinal->calif_final_num == 10) echo "selected"; ?>>10 (diez)</option>
											<?php } else { ?>
												<option value="1">1 (uno)</option>
												<option value="2">2 (dos)</option>
												<option value="3">3 (tres)</option>
												<option value="4">4 (cuatro)</option>
												<option value="5">5 (cinco)</option>
												<option value="6">6 (seis)</option>
												<option value="7">7 (siete)</option>
												<option value="8">8 (ocho)</option>
												<option value="9">9 (nueve)</option>
												<option value="10">10 (diez)</option>
											<?php }	?>
										</select>
										<!-- mostrar cuando exista error -->
								    	@if ($errors->has('cbofinalnumero'))
									    	<span class="help-block">{{ $errors->first('cbofinalnumero') }}</span>
								    	@endif
								    	<!--fin error-->
									</div>

									<label class="col-md-2 control-label <?php if ($errors->has('fechadesde')) echo 'text-danger' ?>">Fecha Aprobación:</label>
									<div id="divavisofechaing" class="col-md-2 <?php if ($errors->has('fechadesde')) echo 'has-error' ?>">
										<div class="input-icon right">
											<i class="fa fa-exclamation tooltips iconoerrorfechaing" style="display:none" data-original-title="Fecha Incorrecta." data-container="body"></i>
											<input type="date" class="form-control" name="fechadesde" id="fechadesde" placeholder="" value="<?php if (isset($fechadesdes)) echo $fechadesdes; ?>">
											<!-- mostrar cuando exista error -->
									    	@if ($errors->has('fechadesde'))
										    	<span class="help-block">{{ $errors->first('fechadesde') }}</span>
									    	@endif
									    	<!--fin error-->
										</div>
									</div>

									<div class="col-md-2 col-sm-2">
										<!--a class="btn blue-madison" id='btnAgregar'>
											<i class="glyphicon glyphicon-download-alt"></i> Agregar
										</a-->
										<button type='submit' id="btnAgregar" class="btn blue-madison" {{ $disabled }}>
											<i class="glyphicon glyphicon-download-alt"></i>
											<span class="hidden-480"> Agregar </span>
										</button>
									</div>
								</div>

							</div>

							<br>
							<br>
							<div class="portlet-body">
								<div class="box-body table-responsive no-padding">
									<table class="table table-striped table-bordered table-hover" id="table_regularidades">
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
											@if (isset($examenfina))
												@foreach ($examenfina as $examenfin)
													<?php $calif_final_num = $examenfin['calif_final_num']; ?>
													<tr>
														<td>
															<center>
																{{ $examenfin->fecha_aprobacion }}
															</center>
														</td>
														<td>
															<center>
																{{ $examenfin->docentes }}
															</center>
														</td>
														<td>
															<center>
																{{ $examenfin->alumno }}
															</center>
														</td>
														<td>
															<center>
																{{ $examenfin->nombrematerias }}
															</center>
														</td>
														<td>
															<center>
																{{ $examenfin->calif_final_num }} ({{ $nota[$calif_final_num] }})
															</center>
														</td>
														<td>
															<center>
																{{ $examenfin->folio }}
															</center>
														</td>
														<td>
															<center>
																{{ $examenfin->libro }}
															</center>
														</td>
														<td>
															<center>
																{{ $examenfin->acta }}
															</center>
														</td>
														<td>
															<center>
																<a href="#" data-id="{{ $examenfin->id }}" class="btn default btn-xs red btnEliminarMaterias"><i title="Eliminar" class="fa fa-trash-o"></i></a>
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
	<!-- FIN -->

@stop

@section('customjs')
	//TableAdvanced.init();
	
	//$("#imprimir").attr('disabled', 'disabled');
	$('input:radio[name=justifico]').attr('disabled', 'disabled');

	$('#asistencia').change(function() {
		if ($('#asistencia').val() == 0) {
	        $('#justificosi').attr('checked', true);
	        $('input:radio[name=justifico]').attr('disabled', 'disabled');
	    }

	    if ($('#asistencia').val() == 1) {
	        $('input:radio[name=justifico]').removeAttr("disabled");
	        $('#justificosi').attr('checked', true);
	    }
	});

	$('#btnBuscar').click(function() {
		var activo = 'disabled';
		var txtalumno = $('#txtalumno').val();
		$('#alumno_id').val('');
		$("#btnAgregar").removeAttr("disabled");

		var materia_id = $('#cboMaterias').val();
    	var carrera_id = $('#cboCarrera').val();
        var planID = $('#cboPlan').val();
        var cboTurnoExamen = $('#cboTurnoExamen').val();

		var url_destino = "";

		if ($("#cboFiltroAlumno").val() == 1) {
			url_destino = "{{url('alumnos/obteneralumnopordni')}}";
		} else {
			url_destino = "{{url('alumnos/obteneralumnoporapellidoynombre')}}";
		}

		if (!txtalumno == '') {
			$.ajax({
			  url: url_destino,
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
				var alumno_id = alumno.alumno_id;
				$('#alumno_id').val(alumno.alumno_id);
				name.toUpperCase();
				$('#nombreAlumno').text(name);
				$('#divDNI').html('<p class="form-control-static">' + alumno.nrodocumento + '</p>');

				$.ajax({
				  url: "{{url('examenfinal/obtenerinscripcionexamen')}}",
				  data:{'materia_id': materia_id, 'carrera_id': carrera_id, 'planID': planID, 'cboTurnoExamen': cboTurnoExamen, 'alumno_id': alumno_id},
				  type: 'POST'
				}).done(function(inscripto) {
					console.log(inscripto);

						if (inscripto == 0) {
							$('#inscripto').val('');
							$('#alumno_id').val('');
							$('#nombreAlumno').text('');
							$('#divDNI').html('<p class="form-control-static"></p>');
							$('#divMensaje').html('<p class="form-control-static"><h4>' + 'El Alumno no esta inscripto en la mesa de examen!' + '</h4></p>');
				    		$('#MensajeCantidad').modal('show');
					    	return;
						} else {
							if (inscripto > 0) $('#inscripto').val(inscripto);

							$.each(inscripto, function(key, value) {
								$('#libro').val(value.libro);
								$('#folio').val(value.folio);
								$('#acta').val(value.acta);
								$('#cbofinalnumero').val(value.calif_final_num);
								$('#inscripto').val(value.inscripcionfinal_id);
								$('#fechadesde').val(value.fecha_aprobacion);
								$('#observaciones').val(value.observaciones);
							});
						}

				}).error(function(data) {
					console.log(data);
				});
			}).error(function(data) {
				console.log(data);
			});
		}
	});

	$('.btnEliminarMaterias').live('click', function(){
		$('#idMateriaHidden').val($(this).data('id'));
		$('#modalEliminaMateria').modal('show');
	});

	$('#cboFiltroAlumno').change(function() {
		if ($('#cboFiltroAlumno').val() == 2) {
	        //$('#txtalumno').removeAttr("disabled");
	        $('#txtalumno').val("");
	        $('#alumno_id').val("");
	        $('#txtalumno').focus();
	    }

	    if ($('#cboFiltroAlumno').val() == 1) {
	        $('#txtalumno').val("");
	        $('#alumno_id').val("");
	    	//$("#txtalumno").attr('disabled', 'disabled');
	        $('#txtalumno').focus();
	    }
	});

	$('#cboOrganizacion').select2({
		placeholder: "Seleccione",
		allowClear: true
	});

	$('#imprimir').on('click', function(e){
		e.preventDefault();
		window.open("{{url('asistencias/imprimir')}}?planID=" + $('#cboPlan').val() + '&carrera_id=' + $('#cboCarrera').val() + '&txtalumno=' + $('#txtalumno').val() + '&fechadesde=' + $('#fechadesde').val() + '&materia_id=' + $('#cboMaterias').val() + '&docente_id=' + $('#cboDocente').val());
	});

    $('#cboMaterias').change(function() {
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

			/*if (materias == 0) {
				$('#alumno_id').val('');
				$('#nombreAlumno').text('');
				$('#divDNI').html('<p class="form-control-static"></p>');
				$('#divMensaje').html('<p class="form-control-static"><h4>' + 'El Alumno no está inscripto en la materia!' + '</h4></p>');
	    		$('#MensajeCantidad').modal('show');
		    	return;
			}*/

			$("#table_regularidades").find("tr:gt(0)").remove();
			var calif_final_let = '';
			var tabladetalle = '';
			var bandera = true;

			$.each(materias, function(key, value) {
				/*if (value.calif_final_let == 0) {
					calif_final_let = "Aprobado";
				} 
				if (value.calif_final_let == 1) {
					calif_final_let = 'Desaprobado';
				}
				if (value.calif_final_let == 2) {
					calif_final_let = 'Ausente';
				}*/
				
				$('#table_regularidades > tbody').append('<tr><td><center>'+value.fecha_aprobacion+'</center></td><td><center>'+value.docentes+'</center></td><td><center>'+value.alumno+'</center></td><td><center>'+value.nombremateria+'</center></td><td><center>'+value.calif_final_num+' ('+value.calif_final_let+')</center></td><td><center>'+value.folio+'</center></td><td><center>'+value.libro+'</center></td><td><center>'+value.acta+'</center></td><td><center><a href="#" data-id="'+value.id+'" class="btn default btn-xs red btnEliminarMaterias"><i title="Eliminar" class="fa fa-trash-o"></i></a></center></td></tr>');
			});

		}).error(function(data) {
			console.log(data);
		});

    });

    $('#cboTurnoExamen').change(function() {
    	limpiar_tabla();

		$('#cboMaterias').children().remove().end();
        if ($('#cboTurnoExamen').val() == 0) return;

        var plan_id = $('#cboPlan').val();
    	var carrera_id = $('#cboCarrera').val();
    	var turnoexamen_id = $('#cboTurnoExamen').val();

		$.ajax({
		  url: "{{url('examenfinal/obtenermaterias')}}",
		  data:{'plan_id': plan_id, 'carrera_id': carrera_id, 'turnoexamen_id': turnoexamen_id},
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
    });

    $('#cboCarrera').change(function() {
    	limpiar_tabla();

    	$('#cboTurnoExamen').val(0);

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
	    $('#inscripto').val('');
		$('#table_regularidades tr').each(function() {
		   if (n > 0) $(this).remove();
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
