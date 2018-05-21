@extends('layouts.master')

@section('customstyle')

@stop 

@section('content')
	<!-- COMIENZO CONTENIDO -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<!-- PARA MOSTRAR ALERTAS - ERRORES - INFORMACIÓN ETC. USAREMOS ESTE DIV. DEPENDIENDO DEL TIPO (note-danger=rojo - note-info=celeste - note-warning=rojo - note-success=verde) USAR DISPLAY:NONE  -->
				@if (Session::has('message'))
				    @if (Session::get('message_type') == DashboardController::OPERACION_EXITOSA)

						<div class="note note-success">
							<p> {{ Session::get('message') }} </p>
						</div>

					@elseif (Session::get('message_type') == DashboardController::OPERACION_FALLIDA)

						<div class="note note-danger">
							<p> <i class="fa fa-exclamation-triangle"></i> {{ Session::get('message') }} </p>
						</div>

					@endif
				@endif
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat blue-madison">
						<div class="visual">
							<i class="fa fa fa-graduation-cap"></i>
						</div>
						<div class="details">
							<div class="number">
								 {{$totalalumnos}}
							</div>
							<div class="desc">
								 Alumnos
							</div>
						</div>
						<a class="more" href="{{url('alumnos/listado')}}">
						Ver más <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>

				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat red-intense">
						<div class="visual">
							<i class="fa fa-users"></i>
						</div>
						<div class="details">
							<div class="number">
								 {{$totaldocentes}}
							</div>
							<div class="desc">
								 Docentes
							</div>
						</div>
						<a class="more" href="{{url('docentes/listado')}}">
						Ver más <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>

				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat purple-plum">
						<div class="visual">
							<i class="fa fa-files-o"></i>
						</div>
						<div class="details">
							<div class="number">
								 {{$totalcarreras}}
							</div>
							<div class="desc">
								 Carreras
							</div>
						</div>
						<a class="more" href="{{url('carreras/listado')}}">
						Ver más <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>					

				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat green-haze">
						<div class="visual">
							<i class="fa fa-user"></i>
						</div>
						<div class="details">
							<div class="number">
								 {{$totalbecados}}
							</div>
							<div class="desc">
								 Becados
							</div>
						</div>
						<a class="more" href="{{url('alumnos/informealumnosbecados')}}">
						Ver más <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>


				<div class="col-md-6 col-sm-6">
					<!-- BEGIN PORTLET-->
					<div class="portlet solid bordered grey-cararra">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-bar-chart-o"></i>Alumnos por carreras
							</div>
						</div>
						<div class="portlet-body">
							<canvas id="canvas" height="150"></canvas>
							<div style="margin: 20px 0 10px 30px">
								<div class="row">
									<div class="col-md-3 col-sm-3 col-xs-6 text-stat">
										<center><span class="label label-sm label-success">
										Hombres </span></center>
										<center><h3>{{$totalhombres}}</h3></center>
									</div>
									<div class="col-md-3 col-sm-3 col-xs-6 text-stat">
										<center><span class="label label-sm label-info">
										Mujeres </span></center>
										<center><h3>{{$totalmujeres}}</h3></center>
									</div>
								</div>
							</div>							
						</div>
					</div>
					<!-- END PORTLET-->
				</div>


				<div class="col-md-6 col-sm-6">
					<!-- BEGIN PORTLET-->
					<div class="portlet solid grey-cararra bordered">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa">%</i> Alumnos por Carrera
							</div>
						</div>
						<div class="portlet-body">
							<center><canvas id="chart-area" height="150"></canvas></center>
							<div style="margin: 20px 0 10px 30px">
								<div class="row">
									<div class="col-md-3 col-sm-3 col-xs-6 text-stat">
										<center><span class="label label-sm label-success">
										Hombres </span></center>
										<center><h3>{{$totalhombres}}</h3></center>
									</div>
									<div class="col-md-3 col-sm-3 col-xs-6 text-stat">
										<center><span class="label label-sm label-info">
										Mujeres </span></center>
										<center><h3>{{$totalmujeres}}</h3></center>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- END PORTLET-->
				</div>				

			</div>
		</div>
	</div>
	<!-- FIN -->

@stop

@section('customjs')
	var barChartData = {
		labels : <?php echo json_encode($carreras); ?>,
		datasets : [
			{
				fillColor : "rgba(151,187,205,0.5)",
				strokeColor : "rgba(151,187,205,0.8)",
				highlightFill : "rgba(151,187,205,0.75)",
				highlightStroke : "rgba(151,187,205,1)",
				data : <?php echo json_encode($alumnosporcarrera); ?>
			}
		]

	}


	var pieData = <?php echo json_encode($porcentaje); ?>;
	
	window.onload = function(){
		var ctx = document.getElementById("canvas").getContext("2d");
		window.myBar = new Chart(ctx).Bar(barChartData, {
			responsive : true
		});
		
		var ctx = document.getElementById("chart-area").getContext("2d");
		window.myPie = new Chart(ctx).Pie(pieData,{
			responsive : true
		});		
	}

@stop

@section('includejs')
	<script type="text/javascript" src="{{url('assets/global/plugins/chartjs/Chart.js')}}"></script>
@stop