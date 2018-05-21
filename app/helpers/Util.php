<?php

class Util
{
    /*método para generar una key aleatoria - Útil para enviar, por ejemplo, 
    una clave temporal al correo para confirmar cuenta
    */
    public static function LlaveTemporal($length)
    {
 
        $key = "";
        $caracteres = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        //aquí podemos incluir incluso caracteres especiales pero cuidado con las ‘ y “ y algunos otros
        $max = strlen($caracteres) - 1;
        for ($i=0;$i<$length;$i++) {
            $key .= substr($caracteres, rand(0, $max), 1);
        }
        return $key;

    }

    //Humaniza las fechas al estilo "Hace una hora o el mes pasado etc.."
    public static function Feacharelativa($time) {
            $second = 1;
            $minute = 60 * $second;
            $hour   = 60 * $minute;
            $day    = 24 * $hour;
            $month  = 30 * $day;  


            $delta = time() - $time;
    
            if ($delta < 1 * $minute)
            {
                    return $delta == 1 ? "En este momento" : "hace " . $delta . " segundos ";
            }
            if ($delta < 2 * $minute)
            {
                    return "Hace un minuto";
            }
            if ($delta < 45 * $minute)
            {
                    return "Hace " . floor($delta / $minute) . " minutos";
            }
            if ($delta < 90 * $minute)
            {
                    return "Hace una hora";
            }
            if ($delta < 24 * $hour)
            {
                    return "Hace " . floor($delta / $hour) . " horas";
            }
            if ($delta < 48 * $hour)
            {
                    return "Ayer";
            }
            if ($delta < 30 * $day)
            {
                    return "Hace " . floor($delta / $day) . " dias";
            }
            if ($delta < 12 * $month)
            {
                    $months = floor($delta / $day / 30);
                    return $months <= 1 ? "El mes pasado" : "hace " . $months . " meses";
            }
            else
            {
                    $years = floor($delta / $day / 365);
                    return $years <= 1 ? "El a&ntilde;o pasado" : "hace " . $years . " a&ntilde;os";
            }
    
    }

    //Trunca los textos largos
    public static function Truncartxt($string, $limit, $break=".", $pad="...")
    {
        if(strlen($string) <= $limit)
            return $string;
            // is $break present between $limit and the end of the string?
        if(false !== ($breakpoint = strpos($string, $break, $limit))) {
            if($breakpoint < strlen($string) - 1) {
            $string = substr($string, 0, $breakpoint) . $pad;
            }
        }
        return $string;
    }

    public static function Calcularedad($fecha){
        $dias = explode("/", $fecha, 3);
        $dias = mktime(0,0,0,$dias[1],$dias[0],$dias[2]);
        $edad = (int)((time()-$dias)/31556926 );
        return $edad;
    }        

}