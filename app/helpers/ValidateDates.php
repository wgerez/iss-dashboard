<?php

Validator::extend('fechamenos', function($attribute, $value, $parameters)
{
	$fechaini = FechaHelper::getFechaParaGuardar($value);
	$fechafin = FechaHelper::getFechaParaGuardar($parameters[0]);
    return strtotime( $fechaini ) < strtotime( $fechafin );
});

?>