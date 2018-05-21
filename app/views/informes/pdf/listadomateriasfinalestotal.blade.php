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
      <p>Alumno: 
      <?php if (isset($alumno->persona->apellido)) {
          echo$alumno->persona->apellido .' '. $alumno->persona->nombre;}?>
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
        <td><center><strong>Fecha</strong></center></td>
        <td><center><strong>Plan/Estudio</strong></center></td>
        <td><center><strong>Materia A Inscribir</strong></center></td>
      </tr>
    </thead>
    <tbody>
        @if (isset($materias))
            @foreach ($materias as $materia)
              <tr>
                <td><center>{{$materia['fecha']}}</center></td>
                <td><center>{{$materia['plan']}}</center></td>
                <td><center>{{$materia['materia']}}</center></td>

              </tr>
            @endforeach
    </tbody>
        @endif          
  </table>
@stop
