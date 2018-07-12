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
											<div class="col-md-2 col-sm-2">
												<select name="cboFiltroAlumno" id="cboFiltroAlumno" class="table-group-action-input form-control">
													<option value="1">DNI</option>
												</select>
											</div>
											<div class="col-md-4 col-sm-4">
												<input class="form-control" name="txtalumno" id="txtalumno" type="text" value="30295559">
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
									<table class="table table-striped table-bordered table-hover" id="table_cuotas">
										<thead>
										<tr>
											<th>
												<center><i class="fa fa-files-o"></i> Unidades Curriculares</center>
											</th>
											<th>
												<center><i class="fa fa-files-o"></i> Régimen</center>
											</th>
											<th>
												<center><i class="glyphicon glyphicon-usd"></i> Efectivo</center>
											</th>
											<th>
												<center><i class="glyphicon glyphicon-credit-card"></i> Tarj. Crédito</center>
											</th>
											<th>
												<center><i class="glyphicon glyphicon-credit-card"></i> Tarj. Débito</center>
											</th>
											<th>
												<center>Otros</center>
											</th>
											<th>
												<center><i class="fa fa-calendar"></i> Fecha de Pago</center>
											</th>
											<th>
												<center><i class="glyphicon glyphicon-list-alt"></i> Nro. Comprobante</center>
											</th>
											<th>
												<center><i class="glyphicon glyphicon-pencil"></i> Acciones</center>
											</th>
										</tr>
										</thead>
										
										<tbody>
										
										</tbody>
									</table>
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

	/*$('#cboFiltroAlumno').click(function() {
		if ($('#cboFiltroAlumno').val() == 2) {
	        $('#txtalumno').removeAttr("disabled");
	    }

	    if ($('#cboFiltroAlumno').val() == 1) {
	        $('#txtalumno').val("");
	        $('#alumno_id').val("");
	    	$("#txtalumno").attr('disabled', 'disabled');
	    }
	});*/

	$('#cboOrganizacion').select2({
		placeholder: "Seleccione",
		allowClear: true
	});

	$('#imprimir').on('click', function(e){
		e.preventDefault();
		window.open("{{url('cuotas/imprimirestadoalumno')}}?carrera_id=" + $('#cboCarrera').val() + '&alumno_id=' + $('#alumno_id').val());
	});

    $('#btnBuscar').click(function() {
    	var ciclo = $('#cboCiclo').val();
    	var carrera = $('#cboCarrera').val();
    	
			limpiar_tabla();

			/* VALIDACIONES DEL BOTON BUSCAR */
		    if ($.trim($('#txtalumno').val()) == '') {
		    	$('#divMensaje').html('<p class="form-control-static"><h4>' + 'Ingrese DNI del Alumno!' + '</h4></p>');
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

		    /* OBTENGO EL ALUMNO */
			$.ajax({
			  url: url_destino,
			  data:{'txt_alumno': $('#txtalumno').val()},
			  type: 'POST'
			}).done(function(alumno) {
				console.log(alumno);

				if (alumno == <?php echo AlumnosController::NO_EXISTE_ALUMNO ?>) {
					$('#divMensaje').html('<p class="form-control-static"><h4>' + 'No se ha encontrado ningun registro!' + '</h4></p>');
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
				  url: '{{url('cuotas/obtenercuentaporalumno')}}',
				  data:{'alumno_id': alumno_id, 'ciclo': ciclo, 'carrera': carrera},
				  type: 'POST'
				}).done(function(cuotas) {
					console.log(cuotas);

					$("#table_cuotas").find("tr:gt(0)").remove();
				
					if (cuotas.length == 0) {
						$("#imprimir").attr('disabled', 'disabled');
					} else {
						$("#imprimir").removeAttr("disabled");
					}

					var efectivo = '';
					var tarjetacredito = '';
					var tarjetadebito = '';
					var otros = '';
					var bandera = true;
					var mesa = 0;
					var meses = ["Matricula", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
					var mespagocuotafin = 0;
					var cuotaperiodopagohasta = 0;
					var cicloslec = 0;
					var fintabla = '';
					var tr = '';

				    $.each(cuotas, function(key, value) {
						if (value.activo == 'disabled') {
							$("#imprimir").attr('disabled', 'disabled');
						} else {
							$("#imprimir").removeAttr("disabled");
						}

				    	if (value.efectivo == 0) {
					    	efectivo = '';
					    } else {
						    efectivo = '$' + parseInt(value.efectivo);
						}

				    	if (value.tarjetacredito == 0) {
					    	tarjetacredito = '';
					    } else {
						    tarjetacredito = '$' + parseInt(value.tarjetacredito);
						}

				    	if (value.tarjetadebito == 0) {
					    	tarjetadebito = '';
					    } else {
						    tarjetadebito = '$' + parseInt(value.tarjetadebito);
						}

				    	if (value.otros == 0) {
					    	otros = '';
					    } else {
						    otros = '$' + parseInt(value.otros);
						}

						mespagocuotafin = value.mespagocuotafin;
						cuotaperiodopagohasta = value.cuotaperiodopagohasta;
						cicloslec = value.cicloslec;

						if (value.tipomovimiento == 'Matricula') {
							fintabla = '<td><center><a target="_blank" href="{{url('matriculas/imprimirreciboadeuda')}}?carrera='+carrera+'&ciclo='+ciclo+'&alumno='+alumno_id+'&matricula='+value.matricula_id+'" '+value.activo+' data-id="" class="btn default btn-xs red"><i title="Imprimir" class="glyphicon glyphicon-print"></i></a></center></td></tr>';
						} else {
							fintabla = '<td><center><a target="_blank" href="{{url('cuotas/imprimirrecibo')}}?txt_pago_id='+value.matricula_id+'" '+value.activo+' data-id="" class="btn default btn-xs red"><i title="Imprimir" class="glyphicon glyphicon-print"></i></a></center></td></tr>';
						}

						if (value.activo == 'disabled') {
							tr = "class='danger'";
							fintabla = '<td><center></center></td></tr>';
							$("#imprimir").removeAttr("disabled");
						} else {
							tr = "";
						}

						$('#table_cuotas > tbody').append('<tr '+tr+'><td><center>'+value.fechavencimientomatricula+'</center></td><td><center>'+value.tipomovimiento+'</center></td><td><center>'+efectivo+'</center></td><td><center>'+tarjetacredito+'</center></td><td><center>'+tarjetadebito+'</center></td><td><center>'+otros+'</center></td><td><center>'+value.fechapago+'</center></td><td><center>'+value.nrocomprobante+'</center></td>'+fintabla);

						mesa = value.mescuota;
					});

					var mesaseguir = parseInt(mesa) + 1;
					var mespagocuotafins = parseInt(mespagocuotafin) + 1;

					for (i = parseInt(mesaseguir); i < parseInt(mespagocuotafins); i++) {
						$('#table_cuotas > tbody').append('<tr class="danger"><td><center>'+cuotaperiodopagohasta+'/'+i+'/'+cicloslec+'</center></td><td><center>Cta. '+meses[i]+'</center></td><td><center></center></td><td><center></center></td><td><center></center></td><td><center></center></td><td><center></center></td><td><center></center></td><td><center></center></td></tr>');
					}

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

        if ($('#cboCarrera').val() == 0) return;

    });

    $('#cboOrganizacion').change(function() {
    	// 1 - limpiar todo

    	limpiar_tabla();
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
		$('#table_cuotas tr').each(function() {
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
