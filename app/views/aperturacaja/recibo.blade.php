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

  <h3>Apertura de Caja: 000{{$aperturacaja->id}}</h3>
  <h3>Fecha de Apertura: {{$aperturacaja->fechaapertura}}</h3>
  <h3>Usuario: {{$usuarios->apellido}}, {{$usuarios->nombre}}</h3> 
  
  <table class="collapse"> <!--width="600"-->
    <thead>
      <tr>
        <td><center><strong>Denominación</strong></center></td>
        <td><center><strong>Cantidad</strong></center></td>
        <td><center><strong>Subtotal</strong></center></td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><center><strong>Billete de $500</strong></center></td>
        <td><center><strong>{{$aperturacaja->cantidad500}}</strong></center></td>
        <td><center><strong>${{$aperturacaja->total500}}</strong></center></td>
      </tr>
      <tr>
        <td><center><strong>Billete de $200</strong></center></td>
        <td><center><strong>{{$aperturacaja->cantidad200}}</strong></center></td>
        <td><center><strong>${{$aperturacaja->total200}}</strong></center></td>
      </tr>
      <tr>
        <td><center><strong>Billete de $100</strong></center></td>
        <td><center><strong>{{$aperturacaja->cantidad100}}</strong></center></td>
        <td><center><strong>${{$aperturacaja->total100}}</strong></center></td>
      </tr>
      <tr>
        <td><center><strong>Billete de $50</strong></center></td>
        <td><center><strong>{{$aperturacaja->cantidad50}}</strong></center></td>
        <td><center><strong>${{$aperturacaja->total50}}</strong></center></td>
      </tr>
      <tr>
        <td><center><strong>Billete de $20</strong></center></td>
        <td><center><strong>{{$aperturacaja->cantidad20}}</strong></center></td>
        <td><center><strong>${{$aperturacaja->total20}}</strong></center></td>
      </tr>
      <tr>
        <td><center><strong>Billete de $10</strong></center></td>
        <td><center><strong>{{$aperturacaja->cantidad10}}</strong></center></td>
        <td><center><strong>${{$aperturacaja->total10}}</strong></center></td>
      </tr>
      <tr>
        <td><center><strong>Billete de $5</strong></center></td>
        <td><center><strong>{{$aperturacaja->cantidad5}}</strong></center></td>
        <td><center><strong>${{$aperturacaja->total5}}</strong></center></td>
      </tr>
      <tr>
        <td><center><strong>Billete de $2</strong></center></td>
        <td><center><strong>{{$aperturacaja->cantidad2}}</strong></center></td>
        <td><center><strong>${{$aperturacaja->total2}}</strong></center></td>
      </tr>
      <tr>
        <td><center><strong>Monedas $</strong></center></td>
        <td><center><strong> </strong></center></td>
        <td><center><strong>${{$aperturacaja->monedas}}</strong></center></td>
      </tr>
      <tr>
        <td colspan="2"><center><strong>Total:</strong></center></td> <td><center><strong>${{$aperturacaja->totalgeneral}} </strong></center></td>
      </tr>
    </tbody>   
  </table>
@stop
