	<!-- BEGIN RESPONSIVE MENU TOGGLER -->
	<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
	</a>
	<!-- END RESPONSIVE MENU TOGGLER -->
	<!-- BEGIN TOP NAVIGATION MENU -->
	<div class="top-menu">
		<ul class="nav navbar-nav pull-right">
			<!-- BEGIN NOTIFICATION DROPDOWN -->
			<li class="dropdown dropdown-user">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
				<img alt="" class="img-circle" src="{{url('assets/admin/layout/img/avatar_small.png')}}"/>
				<span class="username">
				{{ Auth::user()->usuario }} </span>
				<i class="fa fa-angle-down"></i>
				</a>
				<ul class="dropdown-menu">
					<!--
					<li>
						<a href="#">
						<i class="icon-user"></i> Mi Perfil </a>
					</li>
					<li>
						<a href="#">
						<i class="icon-calendar"></i> Mi Calendario </a>
					</li>
					<li>
						<a href="#">
						<i class="icon-envelope-open"></i> Mi Bandeja <span class="badge badge-danger">
						3 </span>
						</a>
					</li>
					<li>
						<a href="#">
						<i class="icon-rocket"></i> Mis Tareas <span class="badge badge-success">
						7 </span>
						</a>
					</li>
					<li class="divider">
					</li> -->
					<li>
						<a href="#">
						<i class="icon-lock"></i> Bloquear Pantalla </a>
					</li>
					<li>
						<a href="{{url('logout')}}">
						<i class="icon-key"></i> Salir </a>
					</li>
				</ul>
			</li>
			<!-- END USER LOGIN DROPDOWN -->
		</ul>
	</div>
	<!-- END TOP NAVIGATION MENU -->
