@extends('layouts.informes.contenedor')

@section('cuerpo')
  <p align="right">Fecha de Impresión: {{date('d/m/Y')}} - {{Auth::user()->usuario}}</p>
  <h3>Informe de Alumno con deudas por Carrera</h3>
  <?php
  $carrera = '';
  $ciclo = '';
  $fecha_desde = '';
  $fecha_hasta = '';

  foreach ($matriculas as $matricula) {
    $carrera = $matricula['carrera'];
    $ciclo = $matricula['ciclo'];
    $can = count($matricula['detalle_cuotas']);
  }

  if (!$fechadesde == '') {
    $ele = explode("-", $fechadesde);
    $mesdesde = (string)(int)$ele[1];
    $fecha_desde = FechaHelper::getFechaImpresion($fechadesde);
  }

  if (!$fechahasta == '') {
    $elem = explode("-", $fechahasta);
    $meshasta = (string)(int)$elem[1];
    $fecha_hasta = FechaHelper::getFechaImpresion($fechahasta);
  }
  

  $ultimomes = 0;
  $saldo = 0;
  $totalimporte = 0;
  $totaldeuda = 0;
  $totalmatricula = 0;
/*highlight_string(var_export($matriculas, true));
        exit();*/

                  //$fecha_vencimiento = getFechaImpresion(matricula.fechavencimientomatricula);
                  //$fecha = new Date();
                  //$fecha_actual = fecha.getDate() + '/' + (fecha.getMonth() + 1) + '/'
                                 //+ fecha.getFullYear();
                //if (primerFechaMayor(fecha_vencimiento, fecha_actual)) {

?>
<h3>Carrera: {{$carrera}}</h3><h3>Ciclo Lectivo: {{$ciclo}}</h3>
<?php
if (!$apeynom == '') {
  echo "<h3>Alumno: ".$apeynom."</h3>";
}
?>
<h3>{{$fecha_desde}} al {{$fecha_hasta}}</h3>
  <table class="collapse">
    <thead>
      <tr>
        <td><center><strong>Apellido y Nombre</strong></center></td>
        <td><center><strong>DNI</strong></center></td>
        <td><center><strong>Matricula</strong></center></td>
        <td><center><strong>Cuota</strong></center></td>
        <td><center><strong>Importe</strong></center></td>
        <td><center><strong>Total</strong></center></td>
      </tr>
    </thead>
    <tbody>
        @if (isset($matriculas))
            @foreach ($matriculas as $matricula)
              <?php
              $saldo = 0;
              $completo = 0;
              $persona = $matricula['apellido'] . ', ' . $matricula['nombre'];

              $meses = ['vacio', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
 
              if ($matricula['detalle_cuotas'] == 'ADEUDA') {
                if ($matricula['saldo'] > 0) {
                  $saldo = $matricula['saldo'];
                  $totalmatricula = $totalmatricula + $saldo;
                }
                
                if ($matricula['abonada'] == 0) {
                  $saldo = $matricula['matriculaimporte'];
                  $totalmatricula = $totalmatricula + $matricula['matriculaimporte'];
                }
                
                $iniciomes = $matricula['mespagocuotainicio'];

                if ($matricula['mespagocuotafin'] == 13) {
                  $mespagocuotafin = $meshasta + 1;//$matricula['mespagocuotafin'];
                } else {
                  $mespagocuotafin = $meshasta + 1;//$matricula['mespagocuotafin'] + 1;
                }

                if ($mesdesde > $iniciomes) {
                  $iniciomes = $mesdesde;
                }

                $a = 0;

                for ($i=$iniciomes; $i < $mespagocuotafin; $i++) {
                  if ($saldo == 0) {
                    $totalde = $matricula['cuotaimporte'];
                    $saldo = '';
                    $totalimporte = $totalimporte + $matricula['cuotaimporte'];
                    $totaldeuda = $totaldeuda + $totalde;
                  } else {
                    if ($a == 0) {
                      $totalde = $saldo + $matricula['cuotaimporte'];
                      $a++;
                    } else {
                      $totalde = $matricula['cuotaimporte'];
                    }

                    $totalimporte = $totalimporte + $matricula['cuotaimporte'];
                    $totaldeuda = $totaldeuda + $totalde;
                  }
                 
                  if ($i == $iniciomes) { ?>
                    <tr>
                      <td><center>{{$persona}}</center></td>
                      <td><center>{{$matricula['nrodocumento']}}</center></td>
                      <td><center>{{$saldo}}</center></td>
                      <td><center>{{$meses[$i]}}</center></td>
                      <td><center>{{number_format($matricula['cuotaimporte'],2, "," , ".")}}</center></td>
                      <td><center>{{number_format($totalde,2, "," , ".")}}</center></td>
                    </tr>
                    <?php
                   } else {
                    ?><tr>
                      <td><center></center></td>
                      <td><center></center></td>
                      <td><center></center></td>
                      <td><center>{{$meses[$i]}}</center></td>
                      <td><center>{{number_format($matricula['cuotaimporte'],2, "," , ".")}}</center></td>
                      <td><center>{{number_format($totalde,2, "," , ".")}}</center></td>
                    </tr><?php
                  }

                  $saldo = 0;
                }
              } else {
                $completo = 0;
                if ($matricula['saldo'] > 0) {
                  $saldo = $matricula['saldo'];
                  $totalmatricula = $totalmatricula + $saldo;
                }
               
                $i = 0;

                foreach ($matricula['detalle_cuotas'] as $value) {
                  if ($saldo == 0) {
                    $saldo = '';
                  }

                  if ($i == 0) { 
                    $datos = '<tr>
                      <td><center>'.$persona.'</center></td>
                      <td><center>'.$matricula['nrodocumento'].'</center></td>
                      <td><center>'.$saldo.'</center></td>';
                    $i++;
                   }

                  $ultimomes = $value->mescuota + 1;
                  
                  if ($value->mescuota == 12) {
                    if ($saldo > 0) $completo = 1;
                  }
                }

                if ($mesdesde > $ultimomes) {
                  $ultimomes = $mesdesde;
                }

                if ($matricula['mespagocuotafin'] == 13) {
                  $mespagocuotafin = $meshasta + 1;//$matricula['mespagocuotafin'];
                } else {
                  $mespagocuotafin = $meshasta + 1;//$matricula['mespagocuotafin'] + 1;
                }
 
                if ($completo == 1) {
                  echo $datos.'<td><center></center></td><td><center></center></td><td><center>'.$saldo.'</center></td></tr>';
                  $totaldeuda = $totaldeuda + $saldo;
                  $completo = 0;
                } else {
                  for ($i=$ultimomes; $i < $mespagocuotafin; $i++) {
                    if ($saldo == 0) {
                      $totalde = $matricula['cuotaimporte'];
                      $saldo = '';
                      $totalimporte = $totalimporte + $matricula['cuotaimporte'];
                      $totaldeuda = $totaldeuda + $totalde;
                    } else {
                      $totalde = $saldo + $matricula['cuotaimporte'];
                      $totalimporte = $totalimporte + $matricula['cuotaimporte'];
                      $totaldeuda = $totaldeuda + $totalde;
                    }
                   
                    if ($i == $ultimomes) { 
                      $datos = '<tr><td><center>'.$persona.'</center></td><td><center>'.$matricula['nrodocumento'].'</center></td><td><center>'.$saldo.'</center></td>';
                     } else {
                      $datos = '<tr><td><center></center></td><td><center></center></td><td><center></center></td>';
                     }

                     echo $datos;
                    ?>
                      <td><center>{{$meses[$i]}}</center></td>
                      <td><center>{{$matricula['cuotaimporte']}}</center></td>
                      <td><center>{{$totalde}}</center></td>
                    </tr><?php
                    $saldo = 0;
                  }
                }
              }

             ?>
            @endforeach
            <tr>
              <td><center><strong>TOTAL</strong></center></td>
              <td></td>
              <td><center><strong>${{number_format($totalmatricula,2, "," , ".")}}</strong></center></td>
              <td></td>
              <td><center><strong>${{number_format($totalimporte,2, "," , ".")}}</strong></center></td>
              <td><center><strong>${{number_format($totaldeuda,2, "," , ".")}}</strong></center></td>
            </tr>
    </tbody>
        @endif          
  </table>
@stop
