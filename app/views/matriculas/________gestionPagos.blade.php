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
						<li class="btn-group">
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
						</li>
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('/')}}">Inicio</a>
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
								<button type='submit' class="btn default green-stripe">
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Guardar </span>
								</button>
								<a href="listado" class="btn default yellow-stripe">
								<i class="fa fa-reorder"></i>
								<span class="hidden-480">
								Listado </span>
								</a>
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
								<table class="table table-hover">
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
									<th>
										 <i class="fa fa-calendar"></i> Período de pago
									</th>
								</tr>
								</thead>
								<tbody>
								<tr class="info">
									<td>
										 2014
									</td>
									<td>
										 $200
									</td>
									<td>
										 10
									</td>										
									<td>
										 $600
									</td>
									<td>
										 1-10
									</td>
								</tr>
								</tbody>
								</table>
							</div>
						</div>
					</div>


					<div class="portlet form-horizontal">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-user"></i>Datos de matrículas y/o cuotas
							</div>
						</div>
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

								  <label class="control-label col-md-2 col-sm-2">Periodo Lectivo: 
								  </label>
									<div class="col-md-3 col-sm-3">
										<select name="cboperiodo" id="cboperiodo" class="table-group-action-input form-control">
										</select>
									</div>

							</div>
							<div class="form-group">
								<label class="col-md-2 col-sm-2 control-label" for="check_matricula_importe">Matricula 
									<span class="checked"><input type="checkbox" class="form-control" id="check_matricula_importe" name="check_matricula_importe" ></span> 
								</label>
								
								<label class="col-md-1 col-sm-1 control-label">Importe:</label>

								<div class="col-md-2 col-sm-2">
									<input type="text" class="form-control" id="txtmatriculaimporte" name="txtmatriculaimporte" value="" readonly>
								</div>

								<label class="col-md-2 col-sm-2 control-label">Periodo pago:</label>
								
								<div class="col-md-1 col-sm-2">
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
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-2 col-sm-2 control-label" for="check_cuota_importe">Cuota
									<span class="checked"><input type="checkbox" class="form-control" id="check_cuota_importe" name="check_cuota_importe"></span>
								</label>
								
								<label class="col-md-1 col-sm-1 control-label">Importe:</label>

								<div class="col-md-2 col-sm-2">
									<input type="text" class="form-control" id="txtcuotaimporte" name="txtcuotaimporte" value="" readonly>
								</div>

								<label class="col-md-2 col-sm-2 control-label">Periodo pago:</label>
								
								<div class="col-md-1 col-sm-2">
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
								</div>

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

								<!-- CUOTAS POR PERIODO -->
								<label class="control-label col-md-2 col-sm-2">Cuotas por Periodo:</label>
								<div class="col-md-1 col-sm-1">
									<div class="spinner">
										<div class="input-group input-xsmall">
											<input type="text" name="cuotas_por_periodo" id="cuotas_por_periodo" class="spinner-input form-control" readonly>
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
@stop


@section('customjs')
	ComponentsFormTools.init();
	$('.spinner').spinner({value:1, min: 1, max: 12});

	function habilitar_campos_matricula() {
        $('#txtmatriculaimporte').prop("readonly",false);
        $('#matricula_periodo_pago_desde').prop("readonly",false);
        $('#matricula_periodo_pago_hasta').prop("readonly",false);
        $('#txtmatriculaimporte').focus();
    }

	function desabilitar_campos_matricula() {
        $('#txtmatriculaimporte').prop("readonly",true);
        $('#matricula_periodo_pago_desde').prop("readonly",true);
        $('#matricula_periodo_pago_hasta').prop("readonly",true);
    }

	function habilitar_campos_cuota() {
        $('#txtcuotaimporte').prop("readonly",false);
        $('#cuota_periodo_pago_desde').prop("readonly",false);
        $('#cuota_periodo_pago_hasta').prop("readonly",false);
        $('#cuotas_por_periodo').prop("readonly",false);
        $('#txtcuotaimporte').focus();
    }

	function desabilitar_campos_cuota() {
        $('#txtcuotaimporte').prop("readonly",true);
        $('#cuota_periodo_pago_desde').prop("readonly",true);
        $('#cuota_periodo_pago_hasta').prop("readonly",true);
        $('#cuotas_por_periodo').prop("readonly",true);
    }

    // HABILITA CAMPOS MATRICULA
	$('#check_matricula_importe').click(function() {
	    if ($('#check_matricula_importe').is(':checked')) {
	        habilitar_campos_matricula();
	    } else {
	        desabilitar_campos_matricula();
	    }
	});

    // HABILITA CAMPOS PAGOS CUOTAS
	$('#check_cuota_importe').click(function() {
	    if ($('#check_cuota_importe').is(':checked')) {
	        habilitar_campos_cuota();
	    } else {
	        desabilitar_campos_cuota();
	    }
	});

	$('#cboCarrera').change(function() {
	    if ($('#cboCarrera').val() == 0) {
	        $('#lbl_carrera_seleccionada').text('');
	        return;
	    }
	    $('#lbl_carrera_seleccionada').text($('#cboCarrera option:selected').text());
	});

	$('#cboOrganizacion').change(function() {
	    var organizacion_id = $('#cboOrganizacion').val();

        $('#ciclo_lectivo_activo').text('Ciclo Lectivo:');
        $('#txt_ciclo_lectivo_id').val('');
        $('#cboperiodo').children().remove().end();
        $('#cboCarrera').children().remove().end();
        $('#lbl_carrera_seleccionada').text('');

	    if (organizacion_id == 0) return;

	    $('#lbl_carrera_seleccionada').text('');
		$.ajax({
		  url: "{{url('matriculas/obtenercicloactivo')}}",
		  data:{'organizacion_id': organizacion_id},
		  type: 'POST'
		}).done(function(ciclo) {
			console.log(ciclo);
			if (ciclo == <?php echo MatriculasController::NO_EXISTE_CICLO_ACTIVO ?>) {
				alert('LA ORGANIZACIÓN NO TIENE CICLO LECTIVO ACTIVO');
				return;
		    }

		    $('#ciclo_lectivo_activo').text('Ciclo Lectivo: ' + ciclo.descripcion);
		    $('#txt_ciclo_lectivo_id').val(ciclo.id);

			$.each(ciclo.periodos_lectivos, function(key, value) {
				$('#cboperiodo').append(
			        $('<option></option>').val(value.id).html(value.descripcion)
			    );
			});
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
				alert('LA ORGANIZACIÓN NO TIENE CARRERAS CARGADAS');
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
<!-- END PAGE LEVEL PLUGINS -->
@stop