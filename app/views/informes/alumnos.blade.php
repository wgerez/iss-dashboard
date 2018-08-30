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
					Informes <small>informe de alumnos (pdf)</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">Informes</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">Alumnos</a>
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

					<!-- COMIENZO DE LA TABLA-->
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-users"></i>Informes de Alumnos
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
							<div class="form-group">

    							<label class="col-md-12 col-sm-12 control-label">
    								<i class="fa fa-circle-o"></i>
									<a href="{{url('alumnos/informealumnosporcarrera')}}">
										Alumnos por Carrera
									</a>
								</label>

    							<label class="col-md-12 col-sm-12 control-label">
    								<i class="fa fa-circle-o"></i>
									<a href="{{url('alumnos/informecuentaalumnos')}}">
										Estado de Cuenta del Alumno
									</a>
								</label>

    							<label class="col-md-12 col-sm-12 control-label">
    								<i class="fa fa-circle-o"></i>
									<a href="{{url('alumnos/informealumnosdeudasporcarrera')}}">
										Alumnos con Deudas por Carrera
									</a>
								</label>

    							<label class="col-md-12 col-sm-12 control-label">
    								<i class="fa fa-circle-o"></i>
									<a href="{{url('alumnos/informeanaliticoalumnos')}}">
										Analitico
									</a>
								</label>

								<label class="col-md-12 col-sm-12 control-label">
    								<i class="fa fa-circle-o"></i>
									<a href="{{url('alumnos/informealumnosporciclolectivo')}}">
										Alumnos por Ciclo Lectivo
									</a>
								</label>

								<label class="col-md-12 col-sm-12 control-label">
    								<i class="fa fa-circle-o"></i>
									<a href="{{url('alumnos/informealumnosbecadosactivosbaja')}}">
										Alumnos por Carrera becados, activos y de baja
									</a>
								</label>

    							<label class="col-md-12 col-sm-12 control-label">
    								<i class="fa fa-circle-o"></i>
									<a href="{{url('alumnos/informelegajosalumnosporcarrera')}}">
										Legajos de Alumnos
									</a>
								</label>

								<label class="col-md-12 col-sm-12 control-label">
    								<i class="fa fa-circle-o"></i>
									<a href="{{url('alumnos/informealumnosbecadosactivos')}}">
										Porcentaje de Alumnos becados y activos
									</a>
								</label>

								<label class="col-md-12 col-sm-12 control-label">
    								<i class="fa fa-circle-o"></i>
									<a href="{{url('alumnos/informealumnosmatriculadosxciclo')}}">
										Cantidad de Alumnos Matriculados por Ciclo Lectivo
									</a>
								</label>

								<label class="col-md-12 col-sm-12 control-label">
    								<i class="fa fa-circle-o"></i>
									<a href="{{url('alumnos/informeauditoriaalumnos')}}">
										Informe de Auditoria Alumnos
									</a>
								</label>
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
