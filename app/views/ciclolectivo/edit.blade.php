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

$organizacionid = (trim(Input::old('organizacion') == false)) ? $ciclo->organizacion_id : Input::old('organizacion');
$ciclolectivo = (trim(Input::old('cicloLectivo') == false)) ? $ciclo->descripcion : Input::old('cicloLectivo');

if (trim(Input::old('cicloFechaInicio') == false)) {
	$ciclofechainicio = FechaHelper::getFechaImpresion($ciclo->fechainicio);
} else {
	$ciclofechainicio = Input::old('cicloFechaInicio');
}

if (trim(Input::old('cicloFechaFin') == false)) {
	$ciclofechafin = FechaHelper::getFechaImpresion($ciclo->fechafin);
} else {
	$ciclofechafin = Input::old('cicloFechaFin');
}

if (trim(Input::old('cicloactivo') == false)) {
	$cicloactivo = $ciclo->activo;
} else {
	$cicloactivo = Input::old('cicloactivo');
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
					Ciclo Lectivo <small>editar ciclo</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('organizacions/listado')}}">Organizaciones</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('ciclolectivo/listado')}}">Ciclo Lectivo</a>
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
					    @if (Session::get('message_type') == CiclolectivoController::OPERACION_EXITOSA)

							<div class="note note-success">
								<p> {{ Session::get('message') }} </p>
							</div>
						@elseif (Session::get('message_type') == CiclolectivoController::OPERACION_FALLIDA)

							<div class="note note-danger">
								<p> {{ Session::get('message') }} </p>
							</div>

						@endif	
					@endif
					<!-- COMIENZO DE LA TABLA-->
					{{ Form::open(array('url'=>'ciclolectivo/update', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmCicloLectivo', 'name'=>'FrmCicloLectivo'))}}
					
					<input type='hidden' name='txtCicloId' id='txtCicloId' value='{{$ciclo->id}}'>

					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-calendar"></i> Ciclo Lectivo
							</div>
							<div class="actions">
								<button {{ $disabled }} type='submit' class="btn default green-stripe">
								<i class="fa fa-save"></i>
								<span class="hidden-480">
								Guardar </span>
								</button>
								<a href="{{url('ciclolectivo/listado')}}" class="btn default yellow-stripe">
								<i class="fa fa-reorder"></i>
								<span class="hidden-480">
								Listado </span>
								</a>
								<a href="{{url('ciclolectivo/listado')}}" class="btn default red-stripe">
								<i class="fa fa-times"></i>
								<span class="hidden-480">
								Cancelar </span>
								</a>
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
										<div class="<?php if ($errors->has('ciclolectivo')) echo 'has-error' ?>" >
											<label class="col-md-2 col-sm-2 control-label">Ciclo Lectivo:</label>
											<div class="col-md-2 col-sm-2">
												<input {{ $readonly }} type="text" class="form-control" id="cicloLectivo" name="cicloLectivo" placeholder="" value="{{ $ciclolectivo }}">

												<!-- mostrar cuando exista error -->
											    @if ($errors->has('ciclolectivo'))
												    <span class="help-block">{{ $errors->first('ciclolectivo') }}</span>
											    @endif
											    <!--fin error-->

											</div>
										</div>
										<div class="<?php if ($errors->has('ciclofechainicio')) echo 'has-error' ?>" >
											<label class="col-md-2 col-sm-2 control-label">Fecha Inicio:</label>
											<div class="col-md-2 col-sm-2">
												<input {{ $readonly }} type="text" class="form-control" id="cicloFechaInicio" name="cicloFechaInicio" placeholder="" value="{{ $ciclofechainicio }}">

												<!-- mostrar cuando exista error -->
											    @if ($errors->has('ciclofechainicio'))
												    <span class="help-block">{{ $errors->first('ciclofechainicio') }}</span>
											    @endif
											    <!--fin error-->

											</div>
										</div>
										<div class="<?php if ($errors->has('ciclofechafin')) echo 'has-error' ?>" >
											<label class="col-md-2 col-sm-2 control-label">Fecha Fin:</label>
											<div class="col-md-2 col-sm-2">
												<input {{ $readonly }} type="text" class="form-control" id="cicloFechaFin" name="cicloFechaFin" placeholder="" value="{{ $ciclofechafin }}">

												<!-- mostrar cuando exista error -->
											    @if ($errors->has('ciclofechafin'))
												    <span class="help-block">{{ $errors->first('ciclofechafin') }}</span>
											    @endif
											    <!--fin error-->

											</div>
										</div>	
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label" for="cicloactivo">Activo
											<div class="checker {{$disabled}}">
												<span class="<?php if ($cicloactivo==1) echo 'checked'; ?>">
												<input @if ($cicloactivo==1) {{ 'checked' }} @endif type="checkbox" class="form-control" id="cicloactivo" name="cicloactivo">
												</span>
											</div>
										</label>
										<a href="#" class="btn default col-md-2 date-picker"><i class="fa fa-calendar"></i> Ver Calendario</a>								
										<div class="col-md-8">
											<a {{ $disabled }} id="btnCargarPeriodo" href="#" class="btn blue-madison pull-right"><i class="fa fa-plus"></i> Gestionar Periodos Lectivos</a>
											<a id="btnOcultarPeriodo" style="display:none" href="#" class="btn default pull-right"><i class="fa fa-minus-square"></i> Ocultar Periodos Lectivos</a>
										</div>
									</div>
								</div>
						</div> <!-- FIN PORTLET-BODY -->
					</div>
					<br>
					<div id="divperiodolectivo" class="portlet" style="display:none">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-calendar"></i>Períodos Lectivos
							</div>
						</div>
						<div class="portlet-body">
									<div id="divErrorPeriodoLectivo">
										<label class="col-md-2 col-sm-2 control-label">Período Lectivo:</label>
										<div class="col-md-2 col-sm-2">
											<input type="text" class="form-control" name="periodolectivo" id="periodolectivo" value="">
											<span class="help-block divErrorPeriodoLectivo"></span>
										</div>
									</div>	
									<div id="divErrorPeriodoFechaIni">
										<label class="col-md-1 col-sm-1 control-label">Fecha Inicio:</label>
										<div class="col-md-2 col-sm-2">
											<input type="text" class="form-control" id="periodoFechaInicio" name="periodoFechaInicio" placeholder="" value="">
											<span class="help-block divErrorPeriodoFechaIni"></span>
										</div>
									</div>
									<div id="divErrorPeriodoFechaFin">
										<label  class="col-md-1 col-sm-1 control-label">Fecha Fin:</label>
										<div class="col-md-2 col-sm-2"> 
											<input type="text" class="form-control" id="periodoFechaFin" name="periodoFechaFin" value="">
											<span class="help-block divErrorPeriodoFechaFin"></span>
									    </div>
									    <!--fin error-->
									</div>
									    <div class="col-md-2 col-sm-2">
											<a id="btnAgregaPeriodo" class="btn default pull-right"><i class="fa fa-plus"></i> Agregar</a>
										</div>										

									<div class="form-group col-md-12">
										<label class="col-md-2 control-label">&nbsp;
										</label>
										<div class="col-md-10">
											<table id="tableperiodos" class="table table-hover">
											<thead>
											<tr>
												<th>
													 &nbsp;
												</th>
												<th>
													 Períodos Lectivos
												</th>
												<th>
													 Fecha Inicio
												</th>
												<th>
													 Fecha Fin
												</th>												
												<th>
													 <center>Acción</center>
												</th>
											</tr>
											</thead>
											<tbody>
												<?php foreach ($periodos as $periodo){ ?>
													<?php $aleatorio = mt_rand(6001, 20000); ?>
													<tr>
														<td>
															 &nbsp;
														</td>
														<td>
															<span id="des_<?php echo $aleatorio; ?>">
															 {{ $periodo->descripcion }}
															</span> 
														</td>
														<td>
															<span id="fechaini_<?php echo $aleatorio; ?>">
															 {{ FechaHelper::getFechaImpresion($periodo->fechainicio) }}
															</span> 
														</td>
														<td>
															<span id="fechafin_<?php echo $aleatorio; ?>">
															 {{ FechaHelper::getFechaImpresion($periodo->fechafin) }}
															</span> 
														</td>
														<td>
															<input type="hidden" name="periodos[]" id="<?php echo $aleatorio; ?>" value="<?php echo $periodo->descripcion."|".$periodo->fechainicio."|".$periodo->fechafin; ?>">
															<center><a title="Modificar" data-id='{{$periodo->id}}' id="btnModi_<?php echo $aleatorio; ?>" rel="<?php echo $aleatorio; ?>" href="#" data-des="{{$periodo->descripcion}}" data-fechaini="{{FechaHelper::getFechaImpresion($periodo->fechainicio)}}" data-fechafin="{{FechaHelper::getFechaImpresion($periodo->fechafin)}}" class="btn default btn-sm purple modificarPeriodo"><i class="fa fa-edit"></i></a><a title="Eliminar" data-id='{{$periodo->id}}' rel="<?php echo $aleatorio; ?>" class="btn default btn-sm red btnBorraPeriodo"><i class="fa fa-trash-o"></i></a></center>
														</td>
													</tr>

												<?php } ?>
											</tbody>
											</table>
										</div>
									</div>									
						</div>
					</div>
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
	//Emular Tab al presionar Enter salta Inputs
	$('input').keydown( function(e) {
	        var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
	        if(key == 13) {
	            e.preventDefault();
	            var inputs = $(this).closest('form').find(':input:visible');
	            inputs.eq( inputs.index(this)+ 1 ).focus();
	        }
	 });
	$('#btnCargarPeriodo').on('click', function(e){
		e.preventDefault();
		$(this).hide();
		$('#btnOcultarPeriodo').show();
		$('#divperiodolectivo').toggle('normal');
		$('#periodolectivo').focus();
	});

	$('#btnOcultarPeriodo').on('click', function(e){
		e.preventDefault();
		$(this).hide();
		$('#btnCargarPeriodo').show();
		$('#divperiodolectivo').toggle('normal');

			$('#divErrorPeriodoLectivo').removeClass('has-error');
			$('.divErrorPeriodoLectivo').text('');
			$('#divErrorPeriodoFechaIni').removeClass('has-error');
			$('.divErrorPeriodoFechaIni').text('');
			$('#divErrorPeriodoFechaFin').removeClass('has-error');
			$('.divErrorPeriodoFechaFin').text('');		
	});
	$('#organizacion').select2({
		placeholder: "Seleccione",
		allowClear: true
	});

	$('#btnAgregaPeriodo').on('click', function(e) {

		e.preventDefault();
		//valido si viene vacio alguno de los tres campos

		if (!comparafecha($('#periodoFechaInicio').val(), $('#periodoFechaFin').val())){
			$('#divErrorPeriodoFechaIni').addClass('has-error');
			$('.divErrorPeriodoFechaIni').text('La fecha inicio debe ser menor.');
			return false;
		}

		var error = 0;
		if ($('#periodolectivo').val().length < 1){

			$('#divErrorPeriodoLectivo').addClass('has-error');
			$('.divErrorPeriodoLectivo').text('El período es obligatorio.');
			error = 1;
		}else{
			$('#divErrorPeriodoLectivo').removeClass('has-error');
			$('.divErrorPeriodoLectivo').text('');
		}
		if($('#periodoFechaInicio').val().length < 1){

			$('#divErrorPeriodoFechaIni').addClass('has-error');
			$('.divErrorPeriodoFechaIni').text('La fecha es obligatoria.');
			error = 1;
		}else{
			$('#divErrorPeriodoFechaIni').removeClass('has-error');
			$('.divErrorPeriodoFechaIni').text('');
		}
		if($('#periodoFechaFin').val().length < 1){

			$('#divErrorPeriodoFechaFin').addClass('has-error');
			$('.divErrorPeriodoFechaFin').text('La fecha es obligatoria.');
			error = 1;
		}else{
			$('#divErrorPeriodoFechaFin').removeClass('has-error');
			$('.divErrorPeriodoFechaFin').text('');
		}
		if (error==1){ return false; }



		$('#divErrorPeriodoLectivo, #divErrorPeriodoFechaIni, #divErrorPeriodoFechaFin').removeClass('has-error');		
		$('.divErrorPeriodoLectivo, .divErrorPeriodoFechaIni, .divErrorPeriodoFechaFin').text('');

		$.ajax({
		  url: "{{url('ciclolectivo/guardarperiodo')}}",
		  data:{
		      'ciclo_lectivo_id': $('#txtCicloId').val(),
		      'descripcion': $('#periodolectivo').val(),
		      'fecha_inicio':$('#periodoFechaInicio').val(),
		      'fecha_fin': $('#periodoFechaFin').val()
		  },
		  type: 'POST'
		}).done(function(periodo) {
			console.log(periodo);
			var idaleatorio = 'periodo_' + aleatorio(100,2000);
			$('#tableperiodos > tbody').append('<tr><td>&nbsp;</td><td><span id="des_' + idaleatorio + '">'+$('#periodolectivo').val()+'</span></td><td><span id="fechaini_' + idaleatorio + '">'+$('#periodoFechaInicio').val()+'</span></td><td><span id="fechafin_' + idaleatorio + '">'+$('#periodoFechaFin').val()+'</span></td><td><center><a title="Modificar" id="btnModi_'+idaleatorio+'" data-id="' + periodo.id + '" rel="'+idaleatorio+'" data-des="'+$('#periodolectivo').val()+'" data-fechaini="'+$('#periodoFechaInicio').val()+'" data-fechafin="'+$('#periodoFechaFin').val()+'" href="#" class="btn default btn-sm purple modificarPeriodo"><i class="fa fa-edit"></i></a><a rel="'+idaleatorio+'" data-id="' + periodo.id + '"  title="Eliminar" class="btn default btn-sm red btnBorraPeriodo"><i class="fa fa-trash-o"></i></a></center></td></tr>');
			$('#FrmCicloLectivo').append('<input id="'+ idaleatorio +'" name="periodos[]" type="hidden" value="'+ $('#periodolectivo').val() +'|'+ $('#periodoFechaInicio').val() +'|'+ $('#periodoFechaFin').val() +'">');
			$('#periodolectivo, #periodoFechaInicio, #periodoFechaFin').val('');
			$('#periodolectivo').focus();
		}).error(function(data){
			console.log(data);
		});
	});

	$('.modificarPeriodo').live('click', function(e){
		e.preventDefault();

		$('#txtIdHiddenPeriodo').val($(this).attr('rel'));
		$('#txt_periodo_lectivo_id').val($(this).attr('data-id'));
		$('#MtxtDescripcion').val($(this).data('des'));
		$('#MtxtFechaIni').val($(this).data('fechaini'));
		$('#MtxtFechaFin').val($(this).data('fechafin'));
		$('#modalModiPeriodo').modal('show');
	});


$('#btnModalModificaPeriodo').live('click', function(){

	//valido que no este vacio
	if ( $("#MtxtDescripcion").val().length < 1 ){
		$('.errorPeriodoModal').addClass('has-error');
		$('#errorPeriodoModal').text('El período es obligatorio.').show();
		return false;
	}
	if ( $("#MtxtFechaIni").val().length < 1 ){
		$('.errorPeriodoFechaInicioModal').addClass('has-error');
		$('#errorPeriodoFechaInicioModal').text('La fecha de inicio es obligatoria.').show();
		return false;
	}
	if ( $("#MtxtFechaFin").val().length < 1 ){
		$('.errorPeriodoFechaFinModal').addClass('has-error');
		$('#errorPeriodoFechaFinModal').text('La fecha fin es obligatoria.').show();
		return false;
	}

	$.ajax({
	  url: "{{url('ciclolectivo/editarperiodo')}}",
	  data:{
	      'periodo_lectivo_id': $('#txt_periodo_lectivo_id').val(),
	      'descripcion': $('#MtxtDescripcion').val(),
	      'fecha_inicio': $("#MtxtFechaIni").val(),
	      'fecha_fin': $("#MtxtFechaFin").val()
	  },
	  type: 'POST'
	}).done(function(request) {
		console.log(request);
	}).error(function(data){
		console.log(data);
	});

	var idcont = $('#txtIdHiddenPeriodo').val();
	$('#'+idcont).val($("#MtxtDescripcion").val()+ '|' +$("#MtxtFechaIni").val()+ '|' + $("#MtxtFechaFin").val());
	//alert($('#'+idcont).val());

	$('#des_'+idcont).text($("#MtxtDescripcion").val());
	$('#fechaini_'+idcont).text($("#MtxtFechaIni").val());
	$('#fechafin_'+idcont).text($("#MtxtFechaFin").val());

	$('#btnModi_'+idcont).data('des', $("#MtxtDescripcion").val());
	$('#btnModi_'+idcont).data('fechaini', $("#MtxtFechaIni").val());
	$('#btnModi_'+idcont).data('fechafin', $("#MtxtFechaFin").val());
	$('#modalModiPeriodo').modal('hide');
});

	$('.btnBorraPeriodo').live('click', function(){
		$('#idPeriodoHidden').val($(this).attr('data-id'));
		$('#txtInputPeriodoHidden').val($(this).attr('rel'));
		$('#modalEliminaPeriodo').modal('show');
	});

	$("#btnMEliminarPeriodo").live('click', function(e) {

		e.preventDefault();

		$.ajax({
		  url: "{{url('ciclolectivo/borrarperiodo')}}",
		  data:{'periodo_lectivo_id': $('#idPeriodoHidden').val()},
		  type: 'POST'
		}).done(function(request) {
			console.log(request);

			if (request.tipo_mensaje == <?php echo CiclolectivoController::OPERACION_FALLIDA?>) {
				alert(request.mensaje);
				return;
		    }

			var idinputHidden = $('#txtInputPeriodoHidden').val();
			console.log(idinputHidden);
			$('#'+idinputHidden).remove();
			$('#des_'+idinputHidden).closest("tr").remove();
			$('#modalEliminaPeriodo').modal('hide');

		}).error(function(data){
			console.log(data);
		});
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

	function aleatorio(a,b) {
	    return '_'+Math.round(Math.random()*(b-a)+parseInt(a));
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

	$('#cicloactivo').change(function(){
	    var checkeado = $(this).attr("checked");
	    if (checkeado) {
			$.ajax({
			  url: "{{url('ciclolectivo/verificaexistecicloactivo')}}",
			  data:{'organizacion_id': $('#organizacion').val()},
			  type: 'POST'
			}).done(function(existe) {
				console.log(existe);
				if (existe) {
	    		    $(this).prop("checked",false);
	        	    $('#modalActivaCiclo').modal('show');
	        	}
			}).error(function(data){
				console.log(data);
			});
	    }
	});

	$('#btnModalActivarCiclo').on('click', function(e){
		e.preventDefault();
		$("#cicloactivo").prop("checked", true );
		$("#cicloactivo").parent().addClass("checked");
		$('#modalActivaCiclo').modal('hide');
	});
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
