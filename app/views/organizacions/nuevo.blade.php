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

@section('content')
	<!-- COMIENZO CONTENIDO -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- COMIENZO DEL HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- COMIENZO TITULO & BREADCRUMB-->
					<h3 class="page-title">
					Organización <small>nueva organización</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('oraganizacions/listado')}}">Organizaciones</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">nueva</a>
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
					{{ Form::open(array('url'=>'organizacions/guardar', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FormOrganizacion'))}}
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-university"></i> Nueva Organización
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
								<a href="listado" class="btn default red-stripe">
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
									<div class="tab-content no-space">
										<div class="tab-pane active" id="tab_datos_organizacion">
											<div class="form-body">
												<!-- la clase has-error muestra cuando exista errores en la carga -->

											    <div class="form-group <?php if ($errors->has('nombre')) echo 'has-error' ?>">

													<label class="col-md-2 control-label">Nombre: <span class="required">
													* </span>
													</label>
													<div class="col-md-6">
														<input type="text" class="form-control" name="nombre" placeholder="" value="{{ Input::old('nombre') }}">

														<!-- mostrar cuando exista error -->
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
														<input type="text" class="form-control" name="razon" placeholder="" value="{{ Input::old('razon') }}">

														<!-- mostrar cuando exista error -->
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
														<input type="text" class="form-control" name="cuit" placeholder="" value="{{ Input::old('cuit') }}">

														<!-- mostrar cuando exista error -->
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
														{{ Form::select('nivel', $arrNivelEducativo, Input::old('nivel'), array('class'=>'table-group-action-input form-control input-medium')); }}
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-2 control-label">Habilitar Sedes:</label>
													<div class="col-md-6">
														<input type="checkbox" class="form-control" name="habilitarsedes" >
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
																	{{ Form::select('pais', $arrPais, Input::old('pais'), array('class'=>'table-group-action-input form-control input-medium', 'id'=>'pais')); }}
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
																	{{ Form::select('provincia', $arrProvincia, Input::old('provincia'), array('class'=>'table-group-action-input form-control input-medium', 'id'=>'provincia')); }}
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
																	{{ Form::select('departamento', $arrDepartamento, Input::old('departamento'), array('class'=>'table-group-action-input form-control input-medium', 'id'=>'departamento')); }}
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
																	{{ Form::select('localidad', $arrLocalidad, Input::old('localidad'), array('class'=>'table-group-action-input form-control input-medium', 'id'=>'localidad')); }}
																</div>
															</div>


															<div class="form-group">
																<label class="col-md-2 control-label">Barrio: <span class="required">
																* </span>
																</label>
																<div class="col-md-6">
																	<input type="text" class="form-control" name="txt_barrio" Input::old('txt_barrio')>
																</div>
																<!--<div class="col-md-6">
																	{{ Form::select('barrio', $arrBarrio, Input::old('barrio'), array('class'=>'table-group-action-input form-control input-medium', 'id'=>'barrio')); }}
																</div>-->
															</div>															


															<div class="form-group">
																<label class="col-md-2 control-label">Calle:
																</label>
																<div class="col-md-6">
																	<input type="text" class="form-control" name="calle" placeholder="" value="{{ Input::old('calle') }}">
																</div>
															</div>

															<div class="form-group">
																<label class="col-md-2 control-label">Número:
																</label>
																<div class="col-md-1">
																	<input type="text" class="form-control" name="numerocalle" placeholder="" value="{{ Input::old('numerocalle') }}">
																</div>

																<label class="col-md-2 control-label">Mz.:
																</label>
																<div class="col-md-1">
																	<input type="text" class="form-control" name="manzana" placeholder="" value="{{ Input::old('manzana') }}">
																</div>																
															</div>		

															<div class="form-group">
																<label class="col-md-2 control-label">Departamento:
																</label>
																<div class="col-md-1">
																	<input type="text" class="form-control" name="domiciliodepartamento" placeholder="" value="{{ Input::old('domiciliodepartamento') }}">
																</div>

																<label class="col-md-2 control-label">Piso.:
																</label>
																<div class="col-md-1">
																	<input type="text" class="form-control" name="piso" placeholder="" value="{{ Input::old('piso') }}">
																</div>																
															</div>		

															<div class="form-group <?php if ($errors->has('codigoPostal')) echo 'has-error' ?>">
																<label class="col-md-2 control-label">Código Postal:<span class="required"> * </span>
																</label>
																<div class="col-md-2">
																	<input type="text" class="form-control" name="codigopostal" placeholder="" value="{{ Input::old('codigopostal') }}">

																	<!-- mostrar cuando exista error -->
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
																	{{ Form::select('cboContacto', $arrContacto, Input::old('cboContacto'), array('class'=>'table-group-action-input form-control', 'id'=>'cboContacto')); }}
																</div>

																<div class="errorContactoDescripcion">
																	<label class="col-md-2 control-label">Descripci&oacute;n:
																	</label>
																	<div class="col-md-3">
																		<input type="text" class="form-control" name="contactodescripcion" id="contactodescripcion" placeholder="">
																		<span id="errorContactoDescripcion" class="help-block"></span>
																	</div>
																</div>
																<div class="col-md-2">
																	<a href="#" id="btnAgregaContacto" class="btn default"><i class="fa fa-plus"></i> Agregar</a>
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
																			 Acción
																		</th>
																	</tr>
																	</thead>
																	<tbody>
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

$('#btnAgregaContacto').on('click', function(e) {
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
	
	var iconcontacto = $("#cboContacto :selected").text();
	if (iconcontacto=='Particular' || iconcontacto=='Laboral'){
		var ico = '<i class="fa fa-phone-square"></i>';
	}else if (iconcontacto=='Correo'){
		var ico = '<i class="fa fa-envelope"></i>';
	}else{
		var ico = '<i class="fa fa-globe"></i>';
	}
	var idaleatorio = $('#cboContacto').val() + aleatorio(100,2000);
	$('#tablecontactos > tbody').append('<tr><td>'+ico+'</i></td><td>'+$("#cboContacto :selected").text()+'</td><td>'+$('#contactodescripcion').val()+'</td><td><center><a rel="'+idaleatorio+'" title="Eliminar" href="#" class="btn default btn-sm red borrarContacto"><i class="fa fa-trash-o"></i></a></center></td></tr>');
	$('#FormOrganizacion').append('<input id="'+ idaleatorio +'" name="contactos[]" type="hidden" value="'+ $('#cboContacto').val() +'|'+ $('#contactodescripcion').val() +'">');
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

function aleatorio(a,b) {
    return '_'+Math.round(Math.random()*(b-a)+parseInt(a));
}

$('#pais, #provincia, #departamento, #localidad, #barrio, #cboContacto').select2({
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
<!-- END PAGE LEVEL PLUGINS -->
@stop
