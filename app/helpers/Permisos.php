<?php
class PermisosHelper
{
	public static function Modulos()
	{
		$user = User::find(Auth::user()->id);

		foreach ($user->perfiles as $perfil)
		{
			/*$permisos = $perfil->modulos->first()->pivot->modulo_id;*/
			foreach ($perfil->modulos as $modulo)
			{
				$permisos[] = [
								"submoduloid"	=> $modulo->id,
								"padreid"	=> $modulo->padreid,
								"leer"		=> $modulo->pivot->leer,
								"editar"	=> $modulo->pivot->editar,
								"eliminar"	=> $modulo->pivot->eliminar,
								"imprimir"	=> $modulo->pivot->imprimir
							];
			}	
		}
		if (isset($permisos))
		{
			return $permisos;
		}
		else
		{
			return false;
		}
		
	} 

	public static function Permisos(){
        //OBTENIENDO PERMISOS
        foreach (Session::get('permisos')[0] as $permiso) {

			switch ($permiso['submoduloid']) {
			    case ModulosHelper::ALUMNOS_ID:
	                Session::put('ALUMNO_LEER', $permiso['leer']);
	                Session::put('ALUMNO_EDITAR', $permiso['editar']);
	                Session::put('ALUMNO_IMPRIMIR', $permiso['imprimir']);
	                Session::put('ALUMNO_ELIMINAR', $permiso['eliminar']);
	                break;
			    case ModulosHelper::DOCENTES_ID:
	                Session::put('DOCENTE_LEER', $permiso['leer']);
	                Session::put('DOCENTE_EDITAR', $permiso['editar']);
	                Session::put('DOCENTE_IMPRIMIR', $permiso['imprimir']);
	                Session::put('DOCENTE_ELIMINAR', $permiso['eliminar']);
			        break;
			    case ModulosHelper::ASIGNAR_DOCENTES_ID:
	                Session::put('ASIGNAR_DOCENTE_LEER', $permiso['leer']);
	                Session::put('ASIGNAR_DOCENTE_EDITAR', $permiso['editar']);
	                Session::put('ASIGNAR_DOCENTE_IMPRIMIR', $permiso['imprimir']);
	                Session::put('ASIGNAR_DOCENTE_ELIMINAR', $permiso['eliminar']);
			        break;
			    case ModulosHelper::ASISTENCIA_ID:
	                Session::put('ASISTENCIA_LEER', $permiso['leer']);
	                Session::put('ASISTENCIA_EDITAR', $permiso['editar']);
	                Session::put('ASISTENCIA_IMPRIMIR', $permiso['imprimir']);
	                Session::put('ASISTENCIA_ELIMINAR', $permiso['eliminar']);
			        break;
			    case ModulosHelper::BOLETINES_ID:
	                Session::put('BOLETIN_LEER', $permiso['leer']);
	                Session::put('BOLETIN_EDITAR', $permiso['editar']);
	                Session::put('BOLETIN_IMPRIMIR', $permiso['imprimir']);
	                Session::put('BOLETIN_ELIMINAR', $permiso['eliminar']);
			        break;
			    case ModulosHelper::INSCRIPCIONES_ID:
	                Session::put('INSCRIPCION_LEER', $permiso['leer']);
	                Session::put('INSCRIPCION_EDITAR', $permiso['editar']);
	                Session::put('INSCRIPCION_IMPRIMIR', $permiso['imprimir']);
	                Session::put('INSCRIPCION_ELIMINAR', $permiso['eliminar']);
			        break;
			    case ModulosHelper::INSCRIPCIONES_MATERIAS_ID:
	                Session::put('INSCRIPCION_MATERIAS_LEER', $permiso['leer']);
	                Session::put('INSCRIPCION_MATERIAS_EDITAR', $permiso['editar']);
	                Session::put('INSCRIPCION_MATERIAS_IMPRIMIR', $permiso['imprimir']);
	                Session::put('INSCRIPCION_MATERIAS_ELIMINAR', $permiso['eliminar']);
			        break;			        
			    case ModulosHelper::ORGANIZACIONES_ID:
	                Session::put('ORGANIZACION_LEER', $permiso['leer']);
	                Session::put('ORGANIZACION_EDITAR', $permiso['editar']);
	                Session::put('ORGANIZACION_IMPRIMIR', $permiso['imprimir']);
	                Session::put('ORGANIZACION_ELIMINAR', $permiso['eliminar']);
			        break;
			    case ModulosHelper::CALENDARIOS_ID:
	                Session::put('CALENDARIO_LEER', $permiso['leer']);
	                Session::put('CALENDARIO_EDITAR', $permiso['editar']);
	                Session::put('CALENDARIO_IMPRIMIR', $permiso['imprimir']);
	                Session::put('CALENDARIO_ELIMINAR', $permiso['eliminar']);
			        break;
			    case ModulosHelper::CARRERAS_ID:
	                Session::put('CARRERA_LEER', $permiso['leer']);
	                Session::put('CARRERA_EDITAR', $permiso['editar']);
	                Session::put('CARRERA_IMPRIMIR', $permiso['imprimir']);
	                Session::put('CARRERA_ELIMINAR', $permiso['eliminar']);
			        break;
			    case ModulosHelper::MATERIAS_ID:
	                Session::put('MATERIA_LEER', $permiso['leer']);
	                Session::put('MATERIA_EDITAR', $permiso['editar']);
	                Session::put('MATERIA_IMPRIMIR', $permiso['imprimir']);
	                Session::put('MATERIA_ELIMINAR', $permiso['eliminar']);
			        break;
			    case ModulosHelper::PLANESTUDIOS_ID:
	                Session::put('PLANESTUDIO_LEER', $permiso['leer']);
	                Session::put('PLANESTUDIO_EDITAR', $permiso['editar']);
	                Session::put('PLANESTUDIO_IMPRIMIR', $permiso['imprimir']);
	                Session::put('PLANESTUDIO_ELIMINAR', $permiso['eliminar']);
			        break;
			   	case ModulosHelper::CORRELATIVIDADES_ID:
	                Session::put('CORRELATIVIDAD_LEER', $permiso['leer']);
	                Session::put('CORRELATIVIDAD_EDITAR', $permiso['editar']);
	                Session::put('CORRELATIVIDAD_IMPRIMIR', $permiso['imprimir']);
	                Session::put('CORRELATIVIDAD_ELIMINAR', $permiso['eliminar']);
			        break;
			    case ModulosHelper::ADMINISTRACION_ID:
	                Session::put('ADMINISTRACION_LEER', $permiso['leer']);
	                Session::put('ADMINISTRACION_EDITAR', $permiso['editar']);
	                Session::put('ADMINISTRACION_IMPRIMIR', $permiso['imprimir']);
	                Session::put('ADMINISTRACION_ELIMINAR', $permiso['eliminar']);
			        break;
			    case ModulosHelper::GESTIONMATRICULAS_ID:
	                Session::put('GESTIONMATRICULA_LEER', $permiso['leer']);
	                Session::put('GESTIONMATRICULA_EDITAR', $permiso['editar']);
	                Session::put('GESTIONMATRICULA_IMPRIMIR', $permiso['imprimir']);
	                Session::put('GESTIONMATRICULA_ELIMINAR', $permiso['eliminar']);
			        break;
			    case ModulosHelper::PAGOMATRICULAS_ID:
	                Session::put('PAGOMATRICULA_LEER', $permiso['leer']);
	                Session::put('PAGOMATRICULA_EDITAR', $permiso['editar']);
	                Session::put('PAGOMATRICULA_IMPRIMIR', $permiso['imprimir']);
	                Session::put('PAGOMATRICULA_ELIMINAR', $permiso['eliminar']);
			        break;
			    case ModulosHelper::PAGOCUOTAS_ID:
	                Session::put('PAGOCUOTAS_LEER', $permiso['leer']);
	                Session::put('PAGOCUOTAS_EDITAR', $permiso['editar']);
	                Session::put('PAGOCUOTAS_IMPRIMIR', $permiso['imprimir']);
	                Session::put('PAGOCUOTAS_ELIMINAR', $permiso['eliminar']);
			        break;
			    case ModulosHelper::CAJACHICA_ID:
	                Session::put('CAJACHICA_LEER', $permiso['leer']);
	                Session::put('CAJACHICA_EDITAR', $permiso['editar']);
	                Session::put('CAJACHICA_IMPRIMIR', $permiso['imprimir']);
	                Session::put('CAJACHICA_ELIMINAR', $permiso['eliminar']);
			        break;
			    case ModulosHelper::APERTURACAJA_ID:
	                Session::put('APERTURACAJA_LEER', $permiso['leer']);
	                Session::put('APERTURACAJA_EDITAR', $permiso['editar']);
	                Session::put('APERTURACAJA_IMPRIMIR', $permiso['imprimir']);
	                Session::put('APERTURACAJA_ELIMINAR', $permiso['eliminar']);
			        break;
			    case ModulosHelper::CIERRECAJA_ID:
	                Session::put('CIERRECAJA_LEER', $permiso['leer']);
	                Session::put('CIERRECAJA_EDITAR', $permiso['editar']);
	                Session::put('CIERRECAJA_IMPRIMIR', $permiso['imprimir']);
	                Session::put('CIERRECAJA_ELIMINAR', $permiso['eliminar']);
			        break;
			    case ModulosHelper::BECAS_ID:
	                Session::put('BECA_LEER', $permiso['leer']);
	                Session::put('BECA_EDITAR', $permiso['editar']);
	                Session::put('BECA_IMPRIMIR', $permiso['imprimir']);
	                Session::put('BECA_ELIMINAR', $permiso['eliminar']);
			        break;			        
			    case ModulosHelper::GENERAL_ID:
	                Session::put('GENERAL_LEER', $permiso['leer']);
	                Session::put('GENERAL_EDITAR', $permiso['editar']);
	                Session::put('GENERAL_IMPRIMIR', $permiso['imprimir']);
	                Session::put('GENERAL_ELIMINAR', $permiso['eliminar']);
			        break;			        
			    case ModulosHelper::INSTITUTOS_ID:
	                Session::put('INSTITUTO_LEER', $permiso['leer']);
	                Session::put('INSTITUTO_EDITAR', $permiso['editar']);
	                Session::put('INSTITUTO_IMPRIMIR', $permiso['imprimir']);
	                Session::put('INSTITUTO_ELIMINAR', $permiso['eliminar']);
			        break;
			    case ModulosHelper::USUARIOS_ID:
	                Session::put('USUARIO_LEER', $permiso['leer']);
	                Session::put('USUARIO_EDITAR', $permiso['editar']);
	                Session::put('USUARIO_IMPRIMIR', $permiso['imprimir']);
	                Session::put('USUARIO_ELIMINAR', $permiso['eliminar']);
			        break;
			    case ModulosHelper::PERFILES_ID:
	                Session::put('PERFIL_LEER', $permiso['leer']);
	                Session::put('PERFIL_EDITAR', $permiso['editar']);
	                Session::put('PERFIL_IMPRIMIR', $permiso['imprimir']);
	                Session::put('PERFIL_ELIMINAR', $permiso['eliminar']);
			        break;
			    case ModulosHelper::INFORMES_ALUMNOS_ID:
	                Session::put('INFORME_ALUMNOS_LEER', $permiso['leer']);
	                Session::put('INFORME_ALUMNOS_EDITAR', $permiso['editar']);
	                Session::put('INFORME_ALUMNOS_IMPRIMIR', $permiso['imprimir']);
	                Session::put('INFORME_ALUMNOS_ELIMINAR', $permiso['eliminar']);
			        break;
			    case ModulosHelper::INFORMES_DOCENTES_ID:
	                Session::put('INFORME_DOCENTES_LEER', $permiso['leer']);
	                Session::put('INFORME_DOCENTES_EDITAR', $permiso['editar']);
	                Session::put('INFORME_DOCENTES_IMPRIMIR', $permiso['imprimir']);
	                Session::put('INFORME_DOCENTES_ELIMINAR', $permiso['eliminar']);
			        break;

			    case ModulosHelper::INFORMES_MATRICULAS_ID:
	                Session::put('INFORME_MATRICULAS_LEER', $permiso['leer']);
	                Session::put('INFORME_MATRICULAS_EDITAR', $permiso['editar']);
	                Session::put('INFORME_MATRICULAS_IMPRIMIR', $permiso['imprimir']);
	                Session::put('INFORME_MATRICULAS_ELIMINAR', $permiso['eliminar']);
			        break;
			    case ModulosHelper::CONTRATOS_ID:
	                Session::put('CONTRATOS_LEER', $permiso['leer']);
	                Session::put('CONTRATOS_EDITAR', $permiso['editar']);
	                Session::put('CONTRATOS_IMPRIMIR', $permiso['imprimir']);
	                Session::put('CONTRATOS_ELIMINAR', $permiso['eliminar']);
			        break;
			    case ModulosHelper::CONTROL_ACCESOS_ID:
	                Session::put('CONTROL_ACCESOS_LEER', $permiso['leer']);
	                Session::put('CONTROL_ACCESOS_EDITAR', $permiso['editar']);
	                Session::put('CONTROL_ACCESOS_IMPRIMIR', $permiso['imprimir']);
	                Session::put('CONTROL_ACCESOS_ELIMINAR', $permiso['eliminar']);
			        break;
			}
        }
	}

}
?>