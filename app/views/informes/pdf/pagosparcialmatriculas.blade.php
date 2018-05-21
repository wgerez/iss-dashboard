@extends('layouts.informes.contenedor')

@section('cuerpo')
  <center><h3>Informe Pago Parcial de matrícula</h3></center>
  <?php
  $totalparcial = 0;
  $totalsaldo = 0;
  $apeynom = '';
/*highlight_string(var_export($todomovimiento, true));
        exit();*/
?>
<p align="right">Fecha de Impresión: {{$fechahoy}}</p>
<h3>Carrera: {{$carrera->carrera}}</h3>
<?php if ($filtroalumno == 1) {
  if (isset($todomovimiento)) {
    foreach ($todomovimiento as $value) {
      $apeynom = $value['apeynom'];
    }
  }
  echo "<h3>Apellido y Nombre: {$apeynom}</h3>";
} ?>
<h3>Desde: {{$fechadesdes}} - Hasta: {{$fechahastas}}</h3>
  <table class="collapse">
    <thead>
      <tr>
        <td><center><strong>Apellido y Nombre</strong></center></td>
        <td><center><strong>N° Documento</strong></center></td>
        <td><center><strong>Importe</strong></center></td>
        <td><center><strong>Pago Parcial</strong></center></td>
        <td><center><strong>Saldo Matricula</strong></center></td>
      </tr>
    </thead>
    <tbody>
        @if (isset($todomovimiento))
            @foreach ($todomovimiento as $todomovimient)
              <?php
                $totalparcial = $totalparcial + $todomovimient['importeparcial'];
                $totalsaldo = $totalsaldo + $todomovimient['saldo'];
              ?>
              <tr>
                <td><center>{{$todomovimient['apeynom']}}</center></td>
                <td><center>{{$todomovimient['dni']}}</center></td>
                <td><center>{{$todomovimient['importe']}}</center></td>
                <td><center>{{$todomovimient['importeparcial']}}</center></td>
                <td><center>{{$todomovimient['saldo']}}</center></td>
              </tr>
            @endforeach
              <tr>
                <td><center><strong>TOTAL</strong></center></td>
                <td><center></center></td>
                <td><center></center></td>
                <td><center><strong>{{$totalparcial}}</strong></center></td>
                <td><center><strong>{{$totalsaldo}}</strong></center></td>
              </tr>
        @endif
    </tbody>          
  </table>
@stop
