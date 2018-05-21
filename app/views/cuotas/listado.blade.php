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
					Cuotas <small>Consulta de Cuotas</small>
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
								<i class="fa fa-files-o"></i>Listado de Cuotas
							</div>
							<div class="actions">
								<a href="{{url('cuotas/pagar')}}" {{$disabled}} class="btn default blue-stripe">
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Pagar </span>
								</a>
								<a target="_blank" href="#" id="imprimir" {{$imprimir}} class="btn default yellow-stripe">
								<i class="fa fa-print"></i>
								<span class="hidden-480">
								Imprimir </span>
								</a>								
							</div>
						</div>
						<div class="portlet-body form">
							<div class="form-body">
								{{ Form::open(array('url'=>'cuotas/listadoalumnos', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmListadoalumnos', 'name'=>'FrmListadoalumnos'))}}
								<div class="form-group">
									<label  class="col-md-2 col-sm-2 control-label">Organización:</label>
									<div class="col-md-6 col-sm-6">
										{{ Form::select('cboOrganizacion', $organizaciones, Input::old('organizacion'), array('class'=>'table-group-action-input form-control','id'=>'cboOrganizacion')); }}
									</div>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<center>
											<p><span class="text-success"><i class="fa fa-check"></i></span> Pagado - <span class="text-danger"><i class="fa fa-exclamation-triangle"></i></span> Adeuda - <span class="text-info"><i class="fa fa-asterisk"></i></span> Becado</p>
										</center>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 col-sm-2 control-label" for="filtro">Ciclo Lectivo:</label>
									<div class="col-md-2 col-sm-3">
										<select name="cboCiclo" id="cboCiclo" class="table-group-action-input form-control">
										</select>
									</div>

									<!--<label class="col-md-2 col-sm-3 control-label" for="filtro">Período Lectivo:</label>
									<div class="col-md-2 col-sm-4">
										<select name="cboperiodo" id="cboperiodo" class="table-group-action-input form-control">
											<option value="1">Opcion 1</option>
											<option value="2">Opcion 2</option>
										</select>
									</div>-->

								</div>

								<div class="form-group">
									<label class="col-md-2 col-sm-2 control-label" for="cbocarrera">Carrera:</label>
									<div class="col-md-6 col-sm-6">
										<select name="cboCarrera" id="cboCarrera" class="table-group-action-input form-control">
										</select>
									</div>
									<!--div class="col-md-2 col-sm-2">
										<a class="btn btn-primary" id='btnBuscar'><i class="fa fa-search"></i> Buscar</a>
									</div-->
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
												<center>Cuota</center>
											</th>
											<th>
												<center>Total</center>
											</th>
											<th>
												<center>Acciones</center>
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
		window.open("{{url('cuotas/imprimir')}}?organizacion_id=" + $('#cboOrganizacion').val() + '&carrera_id=' + $('#cboCarrera').val() + '&ciclo_id=' + $('#cboCiclo').val() + '&alumno_id=' + $('#alumno_id').val());
	});

    $('#btnBuscar').click(function() {
    	var ciclo = $('#cboCiclo').val();
    	var carrera = $('#cboCarrera').val();

    	if ($('#cboFiltroAlumno').val() == 1) {
			var class_matricula = '';
			var td_cuota = '';

	    	var organizacion = $('#cboOrganizacion').val();

	    	if (organizacion == 0 || carrera == 0 || ciclo == 0) {
	    	    //alert('Debe seleccionar todos los datos a buscar');
	    	    $('#divMensaje').html('<p class="form-control-static"><h4>' + 'Debe seleccionar todos los datos a buscar' + '</h4></p>');
	    	    $('#MensajeCantidad').modal('show');
	    	    return;
	    	}

	    	limpiar_tabla();

				$.ajax({
				  url: '{{url('cuotas/obtenercuotaporcarrerayciclo')}}',
				  data:{'organizacion': organizacion, 'ciclo': ciclo, 'carrera': carrera},
				  type: 'POST'
				}).done(function(cuotas) {
					console.log(cuotas);

					if (cuotas.length == 0) {
						$("#imprimir").attr('disabled', 'disabled');
					} else {
						$("#imprimir").removeAttr("disabled");
					}

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
								tr_cuota = '<tr class=success>';
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
									tr_cuota = '<tr class=danger>';
								} else {
									if (mes_actual > cuota.mespagocuotainicio) {
										tr_cuota = '<tr class=danger>';
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
        				
						var bandera = true;
						var tablacargada = '';
						var tabla = '';
						var mesa = '';
						var detalle_cuotas = cuota.detalle_cuotas.length;

						if (detalle_cuotas > 0) {
							$.each(cuota.detalle_cuotas, function(key, value) {
								if (tiene_beca == true) {
									tr_cuota = '<tr class=info>';
									acciones = '';
								} else {
									acciones = '<center><a title="Modificar" href="{{url('cuotas/editarpago')}}/'+value.pago_id+'" class="btn default btn-xs purple"><i class="fa fa-edit"></i></a><a target="_blank" href="{{url('cuotas/imprimirrecibo')}}?txt_pago_id='+value.pago_id+'" data-id="" class="btn default btn-xs red"><i title="Imprimir" class="glyphicon glyphicon-print"></i></a></center>';
								}

								if (bandera == true) {
						    		var primermes = value.mescuota;
						    		var primerimporte = value.importe;
						        	var mes = meses[primermes];
									tabla = tr_cuota +
									    '<td>' + apeynom + '</td>' +
									    '<td>' + cuota.nrodocumento + '</td>' +
									    '<td>' + mes + '</td>' +
									    '<td>' + primerimporte + '</td>' +
									    '<td>' + acciones + '</td>' +
									    '</tr>';
									bandera = false;
								} else {
									if (tablacargada == '') {
						        		mes = meses[value.mescuota];
										tablacargada = tabla + tr_cuota +
										    '<td></td>' +
										    '<td></td>' +
										    '<td>' + mes + '</td>' +
										    '<td>' + value.importe + '</td>' +
										    '<td>' + acciones + '</td>' +
										    '</tr>';
									} else {
						        		mes = meses[value.mescuota];
										tablacargada = tablacargada + tr_cuota +
										    '<td></td>' +
										    '<td></td>' +
										    '<td>' + mes + '</td>' +
										    '<td>' + value.importe + '</td>' +
										    '<td>' + acciones + '</td>' +
										    '</tr>';
									}
								}

								mesa = value.mescuota;
							});

							var mespagocuotafin = '';

							if (cuota.mespagocuotafin == null) {
								mespagocuotafin = 13;
							} else {
								mespagocuotafin = parseInt(cuota.mespagocuotafin) + 1;
							}

							var mesaseguir = parseInt(mesa) + 1;

							if (parseInt(mesaseguir) == 12) {
								mesaseguir = 14;
							}

							var primerfila = mesaseguir;
							bandera = true;

							if (parseInt(mesaseguir) < parseInt(mespagocuotafin)) {
								for (i = parseInt(mesaseguir); i < parseInt(mespagocuotafin); i++) {
									mesaseguir = meses[i];
									tr_cuota = '<tr class=danger>';

									if (tiene_beca == true) {
										tr_cuota = '<tr class=info>';
										acciones = '';
									} else {
										acciones = '<center><a title="Modificar" href="{{url('cuotas/editar')}}/'+cuota.ciclolectivo_id+'-'+cuota.carrera_id+'-'+cuota.alumno_id+'-'+i+'" class="btn default btn-xs purple"><i class="fa fa-edit"></i></a></center>';
									}

									if (tablacargada == '') {
										tablacargada = tabla + tr_cuota +
										    '<td></td>' +
										    '<td></td>' +
										    '<td>' + mesaseguir + '</td>' +
										    '<td>' + cuota.cuotaimporte + '</td>';
										if (primerfila == i) {
										    tablacargada = tablacargada + '<td>' + acciones + '</td>' +
										    '</tr>';
										} else {
											tablacargada = tablacargada + '<td></td></tr>';
										}

										bandera = false;
									} else {
										tablacargada = tablacargada + tr_cuota +
										    '<td></td>' +
										    '<td></td>' +
										    '<td>' + mesaseguir + '</td>' +
										    '<td>' + cuota.cuotaimporte + '</td>';
										if (primerfila == i) {
										    tablacargada = tablacargada + '<td>' + acciones + '</td>' +
										    '</tr>';
										} else {
											tablacargada = tablacargada + '<td></td></tr>';
										}
									}
								}
							}
						} else {
							var mespagocuotainicio = cuota.mespagocuotainicio;

							var mespagocuotafin = '';

							if (cuota.mespagocuotafin == null) {
								mespagocuotafin = 13;
							} else {
								mespagocuotafin = cuota.mespagocuotafin;
								mespagocuotafin++;

								if (mespagocuotafin > 13) mespagocuotafin = 13;
							}

							for (i = parseInt(mespagocuotainicio); i < parseInt(mespagocuotafin); i++) {
								mes = meses[i];
								
								if (tiene_beca == true) {
									tr_cuota = '<tr class=info>';
									acciones = '';
								} else {
									acciones = '<center><a title="Modificar" href="{{url('cuotas/editar')}}/'+cuota.ciclolectivo_id+'-'+cuota.carrera_id+'-'+cuota.alumno_id+'-'+i+'" class="btn default btn-xs purple"><i class="fa fa-edit"></i></a></center>';
								}

								if (bandera == true) {
									tabla = tr_cuota +
									    '<td>' + apeynom + '</td>' +
									    '<td>' + cuota.nrodocumento + '</td>' +
									    '<td>' + mes + '</td>' +
									    '<td>' + cuota.cuotaimporte + '</td>';
									if (tiene_beca == true) {
										tr_final = '<td></td></tr>';
										tabla = tabla + tr_final;
									} else {
										tr_final = '<td>' + acciones + '</td></tr>';
										tabla = tabla + tr_final;
									}
									bandera = false;
								} else {
									if (tablacargada == '') {
										tablacargada = tabla + tr_cuota +
										    '<td></td>' +
										    '<td></td>' +
										    '<td>' + mes + '</td>' +
										    '<td>' + cuota.cuotaimporte + '</td>' +
										    '<td></td>' +
										    '</tr>';
									} else {
										tablacargada = tablacargada + tr_cuota +
										    '<td></td>' +
										    '<td></td>' +
										    '<td>' + mes + '</td>' +
										    '<td>' + cuota.cuotaimporte + '</td>' +
										    '<td></td>' +
										    '</tr>';
									}
								}
							}
						}

						$('#table_cuotas > tbody').append(tablacargada);
					});

				}).error(function(data) {
					console.log(data);
				});

			$('#imprimir').removeAttr("disabled");
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
				  url: '{{url('cuotas/obtenercuotaporalumno')}}',
				  data:{'alumno_id': alumno_id, 'ciclo': ciclo, 'carrera': carrera},
				  type: 'POST'
				}).done(function(cuotas) {
					console.log(cuotas);
				
					if (cuotas.length == 0) {
						$("#imprimir").attr('disabled', 'disabled');
					} else {
						$("#imprimir").removeAttr("disabled");
					}

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
								tr_cuota = '<tr class=success>';
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
										tr_cuota = '<tr class=danger>';
									} else {
										tr_cuota = '<tr>';
									}
								}

								if (ano_actual > cuota.ciclo_descripcion) {
									tr_cuota = '<tr class=danger>';
								} else {
									if (mes_actual > cuota.mespagocuotainicio) {
										tr_cuota = '<tr class=danger>';
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

						var bandera = true;
						var tablacargada = '';
						var tabla = '';
						var mesa = '';
						if (cuota.detalle_cuotas) {
							$.each(cuota.detalle_cuotas, function(key, value) {
								if (tiene_beca == true) {
									tr_cuota = '<tr class=info>';
									acciones = '';
								} else {
									acciones = '<center><a title="Modificar" href="{{url('cuotas/editarpago')}}/'+value.pago_id+'" class="btn default btn-xs purple"><i class="fa fa-edit"></i></a><a target="_blank" href="{{url('cuotas/imprimirrecibo')}}?txt_pago_id='+value.pago_id+'" data-id="" class="btn default btn-xs red"><i title="Imprimir" class="glyphicon glyphicon-print"></i></a></center>';
								}

								if (bandera == true) {
						    		var primermes = value.mescuota;
						    		var primerimporte = value.importe;
						        	var mes = meses[primermes];
									tabla = tr_cuota +
									    '<td>' + apeynom + '</td>' +
									    '<td>' + cuota.nrodocumento + '</td>' +
									    '<td>' + mes + '</td>' +
									    '<td>' + primerimporte + '</td>' +
									    '<td>' + acciones + '</td>' +
									    '</tr>';
									bandera = false;
								} else {
									if (tablacargada == '') {
						        		mes = meses[value.mescuota];
										tablacargada = tabla + tr_cuota +
										    '<td></td>' +
										    '<td></td>' +
										    '<td>' + mes + '</td>' +
										    '<td>' + value.importe + '</td>' +
										    '<td>' + acciones + '</td>' +
										    '</tr>';
									} else {
						        		mes = meses[value.mescuota];
										tablacargada = tablacargada + tr_cuota +
										    '<td></td>' +
										    '<td></td>' +
										    '<td>' + mes + '</td>' +
										    '<td>' + value.importe + '</td>' +
										    '<td>' + acciones + '</td>' +
										    '</tr>';
									}
								}

								mesa = value.mescuota;
							});

							var mespagocuotafin = '';

							if (cuota.mespagocuotafin == null) {
								mespagocuotafin = 13;
							} else {
								mespagocuotafin = parseInt(cuota.mespagocuotafin) + 1;
							}

							var mesaseguir = parseInt(mesa) + 1;

							if (parseInt(mesaseguir) == 12) {
								mesaseguir = 14;
							}

							var primerfila = mesaseguir;
							bandera = true;

							if (parseInt(mesaseguir) < parseInt(mespagocuotafin)) {
								for (i = parseInt(mesaseguir); i < parseInt(mespagocuotafin); i++) {
									mesaseguir = meses[i];
									tr_cuota = '<tr class=danger>';

									if (tiene_beca == true) {
										tr_cuota = '<tr class=info>';
										acciones = '';
									} else {
										acciones = '<center><a title="Modificar" href="{{url('cuotas/editar')}}/'+cuota.ciclolectivo_id+'-'+cuota.carrera_id+'-'+alumno_id+'-'+i+'" class="btn default btn-xs purple"><i class="fa fa-edit"></i></a></center>';
									}

									if (tablacargada == '') {
										tablacargada = tabla + tr_cuota +
										    '<td></td>' +
										    '<td></td>' +
										    '<td>' + mesaseguir + '</td>' +
										    '<td>' + cuota.cuotaimporte + '</td>';
										if (primerfila == i) {
										    tablacargada = tablacargada + '<td>' + acciones + '</td>' +
										    '</tr>';
										} else {
											tablacargada = tablacargada + '<td></td></tr>';
										}

										bandera = false;
									} else {
										tablacargada = tablacargada + tr_cuota +
										    '<td></td>' +
										    '<td></td>' +
										    '<td>' + mesaseguir + '</td>' +
										    '<td>' + cuota.cuotaimporte + '</td>';
										if (primerfila == i) {
										    tablacargada = tablacargada + '<td>' + acciones + '</td>' +
										    '</tr>';
										} else {
											tablacargada = tablacargada + '<td></td></tr>';
										}
									}
								}
							}
						} else {
							var mespagocuotainicio = cuota.mespagocuotainicio;

							var mespagocuotafin = '';

							if (cuota.mespagocuotafin == null) {
								mespagocuotafin = 13;
							} else {
								mespagocuotafin = cuota.mespagocuotafin;
								mespagocuotafin++;

								if (mespagocuotafin > 13) mespagocuotafin = 13;
							}
							
							var mescuotainicio = cuota.mespagocuotainicio;
							for (i = parseInt(mescuotainicio); i < parseInt(mespagocuotafin); i++) {
								if (tiene_beca == true) {
									tr_cuota = '<tr class=info>';
									acciones = '';
								} else {
									acciones = '<center><a title="Modificar" href="{{url('cuotas/editar')}}/'+cuota.ciclolectivo_id+'-'+cuota.carrera_id+'-'+alumno_id+'-'+i+'" class="btn default btn-xs purple"><i class="fa fa-edit"></i></a></center>';
								}

								mes = meses[i];
								if (bandera == true) {
									tabla = tr_cuota +
									    '<td>' + apeynom + '</td>' +
									    '<td>' + cuota.nrodocumento + '</td>' +
									    '<td>' + mes + '</td>' +
									    '<td>' + cuota.cuotaimporte + '</td>' +
									    '<td>' + acciones + '</td>' +
									    '</tr>';
									bandera = false;
								} else {
									if (tablacargada == '') {
										tablacargada = tabla + tr_cuota +
										    '<td></td>' +
										    '<td></td>' +
										    '<td>' + mes + '</td>' +
										    '<td>' + cuota.cuotaimporte + '</td>' +
										    '<td></td>' +
										    '</tr>';
									} else {
										tablacargada = tablacargada + tr_cuota +
										    '<td></td>' +
										    '<td></td>' +
										    '<td>' + mes + '</td>' +
										    '<td>' + cuota.cuotaimporte + '</td>' +
										    '<td></td>' +
										    '</tr>';
									}
								}
							}
						}

						$('#table_cuotas > tbody').append(tablacargada);
					});
				    
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
