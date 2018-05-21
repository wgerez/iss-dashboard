@extends('layouts.informes.contenedor')

@section('cuerpo')
  <h3>Cantidad de Alumnos Matriculados por Ciclo Lectivo</h3>
  <h4>Ciclo Lectivo 
  @foreach ($ciclo_lectivo as $ciclos)
      {{$ciclos->descripcion." "}}
  @endforeach
  </h4>
  <table class="collapse">
    <thead>
      <tr>
        <td><strong>Apellido y Nombre</strong></td>
        <td><strong>DNI</strong></td>
        <td><strong>Dirección</strong></td>
        <td><strong>Localidad</strong></td>
        <td><strong>Teléfono</strong></td>
        <td><strong>Correo</strong></td>
      </tr>
    </thead>
    <tbody>
        @if (isset($alumnos))
            @foreach ($alumnos as $alumno)
              <!-- RESCATO EL TELEFONO Y EL CORREO -->
              <?php
              $persona = $alumno->apellido . ', ' . $alumno->nombre;

              if (empty($alumno->barrio)) {
                $barrio = 'B° no cargado';
              } else {
                $barrio = $alumno->barrio;
              }

              if (empty($alumno->calle)) {
                $calle = 'Calle no cargada';
              } else {
                $calle = $alumno->calle;
              }

              if (empty($alumno->calle_numero)){
                $numero = 's/n';
              } else {
                $numero = ' N: '.$alumno->calle_numero;
              }

              if (empty($alumno->manzana)){
                $manzana = '';
              } else {
                $manzana = '- Mz: '.$alumno->manzana;
              }

              if (empty($alumno->departamento)){
                $departamento = '';
              } else {
                $departamento = '- Dpto: '.$alumno->departamento;
              }

              $domicilio = $barrio . ' - ' . $calle . ' ' . $numero . ' ' . $manzana . ' ' . $departamento;

              if ($domicilio == '0') $domicilio = '&nbsp;';

              $telefono = '';
              $email = '';
              foreach ($alumno->contactos as $contacto) {
                if ($contacto->contacto_id == 1) $telefono = $contacto->descripcion;
                if ($contacto->contacto_id == 3) $email = $contacto->descripcion;
              }
              ?>
              <tr>
                <td>{{$persona}}</td>
                <td>{{$alumno->nrodocumento}}</td>
                <td>{{$domicilio}}</td>
                <td>{{$alumno->localidad}}</td>
                <td>{{$telefono}}</td>
                <td>{{$email}}</td>
              </tr>
            @endforeach
    </tbody>
    <br>
    <h3>TOTAL DE ALUMNOS: {{count($alumnos)}} Matriculados.</h3>
        @endif          
  </table>
@stop
