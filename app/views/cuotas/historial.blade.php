@extends('layouts.master')

@section('customstyle')
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
$disabled = (!$editar) ? 'disabled' : '';
$readonly = (!$editar) ? 'readonly' : '';
$imprimir = (!$imprimir) ? 'disabled' : '';

$total = 0;
$ultimomes = $mespagocuotainicio;
$mespagocuotafin = $mespagocuotafin;
$cicloslec = $cicloslec->descripcion;
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
					Cuotas <small>Historial de Cuotas por Alumno</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<!--li class="btn-group">
							<button type="button" class="btn blue dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
							<span>Acciones</span><i class="fa fa-angle-down"></i>
							</button>
							<ul class="dropdown-menu pull-right" role="menu">
								<li>
									<a href="#">Exportar a PDF</a>
								</li>
								<li>
									<a href="#">Exportar a CVS</a>
								</li>
								<li>
									<a href="#">Exportar a Excel</a>
								</li>
								<li class="divider">
								</li>
								<li>
									<a href="#">Salir</a>
								</li>
							</ul>
						</li -->
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
					    @if (Session::get('message_type') == CuotasController::OPERACION_EXITOSA)

					        <div class="note note-success">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == CuotasController::OPERACION_FALLIDA)

					        <div class="note note-danger">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == CuotasController::OPERACION_CANCELADA)

					        <div class="note note-warning">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == CuotasController::OPERACION_INFO)

					        <div class="note note-info">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@endif
					@endif
					<!-- COMIENZO DE LA TABLA-->
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-files-o"></i>Historial de Cuotas
							</div>
							<div class="actions">
								<a target="_blank" href="#" id="imprimir" {{$imprimir}} class="btn default yellow-stripe">
								<i class="fa fa-print"></i>
								<span class="hidden-480">
								Imprimir </span>
								</a>								
							</div>
						</div>
						<div class="portlet-body form">
							<div class="form-body">
								{{ Form::open(array('url'=>'cuotas/historialalumnos', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmHistorialalumnos', 'name'=>'FrmHistorialalumnos'))}}
								
								<div class="form-group">
									<label class="col-md-2 col-sm-2 control-label text-info" for="filtro">Ciclo Lectivo:</label>
									<div class="col-md-2 col-sm-3">
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
								<input class="form-control" name="txtalumno" id="txtalumno" type="hidden" value="{{ $dni }}">
								<div class="form-group">
									<div class="portlet-body form">
										<div class="form-group">
											<label  class="col-md-2 col-sm-2 control-label text-info">Carrera:</label>
											<div class="col-md-10 col-sm-10" id='divCarrera'><p class="form-control-static">{{$carreras}}</p></div>
										</div>

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
									</div>

								</div>

								{{ Form::close() }}
							</div>
							<div class="portlet form-horizontal">
								<div class="portlet-title">
									<div class="caption">
										<i class="fa fa-user"></i>Historial de Cuotas
									</div>
								</div>
								<div class="portlet-body">
									<div class="box-body table-responsive no-padding">
										<table class="table table-striped table-bordered table-hover" id="table_cuotass">
											<thead>
											<tr>
												<!--th>
													<center></i>Ciclo Lectivo</center>
												</th-->
												<th>
													<center>Cuota</center>
												</th>
												<th>
													<center>Fecha de Pago</center>
												</th>
												<th>
													<center>Forma de Pago</center>
												</th>
												<th>
													<center>M. descuento</center>
												</th>
												<th>
													<center>M. Recargo</center>
												</th>
												<th>
													<center>Importe</center>
												</th>
												<th>
													<center>Total</center>
												</th>
											</tr>
											</thead>
											<tbody>
											
											@if (isset($cuota_detalle))
												@foreach ($cuota_detalle as $cuota_detall)
													<?php 
													$efectivo = $cuota_detall['efectivo'];
													$tarjetacredito = $cuota_detall['tarjetacredito'];
													$tarjetadebito = $cuota_detall['tarjetadebito'];
													$cuentabancaria = $cuota_detall['cuentabancaria'];
													$cheque = $cuota_detall['cheque'];
													
													$cicloslec = $cuota_detall['cicloslec'];
													?>
													<tr class=success>
														<!--td>
															<center>
																{{ $cuota_detall['cicloslec'] }}
															</center>
														</td-->
														<td>
															<center>
																{{ $cuota_detall['mes'] }}
															</center>
														</td>
														<td>
															<center>
																{{ $cuota_detall['fechatransaccion'] }}
															</center>
														</td>
														<td>
															<center>
																<p><a class="alternar-respuesta glyphicon glyphicon-plus" style="cursor:pointer;"></a>
																<p class="respuesta" style="display:none"><?php 
																if ($efectivo > 0) {
																	echo "Efectivo<br>";
																}

																if ($tarjetacredito > 0) {
																	echo "Tarjeta de Credito<br>";
																}

																if ($cuentabancaria > 0) {
																	echo "Cta Bancaria HAC<br>";
																}

																if ($tarjetadebito > 0) {
																	echo "Tarjeta de Debito<br>";
																}

																if ($cheque > 0) {
																	echo "Cheque<br>";
																}
																?></p>
															</center>
														</td>
														<td>
															<center>
																${{ $cuota_detall['descuentos'] }}
															</center>
														</td>
														<td>
															<center>
																${{ $cuota_detall['recargos'] }}
															</center>
														</td>
														<td>
															<center>
																${{ $cuota_detall['importe'] }}
															</center>
														</td>
														<td>
															<center> 
																${{ $cuota_detall['totalpagado'] }}
															</center>
														</td>
													</tr>
													<?php 
													$total = $total + $cuota_detall['totalpagado'];
													$mespagocuotafin = $cuota_detall['mespagocuotafin'];
													$ultimomes = $cuota_detall['mescuota'] + 1;
													?>
												@endforeach
											@endif
											<?php
											$meses = ['vacio', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

											if ($mespagocuotafin == 12) $mespagocuotafin++;

											for ($i=$ultimomes; $i < $mespagocuotafin; $i++) { ?>
												<tr class=danger>
							                      <td><center>{{$meses[$i]}}</center></td>
							                      <td><center></center></td>
							                      <td><center></center></td>
							                      <td><center></center></td>
							                      <td><center></center></td>
							                      <td><center></center></td>
							                      <td><center></center></td>
							                    </tr><?php
											}
											?>
											</tbody>
										</table>
										@if (isset($cuota_detalle))
										<table class="table table-striped table-bordered table-hover" id="table_historia">
											<!--thead>
												<tr>
													<th class="hidden-xs">
														<center><p style="color: white;">CICLO</p></center>
													</th>
													<th>
														<center><p style="color: white;">MES</p></center>
													</th>
													<th>
														<center><p style="color: white;">RECARGO</p></center>
													</th>
													<th colspan="2">
														<center><p style="color: white;">FECHA</p></center>
													</th>
													<th>
														<center><p style="color: white;">FORMA PAGO</p></center>
													</th>
													<th>
														<center><p style="color: white;">DESCUENTO</p></center>
													</th>
													<th>
														<center><p style="color: white;">IMPORTE</p></center>
													</th>

												</tr>
											</thead-->
											<tbody>
												<tr style="background-color: #f2f2f2">
													<td>
														
													</td>
													<td>

													</td>
													<td colspan="2">
														<center>
															<font size=4>
																<strong>
																TOTAL
																</strong>
															</font>
														</center>
													</td>
													<td>
														
													</td>
													<td>

													</td>
													<td>
														<center><font size=4>
															<strong>
																${{ $total }}
															</strong></font>
														</center>
													</td>
													</tr>
												</tbody>
											</table>
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
					<!-- FIN DE LA TABLA-->
				</div>
			</div>
			<!-- FIN DEL CONTENIDO -->
		</div>
	</div>
	<!-- FIN -->

@stop


@section('customjs')
	TableAdvanced.init();
	
	//$("#imprimir").attr('disabled', 'disabled');

	$('#imprimir').on('click', function(e){
		e.preventDefault();
		window.open("{{url('cuotas/imprimirhistorial')}}?ciclo_id=" + $('#cboCiclo').val() + '&dni=' + $('#txtalumno').val());
	});

	$(document).ready(function(){ 
        $('.alternar-respuesta').on('click',function(e){
            $(this).parent().next().toggle();
            e.preventDefault();
        });
        $('#alternar-todo').on('click',function(e){
            $('.respuesta').toggle('slow');
            e.preventDefault();
        });
    });

    $('#cboCiclo').change(function() {

        $('#cboCarrera').children().remove().end();

		limpiar_tabla();

        if ($('#cboCiclo').val() == 0) return;

		$.ajax({
		  url: '{{url('inscripciones/obtenercarrerasporciclo')}}',
		  data:{'ciclo_lectivo_id': $('#cboCiclo').val()},
		  type: 'POST'
		}).done(function(carreras) {
			console.log(carreras);

			if (carreras == <?php echo InscripcionesController::NO_TIENE_INSCRIPCION  ?>) {
				//alert('Este Ciclo Lectivo no tiene Carreras con Alumnos inscritos');
				$('#divMensaje').html('<p class="form-control-static"><h4>' + 'Este Ciclo Lectivo no tiene Carreras con Alumnos inscritos!' + '</h4></p>');
	    	    $('#MensajeCantidad').modal('show');
				return;
			}

			$('#cboCarrera').append(
		        $('<option></option>').val(0).html('Seleccionar')
		    );

			$.each(carreras, function(key, value) {
				$('#cboCarrera').append(
			        $('<option></option>').val(value.carrera_id).html(value.carrera)
			    );
			});
		}).error(function(data) {
			console.log(data);
		});

    });

    function limpiar_tabla() {
	    var n = 0;
		$('#table_cuotas tr').each(function() {
		   if (n > 0) $(this).remove();
		   n++;
		});
    }
@stop


@section('includejs')
	<script type="text/javascript" src="{{url('assets/global/plugins/select2/select2.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js')}}"></script>
	<script src="{{url('assets/admin/pages/scripts/getFechaImpresion.js')}}"></script>
	<script src="{{url('assets/admin/pages/scripts/primerFechaMayor.js')}}"></script>
	<script src="{{url('assets/admin/pages/scripts/table-advanced.js')}}"></script>
<script src="{{url('assets/admin/layout/scripts/menusticky.js')}}" type="text/javascript"></script>
@stop
