@extends('layouts.master')

@section('customstyle')
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/select2/select2.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css')}}"/>
<!-- END PAGE LEVEL STYLES -->
<style>
	td.verinfo{ cursor:pointer;}
</style>
@stop
<?php
//BOTONES Y CAMPOS DE PERMISOS
$disabled = (!$editar) ? 'disabled' : '';
$readonly = (!$editar) ? 'readonly' : '';
$imprimir = (!$imprimir) ? 'disabled' : '';
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
					Becas <small>gestión becas</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{url('dashboard')}}">Inicio</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href='#'>Gestión Contable</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">becas</a>
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
					    @if (Session::get('message_type') == BecasController::OPERACION_EXITOSA)

							<div class="note note-success">
								<p> {{ Session::get('message') }} </p>
							</div>
						@elseif (Session::get('message_type') == BecasController::OPERACION_FALLIDA)

							<div class="note note-danger">
								<p> {{ Session::get('message') }} </p>
							</div>

						@endif	
					@endif
					<!-- COMIENZO DE LA TABLA-->
					{{ Form::open(array('url'=>'becas/guardar','class'=>'form-horizontal form-row-seperated', 'id'=>'FrmBecas', 'name'=>'FrmBecas'))}}
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-copy"></i> Beca
							</div>
							<div class="actions">
								<button {{$disabled}} type='submit' id='btnGuardar' class="btn default green-stripe">
								<i class="fa fa-save"></i>
								<span class="hidden-480">
								Guardar </span>
								</button>
								<!--a href="becas/gestionar" class="btn default yellow-stripe">
								<i class="fa fa-reorder"></i>
								<span class="hidden-480">
								Nuevo </span></a-->
							</div>

						</div>
						<div class="portlet-body form">
								<div class="form-body">

									<div class="form-group">
										<label  class="col-md-2 col-sm-2 control-label">DNI Alumno:</label>
										<div class="col-md-4 col-sm-4">
											<input class="form-control" name="txtalumno" id="txtalumno" type="text" value="{{ $alumno->nrodocumento }}">
										</div>
										<div class="col-md-2 col-sm-2">
											<a class="btn blue-madison" id='btnBuscarAlumno'>
												<i class="fa fa-search"></i> Buscar
											</a>
										</div>										
									</div>


								</div>
						</div> <!-- FIN PORTLET-BODY -->
					</div>
					

					<br>

					<div class="portlet form-horizontal">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-user"></i>Datos del Alumno
							</div>
						</div>

						<input class="form-control" type='hidden' name='txt_alumno_id' id='txt_alumno_id' value='{{ $alumno->alumno_id }}'>
						<input class="form-control" type='hidden' name='txt_pagado_id', id='txt_pagado_id' value='{{ $alumno->alumno_id }}'>

						<div class="portlet-body form">
							<div class="form-group">
								<label  class="col-md-2 col-sm-2 control-label text-info">Alumno:</label>
								<div class="col-md-2 col-sm-4" id='divAlumno'><p class="form-control-static">{{$alumno->apellido}}, {{$alumno->nombre}} </p></div>
								<label  class="col-md-2 col-sm-2 control-label text-info">DNI:</label>
								<div class="col-md-2 col-sm-4" id='divDNI'><p class="form-control-static">{{$alumno->nrodocumento}} </p></div>								
							</div>

							<div class="form-group">
								<label  class="col-md-2 col-sm-2 control-label text-info">Dirección:</label>
								<div class="col-md-10 col-sm-10" id='divDomicilio'><p class="form-control-static">{{$alumno->calle}} {{$alumno->numero}} ({{$alumno->localidad}}, {{$alumno->provincia}}) </p></div>
							</div>
							<!--<div class="form-group">
								<label  class="col-md-2 col-sm-2 control-label text-info">N° Cuenta:</label>
								<div class="col-md-10 col-sm-10">
									<p class="form-control-static">0000</p>
								</div>
							</div>-->
						</div>

						<br>

						<div class="portlet">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-list"></i>Hist&oacute;rico de Becas
								</div>
							</div>

							<div class="portlet-body">
								<div class="table-scrollable">
									<table class="table table-hover" id='tableBecas'>
									<thead>
									<tr>
										<th>Ciclo Lectivo</th>
										<th>Carrera</th>
										<th>Inicio</th>
										<th>Fin</th>
										<th>Acciones</th>										
									</tr>
									</thead>
									<tbody>
										@if (isset($historial_becas))
											@foreach ($historial_becas as $historial_beca)
												<?php
												$meses = ['Seleccionar', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
												$fechaInicioBeca = $historial_beca->becafechainicio;
											    list($dia, $mes, $anio) = explode('/', $fechaInicioBeca);
											    $mes = (string)(int)$mes;
											    $beca_inicio = $meses[''.$mes.''] . ' ' . $anio;

											    $fechaFinBeca = $historial_beca->becafechafin;
											    list($dia1, $mes1, $anio1) = explode('/', $fechaFinBeca);
											    $mes1 = (string)(int)$mes1;
											    $beca_fin = $meses[''.$mes1.''] . ' ' . $anio1;

											    $fechamostrar = $anio1 . '-' . $mes1 . '-' . $dia1;
											    $fecha_actual = date('Y-m-d');

												if (strtotime($fechamostrar) > strtotime($fecha_actual)) {
													$tr_class = '<tr class=success>';
													$td_acciones = "<td><a {{$disabled}} title='Finalizar Beca' class='btn default btn-xs blue' href='finalizar/" . $historial_beca->beca_id ."'><i class='fa fa-bitbucket'></i></a><a title='Eliminar Beca' @if (!$eliminar) {{'DISABLED'}} @endif class='btn default btn-xs red' href='eliminar/" . $historial_beca->beca_id ."'><i class='fa fa-trash-o'></i></a></td>";
											    } else {
											    	$tr_class = '<tr class=danger>';
											    	$td_acciones = '<td><i class="fa fa-arrow-circle-down" title="Beca Finalizada"></i></td>';
												}

												
												    echo $tr_class .
												    '<td>' . $historial_beca->ciclo_descripcion . '</td>' .
												    '<td>' . $historial_beca->carrera . '</td>' .
												    '<td>' . $beca_inicio . '</td>' .
												    '<td>' . $beca_fin . '</td>' .
												    $td_acciones .
												    '</tr>';
												?>
											@endforeach
										@endif
									</tbody>
								    </table>
							    </div>
						    </div>
						</div>

						<br>

						<div class="portlet">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-list"></i>Asignar Becas
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-2 col-sm-2 control-label" for="filtro">Ciclo Lectivo:</label>
								<div class="col-md-2 col-sm-3">
									<select name="cboCiclo" id="cboCiclo" class="table-group-action-input form-control">
										<option value="">Seleccione</option>
										<?php for ($i=0; $i < count($ciclos); $i++) { ?>
											<option value="{{$ciclos[$i]['ciclolectivo_id']}}" <?php if($ciclos[$i]['ciclolectivo_id'] === $becas->ciclolectivo_id) { echo "selected=selected";}?>>
												{{$ciclos[$i]['ciclo']}}
											</option>
										<?php } ?>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label  class="col-md-2 col-sm-2 control-label">Carrera:</label>
								<div class="col-md-6 col-sm-10">
									<select class="table-group-action-input form-control" name="cboCarrera" id="cboCarrera">
										<option value="0">Seleccione</option>
										@foreach ($carreras as $carrera)
											<option value="{{$carrera->inscripcion_id}}" <?php if($carrera->inscripcion_id === $becas->inscripcion_id) { echo "selected=selected";}?>>
												{{$carrera->carrera}}
											</option>
										@endforeach
									</select>
								</div>
							</div>
							
							<div class="form-group" id='divAsignarBeca'>

								<!--<label class="col-md-2 col-sm-2 control-label">
									<div class="checker">
										<span>
											<input id="becado" name="becado" type="checkbox" checked="" >
										</span>
									</div> 
									Asignar Beca
								</label>-->
								
								<label  class="col-md-2 col-sm-2 control-label">Desde:</label>
								<div class="col-md-2 col-sm-2">
									<select name='cboMesInicioBeca' id='cboMesInicioBeca' class="form-control" {{$disabled}}>
										<?php 
											for ($i=0; $i < count($meses); $i++) {
												?><option value="<?php echo $i; ?>" <?php if ($i == $mesinicio) echo "selected=selected"; ?>><?php echo $meses[$i]; ?></option><?php
											}
										?>
									</select>
								</div>

								<label  class="col-md-2 col-sm-2 control-label">Hasta:</label>
								<div class="col-md-2 col-sm-2">
									<select name='cboMesFinBeca' id='cboMesFinBeca' class="form-control" {{$disabled}}>
										<?php 
											for ($i=0; $i < count($meses); $i++) {
												?><option value="<?php echo $i; ?>" <?php if ($i == $mesfin) echo "selected=selected"; ?>><?php echo $meses[$i]; ?></option><?php
											}
										?>
									</select>
								</div>

							</div>



						</div>

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
	ComponentsFormTools.init();

	var mes = [
	    'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo',
	    'Junio', 'Julio', 'Agosto', 'Septiembre',
	    'Octubre', 'Noviembre', 'Diciembre'
	];

	function buscar_alumno() {
		borrar_datos_alumno();
		limpiar_tabla_becas();

		/* VALIDACIONES DEL BOTON BUSCAR */
	    if ($.trim($('#txtalumno').val()) == '') {
	    	alert('Ingrese el dato del Alumno');
	    	return;
	    }

	    url_destino = "{{url('alumnos/obteneralumnopordni')}}";

	    /* OBTENGO EL ALUMNO */
		$.ajax({
		  url: url_destino,
		  data:{'txt_alumno': $('#txtalumno').val()},
		  type: 'POST'
		}).done(function(alumno) {
			console.log(alumno);
			if (alumno == <?php echo AlumnosController::NO_EXISTE_ALUMNO ?>) {
				alert('No se ha encontrado ningún registro');
				return;
		    }

		    var alumno_id = alumno.alumno_id;
		    var apellido_nombre = alumno.apellido + ', ' + alumno.nombre;
		    var dni = alumno.nrodocumento;
		    var domicilio = alumno.calle + ' ' + alumno.numero + ' (' + alumno.localidad + ', ' + alumno.provincia + ')';
		    $('#divAlumno').html('<p class="form-control-static">' + apellido_nombre + '</p>');
		    $('#divDNI').html('<p class="form-control-static">' + dni + '</p>');
		    $('#divDomicilio').html('<p class="form-control-static">' + domicilio + '</p>');

		    $('#txt_alumno_id').val(alumno_id);
		    //$('txt_persona_id').val(alumno.persona_id);

		    /* OBTENGO HISTORIAL DE BECAS */
			$.ajax({
			  url: '{{url('becas/obtenerhistorial')}}',
			  data:{'alumno_id': alumno.alumno_id},
			  type: 'POST'
			}).done(function(becas) {
				console.log(becas);

				var fecha = new Date();
				var fecha_actual = fecha.getDate() + "/" + (fecha.getMonth() +1) + "/" + fecha.getFullYear();

				$.each(becas, function(key, value) {

				    fechaInicioBeca = getFechaImpresion(value.becafechainicio);
				    arrBecaFechaInicio = fechaInicioBeca.split('/');
				    beca_inicio = mes[arrBecaFechaInicio[1] - 1] + ' ' + arrBecaFechaInicio[2];

				    fechaFinBeca = getFechaImpresion(value.becafechafin);
				    arrBecaFechaFin = fechaFinBeca.split('/');
				    beca_fin = mes[arrBecaFechaFin[1] - 1] + ' ' + arrBecaFechaFin[2];

					if (primerFechaMayor(fechaFinBeca, fecha_actual)) {
						tr_class = '<tr class=success>';
						td_acciones = "<td><a {{$disabled}} title='Finalizar Beca' class='btn default btn-xs blue' href='finalizar/" + value.beca_id +"'><i class='fa fa-bitbucket'></i></a><a title='Eliminar Beca' @if (!$eliminar) {{'DISABLED'}} @endif class='btn default btn-xs red' href='eliminar/" + value.beca_id +"'><i class='fa fa-trash-o'></i></a></td>";
				    } else {
				    	tr_class = '<tr class=danger>';
				    	td_acciones = '<td><i class="fa fa-arrow-circle-down" title="Beca Finalizada"></i></td>';
					}

					$('#tableBecas > tbody').append(
					    tr_class +
					    '<td>' + value.ciclo_descripcion + '</td>' +
					    '<td>' + value.carrera + '</td>' +
					    '<td>' + beca_inicio + '</td>' +
					    '<td>' + beca_fin + '</td>' +
					    td_acciones +
					    '</tr>'
					);
				});

			}).error(function(data) {
				console.log(data);
			});

            /* OBTENGO CARRERAS A LAS QUE ESTA INCRITO EL ALUMNO */
			$.ajax({
			  url: '{{url('matriculas/obtenercarrerasinscripciones')}}',
			  data:{'alumno_id': alumno.alumno_id},
			  type: 'POST'
			}).done(function(carreras) {
				console.log(carreras);

				$('#cboCarrera').append(
			        $('<option></option>').val(0).html('Seleccionar')
			    );
				
				$.each(carreras, function(key, value) {
					$('#cboCarrera').append(
				        $('<option></option>').val(value.inscripcion_id).html(value.carrera)
				    );
				});
			}).error(function(data) {
				console.log(data);
			});

		//OBTENGO CICLOS LECTIVOS DESDE INSCRIPCION
		$.ajax({
		  url: '{{url('cuotas/obtenercicloinscripciones')}}',
		  data:{'alumno_id': $('#txt_alumno_id').val()},
		  type: 'POST'
		}).done(function(ciclos) {
			console.log(ciclos);
			$('#cboCiclo').removeAttr("disabled");
	 		$('#cboCiclo').children().remove().end();

	 		$('#cboCiclo').append(
		        $('<option></option>').val(0).html('Seleccionar')
		    );

			$.each(ciclos, function(key, value) {
				$('#cboCiclo').append(
			        $('<option></option>').val(value.ciclolectivo_id).html(value.ciclo)
			    );
			});

		}).error(function(data) {
			console.log(data);
		});

		}).error(function(data) {
			console.log(data);
		});

	}

    /* DESHABILITO EL ENTER EN EL CONTROL */
	$('#txtalumno').keypress(function(e) {
	    if (e.which == 13) {
	        buscar_alumno();
	        return false;
	    }
	});

    function limpiar_tabla_becas() {
	    var n = 0;
		$('#tableBecas tr').each(function() {
		   if (n > 0) $(this).remove();
		   n++;
		});
    }

	function borrar_datos_alumno() {
		 $('#divAlumno').html('');
		 $('#divDNI').html('');
		 $('#divDomicilio').html('');
		 $('#cboCarrera').children().remove().end();
	}

	$('#btnBuscarAlumno').live('click', function() {
		buscar_alumno();
	});

@stop

@section('includejs') 
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{url('assets/global/plugins/select2/select2.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/global/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js')}}"></script>
<script type="text/javascript" src="{{url('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js')}}"></script>
<script src="{{url('assets/admin/pages/scripts/components-form-tools.js')}}"></script>
<script src="{{url('assets/admin/pages/scripts/getFechaImpresion.js')}}"></script>
<script src="{{url('assets/admin/pages/scripts/primerFechaMayor.js')}}"></script>
<!-- END PAGE LEVEL PLUGINS -->
@stop
