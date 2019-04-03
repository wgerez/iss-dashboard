<?php

class FechaHelper {

    /**
     * Recibe la fecha en formato aaaa-mm-dd 00:00:00
     * Devuelve la fecha en formato dd/mm/aaaa
     *
     * @param  String  $fecha
     * @return String
     */
    public static function getFechaImpresion($fecha)
    {
	    if (!$fecha) return null;

	    $arrFechaHora = explode(' ', $fecha);
	    list($anio, $mes, $dia) = explode('-', $arrFechaHora[0]);

        return $dia . '/' . $mes . '/' . $anio;
    }

    /**
     * Recibe la fecha en formato dd/mm/aaaa
     * Devuelve la fecha en formato aaaa-mm-dd
     *
     * @param  String  $fecha
     * @return String
     */
    public static function getFechaParaGuardar($fecha)
    {
        if (!$fecha) return null;

        list($dia, $mes, $anio) = explode('/', $fecha);
        $fechaResult = new DateTime($anio . '-' . $mes . '-' . $dia);

        return $fechaResult->format('Y-m-d');
    }

    /**
     * Devuelve un Array con numeros del 1 al 31 en texto
     *
     * @return Array
     */
    public static function getNumerosTexto()
    {
        $result = array(
            'un', 'dos', 'tres', 'cuatro', 'cinco', 'seis',
            'siete', 'ocho', 'nueve', 'diez', 'once', 'doce',
            'trece', 'catorce', 'quince', 'dieciseis', 'diecisiete',
            'dieciocho', 'diecinueve', 'veinte', 'veintiún',
            'veintidos', 'veintitres', 'veinticuatro', 'veinticinco',
            'veintiseis', 'veintisiete', 'veintiocho', 'veintinueve',
            'treinta', 'treinta y un'
        );

        return $result;
    }

    /**
     * Devuelve un Array con los meses en texto
     *
     * @return Array
     */
    public static function getMesesTexto()
    {
        $result = array(
            'enero', 'febrero', 'marzo', 'abril', 'mayo',
            'junio', 'julio', 'agosto', 'septiembre', 'octubre',
            'noviembre', 'diciembre'
        );

        return $result;
    }


    public static function getFechaInputDate($fecha)
    {
        if (!$fecha) return null;

         $FechaInput = date('Y-m-d', strtotime($fecha));
        
        return $FechaInput;
    }


    public static function getHoraInputDate($hora)
    {
        if (!$hora) return null;

         $horaInput = date('H:i:s', strtotime($hora));
        
        return $horaInput;
    }

    public static function getCalculoHorarios($fecha1, $fecha2)
    {
        list($iniDia, $iniHora) = explode(" ", $fecha1);
        list($dia1, $mes1, $anio1) = explode("-", $iniDia);

        list($finDia, $finHora) = explode(" ", $fecha2);
        list($dia2, $mes2, $anio2) = explode("-", $finDia);

        $datetime1 = date_create($anio1.'-'.$mes1.'-'.$dia1.' '.$iniHora);
        $datetime2 = date_create($anio2.'-'.$mes2.'-'.$dia2.' '.$finHora);
        $intervalo = date_diff($datetime1, $datetime2);
        $dias2 = $intervalo->format('%a');

        $cadena = strtotime($iniHora);
        $iniHora = date("H:i:s", $cadena);

        $cadena = strtotime($finHora);
        $finHora = date("H:i:s", $cadena);
        $hora = '';

        $dias = date("H:i:s", strtotime("00:00:00") + strtotime($finHora) - strtotime($iniHora));

        if ($dias2 > -1) {
            $canhoras = $dias2 * 24;
            list($hora1, $minut, $segu) = explode(':', $dias);
            $nhora = $hora1 + $canhoras;
            $hora = $nhora.':'.$minut.':'.$segu;
        }

        if ($nhora > 35) $hora = $dias;

        return $hora;
    }

}