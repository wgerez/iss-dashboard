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
					Informes <small> Analítico del Alumno</small>
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
							<a href="{{url('alumnos/informeanaliticoalumnos')}}">Analítico</a>
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
					    @if (Session::get('message_type') == AlumnosController::OPERACION_EXITOSA)

					        <div class="note note-success">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == AlumnosController::OPERACION_FALLIDA)

					        <div class="note note-danger">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == AlumnosController::OPERACION_CANCELADA)

					        <div class="note note-warning">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == AlumnosController::OPERACION_INFO)

					        <div class="note note-info">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@endif
					@endif
					<!-- COMIENZO DE LA TABLA-->
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-files-o"></i>Analítico del Alumno
							</div>
							<div class="actions">
								<!--a href="{{url('cuotas/pagar')}}" {{$disabled}} class="btn default blue-stripe">
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Pagar </span>
								</a-->
								<a target="_blank" href="#" id="imprimir" {{$imprimir}} class="btn default yellow-stripe">
								<i class="fa fa-print"></i>
								<span class="hidden-480">
								Imprimir </span>
								</a>								
							</div>
						</div>
						<div class="portlet-body form">
							<div class="form-body">
								{{ Form::open(array('url'=>'alumnos/listadoalumnos', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmListadoalumnos', 'name'=>'FrmListadoalumnos'))}}
								<div class="form-group">
									<label  class="col-md-2 col-sm-2 control-label">Organización:</label>
									<div class="col-md-6 col-sm-6">
										{{ Form::select('cboOrganizacion', $organizaciones, Input::old('organizacion'), array('class'=>'table-group-action-input form-control','id'=>'cboOrganizacion')); }}
									</div>
									<!--div class="col-md-4 col-sm-4 col-xs-12">
										<center>
											<p><span class="text-success"><i class="fa fa-check"></i></span> Pagado - <span class="text-danger"><i class="fa fa-exclamation-triangle"></i></span> Adeuda - <span class="text-info"><i class="fa fa-asterisk"></i></span> Becado</p>
										</center>
									</div-->
								</div>

								<div class="form-group">
									<label class="col-md-2 col-sm-2 control-label" for="cbocarrera">Carrera:</label>
									<div class="col-md-6 col-sm-6">
										<select name="cboCarrera" id="cboCarrera" class="table-group-action-input form-control">
										</select>
									</div>
								</div>

								<div class="portlet-body form">
									<div class="form-body">
										<div class="form-group">
											<label  class="col-md-2 col-sm-2 control-label">Alumno:</label>
											<div class="col-md-3 col-sm-3">
												<select name="cboFiltroAlumno" id="cboFiltroAlumno" class="table-group-action-input form-control">
													<option value="1">DNI</option>
													<option value="2">Apellido, Nombres</option>
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

										<div class="form-group" id="target">
											<label class="col-md-2 control-label" >Apellido y Nombre:</label>
											<div class="col-md-4 col-sm-10">
												<label id="nombreAlumno" class="control-label text-info" id="nombreAlumno"><?php if (isset($apeynom)) echo $apeynom; ?></label>
											</div>
											<label  class="col-md-2 col-sm-2 control-label">DNI:</label>
											<div class="col-md-2 col-sm-4 text-info" id='divDNI'><?php if (isset($nrodocumento)) echo $nrodocumento; ?></div>
										</div>
										<br>
									</div>
								</div>
								
								{{ Form::close() }}
							</div>
							<div class="portlet-body">
								<div class="box-body table-responsive no-padding">
									
							<div class="form-group">
								<div class="box-footer" align="center">
							        <div id="div1">
							        	<center><label id="anio" class='control-label text-info'><strong></strong></label></center>
									<table class="table table-striped table-bordered table-hover" id="table_primero">
										<thead>
										<tr>
											<th>
												<center><i class="fa fa-files-o"></i> Unidades Curriculares</center>
											</th>
											<th>
												<center><i class="glyphicon glyphicon-list-alt"></i> Régimen</center>
											</th>
											<th>
												<center><i class="glyphicon glyphicon-tags"></i> Regularizado</center>
											</th>
											<th>
												<center><i class="fa fa-calendar"></i> Fecha Regularizado</center>
											</th>
											<th>
												<center><i class="glyphicon glyphicon-ok-sign"></i> Promociono</center>
											</th>
											<th>
												<center><i class="glyphicon glyphicon-check"></i> Aprobó</center>
											</th>
											<th>
												<center><i class="fa fa-calendar"></i> Fecha de Aprobación</center>
											</th>
											<th>
												<center><i class="glyphicon glyphicon-sort-by-order"></i> Calif. Final Número</center>
											</th>
											<th>
												<center><i class="glyphicon glyphicon-sort-by-alphabet"></i> Calif. Letra</center>
											</th>
											<th>
												<center><i class="glyphicon glyphicon-list"></i> Libro</center>
											</th>
											<th>
												<center><i class="glyphicon glyphicon-pencil"></i> Folio</center>
											</th>
											<th>
												<center><i class="glyphicon glyphicon-tag"></i> Acta</center>
											</th>
											<th>
												<center><i class="glyphicon glyphicon-eye-open"></i> Observaciones Equivalencias</center>
											</th>
										</tr>
										</thead>
										
										<tbody>
										
										</tbody>
									</table>
							        </div>
							        <br>
							        <br>
							        <div id="div2"></div>
							        <br>
							        <br>
							        <div id="div3"></div>
							        <br>
							        <br>
							        <div id="div4"></div>
							        <br>
							        <br>
							        <div id="div5"></div>
							        <br>
							    </div>
							</div>

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

	$("#div2").hide();
	$("#div3").hide();
	
//Emular Tab al presionar Enter
$('input').keydown( function(e) {
        var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
        if(key == 13) {
            e.preventDefault();
            var inputs = $(this).closest('form').find(':input:visible');
            inputs.eq( inputs.index(this)+ 1 ).focus();
        }
 });

	$("#imprimir").attr('disabled', 'disabled');
	//$("#txtalumno").attr('disabled', 'disabled');

	$('#cboFiltroAlumno').click(function() {
		if ($('#cboFiltroAlumno').val() == 2) {
	        $('#txtalumno').val("");
	        $('#alumno_id').val("");
	        $("#imprimir").attr('disabled', 'disabled');
	        //$('#txtalumno').removeAttr("disabled");
	    }

	    if ($('#cboFiltroAlumno').val() == 1) {
	        $('#txtalumno').val("");
	        $('#alumno_id').val("");
	        $("#imprimir").attr('disabled', 'disabled');
	    	//$("#txtalumno").attr('disabled', 'disabled');
	    }

	    $('#txtalumno').focus();
	});

	$('#cboOrganizacion').select2({
		placeholder: "Seleccione",
		allowClear: true
	});

	$('#imprimir').on('click', function(e){
		e.preventDefault();
		window.open("{{url('alumnos/imprimiranaliticoalumno')}}?carrera_id=" + $('#cboCarrera').val() + '&alumno_id=' + $('#alumno_id').val() + '&organizacion_id=' + $('#cboOrganizacion').val());
	});

    $('#btnBuscar').click(function() {
    	if ($('#cboCiclo').val() == 0) return;

    	if ($('#cboCarrera').val() == 0) return;

    	if ($('#cboOrganizacion').val() == 0) return;

    	var ciclo = $('#cboCiclo').val();
    	var carrera = $('#cboCarrera').val();
    	var organizacion = $('#cboOrganizacion').val();

    	$(div1).show();
    	
			limpiar_tabla();

			/* VALIDACIONES DEL BOTON BUSCAR */
		    if ($.trim($('#txtalumno').val()) == '') {
		    	$('#divMensaje').html('<p class="form-control-static"><h4>' + 'Ingrese Datos del Alumno!' + '</h4></p>');
	    	    $('#MensajeCantidad').modal('show');
		    	return;
		    }

		    if ($('#cboFiltroAlumno').val() == 1) {
		        if ($.trim($('#txtalumno').val()) == '') {
		    	    $('#divMensaje').html('<p class="form-control-static"><h4>' + 'Debe ingresar el DNI del Alumno!' + '</h4></p>');
	    	    	$('#MensajeCantidad').modal('show');
		    	    return;
		    	}
		    	url_destino = "{{url('alumnos/obteneralumnopordni')}}";
		    }

		    if ($('#cboFiltroAlumno').val() == 2) {
		        if ($.trim($('#txtalumno').val()) == '') {
		    	    $('#divMensaje').html('<p class="form-control-static"><h4>' + 'Debe ingresar Apellido y nombres del Alumno!' + '</h4></p>');
	    	    	$('#MensajeCantidad').modal('show');
		    	    return;
		    	}
		    	url_destino = "{{url('alumnos/obteneralumnoporapellidoynombre')}}";
		    }

		    /* OBTENGO EL ALUMNO */
			$.ajax({
			  url: url_destino,
			  data:{'txt_alumno': $('#txtalumno').val()},
			  type: 'POST'
			}).done(function(alumno) {
				console.log(alumno);

				if (alumno == <?php echo AlumnosController::NO_EXISTE_ALUMNO ?>) {
					$('#divMensaje').html('<p class="form-control-static"><h4>' + 'No se ha encontrado ningun registro!' + '</h4></p>');
					$('#alumno_id').val('');
				    $('#txt_persona_id').val('');
				    $('#txt_persona_id_verInfo').val('');
				    $('#nombreAlumno').text('');
					$('#divDNI').html('<p class="form-control-static"></p>');
					$("#imprimir").attr('disabled', 'disabled');
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
			    $('#nombreAlumno').text(apellido_nombre);
				$('#divDNI').html('<p class="form-control-static">' + dni + '</p>');

			    $.ajax({
				  url: '{{url('alumnos/obteneranaliticoporalumno')}}',
				  data:{'alumno_id': alumno_id, 'carrera': carrera, 'organizacion': organizacion},
				  type: 'POST'
				}).done(function(analitico) {
					console.log(analitico);

					$("#table_primero").find("tr:gt(0)").remove();
					//$("#div1").html("");
					$("#table_segundo").find("tr:gt(0)").remove();
					$("#table_tercer").find("tr:gt(0)").remove();
					$("#table_cuarto").find("tr:gt(0)").remove();
					$("#table_quinto").find("tr:gt(0)").remove();
					$("#div2").html("");
					$("#div3").html("");
					$("#div4").html("");
					$("#div5").html("");
				
					if (analitico.length == 0) {
						$("#imprimir").attr('disabled', 'disabled');
					} else {
						$("#imprimir").removeAttr("disabled");
					}

					var anio = 'PRIMER AÑO';

				    $.each(analitico, function(key, value) {
						if (value.aniocursado == 1) {
							if (anio == 'PRIMER AÑO') {
					  			/*$("#div1").html("<center><label class='control-label text-info'><strong>"+anio+"</strong></label></center><table id='table_primero'><thead><tr><th><center><i class='fa fa-files-o'></i> Unidades Curriculares</center></th><th><center><i class='glyphicon glyphicon-list-alt'></i> Régimen</center></th><th><center><i class='glyphicon glyphicon-tags'></i> Regularizado</center></th><th><center><i class='fa fa-calendar'></i> Fecha Regularizado</center></th><th><center><i class='glyphicon glyphicon-ok-sign'></i> Promociono</center></th><th><center><i class='glyphicon glyphicon-check'></i> Aprobó</center></th><th><center><i class='fa fa-calendar'></i> Fecha de Aprobación</center></th><th><center><i class='glyphicon glyphicon-sort-by-order'></i> Calif. Final Número</center></th><th><center><i class='glyphicon glyphicon-sort-by-alphabet'></i> Calif. Letra</center></th><th><center><i class='glyphicon glyphicon-list'></i> Libro</center></th><th><center><i class='glyphicon glyphicon-pencil'></i> Folio</center></th><th><center><i class='glyphicon glyphicon-eye-open'></i> Observaciones Equivalencias</center></th></tr></thead><tbody></tbody></table>");*/

					  			$("#anio").text(anio);

					  			anio = 'SEGUNDO AÑO';

								$("#div2").show();
					  		}

					  		$('#table_primero > tbody').append('<tr><td><center>'+value.materia+'</center></td><td><center>'+value.regimen+'</center></td><td><center>'+value.regularizado+'</center></td><td><center>'+value.fecha_regularizacion+'</center></td><td><center>'+value.promociono+'</center></td><td><center>'+value.aprobo+'</center></td><td><center>'+value.fecha_aprobacion+'</center></td><td><center>'+value.calif_final_num+'</center></td><td><center>'+value.calif_final_let+'</center></td><td><center>'+value.libro+'</center></td><td><center>'+value.folio+'</center></td><td><center>'+value.acta+'</center></td><td><center>'+value.observaciones+'</center></td></tr>');
						}

						if (value.aniocursado == 2) {
							if (anio == 'SEGUNDO AÑO') {
					  			$("#div2").html("<center><label class='control-label text-info'>"+anio+"</label></center><table class='table table-striped table-bordered table-hover' id='table_segundo'><thead><tr><th><center><i class='fa fa-files-o'></i> Unidades Curriculares</center></th><th><center><i class='glyphicon glyphicon-list-alt'></i> Régimen</center></th><th><center><i class='glyphicon glyphicon-tags'></i> Regularizado</center></th><th><center><i class='fa fa-calendar'></i> Fecha Regularizado</center></th><th><center><i class='glyphicon glyphicon-ok-sign'></i> Promociono</center></th><th><center><i class='glyphicon glyphicon-check'></i> Aprobó</center></th><th><center><i class='fa fa-calendar'></i> Fecha de Aprobación</center></th><th><center><i class='glyphicon glyphicon-sort-by-order'></i> Calif. Final Número</center></th><th><center><i class='glyphicon glyphicon-sort-by-alphabet'></i> Calif. Letra</center></th><th><center><i class='glyphicon glyphicon-list'></i> Libro</center></th><th><center><i class='glyphicon glyphicon-pencil'></i> Folio</center></th><th><center><i class='glyphicon glyphicon-tag'></i> Acta</center></th><th><center><i class='glyphicon glyphicon-eye-open'></i> Observaciones Equivalencias</center></th></tr></thead><tbody></tbody></table>");

					  			anio = 'TERCER AÑO';

								$("#div3").show();
					  		}

					  		$('#table_segundo > tbody').append('<tr><td><center>'+value.materia+'</center></td><td><center>'+value.regimen+'</center></td><td><center>'+value.regularizado+'</center></td><td><center>'+value.fecha_regularizacion+'</center></td><td><center>'+value.promociono+'</center></td><td><center>'+value.aprobo+'</center></td><td><center>'+value.fecha_aprobacion+'</center></td><td><center>'+value.calif_final_num+'</center></td><td><center>'+value.calif_final_let+'</center></td><td><center>'+value.libro+'</center></td><td><center>'+value.folio+'</center></td><td><center>'+value.acta+'</center></td><td><center>'+value.observaciones+'</center></td></tr>');
						}

						if (value.aniocursado == 3) {
							if (anio == 'TERCER AÑO') {
					  			$("#div3").html("<center><label class='control-label text-info'>"+anio+"</label></center><table class='table table-striped table-bordered table-hover' id='table_tercer'><thead><tr><th><center><i class='fa fa-files-o'></i> Unidades Curriculares</center></th><th><center><i class='glyphicon glyphicon-list-alt'></i> Régimen</center></th><th><center><i class='glyphicon glyphicon-tags'></i> Regularizado</center></th><th><center><i class='fa fa-calendar'></i> Fecha Regularizado</center></th><th><center><i class='glyphicon glyphicon-ok-sign'></i> Promociono</center></th><th><center><i class='glyphicon glyphicon-check'></i> Aprobó</center></th><th><center><i class='fa fa-calendar'></i> Fecha de Aprobación</center></th><th><center><i class='glyphicon glyphicon-sort-by-order'></i> Calif. Final Número</center></th><th><center><i class='glyphicon glyphicon-sort-by-alphabet'></i> Calif. Letra</center></th><th><center><i class='glyphicon glyphicon-list'></i> Libro</center></th><th><center><i class='glyphicon glyphicon-pencil'></i> Folio</center></th><th><center><i class='glyphicon glyphicon-tag'></i> Acta</center></th><th><center><i class='glyphicon glyphicon-eye-open'></i> Observaciones Equivalencias</center></th></tr></thead><tbody></tbody></table>");

					  			anio = 'CUARTO AÑO';

								$("#div4").show();
					  		}

					  		$('#table_tercer > tbody').append('<tr><td><center>'+value.materia+'</center></td><td><center>'+value.regimen+'</center></td><td><center>'+value.regularizado+'</center></td><td><center>'+value.fecha_regularizacion+'</center></td><td><center>'+value.promociono+'</center></td><td><center>'+value.aprobo+'</center></td><td><center>'+value.fecha_aprobacion+'</center></td><td><center>'+value.calif_final_num+'</center></td><td><center>'+value.calif_final_let+'</center></td><td><center>'+value.libro+'</center></td><td><center>'+value.folio+'</center></td><td><center>'+value.acta+'</center></td><td><center>'+value.observaciones+'</center></td></tr>');
						}

						if (value.aniocursado == 4) {
							if (anio == 'CUARTO AÑO') {
					  			$("#div4").html("<center><label class='control-label text-info'>"+anio+"</label></center><table class='table table-striped table-bordered table-hover' id='table_cuarto'><thead><tr><th><center><i class='fa fa-files-o'></i> Unidades Curriculares</center></th><th><center><i class='glyphicon glyphicon-list-alt'></i> Régimen</center></th><th><center><i class='glyphicon glyphicon-tags'></i> Regularizado</center></th><th><center><i class='fa fa-calendar'></i> Fecha Regularizado</center></th><th><center><i class='glyphicon glyphicon-ok-sign'></i> Promociono</center></th><th><center><i class='glyphicon glyphicon-check'></i> Aprobó</center></th><th><center><i class='fa fa-calendar'></i> Fecha de Aprobación</center></th><th><center><i class='glyphicon glyphicon-sort-by-order'></i> Calif. Final Número</center></th><th><center><i class='glyphicon glyphicon-sort-by-alphabet'></i> Calif. Letra</center></th><th><center><i class='glyphicon glyphicon-list'></i> Libro</center></th><th><center><i class='glyphicon glyphicon-pencil'></i> Folio</center></th><th><center><i class='glyphicon glyphicon-tag'></i> Acta</center></th><th><center><i class='glyphicon glyphicon-eye-open'></i> Observaciones Equivalencias</center></th></tr></thead><tbody></tbody></table>");

					  			anio = 'QUINTO AÑO';

								$("#div5").show();
					  		}

					  		$('#table_cuarto > tbody').append('<tr><td><center>'+value.materia+'</center></td><td><center>'+value.regimen+'</center></td><td><center>'+value.regularizado+'</center></td><td><center>'+value.fecha_regularizacion+'</center></td><td><center>'+value.promociono+'</center></td><td><center>'+value.aprobo+'</center></td><td><center>'+value.fecha_aprobacion+'</center></td><td><center>'+value.calif_final_num+'</center></td><td><center>'+value.calif_final_let+'</center></td><td><center>'+value.libro+'</center></td><td><center>'+value.folio+'</center></td><td><center>'+value.acta+'</center></td><td><center>'+value.observaciones+'</center></td></tr>');
						}

						if (value.aniocursado == 5) {
							if (anio == 'QUINTO AÑO') {
					  			$("#div5").html("<center><label class='control-label text-info'>"+anio+"</label></center><table class='table table-striped table-bordered table-hover' id='table_quinto'><thead><tr><th><center><i class='fa fa-files-o'></i> Unidades Curriculares</center></th><th><center><i class='glyphicon glyphicon-list-alt'></i> Régimen</center></th><th><center><i class='glyphicon glyphicon-tags'></i> Regularizado</center></th><th><center><i class='fa fa-calendar'></i> Fecha Regularizado</center></th><th><center><i class='glyphicon glyphicon-ok-sign'></i> Promociono</center></th><th><center><i class='glyphicon glyphicon-check'></i> Aprobó</center></th><th><center><i class='fa fa-calendar'></i> Fecha de Aprobación</center></th><th><center><i class='glyphicon glyphicon-sort-by-order'></i> Calif. Final Número</center></th><th><center><i class='glyphicon glyphicon-sort-by-alphabet'></i> Calif. Letra</center></th><th><center><i class='glyphicon glyphicon-list'></i> Libro</center></th><th><center><i class='glyphicon glyphicon-pencil'></i> Folio</center></th><th><center><i class='glyphicon glyphicon-tag'></i> Acta</center></th><th><center><i class='glyphicon glyphicon-eye-open'></i> Observaciones Equivalencias</center></th></tr></thead><tbody></tbody></table>");

					  			anio = 'SEXTO AÑO';
					  		}

					  		$('#table_quinto > tbody').append('<tr><td><center>'+value.materia+'</center></td><td><center>'+value.regimen+'</center></td><td><center>'+value.regularizado+'</center></td><td><center>'+value.fecha_regularizacion+'</center></td><td><center>'+value.promociono+'</center></td><td><center>'+value.aprobo+'</center></td><td><center>'+value.fecha_aprobacion+'</center></td><td><center>'+value.calif_final_num+'</center></td><td><center>'+value.calif_final_let+'</center></td><td><center>'+value.libro+'</center></td><td><center>'+value.folio+'</center></td><td><center>'+value.acta+'</center></td><td><center>'+value.observaciones+'</center></td></tr>');
						}

					});

				}).error(function(data) {
					console.log(data);
				});

			}).error(function(data) {
				console.log(data);
			});
		
		$("#imprimir").removeAttr("disabled");
    });

    $('#cboCarrera').change(function() {

    	limpiar_tabla();
    	$("#imprimir").attr('disabled', 'disabled');
        if ($('#cboCarrera').val() == 0) return;

    });

    $('#cboOrganizacion').change(function() {
    	// 1 - limpiar todo

    	limpiar_tabla();
    	$("#imprimir").attr('disabled', 'disabled');
		$('#cboCarrera').children().remove().end();

		if ($('#cboOrganizacion').val() == 0) return;
		
		$.ajax({
		  url: "{{url('organizacions/obtenercarreras')}}",
		  data:{'organizacion_id': $('#cboOrganizacion').val()},
		  type: 'POST'
		}).done(function(carreras) {
			console.log(carreras);
			if (carreras == <?php echo OrganizacionsController::NO_TIENE_CARRERAS ?>) {
				$('#modalMensajes').modal('show');
				return;
		    }

			$("#table_asistencias").find("tr:gt(1)").remove();

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

    function limpiar_tabla() {
	    var n = 0;
		$('#table_primero tr').each(function() {
		   if (n > 0) $(this).remove();
		   n++;
		});
    }

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
