@extends('layouts.informes.contenedor')

@section('cuerpo')
<?php
$total = 0;
$totalingreso = 0;
$totalegreso = 0;
$movi = 0;
$egreso = '';
$ingreso = '';
foreach ($todomovimiento as $todomovimient) {
  if ($todomovimient['datos'] == 1) {
    $datos = 1;
  }
  if ($todomovimient['ingreso'] > 0) {
    $ingreso = '<td><center><strong>Ingreso</strong></center></td>';
  }
  if ($todomovimient['egreso'] > 0) {
    $egreso = '<td><center><strong>Egreso</strong></center></td>';
  }
}
?>
  <h3><center>Informe de Caja Chica</center></h3>
  <table class="collapse">
    <thead>
      <tr>
        <td><center><strong>Fecha</strong></center></td>
        <?php 
        if ($datos == 1) {
          echo "<td><center><strong>Apellido y Nombre</strong></center></td>";
          echo "<td><center><strong>DNI</strong></center></td>";
        }
        ?>
        <td><center><strong>Concepto</strong></center></td>
        <td><center><strong>Comprobante</strong></center></td>
        <td><center><strong>N° Comprobante</strong></center></td>
        <?php 
        if (!$ingreso == '') {
          echo $ingreso;
        }
        if (!$egreso == '') {
          echo $egreso;
        }
        ?>
      </tr>
    </thead>
    <tbody>
        @if (isset($todomovimiento))
            @foreach ($todomovimiento as $todomovimient)
              <tr>
                <td><center>{{$todomovimient['fecha']}}</center></td>
                <?php 
                if ($datos == 1) {
                  echo "<td><center>{$todomovimient['nombre']}</center></td>";
                  echo "<td><center>{$todomovimient['dni']}</center></td>";
                }
                ?>
                <td><center>{{$todomovimient['concepto']}}</center></td>
                <td><center>{{$todomovimient['tipomovimiento']}}</center></td>
                <td><center>{{$todomovimient['comprobante']}}</center></td>
                <?php 
                if (!$ingreso == '') {
                  echo "<td><center>{$todomovimient['ingreso']}</center></td>";
                }

                if (!$egreso == '') {
                  echo "<td><center>{$todomovimient['egreso']}</center></td>";
                }

                $totalegreso += $todomovimient['egreso'];
                $totalingreso += $todomovimient['ingreso'];
                $movi = $todomovimient['movimiento'];
                ?>
              </tr>
            @endforeach
            <tr style="background-color: #f2f2f2">
              <td><center><font size=4><strong>TOTAL</strong></font></center></td>
              <?php 
              if ($datos == 1) {
                echo "<td></td>";
                echo "<td></td>";
              }
              ?>
              <td></td>
              <td></td>
              <td></td>
                <?php 
                if ($totalingreso > 0) {
                  echo "<td><center><font size=4><strong>$".$totalingreso."</strong></font></center></td>";
                }

                if ($totalegreso > 0) {
                  echo "<td><center><font size=4><strong>$".$totalegreso."</strong></font></center></td>";
                }
                ?>
            </tr>
            <?php 
            if ($movi == 1) { ?>
              <tr>
                <td><center><font size=4><strong>SALDO</strong></font></center></td>
                <?php 
                if ($datos == 1) {
                  echo "<td></td>";
                  echo "<td></td>";
                }
                ?>
                <td></td>
                <td></td>
                <td><center><font size=4><strong>$<?php $saldo = $totalingreso - $totalegreso;
                        echo round($saldo, 2); ?></strong></font></center></td>
                <td></td>
                <td></td>
              </tr>
            <?php } ?>
        @endif
    </tbody>          
  </table>
@stop
