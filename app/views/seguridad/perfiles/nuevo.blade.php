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
?>
@section('content')
	<!-- COMIENZO CONTENIDO -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- COMIENZO DEL HEADER-->
			<?php

			    if (isset($perfiles)):
			        $perfil = $perfiles->perfil;
					$descripcion = $perfiles->descripcion;
			        $action    = 'Editar';
			    else:
			        $action    = 'Nuevo';        
			    endif;

			?>
			<div class="row">
				<div class="col-md-12">
					<!-- COMIENZO TITULO & BREADCRUMB--> 
					<h3 class="page-title">
					Perfil <small>{{ $action }} perfil</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('perfiles/listado')}}">Perfiles</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">{{ $action }}</a>
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
					    @if (Session::get('message_type') == PerfilesController::OPERACION_EXITOSA)

							<div class="note note-success">
								<p> {{ Session::get('message') }} </p>
							</div>
						@elseif (Session::get('message_type') == PerfilesController::OPERACION_FALLIDA)

							<div class="note note-danger">
								<p> {{ Session::get('message') }} </p>
							</div>

						@endif	
					@endif
					<!-- COMIENZO DE LA TABLA-->
					@if(isset($perfiles))
					    {{ Form::open(array('url'=>'perfiles/updateperfil', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmPerfil', 'name'=>'FrmPerfil'))}}
						<input type="hidden" value="{{$perfiles->id}}" name="perfilid" id="perfilid">
					@else
					    {{ Form::open(array('url'=>'perfiles/guardar', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmPerfil', 'name'=>'FrmPerfil'))}}
					    {{ $perfil = Input::old('perfil') }}
					    {{ $descripcion = Input::old('descripcion') }}
					@endif
					
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-group"></i> Perfil
							</div>
							<div class="actions">
								<button {{ $disabled }} type='submit' class="btn default green-stripe">
								<i class="fa fa-save"></i>
								<span class="hidden-480">
								Guardar </span>
								</button>
								<a href="{{url('perfiles/listado')}}" class="btn default yellow-stripe">
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
											{{ Form::select('organizacion', $organizaciones, Input::old('organizacion'), array('class'=>'table-group-action-input form-control','id'=>'organizacion', $disabled)); }}
										</div>
									</div>

									<div class="form-group <?php if ($errors->has('perfil')) echo 'has-error' ?>">
										<label  class="col-md-2 col-sm-2 control-label">Perfil:</label>
										<div class="col-md-6 col-sm-10">
											<input {{ $readonly }} type="text" name="txtperfil" id="txtperfil" placeholder="ej.: Administrativo o Asistente Contable" class="form-control" value="{{ $perfil }}">
											<!-- mostrar cuando exista error -->
										    @if ($errors->has('perfil'))
											    <span class="help-block">{{ $errors->first('perfil') }}</span>
										    @endif
										    <!--fin error-->
										</div>
									</div>
									<div class="form-group">
										<label  class="col-md-2 col-sm-2 control-label">Descripción:</label>
										<div class="col-md-6 col-sm-10">
											<textarea {{ $readonly }} name="txtdescripcion" id="txtdescripcion" cols="30" rows="7" class="form-control" value="{{ $descripcion }}">{{ $descripcion }}</textarea>
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
@stop

@section('includejs') 
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{url('assets/global/plugins/select2/select2.min.js')}}"></script>
<script src="{{url('assets/admin/layout/scripts/menusticky.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
@stop
