@extends('layouts.master')

@section('customstyle')
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/select2/select2.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/jquery-multi-select/css/multi-select.css')}}"/>
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
					Inscripciones <small>inscripción a carreras</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('alumnos/listado')}}">Alumnos</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">Inscripción</a>
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
								<p> {{ Session::get('message') }} </p>
							</div>
						@elseif (Session::get('message_type') == AlumnosController::OPERACION_FALLIDA)

							<div class="note note-danger">
								<p> {{ Session::get('message') }} </p>
							</div>

						@endif	
					@endif
					<!-- COMIENZO DE LA TABLA-->
					{{ Form::open(array('url'=>'inscripciones/guardar', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmAsignacarrera', 'name'=>'FrmAsignacarrera'))}}
					
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-user"></i> Alumno (Asignación de Carreras)
							</div>
							<div class="actions">
								<button {{$disabled}} type='submit' class="btn default green-stripe">
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Guardar </span>
								</button>
								<a href="{{url('alumnos/listado')}}" class="btn default yellow-stripe">
								<i class="fa fa-reorder"></i>
								<span class="hidden-480">
								Listado </span>
								</a>
							</div>

						</div>
						<div class="portlet-body form">
								<div class="tabbable-custom">
									<ul class="nav nav-tabs">
										<li>
											<a href="{{url('alumnos/editar')}}/{{$alumno->id}}">
											Datos Personales </a>
										</li>
										<li class="active">
											<a href="#tab_inscripciones" data-toggle="tab">
											Inscripciones </a>
										</li>
										<li>
											<a href="{{url('alumnos/legajo')}}/{{$alumno->id}}" >
											Legajo </a>
										</li>
										<li>
											<a href="{{url('alumnos/familia')}}/{{$alumno->id}}">
											Familia </a>
										</li>
									</ul>
								</div>

							<input type='hidden' id='txt_alumno_id' name='txt_alumno_id' value='{{$alumno->id}}'>

								<div class="form-group">
									<div class="col-md-4">
										<h4 class="text-info">Alumno: {{$alumno->persona->apellido}}, {{$alumno->persona->nombre}}</h4>
									</div>
									<div class="col-md-6">
										<h4 class="text-info">Legajo: {{$alumno->nrolegajo}} </h4>
									</div>													
								</div>

								<div class="form-group">
									<label class="col-md-3 col-sm-3 control-label">Organizaci&oacute;n:</label>
									<div class="col-md-6 col-sm-6">
										{{ Form::select('cboOrganizacion', $organizaciones, Input::old('cboOrganizacion'), array('class'=>'table-group-action-input form-control', 'id'=>'cboOrganizacion', $disabled)); }}
									</div>
								</div>
								<div class="form-group">
									  <label id='ciclo_lectivo_activo' class="col-md-3 col-sm-3 control-label">Ciclo Lectivo:
									  </label>
									  <input type='hidden' name='txt_ciclo_lectivo_id' id='txt_ciclo_lectivo_id' value=''>
								</div>

								<div class="form-body">
									<div class="form-group">
										<label class="control-label col-md-2 col-sm-2">Carreras Disponibles:</label>
										<div class="col-md-8 col-sm-8">
											{{ Form::select('carreras[]', array(), Input::old('carreras'), array('class'=>'table-group-action-input form-control multi-select','id'=>'carreras', 'multiple'=>'multiple')); }}
										</div>
										<div class="col-md-2 col-sm-2">
											<label class="pull-left">Carreras Asignadas</label>
										</div>
									</div>

								</div>
						</div> <!-- FIN PORTLET-BODY -->
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

	$('#carreras').multiSelect();

	$('#cboOrganizacion').change(function() {
	    var organizacion_id = $('#cboOrganizacion').val();

        $('#ciclo_lectivo_activo').text('Ciclo Lectivo:');
        $('#txt_ciclo_lectivo_id').val('');
        $('#carreras').children().remove().end();
        $('#carreras').multiSelect('refresh');

	    if (organizacion_id == 0) return;

		$.ajax({
		  url: "{{url('inscripciones/obtenercicloactivo')}}",
		  data:{'organizacion_id': organizacion_id},
		  type: 'POST'
		}).done(function(ciclo) {
			console.log(ciclo);
			if (ciclo == <?php echo InscripcionesController::NO_EXISTE_CICLO_ACTIVO ?>) {
				alert('LA ORGANIZACIÓN NO TIENE CICLO LECTIVO ACTIVO');
				return;
		    }

		    $('#ciclo_lectivo_activo').text('Ciclo Lectivo: ' + ciclo.descripcion);
		    $('#txt_ciclo_lectivo_id').val(ciclo.id);

			$.ajax({
			  url: "{{url('organizacions/obtenercarreras')}}",
			  data:{'organizacion_id': organizacion_id},
			  type: 'POST'
			}).done(function(carreras) {
				console.log(carreras);
				if (carreras == <?php echo OrganizacionsController::NO_TIENE_CARRERAS ?>) {
					alert('LA ORGANIZACIÓN NO TIENE CARRERAS CARGADAS');
					return;
			    }

				$.each(carreras, function(key, value) {
				    <?php foreach ($alumno->carreras as $carrera) : ?>
				        if (value.id == <?php echo $carrera->id ?>) {
							$('#carreras').append(
						        $('<option selected></option>').val(value.id).html(value.carrera)
						    );
				        } else {
							$('#carreras').append(
							    $('<option></option>').val(value.id).html(value.carrera)
							);
				        }
				    <?php endforeach; ?>
				});

				$('#carreras').multiSelect('refresh');

			}).error(function(data){
				console.log(data);
			});

		}).error(function(data){
			console.log(data);
		});
	});

@stop

@section('includejs') 
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{url('assets/global/plugins/select2/select2.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js')}}"></script>
<!-- END PAGE LEVEL PLUGINS -->
@stop
