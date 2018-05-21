<?php

class ImagenHelper
{
    /**
     * Devuelve la extension (jpg/png/gif) de un archivo a partir del nombre.
     *
     * @param  String  $archivo
     * @return String
     */
	private static function _getExtension($archivo)
	{
		$arreglo = explode('.', $archivo);
		return end($arreglo);
	}

    /**
     * Devuelve 1 (verdadero) o 0 (falso), dependiendo de la extension del archivo.
     *
     * @param  String $archivo
     * @return int (bool)
     */
	public static function extensionValida($archivo)
	{
		$arrExtensiones = array('png', 'jpg', 'gif');
		$extension = self::_getExtension($archivo);

		foreach ($arrExtensiones as $extension_valida) {
			if (strtolower($extension) == $extension_valida)
				return 1;
		}
		return 0;
	}
}

?>