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

.ir-arriba {
  display:none;
  padding:20px;
  background:#666666;
  font-size:20px;
  color:#fff;
  cursor:pointer;
  position: fixed;
  bottom:20px;
  right:20px;
}

.ir-arriba:hover {
  display:none;
  padding:20px;
  background:#C0C0C0;
  font-size:20px;
  color:#fff;
  cursor:pointer;
  position: fixed;
  bottom:20px;
  right:20px;
}

</style>
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
					Informes <small> Deudas</small>
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
							<a href="{{url('alumnos/informealumnosdeudasporcarrera')}}">Deudas</a>
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
					    @if (Session::get('message_type') == AlumnosController::OPERACION_EXITOSA)

					        <div class="note note-success">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == AlumnosController::OPERACION_FALLIDA)

					        <div class="note note-danger">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == AlumnosController::OPERACION_CANCELADA)

					        <div class="note note-warning">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == AlumnosController::OPERACION_INFO)

					        <div class="note note-info">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@endif
					@endif
					<!-- COMIENZO DE LA TABLA-->
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-files-o"></i>Listado de Alumnos con Deudas
							</div>
							<div class="actions">
								<!--a href="{{url('cuotas/pagar')}}" {{$disabled}} class="btn default blue-stripe">
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Pagar </span>
								</a-->
								<a target="_blank" href="#" id="imprimir" {{$imprimir}} class="btn default yellow-stripe">
								<i class="fa fa-print"></i>
								<span class="hidden-480">
								Imprimir </span>
								</a>								
							</div>
						</div>
						<div class="portlet-body form">
							<div class="form-body">
								{{ Form::open(array('url'=>'alumnos/listadoalumnos', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmListadoalumnos', 'name'=>'FrmListadoalumnos'))}}
								<div class="form-group">
									<label  class="col-md-2 col-sm-2 control-label">Organización:</label>
									<div class="col-md-6 col-sm-6">
										{{ Form::select('cboOrganizacion', $organizaciones, Input::old('organizacion'), array('class'=>'table-group-action-input form-control','id'=>'cboOrganizacion')); }}
									</div>
									<!--div class="col-md-4 col-sm-4 col-xs-12">
										<center>
											<p><span class="text-success"><i class="fa fa-check"></i></span> Pagado - <span class="text-danger"><i class="fa fa-exclamation-triangle"></i></span> Adeuda - <span class="text-info"><i class="fa fa-asterisk"></i></span> Becado</p>
										</center>
									</div-->
								</div>

								<div class="form-group">
									<label class="col-md-2 col-sm-2 control-label" for="filtro">Ciclo Lectivo:</label>
									<div class="col-md-2 col-sm-3">
										<select name="cboCiclo" id="cboCiclo" class="table-group-action-input form-control">
										</select>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 col-sm-2 control-label" for="cbocarrera">Carrera:</label>
									<div class="col-md-6 col-sm-6">
										<select name="cboCarrera" id="cboCarrera" class="table-group-action-input form-control">
										</select>
									</div>
								</div>

								<div class="portlet-body form">
									<div class="form-body">
										<div class="form-group">
											<label  class="col-md-2 col-sm-2 control-label">Alumno:</label>
											<div class="col-md-4 col-sm-4">
												<select name="cboFiltroAlumno" id="cboFiltroAlumno" class="table-group-action-input form-control">
													<option value="1">Todos</option>
													<option value="2">DNI</option>
												</select>
											</div>
											<div class="col-md-4 col-sm-4">
												<input class="form-control" name="txtalumno" id="txtalumno" type="text" value="">
												<input class="form-control" name="alumno_id" id="alumno_id" type="hidden" value="">
											</div>
											<div class="col-md-2 col-sm-2">
												<a class="btn blue-madison" id='btnBuscar'>
													<i class="fa fa-search"></i> Buscar
												</a>
											</div>										
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label <?php if ($errors->has('fechadesde')) echo 'text-danger' ?>">Fecha Desde:</label>
									<div id="divavisofechaing" class="col-md-3 <?php if ($errors->has('fechadesde')) echo 'has-error' ?>">
										<div class="input-icon right">
											<i class="fa fa-exclamation tooltips iconoerrorfechaing" style="display:none" data-original-title="Fecha Incorrecta." data-container="body"></i>
											<input type="date" class="form-control" name="fechadesde" id="fechadesde" placeholder="" value="<?php if (isset($fechadesdes)) echo $fechadesdes; ?>">

											<!-- mostrar cuando exista error -->
									    	@if ($errors->has('fechadesde'))
										    	<span class="help-block">{{ $errors->first('fechadesde') }}</span>
									    	@endif
									    	<!--fin error-->
										</div>
									</div>
									<label class="col-md-2 control-label">Fecha Hasta:</label>
									<div class="col-md-3">
										<input type="date" class="form-control" name="fechahasta" id="fechahasta" placeholder="" value="<?php if (isset($fechahastas)) echo $fechahastas; ?>">
									</div>
								</div>
								{{ Form::close() }}
							</div>
							<div class="portlet-body">
								<div class="box-body table-responsive no-padding">
									<table class="table table-striped table-bordered table-hover" id="table_cuotas">
										<thead>
										<tr>
											<th>
												<center><i class="fa fa-users"></i>Alumno</center>
											</th>
											<th>
												<center><i class="fa fa-files-o"></i>N° Doc.</center>
											</th>
											<th>
												<center>Matricula</center>
											</th>
											<th>
												<center>Cuota</center>
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
										
										</tbody>
									</table>
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
					</div>
					<!-- FIN DE LA TABLA-->
				</div>
			</div>
			<!-- FIN DEL CONTENIDO -->
		</div>
	</div>
	<div class="ir-arriba"><i class="glyphicon glyphicon-arrow-up"></i></div>
	<!-- FIN -->

@stop

@section('customjs')
	//TableAdvanced.init();
	
//Emular Tab al presionar Enter
$('input').keydown( function(e) {
        var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
        if(key == 13) {
            e.preventDefault();
            var inputs = $(this).closest('form').find(':input:visible');
            inputs.eq( inputs.index(this)+ 1 ).focus();
        }
 });

	$("#imprimir").attr('disabled', 'disabled');
	$("#txtalumno").attr('disabled', 'disabled');

	$('#cboFiltroAlumno').click(function() {
		if ($('#cboFiltroAlumno').val() == 2) {
	        $('#txtalumno').removeAttr("disabled");
	    }

	    if ($('#cboFiltroAlumno').val() == 1) {
	        $('#txtalumno').val("");
	        $('#alumno_id').val("");
	    	$("#txtalumno").attr('disabled', 'disabled');
	    }
	});

	$('#cboOrganizacion').select2({
		placeholder: "Seleccione",
		allowClear: true
	});

	$('#imprimir').on('click', function(e){
		e.preventDefault();
		window.open("{{url('cuotas/imprimirdeuda')}}?organizacion_id=" + $('#cboOrganizacion').val() + '&carrera_id=' + $('#cboCarrera').val() + '&ciclo_id=' + $('#cboCiclo').val() + '&alumno_id=' + $('#alumno_id').val() + '&fechadesde=' + $('#fechadesde').val() + '&fechahasta=' + $('#fechahasta').val());
	});

    $('#btnBuscar').click(function() {
    	var ciclo = $('#cboCiclo').val();
    	var carrera = $('#cboCarrera').val();
    	var fechadesde = $('#fechadesde').val();
    	var fechahasta = $('#fechahasta').val();

    	if (fechadesde == '' || fechahasta == '') {
    	    $('#divMensaje').html('<p class="form-control-static"><h4>' + 'Debe seleccionar el rango de fechas a buscar!!' + '</h4></p>');
    	    $('#MensajeCantidad').modal('show');
    	    return;
    	}

    	if ($('#cboFiltroAlumno').val() == 1) {
			var class_matricula = '';
			var td_cuota = '';

	    	var organizacion = $('#cboOrganizacion').val();

	    	if (organizacion == 0 || carrera == 0 || ciclo == 0) {
	    	    $('#divMensaje').html('<p class="form-control-static"><h4>' + 'Debe seleccionar todos los datos a buscar!!' + '</h4></p>');
	    	    $('#MensajeCantidad').modal('show');
	    	    return;
	    	}

	    	limpiar_tabla();

				$.ajax({
				  url: '{{url('cuotas/obtenerdeudasalumnos')}}',
				  data:{'organizacion': organizacion, 'ciclo': ciclo, 'carrera': carrera, 'fechadesde': fechadesde, 'fechahasta': fechahasta},
				  type: 'POST'
				}).done(function(cuotas) {
					console.log(cuotas);

					if (cuotas.length == 0) {
						$("#imprimir").attr('disabled', 'disabled');
					} else {
						$("#imprimir").removeAttr("disabled");
					}

					var totalimporte = 0;
					var totaldeuda = 0;
					var tablacargadas = '';
					var totalmatricula = 0;
					var fechahasta = $('#fechahasta').val();
					var elem = fechahasta.split("-");
					var meshasta = elem[1];
    				var fechadesde = $('#fechadesde').val();
    				var arrResult = fechadesde.split('-');
    				var messelecc = parseInt(arrResult[1],10);

					$.each(cuotas, function(key, cuota) {
						ya_pago_cuota = false;
			    		tiene_beca = false;
			    		var tiene_beca_td = '';
			    		tr_cuota = '';

					    if (cuota.beca == 7) {
					    	tiene_beca = false;
					    	tiene_beca_td = '<td><center><a title="Modificar" href="{{url('cuotas/editar')}}/'+cuota.ciclolectivo_id+'-'+cuota.carrera_id+'-'+cuota.alumno_id+'" class="btn default btn-xs purple"><i class="fa fa-edit"></i></a></center></td>';
					    } else {
							tiene_beca = true;
							tiene_beca_td = '<td></td>';
						}
        				
        				var apeynom = cuota.apellido + ', ' + cuota.nombre;
						
						if (cuota.cuotaaplica == 1) {
							var meses = ["S/D", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

							$.each(cuota.detalle_cuotas, function(key, value) {
							    if (value.estado == 1) {
									ya_pago_cuota = true;
							    }
							});

							if (ya_pago_cuota) {
								tr_cuota = '<tr>';
							} else {
								var mespagocuotafin = '';

								if (cuota.mespagocuotafin == null) {
									mespagocuotafin = 13;
								} else {
									mespagocuotafin = cuota.mespagocuotafin;
								}

							    var fecha_vencimiento = getFechaImpresion(cuota.fechavencimientomatricula);
								var fecha = new Date();
								var fecha_actual = fecha.getDate() + '/' + (fecha.getMonth() + 1) + '/'
								                 + fecha.getFullYear();
								var mes_actual = (fecha.getMonth() + 1);
								var ano_actual = fecha.getFullYear();

								if (ano_actual > cuota.ciclo_descripcion) {
									tr_cuota = '<tr>';
								} else {
									if (mes_actual > cuota.mespagocuotainicio) {
										tr_cuota = '<tr>';
									} else {
										tr_cuota = '<tr>';
									}
								}

								if (tiene_beca == true) {
									tr_cuota = '<tr class=info>';
								}
							}
						} else {
							tr_cuota = '<tr>';
						}
						
					    if (cuota.beca == 7) {
					    	tiene_beca = false;
					    	tiene_beca_td = '<td><center><a title="Modificar" href="{{url('cuotas/editar')}}/'+cuota.ciclolectivo_id+'-'+cuota.carrera_id+'-'+cuota.alumno_id+'" class="btn default btn-xs purple"><i class="fa fa-edit"></i></a></center></td>';
					    } else {
							tiene_beca = true;
							tiene_beca_td = '<td></td>';
						}

						var saldo = 0;

						var bandera = true;
						var tablacargada = '';
						var tabla = '';
						var mesa = '';
						var detalle_cuotas = cuota.detalle_cuotas.length;

						if (detalle_cuotas > 0) {
							$.each(cuota.detalle_cuotas, function(key, value) {
								if (bandera == true) {
						    		var primermes = value.mescuota;
						    		var primerimporte = value.importe;
						        	var mes = meses[primermes];
									tabla = tr_cuota +
									    '<td>' + apeynom + '</td>' +
									    '<td><center>' + cuota.nrodocumento + '</center></td>';
									bandera = false;
								}

								mesa = value.mescuota;
							});

							var mespagocuotafin = '';

							if (cuota.mespagocuotafin == null) {
								mespagocuotafin = parseInt(meshasta) + 1;//13;
							} else {
								mespagocuotafin = parseInt(meshasta) + 1;//parseInt(cuota.mespagocuotafin) + 1;
							}

							var mesaseguir = parseInt(mesa) + 1;

							if (messelecc > mesaseguir) {
								mesaseguir = messelecc;
								if (parseInt(mesaseguir) == 12) {
									mesaseguir = 14;
								}
							}

							var primerfila = mesaseguir;
							bandera = true;
							var totalde = 0;

							if (cuota.saldo > 0) {
								saldo = cuota.saldo;
								totalmatricula = totalmatricula + parseInt(cuota.saldo);
							}
        					
        					if (mesa == 12) {
        						if (saldo > 0) {
        							if (tablacargada == '') {
			        					tablacargada = tabla +
										    '<td><center>' + saldo + '</center></td>' +
										    '<td><center></center></td>' +
										    '<td><center></center></td>' +
										    '<td><center>' + saldo + '</center></td></tr>';
									} else {
										tablacargada = tablacargada + tabla +
										    '<td><center>' + saldo + '</center></td>' +
										    '<td><center></center></td>' +
										    '<td><center></center></td>' +
										    '<td><center>' + saldo + '</center></td></tr>';
									}

									totaldeuda = totaldeuda + parseInt(saldo);
								}
	        				} else {
								if (parseInt(mesaseguir) < parseInt(mespagocuotafin)) {
									for (i = parseInt(mesaseguir); i < parseInt(mespagocuotafin); i++) {
										mesaseguir = meses[i];
										tr_cuota = '<tr>';

										if (tiene_beca == true) {
											tr_cuota = '<tr class=info>';
											acciones = '';
										} else {
											acciones = '<center><a title="Modificar" href="{{url('cuotas/editar')}}/'+cuota.ciclolectivo_id+'-'+cuota.carrera_id+'-'+cuota.alumno_id+'-'+i+'" class="btn default btn-xs purple"><i class="fa fa-edit"></i></a></center>';
										}

										if (saldo == 0) {
											totalde = cuota.cuotaimporte;
											saldo = '';
										} else {
											totalde = parseInt(saldo) + parseInt(cuota.cuotaimporte);
										}
										
										totalimporte = totalimporte + parseInt(cuota.cuotaimporte);
										totaldeuda = totaldeuda + parseInt(totalde);

										if (tablacargada == '') {
											tablacargada = tabla +
											    '<td><center>' + saldo + '</center></td>' +
											    '<td><center>' + mesaseguir + '</center></td>' +
											    '<td><center>' + cuota.cuotaimporte + '</center></td>';
											if (primerfila == i) {
											    tablacargada = tablacargada + '<td><center>' + totalde + '</center></td></tr>';
											} else {
												tablacargada = tablacargada + '<td><center>' + totalde + '</center></td></tr>';
											}

											bandera = false;
										} else {
											totalde = cuota.cuotaimporte;
											tablacargada = tablacargada + tr_cuota +
											    '<td></td>' +
											    '<td></td>' +
											    '<td></td>' +
											    '<td><center>' + mesaseguir + '</center></td>' +
											    '<td><center>' + cuota.cuotaimporte + '</center></td>';
											if (primerfila == i) {
											    tablacargada = tablacargada + '<td><center>' + totalde + '</center></td></tr>';
											} else {
												tablacargada = tablacargada + '<td><center>' + totalde + '</center></td></tr>';
											}
										}
									}
								}
							}
						} else {
							var mespagocuotainicio = cuota.mespagocuotainicio;

							if (messelecc > mespagocuotainicio) {
								mespagocuotainicio = messelecc;
							}

							var mespagocuotafin = '';

							if (cuota.mespagocuotafin == null) {
								mespagocuotafin = parseInt(meshasta);//13;
							} else {
								mespagocuotafin = parseInt(meshasta);//cuota.mespagocuotafin;
								mespagocuotafin++;

								if (mespagocuotafin > 13) mespagocuotafin = 13;
							}

							if (cuota.saldo > 0) {
								saldo = cuota.saldo;
								totalmatricula = totalmatricula + parseInt(cuota.saldo);
							} else {
								saldo = cuota.saldo;
								totalmatricula = totalmatricula + parseInt(cuota.saldo);
							}

							if (cuota.abonada == 0) {
								saldo = cuota.matriculaimporte;
								totalmatricula = totalmatricula + parseInt(cuota.matriculaimporte);
							}
        				
							for (i = parseInt(mespagocuotainicio); i < parseInt(mespagocuotafin); i++) {
								mes = meses[i];
								
								if (saldo == 0) {
									totalde = cuota.cuotaimporte;
									saldo = '';
								} else {
									if (cuota.abonada == 1) {
										if (bandera == true) {
											totalde = parseInt(saldo) + parseInt(cuota.cuotaimporte);
										} else {
											totalde = parseInt(cuota.cuotaimporte);
										}
									} else {
										if (bandera == true) {
											totalde = parseInt(cuota.matriculaimporte) + parseInt(cuota.cuotaimporte);
										} else {
											totalde = parseInt(cuota.cuotaimporte);
										}
									}
								}
								
								totalimporte = totalimporte + parseInt(cuota.cuotaimporte);
								totaldeuda = totaldeuda + parseInt(totalde);

								if (bandera == true) {
									tabla = tr_cuota +
									    '<td>' + apeynom + '</td>' +
									    '<td><center>' + cuota.nrodocumento + '</center></td>' +
										'<td><center>' + saldo + '</center></td>' +
									    '<td><center>' + mes + '</center></td>' +
									    '<td><center>' + cuota.cuotaimporte + '</center></td>' +
										'<td><center>' + totalde + '</center></td></tr>';
									
									bandera = false;
								} else {
									if (tablacargada == '') {
										tablacargada = tabla + tr_cuota +
										    '<td></td>' +
										    '<td></td>' +
										    '<td></td>' +
										    '<td><center>' + mes + '</center></td>' +
										    '<td><center>' + cuota.cuotaimporte + '</center></td>' +
										    '<td><center>' + totalde + '</center></td>' +
										    '</tr>';
									} else {
										tablacargada = tablacargada + tr_cuota +
										    '<td></td>' +
										    '<td></td>' +
										    '<td></td>' +
										    '<td><center>' + mes + '</center></td>' +
										    '<td><center>' + cuota.cuotaimporte + '</center></td>' +
										    '<td><center>' + totalde + '</center></td>' +
										    '</tr>';
									}
								}
							}
						}


						$('#table_cuotas > tbody').append(tablacargada);
					});

					tablacargadas = '<tr>' +
					    '<td><center><strong>TOTAL</strong></center></td>' +
					    '<td></td>' +
					    '<td><center><strong>$' + totalmatricula.toFixed(2) + '</strong></center></td>' +
					    '<td></td>' +
					    '<td><center><strong>$' + totalimporte.toFixed(2) + '</strong></center></td>' +
					    '<td><center><strong>$' + totaldeuda.toFixed(2) + '</strong></center></td>' +
					    '</tr>';

					$('#table_cuotas > tbody').append(tablacargadas);

				}).error(function(data) {
					console.log(data);
				});
		} else {
			limpiar_tabla();

			/* VALIDACIONES DEL BOTON BUSCAR */
		    if ($.trim($('#txtalumno').val()) == '') {
		    	//alert('Ingrese el dato del Alumno');
		    	$('#divMensaje').html('<p class="form-control-static"><h4>' + 'Ingrese el dato del Alumno!' + '</h4></p>');
	    	    $('#MensajeCantidad').modal('show');
		    	return;
		    }
		    if ($('#cboFiltroAlumno').val() == 2) {
		        if ($.trim($('#txtalumno').val()) == '') {
		    	    //alert('Debe ingresar el DNI del Alumno');
		    	    $('#divMensaje').html('<p class="form-control-static"><h4>' + 'Debe ingresar el DNI del Alumno!' + '</h4></p>');
	    	    	$('#MensajeCantidad').modal('show');
		    	    return;
		    	}
		    	url_destino = "{{url('alumnos/obteneralumnopordni')}}";
		    }

		    /* OBTENGO EL ALUMNO */
			$.ajax({
			  url: url_destino,
			  data:{'txt_alumno': $('#txtalumno').val()},
			  type: 'POST'
			}).done(function(alumno) {
				console.log(alumno);
				if (alumno == <?php echo AlumnosController::NO_EXISTE_ALUMNO ?>) {
					//alert('No se ha encontrado ningún registro');
					$('#divMensaje').html('<p class="form-control-static"><h4>' + 'No se ha encontrado ningun registro!' + '</h4></p>');
	    	    	$('#MensajeCantidad').modal('show');
					return;
			    }
			    var apellido_nombre = alumno.apellido + ', ' + alumno.nombre;
			    var dni = alumno.nrodocumento;
			    var domicilio = alumno.calle + ' ' + alumno.numero + ' (' + alumno.localidad + ', ' + alumno.provincia + ')';
			    
			    $('#alumno_id').val(alumno.alumno_id);
			    var alumno_id = alumno.alumno_id;
			    $('#txt_persona_id').val(alumno.persona_id);
			    $('#txt_persona_id_verInfo').val(alumno.persona_id);

			    $.ajax({
				  url: '{{url('cuotas/obtenerdeudaporalumno')}}',
				  data:{'alumno_id': alumno_id, 'ciclo': ciclo, 'carrera': carrera},
				  type: 'POST'
				}).done(function(cuotas) {
					console.log(cuotas);
				
					if (cuotas.length == 0) {
						$("#imprimir").attr('disabled', 'disabled');
					} else {
						$("#imprimir").removeAttr("disabled");
					}

					var totalimporte = 0;
					var totaldeuda = 0;
					var tablacargadas = '';
					var totalmatricula = 0;
					var fechahasta = $('#fechahasta').val();
					var elem = fechahasta.split("-");
					var meshasta = elem[1];
					var saldo = 0;

				    $.each(cuotas, function(key, cuota) {
						ya_pago_cuota = false;
			    		tiene_beca = false;
			    		var tiene_beca_td = '';
			    		tr_cuota = '';

					    if (cuota.beca == 7) {
					    	tiene_beca = false;
					    	tiene_beca_td = '<td><center><a title="Modificar" href="{{url('cuotas/editar')}}/'+cuota.ciclolectivo_id+'-'+cuota.carrera_id+'-'+cuota.alumno_id+'" class="btn default btn-xs purple"><i class="fa fa-edit"></i></a></center></td>';
					    } else {
							tiene_beca = true;
							tiene_beca_td = '<td></td>';
						}
        				
        				var apeynom = cuota.apellido + ', ' + cuota.nombre;
						
						if (cuota.cuotaaplica == 1) {
							var meses = ["S/D", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

							$.each(cuota.detalle_cuotas, function(key, value) {
							    if (value.estado == 1) {
									ya_pago_cuota = true;
							    }
							});

							if (ya_pago_cuota) {
								tr_cuota = '<tr>';
							} else {
								var mespagocuotafin = '';

								if (cuota.mespagocuotafin == null) {
									mespagocuotafin = 13;
								} else {
									mespagocuotafin = cuota.mespagocuotafin;
								}

							    var fecha_vencimiento = getFechaImpresion(cuota.fechavencimientomatricula);
								var fecha = new Date();
								var fecha_actual = fecha.getDate() + '/' + (fecha.getMonth() + 1) + '/'
								                 + fecha.getFullYear();
								var mes_actual = (fecha.getMonth() + 1);
								var ano_actual = fecha.getFullYear();

								if (ano_actual == cuota.ciclo_descripcion) {
									tr_cuota = '<tr>';
									if (cuota.mespagocuotainicio > mes_actual) {
										tr_cuota = '<tr>';
									} else {
										tr_cuota = '<tr>';
									}
								}

								if (ano_actual > cuota.ciclo_descripcion) {
									tr_cuota = '<tr>';
								} else {
									if (mes_actual > cuota.mespagocuotainicio) {
										tr_cuota = '<tr>';
									} else {
										tr_cuota = '<tr>';
									}
								}

								if (tiene_beca == true) {
									tr_cuota = '<tr class=info>';
								}
							}
						} else {
							tr_cuota = '<tr>';
						}
						
					    if (cuota.beca == 7) {
					    	tiene_beca = false;
					    	tiene_beca_td = '<td><center><a title="Modificar" href="{{url('cuotas/editar')}}/'+cuota.ciclolectivo_id+'-'+cuota.carrera_id+'-'+cuota.alumno_id+'" class="btn default btn-xs purple"><i class="fa fa-edit"></i></a></center></td>';
					    } else {
							tiene_beca = true;
							tiene_beca_td = '<td></td>';
							tr_cuota = '<tr class=info>';
						}

						if (cuota.saldo > 0) {
							saldo = cuota.saldo;
							totalmatricula = totalmatricula + parseInt(cuota.saldo);
						}
        				
						var bandera = true;
						var tablacargada = '';
						var tabla = '';
						var mesa = '';

						if (cuota.detalle_cuotas) {
							$.each(cuota.detalle_cuotas, function(key, value) {
								if (bandera == true) {
						    		var primermes = value.mescuota;
						    		var primerimporte = value.importe;
						        	var mes = meses[primermes];
									tabla = tr_cuota +
									    '<td>' + apeynom + '</td>' +
									    '<td><center>' + cuota.nrodocumento + '</center></td>';
									bandera = false;
								}

								mesa = value.mescuota;
							});

							var mespagocuotafin = '';

							if (cuota.mespagocuotafin == null) {
								mespagocuotafin = parseInt(meshasta) + 1;//13;
							} else {
								mespagocuotafin = parseInt(meshasta) + 1;//parseInt(cuota.mespagocuotafin) + 1;
							}

							var mesaseguir = parseInt(mesa) + 1;

							if (parseInt(mesaseguir) == 12) {
								mesaseguir = 14;
							}

							var primerfila = mesaseguir;
							bandera = true;

        					if (mesa == 12) {
        						if (saldo > 0) {
        							if (tablacargada == '') {
			        					tablacargada = tabla +
										    '<td><center>' + saldo + '</center></td>' +
										    '<td><center></center></td>' +
										    '<td><center></center></td>' +
										    '<td><center>' + saldo + '</center></td></tr>';
									} else {
										tablacargada = tablacargada + tabla +
										    '<td><center>' + saldo + '</center></td>' +
										    '<td><center></center></td>' +
										    '<td><center></center></td>' +
										    '<td><center>' + saldo + '</center></td></tr>';
									}

									totaldeuda = totaldeuda + parseInt(saldo);
								}
	        				} else {
								if (parseInt(mesaseguir) < parseInt(mespagocuotafin)) {
									for (i = parseInt(mesaseguir); i < parseInt(mespagocuotafin); i++) {
										mesaseguir = meses[i];
										tr_cuota = '<tr>';

										if (saldo == 0) {
											totalde = cuota.cuotaimporte;
											saldo = '';
											totalimporte = totalimporte + parseInt(cuota.cuotaimporte);
											totaldeuda = totaldeuda + parseInt(totalde);
										} else {
											totalde = parseInt(saldo) + parseInt(cuota.cuotaimporte);
											totalimporte = totalimporte + parseInt(cuota.cuotaimporte);
											totaldeuda = totaldeuda + parseInt(totalde);
										}
											
										if (tablacargada == '') {
											tablacargada = tabla +
											    '<td><center>' + saldo + '</center></td>' +
											    '<td><center>' + mesaseguir + '</center></td>' +
											    '<td><center>' + cuota.cuotaimporte + '</center></td>';
											if (primerfila == i) {
											    tablacargada = tablacargada + '<td><center>' + totalde + '</center></td>' +
											    '</tr>';
											} else {
												tablacargada = tablacargada + '<td><center>' + totalde + '</center></td></tr>';
											}

											bandera = false;
										} else {
											totalde = cuota.cuotaimporte;
											tablacargada = tablacargada + tr_cuota +
											    '<td></td>' +
											    '<td></td>' +
											    '<td></td>' +
											    '<td><center>' + mesaseguir + '</center></td>' +
											    '<td><center>' + cuota.cuotaimporte + '</center></td>';
											if (primerfila == i) {
											    tablacargada = tablacargada + '<td><center>' + totalde + '</center></td>' +
											    '</tr>';
											} else {
												tablacargada = tablacargada + '<td><center>' + totalde + '</center></td></tr>';
											}
										}
									}
								}
							}
						} else {
							var mespagocuotainicio = cuota.mespagocuotainicio;

							var mespagocuotafin = '';

							if (cuota.mespagocuotafin == null) {
								mespagocuotafin = parseInt(meshasta) + 1;//13;
							} else {
								mespagocuotafin = parseInt(meshasta) + 1;//cuota.mespagocuotafin;
								mespagocuotafin++;

								if (mespagocuotafin > 13) mespagocuotafin = 13;
							}
							
							var mescuotainicio = cuota.mespagocuotainicio;

							if (cuota.abonada == 0) {
								saldo = cuota.matriculaimporte;
								totalmatricula = totalmatricula + parseInt(cuota.matriculaimporte);
							}
        				
							for (i = parseInt(mescuotainicio); i < parseInt(mespagocuotafin); i++) {
								if (saldo == 0) {
									totalde = cuota.cuotaimporte;
									saldo = '';
								} else {
									if (cuota.abonada == 1) {
										if (bandera == true) {
											totalde = parseInt(saldo) + parseInt(cuota.cuotaimporte);
										} else {
											totalde = parseInt(cuota.cuotaimporte);
										}
									} else {
										if (bandera == true) {
											totalde = parseInt(cuota.matriculaimporte) + parseInt(cuota.cuotaimporte);
										} else {
											totalde = parseInt(cuota.cuotaimporte);
										}
									}
								}
								
								totalimporte = totalimporte + parseInt(cuota.cuotaimporte);
								totaldeuda = totaldeuda + parseInt(totalde);
						
								mes = meses[i];
								if (bandera == true) {
									tabla = tr_cuota +
									    '<td>' + apeynom + '</td>' +
									    '<td><center>' + cuota.nrodocumento + '</center></td>' +
										'<td><center>' + saldo + '</center></td>' +
									    '<td><center>' + mes + '</center></td>' +
									    '<td><center>' + cuota.cuotaimporte + '</center></td>' +
									    '<td><center>' + totalde + '</center></td>' +
									    '</tr>';
									bandera = false;
								} else {
									if (tablacargada == '') {
										tablacargada = tabla + tr_cuota +
										    '<td></td>' +
										    '<td></td>' +
										    '<td></td>' +
										    '<td><center>' + mes + '</center></td>' +
										    '<td><center>' + cuota.cuotaimporte + '</center></td>' +
										    '<td><center>' + totalde + '</center></td>' +
										    '</tr>';
									} else {
										tablacargada = tablacargada + tr_cuota +
										    '<td></td>' +
										    '<td></td>' +
										    '<td></td>' +
										    '<td><center>' + mes + '</center></td>' +
										    '<td><center>' + cuota.cuotaimporte + '</center></td>' +
										    '<td><center>' + totalde + '</center></td>' +
										    '</tr>';
									}
								}
							}
						}

						$('#table_cuotas > tbody').append(tablacargada);
					});

					totaldeuda = totalimporte + parseInt(totalmatricula);
				    
					tablacargadas = '<tr>' +
					    '<td><center><strong>TOTAL</strong></center></td>' +
					    '<td></td>' +
					    '<td><center><strong>$' + totalmatricula + '</strong></center></td>' +
					    '<td></td>' +
					    '<td><center><strong>$' + totalimporte + '</strong></center></td>' +
					    '<td><center><strong>$' + totaldeuda + '</strong></center></td>' +
					    '</tr>';

					$('#table_cuotas > tbody').append(tablacargadas);

				}).error(function(data) {
					console.log(data);
				});

			}).error(function(data) {
				console.log(data);
			});
		}
		$("#imprimir").removeAttr("disabled");
    });

    $('#cboCarrera').change(function() {

    	limpiar_tabla();

        if ($('#cboCarrera').val() == 0) return;

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

    $('#cboOrganizacion').change(function() {
    	// 1 - limpiar todo

    	limpiar_tabla();
		$('#cboCiclo').children().remove().end();
		$('#cboCarrera').children().remove().end();

		if ($('#cboOrganizacion').val() == 0) return;

		$.ajax({
		  url: '{{url('ciclolectivo/obtenercicloslectivos')}}',
		  data:{'organizacion_id': $('#cboOrganizacion').val()},
		  type: 'POST'
		}).done(function(ciclos) {
			console.log(ciclos);
			if (ciclos == <?php echo CicloLectivoController::NO_EXISTE_CICLO ?>) {
				//alert('La Organización no tiene Ciclos Lectivos Asignados');
				$('#divMensaje').html('<p class="form-control-static"><h4>' + 'La Organización no tiene Ciclos Lectivos Asignados' + '</h4></p>');
	    	    $('#MensajeCantidad').modal('show');
				return;
		    }

			$('#cboCiclo').append(
		        $('<option></option>').val(0).html('Seleccionar')
		    );

			$.each(ciclos, function(key, value) {
				$('#cboCiclo').append(
			        $('<option></option>').val(value.id).html(value.descripcion)
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


	$(document).ready(function(){
 
		$('.ir-arriba').click(function(){
			$('body, html').animate({
				scrollTop: '0px'
			}, 300);
		});
	 
		$(window).scroll(function(){
			if( $(this).scrollTop() > 0 ){
				$('.ir-arriba').slideDown(300);
			} else {
				$('.ir-arriba').slideUp(300);
			}
		});
	 
	});

	$('div.alert').not('.alert-important').delay(3000).fadeOut(350) 

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
