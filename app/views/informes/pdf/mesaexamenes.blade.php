@extends('layouts.informes.contenedor')

@section('cuerpo')
<br>
  <div>
    <h6> 
      <p>
      <?php if (isset($carrera->carrera)) {
          echo $carrera->carrera;}?>
      </p>
    </h6>
    <h4> 
      <p>Turno: 
      <?php if (isset($turno->descripcion)) {
          echo $turno->descripcion;}?>
      </p>
    </h4>
    <h4> 
      <p>Ciclo Lectivo: 
      <?php if (isset($ciclo->descripcion)) {
          echo $ciclo->descripcion;}?>
      </p>
    </h4>
  </div>
  <div align="right">
    <h4> 
      <p> 
      <?php 
          echo date ("d/m/Y");?> - {{ Auth::user()->usuario }}
      </p>
    </h4>
  </div>
  
  
  <table class="collapse">
    <thead>
      <tr>
        <td><center><strong>Materia</strong></center></td>
        <td><center><strong>Primer Llamado</strong></center></td>
        <td><center><strong>Hora</strong></center></td>
        <td><center><strong>Segundo Llamado</strong></center></td>
        <td><center><strong>Hora</strong></center></td>
        <td><center><strong>Trib. Docentes</strong></center></td>
      </tr>
    </thead>
    <tbody>
        @if (isset($mesas))
            @foreach ($mesas as $mesa)
              <tr>
                <td><center>{{$mesa['materia']}}</center></td>
                <td><center>{{$mesa['fechaprimerllamado']}}</center></td>
                <td><center>{{$mesa['horaprimerllamado']}}</center></td>
                <td><center>{{$mesa['fechasegundollamado']}}</center></td>
                <td><center>{{$mesa['horasegundollamado']}}</center></td>
                <td><center>{{$mesa['tribunal']}}</center></td>
              </tr>
            @endforeach
    </tbody>
        @endif          
  </table>
@stop
