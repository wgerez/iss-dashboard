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
					Perfil <small>asignación de permisos</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('perfiles/listado')}}">Perfiles</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">Asignar permisos</a>
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
					    @if (Session::get('message_type') == PerfilesController::OPERACION_EXITOSA)

							<div class="note note-success">
								<p> {{ Session::get('message') }} </p>
							</div>
						@elseif (Session::get('message_type') == PerfilesController::OPERACION_FALLIDA)

							<div class="note note-danger">
								<p> {{ Session::get('message') }} </p>
							</div>

						@endif	
					@endif
					<!-- COMIENZO DE LA TABLA-->
					{{ Form::open(array('url'=>'perfiles/guardarpermisos', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmAsignapermisos', 'name'=>'FrmAsignapermisos'))}}
					
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-user"></i> Perfil (Asignación de Permisos)
							</div>
							<div class="actions">
								<button {{ $disabled }} type='submit' class="btn default green-stripe">
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Guardar </span>
								</button>
								<a href="{{url('perfiles/listado')}}" class="btn default yellow-stripe">
								<i class="fa fa-reorder"></i>
								<span class="hidden-480">
								Listado </span>
								</a>
							</div>

						</div>
						<div class="portlet-body form">
								
								<div class="form-group">
									<div class="col-md-4">
										<input type='hidden' id='txt_perfil_id' name='txt_perfil_id' value='{{$perfil->id}}'>
										<h4 class="text-info">Perfil: {{ $perfil->perfil}}</h4>
									</div>
								</div>

								<div class="form-body">
									<div class="form-group">
										<label  class="col-md-2 col-sm-2 control-label">Módulos:</label>
										<div class="col-md-6 col-sm-6">
											<select {{ $disabled }} name="modulo" id="modulo" class="table-group-action-input form-control">
												<option value="0">Seleccionar</option>
												@foreach ($modulos as $modulo)
													<option value="{{$modulo->id}}">{{$modulo->descripcion}}</option>
												@endforeach
											</select>	
											
											<!--select class="table-group-action-input form-control" name="cbomodulos" id="cbomodulos">
												<option value="1">Gestión Académica</option>
												<option value="2">Gestón Administrativa</option>
												<option value="3">Gestión Contable</option>
											</select -->
										</div>
									</div>

									<div class="form-group">
										<label  class="col-md-2 col-sm-2 control-label">Sub Módulos:</label>
										<div class="col-md-6 col-sm-6">
											{{ Form::select('submodulo', array(), Input::old('submodulo'), array('class'=>'table-group-action-input form-control','id'=>'submodulo', $disabled)); }}
											<!--select class="table-group-action-input form-control" name="submodulos" id="submodulos">
												<option value="1">Alumnos</option>
												<option value="2">Docentes</option>
												<option value="3">Boletines</option>
											</select-->
										</div>
									</div>									

									<div class="form-group">
										<label class="control-label col-md-2 col-sm-2">Permisos Disponibles:</label>
										<div class="col-md-8 col-sm-8">
											{{ Form::select('permiso[]', array(), Input::old('permiso'), array('class'=>'table-group-action-input form-control multi-select','id'=>'permiso', 'multiple'=>'multiple', $disabled)); }}
											<!--select name="permisos" id="permisos" class="table-group-action-input form-control multi-select" multiple="multiple">
												<option value="1">Leer Alumnos</option>
												<option value="2">Editar Alumnos</option>
												<option value="3">Eliminar Alumnos</option>
												<option value="4">Imprimir Alumnos</option>
											</select-->
										</div>
										<div class="col-md-2 col-sm-2">
											<label class="pull-left">Permisos Asignados</label>
										</div>
									</div>




								<!--TABLA DE PERMISOS-->
								<table class="table table-hover" id="table_permisos">
									<thead>
									<tr>
										<th>
											<center><i class="fa fa-list"></i> Módulos</center>
										</th>
										<th>
											<center><i class="fa fa-indent"></i> Submodulos</center>
										</th>
										<th class="hidden-xs">
											<center><i class="fa fa-eye"></i> Leer</center>
										</th>
										<th>
											<center><i class="fa fa-edit"></i> Editar</center>
										</th>
										<th>
											<center><i class="fa fa-print"></i> Imprimir</center>
										</th>
										<th>
											<center><i class="fa fa-trash-o"></i> Eliminar</center>
										</th>									
									</tr>
									</thead>
										<tbody>
											@foreach ($arbolpermisos as $arbol)
												<tr class="warning">
													<td>
														{{$arbol['modulo']}}
													</td>
													<td>
														&nbsp;
													</td>
													<td>
														&nbsp;
													</td>
													<td>
														&nbsp;
													</td>
													<td>
														&nbsp;
													</td>
													<td>
														&nbsp;
													</td>
												</tr>
												@foreach($arbol['submodulos'] as $submodulo)
													<tr>
														<td>
															&nbsp;
														</td>
														<td>
															{{$submodulo['nombre']}}
														</td>
														<td>
															<center><i class="fa @if ($submodulo['leer']) {{'fa-check'}} @else {{'fa-times'}} @endif"></i></center>
														</td>
														<td>
															<center><i class="fa fa @if ($submodulo['editar']) {{'fa-check'}} @else {{'fa-times'}} @endif"></i></center>
														</td>
														<td>
															<center><i class="fa fa @if ($submodulo['imprimir']) {{'fa-check'}} @else {{'fa-times'}} @endif"></i></center>
														</td>
														<td>
															<center><i class="fa fa @if ($submodulo['eliminar']) {{'fa-check'}} @else {{'fa-times'}} @endif"></i></center>
														</td>
													</tr>
												@endforeach
											@endforeach
										</tbody>
									</table>
									<!-- FIN TABLA DE PERMISOS -->



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

	var perfil_id = {{ $perfil->id }};

	$('#modulos').select2({
		placeholder: "Seleccione",
		allowClear: true
	});

	$('#submodulos').select2({
		placeholder: "Seleccione",
		allowClear: true
	});	

	$('#permiso').multiSelect();

	//Emular Tab al presionar Enter
	$('input').keydown( function(e) {
	        var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
	        if(key == 13) {
	            e.preventDefault();
	            var inputs = $(this).closest('form').find(':input:visible');
	            inputs.eq( inputs.index(this)+ 1 ).focus();
	        }
	 });


	$('#modulo').change(function() {
        $('#submodulo').children().remove().end();
        $('#permiso').children().remove().end();
        $('#permiso').multiSelect('refresh');

		$.ajax({
		  url: "{{url('perfiles/obtenersubmodulos')}}",
		  data:{'modulo_id': $('#modulo').val()},
		  type: 'POST'
		}).done(function(submodulos) {
			console.log(submodulos);

		$('#submodulo').append(
		        $('<option></option>').val(0).html('Seleccionar')
		    );

			$.each(submodulos, function(key, value) {
				$('#submodulo').append(
			        $('<option></option>').val(value.id).html(value.descripcion)
			    );
			});
		}).error(function(data) {
			console.log(data);
		});
	});

	$('#submodulo').change(function() {
        $('#permiso').children().remove().end();
        $('#permiso').multiSelect('refresh');

		$.ajax({
		  url: "{{url('perfiles/obtenerpermisos')}}",
		  data:{'submodulo_id': $('#submodulo').val(), 'perfil_id': perfil_id, 'submod': $('#submodulo :selected').html()},
		  type: 'POST'
		}).done(function(permisos) {
			console.log(permisos);

			$.each(permisos, function(key, value) {
				var tipo = value.descripcion;

				if (value.leer == 1) {
					$('#permiso').append(
				        $('<option selected></option>').val(1).html('Leer ' + tipo)			       
			    	);
			    } else {
			    	$('#permiso').append(
				        $('<option></option>').val(1).html('Leer ' + tipo)			       
			    	);
			    }
			    if (value.editar == 1) {
					$('#permiso').append(
				        $('<option selected></option>').val(2).html('Editar ' + tipo)			       
			    	);
			    } else {
			    	$('#permiso').append(
				        $('<option></option>').val(2).html('Editar ' + tipo)			       
			    	);
			    }
			    if (value.eliminar == 1) {
					$('#permiso').append(
				        $('<option selected></option>').val(3).html('Eliminar ' + tipo)			       
			    	);
			    } else {
			    	$('#permiso').append(
				        $('<option></option>').val(3).html('Eliminar ' + tipo)			       
			    	);
			    }
			    if (value.imprimir == 1) {
					$('#permiso').append(
				        $('<option selected></option>').val(4).html('Imprimir ' + tipo)			       
			    	);
			    } else {
			    	$('#permiso').append(
				        $('<option></option>').val(4).html('Imprimir ' + tipo)			       
			    	);
			    }
			});
			
			$('#permiso').multiSelect('refresh');

		}).error(function(data) {
			console.log(data);
		});
	});

@stop

@section('includejs') 
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{url('assets/global/plugins/select2/select2.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js')}}"></script>
<script src="{{url('assets/admin/layout/scripts/menusticky.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
@stop
