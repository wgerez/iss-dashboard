@extends('layouts.informes.contenedor')

@section('customstyle')
<!-- BEGIN PAGE LEVEL STYLES -->

<!-- END PAGE LEVEL STYLES -->
@stop
<?php
/*highlight_string(var_export($aperturacaja, true));
exit();*/
?>
@section('cuerpo')
  <h3><center><strong>Fundación de Hospital de Alta Complejidad <br></strong></center>
      <center><strong>"Pte. Juan Domingo Perón" <br></strong></center></h3>
      <center><strong> Av. Nestor Kirchner y Av. Pantaleón <br></strong></center>
      <center><strong>(3600) Formosa <br></strong></center>

  <h3>Cierre de Caja: 000{{$cierrecaja->id}}</h3>
  <h3>Fecha de Cierre: {{$cierrecaja->fechacierre}}</h3>
  <h3>Usuario: {{$usuarios->apellido}}, {{$usuarios->nombre}}</h3> 
  
  <table class="collapse"> <!--width="600"-->
    <thead>
      <tr>
        <td><center><strong>Medio de Pago</strong></center></td>
        <td><center><strong>Subtotal</strong></center></td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><center><strong>Total Efectivo</strong></center></td>
        <td><center><strong>${{$totalefectivo}}</strong></center></td>
      </tr>
      <tr>
        <td><center><strong>Total Tarjeta de Débito</strong></center></td>
        <td><center><strong>${{$totaldebito}}</strong></center></td>
      </tr>
      <tr>
        <td><center><strong>Total Tarjeta de Crédito</strong></center></td>
        <td><center><strong>${{$totaltarjeta}}</strong></center></td>
      </tr>
      <tr>
        <td><center><strong>Total Cuenta Bancaria</strong></center></td>
        <td><center><strong>${{$totalbancaria}}</strong></center></td>
      </tr>
      <tr>
        <td><center><strong>Total Cheques</strong></center></td>
        <td><center><strong>${{$totalcheque}}</strong></center></td>
      </tr>
      <tr>
        <td colspan="2"><center><hr></center></td>
      </tr>
      <tr>
        <td><center><strong>TOTAL GENERAL:</strong></center></td> <td><center><strong>${{$totalgeneralf}} </strong></center></td>
      </tr>
    </tbody>   
  </table>
@stop
