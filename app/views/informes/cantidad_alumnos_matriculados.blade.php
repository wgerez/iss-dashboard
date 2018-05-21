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
					Informes <small>Cantidad de Alumnos Matriculados por Ciclo Lectivo</small>
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
							<a href="{{url('informes/alumnos')}}">Informes</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">Matriculados por Ciclo Lectivo</a>
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
								<i class="fa fa-files-o"></i>Cantidad de Alumnos Matriculados por Ciclo Lectivo
							</div>
						</div>
						<div class="portlet-body form">
							<div class="form-body">
								{{ Form::open(array('url'=>'matriculas/listadoalumnos', 'class'=>'form-horizontal form-row-seperated', 'id'=>'FrmListadoalumnos', 'name'=>'FrmListadoalumnos'))}}
								<div class="form-group">
									<label  class="col-md-2 col-sm-2 control-label">Organización:</label>
									<div class="col-md-6 col-sm-6">
										{{ Form::select('cboOrganizacion', $organizaciones, Input::old('organizacion'), array('class'=>'table-group-action-input form-control','id'=>'cboOrganizacion')); }}
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 col-sm-2 control-label" for="filtro">Ciclo Lectivo:</label>
									<div class="col-md-3 col-sm-3">
										<select name="cboCiclo" id="cboCiclo" class="table-group-action-input form-control">
										</select>
									</div>
									<div class="col-md-2 col-sm-2">
										<a class="btn btn-primary" id='btnBuscar'><i class="fa fa-search"></i> Buscar</a>
									</div>
									<div id="divbtnImprimir2" class="col-md-2 col-sm-2">
										<a href="#" id="imprimir2" class="btn btn-success"><i class="fa fa-print"></i> Imprimir</a>
									</div>
								</div>

								<div id="filtrogra">
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
											<a href="#" id="imprimir" class="btn btn-success"><i class="fa fa-print"></i> Generar Gráfico</a>
										</div>
										<div id="divbtnImprimir1" class="col-md-2 col-sm-2">
											<a href="#" id="imprimir1" class="btn btn-success"><i class="fa fa-print"></i> Imprimir Gráfico</a>
										</div>
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
											<i class="fa"></i> Cantidad de Alumnos Matriculados
										</div>
									</div>
									<div class="portlet-body">
										<center><div id="container" height="90"></div></center>
									</div>
								</div>
								<!-- END PORTLET-->
							</div>

							<table class="table table-striped table-bordered table-hover" id="table_matriculas">
								<thead>
								<tr>
									<th>
										<center><i class="fa fa-files-o"></i>Ciclo</center>
									</th>
									<th>
										<center><i class="fa fa-users"></i>Cantidad de Alumnos</center>
									</th>
									<th><center>Porcentaje</center></th>
								</tr>
								</thead>
								
								<tbody>
								
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

@stop


@section('customjs')
	TableAdvanced.init();

	$('#divbtnImprimir').hide();
	$('#divbtnImprimir1').hide();
	$('#divbtnImprimir2').hide();

	$('#cboOrganizacion').select2({
		placeholder: "Seleccione",
		allowClear: true
	});

	$('#imprimir2').on('click', function(e){
		e.preventDefault();
		if ($('#cboCiclo').val()==0) {
			window.open("{{url('alumnos/informematriculadospdf')}}?ciclo_lectivo=" + $('#cboCiclo').val() + "&organizacion=" + $('#cboOrganizacion').val());
		} else {
			window.open("{{url('alumnos/pdfalumnosmatriculadosporanio')}}?ciclo_lectivo=" + $('#cboCiclo').val());
		}
	});

	$('#imprimir').click(function () {
        var chart = $('#container').highcharts();
        chart.exportChart({
            type: 'application/pdf',
            filename: 'columnas-alumnos'
        });
    });

    $('#imprimir1').click(function () {
        var clone = $('#container').clone().get(0);

		var printWindow = window.open('', '_blank');
		printWindow.document.write(printWindow.document.body.innerHTML += clone.outerHTML +"<center><h3>Cantidad de alumnos Matriculados</h3></center>");
		printWindow.document.close();
		printWindow.print();
		printWindow.close();
    });

    $('#btnBuscar').click(function() {

    	var organizacion = $('#cboOrganizacion').val();
    	var ciclo = $('#cboCiclo').val();

    	if (organizacion == 0) {
    	    alert('Debe seleccionar todos los datos a buscar');
    	    return;
    	}

    	if ($('#cboCiclo').val() == 0) {
        	$('#filtrogra').show();
        	$('#divtorta').hide();
        } else {
        	$('#filtrogra').hide();
        	$('#divtorta').hide();
        }

        $('#filtrografico > option[value="0"]').attr('selected', 'selected');

    	limpiar_tabla();

			$.ajax({
			  url: '{{url('alumnos/obtenermatriculaporciclo')}}',
			  data:{'organizacion': organizacion, 'ciclo': ciclo},
			  type: 'POST'
			}).done(function(matriculas) {
				console.log(matriculas);
				
						$('#divbtnImprimir2').show();
						var total = 0;
						var porcenta = 0;
						$.each(matriculas, function(key, matricula) {
							$('#table_matriculas > tbody').append(
							    '<tr>' +
							    '<td>' + matricula.descripcion + '</td>' +
							    '<td>' + matricula.cantidad + '</td>' +
							    '<td>' + matricula.porcentaje + ' % </td>' +
							    '</tr>'
							);
							total = total + matricula.cantidad;
							porcenta = porcenta + matricula.porcentaje;
						});

						$('#table_matriculas > tbody').append(
							'<tr class=info>' +
						    '<td>' + 'Total:' + '</td>' +
						    '<td>' + total + '</td>' +
						    '<td>' + porcenta + ' % </td>' +
						    '</tr>'
						);

			}).error(function(data) {
				console.log(data);
			});
    });

    $('#cboCiclo').click(function() {

		limpiar_tabla();

		if ($('#cboCiclo').val() == 0) {
        	$('#filtrogra').hide();
        	$('#divtorta').hide();
        } else {
        	$('#filtrogra').hide();
        	$('#divtorta').hide();
        }
    });

    $('#cboOrganizacion').change(function() {
    	// 1 - limpiar todo

    	limpiar_tabla();
		$('#cboCiclo').children().remove().end();

		if ($('#cboOrganizacion').val() == 0) return;

		$.ajax({
		  url: '{{url('ciclolectivo/obtenercicloslectivos')}}',
		  data:{'organizacion_id': $('#cboOrganizacion').val()},
		  type: 'POST'
		}).done(function(ciclos) {
			console.log(ciclos);
			if (ciclos == <?php echo CicloLectivoController::NO_EXISTE_CICLO ?>) {
				alert('La Organización no tiene Ciclos Lectivos Asignados');
				return;
		    }

			$('#cboCiclo').append(
		        $('<option></option>').val(0).html('Todos los años')
		    );

			$.each(ciclos, function(key, value) {
				$('#cboCiclo').append(
			        $('<option></option>').val(value.id).html(value.descripcion)
			    );
			});
		}).error(function(data) {
			console.log(data);
		});

    });

    function limpiar_tabla() {
	    var n = 0;
		$('#table_matriculas tr').each(function() {
		   if (n > 0) $(this).remove();
		   n++;
		});
    }

    $('#filtrografico').on('change', function(){
		//$('#divbtnImprimir').show();
		$('#divbtnImprimir1').show();
		$('#divbtnImprimir1').show();
		if ($('#carrera').val() == 0) return;
		if ($(this).val()==2)
		{
			$('#divtorta').show();
			
			$.ajax({
			  url: '{{url('alumnos/obtenerciclolectivo')}}',
			  data:{'organizacion': $('#cboOrganizacion').val(), 'ciclo': $('#cboCiclo').val()},
			  type: 'POST'
			}).done(function(ciclos) {
				console.log(ciclos);

				var ciclos = ciclos;

				$.ajax({
				  url: '{{url('alumnos/barralinea')}}',
				  data:{'organizacion': $('#cboOrganizacion').val(), 'ciclo': $('#cboCiclo').val()},
				  type: 'POST'
				}).done(function(barra) {
					console.log(barra);
						
						var datos = [];
					 
						$.each(barra, function(key, barr) {
							var anios = barr.anos;
							var total = barr.total;
							datos.push({
			                    name: anios,
			                    y: total
			                });
						});

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
				                plotOptions: {
				                    series: {
				                        borderWidth: 0,
				                        dataLabels: {
				                            enabled: true,
				                            format: '{point.y}'
				                        }
				                    }
				                },
				                tooltip: {
				                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
				                    pointFormat: 'En <span style="color:{point.color}">{point.name}</span> Cantidad de Alumnos: <b>{point.y}</b><br/>'
				                },
								credits: {enabled: false},
								exporting: {enabled: false},
				                series: [{
				                    name: 'Cantidad de Alumnos Matriculados',
				                    colorByPoint: true,
				                    data: datos
				                }]
				            });
						});

				}).error(function(data) {
					console.log(data);
				});
			}).error(function(data) {
				console.log(data);
			});
		}
		else if ($(this).val()==3)
		{
			$('#divtorta').show();

			$.ajax({
			  url: '{{url('alumnos/obtenerciclolectivo')}}',
			  data:{'organizacion': $('#cboOrganizacion').val(), 'ciclo': $('#cboCiclo').val()},
			  type: 'POST'
			}).done(function(ciclos) {
				console.log(ciclos);

				var ciclos = ciclos;

				$.ajax({
				  url: '{{url('alumnos/barralinea')}}',
				  data:{'organizacion': $('#cboOrganizacion').val(), 'ciclo': $('#cboCiclo').val()},
				  type: 'POST'
				}).done(function(cantidad) {
					console.log(cantidad);
						
						var datos = [];
						var anos = [];
					 
						$.each(cantidad, function(key, cantida) {
							datos.push(cantida.total);
							anos.push(cantida.anos);
						});
					
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
							        xAxis: {categories: anos},
							        yAxis: {min: 0,
										title: {
											text: 'Cantidad de Alumnos'
										}
									},
							        series: [{name: 'Cantidad de Alumnos',
							            data: datos
							        }],
							        navigation: {
							            buttonOptions: {
							                enabled: false
							            }
							        }
							    });
							});

				}).error(function(data) {
					console.log(data);
				});
			}).error(function(data) {
				console.log(data);
			});

		}
		else if ($(this).val()==1)
		{
			$('#divtorta').show();

			$.ajax({
			  url: '{{url('alumnos/obtenerporcen')}}',
			  data:{'organizacion': $('#cboOrganizacion').val(), 'ciclo': $('#cboCiclo').val()},
			  type: 'POST'
			}).done(function(porcent) {
				console.log(porcent);

					var datos = [];
					 
					var chart;
				$.each(porcent, function(key, porc) {
					datos.push({
			                    name: porc.label,
			                    y: porc.value
			                });
				});

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
					    chart = new Highcharts.Chart({
							chart: {renderTo: 'container',
								plotBackgroundColor: null, plotBorderWidth: null,//1,
								plotShadow: false, spacingLeft: 0.1,
					        	events: {
					                load: function(event) {
					                	this.renderer.image('http://qa.iss.formosa/assets/global/img/membretecontrato.png',6,-10,560,70).add();
					                }
					            }
					        },
			                title: {text: '.', align: 'left', x: 60},//margin: 50
							subtitle: {text: '.', align: 'left', x: 57},
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
					            data: datos
					        }],
					        navigation: {
					            buttonOptions: {
					                enabled: false
					            }
					        }
					    });
					});

			}).error(function(data) {
				console.log(data);
			});

		}
		if ($(this).val()==0)
		{
			$('#divtorta').hide();
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
	<script src="{{url('assets/admin/pages/scripts/getFechaImpresion.js')}}"></script>
	<script src="{{url('assets/admin/pages/scripts/primerFechaMayor.js')}}"></script>
	<script src="{{url('assets/admin/pages/scripts/table-advanced.js')}}"></script>
@stop
