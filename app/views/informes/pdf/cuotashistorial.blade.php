@extends('layouts.informes.contenedor')

@section('cuerpo')
  <center><h3>Listado pago de Cuotas</h3></center>
  <?php
$total = 0;
$ultimomes = $mespagocuotainicio;
$mespagocuotafin = $mespagocuotafin;
/*highlight_string(var_export($matriculas, true));
        exit();*/

                  //$fecha_vencimiento = getFechaImpresion(matricula.fechavencimientomatricula);
                  //$fecha = new Date();
                  //$fecha_actual = fecha.getDate() + '/' + (fecha.getMonth() + 1) + '/'
                                 //+ fecha.getFullYear();
                //if (primerFechaMayor(fecha_vencimiento, fecha_actual)) {

?>
<h3>Apellido y Nombre: {{$alumno->apellido}} , {{$alumno->nombre}}</h3>
<h3>Carrera: {{$carreras}}</h3><h3>Ciclo Lectivo: {{$cicloslec}}</h3>
  <table class="collapse">
    <thead>
      <tr>
        <!--td><center><strong>Ciclo Lectivo</strong></center></td-->
        <td><center><strong>Cuota</strong></center></td>
        <td><center><strong>Fecha de Pago</strong></center></td>
        <td><center><strong>Forma de Pago</strong></center></td>
        <td><center><strong>M. descuento</strong></center></td>
        <td><center><strong>M. Recargo</strong></center></td>
        <td><center><strong>Importe</strong></center></td>
        <td><center><strong>Total</strong></center></td>
      </tr>
    </thead>
    <tbody>
        @if (isset($cuota_detalle))
            @foreach ($cuota_detalle as $cuota_detall)
              <?php
              $meses = ['vacio', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
              $efectivo = $cuota_detall['efectivo'];
              $tarjetacredito = $cuota_detall['tarjetacredito'];
              $tarjetadebito = $cuota_detall['tarjetadebito'];
              $cuentabancaria = $cuota_detall['cuentabancaria'];
              $cheque = $cuota_detall['cheque'];
              $cicloslec = $cuota_detall['cicloslec'];
                ?>
                <tr>
                  <!--td><center>{{$cuota_detall['cicloslec']}}</center></td-->
                  <td><center>{{$cuota_detall['mes']}}</center></td>
                  <td><center>{{$cuota_detall['fechatransaccion']}}</center></td>
                  <td><center><?php 
                  if ($efectivo > 0) {
                    echo "Efectivo - ";
                  }
                  if ($tarjetacredito > 0) {
                    echo "Tarjeta de Credito - ";
                  }
                  if ($cuentabancaria > 0) {
                    echo "Cta Bancaria HAC - ";
                  }
                  if ($tarjetadebito > 0) {
                    echo "Tarjeta de Debito - ";
                  }
                  if ($cheque > 0) {
                    echo "Cheque";
                  }
                  ?></center></td>
                  <td><center>${{$cuota_detall['descuentos']}}</center></td>
                  <td><center>${{$cuota_detall['recargos']}}</center></td>
                  <td><center>${{$cuota_detall['importe']}}</center></td>
                  <td><center>${{$cuota_detall['totalpagado']}}</center></td>
                </tr>
                <?php
                $total = $total + $cuota_detall['totalpagado'];
                $mespagocuotafin = $cuota_detall['mespagocuotafin'];
                $ultimomes = $cuota_detall['mescuota'] + 1;
                ?>
            @endforeach
        @endif   
            <?php
            
            $meses = ['vacio', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
            
            if ($mespagocuotafin == 12) $mespagocuotafin++;

            for ($i=$ultimomes; $i < $mespagocuotafin; $i++) { ?>
              <tr class=danger>
                          <!--td><center>{{$cicloslec}}</center></td-->
                          <td><center>{{$meses[$i]}}</center></td>
                          <td><center></center></td>
                          <td><center></center></td>
                          <td><center></center></td>
                          <td><center></center></td>
                          <td><center></center></td>
                          <td><center></center></td>
                        </tr><?php
            }
            ?>
            <tr class=danger>
                          <!--td><center></center></td-->
                          <td colspan="2"><center><strong>TOTAL</strong></center></td>
                          <td><center></center></td>
                          <!--td><center></center></td-->
                          <td><center></center></td>
                          <td><center></center></td>
                          <td><center></center></td>
                          <td><center><strong>${{$total}}</strong></center></td>
                        </tr>
    </tbody>       
  </table>
@stop
