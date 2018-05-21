@extends('layouts.informes.contenedor')

@section('cuerpo')
  <h3>Informe Auditoria de Docentes</h3>
  <table class="collapse">
    <thead>
      <tr>
        <td><strong>Apellido y Nombre</strong></td>
        <td><strong>DNI</strong></td>
        <td><strong>Creado</strong></td>
        <td><strong>Fecha</strong></td>
        <td><strong>Modificado </strong></td>
        <td><strong>Fecha</strong></td>
      </tr>
    </thead>
    <tbody>
        @if (isset($docentes))

            <?php $i = 0; ?>
            @foreach ($docentes as $docente)
              <?php
              /*var_dump($docente);
              exit();*/
              ?>
              <tr>
                <td>{{$docente['apeynom']}}</td>
                <td>{{$docente['dni']}}</td>
                <td>{{$docente['usuario_alta']}}</td>
                <td>{{$docente['fecha_alta']}}</td>
                <td>{{$docente['usuario_modi']}}</td>
                <td>{{$docente['fecha_modi']}}</td>
              </tr>
            @endforeach  
    </tbody>
    <br>
    <h3>TOTAL DE DOCENTES: {{count($docentes)}}.</h3>
        @endif          
  </table>
@stop




