<table>
	@foreach ($arrOrganizacion as $organizacion)
	    <tr>
		    <td>
		    	<a href='organizacions/{{$organizacion->id}}'>
		    	    {{ $organizacion->id }}
		    	</a>
		    <td>
		    <td>{{ $organizacion->nombre }}<td>
		    <td>{{ $organizacion->razon_social }}<td>
			<td>
		        {{ Form::open(array('url' => 'organizacions/' . $organizacion->id, 'class' => 'pull-right')) }}
					{{ Form::hidden('_method', 'DELETE') }}
					{{ Form::submit('Borrar', array('class' => 'btn btn-warning')) }}
				{{ Form::close() }}
			</td>
		</tr>
	@endforeach
</table>