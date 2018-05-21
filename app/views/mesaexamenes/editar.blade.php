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
					Examanes <small>Editar Mesa de Examanes</small>
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
							<a href="#">Editar</a>
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
								<p> {{ Session::get('message') }} </p>
							</div>
						@elseif (Session::get('message_type') == MesaexamenesController::OPERACION_FALLIDA)

							<div class="note note-danger">
								<p> {{ Session::get('message') }} </p>
							</div>

						@endif	
					@endif
					<!-- COMIENZO DE LA TABLA-->
					{{ Form::open(array('url'=>'mesaexamenes/editar', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmMesaexamen', 'name'=>'FrmMesaexamen'))}}
					
					<input type='hidden' name='txtmesaId' value='{{$mesaexamen->id}}'>

					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-info"></i> Editar de Mesa de examenes
							</div>
							<div class="actions">
								<a href="{{url('mesaexamenes/crear')}}" {{ $disabled }} class="btn default blue-stripe">
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Nuevo </span>
								</a>
								<!--<a href="{{url('correlatividades/crear')}}">-->
								<button id =guardar type='submit' class="btn default green-stripe">
								<i class="fa fa-save"></i>
								<span class="hidden-480">
								Guardar </span>
								</button>
								<!--</a>-->
								<a href="{{url('mesaexamenes/listado')}}" class="btn default yellow-stripe">
								<i class="fa fa-reorder"></i>
								<span class="hidden-480">
								Listado </span>
								</a>
							</div>

						</div>
						<div class="portlet-body form">
								
							<div class="form-body">
								<div class="form-group <?php if ($errors->has('organizacion')) echo 'has-error' ?> ">
									<label class="col-md-2 control-label" for="carrera">Organización:</label>
									<div class="col-md-6">
										<input disabled type="text" class="form-control" id="organizacion" name="organizacion" value=" {{$organizacion->nombre}}" >
										@if ($errors->has('organizacion'))
										    <span class="help-block">{{ $errors->first('organizacion') }}</span>
									    @endif
									</div>
								</div>


								<div class="form-group <?php if ($errors->has('carrera')) echo 'has-error' ?> ">
									<label class="col-md-2 control-label" for="carrera">Carrera:</label>
									<div class="col-md-6">
										<input disabled type="text" class="form-control" id="carrera" name="carrera" value=" {{$carrera->carrera}}" >
										@if ($errors->has('carrera'))
										    <span class="help-block">{{ $errors->first('carrera') }}</span>
									    @endif
									</div>
								</div>

								
								<div class="form-group <?php if ($errors->has('materia')) echo 'has-error' ?> ">
									<label class="col-md-2 control-label" for="materia">Materia:</label>
									<div class="col-md-6">
										<input disabled type="text" class="form-control" id="materia" name="materia" value=" {{$materia->nombremateria}}" >
										@if ($errors->has('materia'))
										    <span class="help-block">{{ $errors->first('materia') }}</span>
									    @endif
									</div>
								</div>

								
								<div class="form-group <?php if ($errors->has('ciclos')) echo 'has-error' ?> ">
									<label class="col-md-2 control-label" for="ciclos">Ciclo Lectivo:</label>
									<div class="col-md-6">
										<input disabled type="text" class="form-control" id="ciclos" name="ciclos" value=" {{$ciclo->descripcion}}" >
										@if ($errors->has('ciclos'))
										    <span class="help-block">{{ $errors->first('ciclos') }}</span>
									    @endif
									</div>
								</div>

								<div class="form-group">
									<label  class="col-md-2 col-sm-2 control-label">Turnos de Examenes:</label>
									<div class="col-md-2 col-sm-2">
										<input disabled type="text" class="form-control" id="turnos" name="turnos" value=" {{$turno->descripcion}}" >
										@if ($errors->has('turnos'))
										    <span class="help-block">{{ $errors->first('turnos') }}</span>
									    @endif
									</div>	
									<div class="form-group">
										<label class="col-md-2 control-label" for="observacion">Observación:</label>
										<div class="col-md-2">
											<textarea rows="5" name="observacion" class="form-control">{{ $mesaexamen->observaciones }}</textarea>
										</div>
									</div>				
								</div>

								<div class="form-group">
									<label class="col-md-2 control-label" for="fechaprimerllamado"><font color="red">Fecha Primer Llamado:</font></label>
									<div class="col-md-2">
										<input type="date" class="form-control" id="fechaprimerllamado" name="fechaprimerllamado" value="{{ $mesaexamen->fechaprimerllamado }}" >
										<!--<div class="help-block">(hs Cátedra)</div>-->
									</div>
									<label class="col-md-2 control-label" for="horaprimerllamado"><font color="red">Hora: </font></label>
									<div class="col-md-2">
										<input type="time" class="form-control" id="horaprimerllamado" name="horaprimerllamado" value="{{ $mesaexamen->horaprimerllamado }}" >
										<!--<div class="help-block">(hs Cátedra)</div>-->
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label" for="fechasegundollamado"><font color="red">Fecha Segundo Llamado:</font></label>
									<div class="col-md-2">
										<input type="date" class="form-control" id="fechasegundollamado" name="fechasegundollamado" value="{{ $mesaexamen->fechasegundollamado }}" >
										<!--<div class="help-block">(hs Cátedra)</div>-->
									</div>
									<label class="col-md-2 control-label" for="horasegundollamado"><font color="red">Hora: </font></label>
									<div class="col-md-2">
										<input type="time" class="form-control" id="horasegundollamado" name="horasegundollamado" value="{{ $mesaexamen->horasegundollamado }}" >
										<!--<div class="help-block">(hs Cátedra)</div>-->
									</div>
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
						</div>	<!-- FIN TABLA DE PERMISOS -->
					</div>
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
	
$('#docentes').multiSelect()

var arrayJS=<?php echo json_encode($tribunal);?>;

$.each(arrayJS, function(key, value) {
	if(value.seleccionado == 0) {
		$("#docentes").append('<option value="'+value.id+'">'+value.profesor+'</option>');
	} else {
		$("#docentes").append('<option value="'+value.id+'" selected>'+value.profesor+'</option>');			
	}
});

$('#docentes').multiSelect('refresh');

$('#docentes').change(function() {
	
		
		var organizacion_id = $('#organizacion').val();
		var carrera_id = $('#carreras').val();
		var materia_id = $('#materias').val();
		var ciclo_id = $('#ciclos').val();
		var turno_id = $('#turnos').val();
		
		var ultimo = $('#docentes').closest('select').find('option').filter(':selected:last').val();

		$.ajax({
		  url: "{{url('mesaexamenes/obtenerrepetidos')}}",
		  data:{'organizacion_id': organizacion_id, 'carrera_id': carrera_id, 'materia_id': materia_id, 'ciclo_id': ciclo_id, 'turno_id': turno_id},
		  type: 'POST'
		}).done(function(resultado) {
			console.log(resultado);
			
			//alert(resultado);
			if (resultado == 1){
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
<!-- END PAGE LEVEL PLUGINS -->
@stop
