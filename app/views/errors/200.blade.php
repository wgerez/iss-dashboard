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
						 200
					</div>
					<div class="details">
						<h3>Oops! Ha ocurrido un error de sistema.</h3>
						<p>
							<a href="{{url('/')}}"> Ir al inicio </a>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- FIN -->

@stop
