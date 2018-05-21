@extends('layouts.master')

@section('customstyle')
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/select2/select2.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css')}}"/>
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
					Alumnos <small>gesti&oacute;n de alumnos</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<!--li class="btn-group">
							<button type="button" class="btn blue dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
							<span>Acciones</span><i class="fa fa-angle-down"></i>
							</button>
							<ul class="dropdown-menu pull-right" role="menu">
								<li>
									<a href="#">Exportar a PDF</a>
								</li>
								<li>
									<a href="#">Exportar a CVS</a>
								</li>
								<li>
									<a href="#">Exportar a Excel</a>
								</li>
								<li class="divider">
								</li>
								<li>
									<a href="#">Salir</a>
								</li>
							</ul>
						</li-->
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
							<a href="#">Listado</a>
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
								<i class="fa fa-users"></i>Listado de Alumnos
							</div>
							<div class="actions">
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

							</div>

						</div>
						<div class="portlet-body">
							<table class="table table-striped table-bordered table-hover" id="table_alumnos">
							<thead>
							<tr>
								<th>
									 <center><i class="fa fa-list-ol"></i> N° Legajo</center>
								</th>
								<th>
									 <center><i class="fa fa-user"></i> Apellido y Nombre</center>
								</th>
								<th>
									 <center><i class="fa fa-calendar"></i> Fecha Nacimiento</center>
								</th>
								<th>
									 <center><i class="fa fa-calendar"></i> Ingreso</center>
								</th>
								<th>
									 <center><i class="fa fa-calendar"></i> Egreso</center>
								</th>
								<th>
									 <center><i class="fa fa-rocket"></i> Acciones</center>
								</th>								
							</tr>
							</thead>
							<tbody>

							@foreach ($alumnos as $alumno)
							    <?php

							    $fecha_nacimiento = FechaHelper::getFechaImpresion($alumno->persona->fechanacimiento);
							    $fecha_ingreso = FechaHelper::getFechaImpresion($alumno->fechaingreso);
							    $fecha_egreso  = FechaHelper::getFechaImpresion($alumno->fechaegreso);

							    $contactotel = 'No posee';
							    $contactocorreo = 'No posee';
							    foreach ($alumno->persona->contactos as $contacto) {
							    	$contid =  $contacto->pivot->contacto_id;
							    	if ($contid == 1 || $contid == 2){
							    		$contactotel = 	$contacto->pivot->descripcion;
							    	}elseif ($contid == 3) {
							    		$contactocorreo = $contacto->pivot->descripcion;
							    	}
							    }

							    ?>
								<tr class="@if (!$alumno->activo) {{'danger'}} @endif">
									<td class="verinfo" data-id="{{$alumno->id}}" data-cel="{{$contactotel}}" data-correo="{{$contactocorreo}}" data-nivel="{{$alumno->activo}}" style="cursor:pointer">
										{{$alumno->nrolegajo}}
									</td>
									<td class="verinfo" data-id="{{$alumno->id}}" data-cel="{{$contactotel}}" data-correo="{{$contactocorreo}}" data-nivel="{{$alumno->activo}}" style="cursor:pointer">
										{{$alumno->persona->apellido}} , {{$alumno->persona->nombre}}
									</td>
									<td class="verinfo" data-id="{{$alumno->id}}" data-cel="{{$contactotel}}" data-correo="{{$contactocorreo}}" data-nivel="{{$alumno->activo}}" style="cursor:pointer">
										{{$fecha_nacimiento}}
									</td>
									<td class="verinfo" data-id="{{$alumno->id}}" data-cel="{{$contactotel}}" data-correo="{{$contactocorreo}}" data-nivel="{{$alumno->activo}}" style="cursor:pointer">
										{{$fecha_ingreso}}
									</td>
									<td class="verinfo" data-id="{{$alumno->id}}" data-cel="{{$contactotel}}" data-correo="{{$contactocorreo}}" data-nivel="{{$alumno->activo}}" style="cursor:pointer">
										{{$fecha_egreso}}
									</td>
									<td>
										<center>
											<a title="Inscripción" href="{{url('inscripciones/inscribiralumno/'.$alumno->id)}}" class="btn btn-xs blue">
											<i class="fa fa-check-square-o"></i></a>											
											<a title="Legajo" href="legajo/{{$alumno->id}}" class="btn btn-xs blue-hoki">
											<i class="fa fa-files-o"></i></a>
											<!--a title="Familia" href="familias/{{$alumno->id}}" class="btn btn-xs btn-primary">
											<i class="fa fa-users"></i></a-->											
											<a title="Datos personales" href="editar/{{$alumno->id}}" class="btn btn-xs purple">
											<i class="fa fa-edit"></i></a>
											<a title="Eliminar" href="#modaleliminaalumno" @if (!$eliminar) {{'DISABLED'}} @endif data-id="{{$alumno->id}}" data-nombre="{{$alumno->persona->apellido}}, {{$alumno->persona->nombre}}" class="btn default btn-xs red btnEliminarAlumno">
											<i class="fa fa-trash-o"></i></a>
										</center>
									</td>
								</tr>
							@endforeach

							</tbody>
							</table>
						</div>
					</div>
					<!-- FIN DE LA TABLA-->
				</div>
			</div>
			<!-- FIN DEL CONTENIDO -->
		</div>
	</div>
	<!-- FIN -->


	<!-- MODAL ELIMINACION DE ALUMNOS-->
	<div class="modal fade" id="modalEliminaAlumno" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		{{ Form::open(array('url' => 'alumnos/borrar')) }}
			<input id="idAlumnoHidden" name='txtIdAlumnoHidden' type="hidden" value="">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Eliminar Alumno</h4>
					</div>
					<div class="mensajeeliminaralumno modal-body">
						 
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn red"><i class="fa fa-trash-o"></i> Eliminar</button>
						<button type="button" class="btn default" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> Cancelar</button>
					</div>
				</div>
				<!-- /.modal-contenido -->
			</div>
		{{Form::close()}}
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
	<!-- FIN DEL MODAL FORM-->

	<!-- MODAL VER MAS INFO-->
	<div id="modalVerMasInformacion" class="modal fade" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title"><strong>Alumno</strong></h4>
				</div>
				<div class="modal-body">
					<div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible="1">

							<div class="col-md-12 col-sm-12">
								<div class="col-md-6 col-sm-6 hidden-xs">
									<div class="thumbnail pull-right" style="width: 130px; height: auto;">
										<img class="tumbFotoPerfil" src="{{url('assets/admin/layout/img/sinperfil.png')}}" alt="sin perfil">
									</div>									
								</div>
								<div class="col-xs-12 hidden-md hidden-sm hidden-lg">
									<center>
									<div class="thumbnail" style="width: 130px; height: auto;">
										<img class="tumbFotoPerfil" src="{{url('assets/admin/layout/img/sinperfil.png')}}" alt="sin perfil">
									</div>
									</center>									
								</div>															
								<div class="col-md-6 col-sm-6">
									<p class="text-info"><strong>Apellido</strong></p>
									<p id="mApellidoAlumno"></p>
									<p class="text-info"><strong>Nombre</strong></p>
									<p id="mNombreAlumno"></p>				
								</div>
							</div>
							<div class="col-md-12 col-sm-12">
								<div class="col-md-4 col-sm-4">
						 			<p class="text-info"><strong>Fecha Nacimiento</strong></p>
						 		</div>
						 		<div class="col-md-8 col-sm-8">
						 			<p id="mFechaNacimientoAlumno"> - </p>
						 		</div>

								<div class="col-md-4 col-sm-4">
						 			<p class="text-info"><strong>Activo</strong></p>
						 		</div>
						 		<div class="col-md-8 col-sm-8">
						 			<p id="mActivoAlumno"></p>
						 		</div>
								<div class="col-md-4 col-sm-4">
						 			<p class="text-info"><strong>Teléfono</strong></p>
						 		</div>
						 		<div class="col-md-8 col-sm-8">
						 			<p id="mTelefono"></p>
						 		</div>
								<div class="col-md-4 col-sm-4">
						 			<p class="text-info"><strong>Correo</strong></p>
						 		</div>
						 		<div class="col-md-8 col-sm-8">
						 			<p id="mCorreo"></p>
						 		</div>						 		
							</div>
						
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn default" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> Cerrar</button>				</div>
			</div>
		</div>
	</div>


@stop


@section('customjs')
	TableAdvanced.init();

	$('.verinfo').live('click', function(){
		var nivel = $(this).data('nivel');
		var tel = $(this).data('cel');
		var correo = $(this).data('correo');
		$.ajax({
		  url: "{{url('alumnos/show')}}",
		  data:{'id': $(this).data('id')},
		  type: 'POST'
		}).done(function(alumno) {
			console.log(alumno);
			var fecha_nacimiento = getFechaImpresion(alumno.persona.fechanacimiento);
			var fecha_alta = getFechaImpresion(alumno.persona.fecha_alta);

		  	$('#mApellidoAlumno').text(alumno.persona.apellido);
		  	$('#mNombreAlumno').text(alumno.persona.nombre);
		  	$('#mFechaNacimientoAlumno').text(fecha_nacimiento);
		  	if (alumno.foto){ $('.tumbFotoPerfil').attr("src", 'img-perfil/'+alumno.foto); }else{ $('.tumbFotoPerfil').attr("src", 'img-perfil/sinperfil.png'); };
		  	if (alumno.activo==1){ var activo='SI'; }else{ var activo='NO'; }
		  	$('#mActivoAlumno').text(activo);
			$('#mTelefono').text(tel);
			$('#mCorreo').text(correo);

		  	$('#modalVerMasInformacion').modal('show');
		}).error(function(data){
			console.log(data);
		});
	});

	//AL PRESIONAR LOS BOTONES ELIMINAR PASO EL DATA ID DEL ALUMNO A ELIMINAR
	$('.btnEliminarAlumno').live('click', function(){
		//PASO EL DATA ID AL CAMPO OCULTO
		$('#idAlumnoHidden').val($(this).data('id'));
		$('.mensajeeliminaralumno').html('¿Estás seguro de querer borrar a <b>'+$(this).data('nombre')+'</b>?');
		//MUESTRO EL MODAL DE ADVERTENCIA
		$('#modalEliminaAlumno').modal('show');
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
	<script src="{{url('assets/admin/pages/scripts/getFechaImpresion.js')}}"></script>
@stop
