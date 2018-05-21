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
					Inscripciones <small>inscripción a materias</small>
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
								<button {{ $disabled }} type='submit' class="btn default green-stripe">
								<i class="fa fa-plus"></i>
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
											{{ Form::select('organizacion', $arrOrganizaciones, Input::old('organizacion'), array('class'=>'table-group-action-input form-control','id'=>'organizacion')); }}
										</div>
									</div>


									<div class="form-group">
										<label class="col-md-2 control-label" for="carrera">Carrera:</label>
										<div class="col-md-6 col-sm-10">
											{{ Form::select('carreras', $carreras, Input::old('carrera'), array('class'=>'table-group-action-input form-control','id'=>'carrera')); }}
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-2 control-label" for="carrera">Plan de estudios:</label>
										<div class="col-md-4 col-sm-10">
											{{ Form::select('planes', $planes, Input::old('planEstudio'), array('class'=>'table-group-action-input form-control','id'=>'planEstudio')); }}
										</div>
										<label class="col-md-2 control-label" for="carrera">Ciclo lectivo:</label>
										<div class="col-md-4 col-sm-10">
											<label class="control-label text-info" id="estadoCiclo"></label>
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
								<table class="table table-hover" id="table-materias">
									<thead>
									<tr>
										<th>
											<center><i class="fa fa-indent"></i> Carrera</center>
										</th>
										<th class="hidden-xs">
											<center><i class="fa fa-eye"></i> Nombre</center>
										</th>
										<th>
											<center><i class="fa fa-edit"></i> Plan/Estudio</center>
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
@stop


@section('customjs')
	
	$('#FrmInscripcion').on('submit', function(){
		if (document.getElementById('materiasdisponibles').options.selectedIndex == -1) {
			alert('Seleccione una materia');
			return false;
		}
	});
	var url_destino = "{{url('alumnos/obteneralumnopordni')}}";

	$("#search").on('click', function(){
		if (document.getElementById('documento').value.length < 8 || document.getElementById('documento').value == "") {
			alert('Ingrese un DNI válido');		
			$('#nombreAlumno').text("");
			return false;
		}

		$.ajax({
			url: url_destino,
			data: {'txt_alumno': $("#documento").val()},
			type: 'POST',
			dataType: 'json',
			cache: false	
		}).done(function(alumno){
			if (alumno.apellido == undefined && alumno.nombre == undefined) {
				$('#nombreAlumno').text('no se encontro el alumno');
				return false;
			}
			var name = alumno.apellido + ", " + alumno.nombre;
			name.toUpperCase();
			$('#nombreAlumno').text(name);
			$('#alumno_id').val(alumno.alumno_id);
			//console.log(alumno);	
			var urlRequest = "{{url('inscripcionfinal/obtenermaterias')}}";

			$.ajax({
				url: urlRequest,
				data: "nrodni=" + document.getElementById('documento').value,
				type: 'POST',
				dataType: 'json',
				cache: false	
			}).done(function(materias){
				console.log(materias);
				var arr = $.map(materias, function(el) { return el });
				console.log(arr);
				$.each(arr, function(index, value) {
					$('#materiasdisponibles').append('<option value=' + value.id + '>' + value.nombre + '</>');
					$('#table-materias').append(
						'<tr><td><center>' + value.carrera + '</center></td><td><center>' +
						 value.nombre + '</center></td><td>' + 
						'<center>' + value.plan + '</td></center></tr>'
					);
					$('#materiasdisponibles').multiSelect('refresh');
				});
				/* aca se arma la tabla de abajo Diego Maximiliano */
			});
		});

	});

	$('#planEstudio').on('change', function() {
		var request = "{{url('inscripcionfinal/obtenerciclolectivo')}}";
		/*aca hay que validar*/
		$.ajax({
			url: request,
			data: {'plan_id': $("#planEstudio").val()},
			type: 'POST',
			dataType: 'json',
			cache: false
		}).done(function(ciclo){
			if (ciclo == 1) {
				$('#estadoCiclo').text('Activo');	
			} else {
				$('#estadoCiclo').text('Inactivo');	
			}
		});
	});


	$('#organizacion, #carreras').select2({
		placeholder: "Seleccione",
		allowClear: true
	});

	$('#planEstudio').select2({
		placeholder: "Seleccione",
		allowClear: true
	});	
	
	// multiselect 
	$('#materiasdisponibles').multiSelect();
	/*$('#maeriasdisponibles').on('change', function(){
		$('#materiasdisponibles').children().remove().end();
		$('#materiasdisponibles').multiSelect('refresh');
	});
*/

	//Emular Tab al presionar Enter
	$('input').keydown( function(e) {
	        var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
	        if(key == 13) {
	            e.preventDefault();
	            var inputs = $(this).closest('form').find(':input:visible');
	            inputs.eq( inputs.index(this)+ 1 ).focus();
	        }
	 });

@stop

@section('includejs') 
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{url('assets/global/plugins/select2/select2.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js')}}"></script>
<script src="{{url('assets/admin/layout/scripts/menusticky.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
@stop
