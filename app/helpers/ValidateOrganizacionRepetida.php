<?php

Validator::extend('cuitrepetido', function($attribute, $value, $parameters)
{
	$org = Organizacion::where('cuit', '=', $value)->get();

	return (count($org) >= 1) ? false : true;

});

Validator::extend('nombrerepetido', function($attribute, $value, $parameters)
{
	$org = Organizacion::where('nombre', '=', $value)->get();

	return (count($org) >= 1) ? false : true;

});

?>