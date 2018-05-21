@extends('layouts.informes.contenedor')

@section('cuerpo')
  <h3><center>Informe de Estado de Cuenta de Alumnos</center></h3>
  <h4>Carrera: {{$carreras}}</h4>
  <h4>Alumno: {{$alumno->apellido}}, {{$alumno->nombre}}.</h4>
  <table class="collapse">
    <thead>
      <tr>
        <td><strong><center>Fecha de Vencimiento</center></strong></td>
        <td><strong><center>Tipo Movimiento</center></strong></td>
        <td><strong><center>Efectivo</center></strong></td>
        <td><strong><center>Tarj. Crédito</center></strong></td>
        <td><strong><center>Tarj. Débito</center></strong></td>
        <td><strong><center>Otros</center></strong></td>
        <td><strong><center>Fecha de Pago</center></strong></td>
        <td><strong><center>Nro Comprobante</center></strong></td>
      </tr>
    </thead>
    <tbody>
        @if (isset($matriculas))
            @foreach ($matriculas as $matricula)
              <?php
              $mesa = $matricula['mescuota'];
              $mespagocuotafin = $matricula['mespagocuotafin'];
              $cuotaperiodopagohasta = $matricula['cuotaperiodopagohasta'];
              $cicloslec = $matricula['cicloslec'];
              ?>
              <tr>
                <td><center>{{$matricula['fechavencimientomatricula']}}</center></td>
                <td><center>{{$matricula['tipomovimiento']}}</center></td>
                <td><center>{{$matricula['efectivo']}}</center></td>
                <td><center>{{$matricula['tarjetacredito']}}</center></td>
                <td><center>{{$matricula['tarjetadebito']}}</center></td>
                <td><center>{{$matricula['otros']}}</center></td>
                <td><center>{{$matricula['fechapago']}}</center></td>
                <td><center>{{$matricula['nrocomprobante']}}</center></td>
              </tr>
            @endforeach
        @endif
        <?php
        if (!$mesa == '') {
          $mesaseguir = $mesa + 1;
          $mespagocuotafins = $mespagocuotafin + 1;

          for ($i=$mesaseguir; $i < $mespagocuotafins; $i++) { 
          ?>
          <tr>
            <td><center>{{$cuotaperiodopagohasta}}/{{$i}}/{{$cicloslec}}</center></td>
            <td><center>Cta. {{$meses[$i]}}</center></td>
            <td><center></center></td>
            <td><center></center></td>
            <td><center></center></td>
            <td><center></center></td>
            <td><center></center></td>
            <td><center></center></td>
          </tr>
          <?php }
        } ?>
    </tbody>          
  </table>
@stop
