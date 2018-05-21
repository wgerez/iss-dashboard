@extends('layouts.master')

@section('customstyle')
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/select2/select2.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css')}}"/>
<!-- END PAGE LEVEL STYLES -->
<style>
	td.verinfo{ cursor:pointer;}
	td.cargadeuda{ cursor:pointer;}
</style>
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
					Matrículas <small>nueva matrícula</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('matriculas/listado')}}">Matrículas</a>
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
					    @if (Session::get('message_type') == MatriculasController::OPERACION_EXITOSA)

							<div class="note note-success">
								<p> {{ Session::get('message') }} </p>
							</div>
						@elseif (Session::get('message_type') == MatriculasController::OPERACION_FALLIDA)

							<div class="note note-danger">
								<p> {{ Session::get('message') }} </p>
							</div>

						@endif	
					@endif
					<!-- COMIENZO DE LA TABLA-->
					{{ Form::open(array('class'=>'form-horizontal form-row-seperated', 'id'=>'FrmMatricula', 'name'=>'FrmMatricula'))}}
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-copy"></i> Matrícula
							</div>
							<div class="actions">
								<a href="{{url('matriculas/listado')}}" class="btn default yellow-stripe">
								<i class="fa fa-reorder"></i>
								<span class="hidden-480">
								Listado </span>
								</a>
								<a disabled href="recibo" class="btn default blue-stripe">
								<i class="fa fa-times"></i>
								<span class="hidden-480">
								Recibo </span>
								</a>
							</div>

						</div>
						<div class="portlet-body form">
								<div class="form-body">
									<div class="form-group">
										<label  class="col-md-2 col-sm-2 control-label">Alumno:</label>
										<div class="col-md-4 col-sm-4">
											<select name="cboFiltroAlumno" id="cboFiltroAlumno" class="table-group-action-input form-control">
												<!--<option value="1">Apellido y Nombre</option>-->
												<option value="2">DNI</option>
											</select>
										</div>
										<div class="col-md-4 col-sm-4">
											<input class="form-control" name="txtalumno" id="txtalumno" type="text" value='{{$alumno->nrodocumento}}'>
										</div>
										<div class="col-md-2 col-sm-2">
											<a class="btn blue-madison" id='btnBuscarAlumno'>
												<i class="fa fa-search"></i> Buscar
											</a>
										</div>										
									</div>

								</div>
						</div> <!-- FIN PORTLET-BODY -->
					</div>
					{{ Form::close()}}

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
								<div class="col-md-2 col-sm-4" id='divAlumno'>
									<p class="form-control-static">{{$alumno->apellido}} , {{$alumno->nombre}}</p>
								</div>
								<label  class="col-md-2 col-sm-2 control-label text-info">DNI:</label>
								<div class="col-md-2 col-sm-4" id='divDNI'>
									<p class="form-control-static">{{$alumno->nrodocumento}}</p>
								</div>								
							</div>

							<div class="form-group">
								<label  class="col-md-2 col-sm-2 control-label text-info">Dirección:</label>
								<div class="col-md-10 col-sm-10" id='divDomicilio'>
									<p class="form-control-static">
										{{$alumno->calle}} {{$alumno->numero}} ({{$alumno->localidad}}, {{$alumno->provincia}})
									</p>
								</div>
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
									<i class="fa fa-list"></i>Historico de Matrículas
								</div>
							</div>

							<div class="form-group">
								<label  class="col-md-2 col-sm-2 control-label">Carrera:</label>
								<div class="col-md-4 col-sm-10">
									<select name='cboCarrera' id='cboCarrera' class='table-group-action-input form-control'>
									    <option value='0' disabled>Seleccionar</option>
									    @foreach ($carreras as $carrera)
									        <option value='{{$carrera->inscripcion_id}}' <?php if ($carrera->inscripcion_id == $inscripcion_id) echo "selected=selected"; ?>>
									    	{{$carrera->carrera}}
									        </option>
									    @endforeach
									</select>
								</div>
								<label  class="col-md-2 col-sm-2 control-label">Ciclo Lectivo:</label>
								<div class="col-md-2 col-sm-4">
									<select name='cboCiclo' id='cboCiclo' class='table-group-action-input form-control'>
									    @foreach ($ciclos as $ciclo)
									        <option value='{{$ciclo->id}}' <?php if ($ciclo->id == $ciclo_lectivo) echo "selected=selected"; ?>>
									    	{{$ciclo->descripcion}}
									        </option>
									    @endforeach
									</select>
								</div>
								<div class="col-md-2 col-sm-4">
									<a class="btn blue-madison" id='btnAgregar' <?php if ($ciclo->id == $ciclo_lectivo) echo "disabled='true'"; ?>>
										<i class="fa fa-plus"></i> Agregar
									</a>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<center>
										<p>
											<span class="text-success"><i class="glyphicon glyphicon-align-justify"> Pagado</i></span> -- 
											<span class="text-danger"><i class="glyphicon glyphicon-align-justify"> Adeuda</i></span> --
											<span class="text-warning"><i class="glyphicon glyphicon-align-justify"> Parcial</i></span>
										</p>
									</center>
								</div>
							</div>

							<div class="portlet-body">
								<div class="table-scrollable">
									<table class="table table-hover" id='tableMatriculaCuotas'>
									<thead>
									<tr>
										<th style="display: none;">
											 ID Ciclo
										</th>
										<th>
											 Ciclo Lectivo
										</th>
										<th>
											 N° Matrícula
										</th>
										<th>
											 Importe
										</th>
										<th>
											 Saldo
										</th>
										<th>
											 Fecha Venc.
										</th>
										<th>
											 Fecha pago
										</th>
										<th>
											 Estado
										</th>										
									</tr>
									</thead>
									<tbody>
									@if (isset($inscripciones))
										@foreach ($inscripciones as $inscripcion)
										<?php
										$fecha_inicio_ciclo = explode("/", $inscripcion['fecha_inicio_ciclo_lectivo']);
										$fecha_fin_ciclo = explode("/", $inscripcion['fecha_fin_ciclo_lectivo']);

										$mes_inicio_ciclo = $fecha_inicio_ciclo[1];
										$anio_inicio_ciclo = $fecha_inicio_ciclo[2];
										$mes_fin_ciclo  = $fecha_fin_ciclo[1];
										$anio_fin_ciclo = $fecha_fin_ciclo[2];

										/*var fecha       = new Date();
										var dia_actual  = fecha.getDate();
										var mes_actual  = fecha.getMonth();
										var anio_actual = fecha.getFullYear();*/
										$fecha_actual = date("d/m/Y");//("Y-m-d");

										$meses_cuotas = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

										// Pregunto si tiene BECA.
										// Mal enfoque. REFACTORING
										$tiene_beca = false;
										$meses_beca = [0,0,0,0,0,0,0,0,0,0,0,0];
										if (!$inscripcion['beca'] == 7) {
										    $tiene_beca = true;
										    $fecha_inicio_beca = FechaHelper::getFechaImpresion($inscripcion['beca']['becafechainicio']);
										    $fecha_fin_beca = FechaHelper::getFechaImpresion($inscripcion['beca']['becafechafin']);
										    $arrFechaInicioBeca = explode("/", $fecha_inicio_beca);
										    $arrFechaFinBeca = explode("/", $fecha_fin_beca);
										    $mes_inicio_beca = $arrFechaInicioBeca[1];
										    $mes_fin_beca = $arrFechaFinBeca[1];

										    for ($i = ($mes_inicio_beca - 1); $i < $mes_fin_beca; $i++) {
										        $meses_beca[$i] = 1;
										    }
										}

										$td_tabla_accion = '';
										$tr_inicio = '';
										$no_ha_pagado = true;
										$totalparcial = false;
										$fecha_pago = '';
										$saldo = '';
										$mescuota = '';
										
										if ($inscripcion['matriculaaplica']) {
											//$.each( inscripcion.detalle_cuotas, function(key, value) {
											foreach ($inscripcion['detalle_cuotas'] as $value) {
											    $mescuota = $value->mescuota;
											    // Deuda Pago Parcial
											    if ($value->totalparcial == 1) {
											    	$totalparcial = true;
											    	$importeparcial = $value->importeparcial;
											    	$saldo = $value->saldo;
											    	$efectivo = $value->efectivo;
											    	$tarjetacredito = $value->tarjetacredito;
											    	$tarjetadebito = $value->tarjetadebito;
											    	$cuentabancaria = $value->cuentabancaria;
											    }

											    if ($value->mescuota == 0 && $value->estado == 1) {
											        $no_ha_pagado = false;
											        $fecha_pago = FechaHelper::getFechaImpresion($value->fechapago);
											    }
											}

											$fecha_vencimiento_matricula = $inscripcion['matricula_fecha_vencimiento'];

											if ($no_ha_pagado) {
												if (strtotime($fecha_vencimiento_matricula) > strtotime($fecha_actual)) {
												    $tr_inicio = '';
												    $td_tabla_accion = '<i class="fa fa-exclamation-triangle"></i>';
												} else {
												    $tr_inicio = 'class=danger';
												    $td_tabla_accion = '<i class="fa fa-check"></i>';
											    }
										        $tabla_enlace = "<td class='cargadeuda' data-mes='0' data-tipopago='matricula' data-id='". $inscripcion['matricula_id'] ."'><center>". $td_tabla_accion .'</center></td>';

											} else {
												if ($totalparcial) {
													$tr_inicio = 'class=warning';
													$td_tabla_accion = '<i class="fa fa-check"></i>';
													$tabla_enlace = "<td class='cargadeuda' data-mes='". $mescuota ."' data-tipopago='matricula' data-id='". $inscripcion['matricula_id'] ."'><center>". $td_tabla_accion .'</center></td>';
												} else {
													$tr_inicio = 'class=success';
													$td_tabla_accion = '<i class="fa fa-check"></i>';
													$tabla_enlace = "<td class='verinfo' data-mes='". $mescuota ."' data-tipopago='matricula' data-id='". $inscripcion['matricula_id'] ."'><center>". $td_tabla_accion .'</center></td>';
												}
										    }

										} else {
										    $tr_inicio = '';
										    $td_tabla_accion = '<i class="fa fa-check"></i>';
										    $fecha_vencimiento_matricula = '';
										    $tabla_enlace = "<td><center>NO APLICA</center></td>";
									    }

									    /*var tabla = tr_inicio;
										tabla += '<td style="display: none;">' + inscripcion.ciclolectivo_id + '</td>';
										tabla += '<td>' + inscripcion.ciclo_descripcion + '</td>';
										tabla += '<td>Matr&iacute;cula - ' + inscripcion.matricula_id + '</td>';
										tabla += '<td>' + inscripcion.matriculaimporte + '</td>';
										tabla += '<td>' + saldo + '</td>';
										tabla += '<td>' + fecha_vencimiento_matricula + '</td>';
										tabla += '<td>' + fecha_pago + '</td>';
										tabla += tabla_enlace;
										tabla += '</tr>';*/
										?>
										<tr {{$tr_inicio}}>
											<td style="display: none;">
												{{ $inscripcion['ciclolectivo_id'] }}
											</td>
											<td>
												{{ $inscripcion['ciclo_descripcion'] }}
											</td>
											<td>
												Matrícula - {{ $inscripcion['matricula_id'] }}
											</td>
											<td>
												{{ $inscripcion['matriculaimporte'] }}
											</td>
											<td>
												{{ $saldo }}
											</td>
											<td>
												{{ $fecha_vencimiento_matricula }}
											</td>
											<td>
												{{ $fecha_pago }}
											</td>
											{{ $tabla_enlace }}
										</tr>
										@endforeach
									@endif
									</tbody>
									</table>
								</div>
							</div>
						</div>

					</div>					


				</div>
			</div>
			<!-- FIN DEL CONTENIDO -->
		</div>
	</div>
	<!-- FIN -->



	<!-- MODAL VER INFO DE CUOTA-->
	<div id="modalVerMasInfoCuota" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Datos del Pago de Matrículas</h4>
				</div>
				  <input id="matricula_id" name='matricula_id' type="hidden" value="">
				  <input id="mes" name='mes' type="hidden" value="">
				<div class="modal-body">
					<div class="scroller" style="height:270px" data-always-visible="1" data-rail-visible="1">
							<div class="col-md-12 col-sm-12">
								<div class="col-md-4 col-sm-4">
									<p><span class="text-info">
										<strong>Ciclo Lectivo:</strong></span> <span id='verInfo_ciclo'></span>
									</p>
								</div>
								<div class="col-md-4 col-sm-4">
									<p><span class="text-info">
										<strong>Vto.:</strong></span> <span id='verInfo_fecha_vencimiento'></span>
									</p>
								</div>
								<div class="col-md-4 col-sm-4">
									<p class="text-success"><span class="text-info"><strong>Estado:</strong></span> <i class="fa fa-check"></i> Pagado</p>
								</div>
								<div class="col-md-8 col-sm-8">
									<p>
										<span class="text-info"><strong>Fecha Pago:&nbsp;&nbsp;</strong></span>
										<span id='verInfo_fecha_pago'></span>
									</p>
								</div>
							</div>
							<div class="col-md-12 col-sm-12">
								<div class="col-md-2 col-sm-2">
						 			<p class="text-info"><strong>Importe:</strong></p>
						 		</div>
						 		<div class="col-md-10 col-sm-10">
						 			<p id="verInfo_importe"></p>
						 		</div>

								<div class="col-md-2 col-sm-2">
						 			<p class="text-info"><strong>Recargo:</strong></p>
						 		</div>
						 		<div class="col-md-2 col-sm-2">
						 			<p id="verInfo_recargo"></p>
						 		</div>
								<div class="col-md-2 col-sm-2">
						 			<p class="text-info"><strong>Descuento:</strong></p>
						 		</div>
						 		<div class="col-md-6 col-sm-6">
						 			<p id="verInfo_descuento"></p>
						 		</div>

								<!--div class="col-md-3 col-sm-3">
						 			<p class="text-info"><strong>Observaciones:</strong></p>
						 		</div>
						 		<div class="col-md-9 col-sm-9">
						 			<p class="mObs" id='verInfo_obsevaciones'></p>
						 		</div-->
							</div>
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
									<div class="col-md-5 col-sm-5">
							 			<label class="text-info control-label" for="mImporte"><strong>Forma de Pago:</strong></label>
							 		</div>
						 		</div>
							</div>
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
									<div class="col-md-4 col-sm-4">
							 			<p class="text-info"><strong>Efectivo:</strong></p>
							 		</div>
							 		<div class="col-md-4 col-sm-4">
							 			<p id="verInfo_efectivo"></p>
							 		</div>
								</div>
							</div>
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
									<div class="col-md-4 col-sm-4">
							 			<p class="text-info"><strong>Tarj. de Crédito:</strong></p>
							 		</div>
							 		<div class="col-md-4 col-sm-4">
							 			<p id="verInfo_credito"></p>
							 		</div>
								</div>
							</div>
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
									<div class="col-md-4 col-sm-4">
							 			<p class="text-info"><strong>Tarj. de Débito:</strong></p>
							 		</div>
							 		<div class="col-md-4 col-sm-4">
							 			<p id="verInfo_debito"></p>
							 		</div>
								</div>
							</div>
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
									<div class="col-md-4 col-sm-4">
							 			<p class="text-info"><strong>Cta. Bancaria:</strong></p>
							 		</div>
							 		<div class="col-md-4 col-sm-4">
							 			<p id="verInfo_bancaria"></p>
							 		</div>
								</div>
							</div>
						
							<div class="col-md-12 col-sm-12">
								<div class="col-md-2 col-sm-2">
						 			<p class="text-info"><strong>Total:</strong></p>
						 		</div>
						 		<div class="col-md-10 col-sm-10">
						 			<p id="verInfo_total"></p>
						 		</div>
						 	</div>

					</div>
				</div>
				{{ Form::open(array('url'=>'matriculas/anularpago', 'class' => 'form-horizontal form-row-seperated')) }}
				  <input id="txt_persona_id_verInfo" name='txt_persona_id_verInfo' type="hidden" value="{{$alumno->persona_id}}">
				  <input id="txt_pago_id_verInfo" name='txt_pago_id_verInfo' type="hidden" value="">
				  <div class="modal-footer">
					  <button type="submit" class="btn red"><i class="fa fa-plus"></i> Anular Pago</button>
						<a target="_blank" href="#" id="imprimir" class="btn default">
							<i class="fa fa-print"></i>
							<span class="hidden-480">Imprimir</span>
						</a>
					  <button type="button" class="btn default" data-dismiss="modal">
					  	<i class="fa fa-times-circle-o"></i> Cerrar
					  </button>
				  </div>
				  {{ Form::close() }}
				</div>
		</div>
	</div>


	<!-- PARA CARGA DE LEGAJOS FALTANTES -->
	<!-- MODAL VER INFO DE CUOTA-->
	<div id="modalCargaCuota" class="modal fade" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Datos del Pago de Matrículas</h4>
				</div>
				{{ Form::open(array('url'=>'matriculas/registrarpago', 'class' => 'form-horizontal form-row-seperated')) }}
				  <input id="txt_matricula_id" name='txt_matricula_id' type="hidden" value="">
				  <input id="txt_inscripcion_id" name='txt_inscripcion_id' type="hidden" value="">
				  <input id="txt_numero_cuota" name='txt_numero_cuota' type="hidden" value="">
				  <input id="txt_alumno_id" name='txt_alumno_id' type="hidden" value="">
				  <input id="txt_persona_id" name='txt_persona_id' type="hidden" value="{{$alumno->persona_id}}">
				  <input id="txt_fecha_vencimiento" name='txt_fecha_vencimiento' type="hidden" value="">
				  <input id="matricula_id1" name='matricula_id1' type="hidden" value="">
				  <input id="mes1" name='mes1' type="hidden" value="">
				  <div class="modal-body form-body">
					<div class="scroller" style="height:590px" data-always-visible="1" data-rail-visible="1">
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
									<div class="col-md-4 col-sm-4">
										<p><span class="text-info" id='lbl_ciclo_lectivo'></span></p>
									</div>
									<div class="col-md-4 col-sm-4">
										<p><span class="text-info" id='lbl_fecha_vencimiento'></span></p>
									</div>
									<div class="col-md-4 col-sm-4" id='div_estado_pago'>
										<!--<p class="text-danger"><span class="text-info"><strong>Estado:</strong></span> <i class="fa fa-exclamation-triangle"></i> Adeuda</p>-->
									</div>				
								</div>					
							</div>
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
									<div class="col-md-2 col-sm-2">
							 			<label class="text-info control-label" for="mImporte"><strong>Importe:</strong></label>
							 		</div>
							 		<div class="input-icon col-md-4 col-sm-4">
										<input type="text" name="txt_importe" id="txt_importe" class="form-control" value='' readonly>
									</div>
									<div class="col-md-2 col-sm-2">
						                <label class="col-md-2 col-sm-2 control-label">Pago Total
						                    <input type="radio" name="parcialfra" id="parcialfra" value="0" checked="true">
						                </label>
						            </div>
						            <div class="col-md-2 col-sm-2">
						                <label class="col-md-4 col-sm-4 control-label">Pago Parcial
						                    <input type="radio" name="parcialfra" id="parcialfra" value="1">
						                </label>
									</div>
										<input type="hidden" name="txt_total_parcial" id="txt_total_parcial" class="form-control" value=''>
							 		<!--div class="col-md-4 col-sm-4">
							 			<input type="text" name="mImporte" id="mImporte" class="form-control">
							 		</div -->
							 	</div>	

								<div class="form-group">
									<div class="col-md-2 col-sm-2">
							 			<label class="text-info control-label"><strong>Recargo:</strong></label>
							 		</div>
							 		<div class="input-icon col-md-3 col-sm-3">
							 			<i class="fa"><strong>%</strong></i>
							 			<input type="text" name="txt_recargo" id="txt_recargo" class="form-control">
							 		</div>
									<div class="col-md-2 col-sm-2">
							 			<label class="text-info control-label"><strong>Descuento:</strong></label>
							 		</div>
							 		<div class="input-icon col-md-3 col-sm-3">
							 			<i class="fa"><strong>%</strong></i>
							 			<input type="text" name="txt_descuento" id="txt_descuento" class="form-control">
							 		</div>
							 	</div>
								<div class="form-group">
									<div class="col-md-2 col-sm-2">
							 			<label class="text-info control-label" for="mImporte"><strong>Total:</strong></label>
							 		</div>
							 		<div class="input-icon col-md-4 col-sm-4" id='mTotal'>
										<input type="text" name="txt_total_a_pagar" id="txt_total_a_pagar" class="form-control" value='' readonly>
									</div>
									<div class="col-md-2 col-sm-2">
							 			<label class="text-info control-label"><strong>Importe Parcial:</strong></label>
							 		</div>
							 		<div class="input-icon col-md-3 col-sm-3">
							 			<input type="text" name="txt_importe_parcial" id="txt_importe_parcial" class="form-control">
							 		</div>
								</div>
								<div class="form-group">
									<div class="col-md-2 col-sm-2">
							 			<label class="text-info control-label"><strong>Saldo:</strong></label>
							 		</div>
							 		<div class="input-icon col-md-3 col-sm-3">
							 			<input type="hidden" name="txt_saldo" id="txt_saldo" class="form-control">
							 			<p><strong><span class="text-info" id='txt_saldos'></span></strong></p>
							 		</div>
						 		</div>
								<div class="form-group">
									<div class="col-md-3 col-sm-3">
							 			<label class="text-info control-label" for="mImporte"><strong>Forma de Pago:</strong></label>
							 		</div>
						 		</div>
								<div class="form-group">
							 		<div class="input-icon col-md-5 col-sm-5">
										<input type="text" name="txt_efectivo" id="txt_efectivo" placeholder="Efectivo" class="form-control" value=''>
									</div><br>
						 		</div>
								<div class="form-group">
							 		<div class="input-icon col-md-5 col-sm-5">
										<input type="text" name="txt_tarjeta" id="txt_tarjeta" placeholder="Tarjeta de Crédito" class="form-control" value=''>
									</div><br>
						 		</div>
								<div class="form-group">
							 		<div class="input-icon col-md-5 col-sm-5">
										<input type="text" name="txt_debito" id="txt_debito" placeholder="Tarjeta de Débito" class="form-control" value=''>
									</div><br>
						 		</div>
								<div class="form-group">
							 		<div class="input-icon col-md-5 col-sm-5">
										<input type="text" name="txt_bancaria" id="txt_bancaria" placeholder="Cuenta Bancaria" class="form-control" value=''>
									</div><br>
								</div>
							</div>
						
					</div>
				</div>
				<div class="modal-footer">
					<a target="_blank" href="#" id="imprimir1" class="btn default">
						<i class="fa fa-print"></i>
						<span class="hidden-480">Imprimir</span>
					</a>
					<button type="submit" id="guardar" class="btn blue"><i class="fa fa-save"></i> Guardar</button>
					<button type="button" class="btn default" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> Cerrar</button>
				</div>
				{{ Form::close() }}
			</div>
		</div>
	</div>	



@stop


@section('customjs')
	ComponentsFormTools.init();

	//$('#btnAgregar').attr('disabled', 'disabled');
	$('#txt_importe_parcial').attr('disabled', 'disabled');
	$('#imprimir').attr('disabled', 'disabled');

	$('#imprimir').on('click', function(e){
		e.preventDefault();
		window.open("{{url('matriculas/imprimirrecibo')}}?inscripcion_id=" + $('#cboCarrera').val() + '&mes=' + $('#mes').val() + '&matricula_id=' + $('#matricula_id').val());
	});

	$('#imprimir1').on('click', function(e){
		e.preventDefault();
		window.open("{{url('matriculas/imprimirrecibo')}}?inscripcion_id=" + $('#cboCarrera').val() + '&mes=' + $('#mes1').val() + '&matricula_id=' + $('#matricula_id1').val());
	});

	$(document).ready(function() {
	    $('input:radio[name=parcialfra]').change(function() {
	        if (this.value == '0') {
	        	$('#txt_importe_parcial').attr('disabled', 'disabled');
				$('#txt_total_parcial').val(0);
	        }
	        else if (this.value == '1') {
	        	$('#txt_importe_parcial').removeAttr("disabled");
				$('#txt_total_parcial').val(1);
	        }
	    });
	});

    function calcular_forma_pago() {
        var txt_efectivo = parseInt($('#txt_efectivo').val());
    	var txt_tarjeta = parseInt($('#txt_tarjeta').val());
    	var txt_debito = parseInt($('#txt_debito').val());
    	var txt_bancaria = parseInt($('#txt_bancaria').val());
    	var txt_importe_parcial = parseInt($('#txt_importe_parcial').val());
    	var txt_total_a_pagar = parseInt($('#txt_total_a_pagar').val());
    	var bandera = true;

    	if (!txt_efectivo) txt_efectivo = 0;
    	
    	if (!txt_tarjeta) txt_tarjeta = 0;

    	if (!txt_debito) txt_debito = 0;

    	if (!txt_bancaria) txt_bancaria = 0;

		var total = txt_efectivo + txt_tarjeta + txt_debito + txt_bancaria;

    	if (!isNaN(txt_importe_parcial)) {
	    	if (total > txt_importe_parcial) {
	        	alert("No se debe superar el Importe Parcial!!");
	        	$('#txt_efectivo').val('');
	        	$('#txt_tarjeta').val('');
	    		$('#txt_debito').val('');
	    		$('#txt_bancaria').val('');
		    } else {
		    	if (txt_efectivo > txt_importe_parcial) {
		    		alert("El valor no debe ser mayor que el Importe Parcial!!");
		    		$('#txt_efectivo').val('');
		    		bandera = false;
		    	}
		    	if (txt_tarjeta > txt_importe_parcial) {
		    		alert("El valor no debe ser mayor que el Importe Parcial!!");
		    		$('#txt_tarjeta').val('');
		    		bandera = false;
		    	}
		    	if (txt_debito > txt_importe_parcial) {
		    		alert("El valor no debe ser mayor que el Importe Parcial!!");
		    		$('#txt_debito').val('');
		    		bandera = false;
		    	}
		    	if (txt_bancaria > txt_importe_parcial) {
		    		alert("El valor no debe ser mayor que el Importe Parcial!!");
		    		$('#txt_bancaria').val('');
		    		bandera = false;
		    	}
		    }
	    } else {
	        if (total > txt_total_a_pagar) {
	        	alert("No se debe superar el Importe Total!!");
	        	$('#txt_efectivo').val('');
	        	$('#txt_tarjeta').val('');
	    		$('#txt_debito').val('');
	    		$('#txt_bancaria').val('');
	        } else {
		    	if (txt_efectivo > txt_total_a_pagar) {
		    		alert("El valor no debe ser mayor que el Total a Pagar!!");
		    		$('#txt_efectivo').val('');
		    		bandera = false;
		    	}
		    	if (txt_tarjeta > txt_total_a_pagar) {
		    		alert("El valor no debe ser mayor que el Total a Pagar!!");
		    		$('#txt_tarjeta').val('');
		    		bandera = false;
		    	}
		    	if (txt_debito > txt_total_a_pagar) {
		    		alert("El valor no debe ser mayor que el Total a Pagar!!");
		    		$('#txt_debito').val('');
		    		bandera = false;
		    	}
		    	if (txt_bancaria > txt_total_a_pagar) {
		    		alert("El valor no debe ser mayor que el Total a Pagar!!");
		    		$('#txt_bancaria').val('');
		    		bandera = false;
		    	}
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

	function limpiar_datos_informe_pago() {
		$('#verInfo_ciclo').html('');
		$('#verInfo_fecha_vencimiento').html('');
		$('#verInfo_fecha_pago').html('');
		$('#verInfo_importe').html('');
		$('#verInfo_recargo').html('');
		$('#verInfo_descuento').html('');		
		$('#verInfo_total').html('');
		$('#verInfo_efectivo').html('');
		$('#verInfo_credito').html('');
		$('#verInfo_debito').html('');
		$('#verInfo_bancaria').html('');
		//$('#verInfo_obsevaciones').html('');
	}

	$('.verinfo').live('click', function() {
		var inscripcion_id = $('#cboCarrera').val();//$(this).data('id');
		var matricula_id = $(this).data('id');
		var tipo_pago = $(this).data('tipopago');
		var mes = $(this).data('mes');
		$('#imprimir').removeAttr("disabled");
		$('#matricula_id').val(matricula_id);
		$('#mes').val(mes);

		limpiar_datos_informe_pago();

        /* OBTENGO DATOS DEL PAGO REALIZADO */
		$.ajax({
		  url: '{{url('matriculas/obtenerdatospagorealizado')}}',
		  data:{'inscripcion_id': inscripcion_id, 'mes': mes, matricula_id: matricula_id},
		  type: 'POST'
		}).done(function(pagos) {
			console.log(pagos);
			$.each(pagos, function(key, pago) {
				var fecha_vencimiento = getFechaImpresion(pago.fechavencimiento);
				var fecha_pago = getFechaImpresion(pago.fechapago);
		    	var efectivo = '-';
		    	var tarjetacredito = '-';
		    	var tarjetadebito = '-';
		    	var cuentabancaria = '-';

		        var importe = parseInt(pago.matriculaimporte);
		    	var porcentaje_recargo = parseInt(pago.porcentajerecargo);
		    	var porcentaje_descuento = parseInt(pago.porcentajedescuento);

		    	/* CALCULO TOTAL PAGADO */
		    	var recargo = 0;
		    	var descuento = 0;

		    	if (!isNaN(porcentaje_recargo)) {
		    		recargo = (importe * porcentaje_recargo) / 100;
		        }

		    	if (!isNaN(porcentaje_descuento)) {
		    		descuento = (importe * porcentaje_descuento) / 100;
		        }

		        var total_pagado = importe + recargo - descuento;

		    	if (pago.efectivo > 0) {
		    		efectivo = '$' + pago.efectivo;
		        }

		    	if (pago.tarjetacredito > 0) {
		    		tarjetacredito = '$' + pago.tarjetacredito;
		        }

		    	if (pago.tarjetadebito > 0) {
		    		tarjetadebito = '$' + pago.tarjetadebito;
		        }

		    	if (pago.cuentabancaria > 0) {
		    		cuentabancaria = '$' + pago.cuentabancaria;
		        }

		        /* FIN CALCULO TOTAL PAGADO */

				$('#verInfo_ciclo').html(pago.ciclo_descripcion);
				$('#verInfo_fecha_vencimiento').html(fecha_vencimiento);
				$('#verInfo_fecha_pago').html(fecha_pago);
				$('#verInfo_importe').html('$' + pago.matriculaimporte);
				$('#verInfo_recargo').html('%' + pago.porcentajerecargo);
				$('#verInfo_descuento').html('%' + pago.porcentajedescuento);
				$('#verInfo_total').html('$' + total_pagado);
				$('#verInfo_efectivo').html(efectivo);
				$('#verInfo_credito').html(tarjetacredito);
				$('#verInfo_debito').html(tarjetadebito);
				$('#verInfo_bancaria').html(cuentabancaria);
				//$('#verInfo_obsevaciones').html(pago.observaciones);
				$('#txt_pago_id_verInfo').val(pago.pago_id);
			});
		}).error(function(data) {
			console.log(data);
		});
		$('#modalVerMasInfoCuota').modal('show');
	});

	function limpiar_datos_pago_cuotas() {
		$('#txt_inscripcion_id').val('');
		$('#txt_numero_cuota').val('');
		$('#txt_importe').val('');
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

        $('#txt_total_a_pagar').val(total);
    }

    $('#txt_recargo').live('keyup', function() {
    	calcular_total_a_pagar();
	});

    $('#txt_descuento').live('keyup', function() {
    	calcular_total_a_pagar();
	});

    $('#txt_importe_parcial').live('keyup', function() {
        var total = parseInt($('#txt_total_a_pagar').val());
        var importeparcial = parseInt($('#txt_importe_parcial').val());

    	if (!isNaN(importeparcial)) {
    		if (importeparcial > total) {
    			alert("El importe Parcial no debe ser mayor al total a pagar!!");
    			$('#txt_importe_parcial').val('');
    			$('#txt_saldo').val('');
    			$('#txt_saldos').html('');
    		} else {
    		    var saldo = total - importeparcial;

    			$('#txt_saldos').html(saldo);
    			$('#txt_saldo').val(saldo);
    		}
        }
	});

	$('.cargadeuda').live('click', function(){
		//$('#mImporte').focus();
		$('#modalCargaCuota').modal('show');
		$('input:radio[name=parcialfra]').removeAttr("disabled");
		$('#txt_total_parcial').val(0);
		$('#imprimir1').attr('disabled', 'disabled');

		var inscripcion_id = $('#cboCarrera').val();//$(this).data('id');
		var matricula_id = $(this).data('id');
		var tipo_pago = $(this).data('tipopago');
		var mes = $(this).data('mes');
		$('#matricula_id1').val(matricula_id);
		$('#mes1').val(mes);

		limpiar_datos_pago_cuotas();

		$('#txt_inscripcion_id').val(inscripcion_id);
		$('#txt_numero_cuota').val(mes);

        /* OBTENGO DATOS PARA EL PAGO */
		$.ajax({
		  url: '{{url('matriculas/obtenerdatosparapago')}}',
		  data:{'inscripcion_id': inscripcion_id, 'tipo_pago': tipo_pago, matricula_id: matricula_id},
		  type: 'POST'
		}).done(function(inscripcion) {
			console.log(inscripcion);
			if (tipo_pago == 'matricula') {
				var fecha_vencimiento = getFechaImpresion(inscripcion.matricula_fecha_vencimiento);
				$('#txt_importe').val(inscripcion.matriculaimporte);
				$('#txt_total_a_pagar').val(inscripcion.matriculaimporte);
				$('#txt_alumno_id').val(inscripcion.alumno_id);
				$('#txt_matricula_id').val(inscripcion.matricula_id);
				$('#lbl_ciclo_lectivo').html('Ciclo Lectivo: ' + inscripcion.ciclo_descripcion);
				$('#lbl_fecha_vencimiento').html('Fecha Vto: ' + fecha_vencimiento);
				$('#txt_fecha_vencimiento').val(fecha_vencimiento);

				$.ajax({
				  url: '{{url('matriculas/obtenerdatospagorealizado')}}',
				  data:{'inscripcion_id': inscripcion_id, 'mes': mes, matricula_id: matricula_id},
				  type: 'POST'
				}).done(function(pagos) {
					console.log(pagos);
					$.each(pagos, function(key, pago) {
						if (pago.totalparcial == 1) {
							$('#txt_total_a_pagar').val(pago.saldo);
							$('#txt_total_parcial').val(1);
							$('#imprimir1').removeAttr("disabled");
							$('input:radio[name=parcialfra]').attr('disabled', 'disabled');
							$('#txt_saldos').html(pago.saldo);
						}
					});
				}).error(function(data) {
					console.log(data);
				});
			} else {
			    fecha_fin_ciclo = getFechaImpresion(inscripcion.fecha_fin_ciclo_lectivo);
			    var arr_fecha_fin_ciclo = fecha_fin_ciclo.split('/');
			    var fecha_vencimiento = inscripcion.cuota_pago_hasta_dia + '/' + mes + '/' + arr_fecha_fin_ciclo[2];
				$('#txt_importe').val(inscripcion.cuotaimporte);
				$('#txt_total_a_pagar').val(inscripcion.matriculaimporte);
				$('#txt_alumno_id').val(inscripcion.alumno_id);
				$('#txt_matricula_id').val(inscripcion.matricula_id);
				$('#lbl_ciclo_lectivo').html('Ciclo Lectivo: ' + inscripcion.ciclo_descripcion);
				$('#lbl_fecha_vencimiento').html('Fecha Vto: ' + fecha_vencimiento);
				$('#txt_fecha_vencimiento').val(fecha_vencimiento);
		    }
		}).error(function(data) {
			console.log(data);
		});
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
	    	alert('Ingrese el dato del Alumno');
	    	return;
	    }
	    if ($('#cboFiltroAlumno').val() == 2) {
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
		  data:{'txt_alumno': $('#txtalumno').val()},
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
		    $('#txt_persona_id').val(alumno.persona_id);
		    $('#txt_persona_id_verInfo').val(alumno.persona_id);

            /* OBTENGO CARRERAS A LAS QUE ESTA INCRITO EL ALUMNO */
			$.ajax({
			  url: '{{url('matriculas/obtenercarrerasinscripciones')}}',
			  data:{'alumno_id': alumno.alumno_id},
			  type: 'POST'
			}).done(function(carreras) {
				console.log(carreras);

				$('#cboCarrera').append(
			        $('<option></option>').val(0).html('Seleccionar')
			    );
				
				$.each(carreras, function(key, value) {
					$('#cboCarrera').append(
				        $('<option></option>').val(value.inscripcion_id).html(value.carrera)
				    );
				});

				/* OBTENGO CICLOS */
				$.ajax({
				  url: '{{url('matriculas/obtenerciclos')}}',
				  data:{'alumno_id': alumno.alumno_id},
				  type: 'POST'
				}).done(function(ciclos) {
					console.log(ciclos);

		 			$('#cboCiclo').children().remove().end();
				
					$.each(ciclos, function(key, value) {
						$('#cboCiclo').append(
					        $('<option></option>').val(value.id).html(value.descripcion)
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
	}

    $('#cboFiltroAlumno').change(function() {
    	$('#txtalumno').val('');
    	$('#txtalumno').focus();
    });

	$('#btnAgregar').live('click', function() {
    	var carrera = $('#cboCarrera').val();
    	var ciclo = $('#cboCiclo').val();
    	var alumno_id = $('#txt_alumno_id').val();

        /* GENERO INSCRIPCION ALUMNO-CARRERA */
		$.ajax({
		  url: '{{url('matriculas/generarinscripcion')}}',
		  data:{'inscripcion_id': carrera, 'ciclo': ciclo, 'alumno_id': alumno_id},
		  type: 'POST'
		}).done(function(inscripcion) {
			console.log(inscripcion);

        		Generar_Inscripcion();

		}).error(function(data) {
			console.log(data);
		});
    });

    $('#cboCarrera').change(function() {
    	$('#btnAgregar').removeAttr("disabled");
        var bandera = true;
    	var ciclo = $('#cboCiclo').val();

	    $("#tableMatriculaCuotas tbody tr").each(function (index) {
    		var ciclo = $('#cboCiclo').val();
            var campo1;
            $(this).children("td").each(function (index2) {
                switch (index2) {
                    case 0: campo1 = $(this).text();
                    		if (campo1 == ciclo) {
                    			$('#btnAgregar').attr('disabled', 'disabled');
                    			bandera = false;
                    		}
                            break;
                }
                //$(this).css("background-color", "#ECF8E0");
            });
        });

        Generar_Inscripcion();
    });

    $('#cboCiclo').change(function() {
    	$('#btnAgregar').removeAttr("disabled");
        var bandera = true;
    	var ciclo = $('#cboCiclo').val();

	    $("#tableMatriculaCuotas tbody tr").each(function (index) {
    		var ciclo = $('#cboCiclo').val();
            var campo1;
            $(this).children("td").each(function (index2) {
                switch (index2) {
                    case 0: campo1 = $(this).text();
                    		if (parseInt(campo1) == parseInt(ciclo)) {
                    			$('#btnAgregar').attr('disabled', 'disabled');
                    			bandera = false;
                    		}
                            break;
                }
                //$(this).css("background-color", "#ECF8E0");
            });
        });

        //Generar_Inscripcion();
    });

    function Generar_Inscripcion() {
    	var ciclo = $('#cboCiclo').val();
    	var carrera = $('#cboCarrera').val();
    	var alumno_id = $('#txt_alumno_id').val();

    	if (carrera == 0 || ciclo == 0) {
    	    alert('Debe seleccionar todos los datos a buscar');
    	    return;
    	}

    	limpiar_tabla_matriculas();

        /* OBTENGO INSCRIPCION ALUMNO-CARRERA */
		$.ajax({
		  url: '{{url('matriculas/obtenerdatosinscripcion')}}',
		  data:{'inscripcion_id': carrera, 'ciclo': ciclo, 'alumno_id': alumno_id},
		  type: 'POST'
		}).done(function(inscripcions) {
			console.log(inscripcions);

			$.each(inscripcions, function(key, inscripcion) {

				var fecha_fin_ciclo = getFechaImpresion(inscripcion.fecha_fin_ciclo_lectivo);
				var fecha_inicio_ciclo = getFechaImpresion(inscripcion.fecha_inicio_ciclo_lectivo);

				var arrFechaFinCiclo = fecha_fin_ciclo.split('/');
				var arrFechaInicioCiclo = fecha_inicio_ciclo.split('/');
				var mes_inicio_ciclo = arrFechaInicioCiclo[1];
				var anio_inicio_ciclo = arrFechaInicioCiclo[2];
				var mes_fin_ciclo  = arrFechaFinCiclo[1];
				var anio_fin_ciclo = arrFechaFinCiclo[2];

				var fecha       = new Date();
				var dia_actual  = fecha.getDate();
				var mes_actual  = fecha.getMonth();
				var anio_actual = fecha.getFullYear();
				var fecha_actual = fecha.getDate() + '/' + fecha.getMonth() + '/' + fecha.getFullYear();

				meses_cuotas = [
				    'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio',
				    'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
				];

				if (inscripcion.ciclolectivo_id == ciclo) {
					$('#btnAgregar').attr('disabled', 'disabled');
				}/* else {
					$('#btnAgregar').removeAttr("disabled");
				}*/

				// Pregunto si tiene BECA.
				// Mal enfoque. REFACTORING
				var tiene_beca = false;
				var meses_beca = [0,0,0,0,0,0,0,0,0,0,0,0];
				if (inscripcion.beca != <?php echo MatriculasController::NO_TIENE_BECA?>) {
				    tiene_beca = true;
				    var fecha_inicio_beca = getFechaImpresion(inscripcion.beca.becafechainicio);
				    var fecha_fin_beca = getFechaImpresion(inscripcion.beca.becafechafin);
				    var arrFechaInicioBeca = fecha_inicio_beca.split('/');
				    var arrFechaFinBeca = fecha_fin_beca.split('/');
				    var mes_inicio_beca = parseInt(arrFechaInicioBeca[1]);
				    var mes_fin_beca = parseInt(arrFechaFinBeca[1]);

				    for (i = (mes_inicio_beca - 1); i < mes_fin_beca; i++) {
				        meses_beca[i] = 1;
				    }
				}


				var td_tabla_accion = '';
				var tr_inicio = '';
				var no_ha_pagado = true;
				var totalparcial = false;
				var fecha_pago = '';
				var saldo = '';
				var mescuota = '';
				
				if (inscripcion.matriculaaplica) {
					$.each( inscripcion.detalle_cuotas, function(key, value) {
					    mescuota = value.mescuota;
					    // Deuda Pago Parcial
					    if (value.totalparcial == 1) {
					    	totalparcial = true;
					    	var importeparcial = value.importeparcial;
					    	saldo = value.saldo;
					    	var efectivo = value.efectivo;
					    	var tarjetacredito = value.tarjetacredito;
					    	var tarjetadebito = value.tarjetadebito;
					    	var cuentabancaria = value.cuentabancaria;
					    }
					    if (value.mescuota == 0 && value.estado == 1) {
					        no_ha_pagado = false;
					        fecha_pago = getFechaImpresion(value.fechapago);
					        return;
					    }
					});

					var fecha_vencimiento_matricula = getFechaImpresion(
					    inscripcion.matricula_fecha_vencimiento
					);

					if (no_ha_pagado) {

						if (primerFechaMayor(fecha_vencimiento_matricula, fecha_actual)) {
						    tr_inicio = '<tr>';
						    td_tabla_accion = '<i class="fa fa-exclamation-triangle"></i>';
						} else {
						    tr_inicio = '<tr class=danger>';
						    td_tabla_accion = '<i class="fa fa-check"></i>';
					    }
				        tabla_enlace = "<td class='cargadeuda' data-mes='0' data-tipopago='matricula' data-id='" + inscripcion.matricula_id + "'><center>" + td_tabla_accion + '</center></td>';

					} else {
						if (totalparcial) {
							tr_inicio = '<tr class=warning>';
							td_tabla_accion = '<i class="fa fa-check"></i>';
							tabla_enlace = "<td class='cargadeuda' data-mes='" + mescuota + "' data-tipopago='matricula' data-id='" + inscripcion.matricula_id + "'><center>" + td_tabla_accion + '</center></td>';
						} else {
							tr_inicio = '<tr class=success>';
							td_tabla_accion = '<i class="fa fa-check"></i>';
							tabla_enlace = "<td class='verinfo' data-mes='" + mescuota + "' data-tipopago='matricula' data-id='" + inscripcion.matricula_id + "'><center>" + td_tabla_accion + '</center></td>';
						}
				    }

				} else {
				    tr_inicio = '<tr>';
				    td_tabla_accion = '<i class="fa fa-check"></i>';
				    fecha_vencimiento_matricula = '';
				    tabla_enlace = "<td><center>NO APLICA</center></td>";
			    }

			    var tabla = tr_inicio;
				tabla += '<td style="display: none;">' + inscripcion.ciclolectivo_id + '</td>';
				tabla += '<td>' + inscripcion.ciclo_descripcion + '</td>';
				tabla += '<td>Matr&iacute;cula - ' + inscripcion.matricula_id + '</td>';
				tabla += '<td>' + inscripcion.matriculaimporte + '</td>';
				tabla += '<td>' + saldo + '</td>';
				tabla += '<td>' + fecha_vencimiento_matricula + '</td>';
				tabla += '<td>' + fecha_pago + '</td>';
				tabla += tabla_enlace;
				tabla += '</tr>';

				$('#tableMatriculaCuotas > tbody').append(tabla);
			});

		}).error(function(data) {
			console.log(data);
		});

    }

    function limpiar_tabla_matriculas() {
	    var n = 0;
		$('#tableMatriculaCuotas tr').each(function() {
		   if (n > 0) $(this).remove();
		   n++;
		});
    }


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
<!-- END PAGE LEVEL PLUGINS -->
@stop
