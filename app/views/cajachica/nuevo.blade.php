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
					{{ Form::open(array('url'=>'cajachica/guardar', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmCajaChica', 'name'=>'FrmCajaChica'))}}
					
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-files-o"></i> Caja Chica
							</div>
							<div class="actions">
								<button type='submit' class="btn default green-stripe" {{ $disabled }}>
								<i class="fa fa-save"></i>
								<span class="hidden-480">
								Guardar </span>
								</button>
								<a href="listado" class="btn default yellow-stripe">
								<i class="fa fa-reorder"></i>
								<span class="hidden-480">
								Listado </span>
								</a>
								<a target="_blank" href="#" id="imprimir" class="btn default yellow-stripe" disabled>
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
							                    <input type="radio" name="parcialfra" id="parcialfra" value="1" checked="true">
							                </label>
							                <label class="col-md-4 col-sm-4 control-label">Egreso
							                    <input type="radio" name="parcialfra" id="parcialfra" value="0">
							                </label>
							                @if ($errors->has('parcialfra'))
												<span class="help-block">{{ $errors->first('parcialfra') }}</span>
											@endif
										</div>
	        						</div>

									<div class="form-group <?php if ($errors->has('arrOrganizaciones')) echo 'has-error' ?>">
										<label  class="col-md-2 col-sm-2 control-label">Organización:</label>
										<div class="col-md-6 col-sm-10">
											{{ Form::select('organizacion', $arrOrganizaciones, Input::old('organizacion'), array('class'=>'table-group-action-input form-control','id'=>'organizacion', $disabled)); }}
										</div>
				  						<input id="txt_organizacion_id" name='txt_organizacion_id' type="hidden" value="{{ $organizacionid->id }}">
									</div>

									<div class="form-group <?php if ($errors->has('cboFiltroAlumno')) echo 'has-error' ?>">
										<label class="col-md-2 col-sm-2 control-label" for="cboFiltroAlumno">Filtrar:</label>
										<div class="col-md-3 col-sm-10">
											<select class="table-group-action-input form-control" name="cboFiltroAlumno" id="cboFiltroAlumno">
												<option value="0">Documento</option>
												<option value="1">Apellido y Nombre</option>
											</select>
											@if ($errors->has('cboFiltroAlumno'))
											    <span class="help-block">{{ $errors->first('cboFiltroAlumno') }}</span>
										    @endif
										</div>
										<div class="col-md-4 col-sm-4">
											<input class="form-control" name="txtalumno" id="txtalumno" type="text" placeholder="N° Documento">
											@if ($errors->has('txtalumno'))
											    <span class="help-block">{{ $errors->first('txtalumno') }}</span>
										    @endif
										</div>
										<div class="col-md-2 col-sm-2">
											<a class="btn blue-madison" id='BtnBuscar'>
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
											<select class="table-group-action-input form-control" name="carrera" id="carrera">
												<option value="">Seleccione</option>
											</select>
											@if ($errors->has('carrera'))
											    <span class="help-block">{{ $errors->first('carrera') }}</span>
										    @endif
										</div>
				  						<input id="txt_carrera_id" name='txt_carrera_id' type="hidden" value="" visible="false">
									</div><br><br>

									<div class="portlet">
										<div class="portlet-title">
											<div class="caption">
												<i class="fa fa-user"></i> Datos del Alumno
											</div>
										</div>

										<div class="portlet-body form">
											<div class="form-group">
												<label  class="col-md-2 col-sm-2 control-label text-info">Alumno:</label>
												<div class="col-md-2 col-sm-4" id='divAlumno'></div>
												<label  class="col-md-2 col-sm-2 control-label text-info">DNI:</label>
												<div class="col-md-2 col-sm-4" id='divDNI'></div>
					  							<input id="txt_alumno_id" name='txt_alumno_id' type="hidden" value="">
											</div>

											<div class="form-group">
												<label  class="col-md-2 col-sm-2 control-label text-info">Dirección:</label>
												<div class="col-md-10 col-sm-10" id='divDomicilio'></div>
											</div>
										</div>

										<div class="form-group <?php if ($errors->has('concepto')) echo 'has-error' ?> ">
											<label class="col-md-2 control-label" for="concepto">Concepto:</label>
											<div class="col-md-3 col-sm-10">
												<select class="table-group-action-input form-control" name="cboFiltroConcepto" id="cboFiltroConcepto">
													@foreach ($conceptos as $concepto)
														<option value="{{ $concepto->id }}">{{ $concepto->descripcion }}</option>
													@endforeach
												</select>
												@if ($errors->has('concepto'))
												    <span class="help-block">{{ $errors->first('concepto') }}</span>
											    @endif
											</div>

											<div class="form-group @if ($errors->has('observaciones')) {{'has-error'}} @endif">
												<label class="col-md-2 control-label">Observaciones: </label>
												<div class="col-md-5 col-sm-10">
													<textarea rows="5" name="observaciones" class="col-md-2 form-control" placeholder="Observaciones" 
													value="{{ Input::old('observaciones') }}"></textarea>
													@if ($errors->has('observaciones'))
														<span class="help-block">{{ $errors->first('observaciones') }}</span>
													@endif
												</div>
											</div>
										</div>

									</div>

										<div class="form-group @if ($errors->has('monto')) {{'has-error'}} @endif">
											<label class="col-md-2 control-label" for="monto">Monto:</label>
											<div class="col-md-2 <?php if ($errors->has('monto')) echo 'has-error' ?>">
												<input type="text" class="form-control" id="monto" name="monto" value="{{ Input::old('monto') }}" placeholder="Monto">
												@if ($errors->has('monto'))
												    <span class="help-block">{{ $errors->first('monto') }}</span>
											    @endif
											</div>
										</div>

										<div class="form-group @if ($errors->has('tipomovimiento')) {{'has-error'}} @endif">
											<label class="col-md-2 control-label" for="tipomovimiento">Tipo de Comprobante:</label>
											<div class="col-md-2">
												{{ Form::select('tipomovimiento', $tipomovimiento, Input::old('tipomovimiento'), array('class'=>'table-group-action-input form-control','id'=>'tipomovimiento')); }}
												<!--select class="table-group-action-input form-control" name="tipomovimiento" id="tipomovimiento">
													<option value="0">N° Recibo</option>
													<option value="1">N° Factura</option>
													<option value="2">N° Remito</option>
												</select-->
											</div>

												<div class="col-md-4 col-sm-4">
													<div class="col-md-2 col-sm-4" id='divN' value="{{ $movimientos }}" style="border-style: outset; width: 150px; height: 30px;"><center>{{ $movimientos }}</center></div>
													<input class="form-control" name="txtmovimiento" id="txtmovimiento" type="hidden" placeholder="" value="{{ $movimientos }}">
													@if ($errors->has('txtmovimiento'))
													    <span class="help-block">{{ $errors->first('txtmovimiento') }}</span>
												    @endif
												</div>
										</div><br><br>

									<div class="portlet">
										<div class="portlet-title">
											<div class="caption">
												<i class="glyphicon glyphicon-transfer"></i> Forma de Pago:
											</div>
										</div>
										<!--<div class="form-group">
											<label class="col-md-2 col-sm-2 control-label" for="cboFormaPago"><strong>Forma de Pago:</strong></label>
											<div class="col-md-3 col-sm-10">
												{{ Form::select('cboFormaPago', $formapago, Input::old('cboFormaPago'), array('class'=>'table-group-action-input form-control','id'=>'cboFormaPago')); }}
												select class="table-group-action-input form-control" name="cboFormaPago" id="cboFormaPago">
													<option value="0">Efectivo</option>
													<option value="1">Cheque</option>
												</select>
											</div>
										</div-->
										
										<div class="form-group @if ($errors->has('efectivo')) {{'has-error'}} @endif">
											<label class="col-md-2 control-label" for="efectivo">Efectivo:</label>
											<div class="col-md-2 <?php if ($errors->has('efectivo')) echo 'has-error' ?>">
												<input type="number" class="form-control" id="efectivo" name="efectivo" value="{{ Input::old('efectivo') }}" placeholder="Efectivo">
												@if ($errors->has('efectivo'))
												    <span class="help-block">{{ $errors->first('efectivo') }}</span>
											    @endif
											</div>
										</div>
										<div class="form-group @if ($errors->has('tarjeta')) {{'has-error'}} @endif">
											<label class="col-md-2 control-label" for="tarjeta">Tarjeta de Credito:</label>
											<div class="col-md-2 <?php if ($errors->has('tarjeta')) echo 'has-error' ?>">
												<input type="number" class="form-control" id="tarjeta" name="tarjeta" value="{{ Input::old('tarjeta') }}" placeholder="Tarjeta de Credito">
												@if ($errors->has('tarjeta'))
												    <span class="help-block">{{ $errors->first('tarjeta') }}</span>
											    @endif
											</div>
										</div>
										<div class="form-group @if ($errors->has('debito')) {{'has-error'}} @endif">
											<label class="col-md-2 control-label" for="debito">Tarjeta de Debito:</label>
											<div class="col-md-2 <?php if ($errors->has('debito')) echo 'has-error' ?>">
												<input type="number" class="form-control" id="debito" name="debito" value="{{ Input::old('debito') }}" placeholder="Tarjeta de Debito">
												@if ($errors->has('debito'))
												    <span class="help-block">{{ $errors->first('debito') }}</span>
											    @endif
											</div>
										</div>
										<div class="form-group @if ($errors->has('bancaria')) {{'has-error'}} @endif">
											<label class="col-md-2 control-label" for="bancaria">Cuenta Bancaria:</label>
											<div class="col-md-2 <?php if ($errors->has('bancaria')) echo 'has-error' ?>">
												<input type="number" class="form-control" id="bancaria" name="bancaria" value="{{ Input::old('bancaria') }}" placeholder="Cuenta Bancaria">
												@if ($errors->has('bancaria'))
												    <span class="help-block">{{ $errors->first('bancaria') }}</span>
											    @endif
											</div>
										</div>
										<div class="form-group @if ($errors->has('cheque')) {{'has-error'}} @endif">
											<label class="col-md-2 control-label" for="cheque">Cheque:</label>
											<div class="col-md-2 <?php if ($errors->has('cheque')) echo 'has-error' ?>">
												<input type="number" class="form-control" id="cheque" name="cheque" value="{{ Input::old('cheque') }}" placeholder="Cheque">
												@if ($errors->has('cheque'))
												    <span class="help-block">{{ $errors->first('cheque') }}</span>
											    @endif
											</div>
										</div><br>
										<div class="@if ($errors->has('observaciones2')) {{'has-error'}} @endif">
											<label class="col-md-2 control-label">Observaciones: </label>
											<div class="col-md-5 col-sm-10">
												<textarea rows="5" name="observaciones2" class="col-md-2 form-control" placeholder="Observaciones" 
												value="{{ Input::old('observaciones2') }}"></textarea>
												@if ($errors->has('observaciones2'))
													<span class="help-block">{{ $errors->first('observaciones2') }}</span>
												@endif
											</div>
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
															DEBE INGRESAR NÚMEROS EN EL MONTO!!
														</div>
														<div class="modal-footer">
															<button type="button" class="btn default" data-dismiss="modal">Cerrar</button>
														</div>
													</div>
												</div>
										</div>
										<!-- FIN MODAL-->

										<!-- MODAL DE ALERTAS-->
											<div class="modal fade" id="modalAlertas" tabindex="-3" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																<h4 id="titulo" class="modal-title"></h4>
															</div>
															<div class="modal-body">
																<p id="mensaje"></p>
															</div>
															<div class="modal-footer">
																<button type="button" class="btn default" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> Cerrar</button>
															</div>
														</div>
														<!-- /.modal-contenido -->
													</div>
											</div>
											<!-- /.modal -->										

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
$('#organizacion').attr('disabled', 'disabled');

	$('#imprimir').on('click', function(e){
		e.preventDefault();
		window.open("{{url('cajachica/pdfrecibo')}}");
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
		/*$.ajax({
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
			});*/
	});	
	
	$('#carrera').on('change', function(){
		$('#txt_carrera_id').val($('#carrera').val());
	});	

	$('#monto').on('change', function(){
		var monto = $('#monto').val();
		if (isNaN(parseFloat(monto))) {
    		$('#monto').focus();
		    $('#MensajeCantidad').modal('show');
		}

		if (monto <= 0) {
    		$('#monto').focus();
		    $('#MensajeCantidad').modal('show');
		}
	});	

    $('#cboFiltroAlumno').change(function() {
    	if ($('#cboFiltroAlumno').val() == 1) {
    		$("#txtalumno").attr("placeholder", "Apellido, Nombres").val("").focus().blur();
    	} else {
    		$("#txtalumno").attr("placeholder", "N° Documento").val("").focus().blur();
    	}
    	$('#txtalumno').val('');
    	$('#txtalumno').focus();
    });

	$('#cboFiltroConcepto').on('change', function(){
        $('#monto').val('');
        $('#organizacion').removeAttr("disabled");
    	$('#carrera').removeAttr("disabled");
    	$('#cboFiltroAlumno').removeAttr("disabled");
    	$('#txtalumno').removeAttr("disabled");
		
		if ($('#cboFiltroConcepto').val() == 6) {
		 	$('#organizacion').children().remove().end();
		 	$('#carrera').children().remove().end();
        	$('#txtalumno').val('');
			$('#organizacion').attr('disabled', 'disabled');
        	$('#carrera').attr('disabled', 'disabled');
        	$('#cboFiltroAlumno').attr('disabled', 'disabled');
        	$('#txtalumno').attr('disabled', 'disabled');
        	$('#txt_organizacion_id').val('');
        	$('#txt_carrera_id').val('');
        	$('#txt_alumno_id').val('');
			borrar_datos_alumno();
		}

		if ($('#cboFiltroConcepto').val() == 3) {
			$('#organizacion').attr('disabled', 'disabled');
        	$('#carrera').attr('disabled', 'disabled');
        	$('#cboFiltroAlumno').attr('disabled', 'disabled');
        	$('#txtalumno').val('');
        	$('#txtalumno').attr('disabled', 'disabled');
		 	$('#organizacion').children().remove().end();
		 	$('#carrera').children().remove().end();
        	$('#txt_organizacion_id').val('');
        	$('#txt_carrera_id').val('');
        	$('#txt_alumno_id').val('');
        	$('#monto').val('');
			borrar_datos_alumno();
		}

		if ($('#cboFiltroConcepto').val() == 4) {
		 	$('#organizacion').children().remove().end();
		 	$('#carrera').children().remove().end();
        	$('#txtalumno').val('');
			$('#organizacion').attr('disabled', 'disabled');
        	$('#carrera').attr('disabled', 'disabled');
        	$('#cboFiltroAlumno').attr('disabled', 'disabled');
        	$('#txtalumno').attr('disabled', 'disabled');
        	$('#txt_organizacion_id').val('');
        	$('#txt_carrera_id').val('');
        	$('#txt_alumno_id').val('');
			borrar_datos_alumno();
		}

		if ($('#cboFiltroConcepto').val() == 8) {
		 	$('#organizacion').children().remove().end();
		 	$('#carrera').children().remove().end();
        	$('#txtalumno').val('');
			$('#organizacion').attr('disabled', 'disabled');
        	$('#carrera').attr('disabled', 'disabled');
        	$('#cboFiltroAlumno').attr('disabled', 'disabled');
        	$('#txtalumno').attr('disabled', 'disabled');
        	$('#txt_organizacion_id').val('');
        	$('#txt_carrera_id').val('');
        	$('#txt_alumno_id').val('');
			borrar_datos_alumno();
		}
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
				$('#organizacion').removeAttr("disabled");
	        	$('#carrera').removeAttr("disabled");
	        	$('#cboFiltroAlumno').removeAttr("disabled");
	        	$('#txtalumno').removeAttr("disabled");
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

	$('#txtalumno').on('change', function() {
	    buscar_alumno();
    });

	$('#BtnBuscar').live('click', function() {
	    buscar_alumno();
    });

	function buscar_alumno() {

		borrar_datos_alumno();

		/* VALIDACIONES DEL BOTON BUSCAR */
	    if ($.trim($('#txtalumno').val()) == '') {
	    	mostrarMensajes('modalAlertas', 'Alumno', 'Ingrese el dato del Alumno');
	    	//alert('Ingrese el dato del Alumno');
	    	return;
	    }
	    if ($('#cboFiltroAlumno').val() == 0) {
	        if ($.trim($('#txtalumno').val()) == '') {
	        	mostrarMensajes('modalAlertas', 'Alumno', 'Debe ingresar el DNI del Alumno');
	    	    //alert('Debe ingresar el DNI del Alumno');
	    	    return;
	    	}
	    	url_destino = "{{url('alumnos/obteneralumnopordni')}}";
	    } else {
	        if ($.trim($('#txtalumno').val()) == '') {
	        	mostrarMensajes('modalAlertas', 'Alumno', 'Debe ingresar el Apellido y Nombre del Alumno');
	    	    //alert('Debe ingresar el Apellido y Nombre del Alumno');
	    	    return;
	    	}
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
				mostrarMensajes('modalAlertas', 'Alumno', 'No se ha encontrado ningún registro');
				//alert('No se ha encontrado ningún registro');
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

		    var alumno_id = alumno.alumno_id;

		    $.ajax({
			type: "POST",
			url: "{{url('cajachica/buscarcarreras/')}}",
			data: { alumno_id: alumno_id },
			type: "POST"
			}).done(function(carreras) {
				console.log(carreras);

		 		$('#carrera').children().remove().end();
				
				$.each(carreras, function(key, value) {
				    $('#txt_carrera_id').val(value.id);
					$('#carrera').append(
				        $('<option></option>').val(value.id).html(value.carrera)
				    );
				});

				if ($('#cboFiltroConcepto').val() == 6) {
					alumno_id = $('#txt_alumno_id').val();
				    $.ajax({
					type: "POST",
					url: "{{url('cajachica/buscarmonto')}}",
					data: { alumno_id: alumno_id },
					type: "POST"
					}).done(function(monto) {
						console.log(monto);

						$('#monto').val(monto);

					}).error(function(data) {
						console.log(data);
					});
				}

			}).error(function(data) {
				console.log(data);
			});

		}).error(function(data) {
			console.log(data);
		});
	}

    $('#tipomovimiento').change(function() {
    	var movimiento = $('#tipomovimiento').val();

    	$.ajax({
			type: "POST",
			url: "{{url('cajachica/obtenercomprobante')}}",
			data: { movimiento: movimiento },
			type: "POST"
		}).done(function(movimientos) {
			console.log(movimientos);

			if (movimientos == '') {
				$('#txtmovimiento').val(1);
				$('#divN').html(1);
			} else {
				$('#txtmovimiento').val(movimientos);
				$('#divN').html(movimientos);
			}

		}).error(function(data) {
			console.log(data);
		});
    });

    /*$('#txtmovimiento').change(function() {
    	var txtmovimiento = $('#txtmovimiento').val();
    	$.ajax({
			type: "POST",
			url: "{{url('cajachica/obtenercomprobante')}}",
			data: { txtmovimiento: txtmovimiento },
			type: "POST"
		}).done(function(mensaje) {
			console.log(mensaje);

			if (mensaje == 'ERROR') {
		    	$('#MensajeCantidad').modal('show');
		    	$('#txtmovimiento').val('');
		    	$('#txtmovimiento').focus();
			}

		}).error(function(data) {
			console.log(data);
		});
    });*/

    function mostrarMensajes(modal, titulo, mensaje)
    {
    	$('#titulo').text(titulo);
    	$('#mensaje').text(mensaje);
    	$('#'+modal).modal('show');
    }

    function calcular_forma_pago() {
        var efectivo = parseInt($('#efectivo').val());
    	var tarjeta = parseInt($('#tarjeta').val());
    	var debito = parseInt($('#debito').val());
    	var bancaria = parseInt($('#bancaria').val());
    	var cheque = parseInt($('#cheque').val());
    	var monto = parseInt($('#monto').val());

    	if (!efectivo) efectivo = 0;
    	
    	if (!tarjeta) tarjeta = 0;

    	if (!debito) debito = 0;

    	if (!bancaria) bancaria = 0;

    	if (!cheque) cheque = 0;

		var total = efectivo + tarjeta + debito + bancaria + cheque;

    	if (!isNaN(monto)) {
	    	if (total > monto) {
	        	alert("No se debe superar el Monto a Abonar!!");
	        	$('#efectivo').val('');
	        	$('#tarjeta').val('');
	    		$('#debito').val('');
	    		$('#bancaria').val('');
	    		$('#cheque').val('');
		    } else {
		    	if (efectivo > monto) {
		    		alert("El valor no debe ser mayor que el Monto a Abonar!!");
		    		$('#efectivo').val('');
		    	}
		    	if (tarjeta > monto) {
		    		alert("El valor no debe ser mayor que el Monto a Abonar!!");
		    		$('#tarjeta').val('');
		    	}
		    	if (debito > monto) {
		    		alert("El valor no debe ser mayor que el Monto a Abonar!!");
		    		$('#debito').val('');
		    	}
		    	if (bancaria > monto) {
		    		alert("El valor no debe ser mayor que el Monto a Abonar!!");
		    		$('#bancaria').val('');
		    	}
		    	if (cheque > monto) {
		    		alert("El valor no debe ser mayor que el Monto a Abonar!!");
		    		$('#cheque').val('');
		    	}
		    }
	    }
    }

    $('#efectivo').live('keyup', function() {
    	var efectivo = parseInt($('#efectivo').val());
    	if (efectivo < 0) {
    		alert('El valor no debe ser negativo');
    		$('#efectivo').val('');
    	}
    	calcular_forma_pago();
	});

    $('#tarjeta').live('keyup', function() {
    	var tarjeta = parseInt($('#tarjeta').val());
    	if (tarjeta < 0) {
    		alert('El valor no debe ser negativo');
    		$('#tarjeta').val('');
    	}
    	calcular_forma_pago();
	});

    $('#debito').live('keyup', function() {
    	var debito = parseInt($('#debito').val());
    	if (debito < 0) {
    		alert('El valor no debe ser negativo');
    		$('#debito').val('');
    	}
    	calcular_forma_pago();
	});

    $('#bancaria').live('keyup', function() {
    	var bancaria = parseInt($('#bancaria').val());
    	if (bancaria < 0) {
    		alert('El valor no debe ser negativo');
    		$('#bancaria').val('');
    	}
    	calcular_forma_pago();
	});

    $('#cheque').live('keyup', function() {
    	var cheque = parseInt($('#cheque').val());
    	if (cheque < 0) {
    		alert('El valor no debe ser negativo');
    		$('#cheque').val('');
    	}
    	calcular_forma_pago();
	});

@stop

@section('includejs') 
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{url('assets/global/plugins/select2/select2.min.js')}}"></script>
<script src="{{url('assets/admin/layout/scripts/menusticky.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
@stop
