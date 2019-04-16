@extends('layouts.informes.contenedor')

@section('cuerpo')
  <h3>Alumnos por carrera: {{$nombrecarrera}}</h3>
  <table class="collapse">
    <thead>
      <tr>
        <th>Código</th>
        <th>Apellido y Nombre</th>
        <th>DNI</th>
        <th>Dirección</th>
        <th>Localidad</th>
        <th>Teléfono</th>
        <th>Correo</th>
      </tr>
    </thead>
    <tbody>
                    @if (isset($alumnos))
                      @foreach ($alumnos as $alumno)
                        <!-- RESCATO EL TELEFONO Y EL CORREO -->
                        <?php $particular = 'No cargado'; ?>
                        <?php $laboral  = 'No Cargado'; ?>
                        <?php $correo   = 'No cargado'; ?>
                        @foreach ($alumno->persona->contactos as $contacto)
                          @if ($contacto->id==1)
                            <?php $particular = $contacto->pivot->descripcion; ?>
                          @elseif ($contacto->id==2)
                            <?php $laboral = $contacto->pivot->descripcion; ?>
                          @elseif($contacto->id==3)
                            <?php $correo = $contacto->pivot->descripcion; ?>
                          @endif
                        @endforeach
                        @if ($filtroseleccionado==1)
                        <tr>
                          <td><center>{{$alumno->persona['id']}}</center></td>
                          <td>{{$alumno->persona['apellido'].", ". $alumno->persona['nombre']}}</td>
                          <td>{{$alumno->persona['nrodocumento']}}</td>
                          <td>
                            @if (empty($alumno->persona['barrio']) or ($alumno->persona['barrio']==null)) 
                              {{'B° no cargado -'}} 
                            @else 
                              {{$alumno->persona['barrio'].' -'}} 
                            @endif                           
                            @if (empty($alumno->persona['calle']) or ($alumno->persona['calle']==null)) 
                              {{'Calle no cargado'}} 
                            @else 
                              {{$alumno->persona['calle']}} 
                            @endif 
                            @if ($alumno->persona['numero']==0) 
                              {{'s/n'}} 
                            @else 
                              {{$alumno->persona['numero']}} 
                            @endif
                              @if ($alumno->persona['manzana']==0) 
                                {{''}} 
                              @else 
                                {{', Mz: '. $alumno->persona['manzana']}} 
                              @endif
                              @if ($alumno->persona['departamento']==0) 
                                {{''}} 
                              @else 
                                {{', Dpto: '. $alumno->persona['departamento']}} 
                              @endif
                          </td>
                          <td>{{$alumno->persona->localidad['descripcion']}}</td>
                          <td>@if ($particular!='No cargado') {{$particular}} @else {{$laboral}} @endif</td>
                          <td>{{$correo}}</td>
                        </tr>
                        @endif
                        @if ($filtroseleccionado==4)
                          @if ($alumno->persona['sexo']==$filtrosexo)
                            <tr>
                              <td>{{$alumno->persona['apellido'].", ". $alumno->persona['nombre']}}</td>
                              <td>{{$alumno->persona['nrodocumento']}}</td>
                              <td>
                                @if (empty($alumno->persona['barrio']) or ($alumno->persona['barrio']==null)) 
                                  {{'B° no cargado -'}} 
                                @else 
                                  {{$alumno->persona['barrio'].' -'}} 
                                @endif
                                @if (empty($alumno->persona['calle']) or ($alumno->persona['calle']==null)) 
                                  {{'Calle no cargado'}} 
                                @else 
                                  {{$alumno->persona['calle']}} 
                                @endif 
                                @if ($alumno->persona['numero']==0) 
                                  {{'s/n'}} 
                                @else 
                                  {{$alumno->persona['numero']}} 
                                @endif
                              @if ($alumno->persona['manzana']==0) 
                                {{''}} 
                              @else 
                                {{', Mz: '. $alumno->persona['manzana']}} 
                              @endif
                              @if ($alumno->persona['departamento']==0) 
                                {{''}} 
                              @else 
                                {{', Dpto: '. $alumno->persona['departamento']}} 
                              @endif
                              </td>
                              <td>{{$alumno->persona->localidad['descripcion']}}</td>
                              <td>@if ($particular!='No cargado') {{$particular}} @else {{$laboral}} @endif</td>
                              <td>{{$correo}}</td>
                            </tr>
                          @endif  
                        @endif
                        @if ($filtroseleccionado==2)
                          @if ($filtroapellido==null and $filtronombre==null)
                            <tr>
                              <td>{{$alumno->persona['apellido'].", ". $alumno->persona['nombre']}}</td>
                              <td>{{$alumno->persona['nrodocumento']}}</td>
                              <td>
                                @if (empty($alumno->persona['barrio']) or ($alumno->persona['barrio']==null)) 
                                  {{'B° no cargado -'}} 
                                @else 
                                  {{$alumno->persona['barrio'].' -'}} 
                                @endif
                                @if (empty($alumno->persona['calle']) or ($alumno->persona['calle']==null)) 
                                  {{'Calle no cargado'}} 
                                @else 
                                  {{$alumno->persona['calle']}} 
                                @endif 
                                @if ($alumno->persona['numero']==0) 
                                  {{'s/n'}} 
                                @else 
                                  {{$alumno->persona['numero']}} 
                                @endif
                              @if ($alumno->persona['manzana']==0) 
                                {{''}} 
                              @else 
                                {{', Mz: '. $alumno->persona['manzana']}} 
                              @endif
                              @if ($alumno->persona['departamento']==0) 
                                {{''}} 
                              @else 
                                {{', Dpto: '. $alumno->persona['departamento']}} 
                              @endif
                              </td>
                              <td>{{$alumno->persona->localidad['descripcion']}}</td>
                              <td>@if ($particular!='No cargado') {{$particular}} @else {{$laboral}} @endif</td>
                              <td>{{$correo}}</td>
                            </tr>
                          @else
                            <?php 
                             $apellidov = stripos($alumno->persona['apellido'], $filtroapellido); 
                             $nombrev   = stripos($alumno->persona['nombre'], $filtronombre);
                            ?>


                            @if ($apellidov!==false or $nombrev!==false)
                            <tr>
                              <td>{{$alumno->persona['apellido'].", ". $alumno->persona['nombre']}}</td>
                              <td>{{$alumno->persona['nrodocumento']}}</td>
                              <td>
                                @if (empty($alumno->persona['barrio']) or ($alumno->persona['barrio']==null)) 
                                  {{'B° no cargado -'}} 
                                @else 
                                  {{$alumno->persona['barrio'].' -'}} 
                                @endif
                                @if (empty($alumno->persona['calle']) or ($alumno->persona['calle']==null)) 
                                  {{'Calle no cargado'}} 
                                @else 
                                  {{$alumno->persona['calle']}} 
                                @endif 
                                @if ($alumno->persona['numero']==0)
                                  {{'s/n'}} 
                                @else 
                                  {{$alumno->persona['numero']}} 
                                @endif
                              @if ($alumno->persona['manzana']==0) 
                                {{''}} 
                              @else 
                                {{', Mz: '. $alumno->persona['manzana']}} 
                              @endif
                              @if ($alumno->persona['departamento']==0) 
                                {{''}} 
                              @else 
                                {{', Dpto: '. $alumno->persona['departamento']}} 
                              @endif
                              </td>
                              <td>{{$alumno->persona->localidad['descripcion']}}</td>
                              <td>@if ($particular!='No cargado') {{$particular}} @else {{$laboral}} @endif</td>
                              <td>{{$correo}}</td>
                            </tr>
                            @endif
                          @endif                            
                        @endif
                        @if ($filtroseleccionado==5)
                          <?php 
                           $localidad = stripos($alumno->persona->localidad['descripcion'], $filtrolocalidad);  
                          ?>

                          @if ($localidad!==false)
                          <tr>
                            <td>{{$alumno->persona['apellido'].", ". $alumno->persona['nombre']}}</td>
                            <td>{{$alumno->persona['nrodocumento']}}</td>
                            <td>
                              @if (empty($alumno->persona['barrio']) or ($alumno->persona['barrio']==null)) 
                                {{'B° no cargado -'}} 
                              @else 
                                {{$alumno->persona['barrio'].' -'}} 
                              @endif
                              @if (empty($alumno->persona['calle']) or ($alumno->persona['calle']==null)) 
                                {{'Calle no cargado'}} 
                              @else 
                                {{$alumno->persona['calle']}} 
                              @endif 
                              @if ($alumno->persona['numero']==0)
                                {{'s/n'}} 
                              @else 
                                {{$alumno->persona['numero']}} 
                              @endif
                              @if ($alumno->persona['manzana']==0) 
                                {{''}} 
                              @else 
                                {{', Mz: '. $alumno->persona['manzana']}} 
                              @endif
                              @if ($alumno->persona['departamento']==0) 
                                {{''}} 
                              @else 
                                {{', Dpto: '. $alumno->persona['departamento']}} 
                              @endif
                            </td>
                            <td>{{$alumno->persona->localidad['descripcion']}}</td>
                            <td>@if ($particular!='No cargado') {{$particular}} @else {{$laboral}} @endif</td>
                            <td>{{$correo}}</td>
                          </tr>
                          @endif                          
                        @endif
                      @endforeach
                    @endif   
    </tbody>        
  </table>
@stop
