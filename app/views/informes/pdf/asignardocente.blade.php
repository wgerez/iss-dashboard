@extends('layouts.informes.contenedor')

@section('cuerpo')
<p align="right">Fecha de Impresión: {{date('d/m/Y')}} - {{Auth::user()->usuario}}</p>
  <center><h3>Listado de Docentes Asignados por Materia</h3></center>
  
<p><strong>Carrera: {{$carreras}}</strong></p><p><strong>Plan de Estudio: {{$planes}}</strong></p>

  <table class="collapse">
    <thead>
      <tr>
        <td><center><strong>Materia</strong></center></td>
        <td><center><strong>Docente Titular</strong></center></td>
        <td><center><strong>Docente Provisorio</strong></center></td>
        <td><center><strong>Docente Suplente</strong></center></td>
        <td><center><strong>Día</strong></center></td>
        <td><center><strong>Hora Entrada</strong></center></td>
        <td><center><strong>Hora Salida</strong></center></td>
      </tr>
    </thead>
    <tbody>
      <?php 
      $tabla = '';
      $tabladetalle = '';
      ?>
        @if (isset($docentes))
            @foreach ($docentes as $docente)
              <?php $bandera = true; 
      $tablacargada = '';
                $tabla = "<tr><td><center>".$docente['docentesmateria']."</center></td><td><center>".$docente['apeynomtitular']."</center></td><td><center>".$docente['apeynomprovisorio']."</center></td><td><center>".$docente['apeynomsuplente']."</center></td>";
                  
                  foreach ($docente['dias'] as $value) {
                    if ($bandera == true) {
                      $tabladetalle = "<td><center>".$value['dia']."</center></td><td><center>".$value['horaentrada']."</center></td><td><center>".$value['horasalida']."</center></td></tr>";
                      $bandera = false;
                    } else {
                      $tabladetalle = "<tr><td><center></center></td><td><center></center></td><td><center></center></td><td><center></center></td><td><center>".$value['dia']."</center></td><td><center>".$value['horaentrada']."</center></td><td><center>".$value['horasalida']."</center></td></tr>";
                    }

                    $tabla .= $tabladetalle;
                  } 

                  $tablacargada .= $tabla;
                  ?>
                  {{ $tablacargada }}
            @endforeach
        @endif 
    </tbody>       
  </table>
@stop
