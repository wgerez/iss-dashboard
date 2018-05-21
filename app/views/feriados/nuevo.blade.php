@extends('layouts.master')

@section('customstyle')
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/select2/select2.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/bootstrap-datepicker/css/datepicker.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/bootstrap-datetimepicker/css/datetimepicker.css')}}"/>
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
					Feriados <small>Nuevo Feriado</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('feriados/listado')}}">Feriados</a>
							<i class="fa fa-angle-right"></i>
						</li>						
						<li>
							<a href="#">nuevo</a>
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
					    @if (Session::get('message_type') == FeriadosController::OPERACION_EXITOSA)

							<div class="note note-success">
								<p> {{ Session::get('message') }} </p>
							</div>
						@elseif (Session::get('message_type') == FeriadosController::OPERACION_FALLIDA)

							<div class="note note-danger">
								<p> {{ Session::get('message') }} </p>
							</div>

						@endif	
					@endif
					<!-- COMIENZO DE LA TABLA-->
					{{ Form::open(array('url'=>'feriados/guardar', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmListadoFeriados', 'name'=>'FrmListadoFeriados'))}}
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-calendar"></i> Feriados
							</div>
							<div class="actions">
								<button type='submit' class="btn default green-stripe">
								<i class="fa fa-save"></i>
								<span class="hidden-480">
								Guardar </span>
								</button>
								<a href="listado" class="btn default yellow-stripe">
								<i class="fa fa-reorder"></i>
								<span class="hidden-480">
								Listado </span>
								</a>
								<!--a href="listado" class="btn default red-stripe">
								<i class="fa fa-times"></i>
								<span class="hidden-480">
								Cancelar </span>
								</a-->
							</div>

						</div>
						<div class="portlet-body form">
								<div class="form-body">

									<div class="form-group">
										<label  class="col-md-2 col-sm-2 control-label">Organización:</label>
										<div class="col-md-6 col-sm-10">
											{{ Form::select('organizacion', $arrOrganizaciones, Input::old('organizacion'), array('class'=>'table-group-action-input form-control','id'=>'organizacion')); }}
										</div>
									</div>

									<div class="form-group">
										<div class="<?php if ($errors->has('cboCiclos')) echo 'has-error' ?>" >
											<label class="col-md-2 col-sm-2 control-label">Ciclo Lectivo:</label>
											<div class="col-md-2 col-sm-2">
												<!--input type="text" class="form-control" id="cicloLectivo" name="cicloLectivo" placeholder="" value="{{ Input::old('cicloLectivo') }}"-->
												<select class="table-group-action-input form-control" name="cboCiclos" id="cboCiclos">
													<!--option value="0">Seleccione</option-->
												</select>
											    @if ($errors->has('cboCiclos'))
												    <span class="help-block">{{ $errors->first('cboCiclos') }}</span>
											    @endif
											</div>
										</div>
										<div class="<?php if ($errors->has('fechaferiado')) echo 'has-error' ?>" >
											<label class="col-md-2 col-sm-2 control-label">Fecha Feriado:</label>
											<div class="col-md-2 col-sm-2">
												<input type="date" class="form-control" id="fechaferiado" name="fechaferiado" placeholder="" value="{{ Input::old('fechaferiado') }}">
											    @if ($errors->has('fechaferiado'))
												    <span class="help-block">{{ $errors->first('fechaferiado') }}</span>
											    @endif
											</div>
										</div>	
									</div>
									
									<div class="form-group">
										<div class="<?php if ($errors->has('descripcion')) echo 'has-error' ?>" >
											<label class="col-md-2 col-sm-2 control-label" for="descripcion"> Descripción:</label>
											<div class="col-md-6 col-sm-2">
												<input type="text" class="form-control" id="descripcion" name="descripcion" value="{{ Input::old('descripcion') }}" placeholder="Descripción">
											    @if ($errors->has('descripcion'))
												    <span class="help-block">{{ $errors->first('descripcion') }}</span>
											    @endif
											</div>
										</div>
									</div>
								</div>
						</div> <!-- FIN PORTLET-BODY -->
					</div>

					{{ Form::close()}}
					<!-- FIN DE LA TABLA-->
				</div>
			</div>
			<!-- FIN DEL CONTENIDO -->
		</div>
	</div>
	<!-- FIN -->

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


	<!-- MODAL ELIMINACION DE CICLOS-->
	<div class="modal fade" id="modalActivaCiclo" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Activar Ciclo</h4>
					</div>
					<div class="modal-body">
						Existe otro ciclo como activo. ¿Desea cambiar el ciclo lectivo?
					</div>
					<div class="modal-footer">
						<button type="button" id="btnModalActivarCiclo" class="btn blue"><i class="fa fa-edit"></i> Activar</button>
						<button type="button" class="btn default" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> Cancelar</button>
					</div>
				</div>
				<!-- /.modal-contenido -->
			</div>
	</div>
	<!-- /.modal -->
	<!-- FIN DEL MODAL FORM-->


@stop


@section('customjs')
	ComponentsFormTools.init();
	//Emular Tab al presionar Enter
	$('input').keydown( function(e) {
	        var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
	        if(key == 13) {
	            e.preventDefault();
	            var inputs = $(this).closest('form').find(':input:visible');
	            inputs.eq( inputs.index(this)+ 1 ).focus();
	        }
	 });

	$('#organizacion').select2({
		placeholder: "Seleccione",
		allowClear: true
	});

	$('#organizacion').change(function() {
		//var carrid = $('#carrera').val();
		$('#ciclos').children().remove().end();

		if ($('#organizacion').val() == 0) return;

		$.ajax({
		  url: '{{url('ciclolectivo/obtenercicloslectivos')}}',
		  data:{'organizacion_id': $('#organizacion').val()},
		  type: 'POST'
		}).done(function(ciclos) {
			console.log(ciclos);
			if (ciclos == <?php echo CicloLectivoController::NO_EXISTE_CICLO ?>) {
				//alert('La Organización no tiene Ciclos Lectivos Asignados');
				$('#divMensaje').html('<p class="form-control-static"><h4>' + 'La Organización no tiene Ciclos Lectivos Asignados' + '</h4></p>');
	    	    $('#MensajeCantidad').modal('show');
				return;
		    }

			$('#cboCiclos').append(
		        $('<option></option>').val(0).html('Seleccionar')
		    );

			$.each(ciclos, function(key, value) {
				$('#cboCiclos').append(
			        $('<option></option>').val(value.id).html(value.descripcion)
			    );
			});
		}).error(function(data) {
			console.log(data);
		});
	});

	$('#btnModalActivarCiclo').on('click', function(e){
		e.preventDefault();
		$("#cicloactivo").prop("checked", true );
		$("#cicloactivo").parent().addClass("checked");
		$('#modalActivaCiclo').modal('hide');
	});

    if (jQuery().datepicker) {
        $('.date-picker').datepicker({
            rtl: Metronic.isRTL(),
            orientation: "left",
            autoclose: true,
            language: 'es'
        });
        //$('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
    }

    function comparafecha(finicio, ffin){
		//Formato MES/DIA/AÑO
		var fi = finicio.split("/");
		var fini = fi[1]+"/"+fi[0]+"/"+fi[2];

		var ff = ffin.split("/");
		var ffin = ff[1]+"/"+ff[0]+"/"+ff[2];

		var primera = Date.parse(fini);
		var segunda = Date.parse(ffin);
		 
		if (primera == segunda){
			console.log('Error en fecha');
		    return false;
		} else if (primera > segunda) {
			console.log('Error en fecha');
		    return false;
		} else{
			console.log('Fecha correcta');
		    return true;
		}    	
    }
@stop

@section('includejs') 
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{url('assets/global/plugins/select2/select2.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/global/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js')}}"></script>
<script type="text/javascript" src="{{url('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
<script type="text/javascript" src="{{url('assets/global/plugins/bootstrap-datepicker/js/locales/bootstrap-datepicker.es.js')}}"></script>
<script type="text/javascript" src="{{url('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js')}}"></script>
<script src="{{url('assets/admin/pages/scripts/components-form-tools.js')}}"></script>
<!-- END PAGE LEVEL PLUGINS -->
@stop
