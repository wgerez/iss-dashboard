@extends('layouts.informes.contenedor')

@section('cuerpo')
  <h3>Informe de docentes</h3>
  <table class="collapse">
    <thead>
      <tr>
        <th>Apellido y Nombre</th>
        <th>DNI</th>
        <th>Dirección</th>
        <th>Localidad</th>
        <th>Teléfono</th>
        <th>Correo</th>
      </tr>
    </thead>
	<tbody>
		@if (isset($docentes))
			@foreach ($docentes as $docente)
				<!-- RESCATO EL TELEFONO Y EL CORREO -->
				<?php $particular = 'No cargado'; ?>
				<?php $laboral  = 'No Cargado'; ?>
				<?php $correo   = 'No cargado'; ?>
				@foreach ($docente->persona->contactos as $contacto)
					@if ($contacto->id==1)
						<?php $particular = $contacto->pivot->descripcion; ?>
					@elseif ($contacto->id==2)
						<?php $laboral = $contacto->pivot->descripcion; ?>
					@elseif($contacto->id==3)
						<?php $correo = $contacto->pivot->descripcion; ?>
					@endif
				@endforeach											
				<tr>
					<td>{{$docente->persona['apellido'].", ". $docente->persona['nombre']}}</td>
					<td>{{$docente->persona['nrodocumento']}}</td>
					<td>
							@if (empty($docente->persona['barrio']) or ($docente->persona['barrio']==null)) 
								{{'B° no cargado - '}} 
							@else 
								{{$docente->persona['barrio'] . ' - '}} 
							@endif
							@if (empty($docente->persona['calle']) or ($docente->persona['calle']==null)) 
								{{'Calle no cargado - '}} 
							@else 
								{{$docente->persona['calle'] . ' - '}} 
							@endif 
							@if ($docente->persona['numero']==0)
								{{'s/n'}} 
							@else 
								{{$docente->persona['numero']}} 
							@endif
                          @if ($docente->persona['manzana']==0) 
                            {{''}} 
                          @else 
                            {{', Mz: '. $docente->persona['manzana']}} 
                          @endif
                          @if ($docente->persona['departamento']==0) 
                            {{''}} 
                          @else 
                            {{', Dpto: '. $docente->persona['departamento']}} 
                          @endif
					</td>
					<td>{{$docente->persona->localidad['descripcion']}}</td>
					<td>@if ($particular!='No cargado') {{$particular}} @else {{$laboral}} @endif</td>
					<td>{{$correo}}</td>
				</tr>
			@endforeach
		@endif		
	</tbody>        
  </table>
@stop
