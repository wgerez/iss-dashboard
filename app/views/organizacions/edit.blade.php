<!-- Form::model($organizacion, array('route' => array('organizacions.update', $organizacion->id), 'method' => 'PUT')) }}-->

@extends('layouts.master')

@section('customstyle')
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/select2/select2.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/bootstrap-datepicker/css/datepicker.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/bootstrap-datetimepicker/css/datetimepicker.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/fancybox/source/jquery.fancybox.css')}}"/>
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

$nombre = (trim(Input::old('nombre') == false)) ? $organizacion->nombre : Input::old('nombre');
$razon_social = (trim(Input::old('razon') == false)) ? $organizacion->razon_social : Input::old('razon');
$cuit = (trim(Input::old('cuit') == false)) ? $organizacion->cuit : Input::old('cuit');
$habilitarSedes = (trim(Input::old('habilitarSedes') == false)) ? $organizacion->habilitar_sedes : Input::old('habilitarSedes');
$calle = (trim(Input::old('calle') == false)) ? $organizacion->calle : Input::old('calle');
$departamento = (trim(Input::old('domiciliodepartamento') == false)) ? $organizacion->departamento : Input::old('domiciliodepartamento');
$piso = (trim(Input::old('piso') == false)) ? $organizacion->piso : Input::old('piso');

if (trim(Input::old('numerocalle') == false)) {
	$numero = ($organizacion->numero != 0) ? $organizacion->numero : '';
} else {
	$numero = Input::old('numerocalle');
}

if (trim(Input::old('manzana') == false)) {
	$manzana = ($organizacion->manzana != 0) ? $organizacion->manzana : '';
} else {
	$manzana = Input::old('manzana');
}

if (trim(Input::old('codigoPostal') == false)) {
	$codigoPostal = ($organizacion->codigo_postal != 0) ? $organizacion->codigo_postal : '';
} else {
	$codigoPostal = Input::old('codigoPostal');
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
					Organización <small>editar organización</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">Organizaciones</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">edición</a>
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
					    @if (Session::get('message_type') == OrganizacionsController::OPERACION_EXITOSA)

							<div class="note note-success">
								<p> {{ Session::get('message') }} </p>
							</div>

						@elseif (Session::get('message_type') == OrganizacionsController::OPERACION_FALLIDA)

							<div class="note note-danger">
								<p> {{ Session::get('message') }} </p>
							</div>

						@endif	
					@endif
					<!-- COMIENZO DE LA TABLA-->
					{{ Form::open(array('url'=>'organizacions/update', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FormOrganizacion'))}}
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-university"></i> Editar Organización
							</div>
							<div class="actions">
								<button {{$disabled}} type='submit' class="btn default green-stripe">
								<i class="fa fa-save"></i>
								<span class="hidden-480">
								Guardar </span>
								</button>
								<a href="{{url('organizacions/listado')}}" class="btn default yellow-stripe">
								<i class="fa fa-reorder"></i>
								<span class="hidden-480">
								Listado </span>
								</a>
								<a href="{{url('organizacions/listado')}}" class="btn default red-stripe">
								<i class="fa fa-times"></i>
								<span class="hidden-480">
								Cancelar </span>
								</a>
							</div>

						</div>
						<div class="portlet-body">
								<div class="tabbable-custom">
									<ul class="nav nav-tabs">
										<li class="active">
											<a href="#tab_datos_organizacion" data-toggle="tab">
											Datos Organización </a>
										</li>
										<li>
											<a href="#tab_sedes" data-toggle="tab">
											Sedes </a>
										</li>
										<li>
											<a href="#tab_logo" data-toggle="tab">
											Logo </a>
										</li>
									</ul>

									{{ Form::hidden('txtOrganizacionId', $organizacion->id) }}

									<div class="tab-content no-space">
										<div class="tab-pane active" id="tab_datos_organizacion">
											<div class="form-body">
												<!-- la clase has-error muestra cuando haya errores en la carga -->

											    <div class="form-group <?php if ($errors->has('nombre')) echo 'has-error' ?>">

													<label class="col-md-2 control-label">Nombre: <span class="required">
													* </span>
													</label>
													<div class="col-md-6">
														<input {{$readonly}} type="text" class="form-control" name="nombre" placeholder="" value='{{ $nombre }}'>

														<!-- mostrar cuando haya error -->
													    @if ($errors->has('nombre'))
														    <span class="help-block">{{ $errors->first('nombre') }}</span>
													    @endif
													    <!--fin error-->

													</div>
												</div>
												<div class="form-group <?php if ($errors->has('razonSocial')) echo 'has-error' ?>">
													<label class="col-md-2 control-label">Razón Social: <span class="required">
													* </span>
													</label>
													<div class="col-md-6">
														<input {{$readonly}} type="text" class="form-control" name="razon" placeholder="" value='{{ $razon_social }}'>

														<!-- mostrar cuando haya error -->
													    @if ($errors->has('razonSocial'))
														    <span class="help-block">{{ $errors->first('razonSocial') }}</span>
													    @endif
													    <!--fin error-->

													</div>
												</div>
												<div class="form-group <?php if ($errors->has('cuit')) echo 'has-error' ?>">
													<label class="col-md-2 control-label">CUIT: <span class="required">
													* </span>
													</label>
													<div class="col-md-6">
														<input {{$readonly}} type="text" class="form-control" name="cuit" placeholder="" value='{{ $organizacion->cuit }}'>

														<!-- mostrar cuando haya error -->
													    @if ($errors->has('cuit'))
														    <span class="help-block">{{ $errors->first('cuit') }}</span>
													    @endif
													    <!--fin error-->

													</div>
												</div>
												<div class="form-group">
													<label class="col-md-2 control-label">Nivel de Educación: <span class="required">
													* </span>
													</label>
													<div class="col-md-10">
														{{ Form::select('nivel', $arrNivelEducativo, $organizacion->nivel_Educativo_id, array('class'=>'table-group-action-input form-control input-medium', $disabled)); }}
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-2 control-label">Habilitar Sedes:</label>
													<div class="checker {{$disabled}}">
														<span class="<?php if ($habilitarSedes) echo 'checked'; ?>">
														<input type="checkbox" class="form-control" name="habilitarsedes" @if ($habilitarSedes) CHECKED @endif>
														</span>
													</div>
												</div>
												<br>
													<div class="portlet">
														<div class="portlet-title">
															<div class="caption">
																<i class="fa fa-language"></i>Domicilio
															</div>
														</div>
														<div class="portlet-body">
															<div class="form-group">
																<label class="col-md-2 control-label">Pa&iacute;s: <span class="required">
																* </span>
																</label>
																<!--<div class="col-md-1">
																	<input type="text" class="form-control" name="codigopais" >
																</div>-->
																<div class="col-md-6">
																	{{ Form::select('pais', $arrPais, $organizacion->pais_id, array('class'=>'table-group-action-input form-control input-medium', 'id'=>'pais', $disabled)); }}
																</div>
															</div>

															<div class="form-group">
																<label class="col-md-2 control-label">Provincia: <span class="required">
																* </span>
																</label>
																<!--<div class="col-md-1">
																	<input type="text" class="form-control" name="codigoprovincia">
																</div>-->
																<div class="col-md-6">
																	{{ Form::select('provincia', $arrProvincia, $organizacion->provincia_id, array('class'=>'table-group-action-input form-control input-medium', 'id'=>'provincia', $disabled)); }}
																</div>
															</div>

															<div class="form-group">
																<label class="col-md-2 control-label">Departamento: <span class="required">
																* </span>
																</label>
																<!--<div class="col-md-1">
																	<input type="text" class="form-control" name="codigodepartamento">
																</div>-->
																<div class="col-md-6">
																	{{ Form::select('departamento', $arrDepartamento, $organizacion->departamento_id, array('class'=>'table-group-action-input form-control input-medium', 'id'=>'departamento', $disabled)); }}
																</div>
															</div>


															<div class="form-group">
																<label class="col-md-2 control-label">Localidad: <span class="required">
																* </span>
																</label>
																<!--<div class="col-md-1">
																	<input type="text" class="form-control" name="codigolocalidad">
																</div>-->
																<div class="col-md-6">
																	{{ Form::select('localidad', $arrLocalidad, $organizacion->localidad_id, array('class'=>'table-group-action-input form-control input-medium', 'id'=>'localidad', $disabled)); }}
																</div>
															</div>


															<div class="form-group">
																<label class="col-md-2 control-label">Barrio: <span class="required">
																* </span>
																</label>
																<div class="col-md-6">
																	<input type="text" class="form-control" name="txt_barrio" Input::old('txt_barrio') value='{{$organizacion->barrio}}'>
																</div>
																<!--<div class="col-md-6">
																	{{ Form::select('barrio', $arrBarrio, $organizacion->barrio_id, array('class'=>'table-group-action-input form-control input-medium', 'id'=>'barrio', $disabled)); }}
																</div>-->
															</div>															


															<div class="form-group">
																<label class="col-md-2 control-label">Calle:
																</label>
																<div class="col-md-6">
																	<input {{$readonly}} type="text" class="form-control" name="calle" placeholder="" value='{{ $calle }}'>
																</div>
															</div>

															<div class="form-group">
																<label class="col-md-2 control-label">Número:
																</label>
																<div class="col-md-1">
																	<input {{$readonly}} type="text" class="form-control" name="numerocalle" placeholder="" value='{{ $numero }}'>
																</div>

																<label class="col-md-2 control-label">Mz.:
																</label>
																<div class="col-md-1">
																	<input {{$readonly}} type="text" class="form-control" name="manzana" placeholder="" value='{{ $manzana }}'>
																</div>																
															</div>		

															<div class="form-group">
																<label class="col-md-2 control-label">Departamento:
																</label>
																<div class="col-md-1">
																	<input {{$readonly}} type="text" class="form-control" name="domiciliodepartamento" placeholder="" value='{{ $departamento }}'>
																</div>

																<label class="col-md-2 control-label">Piso.:
																</label>
																<div class="col-md-1">
																	<input {{$readonly}} type="text" class="form-control" name="piso" placeholder="" value='{{ $piso }}'>
																</div>																
															</div>		

															<div class="form-group <?php if ($errors->has('codigoPostal')) echo 'has-error' ?>">
																<label class="col-md-2 control-label">Código Postal:
																</label>
																<div class="col-md-2">
																	<input {{$readonly}} type="text" class="form-control" name="codigopostal" placeholder="" value='{{ $codigoPostal }}'>

																	<!-- mostrar cuando haya error -->
																    @if ($errors->has('codigoPostal'))
																	    <span class="help-block">{{ $errors->first('codigoPostal') }}</span>
																    @endif
																    <!--fin error-->

																</div>
															</div>																														

														</div>
													</div>

													<br>
													<div class="portlet">
														<div class="portlet-title">
															<div class="caption">
																<i class="fa fa-envelope-square"></i>Contactos
															</div>
														</div>
														<div class="portlet-body">

															<div class="form-group">
																<label class="col-md-2 control-label">Tipo de Contacto:
																</label>
																<div class="col-md-3">
																	{{ Form::select('cboContacto', $arrTipoContacto, Input::old('cboContacto'), array('class'=>'table-group-action-input form-control', 'id'=>'cboContacto', $disabled)); }}
																</div>

																<div class="errorContactoDescripcion">
																	<label class="col-md-2 control-label">Descripci&oacute;n:
																	</label>
																	<div class="col-md-3">
																		<input {{$readonly}} type="text" class="form-control" name="contactodescripcion" id="contactodescripcion" placeholder="">
																		<span id="errorContactoDescripcion" class="help-block"></span>
																	</div>
																</div>
																<div class="col-md-2">
																	<a {{$disabled}} href="#" id="btnAgregaContacto" class="btn default"><i class="fa fa-plus"></i> Agregar</a>																	
																</div>																
															</div>	
															<div class="form-group">
																<label class="col-md-2 control-label">&nbsp;
																</label>																
																<div class="col-md-10">
																	<table id="tablecontactos" class="table table-hover">
																	<thead>
																	<tr>
																		<th>
																			 &nbsp;
																		</th>
																		<th>
																			 Tipo
																		</th>
																		<th>
																			 Descripción
																		</th>
																		<th>
																			 <center>Acción</center>
																		</th>
																	</tr>
																	</thead>
																	<tbody>
																		
																		@foreach ($arrContactos as $tipo=>$contacto)
																			<?php $aleatorio = mt_rand(6001, 15000); ?>
																			<tr>
																				<td>
																					<span id="icono_<?php echo $aleatorio; ?>">
																						 @if ($contacto->contacto_id==1 || $contacto->contacto_id==2)
																						 	{{'<i class="fa fa-phone-square"></i>'}}
																						 @elseif ($contacto->contacto_id==3)
																						 	{{'<i class="fa fa-envelope"></i>'}}
																						 @else
																							{{'<i class="fa fa-globe"></i>'}}	
																						 @endif
																					 </span> 	
																				</td>
																				<td>
																					<span id="tipo_<?php echo $aleatorio; ?>">
																					 	{{$tipo}}
																					 </span>
																				</td>
																				<td>
																					<span id="des_<?php echo $aleatorio; ?>">
																						{{$contacto->descripcion}}
																					</span>	
																				</td>
																				<td>
																					<input type="hidden" name="contactos[]" id="<?php echo $aleatorio; ?>" value="{{$contacto->contacto_id}}|{{$contacto->descripcion}}">
																					 <center><a {{$disabled}} title="Modificar" id="btnModi_<?php echo $aleatorio; ?>" rel="<?php echo $aleatorio; ?>" href="#" data-id="{{$contacto->contacto_id}}" data-body="{{$contacto->descripcion}}" class="btn default btn-sm purple modificarContacto"><i class="fa fa-edit"></i></a><a {{$disabled}} title="Eliminar" href="#" rel="<?php echo $aleatorio; ?>" class="btn default btn-sm red borrarContacto"><i class="fa fa-trash-o"></i></a></center>
																				</td>
																			</tr>
																		@endforeach
																	</tbody>
																	</table>
																</div>
															</div>
														</div>
													</div>
											</div>	
										</div>
										<div class="tab-pane" id="tab_sedes">

										</div>
										<div class="tab-pane" id="tab_logo">

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
		</div>
	</div>
	<!-- FIN -->

	<!-- MODAL MODIFICACION DE CONTACTOS-->
	<div class="modal fade" id="modalModiContactos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Modificar Contactos</h4>
					</div>
					<div class="modal-body">
						<form class="form-horizontal">
							<input type="hidden" id="txtIdHiddenContacto" value="">
							<div class="form-group">
								<label class="col-md-3 control-label">Tipo de Contacto</label>
								<div class="col-md-6">
									{{ Form::select('cboTipoContacto', $arrTipoContacto, 'null', array('class'=>'table-group-action-input form-control input-medium', 'id'=>'cboTipoContacto')); }}
								</div>
							</div>
							<div class="form-group errorContactoDescripcionModal">
								<label class="col-md-3 control-label">Descripción</label>
								<div class="col-md-6">
									<input type="text" id="txtDescipContacto" name="txtDescipContacto" class="form-control">
									<span id="errorContactoDescripcionModal" class="help-block"></span>
								</div>
							</div>
						</form>

					</div>
					<div class="modal-footer">
						<button type="button" id="btnModalModificaContactos" class="btn purple"><i class="fa fa-edit"></i> Modificar</button>
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

//Emular Tab al presionar Enter
$('input').keydown( function(e) {
        var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
        if(key == 13) {
            e.preventDefault();
            var inputs = $(this).closest('form').find(':input:visible');
            inputs.eq( inputs.index(this)+ 1 ).focus();
        }
 });

$('#btnAgregaContacto').on('click', function(e){
	e.preventDefault();
	if ($('#contactodescripcion').val().length < 1) return false;

	//valido el formato email y sitio Web
	if ($("#cboContacto :selected").text()=='Correo'){
		if($("#contactodescripcion").val().indexOf('@', 0) == -1 || $("#contactodescripcion").val().indexOf('.', 0) == -1) {
			$('.errorContactoDescripcion').addClass('has-error');
			$('#errorContactoDescripcion').text('El correo es incorrecto.').show();
			return false;
		}
	}else if ($("#cboContacto :selected").text()=='Sitio Web'){
		if($("#contactodescripcion").val().indexOf('.', 0) == -1) {
			$('.errorContactoDescripcion').addClass('has-error');
			$('#errorContactoDescripcion').text('El sitio es incorrecto.').show();
			return false;
		}
	}
	$('.errorContactoDescripcion').removeClass('has-error');		
	$('#errorContactoDescripcion').hide();
	//

	var iconcontacto = $('#cboContacto').val(); 
	if (iconcontacto=='1' || iconcontacto=='2'){
		var ico = '<i class="fa fa-phone-square"></i>';
	}else if (iconcontacto=='3'){
		var ico = '<i class="fa fa-envelope"></i>';
	}else{
		var ico = '<i class="fa fa-globe"></i>';
	}
	var idaleatorio = $('#cboContacto').val() + aleatorio(100,2000);
	$('#tablecontactos > tbody').append('<tr><td><span id="icono_'+idaleatorio+'">'+ico+'</span></td><td><span id="tipo_'+idaleatorio+'">'+$('#cboContacto option:selected').text()+'</span></td><td><span id="des_'+idaleatorio+'">'+$('#contactodescripcion').val()+'</span></td><td><center><a title="Modificar" id="btnModi_'+idaleatorio+'" rel="'+idaleatorio+'" data-id="'+$('#cboContacto option:selected').val()+'" data-body="'+$('#contactodescripcion').val()+'" href="#" class="btn default btn-sm purple modificarContacto"><i class="fa fa-edit"></i></a><a title="Eliminar" href="#" rel="'+idaleatorio+'" class="btn default btn-sm red borrarContacto"><i class="fa fa-trash-o"></i></a></center></td></tr>');
	$('#FormOrganizacion').append('<input id="'+idaleatorio+'" name="contactos[]" type="hidden" value="'+$('#cboContacto').val()+'|'+$('#contactodescripcion').val()+'">');
	$('#contactodescripcion').val('');
	$('#contactodescripcion').focus();
});

$(".borrarContacto" ).live('click', function(e){

	e.preventDefault();

	var idinputHidden = $(this).attr('rel');

	console.log(idinputHidden);
	$('#'+idinputHidden).remove();

    $(this).closest("tr").remove();
});

$('.modificarContacto').live('click', function(e){
	e.preventDefault();
	$('#txtIdHiddenContacto').val($(this).attr('rel'));
	$("#cboTipoContacto option[value="+ $(this).data('id') +"]").attr("selected",true);
	$('#txtDescipContacto').val($(this).data('body'));
	$('#modalModiContactos').modal('show');
});

$('#btnModalModificaContactos').live('click', function(){

	//valido el formato email y sitio Web Modal
	if ($("#cboTipoContacto").val()==3){
		if($("#txtDescipContacto").val().indexOf('@', 0) == -1 || $("#txtDescipContacto").val().indexOf('.', 0) == -1) {
			$('.errorContactoDescripcionModal').addClass('has-error');
			$('#errorContactoDescripcionModal').text('El correo es incorrecto.').show();
			return false;
		}
	}else if ($("#cboTipoContacto").val()==4){
		if($("#txtDescipContacto").val().indexOf('.', 0) == -1) {
			$('.errorContactoDescripcionModal').addClass('has-error');
			$('#errorContactoDescripcionModal').text('El sitio es incorrecto.').show();
			return false;
		}
	}
	$('.errorContactoDescripcionModal').removeClass('has-error');		
	$('#errorContactoDescripcionModal').hide();
	//

	var iconcontacto = $("#cboTipoContacto").val(); 
	if (iconcontacto=='1' || iconcontacto=='2'){
		var ico = '<i class="fa fa-phone-square"></i>';
	}else if (iconcontacto=='3'){
		var ico = '<i class="fa fa-envelope"></i>';
	}else{
		var ico = '<i class="fa fa-globe"></i>';
	}

	var idcont = $('#txtIdHiddenContacto').val();
	$('#'+idcont).val($("#cboTipoContacto").val()+ '|' +$("#txtDescipContacto").val() );
	$('#tipo_'+idcont).text($('#cboTipoContacto option:selected').text());
	$('#des_'+idcont).text($('#txtDescipContacto').val());
	$('#icono_'+idcont).html(ico);
	$('#btnModi_'+idcont).data('id', $("#cboTipoContacto").val());
	$('#btnModi_'+idcont).data('body', $("#txtDescipContacto").val());
	$('#modalModiContactos').modal('hide');
});

function aleatorio(a,b) {
    return '_'+Math.round(Math.random()*(b-a)+parseInt(a));
}

$('#pais, #provincia, #departamento, #localidad, #barrio').select2({
	placeholder: "Seleccione",
	allowClear: true
});
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
<script src="{{url('assets/admin/layout/scripts/menusticky.js')}}" type="text/javascript"></script>
<script src="{{url('assets/admin/layout/scripts/menusticky.js')}}" type="text/javascript"></script>

<!-- END PAGE LEVEL PLUGINS -->
@stop
