@extends('layouts.master')

@section('customstyle')
<link href="{{url('assets/admin/pages/css/error.css')}}" rel="stylesheet" type="text/css"/>
@stop 

@section('content')
	<!-- COMIENZO CONTENIDO -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="row">
				<div class="col-md-12 page-404">
					<div class="number">
						 Contratos
					</div>
					<br>
					<div class="details">
						<h3>Ha ocurrido un error al intentar generar el contrato.</h3>
						<h4>Verifique los siguientes datos:</h4>
						@foreach ($errores as $error)
							<p>
								{{$error}}
							</p>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- FIN -->

@stop
