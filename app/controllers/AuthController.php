<?php

class AuthController extends BaseController {
    
    public function doLogin()
    {
        $datos = [
                    'usuario'   => mb_strtolower(trim(Input::get('usuario'))),
                    'password'  => Input::get('password')                    
                    ];

        //COMPRUEBA SI ES UN USUARIO REGISTRADO
        if (Auth::attempt($datos, Input::get('rememberme', 0)))
        {
            //COMPRUEBA SI ES UN USUARIO ACTIVO
            if (Auth::user()->activo == 0)
            {
                Auth::logout();
                Session::flash('msgerror', 'Su cuenta no está activa.');
                return Redirect::to('/');
            }
            //COMPRUEBA SI EL USUARIO TIENE AL MENOS UN PERFIL ASIGNADO
            elseif (Auth::user()->perfiles->count() == 0) 
            {
                Auth::logout();
                Session::flash('msgerror', 'Aún no posee un perfil asociado.');
                return Redirect::to('/');
            }

            //ASIGNACION DE PERMISOS
            if (PermisosHelper::modulos())
            {
                Session::push('permisos', [PermisosHelper::modulos()][0]);
            }
            else
            {
                Auth::logout();
                Session::flash('msgerror', 'Tu perfil no posee permisos.');
                return Redirect::to('/');
            }

            //GENERO LAS VARIABLES DE SESSION PARA LOS PERMISOS
            PermisosHelper::Permisos();
            Session::put('ORGANIZACION_ID', Auth::user()->organizaciones->first()->pivot->organizacion_id);

            //CAMBIAR LA REDIRECCION A UN PANEL ESTADISTICO PARA CUALQUIER USUARIO
            return Redirect::intended('dashboard');
        }
        else
        {
            Session::flash('msgerror', 'Datos incorrectos, vuelva a intentarlo.');
            return Redirect::to('/');
        }    
    }
 
    public function doLogout()
    {
        Auth::logout();

        Session::forget('permisos');
 
        Session::flash('msgok', 'Gracias por visitarnos!!.');
        return Redirect::to('/');
    }
 
}