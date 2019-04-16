@extends('layouts.master')

@section('customstyle')
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/select2/select2.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/jquery-multi-select/css/multi-select.css')}}"/>
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

<?php
//BOTONES Y CAMPOS DE PERMISOS
$disabled = (!$editar) ? 'disabled' : '';
$readonly = (!$editar) ? 'readonly' : '';
$imprimir = (!$imprimir) ? 'disabled' : '';

	$apellido = (trim(Input::old('apellido') == false)) ? $user->Persona['apellido'] : Input::old('apellido');
	$nombre = (trim(Input::old('nombre') == false)) ? $user->Persona['nombre'] : Input::old('nombre');
	$tipodni = (trim(Input::old('tipodocumento') == false)) ? $user->Persona['tipodocumento_id'] : Input::old('tipodocumento');
	$nroDocumento = (trim(Input::old('txtdocumento') == false)) ? $user->Persona['nrodocumento'] : Input::old('txtdocumento');
	$usuario = (trim(Input::old('txtusuario') == false)) ? $user->usuario : Input::old('txtusuario');
	$correo = (trim(Input::old('txtcorreo') == false)) ? $user->email : Input::old('txtcorreo');
	$organizacion = (trim(Input::old('organizaciones') == false)) ? $user->organizaciones->first()->id : Input::old('organizaciones');
	/*highlight_string(var_export($user->Persona['foto'], true));
	exit();*/

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
					Usuario <small>editar usuario</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('usuarios/listado')}}">Usuarios</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">Editar</a>
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
					    @if (Session::get('message_type') == UsersController::OPERACION_EXITOSA)

							<div class="note note-success">
								<p> {{ Session::get('message') }} </p>
							</div>
						@elseif (Session::get('message_type') == UsersController::OPERACION_FALLIDA)

							<div class="note note-danger">
								<p> {{ Session::get('message') }} </p>
							</div>

						@endif	
					@endif
					
					<!-- COMIENZO DE LA TABLA-->
					{{ Form::open(array('url'=>'usuarios/update', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmUsuario', 'name'=>'FrmUsuario'))}}

					{{ Form::hidden('userid', $user->id) }}
					{{ Form::hidden('idpersona', $user->Persona['id']) }}	

					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-user"></i> Usuario
							</div>
							<div class="actions">
								<button {{$disabled}} type='submit' class="btn default green-stripe">
								<i class="fa fa-save"></i>
								<span class="hidden-480">
								Guardar </span>
								</button>
								<a href="{{url('usuarios/listado')}}" class="btn default yellow-stripe">
								<i class="fa fa-reorder"></i>
								<span class="hidden-480">
								Listado </span>
								</a>
							</div>

						</div>
						<div class="portlet-body form">
								<div class="form-body">

									<ul class="nav nav-tabs">
										<li class="active">
											<a href="#">
											Datos </a>
										</li>
										<li>
											<a {{$disabled}} href="{{url('usuarios/asignaperfil/'.$user->id)}}" >
											Asignar Perfil </a>
										</li>
									</ul>


									<div class="row">
										<div class="col-md-8">
											<div class="form-group">

												<div class="<?php if ($errors->has('apellido')) echo 'has-error' ?>">
													<label  class="col-md-2 col-sm-2 control-label">Apellido:</label>
													<div class="col-md-4 col-sm-4">
														<input {{$readonly}} type="text" class="form-control" name="txtapellido" id="txtapellido" value="{{$apellido}}">
														@if ($errors->has('apellido'))
														   	<span class="help-block">{{ $errors->first('apellido') }}</span>
														@endif
													</div>
												</div>
											</div>
											
											<div class="form-group">
												<div class="<?php if ($errors->has('nombre')) echo 'has-error' ?>">
													<label  class="col-md-2 col-sm-2 control-label">Nombre/s:</label>
													<div class="col-md-4 col-sm-4">
														<input {{$readonly}} type="text" class="form-control" name="txtnombre" id="txtnombre" value="{{$nombre}}" >
														@if ($errors->has('nombre'))
														   	<span class="help-block">{{ $errors->first('nombre') }}</span>
														@endif
													</div>
												</div>
											</div>

											<div class="form-group">
												<label  class="col-md-2 col-sm-2 control-label">Tipo Documento:</label>
												<div class="col-md-2 col-sm-2">
													{{ Form::select('tipodocumento', $tipodocumento, $tipodni, array('class'=>'table-group-action-input form-control','id'=>'tipodocumento', $disabled)); }}
												</div>
												<div id="divavisodni" class="<?php if ($errors->has('nrodocumento')) echo 'has-error' ?>">
													<label  class="col-md-2 col-sm-2 control-label">N° Documento:</label>
													<div class="col-md-4 col-sm-4">
														<div class="input-icon right">
															<i class="fa fa-exclamation tooltips iconoerror" style="display:none" data-original-title="El documento ya está registrado." data-container="body"></i>
															<input {{$readonly}} type="text" class="form-control" autocomplete="off" name="txtdocumento" id="txtdocumento" value="{{$nroDocumento}}">
															@if ($errors->has('nrodocumento'))
														   		<span class="help-block">{{ $errors->first('nrodocumento') }}</span>
															@endif
														</div>	
													</div>
												</div>
											</div>
										</div>

										<div class="col-md-4">
											<div class="row" style="padding: 10px 0">
												<center>
												<div class="fileinput fileinput-new" data-provides="fileinput">
													<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 130px; height: 110px;">
														@if ($user->Persona['foto'])
														    <img src="{{url('alumnos/img-perfil')}}/{{$user->Persona['foto']}}" alt="sin perfil">
														@else
														    <img src="{{url('assets/admin/layout/img/sinperfil.png')}}" alt="sin perfil">
														@endif
													</div>
													<div>
														<span class="btn btn-sm default btn-file">
															<span class="fileinput-new"><i class="fa fa-search"></i> Buscar Foto </span>
															<span class="fileinput-exists"><i class="fa fa-edit"></i> Cambiar </span>
															<input {{$disabled}} type="file" name="fotoperfil">
														</span>
														<a href="#" class="btn btn-sm red fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash-o"></i> Eliminar </a>
													</div>
												</div>	
												</center>				
											</div>
										</div>
									</div> <!-- row -->	

									<div class="form-group">
										<div id="divavisousuario" class="<?php if ($errors->has('usuario')) echo 'has-error' ?>">
											<label  class="col-md-2 col-sm-2 control-label">Usuario:</label>
											<div class="col-md-3 col-sm-3">
												<div class="input-icon right">
													<i class="fa fa-check tooltips" style="display:none" data-original-title="Usuario disponible." data-container="body"></i>
													<i class="fa fa-exclamation tooltips" style="display:none" data-original-title="Usuario no disponible." data-container="body"></i>											
													<input {{$readonly}} type="text" class="form-control" name="txtusuario" autocomplete="off" id="txtusuario" value="{{$usuario}}">
													@if ($errors->has('usuario'))
													   	<span class="help-block">{{ $errors->first('usuario') }}</span>
													@endif
												</div>	
											</div>
										</div>
										<label class="col-md-5 col-sm-5 control-label" for="cicloactivo">Activo
											<div class="checker {{$disabled}}">
												<span class="<?php if ($user->activo) echo 'checked'; ?>">
													<input type="checkbox" class="form-control" id="usuarioactivo" name="usuarioactivo" <?php if ($user->activo) echo 'CHECKED'; ?> value="1">
												</span>
											</div>
										</label>										
									</div>
									<div class="form-group <?php if ($errors->has('password')) echo 'has-error' ?>">
										<label  class="col-md-2 col-sm-2 control-label">Contraseña:</label>
										<div class="col-md-3 col-sm-3">
											<input {{$readonly}} type="password" class="form-control" name="txtpass" id="txtpass">
											@if ($errors->has('password'))
											   	<span class="help-block">{{ $errors->first('password') }}</span>
											@else
												<span class="help-block">Mínimo 6 caracteres.</span>
											@endif
										</div>

										<div class="<?php if ($errors->has('email')) echo 'has-error' ?>">
											<label  class="col-md-2 col-sm-2 control-label">E-mail:</label>
											<div class="col-md-3 col-sm-3">
												<input {{$readonly}} type="text" class="form-control" name="txtcorreo" id="txtcorreo" value="{{$correo}}">
												@if ($errors->has('email'))
												   	<span class="help-block">{{ $errors->first('email') }}</span>
												@endif
											</div>
										</div>
									</div>									
									<div class="form-group">
										<label class="control-label col-md-2 col-sm-2">Organizaciones:</label>
										<div class="col-md-6 col-sm-6">
											{{ Form::select('organizaciones', $organizaciones, $organizacion, array('class'=>'table-group-action-input form-control multi-select','id'=>'organizaciones', $disabled)); }}
										</div>
									</div>									
								</div>
						</div> <!-- FIN PORTLET-BODY -->
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
ComponentsFormTools.init();

	//$('#organizaciones').multiSelect();

	//Emular Tab al presionar Enter
	$('input').keydown( function(e) {
	        var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
	        if(key == 13) {
	            e.preventDefault();
	            var inputs = $(this).closest('form').find(':input:visible');
	            inputs.eq( inputs.index(this)+ 1 ).focus();
	        }
	 });

	//Comprobacion de usuario disponible
	$('#txtusuario').on('keyup', function(){
		if ( $(this).val().length < 1 || $(this).val() == '<?php echo $usuario; ?>'){
				$('#divavisousuario').removeClass('has-success', 'has-error');
				$('.fa-exclamation').hide();
				$('.fa-check').hide();
				$(this).removeClass('spinner');	
		}else{
			$.ajax({
			  	url: "{{url('usuarios/compruebausuario')}}",
			  	data:{'usuario': $('#txtusuario').val()},
			  	type: 'POST',
				beforeSend: function(){
					$('#divavisousuario').removeClass('has-success, has-error');
					$('.fa-exclamation').hide();
					$('.fa-check').hide();
	     			$('#txtusuario').addClass('spinner');	
	   			}		  
			}).done(function(datos) {
				$('#txtusuario').removeClass('spinner');
				if (datos.usuario){
					$('#divavisousuario').removeClass('has-success');
					$('#divavisousuario').addClass('has-error');
					$('.fa-check').hide();
					$('.fa-exclamation').show();
					$('button[type="submit"]').attr('disabled','disabled');
				}else{
					$('#divavisousuario').removeClass('has-error');
					$('#divavisousuario').addClass('has-success');
					$('.fa-check').show();
					$('.fa-exclamation').hide();
					$('button[type="submit"]').removeAttr('disabled');
				}
			}).error(function(data) {
				console.log(data);
			});
		}
	});

	//Comprobacion documento disponible
	$('#txtdocumento').on('keyup', function(){
		var doc = $('#txtdocumento');
		var divaviso = $('#divavisodni');
		var iconoerror = $('.iconoerror');
		if ($(this).val().length < 1 || $(this).val() == '<?php echo $nroDocumento; ?>'){
				divaviso.removeClass('has-error');
				iconoerror.hide();
				$(this).removeClass('spinner');	
		}else{
			$.ajax({
			  	url: "{{url('usuarios/compruebadni')}}",
			  	data:{'documento': doc.val()},
			  	type: 'POST',
				beforeSend: function(){
					divaviso.removeClass('has-error');
					iconoerror.hide();
	     			doc.addClass('spinner');	
	   			}		  
			}).done(function(datos) {
				doc.removeClass('spinner');
				if (datos.documento){
					divaviso.addClass('has-error');
					iconoerror.show();
					$('button[type="submit"]').attr('disabled','disabled');

				}else{
					divaviso.removeClass('has-error');
					iconoerror.hide();
					$('button[type="submit"]').removeAttr('disabled');
				}
			}).error(function(data) {
				console.log(data);
			});
		}
	});	

<?php if ($disabled!='disabled' && Auth::user()->id != $user->id) { ?>
	$('#usuarioactivo').change(function(){
	    var checkeado = $(this).attr("checked");
	    if(checkeado) {
	    	$(this).prop("checked",true);
	    	$(this).parent().addClass("checked");
	    }
	    else
	    {
	    	$(this).prop("checked",false);
	    	$(this).parent().removeClass("checked");
	    }
	});
<?php } ?>
@stop

@section('includejs') 
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{url('assets/global/plugins/select2/select2.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js')}}"></script>
<script type="text/javascript" src="{{url('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js')}}"></script>
<script src="{{url('assets/admin/layout/scripts/menusticky.js')}}" type="text/javascript"></script>

<script type="text/javascript" src="{{url('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
<script type="text/javascript" src="{{url('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{url('assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js')}}" type="text/javascript"></script>
<script src="{{url('assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{url('assets/global/plugins/fancybox/source/jquery.fancybox.pack.js')}}"></script>
<script src="{{url('assets/global/plugins/plupload/js/plupload.full.min.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{url('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}"></script>

<script src="{{url('assets/admin/pages/scripts/components-form-tools.js')}}"></script>
<!-- END PAGE LEVEL PLUGINS -->
@stop
