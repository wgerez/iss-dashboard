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
//BOTONES Y CAMPOS DE PERMISOS
$disabled = (!$editar) ? 'disabled' : '';
$readonly = (!$editar) ? 'readonly' : '';
$imprimir = (!$imprimir) ? 'disabled' : '';

$organizacionid = (trim(Input::old('organizacion') == false)) ? $cajachica->organizacion_id : Input::old('organizacion');
if (!$persona == '') {
	$alumno = (trim(Input::old('divAlumno') == false)) ? $persona->apellido .', '. $persona->nombre : Input::old('divAlumno');
	$nrodocumento = (trim(Input::old('divDNI') == false)) ? $persona->nrodocumento : Input::old('divDNI');
	$domicilio = (trim(Input::old('divDomicilio') == false)) ? $persona->calle .' '. $persona->numero .' ('. $persona->localidad->descripcion .', '. $persona->provincia->descripcion .')' : Input::old('divDomicilio');
} else {
	$alumno = '';
	$nrodocumento = '';
	$domicilio = '';
}

if (!$cajachica->alumno_id == NULL) {
	$alumno_id = (trim(Input::old('txt_alumno_id') == false)) ? $cajachica->alumno_id : Input::old('txt_alumno_id');
} else {
	$alumno_id = '';
}

$observacionconcepto = (trim(Input::old('observaciones') == false)) ? $cajachica->observacionconcepto : Input::old('observaciones');
$monto = (trim(Input::old('monto') == false)) ? $cajachica->monto : Input::old('monto');
$numeromovimiento = (trim(Input::old('txtmovimiento') == false)) ? $cajachica->numeromovimiento : Input::old('txtmovimiento');
$observacionpago = (trim(Input::old('observaciones2') == false)) ? $cajachica->observacionpago : Input::old('observaciones2');
$efectivo = (trim(Input::old('efectivo') == false)) ? $cajachica->efectivo : Input::old('efectivo');
$credito = (trim(Input::old('credito') == false)) ? $cajachica->tarjetacredito : Input::old('credito');
$debito = (trim(Input::old('debito') == false)) ? $cajachica->tarjetadebito : Input::old('debito');
$bancaria = (trim(Input::old('bancaria') == false)) ? $cajachica->cuentabancaria : Input::old('bancaria');
$cheque = (trim(Input::old('cheque') == false)) ? $cajachica->cheque : Input::old('cheque');

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
					Contable <small>Caja Chica</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('cajachica/listado')}}">Listado</a>
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
					    @if (Session::get('message_type') == CajaChicaController::OPERACION_EXITOSA)

							<div class="note note-success">
								<p> {{ Session::get('message') }} </p>
							</div>
						@elseif (Session::get('message_type') == CajaChicaController::OPERACION_FALLIDA)

							<div class="note note-danger">
								<p> {{ Session::get('message') }} </p>
							</div>

						@endif	
					@endif
					<!-- COMIENZO DE LA TABLA-->
					{{ Form::open(array('url'=>'cajachica/update', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmCajaChica', 'name'=>'FrmCajaChica'))}}
					
					<input type="hidden" value="{{$cajachica->id}}" name="cajaid" id="cajaid">
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-files-o"></i> Caja Chica
							</div>
							<div class="actions">
								<!--button type='submit' class="btn default green-stripe" disabled>
								<i class="fa fa-save"></i>
								<span class="hidden-480">
								Guardar </span>
								</button-->
								<a href="{{url('cajachica/crear')}}" {{ $disabled }} class="btn default blue-stripe">
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Nuevo </span>
								</a>
								<a href="{{url('cajachica/listado')}}" class="btn default red-stripe">
								<i class="fa fa-reorder"></i>
								<span class="hidden-480">
								Listado </span>
								</a>
								<a target="_blank" href="#" id="imprimir" class="btn default yellow-stripe" <?php if ($persona == '') echo "disabled"; ?> <?php //if ($cajachica->ingresoegreso == 0) echo "disabled"; ?>>
								<i class="glyphicon glyphicon-list-alt"></i>
								<span class="hidden-480">
								Recibo </span>
								</a>
							</div>

						</div>
						<div class="portlet-body form">
								<div class="form-body">

									<div class="form-group">
										<div class="col-md-6 col-sm-10">
							                <label class="col-md-4 col-sm-4 control-label">Ingreso
							                    <input type="radio" name="parcialfra" id="parcialfra" value="1" <?php if($cajachica->ingresoegreso == 1) { echo "checked";}?> disabled>
							                </label>
							                <label class="col-md-4 col-sm-4 control-label">Egreso
							                    <input type="radio" name="parcialfra" id="parcialfra" value="0" <?php if($cajachica->ingresoegreso == 0) { echo "checked";}?> disabled>
							                </label>
							                @if ($errors->has('parcialfra'))
												<span class="help-block">{{ $errors->first('parcialfra') }}</span>
											@endif
										</div>
	        						</div>

									<div class="form-group">
										<label  class="col-md-2 col-sm-2 control-label">Organización:</label>
										<div class="col-md-6 col-sm-10">
											<select name="color" id="color" class="form-control" disabled>
												<option value="0" disabled selected>Seleccionar</option>
													@foreach ($arrOrganizaciones as $organizacion)
														<option value="{{$organizacion->id}}" <?php if($organizacion->id === $cajachica->organizacion_id) { echo "selected=selected";}?>>
															{{$organizacion->nombre}}
														</option>
													@endforeach
												</option>
											</select>
										</div>
				  						<input id="txt_organizacion_id" name='txt_organizacion_id' type="hidden" value="" visible="false">
									</div>

									<div class="form-group">
										<label class="col-md-2 col-sm-2 control-label" for="cboFiltroAlumno">Filtrar:</label>
										<div class="col-md-3 col-sm-10">
											<select class="table-group-action-input form-control" name="cboFiltroAlumno" id="cboFiltroAlumno" disabled>
												<option value="0">Documento</option>
												<option value="1">Apellido y Nombre</option>
											</select>
										</div>
										<div class="col-md-4 col-sm-4">
											<input class="form-control" name="txtalumno" id="txtalumno" type="text" value="{{ $nrodocumento }}" disabled>
										</div>
										<div class="col-md-2 col-sm-2">
											<a class="btn blue-madison" id='BtnBuscar' disabled>
												<i class="fa fa-search"></i> Buscar
											</a>
										</div>	

										<!--div class="col-md-2 col-sm-2">
											<button class="btn btn-primary" type="submit" id="BtnBuscar"><i class="fa fa-search"></i> Buscar</button>
										</div-->				
									</div>

									<div class="form-group <?php if ($errors->has('carrera')) echo 'has-error' ?> ">
										<label class="col-md-2 control-label" for="carrera">Carrera:</label>
										<div class="col-md-6">
											<select class="table-group-action-input form-control" name="carrera" id="carrera" disabled>
												<option value="">Seleccione</option>
													@foreach ($carreras as $carrera)
														<option value="{{$carrera->id}}" <?php if($carrera->id === $cajachica->carrera_id) { echo "selected=selected";}?>>
															{{$carrera->carrera}}
														</option>
													@endforeach
											</select>
											@if ($errors->has('carrera'))
											    <span class="help-block">{{ $errors->first('carrera') }}</span>
										    @endif
										</div>
				  						<input id="txt_carrera_id" name='txt_carrera_id' type="hidden" value="" visible="false">
									</div>

									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-user"></i>Datos del Alumno
										</div>
									</div>
									<div class="portlet-body form">
										<div class="form-group">
											<label  class="col-md-2 col-sm-2 control-label text-info">Alumno:</label>
											<div class="col-md-2 col-sm-4" id='divAlumno'>{{ $alumno }}</div>
											<label  class="col-md-2 col-sm-2 control-label text-info">DNI:</label>
											<div class="col-md-2 col-sm-4" id='divDNI'>{{ $nrodocumento }}</div>
				  							<input id="txt_alumno_id" name='txt_alumno_id' type="text" value="{{ $alumno_id }}" visible="false">
										</div>

										<div class="form-group">
											<label  class="col-md-2 col-sm-2 control-label text-info">Dirección:</label>
											<div class="col-md-10 col-sm-10" id='divDomicilio' value="{{ $domicilio }}">{{ $domicilio }}</div>
										</div>
									</div>

									<div class="form-group <?php if ($errors->has('concepto')) echo 'has-error' ?> ">
										<label class="col-md-2 control-label" for="concepto">Concepto:</label>
										<div class="col-md-3 col-sm-10">
											<select class="table-group-action-input form-control" name="cboFiltroConcepto" id="cboFiltroConcepto" disabled>
												@foreach ($conceptos as $concepto)
													<option value="{{ $concepto->id }}" <?php if($concepto->id === $cajachica->concepto_id) { echo "selected=selected";}?>>
														{{$concepto->descripcion}}
													</option>
												@endforeach
												<!--option value="1">Pago Postitulo</option>
												<option value="2">Proveedor</option>
												<option value="3">Acreedor</option>
												<option value="4">Otro</option-->
											</select>
											@if ($errors->has('concepto'))
											    <span class="help-block">{{ $errors->first('concepto') }}</span>
										    @endif
										</div>

										<div class="form-group @if ($errors->has('observaciones')) {{'has-error'}} @endif">
											<label class="col-md-2 control-label">Observaciones: </label>
											<div class="col-md-5 col-sm-10">
												<textarea rows="5" name="observaciones" class="col-md-2 form-control" placeholder="Observaciones" 
												value="{{ $observacionconcepto }}" disabled>{{ $observacionconcepto }}</textarea>
												@if ($errors->has('observaciones'))
													<span class="help-block">{{ $errors->first('observaciones') }}</span>
												@endif
											</div>
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-2 control-label" for="monto">Monto:</label>
										<div class="col-md-2">
											<input type="number" class="form-control" id="monto" name="monto" value="{{ $monto }}" disabled>
											@if ($errors->has('monto'))
											    <span class="help-block">{{ $errors->first('monto') }}</span>
										    @endif
										</div>

										<label class="col-md-2 control-label" for="tipomovimiento">Tipo de Comprobante:</label>
										<div class="col-md-2">
											<select class="table-group-action-input form-control" name="tipomovimiento" id="tipomovimiento" disabled>
												<option value="">Seleccione</option>
													@foreach ($tipomovimiento as $tipomovimient)
														<option value="{{$tipomovimient->id}}" <?php if($tipomovimient->id === $cajachica->movimiento_id) { echo "selected=selected";}?>>
															{{$tipomovimient->descripcion}}
														</option>
													@endforeach
											</select>
										</div>
										<div class="col-md-4 col-sm-4">
											<input class="form-control" name="txtmovimiento" id="txtmovimiento" type="text" value="{{ $numeromovimiento }}" disabled>
										</div>
									</div>
									
									<div class="portlet">
										<div class="portlet-title">
											<div class="caption">
												<i class="glyphicon glyphicon-transfer"></i> Forma de Pago:
											</div>
										</div>
									<!--div class="form-group">
										<label class="col-md-2 col-sm-2 control-label" for="cboFormaPago">Forma de Pago:</label>
										<div class="col-md-3 col-sm-10">
											<select class="table-group-action-input form-control" name="cboFormaPago" id="cboFormaPago" disabled>
												<option value="">Seleccione</option>
													@foreach ($formapagos as $formapago)
														<option value="{{$formapago->id}}" <?php //if($formapago->id === $cajachica->formapago_id) { echo "selected=selected";}?>>
															{{$formapago->descripcion}}
														</option>
													@endforeach
											</select>
										</div-->
										
										<div class="form-group @if ($errors->has('efectivo')) {{'has-error'}} @endif">
											<label class="col-md-2 control-label" for="efectivo">Efectivo:</label>
											<div class="col-md-2 <?php if ($errors->has('efectivo')) echo 'has-error' ?>">
												<input type="number" class="form-control" id="efectivo" name="efectivo" value="{{ $efectivo }}" placeholder="Efectivo" disabled>
												@if ($errors->has('efectivo'))
												    <span class="help-block">{{ $errors->first('efectivo') }}</span>
											    @endif
											</div>
										</div>
										<div class="form-group @if ($errors->has('tarjeta')) {{'has-error'}} @endif">
											<label class="col-md-2 control-label" for="tarjeta">Tarjeta de Credito:</label>
											<div class="col-md-2 <?php if ($errors->has('tarjeta')) echo 'has-error' ?>">
												<input type="number" class="form-control" id="tarjeta" name="tarjeta" value="{{ $credito }}" placeholder="Tarjeta de Credito" disabled>
												@if ($errors->has('tarjeta'))
												    <span class="help-block">{{ $errors->first('tarjeta') }}</span>
											    @endif
											</div>
										</div>
										<div class="form-group @if ($errors->has('debito')) {{'has-error'}} @endif">
											<label class="col-md-2 control-label" for="debito">Tarjeta de Debito:</label>
											<div class="col-md-2 <?php if ($errors->has('debito')) echo 'has-error' ?>">
												<input type="number" class="form-control" id="debito" name="debito" value="{{ $debito }}" placeholder="Tarjeta de Debito" disabled>
												@if ($errors->has('debito'))
												    <span class="help-block">{{ $errors->first('debito') }}</span>
											    @endif
											</div>
										</div>
										<div class="form-group @if ($errors->has('bancaria')) {{'has-error'}} @endif">
											<label class="col-md-2 control-label" for="bancaria">Cuenta Bancaria:</label>
											<div class="col-md-2 <?php if ($errors->has('bancaria')) echo 'has-error' ?>">
												<input type="number" class="form-control" id="bancaria" name="bancaria" value="{{ $bancaria }}" placeholder="Cuenta Bancaria" disabled>
												@if ($errors->has('bancaria'))
												    <span class="help-block">{{ $errors->first('bancaria') }}</span>
											    @endif
											</div>
										</div>
										<div class="form-group @if ($errors->has('cheque')) {{'has-error'}} @endif">
											<label class="col-md-2 control-label" for="cheque">Cheque:</label>
											<div class="col-md-2 <?php if ($errors->has('cheque')) echo 'has-error' ?>">
												<input type="number" class="form-control" id="cheque" name="cheque" value="{{ $cheque }}" placeholder="Cheque" disabled>
												@if ($errors->has('cheque'))
												    <span class="help-block">{{ $errors->first('cheque') }}</span>
											    @endif
											</div>
										</div><br>


										<div class="@if ($errors->has('observaciones2')) {{'has-error'}} @endif">
											<label class="col-md-2 control-label">Observaciones: </label>
											<div class="col-md-5 col-sm-10">
												<textarea rows="5" name="observaciones2" id="observaciones2" class="col-md-2 form-control" placeholder="Observaciones" 
												value="{{ $observacionpago }}" disabled>{{ $observacionpago }}</textarea>
												@if ($errors->has('observaciones2'))
													<span class="help-block">{{ $errors->first('observaciones2') }}</span>
												@endif
											</div>
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
$('#txt_alumno_id').hide();

	$('#imprimir').on('click', function(e){
		e.preventDefault();
		window.open("{{url('cajachica/pdfrecibo')}}?cajaid=" + $('#cajaid').val());
	});

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
		var orgid = $('#organizacion').val();
		$('#txt_organizacion_id').val($('#organizacion').val());
		//var combocarga = $('#carrera');
		$.ajax({
			type: "POST",
			url: "{{url('carreras/buscarjson/')}}",
			data: { organizacionid: orgid },
			type: "POST"
			}).done(function(carreras) {
				console.log(carreras);

		 		$('#carrera').children().remove().end();
				
				$('#carrera').append(
			        $('<option></option>').val(0).html('Seleccionar')
			    );
				
				$.each(carreras, function(key, value) {
					$('#carrera').append(
				        $('<option></option>').val(value.id).html(value.carrera)
				    );
				});

			}).error(function(data) {
				console.log(data);
			});
	});	
	
	$('#carrera').on('change', function(){
		$('#txt_carrera_id').val($('#carrera').val());
	});	

    $('#cboFiltroAlumno').change(function() {
    	$('#txtalumno').val('');
    	$('#txtalumno').focus();
    });

	$(document).ready(function() {
	    $('input:radio[name=parcialfra]').change(function() {
	        if (this.value == '1') {
	        	/*$('#organizacion').removeAttr("disabled");
	        	$('#carrera').removeAttr("disabled");
	        	$('#cboFiltroAlumno').removeAttr("disabled");
	        	$('#txtalumno').removeAttr("disabled");
	        	$('#BtnBuscar').removeAttr("disabled");*/
	        }
	        else if (this.value == '0') {
	        	/*$('#organizacion').attr('disabled', 'disabled');
	        	$('#carrera').attr('disabled', 'disabled');
	        	$('#cboFiltroAlumno').attr('disabled', 'disabled');
	        	$('#txtalumno').attr('disabled', 'disabled');
	        	$('#BtnBuscar').attr('disabled', 'disabled');*/
	        }

	        $.ajax({
			  url: "{{url('cajachica/obtenerconcepto')}}",
			  data: {'concepto': this.value},
			  type: 'POST'
			}).done(function(conceptos) {
				console.log(conceptos);

		 		$('#cboFiltroConcepto').children().remove().end();
				
				$.each(conceptos, function(key, value) {
					$('#cboFiltroConcepto').append(
				        $('<option></option>').val(value.id).html(value.descripcion)
				    );
				});

			}).error(function(data) {
				console.log(data);
			});
	    });
	});

	function borrar_datos_alumno() {
		 $('#divAlumno').html('');
		 $('#divDNI').html('');
		 $('#divDomicilio').html('');
		 //$('#carrera').children().remove().end();
	}

	$('#BtnBuscar').live('click', function() {
	    buscar_alumno();
    });

	function buscar_alumno() {

		borrar_datos_alumno();

		/* VALIDACIONES DEL BOTON BUSCAR */
	    if ($.trim($('#txtalumno').val()) == '') {
	    	alert('Ingrese el dato del Alumno');
	    	return;
	    }
	    if ($('#cboFiltroAlumno').val() == 0) {
	        if ($.trim($('#txtalumno').val()) == '') {
	    	    alert('Debe ingresar el DNI del Alumno');
	    	    return;
	    	}
	    	url_destino = "{{url('alumnos/obteneralumnopordni')}}";
	    } else {
	        url_destino = "{{url('alumnos/obteneralumnoporapellidoynombre')}}";
	    }

	    /* OBTENGO EL ALUMNO */
		$.ajax({
		  url: url_destino,
		  data: {'txt_alumno': $('#txtalumno').val()},
		  type: 'POST'
		}).done(function(alumno) {
			console.log(alumno);
			if (alumno == <?php echo AlumnosController::NO_EXISTE_ALUMNO ?>) {
				alert('No se ha encontrado ningún registro');
				return;
		    }
		    var apellido_nombre = alumno.apellido + ', ' + alumno.nombre;
		    var dni = alumno.nrodocumento;
		    var domicilio = alumno.calle + ' ' + alumno.numero + ' (' + alumno.localidad + ', ' + alumno.provincia + ')';
		    $('#divAlumno').html('<p class="form-control-static">' + apellido_nombre + '</p>');
		    $('#divDNI').html('<p class="form-control-static">' + dni + '</p>');
		    $('#divDomicilio').html('<p class="form-control-static">' + domicilio + '</p>');

		    $('#txt_alumno_id').val(alumno.alumno_id);
		    //$('#txt_persona_id').val(alumno.persona_id);
		    //$('#txt_persona_id_verInfo').val(alumno.persona_id);

		}).error(function(data) {
			console.log(data);
		});
	}

    $('#tipomovimiento').change(function() {
    	$('#txtmovimiento').val('');
    	$('#txtmovimiento').focus();
    });

@stop

@section('includejs') 
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{url('assets/global/plugins/select2/select2.min.js')}}"></script>
<script src="{{url('assets/admin/layout/scripts/menusticky.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
@stop
