@extends('layouts.master')

@section('customstyle')
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/select2/select2.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css')}}"/>
@stop
<?php
	(isset($organizacionseleccionada)) ? $orgid = $organizacionseleccionada : $orgid = null;
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
					Informes <small>informe de docentes (pdf)</small>
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
							<a href="#">Informe</a>
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
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == DocentesController::OPERACION_FALLIDA)

					        <div class="note note-danger">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == DocentesController::OPERACION_CANCELADA)

					        <div class="note note-warning">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == DocentesController::OPERACION_INFO)

					        <div class="note note-info">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@endif
					@endif
					<!-- COMIENZO DE LA TABLA-->
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-users"></i>Informe de Docentes
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
								{{ Form::open(array('url'=>'docentes/informelistado', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmDocentes', 'name'=>'FrmDocentes'))}}
									<div class="form-group">
										<label  class="col-md-2 col-sm-2 control-label" for="organizacion">Organización:</label>
										<div class="col-md-6 col-sm-10">
											{{ Form::select('organizacion', $organizaciones, $orgid, array('class'=>'table-group-action-input form-control','id'=>'organizacion')) }}
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
									</div>
								{{ Form::close() }}
								<br>
								<table class="table table-striped table-bordered table-hover" id="table_informes_docentes">
									<thead>
										<tr>
											<th>
												 <center><i class="fa fa-tags"></i> Apellido y Nombre</center>
											</th>
											<th>
												 <center><i class="fa fa-list-ol"></i> DNI</center>
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
										@if (isset($docentes))
											@foreach ($docentes as $docente)
												<!-- RESCATO EL TELEFONO Y EL CORREO -->
												<?php $particular = 'No cargado'; ?>
												<?php $laboral  = 'No Cargado'; ?>
												<?php $correo   = 'No cargado'; ?>
												@foreach ($docente->persona->contactos as $contacto)
													@if ($contacto->id==1)
														<?php $particular = $contacto->pivot->descripcion; ?>
													@elseif ($contacto->id==2)
														<?php $laboral = $contacto->pivot->descripcion; ?>
													@elseif($contacto->id==3)
														<?php $correo = $contacto->pivot->descripcion; ?>
													@endif
												@endforeach											
												<tr>
													<td>{{$docente->persona['apellido'].", ". $docente->persona['nombre']}}</td>
													<td>{{$docente->persona['nrodocumento']}}</td>
													<td>
															@if (empty($docente->persona['barrio']) or ($docente->persona['barrio']==null)) 
																{{'B° no cargado - '}} 
															@else 
																{{$docente->persona['barrio'] . ' - '}} 
															@endif
															@if (empty($docente->persona['calle']) or ($docente->persona['calle']==null)) 
																{{'Calle no cargado - '}} 
															@else 
																{{$docente->persona['calle'] . ' - '}} 
															@endif 
															@if ($docente->persona['numero']==0)
																{{'s/n'}} 
															@else 
																{{$docente->persona['numero']}} 
															@endif
								                              @if ($docente->persona['manzana']==0) 
								                                {{''}} 
								                              @else 
								                                {{', Mz: '. $docente->persona['manzana']}} 
								                              @endif
								                              @if ($docente->persona['departamento']==0) 
								                                {{''}} 
								                              @else 
								                                {{', Dpto: '. $docente->persona['departamento']}} 
								                              @endif
													</td>
													<td>{{$docente->persona->localidad['descripcion']}}</td>
													<td>@if ($particular!='No cargado') {{$particular}} @else {{$laboral}} @endif</td>
													<td>{{$correo}}</td>
												</tr>
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

	$('#organizacion').select2({
		placeholder: "Seleccione",
		allowClear: true
	});
	
	$('#organizacion').on('change', function(){
		$('#divbtnImprimir').hide();
	});

	$('#imprimir').on('click', function(e){
		e.preventDefault();
		window.open("{{url('docentes/informepdf')}}?organizacion=" + $('#organizacion').val());
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
@stop
