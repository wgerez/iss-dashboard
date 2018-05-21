@extends('layouts.master')

@section('customstyle')
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/select2/select2.css')}}"/>
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
$editar = true;
$imprimir = true;
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
					Contratos <small>imprimir contratos</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">Contratos</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">imprimir</a>
						</li>
					</ul>
				</div>
			</div>
			<!-- FIN DE HEADER-->
			<!-- COMIENZO DEL CONTENIDO-->

			<div class="row">
				<div class="col-md-12">

					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-print"></i> Imprimir Contratos
							</div>
						</div>
						<div class="portlet-body">
							<div class="form-body">
								{{ Form::open(array('class'=>'form-horizontal form-row-seperated','name'=>'FrmContratos'))}}
									<input type="hidden" id="permiso" value="@if ($disabled=='disabled') {{'0'}} @else {{'1'}} @endif">
									<div class="form-group">
										<label  class="col-md-2 col-sm-2 control-label" for="organizacion">Organización:</label>
										<div class="col-md-6 col-sm-10">
											{{ Form::select('cboOrganizacion', $organizaciones, Input::old('cboOrganizacion'), array('class'=>'table-group-action-input form-control','id'=>'cboOrganizacion')) }}
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 col-sm-2 control-label" for="filtro">Carreras:</label>
										<div class="col-md-6 col-sm-10">
											<select name="cboCarreras" id="cboCarreras" class="table-group-action-input form-control">
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 col-sm-2 control-label" for="filtro">Ciclo Lectivo Actual:</label>
										<div class="col-md-6 col-sm-6">
											<input type="text" class="form-control" name="txtCicloLectivo" id="txtCicloLectivo" READONLY>
											<input type='hidden' id='txtCicloID' name='txtCicloID' value=''>
										</div>
									</div>
									<div class='form-group'>
										<label class="col-md-2 col-sm-2 control-label" for="filtro">DNI:</label>
										<div class="col-md-4 col-sm-8">
											<input type="text" class="form-control" name="txtDNI" id="txtDNI">
										</div>

										<div class="col-md-2 col-sm-2">
											&nbsp;
										</div>

										<div class="col-md-2 col-sm-2">
											<button id='btnBuscar' class="btn btn-primary" type="button"><i class="fa fa-search"></i> Buscar</button>
										</div>										
									</div>
								{{ Form::close() }}
								<table class="table table-striped table-bordered table-hover" id="imprimir_contratos">
									<thead>
									<tr>
										<th>
											<center><i class="fa fa-user"></i> Alumno</center>
										</th>
										<th>
											<center><i class="fa fa-files-o"></i> Carrera</center>
										</th>
										<th><center><i class="fa fa-list-ol"></i> Vigencia del Contrato </center></th>
										<th><center><i class="fa fa-usd"></i> Matrícula</center></th>
										<th><center><i class="fa fa-usd"></i> Cuotas</center></th>
										<th><center><i class="fa fa-usd"></i> Total Anual </center></th>
										<th><center><i class="fa fa-rocket"></i> Acción</center></th>											
									</tr>
									</thead>
									<tbody>
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

	<!-- MODAL DE AVISOS-->
	<div class="modal fade" id="modaldeavisos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		{{ Form::open(array('url' => 'docentes/borrar')) }}
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title" id="idtitlemodalavisos">Aviso</h4>
					</div>
					<div class="modal-body">
						 <p id="idmensajeavisos"></p>
					</div>
					<div class="modal-footer">
						<button type="button" data-dismiss="modal" class="btn default"><i class="fa fa-times-circle-o"></i> Cerrar</button>
					</div>
				</div>
				<!-- /.modal-contenido -->
			</div>
		{{Form::close()}}
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
	<!-- FIN DEL MODAL DE AVISOS-->

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

    $('#btnBuscar').click(function() {

    	if ($('#cboOrganizacion').val() == 0
    	    || ($('#cboCarreras').val() == 0 && $.trim($('#txtDNI').val()) == '')) {
    	    $('#idmensajeavisos').text('Debe ingresar los filtros para realizar la búsqueda');
			$('#modaldeavisos').modal('show');
			return;
    	}
    	
    	limpiar_tabla();

    	if ($.trim($('#txtDNI').val()) != '') {
    		buscar_por_dni_y_ciclo();
    	} else {
    		buscar_por_carrera_y_ciclo();
    	}
    });

    function buscar_por_dni_y_ciclo() {
		$.ajax({
		  url: '{{url('contratos/datosparagenerarcontratospordniyciclo')}}',
		  data:{'dni': $('#txtDNI').val(), 'ciclo': $('#txtCicloID').val()},
		  type: 'POST'
		}).done(function(datos) {
			console.log(datos);
			if (datos == <?php echo ContratosController::ALUMNO_NO_EXISTE ?>) {
    	    	$('#idmensajeavisos').text('El Alumno no Existe');
				$('#modaldeavisos').modal('show');			
				//alert('El Alumno no Existe');
				return;
		    }
			if (datos == <?php echo ContratosController::ALUMNO_NO_INSCRITO ?>) {
    	    	$('#idmensajeavisos').text('El Alumno no se encuentra matriculado en ninguna Carrera');
				$('#modaldeavisos').modal('show');
				//alert('El Alumno no se encuentra matriculado en ninguna Carrera');
				return;
		    }


		    var persona = datos.apellido + ', ' + datos.nombre;

		    var fecha_desde = getFechaImpresion(datos.ciclo_lectivo.fechainicio);
		    var fecha_hasta = getFechaImpresion(datos.ciclo_lectivo.fechafin);
		    var vigencia = fecha_desde + ' - ' + fecha_hasta;

		    var cuota_mensual = '';
		    var total_anual = '';

			$.each(datos.inscripciones, function(key, inscripcion) {

			    var cuota_mensual = inscripcion.matricula[0].cuotasporperiodo + ' * $' + inscripcion.matricula[0].cuotaimporte;
			    var total_anual = inscripcion.matricula[0].cuotaimporte * inscripcion.matricula[0].cuotasporperiodo;

			    total_anual = total_anual.toFixed(2);
				if ($('#permiso').val()=='0') { var per = 'disabled'}else{ var per = '' }
				$('#imprimir_contratos > tbody').append(
				    '<tr>' +
				    '<td>' + persona + '</td>' +
				    '<td>' + inscripcion.carrera.carrera + '</td>' +
				    '<td>' + vigencia + '</td>' +
				    '<td>$' + inscripcion.matricula[0].matriculaimporte + '</td>' +
				    '<td>' + cuota_mensual + '</td>' +
				    '<td>$' + total_anual + '</td>' +
				    "<td><center>" +
				    '<a title="Imprimir" '+ per +'style="cursor:pointer" class="imprimir_contrato" data-carrera="' + inscripcion.carrera.id + '" data-id="' + datos.alumno.id +'"><i class="fa fa-print"></i></a>' +
				    '</td></center>' +
				    '</tr>'
				);
			});

			//var dataTable = $('#imprimir_contratos').dataTable();
		    //dataTable.fnDraw();

		}).error(function(data) {
			console.log(data);
		});
	}

    function buscar_por_carrera_y_ciclo() {
		$.ajax({
		  url: '{{url('contratos/datosparagenerarcontratosporcicloycarrera')}}',
		  data:{'carrera': $('#cboCarreras').val(), 'ciclo': $('#txtCicloID').val()},
		  type: 'POST'
		}).done(function(datos) {
			console.log(datos);
			if (datos == <?php echo ContratosController::NO_HAY_INSCRITOS ?>) {
				alert('La Carrera no tiene Alumnos Matriculados');
				return;
		    }

			if (datos == <?php echo ContratosController::NO_HAY_MATRICULA_ASIGNADA ?>) {
				alert('La Carrera no tiene Matrícula Asignada');
				return;
		    }

		    var matricula = datos.pop();
		    var ciclo_lectivo = datos.pop();
		    var carrera = datos.pop();

		    var persona = '';

		    var fecha_desde = getFechaImpresion(ciclo_lectivo.fechainicio);
		    var fecha_hasta = getFechaImpresion(ciclo_lectivo.fechafin);
		    var vigencia = fecha_desde + ' - ' + fecha_hasta;

		    var cuota_mensual = matricula[0].cuotasporperiodo + ' * $' + matricula[0].cuotaimporte;
		    var total_anual = matricula[0].cuotaimporte * matricula[0].cuotasporperiodo;

		    total_anual = total_anual.toFixed(2);

			$.each(datos, function(key, alumno) {
			    persona = alumno.apellido + ', ' + alumno.nombre;
				if ($('#permiso').val()=='0') { var per = 'disabled'}else{ var per = '' }
				$('#imprimir_contratos > tbody').append(
				    '<tr>' +
				    '<td>' + persona + '</td>' +
				    '<td>' + carrera.carrera + '</td>' +
				    '<td>' + vigencia + '</td>' +
				    '<td>$' + matricula[0].matriculaimporte + '</td>' +
				    '<td>' + cuota_mensual + '</td>' +
				    '<td>$' + total_anual + '</td>' +
				    "<td><center>" +
				    '<a title="Imprimir" '+per+' style="cursor:pointer" class="imprimir_contrato" data-id="' + alumno.alumno_id + '"><i class="fa fa-print"></i></a>' +
				    '</td></center>' +
				    '</tr>'
				);
			});

			//var dataTable = $('#imprimir_contratos').dataTable();
		    //dataTable.fnDraw();

		}).error(function(data) {
			console.log(data);
		});
	}

    $('#cboCarreras').change(function() {
    	limpiar_tabla();
    	$('#txtDNI').val('');
    });

    $('#txtDNI').keydown(function() {
    	$('#cboCarreras').val(0);
    });

	$('#cboOrganizacion').change( function(e) {

    	limpiar_tabla();

	    $('#txtCicloLectivo').val('');
	    $('#txtCicloID').val('');

		$('#cboCarreras').children().remove().end();

		if ($('#cboOrganizacion').val() == 0) return;

		$.ajax({
		  url: '{{url('organizacions/obtenercicloactivo')}}',
		  data:{'organizacion_id': $('#cboOrganizacion').val()},
		  type: 'POST'
		}).done(function(ciclo) {
			console.log(ciclo);
			if (ciclo == <?php echo OrganizacionsController::NO_EXISTE_CICLO_ACTIVO ?>) {
				alert('La Organización no tiene Ciclo Lectivo Activo');
				return;
		    }

		    $('#txtCicloLectivo').val(ciclo.descripcion);
		    $('#txtCicloID').val(ciclo.id);

			$.ajax({
			  url: '{{url('organizacions/obtenercarrerasconmatriculaporciclo')}}',
			  data:{'organizacion_id': $('#cboOrganizacion').val(), 'ciclo': ciclo.id},
			  type: 'POST'
			}).done(function(carreras) {
				console.log(carreras);
				if (carreras == <?php echo OrganizacionsController::NO_TIENE_CARRERAS ?>) {
					alert('La Organización no tiene Carreras asignadas');
					return;
			    }

				if (carreras == <?php echo OrganizacionsController::NO_TIENE_CARRERAS_CON_MATRICULA_ASOCIADA ?>) {
					alert('No existen Carreras con Matrículas asignadas');
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
		}).error(function(data) {
			console.log(data);
		});

	});

    function limpiar_tabla() {
	    var n = 0;
		$('#imprimir_contratos tr').each(function() {
		   if (n > 0) $(this).remove();
		   n++;
		});
    }

	$(".imprimir_contrato").live('click', function() {
		var alumno_id = $(this).data('id');
		if ($('#cboCarreras').val() == 0) {
			var carrera = $(this).data('carrera');
		} else {
			var carrera = $('#cboCarreras').val();
		}

		window.open("{{url('contratos/pdfgenerarcontrato')}}?ciclo=" + $('#txtCicloID').val() + '&carrera=' + carrera + '&alumno=' + alumno_id + '&organizacion=' + $('#cboOrganizacion').val());
	});


@stop


@section('includejs') 
	<script type="text/javascript" src="{{url('assets/global/plugins/select2/select2.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js')}}"></script>
	<!--script src="{{url('assets/admin/pages/scripts/table-advanced.js')}}"></script -->
	<script src="{{url('assets/admin/pages/scripts/getFechaImpresion.js')}}"></script>
@stop
