<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	protected $table = 'users';

	protected $hidden = array('password');

	/*Relaciones*/	
    public function organizaciones()
    {
        return $this->belongsToMany('Organizacion');
    }


    public function perfiles()
    {
        return $this->belongsToMany('Perfil');
    }
    
    public function persona()
    {
        return $this->belongsTo('Persona', 'persona_id');
    }

}
