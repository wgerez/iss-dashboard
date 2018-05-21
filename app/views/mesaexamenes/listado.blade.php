@extends('layouts.master')

@section('customstyle')
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/select2/select2.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css')}}"/>
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
					Examanes <small>listado de Mesa de Examanes</small>
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
					    @if (Session::get('message_type') == MesaexamenesController::OPERACION_EXITOSA)

					        <div class="note note-success">
								<p>{{ Session::get('message') }}</p>
							</div>

						@elseif (Session::get('message_type') == MesaexamenesController::OPERACION_FALLIDA)

					        <div class="note note-danger">
								<p>{{ Session::get('message') }}</p>
							</div>

						@elseif (Session::get('message_type') == MesaexamenesController::OPERACION_CANCELADA)

					        <div class="note note-warning">
								<p>{{ Session::get('message') }}</p>
							</div>

						@elseif (Session::get('message_type') == MesaexamenesController::OPERACION_INFO)

					        <div class="note note-info">
								<p>{{ Session::get('message') }}</p>
							</div>

						@endif
					@endif
					<!-- COMIENZO DE LA TABLA-->
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-files-o"></i>Listado de Mesas
							</div>
							<div class="actions">
								<a href="{{url('mesaexamenes/crear')}}" {{ $disabled }} class="btn default blue-stripe">
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
								{{ Form::open(array('url'=>'mesaexamenes/obtenermesas', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmListadoMesas', 'name'=>'FrmListadoMesas'))}}
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
										<label  class="col-md-2 col-sm-2 control-label">Filtrar por:</label>
										<div class="col-md-2 col-sm-4">
											<select name="cboFiltro" id="cboFiltro" class="table-group-action-input form-control">
												@if (isset($filtro))
													<option value="1" <?php if ($filtro == 1) echo "selected=selected"; ?>>Todos</option>
													<option value="2" <?php if ($filtro == 2) echo "selected=selected"; ?>>Materia</option>
													<option value="3" <?php if ($filtro == 3) echo "selected=selected"; ?>>Docente</option>
												@else
													<option value="1">Todos</option>
													<option value="2">Materia</option>
													<option value="3">Docente</option>
												@endif
											</select>
											@if ($errors->has('cboFiltro'))
											    <span class="help-block">{{ $errors->first('cboFiltro') }}</span>
										    @endif
										</div>
										<div class="col-md-4 col-sm-4">
											@if (isset($opcion))
												<select name="opcion" id="opcion" class="table-group-action-input form-control">
													<option disabled value="0">Seleccione</option>
														@foreach ($opcion as $opc)
															<option value="{{$opc['id']}}" <?php if ($opc['id'] == $opcion_id) echo "selected"; ?>>{{$opc['descripcion']}}</option>
														@endforeach
												</select>
											@else
												<select disabled class="table-group-action-input form-control" name="opcion" id="opcion">
													<option value="0">Seleccione</option>
												</select>
											@endif
										</div>
										
										<!--<div class="col-md-2 col-sm-2">
											<button class="btn btn-primary" type="submit" id='BtnBuscar'><i class="fa fa-search"></i> Buscar</button>
										</div>	-->								
									</div>
									<div class="form-group">
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
										</div>
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
										<div class="col-md-2 col-sm-2">
											<button id='BtnBuscar' class="btn btn-primary" type="submit"><i class="fa fa-search"></i> Buscar</button>
										</div>
																	
									</div>
								{{ Form::close() }}
							</div>
							<br>

							<table class="table table-striped table-bordered table-hover" id="table_mesas">
								<thead>
								<tr>
									<th>
										<center><i class="fa fa-files-o"></i> Materia</center>
									</th>
									<th class="hidden-xs">
										<center><i class="fa fa-calendar"></i> Primer llamado</center>
									</th>
									<th>
										<center><i class="fa fa-clock-o"></i> Hora</center>
									</th>
									<th class="hidden-xs">
										<center><i class="fa fa-calendar"></i> Segundo llamado</center>
									</th>									
									<th>
										<center><i class="fa fa-clock-o"></i> Hora</center>
									</th>
									<th>
										<center><i class="fa fa-calendar"></i> Trib. Docentes</center>
									</th>	
									<th>
										<center><i class="fa fa-rocket"></i> Acciones</center>
									</th>			

								</tr>
								</thead>
								<tbody>
									@if (isset($mesas))
										@foreach ($mesas as $mesa)
											<tr>
												<td>
													<center>
														{{$mesa['materia']}}
													</center>
												</td>
												<td>
													<center>
														{{$mesa['fechaprimerllamado']}}
													</center>
												</td>
												<td>
													<center>
														{{$mesa['horaprimerllamado']}}
													</center>
												</td>
												<td>
													<center>
														{{$mesa['fechasegundollamado']}}
													</center>
												</td>
												<td>
													<center>
														{{$mesa['horasegundollamado']}}
													</center>
												</td>
												<td>
													<center>
														{{$mesa['tribunal']}}
													</center>
												</td>
												<td>
													<center>
													<a title="Modificar" href="editar/{{$mesa['id']}}" class="btn default btn-xs purple">
													<i class="fa fa-edit"></i></a>
													<a title="Eliminar" href="#modalEliminaMesa" {{ $disabled }} data-id="{{$mesa['id']}}" class="btn default btn-xs red btnEliminarMesa">
													<i class="fa fa-trash-o"></i></a>
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
	<div class="modal fade" id="modalEliminaMesa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		{{ Form::open(array('url' => 'mesaexamenes/borrar')) }}
			<input id="idMesaHidden" name='idMesaHidden' type="hidden" value="">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Eliminar Mesa de Examen</h4>
					</div>
					<div class="modal-body">
						¿Estás seguro de querer borrar esta mesa de examen?
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
	
	if($('#table_mesas >tbody >tr').length > 0) {
		$('#imprimir').removeAttr("disabled",'false');
	} else {
		$("#imprimir").attr('disabled', 'disabled');
	}
	
	//AL PRESIONAR LOS BOTONES ELIMINAR PASO EL DATA ID DE LA CARRERA A ELIMINAR
	$('.btnEliminarMesa').live('click', function(){
		//PASO EL DATA ID AL CAMPO OCULTO		
		$('#idMesaHidden').val($(this).data('id'));
		//MUESTRO EL MODAL DE ADVERTENCIA
		$('#modalEliminaMesa').modal('show');
	});


	$(document).ready(function() {
	    $('#table_mesas').DataTable();
	} );

	$('#organizacion, #carrera, #plan, #cboopcion, #turnos, #ciclos').select2({
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
	
	});




	$('#cboFiltro').on('change', function(){
		var filtro = $('#cboFiltro').val();

		
		if (filtro == 2 || filtro == 3 ) {
	    	
			$('#opcion').removeAttr('disabled');
	    	var carrera_id = $('#carrera').val();
			
			$.ajax({
			  url: "{{url('mesaexamenes/obteneropciones')}}",
			  data:{'carrera_id': carrera_id, 'filtro': filtro},
			  type: 'POST'
			}).done(function(opcion) {
				console.log(opcion);
				
				$('#opcion').find('option').remove().end()
				$('#opcion').append('<option value="0" disabled selected>Seleccione</option>');
				$('#opcion').select2("destroy");
				$('#opcion').select2();


				$.each(opcion, function(key, value) {
					$('#opcion').append(
				        $('<option></option>').val(value.id).html(value.descripcion)
				    );
				});
				
			}).error(function(data) {
				console.log(data);
			});

		} else {
			
			$('#opcion').find('option').remove().end()
			$('#opcion').append('<option value="0" disabled selected>Seleccione</option>');
			$('#opcion').select2("destroy")
			$('#opcion').attr('disabled', 'disabled');
			$('#opcion').select2();
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

    	if (filtro != 1){
			var opcion = $('#opcion').val();	
			if(opcion == 0 || opcion == null) {
				
			$('#divMensaje').html('<p class="form-control-static"><h4>' + 'Seleccione los filtros requeridos!' + '</h4></p>');
			$('#Mensajes').modal('show');
			//alert('Seleccione los filtros requeridos');
    	    return false;
			}	
    	}
	});

	
	$('#imprimir').on('click', function(e){
		e.preventDefault();
		window.open("{{url('mesaexamenes/imprimir')}}?organizacion=" + $('#organizacion').val() + '& carrera=' + $('#carrera').val() + '& cboFiltro=' + $('#cboFiltro').val() + '& opcion=' + $('#opcion').val() + '&ciclos=' + $('#ciclos').val() + '& turnos=' + $('#turnos').val());
	});



@stop


@section('includejs')
	<script type="text/javascript" src="{{url('assets/global/plugins/select2/select2.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js')}}"></script>
	<!--<script src="{{url('assets/admin/pages/scripts/table-advanced.js')}}"></script>-->
@stop
