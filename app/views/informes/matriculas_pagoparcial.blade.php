
@extends('layouts.master')

@section('customstyle')
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/select2/select2.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css')}}"/>
@stop
<?php
$totalparcial = 0;
$totalsaldo = 0;

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
					Informes <small>pagos parcial de matrícula (pdf)</small>
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
								<i class="fa fa-users"></i>Pagos Parcial de Matrículas
							</div>
							<div class="actions">
								<!--a href="{{url('alumnos/crear')}}" @if (!$editar) {{'DISABLED'}} @endif class="btn default blue-stripe" >
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Nuevo</span>
								</a-->
								<a target="_blank" href="#" id="imprimir_pagos" class="btn default yellow-stripe" <?php if ($habilita == false) echo "disabled";?>>
								<i class="fa fa-print"></i>
								<span class="hidden-480">
								Imprimir </span>
								</a>

							</div>

						</div>
						<div class="portlet-body">
							<div class="form-body">
								<form method="POST" action="{{url('matriculas/obtenermovimientos')}}" class="form-horizontal form-row-seperated" id="FrmMatriculalistado" name="">
								<div class="form-group">
									<label  class="col-md-2 col-sm-2 control-label" for="organizacion">Organización:</label>
									<div class="col-md-6 col-sm-12">
										{{ Form::select('cboOrganizacion', $organizaciones, Input::old('cboOrganizacion'), array('class'=>'table-group-action-input form-control','id'=>'cboOrganizacion')) }}
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 col-sm-2 control-label" for="filtro">Carreras:</label>
									<div class="col-md-6 col-sm-12">
										<select name="cboCarreras" id="cboCarreras" class="table-group-action-input form-control">
											@if (isset($carrera))
												@foreach ($carreras as $carrer)
													<option value="{{$carrer->id}}" <?php if ($carrera->id == $carrer->id) echo "selected=selected"; ?>>{{$carrer->carrera}}</option>
												@endforeach
											@endif
										</select>
									</div>
								</div>

								<div class='form-group'>
									<label class="col-md-2 col-sm-2 control-label" for="filtro">Filtrar por:</label>
									<div class="col-md-2 col-sm-3">
										<select name="cboFiltros" id="cboFiltros" class="table-group-action-input form-control">
											@if (isset($filtroalumno))
												<option value="0" <?php if ($filtroalumno == 0) echo "selected=selected"; ?>>Todos</option>
												<option value="1" <?php if ($filtroalumno == 1) echo "selected=selected"; ?>>Documento</option>
												<option value="2" <?php if ($filtroalumno == 2) echo "selected=selected"; ?>>Apellido y Nombre</option>
											@else
												<option value="0">Todos</option>
												<option value="1">DNI</option>
												<option value="2">Apellido y Nombre</option>
											@endif
										</select>
									</div>
									<div class="col-md-4 col-sm-7">
										<input type='text' name="txtFiltro" id="txtFiltro" class="table-group-action-input form-control" value="<?php if (isset($txtdni)) echo $txtdni; ?>" <?php if ($filtroalumno == 0) echo "disabled"; ?>>
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
									
									<div class="col-md-2 col-sm-2">
											<button class="btn btn-primary" type="submit" id='BtnBuscar'><i class="fa fa-search"></i> Buscar</button>
									</div>
									<!--div class="col-md-2 col-sm-2">
										<button class="btn btn-primary" type="submit" id='BtnBuscar'><i class="fa fa-search"></i> Buscar</button>
									</div-->
									<!--div class="col-md-2 col-sm-2">
										<a class="btn blue-madison" id='BtnBuscar'>
											<i class="fa fa-search"></i> Buscar
										</a>
									</div-->
								</div>
								</form>
								<br>

								<table class="table table-striped table-bordered table-hover" id="table_informes">
									<thead>
										<tr>
											<th><center>Apellido y Nombre</center></th>
											<th><center>N° Documento</center></th>
											<th><center>Importe</center></th>
											<th><center>Pago Parcial</center></th>
											<th><center>Saldo Matricula</center></th>
											<!--th><center>Pagado ($)</center></th>
											<th><center>Fecha Vto.</center></th>
											<th><center>Fecha Pago</center></th-->
										</tr>
									</thead>
									<tbody>
									@if (isset($todomovimiento))
										@foreach ($todomovimiento as $todomovimient)
											<tr>
												<td>
													<center>
														{{ $todomovimient['apeynom'] }}
													</center>
												</td>
												<td>
													<center>
														{{ $todomovimient['dni'] }}
													</center>
												</td>
												<td>
													<center>
														{{ $todomovimient['importe'] }}
													</center>
												</td>
												<td>
													<center>
														{{ $todomovimient['importeparcial'] }}
													</center>
												</td>
												<td>
													<center>
														${{ $todomovimient['saldo'] }}
													</center>
												</td>
											</tr>
											<?php
											$totalparcial = $totalparcial + $todomovimient['importeparcial'];
											$totalsaldo = $totalsaldo + $todomovimient['saldo'];
											?>
										@endforeach
											
									@endif
									</tbody>
								</table>

								@if (isset($todomovimiento))
								<table class="table table-striped table-bordered table-hover" id="table_movimientos">
								<thead>
									<tr>
										<th>
											<center><p style="color: white;">APELLIDO Y NOMBRE</p></center>
										</th>
										<th class="hidden-xs">
											<center><p style="color: white;">N° DOCUMENTO</p></center>
										</th>
										<th>
											<center><p style="color: white;">IMPORTE</p></center>
										</th>
										<th>
											<center>Total Parcial</center>
										</th>
										<th>
											<center>Total Saldo</center>
										</th>
									</tr>
								</thead>
								<tbody>
									<tr style="background-color: #f2f2f2">
										<td>
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
													${{ $totalparcial }}
												</strong></font>
											</center>
										</td>
										<td>
											<center><font size=4>
												<strong>
													${{ $totalsaldo }}
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

    //$("#txtFiltro").attr('disabled', 'disabled');
    //$("#BtnBuscar").attr('disabled', 'disabled');

    /* DESHABILITO EL ENTER EN EL CONTROL */
	$('#txtFiltro').keypress(function(e) {
	    if (e.which == 13)
	        return false;
	});

    $('#fechadesde').on('change', function(){
    	$('#BtnBuscar').removeAttr("disabled");
    });

    $('#BtnBuscar').click(function() {
    	limpiar_tabla();
    });

    $('#cboCarreras').change(function() {
    	limpiar_tabla();
    });

    $('#cboOrganizacion').change(function() {
    	limpiar_tabla();

		$('#cboCarreras').children().remove().end();

		if ($('#cboOrganizacion').val() == 0) return;

		$.ajax({
		  url: '{{url('organizacions/obtenercarrerasconmatricula')}}',
		  data:{'organizacion_id': $('#cboOrganizacion').val()},
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
    });

	$('#cboFiltros').on('change', function(){
		if ($('#cboFiltros').val() == 0) {
    		$("#txtFiltro").val('');
    		$("#txtFiltro").attr('disabled', 'disabled');
    	}

    	if ($('#cboFiltros').val() == 1) {
    		$("#txtFiltro").val('');
    		$("#txtFiltro").attr("placeholder", "Documento").val("").focus().blur();
    		$("#txtFiltro").removeAttr("disabled");
    	}

    	if ($('#cboFiltros').val() == 2) {
    		$("#txtFiltro").val('');
    		$("#txtFiltro").attr("placeholder", "Apellido, Nombres").val("").focus().blur();
    		$("#txtFiltro").removeAttr("disabled");
    	}
	});	

    function limpiar_tabla() {
	    var n = 0;
		$('#table_informes tr').each(function() {
		   if (n > 0) $(this).remove();
		   n++;
		});

	    var n = 0;
		$('#table_movimientos tr').each(function() {
		   if (n > 0) $(this).remove();
		   n++;
		});
		$('#imprimir_pagos').attr('disabled', 'disabled');
    }

	$('#imprimir_pagos').on('click', function(e){
		e.preventDefault();
		window.open("{{url('matriculas/imprimirinforme')}}?fechadesde=" + $('#fechadesde').val() + '&fechahasta=' + $('#fechahasta').val() + '&dni=' + $('#txtFiltro').val() + '&carrera=' + $('#cboCarreras').val() + '&filtro=' + $('#cboFiltros').val());
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
