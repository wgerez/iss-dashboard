@extends('layouts.informes.contenedor')
@section('cuerpo')
  <h3>Titulo del Plan: {{$planestudio->tituloplan}}</h3>
  <h3>Codigo del Plan: {{$planestudio->codigoplan}}</h3>

    <?php for ($i=1; $i < $cantidad; $i++) { ?>
  <table class="collapse">
    <thead>
      <tr>
        <td><strong>{{$i}}° AÑO</strong></td>
      </tr>
    </thead>
    <tbody><?php
        $bandera = false;
        $bandera2 = false;
        ?>
      @foreach ($materias as $materia)
        <?php
        if ($materia->aniocursado == $i) {
          if ($materia->cuatrimestre == 1 || $materia->cuatrimestre == 0) {
            if ($bandera == false) {
              echo "<tr><td><center><strong>Primer Cuatrimestre</strong></center></td></tr>";
              $bandera = true;
            }
          ?>
          <tr>
            <td>{{$materia->nombremateria}}</td>
          </tr>
          <?php
          }

          /*if ($materia->cuatrimestre == 0) {
            echo "<tr><td>{$materia->nombremateria}</td></tr>";
          }*/

          if ($materia->cuatrimestre == 2) {
            if ($bandera2 == false) {
              echo "<tr><td><center><strong>Segundo Cuatrimestre</strong></center></td></tr>";
              $bandera2 = true;
            }
          ?>
          <tr>
            <td>{{$materia->nombremateria}}</td>
          </tr>
          <?php
          }
        }
        ?>
      @endforeach
    </tbody>
  </table>
    <?php } ?>
@stop
