<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>Sistema de Gestión Académica</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="{{url('assets/global/plugins/font-awesome/css/font-google.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{url('assets/global/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{url('assets/global/plugins/simple-line-icons/simple-line-icons.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{url('assets/global/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{url('assets/global/plugins/uniform/css/uniform.default.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{url('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link href="{{url('assets/admin/pages/css/login-soft.css')}}" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME STYLES -->
<link href="{{url('assets/global/css/components.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{url('assets/global/css/plugins.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{url('assets/admin/layout/css/layout.css')}}" rel="stylesheet" type="text/css"/>
<link id="style_color" href="{{url('assets/admin/layout/css/themes/default.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{url('assets/admin/layout/css/custom.css')}}" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="{{url('favicon.ico')}}"/>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="login">
<!-- BEGIN LOGO -->
<div class="logo">
	<a href="{{url('/')}}">
	<img src="{{url('assets/admin/layout/img/logo-big2.png')}}" alt=""/>
	</a>
</div>
<!-- END LOGO -->
<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<div class="menu-toggler sidebar-toggler">
</div>
<!-- END SIDEBAR TOGGLER BUTTON -->
<!-- BEGIN LOGIN -->
<div class="content">
	<!-- BEGIN LOGIN FORM -->
	{{ Form::open(array('url'=>'login', 'class'=>'login-form', 'id'=>'FormLogin'))}}
		<h3 class="form-title">Ingreso al sistema</h3>
		@if (Session::has('msgerror'))
			<div class="note note-danger">
				<center>
					<span>{{ Session::get('msgerror') }}</span>
				</center>
			</div>
		@endif
		@if (Session::has('msgok'))
			<div class="note note-info">
				<center>
					<span>{{ Session::get('msgok') }}</span>
				</center>
			</div>
		@endif			
		<div class="form-group">
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
			<label class="control-label visible-ie8 visible-ie9">Usuario</label>
			<div class="input-icon">
				<i class="fa fa-user"></i>
				<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="usuario" name="usuario"/>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">Contraseña</label>
			<div class="input-icon">
				<i class="fa fa-lock"></i>
				<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="contraseña" name="password"/>
			</div>
		</div>
		<div class="form-actions">
			<label class="checkbox">
			{{ Form::checkbox('rememberme', true) }} Recordarme </label>
			<button type="submit" class="btn blue pull-right">
			Ingresar <i class="m-icon-swapright m-icon-white"></i>
			</button>
		</div>
		<div class="forget-password">
			<h4>¿Olvidaste tu contraseña?</h4>
			<p>
				no te preocupes, haz click <a href="javascript:;" id="forget-password">
				por aca </a>
				para recuperar tu contraseña.
			</p>
		</div>
	{{ Form::close() }}
	<!-- END LOGIN FORM -->
	<!-- BEGIN FORGOT PASSWORD FORM -->
	{{ Form::open(array('url'=>'recuperaPassword', 'class'=>'forget-form', 'id'=>'FormRecuperarPassword'))}}
		<h3>¿Olvidaste tu contraseña?</h3>
		<p>
			 Ingresá tu e-mail para recuperar tu contraseña.
		</p>
		<div class="form-group">
			<div class="input-icon">
				<i class="fa fa-envelope"></i>
				<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="correo" name="email"/>
			</div>
		</div>
		<div class="form-actions">
			<button type="button" id="back-btn" class="btn">
			<i class="m-icon-swapleft"></i> Atrás </button>
			<button type="submit" class="btn blue pull-right">
			Enviar <i class="m-icon-swapright m-icon-white"></i>
			</button>
		</div>
	{{ Form::close() }}
	<!-- END FORGOT PASSWORD FORM -->
</div>
<!-- END LOGIN -->
<!-- BEGIN COPYRIGHT -->
<div class="copyright">
	 2014 - <?=date('Y')?>  Sistema de Gestión Académica.
</div>
<!-- END COPYRIGHT -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="{{url('assets/global/plugins/respond.min.js')}}"></script>
<script src="{{url('assets/global/plugins/excanvas.min.js')}}"></script> 
<![endif]-->
<script src="{{url('assets/global/plugins/jquery-1.11.0.min.js')}}" type="text/javascript"></script>
<script src="{{url('assets/global/plugins/jquery-migrate-1.2.1.min.js')}}" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="{{url('assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js')}}" type="text/javascript"></script>
<script src="{{url('assets/global/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{url('assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js')}}" type="text/javascript"></script>
<script src="{{url('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
<script src="{{url('assets/global/plugins/jquery.blockui.min.js')}}" type="text/javascript"></script>
<script src="{{url('assets/global/plugins/jquery.cokie.min.js')}}" type="text/javascript"></script>
<script src="{{url('assets/global/plugins/uniform/jquery.uniform.min.js')}}" type="text/javascript"></script>
<script src="{{url('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{url('assets/global/plugins/jquery-validation/js/jquery.validate.min.js')}}" type="text/javascript"></script>
<script src="{{url('assets/global/plugins/backstretch/jquery.backstretch.min.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{url('assets/global/scripts/metronic.js')}}" type="text/javascript"></script>
<script src="{{url('assets/admin/layout/scripts/layout.js')}}" type="text/javascript"></script>
<script src="{{url('assets/admin/layout/scripts/quick-sidebar.js')}}" type="text/javascript"></script>
<script src="{{url('assets/admin/pages/scripts/login-soft.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
		jQuery(document).ready(function() {     
		  	Metronic.init(); // init metronic core components
			Layout.init(); // init current layout
			QuickSidebar.init() // init quick sidebar
		  	Login.init();

	       	// init background slide images
	       	$.backstretch([
		        '{{url("assets/admin/pages/media/bg/siges1.jpg")}}',
    		    "{{url('assets/admin/pages/media/bg/siges2.jpg')}}",
    		    "{{url('assets/admin/pages/media/bg/siges3.jpg')}}",
    		    "{{url('assets/admin/pages/media/bg/siges4.jpg')}}",
    		    "{{url('assets/admin/pages/media/bg/siges5.jpg')}}",
    		    "{{url('assets/admin/pages/media/bg/siges6.jpg')}}",
    		    "{{url('assets/admin/pages/media/bg/siges7.jpg')}}",
    		    "{{url('assets/admin/pages/media/bg/siges8.jpg')}}"
		        ], {
		          fade: 1000,
		          duration: 8000
		    	}
		    );
		});
	</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>