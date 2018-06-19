@extends('layouts.informes.contenedor')

@section('cuerpo')
<p align="right">Fecha de Impresión: {{date('d/m/Y')}} - {{Auth::user()->usuario}}</p>
  <center><h3>Listado de Examen Final</h3></center>
  <p><strong>Carrera: {{$carreras}}</strong></p>
<?php
if (!$nrodocumento == '') { ?>
  <p><strong>Alumno: {{$apeynom}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DNI: {{$nrodocumento}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Domicilio: {{$domicilio}}</strong></p>
<?php } ?>
  
<p><strong>Cohorte: {{$cohorte}}</strong></p>

  <table class="collapse">
    <thead>
      <tr>
        <?php if ($nrodocumento == '') { ?>
          <td><center><strong>Alumno</strong></center></td>
        <?php } ?>
        <td><center><strong>Unidad Curricular</strong></center></td>
        <td><center><strong>Nota</strong></center></td>
        <td><center><strong>Resolución</strong></center></td>
        <td><center><strong>Folio</strong></center></td>
        <td><center><strong>Libro</strong></center></td>
        <td><center><strong>Fecha</strong></center></td>
        <td><center><strong>Condición</strong></center></td>
        <td><center><strong>Acta</strong></center></td>
        <td><center><strong>Obs. (Equivalencias)</strong></center></td>
      </tr>
    </thead>
    <tbody>
      <?php 
      $tabla = '';
      $tabladetalle = '';
      ?>
        @if (isset($materias))
            @foreach ($materias as $materia)
              <?php $calif_final_num = $materia['calif_final_num']; ?>
              <tr>
                <?php if ($nrodocumento == '') { ?>
                  <td>{{$materia['alumno']}}</td>
                <?php } ?>
                <td><center>{{$materia['nombremateria']}}</center></td>
                <td><center>{{$materia['calif_final_num']}} ({{ $nota[$calif_final_num] }})</center></td>
                <td><center>{{$materia['nroresolucion']}}</center></td>
                <td><center>{{$materia['folio']}}</center></td>
                <td><center>{{$materia['libro']}}</center></td>
                <td><center>{{$materia['fecha_aprobacion']}}</center></td>
                <td><center>{{$materia['condicion']}}</center></td>
                <td><center>{{$materia['acta']}}</center></td>
                <td><center>{{$materia['observaciones']}}</center></td>
              </tr>
            @endforeach
        @endif 
    </tbody>       
  </table>
@stop
