@extends('layouts.informes.contenedor')

@section('cuerpo')
  <h3><center>Analítico de Alumno</center></h3>
  @if (isset($datoalumno))
      @foreach ($datoalumno as $datoalumn)
        <h3><center>{{$datoalumn['carrera']}}</center></h3>
        <h4>Alumno: {{$datoalumn['apeynom']}}. &nbsp;&nbsp;&nbsp; DNI: {{$datoalumn['nrodocumento']}} &nbsp;&nbsp;&nbsp; Domicilio: {{$datoalumn['calle']}} &nbsp;&nbsp;&nbsp; Cohorte: {{$datoalumn['cohorte']}}</h4>
        <h4>Lugar y Fecha de Nacimiento: {{$datoalumn['lugarnacimiento']}} &nbsp;&nbsp;&nbsp; Título Presentado: {{$datoalumn['titulopresentado']}} &nbsp;&nbsp;&nbsp; Tel/Cel: {{$datoalumn['telefono']}}</h4>
      @endforeach
  @endif
  <?php
  $anio = 1;
  $aniocursado = ['vacio', 'PRIMER', 'SEGUNDO', 'TERCER', 'CUARTO', 'QUINTO'];
  ?>
  <table class="collapse">
    <thead>
      <tr>
        <td colspan="13"><strong><center>{{$aniocursado[$anio]}} AÑO</center></strong></td>
      </tr>
      <tr>
        <td><strong><center>Unidades Curriculares</center></strong></td>
        <td><strong><center>Régimen</center></strong></td>
        <!--td><strong><center>Regularizado</center></strong></td-->
        <td><strong><center>Fecha Regularización</center></strong></td>
        <td><strong><center>Promocionó</center></strong></td>
        <!--td><strong><center>Aprobó</center></strong></td-->
        <td><strong><center>Fecha Aprobación</center></strong></td>
        <td><strong><center>Calif. Final Número</center></strong></td>
        <td><strong><center>Calif. Final Letra</center></strong></td>
        <td><strong><center>Libro</center></strong></td>
        <td><strong><center>Folio</center></strong></td>
        <td><strong><center>Acta</center></strong></td>
        <td><strong><center>Observaciones</center></strong></td>
      </tr>
    </thead>
    <tbody>
        @if (isset($analitico))
            @foreach ($analitico as $analitic)
            <?php
              if ($analitic['aniocursado'] == 1) {
              ?>
              <tr>
                <td><center>{{$analitic['materia']}}</center></td>
                <td><center>{{$analitic['regimen']}}</center></td>
                <!--td><center>{{$analitic['regularizado']}}</center></td-->
                <td><center>{{$analitic['fecha_regularizacion']}}</center></td>
                <td><center>{{$analitic['promociono']}}</center></td>
                <!--td><center>{{$analitic['aprobo']}}</center></td-->
                <td><center>{{$analitic['fecha_aprobacion']}}</center></td>
                <td><center>{{$analitic['calif_final_num']}}</center></td>
                <td><center>({{$analitic['calif_final_let']}})</center></td>
                <td><center>{{$analitic['libro']}}</center></td>
                <td><center>{{$analitic['folio']}}</center></td>
                <td><center>{{$analitic['acta']}}</center></td>
                <td><center>{{$analitic['observaciones']}}</center></td>
              </tr>
              <?php
              }

              if ($analitic['aniocursado'] == 2) {
                $anio = 2;
              }
              ?>
            @endforeach
        @endif
    </tbody>          
  </table>

  <?php
  if ($anio == 2) {
  ?>
  <table class="collapse">
    <thead>
      <tr>
        <td colspan="13"><strong><center>{{$aniocursado[$anio]}} AÑO</center></strong></td>
      </tr>
      <tr>
        <td><strong><center>Unidades Curriculares</center></strong></td>
        <td><strong><center>Régimen</center></strong></td>
        <!--td><strong><center>Regularizado</center></strong></td-->
        <td><strong><center>Fecha Regularización</center></strong></td>
        <td><strong><center>Promocionó</center></strong></td>
        <!--td><strong><center>Aprobó</center></strong></td-->
        <td><strong><center>Fecha Aprobación</center></strong></td>
        <td><strong><center>Calif. Final Número</center></strong></td>
        <td><strong><center>Calif. Final Letra</center></strong></td>
        <td><strong><center>Libro</center></strong></td>
        <td><strong><center>Folio</center></strong></td>
        <td><strong><center>Acta</center></strong></td>
        <td><strong><center>Observaciones</center></strong></td>
      </tr>
    </thead>
    <tbody>
        @if (isset($analitico))
            @foreach ($analitico as $analitic)
            <?php
              if ($analitic['aniocursado'] == 2) {
              ?>
              <tr>
                <td><center>{{$analitic['materia']}}</center></td>
                <td><center>{{$analitic['regimen']}}</center></td>
                <!--td><center>{{$analitic['regularizado']}}</center></td-->
                <td><center>{{$analitic['fecha_regularizacion']}}</center></td>
                <td><center>{{$analitic['promociono']}}</center></td>
                <!--td><center>{{$analitic['aprobo']}}</center></td-->
                <td><center>{{$analitic['fecha_aprobacion']}}</center></td>
                <td><center>{{$analitic['calif_final_num']}}</center></td>
                <td><center>({{$analitic['calif_final_let']}})</center></td>
                <td><center>{{$analitic['libro']}}</center></td>
                <td><center>{{$analitic['folio']}}</center></td>
                <td><center>{{$analitic['acta']}}</center></td>
                <td><center>{{$analitic['observaciones']}}</center></td>
              </tr>
              <?php
            }

              if ($analitic['aniocursado'] == 3) {
                $anio = 3;
              }
              ?>
            @endforeach
        @endif
    </tbody>          
  </table>
  <?php
    }
  ?>

  <?php
  if ($anio == 3) {
  ?>
  <table class="collapse">
    <thead>
      <tr>
        <td colspan="13"><strong><center>{{$aniocursado[$anio]}} AÑO</center></strong></td>
      </tr>
      <tr>
        <td><strong><center>Unidades Curriculares</center></strong></td>
        <td><strong><center>Régimen</center></strong></td>
        <!--td><strong><center>Regularizado</center></strong></td-->
        <td><strong><center>Fecha Regularización</center></strong></td>
        <td><strong><center>Promocionó</center></strong></td>
        <!--td><strong><center>Aprobó</center></strong></td-->
        <td><strong><center>Fecha Aprobación</center></strong></td>
        <td><strong><center>Calif. Final Número</center></strong></td>
        <td><strong><center>Calif. Final Letra</center></strong></td>
        <td><strong><center>Libro</center></strong></td>
        <td><strong><center>Folio</center></strong></td>
        <td><strong><center>Acta</center></strong></td>
        <td><strong><center>Observaciones</center></strong></td>
      </tr>
    </thead>
    <tbody>
        @if (isset($analitico))
            @foreach ($analitico as $analitic)
            <?php
              if ($analitic['aniocursado'] == 3) {
              ?>
              <tr>
                <td><center>{{$analitic['materia']}}</center></td>
                <td><center>{{$analitic['regimen']}}</center></td>
                <!--td><center>{{$analitic['regularizado']}}</center></td-->
                <td><center>{{$analitic['fecha_regularizacion']}}</center></td>
                <td><center>{{$analitic['promociono']}}</center></td>
                <!--td><center>{{$analitic['aprobo']}}</center></td-->
                <td><center>{{$analitic['fecha_aprobacion']}}</center></td>
                <td><center>{{$analitic['calif_final_num']}}</center></td>
                <td><center>({{$analitic['calif_final_let']}})</center></td>
                <td><center>{{$analitic['libro']}}</center></td>
                <td><center>{{$analitic['folio']}}</center></td>
                <td><center>{{$analitic['acta']}}</center></td>
                <td><center>{{$analitic['observaciones']}}</center></td>
              </tr>
              <?php
            }
            
              if ($analitic['aniocursado'] == 4) {
                $anio = 4;
              }
              ?>
            @endforeach
        @endif
    </tbody>          
  </table>
  <?php
    }
  ?>

  <?php
  if ($anio == 4) {
  ?>
  <table class="collapse">
    <thead>
      <tr>
        <td colspan="13"><strong><center>{{$aniocursado[$anio]}} AÑO</center></strong></td>
      </tr>
      <tr>
        <td><strong><center>Unidades Curriculares</center></strong></td>
        <td><strong><center>Régimen</center></strong></td>
        <!--td><strong><center>Regularizado</center></strong></td-->
        <td><strong><center>Fecha Regularización</center></strong></td>
        <td><strong><center>Promocionó</center></strong></td>
        <!--td><strong><center>Aprobó</center></strong></td-->
        <td><strong><center>Fecha Aprobación</center></strong></td>
        <td><strong><center>Calif. Final Número</center></strong></td>
        <td><strong><center>Calif. Final Letra</center></strong></td>
        <td><strong><center>Libro</center></strong></td>
        <td><strong><center>Folio</center></strong></td>
        <td><strong><center>Acta</center></strong></td>
        <td><strong><center>Observaciones</center></strong></td>
      </tr>
    </thead>
    <tbody>
        @if (isset($analitico))
            @foreach ($analitico as $analitic)
            <?php
              if ($analitic['aniocursado'] == 4) {
              ?>
              <tr>
                <td><center>{{$analitic['materia']}}</center></td>
                <td><center>{{$analitic['regimen']}}</center></td>
                <!--td><center>{{$analitic['regularizado']}}</center></td-->
                <td><center>{{$analitic['fecha_regularizacion']}}</center></td>
                <td><center>{{$analitic['promociono']}}</center></td>
                <!--td><center>{{$analitic['aprobo']}}</center></td-->
                <td><center>{{$analitic['fecha_aprobacion']}}</center></td>
                <td><center>{{$analitic['calif_final_num']}}</center></td>
                <td><center>({{$analitic['calif_final_let']}})</center></td>
                <td><center>{{$analitic['libro']}}</center></td>
                <td><center>{{$analitic['folio']}}</center></td>
                <td><center>{{$analitic['acta']}}</center></td>
                <td><center>{{$analitic['observaciones']}}</center></td>
              </tr>
              <?php
            }
            
              if ($analitic['aniocursado'] == 5) {
                $anio = 5;
              }
              ?>
            @endforeach
        @endif
    </tbody>          
  </table>
  <?php
    }
  ?>

  <?php
  if ($anio == 5) {
  ?>
  <table class="collapse">
    <thead>
      <tr>
        <td colspan="13"><strong><center>{{$aniocursado[$anio]}} AÑO</center></strong></td>
      </tr>
      <tr>
        <td><strong><center>Unidades Curriculares</center></strong></td>
        <td><strong><center>Régimen</center></strong></td>
        <!--td><strong><center>Regularizado</center></strong></td-->
        <td><strong><center>Fecha Regularización</center></strong></td>
        <td><strong><center>Promocionó</center></strong></td>
        <!--td><strong><center>Aprobó</center></strong></td-->
        <td><strong><center>Fecha Aprobación</center></strong></td>
        <td><strong><center>Calif. Final Número</center></strong></td>
        <td><strong><center>Calif. Final Letra</center></strong></td>
        <td><strong><center>Libro</center></strong></td>
        <td><strong><center>Folio</center></strong></td>
        <td><strong><center>Acta</center></strong></td>
        <td><strong><center>Observaciones</center></strong></td>
      </tr>
    </thead>
    <tbody>
        @if (isset($analitico))
            @foreach ($analitico as $analitic)
            <?php
              if ($analitic['aniocursado'] == 5) {
              ?>
              <tr>
                <td><center>{{$analitic['materia']}}</center></td>
                <td><center>{{$analitic['regimen']}}</center></td>
                <!--td><center>{{$analitic['regularizado']}}</center></td-->
                <td><center>{{$analitic['fecha_regularizacion']}}</center></td>
                <td><center>{{$analitic['promociono']}}</center></td>
                <!--td><center>{{$analitic['aprobo']}}</center></td-->
                <td><center>{{$analitic['fecha_aprobacion']}}</center></td>
                <td><center>{{$analitic['calif_final_num']}}</center></td>
                <td><center>({{$analitic['calif_final_let']}})</center></td>
                <td><center>{{$analitic['libro']}}</center></td>
                <td><center>{{$analitic['folio']}}</center></td>
                <td><center>{{$analitic['acta']}}</center></td>
                <td><center>{{$analitic['observaciones']}}</center></td>
              </tr>
              <?php
            }
            
              if ($analitic['aniocursado'] == 6) {
                $anio = 6;
              }
              ?>
            @endforeach
        @endif
    </tbody>          
  </table>
  <?php
    }
  ?>
@stop
