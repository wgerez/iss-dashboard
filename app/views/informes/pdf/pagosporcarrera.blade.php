@extends('layouts.informes.contenedor')

@section('cuerpo')
  <h3>Pagos de Matrículas</h3>
  <h4>Carrera: {{$carrera->carrera}}</h4>
  <h4>Ciclo Lectivo: {{$ciclo_lectivo->descripcion}}</h4>
  <table class="collapse">
    <thead>
      <tr>
        <td><center><strong>Apellido y Nombre</strong></center></td>
        <td><center><strong>DNI</strong></center></td>
        <!--td><strong>Ciclo Lectivo</strong></td-->
        <td><center><strong>Monto ($)</strong></center></td>
        <td><center><strong>Pagado ($)</strong></center></td>
        <td><center><strong>Fecha Vto.</strong></center></td>
        <td><center><strong>Fecha Pago</strong></center></td>
      </tr>
    </thead>
    <tbody>
        @if (isset($inscripciones))
            <?php
            //$falta = "<img src='" . url('assets/global/img') . "/no_ok.png'>";

            //$ok = "<strong><font color='green'>V</font></strong>";
            $falta = "<strong><font color='red'>X</font></strong>";
            $pagado = '';
            ?>
            @foreach ($inscripciones as $inscripcion)
              <?php
              $persona = $inscripcion->apellido . ', ' . $inscripcion->nombre;

              if ($inscripcion->matriculaaplica) {
                  $arrFechaVto = explode('/', $inscripcion->fechavencimientomatricula);
                  $fecha_vencimiento = FechaHelper::getFechaImpresion($arrFechaVto[0]);

                  if ($inscripcion->ha_pagado == MatriculasController::MATRICULA_IMPAGA) {
                      $fecha_pago = '';
                      $pagado = $falta;
                  } else {
                      $arrFechaPago = explode('/', $inscripcion->pago->fechapago);
                      $fecha_pago = FechaHelper::getFechaImpresion($arrFechaPago[0]);
                      //$monto = $inscripcion->pago->importe;

                      if ($inscripcion->pago->importeparcial == NULL) {
                        $monto = $inscripcion->pago->importe;
                      } else {
                        $monto = $inscripcion->pago->importeparcial;
                      }
                      
                      $recargo = 0;
                      $descuento = 0;

                      if ($inscripcion->pago->porcentajerecargo) {
                          $recargo = ($monto * $inscripcion->pago->porcentajerecargo) / 100;
                      }

                      if ($inscripcion->pago->porcentajedescuento) {
                          $descuento = ($monto * $inscripcion->pago->porcentajedescuento) / 100;
                      }

                      $pagado = number_format(($monto + $recargo - $descuento), 2);
                  }
              } else {
                  $fecha_vencimiento = '';
                  $fecha_pago = '';
                  $pagado = '';
              }
              ?>
              <tr>
                <td><center>{{$persona}}</center></td>
                <td><center>{{$inscripcion->nrodocumento}}</center></td>
                <td><center>{{$inscripcion->matriculaimporte}}</center></td>
                <td><center>{{$pagado}}</center></td>
                <td><center>{{$fecha_vencimiento}}</center></td>
                <td><center>{{$fecha_pago}}</center></td>
              </tr>
            @endforeach
        @endif   
    </tbody>        
  </table>
@stop