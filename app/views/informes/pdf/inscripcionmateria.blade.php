@extends('layouts.informes.contenedor')

@section('cuerpo')
<p align="right">Fecha de Impresión: {{$fechahoy}} - {{Auth::user()->usuario}}</p>  
  <?php
  /*highlight_string(var_export($matriculas, true));
        exit();*/
?>
<h3><center>INSCRIPCIÓN MATERIAS A CURSAR</center></h3>
<h3>Carrera: {{$carrera}}</h3><h3>Ciclo Lectivo: {{$ciclo}}</h3>
  <table class="collapse">
    <thead>
      <tr>
        <td><center><strong>Apellido y Nombre</strong></center></td>
        <td><center><strong>Documento</strong></center></td>
        <td><center><strong>Plan/Estudio</strong></center></td>
        <td><center><strong>Fecha</strong></center></td>
        <td><center><strong>Materias a Cursar</strong></center></td>
        <!--td><center><strong>Estado</strong></center></td-->
      </tr>
    </thead>
    <tbody>
        <?php 
          $bandera = true;
          $tabla = ''; ?>

          @if (isset($alumnosinscriptos))
            @foreach ($alumnosinscriptos as $alumnosinscripto)
              <?php 
              if ($bandera == true) { 
                $tabla .= '<tr><td><center>'. $alumnosinscripto["apellido"] .', '. $alumnosinscripto["nombre"] .'</center></td><td><center>'. $alumnosinscripto["nrodocumento"] .'</center></td><td><center>'. $planestudio .'</center></td>';
                $bandera = false;
                $i = 0;
              } 

              foreach ($alumnosinscripto["materias"] as $materias) {
              //for ($i=0; $i < count($alumnosinscripto["materias"]); $i++) { 
                if ($i > 0) {
                  $tabla .= '<tr><td><center></center></td><td><center></center></td><td><center></center></td>';
                }

                $tabla .= '<td><center>'. $materias["fecha"] .'</center></td><td><center>'. $materias["nombre"] .'</center></td><td><center><a title="Datos personales" href="inscripto/'.$materias["alumno_id"].'" class="btn btn-xs purple"><i class="fa fa-edit"></i></a><a href="#" data-id="'. $materias["inscripcion"] .'" class="btn default btn-xs red btnEliminarMaterias"><i title="Eliminar" class="fa fa-trash-o"></i></a></center></td></tr>';
                $i++;
              }

              $bandera = true;
              echo $tabla;
              $tabla = ''; 
              ?>
            @endforeach
          @endif
    </tbody>
  </table>
@stop
