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

	(isset($organizacionseleccionada)) ? $orgid = $organizacionseleccionada : $orgid = null;
	(isset($carreraseleccionada)) ? $carrid = $carreraseleccionada : $carrid = null;
	(isset($filtroseleccionado)) ? $filtroseleccionado = $filtroseleccionado : $filtroseleccionado = 0;
	(isset($filtrografico)) ? $filtrografico = $filtrografico : $filtrografico = 'Torta';
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
					Informes <small>Porcentaje de alumnos becados</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="{{url('informes/alumnos')}}">Alumnos</a>
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
								<i class="fa fa-users"></i>Informe de Alumnos Becados
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
								{{ Form::open(array('url'=>'alumnos/buscarbecadosactivos', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmAlumnos', 'name'=>'FrmAlumnos'))}}
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
									<label class="col-md-3 control-label" for="becados">Cantidad Alumnos Becados:</label>
									<div class="col-md-2">
										<!--input type="text" class="form-control" id="becados" name="becados" value="" -->
										<label id ="becados"></label>
										<span class="help-block"></span>
									</div>
									<label class="col-md-3 control-label" for="activos">Cantidad Alumnos Activos:</label>
									<div class="col-md-2">
										<!--input type="text" class="form-control" id="activos" name="activos" value="" -->
										<label id ="activos"></label>
										<span class="help-block"></span>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label" for="filtro">Tipo de Gráfico:</label>
									<div id="divgrafico" class="col-md-3">
										<select name="filtrografico" id="filtrografico" class="table-group-action-input form-control">
											<option @if($filtroseleccionado==0) {{'selected'}} @endif value="0">Seleccionar</option>
											<option @if($filtroseleccionado==1) {{'selected'}} @endif value="1">Torta</option>
											<option @if($filtroseleccionado==2) {{'selected'}} @endif value="2">Barra</option>
											<option @if($filtroseleccionado==3) {{'selected'}} @endif value="3">Lineal</option>
										</select>
									</div>									
									
										<div id="divbtnImprimir" class="col-md-2 col-sm-2">
											<a href="#" id="imprimir" class="btn btn-success"><i class="fa fa-print"></i> Imprimir Listado</a>
										</div>
										<div id="divbtnImprimir1" class="col-md-2 col-sm-2">
											<a href="#" id="imprimir1" class="btn btn-success"><i class="fa fa-print"></i> Imprimir Gráfico</a>
										</div>
								</div>
								<br>
								{{ Form::close() }}
							</div>
						
							<div id="divtorta" class="col-md-6 col-sm-6" @if($filtroseleccionado!=1) style="display: none" @endif>
								<!-- BEGIN PORTLET-->
								<div class="portlet solid grey-cararra bordered">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa"></i> Cantidad de Alumnos Becados y Activos
										</div>
									</div>
									<div class="portlet-body">
										<center><div id="container" height="90"></div></center>
									</div>
								</div>
								<!-- END PORTLET-->
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
$('#divbtnImprimir').hide();
$('#divbtnImprimir1').hide();

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
	
	$('#carrera').select2({
		placeholder: "Seleccione",
		allowClear: true
	});	

	$('#organizacion, #carrera').on('change', function(){
		$('#divbtnImprimir').hide();
		$('#divbtnImprimir1').hide();
	});

	$('#organizacion').combodinamico("{{url('alumnos/obtenercarrera/')}}", $('#carrera'));

	$('#carrera').change(function() {
		$('#divtorta').hide();

		$.ajax({
		  url: "{{url('alumnos/obtenercantida')}}",
		  data:{'carrera_id': $('#carrera').val()},
		  type: 'POST'
		}).done(function(becados) {
			console.log(becados);

			if (becados.length == 0) {
				alert('No se ha encontrado Alumnos con Beca');
				return;
			}

			$('#divbtnImprimir').show();
			$('#filtrografico > option[value="0"]').attr('selected', 'selected');

			$.each(becados, function(key, value) {
				$('#becados').text(value.becados);
				$('#activos').text(value.activos);
			});
		}).error(function(data) {
			console.log(data);
		});
	});

	$('#imprimir').on('click', function(e){
		e.preventDefault();
		window.open("{{url('alumnos/pdfactivosbecadosporcarrera')}}?carrera=" + $('#carrera').val());
	});
/*
    $('#imprimir').click(function () {
        var chart = $('#container').highcharts();
        chart.exportChart({
            type: 'application/pdf',
            filename: 'columnas-alumnos'
        });
    });
*/
    $('#imprimir1').click(function () {
        /*var chart = $('#container').highcharts();
        chart.renderer.image('http://qa.iss.formosa/assets/global/img/membretecontrato.png',6,-10,560,70).add();
        chart.print();
        chart.setTitle({text: '.'}, {text: '.'});*/
        var clone = $('#container').clone().get(0);

		var printWindow = window.open('', '_blank');
		printWindow.document.write(printWindow.document.body.innerHTML += clone.outerHTML +"<center><h3>Cantidad de alumnos becados y Activos</h3></center>");
		printWindow.document.close();
		printWindow.print();
		printWindow.close();
    });

	$('#filtrografico').on('change', function(){
		$('#divbtnImprimir1').show();
		if ($('#carrera').val() == 0) return;
		if ($(this).val()==2)
		{
			$('#divtorta').show();

			$.ajax({
			  url: '{{url('alumnos/barragrafico')}}',
			  data:{'carrera_id': $('#carrera').val()},
			  type: 'POST'
			}).done(function(barra) {
				console.log(barra);
				
				$.each(barra, function(key, barr) {
					
					$(function () {
					    $('#container').highcharts({
					        chart: {type: 'column',
					        	events: {
					                load: function(event) {
					                	this.renderer.image('http://qa.iss.formosa/assets/global/img/membretecontrato.png',6,-10,560,70).add();
					                }
					            }
            				},
							title: {text: '.', align: 'left', x: 55},
							subtitle: {text: '.', align: 'left', x: 55},
							xAxis: {type: 'category'},
							yAxis: {title: {text: 'Cantidad de Alumnos'}},
							legend: {enabled: false},
							tooltip: {pointFormat: 'Cantidad de Alumnos: <b>{point.y}</b>'},
			                credits: {enabled: false},
							plotOptions: {
							    series: {
			                        borderWidth: 0,
			                        dataLabels: {
			                            enabled: true,
			                            format: '{point.y}'
			                        }
			                    }
			                },
							exporting: {enabled: false},
					        series: [{name: 'Alumnos',
								data: [
									['Alumnos Becados', barr.becados], ['Alumnos Activos', barr.activos]
								]
							}]
					    });
					});

				});

			}).error(function(data) {
				console.log(data);
			});
		}
		else if ($(this).val()==3)
		{
			$('#divtorta').show();

			$.ajax({
			  url: '{{url('alumnos/barragrafico')}}',
			  data:{'carrera_id': $('#carrera').val()},
			  type: 'POST'
			}).done(function(barra) {
				console.log(barra);
				
				$.each(barra, function(key, barr) {
					
					$(function () {
					    $('#container').highcharts({
					        chart: {
					            backgroundColor: {
					                linearGradient: [0, 0, 0, 300],
					                stops: [
					                    [0, '#FFFFFF'],
					                    [1, '#E0E0E0']
					                ]
					            },
					        	events: {
					                load: function(event) {
					                	this.renderer.image('http://qa.iss.formosa/assets/global/img/membretecontrato.png',6,-10,560,70).add();
					                }
					            }
					        },
					        title: {text: '.', align: 'left', x: 55},
							subtitle: {text: '.', align: 'left', x: 55},
					        credits: {enabled: false},
					        legend: {enabled: false},
					        xAxis: {categories: ['Becados', 'Activos']},
					        yAxis: {min: 0,
								title: {
									text: 'Cantidad de Alumnos'
								}
							},
					        series: [{name: 'Cantidad de Alumnos',
					            data: [barr.becados, barr.activos]
					        }],
					        navigation: {
					            buttonOptions: {
					                enabled: false
					            }
					        }
					    });
					});

				});

			}).error(function(data) {
				console.log(data);
			});

		}
		else if ($(this).val()==1)
		{
			$('#divtorta').show();

			$.ajax({
			  url: '{{url('alumnos/porcengrafico')}}',
			  data:{'carrera_id': $('#carrera').val()},
			  type: 'POST'
			}).done(function(porcent) {
				console.log(porcent);
				var datos='';

				$.each(porcent, function(key, porc) {
					Highcharts.getOptions().plotOptions.pie.colors = (function () {
						var colors = [],
							base = '#4D90AB',//Highcharts.getOptions().colors[0],
							i;

						for (i = 0; i < 10; i += 1) {
							colors.push(Highcharts.Color(base).brighten((i - 1) / 6).get());
						}
						return colors;
					}());

					$(function () {
					    $('#container').highcharts({
					        chart: {plotBackgroundColor: null,
					            plotBorderWidth: null,
					            plotShadow: false,
					        	events: {
					                load: function(event) {
					                	this.renderer.image('http://qa.iss.formosa/assets/global/img/membretecontrato.png',6,-10,560,70).add();
					                }
					            }
					        },
					        title: {text: '.', align: 'left', x: 55},
							subtitle: {text: '.', align: 'left', x: 55},
					        tooltip: {pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'},
					        credits: {enabled: false},
					        plotOptions: {
					            pie: {
					                allowPointSelect: false,
					                cursor: 'pointer',
					                dataLabels: {
					                    enabled: true,
					                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
					                    style: {
					                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
					                    }
					                }
					            }
					        },
					        series: [{
					            type: 'pie',
					            name: 'Porcentaje de Alumnos',
					            data: [
					                ['Becados', porc.becados], ['Activos', porc.activos]
					            ]
					        }],
					        navigation: {
					            buttonOptions: {
					                enabled: false
					            }
					        }
					    });
					});
				});

			}).error(function(data) {
				console.log(data);
			});

		} else if ($(this).val()==0)
		{
			$('#divtorta').hide();
			$('#divbtnImprimir1').hide();
		}
	});


@stop


@section('includejs')
	<script type="text/javascript" src="{{url('assets/global/plugins/select2/select2.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/Highcharts/js/highcharts.js')}}"></script>
	<script type="text/javascript" src="{{url('assets/global/plugins/Highcharts/js/modules/exporting.js')}}"></script>

	<script src="{{url('assets/admin/pages/scripts/table-advanced.js')}}"></script>
	<script src="{{url('assets/admin/pages/scripts/helpers/jquery.combodinamico.js')}}" type="text/javascript"></script>
@stop
