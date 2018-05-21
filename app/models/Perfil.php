<?php

class Perfil extends \Eloquent {

	protected $table = 'perfiles';



	/*Relaciones*/
	public function organizacion()
	{
		return $this->belongsTo('Organizacion');
	}



	public function modulos()
    {
        return $this->belongsToMany('Modulo')->withPivot('perfil_id', 'leer', 'editar', 'eliminar', 'imprimir');
    }


    public function users()
    {
        return $this->belongsToMany('User');
    }

    public static function getPermisosperfiles($id,$idperfil)
    {
        $result = DB::table('modulo_perfil', 'modulos')
                ->select(DB::raw('modulos.descripcion, modulo_perfil.leer, modulo_perfil.editar, modulo_perfil.eliminar, modulo_perfil.imprimir'))
                ->join('modulos', 'modulo_perfil.modulo_id', '=', 'modulos.id')
                ->where('modulo_perfil.modulo_id', '=', $id)
                ->where('modulo_perfil.perfil_id', '=', $idperfil)
                ->groupBy('modulos.id')
                ->get();

        return $result;
    }

    public static function getExisteperfilusuario($id,$modulos)
    {
        $result = DB::table('modulo_perfil')
                ->select(DB::raw('modulo_perfil.leer, modulo_perfil.editar, modulo_perfil.eliminar, modulo_perfil.imprimir'))
                ->where('modulo_perfil.modulo_id', '=', $modulos)
                ->where('modulo_perfil.perfil_id', '=', $id)
                ->get();

        return $result;
    }
}