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
$disabled 	= (!$editar) ? 'disabled' : '';
$readonly 	= (!$editar) ? 'readonly' : '';
$imprimir 	= (!$imprimir) ? 'disabled' : '';
$orgId 		= (isset($OrgID)) ? $OrgID : 0;

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
					Finales <small>listado de Inscriptos a Finales</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<!--<li>
							<a href="{{url('organizacions/listado')}}">Gestion Academica</a>
							<i class="fa fa-angle-right"></i>
						</li>-->
						<li>
							<a href="{{url('inscripcionfinal')}}">Inscripciones Finales</a>
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
								<p>{{ Session::get('message') }}</p>
							</div>

						@elseif (Session::get('message_type') == InscripcionFinalesController::OPERACION_FALLIDA)

					        <div class="note note-danger">
								<p>{{ Session::get('message') }}</p>
							</div>

						@elseif (Session::get('message_type') == InscripcionFinalesController::OPERACION_CANCELADA)

					        <div class="note note-warning">
								<p>{{ Session::get('message') }}</p>
							</div>

						@elseif (Session::get('message_type') == InscripcionFinalesController::OPERACION_INFO)

					        <div class="note note-info">
								<p>{{ Session::get('message') }}</p>
							</div>

						@endif
					@endif
					<!-- COMIENZO DE LA TABLA-->
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-files-o"></i>Listado de Inscriptos
							</div>
							<div class="actions">
								<a href="{{url('inscripcionfinal/crear')}}" {{ $disabled }} class="btn default blue-stripe">
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Nuevo </span>
								</a>
								<a target="_blank" href="#" id="imprimir" {{$imprimir}} class="btn default yellow-stripe">
								<i class="fa fa-print"></i>
								<span class="hidden-480">
								Imprimir </span>
								</a>

							</div>

						</div>
						<div class="portlet-body">
							<div class="form-body">
								{{ Form::open(array('url'=>'inscripcionfinal/obtenerinscriptos', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmListadoinscriptos', 'name'=>'FrmListadoinscriptos'))}}
								<div class="form-group">
									<label  class="col-md-2 col-sm-2 control-label">Organización:</label>
									<div class="col-md-6 col-sm-10">
										{{ Form::select('organizacion', $organizaciones, Input::old('organizacion'), array('class'=>'table-group-action-input form-control','id'=>'organizacion')); }}
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 col-sm-2 control-label" for="tipocarrera">Carreras:</label>
									<div class="col-md-6 col-sm-10">
										@if (isset($carreras))
											<select name="carrera" id="carrera" class="table-group-action-input form-control">
												<option value="0">Seleccione</option>
													@foreach ($carreras as $carrera)
														<option value="{{$carrera->id}}" <?php if ($carrera->id == $carr_id) echo "selected"; ?>>{{$carrera->carrera}}</option>
													@endforeach
											</select>
										@else
											<select class="table-group-action-input form-control" name="carrera" id="carrera">
												<option value="0">Seleccione</option>
											</select>
										@endif
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 control-label" for="carrera">Materia:</label>
									<div class="col-md-6 col-sm-10">
										<select name="materias" id="materias" class="table-group-action-input form-control">
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
									<label class="col-md-2 col-sm-2 control-label" for="ciclos">Ciclo Lectivo:</label>
									<div class="col-md-6 col-sm-10">
										@if (isset($ciclos))
											<select name="ciclos" id="ciclos" class="table-group-action-input form-control">
												<option value="0">Seleccione</option>
													@foreach ($ciclos as $ciclo)
														<option value="{{$ciclo->id}}" <?php if ($ciclo->id == $ciclo_id) echo "selected"; ?>>{{$ciclo->descripcion}}</option>
													@endforeach
											</select>
										@else
											<select class="table-group-action-input form-control" name="ciclos" id="ciclos">
												<option value="0">Seleccione</option>
											</select>
										@endif
									</div>
								</div>


								<div class="form-group">
									<label  class="col-md-2 col-sm-2 control-label">Turnos de Examenes:</label>
									<div class="col-md-2 col-sm-4">
										<select name="turnos" id="turnos" class="table-group-action-input form-control">
										<option disabled value="0">Seleccione</option>
										@if (isset($turnos))
											@foreach ($turnos as $turno)
												<option value="{{$turno->id}}" <?php if ($turno->id == $turno_id) echo "selected"; ?>>{{$turno->descripcion}}</option>
											@endforeach
										@endif
									</select>
									</div>
									<!--
									<label  class="col-md-2 col-sm-2 control-label">Ciclo Lectivo:</label>
									<div class="col-md-2 col-sm-4">
										<select name="ciclos" id="ciclos" class="table-group-action-input form-control">
										<option disabled value="0">Seleccione</option>
										@if (isset($ciclos))
											@foreach ($ciclos as $ciclo)
												<option value="{{$ciclo->id}}" <?php if ($ciclo->id == $ciclo_id) echo "selected"; ?>>{{$ciclo->descripcion}}</option>
											@endforeach
										@endif
									</select>
									</div>-->

									<div class="form-group">
										<div class="col-md-6 col-sm-10">
							                <label class="col-md-4 col-sm-4 control-label">1° Llamado
							                    <input type="radio" name="llamado" id="llamado" value="1" <?php if ($llamado == 1) echo "checked = true"; ?>>
							                </label>
							                <label class="col-md-4 col-sm-4 control-label">2° Llamando	
							                    <input type="radio" name="llamado" id="llamado" value="0" <?php if ($llamado == 0) echo "checked = true"; ?>>
							                </label>
							                @if ($errors->has('llamado'))
												<span class="help-block">{{ $errors->first('llamado') }}</span>
											@endif
										</div>
	        						</div>
					
								</div>
								<div class="form-group">
									<label  class="col-md-2 col-sm-2 control-label">Filtrar por:</label>
									<div class="col-md-2 col-sm-4">
										<select name="cboFiltro" id="cboFiltro" class="table-group-action-input form-control">
											@if (isset($filtro))
											<option value="1" <?php if ($filtro == 1) echo "selected"; ?>>Todos</option>
											<option value="2" <?php if ($filtro == 2) echo "selected"; ?>>DNI</option>
											<!--<option value="3" <?php if ($filtro == 3) echo "selected=selected"; ?>>Docente</option>-->
										@else
											<option value="1">Todos</option>
											<option value="2">DNI</option>
											<!--<option value="3">Docente</option>-->
										@endif
										</select>
										@if ($errors->has('cboFiltro'))
										    <span class="help-block">{{ $errors->first('cboFiltro') }}</span>
									    @endif
									</div>
									<!--<div class="col-md-4 col-sm-4">
										@if (isset($opcion))
											<select name="opcion" id="opcion" class="table-group-action-input form-control">
												<option disabled value="0">Seleccione</option>
													@foreach ($opcion as $opc)
														<option value="{{$opc->id}}" <?php if ($opc->id == $opcion_id) echo "selected"; ?>>{{$opc->descripcion}}</option>
													@endforeach
											</select>
										@else
											<select disabled class="table-group-action-input form-control" name="opcion" id="opcion">
												<option value="0">Seleccione</option>
											</select>
										@endif
									</div>-->
									<div class="col-md-4 col-sm-4">
										<input class="form-control" name="nrodocumento" id="nrodocumento" type="number" placeholder="N° Documento"  <?php if ($dni !== '') echo  "value =  $dni "; ?>>
									</div>
									<div class="col-md-2 col-sm-2">
										<button id='BtnBuscar' class="btn btn-primary" type="submit"><i class="fa fa-search"></i> Buscar</button>
									</div>
											
									
									<!--<div class="col-md-2 col-sm-2">
										<button class="btn btn-primary" type="submit" id='BtnBuscar'><i class="fa fa-search"></i> Buscar</button>
									</div>	-->								
								</div>
									
								{{ Form::close() }}
							</div>
							<br>

							<table class="table table-striped table-bordered table-hover" id="table_finales">
								<thead>
								<tr>
									<th>
										<center><i class="fa fa-calendar"></i> Fecha Final</center>
									</th>
									<th class="hidden-xs">
										<center><i class="fa fa-files-o"></i> Alumno</center>
									</th>
									<th>
										<center><i class="fa fa-files-o"></i> Plan/Estudio</center>
									</th>
									<th class="hidden-xs">
										<center><i class="fa fa-files-o"></i> Materia Inscripta</center>
									</th>									
									<th>
										<center><i class="fa fa-files-o"></i> Docente Titular</center>
									</th>	
									<th>
										<center><i class="fa fa-rocket"></i> Acciones</center>
									</th>			

								</tr>
								</thead>
								<tbody>
									@if (isset($inscriptos))
										@foreach ($inscriptos as $mesa)
											<tr>
												<td>
													<center>
														{{$mesa['fecha']}}
													</center>
												</td>
												<td>
													<center>
														{{$mesa['alumno']}}
													</center>
												</td>
												<td>
													<center>
														{{$mesa['plan']}}
													</center>
												</td>
												<td>
													<center>
														{{$mesa['materia']}}
													</center>
												</td>
												<td>
													<center>
														{{$mesa['docentetitular']}}
													</center>
												</td>
												<td>
													<center>
													@if( $mesa['anulado'] == 0)	
														<a title="Eliminar" href="#modalEliminaInscripcion" {{ $disabled }} data-id="{{$mesa['id']}}" class="btn default btn-xs red btnEliminarInscripcion">
														<i class="fa fa-trash-o"></i></a>

														<a title="Anular" href="#modalAnularInscripcion" {{ $disabled }} data-id="{{$mesa['id']}}" class="btn default btn-xs purple btnAnularInscripcion">
														<i class="glyphicon glyphicon-ban-circle"></i></a>

													@else
														<a target="_blank" title="Acuse Anulación" href="imprimiracuse/{{$mesa['id']}}" class="btn default btn-xs purple">
														<i class="fa fa-print"></i></a>	
													@endif
													</center>
												</td>
											</tr>
										@endforeach
									@endif
								</tbody>
							</table>

						</div>
					</div>
					<!-- FIN DE LA TABLA-->
				</div>
			</div>
			<!-- FIN DEL CONTENIDO -->
		</div>
	</div>
	<!-- FIN -->
<!-- MODAL ELIMINACION DE CICLOS-->
	<div class="modal fade" id="modalEliminaInscripcion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		{{ Form::open(array('url' => 'inscripcionfinal/borrar')) }}
			<input id="idInscripcionHidden" name='idInscripcionHidden' type="hidden" value="">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Eliminar Inscripcion</h4>
					</div>
					<div class="modal-body">
						¿Estás seguro de querer borrar esta Incripción?
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn red"><i class="fa fa-trash-o"></i> Eliminar</button>
						<button type="button" class="btn default" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> Cancelar</button>
					</div>
				</div>
				<!-- /.modal-contenido -->
			</div>
		{{Form::close()}}
		<!-- /.modal-dialog -->
	</div>
	
	<!-- /.modal-anular -->
	<div class="modal fade" id="modalAnularInscripcion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		{{ Form::open(array('url' => 'inscripcionfinal/anular')) }}
			<input id="idAnularHidden" name='idAnularHidden' type="hidden" value="">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Anulación de Inscripción a Final</h4>
					</div>
					<div class="modal-body">
						¿Estás seguro de querer anular esta Incripción?
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn purple"><i class="glyphicon glyphicon-ban-circle"></i> Anular</button>
						<button type="button" class="btn default" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> Cancelar</button>
					</div>
				</div>
				<!-- /.modal-contenido -->
			</div>
		{{Form::close()}}
		<!-- /.modal-dialog -->
	</div>




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
	<!--TableAdvanced.init();-->
	
	if($('#table_finales >tbody >tr').length > 0) {
		$('#imprimir').removeAttr("disabled",'false');
	} else {
		$("#imprimir").attr('disabled', 'disabled');
	}


	//para cuando carga un filtro
		var filtro = $('#cboFiltro').val();
		
		//alert(filtro);
		
		if (filtro == 2) {
			$('#nrodocumento').removeAttr("disabled",'false');
			$('#nrodocumento').focus();
		} else {
			
			$('#nrodocumento').attr('disabled', 'disabled');
			$('#nrodocumento').val('');
		}
	//
	
	//AL PRESIONAR LOS BOTONES ELIMINAR PASO EL DATA ID DE LA CARRERA A ELIMINAR
	$('.btnEliminarInscripcion').live('click', function(){
		//PASO EL DATA ID AL CAMPO OCULTO		
		$('#idInscripcionHidden').val($(this).data('id'));
		//MUESTRO EL MODAL DE ADVERTENCIA
		$('#modalEliminaInscripcion').modal('show');
	});

	
	//AL PRESIONAR LOS BOTONES anula PASO EL DATA ID DE LA CARRERA A ELIMINAR
	$('.btnAnularInscripcion').live('click', function(){
		//PASO EL DATA ID AL CAMPO OCULTO		
		$('#idAnularHidden').val($(this).data('id'));
		//MUESTRO EL MODAL DE ADVERTENCIA
		$('#modalAnularInscripcion').modal('show');
	});



	$(document).ready(function() {
	    $('#table_finales').DataTable();
	} );

	$('#organizacion, #carrera, #plan, #cboopcion, #turnos, #ciclos, #materias').select2({
		placeholder: "Seleccione",
		allowClear: true
	});

	$('#organizacion').on('change', function(){
		var orgid = $('#organizacion').val();
		var combocarga = $('#carrera');
		var comboplan = $('#plan');
		$.ajax({
		type: "POST",
		url: "{{url('carreras/buscarjson/')}}",
		data: { organizacionid: orgid }	
		}).done(function(data) {
			console.log(data)
			combocarga.find('option').remove().end()
			combocarga.append('<option value="0" disabled selected>Seleccione</option>');
			combocarga.select2("destroy")
			
			comboplan.find('option').remove().end()
			comboplan.append('<option value="0" disabled selected>Seleccione</option>');
			comboplan.select2("destroy")


			for (i = 0; i < data.length; i++) {
				combocarga.append('<option value="'+data[i]['id']+'">'+data[i]['carrera']+'</option>')
			}
			combocarga.select2()
			comboplan.select2()
		});


		// para combo ciclo lectivo
		var combociclos = $('#ciclos');
		$.ajax({
		type: "POST",
		url: "{{url('mesaexamenes/obtenerciclos')}}",
		data: { organizacion_id: orgid }	
		}).done(function(ciclos) {
			console.log(ciclos)
			combociclos.find('option').remove().end()
			combociclos.append('<option value="0" disabled selected>Seleccione</option>');
			combociclos.select2("destroy")
			

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
	});
	

	$('#carrera').on('change', function(){

		 $("#cboFiltro").val('1')
		
		$('#opcion').find('option').remove().end()
		$('#opcion').append('<option value="0" disabled selected>Seleccione</option>');
		$('#opcion').select2("destroy")
		$('#opcion').select2();
		
		$('#materias').removeAttr('disabled');
    	var carrera_id = $('#carrera').val();
		
		$.ajax({
		  url: "{{url('mesaexamenes/obteneropciones')}}",
		  data:{'carrera_id': carrera_id, 'filtro': 2},
		  type: 'POST'
		}).done(function(opcion) {
			console.log(opcion);
			
			$('#materias').find('option').remove().end()
			$('#materias').append('<option value="0" disabled selected>Seleccione</option>');
			$('#materias').select2("destroy");
			$('#materias').select2();


			$.each(opcion, function(key, value) {
				$('#materias').append(
			        $('<option></option>').val(value.id).html(value.descripcion)
			    );
			});
			
		}).error(function(data) {
			console.log(data);
		});

	});



	
	$('#cboFiltro').on('change', function(){
		var filtro = $('#cboFiltro').val();
		
		//alert(filtro);
		
		if (filtro == 2) {
			$('#nrodocumento').removeAttr("disabled",'false');
			$('#nrodocumento').focus();
		} else {
			
			$('#nrodocumento').attr('disabled', 'disabled');
			$('#nrodocumento').val('');
		}


		
	});
	
	
	
	$('#BtnBuscar').on('click', function(e){
		var carrera_id = $('#carrera').val();
		var filtro = $('#cboFiltro').val();		
		
		if (carrera_id == 0 || carrera_id == null) {

			$('#divMensaje').html('<p class="form-control-static"><h4>' + 'Debe seleccionar una carrera para realizar la busqueda!' + '</h4></p>');
			$('#Mensajes').modal('show');

    	    //alert('Debe seleccionar una carrera para realizar la busqueda');
    	    return false;
    	} 

    	if (filtro == 2){
			var nrodocumento = $('#nrodocumento').val();	
			if(nrodocumento == 0 || nrodocumento == null || nrodocumento == '') {
				
				$('#divMensaje').html('<p class="form-control-static"><h4>' + 'Seleccione los filtros requeridos!' + '</h4></p>');
				$('#Mensajes').modal('show');
				//alert('Seleccione los filtros requeridos');
	    	    return false;
			}	
    	}
	});

	
	$('#imprimir').on('click', function(e){
		e.preventDefault();
		window.open("{{url('inscripcionfinal/imprimirlistado')}}?organizacion=" + $('#organizacion').val() + '& carrera=' + $('#carrera').val() + '& cboFiltro=' + $('#cboFiltro').val() + '& materias=' + $('#materias').val() + '& opcion=' + $('#opcion').val() + '&ciclos=' + $('#ciclos').val() + '& turnos=' + $('#turnos').val() + '& llamado=' + $('#llamado').val());
	});



@stop


@section('includejs')
	<script type="text/javascript" src="{{url('assets/global/plugins/select2/select2.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js')}}"></script>
<script src="{{url('assets/admin/layout/scripts/menusticky.js')}}" type="text/javascript"></script>
	<!--<script src="{{url('assets/admin/pages/scripts/table-advanced.js')}}"></script>-->
@stop
