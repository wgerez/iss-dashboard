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

$iniciocaja = (trim(Input::old('iniciocaja') == false)) ? $apertura->iniciocaja : Input::old('iniciocaja');
$fechaapertura = (trim(Input::old('fechaapertura') == false)) ? $apertura->fechaapertura : Input::old('fechaapertura');
$totalgeneral = (trim(Input::old('totalgeneral') == false)) ? $cierrecaja->totalgeneral : Input::old('totalgeneral');
$monedas = (trim(Input::old('monedas') == false)) ? $cierrecaja->monedas : Input::old('monedas');
$fechacierre = (trim(Input::old('fechacierre') == false)) ? $cierrecaja->fechacierre : Input::old('fechacierre');
$cantidad500 = (trim(Input::old('cantidad500') == false)) ? $cierrecaja->cantidad500 : Input::old('cantidad500');
$cantidad200 = (trim(Input::old('cantidad200') == false)) ? $cierrecaja->cantidad200 : Input::old('cantidad200');
$cantidad100 = (trim(Input::old('cantidad100') == false)) ? $cierrecaja->cantidad100 : Input::old('cantidad100');
$cantidad50 = (trim(Input::old('cantidad50') == false)) ? $cierrecaja->cantidad50 : Input::old('cantidad50');
$cantidad20 = (trim(Input::old('cantidad20') == false)) ? $cierrecaja->cantidad20 : Input::old('cantidad20');
$cantidad10 = (trim(Input::old('cantidad10') == false)) ? $cierrecaja->cantidad10 : Input::old('cantidad10');
$cantidad5 = (trim(Input::old('cantidad5') == false)) ? $cierrecaja->cantidad5 : Input::old('cantidad5');
$cantidad2 = (trim(Input::old('cantidad2') == false)) ? $cierrecaja->cantidad2 : Input::old('cantidad2');
$total500 = (trim(Input::old('total500s') == false)) ? $cierrecaja->total500 : Input::old('total500s');
$total200 = (trim(Input::old('total200s') == false)) ? $cierrecaja->total200 : Input::old('total200s');
$total100 = (trim(Input::old('total100s') == false)) ? $cierrecaja->total100 : Input::old('total100s');
$total50 = (trim(Input::old('total50s') == false)) ? $cierrecaja->total50 : Input::old('total50s');
$total20 = (trim(Input::old('total20s') == false)) ? $cierrecaja->total20 : Input::old('total20s');
$total10 = (trim(Input::old('total10s') == false)) ? $cierrecaja->total10 : Input::old('total10s');
$total5 = (trim(Input::old('total5s') == false)) ? $cierrecaja->total5 : Input::old('total5s');
$total2 = (trim(Input::old('total2s') == false)) ? $cierrecaja->total2 : Input::old('total2s');
$totalsistema = (trim(Input::old('totalefectivosis') == false)) ? $totalsistema : Input::old('totalefectivosis');
$totalarqueo = (trim(Input::old('totalarqueo') == false)) ? $totalsistema : Input::old('totalarqueo');
$ingresoegreso = (trim(Input::old('gastosegresos') == false)) ? $ingresoegreso : Input::old('gastosegresos');

$totalefectivo = (trim(Input::old('totalefectivo') == false)) ? $totalefectivo : Input::old('totalefectivo');
$totaltarjeta = (trim(Input::old('totalcredito') == false)) ? $totaltarjeta : Input::old('totalcredito');
$totaldebito = (trim(Input::old('totaldebito') == false)) ? $totaldebito : Input::old('totaldebito');
$totalbancaria = (trim(Input::old('totalbancaria') == false)) ? $totalbancaria : Input::old('totalbancaria');
$totalcheque = (trim(Input::old('totalcheque') == false)) ? $totalcheque : Input::old('totalcheque');
$totalgeneralf = (trim(Input::old('totalgeneralf') == false)) ? $totalgeneralf : Input::old('totalgeneralf');

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
					Contable <small>Cierre de Caja</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('cierrecaja/crear')}}">Nuevo</a>
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
					    @if (Session::get('message_type') == CierreCajaController::OPERACION_EXITOSA)

					        <div class="note note-success">
								<p>{{ Session::get('message') }}</p>
							</div>

						@elseif (Session::get('message_type') == CierreCajaController::OPERACION_FALLIDA)

					        <div class="note note-danger">
								<p>{{ Session::get('message') }}</p>
							</div>

						@elseif (Session::get('message_type') == CierreCajaController::OPERACION_CANCELADA)

					        <div class="note note-warning">
								<p>{{ Session::get('message') }}</p>
							</div>

						@elseif (Session::get('message_type') == CierreCajaController::OPERACION_INFO)

					        <div class="note note-info">
								<p>{{ Session::get('message') }}</p>
							</div>

						@endif
					@endif

					<?php
					if ($cierreecho == true) {
						echo '<div class="note note-danger">
								<p><strong>CIERRE DE CAJA REALIZADO!</strong></p>
							</div>';
					}
					?>
					<!-- COMIENZO DE LA TABLA-->
					{{ Form::open(array('url'=>'cierrecaja/update', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmCierreCaja', 'name'=>'FrmCierreCaja'))}}
					
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-files-o"></i> Cierre de Caja
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
								<a href="{{url('cierrecaja/crear')}}" class="btn default red-stripe" disabled>
								<i class="fa fa-refresh"></i>
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
								<input type="hidden" value="{{$cierrecaja->id}}" name="cierrecajaid" id="cierrecajaid">
								<div class="form-group @if ($errors->has('arqueo')) {{'has-error'}} @endif">
									<label class="col-md-2 control-label" for="arqueo">N° de Arqueo:</label>
									<div class="col-md-2 <?php if ($errors->has('arqueo')) echo 'has-error' ?>">
										<input type="text" class="form-control" id="arqueo" name="arqueo" value="{{ '000' . $cierrecaja->id }}" style="text-align: center" <?php if ($habilitar == false) echo "disabled"; ?>>
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

								<div class="form-group">
									<label class="col-md-2 control-label <?php if ($errors->has('fechadesde')) echo 'text-danger' ?>">Fecha de Cierre:</label>
									<div id="divavisofechaing" class="col-md-3 <?php if ($errors->has('fechadesde')) echo 'has-error' ?>">
										<div class="input-icon right">
											<i class="fa fa-exclamation tooltips iconoerrorfechaing" style="display:none" data-original-title="Fecha Incorrecta." data-container="body"></i>
											<input type="date" class="form-control" name="fechadesde" id="fechadesde" placeholder="" value="{{ $fechacierre }}" <?php if ($habilitar == false) echo "disabled"; ?>>

											<!-- mostrar cuando exista error -->
									    	@if ($errors->has('fechadesde'))
										    	<span class="help-block">{{ $errors->first('fechadesde') }}</span>
									    	@endif
									    	<!--fin error-->
										</div>
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
														<strong><div class="col-md-4 col-sm-6" id='total500'>{{ $total500 }}</div></strong>
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
														<strong><div class="col-md-4 col-sm-6" id='total200'>{{ $total200 }}</div></strong>
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
														<strong><div class="col-md-4 col-sm-6" id='total100'>{{ $total100 }}</div></strong>
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
														<strong><div class="col-md-4 col-sm-6" id='total50'>{{ $total50 }}</div></strong>
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
														<strong><div class="col-md-4 col-sm-6" id='total20'>{{ $total20 }}</div></strong>
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
														<strong><div class="col-md-4 col-sm-6" id='total10'>{{ $total10 }}</div></strong>
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
														<strong><div class="col-md-4 col-sm-6" id='total5'>{{ $total5 }}</div></strong>
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
														<strong><div class="col-md-4 col-sm-6" id='total2'>{{ $total2 }}</div></strong>
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
								<label class="col-md-2 control-label" for="totals">Total:</label>
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

								<br>
								<div class="form-group">
									<div class="box-footer">
						            	<div class="panel panel-default">
											<div class="panel-heading">
																
												<div class="form-group">
													<label class="col-md-2 control-label <?php if ($errors->has('fechaapertura')) echo 'text-danger' ?>">Fecha de Apertura:</label>
													<div id="divavisofechaing" class="col-md-3 <?php if ($errors->has('fechaapertura')) echo 'has-error' ?>">
														<div class="input-icon right">
															<i class="fa fa-exclamation tooltips iconoerrorfechaing" style="display:none" data-original-title="Fecha Incorrecta." data-container="body"></i>
															<input type="date" class="form-control" name="fechaapertura" id="fechaapertura" placeholder="" value="{{$fechaapertura}}" disabled>
															<!-- mostrar cuando exista error -->
													    	@if ($errors->has('fechaapertura'))
														    	<span class="help-block">{{ $errors->first('fechaapertura') }}</span>
													    	@endif
													    	<!--fin error-->
														</div>
													</div>
												</div>
				
												<div class="form-group">
													<label class="col-md-2 control-label <?php if ($errors->has('fechacierre')) echo 'text-danger' ?>">Fecha de Cierre:</label>
													<div id="divavisofechaing" class="col-md-3 <?php if ($errors->has('fechacierre')) echo 'has-error' ?>">
														<div class="input-icon right">
															<i class="fa fa-exclamation tooltips iconoerrorfechaing" style="display:none" data-original-title="Fecha Incorrecta." data-container="body"></i>
															<input type="date" class="form-control" name="fechacierre" id="fechacierre" placeholder="" value="{{$fechacierre}}" disabled>
															<!-- mostrar cuando exista error -->
													    	@if ($errors->has('fechacierre'))
														    	<span class="help-block">{{ $errors->first('fechacierre') }}</span>
													    	@endif
													    	<!--fin error-->
														</div>
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

												<div class="form-group @if ($errors->has('totalcierre')) {{'has-error'}} @endif">
													<label class="col-md-2 control-label" for="totalcierre">Total al Cierre Caja: $</label>
													<div class="col-md-2 <?php if ($errors->has('totalcierre')) echo 'has-error' ?>">
														<input type="text" class="form-control" id="totalcierre" name="totalcierre" value="{{ $totalgeneral }}" placeholder="" disabled>
														@if ($errors->has('totalcierre'))
														    <span class="help-block">{{ $errors->first('totalcierre') }}</span>
													    @endif
													</div>
												</div>

												<div class="form-group @if ($errors->has('gastosegresos')) {{'has-error'}} @endif">
													<label class="col-md-2 control-label" for="gastosegresos">Gastos/Egresos: $</label>
													<div class="col-md-2 <?php if ($errors->has('gastosegresos')) echo 'has-error' ?>">
														<input type="text" class="form-control" id="gastosegresos" name="gastosegresos" value="{{ $egreso }}" placeholder="" disabled>
														@if ($errors->has('gastosegresos'))
														    <span class="help-block">{{ $errors->first('gastosegresos') }}</span>
													    @endif
													</div>
												</div>

												<div class="form-group @if ($errors->has('totalefectivosis')) {{'has-error'}} @endif">
													<label class="col-md-2 control-label" for="totalefectivosis">Total Efectivo en Sistema: $</label>
													<div class="col-md-2 <?php if ($errors->has('totalefectivosis')) echo 'has-error' ?>">
														<input type="text" class="form-control" id="totalefectivosis" name="totalefectivosis" value="{{ $totalsistema }}" placeholder="" disabled>
														@if ($errors->has('totalefectivosis'))
														    <span class="help-block">{{ $errors->first('totalefectivosis') }}</span>
													    @endif
													</div>
												</div>

												<div class="form-group @if ($errors->has('totalarqueo')) {{'has-error'}} @endif">
													<label class="col-md-2 control-label" for="totalarqueo">Total Arqueo: $</label>
													<div class="col-md-2 <?php if ($errors->has('totalarqueo')) echo 'has-error' ?>">
														<input type="text" class="form-control" id="totalarqueo" name="totalarqueo" value="{{ $totalarqueo }}" placeholder="" disabled>
														@if ($errors->has('totalarqueo'))
														    <span class="help-block">{{ $errors->first('totalarqueo') }}</span>
													    @endif
													</div>
												</div>

											</div>
											<div class="panel-heading">
												<center><strong> Detalles de Forma de Pago</strong></center>
											</div>
												<!-- /.panel-heading -->
											<div class="panel-body">
												<div id= "tableta" class="table-responsive">
													<table id="tablearticulos" class="table table-striped table-bordered table-hover">
													    <thead>
													        <tr>
													            <th><center>Medio de Pago</center></th>
													            <th><center><i class="glyphicon glyphicon-usd"></i>Subtotal</center></th>
													        </tr>
													    </thead>
													    <tbody>
															<tr>
																<td>
																	<center>
																		<strong>Total Efectivo</strong>
																	</center>
																</td>
																<td>
																	<center><strong><div class="col-md-4 col-sm-6" id='totalefectivo'>${{ $totalefectivo }}</div></strong></center>
																	<center>
																		<div class="col-md-8 <?php if ($errors->has('totalefectivo')) echo 'has-error' ?>">
																			<strong><div class="col-md-4 col-sm-6" id='totalefectivo'></div></strong>
																			<input type="hidden" class="form-control" id="totalefectivo" name="totalefectivo" value="{{ $totalefectivo }}" placeholder="" style="text-align: center">
																			@if ($errors->has('totalefectivo'))
																			    <span class="help-block">{{ $errors->first('totalefectivo') }}</span>
																		    @endif
																		</div>
																	</center>
																</td>
															</tr>
															<tr>
																<td>
																	<center>
																		<strong>Total Débito</strong>
																	</center>
																</td>
																<td>
																	<center><strong><div class="col-md-4 col-sm-6" id='totaldebito'>${{ $totaldebito }}</div></strong></center>
																	<center>
																		<div class="col-md-8 <?php if ($errors->has('totaldebito')) echo 'has-error' ?>">
																			<strong><div class="col-md-4 col-sm-6" id='totaldebito'></div></strong>
																			<input type="hidden" class="form-control" id="totaldebito" name="totaldebito" value="{{ $totaldebito }}" placeholder="" style="text-align: center">
																			@if ($errors->has('totaldebito'))
																			    <span class="help-block">{{ $errors->first('totaldebito') }}</span>
																		    @endif
																		</div>
																	</center>
																</td>
															</tr>
															<tr>
																<td>
																	<center>
																		<strong>Total Tarjeta de Crédito</strong>
																	</center>
																</td>
																<td>
																	<center><strong><div class="col-md-4 col-sm-6" id='totaltarjeta'>${{ $totaltarjeta }}</div></strong></center>
																	<center>
																		<div class="col-md-8 <?php if ($errors->has('totalcredito')) echo 'has-error' ?>">
																			<strong><div class="col-md-4 col-sm-6" id='totalcredito'></div></strong>
																			<input type="hidden" class="form-control" id="totalcredito" name="totalcredito" value="{{ $totaltarjeta }}" placeholder="" style="text-align: center">
																			@if ($errors->has('totalcredito'))
																			    <span class="help-block">{{ $errors->first('totalcredito') }}</span>
																		    @endif
																		</div>
																	</center>
																</td>
															</tr>
															<tr>
																<td>
																	<center>
																		<strong>Total Cuenta Bancaria</strong>
																	</center>
																</td>
																<td>
																	<center><strong><div class="col-md-4 col-sm-6" id='totalbancaria'>${{ $totalbancaria }}</div></strong></center>
																	<center>
																		<div class="col-md-8 <?php if ($errors->has('totalbancaria')) echo 'has-error' ?>">
																			<strong><div class="col-md-4 col-sm-6" id='totalbancaria'></div></strong>
																			<input type="hidden" class="form-control" id="totalbancaria" name="totalbancaria" value="{{ $totalbancaria }}" placeholder="" style="text-align: center">
																			@if ($errors->has('totalbancaria'))
																			    <span class="help-block">{{ $errors->first('totalbancaria') }}</span>
																		    @endif
																		</div>
																	</center>
																</td>
															</tr>
															<tr>
																<td>
																	<center>
																		<strong>Total Cheques</strong>
																	</center>
																</td>
																<td>
																	<center><strong><div class="col-md-4 col-sm-6" id='totalcheques'>${{ $totalcheque }}</div></strong></center>
																	<center>
																		<div class="col-md-8 <?php if ($errors->has('totalcheque')) echo 'has-error' ?>">
																			<strong><div class="col-md-4 col-sm-6" id='totalcheque'></div></strong>
																			<input type="hidden" class="form-control" id="totalcheque" name="totalcheque" value="{{ $totalcheque }}" placeholder="" style="text-align: center">
																			@if ($errors->has('totalcheque'))
																			    <span class="help-block">{{ $errors->first('totalcheque') }}</span>
																		    @endif
																		</div>
																	</center>
																</td>
															</tr>
															<tr>
																<td>
																	<center>
																		<strong>Total General</strong>
																	</center>
																</td>
																<td>
																	<center><strong><div class="col-md-4 col-sm-6" id='totalgeneralf'>${{ $totalgeneralf }}</div></strong></center>
																	<center>
																		<div class="col-md-8 <?php if ($errors->has('totalgeneral')) echo 'has-error' ?>">
																			<strong><div class="col-md-4 col-sm-6" id='totalgeneral'></div></strong>
																			<input type="hidden" class="form-control" id="totalgeneral" name="totalgeneral" value="{{ $totalgeneralf }}" placeholder="" style="text-align: center">
																			@if ($errors->has('totalgeneral'))
																			    <span class="help-block">{{ $errors->first('totalgeneral') }}</span>
																		    @endif
																		</div>
																	</center>
																</td>
															</tr>
													    </tbody>
													</table>
												</div>	<!-- /.table-responsive  style="display:none;" -->
											</div><!-- /.panel-body -->
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
												El valor debe ser positivo!!
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

	$('#imprimir').on('click', function(e){
		e.preventDefault();
		window.open("{{url('cierrecaja/pdfimprimircierre')}}?cierrecajaid=" + $('#cierrecajaid').val());
	});

	$(window).ready(function(){
	    $("body").animate({ scrollTop: $(document).height()}, 1000);    
	});

@stop

@section('includejs') 
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{url('assets/global/plugins/select2/select2.min.js')}}"></script>
<script src="{{url('assets/admin/layout/scripts/menusticky.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
@stop
