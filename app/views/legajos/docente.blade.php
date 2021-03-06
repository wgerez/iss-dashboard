@extends('layouts.master')

@section('customstyle')
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/select2/select2.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/bootstrap-datepicker/css/datepicker.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/bootstrap-datetimepicker/css/datetimepicker.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/fancybox/source/jquery.fancybox.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}"/>
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
	$eliminar = (!$eliminar) ? 'disabled' : '';

	$dni = '';
	$foto = '';
	$cuil_cuit = '';
	$partidanacimiento = '';
	$certificadobuenasalud = '';
	$titulosecundario = '';
	$constituloprofesional = '';
	$cargos_actividades = '';
	$declaracion_jurada = '';
	$seguro = '';
	$otros = '';
	$fechavencimientoseguro = '';
	$docentelegajo_id = 0;

	if (!$docente->docentelegajo == null) {
		if ($docente->docentelegajo->dni) $dni = 'checked';
		
		if ($docente->docentelegajo->foto) $foto = 'checked';

		if ($docente->docentelegajo->cuil_cuit) $cuil_cuit = 'checked';

		if ($docente->docentelegajo->partidanacimiento) $partidanacimiento = 'checked';

		if ($docente->docentelegajo->ficha_medica) $certificadobuenasalud = 'checked';

		if ($docente->docentelegajo->titulosecundario) $titulosecundario = 'checked';

		if ($docente->docentelegajo->tituloprofesional) $constituloprofesional = 'checked';

		if ($docente->docentelegajo->cargos_actividades) $cargos_actividades = 'checked';

		if ($docente->docentelegajo->declaracion_jurada) $declaracion_jurada = 'checked';

		if ($docente->docentelegajo->seguro) $seguro = 'checked';

		if ($docente->docentelegajo->otros) $otros = 'checked';

		if ($docente->docentelegajo->fechavencimientoseguro) $fechavencimientoseguro = $docente->docentelegajo->fechavencimientoseguro;

		if ($docente->docentelegajo->id) $docentelegajo_id = $docente->docentelegajo->id;
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
					Legajo Docente
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('docentes/listado')}}">Docentes</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">Legajos</a>
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
					    @if (Session::get('message_type') == DocentesController::OPERACION_EXITOSA)

							<div class="note note-success">
								<p> {{ Session::get('message') }} </p>
							</div>

						@elseif (Session::get('message_type') == DocentesController::OPERACION_FALLIDA)

							<div class="note note-danger">
								<p> {{ Session::get('message') }} </p>
							</div>

						@endif
					@endif


					<!--<div id='mensaje_no_ok' class="note note-danger" style='display:none'>bbb</div>-->

					<!-- COMIENZO DE LA TABLA-->
					{{ Form::open(array('class'=>'form-horizontal form-row-seperated', 'id'=>'FormLegajos', 'enctype'=>'multipart/form-data'))}}
					<div class="portlet">
						<div class="portlet-title">
							<div class="actions">
								<!--<button type='submit' class="btn default green-stripe">
								<i class="fa fa-save"></i>
								<span class="hidden-480">
								Guardar </span>
								</button>-->
								<a href="{{url('docentes/listado')}}" class="btn default yellow-stripe">
								<i class="fa fa-reorder"></i>
								<span class="hidden-480">
								Listado </span>
								</a>
								<!--<a href="{{url('docentes/listado')}}" class="btn default red-stripe">
								<i class="fa fa-times"></i>
								<span class="hidden-480">
								Cancelar </span>
								</a>-->
							</div>

						</div>
						<div class="portlet-body">
								<div class="tabbable-custom">
									<ul class="nav nav-tabs">
										<li>
											<a href="{{url('docentes/editar')}}/{{$docente->id}}">
											Datos Personales </a>
										</li>
										<li class="active">
											<a href="#tab_legajos" data-toggle="tab">
											Legajo </a>
										</li>
										<!--li>
											<a href="{{url('docentes/familia')}}/{{$docente->id}}">
											Familia </a>
										</li-->
									</ul>
									<div class="tab-content no-space">
										<div class="tab-pane active" id="tab_legajos">
											<div class="form-body">
												<div class="form-group">
													<div class="col-md-4">
														<h4 class="text-info">Legajo: {{$docente->nrolegajo}}</h4>
													</div>
													<div class="col-md-6">
														<h4 class="text-info">
															{{$docente->persona->apellido}}, {{$docente->persona->nombre}}
														</h4>
													</div>													
												</div>
												<div class="form-group">
													<div class="col-md-6">
														<div class="checkbox-list">
															<label>
																<div class="checker {{$disabled}}">
																	<span class="<?php echo $dni; ?>">
																		<input name="fotocopiadni" id='fotocopiadni' type="checkbox" <?php echo $dni; ?>
																	</span>
																</div> 
																Fotocopia DNI
															</label>

															<label>
																<div class="checker {{$disabled}}">
																	<span class="<?php echo $foto; ?>">
																		<input name="foto" id='foto' type="checkbox" <?php echo $foto; ?>
																	</span>
																</div> 
																3 Foto 4x4
															</label>															

															<label>
																<div class="checker {{$disabled}}">
																	<span class="<?php echo $cuil_cuit; ?>">
																		<input name="cuil_cuit" id='cuil_cuit' type="checkbox" <?php echo $cuil_cuit; ?>>
																	</span>
																</div> 
																CUIL/CUIT
															</label>

															<label>
																<div class="checker {{$disabled}}">
																	<span class="<?php echo $partidanacimiento; ?>">
																		<input name="fotocopiapartida" id='fotocopiapartida' type="checkbox" <?php echo $partidanacimiento; ?>>
																	</span>
																</div> 
																Fotocopia partida de nacimiento
															</label>

															<label>
																<div class="checker {{$disabled}}">
																	<span class="<?php echo $cargos_actividades; ?>">
																		<input name="fichapreinscripcion" id='fichapreinscripcion' type="checkbox" <?php echo $cargos_actividades; ?>>
																	</span>
																</div> 
																Ficha Cargos y Actividades
															</label>

															<label>
																<div class="checker {{$disabled}}">
																	<span class="<?php echo $declaracion_jurada; ?>">
																		<input name="constanciatrabajo" id='constanciatrabajo' type="checkbox" <?php echo $declaracion_jurada; ?>>
																	</span>
																</div> 
																Fotocopia Declaración Jurada
															</label>

														</div>
													</div>
													<div class="col-md-6">
														<div class="checkbox-list">

															<label>
																<div class="checker {{$disabled}}">
																	<span class="<?php echo $titulosecundario; ?>">
																		<input name="fotocopiatitulosecundario" id='fotocopiatitulosecundario' type="checkbox" <?php echo $titulosecundario; ?>>
																	</span>
																</div> 
																Fotocopia de título secundario
															</label>

															<label>
																<div class="checker {{$disabled}}">
																	<span class="<?php echo $constituloprofesional; ?>">
																		<input name="constanciatitulotramite" id='constanciatitulotramite' type="checkbox" <?php echo $constituloprofesional; ?>>
																	</span>
																</div> 
																Constancia de Título Profesional
															</label>

															<label>
																<div class="checker {{$disabled}}">
																	<span class="<?php echo $certificadobuenasalud; ?>">
																		<input name="certificadobuenasalud" id='certificadobuenasalud' type="checkbox" <?php echo $certificadobuenasalud; ?>>
																	</span>
																</div> 
																Fotocopia Ficha Médica
															</label>

															<label>
																<div class="checker {{$disabled}}">
																	<span class="<?php echo $seguro; ?>">
																		<input name="seguro" id='seguro' type="checkbox" <?php echo $seguro; ?>>
																	</span>
																</div> 
																Seguro
															</label>

															<label>
																<div class="checker {{$disabled}}">
																	<span class="<?php echo $otros; ?>">
																		<input name="otros" id='otros' type="checkbox" <?php echo $otros; ?>>
																	</span>
																</div> 
																Otros
															</label>															

														</div>
													</div>

													<div class="col-md-10" id="fecha" style="<?php if ($seguro = 'CHECKED') {echo 'display: block';} else {echo 'display: none';} ?>">
														<div class="checkbox-list">
															<label class="col-md-8 col-sm-4 control-label">Fecha Vencimiento Seguro:</label>
													 		<div class="input-icon col-md-3 col-sm-4">
																<input type="date" name="fechaseguro" id="fechaseguro" placeholder="" class="form-control" value="<?php echo $fechavencimientoseguro; ?>">
															</div><a class="btn blue-madison" id='btnAgregar'><i class="fa fa-plus"></i></a>
														</div>
													</div>
												</div>
											
									{{ Form::close()}}

									{{ Form::open(array('url'=>'docentes/guardardocumento', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FormDocumentos', 'enctype'=>'multipart/form-data'))}}

									    <input type ='hidden' name='txtAlumnoLegajoId' value='{{$docentelegajo_id}}'>
									    <input type ='hidden' name='txtAlumnoDocumentoId' value='{{$docente->id}}'>
												<div class="form-group <?php if ($errors->has('tipo_documento')) echo 'has-error' ?>">
													<label for="tipodocumento" class="col-md-2 col-sm-3 control-label">Documentaci&oacute;n:</label>
													<div class="col-md-4 col-sm-6">
														<input {{$readonly}} type="text" class="form-control" id="tipodocumento" name="tipodocumento" value="">
													</div>

													<!-- mostrar cuando exista error -->
												    @if ($errors->has('tipo_documento'))
													    <span class="help-block">{{ $errors->first('tipo_documento') }}</span>
												    @endif
												    <!--fin error-->

												</div>

												<div class="form-group <?php if ($errors->has('imagen')) echo 'has-error' ?>">
													<label for="archivoadjunto" class="col-md-2 col-sm-3 control-label">Seleccionar:</label>
													<div class="col-md-4 col-sm-6">
														<input {{$disabled}} type="file" id="archivoadjunto" name="archivoadjunto" value="">
													</div>

													<!-- mostrar cuando exista error -->
												    @if ($errors->has('imagen'))
													    <span class="help-block">{{ $errors->first('imagen') }}</span>
												    @endif
												    <!--fin error-->

													<div class="col-md-2">
														<button {{$disabled}} type='submit' class="btn btn-sm blue-madison" href=""><i class="fa fa-plus"></i> Agregar archivo</button>
													</div>
												</div>

												<div class="form-group">
													<table class="table table-striped table-bordered table-hover" id="table_documentos">
														<thead>
														<tr>
															<th>
																<center><i class="fa fa-file-text"></i> Tipo de Documento</center>
															</th>
															<th>
																<center><i class="fa fa-calendar"></i> Fecha Actualización</center>
															</th>
															<th>
																<center><i class="fa fa-rocket"></i> Acción</center>
															</th>
														</tr>
														</thead>
														<tbody>
														<?php $i = 0;
														if (count($docente_legajo) > 0) { ?>
															@foreach ($docente_legajo->docenteslegajosdocumentos as $documento)
																<tr id="colum_{{$i}}">
																	<td class="vistaprevia" style="cursor:pointer">
																		{{$documento->tipodocumento}}
																	</td>
																	<td class="vistaprevia" style="cursor:pointer">
																		{{FechaHelper::getFechaImpresion($documento->updated_at)}}
																	</td>
																	<td>
																		<input id="doc_{{$i}}" type="hidden" value="{{url('docentes/documentos')}}/{{$documento->documento}}">
																		<center>
																		<a href="#" {{$disabled}} title="Modificar" data-id="{{$documento->id}}" data-doc="{{$documento->tipodocumento}}" class="btn default btn-xs purple btnEditarDoc">
																		<i class="fa fa-edit"></i></a>
																		<a href="#" title="Eliminar" {{$eliminar}} data-id="{{$documento->id}}" data-doc="{{url('docentes/documentos')}}/{{$documento->documento}}" class="btn default btn-xs red btnEliminarDoc">
																		<i class="fa fa-trash-o"></i></a>
																		</center>
																	</td>
																</tr>
																<?php
																$imagen[] = ['id' => $i, 'nombreimagen' => $documento->documento];
																$i++;
																?>
															@endforeach	
														<?php } ?>															
														</tbody>
													</table>													
												</div>

												<!-- TIENE IMAGEN DOCUMENTO -->
												@if ($i > 0)

												<div class="form-group">
											        <center><label>Vista Documentos</label></center>
													<ul class="grid cs-style-3">
														@if ($imagen)
															@foreach ($imagen as $image)
																<center><ol id="element{{$image['id']}}">
																	<figure>
																		<img id="imgvistaprevia" class="img-responsive" src="{{url('docentes/documentos')}}/{{$image['nombreimagen']}}" alt="vista previa documento" data-id="{{$image['id']}}" height="500" width="500">
																	</figure>
																</ol></center>
															@endforeach	
														@endif	
													</ul>
												</div>

												@endif												
											</div>
										</div>
									</div>
								</div>
												</div>
					</div>
					{{ Form::close()}}
					<!-- FIN DE LA TABLA-->
				</div>
			</div>
			<!-- FIN DEL CONTENIDO -->

	<!-- /.modal-anular -->
	<div class="modal fade" id="modalAnularInscripcion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<center><h4 class="modal-title"><strong>Vista Previa</strong></h4></center>
					</div>
					<div class="modal-body">
						<img id="previa" class="img-responsive" src="" alt="vista previa documento">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn default" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> Cerrar</button>
					</div>
				</div>
				<!-- /.modal-contenido -->
			</div>
		<!-- /.modal-dialog -->
	</div>


		</div>
	</div>
	<!-- FIN -->



	


	<!-- MODAL-->
	<div class="modal fade" id="modalEliminaDoc" tabindex="-3" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		{{ Form::open(array('url' => 'docentes/borrardocumento')) }}
			<input id="idDocumentoHidden" name='idDocumentoHidden' type="hidden" value="">
			<input type ='hidden' name='txtAlumnoDocumentoId' value='{{$docente->id}}'>
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Eliminar Documento</h4>
					</div>
					<div class="modal-body">
					<p>¿Est&aacute;s seguro de querer eliminar este documento?</p>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn red" id="btnEliminarDoc"><i class="fa fa-trash-o"></i> Eliminar</button>
						<button type="button" data-dismiss="modal" class="btn default"><i class="fa fa-times-circle-o"></i> Cancelar</button>
					</div>
				</div>
				<!-- /.modal-contenido -->
			</div>
		{{Form::close()}}	
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
	<!-- FIN DEL MODAL FORM-->


	<!-- MODAL MODIFICAR DOCUMENTO-->
	<div class="modal fade" id="modalEditarDoc" tabindex="-4" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		{{ Form::open(array('url' => 'docentes/editardocumento', 'class' => 'form-horizontal form-row-seperated')) }}
			<input id="idDocumentoHiddenModi" name='idDocumentoHiddenModi' type="hidden" value="">
			<input id="txtAlumnoDocumentoModiId" name='txtAlumnoDocumentoModiId' type="hidden" value="{{$docente->id}}">
			
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Editar Documento</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-2">
								<label class="control-label" for="txtDocumento">Documento:</label>
							</div>
							<div class="col-md-10">
								<input name='txtDocumentoDescripcion' id='txtDocumentoDescripcion' type="text" class="form-control">
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn purple" id="btnModificarDoc"><i class="fa fa-edit"></i> Modificar</button>
						<button type="button" data-dismiss="modal" class="btn default"><i class="fa fa-times-circle-o"></i> Cancelar</button>
					</div>
				</div>
				<!-- /.modal-contenido -->
			</div>
		{{Form::close()}}	
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
	<!-- FIN DEL MODAL FORM-->				

@stop


@section('customjs')
ComponentsFormTools.init();

toastr.options = {
  "closeButton": true,
  "debug": false,
  "positionClass": "toast-top-right",
  "onclick": null,
  "showDuration": "600",
  "hideDuration": "600",
  "timeOut": "2000",
  "extendedTimeOut": "600",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
};

//UIToastr.init();
//Emular Tab al presionar Enter
$('input').keydown( function(e) {
        var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
        if(key == 13) {
            e.preventDefault();
            var inputs = $(this).closest('form').find(':input:visible');
            inputs.eq( inputs.index(this)+ 1 ).focus();
        }
 });

//$('#fecha').hide();

$('#seguro').click(function() {
    if ($('#seguro').is(':checked')) {
        $('#fecha').show();
    } else {
        $('#fecha').hide();
    }
});

$('#btnAgregar').live('click', function() {
	var valor = $('#fechaseguro').val();
	guardar_item_legajo(valor, 'FECHA_SEGURO');
});

//--LEGAJOS
$('.vistaprevia').live('click', function(){
	var $arrid = $(this).parent().attr('id').split('_');
	$('#previa').attr('src', $('#doc_'+$arrid[1]).val());
	//MUESTRO EL MODAL DE ADVERTENCIA
	$('#modalAnularInscripcion').modal('show');
	//$('#imgvistaprevia').attr('src', $('#doc_'+$arrid[1]).val());  
});

$('.btnEliminarDoc').live('click', function(e){
	e.preventDefault();
	$('#idDocumentoHidden').val($(this).data('id'));
	$('#modalEliminaDoc').modal('show');
})

$('.btnEditarDoc').live('click', function(e){
	e.preventDefault();
	$('#idDocumentoHiddenModi').val($(this).data('id'));
	$('#txtDocumentoDescripcion').val($(this).data('doc'));
	$('#txtDocumentoDescripcion').focus().select();
	$('#modalEditarDoc').modal('show');
})

//--

// CLICK EN CHECKS
<?php if ($disabled!='disabled'){ ?>
$('#fotocopiadni').change(function(){
    var checkeado = $(this).attr("checked");
    var valor = (checkeado) ? 1 : 0;
    (valor) ? $(this).parent().addClass('checked') : $(this).parent().removeClass('checked');
    guardar_item_legajo(valor, 'DNI');
});
<?php } ?>

<?php if ($disabled!='disabled'){ ?>
$('#foto').change(function(){
    var checkeado = $(this).attr("checked");
    var valor = (checkeado) ? 1 : 0;
    (valor) ? $(this).parent().addClass('checked') : $(this).parent().removeClass('checked');
    guardar_item_legajo(valor, 'FOTO');
});
<?php } ?>

<?php if ($disabled!='disabled'){ ?>
$('#fotocopiapartida').change(function(){
    var checkeado = $(this).attr("checked");
    var valor = (checkeado) ? 1 : 0;
    (valor) ? $(this).parent().addClass('checked') : $(this).parent().removeClass('checked');
    guardar_item_legajo(valor, 'PARTIDA_NACIMIENTO');
});
<?php } ?>

<?php if ($disabled!='disabled'){ ?>
$('#certificadobuenasalud').change(function(){
    var checkeado = $(this).attr("checked");
    var valor = (checkeado) ? 1 : 0;
    (valor) ? $(this).parent().addClass('checked') : $(this).parent().removeClass('checked');
    guardar_item_legajo(valor, 'BUENA_SALUD');
});
<?php } ?>

<?php if ($disabled!='disabled'){ ?>
$('#cuil_cuit').change(function(){
    var checkeado = $(this).attr("checked");
    var valor = (checkeado) ? 1 : 0;
    (valor) ? $(this).parent().addClass('checked') : $(this).parent().removeClass('checked');
    guardar_item_legajo(valor, 'CUIL_CUIT');
});
<?php } ?>

<?php if ($disabled!='disabled'){ ?>
$('#fichapreinscripcion').change(function(){
    var checkeado = $(this).attr("checked");
    var valor = (checkeado) ? 1 : 0;
    (valor) ? $(this).parent().addClass('checked') : $(this).parent().removeClass('checked');
    guardar_item_legajo(valor, 'CARGOS_ACTIVIDADES');
});
<?php } ?>

<?php if ($disabled!='disabled'){ ?>
$('#fotocopiatitulosecundario').change(function(){
    var checkeado = $(this).attr("checked");
    var valor = (checkeado) ? 1 : 0;
    (valor) ? $(this).parent().addClass('checked') : $(this).parent().removeClass('checked');
    guardar_item_legajo(valor, 'TITULO');
});
<?php } ?>

<?php if ($disabled!='disabled'){ ?>
$('#constanciatitulotramite').change(function(){
    var checkeado = $(this).attr("checked");
    var valor = (checkeado) ? 1 : 0;
    (valor) ? $(this).parent().addClass('checked') : $(this).parent().removeClass('checked');
    guardar_item_legajo(valor, 'TITULO_PROFESIONAL');
});
<?php } ?>

<?php if ($disabled!='disabled'){ ?>
$('#constanciatrabajo').change(function(){
    var checkeado = $(this).attr("checked");
    var valor = (checkeado) ? 1 : 0;
    (valor) ? $(this).parent().addClass('checked') : $(this).parent().removeClass('checked');
    guardar_item_legajo(valor, 'DECLARACION_JURADA');
});
<?php } ?>

<?php if ($disabled!='disabled'){ ?>
$('#seguro').change(function(){
    var checkeado = $(this).attr("checked");
    var valor = (checkeado) ? 1 : 0;
    (valor) ? $(this).parent().addClass('checked') : $(this).parent().removeClass('checked');
    guardar_item_legajo(valor, 'SEGURO');
    
    if (valor == 0) {
    	$('#fechaseguro').val('');
    	var valor = $('#fechaseguro').val();
		guardar_item_legajo(valor, 'FECHA_SEGURO');
    }
});
<?php } ?>

<?php if ($disabled!='disabled'){ ?>
$('#otros').change(function(){
    var checkeado = $(this).attr("checked");
    var valor = (checkeado) ? 1 : 0;
    (valor) ? $(this).parent().addClass('checked') : $(this).parent().removeClass('checked');
    guardar_item_legajo(valor, 'OTROS');
});
<?php } ?>

function guardar_item_legajo(valor, campo) {
	$.ajax({
	  url: "{{url('docentes/guardaritemlegajo')}}",
	  data:{
	      'legajoId': <?php echo $docentelegajo_id; ?>,
	      'valor': valor,
	      'campo': campo,
	      'docente_id': <?php echo $docente->id; ?>
	  },
	  type: 'POST'
	}).done(function(result) {
	    if (result.tipo_mensaje == <?php echo DocentesController::OPERACION_EXITOSA?>) {

	    	toastr.success(result.mensaje, "Docentes");
	    	
	    }
	}).error(function(data){
		console.log(data);
	});
}


@stop


@section('includejs') 
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{url('assets/global/plugins/select2/select2.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/global/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js')}}"></script>
<script type="text/javascript" src="{{url('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
<script type="text/javascript" src="{{url('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{url('assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js')}}" type="text/javascript"></script>
<script src="{{url('assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{url('assets/global/plugins/fancybox/source/jquery.fancybox.pack.js')}}"></script>
<script src="{{url('assets/global/plugins/plupload/js/plupload.full.min.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{url('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}"></script>

<script src="{{url('assets/admin/layout/scripts/menusticky.js')}}" type="text/javascript"></script>
<script src="{{url('assets/admin/pages/scripts/components-form-tools.js')}}"></script>
<script src="{{url('assets/admin/pages/scripts/helpers/calculo.edad.js')}}" type="text/javascript"></script>
<script src="{{url('assets/global/plugins/bootstrap-toastr/toastr.min.js')}}"></script>
<!-- END PAGE LEVEL PLUGINS -->
@stop
