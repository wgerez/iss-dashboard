@extends('layouts.informes.contenedor')

@section('customstyle')
<!-- BEGIN PAGE LEVEL STYLES -->

<style>
table {
    width: 20%;
	height: 100px;
}
</style>
<!-- END PAGE LEVEL STYLES -->
@stop
<?php
/*highlight_string(var_export($cajachicas, true));
exit();*/
?>
@section('cuerpo')
  <h3></h3>
  
  <table class="collapse"> <!--width="600"-->
    <thead>
      <tr>
        <td>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <center><strong>Fundación de Hospital de <br>
         Alta Complejidad <br>
         "Pte. Juan Domingo Perón" <br>
         </strong> Av. Nestor Kirchner y Av. Pantaleón <br>
         (3600) Formosa <br>
         <strong>I.V.A. EXENTO</strong></center></td>

        <td><center><font size=10>C</font><br></center></td>

        <td><center>&nbsp;&nbsp;&nbsp;</center></td>

        <td><strong>N° 0001-{{$cajachicas->numeromovimiento}}<br>
        FECHA: {{$cajachicas->fechatransaccion}}<br>
        CUIT. N°: 30-71233107-7<br>
        ING. BRUTOS: 30-71233107-7<br>
        INICIO DE ACTIVIDADES: 02/2013</strong></td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td colspan="4">Señor/es: <strong><?php if (!$persona == '') { echo $persona->apellido.', '.$persona->nombre; } ?></strong></td>
      </tr>
      <tr>
        <td colspan="4">Domicilio: <strong><?php if (!$persona == '') { echo $persona->calle.' - ';
        if ($persona->numero == 0) {
          echo "S/N";
          } else {
            echo $persona->numero;
            } } ?></strong></td>
      </tr>
      <tr>
      	<td colspan="4">
	        <table class="collapse">
			    <thead>
			      <tr>
			        <td><strong>I.V.A.</strong></td>

			        <td><label>Exento<input type="checkbox" name="exento" id="exento"></label></td>

			        <td><label>No Resp.<input type="checkbox" name="noresp" id="noresp"></label></td>

			        <td><label>C. Final<input type="checkbox" name="cfinal" id="cfinal"></label></td>

			        <td><label>Resp. Insc.<input type="checkbox" name="respinsc" id="respinsc"></label></td>

			        <td><label>Monotributo<input type="checkbox" name="monotributo" id="monotributo"></label></td>

			        <td><strong>CUIT N°:</strong><?php 
              if (isset($persona->cuil)) {
                echo $persona->cuil;
              } else {
                echo "........................";
              } ?></td>

			      </tr>
			    </thead>
			</table>
		</td>
      </tr>
      <tr>
        <td colspan="4">Recibi (mos) la suma de pesos: <strong> {{ $montonumero }} </strong></td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4">en Concepto de: <strong>{{ $cajachicas->concepto->descripcion }} - {{ $cajachicas->observacionconcepto }}</strong></td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4">Efectivo: <strong> <?php if ($cajachicas->efectivo > 0) echo $cajachicas->efectivo; ?> </strong></td>
      </tr>
      <tr>
        <td colspan="4">Tarjeta de Crédito: <strong> <?php if ($cajachicas->tarjetacredito > 0) echo $cajachicas->tarjetacredito; ?> </strong></td>
      </tr>
      <tr>
        <td colspan="4">Tarjeta de Débito: <strong> <?php if ($cajachicas->tarjetadebito > 0) echo $cajachicas->tarjetadebito; ?> </strong></td>
      </tr>
      <tr>
        <td colspan="4">Cuenta Bancaria: <strong> <?php if ($cajachicas->cuentabancaria > 0) echo $cajachicas->cuentabancaria; ?> </strong></td>
      </tr>
      <tr>
        <td colspan="4">Cheque c/banco: <strong> <?php if ($cajachicas->cheque > 0) echo $cajachicas->cheque; ?> </strong></td>
        <!--td colspan="2">N°: <?php 
              //if ($cajachicas->formapago_id == 2) {
                //echo $cajachicas->observacionpago;
              //} ?></td-->
      </tr>
      <!--tr>
        <td colspan="4">Recibo Ingresos Brutos N°:</td>
      </tr-->
      <tr>
      	<td colspan="2">
	        <table class="collapse">
			    <thead>
			      <tr>
			        <td><H3><strong><?php
              if ($cajachicas->movimiento_id == 1) {
                 echo "RECIBO";
               } elseif ($cajachicas->movimiento_id == 2) {
                 echo "FACTURA";
               } else {
                 echo "REMITO";
               }

              ?></strong></H3><br>
			        <table class="collapse">
                <thead>
                  <tr>
                    <td>
                      <strong>TOTAL</strong>
                    </td>
                    <td>
                      <input type="text" name="total" id="total" value="$ {{$monto}}"><br>
                    </td>
                  </tr>
                </thead>
              </table>
			        </td>
			      </tr>
			    </thead>
			</table>
		</td>
      	<td colspan="2">
	        <table class="collapse">
			    <thead>
			      <tr>
			        <td><H3><strong>FIRMA:</strong></H3><br>
			        <H3><strong>ACLARACION:</strong></H3>
			      	</td>
			      </tr>
			    </thead>
			</table>
		</td>
      </tr>
    </tbody>   
  </table>
@stop
