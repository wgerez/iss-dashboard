@extends('layouts.informes.contenedor')

@section('cuerpo')
  <h3>Pagos de Matrículas</h3>
  <table class="collapse">
    <thead>
      <tr>
        <td><strong>Apellido y Nombre</strong></td>
        <td><strong>DNI</strong></td>
        <td><strong>Carrera</strong></td>
        <td><strong>Ciclo Lectivo</strong></td>
        <td><strong>Monto ($)</strong></td>
        <td><strong>Pagado ($)</strong></td>
        <td><strong>Fecha Vto.</strong></td>
        <td><strong>Fecha Pago</strong></td>
      </tr>
    </thead>
    <tbody>
        @if (isset($personas))
            <?php
            //$falta = "<img src='" . url('assets/global/img') . "/no_ok.png'>";
            $falta = "<strong><font color='red'>X</font></strong>";
            $pagado = '';
            ?>
            @foreach ($personas as $persona)
              <?php
              $alumno = $persona->apellido . ', ' . $persona->nombre;

              //highlight_string(var_export($persona,true));
              //exit;

              foreach ($persona->inscripciones as $inscripcion) :
                if ((int)$inscripcion->tiene_matricula != (int)MatriculasController::NO_EXISTE_MATRICULA) :
                    if ($inscripcion->matricula->matriculaaplica) {
                        $arrFechaVto = explode('/', $inscripcion->matricula->fechavencimientomatricula);
                        $fecha_vencimiento = FechaHelper::getFechaImpresion($arrFechaVto[0]);

                        if ($inscripcion->ha_pagado == MatriculasController::MATRICULA_IMPAGA) {
                            $fecha_pago = '';
                            $pagado = $falta;
                        } else {
                            $arrFechaPago = explode('/', $inscripcion->pago->fechapago);
                            $fecha_pago = FechaHelper::getFechaImpresion($arrFechaPago[0]);
                            $monto = $inscripcion->pago->importe;
                            $recargo = 0;
                            $descuento = 0;

                            if ($inscripcion->pago->porcentajerecargo) {
                                $recargo = ($monto * $inscripcion->pago->porcentajerecargo) / 100;
                            }

                            if ($inscripcion->pago->porcentajedescuento) {
                                $descuento = ($monto * $inscripcion->pago->porcentajedescuento) / 100;
                            }

                            //$pagado = $monto + $recargo - $descuento;
                            $pagado = number_format(($monto + $recargo - $descuento), 2);
                        }
                    } else {
                        $fecha_vencimiento = '';
                        $fecha_pago = '';
                        $pagado = '';
                    }
                    $importe_matricula = $inscripcion->matricula->matriculaimporte;
                    ?>
                      <tr>
                        <td>{{$alumno}}</td>
                        <td>{{$persona->nrodocumento}}</td>
                        <td>{{$inscripcion->carrera->carrera}}</td>
                        <td>{{$inscripcion->ciclo}}</td>
                        <td>{{$importe_matricula}}</td>
                        <td>{{$pagado}}</td>
                        <td>{{$fecha_vencimiento}}</td>
                        <td>{{$fecha_pago}}</td>
                      </tr>
                <?php endif; ?>
              @endforeach
            @endforeach
        @endif   
    </tbody>        
  </table>
@stop