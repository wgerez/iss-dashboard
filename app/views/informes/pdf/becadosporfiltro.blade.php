@extends('layouts.informes.contenedor')

@section('cuerpo')
  <h3>Alumnos Becados</h3>
  <table class="collapse">
    <thead>
      <tr>
        <td><strong>Apellido y Nombre</strong></td>
        <td><strong>DNI</strong></td>
        <td><strong>Carrera</strong></td>
        <td><strong>Inicio</strong></td>
        <td><strong>Fin</strong></td>
        <td><strong>Teléfono</strong></td>
      </tr>
    </thead>
    <tbody>
        @if (isset($becados))
            @foreach ($becados as $becado)
              <?php
              $persona = $becado->apellido . ', ' . $becado->nombre;
              $telefono = '';
              $fecha_inicio = FechaHelper::getFechaImpresion($becado->becafechainicio);
              $fecha_fin = FechaHelper::getFechaImpresion($becado->becafechafin);

              foreach ($becado->contactos as $contacto) {
                  if ($contacto->contacto_id == 1) {
                      $telefono = $contacto->descripcion;
                  }
              }
              ?>
              <tr>
                <td>{{$persona}}</td>
                <td>{{$becado->dni}}</td>
                <td>{{$becado->carrera}}</td>
                <td>{{$fecha_inicio}}</td>
                <td>{{$fecha_fin}}</td>
                <td>{{$telefono}}</td>
              </tr>
            @endforeach
        @endif   
    </tbody>        
  </table>
@stop