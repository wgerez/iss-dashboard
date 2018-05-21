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
					Matrículas <small>listado pago de matrículas</small>
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
							<a href="{{url('matriculas/listado')}}">Matrículas</a>
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
					    @if (Session::get('message_type') == MatriculasController::OPERACION_EXITOSA)

					        <div class="note note-success">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == MatriculasController::OPERACION_FALLIDA)

					        <div class="note note-danger">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == MatriculasController::OPERACION_CANCELADA)

					        <div class="note note-warning">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == MatriculasController::OPERACION_INFO)

					        <div class="note note-info">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@endif
					@endif
					<!-- COMIENZO DE LA TABLA-->
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-files-o"></i>Listado de Matrículas
							</div>
							<div class="actions">
								<a href="{{url('matriculas/pagar')}}" {{$disabled}} class="btn default blue-stripe">
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Pagar </span>
								</a>
								<a target="_blank" href="#" id="imprimir" class="btn default yellow-stripe" <?php if (!$habilita) echo "disabled"; ?>>
								<i class="fa fa-print"></i>
								<span class="hidden-480">
								Imprimir </span>
								</a>								
							</div>
						</div>
						<div class="portlet-body form">
							<div class="form-body">
								<form method="POST" action="{{url('matriculas/obtenerlistado')}}" class="form-horizontal form-row-seperated" id="FrmMatriculalistados" name="">
								<div class="form-group">
									<label  class="col-md-2 col-sm-2 control-label">Organización:</label>
									<div class="col-md-6 col-sm-6">
										{{ Form::select('cboOrganizacion', $organizaciones, Input::old('organizacion'), array('class'=>'table-group-action-input form-control','id'=>'cboOrganizacion')); }}
									</div>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<center>
											<p><span class="text-success"><i class="fa fa-check"></i></span> Pagado - <span class="text-warning"><i class="fa fa-exclamation-triangle"></i></span> Parcial - <span class="text-danger"><i class="fa fa-exclamation-triangle"></i></span> Adeuda - <span class="text-info"><i class="fa fa-asterisk"></i></span> Becado - <i class="fa fa-exclamation-triangle"></i> Próximo a Vencer</p>
										</center>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 col-sm-2 control-label" for="filtro">Ciclo Lectivo:</label>
									<div class="col-md-2 col-sm-3">
										<select name="cboCiclo" id="cboCiclo" class="table-group-action-input form-control">
											@if (isset($ciclo_id))
												@foreach ($ciclos as $ciclo)
													<option value="{{$ciclo->id}}" <?php if ($ciclo_id == $ciclo->id) echo "selected=selected"; ?>>{{$ciclo->descripcion}}</option>
												@endforeach
											@endif
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
											@if (isset($carrera))
												@foreach ($carreras as $carrer)
													<option value="{{$carrer->carrera_id}}" <?php if ($carrera == $carrer->carrera_id) echo "selected=selected"; ?>>{{$carrer->carrera}}</option>
												@endforeach
											@endif
										</select>
									</div>

									<div class="col-md-2 col-sm-2">
											<button class="btn btn-primary" type="submit" id='BtnBuscar'><i class="fa fa-search"></i> Buscar</button>
									</div>
									<!--div class="col-md-2 col-sm-2">
										<a class="btn btn-primary" id='btnBuscar'><i class="fa fa-search"></i> Buscar</a>
									</div-->
								</div>

								</form>
							</div>
							<table class="table table-striped table-bordered table-hover" id="table_matriculass">
								<thead>
								<tr>
									<th>
										<center><i class="fa fa-users"></i>Alumno</center>
									</th>
									<th>
										<center><i class="fa fa-files-o"></i>N° Doc.</center>
									</th>
									<th><center>Estado</center></th>
								</tr>
								</thead>
								<tbody>
									@if (isset($matricula))
										@foreach ($matricula as $matricul)
											<tr>
												<td>
													<center>
														{{ $matricul['apellido'] }}, {{ $matricul['nombre'] }}
													</center>
												</td>
												<td>
													<center>
														{{ $matricul['nrodocumento'] }}
													</center>
												</td>
												<td {{ $matricul['td_matricula'] }}>
													<center>
														{{ $matricul['content'] }}
													</center>
												</td>
											</tr>
										@endforeach
									@endif
								</tbody>
							</table>
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
	TableAdvanced.init();

	//$("#imprimir").attr('disabled', 'disabled');

	$('#cboOrganizacion').select2({
		placeholder: "Seleccione",
		allowClear: true
	});

	$('#imprimir').on('click', function(e){
		e.preventDefault();
		window.open("{{url('matriculas/imprimir')}}?organizacion_id=" + $('#cboOrganizacion').val() + '&carrera_id=' + $('#cboCarrera').val() + '&ciclo_id=' + $('#cboCiclo').val());
	});

    $('#btnBuscar').click(function() {

		var class_matricula = '';
		var td_cuota = '';

    	var organizacion = $('#cboOrganizacion').val();
    	var ciclo = $('#cboCiclo').val();
    	var carrera = $('#cboCarrera').val();

    	if (organizacion == 0 || carrera == 0 || ciclo == 0) {
    	    alert('Debe seleccionar todos los datos a buscar');
    	    return;
    	}

    	limpiar_tabla();

			$.ajax({
			  url: '{{url('matriculas/obtenermatriculaporcarrerayciclo')}}',
			  data:{'organizacion': organizacion, 'ciclo': ciclo, 'carrera': carrera},
			  type: 'POST'
			}).done(function(matriculas) {
				console.log(matriculas);

				$.each(matriculas, function(key, matricula) {
					ya_pago_matricula = false;
		    		tiene_beca = false;

				    if (matricula.beca == 7) {
				    	tiene_beca = false;
				    } else {
						tiene_beca = true;
					}

					if (matricula.matriculaaplica == 1) {
						$.each(matricula.detalle_cuotas, function(key, value) {
						    if (value.estado == 1) {
								ya_pago_matricula = true;
						    }
						});

						if (ya_pago_matricula) {
							td_matricula = '<td class=success><center><i class="fa fa-check"></i></center></td>';
						} else {
						    var fecha_vencimiento = getFechaImpresion(matricula.fechavencimientomatricula);
							var fecha = new Date();
							var fecha_actual = fecha.getDate() + '/' + (fecha.getMonth() + 1) + '/'
							                 + fecha.getFullYear();
							if (primerFechaMayor(fecha_vencimiento, fecha_actual)) {
								td_matricula = '<td><center><i class="fa fa-exclamation-triangle"></i></center></td>';
							} else {
								td_matricula = '<td class=danger><center><i class="fa fa-exclamation-triangle"></i></center></td>';
							}

							if (tiene_beca == true) {
								td_matricula = '<td class=info><center><i class="fa fa-asterisk"></i></center></td>';
							}
						}
					} else {
						td_matricula = '<td></td>';
					}

					$('#table_matriculas > tbody').append(
					    '<tr>' +
					    '<td>' + matricula.apellido + ', ' + matricula.nombre + '</td>' +
					    '<td>' + matricula.nrodocumento + '</td>' +
					    td_matricula +
					    '</tr>'
					);
				});

				//var dataTable = $('#table_matriculas').dataTable();
			    //dataTable.fnDraw();

			}).error(function(data) {
				console.log(data);
			});

		$('#imprimir').removeAttr("disabled");
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
				alert('Este Ciclo Lectivo no tiene Carreras con Alumnos inscritos');
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
		$('#table_matriculas tr').each(function() {
		   if (n > 0) $(this).remove();
		   n++;
		});
    }

	/*$(document).ready(function(){
 
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
	 
	});*/

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
