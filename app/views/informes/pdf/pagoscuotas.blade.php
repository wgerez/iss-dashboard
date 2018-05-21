@extends('layouts.informes.contenedor')

@section('cuerpo')
  <h3>Listado pago de Cuotas</h3>
  <?php
  $carrera = '';
  $ciclo = '';

  foreach ($matriculas as $matricula) {
    $carrera = $matricula['carrera'];
    $ciclo = $matricula['ciclo'];
    $can = count($matricula['detalle_cuotas']);
  }

$ultimomes = 0;
/*highlight_string(var_export($matriculas, true));
        exit();*/

                  //$fecha_vencimiento = getFechaImpresion(matricula.fechavencimientomatricula);
                  //$fecha = new Date();
                  //$fecha_actual = fecha.getDate() + '/' + (fecha.getMonth() + 1) + '/'
                                 //+ fecha.getFullYear();
                //if (primerFechaMayor(fecha_vencimiento, fecha_actual)) {

?>
<h3>Carrera: {{$carrera}}</h3><h3>Ciclo Lectivo: {{$ciclo}}</h3>
  <table class="collapse">
    <thead>
      <tr>
        <td><center><strong>Apellido y Nombre</strong></center></td>
        <td><center><strong>DNI</strong></center></td>
        <td><center><strong>Cuota</strong></center></td>
        <td><center><strong>Total</strong></center></td>
        <td><center><strong>Estado</strong></center></td>
      </tr>
    </thead>
    <tbody>
        @if (isset($matriculas))
            @foreach ($matriculas as $matricula)
              <?php
              $persona = $matricula['apellido'] . ', ' . $matricula['nombre'];

              $meses = ['vacio', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

              if ($matricula['detalle_cuotas'] == 'ADEUDA') {
                $td_matricula = "<strong><font color='red'>ADEUDA</font></strong>";

                if ($matricula['beca'] == 'BECADO') $td_matricula = "<strong><font color='blue'>BECADO</font></strong>";

                $iniciomes = $matricula['mespagocuotainicio'];

                if ($matricula['mespagocuotafin'] == 13) {
                  $mespagocuotafin = $matricula['mespagocuotafin'];
                } else {
                  $mespagocuotafin = $matricula['mespagocuotafin'] + 1;
                }

                  for ($i=$iniciomes; $i < $mespagocuotafin; $i++) {
                    if ($i == $iniciomes) { ?>
                      <tr>
                        <td><center>{{$persona}}</center></td>
                        <td><center>{{$matricula['nrodocumento']}}</center></td>
                        <td><center>{{$meses[$i]}}</center></td>
                        <td><center>{{$matricula['cuotaimporte']}}</center></td>
                        <td><center>{{$td_matricula}}</center></td>
                      </tr>
                      <?php
                     } else {
                      ?><tr>
                        <td><center></center></td>
                        <td><center></center></td>
                        <td><center>{{$meses[$i]}}</center></td>
                        <td><center>{{$matricula['cuotaimporte']}}</center></td>
                        <td><center>{{$td_matricula}}</center></td>
                      </tr><?php
                    }
                  }
                } else {
                  $td_matricula = "<strong><font color='green'>PAGADO</font></strong>";

                  if ($matricula['beca'] == 'BECADO') $td_matricula = "<strong><font color='blue'>BECADO</font></strong>";

                  $i = 0;

                  foreach ($matricula['detalle_cuotas'] as $value) {
                    if ($i == 0) { ?>
                      <tr>
                        <td><center>{{$persona}}</center></td>
                        <td><center>{{$matricula['nrodocumento']}}</center></td>
                        <td><center>{{$meses[$value->mescuota]}}</center></td>
                        <td><center>{{$value->importe}}</center></td>
                        <td><center>{{$td_matricula}}</center></td>
                      </tr>
                      <?php
                      $i++;
                     } else {
                      ?><tr>
                        <td><center></center></td>
                        <td><center></center></td>
                        <td><center>{{$meses[$value->mescuota]}}</center></td>
                        <td><center>{{$value->importe}}</center></td>
                        <td><center>{{$td_matricula}}</center></td>
                      </tr><?php
                    }

                    $ultimomes = $value->mescuota + 1;
                  }

                  if ($matricula['mespagocuotafin'] == 12) $matricula['mespagocuotafin']++;

                  
                  for ($i=$ultimomes; $i < $matricula['mespagocuotafin']; $i++) {
                    $td_matricula = "<strong><font color='red'>ADEUDA</font></strong>";

                    if ($matricula['beca'] == 'BECADO') $td_matricula = "<strong><font color='blue'>BECADO</font></strong>";
                  ?>
                    <tr>
                      <td><center></center></td>
                      <td><center></center></td>
                      <td><center>{{$meses[$i]}}</center></td>
                      <td><center>{{$matricula['cuotaimporte']}}</center></td>
                      <td><center>{{$td_matricula}}</center></td>
                    </tr><?php
                  }
                }

               ?>
            @endforeach
    </tbody>
        @endif          
  </table>
@stop
