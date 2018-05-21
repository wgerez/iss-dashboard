@extends('layouts.informes.contenedor')

@section('cuerpo')
  <h3>Alumnos Matriculados por A&ntilde;o</h3>
  <h4>Ciclo Lectivo {{$ciclo_lectivo}}</h4>
  <table class="collapse">
    <thead>
      <tr>
        <td><center><strong>Apellido y Nombre</strong></center></td>
        <td><center><strong>DNI</strong></center></td>
        <td><center><strong>Dirección</strong></center></td>
        <td><center><strong>Localidad</strong></center></td>
        <td><center><strong>Teléfono</strong></center></td>
        <td><center><strong>Correo</strong></center></td>
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
                <td><center>{{$alumno->nrodocumento}}</center></td>
                <td><center>{{$domicilio}}</center></td>
                <td><center>{{$alumno->localidad}}</center></td>
                <td><center>{{$telefono}}</center></td>
                <td><center>{{$email}}</center></td>
              </tr>
            @endforeach
    </tbody>
    <br>
    <h3>TOTAL DE ALUMNOS: {{count($alumnos)}} Matriculados.</h3>
        @endif
  </table>
@stop