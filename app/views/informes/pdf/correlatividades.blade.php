@extends('layouts.informes.contenedor')

@section('cuerpo')
<br>
  <div>
    <h3><center><strong>
      <p>
        CORRELATIVIDADES
      </p></strong></center>
    </h3>
    <h6> 
      <p>
      <?php if (isset($carrera->carrera)) {
          echo $carrera->carrera;}?>
      </p>
    </h6>
    <h4> 
      <p>Plan de Estudio: 
      <?php if (isset($plan->codigoplan)) {
          echo $plan->codigoplan;}?>
      </p>
    </h4>
    <h4> 
      <p>N° Resolución: 
      <?php if (isset($plan->nroresolucion)) {
          echo $plan->nroresolucion;}?>
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
        <td><center><strong>Año Cursado</strong></center></td>
        <td><center><strong>Periodo</strong></center></td>
        <td><center><strong>Cuatrimestre</strong></center></td>
        <td><center><strong>Materia</strong></center></td>
        <td><center><strong>Haber Cursado</strong></center></td>
        <td><center><strong>Haber Rendido</strong></center></td>
        <td><center><strong>Para rendir Finales</strong></center></td>
      </tr>
    </thead>
    <tbody>
        @if (isset($listacorrelativas))
            @foreach ($listacorrelativas as $listacorrelativa)
              <tr>
                <td><center>{{$listacorrelativa['aniocursado']}}</center></td>
                <td><center>{{$listacorrelativa['periodo']}}</center></td>
                <td><center>{{$listacorrelativa['cuatrimestre']}}</center></td>
                <td><center>{{$listacorrelativa['nombremateria']}}</center></td>
                <td><center>{{$listacorrelativa['cursadas']}}</center></td>
                <td><center>{{$listacorrelativa['aprobadas']}}</center></td>
                <td><center>{{$listacorrelativa['finales']}}</center></td>
              </tr>
            @endforeach
    </tbody>
        @endif          
  </table>
@stop
