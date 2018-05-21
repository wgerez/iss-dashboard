@extends('layouts.master')

@section('customstyle')
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/select2/select2.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/bootstrap-datepicker/css/datepicker.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/bootstrap-datetimepicker/css/datetimepicker.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/fancybox/source/jquery.fancybox.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}"/>
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
					Alumnos <small>nuevo alumno</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('alumnos/listado')}}">Alumnos</a>
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
					    @if (Session::get('message_type') == AlumnosController::OPERACION_EXITOSA)

							<div class="note note-success">
								<p> {{ Session::get('message') }} </p>
							</div>

						@elseif (Session::get('message_type') == AlumnosController::OPERACION_FALLIDA)

							<div class="note note-danger">
								<p> {{ Session::get('message') }} </p>
							</div>

						@endif
					@endif
					<!-- COMIENZO DE LA TABLA-->
					{{ Form::open(array('url'=>'alumnos/guardar', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FormAlumnos', 'enctype'=>'multipart/form-data'))}}
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-users"></i> Nuevo Alumno
							</div>
							<div class="actions">
							<a href="{{url('alumnos/crear')}}"></a>
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
											<a href="#tab_datos_personales" data-toggle="tab">
											Datos Personales </a>
										</li>
										<li>
									</ul>
									<div class="tab-content no-space">
										<div class="tab-pane active" id="tab_datos_personales">
											<div class="form-body">
												<!-- la clase has-error muestra cuando exista errores en la carga -->
											<div class="row">
											<div class="col-md-8">
											    <div class="form-group <?php if ($errors->has('apellido')) echo 'has-error' ?>">

													<label class="col-md-3 control-label">Apellido: <span class="required">
													* </span>
													</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="apellido" placeholder="" value="{{ Input::old('apellido') }}">

														<!-- mostrar cuando exista error -->
													    @if ($errors->has('apellido'))
														    <span class="help-block">{{ $errors->first('apellido') }}</span>
													    @endif
													    <!--fin error-->

													</div>
												</div>
												<div class="form-group <?php if ($errors->has('nombre')) echo 'has-error' ?>">
													<label class="col-md-3 control-label">Nombre/s: <span class="required">
													* </span>
													</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="nombre" placeholder="" value="{{ Input::old('nombre') }}">

														<!-- mostrar cuando exista error -->
													    @if ($errors->has('nombre'))
														    <span class="help-block">{{ $errors->first('nombre') }}</span>
													    @endif
													    <!--fin error-->

													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Tipo de Doc.: <span class="required">
													* </span>
													</label>
													<div class="col-md-9">
														{{ Form::select('tipodocumento', $arrTipoDocumento, Input::old('tipodocumento'), array('class'=>'table-group-action-input form-control input-medium')); }}
													</div>
												</div>
												<div class="form-group <?php if ($errors->has('documento')) echo 'has-error' ?>">
													<label class="col-md-3 control-label">Documento: <span class="required">
													* </span>
													</label>
													<div class="col-md-3">
														<input type="text" class="form-control" name="documento" id="documento" placeholder="" value="{{ Input::old('documento') }}">

														<!-- mostrar cuando exista error -->
													    @if ($errors->has('documento'))
														    <span class="help-block">{{ $errors->first('documento') }}</span>
													    @endif
													    <!--fin error-->

													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">CUIL: 
													</label>
													<div class="col-md-3">
														<input type="text" class="form-control" name="cuil" id="cuil" placeholder="" value="{{ Input::old('cuil') }}">
													</div>
												</div>
											</div>	
											<div class="col-md-4">
												<div class="row" style="padding: 10px 0">
													<center>
													<div class="fileinput fileinput-new" data-provides="fileinput">
														<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 130px; height: 110px;">
															<img src="{{url('assets/admin/layout/img/sinperfil.png')}}" alt="sin perfil">
														</div>
														<div>
															<span class="btn btn-sm default btn-file">
																<span class="fileinput-new"><i class="fa fa-search"></i> Buscar Foto </span>
																<span class="fileinput-exists"><i class="fa fa-edit"></i> Cambiar </span>
																<input type="file" name="fotoperfil">
															</span>
															<a href="#" class="btn btn-sm red fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash-o"></i> Eliminar </a>
														</div>
													</div>
													</center>
												</div>
												<div class="row">
													<center>
														<label class="control-label" for="alumnoactivo">Activo</label>
														<input type="checkbox" checked  class="form-control" id="alumnoactivo" name="alumnoactivo">
													</center>
												</div>
												<div class="form-group" style="border-bottom: 0">
													<center>
														<button type="button" class="btn btn-sm grey-cascade"><i class="fa fa-print"></i> Credencial</button>
													</center>	
												</div>							
											</div>
											</div> <!-- row -->
												<div class="form-group">
													<label class="col-md-2 control-label">Sexo: <span class="required">
													* </span>
													</label>
													<div class="col-md-6">
														<select name="sexo" id="sexo" class="table-group-action-input form-control input-medium">
															<option value="Masculino">Masculino</option>
															<option value="Femenino">Femenino</option>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-2 control-label">Estado Civil:	</label>
													<div class="col-md-6">
														{{ Form::select('estadocivil', $arrEstadoCivil, Input::old('estadocivil'), array('class'=>'table-group-action-input form-control input-medium')); }}
													</div>
												</div>
												<div id="divavisofechanac" class="form-group <?php if ($errors->has('fechanacimiento')) echo 'has-error' ?>">
													<label class="col-md-2 control-label">Fecha Nacimiento: <span class="required">
													* </span>
													</label>
													<div class="col-md-2">
														<div class="input-icon right">
															<i class="fa fa-exclamation tooltips iconoerror" style="display:none" data-original-title="Fecha incorrecta." data-container="body"></i>
															<input type="text" class="form-control" name="fechanacimiento" id="fechanacimiento" placeholder="" value="{{ Input::old('fechanacimiento') }}">

															<!-- mostrar cuando exista error -->
													    	@if ($errors->has('fechanacimiento'))
														    	<span class="help-block">{{ $errors->first('fechanacimiento') }}</span>
													    	@endif
													    	<!--fin error-->
													    </div>	

													</div>
												</div>
												<div class="form-group">
													<label class="col-md-2 control-label">Edad:</label>
													<div class="col-md-1">
														<input type="text" class="form-control" readonly name="edad" id="edad" value="{{ Input::old('edad') }}">
													</div>
												</div>												
												<div class="form-group">
													<label class="col-md-2 control-label <?php if ($errors->has('fechaingreso')) echo 'text-danger' ?>">Fecha Ingreso:<span class="required">
													* </span></label>
													<div id="divavisofechaing" class="col-md-2 <?php if ($errors->has('fechaingreso')) echo 'has-error' ?>">
														<div class="input-icon right">
															<i class="fa fa-exclamation tooltips iconoerrorfechaing" style="display:none" data-original-title="Fecha Incorrecta." data-container="body"></i>
															<input type="text" class="form-control" name="fechaingreso" id="fechaingreso" placeholder="" value="{{ Input::old('fechaingreso') }}">

															<!-- mostrar cuando exista error -->
													    	@if ($errors->has('fechaingreso'))
														    	<span class="help-block">{{ $errors->first('fechaingreso') }}</span>
													    	@endif
													    	<!--fin error-->
														</div>
													</div>
													<label class="col-md-2 control-label">Fecha Egreso:</label>
													<div class="col-md-2">
														<input type="text" class="form-control" name="fechaegreso" id="fechaegreso" placeholder="" value="{{ Input::old('fechaegreso') }}">
													</div>													
												</div>

												<div class="form-group">
													<label class="col-md-2 control-label">Lugar Nac.:</label>
													<div class="col-md-6">
														{{ Form::select('paisnacimiento', $arrPais, Input::old('paisnacimiento'), array('class'=>'table-group-action-input form-control input-medium')); }}
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
																<label class="col-md-2 control-label">Pa&iacute;s:</label>
																<!--<div class="col-md-1">
																	<input type="text" class="form-control" name="codigopais" >
																</div>-->
																<div class="col-md-6">
																	{{ Form::select('pais', $arrPais, Input::old('pais'), array('class'=>'table-group-action-input form-control input-medium', 'id'=>'pais')); }}
																</div>
															</div>

															<div class="form-group">
																<label class="col-md-2 control-label">Provincia:</label>
																<!--<div class="col-md-1">
																	<input type="text" class="form-control" name="codigoprovincia">
																</div>-->
																<div class="col-md-6">
																	{{ Form::select('provincia', $arrProvincia, Input::old('provincia'), array('class'=>'table-group-action-input form-control input-medium','id'=>'provincia')); }}
																</div>
															</div>

															<div class="form-group">
																<label class="col-md-2 control-label">Departamento:	</label>
																<!--<div class="col-md-1">
																	<input type="text" class="form-control" name="codigodepartamento">
																</div>-->
																<div class="col-md-6">
																	{{ Form::select('departamento', $arrDepartamento, Input::old('departamento'), array('class'=>'table-group-action-input form-control input-medium','id'=>'departamento')); }}
																</div>
															</div>


															<div class="form-group">
																<label class="col-md-2 control-label">Localidad:</label>
																<!--<div class="col-md-1">
																	<input type="text" class="form-control" name="codigolocalidad">
																</div>-->
																<div class="col-md-6">
																	{{ Form::select('localidad', $arrLocalidad, Input::old('localidad'), array('class'=>'table-group-action-input form-control input-medium' ,'id'=>'localidad')); }}
																</div>
															</div>


															<div class="form-group">
																<label class="col-md-2 control-label">Barrio:</label>
																<div class="col-md-6">
																	<input type="text" class="form-control" name="txt_barrio" Input::old('txt_barrio')>
																</div>
																<!--<div class="col-md-6">
																	{{ Form::select('barrio', $arrBarrio, Input::old('barrio'), array('class'=>'table-group-action-input form-control input-medium','id'=>'barrio')); }}
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
																<label class="col-md-2 control-label">Código Postal:
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
																			 <center>Acción</center>
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
										<div class="tab-pane" id="tab_familia">

										</div>
										<div class="tab-pane" id="tab_legajos">
										</div>
									</div>
								</div>
												</div>
					</div>
					{{ Form::close() }}
					<!-- FIN DE LA TABLA-->
				</div>
			</div>
			<!-- FIN DEL CONTENIDO -->
		</div>
	</div>
	<!-- FIN -->

	<!-- MODAL DESACTIVAR ACTIVO-->
	<div class="modal fade" id="modalDesactivarAlumno" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Desactivar Alumno</h4>
					</div>
					<div class="modal-body">
					<p>¿Estas seguro de cambiar el estado del Alumno?</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn red" id="btnDesactivarAlumno"><i class="fa fa-check"></i> Desactivar</button>
						<button type="button" class="btn default" id="btnCancelarAlumno"><i class="fa fa-times-circle-o"></i> Cancelar</button>
					</div>
				</div>
				<!-- /.modal-contenido -->
			</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
	<!-- FIN DEL MODAL FORM-->

	


	<!-- MODAL DESACTIVAR ACTIVO-->
	<div class="modal fade" id="modalEliminaDoc" tabindex="-3" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		{{ Form::open(array('url' => 'alumnos/borrardocumento')) }}
			<input id="idDocumentoHidden" name='idDocumentoHidden' type="hidden" value="">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Eliminar Documento</h4>
					</div>
					<div class="modal-body">
					<p>¿Estas seguro de querer eliminar este documento?</p>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn red" id="btnEliminarDoc"><i class="fa fa-trash-o"></i> Elminar</button>
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
	//valido si viene vacio
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
	$('#FormAlumnos').append('<input id="'+ idaleatorio +'" name="contactos[]" type="hidden" value="'+ $('#cboContacto').val() +'|'+ $('#contactodescripcion').val() +'">');
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

$('#alumnoactivo').change(function(){
    var checkeado = $(this).attr("checked");
    if(!checkeado) {
    	$(this).prop("checked",true);
        $('#modalDesactivarAlumno').modal('show');
    }
});

$('#btnDesactivarAlumno').on('click', function(e){
	e.preventDefault();
	$("#alumnoactivo").prop("checked", false );
	$("#alumnoactivo").parent().removeClass("checked");
	$('#modalDesactivarAlumno').modal('hide');
});

$('#btnCancelarAlumno').on('click', function(e){
	e.preventDefault();
	$("#alumnoactivo").prop("checked", true );
	$("#alumnoactivo").parent().addClass("checked");	
	$('#modalDesactivarAlumno').modal('hide');
})


$('#fechanacimiento').on('keyup', function(){
	$('#edad').val(calcular_edad( $(this).val()));
})

//--LEGAJOS
$('.vistaprevia').live('click', function(){
	var $arrid = $(this).parent().attr('id').split('_'); 
	$('#imgvistaprevia').attr('src', $('#doc_'+$arrid[1]).val());  
});

$('.btnEliminarDoc').live('click', function(e){
	e.preventDefault();
	$('#idDocumentoHidden').val($(this).data('id'));
	$('#modalEliminaDoc').modal('show');
})
//--


	//Comprobacion de fecha de nacimiento
	$('#fechanacimiento').on('focusout', function(){
		var fecha = $('#fechanacimiento');
		var divaviso = $('#divavisofechanac');
		var iconoerror = $('.iconoerror');
		if (!validaFechaDDMMAAAA(fecha.val()) || validarFechaMayorActual(fecha.val()) ){
			divaviso.addClass('has-error');
			iconoerror.show();
			$('button[type="submit"]').attr('disabled','disabled');	
		}
		else
		{
			divaviso.removeClass('has-error');
			iconoerror.hide();
			$('button[type="submit"]').removeAttr('disabled');
		}
	});	

	//Comprobacion de fecha de ingreso
	$('#fechaingreso').on('focusout', function(){
		var fecha = $('#fechaingreso');
		var divaviso = $('#divavisofechaing');
		var iconoerror = $('.iconoerrorfechaing');
		if (!validaFechaDDMMAAAA(fecha.val()) || validarFechaMayorActual(fecha.val()) ){
			divaviso.addClass('has-error');
			iconoerror.show();
			$('button[type="submit"]').attr('disabled','disabled');	
		}
		else
		{
			divaviso.removeClass('has-error');
			iconoerror.hide();
			$('button[type="submit"]').removeAttr('disabled');
		}
	});

	$('#departamento').combodinamico("{{url('alumnos/localidades/')}}", $('#localidad'));

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
<script src="{{url('assets/admin/pages/scripts/helpers/verificar.fecha.js')}}" type="text/javascript"></script>
<script src="{{url('assets/admin/pages/scripts/helpers/jquery.combodinamico.js')}}" type="text/javascript"></script>

<!-- END PAGE LEVEL PLUGINS -->
@stop
