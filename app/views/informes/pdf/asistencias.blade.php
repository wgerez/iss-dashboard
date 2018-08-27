@extends('layouts.informes.contenedor')

@section('cuerpo')
<p align="right">Fecha de Impresión: {{date('d/m/Y')}} - {{Auth::user()->usuario}}</p>
  <center><h3>Listado de Asistencias</h3></center>
  
<p><strong>Carrera: {{$carreras}}</strong></p><p><strong>Plan de Estudio: {{$planes}}</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Ciclo Lectivo: {{$ciclo}}</strong></p>
<p><strong>Materia: {{$materia}}</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Docente: {{$docentes}}</strong></p>
<!--p><strong>Fecha de Asistencia:</strong> {{$fecha}}</p--> 
<?php 

$fechadesdes = date('Y-m-d');
//$porcion = explode("/", $fechades);
//$fechadesdes = $porcion[2].'-'.$porcion[1].'-'.$porcion[0];
$nuevafecha = date('Y-m-d', strtotime("$fechadesdes + 1 day"));
$porcions = explode("-", $nuevafecha);
$fechadesde = $porcions[2].'/'.(string)(int)$porcions[1].'/'.$porcions[0];
//echo $lunesfecha;
//echo $fechadesde;

$lunesta = '';
$martesta = '';
$miercolesta = '';
$juevesta = '';
$viernesta = '';
$sabadota = '';
$lunestab = '';
$martestab = '';
$miercolestab = '';
$juevestab = '';
$viernestab = '';
$sabadotab = '';

if (isset($alumnosinscriptos)) {
  foreach ($alumnosinscriptos as $value) {
    if ($value['lunes'] == 3) {
      $lunestab = '';
      $lunesta = '';
    } else {
      $lunestab = '<th><center>Lunes</center></th>';
      $lunesta = '<th><center>'. $lunes.'/'.$meses[$lunesmes] .'</center></th>';
    }

    if ($value['martes'] == 3) {
      $martestab = '';
      $martesta = '';
    } else {
      $martestab = '<th><center>Martes</center></th>';
      $martesta = '<th><center>'. $martes.'/'.$meses[$martesmes] .'</center></th>';
    }

    if ($value['miercoles'] == 3) {
      $miercolestab = '';
      $miercolesta = '';
    } else {
      $miercolestab = '<th><center>Miércoles</center></th>';
      $miercolesta = '<th><center>'. $miercoles.'/'.$meses[$miercolesmes] .'</center></th>';
    }

    if ($value['jueves'] == 3) {
      $juevestab = '';
      $juevesta = '';
    } else {
      $juevestab = '<th><center>Jueves</center></th>';
      $juevesta = '<th><center>'. $jueves.'/'.$meses[$juevesmes] .'</center></th>';
    }

    if ($value['viernes'] == 3) {
      $viernestab = '';
      $viernesta = '';
    } else {
      $viernestab = '<th><center>Viernes</center></th>';
      $viernesta = '<th><center>'. $viernes.'/'.$meses[$viernesmes] .'</center></th>';
    }

    if ($value['sabado'] == 3) {
      $sabadotab = '';
      $sabadota = '';
    } else {
      $sabadotab = '<th><center>Sábado</center></th>';
      $sabadota = '<th><center>'. $sabado.'/'.$meses[$sabadomes] .'</center></th>';
    }
  }
}
?>
  <table class="collapse">
    <thead>
      <tr>
        <th><center><strong></strong></center></th>
        <th><center><strong></strong></center></th>
        <?php
        if ($fechaimp == '') {
          if ($lunesfecha < $fechadesde) {
            if (!$lunesta == '') {
              echo $lunestab;
            }
          }

          if ($martesfecha < $fechadesde) {
            if (!$martesta == '') {
              echo $martestab;
            }
          }

          if ($miercolesfecha < $fechadesde) {
            if (!$miercolesta == '') {
              echo $miercolestab;
            }
          }

          if ($juevesfecha < $fechadesde) {
            if (!$juevesta == '') {
              echo $juevestab;
            }
          }

          if ($viernesfecha < $fechadesde) {
            if (!$viernesta == '') {
              echo $viernestab;
            }
          }

          if ($sabadofecha < $fechadesde) {
            if (!$sabadota == '') {
              echo $sabadotab;
            }
          }
        } else {
          if (!$lunestab == '') {
            echo $lunestab;
          }
          if (!$martestab == '') {
            echo $martestab;
          }
          if (!$miercolestab == '') {
            echo $miercolestab;
          }
          if (!$juevestab == '') {
            echo $juevestab;
          }
          if (!$viernestab == '') {
            echo $viernestab;
          }
          if (!$sabadotab == '') {
            echo $sabadotab;
          }
        }
        ?>
        <!--th>
          <center>Lunes</center>
        </th>
        <th>
          <center>Martes</center>
        </th>
        <th>
          <center>Miércoles</center>
        </th>
        <th>
          <center>Jueves</center>
        </th>
        <th>
          <center>Viernes</center>
        </th>
        <th>
          <center>Sábado</center>
        </th-->
      </tr>
      <tr>
        <th>
          <center><i class="fa fa-users"></i> Alumno</center>
        </th>
        <th>
          <center><i class="fa fa-files-o"></i> N° Doc.</center>
        </th>
        <?php
        if ($fechaimp == '') {
          if ($lunesfecha < $fechadesde) {
            if (!$lunesta == '') {
              echo $lunesta;
            }
          }

          if ($martesfecha < $fechadesde) {
            if (!$martesta == '') {
              echo $martesta;
            }
          }

          if ($miercolesfecha < $fechadesde) {
            if (!$miercolesta == '') {
              echo $miercolesta;
            }
          }

          if ($juevesfecha < $fechadesde) {
            if (!$juevesta == '') {
              echo $juevesta;
            }
          }

          if ($viernesfecha < $fechadesde) {
            if (!$viernesta == '') {
              echo $viernesta;
            }
          }

          if ($sabadofecha < $fechadesde) {
            if (!$sabadota == '') {
              echo $sabadota;
            }
          }
        } else {
          if (!$lunesta == '') {
            echo $lunesta;
          }
          if (!$martesta == '') {
            echo $martesta;
          }
          if (!$miercolesta == '') {
            echo $miercolesta;
          }
          if (!$juevesta == '') {
            echo $juevesta;
          }
          if (!$viernesta == '') {
            echo $viernesta;
          }
          if (!$sabadota == '') {
            echo $sabadota;
          }
        }
        ?>
        <!--th>
          <center><?php //echo $lunes.'/'.$meses[$lunesmes]; ?></center>
        </th>
        <th>
          <center><?php //echo $martes.'/'.$meses[$martesmes]; ?></center>
        </th>
        <th>
          <center><?php //echo $miercoles.'/'.$meses[$miercolesmes]; ?></center>
        </th>
        <th>
          <center><?php //echo $jueves.'/'.$meses[$juevesmes]; ?></center>
        </th>
        <th>
          <center><?php //echo $viernes.'/'.$meses[$viernesmes]; ?></center>
        </th>
        <th>
          <center><?php //echo $sabado.'/'.$meses[$sabadomes]; ?></center>
        </th-->
      </tr>
    </thead>
    <tbody>
        @if (isset($alumnosinscriptos))
            @foreach ($alumnosinscriptos as $value)
              <?php
              $lunes = '';
              $martes = '';
              $miercoles = '';
              $jueves = '';
              $viernes = '';
              $sabado = '';
              $lunestabla = 'Ausente';
              $martestabla = 'Ausente';
              $miercolestabla = 'Ausente';
              $juevestabla = 'Ausente';
              $viernestabla = 'Ausente';
              $sabadotabla = 'Ausente';

              $tabla = '<tr><td><center>'.$value['apellido'].', '.$value['nombre'].'</center></td><td><center>'.$value['nrodocumento'].'</center></td>';
                
              if ($value['lunes'] == 5) $lunestabla = '<td><center>Feriado</center></td>';
              if ($value['lunes'] == 4) $lunestabla = '<td><center>-</center></td>';
              if ($value['lunes'] == 3) $lunestabla = '<td><center></center></td>';
              if ($value['lunes'] == 2) $lunestabla = '<td><center>Ausente</center></td>';
              if ($value['lunes'] == 1) $lunestabla = '<td><center>Presente</center></td>';
              if ($value['lunes'] == 0) $lunestabla = '<td><center>Ausente</center></td>';
              
              if ($value['martes'] == 5) $martestabla = '<td><center>Feriado</center></td>';
              if ($value['martes'] == 4) $martestabla = '<td><center>-</center></td>';
              if ($value['martes'] == 3) $martestabla = '<td><center></center></td>';
              if ($value['martes'] == 2) $martestabla = '<td><center>Ausente</center></td>';
              if ($value['martes'] == 1) $martestabla = '<td><center>Presente</center></td>';
              if ($value['martes'] == 0) $martestabla = '<td><center>Ausente</center></td>';

              if ($value['miercoles'] == 5) $miercolestabla = '<td><center>Feriado</center></td>';
              if ($value['miercoles'] == 4) $miercolestabla = '<td><center>-</center></td>';
              if ($value['miercoles'] == 3) $miercolestabla = '<td><center></center></td>';
              if ($value['miercoles'] == 2) $miercolestabla = '<td><center>Ausente</center></td>';
              if ($value['miercoles'] == 1) $miercolestabla = '<td><center>Presente</center></td>';
              if ($value['miercoles'] == 0) $miercolestabla = '<td><center>Ausente</center></td>';

              if ($value['jueves'] == 5) $juevestabla = '<td><center>Feriado</center></td>';
              if ($value['jueves'] == 4) $juevestabla = '<td><center>-</center></td>';
              if ($value['jueves'] == 3) $juevestabla = '<td><center></center></td>';
              if ($value['jueves'] == 2) $juevestabla = '<td><center>Ausente</center></td>';
              if ($value['jueves'] == 1) $juevestabla = '<td><center>Presente</center></td>';
              if ($value['jueves'] == 0) $juevestabla = '<td><center>Ausente</center></td>';

              if ($value['viernes'] == 5) $viernestabla = '<td><center>Feriado</center></td>';
              if ($value['viernes'] == 4) $viernestabla = '<td><center>-</center></td>';
              if ($value['viernes'] == 3) $viernestabla = '<td><center></center></td>';
              if ($value['viernes'] == 2) $viernestabla = '<td><center>Ausente</center></td>';
              if ($value['viernes'] == 1) $viernestabla = '<td><center>Presente</center></td>';
              if ($value['viernes'] == 0) $viernestabla = '<td><center>Ausente</center></td>';

              if ($value['sabado'] == 5) $sabadotabla = '<td><center>Feriado</center></td>';
              if ($value['sabado'] == 4) $sabadotabla = '<td><center>-</center></td>';
              if ($value['sabado'] == 3) $sabadotabla = '<td><center></center></td>';
              if ($value['sabado'] == 2) $sabadotabla = '<td><center>Ausente</center></td>';
              if ($value['sabado'] == 1) $sabadotabla = '<td><center>Presente</center></td>';
              if ($value['sabado'] == 0) $sabadotabla = '<td><center>Ausente</center></td>';

              if ($fechaimp == '') {
                if ($lunesfecha < $fechadesde) {
                  if (!$lunesta == '') {
                    $tabla .= $lunestabla;
                  }
                }

                if ($martesfecha < $fechadesde) {
                  if (!$martesta == '') {
                    $tabla .= $martestabla;
                  }
                }

                if ($miercolesfecha < $fechadesde) {
                  if (!$miercolesta == '') {
                    $tabla .= $miercolestabla;
                  }
                }

                if ($juevesfecha < $fechadesde) {
                  if (!$juevesta == '') {
                    $tabla .= $juevestabla;
                  }
                }

                if ($viernesfecha < $fechadesde) {
                  if (!$viernesta == '') {
                    $tabla .= $viernestabla;
                  }
                }

                if ($sabadofecha < $fechadesde) {
                  if (!$sabadota == '') {
                    $tabla .= $sabadotabla;
                  }
                }
              } else {
                if (!$lunesta == '') {
                  $tabla .= $lunestabla;
                }

                if (!$martesta == '') {
                  $tabla .= $martestabla;
                }

                if (!$miercolesta == '') {
                  $tabla .= $miercolestabla;
                }

                if (!$juevesta == '') {
                  $tabla .= $juevestabla;
                }

                if (!$viernesta == '') {
                  $tabla .= $viernestabla;
                }

                if (!$sabadota == '') {
                  $tabla .= $sabadotabla;
                }
              }

              $tabladetalle = $tabla .'</tr>';

              echo $tabladetalle;
              ?>
            @endforeach
        @endif 
    </tbody>       
  </table>
@stop
