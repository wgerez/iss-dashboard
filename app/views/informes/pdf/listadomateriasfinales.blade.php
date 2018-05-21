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
      <p>Llamado: 
      <?php if (isset($llamado)) {
          echo $llamado;}?>
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
        <td><center><strong>Fecha Final</strong></center></td>
        <td><center><strong>Alumno</strong></center></td>
        <td><center><strong>Plan/Estudio</strong></center></td>
        <td><center><strong>Materia Inscripta</strong></center></td>
        <td><center><strong>Docente Titular</strong></center></td>
        <td><center><strong>Anulado</strong></center></td>
      </tr>
    </thead>
    <tbody>
        @if (isset($inscriptos))
            @foreach ($inscriptos as $inscripto)
              <tr>
                <td><center>{{$inscripto['fecha']}}</center></td>
                <td><center>{{$inscripto['alumno']}}</center></td>
                <td><center>{{$inscripto['plan']}}</center></td>
                <td><center>{{$inscripto['materia']}}</center></td>
                <td><center>{{$inscripto['docentetitular']}}</center></td>
                @if ($inscripto['anulado'] == 1)
                  <td><center>SI</center></td>
                @else
                  <td><center>-</center></td>
                @endif
                <!--<td><center>{{$inscripto['anulado']}}</center></td>-->
              </tr>
            @endforeach
    </tbody>
        @endif          
  </table>
@stop
