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
					Informes <small> Auditoria</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('alumnos/informeauditoriaalumnos')}}">Auditoria</a>
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
								<i class="fa fa-files-o"></i>Auditoria de Alumnos
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
								</div>

								<div class="form-group">
									<label class="col-md-2 col-sm-2 control-label" for="cbocarrera">Carrera:</label>
									<div class="col-md-6 col-sm-6">
										<select name="cboCarrera" id="cboCarrera" class="table-group-action-input form-control">
										</select>
									</div>
								</div>

								{{ Form::close() }}
							</div>
							<div class="portlet-body">
								<div class="box-body table-responsive no-padding">
									<table class="table table-striped table-bordered table-hover" id="table_alumnos">
										<thead>
										<tr>
											<th>
												<center><i class="fa fa-users"></i> Alumno</center>
											</th>
											<th>
												<center><i class="fa fa-files-o"></i> Documento</center>
											</th>
											<th>
												<center><i class="fa fa-user"></i> Creado</center>
											</th>
											<th>
												<center><i class="glyphicon glyphicon-calendar"></i> Fecha Alta</center>
											</th>
											<th>
												<center><i class="fa fa-user"></i> Modificado</center>
											</th>
											<th>
												<center><i class="glyphicon glyphicon-calendar"></i> Fecha Modificado</center>
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

	$('#cboOrganizacion').select2({
		placeholder: "Seleccione",
		allowClear: true
	});

	$('#imprimir').on('click', function(e){
		e.preventDefault();
		window.open("{{url('alumnos/imprimirauditoria')}}?organizacion_id=" + $('#cboOrganizacion').val() + '&carrera_id=' + $('#cboCarrera').val());
	});

    $('#cboCarrera').change(function() {
    	limpiar_tabla();

        if ($('#cboCarrera').val() == 0) return;

		$.ajax({
		  url: '{{url('alumnos/obtenerauditoria')}}',
		  data:{'carrera': $('#cboCarrera').val()},
		  type: 'POST'
		}).done(function(carreras) {
			console.log(carreras);
			
			$("#table_alumnos").find("tr:gt(0)").remove();

			$.each(carreras, function(key, value) {
				$('#table_alumnos > tbody').append('<tr><td><center>'+value.apeynom+'</center></td><td><center>'+value.dni+'</center></td><td><center>'+value.usuario_alta+'</center></td><td><center>'+value.fecha_alta+'</center></td><td><center>'+value.usuario_modi+'</center></td><td><center>'+value.fecha_modi+'</center></td></tr>');

				$("#imprimir").removeAttr('disabled', 'disabled');
			});
		}).error(function(data) {
			console.log(data);
		});

    });

    $('#cboOrganizacion').change(function() {
    	// 1 - limpiar todo

    	limpiar_tabla();
		$('#cboCarrera').children().remove().end();

		if ($('#cboOrganizacion').val() == 0) return;

		$.ajax({
		  url: '{{url('alumnos/obtenercarreras')}}',
		  data:{'id': $('#cboOrganizacion').val()},
		  type: 'POST'
		}).done(function(carreras) {
			console.log(carreras);
			
			/*$('#cboCarrera').append(
		        $('<option></option>').val(0).html('Seleccionar')
		    );*/

			$.each(carreras, function(key, value) {
				$('#cboCarrera').append(
			        $('<option></option>').val(value.id).html(value.descripcion)
			    );
			});
		}).error(function(data) {
			console.log(data);
		});

    });

    function limpiar_tabla() {
	    var n = 0;
		$('#table_alumnos tr').each(function() {
		   if (n > 0) $(this).remove();
		   n++;
		});
    }

	$(document).ready(function(){
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
	});

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
