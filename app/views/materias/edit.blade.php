@extends('layouts.master')

@section('customstyle')
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/select2/select2.css')}}"/>
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
	$disabled 	= (!$editar) ? 'disabled' : '';
	$readonly 	= (!$editar) ? 'readonly' : '';
	$imprimir 	= (!$imprimir) ? 'disabled' : '';

	$carreraid 		= (trim(Input::old('carrera') == false)) ? $materia->carrera_id : Input::old('carrera');
	$planid 		= (trim(Input::old('plan') == false)) ? $materia->planestudio_id : Input::old('plan');
	$materiastr 	= (trim(Input::old('materia') == false)) ? $materia->nombremateria : Input::old('materia');
	$periodo 		= (trim(Input::old('periodo') == false)) ? $materia->periodo : Input::old('periodo');
	$hs_semanales	= (trim(Input::old('hsSemanales') == false)) ? $materia->hssemanales : Input::old('hsSemanales');
	$hs_reloj	= (trim(Input::old('hsReloj') == false)) ? $materia->hsreloj : Input::old('hsReloj');
	$hs_catedra	= (trim(Input::old('hsCatedra') == false)) ? $materia->hscatedra : Input::old('hsCatedra');
	$aniocursado	= (trim(Input::old('aniocursado') == false)) ? $materia->aniocursado : Input::old('aniocursado');
	$cuatrimestre	= (trim(Input::old('cuatrimestre') == false)) ? $materia->cuatrimestre : Input::old('cuatrimestre');
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
					Materia <small>editar materia</small>
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
					    @if (Session::get('message_type') == MateriasController::OPERACION_EXITOSA)

							<div class="note note-success">
								<p> {{ Session::get('message') }} </p>
							</div>
						@elseif (Session::get('message_type') == MateriasController::OPERACION_FALLIDA)

							<div class="note note-danger">
								<p> {{ Session::get('message') }} </p>
							</div>

						@endif	
					@endif
					<!-- COMIENZO DE LA TABLA-->
					{{ Form::open(array('url'=>'api/materias/'.$materia->id, 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmMaterias', 'name'=>'FrmMaterias', 'method' => 'put'))}}
					
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-files-o"></i> Materia
							</div>
							<div class="actions">
								<button type='submit' class="btn default green-stripe">
								<i class="fa fa-save"></i>
								<span class="hidden-480">
								Guardar </span>
								</button>
								<a href="{{url('materias/listado')}}" class="btn default yellow-stripe">
								<i class="fa fa-reorder"></i>
								<span class="hidden-480">
								Listado </span>
								</a>
							</div>

						</div>
						<div class="portlet-body form">
								<div class="form-body">

									<div class="form-group">
										<label  class="col-md-2 col-sm-2 control-label">Organización:</label>
										<div class="col-md-6 col-sm-10">
											{{ Form::select('organizacion', $arrOrganizaciones, 1, array('class'=>'table-group-action-input form-control','id'=>'organizacion')); }}
										</div>
									</div>

									<div class="form-group <?php if ($errors->has('carrera')) echo 'has-error' ?> ">
										<label class="col-md-2 control-label" for="carrera">Carrera:</label>
										<div class="col-md-6">
											{{ Form::select('carrera', $carreras, $carreraid, array('class'=>'table-group-action-input form-control','id'=>'carrera')); }}
											@if ($errors->has('carrera'))
											    <span class="help-block">{{ $errors->first('carrera') }}</span>
										    @endif
										</div>
									</div>

									<div class="form-group <?php if ($errors->has('plan')) echo 'has-error' ?> ">
										<label class="col-md-2 control-label" for="plan">Plan de Estudio:</label>
										<div class="col-md-2">
											{{ Form::select('plan', $planes, $planid, array('class'=>'table-group-action-input form-control','id'=>'plan')); }}
										</div>

										<div class="<?php if ($errors->has('cboCiclos')) echo 'has-error' ?>" >
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

									<div class="form-group <?php if ($errors->has('materia')) echo 'has-error' ?> ">
										<label class="col-md-2 control-label" for="materia">Nombre Materia:</label>
										<div class="col-md-6">
											<input type="text" class="form-control" id="materia" name="materia" value="{{ $materiastr }}" >
											@if ($errors->has('materia'))
											    <span class="help-block">{{ $errors->first('materia') }}</span>
										    @endif
										</div>
										<label class="control-label" for="promocional">
											<input type="checkbox" class="form-control" id="promocional" name="promocional" <?php if ($promocional == 1) echo 'CHECKED'; ?>> Promocional
										</label>
									</div>

									<div class="form-group ">
										<label class="col-md-2 control-label" for="periodo">Período:</label>
										<div class="col-md-3">
											<select class="table-group-action-input form-control" name="periodo" id="periodo">
												<option @if ($periodo=='Anual') {{'selected'}} @endif value="Anual">Anual</option>
												<option @if ($periodo=='Cuatrimestral') {{'selected'}} @endif value="Cuatrimestral">Cuatrimestral</option>
											</select>
										</div>
									</div>


									<div class="form-group <?php if ($errors->has('hsSemanales')) echo 'has-error' ?>">
										<label class="col-md-2 control-label" for="hsSemanales">Hs. Semanales:</label>
										<div class="col-md-2">
											<input type="text" class="form-control" id="hsSemanales" name="hsSemanales" value="{{$hs_semanales}}" >
											@if ($errors->has('hsSemanales'))
											    <span class="help-block">{{ $errors->first('hsSemanales') }}</span>
										    @endif
										</div>
									</div>

									<div class="form-group <?php if ($errors->has('hsReloj')) echo 'has-error' ?>">
										<label class="col-md-2 control-label" for="hsReloj">Hs. (Reloj):</label>
										<div class="col-md-2">
											<input type="text" class="form-control" id="hsReloj" name="hsReloj" value="{{ $hs_reloj }}" >
											@if ($errors->has('hsReloj'))
											    <span class="help-block">{{ $errors->first('hsReloj') }}</span>
										    @endif
										</div>
									</div>

									<div class="form-group <?php if ($errors->has('hsCatedras')) echo 'has-error' ?>">
										<label class="col-md-2 control-label" for="hsCatedras">Hs. (Cátedras):</label>
										<div class="col-md-2">
											<input type="text" class="form-control" id="hsCatedras" name="hsCatedras" value="{{$hs_catedra}}" >
											@if ($errors->has('hsCatedras'))
											    <span class="help-block">{{ $errors->first('hsCatedras') }}</span>
										    @endif
										</div>
									</div>									

									<div class="form-group">
										<label class="col-md-2 control-label" for="aniocursado">Año Cursado:</label>
										<div class="col-md-2">
											<select class="table-group-action-input form-control" name="aniocursado" id="aniocursado">
												<option @if ($aniocursado == 1) {{'selected'}} @endif value="1">1°</option>
												<option @if ($aniocursado == 2) {{'selected'}} @endif value="2">2°</option>
												<option @if ($aniocursado == 3) {{'selected'}} @endif value="3">3°</option>
											</select>
										</div>
									</div>	

									<div class="form-group" id="cuatrimestres">
										<label class="col-md-2 control-label" for="cuatrimestre">Cuatrimestre:</label>
										<div class="col-md-2">
											<select class="table-group-action-input form-control" name="cuatrimestre" id="cuatrimestre">
												<option @if ($cuatrimestre == '1') {{'selected'}} @endif value="1">1°</option>
												<option @if ($cuatrimestre == '2') {{'selected'}} @endif value="2">2°</option>
												
											</select>
										</div>
									</div>									
									

								</div>																	
						</div> <!-- FIN PORTLET-BODY -->
					</div>
					{{ Form::close() }}
				</div>
			</div>
			<!-- FIN DEL CONTENIDO -->
		</div>
	</div>
	<!-- FIN -->
@stop


@section('customjs')
	//Emular Tab al presionar Enter
	$('input').keydown( function(e) {
	        var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
	        if(key == 13) {
	            e.preventDefault();
	            var inputs = $(this).closest('form').find(':input:visible');
	            inputs.eq( inputs.index(this)+ 1 ).focus();
	        }
	 });

	var periodo = <?php echo json_encode($periodo);?>;
	if (periodo == 'Cuatrimestral'){
		$("#cuatrimestres").show();
	} else {
		$("#cuatrimestres").hide();
	}

	$('#organizacion').select2({
		placeholder: "Seleccione",
		allowClear: true
	});

	$('#organizacion').on('change', function(){
		var orgid = $('#organizacion').val();
		var combocarga = $('#carrera');
		$.ajax({
			type: "POST",
			url: "{{url('carreras/buscarjson/')}}",
			data: { organizacionid: orgid }	
			}).done(function(data) {
				console.log(data)
				combocarga.find('option').remove().end()
				combocarga.select2("destroy")
				for (i = 0; i < data.length; i++) {
					combocarga.append('<option value="'+data[i]['id']+'">'+data[i]['carrera']+'</option>')
				}
				combocarga.select2()
			});
	});	

	$('#plan').change(function() {
		$('#cboCiclos').children().remove().end();
		if ($('#organizacion').val() == 0) return;

		$.ajax({
		  url: '{{url('ciclolectivo/obtenercicloslectivos')}}',
		  data:{'organizacion_id': $('#organizacion').val()},
		  type: 'POST'
		}).done(function(ciclos) {
			console.log(ciclos);

			if (ciclos == <?php echo CicloLectivoController::NO_EXISTE_CICLO ?>) {
				//alert('La Organización no tiene Ciclos Lectivos Asignados');
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

			$.ajax({
			  url: '{{url('planestudios/obtenerciclo')}}',
			  data:{'plan': $('#plan').val()},
			  type: 'POST'
			}).done(function(plan) {
				console.log(plan);

				$('#cboCiclos').val(plan);

			}).error(function(data) {
				console.log(data);
			});
		}).error(function(data) {
			console.log(data);
		});
	});

	$('#periodo').on('change', function(){
		var periodo = $('#periodo').val();
		if (periodo == 'Cuatrimestral'){
			$("#cuatrimestres").show();
		} else {
			$("#cuatrimestres").hide();
		}
	});

@stop

@section('includejs') 
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{url('assets/global/plugins/select2/select2.min.js')}}"></script>
<script src="{{url('assets/admin/layout/scripts/menusticky.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
@stop
