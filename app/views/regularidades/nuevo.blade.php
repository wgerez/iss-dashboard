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

if (isset($regularidades)) {
	foreach ($regularidades as $value) {
		if ($value->cuatrimestre == 0) {
			$cuatrimestre = 1;
		} else{
			$cuatrimestre = $value->cuatrimestre;
		}
	}
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
								{{ Form::open(array('url'=>'regularidades/guardar', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmRegularidades', 'name'=>'FrmRegularidades'))}}
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-files-o"></i> Examen Parcial
							</div>
							<div class="actions">
								<a href="{{url('regularidades/crear')}}" {{$disabled}} class="btn default blue-stripe" <?php if ($habilita == true) echo "disabled"; ?>>
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Nuevo </span>
								</a>
								<!--a href="#" {{$disabled}} id="guardar" class="btn default blue-stripe">
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Guardar </span>
								</a-->
								<a href="{{url('regularidades/listado')}}" {{ $disabled }} class="btn default red-stripe">
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

								<div class="form-group <?php if ($errors->has('cboCarrera')) echo 'has-error' ?>">
									<label class="col-md-2 col-sm-2 control-label" for="cboCarrera">Carrera:</label>
									<div class="col-md-6 col-sm-6">
										<select name="cboCarrera" id="cboCarrera" class="table-group-action-input form-control">
											<option value="0">Seleccione</option>
											@if (isset($carreras))
												@foreach ($carreras as $carrera)
													<option value="{{$carrera->id}}" <?php if ($carrera->id == $carrera_id) echo "selected"; ?>>{{$carrera->carrera}}</option>
												@endforeach
											@endif
										</select>
										@if ($errors->has('cboCarrera'))
										    <span class="help-block">{{ $errors->first('cboCarrera') }}</span>
									    @endif
									</div>
								</div>

								<div class="form-group <?php if ($errors->has('cboPlan')) echo 'has-error' ?>">
									<label class="col-md-2 col-sm-2 control-label" for="cboPlan">Plan Estudio:</label>
									<div class="col-md-2 col-sm-3">
										<select name="cboPlan" id="cboPlan" class="table-group-action-input form-control">
											<option value="0">Seleccione</option>
											@if (isset($planes))
												@foreach ($planes as $plan)
													<option value="{{$plan->id}}" <?php if ($plan->id == $planID) echo "selected"; ?>>{{$plan->codigoplan}}</option>
												@endforeach
											@endif
										</select>
										@if ($errors->has('cboPlan'))
										    <span class="help-block">{{ $errors->first('cboPlan') }}</span>
									    @endif
									</div>

									<div class="form-group <?php if ($errors->has('cboCiclos')) echo 'has-error' ?>" >
										<label class="col-md-2 col-sm-2 control-label">Ciclo Lectivo:</label>
										<div class="col-md-2 col-sm-2">
											<select class="table-group-action-input form-control" name="cboCiclos" id="cboCiclos">
												@if (isset($ciclos))
													@foreach ($ciclos as $ciclo)
														<option value="{{$ciclo->id}}" <?php if ($ciclo->id == $ciclo_id) echo "selected"; ?>>{{$ciclo->descripcion}}</option>
													@endforeach
												@endif
											</select>
											<!-- mostrar cuando exista error -->
										    @if ($errors->has('cboCiclos'))
											    <span class="help-block">{{ $errors->first('cboCiclos') }}</span>
										    @endif
										    <!--fin error-->

										</div>
									</div>
								</div>

								<div class="form-group <?php if ($errors->has('cboMaterias')) echo 'has-error' ?>">
									<label class="col-md-2 col-sm-2 control-label" for="cboMaterias">Materias:</label>
									<div class="col-md-6 col-sm-6">
										<select name="cboMaterias" id="cboMaterias" class="table-group-action-input form-control">
											<option value="0">Seleccione</option>
											@if (isset($materias))
												@foreach ($materias as $materia)
													<option value="{{$materia->id}}" <?php if ($materia->id == $materia_id) echo "selected"; ?>>{{$materia->nombremateria}}</option>
												@endforeach
											@endif
											<input class="form-control" name="anualcuatrimestral" id="anualcuatrimestral" type="hidden" value="">
										</select>
										@if ($errors->has('cboMaterias'))
										    <span class="help-block">{{ $errors->first('cboMaterias') }}</span>
									    @endif
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 col-sm-2 control-label">Alumno:</label>
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
									<label class="col-md-2 col-sm-2 control-label" for="cboDocente">Docente:</label>
									<div class="col-md-4 col-sm-4">
										<select name="cboDocente" id="cboDocente" class="table-group-action-input form-control" readonly>
											<option value="0">Seleccione</option>
											@if (isset($docentes))
												@foreach ($docentes as $docente)
													<option value="{{$docente['id']}}" <?php if ($docente['id'] == $docente_id) echo "selected"; ?>>{{$docente['apeynom']}}</option>
												@endforeach
											@endif
										</select>
									</div>

									<label class="col-md-2 control-label">Cuatrimestre:</label>
									<div class="col-md-2">
										<input class="form-control" name="cuatrimestre" id="cuatrimestre" type="text" value="<?php if (isset($cuatrimestre)) echo $cuatrimestre .'°'; ?>" readonly>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 control-label <?php if ($errors->has('fechadesde')) echo 'text-danger' ?>">Fecha Parcial:</label>
									<div id="divavisofechaing" class="col-md-2 <?php if ($errors->has('fechadesde')) echo 'has-error' ?>">
										<div class="input-icon right">
											<i class="fa fa-exclamation tooltips iconoerrorfechaing" style="display:none" data-original-title="Fecha Incorrecta." data-container="body"></i>
											<input type="date" class="form-control" name="fechadesde" id="fechadesde" placeholder="" value="<?php //if (isset($fechadesdes)) echo $fechadesdes; ?>">
											<!-- mostrar cuando exista error -->
									    	@if ($errors->has('fechadesde'))
										    	<span class="help-block">{{ $errors->first('fechadesde') }}</span>
									    	@endif
									    	<!--fin error-->
										</div>
									</div>
									<label class="col-md-1 control-label">Parcial:</label>
									<div class="col-md-2">
										<select name="cboParcial" id="cboParcial" class="table-group-action-input form-control">
											<option value="0">-</option>
											<?php if (isset($parcial)) {
												for ($i=1; $i < $parcial; $i++) {
													echo "<option value='$i'>$i</option>";
												}
											} else { ?>
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
											<?php } ?>
										</select>
									</div>
									<label class="col-md-1 control-label <?php if ($errors->has('cboNota')) echo 'text-danger' ?>">Nota:</label>
									<div class="col-md-2 <?php if ($errors->has('cboNota')) echo 'has-error' ?>">
										<select name="cboNota" id="cboNota" class="table-group-action-input form-control" <?php if (isset($promocional)) echo 'disabled'; ?>>
											<option value="0">-</option>
										</select>
										<!-- mostrar cuando exista error -->
								    	@if ($errors->has('cboNota'))
									    	<span class="help-block">{{ $errors->first('cboNota') }}</span>
								    	@endif
								    	<!--fin error-->
									</div>
									<input class="form-control" name="promocion" id="promocion" type="hidden" value="<?php if (isset($promocional)) echo $promocional; ?>" readonly>
								</div>
									
								<div class="form-group">
									<label class="col-md-2 control-label">Calificación:</label>
									<div class="col-md-2 col-sm-2">
										<select name="cboCalificacion" id="cboCalificacion" class="table-group-action-input form-control">
											<option value="0">-</option>
											<option value="1">Aprobó</option>
											<option value="2">Desaprobó</option>
											<option value="3">Ausente</option>
										</select>
									</div>

									<div class="@if ($errors->has('observaciones')) {{'has-error'}} @endif">
										<label class="col-md-2 control-label">Observaciones: </label>
										<div class="col-md-4 col-sm-6">
											<textarea rows="5" id="observaciones" name="observaciones" class="col-md-2 form-control" placeholder="Observaciones" 
											value="{{ Input::old('observaciones') }}"></textarea>
											@if ($errors->has('observaciones'))
												<span class="help-block">{{ $errors->first('observaciones') }}</span>
											@endif
										</div>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 control-label">Recuperatorio:</label>
									<div class="col-md-2">
										<select name="cboRecuperatorio" id="cboRecuperatorio" class="table-group-action-input form-control">
											<option value="0">-</option>
											<option value="1">1</option>
											<option value="2">2</option>
										</select>
									</div>
									
									<label class="col-md-1 control-label">Regularizó:</label>
									<div class="col-md-2 col-sm-2">
										<select name="cboRegularizo" id="cboRegularizo" class="table-group-action-input form-control">
											<option value="0">-</option>
											<option value="1">SI</option>
											<option value="2">NO</option>
										</select>
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
												<center><i class="fa fa-calendar"></i> Fecha Parcial</center>
											</th>
											<th>
												<center><i class="glyphicon glyphicon-book"></i> Materia</center>
											</th>
											<th>
												<center><i class="fa fa-files-o"></i> Régimen</center>
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
												<center><i class="glyphicon glyphicon-check"></i> Regularizo</center>
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
																{{ $regularidad->fecha_regularidad }}
															</center>
														</td>
														<td>
															<center>
																{{ $nombremateria }}
															</center>
														</td>
														<td>
															<center>
																<?php if ($regularidad->promocional == 0) {
																	echo "Regular";
																} else {
																	echo "Promocional";
																} ?>
															</center>
														</td>
														<td>
															<center>
																<?php if ($regularidad->parcial == 0) {
																	echo "-";
																} else {
																	echo $regularidad->parcial.'°';
																} ?>
															</center>
														</td>
														<td>
															<center>
																<?php if ($regularidad->calificacion == 0) {
																	echo "-";
																}
																if ($regularidad->calificacion == 1) {
																	echo "Aprobó";
																}
																if ($regularidad->calificacion == 2) {
																	echo "Desaprobó";
																}
																if ($regularidad->calificacion == 3) {
																	echo "Ausente";
																} ?>
															</center>
														</td>
														<td>
															<center>
																<?php if ($regularidad->nota == 0) {
																	echo "-";
																} else {
																	echo $regularidad->nota;
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
																<?php 
																	if($regularidad->regularizo == 0) echo "-";
																	if($regularidad->regularizo == 1) echo "SI";
																	if($regularidad->regularizo == 2) echo "NO";
																	if($regularidad->regularizo == 3) echo "Promocionó";
																	 ?>
															</center>
														</td>
														<td>
															<center>
																<a href="#" data-id="{{ $regularidad->id }}" class="btn default btn-xs red btnEliminarMaterias" {{ $readonly }}><i title="Eliminar" class="fa fa-trash-o"></i></a>
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
	$("#observaciones").attr('disabled', 'disabled');
	$('#btnAgregar').attr('disabled', 'disabled');

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
    	$('#cboCalificacion').val(0);
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
			        $('<option></option>').val(2).html('NO'),
			        $('<option></option>').val(3).html('PROMOCIONÓ')
			    );
			}
	    }

        if ($('#cboParcial').val() == 3) {
	    	$('#cboRegularizo').children().remove().end();

	    	$('#cboRegularizo').append(
		        $('<option></option>').val(1).html('SI'),
		        $('<option></option>').val(2).html('NO'),
			    $('<option></option>').val(3).html('PROMOCIONÓ')
		    );
	    }

        var cboParcial = $('#cboParcial').val();
		var materia_id = $('#cboMaterias').val();
    	var carrera_id = $('#cboCarrera').val();
        var planID = $('#cboPlan').val();
		var alumno_id = $('#alumno_id').val();

		$.ajax({
		  url: "{{url('regularidades/obtenerparcial')}}",
		  data:{'materia_id': materia_id, 'carrera_id': carrera_id, 'planID': planID, 'cboParcial': cboParcial, 'alumno_id': alumno_id},
		  type: 'POST'
		}).done(function(parcial) {
			console.log(parcial);

			if (parcial == 1) {
				//$('#cboParcial').val(0);
				$("#cboRecuperatorio").removeAttr("disabled");
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
					        $('<option></option>').val(2).html('NO'),
			        		$('<option></option>').val(3).html('PROMOCIONÓ')
					    );
				    }

			        if ($('#cboParcial').val() == 3) {
				    	$('#cboRegularizo').children().remove().end();

				    	$('#cboRegularizo').append(
					        $('<option></option>').val(1).html('SI'),
					        $('<option></option>').val(2).html('NO'),
			        		$('<option></option>').val(3).html('PROMOCIONÓ')
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

	$('#btnBuscar').change(function() {
		Buscar_Alumno();
	});

	$('#txtalumno').change(function() {
		Buscar_Alumno();
	});

	function Buscar_Alumno() {
		var activo = 'disabled';
		var txtalumno = $('#txtalumno').val();
		$('#alumno_id').val('');
		//$("#btnAgregar").removeAttr("disabled");
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
		        var cboCiclos = $('#cboCiclos').val();

				$.ajax({
				  url: "{{url('regularidades/obtenerregularidades')}}",
				  data:{'materia_id': materia_id, 'carrera_id': carrera_id, 'planID': planID, 'alumnoid': alumnoid, 'cboCiclos': cboCiclos},
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
					var asistencia_por = 1;

					$.each(materias, function(key, value) {
						if (value.calificacion == 3 || value.calificacion == 4) {
							i = i + 1;
						}

						if (value.porcentaje_asistencia > 79) {
							asistencia_por = 1;
						} else {
							asistencia_por = 0;
						}
					});

			    	$('#cboRegularizo').children().remove().end();

			    	$('#cboRegularizo').append(
				        $('<option></option>').val(0).html('-'),
				        $('<option></option>').val(1).html('SI'),
				        $('<option></option>').val(2).html('NO')
				    );

					if (asistencia_por == 0) {
				    	$('#cboRegularizo').children().remove().end();

				    	$('#cboRegularizo').append(
					        $('<option></option>').val(0).html('-')
					    );
					}

					if ($('#anualcuatrimestral').val() == 'Anual') {
						if (i > 3) $("#btnAgregar").attr('disabled', 'disabled');
					} else {
						if (i > 2) $("#btnAgregar").attr('disabled', 'disabled');
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
						$('#cboNota').attr('disabled', 'disabled');
						$('#cboNota').children().remove().end();

						if (value.promocional == 1) {
							//$('#promocion').val(1);
							$('#cboNota').removeAttr("disabled");
							$('#cboCalificacion').removeAttr("disabled");

					    	$('#cboNota').append(
						        $('<option></option>').val(0).html('-'),
						        $('<option></option>').val(1).html('1'),
						        $('<option></option>').val(2).html('2'),
						        $('<option></option>').val(3).html('3'),
						        $('<option></option>').val(4).html('4'),
						        $('<option></option>').val(5).html('5'),
						        $('<option></option>').val(6).html('6'),
						        $('<option></option>').val(7).html('7'),
						        $('<option></option>').val(8).html('8'),
						        $('<option></option>').val(9).html('9'),
						        $('<option></option>').val(10).html('10')
						    );

						    $('#cboRecuperatorio').children().remove().end();

					    	$('#cboRecuperatorio').append(
						        $('<option></option>').val(0).html('-')
						    );

						    $('#cboRecuperatorio').attr('disabled', 'disabled');
						    $('#cboRegularizo').val(0);
					   	} else {
							//$('#promocion').val(0);
							$('#cboNota').attr('disabled', 'disabled');
							$('#cboCalificacion').removeAttr("disabled");
							$('#cboRecuperatorio').removeAttr("disabled");
							
					   		$('#cboNota').append(
						        $('<option></option>').val(0).html('-')
						    );

						    $('#cboRecuperatorio').children().remove().end();

					    	$('#cboRecuperatorio').append(
						        $('<option></option>').val(0).html('-'),
						        $('<option></option>').val(1).html(1),
						        $('<option></option>').val(2).html(2)
						    );
					   	}

						if (value.parcial == 1) {
							$('#cboParcial').children().remove().end();

					    	$('#cboParcial').append(
					    		$('<option></option>').val(0).html('-'),
						        $('<option></option>').val(1).html('1'),
						        $('<option></option>').val(2).html('2')
						    );

						    $('#cboParcial').val(2);
						}

						if (value.parcial == 2) {
							$('#cboParcial').children().remove().end();

							if ($('#anualcuatrimestral').val() == 'Anual') {
						    	$('#cboParcial').append(
						    		$('<option></option>').val(0).html('-'),
							        $('<option></option>').val(1).html('1'),
							        $('<option></option>').val(2).html('2'),
							        $('<option></option>').val(3).html('3')
							    );
						    	$('#cboParcial').val(3);
						   	} else {
						   		$('#cboParcial').append(
						   			$('<option></option>').val(0).html('-'),
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

						if (value.regularizo == 3) {
							regularizo = 'Promocionó';
						}

						if (value.calificacion == 1) {
							calificacion = 'Aprobó';
						}

						if (value.calificacion == 2) {
							calificacion = 'Desaprobó';
						}

						if (value.calificacion == 3) {
							calificacion = 'Ausente';
						}

						if (value.nota == 0) {
							nota = '-';
						}

						if (value.nota == 1) {
							nota = '1';
						}

						if (value.nota == 2) {
							nota = '2';
						}

						if (value.nota == 3) {
							nota = '3';
						}

						if (value.nota == 4) {
							nota = '4';
						}

						if (value.nota == 5) {
							nota = '5';
						}

						if (value.nota == 6) {
							nota = '6';
						}

						if (value.nota == 7) {
							nota = '7';
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

						if (value.promocional == 0) {
							promocional = 'Regular';
						} else {
							promocional = 'Promocional';
						}

						$('#table_regularidades > tbody').append('<tr><td><center>'+value.fecha_regularidad+'</center></td><td><center>'+value.nombremateria+'</center></td><td><center>'+promocional+'</center></td><td><center>'+parcial+'</center></td><td><center>'+calificacion+'</center></td><td><center>'+nota+'</center></td><td><center>'+recuperatorio+'</center></td><td><center>'+regularizo+'</center></td><td><center><a href="#" data-id="'+value.id+'" class="btn default btn-xs red btnEliminarMaterias"><i title="Eliminar" class="fa fa-trash-o"></i></a></center></td></tr>');
					});

				}).error(function(data) {
					console.log(data);
				});

			}).error(function(data) {
				console.log(data);
			});
		}
	}

	$('#cboNota').change(function() {
        $('#cboRegularizo').children().remove().end();

		if ($('#cboNota').val() < 6) {
	        $('#cboCalificacion').val(2);
	    	$('#cboRegularizo').append(
		        $('<option></option>').val(0).html('-')
		    );
	    }

	    if ($('#cboNota').val() > 6) {
			$('#cboCalificacion').val(1);

	    	if ($('#cboNota').val() < 8) {
			    $('#cboRegularizo').append(
			        $('<option></option>').val(0).html('-'),
			        $('<option></option>').val(1).html('SI'),
			        $('<option></option>').val(2).html('NO')
			    );
			} else {
				$('#cboRegularizo').append(
			        $('<option></option>').val(0).html('-'),
			        $('<option></option>').val(1).html('SI'),
			        $('<option></option>').val(2).html('NO'),
			        $('<option></option>').val(3).html('PROMOCIONÓ')
			    );
			}
		}

		$('#cboRegularizo').val(0);
	});

	$('.btnEliminarMaterias').live('click', function(){
		$('#idMateriaHidden').val($(this).data('id'));
		$('#modalEliminaMateria').modal('show');
	});

	$('#cboRegularizo').change(function() {
		var regularizo = $('#cboRegularizo').val();
        var materia_id = $('#cboMaterias').val();
    	var carrera_id = $('#cboCarrera').val();
        var planID = $('#cboPlan').val();
        var alumnoid = $('#alumno_id').val();
		var promocion = $('#promocion').val();
		var nota = $("#cboNota").val();

		if (promocion == 1) {
			if (regularizo == 3) {
				if (nota > 7) {
					$.ajax({
					  url: "{{url('regularidades/obtenerpromocion')}}",
					  data:{'materia_id': materia_id, 'carrera_id': carrera_id, 'planID': planID, 'alumnoid': alumnoid, regularizo: regularizo},
					  type: 'POST'
					}).done(function(materias) {
						console.log(materias);
						
						if (materias == 0) {
							$('#divMensaje').html('<p class="form-control-static"><h4>' + 'El Alumno no cumple con los requisitos para promocionar la materia!' + '</h4></p>');
				    		$('#MensajeCantidad').modal('show');
				    		$('#cboRegularizo').val(0);
					    	return;
						}

					}).error(function(data) {
						console.log(data);
					});
				} else {
					$('#divMensaje').html('<p class="form-control-static"><h4>' + 'El Alumno no cumple con los requisitos para promocionar la materia!' + '</h4></p>');
		    		$('#MensajeCantidad').modal('show');
		    		$('#cboRegularizo').val(0);
			    	return;
				}
			}
		}

		var calificacion = $('#cboCalificacion').val();

		if (promocion == 0) {
			if (regularizo == 1) {
				if (calificacion == 1) {
					$.ajax({
					  url: "{{url('regularidades/obtenerpromocion')}}",
					  data:{'materia_id': materia_id, 'carrera_id': carrera_id, 'planID': planID, 'alumnoid': alumnoid, regularizo: regularizo},
					  type: 'POST'
					}).done(function(materias) {
						console.log(materias);
						
						if (materias == 0) {
							$('#divMensaje').html('<p class="form-control-static"><h4>' + 'El Alumno no cumple con los requisitos para regularizar la materia!' + '</h4></p>');
				    		$('#MensajeCantidad').modal('show');
				    		$('#cboRegularizo').val(0);
					    	return;
						}

					}).error(function(data) {
						console.log(data);
					});
				} else {
					$('#divMensaje').html('<p class="form-control-static"><h4>' + 'El Alumno no cumple con los requisitos para regularizar la materia!' + '</h4></p>');
		    		$('#MensajeCantidad').modal('show');
		    		$('#cboRegularizo').val(0);
			    	return;
				}
			}
		}

		$('#btnAgregar').removeAttr("disabled");
	});

	$('#cboCalificacion').change(function() {
	    if ($('#cboCalificacion').val() == 0) {
	    	$("#cboNota").removeAttr("disabled");
	    	$("#cboRecuperatorio").removeAttr("disabled");
	    	$("#observaciones").attr('disabled', 'disabled');
	    }
	    
	    if ($('#cboCalificacion').val() == 1) {
	    	if ($('#promocion').val() == 0) {
		    	$('#cboNota').children().remove().end();
		    	$('#cboNota').attr('disabled', 'disabled');
		    	
		    	if ($('#cboParcial').val() == 1) {
		    		$("#cboRecuperatorio").attr('disabled', 'disabled');
		    	}

		        $('#cboRegularizo').children().remove().end();

		        if ($('#cboParcial').val() == 2) {
			    	$('#cboRegularizo').append(
				        $('<option></option>').val(0).html('-'),
				        $('<option></option>').val(1).html('SI'),
				        $('<option></option>').val(2).html('NO')
				    );
				    $("#cboRecuperatorio").removeAttr("disabled");
				} else {
					$('#cboRegularizo').append(
				        $('<option></option>').val(0).html('-')
				    );
				}

		        $('#cboRegularizo').val(0);
		    } else {
			    $("#cboNota").removeAttr("disabled");
		        $('#cboRegularizo').children().remove().end();

		    	if ($('#cboParcial').val() == 1) {
		    		$("#cboRecuperatorio").attr('disabled', 'disabled');
		    	}
		    	
		    	if ($('#cboParcial').val() == 2) {
		    		$("#cboRecuperatorio").attr('disabled', 'disabled');
		    	}
		    	
		        if ($('#cboParcial').val() == 3) {
			    	$('#cboRegularizo').append(
				        $('<option></option>').val(0).html('-'),
				        $('<option></option>').val(1).html('SI'),
				        $('<option></option>').val(2).html('NO'),
				        $('<option></option>').val(3).html('PROMOCIONÓ')
				    );
				    $("#cboRecuperatorio").removeAttr("disabled");
				} else {
					$('#cboRegularizo').append(
				        $('<option></option>').val(0).html('-')
				    );
				}
			}

		    $("#observaciones").attr('disabled', 'disabled');
	    }

		if ($('#cboCalificacion').val() == 2) {
			if ($('#promocion').val() == 0) {
		    	$("#cboRecuperatorio").removeAttr("disabled");
		        $('#cboRegularizo').children().remove().end();

		    	$('#cboRegularizo').append(
			        $('<option></option>').val(0).html('-'),
			        $('<option></option>').val(2).html('NO')
			    );
			} else {
				$("#cboNota").removeAttr("disabled");
			}

	    	$("#observaciones").attr('disabled', 'disabled');
	    }

		if ($('#cboCalificacion').val() == 3) {
			if ($('#promocion').val() == 0) {
		    	$('#cboNota').attr('disabled', 'disabled');
		    	$('#cboNota').children().remove().end();

		    	$('#cboNota').append(
			        $('<option></option>').val(0).html('-')
			    );

		        $('#cboRegularizo').children().remove().end();

		    	$('#cboRegularizo').append(
			        $('<option></option>').val(0).html('-'),
			        $('<option></option>').val(2).html('NO')
			    );

		    	$("#cboRecuperatorio").removeAttr("disabled");
		        $('#cboRegularizo').removeAttr("disabled");
		    } else {
				$("#cboNota").removeAttr("disabled");
			}

			$("#observaciones").removeAttr("disabled");
	    }

		$('#btnAgregar').removeAttr("disabled");
/*
		var materia_id = $('#cboMaterias').val();
    	var carrera_id = $('#cboCarrera').val();
        var planID = $('#cboPlan').val();
        var cboCiclos = $('#cboCiclos').val();
        var alumnoid = $('#alumno_id').val();

		$.ajax({
		  url: "{{url('regularidades/obtenerregularidades')}}",
		  data:{'materia_id': materia_id, 'carrera_id': carrera_id, 'planID': planID, 'alumnoid': alumnoid, 'cboCiclos': cboCiclos},
		  type: 'POST'
		}).done(function(materias) {
			console.log(materias);

				var asistencia_por = 1;

				$.each(materias, function(key, value) {
					if (value.porcentaje_asistencia > 74) {
						asistencia_por = 1;
					} else {
						asistencia_por = 0;
					}
				});

				if (asistencia_por == 0) {
			    	$('#cboRegularizo').children().remove().end();

			    	$('#cboRegularizo').append(
				        $('<option></option>').val(0).html('-')
				    );
				}

		}).error(function(data) {
			console.log(data);
		});*/
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
		$('#txtalumno').val('');
		$('#alumno_id').val('');
		$('#nombreAlumno').text('');
		$('#divDNI').html('<p class="form-control-static"></p>');

        var materia_id = $('#cboMaterias').val();
    	var carrera_id = $('#cboCarrera').val();
        var planID = $('#cboPlan').val();
        var ciclo_id = $('#cboCiclos').val();

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
				    $('#cuatrimestre').val('Anual');
				} else {
					//$('#cboCuatrimestre').append($('<option></option>').val(value.cuatrimestre).html(value.cuatrimestre + '°'));
				    $('#cuatrimestre').val(value.cuatrimestre + '°');
				}

				$('#txtalumno').focus();
			});

			$.ajax({
			  url: "{{url('asistencias/obtenermaterias')}}",
			  data:{'materia_id': materia_id, 'carrera_id': carrera_id, 'plan_id': planID},
			  type: 'POST'
			}).done(function(materia) {
				console.log(materia);

				$('#anualcuatrimestral').val(materia);
				$('#cboParcial').children().remove().end();

				if (materia == 'Anual') {
			    	$('#cboParcial').append(
			    		$('<option></option>').val(0).html('-'),
				        $('<option></option>').val(1).html('1'),
				        $('<option></option>').val(2).html('2'),
				        $('<option></option>').val(3).html('3')
				    );
				} else {
			    	$('#cboParcial').append(
			    		$('<option></option>').val(0).html('-'),
				        $('<option></option>').val(1).html('1'),
				        $('<option></option>').val(2).html('2')
				    );
				}

				$('#cboParcial').val(1);

				$.ajax({
				  url: "{{url('regularidades/obtenerregularpromocion')}}",
				  data:{'materia_id': materia_id, 'carrera_id': carrera_id, 'plan_id': planID, 'ciclo_id': ciclo_id},
				  type: 'POST'
				}).done(function(promocional) {
					console.log(promocional);

					$('#promocion').val(promocional);

					if (promocional == 1) {
						$('#cboNota').removeAttr("disabled");
					} else {
						$('#cboNota').attr('disabled', 'disabled');
					}
					
					$('#cboNota').children().remove().end();

			    	$('#cboNota').append(
				        $('<option></option>').val(0).html('-'),
				        $('<option></option>').val(1).html('1'),
				        $('<option></option>').val(2).html('2'),
				        $('<option></option>').val(3).html('3'),
				        $('<option></option>').val(4).html('4'),
				        $('<option></option>').val(5).html('5'),
				        $('<option></option>').val(6).html('6'),
				        $('<option></option>').val(7).html('7'),
				        $('<option></option>').val(8).html('8'),
				        $('<option></option>').val(9).html('9'),
				        $('<option></option>').val(10).html('10')
				    );

				}).error(function(data) {
					console.log(data);
				});
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

			/*$.ajax({
			  url: '{{url('planestudios/obtenerciclo')}}',
			  data:{'plan': $('#cboPlan').val()},
			  type: 'POST'
			}).done(function(plan) {
				console.log(plan);

				$('#cboCiclos').val(plan);

			}).error(function(data) {
				console.log(data);
			});*/
		}).error(function(data) {
			console.log(data);
		});

		/*$.ajax({
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
		});*/
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
