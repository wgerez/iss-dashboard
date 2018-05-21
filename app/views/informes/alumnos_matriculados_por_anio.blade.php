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
					Informes <small>alumnos matriculados por a&ntilde;o (pdf)</small>
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
							<a href="#">Alumnos</a>
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
								<i class="fa fa-users"></i>Alumnos Matriculados por A&ntilde;o (Ciclo Lectivo)
							</div>
							<div class="actions">
								<!--a href="{{url('alumnos/crear')}}" @if (!$editar) {{'DISABLED'}} @endif class="btn default blue-stripe" >
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Nuevo</span>
								</a -->
								<a target="_blank" href="#" id="imprimir" class="btn default yellow-stripe" <?php if (!$habilita) echo "disabled"; ?>>
								<i class="fa fa-print"></i>
								<span class="hidden-480">
								Imprimir </span>
								</a>

							</div>

						</div>
						<div class="portlet-body">
							<div class="form-body">
								<form method="POST" action="{{url('alumnos/obtenerinscripcionesporciclo')}}" class="form-horizontal form-row-seperated" id="FrmAlumnos" name="">
								<div class="form-group">
									<label  class="col-md-2 col-sm-2 control-label" for="organizacion">Organización:</label>
									<div class="col-md-6 col-sm-10">
										{{ Form::select('cboOrganizacion', $organizaciones, Input::old('cboOrganizacion'), array('class'=>'table-group-action-input form-control','id'=>'cboOrganizacion')) }}
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 col-sm-2 control-label" for="filtro">Ciclo Lectivo:</label>
									<div class="col-md-2 col-sm-3">
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
									<div class="col-md-2 col-sm-2">
										<button class="btn btn-primary" type="submit">
											<i class="fa fa-search"></i> Buscar
										</button>
									</div>
									<div id="divbtnImprimir" class="col-md-2 col-sm-2">
										<a target="_blank" href="#" id="imprimir" class="btn btn-success"><i class="fa fa-print"></i> Imprimir</a>
									</div>
								</div>
								</form>
								<br>
								<table class="table table-striped table-bordered table-hover" id="table_informespagos">
									<thead>
										<tr>
											<th>
												 <center><i class="fa fa-tags"></i> Apellido y Nombre</center>
											</th>
											<th>
												 <center><i class="fa fa-list-ol"></i> DNI</center>
											</th>
											<th>
												 <center><i class="fa fa-female"></i></i> Sexo</center>
											</th>
											<th>
												 <center><i class="fa fa-language"></i> Dirección</center>
											</th>
											<th>
												 <center><i class="fa fa-language"></i> Localidad</center>
											</th>
											<th>
												 <center><i class="fa fa-phone"></i> Teléfono</center>
											</th>
											<th>
												 <center><i class="fa fa-envelope"></i> E-mail</center>
											</th>								
										</tr>
									</thead>
									<tbody>
									@if (isset($inscriptos))
										@foreach ($inscriptos as $inscripto)
											<tr>
												<td>
													<center>
														{{ $inscripto['persona'] }}
													</center>
												</td>
												<td>
													<center>
														{{ $inscripto['nrodocumento'] }}
													</center>
												</td>
												<td>
													<center>
														{{ $inscripto['sexo'] }}
													</center>
												</td>
												<td>
													<center>
														{{ $inscripto['domicilio'] }}
													</center>
												</td>
												<td>
													<center>
														{{ $inscripto['localidad'] }}
													</center>
												</td>
												<td>
													<center>
														{{ $inscripto['telefono'] }}
													</center>
												</td>
												<td>
													<center>
														{{ $inscripto['email'] }}
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
@stop


@section('customjs')

	TableAdvanced.init();
	$('#divbtnImprimir').hide();

    /*$('#btnBuscar').click(function() {

    	var organizacion = $('#cboOrganizacion').val();
    	var ciclo = $('#cboCiclo').val();

    	if (organizacion == 0 || ciclo == 0) {
    	    alert('Debe seleccionar todos los datos a buscar');
    	    return;
    	}

    	limpiar_tabla();

		$.ajax({
		  url: '{{url('inscripciones/obtenerinscripcionesporciclo')}}',
		  data:{'organizacion': organizacion, 'ciclo': ciclo},
		  type: 'POST'
		}).done(function(inscripciones) {
			console.log(inscripciones);

			if (inscripciones == <?php echo InscripcionesController::NO_HAY_INSCRITOS ?>) {
				return;
			}

			$('#divbtnImprimir').show();

			$.each(inscripciones, function(key, inscripcion) {
			    persona = inscripcion.apellido + ', ' + inscripcion.nombre;

			    if (inscripcion.barrio == null) {
			    	barrio = 'B° no cargado';
			    } else {
			    	barrio = inscripcion.barrio;
			    }

			    if (inscripcion.calle) {
			    	calle = inscripcion.calle;
			    } else {
			    	calle = 'Calle no cargado';
			    }

				if (inscripcion.calle_numero==0) {
					numero = ' s/n';
				} else {
					numero = ' N: ' + inscripcion.calle_numero;
				}

				if (inscripcion.manzana==0) {
					manzana = '';
				} else {
					manzana = ' - Mz: ' + inscripcion.manzana;
				}

				if (inscripcion.departamento==0) {
					departamento = '';
				} else {
					departamento = ' - dpto: ' + inscripcion.departamento;
				}
			    
			    domicilio = barrio + ' - ' + calle + ' ' + numero + ' ' + manzana + ' ' + departamento;

				if (domicilio == 0) domicilio = '&nbsp;';

			    var telefono = '';
			    var email = '';

			    $.each(inscripcion.contactos, function(key, contacto) {
			        if (contacto.contacto_id == 1) {
			            telefono = contacto.descripcion;
			        } else if(contacto.contacto_id == 3) {
			            email = contacto.descripcion;
			        }
				});

				$('#table_informes > tbody').append(
				    '<tr>' +
				    '<td>' + persona + '</td>' +
				    '<td>' + inscripcion.nrodocumento + '</td>' +
				    '<td>' + inscripcion.sexo + '</td>' +
				    '<td>' + domicilio + '</td>' +
				    '<td>' + inscripcion.localidad + '</td>' +
				    '<td>' + telefono + '</td>' +
				    '<td>' + email + '</td>' +
				    '</tr>'
				);
			});

		}).error(function(data) {
			console.log(data);
		});

    });*/

    $('#cboCiclo').change(function() {
    	$('#divbtnImprimir').hide();
    	limpiar_tabla();
    });

    $('#cboOrganizacion').change(function() {

    	$('#divbtnImprimir').hide();
    	limpiar_tabla();
		$('#cboCiclo').children().remove().end();

		if ($('#cboOrganizacion').val() == 0) return;

		$.ajax({
		  url: '{{url('ciclolectivo/obtenercicloslectivos')}}',
		  data:{'organizacion_id': $('#cboOrganizacion').val()},
		  type: 'POST'
		}).done(function(ciclos) {
			console.log(ciclos);
			if (ciclos == <?php echo CicloLectivoController::NO_EXISTE_CICLO ?>) {
				alert('La Organización no tiene Ciclos Lectivos Asignados');
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
		$('#table_informes tr').each(function() {
		   if (n > 0) $(this).remove();
		   n++;
		});
    }

	$('#imprimir').on('click', function(e){
		e.preventDefault();
		window.open("{{url('alumnos/pdfalumnosmatriculadosporanio')}}?ciclo_lectivo=" + $('#cboCiclo').val());
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
@stop
