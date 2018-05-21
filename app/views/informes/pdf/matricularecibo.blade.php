@extends('layouts.informes.contenedor')

@section('cuerpo')
  <h3><center>Detalle Pago Matricula</center></h3>
            <?php
            /*highlight_string(var_export($matriculas, true));
                exit();*/
                ?>
      @if (isset($matriculas))
        @foreach ($matriculas as $matricula)
          <table class="collapse">
            <thead>
              <tr>
                <td></td><td></td><td></td><td><strong>N°: 0000{{$matricula['id']}}</strong></td>
              </tr>
              <tr>
                <td><strong>Carrera: </strong></td><td colspan="2"><strong>{{$matricula['carrera']}}</strong></td><td></td>
              </tr>
              <tr>
                <td><strong>Ciclo Lectivo: </strong></td><td colspan="2"><strong>{{$matricula['ciclo']}}</strong></td><td></td>
              </tr>
              <tr>
                <td><strong>Apellido y Nombre:</strong></td><td colspan="2">{{$matricula['apeynom']}}</td><td></td>
              </tr>
              <tr>
                <td><strong>N° Documento:</strong></td><td colspan="2">{{$matricula['dni']}}</td><td></td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><strong>Importe:</strong></td><td></td><td></td><td>{{$matricula['matriculaimporte']}}</td>
              </tr>
              <tr>
                <td><strong>Descuento:</strong></td><td></td><td></td><td>{{$matricula['descuento']}} %</td>
              </tr>
              <tr>
                <td><strong>Recargo:</strong></td><td></td><td></td><td>{{$matricula['recargo']}} %</td>
              </tr>
              <?php
              if (!$matricula['importeparcial'] == NULL) {
                echo "<tr><td><strong>Pago Parcial:</strong></td><td></td><td></td><td>{$matricula['importeparcial']}</td></tr>";
              } else {
                echo "<tr><td><strong>Pago Total:</strong></td><td></td><td></td><td>{$matricula['importe']}</td></tr>";
              }
              ?>
              <tr>
                <td><strong>Saldo:</strong></td><td></td><td></td><td>{{$matricula['saldo']}}</td>
              </tr>
              <tr>
                <td></td><td colspan="2"><strong><h4>Formas de Pago</h4></strong></td><td></td>
              </tr>
              <tr>
                <td><strong>Efectivo:</strong></td><td></td><td></td><td><?php if($matricula['efectivo'] == 0) {echo "-";} else {echo $matricula['efectivo'];} ?></td>
              </tr>
              <tr>
                <td><strong>Tarjeta de Crédito:</strong></td><td></td><td></td><td><?php if($matricula['credito'] == 0) {echo "-";} else {echo $matricula['credito'];} ?></td>
              </tr>
              <tr>
                <td><strong>Tarjeta de Débito:</strong></td><td></td><td></td><td><?php if($matricula['debito'] == 0) {echo "-";} else {echo $matricula['debito'];} ?></td>
              </tr>
              <tr>
                <td><strong>Cta Bancaria:</strong></td><td></td><td></td><td><?php if($matricula['bancaria'] == 0) {echo "-";} else {echo $matricula['bancaria'];} ?></td>
              </tr>
              <tr>
                <td></td><td><strong><h4>Total:</h4></strong></td><td></td><td><strong><?php 
                if ($matricula['totalparcial'] == 1) {
                  echo $matricula['importeparcial'];
                } else {
                  echo $matricula['importe'];
                } ?></strong></td>
              </tr>  
            </tbody>       
          </table>
        @endforeach
      @endif   
@stop
