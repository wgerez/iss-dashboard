@extends('layouts.master')

@section('customstyle')
<!-- BEGIN PAGE LEVEL STYLES -->
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

$iniciocaja = (trim(Input::old('iniciocaja') == false)) ? $aperturacaja->iniciocaja : Input::old('iniciocaja');
$totalgeneral = (trim(Input::old('totalgeneral') == false)) ? $aperturacaja->totalgeneral : Input::old('totalgeneral');
$monedas = (trim(Input::old('monedas') == false)) ? $aperturacaja->monedas : Input::old('monedas');
$fechaapertura = (trim(Input::old('fechaapertura') == false)) ? $aperturacaja->fechaapertura : Input::old('fechaapertura');
$cantidad500 = (trim(Input::old('cantidad500') == false)) ? $aperturacaja->cantidad500 : Input::old('cantidad500');
$cantidad200 = (trim(Input::old('cantidad200') == false)) ? $aperturacaja->cantidad200 : Input::old('cantidad200');
$cantidad100 = (trim(Input::old('cantidad100') == false)) ? $aperturacaja->cantidad100 : Input::old('cantidad100');
$cantidad50 = (trim(Input::old('cantidad50') == false)) ? $aperturacaja->cantidad50 : Input::old('cantidad50');
$cantidad20 = (trim(Input::old('cantidad20') == false)) ? $aperturacaja->cantidad20 : Input::old('cantidad20');
$cantidad10 = (trim(Input::old('cantidad10') == false)) ? $aperturacaja->cantidad10 : Input::old('cantidad10');
$cantidad5 = (trim(Input::old('cantidad5') == false)) ? $aperturacaja->cantidad5 : Input::old('cantidad5');
$cantidad2 = (trim(Input::old('cantidad2') == false)) ? $aperturacaja->cantidad2 : Input::old('cantidad2');
$total500 = (trim(Input::old('total500s') == false)) ? $aperturacaja->total500 : Input::old('total500s');
$total200 = (trim(Input::old('total200s') == false)) ? $aperturacaja->total200 : Input::old('total200s');
$total100 = (trim(Input::old('total100s') == false)) ? $aperturacaja->total100 : Input::old('total100s');
$total50 = (trim(Input::old('total50s') == false)) ? $aperturacaja->total50 : Input::old('total50s');
$total20 = (trim(Input::old('total20s') == false)) ? $aperturacaja->total20 : Input::old('total20s');
$total10 = (trim(Input::old('total10s') == false)) ? $aperturacaja->total10 : Input::old('total10s');
$total5 = (trim(Input::old('total5s') == false)) ? $aperturacaja->total5 : Input::old('total5s');
$total2 = (trim(Input::old('total2s') == false)) ? $aperturacaja->total2 : Input::old('total2s');/*
$bancaria = (trim(Input::old('bancaria') == false)) ? $cajachica->cuentabancaria : Input::old('bancaria');
$cheque = (trim(Input::old('cheque') == false)) ? $cajachica->cheque : Input::old('cheque');
*/
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
					Contable <small>Apertura de Caja</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('aperturacaja/crear')}}">Nuevo</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<!--li>
							<a href="#">Editar</a>
						</li-->
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
					    @if (Session::get('message_type') == AperturaCajaController::OPERACION_EXITOSA)

					        <div class="note note-success">
								<p>{{ Session::get('message') }}</p>
							</div>

						@elseif (Session::get('message_type') == AperturaCajaController::OPERACION_FALLIDA)

					        <div class="note note-danger">
								<p>{{ Session::get('message') }}</p>
							</div>

						@elseif (Session::get('message_type') == AperturaCajaController::OPERACION_CANCELADA)

					        <div class="note note-warning">
								<p>{{ Session::get('message') }}</p>
							</div>

						@elseif (Session::get('message_type') == AperturaCajaController::OPERACION_INFO)

					        <div class="note note-info">
								<p>{{ Session::get('message') }}</p>
							</div>

						@endif
					@endif

					<?php
					if ($bandera == true) {
						echo '<div class="note note-danger">
								<p><strong>YA TIENE UNA APERTURA DE CAJA INICIADA!</strong></p>
							</div>';
					}
					?>
					<!-- COMIENZO DE LA TABLA-->
					{{ Form::open(array('url'=>'aperturacaja/update', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmAperturaCaja', 'name'=>'FrmAperturaCaja'))}}
					
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-files-o"></i> Apertura de Caja
							</div>
							<div class="actions">
								<button type='submit' class="btn default green-stripe" {{ $disabled }} disabled>
								<i class="fa fa-save"></i>
								<span class="hidden-480">
								Guardar </span>
								</button>
								<!--a href="{{url('cajachica/crear')}}" {{ $disabled }} class="btn default blue-stripe">
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Nuevo </span>
								</a-->
								<a href="{{url('aperturacaja/crear')}}" class="btn default red-stripe"  <?php if ($bandera == true) echo "disabled"; ?>>
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Nuevo </span>
								</a>
								<a target="_blank" href="#" id="imprimir" class="btn default yellow-stripe" <?php if ($habilitar == true) echo "disabled"; ?>>
								<i class="fa fa-print"></i>
								<span class="hidden-480">
								Imprimir </span>
								</a>
							</div>

						</div>
						<div class="portlet-body form">
								<div class="form-body">
								<input type="hidden" value="{{$aperturacaja->id}}" name="aperturacajaid" id="aperturacajaid">
								<div class="form-group @if ($errors->has('arqueo')) {{'has-error'}} @endif">
									<label class="col-md-2 control-label" for="arqueo">N° de Arqueo:</label>
									<div class="col-md-2 <?php if ($errors->has('arqueo')) echo 'has-error' ?>">
										<input type="text" class="form-control" id="arqueo" name="arqueo" value="{{ '000' . $aperturacaja->id }}" style="text-align: center" <?php if ($habilitar == false) echo "disabled"; ?>>
										@if ($errors->has('arqueo'))
										    <span class="help-block">{{ $errors->first('arqueo') }}</span>
									    @endif
									</div>
								</div>

								<div class="form-group <?php if ($errors->has('usuario')) echo 'has-error' ?> ">
									<label class="col-md-2 control-label" for="usuario">Usuario:</label>
									<div class="col-md-3 col-sm-10">
										<select class="table-group-action-input form-control" name="usuario" id="usuario" <?php if ($habilitar == false) echo "disabled"; ?>>
												<option value="{{ $iduser }}">{{ $usuarios->apellido }}, {{ $usuarios->nombre }}</option>
										</select>
										<input type="hidden" class="form-control" id="usuarioid" name="usuarioid" value="{{ $iduser }}">
										@if ($errors->has('usuario'))
										    <span class="help-block">{{ $errors->first('usuario') }}</span>
									    @endif
									</div>
								</div>

								<div class="form-group @if ($errors->has('iniciocaja')) {{'has-error'}} @endif">
									<label class="col-md-2 control-label" for="iniciocaja">Inicio de Caja: $</label>
									<div class="col-md-2 <?php if ($errors->has('iniciocaja')) echo 'has-error' ?>">
										<input type="text" class="form-control" id="iniciocaja" name="iniciocaja" value="{{ $iniciocaja }}" placeholder="" <?php if ($habilitar == false) echo "disabled"; ?>>
										<input type="hidden" class="form-control" id="iniciocajas" name="iniciocajas" value="{{ $iniciocaja }}">
										@if ($errors->has('iniciocaja'))
										    <span class="help-block">{{ $errors->first('iniciocaja') }}</span>
									    @endif
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 control-label <?php if ($errors->has('fechadesde')) echo 'text-danger' ?>">Fecha de Apertura:</label>
									<div id="divavisofechaing" class="col-md-3 <?php if ($errors->has('fechadesde')) echo 'has-error' ?>">
										<div class="input-icon right">
											<i class="fa fa-exclamation tooltips iconoerrorfechaing" style="display:none" data-original-title="Fecha Incorrecta." data-container="body"></i>
											<input type="date" class="form-control" name="fechadesde" id="fechadesde" placeholder="" value="{{ $fechaapertura }}" <?php if ($bandera == false) { echo "disabled"; } ?>>

											<!-- mostrar cuando exista error -->
									    	@if ($errors->has('fechadesde'))
										    	<span class="help-block">{{ $errors->first('fechadesde') }}</span>
									    	@endif
									    	<!--fin error-->
										</div>
									</div>
									<div class="col-md-2 col-sm-2">
										<a class="btn blue-madison" id='BtnBuscarApertura' <?php if ($bandera == false) { echo "disabled"; } ?>>
											<i class="fa fa-search"></i> Buscar Apertura de Caja
										</a>
									</div>
								</div>
							</div>
							<br>

							<div class="portlet-body">
								<div class="box-body table-responsive no-padding">
									<table class="table table-striped table-bordered table-hover" id="table_apertura">
										<thead>
										<tr>
											<th class="hidden-xs">
												<center><i class="glyphicon glyphicon-list"></i> Denominación</center>
											</th>
											<th class="col-md-2">
												<center><i class="glyphicon glyphicon-plus"></i> Cantidad</center>
											</th>
											<th>
												<center><i class="glyphicon glyphicon-usd"></i> Subtotal</center>
											</th>
										</tr>
										</thead>
										<tbody>
											<tr>
												<td>
													<center>
														<strong>Billete de $500</strong>
													</center>
												</td>
												<td>
													<center>
														<div class="col-md-8 <?php if ($errors->has('cantidad500')) echo 'has-error' ?>">
															<input type="number" class="form-control" id="cantidad500" name="cantidad500" value="{{ $cantidad500 }}" <?php if ($habilitar == false) echo "disabled"; ?> style="text-align: center">
															@if ($errors->has('cantidad500'))
															    <span class="help-block">{{ $errors->first('cantidad500') }}</span>
														    @endif
														</div>
													</center>
												</td>
												<td>
													<center>
														<strong><div class="col-md-4 col-sm-6" id='total500'>${{ $total500 }}</div></strong>
													</center>
												</td>
											</tr>
											<tr>
												<td>
													<center>
														<strong>Billete de $200</strong>
													</center>
												</td>
												<td>
													<center>
														<div class="col-md-8 <?php if ($errors->has('cantidad200')) echo 'has-error' ?>">
															<input type="number" class="form-control" id="cantidad200" name="cantidad200" value="{{ $cantidad200 }}" <?php if ($habilitar == false) echo "disabled"; ?> style="text-align: center">
															@if ($errors->has('cantidad200'))
															    <span class="help-block">{{ $errors->first('cantidad200') }}</span>
														    @endif
														</div>
													</center>
												</td>
												<td>
													<center>
														<strong><div class="col-md-4 col-sm-6" id='total200'>${{ $total200 }}</div></strong>
													</center>
												</td>
											</tr>
											<tr>
												<td>
													<center>
														<strong>Billete de $100<strong>
													</center>
												</td>
												<td>
													<center>
														<div class="col-md-8 <?php if ($errors->has('cantidad100')) echo 'has-error' ?>">
															<input type="number" class="form-control" id="cantidad100" name="cantidad100" value="{{ $cantidad100 }}" <?php if ($habilitar == false) echo "disabled"; ?> style="text-align: center">
															@if ($errors->has('cantidad100'))
															    <span class="help-block">{{ $errors->first('cantidad100') }}</span>
														    @endif
														</div>
													</center>
												</td>
												<td>
													<center>
														<strong><div class="col-md-4 col-sm-6" id='total100'>${{ $total100 }}</div></strong>
													</center>
												</td>
											</tr>
											<tr>
												<td>
													<center>
														<strong>Billete de $50</strong>
													</center>
												</td>
												<td>
													<center>
														<div class="col-md-8 <?php if ($errors->has('cantidad50')) echo 'has-error' ?>">
															<input type="number" class="form-control" id="cantidad50" name="cantidad50" value="{{ $cantidad50 }}" <?php if ($habilitar == false) echo "disabled"; ?> style="text-align: center">
															@if ($errors->has('cantidad50'))
															    <span class="help-block">{{ $errors->first('cantidad50') }}</span>
														    @endif
														</div>
													</center>
												</td>
												<td>
													<center>
														<strong><div class="col-md-4 col-sm-6" id='total50'>${{ $total50 }}</div></strong>
													</center>
												</td>
											</tr>
											<tr>
												<td>
													<center>
														<strong>Billete de $20</strong>
													</center>
												</td>
												<td>
													<center>
														<div class="col-md-8 <?php if ($errors->has('cantidad20')) echo 'has-error' ?>">
															<input type="number" class="form-control" id="cantidad20" name="cantidad20" value="{{ $cantidad20 }}" <?php if ($habilitar == false) echo "disabled"; ?> style="text-align: center">
															@if ($errors->has('cantidad20'))
															    <span class="help-block">{{ $errors->first('cantidad20') }}</span>
														    @endif
														</div>
													</center>
												</td>
												<td>
													<center>
														<strong><div class="col-md-4 col-sm-6" id='total20'>${{ $total20 }}</div></strong>
													</center>
												</td>
											</tr>
											<tr>
												<td>
													<center>
														<strong>Billete de $10</strong>
													</center>
												</td>
												<td>
													<center>
														<div class="col-md-8 <?php if ($errors->has('cantidad10')) echo 'has-error' ?>">
															<input type="number" class="form-control" id="cantidad10" name="cantidad10" value="{{ $cantidad10 }}" <?php if ($habilitar == false) echo "disabled"; ?> style="text-align: center">
															@if ($errors->has('cantidad10'))
															    <span class="help-block">{{ $errors->first('cantidad10') }}</span>
														    @endif
														</div>
													</center>
												</td>
												<td>
													<center>
														<strong><div class="col-md-4 col-sm-6" id='total10'>${{ $total10 }}</div></strong>
													</center>
												</td>
											</tr>
											<tr>
												<td>
													<center>
														<strong>Billete de $5</strong>
													</center>
												</td>
												<td>
													<center>
														<div class="col-md-8 <?php if ($errors->has('cantidad5')) echo 'has-error' ?>">
															<input type="number" class="form-control" id="cantidad5" name="cantidad5" value="{{ $cantidad5 }}" <?php if ($habilitar == false) echo "disabled"; ?> style="text-align: center">
															@if ($errors->has('cantidad5'))
															    <span class="help-block">{{ $errors->first('cantidad5') }}</span>
														    @endif
														</div>
													</center>
												</td>
												<td>
													<center>
														<strong><div class="col-md-4 col-sm-6" id='total5'>${{ $total5 }}</div></strong>
													</center>
												</td>
											</tr>
											<tr>
												<td>
													<center>
														<strong>Billete de $2</strong>
													</center>
												</td>
												<td>
													<center>
														<div class="col-md-8 <?php if ($errors->has('cantidad2')) echo 'has-error' ?>">
															<input type="number" class="form-control" id="cantidad2" name="cantidad2" value="{{ $cantidad2 }}" <?php if ($habilitar == false) echo "disabled"; ?> style="text-align: center">
															@if ($errors->has('cantidad2'))
															    <span class="help-block">{{ $errors->first('cantidad2') }}</span>
														    @endif
														</div>
													</center>
												</td>
												<td>
													<center>
														<strong><div class="col-md-4 col-sm-6" id='total2'>${{ $total2 }}</div></strong>
													</center>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>

							<div class="form-group @if ($errors->has('monedas')) {{'has-error'}} @endif">
								<label class="col-md-2 control-label" for="monedas">Monedas: $</label>
								<div class="col-md-4 <?php if ($errors->has('monedas')) echo 'has-error' ?>">
									<input type="number" class="form-control" id="monedas" name="monedas" value="{{ $monedas }}" <?php if ($habilitar == false) echo "disabled"; ?>>
									@if ($errors->has('monedas'))
									    <span class="help-block">{{ $errors->first('monedas') }}</span>
								    @endif
								</div>
								<div class="col-md-2 col-sm-2">
									<a class="btn blue-madison" id='BtnBuscar' <?php if ($habilitar == false) echo "disabled"; ?>>
										<i class="glyphicon glyphicon-tasks"></i> Calcular
									</a>
								</div>
							</div>

							<div class="form-group @if ($errors->has('totals')) {{'has-error'}} @endif">
								<label class="col-md-2 control-label" for="totals">Total: $</label>
								<div class="col-md-4 <?php if ($errors->has('totals')) echo 'has-error' ?>">
									<input type="text" class="form-control" id="totals" name="totals" value="{{ $totalgeneral }}" placeholder="" disabled>
									@if ($errors->has('totals'))
									    <span class="help-block">{{ $errors->first('totals') }}</span>
								    @endif
								</div>
							</div>

								<div class="col-md-2 <?php if ($errors->has('total500s')) echo 'has-error' ?>">
									<input type="hidden" class="form-control" id="total500s" name="total500s" value="{{ $total500 }}" placeholder="">
									@if ($errors->has('total500s'))
									    <span class="help-block">{{ $errors->first('total500s') }}</span>
								    @endif
								</div>

								<div class="col-md-2 <?php if ($errors->has('total200s')) echo 'has-error' ?>">
									<input type="hidden" class="form-control" id="total200s" name="total200s" value="{{ Input::old('total200s') }}" placeholder="">
									@if ($errors->has('total200s'))
									    <span class="help-block">{{ $errors->first('total200s') }}</span>
								    @endif
								</div>

								<div class="col-md-2 <?php if ($errors->has('total100s')) echo 'has-error' ?>">
									<input type="hidden" class="form-control" id="total100s" name="total100s" value="{{ Input::old('total100s') }}" placeholder="">
									@if ($errors->has('total100s'))
									    <span class="help-block">{{ $errors->first('total100s') }}</span>
								    @endif
								</div>

								<div class="col-md-2 <?php if ($errors->has('total50s')) echo 'has-error' ?>">
									<input type="hidden" class="form-control" id="total50s" name="total50s" value="{{ Input::old('total50s') }}" placeholder="">
									@if ($errors->has('total50s'))
									    <span class="help-block">{{ $errors->first('total50s') }}</span>
								    @endif
								</div>

								<div class="col-md-2 <?php if ($errors->has('total20s')) echo 'has-error' ?>">
									<input type="hidden" class="form-control" id="total20s" name="total20s" value="{{ Input::old('total20s') }}" placeholder="">
									@if ($errors->has('total20s'))
									    <span class="help-block">{{ $errors->first('total20s') }}</span>
								    @endif
								</div>

								<div class="col-md-2 <?php if ($errors->has('total10s')) echo 'has-error' ?>">
									<input type="hidden" class="form-control" id="total10s" name="total10s" value="{{ Input::old('total10s') }}" placeholder="">
									@if ($errors->has('total10s'))
									    <span class="help-block">{{ $errors->first('total10s') }}</span>
								    @endif
								</div>

								<div class="col-md-2 <?php if ($errors->has('total5s')) echo 'has-error' ?>">
									<input type="hidden" class="form-control" id="total5s" name="total5s" value="{{ Input::old('total5s') }}" placeholder="">
									@if ($errors->has('total5s'))
									    <span class="help-block">{{ $errors->first('total5s') }}</span>
								    @endif
								</div>

								<div class="col-md-2 <?php if ($errors->has('total2s')) echo 'has-error' ?>">
									<input type="hidden" class="form-control" id="total2s" name="total2s" value="{{ Input::old('total2s') }}" placeholder="">
									@if ($errors->has('total2s'))
									    <span class="help-block">{{ $errors->first('total2s') }}</span>
								    @endif
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
												El valor debe ser positivo!!
											</div>
											<div class="modal-footer">
												<button type="button" class="btn default" data-dismiss="modal">Cerrar</button>
											</div>
										</div>
									</div>
							</div>
							<!-- FIN MODAL-->

							<!-- MODAL-->
							<div class="modal fade" id="MensajeCantidad1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Atención!</h4>
										</div>
										<div class="modal-body">
											<div class="form-group">
												<div class="col-md-12 col-sm-12 control-label text-info" id='divMensaje1'></div><br><br>
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
					{{ Form::close() }}
				</div>
			</div>
			<!-- FIN DEL CONTENIDO -->
		</div>
	</div>
	<!-- FIN -->
@stop


@section('customjs')
//$("#imprimir").attr('disabled', 'disabled');

	//Emular Tab al presionar Enter
	$('input').keydown( function(e) {
	        var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
	        if(key == 13) {
	            e.preventDefault();
	            var inputs = $(this).closest('form').find(':input:visible');
	            inputs.eq( inputs.index(this)+ 1 ).focus();
	        }
	 });
	 
	$('#usuario').select2({
		placeholder: "Seleccione",
		allowClear: true
	});

	$('#cantidad500').live('keyup', function() {
		var cantidad500 = $('#cantidad500').val();

		if (cantidad500 < 0) {
			$('#cantidad500').val('');
		    $('#MensajeCantidad').modal('show');
		    return;
		}

		var total = 500 * cantidad500;

		$('#total500').html('<p class="form-control-static">' + total + '</p>');
		$('#total500s').val(total);
	});

	$('#cantidad200').live('keyup', function() {
		var cantidad200 = $('#cantidad200').val();

		if (cantidad200 < 0) {
			$('#cantidad200').val('');
		    $('#MensajeCantidad').modal('show');
		    return;
		}

		var total = 200 * cantidad200;

		$('#total200').html('<p class="form-control-static">' + total + '</p>');
		$('#total200s').val(total);
	});

	$('#cantidad100').live('keyup', function() {
		var cantidad100 = $('#cantidad100').val();

		if (cantidad100 < 0) {
			$('#cantidad100').val('');
		    $('#MensajeCantidad').modal('show');
		    return;
		}

		var total = 100 * cantidad100;

		$('#total100').html('<p class="form-control-static">' + total + '</p>');
		$('#total100s').val(total);
	});

	$('#cantidad50').live('keyup', function() {
		var cantidad50 = $('#cantidad50').val();

		if (cantidad50 < 0) {
			$('#cantidad50').val('');
		    $('#MensajeCantidad').modal('show');
		    return;
		}

		var total = 50 * cantidad50;

		$('#total50').html('<p class="form-control-static">' + total + '</p>');
		$('#total50s').val(total);
	});

	$('#cantidad20').live('keyup', function() {
		var cantidad20 = $('#cantidad20').val();

		if (cantidad20 < 0) {
			$('#cantidad20').val('');
		    $('#MensajeCantidad').modal('show');
		    return;
		}

		var total = 20 * cantidad20;

		$('#total20').html('<p class="form-control-static">' + total + '</p>');
		$('#total20s').val(total);
	});

	$('#cantidad10').live('keyup', function() {
		var cantidad10 = $('#cantidad10').val();

		if (cantidad10 < 0) {
			$('#cantidad10').val('');
		    $('#MensajeCantidad').modal('show');
		    return;
		}

		var total = 10 * cantidad10;

		$('#total10').html('<p class="form-control-static">' + total + '</p>');
		$('#total10s').val(total);
	});

	$('#cantidad5').live('keyup', function() {
		var cantidad5 = $('#cantidad5').val();

		if (cantidad5 < 0) {
			$('#cantidad5').val('');
		    $('#MensajeCantidad').modal('show');
		    return;
		}

		var total = 5 * cantidad5;

		$('#total5').html('<p class="form-control-static">' + total + '</p>');
		$('#total5s').val(total);
	});

	$('#cantidad2').live('keyup', function() {
		var cantidad2 = $('#cantidad2').val();

		if (cantidad2 < 0) {
			$('#cantidad2').val('');
		    $('#MensajeCantidad').modal('show');
		    return;
		}

		var total = 2 * cantidad2;

		$('#total2').html('<p class="form-control-static">' + total + '</p>');
		$('#total2s').val(total);
	});

	$('#BtnBuscar').live('click', function() {
	    var total500 = parseInt($('#total500s').val());
	    var total200 = parseInt($('#total200s').val());
	    var total100 = parseInt($('#total100s').val());
	    var total50 = parseInt($('#total50s').val());
	    var total20 = parseInt($('#total20s').val());
	    var total10 = parseInt($('#total10s').val());
	    var total5 = parseInt($('#total5s').val());
	    var total2 = parseInt($('#total2s').val());
	    var monedas = parseInt($('#monedas').val());

	    if (total500 == '' || isNaN(total500)) total500 = 0;
	    if (total200 == '' || isNaN(total200)) total200 = 0;
	    if (total100 == '' || isNaN(total100)) total100 = 0;
	    if (total50 == '' || isNaN(total50)) total50 = 0;
	    if (total20 == '' || isNaN(total20)) total20 = 0;
	    if (total10 == '' || isNaN(total10)) total10 = 0;
	    if (total5 == '' || isNaN(total5)) total5 = 0;
	    if (total2 == '' || isNaN(total2)) total2 = 0;
	    if (monedas == '' || isNaN(monedas)) monedas = 0;

	    var totalcalculado = total500 + total200 + total100 + total50 + total20 + total10 + total5 + total2 + monedas;

	    $('#totals').val('');
	    $('#totals').val(totalcalculado);
	    $('#iniciocaja').val(totalcalculado);
	    $('#iniciocajas').val(totalcalculado);
	    $("#imprimir").removeAttr("disabled");
    });

	$('#BtnBuscarApertura').live('click', function() {
		var fechadesde = $('#fechadesde').val();
		
		$.ajax({
		  url: '{{url('aperturacaja/obteneraperturacaja')}}',
		  data:{'fechadesde': fechadesde},
		  type: 'POST'
		}).done(function(apertura) {
			console.log(apertura);
				if (apertura == '1') {
					$('#divMensaje1').html('<p class="form-control-static"><h4>' + 'No se ha encontrado ningún registro' + '</h4></p>');
		    		$('#MensajeCantidad1').modal('show');
				}

				$.each(apertura, function(key, value) {
					$('#usuario').removeAttr("disabled");
	    			$('#usuario').children().remove().end();
	    			$('#usuario').append(
				        $('<option></option>').val(value.user_id).html(value.apeynom)
				    );
	    			$('#arqueo').val('000'+value.id);
	    			$('#aperturacajaid').val(value.id);
					$('#iniciocaja').val(value.iniciocaja);
	    			$('#iniciocajas').val(value.iniciocaja);
	    			$('#totals').val(value.totalgeneral);
	    			$('#monedas').val(value.monedas);
	    			$('#monedas').attr('disabled', 'disabled');
	    			$('#cantidad500').val(value.cantidad500);
	    			$('#cantidad500').attr('disabled', 'disabled');
	    			$('#total500').html('<p class="form-control-static">$' + value.total500 + '</p>');
					$('#total500s').val(value.total500);
	    			$('#cantidad200').val(value.cantidad200);
	    			$('#cantidad200').attr('disabled', 'disabled');
	    			$('#total200').html('<p class="form-control-static">$' + value.total200 + '</p>');
					$('#total200s').val(value.total200);
	    			$('#cantidad100').val(value.cantidad100);
	    			$('#cantidad100').attr('disabled', 'disabled');
	    			$('#total100').html('<p class="form-control-static">$' + value.total100 + '</p>');
					$('#total100s').val(value.total100);
	    			$('#cantidad50').val(value.cantidad50);
	    			$('#cantidad50').attr('disabled', 'disabled');
	    			$('#total50').html('<p class="form-control-static">$' + value.total50 + '</p>');
					$('#total50s').val(value.total50);
	    			$('#cantidad20').val(value.cantidad20);
	    			$('#cantidad20').attr('disabled', 'disabled');
	    			$('#total20').html('<p class="form-control-static">$' + value.total20 + '</p>');
					$('#total20s').val(value.total20);
	    			$('#cantidad10').val(value.cantidad10);
	    			$('#cantidad10').attr('disabled', 'disabled');
	    			$('#total10').html('<p class="form-control-static">$' + value.total10 + '</p>');
					$('#total10s').val(value.total10);
	    			$('#cantidad5').val(value.cantidad5);
	    			$('#cantidad5').attr('disabled', 'disabled');
	    			$('#total5').html('<p class="form-control-static">$' + value.total5 + '</p>');
					$('#total5s').val(value.total5);
	    			$('#cantidad2').val(value.cantidad2);
	    			$('#cantidad2').attr('disabled', 'disabled');
	    			$('#total2').html('<p class="form-control-static">$' + value.total2 + '</p>');
					$('#total2s').val(value.total2);
					$('#BtnBuscar').attr('disabled', 'disabled');
					$('#imprimir').removeAttr("disabled");
				});
		}).error(function(data) {
			console.log(data);
		});
	});

	$('#imprimir').on('click', function(e){
		e.preventDefault();
		window.open("{{url('aperturacaja/pdfimprimirapertura')}}?aperturacajaid=" + $('#aperturacajaid').val());
	});

@stop

@section('includejs') 
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{url('assets/global/plugins/select2/select2.min.js')}}"></script>
<script src="{{url('assets/admin/layout/scripts/menusticky.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
@stop
