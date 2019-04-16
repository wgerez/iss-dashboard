@extends('layouts.master')

@section('customstyle')
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/select2/select2.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css')}}"/>
@stop
<?php
	(isset($organizacionseleccionada)) ? $orgid = $organizacionseleccionada : $orgid = null;
	(isset($carreraseleccionada)) ? $carrid = $carreraseleccionada : $carrid = null;
	(isset($filtroseleccionado)) ? $filtroseleccionado = $filtroseleccionado : $filtroseleccionado = 1;
	(isset($filtrosexo)) ? $filtrosexo = $filtrosexo : $filtrosexo = 'Masculino';
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
					Informes <small>informe de alumnos por carrera (pdf)</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('informes/alumnos')}}">Informes</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('alumnos/listado')}}">Alumnos</a>
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
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == AlumnosController::OPERACION_FALLIDA)

					        <div class="note note-danger">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == AlumnosController::OPERACION_CANCELADA)

					        <div class="note note-warning">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == AlumnosController::OPERACION_INFO)

					        <div class="note note-info">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@endif
					@endif
					<!-- COMIENZO DE LA TABLA-->
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-users"></i>Informe de Alumnos por Carrera
							</div>
							<!--div class="actions">
								<a href="{{url('alumnos/crear')}}" @if (!$editar) {{'DISABLED'}} @endif class="btn default blue-stripe" >
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Nuevo</span>
								</a>
								<a href="{{url('alumnos/listado')}}" class="btn default yellow-stripe">
								<i class="fa fa-refresh"></i>
								<span class="hidden-480">
								Actualizar </span>
								</a>

							</div -->

						</div>
						<div class="portlet-body">
							<div class="form-body">
								{{ Form::open(array('url'=>'alumnos/informealumnosporcarrera', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmAlumnos', 'name'=>'FrmAlumnos'))}}
								<div class="form-group">
									<label  class="col-md-2 col-sm-2 control-label" for="organizacion">Organización:</label>
									<div class="col-md-6 col-sm-10">
										{{ Form::select('organizacion', $organizaciones, $orgid, array('class'=>'table-group-action-input form-control','id'=>'organizacion')) }}
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 col-sm-2 control-label" for="carrera">Carreras:</label>
									<div class="col-md-6 col-sm-10">
										@if ($carrid!=null)
											{{ Form::select('carrera', Organizacion::find($orgid)->carreras->lists('carrera', 'id'), $carrid, array('class'=>'table-group-action-input form-control','id'=>'carrera')) }}
										@else
											<select class="table-group-action-input form-control" id="carrera" name="carrera">
												<option value="0">Seleccione una carrera</option>
											</select>
										@endif
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label" for="filtro">Filtrar por:</label>
									<div class="col-md-2">
										<select class="table-group-action-input form-control" name="filtro" id="filtro">
											<option @if($filtroseleccionado==1) {{'selected'}} @endif value="1">Todos</option>
											<option @if($filtroseleccionado==2) {{'selected'}} @endif value="2">Apellido y Nombre</option>
											<option @if($filtroseleccionado==4) {{'selected'}} @endif value="4">Sexo</option>
											<option @if($filtroseleccionado==5) {{'selected'}} @endif value="5">Localidad</option>
										</select>
									</div>
									<div id="divdescripcion" class="col-md-3" @if($filtroseleccionado!=5) style="display: none" @endif>
										<input type="text" class="form-control" name="filtrolocalidad" id="filtrolocalidad" value="@if (isset($filtrolocalidad)) {{$filtrolocalidad}} @endif">
									</div>
									<div id="divapellido" class="col-md-2" @if($filtroseleccionado!=2) style="display: none" @endif>
										<input type="text" class="form-control" name="filtroapellido" id="filtroapellido" value="@if (isset($filtroapellido)) {{$filtroapellido}} @endif">
									</div>									
									<div id="divnombre" class="col-md-2" @if($filtroseleccionado!=2) style="display: none" @endif>
										<input type="text" class="form-control" name="filtronombre" id="filtronombre" value="@if (isset($filtronombre)) {{$filtronombre}} @endif">
									</div>
									<div id="divsexo" class="col-md-2" @if($filtroseleccionado!=4) style="display: none" @endif >
										<select name="filtrosexo" id="filtrosexo" class="table-group-action-input form-control">
											<option @if ($filtrosexo=='Masculino') selected @endif value="1">Masculino</option>
											<option @if ($filtrosexo=='Femenino') selected @endif value="2">Femenino</option>
										</select>
									</div>									
									<div class="col-md-2 col-sm-2">
										<button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> Buscar</button>
									</div>
									@if (isset($orgid))
										<div id="divbtnImprimir" class="col-md-2 col-sm-2">
											<a target="_blank" href="#" id="imprimir" class="btn btn-success"><i class="fa fa-print"></i> Imprimir</a>
										</div>
									@endif	
								</div>
								{{ Form::close() }}
								<br>
								<table class="table table-striped table-bordered table-hover" id="table_informes_alumnos">
									<thead>
										<tr>
											<th class="hidden-xs">
												<center><i class="glyphicon glyphicon-list-alt"></i> Código</center>
											</th>
											<th>
												 <center><i class="fa fa-tags"></i> Apellido y Nombre</center>
											</th>
											<th>
												 <center><i class="fa fa-list-ol"></i> DNI</center>
											</th>
											<th>
												 <center><i class="fa fa-female"></i></i> Sexo</center>
											</th>
											<th>
												 <center><i class="fa fa-language"></i> Dirección</center>
											</th>
											<th>
												 <center><i class="fa fa-language"></i> Localidad</center>
											</th>
											<th>
												 <center><i class="fa fa-phone"></i> Teléfono</center>
											</th>
											<th>
												 <center><i class="fa fa-envelope"></i> E-mail</center>
											</th>								
										</tr>
									</thead>
									<tbody>

										@if (isset($alumnos))
											@foreach ($alumnos as $alumno)
												<!-- RESCATO EL TELEFONO Y EL CORREO -->
												<?php $particular = 'No cargado'; ?>
												<?php $laboral  = 'No Cargado'; ?>
												<?php $correo   = 'No cargado'; ?>
												@foreach ($alumno->persona->contactos as $contacto)
													@if ($contacto->id==1)
														<?php $particular = $contacto->pivot->descripcion; ?>
													@elseif ($contacto->id==2)
														<?php $laboral = $contacto->pivot->descripcion; ?>
													@elseif($contacto->id==3)
														<?php $correo = $contacto->pivot->descripcion; ?>
													@endif
												@endforeach
												@if ($filtroseleccionado==1)
												<tr>
													<td><center>{{$alumno->persona['id']}}</center></td>
													<td>{{$alumno->persona['apellido'].", ". $alumno->persona['nombre']}}</td>
													<td>{{$alumno->persona['nrodocumento']}}</td>
													<td>{{$alumno->persona['sexo']}}</td>
													<td>
														@if (empty($alumno->persona['barrio']) or ($alumno->persona['barrio']==null)) 
															{{'B° no cargado -'}} 
														@else 
															{{$alumno->persona['barrio']. ' -'}}
														@endif
														@if (empty($alumno->persona['calle']) or ($alumno->persona['calle']==null)) 
															{{'Calle no cargado'}} 
														@else 
															{{$alumno->persona['calle']}} 
														@endif 
														@if ($alumno->persona['numero']==0) 
															{{'s/n'}} 
														@else 
															{{$alumno->persona['numero']}} 
														@endif
														@if ($alumno->persona['manzana']==0) 
															{{''}} 
														@else 
															{{', Mz: '. $alumno->persona['manzana']}} 
														@endif
														@if ($alumno->persona['departamento']==0) 
															{{''}} 
														@else 
															{{', Dpto: '. $alumno->persona['departamento']}} 
														@endif
													</td>
													<td>{{$alumno->persona->localidad['descripcion']}}</td>
													<td>@if ($particular!='No cargado') {{$particular}} @else {{$laboral}} @endif</td>
													<td>{{$correo}}</td>
												</tr>
												@endif
												@if ($filtroseleccionado==4)
													@if ($alumno->persona['sexo']==$filtrosexo)
														<tr>
															<td>{{$alumno->persona['apellido'].", ". $alumno->persona['nombre']}}</td>
															<td>{{$alumno->persona['nrodocumento']}}</td>
															<td>{{$alumno->persona['sexo']}}</td>
															<td>
																@if (empty($alumno->persona['barrio']) or ($alumno->persona['barrio']==null)) 
																	{{'B° no cargado -'}} 
																@else 
																	{{$alumno->persona['barrio']. ' -'}}
																@endif
																@if (empty($alumno->persona['calle']) or ($alumno->persona['calle']==null)) 
																	{{'Calle no cargado'}} 
																@else 
																	{{$alumno->persona['calle']}} 
																@endif 
																@if ($alumno->persona['numero']==0) 
																	{{'s/n'}} 
																@else 
																	{{$alumno->persona['numero']}} 
																@endif
																@if ($alumno->persona['manzana']==0) 
																	{{''}} 
																@else 
																	{{', Mz: '. $alumno->persona['manzana']}} 
																@endif
																@if ($alumno->persona['departamento']==0) 
																	{{''}} 
																@else 
																	{{', Dpto: '. $alumno->persona['departamento']}} 
																@endif
															</td>
															<td>{{$alumno->persona->localidad['descripcion']}}</td>
															<td>@if ($particular!='No cargado') {{$particular}} @else {{$laboral}} @endif</td>
															<td>{{$correo}}</td>
														</tr>
													@endif	
												@endif
												@if ($filtroseleccionado==2)
													@if ($filtroapellido==null and $filtronombre==null)
														<tr>
															<td>{{$alumno->persona['apellido'].", ". $alumno->persona['nombre']}}</td>
															<td>{{$alumno->persona['nrodocumento']}}</td>
															<td>{{$alumno->persona['sexo']}}</td>
															<td>
																@if (empty($alumno->persona['barrio']) or ($alumno->persona['barrio']==null)) 
																	{{'B° no cargado -'}} 
																@else 
																	{{$alumno->persona['barrio']. ' -'}}
																@endif
																@if (empty($alumno->persona['calle']) or ($alumno->persona['calle']==null)) 
																	{{'Calle no cargado'}} 
																@else 
																	{{$alumno->persona['calle']}} 
																@endif 
																@if ($alumno->persona['numero']==0) 
																	{{'s/n'}} 
																@else 
																	{{$alumno->persona['numero']}} 
																@endif
																@if ($alumno->persona['manzana']==0) 
																	{{''}} 
																@else 
																	{{', Mz: '. $alumno->persona['manzana']}} 
																@endif
																@if ($alumno->persona['departamento']==0) 
																	{{''}} 
																@else 
																	{{', Dpto: '. $alumno->persona['departamento']}} 
																@endif
															</td>
															<td>{{$alumno->persona->localidad['descripcion']}}</td>
															<td>@if ($particular!='No cargado') {{$particular}} @else {{$laboral}} @endif</td>
															<td>{{$correo}}</td>
														</tr>
													@else
														<?php 
														 $apellidov = stripos($alumno->persona['apellido'], $filtroapellido);	
														 $nombrev 	= stripos($alumno->persona['nombre'], $filtronombre);
														?>


														@if ($apellidov!==false or $nombrev!==false)
														<tr>
															<td>{{$alumno->persona['apellido'].", ". $alumno->persona['nombre']}}</td>
															<td>{{$alumno->persona['nrodocumento']}}</td>
															<td>{{$alumno->persona['sexo']}}</td>
															<td>
																@if (empty($alumno->persona['barrio']) or ($alumno->persona['barrio']==null)) 
																	{{'B° no cargado -'}} 
																@else 
																	{{$alumno->persona['barrio']. ' -'}}
																@endif
																@if (empty($alumno->persona['calle']) or ($alumno->persona['calle']==null)) 
																	{{'Calle no cargado'}} 
																@else 
																	{{$alumno->persona['calle']}} 
																@endif 
																@if ($alumno->persona['numero']==0)
																	{{'s/n'}} 
																@else 
																	{{$alumno->persona['numero']}} 
																@endif
																@if ($alumno->persona['manzana']==0) 
																	{{''}} 
																@else 
																	{{', Mz: '. $alumno->persona['manzana']}} 
																@endif
																@if ($alumno->persona['departamento']==0) 
																	{{''}} 
																@else 
																	{{', Dpto: '. $alumno->persona['departamento']}} 
																@endif
															</td>
															<td>{{$alumno->persona->localidad['descripcion']}}</td>
															<td>@if ($particular!='No cargado') {{$particular}} @else {{$laboral}} @endif</td>
															<td>{{$correo}}</td>
														</tr>
														@endif
													@endif														
												@endif
												@if ($filtroseleccionado==5)
													<?php 
													 $localidad = stripos($alumno->persona->localidad['descripcion'], $filtrolocalidad);	
													?>

													@if ($localidad!==false)
													<tr>
														<td>{{$alumno->persona['apellido'].", ". $alumno->persona['nombre']}}</td>
														<td>{{$alumno->persona['nrodocumento']}}</td>
														<td>{{$alumno->persona['sexo']}}</td>
														<td>
															@if (empty($alumno->persona['barrio']) or ($alumno->persona['barrio']==null)) 
																{{'B° no cargado -'}} 
															@else 
																{{$alumno->persona['barrio']. ' -'}}
															@endif
															@if (empty($alumno->persona['calle']) or ($alumno->persona['calle']==null)) 
																{{'Calle no cargado'}} 
															@else 
																{{$alumno->persona['calle']}} 
															@endif 
															@if ($alumno->persona['numero']==0)
																{{'s/n'}} 
															@else 
																{{$alumno->persona['numero']}} 
															@endif
															@if ($alumno->persona['manzana']==0) 
																{{''}} 
															@else 
																{{', Mz: '. $alumno->persona['manzana']}} 
															@endif
															@if ($alumno->persona['departamento']==0) 
																{{''}} 
															@else 
																{{', Dpto: '. $alumno->persona['departamento']}} 
															@endif
														</td>
														<td>{{$alumno->persona->localidad['descripcion']}}</td>
														<td>@if ($particular!='No cargado') {{$particular}} @else {{$laboral}} @endif</td>
														<td>{{$correo}}</td>
													</tr>
													@endif													
												@endif
											@endforeach
										@endif		
									</tbody>
								</table>
							</div>
						

						</div>
					</div>
					<!-- FIN DE LA TABLA-->
				</div>
			</div>
			<!-- FIN DEL CONTENIDO -->
		</div>
	</div>
	<!-- FIN -->
@stop


@section('customjs')

	TableAdvanced.init();

	//Emular Tab al presionar Enter
	$('input').keydown( function(e) {
	        var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
	        if(key == 13) {
	            e.preventDefault();
	            var inputs = $(this).closest('form').find(':input:visible');
	            inputs.eq( inputs.index(this)+ 1 ).focus();
	        }
	 });

	$('#organizacion, #carrera').select2({
		placeholder: "Seleccione",
		allowClear: true
	});
	
	$('#organizacion, #carrera').on('change', function(){
		$('#divbtnImprimir').hide();
	});

	$('#filtro').on('change', function(){
		$('#divbtnImprimir').hide();
		if ($(this).val()==2)
		{
			$('#divdescripcion').hide();
			$('#divsexo').hide();
			$('#divapellido, #divnombre').show();
			$('#filtroapellido').focus();
		}
		else if ($(this).val()==4)
		{
			$('#divapellido, #divnombre').hide();
			$('#divdescripcion').hide();
			$('#divsexo').show();	
		}
		else if ($(this).val()==1)
		{
			$('#divapellido, #divnombre').hide();
			$('#divsexo').hide();
			$('#divdescripcion').hide();
		}
		else
		{
			$('#divapellido, #divnombre').hide();
			$('#divsexo').hide();
			$('#divdescripcion').show();		
		}
	});

	$('#organizacion').combodinamico("{{url('alumnos/obtenercarreras/')}}", $('#carrera'));

	$('#imprimir').on('click', function(e){
		e.preventDefault();
		window.open("{{url('alumnos/informepdf')}}?filtro=" + $('#filtro').val() + "&organizacion=" + $('#organizacion').val() + "&carrera=" + $('#carrera').val() + "&filtrosexo=" + $("#filtrosexo").val() +"&filtroapellido=" + $('#filtroapellido').val() + "&filtronombre=" + $('#filtronombre').val() + "&filtrolocalidad=" + $('#filtrolocalidad').val() + "&nombrecarrera=" + $('#carrera option:selected').text());
	});

@stop


@section('includejs')
	<script type="text/javascript" src="{{url('assets/global/plugins/select2/select2.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js')}}"></script>

	<script src="{{url('assets/admin/pages/scripts/table-advanced.js')}}"></script>
	<script src="{{url('assets/admin/pages/scripts/helpers/jquery.combodinamico.js')}}" type="text/javascript"></script>
@stop
