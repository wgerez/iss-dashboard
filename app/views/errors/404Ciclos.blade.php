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
						 404
					</div>
					<div class="details">
						<h3>Oops! Parece que estas perdido.</h3>
						<p>
							No tienes persmiso para editar el ciclo o no se ecuentra en la base de datos!!.<br/>
							<a href="{{url('/')}}">
							Ir al inicio </a>
							o buscalo en la <a href="{{ url('ciclolectivo/listado') }}">lista de ciclos.</a>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- FIN -->

@stop
