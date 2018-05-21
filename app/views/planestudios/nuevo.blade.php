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
	<div class="page-content-wrapper" ng-app="app">
		<div class="page-content" ng-controller="NuevoPlanEstudiosController" >
			<!-- COMIENZO DEL HEADER-->

			<div class="row">
				<div class="col-md-12">
					<!-- COMIENZO TITULO & BREADCRUMB--> 
					<h3 class="page-title">
					Plan de Estudios <small>nuevo plan</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('planestudios/listado')}}">Plan de Estudios</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('planestudios/crear')}}">Nuevo</a>
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
					    @if (Session::get('message_type') == PlanestudiosController::OPERACION_EXITOSA)

					        <div class="note note-success">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == PlanestudiosController::OPERACION_FALLIDA)

					        <div class="note note-danger">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == PlanestudiosController::OPERACION_CANCELADA)

					        <div class="note note-warning">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == PlanestudiosController::OPERACION_INFO)

					        <div class="note note-info">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@endif
					@endif
					<!-- COMIENZO DE LA TABLA-->
					{{ Form::open(array('url'=>'planestudios/guardar', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmPlanestudios', 'enctype'=>'multipart/form-data'))}}
					
						<div class="portlet">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-files-o"></i> Plan de estudios
								</div>
								<div class="actions">
									<button id="guardar" type='submit' class="btn default green-stripe">
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
												{{ Form::select('organizacion', $organizaciones, Input::old('organizacion'), array('class'=>'table-group-action-input form-control','id'=>'organizacion')) }}
											</div>
										</div>

										<div class="form-group">
											<label class="col-md-2 control-label" for="carrera">Carrera:</label>
											<div class="col-md-6">
												<select class="table-group-action-input form-control" name="carrera" id="carrera">
													<!--option value="0">Seleccione</option-->
												</select>
												@if ($errors->has('carrera'))
												    <span class="help-block">{{ $errors->first('carrera') }}</span>
											    @endif
											</div>
										</div>

										<div class="form-group">
											<label class="col-md-2 control-label" for="ciclos">Ciclo Lectivo:</label>
											<div class="col-md-2">
												<select class="table-group-action-input form-control" name="ciclos" id="ciclos">
													<option value="0">Seleccione</option>
												</select>
											</div>
											@if ($errors->has('ciclos'))
											    <span class="help-block">{{ $errors->first('ciclos') }}</span>
										    @endif
										</div>

										<div class="form-group <?php if ($errors->has('codigoplan')) echo 'has-error' ?>">
											<label class="col-md-2 control-label">Cod. de Plan:<span class="required"> * </span>
											</label>
											<div class="col-md-3">
												<input type="text" class="form-control" name="codigoplan" id="codigoplan" placeholder="" value="{{ Input::old('codigoplan') }}" disabled>
											    @if ($errors->has('codigoplan'))
												    <span class="help-block">{{ $errors->first('codigoplan') }}</span>
											    @endif
											</div>
											<input type="hidden" class="form-control" name="codigoplan1" id="codigoplan1" placeholder="" value="{{ Input::old('codigoplan') }}">
										</div>

										<div class="form-group <?php if ($errors->has('tituloplan')) echo 'has-error' ?>">
											<label class="col-md-2 control-label">Título del Plan:<span class="required"> * </span>
											</label>
											<div class="col-md-6">
												<input type="text" class="form-control" name="tituloplan" id="tituloplan" placeholder="" value="{{ Input::old('tituloplan') }}">
											    @if ($errors->has('tituloplan'))
												    <span class="help-block">{{ $errors->first('tituloplan') }}</span>
											    @endif
											</div>
										</div>

										<div class="form-group <?php if ($errors->has('nroresolucion')) echo 'has-error' ?> ">
											<label class="col-md-2 control-label" for="nroresolucion">Nro. Resolución:</label>
											<div class="col-md-6">
												<input type="text" class="form-control" id="nroresolucion" name="nroresolucion" value="" >
												@if ($errors->has('nroresolucion'))
												    <span class="help-block">{{ $errors->first('nroresolucion') }}</span>
											    @endif
											</div>
										</div>
									
										<div class="form-group <?php if ($errors->has('fechaInicio')) echo 'has-error' ?>">
											<label class="col-md-2 control-label">Fecha Inicio: <span class="required"> * </span></label>
											<div class="col-md-2">
												<div class="input-icon right">
													<i class="fa fa-exclamation tooltips iconoerror" style="display:none" data-original-title="Fecha incorrecta." data-container="body"></i>
													<input type="text" class="form-control" name="fechaInicio" id="fechaInicio" placeholder="" value="{{ Input::old('fechaInicio') }}">
											    	@if ($errors->has('fechaInicio'))
												    	<span class="help-block">{{ $errors->first('fechaInicio') }}</span>
											    	@endif
											    </div>	
											</div>
										</div>
										
										<div class="form-group <?php if ($errors->has('fechaFin')) echo 'has-error' ?>">
											<label class="col-md-2 control-label">Fecha Fin: <span class="required"> * </span></label>
											<div class="col-md-2">
												<div class="input-icon right">
													<i class="fa fa-exclamation tooltips iconoerror" style="display:none" data-original-title="Fecha incorrecta." data-container="body"></i>
													<input type="text" class="form-control" name="fechaFin" id="fechaFin" placeholder="" value="{{ Input::old('fechaFin') }}">
											    	@if ($errors->has('fechaFin'))
												    	<span class="help-block">{{ $errors->first('fechaFin') }}</span>
											    	@endif
											    </div>	
											</div>
										</div>
											
									</div>																	
							</div> <!-- FIN PORTLET-BODY -->
						</div>
					{{ Form::close()}}
				</div>
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
	 
	$('#organizacion').select2({
		placeholder: "Seleccione",
		allowClear: true
	});

	$('#organizacion').on('change', function(){
		var organizacion_id = $('#organizacion').val();
		
		$.ajax({
		  url: "{{url('organizacions/obtenercarreras')}}",
		  data:{'organizacion_id': organizacion_id},
		  type: 'POST'
		}).done(function(carreras) {
			console.log(carreras);
			if (carreras == <?php echo OrganizacionsController::NO_TIENE_CARRERAS ?>) {
				$('#divMensaje').html('<p class="form-control-static"><h4>' + 'La Organización no tiene Carreras Asignadas' + '</h4></p>');
	    	    $('#MensajeCantidad').modal('show');
				return;
		    }

			$('#carrera').append(
		        $('<option></option>').val(0).html('Seleccionar')
		    );

			$.each(carreras, function(key, value) {
				$('#carrera').append(
			        $('<option></option>').val(value.id).html(value.carrera)
			    );
			});
		}).error(function(data){
			console.log(data);
		});
	});
	
	$('#carrera').change(function() {
		var carrid = $('#carrera').val();
		$('#ciclos').children().remove().end();

		if ($('#cboOrganizacion').val() == 0) return;

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

			$('#ciclos').append(
		        $('<option></option>').val(0).html('Seleccionar')
		    );

			$.each(ciclos, function(key, value) {
				$('#ciclos').append(
			        $('<option></option>').val(value.id).html(value.descripcion)
			    );
			});
		}).error(function(data) {
			console.log(data);
		});
	});

    $('#ciclos').change(function() {
        if ($('#ciclos').val() == 0) return;
        
        $('#guardar').removeAttr("disabled");

        limpiar_datos();

		$.ajax({
		  url: '{{url('planestudios/obtenerplanestudios')}}',
		  data:{'ciclo': $('#ciclos').val(), 'carrera': $('#carrera').val()},
		  type: 'POST'
		}).done(function(planes) {
			console.log(planes);

			$.each(planes, function(key, plan) {
				$('#codigoplan').val(plan.codigoplan);
				$('#codigoplan1').val(plan.codigoplan);
				$('#tituloplan').val(plan.tituloplan);
				/*$('#fechaInicio').val(plan.fechainicio);
				$('#fechaFin').val(plan.fechafin);
				$('#guardar').attr('disabled', 'disabled');*/
			});

		}).error(function(data) {
			console.log(data);
		});

    });

	function limpiar_datos() {
		$('#codigoplan').val('');
		$('#tituloplan').val('');
		$('#fechaInicio').val('');
		$('#fechaFin').val('');
	}

    $("#fechaInicio, #fechaFin").inputmask("dd/mm/yyyy", {
        "placeholder": "__/__/____"
    });
@stop

@section('includejs') 
	<script type="text/javascript" src="{{url('assets/global/plugins/select2/select2.min.js')}}"></script>
	<script src="{{url('assets/admin/layout/scripts/menusticky.js')}}" type="text/javascript"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js')}}"></script>

@stop
