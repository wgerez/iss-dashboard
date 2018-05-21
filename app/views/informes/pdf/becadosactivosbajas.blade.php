@extends('layouts.informes.contenedor')

@section('cuerpo')
<p align="right">Fecha de Impresión: {{$fechahoy}} - {{Auth::user()->usuario}}</p>
  <h3>Informe Alumnos</h3>
  <h4>Carrera: {{$carrera}}</h4>
  <h4>Ciclo Lectivo: {{$ciclos}}</h4>
  <table class="collapse">
    <thead>
      <tr>
        <td><center><strong>Apellido y Nombre</strong></center></td>
        <td><center><strong>Fecha de Ingreso</strong></center></td>
        <td><center><strong>Telefono</strong></center></td>
        <td><center><strong>Email</strong></center></td>
        <td><center><strong>Dirección</strong></center></td>
        <td><center><strong>Condición</strong></center></td>
      </tr>
    </thead>
    <tbody>
        @if (isset($becados))
            @foreach ($becados as $becado)
              <?php
              $persona = $becado['apellido'] . ', ' . $becado['nombre'];
              $domicilio = $becado['barrio'] . ', ' . $becado['calle'] . ' ' . $becado['calle_numero'];
              if ($becado['activo'] == 1) {
                $condicion = 'Activo';
              }

              if ($becado['activo'] == 0) {
                $condicion = 'Baja';
              }

              if ($becado['becado'] == 1) {
                $condicion = 'Becado';
              }
              ?>
              <tr>
                <td>{{$persona}}</td>
                <td><center>{{$becado['fechaingreso']}}</center></td>
                <td><center>{{$becado['telefono']}}</center></td>
                <td>{{$becado['email']}}</td>
                <td>{{$domicilio}}</td>
                <td><center>{{$condicion}}</center></td>
              </tr>
            @endforeach
        @endif  
    </tbody>          
  </table>
@stop