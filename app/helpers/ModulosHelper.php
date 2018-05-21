<?php

class ModulosHelper
{
	/* DASHBOARD */
	const MENU_DASHBOARD = 'dashboard';

	/* GESTION ACADEMICA */
	const MENU_GESTION_ACADEMICA = 'gestion_academica';

	const SUBMENU_ALUMNOS = 'alumnos';
	const SUBMENU_DOCENTES = 'docentes';
	const SUBMENU_ASIGNAR_DOCENTES = 'asignar_docentes';
	const SUBMENU_ASISTENCIA = 'asistencia';
	const SUBMENU_BOLETINES = 'boletines';

    const SUBMENU_2_EXAMENFINAL = 'examen_final';

	const SUBMENU_INSCRIPCIONES = 'inscripciones';
	const SUBMENU_INSCRIPCIONES_MATERIAS = 'inscripciones_materias';

    /* GESTION ADMINISTRATIVA */
	const MENU_GESTION_ADMINISTRATIVA = 'gestion_administrativa';

	const SUBMENU_ORGANIZACIONES = 'organizaciones';
	const SUBMENU_CALENDARIOS = 'calendarios';
	const SUBMENU_CARRERAS = 'carreras';
	const SUBMENU_MATERIAS = 'materias';
	const SUBMENU_PLAN_ESTUDIOS = 'plan_estudio';
	const SUBMENU_CORRELATIVIDADES = 'correlativides';
	const SUBMENU_ADMINISTRACION = 'administracion';

    const SUBMENU_2_CICLOS = 'ciclos';
    const SUBMENU_2_FERIADOS = 'feriados';
    const SUBMENU_2_EXAMENPARCIAL = 'examenparcial';
    const SUBMENU_2_MESAEXAMENES = 'mesaexamenes';

	/* GESTION CONTABLE */
	const MENU_GESTION_CONTABLE = 'gestion_contable';

	const SUBMENU_GESTION_MATRICULA = 'gestion_matricula';
	const SUBMENU_PAGO_MATRICULA = 'pago_matriculas';
	const SUBMENU_PAGO_CUOTAS = 'pago_cuotas';
	const SUBMENU_CAJA_CHICA = 'caja_chica';
	const SUBMENU_APERTURA_CAJA = 'apertura_caja';
	const SUBMENU_CIERRE_CAJA = 'cierre_caja';
	const SUBMENU_BECAS = 'becas';

	const SUBMENU_CONTRATOS = 'contratos';

    const SUBMENU_2_EDICION_CONTRATOS = 'edicion_contratos';
    const SUBMENU_2_IMPRESION_CONTRATOS = 'impresion_contratos';

	/* INFORMES */
	const MENU_INFORMES = 'informes';

	const SUBMENU_INFORMES_ALUMNOS = 'informes_alumnos';
	const SUBMENU_INFORMES_DOCENTES = 'informes_docentes';
	const SUBMENU_INFORMES_MATRICULAS = 'informes_matriculas';


	/* CONFIGURACIONES */
	const MENU_CONFIGURACIONES = 'configuraciones';

	const SUBMENU_CONFIG_GENERAL = 'config_general';
	const SUBMENU_CONFIG_INSTITUTOS = 'config_institutos';

	/* SEGURIDAD */
	const MENU_SEGURIDAD = 'seguridad';

	const SUBMENU_SEGURIDAD_USUARIOS = 'seguridad_usuarios';
	const SUBMENU_SEGURIDAD_PERFILES = 'seguridad_perfiles';

	/*SUBMODULOS ID PARA PERMISOS DE LECTURA - EDITAR - IMPRIMIR - ELIMINAR*/

	/* GESTION ACADEMICA */
	const ALUMNOS_ID 			= 6;
	const DOCENTES_ID 			= 7;
	const ASIGNAR_DOCENTES_ID 	= 38;
	const ASISTENCIA_ID			= 37;
	const BOLETINES_ID 			= 8;
	const INSCRIPCIONES_ID 		= 9;
	const INSCRIPCIONES_MATERIAS_ID = 31;

	/* GESTION ADMINISTRATIVA */
	const ORGANIZACIONES_ID		= 10;
	const CALENDARIOS_ID		= 11;
	const CARRERAS_ID 			= 12;
	const MATERIAS_ID 			= 13;
	const PLANESTUDIOS_ID		= 14;
	const CORRELATIVIDADES_ID	= 34;
	const ADMINISTRACION_ID		= 15;

	/* GESTION CONTABLE */
	const GESTIONMATRICULAS_ID 	= 16;
	const PAGOMATRICULAS_ID		= 17;
	const PAGOCUOTAS_ID			= 33;
	const CAJACHICA_ID			= 32;
	const APERTURACAJA_ID		= 35;
	const CIERRECAJA_ID			= 36;
	const BECAS_ID				= 22;
	const CONTRATOS_ID			= 28;

	/*INFORMES*/
	const INFORMES_ALUMNOS_ID	= 25;
	const INFORMES_DOCENTES_ID	= 26;
	const INFORMES_MATRICULAS_ID = 27;

	/* CONFIGURACIONES */
	const GENERAL_ID 			= 18;
	const INSTITUTOS_ID			= 19;

	/* SEGURIDAD */
	const USUARIOS_ID 			= 20;
	const PERFILES_ID 			= 21;
}

?>