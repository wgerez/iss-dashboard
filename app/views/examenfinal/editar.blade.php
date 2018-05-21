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

if (isset($alumnos)) {
	foreach ($alumnos as $value) {
		$alumno_id = $value['alumno_id'];
		$apeynom = $value['apeynom'];
		$nrodocumento = $value['nrodocumento'];
	}
}

if (isset($regularidad)) {
	//foreach ($regularidad as $value) {
	if ($regularidad->cuatrimestre == 0) {
		$cuatrimestre = 1;
	} else{
		$cuatrimestre = $regularidad->cuatrimestre;
	}

	$calif_final_num = $examenfinal->calif_final_num;
	$calif_final_let = $examenfinal->calif_final_let;
	//}
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
							<a href="{{url('examenfinal/listado')}}"> Examen Final</a>
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
								{{ Form::open(array('url'=>'examenfinal/guardar', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmRegularidades', 'name'=>'FrmRegularidades'))}}
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
								<a href="{{url('examenfinal/listado')}}" {{ $disabled }} class="btn default blue-stripe">
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
									<input class="form-control" name="txtid" id="txtid" type="hidden" value="<?php if ($idaseguir) echo $idaseguir; ?>">

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
									<label class="col-md-1 control-label">Libro:</label>
									<div class="col-md-2">
										<input type="text" class="form-control" name="libro" id="libro" placeholder="" value="<?php if (isset($examenfinal)) echo $examenfinal->libro; ?>">
										<!-- mostrar cuando exista error -->
								    	@if ($errors->has('libro'))
									    	<span class="help-block">{{ $errors->first('libro') }}</span>
								    	@endif
								    	<!--fin error-->
									</div>
									
									<label class="col-md-1 control-label">Folio:</label>
									<div class="col-md-2 col-sm-2">
										<input type="text" class="form-control" id="folio" name="folio" value="<?php if (isset($examenfinal)) echo $examenfinal->folio; ?>" >
										@if ($errors->has('folio'))
										    <span class="help-block">{{ $errors->first('folio') }}</span>
									    @endif
									</div>

									<label class="col-md-1 control-label">Acta:</label>
									<div class="col-md-2 col-sm-2">
										<input type="text" class="form-control" id="acta" name="acta" value="<?php if (isset($examenfinal)) echo $examenfinal->acta; ?>" >
										@if ($errors->has('acta'))
										    <span class="help-block">{{ $errors->first('acta') }}</span>
									    @endif
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 control-label">Calif. Final Número:</label>
									<div class="col-md-2">
										<select name="cbofinalnumero" id="cbofinalnumero" class="table-group-action-input form-control">
											<option value="1" <?php if ($examenfinal->calif_final_num == 1) echo "selected"; ?>>1</option>
											<option value="2" <?php if ($examenfinal->calif_final_num == 2) echo "selected"; ?>>2</option>
											<option value="3" <?php if ($examenfinal->calif_final_num == 3) echo "selected"; ?>>3</option>
											<option value="4" <?php if ($examenfinal->calif_final_num == 4) echo "selected"; ?>>4</option>
											<option value="5" <?php if ($examenfinal->calif_final_num == 5) echo "selected"; ?>>5</option>
											<option value="6" <?php if ($examenfinal->calif_final_num == 6) echo "selected"; ?>>6</option>
											<option value="7" <?php if ($examenfinal->calif_final_num == 7) echo "selected"; ?>>7</option>
											<option value="8" <?php if ($examenfinal->calif_final_num == 8) echo "selected"; ?>>8</option>
											<option value="9" <?php if ($examenfinal->calif_final_num == 9) echo "selected"; ?>>9</option>
											<option value="10" <?php if ($examenfinal->calif_final_num == 10) echo "selected"; ?>>10</option>
										</select>
										<!-- mostrar cuando exista error -->
								    	@if ($errors->has('cbofinalnumero'))
									    	<span class="help-block">{{ $errors->first('cbofinalnumero') }}</span>
								    	@endif
								    	<!--fin error-->
									</div>

									<label class="col-md-1 control-label">Calif. Final Letra:</label>
									<div class="col-md-2">
										<select name="cbofinalletra" id="cbofinalletra" class="table-group-action-input form-control">
											<option value="0" <?php if ($examenfinal->calif_final_let == 0) echo "selected"; ?>>Aprobado</option>
											<option value="1" <?php if ($examenfinal->calif_final_let == 1) echo "selected"; ?>>Desaprobado</option>
											<option value="2" <?php if ($examenfinal->calif_final_let == 2) echo "selected"; ?>>Ausente</option>
										</select>
										<!-- mostrar cuando exista error -->
								    	@if ($errors->has('cbofinalletra'))
									    	<span class="help-block">{{ $errors->first('cbofinalletra') }}</span>
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
								</div>

								<div class="form-group">
									<div class="@if ($errors->has('observaciones')) {{'has-error'}} @endif">
										<label class="col-md-2 control-label">Observaciones: </label>
										<div class="col-md-5 col-sm-10">
											<textarea rows="5" name="observaciones" class="col-md-2 form-control" placeholder="Observaciones" 
											value="<?php if (isset($examenfinal)) echo $examenfinal->observaciones; ?>"><?php if (isset($examenfinal)) echo $examenfinal->observaciones; ?></textarea>
											@if ($errors->has('observaciones'))
												<span class="help-block">{{ $errors->first('observaciones') }}</span>
											@endif
										</div>
									</div>

									<div class="col-md-2 col-sm-2">
										<!--a class="btn blue-madison" id='btnAgregar'>
											<i class="glyphicon glyphicon-download-alt"></i> Agregar
										</a-->
										<button type='submit' id='btnAgregar' class="btn blue-madison" {{ $disabled }}>
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
												<center><i class="fa fa-calendar"></i> Fecha Regularización</center>
											</th>
											<th>
												<center><i class="glyphicon glyphicon-book"></i> Materia</center>
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
												<center><i class="glyphicon glyphicon-check"></i> Regularizó</center>
											</th>
											<th>
												<center><i class="glyphicon glyphicon-pencil"></i> Acciones</center>
											</th>
										</tr>
										</thead>
										<tbody>
											@if (isset($examenfinal))
												@foreach ($examenfinal as $examenfina)
													<?php $calificacionn = '';
													if ($examenfina->id == $idaseguir) { 
															echo '';
														} else { ?>
														<tr>
															<td>
																<center>
																	{{ $examenfina->fecha_aprobacion }}
																</center>
															</td>
															<td>
																<center>
																	{{ $nombremateria }}
																</center>
															</td>
															<td>
																<center>
																	<?php if ($examenfina->parcial == 0) {
																		echo "-";
																	} else {
																		echo $examenfina->parcial .'°';
																	} ?>
																</center>
															</td>
															<td>
																<center>
																	<?php 
																	if ($regularidad->calificacion == 1) {
																		$calificacionn = "Promociono ". $regularidad->nota;
																	}

																	if ($regularidad->calificacion == 2) {
																		$calificacionn = "Aprobó";
																	}

																	if ($regularidad->calificacion == 3) {
																		$calificacionn = "Desaprobó";
																	}

																	if ($regularidad->calificacion == 2) {
																		$calificacionn = "Ausente";
																	}
																	echo $calificacionn; ?>
																</center>
															</td>
															<td>
																<center>
																	<?php if ($regularidad->nota == 0) {
																		echo "-";
																	}

																	if ($regularidad->nota == 8) {
																		echo "8";
																	}

																	if ($regularidad->nota == 9) {
																		echo "9";
																	}

																	if ($regularidad->nota == 10) {
																		echo "10";
																	} ?>
																</center>
															</td>
															<td>
																<center>
																	<?php if ($regularidad->recuperatorio == 0) {
																		echo "- ";
																	} else {
																		echo $regularidad->recuperatorio .'°';
																	} ?>
																</center>
															</td>
															<td>
																<center>
																	<?php if($regularidad->regularizo == 0) {
																		echo "-";
																	}

																	if($regularidad->regularizo == 1) {
																		echo "SI";
																	}

																	if($regularidad->regularizo == 2) {
																		echo "NO";
																	} ?>
																</center>
															</td>
															<td>
																<center>
																	<a href="#" data-id="{{ $regularidad->id }}" class="btn default btn-xs red btnEliminarMaterias"><i title="Eliminar" class="fa fa-trash-o"></i></a>
																</center>
															</td>
														</tr>
													<?php } ?>
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
		{{ Form::open(array('url' => 'regularidades/borrar')) }}
			<input id="idMateriaHidden" name='idMateriaHidden' type="hidden" value="">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Eliminar Regularidad</h4>
					</div>
					<div class="modal-body">
						¿Estás seguro de querer borrar esta regularidad?
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

    $('#fechadesde').change(function() {
		var fechadesde = $('#fechadesde').val();
        var cboParcial = $('#cboParcial').val();
		var materia_id = $('#cboMaterias').val();
    	var carrera_id = $('#cboCarrera').val();
        var planID = $('#cboPlan').val();
		var alumno_id = $('#alumno_id').val();

		$.ajax({
		  url: "{{url('regularidades/obtenerfechaparcial')}}",
		  data:{'materia_id': materia_id, 'carrera_id': carrera_id, 'planID': planID, 'cboParcial': cboParcial, 'alumno_id': alumno_id, 'fechadesde': fechadesde},
		  type: 'POST'
		}).done(function(parcial) {
			console.log(parcial);
			
				if (parcial == 1) {
					//$('#cboParcial').val(0);
					$('#divMensaje').html('<p class="form-control-static"><h4>' + 'Ya existe un parcial con esta fecha!' + '</h4></p>');
		    		$('#MensajeCantidad').modal('show');
		    		$('#fechadesde').val('');
			    	return;
				}

		}).error(function(data) {
			console.log(data);
		});
    });

    $('#cboRecuperatorio').change(function() {
        if ($('#cboRecuperatorio').val() == 0) return;

        if ($('#cboRecuperatorio').val() == 1) {
	    	$('#cboParcial').val(0);
	    }

        if ($('#cboRecuperatorio').val() == 2) {
	    	$('#cboParcial').val(0);
	    }
    });

    $('#cboParcial').change(function() {
        if ($('#cboParcial').val() == 0) return;

        if ($('#cboParcial').val() == 1) {
	    	$('#cboRegularizo').children().remove().end();

	    	$('#cboRegularizo').append(
		        $('<option></option>').val(0).html('-')
		    );
	    }

        if ($('#cboParcial').val() == 2) {
	    	$('#cboRegularizo').children().remove().end();

	    	if ($('#anualcuatrimestral').val() == 'Anual') {
		    	$('#cboRegularizo').append(
			        $('<option></option>').val(0).html('-')
			    );
			} else {
				$('#cboRegularizo').append(
			        $('<option></option>').val(1).html('SI'),
			        $('<option></option>').val(2).html('NO')
			    );
			}
	    }

        if ($('#cboParcial').val() == 3) {
	    	$('#cboRegularizo').children().remove().end();

	    	$('#cboRegularizo').append(
		        $('<option></option>').val(1).html('SI'),
		        $('<option></option>').val(2).html('NO')
		    );
	    }

        var cboParcial = $('#cboParcial').val();
		var materia_id = $('#cboMaterias').val();
    	var carrera_id = $('#cboCarrera').val();
        var planID = $('#cboPlan').val();
		var alumno_id = $('#alumno_id').val();
		var txtid = $('#txtid').val();

		$.ajax({
		  url: "{{url('regularidades/obtenerparcial')}}",
		  data:{'materia_id': materia_id, 'carrera_id': carrera_id, 'planID': planID, 'cboParcial': cboParcial, 'alumno_id': alumno_id, 'txtid': txtid},
		  type: 'POST'
		}).done(function(parcial) {
			console.log(parcial);

			if (parcial == 1) {
				//$('#cboParcial').val(0);
				$('#divMensaje').html('<p class="form-control-static"><h4>' + 'El Alumno ya tiene cargado referencias en este parcial!' + '</h4></p>');
	    		$('#MensajeCantidad').modal('show');
		    	//return;
			}
			
			$.ajax({
			  url: "{{url('regularidades/obtenerregularidad')}}",
			  data:{'materia_id': materia_id, 'carrera_id': carrera_id, 'planID': planID, 'cboParcial': cboParcial, 'alumno_id': alumno_id},
			  type: 'POST'
			}).done(function(regularidad) {
				console.log(regularidad);
				
				if (regularidad == 1) {
			        if ($('#cboParcial').val() == 2) {
				    	$('#cboRegularizo').children().remove().end();

				    	$('#cboRegularizo').append(
					        $('<option></option>').val(0).html('-'),
					        $('<option></option>').val(1).html('SI'),
					        $('<option></option>').val(2).html('NO')
					    );
				    }

			        if ($('#cboParcial').val() == 3) {
				    	$('#cboRegularizo').children().remove().end();

				    	$('#cboRegularizo').append(
					        $('<option></option>').val(1).html('SI'),
					        $('<option></option>').val(2).html('NO')
					    );
				    }
				} else {
					$('#cboRegularizo').children().remove().end();

			    	$('#cboRegularizo').append(
				        $('<option></option>').val(0).html('-')
				    );
				}

			}).error(function(data) {
				console.log(data);
			});

		}).error(function(data) {
			console.log(data);
		});
    });

	$('#btnBuscar').click(function() {
		var activo = 'disabled';
		var txtalumno = $('#txtalumno').val();
		$('#alumno_id').val('');
		$("#btnAgregar").removeAttr("disabled");
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
				var alumnoid = alumno.alumno_id;
				$('#alumno_id').val(alumno.alumno_id);
				name.toUpperCase();
				$('#nombreAlumno').text(name);
				$('#divDNI').html('<p class="form-control-static">' + alumno.nrodocumento + '</p>');

				var materia_id = $('#cboMaterias').val();
		    	var carrera_id = $('#cboCarrera').val();
		        var planID = $('#cboPlan').val();

				$.ajax({
				  url: "{{url('regularidades/obtenerregularidades')}}",
				  data:{'materia_id': materia_id, 'carrera_id': carrera_id, 'planID': planID, 'alumnoid': alumnoid},
				  type: 'POST'
				}).done(function(materias) {
					console.log(materias);

					if (materias == 0) {
						$('#alumno_id').val('');
						$('#nombreAlumno').text('');
						$('#divDNI').html('<p class="form-control-static"></p>');
						$('#divMensaje').html('<p class="form-control-static"><h4>' + 'El Alumno no está inscripto en la materia!' + '</h4></p>');
			    		$('#MensajeCantidad').modal('show');
				    	return;
					}

				    $('#cboRecuperatorio').children().remove().end();

			    	$('#cboRecuperatorio').append(
				        $('<option></option>').val(0).html('-'),
				        $('<option></option>').val(1).html(1),
				        $('<option></option>').val(2).html(2)
				    );

					if (materias == 1) {
						$('#cboParcial').children().remove().end();

				    	$('#cboParcial').append(
					        $('<option></option>').val(1).html('1')
					    );

					    $('#cboRecuperatorio').children().remove().end();

				    	$('#cboRecuperatorio').append(
					        $('<option></option>').val(0).html('-')
					    );

				    	$('#cboRegularizo').children().remove().end();

				    	$('#cboRegularizo').append(
					        $('<option></option>').val(0).html('-')
					    );
					}

					var recupera = 1;
					var i = 0;

					$.each(materias, function(key, value) {
						if (value.calificacion == 3 || value.calificacion == 4) {
							i = i + 1;
						}
					});

					if ($('#anualcuatrimestral').val() == 'Anual') {
						if (i == 3) $("#btnAgregar").attr('disabled', 'disabled');
					} else {
						if (i == 2) $("#btnAgregar").attr('disabled', 'disabled');
					}

					//---TENER EN CUENTA ASISTENCIAS 75% O MAS PARA INTEGRADOR---//

					$("#table_regularidades").find("tr:gt(0)").remove();
					var tabla = '';
					var tabladetalle = '';
					var bandera = true;
					var recuperatorio = '';
					var regularizo = '';
					var calificacion = '';
					var parcial = '';

					$.each(materias, function(key, value) {
						if (value.parcial == 1) {
							$('#cboParcial').children().remove().end();

					    	$('#cboParcial').append(
						        $('<option></option>').val(1).html('1'),
						        $('<option></option>').val(2).html('2')
						    );

						    $('#cboParcial').val(2);
						}

						if (value.parcial == 2) {
							$('#cboParcial').children().remove().end();

							if ($('#anualcuatrimestral').val() == 'Anual') {
						    	$('#cboParcial').append(
							        $('<option></option>').val(1).html('1'),
							        $('<option></option>').val(2).html('2'),
							        $('<option></option>').val(3).html('3')
							    );
						    	$('#cboParcial').val(3);
						   	} else {
						   		$('#cboParcial').append(
							        $('<option></option>').val(1).html('1'),
							        $('<option></option>').val(2).html('2')
							    );
						    	$('#cboParcial').val(2);
						   	}
						}

						if (value.recuperatorio > 0) {
							recuperatorio = 'A';
						} else {
							recuperatorio = '-';
						}

						if (value.regularizo == 0) {
							regularizo = '-';
						}

						if (value.regularizo == 1) {
							regularizo = 'SI';
						}

						if (value.regularizo == 2) {
							regularizo = 'NO';
						}

						if (value.calificacion == 1) {
							calificacion = 'Promocionó';
						}

						if (value.calificacion == 2) {
							calificacion = 'Aprobó';
						}

						if (value.calificacion == 3) {
							calificacion = 'Desaprobó';
						}

						if (value.calificacion == 4) {
							calificacion = 'Ausente';
						}

						if (value.nota == 0) {
							nota = '-';
						}

						if (value.nota == 8) {
							nota = '8';
						}

						if (value.nota == 9) {
							nota = '9';
						}

						if (value.nota == 10) {
							nota = '10';
						}

						if (value.parcial == 0) {
							parcial = '-';
						} else {
							parcial = value.parcial + '°';
						}

						$('#table_regularidades > tbody').append('<tr><td><center>'+value.fecha_regularidad+'</center></td><td><center>'+value.nombremateria+'</center></td><td><center>'+parcial+'</center></td><td><center>'+calificacion+'</center></td><td><center>'+nota+'</center></td><td><center>'+recuperatorio+'</center></td><td><center>'+regularizo+'</center></td><td><center><a href="#" data-id="'+value.id+'" class="btn default btn-xs red btnEliminarMaterias"><i title="Eliminar" class="fa fa-trash-o"></i></a></center></td></tr>');
					});

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

	$('#cboCalificacion').change(function() {
	    if ($('#cboCalificacion').val() == 0) {
	    	$("#cboNota").removeAttr("disabled");
	    	$("#cboRecuperatorio").removeAttr("disabled");
	    }
	    
	    if ($('#cboCalificacion').val() == 1) {
	    	$("#cboNota").removeAttr("disabled");
	    	$('#cboNota').children().remove().end();

	    	$('#cboNota').append(
		        $('<option></option>').val(8).html('8'),
		        $('<option></option>').val(9).html('9'),
		        $('<option></option>').val(10).html('10')
		    );

	    	$("#cboRecuperatorio").attr('disabled', 'disabled');
	        //$('#cboRegularizo').val(1);
	        $('#cboRegularizo').children().remove().end();

	    	$('#cboRegularizo').append(
		        $('<option></option>').val(0).html('-')
		    );
	    }

		if ($('#cboCalificacion').val() == 2) {
	    	$("#cboNota").removeAttr("disabled");
	    	$('#cboNota').children().remove().end();

	    	$('#cboNota').append(
		        $('<option></option>').val(0).html('-')
		    );

	    	$("#cboRecuperatorio").removeAttr("disabled");
	    }

		if ($('#cboCalificacion').val() == 3) {
	    	$("#cboNota").removeAttr("disabled");
	    	$('#cboNota').children().remove().end();

	    	$('#cboNota').append(
		        $('<option></option>').val(0).html('-')
		    );

	    	$("#cboRecuperatorio").removeAttr("disabled");
	    }

		if ($('#cboCalificacion').val() == 4) {
	    	$("#cboNota").removeAttr("disabled");
	    	$('#cboNota').children().remove().end();

	    	$('#cboNota').append(
		        $('<option></option>').val(0).html('-')
		    );

	    	$("#cboRecuperatorio").removeAttr("disabled");
	    }
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
		$('#cboDocente').children().remove().end();
		$('#anualcuatrimestral').val('');

        var materia_id = $('#cboMaterias').val();
    	var carrera_id = $('#cboCarrera').val();
        var planID = $('#cboPlan').val();

		$.ajax({
		  url: "{{url('asignardocente/obtenerdocentes')}}",
		  data:{'materia_id': materia_id, 'carrera_id': carrera_id, 'planID': planID},
		  type: 'POST'
		}).done(function(docentes) {
			console.log(docentes);

			if (docentes.length == 0) {
				$('#divMensaje').html('<p class="form-control-static"><h4>' + 'La materia no tiene asignado profesor!' + '</h4></p>');
	    		$('#MensajeCantidad').modal('show');
		    	return;
			}

			$("#table_asistencias").find("tr:gt(0)").remove();

			/*$('#cboDocente').append(
		        $('<option></option>').val(0).html('Seleccionar')
		    );*/

			$.each(docentes, function(key, value) {
				$('#cboDocente').append(
			        $('<option></option>').val(value.titular_id).html(value.apeynomtitular), $('<option></option>').val(value.provisorio_id).html(value.apeynomprovisorio), $('<option></option>').val(value.suplente_id).html(value.apeynomsuplente)
			    );

			    if (value.cuatrimestre == 0) {
				    //$('#cboCuatrimestre').append($('<option></option>').val(value.cuatrimestre).html(1 + '°'));
				    $('#cuatrimestre').val(1 + '°');
				} else {
					//$('#cboCuatrimestre').append($('<option></option>').val(value.cuatrimestre).html(value.cuatrimestre + '°'));
				    $('#cuatrimestre').val(value.cuatrimestre + '°');
				}
			});
			
			$.ajax({
			  url: "{{url('asistencias/obtenermaterias')}}",
			  data:{'materia_id': materia_id, 'carrera_id': carrera_id, 'plan_id': planID},
			  type: 'POST'
			}).done(function(materia) {
				console.log(materia);

				$('#anualcuatrimestral').val(materia);

			}).error(function(data) {
				console.log(data);
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

		$.ajax({
		  url: "{{url('asistencias/obtenermaterias')}}",
		  data:{'plan_id': plan_id, 'carrera_id': carrera_id},
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
