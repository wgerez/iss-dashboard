@extends('layouts.informes.contenedor')

@section('cuerpo')
  <h3>Informe Auditoria de Matriculas</h3>
  <table class="collapse">
    <thead>
      <tr>
        <td><strong>Apellido y Nombre</strong></td>
        <td><strong>DNI</strong></td>
        <td><strong>Carrera</strong></td>
        <td><strong>Cuota Mes</strong></td>
        <td><strong>Creado</strong></td>
        <td><strong>Fecha</strong></td>
        <td><strong>Modificado</strong></td>
        <td><strong>Fecha</strong></td>
      </tr>
    </thead>
    <tbody>
        @if (isset($matriculas))
            @foreach ($matriculas as $matricula)
              <tr>
                <td>{{$matricula['apeynom']}}</td>
                <td>{{$matricula['dni']}}</td>
                <td>{{$matricula['abreviatura']}}</td>
                <td>{{$matricula['mescuota']}}</td>
                <td>{{$matricula['usuario_alta']}}</td>
                <td>{{$matricula['fecha_alta']}}</td>
                <td>{{$matricula['usuario_modi']}}</td>
                <td>{{$matricula['fecha_modi']}}</td>
              </tr>
            @endforeach  
    </tbody>
    <br>
  <h3>TOTAL DE MATRICULAS: {{count($matriculas)}}.</h3>
        @endif          
  </table>
@stop
