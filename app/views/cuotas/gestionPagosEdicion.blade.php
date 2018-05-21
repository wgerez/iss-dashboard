@extends('layouts.master')

@section('customstyle')
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/select2/select2.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css')}}"/>
<!-- END PAGE LEVEL STYLES -->
<style>
	td.verinfo{ cursor:pointer;}
	td.cargadeuda{ cursor:pointer;}

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
$disabled = (!$editar) ? 'disabled' : '';
$readonly = (!$editar) ? 'readonly' : '';
$imprimir = (!$imprimir) ? 'disabled' : '';

foreach ($carreras as $carrera) {
	$inscripcion_id = $carrera->inscripcion_id;
}

$total = 0;
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
					Cuotas <small>Nueva Cuota</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('cuotas/listado')}}">Cuotas</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">nuevo</a>
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
					    @if (Session::get('message_type') == CuotasController::OPERACION_EXITOSA)

							<div class="note note-success">
								<p> {{ Session::get('message') }} </p>
							</div>
						@elseif (Session::get('message_type') == CuotasController::OPERACION_FALLIDA)

							<div class="note note-danger">
								<p> {{ Session::get('message') }} </p>
							</div>

						@endif	
					@endif
					<!-- COMIENZO DE LA TABLA-->
					<?php if ($editargestion == 1) { ?>
						{{ Form::open(array('url'=>'cuotas/pagar', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmCuotas', 'enctype'=>'multipart/form-data'))}}
					<?php } else { ?>
						{{ Form::open(array('url'=>'cuotas/guardar', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmCuotas', 'enctype'=>'multipart/form-data'))}}
					<?php } ?>
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-copy"></i> Cuota
							</div>
							<div class="actions">
								<?php if ($editargestion == 1) { ?>
									<a href="{{url('cuotas/pagar')}}" class="btn default green-stripe">
									<i class="fa fa-plus"></i>
									<span class="hidden-480">
									Pagar </span>
									</a>
								<?php } else { ?>
									<a href="{{url('cuotas/guardar')}}"></a>
									<button type='submit' class="btn default green-stripe" id="btnGuardar" {{ $disabled }}>
									<i class="fa fa-save"></i>
									<span class="hidden-480">
									Guardar </span>
									</button>
								<?php } ?>
								<a href="{{url('cuotas/listado')}}" class="btn default yellow-stripe">
								<i class="fa fa-reorder"></i>
								<span class="hidden-480">
								Listado </span>
								</a>
								<a disabled href="recibo" class="btn default blue-stripe">
								<i class="fa fa-times"></i>
								<span class="hidden-480">
								Historial </span>
								</a>
							</div>

						</div>
						<div class="portlet-body form">
								<div class="form-body">
									<div class="form-group">
										<label  class="col-md-2 col-sm-2 control-label">Alumno:</label>
										<div class="col-md-4 col-sm-4">
											<select name="cboFiltroAlumno" id="cboFiltroAlumno" class="table-group-action-input form-control" readonly>
												<option value="2">DNI</option>
												<option value="1">Apellido y Nombre</option>
											</select>
										</div>

										<div class="col-md-4 col-sm-4">
											<input class="form-control" name="txtalumno" id="txtalumno" type="text" value="{{$alumno->nrodocumento}}" readonly>
										</div>
										<input class="form-control" name="txt_pago_id" id="txt_pago_id" type="hidden" value="{{$pago_id}}">
										<input class="form-control" name="txt_alumno_id" id="txt_alumno_id" type="hidden" value="{{$alumno->alumno_id}}">
										<input class="form-control" name="txt_inscripcion_id" id="txt_inscripcion_id" type="hidden" value="{{$inscripcion_id}}">
				  						<input id="txt_persona_id" name='txt_persona_id' type="hidden" value="{{$alumno->persona_id}}">
										<div class="col-md-2 col-sm-2">
											<a class="btn blue-madison" id='btnBuscarAlumno' disabled>
												<i class="fa fa-search"></i> Buscar
											</a>
										</div>
									</div>
									<div class="form-group">
										<label  class="col-md-2 col-sm-2 control-label">Ciclo Lectivo:</label>
										<div class="col-md-2 col-sm-2">
											<select name='cboCiclo' id='cboCiclo' class='table-group-action-input form-control' readonly>
											    @foreach ($ciclos as $ciclo)
											    	<?php if ($ciclolectivo == $ciclo->id) { ?>
											    		<option value='{{$ciclo->id}}' selected>{{$ciclo->descripcion}}</option>
											    		<?php
											    	} else { ?>
											        <option value='{{$ciclo->id}}'>{{$ciclo->descripcion}}</option>
											        <?php } ?>
											    @endforeach
											</select>
										</div>
									</div>
								</div>
						</div> <!-- FIN PORTLET-BODY -->
					</div>

					<br>

					<div class="portlet form-horizontal">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-user"></i>Datos del Alumno
							</div>
						</div>
						<div class="portlet-body form">
							<div class="form-group">
								<label  class="col-md-2 col-sm-2 control-label text-info">Alumno:</label>
								<div class="col-md-2 col-sm-4" id='divAlumno'><p class="form-control-static">{{$alumno->apellido}} , {{$alumno->nombre}}</p></div>
								<label  class="col-md-2 col-sm-2 control-label text-info">DNI:</label>
								<div class="col-md-2 col-sm-4" id='divDNI'><p class="form-control-static">{{$alumno->nrodocumento}}</p></div>								
							</div>

							<div class="form-group">
								<label  class="col-md-2 col-sm-2 control-label text-info">Dirección:</label>
								<div class="col-md-10 col-sm-10" id='divDomicilio'><p class="form-control-static">
										{{$alumno->calle}} {{$alumno->numero}} ({{$alumno->localidad}}, {{$alumno->provincia}})
									</p></div>
							</div>
							<!--<div class="form-group">
								<label  class="col-md-2 col-sm-2 control-label text-info">N° Cuenta:</label>
								<div class="col-md-10 col-sm-10">
									<p class="form-control-static">0000</p>
								</div>
							</div>-->
						</div>

						<div class="portlet">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-list"></i>Detalle Pago
								</div>
							</div>

							<div class="form-group">
								<label  class="col-md-2 col-sm-2 control-label">Carrera:</label>
								<div class="col-md-8 col-sm-10">
									<select name='cboCarrera' id='cboCarrera' class='table-group-action-input form-control' readonly>
									    @foreach ($carreras as $carrera)
									        <option value='{{$carrera->carrera_id}}'>
									    	{{$carrera->carrera}}
									        </option>
									    @endforeach
									</select>
								</div>
								<!--label  class="col-md-2 col-sm-2 control-label">Ciclo Lectivo:</label>
								<div class="col-md-2 col-sm-4">
									{{ Form::select('cboCiclo', array(), Input::old('cboCiclo'), array('class'=>'table-group-action-input form-control','id'=>'cboCiclo')); }}
								</div>
								<div class="col-md-2 col-sm-4">
									<a class="btn blue-madison" id='btnAgregar'>
										<i class="fa fa-save"></i> Agregar
									</a>
								</div-->
							</div>

							<div class="form-group">
								<label class="col-md-2 col-sm-2 control-label" for="check_cuota_importe">Cuota
									<span class="checked"><input type="checkbox" class="form-control" id="check_cuota_importe" name="check_cuota_importe" readonly></span>
								</label>
								<input class="form-control" name="txt_matricula_id" id="txt_matricula_id" type="hidden" value="{{$matricula}}">

								<label class="col-md-1 col-sm-1 control-label">Mes Cuota:</label>
								<div class="col-md-2 col-sm-2">
									<select name="cboMesPagoCuotaInicio" id="cboMesPagoCuotaInicio" class="table-group-action-input form-control">
										<?php if (isset($cuotasmeses)) {
											for ($i=0; $i < count($cuotasmeses); $i++) {
												?><option value="<?php echo $cuotasmeses[$i]['id']; ?>"><?php echo $cuotasmeses[$i]['mes']; ?></option><?php
											}
										}
										?>
									</select>									
								</div>

								<label class="col-md-1 col-sm-1 control-label">Importe:</label>
								<div class="col-md-2 col-sm-2">
								<?php if ($editargestion == 2 or $editargestion == 3) { ?>
								@if (isset($cuota_detalle))
										@foreach ($cuota_detalle as $cuota_detall)
										<input type="hidden" class="form-control" id="txt_importe" name="txt_importe" value="{{ $cuota_detall['importe'] }}">
										<input type="text" class="form-control" id="txt_importe1" name="txt_importe1" value="{{ $cuota_detall['importe'] }}" readonly>
									@endforeach
								@endif
								<?php } else { ?>
									<input type="hidden" class="form-control" id="txt_importe" name="txt_importe" value="">
									<input type="text" class="form-control" id="txt_importe1" name="txt_importe1" value="" readonly>
								<?php } ?>
								</div>

								<label class="col-md-1 col-sm-1 control-label">Descuento:</label>
								<div class="col-md-2 col-sm-2">
									<input type="text" class="form-control" id="txt_descuento" name="txt_descuento" value="" <?php if ($editargestion == 1) echo "readonly"; ?>>
									<input type="hidden" class="form-control" id="txtdescuento" name="txtdescuento" value="">
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-2 col-sm-2 control-label">Recargo:</label>
								<div class="col-md-2 col-sm-2">
									<input type="text" class="form-control" id="txt_recargo" name="txt_recargo" value="" <?php if ($editargestion == 1) echo "readonly"; ?>>
									<input type="hidden" class="form-control" id="txtrecargo" name="txtrecargo" value="">
								</div>

								<label class="col-md-1 col-sm-1 control-label">Total:</label>
								<div class="col-md-2 col-sm-2">
								<?php if ($editargestion == 2 or $editargestion == 3) { ?>
								@if (isset($cuota_detalle))
										@foreach ($cuota_detalle as $cuota_detall)
									<input type="hidden" class="form-control" id="txt_total" name="txt_total" value="{{ $cuota_detall['importe'] }}">
									<input type="text" class="form-control" id="txt_total1" name="txt_total1" value="{{ $cuota_detall['importe'] }}" readonly>
									@endforeach
								@endif
								<?php } else { ?>
									<input type="hidden" class="form-control" id="txt_total" name="txt_total" value="">
									<input type="text" class="form-control" id="txt_total1" name="txt_total1" value="" readonly>
								<?php } ?>
								</div>
								<?php //if ($editargestion == 3) { ?>
								<!--div class="col-md-2 col-sm-2">
									<a class="btn blue-madison" id='btnAgregar1'>
										<i class="glyphicon glyphicon-plus"></i> Agregar
									</a>
								</div-->
								<?php //} else { ?>
								<div class="col-md-2 col-sm-2">
									<a class="btn blue-madison" id='btnAgregar' <?php if ($editargestion == 1) echo "disabled";
									?>>
										<i class="glyphicon glyphicon-plus"></i> Agregar
									</a>
								</div>
								<?php //} ?>
								<div class="col-md-2 col-sm-2">
									<a target="_blank" class="btn blue-madison" id='btnImprimir' <?php if ($editargestion == 2 or $editargestion == 3) echo "disabled"; ?>>
										<i class="glyphicon glyphicon-print"></i> Imp. Comprobante
									</a>
								</div>
							</div>

							<!--div class="form-group">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<center>
										<p>
											<span class="text-success"><i class="glyphicon glyphicon-align-justify"> Pagado</i></span> -- 
											<span class="text-danger"><i class="glyphicon glyphicon-align-justify"> Adeuda</i></span> --
											<span class="text-warning"><i class="glyphicon glyphicon-align-justify"> Parcial</i></span>
										</p>
									</center>
								</div>
							</div-->

						<div class="portlet">
							<div class="portlet-title">
								<div class="caption">
									<i class="glyphicon glyphicon-tasks"></i>Cuotas
								</div>
							</div>
							<div class="portlet-body">
								<div class="table-scrollable">
									<table class="table table-hover" id='tableMatriculaCuotas'>
									<thead>
									<tr>
										<th style="display: none;">
											 ID Cuota
										</th>
										<th>
											<center>Fecha Pago</center>
										</th>
										<th>
											<center>Cuota</center>
										</th>
										<th>
											<center>Monto Descuento</center>
										</th>
										<th>
											<center>Monto Recargo</center>
										</th>
										<th>
											<center>Importe</center>
										</th>
										<th>
											<center>Total</center>
										</th>
										<?php if ($editargestion == 2 or $editargestion == 3) {
										echo "<th><center>Acción</center></th>";
									} ?>
										<!--th>
											<center>Acción</center>
										</th-->
									</tr>
									</thead>
									<tbody>
									@if (isset($cuota_detalle))
										@foreach ($cuota_detalle as $cuota_detall)
											<?php if ($editargestion == 1) { ?>
											<tr>
												<td style="display: none;">
													<center>
														{{ $cuota_detall['mescuota'] }}
													</center>
												</td>
												<td>
													<center>
														{{ $cuota_detall['fechatransaccion'] }}
													</center>
												</td>
												<td>
													<center>
														{{ $cuota_detall['mes'] }}
													</center>
												</td>
												<td>
													<center>
														{{ $cuota_detall['descuentos'] }}
													</center>
												</td>
												<td>
													<center>
														{{ $cuota_detall['recargos'] }}
													</center>
												</td>
												<td>
													<center>
														{{ $cuota_detall['importe'] }}
													</center>
												</td>
												<td>
													<center> 
														${{ $cuota_detall['importe'] }}
													</center>
												</td>
												<!--td>
													<center>
														<p id="quitar" class="quitar"><i class="fa fa-trash-o"></i> Quitar</p>
													</center>
												</td-->
											</tr>
											<?php } 
											$total = $total + $cuota_detall['importe'];
											$efectivo = $cuota_detall['efectivo'];
											$tarjetacredito = $cuota_detall['tarjetacredito'];
											$tarjetadebito = $cuota_detall['tarjetadebito'];
											$cuentabancaria = $cuota_detall['cuentabancaria'];
											$cheque = $cuota_detall['cheque'];
											$observaciones = $cuota_detall['observaciones'];

											if ($editargestion == 2 or $editargestion == 3) $total = 0;
											?>
										@endforeach
									@endif
									</tbody>
									</table>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-1 col-sm-1 control-label"><strong>TOTAL</strong></label>
						 		<div class="input-icon col-md-10 col-sm-10">
									<input type="text" name="txt_total_pagar" id="txt_total_pagar" placeholder="" class="form-control" value='<?php echo $total; ?>' style="text-align:right" readonly>
									<input type="hidden" name="txt_total_apagar" id="txt_total_apagar" placeholder="" class="form-control" value='<?php echo $total; ?>'>
								</div><br>
							</div>
						</div>

						<div class="portlet">
							<div class="portlet-title">
								<div class="caption">
									<i class="glyphicon glyphicon-usd"></i>Forma de Pago
								</div>
							</div>
							<div class="form-group @if ($errors->has('txt_efectivo')) {{'has-error'}} @endif">
								<label class="col-md-2 control-label" for="txt_efectivo">Importe Efectivo:</label>
								<div class="col-md-2 <?php if ($errors->has('txt_efectivo')) echo 'has-error' ?>">
									<input type="number" class="form-control" id="txt_efectivo" name="txt_efectivo" value="{{$efectivo}}" placeholder="Efectivo" <?php if ($editargestion == 1) echo "disabled"; ?>>
									@if ($errors->has('txt_efectivo'))
									    <span class="help-block">{{ $errors->first('txt_efectivo') }}</span>
								    @endif
								</div>
							</div>
							<div class="form-group @if ($errors->has('txt_tarjeta')) {{'has-error'}} @endif">
								<label class="col-md-2 control-label" for="txt_tarjeta">Importe Tarj. Crédito:</label>
								<div class="col-md-2 <?php if ($errors->has('txt_tarjeta')) echo 'has-error' ?>">
									<input type="number" class="form-control" id="txt_tarjeta" name="txt_tarjeta" value="{{$tarjetacredito}}" placeholder="Tarjeta de Credito" <?php if ($editargestion == 1) echo "disabled"; ?>>
									@if ($errors->has('txt_tarjeta'))
									    <span class="help-block">{{ $errors->first('txt_tarjeta') }}</span>
								    @endif
								</div>
							</div>
							<div class="form-group @if ($errors->has('txt_debito')) {{'has-error'}} @endif">
								<label class="col-md-2 control-label" for="txt_debito">Importe Tarj. Débito:</label>
								<div class="col-md-2 <?php if ($errors->has('txt_debito')) echo 'has-error' ?>">
									<input type="number" class="form-control" id="txt_debito" name="txt_debito" value="{{$tarjetadebito}}" placeholder="Tarjeta de Debito" <?php if ($editargestion == 1) echo "disabled"; ?>>
									@if ($errors->has('txt_debito'))
									    <span class="help-block">{{ $errors->first('txt_debito') }}</span>
								    @endif
								</div>
							</div>
							<div class="form-group @if ($errors->has('txt_bancaria')) {{'has-error'}} @endif">
								<label class="col-md-2 control-label" for="txt_bancaria">Cuenta Bancaria:</label>
								<div class="col-md-2 <?php if ($errors->has('txt_bancaria')) echo 'has-error' ?>">
									<input type="number" class="form-control" id="txt_bancaria" name="txt_bancaria" value="{{$cuentabancaria}}" placeholder="Cuenta Bancaria" <?php if ($editargestion == 1) echo "disabled"; ?>>
									@if ($errors->has('txt_bancaria'))
									    <span class="help-block">{{ $errors->first('txt_bancaria') }}</span>
								    @endif
								</div>
							</div>
							<div class="form-group @if ($errors->has('txt_cheque')) {{'has-error'}} @endif">
								<label class="col-md-2 control-label" for="txt_cheque">Importe Cheque:</label>
								<div class="col-md-2 <?php if ($errors->has('txt_cheque')) echo 'has-error' ?>">
									<input type="number" class="form-control" id="txt_cheque" name="txt_cheque" value="{{$cheque}}" placeholder="Cheque" <?php if ($editargestion == 1) echo "disabled"; ?>>
									@if ($errors->has('txt_cheque'))
									    <span class="help-block">{{ $errors->first('txt_cheque') }}</span>
								    @endif
								</div>
							</div>
							<div class="@if ($errors->has('observaciones')) {{'has-error'}} @endif">
								<label class="col-md-2 control-label">Observaciones: </label>
								<div class="col-md-5 col-sm-10">
									<textarea rows="5" name="observaciones" class="col-md-2 form-control" placeholder="Observaciones" 
									value="{{$observaciones}}" <?php if ($editargestion == 1) echo "readonly"; ?>>{{$observaciones}}</textarea>
									@if ($errors->has('observaciones'))
										<span class="help-block">{{ $errors->first('observaciones') }}</span>
									@endif
								</div>
							</div>
						</div>
					</div>

				</div>
				{{ Form::close()}}
			</div>
			<!-- FIN DEL CONTENIDO -->
			
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

		</div>
	</div>
	<!-- FIN -->

@stop


@section('customjs')
	ComponentsFormTools.init();

    $('#cboMesPagoCuotaInicio').attr('disabled', 'disabled');
    //$('#btnAgregar').attr('disabled', 'disabled');
	//$('#btnImprimir').attr('disabled', 'disabled');
    /*$('#txt_efectivo').attr('disabled', 'disabled');
	$('#txt_tarjeta').attr('disabled', 'disabled');
    $('#txt_debito').attr('disabled', 'disabled');
	$('#txt_bancaria').attr('disabled', 'disabled');
    $('#txt_cheque').attr('disabled', 'disabled');*/
	$('#observaciones').attr('disabled', 'disabled');

    $('#btnGuardar').live('keyup', function() {
    	$('#btnImprimir').removeAttr("disabled");
	});

    $('#btnGuardar').change(function() {
    	$('#btnImprimir').removeAttr("disabled");
    });

	$('#btnImprimir').on('click', function(e){
		e.preventDefault();
		window.open("{{url('cuotas/imprimirrecibo')}}?inscripcion_id=" + $('#txt_inscripcion_id').val() + '&matricula_id=' + $('#txt_matricula_id').val() + '&txt_pago_id=' + $('#txt_pago_id').val());
	});

    function calcular_forma_pago() {
        var txt_efectivo = parseInt($('#txt_efectivo').val());
    	var txt_tarjeta = parseInt($('#txt_tarjeta').val());
    	var txt_debito = parseInt($('#txt_debito').val());
    	var txt_bancaria = parseInt($('#txt_bancaria').val());
    	var txt_cheque = parseInt($('#txt_cheque').val());
    	var txt_total_pagar = parseInt($('#txt_total_pagar').val());
    	var bandera = true;

    	if (!txt_efectivo) txt_efectivo = 0;
    	
    	if (!txt_tarjeta) txt_tarjeta = 0;

    	if (!txt_debito) txt_debito = 0;

    	if (!txt_bancaria) txt_bancaria = 0;

    	if (!txt_cheque) txt_cheque = 0;

		var total = txt_efectivo + txt_tarjeta + txt_debito + txt_bancaria + txt_cheque;

        if (total > txt_total_pagar) {
        	//alert("No se debe superar el Importe Total!!");
        	$('#divMensaje').html('<p class="form-control-static"><h4>' + 'No se debe superar el Importe Total!!' + '</h4></p>');
	    	$('#MensajeCantidad').modal('show');
        	$('#txt_efectivo').val('');
        	$('#txt_tarjeta').val('');
    		$('#txt_debito').val('');
    		$('#txt_bancaria').val('');
    		$('#txt_cheque').val('');
        } else {
	    	if (txt_efectivo > txt_total_pagar) {
	    		//alert("El valor no debe ser mayor que el Total a Pagar!!");
	    		$('#divMensaje').html('<p class="form-control-static"><h4>' + 'El valor no debe ser mayor que el Total a Pagar!!' + '</h4></p>');
	    		$('#MensajeCantidad').modal('show');
	    		$('#txt_efectivo').val('');
	    		bandera = false;
	    	}
	    	if (txt_tarjeta > txt_total_pagar) {
	    		//alert("El valor no debe ser mayor que el Total a Pagar!!");
	    		$('#divMensaje').html('<p class="form-control-static"><h4>' + 'El valor no debe ser mayor que el Total a Pagar!!' + '</h4></p>');
	    		$('#MensajeCantidad').modal('show');
	    		$('#txt_tarjeta').val('');
	    		bandera = false;
	    	}
	    	if (txt_debito > txt_total_pagar) {
	    		//alert("El valor no debe ser mayor que el Total a Pagar!!");
	    		$('#divMensaje').html('<p class="form-control-static"><h4>' + 'El valor no debe ser mayor que el Total a Pagar!!' + '</h4></p>');
	    		$('#MensajeCantidad').modal('show');
	    		$('#txt_debito').val('');
	    		bandera = false;
	    	}
	    	if (txt_bancaria > txt_total_pagar) {
	    		//alert("El valor no debe ser mayor que el Total a Pagar!!");
	    		$('#divMensaje').html('<p class="form-control-static"><h4>' + 'El valor no debe ser mayor que el Total a Pagar!!' + '</h4></p>');
	    		$('#MensajeCantidad').modal('show');
	    		$('#txt_bancaria').val('');
	    		bandera = false;
	    	}
	    	if (txt_cheque > txt_total_pagar) {
	    		//alert("El valor no debe ser mayor que el Total a Pagar!!");
	    		$('#divMensaje').html('<p class="form-control-static"><h4>' + 'El valor no debe ser mayor que el Total a Pagar!!' + '</h4></p>');
	    		$('#MensajeCantidad').modal('show');
	    		$('#txt_cheque').val('');
	    		bandera = false;
	    	}
	    }
    }

    $('#txt_efectivo').live('keyup', function() {
    	calcular_forma_pago();
	});

    $('#txt_tarjeta').live('keyup', function() {
    	calcular_forma_pago();
	});

    $('#txt_debito').live('keyup', function() {
    	calcular_forma_pago();
	});

    $('#txt_bancaria').live('keyup', function() {
    	calcular_forma_pago();
	});

    $('#txt_cheque').live('keyup', function() {
    	calcular_forma_pago();
	});

	function limpiar_datos_pago_cuotas() {
		$('#txt_inscripcion_id').val('');
		$('#txt_numero_cuota').val('');
		$('#txt_importe').val('');
		$('#txt_importe1').val('');
		$('#lbl_ciclo_lectivo').html('');
		$('#lbl_fecha_vencimiento').html('');
		$('#txt_fecha_vencimiento').val('');
    }

    function calcular_total_a_pagar() {
        var importe = parseInt($('#txt_importe').val());
    	var porcentaje_recargo = parseInt($('#txt_recargo').val());
    	var porcentaje_descuento = parseInt($('#txt_descuento').val());

    	var recargo = 0;
    	var descuento = 0;

    	if (!isNaN(porcentaje_recargo)) {
    		recargo = (importe * porcentaje_recargo) / 100;
        }

    	if (!isNaN(porcentaje_descuento)) {
    		descuento = (importe * porcentaje_descuento) / 100;
        }

        var total = importe + recargo - descuento;

        $('#txtrecargo').val(recargo);
        $('#txtdescuento').val(descuento);

        $('#txt_total').val(total);
        $('#txt_total1').val(total);
    }

    $('#txt_recargo').live('keyup', function() {
    	calcular_total_a_pagar();
	});

    $('#txt_descuento').live('keyup', function() {
    	calcular_total_a_pagar();
	});

	function borrar_opciones_filtro() {
        //$('#ciclo_lectivo_activo').text('Ciclo Lectivo:');
        //$('#txt_ciclo_lectivo_id').val('');
        $('#txtalumno').val('');
    }

    /* DESHABILITO EL ENTER EN EL CONTROL */
	$('#txtalumno').keypress(function(e) {
	    if (e.which == 13) {
	    	buscar_alumno();
	    	return false;
	    }
	});

	function borrar_datos_alumno() {
		 $('#divAlumno').html('');
		 $('#divDNI').html('');
		 $('#divDomicilio').html('');
		 $('#cboCarrera').children().remove().end();
	}

	$('#btnBuscarAlumno').live('click', function() {
	    buscar_alumno();
    });

	function buscar_alumno() {

		borrar_datos_alumno();
		limpiar_tabla_matriculas();

		/* VALIDACIONES DEL BOTON BUSCAR */
	    if ($.trim($('#txtalumno').val()) == '') {
	    	//alert('Ingrese el dato del Alumno');
    		$('#divMensaje').html('<p class="form-control-static"><h4>' + 'Ingrese el dato del Alumno' + '</h4></p>');
    		$('#MensajeCantidad').modal('show');
	    	return;
	    }
	    if ($('#cboFiltroAlumno').val() == 2) {
	        if ($.trim($('#txtalumno').val()) == '') {
	    	    //alert('Debe ingresar el DNI del Alumno');
	    		$('#divMensaje').html('<p class="form-control-static"><h4>' + 'Debe ingresar el DNI del Alumno' + '</h4></p>');
	    		$('#MensajeCantidad').modal('show');
	    	    return;
	    	}
	    	url_destino = "{{url('alumnos/obteneralumnopordni')}}";
	    } else {
	        url_destino = "{{url('alumnos/obteneralumnoporapellidoynombre')}}";
	    }

	    /* OBTENGO EL ALUMNO */
	    $.ajax({
			  url: "{{url('cuotas/obteneralumnobecado')}}",
			  data:{'txt_alumno': $('#txtalumno').val()},
			  type: 'POST'
			}).done(function(alumno) {
				console.log(alumno);
				if (alumno == 1) {
					//alert('El Alumno se encuentra Becado!');
		    		$('#divMensaje').html('<p class="form-control-static"><h4>' + 'El Alumno se encuentra Becado!' + '</h4></p>');
		    		$('#MensajeCantidad').modal('show');
					return;
			    }
			$.ajax({
			  url: url_destino,
			  data:{'txt_alumno': $('#txtalumno').val()},
			  type: 'POST'
			}).done(function(alumno) {
				console.log(alumno);
				if (alumno == <?php echo AlumnosController::NO_EXISTE_ALUMNO ?>) {
					//alert('No se ha encontrado ningún registro');
		    		$('#divMensaje').html('<p class="form-control-static"><h4>' + 'No se ha encontrado ningún registro' + '</h4></p>');
		    		$('#MensajeCantidad').modal('show');
					return;
			    }
			    var apellido_nombre = alumno.apellido + ', ' + alumno.nombre;
			    var dni = alumno.nrodocumento;
			    var domicilio = alumno.calle + ' ' + alumno.numero + ' (' + alumno.localidad + ', ' + alumno.provincia + ')';
			    $('#divAlumno').html('<p class="form-control-static">' + apellido_nombre + '</p>');
			    $('#divDNI').html('<p class="form-control-static">' + dni + '</p>');
			    $('#divDomicilio').html('<p class="form-control-static">' + domicilio + '</p>');

			    $('#txt_alumno_id').val(alumno.alumno_id);
			    $('#txt_persona_id').val(alumno.persona_id);
			    $('#txt_persona_id_verInfo').val(alumno.persona_id);

	            /* OBTENGO CARRERAS A LAS QUE ESTA INCRITO EL ALUMNO */
				$.ajax({
				  url: '{{url('cuotas/obtenercarrerasinscripciones')}}',
				  data:{'alumno_id': alumno.alumno_id},
				  type: 'POST'
				}).done(function(carreras) {
					console.log(carreras);

					/*$('#cboCarrera').append(
				        $('<option></option>').val(0).html('Seleccionar')
				    );
					
					$.each(carreras, function(key, value) {
						$('#cboCarrera').append(
					        $('<option></option>').val(value.carrera_id).html(value.carrera)
					    );
					});*/

					$.ajax({
					  url: '{{url('cuotas/obtenercicloinscripciones')}}',
					  data:{'alumno_id': alumno.alumno_id},
					  type: 'POST'
					}).done(function(ciclos) {
						console.log(ciclos);
						$('#cboCiclo').removeAttr("disabled");
				 		$('#cboCiclo').children().remove().end();

				 		$('#cboCiclo').append(
					        $('<option></option>').val(0).html('Seleccionar')
					    );

						$.each(ciclos, function(key, value) {
							$('#cboCiclo').append(
						        $('<option></option>').val(value.ciclolectivo_id).html(value.ciclo)
						    );
						});

					}).error(function(data) {
						console.log(data);
					});

				}).error(function(data) {
					console.log(data);
				});

			}).error(function(data) {
				console.log(data);
			});
		}).error(function(data) {
			console.log(data);
		});
	}

    $('#cboFiltroAlumno').change(function() {
    	$('#txtalumno').val('');
    	$('#txtalumno').focus();
    });

	$('#btnAgregar').live('click', function() {
    	//Generar_Inscripcion();
        $('#check_cuota_importe').prop("checked", false);
    	var cboMesPagoCuotaInicio = parseInt($('#cboMesPagoCuotaInicio').val());
    	$('#cboMesPagoCuotaInicio').find('option[value="'+cboMesPagoCuotaInicio+'"]').remove();
    	var txt_importe = $('#txt_importe').val();
    	var txt_total = parseInt($('#txt_total').val());
    	var txtdescuento = $('#txtdescuento').val();
    	var txtrecargo = $('#txtrecargo').val();
		var fecha       = new Date();
		var dia_actual  = fecha.getDate();
		var mes_actual  = fecha.getMonth() + 1;
		var anio_actual = fecha.getFullYear();
		var fecha_actual = dia_actual + '/' + mes_actual + '/' + anio_actual;

		var meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        var mespago = cboMesPagoCuotaInicio - 1;
        var mes = meses[mespago];
        
    	if (cboMesPagoCuotaInicio) {
	        var txt_total_apagar = parseInt($('#txt_total_apagar').val());
	        var totaldetotal = txt_total + txt_total_apagar;

	        txt_total = txt_total.toFixed(2);
	        totaldetotal = totaldetotal.toFixed(2);

	        $('#txt_total_pagar').val(totaldetotal);
	        $('#txt_total_apagar').val('');
	        $('#txt_total_apagar').val(totaldetotal);

	    	$('#txt_descuento').val('');
	    	$('#txt_recargo').val('');
	    	$('#txt_total').val(txt_importe);
	    	$('#txt_total1').val(txt_importe);

	    	if (txtdescuento == 0) txtdescuento = '';
	    	if (txtrecargo == 0) txtrecargo = '';

	    	var tabla = '<tr>';
			tabla += '<td style="display: none;"><center><input type="hidden" name="mesescargados[]" value="'+cboMesPagoCuotaInicio+'">' + cboMesPagoCuotaInicio + '</center></td>';
			tabla += '<td><center>' + fecha_actual + '</center></td>';
			tabla += '<td><center>' + mes + '</center></td>';
			tabla += '<td><center><input type="hidden" name="txtdescuentos[]" id="'+txtdescuento+'" value="'+txtdescuento+'">' + txtdescuento + '</center></td>';
			tabla += '<td><center><input type="hidden" name="txtrecargos[]" id="'+txtrecargo+'" value="'+txtrecargo+'">' + txtrecargo + '</center></td>';
			tabla += '<td><center>' + txt_importe + '</center></td>';
			tabla += '<td style="display: none;" class="numero">' + txt_total + '</td>';
			tabla += '<td><center><input type="hidden" name="txt_totals[]" id="'+txt_total+'" value="'+txt_total+'">' + txt_total + '</center></td>';
			tabla += '<td><center><a href="#" id="quitar" class="quitar" value="'+txt_total+'"><i class="fa fa-trash-o"></i> Quitar</a></center></td>';
			tabla += '</tr>';

	    	$('#tableMatriculaCuotas > tbody').append(tabla);
	    }

        $('#check_cuota_importe').prop("checked", false);
        $('#txtrecargo').val('');
        $('#txtdescuento').val('');
    });

	$(document).on('click', '.quitar', function (event) {
		var valores = "";

        $(this).parents("tr").find(".numero").each(function() {
          valores += $(this).html() + "\n";
        });

        console.log(valores);

        var total_arestar = valores;
        var txt_total_apagar = parseInt($('#txt_total_apagar').val());
        var totaldetotal = txt_total_apagar - total_arestar;

        $('#txt_total_pagar').val(totaldetotal);
        $('#txt_total_apagar').val('');
        $('#txt_total_apagar').val(totaldetotal);

	    event.preventDefault();
	    $(this).closest('tr').remove();
	});

    function limpiar_tabla_matriculas() {
	    var n = 0;
		$('#tableMatriculaCuotas tr').each(function() {
		   if (n > 0) $(this).remove();
		   n++;
		});
    }

	function habilitar_campos_cuota() {
        //$('#txt_importe1').prop("readonly",false);
        //$('#cboMesPagoCuotaInicio').removeAttr("disabled");
        //$('#cboMesPagoCuotaInicio').val(1);
        $('#txt_descuento').prop("readonly",false);
        $('#txt_recargo').prop("readonly",false);
        //$('#txt_total1').prop("readonly",false);
        //$('#txt_importe1').focus();
        $('#btnAgregar').removeAttr("disabled");
	    $('#txt_efectivo').removeAttr("disabled");
		$('#txt_tarjeta').removeAttr("disabled");
	    $('#txt_debito').removeAttr("disabled");
		$('#txt_bancaria').removeAttr("disabled");
	    $('#txt_cheque').removeAttr("disabled");
		$('#observaciones').removeAttr("disabled");
    }

	function deshabilitar_campos_cuota() {
        $('#check_cuota_importe').prop('checked', false);
        $("#check_cuota_importe").parent().removeClass("checked");
	    $('#txt_importe').val('');
	    $('#txt_importe1').val('');
        $('#txt_importe1').prop("readonly",true);
        $('#txt_descuento').prop("readonly",true);
        $('#txt_recargo').prop("readonly",true);
        $('#txt_total1').prop("readonly",true);
        $('#cboMesPagoCuotaInicio').attr('disabled', 'disabled');
        $('#cboMesPagoCuotaInicio').val(0);
        $('#btnAgregar').attr('disabled', 'disabled');
	    $('#txt_efectivo').attr('disabled', 'disabled');
		$('#txt_tarjeta').attr('disabled', 'disabled');
	    $('#txt_debito').attr('disabled', 'disabled');
		$('#txt_bancaria').attr('disabled', 'disabled');
	    $('#txt_cheque').attr('disabled', 'disabled');
		$('#observaciones').attr('disabled', 'disabled');
    }

    $('#cboCiclo').change(function() {
        $('#cboCarrera').children().remove().end();
        deshabilitar_campos_cuota();
		//limpiar_tabla();
        if ($('#cboCiclo').val() == 0) return;

		$('#check_cuota_importe').prop( "checked", false );

		$.ajax({
		  url: '{{url('cuotas/obtenercarrerasporciclo')}}',
		  data:{'ciclo': $('#cboCiclo').val(), 'alumno_id': $('#txt_alumno_id').val()},
		  type: 'POST'
		}).done(function(carreras) {
			console.log(carreras);

			/*if (carreras == <?php echo CuotasController::NO_EXISTE_INSCRIPCION  ?>) {
				alert('El Alumno no posee matricula abonada!');
				$('#cboCiclo').removeAttr("disabled");
				return;
			}*/

	    	if (carreras == 'mensaje') {
	    		//alert(carreras);
	    		$('#divMensaje').html('<p class="form-control-static"><h4>' + carreras + '</h4></p>');
	    		$('#MensajeCantidad').modal('show');
	    		$('#cboCiclo').removeAttr("disabled");
	    	    return;
	    	}

			$('#cboCarrera').append(
		        $('<option></option>').val(0).html('Seleccionar')
		    );

			$.each(carreras, function(key, value) {
				$('#cboCarrera').append(
			        $('<option></option>').val(value.carrera_id).html(value.carrera)
			    );

			    //$('#cboCiclo').attr('disabled', 'disabled');
			});
		}).error(function(data) {
			console.log(data);
		});
    });

    $('#cboCarrera').change(function() {
    	var carrera = $('#cboCarrera').val();
    	var alumno_id = $('#txt_alumno_id').val();
    	$('#txt_inscripcion_id').val();

    	if (carrera == 0) {
    		$('#check_cuota_importe').prop("readonly",true);
    	} else {
			$('#check_cuota_importe').removeAttr("disabled");
        	$('#check_cuota_importe').prop("readonly",false);

        	$.ajax({
			  url: '{{url('cuotas/obtenerinscripcionescarreras')}}',
			  data:{'alumno_id': alumno_id, 'carrera': carrera},
			  type: 'POST'
			}).done(function(carreras) {
				console.log(carreras);

				$('#txt_inscripcion_id').val(carreras);

			}).error(function(data) {
				console.log(data);
			});
        }
    });

    // HABILITA CAMPOS PAGOS CUOTAS
	$('#check_cuota_importe').click(function() {
    	var carrera = $('#cboCarrera').val();
    	var ciclo = $('#cboCiclo').val();
    	var alumno_id = $('#txt_alumno_id').val();
	    //$('#check_cuota_importe').attr('disabled', 'disabled');

    	if (carrera == 0 || ciclo == 0) {
    		//alert('Debe seleccionar la Carrera y ciclo para continuar');
    		$('#divMensaje').html('<p class="form-control-static"><h4>' + 'Debe seleccionar la Carrera y ciclo para continuar' + '</h4></p>');
    		$('#MensajeCantidad').modal('show');
    	    return;
    	}

	    if ($('#check_cuota_importe').is(':checked')) {
	        habilitar_campos_cuota();
	        $.ajax({
			  url: '{{url('cuotas/obtenercuotas')}}',
			  data:{'ciclo': ciclo, 'carrera': carrera, 'alumno_id': alumno_id},
			  type: 'POST'
			}).done(function(cuotafin) {
				console.log(cuotafin);

			    	if (cuotafin == 'mensaje') {
			    		//alert('El alumno ya tiene todas las cuotas abonadas en este ciclo!');
			    		$('#divMensaje').html('<p class="form-control-static"><h4>' + 'El alumno ya tiene todas las cuotas abonadas en este ciclo!' + '</h4></p>');
    					$('#MensajeCantidad').modal('show');
			    		$('#cboCiclo').removeAttr("disabled");
			    	    return;
			    	}

		 			$('#txt_importe').val(cuotafin.cuotaimporte);
		 			$('#txt_importe1').val(cuotafin.cuotaimporte);
		 			$('#cboMesPagoCuotaInicio').val(cuotafin.mespagocuotainicio + 1);
		 			$('#txt_total').val(cuotafin.cuotaimporte);
		 			$('#txt_total1').val(cuotafin.cuotaimporte);
		 			$('#txt_matricula_id').val(cuotafin.id);

		 			$('#cboMesPagoCuotaInicio').children().remove().end();

		 			$.each(cuotafin.cuotasmeses, function(key, value) {
						$('#cboMesPagoCuotaInicio').append(
					        $('<option></option>').val(value.id).html(value.mes)
					    );
					});

			}).error(function(data) {
				console.log(data);
			});

			$('#check_cuota_importe').attr("disabled", true);
	    } else {
	        deshabilitar_campos_cuota();
	    }
	});


@stop

@section('includejs') 
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{url('assets/global/plugins/select2/select2.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/global/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js')}}"></script>
<script type="text/javascript" src="{{url('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js')}}"></script>
<script src="{{url('assets/admin/pages/scripts/components-form-tools.js')}}"></script>
<script src="{{url('assets/admin/pages/scripts/getFechaImpresion.js')}}"></script>
<script src="{{url('assets/admin/pages/scripts/primerFechaMayor.js')}}"></script>
<script src="{{url('assets/admin/layout/scripts/menusticky.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
@stop
