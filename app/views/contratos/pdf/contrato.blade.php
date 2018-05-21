@extends('layouts.informes.contenedor_contrato')

@section('estilo')
  <style> 
    .clausulas {
      margin-top:5px;
      font-size:12px;
      font-family: Arial, Helvetica;
    }

    .encabezado_titulo {
      margin-top:10px;
      font-size:13px;
      font-family: Arial, Helvetica;
    }

    .salto_pagina {
      page-break-after: always;
    }
  </style>
@stop

@section('cuerpo')
  <div align='center' class='encabezado_titulo'>
  	<strong><u>{{$contrato->titulo}}</u></strong>
  </div>
  <br>

  <?php
  list($hoja1, $hoja2) = explode(' judicial.-', $contrato->clausulas);
  ?>

  <div class='clausulas'>
  	{{$hoja1}} judicial.-
  </div>
  
  <div class='salto_pagina'>&nbsp;</div>

  <header>
    <center>
      <img width='700' height='96' src="<?php echo $_SERVER["DOCUMENT_ROOT"].'/assets/global/img/membretecontrato.png'; ?>">
    </center>
  </header>

  <div class='clausulas'>
    {{$hoja2}}
  </div>
@stop