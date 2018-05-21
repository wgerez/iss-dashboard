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

}