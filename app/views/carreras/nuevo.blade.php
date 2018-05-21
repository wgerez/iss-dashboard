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

@section('content')
	<!-- COMIENZO CONTENIDO -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- COMIENZO DEL HEADER-->

			<div class="row">
				<div class="col-md-12">
					<!-- COMIENZO TITULO & BREADCRUMB--> 
					<h3 class="page-title">
					Carrera <small>nueva carrera</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('carreras/listado')}}">Carreras</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">Nuevo</a>
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
					    @if (Session::get('message_type') == CarrerasController::OPERACION_EXITOSA)

							<div class="note note-success">
								<p> {{ Session::get('message') }} </p>
							</div>
						@elseif (Session::get('message_type') == CarrerasController::OPERACION_FALLIDA)

							<div class="note note-danger">
								<p> {{ Session::get('message') }} </p>
							</div>

						@endif	
					@endif
					<!-- COMIENZO DE LA TABLA-->
					{{ Form::open(array('url'=>'carreras/guardar', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmCarrera', 'name'=>'FrmCarrera'))}}
					
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-files-o"></i> Carrera
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
						<div class="portlet-body form">
								<div class="form-body">

									<div class="form-group">
										<label  class="col-md-2 col-sm-2 control-label">Organización:</label>
										<div class="col-md-6 col-sm-10">
											{{ Form::select('organizacion', $arrOrganizaciones, Input::old('organizacion'), array('class'=>'table-group-action-input form-control','id'=>'organizacion')); }}
										</div>
									</div>

									<div class="form-group">
										<!--<label class="col-md-2 col-sm-2 control-label" for="idcarrera">ID Carrera</label>
										<div class="col-md-1 col-sm-2">
											<input type="text" class="form-control" id="idcarrera" name="idcarrera" value="" >
										</div> !-->
										<label class="col-md-2 col-sm-2 control-label" for="carreraactiva">
											<input type="checkbox" class="form-control" id="carreraactiva" name="carreraactiva" checked> Activo
										</label>
									</div>

									<div class="form-group <?php if ($errors->has('carrera')) echo 'has-error' ?> ">
										<label class="col-md-2 control-label" for="carrera">Carrera:</label>
										<div class="col-md-6">
											<input type="text" class="form-control" id="carrera" name="carrera" value="" >
											@if ($errors->has('carrera'))
											    <span class="help-block">{{ $errors->first('carrera') }}</span>
										    @endif
										</div>
									</div>
									<div class="form-group <?php if ($errors->has('nroresolucion')) echo 'has-error' ?> ">
										<label class="col-md-2 control-label" for="nroresolucion">Nro. Resolución:</label>
										<div class="col-md-6">
											<input type="text" class="form-control" id="nroresolucion" name="nroresolucion" value="" >
											@if ($errors->has('nroresolucion'))
											    <span class="help-block">{{ $errors->first('nroresolucion') }}</span>
										    @endif
										</div>
									</div>
									<div class="form-group <?php if ($errors->has('carrera')) echo 'has-error' ?> ">
										<label class="col-md-2 control-label" for="carrera">Abreviatura:</label>
										<div class="col-md-6">
											<input type="text" class="form-control" id="abreviatura" name="abreviatura" value="" >
											@if ($errors->has('abreviatura'))
											    <span class="help-block">{{ $errors->first('abreviatura') }}</span>
										    @endif
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-2 control-label" for="nivel">Nivel:</label>
										<div class="col-md-6">
											{{ Form::select('nivel', $arrNivelEducativo, Input::old('nivel'), array('class'=>'table-group-action-input form-control','id'=>'nivel')); }}
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-2 control-label" for="tipocarrera">Tipo de Carrera:</label>
										<div class="col-md-6">
											{{ Form::select('tipocarrera', $tiposCarreras, Input::old('tipocarrera'), array('class'=>'table-group-action-input form-control','id'=>'tipocarrera')); }}
											<!--<select name="tipocarrera" id="tipocarrera" class="table-group-action-input form-control">
												<option value="1">PostGrado</option>
												<option value="2">Pregrado</option>
											</select> !-->
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-2 control-label" for="regimen">Régimen:</label>
										<div class="col-md-6">
											{{ Form::select('regimen', $regimenes, Input::old('regimen'), array('class'=>'table-group-action-input form-control','id'=>'regimen')); }}
											<!--<select name="regimen" id="regimen" class="table-group-action-input form-control">
												<option value="1">Mixto</option>
											</select> !-->
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-2 control-label" for="titulootorga">Título que Otorga:</label>
										<div class="col-md-6">
											{{ Form::select('titulootorga', $titulosOtorgados, Input::old('titulootorga'), array('class'=>'table-group-action-input form-control','id'=>'titulootorga')); }}
											<!--<select name="titulootorga" id="titulootorga" class="table-group-action-input form-control">
												<option value="1">Tec. Sup. en Hemoterapia</option>
												<option value="2">Tec. Sup. en Instrumentación Quirúgica</option>
												<option value="3">Tec. Sup. en Emergentología</option>
												<option value="4">Tec. Sup. en Materno Infantil</option>
											</select> !-->
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-2 control-label" for="duracion">Duración:</label>
										<div class="col-md-2">
											<div id="spinner">
												<div class="input-group input-small">
													<input type="text" name="duracion" id="duracion" class="spinner-input form-control" maxlength="4" readonly>
													<div class="spinner-buttons input-group-btn btn-group-vertical">
														<button type="button" class="btn spinner-up btn-xs grey">
														<i class="fa fa-angle-up"></i>
														</button>
														<button type="button" class="btn spinner-down btn-xs grey">
														<i class="fa fa-angle-down"></i>
														</button>
													</div>
												</div>
											</div>											
										</div>
										<div class="col-md-2">
											{{ Form::select('tipoduracion', $tiposDuraciones, Input::old('tipoduracion'), array('class'=>'table-group-action-input form-control','id'=>'tipoduracion')); }}
											<!---<select name="tipoduracion" id="txtduracion" class="table-group-action-input form-control">
												<option value="1">Años</option>
												<option value="2">Meses</option>
												<option value="3">Días</option>
											</select> !-->
										</div>										
									</div>

									<div class="form-group">
										<label class="col-md-2 control-label" for="modalidad">Modalidad:</label>
										<div class="col-md-6">
											{{ Form::select('modalidad', $modalidades, Input::old('modalidad'), array('class'=>'table-group-action-input form-control','id'=>'modalidad')); }}
											<!--<select name="modalidad" id="modalidad" class="table-group-action-input form-control">
												<option value="1">Presencial</option>
												<option value="2">Semipresencial</option>
											</select> !-->
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-2 control-label" for="cargaHorariaCatedra">Carga horaria total:</label>
										<div class="col-md-2">
											<input type="text" class="form-control" id="cargaHorariaCatedra" name="cargaHorariaCatedra" value="" >
											<div class="help-block">(hs Cátedra)</div>
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-2 control-label" for="cargaHorariaReloj">Carga horaria total:</label>
										<div class="col-md-2">
											<input type="text" class="form-control" id="cargaHorariaReloj" name="cargaHorariaReloj" value="" >
											<div class="help-block">(hs Reloj)</div>
										</div>
									</div>									

									<div class="form-group">
										<label class="col-md-2 control-label" for="areaocupacional">Área ocupacional:</label>
										<div class="col-md-6">
											{{ Form::select('areaocupacional', $areasOcupacionales, Input::old('areaocupacional'), array('class'=>'table-group-action-input form-control','id'=>'areaocupacional')); }}
											<!---<select name="areaocupacional" id="areaocupacional" class="table-group-action-input form-control">
												<option value="1">Sistema salud pública</option>
												<option value="2">Privado</option>
											</select> !-->
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-3 control-label" for="exameningreso">Examen Ingreso
										<input type="checkbox" class="form-control" id="exameningreso" name="exameningreso">
										</label>
									</div>

									<div class="form-group">
										<label class="col-md-2 control-label" for="observacion">Observación</label>
										<div class="col-md-10">
											<textarea rows="5" name="observacion" class="form-control"></textarea>
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
	$('#spinner').spinner({value:1, min: 1, max: 1000});
@stop

@section('includejs') 
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{url('assets/global/plugins/select2/select2.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/global/plugins/fuelux/js/spinner.min.js')}}"></script>
<script src="{{url('assets/admin/layout/scripts/menusticky.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
@stop
