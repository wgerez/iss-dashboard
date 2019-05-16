@extends('layouts.informes.contenedor')

@section('cuerpo')
<p align="right">Fecha de Impresión: {{date('d/m/Y')}} - {{Auth::user()->usuario}}</p>
  <h3><center>Control de Accesos</center></h3>
  <h4>Desde: {{$fechadesde}} al {{$fechahasta}}.</h4>
  <table class="collapse">
    <thead>
      <tr>
        <td><strong><center>Código</center></strong></td>
        <td><strong><center>Apellido y Nombre</center></strong></td>
        <td><strong><center>Dias</center></strong></td>
        <td><strong><center>Entrada</center></strong></td>
        <td><strong><center>Salida</center></strong></td>
        <td><strong><center>Hs. Cumplidas</center></strong></td>
      </tr>
    </thead>
    <tbody>
        @if (isset($resultados))
          @foreach ($resultados as $resultado)
            @if ($resultado['i'] == 0)
              <tr>
                <td><center>{{ $resultado['persona_id'] }}</center></td>
                <td><center>{{ $resultado['apellido_nombre'] }}</center></td>
                <td><center>{{ $resultado['dia'] }}</center></td>
                <td><center>{{ $resultado['entrada'] }}</center></td>
                <td><center>{{ $resultado['salida'] }}</center></td>
                <td><center>{{ $resultado['horascumplidas'] }}</center></td>
              </tr>
            @else
              <tr>
                <td><center></center></td>
                <td><center></center></td>
                <td><center>{{ $resultado['dia'] }}</center></td>
                <td><center>{{ $resultado['entrada'] }}</center></td>
                <td><center>{{ $resultado['salida'] }}</center></td>
                <td><center>{{ $resultado['horascumplidas'] }}</center></td>
              </tr>
            @endif

            @if (!$resultado['totalhoras'] == '')
              <tr>
                <td><center><strong>TOTAL</strong></center></td>
                <td><center></center></td>
                <td><center></center></td>
                <td><center></center></td>
                <td><center></center></td>
                <td><center><strong>{{ $resultado['totalhoras'] }}</strong></center></td>
              </tr>
            @endif
          @endforeach
        @endif
    </tbody>          
  </table>
@stop
