@extends('layouts.master')

@section('customstyle')
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/select2/select2.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/jquery-multi-select/css/multi-select.css')}}"/>
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
					Correlatividades <small>Nueva Correlatividad</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('correlatividades/listado')}}">Correlatividades</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">Nueva</a>
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
					    @if (Session::get('message_type') == CorrelatividadesController::OPERACION_EXITOSA)

							<div class="note note-success">
								<p> {{ Session::get('message') }} </p>
							</div>
						@elseif (Session::get('message_type') == CorrelatividadesController::OPERACION_FALLIDA)

							<div class="note note-danger">
								<p> {{ Session::get('message') }} </p>
							</div>

						@endif	
					@endif
					<!-- COMIENZO DE LA TABLA-->
					{{ Form::open(array('url'=>'correlatividades/guardar', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmCorrelativiad', 'name'=>'FrmCorrelativiad'))}}
					
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-info"></i> Listado de Correlatividades
							</div>
							<div class="actions">
								<!--<a href="{{url('correlatividades/crear')}}">-->
								<button id =guardar type='submit' class="btn default green-stripe" disabled>
								<i class="fa fa-save"></i>
								<span class="hidden-480">
								Guardar </span>
								</button>
								<!--</a>-->
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
											<select name="organizacion" id="organizacion" class="table-group-action-input form-control">
												<option value="0">Seleccione</option>
												<?php
												foreach ($arrOrganizaciones as $organizacion) {
												?>
													<option value="<?php echo $organizacion->id; ?>"><?php echo $organizacion->nombre; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-2 control-label" for="carreras">Carrera:</label>
										<div class="col-md-6 col-sm-10">

											<select name="carreras" id="carreras" class="form-control">
												<option value='0' disabled selected>Seleccionar</option>
													
											</select>
	
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label" for="carrera">Plan de estudios:</label>
										<div class="col-md-6 col-sm-10">
											<select name="planes" id="planes" class="form-control">
												<option value='0' disabled selected>Seleccionar</option>
													
											</select>
										</div>							
									</div>	

									<div class="form-group">
										<label class="col-md-2 control-label" for="materia">Materia:</label>
										<div class="col-md-6 col-sm-10">
											<select name="materias" id="materias" class="form-control">
												<option value='0' disabled selected>Seleccionar</option>
													
											</select>
										</div>							
									</div>	

						</div> <!-- FIN PORTLET-BODY -->	
									
									<!--div class="form-group">
										<label class="col-md-2 control-label" for="tituloplan">Docente:</label>
										<div class="col-md-6 col-sm-10">
											<input type="text" class="form-control" id="docente" name="docente">
										</div>
									</div -->

					</div>
					<br>
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-user"></i> Para Cursar:
							</div>
						</div>	
						<div class="form-group">
							<label class="control-label col-md-2 col-sm-2">Materias:</label>
							<div class="col-md-8 col-sm-8">
								<!--<select multiple="multiple" id="my-select_cursada" name="my-select_cursada[]">-->
								{{ Form::select('cursadas[]', array(), Input::old('cursadas'), array('class'=>'table-group-action-input form-control multi-select','id'=>'cursadas', 'multiple'=>'multiple', $disabled)); }}
								</select>
							</div>
							<div class="col-md-2 col-sm-2">
								<label class="pull-left">Haber Cursado/Regular</label>
							</div>
						</div>
					</div>
						
					<br>
					<div class="portlet">
						
						<div class="form-group">
							<label class="control-label col-md-2 col-sm-2">Materias:</label>
							<div class="col-md-8 col-sm-8">
								{{ Form::select('aprobadas[]', array(), Input::old('aprobadas'), array('class'=>'table-group-action-input form-control multi-select','id'=>'aprobadas', 'multiple'=>'multiple', $disabled)); }}
								</select>
							</div>
							<div class="col-md-2 col-sm-2">
								<label class="pull-left">Haber Rendido/Aprobado</label>
							</div>
						</div>
					</div>
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-user"></i> Para Rendir:
							</div>
						</div>	
						<div class="form-group">
							<label class="control-label col-md-2 col-sm-2">Materias:</label>
							<div class="col-md-8 col-sm-8">
								<!--<select multiple="multiple" id="my-select_cursada" name="my-select_cursada[]">-->
								{{ Form::select('finales[]', array(), Input::old('finales'), array('class'=>'table-group-action-input form-control multi-select','id'=>'finales', 'multiple'=>'multiple', $disabled)); }}
								</select>
							</div>
							<div class="col-md-2 col-sm-2">
								<label class="pull-left">Materias Finales</label>
							</div>
						</div>
					</div>

									<!-- FIN TABLA DE PERMISOS -->
					</div>
					</div>
					{{ Form::close()}}
				</div>
			</div>
			<!-- FIN DEL CONTENIDO -->
		</div>
	</div>
	<!-- FIN -->
@stop


@section('customjs')
	
$('#cursadas').multiSelect()
$('#aprobadas').multiSelect()
$('#finales').multiSelect()


$('#organizacion').change(function() {
	
	
	var buscarO = $("#organizacion option:selected").attr("value")
	//alert(buscarO);
	var arrayJS=<?php echo json_encode($arrCarreras);?>;
	//alert(arrayJS.carrera);	

	$('option', '#carreras').remove();
	$("#carreras").append('<option value="0" disabled selected>Seleccionar</option>');
	
	$('option', '#materias').remove();
	$("#materias").append('<option value="0" disabled selected>Seleccionar</option>');

	$('option', '#planes').remove();
	$("#planes").append('<option value="0" disabled selected>Seleccionar</option>');
			
	$.each(arrayJS, function(key, value){
		//$("#carreras").append('<option value="'+value.id+'">'+value.numero+' '+value.letra+'</option>');
		if(value.organizacion_id == buscarO) {
			$("#carreras").append('<option value="'+value.id+'">'+value.carrera+'</option>');
		}

	})


});

$('#carreras').change(function() {
	
	
	var buscarP = $("#carreras option:selected").attr("value")
	//alert(buscarP);
	var arrayJS=<?php echo json_encode($arrPlanes);?>;
	//alert(arrayJS.carrera);	
	
	$('option', '#materias').remove();
	$("#materias").append('<option value="0" disabled selected>Seleccionar</option>');

	$('option', '#planes').remove();
	$("#planes").append('<option value="0" disabled selected>Seleccionar</option>');
			
	$.each(arrayJS, function(key, value){
		//$("#planes").append('<option value="'+value.id+'">'+value.numero+' '+value.letra+'</option>');
		if(value.carrera_id == buscarP) {
			$("#planes").append('<option value="'+value.id+'">'+value.codigoplan+'</option>');
		}

	})


});


$('#planes').change(function() {
	
	
	var buscarP = $("#planes option:selected").attr("value")
	//alert(buscarC);
	var arrayJS=<?php echo json_encode($arrMaterias);?>;
	//alert(arrayJS.carrera);	
	
	$('option', '#materias').remove();
	$("#materias").append('<option value="0" disabled selected>Seleccionar</option>');
			
	$.each(arrayJS, function(key, value){
		//$("#materias").append('<option value="'+value.id+'">'+value.numero+' '+value.letra+'</option>');
		if(value.planestudio_id == buscarP) {
			$("#materias").append('<option value="'+value.id+'">'+value.nombremateria+'</option>');
		}

	})


});


$('#materias').change(function() {
	
	var buscarP = $("#planes option:selected").attr("value")
	var buscarM = $("#materias option:selected").attr("value")
	//alert(buscarP);
	var arrayJS=<?php echo json_encode($arrMaterias);?>;
	
	$('#cursadas').children().remove().end();
    $('#cursadas').multiSelect('refresh');

    $('#aprobadas').children().remove().end();
    $('#aprobadas').multiSelect('refresh');

    $('#finales').children().remove().end();
    $('#finales').multiSelect('refresh');

			
	$.each(arrayJS, function(key, value){
		if(value.planestudio_id == buscarP && value.id != buscarM) {
			// para seleccionados  $('<option selected></option>').val(4).html('Imprimir ' + tipo)			
			$("#cursadas").append('<option value="'+value.id+'">'+value.nombremateria+'</option>');
		}
	})
	

	$.each(arrayJS, function(key, value){
		if(value.planestudio_id == buscarP && value.id != buscarM) {
			$("#aprobadas").append('<option value="'+value.id+'">'+value.nombremateria+'</option>');
		}
	})

	$.each(arrayJS, function(key, value){
		if(value.planestudio_id == buscarP && value.id != buscarM) {
			$("#finales").append('<option value="'+value.id+'">'+value.nombremateria+'</option>');
		}
	})


	$('#cursadas').multiSelect('refresh');
	$('#aprobadas').multiSelect('refresh');
	$('#finales').multiSelect('refresh');

	//$("#guardar").removeClass("disabled");
  	$('#guardar').removeAttr('disabled', 'false');		

});


$('#cursadas').change(function() {

	$('#finales').multiSelect('deselect_all');

	var cursadas = $('#cursadas').val(); 
	if (cursadas) {
		$.each(cursadas, function(key, value){
			$('#finales').multiSelect('select', value);
		})	
	}
	

	
	var aprobadas = $('#aprobadas').val(); 
	if(aprobadas) {
		$.each(aprobadas, function(key, value){
			$('#finales').multiSelect('select', value);
		})
	}



	$('#finales').multiSelect('refresh');
});


$('#aprobadas').change(function() {

	$('#finales').multiSelect('deselect_all');

	var cursadas = $('#cursadas').val(); 
	if (cursadas) {
		$.each(cursadas, function(key, value){
			$('#finales').multiSelect('select', value);
		})	
	}
	

	
	var aprobadas = $('#aprobadas').val(); 
	if(aprobadas) {
		$.each(aprobadas, function(key, value){
			$('#finales').multiSelect('select', value);
		})
	}



	$('#finales').multiSelect('refresh');
});



@stop

@section('includejs') 
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{url('assets/global/plugins/select2/select2.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js')}}"></script>
<script src="{{url('assets/admin/layout/scripts/menusticky.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
@stop
