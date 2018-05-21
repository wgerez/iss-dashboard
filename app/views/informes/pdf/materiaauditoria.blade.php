@extends('layouts.informes.contenedor')

@section('cuerpo')
  <h3>Informe Auditoria de Materias</h3>
  <table class="collapse">
    <thead>
      <tr>
        <td><strong>Carrera</strong></td>
        <td><strong>Materia</strong></td>
        <td><strong>Periodo</strong></td>
        <td><strong>Hs. Semanales</strong></td>
        <td><strong>Hs. Reloj</strong></td>
        <td><strong>Hs. Catedra</strong></td>
        <td><strong>Alta</strong></td>
        <td><strong>Fecha</strong></td>
        <td><strong>Modificado</strong></td>
        <td><strong>Fecha</strong></td>
      </tr>
    </thead>
    <tbody>
        @if (isset($materias))
            @foreach ($materias as $materia)
            <?php
            $carrera = $materia->carrera->Abreviatura;
            $fecha_alta = FechaHelper::getFechaImpresion($materia->fecha_alta);
            $fecha_modi = FechaHelper::getFechaImpresion($materia->fecha_modi);
            ?>
              <tr>
                <td>{{$carrera}}</td>
                <td>{{$materia->nombremateria}}</td>
                <td>{{$materia->periodo}}</td>
                <td>{{$materia->hssemanales}}</td>
                <td>{{$materia->hsreloj}}</td>
                <td>{{$materia->hscatedra}}</td>
                <td>{{$materia->usuario_alta}}</td>
                <td>{{$fecha_alta}}</td>
                <td>{{$materia['usuario_modi']}}</td>
                <td>{{$fecha_modi}}</td>
              </tr>
            @endforeach  
    </tbody>
    <br>
  <h3>TOTAL DE MATERIAS: {{count($materias)}}.</h3>
        @endif          
  </table>
@stop
