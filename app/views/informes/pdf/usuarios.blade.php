@extends('layouts.informes.contenedor')

@section('cuerpo')
<p align="right">Fecha de Impresión: {{date('d/m/Y')}} - {{Auth::user()->usuario}}</p>
  <h3><center>Listado de Usuarios</center></h3>
  
  <table class="collapse">
    <thead>
      <tr>
        <td><strong><center>Código</center></strong></td>
        <td><strong><center>Apellido y Nombre</center></strong></td>
        <td><strong><center>Usuario</center></strong></td>
        <td><strong><center>Perfiles</center></strong></td>
        <td><strong><center>Correos</center></strong></td>
      </tr>
    </thead>
    <tbody>
        @if (isset($usuarios))
            @foreach ($usuarios as $usuario)
              <tr>
                <td><center>{{$usuario->Persona['id']}}</center></td>
                <td><center>{{$usuario->Persona['apellido'].', '.$usuario->Persona['nombre']}}</center></td>
                <td><center>{{$usuario->usuario}}</center></td>
                <td><center>@if (isset($usuario->perfiles->first()->perfil)) {{ $usuario->perfiles->first()->perfil }}  @else {{ 'Sin perfil' }} @endif</center></td>
                <td><center>{{$usuario->email}}</center></td>
              </tr>
            @endforeach
        @endif
    </tbody>          
  </table>
@stop
