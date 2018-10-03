@extends('layouts.master')

@section('customstyle')
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/select2/select2.css')}}"/>
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

$carreraid = (trim(Input::old('carrera') == false)) ? $planestudios->carrera_id : Input::old('carrera');
$cicloid = (trim(Input::old('ciclo') == false)) ? $planestudios->ciclolectivo_id : Input::old('ciclo');
$codigoplan = (trim(Input::old('codigoplan') == false)) ? $planestudios->codigoplan : Input::old('codigoplan');
$tituloplan = (trim(Input::old('tituloplan') == false)) ? $planestudios->tituloplan : Input::old('tituloplan');
$nroresolucion = (trim(Input::old('nroresolucion') == false)) ? $planestudios->nroresolucion : Input::old('nroresolucion');
$fechainicio = (trim(Input::old('fechaInicio') == false)) ? $fechainicio : Input::old('fechaInicio');
$fechafin = (trim(Input::old('fechaFin') == false)) ? $fechafin : Input::old('fechaFin');

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
					Plan de Estudios <small>editar plan</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('planestudios/listado')}}">Plan de Estudios</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('planestudios/editar')}}">editar</a>
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
					    @if (Session::get('message_type') == PlanestudiosController::OPERACION_EXITOSA)

							<div class="note note-success">
								<p> EL PLAN SE GUARDÓ CORRECTAMENTE </p>
							</div>
						@elseif (Session::get('message_type') == PlanestudiosController::OPERACION_FALLIDA)

							<div class="note note-danger">
								<p> HUBO UN PROBLEMA AL GUARDAR EL PLAN, VERIFIQUE SI LOS DATOS ESTAN BIEN CARGADOS. </p>
							</div>

						@endif	
					@endif
					<!-- COMIENZO DE LA TABLA-->
					{{ Form::open(array('url'=>'api/planestudios/'.$planestudios->id, 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmPlanUpdate', 'name'=>'FrmPlanUpdate', 'method'=>'PUT')) }}
						<input type="hidden" value="{{$planestudios->id}}" name="planid" id="planid">
						<div class="portlet">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-files-o"></i> Plan de estudios
								</div>
								<div class="actions">
									<button type='submit' class="btn default green-stripe">
									<i class="fa fa-save"></i>
									<span class="hidden-480">
									Guardar </span>
									</button>
									<a href="../listado" class="btn default yellow-stripe">
									<i class="fa fa-reorder"></i>
									<span class="hidden-480">
									Listado </span>
									</a>
								</div>

							</div>
							<div class="portlet-body form">
									<div class="form-body">
										<div class="form-group">
											<label class="col-md-2 control-label" for="carrera">Carrera:</label>
											<div class="col-md-6">
												{{ Form::select('carrera', $carreras, $carreraid, array('class'=>'table-group-action-input form-control','id'=>'carrera')) }}
											</div>
										</div>

										<div class="form-group">
											<label class="col-md-2 control-label" for="ciclo">Ciclo Lectivo:</label>
											<div class="col-md-2">
												{{ Form::select('ciclo', $ciclos, $cicloid, array('class'=>'table-group-action-input form-control','id'=>'ciclo')) }}
											</div>
											@if ($errors->has('ciclo'))
											    <span class="help-block">El ciclo es obligatorio.</span>
										    @endif											
										</div>

										<div class="form-group">
											<label class="col-md-2 control-label" for="codigoplan">Cod. de Plan:</label>
											<div class="col-md-2">
												<input type="text" class="form-control" id="codigoplan" name="codigoplan" value="{{$codigoplan}}">
											</div>
										</div>

										<div class="form-group">
											<label class="col-md-2 control-label" for="tituloplan">Título del Plan:</label>
											<div class="col-md-6">
												<input type="text" class="form-control" id="tituloplan" name="tituloplan" value="{{$tituloplan}}">
											</div>
											@if ($errors->has('tituloplan'))
												<span class="help-block">El título de plan es obligatorio.</span>
											@endif	
										</div>										

										<div class="form-group <?php if ($errors->has('nroresolucion')) echo 'has-error' ?> ">
											<label class="col-md-2 control-label" for="nroresolucion">Nro. Resolución:</label>
											<div class="col-md-6">
												<input type="text" class="form-control" id="nroresolucion" name="nroresolucion" value=" {{$nroresolucion}}" >
												@if ($errors->has('nroresolucion'))
												    <span class="help-block">{{ $errors->first('nroresolucion') }}</span>
											    @endif
											</div>
										</div>

										<div class="form-group">
											<label class="col-md-2 col-sm-2 control-label" for="fechaInicio">Fecha Inicio:</label>
											<div class="col-md-2 col-sm-2">
												<input type="text" class="form-control" id="fechaInicio" name="fechaInicio" placeholder="" value="{{$fechainicio}}">
											</div>
											@if ($errors->has('fechaInicio'))
												<span class="help-block">La fecha de inicio es obligatoria.</span>
											@endif	
										</div>

										<div class="form-group">
											<label class="col-md-2 col-sm-2 control-label" for="fechaFin">Fecha Fin:</label>
											<div class="col-md-2 col-sm-2">
												<input type="text" class="form-control" id="fechaFin" name="fechaFin" placeholder="" value="{{$fechafin}}">
											</div>
											<span class="help-block">La fecha de fin debe ser mayor</span>
										</div>

									</div>																	
							</div> <!-- FIN PORTLET-BODY -->
						</div>
					</form>
				</div>
			</div>
			<!-- FIN DEL CONTENIDO -->
		</div>
	</div>
	<!-- FIN -->
@stop


@section('customjs')
	//Emular Tab al presionar Enter
	$('input').keydown( function(e) {
	        var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
	        if(key == 13) {
	            e.preventDefault();
	            var inputs = $(this).closest('form').find(':input:visible');
	            inputs.eq( inputs.index(this)+ 1 ).focus();
	        }
	});
	 
	$('#carreras').select2({
		placeholder: "Seleccione",
		allowClear: true
	});

    $("#fechaInicio, #fechaFin").inputmask("dd/mm/yyyy", {
        "placeholder": "__/__/____"
    });

	$('#carrera, #ciclo').on('change', function(){
		$('#codigoplan').val( primeraletra($("#carrera option:selected").text()) +'/'+$("#ciclo option:selected").text().trim() );
	});


	function primeraletra(frase) {
	    var resultado =	frase.concat(' ').replace(/([a-zA-ZñÑáéíóúÁÉÍÓÚ]{0,} )/g, function(match){ 
	    	return (match.trim()[0]);
	    }); 
		    
		return resultado;			
	}    
@stop

@section('includejs')
	<script type="text/javascript" src="{{url('assets/global/plugins/select2/select2.min.js')}}"></script>
	<script src="{{url('assets/admin/layout/scripts/menusticky.js')}}" type="text/javascript"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js')}}"></script>
@stop
