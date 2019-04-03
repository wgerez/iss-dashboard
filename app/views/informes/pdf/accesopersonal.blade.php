@extends('layouts.informes.contenedor')

@section('cuerpo')
<p align="right">Fecha de Impresión: {{date('d/m/Y')}} - {{Auth::user()->usuario}}</p>
  <h3><center>Informe de Accesos de Personal</center></h3>
  <?php
  if ($filtro == 'N° Documento') { ?>
    <h4>DNI: {{$txtalumno}}</h4> <?php
  } elseif ($filtro == 'Usuario') { ?>
    <h4>Usuario: {{$txtalumno}}</h4> <?php
  } elseif ($filtro == 'Apellido') { ?>
    <h4>Apellido: {{$txtalumno}}</h4> <?php
  } elseif ($filtro == 'Nombre') { ?>
    <h4>Nombre: {{$txtalumno}}</h4> <?php
  } else { ?>
    <h4>{{$filtro}}</h4> <?php
  }
  ?>
  
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
          @endforeach
        @endif
        <?php
        /*if (!$mesa == '') {
          $mesaseguir = $mesa + 1;
          $mespagocuotafins = $mespagocuotafin + 1;

          for ($i=$mesaseguir; $i < $mespagocuotafins; $i++) { */
          ?>
          <!--tr>
            <td><center></center></td>
            <td><center></center></td>
            <td><center></center></td>
            <td><center></center></td>
            <td><center></center></td>
            <td><center></center></td>
            <td><center></center></td>
            <td><center></center></td>
          </tr-->
          <?php /*}
        } */?>
    </tbody>          
  </table>
@stop
