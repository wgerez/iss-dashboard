@extends('layouts.master')

@section('customstyle')
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/select2/select2.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/bootstrap-datepicker/css/datepicker.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/bootstrap-datetimepicker/css/datetimepicker.css')}}"/>
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
					Feriados <small>Editar feriado</small>
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
							<a href="#">editar</a>
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
					
					<input type='hidden' name='txtFeriadoId' id='txtFeriadoId' value='{{$idferiados}}'>

					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-calendar"></i> Ciclo Lectivo
							</div>
							<div class="actions">
								<a {{ $disabled }} href="{{url('feriados/crear')}}" class="btn default blue-stripe">
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Nuevo </span>
								</a>
								<button {{ $disabled }} type='submit' class="btn default green-stripe">
								<i class="fa fa-save"></i>
								<span class="hidden-480">
								Guardar </span>
								</button>
								<a href="{{url('feriados/listado')}}" class="btn default yellow-stripe">
								<i class="fa fa-reorder"></i>
								<span class="hidden-480">
								Listado </span>
								</a>
								<!--a href="{{url('feriados/listado')}}" class="btn default red-stripe">
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
											{{ Form::select('organizacion', $arrOrganizaciones, $organizacionid, array('class'=>'table-group-action-input form-control','id'=>'organizacion', $disabled)); }}
										</div>
									</div>
									<div class="form-group">
										<div class="<?php if ($errors->has('cboCiclos')) echo 'has-error' ?>" >
											<label class="col-md-2 col-sm-2 control-label">Ciclo Lectivo:</label>
											<div class="col-md-2 col-sm-2">
												<select class="table-group-action-input form-control" name="cboCiclos" id="cboCiclos">
													@if (isset($ciclos))
														@foreach ($ciclos as $ciclo)
															<option value="{{$ciclo->id}}" <?php if ($ciclo->id == $ciclo_id) echo "selected"; ?>>{{$ciclo->descripcion}}</option>
														@endforeach
													@endif
												</select>
												<!-- mostrar cuando exista error -->
											    @if ($errors->has('cboCiclos'))
												    <span class="help-block">{{ $errors->first('cboCiclos') }}</span>
											    @endif
											    <!--fin error-->

											</div>
										</div>
										<div class="<?php if ($errors->has('fechaferiado')) echo 'has-error' ?>" >
											<label class="col-md-2 col-sm-2 control-label">Fecha Feriado:</label>
											<div class="col-md-2 col-sm-2">
												<input type="date" class="form-control" id="fechaferiado" name="fechaferiado" placeholder="" value="{{ $fecha }}">
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
												<input type="text" class="form-control" id="descripcion" name="descripcion" value="{{ $descripcion }}" placeholder="Descripción">
											    @if ($errors->has('descripcion'))
												    <span class="help-block">{{ $errors->first('descripcion') }}</span>
											    @endif
											</div>
										</div>
									</div>
								</div>
						</div> <!-- FIN PORTLET-BODY -->
					</div>
					<br>
					{{ Form::close()}}
					<!-- FIN DE LA TABLA-->
				</div>
			</div>
			<!-- FIN DEL CONTENIDO -->
		</div>
	</div>
	<!-- FIN -->

	<!-- MODAL ELIMINACION DE PERIODOS-->
	<div class="modal fade" id="modalEliminaPeriodo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<input id="idPeriodoHidden" name='idPeriodoHidden' type="hidden" value="">
			<input id="txtInputPeriodoHidden" name='txtInputPeriodoHidden' type="hidden" value="">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Eliminar Período</h4>
					</div>
					<div class="modal-body">
						¿Estás seguro de querer borrar este período?
					</div>
					<div class="modal-footer">
						<button type="button" id="btnMEliminarPeriodo" class="btn red"><i class="fa fa-trash-o"></i> Eliminar</button>
						<button type="button" class="btn default" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> Cancelar</button>
					</div>
				</div>
			</div>
	</div>
	<!-- FIN DEL MODAL FORM-->

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
						<button type="button" class="btn default" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> Cancelar</button>					</div>
				</div>
				<!-- /.modal-contenido -->
			</div>
	</div>
	<!-- /.modal -->
	<!-- FIN DEL MODAL FORM-->

	<!-- MODAL MODIFICACION DE PERIODOS-->
	<div class="modal fade" id="modalModiPeriodo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title"><i class="fa fa-calendar"></i> Modificar Períodos</h4>
					</div>
					<div class="modal-body">
						<form class="form-horizontal">
							<input type="hidden" id="txtIdHiddenPeriodo" value="">
							<input type="hidden" id="txt_periodo_lectivo_id" value="">
							<div class="form-group errorPeriodoModal">
								<label class="col-md-3 control-label">Período</label>
								<div class="col-md-6">
									<input type="text" id="MtxtDescripcion" name="MtxtDescripcion" class="form-control">
									<span id="errorPeriodoModal" class="help-block"></span>
								</div>
							</div>
							<div class="form-group errorPeriodoFechaInicioModal">
								<label class="col-md-3 control-label">Fecha Inicio</label>
								<div class="col-md-6">
									<input type="text" id="MtxtFechaIni" name="MtxtFechaIni" class="form-control">
									<span id="errorPeriodoFechaInicioModal" class="help-block"></span>
								</div>
							</div>
							<div class="form-group errorPeriodoFechaFinModal">
								<label class="col-md-3 control-label">Fecha Fin</label>
								<div class="col-md-6">
									<input type="text" id="MtxtFechaFin" name="MtxtFechaFin" class="form-control">
									<span id="errorPeriodoFechaFinModal" class="help-block"></span>
								</div>
							</div>							
						</form>

					</div>
					<div class="modal-footer">
						<button type="button" id="btnModalModificaPeriodo" class="btn purple"><i class="fa fa-edit"></i> Modificar</button>
						<button type="button" class="btn default" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> Cancelar</button>
					</div>
				</div>
				<!-- /.modal-contenido -->
			</div>
		<!-- /.modal-dialog -->
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
