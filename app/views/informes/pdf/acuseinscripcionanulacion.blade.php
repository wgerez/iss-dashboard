@extends('layouts.informes.contenedor')

@section('cuerpo')
<br>
  <div>
      <center><h4><strong>Anulación de Inscripción a Materia Final</strong></h4></center>
    <h6> 
      <p>
      <?php if ($mesa->carrera->carrera) {
          echo $mesa->carrera->carrera;
        }?>
      </p>
    </h6>
    <h4> 
      <p> 
      <?php if ($llamado) {
          echo $llamado;
        }?>
      </p>
    </h4>
    <h4> 
      <p>Turno: 
      <?php if ($mesa->turnoexamen->descripcion) {
          echo $mesa->turnoexamen->descripcion;
        }?>
      </p>
    </h4>
    <h4> 
      <p>Alumno: 
      <?php if ($inscripcion->alumno->persona->apellido) {
          echo $inscripcion->alumno->persona->apellido .' '. $inscripcion->alumno->persona->nombre;
        }?>
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
        <td><center><strong>Materia Inscriptas</strong></center></td>
        <td><center><strong>Plan/Estudio</strong></center></td>
        <td><center><strong>Docente Titular</strong></center></td>
      </tr>
    </thead>
    <tbody>
            <tr>
              <td><center>{{$fecha}}</center></td>
              <td><center>{{$materia}}</center></td>
              <td><center>{{$plan}}</center></td>
              <td><center>{{$tribunal}}</center></td>
            </tr> 
    </tbody>
            
  </table>
@stop
