@extends('layouts.informes.contenedor')

@section('cuerpo')
  <center><h3>Listado pago de matrículas</h3></center>
  <?php
  $ciclo = '';
  $carrera = '';
/*highlight_string(var_export($matriculas, true));
        exit();*/

                  //$fecha_vencimiento = getFechaImpresion(matricula.fechavencimientomatricula);
                  //$fecha = new Date();
                  //$fecha_actual = fecha.getDate() + '/' + (fecha.getMonth() + 1) + '/'
                                 //+ fecha.getFullYear();
                //if (primerFechaMayor(fecha_vencimiento, fecha_actual)) {
if (isset($matriculas)) {
  foreach ($matriculas as $matricula) {
    $ciclo = $matricula['ciclo_descripcion'];
    $carrera = $matricula['carrera'];
  }
}

?>
  <h3>Carrera: {{$carrera}}</h3>
  <h3>Ciclo Lectivo: {{$ciclo}}</h3>
  <table class="collapse">
    <thead>
      <tr>
        <td><center><strong>Apellido y Nombre</strong></center></td>
        <td><center><strong>DNI</strong></center></td>
        <!--td><center><strong>Carrera</strong></center></td-->
        <td><center><strong>Pagado</strong></center></td>
      </tr>
    </thead>
    <tbody>
        @if (isset($matriculas))
            @foreach ($matriculas as $matricula)
              <?php
              $ya_pago_matricula = false;
              $parcial = false;
              $tiene_beca = false;

              if ($matricula['beca'] == '7') {
                $tiene_beca = false;
              } else {
                $tiene_beca = true;
              }

            if ($matricula['matriculaaplica'] == '1') {
              foreach ($matricula['detalle_cuotas'] as $value) {
                  if ($value->estado == 1) {
                    $ya_pago_matricula = true;
                    $importe = $value->importe;
                    if ($value->totalparcial == 1) {
                      $parcial = true;
                      $importe = $value->importeparcial;
                    }
                  }
              }

              if ($ya_pago_matricula) {
                if ($parcial) {
                  $td_matricula = 'class=warning';
                  $content = "<strong><font color='orange'>".$importe."</font></strong>";
                } else {
                  $td_matricula = 'class=success';
                  $content = "<strong><font color='green'>".$importe."</font></strong>";
                }
              } else {
                  $fecha_vencimiento = $matricula['fechavencimientomatricula'];
                /*$porcions = explode("/", $fecha_vencimiento);
                            $fechatransaccions = $porcions[2].'-'.$porcions[1].'-'.$porcions[0];
                            $fecha_trans = strtotime($fechatransaccions);
                            $fecha_trans = strtotime($fecha_vencimiento);*/

                $fecha_actual = date("Y-m-d");

                if ($fecha_vencimiento > $fecha_actual) {
                  $td_matricula = '';
                  $content = "<strong><font color='orange'>-</font></strong>";
                } else {
                  $td_matricula = 'class=danger';
                  $content = "<strong><font color='red'>X</font></strong>";
                }

                if ($tiene_beca == true) {
                  $td_matricula = 'class=info';
                  $content = "<strong><font color='blue'>V</font></strong>";
                }
              }
            } else {
              $td_matricula = '';
              $content = '';
            }

              $persona = $matricula['apellido'] . ', ' . $matricula['nombre'];

              /*if ($matricula['tiene_beca']) {
                $td_matricula = "<strong><font color='blue'>V</font></strong>";
              } elseif ($matricula['matriculaaplica']) {
                $td_matricula = "<strong><font color='green'>".$matricula['importe']."</font></strong>";
              } else {
                  $porcions = explode("/", $matricula['fechavencimientomatricula']);
                  $fechaven = $porcions[2].'-'.$porcions[1].'-'.$porcions[0];
                  $fechavencimientomatricula = strtotime($fechaven);
                  $fechahastas = date("Y-m-d");
                  $fecha_actual = strtotime($fechahastas);

                if ($fechavencimientomatricula > $fecha_actual) {
                  $td_matricula = "<strong><font color='orange'></font></strong>";
                } else {
                  $td_matricula = "<strong><font color='red'>X</font></strong>";
                }
              }

              if ($matricula['tiene_beca']) {
                $td_matricula = "<strong><font color='blue'>BECADO</font></strong>";
              }*/
                
              ?>
              <tr>
                <td><center>{{$persona}}</center></td>
                <td><center>{{$matricula['nrodocumento']}}</center></td>
                <!--td><center>{{$matricula['carrera']}}</center></td-->
                <td {{$td_matricula}}><center>{{$content}}</center></td>
              </tr>
            @endforeach
    </tbody>
        @endif          
  </table>
@stop
