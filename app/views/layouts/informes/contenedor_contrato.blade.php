<!DOCTYPE html>
<html lang="es">
	<head>
		<title>ISS - Contratos</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	</head>
	@section('estilo')
		<!-- ESTILO PERSONALIZADO -->
	@show	
	<body>
   		<center>
    		<img  width='700' height='96' src="<?php echo $_SERVER["DOCUMENT_ROOT"].'/assets/global/img/membretecontrato.png'; ?>">
   		</center>

		<section>
			@yield('cuerpo')
		</section>

		<!--footer>
			<center>Instituto Superior de Sanidad "Prof. Ramón Carrillo" - Formosa</center>
		</footer -->
	</body>
</html>