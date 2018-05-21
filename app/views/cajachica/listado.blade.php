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
</style>
@stop
<?php
//BOTONES Y CAMPOS DE PERMISOS
$disabled 	= (!$editar) ? 'disabled' : '';
$readonly 	= (!$editar) ? 'readonly' : '';
$imprimir 	= (!$imprimir) ? 'disabled' : '';
$orgId 		= (isset($OrgID)) ? $OrgID : 0;
/*if (isset($todomovimiento)) {
	highlight_string(var_export($todomovimiento, true));
	exit();
}*/
$total = 0;
$totalingreso = 0;
$totalegreso = 0;
$movi = 0;
if (isset($todomovimiento)) {
	foreach ($todomovimiento as $todomovimient) {
		$totalingreso += $todomovimient['ingreso'];
		$totalegreso += $todomovimient['egreso'];
		$movi = $todomovimient['movimiento'];
	}
}
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
					Contable <small>Caja Chica</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('cajachica/listado')}}">Caja Chica</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('cajachica/listado')}}">Listado</a>
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
					    @if (Session::get('message_type') == CajaChicaController::OPERACION_EXITOSA)

					        <div class="note note-success">
								<p>{{ Session::get('message') }}</p>
							</div>

						@elseif (Session::get('message_type') == CajaChicaController::OPERACION_FALLIDA)

					        <div class="note note-danger">
								<p>{{ Session::get('message') }}</p>
							</div>

						@elseif (Session::get('message_type') == CajaChicaController::OPERACION_CANCELADA)

					        <div class="note note-warning">
								<p>{{ Session::get('message') }}</p>
							</div>

						@elseif (Session::get('message_type') == CajaChicaController::OPERACION_INFO)

					        <div class="note note-info">
								<p>{{ Session::get('message') }}</p>
							</div>

						@endif
					@endif
					<!-- COMIENZO DE LA TABLA-->
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-files-o"></i>Listado de Caja Chica
							</div>
							<div class="actions">
								<a href="{{url('cajachica/crear')}}" {{ $disabled }} class="btn default blue-stripe">
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Nuevo </span>
								</a>
								<a href="{{url('cajachica/listado')}}" class="btn default yellow-stripe">
								<i class="fa fa-refresh"></i>
								<span class="hidden-480">
								Actualizar </span>
								</a>
								<a target="_blank" href="#" id="imprimir" class="btn default yellow-stripe"  {{ $imprimir }} <?php if (!isset($todomovimiento)) echo 'disabled' ?>>
								<i class="glyphicon glyphicon-list-alt"></i>
								<span class="hidden-480">
								Imprimir </span>
								</a>

							</div>

						</div>
						<div class="portlet-body">
							<div class="form-body">
								<form method="POST" action="{{url('cajachica/obtenermovimientos')}}" class="form-horizontal form-row-seperated" id="FrmPlanestudios" name="">
									<div class="form-group">
										<label  class="col-md-2 col-sm-2 control-label">Organización:</label>
										<div class="col-md-6 col-sm-10">
											{{ Form::select('organizacion', $organizaciones, Input::old('organizacion'), array('class'=>'table-group-action-input form-control','id'=>'organizacion')) }}
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-2 col-sm-2 control-label" for="movimiento">Movimiento:</label>
										<div class="col-md-6 col-sm-10">
											<select class="table-group-action-input form-control" name="movimiento" id="movimiento">
											@if (isset($movimiento))
												<option value="1" <?php if ($movimiento == 1) echo "selected=selected"; ?>>Ingresos</option>
												<option value="0" <?php if ($movimiento == 0) echo "selected=selected"; ?>>Egresos</option>
												<option value="2" <?php if ($movimiento == 2) echo "selected=selected"; ?>>Ambos</option>
											@else
												<option value="1">Ingresos</option>
												<option value="0">Egresos</option>
												<option value="2">Ambos</option>
											@endif
											</select>
											@if ($errors->has('movimiento'))
											    <span class="help-block">{{ $errors->first('movimiento') }}</span>
										    @endif
										</div>

										<!--div class="col-md-2 col-sm-2">
											<button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> Buscar</button>
										</div-->				
									</div>

									<div class="form-group">
										<label class="col-md-2 col-sm-2 control-label" for="cboFiltroAlumno">Filtrar Alumno:</label>
										<div class="col-md-3 col-sm-10">
											<select class="table-group-action-input form-control" name="cboFiltroAlumno" id="cboFiltroAlumno">
											@if (isset($filtroalumno))
												<option value="0" <?php if ($filtroalumno == 0) echo "selected=selected"; ?>>Todos</option>
												<option value="1" <?php if ($filtroalumno == 1) echo "selected=selected"; ?>>Documento</option>
											@else
												<option value="0">Todos</option>
												<option value="1">Documento</option>
											@endif
											</select>
										</div>
										<div class="col-md-4 col-sm-4">
											<input class="form-control" name="txtalumno" id="txtalumno" type="text" placeholder="N° Documento" value="<?php if (isset($txtalumno)) echo $txtalumno; ?>" <?php if (!isset($txtalumno)) echo "disabled"; ?>>
										</div>
				
										<div class="col-md-2 col-sm-2">
											<a class="btn blue-madison" id='BtnBuscardni'>
												<i class="fa fa-search"></i>
											</a>
										</div>
									</div>

									<div class="portlet-body form">
										<div class="form-group">
											<label  class="col-md-2 col-sm-2 control-label text-info">Alumno:</label>
											<div class="col-md-2 col-sm-4" id='divAlumno'><?php if (isset($divAlumno)) echo '<p class="form-control-static">'.$divAlumno.'</p>'; ?></div>
											<input class="form-control" name="divAlumnos" id="divAlumnos" type="hidden" value="<?php if (isset($divAlumno)) echo $divAlumno; ?>">
											<label  class="col-md-2 col-sm-2 control-label text-info">DNI:</label>
											<div class="col-md-2 col-sm-4" id='divDNI'><?php if (isset($txtalumno)) echo '<p class="form-control-static">'.$txtalumno.'</p>'; ?></div>
				  							<input id="txt_alumno_id" name='txt_alumno_id' type="hidden" value="<?php if (isset($txt_alumno_id)) echo $txt_alumno_id; ?>">
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
											<a class="btn blue-madison" id='BtnBuscar'>
												<i class="fa fa-search"></i> Buscar
											</a>
										</div-->
									</div>
								</form>
							</div>
							<br>

							<table class="table table-striped table-bordered table-hover" id="table_movimiento">
								<thead>
								<tr>
									<th class="hidden-xs">
										<center><i class="fa fa-calendar"></i> Fecha</center>
									</th>
									<th>
										<center><i class="fa fa-files-o"></i> Concepto</center>
									</th>
									<th>
										<center><i class="fa fa-user"></i> Apellido y Nombre</center>
									</th>
									<th>
										<center><i class="glyphicon glyphicon-check"></i> Comprobante</center>
									</th>
									<th>
										<center><i class="glyphicon glyphicon-save-file"></i> N° Comprobante</center>
									</th>
									<th>
										<center><i class="glyphicon glyphicon-thumbs-up"></i> Ingreso</center>
									</th>
									<th>
										<center><i class="glyphicon glyphicon-thumbs-down"></i> Egreso</center>
									</th>	
									<th>
										<center><i class="glyphicon glyphicon-pencil"></i> Acciones</center>
									</th>			

								</tr>
								</thead>
								<tbody>
									@if (isset($todomovimiento))
										@foreach ($todomovimiento as $todomovimient)
											<tr>
												<td>
													<center>
														{{ $todomovimient['fecha'] }}
													</center>
												</td>
												<td>
													<center>
														{{ $todomovimient['concepto'] }}
													</center>
												</td>
												<td>
													<center>
														{{ $todomovimient['apeynom'] }}
													</center>
												</td>
												<td>
													<center>
														{{ $todomovimient['tipomovimiento'] }}
													</center>
												</td>
												<td>
													<center>
														{{ $todomovimient['comprobante'] }}
													</center>
												</td>
												<td>
													<center>
														${{ $todomovimient['ingreso'] }}
													</center>
												</td>
												<td>
													<center>
														${{ $todomovimient['egreso'] }}
													</center>
												</td>													
												<td>
													<center>
														<a title="Modificar" href="{{url('cajachica/editar/' . $todomovimient['id'])}}" class="btn default btn-xs purple">
															<i class="fa fa-edit"></i>
														</a>
														<a target="_blank" href="{{url('cajachica/pdfimprimirrecibo/' . $todomovimient['id'])}}" data-id=""  class="btn default btn-xs red" <?php if ($todomovimient['alumno_id'] == 'disabled') echo "disabled"; ?>>
															<i title="Imprimir" class="glyphicon glyphicon-print"></i>
														</a>
													</center>
												</td>
											</tr>
										@endforeach
											
									@endif
								</tbody>
							</table>
							@if (isset($todomovimiento))
							<table class="table table-striped table-bordered table-hover" id="table_movimientos">
							<thead>
								<tr>
									<th class="hidden-xs">
										<center><p style="color: white;">FECHA</p></center>
									</th>
									<th>
										<center><p style="color: white;">CONCEPTO</p></center>
									</th>
									<th>
										<center><p style="color: white;">APELLIDO Y NOMBRE</p></center>
									</th>
									<th>
										<center><p style="color: white;">TIPO COMPROBANTE</p></center>
									</th>
									<th>
										<center><p style="color: white;">COMPROBANTE</p></center>
									</th>
									<th>
										<center><i class="glyphicon glyphicon-thumbs-up"></i> Ingreso</center>
									</th>
									<th>
										<center><i class="glyphicon glyphicon-thumbs-down"></i> Egreso</center>
									</th>	
									<th>
										<center><p style="color: white;">ACCIONES</p></center>
									</th>			

								</tr>
							</thead>
							<tbody>
								<tr style="background-color: #f2f2f2">
									<td>
										
									</td>
									<td>
										
									</td>
									<td colspan="2">
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
										<center><font size=4>
											<strong>
												${{ $totalingreso }}
											</strong></font>
										</center>
									</td>
									<td>
										<center><font size=4>
											<strong>
												${{ $totalegreso }}
											</strong></font>
										</center>
									</td>
									<td>
										
									</td>
								</tr>
								<?php 
								if ($movi == 1) { ?>
									<tr>
										<td>
											
										</td>
										<td>
											
										</td>
										<td>
											<center>
												<font size=4>
													<strong>
														SALDO
													</strong>
												</font>
											</center>
										</td>
										<td>
											<center>
												<font size=4>
													<strong>$
														<?php $saldo = $totalingreso - $totalegreso;
														echo $saldo; ?>
													</strong>
												</font>
											</center>
										</td>
										<td>
											
										</td>
										<td>
											
										</td>
										<td>
											
										</td>
									</tr>
								<?php } ?>
								</tbody>
							</table>
							@endif

							<!-- MODAL-->
							<div class="modal fade" id="MensajeCantidad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h4 class="modal-title">Atención!</h4>
											</div>
											<div class="modal-body">
												La Fecha Desde no debe ser mayor a la fecha Hasta!!
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
					<!-- FIN DE LA TABLA-->
				</div>
			</div>
			<!-- FIN DEL CONTENIDO -->
		</div>
	</div>
	<!-- FIN -->

@stop


@section('customjs')
	$(document).ready(function() {
	    $('#table_movimiento').DataTable();
	});

	$('#BtnBuscardni').hide();
    //$("#txtalumno").attr('disabled', 'disabled');
    //$("#imprimir").attr('disabled', 'disabled');

	$('#organizacion, #carrera').select2({
		placeholder: "Seleccione",
		allowClear: true
	});

	$('#movimiento').on('change', function(){
		if ($('#movimiento').val() == 0) {
			$('#cboFiltroAlumno').val(0);
			$("#cboFiltroAlumno").attr('disabled', 'disabled');
    		$("#txtalumno").attr('disabled', 'disabled');
    		$('#txt_alumno_id').val('');
    		$('#txtalumno').val('');
		    $('#divAlumno').html('');
		    $('#divDNI').html('');
			$('#BtnBuscardni').hide();
    	}

    	if ($('#movimiento').val() == 1) {
			$('#cboFiltroAlumno').removeAttr("disabled");
    		$('#txt_alumno_id').val('');
    		$('#txtalumno').val('');
		    $('#divAlumno').html('');
		    $('#divDNI').html('');
			$('#BtnBuscardni').hide();
    	}

		if ($('#movimiento').val() == 2) {
			$("#cboFiltroAlumno").attr('disabled', 'disabled');
    		$("#txtalumno").attr('disabled', 'disabled');
    		$('#txt_alumno_id').val('');
    		$('#txtalumno').val('');
		    $('#divAlumno').html('');
		    $('#divDNI').html('');
			$('#BtnBuscardni').hide();
    	}
	});	

	$('#cboFiltroAlumno').on('change', function(){
		if ($('#cboFiltroAlumno').val() == 0) {
    		$("#txtalumno").attr('disabled', 'disabled');
    		$('#txt_alumno_id').val('');
			$('#BtnBuscardni').hide();
    	}

    	if ($('#cboFiltroAlumno').val() == 1) {
    		$("#txtalumno").removeAttr("disabled");
			$('#BtnBuscardni').show();
    	}
	});	

	$('#txtalumno').on('change', function() {
	    buscar_alumno();
    });

	$('#BtnBuscardni').live('click', function() {
	    buscar_alumno();
    });

	function buscar_alumno() {

		//borrar_datos_alumno();

		/* VALIDACIONES DEL BOTON BUSCAR */

	    if ($('#cboFiltroAlumno').val() == 1) {
	        if ($.trim($('#txtalumno').val()) == '') {
	    	    alert('Debe ingresar el DNI del Alumno');
	    	    return;
	    	}
	    	url_destino = "{{url('alumnos/obteneralumnopordni')}}";

		    /* OBTENGO EL ALUMNO */
			$.ajax({
			  url: url_destino,
			  data: {'txt_alumno': $('#txtalumno').val()},
			  type: 'POST'
			}).done(function(alumno) {
				console.log(alumno);
				if (alumno == <?php echo AlumnosController::NO_EXISTE_ALUMNO ?>) {
					alert('No se ha encontrado ningún registro');
					return;
			    }
			    var apellido_nombre = alumno.apellido + ', ' + alumno.nombre;
			    var dni = alumno.nrodocumento;
			    var domicilio = alumno.calle + ' ' + alumno.numero + ' (' + alumno.localidad + ', ' + alumno.provincia + ')';
			    $('#divAlumno').html('<p class="form-control-static">' + apellido_nombre + '</p>');
			    $('#divDNI').html('<p class="form-control-static">' + dni + '</p>');
			    $('#divAlumnos').val(apellido_nombre);
			    //$('#divDomicilio').html('<p class="form-control-static">' + domicilio + '</p>');

			    $('#txt_alumno_id').val(alumno.alumno_id);
			    //$('#txt_persona_id').val(alumno.persona_id);
			    //$('#txt_persona_id_verInfo').val(alumno.persona_id);

			}).error(function(data) {
				console.log(data);
			});
	    }
	}

	$('#imprimir').on('click', function(e){
		e.preventDefault();
		window.open("{{url('cajachica/pdfimprimirlistado')}}?fechadesde=" + $('#fechadesde').val() + '&fechahasta=' + $('#fechahasta').val() + '&movimiento=' + $('#movimiento').val() + '&organizacion=' + $('#organizacion').val() + '&cboFiltroAlumno=' + $('#cboFiltroAlumno').val() + '&txt_alumno_id=' + $('#txt_alumno_id').val());
	});

@stop


@section('includejs')
	<script type="text/javascript" src="{{url('assets/global/plugins/select2/select2.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js')}}"></script>
	<script src="{{url('assets/admin/layout/scripts/menusticky.js')}}" type="text/javascript"></script>
	<script src="{{url('assets/admin/pages/scripts/table-advanced.js')}}"></script>
@stop
