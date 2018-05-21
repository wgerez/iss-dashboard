@extends('layouts.master')

@section('customstyle')
	<!--link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css')}}"/-->
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/bootstrap-summernote/summernote.css')}}">
	<style>
	.fixed {
	    position:fixed;
	    top: 60px;
	    right: 20px;
	    z-index: 999
	}
	</style>
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
					Contratos <small>editar contratos {{$disabled}}</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">Contratos</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">editar</a>
						</li>
					</ul>
				</div>
			</div>
			<!-- FIN DE HEADER-->
			<!-- COMIENZO DEL CONTENIDO-->

			<div class="row">
				<div class="col-md-12">
					<!-- PARA MOSTRAR ALERTAS - ERRORES - INFORMACIÓN ETC. USAREMOS ESTE DIV. DEPENDIENDO DEL TIPO (note-danger=rojo - note-info=celeste - note-warning=rojo - note-success=verde) USAR DISPLAY:NONE  -->
					@if (Session::has('message'))
					    @if (Session::get('message_type') == TiposContratosController::OPERACION_EXITOSA)

							<div class="note note-success">
								<p> {{ Session::get('message') }} </p>
							</div>

						@elseif (Session::get('message_type') == TiposContratosController::OPERACION_FALLIDA)

							<div class="note note-danger">
								<p> {{ Session::get('message') }} </p>
							</div>

						@endif	
					@endif
					<!-- COMIENZO DE LA TABLA-->
					{{ Form::open(array('url'=>'tiposcontratos/update' , 'class'=>'form-horizontal form-row-seperated', 'id'=>'FormContratos'))}}

					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-edit"></i> Editar Contrato
							</div>
							<div class="actions">
								<button {{$disabled}} type='submit' class="btn default green-stripe">
								<i class="fa fa-save"></i>
								<span class="hidden-480">
								Guardar </span>
								</button>
							</div>

						</div>
						<div class="portlet-body">
								<div class="tabbable-custom">
									<ul class="nav nav-tabs">
										<li class='active' id='tab_mayor_edad'>
											<a href="#tab_mayor_18" data-toggle="tab">
											Mayor de Edad (+18) </a>
										</li>
										<li id='tab_menor_edad'>
											<a href="#tab_menor" data-toggle="tab">
											Menor de Edad (-18) </a>
										</li>
									</ul>

									<div class="tab-content no-space">
										<div class="tab-pane active" id="tab_mayor_18">
											<div class="form-body">
												<div class="form-group">
													<label class="col-md-3 control-label">
														Encabezado:
													</label>
													<div class="col-md-6">
														<input type="text" class="form-control" name="txtTituloMayorEdad" value="{{$contratos[0]->titulo}}">
													</div>

													<div class="col-md-3">
														<button type='button' id='btnVistaPrevia_1' class="btn default yellow-stripe">
														    <i class="fa fa-file-pdf-o"></i>
														    <span class="hidden-480">
														        Vista Previa
														    </span>
														</button>
													</div>

													<br><br><br>
													<div class="col-md-12">
														<textarea name='txtContratoMayorEdad' id="contrato_1" class="form-control" rows="20">
															{{$contratos[0]->clausulas}}
														</textarea>
													</div>
												</div>
											</div>
										</div>
										<div class="tab-pane" id="tab_menor">
											<div class="form-body">
												<div class="form-group">
													<label class="col-md-3 control-label">
														Encabezado:
													</label>
													<div class="col-md-6">
														<input type="text" class="form-control" name="txtTituloMenorEdad" value="{{$contratos[1]->titulo}}">
													</div>
													<div class="col-md-3">
														<button type='button' id='btnVistaPrevia_2' class="btn default yellow-stripe">
														    <i class="fa fa-file-pdf-o"></i>
														    <span class="hidden-480">
														        Vista Previa
														    </span>
														</button>
													</div>
													<br><br><br>
													<div class="col-md-12">
														<textarea name='txtContratoMenorEdad' id="contrato_2" class="form-control" rows="20">
															{{$contratos[1]->clausulas}}
														</textarea>
													</div>
												</div>
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
		</div>
	</div>
	<!-- FIN -->
@stop

@section('customjs')
	ComponentsEditors.init();
	//Emular Tab al presionar Enter
	$('input').keydown( function(e) {
	        var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
	        if(key == 13) {
	            e.preventDefault();
	            var inputs = $(this).closest('form').find(':input:visible');
	            inputs.eq( inputs.index(this)+ 1 ).focus();
	        }
	 });

	$('#btnVistaPrevia_1').on('click', function(e){
		window.open("{{url('tiposcontratos/pdfcontrato/1')}}");
	});

	$('#btnVistaPrevia_2').on('click', function(e){
		window.open("{{url('tiposcontratos/pdfcontrato/2')}}");
	});
@stop


@section('includejs') 
	<!--script type="text/javascript" src="{{url('assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js')}}"></script-->
	<script src="{{url('assets/global/plugins/bootstrap-summernote/summernote.min.js')}}" type="text/javascript"></script>
	<script src="{{url('assets/global/plugins/bootstrap-summernote/lang/summernote-es-ES.js')}}" type="text/javascript"></script>
	<script src="{{url('assets/admin/pages/scripts/components-editors.js')}}"></script>
@stop
