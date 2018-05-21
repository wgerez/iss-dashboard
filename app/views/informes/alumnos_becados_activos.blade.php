@extends('layouts.master')

@section('customstyle')
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/select2/select2.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css')}}"/>
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
					Informes <small>alumnos Becados, Activos y Baja (pdf)</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('informes/alumnos')}}">Informes</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('alumnos/informealumnosbecadosactivosbaja')}}">Alumnos</a>
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
					    @if (Session::get('message_type') == AlumnosController::OPERACION_FALLIDA)

					        <div class="note note-danger">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@endif
					@endif
					<!-- COMIENZO DE LA TABLA-->
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-users"></i>Alumnos Becados
							</div>
							<div class="actions">
								<!--a href="{{url('alumnos/crear')}}" @if (!$editar) {{'DISABLED'}} @endif class="btn default blue-stripe" >
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Nuevo</span>
								</a-->
								<a target="_blank" href="#" id="imprimir" class="btn default yellow-stripe" <?php if (!$habilita) echo "disabled"; ?><?php if (!$becados) echo "disabled"; ?>>
								<i class="fa fa-print"></i>
								<span class="hidden-480">
								Imprimir </span>
								</a>

							</div >

						</div>
						<div class="portlet-body">
							<div class="form-body">
								<form method="POST" action="{{url('alumnos/informebecadosactivosporcarreras')}}" class="form-horizontal form-row-seperated" id="FrmPlanestudios" name="">
								<div class="form-group">
									<label  class="col-md-2 col-sm-2 control-label" for="organizacion">Organización:</label>
									<div class="col-md-6 col-sm-10">
										{{ Form::select('cboOrganizacion', $organizaciones, Input::old('cboOrganizacion'), array('class'=>'table-group-action-input form-control','id'=>'cboOrganizacion')) }}
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 col-sm-2 control-label" for="filtro">Ciclo Lectivo:</label>
									<div class="col-md-2 col-sm-3">
										<select class="table-group-action-input form-control" name="cboCiclo" id="cboCiclo">
											@if (isset($ciclo_id))
												@foreach ($ciclos as $ciclo)
													<option value="{{$ciclo->id}}" <?php if ($ciclo_id == $ciclo->id) echo "selected=selected"; ?>>{{$ciclo->descripcion}}</option>
												@endforeach
											@endif
										</select>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 col-sm-2 control-label" for="filtro">Carreras:</label>
									<div class="col-md-6 col-sm-10">
										<select name="cboCarreras" id="cboCarreras" class="table-group-action-input form-control">
											@if (isset($carrera))
												@foreach ($carreras as $carrer)
													<option value="{{$carrer->carrera_id}}" <?php if ($carrera == $carrer->carrera_id) echo "selected=selected"; ?>>{{$carrer->carrera}}</option>
												@endforeach
											@endif
										</select>
									</div>
									
									<!--div id="divbtnImprimir" class="col-md-2 col-sm-2">
										<a target="_blank" href="#" id="imprimir" class="btn btn-success"><i class="fa fa-print"></i> Imprimir</a>
									</div-->
								</div>

								<div class='form-group'>
									<label class="col-md-2 col-sm-2 control-label" for="filtro">Filtrar por:</label>
									<div class="col-md-2 col-sm-3">
										<select name="cboFiltros" id="cboFiltros" class="table-group-action-input form-control">
											@if ($filtros == '')
												<option value='0'>Todos</option>
												<option value='1'>Becados</option>
												<option value='2'>Activos</option>
												<option value='3'>Bajas</option>
											@else
												<option value='0'<?php if ($filtros == 0) echo "selected=selected"; ?>>Todos</option>
												<option value='1'<?php if ($filtros == 1) echo "selected=selected"; ?>>Becados</option>
												<option value='2'<?php if ($filtros == 2) echo "selected=selected"; ?>>Activos</option>
												<option value='3'<?php if ($filtros == 3) echo "selected=selected"; ?>>Bajas</option>
											@endif
										</select>
									</div>								
									<!--div class="col-md-2 col-sm-2">
										<button class="btn btn-primary" type="button" id='btnBuscar'>
											<i class="fa fa-search"></i> Buscar
										</button>
									</div-->

										<div class="col-md-2 col-sm-2">
											<button class="btn btn-primary" type="submit" id='BtnBuscar'><i class="fa fa-search"></i> Buscar</button>
										</div>
									
									<!--div id="divbtnImprimirFiltrar" class="col-md-2 col-sm-2">
										<a target="_blank" href="#" id="imprimir_filtrar" class="btn btn-success"><i class="fa fa-print"></i> Imprimir</a>
									</div-->
								</div>
								</form>

								<br>
								<table class="table table-striped table-bordered table-hover" id="table_informesabb">
									<thead>
										<tr>
											<th><center>Apellido y Nombre</center></th>
											<th><center>Fecha de Ingreso</center></th>
											<th><center>Teléfono</center></th>
											<th><center>Dirección</center></th>
										</tr>
									</thead>
									<tbody>
									@if (isset($becados))
										@foreach ($becados as $becado)
											<?php
											    /*$telefono = '';
											    $email = '';
											    $domicilio = $becado->barrio . ', ' . $becado->calle . ' ' . $becado->calle_numero;

											    foreach ($becado->contactos as $contacto) {
											        if ($contacto->contacto_id == 1) {
											            $telefono = $contacto->descripcion;
											        } else if($contacto->contacto_id == 3) {
											            $email = $contacto->descripcion;
											        }
												}*/
											?>
											<tr>
												<td>
													<center>
														{{ $becado['apellido'] }}, {{ $becado['nombre'] }}
													</center>
												</td>
												<td>
													<center>
														{{ $becado['fechaingreso'] }}
													</center>
												</td>
												<td>
													<center>
														{{ $becado['telefono'] }}
													</center>
												</td>
												<td>
													<center>
														{{ $becado['barrio'] }}, {{ $becado['calle'] }}, {{ $becado['calle_numero'] }}
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
				</div>
			</div>
			<!-- FIN DEL CONTENIDO -->
		</div>
	</div>
	<!-- FIN -->

<!-- MODAL DE ALERTAS-->
	<div class="modal fade" id="modalalerta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title"><i class="fa fa-info-circle"></i> Aviso</h4>
					</div>
					<div class="modal-body">
					<p id="txtalerta"></p>
					</div>
					<div class="modal-footer">
						<button data-dismiss="modal" type="button" class="btn default"><i class="fa fa-times-circle-o"></i> Cerrar</button>
					</div>
				</div>
			</div>
	</div>
	<!-- FIN MODAL DE ALERTAS-->

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

    /*$('#btnBuscar').click(function() {

    	limpiar_tabla();
    	$('#divbtnImprimir').hide();
    	$('#divbtnImprimirFiltrar').hide();

    	var organizacion = $('#cboOrganizacion').val();
    	var carrera = $('#cboCarreras').val();
    	var ciclo = $('#cboCiclo').val();
    	var filtro = $('#cboFiltros').val();

    	if (organizacion == 0) {
    		$('#txtalerta').text('Debe seleccionar Organización');
    		$('#modalalerta').modal('show');    	
    	    return;
    	}

    	if (carrera == 0) {
    		$('#txtalerta').text('Debe seleccionar Carrera');
    		$('#modalalerta').modal('show');    	
    	    return;
    	}

    	if (ciclo == 0) {
    		$('#txtalerta').text('Debe seleccionar Ciclo');
    		$('#modalalerta').modal('show');    	
    	    return;
    	}

		$.ajax({
		  url: '{{url('alumnos/informebecadosactivosporcarrera')}}',
		  data:{'carrera': carrera, 'ciclo': ciclo, 'filtro': filtro},
		  type: 'POST'
		}).done(function(becados) {
			console.log(becados);

			if (becados.length == 0) {
    			$('#txtalerta').text('No se ha encontrado Alumnos con Beca');
    			$('#modalalerta').modal('show');			
				return;
			}

			$('#divbtnImprimir').show();

			$.each(becados, function(key, becado) {
			    persona = becado.apellido + ', ' + becado.nombre;
			    domicilio = becado.barrio + ', ' + becado.calle + ' ' + becado.calle_numero;
			    fecha_inicio_beca = getFechaImpresion(becado.fechaingreso);
			    //fecha_fin_beca = getFechaImpresion(becado.becafechafin);

			    var telefono = '';
			    var email = '';

			    $.each(becado.contactos, function(key, contacto) {
			        if (contacto.contacto_id == 1) {
			            telefono = contacto.descripcion;
			        } else if(contacto.contacto_id == 3) {
			            email = contacto.descripcion;
			        }
				});

				$('#table_informesabb > tbody').append(
				    '<tr>' +
				    '<td><center>' + persona + '</center></td>' +
				    '<td><center>' + fecha_inicio_beca + '</center></td>' +
				    '<td><center>' + telefono + '</center></td>' +
				    '<td><center>' + domicilio + '</center></td>' +
				    '</tr>'
				);
			});

		}).error(function(data) {
			console.log(data);
		});

    });*/

    $('#cboCiclo').change(function() {
        $('#cboCarreras').children().remove().end();
		limpiar_tabla();
        if ($('#cboCiclo').val() == 0) return;

		$.ajax({
		  url: '{{url('organizacions/obtenercarrerasconmatriculaporciclo')}}',
		  data:{'ciclo': $('#cboCiclo').val(), 'organizacion_id': $('#cboOrganizacion').val()},
		  type: 'POST'
		}).done(function(carreras) {
			console.log(carreras);

			if (carreras == <?php echo InscripcionesController::NO_TIENE_INSCRIPCION  ?>) {
				//alert('Este Ciclo Lectivo no tiene Carreras con Alumnos inscritos');
	    	    $('#txtalerta').text('Este Ciclo Lectivo no tiene Carreras con Alumnos inscritos!');
    			$('#modalalerta').modal('show');
				return;
			}

			$('#cboCarreras').append(
		        $('<option></option>').val(0).html('Seleccionar')
		    );

			$.each(carreras, function(key, value) {
				$('#cboCarreras').append(
			        $('<option></option>').val(value.id).html(value.carrera)
			    );
			});
		}).error(function(data) {
			console.log(data);
		});

    });

    $('#cboCarreras').change(function() {
    	$('#divbtnImprimir').hide();
    	$('#divbtnImprimirFiltrar').hide();
    	limpiar_tabla();
    });

    $('#cboOrganizacion').change(function() {

    	$('#divbtnImprimir').hide();
    	$('#divbtnImprimirFiltrar').hide();
    	limpiar_tabla();

		$('#cboCarreras').children().remove().end();

		$('#cboCiclo').children().remove().end();

		if ($('#cboOrganizacion').val() == 0) return;

		$.ajax({
		  url: '{{url('ciclolectivo/obtenercicloslectivos')}}',
		  data:{'organizacion_id': $('#cboOrganizacion').val()},
		  type: 'POST'
		}).done(function(ciclos) {
			console.log(ciclos);
			if (ciclos == <?php echo CicloLectivoController::NO_EXISTE_CICLO ?>) {
				//alert('La Organización no tiene Ciclos Lectivos Asignados');
	    	    $('#txtalerta').text('La Organización no tiene Ciclos Lectivos Asignados');
    			$('#modalalerta').modal('show');
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

		/*$.ajax({
		  url: '{{url('organizacions/obtenercarrerasconmatricula')}}',
		  data:{'organizacion_id': $('#cboOrganizacion').val()},
		  type: 'POST'
		}).done(function(carreras) {
			console.log(carreras);
			if (carreras == <?php echo OrganizacionsController::NO_TIENE_CARRERAS ?>) {
    			$('#txtalerta').text('La Organización no tiene Carreras asignadas');
    			$('#modalalerta').modal('show');			
				return;
		    }

			if (carreras == <?php echo OrganizacionsController::NO_TIENE_CARRERAS_CON_MATRICULA_ASOCIADA ?>) {
    			$('#txtalerta').text('No existen Carreras con Matrículas asignadas');
    			$('#modalalerta').modal('show');					
				return;
		    }

			$('#cboCarreras').append(
		        $('<option></option>').val(0).html('Seleccionar')
		    );

			$.each(carreras, function(key, value) {
				$('#cboCarreras').append(
			        $('<option></option>').val(value.id).html(value.carrera)
			    );
			});
		}).error(function(data) {
			console.log(data);
		});*/
    });

    function limpiar_tabla() {
	    var n = 0;
		$('#table_informesabb tr').each(function() {
		   if (n > 0) $(this).remove();
		   n++;
		});
    }

	$('#imprimir').on('click', function(e){
		e.preventDefault();
		window.open("{{url('alumnos/pdfbecadosactivosbajas')}}?carrera=" + $('#cboCarreras').val() + '&ciclo=' + $('#cboCiclo').val() + '&filtro=' + $('#cboFiltros').val());
	});

@stop


@section('includejs')
	<script type="text/javascript" src="{{url('assets/global/plugins/select2/select2.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js')}}"></script>
	<script src="{{url('assets/admin/pages/scripts/helpers/jquery.combodinamico.js')}}" type="text/javascript"></script>
	<script src="{{url('assets/admin/pages/scripts/getFechaImpresion.js')}}"></script>
	<script src="{{url('assets/admin/pages/scripts/table-advanced.js')}}"></script>
@stop
