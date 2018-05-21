<?php
class ArrayHelper {

    /**
     * Obtiene los contactos a partir de una cadena de texto
     *
     * @param  String  $contactos
     * @return Array
     */
    public static function obtenerContactosSeparados($contactos)
    {
        $arrContactos = new ArrayObject;

        if (empty($contactos)) return $arrContactos;

        foreach ($contactos as $cadena) {
            list($tipo, $valor) = explode('|', $cadena);
            $arrContactos->append(array('tipo'=>$tipo, 'valor'=>$valor));
        }

        return $arrContactos;
    }

    // prueba gitgub

    public static function obtenerPeriodosSeparados($periodos)
    {
        $arrPeriodos = new ArrayObject;

        if (empty($periodos)) return $arrPeriodos;

        foreach ($periodos as $cadena) {
            list($periodo, $fechaini, $fechafin) = explode('|', $cadena);
            $arrPeriodos->append(array('periodo'=>$periodo, 'fechaini'=>$fechaini, 'fechafin'=>$fechafin));
        }

        return $arrPeriodos;
    }    

}