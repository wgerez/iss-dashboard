@extends('layouts.master')

@section('customstyle')
<!-- BEGIN PAGE LEVEL STYLES -->
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
<!-- END PAGE LEVEL STYLES -->
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
					Matrículas <small>gestión de importes</small>
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
							<a href="#">importes</a>
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
					{{ Form::open(array('url'=>'matriculas/guardar', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmMatricula', 'name'=>'FrmMatricula'))}}
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-usd"></i> Importes de Matrículas
							</div>
							<div class="actions">
								<button {{$disabled}} type='submit' class="btn default green-stripe">
								<i class="fa fa-save"></i>
								<span class="hidden-480">
								Guardar </span>
								</button>
								<!--<a href="listado" class="btn default yellow-stripe">
								<i class="fa fa-reorder"></i>
								<span class="hidden-480">
								Listado </span>
								</a>-->
							</div>

						</div>
						<div class="portlet-body form">
								<div class="form-body">

									<div class="form-group">
										<label  class="col-md-2 col-sm-2 control-label">Organización:</label>
										<div class="col-md-6 col-sm-10">

											{{ Form::select('cboOrganizacion', $organizaciones, Input::old('cboOrganizacion'), array('class'=>'table-group-action-input form-control','id'=>'cboOrganizacion')); }}

										</div>
									</div>

									<div class="form-group">
										<label  class="col-md-2 col-sm-2 control-label">Carrera:</label>
										<div class="col-md-6 col-sm-10">
											{{ Form::select('cboCarrera', array(), Input::old('cboCarrera'), array('class'=>'table-group-action-input form-control','id'=>'cboCarrera')); }}
										</div>
									</div>
								</div>
						</div> <!-- FIN PORTLET-BODY -->
					</div>
					

					<br>

					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-list"></i>Histórico de Matrículas
							</div>
						</div>
						<div class="portlet-body">
							<div class="table-scrollable">
								<table id='tableHistoricoMatriculas' class="table table-hover">
								<thead>
								<tr>
									<th>
										 <i class="fa fa-calendar"></i> Ciclo Lectivo
									</th>
									<th>
										 <i class="fa">$</i> Matrícula
									</th>
									<th>
										 <i class="fa fa-list"></i> Cuotas
									</th>
									<th>
										 <i class="fa">$</i> Importe
									</th>
									<!--<th>
										 <i class="fa fa-calendar"></i> Período de pago
									</th>-->
									<th>
										<center><i class="fa fa-rocket"></i> Acción</center>
									</th>
								</tr>
								</thead>
								<tbody>

								</tbody>
								</table>
							</div>
						</div>
					</div>


					<div class="portlet form-horizontal">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-usd"></i>Datos de matrículas y/o cuotas
							</div>
						</div>
						<input type='hidden' name='txt_matricula_id' id='txt_matricula_id' value=''>
						<div class="portlet-body form">
							<div class="form-group">
								<label  class="col-md-2 col-sm-2 control-label">Carrera:</label>
								<div class="col-md-10 col-sm-10">
									<p class="form-control-static" id='lbl_carrera_seleccionada'></p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 col-sm-2 control-label">Aplicar a:</label>
		

								<!--<div class="col-md-2 col-sm-2">
								  <label class="radio-inline control-label"><input type="radio" name="optradio"> Ciclo Lectivo</label>
								</div>-->
								  <label id='ciclo_lectivo_activo' class="control-label col-md-3 col-sm-3">Ciclo Lectivo:
								  </label>
								  <input type='hidden' name='txt_ciclo_lectivo_id' id='txt_ciclo_lectivo_id' value=''>

								<!--<div class="col-md-3 col-sm-3">
									<select name="cbociclo" id="cbociclo" class="table-group-action-input form-control">
										<option value="1">2014</option>
										<option value="2">2015</option>
									</select>
								</div>-->

								<!--<div class="col-md-2 col-sm-2">
								  <label class="radio-inline control-label"><input type="radio" name="optradio"> Periodo Lectivo</label>
								</div>

								<div class="col-md-3 col-sm-3">
									<select name="cboperiodo" id="cboperiodo" class="table-group-action-input form-control">
										<option value="1">1° Cuatrimestre</option>
										<option value="2">2° Cuatrimestre</option>
									</select>
								</div>-->

								  <!--label class="control-label col-md-2 col-sm-2">Período Lectivo: 
								  </label>
									<div class="col-md-3 col-sm-3">
										<select name="cboperiodo" id="cboperiodo" class="table-group-action-input form-control">
										</select>
									</div -->

							</div>
							<div class="form-group">
								<label class="col-md-2 col-sm-2 control-label" for="check_matricula_importe">Matrícula 
									<span class="checked"><input {{$disabled}} type="checkbox" class="form-control" id="check_matricula_importe" name="check_matricula_importe" ></span> 
								</label>
								
								<label class="col-md-1 col-sm-1 control-label">Importe:</label>

								<div class="col-md-2 col-sm-2">
									<input type="text" class="form-control" id="txtmatriculaimporte" name="txtmatriculaimporte" value="" readonly>
								</div>

								<label class="col-md-2 col-sm-2 control-label">Fecha Vencimiento:</label>
								
								<div class="col-md-2 col-sm-2">
									<input type="text" class="form-control" id="txtmatriculafechavencimiento" name="txtmatriculafechavencimiento" value="" readonly>
								</div>								
								<!--div class="col-md-1 col-sm-2">
									<div class="spinner">
										<div class="input-group input-xsmall">
											<input type="text" name="matricula_periodo_pago_desde" id="matricula_periodo_pago_desde" class="spinner-input form-control" maxlength="1" readonly>
											<div class="spinner-buttons input-group-btn btn-group-vertical">
												<button type="button" class="btn spinner-up btn-xs grey">
												<i class="fa fa-angle-up"></i>
												</button>
												<button type="button" class="btn spinner-down btn-xs grey">
												<i class="fa fa-angle-down"></i>
												</button>
											</div>
										</div>
									</div>									
								</div>

								<div class="col-md-1 col-sm-2">
									<div class="spinner">
										<div class="input-group input-xsmall">
											<input type="text" name="matricula_periodo_pago_hasta" id="matricula_periodo_pago_hasta" class="spinner-input form-control" readonly>
											<div class="spinner-buttons input-group-btn btn-group-vertical">
												<button type="button" class="btn spinner-up btn-xs grey">
												<i class="fa fa-angle-up"></i>
												</button>
												<button type="button" class="btn spinner-down btn-xs grey">
												<i class="fa fa-angle-down"></i>
												</button>
											</div>
										</div>
									</div>									
								</div -->
							</div>

							<div class="form-group">
								<label class="col-md-2 col-sm-2 control-label" for="check_cuota_importe">Cuota
									<span class="checked"><input {{$disabled}} type="checkbox" class="form-control" id="check_cuota_importe" name="check_cuota_importe"></span>
								</label>
								
								<label class="col-md-1 col-sm-1 control-label">Importe:</label>
								<div class="col-md-2 col-sm-2">
									<input type="text" class="form-control" id="txtcuotaimporte" name="txtcuotaimporte" value="" readonly>
								</div>

								<label class="col-md-2 col-sm-2 control-label">Día vencimiento:</label>
								<div class="col-md-1 col-sm-2">
									<div class="spinner">
										<div class="input-group input-xsmall">
											<input type="text" name="cuota_periodo_pago_hasta" id="cuota_periodo_pago_hasta" class="spinner-input form-control" maxlength="1" readonly>
											<div class="spinner-buttons input-group-btn btn-group-vertical">
												<button type="button" class="btn spinner-up btn-xs grey">
												<i class="fa fa-angle-up"></i>
												</button>
												<button type="button" class="btn spinner-down btn-xs grey">
												<i class="fa fa-angle-down"></i>
												</button>
											</div>
										</div>
									</div>									
								</div>								

								
							</div>

							<div class="form-group">
								<label class="col-md-2 col-sm-2 control-label">Empieza en:</label>
								<div class="col-md-2 col-sm-2">
									<select {{$disabled}} name="cboMesPagoCuotaInicio" id="cboMesPagoCuotaInicio" class="table-group-action-input form-control">
										<option value="0">Seleccionar</option>
										<option value="1">Enero</option>
										<option value="2">Febrero</option>
										<option value="3">Marzo</option>
										<option value="4">Abril</option>
										<option value="5">Mayo</option>
										<option value="6">Junio</option>
										<option value="7">Julio</option>
										<option value="8">Agosto</option>
										<option value="9">Setiembre</option>
										<option value="10">Octubre</option>
										<option value="11">Noviembre</option>
										<option value="12">Diciembre</option>
									</select>									
								</div>

								<label class="col-md-2 col-sm-2 control-label">Termina en:</label>
								<div class="col-md-2 col-sm-2" style="text-align: right;">
									<select {{$disabled}} name="cboMesPagoCuotaFin" id="cboMesPagoCuotaFin" class="table-group-action-input form-control">
										<option value="1">Enero</option>
										<option value="2">Febrero</option>
										<option value="3">Marzo</option>
										<option value="4">Abril</option>
										<option value="5">Mayo</option>
										<option value="6">Junio</option>
										<option value="7">Julio</option>
										<option value="8">Agosto</option>
										<option value="9">Setiembre</option>
										<option value="10">Octubre</option>
										<option value="11">Noviembre</option>
										<option value="12">Diciembre</option>
									</select>									
								</div>

								<label class="col-md-1 col-sm-1 control-label">Cant. Cuota:</label>
								<div class="col-md-2 col-sm-2">
									<input type="text" class="form-control" id="txtcantcuota" name="txtcantcuota" value="" readonly>
								</div>

								<!--div class="col-md-1 col-sm-2">
									<div class="spinner">
										<div class="input-group input-xsmall">
											<input type="text" name="cuota_periodo_pago_desde" id="cuota_periodo_pago_desde" class="spinner-input form-control" maxlength="1" readonly>
											<div class="spinner-buttons input-group-btn btn-group-vertical">
												<button type="button" class="btn spinner-up btn-xs grey">
												<i class="fa fa-angle-up"></i>
												</button>
												<button type="button" class="btn spinner-down btn-xs grey">
												<i class="fa fa-angle-down"></i>
												</button>
											</div>
										</div>
									</div>									
								</div>

								<div class="col-md-1 col-sm-2">
									<div class="spinner">
										<div class="input-group input-xsmall">
											<input type="text" name="cuota_periodo_pago_hasta" id="cuota_periodo_pago_hasta" class="spinner-input form-control" readonly>
											<div class="spinner-buttons input-group-btn btn-group-vertical">
												<button type="button" class="btn spinner-up btn-xs grey">
												<i class="fa fa-angle-up"></i>
												</button>
												<button type="button" class="btn spinner-down btn-xs grey">
												<i class="fa fa-angle-down"></i>
												</button>
											</div>
										</div>
									</div>									
								</div-->
							</div>

							<!-- CUOTAS POR CARRERA -->
							<!--<div class="form-group">
								<label class="control-label col-md-2 col-sm-2">Cuotas por carrera:</label>
								<div class="col-md-1 col-sm-1">
									<div class="spinner">
										<div class="input-group input-xsmall">
											<input type="text" name="cuotahasta" id="cuotahasta" class="spinner-input form-control" readonly="">
											<div class="spinner-buttons input-group-btn btn-group-vertical">
												<button type="button" class="btn spinner-up btn-xs grey">
												<i class="fa fa-angle-up"></i>
												</button>
												<button type="button" class="btn spinner-down btn-xs grey">
												<i class="fa fa-angle-down"></i>
												</button>
											</div>
										</div>
									</div>
								</div>-->

								<!-- CUOTAS POR CICLO -->
								<!--
								<label class="control-label col-md-2 col-sm-2">Cuotas por Ciclo:</label>
								<div class="col-md-1 col-sm-1">
									<div class="spinner">
										<div class="input-group input-xsmall">
											<input type="text" name="cuotahasta" id="cuotahasta" class="spinner-input form-control" readonly="">
											<div class="spinner-buttons input-group-btn btn-group-vertical">
												<button type="button" class="btn spinner-up btn-xs grey">
												<i class="fa fa-angle-up"></i>
												</button>
												<button type="button" class="btn spinner-down btn-xs grey">
												<i class="fa fa-angle-down"></i>
												</button>
											</div>
										</div>
									</div>
								</div>-->

							</div>
						</div>
						{{ Form::close()}}
						</div>
					</div>	
				</div>
			</div>
			<!-- FIN DEL CONTENIDO -->
		</div>
	</div>
	<!-- FIN -->

	<!-- MODAL AVISOS-->
	<div class="modal fade" id="modalMensajes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Mensaje</h4>
				</div>
				<div class="modal-body">
					 <p>La organización no tiene carreras cargadas.</p>
				</div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn default"><i class="fa fa-times-circle-o"></i> Cerrar</button>
				</div>
			</div>
		</div>
	</div>

	<!-- MODAL AVISOS-->
	<div class="modal fade" id="modalMensajesCiclo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Mensaje</h4>
				</div>
				<div class="modal-body">
					 <p>La organización no tiene ciclo lectivo activo.</p>
				</div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn default"><i class="fa fa-times-circle-o"></i> Cerrar</button>
				</div>
			</div>
		</div>
	</div>	

@stop


@section('customjs')
	ComponentsFormTools.init();
	$('.spinner').spinner({value:1, min: 1, max: 25});

	function habilitar_campos_matricula() {
        $('#txtmatriculaimporte').prop("readonly",false);
        $('#txtmatriculafechavencimiento').prop("readonly",false);
        $('#txtmatriculaimporte').focus();
    }

	function deshabilitar_campos_matricula() {
		$('#check_matricula_importe').prop('checked', false);
        $("#check_matricula_importe").parent().removeClass("checked");
	    $('#txtmatriculaimporte').val('');
	    $('#txtmatriculafechavencimiento').val('');
        $('#txtmatriculafechavencimiento').prop("readonly",true);
        $('#txtmatriculaimporte').prop("readonly",true);
    }

	function habilitar_campos_cuota() {
        $('#txtcuotaimporte').prop("readonly",false);
        $('#cuota_periodo_pago_hasta').prop("readonly",false);
        $('#cboMesPagoCuotaInicio').val(1);
        $('#txtcuotaimporte').focus();
    }

	function deshabilitar_campos_cuota() {
        $('#check_cuota_importe').prop('checked', false);
        $("#check_cuota_importe").parent().removeClass("checked");
	    $('#txtcuotaimporte').val('');
        $('#cuota_periodo_pago_hasta').val('1');
        $('#txtcuotaimporte').prop("readonly",true);
        $('#cuota_periodo_pago_hasta').prop("readonly",true);
        $('#cboMesPagoCuotaInicio').val(0);
    }

    // HABILITA CAMPOS MATRICULA
	$('#check_matricula_importe').click(function() {
	    if ($('#check_matricula_importe').is(':checked')) {
	        habilitar_campos_matricula();
	    } else {
	        deshabilitar_campos_matricula();
	    }
	});

    // HABILITA CAMPOS PAGOS CUOTAS
	$('#check_cuota_importe').click(function() {
	    if ($('#check_cuota_importe').is(':checked')) {
	        habilitar_campos_cuota();
	    } else {
	        deshabilitar_campos_cuota();
	    }
	});

	$('#cboCarrera').change(function() {
	    borrar_historico_matriculas();
	    deshabilitar_campos_matricula();
	    deshabilitar_campos_cuota();
	    $('#txt_matricula_id').val('');

	    if ($('#cboCarrera').val() == 0) {
	        $('#lbl_carrera_seleccionada').text('');
	        return;
	    }
	    $('#lbl_carrera_seleccionada').text($('#cboCarrera option:selected').text());

        // crear tabla historico matriculas
        var organizacion_id = $('#cboOrganizacion').val();
        var carrera_id = $('#cboCarrera').val();

		$.ajax({
		  url: "{{url('matriculas/obtenerhistorico')}}",
		  data:{'organizacion_id': organizacion_id, 'carrera_id': carrera_id},
		  type: 'POST'
		}).done(function(matriculas) {
			console.log(matriculas);

            var acciones;
            var cantcuota;
			$.each(matriculas, function(key, matricula) {
			    if (matricula.ciclolectivo.activo == 1) {
			    	acciones = "<a title='Modificar' {{$disabled}} data-id='" + matricula.id + "' id='btnModificar' class='btn default btn-xs purple'>" +
				      "<i class='fa fa-edit'></i></a>" +
				      "<a title='Eliminar' @if (!$eliminar) {{'DISABLED'}} @endif class='btn default btn-xs red' href='eliminar/" + matricula.id + "'>" +
				      "<i class='fa fa-trash-o'></i></a>";
			    } else {
			        acciones = '';
			    }

			    if (matricula.mespagocuotafin == null) {
			    	var mespagocuotafin = 0;
			    } else {
			    	var mespagocuotafin = matricula.mespagocuotafin;
			    }

			    if (matricula.mespagocuotainicio == null) {
			    	var mespagocuotainicio = 0;
			    } else {
			    	var mespagocuotainicio = matricula.mespagocuotainicio;
			    }

			    cantcuota = mespagocuotafin - mespagocuotainicio + 1;

			    if (cantcuota < 0) {
			    	cantcuota = matricula.cuotasporperiodo;
			    }

				$('#tableHistoricoMatriculas > tbody').append(
				  '<tr class=info>' +
				    '<td>' + matricula.ciclolectivo.descripcion + '</td>' +
				    '<td>$' + matricula.matriculaimporte + '</td>' +
				    '<td>' + cantcuota + '</td>' +
				    '<td>$' + matricula.cuotaimporte + '</td>' +
				    //'<td>1'-' + matricula.cuotaperiodopagohasta + '</td>' +
				    '<td><center>' + acciones + '</center></td>' +
				  '</tr>'
				);
			});
		}).error(function(data) {
			console.log(data);
		});
	});

	$('#cboOrganizacion').select2({
		placeholder: "Seleccione",
		allowClear: true
	});

	$('#cbocomienzaen').select2({
		placeholder: "Seleccione",
		allowClear: true
	});

    $("#txtmatriculafechavencimiento").inputmask("dd/mm/yyyy", {
        "placeholder": "__/__/____"
    });
	
	$('#cboOrganizacion').change(function() {
	    deshabilitar_campos_matricula();
	    deshabilitar_campos_cuota();

	    var organizacion_id = $('#cboOrganizacion').val();
	    $('#txt_matricula_id').val('');

        $('#ciclo_lectivo_activo').text('Ciclo Lectivo:');
        $('#txt_ciclo_lectivo_id').val('');
        $('#cboCarrera').children().remove().end();
        $('#lbl_carrera_seleccionada').text('');

        borrar_historico_matriculas();

	    if (organizacion_id == 0) return;

	    $('#lbl_carrera_seleccionada').text('');

		$.ajax({
		  url: "{{url('matriculas/obtenercicloactivo')}}",
		  data:{'organizacion_id': organizacion_id},
		  type: 'POST'
		}).done(function(ciclo) {
			console.log(ciclo);
			if (ciclo == <?php echo MatriculasController::NO_EXISTE_CICLO_ACTIVO ?>) {
				$('#modalMensajesCiclo').modal('show');
				return;
		    }

		    $('#ciclo_lectivo_activo').text('Ciclo Lectivo: ' + ciclo.descripcion);
		    $('#txt_ciclo_lectivo_id').val(ciclo.id);
		    
		    var fechafin = ciclo.fechafin;
		    var afechafin = fechafin.split("/");

		    var combo = document.forms["FrmMatricula"].cboMesPagoCuotaFin;
		   	var cantidad = combo.length;
		   	for (i = 0; i < cantidad; i++) {
		      	if (combo[i].value == parseInt(afechafin[1])) {
		         	combo[i].selected = true;
		      	}   
		   	}	

		}).error(function(data){
			console.log(data);
		});

		$.ajax({
		  url: "{{url('organizacions/obtenercarreras')}}",
		  data:{'organizacion_id': organizacion_id},
		  type: 'POST'
		}).done(function(carreras) {
			console.log(carreras);
			if (carreras == <?php echo OrganizacionsController::NO_TIENE_CARRERAS ?>) {
				$('#modalMensajes').modal('show');
				return;
		    }

			$('#cboCarrera').append(
		        $('<option></option>').val(0).html('Seleccionar')
		    );

			$.each(carreras, function(key, value) {
				$('#cboCarrera').append(
			        $('<option></option>').val(value.id).html(value.carrera)
			    );
			});
		}).error(function(data){
			console.log(data);
		});
	});

    // BORRAR FILAS DE LA TABLA HISTORICO MATRICULAS
    function borrar_historico_matriculas() {
	    var n = 0;
		$('#tableHistoricoMatriculas tr').each(function() {
		   if (n > 0) $(this).remove();
		   n++;
		});
    }

    $('#btnModificar').live('click', function() {
		$.ajax({
		  url: "{{url('matriculas/editar')}}",
		  data:{'id': $(this).data('id')},
		  type: 'POST'
		}).done(function(matricula) {
			console.log(matricula);
			if (matricula.matriculaaplica == 1) {
			    var fecha = getFechaImpresion(matricula.fechavencimientomatricula);
				$('#check_matricula_importe').prop('checked', true);
	            $("#check_matricula_importe").parent().addClass("checked");
	            habilitar_campos_matricula();
		        $('#txtmatriculaimporte').val(matricula.matriculaimporte);
		        $('#txtmatriculafechavencimiento').val(fecha);
		    } else {
		    	deshabilitar_campos_matricula();
		    }
			if (matricula.cuotaaplica == 1) {
				$('#check_cuota_importe').prop('checked', true);
	            $("#check_cuota_importe").parent().addClass("checked");
				habilitar_campos_cuota();
		        $('#txtcuotaimporte').val(matricula.cuotaimporte);
		        $('#cuota_periodo_pago_hasta').val(matricula.cuotaperiodopagohasta);
		        $('#cboMesPagoCuotaInicio').val(matricula.mespagocuotainicio);
		    } else {
		    	deshabilitar_campos_cuota();
		    }
		    $('#txt_matricula_id').val(matricula.id);
		}).error(function(data){
			console.log(data);
		});
    });

	$('#cboMesPagoCuotaInicio').change(function() {
		var cantcuota = 0;
	    var cuotainicio = $('#cboMesPagoCuotaInicio').val();
	    var cuotafin = $('#cboMesPagoCuotaFin').val();
	    $('#txtcantcuota').val('');

	    if (cuotainicio == 0) return;

	    if (parseInt(cuotainicio) > parseInt(cuotafin)) {
	    	return;
	    } else {
	    	cantcuota = cuotafin - cuotainicio + 1;
	    }

	    $('#txtcantcuota').val(cantcuota);
	});

	$('#cboMesPagoCuotaFin').change(function() {
		var cantcuota = 0;
	    var cuotainicio = $('#cboMesPagoCuotaInicio').val();
	    var cuotafin = $('#cboMesPagoCuotaFin').val();
	    $('#txtcantcuota').val('');

	    if (cuotainicio == 0) return;

	    if (parseInt(cuotainicio) > parseInt(cuotafin)) {
	    	return;
	    } else {
	    	cantcuota = cuotafin - cuotainicio + 1;
	    }

	    $('#txtcantcuota').val(cantcuota);
	});

@stop

@section('includejs') 
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{url('assets/global/plugins/select2/select2.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/global/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js')}}"></script>
<script type="text/javascript" src="{{url('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/global/plugins/fuelux/js/spinner.min.js')}}"></script>
<script src="{{url('assets/admin/pages/scripts/components-form-tools.js')}}"></script>

<script src="{{url('assets/admin/layout/scripts/menusticky.js')}}" type="text/javascript"></script>
<script src="{{url('assets/admin/pages/scripts/getFechaImpresion.js')}}"></script>
<!-- END PAGE LEVEL PLUGINS -->
@stop
