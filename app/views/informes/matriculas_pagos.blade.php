
@extends('layouts.master')

@section('customstyle')
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/select2/select2.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css')}}"/>
@stop
<?php
//BOTONES Y CAMPOS DE PERMISOS
$disabled 	= (!$editar) ? 'disabled' : '';
$readonly 	= (!$editar) ? 'readonly' : '';
$imprimir 	= (!$imprimir) ? 'disabled' : '';
$orgId 		= (isset($OrgID)) ? $OrgID : 0;
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
					Informes <small>pago de matrícula (pdf)</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('informes/matriculas')}}">Informes</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">Matrículas</a>
						</li>
					</ul>
					<!-- FIN DE TITULO & BREADCRUMB-->
				</div>
			</div>
			<!-- FIN DE HEADER-->
			<!-- COMIENZO DEL CONTENIDO-->
			<div class="row">
				<div class="col-md-12">
					<!-- COMIENZO DE LA TABLA-->
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-users"></i>Pagos de Matrículas
							</div>
							<div class="actions">
								<!--a href="{{url('alumnos/crear')}}" @if (!$editar) {{'DISABLED'}} @endif class="btn default blue-stripe" >
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Nuevo</span>
								</a-->
								<a target="_blank" href="#" id="imprimir" class="btn default yellow-stripe" <?php if (!$habilita) echo "disabled"; ?>>
								<i class="fa fa-print"></i>
								<span class="hidden-480">
								Imprimir </span>
								</a>

							</div >

						</div>
						<div class="portlet-body">
							<div class="form-body">
								<form method="POST" action="{{url('matriculas/informelistado')}}" class="form-horizontal form-row-seperated" id="FrmPlaneslistados" name="">
								<div class="form-group">
									<label  class="col-md-2 col-sm-2 control-label" for="organizacion">Organización:</label>
									<div class="col-md-6 col-sm-10">
										{{ Form::select('cboOrganizacion', $organizaciones, Input::old('cboOrganizacion'), array('class'=>'table-group-action-input form-control','id'=>'cboOrganizacion')) }}
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 col-sm-2 control-label" for="filtro">Ciclo Lectivo:</label>
									<div class="col-md-2 col-sm-3">
										<!--select name="cboCiclo" id="cboCiclo" class="table-group-action-input form-control">
										</select-->
										@if (isset($ciclos))
											<select class="table-group-action-input form-control" name="cboCiclo" id="cboCiclo">
												<option value="0" disabled selected>Seleccionar</option><?php
												foreach ($ciclos as $ciclo) { ?>
													<option value="{{$ciclo->id}}" <?php if($ciclo->id == $ciclo_id) { echo "selected=selected";}?>>
														{{$ciclo->descripcion}}
													</option>
												<?php } ?>
											</select>
										@else
											<select class="table-group-action-input form-control" name="cboCiclo" id="cboCiclo">
												<option selected value="0">Seleccione</option>
											</select>
										@endif
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 col-sm-2 control-label" for="filtro">Carreras:</label>
									<div class="col-md-6 col-sm-10">
										<!--select name="cboCarreras" id="cboCarreras" class="table-group-action-input form-control">
										</select-->
										@if (isset($carreras))
											<select class="table-group-action-input form-control" name="carrera" id="carrera">
												<option value="0" disabled selected>Seleccionar</option><?php
												foreach ($carreras as $carrera) { ?>
													<option value="{{$carrera->carrera_id}}" <?php if($carrera->carrera_id == $carrID) { echo "selected=selected";}?>>
														{{$carrera->carrera}}
													</option>
												<?php } ?>
											</select>
										@else
											<select class="table-group-action-input form-control" name="carrera" id="carrera">
												<!--option selected value="0">Seleccione</option-->
											</select>
										@endif
									</div>
									<div class="col-md-2 col-sm-2">
										<button class="btn btn-primary" type="submit">
											<i class="fa fa-search"></i> Buscar
										</button>
									</div>
									
									<div id="divbtnImprimir" class="col-md-2 col-sm-2">
										<a target="_blank" href="#" id="imprimir" class="btn btn-success"><i class="fa fa-print"></i> Imprimir</a>
									</div>
								</div>

								<div class='form-group'>
									<label class="col-md-2 col-sm-2 control-label" for="filtro">Filtrar por:</label>
									<div class="col-md-2 col-sm-3">
										<select name="cboFiltros" id="cboFiltros" class="table-group-action-input form-control">
											<option value='0'>Todos</option>
											<option value='1'>DNI</option>
											<option value='2'>Apellido</option>
										</select>
									</div>
									<div class="col-md-4 col-sm-7">
										<input type='text' name="txtFiltro" id="txtFiltro" class="table-group-action-input form-control"<?php if (!$habilita) echo "disabled"; ?>>
									</div>
									<div class="col-md-2 col-sm-2">
										<button class="btn btn-primary" type="button" id='btnFiltrar'>
											<i class="fa fa-search"></i> Filtrar
										</button>
									</div>

									<div id="divbtnImprimirFiltrar" class="col-md-2 col-sm-2">
										<a target="_blank" href="#" id="imprimir_filtrar" class="btn btn-success"><i class="fa fa-print"></i> Imprimir</a>
									</div>
								</div>
								</form>
								<br>

								<table class="table table-striped table-bordered table-hover" id="table_informesmatricula">
									<thead>
										<tr>
											<th><center>Apellido y Nombre</center></th>
											<th><center>DNI</center></th>
											<!--th><center>Carrera</center></th>
											<th><center>Ciclo Lectivo</center></th-->
											<th><center>Monto ($)</center></th>
											<th><center>Pagado ($)</center></th>
											<th><center>Fecha Vto.</center></th>
											<th><center>Fecha Pago</center></th>
										</tr>
									</thead>
									<tbody>
									@if (isset($matricula))
										@foreach ($matricula as $matricul)
											<?php
											    if ($matricul->matriculaaplica == '1') {
											    	$fecha_vencimiento = $matricul->fechavencimientomatricula;

												    if ($matricul->pago == '8') {
												        $fecha_pago = '';
												        $pagado = "<i class='fa fa-times text-danger'></i>";
													} else {
														$fecha_pago = FechaHelper::getFechaImpresion($matricul->pago->fechapago);

														if ($matricul->pago->importeparcial == NULL) {
															$monto = $matricul->pago->importe;
														} else {
															$monto = $matricul->pago->importeparcial;
														}
												    	
												    	$porcentajerecargo = $matricul->pago->porcentajerecargo;
												    	$porcentajedescuento = $matricul->pago->porcentajedescuento;
														
												    	$recargo = 0;
												    	$descuento = 0;

												    	if (!$porcentajerecargo == null) {
												    		$recargo = ($monto * $porcentajerecargo) / 100;
												    	}

												    	if (!$porcentajedescuento == null) {
												    		$descuento = ($monto * $porcentajedescuento) / 100;
												    	}

												    	$pagado = $monto + $recargo - $descuento;
												    }
											    } else {
											        $fecha_vencimiento = '';
											        $fecha_pago = '';
											        $pagado = '';
												}

												//echo $td_matricula;
											?>
											<tr>
												<td>
													<center>
														{{ $matricul->apellido }}, {{ $matricul->nombre }}
													</center>
												</td>
												<td>
													<center>
														{{ $matricul->nrodocumento }}
													</center>
												</td>
												<td>
													<center>
														{{ $matricul->matriculaimporte }}
													</center>
												</td>
												<td>
													<center>
														{{ $pagado }}
													</center>
												</td>
												<td>
													<center>
														{{ $fecha_vencimiento }}
													</center>
												</td>
												<td>
													<center>
														{{ $fecha_pago }}
													</center>
												</td>
											</tr>
											
										@endforeach
											
									@endif
									</tbody>
								</table>
							</div>			
						</div>
					</div>
					<!-- FIN DE LA TABLA-->

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
			<!-- FIN DEL CONTENIDO -->
		</div>
	</div>
	<!-- FIN -->
@stop


@section('customjs')
	TableAdvanced.init();

	$('#divbtnImprimir').hide();
	$('#divbtnImprimirFiltrar').hide();

    /* DESHABILITO EL ENTER EN EL CONTROL */
	$('#txtFiltro').keypress(function(e) {
	    if (e.which == 13)
	        return false;
	});

	$('#cboFiltros').click(function() {
		if ($('#cboFiltros').val() == 0) {
			$('#txtFiltro').val('');
			$('#txtFiltro').attr('disabled', 'disabled');
		}

		if ($('#cboFiltros').val() == 1) {
			$('#txtFiltro').removeAttr("disabled");
		}

		if ($('#cboFiltros').val() == 2) {
			$('#txtFiltro').removeAttr("disabled");
		}
	});

    $('#btnFiltrar').click(function() {

    	limpiar_tabla();
    	$('#divbtnImprimir').hide();
    	$('#divbtnImprimirFiltrar').hide();

    	var filtro_opcion = $('#cboFiltros').val();
    	var filtro = $('#txtFiltro').val();
    	var ciclo = $('#cboCiclo').val();

    	if (filtro_opcion == 0 || filtro == '' || ciclo == 0) {
    	    //alert('Debe seleccionar la Opción e ingresar un valor');
    	    $('#divMensaje').html('<p class="form-control-static"><h4>' + 'Debe seleccionar la Opción e ingresar un valor' + '</h4></p>');
	    	$('#MensajeCantidad').modal('show');
    	    return;
    	}

    	var url_informe = '';

    	if (filtro_opcion == 1) { //DNI
    		url_informe = '{{url('matriculas/informepagospordni')}}';
    	} else if (filtro_opcion == 2) { // APELLIDO
    		url_informe = '{{url('matriculas/informepagosporapellido')}}';
    	}

		$.ajax({
		  url: url_informe,
		  data:{'filtro': filtro, 'ciclo': ciclo},
		  type: 'POST'
		}).done(function(personas) {
			console.log(personas);

			if (personas.length == 0) {
				//alert('No se han encontrado datos');
				$('#divMensaje').html('<p class="form-control-static"><h4>' + 'No se han encontrado datos' + '</h4></p>');
	    		$('#MensajeCantidad').modal('show');
				return;
			}

			$('#divbtnImprimirFiltrar').show();

			var falta = "<i class='fa fa-times text-danger'></i>";
			var pagado;

			$.each(personas, function(key, persona) {
			    alumno = persona.apellido + ', ' + persona.nombre;

			    $.each(persona.inscripciones, function(key, inscripcion) {

			    	if (inscripcion.matricula != <?php echo MatriculasController::NO_EXISTE_MATRICULA ?>) {
					    if (inscripcion.matricula.matriculaaplica) {
					    	fecha_vencimiento = getFechaImpresion(inscripcion.matricula.fechavencimientomatricula);

						    if (inscripcion.pago == <?php echo MatriculasController::MATRICULA_IMPAGA ?>) {
						        fecha_pago = '';
						        pagado = falta;
							} else {
								var monto = 0;
						    	fecha_pago = getFechaImpresion(inscripcion.pago.fechapago);

						    	if (inscripcion.pago.importeparcial == null) {
						    		monto = parseFloat(inscripcion.pago.importe);
						    	} else {
						    		monto = parseFloat(inscripcion.pago.importeparcial);
						    	}

						    	var recargo = 0;
						    	var descuento =0;

						    	if (inscripcion.pago.porcentajerecargo) {
						    		recargo = parseFloat((monto * inscripcion.pago.porcentajerecargo) / 100);
						    	}

						    	if (inscripcion.pago.porcentajedescuento) {
						    		descuento = parseFloat((monto * inscripcion.pago.porcentajedescuento) / 100);
						    	}

						    	pagado = parseFloat(monto + recargo - descuento);
						    	pagado = pagado.toFixed(2);
						    }
					    } else {
					        fecha_vencimiento = '';
					        pagado = '';
					        fecha_pago = '';
						}
						importe_matricula = inscripcion.matricula.matriculaimporte;

						$('#table_informesmatricula > tbody').append(
						    '<tr>' +
						    '<td><center>' + alumno + '</center></td>' +
						    '<td><center>' + persona.nrodocumento + '</center></td>' +
						    '<td><center>' + importe_matricula + '</center></td>' +
						    '<td><center>' + pagado + '</center></td>' +
						    '<td><center>' + fecha_vencimiento + '</center></td>' +
						    '<td><center>' + fecha_pago + '</center></td>' +
						    '</tr>'
						);
					}
				});
			});

		}).error(function(data) {
			console.log(data);
		});

    });

    $('#btnBuscar').click(function() {

    	limpiar_tabla();
    	$('#divbtnImprimir').hide();
    	$('#divbtnImprimirFiltrar').hide();

    	var organizacion = $('#cboOrganizacion').val();
    	var carrera = $('#carrera').val();

    	if (organizacion == 0 || carrera == 0) {
    	    //alert('Debe seleccionar Organización y Carrera');
    	    $('#divMensaje').html('<p class="form-control-static"><h4>' + 'Debe seleccionar Organización y Carrera' + '</h4></p>');
	    	$('#MensajeCantidad').modal('show');
    	    return;
    	}

		$.ajax({
		  url: '{{url('matriculas/informepagosporcarrera')}}',
		  data:{'carrera': carrera},
		  type: 'POST'
		}).done(function(matriculas) {
			console.log(matriculas);

			if (matriculas.length == 0) {
				//alert('No se han encontrado datos');
				$('#divMensaje').html('<p class="form-control-static"><h4>' + 'No se han encontrado datos' + '</h4></p>');
	    		$('#MensajeCantidad').modal('show');
				return;
			}

			$('#divbtnImprimir').show();

			var falta = "<i class='fa fa-times text-danger'></i>";
			var pagado;

			$.each(matriculas, function(key, matricula) {
			    persona = matricula.apellido + ', ' + matricula.nombre;

			    if (matricula.matriculaaplica) {
			    	fecha_vencimiento = getFechaImpresion(matricula.fechavencimientomatricula);

				    if (matricula.pago == <?php echo MatriculasController::MATRICULA_IMPAGA ?>) {
				        fecha_pago = '';
				        pagado = falta;
					} else {
				    	fecha_pago = getFechaImpresion(matricula.pago.fechapago);
				    	var monto = parseFloat(matricula.pago.importe);
				    	var recargo = 0;
				    	var descuento =0;

				    	if (matricula.pago.porcentajerecargo) {
				    		recargo = parseFloat((monto * matricula.pago.porcentajerecargo) / 100);
				    	}

				    	if (matricula.pago.porcentajedescuento) {
				    		descuento = parseFloat((monto * matricula.pago.porcentajedescuento) / 100);
				    	}

				    	pagado = parseFloat(monto + recargo - descuento);
				    	pagado = pagado.toFixed(2);
				    }
			    } else {
			        fecha_vencimiento = '';
			        fecha_pago = '';
			        pagado = '';
				}

				$('#table_informesmatricula > tbody').append(
				    '<tr>' +
				    '<td><center>' + persona + '</center></td>' +
				    '<td><center>' + matricula.dni + '</center></td>' +
				    '<td><center>' + matricula.matriculaimporte + '</center></td>' +
				    '<td><center>' + pagado + '</center></td>' +
				    '<td><center>' + fecha_vencimiento + '</center></td>' +
				    '<td><center>' + fecha_pago + '</center></td>' +
				    '</tr>'
				);
			});

		}).error(function(data) {
			console.log(data);
		});

    });

    $('#carrera').change(function() {
    	$('#divbtnImprimir').hide();
    	$('#divbtnImprimirFiltrar').hide();
    	limpiar_tabla();
    });

    $('#cboCiclo').change(function() {

        $('#carrera').children().remove().end();

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

			$('#carrera').append(
		        $('<option></option>').val(0).html('Seleccionar')
		    );

			$.each(carreras, function(key, value) {
				$('#carrera').append(
			        $('<option></option>').val(value.carrera_id).html(value.carrera)
			    );
			});
		}).error(function(data) {
			console.log(data);
		});

    });

    $('#cboOrganizacion').change(function() {

    	$('#divbtnImprimir').hide();
    	$('#divbtnImprimirFiltrar').hide();
    	limpiar_tabla();
		$('#cboCiclo').children().remove().end();
		$('#carrera').children().remove().end();

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
		$('#table_informesmatricula tr').each(function() {
		   if (n > 0) $(this).remove();
		   n++;
		});
    }

	$('#imprimir').on('click', function(e){
		e.preventDefault();
		window.open("{{url('matriculas/pdfpagosporcarrera')}}?carrera=" + $('#carrera').val() + '&ciclo=' + $('#cboCiclo').val());
	});

	$('#imprimir_filtrar').on('click', function(e){
		e.preventDefault();
		window.open("{{url('matriculas/pdfpagosporfiltro')}}?filtro=" + $('#cboFiltros').val() + '&valor=' + $('#txtFiltro').val());
	});
@stop


@section('includejs')
	<script type="text/javascript" src="{{url('assets/global/plugins/select2/select2.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js')}}"></script>
	<script src="{{url('assets/admin/pages/scripts/table-advanced.js')}}"></script>
	<script src="{{url('assets/admin/pages/scripts/helpers/jquery.combodinamico.js')}}" type="text/javascript"></script>
	<script src="{{url('assets/admin/pages/scripts/getFechaImpresion.js')}}"></script>
@stop
