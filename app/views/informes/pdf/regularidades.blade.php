@extends('layouts.informes.contenedor')

@section('cuerpo')
<p align="right">Fecha de Impresión: {{date('d/m/Y')}} - {{Auth::user()->usuario}}</p>
  <center><h3>PLANILLA DE REGULARIZACIÓN</h3></center>
  
<p><strong>Carrera: {{$carreras}}</strong></p>
<p><strong>Materia: {{$nombremateria}}</strong></p><p><strong>Año Cursado: {{$aniocursado}}° año</strong></p>
<p><strong>Docente: {{$docente}}</strong></p>
<p><strong>Ciclo Lectivo: {{$codigoplan}}</strong></p>

  <table class="collapse">
    <thead>
      <tr>
        <td><center><strong>Alumno</strong></center></td>
        <td><center><strong>Parcial</strong></center></td>
        <td><center><strong>Calificación</strong></center></td>
        <td><center><strong>Nota</strong></center></td>
        <td><center><strong>Recuperatorio</strong></center></td>
        <td><center><strong>Asistencia</strong></center></td>
        <td><center><strong>Regularizó</strong></center></td>
        <td><center><strong>Fecha Regular</strong></center></td>
      </tr>
    </thead>
    <tbody>
        @if (isset($materias))
            @foreach ($materias as $materia)
                <?php
                $tabla = '';
                $tabladetalle = '';
                $tablacargada = '';
                $recuperatorio = '';
                $regularizo = '';
                $calificacion = '';
                $nota = '';
                $bandera = true;
                $porcentaje_asistencia = $materia['porcentaje_asistencia'];

                $tabla = "<tr><td><center>{$materia['alumno']}</center></td>";
                  
                  foreach ($materia['regularidad'] as $value) { 
                    if ($value->calificacion == 1) {
                      $calificacion = 'Aprobó';
                    }

                    if ($value->calificacion == 2) {
                      $calificacion = 'Desaprobó';
                    }

                    if ($value->calificacion == 3) {
                      $calificacion = 'Ausente';
                    }

                    if ($value->recuperatorio > 0) {
                      $recuperatorio = 'A';
                    } else {
                      $recuperatorio = '-';
                    }

                    if ($value->regularizo == 0) {
                      $regularizo = '-';
                    }
                    if ($value->regularizo == 1) {
                      $regularizo = 'SI';
                    }
                    if ($value->regularizo == 2) {
                      $regularizo = 'NO';
                    }

                    if ($value->regularizo == 3) {
                      $regularizo = 'Promocionó';
                    }

                    if ($value->nota == 0) {
                      $nota = "-";
                    }
                    if ($value->nota == 1) {
                      $nota = "1";
                    }
                    if ($value->nota == 2) {
                      $nota = "2";
                    }
                    if ($value->nota == 3) {
                      $nota = "3";
                    }
                    if ($value->nota == 4) {
                      $nota = "4";
                    }
                    if ($value->nota == 5) {
                      $nota = "5";
                    }
                    if ($value->nota == 6) {
                      $nota = "6";
                    }
                    if ($value->nota == 7) {
                      $nota = "7";
                    }
                    if ($value->nota == 8) {
                      $nota = "8";
                    }
                    if ($value->nota == 9) {
                      $nota = "9";
                    }
                    if ($value->nota == 10) {
                      $nota = "10";
                    }

                    $fecha = FechaHelper::getFechaImpresion($value->fecha_regularidad);

                    if ($bandera ==true) {
                      $tabladetalle = '<td><center>'.$value->parcial.'°</center></td><td><center>'.$calificacion.'</center></td><td><center>'.$nota.'</center></td><td><center>'.$recuperatorio.'</center></td><td><center>'.$porcentaje_asistencia.' %</center></td><td><center>'.$regularizo.'</center></td><td><center>'.$fecha.'</center></td></tr>';
                      $bandera = false;
                    } else {
                      $tabladetalle = '<tr><td><center></center></td><td><center>'.$value->parcial.'°</center></td><td><center>'.$calificacion.'</center></td><td><center>'.$nota.'</center></td><td><center>'.$recuperatorio.'</center></td><td><center>'.$porcentaje_asistencia.' %</center></td><td><center>'.$regularizo.'</center></td></td><td><center>'.$fecha.'</center></td></tr>';
                    }

                    $tabla .= $tabladetalle;
                  }

                  $tablacargada .= $tabla;

                  echo $tablacargada;
                  ?>
                  
                
            @endforeach
        @endif 
    </tbody>       
  </table>
  <br>
  <br>
  <p align="right"><strong>Firma del Profesor:...............................</strong></p>
  <p align="right"><strong>Aclaración:...............................</strong></p>
@stop
