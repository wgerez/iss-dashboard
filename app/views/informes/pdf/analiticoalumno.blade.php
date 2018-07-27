@extends('layouts.informes.contenedor')

@section('cuerpo')
  <h3><center>Analitico de Alumno</center></h3>
  @if (isset($datoalumno))
      @foreach ($datoalumno as $datoalumn)
        <h3><center>{{$datoalumn['carrera']}}</center></h3>
        <h4>Alumno: {{$datoalumn['apeynom']}}. &nbsp;&nbsp;&nbsp; DNI: {{$datoalumn['nrodocumento']}} &nbsp;&nbsp;&nbsp; Domicilio: {{$datoalumn['calle']}} &nbsp;&nbsp;&nbsp; Cohorte: {{$datoalumn['cohorte']}}</h4>
        <h4>Lugar y Fecha de Nacimiento: {{$datoalumn['lugarnacimiento']}} &nbsp;&nbsp;&nbsp; Titulo Presentado: {{$datoalumn['titulopresentado']}} &nbsp;&nbsp;&nbsp; Tel/Cel: {{$datoalumn['telefono']}}</h4>
      @endforeach
  @endif
  <table class="collapse">
    <thead>
      <tr>
        <td><strong><center>Unidades Curriculares</center></strong></td>
        <td><strong><center>Régimen</center></strong></td>
        <td><strong><center>Regularizado</center></strong></td>
        <td><strong><center>Fecha Regularización</center></strong></td>
        <td><strong><center>Promociono</center></strong></td>
        <td><strong><center>Aprobó</center></strong></td>
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
              <tr>
                <td><center>{{$analitic['materia']}}</center></td>
                <td><center>{{$analitic['regimen']}}</center></td>
                <td><center>{{$analitic['regularizado']}}</center></td>
                <td><center>{{$analitic['fecha_regularizacion']}}</center></td>
                <td><center>{{$analitic['promociono']}}</center></td>
                <td><center>{{$analitic['aprobo']}}</center></td>
                <td><center>{{$analitic['fecha_aprobacion']}}</center></td>
                <td><center>{{$analitic['calif_final_num']}}</center></td>
                <td><center>({{$analitic['calif_final_let']}})</center></td>
                <td><center>{{$analitic['libro']}}</center></td>
                <td><center>{{$analitic['folio']}}</center></td>
                <td><center>{{$analitic['acta']}}</center></td>
                <td><center>{{$analitic['observaciones']}}</center></td>
              </tr>
            @endforeach
        @endif
    </tbody>          
  </table>
@stop
