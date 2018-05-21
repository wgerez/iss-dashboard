@extends('layouts.informes.contenedor')

@section('cuerpo')
  <h3>Informe de Auditoría de Alumnos</h3>
  <table class="collapse">
    <thead>
      <tr>
        <td><strong>Apellido y Nombre</strong></td>
        <td><strong>DNI</strong></td>
        <td><strong>Creado</strong></td>
        <td><strong>Fecha</strong></td>
        <td><strong>Modificado</strong></td>
        <td><strong>Fecha</strong></td>
      </tr>
    </thead>
    <tbody>
        @if (isset($alumnos))
            @foreach ($alumnos as $alumno)
              <tr>
                <td>{{$alumno['apeynom']}}</td>
                <td>{{$alumno['dni']}}</td>
                <td>{{$alumno['usuario_alta']}}</td>
                <td>{{$alumno['fecha_alta']}}</td>
                <td>{{$alumno['usuario_modi']}}</td>
                <td>{{$alumno['fecha_modi']}}</td>
              </tr>
            @endforeach
    </tbody>
    <br>
    <h3>TOTAL DE ALUMNOS: {{count($alumnos)}} auditados.</h3>
        @endif          
  </table>
@stop
