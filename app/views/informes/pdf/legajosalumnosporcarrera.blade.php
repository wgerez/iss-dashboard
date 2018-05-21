@extends('layouts.informes.contenedor')

@section('cuerpo')
  <h3>Legajos de Alumnos</h3>
  <h4>Carrera: {{$carrera}} - Ciclo Lectivo: {{$ciclo}}</h4>
  <div class="form-group" align='center'>
    <small>
      DNI = Fotocopia DNI | Fotos = 3 fotos 4x4 | PN = Partida de Nacimiento | FM = Ficha Médica | CV = Constancia de Vacunación <br>
      FP = Ficha de Preinscripción | FTS = Fotocopia Título Secundario | CTT = Constancia de Título en Trámite | CT = Constancia de Trabajo | S = Seguro | FVS = Fecha Vencimiento Seguro
    </small>
    </div>
  <table class="collapse">
    <thead>
      <tr>
        <td><center><strong>Apellido y Nombre</strong></center></td>
        <td><center><strong>DNI</strong></center></td>
        <td><center><strong>Fotos</strong></center></td>
        <td><center><strong>PN</strong></center></td>
        <td><center><strong>FM</strong></center></td>
        <td><center><strong>CV</strong></center></td>
        <td><center><strong>FP</strong></center></td>
        <td><center><strong>FTS</strong></center></td>
        <td><center><strong>CTT</strong></center></td>
        <td><center><strong>CT</strong></center></td>
        <td><center><strong>S</strong></center></td>
        <td><center><strong>FVS</strong></center></td>
        <td><center><strong>Otros</strong></center></td>
      </tr>
    </thead>
    <tbody>
        @if (isset($legajos))
        <?php if (!$legajos == '') {
        ?>
            @foreach ($legajos as $legajo)
              <?php
              //$ok = "ok.png";
              //$falta = "no_ok.png";

              $ok = "<strong><font color='green'>V</font></strong>";
              $falta = "<strong><font color='red'>X</font></strong>";

              $dni  = ($legajo['dni']) ? $ok : $falta;
              $foto = ($legajo['foto']) ? $ok : $falta;
              $partida_nacimiento = ($legajo['partidanacimiento']) ? $ok : $falta;
              $certificado_buena_salud = ($legajo['certificadobuenasalud']) ? $ok : $falta;
              $certificado_vacunacion = ($legajo['certificadovacinacion']) ? $ok : $falta;
              $ficha_preinscripcion = ($legajo['fichapreinscripcion']) ? $ok : $falta;
              $titulo_secundario = ($legajo['titulosecundario']) ? $ok : $falta;
              $titulo_tramite = ($legajo['constitulotramite']) ? $ok : $falta;
              $constancia_trabajo = ($legajo['constanciatrabajo']) ? $ok : $falta;
              $seguro = ($legajo['seguro']) ? $ok : $falta;
              $otros = ($legajo['otros']) ? $ok : $falta;
              $fecha_vencimiento = '';

              if ($legajo['seguro'] == 1) {
                $fecha_vencimiento = FechaHelper::getFechaImpresion($legajo['fechavencimientoseguro']);
              }
              ?>
              <tr>
                <td>{{$legajo['apellido']}} , {{$legajo['nombre']}}</td>
                <!--<td><img src="{{url('assets/global/img')}}/{{$dni}}"></td>
                <td><img src="{{url('assets/global/img')}}/{{$foto}}"></td>
                <td><img src="{{url('assets/global/img')}}/{{$partida_nacimiento}}"></td>
                <td><img src="{{url('assets/global/img')}}/{{$certificado_buena_salud}}"></td>
                <td><img src="{{url('assets/global/img')}}/{{$certificado_vacunacion}}"></td>
                <td><img src="{{url('assets/global/img')}}/{{$ficha_preinscripcion}}"></td>
                <td><img src="{{url('assets/global/img')}}/{{$titulo_secundario}}"></td>
                <td><img src="{{url('assets/global/img')}}/{{$constancia_trabajo}}"></td>
                <td><img src="{{url('assets/global/img')}}/{{$otros}}"></td>-->
                <td><center>{{$dni}}</center></td>
                <td><center>{{$foto}}</center></td>
                <td><center>{{$partida_nacimiento}}</center></td>
                <td><center>{{$certificado_buena_salud}}</center></td>
                <td><center>{{$certificado_vacunacion}}</center></td>
                <td><center>{{$ficha_preinscripcion}}</center></td>
                <td><center>{{$titulo_secundario}}</center></td>
                <td><center>{{$titulo_tramite}}</center></td>
                <td><center>{{$constancia_trabajo}}</center></td>
                <td><center>{{$seguro}}</center></td>
                <td><center>{{$fecha_vencimiento}}</center></td>
                <td><center>{{$otros}}</center></td>
              </tr>
            @endforeach
             <?php }
        ?>
        @endif   
    </tbody>        
  </table>
@stop