	<!-- BEGIN SIDEBAR -->
	<div class="page-sidebar navbar-collapse collapse">
		<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
		<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
		<!-- BEGIN SIDEBAR MENU1 -->
		<ul class="page-sidebar-menu hidden-sm hidden-xs" data-auto-scroll="true" data-slide-speed="200">

				<li <?php if ($menu == ModulosHelper::MENU_DASHBOARD) echo "class='start active open'"; ?> >
					<a href="{{url('dashboard')}}">
					<i class="fa fa-dashboard"></i>
					<span class="title"> Panel de Control</span>
					<span class="arrow">
					</span>
					</a>
				</li>	


			<?php 
			foreach (Session::get('permisos')[0] as $permiso) {
				if ($permiso['submoduloid'] == ModulosHelper::ALUMNOS_ID or $permiso['submoduloid'] == ModulosHelper::DOCENTES_ID or $permiso['submoduloid'] == ModulosHelper::ASIGNAR_DOCENTES_ID or $permiso['submoduloid'] == ModulosHelper::BOLETINES_ID or $permiso['submoduloid'] == ModulosHelper::INSCRIPCIONES_ID or $permiso['submoduloid'] == ModulosHelper::ASISTENCIA_ID){
			?>
				<li <?php if ($menu == ModulosHelper::MENU_GESTION_ACADEMICA) echo "class='start active open'"; ?> >
					<a href="javascript:;">
					<i class="fa fa-graduation-cap"></i>
					<span class="title">
					Gestión Académica</span>
					<span class="selected ">
					</span>
					<span class="arrow <?php if ($menu == ModulosHelper::MENU_GESTION_ACADEMICA) echo 'open'; ?>">
					</span>
					</a>
					<ul class="sub-menu">
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::ALUMNOS_ID){
						?>
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_ALUMNOS) echo 'active'; ?>">
								<a href="{{url('alumnos/listado')}}">
								<i class="fa fa-users"></i>
								 Alumnos</a>
							</li>
						<?php
							break; 
							}
						}
						?>
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::DOCENTES_ID){
						?>					
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_DOCENTES) echo 'active'; ?>">
								<a href="{{url('docentes/listado')}}"><i class="fa fa-user"></i> Docentes</a>
							</li>
						<?php
							break; 
							}
						}
						?>
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::ASIGNAR_DOCENTES_ID){
						?>					
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_ASIGNAR_DOCENTES) echo 'active'; ?>">
								<a href="{{url('asignardocente/asignadocente')}}"><i class="fa fa-user"></i> Asignar Docentes</a>
							</li>
						<?php
							break; 
							}
						}
						?>
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::ASISTENCIA_ID){
						?>					
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_ASISTENCIA) echo 'active'; ?>">
								<a href="{{url('asistencias/listado')}}"><i class="fa fa-edit"></i> Asistencias</a>
							</li>
						<?php
							break; 
							}
						}
						?>
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::BOLETINES_ID) {
						?>
							<li>
								<a href="javascript:;">
								<i class="fa fa-files-o"></i> Boletines <span class="arrow <?php if ($submenu == ModulosHelper::SUBMENU_BOLETINES) echo 'open'; ?>"></span>
								</a>
								<!-- SI $submenu2 existe hay que agregar "block" al style sino "none" para que el submenu2 quede abierto -->
								<ul class="sub-menu" style="display: <?php if (isset($submenu2)){ if ($submenu2==ModulosHelper::SUBMENU_2_EXAMENPARCIAL || $submenu2==ModulosHelper::SUBMENU_2_EXAMENFINAL) {echo 'block';}else{echo 'none';} } ?>;">
									<li class="<?php if (isset($submenu2)){ if ($submenu2==ModulosHelper::SUBMENU_2_EXAMENPARCIAL) echo 'active'; } ?>">
										<a href="{{url('regularidades/listado')}}"><i class="fa fa-file-text"></i> Examen Parcial</a>
									</li>
									<li class="<?php if (isset($submenu2)){ if ($submenu2==ModulosHelper::SUBMENU_2_EXAMENFINAL) echo 'active'; } ?>">
										<a href="{{url('examenfinal/listado')}}"><i class="fa fa-file-text"></i> Examen Final</a>
									</li>
								</ul>
							</li>
						<?php
							break; 
							}
						}
						?>
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::INSCRIPCIONES_ID){
						?>
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_INSCRIPCIONES) echo 'active'; ?>">
								<a href="{{url('inscripcionfinal')}}">
								<i class="fa fa-edit"></i>	Inscripción Finales</a>
							</li>
						<?php
							break; 
							}
						}
						?>
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::INSCRIPCIONES_MATERIAS_ID){
						?>
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_INSCRIPCIONES_MATERIAS) echo 'active'; ?>">
								<a href="{{url('inscripcionmaterias')}}">
								<i class="fa fa-edit"></i>	Inscripción Materias</a>
							</li>
						<?php
							break; 
							}
						}
						?>						
					</ul>
				</li>
			<?php
				break; 
				}
			}
			?>
			<!-- LA CLASE class="start active open" COLOREA EL MENU ACTIVO -->
			<?php 
			foreach (Session::get('permisos')[0] as $permiso) {
				if ($permiso['submoduloid'] == ModulosHelper::ORGANIZACIONES_ID or $permiso['submoduloid'] == ModulosHelper::CALENDARIOS_ID or $permiso['submoduloid'] == ModulosHelper::CARRERAS_ID or $permiso['submoduloid'] == ModulosHelper::MATERIAS_ID or $permiso['submoduloid'] == ModulosHelper::PLANESTUDIOS_ID or $permiso['submoduloid'] == ModulosHelper::ADMINISTRACION_ID or $permiso['submoduloid'] == ModulosHelper::CORRELATIVIDADES_ID){
			?>			
				<li <?php if ($menu == ModulosHelper::MENU_GESTION_ADMINISTRATIVA) echo "class='start active open'"; ?>>
					<a href="javascript:;">
					<i class="fa fa-book"></i>
					<span class="title">
					Gestión Administrativa </span>
					<!-- AGREGAR LA CLASE "OPEN" PARA EL ARROW  -->	
					<span class="arrow <?php if ($menu == ModulosHelper::MENU_GESTION_ADMINISTRATIVA) echo 'open'; ?>">
					</span>
					</a>
					<ul class="sub-menu">
						<!-- AGREGAR class="active" PARA COLOREAR EL SUBMENU -->
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::ORGANIZACIONES_ID){
						?>
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_ORGANIZACIONES) echo 'active'; ?>">
								<a href="{{url('organizacions/listado')}}">
								<i class="fa fa-university"></i>
								<span class="title">
								Organizaciones </span>
								</a>
							</li>
						<?php
							break; 
							}
						}
						?>
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::CALENDARIOS_ID){
						?>
							<li>
								<a href="javascript:;">
								<i class="fa fa-calendar"></i> Calendarios <span class="arrow <?php if ($submenu == ModulosHelper::SUBMENU_CALENDARIOS) echo 'open'; ?>"></span>
								</a>
								<!-- SI $submenu2 existe hay que agregar "block" al style sino "none" para que el submenu2 quede abierto -->
								<ul class="sub-menu" style="display: <?php if (isset($submenu2)){ if ($submenu2==ModulosHelper::SUBMENU_2_CICLOS || $submenu2==ModulosHelper::SUBMENU_2_FERIADOS || $submenu2==ModulosHelper::SUBMENU_2_MESAEXAMENES) {echo 'block';}else{echo 'none';} } ?>;">
									<li class="<?php if (isset($submenu2)){ if ($submenu2==ModulosHelper::SUBMENU_2_CICLOS) echo 'active'; } ?>">
										<a href="{{url('ciclolectivo/listado')}}"><i class="fa fa-calendar"></i> Ciclo Lectivo</a>
									</li>
									<li class="<?php if (isset($submenu2)){ if ($submenu2==ModulosHelper::SUBMENU_2_FERIADOS) echo 'active'; } ?>">
										<a href="{{url('feriados/listado')}}"><i class="fa fa-calendar-o"></i> Feriados</a>
									</li>
									<li class="<?php if (isset($submenu2)){ if ($submenu2==ModulosHelper::SUBMENU_2_MESAEXAMENES) echo 'active'; } ?>">
										<a href="{{url('mesaexamenes/listado')}}"><i class="fa fa-calendar"></i> Mesa de Examenes</a>
									</li>
								</ul>
							</li>
						<?php
							break; 
							}
						}
						?>
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::CARRERAS_ID){
						?>
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_CARRERAS) echo 'active'; ?>">
								<a href="{{url('carreras/listado')}}"><i class="fa fa-files-o"></i> Carreras</a>
							</li>
						<?php
							break; 
							}
						}
						?>
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::MATERIAS_ID){
						?>
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_MATERIAS) echo 'active'; ?>">
								<a href="{{url('materias/listado')}}"><i class="fa fa-folder-open"></i> Materias</a>
							</li>
						<?php
							break; 
							}
						}
						?>
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::PLANESTUDIOS_ID){
						?>
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_PLAN_ESTUDIOS) echo 'active'; ?>">
								<a href="{{url('planestudios/listado')}}"><i class="fa fa-file-text"></i> Plan de Estudios</a>
							</li>
						<?php
							break; 
							}
						}
						?>
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::CORRELATIVIDADES_ID){
						?>
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_CORRELATIVIDADES) echo 'active'; ?>">
								<a href="{{url('correlatividades/listado')}}"><i class="glyphicon glyphicon-list-alt"></i> Correlatividades</a>
							</li>
						<?php
							break; 
							}
						}
						?>
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::ADMINISTRACION_ID){
						?>
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_ADMINISTRACION) echo 'active'; ?>">
								<a href="#"><i class="fa fa-adn"></i> Administración</a>
							</li>
						<?php
							break; 
							}
						}
						?>
					</ul>
				</li>
			<?php
				break; 
				}
			}
			?>
			<?php 
			foreach (Session::get('permisos')[0] as $permiso) {
				if ($permiso['submoduloid'] == ModulosHelper::GESTIONMATRICULAS_ID or $permiso['submoduloid'] == ModulosHelper::PAGOMATRICULAS_ID or $permiso['submoduloid'] == ModulosHelper::CAJACHICA_ID or $permiso['submoduloid'] == ModulosHelper::BECAS_ID or $permiso['submoduloid'] == ModulosHelper::PAGOCUOTAS_ID or $permiso['submoduloid'] == ModulosHelper::APERTURACAJA_ID or $permiso['submoduloid'] == ModulosHelper::CIERRECAJA_ID){
			?>
				<li <?php if ($menu == ModulosHelper::MENU_GESTION_CONTABLE) echo "class='start active open'"; ?>>
					<a href="javascript:;">
					<i class="fa fa-dollar"></i>
					<span class="title">
					Gestión Contable </span>
					<span class="arrow <?php if ($menu == ModulosHelper::MENU_GESTION_CONTABLE) echo 'open'; ?>">
					</span>
					</a>
					<ul class="sub-menu">
						<!-- CONTRATOS -->
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::CONTRATOS_ID){
						?>						
							<li>
								<a href="javascript:;">
								<i class="fa fa-file-text"></i> Contratos <span class="arrow <?php if ($submenu == ModulosHelper::SUBMENU_CONTRATOS) echo 'open'; ?>"></span>
								</a>
								<!-- SI $submenu2 existe hay que agregar "block" al style sino "none" para que el submenu2 quede abierto -->
								<ul class="sub-menu" style="display: <?php if (isset($submenu2)){ if ($submenu2==ModulosHelper::SUBMENU_2_EDICION_CONTRATOS || $submenu2==ModulosHelper::SUBMENU_2_IMPRESION_CONTRATOS) {echo 'block';}else{echo 'none';} } ?>;">
									<li class="<?php if (isset($submenu2)){ if ($submenu2==ModulosHelper::SUBMENU_2_EDICION_CONTRATOS) echo 'active'; } ?>">
										<a href="{{url('tiposcontratos/editar')}}"><i class="fa fa-edit"></i> Edición de Contratos</a>
									</li>
									<li class="<?php if (isset($submenu2)){ if ($submenu2==ModulosHelper::SUBMENU_2_IMPRESION_CONTRATOS) echo 'active'; } ?>">
										<a href="{{url('contratos/imprimir')}}"><i class="fa fa-print"></i> Imprimir</a>
									</li>
								</ul>
							</li>
						<?php
							break; 
							}
						}
						?>							
						<!-- FIN CONTRATOS -->
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::GESTIONMATRICULAS_ID){
						?>
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_GESTION_MATRICULA) echo 'active'; ?>">
								<a href="{{url('matriculas/gestion')}}">
								<i class="fa fa-copy"></i> Gestión de Matrículas</a>
							</li>
						<?php
							break; 
							}
						}
						?>
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::PAGOMATRICULAS_ID){
						?>
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_PAGO_MATRICULA) echo 'active'; ?>">
								<a href="{{url('matriculas/listado')}}">
								<i class="fa fa-file-excel-o"></i> Pago de Matrículas</a>
							</li>
						<?php
							break; 
							}
						}
						?>
						
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::PAGOCUOTAS_ID){
						?>
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_PAGO_CUOTAS) echo 'active'; ?>">
								<a href="{{url('cuotas/listado')}}">
								<i class="fa fa-file-excel-o"></i> Pago de Cuotas</a>
							</li>
						<?php
							break; 
							}
						}
						?>
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::CAJACHICA_ID){
						?>
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_CAJA_CHICA) echo 'active'; ?>">
								<a href="{{url('cajachica/listado')}}">
								<i class="fa fa-file-excel-o"></i> Caja Chica</a>
							</li>
						<?php
							break; 
							}
						}
						?>
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::APERTURACAJA_ID){
						?>
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_APERTURA_CAJA) echo 'active'; ?>">
								<a href="{{url('aperturacaja/crear')}}">
								<i class="fa fa-file-excel-o"></i> Apertura de Caja</a>
							</li>
						<?php
							break; 
							}
						}
						?>
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::CIERRECAJA_ID){
						?>
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_CIERRE_CAJA) echo 'active'; ?>">
								<a href="{{url('cierrecaja/crear')}}">
								<i class="fa fa-file-excel-o"></i> Cierre de Caja</a>
							</li>
						<?php
							break; 
							}
						}
						?>
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::BECAS_ID){
						?>
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_BECAS) echo 'active'; ?>">
								<a href="{{url('becas/gestionar')}}">
								<i class="fa fa-file-excel-o"></i> Becas</a>
							</li>
						<?php
							break; 
							}
						}
						?>						
					</ul>
				</li>
			<?php
				break; 
				}
			}
			?>
			<?php 
			foreach (Session::get('permisos')[0] as $permiso) {
				if ($permiso['submoduloid'] == ModulosHelper::INFORMES_ALUMNOS_ID or $permiso['submoduloid'] == ModulosHelper::INFORMES_DOCENTES_ID){
			?>
				<li <?php if ($menu == ModulosHelper::MENU_INFORMES) echo "class='start active open'"; ?>>
					<a href="javascript:;">
					<i class="fa fa-copy"></i>
					<span class="title">
					Informes </span>
					<span class="arrow <?php if ($menu == ModulosHelper::MENU_INFORMES) echo 'open'; ?>">
					</span>
					</a>
					<ul class="sub-menu">
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::INFORMES_ALUMNOS_ID){
						?>
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_INFORMES_ALUMNOS) echo 'active'; ?>">
								<a href="{{url('informes/alumnos')}}">
								<i class="fa fa-file-text-o"></i>
								Alumnos </a>
							</li>
						<?php
							break; 
							}
						}
						?>
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::INFORMES_DOCENTES_ID){
						?>						
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_INFORMES_DOCENTES) echo 'active'; ?>">
								<a href="{{url('informes/docentes')}}">
								<i class="fa fa-file-text-o"></i>
								Docentes </a>
							</li>
						<?php
							break; 
							}
						}
						?>

						<?php
						foreach (Session::get('permisos')[0] as $permiso) :
							if ($permiso['submoduloid'] == ModulosHelper::INFORMES_MATRICULAS_ID) :
						?>						
								<li class="<?php if ($submenu == ModulosHelper::SUBMENU_INFORMES_MATRICULAS) echo 'active'; ?>">
									<a href="{{url('informes/matriculas')}}">
									<i class="fa fa-file-text-o"></i>
									Matrículas </a>
								</li>
						<?php
							    break;
							endif;
						endforeach;
						?>
					</ul>
				</li>
			<?php
				break; 
				}
			}
			?>
			<?php 
			foreach (Session::get('permisos')[0] as $permiso) {
				if ($permiso['submoduloid'] == ModulosHelper::GENERAL_ID or $permiso['submoduloid'] == ModulosHelper::INSTITUTOS_ID){
			?>
				<li <?php if ($menu == ModulosHelper::MENU_CONFIGURACIONES) echo "class='start active open'"; ?>>
					<a href="javascript:;">
					<i class="fa fa-gears"></i>
					<span class="title">
					Configuraciones </span>
					<span class="arrow <?php if ($menu == ModulosHelper::MENU_CONFIGURACIONES) echo 'open'; ?>">
					</span>
					</a>
					<ul class="sub-menu">
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::GENERAL_ID){
						?>
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_CONFIG_GENERAL) echo 'active'; ?>">
								<a href="#">
								General </a>
							</li>
						<?php
							break; 
							}
						}
						?>
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::INSTITUTOS_ID){
						?>						
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_CONFIG_INSTITUTOS) echo 'active'; ?>">
								<a href="#">
								Institutos </a>
							</li>
						<?php
							break; 
							}
						}
						?>
					</ul>
				</li>
			<?php
				break; 
				}
			}
			?>
			<?php 
			foreach (Session::get('permisos')[0] as $permiso) {
				if ($permiso['submoduloid'] == ModulosHelper::USUARIOS_ID or $permiso['submoduloid'] == ModulosHelper::PERFILES_ID){
			?>
				<li <?php if ($menu == ModulosHelper::MENU_SEGURIDAD) echo "class='start active open'"; ?>>
					<a href="javascript:;">
					<i class="fa fa-lock"></i>
					<span class="title">
					Seguridad </span>
					<span class="arrow <?php if ($menu == ModulosHelper::MENU_SEGURIDAD) echo 'open'; ?>">
					</span>
					</a>
					<ul class="sub-menu">
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::USUARIOS_ID){
						?>
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_SEGURIDAD_USUARIOS) echo 'active'; ?>">
								<a href="{{url('usuarios/listado')}}">
								<i class="fa fa-user"></i> Usuarios </a>
							</li>
						<?php
							break; 
							}
						}
						?>
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::PERFILES_ID){
						?>
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_SEGURIDAD_PERFILES) echo 'active'; ?>">
								<a href="{{url('perfiles/listado')}}"> 
								<i class="fa fa-group"></i> Perfiles </a>
							</li>
						<?php
							break; 
							}
						}
						?>
					</ul>				

				</li>
			<?php
				break; 
				}
			}
			?>
		</ul>
		<!-- END SIDEBAR MENU1 -->
		<!-- BEGIN RESPONSIVE MENU FOR HORIZONTAL & SIDEBAR MENU -->
		<ul class="page-sidebar-menu visible-sm visible-xs" data-slide-speed="200" data-auto-scroll="true">
				<li <?php if ($menu == ModulosHelper::MENU_DASHBOARD) echo "class='start active open'"; ?> >
					<a href="{{url('dashboard')}}">
					<i class="fa fa-dashboard"></i>
					<span class="title"> Panel de Control</span>
					<span class="arrow">
					</span>
					</a>
				</li>	


			<?php 
			foreach (Session::get('permisos')[0] as $permiso) {
				if ($permiso['submoduloid'] == ModulosHelper::ALUMNOS_ID or $permiso['submoduloid'] == ModulosHelper::DOCENTES_ID or $permiso['submoduloid'] == ModulosHelper::ASIGNAR_DOCENTES_ID or $permiso['submoduloid'] == ModulosHelper::BOLETINES_ID or $permiso['submoduloid'] == ModulosHelper::INSCRIPCIONES_ID or $permiso['submoduloid'] == ModulosHelper::ASISTENCIA_ID){
			?>
				<li <?php if ($menu == ModulosHelper::MENU_GESTION_ACADEMICA) echo "class='start active open'"; ?> >
					<a href="javascript:;">
					<i class="fa fa-graduation-cap"></i>
					<span class="title">
					Gestión Académica</span>
					<span class="selected ">
					</span>
					<span class="arrow <?php if ($menu == ModulosHelper::MENU_GESTION_ACADEMICA) echo 'open'; ?>">
					</span>
					</a>
					<ul class="sub-menu">
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::ALUMNOS_ID){
						?>
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_ALUMNOS) echo 'active'; ?>">
								<a href="{{url('alumnos/listado')}}">
								<i class="fa fa-users"></i>
								 Alumnos</a>
							</li>
						<?php
							break; 
							}
						}
						?>
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::DOCENTES_ID){
						?>					
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_DOCENTES) echo 'active'; ?>">
								<a href="{{url('docentes/listado')}}"><i class="fa fa-user"></i> Docentes</a>
							</li>
						<?php
							break; 
							}
						}
						?>
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::ASIGNAR_DOCENTES_ID){
						?>					
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_ASIGNAR_DOCENTES) echo 'active'; ?>">
								<a href="{{url('asignardocente/asignadocente')}}"><i class="fa fa-user"></i> Asignar Docentes</a>
							</li>
						<?php
							break; 
							}
						}
						?>
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::ASISTENCIA_ID){
						?>					
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_ASISTENCIA) echo 'active'; ?>">
								<a href="{{url('asistencias/listado')}}"><i class="fa fa-edit"></i> Asistencias</a>
							</li>
						<?php
							break; 
							}
						}
						?>
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::BOLETINES_ID){
						?>
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_BOLETINES) echo 'active'; ?>">
								<a href="#"><i class="fa fa-files-o"></i> Boletines</a>
								<!-- SI $submenu2 existe hay que agregar "block" al style sino "none" para que el submenu2 quede abierto -->
								<ul class="sub-menu" style="display: <?php if (isset($submenu2)){ if ($submenu2==ModulosHelper::SUBMENU_2_EXAMENPARCIAL || $submenu2==ModulosHelper::SUBMENU_2_EXAMENFINAL) {echo 'block';}else{echo 'none';} } ?>;">
									<li class="<?php if (isset($submenu2)){ if ($submenu2==ModulosHelper::SUBMENU_2_EXAMENPARCIAL) echo 'active'; } ?>">
										<a href="{{url('regularidades/listado')}}"><i class="fa fa-file-text"></i> Examen Parcial</a>
									</li>
									<li class="<?php if (isset($submenu2)){ if ($submenu2==ModulosHelper::SUBMENU_2_EXAMENFINAL) echo 'active'; } ?>">
										<a href="{{url('examenfinal/listado')}}"><i class="fa fa-file-text"></i> Examen Final</a>
									</li>
								</ul>
							</li>
						<?php
							break; 
							}
						}
						?>
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::INSCRIPCIONES_ID){
						?>
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_INSCRIPCIONES) echo 'active'; ?>">
								<a href="{{url('inscripcionfinal')}}">
								<i class="fa fa-edit"></i>	Inscripción Finales</a>
							</li>
						<?php
							break; 
							}
						}
						?>
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::INSCRIPCIONES_MATERIAS_ID){
						?>
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_INSCRIPCIONES_MATERIAS) echo 'active'; ?>">
								<a href="{{url('inscripcionmaterias')}}">
								<i class="fa fa-edit"></i>	Inscripción Materias</a>
							</li>
						<?php
							break; 
							}
						}
						?>												
					</ul>
				</li>
			<?php
				break; 
				}
			}
			?>
			<!-- LA CLASE class="start active open" COLOREA EL MENU ACTIVO -->
			<?php 
			foreach (Session::get('permisos')[0] as $permiso) {
				if ($permiso['submoduloid'] == ModulosHelper::ORGANIZACIONES_ID or $permiso['submoduloid'] == ModulosHelper::CALENDARIOS_ID or $permiso['submoduloid'] == ModulosHelper::CARRERAS_ID or $permiso['submoduloid'] == ModulosHelper::MATERIAS_ID or $permiso['submoduloid'] == ModulosHelper::PLANESTUDIOS_ID or $permiso['submoduloid'] == ModulosHelper::ADMINISTRACION_ID){
			?>			
				<li <?php if ($menu == ModulosHelper::MENU_GESTION_ADMINISTRATIVA) echo "class='start active open'"; ?>>
					<a href="javascript:;">
					<i class="fa fa-book"></i>
					<span class="title">
					Gestión Administrativa </span>
					<!-- AGREGAR LA CLASE "OPEN" PARA EL ARROW  -->	
					<span class="arrow <?php if ($menu == ModulosHelper::MENU_GESTION_ADMINISTRATIVA) echo 'open'; ?>">
					</span>
					</a>
					<ul class="sub-menu">
						<!-- AGREGAR class="active" PARA COLOREAR EL SUBMENU -->
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::ORGANIZACIONES_ID){
						?>
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_ORGANIZACIONES) echo 'active'; ?>">
								<a href="{{url('organizacions/listado')}}">
								<i class="fa fa-university"></i>
								<span class="title">
								Organizaciones </span>
								</a>
							</li>
						<?php
							break; 
							}
						}
						?>
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::CALENDARIOS_ID){
						?>
							<li>
								<a href="javascript:;">
								<i class="fa fa-calendar"></i> Calendarios <span class="arrow <?php if ($submenu == ModulosHelper::SUBMENU_CALENDARIOS) echo 'open'; ?>"></span>
								</a>
								<!-- SI $submenu2 existe hay que agregar "block" al style sino "none" para que el submenu2 quede abierto -->
								<ul class="sub-menu" style="display: <?php if (isset($submenu2)){ if ($submenu2==ModulosHelper::SUBMENU_2_CICLOS || $submenu2==ModulosHelper::SUBMENU_2_FERIADOS) {echo 'block';}else{echo 'none';} } ?>;">
									<li class="<?php if (isset($submenu2)){ if ($submenu2==ModulosHelper::SUBMENU_2_CICLOS) echo 'active'; } ?>">
										<a href="{{url('ciclolectivo/listado')}}"><i class="fa fa-calendar"></i> Ciclo Lectivo</a>
									</li>
									<li class="<?php if (isset($submenu2)){ if ($submenu2==ModulosHelper::SUBMENU_2_FERIADOS) echo 'active'; } ?>">
										<a href="{{url('feriados/listado')}}"><i class="fa fa-calendar-o"></i> Feriados</a>
									</li>
									<li class="<?php if (isset($submenu2)){ if ($submenu2==ModulosHelper::SUBMENU_2_MESAEXAMENES) echo 'active'; } ?>">
										<a href="{{url('mesaexamenes/listado')}}"><i class="fa fa-calendar"></i> Mesa de Examenes</a>
									</li>
								</ul>
							</li>
						<?php
							break; 
							}
						}
						?>
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::CARRERAS_ID){
						?>
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_CARRERAS) echo 'active'; ?>">
								<a href="{{url('carreras/listado')}}"><i class="fa fa-files-o"></i> Carreras</a>
							</li>
						<?php
							break; 
							}
						}
						?>
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::MATERIAS_ID){
						?>
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_MATERIAS) echo 'active'; ?>">
								<a href="{{url('materias/listado')}}"><i class="fa fa-folder-open"></i> Materias</a>
							</li>
						<?php
							break; 
							}
						}
						?>
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::PLANESTUDIOS_ID){
						?>
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_PLAN_ESTUDIOS) echo 'active'; ?>">
								<a href="#"><i class="fa fa-file-text"></i> Plan de Estudios</a>
							</li>
						<?php
							break; 
							}
						}
						?>
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::CORRELATIVIDADES_ID){
						?>
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_CORRELATIVIDADES) echo 'active'; ?>">
								<a href="{{url('correlatividades/listado')}}">
								<i class="fa fa-university"></i>
								<span class="title">
								Correlatividades </span>
								</a>
							</li>
						<?php
							break; 
							}
						}
						?>
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::ADMINISTRACION_ID){
						?>
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_ADMINISTRACION) echo 'active'; ?>">
								<a href="#"><i class="fa fa-adn"></i> Administración</a>
							</li>
						<?php
							break; 
							}
						}
						?>
					</ul>
				</li>
			<?php
				break; 
				}
			}
			?>
			<?php 
			foreach (Session::get('permisos')[0] as $permiso) {
				if ($permiso['submoduloid'] == ModulosHelper::GESTIONMATRICULAS_ID or $permiso['submoduloid'] == ModulosHelper::PAGOMATRICULAS_ID or $permiso['submoduloid'] == ModulosHelper::BECAS_ID or $permiso['submoduloid'] == ModulosHelper::CAJACHICA_ID or $permiso['submoduloid'] == ModulosHelper::PAGOCUOTAS_ID){
			?>
				<li <?php if ($menu == ModulosHelper::MENU_GESTION_CONTABLE) echo "class='start active open'"; ?>>
					<a href="javascript:;">
					<i class="fa fa-dollar"></i>
					<span class="title">
					Gestión Contable </span>
					<span class="arrow <?php if ($menu == ModulosHelper::MENU_GESTION_CONTABLE) echo 'open'; ?>">
					</span>
					</a>
					<ul class="sub-menu">
						<!-- CONTRATOS -->
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::CONTRATOS_ID){
						?>						
							<li>
								<a href="javascript:;">
								<i class="fa fa-file-text"></i> Contratos <span class="arrow <?php if ($submenu == ModulosHelper::SUBMENU_CONTRATOS) echo 'open'; ?>"></span>
								</a>
								<!-- SI $submenu2 existe hay que agregar "block" al style sino "none" para que el submenu2 quede abierto -->
								<ul class="sub-menu" style="display: <?php if (isset($submenu2)){ if ($submenu2==ModulosHelper::SUBMENU_2_EDICION_CONTRATOS || $submenu2==ModulosHelper::SUBMENU_2_IMPRESION_CONTRATOS) {echo 'block';}else{echo 'none';} } ?>;">
									<li class="<?php if (isset($submenu2)){ if ($submenu2==ModulosHelper::SUBMENU_2_EDICION_CONTRATOS) echo 'active'; } ?>">
										<a href="{{url('tiposcontratos/editar')}}"><i class="fa fa-edit"></i> Edición de Contratos</a>
									</li>
									<li class="<?php if (isset($submenu2)){ if ($submenu2==ModulosHelper::SUBMENU_2_IMPRESION_CONTRATOS) echo 'active'; } ?>">
										<a href="{{url('contratos/imprimir')}}"><i class="fa fa-print"></i> Imprimir</a>
									</li>
								</ul>
							</li>
						<?php
							break; 
							}
						}
						?>							
						<!-- FIN CONTRATOS -->					
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::GESTIONMATRICULAS_ID){
						?>
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_GESTION_MATRICULA) echo 'active'; ?>">
								<a href="{{url('matriculas/gestion')}}">
								<i class="fa fa-copy"></i> Gestión de Matrículas</a>
							</li>
						<?php
							break; 
							}
						}
						?>
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::PAGOMATRICULAS_ID){
						?>
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_PAGO_MATRICULA) echo 'active'; ?>">
								<a href="{{url('matriculas/listado')}}">
								<i class="fa fa-file-excel-o"></i> Pago de Matrículas</a>
							</li>
						<?php
							break; 
							}
						}
						?>
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::PAGOCUOTAS_ID){
						?>
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_PAGO_CUOTAS) echo 'active'; ?>">
								<a href="{{url('cuotas/listado')}}">
								<i class="fa fa-file-excel-o"></i> Pago de Cuotas</a>
							</li>
						<?php
							break; 
							}
						}
						?>
						
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::CAJACHICA_ID){
						?>
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_CAJA_CHICA) echo 'active'; ?>">
								<a href="{{url('cajachica/listado')}}">
								<i class="fa fa-file-excel-o"></i> Caja Chica</a>
							</li>
						<?php
							break; 
							}
						}
						?>						
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::BECAS_ID){
						?>
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_BECAS) echo 'active'; ?>">
								<a href="{{url('becas/gestionar')}}">
								<i class="fa fa-file-excel-o"></i> Becas</a>
							</li>
						<?php
							break; 
							}
						}
						?>						
					</ul>
				</li>
			<?php
				break; 
				}
			}
			?>
			<?php 
			foreach (Session::get('permisos')[0] as $permiso) {
				if ($permiso['submoduloid'] == ModulosHelper::INFORMES_ALUMNOS_ID or $permiso['submoduloid'] == ModulosHelper::INFORMES_DOCENTES_ID){
			?>
				<li <?php if ($menu == ModulosHelper::MENU_INFORMES) echo "class='start active open'"; ?>>
					<a href="javascript:;">
					<i class="fa fa-copy"></i>
					<span class="title">
					Informes </span>
					<span class="arrow <?php if ($menu == ModulosHelper::MENU_INFORMES) echo 'open'; ?>">
					</span>
					</a>
					<ul class="sub-menu">
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::INFORMES_ALUMNOS_ID){
						?>
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_INFORMES_ALUMNOS) echo 'active'; ?>">
								<a href="{{url('informes/alumnos')}}">
								<i class="fa fa-file-text-o"></i>
								Alumnos </a>
							</li>
						<?php
							break; 
							}
						}
						?>
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::INFORMES_DOCENTES_ID){
						?>						
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_INFORMES_DOCENTES) echo 'active'; ?>">
								<a href="{{url('informes/docentes')}}">
								<i class="fa fa-file-text-o"></i>
								Docentes </a>
							</li>
						<?php
							break; 
							}
						}
						?>

						<?php
						foreach (Session::get('permisos')[0] as $permiso) :
							if ($permiso['submoduloid'] == ModulosHelper::INFORMES_MATRICULAS_ID) :
						?>						
								<li class="<?php if ($submenu == ModulosHelper::SUBMENU_INFORMES_MATRICULAS) echo 'active'; ?>">
									<a href="{{url('informes/matriculas')}}">
									<i class="fa fa-file-text-o"></i>
									Matrículas </a>
								</li>
						<?php
							    break;
							endif;
						endforeach;
						?>
					</ul>
				</li>
			<?php
				break; 
				}
			}
			?>
			<?php 
			foreach (Session::get('permisos')[0] as $permiso) {
				if ($permiso['submoduloid'] == ModulosHelper::GENERAL_ID or $permiso['submoduloid'] == ModulosHelper::INSTITUTOS_ID){
			?>
				<li <?php if ($menu == ModulosHelper::MENU_CONFIGURACIONES) echo "class='start active open'"; ?>>
					<a href="javascript:;">
					<i class="fa fa-gears"></i>
					<span class="title">
					Configuraciones </span>
					<span class="arrow <?php if ($menu == ModulosHelper::MENU_CONFIGURACIONES) echo 'open'; ?>">
					</span>
					</a>
					<ul class="sub-menu">
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::GENERAL_ID){
						?>
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_CONFIG_GENERAL) echo 'active'; ?>">
								<a href="#">
								General </a>
							</li>
						<?php
							break; 
							}
						}
						?>
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::INSTITUTOS_ID){
						?>						
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_CONFIG_INSTITUTOS) echo 'active'; ?>">
								<a href="#">
								Institutos </a>
							</li>
						<?php
							break; 
							}
						}
						?>
					</ul>
				</li>
			<?php
				break; 
				}
			}
			?>
			<?php 
			foreach (Session::get('permisos')[0] as $permiso) {
				if ($permiso['submoduloid'] == ModulosHelper::USUARIOS_ID or $permiso['submoduloid'] == ModulosHelper::PERFILES_ID){
			?>
				<li <?php if ($menu == ModulosHelper::MENU_SEGURIDAD) echo "class='start active open'"; ?>>
					<a href="javascript:;">
					<i class="fa fa-lock"></i>
					<span class="title">
					Seguridad </span>
					<span class="arrow <?php if ($menu == ModulosHelper::MENU_SEGURIDAD) echo 'open'; ?>">
					</span>
					</a>
					<ul class="sub-menu">
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::USUARIOS_ID){
						?>
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_SEGURIDAD_USUARIOS) echo 'active'; ?>">
								<a href="{{url('usuarios/listado')}}">
								<i class="fa fa-user"></i> Usuarios </a>
							</li>
						<?php
							break; 
							}
						}
						?>
						<?php 
						foreach (Session::get('permisos')[0] as $permiso) {
							if ($permiso['submoduloid'] == ModulosHelper::PERFILES_ID){
						?>
							<li class="<?php if ($submenu == ModulosHelper::SUBMENU_SEGURIDAD_PERFILES) echo 'active'; ?>">
								<a href="{{url('perfiles/listado')}}"> 
								<i class="fa fa-group"></i> Perfiles </a>
							</li>
						<?php
							break; 
							}
						}
						?>
					</ul>				

				</li>
			<?php
				break; 
				}
			}
			?>
		</ul>
		<!-- END RESPONSIVE MENU FOR HORIZONTAL & SIDEBAR MENU -->
	</div>
	<!-- END SIDEBAR -->
