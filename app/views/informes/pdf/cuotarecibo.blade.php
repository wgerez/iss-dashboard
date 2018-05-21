@extends('layouts.informes.contenedor')

@section('cuerpo')
  <h3><center></center></h3>
            <?php
            $observaciones = '';
                ?>
      
          <table class="collapse">
            <thead>
              <tr>
                <td></td><td></td><td></td><td><strong>N°: 0000{{$matriculas['id']}}</strong></td>
              </tr>
              <tr>
                <td><strong><h4>Carrera: </h4></strong></td><td colspan="2"><strong>{{$matriculas['carrera']}}</strong></td><td></td>
              </tr>
              <tr>
                <td><strong><h4>Apellido y Nombre:</h4></strong></td><td colspan="2">{{$matriculas['apeynom']}}</td><td></td>
              </tr>
              <tr>
                <td><strong><h4>N° Documento:</h4></strong></td><td colspan="2">{{$matriculas['dni']}}</td><td></td>
              </tr>
              <tr>
                <td><strong><h4>Ciclo Lectivo:</h4></strong></td><td colspan="2">{{$matriculas['ciclo']}}</td><td></td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><strong><h4>Cuota:</h4></strong></td><td colspan="4"><?php 
                foreach ($matriculas['cuotasmeses'] as $value) {
                   echo $value['mes'] . ' ';
                   $observaciones = $value['observaciones'];
                 } ?></td>
              </tr>
              <!--tr>
                <td></td><td colspan="2"><strong><h4>Formas de Pago</h4></strong></td><td></td>
              </tr-->
              <?php if ($matriculas['efectivo'] == 0 && $matriculas['credito'] == 0 && $matriculas['debito'] == 0 && $matriculas['bancaria'] == 0 && $matriculas['cheque'] == 0) { ?>
                <tr>
                  <td><strong>Efectivo:</strong></td><td></td><td></td><td><center>{{$matriculas['cuotames']}}</center></td>
                </tr>
                <tr>
                  <td><strong>Tarjeta de Crédito:</strong></td><td></td><td></td><td><center><?php if($matriculas['credito'] == 0) {echo "-";} else {echo $matriculas['credito'];} ?></center></td>
                </tr>
                <tr>
                  <td><strong>Tarjeta de Débito:</strong></td><td></td><td></td><td><center><?php if($matriculas['debito'] == 0) {echo "-";} else {echo $matriculas['debito'];} ?></center></td>
                </tr>
                <tr>
                  <td><strong>Cta Bancaria:</strong></td><td></td><td></td><td><center><?php if($matriculas['bancaria'] == 0) {echo "-";} else {echo $matriculas['bancaria'];} ?></center></td>
                </tr>
                <tr>
                  <td><strong>Cheque:</strong></td><td></td><td></td><td><center><?php if($matriculas['cheque'] == 0) {echo "-";} else {echo $matriculas['cheque'];} ?></center></td>
                </tr>
              <?php } else { ?>
                <tr>
                  <td><strong>Efectivo:</strong></td><td></td><td></td><td><center><?php if($matriculas['efectivo'] == 0) {echo "-";} else {echo $matriculas['efectivo'];} ?></center></td>
                </tr>
                <tr>
                  <td><strong>Tarjeta de Crédito:</strong></td><td></td><td></td><td><center><?php if($matriculas['credito'] == 0) {echo "-";} else {echo $matriculas['credito'];} ?></center></td>
                </tr>
                <tr>
                  <td><strong>Tarjeta de Débito:</strong></td><td></td><td></td><td><center><?php if($matriculas['debito'] == 0) {echo "-";} else {echo $matriculas['debito'];} ?></center></td>
                </tr>
                <tr>
                  <td><strong>Cta Bancaria:</strong></td><td></td><td></td><td><center><?php if($matriculas['bancaria'] == 0) {echo "-";} else {echo $matriculas['bancaria'];} ?></center></td>
                </tr>
                <tr>
                  <td><strong>Cheque:</strong></td><td></td><td></td><td><center><?php if($matriculas['cheque'] == 0) {echo "-";} else {echo $matriculas['cheque'];} ?></center></td>
                </tr>
              <?php } ?>
              <tr>
                <td><strong>Descuento:</strong></td><td></td><td></td><td><center>{{$matriculas['descuento']}}</center></td>
              </tr>
              <tr>
                <td><strong>Recargo:</strong></td><td></td><td></td><td><center>{{$matriculas['recargo']}}</center></td>
              </tr>
              <tr>
                <td><strong>Observaciones:</strong></td><td colspan="3">{{$observaciones}}</td>
              </tr>
              <tr>
                <td></td><td><strong><h4>Total:</h4></strong></td><td></td><td><strong><?php 
                
                  echo $matriculas['total'];
               ?></strong></td>
              </tr>  
            </tbody>       
          </table>
@stop
