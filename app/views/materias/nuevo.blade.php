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

@section('content')
	<!-- COMIENZO CONTENIDO -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- COMIENZO DEL HEADER-->

			<div class="row">
				<div class="col-md-12">
					<!-- COMIENZO TITULO & BREADCRUMB--> 
					<h3 class="page-title">
					Materia <small>nueva materia</small>
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
							<a href="#">Nueva</a>
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
					{{ Form::open(array('url'=>'api/materias', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmMaterias', 'name'=>'FrmMaterias'))}}
					
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
								<a href="listado" class="btn default yellow-stripe">
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
											{{ Form::select('organizacion', $arrOrganizaciones, Input::old('organizacion'), array('class'=>'table-group-action-input form-control','id'=>'organizacion')); }}
										</div>
									</div>

									<div class="form-group <?php if ($errors->has('carrera')) echo 'has-error' ?> ">
										<label class="col-md-2 control-label" for="carrera">Carrera:</label>
										<div class="col-md-6">
											<select class="table-group-action-input form-control" name="carrera" id="carrera">
												<option value="">Seleccione</option>
											</select>
											@if ($errors->has('carrera'))
											    <span class="help-block">{{ $errors->first('carrera') }}</span>
										    @endif
										</div>
									</div>

									<div class="form-group <?php if ($errors->has('plan')) echo 'has-error' ?> ">
										<label class="col-md-2 control-label" for="plan">Plan de Estudio:</label>
										<div class="col-md-2">
											<select class="table-group-action-input form-control" name="plan" id="plan">
												<option value="0">Seleccione</option>
											</select>
											@if ($errors->has('plan'))
											    <span class="help-block">{{ $errors->first('plan') }}</span>
										    @endif
											<!--{{ Form::select('plan', $planes, Input::old('plan'), array('class'=>'table-group-action-input form-control','id'=>'plan')); }}-->
										</div>

										<div class="<?php if ($errors->has('cboCiclos')) echo 'has-error' ?>" >
											<label class="col-md-2 col-sm-2 control-label">Ciclo Lectivo:</label>
											<div class="col-md-2 col-sm-2">
												<select class="table-group-action-input form-control" name="cboCiclos" id="cboCiclos">
													<!--option value="0">Seleccione</option-->
												</select>
											    @if ($errors->has('cboCiclos'))
												    <span class="help-block">{{ $errors->first('cboCiclos') }}</span>
											    @endif
											</div>
										</div>
									</div>

									<div class="form-group <?php if ($errors->has('materia')) echo 'has-error' ?> ">
										<label class="col-md-2 control-label" for="materia">Nombre Materia:</label>
										<div class="col-md-6">
											<input type="text" class="form-control" id="materia" name="materia" value="" >
											@if ($errors->has('materia'))
											    <span class="help-block">{{ $errors->first('materia') }}</span>
										    @endif
										</div>

										<label class="control-label" for="promocional">
											<input type="checkbox" class="form-control" id="promocional" name="promocional"> Promocional
										</label>
									</div>

									<div class="form-group">
										<label class="col-md-2 control-label" for="periodo">Período:</label>
										<div class="col-md-3">
											<select class="table-group-action-input form-control" name="periodo" id="periodo">
												<option value="Anual">Anual</option>
												<option value="Cuatrimestral">Cuatrimestral</option>
											</select>
										</div>
									</div>


									<div class="form-group">
										<label class="col-md-2 control-label" for="hsSemanales">Hs. Semanales:</label>
										<div class="col-md-2">
											<input type="text" class="form-control" id="hsSemanales" name="hsSemanales" value="" >
											@if ($errors->has('hsSemanales'))
											    <span class="help-block">{{ $errors->first('hsSemanales') }}</span>
										    @endif
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-2 control-label" for="hsReloj">Hs. (Reloj):</label>
										<div class="col-md-2">
											<input type="text" class="form-control" id="hsReloj" name="hsReloj" value="" >
											@if ($errors->has('hsReloj'))
											    <span class="help-block">{{ $errors->first('hsReloj') }}</span>
										    @endif
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-2 control-label" for="hsCatedras">Hs. (Cátedras):</label>
										<div class="col-md-2">
											<input type="text" class="form-control" id="hsCatedras" name="hsCatedras" value="" >
											@if ($errors->has('hsCatedras'))
											    <span class="help-block">{{ $errors->first('hsCatedras') }}</span>
										    @endif
										</div>
									</div>									

									<div class="form-group">
										<label class="col-md-2 control-label" for="aniocursado">Año Cursado:</label>
										<div class="col-md-2">
											<select class="table-group-action-input form-control" name="aniocursado" id="aniocursado">
												<option value="1">1°</option>
												<option value="2">2°</option>
												<option value="3">3°</option>
												<option value="3">4°</option>
												<option value="3">5°</option>
												<option value="3">6°</option>
												<option value="3">7°</option>
											</select>
										</div>
									</div>		

									<div class="form-group"  id = "cuatrimestres">
										<label class="col-md-2 control-label" for="cuatrimestre">Cuatrimestre:</label>
										<div class="col-md-2">
											<select class="table-group-action-input form-control" name="cuatrimestre" id="cuatrimestre">
												<option value="1">1°</option>
												<option value="2">2°</option>
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
	 

	$("#cuatrimestres").hide();
	 
	$('#organizacion').select2({
		placeholder: "Seleccione",
		allowClear: true
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

	/*$('#organizacion').on('change', function(){
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
	});	*/

	$('#organizacion').change(function() {
	
		
		var buscarO = $("#organizacion option:selected").attr("value")
		//alert(buscarO);
		var arrayJS=<?php echo json_encode($carreras);?>;
		//alert(arrayJS.carrera);	

		$('option', '#carrera').remove();
		$("#carrera").append('<option value="0" disabled selected>Seleccionar</option>');
		
		$('option', '#plan').remove();
		$("#plan").append('<option value="0" disabled selected>Seleccionar</option>');
				
		$.each(arrayJS, function(key, value){
			//$("#carrera").append('<option value="'+value.id+'">'+value.numero+' '+value.letra+'</option>');
			if(value.organizacion_id == buscarO) {
				$("#carrera").append('<option value="'+value.id+'">'+value.carrera+'</option>');
			}

		})


	});

	$('#carrera').change(function() {
	
		
		var buscarP = $("#carrera option:selected").attr("value")
		//alert(buscarP);
		var arrayJS=<?php echo json_encode($planes);?>;
		//alert(arrayJS);	
		
		$('option', '#plan').remove();
		$("#plan").append('<option value="0" disabled selected>Seleccionar</option>');
				
		$.each(arrayJS, function(key, value){
			//$("#plan").append('<option value="'+value.id+'">'+value.numero+' '+value.letra+'</option>');
			if(value.carrera_id == buscarP) {
				$("#plan").append('<option value="'+value.id+'">'+value.codigoplan+'</option>');
			}

		})


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
