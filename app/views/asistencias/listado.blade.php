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
					Asistencias <small> Listado de Asistencia de alumnos por Carrera</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('asistencias/listado')}}">Asistencias</a>
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
					    @if (Session::get('message_type') == AsistenciaController::OPERACION_EXITOSA)

					        <div class="note note-success">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == AsistenciaController::OPERACION_FALLIDA)

					        <div class="note note-danger">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == AsistenciaController::OPERACION_CANCELADA)

					        <div class="note note-warning">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == AsistenciaController::OPERACION_INFO)

					        <div class="note note-info">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@endif
					@endif
					<!-- COMIENZO DE LA TABLA-->
								{{ Form::open(array('url'=>'asistencias/guardar', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmListadoasistencias', 'name'=>'FrmListadoalumnos'))}}
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-files-o"></i> Asistencias
							</div>
							<div class="actions">
								<!--a href="#" {{$disabled}} id="guardar" class="btn default blue-stripe">
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Guardar </span>
								</a-->
								<a href="{{url('asistencias/listado')}}" {{ $disabled }} class="btn default blue-stripe" <?php if ($habilita == false) echo "disabled"; ?>>
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Nuevo </span>
								</a>
								<button type='submit' class="btn default green-stripe" id="btnConfirmar" {{ $disabled }}>
								<i class="fa fa-save"></i>
								<span class="hidden-480">
								Guardar </span>
								</button>
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
										<select name="cboOrganizacion" id="cboOrganizacion" class="table-group-action-input form-control" <?php if (isset($alumnosinscriptos)) echo "disabled"; ?>>
											<option value="0">Seleccione</option>
											@if (isset($organizaciones))
												@foreach ($organizaciones as $organizacion)
													<option value="{{$organizacion['id']}}" <?php if ($organizacion->id == $org_id) echo "selected"; ?>>{{$organizacion['nombre']}}</option>
												@endforeach
											@endif
										</select>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 col-sm-2 control-label" for="cbocarrera">Carrera:</label>
									<div class="col-md-6 col-sm-6">
										<select name="cboCarrera" id="cboCarrera" class="table-group-action-input form-control" <?php if (isset($alumnosinscriptos)) echo "disabled"; ?>>
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
										<select name="cboPlan" id="cboPlan" class="table-group-action-input form-control" <?php if (isset($alumnosinscriptos)) echo "disabled"; ?>>
											<option value="0">Seleccione</option>
											@if (isset($planes))
												@foreach ($planes as $plan)
													<option value="{{$plan->id}}" <?php if ($plan->id == $planID) echo "selected"; ?>>{{$plan->codigoplan}}</option>
												@endforeach
											@endif
										</select>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 control-label" for="cboCiclos">Ciclo Lectivo:</label>
									<div class="col-md-2 col-sm-3">
										<select name="cboCiclos" id="cboCiclos" class="table-group-action-input form-control" <?php if (isset($alumnosinscriptos)) echo "disabled"; ?>>
											<option value="0">Seleccione</option>
											@if (isset($ciclos))
												@foreach ($ciclos as $ciclo)
													<option value="{{$ciclo->id}}"<?php if ($ciclo->id == $ciclo_id) echo "selected"; ?>>{{$ciclo->descripcion}}</option>
												@endforeach
											@endif
										</select>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 col-sm-2 control-label" for="cboMaterias">Materias:</label>
									<div class="col-md-6 col-sm-6">
										<select name="cboMaterias" id="cboMaterias" class="table-group-action-input form-control" <?php if (isset($alumnosinscriptos)) echo "disabled"; ?>>
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
										<select name="cboDocente" id="cboDocente" class="table-group-action-input form-control" disabled>
											<option value="0">Seleccione</option>
											@if (isset($docentes))
												@foreach ($docentes as $docente)
													<option value="{{$docente['id']}}" <?php if ($docente['id'] == $docente_id) echo "selected"; ?>>{{$docente['apeynom']}}</option>
												@endforeach
											@endif
										</select>
										<input class="form-control" name="txtDocente" id="txtDocente" type="hidden" value="">
									</div>
								</div>

								<div class="portlet-body form">
									<div class="form-body">
										<div class="form-group">
											<label  class="col-md-2 col-sm-2 control-label">Alumno:</label>
											<div class="col-md-4 col-sm-4">
												<select name="cboFiltroAlumno" id="cboFiltroAlumno" class="table-group-action-input form-control" <?php if (isset($alumnosinscriptos)) echo "disabled"; ?>>
													<option value="1">Todos</option>
													<option value="2" <?php if (!$dni == '') echo "selected"; ?>>DNI</option>
												</select>
											</div>
											<div class="col-md-4 col-sm-4">
												<input class="form-control" name="txtalumno" id="txtalumno" type="text" value="{{ $dni }}" <?php if ($dni == '') echo "disabled"; ?>>
												<input class="form-control" name="alumno_id" id="alumno_id" type="hidden" value="">
											</div>										
										</div>

							<div class="form-group" id="target">
								<label class="col-md-2 control-label" >Apellido y Nombre:</label>
								<div class="col-md-4 col-sm-10">
									<label id="nombreAlumno" class="control-label text-info" id="nombreAlumno"></label>
								</div>
								<label  class="col-md-2 col-sm-2 control-label">DNI:</label>
								<div class="col-md-2 col-sm-4 text-info" id='divDNI'></div>
							</div>

									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 control-label <?php if ($errors->has('fechainicio')) echo 'text-danger' ?>">Fecha Inicio:</label>
									<div id="divavisofechaing" class="col-md-3 <?php if ($errors->has('fechainicio')) echo 'has-error' ?>">
										<div class="input-icon right">
											<i class="fa fa-exclamation tooltips iconoerrorfechaing" style="display:none" data-original-title="Fecha Incorrecta." data-container="body"></i>
											<input type="date" class="form-control" name="fechainicio" id="fechainicio" placeholder="" value="<?php if (isset($fechainicio)) echo $fechainicio; ?>" readonly>
											<!-- mostrar cuando exista error -->
									    	@if ($errors->has('fechainicio'))
										    	<span class="help-block">{{ $errors->first('fechainicio') }}</span>
									    	@endif
									    	<!--fin error-->
										</div>
									</div>
									
									<label class="col-md-2 control-label">Fecha Fin:</label>
									<div class="col-md-3">
										<input type="date" class="form-control" name="fechafin" id="fechafin" placeholder="" value="<?php if (isset($fechafin)) echo $fechafin; ?>" readonly>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label <?php if ($errors->has('fechadesde')) echo 'text-danger' ?>">Buscar por Fecha:</label>
									<div id="divavisofechaing" class="col-md-3 <?php if ($errors->has('fechadesde')) echo 'has-error' ?>">
										<div class="input-icon right">
											<i class="fa fa-exclamation tooltips iconoerrorfechaing" style="display:none" data-original-title="Fecha Incorrecta." data-container="body"></i>
											<input type="date" class="form-control" name="fechadesde" id="fechadesde" placeholder="" value="<?php if (isset($fechadesdes)) echo $fechadesdes; ?>" <?php if (isset($alumnosinscriptos)) echo "disabled"; ?>>
											<!-- mostrar cuando exista error -->
									    	@if ($errors->has('fechadesde'))
										    	<span class="help-block">{{ $errors->first('fechadesde') }}</span>
									    	@endif
									    	<!--fin error-->
										</div>
									</div>
									
									<div class="col-md-2 col-sm-2">
										<center>
											<label class="control-label" for="asistencias">Asistencia
											<input type="checkbox" class="form-control" id="asistencias" name="asistencias" <?php if (isset($alumnosinscriptos)) echo "disabled"; ?>></label>
										</center>
									</div>

									<div class="col-md-2 col-sm-2">
										<!--button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> Buscar</button-->
										<a class="btn blue-madison" id='btnBuscar' <?php if (isset($alumnosinscriptos)) echo "disabled"; ?>>
											<i class="fa fa-search"></i> Buscar
										</a>
									</div>
								</div>
							</div>
							<div class="portlet-body">
								<div class="box-body table-responsive no-padding">
									<table class="table table-striped table-bordered table-hover" id="table_asistencias">
										<thead>
										<tr>
											<th>
												<center></center>
											</th>
											<th>
												<center></center>
											</th>
											<th <?php //if ($lunes == date('d')) echo "class=success"; ?>>
												<center>Lunes</center>
											</th>
											<th <?php //if ($martes == date('d')) echo "class=success"; ?>>
												<center>Martes</center>
											</th>
											<th <?php //if ($miercoles == date('d')) echo "class=success"; ?>>
												<center>Miércoles</center>
											</th>
											<th <?php //if ($jueves == date('d')) echo "class=success"; ?>>
												<center>Jueves</center>
											</th>
											<th <?php //if ($viernes == date('d')) echo "class=success"; ?>>
												<center>Viernes</center>
											</th>
											<th <?php //if ($sabado == date('d')) echo "class=success"; ?>>
												<center>Sábado</center>
											</th>
										</tr>
										<tr>
											<th>
												<center><i class="fa fa-users"></i> Alumno</center>
											</th>
											<th>
												<center><i class="fa fa-files-o"></i> N° Doc.</center>
											</th>
											<th <?php if ($lunes == date('d')) echo "class=success"; ?>>
												<center><?php echo $lunes.'/'.$meses[$lunesmes]; ?></center>
											</th>
											<th <?php if ($martes == date('d')) echo "class=success"; ?>>
												<center><?php echo $martes.'/'.$meses[$martesmes]; ?></center>
											</th>
											<th <?php if ($miercoles == date('d')) echo "class=success"; ?>>
												<center><?php echo $miercoles.'/'.$meses[$miercolesmes]; ?></center>
											</th>
											<th <?php if ($jueves == date('d')) echo "class=success"; ?>>
												<center><?php echo $jueves.'/'.$meses[$juevesmes]; ?></center>
											</th>
											<th <?php if ($viernes == date('d')) echo "class=success"; ?>>
												<center><?php echo $viernes.'/'.$meses[$viernesmes]; ?></center>
											</th>
											<th <?php if ($sabado == date('d')) echo "class=success"; ?>>
												<center><?php echo $sabado.'/'.$meses[$sabadomes]; ?></center>
											</th>
										</tr>
										</thead>
										<tbody>
											@if (isset($alumnosinscriptos))
												@foreach ($alumnosinscriptos as $value)
													<?php
													$lunes = '';
													$martes = '';
													$miercoles = '';
													$jueves = '';
													$viernes = '';
													$sabado = '';
													$lunestabla = '';
													$martestabla = '';
													$miercolestabla = '';
													$juevestabla = '';
													$viernestabla = '';
													$sabadotabla = '';
													$activo = 'disabled';

													$tabla = '<tr><td><center>'.$value['apellido'].', '.$value['nombre'].'</center></td><td><center>'.$value['nrodocumento'].'</center></td>';
														
													if ($value['lunes'] == 1 || $value['lunes'] == 0 || $value['lunes'] == 2) {
														if ($value['lunes'] == 1) $lunes = 'checked';
														$lunestabla = '<input type="checkbox" name="lunes[]" value="'.$value['alumno_id'].'" '.$lunes.' '.$activo.'>';
													}
													
													if ($value['lunes'] == 4) {
														$lunestabla = '<label tabindex="0" class="checkbox"><input type="hidden" name="lunes[]" value="'.$value['alumno_id'].'" style="display:none">Feriado</label>';
													}
													
													if ($value['martes'] == 1 || $value['martes'] == 0 || $value['martes'] == 2) {
														if ($value['martes'] == 1) $martes = 'checked';
														$martestabla = '<input type="checkbox" name="martes[]" value="'.$value['alumno_id'].'" '.$martes.' '.$activo.'>';
													}

													if ($value['martes'] == 4) {
														$martestabla = '<label tabindex="0" class="checkbox"><input type="hidden" name="martes[]" value="'.$value['alumno_id'].'" style="display:none">Feriado</label>';
													}
													
													if ($value['miercoles'] == 1 || $value['miercoles'] == 0 || $value['miercoles'] == 2) {
														if ($value['miercoles'] == 1) $miercoles = 'checked';
														$miercolestabla = '<input type="checkbox" name="miercoles[]" value="'.$value['alumno_id'].'" '.$miercoles.' '.$activo.'>';
													}

													if ($value['miercoles'] == 4) {
														$miercolestabla = '<label tabindex="0" class="checkbox"><input type="hidden" name="miercoles[]" value="'.$value['alumno_id'].'" style="display:none">Feriado</label>';
													}
													
													if ($value['jueves'] == 1 || $value['jueves'] == 0 || $value['jueves'] == 2) {
														if ($value['jueves'] == 1) $jueves = 'checked';
														$juevestabla = '<input type="checkbox" name="jueves[]" value="'.$value['alumno_id'].'" '.$jueves.' '.$activo.'>';
													}

													if ($value['jueves'] == 4) {
														$juevestabla = '<label tabindex="0" class="checkbox"><input type="hidden" name="jueves[]" value="'.$value['alumno_id'].'" style="display:none">Feriado</label>';
													}
													
													if ($value['viernes'] == 1 || $value['viernes'] == 0 || $value['viernes'] == 2) {
														if ($value['viernes'] == 1) $viernes = 'checked';
														$viernestabla = '<input type="checkbox" name="viernes[]" value="'.$value['alumno_id'].'" '.$viernes.' '.$activo.'>';
													}

													if ($value['viernes'] == 4) {
														$viernestabla = '<label tabindex="0" class="checkbox"><input type="hidden" name="viernes[]" value="'.$value['alumno_id'].'" style="display:none">Feriado</label>';
													}
													
													if ($value['sabado'] == 1 || $value['sabado'] == 0 || $value['sabado'] == 2) {
														if ($value['sabado'] == 1) $sabado = 'checked';
														$sabadotabla = '<input type="checkbox" name="sabado[]" value="'.$value['alumno_id'].'" '.$sabado.' '.$activo.'>';
													}

													if ($value['sabado'] == 4) {
														$sabadotabla = '<label tabindex="0" class="checkbox"><input type="hidden" name="sabado[]" value="'.$value['alumno_id'].'" style="display:none">Feriado</label>';
													}
													
													$tabladetalle = $tabla . '<td><center>'.$lunestabla.'</center></td><td><center>'.$martestabla.'</center></td><td><center>'.$miercolestabla.'</center></td><td><center>'.$juevestabla.'</center></td><td><center>'.$viernestabla.'</center></td><td><center>'.$sabadotabla.'</center></td></tr>';

													echo $tabladetalle;
													?>
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
	
	$("#asistencias").attr('disabled', 'disabled');
	$("#btnConfirmar").attr('disabled', 'disabled');
	$("#txtalumno").attr('disabled', 'disabled');
	$('#target').hide();

	$('#fechadesde').keydown( function(e) {
	    var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
	    if(key == 13) {
	        e.preventDefault();
	        var activo = 'disabled';
	        $("#asistencias").removeAttr("disabled");
	        Inscripciones(activo);
	        $('#btnBuscar').focus();
	    }
	});

	$('#txtalumno').keydown( function(e) {
	    var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
	    if(key == 13) {
	        e.preventDefault();
	        var activo = 'disabled';
	        $("#asistencias").removeAttr("disabled");
	        Inscripciones(activo);
	        $('#btnBuscar').focus();
	    }
	});

	$("#asistencias").change(function () {
	    if ($(this).is(':checked')) {
	        var activo = 'enabled';
			Inscripciones(activo);
			$("#btnConfirmar").removeAttr("disabled");
	    } else {
	        var activo = 'disabled';
			Inscripciones(activo);
			$("#btnConfirmar").attr('disabled', 'disabled');
	    }
	});

	$('#btnBuscar').click(function() {
		$("#asistencias").removeAttr("disabled");
		var activo = 'disabled';
		var txtalumno = $('#txtalumno').val();
    	var fechadesde = $('#fechadesde').val();
    	var fechainicio = $('#fechainicio').val();
    	var fechafin = $('#fechafin').val();

		var hoy = new Date();
		var dd = hoy.getDate();
		var mm = hoy.getMonth()+1; //hoy es 0!
		var yyyy = hoy.getFullYear();

		if(dd < 10) {
		    dd = '0'+dd;
		}

		if(mm < 10) {
		    mm = '0'+mm;
		}

		var fechahoy = yyyy+'-'+mm+'-'+dd;

    	if (fechadesde == '') {
	    	fechadesde = yyyy+'-'+mm+'-'+dd;
	    } else {
		    if (fechadesde > fechahoy) {
			    $('#divMensaje').html('<p class="form-control-static"><h4>' + 'No puede seleccionar una fecha mayor a la actual!' + '</h4></p>');
	    		$('#MensajeCantidad').modal('show');
		    	return;
			}

			if (fechainicio > fechadesde) {
			    $('#divMensaje').html('<p class="form-control-static"><h4>' + 'La fecha no se encuentra en el ciclo lectivo!' + '</h4></p>');
	    		$('#MensajeCantidad').modal('show');
		    	return;
			}
		}

	    if (fechadesde > fechafin) {
		    $('#divMensaje').html('<p class="form-control-static"><h4>' + 'La fecha seleccionada no se encuentra en el ciclo lectivo!' + '</h4></p>');
    		$('#MensajeCantidad').modal('show');
	    	return;
		}

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

    	if (fechadesde == '') {
    		activo = 'disabled';
    	}
		
		Inscripciones(activo);
	});

	function Inscripciones(activo) {
        var materia_id = $('#cboMaterias').val();
    	var carrera_id = $('#cboCarrera').val();
        var planID = $('#cboPlan').val();
        var cboCiclos = $('#cboCiclos').val();
    	var txtalumno = $('#txtalumno').val();
    	var fechadesde = $('#fechadesde').val();

		$.ajax({
		  url: "{{url('asistencias/obtenerasistencias')}}",
		  data:{'cboMaterias': materia_id, 'cboCarrera': carrera_id, 'cboPlan': planID, 'fechadesde': fechadesde, 'txtalumno': txtalumno, 'cboCiclos': cboCiclos},
		  type: 'POST'
		}).done(function(materias) {
			console.log(materias);

			//$("#table_asistencias").find("tr:gt(1)").remove();
			$("#table_asistencias").find("tr:gt(0)").remove();
			var tabla = '';
			var tabladetalle = '';
			var tablacargada = '';
			var bandera = true;

			$.each(materias, function(key, value) {
				var lunes = '';
				var martes = '';
				var miercoles = '';
				var jueves = '';
				var viernes = '';
				var sabado = '';
				var lunestabla = '';
				var martestabla = '';
				var miercolestabla = '';
				var juevestabla = '';
				var viernestabla = '';
				var sabadotabla = '';
				var tablahead = '';

				tabla = '<tr><td><center>'+value.apellido+', '+value.nombre+'</center></td><td><center>'+value.nrodocumento+'</center></td>';
					
				if (value.lunes == 1 || value.lunes == 0 || value.lunes == 2) {
					if (value.lunes == 1) lunes = 'checked';
					lunestabla = '<input type="checkbox" name="lunes[]" value="'+value.alumno_id+'" '+lunes+' '+activo+'>';
				}
				
				if (value.lunes == 4) {
					lunestabla = '<label tabindex="0" class="checkbox"><input type="checkbox" name="lunes[]" value="'+value.alumno_id+'" style="display:none">Feriado</label>';
				}
				
				if (value.martes == 1 || value.martes == 0 || value.martes == 2) {
					if (value.martes == 1) martes = 'checked';
					martestabla = '<input type="checkbox" name="martes[]" value="'+value.alumno_id+'" '+martes+' '+activo+'>';
				}

				if (value.martes == 4) {
					martestabla = '<label tabindex="0" class="checkbox"><input type="checkbox" name="martes[]" value="'+value.alumno_id+'" style="display:none">Feriado</label>';
				}
				
				if (value.miercoles == 1 || value.miercoles == 0 || value.miercoles == 2) {
					if (value.miercoles == 1) miercoles = 'checked';
					miercolestabla = '<input type="checkbox" name="miercoles[]" value="'+value.alumno_id+'" '+miercoles+' '+activo+'>';
				}

				if (value.miercoles == 4) {
					miercolestabla = '<label tabindex="0" class="checkbox"><input type="checkbox" name="miercoles[]" value="'+value.alumno_id+'" style="display:none">Feriado</label>';
				}
				
				if (value.jueves == 1 || value.jueves == 0 || value.jueves == 2) {
					if (value.jueves == 1) jueves = 'checked';
					juevestabla = '<input type="checkbox" name="jueves[]" value="'+value.alumno_id+'" '+jueves+' '+activo+'>';
				}

				if (value.jueves == 4) {
					juevestabla = '<label tabindex="0" class="checkbox"><input type="checkbox" name="jueves[]" value="'+value.alumno_id+'" style="display:none">Feriado</label>';
				}
				
				if (value.viernes == 1 || value.viernes == 0 || value.viernes == 2) {
					if (value.viernes == 1) viernes = 'checked';
					viernestabla = '<input type="checkbox" name="viernes[]" value="'+value.alumno_id+'" '+viernes+' '+activo+'>';
				}

				if (value.viernes == 4) {
					viernestabla = '<label tabindex="0" class="checkbox"><input type="checkbox" name="viernes[]" value="'+value.alumno_id+'" style="display:none">Feriado</label>';
				}
				
				if (value.sabado == 1 || value.sabado == 0 || value.sabado == 2) {
					if (value.sabado == 1) sabado = 'checked';
					sabadotabla = '<input type="checkbox" name="sabado[]" value="'+value.alumno_id+'" '+sabado+' '+activo+'>';
				}

				if (value.sabado == 4) {
					sabadotabla = '<label tabindex="0" class="checkbox"><input type="checkbox" name="sabado[]" value="'+value.alumno_id+'" style="display:none">Feriado</label>';
				}
				
				tabladetalle = tabla + '<td><center>'+lunestabla+'</center></td><td><center>'+martestabla+'</center></td><td><center>'+miercolestabla+'</center></td><td><center>'+juevestabla+'</center></td><td><center>'+viernestabla+'</center></td><td><center>'+sabadotabla+'</center></td></tr>';

				if (bandera == true) {
					tablahead = '<tr><th><center><i class="fa fa-users"></i> Alumno</center></th><th><center><i class="fa fa-files-o"></i> N° Doc.</center></th><th><center>'+value.lunest+'</center></th><th><center>'+value.martest+'</center></th><th><center>'+value.miercolest+'</center></th><th><center>'+value.juevest+'</center></th><th><center>'+value.viernest+'</center></th><th><center>'+value.sabadot+'</center></th></tr>';
					bandera = false;
				}

				$('#table_asistencias > thead').append(tablahead);

				$('#table_asistencias > tbody').append(tabladetalle);
				$('#fechas').val(value.fecha);
				$("#imprimir").removeAttr("disabled");
	    		//$("#asistencias").prop('checked', 'true');
			});

		}).error(function(data) {
			console.log(data);
		});
	}

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

	    $("#imprimir").attr('disabled', 'disabled');
	});

	$('#cboOrganizacion').select2({
		placeholder: "Seleccione",
		allowClear: true
	});

	$('#imprimir').on('click', function(e){
		e.preventDefault();
		window.open("{{url('asistencias/imprimir')}}?planID=" + $('#cboPlan').val() + '&carrera_id=' + $('#cboCarrera').val() + '&txtalumno=' + $('#txtalumno').val() + '&fechadesde=' + $('#fechadesde').val() + '&materia_id=' + $('#cboMaterias').val() + '&docente_id=' + $('#cboDocente').val() + '&cboCiclos=' + $('#cboCiclos').val());
	});

    $('#cboMaterias').change(function() {
    	limpiar_tabla();

        if ($('#cboMaterias').val() == 0) return;
		$('#cboDocente').children().remove().end();

        var materia_id = $('#cboMaterias').val();
    	var carrera_id = $('#cboCarrera').val();
        var planID = $('#cboPlan').val();
        var cboCiclos = $('#cboCiclos').val();
        $('#txtDocente').val('');

		$.ajax({
		  url: "{{url('asignardocente/obtenerdocentes')}}",
		  data:{'materia_id': materia_id, 'carrera_id': carrera_id, 'planID': planID},
		  type: 'POST'
		}).done(function(docentes) {
			console.log(docentes);

			$("#table_asistencias").find("tr:gt(1)").remove();

			if (docentes == '') {
				$('#divMensaje').html('<p class="form-control-static"><h4><center>' + 'LA MATERIA NO POSEE DOCENTES ASIGNADOS!' + '</center></h4></p>');
	    		$('#MensajeCantidad').modal('show');
		    	return;
		    }

			/*$('#cboDocente').append(
		        $('<option></option>').val(0).html('Seleccionar')
		    );*/

			$.each(docentes, function(key, value) {
				$('#cboDocente').append(
			        $('<option></option>').val(value.titular_id).html(value.apeynomtitular), $('<option></option>').val(value.provisorio_id).html(value.apeynomprovisorio), $('<option></option>').val(value.suplente_id).html(value.apeynomsuplente)
			    );
			    $('#txtDocente').val(value.titular_id);
			});

			$('#fechainicio').val('');
			$('#fechafin').val('');

			$.ajax({
			  url: "{{url('asistencias/obtenerfechas')}}",
			  data:{'materia_id': materia_id, 'carrera_id': carrera_id, 'planID': planID, 'cboCiclos': cboCiclos},
			  type: 'POST'
			}).done(function(materias) {
				console.log(materias);
				
				$.each(materias, function(key, value) {
					if (value.fechainicio == null || value.fechainicio == '') {
						$('#divMensaje').html('<p class="form-control-static"><h4><center>' + 'LA MATERIA NO POSEE FECHA INICIO Y FECHA FIN!' + '</center></h4></p>');
						//$('#cboMaterias').val(0);
				    	$('#cboCarrera').val(0);
				        $('#cboPlan').val(0);
				        $('#cboCiclos').val(0);
			    		$('#MensajeCantidad').modal('show');
				    	return;
				    }

					$('#fechainicio').val(value.fechainicio);
					$('#fechafin').val(value.fechafin);
				});

			}).error(function(data) {
				console.log(data);
			});
		}).error(function(data) {
			console.log(data);
		});

	    $("#imprimir").attr('disabled', 'disabled');
    });

	$('#cboCiclos').on('change', function() {
		if ($('#cboCiclos').val() == 0) return;
		limpiar_tabla();
		$('#fechainicio').val('');
		$('#fechafin').val('');

		$('#cboMaterias').children().remove().end();

        var plan_id = $('#cboPlan').val();
    	var carrera_id = $('#cboCarrera').val();
        var cboCiclos = $('#cboCiclos').val();

		$.ajax({
		  url: "{{url('asistencias/obtenermaterias')}}",
		  data:{'plan_id': plan_id, 'carrera_id': carrera_id, 'cboCiclos': cboCiclos},
		  type: 'POST'
		}).done(function(materias) {
			console.log(materias);

			$("#table_asistencias").find("tr:gt(1)").remove();

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

	    $("#imprimir").attr('disabled', 'disabled');
	});

    $('#cboPlan').change(function() {
    	limpiar_tabla();
		$('#fechainicio').val('');
		$('#fechafin').val('');

        if ($('#cboPlan').val() == 0) return;
		$('#cboMaterias').children().remove().end();

        var plan_id = $('#cboPlan').val();
    	var carrera_id = $('#cboCarrera').val();
		$('#cboCiclos').children().remove().end();

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

	    $("#imprimir").attr('disabled', 'disabled');
    });

    $('#cboCarrera').change(function() {
    	limpiar_tabla();
		$('#fechainicio').val('');
		$('#fechafin').val('');

        if ($('#cboCarrera').val() == 0) return;
		$('#cboPlan').children().remove().end();

        var carrera_id = $('#cboCarrera').val();

		$.ajax({
		  url: "{{url('asistencias/obtenerplanes')}}",
		  data:{'carrera_id': carrera_id},
		  type: 'POST'
		}).done(function(planes) {
			console.log(planes);

			$("#table_asistencias").find("tr:gt(1)").remove();

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

	    $("#imprimir").attr('disabled', 'disabled');
    });

    $('#cboOrganizacion').change(function() {
    	// 1 - limpiar todo
		$('#fechainicio').val('');
		$('#fechafin').val('');

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

			$("#table_asistencias").find("tr:gt(1)").remove();

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

	    $("#imprimir").attr('disabled', 'disabled');
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
