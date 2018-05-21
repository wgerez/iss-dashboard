@extends('layouts.master')

@section('content')
	<!-- COMIENZO CONTENIDO -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- COMIENZO DEL HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- COMIENZO TITULO & BREADCRUMB-->
					<h3 class="page-title">Informes <small>informe de matriculas (pdf)</small></h3>
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
							<a href="#">Matrículas</a>
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
								<i class="fa fa-users"></i>Informes de Matrículas
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
									<a href="{{url('matriculas/informepagos')}}">
										Pagos de Matrículas
									</a>
								</label>

    							<label class="col-md-12 col-sm-12 control-label">
    								<i class="fa fa-circle-o"></i>
									<a href="{{url('matriculas/informepagosparcial')}}">
										Pago Parcial de Matrícula
									</a>
								</label>

    							<label class="col-md-12 col-sm-12 control-label">
    								<i class="fa fa-circle-o"></i>
									<a href="{{url('alumnos/informealumnosmatriculadosporanio')}}">
										Alumnos Matriculados por A&ntilde;o
									</a>
								</label>

    							<label class="col-md-12 col-sm-12 control-label">
    								<i class="fa fa-circle-o"></i>
									<a href="{{url('alumnos/informealumnosbecados')}}">
										Alumnos Becados
									</a>
								</label>

								<label class="col-md-12 col-sm-12 control-label">
    								<i class="fa fa-circle-o"></i>
									<a target="_blank" href="{{url('matriculas/informeauditoriamatricula')}}">
										Informe Auditoria de Matriculas
									</a>
								</label>

								<label class="col-md-12 col-sm-12 control-label">
    								<i class="fa fa-circle-o"></i>
									<a target="_blank" href="{{url('materias/informeauditoriamateria')}}">
										Informe Auditoria de Materias
									</a>
								</label>
    							<!--<label class="col-md-12 col-sm-12 control-label">
    								<i class="fa fa-circle-o"></i>
									<a href="{{url('alumnos/informeporcentajealumnosbecadosyactivos')}}">
										Porcentaje de Alumnos Becados y Activos
									</a>
								</label>-->
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
