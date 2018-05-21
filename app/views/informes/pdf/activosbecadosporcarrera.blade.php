@extends('layouts.informes.contenedor')

@section('cuerpo')
  <h3>Alumnos Becados</h3>
  <h4>Carrera: {{$carrera}}</h4>
  <table class="collapse">
    <thead>
      <tr>
        <td><strong>Apellido y Nombre</strong></td>
        <td><strong>DNI</strong></td>
        <td><strong>Ciclo Lectivo</strong></td>
        <td><strong>Telefono</strong></td>
        <td><center><strong>Becado</strong></center></td>
      </tr>
    </thead>
    <tbody>
        @if (isset($activos))
            <?php $i = 0; ?>
            @foreach ($activos as $activo)
              <?php
              $persona = $activo->apellido . ', ' . $activo->nombre;
              $idalumno = $activo->alumno_id;
              $telefono = 'No cargado';
              //$fecha_inicio = FechaHelper::getFechaImpresion($becado->becafechainicio);
              //$fecha_fin = FechaHelper::getFechaImpresion($becado->becafechafin);
              $beca = "<strong><font color='red'>X</font></strong>";

              foreach ($activo->becados as $becado) {
                  if ($becado->alumno_id) {
                    $beca = "<strong><font color='green'>V</font></strong>";
                    $i++;
                  }
              }
              
              foreach ($activo->contactos as $contacto) {
                  if ($contacto->contacto_id == 1) {
                      $telefono = $contacto->descripcion;
                  }
              }
              ?>
              <tr>
                <td>{{$persona}}</td>
                <td>{{$activo->dni}}</td>
                <td>{{$activo->ciclo}}</td>
                <td>{{$telefono}}</td>
                <td><center>{{$beca}}</center></td>
              </tr>
            @endforeach  
    </tbody>
    <br>
    <h3>TOTAL DE ALUMNOS BECADOS: {{$i}}.</h3>
    <h3>TOTAL DE ALUMNOS: {{count($activos)}}.</h3>
        @endif          
  </table>
@stop