 @extends('layouts.master')

@section('customstyle')
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/select2/select2.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css')}}"/>
@stop
<?php
	//BOTONES Y CAMPOS DE PERMISOS
$disabled = (!$editar) ? 'disabled' : '';
$readonly = (!$editar) ? 'readonly' : '';
$imprimir = (!$imprimir) ? 'disabled' : '';

	$idorg = (isset($organizacionid)) ? $organizacionid : null;
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
					Usuarios <small>gestión de usuarios</small>
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
						</li -->
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
					    @if (Session::get('message_type') == UsersController::OPERACION_EXITOSA)

					        <div class="note note-success">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == UsersController::OPERACION_FALLIDA)

					        <div class="note note-danger">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == UsersController::OPERACION_CANCELADA)

					        <div class="note note-warning">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@elseif (Session::get('message_type') == UsersController::OPERACION_INFO)

					        <div class="note note-info">
								<p><strong> {{ Session::get('message') }} </strong></p>
							</div>

						@endif
					@endif
					<!-- COMIENZO DE LA TABLA-->
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-user"></i>Listado de Usuarios
							</div>
							<div class="actions">
								<a href="{{url('usuarios/crear')}}" {{$disabled}} class="btn default blue-stripe">
								<i class="fa fa-plus"></i>
								<span class="hidden-480">
								Nuevo </span>
								</a>
								<a href="{{url('usuarios/listado')}}" class="btn default yellow-stripe">
								<i class="fa fa-refresh"></i>
								<span class="hidden-480">
								Actualizar </span>
								</a>
								<a target="_blank" href="#" id="imprimir" class="btn default yellow-stripe" <?php if (count($usuarios) == 0) echo 'disabled' ?>>
								<i class="glyphicon glyphicon-list-alt"></i>
								<span class="hidden-480">
								Imprimir </span>
								</a>

							</div>

						</div>
						<div class="portlet-body form">
							<div class="form-body">
								{{ Form::open(array('url'=>'usuarios/listado', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmUsuarios', 'name'=>'FrmUsuarios'))}}
								<div class="form-group">
									<label  class="col-md-2 col-sm-2 control-label">Organización:</label>
									<div class="col-md-6 col-sm-8">
										{{ Form::select('organizacion', $organizaciones, $idorg, array('class'=>'table-group-action-input form-control','id'=>'organizacion')); }}
									</div>
									<div class="col-md-2 col-sm-2">
										<button type="submit"  class="btn btn-primary" href="#"><i class="fa fa-search"></i> Buscar</button>
									</div>													
								</div>
								{{ Form::close() }}
							</div>
							<table class="table table-striped table-bordered table-hover" id="table_usuarios">
								<thead>
								<tr>
									<th>
										<center><i class="fa fa-list-ol"></i> Cod.</center>
									</th>
									<th>
										<center><i class="fa fa-tag"></i> Apellido y Nombre</center>
									</th>
									<th>
										<center><i class="fa fa-user"></i> Usuario</center>
									</th>
									<th>
										<center><i class="fa fa-users"></i> Perfiles</center>
									</th>									
									<th>
										<center><i class="fa fa-envelope"></i> Correo</center>
									</th>									
									<th>
										<center><i class="fa fa-rocket"></i> Acción</center>
									</th>
								</tr>
								</thead>
								
								<tbody>
									@if (isset($usuarios))
										@foreach ($usuarios as $usuario)
											@if (Auth::user()->id==5)
												<tr class="@if ($usuario->activo == 0) {{'danger'}} @else @if (!isset($usuario->perfiles->first()->perfil)) {{'warning'}}  @endif @endif">
													<td><center>
														{{$usuario->Persona['id']//$usuario->id}}</center>
													</td>
													<td>
														{{ $usuario->Persona['apellido'].', '.$usuario->Persona['nombre'] }}
													</td>
													<td>
														{{$usuario->usuario}}
													</td>
													<td>
														@if (isset($usuario->perfiles->first()->perfil)) {{ $usuario->perfiles->first()->perfil }}  @else {{ 'Sin perfil' }} @endif
													</td>
													<td>
														{{$usuario->email}}
													</td>										
													<td>
														<center>
														<a title="Modificar" href="editar/{{$usuario->id}}" class="btn default btn-xs purple">
														<i class="fa fa-edit"></i></a>
														<a title="Asignar Perfil" href="asignaperfil/{{$usuario->id}}" class="btn default btn-xs blue-madison">
														<i class="fa fa-unlock-alt"></i></a>
														<a  @if (!$eliminar) {{'DISABLED'}} @endif href="#modaleliminausuario" @if (Auth::user()->id == $usuario->id) {{'disabled'}} @endif data-id="{{$usuario->id}}" data-idorg="{{$usuario->pivot->organizacion_id}}" class="btn default btn-xs red btnEliminarUsuario">
														<i title="Eliminar" class="fa fa-trash-o"></i></a>
														</center>
													</td>
												</tr>
												@else
													@if ( $usuario->id!=5)
													<tr class="@if ($usuario->activo == 0) {{'danger'}} @else @if (!isset($usuario->perfiles->first()->perfil)) {{'warning'}}  @endif @endif">
														<td><center>
															{{$usuario->Persona['id']//$usuario->id}}</center>
														</td>
														<td>
															{{ $usuario->Persona['apellido'].', '.$usuario->Persona['nombre'] }}
														</td>
														<td>
															{{$usuario->usuario}}
														</td>
														<td>
															@if (isset($usuario->perfiles->first()->perfil)) {{ $usuario->perfiles->first()->perfil }}  @else {{ 'Sin perfil' }} @endif
														</td>
														<td>
															{{$usuario->email}}
														</td>										
														<td>
															<center>
															<a title="Modificar" href="editar/{{$usuario->id}}" class="btn default btn-xs purple">
															<i class="fa fa-edit"></i></a>
															<a title="Asignar Perfil" href="asignaperfil/{{$usuario->id}}" class="btn default btn-xs blue-madison">
															<i class="fa fa-unlock-alt"></i></a>
															<a  @if (!$eliminar) {{'DISABLED'}} @endif href="#modaleliminausuario" @if (Auth::user()->id == $usuario->id) {{'disabled'}} @endif data-id="{{$usuario->id}}" data-idorg="{{$usuario->pivot->organizacion_id}}" class="btn default btn-xs red btnEliminarUsuario">
															<i title="Eliminar" class="fa fa-trash-o"></i></a>
															</center>
														</td>
													</tr>
													@endif
												@endif	
										@endforeach
									@endif
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

	<!-- MODAL ELIMINACION DE CICLOS-->
	<div class="modal fade" id="modalEliminaUsuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		{{ Form::open(array('url' => 'usuarios/borrar')) }}
			<input id="idUsuarioHidden" name='idUsuarioHidden' type="hidden" value="">
			<input id="idOrganizacionHidden" name='idOrganizacionHidden' type="hidden" value="">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Eliminar Usuario</h4>
					</div>
					<div class="modal-body">
						¿Estás seguro de querer borrar este usuario?
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

@stop


@section('customjs')
	TableAdvanced.init();

	$('#organizacion').select2({
		placeholder: "Seleccione",
		allowClear: true
	});

	//AL PRESIONAR LOS BOTONES ELIMINAR PASO EL DATA ID DE LA CARRERA A ELIMINAR
	$('.btnEliminarUsuario').live('click', function(){
		$('#idUsuarioHidden').val($(this).data('id'));
		$('#idOrganizacionHidden').val($(this).data('idorg'));
		$('#modalEliminaUsuario').modal('show');
	});

	$('#imprimir').on('click', function(e){
		e.preventDefault();
		window.open("{{url('usuarios/imprimirusuarios')}}?organizacion=" + $('#organizacion').val());
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
